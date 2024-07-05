-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 01:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `file_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `type`, `username`, `user_id`, `filename`, `timestamp`) VALUES
(1, 'Download', 'guest', NULL, 'Category_Naspin.png', '2024-06-22 15:51:56'),
(2, 'Download', 'guest', NULL, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-23 23:17:17'),
(3, 'Download', 'guest', NULL, 'Payable_sheet_cash_2.png', '2024-06-23 23:39:38'),
(4, 'Upload', 'guest', NULL, 'hs_code_issue.png', '2024-06-24 00:01:41'),
(5, 'Download', 'guest', NULL, 'Salary-Sheet-Excel-Template.jpg.webp', '2024-06-24 00:36:41'),
(6, 'Upload', 'guest', NULL, 'import_opening.png', '2024-06-24 00:37:21'),
(7, 'Download', 'guest', NULL, 'Payable_sheet_cash_2.png', '2024-06-24 04:06:03'),
(8, 'Download', 'guest', NULL, 'Salary-Sheet-Excel-Template.jpg.webp', '2024-06-24 04:06:08'),
(9, 'Upload', 'guest', NULL, 'hs_code_issue.png', '2024-06-24 04:06:14'),
(10, 'Download', 'guest', NULL, 'Payable_sheet.png', '2024-06-24 05:18:24'),
(11, 'Upload', 'guest', NULL, 'items_import.csv', '2024-06-24 05:18:37'),
(12, 'Download', 'guest', NULL, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-24 05:48:54'),
(13, 'Upload', 'guest', NULL, 'Payable_sheet.png', '2024-06-24 06:22:44'),
(14, 'Download', 'guest', NULL, 'analytics.JPG', '2024-06-24 11:39:18'),
(15, 'Upload', 'guest', NULL, 'import_opening.png', '2024-06-24 11:39:24'),
(16, 'Download', 'guest', NULL, 'Payable_sheet_cash_2.png', '2024-06-24 11:48:14'),
(17, 'Download', 'Minhaj', NULL, 'Payable_sheet.png', '2024-06-24 13:33:21'),
(18, 'Download', 'user2@gmail.com', NULL, 'analytics.JPG', '2024-06-26 03:21:53'),
(19, 'Download', 'Minhaj', NULL, 'bank salary sheet.pdf', '2024-06-26 15:32:42'),
(20, 'Download', 'user2@gmail.com', NULL, 'Category_Naspin.png', '2024-06-26 15:33:56'),
(21, 'Download', 'Minhaj', NULL, 'analytics.JPG', '2024-06-26 16:21:53'),
(22, 'Download', 'Minhaj', NULL, 'bank salary sheet.pdf', '2024-06-26 16:26:39'),
(23, 'Download', 'Minhaj', 0, 'Payable_sheet_cash_2.png', '2024-06-26 16:38:58'),
(24, 'Download', 'Minhaj', 0, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-26 16:40:52'),
(25, 'Download', 'Minhaj', 1, 'WhatsApp Image 2024-06-20 at 12.59.31.jpeg', '2024-06-26 16:41:46'),
(26, 'Download', 'Minhaj', 1, 'inventory_valuation_report.png', '2024-06-26 16:45:58'),
(27, 'Download', 'Minhaj', 1, 'items_import.csv', '2024-06-26 16:46:25'),
(28, 'Upload', 'Minhaj', NULL, 'analytics.JPG', '2024-06-26 16:53:52'),
(29, 'Upload', 'Minhaj', 1, '', '2024-06-26 17:09:20'),
(30, 'Upload', 'Minhaj', 1, '', '2024-06-26 17:10:57'),
(31, 'Upload', 'Minhaj', 1, 'analytics (4).JPG', '2024-06-26 17:18:19'),
(32, 'Download', 'Minhaj', 1, 'Salary-Sheet-Template-India.jpg', '2024-06-26 17:24:13'),
(33, 'Download', 'user2@gmail.com', 3, 'Salary-Sheet-Template-India.jpg', '2024-06-26 17:24:47'),
(34, 'Upload', 'Minhaj', 1, '6360926-Maya-Angelou-Quote-Nothing-will-work-unless-you-do.jpg', '2024-06-27 17:56:39'),
(35, 'Upload', 'Minhaj', 1, '1719472030218.jpeg', '2024-06-27 17:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `downloaded_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`id`, `file_name`, `downloaded_time`, `user`) VALUES
(1, 'analytics.JPG', '2024-06-21 08:15:35', 'guest'),
(2, 'bank salary sheet.pdf', '2024-06-21 08:58:17', 'guest'),
(3, '', '2024-06-21 10:23:30', 'guest'),
(4, 'Salary-Sheet-Excel-Template.jpg.webp', '2024-06-21 10:27:15', 'guest'),
(5, 'WhatsApp Image 2024-06-20 at 12.59.31.jpeg', '2024-06-21 10:40:09', 'guest'),
(6, 'analytics.JPG', '2024-06-21 10:44:46', 'guest'),
(7, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-21 10:46:30', 'guest'),
(8, 'Salary-Sheet-Excel-Template.jpg.webp', '2024-06-21 11:06:28', 'guest'),
(9, 'Payable_sheet_cash_2.png', '2024-06-21 11:10:12', 'guest'),
(10, 'Salary-Sheet-Excel-Template.jpg.webp', '2024-06-21 11:12:38', 'guest'),
(11, 'Payable_sheet_cash_2.png', '2024-06-21 11:12:57', 'guest'),
(12, 'Payable_sheet_cash_2.png', '2024-06-22 08:49:40', 'guest'),
(13, 'Category_Naspin.png', '2024-06-22 09:04:30', 'guest'),
(14, 'Payable_sheet.png', '2024-06-22 09:14:52', 'guest'),
(15, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-22 09:19:24', 'guest'),
(16, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-22 09:46:42', 'guest'),
(17, 'hs_code_issue.png', '2024-06-22 09:46:48', 'guest'),
(18, 'import_opening.png', '2024-06-22 09:46:54', 'guest'),
(19, 'Category_Naspin.png', '2024-06-22 10:19:10', 'guest'),
(20, 'Payable_sheet.png', '2024-06-22 10:27:31', 'guest'),
(21, 'Category_Naspin.png', '2024-06-22 10:27:57', 'guest'),
(22, 'Category_Naspin.png', '2024-06-22 10:38:24', 'guest'),
(23, 'Payable_sheet.png', '2024-06-22 10:42:17', 'guest'),
(24, 'Salary-Sheet-Excel-Template.jpg.webp', '2024-06-22 10:47:19', 'guest'),
(25, 'Payable_sheet.png', '2024-06-22 10:50:43', 'guest'),
(26, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-22 10:51:03', 'guest'),
(27, 'Category_Naspin.png', '2024-06-22 10:51:56', 'guest'),
(28, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-23 18:17:17', 'guest'),
(29, 'Payable_sheet_cash_2.png', '2024-06-23 18:39:38', 'guest'),
(30, 'Salary-Sheet-Excel-Template.jpg.webp', '2024-06-23 19:36:41', 'guest'),
(31, 'Payable_sheet_cash_2.png', '2024-06-23 23:06:03', 'guest'),
(32, 'Salary-Sheet-Excel-Template.jpg.webp', '2024-06-23 23:06:08', 'guest'),
(33, 'Payable_sheet.png', '2024-06-24 00:18:24', 'guest'),
(34, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-24 00:48:54', 'guest'),
(35, 'analytics.JPG', '2024-06-24 06:39:18', 'guest'),
(36, 'Payable_sheet_cash_2.png', '2024-06-24 06:48:14', 'guest'),
(37, 'Payable_sheet.png', '2024-06-24 08:33:21', 'Minhaj'),
(38, 'analytics.JPG', '2024-06-25 22:21:53', 'user2@gmail.com'),
(39, 'bank salary sheet.pdf', '2024-06-26 10:32:42', 'Minhaj'),
(40, 'Category_Naspin.png', '2024-06-26 10:33:56', 'user2@gmail.com'),
(41, 'analytics.JPG', '2024-06-26 11:21:53', 'Minhaj'),
(42, 'bank salary sheet.pdf', '2024-06-26 11:26:39', 'Minhaj'),
(43, 'Payable_sheet_cash_2.png', '2024-06-26 11:33:34', 'Minhaj'),
(44, 'Payable_sheet_cash_2.png', '2024-06-26 11:34:05', 'Minhaj'),
(45, 'Payable_sheet_cash_2.png', '2024-06-26 11:37:57', 'Minhaj'),
(46, 'Category_Naspin.png', '2024-06-26 11:38:31', 'Minhaj'),
(47, 'Payable_sheet_cash_2.png', '2024-06-26 11:38:58', 'Minhaj'),
(48, 'Quotes-about-confidence-for-women-1.jpg', '2024-06-26 11:40:52', 'Minhaj'),
(49, 'WhatsApp Image 2024-06-20 at 12.59.31.jpeg', '2024-06-26 11:41:46', 'Minhaj'),
(50, 'inventory_valuation_report.png', '2024-06-26 11:45:58', 'Minhaj'),
(51, 'items_import.csv', '2024-06-26 11:46:25', 'Minhaj'),
(52, 'Salary-Sheet-Template-India.jpg', '2024-06-26 12:24:13', 'Minhaj'),
(53, 'Salary-Sheet-Template-India.jpg', '2024-06-26 12:24:47', 'user2@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `filename`, `filepath`, `upload_date`) VALUES
(1, 'analytics.JPG', 'files/uploads/analytics.JPG', '2024-06-20 19:39:38'),
(2, 'Salary-Sheet-Excel-Template.jpg.webp', 'files/uploads/Salary-Sheet-Excel-Template.jpg.webp', '2024-06-20 20:52:44'),
(3, 'Payable_sheet_cash_2.png', 'files/uploads/Payable_sheet_cash_2.png', '2024-06-21 10:49:20'),
(4, 'Category_Naspin.png', 'files/uploads/Category_Naspin.png', '2024-06-21 11:15:38'),
(5, 'import_opening.png', 'files/uploads/import_opening.png', '2024-06-21 11:17:06'),
(6, 'hs_code_issue.png', 'files/uploads/hs_code_issue.png', '2024-06-22 08:38:47'),
(7, 'inventory_valuation_report.png', 'files/uploads/inventory_valuation_report.png', '2024-06-22 08:40:11'),
(8, 'items_import.csv', 'files/uploads/items_import.csv', '2024-06-22 08:41:21'),
(9, 'Payable_sheet.png', 'files/uploads/Payable_sheet.png', '2024-06-22 08:49:22'),
(10, 'Payable_sheet.png', 'files/uploads/Payable_sheet.png', '2024-06-23 18:17:55'),
(11, 'hs_code_issue.png', 'files/uploads/hs_code_issue.png', '2024-06-23 18:38:38'),
(12, 'Category_Naspin.png', 'files/uploads/Category_Naspin.png', '2024-06-23 18:43:48'),
(13, 'hs_code_issue.png', 'files/uploads/hs_code_issue.png', '2024-06-23 19:01:41'),
(14, 'import_opening.png', 'files/uploads/import_opening.png', '2024-06-23 19:37:21'),
(15, 'hs_code_issue.png', 'files/uploads/hs_code_issue.png', '2024-06-23 23:06:14'),
(16, 'items_import.csv', 'files/uploads/items_import.csv', '2024-06-24 00:18:37'),
(17, 'Payable_sheet.png', 'files/uploads/Payable_sheet.png', '2024-06-24 01:22:44'),
(18, 'import_opening.png', 'files/uploads/import_opening.png', '2024-06-24 06:39:24'),
(19, 'analytics.JPG', 'files/uploads/analytics.JPG', '2024-06-26 11:53:52'),
(20, 'items_import (3).csv', 'files/uploads/items_import (3).csv', '2024-06-26 12:05:49'),
(21, '', '2024-06-26 17:09:20', '0000-00-00 00:00:00'),
(22, '', '2024-06-26 17:10:57', '0000-00-00 00:00:00'),
(23, 'analytics (4).JPG', 'files/uploads/analytics (4).JPG', '2024-06-26 12:18:19'),
(24, '6360926-Maya-Angelou-Quote-Nothing-will-work-unless-you-do.jpg', 'files/uploads/6360926-Maya-Angelou-Quote-Nothing-will-work-unless-you-do.jpg', '2024-06-27 12:56:39'),
(25, '1719472030218.jpeg', 'files/uploads/1719472030218.jpeg', '2024-06-27 12:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`, `description`) VALUES
(1, 'edit', 'Edit user information'),
(2, 'update', 'Update user data'),
(3, 'delete', 'Delete user'),
(4, 'activate', 'Activate user account'),
(5, 'block', 'Block user account'),
(6, 'user_counts', 'View user counts'),
(7, 'download_full_list', 'Download full user list'),
(8, 'download_userwise_list', 'Download user-wise data'),
(9, 'upload_all_list', 'Upload data for all users'),
(10, 'upload_userwise_list', 'Upload data for specific users');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `description`) VALUES
(1, 'admin', 'Administrator with full access'),
(2, 'user', 'Regular user with limited access');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','blocked') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`, `role`, `created_at`, `status`) VALUES
(1, 'Minhaj Azeem', 'Minhaj', '$2y$10$Y0uKbEr5m54.conI1CeWOugFgP0E5m33.T7jeW1g/9X4rBnp7gacu', 'minhaj@gmail.com', 'admin', '2024-06-24 07:47:41', 'active'),
(2, 'Testing', 'testing', '$2y$10$ljDLOEaiBpQLgCoMh.Zem.L02tkPkds8EutECrtWSkPPACnaGGqP2', 'testing@gmail.com', 'admin', '2024-06-25 08:55:19', ''),
(3, 'User2', 'user2@gmail.com', '$2y$10$nUW9hJWDFk5BAxnEf2t3nOeFGTdrg2ty1UNpmSP7zHu9Ogmp8znUi', 'user2@gmail.com', 'user', '2024-06-25 21:35:53', 'active'),
(4, 'User3', 'user3@gmail.com', '$2y$10$WDZQN7KaT8veKZ0r2Tz7Z./jsi55M1aAYiZPKATAhPbeA7oDobNmC', 'user3@gmail.com', 'user', '2024-06-26 09:03:19', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `permission_name` (`permission_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
