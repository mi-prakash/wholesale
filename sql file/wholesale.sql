-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2021 at 10:25 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wholesale`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 9, '2826.00', '2021-11-25 19:37:38', '2021-11-25 19:37:38'),
(2, 2, 8, '449.99', '2021-11-25 19:38:07', '2021-11-25 19:38:07'),
(3, 2, 6, '50.00', '2021-11-25 19:38:09', '2021-11-25 19:38:09'),
(4, 2, 10, '3140.00', '2021-11-25 19:38:11', '2021-11-25 19:38:11'),
(5, 2, 10, '3140.00', '2021-11-25 19:40:37', '2021-11-25 19:40:37'),
(6, 2, 10, '3140.00', '2021-11-25 19:40:39', '2021-11-25 19:40:39'),
(7, 2, 10, '3140.00', '2021-11-25 19:40:41', '2021-11-25 19:40:41'),
(8, 2, 10, '3140.00', '2021-11-25 19:40:43', '2021-11-25 19:40:43'),
(10, 2, 1, '1100.00', '2021-11-26 07:13:15', '2021-11-26 07:13:15'),
(11, 2, 13, '499.00', '2021-11-26 07:13:17', '2021-11-26 07:13:17'),
(12, 1, 13, '449.10', '2021-11-26 09:06:32', '2021-11-26 09:06:32'),
(13, 2, 12, '130.00', '2021-11-26 10:08:24', '2021-11-26 10:08:24'),
(14, 4, 5, '54.00', '2021-11-26 10:15:54', '2021-11-26 10:15:54'),
(15, 4, 3, '1080.00', '2021-11-26 10:16:02', '2021-11-26 10:16:02'),
(16, 2, 5, '60.00', '2021-11-26 10:24:18', '2021-11-26 10:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retail_price` decimal(8,2) NOT NULL,
  `wholesale_price` decimal(8,2) NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_by` int(11) NOT NULL,
  `status` enum('published','unpublished') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `retail_price`, `wholesale_price`, `image`, `image_2`, `publish_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 13 512GB Silver', '1100.00', '990.00', 'assets/images/products/ID_1_IMG1_619e2a6e7a1be.jpg', NULL, 1, 'published', '2021-11-19 14:10:20', NULL),
(2, 'Sony Bravia 40\"', '1200.00', '1080.00', 'assets/images/products/ID_2_IMG1_619e2f8ebb44d.jpg', NULL, 1, 'published', '2021-11-19 14:18:20', NULL),
(3, 'Sharp Fridge 400 Ltr', '1200.00', '1080.00', 'assets/images/products/ID_3_IMG1_619fa21a1b151.jpg', NULL, 1, 'published', '2021-11-23 13:42:05', NULL),
(4, 'Full Interior service', '1200.00', '1080.00', 'assets/images/products/ID_7_IMG1_619dda902895c.jpg', NULL, 1, 'published', '2021-11-24 07:24:16', '2021-11-24 07:24:16'),
(5, 'Gaming Channel', '60.00', '54.00', 'assets/images/products/ID_5_IMG1_619e1407cd1b8.jpeg', NULL, 1, 'published', '2021-11-24 11:29:27', NULL),
(6, 'Cook Book', '50.00', '45.00', 'assets/images/products/ID_6_IMG1_619e14c75851d.png', 'assets/images/products/ID_6_IMG2_619e14c768987.jpeg', 1, 'published', '2021-11-24 11:32:39', NULL),
(7, 'Test Product 3', '150.00', '135.00', NULL, NULL, 1, 'unpublished', '2021-11-24 13:12:20', NULL),
(8, 'Intel Core i9-9900K Desktop Processor 8 Cores up to 5.0 GHz', '449.99', '404.99', 'assets/images/products/ID_8_IMG1_619e314d8cce9.jpg', NULL, 4, 'published', '2021-11-24 13:34:21', NULL),
(9, 'Gigabyte GeForce RTX 3090 GAMING OC 24G Graphics Card', '3140.00', '2826.00', 'assets/images/products/ID_9_IMG1_619e31b324957.jpg', 'assets/images/products/ID_9_IMG2_619e31da76782.jpg', 4, 'published', '2021-11-24 13:36:03', NULL),
(10, 'Gigabyte GeForce RTX 3090 GAMING OC 24G Graphics Card', '3140.00', '2826.00', 'assets/images/products/ID_9_IMG1_619e31b324957.jpg', 'assets/images/products/ID_9_IMG2_619e31da76782.jpg', 1, 'published', '2021-11-25 19:37:38', '2021-11-25 19:37:38'),
(12, 'Ray Ban Justin 4165 Sunglasses', '130.00', '117.00', 'assets/images/products/ID_12_IMG1_61a07a03f1781.png', NULL, 4, 'published', '2021-11-26 07:06:48', NULL),
(13, 'Galaxy A52s 5G', '499.00', '449.10', 'assets/images/products/ID_13_IMG1_61a07ad4a680b.webp', 'assets/images/products/ID_13_IMG2_61a07ad4ef4dc.jpg', 4, 'published', '2021-11-26 07:12:36', '2021-11-26 07:12:36'),
(14, 'Galaxy A52s 5G', '499.00', '449.10', 'assets/images/products/ID_13_IMG1_61a07ad4a680b.webp', 'assets/images/products/ID_13_IMG2_61a07ad4ef4dc.jpg', 1, 'published', '2021-11-26 09:06:32', '2021-11-26 09:06:32'),
(15, 'Gaming Channel', '60.00', '54.00', 'assets/images/products/ID_5_IMG1_619e1407cd1b8.jpeg', NULL, 4, 'published', '2021-11-26 10:15:54', '2021-11-26 10:15:54'),
(16, 'Sharp Fridge 400 Ltr', '1200.00', '1080.00', 'assets/images/products/ID_3_IMG1_619fa21a1b151.jpg', NULL, 4, 'published', '2021-11-26 10:16:02', '2021-11-26 10:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('customer','seller') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `type`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Mahmudul Islam Prakash', 'seller', 'mahmudul@wholesale.com', '$2y$10$pvWGBWF3KrFsQTbNSTkCd.fh4ujajJ0zkikKuiU5TOCbm1aOihwQ.', '2021-11-18 20:15:17', '2021-11-18 20:15:17'),
(2, 'Kenny Joe', 'customer', 'kenny@wholesale.com', '$2y$10$JuRFLPrzE/DHk251Ry/rg.nrz/tipe0LFQY7ZbHjsW1CX9nYQN6zW', '2021-11-19 12:16:58', '2021-11-19 12:16:58'),
(3, 'Walter White', 'customer', 'white@wholesale.com', '$2y$10$i1dhixwxYPCEy0W7QJfX4u4/btzI0zYqaSBnT3pi5KH98HQzYl.Je', '2021-11-19 12:19:54', '2021-11-19 12:19:54'),
(4, 'John Smith', 'seller', 'john@wholesale.com', '$2y$10$WracZV56PTSB.WY7QFqpleUoPLB5lo0wgdplB8rElPH3InBI9OJsa', '2021-11-19 12:45:01', '2021-11-19 12:45:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`product_id`,`created_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publish_by` (`publish_by`,`created_at`),
  ADD KEY `name` (`name`,`retail_price`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
