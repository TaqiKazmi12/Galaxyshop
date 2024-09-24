-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 03:06 PM
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
-- Database: `galaxyshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'adminman', 'adminman123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Electronics'),
(2, 'Clothing'),
(3, 'Home Appliances'),
(4, 'Books'),
(5, 'Toys'),
(6, 'Sports'),
(7, 'Jewelry'),
(8, 'Beauty'),
(9, 'Furniture'),
(10, 'Automotive');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `payment_method` enum('online','cod','online_saved') DEFAULT 'cod',
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total`, `address`, `contact_number`, `payment_method`, `status`, `product_id`, `product_name`, `quantity`) VALUES
(13, 64, '2024-08-19 21:49:44', 199.99, 'Street 708 , Canada', '930211239', 'cod', 'pending', 107, ' Leather Car Seat Covers', 1),
(14, 65, '2024-08-19 21:51:13', 49.99, 'Usa,Los angles street 204', '5041235245', 'cod', 'pending', 83, 'Women\'s Summer Dress', 1),
(15, 65, '2024-08-19 21:51:44', 99.99, 'Usa,Log Angles street 230', '60534252', 'cod', 'pending', 85, '6-Quart Instant Pot', 1),
(16, 66, '2024-08-23 15:55:55', 199.99, 'asdas', 'a23123123123', 'cod', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(17, 66, '2024-08-23 15:57:54', 199.99, 'asdasd', '1234567890', 'cod', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(18, 69, '2024-08-23 16:47:54', 199.99, 'qasda', '1231231231', 'cod', 'cancelled', 80, 'Wireless Noise-Cancelling Headphones', 1),
(19, 64, '2024-09-01 12:06:07', 199.99, '12312', '3123123', 'online', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(20, 64, '2024-09-01 12:17:29', 79.99, '132123', '123123123', 'online', 'pending', 82, 'Men\'s Casual Denim Jacket', 1),
(21, 64, '2024-09-01 12:32:31', 199.99, '1231231231', '23123123123', '', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(22, 64, '2024-09-01 13:02:52', 199.99, 'asdasdasdasd', '345345345453453', 'cod', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(23, 64, '2024-09-01 13:08:45', 199.99, 'asdasdadsasd', '12312312312312', '', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(24, 64, '2024-09-01 13:08:53', 199.99, 'asdasdadsasd', '12312312312312', 'online', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(25, 64, '2024-09-01 13:09:20', 199.99, '1231231', '123123123123123', 'online', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(26, 64, '2024-09-01 13:19:09', 249.99, '1212', '123123123123', 'online', 'pending', 81, 'Smartwatch Pro Series', 1),
(27, 72, '2024-09-15 08:48:22', 199.99, 'hjghjgh', '123123123123123', 'cod', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(28, 74, '2024-09-15 09:14:54', 199.99, 'Pakistan,Karachi', '03425412352', 'cod', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(29, 76, '2024-09-24 12:19:55', 199.99, 'sdasdasd', '123131231231231', 'online', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(30, 76, '2024-09-24 12:24:53', 199.99, 'asdasdasdasdasd', '12312312312312', 'online', 'pending', 80, 'Wireless Noise-Cancelling Headphones', 1),
(31, 76, '2024-09-24 12:30:54', 599.99, 'asdasdasdasd', '123123123123123', '', 'pending', 79, 'Ultra HD 4K Smart TV', 1),
(32, 76, '2024-09-24 12:34:28', 599.99, 'asdasdasdasd', '12312312312313', 'online_saved', 'pending', 79, 'Ultra HD 4K Smart TV', 1),
(33, 76, '2024-09-24 12:37:39', 599.99, 'asdasdasda', '34534534534534', 'online_saved', 'pending', 79, 'Ultra HD 4K Smart TV', 1),
(34, 76, '2024-09-24 12:38:17', 599.99, 'WERWERWERWERWERW', '123123123123123', 'online', 'pending', 79, 'Ultra HD 4K Smart TV', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `card_holder_name` varchar(255) NOT NULL,
  `expiration_date` date NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `payment_type` enum('card','cash') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `user_id`, `card_number`, `card_holder_name`, `expiration_date`, `is_primary`, `payment_type`, `created_at`, `updated_at`) VALUES
(20, 71, '1234567890123123', '1234567890123123', '2024-09-27', 0, 'card', '2024-08-31 11:10:25', '2024-08-31 11:10:25'),
(23, 64, '5675685695659808', 'JhonsCard', '2053-02-07', 0, 'card', '2024-09-01 12:54:09', '2024-09-01 12:54:09'),
(24, 64, '1123124343463523', 'NewJhonsCard', '2034-02-03', 0, 'card', '2024-09-01 12:56:05', '2024-09-01 12:57:24'),
(25, 64, '5675685684563453', 'wowanothercard', '2034-02-04', 1, 'card', '2024-09-01 12:57:24', '2024-09-01 12:57:24'),
(26, 72, '1234564578795645', 'ToShowThem', '2024-11-01', 1, 'card', '2024-09-15 08:46:01', '2024-09-15 08:46:01'),
(27, 74, '1231231231231234', 'User', '2024-09-26', 1, 'card', '2024-09-15 09:14:18', '2024-09-15 09:14:18'),
(29, 76, '1231231231231231', 'asdasdasdasdasd', '2024-09-28', 1, 'card', '2024-09-24 12:25:39', '2024-09-24 12:25:45'),
(30, 76, '1312312312312312', 'ASasASasFDHGFDTUY567', '2024-09-29', 0, 'card', '2024-09-24 12:37:56', '2024-09-24 12:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(3,2) DEFAULT 0.00,
  `category_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image_url`, `price`, `rating`, `category_id`, `seller_id`) VALUES
(79, 'Ultra HD 4K Smart TV', ' A 55-inch Ultra HD 4K Smart TV with HDR and streaming capabilities.', 'uploads/Ultra HD 4K Smart TV.png', 599.99, 0.00, 1, 63),
(80, 'Wireless Noise-Cancelling Headphones', 'High-quality wireless headphones with active noise cancellation and long battery life.', 'uploads/Wireless Noise-Cancelling Headphones.png', 199.99, 0.00, 1, 63),
(81, 'Smartwatch Pro Series', ' A premium smartwatch with fitness tracking, GPS, and heart rate monitoring.', 'uploads/Smartwatch Pro Series.png', 249.99, 0.00, 1, 63),
(82, 'Men\'s Casual Denim Jacket', 'A stylish and durable denim jacket perfect for casual wear.', 'uploads/Men\'s Casual Denim Jacket.png', 79.99, 0.00, 2, 63),
(83, 'Women\'s Summer Dress', 'A light and flowy summer dress available in various colors and patterns.', 'uploads/Women\'s Summer Dress.png', 49.99, 0.00, 2, 63),
(84, 'Unisex Athletic Sneakers', 'Comfortable and trendy sneakers suitable for all-day wear.', 'uploads/Unisex Athletic Sneakers.png', 89.99, 0.00, 2, 63),
(85, '6-Quart Instant Pot', 'A versatile multi-cooker that replaces several kitchen appliances, ideal for fast and easy meals.', 'uploads/6-Quart Instant Pot.png', 99.99, 0.00, 2, 63),
(86, 'Cordless Vacuum Cleaner', 'A powerful and lightweight vacuum cleaner with a long-lasting battery.', 'uploads/Cordless Vacuum Cleaner.png', 149.99, 0.00, 3, 63),
(87, 'Air Fryer Oven Combo', 'A 10-quart air fryer that also functions as a toaster oven, perfect for healthy cooking.', 'uploads/Air Fryer Oven Combo.png', 129.99, 0.00, 3, 63),
(88, 'The Great Adventure: A Novel', ' A thrilling adventure novel that takes readers on a journey through uncharted territories.', 'uploads/The Great Adventure.png', 14.99, 0.00, 4, 63),
(89, 'Cooking 101: Beginner’s Guide', ' A comprehensive guide for beginners to learn the basics of cooking and baking.', 'uploads/Cooking 101Beginner’s Guide.png', 19.99, 0.00, 4, 63),
(90, 'Mindfulness and Meditation', ' A book exploring mindfulness techniques and meditation practices for a balanced life.', 'uploads/Mindfulness and Meditation.png', 12.99, 0.00, 4, 63),
(91, 'Remote Control Car', 'A fast and durable remote control car with off-road capabilities.', 'uploads/A fast and durable remote control car with off-road capabilities.png', 29.99, 0.00, 5, 63),
(92, 'Building Block Set', 'A creative building block set that helps develop motor skills and creativity in children.', 'uploads/Building Block Set.png', 39.99, 0.00, 5, 63),
(93, 'Plush Teddy Bear', ' A soft and cuddly teddy bear, perfect as a gift for children of all ages.\r\n', 'uploads/Plush Teddy Bear.png', 19.99, 0.00, 5, 63),
(94, 'Yoga Mat with Strap', 'A non-slip yoga mat with an included carrying strap, ideal for yoga and pilates.', 'uploads/Yoga Mat with Strap.png', 24.99, 0.00, 6, 63),
(95, 'Adjustable Dumbbell Set', ' A pair of adjustable dumbbells for strength training with a range of weight options.', 'uploads/Adjustable Dumbbell Set.png', 129.99, 0.00, 6, 63),
(96, 'Football Training Kit', 'A complete training kit with cones, agility ladder, and football for aspiring players.', 'uploads/Football Training Kit.png', 59.99, 0.00, 6, 63),
(97, 'Sterling Silver Necklace', 'A delicate sterling silver necklace with a minimalist pendant design.', 'uploads/Sterling Silver Necklace.png', 49.99, 0.00, 7, 63),
(98, 'Gold-Plated Hoop Earrings', 'Elegant gold-plated hoop earrings that complement any outfit.', 'uploads/Gold-Plated Hoop Earrings.png', 39.99, 0.00, 7, 63),
(99, 'Diamond Engagement Ring', 'A stunning diamond engagement ring with a classic design.', 'uploads/Diamond Engagement Ring.png', 1999.99, 0.00, 7, 63),
(100, ' Hydrating Face Cream', ' A nourishing face cream that hydrates and smoothens the skin.', 'uploads/Hydrating Face Cream.png', 29.99, 0.00, 8, 63),
(101, 'Matte Lipstick Set', 'A set of five long-lasting matte lipsticks in various shades.', 'uploads/Matte Lipstick Set.png', 24.99, 0.00, 8, 63),
(102, 'Anti-Aging Serum', 'A powerful serum that reduces wrinkles and fine lines for youthful skin.', 'uploads/Anti-Aging Serum.png', 49.99, 0.00, 8, 63),
(103, 'Modern Coffee Table', 'A sleek and stylish coffee table with a glass top and wooden legs.', 'uploads/Modern Coffee Table.png', 199.99, 0.00, 9, 63),
(104, 'Ergonomic Office Chair', 'An ergonomic office chair designed for comfort during long hours of work.', 'uploads/Ergonomic Office Chair.png', 149.99, 0.00, 9, 63),
(105, 'Queen Size Bed Frame', 'A sturdy and elegant queen-size bed frame with a modern design.', 'uploads/Queen Size Bed Frame.png', 299.99, 0.00, 9, 63),
(106, 'Car Dash Cam', 'A high-definition dash cam with night vision and motion detection.\r\n', 'uploads/Car Dash Cam.png', 89.99, 0.00, 10, 63),
(107, ' Leather Car Seat Covers', 'Premium leather car seat covers that offer comfort and style.', 'uploads/Leather Car Seat Covers.png', 199.99, 0.00, 10, 63),
(108, 'Portable Tire Inflator', ' A compact and easy-to-use tire inflator, perfect for emergency situations.', 'uploads/Portable Tire Inflator.png', 49.99, 0.00, 10, 63);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `review` text NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `review`, `review_date`) VALUES
(1, 80, 66, 1, 'asdasd', '2024-08-23 16:21:32'),
(2, 80, 66, 1, 'wrost ass headphone man', '2024-08-23 16:21:51'),
(3, 80, 67, 4, 'works fine tbh', '2024-08-23 16:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `sellersupport`
--

CREATE TABLE `sellersupport` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `issue_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `response` text DEFAULT NULL,
  `responded_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cart` text DEFAULT NULL,
  `account_type` varchar(20) DEFAULT 'buyer',
  `joined_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `cart`, `account_type`, `joined_date`) VALUES
(63, 'NewCompany', 'NewCompany@gmail.com', '$2y$10$5ZOAwzlXVYi.hbaiJ0Foq.IM3TAL9IDa0ktYjT96.l4p1uCrhA346', NULL, 'seller', '2024-08-20'),
(64, 'Jhon', 'Jhon@gmail.com', '$2y$10$nFDkk4j3RD/gWp.eC179q.5f28bKdwZpK36ULHTtjnowuU2dZpTpq', NULL, 'buyer', '2024-08-20'),
(65, 'Sarah', 'Sarah@gmail.com', '$2y$10$X0.itbehb.IgI2f9hkbCsuG2Od60K3EgMnihJLaHiXuYppIcJzf8u', NULL, 'buyer', '2024-08-20'),
(66, 'asdas', 'adasd@gmail.com', '$2y$10$tPwgyG6vEnMVoOOiLjyZo.Z6lpS5FX0orIEjpcvogvulPo2Buy0y6', NULL, 'buyer', '2024-08-23'),
(67, 'mrmonkey', 'mrmonkey@gmail.com', '$2y$10$AQERzjtdiM2btdsOn0Dh..VSFCCugqsopHRBO1I2xPiWZCXaUSvlm', NULL, 'buyer', '2024-08-23'),
(68, 'ComputerParts', 'Computers@gmail.com', '$2y$10$9uy27H2N1/SXW4gjSJWmH.zAeJpVpncxGdUdS0ETR77aLfMzhy6nC', NULL, 'seller', '2024-08-23'),
(69, 'Taqikazmi', 'taqikazmi@gmail.com', '$2y$10$Q0WlgSv/TyF/w5h4V.ShUeRJCX8CJgCNpYCkHXmSdbYThZ.7EnXmm', NULL, 'buyer', '2024-08-23'),
(70, 'asdasdas', 'dasd2asdasdasdasd@gmail.com', '$2y$10$8Vtcd.x4fFAkMl1qm6QJKu17NJl7OMH21.jbnf9Ntl0Kv2Aa609aK', NULL, 'seller', '2024-08-23'),
(71, 'Imnewbro', 'imnewbro@gmail.com', '$2y$10$G9Sq7lapIie3OgysESAcTeR.DS79rwSXJb8j4wv8fGG9wEZt.ctSm', NULL, 'buyer', '2024-08-31'),
(72, 'TOShowThem', 'toshowthem@gmail.com', '$2y$10$u.oHPxwjSTC3eJZjKcmg6ezaTdhhHd95ox00pO.g5E1oE6vIb9UOy', NULL, 'buyer', '2024-09-15'),
(73, 'Watches', 'watches123@gmail.com', '$2y$10$3wJUeVhXTUcP9HiVrTE03.dOkCqZ8TALubqhFBe3oreAPp4Ikzo12', NULL, 'seller', '2024-09-15'),
(74, 'newuser', 'newuser123@gmail.com', '$2y$10$k3u/awamCDTlBXSn4aBCbekGecCUvIdF2NeiWZT1rs2OZxavBD34G', NULL, 'buyer', '2024-09-15'),
(75, 'ShoesCompany', 'shoescompany@gmail.com', '$2y$10$mcF3yNI6RglLaOM2bX3Bbe6lAajjpnPB9nHxzWLULyY4t3tL9UjMq', NULL, 'seller', '2024-09-15'),
(76, 'letsfixgtlich', 'letsfixgtlich@gmail.com', '$2y$10$jw9q5dBOpNY9RHDV09cUV.1FmOWJwtWiPuTIekfOHRVCihwS/93LW', NULL, 'buyer', '2024-09-24'),
(77, 'asdasdasd123123', 'adsasdasd1231@asdasdas', '$2y$10$R05MtuIuZDPuDsulFxbwv.v4BbI8k50N/nbOlxo6K1EdttSymrXOu', NULL, 'seller', '2024-09-24'),
(78, 'sdasdasd', 'asdasdasda@asd', '$2y$10$28/3wIFjwmAdJfWe1/u8z.h423452H18LxdKxX/NUdv3gCm8KLIY2', NULL, 'buyer', '2024-09-24');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`) VALUES
(15, 65, 83),
(16, 65, 84);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sellersupport`
--
ALTER TABLE `sellersupport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sellersupport`
--
ALTER TABLE `sellersupport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
