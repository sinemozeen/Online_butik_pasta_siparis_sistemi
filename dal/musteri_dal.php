<?php
require_once __DIR__ . '/../dal/db.php';

function musteri_ekle($ad, $soyad, $telefon, $mail, $sifre, $adres) {
    global $pdo;
    $stmt = $pdo->prepare("CALL MusteriEkle(?, ?, ?, ?, ?, ?)");
    $stmt->execute([$ad, $soyad, $telefon, $mail, $sifre, $adres]);
}

function mail_ile_musteri_getir($mail) {
    global $pdo;
    $stmt = $pdo->prepare("CALL MusteriGetirByMail(?)");
    $stmt->execute([$mail]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>