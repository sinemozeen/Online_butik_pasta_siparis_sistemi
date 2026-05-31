-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 31 May 2026, 17:36:53
-- Sunucu sürümü: 8.0.45
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `butik_pasta_sistemi`
--

DELIMITER $$
--
-- Yordamlar
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `KategoriEkle` (IN `p_KategoriAdi` VARCHAR(100))   BEGIN
    INSERT INTO Kategori(KategoriAdi) VALUES(p_KategoriAdi);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `KategoriGuncelle` (IN `p_Kategori_id` INT, IN `p_KategoriAdi` VARCHAR(100))   BEGIN
    UPDATE Kategori
    SET KategoriAdi=p_KategoriAdi
    WHERE Kategori_id=p_Kategori_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `KategoriListele` ()   BEGIN
    SELECT * FROM Kategori;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `KategoriSil` (IN `p_Kategori_id` INT)   BEGIN
    DELETE FROM Kategori WHERE Kategori_id=p_Kategori_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MusteriEkle` (IN `p_Ad` VARCHAR(50), IN `p_Soyad` VARCHAR(50), IN `p_Telefon` VARCHAR(15), IN `p_Mail` VARCHAR(100), IN `p_Sifre` VARCHAR(100), IN `p_Adres` VARCHAR(250))   BEGIN
    INSERT INTO Musteri(Ad,Soyad,Telefon,Mail,Sifre,Adres)
    VALUES(p_Ad,p_Soyad,p_Telefon,p_Mail,p_Sifre,p_Adres);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MusteriGetirByMail` (IN `p_Mail` VARCHAR(100))   BEGIN
    SELECT * FROM Musteri WHERE Mail = p_Mail;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MusteriGuncelle` (IN `p_Musteri_id` INT, IN `p_Telefon` VARCHAR(15), IN `p_Adres` VARCHAR(250))   BEGIN
    UPDATE Musteri
    SET Telefon=p_Telefon, Adres=p_Adres
    WHERE Musteri_id=p_Musteri_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MusteriListele` ()   BEGIN
    SELECT * FROM Musteri;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MusteriSil` (IN `p_Musteri_id` INT)   BEGIN
    DELETE FROM Musteri WHERE Musteri_id=p_Musteri_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `OdemeEkle` (IN `p_Siparis_id` INT, IN `p_OdemeTarihi` DATE, IN `p_OdemeTutari` DECIMAL(10,2), IN `p_OdemeTuru` VARCHAR(30), IN `p_OdemeDurumu` VARCHAR(30))   BEGIN
    INSERT INTO Odeme(Siparis_id,OdemeTarihi,OdemeTutari,OdemeTuru,OdemeDurumu)
    VALUES(p_Siparis_id,p_OdemeTarihi,p_OdemeTutari,p_OdemeTuru,p_OdemeDurumu);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `OdemeGuncelle` (IN `p_Odeme_id` INT, IN `p_OdemeTutari` DECIMAL(10,2), IN `p_OdemeTuru` VARCHAR(30), IN `p_OdemeDurumu` VARCHAR(30))   BEGIN
    UPDATE Odeme
    SET OdemeTutari=p_OdemeTutari,
        OdemeTuru=p_OdemeTuru,
        OdemeDurumu=p_OdemeDurumu
    WHERE Odeme_id=p_Odeme_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `OdemeListele` ()   BEGIN
    SELECT * FROM Odeme;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `OdemeSil` (IN `p_Odeme_id` INT)   BEGIN
    DELETE FROM Odeme WHERE Odeme_id=p_Odeme_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PastaEkle` (IN `p_Kategori_id` INT, IN `p_PastaAdi` VARCHAR(100), IN `p_Aciklama` VARCHAR(255), IN `p_Fiyat` DECIMAL(10,2), IN `p_MevcutMu` BOOLEAN)   BEGIN
    INSERT INTO Pasta(Kategori_id,PastaAdi,Aciklama,Fiyat,MevcutMu)
    VALUES(p_Kategori_id,p_PastaAdi,p_Aciklama,p_Fiyat,p_MevcutMu);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PastaGetirById` (IN `p_Pasta_id` INT)   BEGIN
    SELECT * FROM Pasta WHERE Pasta_id = p_Pasta_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PastaGetirByKategori` (IN `p_Kategori_id` INT)   BEGIN
    SELECT * FROM Pasta WHERE Kategori_id = p_Kategori_id AND MevcutMu = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PastaGuncelle` (IN `p_Pasta_id` INT, IN `p_Kategori_id` INT, IN `p_PastaAdi` VARCHAR(100), IN `p_Aciklama` VARCHAR(255), IN `p_Fiyat` DECIMAL(10,2), IN `p_Stok` INT, IN `p_MevcutMu` BOOLEAN)   BEGIN
    UPDATE Pasta
    SET Kategori_id=p_Kategori_id,
        PastaAdi=p_PastaAdi,
        Aciklama=p_Aciklama,
        Fiyat=p_Fiyat,
        Stok=p_Stok,
        MevcutMu=p_MevcutMu
    WHERE Pasta_id=p_Pasta_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PastaListele` ()   BEGIN
    SELECT * FROM Pasta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PastaSil` (IN `p_Pasta_id` INT)   BEGIN
    DELETE FROM Pasta WHERE Pasta_id=p_Pasta_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisDetayEkle` (IN `p_Siparis_id` INT, IN `p_Pasta_id` INT, IN `p_Adet` INT, IN `p_BirimFiyat` DECIMAL(10,2))   BEGIN
    INSERT INTO SiparisDetay(Siparis_id,Pasta_id,Adet,BirimFiyat)
    VALUES(p_Siparis_id,p_Pasta_id,p_Adet,p_BirimFiyat);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisDetayGetir` (IN `p_Siparis_id` INT)   BEGIN
    SELECT sd.*, p.PastaAdi 
    FROM SiparisDetay sd 
    JOIN Pasta p ON sd.Pasta_id = p.Pasta_id 
    WHERE sd.Siparis_id = p_Siparis_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisDetayGuncelle` (IN `p_SiparisDetay_id` INT, IN `p_Adet` INT, IN `p_BirimFiyat` DECIMAL(10,2))   BEGIN
    UPDATE SiparisDetay
    SET Adet=p_Adet,
        BirimFiyat=p_BirimFiyat
    WHERE SiparisDetay_id=p_SiparisDetay_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisDetayListele` ()   BEGIN
    SELECT * FROM SiparisDetay;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisDetaySil` (IN `p_SiparisDetay_id` INT)   BEGIN
    DELETE FROM SiparisDetay WHERE SiparisDetay_id=p_SiparisDetay_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisEkle` (IN `p_Musteri_id` INT, IN `p_SiparisTarihi` DATE, IN `p_ToplamTutar` DECIMAL(10,2), IN `p_SiparisDurumu` VARCHAR(30))   BEGIN
    INSERT INTO Siparis(Musteri_id,SiparisTarihi,ToplamTutar,SiparisDurumu)
    VALUES(p_Musteri_id,p_SiparisTarihi,p_ToplamTutar,p_SiparisDurumu);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisGuncelle` (IN `p_Siparis_id` INT, IN `p_ToplamTutar` DECIMAL(10,2), IN `p_SiparisDurumu` VARCHAR(30))   BEGIN
    UPDATE Siparis
    SET ToplamTutar=p_ToplamTutar,
        SiparisDurumu=p_SiparisDurumu
    WHERE Siparis_id=p_Siparis_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisListele` ()   BEGIN
    SELECT * FROM Siparis;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisListeleHepsi` ()   BEGIN
    SELECT s.*, CONCAT(m.Ad, ' ', m.Soyad) AS MusteriAdi 
    FROM Siparis s 
    JOIN Musteri m ON s.Musteri_id = m.Musteri_id 
    ORDER BY s.SiparisTarihi DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisSil` (IN `p_Siparis_id` INT)   BEGIN
    DELETE FROM Siparis WHERE Siparis_id=p_Siparis_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SiparisTutarGetir` (IN `p_Siparis_id` INT)   BEGIN
    SELECT ToplamTutar FROM Siparis WHERE Siparis_id = p_Siparis_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TeslimatEkle` (IN `p_Siparis_id` INT, IN `p_TeslimatAdresi` VARCHAR(255), IN `p_TeslimatTarihi` DATE, IN `p_TeslimatDurumu` VARCHAR(30))   BEGIN
    INSERT INTO Teslimat(Siparis_id,TeslimatAdresi,TeslimatTarihi,TeslimatDurumu)
    VALUES(p_Siparis_id,p_TeslimatAdresi,p_TeslimatTarihi,p_TeslimatDurumu);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TeslimatGuncelle` (IN `p_Teslimat_id` INT, IN `p_TeslimatTarihi` DATE, IN `p_TeslimatDurumu` VARCHAR(30))   BEGIN
    UPDATE Teslimat
    SET TeslimatTarihi=p_TeslimatTarihi,
        TeslimatDurumu=p_TeslimatDurumu
    WHERE Teslimat_id=p_Teslimat_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TeslimatListele` ()   BEGIN
    SELECT * FROM Teslimat;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TeslimatSil` (IN `p_Teslimat_id` INT)   BEGIN
    DELETE FROM Teslimat WHERE Teslimat_id=p_Teslimat_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `YorumEkle` (IN `p_Musteri_id` INT, IN `p_Pasta_id` INT, IN `p_Puan` INT, IN `p_YorumMetni` VARCHAR(255), IN `p_YorumTarihi` DATE)   BEGIN
    INSERT INTO Yorum(Musteri_id,Pasta_id,Puan,YorumMetni,YorumTarihi)
    VALUES(p_Musteri_id,p_Pasta_id,p_Puan,p_YorumMetni,p_YorumTarihi);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `YorumGuncelle` (IN `p_Yorum_id` INT, IN `p_Puan` INT, IN `p_YorumMetni` VARCHAR(255))   BEGIN
    UPDATE Yorum
    SET Puan=p_Puan,
        YorumMetni=p_YorumMetni
    WHERE Yorum_id=p_Yorum_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `YorumKontrol` (IN `p_Musteri_id` INT, IN `p_Pasta_id` INT)   BEGIN
    SELECT COUNT(*) AS sayi 
    FROM Siparis s
    JOIN SiparisDetay sd ON s.Siparis_id = sd.Siparis_id
    WHERE s.Musteri_id = p_Musteri_id 
    AND sd.Pasta_id = p_Pasta_id 
    AND s.SiparisDurumu = 'Teslim Edildi';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `YorumListele` ()   BEGIN
    SELECT * FROM Yorum;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `YorumListeleByPasta` (IN `p_Pasta_id` INT)   BEGIN
    SELECT y.*, m.Ad, m.Soyad 
    FROM Yorum y 
    JOIN Musteri m ON y.Musteri_id = m.Musteri_id 
    WHERE y.Pasta_id = p_Pasta_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `YorumSil` (IN `p_Yorum_id` INT)   BEGIN
    DELETE FROM Yorum WHERE Yorum_id=p_Yorum_id;
