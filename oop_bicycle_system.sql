-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 26, 2026 lúc 04:22 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `oop_bicycle_system`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bicycles`
--

CREATE TABLE `bicycles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `condition_status` varchar(50) DEFAULT NULL,
  `frame_size` varchar(20) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `sub_image1` varchar(255) DEFAULT NULL,
  `sub_image2` varchar(255) DEFAULT NULL,
  `sub_image3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bicycles`
--

INSERT INTO `bicycles` (`id`, `name`, `price`, `category_id`, `brand_id`, `condition_status`, `frame_size`, `location`, `description`, `main_image`, `sub_image1`, `sub_image2`, `sub_image3`, `created_at`) VALUES
(1, 'Giant Escape 3', 7500000, 3, 1, 'Như mới 95%', 'M', 'TP.HCM', 'Xe đi nhẹ, bảo dưỡng định kỳ, chưa thay thế linh kiện lớn.', 'assets/images/giant-escape-3-main.jpg', 'assets/images/giant-escape-3-1.jpg', 'assets/images/giant-escape-3-2.jpg', 'assets/images/giant-escape-3-3.jpg', '2026-03-25 09:03:02'),
(2, 'Trek Marlin 7', 12000000, 2, 2, 'Đã sử dụng', 'L', 'Hà Nội', 'Xe leo núi mạnh mẽ, phanh đĩa, phù hợp địa hình khó.', 'assets/images/trek-marlin-7-main.jpg', 'assets/images/trek-marlin-7-1.jpg', 'assets/images/trek-marlin-7-2.jpg', 'assets/images/trek-marlin-7-3.jpg', '2026-03-25 09:03:02'),
(3, 'Twitter Thunder Carbon', 18500000, 1, 3, 'Như mới 98%', 'S', 'Đà Nẵng', 'Khung carbon siêu nhẹ, chạy đường dài cực tốt.', 'assets/images/twitter-thunder-carbon-main.jpg', 'assets/images/twitter-thunder-carbon-1.jpg', 'assets/images/twitter-thunder-carbon-2.jpg', 'assets/images/twitter-thunder-carbon-3.jpg', '2026-03-25 09:03:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'Giant'),
(2, 'Trek'),
(3, 'Twitter');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Road Bike', NULL, '2026-03-21 07:24:26'),
(2, 'Mountain Bike', NULL, '2026-03-21 07:24:26'),
(3, 'Hybrid Bike', NULL, '2026-03-21 07:24:26'),
(4, 'Touring Bike', NULL, '2026-03-21 07:24:26'),
(5, 'Gravel Bike', NULL, '2026-03-21 07:24:26'),
(6, 'Folding Bike', NULL, '2026-03-21 07:24:26'),
(7, 'BMX', NULL, '2026-03-21 07:24:26'),
(8, 'Fixed Gear', NULL, '2026-03-21 07:24:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `bike_id` int(11) DEFAULT NULL,
  `deposit_amount` decimal(12,2) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','deposit_paid','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `seller_id`, `bike_id`, `deposit_amount`, `status`, `created_at`) VALUES
(1, 1, 2, 1, 1500000.00, 'deposit_paid', '2026-03-21 15:52:14'),
(2, 1, 2, 2, 2400000.00, 'deposit_paid', '2026-03-21 15:52:14'),
(3, 1, 2, 1, 0.00, 'cancelled', '2026-03-21 08:52:14'),
(4, 1, 2, 2, 2400000.00, 'cancelled', '2026-03-21 08:52:14'),
(5, 1, 2, 1, 0.00, 'pending', '2026-03-21 08:52:14'),
(6, 1, 2, 3, 0.00, 'accepted', '2026-03-21 08:52:14'),
(7, 1, 2, 3, 0.00, 'accepted', '2026-03-21 08:52:14'),
(8, 1, 2, 1, 0.00, 'pending', '2026-03-21 08:52:14'),
(9, 1, 2, 2, 0.00, 'pending', '2026-03-21 08:52:14'),
(10, 1, 2, 2, 0.00, 'accepted', '2026-03-21 08:52:14');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bicycles`
--
ALTER TABLE `bicycles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bicycles`
--
ALTER TABLE `bicycles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bicycles`
--
ALTER TABLE `bicycles`
  ADD CONSTRAINT `bicycles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `bicycles_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
