<?php
session_start();
require_once 'bl/pasta_bl.php';

$pastalar = pastalari_getir();
$kategoriler = kategorileri_getir();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markiz Pastanesi</title>
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
        <a href="sepet.php" class="btn-outline">
            Sepetim
            <?php if(isset($_SESSION['sepet'])): ?>
                <span class="badge"><?= count($_SESSION['sepet']) ?></span>
            <?php endif; ?>
        </a>
        <?php if(isset($_SESSION['musteri'])): ?>
            <a href="siparislerim.php">Siparişlerim</a>
            <a href="cikis.php" class="btn-outline">Çıkış</a>
        <?php else: ?>
            <a href="giris.php" class="btn-outline">Giriş</a>
            <a href="kayit.php" class="btn-fill">Kayıt ol</a>
        <?php endif; ?>
    </div>
</nav>


<section class="hero">
    <div class="hero-text">
        <h1>Özel günleriniz için<br>el yapımı pastalar</h1>
        <p>Doğum günü, düğün, nişan ve daha fazlası...</p>
        <a href="urunler.php" class="btn-fill">Siparişe başla</a>
    </div>
    <div class="hero-img"></div>
</section>


<section class="kategoriler">
    <h2>Kategoriler</h2>
    <div class="kategori-listesi">
        <a href="urunler.php" class="kategori-chip aktif">Tümü</a>
        <?php foreach($kategoriler as $kat): ?>
            <a href="urunler.php?kategori=<?= $kat['Kategori_id'] ?>" class="kategori-chip">
                <?= htmlspecialchars($kat['KategoriAdi']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>


<section class="urunler">
    <h2>Öne Çıkan Pastalar</h2>
    <div class="pasta-grid" class="pasta-grid" style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
        <?php foreach(array_slice($pastalar, 0, 6) as $pasta): ?>
            <?php if($pasta['MevcutMu']): ?>
            <div class="pasta-kart">
                <div class="pasta-resim">
                   <?php if(!empty($pasta['Resim']) && $pasta['Resim'] !== 'default.jpg'): ?>
                     <img src="img/<?= htmlspecialchars($pasta['Resim']) ?>" alt="<?= htmlspecialchars($pasta['PastaAdi']) ?>" >                    
                    <?php endif; ?>
                </div>
                <div class="pasta-bilgi">
                    <h3><?= htmlspecialchars($pasta['PastaAdi']) ?></h3>
                    <p><?= htmlspecialchars($pasta['Aciklama']) ?></p>
                    <div class="pasta-alt">
                        <span class="fiyat">₺<?= number_format($pasta['Fiyat'], 2) ?></span>
                        <a href="urun_detay.php?id=<?= $pasta['Pasta_id'] ?>" class="btn-fill kucuk">İncele</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>


<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>