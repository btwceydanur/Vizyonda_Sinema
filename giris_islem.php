<?php
session_start();
require 'config3.php';

if (!isset($_POST['giris_submit'])) {
    header('Location: giris_yap.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$sifre = $_POST['sifre'] ?? '';

if ($email === '' || $sifre === '') {
    die('E-posta ve şifre zorunludur.');
    exit;
}

$stmt = $pdo->prepare('SELECT kisi_id, ad, soyad, sifre_hash FROM Kisi WHERE email = ?');
$stmt->execute([$email]);
$kisi = $stmt->fetch();

if (!$kisi) {
    header('Location: giris_yap.php?hata=E-posta veya şifre hatalı.');
    exit;
}

if (!password_verify($sifre, $kisi['sifre_hash'])) {
    header('Location: giris_yap.php?hata=E-posta veya şifre hatalı.');
    exit;
}

$_SESSION['kisi_id'] = $kisi['kisi_id'];
$_SESSION['ad'] = $kisi['ad'];
$_SESSION['soyad'] = $kisi['soyad'];

header('Location: giris_yap.php?basarili=1');
exit;

