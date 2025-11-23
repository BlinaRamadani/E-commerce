-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 07:38 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoping_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `pid` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `city_reports`
--

CREATE TABLE `city_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `urgency` enum('low','medium','high') DEFAULT 'medium',
  `photo` longtext DEFAULT NULL,
  `status` enum('pending','in_progress','resolved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `issue_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reference_number` varchar(20) DEFAULT NULL,
  `reporter_name` varchar(100) DEFAULT NULL,
  `reporter_email` varchar(100) DEFAULT NULL,
  `reporter_phone` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `issue_type`, `description`, `status`, `location`, `created_at`, `reference_number`, `reporter_name`, `reporter_email`, `reporter_phone`, `photo`, `updated_at`) VALUES
(1, 'pothole', 'HI here is a problem', 'Pending', '42.662473, 21.163187', '2025-11-23 16:34:53', '#19175', 'Blinaa', 'blina@gmail.com', '1111111111111111111111', 'uploads/1763915693_Screenshot (80).png', NULL),
(2, 'streetlight', 'hi', 'Pending', '42.659317, 21.183615', '2025-11-23 17:03:26', '#11400', 'blinaaa', 'bb@gmail.com', '111111111111111', 'uploads/1763917406_Screenshot (16).png', NULL),
(3, 'graffiti', 'hi', 'Pending', '42.665818, 21.160784', '2025-11-23 18:35:39', '#10142', 'b', 'blina@gmail.com', '22222222222222222', 'uploads/1763922939_Screenshot (84).png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(13, 21, 'w', 'w@gmail.com', '11', '11ww'),
(14, 21, 'w', 'w@gmail.com', '11', 'ww1'),
(15, 21, 'w', 'w@gmail.com', '11', 'ww1'),
(16, 21, 'w', 'w@gmail.com', '11', '2ww'),
(18, 21, 'w', 'w@gmail.com', '11', 'www'),
(19, 22, 'blina', 'w2@gmail.com', '12', 'hsjsjs');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `placed_on` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `product_detail` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `reference_number` varchar(20) NOT NULL,
  `category` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` text NOT NULL,
  `urgency` varchar(20) DEFAULT 'low',
  `photo` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `status` enum('pending','in_progress','resolved') DEFAULT 'pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sanitationrequests`
--

CREATE TABLE `sanitationrequests` (
  `id` int(11) NOT NULL,
  `request_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'blina', 'blina@gmail.com', '$2y$10$WDpWiJW3sbJGQn2esmaHe.KknMeNPygJE7CaO2Ddz.UWuSVMfDXd.', 'admin'),
(4, 'blinaa', 'blinaa@gmail.com', '$2y$10$khhHRgiJ3Lg40VCIXmy.H.uW7T8KLsyhM4q5NEVbiDh9iY.R4Qx.S', 'user'),
(17, 'blina', 'b9@gmail.com', '$2y$10$/K1Vzb599n3KUkPV7M2aHeiVW0FFwe8obBvT9fNpS3ac6ot6MmZ1O', 'user'),
(21, 'w', 'w@gmail.com', '$2y$10$1bNkpO5rGfUsWGdoPAYdJOEVkuAWYeyZ10gZfT4q/C6wGsTikBkPG', 'user'),
(22, 'w2', 'w2@gmail.com', '$2y$10$YucKPPGyI3M08WzZeeyWAeG//EMIiAocO3lM.oicwqjnDyfYvZ/3y', 'user'),
(23, 'bb', 'bb@gmail.com', '$2y$10$JiI3jbuXqLzsLiWYY3qcfubZbkRG3SYRDaMUA.4wFjhQSW8b4Ajq2', 'user'),
(24, 'bb', 'bbb@gmail.com', '$2y$10$AUJ2dvc6uVnytFi7piuY3.QQqIBf/.MArcDbN3NGmHOUoq6tn5oCS', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `pid` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_reports`
--
ALTER TABLE `city_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_number` (`reference_number`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_number` (`reference_number`);

--
-- Indexes for table `sanitationrequests`
--
ALTER TABLE `sanitationrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city_reports`
--
ALTER TABLE `city_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sanitationrequests`
--
ALTER TABLE `sanitationrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `city_reports`
--
ALTER TABLE `city_reports`
  ADD CONSTRAINT `city_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
