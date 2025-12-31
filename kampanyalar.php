<?php
session_start();
require 'config3.php'; 
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kampanyalar - Vizyonda Sinema</title>
    <link rel="stylesheet" href="kampanyalar.css">
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
		<section class="sayfa_baslik">
			<h2>
				<span class="ilk_harf">K</span>ampanyalar
			</h2>
			<p>Öğrenciler, sinema günü ve belirli seanslar için uygulanan indirimler</p>
		</section>

		<section class="kampanyalar">
			<!-- 1) Öğrenci indirimi -->
			<article class="kampanya_baslik ogrenci">
				<img src="resimler/ogrenci.png" alt="Ogrenci" class="indirim">
				<h3>Öğrenci İndirimi – %30</h3>
				<p class="kampanya_aciklama">
					Online alımda öğrenci seçimi yapıp sinema salonuna girişte ve bilet 
					satış noktalrında geçerli öğrenci kimliğini gösteren tüm ziyaretçilere 
					bilet fiyatında <strong>%30 indirim</strong> uygulanır. Bu indirim 
					haftanın her günü ve tüm seanslarda geçerlidir.
				</p>
				<p class="kampanya_not">
					Bilet fiyatına %30 indirim yapılır.
				</p>
			</article>

			<!-- 2) Çarşamba sabit fiyat -->
			<article class="kampanya_baslik carsamba">
				<img src="resimler/takvim.png" alt="Ogrenci" class="indirim">
				<h3>Çarşamba Fırsatı – 120 TL</h3>
				<p class="kampanya_aciklama">
					Haftanın <strong>Çarşamba</strong> günü, tüm filmlerde tüm seansların bilet fiyatı
					<strong>120 TL</strong> olarak sabitlenir. Öğrenci indirimi bu fiyatın üzerine eklenmez.
				</p>
				<p class="kampanya_not">
					Çarşamba günü herkes için tek fiyat: 120 TL
				</p>
			</article>

			<!-- 3) Özel seans indirimi -->
			<article class="kampanya_baslik seans">
				<img src="resimler/saat.png" alt="Ogrenci" class="indirim">
				<h3>Özel Seans İndirimi – %20 (10:00–15:00)</h3>
				<p class="kampanya_aciklama">
					Saat <strong>10:00 ile 15:00</strong> arasındaki tüm seanslarda bilet fiyatı
					<strong>%20 indirimli</strong> olarak uygulanır. Öğrenci indirimi ile birleşmez.
				</p>
				<p class="kampanya_not">
					Bilet fiyatına %20 indirim yapılır.
				</p>
			</article>
		</section>
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