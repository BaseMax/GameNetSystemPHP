-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 04, 2021 at 10:47 PM
-- Server version: 10.3.27-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asrezir_gamenet`
--

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` bigint(50) NOT NULL,
  `name` varchar(256) NOT NULL,
  `buy` bigint(20) NOT NULL,
  `sale` bigint(20) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `name`, `buy`, `sale`, `datetime`) VALUES
(1, 'کیک یزدی', 500, 800, '2021-02-05 13:41:57'),
(2, 'نوشابه کوچک', 1500, 2000, '2021-02-05 13:42:06'),
(3, 'دلستر بزرگ', 5000, 6000, '2021-02-05 13:42:11'),
(4, 'مواد', 60000, 100000, '2021-02-05 13:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(50) NOT NULL,
  `playID` bigint(50) NOT NULL,
  `startTime` bigint(50) NOT NULL,
  `planID` bigint(10) NOT NULL,
  `planIndexID` int(5) NOT NULL,
  `planDaste` int(11) NOT NULL,
  `planPrice` bigint(50) NOT NULL,
  `endTime` bigint(50) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `timer` int(2) DEFAULT 0,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `playID`, `startTime`, `planID`, `planIndexID`, `planDaste`, `planPrice`, `endTime`, `status`, `timer`, `datetime`) VALUES
(1, 1, 1614875669, 1, 1, 1, 84, 1614878969, 1, 0, '2021-03-04 17:11:37'),
(2, 2, 1614878609, 1, 4, 1, 84, NULL, 1, NULL, '2021-03-04 17:23:29'),
(3, 3, 1614878616, 1, 8, 4, 200, NULL, 1, NULL, '2021-03-04 17:23:36'),
(4, 4, 1614878620, 2, 3, 3, 217, NULL, 1, NULL, '2021-03-04 17:23:40'),
(5, 5, 1614878626, 3, 1, 2, 167, NULL, 1, NULL, '2021-03-04 17:23:46'),
(6, 1, 1614877871, 1, 1, 4, 200, 1614879071, 1, NULL, '2021-03-04 17:29:29'),
(7, 1, 1614882860, 1, 1, 2, 117, 1614890060, 1, 1, '2021-03-04 17:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `orders_food`
--

CREATE TABLE `orders_food` (
  `id` int(11) NOT NULL,
  `playID` int(11) NOT NULL,
  `foodID` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders_food`
--

INSERT INTO `orders_food` (`id`, `playID`, `foodID`, `count`, `price`, `datetime`) VALUES
(1, 1, 1, 1, 800, '2021-03-04 17:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `family` text NOT NULL,
  `name1` text NOT NULL,
  `name2` text NOT NULL,
  `name3` text NOT NULL,
  `name4` text NOT NULL,
  `count` int(5) NOT NULL DEFAULT 1,
  `price1` bigint(20) NOT NULL DEFAULT 0,
  `price2` int(11) NOT NULL DEFAULT 0,
  `price3` int(11) NOT NULL DEFAULT 0,
  `price4` int(11) NOT NULL DEFAULT 0,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `datetimeUpdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `family`, `name1`, `name2`, `name3`, `name4`, `count`, `price1`, `price2`, `price3`, `price4`, `datetime`, `datetimeUpdate`) VALUES
(1, 'معمولی', 'یک دسته', 'دو دسته', 'سه دسته', 'چهار دسته', 8, 84, 117, 150, 200, '2021-01-14 16:58:13', '2021-02-02 19:52:46'),
(2, 'آنلاین', 'یک دسته', 'دو دسته', 'سه دسته', 'چهار دسته', 3, 109, 142, 217, 250, '2021-01-14 16:58:13', '2021-02-02 19:52:49'),
(3, 'VIP', 'یک دسته', 'دو دسته', 'سه دسته', 'چهار دسته', 1, 100, 167, 217, 250, '2021-01-14 16:58:13', '2021-02-02 19:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `plays`
--

CREATE TABLE `plays` (
  `id` bigint(50) NOT NULL,
  `pending` int(2) NOT NULL DEFAULT 1,
  `price` bigint(50) DEFAULT NULL,
  `prePayment` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plays`
--

INSERT INTO `plays` (`id`, `pending`, `price`, `prePayment`) VALUES
(1, 1, NULL, 600),
(2, 1, NULL, 0),
(3, 1, NULL, 0),
(4, 1, NULL, 0),
(5, 1, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_food`
--
ALTER TABLE `orders_food`
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
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders_food`
--
ALTER TABLE `orders_food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `plays`
--
ALTER TABLE `plays`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
