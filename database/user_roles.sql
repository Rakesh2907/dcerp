-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2018 at 12:49 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `treatmyt_resilient`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` tinyint(4) NOT NULL,
  `user_role` varchar(50) DEFAULT NULL,
  `groups` text,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `is_deleted` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_role`, `groups`, `created`, `updated`, `is_deleted`) VALUES
(1, 'System Administrator', '["all"]', NULL, NULL, 'false'),
(2, 'CMD', NULL, NULL, '2017-09-25 10:10:03', 'true'),
(3, 'Medical Director', '["clinical_history","clinical_investigation_management","dcgl_investigation","patient_followup","registration","therapy_administrator"]', NULL, '2017-09-25 10:15:08', 'true'),
(4, 'Employee', NULL, '2017-09-16 10:06:32', NULL, 'false'),
(5, 'Director', '["clinical_history","clinical_investigation_management","dcgl_investigation","drug_inventory","patient_followup","registration","therapy_administrator"]', '2017-09-16 10:18:54', '2017-09-25 10:15:39', 'true'),
(6, 'Program Investigator', '["clinical_history","clinical_investigation_management","dcgl_investigation","drug_inventory","patient_followup","registration","therapy_administrator"]', '2017-09-16 10:19:05', '2017-09-25 10:17:21', 'true'),
(7, 'Operations', '["billing","clinical_history","drug_inventory","registration","therapy_administrator"]', '2017-09-24 21:47:57', NULL, 'true'),
(8, 'Senior Scientist', '["dcgl_investigation"]', '2017-09-24 21:48:59', NULL, 'true'),
(9, 'Scientist', '["billing"]', '2017-09-24 21:49:22', NULL, 'true'),
(10, 'Consultant', NULL, '2017-09-24 21:50:06', NULL, 'true'),
(11, 'Program Coordinator', '["billing","clinical_history","clinical_investigation_management","drug_inventory","patient_followup","registration","therapy_administrator"]', '2017-09-24 21:55:30', NULL, 'true'),
(12, 'Medical Officer', '["clinical_history","clinical_investigation_management","patient_followup","registration","therapy_administrator"]', '2017-09-24 21:56:08', NULL, 'true'),
(13, 'Response', '["clinical_history","registration"]', '2017-09-24 21:56:30', NULL, 'true'),
(14, 'Accounts', '["billing"]', '2017-09-24 21:56:51', NULL, 'true'),
(15, 'Purchase', '["billing","drug_inventory"]', '2017-09-24 21:57:06', NULL, 'true'),
(16, 'Patient', NULL, '2018-01-24 04:55:20', NULL, 'true'),
(17, NULL, NULL, '2018-04-17 14:54:29', NULL, 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
