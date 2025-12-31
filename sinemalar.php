<?php
session_start();
require 'config3.php'; 
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinemalar - Vizyonda Sinema</title>
	<link rel="stylesheet" href="sinemalar.css">
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
				<span class="ilk_harf">S</span>inemalar
			</h2>
			<p>Farklı şehirlerdeki sinema salonlarımızı keşfedin</p>
		</section>
		<section class="sehirler">
			<!--Ankara-->
			<article  class="sehir_bilgisi">
				<h3>Ankara</h3>
				<p class="sehir_aciklama">Şehrin merkezinde modern sinema deneyimi.</p>
				<ul class="sinema_listesi">
					<li>
						<span class="sinema_adi">Ankara Vizyonda Sinema /</span>
						<span class="salon_bilgileri">Kızılay</span>
					</li>
				</ul>
			</article>
			<!--Konya-->
			<article class="sehir_bilgisi">
				<h3>Konya</h3>
				<p class="sehir_aciklama">Geniş salonu ve aile dostu atmosferiyle öne çıkıyor.</p>
				<ul class="sinema_listesi">
					<li>
						<span class="sinema_adi">Konya Vizyonda Sinema /</span>
						<span class="salon_bilgileri">Selçuklu</span>
					</li>
				</ul>
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