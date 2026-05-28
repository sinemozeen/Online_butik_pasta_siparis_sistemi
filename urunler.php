<?php
session_start();
require_once 'bl/pasta_bl.php';

$kategoriler = kategorileri_getir();

// Kategori filtresi
$secili_kategori = isset($_GET['kategori']) ? (int)$_GET['kategori'] : null;

if ($secili_kategori) {
    $pastalar = kategoriye_gore_getir($secili_kategori);
} else {
    $pastalar = pastalari_getir();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastalar - Markiz Pastanesi</title>
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
            <?php if(isset($_SESSION['sepet']) && count($_SESSION['sepet']) > 0): ?>
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


<div class="sayfa-baslik">
    <h1>Pastalarımız</h1>
    <p>Özel günleriniz için el yapımı pastalar</p>
</div>


<section class="kategoriler">
    <div class="kategori-listesi">
        <a href="urunler.php" class="kategori-chip <?= !$secili_kategori ? 'aktif' : '' ?>">
            Tümü
        </a>
        <?php foreach($kategoriler as $kat): ?>
            <a href="urunler.php?kategori=<?= $kat['Kategori_id'] ?>"
               class="kategori-chip <?= $secili_kategori == $kat['Kategori_id'] ? 'aktif' : '' ?>">
                <?= htmlspecialchars($kat['KategoriAdi']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="urunler">
    <?php if(empty($pastalar)): ?>
        <p class="bos-mesaj">Bu kategoride ürün bulunamadı.</p>
    <?php else: ?>
        <div class="pasta-grid">
            <?php foreach($pastalar as $pasta): ?>
                <?php if($pasta['MevcutMu']): ?>
                <div class="pasta-kart">
                    <div class="pasta-resim">
                       <?php if(!empty($pasta['Resim']) && $pasta['Resim'] !== 'default.jpg'): ?>
                       <img src="img/<?= htmlspecialchars($pasta['Resim']) ?>" alt="<?= htmlspecialchars($pasta['PastaAdi']) ?>">
                       <?php endif; ?>
                    </div>
                    <div class="pasta-bilgi">
                        <h3><?= htmlspecialchars($pasta['PastaAdi']) ?></h3>
                        <p><?= htmlspecialchars($pasta['Aciklama']) ?></p>
                        <div class="pasta-alt">
                            <span class="fiyat">₺<?= number_format($pasta['Fiyat'], 2) ?></span>
                            <a href="urun_detay.php?id=<?= $pasta['Pasta_id'] ?>" class="btn-fill kucuk">
                                İncele
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>


<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>