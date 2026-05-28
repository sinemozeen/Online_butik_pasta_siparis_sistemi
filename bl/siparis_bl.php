<?php
require_once __DIR__ . '/../dal/siparis_dal.php';

function siparis_olustur($musteri_id, $sepet, $odeme_turu, $adres) {
    if(empty($sepet)) {
        return ["basari" => false, "mesaj" => "Sepetiniz boş."];
    }
    if(empty($odeme_turu)) {
        return ["basari" => false, "mesaj" => "Ödeme yöntemi seçiniz."];
    }
    if(empty($adres)) {
        return ["basari" => false, "mesaj" => "Teslimat adresi boş olamaz."];
    }

    $toplam = 0;
    foreach($sepet as $item) {
        $toplam += $item['fiyat'] * $item['adet'];
    }

    try {
        $siparis_id = siparis_ekle($musteri_id, $toplam);
        foreach($sepet as $item) {
            siparis_detay_ekle($siparis_id, $item['pasta_id'], $item['adet'], $item['fiyat']);
        }
        odeme_ekle($siparis_id, $toplam, $odeme_turu);
        teslimat_ekle($siparis_id, $adres);
        return ["basari" => true, "mesaj" => "Siparişiniz alındı!", "siparis_id" => $siparis_id];
    } catch(Exception $e) {
        return ["basari" => false, "mesaj" => "Sipariş oluşturulamadı: " . $e->getMessage()];
    }
}

function musteri_siparisleri($musteri_id) {
    return musteri_siparislerini_getir($musteri_id);
}

function siparis_detayi($siparis_id) {
    return siparis_detaylarini_getir($siparis_id);
}
?>