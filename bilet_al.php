<?php
session_start();
require 'config3.php';

if (!isset($_SESSION['kisi_id'])) {
    header('Location: giris_yap.php?hata=Bilet almak için önce giriş yapın.');
    exit;
}

$film_id = isset($_GET['film_id']) ? (int)$_GET['film_id'] : 0;
if ($film_id <= 0) {
    die('Geçersiz film.');
}

$stmt = $pdo->prepare('SELECT film_adi FROM Film WHERE film_id = ?');
$stmt->execute([$film_id]);
$film = $stmt->fetch();

if (!$film) {
    die('Film bulunamadı.');
}

$step         = isset($_GET['step'])         ? (int)$_GET['step']         : 1;
$il_id        = isset($_GET['il_id'])        ? (int)$_GET['il_id']        : 0;
$seans_tarihi = isset($_GET['seans_tarihi']) ? $_GET['seans_tarihi']      : '';

if ($step === 1) {
    $sql = "
        SELECT DISTINCT I.il_id, I.il_adi
        FROM Seans S
        JOIN Salon Sl ON S.salon_id = Sl.salon_id
        JOIN Il I     ON Sl.il_id   = I.il_id
        WHERE S.film_id = ?
        ORDER BY I.il_adi
    ";
    $stmtIl = $pdo->prepare($sql);
    $stmtIl->execute([$film_id]);
    $iller = $stmtIl->fetchAll();
}

if ($step === 2) {
    if ($il_id <= 0) {
        die('Şehir seçilmedi.');
    }

    $sqlIl = "SELECT il_adi FROM Il WHERE il_id = ?";
    $stmtIlAd = $pdo->prepare($sqlIl);
    $stmtIlAd->execute([$il_id]);
    $il = $stmtIlAd->fetch();

    if (!$il) {
        die('Şehir bulunamadı.');
    }

    $sqlTarih = "
        SELECT DISTINCT S.seans_tarihi
        FROM Seans S
        JOIN Salon Sl ON S.salon_id = Sl.salon_id
        WHERE S.film_id = ?
          AND Sl.il_id  = ?
          AND S.seans_tarihi >= CURDATE()
        ORDER BY S.seans_tarihi
    ";
    $stmtTarih = $pdo->prepare($sqlTarih);
    $stmtTarih->execute([$film_id, $il_id]);
    $tarihler = $stmtTarih->fetchAll();

    $bugun = date('Y-m-d');

    $allowedDates = [];
    foreach ($tarihler as $row) {
        $allowedDates[] = $row['seans_tarihi'];
    }
}

if ($step === 3) {
    if ($il_id <= 0 || $seans_tarihi === '') {
        die('Şehir veya tarih eksik.');
    }

    $sqlIl = "SELECT il_adi FROM Il WHERE il_id = ?";
    $stmtIlAd = $pdo->prepare($sqlIl);
    $stmtIlAd->execute([$il_id]);
    $il = $stmtIlAd->fetch();

    if (!$il) {
        die('Şehir bulunamadı.');
    }

    $bugun = date('Y-m-d');

    if ($seans_tarihi === $bugun) {
        $sqlSeans = "
            SELECT 
                S.seans_id,
                S.seans_saati,
                S.baz_fiyat,
                Sl.salon_adi
            FROM Seans S
            JOIN Salon Sl ON S.salon_id = Sl.salon_id
            WHERE S.film_id      = ?
              AND S.seans_tarihi = ?
              AND Sl.il_id       = ?
              AND S.seans_saati  > CURTIME()
            ORDER BY S.seans_saati, Sl.salon_adi
        ";
        $params = [$film_id, $seans_tarihi, $il_id];
    } else {
        $sqlSeans = "
            SELECT 
                S.seans_id,
                S.seans_saati,
                S.baz_fiyat,
                Sl.salon_adi
            FROM Seans S
            JOIN Salon Sl ON S.salon_id = Sl.salon_id
            WHERE S.film_id      = ?
              AND S.seans_tarihi = ?
              AND Sl.il_id       = ?
            ORDER BY S.seans_saati, Sl.salon_adi
        ";
        $params = [$film_id, $seans_tarihi, $il_id];
    }

    $stmtSeans = $pdo->prepare($sqlSeans);
    $stmtSeans->execute($params);
    $seanslar = $stmtSeans->fetchAll();
}

if ($step === 4) {
    $seans_id = isset($_GET['seans_id']) ? (int)$_GET['seans_id'] : 0;
    if ($seans_id <= 0) {
        die('Seans seçilmedi.');
    }

    $sqlSeansDetay = "
        SELECT 
            S.seans_id,
            S.seans_tarihi,
            S.seans_saati,
            S.baz_fiyat,
            Sl.salon_id,
            Sl.salon_adi,
            I.il_adi
        FROM Seans S
        JOIN Salon Sl ON S.salon_id = Sl.salon_id
        JOIN Il I     ON Sl.il_id   = I.il_id
        WHERE S.seans_id = ?
          AND S.film_id  = ?
    ";
    $stmtSeansDetay = $pdo->prepare($sqlSeansDetay);
    $stmtSeansDetay->execute([$seans_id, $film_id]);
    $seans = $stmtSeansDetay->fetch();

    if (!$seans) {
        die('Seans bulunamadı.');
    }

    $salon_id = (int)$seans['salon_id'];

    $sqlKoltuk = "
        SELECT sira, numara, koltuk_kodu
        FROM Koltuk
        WHERE salon_id = ?
        ORDER BY sira, numara
    ";
    $stmtKoltuk = $pdo->prepare($sqlKoltuk);
    $stmtKoltuk->execute([$salon_id]);
    $koltuklar = $stmtKoltuk->fetchAll();

    $sqlDolu = "
        SELECT K.koltuk_kodu
        FROM Bilet B
        JOIN Koltuk K ON B.koltuk_id = K.koltuk_id
        WHERE B.seans_id = ?
            AND B.durum = 'SATILDI'
    ";
    $stmtDolu = $pdo->prepare($sqlDolu);
    $stmtDolu->execute([$seans_id]);
    $doluKayitlar = $stmtDolu->fetchAll();

    $doluKoltuklar = [];
    foreach ($doluKayitlar as $d) {
        $doluKoltuklar[] = $d['koltuk_kodu'];
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bilet Al - <?= htmlspecialchars($film['film_adi']) ?></title>

    <?php if ($step === 2): ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <?php endif; ?>

    <link rel="stylesheet" href="bilet_al.css">
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
                <span class="ilk_harf">B</span>ilet Alma
            </h2>
            <p>Film ve seans seçiminizi yapın.</p>
        </section>
        <div class="bilet_alma">
            <h2 class="sayfa_baslik">Bilet Al – <?= htmlspecialchars($film['film_adi']) ?></h2>
            <?php
            switch ($step) {
                case 1:
                    include 'bilet_al_step1.php';
                    break;
                case 2:
                    include 'bilet_al_step2.php';
                    break;
                case 3:
                    include 'bilet_al_step3.php';
                    break;
                case 4:
                    include 'bilet_al_step4.php';
                    break;
                default:
                    echo '<p class="uyari-kutu hata">Geçersiz adım.</p>';
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
