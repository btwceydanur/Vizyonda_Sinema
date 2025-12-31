<?php
session_start();
require 'config3.php';

if (!isset($_SESSION['kisi_id'])) {
    header('Location: giris_yap.php?hata=Bilet almak için önce giriş yapın.');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ilk_orn.php');
    exit;
}

$kisi_id   = (int)$_SESSION['kisi_id'];

$film_id   = isset($_POST['film_id'])  ? (int)$_POST['film_id']  : 0;
$seans_id  = isset($_POST['seans_id']) ? (int)$_POST['seans_id'] : 0;
$salon_id  = isset($_POST['salon_id']) ? (int)$_POST['salon_id'] : 0;


$il_id            = isset($_POST['il_id']) ? (int)$_POST['il_id'] : 0;
$seans_tarihi_param = $_POST['seans_tarihi'] ?? '';

$koltuk_kodlari = $_POST['koltuk_kodu'] ?? [];
if (!is_array($koltuk_kodlari)) {
    $koltuk_kodlari = [];
}
$koltuk_kodlari = array_values(array_unique($koltuk_kodlari));

$hatalar = [];
$basari_mesaji = '';


if ($film_id <= 0 || $seans_id <= 0 || $salon_id <= 0) {
    $hatalar[] = 'Geçersiz seans bilgisi.';
}
if (empty($koltuk_kodlari)) {
    $hatalar[] = 'En az bir koltuk seçmelisiniz.';
}


$seans = null;
$seans_tarihi = '';
$seans_saati  = '';
$baz_fiyat    = 0.0;
$is_carsamba  = false;
$saat_kampanya_var = false;

if (empty($hatalar)) {
    $sqlSeans = "
        SELECT 
            S.seans_id,
            S.seans_tarihi,
            S.seans_saati,
            S.baz_fiyat,
            Sl.salon_id,
            Sl.salon_adi,
            I.il_adi,
            F.film_adi
        FROM Seans S
        JOIN Salon Sl ON S.salon_id = Sl.salon_id
        JOIN Il I     ON Sl.il_id   = I.il_id
        JOIN Film F   ON S.film_id  = F.film_id
        WHERE S.seans_id = ? 
          AND S.film_id  = ? 
          AND Sl.salon_id = ?
    ";
    $stmt = $pdo->prepare($sqlSeans);
    $stmt->execute([$seans_id, $film_id, $salon_id]);
    $seans = $stmt->fetch();

    if (!$seans) {
        $hatalar[] = 'Seans bilgisi bulunamadı.';
    } else {
        $seans_tarihi = $seans['seans_tarihi'];
        $seans_saati  = $seans['seans_saati'];
        $baz_fiyat    = (float)$seans['baz_fiyat'];

        
        if ($seans_tarihi_param === '') {
            $seans_tarihi_param = $seans_tarihi;
        }

        $gun_no = date('N', strtotime($seans_tarihi)); // 1= Pazartesi, 3= Çarşamba
        $is_carsamba = ($gun_no == 3);

        $saat_kampanya_var = ($seans_saati >= '10:00:00' && $seans_saati <= '15:00:00');
    }
}


$koltukHarita = [];
if (empty($hatalar) && !empty($koltuk_kodlari)) {
    $placeholders = implode(',', array_fill(0, count($koltuk_kodlari), '?'));
    $sqlKoltuk = "
        SELECT koltuk_id, koltuk_kodu
        FROM Koltuk
        WHERE salon_id = ?
          AND koltuk_kodu IN ($placeholders)
    ";
    $params = array_merge([$salon_id], $koltuk_kodlari);
    $stmtK = $pdo->prepare($sqlKoltuk);
    $stmtK->execute($params);
    $rows = $stmtK->fetchAll();

    foreach ($rows as $r) {
        $koltukHarita[$r['koltuk_kodu']] = (int)$r['koltuk_id'];
    }

    foreach ($koltuk_kodlari as $kod) {
        if (!isset($koltukHarita[$kod])) {
            $hatalar[] = "$kod koltuğu bu salonda bulunamadı.";
        }
    }
}


$bilet_tipleri = $_POST['bilet_tip'] ?? [];
$odeme_tipi    = $_POST['odeme_tipi'] ?? '';
$kart_no       = trim($_POST['kart_no']   ?? '');
$kart_isim     = trim($_POST['kart_isim'] ?? '');

