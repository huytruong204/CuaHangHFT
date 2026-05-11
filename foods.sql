-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 04:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ql_shophft`
--

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `food_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `food_name` varchar(150) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`food_id`, `category_id`, `food_name`, `description`, `price`, `image_url`, `status`, `created_at`) VALUES
(130, 4, '1 MIẾNG GÀ GIÒN', '1 miếng Gà Giòn + 1 Sốt Gà Cay', 35000, 'img_ga_4-ea9f138bc8802de5a7f5d0f24cfa116f.webp', 1, '2025-12-25 03:29:40'),
(131, 4, '2 MIẾNG GÀ GIÒN', '2 miếng Gà Giòn + 2 Sốt Gà Cay', 68000, 'img_ga_2-4b3e3b72f2e460f737528cede6cb87ea.webp', 1, '2025-12-25 03:29:40'),
(132, 4, '4 MIẾNG GÀ GIÒN', '4 miếng Gà Giòn + 4 Sốt Gà Cay', 135000, 'img_ga_3-3e4ffe6196fc739145db4765d07ff593.webp', 1, '2025-12-25 03:29:40'),
(133, 4, '6 MIẾNG GÀ GIÒN', '6 miếng Gà Giòn + 6 Sốt Gà Cay', 199000, 'img_ga_1-removebg-preview-23e970d8e2401f8a699278049d8e4e0f.png', 1, '2025-12-25 03:29:40'),
(134, 4, '1 GÀ GIÒN + 1 KHOAI TÂY CHIÊN + 1 NƯỚC NGỌT', '1 Gà Giòn + 1 Khoai Tây Chiên Vừa + 1 Nước Ngọt+ 1 Sốt Gà Cay + 1 Sốt Cà Chua', 90000, 'combo_ga_2-removebg-preview-2dceee4819248e07a7257a16aa025cd3.png', 1, '2025-12-25 03:29:40'),
(135, 4, '2 GÀ GIÒN + 1 KHOAI TÂY CHIÊN + 1 NƯỚC NGỌT', '2 Gà Giòn + 1 Khoai Tây Chiên Vừa + 1 Nước Ngọt+ 2 Sốt Gà Cay + 1 Sốt Cà Chua', 90000, 'combo_ga_1-removebg-preview-4e5af5ce0188900a352573df2c6dbe10.png', 1, '2025-12-25 03:29:40'),
(136, 6, 'MÌ Ý SỐT CAY VỪA', '1 Mì Ý Sốt Cay Vừa', 45000, 'img_my1-removebg-preview-388eab5ae08b3092f632a98c176a4adb.png', 1, '2025-12-25 03:29:40'),
(137, 6, 'MÌ Ý SỐT CAY LỚN', '1 Mì Ý Sốt Cay Lớn', 50000, 'img_my1-removebg-preview-06fdae5a50c16aa08051a155c7faba05.png', 1, '2025-12-25 03:29:40'),
(138, 6, '1 MÌ Ý SỐT CAY + 1 NƯỚC NGỌT', '1 Mì Ý Sốt Cay Vừa + 1 Nước Ngọt', 55000, 'combo_my_1-removebg-preview-0e5edf15056c56bb6df8c4aa8a7224af.png', 1, '2025-12-25 03:29:40'),
(139, 6, '1 MÌ Ý SỐT CAY + 1 GÀ GIÒN + 1 NƯỚC NGỌT', '1 Mì Ý Sốt Cay Vừa + 1 Gà Giòn + 1 Nước Ngọt + 1 Sốt Gà Cay', 85000, 'combo_my_3-removebg-preview-9391bd70133930e2695a1aed554bbe22.png', 1, '2025-12-25 03:29:40'),
(140, 6, '1 MÌ Ý + 1 GÀ GIÒN + 1 KHOAI TÂY CHIÊN + 1 NƯỚC NGỌT', '1 Mì Ý Vừa + 1 Gà Giòn + 1 Khoai Tây Chiên Vừa + 1 Nước Ngọt + 1 Sốt Gà Cay + 1 Sốt Cà Chua', 85000, 'combo_my_4-removebg-preview-2fd8437ce81b61bc185a680455fbb963.png', 1, '2025-12-25 03:29:40'),
(141, 6, '1 MÌ Ý + 1 GÀ GIÒN + 1 NƯỚC NGỌT', '1 Mì Ý Vừa + 1 Gà Giòn + 1 Nước Ngọt + 1 Sốt Gà Cay', 85000, 'combo_my_3-removebg-preview-e93aae21f8b9afbdb4d62c7204ba21bc.png', 1, '2025-12-25 03:29:40'),
(142, 6, '1 MÌ Ý + 1 NƯỚC NGỌT', '1 Mì Ý Vừa + 1 Nước Ngọt', 55000, 'combo_my_5-removebg-preview-fe836e444a17fdbaa71aea028a5b7eb1.png', 1, '2025-12-25 03:29:40'),
(143, 6, '1 MÌ Ý + 1 KHOAI TÂY CHIÊN + 1 NƯỚC NGỌT', '1 Mì Ý Vừa + 1 Khoai Tây Chiên Vừa + 1 Nước Ngọt + 1 Sốt Cà Chua', 85000, 'combo_my_6-removebg-preview-5f4baa2989f8833ac99283639b0b13c8.png', 1, '2025-12-25 03:29:40'),
(144, 6, 'MÌ Ý VỪA', '1 Mì Ý Vừa', 30000, 'img_my2-removebg-preview-17d948992aaed2fa9b1931c7981411cf.png', 1, '2025-12-25 03:29:40'),
(145, 6, 'MÌ Ý LỚN', '1 Mì Ý Lớn', 35000, 'img_my2-removebg-preview-ea7e4a1dc5a75a72f33a8e202f95902c.png', 1, '2025-12-25 03:29:40'),
(146, 7, '1 MIẾNG GÀ SỐT CHUA NGỌT', '1 Miếng Gà Sốt Chua Ngọt', 40000, 'img_ga_cay_1-removebg-preview-fa967f202f0f09af916e8e994b40e690.png', 1, '2025-12-25 03:29:40'),
(147, 7, '2 MIẾNG GÀ SỐT CHUA NGỌT', '2 Miếng Gà Sốt Chua Ngọt', 78000, 'img_ga_cay_2-removebg-preview-22ab6b22659108fea8efbbf42bbbdedd.png', 1, '2025-12-25 03:29:40'),
(148, 7, '1 GÀ SỐT CHUA NGỌT + 1 KHOAI TÂY CHIÊN + 1 NƯỚC NGỌT', '1 Gà Sốt Chua Ngọt + 1 Khoai Tây Chiên Vừa + 1 Nước Ngọt + 1 Sốt Cà Chua', 95000, 'combo_ga_cay_2-removebg-preview-cc5a7166a4a6697258c467b192284f14.png', 1, '2025-12-25 03:29:40'),
(149, 7, '2 GÀ SỐT CHUA NGỌT + 1 KHOAI TÂY CHIÊN + 1 NƯỚC NGỌT', '2 Gà Sốt Chua Ngọt + 1 Khoai Tây Chiên Vừa + 1 Nước Ngọt + 1 Sốt Cà Chua', 95000, 'combo_ga_cay_1-removebg-preview-ce94ba719a18e7b039684c79dffc06c5.png', 1, '2025-12-25 03:29:40'),
(150, 3, '1 BURGER TÔM + 1 NƯỚC NGỌT', '1 Burger Tôm + 1 Nước Ngọt', 60000, 'combo_berger_1-removebg-preview-94c1ffff833929568596db92846bb046.png', 1, '2025-12-25 03:29:40'),
(151, 3, '1 BURGER TÔM + 1 KHOAI TÂY CHIÊN + 1 NƯỚC NGỌT', '1 Burger Tôm + 1 Khoai Tây Chiên Vừa + 1 Nước Ngọt + 1 Sốt Cà Chua', 75000, 'combo_berger_2-removebg-preview-d7e690f844d9ca441ffee724de1e1836.png', 1, '2025-12-25 03:29:40'),
(152, 3, 'BURGER TÔM', '1 Burger Tôm', 35000, 'img_berger_1-de69bd610bad8308514ee7e543cc3bc4.webp', 1, '2025-12-25 03:29:40'),
(153, 3, 'SANDWICH GÀ', '1 Sandwich Gà', 30000, 'img_sandwich_1-8773f9cc7ac5c634b24f7c23303f8872.webp', 1, '2025-12-25 03:29:40'),
(154, 3, '1 SANDWICH GÀ + 1 NƯỚC NGỌT', '1 Sandwich Gà + 1 Nước Ngọt', 60000, 'combo_sandwich_1-removebg-preview-e424ae80c7d1c1193b09194b4c780702.png', 1, '2025-12-25 03:29:40'),
(155, 3, '1 SANDWICH GÀ + 1 + 1 KHOAI TÂY CHIÊN + 1 NƯỚC NGỌT', '1 Sandwich Gà + 1 Khoai Tây Chiên Vừa + 1 Nước Ngọt + 1 Sốt Cà Chua', 75000, 'combo_sanwich_2-removebg-preview-37860be8292abebe626d0fb2b89289be.png', 1, '2025-12-25 03:29:40'),
(156, 10, 'CƠM GÀ MẮM TỎI', '1 Cơm Gà Mắm Tỏi', 45000, 'img_com_1-removebg-preview-aac71ed58a748b7951e753b3d8ce6bfe.png', 1, '2025-12-25 03:29:40'),
(157, 10, '1 CƠM GÀ MẮM TỎI + 1 NƯỚC NGỌT', '1 Cơm Gà Mắm Tỏi + 1 Nước Ngọt', 60000, 'combo_com_3-removebg-preview-c2a83c2077e868d1bffe2e686a2e70dc.png', 1, '2025-12-25 03:29:40'),
(158, 10, 'CƠM GÀ SỐT CHUA NGỌT', '1 Cơm Gà Sốt Chua Ngọt', 45000, 'combo_com_2-removebg-preview (1)-038fdbd3b6640e08933e82cd6121eb03.png', 1, '2025-12-25 03:29:40'),
(159, 10, '1 CƠM GÀ SỐT CHUA NGỌT + 1 NƯỚC NGỌT', '1 Cơm Gà Sốt Chua Ngọt + 1 Nước Ngọt', 60000, 'combo_com_2-removebg-preview-733000d7f4fc10f9efc9921a71fa3ab8.png', 1, '2025-12-25 03:29:40'),
(160, 10, 'CƠM GÀ GIÒN', '1 Cơm Gà Sốt Chua Ngọt + 1 Sốt Gà Cay', 45000, 'img_com_ga_1-545c9aa55dbbf37769152c5216ccec46.webp', 1, '2025-12-25 03:29:40'),
(161, 10, '1 CƠM GÀ GIÒN + 1 NƯỚC NGỌT', '1 Cơm Gà Giòn + 1 Nước Ngọt + 1 Sốt Gà Cay', 60000, 'combo_com_1-removebg-preview-9c03e57f79cf2ce795e7c45deb89da4a.png', 1, '2025-12-25 03:29:40'),
(162, 9, '2 GÓI SỐT GÀ CAY', 'Thêm 2 Gói Sốt Gà Cay', 1000, 'img_sot_cay-removebg-preview (1)-8d1bc736b97fd6850d8b78dbf889edc5.png', 1, '2025-12-25 03:29:40'),
(163, 9, '2 GÓI SỐT CÀ CHUA', 'Thêm 2 Gói Sốt Cà Chua', 1000, 'img_sot_ca_chua-removebg-preview-b9427228c1f08a4dcd4947b86fb75407.png', 1, '2025-12-25 03:29:40'),
(164, 9, 'KHOAI TÂY CHIÊN VỪA', '1 Khoai Tây Chiên Vừa + 1 Sốt Cà Chua', 20000, 'img_khoai_2-removebg-preview-82da4ecfe0ef52814a3cfc4246e2398a.png', 1, '2025-12-25 03:29:40'),
(165, 9, 'KHOAI TÂY CHIÊN LỚN', '1 Khoai Tây Chiên Lớn + 2 Sốt Cà Chua', 30000, 'img_khoai_2-removebg-preview-b2947c4f7ffe5fb7bd33126f39ae45a4.png', 1, '2025-12-25 03:29:40'),
(166, 9, 'KHOAI TÂY LẮC BBQ VỪA', '1 Khoai Tây Lắc BBQ Vừa + 1 Sốt Cà Chua', 30000, 'img_khoai_3-removebg-preview (1)-7d025bb1288a9db04ae3fb63de8acb24.png', 1, '2025-12-25 03:29:40'),
(167, 9, 'KHOAI TÂY LẮC BBQ LỚN', '1 Khoai Tây Lắc BBQ Lớn + 2 Sốt Cà Chua', 40000, 'img_khoai_3-removebg-preview (1)-b59af415cf1fc96f9dce2aa7eee8c690.png', 1, '2025-12-25 03:29:40'),
(168, 8, 'KEM VANI', '1 Cúp Kem Vani', 15000, 'img_kem_1-removebg-preview-820d219869493fc53b1f7e6f5d092199.png', 1, '2025-12-25 03:29:40'),
(169, 8, 'KEM CHOCOLATE', '1 Cúp Kem Chocolate', 15000, 'img_kem_2-removebg-preview-e575d21be02a0b9b9ffcd24976d5c3d8.png', 1, '2025-12-25 03:29:40'),
(170, 8, 'KEM THẠCH TRÁI CÂY', '1 Ly Kem Thạch Trái Cây', 25000, 'img_kem_3-removebg-preview-aef5fd2994ed3fdf1d74c404e43ee9cf.png', 1, '2025-12-25 03:29:40'),
(171, 1, 'TRÀ ĐÀO', '1 Ly Trà Đào', 25000, 'img_tra_dao-removebg-preview-e043d62df4cf151dbdc387e7ea3f0255.png', 1, '2025-12-25 03:29:40'),
(172, 1, 'CACAO ĐÁ', '1 Ly CaCao Đá', 25000, 'img_cacao_da-removebg-preview-a19332f28326dee04ea066085ba23584.png', 1, '2025-12-25 03:29:40'),
(173, 1, '7 UP', '1 Ly 7 Up', 15000, 'img_7up-4f5ee4989b00afa47430c274ed51cccc.webp', 1, '2025-12-25 03:29:40'),
(174, 1, 'MIRINDA', '1 Ly Mirinda Cam', 15000, 'img_mirinda-56ef3141d6d1b3b32a2012ca2f783822.webp', 1, '2025-12-25 03:29:40'),
(175, 1, 'PEPSI', '1 Ly Pepsi', 15000, 'img_pepsi-34510e5751de70578ee3bdbd309f90d4.webp', 1, '2025-12-25 03:29:40'),
(176, 1, 'NƯỚC SUỐI', '1 Chai Nước Suối', 11000, 'img_nuoc_suoi-e7c0ffc262aceaf415fa14ba35b9528a.webp', 1, '2025-12-25 03:29:40'),
(177, 5, 'COMBO ALONE', '1 Gà Giòn + 1 Mì Ý Vừa + 1 Khoai Tây Chiên Vừa + 1 Nước Ngọt + 1 Sốt Gà Cay', 95000, 'combo_my_4-removebg-preview-346dd6b924e04dfb06e21c8d906260a3.png', 1, '2025-12-25 03:29:40'),
(178, 5, 'COMBO COUPLE 1', '2 Gà Giòn + 2 Mì Ý Vừa + 1 Khoai Tây Chiên + 2 Nước Ngọt + 2 Sốt Gà Cay + 1 Sốt Cà Chua', 185000, 'combo_cap_doi_1-removebg-preview-5767949c3687c9a87008923dcb4270a0.png', 1, '2025-12-25 03:29:40'),
(179, 5, 'COMBO COUPLE 2', '3 Gà Giòn + 1 Mì Ý Vừa + 1 Khoai Tây Chiên + 2 Nước Ngọt + 2 Sốt Gà Cay + 1 Sốt Cà Chua', 205000, 'combo_cap_doi_2-removebg-preview-1ea746dbea47000b5d6b6edbdab803cf.png', 1, '2025-12-25 03:29:40'),
(180, 5, 'COMBO FAMILY', '3 Gà Giòn + 2 Mì Ý Vừa + 1 Khoai Tây Chiên + 3 Nước Ngọt + 3 Sốt Gà Cay + 1 Sốt Cà Chua', 295000, 'combo_gia_dinh_nho-removebg-preview-3b02bdb65c23c7cc8bd4e5cd94429449.png', 1, '2025-12-25 03:29:40'),
(181, 5, 'COMBO PARTY 1', '3 Gà Giòn + 3 Mì Ý Vừa + 1 Khoai Tây Chiên + 1 Burger + 4 Nước Ngọt + 3 Sốt Gà Cay + 2 Sốt Cà Chua', 450000, 'combo_tiec_tung_4-removebg-preview-0f627ad9ae63d25824809b4d663481db.png', 1, '2025-12-25 03:29:40'),
(182, 5, 'COMBO PARTY 2', '3 Gà Giòn + 3 Mì Ý Vừa + 1 Khoai Tây Chiên + 2 Burger + 5 Nước Ngọt + 3 Sốt Gà Cay + 3 Sốt Cà Chua', 550000, 'combo_tiec_tung_2-removebg-preview-513ce94f7b258d970b5919fd825d32d3.png', 1, '2025-12-25 03:29:40'),
(183, 5, 'COMBO PARTY 3', '3 Gà Giòn + 5 Mì Ý Vừa + 2 Gà Sốt Chua Ngọt + 3 Khoai Tây Chiên + 5 Nước Ngọt + 3 Sốt Gà Cay + 3 Sốt Cà Chua', 720000, 'combo_tiec_tung_5-removebg-preview-26a2326b0cadc62660c7db9bd8ac8ac7.png', 1, '2025-12-25 03:29:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `fk_foods_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
