<?php
session_start();
require 'config3.php';

if (!isset($_SESSION['kisi_id'])) {
    header("Location: giris_yap.php?hata=Lütfen önce giriş yapın.");
    exit;
}

if (!isset($_POST['sifre_degistir'])) {
    header("Location: hesap_bilgileri.php");
    exit;
}

$kisi_id = (int)$_SESSION['kisi_id'];

$mevcut = $_POST['mevcut_sifre'] ?? '';
$yeni = $_POST['yeni_sifre'] ?? '';
$yeni2 = $_POST['yeni_sifre_tekrar'] ?? '';

if ($mevcut === '' || $yeni === '' || $yeni2 === '') {
    header("Location: hesap_bilgileri.php?hata=Tüm şifre alanlarını doldurmalısınız.");
    exit;
}

if ($yeni !== $yeni2) {
    header("Location: hesap_bilgileri.php?hata=Yeni şifreler uyuşmuyor.");
    exit;
}

$stmt = $pdo->prepare("SELECT sifre_hash FROM Kisi WHERE kisi_id = ?");
$stmt->execute([$kisi_id]);
$kisi = $stmt->fetch();

if (!$kisi || !password_verify($mevcut, $kisi['sifre_hash'])) {
    header("Location: hesap_bilgileri.php?hata=Mevcut şifre yanlış.");
    exit;
}

$yeni_hash = password_hash($yeni, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE Kisi SET sifre_hash = ? WHERE kisi_id = ?");
$stmt->execute([$yeni_hash, $kisi_id]);

header("Location: hesap_bilgileri.php?mesaj=Şifre başarıyla güncellendi.");
exit;