$odeme_modu = isset($_POST['odeme_submit']);

$bilet_detaylari = [];
$toplam_tutar = 0.0;


if ($seans && empty($hatalar)) {
    foreach ($koltuk_kodlari as $kod) {
        $detay = [
            'tip'      => null,
            'kampanya' => '',
            'fiyat'    => null
        ];

        if ($is_carsamba) {
            $detay['tip']      = 'carsamba';
            $detay['kampanya'] = 'Çarşamba kampanyası: Tüm biletler 120 TL (diğer kampanyalar geçerli değil)';
            $detay['fiyat']    = 120.0;
        } else {
            $tip = $bilet_tipleri[$kod] ?? 'tam';
            $detay['tip'] = $tip;

            if ($tip === 'ogrenci') {
                $detay['kampanya'] = 'Öğrenci indirimi (%30)';
                $detay['fiyat']    = round($baz_fiyat * 0.7, 2);
            } elseif ($tip === 'tam') {
                if ($saat_kampanya_var) {
                    $detay['kampanya'] = 'Özel seans indirimi (%20)';
                    $detay['fiyat']    = round($baz_fiyat * 0.8, 2);
                } else {
                    $detay['kampanya'] = 'Kampanya yok';
                    $detay['fiyat']    = round($baz_fiyat, 2);
                }
            }
        }

        if ($detay['fiyat'] !== null) {
            $toplam_tutar += $detay['fiyat'];
        }

        $bilet_detaylari[$kod] = $detay;
    }
}


