<?php
require_once __DIR__ . '/../dal/yorum_dal.php';
require_once __DIR__ . '/../dal/db.php';

function yorum_yap($musteri_id, $pasta_id, $puan, $yorum_metni) {
    global $pdo;

    if($puan < 1 || $puan > 5) {
        return ["basari" => false, "mesaj" => "Puan 1 ile 5 arasında olmalıdır."];
    }
    if(empty($yorum_metni)) {
        return ["basari" => false, "mesaj" => "Yorum metni boş olamaz."];
    }

    // müşteri bu pastayı teslim aldı mı kontrol et
    $stmt = $pdo->prepare("CALL YorumKontrol(?, ?)");
    $stmt->execute([$musteri_id, $pasta_id]);
    $sonuc = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    if($sonuc['sayi'] == 0) {
        return ["basari" => false, "mesaj" => "Yorum yapabilmek için ürünü teslim almış olmanız gerekmektedir."];
    }

    yorum_ekle($musteri_id, $pasta_id, $puan, $yorum_metni);
    return ["basari" => true, "mesaj" => "Yorumunuz eklendi."];
}
?>
