<?php
require_once __DIR__ . '/../dal/db.php';

function yorum_ekle($musteri_id, $pasta_id, $puan, $yorum_metni) {
    global $pdo;
    $stmt = $pdo->prepare("CALL YorumEkle(?, ?, ?, ?, CURDATE())");
    $stmt->execute([$musteri_id, $pasta_id, $puan, $yorum_metni]);
}
?>