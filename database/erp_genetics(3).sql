-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2018 at 06:49 AM
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
  `po_number` varchar(255) DEFAULT NULL,
  `quotation_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_auto_increament`
--

INSERT INTO `erp_auto_increament` (`id`, `material_requisation_number`, `quotation_request_number`, `material_unique_number`, `po_number`, `quotation_number`) VALUES
(1, '000012', '000024', 'DCGL/29', 'DCGL/2018/43', 'Quotation/2018/42');

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
(-1, 'DEFAULT', 'DEFAULT', NULL, NULL, '2018-08-17 00:00:00', 1, '2018-08-17 00:00:00', 1, '0'),
(1, '1', 'GENERAL ITEMS', 'general_po', 'consumable', '2018-08-11 07:06:02', 1, '2018-08-30 12:43:11', 1, '0'),
(2, '2', 'CHEMICAL', 'material_po', 'non_consumable', '2018-08-11 07:11:22', 1, '2018-09-18 16:10:32', 1, '0'),
(3, '3', 'CONSUMABLE', 'general_po', 'consumable', '2018-08-11 07:12:31', 1, NULL, NULL, '0'),
(4, '4', 'CHEMICAL (EXTRACTION)', 'material_po', 'consumable', '2018-08-11 07:13:27', 1, '2018-08-20 03:52:15', 1, '0'),
(5, '5', 'CONSUMABLES INSTRUMENT', 'material_po', 'consumable', '2018-08-11 07:15:24', 1, NULL, NULL, '0'),
(6, '6', 'PLASTIC CONSUMABLE', 'general_po', 'consumable', '2018-08-11 07:17:43', 1, '2018-08-30 12:41:24', 1, '0'),
(7, '7', 'INSTRUMENT', 'material_po', 'consumable', '2018-08-11 07:19:40', 1, NULL, NULL, '0'),
(8, '8', 'LOCAL ITEMS', 'material_po', 'consumable', '2018-08-11 07:21:22', 1, '2018-08-18 12:51:13', 1, '0'),
(9, '9', 'INSTALLATIONS & SERVICES', 'general_po', 'non_consumable', '2018-08-11 07:25:35', 1, NULL, NULL, '0');

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
('NA'),
('NIL');

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
('IMMIDIATE'),
('1 week'),
('1-2 week'),
('1-3 weeks'),
('2-3 weeks'),
('6-8 weeks'),
('As Commited'),
('delivery in 6 lots in 14 months'),
('Against Delivery'),
('4-6 weeks');

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
('NIL');

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
-- Table structure for table `erp_material_inwards`
--

