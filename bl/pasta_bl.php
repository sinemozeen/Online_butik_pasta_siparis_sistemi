<?php
require_once __DIR__ . '/../dal/pasta_dal.php';

function pastalari_getir() {
    return pastalari_listele();
}

function kategorileri_getir() {
    return kategorileri_listele();
}

function pasta_detay_getir($pasta_id) {
    return pasta_getir_Id($pasta_id);
}

function kategoriye_gore_getir($kategori_id) {
    return kategoriye_gore_pasta_getir($kategori_id);
}
function yorumlari_getir($pasta_id) {
    return pastaya_gore_yorumlari_listele($pasta_id);
}

function ortalama_puan_getir($pasta_id) {
    return ortalama_puan_hesapla($pasta_id);
}
?>