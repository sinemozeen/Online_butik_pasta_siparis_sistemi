<?php
session_start();
if(!isset($_SESSION['musteri']) || $_SESSION['musteri']['Mail'] !== 'markizpastanesi@gmail.com') {
    header("Location: ../giris.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Markiz Pastanesi</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">Markiz<span> Admin</span></div>
    <ul class="nav-links">
        <li><a href="panel.php">Panel</a></li>
        <li><a href="urunler.php">Ürünler</a></li>
        <li><a href="siparisler.php">Siparişler</a></li>
        
    </ul>
    <div class="nav-actions">
        <a href="../cikis.php" class="btn-outline">Çıkış</a>
    </div>
</nav>

<div class="admin-wrapper">
    <div class="sayfa-baslik">
        <h1>Admin Paneli</h1>
        <p>Hoş geldiniz</p>
    </div>

    <div class="admin-kartlar">
        <a href="urunler.php" class="admin-ozet-kart">
            <div>
                <p class="ozet-baslik">Ürün Yönetimi</p>
                <p class="ozet-alt">Pasta ekle, düzenle, sil</p>
            </div>
        </a>
        <a href="siparisler.php" class="admin-ozet-kart">
            <div>
                <p class="ozet-baslik">Sipariş Yönetimi</p>
                <p class="ozet-alt">Siparişleri takip et</p>
            </div>
        </a>
    </div>
</div>

<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>