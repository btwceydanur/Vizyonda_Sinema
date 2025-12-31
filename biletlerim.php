<?php
session_start();
require 'config3.php';

// 1) Giriş kontrolü yapıyoruz
if (!isset($_SESSION['kisi_id'])) {
    header('Location: giris_yap.php?hata=Biletleri görmek için önce giriş yapın.');
    exit;
}

$kisi_id = (int)$_SESSION['kisi_id'];

// 2) İptal işlemlerinden gelen mesaj/hata varsa aldık
$mesaj = isset($_GET['mesaj']) ? $_GET['mesaj'] : '';
$hata  = isset($_GET['hata'])  ? $_GET['hata']  : '';

// 3) Kullanıcının TÜM biletlerini çektim (SATILDI + IPTAL)
// DİKKAT: Koltuk için LEFT JOIN kullanıyoruz ki koltuk_id NULL olsa bile kayıt gelsin.
$sql = "
    SELECT 
        B.bilet_id,
        B.odenen_fiyat,
        B.satis_zamani,
        B.iptal_zamani,
        B.durum,
        S.seans_tarihi,
        S.seans_saati,
        F.film_adi,
        Sl.salon_adi,
        Sl.salon_id,
        I.il_adi,
        K.koltuk_kodu
    FROM Bilet B
    JOIN Seans S   ON B.seans_id  = S.seans_id
    JOIN Film F    ON S.film_id   = F.film_id
    JOIN Salon Sl  ON S.salon_id  = Sl.salon_id
    JOIN Il I      ON Sl.il_id    = I.il_id
    LEFT JOIN Koltuk K ON B.koltuk_id = K.koltuk_id
    WHERE B.kisi_id = ?
    ORDER BY S.seans_tarihi DESC, S.seans_saati DESC, B.bilet_id DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$kisi_id]);
$biletler = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4) Şu anki zamanı aldık (24 saat kuralı ve süresi geçti mi kontrolü için)
$tz    = new DateTimeZone("Europe/Istanbul");
$simdi = new DateTime("now", $tz);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Biletlerim</title>
    <link rel="stylesheet" href="biletlerim.css">
</head>
<body>
    <header>
        <h1>
            <span class="ilk_harf">V</span>İZYONDA SİNEM<span class="son_harf">A</span>
        </h1>
    </header>

    <!-- NAV MENÜ -->
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
                <a href="#">Hesap</a>
                <ul class="alt_menu">
                    <li><a href="hesap_bilgileri.php">Hesap Bilgileri</a></li>
                    <li><a href="biletlerim.php">Biletlerim</a></li>
                    <li><a href="cikis.php">Çıkış Yap</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <main>
        <section class="sayfa_ana_baslik">
            <h2><span class="ilk_harf">B</span>iletlerim</h2>
            <p>Tüm satın aldığınız biletleri görüntüleyin.</p>
        </section>
        <div class="biletlerim_alani">
            <?php if ($mesaj): ?>
                <div class="mesaj"><?= htmlspecialchars($mesaj) ?></div>
            <?php endif; ?>

            <?php if ($hata): ?>
                <div class="hata"><?= htmlspecialchars($hata) ?></div>
            <?php endif; ?>

            <?php if (empty($biletler)): ?>

                <p>Herhangi bir bilet bulunamadı.</p>
                <p><a class="geri-btn" href="ilk_orn.php">Ana sayfaya dön</a></p>

            <?php else: ?>

                <table class="bilet-tablo">
                    <thead>
                        <tr>
                            <th>Film</th>
                            <th>Şehir</th>
                            <th>Salon</th>
                            <th>Tarih</th>
                            <th>Saat</th>
                            <th>Koltuk</th>
                            <th>Ödenen Fiyat (TL)</th>
                            <th>Satış Zamanı</th>
                            <th>İptal Zamanı</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($biletler as $b): ?>
                        <?php     
                            $seansDT = new DateTime(
                                $b['seans_tarihi'] . ' ' . $b['seans_saati'],
                                $tz
                            );
                            $fark_saniye = $seansDT->getTimestamp() - $simdi->getTimestamp();
                            $fark_saat   = $fark_saniye / 3600.0;
                            $seans_gelecekte = ($fark_saniye > 0);

                            
                            if ($b['durum'] === 'IPTAL') {
                                $durum_metin = 'İptal Oldu';
                                $durum_css   = 'durum-iptal';
                            } else { 
                                if ($seans_gelecekte) {
                                    $durum_metin = 'Aktif';
                                    $durum_css   = 'durum-aktif';
                                } else {
                                    $durum_metin = 'Süresi Geçti';
                                    $durum_css   = 'durum-suresi-gecti';
                                }
                            }

                            //iptalin mümkün olup olmadığına
                            $iptal_mumkun = (
                                $b['durum'] === 'SATILDI' &&
                                $seans_gelecekte &&
                                $fark_saat > 24
                            );

                            // Koltuk kodu (iptal edilmiş ve koltuk_id NULL ise '-' göster)
                            $koltukKod = $b['koltuk_kodu'] ?? '-';

                            // İptal zamanı gösterimi
                            $iptalZamanGoster = $b['iptal_zamani'] !== null ? $b['iptal_zamani'] : '-';
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($b['film_adi']) ?></td>
                            <td><?= htmlspecialchars($b['il_adi']) ?></td>
                            <td><?= htmlspecialchars($b['salon_adi']) ?></td>
                            <td><?= htmlspecialchars($b['seans_tarihi']) ?></td>
                            <td><?= htmlspecialchars($b['seans_saati']) ?></td>
                            <td><?= htmlspecialchars($koltukKod) ?></td>
                            <td><?= htmlspecialchars(number_format($b['odenen_fiyat'], 2)) ?></td>
                            <td><?= htmlspecialchars($b['satis_zamani']) ?></td>
                            <td><?= htmlspecialchars($iptalZamanGoster) ?></td>

                            
                            <td><span class="<?= $durum_css ?>"><?= htmlspecialchars($durum_metin) ?></span></td>

                            
                            <td>
                                <?php if ($iptal_mumkun): ?>
                                    <form class="islem-form" method="post" action="bilet_iptal.php">
                                        <input type="hidden" name="bilet_id" value="<?= htmlspecialchars($b['bilet_id']) ?>">
                                        <button type="submit" class="btn-islem btn-iptal"
                                                onclick="return confirm('Bu bileti iptal etmek istediğinize emin misiniz?');">
                                            İptal Et
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <?php if ($b['durum'] === 'IPTAL'): ?>
                                        <span class="pasif">İptal edildi</span>
                                    <?php elseif (!$seans_gelecekte): ?>
                                        <span class="pasif">Süresi geçti (işlem yapılamaz)</span>
                                    <?php else: ?>
                                        <span class="pasif">Seansa 24 saatten az kaldı (işlem yapılamaz)</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <p><a class= "geri-btn" href="ilk_orn.php">Ana sayfaya dön</a></p>

            <?php endif; ?>
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
