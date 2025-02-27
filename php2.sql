-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 06:07 AM
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
-- Database: `php2`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 'banner 1', 'uploads/1740630305_67bfe921c657b.jpg', 1, '2025-02-27 04:25:05', '2025-02-27 04:25:05'),
(4, 'banner 2', 'uploads/1740630359_67bfe957ea783.jpg', 1, '2025-02-27 04:25:59', '2025-02-27 04:25:59'),
(5, 'money', 'uploads/1740631035_67bfebfb3e3ae.jpg', 1, '2025-02-27 04:37:15', '2025-02-27 04:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `idUser`, `status`, `created_at`, `updated_at`) VALUES
(89, 18446744073709551615, 'pending', '2025-02-18 12:46:00', '2025-02-18 12:46:00'),
(90, 18446744073709551615, 'pending', '2025-02-18 12:47:09', '2025-02-18 12:47:09'),
(92, 29, 'pending', '2025-02-19 10:55:04', '2025-02-19 10:55:04'),
(100, 27, 'pending', '2025-02-25 18:17:54', '2025-02-25 18:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `idCartItem` bigint(20) UNSIGNED NOT NULL,
  `idCart` bigint(20) UNSIGNED NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idProductItem` int(11) NOT NULL,
  `sku` text NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`idCartItem`, `idCart`, `idProduct`, `idProductItem`, `sku`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(153, 89, 66, 128, 'den123', 3, 5000000, '2025-02-18 12:46:00', '2025-02-18 12:46:00'),
(154, 90, 1, 119, 'iphone11-green-64gb', 1, 6500000, '2025-02-18 12:47:09', '2025-02-18 12:47:09'),
(156, 92, 15, 102, 'iphone12pr-vang-128gb', 4, 24000000, '2025-02-19 10:55:04', '2025-02-19 10:55:04'),
(179, 100, 1, 119, 'iphone11-green-64gb', 1, 6500000, '2025-02-25 18:17:54', '2025-02-25 18:17:54'),
(184, 100, 6, 96, 'iphone13-den-64gb', 1, 13000000, '2025-02-25 19:28:13', '2025-02-25 19:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'iPhone ', '2025-01-13 00:59:09', '2025-01-13 00:59:09'),
(8, 'iPad', '2025-02-25 20:13:41', '2025-02-25 20:13:41'),
(9, 'Macbook', '2025-02-25 20:13:50', '2025-02-25 20:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `idColor` int(11) NOT NULL,
  `nameColor` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`idColor`, `nameColor`, `created_at`, `updated_at`) VALUES
(1, 'Black', '2025-01-14 02:59:41', '2025-01-14 02:59:41'),
(2, 'White', '2025-01-14 02:59:41', '2025-01-14 02:59:41'),
(3, 'Blue', '2025-01-14 02:59:41', '2025-01-14 02:59:41'),
(4, 'Pink', '2025-01-14 02:59:41', '2025-01-14 02:59:41'),
(5, 'Yellow', '2025-01-14 02:59:41', '2025-01-14 02:59:41'),
(6, 'Green', '2025-01-14 02:59:41', '2025-01-14 02:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(20) NOT NULL,
  `nameDiscount` text NOT NULL,
  `description` text NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_type` enum('percent','fixed','free_shipping') NOT NULL,
  `discount_value` decimal(10,0) NOT NULL,
  `min_order_value` decimal(10,0) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `nameDiscount`, `description`, `code`, `discount_type`, `discount_value`, `min_order_value`, `start_date`, `end_date`, `usage_limit`, `used_count`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Tết đến xuân về', 'Hân hoan chúc mừng năm mới 2025', 'tetsumvay', 'fixed', 100000, 500, '2025-02-20 00:00:00', '2025-02-28 00:00:00', 75, 19, 1, NULL, '2025-01-10 07:56:36'),
(7, 'chuc mung nam moi', 'chao don nam moi 2025', 'NEWYEAR2024', 'percent', 20, 0, '2025-02-05 00:00:00', '2025-03-06 00:00:00', 97, 3, 1, '2024-12-31 07:44:43', '2025-01-07 01:44:35'),
(15, 'ngay vang trong nam', 'chao don nam moi 2025', 'freeship', 'free_shipping', 0, 0, '2025-02-01 00:00:00', '2025-02-28 00:00:00', 99, 1, 1, '2025-01-06 22:08:54', '2025-01-07 00:43:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `noteOrder` text DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL,
  `total_price` int(250) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `code` varchar(250) NOT NULL,
  `discount_id` int(20) DEFAULT NULL,
  `discount_value` int(11) DEFAULT NULL,
  `final_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `idUser`, `status`, `noteOrder`, `payment`, `total_price`, `created_at`, `updated_at`, `name`, `phone`, `address`, `code`, `discount_id`, `discount_value`, `final_amount`) VALUES
(142, 32, 'completed', '', 'cod', 6530000, '2025-02-26 20:17:10', '2025-02-26 20:17:10', 'bui van chau', '0987654321', 'cuewi , cukuin, daklak', '1K4GRHI0', 4, 100000, 6400000),
(143, 32, 'pending', '', 'cod', 6530000, '2025-02-26 20:23:59', '2025-02-26 20:23:59', 'bui van chau', '0987654321', 'cuewi , cukuin, daklak', 'F19MKH4G', 4, 100000, 6400000),
(144, 32, 'pending', '', 'cod', 6530000, '2025-02-26 20:26:31', '2025-02-26 20:26:31', 'bui van chau', '0987654321', 'eakar, dak lak', '8G0JO726', 4, 100000, 6400000),
(145, 32, 'completed', '', 'vnpay', 6530000, '2025-02-27 04:43:10', '2025-02-27 04:43:10', 'bui van chau', '0987654321', 'cuewi , cukuin, daklak', 'SB609YTK', NULL, 100000, 6400000),
(146, 32, 'completed', '', 'vnpay', 12900000, '2025-02-27 04:49:40', '2025-02-27 04:49:40', 'bui van chau', '0987654321', 'cuewi , cukuin, daklak', '1QS6VOJY', NULL, 100000, 12900000),
(147, 32, 'completed', '', 'vnpay', 6400000, '2025-02-27 04:53:38', '2025-02-27 04:53:38', 'bui van chau', '0987654321', 'cuewi , cukuin, daklak', '4LUM5AFC', NULL, 100000, 6400000);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idOrder` int(10) UNSIGNED NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idProductItem` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `idOrder`, `idProduct`, `idProductItem`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(185, 142, 1, 119, 1, 6500000, '2025-02-26 20:17:10', '2025-02-26 20:17:10'),
(186, 143, 1, 119, 1, 6500000, '2025-02-26 20:23:59', '2025-02-26 20:23:59'),
(187, 144, 1, 119, 1, 6500000, '2025-02-26 20:26:31', '2025-02-26 20:26:31'),
(188, 145, 1, 119, 1, 6500000, '2025-02-27 04:43:10', '2025-02-27 04:43:10'),
(189, 146, 1, 118, 2, 6500000, '2025-02-27 04:49:40', '2025-02-27 04:49:40'),
(190, 147, 1, 119, 1, 6500000, '2025-02-27 04:53:38', '2025-02-27 04:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `pic_products`
--

CREATE TABLE `pic_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idProduct` int(20) NOT NULL,
  `imagePath` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pic_products`
--

INSERT INTO `pic_products` (`id`, `idProduct`, `imagePath`, `created_at`, `updated_at`) VALUES
(99, 1, 'uploads/67986b78f06cf_iPhone-11_1.png', '2025-01-28 05:30:32', '2025-01-28 05:30:32'),
(100, 1, 'uploads/67986b78f2b6d_iphone-11-black-1.png', '2025-01-28 05:30:32', '2025-01-28 05:30:32'),
(101, 1, 'uploads/67986b78f39a0_iphone-11-purple-1.png', '2025-01-28 05:30:32', '2025-01-28 05:30:32'),
(102, 1, 'uploads/67986b790014b_iphone-11-red-1.png', '2025-01-28 05:30:33', '2025-01-28 05:30:33'),
(103, 1, 'uploads/67986b7900acc_iphone-11-white-1.png', '2025-01-28 05:30:33', '2025-01-28 05:30:33'),
(104, 1, 'uploads/67986b790122a_iphone-11-yellow-1.png', '2025-01-28 05:30:33', '2025-01-28 05:30:33'),
(105, 6, 'uploads/67986bb800912_iPhone-13_1.png', '2025-01-28 05:31:36', '2025-01-28 05:31:36'),
(106, 6, 'uploads/67986bb8013f6_iphone-13-black.png', '2025-01-28 05:31:36', '2025-01-28 05:31:36'),
(107, 6, 'uploads/67986bb801cbb_iphone-13-pink.png', '2025-01-28 05:31:36', '2025-01-28 05:31:36'),
(108, 8, 'uploads/67986bcc69a38_iPhone-12_1.png', '2025-01-28 05:31:56', '2025-01-28 05:31:56'),
(109, 8, 'uploads/67986bcc6a0dc_iphone-12-black-3.png', '2025-01-28 05:31:56', '2025-01-28 05:31:56'),
(110, 14, 'uploads/67986c0d104bb_iPhone-13-Pro_2 - Copy.jpg', '2025-01-28 05:33:01', '2025-01-28 05:33:01'),
(113, 15, 'uploads/67986c64afa64_iphone-13-pro-gold - Copy.png', '2025-01-28 05:34:28', '2025-01-28 05:34:28'),
(114, 16, 'uploads/67986c9c37eac_iPhone-13-Pro-Max_gray1.png', '2025-01-28 05:35:24', '2025-01-28 05:35:24'),
(115, 18, 'uploads/67986cc2a27ff_iphone-13-pro-max-green.png', '2025-01-28 05:36:02', '2025-01-28 05:36:02'),
(124, 66, 'uploads/ipad-air-6-blue.webp', '2025-02-06 03:30:48', '2025-02-06 03:30:48'),
(125, 66, 'uploads/ipad-air-6-white.webp', '2025-02-06 03:30:48', '2025-02-06 03:30:48'),
(126, 66, 'uploads/iPadAir-m5.webp', '2025-02-06 03:30:48', '2025-02-06 03:30:48');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 11', 'Kích thước to hơn với chất liệu thép không gỉ bền bỉMàn hình 6.5 inch, công nghệ Super Retina XDR hiển thị tuyệt vờiHệ thống 3 camera 12MP sau được nâng cấp đáng kểCấu hình mạnh mẽ với A13 Bionic xử lý nhanh chóng mọi tác vụ', 1, '2025-01-14 02:56:24', '2025-01-14 02:56:24'),
(6, 'iPhone 13', 'Hiệu năng vượt trội - Chip Apple A15 Bionic mạnh mẽ, hỗ trợ mạng 5G tốc độ cao\r\nKhông gian hiển thị sống động - Màn hình 6.1\" Super Retina XDR độ sáng cao, sắc nét\r\nTrải nghiệm điện ảnh đỉnh cao - Camera kép 12MP, hỗ trợ ổn định hình ảnh quang học\r\nTối ưu điện năng - Sạc nhanh 20 W, đầy 50% pin trong khoảng 30 phút', 1, '2025-01-14 02:56:24', '2025-01-14 02:56:24'),
(8, 'iPhone 12', 'Máy mới 100% , chính hãng Apple Việt Nam.\r\nCellphoneS hiện là đại lý bán lẻ uỷ quyền iPhone chính hãng VN/A của Apple Việt Nam\r\nHộp, Sách hướng dẫn, Cây lấy sim, Cáp Lightning - Type C', 1, '2025-01-14 02:56:24', '2025-01-14 02:56:24'),
(14, 'iPhone 12 Pro Max', 'Mạnh mẽ, siêu nhanh với chip A14, RAM 6GB, mạng 5G tốc độ cao\r\nRực rỡ, sắc nét, độ sáng cao - Màn hình OLED cao cấp, Super Retina XDR hỗ trợ HDR10, Dolby Vision\r\nChụp ảnh siêu đỉnh - Night Mode , thuật toán Deep Fusion, Smart HDR 3, camera LiDar\r\nBền bỉ vượt trội - Kháng nước, kháng bụi IP68, mặt lưng Ceramic Shield', 1, '2025-01-14 02:56:24', '2025-01-14 02:56:24'),
(15, 'iPhone 12 Pro', 'Mạnh mẽ, siêu nhanh với chip A14, RAM 6GB, mạng 5G tốc độ cao\r\nRực rỡ, sắc nét, độ sáng cao - Màn hình OLED cao cấp, Super Retina XDR hỗ trợ HDR10, Dolby Vision\r\nChụp ảnh siêu đỉnh - Night Mode , thuật toán Deep Fusion, Smart HDR 3, camera LiDar\r\nBền bỉ vượt trội - Kháng nước, kháng bụi IP68, mặt lưng Ceramic Shield', 1, '2025-01-14 02:56:24', '2025-01-14 02:56:24'),
(16, 'iPhone 13 Pro', 'Hiệu năng vượt trội - Chip Apple A15 Bionic mạnh mẽ, hỗ trợ mạng 5G tốc độ cao\r\nKhông gian hiển thị sống động - Màn hình 6.1\" Super Retina XDR độ sáng cao, sắc nét\r\nTrải nghiệm điện ảnh đỉnh cao - Cụm 3 camera 12MP, hỗ trợ ổn định hình ảnh quang học\r\nTối ưu điện năng - Sạc nhanh 20 W, đầy 50% pin trong khoảng 30 phút', 1, '2025-01-14 02:56:24', '2025-01-14 02:56:24'),
(18, 'iPhone 13 Pro Max', 'Hiệu năng vượt trội - Chip Apple A15 Bionic mạnh mẽ, hỗ trợ mạng 5G tốc độ cao\\nKhông gian hiển thị sống động - Màn hình 6.7\\\" Super Retina XDR độ sáng cao, sắc nét\\nTrải nghiệm điện ảnh đỉnh cao - Cụm 3 camera kép 12MP, hỗ trợ ổn định hình ảnh quang học\\nTối ưu điện năng - Sạc nhanh 20 W, đầy 50% pin trong khoảng 30 phút', 1, '2025-01-14 02:56:24', '2025-01-14 02:56:24'),
(66, 'iphone 16', 'ada', 1, '2025-02-06 03:30:48', '2025-02-06 03:30:48');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `idVariant` int(11) NOT NULL,
  `quantityProduct` int(11) NOT NULL,
  `sku` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idSize` int(11) NOT NULL,
  `idColor` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`idVariant`, `quantityProduct`, `sku`, `price`, `idProduct`, `idSize`, `idColor`, `created_at`, `updated_at`) VALUES
(96, 13, 'iphone13-den-64gb', 13000000, 6, 1, 1, '2025-01-28 05:31:35', '2025-01-28 05:31:35'),
(97, 10, 'iphone13-den-128gb', 13500000, 6, 2, 1, '2025-01-28 05:31:36', '2025-01-28 05:31:36'),
(98, 48, 'iphone12-trang-128gb', 11000000, 8, 2, 2, '2025-01-28 05:31:56', '2025-01-28 05:31:56'),
(99, 10, 'iphone13prm-xanh-512gb', 23000000, 14, 4, 3, '2025-01-28 05:33:01', '2025-01-28 05:33:01'),
(102, 20, 'iphone12pr-vang-128gb', 24000000, 15, 2, 5, '2025-01-28 05:34:28', '2025-01-28 05:34:28'),
(103, 7, 'iphone13pr-den-512gb', 25000000, 16, 3, 1, '2025-01-28 05:35:24', '2025-01-28 05:35:24'),
(118, 98, 'demo1', 6500000, 1, 1, 1, '2025-02-06 03:05:20', '2025-02-06 03:05:20'),
(119, 97, 'iphone11-green-64gb', 6500000, 1, 1, 6, '2025-02-06 03:05:20', '2025-02-06 03:05:20'),
(120, 10, 'iphone13prm-xanh-512gb', 26000000, 18, 4, 6, '2025-02-06 03:16:23', '2025-02-06 03:16:23'),
(121, 20, 'iphone13prm-trang-512gb', 26000000, 18, 4, 2, '2025-02-06 03:16:23', '2025-02-06 03:16:23'),
(128, 3, 'den123', 5000000, 66, 1, 1, '2025-02-10 02:32:36', '2025-02-10 02:32:36'),
(129, 0, 'trang123', 6000000, 66, 2, 2, '2025-02-10 02:32:36', '2025-02-10 02:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `nameSize` varchar(250) NOT NULL,
  `idSize` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`nameSize`, `idSize`, `created_at`, `updated_at`) VALUES
('64GB', 1, '2025-01-14 02:58:27', '2025-01-14 02:58:27'),
('128GB', 2, '2025-01-14 02:58:27', '2025-01-14 02:58:27'),
('256GB', 3, '2025-01-14 02:58:27', '2025-01-14 02:58:27'),
('512GB', 4, '2025-01-14 02:58:27', '2025-01-14 02:58:27'),
('1TB', 5, '2025-01-14 02:58:27', '2025-01-14 02:58:27'),
('2TB', 9, '2025-01-15 01:06:51', '2025-01-15 01:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` text NOT NULL DEFAULT 'storage/uploads/default.jpg',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `otp` varchar(255) DEFAULT NULL,
  `otp_expired_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`, `role`, `otp`, `otp_expired_at`, `status`) VALUES
(24, 'admin', 'admin@gmail.com', '', NULL, '123123', 'uploads/default.jpg', NULL, '2024-12-04 20:38:34', '2024-12-19 07:01:11', 'admin', '105841', '2025-01-13 06:19:38', 'active'),
(26, 'tienphat', 'tienphat123@gmail.com', '', NULL, '123123', 'uploads/default.jpg', NULL, NULL, NULL, 'user', NULL, NULL, 'active'),
(27, 'dat', 'dat@gmail.com', '', NULL, '123123', 'uploads/default.jpg', NULL, NULL, NULL, 'user', NULL, NULL, 'active'),
(29, 'Tiến Đạt Nguyễn', 'datntpk2005@gmail.com', '', NULL, '123123', 'uploads/default.jpg', NULL, NULL, NULL, 'user', NULL, NULL, 'active'),
(32, 'dat', 'ntdad2005@gmail.com', '0847701200', NULL, '123123', 'uploads/1739960745_67b5b1a97d672.jpg', NULL, NULL, NULL, 'admin', '795028', '2025-02-14 21:23:45', 'active'),
(33, 'nguyen manh cuong', 'cuong123@gmail.com', '0987654321', NULL, '123123', 'uploads/default.jpg', NULL, NULL, NULL, 'user', NULL, NULL, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_iduser_foreign` (`idUser`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`idCartItem`),
  ADD KEY `cart_product_productSize` (`idProduct`),
  ADD KEY `productsize` (`idProductItem`),
  ADD KEY `fk_cart_id` (`idCart`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`idColor`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discounts_code_unique` (`code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_iduser_foreign` (`idUser`),
  ADD KEY `discountId_order` (`discount_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_product_productSize_foregkey` (`idOrder`,`idProduct`,`idProductItem`),
  ADD KEY `idProduct` (`idProduct`),
  ADD KEY `idProductItem` (`idProductItem`);

--
-- Indexes for table `pic_products`
--
ALTER TABLE `pic_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `picproduct` (`idProduct`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSubCategory` (`category_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`idVariant`),
  ADD UNIQUE KEY `unique_product_size_color` (`idProduct`,`idSize`,`idColor`),
  ADD KEY `idProduct_size_color_foreigkey` (`idProduct`,`idSize`,`idColor`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`idSize`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `idCartItem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `idColor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `pic_products`
--
ALTER TABLE `pic_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `idVariant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `idSize` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`idCart`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`idProductItem`) REFERENCES `product_variants` (`idVariant`),
  ADD CONSTRAINT `cart_items_ibfk_3` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`idProductItem`) REFERENCES `product_variants` (`idVariant`);

--
-- Constraints for table `pic_products`
--
ALTER TABLE `pic_products`
  ADD CONSTRAINT `fk_pic_product` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`idColor`) REFERENCES `colors` (`idColor`),
  ADD CONSTRAINT `product_variants_ibfk_2` FOREIGN KEY (`idSize`) REFERENCES `sizes` (`idSize`),
  ADD CONSTRAINT `product_variants_ibfk_3` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
