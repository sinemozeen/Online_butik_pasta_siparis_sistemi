<?php
session_start();
require_once 'bl/siparis_bl.php';

if(!isset($_SESSION['musteri'])) {
    header("Location: giris.php");
    exit;
}

if(empty($_SESSION['sepet'])) {
    header("Location: sepet.php");
    exit;
}

$musteri = $_SESSION['musteri'];
$sepet = $_SESSION['sepet'];
$toplam = 0;
foreach($sepet as $item) {
    $toplam += $item['fiyat'] * $item['adet'];
}

$hata = "";
$mesaj = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $odeme_turu = $_POST['odeme_turu'];
    $adres      = htmlspecialchars(trim($_POST['adres']));

    $sonuc = siparis_olustur($musteri['Musteri_id'], $sepet, $odeme_turu, $adres);

    if($sonuc['basari']) {
        $_SESSION['sepet'] = [];
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
    <title>Sipariş Ver - Markiz Pastanesi</title>
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
        <?php if(isset($_SESSION['musteri'])): ?>
            <a href="siparislerim.php">Siparişlerim</a>
            <a href="cikis.php" class="btn-outline">Çıkış</a>
        <?php endif; ?>
    </div>
</nav>

<div class="siparis-wrapper">
    <div class="sayfa-baslik">
        <h1>Siparişi Tamamla</h1>
    </div>

    <?php if($mesaj): ?>
        <div class="alert alert-basari">
            <?= $mesaj ?> <a href="siparislerim.php">Siparişlerime git</a>
        </div>
    <?php endif; ?>

    <?php if($hata): ?>
        <div class="alert alert-hata"><?= $hata ?></div>
    <?php endif; ?>

    <?php if(!$mesaj): ?>
    <div class="siparis-grid">

        <!-- SİPARİŞ FORMU -->
        <div class="siparis-form-bolum">
            <form method="POST" action="siparis.php">

                <div class="form-kart">
                    <h3>Teslimat Bilgileri</h3>
                    <div class="form-grup">
                        <label>Teslimat Adresi</label>
                        <textarea name="adres" rows="3" required
                            placeholder="Teslimat adresinizi girin..."><?= htmlspecialchars($musteri['Adres']) ?></textarea>
                    </div>
                </div>

                <div class="form-kart">
                    <h3>Ödeme Yöntemi</h3>
                    <div class="odeme-secenekler">
                        <label class="odeme-label">
                            <input type="radio" name="odeme_turu" value="Kredi Karti" required>
                            Kredi Kartı
                        </label>
                        <label class="odeme-label">
                            <input type="radio" name="odeme_turu" value="Havale">
                             Havale / EFT
                        </label>
                        <label class="odeme-label">
                            <input type="radio" name="odeme_turu" value="Kapida Odeme">
                            Kapıda Ödeme
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-fill gonder-btn">
                    Siparişi Onayla (₺<?= number_format($toplam, 2) ?>)
                </button>
            </form>
        </div>

       
        <div class="ozet-kart">
            <h3>Sipariş Özeti</h3>
            <?php foreach($sepet as $item): ?>
            <div class="ozet-urun">
                <span><?= htmlspecialchars($item['pasta_adi']) ?> x<?= $item['adet'] ?></span>
                <span>₺<?= number_format($item['fiyat'] * $item['adet'], 2) ?></span>
            </div>
            <?php endforeach; ?>
            <div class="ozet-satir toplam">
                <span>Toplam</span>
                <span>₺<?= number_format($toplam, 2) ?></span>
            </div>
        </div>

    </div>
    <?php endif; ?>
</div>

<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>