CREATE TABLE `erp_material_inwards` (
  `inward_id` int(11) NOT NULL,
  `bill_date` date DEFAULT NULL,
  `bill_number` varchar(355) DEFAULT NULL,
  `chalan_date` date DEFAULT NULL,
  `gate_entry_date` date DEFAULT NULL,
  `gate_entry_number` varchar(355) DEFAULT NULL,
  `grn_date` date DEFAULT NULL,
  `grn_number` varchar(355) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `state_code` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_inward_details_draft`
--

CREATE TABLE `erp_material_inward_details_draft` (
  `inward_draft_id` int(11) NOT NULL,
  `po_id` int(11) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `hsn_code` varchar(355) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `po_qty` float DEFAULT NULL,
  `received_qty` float DEFAULT NULL,
  `rejected_qty` float DEFAULT NULL,
  `discount_per` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `mat_amount` float DEFAULT NULL,
  `cgst_per` float DEFAULT NULL,
  `cgst_amt` float DEFAULT NULL,
  `sgst_per` float DEFAULT NULL,
  `sgst_amt` float DEFAULT NULL,
  `igst_per` float DEFAULT NULL,
  `igst_amt` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_inward_details_draft`
--

INSERT INTO `erp_material_inward_details_draft` (`inward_draft_id`, `po_id`, `mat_id`, `hsn_code`, `unit_id`, `rate`, `po_qty`, `received_qty`, `rejected_qty`, `discount_per`, `discount`, `mat_amount`, `cgst_per`, `cgst_amt`, `sgst_per`, `sgst_amt`, `igst_per`, `igst_amt`) VALUES
(2, 2, 26, '423434', 3, 12, 8, 0, 0, 0, 0, 96, 7, 6.72, 0, 0, 7, 6.72),
(3, 2, 19, '343243', 2, 3, 6, 0, 0, 0, 0, 18, 6, 1.08, 7, 1.26, 7, 1.26),
(4, 2, 22, '1232311', 2, 12, 6, 0, 0, 0, 0, 72, 6, 4.32, 7, 5.04, 7, 5.04),
(6, 3, 44, '543543', 2, 12, 3, 0, 0, 0, 0, 36, 12, 4.32, 12, 4.32, 12, 4.32),
(7, 3, 4, '12323', 2, 12, 2, 0, 0, 0, 0, 24, 12, 2.88, 12, 2.88, 12, 2.88),
(8, 7, 24, '', 2, 12, 2, 0, 0, 0, 0, 24, 12, 2.88, 12, 2.88, 12, 2.88);

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
(17, 'DCGL/03', '0215757401', '4′,6-DIAMIDINO-2-PHENYLINDOLE', '4′,6-DIAMIDINO-2-PHENYLINDOLE', 0, 2, -1, 17, '0215757401', '4′,6-DIAMIDINO-2-PHENYLINDOLE', NULL, 2, 0, 1, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 1, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 04:51:46', 1, '2018-10-11 16:50:08', 4, '0'),
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

--
-- Dumping data for table `erp_material_quotation_draft`
--

INSERT INTO `erp_material_quotation_draft` (`quo_draft_id`, `mat_id`, `unit_id`, `require_qty`, `dep_id`, `mat_req_id`) VALUES
(5, 26, 2, 8, 21, NULL),
(8, 19, 4, 6, 21, NULL),
(9, 22, 6, 6, 21, NULL),
(10, 17, 2, 3, 20, 12),
(11, 19, 2, 3, 20, 12),
(12, 3, 2, 2, 20, 12),
(13, 4, 22, 2, 20, 12);

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
  `approval_by_purchase` int(11) DEFAULT NULL,
  `approval_date_purchase` datetime DEFAULT NULL,
  `approval_status_purchase` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `approval_quotation_id_purchase` int(11) DEFAULT NULL,
  `approval_by_account` int(11) DEFAULT NULL,
  `approval_date_account` datetime DEFAULT NULL,
  `approval_status_account` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `approval_quotation_id_account` int(11) DEFAULT NULL,
  `last_quotation_id` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_quotation_request`
--

INSERT INTO `erp_material_quotation_request` (`quo_req_id`, `quotation_request_number`, `request_date`, `supplier_id`, `dep_id`, `approval_by_purchase`, `approval_date_purchase`, `approval_status_purchase`, `approval_quotation_id_purchase`, `approval_by_account`, `approval_date_account`, `approval_status_account`, `approval_quotation_id_account`, `last_quotation_id`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 'Quo/2018/00007', '2018-09-08', '10,11,3,2', 20, 4, '2018-10-08 15:53:32', 'pending', 1, 6, '2018-10-08 14:33:25', 'pending', 1, 0, '2018-09-08 09:59:28', 1, '2018-10-08 15:53:32', 4, '0'),
(2, 'Quo/2018/00008', '2018-09-08', '2,9', 20, 4, '2018-10-08 12:13:43', 'pending', 3, 6, '2018-10-08 12:29:27', 'pending', 3, 0, '2018-09-08 15:12:17', 1, '2018-10-08 12:29:27', 6, '0'),
(3, 'Quo/2018/00009', '2018-09-10', '5', 20, 0, '0000-00-00 00:00:00', 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-09-10 14:10:00', 1, NULL, NULL, '0'),
(4, 'Quo/2018/000010', '2018-09-10', '1,2,3,4,5,6,10', 20, 0, '0000-00-00 00:00:00', 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-09-10 14:51:54', 1, NULL, NULL, '0'),
(5, 'Quo/2018/000011', '2018-09-10', '1,2,3,4', 20, 0, '0000-00-00 00:00:00', 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-09-10 14:57:39', 1, NULL, NULL, '0'),
(6, 'Quo/2018/000012', '2018-09-12', '6,9', 21, 4, '2018-10-24 14:38:19', 'approved', 6, 6, '2018-10-24 14:44:51', 'approved', 6, 6, '2018-09-12 15:17:13', 4, '2018-10-24 14:44:51', 6, '0'),
(7, 'Quo/2018/000013', '2018-09-12', '1,5', 21, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-09-12 16:57:44', 4, NULL, NULL, '0'),
(10, 'Quo/2018/000015', '2018-09-25', '2', 21, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-09-25 13:30:17', 4, NULL, NULL, '0'),
(11, 'Quo/2018/000016', '2018-09-26', '3', 21, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-09-26 16:29:53', 4, NULL, NULL, '0'),
(12, 'Quo/2018/000017', '2018-10-05', '2,5', 21, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-10-05 10:49:07', 4, NULL, NULL, '0'),
(13, 'Quo/2018/000018', '2018-10-05', '7,25,26', 20, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-10-05 12:46:25', 4, NULL, NULL, '0'),
(14, 'Quo/2018/000019', '2018-10-05', '7,25,26', 20, 4, '2018-10-29 14:46:28', 'approved', 5, 6, '2018-10-29 14:45:59', 'approved', 5, 5, '2018-10-05 13:47:32', 4, '2018-10-29 14:46:28', 4, '0'),
(15, 'Quo/2018/000020', '2018-10-05', '25,26,27', 21, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-10-05 13:49:25', 4, NULL, NULL, '0'),
(16, 'Quo/2018/000021', '2018-10-08', '7,25,26', 20, 4, '2018-10-24 12:42:17', 'approved', 4, 6, '2018-10-24 12:45:22', 'approved', 4, 4, '2018-10-08 16:53:50', 4, '2018-10-24 12:45:22', 6, '0'),
(17, 'Quo/2018/000022', '2018-10-12', '7', 19, 4, '2018-10-23 17:37:08', 'approved', 1, 6, '2018-10-23 17:38:09', 'approved', 1, 1, '2018-10-12 14:49:50', 4, '2018-10-23 17:38:09', 6, '0'),
(18, 'Quo/2018/000023', '2018-10-25', '6', 15, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-10-25 10:20:03', 4, NULL, NULL, '0'),
(20, 'Quo/2018/000024', '2018-10-25', '6', 17, 4, '2018-10-25 11:34:28', 'approved', 7, 6, '2018-10-25 11:34:59', 'approved', 7, 7, '2018-10-25 10:28:12', 4, '2018-10-25 11:34:59', 6, '0');

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
(36, 15, 4, 3, 4, 21, 16, '2018-10-05 13:49:25', 4, NULL, NULL),
(37, 16, 18, 2, 3, 20, 12, '2018-10-08 16:53:50', 4, NULL, NULL),
(38, 17, 26, 2, 8, 19, 0, '2018-10-12 14:49:50', 4, NULL, NULL),
(39, 18, 26, 3, 8, 15, 0, '2018-10-25 10:20:03', 4, NULL, NULL),
(40, 18, 24, 6, 5, 15, 0, '2018-10-25 10:20:03', 4, NULL, NULL),
(41, 18, 28, 7, 7, 15, 0, '2018-10-25 10:20:03', 4, NULL, NULL),
(45, 20, 26, 2, 8, 17, 0, '2018-10-25 10:28:12', 4, NULL, NULL),
(46, 20, 19, 4, 6, 17, 0, '2018-10-25 10:28:12', 4, NULL, NULL),
(47, 20, 22, 6, 6, 17, 0, '2018-10-25 10:28:12', 4, NULL, NULL);

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
(15, 3, 2, '2018-12-12', NULL, NULL, 21, '0');

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
(1, NULL, 'Purchase', 'Purchase', '', 'fa fa-shopping-cart', '1', NULL, NULL, '2018-10-08 12:26:21', 1, '0', '1,4,6'),
(2, NULL, 'Stores', 'Store', '', 'fa fa-book', '1', NULL, NULL, '2018-10-09 10:32:21', 1, '0', '1,4,5,6'),
(3, 1, 'Master', 'purchase-master', NULL, 'fa fa-dot-circle-o', '1', NULL, NULL, NULL, NULL, '0', '1,4'),
(6, 2, 'Input', 'Store-Input', '', 'fa fa-dot-circle-o', '1', NULL, NULL, '2018-10-09 10:33:16', 1, '0', '1,4,5,6'),
(7, 2, 'Output', 'Store-output', '', 'fa fa-dot-circle-o', '0', NULL, NULL, '2018-09-04 11:15:03', 1, '0', '1'),
(8, 3, 'Unit', 'Purchase-master-unit', 'purchase/unit', 'fa fa-circle-o', '0', NULL, NULL, '2018-10-11 09:31:54', 1, '0', '1,4,6'),
(9, 3, 'Category', 'Purchase-master-category', 'purchase/category', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 10:35:46', 1, '0', '1,4'),
(10, 3, 'Material', 'purchase-master-material', 'purchase/material', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 10:36:00', 1, '0', '1,4'),
(11, 3, 'Vendor', 'purchase-master-supplier', 'purchase/supplier', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 10:36:11', 1, '0', '1,4'),
(12, NULL, 'Settings', 'Settings', 'settings/index', 'fa fa-gear', '0', NULL, NULL, NULL, NULL, '0', '1'),
(13, NULL, 'Departments', 'Departments', 'department/index', 'fa fa-building', '0', '2018-08-20 00:00:00', 1, '2018-09-04 10:21:11', 1, '0', '1'),
(14, 6, 'Material-Inward', 'Store-Input-Inward', 'store/material_inward', 'fa fa-circle-o', '0', '2018-08-23 00:00:00', 1, '2018-10-29 11:42:48', 1, '0', '1,4'),
(15, 6, 'Material Requisition', 'Store-Input-Requisation', 'store/material_requisation', 'fa fa-circle-o', '0', '2018-08-23 00:00:00', 1, '2018-10-09 10:32:10', 1, '0', '1,4,5,6'),
(23, 1, 'Quotations (Materials)', 'Quotations (Materials)', 'purchase/quotations', 'fa fa-dot-circle-o', '0', '2018-09-28 17:40:26', 1, '2018-10-08 12:25:36', 1, '0', '1,4,6'),
(24, 1, 'Purchase Order', 'Purchase Order', 'purchase/purchase_order', 'fa fa-dot-circle-o', '1', '2018-09-28 17:42:06', 1, '2018-10-03 17:17:12', 1, '0', '1,4'),
(25, 24, 'Prepare PO (Quotation)', 'Prepare PO (Quotation)', 'purchase/purchase_order_quotation', 'fa fa-circle-o', '0', '2018-09-28 18:14:44', 1, '2018-09-29 09:20:37', 1, '0', '1,4'),
(26, 24, 'Prepare PO (Requisition)', '', 'purchase/purchase_order_requisition', 'fa fa-circle-o', '0', '2018-09-28 18:15:46', 1, '2018-09-29 09:21:41', 1, '0', '1,4'),
(27, 6, 'General-inward', 'General-inward', 'store/general_inward', 'fa fa-circle-o', '0', '2018-10-30 10:28:33', 1, NULL, NULL, '0', '1,4');

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
('100% Advance'),
('100% against delivery');

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
(35, 'quotation-accounts_approval_status'),
(36, 'quotation-view_quotation_details'),
(37, 'quotation-send_quotation_request'),
(38, 'quotation-pending_quotations_list'),
(39, 'quotation-quotations_list'),
(40, 'quotation-approved_quotations_list'),
(41, 'quotation-prepare_purchase_order_button'),
(42, 'dashboard-pending_requisation_count'),
(43, 'dashboard-approved_requisation_count'),
(44, 'dashboard-completed_requisation_count'),
(45, 'dashboard-place_new_requisition'),
(46, 'dashboard-view_all_requisition'),
(47, 'dashboard-place_new_purchase_order'),
(48, 'dashboard-all_purchase_order'),
(49, 'dashboard-pending_po_count'),
(50, 'dashboard-approved_po_count'),
(51, 'dashboard-completed_po_count'),
(52, 'PurchaseOrder-add_new_po_button'),
(53, 'PurchaseOrder-prepare_po_quotation'),
(54, 'PurchaseOrder-prepare_po_requisition'),
(55, 'PurchaseOrder-pending_purchase_order'),
(56, 'PurchaseOrder-approved_purchase_order'),
(57, 'PurchaseOrder-completed_purchase_order'),
(58, 'PurchaseOrder-approved_purchase_order_view'),
(59, 'PurchaseOrder-pending_purchase_order_edit'),
(61, 'PurchaseOrder-completed_purchase_order_view'),
(62, 'Settings-sub_menu_details'),
(63, 'Settings-edit_parent_menu_link'),
(64, 'Settings-remove_parent_menu_link'),
(65, 'Settings-add_sub_menu'),
(66, 'Settings-insert_parent_menu_details'),
(67, 'Settings-edit_parent_menu_details'),
(68, 'Settings-access_permission_key'),
(69, 'PurchaseOrder-completed_purchase_order_delete'),
(70, 'PurchaseOrder-approved_purchase_order_delete'),
(71, 'PurchaseOrder-pending_purchase_order_delete'),
(72, 'vendor-invoice_tab'),
(73, 'dashboard-request_quotation'),
(74, 'dashboard-received_quotation'),
(75, 'dashboard-approved_quotation'),
(76, 'quotation-approved_disapproved_button'),
(77, 'vendor-edit_tab'),
(78, 'PurchaseOrder-approval_flag');

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
  `cat_id` int(11) DEFAULT NULL,
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
  `approval_date` datetime DEFAULT NULL,
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
  `amendment` enum('no','yes') NOT NULL DEFAULT 'no',
  `material_inward_po` enum('no','yes') NOT NULL DEFAULT 'no',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_purchase_order`
--

INSERT INTO `erp_purchase_order` (`po_id`, `po_type`, `po_number`, `po_date`, `supplier_id`, `quotation_id`, `req_id`, `cat_id`, `dep_id`, `delievery_schedule`, `delievery_schedule_days`, `transport`, `freight_charges`, `payment_terms`, `test_certificate`, `custom_duty`, `approval_flag`, `approval_by`, `approval_date`, `notes`, `remarks`, `currency`, `total_amt`, `total_cgst`, `total_sgst`, `total_igst`, `freight_amt`, `other_amt`, `total_bill_amt`, `rounded_amt`, `po_form`, `status`, `amendment`, `material_inward_po`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 'material_po', 'DCGL/2018/31', '2018-10-29', 6, 6, NULL, NULL, 20, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', NULL, NULL, '', '', 'RS', 114, 13.68, 13.68, 0, 0, 0, 141.36, 0, 'quotation_form', 'non_completed', 'no', 'no', '2018-10-29 14:21:08', 4, NULL, NULL, '0'),
(2, 'material_po', 'DCGL/2018/33', '2018-10-29', 6, 7, NULL, NULL, 17, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, NULL, '', '', 'RS', 186, 12.12, 6.3, 13.02, 0, 12, 229.44, 0, 'quotation_form', 'non_completed', 'no', 'no', '2018-10-29 14:22:12', 4, '2018-10-29 14:39:50', 4, '0'),
(3, 'general_po', 'DCGL/2018/35', '2018-10-29', 7, NULL, NULL, 3, 20, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, NULL, '', '', 'RS', 60, 7.2, 7.2, 7.2, 0, 0, 81.6, 0, 'general_form', 'non_completed', 'no', 'no', '2018-10-29 14:26:58', 4, '2018-10-30 10:40:07', 4, '0'),
(4, 'material_po', 'DCGL/2018/37', '2018-10-29', 7, 5, NULL, NULL, 20, '01-01-2018 to 31-12-2018', 12, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', NULL, NULL, '', '', 'RS', 244, 29.28, 24.4, 0, 0, 12, 309.68, 0, 'quotation_form', 'non_completed', 'no', 'no', '2018-10-29 14:48:49', 4, NULL, NULL, '0'),
(5, 'material_po', 'DCGL/2018/39-A-A', '2018-10-30', 26, 4, NULL, NULL, 20, '2-3 weeks', 12, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', NULL, '2018-10-31 10:39:20', '', '', 'RS', 30, 0, 0, 0, 0, 0, 30, 0, 'quotation_form', 'non_completed', 'no', 'yes', '2018-10-30 09:41:03', 4, '2018-10-31 10:39:20', 4, '0'),
(6, 'material_po', 'DCGL/2018/40', '2018-10-30', 11, NULL, 23, NULL, 20, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, '2018-10-31 12:10:44', '', '', 'RS', 72, 0, 0, 0, 0, 0, 72, 0, 'requisition_form', 'non_completed', 'no', 'no', '2018-10-30 17:47:19', 4, NULL, NULL, '0'),
(7, 'general_po', 'DCGL/2018/42', '2018-11-01', 2, NULL, NULL, 9, 20, '01-01-2018 to 31-12-2018', 12, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, '2018-11-05 09:25:41', '', '', 'RS', 24, 2.88, 2.88, 2.88, 45, 0, 77.64, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-01 09:48:53', 4, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_purchase_order_details`
--

CREATE TABLE `erp_purchase_order_details` (
  `id` int(11) NOT NULL,
  `po_id` int(11) DEFAULT NULL,
  `req_id` int(11) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `hsn_code` varchar(255) DEFAULT NULL,
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

INSERT INTO `erp_purchase_order_details` (`id`, `po_id`, `req_id`, `quotation_id`, `cat_id`, `mat_id`, `hsn_code`, `dep_id`, `unit_id`, `qty`, `rate`, `expire_date`, `cgst_per`, `cgst_amt`, `sgst_per`, `sgst_amt`, `igst_per`, `igst_amt`, `discount`, `discount_per`, `mat_amount`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 1, NULL, 6, NULL, 17, NULL, 20, 2, 3, 24, '2018-10-29 00:00:00', 12, 8.64, 12, 8.64, 0, 0, 0, 0, 72, '2018-10-29 00:00:00', 4, NULL, NULL, '0'),
(2, 1, NULL, 6, NULL, 3, NULL, 20, 2, 2, 9, '2018-10-29 00:00:00', 12, 2.16, 12, 2.16, 0, 0, 0, 0, 18, '2018-10-29 00:00:00', 4, NULL, NULL, '0'),
(3, 1, NULL, 6, NULL, 4, NULL, 20, 2, 2, 12, '2018-10-29 00:00:00', 12, 2.88, 12, 2.88, 0, 0, 0, 0, 24, '2018-10-29 00:00:00', 4, NULL, NULL, '0'),
(4, 2, NULL, 7, NULL, 22, '1232311', 17, 2, 6, 12, '2018-10-29 00:00:00', 6, 4.32, 7, 5.04, 7, 5.04, 0, 0, 72, '2018-10-29 00:00:00', 4, '2018-10-29', 4, '0'),
(5, 2, NULL, 7, NULL, 26, '423434', 17, 3, 8, 12, '2018-10-29 00:00:00', 7, 6.72, 0, 0, 7, 6.72, 0, 0, 96, '2018-10-29 00:00:00', 4, '2018-10-29', 4, '0'),
(6, 2, NULL, 7, NULL, 19, '343243', 17, 2, 6, 3, '2018-10-29 00:00:00', 6, 1.08, 7, 1.26, 7, 1.26, 0, 0, 18, '2018-10-29 00:00:00', 4, '2018-10-29', 4, '0'),
(7, 3, NULL, NULL, 3, 4, '12323', 20, 2, 2, 12, '2018-10-29 00:00:00', 12, 2.88, 12, 2.88, 12, 2.88, 0, 0, 24, '2018-10-29 00:00:00', 4, '2018-10-30', 4, '0'),
(8, 3, NULL, NULL, 3, 44, '543543', 20, 2, 3, 12, '2018-10-29 00:00:00', 12, 4.32, 12, 4.32, 12, 4.32, 0, 0, 36, '2018-10-29 00:00:00', 4, '2018-10-30', 4, '0'),
(9, 4, NULL, 5, NULL, 3, '', 20, 2, 2, 122, '2018-10-29 00:00:00', 12, 29.28, 10, 24.4, 0, 0, 0, 0, 244, '2018-10-29 00:00:00', 4, NULL, NULL, '0'),
(10, 5, NULL, 4, NULL, 18, '89099', 20, 2, 3, 10, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 30, '2018-10-30 00:00:00', 4, '2018-10-31', 4, '0'),
(11, 6, 23, NULL, NULL, 3, '', 20, 2, 2, 12, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 24, '2018-10-30 00:00:00', 4, NULL, NULL, '0'),
(12, 6, 23, NULL, NULL, 4, '', 20, 2, 4, 12, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 48, '2018-10-30 00:00:00', 4, NULL, NULL, '0'),
(13, 7, NULL, NULL, 9, 24, '', 20, 2, 2, 12, '2018-11-01 00:00:00', 12, 2.88, 12, 2.88, 12, 2.88, 0, 0, 24, '2018-11-01 00:00:00', 4, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_purchase_order_details_draft`
--

CREATE TABLE `erp_purchase_order_details_draft` (
  `po_draft_id` int(11) NOT NULL,
  `req_id` int(11) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `hsn_code` varchar(255) DEFAULT NULL,
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

INSERT INTO `erp_purchase_order_details_draft` (`po_draft_id`, `req_id`, `quotation_id`, `cat_id`, `mat_id`, `hsn_code`, `dep_id`, `unit_id`, `qty`, `rate`, `expire_date`, `cgst_per`, `cgst_amt`, `sgst_per`, `sgst_amt`, `igst_per`, `igst_amt`, `discount`, `discount_per`, `mat_amount`) VALUES
(1, NULL, NULL, 9, 24, NULL, 13, 2, 0, 0, '2018-10-09 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, NULL, NULL, 3, 4, NULL, 16, 2, 0, 0, '2018-10-09 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, NULL, NULL, 3, 53, NULL, 16, 2, 0, 0, '2018-10-09 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, NULL, 3, NULL, 19, NULL, 20, 2, 5, 20, '2018-10-05 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 100),
(8, NULL, 3, NULL, 21, NULL, 20, 2, 2, 30, '2018-10-05 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 60),
(27, NULL, 27, NULL, 3, NULL, 21, 2, 2, 34, '2018-10-26 00:00:00', 18, 12.24, 18, 12.24, 18, 12.24, 0, 0, 68),
(44, NULL, 34, NULL, 18, NULL, 20, 2, 3, 3, '2018-11-15 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 9),
(45, NULL, 24, NULL, 26, NULL, 20, 2, 8, 10, '2018-11-23 00:00:00', 12, 8.16, 12, 8.16, 12, 8.16, 12, 0, 68),
(67, NULL, NULL, 3, 4, NULL, 21, 2, 0, 0, '2018-10-29 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(68, NULL, NULL, 3, 39, NULL, 21, 2, 0, 0, '2018-10-29 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(73, NULL, 1, NULL, 26, NULL, 20, 2, 8, 12, '2018-11-16 00:00:00', 12, 11.52, 12, 11.52, 12, 11.52, 0, 0, 96),
(111, 12, NULL, NULL, 17, NULL, 20, 2, 3, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(112, 12, NULL, NULL, 19, NULL, 20, 2, 3, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(113, 12, NULL, NULL, 21, NULL, 20, 2, 3, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(114, 12, NULL, NULL, 18, NULL, 20, 2, 3, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(115, 12, NULL, NULL, 3, NULL, 20, 2, 2, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(116, 12, NULL, NULL, 4, NULL, 20, 22, 2, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(119, 23, NULL, NULL, 3, NULL, 20, 2, 2, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(120, 23, NULL, NULL, 4, NULL, 20, 6, 4, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(130, NULL, 6, NULL, 3, NULL, 20, 2, 2, 9, '2018-10-25 00:00:00', 12, 2.16, 12, 2.16, 0, 0, 0, 0, 18),
(131, NULL, 6, NULL, 4, NULL, 20, 2, 2, 12, '2018-11-22 00:00:00', 12, 2.88, 12, 2.88, 0, 0, 0, 0, 24),
(132, NULL, 6, NULL, 17, NULL, 20, 2, 3, 24, '2018-11-30 00:00:00', 12, 8.64, 12, 8.64, 0, 0, 0, 0, 72),
(133, NULL, 7, NULL, 19, NULL, 20, 2, 6, 3, '2018-11-22 00:00:00', 6, 1.08, 7, 1.26, 7, 1.26, 0, 0, 18),
(134, NULL, 7, NULL, 22, NULL, 20, 2, 6, 12, '2018-11-22 00:00:00', 6, 4.32, 7, 5.04, 7, 5.04, 0, 0, 72),
(135, NULL, 7, NULL, 26, NULL, 20, 2, 8, 12, '2018-11-09 00:00:00', 7, 6.72, 0, 0, 7, 6.72, 0, 0, 96),
(136, 22, NULL, NULL, 4, NULL, 20, 2, 3, 0, '2018-11-01 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(137, NULL, NULL, 9, 24, NULL, 20, 2, 0, 0, '2018-11-02 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
(63, 4, '455', 'test232', '', '', '2018-08-14 10:56:30', 1, '2018-08-20 03:52:15', 1, '1'),
(64, 4, '9966', '54545', '', '', '2018-08-14 10:56:30', 1, '2018-08-20 03:52:15', 1, '1'),
(66, 7, '545', 'gfgfgffg', '', '', '2018-08-14 11:05:09', 1, '0000-00-00 00:00:00', NULL, '0'),
(67, 5, '4343', 'tttt', '', '', '2018-08-14 11:06:34', 1, '0000-00-00 00:00:00', NULL, '0'),
(69, 3, '434', 'fdffdf445', 'general_po', 'consumable', '2018-08-14 11:09:53', 1, '0000-00-00 00:00:00', NULL, '0'),
(70, 4, '433', 'cccccc', 'material_po', 'consumable', '2018-08-14 11:12:34', 1, '2018-08-20 03:52:15', 1, '1'),
(122, 5, '212', 'FRERRR', 'material_po', 'consumable', '2018-08-22 10:32:19', 1, '0000-00-00 00:00:00', NULL, '0'),
(123, 1, '1', 'GIFDSF', 'general_po', 'consumable', '2018-08-22 11:47:49', 1, '2018-08-30 12:43:11', 1, '1'),
(124, 1, '21', 'FDFDSFDS', 'general_po', 'consumable', '2018-08-22 12:12:31', 1, '2018-08-30 12:43:11', 1, '1'),
(125, 1, '343', 'TTTT', 'general_po', 'consumable', '2018-08-22 12:12:46', 1, '2018-08-30 12:43:11', 1, '1'),
(136, 2, 'test12', 'TEST123', 'material_po', 'non_consumable', '2018-09-18 16:10:32', 1, '0000-00-00 00:00:00', NULL, '0'),
(137, 2, '23', 'YYYYYYY', 'material_po', 'non_consumable', '2018-09-18 16:10:32', 1, '0000-00-00 00:00:00', NULL, '0'),
(138, 2, 'testcat11', 'ERERER', 'material_po', 'non_consumable', '2018-09-18 16:10:32', 1, '0000-00-00 00:00:00', NULL, '0'),
(139, 2, '6', 'TTTTT', 'material_po', 'non_consumable', '2018-10-10 10:55:48', 4, '0000-00-00 00:00:00', NULL, '0'),
(140, 3, '9', 'IUIUI', 'general_po', 'consumable', '2018-10-10 10:56:31', 4, '0000-00-00 00:00:00', NULL, '0'),
(141, 3, '8', 'LLL', 'general_po', 'consumable', '2018-10-10 10:58:35', 4, '0000-00-00 00:00:00', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_supplier`
--

CREATE TABLE `erp_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supp_firm_name` varchar(255) DEFAULT NULL,
  `supplier_logo` text,
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
  `password` text,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_vendor` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_supplier`
--

INSERT INTO `erp_supplier` (`supplier_id`, `supp_firm_name`, `supplier_logo`, `supp_contact_person`, `supp_address`, `supp_city`, `supp_pin`, `supp_contact`, `supp_mobile`, `supp_fax`, `supp_email`, `supp_state`, `supp_country`, `supp_contact_designation`, `supp_phone1`, `supp_phone2`, `supp_phone3`, `supp_mobile2`, `supp_website`, `supp_description`, `dep_id`, `password`, `created`, `created_by`, `updated`, `updated_vendor`, `updated_by`, `is_deleted`) VALUES
(1, 'Shripad Agencies', NULL, 'Shripad Agencies', 'W-104 (A) Additional Industrial Area M.I.D.C, Ambad, \r\nNashik - 422 010', 'Nashik', 422, NULL, '9823916718', '0', 'shripad@gmail.com', 'MAHARASHATRA', 'INDIA', '', '253', '0', NULL, '', '', NULL, NULL, '123451', '2018-08-02 12:37:45', 1, '2018-08-03 08:28:31', NULL, 1, '0'),
(2, 'SAN INFOTEK', NULL, 'Archana', 'Sharanpur Link Rd, Ramdas Colony, Nashik, Maharashtra', 'Nashik', 422005, NULL, '1234567891', '', 'Infotek@sangroup.co.in', 'MAHARASHATRA', 'INDIA', '', '0253 2310991', '0253 2315991', NULL, '', '', NULL, NULL, '1234567782', '2018-08-03 03:51:38', 1, '2018-09-18 13:46:49', NULL, 1, '0'),
(3, 'PRATHMESH ENTRPRISES', NULL, 'PRATHMESH ENTRPRISES', 'Shop No:7, Indira Gandhi complex Near Mahatma Nagar Water Tank, Mahatma Nagar.', 'Nashik', 422101, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '123453', '2018-08-03 04:18:26', 1, '2018-08-03 08:55:43', NULL, NULL, '0'),
(4, 'BOSS CORPORATION (EPOXY)', NULL, 'BOSS CORPORATION (EPOXY)', 'A-2 krishna Kamal Apt. Opp Shubam', '', 422101, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '123454', '2018-08-03 04:19:48', 1, '2018-08-18 04:35:13', NULL, 1, '0'),
(5, 'RELIABLE ALUMINIUM', NULL, 'RELIABLE ALUMINIUM', 'Shop No: 09, H K Plaza, Kurdukar N', '', 0, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '123455', '2018-08-03 04:21:04', 1, '2018-08-10 08:29:48', NULL, NULL, '0'),
(6, 'ALPS ENGINEERING', NULL, 'ALPS ENGINEERING', '1/1, DJ Park,Opp Holram Colony, Sa', '', 0, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'tersed', '15,17', '123456', '2018-08-03 04:22:24', 1, '2018-10-25 10:18:00', NULL, 4, '0'),
(7, 'ALFA ENGINEERING', 'http://localhost/vendor_erp/upload/profile_logo/alfa_engineering', 'Mr. Shailesh Pande', '1/1, DJ Park,Opp Holram Colony, Sadhu Waswani Road, Nashik.', 'Nasik', 422002, NULL, '1234567891', '', 'alfaac@gmail.com', 'MAHARASHATRA', 'INDIA', 'Service Executive', '0253-2314403', '', NULL, '', '', '0', '19,22,20', '123457', '2018-08-03 04:23:56', 1, '2018-09-19 12:22:54', '2018-10-20 12:51:28', 1, '0'),
(9, 'M K PRECISION PVT LTD.', NULL, 'M K PRECISION PVT LTD.', 'plot no: A791/10. T.T.C Industrial', '', 0, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '123458', '2018-08-03 04:26:10', 1, NULL, NULL, NULL, '0'),
(10, 'Anmol Sales Corporation', NULL, 'Mr. Jatin Rathi', 'Shop No.3, Sydney Towers,Behind Camel House,Near Kathe Galli Signal,Dwarka,Nasik', 'Nashik', 422011, NULL, '9823069120', '123456782', 'sales@anmolsales.com', 'MAHARASHATRA', 'INDIA', 'PROPRIETOR', '02532505900', '9923596528', NULL, '9823019865', 'http://anmolsales.com', NULL, NULL, '123459', '2018-08-03 04:31:11', 1, '2018-08-03 08:06:55', NULL, 1, '0'),
(11, 'ALGOL SOFTWARE CONSULTACY', NULL, 'ALGOL SOFTWARE CONSULTACY', 'Plot No: 69/407, SIFCO, MIDC , Sat', '', 0, NULL, '1234567891', '', 'abc@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, '1234510', '2018-08-03 04:32:28', 1, '2018-09-18 14:47:35', NULL, 1, '0'),
(12, 'test', NULL, 'test', 'test', '', 0, NULL, '9874587458', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, NULL, '2018-08-18 04:09:56', 1, '2018-08-18 04:10:10', NULL, 1, '1'),
(13, 'test', NULL, 'test', 'test', '', 0, NULL, '9874565459', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, NULL, '2018-08-18 04:10:58', 1, '2018-08-18 04:12:15', NULL, 1, '1'),
(14, 'test', NULL, 'test', 'test', '', 0, NULL, '9874563214', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, NULL, '2018-08-18 04:12:55', 1, '2018-08-18 04:34:12', NULL, 1, '1'),
(15, 'test', NULL, 'test', 'test', '', 0, NULL, '98654532123', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, NULL, '2018-08-18 04:34:54', 1, '2018-08-18 11:36:14', NULL, 1, '1'),
(16, 'rewr', NULL, 'rewrewr', 'rewrew', '', 0, NULL, '9845654589', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, NULL, '2018-08-18 11:23:49', 1, '2018-08-18 11:36:03', NULL, 1, '1'),
(17, 'ewe', NULL, 'ewewewe', 'ewqewqewqewq', '', 0, NULL, '9845654564', '', 'testt@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, NULL, '2018-08-18 11:27:26', 1, '2018-08-18 11:36:03', NULL, 1, '1'),
(18, 'fdsf', NULL, 'fdsfdsf', 'fdsfdsf', '', 0, NULL, '9845632125', '', 'test123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, NULL, '2018-08-18 11:50:14', 1, '2018-08-18 11:50:47', NULL, 1, '1'),
(19, 'fdsfdsf', NULL, 'fdsfdsf', 'fdf f fdsf fdsfdsf fsdf fd', '', 0, NULL, '9865453215', '', 'rrrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, NULL, '2018-08-22 12:34:11', 1, '2018-09-05 17:45:15', NULL, 1, '1'),
(20, 'vendor 007', NULL, 'vendor 007', 'vendor 007', '', 0, NULL, '9513541232', '', 'v007@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', NULL, NULL, NULL, '2018-09-14 11:48:21', 4, '2018-10-05 14:09:33', NULL, 1, '1'),
(21, 'test new vendor', NULL, 'vendor one', 'vendor one', '', 0, NULL, '9856321245', '', 'rrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'fdfdf', '15,18', NULL, '2018-09-19 12:31:59', 1, '2018-10-05 14:08:41', NULL, 1, '1'),
(22, 'test vendor', NULL, 'vendor 2', 'vendor 2', '', 0, NULL, '9845654565', '', 'rrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'gfgf', '17,18', NULL, '2018-09-19 12:36:02', 1, '2018-10-05 14:08:50', NULL, 1, '1'),
(23, 'test vendor', NULL, 'vendor 2', 'vendor 2', '', 0, NULL, '9845654565', '', 'rrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'gfgf', '17,18', NULL, '2018-09-19 12:36:07', 1, '2018-10-05 14:09:17', NULL, 1, '1'),
(24, 'test vendor', NULL, 'vendor 2', 'vendor 2', '', 0, NULL, '9845654565', '', 'rrr@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'gfgf', '17,18', NULL, '2018-09-19 12:37:54', 1, '2018-10-05 14:09:27', NULL, 1, '1'),
(25, 'tesst vendor 22', NULL, 'tesst vendor 22', 'tesst vendor 22', '', 0, NULL, '9845654565', '', 'test121@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'dsfdsf', '21,20', '123459999', '2018-10-05 09:29:46', 4, '2018-10-05 14:07:29', NULL, 1, '0'),
(26, 'tesrgdfg', NULL, 'tesrgdfg', 'tesrgdfg', '', 0, NULL, '9845654565', '', 'test@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'gdfgdfg', '21,20', '123451111', '2018-10-05 09:38:52', 4, '2018-10-05 14:07:21', NULL, 1, '0'),
(27, 'ryty', NULL, 'yty', 'ytyt', '', 0, NULL, '9845654565', '', 'ttt@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'fdsfdsf', '21', NULL, '2018-10-05 10:15:08', 4, '2018-10-05 14:07:12', NULL, 1, '0'),
(28, 'fdf', NULL, 'dfds', 'fdsf', '', 0, NULL, '9845654565', '', 'tt123@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'sadsad', '', NULL, '2018-10-05 10:29:55', 4, '2018-10-05 14:07:04', NULL, 1, '1'),
(29, 'dfdfds', NULL, 'fdsf', 'fdsf', '', 0, NULL, '9845654565', '', 'test@gmail.com', 'MAHARASHATRA', 'INDIA', '', '', '', NULL, '', '', 'fdsff', '14', NULL, '2018-10-05 10:42:20', 4, '2018-10-05 14:06:58', NULL, 1, '1');

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
(18, 19, 3, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 12:35:21', 1, NULL, NULL, '0'),
(19, 19, 4, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 12:35:21', 1, NULL, NULL, '0'),
(20, 19, 38, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 12:35:53', 1, NULL, NULL, '0'),
(22, 10, 3, 'supp_4471269', 0, 2, 0, 0, 0, '2018-08-22 15:09:00', 1, '2018-10-12 11:03:37', 4, '0'),
(23, 10, 4, 'supp_S0182222222', 0, 2, 0, 0, 0, '2018-08-22 15:09:00', 1, '2018-10-12 11:03:37', 4, '0'),
(24, 10, 16, NULL, NULL, NULL, NULL, NULL, 0, '2018-08-22 15:09:24', 1, NULL, NULL, '0'),
(31, 7, 3, 'sup_4471269', 1200, 2, 11, 12, 13, '2018-08-23 09:31:03', 1, '2018-10-12 10:58:28', 4, '0'),
(32, 7, 16, 'sup_0215538791', 356, 9, 5, 16, 14, '2018-08-23 09:31:03', 1, '2018-08-29 17:01:12', 1, '0'),
(33, 7, 18, 'sup_3540C/3541C', 545, 2, 1, 11, 12, '2018-08-23 10:49:31', 1, '2018-10-12 10:58:28', 4, '0'),
(34, 7, 19, 'sup_0217006201', 4545, 3, 1, 11, 12, '2018-08-23 10:49:31', 1, '2018-10-12 10:58:28', 4, '0'),
(35, 7, 4, 'supp_S0188888', 0, 2, 0, 0, 0, '2018-08-23 11:00:57', 1, '2018-10-12 10:58:28', 4, '0'),
(36, 7, 17, 'supp_0215757401', 0, 4, 0, 0, 0, '2018-08-23 11:00:57', 1, '2018-10-12 10:58:28', 4, '0'),
(37, 7, 28, 'supp_10416-014', 0, 2, 0, 0, 0, '2018-08-23 11:39:38', 1, '2018-10-12 10:58:28', 4, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_supplier_quotation_bid`
--

CREATE TABLE `erp_supplier_quotation_bid` (
  `quotation_id` int(11) NOT NULL,
  `quo_req_id` int(11) DEFAULT NULL,
  `vendor_panal_quotation_id` int(11) DEFAULT NULL,
  `quotation_number` varchar(255) DEFAULT NULL,
  `bid_date` date DEFAULT NULL COMMENT 'bid received date',
  `dep_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `total_cgst` float DEFAULT NULL,
  `total_sgst` float DEFAULT NULL,
  `total_igst` float DEFAULT NULL,
  `other_amt` float DEFAULT NULL,
  `total_amt` float DEFAULT NULL,
  `status_purchase` varchar(255) DEFAULT NULL,
  `approval_by_purchase` int(11) DEFAULT NULL,
  `status_account` varchar(255) DEFAULT NULL,
  `approval_by_account` int(11) DEFAULT NULL,
  `note_by_vendor` text,
  `quotation_file` text,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_by_vender` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_supplier_quotation_bid`
--

INSERT INTO `erp_supplier_quotation_bid` (`quotation_id`, `quo_req_id`, `vendor_panal_quotation_id`, `quotation_number`, `bid_date`, `dep_id`, `supplier_id`, `credit_days`, `total_price`, `total_cgst`, `total_sgst`, `total_igst`, `other_amt`, `total_amt`, `status_purchase`, `approval_by_purchase`, `status_account`, `approval_by_account`, `note_by_vendor`, `quotation_file`, `created`, `created_by`, `created_by_vender`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 17, 1, 'Quotation/2018/36', '2018-10-23', 19, 7, 40, 96, 11.52, 11.52, 11.52, 10, 140.56, 'approved', 4, 'approved', 6, NULL, 'http://localhost/vendor_erp/upload/quotation/alfa_engineering_1540295531_546.pdf', '2018-10-23 17:22:54', NULL, 7, '2018-10-23 17:38:09', 6, '0'),
(2, 16, 2, 'Quotation/2018/37', '2018-10-23', 20, 7, 40, 55.2, 6.62, 6.62, 6.62, 0, 75.06, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-23 17:55:25', NULL, 7, NULL, NULL, '0'),
(3, 16, 3, 'Quotation/2018/38', '2018-10-23', 20, 25, 40, 69, 8.28, 8.28, 8.28, 0, 93.84, NULL, NULL, 'approved', 6, 'test note.', NULL, '2018-10-23 17:58:16', NULL, 25, '2018-10-24 12:44:34', 6, '0'),
(4, 16, 4, 'Quotation/2018/39', '2018-10-23', 20, 26, 40, 30, 0, 0, 0, 0, 30, 'approved', 4, 'approved', 6, NULL, 'http://localhost/vendor_erp/upload/quotation/tesrgdfg.pdf', '2018-10-23 18:02:28', NULL, 26, '2018-10-24 12:45:22', 6, '0'),
(5, 14, 5, 'Quotation/2018/40', '2018-10-24', 20, 7, 40, 244, 29.28, 24.4, 0, 12, 309.68, 'approved', 4, 'approved', 6, NULL, NULL, '2018-10-24 09:28:04', NULL, 7, '2018-10-29 14:46:28', 4, '0'),
(6, 6, 6, 'Quotation/2018/41', '2018-10-24', 21, 6, 40, 342, 41.04, 41.04, 23.76, 0, 447.84, 'approved', 4, 'approved', 6, 'test note.', 'http://localhost/vendor_erp/upload/quotation/alps_engineering_1540370959_237.pdf', '2018-10-24 14:20:01', NULL, 6, '2018-10-24 14:44:51', 6, '0'),
(7, 20, 7, 'Quotation/2018/42', '2018-10-25', 17, 6, 40, 186, 12.12, 6.3, 13.02, 12, 229.44, 'approved', 4, 'approved', 6, NULL, NULL, '2018-10-25 10:32:05', NULL, 6, '2018-10-25 11:34:59', 6, '0');

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
  `availability` enum('available','not_available') NOT NULL DEFAULT 'available',
  `substitute_material` varchar(355) DEFAULT NULL,
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
  `status` enum('approval','pending') NOT NULL DEFAULT 'pending',
  `created` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_by_vender` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_supplier_quotation_bid_details`
--

INSERT INTO `erp_supplier_quotation_bid_details` (`id`, `quotation_id`, `quo_req_id`, `supplier_id`, `unit_id`, `mat_id`, `availability`, `substitute_material`, `quo_rate`, `quo_qty`, `quo_price`, `expire_date`, `cgst_per`, `cgst_amt`, `sgst_per`, `sgst_amt`, `igst_per`, `igst_amt`, `discount`, `discount_per`, `status`, `created`, `created_by`, `created_by_vender`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 1, 17, 7, 2, 26, 'available', '', 12, 8, 96, '2018-11-16', 12, 11.52, 12, 11.52, 12, 11.52, 0, 0, 'approval', '2018-10-23 17:22:54', NULL, 7, '2018-10-23 17:36:58', 4, '0'),
(2, 2, 16, 7, 2, 18, 'available', '', 23, 3, 55.2, '2018-11-30', 12, 6.62, 12, 6.62, 12, 6.62, 0, 20, 'pending', '2018-10-23 17:55:25', NULL, 7, NULL, NULL, '0'),
(3, 3, 16, 25, 2, 18, 'available', '', 23, 3, 69, '2018-11-23', 12, 8.28, 12, 8.28, 12, 8.28, 0, 0, 'pending', '2018-10-23 17:58:16', NULL, 25, NULL, NULL, '0'),
(4, 4, 16, 26, 2, 18, 'available', '', 10, 3, 30, '2018-11-23', 0, 0, 0, 0, 0, 0, 0, 0, 'approval', '2018-10-23 18:02:28', NULL, 26, '2018-10-24 12:42:03', 4, '0'),
(5, 5, 14, 7, 2, 3, 'available', '', 122, 2, 244, '2018-11-30', 12, 29.28, 10, 24.4, 0, 0, 0, 0, 'approval', '2018-10-24 09:28:04', NULL, 7, '2018-10-29 14:44:38', 4, '0'),
(6, 6, 6, 6, 2, 3, 'available', '', 9, 2, 18, '2018-10-25', 12, 2.16, 12, 2.16, 0, 0, 0, 0, 'approval', '2018-10-24 14:20:01', NULL, 6, '2018-10-24 14:40:45', 4, '0'),
(7, 6, 6, 6, 2, 4, 'available', '', 12, 2, 24, '2018-11-22', 12, 2.88, 12, 2.88, 0, 0, 0, 0, 'approval', '2018-10-24 14:20:01', NULL, 6, '2018-10-24 14:40:45', 4, '0'),
(8, 6, 6, 6, 2, 17, 'available', '', 24, 3, 72, '2018-11-30', 12, 8.64, 12, 8.64, 0, 0, 0, 0, 'approval', '2018-10-24 14:20:02', NULL, 6, '2018-10-24 14:40:45', 4, '0'),
(9, 6, 6, 6, 2, 18, 'available', '', 10, 3, 30, '2018-12-14', 12, 3.6, 12, 3.6, 0, 0, 0, 0, 'pending', '2018-10-24 14:20:02', NULL, 6, NULL, NULL, '0'),
(10, 6, 6, 6, 2, 19, 'available', '', 44, 3, 132, '2018-11-16', 12, 15.84, 12, 15.84, 12, 15.84, 0, 0, 'pending', '2018-10-24 14:20:02', NULL, 6, NULL, NULL, '0'),
(11, 6, 6, 6, 2, 21, 'available', '', 22, 3, 66, '2018-11-29', 12, 7.92, 12, 7.92, 12, 7.92, 0, 0, 'pending', '2018-10-24 14:20:02', NULL, 6, NULL, NULL, '0'),
(12, 7, 20, 6, 2, 19, 'available', '', 3, 6, 18, '2018-11-22', 6, 1.08, 7, 1.26, 7, 1.26, 0, 0, 'approval', '2018-10-25 10:32:05', NULL, 6, '2018-10-25 11:34:16', 4, '0'),
(13, 7, 20, 6, 2, 22, 'available', '', 12, 6, 72, '2018-11-22', 6, 4.32, 7, 5.04, 7, 5.04, 0, 0, 'approval', '2018-10-25 10:32:05', NULL, 6, '2018-10-25 11:34:16', 4, '0'),
(14, 7, 20, 6, 2, 26, 'available', '', 12, 8, 96, '2018-11-09', 7, 6.72, 0, 0, 7, 6.72, 0, 0, 'approval', '2018-10-25 10:32:05', NULL, 6, '2018-10-25 11:34:16', 4, '0');

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
('By Courier');

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
-- Table structure for table `erp_user_activities`
--

CREATE TABLE `erp_user_activities` (
  `id` int(11) NOT NULL,
  `modules` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activities` text,
  `activitity_date` date DEFAULT NULL,
  `activitity_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(4, 'nileshk', 'purchase@datarpgx.com', '$2y$10$jA8s9kreBiRtVgDRqOa4Se.aRU9LFLHLye9KuDh/YVUvVuqtDBpES', 'Nilesh Kakad', '9856545654', 4, 21, '["category-add_new_category", "category-edit_category", "dashboard-all_purchase_order", "dashboard-approved_po_count", "dashboard-approved_quotation", "dashboard-approved_requisation_count", "dashboard-completed_po_count", "dashboard-completed_requisation_count", "dashboard-pending_po_count", "dashboard-pending_requisation_count", "dashboard-place_new_purchase_order", "dashboard-place_new_requisition", "dashboard-po_count", "dashboard-quotation_count", "dashboard-received_quotation", "dashboard-request_quotation", "dashboard-requisition_count", "dashboard-vendor_count", "dashboard-view_all_requisition", "material-add_new_material", "material-edit_material", "material-export_material", "material_requisition-add_new", "material_requisition-approved_requisition", "material_requisition-completed_requisition", "material_requisition-material_notes_view_edit", "material_requisition-pending_requisition", "material_requisition-view_edit", "material_requisition-view_materials", "PurchaseOrder-add_new_po_button", "PurchaseOrder-approval_flag", "PurchaseOrder-approved_purchase_order", "PurchaseOrder-approved_purchase_order_view", "PurchaseOrder-completed_purchase_order", "PurchaseOrder-completed_purchase_order_view", "PurchaseOrder-pending_purchase_order", "PurchaseOrder-pending_purchase_order_delete", "PurchaseOrder-pending_purchase_order_edit", "PurchaseOrder-prepare_po_quotation", "PurchaseOrder-prepare_po_requisition", "quotation-approved_disapproved_button", "quotation-approved_quotations_list", "quotation-pending_quotations_list", "quotation-prepare_purchase_order_button", "quotation-purchase_approval_status", "quotation-quotations_list", "quotation-send_quotation_request", "quotation-view_quotation_details", "units-add_new_unit", "units-edit_unit", "units-export_unit", "vendor-add_new_vendor", "vendor-edit_tab", "vendor-edit_vendor", "vendor-export_details", "vendor-invoice_tab", "vendor-material_tab", "vendor-payments_tab", "vendor-purchase_order_tab", "vendor-quotation_tab"]', 0, 1, '2018-08-31 12:56:03', 1, '2018-11-02 15:05:59'),
(5, 'umeshw', 'umesh@datar.com', '$2y$10$1PJftok/tA9shp8i6lpkreVDzj0edt9e5Grpgd76gudYFM.wi/mi2', 'Umesh Wakalekar', '9845325845', 4, 20, NULL, 0, 1, '2018-09-05 18:07:31', NULL, NULL),
(6, 'account_user', 'account@datarpgx.com', '$2y$10$RjNXnlyNMmtrmFGY4C8GSeXuLgKJDopZsMkjRUSC1u5bI9Stxy.uq', 'Account User', '5475321458', 4, 24, '["dashboard-po_count", "dashboard-quotation_count", "dashboard-requisition_count", "material_requisition-add_new", "material_requisition-approved_requisition", "material_requisition-completed_requisition", "material_requisition-material_notes_view_edit", "material_requisition-pending_requisition", "material_requisition-view_edit", "material_requisition-view_materials", "quotation-accounts_approval_status", "quotation-approved_quotations_list", "quotation-pending_quotations_list", "quotation-quotations_list", "quotation-view_quotation_details"]', 0, 1, '2018-10-08 12:20:22', 1, '2018-10-23 10:37:05');

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
(6, 'sybKgTXdl9oaIrMOczU6G7NkAqYhF1', '::1', '2018-10-08 12:23:59', '2018-10-08 12:23:59', NULL),
(6, 'tkaB8TsJ205yLIgSlOEpxhX4GVFfzC', '::1', '2018-10-08 12:23:59', '2018-10-08 12:23:59', NULL),
(6, '5hibK0jmPnkUplGAswO1q4eZxzdTy3', '::1', '2018-10-09 09:53:55', '2018-10-09 09:53:55', NULL),
(6, 'wKoX2eQlmiz7StcVdqp5vPJAGsxk3E', '::1', '2018-10-09 09:53:55', '2018-10-09 09:53:55', NULL),
(6, 'XhdzbeonTAgaRO0D9ImPvwu2FcKMJi', '::1', '2018-10-09 12:35:08', '2018-10-09 12:35:08', NULL),
(6, 'srFDQNginy8wafu7O52UbZR4zYeEMH', '::1', '2018-10-09 12:35:08', '2018-10-09 12:35:08', NULL),
(6, '2uACLBU9NIM34tRDsKb5fz8GS7rpPO', '::1', '2018-10-10 14:00:57', '2018-10-10 14:00:57', NULL),
(6, '5rQwKgUnEl7SNjzed9PtVcHM2piasq', '::1', '2018-10-10 14:00:57', '2018-10-10 14:00:57', NULL),
(6, 'O7nYxTtLZma3SWv4A9E125UzRQopwC', '::1', '2018-10-11 09:29:34', '2018-10-11 09:29:34', NULL),
(6, 'ogTPiZ8Mkr4O3mVAplRYe25KwStuDI', '::1', '2018-10-11 09:29:34', '2018-10-11 09:29:34', NULL),
(6, 'ZtmHE87SaJ3K9h6vzBnlG1Up5bNOcs', '::1', '2018-10-23 10:29:34', '2018-10-23 10:29:34', NULL),
(6, 'R7eZ8bBYsLD5jp0mrWz61CcwOvyVKJ', '::1', '2018-10-23 10:29:34', '2018-10-23 10:29:34', NULL),
(6, 'G1FvHSly2m3BJLqPCh0YID4wTefsgk', '::1', '2018-10-23 15:42:02', '2018-10-23 15:42:02', NULL),
(6, '49pXWUYJrgOjibEBlfLcsAPN3htHnw', '::1', '2018-10-23 15:42:03', '2018-10-23 15:42:03', NULL),
(6, 'ZV6mvT1C3rkO5JYoWye2PSuRA7UxLi', '::1', '2018-10-24 11:36:56', '2018-10-24 11:36:56', NULL),
(6, 'zQ1G8bc7wriP5E2ovOKMlTqygUnNVm', '::1', '2018-10-24 11:36:56', '2018-10-24 11:36:56', NULL),
(6, 'HaglFAETSZP0zKmC37fnIcjMieX4Oo', '::1', '2018-10-25 11:32:53', '2018-10-25 11:32:53', NULL),
(6, '8z70BXxgoVKGn5tMkAUifNCcqJ9s6Z', '::1', '2018-10-25 11:32:53', '2018-10-25 11:32:53', NULL),
(4, 'nhZTsYaWl0ApC7DvIGRkOomQ942B1w', '::1', '2018-10-29 09:29:21', '2018-10-29 09:29:21', NULL),
(4, 'hVLFf0UMZO2yq7xA83zBGbRnPYwCiK', '::1', '2018-10-29 09:29:21', '2018-10-29 09:29:21', NULL),
(4, '65DKLUuzNlRmby3JHXtoC0PigVZvQT', '::1', '2018-10-29 09:30:01', '2018-10-29 09:30:01', NULL),
(4, 'a1LU0zMw5XENiWljDFpYR3qKPZur2m', '::1', '2018-10-29 09:30:01', '2018-10-29 09:30:01', NULL),
(1, '41LPqQ3bIXmNvhigUnHaFk8WYldwzV', '::1', '2018-10-29 11:40:55', '2018-10-29 11:40:55', NULL),
(1, 'a6XSLbDfzs4tw30iQmWpjCo9OdgVvG', '::1', '2018-10-29 11:40:55', '2018-10-29 11:40:55', NULL),
(6, 'f57UHwnAvNKpk4I02xBuQOLF9rVlb8', '::1', '2018-10-29 14:45:11', '2018-10-29 14:45:11', NULL),
(6, '3dYCGzbJr95eaXlUPMEZAsmWj7icBF', '::1', '2018-10-29 14:45:12', '2018-10-29 14:45:12', NULL),
(4, 'qgZU4djTklA8FywWaroHfQJ7biB9KR', '::1', '2018-10-30 09:17:06', '2018-10-30 09:17:06', NULL),
(4, '0DXligdWR936nrOImey8SjZfHFCPJN', '::1', '2018-10-30 09:17:06', '2018-10-30 09:17:06', NULL),
(1, 'zKV8nSvOqXrtgcFZNJ4D9mGE1y07CT', '::1', '2018-10-30 10:24:01', '2018-10-30 10:24:01', NULL),
(1, '8VuEUdjhw7JiZzHaXLmCbPsAfBkg0y', '::1', '2018-10-30 10:24:01', '2018-10-30 10:24:01', NULL),
(4, 'u8BDTcl0n7ioJzRhFkX2Qmv19w3ZpV', '::1', '2018-10-31 09:11:33', '2018-10-31 09:11:33', NULL),
(4, 'tS9rCK3e5mIu0csZMXOyvJUYFhqknf', '::1', '2018-10-31 09:11:33', '2018-10-31 09:11:33', NULL),
(1, 'Fcop95JX6BZUvmxbO4aCTdligHtYV2', '::1', '2018-10-31 11:09:48', '2018-10-31 11:09:48', NULL),
(1, 'n8fepmzdZr7ASRWOGKEFIDCqxkPaXL', '::1', '2018-10-31 11:09:48', '2018-10-31 11:09:48', NULL),
(4, '8IjO3YFZlTUuACr5tEfcSD9sq7bkJQ', '::1', '2018-11-01 08:32:07', '2018-11-01 08:32:07', NULL),
(4, '7IWpOAJPfFb0YnShTuQ3wcmBGaEkld', '::1', '2018-11-01 08:32:07', '2018-11-01 08:32:07', NULL),
(4, 'OU7uzEZNwMxgs52d3WycBmqtkePnFj', '::1', '2018-11-02 09:14:33', '2018-11-02 09:14:33', NULL),
(4, '3DQS1nehCbpkgdOtKH52aImlc4UNrB', '::1', '2018-11-02 09:14:33', '2018-11-02 09:14:33', NULL),
(4, '2NzeOYrZu59nlpoPIdjLqW4aUsfmDx', '::1', '2018-11-02 11:58:24', '2018-11-02 11:58:24', NULL),
(4, 'mRH1CJqYfOAda9TQVhpGvXkNtyB2ls', '::1', '2018-11-02 11:58:24', '2018-11-02 11:58:24', NULL),
(4, '15E6GUNRqKhY7jSFdaDsmHogOBZLnr', '::1', '2018-11-02 12:01:33', '2018-11-02 12:01:33', NULL),
(4, 'ElxSOGbwecgKD3qj752fA14FrHmvI6', '::1', '2018-11-02 12:01:33', '2018-11-02 12:01:33', NULL),
(4, 'aK7jsOwVy5JU9RGeHrFkh3fEixNB2Q', '::1', '2018-11-02 12:03:33', '2018-11-02 12:03:33', NULL),
(4, 'Kxri1kqj0URcXo396LPATgMdBlVsmb', '::1', '2018-11-02 12:03:33', '2018-11-02 12:03:33', NULL),
(4, 'T9kcU3E2NL0YSH4Ranv8JuIwDzsd5p', '::1', '2018-11-02 12:55:41', '2018-11-02 12:55:41', NULL),
(4, '03BnSwY7P6WHabfk5vFJMXR1eNmKjt', '::1', '2018-11-02 12:55:41', '2018-11-02 12:55:41', NULL),
(1, 'Ni1Jqk4xlG82YSDCUR0LZX6HmWKbVO', '::1', '2018-11-02 15:05:15', '2018-11-02 15:05:15', NULL),
(1, 'wYanJKUvseh31g4iA9kZVmut2MpCqj', '::1', '2018-11-02 15:05:15', '2018-11-02 15:05:15', NULL),
(4, 'l3onhfu7R2Hv9DpFxJPqNbtjQKzLYy', '::1', '2018-11-05 09:13:45', '2018-11-05 09:13:45', NULL),
(4, 'L1krs96RtXvbQhAxHYfl4wVTqGZOFp', '::1', '2018-11-05 09:13:45', '2018-11-05 09:13:45', NULL),
(4, '3vHVZBcAQg2iorDFEU6YJmqae5SnOR', '::1', '2018-11-05 11:31:41', '2018-11-05 11:31:41', NULL),
(4, 'RgN5L7HUCfKndem6j9opzAEu3hqGPy', '::1', '2018-11-05 11:31:41', '2018-11-05 11:31:41', NULL);

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
-- Indexes for table `erp_material_inwards`
--
ALTER TABLE `erp_material_inwards`
  ADD PRIMARY KEY (`inward_id`);

--
-- Indexes for table `erp_material_inward_details_draft`
--
ALTER TABLE `erp_material_inward_details_draft`
  ADD PRIMARY KEY (`inward_draft_id`);

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
-- Indexes for table `erp_user_activities`
--
ALTER TABLE `erp_user_activities`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
-- AUTO_INCREMENT for table `erp_material_inwards`
--
ALTER TABLE `erp_material_inwards`
  MODIFY `inward_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `erp_material_inward_details_draft`
--
ALTER TABLE `erp_material_inward_details_draft`
  MODIFY `inward_draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `erp_material_master`
--
ALTER TABLE `erp_material_master`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `erp_material_quotation_draft`
--
ALTER TABLE `erp_material_quotation_draft`
  MODIFY `quo_draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `erp_material_quotation_request`
--
ALTER TABLE `erp_material_quotation_request`
  MODIFY `quo_req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `erp_material_quotation_request_details`
--
ALTER TABLE `erp_material_quotation_request_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
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
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `erp_permission_keys`
--
ALTER TABLE `erp_permission_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `erp_purchase_order`
--
ALTER TABLE `erp_purchase_order`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `erp_purchase_order_details`
--
ALTER TABLE `erp_purchase_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `erp_purchase_order_details_draft`
--
ALTER TABLE `erp_purchase_order_details_draft`
  MODIFY `po_draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;
--
-- AUTO_INCREMENT for table `erp_sub_categories`
--
ALTER TABLE `erp_sub_categories`
  MODIFY `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;
--
-- AUTO_INCREMENT for table `erp_supplier`
--
ALTER TABLE `erp_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `erp_supplier_materials`
--
ALTER TABLE `erp_supplier_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `erp_supplier_quotation_bid`
--
ALTER TABLE `erp_supplier_quotation_bid`
  MODIFY `quotation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `erp_supplier_quotation_bid_details`
--
ALTER TABLE `erp_supplier_quotation_bid_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `erp_unit_master`
--
ALTER TABLE `erp_unit_master`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `erp_user_activities`
--
ALTER TABLE `erp_user_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
