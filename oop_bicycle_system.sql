-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2026 at 06:09 AM
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
-- Database: `oop_bicycle_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bicycles`
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
-- Dumping data for table `bicycles`
--

INSERT INTO `bicycles` (`id`, `seller_id`, `name`, `price`, `category_id`, `brand_id`, `condition_status`, `frame_size`, `location`, `description`, `main_image`, `sub_image1`, `sub_image2`, `sub_image3`, `is_featured`, `created_at`) VALUES
(1, 2, 'Giant Escape 3', 7500000, 3, 1, 'Như mới 95%', 'M', 'TP.HCM', 'Xe đi nhẹ, bảo dưỡng định kỳ, chưa thay thế linh kiện lớn.', 'assets/images/giant-escape-3-main.jpg', 'assets/images/giant-escape-3-1.jpg', 'assets/images/giant-escape-3-2.jpg', 'assets/images/giant-escape-3-3.jpg', 1, '2026-03-25 09:03:02'),
(2, 2, 'Trek Marlin 7', 12000000, 2, 2, 'Đã sử dụng', 'L', 'Hà Nội', 'Xe leo núi mạnh mẽ, phanh đĩa, phù hợp địa hình khó.', 'assets/images/trek-marlin-7-main.jpg', 'assets/images/trek-marlin-7-1.jpg', 'assets/images/trek-marlin-7-2.jpg', 'assets/images/trek-marlin-7-3.jpg', 1, '2026-03-25 09:03:02'),
(3, 2, 'Twitter Thunder Carbon', 18500000, 1, 3, 'Như mới 98%', 'S', 'Đà Nẵng', 'Khung carbon siêu nhẹ, chạy đường dài cực tốt.', 'assets/images/twitter-thunder-carbon-main.jpg', 'assets/images/twitter-thunder-carbon-1.jpg', 'assets/images/twitter-thunder-carbon-2.jpg', 'assets/images/twitter-thunder-carbon-3.jpg', 1, '2026-03-25 09:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'Giant'),
(2, 'Trek'),
(3, 'Twitter');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
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
-- Table structure for table `cuoc_hoi_thoai`
--

CREATE TABLE `cuoc_hoi_thoai` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `xe_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cuoc_hoi_thoai`
--

INSERT INTO `cuoc_hoi_thoai` (`id`, `buyer_id`, `seller_id`, `xe_id`, `created_at`) VALUES
(1, 1, 2, 1, '2026-04-01 15:30:04'),
(2, 1, 2, 2, '2026-04-06 11:32:59'),
(3, 1, 2, 3, '2026-04-06 11:33:04');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
-- Dumping data for table `orders`
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
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `content` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `tag`, `image`, `date`, `content`) VALUES
(1, 'Top xe đạp bán chạy tháng', 'NEW', '../assets/images/bike_top.jpg', 'Admin · 01/04/2026', '\r\n        <p>Trong thời gian gần đây, xe đạp không chỉ còn là phương tiện di chuyển đơn thuần mà còn trở thành một phần trong lối sống của nhiều người – từ đi học, đi làm cho đến rèn luyện sức khỏe. \r\n        Tuy nhiên, giữa rất nhiều lựa chọn trên thị trường, việc tìm được một chiếc xe “đáng tiền” lại không hề dễ dàng.</p>\r\n\r\n        <p>Hiểu được điều đó, mình đã tổng hợp 3 mẫu xe đạp bán chạy nhất trong tháng – không chỉ vì thương hiệu mà còn vì trải nghiệm thực tế mà chúng mang lại. \r\n        Nếu bạn đang chuẩn bị “xuống tiền”, đây sẽ là những lựa chọn đáng để cân nhắc.</p>\r\n\r\n        <h5> 1. Giant Escape 3 – Lựa chọn an toàn cho người mới bắt đầu</h5>\r\n        <p>Giant Escape 3 là mẫu xe gần như luôn nằm trong top bán chạy bởi sự cân bằng rất tốt giữa giá thành và trải nghiệm. \r\n        Ngay từ lần đầu sử dụng, bạn sẽ cảm nhận được sự nhẹ nhàng khi đạp, xe lướt khá nhanh trên đường phố và không gây cảm giác mệt khi đi quãng đường dài.</p>\r\n\r\n        <p>Điểm đáng giá nhất của Escape 3 nằm ở sự đơn giản nhưng hiệu quả: khung nhôm nhẹ, thiết kế tối ưu cho tư thế ngồi thoải mái và khả năng vận hành ổn định. \r\n        Đây là kiểu xe mà bạn có thể sử dụng mỗi ngày mà không cần suy nghĩ quá nhiều.</p>\r\n\r\n        <p><b>Vì sao nên chọn?</b> Nếu bạn là sinh viên hoặc người mới tập đi xe, đây là khoản đầu tư “an toàn” – không quá đắt nhưng dùng lâu dài và ít hỏng vặt.</p>\r\n        <img src=\"../assets/images/giant-escape-3-1.jpg\" style=\"width:100%; border-radius:10px; margin:10px 0;\">\r\n\r\n        <h5> 2. Trek Marlin 7 – Mạnh mẽ, đa dụng và đáng tin cậy</h5>\r\n        <p>Khác với Escape 3, Trek Marlin 7 hướng đến những người cần một chiếc xe “làm được nhiều hơn”. \r\n        Dù là đường phố, đường xấu hay những chuyến đi xa, chiếc xe này đều mang lại cảm giác chắc chắn và ổn định.</p>\r\n\r\n        <p>Phuộc trước giúp giảm xóc tốt, đặc biệt khi đi qua những đoạn đường gồ ghề. \r\n        Khung xe cứng cáp tạo cảm giác an tâm khi chạy tốc độ cao hoặc leo dốc. \r\n        Đây là dòng xe bạn có thể tin tưởng khi cần một người bạn đồng hành lâu dài.</p>\r\n\r\n        <p><b>Vì sao nên chọn?</b> Nếu bạn không muốn bị giới hạn bởi địa hình và thích một chiếc xe “đi đâu cũng được”, thì Marlin 7 hoàn toàn xứng đáng với số tiền bỏ ra.</p>\r\n        <img src=\"../assets/images/trek-marlin-7-2.jpg\" style=\"width:100%; border-radius:10px; margin:10px 0;\">\r\n\r\n        <h5> 3. Twitter Thunder Carbon – Trải nghiệm cao cấp cho người thích tốc độ</h5>\r\n        <p>Twitter Thunder Carbon là lựa chọn dành cho những ai muốn nâng tầm trải nghiệm. \r\n        Điểm khác biệt lớn nhất nằm ở khung carbon siêu nhẹ – giúp xe tăng tốc nhanh hơn và mang lại cảm giác “lướt” rất rõ rệt so với các dòng xe phổ thông.</p>\r\n\r\n        <p>Không chỉ nhẹ, thiết kế của xe cũng mang đậm chất thể thao và hiện đại, phù hợp với những người thích sự nổi bật. \r\n        Khi đã quen với dòng xe này, bạn sẽ khó quay lại những mẫu xe cơ bản hơn.</p>\r\n\r\n        <p><b>Vì sao nên chọn?</b> Nếu bạn sẵn sàng đầu tư để có trải nghiệm tốt hơn, tốc độ hơn và cảm giác lái “đã” hơn, thì đây là lựa chọn rất đáng tiền.</p>\r\n        <img src=\"../assets/images/twitter-thunder-carbon-3.jpg\" style=\"width:100%; border-radius:10px; margin:10px 0;\">\r\n\r\n        <h5> Đây là những mẫu xe bán chạy nhất tháng. Đâu là lựa chọn dành cho bạn?</h5>\r\n        <p>Mỗi chiếc xe trong danh sách này đều hướng đến một nhóm người dùng khác nhau. \r\n        Nếu bạn cần sự đơn giản và tiết kiệm, Giant Escape 3 là đủ. \r\n        Nếu bạn muốn một chiếc xe bền bỉ, đa dụng, Trek Marlin 7 sẽ không làm bạn thất vọng. \r\n        Và nếu bạn đang tìm kiếm cảm giác mới mẻ, tốc độ và đẳng cấp hơn, Twitter Thunder Carbon là lựa chọn đáng để đầu tư.</p>\r\n\r\n        <p> Lời khuyên thật: hãy chọn chiếc xe phù hợp với nhu cầu hiện tại của bạn. \r\n        Một lựa chọn đúng ngay từ đầu sẽ giúp bạn sử dụng lâu dài và cảm thấy “đáng tiền” hơn rất nhiều.</p>\r\n    '),
(2, 'Cách chọn xe đạp phù hợp', 'TIPS', '../assets/images/bike_tip.jpg', 'Admin · 01/04/2026', '\r\n        <p>Việc chọn một chiếc xe đạp phù hợp không đơn giản chỉ là nhìn vào giá hay mẫu mã. \r\n        Một chiếc xe tốt là chiếc xe phù hợp với nhu cầu sử dụng, thể trạng và thói quen di chuyển của bạn. \r\n        Nếu chọn sai, bạn có thể sẽ cảm thấy khó chịu khi sử dụng hoặc nhanh chóng muốn đổi xe chỉ sau một thời gian ngắn.</p>\r\n\r\n        <p>Dưới đây là những yếu tố quan trọng bạn nên cân nhắc trước khi quyết định mua xe, giúp bạn tránh lãng phí và chọn được chiếc xe thực sự “đáng tiền”.</p>\r\n\r\n        <h5> 1. Xác định rõ mục đích sử dụng</h5>\r\n        <p>Đây là yếu tố quan trọng nhất. Mỗi loại xe được thiết kế cho một mục đích riêng, nếu chọn đúng ngay từ đầu, bạn sẽ có trải nghiệm tốt hơn rất nhiều.</p>\r\n\r\n        <p>• <b>Đi học, đi làm, di chuyển trong thành phố:</b> nên chọn xe hybrid hoặc city bike vì nhẹ, dễ điều khiển và tiết kiệm sức.</p>\r\n        <p>• <b>Đường xấu, địa hình, đi phượt:</b> nên chọn mountain bike (MTB) để có độ bền và khả năng giảm xóc tốt.</p>\r\n        <p>• <b>Tốc độ, tập luyện thể thao:</b> road bike hoặc xe khung carbon sẽ giúp bạn đạp nhanh và hiệu quả hơn.</p>\r\n\r\n        <p><b>Lời khuyên:</b> Đừng cố chọn xe “đa năng” nếu bạn đã biết rõ nhu cầu chính của mình. Chọn đúng mục đích sẽ giúp bạn hài lòng lâu dài hơn.</p>\r\n\r\n        <h5> 2. Chọn đúng size khung – yếu tố nhiều người bỏ qua</h5>\r\n        <p>Một chiếc xe dù tốt đến đâu nhưng sai size vẫn sẽ gây khó chịu khi sử dụng. \r\n        Bạn có thể bị đau lưng, mỏi vai hoặc khó kiểm soát xe nếu khung không phù hợp.</p>\r\n\r\n        <p>• Người cao <b>160 – 170cm</b>: nên chọn size S hoặc M</p>\r\n        <p>• Người cao <b>170 – 180cm</b>: nên chọn size M hoặc L</p>\r\n        <p>• Trên <b>180cm</b>: nên chọn size L hoặc XL</p>\r\n\r\n        <p><b>Mẹo nhỏ:</b> Khi ngồi lên xe, bạn nên cảm thấy thoải mái, không bị với tay quá xa hoặc gập người quá nhiều.</p>\r\n\r\n        <h5> 3. Xác định ngân sách hợp lý</h5>\r\n        <p>Không phải cứ xe đắt là tốt nhất. Điều quan trọng là chiếc xe có phù hợp với nhu cầu của bạn hay không.</p>\r\n\r\n        <p>• Tầm <b>5 – 10 triệu</b>: phù hợp cho nhu cầu cơ bản, đi lại hằng ngày</p>\r\n        <p>• Tầm <b>10 – 20 triệu</b>: chất lượng tốt hơn, đa dụng hơn</p>\r\n        <p>• Trên <b>20 triệu</b>: dành cho trải nghiệm cao cấp hoặc tập luyện chuyên sâu</p>\r\n\r\n        <p><b>Lời khuyên:</b> Nếu bạn là người mới, không cần thiết phải đầu tư quá nhiều ngay từ đầu. \r\n        Một chiếc xe tầm trung là đủ để bạn làm quen và sử dụng lâu dài.</p>\r\n\r\n        <h5> 4. Kiểm tra kỹ nếu mua xe cũ</h5>\r\n        <p>Xe cũ có thể giúp bạn tiết kiệm chi phí, nhưng cũng tiềm ẩn nhiều rủi ro nếu không kiểm tra kỹ.</p>\r\n\r\n        <p>• Kiểm tra <b>khung xe</b>: không bị nứt, cong</p>\r\n        <p>• Kiểm tra <b>phanh</b>: hoạt động tốt, không bị bó</p>\r\n        <p>• Kiểm tra <b>xích, líp</b>: không bị mòn quá nhiều</p>\r\n\r\n        <p><b>Lưu ý:</b> Nếu bạn không có kinh nghiệm, nên đi cùng người có hiểu biết hoặc chọn mua ở cửa hàng uy tín.</p>\r\n\r\n        <h5> Tổng kết</h5>\r\n        <p>Chọn xe đạp không khó, quan trọng là bạn hiểu rõ nhu cầu của mình. \r\n        Hãy bắt đầu từ mục đích sử dụng, chọn đúng size, cân nhắc ngân sách và kiểm tra kỹ trước khi mua.</p>\r\n\r\n        <p>👉 Một chiếc xe phù hợp sẽ không chỉ giúp bạn di chuyển dễ dàng hơn mà còn tạo động lực để bạn duy trì thói quen đạp xe mỗi ngày. \r\n        Và đó mới là giá trị thực sự của một chiếc xe tốt.</p>\r\n    '),
(3, 'Hành trình đạp xe đáng nhớ', 'TRAVEL', '../assets/images/bike_travel.jpg', 'Admin · 01/04/2026', '\r\n        <p>Đạp xe không chỉ đơn giản là một môn thể thao, mà còn là cách để bạn cảm nhận thế giới theo một nhịp độ rất khác – chậm hơn, gần gũi hơn và chân thật hơn. \r\n        Không có cửa kính ngăn cách, không có tiếng động cơ ồn ào, chỉ có bạn, chiếc xe và những cung đường phía trước.</p>\r\n\r\n        <p>Trong bài viết này, mình muốn chia sẻ một vài hành trình đạp xe đáng nhớ mà bất cứ ai yêu thích xe đạp cũng nên thử ít nhất một lần. \r\n        Mỗi nơi mang một cảm xúc riêng, nhưng điểm chung là đều để lại những trải nghiệm rất khó quên.</p>\r\n\r\n        <h5> Cung đường Đà Lạt – Mát mẻ và đầy cảm hứng</h5>\r\n        <p>Đà Lạt luôn là điểm đến lý tưởng cho những chuyến đạp xe nhờ khí hậu dễ chịu quanh năm. \r\n        Một trong những cung đường đẹp nhất là từ trung tâm thành phố đến hồ Tuyền Lâm, dài khoảng 8km.</p>\r\n\r\n        <p>Trên đường đi, bạn sẽ cảm nhận rõ không khí se lạnh, những hàng thông xanh và khung cảnh yên bình rất đặc trưng của Đà Lạt. \r\n        Đây không phải là cung đường quá khó, nhưng đủ để bạn vừa vận động, vừa tận hưởng thiên nhiên.</p>\r\n\r\n        <p><b>Cảm nhận:</b> Nhẹ nhàng, thư giãn, cực kỳ phù hợp cho những chuyến đi “reset” lại bản thân.</p>\r\n\r\n        <h5> Ven biển Mũi Né – Tự do và khoáng đạt</h5>\r\n        <p>Nếu bạn thích cảm giác gió biển và không gian rộng mở, thì Mũi Né là lựa chọn không thể bỏ qua. \r\n        Đạp xe vào buổi sáng sớm, khi nắng còn nhẹ và đường còn vắng, là thời điểm lý tưởng nhất.</p>\r\n\r\n        <p>Con đường ven biển dài, thoáng, một bên là biển xanh, một bên là đồi cát tạo nên khung cảnh rất đặc biệt. \r\n        Cảm giác vừa đạp xe vừa nghe tiếng sóng biển thực sự rất “đã”.</p>\r\n\r\n        <p><b>Cảm nhận:</b> Tự do, thoải mái, rất phù hợp cho những ai muốn trải nghiệm cảm giác “đi thật xa”.</p>\r\n\r\n        <h5> Phố cổ Hội An – Chậm rãi và đầy hoài niệm</h5>\r\n        <p>Hội An có thể xem là “thiên đường xe đạp” với nhịp sống chậm và không gian yên bình. \r\n        Việc đạp xe quanh phố cổ, len lỏi qua từng con hẻm nhỏ mang lại một trải nghiệm rất khác so với các phương tiện khác.</p>\r\n\r\n        <p>Bạn có thể dừng lại bất cứ lúc nào để uống cà phê, chụp ảnh hoặc đơn giản là ngồi nhìn dòng người qua lại. \r\n        Đây là kiểu hành trình không cần vội vàng, chỉ cần tận hưởng.</p>\r\n\r\n        <p><b>Cảm nhận:</b> Nhẹ nhàng, sâu lắng, phù hợp để “sống chậm” và tận hưởng từng khoảnh khắc.</p>\r\n\r\n        <h5> Tổng kết</h5>\r\n        <p>Mỗi hành trình đạp xe đều mang lại một trải nghiệm khác nhau, từ nhẹ nhàng ở Đà Lạt, phóng khoáng ở Mũi Né cho đến yên bình tại Hội An. \r\n        Điều quan trọng không phải là bạn đi xa bao nhiêu, mà là bạn cảm nhận được gì trên từng vòng quay của bánh xe.</p>\r\n\r\n        <p> Nếu có cơ hội, hãy thử một chuyến đi như vậy. \r\n        Chỉ cần một chiếc xe phù hợp, một chút thời gian và tinh thần sẵn sàng khám phá, bạn sẽ có những kỷ niệm mà không chuyến đi nào khác mang lại được.</p>\r\n    '),
(4, 'Xe đạp thể thao cho người mới', 'NEWBIE', '../assets/images/bike_newbie.jpg', 'Admin · 01/04/2026', '\r\n        <p>Nếu bạn đang muốn bắt đầu với xe đạp thể thao nhưng chưa biết nên chọn loại nào, bắt đầu từ đâu hay cần chuẩn bị những gì, thì bạn không hề đơn độc. \r\n        Rất nhiều người cũng từng ở vị trí giống bạn – và tin tốt là: bắt đầu đạp xe dễ hơn bạn nghĩ rất nhiều.</p>\r\n\r\n        <p>Quan trọng nhất không phải là mua một chiếc xe thật đắt tiền, mà là chọn đúng loại phù hợp với nhu cầu và tạo được thói quen sử dụng lâu dài.</p>\r\n\r\n        <h5>🚲 1. Người mới nên bắt đầu với loại xe nào?</h5>\r\n        <p>Đối với người mới, bạn không cần những dòng xe quá chuyên sâu hay cấu hình cao. \r\n        Thay vào đó, hãy ưu tiên những dòng xe dễ sử dụng, tư thế ngồi thoải mái và phù hợp với đường phố Việt Nam.</p>\r\n\r\n        <p><b>Gợi ý:</b></p>\r\n        <ul>\r\n            <li><b>Hybrid bike (xe lai):</b> Kết hợp giữa tốc độ và sự thoải mái, phù hợp đi học, đi làm và tập thể dục.</li>\r\n            <li><b>City bike:</b> Thiết kế đơn giản, dễ điều khiển, rất phù hợp cho nhu cầu di chuyển hằng ngày.</li>\r\n        </ul>\r\n\r\n        <p> Đây là những lựa chọn “an toàn” giúp bạn làm quen với việc đạp xe mà không bị quá sức hay khó điều khiển.</p>\r\n\r\n        <h5> 2. Chọn size xe – yếu tố nhiều người bỏ qua</h5>\r\n        <p>Một chiếc xe phù hợp kích thước sẽ giúp bạn đạp thoải mái hơn, tránh đau lưng và hạn chế chấn thương.</p>\r\n\r\n        <ul>\r\n            <li>Chiều cao 150–165cm → Size S</li>\r\n            <li>Chiều cao 165–175cm → Size M</li>\r\n            <li>Chiều cao 175–185cm → Size L</li>\r\n        </ul>\r\n\r\n        <p> Nếu có thể, hãy thử ngồi lên xe trước khi mua để cảm nhận rõ nhất.</p>\r\n\r\n        <h5> 3. Những trang bị cần thiết khi bắt đầu</h5>\r\n        <p>Đạp xe an toàn quan trọng hơn bất kỳ yếu tố nào khác. \r\n        Dưới đây là những món cơ bản bạn nên chuẩn bị:</p>\r\n\r\n        <ul>\r\n            <li><b>Mũ bảo hiểm:</b> Bắt buộc – bảo vệ bạn trong mọi tình huống.</li>\r\n            <li><b>Găng tay:</b> Giảm đau tay khi đạp lâu.</li>\r\n            <li><b>Kính:</b> Chống bụi, côn trùng và ánh nắng.</li>\r\n            <li><b>Bơm mini / bộ vá lốp:</b> Phòng trường hợp xe bị xẹp giữa đường.</li>\r\n        </ul>\r\n\r\n        <p> Không cần mua tất cả ngay từ đầu, nhưng mũ bảo hiểm là thứ bạn không nên bỏ qua.</p>\r\n\r\n        <h5> 4. Bắt đầu luyện tập như thế nào?</h5>\r\n        <p>Đừng cố gắng đạp quá xa ngay từ ngày đầu tiên. \r\n        Điều quan trọng là tạo thói quen và để cơ thể thích nghi dần.</p>\r\n\r\n        <ul>\r\n            <li>Tuần đầu: 5–10km / ngày</li>\r\n            <li>Tuần 2–3: tăng lên 10–15km</li>\r\n            <li>Sau 1 tháng: có thể thử 20km trở lên</li>\r\n        </ul>\r\n\r\n        <p>Hãy giữ tốc độ vừa phải, tập trung vào cảm giác thoải mái thay vì cố gắng đi nhanh.</p>\r\n\r\n        <h5> 5. Một vài lời khuyên cho người mới</h5>\r\n        <ul>\r\n            <li>Không cần mua xe quá đắt ngay từ đầu</li>\r\n            <li>Ưu tiên sự thoải mái hơn tốc độ</li>\r\n            <li>Đạp đều đặn quan trọng hơn đạp xa</li>\r\n            <li>Bảo dưỡng xe định kỳ để xe luôn vận hành tốt</li>\r\n        </ul>\r\n\r\n        <p>Bắt đầu với xe đạp thể thao không hề khó. \r\n        Chỉ cần một chiếc xe phù hợp, một chút kiên trì và thói quen luyện tập, bạn sẽ nhanh chóng cảm nhận được lợi ích cả về sức khỏe lẫn tinh thần.</p>\r\n\r\n        <p> Đừng chờ “chuẩn bị hoàn hảo” mới bắt đầu. \r\n        Chỉ cần có xe – bạn đã sẵn sàng cho hành trình của mình rồi.</p>\r\n    '),
(5, 'Kinh nghiệm bảo dưỡng xe', 'TIPS', '../assets/images/bike_fix.jpg', 'Admin · 01/04/2026', '\r\n        <p>Một chiếc xe đạp dù tốt đến đâu cũng sẽ xuống cấp theo thời gian nếu không được bảo dưỡng đúng cách. \r\n        Việc chăm sóc xe định kỳ không chỉ giúp xe vận hành mượt mà hơn mà còn tiết kiệm chi phí sửa chữa về lâu dài và đảm bảo an toàn cho bạn trên mọi hành trình.</p>\r\n\r\n        <p>Điều quan trọng là bạn không cần phải là thợ chuyên nghiệp – chỉ cần nắm một vài nguyên tắc cơ bản, bạn hoàn toàn có thể tự bảo dưỡng chiếc xe của mình tại nhà.</p>\r\n\r\n        <h5> 1. Vệ sinh xích và líp – việc nhỏ nhưng cực kỳ quan trọng</h5>\r\n        <p>Xích là bộ phận hoạt động liên tục và dễ bám bụi bẩn nhất. Nếu không vệ sinh thường xuyên, xích sẽ nhanh mòn, gây tiếng ồn và làm việc chuyển số trở nên kém mượt.</p>\r\n\r\n        <ul>\r\n            <li>Lau xích bằng khăn khô sau khi đi mưa hoặc đường bụi</li>\r\n            <li>Tra dầu chuyên dụng mỗi 2–3 tuần</li>\r\n            <li>Tránh dùng dầu nhớt xe máy vì dễ bám bụi</li>\r\n        </ul>\r\n\r\n        <p> Một sợi xích sạch sẽ giúp xe chạy nhẹ hơn rõ rệt.</p>\r\n\r\n        <h5> 2. Kiểm tra phanh – yếu tố an toàn hàng đầu</h5>\r\n        <p>Phanh là bộ phận bạn không nên “để ý khi có vấn đề”, mà cần kiểm tra thường xuyên ngay cả khi xe vẫn chạy bình thường.</p>\r\n\r\n        <ul>\r\n            <li>Bóp thử phanh trước mỗi chuyến đi</li>\r\n            <li>Nếu phanh bị lỏng hoặc ăn chậm → cần chỉnh lại dây</li>\r\n            <li>Má phanh mòn quá 50% → nên thay ngay</li>\r\n        </ul>\r\n\r\n        <p> Một hệ thống phanh tốt có thể giúp bạn tránh được những tình huống nguy hiểm bất ngờ.</p>\r\n\r\n        <h5> 3. Bơm lốp đúng áp suất – đạp nhẹ hơn, đi xa hơn</h5>\r\n        <p>Nhiều người thường bỏ qua việc kiểm tra áp suất lốp, nhưng đây lại là yếu tố ảnh hưởng trực tiếp đến trải nghiệm đạp xe.</p>\r\n\r\n        <ul>\r\n            <li>Lốp xe đường phố: khoảng 80–100 PSI</li>\r\n            <li>Lốp địa hình: thấp hơn để tăng độ bám</li>\r\n            <li>Kiểm tra lốp mỗi tuần để tránh xẹp bất ngờ</li>\r\n        </ul>\r\n\r\n        <p> Lốp đủ hơi giúp giảm ma sát, tiết kiệm sức và hạn chế hỏng săm.</p>\r\n\r\n        <h5> 4. Kiểm tra ốc vít và khung xe</h5>\r\n        <p>Sau một thời gian sử dụng, các ốc vít trên xe có thể bị lỏng do rung lắc. \r\n        Điều này có thể gây ra tiếng kêu khó chịu hoặc thậm chí mất an toàn khi di chuyển.</p>\r\n\r\n        <ul>\r\n            <li>Kiểm tra định kỳ các vị trí như cổ lái, yên xe, bánh xe</li>\r\n            <li>Siết chặt lại nếu phát hiện lỏng</li>\r\n            <li>Quan sát khung xe để phát hiện nứt hoặc cong bất thường</li>\r\n        </ul>\r\n\r\n        <h5> 5. Giữ xe luôn sạch sẽ</h5>\r\n        <p>Một chiếc xe sạch không chỉ đẹp hơn mà còn giúp bạn dễ dàng phát hiện các vấn đề sớm hơn.</p>\r\n\r\n        <ul>\r\n            <li>Rửa xe nhẹ nhàng bằng nước và khăn mềm</li>\r\n            <li>Tránh xịt nước áp lực mạnh vào ổ trục</li>\r\n            <li>Lau khô sau khi rửa để tránh rỉ sét</li>\r\n        </ul>\r\n\r\n        <h5> Một vài lưu ý nhỏ nhưng hữu ích</h5>\r\n        <ul>\r\n            <li>Nếu không tự tin sửa chữa, hãy mang xe ra tiệm định kỳ 2–3 tháng/lần</li>\r\n            <li>Luôn mang theo bộ dụng cụ cơ bản khi đi xa</li>\r\n            <li>Nghe tiếng xe – nếu có âm thanh lạ, đó là dấu hiệu cần kiểm tra</li>\r\n        </ul>\r\n\r\n        <p>Chăm sóc xe đạp không hề phức tạp, nhưng lại mang đến sự khác biệt rất lớn trong trải nghiệm sử dụng. \r\n        Một chiếc xe được bảo dưỡng tốt sẽ luôn mang lại cảm giác êm ái, nhẹ nhàng và đáng tin cậy trên mọi cung đường.</p>\r\n\r\n        <p> Hãy dành một chút thời gian cho chiếc xe của bạn – nó sẽ “đáp lại” bằng những hành trình mượt mà hơn rất nhiều.</p>\r\n    ');

