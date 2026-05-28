<?php
session_start();
if(!isset($_SESSION['musteri']) || $_SESSION['musteri']['Mail'] !== 'markizpastanesi@gmail.com') {
    header("Location: ../giris.php");
    exit;
}

require_once '../dal/db.php';
require_once '../dal/siparis_dal.php';

$mesaj = "";


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['durum_guncelle'])) {
    $siparis_id = (int)$_POST['siparis_id'];
    $durum = $_POST['durum'];
    
  
    $stmt = $pdo->prepare("CALL SiparisTutarGetir(?)");
$stmt->execute([$siparis_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$tutar = $row['ToplamTutar'];
    
    // Sonra güncelle
    $stmt = $pdo->prepare("CALL SiparisGuncelle(?, ?, ?)");
    $stmt->execute([$siparis_id, $tutar, $durum]);
    $mesaj = "Sipariş durumu güncellendi.";
}


require_once '../dal/siparis_dal.php';
$siparisler = tum_siparisleri_getir();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Yönetimi - Admin</title>
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
        <h1>Sipariş Yönetimi</h1>
    </div>

    <?php if($mesaj): ?>
        <div class="alert alert-basari"><?= $mesaj ?></div>
    <?php endif; ?>

    <div class="form-kart">
        <table class="admin-tablo">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Müşteri</th>
                    <th>Tarih</th>
                    <th>Toplam</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($siparisler as $siparis): ?>
                <tr>
                    <td><?= $siparis['Siparis_id'] ?></td>
                    <td><?= htmlspecialchars($siparis['MusteriAdi']) ?></td>
                    <td><?= $siparis['SiparisTarihi'] ?></td>
                    <td>₺<?= number_format($siparis['ToplamTutar'], 2) ?></td>
                    <td>
                        <span class="durum-badge durum-<?= strtolower(str_replace(' ', '-', $siparis['SiparisDurumu'])) ?>">
                            <?= $siparis['SiparisDurumu'] ?>
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="siparisler.php" style="display:flex; gap:6px;">
                            <input type="hidden" name="siparis_id" value="<?= $siparis['Siparis_id'] ?>">
                            <select name="durum" class="tablo-input">
                                <option <?= $siparis['SiparisDurumu'] == 'Hazirlaniyor' ? 'selected' : '' ?>>Hazirlaniyor</option>
                                <option <?= $siparis['SiparisDurumu'] == 'Yolda' ? 'selected' : '' ?>>Yolda</option>
                                <option <?= $siparis['SiparisDurumu'] == 'Teslim Edildi' ? 'selected' : '' ?>>Teslim Edildi</option>
                                <option <?= $siparis['SiparisDurumu'] == 'Iptal' ? 'selected' : '' ?>>Iptal</option>
                            </select>
                            <button type="submit" name="durum_guncelle" class="btn-fill kucuk">Güncelle</button>
                        </form>
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