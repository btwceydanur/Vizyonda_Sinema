<?php
session_start();
require 'config3.php'; 
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yakındakiler - Vizyonda Sinema</title>
    <link rel="stylesheet" href="yakindakiler.css">
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
				<span class="ilk_harf">Y</span>akında
			</h2>
			<p>Yakında gösterimde olacak filmler:</p>
		</section>
		<section class="film_listesi">
			<!--1.Film-->
			<article class="filmler">
				<img src="resimler/arabalar_poster.png" alt="Arabalar" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>Arabalar</h3>
					<p class="film_detayları">
						1 sa 57 dk • Animasyon, Macera, Komedi, Aile
					</p>
					<p class="film_kisa_aciklama">
						Şimşek McQueen, yarışa giderken küçük bir kasabada mahsur kalır. 
						Burada dostluğun ve tevazunun değerini öğrenerek gerçek bir 
						şampiyonluğun ne olduğunu keşfeder.
					</p>

					<!-- GİZLİ DETAY KISMI -->
					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> John Lasseter</p>
						<p><strong>Yapım Yılı:</strong> 2006</p>
						<p><strong>IMDB:</strong> 7.2/10</p>
						<p>
							Şimşek McQueen, büyük Piston Kupası yarışı için Kaliforniya’ya giderken kendisini beklenmedik şekilde Radiator Springs adlı küçük bir kasabada bulur. İlk başta buradan bir an önce ayrılmak isteyen McQueen, kasabadaki dostluklar sayesinde gerçek başarı ve şampiyonluğun sadece hızdan ibaret olmadığını fark eder. Kasaba halkıyla kurduğu bağlar, yarış kariyerinden daha değerli bir yolculuğa dönüşür. Sonunda, kibir yerine tevazu ve dostluğun önemini keşfeder.
						</p>
					</div>

					<button class="detay_button" type="button">Detaylı incele</button>
				</div>
			</article>
			<!--2.Film-->
			<article class="filmler">
				<img src="resimler/baslangic_poster.png" alt="Başlangıç" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>Başlangıç</h3>
					<p class="film_detayları">
						2 sa 28 dk • Aksiyon, Bilim-Kurgu, Macera
					</p>
					<p class="film_kisa_aciklama">
						Rüyalara girip fikir çalan bir ekip, bu kez bir fikri birinin zihnine 
						yerleştirme görevi alır. Rüyaların içinde geçen çok katmanlı bir 
						zihin yolculuğu başlar.
					</p>

					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> Christopher Nolan</p>
						<p><strong>Yapım Yılı:</strong> 2010</p>
						<p><strong>IMDB:</strong> 8.8/10</p>
						<p>
							Dom Cobb ve ekibi, bir iş insanının zihnine bir fikir yerleştirmek için rüyaların derinliklerine inmeyi gerektiren tehlikeli bir görev üstlenir. Rüya içinde rüya katmanlarında ilerlerken, zamanın ve gerçeklik algısının değişmesi işleri daha da karmaşık hâle getirir. Cobb hem görevi tamamlamaya çalışır hem de geçmişindeki suçluluk ve kayıplarla yüzleşmek zorunda kalır. Bu yolculuk, zihnin sınırlarını zorlayan gerilim dolu bir maceraya dönüşür.
						</p>
					</div>

					<button class="detay_button" type="button">Detaylı incele</button>
				</div>
			</article>
			<!--3.Film-->
			<article class="filmler">
				<img src="resimler/7_kogus_poster.png" alt="7.Koğuştaki Mucize" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>7.Koğuştaki Mucize</h3>
					<p class="film_detayları">
						2 sa 12 dk • Dram
					</p>
					<p class="film_kisa_aciklama">
						Zihinsel engelli Memo, işlemediği bir suçtan idama mahkûm edilir.
						Kızı Ova ve onu sevenlerin çabası, gerçekleri ortaya çıkarmak için umut verir.
					</p>

					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> Mehmet Ada Öztekin</p>
						<p><strong>Yapım Yılı:</strong> 2019</p>
						<p>
							1983 yılında geçen hikâyede, haksız yere idamla yargılanan Memo’nun masumiyetini kanıtlamak için kızı Ova ve çevresindekiler büyük bir mücadele verir. Hapishanedeki mahkûmlar ve gardiyanlar zamanla Memo’nun saf ve iyi kalpli yapısını fark ederek ona destek olur. Gerçeklerin ortaya çıkma ihtimali, herkes için umut ışığı hâline gelir. Koğuşta yaşanan duygusal anlar, adalet arayışının dramatik bir mücadelesine dönüşür.
						</p>
					</div>
					<button class="detay_button" type="button">Detaylı incele</button>
    			</div>
			</article>
			<!--4.Film-->
			<article class="filmler">
				<img src="resimler/hukumet_poster.png" alt="Hükümet Kadını" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>Hükümet Kadını</h3>
					<p class="film_detayları">
						1 sa 45 dk • Komedi
					</p>
					<p class="film_kisa_aciklama">
						Sekiz çocuk annesi Xate, eşinin ani ölümüyle Midyat’ın belediye başkanı olur ve
						kasabanın sorunlarını kendine özgü yöntemleriyle çözmeye çalışır.
					</p>

					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> Sermiyan Midyat</p>
						<p><strong>Yapım Yılı:</strong> 2013</p>
						<p>
							Okuma yazma bilmeyen Xate, eşinin vefatıyla hiç beklemediği bir anda Midyat’ın belediye başkanı olur. Kısıtlı imkânlara rağmen kasabanın sorunlarını çözmeye çalışan Xate, bürokrasiye, geleneklere ve erkek egemen yapıya karşı cesurca mücadele eder. Hem komik hem duygusal olaylar yaşanırken, Xate’nin samimiyeti halkın sevgisini kazanmasına yol açar. Kasabayı değiştiren bu mücadele, güçlü bir kadın hikâyesine dönüşür.
						</p>
					</div>

					<button class="detay_button" type="button">Detaylı incele</button>
				</div>
			</article>
			<!--5.Film-->
			<article class="filmler">
				<img src="resimler/mucize_poster.png" alt="Mucize: Uğur Böceği ile Kara Kedi" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>Mucize: Uğur Böceği ile Kara Kedi</h3>
					<p class="film_detayları">
						1 sa 40 dk • Animasyon, Fantastik, Aksiyon, Romantik, Aile
					</p>
					<p class="film_kisa_aciklama">
						Paris’te yaşayan Marinette, Uğur Böceği adlı süper kahramana dönüşür ve
						Kara Kedi ile birlikte şehri kötülükten korumaya çalışır.
					</p>

					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> Jeremy Zag</p>
						<p><strong>Yapım Yılı:</strong> 2023</p>
						<p>
							Hawk Moth'un insanların duygularını manipüle ederek onları süper kötüye dönüştürmesi Paris’i kaosa sürüklerken, Marinette gizli kimliği Uğur Böceği olarak şehri korumaya çalışır. Adrien ise Kara Kedi olarak hem Marinette’in bilmediği bir müttefik hem de karmaşık duygularının merkezidir. İkili, kimliklerini gizlemek zorunda oldukları için kişisel hayatları ve kahramanlık görevleri arasında sıkışıp kalır. Paris’i korumaya çalışırken aralarındaki bağ giderek güçlenir.
						</p>
					</div>
					<button class="detay_button" type="button">Detaylı incele</button>
    			</div>
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
	<script>
		document.querySelectorAll('.detay_button').forEach(function (btn) {
			btn.addEventListener('click', function () {
				const kart = btn.closest('.filmler');

				const acikMi = kart.classList.toggle('acik');

				btn.textContent = acikMi ? 'Daha az göster' : 'Detaylı incele';
			});
		});
	</script>
</body>
</html>