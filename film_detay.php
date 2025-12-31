<?php
require 'config3.php';

if (!isset($_GET['film_id'])) {
    die('Film bulunamadı.');
}

$film_id = (int)$_GET['film_id'];

$stmt = $pdo->prepare("SELECT film_id, film_adi, aciklama FROM Film WHERE film_id = ?");
$stmt->execute([$film_id]);
$film = $stmt->fetch();

if (!$film) {
    die('Film bulunamadı.');
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($film['film_adi']) ?> - Detay</title>
</head>
<body>

<h1><?= htmlspecialchars($film['film_adi']) ?></h1>

<p><?= nl2br(htmlspecialchars($film['aciklama'])) ?></p>

<a href="ilk_orn.php">Geri dön</a>

</body>
</html>
