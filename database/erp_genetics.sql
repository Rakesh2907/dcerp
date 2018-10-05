-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2018 at 12:32 PM
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
-- Table structure for table `erp_auto_increament`
--

CREATE TABLE `erp_auto_increament` (
  `id` int(11) NOT NULL,
  `material_requisation_number` varchar(255) NOT NULL,
  `quotation_request_number` varchar(255) NOT NULL,
  `material_unique_number` varchar(255) DEFAULT NULL,
  `po_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_auto_increament`
--

INSERT INTO `erp_auto_increament` (`id`, `material_requisation_number`, `quotation_request_number`, `material_unique_number`, `po_number`) VALUES
(1, '000012', '000020', 'DCGL/29', 'DCGL/2018/14');

-- --------------------------------------------------------

--
-- Table structure for table `erp_categories`
--

CREATE TABLE `erp_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_code` varchar(255) DEFAULT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_for` enum('general_po','material_po') DEFAULT 'general_po',
  `cat_stockable` enum('consumable','non_consumable') DEFAULT 'consumable',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_categories`
--

INSERT INTO `erp_categories` (`cat_id`, `cat_code`, `cat_name`, `cat_for`, `cat_stockable`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(-1, 'DEFAULT', 'DEFAULT', 'general_po', 'consumable', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1, '0'),
(1, '1', 'GENERAL ITEMS', 'general_po', 'consumable', '2018-08-11 07:06:02', 1, '2018-08-30 12:43:11', 1, '1'),
(2, '2', 'CHEMICAL', 'material_po', 'non_consumable', '2018-08-11 07:11:22', 1, '2018-09-18 16:10:32', 1, '0'),
(3, '3', 'CONSUMABLE', 'general_po', 'consumable', '2018-08-11 07:12:31', 1, NULL, NULL, '0'),
(4, '4', 'CHEMICAL (EXTRACTION)', 'material_po', 'consumable', '2018-08-11 07:13:27', 1, '2018-08-20 03:52:15', 1, '0'),
(5, '5', 'CONSUMABLES INSTRUMENT', 'material_po', 'consumable', '2018-08-11 07:15:24', 1, NULL, NULL, '0'),
(6, '6', 'PLASTIC CONSUMABLE', 'general_po', 'consumable', '2018-08-11 07:17:43', 1, '2018-08-30 12:41:24', 1, '0'),
(7, '7', 'INSTRUMENT', 'material_po', 'consumable', '2018-08-11 07:19:40', 1, NULL, NULL, '0'),
(8, '8', 'LOCAL ITEMS', 'material_po', 'consumable', '2018-08-11 07:21:22', 1, '2018-08-18 12:51:13', 1, '0'),
(9, '9', 'INSTALLATIONS & SERVICES', 'general_po', 'non_consumable', '2018-08-11 07:25:35', 1, NULL, NULL, '0'),
(10, '10', 'REAGENTS', 'material_po', 'consumable', '2018-08-11 07:27:15', 1, '2018-08-31 11:17:45', 1, '1'),
(11, '11', 'test', 'material_po', 'consumable', '2018-08-11 08:47:07', 1, '2018-08-30 12:42:54', 1, '1'),
(12, '12', 'test2', 'material_po', 'consumable', '2018-08-11 11:32:37', 1, '2018-08-30 12:43:00', 1, '1'),
(14, 'test2', 'TEST2', 'material_po', 'consumable', '2018-08-18 04:44:41', 1, '2018-08-30 12:53:56', 1, '1'),
(15, 'test123', 'TEST123', 'material_po', 'consumable', '2018-08-18 04:45:33', 1, '2018-08-30 12:54:04', 1, '1'),
(16, '133', 'RREWRER', 'material_po', 'consumable', '2018-08-18 11:17:23', 1, '2018-08-30 12:43:28', 1, '1'),
(17, 'ewe', 'EWE', 'material_po', 'consumable', '2018-08-18 11:48:45', 1, '2018-08-30 12:43:38', 1, '1'),
(18, '12', 'TEST CATEGOR', 'material_po', 'consumable', '2018-08-22 11:48:32', 1, '2018-08-30 12:43:16', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `erp_custom_duty`
--

CREATE TABLE `erp_custom_duty` (
  `custom_duty` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_custom_duty`
--

INSERT INTO `erp_custom_duty` (`custom_duty`) VALUES
('Extra as applicable'),
('NIL'),
('NA'),
(NULL);

-- --------------------------------------------------------

--
-- Table structure for table `erp_delievery_schedule`
--

CREATE TABLE `erp_delievery_schedule` (
  `delievery_schedule` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_delievery_schedule`
--

INSERT INTO `erp_delievery_schedule` (`delievery_schedule`) VALUES
('01-01-2018 to 31-12-2018'),
('IMMIDIATE');

-- --------------------------------------------------------

--
-- Table structure for table `erp_departments`
--

CREATE TABLE `erp_departments` (
  `dep_id` int(11) NOT NULL,
  `dep_name` varchar(255) DEFAULT NULL,
  `dep_description` varchar(255) DEFAULT NULL,
  `access_permission` enum('true','false') NOT NULL DEFAULT 'false',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_departments`
--

INSERT INTO `erp_departments` (`dep_id`, `dep_name`, `dep_description`, `access_permission`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(13, 'DIAGNOSTIC LAB', 'Diagnostic lab', 'false', '2018-08-20 13:06:19', 1, '2018-08-20 15:02:58', 1, '0'),
(14, 'STEM CELL LAB', 'Stem cell lab', 'false', '2018-08-20 13:06:46', 1, '2018-08-20 15:03:02', 1, '0'),
(15, 'ANIMAL TISSUE LAB', 'Animal tissue lab', 'false', '2018-08-20 13:07:41', 1, '2018-08-30 15:11:41', 1, '0'),
(16, 'RESPONSE', 'Response', 'false', '2018-08-20 13:08:21', 1, '2018-09-05 11:25:17', 1, '0'),
(17, 'ADMINISTRATION', 'Administration', 'false', '2018-08-20 13:58:46', 1, '2018-08-30 15:11:32', 1, '0'),
(18, 'LOGISTICS', 'logistics', 'false', '2018-08-20 13:59:25', 1, '2018-08-20 15:03:20', 1, '0'),
(19, 'MAINTAINANCE', 'maintainance', 'false', '2018-08-20 13:59:59', 1, '2018-08-20 15:03:28', 1, '0'),
(20, 'ITD', 'ITD', 'false', '2018-08-20 14:00:32', 1, '2018-09-05 11:24:25', 1, '0'),
(21, 'PURCHASE', 'Purchase', 'true', '2018-08-20 14:00:58', 1, '2018-08-20 15:03:39', 1, '0'),
(22, 'STORES', 'stores', 'false', '2018-08-20 14:01:26', 1, '2018-08-20 15:03:43', 1, '0'),
(23, 'PRINTING', '', 'false', '2018-08-20 14:01:51', 1, '2018-08-20 15:03:47', 1, '0'),
(24, 'ACCOUNT', 'Account', 'false', '2018-08-20 14:02:46', 1, '2018-08-30 15:10:39', 1, '0'),
(25, 'QUALITY ASSURANCE', 'Quality Assurance', 'false', '2018-08-20 14:03:28', 1, '2018-08-20 15:04:00', 1, '0'),
(26, 'R & D', 'R & D', 'false', '2018-08-20 14:04:04', 1, '2018-08-20 15:04:04', 1, '0'),
(27, 'HRD', '', 'false', '2018-08-20 14:04:41', 1, '2018-09-05 11:25:54', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_freight_charges`
--

CREATE TABLE `erp_freight_charges` (
  `freight_charges` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_freight_charges`
--

INSERT INTO `erp_freight_charges` (`freight_charges`) VALUES
('At Actual'),
('Extra as applicable'),
('NIL'),
(NULL);

-- --------------------------------------------------------

--
-- Table structure for table `erp_locations`
--

CREATE TABLE `erp_locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_locations`
--

INSERT INTO `erp_locations` (`location_id`, `location_name`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(1, '-20', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(2, '-20 degree', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(3, '4 degree samsung', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(4, '4 degree samsung big', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(5, 'All Departments', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(6, 'ATC', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(7, 'cell frost', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(8, 'CTC', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(9, 'DIAGNOSIS', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(10, 'DIAGNOSTICS', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(11, 'GROUND FLOOR DGL', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(12, 'GROUND FLOOR Histopath Lab', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(13, 'Histopath Lab', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(14, 'IHC', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(15, 'IT', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(16, 'LIMS-Developers', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(17, 'Marketing', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(18, 'PRINTING', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(19, 'R&D', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(20, 'Response', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(21, 'Room Temperature', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(22, 'RT', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(23, 'RT -20', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(24, 'RT 20 to 80c -200c', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(25, 'Server room', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1),
(26, 'Stem cell', '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_master`
--

CREATE TABLE `erp_material_master` (
  `mat_id` int(11) NOT NULL,
  `unique_number` varchar(255) DEFAULT NULL,
  `mat_code` varchar(255) DEFAULT NULL,
  `mat_name` varchar(255) DEFAULT NULL,
  `mat_details` varchar(255) DEFAULT NULL,
  `mat_rate` float DEFAULT NULL,
  `cat_id` int(11) NOT NULL COMMENT 'table erp_categories',
  `sub_cat_id` int(11) DEFAULT NULL COMMENT 'table erp_sub_categories',
  `mat_parent_id` int(11) DEFAULT NULL,
  `parent_mat_code` varchar(255) DEFAULT NULL,
  `parent_mat_name` varchar(255) DEFAULT NULL,
  `make` varchar(255) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL COMMENT 'table erp_unit_master',
  `opening_stock` float DEFAULT NULL,
  `current_stock` float DEFAULT NULL,
  `as_on_date` datetime DEFAULT NULL,
  `minimum_level` float DEFAULT NULL,
  `reorder_qty` float DEFAULT NULL,
  `mat_length` float NOT NULL,
  `mat_weight` float DEFAULT NULL,
  `weight_unit_id` int(255) DEFAULT NULL COMMENT 'table erp_unit_master',
  `location_id` int(11) NOT NULL COMMENT 'table erp_locations',
  `tolerance` float DEFAULT NULL,
  `length_unit_id` int(11) DEFAULT NULL COMMENT 'table erp_unit_master',
  `free_stock` float DEFAULT NULL,
  `mat_rate2` float DEFAULT NULL,
  `prod_type` varchar(255) DEFAULT NULL,
  `rejected_opening_qty` float DEFAULT NULL,
  `rejected_current_qty` float DEFAULT NULL,
  `mat_status` enum('Regular','Non-Moveable','Deactive') NOT NULL,
  `scrape_opening_qty` float DEFAULT NULL,
  `scrape_current_qty` float DEFAULT NULL,
  `transport` float DEFAULT NULL,
  `mat_width` float DEFAULT NULL,
  `mat_thickness` float DEFAULT NULL,
  `packing` varchar(255) DEFAULT NULL,
  `pack_size` varchar(255) DEFAULT NULL,
  `no_of_reaction` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_master`
--

INSERT INTO `erp_material_master` (`mat_id`, `unique_number`, `mat_code`, `mat_name`, `mat_details`, `mat_rate`, `cat_id`, `sub_cat_id`, `mat_parent_id`, `parent_mat_code`, `parent_mat_name`, `make`, `unit_id`, `opening_stock`, `current_stock`, `as_on_date`, `minimum_level`, `reorder_qty`, `mat_length`, `mat_weight`, `weight_unit_id`, `location_id`, `tolerance`, `length_unit_id`, `free_stock`, `mat_rate2`, `prod_type`, `rejected_opening_qty`, `rejected_current_qty`, `mat_status`, `scrape_opening_qty`, `scrape_current_qty`, `transport`, `mat_width`, `mat_thickness`, `packing`, `pack_size`, `no_of_reaction`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(3, 'DCGL/01', '4471269', 'Ion Xpress™ Plus Fragment Library Kit', 'Ion Xpress™ Plus Fragment Library Kit', 46222.8, 5, 67, 0, NULL, NULL, NULL, 2, 12, 2, '2014-03-14 12:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 2, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-16 12:40:40', 1, NULL, NULL, '0'),
(4, 'DCGL/02', 'S018', 'MAYER\'S HEMATOXYLIN', 'Himedia', 0, 3, 69, 0, NULL, NULL, NULL, 2, 0, 0, '2014-03-14 12:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 03:59:40', 1, NULL, NULL, '0'),
(17, 'DCGL/03', '0215757401', '4′,6-DIAMIDINO-2-PHENYLINDOLE', '4′,6-DIAMIDINO-2-PHENYLINDOLE', 0, 2, -1, 17, '0215757401', '4′,6-DIAMIDINO-2-PHENYLINDOLE', NULL, 2, 0, 1, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 04:51:46', 1, '2018-08-20 06:05:18', 1, '0'),
(18, 'DCGL/04', '3540C/3541C', 'XYLENE Sulpher Free Histological Grade Qualigen 25 Ltr Pack', 'XYLENE Sulpher Free Histological Grade Qualigen 25 Ltr Pack', 0, 2, -1, 0, NULL, NULL, NULL, 2, 0, 24, '2014-03-14 12:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 53, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 04:53:33', 1, NULL, NULL, '0'),
(19, 'DCGL/05', '0217006201', 'COPLIN STAINING JAR', 'COPLIN STAINING JAR', 0, 2, -1, 19, '0217006201', 'COPLIN STAINING JAR', NULL, 2, 2, 2, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 04:57:36', 1, '2018-08-20 06:05:38', 1, '0'),
(20, 'DCGL/06', '0219405490', 'HYDROCHLORIC ACID, ACS', 'HYDROCHLORIC ACID, ACS', 0, 2, -1, 20, '0219405490', 'HYDROCHLORIC ACID, ACS', NULL, 2, 1, 1, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 05:00:22', 1, '2018-08-30 10:52:32', 1, '1'),
(21, 'DCGL/07', '02195501.5', 'SODIUM PHOSPHATE DIBASIC', 'SODIUM PHOSPHATE DIBASIC', 0, 2, -1, 21, '02195501.5', 'SODIUM PHOSPHATE DIBASIC', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 05:02:01', 1, '2018-08-20 06:07:58', 1, '0'),
(22, 'DCGL/08', '02199802.5', 'SODIUM PHOSPHATE DIBASIC ANHYDROUS, U.S.P.', 'SODIUM PHOSPHATE DIBASIC ANHYDROUS, U.S.P.', 0, 2, -1, 22, '02199802.5', 'SODIUM PHOSPHATE DIBASIC ANHYDROUS, U.S.P.', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 05:03:46', 1, '2018-08-20 06:06:12', 1, '0'),
(23, 'DCGL/09', '091688045', 'HYDROCHLORIC ACID, ACS', 'HYDROCHLORIC ACID, ACS', 0, 2, -1, 23, '091688045', 'HYDROCHLORIC ACID, ACS', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 05:05:23', 1, '2018-08-30 10:59:15', 1, '1'),
(24, 'DCGL/10', 'AMC for Air Handling Unit', 'AMC for Air Handling Unit', 'AMC for Air Handling Unit', 0, 9, -1, 24, 'AMC for Air Handling Unit', 'AMC for Air Handling Unit', NULL, 2, 0, 0, '2014-05-30 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 07:00:53', 1, '2018-08-20 06:06:55', 1, '0'),
(25, 'DCGL/11', '096400204', 'Membrane Filters, D26-45 Filters 0.45 µm', 'Membrane Filters, D26-45 Filters 0.45 µm', 0, 2, -1, 25, '096400204', 'Membrane Filters, D26-45 Filters 0.45 µm', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 11:39:52', 1, '2018-08-17 11:42:28', 1, '0'),
(26, 'DCGL/12', '097690105', 'SMARTPLASTIC™ TISSUE CULTURE DISH', 'SMARTPLASTIC™ TISSUE CULTURE DISH', 0, 2, -1, 26, '097690105', 'SMARTPLASTIC™ TISSUE CULTURE DISH', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 11:44:50', 1, '2018-08-17 11:46:24', 1, '0'),
(27, 'DCGL/11', '10400C', '10400C -  NORMAL MS IGG 5 ML', '10400C -  NORMAL MS IGG 5 ML', 8268.02, 2, -1, 0, '', '', NULL, 2, 1, 1, '2014-03-14 00:00:00', 1, 0, 0, 0, 2, 3, 0, 2, 1, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '5ml', '', '2018-08-17 12:21:45', 1, '2018-08-30 12:15:32', 1, '1'),
(28, 'DCGL/12', '10416-014', '50 bp DNA Ladder, Make : Invitrogen', '50 bp DNA Ladder, Make : Invitrogen', 9106.44, 2, -1, 28, '10416-014', '50 bp DNA Ladder, Make : Invitrogen', NULL, 2, 4, 7, '2014-09-03 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 8, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '50 ug', '', '2018-08-17 12:24:19', 1, '2018-08-17 12:24:47', 1, '0'),
(29, 'DCGL/13', '10488058', '10488058 -  TRACKIT 100 BP DNA LADDER 100', '10488058 -  TRACKIT 100 BP DNA LADDER 100', 4815.01, 3, -1, 29, '10488058', '10488058 -  TRACKIT 100 BP DNA LADDER 100', NULL, 22, 1, 1, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '100 appls (0.1 ug/ml)', '', '2018-08-17 12:27:53', 1, '2018-08-30 10:59:23', 1, '1'),
(35, 'DCGL/14', '12330', 'test2343423', 'rrerewr', 10, 5, 122, 0, '', '', NULL, 2, 0, 0, '2018-08-22 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-22 10:32:33', 1, NULL, NULL, '0'),
(38, 'DCGL/15', 'fdfdf', 'fdfdsfdsf', 'fdsfdsfdsf', 0, 7, 8, 0, '', '', NULL, 2, 0, 0, '2018-08-22 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-22 12:35:53', 1, NULL, NULL, '0'),
(39, 'DCGL/16', 'dsdsdsad1212', 'fdfdsfdsfds', 'fdsfdsfdsfsdf fdsfdsf', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-22 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-22 03:04:16', 1, NULL, NULL, '0'),
(40, 'DCGL/17', '244444444', 'trffdfsdfs', 'fdsfdsf', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-22 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-22 04:36:20', 1, '2018-08-30 10:53:42', 1, '1'),
(41, 'DCGL/18', '104 test 12345', 'ffsdf', 'fdsfdf', 0, 1, 123, 0, '', '', NULL, 2, 0, 0, '2018-08-24 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-24 04:04:56', 1, '2018-08-30 10:52:26', 1, '1'),
(42, 'DCGL/19', 'test_supp_28_08', 'test_supp_28_08', 'fcdsfdsf', 0, 1, 124, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:27:34', 1, '2018-08-30 10:52:19', 1, '1'),
(43, 'DCGL/20', 'test_requisation_28_08', 'test_requisation_28_08', 'test_requisation_28_08', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:28:59', 1, '2018-08-30 10:59:48', 1, '1'),
(44, 'DCGL/21', 'test_requisation_28_08_18', 'test_requisation_28_08', 'test_requisation_28_08', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:30:06', 1, NULL, NULL, '0'),
(45, 'DCGL/22', 'test_requisation_28_08_18_10_37', 'test_requisation_28_08', 'test_requisation_28_08', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:37:12', 1, NULL, NULL, '0'),
(46, 'DCGL/23', 'test_spplier_28_08', 'test_spplier_28_08', 'test_spplier_28_08', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:38:20', 1, NULL, NULL, '0'),
(47, 'DCGL/24', 'test_req_28_08', 'test_req_28_08', 'test_req_28_08', 0, 7, 8, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:39:52', 1, NULL, NULL, '0'),
(49, 'DCGL/25', 'trttrt', 'trtrt', 'trt', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-09-05 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-05 17:59:32', 1, NULL, NULL, '0'),
(52, 'DCGL/26', 'test_quo_444', 'test_quo_444', 'test_quo_444', 0, 7, 8, 16, '0215538791', 'METHANOL', NULL, 2, 0, 0, '2018-09-06 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-06 17:58:26', 1, NULL, NULL, '0'),
(53, 'DCGL/27', 'jdsddd', 'test unique number', 'test unique number', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-09-20 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-20 15:30:04', 1, NULL, NULL, '0'),
(54, 'DCGL/28', 'fffdfdfdf333', 'test unique number 1212', 'test unique number 1212', 0, 5, 67, 0, '', '', NULL, 2, 0, 0, '2018-09-20 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-20 15:30:58', 1, NULL, NULL, '0'),
(56, 'DCGL/29', 'fffdfdffdfdfdfdfdff666', 'test unique numberffdfdf', 'test unique numberffdfdf', 0, 5, 67, 0, '', '', NULL, 2, 0, 0, '2018-09-20 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-20 15:38:50', 1, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_quotation_draft`
--

CREATE TABLE `erp_material_quotation_draft` (
  `quo_draft_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `require_qty` float DEFAULT NULL,
  `dep_id` int(11) NOT NULL,
  `mat_req_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_quotation_request`
--

CREATE TABLE `erp_material_quotation_request` (
  `quo_req_id` int(11) NOT NULL,
  `quotation_request_number` varchar(255) DEFAULT NULL,
  `request_date` date NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `dep_id` int(11) NOT NULL,
  `approval_by` int(11) DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `approval_status` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `approval_status_account` enum('pending','approval') DEFAULT 'pending',
  `approval_vendor_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_quotation_request`
--

INSERT INTO `erp_material_quotation_request` (`quo_req_id`, `quotation_request_number`, `request_date`, `supplier_id`, `dep_id`, `approval_by`, `approval_date`, `approval_status`, `approval_status_account`, `approval_vendor_id`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 'Quo/2018/00007', '2018-09-08', '10,11,3,2', 20, 1, '2018-09-11 15:26:37', 'approved', 'pending', 3, '2018-09-08 09:59:28', 1, '2018-09-11 15:26:37', 1, '0'),
(2, 'Quo/2018/00008', '2018-09-08', '2,9', 20, 4, '2018-10-05 17:00:42', 'pending', 'pending', 2, '2018-09-08 15:12:17', 1, '2018-10-05 17:00:42', 4, '0'),
(3, 'Quo/2018/00009', '2018-09-10', '5', 20, 0, '0000-00-00 00:00:00', 'pending', 'pending', NULL, '2018-09-10 14:10:00', 1, NULL, NULL, '0'),
(4, 'Quo/2018/000010', '2018-09-10', '1,2,3,4,5,6,10', 20, 0, '0000-00-00 00:00:00', 'pending', 'pending', NULL, '2018-09-10 14:51:54', 1, NULL, NULL, '0'),
(5, 'Quo/2018/000011', '2018-09-10', '1,2,3,4', 20, 0, '0000-00-00 00:00:00', 'pending', 'pending', NULL, '2018-09-10 14:57:39', 1, NULL, NULL, '0'),
(6, 'Quo/2018/000012', '2018-09-12', '6,9', 21, NULL, NULL, 'pending', 'pending', NULL, '2018-09-12 15:17:13', 4, NULL, NULL, '0'),
(7, 'Quo/2018/000013', '2018-09-12', '1,5', 21, NULL, NULL, 'pending', 'pending', NULL, '2018-09-12 16:57:44', 4, NULL, NULL, '0'),
(10, 'Quo/2018/000015', '2018-09-25', '2', 21, NULL, NULL, 'pending', 'pending', NULL, '2018-09-25 13:30:17', 4, NULL, NULL, '0'),
(11, 'Quo/2018/000016', '2018-09-26', '3', 21, NULL, NULL, 'pending', 'pending', NULL, '2018-09-26 16:29:53', 4, NULL, NULL, '0'),
(12, 'Quo/2018/000017', '2018-10-05', '2,5', 21, NULL, NULL, 'pending', 'pending', NULL, '2018-10-05 10:49:07', 4, NULL, NULL, '0'),
(13, 'Quo/2018/000018', '2018-10-05', '7,25,26', 20, NULL, NULL, 'pending', 'pending', NULL, '2018-10-05 12:46:25', 4, NULL, NULL, '0'),
(14, 'Quo/2018/000019', '2018-10-05', '7,25,26', 20, NULL, NULL, 'pending', 'pending', NULL, '2018-10-05 13:47:32', 4, NULL, NULL, '0'),
(15, 'Quo/2018/000020', '2018-10-05', '25,26,27', 21, NULL, NULL, 'pending', 'pending', NULL, '2018-10-05 13:49:25', 4, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_quotation_request_details`
--

CREATE TABLE `erp_material_quotation_request_details` (
  `id` int(11) NOT NULL,
  `quo_req_id` int(11) NOT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `require_qty` float DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `mat_req_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_quotation_request_details`
--

INSERT INTO `erp_material_quotation_request_details` (`id`, `quo_req_id`, `mat_id`, `unit_id`, `require_qty`, `dep_id`, `mat_req_id`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(1, 1, 3, NULL, 4, 20, NULL, '2018-09-08 09:59:28', 1, NULL, NULL),
(2, 1, 4, NULL, 5, 20, NULL, '2018-09-08 09:59:28', 1, NULL, NULL),
(3, 2, 19, NULL, 5, 20, NULL, '2018-09-08 15:12:17', 1, NULL, NULL),
(4, 2, 21, NULL, 2, 20, NULL, '2018-09-08 15:12:17', 1, NULL, NULL),
(5, 3, 24, NULL, 6, 20, NULL, '2018-09-10 14:10:00', 1, NULL, NULL),
(6, 3, 25, NULL, 6, 20, NULL, '2018-09-10 14:10:00', 1, NULL, NULL),
(7, 4, 21, NULL, 7, 20, NULL, '2018-09-10 14:51:54', 1, NULL, NULL),
(8, 5, 28, NULL, 8, 20, NULL, '2018-09-10 14:57:39', 1, NULL, NULL),
(9, 6, 16, NULL, 2, 21, NULL, '2018-09-12 15:17:13', 4, NULL, NULL),
(10, 6, 17, NULL, 3, 21, NULL, '2018-09-12 15:17:13', 4, NULL, NULL),
(11, 6, 19, NULL, 3, 21, NULL, '2018-09-12 15:17:13', 4, NULL, NULL),
(12, 6, 21, NULL, 3, 21, NULL, '2018-09-12 15:17:13', 4, NULL, NULL),
(13, 6, 18, NULL, 3, 21, NULL, '2018-09-12 15:17:13', 4, NULL, NULL),
(14, 6, 3, NULL, 2, 21, NULL, '2018-09-12 15:17:13', 4, NULL, NULL),
(15, 6, 4, NULL, 2, 21, NULL, '2018-09-12 15:17:13', 4, NULL, NULL),
(16, 7, 16, 3, 5, 21, NULL, '2018-09-12 16:57:44', 4, NULL, NULL),
(17, 7, 4, 6, 4, 21, NULL, '2018-09-12 16:57:44', 4, NULL, NULL),
(24, 10, 3, 2, 2, 21, 23, '2018-09-25 13:30:17', 4, NULL, NULL),
(25, 10, 4, 6, 4, 21, 23, '2018-09-25 13:30:17', 4, NULL, NULL),
(26, 10, 17, 2, 1, 21, 0, '2018-09-25 13:30:17', 4, NULL, NULL),
(27, 11, 17, 2, 3, 21, 12, '2018-09-26 16:29:53', 4, NULL, NULL),
(28, 11, 19, 2, 3, 21, 12, '2018-09-26 16:29:53', 4, NULL, NULL),
(29, 12, 19, 2, 3, 21, 12, '2018-10-05 10:49:07', 4, NULL, NULL),
(30, 12, 21, 2, 3, 21, 12, '2018-10-05 10:49:07', 4, NULL, NULL),
(31, 12, 18, 2, 3, 21, 12, '2018-10-05 10:49:07', 4, NULL, NULL),
(32, 13, 17, 2, 3, 20, 12, '2018-10-05 12:46:25', 4, NULL, NULL),
(33, 13, 21, 2, 3, 20, 12, '2018-10-05 12:46:25', 4, NULL, NULL),
(34, 13, 18, 2, 3, 20, 12, '2018-10-05 12:46:25', 4, NULL, NULL),
(35, 14, 3, 2, 2, 20, 12, '2018-10-05 13:47:32', 4, NULL, NULL),
(36, 15, 4, 3, 4, 21, 16, '2018-10-05 13:49:25', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_requisation_draft`
--

CREATE TABLE `erp_material_requisation_draft` (
  `req_draft_id` int(11) NOT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `require_qty` float DEFAULT NULL,
  `require_date` date DEFAULT NULL,
  `material_note` text,
  `unit_id` int(11) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_requisation_draft`
--

INSERT INTO `erp_material_requisation_draft` (`req_draft_id`, `mat_id`, `require_qty`, `require_date`, `material_note`, `unit_id`, `dep_id`, `is_deleted`) VALUES
(8, 16, NULL, NULL, NULL, 3, 20, '0'),
(15, 3, 1, NULL, NULL, NULL, 21, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_requisition`
--

CREATE TABLE `erp_material_requisition` (
  `req_id` int(11) NOT NULL,
  `req_number` varchar(255) DEFAULT NULL,
  `req_date` date DEFAULT NULL,
  `req_given_by` varchar(255) DEFAULT NULL,
  `material_type` varchar(255) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL COMMENT 'table erp_departments',
  `approval_assign_to` int(11) DEFAULT NULL,
  `approval_flag` enum('approved','not_approved','pending','completed') NOT NULL DEFAULT 'pending',
  `approval_date` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_requisition`
--

INSERT INTO `erp_material_requisition` (`req_id`, `req_number`, `req_date`, `req_given_by`, `material_type`, `dep_id`, `approval_assign_to`, `approval_flag`, `approval_date`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(12, 'Req/2018/00001', '2018-08-28', '1', NULL, 20, 4, 'approved', '2018-09-05 17:55:43', '2018-08-28 11:24:40', 1, '2018-09-05 15:20:51', 1, '0'),
(13, 'Req/2018/00002', '2018-08-28', '1', NULL, 20, 4, 'pending', '2018-09-05 17:46:08', '2018-08-28 11:40:40', 1, '2018-09-05 14:39:42', 1, '0'),
(14, 'Req/2018/00003', '2018-08-28', '1', NULL, 20, 4, 'pending', '2018-09-03 10:03:49', '2018-08-28 12:16:45', 1, '2018-09-05 15:53:24', 1, '0'),
(15, 'Req/2018/00004', '2018-08-28', '4', NULL, 21, 4, 'approved', '2018-09-15 10:28:27', '2018-08-28 16:16:27', 1, '2018-09-05 15:45:52', 4, '0'),
(16, 'Req/2018/00005', '2018-08-28', '4', NULL, 21, 4, 'approved', '2018-09-05 15:46:43', '2018-08-28 16:28:36', 1, '2018-09-05 15:46:31', 4, '0'),
(17, 'Req/2018/00006', '2018-08-29', '1', NULL, 20, 4, 'pending', NULL, '2018-08-29 10:45:33', 1, '2018-09-03 10:33:16', 1, '0'),
(18, 'Req/2018/00007', '2018-08-29', '1', NULL, 20, 4, 'pending', NULL, '2018-08-29 11:03:22', 1, '2018-09-03 10:33:37', 1, '0'),
(19, 'Req/2018/00008', '2018-09-05', '1', NULL, 20, 4, 'pending', NULL, '2018-09-05 14:25:22', 1, '2018-09-05 15:01:05', 1, '0'),
(20, 'Req/2018/00008', '2018-09-05', '1', NULL, 20, 4, 'pending', NULL, '2018-09-05 14:25:26', 1, '2018-09-05 15:42:17', 1, '0'),
(21, 'Req/2018/00009', '2018-09-05', '1', NULL, 20, 4, 'pending', NULL, '2018-09-05 14:27:28', 1, '2018-09-05 15:00:03', 1, '0'),
(22, 'Req/2018/000010', '2018-09-05', '1', NULL, 20, 4, 'approved', '2018-09-25 10:39:51', '2018-09-05 15:01:58', 1, '2018-09-25 10:38:59', 1, '0'),
(23, 'Req/2018/000011', '2018-09-20', '1', NULL, 20, 4, 'approved', '2018-09-25 10:40:46', '2018-09-20 09:57:48', 1, NULL, NULL, '0'),
(24, 'Req/2018/000012', '2018-09-25', '1', NULL, 20, 4, 'pending', NULL, '2018-09-25 11:13:37', 1, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_requisition_details`
--

CREATE TABLE `erp_material_requisition_details` (
  `id` int(11) NOT NULL,
  `req_id` int(11) NOT NULL COMMENT 'table erp_material_requisition',
  `mat_id` int(11) NOT NULL COMMENT 'table erp_material_master',
  `unit_id` int(11) DEFAULT NULL COMMENT 'table erp_unit_master',
  `dep_id` int(11) DEFAULT NULL COMMENT 'table erp_departments',
  `require_qty` float DEFAULT NULL,
  `require_users` varchar(255) DEFAULT NULL COMMENT 'users_management database  user_id',
  `stock_qty` float DEFAULT NULL,
  `po_qty` float DEFAULT NULL,
  `require_date` date DEFAULT NULL,
  `material_note` text,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_requisition_details`
--

INSERT INTO `erp_material_requisition_details` (`id`, `req_id`, `mat_id`, `unit_id`, `dep_id`, `require_qty`, `require_users`, `stock_qty`, `po_qty`, `require_date`, `material_note`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(71, 17, 47, 3, 20, 5, NULL, NULL, NULL, '2018-08-31', NULL, '2018-09-03 10:33:16', 1, NULL, NULL, '0'),
(89, 13, 3, 4, 20, 3, '1,4', NULL, NULL, '2018-08-31', 'ddsad1222', '2018-09-05 14:39:42', 1, NULL, NULL, '0'),
(91, 21, 4, 2, 20, 3, '4', NULL, NULL, '2018-09-07', NULL, '2018-09-05 15:00:03', 1, NULL, NULL, '0'),
(93, 19, 3, 2, 20, 3, '', NULL, NULL, '2018-09-07', NULL, '2018-09-05 15:01:05', 1, NULL, NULL, '0'),
(103, 12, 17, 2, 20, 3, '1,4', NULL, NULL, '2018-09-01', NULL, '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(104, 12, 19, 2, 20, 3, '', NULL, NULL, '2018-08-31', NULL, '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(105, 12, 21, 2, 20, 3, '', NULL, NULL, '2018-09-01', NULL, '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(106, 12, 18, 2, 20, 3, '', NULL, NULL, '2018-08-31', NULL, '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(107, 12, 3, 2, 20, 2, '', NULL, NULL, '2018-08-30', NULL, '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(108, 12, 4, 22, 20, 2, '', NULL, NULL, '2018-08-31', NULL, '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(109, 20, 3, 2, 20, 3, '9', NULL, NULL, '2018-09-07', NULL, '2018-09-05 15:42:17', 1, NULL, NULL, '0'),
(111, 15, 4, 2, 21, 5, '121', NULL, NULL, '2018-09-03', '133 111', '2018-09-05 15:45:52', 4, NULL, NULL, '0'),
(113, 16, 4, 3, 21, 4, '121', NULL, NULL, '2018-08-31', NULL, '2018-09-05 15:46:31', 4, NULL, NULL, '0'),
(115, 14, 18, 2, 20, 3, '', NULL, NULL, '2018-09-01', NULL, '2018-09-05 15:53:24', 1, NULL, NULL, '0'),
(116, 14, 3, 2, 20, 3, '', NULL, NULL, '2018-09-03', NULL, '2018-09-05 15:53:24', 1, NULL, NULL, '0'),
(120, 23, 3, 2, 20, 2, '', NULL, NULL, '2018-09-29', NULL, '2018-09-20 09:57:48', 1, NULL, NULL, '0'),
(121, 23, 4, 6, 20, 4, '', NULL, NULL, '2018-09-20', NULL, '2018-09-20 09:57:48', 1, NULL, NULL, '0'),
(123, 22, 4, 2, 20, 3, '1,4', NULL, NULL, '2018-09-07', NULL, '2018-09-25 10:38:59', 1, NULL, NULL, '0'),
(124, 24, 17, 2, 20, 4, '', NULL, NULL, '2018-09-27', NULL, '2018-09-25 11:13:37', 1, NULL, NULL, '0'),
(125, 24, 19, 2, 20, 2, '', NULL, NULL, '2018-09-29', NULL, '2018-09-25 11:13:37', 1, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_menu`
--

CREATE TABLE `erp_menu` (
  `menu_id` int(11) NOT NULL,
  `parent_menu_id` int(11) DEFAULT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_description` varchar(255) DEFAULT NULL,
  `menu_links` text,
  `menu_icon` varchar(255) DEFAULT NULL,
  `sub_menu` enum('0','1') DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0',
  `user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_menu`
--

INSERT INTO `erp_menu` (`menu_id`, `parent_menu_id`, `menu_name`, `menu_description`, `menu_links`, `menu_icon`, `sub_menu`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`, `user_id`) VALUES
(1, NULL, 'Purchase', 'Purchase', '', 'fa fa-shopping-cart', '1', NULL, NULL, NULL, NULL, '0', '1,4'),
(2, NULL, 'Stores', 'Store', '', 'fa fa-book', '1', NULL, NULL, '2018-09-05 18:11:58', 1, '0', '1,4,5'),
(3, 1, 'Master', 'purchase-master', NULL, 'fa fa-dot-circle-o', '1', NULL, NULL, NULL, NULL, '0', '1,4'),
(6, 2, 'Input', 'Store-Input', '', 'fa fa-dot-circle-o', '1', NULL, NULL, '2018-09-05 18:13:01', 1, '0', '1,4,5'),
(7, 2, 'Output', 'Store-output', '', 'fa fa-dot-circle-o', '0', NULL, NULL, '2018-09-04 11:15:03', 1, '0', '1'),
(8, 3, 'Unit', 'Purchase-master-unit', 'purchase/unit', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 11:53:08', 1, '0', '1,4'),
(9, 3, 'Category', 'Purchase-master-category', 'purchase/category', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 10:35:46', 1, '0', '1,4'),
(10, 3, 'Material', 'purchase-master-material', 'purchase/material', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 10:36:00', 1, '0', '1,4'),
(11, 3, 'Vendor', 'purchase-master-supplier', 'purchase/supplier', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 10:36:11', 1, '0', '1,4'),
(12, NULL, 'Settings', 'Settings', 'settings/index', 'fa fa-gear', '0', NULL, NULL, NULL, NULL, '0', '1'),
(13, NULL, 'Departments', 'Departments', 'department/index', 'fa fa-building', '0', '2018-08-20 00:00:00', 1, '2018-09-04 10:21:11', 1, '0', '1'),
(14, 6, 'Inward', 'Store-Input-Inward', '', 'fa fa-circle-o', '0', '2018-08-23 00:00:00', 1, '2018-09-04 11:16:23', 1, '0', '1'),
(15, 6, 'Material Requisition', 'Store-Input-Requisation', 'store/material_requisation', 'fa fa-circle-o', '0', '2018-08-23 00:00:00', 1, '2018-09-05 18:12:19', 1, '0', '1,4,5'),
(23, 1, 'Quotations (Materials)', 'Quotations (Materials)', 'purchase/quotations', 'fa fa-dot-circle-o', '0', '2018-09-28 17:40:26', 1, '2018-09-28 17:41:20', 1, '0', '1,4'),
(24, 1, 'Purchase Order', 'Purchase Order', 'purchase/purchase_order', 'fa fa-dot-circle-o', '1', '2018-09-28 17:42:06', 1, '2018-10-03 17:17:12', 1, '0', '1,4'),
(25, 24, 'Prepare PO (Quotation)', 'Prepare PO (Quotation)', 'purchase/purchase_order_quotation', 'fa fa-circle-o', '0', '2018-09-28 18:14:44', 1, '2018-09-29 09:20:37', 1, '0', '1,4'),
(26, 24, 'Prepare PO (Requisition)', '', 'purchase/purchase_order_requisition', 'fa fa-circle-o', '0', '2018-09-28 18:15:46', 1, '2018-09-29 09:21:41', 1, '0', '1,4');

-- --------------------------------------------------------

--
-- Table structure for table `erp_payment_terms`
--

CREATE TABLE `erp_payment_terms` (
  `payment_terms` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_payment_terms`
--

INSERT INTO `erp_payment_terms` (`payment_terms`) VALUES
('50% Advance & 50% after completion work'),
('100% Advance');

-- --------------------------------------------------------

--
-- Table structure for table `erp_permission_keys`
--

CREATE TABLE `erp_permission_keys` (
  `id` int(11) NOT NULL,
  `permission_keys` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_permission_keys`
--

INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES
(1, 'units-add_new_unit'),
(2, 'units-export_unit'),
(3, 'units-edit_unit'),
(4, 'units-delete_unit'),
(5, 'category-add_new_category'),
(6, 'category-edit_category'),
(7, 'category-delete_category'),
(9, 'material-add_new_material'),
(10, 'material-delete_material'),
(11, 'material-edit_material'),
(12, 'material-export_material'),
(13, 'vendor-add_new_vendor'),
(14, 'vendor-export_details'),
(15, 'vendor-edit_vendor'),
(16, 'vendor-delete_vendor'),
(17, 'vendor-quotation_tab'),
(18, 'vendor-purchase_order_tab'),
(19, 'vendor-material_tab'),
(20, 'vendor-payments_tab'),
(21, 'material_requisition-add_new'),
(22, 'material_requisition-pending_requisition'),
(23, 'material_requisition-approved_requisition'),
(24, 'material_requisition-completed_requisition'),
(25, 'material_requisition-view_edit'),
(26, 'material_requisition-view_materials'),
(27, 'material_requisition-material_notes_view_edit'),
(29, 'dashboard-requisition_count'),
(30, 'dashboard-quotation_count'),
(31, 'dashboard-vendor_count'),
(32, 'dashboard-po_count'),
(34, 'quotation-purchase_approval_status'),
(35, 'quotation-accounts_approval_status');

-- --------------------------------------------------------

--
-- Table structure for table `erp_purchase_order`
--

CREATE TABLE `erp_purchase_order` (
  `po_id` int(11) NOT NULL,
  `po_type` varchar(255) NOT NULL,
  `po_number` varchar(255) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `req_id` int(11) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `delievery_schedule` varchar(255) DEFAULT NULL,
  `delievery_schedule_days` int(11) DEFAULT NULL,
  `transport` varchar(255) DEFAULT NULL,
  `freight_charges` varchar(255) DEFAULT NULL,
  `payment_terms` varchar(255) DEFAULT NULL,
  `test_certificate` varchar(255) DEFAULT NULL,
  `custom_duty` varchar(255) DEFAULT NULL,
  `approval_flag` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `approval_by` int(11) DEFAULT NULL,
  `notes` text,
  `remarks` text,
  `currency` enum('RS','USD','EURO','YEN','GBP','POUND','DOLLER') DEFAULT 'RS',
  `total_amt` float DEFAULT NULL,
  `total_cgst` float DEFAULT NULL,
  `total_sgst` float DEFAULT NULL,
  `total_igst` float DEFAULT NULL,
  `freight_amt` float DEFAULT NULL,
  `other_amt` float DEFAULT NULL,
  `total_bill_amt` float DEFAULT NULL,
  `rounded_amt` float DEFAULT NULL,
  `po_form` varchar(255) DEFAULT NULL,
  `status` enum('non_completed','completed') NOT NULL DEFAULT 'non_completed',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_purchase_order`
--

INSERT INTO `erp_purchase_order` (`po_id`, `po_type`, `po_number`, `po_date`, `supplier_id`, `quotation_id`, `req_id`, `dep_id`, `delievery_schedule`, `delievery_schedule_days`, `transport`, `freight_charges`, `payment_terms`, `test_certificate`, `custom_duty`, `approval_flag`, `approval_by`, `notes`, `remarks`, `currency`, `total_amt`, `total_cgst`, `total_sgst`, `total_igst`, `freight_amt`, `other_amt`, `total_bill_amt`, `rounded_amt`, `po_form`, `status`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 'material_po', 'DCGL/2018/7', '2018-10-02', 2, NULL, 22, 20, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'Extra as applicable', 'approved', 4, '', '', 'RS', 6, 0.72, 0.72, 0.72, 0, 0, 8.16, 0, 'requisition_form', 'non_completed', '2018-10-02 18:23:48', 4, '2018-10-03 16:41:18', 4, '0'),
(2, 'material_po', 'DCGL/2018/8', '2018-10-03', 10, NULL, 15, 21, 'IMMIDIATE', 2, 'By Courier DDP Mode', 'NIL', '100% Advance', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'Extra as applicable', 'pending', 4, 'test note126', 'test remark123', 'RS', 25, 0, 0, 0, 0, 0, 25, 0, 'requisition_form', 'non_completed', '2018-10-03 09:22:05', 4, '2018-10-03 15:47:24', 4, '0'),
(3, 'material_po', 'DCGL/2018/9', '2018-10-03', 11, NULL, 23, 20, '01-01-2018 to 31-12-2018', 1, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'Extra as applicable', 'approved', 4, '', '', 'RS', 28, 0, 0, 0, 0, 0, 28, 0, 'requisition_form', 'non_completed', '2018-10-03 09:24:19', 4, '2018-10-03 16:00:40', 4, '0'),
(6, 'material_po', 'DCGL/2018/11', '2018-10-04', 2, 3, NULL, 20, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, 'test11', 'test123', 'RS', 80, 0, 0, 0, 0, 0, 80, 0, 'quotation_form', 'non_completed', '2018-10-04 12:09:27', 4, '2018-10-04 15:25:50', 4, '0'),
(7, 'material_po', 'DCGL/2018/13', '2018-10-04', 3, 2, NULL, 20, 'IMMIDIATE', 2, 'As Require', 'Extra as applicable', '100% Advance', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 4, '', '', 'RS', 500, 0, 0, 0, 0, 0, 500, 0, 'quotation_form', 'non_completed', '2018-10-04 14:14:17', 4, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_purchase_order_details`
--

CREATE TABLE `erp_purchase_order_details` (
  `id` int(11) NOT NULL,
  `po_id` int(11) DEFAULT NULL,
  `req_id` int(11) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `qty` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `cgst_per` float DEFAULT NULL,
  `cgst_amt` float DEFAULT NULL,
  `sgst_per` float DEFAULT NULL,
  `sgst_amt` float DEFAULT NULL,
  `igst_per` float DEFAULT NULL,
  `igst_amt` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `discount_per` float DEFAULT NULL,
  `mat_amount` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_purchase_order_details`
--

INSERT INTO `erp_purchase_order_details` (`id`, `po_id`, `req_id`, `quotation_id`, `mat_id`, `dep_id`, `unit_id`, `qty`, `rate`, `expire_date`, `cgst_per`, `cgst_amt`, `sgst_per`, `sgst_amt`, `igst_per`, `igst_amt`, `discount`, `discount_per`, `mat_amount`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 1, 22, NULL, 4, 20, 2, 3, 4, '2018-10-02 00:00:00', 12, 0.72, 12, 0.72, 12, 0.72, 0, 50, 6, '2018-10-02 00:00:00', 4, '2018-10-03', 4, '0'),
(2, 2, 15, NULL, 4, 21, 2, 5, 10, '2018-10-03 00:00:00', 0, 0, 0, 0, 0, 0, 0, 50, 25, '2018-10-03 00:00:00', 4, '2018-10-03', 4, '0'),
(3, 3, 23, NULL, 3, 20, 2, 4, 3, '2018-10-03 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 12, '2018-10-03 00:00:00', 4, '2018-10-03', 4, '0'),
(4, 3, 23, NULL, 4, 20, 2, 4, 4, '2018-10-03 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 16, '2018-10-03 00:00:00', 4, '2018-10-03', 4, '0'),
(9, 6, NULL, 3, 19, 20, 2, 5, 20, '2018-10-04 00:00:00', 0, 0, 0, 0, 0, 0, 0, 50, 50, '2018-10-04 00:00:00', 4, '2018-10-04', 4, '0'),
(10, 6, NULL, 3, 21, 20, 2, 2, 30, '2018-10-04 00:00:00', 0, 0, 0, 0, 0, 0, 0, 50, 30, '2018-10-04 00:00:00', 4, '2018-10-04', 4, '0'),
(11, 7, NULL, 2, 3, 20, 2, 4, 50, '2018-10-04 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 200, '2018-10-04 00:00:00', 4, NULL, NULL, '0'),
(12, 7, NULL, 2, 4, 20, 2, 5, 60, '2018-10-04 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 300, '2018-10-04 00:00:00', 4, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_purchase_order_details_draft`
--

CREATE TABLE `erp_purchase_order_details_draft` (
  `po_draft_id` int(11) NOT NULL,
  `req_id` int(11) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `qty` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `cgst_per` float DEFAULT NULL,
  `cgst_amt` float DEFAULT NULL,
  `sgst_per` float DEFAULT NULL,
  `sgst_amt` float DEFAULT NULL,
  `igst_per` float DEFAULT NULL,
  `igst_amt` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `discount_per` float DEFAULT NULL,
  `mat_amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_purchase_order_details_draft`
--

INSERT INTO `erp_purchase_order_details_draft` (`po_draft_id`, `req_id`, `quotation_id`, `mat_id`, `dep_id`, `unit_id`, `qty`, `rate`, `expire_date`, `cgst_per`, `cgst_amt`, `sgst_per`, `sgst_amt`, `igst_per`, `igst_amt`, `discount`, `discount_per`, `mat_amount`) VALUES
(2, 22, NULL, 4, 20, 2, 3, 0, '2018-10-03 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `erp_sub_categories`
--

CREATE TABLE `erp_sub_categories` (
  `sub_cat_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL COMMENT 'table erp_categories',
  `cat_code` varchar(255) DEFAULT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_for` enum('general_po','material_po') DEFAULT 'general_po',
  `cat_stockable` enum('consumable','non_consumable') DEFAULT 'consumable',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_sub_categories`
--

INSERT INTO `erp_sub_categories` (`sub_cat_id`, `cat_id`, `cat_code`, `cat_name`, `cat_for`, `cat_stockable`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(-1, -1, 'Default Sub Categories', 'Default Sub Categories', 'general_po', 'consumable', '2018-08-17 00:00:00', NULL, '2018-08-17 00:00:00', NULL, '0'),
(8, 7, '1', 'Aceesories', 'material_po', 'consumable', '2018-08-11 07:19:40', 1, '0000-00-00 00:00:00', NULL, '0'),
(9, 7, '2', 'NA', 'material_po', 'consumable', '2018-08-11 07:19:40', 1, '0000-00-00 00:00:00', NULL, '0'),
(10, 7, '3', 'Instrument Main Body', 'material_po', 'consumable', '2018-08-11 07:19:40', 1, '0000-00-00 00:00:00', NULL, '0'),
(11, 8, '1', 'Gowning Aids', 'material_po', 'consumable', '2018-08-11 07:21:22', 1, '2018-08-18 12:51:13', 1, '1'),
(12, 8, '2', 'Cleaning Aids', 'material_po', 'consumable', '2018-08-11 07:21:22', 1, '2018-08-18 12:51:13', 1, '1'),
(13, 8, '3', 'BMW Aids', 'material_po', 'consumable', '2018-08-11 07:21:22', 1, '2018-08-18 12:51:13', 1, '1'),
(14, 9, '1', 'CALLIBRATIONS', 'general_po', 'non_consumable', '2018-08-11 07:25:35', 1, '0000-00-00 00:00:00', NULL, '0'),
(15, 9, '2', 'PREVENTIVE MAINTENANCE', 'general_po', 'non_consumable', '2018-08-11 07:25:35', 1, '0000-00-00 00:00:00', NULL, '0'),
(16, 9, '3', 'SERVICES', 'general_po', 'non_consumable', '2018-08-11 07:25:35', 1, '0000-00-00 00:00:00', NULL, '0'),
(17, 9, '4', 'INSTALLATION', 'general_po', 'non_consumable', '2018-08-11 07:25:35', 1, '0000-00-00 00:00:00', NULL, '0'),
(62, 12, '12', 'test name', 'material_po', 'consumable', '2018-08-11 11:34:02', 1, '2018-08-30 12:43:00', 1, '1'),
(63, 4, '455', 'test232', '', '', '2018-08-14 10:56:30', 1, '2018-08-20 03:52:15', 1, '1'),
(64, 4, '9966', '54545', '', '', '2018-08-14 10:56:30', 1, '2018-08-20 03:52:15', 1, '1'),
(66, 7, '545', 'gfgfgffg', '', '', '2018-08-14 11:05:09', 1, '0000-00-00 00:00:00', NULL, '0'),
(67, 5, '4343', 'tttt', '', '', '2018-08-14 11:06:34', 1, '0000-00-00 00:00:00', NULL, '0'),
(69, 3, '434', 'fdffdf445', 'general_po', 'consumable', '2018-08-14 11:09:53', 1, '0000-00-00 00:00:00', NULL, '0'),
(70, 4, '433', 'cccccc', 'material_po', 'consumable', '2018-08-14 11:12:34', 1, '2018-08-20 03:52:15', 1, '1'),
(76, 11, '434', 'tretret', 'material_po', 'consumable', '2018-08-14 11:36:11', 1, '2018-08-30 12:42:54', 1, '1'),
(77, 11, '343', 'ffdsfdf', 'material_po', 'consumable', '2018-08-14 11:36:26', 1, '2018-08-30 12:42:54', 1, '1'),
(122, 5, '212', 'FRERRR', 'material_po', 'consumable', '2018-08-22 10:32:19', 1, '0000-00-00 00:00:00', NULL, '0'),
(123, 1, '1', 'GIFDSF', 'general_po', 'consumable', '2018-08-22 11:47:49', 1, '2018-08-30 12:43:11', 1, '1'),
(124, 1, '21', 'FDFDSFDS', 'general_po', 'consumable', '2018-08-22 12:12:31', 1, '2018-08-30 12:43:11', 1, '1'),
(125, 1, '343', 'TTTT', 'general_po', 'consumable', '2018-08-22 12:12:46', 1, '2018-08-30 12:43:11', 1, '1'),
(128, 10, '43', 'FSDFFDF', 'material_po', 'consumable', '2018-08-30 01:47:40', 1, '2018-08-31 11:17:45', 1, '1'),
(129, 10, '43434', 'YYYY', 'material_po', 'consumable', '2018-08-30 01:47:40', 1, '2018-08-31 11:17:45', 1, '1'),
(130, 10, '444', 'JJJJJ', 'material_po', 'consumable', '2018-08-30 01:47:40', 1, '2018-08-31 11:17:45', 1, '1'),
(131, 10, '4333', 'RRRR', 'material_po', 'consumable', '2018-08-30 01:47:40', 1, '2018-08-31 11:17:45', 1, '1'),
(132, 10, '4334', 'FFFFUUUUUUUU', 'material_po', 'consumable', '2018-08-30 01:47:40', 1, '2018-08-31 11:17:45', 1, '1'),
(136, 2, 'test12', 'TEST123', 'material_po', 'non_consumable', '2018-09-18 16:10:32', 1, '0000-00-00 00:00:00', NULL, '0'),
(137, 2, '23', 'YYYYYYY', 'material_po', 'non_consumable', '2018-09-18 16:10:32', 1, '0000-00-00 00:00:00', NULL, '0'),
(138, 2, 'testcat11', 'ERERER', 'material_po', 'non_consumable', '2018-09-18 16:10:32', 1, '0000-00-00 00:00:00', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_supplier`
--

CREATE TABLE `erp_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supp_firm_name` varchar(255) DEFAULT NULL,
  `supp_contact_person` varchar(255) DEFAULT NULL,
  `supp_address` text,
  `supp_city` varchar(255) DEFAULT NULL,
  `supp_pin` int(11) DEFAULT NULL,
  `supp_contact` varchar(255) DEFAULT NULL,
  `supp_mobile` varchar(255) DEFAULT NULL,
  `supp_fax` varchar(255) DEFAULT NULL,
  `supp_email` varchar(255) DEFAULT NULL,
  `supp_state` varchar(255) DEFAULT NULL,
  `supp_country` varchar(255) DEFAULT NULL,
  `supp_contact_designation` varchar(255) DEFAULT NULL,
  `supp_phone1` varchar(255) DEFAULT NULL,
  `supp_phone2` varchar(255) DEFAULT NULL,
  `supp_phone3` varchar(255) DEFAULT NULL,
  `supp_mobile2` varchar(255) DEFAULT NULL,
  `supp_website` varchar(255) DEFAULT NULL,
  `supp_description` text,
  `dep_id` varchar(255) DEFAULT NULL COMMENT 'assign department to vendor',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_supplier`
--

INSERT INTO `erp_supplier` (`supplier_id`, `supp_firm_name`, `supp_contact_person`, `supp_address`, `supp_city`, `supp_pin`, `supp_contact`, `supp_mobile`, `supp_fax`, `supp_email`, `supp_state`, `supp_country`, `supp_contact_designation`, `supp_phone1`, `supp_phone2`, `supp_phone3`, `supp_mobile2`, `supp_website`, `supp_description`, `dep_id`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 'Shripad Agencies', 'Shripad Agencies', 'W-104 (A) Additional Industrial Area M.I.D.C, Ambad, \r\nNashik - 422 010', 'Nashik', 422, NULL, '9823916718', '0', 'shripad@gmail.com', 'MAHARASHATRA', 'INDIA', '', '253', '0', NULL, '', '', NULL, NULL, '2018-08-02 12:37:45', 1, '2018-08-03 08:28:31', 1, '0'),
(2, 'SAN INFOTEK', 'Archana', 'Sharanpur Link Rd, Ramdas Colony, Nashik, Maharashtra', 'Nashik', 422005, NULL, '1234567891', '', 'Infotek@sangroup.co.in', 'MAHARASHATRA', 'INDIA', '', '0253 2310991', '0253 2315991', NULL, '', '', NULL, NULL, '2018-08-03 03:51:38', 1, '2018-09-18 13:46:49', 1, '0'),
(3, 'PRATHMESH ENTRPRISES', 'PRATHMESH ENTRPRISES', 'Shop No:7, Indira Gandhi complex Near Mahatma Nagar Water Tank, Mahatma Nagar.', 'Nashik', 422101, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-03 04:18:26', 1, '2018-08-03 08:55:43', NULL, '0'),
(4, 'BOSS CORPORATION (EPOXY)', 'BOSS CORPORATION (EPOXY)', 'A-2 krishna Kamal Apt. Opp Shubam', '', 422101, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-03 04:19:48', 1, '2018-08-18 04:35:13', 1, '0'),
(5, 'RELIABLE ALUMINIUM', 'RELIABLE ALUMINIUM', 'Shop No: 09, H K Plaza, Kurdukar N', '', 0, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-03 04:21:04', 1, '2018-08-10 08:29:48', NULL, '0'),
(6, 'ALPS ENGINEERING', 'ALPS ENGINEERING', '1/1, DJ Park,Opp Holram Colony, Sa', '', 0, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-03 04:22:24', 1, '2018-09-18 14:47:46', 1, '0'),
(7, 'ALFA ENGINEERING', 'Mr. Shailesh Pande', '1/1, DJ Park,Opp Holram Colony, Sadhu Waswani Road, Nashik.', 'Nashik', 422002, NULL, '1234567891', '', 'alfaac@gmail.com', 'MAHARASHATRA', 'INDIA', 'Service Executive', '0253-2314403', '', NULL, '', '', 'fdsfds111', '19,22,20', '2018-08-03 04:23:56', 1, '2018-09-19 12:22:54', 1, '0'),
(9, 'M K PRECISION PVT LTD.', 'M K PRECISION PVT LTD.', 'plot no: A791/10. T.T.C Industrial', '', 0, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-03 04:26:10', 1, NULL, NULL, '0'),
(10, 'Anmol Sales Corporation', 'Mr. Jatin Rathi', 'Shop No.3, Sydney Towers,Behind Camel House,Near Kathe Galli Signal,Dwarka,Nasik', 'Nashik', 422011, NULL, '9823069120', '123456782', 'sales@anmolsales.com', 'MAHARASHATRA', 'INDIA', 'PROPRIETOR', '02532505900', '9923596528', NULL, '9823019865', 'http://anmolsales.com', NULL, NULL, '2018-08-03 04:31:11', 1, '2018-08-03 08:06:55', 1, '0'),
(11, 'ALGOL SOFTWARE CONSULTACY', 'ALGOL SOFTWARE CONSULTACY', 'Plot No: 69/407, SIFCO, MIDC , Sat', '', 0, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-03 04:32:28', 1, '2018-09-18 14:47:35', 1, '0'),
(12, 'test', 'test', 'test', '', 0, NULL, '9874587458', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-18 04:09:56', 1, '2018-08-18 04:10:10', 1, '1'),
(13, 'test', 'test', 'test', '', 0, NULL, '9874565459', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-18 04:10:58', 1, '2018-08-18 04:12:15', 1, '1'),
(14, 'test', 'test', 'test', '', 0, NULL, '9874563214', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-18 04:12:55', 1, '2018-08-18 04:34:12', 1, '1'),
(15, 'test', 'test', 'test', '', 0, NULL, '98654532123', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-18 04:34:54', 1, '2018-08-18 11:36:14', 1, '1'),
(16, 'rewr', 'rewrewr', 'rewrew', '', 0, NULL, '9845654589', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-18 11:23:49', 1, '2018-08-18 11:36:03', 1, '1'),
(17, 'ewe', 'ewewewe', 'ewqewqewqewq', '', 0, NULL, '9845654564', '', 'testt@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-18 11:27:26', 1, '2018-08-18 11:36:03', 1, '1'),
(18, 'fdsf', 'fdsfdsf', 'fdsfdsf', '', 0, NULL, '9845632125', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-18 11:50:14', 1, '2018-08-18 11:50:47', 1, '1'),
(19, 'fdsfdsf', 'fdsfdsf', 'fdf f fdsf fdsfdsf fsdf fd', '', 0, NULL, '9865453215', '', 'rrrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-08-22 12:34:11', 1, '2018-09-05 17:45:15', 1, '1'),
(20, 'vendor 007', 'vendor 007', 'vendor 007', '', 0, NULL, '9513541232', '', 'v007@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '2018-09-14 11:48:21', 4, '2018-10-05 14:09:33', 1, '1'),
(21, 'test new vendor', 'vendor one', 'vendor one', '', 0, NULL, '9856321245', '', 'rrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'fdfdf', '15,18', '2018-09-19 12:31:59', 1, '2018-10-05 14:08:41', 1, '1'),
(22, 'test vendor', 'vendor 2', 'vendor 2', '', 0, NULL, '9845654565', '', 'rrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'gfgf', '17,18', '2018-09-19 12:36:02', 1, '2018-10-05 14:08:50', 1, '1'),
(23, 'test vendor', 'vendor 2', 'vendor 2', '', 0, NULL, '9845654565', '', 'rrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'gfgf', '17,18', '2018-09-19 12:36:07', 1, '2018-10-05 14:09:17', 1, '1'),
(24, 'test vendor', 'vendor 2', 'vendor 2', '', 0, NULL, '9845654565', '', 'rrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'gfgf', '17,18', '2018-09-19 12:37:54', 1, '2018-10-05 14:09:27', 1, '1'),
(25, 'tesst vendor 22', 'tesst vendor 22', 'tesst vendor 22', '', 0, NULL, '9845654565', '', 'test121@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'dsfdsf', '21,20', '2018-10-05 09:29:46', 4, '2018-10-05 14:07:29', 1, '0'),
(26, 'tesrgdfg', 'tesrgdfg', 'tesrgdfg', '', 0, NULL, '9845654565', '', 'test@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'gdfgdfg', '21,20', '2018-10-05 09:38:52', 4, '2018-10-05 14:07:21', 1, '0'),
(27, 'ryty', 'yty', 'ytyt', '', 0, NULL, '9845654565', '', 'ttt@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'fdsfdsf', '21', '2018-10-05 10:15:08', 4, '2018-10-05 14:07:12', 1, '0'),
(28, 'fdf', 'dfds', 'fdsf', '', 0, NULL, '9845654565', '', 'tt123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'sadsad', '', '2018-10-05 10:29:55', 4, '2018-10-05 14:07:04', 1, '1'),
(29, 'dfdfds', 'fdsf', 'fdsf', '', 0, NULL, '9845654565', '', 'test@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'fdsff', '14', '2018-10-05 10:42:20', 4, '2018-10-05 14:06:58', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `erp_supplier_materials`
--

CREATE TABLE `erp_supplier_materials` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `sup_mat_code` varchar(255) DEFAULT NULL,
  `mat_rate` float DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `mat_discount` float DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `lead_time` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_supplier_materials`
--

INSERT INTO `erp_supplier_materials` (`id`, `supplier_id`, `mat_id`, `sup_mat_code`, `mat_rate`, `unit_id`, `mat_discount`, `credit_days`, `lead_time`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 7, 3, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:00:41', 1, '2018-08-23 09:26:41', 1, '1'),
(2, 7, 4, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:00:41', 1, '2018-08-22 17:59:10', 1, '1'),
(3, 7, 16, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:00:41', 1, '2018-08-23 09:27:02', 1, '1'),
(4, 7, 17, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:00:41', 1, '2018-08-23 09:26:57', 1, '1'),
(5, 7, 20, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:32:25', 1, '2018-08-22 14:31:21', 1, '1'),
(6, 7, 28, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:32:55', 1, '2018-08-22 14:55:12', 1, '1'),
(7, 7, 27, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:35:04', 1, '2018-08-22 14:53:22', 1, '1'),
(8, 7, 18, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:38:06', 1, '2018-08-23 09:26:46', 1, '1'),
(9, 7, 24, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:41:04', 1, '2018-08-22 14:56:05', 1, '1'),
(10, 7, 19, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:43:32', 1, '2018-08-22 14:27:39', 1, '1'),
(11, 7, 23, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:43:32', 1, '2018-08-22 14:31:49', 1, '1'),
(12, 11, 3, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-21 17:50:25', 1, '2018-08-22 14:11:34', 1, '1'),
(13, 7, 25, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 09:19:09', 1, '2018-08-22 14:45:02', 1, '1'),
(14, 7, 22, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 09:19:21', 1, '2018-08-22 14:31:38', 1, '1'),
(15, 7, 35, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 10:32:33', 1, '2018-08-22 15:00:02', 1, '1'),
(16, 7, 36, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 10:34:29', 1, '2018-08-22 15:00:14', 1, '1'),
(17, 7, 37, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 10:47:34', 1, '2018-08-22 15:00:20', 1, '1'),
(18, 19, 3, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 12:35:21', 1, NULL, NULL, '0'),
(19, 19, 4, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 12:35:21', 1, NULL, NULL, '0'),
(20, 19, 38, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 12:35:53', 1, NULL, NULL, '0'),
(21, 7, 39, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 15:04:16', 1, '2018-08-22 15:05:32', 1, '1'),
(22, 10, 3, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 15:09:00', 1, NULL, NULL, '0'),
(23, 10, 4, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 15:09:00', 1, NULL, NULL, '0'),
(24, 10, 16, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 15:09:24', 1, NULL, NULL, '0'),
(25, 7, 3, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 15:11:52', 1, '2018-08-23 09:26:41', 1, '1'),
(26, 7, 18, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 15:11:52', 1, '2018-08-23 09:26:46', 1, '1'),
(27, 7, 16, NULL, NULL, NULL, NULL, NULL, NULL, '2018-08-22 16:23:59', 1, '2018-08-23 09:27:02', 1, '1'),
(28, 7, 4, NULL, NULL, NULL, NULL, NULL, NULL, '2018-08-22 16:35:21', 1, '2018-08-22 17:59:10', 1, '1'),
(29, 7, 17, NULL, NULL, NULL, NULL, NULL, NULL, '2018-08-22 16:35:21', 1, '2018-08-23 09:26:57', 1, '1'),
(30, 7, 40, NULL, NULL, NULL, NULL, NULL, NULL, '2018-08-22 16:36:20', 1, '2018-08-23 09:26:51', 1, '1'),
(31, 7, 3, 'sup_4471269', 1200, 2, 11, 12, 13, '2018-08-23 09:31:03', 1, '2018-08-29 17:01:12', 1, '0'),
(32, 7, 16, 'sup_0215538791', 356, 9, 5, 16, 14, '2018-08-23 09:31:03', 1, '2018-08-29 17:01:12', 1, '0'),
(33, 7, 18, 'sup_3540C/3541C', 545, 19, 1, 11, 12, '2018-08-23 10:49:31', 1, '2018-08-29 17:01:12', 1, '0'),
(34, 7, 19, 'sup_0217006201', 4545, 3, 1, 11, 12, '2018-08-23 10:49:31', 1, '2018-08-29 17:01:12', 1, '0'),
(35, 7, 4, 'supp_S018', 0, 2, 0, 0, 0, '2018-08-23 11:00:57', 1, '2018-08-29 17:01:12', 1, '0'),
(36, 7, 17, 'supp_0215757401', 0, 4, 0, 0, 0, '2018-08-23 11:00:57', 1, '2018-08-29 17:01:12', 1, '0'),
(37, 7, 28, 'supp_10416-014', 0, 2, 0, 0, 0, '2018-08-23 11:39:38', 1, '2018-08-29 17:01:12', 1, '0'),
(38, 7, 41, NULL, NULL, NULL, NULL, NULL, NULL, '2018-08-24 16:04:56', 1, '2018-08-24 16:05:15', 1, '1'),
(39, 7, 42, NULL, NULL, NULL, NULL, NULL, NULL, '2018-08-29 10:27:34', 1, '2018-08-29 16:59:36', 1, '1'),
(40, 7, 46, NULL, NULL, NULL, NULL, NULL, NULL, '2018-08-29 10:38:20', 1, '2018-08-29 16:59:30', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `erp_supplier_quotation_bid`
--

CREATE TABLE `erp_supplier_quotation_bid` (
  `quotation_id` int(11) NOT NULL,
  `quo_req_id` int(11) DEFAULT NULL,
  `quotation_number` varchar(255) DEFAULT NULL,
  `bid_date` date DEFAULT NULL COMMENT 'bid received date',
  `supplier_id` int(11) NOT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `total_cgst` float DEFAULT NULL,
  `total_sgst` float DEFAULT NULL,
  `total_igst` float DEFAULT NULL,
  `other_amt` float DEFAULT NULL,
  `total_amt` float DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `approval_by` int(11) DEFAULT NULL,
  `status_account` varchar(255) DEFAULT NULL,
  `approval_by_account` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_supplier_quotation_bid`
--

INSERT INTO `erp_supplier_quotation_bid` (`quotation_id`, `quo_req_id`, `quotation_number`, `bid_date`, `supplier_id`, `credit_days`, `total_price`, `total_cgst`, `total_sgst`, `total_igst`, `other_amt`, `total_amt`, `status`, `approval_by`, `status_account`, `approval_by_account`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 1, 'Quotation/2018/1', '2018-09-20', 10, 45, 301, 0, 0, 0, 0, 301, '', NULL, '', NULL, '2018-09-08 00:00:00', 1, NULL, NULL, '0'),
(2, 1, 'Quotation/2018/2', '2018-09-08', 3, 60, 500, 0, 0, 0, 0, 500, '', 4, '', 1, '2018-09-08 00:00:00', 1, '2018-09-11 15:26:37', 1, '0'),
(3, 2, 'Quotation/2018/3', '2018-09-08', 2, 30, 160, 0, 0, 0, 0, 160, '', 4, '', 1, NULL, NULL, '2018-10-05 17:00:42', 4, '0'),
(4, 2, 'Quotation/2018/4', '2018-09-14', 9, 40, 190, 0, 0, 0, 0, 190, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_supplier_quotation_bid_details`
--

CREATE TABLE `erp_supplier_quotation_bid_details` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `quo_req_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `mat_id` int(11) NOT NULL,
  `quo_rate` float DEFAULT NULL,
  `quo_qty` float DEFAULT NULL,
  `quo_price` float DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `cgst_per` float DEFAULT NULL,
  `cgst_amt` float DEFAULT NULL,
  `sgst_per` float DEFAULT NULL,
  `sgst_amt` float DEFAULT NULL,
  `igst_per` float DEFAULT NULL,
  `igst_amt` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `discount_per` float DEFAULT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_supplier_quotation_bid_details`
--

INSERT INTO `erp_supplier_quotation_bid_details` (`id`, `quotation_id`, `quo_req_id`, `supplier_id`, `unit_id`, `mat_id`, `quo_rate`, `quo_qty`, `quo_price`, `expire_date`, `cgst_per`, `cgst_amt`, `sgst_per`, `sgst_amt`, `igst_per`, `igst_amt`, `discount`, `discount_per`, `created`, `created_by`, `is_deleted`) VALUES
(1, 1, 1, 10, 2, 3, 50, 4, 101, '2018-10-03', 0, 0, 0, 0, 0, 0, 0, 0, '2018-09-08 00:00:00', 1, '0'),
(2, 1, 1, 10, 2, 4, 40, 5, 200, '2018-10-18', 0, 0, 0, 0, 0, 0, 0, 0, '2018-09-08 00:00:00', 1, '0'),
(3, 2, 1, 3, 4, 3, 50, 4, 200, '2018-10-03', 0, 0, 0, 0, 0, 0, 0, 0, '2018-09-08 00:00:00', 1, '0'),
(4, 2, 1, 3, 2, 4, 60, 5, 300, '2018-10-03', 0, 0, 0, 0, 0, 0, 0, 0, '2018-09-08 00:00:00', 1, '0'),
(5, 3, 2, 2, 2, 19, 20, 5, 100, '2018-10-05', 0, 0, 0, 0, 0, 0, 0, 0, '2018-09-11 00:00:00', 1, '0'),
(6, 3, 2, 2, 2, 21, 30, 2, 60, '2018-10-05', 0, 0, 0, 0, 0, 0, 0, 0, '2018-09-11 00:00:00', NULL, '0'),
(7, 4, 2, 9, 2, 19, 30, 5, 150, '2018-10-06', 0, 0, 0, 0, 0, 0, 0, 0, '2018-09-11 00:00:00', NULL, '0'),
(8, 4, 2, 9, 6, 21, 20, 2, 40, '2018-10-06', 0, 0, 0, 0, 0, 0, 0, 0, '2018-09-11 00:00:00', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_transport`
--

CREATE TABLE `erp_transport` (
  `transport` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_transport`
--

INSERT INTO `erp_transport` (`transport`) VALUES
('As Require'),
('By Courier'),
('By Courier DDP Mode'),
(NULL);

-- --------------------------------------------------------

--
-- Table structure for table `erp_unit_master`
--

CREATE TABLE `erp_unit_master` (
  `unit_id` int(11) NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `unit_description` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_unit_master`
--

INSERT INTO `erp_unit_master` (`unit_id`, `unit`, `unit_description`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(2, 'No', 'Number', '2018-07-27 10:32:19', 1, '2018-08-02 10:00:53', 1, '0'),
(3, 'GM', 'GRAM', '2018-07-27 10:32:52', 1, '2018-09-25 12:16:40', 4, '0'),
(4, 'KG', 'KILOGRAM', '2018-07-27 10:33:35', 1, '2018-08-02 10:00:53', 1, '0'),
(5, 'LTR', 'LITRE', '2018-07-27 11:04:33', 1, '2018-08-30 12:14:44', 1, '1'),
(6, 'ML', 'MILL LITRE', '2018-07-27 11:05:17', 1, '2018-08-02 10:00:53', 1, '0'),
(7, 'MTR', 'METER', '2018-07-27 11:06:10', 1, '2018-08-30 12:07:35', 1, '0'),
(8, 'NOS', 'Number', '2018-07-27 11:06:47', 1, '2018-08-20 04:19:53', 1, '0'),
(9, 'PKT', 'PACKET', '2018-07-27 11:07:10', 1, '2018-08-30 12:14:55', 1, '1'),
(10, 'ROLL', 'ROLL', '2018-07-27 11:07:23', 1, '2018-08-30 12:15:03', 1, '1'),
(11, 'MM', 'MILL METER', '2018-07-27 11:07:50', 1, '2018-08-30 12:10:51', 1, '0'),
(12, 'SET', 'SET', '2018-07-27 11:08:08', 1, '2018-08-30 12:05:09', 1, '0'),
(13, 'Cylender', 'Cylender', '2018-07-27 11:10:20', 1, '2018-08-30 12:14:25', 1, '1'),
(14, 'SQMT', 'SQMT', '2018-07-27 11:11:06', 1, '2018-08-30 12:52:46', 1, '1'),
(15, 'FT', 'FEET', '2018-07-27 11:11:26', 1, '2018-08-30 12:14:31', 1, '1'),
(16, 'SQFT', 'SQUARE FOOT', '2018-07-27 11:12:24', 1, '2018-08-30 12:06:13', 1, '0'),
(17, 'BOX', 'BOX', '2018-07-27 11:13:45', 1, '2018-08-30 12:14:19', 1, '1'),
(18, 'DOZ', 'DOZEN', '2018-07-27 11:19:24', 1, '2018-08-30 11:46:30', 1, '1'),
(19, 'CUM', 'CUMMULATIVE', '2018-07-27 11:20:11', 1, '2018-08-30 11:44:53', 1, '1'),
(20, 'MONTH', 'MONTH', '2018-07-27 11:20:43', 1, '2018-08-02 10:00:53', 1, '0'),
(21, 'BOTTLE', 'BOTTLE', '2018-07-27 11:21:07', 1, '2018-08-18 11:05:53', 1, '1'),
(22, 'PACK', '', '2018-07-27 11:21:26', 1, '2018-08-02 10:00:53', 1, '0'),
(23, 'KIT', 'KIT', '2018-07-27 11:21:49', 1, '2018-08-30 12:11:55', 1, '1'),
(24, 'test', 'test123', '2018-07-27 01:02:59', 1, '2018-08-18 10:57:05', 1, '1'),
(25, 'ew', 'wew', '2018-07-27 01:09:40', 1, '2018-08-03 05:55:37', 1, '1'),
(26, 'ewewew', 'dsadsadsad', '2018-07-27 01:10:04', 1, '2018-08-03 05:55:48', 1, '1'),
(27, 'dee', 'dsad', '2018-07-28 06:51:58', 1, '2018-08-18 10:58:03', 1, '1'),
(28, 'dsa', 'dsadsa', '2018-07-28 06:53:29', 1, '2018-08-03 05:55:23', 1, '1'),
(29, 'dfd', 'fdsf', '2018-07-28 06:54:10', 1, '2018-08-18 10:58:10', 1, '1'),
(30, 'tret', 'tret', '2018-07-28 09:26:27', 1, '2018-08-18 10:40:15', 1, '1'),
(31, 'fdfdsf', 'PACKET1123reerere', '2018-07-28 09:45:17', 1, '2018-08-03 05:55:54', 1, '1'),
(32, 'fer', 'reewr', '2018-07-28 10:09:05', 1, '2018-08-18 10:57:43', 1, '1'),
(33, 'fdf', 'fdsfdfd', '2018-07-28 10:12:54', 1, '2018-08-03 05:55:43', 1, '1'),
(34, 'PKT12', 'Cylender', '2018-07-28 10:22:08', 1, '2018-08-30 12:02:28', 1, '1'),
(35, 'fdsf123', 'dfdsfrer', '2018-08-03 05:30:59', 1, '2018-08-03 05:55:58', 1, '1'),
(36, 'dsd', 'dsd', '2018-08-18 10:40:05', 1, '2018-08-18 10:57:55', 1, '1'),
(37, 'rer', 'rewr', '2018-08-18 10:43:20', 1, '2018-08-18 10:58:23', 1, '1'),
(38, 'trt', 'trt', '2018-08-18 10:51:39', 1, '2018-08-18 10:51:59', 1, '1'),
(39, 'fdfdsf', 'fdsfdsfds', '2018-08-22 10:51:37', 1, '2018-08-22 11:24:49', 1, '1'),
(40, 'fsdfdsf', 'fdsfdsfdsfdsfdsf', '2018-08-22 11:24:26', 1, '2018-08-22 11:24:53', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `role_id` tinyint(4) NOT NULL,
  `dep_id` int(11) NOT NULL,
  `permissions` text,
  `isDeleted` tinyint(4) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `email`, `password`, `name`, `mobile`, `role_id`, `dep_id`, `permissions`, `isDeleted`, `createdBy`, `created`, `updatedBy`, `updated`) VALUES
(1, 'rakesh29', 'rakeshahirrao29@datargene.com', '$2y$10$f4oSBk6hsqKfOSAOzW.Hk.Brl17LChn.5S1qVvCRx.FDW.TxZFK2q', 'Rakesh M. Ahirrao', '9845654565', 2, 20, '["all"]', 0, 1, '2018-08-30 18:36:45', 1, '2018-09-05 16:05:33'),
(4, 'nileshk', 'purchase@datarpgx.com', '$2y$10$jA8s9kreBiRtVgDRqOa4Se.aRU9LFLHLye9KuDh/YVUvVuqtDBpES', 'Nilesh Kakad', '9856545654', 4, 21, '["category-add_new_category", "category-edit_category", "dashboard-po_count", "dashboard-quotation_count", "dashboard-requisition_count", "dashboard-vendor_count", "material-add_new_material", "material-edit_material", "material-export_material", "material_requisition-add_new", "material_requisition-approved_requisition", "material_requisition-completed_requisition", "material_requisition-material_notes_view_edit", "material_requisition-pending_requisition", "material_requisition-view_edit", "material_requisition-view_materials", "quotation-purchase_approval_status", "units-add_new_unit", "units-edit_unit", "units-export_unit", "vendor-add_new_vendor", "vendor-edit_vendor", "vendor-export_details", "vendor-material_tab", "vendor-payments_tab", "vendor-purchase_order_tab", "vendor-quotation_tab"]', 0, 1, '2018-08-31 12:56:03', 1, '2018-10-05 16:59:22'),
(5, 'umeshw', 'umesh@datar.com', '$2y$10$1PJftok/tA9shp8i6lpkreVDzj0edt9e5Grpgd76gudYFM.wi/mi2', 'Umesh Wakalekar', '9845325845', 4, 20, NULL, 0, 1, '2018-09-05 18:07:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `login_id` varchar(64) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `user_type` varchar(50) DEFAULT NULL,
  `reset_password_now` enum('0','1') DEFAULT '0',
  `created` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_login_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `type` int(1) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` varchar(2500) NOT NULL,
  `update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `user_verification`
--

CREATE TABLE `user_verification` (
  `user_login_id` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `remote_ip` varchar(20) NOT NULL,
  `last_visited` datetime NOT NULL,
  `created` datetime NOT NULL,
  `hash` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_verification`
--

INSERT INTO `user_verification` (`user_login_id`, `token`, `remote_ip`, `last_visited`, `created`, `hash`) VALUES
(1, 'DwN4gt39H6R8zne2IcC1AqZfGVMkaQ', '::1', '2018-09-18 15:53:33', '2018-09-18 15:53:33', NULL),
(1, 'EL3NS8OpRMyBUsAeciok4QwdFxgGr7', '::1', '2018-09-18 15:53:33', '2018-09-18 15:53:33', NULL),
(1, 'sSMkgIOYoBw69pExfba1ZH53LqQ7U0', '::1', '2018-09-19 09:20:31', '2018-09-19 09:20:31', NULL),
(1, 'Blkh1wxg2XGaRFKEWuym4fqsOCot8D', '::1', '2018-09-19 09:20:31', '2018-09-19 09:20:31', NULL),
(1, 'cQVAz0TbnPoKm7YOEyqBep8UF34Lt5', '::1', '2018-09-19 10:04:12', '2018-09-19 10:04:12', NULL),
(1, 'p7RJYGi45Dq20uAzk9IKafC8bSsyox', '::1', '2018-09-19 10:04:12', '2018-09-19 10:04:12', NULL),
(4, 'rmHbTCvPliwqczuahd4ZByOogn7UMN', '::1', '2018-09-19 10:11:41', '2018-09-19 10:11:41', NULL),
(4, '3EjDGWF8QV29ZLzIPCpnRcsUAS0wXf', '::1', '2018-09-19 10:11:41', '2018-09-19 10:11:41', NULL),
(4, '8nczmRQVTkiIswSjDGe7q9ob43pdtN', '::1', '2018-09-19 18:04:01', '2018-09-19 18:04:01', NULL),
(4, '4PfJnWMxsrZgIoD6KSE8A7u5dmqc9Q', '::1', '2018-09-19 18:04:01', '2018-09-19 18:04:01', NULL),
(1, 'tol96D3yNTArZs5WC4BcFpKMzwVd1e', '::1', '2018-09-20 09:15:45', '2018-09-20 09:15:45', NULL),
(1, 'eiY7haob4rMmK5GL9ZdOU8TsQl3DEJ', '::1', '2018-09-20 09:15:45', '2018-09-20 09:15:45', NULL),
(4, 'Wry2ULJs4eNaIvt5jfFhdgx1l8qpic', '::1', '2018-09-20 10:03:00', '2018-09-20 10:03:00', NULL),
(4, 'hUoXwtiWpulIxMO01RfFBSmE3gzqJd', '::1', '2018-09-20 10:03:00', '2018-09-20 10:03:00', NULL),
(4, 'xjwqM7PHrgezy9pE4KcUFOBZfCLV8D', '::1', '2018-09-20 10:38:10', '2018-09-20 10:38:10', NULL),
(4, 'UpjDNJ9Bw7hekA62Il1ZgXbsLmPtoT', '::1', '2018-09-20 10:38:10', '2018-09-20 10:38:10', NULL),
(4, 'A410RXjLlI3PNCiF865KmwHxqOdUVQ', '::1', '2018-09-20 16:15:21', '2018-09-20 16:15:21', NULL),
(4, 'HQug2cCb0FZInR6YqVk8A5LWi9NEyS', '::1', '2018-09-20 16:15:21', '2018-09-20 16:15:21', NULL),
(1, 'W7Xz4G5CEUDBQta6Idm89OAKcgv1ij', '::1', '2018-09-20 17:25:17', '2018-09-20 17:25:17', NULL),
(1, 'dKUQ9nBWHbyoVS8Lv5RIxf3tYXwCOZ', '::1', '2018-09-20 17:25:17', '2018-09-20 17:25:17', NULL),
(4, 'PHuFbY2X7aEJ9j8cG6NdgBq0VoU1yC', '::1', '2018-09-20 17:37:57', '2018-09-20 17:37:57', NULL),
(4, 'x0Oyh7UrVNBkWXGoRfEpswI9nJlji4', '::1', '2018-09-20 17:37:57', '2018-09-20 17:37:57', NULL),
(1, 'KNoiAu1BSpvXHyTMm5lkY9z7d2tWQ3', '::1', '2018-09-22 09:11:06', '2018-09-22 09:11:06', NULL),
(1, 'GIC7qF4A3n5UHVrgkLXNQlJc2b0t8R', '::1', '2018-09-22 09:11:06', '2018-09-22 09:11:06', NULL),
(1, 'S7MH3In0UJb4NrKzu9CiBZLhko1sYf', '::1', '2018-09-22 09:48:25', '2018-09-22 09:48:25', NULL),
(1, 'e8NDQFCt7UKoabxS0iEI4dgqMVYTLc', '::1', '2018-09-22 09:48:25', '2018-09-22 09:48:25', NULL),
(1, 'g9VYfE3mZPKLewk4JBGQ0narFO581l', '::1', '2018-09-24 09:14:45', '2018-09-24 09:14:45', NULL),
(1, 'Hn9LvM47uJQaA6I0dZBtWeR3DC5bVz', '::1', '2018-09-24 09:14:45', '2018-09-24 09:14:45', NULL),
(1, 'a8e3YCGm4bSywzctQnixfOhAskXFT1', '::1', '2018-09-24 16:24:21', '2018-09-24 16:24:21', NULL),
(1, 'LJeAQBw0NKZIMfT9DaU3z5FP8hmsOR', '::1', '2018-09-24 16:24:21', '2018-09-24 16:24:21', NULL),
(1, 'DUh0A2H39EFMTPXczRvVrqbftuBgYO', '::1', '2018-09-25 09:14:01', '2018-09-25 09:14:01', NULL),
(1, '7WCDuY4G8FgpL6nsVE5PT1RIaZKNfe', '::1', '2018-09-25 09:14:01', '2018-09-25 09:14:01', NULL),
(4, 'k508g276jsYib1xytvADCRJE4XwH9V', '::1', '2018-09-25 10:33:20', '2018-09-25 10:33:20', NULL),
(4, 'VNLJZy3x6TR0UIhXdPFz7CSAnOWglK', '::1', '2018-09-25 10:33:20', '2018-09-25 10:33:20', NULL),
(1, 'dPko8bel1TWB2RLiwrDAfV6pJGSK3u', '::1', '2018-09-25 12:15:38', '2018-09-25 12:15:38', NULL),
(1, 'VSr5AHhoYjLyuRT1wbk6em3U8zPFns', '::1', '2018-09-25 12:15:38', '2018-09-25 12:15:38', NULL),
(4, 'O3lC4NyYW0RPBi7zSvjgudb8DmqJae', '::1', '2018-09-25 12:16:01', '2018-09-25 12:16:01', NULL),
(4, 'Z92SFTw0hXirH3sVDy47cdMtOoaJUk', '::1', '2018-09-25 12:16:01', '2018-09-25 12:16:01', NULL),
(4, '6WpRet3GkSDJidj1NsKObzEoQa8Vu5', '::1', '2018-09-25 12:22:32', '2018-09-25 12:22:32', NULL),
(4, 'JNanS6Tjzi0ZtABYdVf5Rs9HDlmrXy', '::1', '2018-09-25 12:22:32', '2018-09-25 12:22:32', NULL),
(4, 'dWJTSRFbAhBc29q87YgXMUQK4nHmy0', '::1', '2018-09-25 12:23:35', '2018-09-25 12:23:35', NULL),
(4, 'm4Yf8hQosFpZTLyArUntNG0VWa1Bib', '::1', '2018-09-25 12:23:35', '2018-09-25 12:23:35', NULL),
(1, 'j73pv4Fzf6cwr9lMOxdDGNRV1H8Q02', '::1', '2018-09-25 14:59:20', '2018-09-25 14:59:20', NULL),
(1, 'ZkaV1BES2Xhg9IrPvKcNCd3qsxJji0', '::1', '2018-09-25 14:59:21', '2018-09-25 14:59:21', NULL),
(4, 'oM5rkRxaiAI8E71bsldVKLfZSuTt9Y', '::1', '2018-09-25 17:33:38', '2018-09-25 17:33:38', NULL),
(4, '4RXLuNsWHx9q02fTZa7mdGY5n1tBgz', '::1', '2018-09-25 17:33:38', '2018-09-25 17:33:38', NULL),
(1, 'or35V4vd9SflNQnEFOuscGYMkBjh78', '::1', '2018-09-25 17:36:26', '2018-09-25 17:36:26', NULL),
(1, '83o6YpE7jqerlX1PkCBN4SfgGTVvKs', '::1', '2018-09-25 17:36:26', '2018-09-25 17:36:26', NULL),
(4, '9b5hz3xoI8WlUBKmq04prTw2SCdZfc', '::1', '2018-09-25 17:36:57', '2018-09-25 17:36:57', NULL),
(4, 'xWU5oqiu2OrbAGISlH7pc1ZPJnXhvz', '::1', '2018-09-25 17:36:57', '2018-09-25 17:36:57', NULL),
(4, '5z63jxD1TayvicuqS8lbEQJeV7WLKR', '::1', '2018-09-25 17:53:37', '2018-09-25 17:53:37', NULL),
(4, 'jSkPpieHr6B8EmaytMNLUcnR0TZ14W', '::1', '2018-09-25 17:53:37', '2018-09-25 17:53:37', NULL),
(4, 'kIBAYGuvdX2MjaETZlmcFs9gzL56tK', '::1', '2018-09-25 18:00:25', '2018-09-25 18:00:25', NULL),
(4, 'f8bltzo0drYiwpkBuySOv1ANxHLET5', '::1', '2018-09-25 18:00:25', '2018-09-25 18:00:25', NULL),
(4, 'PxLFKngQwkiy0p9RAodjb2G5HTYhvV', '::1', '2018-09-26 09:13:39', '2018-09-26 09:13:39', NULL),
(4, 'EfLd6Y41cZW38HpgyTxwUCurD9Ka7v', '::1', '2018-09-26 09:13:39', '2018-09-26 09:13:39', NULL),
(1, 'kpHMwRYWA1i4O5yuG7SoTXLdm6qvtJ', '::1', '2018-09-26 09:14:22', '2018-09-26 09:14:22', NULL),
(1, 'UrVpESXDQA5nm3oRqhM8YIkKWyjgez', '::1', '2018-09-26 09:14:22', '2018-09-26 09:14:22', NULL),
(1, '50TjGCS2AZb8poWE7rvsfuJnMBcgei', '::1', '2018-09-26 14:35:34', '2018-09-26 14:35:34', NULL),
(1, 'XNc43lf2ZI7C0WoiA819phuOqmy5Bk', '::1', '2018-09-26 14:35:34', '2018-09-26 14:35:34', NULL),
(4, 'Nsz9BHgbSLQD7tYmpuPAOnfTwdv4F6', '::1', '2018-09-26 14:36:05', '2018-09-26 14:36:05', NULL),
(4, 'oKOya1rPWztLFiEqHd87TGBZhIvMQg', '::1', '2018-09-26 14:36:05', '2018-09-26 14:36:05', NULL),
(4, 'PbUXGT6goRVhLmvrOKny3NxDsWw427', '::1', '2018-09-26 17:22:49', '2018-09-26 17:22:49', NULL),
(4, 'QNtFO0IgMEiaVjSJr2pe76BhGnlzYK', '::1', '2018-09-26 17:22:49', '2018-09-26 17:22:49', NULL),
(4, 'VuwDPjt2I5eCx8gqmOFvklL7QM0ZG4', '::1', '2018-09-27 09:10:48', '2018-09-27 09:10:48', NULL),
(4, 'cRzpmg4D6IMdi1oxq5jbhXwfsOPvnH', '::1', '2018-09-27 09:10:48', '2018-09-27 09:10:48', NULL),
(4, '294uN1h0A8tQkCab5HvKzeGJf7cpnL', '::1', '2018-09-27 09:10:48', '2018-09-27 09:10:48', NULL),
(1, 'Z9m1KBgrOEL4I7wvy0GC8niScQbtHx', '::1', '2018-09-27 12:25:47', '2018-09-27 12:25:47', NULL),
(1, 'eu1RWErQzFlJ5t2qKpILbg0NH6XVPT', '::1', '2018-09-27 12:25:47', '2018-09-27 12:25:47', NULL),
(4, 'ciW9ULZCGxRrQeuAavt8oblIKjSF7q', '::1', '2018-09-28 09:12:48', '2018-09-28 09:12:48', NULL),
(4, 'quydsOKNlIb7LmCXt2FMkhaRPfZgpv', '::1', '2018-09-28 09:12:49', '2018-09-28 09:12:49', NULL),
(1, 'T1BR9XlxCjt8LQGchJsgw0o3DW7e2Z', '::1', '2018-09-28 17:36:43', '2018-09-28 17:36:43', NULL),
(1, 'puaY1A5whsDtzMlC4exv8BGndJfcNP', '::1', '2018-09-28 17:36:43', '2018-09-28 17:36:43', NULL),
(4, 'yHW6h4KQrMOPNJ82IYmGn7ceAikDda', '::1', '2018-09-29 09:11:04', '2018-09-29 09:11:04', NULL),
(4, 'DnRxQo0Yq6K9yBHlzPw4tcUMk5GjpV', '::1', '2018-09-29 09:11:04', '2018-09-29 09:11:04', NULL),
(1, 'Sco6aCYNlpdKOmBjb7kiQJFLuhr4Dq', '::1', '2018-09-29 09:11:59', '2018-09-29 09:11:59', NULL),
(1, 'CYW6gGPwjnqiQbXum9hEUDdxoBcJI2', '::1', '2018-09-29 09:11:59', '2018-09-29 09:11:59', NULL),
(4, 'Nr1vlCc90knhLyXS8Ys6TO2oI5u3qz', '::1', '2018-09-29 14:35:22', '2018-09-29 14:35:22', NULL),
(4, 'XRjBwWg8I4TMGpQEqd2PnJ1hlm6y7x', '::1', '2018-09-29 14:35:22', '2018-09-29 14:35:22', NULL),
(4, 'c54YKBI3zPUljHNQspS1mxv6FOVEin', '::1', '2018-09-29 14:39:15', '2018-09-29 14:39:15', NULL),
(4, '61jZC0xnBmO34NrEkS9M58UyJTXHeW', '::1', '2018-09-29 14:39:15', '2018-09-29 14:39:15', NULL),
(4, 'bnApTva97VmZC6tXFLq3roU5y2Dc4I', '::1', '2018-09-29 14:43:43', '2018-09-29 14:43:43', NULL),
(4, 'A4zH5l28xSGNIa7WoRPD0gwLd6ZEtO', '::1', '2018-09-29 14:43:43', '2018-09-29 14:43:43', NULL),
(1, 'SUFNPKyMe7dIo5ZfCTvuljm9LBgHDx', '::1', '2018-09-29 14:54:12', '2018-09-29 14:54:12', NULL),
(1, 'OMpUSKT31JYuceo89AxNbVng4ZzwyE', '::1', '2018-09-29 14:54:12', '2018-09-29 14:54:12', NULL),
(4, 'KFX7OvE8jB9IMPVcbU0SGuReAnhrWg', '::1', '2018-09-29 15:02:43', '2018-09-29 15:02:43', NULL),
(4, '8Vc5GPZC4EwBDS9YbjeQiOyuz1drxv', '::1', '2018-09-29 15:02:43', '2018-09-29 15:02:43', NULL),
(4, 'I7TpPAjD6x8SErbJuskow3laYqiU9C', '::1', '2018-10-01 09:23:52', '2018-10-01 09:23:52', NULL),
(4, 'EDZ0G6zHh5QISTjUAkdOPrlBWNRswm', '::1', '2018-10-01 09:23:52', '2018-10-01 09:23:52', NULL),
(4, 'NQHUoTEe4Oyft3IGp6mWDRzXbZMCK1', '::1', '2018-10-02 09:23:53', '2018-10-02 09:23:53', NULL),
(4, '3zGrHMloOwnm7Ye1BTDJX5SpLfKqIk', '::1', '2018-10-02 09:23:53', '2018-10-02 09:23:53', NULL),
(4, '6mzUxaYjGokiDgcKfH2N4sFPhQ3VC1', '::1', '2018-10-03 09:19:01', '2018-10-03 09:19:01', NULL),
(4, 'QRagUlmsy98oLEJOnKBxerH7fC4Zk5', '::1', '2018-10-03 09:19:01', '2018-10-03 09:19:01', NULL),
(4, 'q2XTm6S1lPK4thZYjiwvs3AUQON5Fp', '::1', '2018-10-03 09:37:01', '2018-10-03 09:37:01', NULL),
(4, 'pMRNs9cLDymnFW1GkTfH4iaxBZOA2S', '::1', '2018-10-03 09:37:02', '2018-10-03 09:37:02', NULL),
(4, '7HlZLiydYur8h3DxS6e9wUJogW4pNQ', '::1', '2018-10-03 15:11:11', '2018-10-03 15:11:11', NULL),
(4, 'eHnB4DO3w6SMyr5uFjcWCVYp2odEKx', '::1', '2018-10-03 15:11:12', '2018-10-03 15:11:12', NULL),
(4, 'NsjTQRxn4Jwi538KqF2MUge7pmvcPG', '::1', '2018-10-03 15:14:25', '2018-10-03 15:14:25', NULL),
(4, 'WDG5a2fM79OjoSXV0d3r4v1FkPAH6Z', '::1', '2018-10-03 15:14:25', '2018-10-03 15:14:25', NULL),
(4, 't8faJYqUrvTh2NQosz5lOIVyWBg9Fk', '::1', '2018-10-03 15:19:44', '2018-10-03 15:19:44', NULL),
(4, '1IK2L3ScQyAgRDpfjYslCVMmkZF6bU', '::1', '2018-10-03 15:19:44', '2018-10-03 15:19:44', NULL),
(4, 'blziVC3pEN6qS0sMkR8cyWUPjYfmZI', '::1', '2018-10-03 15:47:11', '2018-10-03 15:47:11', NULL),
(4, '18emGn5Y7CANfyh3ri4dbJlo6ctDzL', '::1', '2018-10-03 15:47:11', '2018-10-03 15:47:11', NULL),
(4, 'yZp1bqPhgjkKaFv4zmVCYes5f2LdOE', '::1', '2018-10-03 15:52:55', '2018-10-03 15:52:55', NULL),
(4, 'pMnmwLcBIW4lQz9exSFj6kDJO0uX8a', '::1', '2018-10-03 15:52:55', '2018-10-03 15:52:55', NULL),
(4, 'IiUCevm5G0bOLqlufoXshkzgpwM1xn', '::1', '2018-10-03 15:57:33', '2018-10-03 15:57:33', NULL),
(4, 'JyPSaDdgAtU4GvNmfYrMFn9j7b0Hi2', '::1', '2018-10-03 15:57:33', '2018-10-03 15:57:33', NULL),
(1, 'ArIiGa5oY60NT3x4XFu8t9S1Oc2vqH', '::1', '2018-10-03 17:16:11', '2018-10-03 17:16:11', NULL),
(1, '5SuaYio14nlbUk7CX90OQcgW6rzdvJ', '::1', '2018-10-03 17:16:11', '2018-10-03 17:16:11', NULL),
(1, 'PbUXGT6goRVhLmvrOKny3NxDsWw427', '::1', '2018-10-04 09:12:58', '2018-10-04 09:12:58', NULL),
(1, 'ZyXQuzapHIjBqKDdS2vneUm46kPMrJ', '::1', '2018-10-04 09:12:58', '2018-10-04 09:12:58', NULL),
(4, 'p8hPEfs2B1ctkWvwdZDubRSLyGx4MO', '::1', '2018-10-04 09:17:25', '2018-10-04 09:17:25', NULL),
(4, 'znWOQMZXwTfkpYUHPvRsKJEDqxBIge', '::1', '2018-10-04 09:17:25', '2018-10-04 09:17:25', NULL),
(1, 'K6NpmDWaARyHcjXCqd45b9LTnVhJvP', '::1', '2018-10-04 14:15:54', '2018-10-04 14:15:54', NULL),
(1, 'Gztk7x536fljiNEcWZ8CwueganL4KI', '::1', '2018-10-04 14:15:54', '2018-10-04 14:15:54', NULL),
(4, 'dh01VjTG2LzWyJUaYiA9l6RtNsMC7r', '::1', '2018-10-04 15:46:12', '2018-10-04 15:46:12', NULL),
(4, 'iH1jov0esmKP8w3Tzufgnd52bGFxOa', '::1', '2018-10-04 15:46:12', '2018-10-04 15:46:12', NULL),
(4, '5L3fK6mQJz70aHwect82UOjNSuFEI1', '::1', '2018-10-05 09:17:02', '2018-10-05 09:17:02', NULL),
(4, 'cXG50KSQejrP38Uyoz4Ca6igRIusFD', '::1', '2018-10-05 09:17:02', '2018-10-05 09:17:02', NULL),
(4, 'JPfeZM6SwWNCoygxIUAmDOusHnEL3v', '::1', '2018-10-05 09:28:19', '2018-10-05 09:28:19', NULL),
(4, 'gcjI0v1wRbKhp56xTGMsSuVA8nmB3X', '::1', '2018-10-05 09:28:19', '2018-10-05 09:28:19', NULL),
(1, 'RqF7KM3DNCH5ywb0mOngWLxz2Q1SPo', '::1', '2018-10-05 14:06:43', '2018-10-05 14:06:43', NULL),
(1, '2M3mBELvkOsXJl9WIzaPigcVGFjwfx', '::1', '2018-10-05 14:06:43', '2018-10-05 14:06:43', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `erp_auto_increament`
--
ALTER TABLE `erp_auto_increament`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `erp_categories`
--
ALTER TABLE `erp_categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `erp_departments`
--
ALTER TABLE `erp_departments`
  ADD PRIMARY KEY (`dep_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `erp_locations`
--
ALTER TABLE `erp_locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `erp_material_master`
--
ALTER TABLE `erp_material_master`
  ADD PRIMARY KEY (`mat_id`),
  ADD KEY `mat_id` (`mat_id`),
  ADD KEY `cat_id` (`cat_id`,`sub_cat_id`,`unit_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `sub_cat_id` (`sub_cat_id`),
  ADD KEY `cat_id_2` (`cat_id`,`sub_cat_id`,`mat_parent_id`,`unit_id`,`location_id`,`length_unit_id`);

--
-- Indexes for table `erp_material_quotation_draft`
--
ALTER TABLE `erp_material_quotation_draft`
  ADD PRIMARY KEY (`quo_draft_id`);

--
-- Indexes for table `erp_material_quotation_request`
--
ALTER TABLE `erp_material_quotation_request`
  ADD PRIMARY KEY (`quo_req_id`);

--
-- Indexes for table `erp_material_quotation_request_details`
--
ALTER TABLE `erp_material_quotation_request_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `erp_material_requisation_draft`
--
ALTER TABLE `erp_material_requisation_draft`
  ADD PRIMARY KEY (`req_draft_id`),
  ADD KEY `mat_id` (`mat_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `erp_material_requisition`
--
ALTER TABLE `erp_material_requisition`
  ADD PRIMARY KEY (`req_id`),
  ADD KEY `req_id` (`req_id`,`dep_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `erp_material_requisition_details`
--
ALTER TABLE `erp_material_requisition_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`req_id`,`mat_id`,`unit_id`),
  ADD KEY `req_id` (`req_id`),
  ADD KEY `mat_id` (`mat_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `erp_menu`
--
ALTER TABLE `erp_menu`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `erp_permission_keys`
--
ALTER TABLE `erp_permission_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `erp_purchase_order`
--
ALTER TABLE `erp_purchase_order`
  ADD PRIMARY KEY (`po_id`);

--
-- Indexes for table `erp_purchase_order_details`
--
ALTER TABLE `erp_purchase_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `erp_purchase_order_details_draft`
--
ALTER TABLE `erp_purchase_order_details_draft`
  ADD PRIMARY KEY (`po_draft_id`);

--
-- Indexes for table `erp_sub_categories`
--
ALTER TABLE `erp_sub_categories`
  ADD PRIMARY KEY (`sub_cat_id`),
  ADD KEY `sub_cat_id` (`sub_cat_id`,`cat_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `erp_supplier`
--
ALTER TABLE `erp_supplier`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `erp_supplier_materials`
--
ALTER TABLE `erp_supplier_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`,`mat_id`,`unit_id`);

--
-- Indexes for table `erp_supplier_quotation_bid`
--
ALTER TABLE `erp_supplier_quotation_bid`
  ADD PRIMARY KEY (`quotation_id`);

--
-- Indexes for table `erp_supplier_quotation_bid_details`
--
ALTER TABLE `erp_supplier_quotation_bid_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `erp_unit_master`
--
ALTER TABLE `erp_unit_master`
  ADD PRIMARY KEY (`unit_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `erp_auto_increament`
--
ALTER TABLE `erp_auto_increament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `erp_categories`
--
ALTER TABLE `erp_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `erp_departments`
--
ALTER TABLE `erp_departments`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `erp_locations`
--
ALTER TABLE `erp_locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `erp_material_master`
--
ALTER TABLE `erp_material_master`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `erp_material_quotation_draft`
--
ALTER TABLE `erp_material_quotation_draft`
  MODIFY `quo_draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `erp_material_quotation_request`
--
ALTER TABLE `erp_material_quotation_request`
  MODIFY `quo_req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `erp_material_quotation_request_details`
--
ALTER TABLE `erp_material_quotation_request_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `erp_material_requisation_draft`
--
ALTER TABLE `erp_material_requisation_draft`
  MODIFY `req_draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `erp_material_requisition`
--
ALTER TABLE `erp_material_requisition`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `erp_material_requisition_details`
--
ALTER TABLE `erp_material_requisition_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT for table `erp_menu`
--
ALTER TABLE `erp_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `erp_permission_keys`
--
ALTER TABLE `erp_permission_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `erp_purchase_order`
--
ALTER TABLE `erp_purchase_order`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `erp_purchase_order_details`
--
ALTER TABLE `erp_purchase_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `erp_purchase_order_details_draft`
--
ALTER TABLE `erp_purchase_order_details_draft`
  MODIFY `po_draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `erp_sub_categories`
--
ALTER TABLE `erp_sub_categories`
  MODIFY `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
--
-- AUTO_INCREMENT for table `erp_supplier`
--
ALTER TABLE `erp_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `erp_supplier_materials`
--
ALTER TABLE `erp_supplier_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `erp_supplier_quotation_bid`
--
ALTER TABLE `erp_supplier_quotation_bid`
  MODIFY `quotation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `erp_supplier_quotation_bid_details`
--
ALTER TABLE `erp_supplier_quotation_bid_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `erp_unit_master`
--
ALTER TABLE `erp_unit_master`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `erp_material_master`
--
ALTER TABLE `erp_material_master`
  ADD CONSTRAINT `erp_material_master_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `erp_unit_master` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `erp_material_master_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `erp_categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `erp_material_master_ibfk_3` FOREIGN KEY (`sub_cat_id`) REFERENCES `erp_sub_categories` (`sub_cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `erp_material_requisition`
--
ALTER TABLE `erp_material_requisition`
  ADD CONSTRAINT `erp_material_requisition_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `erp_departments` (`dep_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `erp_material_requisition_details`
--
ALTER TABLE `erp_material_requisition_details`
  ADD CONSTRAINT `erp_material_requisition_details_ibfk_1` FOREIGN KEY (`req_id`) REFERENCES `erp_material_requisition` (`req_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `erp_material_requisition_details_ibfk_2` FOREIGN KEY (`mat_id`) REFERENCES `erp_material_master` (`mat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `erp_material_requisition_details_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `erp_unit_master` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `erp_sub_categories`
--
ALTER TABLE `erp_sub_categories`
  ADD CONSTRAINT `erp_sub_categories_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `erp_categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
