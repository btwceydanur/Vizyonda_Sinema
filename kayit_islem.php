<?php
session_start();
require 'config3.php';

if (!isset($_POST['kayit_submit'])) {
    header('Location: kayit_ol.php');
    exit;
}

$ad = trim($_POST['ad'] ?? '');
$soyad = trim($_POST['soyad'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefon = trim($_POST['telefon'] ?? '');
$sifre = $_POST['sifre'] ?? '';
$sifre_tekrar = $_POST['sifre_tekrar'] ?? '';

if ($ad === '' || $soyad === '' || $email === '' || $telefon === '' || $sifre === '' || $sifre_tekrar === '') {
    header('Location: kayit_ol.php?hata=Lütfen tüm alanları doldurun');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: kayit_ol.php?hata=Geçerli bir e-posta adresi girin');
    exit;
}

if ($sifre !== $sifre_tekrar) {
    header('Location: kayit_ol.php?hata=Şifreler uyuşmuyor');
    exit;
}

$stmt = $pdo->prepare('SELECT kisi_id FROM Kisi WHERE email = ?');
$stmt->execute([$email]);
$kisiEmail = $stmt->fetch();

if ($kisiEmail) {
    header('Location: kayit_ol.php?hata=Bu e-posta adresi ile zaten kayıt olunmuş');
    exit;
}

$stmt = $pdo->prepare('SELECT kisi_id FROM Kisi WHERE telefon = ?');
$stmt->execute([$telefon]);
$kisiTel = $stmt->fetch();

if ($kisiTel) {
    header('Location: kayit_ol.php?hata=Bu telefon numarası ile zaten kayıt olunmuş');
    exit;
}

$hash = password_hash($sifre, PASSWORD_DEFAULT);

$stmt = $pdo->prepare('INSERT INTO Kisi (ad, soyad, email, sifre_hash, telefon) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([$ad, $soyad, $email, $hash, $telefon]);

$kisi_id = $pdo->lastInsertId();

$_SESSION['kisi_id'] = $kisi_id;
$_SESSION['ad'] = $ad;
$_SESSION['soyad'] = $soyad;

header('Location: kayit_ol.php?mesaj=Kayıt başarılı! Artık giriş yapabilirsiniz.');
exit;
