-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 12:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pionir`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_table`
--

CREATE TABLE `activity_table` (
  `activity_table_id` int(11) NOT NULL,
  `activity_table_desc` text NOT NULL,
  `activity_table_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ms_brand`
--

CREATE TABLE `ms_brand` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(250) NOT NULL,
  `brand_desc` text NOT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ms_brand`
--

INSERT INTO `ms_brand` (`brand_id`, `brand_name`, `brand_desc`, `is_active`, `created_at`) VALUES
(1, 'COMFORTA', ' ', 'Y', '2024-12-23 23:49:56'),
(2, 'IMPORTA', ' ', 'Y', '2024-12-23 23:49:56'),
(3, 'HOMEDOKI', ' ', 'Y', '2024-12-23 23:49:56'),
(4, 'HOMELIVING', ' ', 'Y', '2024-12-23 23:49:56'),
(5, 'BIGLAND', ' ', 'Y', '2024-12-23 23:49:56'),
(6, 'OCEAN', ' ', 'Y', '2024-12-23 23:49:56'),
(7, 'SPRINGAIR', ' ', 'Y', '2024-12-23 23:49:56'),
(8, 'THERAPEDIC', ' ', 'Y', '2024-12-23 23:49:56'),
(9, 'IMPORIAL', ' ', 'Y', '2024-12-23 23:49:56'),
(10, 'BIGFOAM', ' ', 'Y', '2024-12-23 23:49:56'),
(11, 'CAMEL', ' ', 'Y', '2024-12-23 23:49:56'),
(12, 'INOAC', ' ', 'Y', '2024-12-23 23:49:56'),
(13, 'KWANTOP', ' ', 'Y', '2024-12-23 23:49:56'),
(14, 'VICA FOAM', ' ', 'Y', '2024-12-23 23:49:56'),
(15, 'G-STAR OLYMPIC', ' ', 'Y', '2024-12-23 23:49:56'),
(16, 'EAGLE KING', ' ', 'Y', '2024-12-23 23:49:56'),
(17, 'MARCO', ' ', 'Y', '2024-12-23 23:49:56'),
(18, 'OLYMBED', ' ', 'Y', '2024-12-23 23:49:56'),
(19, 'LUXURY', ' ', 'Y', '2024-12-23 23:49:56'),
(20, 'STEEL FOAM', ' ', 'Y', '2024-12-23 23:49:56'),
(21, 'NAIBA', ' ', 'Y', '2024-12-23 23:49:56'),
(22, 'AKAKO', '', 'Y', '2024-12-23 23:49:56'),
(23, 'OLYMPLAST', ' ', 'Y', '2024-12-23 23:49:56'),
(24, 'WDM KEA', ' ', 'Y', '2024-12-23 23:49:56'),
(25, 'WAKANDA', ' ', 'Y', '2024-12-23 23:49:56'),
(50, 'asd', 'asd', 'N', '2025-02-24 16:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `ms_customer`
--

CREATE TABLE `ms_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `customer_dob` date NOT NULL,
  `customer_gender` enum('L','P') NOT NULL,
  `customer_address` text NOT NULL,
  `customer_address_blok` varchar(250) NOT NULL,
  `customer_address_no` varchar(250) NOT NULL,
  `customer_rt` varchar(250) NOT NULL,
  `customer_rw` varchar(250) NOT NULL,
  `customer_phone` varchar(250) NOT NULL,
  `customer_email` varchar(250) NOT NULL,
  `customer_send_address` text NOT NULL,
  `customer_npwp` varchar(250) NOT NULL,
  `customer_nik` varchar(250) NOT NULL,
  `customer_rate` enum('Normal','Toko','Sales','Khusus') NOT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ms_customer_expedisi`
--

CREATE TABLE `ms_customer_expedisi` (
  `customer_expedisi_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `expedisi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_table`
--
ALTER TABLE `activity_table`
  ADD PRIMARY KEY (`activity_table_id`);

--
-- Indexes for table `ms_brand`
--
ALTER TABLE `ms_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `ms_customer`
--
ALTER TABLE `ms_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `ms_customer_expedisi`
--
ALTER TABLE `ms_customer_expedisi`
  ADD PRIMARY KEY (`customer_expedisi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_table`
--
ALTER TABLE `activity_table`
  MODIFY `activity_table_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_brand`
--
ALTER TABLE `ms_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `ms_customer`
--
ALTER TABLE `ms_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_customer_expedisi`
--
ALTER TABLE `ms_customer_expedisi`
  MODIFY `customer_expedisi_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
