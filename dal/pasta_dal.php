<?php
require_once __DIR__ . '/../dal/db.php';

function pastalari_listele() {
    global $pdo;
    $stmt = $pdo->prepare("CALL PastaListele()");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function kategorileri_listele() {
    global $pdo;
    $stmt = $pdo->prepare("CALL KategoriListele()");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function pasta_getir_Id($pasta_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL PastaGetirById(?)");
    $stmt->execute([$pasta_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function kategoriye_gore_pasta_getir($kategori_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL PastaGetirByKategori(?)");
    $stmt->execute([$kategori_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function pastaya_gore_yorumlari_listele($pasta_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL YorumListeleByPasta(?)");
    $stmt->execute([$pasta_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function ortalama_puan_hesapla($pasta_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT OrtalamaPuanHesapla(?) AS ortalama");
    $stmt->execute([$pasta_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['ortalama'];
}
?>