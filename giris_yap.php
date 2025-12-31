<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="giris_yap.css">
    <title>Giriş Yap - Vizyonda Sinema</title>
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
                <span class="ilk_harf">G</span>iriş Ekranı
            </h2>
            <p>Hesabınıza giriş yapınız</p>
        </section>

        <section class="giris_yap">
            <div class="giris_ekrani">
                <h3>Giriş Yap</h3>

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

                <form class="giris_formu" action="giris_islem.php" method="post">

                    <label>E-posta</label>
                    <input type="email" name="email" placeholder="E-posta adresinizi girin" required>

                    <label>Şifre</label>
                    <input type="password" name="sifre" placeholder="Şifrenizi girin" required>

                    <button type="submit" name="giris_submit" class="giris_butonu">Giriş Yap</button>

                    <p class="kayit_yonlendirme">
                        Hesabınız yok mu? <a href="kayit_ol.php">Kayıt Ol</a>
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

    <?php if (isset($_GET['basarili']) && $_GET['basarili'] == '1'): ?>
       
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
                border:1px solid #4A70A9;
                color:#EDE9E1;
                font-family: Helvetica, Arial, sans-serif;
            ">
                <h3 style="margin:0 0 8px 0;font-size:20px;color:#8BC34A;letter-spacing:0.5px;">
                    Giriş Başarılı
                </h3>

                <p style="margin:0 0 16px 0;font-size:14px;">
                    Hoş geldiniz, 
                    <?= isset($_SESSION['ad']) && isset($_SESSION['soyad']) 
                            ? htmlspecialchars($_SESSION['ad'] . ' ' . $_SESSION['soyad']) 
                            : 'kullanıcı' ?>
                </p>

                <button type="button"
                        onclick="window.location.href='ilk_orn.php';"
                        style="
                            padding:9px 20px;
                            font-size:15px;
                            border:none;
                            border-radius:999px;
                            cursor:pointer;
                            background:linear-gradient(135deg,#8BC34A,#76b042);
                            color:#ffffff;
                            font-weight:500;
                            box-shadow:0 8px 20px rgba(0,0,0,0.5);
                        ">
                    Tamam
                </button>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>
