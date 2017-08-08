-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2017 at 09:13 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_component`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE IF NOT EXISTS `tbl_class` (
  `cls_id` int(5) NOT NULL,
  `cls_name` varchar(100) NOT NULL,
  `cls_supplier` varchar(255) NOT NULL,
  `cls_life` int(5) NOT NULL,
  `cls_life_period` int(2) NOT NULL COMMENT '1-hour, 2-day, 3-month, 4-year'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component`
--

CREATE TABLE IF NOT EXISTS `tbl_component` (
  `cmp_id` int(7) NOT NULL,
  `cmp_class_id` int(5) NOT NULL,
  `cmp_machine_id` int(5) NOT NULL,
  `cmp_type` varchar(100) NOT NULL,
  `cmp_vendor` varchar(255) NOT NULL,
  `cmp_arrival_on` date NOT NULL,
  `cmp_status` int(2) NOT NULL COMMENT '1-not fitted, 2-fitted, 3-nearing expiry, 4-expiry crossed, 5-expired',
  `cmp_fitted_on` date NOT NULL,
  `cmp_fitted_by` varchar(100) NOT NULL,
  `cmp_expired_on` date NOT NULL,
  `cmp_defect_type` varchar(200) NOT NULL,
  `cmp_removed_by` varchar(100) NOT NULL,
  `cmp_used_hours` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hour_log`
--

CREATE TABLE IF NOT EXISTS `tbl_hour_log` (
  `log_id` int(10) NOT NULL,
  `log_machine_id` int(5) NOT NULL,
  `log_entry_on` date NOT NULL,
  `log_entry_by` varchar(100) NOT NULL,
  `log_hours` int(3) NOT NULL,
  `log_checked` int(2) NOT NULL DEFAULT '1' COMMENT '1-not checked, 2-checked'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_machine`
--

CREATE TABLE IF NOT EXISTS `tbl_machine` (
  `mac_id` int(5) NOT NULL,
  `mac_name` varchar(255) NOT NULL,
  `mac_hours` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
