-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2021 at 09:28 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamenet`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(50) NOT NULL,
  `playID` bigint(50) NOT NULL,
  `startTime` bigint(50) NOT NULL,
  `planID` bigint(10) NOT NULL,
  `planPrice` bigint(50) NOT NULL,
  `endTime` bigint(50) DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `playID`, `startTime`, `planID`, `planPrice`, `endTime`, `datetime`) VALUES
(1, 1, 1610644113, 1, 101, 1610645032, '2021-01-14 17:08:33'),
(2, 2, 1610645389, 1, 101, 1610645391, '2021-01-14 17:29:49'),
(3, 3, 1610645745, 1, 101, 1610645750, '2021-01-14 17:35:45'),
(4, 4, 1610646170, 8, 500, 1610647202, '2021-01-14 17:42:50'),
(5, 4, 1610647202, 9, 0, 1610647326, '2021-01-14 18:00:02'),
(6, 4, 1610647326, 6, 0, 1610647398, '2021-01-14 18:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `family` text NOT NULL,
  `name` text NOT NULL,
  `price` bigint(20) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `datetimeUpdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `family`, `name`, `price`, `datetime`, `datetimeUpdate`) VALUES
(1, 'معمولی', 'تک نفره', 101, '2021-01-14 16:58:13', NULL),
(2, 'معمولی', 'دو نفره', 200, '2021-01-14 16:58:13', NULL),
(3, 'معمولی', 'سه نفره', 300, '2021-01-14 16:58:13', NULL),
(4, 'ویژه', 'یک نفره', 200, '2021-01-14 16:58:13', NULL),
(5, 'ویژه', 'دو نفره', 300, '2021-01-14 16:58:13', NULL),
(6, 'ویژه', 'سه نفره', 500, '2021-01-14 16:58:13', NULL),
(7, 'آنلاین', 'یک نفره', 300, '2021-01-14 16:58:13', NULL),
(8, 'آنلاین', 'دو نفره', 500, '2021-01-14 16:58:13', NULL),
(9, 'آنلاین', 'سه نفره', 700, '2021-01-14 16:58:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plays`
--

CREATE TABLE `plays` (
  `id` bigint(50) NOT NULL,
  `name` text NOT NULL,
  `pending` int(2) NOT NULL DEFAULT 1,
  `price` bigint(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plays`
--

INSERT INTO `plays` (`id`, `name`, `pending`, `price`) VALUES
(1, 'رضا', 0, 92819),
(2, 'عرفان', 0, 202),
(3, 'سیستم یک', 0, 101),
(4, 'علی اقا اختر', 0, 9000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plays`
--
ALTER TABLE `plays`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `plays`
--
ALTER TABLE `plays`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
