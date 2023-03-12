-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 19, 2022 at 01:00 PM
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
-- Database: `unitedhospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dept_id` int(191) UNSIGNED DEFAULT NULL,
  `department_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dept_id`, `department_name`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 15, 'Cardiac Surgery', 1, 0, '2022-09-14 02:28:39', '2022-09-14 02:28:39'),
(2, 16, 'Cardiology', 1, 0, '2022-09-14 02:29:00', '2022-09-14 02:29:00'),
(3, 27, 'Communication & Business Development', 1, 0, '2022-09-14 02:29:11', '2022-09-14 02:29:11'),
(4, 31, 'Dentistry', 1, 0, '2022-09-14 02:29:21', '2022-09-14 02:29:21'),
(5, NULL, 'Hips', 1, 0, '2022-09-14 02:29:31', '2022-09-14 02:29:31'),
(6, 32, 'Dermatology', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(7, 33, 'Dietetics & Nutrition', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(8, 147, 'Dietetics and Nutrition', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(9, 35, 'Emergency', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(10, 36, 'Endocrinology', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(11, 38, 'ENT', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(12, 42, 'Finance & Accounts', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(13, 47, 'Gastroenterology', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(14, 48, 'General Anaesthesia', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(15, 51, 'General Surgery', 1, 0, '2022-09-19 10:41:10', '2022-09-19 10:41:10'),
(16, 54, 'Haematology', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(17, 56, 'Health Screening', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(18, 61, 'ICU', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(19, 64, 'Internal Medicine', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(20, 66, 'Laboratory', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(21, 77, 'Neonatology', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(22, 78, 'Nephrology', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(23, 79, 'Neuro Medicine', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(24, 80, 'Neuro Surgery', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(25, 82, 'Nuclear Medicine', 1, 0, '2022-09-19 10:45:05', '2022-09-19 10:45:05'),
(26, 85, 'Obstetrics & Gynaecology', 1, 0, '2022-09-19 10:46:14', '2022-09-19 10:46:14'),
(27, 86, 'Oncology', 1, 0, '2022-09-19 10:46:14', '2022-09-19 10:46:14'),
(44, 87, 'Operation & Administration', 1, 0, '2022-09-19 10:55:09', '2022-09-19 10:55:09'),
(45, 89, 'Ophthalmology', 1, 0, '2022-09-19 10:55:09', '2022-09-19 10:55:09'),
(46, 90, 'Orthopaedic', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(47, 92, 'Paediatrics', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(48, 93, 'Pain Relief', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(49, 97, 'Pediatric Surgery', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(50, 141, 'Physical Medicine', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(51, 104, 'Physical Medicine & Rehabilitation', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(52, 105, 'Physiotherapy', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(53, 106, 'Plastic Surgery', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(54, 108, 'Psychiatry & Behavioural Science', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(55, 109, 'Psychology', 1, 0, '2022-09-19 10:57:47', '2022-09-19 10:57:47'),
(56, 115, 'Radiology & Imaging', 1, 0, '2022-09-19 10:59:40', '2022-09-19 10:59:40'),
(57, 116, 'Respiratory Medicine', 1, 0, '2022-09-19 10:59:40', '2022-09-19 10:59:40'),
(58, 125, 'Thoracic Surgery', 1, 0, '2022-09-19 10:59:40', '2022-09-19 10:59:40'),
(59, 156, 'United Harvest', 1, 0, '2022-09-19 10:59:40', '2022-09-19 10:59:40'),
(60, 132, 'Urology', 1, 0, '2022-09-19 10:59:40', '2022-09-19 10:59:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dept_id` (`dept_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
