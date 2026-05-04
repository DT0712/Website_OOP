-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 27, 2026 lúc 06:03 PM
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
-- Cơ sở dữ liệu: `bike_market`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id_khach_hang` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dien_thoai` varchar(20) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `anh_dai_dien` varchar(255) DEFAULT NULL,
  `anh_nen` varchar(255) DEFAULT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khach_hang`
--

INSERT INTO `khach_hang` (`id_khach_hang`, `ho_ten`, `email`, `dien_thoai`, `ngay_sinh`, `dia_chi`, `anh_dai_dien`, `anh_nen`, `mat_khau`, `ngay_tao`) VALUES
(1, 'Trương Duy', 'Ducduy102938@gmail.com', '0325144221', NULL, NULL, 'uploads/avatars/suggest/avatar8.jpg', 'uploads/covers/1775576102_69d52426e66ec.webp', '$2y$10$UFM8hfFfQ9AL9apSgxhqEuC1t2jdLNdozTXOJeaKHFG0pSDaPDBQe', '2025-12-02 16:24:55'),
(2, 'Nguyễn Văn An', 'an.nguyen@gmail.com', '0901234567', NULL, NULL, 'uploads/avatars/suggest/avatar5.jpg', 'uploads/covers/1777220406_diamond_use_case.png', '$2y$10$examplehash1234567890', '2025-11-15 10:30:00'),
(3, 'Trần Thị Bé', 'be.tran@yahoo.com', '0912345678', NULL, NULL, NULL, NULL, '$2y$10$examplehash1234567890', '2025-11-18 14:20:00'),
(4, 'Lê Văn Cường', 'cuong.le@hotmail.com', '0329876543', NULL, NULL, NULL, NULL, '$2y$10$examplehash1234567890', '2025-11-20 09:15:00'),
(5, 'Phạm Minh Đức', 'duc.pham@gmail.com', '0388889999', NULL, NULL, NULL, NULL, '$2y$10$examplehash1234567890', '2025-11-22 16:45:00'),
(6, 'Hoàng Yến Nhi', 'nhi.hoang@gmail.com', '0777123456', NULL, NULL, NULL, NULL, '$2y$10$examplehash1234567890', '2025-11-25 11:00:00'),
(7, 'Vũ Ngọc Lan', 'lan.vu@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$10$examplehash1234567890', '2025-11-28 08:30:00'),
(8, 'Đỗ Quang Huy', 'huy.do@gmail.com', '0935123456', NULL, NULL, NULL, NULL, '$2y$10$examplehash1234567890', '2025-12-01 13:20:00'),
(9, 'Bùi Thị Mai', 'mai.bui@gmail.com', '0966789123', NULL, NULL, NULL, NULL, '$2y$10$examplehash1234567890', '2025-12-02 17:55:00'),
(10, 'Ngô Văn Tuấn', 'tuan.ngo@gmail.com', '0355558888', NULL, NULL, NULL, NULL, '$2y$10$examplehash1234567890', '2025-12-03 10:10:00'),
(11, 'Lý Kim Ngân', 'ngan.ly@gmail.com', '0399991111', NULL, NULL, NULL, NULL, '$2y$10$examplehash1234567890', '2025-12-04 15:40:00'),
(12, 'H Trương', 'vipro@gmail.com', '0898538893', NULL, NULL, NULL, NULL, '$2y$10$SoLdCpg8k/r3FSDP9d8.1eswHfvWq4Q7Pw01vpbz/ix573d0xXhBq', '2025-12-06 13:11:19'),
(13, 'Huệ Bích', 'huehtb3441@ut.edu.vn', '0978565643', NULL, NULL, 'uploads/avatars/suggest/avatar2.jpg', NULL, '$2y$10$lb68BfXwODowQFSBbWQNfeEWMkXyx.Pnskahyl3d73cAKCtfmVEu2', '2026-03-30 20:01:48'),
(14, 'Bỉ Đức', 'ducbi1@gmail.com', '0367079129', NULL, NULL, 'uploads/avatars/suggest/avatar3.jpg', 'uploads/covers/1776624542_69e5239e19f03.png', '$2y$10$n1/XbJ7qsJYjjSuXJX04T.Y63dbVSPVk/BKesC6uJA2Wb/JegleZi', '2026-04-20 01:45:41'),
(27, 'Nguyễn Văn B', 'buser@gmail.com', '0943498416', NULL, NULL, 'uploads/avatars/1777240421_Ca_Chuot_Cafe.jpg', 'uploads/covers/1777240421_images.jpg', '$2y$10$lfPSGnEFfRhpauzyAiLlk.uQilHXwuHggFw2UmAMrD/tehpy198ry', '2026-04-27 04:53:41'),
(45, 'Nguyễn Văn D', 'duser@gmail.com', '0943498414', '2000-06-22', 'TPHCM', 'uploads/avatars/suggest/avatar4.jpg', 'uploads/covers/1777301147_69ef769b99407.jpg', '$2y$10$iK4MIXB1UevFyIJuTMLaWuSm7j7UdPOqj5qLbSvxb9huRHCq7xK1O', '2026-04-27 21:45:47');

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
(1, 'Nguyễn Văn A', 'buyer@test.com', '123456', 'buyer', '2026-04-01 08:08:05'),
(2, 'Trần Thị B', 'seller@test.com', '123456', 'seller', '2026-04-01 15:08:05');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id_khach_hang`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id_khach_hang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