if ($odeme_modu && empty($hatalar) && $seans) {

    if (!$is_carsamba) {
        foreach ($koltuk_kodlari as $kod) {
            if (!isset($bilet_tipleri[$kod]) || !in_array($bilet_tipleri[$kod], ['tam', 'ogrenci'], true)) {
                $hatalar[] = "$kod koltuğu için bilet tipi seçilmelidir.";
            }
        }
    }

    if ($odeme_tipi !== 'nakit' && $odeme_tipi !== 'kart') {
        $hatalar[] = 'Ödeme tipi (Nakit / Kart) seçilmelidir.';
    }

    if ($odeme_tipi === 'kart') {
        if ($kart_no === '' || $kart_isim === '') {
            $hatalar[] = 'Kart numarası ve kart üzerindeki isim boş bırakılamaz.';
        } elseif ($kart_no !== '1234') {
            $hatalar[] = 'Kart numarası geçersiz. (Test için 1234 olmalı)';
        }
    }

    foreach ($koltuk_kodlari as $kod) {
        if (!isset($bilet_detaylari[$kod]['fiyat']) || $bilet_detaylari[$kod]['fiyat'] === null) {
            $hatalar[] = "$kod koltuğu için fiyat hesaplanamadı.";
        }
    }

    
    if (empty($hatalar)) {
        $placeholders = implode(',', array_fill(0, count($koltuk_kodlari), '?'));
        $sqlDolu = "
            SELECT K.koltuk_kodu
            FROM Bilet B
            JOIN Koltuk K ON B.koltuk_id = K.koltuk_id
            WHERE B.seans_id = ?
              AND K.koltuk_kodu IN ($placeholders)
              AND B.durum = 'SATILDI'
        ";
        $params = array_merge([$seans_id], $koltuk_kodlari);
        $stmtD = $pdo->prepare($sqlDolu);
        $stmtD->execute($params);
        $doluSon = $stmtD->fetchAll();

        if (!empty($doluSon)) {
            $alindilar = array_column($doluSon, 'koltuk_kodu');
            $hatalar[] = 'Şu koltuklar bu sırada başka bir kullanıcı tarafından alınmış: ' 
                       . implode(', ', $alindilar) 
                       . '. Lütfen geri dönüp yeniden seçim yapın.';
        }
    }

    
    if (empty($hatalar)) {
        try {
            $pdo->beginTransaction();

            $sqlInsert = "
                INSERT INTO Bilet (kisi_id, seans_id, koltuk_id, odenen_fiyat, satis_zamani)
                VALUES (?, ?, ?, ?, NOW())
            ";
            $stmtIns = $pdo->prepare($sqlInsert);

            foreach ($koltuk_kodlari as $kod) {
                $koltuk_id = $koltukHarita[$kod];
                $fiyat     = $bilet_detaylari[$kod]['fiyat'];

                $stmtIns->execute([$kisi_id, $seans_id, $koltuk_id, $fiyat]);
            }

            $pdo->commit();
            $basari_mesaji = 'Toplam ' . count($koltuk_kodlari) . ' adet bilet başarıyla alındı.';

        } catch (Exception $e) {
            $pdo->rollBack();
            $hatalar[] = 'Bilet kaydı sırasında bir hata oluştu: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bilet Onayı - <?= isset($seans['film_adi']) ? htmlspecialchars($seans['film_adi']) : '' ?></title>

    <link rel="stylesheet" href="bilet_onayla.css">
</head>
<body>
    <header>
        <h1>
            <span class="ilk_harf">V</span>İZYONDA SİNEM<span class="son_harf">A</span>
        </h1>
    </header>
    <nav class="menu">
        <ul>
            <li><a href="ilk_orn.php">Anasayfa</a></li>
            <li class="alt_menuler">
                <a href="#">Filmler</a>
                <ul class="alt_menu">
                    <li><a href="vizyondaki_filmler.php">Vizyondaki Filmler</a></li>
                    <li><a href="yakindakiler.php">Yakında</a></li>
                </ul>
            </li>
            <li><a href="sinemalar.php">Sinemalar</a></li>
            <li><a href="kampanyalar.php">Kampanyalar</a></li>
            <li class="alt_menuler">
                <a href="#" onclick="return false;">Hesap</a>
                <ul class="alt_menu">
                    <?php if (isset($_SESSION['kisi_id'])): ?>
                        <li><a href="hesap_bilgileri.php">Hesap Bilgileri</a></li>
                        <li><a href="biletlerim.php">Biletlerim</a></li>
                        <li><a href="cikis.php">Çıkış Yap</a></li>
                    <?php else: ?>
                        <li><a href="giris_yap.php">Giriş Yap</a></li>
                        <li><a href="kayit_ol.php">Kayıt Ol</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </nav>
    <main>
        <section class="sayfa_ana_baslik">
            <h2>
                <span class="ilk_harf">B</span>ilet Onayla
            </h2>
            <p>Film ve seans seçiminizi yapın.</p>
        </section>
        <div class="bilet_onay_kapsayici">
            <h2 class="sayfa_baslik">Bilet Onayı</h2>

            <?php if (!empty($hatalar)): ?>
                <div class="hata">
                    <ul>
                        <?php foreach ($hatalar as $h): ?>
                            <li><?= htmlspecialchars($h) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php
            if ($basari_mesaji) {
                // Başarılı ekran girişi
                include 'bilet_onayla_success.php';
            } elseif ($seans && !empty($koltuk_kodlari)) {
                // Hata olsa bile formu tekrar göster
                include 'bilet_onayla_form.php';
            } else {
                ?>
                <p>Bir hata oluştu. Lütfen baştan deneyin.</p>
                <p><a href="ilk_orn.php">Ana sayfaya dön</a></p>
                <?php
            }
            ?>
        </div>
    </main>
    <hr>
    <footer class="footer">
        <div class="footer-icerik">
            <div class="footer-sutun">
                <h3>Vizyonda Sinema</h3>
                <p>
                    Vizyondaki ve yakında gösterime girecek filmleri,
                    kampanyaları ve sinema salonlarını tek bir yerde
                    takip edebileceğiniz ve uygun fiyatlı bilet satın
                    alabileceğiniz bir sinema sitesidir.
                </p>
            </div>

            <div class="footer-sutun">
                <h4>İletişim</h4>
                <ul>
                    <li>Mail: info@vizyondasinema.com</li>
                    <li>Tel: 0 (312) 000 00 00</li>
                    <li>Konya / Türkiye</li>
                </ul>
            </div>

            <div class="footer-sutun">
                <h4>Bağlantılar</h4>
                <ul>
                    <li><a href="ilk_orn.php">Anasayfa</a></li>
                    <li><a href="vizyondaki_filmler.php">Vizyondaki Filmler</a></li>
                    <li><a href="yakindakiler.php">Yakında</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-alt">
            <p>© 2025 Vizyonda Sinema. Tüm hakları saklıdır.</p>
        </div>
    </footer>
</body>
</html>
