-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2019 at 04:51 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp_genetics`
--

-- --------------------------------------------------------

--
-- Table structure for table `erp_notifications`
--

CREATE TABLE `erp_notifications` (
  `notify_id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `notify_from` int(11) DEFAULT NULL,
  `notify_to` int(11) DEFAULT NULL,
  `modules` varchar(355) DEFAULT NULL,
  `variable` varchar(355) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `login_user_id` int(11) DEFAULT NULL,
  `notify_check` enum('unseen','seen') NOT NULL DEFAULT 'unseen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `erp_notifications`
--
ALTER TABLE `erp_notifications`
  ADD PRIMARY KEY (`notify_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `erp_notifications`
--
ALTER TABLE `erp_notifications`
  MODIFY `notify_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