END$$

--
-- İşlevler
--
CREATE DEFINER=`root`@`localhost` FUNCTION `OrtalamaPuanHesapla` (`p_Pasta_id` INT) RETURNS DECIMAL(3,2) DETERMINISTIC BEGIN
    DECLARE ortalama DECIMAL(3,2);
    SELECT AVG(Puan)
    INTO ortalama
    FROM Yorum
    WHERE Pasta_id = p_Pasta_id;
    RETURN IFNULL(ortalama, 0);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `SiparisToplamHesapla` (`p_Siparis_id` INT) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
    DECLARE toplam DECIMAL(10,2);
    SELECT SUM(Adet * BirimFiyat)
    INTO toplam
    FROM SiparisDetay
    WHERE Siparis_id = p_Siparis_id;
    RETURN IFNULL(toplam, 0);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `Kategori_id` int NOT NULL,
  `KategoriAdi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`Kategori_id`, `KategoriAdi`) VALUES
(1, 'Doğum Günü Pastası'),
(2, 'Düğün Pastası'),
(3, 'Nişan Pastası'),
(4, 'Özel Tasarım Pasta');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteri`
--

CREATE TABLE `musteri` (
  `Musteri_id` int NOT NULL,
  `Ad` varchar(50) NOT NULL,
  `Soyad` varchar(50) NOT NULL,
  `Telefon` varchar(15) NOT NULL,
  `Mail` varchar(100) NOT NULL,
  `Sifre` varchar(100) NOT NULL,
  `Adres` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `musteri`
--

INSERT INTO `musteri` (`Musteri_id`, `Ad`, `Soyad`, `Telefon`, `Mail`, `Sifre`, `Adres`) VALUES
(1, 'Admin', 'Markiz', '05466393782', 'markizpastanesi@gmail.com', '$2y$10$0bm5uFH8VaKZtFdMxZz6ROvqhaUQal2sxfDsvDKAZGi4hqnqrqoVy', 'Markiz Pastane'),
(2, 'sinem', 'özen', '05466393781', 'sinemozen258@gmail.com', '$2y$10$edZJK2lljSJa.Rog4SCvqebbM96EvC4fB3DPWDN7ABgiqieII77x.', 'istanbul sancaktepe'),
(3, 'aden', 'uzun', '05466393781', 'adenuzun@gmail.com', '$2y$10$BzdkhvHoenB3E1PAKo3m7.NuLlKs2HKm65Py.O3xZaLU2UYocsI6q', 'istanbul sancaktepe'),
(4, 'Tuğba', 'Uzun', '05466393780', 'tugbauzun@gmail.com', '$2y$10$04YfVmmLIfC5chdJdPvoneK4Lr9cjlMwTrf1n9S6bpFGclXENk0cG', 'Kızılay caddesi Eyüp Sultan mah. Mühendis sk. Bina no 6 daire no 4'),
(5, 'ali', 'veli', '05466393780', 'aliveli@gmail.com', '$2y$10$yfK9WifyDlo/6ZVCAbihPeMftc0DukPtazHZiksdgIhrT0q7JwH6.', 'istanbul'),
(6, 'veli', 'ali', '05466378212', 'veliali@gmail.com', '$2y$10$9gPB9Mf4Zht5dEtHUJXIKO90R5NHk/KVFk4ZatTDfKxa0ED0xzAK2', 'bartın'),
(7, 'veli', 'inan', '05466573423', 'veliinan@gmail.com', '$2y$10$bbjfVmOn5jItAmaJ8P9w/.YsSFi04lGES7ontPnBPzBjqCF6nG5E2', 'zonguldak'),
(8, 'ali', 'inan', '05466393785', 'aliinan@gmail.com', '$2y$10$Q1UzEMreHtYwQJJu2D9FKeHJKMM4BEbLh0fLOhRNrDVFPwSww75ou', 'zonguldak');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `odeme`
--

CREATE TABLE `odeme` (
  `Odeme_id` int NOT NULL,
  `Siparis_id` int NOT NULL,
  `OdemeTarihi` date NOT NULL,
  `OdemeTutari` decimal(10,2) NOT NULL,
  `OdemeTuru` varchar(30) NOT NULL,
  `OdemeDurumu` varchar(30) NOT NULL DEFAULT 'Beklemede'
) ;

--
-- Tablo döküm verisi `odeme`
--

INSERT INTO `odeme` (`Odeme_id`, `Siparis_id`, `OdemeTarihi`, `OdemeTutari`, `OdemeTuru`, `OdemeDurumu`) VALUES
(6, 9, '2026-05-28', 2000.00, 'Kredi Karti', 'Basarili'),
(7, 10, '2026-05-28', 500.00, 'Kredi Karti', 'Basarili'),
(8, 11, '2026-05-28', 500.00, 'Kredi Karti', 'Basarili'),
(9, 12, '2026-05-29', 3000.00, 'Kredi Karti', 'Basarili'),
(10, 15, '2026-05-29', 5000.00, 'Kredi Karti', 'Basarili'),
(11, 19, '2026-05-29', 1200.00, 'Kredi Karti', 'Basarili');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pasta`
--

CREATE TABLE `pasta` (
  `Pasta_id` int NOT NULL,
  `Kategori_id` int NOT NULL,
  `PastaAdi` varchar(100) NOT NULL,
  `Aciklama` varchar(255) DEFAULT NULL,
  `Fiyat` decimal(10,2) NOT NULL,
  `MevcutMu` tinyint(1) NOT NULL DEFAULT '1',
  `Stok` int NOT NULL DEFAULT '10',
  `Resim` varchar(255) DEFAULT 'default.jpg'
) ;

--
-- Tablo döküm verisi `pasta`
--

INSERT INTO `pasta` (`Pasta_id`, `Kategori_id`, `PastaAdi`, `Aciklama`, `Fiyat`, `MevcutMu`, `Stok`, `Resim`) VALUES
(16, 1, 'Vişneli pasta', 'Kremalı vişneli pasta', 500.00, 1, 5, 'pasta_6a1730a038236.jpg'),
(17, 2, 'Düğün pastası', 'Çiçek süslemeli düğün pastası', 2000.00, 1, 7, 'pasta_6a1730d56b060.jpg'),
(18, 3, 'Nişan pastası', 'Sade tasarımlı nişan pastası', 1500.00, 1, 8, 'pasta_6a17310001d22.jpg'),
(19, 4, 'Ahududulu pasta', 'Günlük özel tasarım pasta', 700.00, 1, 9, 'pasta_6a17313c27d89.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis`
--

CREATE TABLE `siparis` (
  `Siparis_id` int NOT NULL,
  `Musteri_id` int NOT NULL,
  `SiparisTarihi` date NOT NULL,
  `ToplamTutar` decimal(10,2) NOT NULL,
  `SiparisDurumu` varchar(30) NOT NULL DEFAULT 'Hazirlaniyor'
) ;

--
-- Tablo döküm verisi `siparis`
--

INSERT INTO `siparis` (`Siparis_id`, `Musteri_id`, `SiparisTarihi`, `ToplamTutar`, `SiparisDurumu`) VALUES
(9, 2, '2026-05-28', 2000.00, 'Teslim Edildi'),
(10, 3, '2026-05-28', 500.00, 'Teslim Edildi'),
(11, 4, '2026-05-28', 500.00, 'Teslim Edildi'),
(12, 6, '2026-05-29', 3000.00, 'Teslim Edildi'),
(13, 1, '2026-05-29', 3500.00, 'Hazirlaniyor'),
(14, 1, '2026-05-29', 3500.00, 'Hazirlaniyor'),
(15, 7, '2026-05-29', 5000.00, 'Teslim Edildi'),
(16, 7, '2026-05-29', 7000.00, 'Hazirlaniyor'),
(17, 7, '2026-05-29', 7000.00, 'Hazirlaniyor'),
(18, 7, '2026-05-29', 7000.00, 'Hazirlaniyor'),
(19, 8, '2026-05-29', 1200.00, 'Teslim Edildi'),
(20, 8, '2026-05-29', 3000.00, 'Hazirlaniyor');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisdetay`
--

CREATE TABLE `siparisdetay` (
  `SiparisDetay_id` int NOT NULL,
  `Siparis_id` int NOT NULL,
  `Pasta_id` int NOT NULL,
  `Adet` int NOT NULL,
  `BirimFiyat` decimal(10,2) NOT NULL
) ;

--
-- Tablo döküm verisi `siparisdetay`
--

INSERT INTO `siparisdetay` (`SiparisDetay_id`, `Siparis_id`, `Pasta_id`, `Adet`, `BirimFiyat`) VALUES
(7, 9, 17, 1, 2000.00),
(8, 10, 16, 1, 500.00),
(9, 11, 16, 1, 500.00),
(10, 12, 16, 2, 500.00),
(11, 12, 17, 1, 2000.00),
(12, 15, 18, 2, 1500.00),
(13, 15, 17, 1, 2000.00),
(14, 19, 16, 1, 500.00),
(15, 19, 19, 1, 700.00);

--
-- Tetikleyiciler `siparisdetay`
--
DELIMITER $$
CREATE TRIGGER `trg_StokAzalt` AFTER INSERT ON `siparisdetay` FOR EACH ROW BEGIN
    UPDATE Pasta
    SET Stok = Stok - NEW.Adet
    WHERE Pasta_id = NEW.Pasta_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_StokKontrol` BEFORE INSERT ON `siparisdetay` FOR EACH ROW BEGIN
    DECLARE mevcutStok INT;
    DECLARE hataMesaj VARCHAR(250);

    SELECT Stok INTO mevcutStok
    FROM Pasta
    WHERE Pasta_id = NEW.Pasta_id;

    IF (NEW.Adet > mevcutStok) THEN
        SET hataMesaj = CONCAT('Yetersiz stok! ', NEW.Adet, ' adet isteniyor, ancak ', mevcutStok, ' adet mevcut.');
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = hataMesaj;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teslimat`
--

CREATE TABLE `teslimat` (
  `Teslimat_id` int NOT NULL,
  `Siparis_id` int NOT NULL,
  `TeslimatAdresi` varchar(255) NOT NULL,
  `TeslimatTarihi` date DEFAULT NULL,
  `TeslimatDurumu` varchar(30) NOT NULL DEFAULT 'Hazirlaniyor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `teslimat`
--

INSERT INTO `teslimat` (`Teslimat_id`, `Siparis_id`, `TeslimatAdresi`, `TeslimatTarihi`, `TeslimatDurumu`) VALUES
(6, 9, 'istanbul sancaktepe', NULL, 'Hazirlaniyor'),
(7, 10, 'istanbul sancaktepe', NULL, 'Hazirlaniyor'),
(8, 11, 'Kızılay caddesi Eyüp Sultan mah. Mühendis sk. Bina no 6 daire no 4', NULL, 'Hazirlaniyor'),
(9, 12, 'bartın', NULL, 'Hazirlaniyor'),
(10, 15, 'zonguldak', NULL, 'Hazirlaniyor'),
(11, 19, 'zonguldak', NULL, 'Hazirlaniyor');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorum`
--

CREATE TABLE `yorum` (
  `Yorum_id` int NOT NULL,
  `Musteri_id` int NOT NULL,
  `Pasta_id` int NOT NULL,
  `Puan` int NOT NULL,
  `YorumMetni` varchar(255) DEFAULT NULL,
  `YorumTarihi` date NOT NULL
) ;

--
-- Tablo döküm verisi `yorum`
--

INSERT INTO `yorum` (`Yorum_id`, `Musteri_id`, `Pasta_id`, `Puan`, `YorumMetni`, `YorumTarihi`) VALUES
(2, 3, 16, 5, 'Beğendim.', '2026-05-28'),
(3, 4, 16, 3, 'Daha güzel olabilirdi.', '2026-05-28'),
(4, 2, 17, 5, 'Harikaydı.', '2026-05-28'),
(5, 6, 16, 2, 'beğenmedim.', '2026-05-29'),
(6, 6, 17, 3, 'iyiydi.', '2026-05-29'),
(7, 7, 18, 3, 'iyiydi.', '2026-05-29'),
(8, 7, 17, 4, 'güzel.', '2026-05-29'),
(9, 8, 16, 5, 'güzel', '2026-05-29'),
(10, 8, 19, 1, 'beğenmedim.', '2026-05-29');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`Kategori_id`);

