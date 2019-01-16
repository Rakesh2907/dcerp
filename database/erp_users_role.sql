-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2019 at 04:44 AM
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
-- Table structure for table `erp_users_role`
--

CREATE TABLE `erp_users_role` (
  `erp_user_role_id` int(11) NOT NULL,
  `user_role` varchar(255) DEFAULT NULL,
  `permission` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_users_role`
--

INSERT INTO `erp_users_role` (`erp_user_role_id`, `user_role`, `permission`, `created`, `updated`, `is_deleted`) VALUES
(1, 'HOD', NULL, '2019-01-12 00:00:00', '2019-01-12 00:00:00', '0'),
(2, 'Staff', NULL, '2019-01-12 00:00:00', '2019-01-12 00:00:00', '0'),
(3, 'Manager', NULL, '2019-01-12 00:00:00', '2019-01-12 00:00:00', '0'),
(4, 'Senior Manager ', NULL, '2019-01-12 00:00:00', '2019-01-12 00:00:00', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `erp_users_role`
--
ALTER TABLE `erp_users_role`
  ADD PRIMARY KEY (`erp_user_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `erp_users_role`
--
ALTER TABLE `erp_users_role`
  MODIFY `erp_user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
