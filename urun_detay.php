<?php
session_start();
require_once 'bl/pasta_bl.php';
require_once 'bl/yorum_bl.php';

if(!isset($_GET['id'])) {
    header("Location: urunler.php");
    exit;
}

$pasta_id = (int)$_GET['id'];
$pasta = pasta_detay_getir($pasta_id);

if(!$pasta) {
    header("Location: urunler.php");
    exit;
}

$yorumlar = yorumlari_getir($pasta_id);
$ortalama = ortalama_puan_getir($pasta_id);
$mesaj = "";
$hata = "";


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['yorum_gonder'])) {
    if(!isset($_SESSION['musteri'])) {
        header("Location: giris.php");
        exit;
    }
    $puan       = (int)$_POST['puan'];
    $yorum_metni = htmlspecialchars(trim($_POST['yorum_metni']));
    $sonuc = yorum_gonder($_SESSION['musteri']['Musteri_id'], $pasta_id, $puan, $yorum_metni);

    if($sonuc['basari']) {
        $mesaj = $sonuc['mesaj'];
        $yorumlar = yorumlari_getir($pasta_id);
        $ortalama = ortalama_puan_getir($pasta_id);
    } else {
        $hata = $sonuc['mesaj'];
    }
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sepete_ekle'])) {
    if(!isset($_SESSION['sepet'])) {
        $_SESSION['sepet'] = [];
    }
    $adet = (int)$_POST['adet'];
    $bulundu = false;
    foreach($_SESSION['sepet'] as &$item) {
        if($item['pasta_id'] == $pasta_id) {
            $item['adet'] += $adet;
            $bulundu = true;
            break;
        }
    }
    if(!$bulundu) {
        $_SESSION['sepet'][] = [
            'pasta_id' => $pasta_id,
            'pasta_adi' => $pasta['PastaAdi'],
            'fiyat' => $pasta['Fiyat'],
            'adet' => $adet
        ];
    }
    $mesaj = "Ürün sepete eklendi!";
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pasta['PastaAdi']) ?> - Markiz Pastanesi</title>
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

<div class="detay-wrapper">

    <?php if($mesaj): ?>
        <div class="alert alert-basari"><?= $mesaj ?></div>
    <?php endif; ?>
    <?php if($hata): ?>
        <div class="alert alert-hata"><?= $hata ?></div>
    <?php endif; ?>

  
    <div class="detay-kart" style="display:flex; gap:24px; align-items:flex-start;">
    <div style="flex-shrink:0;">
        <?php if(!empty($pasta['Resim']) && $pasta['Resim'] !== 'default.jpg'): ?>
            <img src="img/<?= htmlspecialchars($pasta['Resim']) ?>" 
                 width="200" 
                 height="200"
                 style="object-fit:cover; border-radius:12px;"
                 alt="<?= htmlspecialchars($pasta['PastaAdi']) ?>">
        <?php else: ?>
            <div style="width:200px; height:200px; background:#fbeaf0; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:52px;">🎂</div>
        <?php endif; ?>
    </div>
        <div class="detay-bilgi">
            <h1><?= htmlspecialchars($pasta['PastaAdi']) ?></h1>
            <p class="detay-aciklama"><?= htmlspecialchars($pasta['Aciklama']) ?></p>
            <div class="detay-puan">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <span style="color: <?= $i <= $ortalama ? '#ef9f27' : '#ddd' ?>">★</span>
                <?php endfor; ?>
                <span class="puan-sayi">(<?= number_format($ortalama, 1) ?>)</span>
            </div>
            <div class="detay-fiyat">₺<?= number_format($pasta['Fiyat'], 2) ?></div>

            <form method="POST" action="urun_detay.php?id=<?= $pasta_id ?>">
                <div class="form-grup adet-grup">
                    <label>Adet</label>
                    <input type="number" name="adet" value="1" min="1" max="10">
                </div>
                <button type="submit" name="sepete_ekle" class="btn-fill gonder-btn">
                   Sepete Ekle
                </button>
            </form>
        </div>
    </div>




   
    <div class="yorumlar-bolum">
        <h2>Yorumlar (<?= count($yorumlar) ?>)</h2>

        <?php if(empty($yorumlar)): ?>
            <p class="bos-mesaj">Henüz yorum yapılmamış.</p>
        <?php else: ?>
            <?php foreach($yorumlar as $yorum): ?>
            <div class="yorum-kart">
                <div class="yorum-ust">
                    <span class="yorum-isim">
                        <?= htmlspecialchars($yorum['Ad']) ?> <?= htmlspecialchars($yorum['Soyad']) ?>
                    </span>
                    <span class="yorum-tarih"><?= $yorum['YorumTarihi'] ?></span>
                </div>
                <div class="yorum-puan">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <span style="color: <?= $i <= $yorum['Puan'] ? '#ef9f27' : '#ddd' ?>">★</span>
                    <?php endfor; ?>
                </div>
                <p class="yorum-metin"><?= htmlspecialchars($yorum['YorumMetni']) ?></p>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        
        <?php if(isset($_SESSION['musteri'])): ?>
        <div class="yorum-form-bolum">
            <h3>Yorum Yap</h3>
            <form method="POST" action="urun_detay.php?id=<?= $pasta_id ?>">
                <div class="form-grup">
                    <label>Puanınız</label>
                    <select name="puan" required>
                        <option value="5">★★★★★ (5)</option>
                        <option value="4">★★★★☆ (4)</option>
                        <option value="3">★★★☆☆ (3)</option>
                        <option value="2">★★☆☆☆ (2)</option>
                        <option value="1">★☆☆☆☆ (1)</option>
                    </select>
                </div>
                <div class="form-grup">
                    <label>Yorumunuz</label>
                    <textarea name="yorum_metni" rows="3" placeholder="Deneyiminizi paylaşın..." required></textarea>
                </div>
                <button type="submit" name="yorum_gonder" class="btn-fill">Yorum Gönder</button>
            </form>
        </div>
        <?php else: ?>
            <p class="auth-link">Yorum yapmak için <a href="giris.php">giriş yapın</a></p>
        <?php endif; ?>
    </div>

</div>

<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>