<?php
session_start();
require 'config3.php';

if (!isset($_SESSION['kisi_id'])) {
    header('Location: giris_yap.php?hata=Lütfen önce giriş yapın.');
    exit;
}

if (!isset($_POST['hesap_sil'])) {
    header('Location: hesap_bilgileri.php');
    exit;
}

$kisi_id = (int)$_SESSION['kisi_id'];

$stmt = $pdo->prepare('DELETE FROM Bilet WHERE kisi_id = ?');
$stmt->execute([$kisi_id]);

$stmt = $pdo->prepare('DELETE FROM Kisi WHERE kisi_id = ?');
$stmt->execute([$kisi_id]);

session_unset();
session_destroy();

header('Location: ilk_orn.php?mesaj=Hesabınız silindi.');
exit;
