-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 02, 2026 lúc 08:33 AM
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
  `seller_id` int(11) NOT NULL DEFAULT 2,
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
  `is_featured` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bicycles`
--

INSERT INTO `bicycles` (`id`, `seller_id`, `name`, `price`, `category_id`, `brand_id`, `condition_status`, `frame_size`, `location`, `description`, `main_image`, `sub_image1`, `sub_image2`, `sub_image3`, `is_featured`, `created_at`) VALUES
(1, 2, 'Giant Escape 3', 7500000, 3, 1, 'Như mới 95%', 'M', 'TP.HCM', 'Xe đi nhẹ, bảo dưỡng định kỳ, chưa thay thế linh kiện lớn.', 'assets/images/giant-escape-3-main.jpg', 'assets/images/giant-escape-3-1.jpg', 'assets/images/giant-escape-3-2.jpg', 'assets/images/giant-escape-3-3.jpg', 1, '2026-03-25 09:03:02'),
(2, 2, 'Trek Marlin 7', 12000000, 2, 2, 'Đã sử dụng', 'L', 'Hà Nội', 'Xe leo núi mạnh mẽ, phanh đĩa, phù hợp địa hình khó.', 'assets/images/trek-marlin-7-main.jpg', 'assets/images/trek-marlin-7-1.jpg', 'assets/images/trek-marlin-7-2.jpg', 'assets/images/trek-marlin-7-3.jpg', 1, '2026-03-25 09:03:02'),
(3, 2, 'Twitter Thunder Carbon', 18500000, 1, 3, 'Như mới 98%', 'S', 'Đà Nẵng', 'Khung carbon siêu nhẹ, chạy đường dài cực tốt.', 'assets/images/twitter-thunder-carbon-main.jpg', 'assets/images/twitter-thunder-carbon-1.jpg', 'assets/images/twitter-thunder-carbon-2.jpg', 'assets/images/twitter-thunder-carbon-3.jpg', 1, '2026-03-25 09:03:02');

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
-- Cấu trúc bảng cho bảng `cuoc_hoi_thoai`
--

CREATE TABLE `cuoc_hoi_thoai` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `xe_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cuoc_hoi_thoai`
--

INSERT INTO `cuoc_hoi_thoai` (`id`, `buyer_id`, `seller_id`, `xe_id`, `created_at`) VALUES
(1, 1, 2, 1, '2026-04-01 15:30:04');

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
(3, 1, 2, 1, 1500000.00, 'cancelled', '2026-03-21 08:52:14'),
(4, 1, 2, 2, 2400000.00, 'deposit_paid', '2026-03-21 08:52:14'),
(5, 1, 2, 1, 0.00, 'accepted', '2026-03-21 08:52:14'),
(6, 1, 2, 3, 3700000.00, 'deposit_paid', '2026-03-21 08:52:14'),
(7, 1, 2, 3, 3700000.00, 'deposit_paid', '2026-03-21 08:52:14'),
(8, 1, 2, 1, 0.00, 'pending', '2026-03-21 08:52:14'),
(9, 1, 2, 2, 0.00, 'accepted', '2026-03-21 08:52:14'),
(10, 1, 2, 2, 2400000.00, 'deposit_paid', '2026-03-21 08:52:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tin_nhan`
--

CREATE TABLE `tin_nhan` (
  `id` int(11) NOT NULL,
  `hoi_thoai_id` int(11) NOT NULL,
  `nguoi_gui_id` int(11) NOT NULL,
  `noi_dung` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('buyer','seller','admin') DEFAULT 'buyer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Nguyễn Văn A', 'buyer@test.com', '123456', 'buyer', '2026-04-01 15:08:05'),
(2, 'Trần Thị B', 'seller@test.com', '123456', 'seller', '2026-04-01 15:08:05');

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
-- Chỉ mục cho bảng `cuoc_hoi_thoai`
--
ALTER TABLE `cuoc_hoi_thoai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `xe_id` (`xe_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tin_nhan`
--
ALTER TABLE `tin_nhan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hoi_thoai_id` (`hoi_thoai_id`),
  ADD KEY `nguoi_gui_id` (`nguoi_gui_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
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
-- AUTO_INCREMENT cho bảng `cuoc_hoi_thoai`
--
ALTER TABLE `cuoc_hoi_thoai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `tin_nhan`
--
ALTER TABLE `tin_nhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bicycles`
--
ALTER TABLE `bicycles`
  ADD CONSTRAINT `bicycles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `bicycles_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Các ràng buộc cho bảng `cuoc_hoi_thoai`
--
ALTER TABLE `cuoc_hoi_thoai`
  ADD CONSTRAINT `cuoc_hoi_thoai_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cuoc_hoi_thoai_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cuoc_hoi_thoai_ibfk_3` FOREIGN KEY (`xe_id`) REFERENCES `bicycles` (`id`);

--
-- Các ràng buộc cho bảng `tin_nhan`
--
ALTER TABLE `tin_nhan`
  ADD CONSTRAINT `tin_nhan_ibfk_1` FOREIGN KEY (`hoi_thoai_id`) REFERENCES `cuoc_hoi_thoai` (`id`),
  ADD CONSTRAINT `tin_nhan_ibfk_2` FOREIGN KEY (`nguoi_gui_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
