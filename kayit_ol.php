<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - Vizyonda Sinema</title>
	<link rel="stylesheet" href="kayit_ol.css">
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
					<li><a href="giris_yap.php">Giriş Yap</a></li>
					<li><a href="kayit_ol.php">Kayıt Ol</a></li>
				</ul>
			</li>
		</ul>
	</nav>
	<main>
		<section class="sayfa_baslik">
			<h2>
				<span class="ilk_harf">K</span>ayıt Ekranı
			</h2>
			<p>Hesap oluşturun</p>
		</section>

		<section class="kayıt_yap">
			<div class="kayıt_ekrani">
				<h3>Kayıt Yap</h3>

				<?php if (isset($_GET['mesaj'])): ?> 
					<div class="basari_mesaji">
						<?= htmlspecialchars($_GET['mesaj']) ?>
					</div>
				<?php endif; ?>

				<?php if (isset($_GET['hata'])): ?> 
				<div class="hata_mesaji">
						<?= htmlspecialchars($_GET['hata']) ?>
					</div>
				<?php endif; ?>

				<form class="kayıt_formu" action="kayit_islem.php" method="post">

					<label>Adınız</label>
					<input type="text" name="ad" placeholder="Adınızı girin" required>

					<label>Soyad</label>
					<input type="text" name="soyad" placeholder="Soyadınızı girin" required>

					<label>E-posta</label>
					<input type="email" name="email" placeholder="E-posta adresinizi girin" required>

					<label>Telefon</label>
					<input type="text" name="telefon" placeholder="Telefon numaranızı girin" required>

					<label>Şifre</label>
					<input type="password" name="sifre" placeholder="Şifre oluşturun" required>

					<label>Şifre Tekrarı</label>
					<input type="password" name="sifre_tekrar" placeholder="Şifre (tekrar)" required>

					<button type="submit" name="kayit_submit" class="kayıt_butonu">Kayıt Ol</button>

					<p class="kayit_yonlendirme">
						Hesabınız var mı? <a href="giris_yap.php">Giriş Yap</a>
					</p>

				</form>
			</div>
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