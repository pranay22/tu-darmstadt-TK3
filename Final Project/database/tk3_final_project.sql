-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2015 at 01:01 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tk3_final_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `times` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seat_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `occupied` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `room_id` int(11) NOT NULL,
  `no_of_seats` int(11) NOT NULL,
  `room_address` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tcp_info` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `no_of_seats`, `room_address`, `type`, `room_name`, `tcp_info`) VALUES
(1, 100, 'FB 20, S2|02', 'PC Pool', 'C Pool', NULL),
(2, 50, 'FB 20, S2|02', 'PC Pool', 'E Pool', NULL),
(3, 40, 'FB 20, S2|02', 'Study Room', 'SPZ', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE IF NOT EXISTS `seats` (
  `id` mediumint(9) NOT NULL,
  `room_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `occupied` tinyint(1) NOT NULL,
  `tags` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='seat information';

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `room_id`, `seat_id`, `occupied`, `tags`) VALUES
(1, 1, 1, 0, 'PC slot'),
(2, 1, 2, 1, 'PC slot'),
(3, 1, 3, 1, 'PC slot'),
(4, 1, 4, 0, 'Study slot'),
(5, 1, 5, 0, 'Study slot'),
(6, 1, 6, 0, 'Study slot'),
(7, 1, 7, 1, 'PC slot'),
(8, 1, 8, 1, 'PC slot'),
(9, 1, 9, 1, 'PC slot'),
(10, 1, 10, 1, 'PC slot'),
(11, 1, 11, 1, 'PC slot'),
(12, 1, 12, 0, 'Study slot'),
(13, 1, 13, 1, 'Study slot'),
(14, 1, 14, 1, 'PC slot'),
(15, 1, 15, 0, 'PC slot'),
(16, 1, 16, 1, 'Study slot'),
(17, 1, 17, 0, 'Study slot'),
(18, 1, 18, 1, 'Study slot'),
(19, 1, 19, 1, 'Study slot'),
(20, 1, 20, 0, 'Study slot'),
(21, 1, 21, 0, 'PC slot'),
(22, 1, 22, 1, 'PC slot'),
(23, 1, 23, 1, 'PC slot'),
(24, 1, 24, 0, 'PC slot'),
(25, 1, 25, 0, 'PC slot'),
(26, 1, 26, 1, 'PC slot'),
(27, 1, 27, 1, 'Study slot'),
(28, 1, 28, 1, 'Study slot'),
(29, 1, 29, 0, 'Study slot'),
(30, 1, 30, 0, 'Study slot'),
(31, 1, 31, 0, 'Study slot'),
(32, 1, 32, 1, 'Study slot'),
(112, 2, 1, 1, 'PC slot'),
(113, 2, 2, 1, 'PC slot'),
(114, 2, 3, 0, 'PC slot'),
(115, 2, 4, 0, 'PC slot'),
(116, 2, 5, 0, 'Study slot'),
(117, 2, 6, 1, 'Study slot'),
(118, 2, 7, 1, 'PC slot'),
(119, 2, 8, 1, 'PC slot'),
(120, 2, 9, 0, 'PC slot'),
(121, 2, 10, 0, 'PC slot'),
(122, 2, 11, 0, 'PC slot'),
(123, 2, 12, 0, 'PC slot'),
(124, 2, 13, 1, 'PC slot'),
(125, 2, 14, 1, 'PC slot'),
(126, 2, 15, 1, 'Study slot'),
(127, 2, 16, 0, 'Study slot'),
(128, 2, 17, 0, 'Study slot'),
(129, 2, 18, 1, 'Study slot'),
(130, 2, 19, 1, 'Study slot'),
(131, 2, 20, 0, 'Study slot'),
(132, 2, 21, 1, 'Study slot'),
(133, 2, 22, 1, 'Study slot'),
(134, 2, 23, 0, 'PC slot'),
(135, 2, 24, 1, 'PC slot'),
(136, 2, 25, 1, 'PC slot'),
(137, 2, 26, 0, 'PC slot'),
(138, 2, 27, 0, 'PC slot'),
(139, 2, 28, 0, 'Study slot'),
(140, 2, 29, 1, 'Study slot'),
(141, 2, 30, 1, 'Study slot'),
(142, 2, 31, 1, 'Study slot'),
(143, 2, 32, 0, 'Study slot'),
(144, 2, 33, 0, 'Study slot'),
(145, 2, 34, 0, 'Study slot'),
(146, 2, 35, 1, 'PC slot'),
(147, 2, 36, 1, 'PC slot'),
(148, 2, 37, 1, 'PC slot'),
(149, 2, 38, 1, 'Study slot'),
(150, 2, 39, 1, 'Study slot'),
(151, 2, 40, 1, 'Study slot'),
(152, 2, 41, 1, 'Study slot'),
(153, 2, 42, 1, 'Study slot'),
(154, 2, 43, 1, 'Study slot'),
(155, 2, 44, 0, 'Study slot'),
(156, 2, 45, 0, 'Study slot'),
(157, 2, 46, 0, 'Study slot'),
(158, 2, 47, 0, 'Study slot'),
(159, 2, 48, 1, 'Study slot'),
(160, 2, 49, 1, 'Study slot'),
(161, 2, 50, 1, 'Study slot'),
(162, 3, 1, 1, 'Study slot'),
(163, 3, 2, 1, 'Study slot'),
(164, 3, 3, 1, 'Study slot'),
(165, 3, 4, 1, 'Study slot'),
(166, 3, 5, 1, 'Study slot'),
(167, 3, 6, 1, 'PC slot'),
(168, 3, 7, 1, 'PC slot'),
(169, 3, 8, 1, 'PC slot'),
(170, 3, 9, 1, 'PC slot'),
(171, 3, 10, 1, 'PC slot'),
(172, 3, 11, 1, 'PC slot'),
(173, 3, 12, 1, 'PC slot'),
(174, 3, 13, 1, 'PC slot'),
(175, 3, 14, 1, 'PC slot'),
(176, 3, 15, 1, 'PC slot'),
(177, 3, 16, 1, 'PC slot'),
(178, 3, 17, 1, 'PC slot'),
(179, 3, 18, 1, 'PC slot'),
(180, 3, 19, 1, 'PC slot'),
(181, 3, 20, 1, 'Study slot'),
(182, 3, 21, 1, 'Study slot'),
(183, 3, 22, 1, 'Study slot'),
(184, 3, 23, 1, 'Study slot'),
(185, 3, 24, 1, 'Study slot'),
(186, 3, 25, 1, 'Study slot'),
(187, 3, 26, 1, 'Study slot'),
(188, 3, 27, 1, 'PC slot'),
(189, 3, 28, 1, 'PC slot'),
(190, 3, 29, 1, 'PC slot'),
(191, 3, 30, 1, 'PC slot'),
(192, 3, 31, 1, 'Study slot'),
(193, 3, 32, 1, 'Study slot'),
(194, 3, 33, 1, 'PC slot'),
(195, 3, 34, 1, 'PC slot'),
(196, 3, 35, 1, 'PC slot'),
(197, 3, 36, 1, 'PC slot'),
(198, 3, 37, 1, 'Study slot'),
(199, 3, 38, 1, 'Study slot'),
(200, 3, 39, 1, 'Study slot'),
(201, 3, 40, 1, 'Study slot');

-- --------------------------------------------------------

--
-- Table structure for table `seat_cam_pos`
--

CREATE TABLE IF NOT EXISTS `seat_cam_pos` (
  `cam_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `p0_x` int(11) DEFAULT NULL,
  `p0_y` int(11) DEFAULT NULL,
  `p1_x` int(11) DEFAULT NULL,
  `p1_y` int(11) DEFAULT NULL,
  `p2_x` int(11) DEFAULT NULL,
  `p2_y` int(11) DEFAULT NULL,
  `p3_x` int(11) DEFAULT NULL,
  `p3_y` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`times`, `seat_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD UNIQUE KEY `room_id` (`room_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=202;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
