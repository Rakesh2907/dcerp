-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2018 at 12:46 PM
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
  `quotation_number` varchar(255) DEFAULT NULL,
  `outward_number` varchar(355) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_auto_increament`
--

INSERT INTO `erp_auto_increament` (`id`, `material_requisation_number`, `quotation_request_number`, `material_unique_number`, `po_number`, `quotation_number`, `outward_number`) VALUES
(1, '000021', '000027', 'DCGL/34', 'DCGL/2018/59', 'Quotation/2018/42', 'Outward/2018/14');

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
(8, '8', 'LOCAL ITEMS', 'material_po', 'consumable', '2018-08-11 07:21:22', 4, '2018-11-26 14:33:16', 1, '0'),
(9, '9', 'INSTALLATIONS & SERVICES', 'general_po', 'non_consumable', '2018-08-11 07:25:35', 1, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_custom_duty`
--

CREATE TABLE `erp_custom_duty` (
  `custom_duty` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('4-6 weeks'),
('5-6 weeks'),
('10-12 weeks');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `invoice_date` date DEFAULT NULL,
  `invoice_number` varchar(355) DEFAULT NULL,
  `chalan_date` date DEFAULT NULL,
  `chalan_number` varchar(355) DEFAULT NULL,
  `gate_entry_date` date DEFAULT NULL,
  `gate_entry_number` varchar(355) DEFAULT NULL,
  `grn_date` date DEFAULT NULL,
  `grn_number` varchar(355) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `state_code` int(11) DEFAULT NULL,
  `currency` varchar(355) DEFAULT NULL,
  `total_amt` float DEFAULT NULL,
  `total_cgst` float DEFAULT NULL,
  `total_sgst` float DEFAULT NULL,
  `total_igst` float DEFAULT NULL,
  `freight_amt` float DEFAULT NULL,
  `other_amt` float DEFAULT NULL,
  `total_bill_amt` float DEFAULT NULL,
  `rounded_amt` float DEFAULT NULL,
  `invoice_file` text,
  `remark` text,
  `inward_form` varchar(455) DEFAULT NULL,
  `payment_status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_inwards`
--

INSERT INTO `erp_material_inwards` (`inward_id`, `invoice_date`, `invoice_number`, `chalan_date`, `chalan_number`, `gate_entry_date`, `gate_entry_number`, `grn_date`, `grn_number`, `vendor_id`, `po_id`, `cat_id`, `state_code`, `currency`, `total_amt`, `total_cgst`, `total_sgst`, `total_igst`, `freight_amt`, `other_amt`, `total_bill_amt`, `rounded_amt`, `invoice_file`, `remark`, `inward_form`, `payment_status`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, '2018-12-06', 'INVOICE-', '2018-12-06', 'CHALAN-', '2018-12-06', 'GATE-', '2018-12-06', 'GRN-', 6, 2, NULL, 0, 'RS', 84, 5.4, 3.36, 5.88, 0, 0, 98.64, 0, 'http://localhost/erp/upload/invoice/invoice_1544034600.pdf', '', 'material_inward_form', 'unpaid', '2018-12-06 15:25:56', 4, '2018-12-06 15:30:50', 4, '0'),
(2, '2018-12-06', 'INVOICE-', '2018-12-06', 'CHALAN-', '2018-12-06', 'GATE-', '2018-12-06', 'GRN-', 11, 6, NULL, 0, 'RS', 72, 0, 0, 0, 0, 0, 72, 0, 'http://localhost/erp/upload/invoice/invoice_1544034600.pdf', '', 'material_inward_form', 'unpaid', '2018-12-06 15:32:38', 4, '2018-12-07 12:10:16', 4, '0'),
(3, '2018-12-06', 'INVOICE-', '2018-12-06', 'CHALAN-', '2018-12-06', 'GATE-', '2018-12-06', 'GRN-', 6, 2, NULL, 0, 'RS', 78, 5.04, 2.94, 5.46, 0, 0, 91.44, 0, 'http://localhost/erp/upload/invoice/invoice_1544034600.pdf', '', 'material_inward_form', 'unpaid', '2018-12-06 15:39:56', 4, '2018-12-06 15:44:39', 4, '0'),
(4, '2018-12-06', 'INVOICE-', '2018-12-06', 'CHALAN-', '2018-12-06', 'GATE-', '2018-12-06', 'GRN-', 6, 2, NULL, 0, 'RS', 24, 1.68, 0, 1.68, 0, 0, 27.36, 0, 'http://localhost/erp/upload/invoice/invoice_1544034600.pdf', '', 'material_inward_form', 'unpaid', '2018-12-06 15:45:49', 4, '2018-12-06 15:47:02', 4, '0'),
(5, '2018-12-06', 'INVOICE-', '2018-12-06', 'CHALAN-', '2018-12-06', 'GATE-', '2018-12-06', 'GRN-', 2, 7, 9, 27, 'RS', 36, 4.32, 4.32, 4.32, 0, 0, 48.96, 0, 'http://localhost/erp/upload/invoice/invoice_1544034600.pdf', '', 'general_inward_form', 'unpaid', '2018-12-06 15:48:23', 4, '2018-12-06 15:49:39', 4, '0'),
(6, '2018-12-06', 'INVOICE-', '2018-12-06', 'CHALAN-', '2018-12-06', 'GATE-', '2018-12-06', 'GRN-', 7, 3, 3, 27, 'RS', 24, 2.88, 2.88, 2.88, 0, 0, 32.64, 0, 'http://localhost/erp/upload/invoice/invoice_1544034600.pdf', '', 'general_inward_form', 'unpaid', '2018-12-06 15:50:51', 4, '2018-12-06 15:51:33', 4, '0'),
(7, '2018-12-06', 'INVOICE-', '2018-12-06', 'CHALAN-', '2018-12-06', 'GATE-', '2018-12-06', 'GRN-', 7, 3, 3, 27, 'RS', 36, 4.32, 4.32, 4.32, 0, 0, 48.96, 0, 'http://localhost/erp/upload/invoice/invoice_1544034600.pdf', '', 'general_inward_form', 'unpaid', '2018-12-06 15:52:53', 4, '2018-12-06 15:54:59', 4, '0'),
(8, '2018-12-06', 'INVOICE-', '2018-12-06', 'CHALAN-', '2018-12-06', 'GATE-', '2018-12-06', 'GRN-', 25, 26, 3, 0, 'RS', 34, 4.08, 4.08, 0, 0, 0, 42.16, 0, 'http://localhost/erp/upload/invoice/invoice_1544034600.pdf', '', 'general_inward_form', 'unpaid', '2018-12-06 17:12:49', 4, '2018-12-06 17:18:47', 4, '0'),
(9, '2018-12-06', 'INVOICE-', '2018-12-06', 'CHALAN-', '2018-12-06', 'GATE-', '2018-12-06', 'GRN-', 25, 26, 3, 0, 'RS', 360, 43.2, 43.2, 0, 0, 0, 446.4, 0, 'http://localhost/erp/upload/invoice/invoice_1544034600.pdf', '', 'general_inward_form', 'unpaid', '2018-12-06 17:20:34', 4, '2018-12-06 17:23:56', 4, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_inward_batchwise`
--

CREATE TABLE `erp_material_inward_batchwise` (
  `batch_id` int(11) NOT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `sub_mat_id` int(11) DEFAULT NULL,
  `inward_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `bar_code` text,
  `batch_number` varchar(355) DEFAULT NULL,
  `lot_number` varchar(455) DEFAULT NULL,
  `received_qty` float DEFAULT NULL,
  `accepted_qty` float DEFAULT NULL,
  `outward_qty` float NOT NULL DEFAULT '0',
  `expire_date` date DEFAULT NULL,
  `shipping_temp` varchar(355) DEFAULT NULL,
  `storage_temp` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_inward_batchwise`
--

INSERT INTO `erp_material_inward_batchwise` (`batch_id`, `mat_id`, `sub_mat_id`, `inward_id`, `po_id`, `bar_code`, `batch_number`, `lot_number`, `received_qty`, `accepted_qty`, `outward_qty`, `expire_date`, `shipping_temp`, `storage_temp`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 22, NULL, 1, 2, '46994754_02', '46994754_02', '46994754_02', 2, 2, 2, '2019-02-01', 'AT', 'AT', '2018-12-06 15:27:07', 4, NULL, NULL, '0'),
(2, 22, NULL, 1, 2, '01452243_02', '01452243_02', '01452243_02', 2, 2, 2, '2018-12-17', 'AT', '', '2018-12-06 15:27:07', 4, NULL, NULL, '0'),
(3, 26, NULL, 1, 2, '04864104_09', '04864104_09', '04864104_09', 2, 2, 0, '2018-12-12', '', '', '2018-12-06 15:30:29', 4, NULL, NULL, '0'),
(4, 26, NULL, 1, 2, '40010319_09', '40010319_09', '40010319_09', 1, 1, 0, '2019-02-22', '', '', '2018-12-06 15:30:29', 4, NULL, NULL, '0'),
(6, 4, NULL, 2, 6, '41641046_S0', '41641046_S0', '41641046_S0', 1, 1, 1, '2019-03-21', '', '', '2018-12-06 15:36:03', 4, NULL, NULL, '0'),
(7, 4, NULL, 2, 6, '80434543_S0', '80434543_S0', '80434543_S0', 1, 1, 1, '2018-12-28', '', '', '2018-12-06 15:36:03', 4, NULL, NULL, '0'),
(8, 4, NULL, 2, 6, '53067640_S0', '53067640_S0', '53067640_S0', 1, 1, 1, '2019-02-22', '', '', '2018-12-06 15:36:03', 4, NULL, NULL, '0'),
(9, 4, NULL, 2, 6, '49070415_S0', '49070415_S0', '49070415_S0', 1, 1, 1, '2019-02-22', '', '', '2018-12-06 15:36:03', 4, NULL, NULL, '0'),
(10, 22, NULL, 3, 2, '14539144_02', '14539144_02', '14539144_02', 1, 1, 1, '2019-02-08', '', '', '2018-12-06 15:40:34', 4, NULL, NULL, '0'),
(11, 22, NULL, 3, 2, '31341141_02', '31341141_02', '31341141_02', 1, 1, 1, '2019-02-14', '', '', '2018-12-06 15:40:34', 4, NULL, NULL, '0'),
(12, 26, 1, 3, 2, '04141100_09', '04141100_09', '04141100_09', 1, 1, 0, '2019-03-29', '', '', '2018-12-06 15:41:57', 4, NULL, NULL, '0'),
(13, 26, 2, 3, 2, '59335975_09', '59335975_09', '59335975_09', 1, 1, 0, '2019-02-28', '', '', '2018-12-06 15:41:57', 4, NULL, NULL, '0'),
(14, 26, NULL, 3, 2, '47111528_09', '47111528_09', '47111528_09', 1, 1, 0, '2019-02-09', '', '', '2018-12-06 15:41:57', 4, NULL, NULL, '0'),
(15, 19, 5, 3, 2, '41144410_02', '41144410_02', '41144410_02', 1, 1, 1, '2019-02-22', '', '', '2018-12-06 15:43:56', 4, '2018-12-06 15:44:31', 4, '0'),
(19, 19, NULL, 3, 2, '49830183_02', '49830183_02', '49830183_02', 1, 1, 1, '2019-03-16', '', '', '2018-12-06 15:44:31', 4, NULL, NULL, '0'),
(20, 19, NULL, 3, 2, '41415889_02', '41415889_02', '41415889_02', 2, 2, 0, '2019-02-28', '', '', '2018-12-06 15:44:31', 4, NULL, NULL, '0'),
(21, 19, NULL, 3, 2, '19494510_02', '19494510_02', '19494510_02', 1, 1, 1, '2019-02-28', '', '', '2018-12-06 15:44:31', 4, NULL, NULL, '0'),
(22, 19, NULL, 3, 2, '91958555_02', '91958555_02', '91958555_02', 1, 1, 0, '2019-02-28', 'AT', '', '2018-12-06 15:44:31', 4, NULL, NULL, '0'),
(23, 26, 4, 4, 2, '04609961_09', '04609961_09', '04609961_09', 1, 1, 0, '2019-02-22', 'AT', '', '2018-12-06 15:46:52', 4, NULL, NULL, '0'),
(24, 26, NULL, 4, 2, '34143948_09', '34143948_09', '34143948_09', 1, 1, 0, '2019-03-15', '', '', '2018-12-06 15:46:52', 4, NULL, NULL, '0'),
(25, 24, NULL, 5, 7, '51315490_AM', '51315490_AM', '51315490_AM', 1, 1, 0, '2019-03-15', '', '', '2018-12-06 15:49:27', 4, NULL, NULL, '0'),
(26, 24, NULL, 5, 7, '11455553_AM', '11455553_AM', '11455553_AM', 1, 1, 0, '2019-02-28', '', '', '2018-12-06 15:49:27', 4, NULL, NULL, '0'),
(27, 24, NULL, 5, 7, '11447645_AM', '11447645_AM', '11447645_AM', 1, 1, 0, '2019-01-31', 'AT', '', '2018-12-06 15:49:27', 4, NULL, NULL, '0'),
(28, 4, 6, 6, 3, '15565694_S0', '15565694_S0', '15565694_S0', 1, 1, 0, '2019-02-21', 'AT', '', '2018-12-06 15:51:24', 4, NULL, NULL, '0'),
(29, 4, NULL, 6, 3, '17115619_S0', '17115619_S0', '17115619_S0', 1, 1, 0, '2019-02-14', '', '', '2018-12-06 15:51:24', 4, NULL, NULL, '0'),
(30, 44, NULL, 7, 3, '04841455_te', '04841455_te', '04841455_te', 1, 1, 0, '2019-02-14', '', '', '2018-12-06 15:54:50', 4, NULL, NULL, '0'),
(31, 44, NULL, 7, 3, '44575041_te', '44575041_te', '44575041_te', 2, 2, 0, '2019-02-28', 'AT', 'AT', '2018-12-06 15:54:50', 4, NULL, NULL, '0'),
(32, 57, NULL, 8, 26, '91024642_11', '91024642_11', '91024642_11', 1, 1, 0, '2018-12-14', 'AT', '', '2018-12-06 17:17:59', 4, NULL, NULL, '0'),
(35, 62, NULL, 9, 26, '14145465_17', '14145465_17', '14145465_17', 2, 2, 0, '2019-02-16', '', '', '2018-12-06 17:23:46', 4, NULL, NULL, '0'),
(36, 62, NULL, 9, 26, '35425153_17', '35425153_17', '35425153_17', 2, 2, 0, '2019-02-28', '', '', '2018-12-06 17:23:46', 4, NULL, NULL, '0'),
(40, 57, NULL, 9, 26, '70294364_11', '70294364_11', '70294364_11', 2, 2, 0, '2019-02-21', '', '', '2018-12-06 17:27:01', 4, NULL, NULL, '0'),
(41, 57, NULL, 9, 26, '71474110_11', '71474110_11', '71474110_11', 2, 2, 0, '2019-02-22', '', '', '2018-12-06 17:27:01', 4, NULL, NULL, '0'),
(42, 57, NULL, 9, 26, '34711735_11', '34711735_11', '34711735_11', 1, 1, 0, '2019-02-28', '', '', '2018-12-06 17:27:01', 4, NULL, NULL, '1'),
(43, 3, NULL, 2, 6, '40327144_44', '40327144_44', '40327144_44', 1, 1, 1, '2019-03-14', 'AT', '', '2018-12-07 12:10:02', 4, NULL, NULL, '0'),
(44, 3, NULL, 2, 6, '34601304_44', '34601304_44', '34601304_44', 1, 1, 1, '2019-02-21', 'AT', '', '2018-12-07 12:10:02', 4, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_inward_details`
--

CREATE TABLE `erp_material_inward_details` (
  `inward_details_id` int(11) NOT NULL,
  `inward_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `hsn_code` varchar(355) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `po_qty` float DEFAULT NULL,
  `pre_rec_qty` int(11) DEFAULT NULL,
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
  `igst_amt` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_inward_details`
--

INSERT INTO `erp_material_inward_details` (`inward_details_id`, `inward_id`, `po_id`, `mat_id`, `hsn_code`, `unit_id`, `rate`, `po_qty`, `pre_rec_qty`, `received_qty`, `rejected_qty`, `discount_per`, `discount`, `mat_amount`, `cgst_per`, `cgst_amt`, `sgst_per`, `sgst_amt`, `igst_per`, `igst_amt`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(1, 1, 2, 22, '1232311', 2, 12, 6, 0, 4, 0, 0, 0, 48, 6, 2.88, 7, 3.36, 7, 3.36, '2018-12-06 15:25:56', 4, '2018-12-06 15:30:50', 4),
(2, 1, 2, 26, '423434', 3, 12, 8, 0, 3, 0, 0, 0, 36, 7, 2.52, 0, 0, 7, 2.52, NULL, NULL, '2018-12-06 15:30:50', 4),
(3, 2, 6, 3, '', 2, 12, 2, 0, 2, 0, 0, 0, 24, 0, 0, 0, 0, 0, 0, '2018-12-06 15:32:38', 4, '2018-12-07 12:10:16', 4),
(4, 2, 6, 4, '', 2, 12, 4, 0, 4, 0, 0, 0, 48, 0, 0, 0, 0, 0, 0, '2018-12-06 15:32:38', 4, '2018-12-07 12:10:16', 4),
(5, 3, 2, 22, '1232311', 2, 12, 6, 4, 2, 0, 0, 0, 24, 6, 1.44, 7, 1.68, 7, 1.68, '2018-12-06 15:39:56', 4, '2018-12-06 15:44:39', 4),
(6, 3, 2, 26, '423434', 3, 12, 8, 3, 3, 0, 0, 0, 36, 7, 2.52, 0, 0, 7, 2.52, '2018-12-06 15:39:56', 4, '2018-12-06 15:44:39', 4),
(7, 3, 2, 19, '343243', 2, 3, 6, 0, 6, 0, 0, 0, 18, 6, 1.08, 7, 1.26, 7, 1.26, '2018-12-06 15:39:56', 4, '2018-12-06 15:44:39', 4),
(8, 4, 2, 26, '423434', 3, 12, 8, 6, 2, 0, 0, 0, 24, 7, 1.68, 0, 0, 7, 1.68, '2018-12-06 15:45:49', 4, '2018-12-06 15:47:02', 4),
(9, 5, 7, 24, '', 2, 12, 3, 0, 3, 0, 0, 0, 36, 12, 4.32, 12, 4.32, 12, 4.32, '2018-12-06 15:48:23', 4, '2018-12-06 15:49:39', 4),
(10, 6, 3, 4, '12323', 2, 12, 2, 0, 2, 0, 0, 0, 24, 12, 2.88, 12, 2.88, 12, 2.88, '2018-12-06 15:50:51', 4, '2018-12-06 15:51:33', 4),
(11, 7, 3, 44, '543543', 2, 12, 3, 0, 3, 0, 0, 0, 36, 12, 4.32, 12, 4.32, 12, 4.32, '2018-12-06 15:52:53', 4, '2018-12-06 15:54:59', 4),
(12, 8, 26, 57, '75676', 3, 34, 5, 4, 1, 0, 0, 0, 34, 12, 4.08, 12, 4.08, 0, 0, '2018-12-06 17:12:49', 4, '2018-12-06 17:18:47', 4),
(13, 9, 26, 62, '45435', 6, 56, 10, 0, 4, 0, 0, 0, 224, 12, 26.88, 12, 26.88, 0, 0, '2018-12-06 17:20:34', 4, '2018-12-06 17:23:56', 4),
(14, 9, 26, 57, '75676', 3, 34, 5, 1, 4, 0, 0, 0, 136, 12, 16.32, 12, 16.32, 0, 0, '2018-12-06 17:20:34', 4, '2018-12-06 17:23:56', 4);

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
  `pre_rec_qty` float DEFAULT NULL,
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
  `closing_stock` float DEFAULT NULL,
  `mat_rate2` float DEFAULT NULL,
  `prod_type` varchar(255) DEFAULT NULL,
  `total_stock` float DEFAULT NULL,
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

INSERT INTO `erp_material_master` (`mat_id`, `unique_number`, `mat_code`, `mat_name`, `mat_details`, `mat_rate`, `cat_id`, `sub_cat_id`, `mat_parent_id`, `parent_mat_code`, `parent_mat_name`, `make`, `unit_id`, `opening_stock`, `current_stock`, `as_on_date`, `minimum_level`, `reorder_qty`, `mat_length`, `mat_weight`, `weight_unit_id`, `location_id`, `tolerance`, `length_unit_id`, `closing_stock`, `mat_rate2`, `prod_type`, `total_stock`, `rejected_current_qty`, `mat_status`, `scrape_opening_qty`, `scrape_current_qty`, `transport`, `mat_width`, `mat_thickness`, `packing`, `pack_size`, `no_of_reaction`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(3, 'DCGL/01', '4471269', 'Ion Xpress™ Plus Fragment Library Kit', 'Ion Xpress™ Plus Fragment Library Kit', 46222.8, 5, 67, 0, '', '', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-16 12:40:40', 1, '2018-12-08 09:27:20', 4, '0'),
(4, 'DCGL/02', 'S018', 'MAYER\'S HEMATOXYLIN', 'Himedia', 0, 3, 69, 0, '', '', NULL, 2, 0, 2, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 2, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 03:59:40', 1, '2018-11-28 10:44:51', 4, '0'),
(17, 'DCGL/03', '0215757401', '4′,6-DIAMIDINO-2-PHENYLINDOLE', '4′,6-DIAMIDINO-2-PHENYLINDOLE', 0, 2, -1, 17, '0215757401', '4′,6-DIAMIDINO-2-PHENYLINDOLE', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 04:51:46', 1, '2018-12-08 09:45:53', 4, '0'),
(18, 'DCGL/04', '3540C/3541C', 'XYLENE Sulpher Free Histological Grade Qualigen 25 Ltr Pack', 'XYLENE Sulpher Free Histological Grade Qualigen 25 Ltr Pack', 0, 2, -1, 0, '', '', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 53, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 04:53:33', 1, '2018-11-28 11:19:53', 4, '0'),
(19, 'DCGL/05', '0217006201', 'COPLIN STAINING JAR', 'COPLIN STAINING JAR', 0, 2, -1, 19, '0217006201', 'COPLIN STAINING JAR', NULL, 2, 2, 3, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 3, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 04:57:36', 1, '2018-11-28 10:47:56', 4, '0'),
(20, 'DCGL/06', '0219405490', 'HYDROCHLORIC ACID, ACS', 'HYDROCHLORIC ACID, ACS', 0, 2, -1, 20, '0219405490', 'HYDROCHLORIC ACID, ACS', NULL, 2, 1, 1, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 05:00:22', 1, '2018-08-30 10:52:32', 1, '1'),
(21, 'DCGL/07', '02195501.5', 'SODIUM PHOSPHATE DIBASIC', 'SODIUM PHOSPHATE DIBASIC', 0, 2, -1, 21, '02195501.5', 'SODIUM PHOSPHATE DIBASIC', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 05:02:01', 1, '2018-11-28 10:48:14', 4, '0'),
(22, 'DCGL/08', '02199802.5', 'SODIUM PHOSPHATE DIBASIC ANHYDROUS, U.S.P.', 'SODIUM PHOSPHATE DIBASIC ANHYDROUS, U.S.P.', 0, 2, -1, 22, '02199802.5', 'SODIUM PHOSPHATE DIBASIC ANHYDROUS, U.S.P.', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 05:03:46', 1, '2018-11-28 11:18:19', 4, '0'),
(23, 'DCGL/09', '091688045', 'HYDROCHLORIC ACID, ACS', 'HYDROCHLORIC ACID, ACS', 0, 2, -1, 23, '091688045', 'HYDROCHLORIC ACID, ACS', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 05:05:23', 1, '2018-08-30 10:59:15', 1, '1'),
(24, 'DCGL/10', 'AMC for Air Handling Unit', 'AMC for Air Handling Unit', 'AMC for Air Handling Unit', 0, 9, 14, 24, 'AMC for Air Handling Unit', 'AMC for Air Handling Unit', NULL, 2, 0, 3, '2014-05-30 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 3, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 07:00:53', 1, '2018-11-28 10:48:49', 4, '0'),
(25, 'DCGL/11', '096400204', 'Membrane Filters, D26-45 Filters 0.45 µm', 'Membrane Filters, D26-45 Filters 0.45 µm', 0, 2, 136, 25, '096400204', 'Membrane Filters, D26-45 Filters 0.45 µm', NULL, 2, 0, 0, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 11:39:52', 1, '2018-11-28 10:49:14', 4, '0'),
(26, 'DCGL/12', '097690105', 'SMARTPLASTIC™ TISSUE CULTURE DISH', 'SMARTPLASTIC™ TISSUE CULTURE DISH', 0, 2, -1, 26, '097690105', 'SMARTPLASTIC™ TISSUE CULTURE DISH', NULL, 2, 0, 8, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 8, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-17 11:44:50', 1, '2018-11-28 10:49:42', 4, '0'),
(27, 'DCGL/11', '10400C', '10400C -  NORMAL MS IGG 5 ML', '10400C -  NORMAL MS IGG 5 ML', 8268.02, 2, -1, 0, '', '', NULL, 2, 1, 1, '2014-03-14 00:00:00', 1, 0, 0, 0, 2, 3, 0, 2, 1, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '5ml', '', '2018-08-17 12:21:45', 1, '2018-08-30 12:15:32', 1, '1'),
(28, 'DCGL/12', '10416-014', '50 bp DNA Ladder, Make : Invitrogen', '50 bp DNA Ladder, Make : Invitrogen', 9106.44, 2, -1, 28, '10416-014', '50 bp DNA Ladder, Make : Invitrogen', NULL, 2, 4, 0, '2014-09-03 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 8, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '50 ug', '', '2018-08-17 12:24:19', 1, '2018-11-28 10:50:06', 4, '0'),
(29, 'DCGL/13', '10488058', '10488058 -  TRACKIT 100 BP DNA LADDER 100', '10488058 -  TRACKIT 100 BP DNA LADDER 100', 4815.01, 3, -1, 29, '10488058', '10488058 -  TRACKIT 100 BP DNA LADDER 100', NULL, 22, 1, 1, '2014-03-14 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '100 appls (0.1 ug/ml)', '', '2018-08-17 12:27:53', 1, '2018-08-30 10:59:23', 1, '1'),
(35, 'DCGL/14', '12330', 'test2343423', 'rrerewr', 10, 5, 67, 0, '', '', NULL, 2, 0, 0, '2018-08-22 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-22 10:32:33', 1, '2018-11-28 10:51:32', 4, '0'),
(38, 'DCGL/15', 'fdfdf', 'fdfdsfdsf', 'fdsfdsfdsf', 0, 7, 8, 0, '', '', NULL, 2, 0, 0, '2018-08-22 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-22 12:35:53', 1, '2018-11-28 10:51:44', 4, '0'),
(39, 'DCGL/16', 'dsdsdsad1212', 'fdfdsfdsfds', 'fdsfdsfdsfsdf fdsfdsf', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-22 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-22 03:04:16', 1, NULL, NULL, '0'),
(40, 'DCGL/17', '244444444', 'trffdfsdfs', 'fdsfdsf', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-22 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-22 04:36:20', 1, '2018-08-30 10:53:42', 1, '1'),
(41, 'DCGL/18', '104 test 12345', 'ffsdf', 'fdsfdf', 0, 1, 123, 0, '', '', NULL, 2, 0, 0, '2018-08-24 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-24 04:04:56', 1, '2018-08-30 10:52:26', 1, '1'),
(42, 'DCGL/19', 'test_supp_28_08', 'test_supp_28_08', 'fcdsfdsf', 0, 1, 124, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:27:34', 1, '2018-08-30 10:52:19', 1, '1'),
(43, 'DCGL/20', 'test_requisation_28_08', 'test_requisation_28_08', 'test_requisation_28_08', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:28:59', 1, '2018-08-30 10:59:48', 1, '1'),
(44, 'DCGL/21', 'test_requisation_28_08_18', 'test_requisation_28_08', 'test_requisation_28_08', 0, 3, 69, 0, '', '', NULL, 2, 0, 3, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 3, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:30:06', 1, NULL, NULL, '0'),
(45, 'DCGL/22', 'test_requisation_28_08_18_10_37', 'test_requisation_28_08', 'test_requisation_28_08', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:37:12', 1, NULL, NULL, '0'),
(46, 'DCGL/23', 'test_spplier_28_08', 'test_spplier_28_08', 'test_spplier_28_08', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:38:20', 1, NULL, NULL, '0'),
(47, 'DCGL/24', 'test_req_28_08', 'test_req_28_08', 'test_req_28_08', 0, 7, 8, 0, '', '', NULL, 2, 0, 0, '2018-08-29 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-08-29 10:39:52', 1, NULL, NULL, '0'),
(49, 'DCGL/25', 'trttrt', 'trtrt', 'trt', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-09-05 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-05 17:59:32', 1, NULL, NULL, '0'),
(52, 'DCGL/26', 'test_quo_444', 'test_quo_444', 'test_quo_444', 0, 7, 8, 16, '0215538791', 'METHANOL', NULL, 2, 0, 0, '2018-09-06 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-06 17:58:26', 1, NULL, NULL, '0'),
(53, 'DCGL/27', 'jdsddd', 'test unique number', 'test unique number', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-09-20 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-20 15:30:04', 1, NULL, NULL, '0'),
(54, 'DCGL/28', 'fffdfdfdf333', 'test unique number 1212', 'test unique number 1212', 0, 5, 67, 0, '', '', NULL, 2, 0, 0, '2018-09-20 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-20 15:30:58', 1, NULL, NULL, '0'),
(56, 'DCGL/29', 'fffdfdffdfdfdfdfdff666', 'test unique numberffdfdf', 'test unique numberffdfdf', 0, 5, 67, 0, '', '', NULL, 2, 0, 0, '2018-09-20 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-09-20 15:38:50', 1, NULL, NULL, '0'),
(57, 'DCGL/30', '11304029', 'PLATINUM TAQ HIGH FIDELITY 500 REACTIONS', 'PLATINUM TAQ HIGH FIDELITY 500 REACTIONS', 0, 3, 69, 0, '', '', NULL, 2, 0, 5, '2018-11-11 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 5, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-11-11 11:20:42', 4, NULL, NULL, '0'),
(58, 'DCGL/31', '11306016', 'Platinum® PCR SuperMix', 'Platinum® PCR SuperMix', 0, 3, 69, 58, '11306016', 'Platinum® PCR SuperMix', NULL, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-11-11 11:24:55', 4, '2018-11-28 11:18:38', 4, '0'),
(60, 'DCGL/32', '12321D', 'DYNAMAG -2 EACH', 'Holds: 16 standard 1.5 mL or 2 mL microcentrifuge tubes,Working volume: 10–1500 μL,', 0, 7, 8, 0, '', '', NULL, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-11-11 11:36:48', 4, '2018-11-28 11:17:34', 4, '0'),
(61, 'DCGL/33', '153066', 'Culture dishes 35*10 mm NUNC', 'Culture dishes 35*10 mm NUNC', 0, 3, 69, 0, '', '', NULL, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 0, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-11-11 11:40:24', 1, '2018-11-28 10:52:22', 4, '0'),
(62, 'DCGL/34', '17300-30', 'UltraClean® 5N NaOH', 'UltraClean® 5N NaOH', 0, 3, 69, 0, '', '', NULL, 2, 0, 4, '2018-11-11 00:00:00', 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, '', 4, 0, 'Regular', 0, 0, 0, 0, 0, '', '', '', '2018-11-11 11:49:08', 4, '2018-11-28 10:52:08', 4, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_outwards`
--

CREATE TABLE `erp_material_outwards` (
  `outward_id` int(11) NOT NULL,
  `outward_date` date DEFAULT NULL,
  `outward_number` varchar(355) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `req_id` int(11) DEFAULT NULL,
  `raised_by` int(11) DEFAULT NULL,
  `issued_by` int(11) DEFAULT NULL,
  `form_type` varchar(355) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_outwards`
--

INSERT INTO `erp_material_outwards` (`outward_id`, `outward_date`, `outward_number`, `dep_id`, `req_id`, `raised_by`, `issued_by`, `form_type`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, '2018-12-06', 'Outward/2018/10', 20, 12, 3, 4, 'bachwise_outward_form', '2018-12-06 16:07:54', 4, '2018-12-07 11:59:39', 4, '0'),
(5, '2018-12-07', 'Outward/2018/11', 20, 12, 8, 4, 'bachwise_outward_form', '2018-12-07 12:12:16', 4, '2018-12-08 09:26:29', 4, '0'),
(6, '2018-12-11', 'Outward/2018/12', 20, 32, 119, 4, 'bachwise_outward_form', '2018-12-11 14:45:14', 4, '2018-12-11 14:50:25', 4, '0'),
(7, '2018-12-11', 'Outward/2018/13', 19, 25, 114, 4, 'bachwise_outward_form', '2018-12-11 15:22:23', 4, '2018-12-11 15:33:39', 4, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_outward_batchwise`
--

CREATE TABLE `erp_material_outward_batchwise` (
  `out_batch_id` int(11) NOT NULL,
  `outward_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `sub_mat_id` int(11) DEFAULT NULL,
  `inward_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `req_id` int(11) DEFAULT NULL,
  `bar_code` text,
  `batch_number` varchar(355) DEFAULT NULL,
  `lot_number` varchar(455) DEFAULT NULL,
  `outward_qty` float DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `pack_size` varchar(255) DEFAULT NULL,
  `remark` text,
  `stock_qty` float DEFAULT NULL,
  `inward_qty` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_outward_batchwise`
--

INSERT INTO `erp_material_outward_batchwise` (`out_batch_id`, `outward_id`, `batch_id`, `mat_id`, `sub_mat_id`, `inward_id`, `po_id`, `req_id`, `bar_code`, `batch_number`, `lot_number`, `outward_qty`, `expire_date`, `pack_size`, `remark`, `stock_qty`, `inward_qty`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(79, 1, 6, 4, 0, 2, 6, 12, '41641046_S0', '41641046_S0', '41641046_S0', 1, '2019-03-15', '', '', 0, 1, '2018-12-07 11:59:39', 4, NULL, NULL, '0'),
(80, 1, 7, 4, 0, 2, 6, 12, '80434543_S0', '80434543_S0', '80434543_S0', 1, '2018-12-28', '', '', 0, 1, '2018-12-07 11:59:39', 4, NULL, NULL, '0'),
(81, 1, 15, 19, 5, 3, 2, 12, '41144410_02', '41144410_02', '41144410_02', 1, '2019-02-22', '', '', 0, 1, '2018-12-07 11:59:39', 4, NULL, NULL, '0'),
(82, 1, 19, 19, 0, 3, 2, 12, '49830183_02', '49830183_02', '49830183_02', 1, '2019-03-16', '', '', 0, 1, '2018-12-07 11:59:39', 4, NULL, NULL, '0'),
(83, 1, 21, 19, 0, 3, 2, 12, '19494510_02', '19494510_02', '19494510_02', 1, '2019-02-28', '', '', 0, 1, '2018-12-07 11:59:39', 4, NULL, NULL, '0'),
(89, 5, 43, 3, 0, 2, 6, 12, '40327144_44', '40327144_44', '40327144_44', 1, '2019-03-14', '', '', 0, 1, '2018-12-08 09:26:29', 4, NULL, NULL, '0'),
(90, 5, 44, 3, 0, 2, 6, 12, '34601304_44', '34601304_44', '34601304_44', 1, '2019-02-21', '', '', 0, 1, '2018-12-08 09:26:29', 4, NULL, NULL, '0'),
(99, 6, 8, 4, 0, 2, 6, 32, '53067640_S0', '53067640_S0', '53067640_S0', 1, '2019-02-22', '', '', 0, 1, '2018-12-11 14:50:25', 4, NULL, NULL, '0'),
(100, 6, 9, 4, 0, 2, 6, 32, '49070415_S0', '49070415_S0', '49070415_S0', 1, '2019-02-22', '', '', 0, 1, '2018-12-11 14:50:25', 4, NULL, NULL, '0'),
(129, 7, 2, 22, 0, 1, 2, 25, '01452243_02', '01452243_02', '01452243_02', 2, '2018-12-17', '', '', 0, 2, '2018-12-11 15:33:39', 4, NULL, NULL, '0'),
(130, 7, 11, 22, 0, 3, 2, 25, '31341141_02', '31341141_02', '31341141_02', 1, '2019-02-14', '', '', 0, 1, '2018-12-11 15:33:39', 4, NULL, NULL, '0'),
(131, 7, 1, 22, 0, 1, 2, 25, '46994754_02', '46994754_02', '46994754_02', 2, '2019-02-01', '', '', 0, 2, '2018-12-11 15:33:39', 4, NULL, NULL, '0'),
(132, 7, 10, 22, 0, 3, 2, 25, '14539144_02', '14539144_02', '14539144_02', 1, '2019-02-08', '', '', 0, 1, '2018-12-11 15:33:39', 4, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_outward_details`
--

CREATE TABLE `erp_material_outward_details` (
  `id` int(11) NOT NULL,
  `outward_id` int(11) DEFAULT NULL,
  `req_id` int(11) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `save_type` enum('draft','saved') NOT NULL DEFAULT 'draft',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_outward_details`
--

INSERT INTO `erp_material_outward_details` (`id`, `outward_id`, `req_id`, `mat_id`, `quantity`, `save_type`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(32, 1, 12, 4, 2, 'draft', '2018-12-07 11:59:39', 4, NULL, NULL, '0'),
(33, 1, 12, 19, 3, 'draft', '2018-12-07 11:59:39', 4, NULL, NULL, '0'),
(38, 5, 12, 3, 2, 'draft', '2018-12-08 09:26:29', 4, NULL, NULL, '0'),
(43, 6, 32, 4, 2, 'draft', '2018-12-11 14:50:25', 4, NULL, NULL, '0'),
(51, 7, 25, 22, 5, 'draft', '2018-12-11 15:33:39', 4, NULL, NULL, '0');

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
(20, 'Quo/2018/000024', '2018-10-25', '6', 17, 4, '2018-10-25 11:34:28', 'approved', 7, 6, '2018-10-25 11:34:59', 'approved', 7, 7, '2018-10-25 10:28:12', 4, '2018-10-25 11:34:59', 6, '0'),
(21, 'Quo/2018/000025', '2018-11-06', '7', 19, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-11-06 15:37:33', 4, NULL, NULL, '0'),
(22, 'Quo/2018/000026', '2018-11-06', '7,25,26', 20, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-11-06 16:55:47', 4, NULL, NULL, '0'),
(23, 'Quo/2018/000027', '2018-12-08', '2,7,25,26', 20, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, 0, '2018-12-08 10:52:29', 4, NULL, NULL, '0');

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
(47, 20, 22, 6, 6, 17, 0, '2018-10-25 10:28:12', 4, NULL, NULL),
(48, 21, 22, 2, 5, 19, 25, '2018-11-06 15:37:33', 4, NULL, NULL),
(49, 22, 17, 2, 3, 20, 12, '2018-11-06 16:55:47', 4, NULL, NULL),
(50, 22, 4, 22, 2, 20, 12, '2018-11-06 16:55:47', 4, NULL, NULL),
(51, 23, 17, 7, 9, 20, 28, '2018-12-08 10:52:29', 4, NULL, NULL),
(52, 23, 3, 2, 5, 20, 28, '2018-12-08 10:52:29', 4, NULL, NULL);

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
(59, 62, NULL, NULL, NULL, NULL, 21, '0');

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
(12, 'Req/2018/00001', '2018-08-28', '1', NULL, 20, 7, 'approved', '2018-09-05 17:55:43', '2018-08-28 11:24:40', 1, '2018-09-05 15:20:51', 1, '0'),
(13, 'Req/2018/00002', '2018-08-28', '1', NULL, 20, 7, 'approved', '2018-11-05 14:37:11', '2018-08-28 11:40:40', 1, '2018-09-05 14:39:42', 1, '0'),
(14, 'Req/2018/00003', '2018-08-28', '1', NULL, 20, 7, 'approved', '2018-11-05 14:41:45', '2018-08-28 12:16:45', 1, '2018-09-05 15:53:24', 1, '0'),
(15, 'Req/2018/00004', '2018-08-28', '4', NULL, 21, 4, 'approved', '2018-09-15 10:28:27', '2018-08-28 16:16:27', 1, '2018-09-05 15:45:52', 4, '0'),
(16, 'Req/2018/00005', '2018-08-28', '4', NULL, 21, 4, 'approved', '2018-09-05 15:46:43', '2018-08-28 16:28:36', 1, '2018-09-05 15:46:31', 4, '0'),
(17, 'Req/2018/00006', '2018-08-29', '1', NULL, 20, 7, 'pending', NULL, '2018-08-29 10:45:33', 1, '2018-12-08 11:21:51', 7, '0'),
(18, 'Req/2018/00007', '2018-08-29', '1', NULL, 20, 7, 'approved', '2018-12-08 11:25:18', '2018-08-29 11:03:22', 1, '2018-12-08 11:25:04', 7, '0'),
(19, 'Req/2018/00008', '2018-09-05', '1', NULL, 20, 7, 'pending', NULL, '2018-09-05 14:25:22', 1, '2018-09-05 15:01:05', 1, '0'),
(20, 'Req/2018/00008', '2018-09-05', '1', NULL, 20, 7, 'pending', NULL, '2018-09-05 14:25:26', 1, '2018-09-05 15:42:17', 1, '0'),
(21, 'Req/2018/00009', '2018-09-05', '1', NULL, 20, 7, 'pending', NULL, '2018-09-05 14:27:28', 1, '2018-09-05 15:00:03', 1, '0'),
(22, 'Req/2018/000010', '2018-09-05', '1', NULL, 20, 7, 'approved', '2018-09-25 10:39:51', '2018-09-05 15:01:58', 1, '2018-09-25 10:38:59', 1, '0'),
(23, 'Req/2018/000011', '2018-09-20', '1', NULL, 20, 7, 'approved', '2018-09-25 10:40:46', '2018-09-20 09:57:48', 1, NULL, NULL, '0'),
(24, 'Req/2018/000012', '2018-09-25', '1', NULL, 20, 7, 'approved', '2018-11-05 14:33:53', '2018-09-25 11:13:37', 1, NULL, NULL, '0'),
(25, 'Req/2018/000013', '2018-11-05', '4', NULL, 19, 4, 'approved', '2018-11-06 14:37:13', '2018-11-05 14:45:42', 4, NULL, NULL, '0'),
(26, 'Req/2018/000014', '2018-11-05', '4', NULL, 19, 4, 'pending', NULL, '2018-11-05 15:02:11', 4, NULL, NULL, '0'),
(27, 'Req/2018/000015', '2018-11-05', '4', NULL, 21, 4, 'pending', NULL, '2018-11-05 17:47:44', 4, '2018-11-11 11:37:11', 4, '0'),
(28, 'Req/2018/000016', '2018-11-05', '1', NULL, 20, 7, 'approved', '2018-11-11 11:15:24', '2018-11-05 17:49:04', 1, '2018-11-11 11:14:50', 1, '0'),
(29, 'Req/2018/000017', '2018-11-06', '1', NULL, 20, 7, 'approved', '2018-12-08 11:10:15', '2018-11-06 16:38:02', 4, '2018-12-08 11:09:36', 7, '0'),
(30, 'Req/2018/000018', '2018-11-11', '4', NULL, 21, 4, 'pending', NULL, '2018-11-11 09:56:25', 4, '2018-11-11 11:09:16', 4, '0'),
(31, 'Req/2018/000019', '2018-11-11', '4', NULL, 21, 4, 'pending', NULL, '2018-11-11 10:39:03', 4, NULL, NULL, '0'),
(32, 'Req/2018/000020', '2018-12-07', '1', NULL, 20, 7, 'approved', '2018-12-07 14:08:46', '2018-12-07 13:02:35', 1, '2018-12-07 13:46:47', 7, '0'),
(33, 'Req/2018/000021', '2018-12-11', '1', NULL, 20, 7, 'approved', '2018-12-11 10:18:31', '2018-12-11 09:39:05', 7, '2018-12-11 09:40:57', 7, '0');

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
  `received_qty` float DEFAULT NULL,
  `require_users` varchar(255) DEFAULT NULL COMMENT 'users_management database  user_id',
  `stock_qty` float DEFAULT NULL,
  `po_qty` float DEFAULT NULL,
  `require_date` date DEFAULT NULL,
  `material_note` text,
  `requisation_send_purchase` enum('no','yes') NOT NULL DEFAULT 'no',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_material_requisition_details`
--

INSERT INTO `erp_material_requisition_details` (`id`, `req_id`, `mat_id`, `unit_id`, `dep_id`, `require_qty`, `received_qty`, `require_users`, `stock_qty`, `po_qty`, `require_date`, `material_note`, `requisation_send_purchase`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(89, 13, 3, 4, 20, 3, NULL, '1,4', NULL, NULL, '2018-08-31', 'ddsad1222', 'no', '2018-09-05 14:39:42', 1, NULL, NULL, '0'),
(91, 21, 4, 2, 20, 3, NULL, '4', NULL, NULL, '2018-09-07', NULL, 'no', '2018-09-05 15:00:03', 1, NULL, NULL, '0'),
(93, 19, 3, 2, 20, 3, NULL, '', NULL, NULL, '2018-09-07', NULL, 'no', '2018-09-05 15:01:05', 1, NULL, NULL, '0'),
(103, 12, 17, 2, 20, 3, NULL, '1,4', NULL, NULL, '2018-09-01', NULL, 'yes', '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(104, 12, 19, 2, 20, 3, 3, '', NULL, NULL, '2018-08-31', NULL, 'no', '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(105, 12, 21, 2, 20, 3, NULL, '', NULL, NULL, '2018-09-01', NULL, 'yes', '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(106, 12, 18, 2, 20, 3, NULL, '', NULL, NULL, '2018-08-31', NULL, 'yes', '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(107, 12, 3, 2, 20, 2, 2, '', NULL, NULL, '2018-08-30', NULL, 'no', '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(108, 12, 4, 22, 20, 2, 2, '', NULL, NULL, '2018-08-31', NULL, 'no', '2018-09-05 15:20:51', 1, NULL, NULL, '0'),
(109, 20, 3, 2, 20, 3, NULL, '9', NULL, NULL, '2018-09-07', NULL, 'no', '2018-09-05 15:42:17', 1, NULL, NULL, '0'),
(111, 15, 4, 2, 21, 5, NULL, '121', NULL, NULL, '2018-09-03', '133 111', 'yes', '2018-09-05 15:45:52', 4, NULL, NULL, '0'),
(113, 16, 4, 3, 21, 4, NULL, '121', NULL, NULL, '2018-08-31', NULL, 'no', '2018-09-05 15:46:31', 4, NULL, NULL, '0'),
(115, 14, 18, 2, 20, 3, NULL, '', NULL, NULL, '2018-09-01', NULL, 'yes', '2018-09-05 15:53:24', 1, NULL, NULL, '0'),
(116, 14, 3, 2, 20, 3, NULL, '', NULL, NULL, '2018-09-03', NULL, 'yes', '2018-09-05 15:53:24', 1, NULL, NULL, '0'),
(120, 23, 3, 2, 20, 2, NULL, '', NULL, NULL, '2018-09-29', NULL, 'no', '2018-09-20 09:57:48', 1, NULL, NULL, '0'),
(121, 23, 4, 6, 20, 4, NULL, '', NULL, NULL, '2018-09-20', NULL, 'no', '2018-09-20 09:57:48', 1, NULL, NULL, '0'),
(123, 22, 4, 2, 20, 3, NULL, '1,4', NULL, NULL, '2018-09-07', NULL, 'no', '2018-09-25 10:38:59', 1, NULL, NULL, '0'),
(124, 24, 17, 2, 20, 4, NULL, '', NULL, NULL, '2018-09-27', NULL, 'yes', '2018-09-25 11:13:37', 1, NULL, NULL, '0'),
(125, 24, 19, 2, 20, 2, NULL, '', NULL, NULL, '2018-09-29', NULL, 'no', '2018-09-25 11:13:37', 1, NULL, NULL, '0'),
(126, 25, 22, 2, 19, 5, 6, '', NULL, NULL, '2018-11-15', 'rerererer', 'no', '2018-11-05 14:45:42', 4, NULL, NULL, '0'),
(127, 26, 25, 2, 19, 5, NULL, '', NULL, NULL, '2019-01-17', NULL, 'no', '2018-11-05 15:02:11', 4, NULL, NULL, '0'),
(133, 31, 3, 2, 21, 2, NULL, '', NULL, NULL, '2018-11-11', 'rewrewr 11111', 'no', '2018-11-11 10:39:03', 4, NULL, NULL, '0'),
(134, 31, 4, 2, 21, 2, NULL, '', NULL, NULL, '2018-11-21', 'erewrewr 1111', 'no', '2018-11-11 10:39:03', 4, NULL, NULL, '0'),
(135, 31, 22, 2, 21, 2, NULL, '', NULL, NULL, '2018-11-21', 'erer11111111111111111111', 'no', '2018-11-11 10:39:03', 4, NULL, NULL, '0'),
(136, 31, 28, 2, 21, 2, NULL, '', NULL, NULL, '2018-11-21', '33333333333333frdfdsfdsf', 'no', '2018-11-11 10:39:03', 4, NULL, NULL, '0'),
(143, 30, 3, 2, 21, 5, NULL, '', NULL, NULL, '2018-11-22', 'sdsdsd', 'no', '2018-11-11 11:09:16', 4, NULL, NULL, '0'),
(144, 30, 4, 2, 21, 6, NULL, '', NULL, NULL, '2018-11-29', 'dsds dsadsad', 'no', '2018-11-11 11:09:16', 4, NULL, NULL, '0'),
(145, 30, 21, 2, 21, 5, NULL, '', NULL, NULL, '2018-11-30', 'yyyyy', 'no', '2018-11-11 11:09:16', 4, NULL, NULL, '0'),
(148, 28, 17, 7, 20, 9, NULL, '', NULL, NULL, '2018-11-22', 'ewewe 111', 'yes', '2018-11-11 11:14:50', 1, NULL, NULL, '0'),
(149, 28, 3, 2, 20, 5, NULL, '', NULL, NULL, '2018-11-27', 'hghgfh', 'yes', '2018-11-11 11:14:50', 1, NULL, NULL, '0'),
(154, 27, 3, 2, 21, 5, NULL, '', NULL, NULL, '2018-11-28', 'frdfdf fdsf', 'no', '2018-11-11 11:37:11', 4, NULL, NULL, '0'),
(155, 27, 57, 2, 21, 6, NULL, '', NULL, NULL, '2018-11-30', 'fdsf f fdsfdsf', 'no', '2018-11-11 11:37:12', 4, NULL, NULL, '0'),
(156, 27, 60, 2, 21, 5, NULL, '', NULL, NULL, '2018-11-29', 'fdsf ffds fdsf f', 'no', '2018-11-11 11:37:12', 4, NULL, NULL, '0'),
(162, 32, 3, 2, 20, 5, NULL, '6', NULL, NULL, '2019-02-15', 'eqweqwe', 'yes', '2018-12-07 13:46:47', 7, NULL, NULL, '0'),
(163, 32, 4, 2, 20, 2, 2, '5', NULL, NULL, '2019-01-25', '', 'no', '2018-12-07 13:46:47', 7, NULL, NULL, '0'),
(164, 32, 17, 2, 20, 3, NULL, '6', NULL, NULL, '2019-01-25', 'fdsfdsf', 'yes', '2018-12-07 13:46:47', 7, NULL, NULL, '0'),
(165, 32, 61, 2, 20, 3, NULL, '6', NULL, NULL, '2019-01-25', 'dsadsadsa  dsad', 'yes', '2018-12-07 13:46:47', 7, NULL, NULL, '0'),
(168, 29, 4, 2, 20, 6, NULL, '1', NULL, NULL, '2018-11-27', '', 'no', '2018-12-08 11:09:36', 7, NULL, NULL, '0'),
(170, 17, 47, 3, 20, 5, NULL, '', NULL, NULL, '2018-08-31', '', 'no', '2018-12-08 11:21:51', 7, NULL, NULL, '0'),
(173, 18, 25, 2, 20, 5, NULL, '', NULL, NULL, '2018-12-14', 'rerewr', 'yes', '2018-12-08 11:25:04', 7, NULL, NULL, '0'),
(174, 18, 28, 2, 20, 5, NULL, '', NULL, NULL, '2018-12-14', 'rewrewr', 'yes', '2018-12-08 11:25:04', 7, NULL, NULL, '0'),
(181, 33, 49, 2, 20, 6, NULL, '1', NULL, NULL, '2019-02-14', 'dsdfdsf fdsf', 'yes', '2018-12-11 09:40:57', 7, NULL, NULL, '0'),
(182, 33, 53, 2, 20, 2, NULL, '1', NULL, NULL, '2019-02-20', 'fdsf fdsf sfds', 'yes', '2018-12-11 09:40:57', 7, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_material_stocks`
--

CREATE TABLE `erp_material_stocks` (
  `id` int(11) NOT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `store_qty` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `updated_by` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(2, NULL, 'Stores', 'Store', '', 'fa fa-book', '1', NULL, NULL, '2018-12-07 14:49:11', 1, '0', '1,4,5,7'),
(3, 1, 'Master', 'purchase-master', NULL, 'fa fa-dot-circle-o', '1', NULL, NULL, NULL, NULL, '0', '1,4'),
(6, 2, 'Input', 'Store-Input', '', 'fa fa-dot-circle-o', '1', NULL, NULL, '2018-12-07 14:48:40', 1, '0', '1,4,5,7'),
(7, 2, 'Reports', 'Store-output', '', 'fa fa-dot-circle-o', '0', NULL, NULL, '2018-11-23 14:03:37', 1, '1', '1'),
(8, 3, 'Unit', 'Purchase-master-unit', 'purchase/unit', 'fa fa-circle-o', '0', NULL, NULL, '2018-10-11 09:31:54', 1, '0', '1,4,6'),
(9, 3, 'Category', 'Purchase-master-category', 'purchase/category', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 10:35:46', 1, '0', '1,4'),
(10, 3, 'Material', 'purchase-master-material', 'purchase/material', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 10:36:00', 1, '0', '1,4'),
(11, 3, 'Vendor', 'purchase-master-supplier', 'purchase/supplier', 'fa fa-circle-o', '0', NULL, NULL, '2018-09-04 10:36:11', 1, '0', '1,4'),
(12, NULL, 'Settings', 'Settings', 'settings/index', 'fa fa-gear', '0', NULL, NULL, NULL, NULL, '0', '1'),
(13, NULL, 'Departments', 'Departments', 'department/index', 'fa fa-building', '0', '2018-08-20 00:00:00', 1, '2018-09-04 10:21:11', 1, '0', '1'),
(14, 6, 'Material-Inward', 'Store-Input-Inward', 'store/material_inward', 'fa fa-circle-o', '0', '2018-08-23 00:00:00', 1, '2018-10-29 11:42:48', 1, '0', '1,4'),
(15, 6, 'Material(s) Requisition', 'Store-Input-Requisation', 'store/material_requisation', 'fa fa-circle-o', '0', '2018-08-23 00:00:00', 1, '2018-12-08 09:22:46', 1, '0', '1,4,5,6,7'),
(23, 1, 'Quotations (Materials)', 'Quotations (Materials)', 'purchase/quotations', 'fa fa-dot-circle-o', '0', '2018-09-28 17:40:26', 1, '2018-10-08 12:25:36', 1, '0', '1,4,6'),
(24, 1, 'Purchase Order', 'Purchase Order', 'purchase/purchase_order', 'fa fa-dot-circle-o', '1', '2018-09-28 17:42:06', 1, '2018-10-03 17:17:12', 1, '0', '1,4'),
(25, 24, 'Prepare PO (Quotation)', 'Prepare PO (Quotation)', 'purchase/purchase_order_quotation', 'fa fa-circle-o', '0', '2018-09-28 18:14:44', 1, '2018-09-29 09:20:37', 1, '0', '1,4'),
(26, 24, 'Prepare PO (Requisition)', '', 'purchase/purchase_order_requisition', 'fa fa-circle-o', '0', '2018-09-28 18:15:46', 1, '2018-09-29 09:21:41', 1, '0', '1,4'),
(27, 6, 'General-Inward', 'General-inward', 'store/general_inward', 'fa fa-circle-o', '0', '2018-10-30 10:28:33', 1, '2018-11-27 17:11:47', 1, '0', '1,4'),
(28, 2, 'Stocks', 'Stocks', '', 'fa fa-cube', '0', '2018-11-23 11:32:37', 1, '2018-11-23 11:35:22', 1, '1', '1'),
(29, NULL, 'Stock', 'Stock', '', 'fa fa-cube', '0', '2018-11-23 11:36:02', 1, '2018-11-23 14:03:03', 1, '1', '1,4'),
(30, 2, 'Stock', '', '', 'fa fa-dot-circle-o', '0', '2018-11-23 14:04:28', 1, '2018-11-23 14:04:49', 1, '0', '1,4'),
(31, 6, 'Outward-Batch-Wise', 'Outward-Batch-wise', 'store/outward_batch_wise', 'fa fa-circle-o', '0', '2018-11-27 16:58:56', 1, '2018-11-27 17:12:08', 1, '0', '1,4'),
(32, 1, 'Material(s) Requisition', '', 'purchase/purchase_material_requisition', 'fa fa-dot-circle-o', '0', '2018-12-07 14:52:01', 1, '2018-12-07 18:00:47', 1, '0', '1,4'),
(33, 1, 'Billing', 'Billing', 'purchase/billing', 'fa fa-dot-circle-o', '0', '2018-12-12 17:33:07', 1, NULL, NULL, '0', '1,4,6');

-- --------------------------------------------------------

--
-- Table structure for table `erp_payments_plan`
--

CREATE TABLE `erp_payments_plan` (
  `id` int(11) NOT NULL,
  `inward_id` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `installment_amout` float DEFAULT NULL,
  `balance_amount` float DEFAULT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_payments_plan`
--

INSERT INTO `erp_payments_plan` (`id`, `inward_id`, `due_date`, `installment_amout`, `balance_amount`, `created`, `created_by`, `is_deleted`) VALUES
(1, 1, '2018-12-12', 12, 86.64, '2018-12-12 17:20:13', 4, '0'),
(2, 1, '2019-01-11', 12, 74.64, '2018-12-12 17:20:13', 4, '0'),
(3, 1, '2019-01-23', 74.64, 0, '2018-12-12 17:20:13', 4, '0'),
(4, 3, '2018-12-14', 24, 67.44, '2018-12-12 17:22:56', 4, '0'),
(5, 3, '2019-02-22', 24, 43.44, '2018-12-12 17:22:56', 4, '0'),
(6, 3, '2019-01-24', 43.44, 0, '2018-12-12 17:22:56', 4, '0'),
(7, 2, '2018-12-15', 34, 38, '2018-12-12 17:56:32', 4, '0'),
(8, 2, '2019-01-23', 38, 0, '2018-12-12 17:56:32', 4, '0');

-- --------------------------------------------------------

--
-- Table structure for table `erp_payment_terms`
--

CREATE TABLE `erp_payment_terms` (
  `payment_terms` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_payment_terms`
--

INSERT INTO `erp_payment_terms` (`payment_terms`) VALUES
('50% Advance & 50% after completion work'),
('100% Advance'),
('100% against delivery'),
('80% Advance & 20% after completion');

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
-- Table structure for table `erp_purchase_material_requisition`
--

CREATE TABLE `erp_purchase_material_requisition` (
  `id` int(11) NOT NULL,
  `req_id` int(11) DEFAULT NULL,
  `purchase_approval_flag` enum('approved','not_approved','pending','completed') NOT NULL DEFAULT 'pending',
  `purchase_approval_date` datetime DEFAULT NULL,
  `approval_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_purchase_material_requisition`
--

INSERT INTO `erp_purchase_material_requisition` (`id`, `req_id`, `purchase_approval_flag`, `purchase_approval_date`, `approval_by`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 32, 'approved', '2018-12-07 17:24:02', 4, '2018-12-07 00:00:00', 4, NULL, NULL, '0'),
(2, 28, 'approved', '2018-12-08 10:45:54', 4, '2018-12-08 00:00:00', 4, NULL, NULL, '0'),
(3, 24, 'pending', NULL, NULL, '2018-12-10 00:00:00', 4, NULL, NULL, '0'),
(4, 14, 'pending', NULL, NULL, '2018-12-10 00:00:00', 4, NULL, NULL, '0'),
(5, 18, 'pending', NULL, NULL, '2018-12-10 00:00:00', 4, NULL, NULL, '0'),
(6, 15, 'pending', NULL, NULL, '2018-12-10 00:00:00', 4, NULL, NULL, '0'),
(7, 33, 'pending', NULL, NULL, '2018-12-11 00:00:00', 4, NULL, NULL, '0');

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
(1, 'material_po', 'DCGL/2018/31', '2018-10-29', 6, 6, NULL, NULL, 20, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 4, '2018-11-26 15:57:57', '', '', 'RS', 114, 13.68, 13.68, 0, 0, 0, 141.36, 141.36, 'quotation_form', 'non_completed', 'no', 'no', '2018-10-29 14:21:08', 4, '2018-11-26 15:57:57', 4, '0'),
(2, 'material_po', 'DCGL/2018/33', '2018-10-29', 6, 7, NULL, NULL, 17, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, NULL, '', '', 'RS', 186, 12.12, 6.3, 13.02, 0, 12, 229.44, 0, 'quotation_form', 'completed', 'no', 'yes', '2018-10-29 14:22:12', 4, '2018-10-29 14:39:50', 4, '0'),
(3, 'general_po', 'DCGL/2018/35', '2018-10-29', 7, NULL, NULL, 3, 20, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, NULL, '', '', 'RS', 60, 7.2, 7.2, 7.2, 0, 0, 81.6, 0, 'general_form', 'completed', 'no', 'yes', '2018-10-29 14:26:58', 4, '2018-10-30 10:40:07', 4, '0'),
(4, 'material_po', 'DCGL/2018/37', '2018-10-29', 7, 5, NULL, NULL, 20, '01-01-2018 to 31-12-2018', 12, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 4, '2018-11-12 14:46:46', '', '', 'RS', 244, 29.28, 24.4, 0, 0, 12, 309.68, 309.68, 'quotation_form', 'non_completed', 'no', 'no', '2018-10-29 14:48:49', 4, '2018-11-12 14:46:46', 4, '0'),
(5, 'material_po', 'DCGL/2018/39-A-A', '2018-10-30', 26, 4, NULL, NULL, 20, '2-3 weeks', 12, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', NULL, '2018-10-31 10:39:20', '', '', 'RS', 30, 0, 0, 0, 0, 0, 30, 0, 'quotation_form', 'non_completed', 'no', 'no', '2018-10-30 09:41:03', 4, '2018-10-31 10:39:20', 4, '0'),
(6, 'material_po', 'DCGL/2018/40', '2018-10-30', 11, NULL, 23, NULL, 20, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, '2018-10-31 12:10:44', '', '', 'RS', 72, 0, 0, 0, 0, 0, 72, 0, 'requisition_form', 'completed', 'no', 'yes', '2018-10-30 17:47:19', 4, NULL, NULL, '0'),
(7, 'general_po', 'DCGL/2018/42-A', '2018-11-01', 2, NULL, NULL, 9, 20, '01-01-2018 to 31-12-2018', 12, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, '2018-11-11 15:07:35', '', '', 'RS', 36, 4.32, 4.32, 4.32, 45, 0, 93.96, 0, 'general_form', 'completed', 'yes', 'yes', '2018-11-01 09:48:53', 4, '2018-11-11 15:06:39', 4, '0'),
(8, 'general_po', 'DCGL/2018/44', '2018-11-11', 5, NULL, NULL, 3, 20, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 4, '2018-11-12 14:47:20', '', '', 'RS', 144, 17.28, 17.28, 17.28, 0, 12, 207.84, 207.84, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 12:20:07', 4, '2018-11-12 14:47:20', 4, '0'),
(9, 'general_po', 'DCGL/2018/46', '2018-11-11', 7, NULL, NULL, NULL, 19, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 12:44:54', 4, '2018-11-11 14:18:29', 4, '1'),
(10, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 19, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:27:54', 4, '2018-11-11 14:28:53', 4, '1'),
(11, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 19, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:28:07', 4, '2018-11-11 14:28:47', 4, '1'),
(12, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 19, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:28:16', 4, '2018-11-11 14:28:41', 4, '1'),
(13, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:36:50', 4, '2018-11-11 14:41:02', 4, '1'),
(14, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:36:51', 4, '2018-11-11 14:41:09', 4, '1'),
(15, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 34, 0, 0, 0, 0, 0, 34, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:37:15', 4, '2018-11-11 14:41:22', 4, '1'),
(16, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 34, 0, 0, 0, 0, 0, 34, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:37:15', 4, '2018-11-11 14:42:11', 4, '1'),
(17, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 34, 0, 0, 0, 0, 0, 34, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:37:16', 4, '2018-11-11 14:42:18', 4, '1'),
(18, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 34, 0, 0, 0, 0, 0, 34, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:37:16', 4, '2018-11-11 14:42:24', 4, '1'),
(19, 'general_po', 'DCGL/2018/46', '2018-11-11', 2, NULL, NULL, NULL, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 34, 0, 0, 0, 0, 0, 34, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:37:41', 4, '2018-11-11 14:42:31', 4, '1'),
(20, 'general_po', 'DCGL/2018/46', '2018-11-11', 9, NULL, NULL, 3, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:43:09', 4, '2018-11-11 14:43:19', 4, '1'),
(21, 'general_po', 'DCGL/2018/48', '2018-11-11', 9, NULL, NULL, 3, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:43:50', 4, '2018-11-11 14:44:01', 4, '1'),
(22, 'general_po', 'DCGL/2018/50', '2018-11-11', 10, NULL, NULL, 3, 15, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:44:53', 4, '2018-11-11 14:45:42', 4, '1'),
(23, 'general_po', 'DCGL/2018/52', '2018-11-11', 4, NULL, NULL, 3, 14, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 0, 0, 0, 0, 0, 0, 0, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:47:51', 4, '2018-11-11 14:50:19', 4, '1'),
(24, 'general_po', 'DCGL/2018/54', '2018-11-11', 4, NULL, NULL, 3, 15, '01-01-2018 to 31-12-2018', 0, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 0, NULL, '', '', 'RS', 540, 0, 0, 0, 0, 0, 540, 0, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 14:53:06', 4, NULL, NULL, '0'),
(25, 'general_po', 'DCGL/2018/56', '2018-11-11', 5, NULL, NULL, 3, 15, '01-01-2018 to 31-12-2018', 12, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'pending', 4, '2018-11-11 17:44:18', '', '', 'RS', 144, 0, 0, 0, 12, 12, 168, 168, 'general_form', 'non_completed', 'no', 'no', '2018-11-11 17:43:21', 4, '2018-11-11 17:44:18', 4, '0'),
(26, 'general_po', 'DCGL/2018/58', '2018-11-27', 25, NULL, NULL, 3, 20, '01-01-2018 to 31-12-2018', 30, 'As Require', 'At Actual', '50% Advance & 50% after completion work', 'MUST BE ON THE NAME OF Datar Cancer Genetics Limited', 'NIL', 'approved', 4, '2018-11-27 10:43:10', '', '', 'RS', 1090, 130.8, 130.8, 0, 0, 40, 1391.6, 0, 'general_form', 'non_completed', 'no', 'yes', '2018-11-27 10:40:16', 4, '2018-11-27 10:43:10', 4, '0');

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
  `received_qty` float DEFAULT '0',
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

INSERT INTO `erp_purchase_order_details` (`id`, `po_id`, `req_id`, `quotation_id`, `cat_id`, `mat_id`, `hsn_code`, `dep_id`, `unit_id`, `qty`, `received_qty`, `rate`, `expire_date`, `cgst_per`, `cgst_amt`, `sgst_per`, `sgst_amt`, `igst_per`, `igst_amt`, `discount`, `discount_per`, `mat_amount`, `created`, `created_by`, `updated`, `updated_by`, `is_deleted`) VALUES
(1, 1, NULL, 6, NULL, 17, '', 20, 2, 3, 0, 24, '2018-10-29 00:00:00', 12, 8.64, 12, 8.64, 0, 0, 0, 0, 72, '2018-10-29 00:00:00', 4, '2018-11-26', 4, '0'),
(2, 1, NULL, 6, NULL, 3, '', 20, 2, 2, 0, 9, '2018-10-29 00:00:00', 12, 2.16, 12, 2.16, 0, 0, 0, 0, 18, '2018-10-29 00:00:00', 4, '2018-11-26', 4, '0'),
(3, 1, NULL, 6, NULL, 4, '', 20, 2, 2, 0, 12, '2018-10-29 00:00:00', 12, 2.88, 12, 2.88, 0, 0, 0, 0, 24, '2018-10-29 00:00:00', 4, '2018-11-26', 4, '0'),
(4, 2, NULL, 7, NULL, 22, '1232311', 17, 2, 6, 6, 12, '2018-10-29 00:00:00', 6, 4.32, 7, 5.04, 7, 5.04, 0, 0, 72, '2018-10-29 00:00:00', 4, '2018-10-29', 4, '0'),
(5, 2, NULL, 7, NULL, 26, '423434', 17, 3, 8, 8, 12, '2018-10-29 00:00:00', 7, 6.72, 0, 0, 7, 6.72, 0, 0, 96, '2018-10-29 00:00:00', 4, '2018-10-29', 4, '0'),
(6, 2, NULL, 7, NULL, 19, '343243', 17, 2, 6, 6, 3, '2018-10-29 00:00:00', 6, 1.08, 7, 1.26, 7, 1.26, 0, 0, 18, '2018-10-29 00:00:00', 4, '2018-10-29', 4, '0'),
(7, 3, NULL, NULL, 3, 4, '12323', 20, 2, 2, 2, 12, '2018-10-29 00:00:00', 12, 2.88, 12, 2.88, 12, 2.88, 0, 0, 24, '2018-10-29 00:00:00', 4, '2018-10-30', 4, '0'),
(8, 3, NULL, NULL, 3, 44, '543543', 20, 2, 3, 3, 12, '2018-10-29 00:00:00', 12, 4.32, 12, 4.32, 12, 4.32, 0, 0, 36, '2018-10-29 00:00:00', 4, '2018-10-30', 4, '0'),
(9, 4, NULL, 5, NULL, 3, '', 20, 2, 2, 0, 122, '2018-10-29 00:00:00', 12, 29.28, 10, 24.4, 0, 0, 0, 0, 244, '2018-10-29 00:00:00', 4, '2018-11-12', 4, '0'),
(10, 5, NULL, 4, NULL, 18, '89099', 20, 2, 3, 0, 10, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 30, '2018-10-30 00:00:00', 4, '2018-10-31', 4, '0'),
(11, 6, 23, NULL, NULL, 3, '', 20, 2, 2, 2, 12, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 24, '2018-10-30 00:00:00', 4, NULL, NULL, '0'),
(12, 6, 23, NULL, NULL, 4, '', 20, 2, 4, 4, 12, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 48, '2018-10-30 00:00:00', 4, NULL, NULL, '0'),
(13, 7, NULL, NULL, 9, 24, '', 20, 2, 3, 3, 12, '2018-11-01 00:00:00', 12, 4.32, 12, 4.32, 12, 4.32, 0, 0, 36, '2018-11-01 00:00:00', 4, '2018-11-11', 4, '0'),
(14, 8, NULL, NULL, 3, 4, '', 20, 2, 12, 0, 12, '2018-11-11 00:00:00', 12, 17.28, 12, 17.28, 12, 17.28, 0, 0, 144, '2018-11-11 00:00:00', 4, '2018-11-12', 4, '0'),
(15, 9, NULL, NULL, NULL, 4, '', 19, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(16, 10, NULL, NULL, NULL, 61, '', 19, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(17, 10, NULL, NULL, NULL, 57, '', 19, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(18, 10, NULL, NULL, NULL, 58, '', 19, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(19, 11, NULL, NULL, NULL, 61, '', 19, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(20, 11, NULL, NULL, NULL, 57, '', 19, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(21, 12, NULL, NULL, NULL, 61, '', 19, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(22, 13, NULL, NULL, NULL, 58, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(23, 13, NULL, NULL, NULL, 61, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(24, 14, NULL, NULL, NULL, 58, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(25, 14, NULL, NULL, NULL, 61, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(26, 15, NULL, NULL, NULL, 58, '', 14, 2, 1, 0, 12, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 12, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(27, 15, NULL, NULL, NULL, 61, '', 14, 2, 1, 0, 22, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 22, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(28, 16, NULL, NULL, NULL, 58, '', 14, 2, 1, 0, 12, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 12, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(29, 16, NULL, NULL, NULL, 61, '', 14, 2, 1, 0, 22, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 22, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(30, 17, NULL, NULL, NULL, 58, '', 14, 2, 1, 0, 12, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 12, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(31, 17, NULL, NULL, NULL, 61, '', 14, 2, 1, 0, 22, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 22, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(32, 18, NULL, NULL, NULL, 58, '', 14, 2, 1, 0, 12, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 12, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(33, 18, NULL, NULL, NULL, 61, '', 14, 2, 1, 0, 22, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 22, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(34, 19, NULL, NULL, NULL, 58, '', 14, 2, 1, 0, 12, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 12, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(35, 19, NULL, NULL, NULL, 61, '', 14, 2, 1, 0, 22, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 22, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(36, 20, NULL, NULL, 3, 4, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(37, 20, NULL, NULL, 3, 57, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(38, 20, NULL, NULL, 3, 58, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(39, 20, NULL, NULL, 3, 61, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(40, 20, NULL, NULL, 3, 62, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(41, 21, NULL, NULL, 3, 4, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(42, 21, NULL, NULL, 3, 57, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(43, 21, NULL, NULL, 3, 58, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(44, 21, NULL, NULL, 3, 61, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(45, 21, NULL, NULL, 3, 62, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(46, 22, NULL, NULL, 3, 4, '', 15, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(47, 22, NULL, NULL, 3, 57, '', 15, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(48, 22, NULL, NULL, 3, 58, '', 15, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(49, 22, NULL, NULL, 3, 61, '', 15, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(50, 22, NULL, NULL, 3, 62, '', 15, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(51, 23, NULL, NULL, 3, 4, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(52, 23, NULL, NULL, 3, 57, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(53, 23, NULL, NULL, 3, 58, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(54, 23, NULL, NULL, 3, 61, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(55, 23, NULL, NULL, 3, 62, '', 14, 2, 0, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '1'),
(56, 24, NULL, NULL, 3, 58, '', 15, 2, 12, 0, 45, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 540, '2018-11-11 00:00:00', 4, NULL, NULL, '0'),
(57, 25, NULL, NULL, 3, 4, '', 15, 2, 12, 0, 12, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 144, '2018-11-11 00:00:00', 4, '2018-11-11', 4, '0'),
(58, 26, NULL, NULL, 3, 57, '75676', 20, 3, 5, 5, 34, '2018-11-27 00:00:00', 12, 20.4, 12, 20.4, 0, 0, 0, 0, 170, '2018-11-27 00:00:00', 4, '2018-11-27', 4, '0'),
(59, 26, NULL, NULL, 3, 58, '8787', 20, 4, 8, 0, 45, '2018-11-27 00:00:00', 12, 43.2, 12, 43.2, 0, 0, 0, 0, 360, '2018-11-27 00:00:00', 4, '2018-11-27', 4, '0'),
(60, 26, NULL, NULL, 3, 62, '45435', 20, 6, 10, 4, 56, '2018-11-27 00:00:00', 12, 67.2, 12, 67.2, 0, 0, 0, 0, 560, '2018-11-27 00:00:00', 4, '2018-11-27', 4, '0');

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
(73, NULL, 1, NULL, 26, NULL, 20, 2, 8, 12, '2018-11-16 00:00:00', 12, 11.52, 12, 11.52, 12, 11.52, 0, 0, 96),
(112, 12, NULL, NULL, 19, NULL, 20, 2, 3, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(113, 12, NULL, NULL, 21, NULL, 20, 2, 3, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(114, 12, NULL, NULL, 18, NULL, 20, 2, 3, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(115, 12, NULL, NULL, 3, NULL, 20, 2, 2, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(116, 12, NULL, NULL, 4, NULL, 20, 22, 2, 0, '2018-10-30 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(136, 22, NULL, NULL, 4, NULL, 20, 2, 3, 0, '2018-11-01 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(147, NULL, NULL, 3, 61, NULL, 18, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(213, NULL, NULL, 3, 4, NULL, 14, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(214, NULL, NULL, 3, 57, NULL, 14, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(215, NULL, NULL, 3, 58, NULL, 14, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(216, NULL, NULL, 3, 61, NULL, 14, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(217, NULL, NULL, 3, 62, NULL, 14, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(223, NULL, 7, NULL, 19, NULL, 20, 2, 6, 3, '2018-11-22 00:00:00', 6, 1.08, 7, 1.26, 7, 1.26, 0, 0, 18),
(224, NULL, 7, NULL, 22, NULL, 20, 2, 6, 12, '2018-11-22 00:00:00', 6, 4.32, 7, 5.04, 7, 5.04, 0, 0, 72),
(225, NULL, 7, NULL, 26, NULL, 20, 2, 8, 12, '2018-11-09 00:00:00', 7, 6.72, 0, 0, 7, 6.72, 0, 0, 96),
(226, NULL, 6, NULL, 3, NULL, 20, 2, 2, 9, '2018-10-25 00:00:00', 12, 2.16, 12, 2.16, 0, 0, 0, 0, 18),
(227, NULL, 6, NULL, 4, NULL, 20, 2, 2, 12, '2018-11-22 00:00:00', 12, 2.88, 12, 2.88, 0, 0, 0, 0, 24),
(229, NULL, 6, NULL, 3, NULL, 21, 2, 2, 9, '2018-10-25 00:00:00', 12, 2.16, 12, 2.16, 0, 0, 0, 0, 18),
(231, NULL, 6, NULL, 17, NULL, 21, 2, 3, 24, '2018-11-30 00:00:00', 12, 8.64, 12, 8.64, 0, 0, 0, 0, 72),
(236, 28, NULL, NULL, 17, NULL, 20, 7, 9, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(237, 28, NULL, NULL, 3, NULL, 20, 2, 5, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(238, 25, NULL, NULL, 22, NULL, 19, 2, 5, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(239, 24, NULL, NULL, 17, NULL, 20, 2, 4, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(240, 24, NULL, NULL, 19, NULL, 20, 2, 2, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(243, NULL, NULL, 3, 61, NULL, 21, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(244, NULL, NULL, 3, 62, NULL, 21, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(245, NULL, NULL, 3, 4, NULL, 19, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(246, NULL, NULL, 3, 57, NULL, 19, 2, 0, 0, '2018-11-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(250, NULL, NULL, 3, 4, NULL, 15, 2, 0, 0, '2018-11-12 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(251, NULL, NULL, 3, 57, NULL, 15, 2, 0, 0, '2018-11-12 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(252, 23, NULL, NULL, 3, NULL, 20, 2, 2, 0, '2018-11-28 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(253, 23, NULL, NULL, 4, NULL, 20, 6, 4, 0, '2018-11-28 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
-- Table structure for table `erp_sub_material_master`
--

CREATE TABLE `erp_sub_material_master` (
  `sub_mat_id` int(11) NOT NULL,
  `mat_id` int(11) DEFAULT NULL,
  `sub_material_name` varchar(355) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_sub_material_master`
--

INSERT INTO `erp_sub_material_master` (`sub_mat_id`, `mat_id`, `sub_material_name`, `created`, `created_by`, `is_deleted`) VALUES
(1, 26, 'dsdsadsad', '2018-11-16 17:22:20', 4, '0'),
(2, 26, 'ewew ewe wewe', '2018-11-16 17:33:36', 4, '0'),
(3, 26, 'ughghghg', '2018-11-17 14:01:24', 4, '0'),
(4, 26, 'test material name', '2018-11-18 09:36:35', 4, '0'),
(5, 19, 'yyyyy', '2018-11-18 09:40:01', 4, '0'),
(6, 4, 'Mayer\'s Hematoxylin', '2018-11-19 15:26:34', 4, '0'),
(7, 17, '4′,6-DIAMIDINO-2-PHENYLINDOLE: Sub Material', '2018-11-22 15:19:53', 4, '0'),
(8, 3, 'Ion Xpress™ Plus Fragment Library Kit -sub material', '2018-11-22 17:54:55', 4, '0');

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
(2, 'SAN INFOTEK', NULL, 'Archana', 'Sharanpur Link Rd, Ramdas Colony, Nashik, Maharashtra', 'Nashik', 422005, NULL, '1234567891', '', 'Infotek@sangroup.co.in', 'MAHARASHATRA', 'INDIA', '', '0253 2310991', '0253 2315991', NULL, '', '', 'jnjn', '20', '1234567782', '2018-08-03 03:51:38', 1, '2018-11-06 17:00:22', NULL, 4, '0'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `activities_date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_user_activities`
--

INSERT INTO `erp_user_activities` (`id`, `modules`, `user_id`, `activities`, `activities_date_time`) VALUES
(1, 'Category', 4, 'Category Updated: cat_id 8', '2018-11-26 14:33:16'),
(2, 'Vendor', 4, 'Export Vendor', '2018-11-26 14:54:31'),
(3, 'Vendor', 4, 'Export Vendor', '2018-11-26 14:54:36'),
(4, 'Vendor', 4, 'Export Vendor', '2018-11-26 14:55:01'),
(5, 'Vendor', 4, 'Export Vendor', '2018-11-26 14:55:07'),
(6, 'Vendor', 4, 'Export Vendor', '2018-11-26 14:56:03'),
(7, 'Vendor', 4, 'Export Vendor', '2018-11-26 14:56:08'),
(8, 'Purchase Order', 4, 'Purchase Order Updated. PO Number :DCGL/2018/31', '2018-11-26 15:57:57'),
(9, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 6 Status Non Completed', '2018-11-26 17:36:59'),
(10, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 6 Status Non Completed', '2018-11-26 17:37:08'),
(11, 'Material Inward', 4, 'Saved Material Inward. Inward ID 12', '2018-11-26 17:38:09'),
(12, 'Material Inward', 4, 'Saved Batch Number. Inward ID12', '2018-11-26 17:39:22'),
(13, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 6 Status Completed', '2018-11-26 17:39:33'),
(14, 'Material Inward', 4, 'Updated Material Inward. Inward ID 12', '2018-11-26 17:39:33'),
(15, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 7 Status Non Completed', '2018-11-26 17:40:55'),
(16, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 7 Status Non Completed', '2018-11-26 17:42:36'),
(17, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 7 Status Non Completed', '2018-11-26 17:42:45'),
(18, 'General Inward', 4, 'Saved General Inward. Inward ID 13', '2018-11-26 17:43:28'),
(19, 'General Inward', 4, 'Saved Batch Number. Inward ID13', '2018-11-26 17:44:47'),
(20, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 7 Status Completed', '2018-11-26 17:46:03'),
(21, 'General Inward', 4, 'Updated General Inward. Inward ID 13', '2018-11-26 17:46:03'),
(22, 'Purchase Order', 4, 'Purchase Order Created. PO Number :DCGL/2018/58', '2018-11-27 10:40:16'),
(23, 'Purchase Order', 4, 'Purchase Order Updated. PO Number :DCGL/2018/58', '2018-11-27 10:41:04'),
(24, 'Purchase Order', 4, 'Purchase Order Updated. PO Number :DCGL/2018/58', '2018-11-27 10:43:10'),
(25, 'General Inward', 4, 'Saved General Inward. Inward ID 14', '2018-11-27 11:05:39'),
(26, 'General Inward', 4, 'Saved Batch Number. Inward ID14', '2018-11-27 11:07:05'),
(27, 'General Inward', 4, 'Updated General Inward. Inward ID 14', '2018-11-27 11:07:51'),
(28, 'Requisation', 1, 'Requisation Records Updated. Requisation ID 29', '2018-11-27 16:01:43'),
(29, 'Material', 4, 'Material Updated Successfully. Material ID 4', '2018-11-28 10:44:51'),
(30, 'Material', 4, 'Material Updated Successfully. Material ID 3', '2018-11-28 10:45:17'),
(31, 'Material', 4, 'Material Updated Successfully. Material ID 17', '2018-11-28 10:45:55'),
(32, 'Material', 4, 'Material Updated Successfully. Material ID 18', '2018-11-28 10:46:07'),
(33, 'Material', 4, 'Material Updated Successfully. Material ID 18', '2018-11-28 10:47:26'),
(34, 'Material', 4, 'Material Updated Successfully. Material ID 19', '2018-11-28 10:47:56'),
(35, 'Material', 4, 'Material Updated Successfully. Material ID 21', '2018-11-28 10:48:14'),
(36, 'Material', 4, 'Material Updated Successfully. Material ID 22', '2018-11-28 10:48:37'),
(37, 'Material', 4, 'Material Updated Successfully. Material ID 24', '2018-11-28 10:48:49'),
(38, 'Material', 4, 'Material Updated Successfully. Material ID 25', '2018-11-28 10:49:01'),
(39, 'Material', 4, 'Material Updated Successfully. Material ID 25', '2018-11-28 10:49:14'),
(40, 'Material', 4, 'Material Updated Successfully. Material ID 26', '2018-11-28 10:49:30'),
(41, 'Material', 4, 'Material Updated Successfully. Material ID 26', '2018-11-28 10:49:42'),
(42, 'Material', 4, 'Material Updated Successfully. Material ID 28', '2018-11-28 10:50:06'),
(43, 'Material', 4, 'Material Updated Successfully. Material ID 35', '2018-11-28 10:50:20'),
(44, 'Material', 4, 'Material Updated Successfully. Material ID 35', '2018-11-28 10:51:32'),
(45, 'Material', 4, 'Material Updated Successfully. Material ID 38', '2018-11-28 10:51:44'),
(46, 'Material', 4, 'Material Updated Successfully. Material ID 62', '2018-11-28 10:52:08'),
(47, 'Material', 4, 'Material Updated Successfully. Material ID 61', '2018-11-28 10:52:22'),
(48, 'Material', 4, 'Material Updated Successfully. Material ID 60', '2018-11-28 11:17:34'),
(49, 'Material', 4, 'Material Updated Successfully. Material ID 22', '2018-11-28 11:18:19'),
(50, 'Material', 4, 'Material Updated Successfully. Material ID 58', '2018-11-28 11:18:38'),
(51, 'Material', 4, 'Material Updated Successfully. Material ID 18', '2018-11-28 11:19:53'),
(52, 'Material Outward', 4, 'Material Requisation Records send to Purchase.', '2018-11-29 12:04:52'),
(53, 'General Inward', 4, 'Saved General Inward. Inward ID 15', '2018-11-30 15:40:08'),
(54, 'General Inward', 4, 'Saved Batch Number. Inward ID15', '2018-11-30 16:56:20'),
(55, 'General Inward', 4, 'Updated General Inward. Inward ID 15', '2018-11-30 16:56:37'),
(56, 'General Inward', 4, 'Saved General Inward. Inward ID 16', '2018-12-05 14:23:42'),
(57, 'General Inward', 4, 'Saved Batch Number. Inward ID16', '2018-12-05 14:25:07'),
(58, 'General Inward', 4, 'Updated General Inward. Inward ID 16', '2018-12-05 14:45:59'),
(59, 'General Inward', 4, 'Updated General Inward. Inward ID 16', '2018-12-05 14:54:17'),
(60, 'General Inward', 4, 'Updated General Inward. Inward ID 16', '2018-12-05 14:56:39'),
(61, 'General Inward', 4, 'Updated General Inward. Inward ID 16', '2018-12-05 14:57:30'),
(62, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 2 Status Completed', '2018-12-06 15:23:32'),
(63, 'Material Inward', 4, 'Saved Material Inward. Inward ID 1', '2018-12-06 15:25:56'),
(64, 'Material Inward', 4, 'Saved Batch Number. Inward ID1', '2018-12-06 15:27:07'),
(65, 'Material Inward', 4, 'Updated Material Inward. Inward ID 1', '2018-12-06 15:28:22'),
(66, 'Material Inward', 4, 'Saved Batch Number. Inward ID1', '2018-12-06 15:30:29'),
(67, 'Material Inward', 4, 'Updated Material Inward. Inward ID 1', '2018-12-06 15:30:50'),
(68, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 6 Status Completed', '2018-12-06 15:31:32'),
(69, 'Material Inward', 4, 'Saved Material Inward. Inward ID 2', '2018-12-06 15:32:38'),
(70, 'Material Inward', 4, 'Saved Batch Number. Inward ID2', '2018-12-06 15:33:41'),
(71, 'Material Inward', 4, 'Saved Batch Number. Inward ID2', '2018-12-06 15:36:03'),
(72, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 6 Status Completed', '2018-12-06 15:36:23'),
(73, 'Material Inward', 4, 'Updated Material Inward. Inward ID 2', '2018-12-06 15:36:23'),
(74, 'Material Inward', 4, 'Saved Material Inward. Inward ID 3', '2018-12-06 15:39:56'),
(75, 'Material Inward', 4, 'Saved Batch Number. Inward ID3', '2018-12-06 15:40:34'),
(76, 'Material Inward', 4, 'Saved Batch Number. Inward ID3', '2018-12-06 15:41:57'),
(77, 'Material Inward', 4, 'Saved Batch Number. Inward ID3', '2018-12-06 15:43:56'),
(78, 'Material Inward', 4, 'Updated Material Inward. Inward ID 3', '2018-12-06 15:44:02'),
(79, 'Material Inward', 4, 'Saved Batch Number. Inward ID3', '2018-12-06 15:44:31'),
(80, 'Material Inward', 4, 'Updated Material Inward. Inward ID 3', '2018-12-06 15:44:39'),
(81, 'Material Inward', 4, 'Saved Material Inward. Inward ID 4', '2018-12-06 15:45:49'),
(82, 'Material Inward', 4, 'Saved Batch Number. Inward ID4', '2018-12-06 15:46:52'),
(83, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 2 Status Completed', '2018-12-06 15:47:02'),
(84, 'Material Inward', 4, 'Updated Material Inward. Inward ID 4', '2018-12-06 15:47:02'),
(85, 'General Inward', 4, 'Saved General Inward. Inward ID 5', '2018-12-06 15:48:23'),
(86, 'General Inward', 4, 'Saved Batch Number. Inward ID5', '2018-12-06 15:49:27'),
(87, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 7 Status Completed', '2018-12-06 15:49:39'),
(88, 'General Inward', 4, 'Updated General Inward. Inward ID 5', '2018-12-06 15:49:39'),
(89, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 7 Status Completed', '2018-12-06 15:50:10'),
(90, 'General Inward', 4, 'Saved General Inward. Inward ID 6', '2018-12-06 15:50:51'),
(91, 'General Inward', 4, 'Saved Batch Number. Inward ID6', '2018-12-06 15:51:24'),
(92, 'General Inward', 4, 'Updated General Inward. Inward ID 6', '2018-12-06 15:51:33'),
(93, 'General Inward', 4, 'Saved General Inward. Inward ID 7', '2018-12-06 15:52:53'),
(94, 'General Inward', 4, 'Saved Batch Number. Inward ID7', '2018-12-06 15:54:50'),
(95, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 3 Status Completed', '2018-12-06 15:54:59'),
(96, 'General Inward', 4, 'Updated General Inward. Inward ID 7', '2018-12-06 15:54:59'),
(97, 'Material Outward', 4, 'Material Requisation send to Purchase.', '2018-12-06 16:00:22'),
(98, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 3 Status Completed', '2018-12-06 17:12:05'),
(99, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 7 Status Completed', '2018-12-06 17:12:13'),
(100, 'General Inward', 4, 'Saved General Inward. Inward ID 8', '2018-12-06 17:12:49'),
(101, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 7 Status Completed', '2018-12-06 17:16:37'),
(102, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 3 Status Completed', '2018-12-06 17:16:43'),
(103, 'General Inward', 4, 'Saved Batch Number. Inward ID8', '2018-12-06 17:17:59'),
(104, 'General Inward', 4, 'Updated General Inward. Inward ID 8', '2018-12-06 17:18:47'),
(105, 'General Inward', 4, 'Saved General Inward. Inward ID 9', '2018-12-06 17:20:34'),
(106, 'General Inward', 4, 'Saved Batch Number. Inward ID9', '2018-12-06 17:22:50'),
(107, 'General Inward', 4, 'Saved Batch Number. Inward ID9', '2018-12-06 17:23:46'),
(108, 'General Inward', 4, 'Updated General Inward. Inward ID 9', '2018-12-06 17:23:56'),
(109, 'General Inward', 4, 'Saved Batch Number. Inward ID9', '2018-12-06 17:26:18'),
(110, 'General Inward', 4, 'Saved Batch Number. Inward ID9', '2018-12-06 17:27:01'),
(111, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 6 Status Completed', '2018-12-07 12:08:20'),
(112, 'Material Inward', 4, 'Updated Material Inward. Inward ID 2', '2018-12-07 12:08:20'),
(113, 'Material Inward', 4, 'Saved Batch Number. Inward ID2', '2018-12-07 12:10:02'),
(114, 'Purchase Order', 4, 'Purchase Status Updated. PO ID 6 Status Completed', '2018-12-07 12:10:16'),
(115, 'Material Inward', 4, 'Updated Material Inward. Inward ID 2', '2018-12-07 12:10:16'),
(116, 'Requisation', 1, 'Requisation Records Inserted. Requisation ID 32', '2018-12-07 13:02:36'),
(117, 'Requisation', 7, 'Requisation Records Updated. Requisation ID 32', '2018-12-07 13:46:47'),
(118, 'Requisation', 7, 'Requisation Status Changed. Requisation ID 32 AND Status approved', '2018-12-07 14:08:46'),
(119, 'Material Outward', 4, 'Material Requisation send to Purchase.', '2018-12-07 14:43:52'),
(120, 'Quotation', 4, 'Removed Selected Material. Material ID 61', '2018-12-07 16:50:08'),
(121, 'Quotation', 4, 'Removed Selected Material. Material ID 3', '2018-12-07 16:50:13'),
(122, 'Quotation', 4, 'Removed Selected Material. Material ID 17', '2018-12-07 16:50:17'),
(123, 'Purchase Material Requisation', 4, 'Requisation Status Changed. Requisation ID 32 AND Status approved', '2018-12-07 17:22:12'),
(124, 'Purchase Material Requisation', 4, 'Requisation Status Changed. Requisation ID 32 AND Status approved', '2018-12-07 17:22:20'),
(125, 'Purchase Material Requisation', 4, 'Requisation Status Changed. Requisation ID 32 AND Status approved', '2018-12-07 17:23:26'),
(126, 'Purchase Material Requisation', 4, 'Requisation Status Changed. Requisation ID 32 AND Status approved', '2018-12-07 17:24:02'),
(127, 'Material', 4, 'Material Updated Successfully. Material ID 3', '2018-12-08 09:27:20'),
(128, 'Material', 4, 'Material Updated Successfully. Material ID 17', '2018-12-08 09:43:55'),
(129, 'Material', 4, 'Material Updated Successfully. Material ID 17', '2018-12-08 09:44:39'),
(130, 'Material', 4, 'Material Updated Successfully. Material ID 17', '2018-12-08 09:45:22'),
(131, 'Material', 4, 'Material Updated Successfully. Material ID 17', '2018-12-08 09:45:53'),
(132, 'Material Outward', 4, 'Material Requisation send to Purchase.', '2018-12-08 10:43:06'),
(133, 'Purchase Material Requisation', 4, 'Requisation Status Changed. Requisation ID 28 AND Status approved', '2018-12-08 10:45:54'),
(134, 'Quotation', 4, 'Removed Selected Material. Material ID 3', '2018-12-08 10:53:17'),
(135, 'Quotation', 4, 'Removed Selected Material. Material ID 17', '2018-12-08 10:53:21'),
(136, 'Quotation', 4, 'Removed Selected Material. Material ID 61', '2018-12-08 10:53:25'),
(137, 'Requisation', 7, 'Requisation Records Updated. Requisation ID 29', '2018-12-08 11:06:10'),
(138, 'Requisation', 7, 'Requisation Records Updated. Requisation ID 29', '2018-12-08 11:09:36'),
(139, 'Requisation', 7, 'Requisation Status Changed. Requisation ID 29 AND Status approved', '2018-12-08 11:10:15'),
(140, 'Requisation', 7, 'Requisation Records Updated. Requisation ID 17', '2018-12-08 11:20:24'),
(141, 'Requisation', 7, 'Requisation Records Updated. Requisation ID 17', '2018-12-08 11:21:51'),
(142, 'Requisation', 7, 'Material Note Added. Material ID 25', '2018-12-08 11:24:13'),
(143, 'Requisation', 7, 'Material Note Added. Material ID 28', '2018-12-08 11:24:20'),
(144, 'Requisation', 7, 'Requisation Records Updated. Requisation ID 18', '2018-12-08 11:25:04'),
(145, 'Requisation', 7, 'Requisation Status Changed. Requisation ID 18 AND Status approved', '2018-12-08 11:25:18'),
(146, 'Material Outward', 4, 'Material Requisation send to Purchase.', '2018-12-10 11:29:04'),
(147, 'Material Outward', 4, 'Material Requisation send to Purchase.', '2018-12-10 11:29:49'),
(148, 'Material Outward', 4, 'Material Requisation send to Purchase.', '2018-12-10 11:30:12'),
(149, 'Material Outward', 4, 'Material Requisation send to Purchase.', '2018-12-10 11:30:21'),
(150, 'Requisation', 7, 'Material Note Added. Material ID 49', '2018-12-11 09:38:55'),
(151, 'Requisation', 7, 'Material Note Added. Material ID 53', '2018-12-11 09:39:01'),
(152, 'Requisation', 7, 'Requisation Records Inserted. Requisation ID 33', '2018-12-11 09:39:05'),
(153, 'Requisation', 7, 'Requisation Records Updated. Requisation ID 33', '2018-12-11 09:39:15'),
(154, 'Requisation', 7, 'Requisation Records Updated. Requisation ID 33', '2018-12-11 09:40:39'),
(155, 'Requisation', 7, 'Requisation Records Updated. Requisation ID 33', '2018-12-11 09:40:57'),
(156, 'Requisation', 7, 'Requisation Status Changed. Requisation ID 33 AND Status approved', '2018-12-11 10:18:31'),
(157, 'Material Outward', 4, 'Material Requisation send to Purchase.', '2018-12-11 10:19:23'),
(158, 'Material Requisation', 4, 'Material Requisation Status Updated. REQ ID 25 Status Completed', '2018-12-11 15:25:56'),
(159, 'Material Requisation', 4, 'Material Requisation Status Updated. REQ ID 25 Status Completed', '2018-12-11 15:33:04'),
(160, 'Quotation', 4, 'Removed Selected Material. Material ID 3', '2018-12-12 09:15:57'),
(161, 'Quotation', 4, 'Removed Selected Material. Material ID 17', '2018-12-12 09:16:01');

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
(5, 'umeshw', 'umesh@datar.com', '24b185b8e8395f9f6a850c343c118636', 'Umesh Wakalekar', '9845325845', 4, 20, NULL, 0, 1, '2018-09-05 18:07:31', NULL, NULL),
(6, 'account_user', 'account@datarpgx.com', '$2y$10$RjNXnlyNMmtrmFGY4C8GSeXuLgKJDopZsMkjRUSC1u5bI9Stxy.uq', 'Account User', '5475321458', 4, 24, '["dashboard-po_count", "dashboard-quotation_count", "dashboard-requisition_count", "material_requisition-add_new", "material_requisition-approved_requisition", "material_requisition-completed_requisition", "material_requisition-material_notes_view_edit", "material_requisition-pending_requisition", "material_requisition-view_edit", "material_requisition-view_materials", "quotation-accounts_approval_status", "quotation-approved_quotations_list", "quotation-pending_quotations_list", "quotation-quotations_list", "quotation-view_quotation_details"]', 0, 1, '2018-10-08 12:20:22', 1, '2018-10-23 10:37:05'),
(7, 'harjeetr', 'itd@datarpgx.com', '$2y$10$1ZHrY6S/LBsW.P3.HcM44.OI1Zei9D45yrxFVg7SLg1gEblzrkxXK', 'Harjeet R', '9845789852', 4, 20, '["all"]', 0, 1, '2018-12-07 13:14:17', NULL, NULL);

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
(6, 'f57UHwnAvNKpk4I02xBuQOLF9rVlb8', '::1', '2018-10-29 14:45:11', '2018-10-29 14:45:11', NULL),
(6, '3dYCGzbJr95eaXlUPMEZAsmWj7icBF', '::1', '2018-10-29 14:45:12', '2018-10-29 14:45:12', NULL),
(4, 'jryEN1lkM09PY5J3UxLKBhsgdQmWtn', '::1', '2018-11-26 17:41:55', '2018-11-26 17:41:55', NULL),
(4, 'Ks6Ya1pMQ2Z3fLPoRbt9nGWAwhxDiJ', '::1', '2018-11-26 17:41:55', '2018-11-26 17:41:55', NULL),
(4, 'INM1l2ZpkWQXYrCRsy0Sv5bUDHFogx', '::1', '2018-11-27 09:10:55', '2018-11-27 09:10:55', NULL),
(4, 'j43YsTGQgS9K8daCZF2yJz1RUwhfVl', '::1', '2018-11-27 09:10:55', '2018-11-27 09:10:55', NULL),
(4, 'DZWbyNH1qu92MLGV03cvPwxJBlR5kA', '::1', '2018-11-27 15:47:39', '2018-11-27 15:47:39', NULL),
(4, 'ILfYpE4Dhs2gWcuQxV1r589oFnOTZw', '::1', '2018-11-27 15:47:39', '2018-11-27 15:47:39', NULL),
(4, 'PMlLNfo1WbrytHegFK3RXCEVY7Ik9h', '::1', '2018-11-28 09:11:49', '2018-11-28 09:11:49', NULL),
(4, 'kUBd59nrKfL4uAlM8NtExjVYi23wID', '::1', '2018-11-28 09:11:49', '2018-11-28 09:11:49', NULL),
(4, 'A5cl2TUqInhwm7BOELS3C1deiGXZYK', '::1', '2018-11-28 09:11:49', '2018-11-28 09:11:49', NULL),
(4, 'SRZnIt8M9KpfhQcrNqezd2FyOb1vDg', '::1', '2018-11-28 10:06:08', '2018-11-28 10:06:08', NULL),
(4, 'y0HvJczmZ2I31NgWFhRfS6En8xdOar', '::1', '2018-11-28 10:06:08', '2018-11-28 10:06:08', NULL),
(4, 'pw9xHd8LkDW4E1Ale2JhiUySvKozMa', '::1', '2018-11-29 09:18:00', '2018-11-29 09:18:00', NULL),
(4, 'YnlQbSh1fCoFgrs7PpkdwIicuBRyqm', '::1', '2018-11-29 09:18:00', '2018-11-29 09:18:00', NULL),
(4, 'BVD8Ab0ZQvSqWPCK7XRy93En2d6ITO', '::1', '2018-11-29 10:04:06', '2018-11-29 10:04:06', NULL),
(4, 'otRMWpb0aqyn4wLT2OQXFGg17lvjIi', '::1', '2018-11-29 10:04:06', '2018-11-29 10:04:06', NULL),
(4, 'BG3amfIcEXk5ewny8dJNvZlM4KOFoC', '::1', '2018-11-29 15:00:08', '2018-11-29 15:00:08', NULL),
(4, 'EZtdNFlq61W9HaizXreAmVQv4R8Kpu', '::1', '2018-11-29 15:00:08', '2018-11-29 15:00:08', NULL),
(4, 'a8LMkKTr5VhDB2isZpJjwu3UOHPAfq', '::1', '2018-11-30 09:16:19', '2018-11-30 09:16:19', NULL),
(4, 'iVMt9RHcvLrAUBTqXudxy3f2D1N65I', '::1', '2018-11-30 09:16:20', '2018-11-30 09:16:20', NULL),
(1, 'uJjRHMVI2CKaUWx7NBTg0sqDcz6EXm', '::1', '2018-12-07 14:09:53', '2018-12-07 14:09:53', NULL),
(1, 'YdaKyos6cPVOpuDwXv0qtn3Mz4blST', '::1', '2018-12-07 14:09:53', '2018-12-07 14:09:53', NULL),
(4, '7VzBkhXgKvWOUIMAeElLsPai0tyGYZ', '::1', '2018-12-07 14:58:56', '2018-12-07 14:58:56', NULL),
(1, 'y0uYXJfnZbiNV3EIwHe4sh5WUSO6og', '::1', '2018-12-12 17:30:52', '2018-12-12 17:30:52', NULL),
(1, 'W4TYRmO0FpcGAX8aoU1xbJynzqDvg3', '::1', '2018-12-12 17:30:52', '2018-12-12 17:30:52', NULL);

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
-- Indexes for table `erp_material_inward_batchwise`
--
ALTER TABLE `erp_material_inward_batchwise`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `erp_material_inward_details`
--
ALTER TABLE `erp_material_inward_details`
  ADD PRIMARY KEY (`inward_details_id`);

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
-- Indexes for table `erp_material_outwards`
--
ALTER TABLE `erp_material_outwards`
  ADD PRIMARY KEY (`outward_id`);

--
-- Indexes for table `erp_material_outward_batchwise`
--
ALTER TABLE `erp_material_outward_batchwise`
  ADD PRIMARY KEY (`out_batch_id`);

--
-- Indexes for table `erp_material_outward_details`
--
ALTER TABLE `erp_material_outward_details`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `erp_payments_plan`
--
ALTER TABLE `erp_payments_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `erp_permission_keys`
--
ALTER TABLE `erp_permission_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `erp_purchase_material_requisition`
--
ALTER TABLE `erp_purchase_material_requisition`
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
-- Indexes for table `erp_sub_material_master`
--
ALTER TABLE `erp_sub_material_master`
  ADD PRIMARY KEY (`sub_mat_id`);

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
  MODIFY `inward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `erp_material_inward_batchwise`
--
ALTER TABLE `erp_material_inward_batchwise`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `erp_material_inward_details`
--
ALTER TABLE `erp_material_inward_details`
  MODIFY `inward_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `erp_material_inward_details_draft`
--
ALTER TABLE `erp_material_inward_details_draft`
  MODIFY `inward_draft_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `erp_material_master`
--
ALTER TABLE `erp_material_master`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `erp_material_outwards`
--
ALTER TABLE `erp_material_outwards`
  MODIFY `outward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `erp_material_outward_batchwise`
--
ALTER TABLE `erp_material_outward_batchwise`
  MODIFY `out_batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `erp_material_outward_details`
--
ALTER TABLE `erp_material_outward_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `erp_material_quotation_draft`
--
ALTER TABLE `erp_material_quotation_draft`
  MODIFY `quo_draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `erp_material_quotation_request`
--
ALTER TABLE `erp_material_quotation_request`
  MODIFY `quo_req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `erp_material_quotation_request_details`
--
ALTER TABLE `erp_material_quotation_request_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `erp_material_requisation_draft`
--
ALTER TABLE `erp_material_requisation_draft`
  MODIFY `req_draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `erp_material_requisition`
--
ALTER TABLE `erp_material_requisition`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `erp_material_requisition_details`
--
ALTER TABLE `erp_material_requisition_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;
--
-- AUTO_INCREMENT for table `erp_menu`
--
ALTER TABLE `erp_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `erp_payments_plan`
--
ALTER TABLE `erp_payments_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `erp_permission_keys`
--
ALTER TABLE `erp_permission_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `erp_purchase_material_requisition`
--
ALTER TABLE `erp_purchase_material_requisition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `erp_purchase_order`
--
ALTER TABLE `erp_purchase_order`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `erp_purchase_order_details`
--
ALTER TABLE `erp_purchase_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `erp_purchase_order_details_draft`
--
ALTER TABLE `erp_purchase_order_details_draft`
  MODIFY `po_draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;
--
-- AUTO_INCREMENT for table `erp_sub_categories`
--
ALTER TABLE `erp_sub_categories`
  MODIFY `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;
--
-- AUTO_INCREMENT for table `erp_sub_material_master`
--
ALTER TABLE `erp_sub_material_master`
  MODIFY `sub_mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
