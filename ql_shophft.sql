-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 04:20 PM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`, `created_at`) VALUES
(1, 'Nước Uống', 'các loại nước uống', '2025-12-16 02:05:56'),
(3, 'Burger', 'những chiếc hamburger thơm phức', '2025-12-19 01:31:17'),
(4, 'Gà Giòn', 'những miếng gà giòn rụm', '2025-12-19 01:31:44'),
(5, 'Combo', 'combo nhiều món ăn', '2025-12-22 16:07:05'),
(6, 'Mỳ Ý', 'Sợi mì dai, ngon, béo ngậy', '2025-12-23 01:16:36'),
(7, 'Gà Sốt Chua Ngọt', 'Những miếng gà, cay cay, tê đầu lưỡi', '2025-12-23 01:17:15'),
(8, 'Tráng Miệng', 'các món kem', '2025-12-23 01:21:37'),
(9, 'Món phụ', 'các phần khoai tây chiên', '2025-12-23 01:22:05'),
(10, 'Cơm', 'Những phần cơm đầy ấp, thơm ngon', '2025-12-25 02:21:01');

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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `shipper_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `total_money` decimal(10,0) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `fullname`, `phone_number`, `address`, `shipper_id`, `payment_method`, `payment_status`, `status`, `note`, `total_money`, `created_at`) VALUES
(2, 3, 'admin123', '0909090909', 'Ninh Hòa, Hà Nội', 2, 'cod', '1', 'Đã giao hàng', '', 30000, '2025-12-25 03:36:21'),
(3, 3, 'Nguyễn Hoàng Ngọc Tú', '0708688251', 'Số 10 Nguyễn Trường Tộ - Ninh Hòa', 2, 'banking', '1', 'Đã giao hàng', 'Nhà có cái cổng màu trắng.', 240000, '2025-12-27 05:16:26'),
(4, 14, 'user1', '0909090908', 'Nha Trang, Khánh Hòa', 2, 'banking', '1', 'Đang giao hàng', '', 720000, '2025-12-30 00:50:54'),
(5, 16, 'tester01', '09876542', 'Nha Trang, Khánh Hòa', 2, 'cod', '1', 'Đã giao hàng', '', 55000, '2026-01-05 07:19:10'),
(6, 16, 'tester01', '11111', 'Nha Trang, Khánh Hòa', NULL, 'banking', '1', 'Hoàn tiền', '', 90000, '2026-01-05 07:25:50'),
(7, 16, 'tester01', '11111', 'Nha Trang, Khánh Hòa', NULL, 'cod', '0', 'Đã hủy', '', 15000, '2026-01-05 07:27:13'),
(8, 16, 'tester01', '0908778743', 'Nha Trang, Khánh Hòa', 2, 'banking', '1', 'Đã giao hàng', '', 150000, '2026-01-05 07:28:55'),
(9, 16, 'tester01', '11111', 'nhà số 2, đường 2/4, Nha Trang, Khánh Hòa', 2, 'cod', '1', 'Đã giao hàng', '', 55000, '2026-01-06 01:23:23'),
(10, 3, 'admin123', '0909090909', 'Ninh Hòa, TP. Hồ Chí Minh', 2, 'cod', '1', 'Đã giao hàng', '', 55000, '2026-01-07 03:47:27'),
(11, 3, 'admin123', '0909090909', 'Ninh Hòa, TP. Hồ Chí Minh', 2, 'cod', '1', 'Đã giao hàng', '', 85000, '2026-01-07 04:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `food_id`, `quantity`, `price_at_purchase`) VALUES
(2, 2, 160, 1, 30000),
(3, 3, 147, 2, 30000),
(4, 3, 146, 1, 30000),
(5, 3, 152, 1, 30000),
(6, 3, 165, 1, 30000),
(7, 3, 170, 1, 30000),
(8, 3, 156, 1, 30000),
(9, 3, 171, 1, 30000),
(10, 4, 183, 1, 720000),
(11, 5, 156, 1, 45000),
(12, 5, 176, 1, 10000),
(13, 6, 135, 1, 90000),
(14, 7, 175, 1, 15000),
(15, 8, 153, 5, 30000),
(16, 9, 142, 1, 55000),
(17, 10, 142, 1, 55000),
(18, 11, 141, 1, 85000);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
(9, 'admin123@example.com', '25c7e6c0356f98b3d7f8e9eb1968ac2e', '2025-12-27 07:56:29', '2025-12-27 06:26:29'),
(10, 'admin123@example.com', '2fa8c34135c0b3ad8c74603d2aba09b0', '2025-12-27 07:57:57', '2025-12-27 06:27:57'),
(11, 'admin123@example.com', '630f49ef275f75e82e5702e45b588f80', '2025-12-27 07:58:04', '2025-12-27 06:28:04'),
(12, 'admin123@example.com', '9367140b64cc22cda72ddce846b7598a', '2025-12-27 07:59:48', '2025-12-27 06:29:48'),
(13, 'admin123@example.com', '5bf86d0e884d6b22f3f35141c2bbc164', '2025-12-27 07:59:56', '2025-12-27 06:29:56'),
(14, 'admin123@example.com', '2ba4e14d168d45d7c8fc597cb95c2aa1', '2025-12-27 08:00:23', '2025-12-27 06:30:23'),
(15, 'admin123@example.com', 'ff5f8d5434fe67707109c48646622ac5', '2025-12-27 08:00:47', '2025-12-27 06:30:47'),
(16, 'admin123@example.com', 'cb74fc25c768f3ab2427c18eac15ffb5', '2025-12-27 08:00:59', '2025-12-27 06:30:59'),
(17, 'admin123@example.com', 'd342476c18004ddc982f351963d7f6a3', '2025-12-27 08:01:20', '2025-12-27 06:31:20');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `food_id`, `order_id`, `rating`, `comment`, `created_at`) VALUES
(1, 3, 147, 3, 5, 'Ngon', '2025-12-27 05:20:12'),
(2, 16, 156, 5, 5, 'ngon', '2026-01-05 07:24:04');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'customer'),
(3, 'shipper');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `avatar_url` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `full_name`, `phone_number`, `address`, `city`, `avatar_url`, `is_active`, `created_at`) VALUES
(1, 'nguyenvana', 'nguyenvana@example.com', '123456', 'Nguyễn Văn A', '0901234567', 'Số 10 Đường Láng', 'Hà Nội', 'default.jpg', 1, '2025-12-19 08:34:49'),
(2, 'huy204', 'huy204@example.com', '$2y$10$3AM/Op7KRX0fZBCsGNPSJOBSuJ/yrHr/7gdnIGoILi4ZFRxi38nCS', 'Trương Công Huy', '123456', '120 Yên Lãng', 'Cao Bằng', 'avatar-c1fe91803c92d109fa45690b61c4f14d.png', 1, '2025-12-20 07:02:23'),
(3, 'admin123', 'admin123@example.com', '$2y$10$vJQB8x2IPvw9jHBwZIl4pe91it5l0FteI3SfeuO7KXvrxI07tFAwq', 'admin', '0909090909', 'Ninh Hòa', 'TP. Hồ Chí Minh', 'avatar-25080c057941b3c9f83b6f4cf6a07439.png', 1, '2025-12-20 08:47:00'),
(14, 'user1', 'user1@example.com', '$2y$10$KYgWvSBtkstnclD0nz4l6Oe5u7FuIYamxac1ReHCZWuG.aOjAcQ/u', 'anh hai', '0909090908', 'Nha Trang', 'Khánh Hòa', 'hoa-muong-den-9daf97375b6c381617c9d311935812e9.jpeg', 1, '2025-12-20 12:23:54'),
(15, 'user2', 'user2@example.com', '$2y$10$HitML3LAmCRbPEZltlDVOuSA6an6VjhhvbAqOJuq6RUnXDZ.qSs2u', 'anh d', '0909090908', 'Nha Trang', 'Cao Bằng', 'combo_cap_doi_1-03a1ccf87856e4b574b61f670deda465.jpeg', 1, '2025-12-23 03:59:45'),
(16, 'tester01', 'test@gmail.com', '$2y$10$P7xpU6N6394zIPXbeLWjGeDmy1Q3vh41Hyue8g.uV5d33g9zJJvEK', 'test', '11111', 'Nha Trang', 'Khánh Hòa', '', 1, '2026-01-05 07:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `user_id`) VALUES
(3, 2),
(3, 1),
(2, 14),
(1, 3),
(2, 15),
(2, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipper_id` (`shipper_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `food_id` (`food_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `fk_foods_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_foods` FOREIGN KEY (`food_id`) REFERENCES `foods` (`food_id`),
  ADD CONSTRAINT `fk_order_items_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_foods` FOREIGN KEY (`food_id`) REFERENCES `foods` (`food_id`),
  ADD CONSTRAINT `fk_reviews_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `fk_reviews_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `fk_user_role_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `fk_user_role_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