-- --------------------------------------------------------

--
-- Table structure for table `tin_nhan`
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
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Nguyễn Văn A', 'buyer@test.com', '123456', 'buyer', '2026-04-01 15:08:05'),
(2, 'Trần Thị B', 'seller@test.com', '123456', 'seller', '2026-04-01 15:08:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bicycles`
--
ALTER TABLE `bicycles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuoc_hoi_thoai`
--
ALTER TABLE `cuoc_hoi_thoai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `xe_id` (`xe_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tin_nhan`
--
ALTER TABLE `tin_nhan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hoi_thoai_id` (`hoi_thoai_id`),
  ADD KEY `nguoi_gui_id` (`nguoi_gui_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bicycles`
--
ALTER TABLE `bicycles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cuoc_hoi_thoai`
--
ALTER TABLE `cuoc_hoi_thoai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tin_nhan`
--
ALTER TABLE `tin_nhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bicycles`
--
ALTER TABLE `bicycles`
  ADD CONSTRAINT `bicycles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `bicycles_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Constraints for table `cuoc_hoi_thoai`
--
ALTER TABLE `cuoc_hoi_thoai`
  ADD CONSTRAINT `cuoc_hoi_thoai_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cuoc_hoi_thoai_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cuoc_hoi_thoai_ibfk_3` FOREIGN KEY (`xe_id`) REFERENCES `bicycles` (`id`);

--
-- Constraints for table `tin_nhan`
--
ALTER TABLE `tin_nhan`
  ADD CONSTRAINT `tin_nhan_ibfk_1` FOREIGN KEY (`hoi_thoai_id`) REFERENCES `cuoc_hoi_thoai` (`id`),
  ADD CONSTRAINT `tin_nhan_ibfk_2` FOREIGN KEY (`nguoi_gui_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
