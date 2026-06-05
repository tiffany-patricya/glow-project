-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for glow_db
CREATE DATABASE IF NOT EXISTS `glow_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `glow_db`;

-- Dumping structure for table glow_db.diary
CREATE TABLE IF NOT EXISTS `diary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `mood` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  CONSTRAINT `diary_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table glow_db.diary: ~2 rows (approximately)
INSERT INTO `diary` (`id`, `username`, `date`, `mood`, `note`, `created_at`) VALUES
	(1, 'tipaniyeo', '2026-06-05', 'Glowing ✨', 'aku glowing banget\n---\n✅ Skincare routine AM completed automatically!', '2026-06-05 12:00:14'),
	(2, 'lacut', '2026-06-05', 'Glowing ✨', 'kulitku gosong karena tergoreng\n---\n✅ Skincare routine AM completed automatically!\n---\n✅ Skincare routine AM/PM completed automatically!', '2026-06-05 12:12:11');

-- Dumping structure for table glow_db.page_views
CREATE TABLE IF NOT EXISTS `page_views` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_date` date NOT NULL,
  `views` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table glow_db.page_views: ~8 rows (approximately)
INSERT INTO `page_views` (`id`, `page_name`, `view_date`, `views`) VALUES
	(1, 'index.php', '2026-06-05', 31),
	(2, 'streak.php', '2026-06-05', 13),
	(3, 'routine.php', '2026-06-05', 32),
	(4, 'diary.php', '2026-06-05', 17),
	(5, 'register.php', '2026-06-05', 4),
	(6, 'stash.php', '2026-06-05', 22),
	(7, 'tips.php', '2026-06-05', 19),
	(8, 'model.php', '2026-06-05', 9);

