<?php
session_start();
require 'config3.php';

if (!isset($_SESSION['kisi_id'])) {
    header('Location: giris_yap.php?hata=Lütfen önce giriş yapın.');
    exit;
}

if (!isset($_POST['hesap_guncelle'])) {
    header('Location: hesap_bilgileri.php');
    exit;
}

$kisi_id = (int)$_SESSION['kisi_id'];

$ad = trim($_POST['ad'] ?? '');
$soyad = trim($_POST['soyad'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefon = trim($_POST['telefon'] ?? '');

if ($ad === '' || $soyad === '' || $email === '' || $telefon === '') {
    header('Location: hesap_bilgileri.php?hata=Tüm alanlar zorunludur.');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: hesap_bilgileri.php?hata=Geçerli bir e-posta adresi girin.');
    exit;
}

$stmt = $pdo->prepare('SELECT kisi_id FROM Kisi WHERE email = ? AND kisi_id <> ?');
$stmt->execute([$email, $kisi_id]);
$varEmail = $stmt->fetch();

if ($varEmail) {
    header('Location: hesap_bilgileri.php?hata=Bu e-posta başka bir kullanıcı tarafından kullanılıyor.');
    exit;
}

$stmt = $pdo->prepare('SELECT kisi_id FROM Kisi WHERE telefon = ? AND kisi_id <> ?');
$stmt->execute([$telefon, $kisi_id]);
$varTel = $stmt->fetch();

if ($varTel) {
    header('Location: hesap_bilgileri.php?hata=Bu telefon numarası başka bir kullanıcı tarafından kullanılıyor.');
    exit;
}

$stmt = $pdo->prepare('UPDATE Kisi SET ad = ?, soyad = ?, email = ?, telefon = ? WHERE kisi_id = ?');
$stmt->execute([$ad, $soyad, $email, $telefon, $kisi_id]);

$_SESSION['ad'] = $ad;
$_SESSION['soyad'] = $soyad;

header('Location: hesap_bilgileri.php?mesaj=Bilgileriniz başarıyla güncellendi.');
exit;