--
-- Tablo için indeksler `musteri`
--
ALTER TABLE `musteri`
  ADD PRIMARY KEY (`Musteri_id`),
  ADD UNIQUE KEY `Mail` (`Mail`);

--
-- Tablo için indeksler `odeme`
--
ALTER TABLE `odeme`
  ADD PRIMARY KEY (`Odeme_id`),
  ADD UNIQUE KEY `Siparis_id` (`Siparis_id`);

--
-- Tablo için indeksler `pasta`
--
ALTER TABLE `pasta`
  ADD PRIMARY KEY (`Pasta_id`),
  ADD KEY `Kategori_id` (`Kategori_id`);

--
-- Tablo için indeksler `siparis`
--
ALTER TABLE `siparis`
  ADD PRIMARY KEY (`Siparis_id`),
  ADD KEY `Musteri_id` (`Musteri_id`);

--
-- Tablo için indeksler `siparisdetay`
--
ALTER TABLE `siparisdetay`
  ADD PRIMARY KEY (`SiparisDetay_id`),
  ADD KEY `Siparis_id` (`Siparis_id`),
  ADD KEY `Pasta_id` (`Pasta_id`);

--
-- Tablo için indeksler `teslimat`
--
ALTER TABLE `teslimat`
  ADD PRIMARY KEY (`Teslimat_id`),
  ADD UNIQUE KEY `Siparis_id` (`Siparis_id`);

