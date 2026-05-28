<?php
session_start();


if(isset($_GET['sil'])) {
    $index = (int)$_GET['sil'];
    if(isset($_SESSION['sepet'][$index])) {
        array_splice($_SESSION['sepet'], $index, 1);
    }
    header("Location: sepet.php");
    exit;
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guncelle'])) {
    foreach($_POST['adet'] as $index => $adet) {
        $adet = (int)$adet;
        if($adet > 0) {
            $_SESSION['sepet'][$index]['adet'] = $adet;
        }
    }
    header("Location: sepet.php");
    exit;
}

$sepet = isset($_SESSION['sepet']) ? $_SESSION['sepet'] : [];
$toplam = 0;
foreach($sepet as $item) {
    $toplam += $item['fiyat'] * $item['adet'];
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepet - Markiz Pastanesi</title>
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
            <?php if(!empty($sepet)): ?>
                <span class="badge"><?= count($sepet) ?></span>
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

<div class="sepet-wrapper">
    <div class="sayfa-baslik">
        <h1>Sepetim</h1>
    </div>

    <?php if(empty($sepet)): ?>
        <div class="bos-sepet">
            <p> Sepetiniz boş.</p>
            <a href="urunler.php" class="btn-fill">Pastalarımıza göz at</a>
        </div>
    <?php else: ?>
        <form method="POST" action="sepet.php">
            <table class="sepet-tablo">
                <thead>
                    <tr>
                        <th>Ürün</th>
                        <th>Birim Fiyat</th>
                        <th>Adet</th>
                        <th>Toplam</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($sepet as $index => $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['pasta_adi']) ?></td>
                        <td>₺<?= number_format($item['fiyat'], 2) ?></td>
                        <td>
                            <input type="number" name="adet[<?= $index ?>]"
                                   value="<?= $item['adet'] ?>" min="1" max="10"
                                   class="adet-input">
                        </td>
                        <td>₺<?= number_format($item['fiyat'] * $item['adet'], 2) ?></td>
                        <td>
                            <a href="sepet.php?sil=<?= $index ?>" class="sil-btn">✕</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="guncelle" class="btn-outline">Güncelle</button>
        </form>

        <div class="sepet-ozet">
            <div class="ozet-kart">
                <h3>Sipariş Özeti</h3>
                <div class="ozet-satir">
                    <span>Ara Toplam</span>
                    <span>₺<?= number_format($toplam, 2) ?></span>
                </div>
                <div class="ozet-satir">
                    <span>Teslimat</span>
                    <span>Ücretsiz</span>
                </div>
                <div class="ozet-satir toplam">
                    <span>Toplam</span>
                    <span>₺<?= number_format($toplam, 2) ?></span>
                </div>
                <a href="siparis.php" class="btn-fill gonder-btn">Siparişi Tamamla</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>