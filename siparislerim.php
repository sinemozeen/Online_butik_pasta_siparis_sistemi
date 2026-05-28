<?php
session_start();
require_once 'bl/siparis_bl.php';

if(!isset($_SESSION['musteri'])) {
    header("Location: giris.php");
    exit;
}

$musteri_id = $_SESSION['musteri']['Musteri_id'];
$siparisler = musteri_siparisleri($musteri_id);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siparişlerim - Markiz Pastanesi</title>
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
        <a href="siparislerim.php">Siparişlerim</a>
        <a href="cikis.php" class="btn-outline">Çıkış</a>
    </div>
</nav>

<div class="siparisler-wrapper">
    <div class="sayfa-baslik">
        <h1>Siparişlerim</h1>
        <p>Tüm siparişlerinizi buradan takip edebilirsiniz</p>
    </div>

    <?php if(empty($siparisler)): ?>
        <div class="bos-sepet">
            <p>Henüz siparişiniz yok.</p>
            <a href="urunler.php" class="btn-fill">Sipariş ver</a>
        </div>
    <?php else: ?>
        <?php foreach($siparisler as $siparis): ?>
        <div class="siparis-kart">
            <div class="siparis-kart-ust">
                <div>
                    <span class="siparis-no">Sipariş #<?= $siparis['Siparis_id'] ?></span>
                    <span class="siparis-tarih"><?= $siparis['SiparisTarihi'] ?></span>
                </div>
                <span class="durum-badge durum-<?= strtolower(str_replace(' ', '-', $siparis['SiparisDurumu'])) ?>">
                    <?= $siparis['SiparisDurumu'] ?>
                </span>
            </div>

          
            <?php $detaylar = siparis_detayi($siparis['Siparis_id']); ?>
            <div class="siparis-detaylar">
                <?php foreach($detaylar as $detay): ?>
                <div class="detay-satir">
                    <span> <?= htmlspecialchars($detay['PastaAdi']) ?></span>
                    <span><?= $detay['Adet'] ?> adet × ₺<?= number_format($detay['BirimFiyat'], 2) ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="siparis-kart-alt">
                <span class="siparis-toplam">
                    Toplam: ₺<?= number_format($siparis['ToplamTutar'], 2) ?>
                </span>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>