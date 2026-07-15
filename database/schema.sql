-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 15, 2026 lúc 06:17 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `crowdfunding_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `target_amount` decimal(15,2) NOT NULL,
  `current_amount` decimal(15,2) DEFAULT 0.00,
  `image_url` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('pending','active','completed','deleted') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `campaigns`
--

INSERT INTO `campaigns` (`id`, `creator_id`, `title`, `description`, `target_amount`, `current_amount`, `image_url`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 2, 'test update', 'abc', 200000.00, 20000025.00, NULL, '2026-07-01', '2026-08-01', 'deleted', '2026-07-05 21:11:32'),
(2, 2, 'yasuo thach dau', 'deo the hieu', 100000.00, 0.00, NULL, '2006-06-08', '0000-00-00', 'deleted', '2026-07-05 22:44:43'),
(3, 2, 'Faker viet nam', 'He roi ma oi doi oi', 1000000.00, 1000.00, NULL, '2006-05-04', '2009-07-08', 'deleted', '2026-07-05 23:08:09'),
(4, 2, 'yasuo di rung', 'Van khong the hieu chuyen gi xay ra', 1000000.00, 0.00, '1783354062_A&#777;nh chu&#803;p ma&#768;n hi&#768;nh 2026-07-03 203732.png', '2006-06-02', '2009-07-08', 'deleted', '2026-07-06 23:07:42'),
(5, 4, 'leesin', 'Insec v&#7873; tr&#7909;', 100000.00, 1234.00, '1783355741_1.jfif', '2006-02-04', '2020-03-02', 'deleted', '2026-07-06 23:35:41'),
(6, 3, 'a', 'vs', 10000.00, 10135.00, '1783527436_', '2006-02-04', '2028-05-02', 'deleted', '2026-07-08 23:17:16'),
(7, 3, 'ac', 'Gragas max E', 100000.00, 0.00, NULL, '2006-02-04', '2020-04-02', 'deleted', '2026-07-08 23:17:20'),
(8, 2, 'test', 'test', 100000.00, 0.00, NULL, '2026-07-01', '2026-08-01', 'deleted', '2026-07-10 18:53:40'),
(9, 2, 'test', 'test', 100000.00, 0.00, NULL, '2026-07-01', '2026-08-01', 'deleted', '2026-07-10 18:54:13'),
(10, 2, 'test', 'test', 100000.00, 100000.00, NULL, '2026-07-01', '2026-08-01', 'deleted', '2026-07-10 18:54:21'),
(11, 2, 'test', 'test', 100000.00, 0.00, NULL, '2026-07-01', '2026-08-01', 'deleted', '2026-07-10 19:04:01'),
(12, 3, 'Garen', 'Update chiêu R', 1000000.00, 0.00, NULL, '2006-02-02', '2006-02-02', 'deleted', '2026-07-12 19:04:29'),
(13, 3, 'Quyên góp hỗ trợ vùng lũ miền Trung', 'Chiến dịch nhằm kêu gọi cộng đồng chung tay hỗ trợ bà con vùng lũ miền Trung, cung cấp nhu yếu phẩm, thuốc men và hỗ trợ tái thiết sau thiên tai.', 500000000.00, 100000.00, '1783870626_c1.webp', '2026-07-15', '2026-08-15', 'active', '2026-07-12 22:37:06'),
(14, 3, 'Chiến dịch hỗ trợ trẻ em vùng cao', 'Gây quỹ mua sách, áo ấm và đồ dùng học tập cho trẻ em nghèo miền núi.', 50000000.00, 0.00, '1784085047_c2.webp', '2026-07-15', '2026-09-15', 'active', '2026-07-13 23:24:36'),
(15, 3, 'Indie Adventure', 'Một game phiêu lưu indie với đồ họa pixel, kể câu chuyện về một nhân vật nhỏ bé khám phá thế giới rộng lớn', 200000000.00, 0.00, '1784083384_c3.webp', '2026-07-15', '2028-09-15', 'active', '2026-07-15 09:43:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `campaign_id`, `user_id`, `content`, `created_at`) VALUES
(1, 14, 2, 'aaa', '2026-07-14 10:03:40'),
(2, 13, 3, 'aaa', '2026-07-14 22:41:21'),
(3, 14, 2, 'yolo', '2026-07-14 22:54:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `message` text DEFAULT NULL,
  `donated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donations`
--

INSERT INTO `donations` (`id`, `user_id`, `campaign_id`, `amount`, `message`, `donated_at`) VALUES
(1, 2, 1, 25.00, 'gg', '2026-07-05 21:40:16'),
(2, 3, 3, 1000.00, 'anh faker oi', '2026-07-07 22:50:19'),
(3, 3, 5, 1234.00, 'aaaa', '2026-07-07 22:53:46'),
(4, 2, 6, 10000.00, 'abc', '2026-07-12 18:19:42'),
(5, 3, 6, 12.00, 'abc', '2026-07-12 18:20:56'),
(6, 2, 6, 123.00, 'abc', '2026-07-12 18:39:03'),
(7, 2, 1, 20000000.00, 'abc', '2026-07-12 19:08:29'),
(8, 2, 13, 100000.00, 'ủng hộ người dân vùng lũ', '2026-07-12 22:37:58'),
(9, 10, 10, 100000.00, 'chúc', '2026-07-14 21:22:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `favorites`
--

INSERT INTO `favorites` (`user_id`, `campaign_id`) VALUES
(2, 13),
(2, 14),
(3, 13),
(10, 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `financial_reports`
--

CREATE TABLE `financial_reports` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `generated_by` int(11) NOT NULL,
  `income` decimal(15,2) DEFAULT 0.00,
  `expense` decimal(15,2) DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `financial_reports`
--

INSERT INTO `financial_reports` (`id`, `campaign_id`, `generated_by`, `income`, `expense`, `note`, `report_date`) VALUES
(1, 1, 2, 100000.00, 20000.00, 'Chi phí vận chuyển', '2026-07-13 16:17:01'),
(2, 3, 2, 10000.00, 100000.00, 'abc', '2026-07-13 16:17:01'),
(4, 4, 2, 20000.00, 20000.00, 'avas', '2026-07-13 16:17:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `method_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(255) DEFAULT NULL,
  `login_time` datetime DEFAULT current_timestamp(),
  `expired_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `donation_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `transaction_code` varchar(100) DEFAULT NULL,
  `payment_status` enum('pending','success','failed') DEFAULT 'pending',
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','blocked') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `full_name`, `phone`, `avatar`, `role`, `status`, `created_at`) VALUES
(1, 'chuhaanh', 'abc@gmail.com', '123123123', NULL, NULL, NULL, 'user', 'active', '2026-06-19 22:53:43'),
(2, 'duonghieu', 'aaa@gmail.com', '$2y$10$wxaZHGJGmyKtyM7XB5BcautafMYINjmgkb7nyw.7JEUwAsYg06Jsm', NULL, NULL, NULL, 'admin', 'active', '2026-07-05 21:09:03'),
(3, 'trong', 'a@gmail.com', '$2y$10$fyLXZ1KAJnY9N58wHoPumuDCyhNS3hDPrCb2vzszwTbYPd3FXEMKO', NULL, NULL, NULL, 'user', 'active', '2026-07-06 21:27:42'),
(4, 'brotato', 'b@gmail.com', '$2y$10$.Fh3p/vOEZHHA7YOHSRqe.ct.lgxAe7Q7T9lE0AJPMuMgMOYjcNne', NULL, NULL, NULL, 'user', 'active', '2026-07-06 23:31:19'),
(5, 'vlog', 'ab@gmail.com', '$2y$10$xUPDI5ZY2uM21v/3JTZtC.8HX8xk.o8DaCBA9ySwbn95yVSrrvRqy', NULL, NULL, NULL, 'user', 'active', '2026-07-07 23:02:16'),
(7, 'glog', 'as@gmail.com', '$2y$10$HVfdfZb4j501Kv4A36T6SOJeSe1YHpLOS5wXk0GUjM3sOpVmAUXRi', NULL, NULL, NULL, 'user', 'active', '2026-07-07 23:09:39'),
(8, 'aa', 'glock@gmail.com', '$2y$10$T9MJ66immO0L1Y/SUl73HO/6EB.MM/kEVdDmEXtrncCfEhzZvENwq', NULL, NULL, NULL, 'user', 'active', '2026-07-07 23:28:33'),
(9, 'test01', 'test01@gmail.com', '$2y$10$ZRhfFkCIzyfp4ZP51/wv9.RleFnAFIz73MsOCcPy5oQcQiQ9kZGKC', NULL, NULL, NULL, 'user', 'active', '2026-07-10 18:50:12'),
(10, 'gragas', 'abb@gmail.com', '$2y$10$1Z.ydCvtQBuEfgi.dL0IDO1NMHDMdx/a74wihi2BihzRbA74KOl.q', NULL, NULL, NULL, 'user', 'active', '2026-07-14 21:21:36'),
(11, 'nasus', 'acc@gmail.com', '$2y$10$gffSeanVhGO6eg4jS4avUuGiq7QZrzHDhAYkiGifctqUEL27caaBm', NULL, NULL, NULL, 'user', 'active', '2026-07-14 22:00:54'),
(12, 'brand', 'brad.b@gmail.com', '$2y$10$./J5siJWr.3FK7s3s4b4E.vcHPR0FBFsLTaiSXz39x/l.Z6xOvTrq', NULL, NULL, NULL, 'user', 'active', '2026-07-14 22:38:22');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_campaign_creator` (`creator_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_id` (`campaign_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Chỉ mục cho bảng `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`campaign_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Chỉ mục cho bảng `financial_reports`
--
ALTER TABLE `financial_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_id` (`campaign_id`),
  ADD KEY `fk_report_user` (`generated_by`);

--
-- Chỉ mục cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `method_name` (`method_name`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_token` (`session_token`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_code` (`transaction_code`),
  ADD KEY `donation_id` (`donation_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `financial_reports`
--
ALTER TABLE `financial_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `fk_campaign_creator` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `financial_reports`
--
ALTER TABLE `financial_reports`
  ADD CONSTRAINT `financial_reports_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_report_user` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`donation_id`) REFERENCES `donations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
