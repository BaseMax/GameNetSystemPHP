-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2021 at 04:57 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

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
(1, 'ماسک', 1499, 1500, '2021-02-05 13:41:57'),
(2, 'عارف', 5000, 3000, '2021-02-05 13:42:06'),
(3, 'متین', 1000000, 100000000, '2021-02-05 13:42:11'),
(4, 'علی', 0, 10000, '2021-02-05 13:46:00'),
(5, 'وحید', 0, 9500, '2021-03-06 12:03:54');

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
  `has_canceled` int(2) NOT NULL DEFAULT 0,
  `timer` int(2) DEFAULT 0,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `playID`, `startTime`, `planID`, `planIndexID`, `planDaste`, `planPrice`, `endTime`, `status`, `has_canceled`, `timer`, `datetime`) VALUES
(3255, 2861, 1620432383, 1, 6, 4, 234, NULL, 1, 0, 0, '2021-05-08 00:06:23'),
(3259, 2865, 1620434855, 1, 7, 2, 134, NULL, 1, 0, 0, '2021-05-08 00:47:35'),
(3263, 2868, 1620437617, 1, 5, 1, 100, 1620440729, 0, 0, 0, '2021-05-08 01:33:37'),
(3266, 2871, 1620438733, 2, 3, 2, 184, 1620442333, 1, 0, 1, '2021-05-08 01:51:57'),
(3267, 2872, 1620439383, 1, 2, 2, 134, NULL, 1, 0, 0, '2021-05-08 02:03:03'),
(3268, 2873, 1620439419, 2, 2, 4, 267, NULL, 1, 0, 0, '2021-05-08 02:03:39'),
(3270, 2868, 1620440729, 1, 8, 1, 100, NULL, 1, 0, 0, '2021-05-08 02:25:29'),
(3271, 2875, 1620440741, 1, 5, 2, 134, NULL, 1, 0, 0, '2021-05-08 02:25:41'),
(3272, 2876, 1620441659, 3, 1, 4, 267, NULL, 1, 0, 0, '2021-05-08 02:40:59'),
(3276, 2879, 1620442156, 1, 4, 1, 100, 1620445756, 1, 0, 1, '2021-05-08 02:49:08'),
(3277, 2880, 1620442215, 1, 3, 2, 134, NULL, 1, 0, 0, '2021-05-08 02:50:15');

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
(2, 9, 1, 1, 800, '2021-03-05 18:59:04'),
(7, 18, 4, 1, 100000, '2021-03-05 19:43:10'),
(8, 19, 1, 1, 800, '2021-03-05 19:43:57'),
(9, 29, 1, 1, 800, '2021-03-05 21:57:10'),
(12, 40, 1, 1, 800, '2021-03-06 10:48:57'),
(20, 57, 1, 4, 1500, '2021-03-06 14:12:40'),
(22, 60, 1, 5, 1500, '2021-03-06 14:14:34'),
(48, 198, 1, 1, 1500, '2021-03-08 13:32:23'),
(81, 339, 2, 2, 5000, '2021-03-10 14:22:03'),
(99, 416, 1, 3, 1500, '2021-03-11 12:40:21'),
(114, 470, 1, 2, 1500, '2021-03-11 19:37:34'),
(116, 472, 1, 2, 1500, '2021-03-11 19:39:12'),
(152, 730, 1, 1, 1500, '2021-03-15 16:00:18'),
(155, 737, 1, 1, 1500, '2021-03-15 16:42:28'),
(156, 741, 1, 1, 1500, '2021-03-15 17:07:06'),
(169, 880, 1, 1, 1500, '2021-03-18 00:41:03'),
(170, 881, 1, 1, 1500, '2021-03-18 00:41:13'),
(174, 974, 1, 2, 1500, '2021-03-19 01:50:28'),
(175, 975, 1, 2, 1500, '2021-03-19 01:50:43'),
(178, 982, 1, 2, 1500, '2021-03-19 02:32:56'),
(192, 1057, 1, 2, 1500, '2021-03-19 23:51:04'),
(204, 1115, 1, 1, 1500, '2021-03-20 07:44:07'),
(205, 1117, 1, 2, 1500, '2021-03-20 07:58:22'),
(209, 1126, 1, 2, 1500, '2021-03-21 02:17:06'),
(231, 1188, 1, 1, 1500, '2021-03-21 18:50:45'),
(232, 1189, 1, 2, 1500, '2021-03-21 18:51:04'),
(301, 1433, 1, 2, 1500, '2021-03-23 17:53:25'),
(310, 1446, 1, 2, 1500, '2021-03-23 20:04:09'),
(353, 1580, 1, 2, 1500, '2021-03-25 02:15:36'),
(357, 1590, 1, 1, 1500, '2021-03-25 03:01:41'),
(358, 1591, 1, 1, 1500, '2021-03-25 03:02:12'),
(396, 1748, 1, 2, 1500, '2021-03-26 21:17:54'),
(421, 1860, 1, 2, 1500, '2021-03-28 03:44:23'),
(428, 1893, 1, 2, 1500, '2021-03-28 18:10:45'),
(430, 1898, 1, 2, 1500, '2021-03-28 20:43:17'),
(434, 1932, 1, 1, 1500, '2021-03-29 03:35:17'),
(448, 1986, 1, 1, 1500, '2021-03-29 23:10:28'),
(449, 1991, 1, 1, 1500, '2021-03-30 00:37:52'),
(472, 2085, 1, 1, 1500, '2021-03-31 04:07:26'),
(474, 2089, 1, 2, 1500, '2021-03-31 04:25:59'),
(478, 2093, 1, 2, 1500, '2021-03-31 05:01:42'),
(481, 2096, 1, 2, 1500, '2021-03-31 05:02:57'),
(513, 2238, 1, 1, 1500, '2021-04-02 02:19:09'),
(514, 2240, 1, 1, 1500, '2021-04-02 02:22:59'),
(515, 2241, 1, 1, 1500, '2021-04-02 02:23:38'),
(541, 2333, 1, 1, 1500, '2021-04-04 06:00:25'),
(588, 2491, 4, 5, 10000, '2021-04-06 22:45:05'),
(589, 2492, 2, 3, 3000, '2021-04-06 22:45:11'),
(590, 2493, 5, 3, 9500, '2021-04-06 22:45:19'),
(591, 2494, 5, 3, 9500, '2021-04-06 22:45:23'),
(592, 2495, 1, 2, 1500, '2021-04-06 22:45:30'),
(640, 2692, 1, 1, 1500, '2021-04-09 23:07:56'),
(672, 2861, 1, 3, 1500, '2021-05-08 00:06:31'),
(675, 2875, 1, 2, 1500, '2021-05-08 02:25:51'),
(676, 2876, 1, 2, 1500, '2021-05-08 02:41:11');

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
(1, 'معمولی', 'یک دسته', 'دو دسته', 'سه دسته', 'چهار دسته', 8, 100, 134, 184, 234, '2021-01-14 16:58:13', '2021-03-21 11:39:33'),
(2, 'آنلاین', 'یک دسته', 'دو دسته', 'سه دسته', 'چهار دسته', 3, 134, 184, 234, 267, '2021-01-14 16:58:13', '2021-03-21 11:39:33'),
(3, 'VIP', 'یک دسته', 'دو دسته', 'سه دسته', 'چهار دسته', 1, 134, 184, 234, 267, '2021-01-14 16:58:13', '2021-03-21 11:39:33');

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
(9, 1, NULL, 0),
(13, 1, NULL, 0),
(18, 1, NULL, 0),
(19, 1, NULL, 0),
(29, 1, NULL, 0),
(40, 1, NULL, 0),
(57, 1, NULL, 0),
(60, 1, NULL, 0),
(198, 1, NULL, 0),
(339, 1, NULL, 0),
(416, 1, NULL, 0),
(470, 1, NULL, 0),
(472, 1, NULL, 0),
(730, 1, NULL, 0),
(737, 1, NULL, 0),
(741, 1, NULL, 0),
(880, 1, NULL, 0),
(881, 1, NULL, 0),
(974, 1, NULL, 0),
(975, 1, NULL, 0),
(982, 1, NULL, 0),
(1057, 1, NULL, 0),
(1115, 1, NULL, 0),
(1117, 1, NULL, 0),
(1126, 1, NULL, 0),
(1188, 1, NULL, 0),
(1189, 1, NULL, 0),
(1433, 1, NULL, 0),
(1446, 1, NULL, 0),
(1580, 1, NULL, 0),
(1590, 1, NULL, 0),
(1591, 1, NULL, 0),
(1748, 1, NULL, 0),
(1860, 1, NULL, 0),
(1893, 1, NULL, 0),
(1898, 1, NULL, 0),
(1932, 1, NULL, 0),
(1986, 1, NULL, 0),
(1991, 1, NULL, 0),
(2085, 1, NULL, 0),
(2089, 1, NULL, 0),
(2093, 1, NULL, 0),
(2096, 1, NULL, 0),
(2238, 1, NULL, 0),
(2240, 1, NULL, 0),
(2241, 1, NULL, 0),
(2333, 1, NULL, 0),
(2491, 1, NULL, 0),
(2492, 1, NULL, 0),
(2493, 1, NULL, 0),
(2494, 1, NULL, 0),
(2495, 1, NULL, 0),
(2692, 1, NULL, 0),
(2861, 1, NULL, 0),
(2865, 1, NULL, 0),
(2868, 1, NULL, 0),
(2871, 1, NULL, 0),
(2872, 1, NULL, 0),
(2873, 1, NULL, 0),
(2875, 1, NULL, 0),
(2876, 1, NULL, 0),
(2879, 1, NULL, 0),
(2880, 1, NULL, 0);

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
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3278;

--
-- AUTO_INCREMENT for table `orders_food`
--
ALTER TABLE `orders_food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=677;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `plays`
--
ALTER TABLE `plays`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2881;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
