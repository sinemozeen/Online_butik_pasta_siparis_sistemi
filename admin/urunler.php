<?php
session_start();
if(!isset($_SESSION['musteri']) || $_SESSION['musteri']['Mail'] !== 'markizpastanesi@gmail.com') {
    header("Location: ../giris.php");
    exit;
}
require_once '../dal/pasta_dal.php';
require_once '../dal/db.php';

$mesaj = "";
$hata = "";


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ekle'])) {
    $resim = 'default.jpg';

if(isset($_FILES['resim']) && $_FILES['resim']['error'] === 0) {
    $uzanti = pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION);
    $yeniIsim = uniqid('pasta_') . '.' . $uzanti;
    $hedef = __DIR__ . '/../img/' . $yeniIsim;
    
    if(move_uploaded_file($_FILES['resim']['tmp_name'], $hedef)) {
        $resim = $yeniIsim;
    } else {
        $hata = "Resim yüklenemedi! Hedef: " . $hedef;
    }
}

    
    $stmt = $pdo->prepare("CALL PastaEkle(?, ?, ?, ?, 1)");
    $stmt->execute([
        (int)$_POST['kategori_id'],
        htmlspecialchars(trim($_POST['pasta_adi'])),
        htmlspecialchars(trim($_POST['aciklama'])),
        (float)$_POST['fiyat']
    ]);
    
    $stmt2 = $pdo->prepare("UPDATE Pasta SET Resim = ? WHERE Pasta_id = LAST_INSERT_ID()");
    $stmt2->execute([$resim]);
    
    $mesaj = "Ürün eklendi.";
}


if(isset($_GET['sil'])) {
    $stmt = $pdo->prepare("CALL PastaSil(?)");
    $stmt->execute([(int)$_GET['sil']]);
    $mesaj = "Ürün silindi.";
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guncelle'])) {
    $stmt = $pdo->prepare("CALL PastaGuncelle(?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        (int)$_POST['pasta_id'],
        (int)$_POST['kategori_id'],
        htmlspecialchars(trim($_POST['pasta_adi'])),
        htmlspecialchars(trim($_POST['aciklama'])),
        (float)$_POST['fiyat'],
        isset($_POST['mevcutmu']) ? 1 : 0
    ]);
    $mesaj = "Ürün güncellendi.";
}

$pastalar = pastalari_listele();
$kategoriler = kategorileri_listele();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Yönetimi - Admin</title>
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
        <h1>Ürün Yönetimi</h1>
    </div>

    <?php if($mesaj): ?>
        <div class="alert alert-basari"><?= $mesaj ?></div>
    <?php endif; ?>
    <?php if($hata): ?>
        <div class="alert alert-hata"><?= $hata ?></div>
    <?php endif; ?>

    
    <div class="form-kart">
        <h3>Yeni Ürün Ekle</h3>
        <form method="POST" action="urunler.php" enctype="multipart/form-data">
            <div class="admin-form-grid">
                <div class="form-grup">
                    <label>Kategori</label>
                    <select name="kategori_id" required>
                        <?php foreach($kategoriler as $kat): ?>
                            <option value="<?= $kat['Kategori_id'] ?>">
                                <?= htmlspecialchars($kat['KategoriAdi']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-grup">
                    <label>Pasta Adı</label>
                    <input type="text" name="pasta_adi" placeholder="Pasta adı" required>
                </div>
                <div class="form-grup">
                    <label>Açıklama</label>
                    <input type="text" name="aciklama" placeholder="Açıklama">
                </div>
                <div class="form-grup">
                    <label>Fiyat (₺)</label>
                    <input type="number" name="fiyat" step="0.01" min="0" placeholder="0.00" required>
                </div>
                <div class="form-grup">
                    <label>Ürün Resmi</label>
                    <input type="file" name="resim" accept="image/*">
                </div>
            </div>
            <button type="submit" name="ekle" class="btn-fill">Ekle</button>
        </form>
    </div>

    
    <div class="form-kart">
        <h3>Mevcut Ürünler</h3>
        <table class="admin-tablo">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Resim</th>
                    <th>Pasta Adı</th>
                    <th>Açıklama</th>
                    <th>Fiyat</th>
                    <th>Mevcut</th>
                    <th>İşlem</th>
                    <th>Sil</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pastalar as $pasta): ?>
                <tr>
                    <form method="POST" action="urunler.php">
                    <input type="hidden" name="pasta_id" value="<?= $pasta['Pasta_id'] ?>">
                    <td><?= $pasta['Pasta_id'] ?></td>
                    <td>
                        <?php if(!empty($pasta['Resim']) && $pasta['Resim'] !== 'default.jpg'): ?>
                            <img src="../img/<?= htmlspecialchars($pasta['Resim']) ?>"
                                 style="width:50px; height:50px; object-fit:cover; border-radius:6px;">
                        <?php endif; ?>
                    </td>
                    <td>
                        <input type="text" name="pasta_adi"
                               value="<?= htmlspecialchars($pasta['PastaAdi']) ?>"
                               class="tablo-input">
                    </td>
                    <td>
                        <input type="text" name="aciklama"
                               value="<?= htmlspecialchars($pasta['Aciklama']) ?>"
                               class="tablo-input">
                    </td>
                    <td>
                        <input type="number" name="fiyat" step="0.01"
                               value="<?= $pasta['Fiyat'] ?>"
                               class="tablo-input kisa">
                    </td>
                    <td>
                        <input type="hidden" name="kategori_id" value="<?= $pasta['Kategori_id'] ?>">
                        <input type="checkbox" name="mevcutmu" <?= $pasta['MevcutMu'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <button type="submit" name="guncelle" class="btn-outline kucuk">Kaydet</button>
                    </td>
                    </form>
                    <td>
                        <a href="urunler.php?sil=<?= $pasta['Pasta_id'] ?>"
                           onclick="return confirm('Silmek istediğinize emin misiniz?')"
                           class="sil-btn">Sil</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="footer">
    <p>© 2026 Markiz Pastanesi</p>
</footer>

</body>
</html>