-- Dumping structure for table glow_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table glow_db.products: ~200 rows (approximately)
INSERT INTO `products` (`id`, `name`, `brand`, `category`, `description`, `image_url`, `created_at`) VALUES
	(1, 'Acnes Face Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(2, 'Garnier Micellar Water Pink', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(3, 'Cetaphil Gentle Skin Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(4, 'Cosrx Low pH Good Morning Gel', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(5, 'Skintific Panthenol Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(6, 'Senka Perfect Whip', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(7, 'Hada Labo Gokujyun Face Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(8, 'Somethinc Low pH Jelly Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(9, 'Wardah Lightening Micellar Gentle Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(10, 'Emina Bright Stuff Face Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(11, 'CeraVe Hydrating Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(12, 'CeraVe SA Smoothing Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(13, 'La Roche-Posay Effaclar Purifying Foaming Gel', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(14, 'The Originote Cicamide Facial Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(15, 'Glad2Glow Blueberry Ceramide Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(16, 'Y.O.U Hy Amino Facial Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(17, 'Avoskin Natural Sublime Facial Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(18, 'Dear Me Beauty Skin Barrier Face Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(19, 'NPURE Centella Asiatica Face Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(20, 'Whitelab Brightening Facial Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(21, 'Joylab Cleansing Water', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(22, 'Bioderma Sensibio H2O', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(23, 'Biore Makeup Remover Perfect Cleansing Water', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(24, 'Ponds Bright Beauty Facial Foam', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(25, 'Clean & Clear Foaming Face Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(26, 'Himalaya Purifying Neem Face Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(27, 'Safi Research Institute Acne Expert', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(28, 'Kahf Face Wash', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(29, 'Y.O.U AcnePlus Low pH', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(30, 'True to Skin Matcha Oat Gentle Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(31, 'DHC Deep Cleansing Oil', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(32, 'Kose Softymo Speedy Cleansing Oil', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(33, 'Somethinc Omega Butter Cleansing Balm', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(34, 'Skintific Purifying Cleansing Balm', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(35, 'Dear Me Beauty Cleansing Balm', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(36, 'Heimish All Clean Balm', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(37, 'Banila Co Clean It Zero', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(38, 'Barenbliss K.O Kombucha Omega', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(39, 'Innisfree Green Tea Amino Cleansing Foam', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(40, 'Laneige Water Bank Blue Hyaluronic Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(41, 'Kiehl\'s Calendula Deep Cleansing', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(42, 'Pyunkang Yul Low pH Pore Deep Cleansing', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(43, 'Rovectin Skin Essentials Conditioning Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(44, 'Make P:rem Safe me Relief Moisture Cleansing Foam', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(45, 'Isntree Green Tea Fresh Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(46, 'Round Lab 1025 Dokdo Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(47, 'Benton Honest Cleansing Foam', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(48, 'Neogen Real Fresh Foam Green Tea', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(49, 'Skin1004 Madagascar Centella Ampoule Foam', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(50, 'Beauty of Joseon Green Plum Refreshing Cleanser', NULL, 'Cleanser', NULL, NULL, '2026-06-05 12:46:25'),
	(51, 'The Originote Peeling Solution', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(52, 'Somethinc Niacinamide Moisture Sabi', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(53, 'Avoskin Perfect Hydrating Treatment', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(54, 'Skintific 5X Ceramide Soothing Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(55, 'Somethinc 5% Niacinamide', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(56, 'Somethinc 10% Niacinamide', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(57, 'Somethinc AHA BHA PHA Peeling Solution', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(58, 'Somethinc Retinol 1%', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(59, 'Skintific 10% Niacinamide Brightening Serum', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(60, 'Skintific SymWhite 377 Dark Spot Serum', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(61, 'Skintific 2% Salicylic Acid Anti Acne Serum', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(62, 'Avoskin Miraculous Refining Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(63, 'Avoskin Miraculous Retinol Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(64, 'Avoskin Your Skin Bae Salicylic Acid', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(65, 'Avoskin Your Skin Bae Alpha Arbutin', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(66, 'Wardah Lightening Face Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(67, 'Emina The Bright Stuff Face Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(68, 'The Originote Ceramide Hya', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(69, 'The Originote Retinol B3 Serum', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(70, 'Glad2Glow Pomegranate 5% Niacinamide', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(71, 'Glad2Glow Centella 2% Salicylic Acid', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(72, 'NPURE Centella Asiatica Face Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(73, 'NPURE Licorice Light Up Brightening', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(74, 'Whitelab Brightening Face Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(75, 'Whitelab Niacinamide 10%', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(76, 'Dear Me Beauty 10% Niacinamide', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(77, 'True to Skin Bakuchiol Anti-Aging', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(78, 'Cosrx AHA/BHA Clarifying Treatment Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(79, 'Cosrx Centella Water Alcohol-Free Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(80, 'Cosrx Advanced Snail 96 Mucin Power Essence', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(81, 'Cosrx BHA Blackhead Power Liquid', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(82, 'Some By Mi AHA BHA PHA 30 Days Miracle Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(83, 'Some By Mi Snail Truecica Miracle Repair', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(84, 'Skin1004 Madagascar Centella Toning Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(85, 'Skin1004 Madagascar Centella Ampoule', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(86, 'Pyunkang Yul Essence Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(87, 'Isntree Green Tea Fresh Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(88, 'Round Lab 1025 Dokdo Toner', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(89, 'Beauty of Joseon Glow Serum', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(90, 'Beauty of Joseon Calming Serum', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(91, 'The Ordinary Niacinamide 10% + Zinc 1%', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(92, 'The Ordinary Hyaluronic Acid 2% + B5', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(93, 'The Ordinary Glycolic Acid 7% Toning Solution', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(94, 'The Ordinary AHA 30% + BHA 2% Peeling Solution', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(95, 'Paula\'s Choice 2% BHA Liquid Exfoliant', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(96, 'Kiehl\'s Clearly Corrective Dark Spot', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(97, 'Lancome Advanced Genifique', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(98, 'Estee Lauder Advanced Night Repair', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(99, 'Hada Labo Gokujyun Ultimate Moisturizing Lotion', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(100, 'Hada Labo Shirojyun Whitening Lotion', NULL, 'Toner/Serum', NULL, NULL, '2026-06-05 12:46:25'),
	(101, 'Skintific 5X Ceramide Moisturizer', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(102, 'The Originote Hyalucera Moisturizer', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(103, 'Glad2Glow Blueberry Moisturizer', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(104, 'Dear Me Beauty Skin Barrier Water Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(105, 'Somethinc Ceramic Skin Saviour', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(106, 'Somethinc Calm Down Skinpair', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(107, 'Wardah Nature Daily Witch Hazel', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(108, 'Wardah Perfect Bright Moisturizer', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(109, 'Emina Bright Stuff Moisturizing Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(110, 'Emina Ms. Pimple Acne Solution', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(111, 'Avoskin Your Skin Bae Glow Concentrate', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(112, 'NPURE Centella Asiatica Day Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(113, 'NPURE Centella Asiatica Night Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(114, 'Whitelab Brightening Day Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(115, 'Whitelab Brightening Night Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(116, 'True to Skin Mugwort Tripeptide', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(117, 'Joylab Moisture Bomb Pudding Gel', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(118, 'Y.O.U Radiance Up! Deep Moisturizing', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(119, 'Skintific Truffle Biome Skin Reborn', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(120, 'Skintific SymWhite 377 Moisture Gel', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(121, 'The Originote Ceraluronic Ceramide', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(122, 'Glad2Glow Centella Allantoin Soothing', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(123, 'Azarine Oil Free Brightening Daily', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(124, 'Studio Tropik Rich Skin Barrier Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(125, 'Base Ultra Matte Natural Moisturizer', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(126, 'Hada Labo Gokujyun Ultimate Moisturizing Milk', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(127, 'Hada Labo Perfect 3D Gel', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(128, 'Cosrx Oil-Free Ultra-Moisturizing Lotion', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(129, 'Cosrx Advanced Snail 92 All In One Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(130, 'Cosrx Centella Blemish Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(131, 'Some By Mi AHA BHA PHA 30 Days Miracle Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(132, 'Skin1004 Madagascar Centella Soothing Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(133, 'Illiyoon Ceramide Ato Concentrate Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(134, 'Etude House SoonJung 2x Barrier Intensive Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(135, 'Laneige Water Bank Blue Hyaluronic Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(136, 'Innisfree Green Tea Seed Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(137, 'Nature Republic Aloe Vera 92% Soothing Gel', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(138, 'The Face Shop Jeju Aloe Fresh Soothing Gel', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(139, 'Beauty of Joseon Dynasty Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(140, 'CeraVe Moisturizing Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(141, 'CeraVe Daily Moisturizing Lotion', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(142, 'Cetaphil Moisturizing Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(143, 'La Roche-Posay Toleriane Double Repair', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(144, 'La Roche-Posay Cicaplast Baume B5', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(145, 'Kiehl\'s Ultra Facial Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(146, 'Clinique Moisture Surge 100H', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(147, 'Neutrogena Hydro Boost Water Gel', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(148, 'Olay Regenerist Micro-Sculpting Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(149, 'Ponds Age Miracle Youthful Glow', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(150, 'Safi Age Defy Renewal Night Cream', NULL, 'Moisturizer', NULL, NULL, '2026-06-05 12:46:25'),
	(151, 'Azarine Hydrasoothe Sunscreen Gel', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(152, 'Emina Sun Battle SPF 30', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(153, 'Facetology Triple Care Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(154, 'Carasun Solar Smart UV Protector', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(155, 'Skintific 5X Ceramide Serum Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(156, 'Skintific All Day Light Sunscreen Mist', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(157, 'Somethinc Holyshield! Sunscreen Comfort', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(158, 'Somethinc Holyshield! UV Watery', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(159, 'Wardah UV Shield Essential Sunscreen Gel', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(160, 'Wardah UV Shield Aqua Tinted', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(161, 'Emina Sun Battle SPF 45', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(162, 'Emina Sun Battle SPF 50', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(163, 'The Originote Ceramella Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(164, 'Glad2Glow Ultra Light Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(165, 'NPURE Cica Beat The Sun', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(166, 'NPURE Cica Beat The Sun Powder', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(167, 'Whitelab UV Shield Sunscreen Gel', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(168, 'Avoskin The Great Shield', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(169, 'Dear Me Beauty Acne Care Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(170, 'True to Skin Sunfriends', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(171, 'Y.O.U Triple UV Elixir', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(172, 'Madame Gie Protect Me Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(173, 'Hanasui Collagen Water Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(174, 'Implora Perfect Shield Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(175, 'Base Ultra Matte Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(176, 'Studio Tropik Skin Pretty Filter', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(177, 'For Skin\'s Sake Weightless Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(178, 'Biore UV Aqua Rich Watery Essence', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(179, 'Biore UV Aqua Rich Watery Gel', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(180, 'Skin Aqua UV Moisture Milk', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(181, 'Skin Aqua UV Moisture Gel', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(182, 'Skin Aqua Tone Up UV Essence', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(183, 'Anessa Perfect UV Sunscreen Skincare Milk', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(184, 'Allie Chrono Beauty Gel UV', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(185, 'Cosrx Aloe Soothing Sun Cream', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(186, 'Some By Mi Truecica Mineral 100 Calming Suncream', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(187, 'Skin1004 Madagascar Centella Hyalu-Cica Water-Fit Sun Serum', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(188, 'Isntree Hyaluronic Acid Watery Sun Gel', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(189, 'Beauty of Joseon Relief Sun : Rice + Probiotics', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(190, 'Beauty of Joseon Matte Sun Stick', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(191, 'Round Lab Birch Juice Moisturizing Sun Cream', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(192, 'Innisfree Intensive Long-lasting Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(193, 'Laneige Radian-C Sun Cream', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(194, 'Tocobo Cotton Soft Sun Stick', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(195, 'Supergoop! Unseen Sunscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(196, 'Supergoop! Glowscreen', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(197, 'La Roche-Posay Anthelios Melt-in Milk', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(198, 'La Roche-Posay Anthelios Light Fluid', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(199, 'Cetaphil Sun SPF 50+ Light Gel', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25'),
	(200, 'Neutrogena Ultra Sheer Dry-Touch', NULL, 'Sunscreen', NULL, NULL, '2026-06-05 12:46:25');

-- Dumping structure for table glow_db.routine
CREATE TABLE IF NOT EXISTS `routine` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `routine_type` enum('AM','PM') COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_date` date NOT NULL,
  `completed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  CONSTRAINT `routine_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table glow_db.routine: ~0 rows (approximately)

-- Dumping structure for table glow_db.stash
CREATE TABLE IF NOT EXISTS `stash` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  CONSTRAINT `stash_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table glow_db.stash: ~2 rows (approximately)
INSERT INTO `stash` (`id`, `username`, `product_name`, `product_type`, `status`, `added_at`) VALUES
	(1, 'lacut', 'Acnes Face Wash', 'Cleanser', 'Holy Grail ✨', '2026-06-05 12:52:11'),
	(2, 'lacut', 'Wardah Lightening Face Toner', 'Toner/Serum', 'Holy Grail ✨', '2026-06-05 12:53:31');

-- Dumping structure for table glow_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','member') COLLATE utf8mb4_unicode_ci DEFAULT 'member',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table glow_db.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
	(1, 'admin', '$2y$10$rRLc0HWZDaCg6K4bjMQxG.vKg2BZwfcv1ln1TAWesLIY8wVOm7fHC', 'admin', '2026-06-05 10:50:23'),
	(2, 'tipaniyeo', '$2y$10$oOP5gd5XfQE7ogl12r2duOZghB35AjLObTojGnRzzn0bvrkYyR3tW', 'member', '2026-06-05 11:36:29'),
	(3, 'lacut', '$2y$10$nE/gPm6mpwKOOr2aa/nJw.LnayxXs8zwPMPVoKFCFwcxsJCbLyXX2', 'member', '2026-06-05 12:11:23');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
