-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2019 at 06:11 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bvms`
--
CREATE DATABASE IF NOT EXISTS `db_bvms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_bvms`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `account_uname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` int(11) NOT NULL,
  `account_suspend` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_uname`, `account_password`, `account_type`, `account_suspend`, `created_at`, `updated_at`) VALUES
(1, 'ecruz', 'e64dfbc42b4939ad984e4fc398cdd4d826873e51', 0, 0, NULL, NULL),
(2, 'kylaris18', 'e64dfbc42b4939ad984e4fc398cdd4d826873e51', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brgies`
--

DROP TABLE IF EXISTS `brgies`;
CREATE TABLE `brgies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brgy_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_captain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_sk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brgies`
--

INSERT INTO `brgies` (`id`, `brgy_name`, `brgy_address`, `brgy_captain`, `brgy_sk`, `created_at`, `updated_at`) VALUES
(1, 'Baranggay Langgam', 'San Pedro City, Laguna, PH', 'Edgar San Luis', 'Bryan Higa', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `councilors`
--

DROP TABLE IF EXISTS `councilors`;
CREATE TABLE `councilors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `councilor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `councilors`
--

INSERT INTO `councilors` (`id`, `councilor_name`, `created_at`, `updated_at`) VALUES
(1, 'Neslie Magtanggol', NULL, NULL),
(2, 'Robert Cruz', NULL, NULL),
(3, 'Pamela Remoquilo', NULL, NULL),
(4, 'John Marvin Bien', NULL, NULL),
(5, 'Christian Felipe', NULL, NULL),
(6, 'Kenneth Piezas', NULL, NULL),
(7, 'Jasmin Alora', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2019_06_01_174914_create_violators_table', 3),
(6, '2019_06_01_173231_create_types_table', 4),
(16, '2019_06_01_173244_create_violations_table', 5),
(17, '2019_06_01_080247_create_accounts_table', 6),
(20, '2019_06_01_080231_create_users_table', 7),
(21, '2019_06_08_181325_create_brgies_table', 8),
(22, '2019_06_08_181817_create_councilors_table', 8),
(23, '2019_06_09_001355_create_reports_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `report_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `violator_id` int(11) NOT NULL,
  `report_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `account_id`, `violator_id`, `report_path`, `report_date`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '/storage/reports/1569074190.xlsx', '1569074190', NULL, NULL),
(2, 1, 6, '/storage/reports/1569075607.xlsx', '1569075607', NULL, NULL),
(3, 1, 6, '/storage/reports/1569078150.xlsx', '1569078150', NULL, NULL),
(4, 1, 6, '/storage/reports/1569079048.xlsx', '1569079048', NULL, NULL),
(5, 1, 6, '/storage/reports/1569079085.xlsx', '1569079085', NULL, NULL),
(6, 1, 6, '/storage/reports/1569079690.xlsx', '1569079690', NULL, NULL),
(7, 1, 6, '/storage/reports/1569080500.xlsx', '1569080500', NULL, NULL),
(8, 1, 6, '/storage/reports/1569083619.xlsx', '1569083619', NULL, NULL),
(9, 1, 6, '/storage/reports/1569085528.xlsx', '1569085528', NULL, NULL),
(10, 1, 6, '/storage/reports/1569093656.xlsx', '1569093656', NULL, NULL),
(11, 1, 6, '/storage/reports/1569111706.xlsx', '1569111706', NULL, NULL),
(12, 1, 7, '/storage/reports/1569115518.xlsx', '1569115518', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `type_name`, `created_at`, `updated_at`) VALUES
(1, 'Loitering', NULL, NULL),
(2, 'No Entry', NULL, NULL),
(3, 'No Parking', NULL, NULL),
(4, 'No Loading/Unloading', NULL, NULL),
(5, 'Illegal Vending', NULL, NULL),
(6, 'Jaywalking', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_contactno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `account_id`, `user_fname`, `user_lname`, `user_contactno`, `user_photo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Emmanuel', 'Labao', '9476025547', '/storage/profile/1569115605.jpg', NULL, NULL),
(2, 2, 'Dan', 'Fernandez', '09476085541', '/storage/profile/1569088635.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

DROP TABLE IF EXISTS `violations`;
CREATE TABLE `violations` (
  `violation_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `violation_violator` int(11) NOT NULL,
  `violation_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violation_month` int(11) NOT NULL,
  `violation_year` int(11) NOT NULL,
  `violation_status` int(11) NOT NULL,
  `violation_report` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violation_resolution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `violation_notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violation_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`violation_id`, `type_id`, `account_id`, `violation_violator`, `violation_date`, `violation_month`, `violation_year`, `violation_status`, `violation_report`, `violation_resolution`, `violation_notes`, `violation_photo`, `created_at`, `updated_at`) VALUES
(16, 1, 1, 6, '22', 6, 2019, 1, '1560050256', NULL, 'sdvasdfasd', '/storage/uploads/1569082374.jpg', NULL, NULL),
(17, 3, 1, 6, '22', 6, 2019, 1, '1560050272', NULL, 'sfasdfasdf', '/storage/uploads/1569082337.jpg', NULL, NULL),
(18, 3, 1, 6, '22', 6, 2019, 2, '1560050288', 'ssdfgsdfg', 'zdsfas', '/storage/uploads/1569082322.jpg', NULL, NULL),
(21, 2, 1, 6, '21', 9, 2019, 1, '1569124938', 'sdgsgsdgsdgf', 'ergafgsgfsdf', '/storage/uploads/1569124938.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `violators`
--

DROP TABLE IF EXISTS `violators`;
CREATE TABLE `violators` (
  `violator_id` bigint(20) UNSIGNED NOT NULL,
  `violator_lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violator_fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violator_mname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violator_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `violators`
--

INSERT INTO `violators` (`violator_id`, `violator_lname`, `violator_fname`, `violator_mname`, `violator_count`, `created_at`, `updated_at`) VALUES
(6, 'Labao', 'Christian Jay', 'Mendoza', 0, NULL, NULL),
(7, 'Labao', 'Casey', 'Mendoza', 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `brgies`
--
ALTER TABLE `brgies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `councilors`
--
ALTER TABLE `councilors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`violation_id`);

--
-- Indexes for table `violators`
--
ALTER TABLE `violators`
  ADD PRIMARY KEY (`violator_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brgies`
--
ALTER TABLE `brgies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `councilors`
--
ALTER TABLE `councilors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violation_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `violators`
--
ALTER TABLE `violators`
  MODIFY `violator_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
