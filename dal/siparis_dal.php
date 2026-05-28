<?php
require_once __DIR__ . '/../dal/db.php';

function siparis_ekle($musteri_id, $toplam_tutar) {
    global $pdo;
    $stmt = $pdo->prepare("CALL SiparisEkle(?, CURDATE(), ?, 'Hazirlaniyor')");
    $stmt->execute([$musteri_id, $toplam_tutar]);
    $stmt->closeCursor();
    $stmt2 = $pdo->query("SELECT LAST_INSERT_ID() AS id");
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    return $row['id'];
}

function siparis_detay_ekle($siparis_id, $pasta_id, $adet, $birim_fiyat) {
    global $pdo;
    $stmt = $pdo->prepare("CALL SiparisDetayEkle(?, ?, ?, ?)");
    $stmt->execute([$siparis_id, $pasta_id, $adet, $birim_fiyat]);
}

function odeme_ekle($siparis_id, $tutar, $odeme_turu) {
    global $pdo;
    $stmt = $pdo->prepare("CALL OdemeEkle(?, CURDATE(), ?, ?, 'Basarili')");
    $stmt->execute([$siparis_id, $tutar, $odeme_turu]);
}

function teslimat_ekle($siparis_id, $adres) {
    global $pdo;
    $stmt = $pdo->prepare("CALL TeslimatEkle(?, ?, NULL, 'Hazirlaniyor')");
    $stmt->execute([$siparis_id, $adres]);
}

function musteri_siparislerini_getir($musteri_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL SiparisListele()");
    $stmt->execute();
    $tumSiparisler = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return array_filter($tumSiparisler, function($s) use ($musteri_id) {
        return $s['Musteri_id'] == $musteri_id;
    });
}

function siparis_detaylarini_getir($siparis_id) {
    global $pdo;
    $stmt = $pdo->prepare("CALL SiparisDetayGetir(?)");
    $stmt->execute([$siparis_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function tum_siparisleri_getir() {
    global $pdo;
    $stmt = $pdo->prepare("CALL SiparisListeleHepsi()");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>