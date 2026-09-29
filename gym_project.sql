-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 27, 2026 at 01:08 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trainer_id` int NOT NULL,
  `day` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_limit` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_classes_trainers` (`trainer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `trainer_id`, `day`, `hour`, `max_limit`) VALUES
(1, 'ZZZZ', 1, 'احد - ثلثاء -خميس', '5 الى 6', 2),
(2, 'QQQQ', 5, 'ثلثاء -خميس', '6 الى 7:30', 10),
(3, 'QQQQ', 2, 'ثلثاء -خميس', '6 الى 7:30', 25);

-- --------------------------------------------------------

--
-- Table structure for table `class_attendees`
--

DROP TABLE IF EXISTS `class_attendees`;
CREATE TABLE IF NOT EXISTS `class_attendees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `join_date` date DEFAULT (curdate()),
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_attendees`
--

INSERT INTO `class_attendees` (`id`, `class_id`, `name`, `phone`, `age`, `gender`, `join_date`) VALUES
(1, 1, 'ali', '45455422222', 56, 'ذكر', '2026-09-23'),
(2, 1, 'salmaaaaa', '758588', 444, 'أنثى', '2026-09-23');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` tinyint NOT NULL,
  `height` decimal(5,2) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `join_date` date NOT NULL,
  `trainer_id` int NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_id` int NOT NULL,
  `subscription_duration` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `trainer_id` (`trainer_id`),
  KEY `plan_1d` (`plan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `phone`, `email`, `age`, `height`, `weight`, `join_date`, `trainer_id`, `gender`, `image`, `plan_id`, `subscription_duration`) VALUES
(4, 'ZZZZسسس', '45455422222', 'ssmohmdddddd@email.com', 34, 178.00, 56.00, '2026-09-23', 1, 'male', 'images.jpg', 3, '1'),
(8, 'ZZZZ', '45455422222', '', 34, 179.00, 56.00, '2026-09-23', 2, 'male', 'images.jpg', 2, '3'),
(9, 'MOHAMMAD', '0782064961', 'SS@email.com', 20, 174.00, 60.00, '2026-09-23', 10, 'male', 'WhatsApp Image .jpeg', 6, '3_months'),
(10, 'khalaf', '0777771375', 'ka@email.com', 55, 177.00, 78.00, '2026-09-23', 1, 'male', 'php .jpg', 6, '3'),
(11, 'ggg', '0777771375', 'ka@email.com', 55, 177.00, 78.00, '2026-09-23', 2, 'male', '', 3, '1'),
(13, 'محمد علي', '0599000002', 'mohammad@gmail.com', 30, 175.00, 85.00, '2026-09-26', 1, 'male', '', 2, '12'),
(15, 'سامي محمود', '0599000004', 'sami@gmail.com', 28, 182.00, 90.00, '2026-09-26', 2, 'male', '', 3, '3');

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

DROP TABLE IF EXISTS `membership_plans`;
CREATE TABLE IF NOT EXISTS `membership_plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `membership` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_plans`
--

INSERT INTO `membership_plans` (`id`, `name`, `membership`) VALUES
(2, 'pro_pro', 55.00),
(3, 'XXXDDDD', 33.00),
(6, 'praimary', 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `plan_id` int DEFAULT NULL,
  `amount` int NOT NULL,
  `payment_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `plan_id` (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `member_id`, `plan_id`, `amount`, `payment_type`, `payment_method`, `payment_date`, `notes`) VALUES
(1, 9, 2, 45, 'دفعة أولى', 'نقدي', '2026-09-24', ''),
(4, 9, 6, 56, 'دفعة ثانية', 'نقدي', '2026-09-24', ''),
(3, 10, 6, 0, 'دفعة أولى', 'نقدي', '0000-00-00', ''),
(5, 11, 6, 40, 'دفعة أولى', 'نقدي', '2026-09-26', '');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

DROP TABLE IF EXISTS `trainers`;
CREATE TABLE IF NOT EXISTS `trainers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` tinyint NOT NULL,
  `join_date` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `name`, `phone`, `email`, `age`, `join_date`, `gender`, `image`) VALUES
(1, 'mohammad', '0782064961', 'mmmm@email.com', 20, '2026-09-21', 'male', 'inv.ico'),
(2, 'ali', '45455422222', 'ssmohmdddddd@email.com', 34, '2026-09-22', 'male', 'python .jpeg'),
(5, 'salmaa', '45455422222', 's@email.com', 34, '2026-09-24', 'female', 'WhatsApp Image .jpeg'),
(10, 'HHHHH', '45455422222', 'ssmohmdddddd@email.com', 34, '2026-09-22', 'male', 'photo_2025-05-25_15-27-43.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'mohammad', 'asd123123');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `fk_classes_trainers` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