--
-- Tablo için indeksler `yorum`
--
ALTER TABLE `yorum`
  ADD PRIMARY KEY (`Yorum_id`),
  ADD KEY `Musteri_id` (`Musteri_id`),
  ADD KEY `Pasta_id` (`Pasta_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `Kategori_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `musteri`
--
ALTER TABLE `musteri`
  MODIFY `Musteri_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `odeme`
--
ALTER TABLE `odeme`
  MODIFY `Odeme_id` int NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `pasta`
--
ALTER TABLE `pasta`
  MODIFY `Pasta_id` int NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `siparis`
--
ALTER TABLE `siparis`
  MODIFY `Siparis_id` int NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `siparisdetay`
--
ALTER TABLE `siparisdetay`
  MODIFY `SiparisDetay_id` int NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `teslimat`
--
ALTER TABLE `teslimat`
  MODIFY `Teslimat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `yorum`
--
ALTER TABLE `yorum`
  MODIFY `Yorum_id` int NOT NULL AUTO_INCREMENT;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `odeme`
--
ALTER TABLE `odeme`
  ADD CONSTRAINT `odeme_ibfk_1` FOREIGN KEY (`Siparis_id`) REFERENCES `siparis` (`Siparis_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `pasta`
--
ALTER TABLE `pasta`
  ADD CONSTRAINT `pasta_ibfk_1` FOREIGN KEY (`Kategori_id`) REFERENCES `kategori` (`Kategori_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `siparis`
--
ALTER TABLE `siparis`
  ADD CONSTRAINT `siparis_ibfk_1` FOREIGN KEY (`Musteri_id`) REFERENCES `musteri` (`Musteri_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `siparisdetay`
--
ALTER TABLE `siparisdetay`
  ADD CONSTRAINT `siparisdetay_ibfk_1` FOREIGN KEY (`Siparis_id`) REFERENCES `siparis` (`Siparis_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siparisdetay_ibfk_2` FOREIGN KEY (`Pasta_id`) REFERENCES `pasta` (`Pasta_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `teslimat`
--
ALTER TABLE `teslimat`
  ADD CONSTRAINT `teslimat_ibfk_1` FOREIGN KEY (`Siparis_id`) REFERENCES `siparis` (`Siparis_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `yorum`
--
ALTER TABLE `yorum`
  ADD CONSTRAINT `yorum_ibfk_1` FOREIGN KEY (`Musteri_id`) REFERENCES `musteri` (`Musteri_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yorum_ibfk_2` FOREIGN KEY (`Pasta_id`) REFERENCES `pasta` (`Pasta_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
