<?php
require_once __DIR__ . '/../dal/musteri_dal.php';

function musteri_kayit($ad, $soyad, $telefon, $mail, $sifre, $sifre_tekrar, $adres) {
    if(empty($ad) || empty($soyad) || empty($mail) || empty($sifre)) {
        return ["basari" => false, "mesaj" => "Tüm alanları doldurunuz."];
    }
    if($sifre !== $sifre_tekrar) {
        return ["basari" => false, "mesaj" => "Şifreler eşleşmiyor."];
    }
    if(strlen($sifre) < 6) {
        return ["basari" => false, "mesaj" => "Şifre en az 6 karakter olmalıdır."];
    }
    $mevcutMusteri = mail_ile_musteri_getir($mail);
    if($mevcutMusteri) {
        return ["basari" => false, "mesaj" => "Bu e-posta adresi zaten kayıtlı."];
    }
    $sifreHash = password_hash($sifre, PASSWORD_DEFAULT);
    musteri_ekle($ad, $soyad, $telefon, $mail, $sifreHash, $adres);
    return ["basari" => true, "mesaj" => "Kayıt başarılı! Giriş yapabilirsiniz."];
}

function musteri_giris($mail, $sifre) {
    if(empty($mail) || empty($sifre)) {
        return ["basari" => false, "mesaj" => "E-posta ve şifre giriniz."];
    }
    $musteri = mail_ile_musteri_getir($mail);
    if(!$musteri) {
        return ["basari" => false, "mesaj" => "E-posta veya şifre hatalı."];
    }
    if(!password_verify($sifre, $musteri['Sifre'])) {
        return ["basari" => false, "mesaj" => "E-posta veya şifre hatalı."];
    }
    return ["basari" => true, "musteri" => $musteri];
}
?>