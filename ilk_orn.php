<?php
session_start();
require 'config3.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="anasayfa.css">
    <title>Vizyonda Sinema</title>
</head>
<body>
	<?php if (isset($_GET['cikis']) && $_GET['cikis'] == '1'): ?>
		<div style="
			position: fixed;
			inset: 0;
			background: rgba(0,0,0,0.55);
			display: flex;
			justify-content: center;
			align-items: center;
			z-index: 9999;
		">
			<div style="
				background:#1f2933;
				padding:22px 28px;
				border-radius:18px;
				width:320px;
				max-width:92%;
				text-align:center;
				box-shadow:0 18px 40px rgba(0,0,0,0.6);
				border:1px solid #b23a48;
				color:#EDE9E1;
				font-family: Helvetica, Arial, sans-serif;
			">
				<h3 style="margin:0 0 8px 0;font-size:20px;color:#ff6b6b;letter-spacing:0.5px;">
					Çıkış Yapıldı
				</h3>

				<p style="margin:0 0 16px 0;font-size:14px;">
					Başarıyla çıkış yaptınız.
				</p>

				<button type="button"
						onclick="window.location.href='ilk_orn.php';"
						style="
							padding:9px 20px;
							font-size:15px;
							border:none;
							border-radius:999px;
							cursor:pointer;
							background:linear-gradient(135deg,#ff6b6b,#e63946);
							color:#ffffff;
							font-weight:500;
							box-shadow:0 8px 20px rgba(0,0,0,0.5);
						">
					Tamam
				</button>
			</div>
		</div>
	<?php endif; ?>

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
        <section class="film_bolumleri">
            <div class="filmler">
                <button class="nav-btn prev">&#10094;</button>
                <button class="nav-btn next">&#10095;</button>
                <!--1.Afiş-->
                <div class="film_gosterimleri aktif eksi_elmalar">
                    <div class="film_icerigi">
                        <span class="film-etiket">VİZYONDA</span>
                        <h2>Ekşi Elmalar</h2>
						<p class="film_detaylari">
							1 sa 54 dk • Dram, Komedi
						</p>
                        <p class="film_kisa_aciklama">
                            1970’lerin sonunda Hakkari’de yaşayan Belediye Reisi Aziz Özay’ın baskıcı karakteri, üç kızıyla olan karmaşık ilişkileriyle birleşir. Yıllar içinde hem aile içi çatışmalar hem de geçmişin izleri, bu küçük kasabanın hayatını şekillendirir.
                        </p>
						<!-- DETAYLI AÇIKLAMA (ilk başta gizli) -->
						<div class="detay_icerik">
							<p><strong>Yönetmen:</strong> Yılmaz Erdoğan</p>
							<p><strong>Yapım Yılı:</strong> 2016</p>
							<p><strong>IMDB:</strong> 7.2/10</p>
							<p>
								Sert mizacıyla tanınan Belediye Reisi Aziz Özay'ın kent çapında meşhur 
								iki özelliği daha vardır: Biri herkesin imrendiği meyve bahçesi, ikincisi 
								de evlenme çağına gelmiş, birbirinden güzel 3 kızı. Kasaba merkezine inmeyen, 
								insan içine çok çıkmayan kızların taliplisi ise çoktur. Aziz Bey'in eşi Ayda ve 
								kızları Muazzez, Türkan ve Safiye 'nin öyküleri 1970'li yılların sonunda Hakkari'de 
								başlar ve 1990'lı yılların sonunda Antalya’ya dek uzanır.
							</p>
						</div>
						<div class="film_butonlar">
							<form action="bilet_al.php" method="get" style="display:inline;">
								<input type="hidden" name="film_id" value="1">
								<button type="submit" class="bilet_button">Bilet Al</button>
							</form>
							<button class="detay_button" onclick="kartDetay(this)">Detaylı İncele</button>
						</div>
                        
                    </div>
                </div>

				<!--2.Afiş-->
                <div class="film_gosterimleri hızlı_ve_ofkeli">
                    <div class="film_icerigi">
                        <span class="film-etiket">VİZYONDA</span>
                        <h2>Hızlı ve Öfkeli 5: Rio Soygunu</h2>
						<p class="film_detaylari">
							2 sa 11 dk • Aksiyon, Gerilim, Suç
						</p>
                        <p class="film_kisa_aciklama">
							Brian ve Dom, son kez özgür olabilmek için Rio’da büyük bir soyguna girişirler. Hem peşlerindeki acımasız bir iş adamı hem de onları durdurmaya çalışan federal ajan, ekibin işini iyice zorlaştırır.
						</p>
						<div class="detay_icerik">
							<p><strong>Yönetmen:</strong> Justin Lin</p>
							<p><strong>Yapım Yılı:</strong> 2011</p>
							<p><strong>IMDb:</strong> 7.3 / 10</p>
							<p>
								Eski polis Brian O'Conner ve geçmişte, paçasını kurtardığı Dom Toretto, 
								tamamen özgür olabilmek için bir kez daha takım olurlar. Ancak özgürlük kolay 
								olmayacaktır, peşlerinde onları ölü isteyen belalı bir iş adamı ve avını yakalamayı 
								amaç edinmiş Federal bir ajan vardır. İkili Rio'da sıkışıp kalmışken bir yandan da, 
								yarışma için, eşsiz bir ekip toplamaktadır.
							</p>
						</div>
                        <div class="film_butonlar">
							<form action="bilet_al.php" method="get" style="display:inline;">
								<input type="hidden" name="film_id" value="2">
								<button type="submit" class="bilet_button">Bilet Al</button>
							</form>
							<button class="detay_button" onclick="kartDetay(this)">Detaylı İncele</button>
						</div>
                    </div>
                </div>
				
				<!--3.Afiş-->
				<div class="film_gosterimleri hababam">
                    <div class="film_icerigi">
                        <span class="film-etiket">VİZYONDA</span>
                        <h2>Hababam Sınıfı</h2>
						<p class="film_detaylari">
							1 sa 28 dk • Komedi, Dram
						</p>
                        <p class="film_kisa_aciklama">
							Çamlıca Lisesi’nin uslanmaz öğrencileri, yeni idareci Mahmut Hoca’nın disiplin kurallarıyla karşı karşıya kalır. Haylazlıklarıyla ünlü Hababam Sınıfı, okul hayatını bir kez daha karıştırmaya kararlıdır.
						</p>
						<div class="detay_icerik">
							<p><strong>Yönetmen:</strong> Ertem Eğilmez</p>
							<p><strong>Yapım Yılı:</strong> 1975</p>
							<p><strong>IMDb:</strong> 9.2 / 10</p>
							<p>
								Özel Çamlıca Lisesi'ne yeni bir idareci atanır. Tarih hocası olan Kel Mahmut,
								haylaz öğrencilerle dolu Hababam Sınıfı'nı disiplin altına almak için çaba sarf 
								etmektir. Ancak öğrencilerin de uslanmaya niyetleri yoktur. Kopya çekmeyi alışkanlık 
								haline getiren, sigara içen ve sıkça okuldan kaçan öğrencilere, Mahmut Hoca'nın ilginç 
								cezaları vardır. Yaşları bir hayli ilerlemiş ve bir türlü okulu bitirememiş olan
								Hababam Sınıfı öğrencilerinden Ferit'in bir de çocuğu vardır. Bir gün çocuğa bakacak
								kimse bulamayınca onu, okula getirmek zorunda kalır. Ancak bu durum, okul 
								sahibinin hoşuna gitmeyecektir.
							</p>
						</div>
                        <div class="film_butonlar">
							<form action="bilet_al.php" method="get" style="display:inline;">
								<input type="hidden" name="film_id" value="3">
								<button type="submit" class="bilet_button">Bilet Al</button>
							</form>
							<button class="detay_button" onclick="kartDetay(this)">Detaylı İncele</button>
						</div>
                    </div>
                </div>
				<!--4.Afiş-->
                <div class="film_gosterimleri arabalar">
                    <div class="film_icerigi">
                        <span class="film-etiket">YAKINDA</span>
                        <h2>Arabalar</h2>
						<p class="film_detaylari">
							1 sa 57 dk • Animasyon, Macera, Komedi, Aile
						</p>
                        <p class="film_kisa_aciklama">
							Ünlü yarışçı Lightning McQueen, bir kaza sonrası Radiator Springs adlı kasabada mahsur kalır. Zorunlu mola, ona hayat, dostluk ve gerçek başarı hakkında beklenmedik dersler verir.
						</p>
						<div class="detay_icerik">
							<p><strong>Yönetmen:</strong> John Lasseter</p>
							<p><strong>Yapım Yılı:</strong> 2006</p>
							<p><strong>IMDB:</strong> 7.2/10</p>
							<p>
								Piston Kupası için The King ve Chick Hicks’e karşı yarışmak üzere Kaliforniya’ya 
								gitmekte olan meşhur yarış arabası Lightning McQueen, kaza ile Radiator Springs 
								adındaki küçük bir kasabanın yollarına zarar verir. Üstelik kendisinin de tamir 
								olması için çok çalışması gerekmektedir. Bu sırada bu olayla beraber o kasabada 
								geçirdiği zamanlarda dostluklar edinir ve gerçek sevgiyi yaşar. Hatta aşkı bile 
								katar yaşamına. Bu küçük kasabada kaldığı sürece değerleri değişmeye başlar. 
								İşte ancak ondan sonra gerçek bir kazanan olmaya hazır hale gelecektir.
							</p>
						</div>
                        <div class="film_butonlar">
							<button class="detay_button" onclick="kartDetay(this)">Detaylı İncele</button>
						</div>
                    </div>
                </div>
                <!--5.Afiş-->
                <div class="film_gosterimleri baslangic">
                    <div class="film_icerigi">
                        <span class="film-etiket">YAKINDA</span>
                        <h2>Başlangıç</h2>
						<p class="film_detaylari">
							2 sa 28 dk • Aksiyon, Bilim-Kurgu, Macera
						</p>
                        <p class="film_kisa_aciklama">
							Dom Cobb, insanların rüyalarına girerek bilinçaltından bilgi çalan yetenekli bir hırsızdır. Hayatını geri kazanma şansı bulduğunda, bu kez fikir çalmak yerine imkânsız görünen bir görevi tamamlamak zorundadır.
						</p>
						<div class="detay_icerik">
							<p><strong>Yönetmen:</strong> Christopher Nolan</p>
							<p><strong>Yapım Yılı:</strong> 2010</p>
							<p><strong>IMDB:</strong> 8.8/10</p>
							<p>
								Leonardo DiCaprio bu yapımda, çok yetenekli bir hırsız olan Dom Cobb ile 
								karşımızda. Uzmanlık alanı, zihnin en karanlık ve savunmasız olduğu rüya anında, 
								bilinçaltının derinliklerindeki değerli sırları çekip çıkarmak ve onları çalmaktır. 
								Cobb'un insanlarda nadiren görülebilecek bu yeteneği onu kurumsal casusluğun tehlikeli 
								yeni dünyasında aranan bir oyuncu yapmıştır. Aynı zamanda bu durum onu uluslararası 
								bir kaçak yapmış ve sevdiği her şeye malolmuştur. Cobb'a içinde bulunduğu durumdan 
								kurtulmasını sağlayacak bir fırsat sunulur. Ona hayatını geri verebilecek son bir 
								iş; tabii eğer imkansız 'Başlangıç'ı tamamlayabilirse.
							</p>
						</div>
                        <div class="film_butonlar">
							<button class="detay_button" onclick="kartDetay(this)">Detaylı İncele</button>
						</div>
                    </div>
                </div>
                <!--6.Afiş-->
                <div class="film_gosterimleri mucize_paris">
                    <div class="film_icerigi">
                        <span class="film-etiket">YAKINDA</span>
                        <h2>Mucize: Uğur Böceği ile Kara Kedi</h2>
						<p class="film_detaylari">
							1 sa 40 dk • Animasyon, Fantastik, Aksiyon, Romantik, Aile
						</p>
                        <p class="film_kisa_aciklama">
							Paris’te yaşayan Marinette ve Adrien, kimliklerini bilmeden şehri koruyan iki süper kahramana dönüşür. Kötü Hawkmoth’un tehditleriyle mücadele eden ikili, hem gençlik sorunlarıyla hem de şehrin güvenliğiyle başa çıkar.
						</p>
						<div class="detay_icerik">
							<p><strong>Yönetmen:</strong> Jeremy Zag</p>
							<p><strong>Yapım Yılı:</strong> 2023</p>
							<p>
								Paris’te yaşayan Marinette, gizemli bir yaratık olan Tikki sayesinde Uğur Böceği 
								adlı süper kahramana dönüşme gücü kazanır. Aynı zamanda sınıf arkadaşı Adrien de 
								Kara Kedi olur; ancak ikisi de birbirlerinin gerçek kimliğini bilmeden şehri korumak 
								için birlikte savaşırlar.Kötü kalpli Hawkmoth, insanların olumsuz duygularını kullanarak onları süper kötüye dönüştürür ve Uğur Böceği ile Kara Kedi’nin güçlerini ele geçirmek ister. Marinette, okul hayatındaki sorunlar ve Adrien’e olan duyguları ile mücadele ederken, kahraman kimliğiyle Paris’i büyük tehlikelere karşı savunur. Film, ikilinin güç birliğiyle Paris’i kurtarma mücadelesini ve aralarındaki dostluğu konu alır.
							</p>
						</div>
                        <div class="film_butonlar">
							<button class="detay_button" onclick="kartDetay(this)">Detaylı İncele</button>
						</div>
                    </div>
                </div>
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
	<script>
		const cards   = document.querySelectorAll('.film_gosterimleri');
		const prevBtn = document.querySelector('.nav-btn.prev');
		const nextBtn = document.querySelector('.nav-btn.next');

		let currentIndex = 0;
		let autoSlide;          
		let slideLocked = false; 

		function showCard(index) {
			cards[currentIndex].classList.remove('aktif');
			currentIndex = (index + cards.length) % cards.length;
			cards[currentIndex].classList.add('aktif');
		}

		
		function startAutoSlide() {
			clearInterval(autoSlide);
			autoSlide = setInterval(() => {
				if (!slideLocked) {            
					showCard(currentIndex + 1);
				}
			}, 2500);
		}

		
		nextBtn.addEventListener('click', () => {
			if (slideLocked) return;          
			showCard(currentIndex + 1);
			startAutoSlide();                 
		});

		
		prevBtn.addEventListener('click', () => {
			if (slideLocked) return;          
			showCard(currentIndex - 1);
			startAutoSlide();
		});

		
		function kartDetay(button) {
			const wrapper = document.querySelector('.filmler');

			
			const acikMi = wrapper.classList.contains('acik');

			if (!acikMi) {
				wrapper.classList.add('acik');
				button.textContent = 'Daha Az Göster';
				slideLocked = true;           // slider kilitlendi
			} else {
				// Detayları kapattım
				wrapper.classList.remove('acik');
				button.textContent = 'Detaylı İncele';
				slideLocked = false;          // slider tekrar çalıştık
				startAutoSlide();
			}
		}

		// Sayfa açılınca otomatik kaydırmayı başlattım
		startAutoSlide();
	</script>
</body>
</html>