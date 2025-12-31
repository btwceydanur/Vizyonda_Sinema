<?php
session_start();
require 'config3.php'; 
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vizyondaki Filmler - Vizyonda Sinema</title>
    <link rel="stylesheet" href="vizyondakiler.css">
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
				<span class="ilk_harf">V</span>izyondaki Filmler
			</h2>
			<p>Şu anda gösterimde olan filmler:</p>
		</section>
		<section class="film_listesi">
			<!--1.Film-->
			<article class="filmler">
				<img src="resimler/eksi_elmalar_poster.png" alt="Ekşi Elmalar" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>Ekşi Elmalar</h3>
					<p class="film_detayları">
						1 sa 54 dk • Dram, Komedi
					</p>
					<!-- KISA AÇIKLAMA (kart kapalıyken görünsün) -->
					<p class="film_kisa_aciklama">
						Hakkâri’nin sert ikliminde, Belediye Başkanı Aziz Özay’ın evi hem elma 
						ağaçlarıyla dolu bir bahçe, hem de üç kızının özgürlük hayallerine dar gelen 
						bir kafes gibidir.
					</p>
					<!-- DETAYLI AÇIKLAMA (ilk başta gizli) -->
					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> Yılmaz Erdoğan</p>
						<p><strong>Yapım Yılı:</strong> 2016</p>
						<p><strong>IMDB:</strong> 7.2/10</p>
						<p>
							Film, 1970’lerden 1990’lara uzanan bir dönemde Aziz Özay’ın ailesiyle olan
							çatışmalı ilişkisini anlatır. Baskıcı bir baba ile geleneklerin arasında 
							sıkışan kızları, kendi hayatlarını kurmak için evlilik, aşk ve eğitim 
							mücadelesi verir. Elma bahçesi, hem bu ailenin köklerini hem de yıllar 
							içinde eksilenleri simgeleyen bir hafıza mekânına dönüşür. Yıllar geçtikçe
							geçmişin yüküyle yüzleşen Aziz ve kızları, affetmenin ve kabullenmenin
							ne demek olduğunu yeniden öğrenmek zorunda kalır.
						</p>
					</div>
					<!-- BUTONLAR: HEM KISA, HEM UZUN METNİN ALTINDA DURACAK -->
					<div class="film_butonlar">
						<form action="bilet_al.php" method="get" style="display:inline;">
							<input type="hidden" name="film_id" value="1">
							<button type="submit" class="bilet_button">Bilet Al</button>
						</form>
						<button class="detay_button" onclick="kartDetay(this)">Detaylı İncele</button>
					</div>
			</article>
			<!--2.Film-->
			<article class="filmler">
				<img src="resimler/hızlı_ofkeli_poster.png" alt="Hızlı ve Öfkeli 5: Rio Soygunu" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>Hızlı ve Öfkeli 5: Rio Soygunu</h3>
					<p class="film_detayları">
						2 sa 11 dk • Aksiyon, Gerilim, Suç
					</p>

					<p class="film_kisa_aciklama">
						Dom Toretto ve Brian O'Conner, Rio'da son bir büyük iş için ekibi tekrar 
						toplar ve kendilerini hem uyuşturucu baronunun hedefinde hem de FBI’ın 
						peşinde bulurlar.
					</p>

					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> Justin Lin</p>
						<p><strong>Yapım Yılı:</strong> 2011</p>
						<p><strong>IMDb:</strong> 7.3 / 10</p>
						<p>
							Eski polis Brian ile kaçak Dom, özgürlüklerini kazanmak için Rio’nun en zengin 
							ve en tehlikeli iş adamı Reyes’in kasasını soymaya karar verir. Şehrin her 
							köşesinde iz süren ajan Hobbs, ekibi yakalamaya ant içmiştir. Sokak 
							yarışlarından araba kovalamacalarına, tren üstü soygunlardan kasaları 
							zincirleyip şehir içinde çekmeye kadar aksiyon, filmin her anına yayılır. 
							Dom’un “aile” kavramına olan bağlılığı ise ekibin en büyük gücü hâline gelir.
						</p>
					</div>
					<div class="buton_grup">
						<form action="bilet_al.php" method="get" style="display:inline;">
							<input type="hidden" name="film_id" value="2">
							<button type="submit" class="bilet_button">Bilet Al</button>
						</form>
						<button class="detay_button">Detaylı İncele</button>
					</div>
				</div>
			</article>
			<!--3.Film-->
			<article class="filmler">
				<img src="resimler/hababam_poster.png" alt="Hababam Sınıfı" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>Hababam Sınıfı</h3>
					<p class="film_detayları">
						1 sa 28 dk • Komedi, Dram
					</p>
					<p class="film_kisa_aciklama">
						Özel Çamlıca Lisesi’nin efsane yaramazları, okulu bitirmekten çok şaka
						yapmaya ve dersten kaçmaya odaklıdır; ta ki karşılarına disiplin
						timsali Mahmut Hoca çıkana kadar.
					</p>
					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> Ertem Eğilmez</p>
						<p><strong>Yapım Yılı:</strong> 1975</p>
						<p><strong>IMDb:</strong> 9.2 / 10</p>
						<p>
							Yıllardır aynı sınıfta kalan Hababam tayfası, sahte raporlarla dersten 
							kaçan, geceleyin yatakhaneden kaçıp maç izleyen, kopyayı sanat haline 
							getiren bir ekipten oluşur. Okula atanan Mahmut Hoca, sert ama adil tavrıyla 
							bu dağınık sınıfı disipline etmeye çalışırken öğrencilerle arasında tuhaf 
							bir sevgi bağı oluşur. Gülme krizine sokan şakalar, duygusal veda sahneleri 
							ve okul hayatına dair sıcak ayrıntılar, filmi hem nostaljik hem de kalıcı bir 
							Türk sineması klasiği yapar.
						</p>
					</div>
					<div class="buton_grup">
						<form action="bilet_al.php" method="get" style="display:inline;">
							<input type="hidden" name="film_id" value="3">
							<button type="submit" class="bilet_button">Bilet Al</button>
						</form>
						<button class="detay_button">Detaylı İncele</button>
					</div>
				</div>
			</article>
			<!--4.Film-->
			<article class="filmler">
				<img src="resimler/ejderhani_nasıl_poster.png" alt="Ejderhanı Nasıl Eğitirsin" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>Ejderhanı Nasıl Eğitirsin</h3>
					<p class="film_detayları">
						1 sa 38 dk • Animasyon, Aile, Macera, Fantastik
					</p>
					<p class="film_kisa_aciklama">
						Viking köyünün çelimsiz genci Hıçkırık, yaralı bir ejderha bulduğunda
						yıllardır süren insan–ejderha savaşının aslında bir yanlış anlamadan
						ibaret olabileceğini fark eder.
					</p>
					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> Chris Sanders, Dean DeBlois</p>
						<p><strong>Yapım Yılı:</strong> 2010</p>
						<p><strong>IMDb:</strong> 8.1 / 10</p>
						<p>
							Hıçkırık, kendisini kanıtlamak için bir ejderha avlamak zorunda olan ama 
							savaşmaktan çok merak eden bir delikanlıdır. Dişsiz adını verdiği nadir 
							bir ejderhayı yaralı halde bulunca onu öldürmek yerine gizlice iyileştirir 
							ve aralarında güçlü bir dostluk kurulur. Hıçkırık öğrendiklerini köyüne 
							anlatmaya çalıştıkça hem babası reis Stoick’le hem de savaşçı arkadaşlarıyla 
							ters düşer. Ejderhaların gerçek yüzü ortaya çıktığında ise köyün kaderi bu 
							iki sıra dışı dostluğun ellerine bırakılır.
						</p>
					</div>
					<div class="buton_grup">
						<form action="bilet_al.php" method="get" style="display:inline;">
							<input type="hidden" name="film_id" value="4">
							<button type="submit" class="bilet_button">Bilet Al</button>
						</form>
						<button class="detay_button">Detaylı İncele</button>
					</div>
				</div>
			</article>
			<!--5.Film-->
			<article class="filmler">
				<img src="resimler/sihirbazlar_poster.png" alt="Sihirbazlar Çetesi: Daha Bir Şey Görmediniz" class="film_posterleri">

				<div class="film_bilgisi">
					<h3>Sihirbazlar Çetesi: Daha Bir Şey Görmediniz</h3>
					<p class="film_detayları">
						1 sa 55 dk • Gerilim, Suç, Gizem
					</p>
					<p class="film_kisa_aciklama">
						“Dört Atlı” bir yıl sonra yeniden sahneye döner; bu kez perde 
						arkasından ipleri elinde tutan gizemli bir teknoloji dahisi, 
						onları dünyayı sarsacak bir hırsızlığa zorlar.
					</p>
					<div class="detay_icerik">
						<p><strong>Yönetmen:</strong> Jon M. Chu</p>
						<p><strong>Yapım Yılı:</strong> 2016</p>
						<p><strong>IMDb:</strong> 6.4 / 10</p>
						<p>
							İlk filmden sağ çıkan ekip, sahne şovlarını kullanarak yolsuzluk yapanları 
							ifşa etmeye devam ederken bir anda kendilerini, öldüğü sanılan eski bir 
							düşmanın ve genç bir milyarderin kurduğu oyunun merkezinde bulur. Londra’dan 
							Makao’ya uzanan zincirleme illüzyonlar, izleyenlerin neye inanacağını iyice 
							karıştırır. Her numaranın arkasında ikinci bir plan, her karakterin geçmişinde 
							sakladığı bir sır vardır. Film, “gözünü kırpma, yoksa numarayı kaçırırsın” 
							hissini son ana kadar diri tutar.
						</p>
					</div>
					<div class="buton_grup">
						<form action="bilet_al.php" method="get" style="display:inline;">
							<input type="hidden" name="film_id" value="5">
							<button type="submit" class="bilet_button">Bilet Al</button>
						</form>
						<button class="detay_button">Detaylı İncele</button>
					</div>
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
		document.addEventListener("DOMContentLoaded", function () {
			const cards = document.querySelectorAll(".filmler");

			cards.forEach(card => {
				const detayBtn   = card.querySelector(".detay_button");
				const detayIcerik = card.querySelector(".detay_icerik");

				if (!detayBtn || !detayIcerik) return;

				detayBtn.addEventListener("click", function () {
					const acikMi = card.classList.toggle("acik");

					if (acikMi) {
						// Açıldı
						detayBtn.textContent = "Daha Az Göster";
					} else {
						// Kapandı
						detayBtn.textContent = "Detaylı İncele";
					}
				});
			});
		});
	</script>
</body>
</html>