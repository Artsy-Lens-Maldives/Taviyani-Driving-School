-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2018 at 11:55 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `driving`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `code`, `rate`, `created_at`, `updated_at`) VALUES
(1, 'Cycle', 'A0/A1', '2000', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(2, 'Car', 'B1', '3000', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(3, 'Van', 'B2', '3000', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(4, 'Pick Up (Below 2 Ton)', 'C1', '2500', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(5, 'Pickup (Above 2 ton)', 'C2', '2500', '2018-06-22 19:00:00', '2018-06-22 19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category_instructor`
--

CREATE TABLE IF NOT EXISTS `category_instructor` (
  `category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructor_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_instructor`
--

INSERT INTO `category_instructor` (`category_id`, `instructor_id`) VALUES
('1', '1'),
('2', '1'),
('4', '1'),
('5', '1'),
('1', '2'),
('2', '2'),
('4', '2'),
('1', '3'),
('2', '3'),
('4', '3'),
('1', '4'),
('2', '4'),
('4', '4'),
('1', '5'),
('4', '5'),
('1', '6');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE IF NOT EXISTS `instructors` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '/user.png',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `category_id`, `photo_url`, `name`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, '1,2,4,5', '/user.png', 'Nadeem', '9558833', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(2, '1,2,4', '/user.png', 'Hussain', '9125072', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(3, '1,2,4', '/user.png', 'Abdulla', '7939951', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(4, '1,2,4', '/user.png', 'Hamdhaan', '7488800', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(5, '1,4', '/user.png', 'Ibrahim', '7726126', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(6, '1', '/user.png', 'Mohamed', '7434310', '2018-06-22 19:00:00', '2018-06-22 19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2014_10_12_000000_create_users_table', 1),
(10, '2014_10_12_100000_create_password_resets_table', 1),
(11, '2018_06_23_061730_create_instructors_table', 1),
(12, '2018_06_23_061822_create_times_table', 1),
(14, '2018_06_23_062030_create_slots_table', 1),
(15, '2018_06_23_063125_create_categories_table', 1),
(16, '2018_06_23_063324_create_vehicles_table', 1),
(17, '2018_07_09_064755_category_instructor_table', 2),
(19, '2018_06_23_062019_create_students_table', 3),
(21, '2018_07_11_043326_create_transportfees_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE IF NOT EXISTS `slots` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `instructor_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `time_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `student_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `isEmpty` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slots`
--

INSERT INTO `slots` (`id`, `instructor_id`, `time_id`, `student_id`, `isEmpty`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(2, '1', '2', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(3, '1', '3', '1', '0', '2018-07-09 03:57:01', '2018-07-09 05:14:51'),
(4, '1', '4', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(5, '1', '5', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(6, '1', '6', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(7, '1', '7', '2', '0', '2018-07-09 03:57:01', '2018-07-09 05:19:06'),
(8, '1', '8', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(9, '1', '9', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(10, '1', '10', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(11, '1', '11', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(12, '1', '12', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(13, '1', '13', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(14, '1', '14', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(15, '1', '15', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(16, '1', '16', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(17, '1', '17', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(18, '1', '18', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(19, '2', '1', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(20, '2', '2', '0', '1', '2018-07-09 03:57:01', '2018-07-09 03:57:01'),
(21, '2', '3', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(22, '2', '4', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(23, '2', '5', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(24, '2', '6', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(25, '2', '7', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(26, '2', '8', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(27, '2', '9', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(28, '2', '10', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(29, '2', '11', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(30, '2', '12', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(31, '2', '13', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(32, '2', '14', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(33, '2', '15', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(34, '2', '16', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(35, '2', '17', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(36, '2', '18', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(37, '3', '1', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(38, '3', '2', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(39, '3', '3', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(40, '3', '4', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(41, '3', '5', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(42, '3', '6', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(43, '3', '7', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(44, '3', '8', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(45, '3', '9', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(46, '3', '10', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(47, '3', '11', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(48, '3', '12', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(49, '3', '13', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(50, '3', '14', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(51, '3', '15', '0', '1', '2018-07-09 03:57:02', '2018-07-09 03:57:02'),
(52, '3', '16', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(53, '3', '17', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(54, '3', '18', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(55, '4', '1', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(56, '4', '2', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(57, '4', '3', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(58, '4', '4', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(59, '4', '5', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(60, '4', '6', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(61, '4', '7', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(62, '4', '8', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(63, '4', '9', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(64, '4', '10', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(65, '4', '11', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(66, '4', '12', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(67, '4', '13', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(68, '4', '14', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(69, '4', '15', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(70, '4', '16', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(71, '4', '17', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(72, '4', '18', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(73, '5', '1', '0', '1', '2018-07-09 03:57:03', '2018-07-09 03:57:03'),
(74, '5', '2', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(75, '5', '3', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(76, '5', '4', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(77, '5', '5', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(78, '5', '6', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(79, '5', '7', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(80, '5', '8', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(81, '5', '9', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(82, '5', '10', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(83, '5', '11', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(84, '5', '12', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(85, '5', '13', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(86, '5', '14', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(87, '5', '15', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(88, '5', '16', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(89, '5', '17', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(90, '5', '18', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(91, '6', '1', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(92, '6', '2', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(93, '6', '3', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(94, '6', '4', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(95, '6', '5', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(96, '6', '6', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(97, '6', '7', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(98, '6', '8', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(99, '6', '9', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(100, '6', '10', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(101, '6', '11', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(102, '6', '12', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(103, '6', '13', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(104, '6', '14', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(105, '6', '15', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(106, '6', '16', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(107, '6', '17', '0', '1', '2018-07-09 03:57:04', '2018-07-09 03:57:04'),
(108, '6', '18', '0', '1', '2018-07-09 03:57:05', '2018-07-09 03:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_card` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateofbirth` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `vehicle_id`, `category_id`, `photo_url`, `name`, `id_card`, `phone`, `p_address`, `c_address`, `dateofbirth`, `gender`, `license_no`, `created_at`, `updated_at`) VALUES
(1, NULL, '1', NULL, 'Mohamed Athik', 'A328423', '9990582', NULL, NULL, '18/12/1999', 'male', NULL, '2018-07-09 04:01:36', '2018-07-09 04:31:41'),
(2, NULL, '1', NULL, 'Mohamed Yaniu', 'A324098', '7779423', 'Pool Dream', 'GJLKDS', '05/09/1998', 'female', NULL, '2018-07-09 05:18:16', '2018-07-09 05:18:22'),
(3, NULL, '1', NULL, 'Mohamed Ahmed', 'A324134', '7942104', 'mfej', '24', '15/06/2000', 'male', NULL, '2018-07-10 03:31:42', '2018-07-12 01:17:18');

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE IF NOT EXISTS `times` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `times`
--

INSERT INTO `times` (`id`, `time`, `created_at`, `updated_at`) VALUES
(1, '06:00-07:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(2, '07:00-08:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(3, '08:00-09:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(4, '09:00-10:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(5, '10:00-11:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(6, '11:00-12:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(7, '12:00-13:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(8, '13:00-14:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(9, '14:00-15:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(10, '15:00-16:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(11, '16:00-17:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(12, '17:00-18:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(13, '18:00-19:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(14, '19:00-20:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(15, '20:00-21:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(16, '21:00-22:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(17, '22:00-23:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(18, '23:00-00:00', '2018-06-22 19:00:00', '2018-06-22 19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transportfees`
--

CREATE TABLE IF NOT EXISTS `transportfees` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'athik', 'athik.13@gmail.com', '$2y$10$wY8Cj6uFPlUvr3RvhQnMHO2TdoZP7RSXHK4yYKvdUpGSXwnE1JA0m', 'Pl7k7YV1lJ3YJFIzEzaDIexjgFrtU2RDzjkJAuAy9H7iO8DnDVwF9Z0aTWQr', '2018-07-09 23:34:09', '2018-07-09 23:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `category_id`, `photo_url`, `number`, `created_at`, `updated_at`) VALUES
(1, '1', '/car.png', 'P1234', '2018-06-22 19:00:00', '2018-06-22 19:00:00'),
(2, '2', '/cycle.png', 'P7002', '2018-06-22 19:00:00', '2018-06-22 19:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
