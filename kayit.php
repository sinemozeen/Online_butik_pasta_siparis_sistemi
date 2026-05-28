<?php
session_start();
require_once 'bl/musteri_bl.php';

if(isset($_SESSION['musteri'])) {
    header("Location: index.php");
    exit;
}

$hata = "";
$mesaj = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad           = trim($_POST['ad']);
    $soyad        = trim($_POST['soyad']);
    $telefon      = trim($_POST['telefon']);
    $mail         = trim($_POST['mail']);
    $sifre        = trim($_POST['sifre']);
    $sifre_tekrar = trim($_POST['sifre_tekrar']);
    $adres        = trim($_POST['adres']);

    $sonuc = musteri_kayit($ad, $soyad, $telefon, $mail, $sifre, $sifre_tekrar, $adres);

    if($sonuc['basari']) {
        $mesaj = $sonuc['mesaj'];
    } else {
        $hata = $sonuc['mesaj'];
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - Markiz Pastanesi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">Markiz<span> Pastanesi</span></div>
    <ul class="nav-links">
        <li><a href="index.php">Anasayfa</a></li>
        <li><a href="urunler.php">Pastalar</a></li>
    </ul>
    <div class="nav-actions">
        <a href="giris.php" class="btn-outline">Giriş yap</a>
    </div>
</nav>

<div class="auth-wrapper">
    <div class="auth-kart">
        <h2>Kayıt Ol</h2>
        <p class="auth-alt">Yeni hesap oluşturun</p>

        <?php if($mesaj): ?>
            <div class="alert alert-basari">
                <?= $mesaj ?> <a href="giris.php">Giriş yapın</a>
            </div>
        <?php endif; ?>

        <?php if($hata): ?>
            <div class="alert alert-hata"><?= $hata ?></div>
        <?php endif; ?>

        <form method="POST" action="kayit.php">
            <div class="form-grup">
                <label>Ad</label>
                <input type="text" name="ad" placeholder="Adınız" required>
            </div>
            <div class="form-grup">
                <label>Soyad</label>
                <input type="text" name="soyad" placeholder="Soyadınız" required>
            </div>
            <div class="form-grup">
                <label>Telefon</label>
                <input type="text" name="telefon" placeholder="05xxxxxxxxx" required>
            </div>
            <div class="form-grup">
                <label>E-posta</label>
                <input type="email" name="mail" placeholder="ornek@gmail.com" required>
            </div>
            <div class="form-grup">
                <label>Adres</label>
                <textarea name="adres" placeholder="Teslimat adresiniz..." rows="2" required></textarea>
            </div>
            <div class="form-grup">
                <label>Şifre</label>
                <input type="password" name="sifre" placeholder="En az 6 karakter" required>
            </div>
            <div class="form-grup">
                <label>Şifre Tekrar</label>
                <input type="password" name="sifre_tekrar" placeholder="Şifrenizi tekrar girin" required>
            </div>
            <button type="submit" class="btn-fill gonder-btn">Kayıt Ol</button>
        </form>

        <p class="auth-link">Zaten hesabınız var mı? <a href="giris.php">Giriş yapın</a></p>
    </div>
</div>

<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>