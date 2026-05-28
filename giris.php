<?php
session_start();
require_once 'bl/musteri_bl.php';

if(isset($_SESSION['musteri'])) {
    header("Location: index.php");
    exit;
}

$hata = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail  = trim($_POST['mail']);
    $sifre = trim($_POST['sifre']);

    $sonuc = musteri_giris($mail, $sifre);

    if($sonuc['basari']) {
    $_SESSION['musteri'] = $sonuc['musteri'];
    if($sonuc['musteri']['Mail'] === 'markizpastanesi@gmail.com') {
        header("Location: admin/panel.php");
    } else {
        header("Location: index.php");
    }
    exit;
}else {
        $hata = $sonuc['mesaj'];
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş - Markiz Pastanesi</title>
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
        <a href="kayit.php" class="btn-fill">Kayıt ol</a>
    </div>
</nav>

<div class="auth-wrapper">
    <div class="auth-kart">
        <h2>Giriş Yap</h2>
        <p class="auth-alt">Hesabınıza giriş yapın</p>

        <?php if($hata): ?>
            <div class="alert alert-hata"><?= $hata ?></div>
        <?php endif; ?>

        <form method="POST" action="giris.php">
            <div class="form-grup">
                <label>E-posta</label>
                <input type="email" name="mail" placeholder="ornek@mail.com" required>
            </div>
            <div class="form-grup">
                <label>Şifre</label>
                <input type="password" name="sifre" placeholder="Şifreniz" required>
            </div>
            <button type="submit" class="btn-fill gonder-btn">Giriş Yap</button>
        </form>

        <p class="auth-link">Hesabınız yok mu? <a href="kayit.php">Kayıt olun</a></p>
    </div>
</div>

<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>