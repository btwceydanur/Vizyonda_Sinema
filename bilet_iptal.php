<?php
session_start();
require 'config3.php';

// 1) Giriş kontrolü
if (!isset($_SESSION['kisi_id'])) {
    header('Location: giris_yap.php?hata=İptal işlemi için önce giriş yapın.');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: biletlerim.php');
    exit;
}

$kisi_id  = (int)$_SESSION['kisi_id'];
$bilet_id = isset($_POST['bilet_id']) ? (int)$_POST['bilet_id'] : 0;

if ($bilet_id <= 0) {
    header('Location: biletlerim.php?hata=Geçersiz bilet.');
    exit;
}

// 2) Bilet bilgilerini çektim (kime ait, durumu ne, seans zamanı ne?)
$sql = "
    SELECT 
        B.bilet_id,
        B.kisi_id,
        B.durum,
        S.seans_tarihi,
        S.seans_saati
    FROM Bilet B
    JOIN Seans S ON B.seans_id = S.seans_id
    WHERE B.bilet_id = ?
    LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$bilet_id]);
$bilet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bilet) {
    header('Location: biletlerim.php?hata=Bilet bulunamadı.');
    exit;
}

// 3) Bu bilet gerçekten giriş yapan kullanıcıya mı ait?
if ((int)$bilet['kisi_id'] !== $kisi_id) {
    header('Location: biletlerim.php?hata=Bu bileti iptal etme yetkiniz yok.');
    exit;
}

// 4) Bilet zaten iptal edilmiş mi?
if ($bilet['durum'] !== 'SATILDI') {
    header('Location: biletlerim.php?hata=Bu bilet zaten iptal edilmiş veya geçersiz.');
    exit;
}

// 5) 24 saat kuralını tekrar kontrol ettim 
$tz      = new DateTimeZone("Europe/Istanbul");
$simdi   = new DateTime("now", $tz);
$seansDT = new DateTime($bilet['seans_tarihi'] . ' ' . $bilet['seans_saati'], $tz);

$fark_saniye = $seansDT->getTimestamp() - $simdi->getTimestamp();
$fark_saat   = $fark_saniye / 3600.0;



// Eğer seans geçmişse veya 24 saatten az kalmışsa → iptal yok
if ($fark_saat <= 24) {
    header('Location: biletlerim.php?hata=Seansa 24 saatten az kaldığı veya süresi geçtiği için bu bilet iptal edilemez.');
    exit;
}

// 6) İptal işlemi: durum + iptal_zamani
try {
    $sqlUpdate = "
        UPDATE Bilet
        SET durum = 'IPTAL',
            iptal_zamani = NOW(),
            koltuk_id = NULL
        WHERE bilet_id = ?
        AND kisi_id  = ?
        AND durum    = 'SATILDI'
    ";

    $stmtUp = $pdo->prepare($sqlUpdate);
    $stmtUp->execute([$bilet_id, $kisi_id]);

    if ($stmtUp->rowCount() > 0) {
        header('Location: biletlerim.php?mesaj=Bilet başarıyla iptal edildi.');
        exit;
    } else {
        header('Location: biletlerim.php?hata=Bilet iptal edilirken bir sorun oluştu.');
        exit;
    }

} catch (Exception $e) {
    header('Location: biletlerim.php?hata=İptal sırasında bir hata oluştu: ' . urlencode($e->getMessage()));
    exit;
}
