<?php
session_start();
require 'config3.php';

if (!isset($_SESSION['kisi_id'])) {
    header('Location: giris_yap.php?hata=Lütfen önce giriş yapın.');
    exit;
}

$kisi_id = (int)$_SESSION['kisi_id'];

$stmt = $pdo->prepare('SELECT ad, soyad, email, telefon, kayit_tarihi FROM Kisi WHERE kisi_id = ?');
$stmt->execute([$kisi_id]);
$kisi = $stmt->fetch();

if (!$kisi) {
    header('Location: giris_yap.php?hata=Kullanıcı bulunamadı.');
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hesap Bilgileri</title>
    <link rel="stylesheet" href="hesap_bilgileri.css">
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
                    <li><a href="yakındakiler.php">Yakında</a></li>
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

    <main class="ana_hesap">
        <section class="sayfa_baslik">
                    <h2>
                        <span class="ilk_harf">H</span>esap Bilgileri
                    </h2>
                    <p>Hesap bilgilerinizi güncelleyebilirsiniz</p>
        </section>
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
        <section class="hesap_bilgileri">
            <section class="hesap_islemleri">
                <form action="hesap_guncelle.php" method="post" class="hesap_formu">
                    <h3>Kişisel Bilgiler</h3>
                    <label>Ad</label><br>
                    <input type="text" name="ad" value="<?= htmlspecialchars($kisi['ad']) ?>" required>

                    <label>Soyad</label><br>
                    <input type="text" name="soyad" value="<?= htmlspecialchars($kisi['soyad']) ?>" required>

                    <label>E-posta</label><br>
                    <input type="email" name="email" value="<?= htmlspecialchars($kisi['email']) ?>" required>

                    <label>Telefon</label><br>
                    <input type="text" name="telefon" value="<?= htmlspecialchars($kisi['telefon']) ?>" required>

                    <button type="submit" name="hesap_guncelle" class="hesap_buton">Bilgileri Güncelle</button>
                </form>
            </section>
            <section class="hesap_islemleri">
                <form action="sifre_guncelle.php" method="post" class="hesap_formu">
                    <h3>Şifre Değiştir</h3>

                    <label>Mevcut Şifre</label><br>
                    <input type="password" name="mevcut_sifre" required><br><br>

                    <label>Yeni Şifre</label><br>
                    <input type="password" name="yeni_sifre" required><br><br>

                    <label>Yeni Şifre (Tekrar)</label><br>
                    <input type="password" name="yeni_sifre_tekrar" required><br><br>

                    <button type="submit" name="sifre_degistir" class="hesap_buton">Şifreyi Güncelle</button>
                </form>
            </section>
        </section>
        <section class="silme_karti">
                <form action="hesap_sil.php" method="post" class="silme_uyari" onsubmit="return confirm('Hesabınızı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.');">
                <button type="submit" name="hesap_sil" class="hesap_sil_buton">Hesabı Sil</button>
                </form>
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
					<li><a href="deneme.html">Anasayfa</a></li>
					<li><a href="vizyonda.html">Vizyondaki Filmler</a></li>
					<li><a href="yakinda.html">Yakında</a></li>
				</ul>
			</div>
		</div>

		<div class="footer-alt">
			<p>© 2025 Vizyonda Sinema. Tüm hakları saklıdır.</p>
		</div>
	</footer>
</body>
</html>
