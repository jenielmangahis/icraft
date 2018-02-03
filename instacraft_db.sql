-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2018 at 07:54 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instacraft_db`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`instacraftdb`@`%` FUNCTION `categoryNamesByItemId` (`itemid` INT) RETURNS VARCHAR(255) CHARSET latin1 NO SQL
BEGIN
declare categories varchar(255);
set categories=(SELECT GROUP_CONCAT(' ', category.name) AS  "categories" from items left join item_category_mapping as mapping on items.item_id=mapping.item_id join category on category.category_id=mapping.category_id  where items.item_id=itemid);
RETURN categories;
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `deliveredOnTimePercentage` (`driverid` INT) RETURNS VARCHAR(100) CHARSET latin1 NO SQL
return "0"$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `doctorAppointmentCount` (`doctorid` INT) RETURNS INT(11) NO SQL
BEGIN
declare appointmentCount varchar(255);
set appointmentCount=(select count(id) from appointment_details where doctor_id=doctorid);
RETURN appointmentCount;
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `driverActivePercentage` (`driverid` INT) RETURNS VARCHAR(100) CHARSET latin1 NO SQL
return "0"$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `driverAvgDeliveryTime` (`driverid` INT) RETURNS TIME NO SQL
BEGIN
declare Avg varchar(255);
set Avg=(select AVG(delivered_time) from  driver_assigned_order where driver_id=driverid and order_status='6');
RETURN Avg;
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `driverAvgRating` (`driverid` INT) RETURNS VARCHAR(100) CHARSET latin1 NO SQL
BEGIN
declare AvgRating varchar(255);
set AvgRating=(select AVG(rating) from  driver_review_rating where driver_id=driverid);
RETURN FLOOR(AvgRating);
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `driverAvgStopTime` (`driverid` INT) RETURNS TIME NO SQL
return "00:00:00"$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `fetchPrescription` (`userid` INT) RETURNS VARCHAR(512) CHARSET latin1 NO SQL
BEGIN
declare bothimage varchar(255);
set bothimage=(SELECT CONCAT(`prescription_front_image`,',',`prescription_back_image`) AS bimage FROM prescriptions WHERE user_id =userid ORDER BY id DESC LIMIT 1);
RETURN bothimage;
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `fn_returnOrderStatusName` (`stausid` ENUM('0','1','2','3','4','5','6','7')) RETURNS VARCHAR(20) CHARSET latin1 BEGIN

declare statusname varchar(20);

if(stausid='0') then set statusname = 'Unsigned';
RETURN statusname;
end if;
 if (stausid='1') then set statusname = 'Assigned';
 RETURN statusname;
end if;
 if (stausid='2') then set statusname = 'in-transit/Start';
 RETURN statusname;
end if;
 if (stausid='3') then set statusname = 'Hold';
 RETURN statusname;
end if;
 if (stausid='4') then set statusname = 'Reached';
 RETURN statusname;
end if;
 if (stausid='5') then set statusname = 'Return';
 RETURN statusname;
end if;
 if (stausid='6') then set statusname = 'Delivered';
 RETURN statusname;

else  set statusname = 'Delayed';
RETURN statusname;
end if;


end$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `getDriverGrade` (`driverid` INT) RETURNS VARCHAR(100) CHARSET latin1 NO SQL
return "C"$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `getFamillyType` (`famillyid` INT) RETURNS VARCHAR(255) CHARSET latin1 NO SQL
BEGIN
declare famillyType varchar(255);
set famillyType=(SELECT name AS  "familly" from item_familly where item_familly.id=famillyid);
RETURN famillyType;
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `itemQtyIsAvailable` (`driverid` INT, `itemid` INT) RETURNS INT(11) NO SQL
BEGIN
declare qtyAvailability varchar(255);
set qtyAvailability=(select SUM(item_quantity) from driver_inventory where driver_id=driverid and item_id=itemid);
RETURN qtyAvailability;
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `totalBreakCount` (`fromdate` VARCHAR(255), `todate` VARCHAR(255), `driverid` INT) RETURNS VARCHAR(255) CHARSET latin1 NO SQL
BEGIN
declare totalBreakCount varchar(255);
set totalBreakCount=(select count(break_id) from break_clock where (date BETWEEN fromdate AND todate) and driver_id=driverid);
RETURN totalBreakCount;
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `totalBreakTime` (`fromdate` VARCHAR(255), `todate` VARCHAR(255), `driverid` INT) RETURNS VARCHAR(255) CHARSET latin1 NO SQL
BEGIN
declare totalShiftTime varchar(255);
set totalShiftTime=(select SEC_TO_TIME(SUM(total_time)) from break_clock where (date BETWEEN fromdate AND todate) and driver_id=driverid);
RETURN totalShiftTime;
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `totalDeliveredOrder` (`fromdate` VARCHAR(255), `todate` VARCHAR(255), `driverid` INT) RETURNS VARCHAR(255) CHARSET latin1 NO SQL
BEGIN
declare totalDeliveredOrder varchar(255);
set totalDeliveredOrder=(select count(id) from driver_assigned_order where (order_date BETWEEN fromdate AND todate) and driver_id=driverid and order_status='6');
RETURN totalDeliveredOrder;
END$$

CREATE DEFINER=`instacraftdb`@`%` FUNCTION `totalShiftTime` (`fromdate` VARCHAR(255), `todate` VARCHAR(255), `driverid` INT) RETURNS VARCHAR(255) CHARSET latin1 NO SQL
BEGIN
declare totalShiftTime varchar(255);
set totalShiftTime=(select SEC_TO_TIME(SUM(total_time)) from shift_clock where (date BETWEEN fromdate AND todate) and driver_id=driverid);
RETURN totalShiftTime;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fname` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `user_right` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1-admin, 2-user',
  `allowed_menus` varchar(64) NOT NULL COMMENT 'super_Admin-all, rest-comma_separted  ',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last Login Time ',
  `created_from` int(5) NOT NULL,
  `deleted_from` int(5) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_time` timestamp NULL DEFAULT NULL,
  `active` enum('1','2') NOT NULL COMMENT '1- activated, 2- deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `fname`, `lname`, `password`, `phone`, `user_right`, `allowed_menus`, `last_login`, `created_from`, `deleted_from`, `created_date`, `deleted_time`, `active`) VALUES
(1, 'admin@gmail.com', 'Super', 'Admin', 'e10adc3949ba59abbe56e057f20f883e', '66879879877', '1', '1,2,3,4,5,6,7,8,9,10,11,12', '2017-10-05 16:32:18', 1, 0, '2017-09-22 06:31:42', '0000-00-00 00:00:00', '1'),
(4, 'niraj@gmail.com', 'Niraj', 'Kumar', '89713a204bfd81898b9894325104cd39', '888952343543', '2', '1,6,7', '0000-00-00 00:00:00', 1, 0, '2017-10-06 10:43:29', '0000-00-00 00:00:00', '1'),
(5, 'retro@gmail.com', 'Retro', 'Samaru', 'e10adc3949ba59abbe56e057f20f883e', '99587954688', '2', '1,2,3,4,5,9,10,11,12', '0000-00-00 00:00:00', 1, 0, '2017-10-06 11:29:58', '0000-00-00 00:00:00', '1'),
(6, 'qwery@tech.com', 'qwery', 'qwery', '252f88f8fab9832397d8b6de9a194667', '0123456789', '2', '1', '0000-00-00 00:00:00', 1, 0, '2018-01-05 07:21:30', '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_details`
--

CREATE TABLE `appointment_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `other_consultation_request` int(11) NOT NULL,
  `paid_amount` double NOT NULL,
  `transaction_no` varchar(255) NOT NULL,
  `rescheduled_date` date NOT NULL,
  `rescheduled_time` time NOT NULL,
  `status` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT '0=>pending,1=>confirm,2=>reschedule,3=>cancel',
  `reschedule_resason` text,
  `cancel_reason` text,
  `consultation_for` text NOT NULL,
  `videoRoomId` varchar(255) DEFAULT NULL,
  `call_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment_details`
--

INSERT INTO `appointment_details` (`id`, `user_id`, `doctor_id`, `appointment_date`, `appointment_time`, `other_consultation_request`, `paid_amount`, `transaction_no`, `rescheduled_date`, `rescheduled_time`, `status`, `reschedule_resason`, `cancel_reason`, `consultation_for`, `videoRoomId`, `call_status`, `created_at`, `updated_at`) VALUES
(1, 209, 138, '2017-12-01', '21:19:00', 1, 123456, '123456', '0000-00-00', '00:00:00', '1', NULL, NULL, '1,2,5,3,4', 'room-d020ba', '', '2017-11-25 07:40:16', '0000-00-00 00:00:00'),
(2, 209, 85, '2017-11-29', '18:30:00', 1, 123456, '123456', '0000-00-00', '00:00:00', '1', NULL, NULL, '1,2,5,8,3,4', NULL, NULL, '2017-11-25 07:43:52', '0000-00-00 00:00:00'),
(3, 209, 123, '2017-11-30', '11:15:00', 1, 123456, '123456', '0000-00-00', '00:00:00', '0', NULL, NULL, '1,2', NULL, '', '2017-11-25 09:50:24', '0000-00-00 00:00:00'),
(4, 209, 214, '2017-12-09', '17:15:00', 1, 0, '', '0000-00-00', '09:19:00', '2', NULL, '', '7', NULL, NULL, '2017-12-09 11:46:58', '0000-00-00 00:00:00'),
(5, 209, 214, '2017-12-09', '17:15:00', 1, 0, '', '0000-00-00', '09:19:00', '2', NULL, '', '7', NULL, NULL, '2017-12-09 11:48:31', '0000-00-00 00:00:00'),
(6, 209, 214, '2017-12-09', '17:15:00', 1, 0, '', '0000-00-00', '09:19:00', '2', NULL, '', '8', NULL, NULL, '2017-12-09 11:49:53', '0000-00-00 00:00:00'),
(7, 209, 214, '2017-12-09', '17:15:00', 1, 0, '', '0000-00-00', '09:19:00', '2', NULL, '', '8', NULL, NULL, '2017-12-09 11:51:54', '0000-00-00 00:00:00'),
(8, 209, 214, '2017-12-19', '12:35:00', 1, 0, '', '0000-00-00', '09:19:00', '2', NULL, '', '5,7,4', 'room-f5ba98', 'ringing', '2017-12-15 13:00:20', '0000-00-00 00:00:00'),
(9, 227, 214, '2018-01-02', '08:15:00', 1, 0, '', '2018-02-07', '09:00:00', '3', NULL, 'dd', '1,5', NULL, NULL, '2018-01-02 14:23:35', '0000-00-00 00:00:00'),
(10, 227, 214, '2018-01-03', '08:15:00', 1, 0, '', '2018-02-07', '09:00:00', '3', NULL, 'dd', '1,5,7', NULL, NULL, '2018-01-03 05:33:25', '0000-00-00 00:00:00'),
(11, 227, 214, '2018-01-03', '18:45:00', 1, 0, '', '2018-02-07', '09:00:00', '3', NULL, 'dd', '1,2,5,6,7,8,3,4,9', NULL, NULL, '2018-01-03 06:53:21', '0000-00-00 00:00:00'),
(12, 227, 214, '2018-01-03', '12:30:00', 1, 0, '', '2018-02-07', '09:00:00', '3', NULL, 'dd', '1,2', NULL, NULL, '2018-01-03 06:59:01', '0000-00-00 00:00:00'),
(13, 216, 214, '2018-01-03', '12:45:00', 1, 0, '', '0000-00-00', '00:00:00', '1', NULL, NULL, '3', NULL, NULL, '2018-01-03 07:08:06', '0000-00-00 00:00:00'),
(14, 228, 214, '2018-01-03', '18:45:00', 1, 0, '', '0000-00-00', '00:00:00', '0', NULL, NULL, '5,7,3', NULL, NULL, '2018-01-03 07:24:50', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_fee_details`
--

CREATE TABLE `appointment_fee_details` (
  `id` int(11) NOT NULL,
  `fee` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment_fee_details`
--

INSERT INTO `appointment_fee_details` (`id`, `fee`, `created_at`, `updated_at`) VALUES
(1, 100, '2017-10-04 13:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `break_clock`
--

CREATE TABLE `break_clock` (
  `break_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `edited_start_time` time NOT NULL DEFAULT '00:00:00',
  `break_type` time NOT NULL,
  `end_time` time NOT NULL DEFAULT '00:00:00',
  `edited_end_time` time NOT NULL DEFAULT '00:00:00',
  `total_time` time NOT NULL DEFAULT '00:00:00',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `break_clock`
--

INSERT INTO `break_clock` (`break_id`, `driver_id`, `shift_id`, `start_time`, `edited_start_time`, `break_type`, `end_time`, `edited_end_time`, `total_time`, `date`) VALUES
(1, 0, 1, '13:10:00', '00:00:00', '15:00:00', '13:25:00', '00:00:00', '00:00:00', '2017-08-25'),
(3, 0, 5, '11:28:00', '00:00:00', '15:00:00', '11:40:00', '00:00:00', '00:00:00', '2017-08-25'),
(15, 0, 5, '12:53:00', '00:00:00', '15:00:00', '00:00:00', '00:00:00', '00:00:00', '2017-08-25'),
(18, 0, 6, '12:24:00', '00:00:00', '15:00:00', '12:26:00', '00:00:00', '00:00:00', '2017-08-28'),
(19, 0, 6, '12:26:00', '00:00:00', '15:00:00', '00:00:00', '00:00:00', '00:00:00', '2017-08-28'),
(20, 1, 7, '11:09:00', '00:00:00', '15:00:00', '11:10:00', '00:00:00', '00:01:00', '2017-09-04'),
(21, 1, 7, '11:40:00', '00:00:00', '15:00:00', '11:41:00', '00:00:00', '00:01:00', '2017-09-04'),
(22, 1, 35, '13:58:00', '00:00:00', '15:00:00', '00:00:00', '00:00:00', '00:00:00', '2017-09-18'),
(23, 1, 37, '10:12:00', '00:00:00', '00:00:05', '00:00:00', '00:00:00', '00:00:00', '2017-09-19'),
(24, 1, 41, '10:29:00', '00:00:00', '00:00:05', '00:00:00', '00:00:00', '00:00:00', '2017-09-19'),
(25, 1, 44, '12:24:00', '00:00:00', '00:00:05', '12:29:00', '00:00:00', '00:05:00', '2017-09-19'),
(26, 1, 44, '12:29:00', '00:00:00', '00:00:05', '12:42:00', '00:00:00', '00:13:00', '2017-09-19'),
(27, 1, 44, '12:42:00', '00:00:00', '00:00:05', '00:00:00', '00:00:00', '00:00:00', '2017-09-19'),
(28, 1, 53, '09:16:00', '00:00:00', '00:00:05', '09:22:00', '00:00:00', '00:06:00', '2017-10-06'),
(29, 1, 53, '11:55:00', '00:00:00', '00:00:05', '11:56:00', '00:00:00', '00:01:00', '2017-10-06'),
(30, 1, 53, '12:46:00', '00:00:00', '00:00:10', '12:50:00', '00:00:00', '00:04:00', '2017-10-06'),
(31, 1, 53, '12:51:00', '00:00:00', '00:00:05', '12:51:00', '00:00:00', '00:00:00', '2017-10-06'),
(32, 1, 54, '13:08:00', '00:00:00', '00:00:05', '13:08:00', '00:00:00', '00:00:00', '2017-10-06'),
(33, 1, 55, '07:29:00', '00:00:00', '00:05:00', '08:04:00', '00:00:00', '00:35:00', '2017-10-07'),
(34, 1, 55, '09:27:00', '00:00:00', '00:10:00', '09:27:00', '00:00:00', '00:00:00', '2017-10-07'),
(35, 1, 55, '09:27:00', '00:00:00', '00:05:00', '09:29:00', '00:00:00', '00:02:00', '2017-10-07'),
(36, 1, 55, '10:27:00', '00:00:00', '00:15:00', '10:28:00', '00:00:00', '00:01:00', '2017-10-07'),
(37, 1, 55, '10:28:00', '00:00:00', '00:05:00', '10:28:00', '00:00:00', '00:00:00', '2017-10-07'),
(38, 1, 55, '10:28:00', '00:00:00', '01:00:00', '10:28:00', '00:00:00', '00:00:00', '2017-10-07'),
(39, 1, 56, '07:18:00', '00:00:00', '00:15:00', '09:46:00', '00:00:00', '02:28:00', '2017-10-09'),
(40, 1, 56, '09:46:00', '00:00:00', '01:00:00', '09:46:00', '00:00:00', '00:00:00', '2017-10-09'),
(41, 1, 56, '10:05:00', '00:00:00', '00:15:00', '11:20:00', '00:00:00', '01:15:00', '2017-10-09'),
(42, 1, 56, '11:30:00', '00:00:00', '00:15:00', '11:36:00', '00:00:00', '00:06:00', '2017-10-09'),
(43, 1, 56, '11:46:00', '00:00:00', '00:15:00', '11:47:00', '00:00:00', '00:01:00', '2017-10-09'),
(44, 1, 56, '11:56:00', '00:00:00', '00:15:00', '12:05:00', '00:00:00', '00:09:00', '2017-10-09'),
(45, 1, 56, '12:05:00', '00:00:00', '00:05:00', '12:53:00', '00:00:00', '00:48:00', '2017-10-09'),
(46, 1, 57, '14:02:00', '00:00:00', '00:15:00', '14:03:00', '00:00:00', '00:01:00', '2017-10-10'),
(47, 1, 57, '14:03:00', '00:00:00', '00:05:00', '14:04:00', '00:00:00', '00:01:00', '2017-10-10'),
(48, 1, 59, '14:08:00', '00:00:00', '00:15:00', '00:00:00', '00:00:00', '00:00:00', '2017-10-11'),
(49, 1, 60, '11:04:00', '00:00:00', '00:15:00', '11:12:00', '00:00:00', '00:08:00', '2017-10-12'),
(50, 1, 60, '11:12:00', '00:00:00', '00:15:00', '11:13:00', '00:00:00', '00:01:00', '2017-10-12'),
(51, 1, 60, '11:13:00', '00:00:00', '00:10:00', '11:17:00', '00:00:00', '00:04:00', '2017-10-12'),
(52, 1, 60, '11:17:00', '00:00:00', '00:05:00', '11:18:00', '00:00:00', '00:01:00', '2017-10-12'),
(53, 1, 60, '11:18:00', '00:00:00', '00:15:00', '11:18:00', '00:00:00', '00:00:00', '2017-10-12'),
(54, 1, 63, '09:42:00', '00:00:00', '00:05:00', '09:42:00', '00:00:00', '00:00:00', '2017-12-19'),
(55, 1, 63, '09:42:00', '00:00:00', '00:15:00', '09:42:00', '00:00:00', '00:00:00', '2017-12-19'),
(56, 1, 63, '09:42:00', '00:00:00', '01:00:00', '09:42:00', '00:00:00', '00:00:00', '2017-12-19'),
(57, 1, 63, '09:43:00', '00:00:00', '00:10:00', '09:43:00', '00:00:00', '00:00:00', '2017-12-19'),
(58, 1, 63, '09:43:00', '00:00:00', '00:15:00', '09:47:00', '00:00:00', '00:04:00', '2017-12-19'),
(59, 1, 82, '12:02:00', '00:00:00', '00:15:00', '12:02:00', '00:00:00', '00:00:00', '2017-12-20'),
(60, 1, 84, '12:08:00', '00:00:00', '01:00:00', '13:16:00', '00:00:00', '01:08:00', '2017-12-20'),
(61, 1, 84, '13:22:00', '00:00:00', '00:05:00', '13:24:00', '00:00:00', '00:02:00', '2017-12-20'),
(62, 1, 91, '09:53:00', '00:00:00', '00:05:00', '09:54:00', '00:00:00', '00:01:00', '2017-12-27'),
(63, 1, 91, '10:54:00', '00:00:00', '00:10:00', '10:54:00', '00:00:00', '00:00:00', '2017-12-27'),
(64, 1, 91, '11:16:00', '00:00:00', '00:10:00', '11:19:00', '00:00:00', '00:03:00', '2017-12-27'),
(65, 1, 91, '11:19:00', '00:00:00', '00:05:00', '00:00:00', '00:00:00', '00:00:00', '2017-12-27'),
(66, 1, 92, '11:15:00', '00:00:00', '00:10:00', '11:20:00', '00:00:00', '00:05:00', '2017-12-28'),
(67, 1, 94, '04:04:00', '00:00:00', '00:05:00', '04:04:00', '00:00:00', '00:00:00', '2018-01-01'),
(68, 1, 95, '12:08:00', '00:00:00', '00:05:00', '12:08:00', '00:00:00', '00:00:00', '2018-01-02'),
(69, 1, 95, '12:13:00', '00:00:00', '00:05:00', '12:13:00', '00:00:00', '00:00:00', '2018-01-02'),
(70, 1, 96, '05:57:00', '00:00:00', '00:05:00', '05:57:00', '00:00:00', '00:00:00', '2018-01-03');

-- --------------------------------------------------------

--
-- Table structure for table `break_interval`
--

CREATE TABLE `break_interval` (
  `id` int(11) NOT NULL,
  `time_minute` time NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>not active,1=>active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `break_interval`
--

INSERT INTO `break_interval` (`id`, `time_minute`, `status`, `created_at`) VALUES
(1, '00:05:00', '1', '2017-08-22 18:30:00'),
(2, '00:10:00', '1', '2017-08-23 09:33:44'),
(3, '00:15:00', '1', '2017-08-23 09:33:53'),
(4, '01:00:00', '1', '2017-10-07 05:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `caregiver_details`
--

CREATE TABLE `caregiver_details` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `telephone_number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `designee_name` varchar(100) NOT NULL,
  `designee_signature_image` varchar(255) NOT NULL,
  `identification_number` int(11) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `caregiver_details`
--

INSERT INTO `caregiver_details` (`id`, `name`, `telephone_number`, `email`, `designee_name`, `designee_signature_image`, `identification_number`, `city`, `state`, `country`, `zip_code`, `created_at`, `updated_at`) VALUES
(1, 'caregiver1', '8563256987', 'caregiver1@gmail.com', 'designee1', '', 123456, 'delhi', 'delhi', 'india', 256325, '2017-10-08 13:00:00', '0000-00-00 00:00:00'),
(2, 'caregiver2', '8563256987', 'caregiver1@gmail.com', 'caregiver2', '', 875689, 'noida', 'up', 'india', 452145, '2017-10-08 13:00:00', '0000-00-00 00:00:00'),
(3, 'Rakesh', '1234567890', 'rakesh.kumar@techaheadcorp.com', 'Raka', '', 123456, 'SGNR', 'Raj', 'India', 335001, '2017-12-13 07:01:21', '0000-00-00 00:00:00'),
(4, 'Ankit', '12345677', 'ankit@gmail.com', 'sdfds', '', 765435, 'SGNR', 'Raj', 'India', 335001, '2017-12-13 07:22:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `item_id`, `quantity`, `user_id`, `created_at`, `updated_at`) VALUES
(28, 1, 1, 218, '2018-01-08 02:49:41', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL COMMENT '0=>parent',
  `status` enum('0','1') NOT NULL COMMENT '0=>not active,1=>active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'THC', 0, '1', '2017-08-29 06:41:57', '0000-00-00 00:00:00'),
(2, 'Sativa', 1, '1', '2017-08-28 18:30:00', '0000-00-00 00:00:00'),
(3, 'Flowers', 0, '1', '2017-09-27 18:30:00', '0000-00-00 00:00:00'),
(4, 'CBD', 0, '1', '2017-10-03 14:26:07', '0000-00-00 00:00:00'),
(5, 'Rare Items', 1, '1', '2017-10-02 18:30:00', '0000-00-00 00:00:00'),
(6, 'By Purpose', 3, '1', '2017-10-03 14:27:05', '0000-00-00 00:00:00'),
(7, 'Everything', 0, '1', '2017-10-02 18:30:00', '0000-00-00 00:00:00'),
(8, 'Category Check', 0, '1', '2017-10-03 16:04:07', '0000-00-00 00:00:00'),
(9, 'assdasda', 0, '1', '2017-10-07 09:44:45', '0000-00-00 00:00:00'),
(10, 'Category3', 0, '1', '2017-10-07 09:47:01', '0000-00-00 00:00:00'),
(11, 'Asdsfdsfsd', 0, '1', '2017-10-07 09:47:47', '0000-00-00 00:00:00'),
(12, 'New Category', 0, '1', '2017-10-07 09:48:35', '0000-00-00 00:00:00'),
(13, 'qwerty', 0, '1', '2018-01-04 07:06:06', '0000-00-00 00:00:00'),
(14, 'xyzuv', 0, '1', '2018-01-05 05:58:39', '0000-00-00 00:00:00'),
(15, 'abcde', 0, '1', '2018-01-05 06:00:21', '0000-00-00 00:00:00'),
(16, 'Product', 0, '1', '2018-01-05 06:10:07', '0000-00-00 00:00:00'),
(17, 'product1', 0, '1', '2018-01-05 06:11:15', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_type`
--

CREATE TABLE `consultation_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_other` enum('0','1') NOT NULL COMMENT '1=>true,0=>false',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultation_type`
--

INSERT INTO `consultation_type` (`id`, `name`, `is_other`, `created_at`, `updated_at`) VALUES
(1, 'AIDS', '0', '2017-09-25 13:00:00', '0000-00-00 00:00:00'),
(2, 'Cancer', '0', '2017-09-25 13:00:00', '0000-00-00 00:00:00'),
(3, 'Get a good night rest', '1', '2017-09-26 06:44:38', '0000-00-00 00:00:00'),
(4, 'Conquer anxiety', '1', '2017-09-26 06:44:53', '0000-00-00 00:00:00'),
(5, 'Muscle spasm', '0', '2017-10-02 18:30:00', '0000-00-00 00:00:00'),
(6, 'Anorexia', '0', '2017-10-02 18:30:00', '0000-00-00 00:00:00'),
(7, 'Chronic pain', '0', '2017-10-03 12:22:45', '0000-00-00 00:00:00'),
(8, 'Nausia', '0', '2017-10-02 18:30:00', '0000-00-00 00:00:00'),
(9, 'Fight fagigue', '1', '2017-10-03 12:25:19', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_support`
--

CREATE TABLE `contact_support` (
  `support_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `support_type` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_support`
--

INSERT INTO `contact_support` (`support_id`, `email`, `contact_number`, `support_type`, `created_at`) VALUES
(1, 'support@gmail.com', '8112314653', 'contact_us', '2017-08-23 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `driver_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `message`, `driver_id`, `created_at`, `updated_at`) VALUES
(1, 'hello sdfsdfsdf sfsdfsdfsdf', 1, '2017-08-23 18:30:00', '0000-00-00 00:00:00'),
(2, 'test', 1, '2017-08-24 09:47:20', '0000-00-00 00:00:00'),
(3, 'test', 1, '2017-08-24 09:48:58', '0000-00-00 00:00:00'),
(4, 'test', 1, '2017-08-24 09:53:32', '0000-00-00 00:00:00'),
(5, 'hi', 1, '2017-08-24 13:42:13', '0000-00-00 00:00:00'),
(6, 'hi', 1, '2017-09-21 12:21:54', '0000-00-00 00:00:00'),
(7, 'Test by iOS', 1, '2017-10-04 04:17:41', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL COMMENT 'Coupon Name ',
  `code` varchar(20) NOT NULL COMMENT 'Coupon code consists on 20 chars uniquely',
  `min_order_price` int(10) NOT NULL,
  `points` int(11) NOT NULL COMMENT 'int val e:g; 200, 325',
  `redeem_count` int(11) NOT NULL COMMENT 'int val e:g; 20, 35',
  `discount` float NOT NULL COMMENT '% int  as 7 , 15',
  `discount_type` enum('1','2') NOT NULL COMMENT '1-amount, 2-percentage',
  `validity` int(11) NOT NULL COMMENT 'validity in month as 6 month from created date',
  `status` int(11) NOT NULL COMMENT '0-Deleted, 1- Active',
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `category_id`, `name`, `code`, `min_order_price`, `points`, `redeem_count`, `discount`, `discount_type`, `validity`, `status`, `valid_from`, `valid_to`, `created_at`, `updated_at`) VALUES
(1, 1, 'Boom your wishes into reality', 'BOOM5', 0, 110, 5, 30, '2', 3, 1, '2017-10-01', '2017-10-03', '2017-10-04 17:44:00', '2017-10-04 14:54:26'),
(2, 2, 'Boom your wishes alnight', 'BOOM6', 0, 150, 5, 18, '2', 2, 1, '2017-10-04', '2017-10-27', '2017-10-08 18:00:29', '2017-10-05 13:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_availability`
--

CREATE TABLE `doctor_availability` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `mon` varchar(255) DEFAULT NULL,
  `tue` varchar(255) NOT NULL,
  `wed` varchar(255) NOT NULL,
  `thu` varchar(255) NOT NULL,
  `fri` varchar(255) NOT NULL,
  `sat` varchar(255) NOT NULL,
  `sun` varchar(255) NOT NULL,
  `time_slot_id` int(11) NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor_availability`
--

INSERT INTO `doctor_availability` (`id`, `doctor_id`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`, `time_slot_id`, `from_time`, `to_time`, `created_at`, `updated_at`) VALUES
(1, 214, '1', '1', '1', '1', '1', '1', '1', 0, '01:00:00', '23:00:00', '2018-01-02 04:35:43', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_professional_information`
--

CREATE TABLE `doctor_professional_information` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `license_number` varchar(250) NOT NULL,
  `signature_or_document` varchar(255) NOT NULL,
  `doc1_name` varchar(64) NOT NULL,
  `doc2_name` varchar(64) NOT NULL,
  `doc3_name` varchar(64) NOT NULL,
  `doc1_url` varchar(255) NOT NULL,
  `doc2_url` varchar(255) NOT NULL,
  `doc3_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor_professional_information`
--

INSERT INTO `doctor_professional_information` (`id`, `doctor_id`, `specialization`, `experience`, `license_number`, `signature_or_document`, `doc1_name`, `doc2_name`, `doc3_name`, `doc1_url`, `doc2_url`, `doc3_url`, `created_at`, `updated_at`) VALUES
(1, 22, 'MBBS', '2 years', 'fsgAseZt9sKp9L', '', '', '', '', '', '', '', '2017-09-21 07:53:09', '0000-00-00 00:00:00'),
(2, 28, 'MD', '4 Year', 'asdasd6aeb6Sxz', '', '', '', '', '', '', '', '2017-09-25 18:30:00', '0000-00-00 00:00:00'),
(9, 83, '', '', '', '', 'asdasdasd', 'sdfasdas', '78678678', 'http://instacraft1.s3.amazonaws.com/driver/pics/androidbg_s51_1506328849.jpg', 'http://instacraft1.s3.amazonaws.com/driver/pics/android_sbg57_1506328851.png', 'http://instacraft1.s3.amazonaws.com/driver/pics/android_welcome77_1506328853.jpg', '2017-09-25 08:40:55', '0000-00-00 00:00:00'),
(10, 85, 'BDS', '1 Year', 'asdfsguhwrducx', '', 'aaaaaa', 'bbbbbbbbbb', 'ccccccccccccc', 'http://instacraft1.s3.amazonaws.com/driver/pics/apposter64_1506332369.png', 'http://instacraft1.s3.amazonaws.com/driver/pics/androidbg_s49_1506332370.jpg', 'http://instacraft1.s3.amazonaws.com/driver/pics/android-app-banner90_1506332372.jpg', '2017-09-25 09:39:34', '0000-00-00 00:00:00'),
(11, 96, '', '', '', '', 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsdf', 'http://instacraft1.s3.amazonaws.com/driver/pics/android-o23_1506333664.jpg', 'http://instacraft1.s3.amazonaws.com/driver/pics/android-o23_1506333664.jpg', 'http://instacraft1.s3.amazonaws.com/driver/pics/android-o49_1506333793.png', '2017-09-25 10:03:15', '0000-00-00 00:00:00'),
(12, 138, 'ENT', '8', 'ANKIT2027', 'http://instacraft1.s3.amazonaws.com/signature/1506607081old-doorbell-x.jpg', '', '', '', '', '', '', '2017-09-28 13:57:31', '0000-00-00 00:00:00'),
(13, 214, 'gtt', 'ttt', '', 'http://instacraft1.s3.amazonaws.com/signature/1514967376IMG_0374.PNG', 'testfghgf', 'trest', 'testghgf', 'http://instacraft1.s3.amazonaws.com//123_1513351149.jpg', 'http://instacraft1.s3.amazonaws.com//177_1513351150.jpg', 'http://instacraft1.s3.amazonaws.com//147_1513351151.jpg', '2017-12-15 15:17:50', '0000-00-00 00:00:00'),
(14, 231, '', '', '', '', 'panda', 'panda', 'panda', 'http://instacraft1.s3.amazonaws.com//96f486a701a402d0e083d4c588a6e54433_1515066207.jpg', 'http://instacraft1.s3.amazonaws.com//96f486a701a402d0e083d4c588a6e54424_1515066208.jpg', 'http://instacraft1.s3.amazonaws.com//96f486a701a402d0e083d4c588a6e54422_1515066209.jpg', '2018-01-04 11:41:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `driver_id` int(11) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contact_number` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(45) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('1','2','3') DEFAULT NULL COMMENT '1=>Male,2=>Female,3=>Others',
  `profile_image` varchar(255) NOT NULL,
  `location` varchar(45) DEFAULT NULL,
  `starting_location` int(11) NOT NULL COMMENT 'warehouse_id',
  `online` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=>Offline,1=>Online',
  `otp` int(11) NOT NULL,
  `is_email_verified` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=>Not Verfied,1=>Verified',
  `is_approved` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=>Not Approved By Admin,1=>Approved By Admin',
  `login_type` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=>Email,1=>Contact',
  `device_token` varchar(255) NOT NULL,
  `device_type` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=>''not deleted,''1''=>''deleted''',
  `is_blocked` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=>unblocked,1=>blocked',
  `token` text NOT NULL,
  `notification_status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>off,1=>on',
  `hourly_pay_rate` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driver_id`, `email`, `contact_number`, `password`, `full_name`, `first_name`, `last_name`, `date_of_birth`, `gender`, `profile_image`, `location`, `starting_location`, `online`, `otp`, `is_email_verified`, `is_approved`, `login_type`, `device_token`, `device_type`, `latitude`, `longitude`, `is_deleted`, `is_blocked`, `token`, `notification_status`, `hourly_pay_rate`, `created_at`, `updated_at`) VALUES
(1, 'ramnivash@techaheadcorp.com', 2147483647, 'e10adc3949ba59abbe56e057f20f883e', 'Ram Nivash kumar', 'Ganesh', 'Chauraha', '1988-08-18', '1', 'http://instacraft1.s3.amazonaws.com//get-in-touch-red85_1507024856.png', '', 1, '0', 123456, '1', '1', '0', '', '1', '', '', '0', '0', 'ca5029ef2397c36ce40ec253ed20ef9e', '1', 10, '2017-08-20 18:30:00', '0000-00-00 00:00:00'),
(2, 'priya.barnwal@techaheadcorp.com', 2147483647, 'd41d8cd98f00b204e9800998ecf8427e', NULL, 'Priya', 'Barnwal', NULL, '2', 'http://instacraft1.s3.amazonaws.com/driver/151487609996f486a701a402d0e083d4c588a6e544.jpg', NULL, 4, '0', 0, '0', '0', '0', '', '', '', '', '0', '0', 'a3171ab174267ef7a41c980d5dd5ea18', '1', 200, '2018-01-02 06:53:22', '0000-00-00 00:00:00'),
(3, 'sweta', 1234567890, 'd41d8cd98f00b204e9800998ecf8427e', NULL, 'Sweta', 'Mehar', NULL, '2', 'http://instacraft1.s3.amazonaws.com/driver/151506149696f486a701a402d0e083d4c588a6e544.jpg', NULL, 4, '0', 0, '0', '0', '0', '', '', '', '', '0', '0', '', '1', 20, '2018-01-04 10:23:17', '0000-00-00 00:00:00'),
(4, 'ab', 123, 'd41d8cd98f00b204e9800998ecf8427e', NULL, 'A', 'B', NULL, '1', 'http://instacraft1.s3.amazonaws.com/driver/151506246796f486a701a402d0e083d4c588a6e544.jpg', NULL, 4, '0', 0, '0', '0', '0', '', '', '', '', '0', '0', '', '1', -1, '2018-01-04 10:39:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `driver_assigned_order`
--

CREATE TABLE `driver_assigned_order` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `delivery_time` time NOT NULL,
  `delivered_time` time NOT NULL,
  `delivered_date` date NOT NULL,
  `expected_delivery_date` date NOT NULL DEFAULT '0000-00-00',
  `drop_location` varchar(255) NOT NULL,
  `drop_location_lat` varchar(255) NOT NULL,
  `drop_location_lang` varchar(255) NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `pickup_location_lat` varchar(255) NOT NULL,
  `pickup_location_lang` varchar(255) NOT NULL,
  `order_date` date NOT NULL DEFAULT '0000-00-00',
  `order_status` enum('0','1','2','3','4','5','6','7') NOT NULL COMMENT '0=>Unsigned,1=>Assigned,2=>in-transit/Start,3=>Hold,4=>Reached,5=>Return,6=>Delivered,7-Delayed',
  `hold_reason` int(11) NOT NULL,
  `hold_comment` text NOT NULL,
  `return_reason` varchar(255) NOT NULL,
  `document_url` varchar(255) NOT NULL,
  `idproof_url` varchar(255) NOT NULL,
  `cannabis_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver_assigned_order`
--

INSERT INTO `driver_assigned_order` (`id`, `order_id`, `user_id`, `driver_id`, `delivery_time`, `delivered_time`, `delivered_date`, `expected_delivery_date`, `drop_location`, `drop_location_lat`, `drop_location_lang`, `pickup_location`, `pickup_location_lat`, `pickup_location_lang`, `order_date`, `order_status`, `hold_reason`, `hold_comment`, `return_reason`, `document_url`, `idproof_url`, `cannabis_url`, `created_at`, `updated_at`) VALUES
(3, 6, 209, 1, '18:00:00', '00:00:00', '0000-00-00', '0000-00-00', 'Green Boulevard, Industrial Area, Noida, Uttar Pradesh, India', '28.62287970', '77.36725540', 'Warehouse1', '28.6452', '77.3554', '2017-12-19', '3', 1, 'Fudge', 'Inadequate ID or paperwork', '', 'https://s3-us-east-1.amazonaws.com/instacraft1/driver/04C3C93C-7BA4-4AD9-A46B-2AFDEB88E0F2-3620-0000037FD7C9BBAE.png', 'https://s3-us-east-1.amazonaws.com/instacraft1/driver/8742FC6F-A566-498E-B608-CB6CA30F097E-3620-0000037FE74CFC63.png', '2017-12-19 07:57:57', '2017-12-19 07:59:22'),
(4, 7, 209, 1, '22:00:00', '00:00:00', '0000-00-00', '0000-00-00', 'Shipra Suncity, Ghaziabad, Uttar Pradesh, India', '28.63678820', '77.37407320', 'Warehouse1', '28.584117', '77.397394', '2017-12-19', '6', 2, 'retttt', 'Inadequate ID or paperwork', '', 'https://s3-us-east-1.amazonaws.com/instacraft1/driver/A2E82905-2990-4796-B2FC-2E4C29FBAFE7-3929-000005C95216C93B.png', 'https://s3-us-east-1.amazonaws.com/instacraft1/driver/2E633D1A-5BCC-45AA-B96C-ABCC14E00963-3929-000005C9583244E5.png', '2017-12-19 09:56:40', '2017-12-19 09:58:05'),
(6, 8, 209, 1, '20:00:00', '00:00:00', '0000-00-00', '0000-00-00', 'Sri Ganganagar, Rajasthan, India', '29.90383990', '73.87719010', 'Warehouse1', '29.95918260', '73.98554920', '2017-12-19', '5', 2, 'ff', 'Customer No Show', '', '', '', '2017-12-19 10:44:00', '2017-12-19 10:45:24'),
(7, 9, 216, 1, '17:00:00', '00:00:00', '0000-00-00', '0000-00-00', 'Noida, Uttar Pradesh, India', '28.53551610', '77.39102650', 'Warehouse1', '28.53551610', '77.39102650', '2017-12-21', '5', 1, 'Fdffg', 'Customer No Show', '', 'https://s3.amazonaws.com/instacraft1/driverJPEG_20171221_162510_1504010371.jpg', 'https://s3.amazonaws.com/instacraft1/driverJPEG_20171221_162600_1631558284.jpg', '2017-12-21 10:48:26', '2017-12-21 10:49:52');

-- --------------------------------------------------------

--
-- Table structure for table `driver_availability`
--

CREATE TABLE `driver_availability` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `mon` varchar(255) DEFAULT NULL,
  `tue` varchar(255) NOT NULL,
  `wed` varchar(255) NOT NULL,
  `thu` varchar(255) NOT NULL,
  `fri` varchar(255) NOT NULL,
  `sat` varchar(255) NOT NULL,
  `sun` varchar(255) NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver_availability`
--

INSERT INTO `driver_availability` (`id`, `driver_id`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`, `from_time`, `to_time`, `created_at`, `updated_at`) VALUES
(1, 1, '1', '1', '1', '1', '1', '0', '0', '01:00:00', '04:00:00', '2017-10-10 09:54:24', '0000-00-00 00:00:00'),
(2, 2, '0', '0', '0', '0', '0', '0', '0', '12:00:00', '15:00:00', '2018-01-02 06:53:22', '0000-00-00 00:00:00'),
(3, 3, '0', '0', '0', '0', '0', '0', '0', '10:00:00', '18:00:00', '2018-01-04 10:23:17', '0000-00-00 00:00:00'),
(4, 4, '0', '0', '0', '0', '0', '0', '0', '17:00:00', '21:00:00', '2018-01-04 10:39:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `driver_inventory`
--

CREATE TABLE `driver_inventory` (
  `inventory_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `driver_id` int(11) NOT NULL,
  `item_quantity` int(11) DEFAULT NULL,
  `approve_by_admin` enum('0','1') NOT NULL COMMENT '0=>not approved,1=>approved by admin',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver_inventory`
--

INSERT INTO `driver_inventory` (`inventory_id`, `warehouse_id`, `item_id`, `driver_id`, `item_quantity`, `approve_by_admin`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 112, '0', '0000-00-00 00:00:00', '2018-01-02 01:35:00'),
(2, 2, 2, 1, 17, '0', '0000-00-00 00:00:00', '2017-12-20 12:46:00'),
(3, 1, 2, 1, 16, '0', '2017-09-05 13:30:31', '2018-01-02 01:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `driver_professional_detail`
--

CREATE TABLE `driver_professional_detail` (
  `professional_detail_id` int(11) NOT NULL,
  `document_name` varchar(100) DEFAULT NULL,
  `document_id` varchar(255) NOT NULL,
  `document_image` varchar(255) NOT NULL,
  `vehicle_image` varchar(255) NOT NULL,
  `vehicle_make` varchar(45) DEFAULT NULL,
  `vehicle_model_type` varchar(45) DEFAULT NULL,
  `vehicle_color` varchar(100) NOT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `license_number` varchar(255) DEFAULT NULL,
  `manufacture_date` date NOT NULL,
  `ssn` varchar(255) NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver_professional_detail`
--

INSERT INTO `driver_professional_detail` (`professional_detail_id`, `document_name`, `document_id`, `document_image`, `vehicle_image`, `vehicle_make`, `vehicle_model_type`, `vehicle_color`, `registration_number`, `license_number`, `manufacture_date`, `ssn`, `expiration_date`, `driver_id`) VALUES
(1, 'Licence', '', '', '', '878LKI', '123', '', '1112245', 'sdfdsf44545', '0000-00-00', '', '2017-08-08', 1),
(2, 'licence', '', '0', 'http://instacraft1.s3.amazonaws.com/vehicle/151487610096f486a701a402d0e083d4c588a6e544.jpg', 'abc', 'xyz', 'white', '123', 'abc123', '2017-11-02', '1234', NULL, 2),
(3, 'licence', '', '0', 'http://instacraft1.s3.amazonaws.com/vehicle/151506149796f486a701a402d0e083d4c588a6e544.jpg', 'abc', 'xyz', 'Black', '1', '12345', '2018-01-05', '123', NULL, 3),
(4, 'xyz', '', '0', 'http://instacraft1.s3.amazonaws.com/vehicle/151506246796f486a701a402d0e083d4c588a6e544.jpg', 'a', 'b', 'c', '1', '1', '2018-01-06', '321', NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `driver_review_rating`
--

CREATE TABLE `driver_review_rating` (
  `id` int(11) NOT NULL,
  `review_by` int(11) NOT NULL,
  `review` text NOT NULL,
  `rating` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=>not deleted,1=>deleted',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver_review_rating`
--

INSERT INTO `driver_review_rating` (`id`, `review_by`, `review`, `rating`, `driver_id`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'hello', 3, 1, '0', '2017-08-24 13:39:45', '0000-00-00 00:00:00'),
(2, 2, 'Hi', 5, 1, '0', '2017-08-24 13:40:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `hold_reason`
--

CREATE TABLE `hold_reason` (
  `reason_id` int(11) NOT NULL,
  `reason` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hold_reason`
--

INSERT INTO `hold_reason` (`reason_id`, `reason`, `created_at`) VALUES
(1, 'Hold Reason1', '2017-08-23 18:30:00'),
(2, 'Hold Reason2', '2017-08-24 10:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` int(11) NOT NULL,
  `profile_image` varchar(200) DEFAULT NULL,
  `document_image` varchar(200) DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  `upload_time` time DEFAULT NULL,
  `driver_id` int(11) NOT NULL,
  `customer_document_order` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_status`
--

CREATE TABLE `inventory_status` (
  `inventory_status_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `caregiver_id` int(11) NOT NULL,
  `sub_category_ids` varchar(255) NOT NULL COMMENT 'sub category id in comma separated',
  `item_name` varchar(255) NOT NULL,
  `item_unit` enum('1','2','3','4') NOT NULL COMMENT '1=>ounce,2=>gram,3=>ml,4=>piece',
  `item_image` varchar(255) NOT NULL,
  `price_eigth` varchar(255) NOT NULL,
  `price_one` varchar(255) NOT NULL,
  `deducted_price` double(10,2) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `item_familly` int(11) NOT NULL COMMENT 'item familly id from item_familly table',
  `recommended_uses` varchar(255) NOT NULL,
  `flavor` varchar(255) NOT NULL,
  `smell` varchar(255) NOT NULL,
  `effect` text NOT NULL,
  `color_code` varchar(100) NOT NULL,
  `review` text NOT NULL COMMENT 'review is description',
  `thc` float NOT NULL,
  `cbg` float NOT NULL,
  `cbc` float NOT NULL,
  `cbn` float NOT NULL,
  `cbd` float NOT NULL,
  `thcv` float NOT NULL,
  `is_biweekly` enum('0','1') NOT NULL COMMENT '1=>Yes,0=>No',
  `is_hot_item` enum('0','1') NOT NULL COMMENT '0-No, 1-Yes',
  `status` enum('1','0') NOT NULL COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `is_luxurious_item` enum('0','1') NOT NULL COMMENT '0-No, 1-Yes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `category_id`, `caregiver_id`, `sub_category_ids`, `item_name`, `item_unit`, `item_image`, `price_eigth`, `price_one`, `deducted_price`, `weight`, `item_familly`, `recommended_uses`, `flavor`, `smell`, `effect`, `color_code`, `review`, `thc`, `cbg`, `cbc`, `cbn`, `cbd`, `thcv`, `is_biweekly`, `is_hot_item`, `status`, `created_at`, `updated_at`, `is_luxurious_item`) VALUES
(1, 0, 1, '', 'Med 1', '1', 'http://instacraft1.s3.amazonaws.com//med 1_263187_1515365389.jpg', '269', '269', 0.00, '100', 2, 'recommended uses, xyz, zysf fdfasdf fdaff ', 'Bouquet of sliced fruit', 'hint of fruet', 'fafdds dsaffsadf dsafsaf', '#24A34B', 'adfdsf afdsf ', 0, 0, 0, 0, 0, 0, '0', '0', '1', '2017-08-29 08:19:47', '0000-00-00 00:00:00', '0'),
(2, 1, 3, '2', 'Digital Dreem edited', '1', 'https://instacraft1.s3.amazonaws.com//get-in-touch-red85_1507024856.png', '1200', '1200', 0.00, '30', 1, 'uses1,uses2,uses3', 'Very sweet flamable', 'hints of fruit', 'uplifting,euphoric', '#6E2309', 'Lorem Ipsum, ad? bilinmeyen bir matbaac?n?n bir hurufat numune kitab? olu?turmak üzere bir yaz? galerisini alarak.', 10, 20, 60, 40, 30, 15, '1', '1', '1', '2017-08-28 18:30:00', '0000-00-00 00:00:00', '0'),
(17, 7, 2, '2,5', 'New Product', '1', 'https://instacraft1.s3.amazonaws.com//tomb-of-itimad-ud-daulahc44_1506688334.jpg', '160', '160', 0.00, '', 2, 'recomendded usages', 'Grammy Tastes', '', 'Product effects', '#C99CFF', 'Product reviews', 12, 12, 13, 14, 15, 16, '0', '0', '1', '2017-09-29 12:32:15', '0000-00-00 00:00:00', '0'),
(18, 3, 3, '6', 'Sample Product', '1', 'https://instacraft1.s3.amazonaws.com//img-20170805-082124-96289_1506689032.jpg', '240', '240', 0.00, '', 3, 'aaaaaaaaa', 'sdfsdfasdf', '', 'abbbbbbbb', '#9EAF66', 'ccccccccc', 1, 2, 3, 4, 5, 6, '1', '1', '1', '2017-09-29 12:43:54', '0000-00-00 00:00:00', '1'),
(19, 2, 2, '', 'dasdasdadsa', '3', 'https://instacraft1.s3.amazonaws.com//20170813-155511-largejpg72_1506689193.jpg', '223', '223', 0.00, '', 2, 'wedfew', 'asadassa', '', 'fedsfvdvfdv', '#FF7712', 'dfvfdvfdv', 11, 4, 233, 435, 45, 3, '1', '1', '1', '2017-09-29 12:46:34', '0000-00-00 00:00:00', '0'),
(20, 0, 1, '', 'abcde', '1', '123', '15', '15', 0.00, '', 1, 'xyzuw', 'blue berry', '', 'tuvxy', '#55126E', 'qwerty', 0, 0, 0, 0, 0, 0, '0', '1', '1', '2018-01-04 13:01:23', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `item_category_mapping`
--

CREATE TABLE `item_category_mapping` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_category_mapping`
--

INSERT INTO `item_category_mapping` (`id`, `item_id`, `category_id`, `created_at`, `updated_at`) VALUES
(11, 17, 1, '2017-09-29 12:32:15', '0000-00-00 00:00:00'),
(13, 18, 1, '2017-09-29 12:43:54', '0000-00-00 00:00:00'),
(14, 19, 1, '2017-09-29 12:46:34', '0000-00-00 00:00:00'),
(15, 19, 2, '2017-09-29 12:46:34', '0000-00-00 00:00:00'),
(18, 2, 2, '2017-10-03 09:52:30', '0000-00-00 00:00:00'),
(19, 17, 2, '2017-10-03 09:52:30', '0000-00-00 00:00:00'),
(52, 2, 1, '2017-10-03 10:38:16', '0000-00-00 00:00:00'),
(53, 2, 3, '2017-10-03 10:38:16', '0000-00-00 00:00:00'),
(62, 20, 3, '2018-01-04 13:01:23', '0000-00-00 00:00:00'),
(63, 20, 6, '2018-01-04 13:01:23', '0000-00-00 00:00:00'),
(66, 1, 1, '2018-01-08 02:43:21', '0000-00-00 00:00:00'),
(67, 1, 3, '2018-01-08 02:43:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `item_familly`
--

CREATE TABLE `item_familly` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_familly`
--

INSERT INTO `item_familly` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sativa', '1', '2017-09-27 18:30:00', '2018-01-04 06:51:52'),
(2, 'indica', '1', '2017-09-27 18:30:00', '0000-00-00 00:00:00'),
(3, 'Gracia', '1', '2017-10-05 15:40:20', '0000-00-00 00:00:00'),
(4, 'abcde', '1', '2018-01-04 06:52:44', '0000-00-00 00:00:00'),
(5, 'qwerty', '1', '2018-01-04 06:56:36', '0000-00-00 00:00:00'),
(6, 'Product Family B', '1', '2018-01-07 22:59:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `manage_warehouse_items`
--

CREATE TABLE `manage_warehouse_items` (
  `id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `inventry_left` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manage_warehouse_items`
--

INSERT INTO `manage_warehouse_items` (`id`, `warehouse_id`, `item_id`, `inventry_left`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 20, '2017-08-29 18:30:00', '0000-00-00 00:00:00'),
(4, 2, 2, 10, '2017-09-05 13:10:48', '0000-00-00 00:00:00'),
(24, 1, 20, 0, '2018-01-04 13:01:23', '0000-00-00 00:00:00'),
(25, 2, 20, 0, '2018-01-04 13:01:23', '0000-00-00 00:00:00'),
(26, 3, 20, 0, '2018-01-04 13:01:23', '0000-00-00 00:00:00'),
(27, 4, 20, 0, '2018-01-04 13:01:23', '0000-00-00 00:00:00'),
(28, 5, 20, 0, '2018-01-04 13:01:23', '0000-00-00 00:00:00'),
(34, 1, 1, 11, '2018-01-08 02:43:21', '0000-00-00 00:00:00'),
(35, 2, 1, 40, '2018-01-08 02:43:21', '0000-00-00 00:00:00'),
(36, 3, 1, 0, '2018-01-08 02:43:21', '0000-00-00 00:00:00'),
(37, 4, 1, 0, '2018-01-08 02:43:21', '0000-00-00 00:00:00'),
(38, 5, 1, 0, '2018-01-08 02:43:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) NOT NULL,
  `message` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `imgsrc` varchar(255) NOT NULL,
  `is_sent` enum('0','1') NOT NULL COMMENT '0-Not sent, 1- sent',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `link`, `imgsrc`, `is_sent`, `created_at`) VALUES
(1, 'Sample text message here , Max char length -255 ', 'http://samplelink.com/home', 'http://samplelink.com/home/image.jpg', '0', '2017-10-04 15:30:19'),
(3, 'Crack n Jack', 'http://samplelink.com/home', 'http://samplelink.com/home/image2.png', '0', '2017-10-04 15:35:12'),
(4, 'Get in Touch is a brand name now popular in every IT industry. So, please go and help others', 'https://getintouch.com/helpdesk', 'https://getintouch.com/helpdesk', '1', '2017-10-04 16:23:36'),
(5, 'asdasdfasfasfsdafgvdsafsdafdsf', 'http://images.lulushark.com/content-images/Love%20Images/Love%20Imge%20079.jpg', 'http://instacraft1.s3.amazonaws.com//shutterstock_313679270-wbc-webversion96_1507114893.jpg', '1', '2017-10-04 16:31:34'),
(6, 'shttps://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'http://instacraft1.s3.amazonaws.com//shutterstock_313679270-wbc-webversion99_1507114971.jpg', '1', '2017-10-04 16:32:53'),
(7, 'shttps://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'http://instacraft1.s3.amazonaws.com//shutterstock_313679270-wbc-webversion85_1507114998.jpg', '1', '2017-10-04 16:33:20'),
(8, 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'http://instacraft1.s3.amazonaws.com//5ada946ff7bce8d218bc130ec03c6af484_1507115085.jpg', '1', '2017-10-04 16:34:46'),
(9, 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'http://instacraft1.s3.amazonaws.com//5ada946ff7bce8d218bc130ec03c6af484_1507115085.jpg', '1', '2017-10-04 16:34:46'),
(10, 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'http://instacraft1.s3.amazonaws.com//5ada946ff7bce8d218bc130ec03c6af443_1507115158.jpg', '1', '2017-10-04 16:35:59'),
(11, 'dsadasdas', 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'http://instacraft1.s3.amazonaws.com//5ada946ff7bce8d218bc130ec03c6af458_1507115213.jpg', '1', '2017-10-04 16:36:54'),
(12, 'dsadasdas', 'https://static1.squarespace.com/static/58d7bf7f2e69cf94cd827abc/t/58def0efebbd1a7ec63199e9/1491005685589/shutterstock_313679270-wbc-webversion.jpg', 'http://instacraft1.s3.amazonaws.com//5ada946ff7bce8d218bc130ec03c6af498_1507115277.jpg', '1', '2017-10-04 16:37:58'),
(13, 'sdfsdfsdfsdfsdfds', 'http://google.co.in', 'http://instacraft1.s3.amazonaws.com//5ada946ff7bce8d218bc130ec03c6af467_1507366084.jpg', '1', '2017-10-07 14:18:05'),
(14, 'message', 'www.msg', 'http://instacraft1.s3.amazonaws.com//96f486a701a402d0e083d4c588a6e54419_1515133408.jpg', '1', '2018-01-05 06:23:28'),
(15, 'message', 'www.msg', 'http://instacraft1.s3.amazonaws.com//96f486a701a402d0e083d4c588a6e54450_1515133409.jpg', '1', '2018-01-05 06:23:30'),
(16, 'message', 'wwwmsg', 'http://instacraft1.s3.amazonaws.com//hellokitty89_1515133517.jpg', '1', '2018-01-05 06:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `minimum_delivery_prices`
--

CREATE TABLE `minimum_delivery_prices` (
  `id` int(10) NOT NULL,
  `name` varchar(64) NOT NULL,
  `rate` float NOT NULL DEFAULT '0',
  `last_rate` float NOT NULL DEFAULT '0',
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `minimum_delivery_prices`
--

INSERT INTO `minimum_delivery_prices` (`id`, `name`, `rate`, `last_rate`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Min. Price for On-Demand', 120, 0, '0', '2017-10-09 15:48:43', NULL),
(2, 'Min. Price for Scheduled', 35, 250, '0', '2017-07-14 20:30:12', '2018-01-07 23:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `module_name` varchar(45) DEFAULT NULL,
  `is_active` enum('0','1') DEFAULT '1',
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `is_active`, `created_on`, `updated_on`, `path`) VALUES
(1, 'Dashboard', '1', '2017-11-20 16:18:13', '2017-11-20 16:18:13', 'admin-dashboard'),
(2, 'Orders', '1', '2017-11-20 16:18:47', '2017-11-20 16:18:47', 'orders'),
(3, 'Drivers', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'drivers'),
(4, 'Doctors', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'doctors'),
(5, 'Customers', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'customers'),
(6, 'Products', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'products'),
(7, 'Category', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'categories'),
(8, 'Messages', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'messages'),
(9, 'Coupons', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'coupons'),
(10, 'Reports', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'reports'),
(11, 'Canna Community', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'cannaCommunity'),
(12, 'System Setting', '1', '2017-11-20 16:25:05', '2017-11-20 16:25:05', 'manage-users');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `push_type` enum('1','2','3','4','5','6') NOT NULL COMMENT '0=>Assigned,1=>Accepted,2=>Start,3=>Hold,4=>Reached,5=>Return,6=>Delivered',
  `title` varchar(200) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL COMMENT '1=>not deleted,0=>deleted',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `push_type`, `title`, `message`, `is_deleted`, `created_at`) VALUES
(1, 118, '1', 'order status-Pending', 'successfully sent', '1', '2017-10-12 07:44:06'),
(2, 118, '1', 'order Status:Complete', 'hello', '1', '2017-10-12 14:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `driver_id` int(10) DEFAULT NULL COMMENT 'current_assigned_driver_id',
  `transaction_no` varchar(255) NOT NULL,
  `order_type` enum('0','1','2') NOT NULL COMMENT '0=>scheduled,1=>ASAP,2=>Pre Order',
  `delivery_time` time DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `drop_location` varchar(255) NOT NULL,
  `drop_location_lat` varchar(255) NOT NULL,
  `drop_location_lang` varchar(255) NOT NULL,
  `pay_status` enum('0','1') NOT NULL COMMENT '0=>pending,1=>paid',
  `order_status` enum('0','1','2','3','4','5','6','7') NOT NULL COMMENT '0=>Unsigned,1=>Assigned,2=>in-transit/Start,3=>Hold,4=>Reached,5=>Return,6=>Delivered,7-Delayed',
  `amount` double NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount_refunded` int(11) NOT NULL,
  `captured` int(11) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `failure_code` varchar(255) NOT NULL,
  `failure_message` varchar(255) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `driver_id`, `transaction_no`, `order_type`, `delivery_time`, `delivery_date`, `drop_location`, `drop_location_lat`, `drop_location_lang`, `pay_status`, `order_status`, `amount`, `transaction_id`, `amount_refunded`, `captured`, `currency`, `description`, `failure_code`, `failure_message`, `invoice`, `status`, `created_at`, `updated_at`) VALUES
(1, 209, NULL, 'txn_1BYw2QGiOPmheJ8IObs4rgev', '1', NULL, NULL, '', '', '', '1', '0', 1932, 'ch_1BYw2QGiOPmheJ8IOeJK85Bf', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-14 12:41:55', NULL),
(2, 209, NULL, 'txn_1BZIcCCpUJfmaY4d4bT5Fy1S', '1', '13:00:00', '0000-00-00', 'test', '', '', '1', '1', 2080, 'ch_1BZIcCCpUJfmaY4dSrC5GEu3', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-15 12:48:19', NULL),
(3, 209, NULL, 'txn_1BaNStCpUJfmaY4dQDe0S8p2', '1', '17:40:00', '2017-12-18', 'gfdgd', '', '', '1', '0', 800, 'ch_1BaNSsCpUJfmaY4daJvdyk5G', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-18 12:11:01', NULL),
(4, 209, NULL, '', '1', '17:40:00', '2017-12-18', 'gfdgd', '', '', '0', '0', 0, '', 0, 0, '', '', '', '', '', '', '2017-12-18 12:15:50', NULL),
(5, 209, NULL, 'txn_1BaNYQCpUJfmaY4dMFtVssiT', '1', '17:46:00', '2017-12-18', 'sdfs', '', '', '1', '0', 223, 'ch_1BaNYQCpUJfmaY4d2t4UX6Nt', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-18 12:16:58', NULL),
(6, 209, 1, 'txn_1Bafy0CpUJfmaY4dNrIDNwaL', '1', '18:00:00', '0000-00-00', 'Green Boulevard, Industrial Area, Noida, Uttar Pradesh, India', '28.62287970', '77.36725540', '1', '3', 800, 'ch_1BafxzCpUJfmaY4ddrPk3e6P', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-19 07:56:33', NULL),
(7, 209, 1, 'txn_1BahlSCpUJfmaY4dkO6GU9qp', '1', '22:00:00', '0000-00-00', 'Shipra Suncity, Ghaziabad, Uttar Pradesh, India', '28.63678820', '77.37407320', '1', '6', 1200, 'ch_1BahlSCpUJfmaY4dKAv201kC', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-19 09:51:42', NULL),
(8, 209, 2, 'txn_1BahtOCpUJfmaY4dTznfcDi9', '0', '15:00:00', '2018-01-04', 'Sri Ganganagar, Rajasthan, India', '29.90383990', '73.87719010', '1', '1', 240, 'ch_1BahtOCpUJfmaY4d5mPXLHnj', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-19 09:59:55', NULL),
(9, 216, 1, 'txn_1BbRZ8CpUJfmaY4dHWv9MxW2', '1', '15:00:00', '0000-00-00', 'Noida, Uttar Pradesh, India', '28.53551610', '77.39102650', '1', '1', 1200, 'ch_1BbRZ8CpUJfmaY4dtjq0yuun', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-21 10:44:36', NULL),
(10, 209, NULL, 'txn_1BdJZVCpUJfmaY4dBTiiJuxe', '1', '20:04:00', '2017-12-26', 'Noida, Uttar Pradesh, India', '28.53551610', '77.39102650', '1', '0', 160, 'ch_1BdJZVCpUJfmaY4dzyLJmgYE', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-26 14:38:13', NULL),
(11, 209, NULL, 'txn_1BdYuCCpUJfmaY4djVsj8th9', '1', '12:29:00', '2017-12-27', 'Voodoo Doughnut, Southwest 3rd Avenue, Portland, OR, United States', '45.52269860', '-122.67312520', '1', '0', 1200, 'ch_1BdYuCCpUJfmaY4dZk4OgDPw', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-27 07:00:32', NULL),
(12, 216, NULL, 'txn_1BddLNCpUJfmaY4dOrb804XE', '1', '17:09:00', '2017-12-27', 'Noida, Uttar Pradesh, India', '28.53551610', '77.39102650', '1', '0', 1200, 'ch_1BddLNCpUJfmaY4dqt7yAwVy', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-27 11:44:06', NULL),
(13, 209, NULL, 'txn_1BdfDOCpUJfmaY4d1jf24iZ0', '1', '19:10:00', '2017-12-27', 'Noida, Uttar Pradesh, India', '28.53551610', '77.39102650', '1', '0', 1200, 'ch_1BdfDOCpUJfmaY4dW9GWVInD', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2017-12-27 13:44:51', NULL),
(14, 226, 1, 'txn_1Bfp6SCpUJfmaY4dKYs8BBLu', '1', '15:00:00', '0000-00-00', 'Second Profession Brewing Company, Northeast Sandy Boulevard, Portland, OR, United States', '45.54269320', '-122.60282720', '1', '1', 1200, 'ch_1Bfp6SCpUJfmaY4drb9IJwXL', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2018-01-02 12:36:52', NULL),
(15, 228, NULL, '', '1', '00:00:00', '0000-00-00', 'Green Boulevard, Industrial Area, Noida, Uttar Pradesh, India', '28.62287970', '77.36725540', '0', '0', 240, '', 0, 0, '', '', '', '', '', '', '2018-01-03 05:06:40', NULL),
(16, 227, 1, 'txn_1Bg4xXCpUJfmaY4dkH4GEEMc', '1', '16:00:00', '0000-00-00', 'Second Profession Brewing Company, Northeast Sandy Boulevard, Portland, OR, United States', '45.54269320', '-122.60282720', '1', '1', 1200, 'ch_1Bg4xWCpUJfmaY4d1cjOaQR4', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2018-01-03 05:37:44', NULL),
(17, 228, 1, 'txn_1Bg74BCpUJfmaY4dDKOOmHhc', '0', '18:00:00', '2018-01-08', 'Green Boulevard, Industrial Area, Noida, Uttar Pradesh, India', '28.62287970', '77.36725540', '1', '1', 800, 'ch_1Bg74BCpUJfmaY4dk4XvhHM9', 0, 1, 'usd', 'Appointment', '', '', '', 'success', '2018-01-03 07:53:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `total_amount` bigint(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `order_qty`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 800, '2017-12-14 12:41:55', NULL),
(2, 1, 18, 1, 240, '2017-12-14 12:41:55', NULL),
(3, 1, 19, 4, 892, '2017-12-14 12:41:55', NULL),
(4, 2, 1, 2, 1600, '2017-12-15 12:48:19', NULL),
(5, 2, 17, 3, 480, '2017-12-15 12:48:19', NULL),
(6, 3, 1, 1, 800, '2017-12-18 12:11:01', NULL),
(7, 5, 19, 1, 223, '2017-12-18 12:16:58', NULL),
(8, 6, 1, 1, 800, '2017-12-19 07:56:33', NULL),
(9, 7, 2, 1, 1200, '2017-12-19 09:51:42', NULL),
(10, 8, 18, 1, 240, '2017-12-19 09:59:55', NULL),
(11, 9, 2, 1, 1200, '2017-12-21 10:44:36', NULL),
(12, 10, 17, 1, 160, '2017-12-26 14:38:13', NULL),
(13, 11, 2, 1, 1200, '2017-12-27 07:00:32', NULL),
(14, 12, 2, 1, 1200, '2017-12-27 11:44:06', NULL),
(15, 13, 2, 1, 1200, '2017-12-27 13:44:51', NULL),
(16, 14, 2, 1, 1200, '2018-01-02 12:36:52', NULL),
(17, 15, 18, 1, 240, '2018-01-03 05:06:40', NULL),
(18, 16, 2, 1, 1200, '2018-01-03 05:37:44', NULL),
(19, 17, 1, 1, 800, '2018-01-03 07:53:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `points_details`
--

CREATE TABLE `points_details` (
  `id` int(11) NOT NULL,
  `points` double NOT NULL,
  `source_of_point` enum('0','1','2','3') NOT NULL COMMENT '0=>Share on Facebook,1=>Share on Twitter,2=>Share on Instagram,3=>by refferal code',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `points_details`
--

INSERT INTO `points_details` (`id`, `points`, `source_of_point`, `created_at`, `updated_at`) VALUES
(1, 100, '0', '2017-09-07 18:30:00', '0000-00-00 00:00:00'),
(2, 100, '1', '2017-09-07 18:30:00', '0000-00-00 00:00:00'),
(3, 100, '2', '2017-09-07 18:30:00', '0000-00-00 00:00:00'),
(4, 100, '3', '2017-09-08 10:27:16', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL COMMENT '0=>in case of uploaded by user',
  `doctor_id` int(11) NOT NULL COMMENT '0=>in case of uploaded by user',
  `prescription_front_image` varchar(255) NOT NULL,
  `prescription_back_image` varchar(255) NOT NULL,
  `expire_date` date NOT NULL DEFAULT '0000-00-00',
  `notes` text NOT NULL,
  `uploaded_by` enum('0','1') NOT NULL COMMENT '0=>created and uploaded by doctor,1=>uploaded by user',
  `is_approved` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=> unapproved,Rejected, ''1''=> Approved',
  `valid_till` date NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `user_id`, `appointment_id`, `doctor_id`, `prescription_front_image`, `prescription_back_image`, `expire_date`, `notes`, `uploaded_by`, `is_approved`, `valid_till`, `reason`, `created_at`, `updated_at`) VALUES
(1, 144, 0, 0, 'https://s3-us-west-2.amazonaws.com/athbucket/7B5D50C8-6CDA-4B2C-ACE7-E3A1A2AD863D-5335-0000090510C961F9.png', 'https://s3-us-west-2.amazonaws.com/athbucket/F6BA418A-D82F-4ED4-B68E-021FFCAEAEF3-5335-000008F83EEC31C4.png', '2017-11-11', '', '1', '0', '0000-00-00', '', '2017-10-06 07:20:14', '0000-00-00 00:00:00'),
(2, 191, 0, 0, 'https://s3-us-west-2.amazonaws.com/athbucket/BC9B14D5-F9DA-4CF8-B849-C290F0FB55B2-5661-0000098940AE8E34.png', 'https://s3-us-west-2.amazonaws.com/athbucket/3F46A210-8780-4F44-AD34-4999272F815E-5661-0000097BB0C7062E.png', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-10-06 07:29:38', '0000-00-00 00:00:00'),
(3, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-11-25 05:45:31', '0000-00-00 00:00:00'),
(4, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-11-25 05:45:32', '0000-00-00 00:00:00'),
(5, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-11-25 05:45:36', '0000-00-00 00:00:00'),
(6, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-11-25 05:46:17', '0000-00-00 00:00:00'),
(7, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-11-25 05:46:25', '0000-00-00 00:00:00'),
(8, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-12-01 07:48:44', '0000-00-00 00:00:00'),
(9, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-12-01 09:33:54', '0000-00-00 00:00:00'),
(10, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-12-01 09:34:31', '0000-00-00 00:00:00'),
(11, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-12-01 09:34:39', '0000-00-00 00:00:00'),
(12, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-12-01 09:43:37', '0000-00-00 00:00:00'),
(13, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-12-01 09:43:44', '0000-00-00 00:00:00'),
(14, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2017-12-01 09:44:38', '0000-00-00 00:00:00'),
(15, 226, 0, 0, 'http://instacraft1.s3.amazonaws.com/customer/1514901271Astra_Towers_bigimage_20160524033207 (1).png', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2018-01-02 13:52:53', '0000-00-00 00:00:00'),
(16, 226, 0, 0, 'http://instacraft1.s3.amazonaws.com/customer/1514901426Astra_Towers_bigimage_20160524033207.png', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2018-01-02 13:55:27', '0000-00-00 00:00:00'),
(17, 228, 0, 0, 'http://instacraft1.s3.amazonaws.com/customer/151496285396f486a701a402d0e083d4c588a6e544.jpg', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2018-01-03 06:59:14', '0000-00-00 00:00:00'),
(18, 228, 0, 0, 'http://instacraft1.s3.amazonaws.com/customer/151496287196f486a701a402d0e083d4c588a6e544.jpg', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2018-01-03 06:59:32', '0000-00-00 00:00:00'),
(19, 228, 0, 0, 'http://instacraft1.s3.amazonaws.com/customer/151496520296f486a701a402d0e083d4c588a6e544.jpg', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2018-01-03 07:38:22', '0000-00-00 00:00:00'),
(20, 209, 0, 0, '', '', '0000-00-00', '', '1', '0', '0000-00-00', '', '2018-01-08 08:51:59', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `restricted_areas`
--

CREATE TABLE `restricted_areas` (
  `id` int(11) NOT NULL,
  `area_name` varchar(64) NOT NULL,
  `area_permission` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1-Allowed, 2-Restricted, 3-Restricted Delivery',
  `mon` enum('0','1') NOT NULL DEFAULT '0',
  `tue` enum('0','1') NOT NULL DEFAULT '0',
  `wed` enum('0','1') NOT NULL DEFAULT '0',
  `thu` enum('0','1') NOT NULL DEFAULT '0',
  `fri` enum('0','1') NOT NULL DEFAULT '0',
  `sat` enum('0','1') NOT NULL DEFAULT '0',
  `sun` enum('0','1') NOT NULL DEFAULT '0',
  `zip_codes` varchar(512) NOT NULL COMMENT 'zip codes should be comma separated ',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restricted_areas`
--

INSERT INTO `restricted_areas` (`id`, `area_name`, `area_permission`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`, `zip_codes`, `created_at`, `updated_at`) VALUES
(2, 'Demo Area 1', '1', '1', '0', '0', '0', '0', '0', '0', '111222,111223,111224', '2017-10-09 02:57:18', '2017-10-09 04:00:00'),
(3, 'Demo Area 1', '2', '0', '0', '1', '0', '0', '0', '0', '222333,222334,222335,222336', '2017-10-09 18:30:00', '2017-10-09 00:02:00'),
(4, 'Demo Area 2', '1', '0', '1', '0', '0', '0', '0', '0', '444523,444524,444525', '2017-10-09 02:59:19', '2017-10-04 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `shift_clock`
--

CREATE TABLE `shift_clock` (
  `shift_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `edited_start_time` time NOT NULL DEFAULT '00:00:00',
  `end_time` time NOT NULL DEFAULT '00:00:00',
  `edited_end_time` time NOT NULL DEFAULT '00:00:00',
  `total_time` time NOT NULL DEFAULT '00:00:00',
  `payable_amount` float NOT NULL,
  `original_payable_amount` float NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift_clock`
--

INSERT INTO `shift_clock` (`shift_id`, `driver_id`, `start_time`, `edited_start_time`, `end_time`, `edited_end_time`, `total_time`, `payable_amount`, `original_payable_amount`, `date`) VALUES
(1, 1, '10:20:00', '00:00:00', '22:25:00', '00:00:00', '00:00:00', 0, 0, '2017-08-20'),
(2, 1, '13:20:00', '00:00:00', '20:20:00', '00:00:00', '00:00:00', 0, 0, '2017-08-22'),
(4, 1, '10:20:00', '00:00:00', '20:25:00', '00:00:00', '00:00:00', 0, 0, '2017-08-23'),
(5, 1, '11:10:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-08-25'),
(6, 1, '04:52:00', '00:00:00', '19:00:00', '00:00:00', '14:08:00', 100, 0, '2017-08-28'),
(7, 1, '07:04:00', '00:00:00', '10:10:00', '00:00:00', '03:06:00', 0, 0, '2017-09-04'),
(15, 1, '09:08:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-09-12'),
(36, 1, '14:09:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-09-18'),
(46, 1, '14:56:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-09-19'),
(47, 1, '07:49:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-09-20'),
(52, 1, '13:02:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-10-05'),
(55, 1, '04:54:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-10-07'),
(56, 1, '04:20:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-10-09'),
(57, 1, '04:33:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-10-10'),
(59, 1, '13:59:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-10-11'),
(61, 1, '13:33:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-10-12'),
(63, 1, '09:04:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-12-19'),
(88, 1, '15:07:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-12-20'),
(89, 1, '05:04:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-12-21'),
(90, 1, '06:42:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-12-22'),
(91, 1, '07:29:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-12-27'),
(92, 1, '05:30:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-12-28'),
(93, 1, '11:14:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2017-12-29'),
(94, 1, '03:55:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, '2018-01-01'),
(95, 1, '03:37:00', '00:00:00', '03:45:00', '00:00:00', '00:08:00', 0, 0, '2018-01-02'),
(96, 1, '05:23:00', '00:00:00', '05:51:00', '00:00:00', '00:28:00', 0, 0, '2018-01-03');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `category_id`, `sub_category_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'sub cat1', '1', '2017-09-26 18:30:00', '0000-00-00 00:00:00'),
(2, 1, 'sub cat2', '1', '2017-09-26 18:30:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `tax_name` varchar(50) NOT NULL,
  `tax_type` enum('amount','percent') NOT NULL,
  `amt_value` float NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `tax_name`, `tax_type`, `amt_value`, `is_active`, `created_on`, `modified_on`) VALUES
(2, 'sales tax', 'percent', 5.5, 1, '2017-11-24 13:01:37', '2018-01-07 23:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment_transaction`
--

CREATE TABLE `tbl_appointment_transaction` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount_refunded` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `captured` int(11) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `failure_code` varchar(255) DEFAULT NULL,
  `failure_message` varchar(255) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_appointment_transaction`
--

INSERT INTO `tbl_appointment_transaction` (`id`, `appointment_id`, `transaction_id`, `amount_refunded`, `paid_amount`, `captured`, `currency`, `description`, `failure_code`, `failure_message`, `invoice`, `status`, `created_at`) VALUES
(1, 8, 'txn_1BZInWCpUJfmaY4dc5W2HeWT', 0, 2900, 1, 'usd', 'Appointment', NULL, NULL, NULL, 'success', '2017-12-15 13:00:20'),
(2, 9, 'txn_1BfqfxCpUJfmaY4dKQr1TRku', 0, 2900, 1, 'usd', 'Appointment', NULL, NULL, NULL, 'success', '2018-01-02 14:23:35'),
(3, 10, 'txn_1Bg4sQCpUJfmaY4dthPjPm1m', 0, 2900, 1, 'usd', 'Appointment', NULL, NULL, NULL, 'success', '2018-01-03 05:33:25'),
(4, 11, 'txn_1Bg67mCpUJfmaY4d9j7IsFto', 0, 2900, 1, 'usd', 'Appointment', NULL, NULL, NULL, 'success', '2018-01-03 06:53:21'),
(5, 12, 'txn_1Bg6DGCpUJfmaY4d1z9zyzm5', 0, 2900, 1, 'usd', 'Appointment', NULL, NULL, NULL, 'success', '2018-01-03 06:59:01'),
(6, 13, 'txn_1Bg6M4CpUJfmaY4diKLRFdo1', 0, 2900, 1, 'usd', 'Appointment', NULL, NULL, NULL, 'success', '2018-01-03 07:08:06'),
(7, 14, 'txn_1Bg6cFCpUJfmaY4dbB1IrEwr', 0, 2900, 1, 'usd', 'Appointment', NULL, NULL, NULL, 'success', '2018-01-03 07:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_info_pages`
--

CREATE TABLE `tbl_info_pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `is_active` enum('0','1') NOT NULL COMMENT '0=>inactive,1=>active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_info_pages`
--

INSERT INTO `tbl_info_pages` (`id`, `title`, `slug`, `content`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Terms and Condition', 'terms-and-condition', 'Terms & Condition...', '1', '2017-09-05 15:34:29', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_caregivers`
--

CREATE TABLE `tbl_order_caregivers` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `caregiver_id` int(11) NOT NULL,
  `user_signature` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `home_address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `medical_certification` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order_caregivers`
--

INSERT INTO `tbl_order_caregivers` (`id`, `order_id`, `item_id`, `order_qty`, `caregiver_id`, `user_signature`, `full_name`, `dob`, `phone_number`, `home_address`, `city`, `state`, `country`, `zip`, `medical_certification`, `created_at`) VALUES
(1, 1, 1, 1, 1, 'http://instacraft1.s3.amazonaws.com/customer/1513255394blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'sasdf', 'SGNR', 'Raj', 'India', 335001, '123456', '2017-12-14 12:41:55'),
(2, 1, 18, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1513255394blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'sasdf', 'SGNR', 'Raj', 'India', 335001, '123456', '2017-12-14 12:41:55'),
(3, 1, 19, 4, 2, 'http://instacraft1.s3.amazonaws.com/customer/1513255394blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'sasdf', 'SGNR', 'Raj', 'India', 335001, '123456', '2017-12-14 12:41:55'),
(4, 2, 1, 2, 1, 'http://instacraft1.s3.amazonaws.com/customer/1513342179blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'Test', 'SGNR', 'Raj', 'India', 335001, '123456', '2017-12-15 12:48:19'),
(5, 2, 17, 3, 2, 'http://instacraft1.s3.amazonaws.com/customer/1513342179blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'Test', 'SGNR', 'Raj', 'India', 335001, '123456', '2017-12-15 12:48:19'),
(6, 3, 1, 1, 1, 'http://instacraft1.s3.amazonaws.com/customer/1513599145blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'dfgd', 'SGNR', 'Raj', 'India', 335001, '123456', '2017-12-18 12:11:01'),
(7, 5, 19, 1, 2, 'http://instacraft1.s3.amazonaws.com/customer/1513599501blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'sfgsdg', 'SGNR', 'Raj', 'India', 335001, '123456', '2017-12-18 12:16:58'),
(8, 6, 1, 1, 1, 'http://instacraft1.s3.amazonaws.com/customer/1513670277blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'Green bouleward', 'Noida', 'UP', 'India', 201301, '12', '2017-12-19 07:56:33'),
(9, 7, 2, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1513677186blob', 'Chetan', '2017-11-15', '1234567890', 'Shipra sun city', 'Ghaziabad', 'UP', 'India', 335001, '123456', '2017-12-19 09:51:42'),
(10, 8, 18, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1513677679blob', 'Piyush', '2017-11-15', '1234567890', 'Sri ganganagar', 'SGNR', 'Raj', 'India', 335001, '123456', '2017-12-19 09:59:55'),
(11, 9, 2, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1513853162blob', ' Rahul', '27/26/1975', '9718963666', 'Kavi Nagar', 'GZB', 'UP', 'India', 201002, 'OK', '2017-12-21 10:44:36'),
(12, 10, 17, 1, 2, 'http://instacraft1.s3.amazonaws.com/customer/1514299108blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'Noida', 'Ghaziabad', 'UP', 'India', 335001, '123456', '2017-12-26 14:38:13'),
(13, 11, 2, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1514358119blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'sfdsd', 'sdf', 'sdf', 'sdfsd', 432523, 'sdf', '2017-12-27 07:00:32'),
(14, 12, 2, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1514374999blob', 'Rahul  Sharma', '2017-12-27', '9876543212', 'HRrh', 'Hd', 'Jfk', 'India ', 566666, 'BCNDb', '2017-12-27 11:44:06'),
(15, 13, 2, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1514382381blob', 'Rakesh kumar', '2017-11-15', '1234567890', 'test', 'SGNR', 'Raj', 'India', 335001, '123456', '2017-12-27 13:44:51'),
(16, 14, 2, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1514896707blob', ' ddd', '2018-1-16', '45555657778', '56657488484', 'Noida', 'Uttar Pradesh', 'India', 201301, '201301', '2018-01-02 12:36:52'),
(17, 15, 18, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1514956089blob', ' abc', '2014-8-12', '0120-665544', 'Green Boulevard', 'noida', 'delhi', 'india', 49, 'xyz', '2018-01-03 05:06:40'),
(18, 16, 2, 1, 3, 'http://instacraft1.s3.amazonaws.com/customer/1514957952blob', ' Vbh', '2018-1-10', '9958557182', 'B9/14 Flat no. 103\r\nBhagirathi Apartments Sector 62 Noida', 'Noida', 'Uttar Pradesh', 'India', 201301, 'Fgg', '2018-01-03 05:37:44'),
(19, 17, 1, 1, 1, 'http://instacraft1.s3.amazonaws.com/customer/1514966071blob', 'Priya', '2018-1-18', '9876543210', 'Green Boulevard', 'Noida', 'New Delhi', 'india', 201301, 'xyz', '2018-01-03 07:53:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

CREATE TABLE `tbl_pages` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pages`
--

INSERT INTO `tbl_pages` (`id`, `slug`, `title`, `content`, `created_on`) VALUES
(1, 'terms-conditions', 'Terms&Conditions', '    <section class=\"tnc\">\n        <h1>Terms of Service</h1>\n        <p>October 3, 2017</p>\n        <p>The terms and conditions stated herein (collectively, the “Agreement”) constitute a legal agreement between you (referred to sometimes as “user” or “you”) and InstaCraft Inc., and its subsidiaries and affiliates (collectively, “InstaCraft” or the “Company”). In order to use the Service (defined below) and the associated Application (defined below) you must agree to the Terms and Conditions that are set out below. By using or receiving any services supplied to you by the Company (collectively, the “Service”), and/or accessing, downloading, installing or using any associated application or website provided by the Company (including without limitation, the InstaCraft website located at getinstacraft.com) (collectively, the “Application”), you hereby expressly acknowledge and agree to be bound by the terms and conditions of the Agreement, and any future amendments and additions to this Agreement as published from time to time at the INSTACRAFT website or through the Service.</p>\n\n        <h3>USER AGREEMENT</h3>\n        <h5>DISCLAIMER & ACKNOWLEDGMENT</h5>\n        <p>THE COMPANY IS NOT, AS DEFINED BY THE <a href=\"http://www.maine.gov/dhhs/mecdc/public-health-systems/mmm/index.shtml\" target=\"_blank\">MAINE MEDICAL USE OF MARIJUANA PROGRAM</a>(“MMMP”), EITHER A MEDICAL CANNABIS COLLECTIVE OR COOPERATIVE OR MEDICAL MARIJUANA DISPENSARY (“DISPENSARY”) OR A REGISTERED PRIMARY CAREGIVER (“CAREGIVER”) AND DOES NOT ITSELF PROVIDE MEDICAL CANNABIS DELIVERY SERVICES TO MEDICAL CANNABIS PATIENTS, BUT RATHER THOSE SERVICES ARE PROVIDED BY EMPLOYEES AND CONTRACTORS OF CAREGIVERS OR DISPENSARIES. THE COMPANY DOES NOT PROVIDE OR SELL MEDICAL CANNABIS AND IS NOT A MEDICAL CANNABIS DELIVERY SERVICE PROVIDER. IT IS THE SOLE RESPONSIBILITY OF THE THIRD PARTY DISPENSARY OR CAREGIVER TO OFFER STATE LAW COMPLIANT SERVICES, WHICH MAY BE LOCATED, SCHEDULED, AND COORDINATED THROUGH USE OF THE APPLICATION OR SERVICE. INSTACRAFT OFFERS PRE-VERIFICATION OF USERS AND PROVIDES USERS’ INFORMATION TO REGISTERED CAREGIVERS AND DISPENSARIES.  THE COMPANY DOES NOT AND DOES NOT INTEND TO PROVIDE DELIVERY SERVICES OR ACT IN ANY WAY AS A DELIVERY SERVICE PROVIDER, AND HAS NO RESPONSIBILITY OR LIABILITY FOR ANY DELIVERY SERVICES PROVIDED TO YOU BY THIRD PARTY CAREGIVERS OR DISPENSARIES OR THEIR CONTRACTORS.\n        </p>\n\n\n        <h5>ACKNOWLEDGMENT OF FEDERAL LAW</h5>\n        <p>User expressly acknowledges that INSTACRAFT is for residents with laws regulating medical use of cannabis only and that medical cannabis collectives and patients are established pursuant to their respective State laws.  Marijuana is included on Schedule 1 under the United States Controlled Substances Act.  Under the federal laws of the United States of America, manufacturing, distributing, dispensing or possession of marijuana is illegal, and individuals are subject to arrest and/or prosecution for doing so.  User further acknowledges that medical uses not recognized as a valid defense under federal laws regarding marijuana. User also acknowledges that the interstate transportation of marijuana is a federal offense.</p>\n\n\n\n        <h5>ACKNOWLEDGMENT OF MAINE LAW</h5>\n        <p>User expressly acknowledges that the use, possession, cultivation, transportation and distribution of cannabis is illegal in Maine unless all participants are acting completely within the scope of Maine’s medical cannabis laws as set forth in the <a href=\"http://www.maine.gov/dhhs/mecdc/public-health-systems/mmm/index.shtml\" target=\"_blank\" >MAINE MEDICAL USE OF MARIJUANA PROGRAM</a>, <a href=\"http://www.maine.gov/dhhs/mecdc/public-health-systems/mmm/documents/MMMP-Rules-144c122.pdf\" target=\"_blank\"> the Rules Governing the Maine Medical Use of Marijuana Program</a>, and the <a href=\"http://www.mainelegislature.org/legis/statutes/22/title22ch558-Csec0.html\" target=\"_blank\">MMMP Statute (Title 22, Ch 558-C)</a>, and any amendments thereto. \n        </p>\n\n\n\n        <h5>ACKNOWLEDGMENT OF THE LAWS OF USERS STATE OF RESIDENCY</h5>\n        <p>The Company has its principal place of business in Maine.  Even though the InstaCraft Application may be accessed outside of Maine, the Service, as far as it pertains to medical marijuana products, is currently available only to users, Caregivers, and  Dispensaries located in Maine (the Company’s CBD is derived from industrial hemp with less than 0.3% THC and therefore, according to 2017 definitions and guidance of the U.S. Drug Enforcement Agency, is not a medical marijuana product).  In all events, you must abide by and follow the laws of the state in which you are a resident.  User expressly acknowledges and assumes full responsibility for cooperating with the laws of the state of the user’s residency.</p>\n\n        <h5>TERMS & CONDITIONS OF SERVICE</h5>\n        <p>The terms and conditions stated in this Agreement constitute a legal agreement between you and the Company. In order to use the Service (defined below) and the associated Application (defined below) you must agree to the Terms and Conditions that are set out below. By using or receiving any services provided to you by the Company (collectively, the “Service”), and downloading, installing or using any associated application supplied or website provided by the Company which purpose is to enable you to use the Service (collectively, the “Application”), you hereby expressly acknowledge and agree to be bound by the terms and conditions of the Agreement, and any future amendments and additions to this Agreement as published from time to time at the Company website <a href=\"http://www.getinstacraft.com/\" target=\"_blank\">www.getinstacraft.com</a> or through the Service. </p>\n\n        <p>The Company is willing to license, not sell, the INSTACRAFT Application to you only upon the condition that you accept all the terms contained in this Agreement. By signing up with or by using the INSTACRAFT Application, you indicate that you understand this Agreement and accept all of its terms. If you do not accept all the terms of this Agreement, then the Company is unwilling to license the INSTACRAFT Application to you.</p>\n        <p>The Company reserves the right to modify the terms and conditions of this Agreement or its policies relating to the Service or Application at any time, effective upon posting of an updated version of this Agreement on the Service or Application. You are responsible for regularly reviewing this Agreement. Continued use of the Service or Application after any such changes shall constitute your consent to such changes.</p>\n        <p>The INSTACRAFT Application provides the communication structure to enable a connection between persons (“Users”) and third party Caregivers or Dispensaries. This Agreement describes the terms and conditions that will govern your use of and participation in the INSTACRAFT Application.</p>\n\n\n        <h5>KEY CONTENT-RELATED TERMS</h5>\n        <p>“Content” means text, graphics, images, music, software (excluding the Application), audio, video, information or other materials.<p>\n\n        <p>“Company Content” means Content that Company makes available through the Service or Application, including any Content licensed from a third party, but \n            excluding User Content.</p>\n\n        <p>“User” means a person who accesses or uses the Service or Application<p>\n\n        <p>“User Content” means Content that a User posts, uploads, publishes, submits or transmits to be made available through the Service or Application.</p>\n\n        <p>“Collective Content” means, collectively, Company Content and User Content.<p>\n\n\n\n        <h5>REPRESENTATIONS AND WARRANTIES</h5>\n        <p>Users agree not to post, email, or otherwise make available Content: a) that is unlawful, harmful, threatening, abusive, harassing, defamatory, libelous, invasive of another’s privacy, or is harmful to minors in any way; b) that advertises any illegal service or the sale of any items which are prohibited or restricted by the laws of your State; c) attempt to gain unauthorized access to the Company’s computer systems or engage in any activity that disrupts, diminishes the quality of, interferes with the performance of, or impairs the functionality of, the Service or the INSTACRAFT Application (including the INSTACRAFT website). By using the Application or Service, you expressly represent and warrant that you are legally entitled to enter into this Agreement. If you reside in a jurisdiction that restricts the use of the Service because of age, or restricts the ability to enter into agreements such as this one due to age or other restrictions, you must abide by such age limits or other restrictions. Without limiting the foregoing, the Service and Application is not available to children (persons under the age of 18).\n        </p>\n\n        <p>By using the Application or Service, you represent and warrant that you are at least 18 years old. By using the Application or the Service, you represent and warrant that you have the right, authority and capacity to enter into this Agreement and to abide by the terms and conditions of this Agreement. Your participation in using the Service and/or Application is for your sole, personal use. You may not authorize others to use your user status, and you may not assign or otherwise transfer your user account to any other person or entity. When using the Application or Service you agree to comply with all applicable laws from your home nation, country, state and city in which you are present while using the Application or Service.</p>\n\n        <p>You may only access the Service using authorized means. It is your responsibility to check to ensure you download the correct Application for your device. The Company is not liable if you do not have a compatible handset or if you have downloaded the wrong version of the Application for your handset. The Company reserves the right to terminate this Agreement should you be using the Service or Application with an incompatible or unauthorized device.</p>\n\n\n        <p>By using the Application or the Service, you agree that:</p>\n        <ol>\n            <li><p>You will only use the Service or Application for lawful purposes; you will not use the Services for sending or storing any unlawful material or for fraudulent purposes.</p></li>\n            <li><p>You will not use the Service or Application to cause nuisance, annoyance or inconvenience.</p></li>\n            <li><p>You will not impair the proper operation of the network.</p></li>\n            <li><p>You will not try to harm the Service or Application in any way whatsoever.</p></li>\n            <li><p>You will not copy, or distribute the Application or other content without written permission from the Company.</p></li>\n            <li><p>You will only use the Application and Service for your own use and will not resell it to a third party.</p></li>\n            <li><p>You will keep secure and confidential your account password or any identification we provide you which allows access to the Service.</p></li>\n            <li><p>You will provide us with whatever proof of identity we may reasonably request.</p></li>\n            <li><p>You will at all times act in full compliance with the laws of your State pertaining to medical cannabis.</p></li>\n            </ul>\n\n\n\n            <h5>LICENSE GRANT, RESTRICTIONS, AND COPYRIGHT POLICY</h5>\n            <p>LICENSES TO COMPANY CONTENT AND USER CONTENT GRANTED BY COMPANY</p>\n\n            <p>Subject to your compliance with the terms and conditions of this Agreement, Company grants you a limited, non-exclusive, non-transferable license: (i) to view, download and print any Company Content solely for your personal and non-commercial purposes; and (ii) to view any User Content to which you are permitted access solely for your personal and non-commercial purposes. You have no right to sublicense the license rights granted in this section.</p>\n            <p>You will not use, copy, adapt, modify, prepare derivative works based upon, distribute, license, sell, transfer, publicly display, publicly perform, transmit, stream, broadcast or otherwise exploit the Service, Application or Collective Content, except as expressly permitted in this Agreement. No licenses or rights are granted to you by implication or otherwise under any intellectual property rights owned or controlled by Company or its licensors, except for the licenses and rights expressly granted in this Agreement.</p>\n\n\n\n            <h5>LICENSE GRANTED BY USER</h5>\n\n\n            <p>InstaCraft may, in its sole discretion, permit Users to post, upload, publish, submit or transmit User Content. By making available any User Content on or through the Service or Application, you hereby grant to Company a worldwide, irrevocable, perpetual, non-exclusive, transferable, royalty-free license, with the right to sublicense, to use, view, copy, adapt, modify, distribute, license, sell, transfer, publicly display, publicly perform, transmit, stream, broadcast and otherwise exploit such User Content only on, through or by means of the Service or Application. Company does not claim any ownership rights in any User Content and nothing in this Agreement will be deemed to restrict any rights that you may have to use and exploit any User Content. </p>\n            <p>You acknowledge and agree that you are solely responsible for all User Content that you make available through the Service or Application. Accordingly, you represent and warrant that: (i) you either are the sole and exclusive owner of all User Content that you make available through the Service or Application or you have all rights, licenses, consents and releases that are necessary to grant to Company and to the rights in such User Content, as contemplated under this Agreement; and (ii) neither the User Content nor your posting, uploading, publication, submission or transmittal of the User Content or Company’s use of the User Content (or any portion thereof) on, through or by means of the Service or Application will infringe, misappropriate or violate a third party’s patent, copyright, trademark, trade secret, moral rights or other intellectual property rights, or rights of publicity or privacy, or result in the violation of any applicable law or regulation</p>\n            <p>You agree that the Company may verify your medical recommendation and may share your identification, your medical recommendation and the results of the medical recommendation verification with Dispensaries or Caregivers.</p>\n\n\n\n\n            <h5>INSTACRAFT COMMUNICATIONS</h5>\n\n\n            <p>By becoming a User, you expressly consent and agree to accept and receive communications from us and/or Dispensaries or Caregivers that you transact with, including via e-mail, text message, calls, and push notifications to the cellular telephone number you provided to us. By consenting to being contacted by the Company, you understand and agree that you may receive communications generated by automatic telephone dialing systems and/or which will deliver prerecorded messages sent by or on behalf of the Company, its affiliated companies and/or Drivers, including but not limited to: operational communications concerning your User account or use of the INSTACRAFT Application or Services, updates concerning new and existing features of the INSTACRAFT Application, communications concerning promotions run by us or third party Caregivers or Dispensaries, and news concerning the Company and industry developments. IF YOU WISH TO OPT-OUT OF PROMOTIONAL EMAILS, TEXT MESSAGES, OR OTHER COMMUNICATIONS, YOU MAY OPT-OUT BY FOLLOWING THE UNSUBSCRIBE OPTIONS PROVIDED TO YOU. Standard text messaging charges applied by your cell phone carrier will apply to text messages we send. You acknowledge that you are not required to consent to receive promotional messages as a condition of using the INSTACRAFT Application or the Service. However, you acknowledge that opting out of receiving text messages or other communications may impact your use of the INSTACRAFT Application or the Service.</p>\n\n\n            <h5>APPLICATION LICENSE</h5>\n\n\n            <p>Subject to your compliance with this Agreement, Company grants you a limited non-exclusive, non-transferable license to download and install a copy of the Application on a single mobile device or computer that you own or control and to run such copy of the Application solely for your own personal use. Furthermore, with respect to any Application accessed through or downloaded from the Apple App Store, Android Market, Amazon App Store, BlackBerry App World, Samsung Apps Store, Nokia OVI store, and Windows marketplace for Mobile (“App Store Sourced Application”), you will use the App Store Sourced Application as permitted by the “Usage Rules” set forth in the App Store Sourced Application Terms of Service. Company reserves all rights in and to the Application not expressly granted to you under this Agreement.</p>\n\n\n\n\n            <h5>FEE AND REFUND POLICY</h5>\n\n\n            <p>Any fees that the Company may charge you for the Application or Service, are due immediately and are non-refundable. This no refund policy shall apply at all times regardless of your decision to terminate your usage, our decision to terminate your usage, disruption caused to our Application or Service either planned, accidental or intentional, or any reason whatsoever. The Company reserves the right to determine final prevailing pricing – Please note the pricing information published on the website may not reflect the prevailing pricing.\n            </p>\n            <p>The Company, at its sole discretion, may make promotional offers with different features and different rates to any of our customers. These promotional offers, unless made to you, shall have no bearing whatsoever on your offer or contract. Any such promotions shall be made subject to its particular terms, and unless expressly provided otherwise shall expire ninety (90) days following the date of the promotion offer.  The Company may change the fees for our Service or Application, as we deem necessary for our business. We encourage you to check back at our website periodically if you are interested about how we charge for the Service or Application.</p>\n\n\n\n            <h5>INTELLECTUAL PROPERTY OWNERSHIP</h5>\n\n\n            <p>The Company alone (and its licensors, where applicable) shall own all right, title and interest, including all related intellectual property rights, in and to the Application and the Service and any suggestions, ideas, enhancement requests, feedback, recommendations or other information provided by you or any other party relating to the Application or the Service. This Agreement is not a sale and does not convey to you any rights of ownership in or related to the Application or the Service, or any intellectual property rights owned by the Company. The Company name, the Company logo, and the product names associated with the Application and Service are trademarks of the Company or third parties, and no right or license is granted to use them.</p>\n\n\n\n            <h5>THIRD PARTY INTERACTIONS</h5>\n\n\n            <p>During use of the Application and Service, you may enter into correspondence with, purchase goods and/or services from, or participate in promotions of third party service providers, advertisers or sponsors showing their goods and/or services through the Application or Service. In particular, Company is not a party to any transaction that a User may enter into with a Caregiver or Dispensary or third party payment processor.  Any such activity, and any terms, conditions, warranties or representations associated with such activity, is solely between you and the applicable third-party. The Company and its licensors shall have no liability, obligation or responsibility for any such correspondence, purchase, transaction or promotion between you and any such third-party. The Company does not endorse any sites on the Internet that are linked through the Service or Application, and in no event shall the Company or its licensors be responsible for any content, products, services or other materials on or available from such sites or third party providers. The Company provides the Application and Service to you pursuant to the terms and conditions of this Agreement. You recognize, however, that certain third-party providers of goods and/or services may require your agreement to additional or different terms and conditions prior to your use of or access to such goods or services, and the Company disclaims any and all responsibility or liability arising from such agreements between you and the third party providers.\n            </p>\n            <p>The Company may rely on third party advertising and marketing supplied through the Application or Service and other mechanisms to subsidize the Application or Service. By agreeing to these terms and conditions you agree to receive such advertising and marketing.  The Company may compile and release information regarding you and your use of the Application or Service on an anonymous basis as part of a customer profile or similar report or analysis. You agree that it is your responsibility to take reasonable precautions in all actions and interactions with any third party you interact with through the Service.</p>\n\n\n            <h5>INDEMNIFICATION</h5>\n\n\n            <p>By entering into this Agreement and using the Application or Service, you agree that you shall defend, indemnify and hold the Company, its licensors and each such party’s parent organizations, subsidiaries, affiliates, officers, directors, Users, employees, attorneys and agents harmless from and against any and all claims, costs, damages, losses, liabilities and expenses (including attorneys’ fees and costs) arising out of or in connection with: (a) your violation or breach of any term of this Agreement or any applicable law or regulation, whether or not referenced herein; (b) your violation of any rights of any third party, including providers of delivery services arranged via the Service or Application, or (c) your use or misuse of the Application or Service.\n            </p>\n\n            <h5>DISCLAIMER OF WARRANTIES</h5>\n\n\n            <p>THE COMPANY MAKES NO REPRESENTATION, WARRANTY, OR GUARANTY AS TO THE RELIABILITY, TIMELINESS, QUALITY, SUITABILITY, AVAILABILITY, ACCURACY OR COMPLETENESS OF THE SERVICE OR APPLICATION. THE COMPANY DOES NOT REPRESENT OR WARRANT THAT: (A) THE USE OF THE SERVICE OR APPLICATION WILL BE SECURE, TIMELY, UNINTERRUPTED OR ERROR-FREE OR OPERATE IN COMBINATION WITH ANY OTHER HARDWARE, APPLICATION, SYSTEM OR DATA, (B) THE SERVICE OR APPLICATION WILL MEET YOUR REQUIREMENTS OR EXPECTATIONS, (C) ANY STORED DATA WILL BE ACCURATE OR RELIABLE, (D) THE QUALITY OF ANY PRODUCTS, SERVICES, INFORMATION, OR OTHER MATERIAL PURCHASED OR OBTAINED BY YOU THROUGH THE SERVICE WILL MEET YOUR REQUIREMENTS OR EXPECTATIONS, (E) ERRORS OR DEFECTS IN THE SERVICE OR APPLICATION WILL BE CORRECTED, OR (F) THE SERVICE OR THE SERVER(S) THAT MAKE THE SERVICE AVAILABLE ARE FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS. THE SERVICE AND APPLICATION IS PROVIDED TO YOU STRICTLY ON AN “AS IS” BASIS. ALL CONDITIONS, REPRESENTATIONS AND WARRANTIES, WHETHER EXPRESS, IMPLIED, STATUTORY OR OTHERWISE, INCLUDING, WITHOUT LIMITATION, ANY IMPLIED WARRANTY OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT OF THIRD PARTY RIGHTS, ARE HEREBY DISCLAIMED TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW BY THE COMPANY. THE COMPANY MAKES NO REPRESENTATION, WARRANTY, OR GUARANTY AS TO THE RELIABILITY, SAFETY, TIMELINESS, QUALITY, SUITABILITY OR AVAILABILITY OF ANY SERVICES, PRODUCTS OR GOODS OBTAINED BY THIRD PARTIES THROUGH THE USE OF THE SERVICE OR APPLICATION. YOU ACKNOWLEDGE AND AGREE THAT THE ENTIRE RISK ARISING OUT OF YOUR USE OF THE APPLICATION AND SERVICE, AND ANY THIRD PARTY SERVICES OR PRODUCTS REMAINS SOLELY WITH YOU, TO THE MAXIMUM EXTENT PERMITTED BY LAW.</p>\n\n            <h5>INTERNET DELAYS</h5>\n\n\n            <p>THE COMPANY’S SERVICE AND APPLICATION MAY BE SUBJECT TO LIMITATIONS, DELAYS, AND OTHER PROBLEMS INHERENT IN THE USE OF THE INTERNET AND ELECTRONIC COMMUNICATIONS. THE COMPANY IS NOT RESPONSIBLE FOR ANY DELAYS, DELIVERY FAILURES, OR OTHER DAMAGE RESULTING FROM SUCH PROBLEMS.\n            </p>\n\n            <h5>LIMITATION OF LIABILITY</h5>\n\n\n            <p>IN NO EVENT SHALL THE COMPANY AND/OR ITS LICENSORS BE LIABLE TO ANYONE FOR ANY INDIRECT, PUNITIVE, SPECIAL, EXEMPLARY, INCIDENTAL, CONSEQUENTIAL OR OTHER DAMAGES OF ANY TYPE OR KIND (INCLUDING PERSONAL INJURY, LOSS OF DATA, REVENUE, PROFITS, USE OR OTHER ECONOMIC ADVANTAGE). THE COMPANY AND/OR ITS LICENSORS SHALL NOT BE LIABLE FOR ANY LOSS, DAMAGE OR INJURY WHICH MAY BE INCURRED BY YOU, INCLUDING BUT NOT LIMITED TO LOSS, DAMAGE OR INJURY ARISING OUT OF, OR IN ANY WAY CONNECTED WITH THE SERVICE OR APPLICATION, INCLUDING BUT NOT LIMITED TO THE USE OR INABILITY TO USE THE SERVICE OR APPLICATION, ANY RELIANCE PLACED BY YOU ON THE COMPLETENESS, ACCURACY OR EXISTENCE OF ANY ADVERTISING, OR AS A RESULT OF ANY RELATIONSHIP OR TRANSACTION BETWEEN YOU AND ANY THIRD PARTY SERVICE PROVIDER, ADVERTISER OR SPONSOR WHOSE ADVERTISING APPEARS ON THE WEBSITE OR IS REFERRED BY THE SERVICE OR APPLICATION, EVEN IF THE COMPANY AND/OR ITS LICENSORS HAVE BEEN PREVIOUSLY ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.</p>\n            <p>THE COMPANY MAY INTRODUCE YOU TO THIRD PARTY DELIVERY SERVICE PROVIDERS FOR THE PURPOSES OF PROVIDING DELIVERY SERVICES. WE WILL NOT ASSESS THE SUITABILITY, LEGALITY OR ABILITY OF ANY THIRD PARTY DELIVERY SERVICE PROVIDERS AND YOU EXPRESSLY WAIVE AND RELEASE THE COMPANY FROM ANY AND ALL ANY LIABILITY, CLAIMS OR DAMAGES ARISING FROM OR IN ANY WAY RELATED TO THE THIRD PARTY DELIVERY SERVICE PROVIDER. YOU ACKNOWLEDGE THAT THIRD PARTY DELIVERY SERVICE PROVIDERS PROVIDING DELIVERY SERVICES REQUESTED THROUGH THE COMPANY MAY OFFER DELIVERY SERVICES AND MAY NOT BE PROFESSIONALLY LICENSED OR PERMITTED. THE COMPANY WILL NOT BE A PARTY TO DISPUTES, NEGOTIATIONS OF DISPUTES BETWEEN YOU AND ANY THIRD PARTY PROVIDERS. WE CANNOT AND WILL NOT PLAY ANY ROLE IN MANAGING PAYMENTS BETWEEN YOU AND THE THIRD PARTY PROVIDERS. RESPONSIBILITY FOR THE DECISIONS YOU MAKE REGARDING SERVICES OFFERED VIA THE APPLICATION OR SERVICE (WITH ALL ITS IMPLICATIONS) RESTS SOLELY WITH YOU. WE WILL NOT ASSESS THE SUITABILITY, LEGALITY OR ABILITY OF ANY SUCH THIRD PARTIES AND YOU EXPRESSLY WAIVE AND RELEASE THE COMPANY FROM ANY AND ALL LIABILITY, CLAIMS, CAUSES OF ACTION, OR DAMAGES ARISING FROM YOUR USE OF THE APPLICATION OR SERVICE, OR IN ANY WAY RELATED TO THE THIRD PARTIES INTRODUCED TO YOU BY THE APPLICATION OR SERVICE. YOU EXPRESSLY WAIVE AND RELEASE ANY AND ALL RIGHTS AND BENEFITS UNDER SECTION 1542 OF THE CIVIL CODE OF THE STATE OF CALIFORNIA (OR ANY ANALOGOUS LAW OF ANY OTHER STATE), WHICH READS AS FOLLOWS: “A GENERAL RELEASE DOES NOT EXTEND TO CLAIMS WHICH THE CREDITOR DOES NOT KNOW OR SUSPECT TO EXIST IN HIS FAVOR AT THE TIME OF EXECUTING THE RELEASE, WHICH, IF KNOWN BY HIM, MUST HAVE MATERIALLY AFFECTED HIS SETTLEMENT WITH THE DEBTOR.”</p>\n            <p>THE QUALITY OF THE DELIVERY SERVICES SCHEDULED THROUGH THE USE OF THE SERVICE OR APPLICATION IS ENTIRELY THE RESPONSIBILITY OF THE THIRD PARTY PROVIDER WHO ULTIMATELY PROVIDES SUCH DELIVERY SERVICES TO YOU. YOU UNDERSTAND, THEREFORE, THAT BY USING THE APPLICATION AND THE SERVICE, YOU MAY BE EXPOSED TO A DELIVERY SERVICE THAT IS POTENTIALLY DANGEROUS, OFFENSIVE, HARMFUL TO MINORS, UNSAFE OR OTHERWISE OBJECTIONABLE, AND THAT YOU USE THE APPLICATION AND THE SERVICE AT YOUR OWN RISK.</p>\n\n\n            <h5>NOTICE</h5>\n\n\n            <p>The Company may give notice by means of a general notice on the Service, electronic mail to your email address on record in the Company’s account information, or by written communication sent by first class mail or pre-paid post to your address on record in the Company’s account information. Such notice shall be deemed to have been given upon the expiration of 48 hours after mailing or posting (if sent by first class mail or pre-paid post) or 12 hours after sending (if sent by email). You may give notice to the Company (such notice shall be deemed given when received by the Company) at any time by sending an email to: support@getinstacraft.com; Please specify the reason for the email in the subject line so it can be forwarded to the proper department.</p>\n\n            <h5>ASSIGNMENT</h5>\n\n\n            <p>This Agreement may not be assigned by you without the prior written approval of the Company but may be assigned without your consent by the Company to (i) a parent or subsidiary, (ii) an acquirer of assets, or (iii) a successor by merger. Any purported assignment in violation of this section shall be void.</p>\n\n\n\n\n            <h5>EXPORT CONTROL</h5>\n\n\n            <p>You agree to comply fully with all U.S. and foreign export laws and regulations to ensure that neither the Application nor any technical data related thereto nor any direct product thereof is exported or re-exported directly or indirectly in violation of, or used for any purposes prohibited by, such laws and regulations. By using the App Store Sourced Application, you represent and warrant that: (i) you are not located in a country that is subject to a U.S. Government embargo, or that has been designated by the U.S. Government as a “terrorist supporting” country; and (ii) you are not listed on any U.S. Government list of prohibited or restricted parties.</p>\n\n            <h5>DISPUTE RESOLUTION</h5>\n\n\n            <p>You and Company agree that any dispute, claim or controversy arising out of or relating to this Agreement or the breach, termination, enforcement, interpretation or validity thereof or the use of the Service or Application (collectively, “Disputes”) will be settled by binding arbitration, except that each party retains the right to bring an individual action in small claims court and the right to seek injunctive or other equitable relief in a court of competent jurisdiction to prevent the actual or threatened infringement, misappropriation or violation of a party’s copyrights, trademarks, trade secrets, patents or other intellectual property rights. You acknowledge and agree that you and Company are each waiving the right to a trial by jury or to participate as a plaintiff or class User in any purported class action or representative proceeding. Further, unless both you and Company otherwise agree in writing, the arbitrator may not consolidate more than one person’s claims, and may not otherwise preside over any form of any class or representative proceeding. If this specific paragraph is held unenforceable, then the entirety of this “Dispute Resolution” section will be deemed void. Except as provided in the preceding sentence, this “Dispute Resolution” section will survive any termination of this Agreement.</p>\n            <p>Arbitration Rules and Governing Law. The arbitration will be administered by the American Arbitration Association (“AAA”) in accordance with the Commercial Arbitration Rules and the Supplementary Procedures for Consumer Related Disputes (the “AAA Rules”) then in effect, except as modified by this “Dispute Resolution” section. (The AAA Rules are available at www.adr.org/arb_med or by calling the AAA at 1-800-778-7879.) The Federal Arbitration Act will govern the interpretation and enforcement of this Section.</p>\n            <p>Arbitration Process. A party who desires to initiate arbitration must provide the other party with a written Demand for Arbitration as specified in the AAA Rules. The arbitrator will be either a retired judge or an attorney licensed to practice law in the state of Maine and will be selected by the parties from the AAA’s roster of consumer dispute arbitrators. If the parties are unable to agree upon an arbitrator within seven (7) days of delivery of the Demand for Arbitration, then the AAA will appoint the arbitrator in accordance with the AAA Rules. \n            </p>\n            <p>Arbitration Location and Procedure. Unless you and Company otherwise agree, the arbitration will be conducted in the county of Cumberland in the State of Maine. If your claim does not exceed $10,000, then the arbitration will be conducted solely on the basis of documents you and Company submit to the arbitrator, unless you request a hearing or the arbitrator determines that a hearing is necessary. If your claim exceeds $10,000, your right to a hearing will be determined by the AAA Rules. Subject to the AAA Rules, the arbitrator will have the discretion to direct a reasonable exchange of information by the parties, consistent with the expedited nature of the arbitration.</p>\n            <p>Arbitrator’s Decision. The arbitrator will render an award within the time frame specified in the AAA Rules. The arbitrator’s decision will include the essential findings and conclusions upon which the arbitrator based the award. Judgment on the arbitration award may be entered in any court having jurisdiction thereof. The arbitrator’s award damages must be consistent with the terms of the “Limitation of Liability” section above as to the types and the amounts of damages for which a party may be held liable. The arbitrator may award declaratory or injunctive relief only in favor of the claimant and only to the extent necessary to provide relief warranted by the claimant’s individual claim. The prevailing party in arbitration will be entitled to an award of attorneys’ fees and expenses, to the extent provided under applicable law.</p>\n            <p>Fees. Your responsibility to pay any AAA filing, administrative and arbitrator fees will be solely as set forth in the AAA Rules.\n            </p>\n            <p>Changes. Notwithstanding the provisions of the modification-related provisions above, if Company changes this “Dispute Resolution” section after the date you first accepted this Agreement (or accepted any subsequent changes to this Agreement), you may reject any such change by sending us a notice to support@getinstacraft.com with “Legal” in the subject line within 30 days of the date such change became effective, as indicated in the “Last Updated Date” above or in the date of Company’s email to you notifying you of such change. By rejecting any change, you are agreeing that you will arbitrate any Dispute between you and Company in accordance with the provisions of this “Dispute Resolution” section as of the date you first accepted this Agreement (or accepted any subsequent changes to this Agreement).\n            </p>\n\n            <h5>GENERAL</h5>\n\n\n            <p>No joint venture, partnership, employment, or agency relationship exists between you, the Company or any third party provider as a result of this Agreement or use of the Service or Application. If any provision of the Agreement is held to be invalid or unenforceable, such provision shall be struck and the remaining provisions shall be enforced to the fullest extent under law. The failure of the Company to enforce any right or provision in this Agreement shall not constitute a waiver of such right or provision unless acknowledged and agreed to by the Company in writing.\n            </p>\n\n            <p>This User Agreement constitutes the entire agreement between you and the Company and governs your use of the Service, superseding any prior agreements between you and the Company. The User Agreement and the relationship between you and InstaCraft shall be governed by the laws of the State of Maine without regard to its conflict of law provisions. You and InstaCraft agree to submit to binding arbitration for any dispute arising out of your relationship with InstaCraft and that such arbitration will take place in the county of Cumberland in the State of Maine. The failure of InstaCraft to exercise or enforce any right or provision of the User Agreement shall not constitute a waiver of such right or provision. If any provision of the User Agreement is found by an arbitrator to be invalid, the parties nevertheless agree that the arbitrator should endeavor to give effect to the parties’ intentions as reflected in the provision, and the other provisions of the User Agreement remain in full force and effect. You agree that regardless of any statute or law to the contrary, any claim or cause of action arising out of or related to use of the Service or the Terms of Service must be filed within one (1) year after such claim or cause of action arose or be forever barred.</p>\n    </section>\n', '2017-12-28 11:30:38'),
(2, 'about-us', 'About Us', '    <section class=\"tnc\">\r\n\r\n        <p>We provide free and discounted cannabis medicine for low income and disabled patients. Every purchase you make supports families in your local community. We also believe in giving back to individuals who help protect our communities and our freedom. A percentage of all our profits goes to charity. We support first responders and veterans. Our future vision is of a world where legal cannabis medicine is available to those who need it – quickly, safely, and effectively.</p>\r\n\r\n        <p>We believe in evolving the status quo and striving every day to make a positive change in the world.  We believe nearly everyone should have access to Craft Cannabis™ Medicine, grown by Craft Caregivers with an eye for detail and a heart of compassion. We believe we can craft a new reality by improving legal access to the high quality medicine that many people need to live their full potential. With your help in making us grow, together we can change the world.</p>\r\n\r\n        <p>Every product on InstaCraft’s menu is grown by true craftsman dedicated like artists to making the highest quality, Craft Cannabis.  We are a team of hardworking professionals who work tirelessly to provide solutions for the patients and caregivers we work with. Each item on our menu is carefully selected by our team of curators who have years of hands on cannabis growing experience, and a passionate commitment to providing medicine that will lift the quality of patient\'s lives – across the many conditions that may be aided by cannabis. Our goal is to provide our app users with the highest level of service and satisfaction in the industry. </p>\r\n        <p><strong>Craft Community. Craft Wellness. Craft Cannabis.<strong><p>\r\n    </section>\r\n       \r\n', '2017-12-28 12:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_assigned` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=>not Assigned,''1''=>Assigned',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `driver_id`, `name`, `is_assigned`, `created_at`, `updated_at`) VALUES
(1, 0, 'Default Template', '0', '2017-10-04 11:48:01', '0000-00-00 00:00:00'),
(2, 1, 'Template 1', '1', '2018-01-04 11:04:53', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `template_items`
--

CREATE TABLE `template_items` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template_items`
--

INSERT INTO `template_items` (`id`, `template_id`, `item_id`, `warehouse_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 90, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 1, 2, 50, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 18, 2, -8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `id` int(11) NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`id`, `time`) VALUES
(1, '10:00:00'),
(2, '10:15:00'),
(3, '10:30:00'),
(4, '10:45:00'),
(5, '11:00:00'),
(6, '11:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=>customer,1=>doctor',
  `refferal_code` int(11) DEFAULT NULL,
  `reffered_by` int(11) DEFAULT NULL COMMENT 'reffered_by=>user_id',
  `password` varchar(255) DEFAULT NULL,
  `new_password` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT '',
  `gender` enum('1','2','3') NOT NULL COMMENT '1=male 2=female 3=other',
  `country_code` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `device_id` varchar(255) NOT NULL DEFAULT '',
  `registration_type` enum('1','2') NOT NULL COMMENT '1=>email,2=>facebook',
  `facebook_social_id` varchar(255) DEFAULT NULL,
  `google_social_id` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `otp` int(4) DEFAULT NULL,
  `is_notification` enum('0','1') DEFAULT '1' COMMENT '0=>Not Active,1=>Active',
  `is_location` enum('0','1') NOT NULL COMMENT '0=>in active,1=>active',
  `is_verified` enum('0','1') DEFAULT '0' COMMENT '0=>Not Verfied,1=>Verified',
  `is_approved` enum('0','1') DEFAULT '0' COMMENT '0=>Not Approved,1=>Approved',
  `device_token` varchar(255) DEFAULT NULL,
  `device_type` enum('0','1') DEFAULT '0' COMMENT '0=>Android,1=>IOS',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `lang` enum('1','2','3') DEFAULT '1' COMMENT '''1''=English,''2''=>Chinese,''3'' =>Korean',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=>''not deleted,''1''=>''deleted''',
  `is_blocked` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=>''not blocked,''1''=>''blocked''',
  `token` text,
  `is_termcondition_accepted` enum('0','1') NOT NULL COMMENT '0=>not accepted,1=>accepted',
  `is_medical_prescription` enum('0','1') NOT NULL COMMENT '0=>no,1=>Yes',
  `zip` int(10) NOT NULL,
  `country` varchar(128) NOT NULL,
  `state` varchar(255) DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `street1` varchar(255) NOT NULL DEFAULT '',
  `street2` varchar(255) NOT NULL DEFAULT '',
  `preferred_zip_code` int(11) DEFAULT NULL COMMENT 'need admin to know  regions  to extend scheduled delivery',
  `availablity` enum('0','1','2') DEFAULT '0' COMMENT '0=>offline,1=>online,2=>incall',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `refferal_code`, `reffered_by`, `password`, `new_password`, `first_name`, `last_name`, `profile_pic`, `gender`, `country_code`, `email`, `slug`, `device_id`, `registration_type`, `facebook_social_id`, `google_social_id`, `phone_number`, `dob`, `otp`, `is_notification`, `is_location`, `is_verified`, `is_approved`, `device_token`, `device_type`, `latitude`, `longitude`, `lang`, `is_deleted`, `is_blocked`, `token`, `is_termcondition_accepted`, `is_medical_prescription`, `zip`, `country`, `state`, `city`, `address`, `street1`, `street2`, `preferred_zip_code`, `availablity`, `created_at`, `updated_at`) VALUES
(2, '0', 123456, 0, 'e10adc3949ba59abbe56e057f20f883e', '', 'ram', 'nivash', '', '', 91, 'ramnivash@techaheadcorp.com', '', '', '1', '123456', NULL, '8750024108', '2016-04-05', 123456, '1', '0', '0', '0', '43234dvdsv5654', '1', '25.3256', '256.2563', '1', '0', '0', 'xcdsdsfdsfdsfdsfds342423vcv', '0', '0', 0, '', 'Gujrat', 'Gandhi Nagar', 'Saffron Colony', 'street', 'street2', NULL, '0', '2017-08-31 18:30:00', '0000-00-00 00:00:00'),
(9, '0', 9453726, 2, 'e10adc3949ba59abbe56e057f20f883e', '', 'Ankit', 'Chavhan', '', '1', NULL, 'ram11111@techaheadcorp.com', '', '', '2', '123456789', NULL, NULL, '1987-12-09', NULL, '1', '0', '0', '0', '3432423432gfdgdgf1', '1', NULL, NULL, '1', '0', '0', '', '1', '1', 0, '', 'delhi', 'delhi', 'new ashok nagar', '', '', 12345679, '0', '2017-09-07 06:54:11', '0000-00-00 00:00:00'),
(12, '0', 524776, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Ramesh', 'Chandra', 'https://s3-us-west-2.amazonaws.com/athbucket/FCECDAF7-4045-46F2-A9B0-30FABC15F369-3848-000003850AA8C47D.png', '1', NULL, 'test11@gmail.com', '', '', '1', NULL, NULL, '1234567890', '2014-09-27', NULL, '0', '1', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'Maharashtra', 'Mumbai', 'Puranpur Uttar Pradesh 262302', '', '', NULL, '1', '2017-09-13 12:32:41', '0000-00-00 00:00:00'),
(13, '0', 476529, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Mukesh', 'Gautam', '', '1', NULL, 'ew@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', 'fzThz1NhQEk:APA91bFoyAdOfY17YnM79KsInTQkb9y1jzy3CHlMZT5drLWSby8C-0lcARDPsTOMgktd3VEr11Js0HcqkfUUCVOYRLYgIUYnmAt20PTSC1cyZSBLauXtv3oUXVaaXFwUo_kEMomlb_X1', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-13 12:55:32', '0000-00-00 00:00:00'),
(21, '0', 878034, NULL, NULL, '', 'Demo', 'memo', '', '1', NULL, NULL, '', '16', '1', NULL, NULL, '48797966565', NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-14 13:21:24', '0000-00-00 00:00:00'),
(85, '1', 773917, 2, 'e10adc3949ba59abbe56e057f20f883e', '', 'Surajj', 'Gupta', 'http://instacraft1.s3.amazonaws.com//96f486a701a402d0e083d4c588a6e54439_1515065936.jpg', '1', NULL, 'tedfdddddfccrttst@gmail.com', '', 'E16949D3-0B2B-41FC-B610-E7A0A3B33E27-6931-000016947EB2A767', '1', NULL, NULL, '88899665585', '2017-08-15', NULL, '1', '0', '0', '0', '1234567', '1', NULL, NULL, '1', '0', '1', NULL, '1', '1', 0, '', 'Uttar Pradesh', 'Lucknow', 'Lalganj', 'asd', 'asd', NULL, '0', '2017-09-14 13:24:57', '0000-00-00 00:00:00'),
(106, '0', 854597, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', NULL, NULL, '', '1', NULL, 'tt@gmail.com', '', '', '1', NULL, NULL, '89898989898', NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 12:38:19', '0000-00-00 00:00:00'),
(107, '0', 709912, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'dsvfdg@dfgv.jhj', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 12:41:40', '0000-00-00 00:00:00'),
(108, '0', 393102, NULL, '987d7883e45bf020e9e910d0e8350118', '', NULL, NULL, '', '1', NULL, 'gdfgdfg@rftgd.ghj', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 12:57:48', '0000-00-00 00:00:00'),
(109, '0', 967133, 2, 'ad544b488234f215da0463e21c92f038', '', NULL, NULL, '', '1', NULL, 'gdfgf@werf.ghj', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 13:01:38', '0000-00-00 00:00:00'),
(110, '0', 860495, 2, 'e10adc3949ba59abbe56e057f20f883e', '', 'JD', 'Keshari', '', '1', NULL, 'test1@gmail.com', '', '', '1', NULL, NULL, NULL, '2014-09-27', NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'UP', 'Noida', 'ABES', '', '', NULL, '0', '2017-09-26 13:08:22', '0000-00-00 00:00:00'),
(111, '0', 682438, 2, 'ed6a068e5fb0718932c4d3e39eaabbeb', '', NULL, NULL, '', '1', NULL, '234f@dfgd.ghj', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 13:17:48', '0000-00-00 00:00:00'),
(112, '0', 533027, NULL, NULL, '', NULL, NULL, '', '1', NULL, 'tedfdddffdddddddddddfccrttst@gmail.com', '', '', '2', 'sdasdasdasd', NULL, NULL, NULL, NULL, '1', '0', '0', '0', '1234567', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 13:22:32', '0000-00-00 00:00:00'),
(113, '0', 536074, NULL, NULL, '', NULL, NULL, '', '1', NULL, 'tedfdddffdderrdddddddddfccrttst@gmail.com', '', '', '2', 'sdasdaerwsdasd', NULL, NULL, NULL, NULL, '1', '0', '0', '0', '1234567', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 13:28:53', '0000-00-00 00:00:00'),
(114, '0', 529784, NULL, NULL, '', NULL, NULL, '', '1', NULL, 'iosdev1@techaheadcorp.com', '', '', '2', '1703595769935942', NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 13:30:30', '0000-00-00 00:00:00'),
(115, '0', 102145, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', NULL, NULL, '', '1', NULL, 'taravb@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 13:31:34', '0000-00-00 00:00:00'),
(116, '0', 899547, 2, 'bdc297c1209122c27894011c59c560f2', '', NULL, NULL, '', '1', NULL, 'dsfgd@dfgd.ftg', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 14:04:27', '0000-00-00 00:00:00'),
(117, '0', 681447, 2, '1bb6d9df05917877e33a28dfdaed76da', '', NULL, NULL, '', '1', NULL, 'fgdfg@sdf.fgh', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-26 14:07:01', '0000-00-00 00:00:00'),
(118, '0', 254277, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'vipin', 'keshari', '', '1', NULL, 'tara@gmail.com', '', '', '1', NULL, NULL, '9876543210', '2017-10-06', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'sdfsd', 'sdf', 'Noida', 'dsf', 'dsf', NULL, '0', '2017-09-27 04:48:10', '0000-00-00 00:00:00'),
(119, '0', 915434, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', NULL, NULL, '', '1', NULL, 'taraq@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-27 05:20:09', '0000-00-00 00:00:00'),
(120, '0', 316331, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', NULL, NULL, '', '1', NULL, 'yui@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-27 05:46:04', '0000-00-00 00:00:00'),
(121, '0', 806573, NULL, NULL, '', NULL, NULL, '', '1', NULL, 'raghavnty@gmail.com', '', '', '2', '1601617923229796', NULL, NULL, NULL, NULL, '1', '0', '0', '0', 'eQYEqnAvgDI:APA91bF84n3e0WYmTpoeSFuWNSW04u7xXCR6eRZX3lRjkaIeAO73FFPhj2azyfqmidi8ihYgp6z0AyTKoNM7fsBrCwaOVwuYBvXMejgcQ-SfjeUc5g6O6EJgwfbycRyyOQqufVo8E-BK', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 123, '0', '2017-09-27 07:51:42', '0000-00-00 00:00:00'),
(122, '0', 920920, NULL, '25d55ad283aa400af464c76d713c07ad', '', NULL, NULL, '', '1', NULL, 'a1@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-27 07:52:59', '0000-00-00 00:00:00'),
(123, '1', NULL, NULL, 'a8ae90c02ad3a603f7a71a53baea73a0', '', 'Suraj', 'Gupta', 'http://instacraft1.s3.amazonaws.com/driver/pics/2017-01-101484025281male77_1506500188.png', '1', NULL, 'tedfdddddfccrttst@gmail.com', '', '', '1', NULL, NULL, '88899665585', NULL, NULL, '0', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '1', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-27 08:16:30', '0000-00-00 00:00:00'),
(124, '0', 173223, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Testaa', 'New', '', '1', NULL, 'testaa@gmail.com', '', '', '1', NULL, NULL, NULL, '2012-09-27', NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'UP', 'Noida', 'Noida', '', '', NULL, '0', '2017-09-27 09:14:52', '0000-00-00 00:00:00'),
(125, '0', 879810, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'bvcb', 'cvbcvb', '', '1', NULL, 'testa1@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-06-27', NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'cvbc', 'cvb', 'xcvxc', '', '', NULL, '0', '2017-09-27 09:58:59', '0000-00-00 00:00:00'),
(126, '0', 413835, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'testa11@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-27 12:18:10', '0000-00-00 00:00:00'),
(127, '0', 556713, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', NULL, NULL, '', '1', NULL, 'trap@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-27 13:15:43', '0000-00-00 00:00:00'),
(128, '0', 563156, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'test@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 121323, '0', '2017-09-27 13:21:51', '0000-00-00 00:00:00'),
(129, '0', 895050, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', 'vjjc', 'hxjcjc', '', '1', NULL, 'ty@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-09-27', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'xhxhx', 'xhxu', 'hddu', 'hxjc', 'jcjc', NULL, '0', '2017-09-27 13:28:23', '0000-00-00 00:00:00'),
(130, '0', 670849, NULL, '8dc7a9af7e1e88d8b31bb33be4d06525', '', 'fjfjf', 'jfjfj', '', '1', NULL, 'jff@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-09-27', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'cufu', 'hxhxh', 'jdh', 'jcjc', 'hdhc', NULL, '0', '2017-09-27 13:41:27', '0000-00-00 00:00:00'),
(131, '0', 775086, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', 'ufufu', 'kvjc', '', '1', NULL, 'cjfj@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-09-27', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'jcj', 'cjcj', 'vjvk', 'hxcu', 'jcjc', NULL, '0', '2017-09-27 14:06:02', '0000-00-00 00:00:00'),
(132, '0', 990654, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'xbx@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-27 14:08:25', '0000-00-00 00:00:00'),
(133, '0', 845632, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', NULL, NULL, '', '1', NULL, 'cjcu@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-27 14:14:55', '0000-00-00 00:00:00'),
(134, '0', 69016, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'my@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-28 05:25:48', '0000-00-00 00:00:00'),
(135, '0', 790425, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'my1@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-28 05:26:52', '0000-00-00 00:00:00'),
(136, '0', 462125, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'my2@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-28 05:30:54', '0000-00-00 00:00:00'),
(137, '0', 615429, 2, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'tyu@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-28 06:39:38', '0000-00-00 00:00:00'),
(138, '1', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Ankit', 'Chavhan', 'http://instacraft1.s3.amazonaws.com/profile/1506607065imgpsh_fullsize (2).png', '1', NULL, 'ankit.chavhan@techaheadcorp.com', '', '', '1', NULL, NULL, '9827292977', '1989-04-05', NULL, '1', '0', '1', '1', NULL, '0', NULL, NULL, '1', '0', '1', NULL, '0', '0', 0, '', '', '', '1234', '', '', NULL, '0', '2017-09-28 12:35:20', '0000-00-00 00:00:00'),
(139, '0', 777040, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'test12@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-28 13:31:49', '0000-00-00 00:00:00'),
(140, '0', 302607, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'test112@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-28 13:34:51', '0000-00-00 00:00:00'),
(141, '0', 945482, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'test121@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-28 13:36:38', '0000-00-00 00:00:00'),
(142, '0', 100532, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'test13@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-28 13:39:51', '0000-00-00 00:00:00'),
(143, '0', 132543, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'test131@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-09-28 13:55:44', '0000-00-00 00:00:00'),
(144, '0', 315453, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Shashank', 'Gupta', 'https://s3-us-west-2.amazonaws.com/athbucket/F6C95835-D135-4B0F-84E5-CB157247ECD5-2828-00000459FC7ABB6C.png', '1', NULL, 'shashank@techaheadcorp.com', '', '', '1', NULL, NULL, '9654701931', '1990-10-07', NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', 'Dadri Road Uttar Pradesh 201304', '', '', NULL, '0', '2017-09-29 06:03:13', '0000-00-00 00:00:00'),
(145, '0', 782324, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'rakesh', 'sharma', '', '1', NULL, 'yuv@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-10-03', NULL, '1', '0', '0', '0', 'cjFIQPTOa1Q:APA91bFXTrek2fBf-RwMvFc33yVmAAfFYnWZiSFpiBGFMbpdNk941uTCU5Pb8Vy06y0tbukE7A73IFt-hs_ltUQJ-fYfGWIsGEDpdwMpFQELZ2HFcwhJA5xGfOfQlVQkQy0NURYvOF43', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'asd', 'asd', 'asda', 'sdfsad', 'asd', 123456, '0', '2017-10-03 05:39:19', '0000-00-00 00:00:00'),
(146, '0', 765361, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'next@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-03 06:25:54', '0000-00-00 00:00:00'),
(147, '0', 947759, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'trey@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-03 06:47:06', '0000-00-00 00:00:00'),
(148, '0', 616081, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'yuo@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 123456, '0', '2017-10-03 06:48:56', '0000-00-00 00:00:00'),
(149, '0', 528023, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'sadfsa', 'asdsa', '', '1', NULL, 'tty@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-10-03', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'asd', 'asd', 'asd', 'asd', 'sad', 123456, '0', '2017-10-03 07:04:49', '0000-00-00 00:00:00'),
(150, '0', 828101, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'dfgfd', 'dfgfd', '', '1', NULL, 'uihjJ@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-10-02', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'dfgdfg', 'fdgfdg', 'dfg', 'dfg', 'dfg', 123456, '0', '2017-10-03 07:08:02', '0000-00-00 00:00:00'),
(151, '0', 273358, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'raka@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', 'd21y7Tlftp0:APA91bHgtX9CDO9TaSBNavsMaev7RPVMQguR9zi5NbCeyoTsRP0nrVICK_CmTcmP39-7Md7pJvf7mQ8EUeD01s_A6YJj7777TZljJL9Ecirz75oCByVtFS2ilSPp7qK0-yjs4JQIAMLd', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 123456, '0', '2017-10-03 07:37:13', '0000-00-00 00:00:00'),
(152, '0', 401097, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'koka@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-03 08:04:35', '0000-00-00 00:00:00'),
(153, '0', 346916, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'kiransa@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 123456, '0', '2017-10-03 08:05:16', '0000-00-00 00:00:00'),
(154, '0', 115068, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'gana@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 123456, '0', '2017-10-03 09:53:59', '0000-00-00 00:00:00'),
(155, '0', 131102, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'dsad', 'sadasdsadsd', '', '1', NULL, 'fg@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-10-03', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'asd', 'sd', 'asd', 'sad', 'asd', 123456, '0', '2017-10-03 10:08:52', '0000-00-00 00:00:00'),
(156, '0', 39787, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'rasds', 'asdasd', '', '1', NULL, 'tty67@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-09-30', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'asda', 'sdasd', 'asd', 'asd', 'sad', NULL, '0', '2017-10-03 10:54:32', '0000-00-00 00:00:00'),
(157, '0', 493807, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'rakesh', 'SHARMA', '', '1', NULL, 'test123@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-10-03', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'sdfsdf', 'dsf', 'sdf', 'SFDSsd', 'dsfsd', 123456, '0', '2017-10-03 12:53:21', '0000-00-00 00:00:00'),
(158, '0', 239969, NULL, '25d55ad283aa400af464c76d713c07ad', '', 'Rahul ', 'Sharma ', '', '1', NULL, 'loremipsul@gmail.com', '', '', '1', NULL, NULL, NULL, '2015-10-03', NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'up', 'noida', 'gbbnb', 'rhdndn', 'Berne', 12345, '0', '2017-10-03 12:56:15', '0000-00-00 00:00:00'),
(159, '0', 584929, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'tar@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 0, '0', '2017-10-03 13:52:02', '0000-00-00 00:00:00'),
(160, '0', 961811, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'fsfsd', 'sdfsd', '', '1', NULL, 'testaa1@gmail.com', '', '', '1', NULL, NULL, NULL, '2013-10-03', NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'sdfsdf', 'sdfsd', 'sdfssdfs', 'a', '', NULL, '0', '2017-10-03 15:13:35', '0000-00-00 00:00:00'),
(161, '0', 159534, NULL, NULL, '', NULL, NULL, '', '1', NULL, 'sharrmarahul@rediffmail.com', '', '', '2', '10155803960924851', NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-03 15:40:56', '0000-00-00 00:00:00'),
(162, '0', 954242, NULL, 'caf3d3f598a9decaf2d9501e5b351e0c', '', NULL, NULL, '', '1', NULL, 'ayush@techaheadcorp.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 12452, '0', '2017-10-03 15:59:04', '0000-00-00 00:00:00'),
(163, '0', 486467, NULL, NULL, '', NULL, NULL, '', '1', NULL, 'ayush.a.k.a.spartan117@gmail.com', '', '', '2', '1646967048659998', NULL, NULL, NULL, NULL, '1', '0', '0', '0', 'e3O7VNFuX3s:APA91bGsUzwd41IslbrM7vLE_BWYlUGvFCSYousHch6SEhQ5XmZQjMedMCDao1kAEF-258n3rDorbPmyV7tNx12YKEIOHRyMl7z5fUfG141sMFjJ0Gll5TASJzOkn9jVeveMkBgiQ-Rf', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 12345, '0', '2017-10-03 16:08:05', '0000-00-00 00:00:00'),
(164, '0', 723360, NULL, 'b617e6644d6f82ffef6b1e2b73b0a294', '63894abe9dab975bc949c4dfe4a6d0be', NULL, NULL, '', '1', NULL, 'fhassan1776@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-03 16:46:26', '0000-00-00 00:00:00'),
(165, '0', 566052, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'bcv@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 0, '0', '2017-10-04 05:37:40', '0000-00-00 00:00:00'),
(166, '0', 855324, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'gggggg@ggg.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 0, '0', '2017-10-04 05:38:20', '0000-00-00 00:00:00'),
(167, '0', 302899, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'vipin', 'kumar', 'https://instacraft1.s3.amazonaws.com/20171012_183342.jpg', '1', NULL, 'vipin@techaheadcorp.com', '', '', '1', NULL, NULL, '987654321', '2017-10-05', NULL, '1', '1', '0', '0', 'dQbCscEdAo0:APA91bFJPcmYWWAJh92VQUinnRUmmpYDavV8Fi4JECk8qIl82bNriaeD2cL5BG3sGpuMrRoIEq8PTVUA-hqgMnF_LRKYlG9IW2pD0z2PXFkqMDjhj86RNr0tzfkT4geI9ZDxaFHQdqHL', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', 'Noida', '', '', 0, '0', '2017-10-04 05:43:23', '0000-00-00 00:00:00'),
(168, '0', 599865, NULL, 'e807f1fcf82d132f9bb018ca6738a19f', '', NULL, NULL, '', '1', NULL, 'afa@gnagu.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 12345, '0', '2017-10-04 05:53:09', '0000-00-00 00:00:00'),
(169, '0', 506259, NULL, 'b617e6644d6f82ffef6b1e2b73b0a294', '', 'farris', 'Hassan', '', '1', NULL, 'farris.aurelius@gmail.com', '', '', '1', NULL, NULL, NULL, '1989-07-30', NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'Maine', 'South Thomaston', 'an ', '20 Country Lane', 'Unit 1', 4858, '0', '2017-10-04 06:31:04', '0000-00-00 00:00:00'),
(170, '0', 523316, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'tyiuh@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 123, '0', '2017-10-04 07:04:21', '0000-00-00 00:00:00'),
(171, '0', 603801, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'sdfd@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 123456, '0', '2017-10-04 07:12:42', '0000-00-00 00:00:00'),
(172, '0', 233515, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'sadas@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 13213, '0', '2017-10-04 07:27:44', '0000-00-00 00:00:00'),
(173, '0', 330052, NULL, '633bd287609b5b5854509b614ef5bee0', '', NULL, NULL, '', '1', NULL, 'dfsdf@dfgdf.ghj', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-04 08:44:47', '0000-00-00 00:00:00'),
(174, '0', 680362, NULL, '70d53ac3041f372ef644b24645cfd4e2', '', NULL, NULL, '', '1', NULL, 'dfgdg@fdgdf.fgh', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-04 09:53:49', '0000-00-00 00:00:00'),
(175, '0', 451056, NULL, NULL, '', NULL, NULL, '', '1', NULL, 'joseph.chacko@techaheadcorp.com', '', '', '2', '280095572508917', NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-04 10:10:20', '0000-00-00 00:00:00'),
(176, '0', 642405, NULL, 'd58e3582afa99040e27b92b13c8f2280', '', NULL, NULL, '', '1', NULL, 'fgdfg@sdf.fdg', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 21312, '0', '2017-10-04 11:06:36', '0000-00-00 00:00:00'),
(177, '0', 409356, NULL, '7719a45071bf6c2fe634a5ce0ee27e79', '', NULL, NULL, '', '1', NULL, 'dfsdf@fgdf.fgh', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-04 11:57:05', '0000-00-00 00:00:00'),
(178, '0', 650133, 175, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', NULL, NULL, '', '1', NULL, 'yy@mailinator.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-04 12:00:28', '0000-00-00 00:00:00'),
(179, '0', 525674, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'sdsds@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 13132, '0', '2017-10-04 12:52:14', '0000-00-00 00:00:00'),
(180, '0', 787732, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'sadfasd@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-04 12:54:17', '0000-00-00 00:00:00'),
(181, '0', 179028, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'rahulsharma@abc.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 201002, '0', '2017-10-04 13:40:15', '0000-00-00 00:00:00'),
(182, '0', 944120, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'arun@mailinator.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 0, '0', '2017-10-04 15:20:58', '0000-00-00 00:00:00'),
(183, '0', 861257, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', NULL, NULL, '', '1', NULL, 'arunv@mailinator.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 12, '0', '2017-10-04 15:23:36', '0000-00-00 00:00:00'),
(184, '0', 111011, NULL, '96e79218965eb72c92a549dd5a330112', '', NULL, NULL, '', '1', NULL, 'test12@test.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 95014, '0', '2017-10-04 23:21:11', '0000-00-00 00:00:00'),
(185, '0', 907381, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'qwe@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', 123456, '0', '2017-10-05 09:18:30', '0000-00-00 00:00:00'),
(186, '0', 349855, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'xnfn', 'xbxn', '', '1', NULL, 'guvu@gmail.com', '', '', '1', NULL, NULL, NULL, '2017-10-05', NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '1', 0, '', 'zbsbd', 'vbs', 'zvsv', 'xndb', 'vsb', 0, '0', '2017-10-05 09:21:41', '0000-00-00 00:00:00'),
(187, '0', 306363, NULL, '8c7e21d8b66f7d92642b5850900ed44f', '', NULL, NULL, '', '1', NULL, 'hgfgh@gfcgf.jhg', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-05 12:43:35', '0000-00-00 00:00:00'),
(188, '0', 108933, NULL, '8bd7aa5adda2e453f31bad61dd2e9549', '', NULL, NULL, '', '1', NULL, 'fgbfg@fgdg.fgj', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-05 13:03:29', '0000-00-00 00:00:00'),
(189, '0', 82476, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'tyu12@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-07 07:31:55', '0000-00-00 00:00:00'),
(190, '0', 851322, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'uio@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-07 07:47:01', '0000-00-00 00:00:00'),
(191, '0', 183498, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'sdfsd12324@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-07 07:50:22', '0000-00-00 00:00:00'),
(192, '0', 795703, NULL, '25d55ad283aa400af464c76d713c07ad', '', NULL, NULL, '', '1', NULL, 'ashihsk@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-10 06:01:37', '0000-00-00 00:00:00'),
(193, '0', 77526, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'ashish@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '', '0', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-10-10 07:59:57', '0000-00-00 00:00:00'),
(209, '0', 309912, NULL, '25d55ad283aa400af464c76d713c07ad', '', 'Rakesh', 'kumar', 'http://instacraft1.s3.amazonaws.com/customer/1513340947sahil1.jpg', '1', NULL, 'rakesh.kumaar@techaheadcorp.com', '42ce1e89', '', '1', NULL, NULL, '1234567890', '2007-12-11', NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-11-18 07:27:24', '2018-01-08 08:48:59'),
(210, '0', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Rakesh', 'kumar', 'http://instacraft1.s3.amazonaws.com/customer/15113341951.jpg', '1', NULL, 'admin@gmaaail.com', '', '', '1', NULL, NULL, '234335435435', '2017-11-22', NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-11-22 07:03:19', NULL),
(211, '0', NULL, NULL, NULL, '', 'Sachin', 'Saxena', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p50x50/12923340_1691794921093481_4562059566952583601_n.jpg?oh=a62c6d3e3ec5a3a64ac61ca681402d2d&oe=5A8A3B64', '', NULL, 'sachin@techaheadcorp.com', 'sachint', '', '1', '1957939541145683', NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-01 07:10:41', NULL),
(212, '0', 756885, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'sharrmarahul123@gmail.com', '233b0e5e', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-15 13:06:57', NULL),
(213, '0', NULL, NULL, NULL, '', 'Ravindra', 'Singh', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p50x50/18119326_1351967098219122_5441987778110723533_n.jpg?oh=83bda86eae8291189bb8acccd67643e0&oe=5AC8FCEA', '', NULL, 'rs636304@gmail.com', 'rs636304', '', '1', '1568098209939342', NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-15 14:52:39', NULL),
(214, '1', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Rakaa', 'kumar', 'http://instacraft1.s3.amazonaws.com/profile/1514898116IMG_0108.PNG', '1', NULL, 'rakesh.kumar@techaheadcorp.com', '', '', '1', NULL, NULL, '1234567890', NULL, NULL, '0', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', 'sector 62 noida', '', '', NULL, '1', '2017-12-15 15:19:11', NULL),
(215, '0', 412559, NULL, 'fcea920f7412b5da7be0cf42b8c93759', '', NULL, NULL, '', '1', NULL, 'tesst@gmail.com', 'f497b2f0', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-15 15:24:53', NULL),
(216, '0', 497044, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Rahul ', 'Sharma', '', '1', NULL, 'rahulsharma413@techaheadcorp.com', 'aa525e89', '', '1', NULL, NULL, '9876543212', '2017-12-27', NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-21 10:20:38', '2017-12-26 14:48:13'),
(217, '0', 532635, NULL, '2bd910ad677c6700ebf85d58daf4ab50', 'b6f0eeccc9051368f562fc983f7c94b1', NULL, NULL, '', '1', NULL, 'farris@farrisfund.com', 'eb0961fa', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-22 16:53:35', NULL),
(218, '0', 668799, NULL, 'ebfadbfc28b0cb7b82d2ca0005aca1e2', '', NULL, NULL, '', '1', NULL, 'Farris@getinstacraft.com', 'bff50da7', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-22 16:54:24', NULL),
(219, '0', 160670, NULL, '6eea9b7ef19179a06954edd0f6c05ceb', '', NULL, NULL, '', '1', NULL, 'abc@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-28 06:32:59', NULL),
(220, '0', 165409, NULL, '6eea9b7ef19179a06954edd0f6c05ceb', '', NULL, NULL, '', '1', NULL, 'abcd@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-29 09:35:06', NULL),
(221, '0', 719984, NULL, '6eea9b7ef19179a06954edd0f6c05ceb', '', NULL, NULL, '', '1', NULL, 'a@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-29 09:42:46', NULL),
(222, '0', 2208, NULL, '6eea9b7ef19179a06954edd0f6c05ceb', '', NULL, NULL, '', '1', NULL, 'b@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-29 09:47:01', NULL),
(223, '0', 630856, NULL, '6eea9b7ef19179a06954edd0f6c05ceb', '', NULL, NULL, '', '1', NULL, 'c@sbxmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-29 09:50:15', NULL),
(224, '0', 986205, NULL, '6eea9b7ef19179a06954edd0f6c05ceb', '', NULL, NULL, '', '1', NULL, 'd@gmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-29 09:52:43', NULL),
(225, '0', 705573, NULL, '6eea9b7ef19179a06954edd0f6c05ceb', '', NULL, NULL, '', '1', NULL, 'd@sbxmail.com', '', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', '123467', '1', NULL, NULL, '1', '0', '0', NULL, '1', '0', 0, '', '', '', '', '', '', NULL, '0', '2017-12-29 10:54:08', NULL),
(226, '0', 636987, NULL, '3fc0a7acf087f549ac2b266baf94b8b1', 'c70660b70f3cc0d3dfa32a2519714b06', NULL, NULL, '', '1', NULL, 'jyoti.taneja@techaheadcorp.com', 'fb624c98', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2018-01-02 12:34:10', NULL),
(227, '0', 130077, NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', '', NULL, NULL, '', '1', NULL, 'jyotitaneja111@gmail.com', 'cbdfbae0', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2018-01-02 14:18:52', NULL),
(228, '0', 316352, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Priya', 'Barnwal', 'http://instacraft1.s3.amazonaws.com/customer/151497383096f486a701a402d0e083d4c588a6e544.jpg', '2', NULL, 'priya@tech.com', '3f04ea52', '', '1', NULL, NULL, '9988776655443', '2018-01-05', NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2018-01-03 04:57:20', '2018-01-03 10:03:51'),
(229, '0', 893025, NULL, 'd5c8002f1808b78be929b2e189eb689a', '', NULL, NULL, '', '1', NULL, 'mitanshi@techaheadcorp.com', '76ba9838', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2018-01-03 14:02:23', NULL),
(230, '0', 833310, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, '', '1', NULL, 'admin@gmail.com', 'a9f87553', '', '1', NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2018-01-04 05:04:27', NULL),
(231, '1', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', '', 'Priya', 'Barnwal', 'http://instacraft1.s3.amazonaws.com//96f486a701a402d0e083d4c588a6e54477_1515066207.jpg', '1', NULL, 'priya@techahead.com', '', '', '1', NULL, NULL, '1234567890', NULL, NULL, '0', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2018-01-04 11:43:29', NULL),
(232, '0', NULL, NULL, '202cb962ac59075b964b07152d234b70', '', 'Priya', 'Priya', '0', '2', NULL, 'priya.priya@tech.com', '', '', '1', NULL, NULL, '9988776655', '2018-01-06', NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2018-01-04 12:31:14', NULL),
(233, '0', NULL, NULL, '7694f4a66316e53c8cdd9d9954bd611d', '', 'a', 'b', '0', '1', NULL, 'a', '', '', '1', NULL, NULL, 'a', '2018-01-04', NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2018-01-04 12:33:40', NULL),
(234, '0', NULL, NULL, 'fbade9e36a3f36d3d676c1b808451dd7', '', 'x', 'y', '0', '1', NULL, 'x', '', '', '1', NULL, NULL, 'y', '2018-01-04', NULL, '1', '0', '0', '0', NULL, '0', NULL, NULL, '1', '0', '0', NULL, '0', '0', 0, '', '', '', '', '', '', NULL, '0', '2018-01-04 12:36:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_consultation_request`
--

CREATE TABLE `user_consultation_request` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `consultation_type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_contact_share_list`
--

CREATE TABLE `user_contact_share_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `share_type` enum('0') NOT NULL COMMENT '0=>app share',
  `to_name` varchar(255) NOT NULL,
  `to_mobile` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_contact_share_list`
--

INSERT INTO `user_contact_share_list` (`id`, `user_id`, `share_type`, `to_name`, `to_mobile`, `created_at`, `updated_at`) VALUES
(1, 1, '0', 'Ankit', '+918750024108', '2017-09-10 18:30:00', '0000-00-00 00:00:00'),
(2, 2, '0', 'ram', '8750024108', '2017-09-11 07:20:03', '0000-00-00 00:00:00'),
(3, 2, '0', 'manoj', '8750024109', '2017-09-11 07:20:03', '0000-00-00 00:00:00'),
(4, 2, '0', 'ram', '+918750024108', '2017-09-11 07:30:37', '0000-00-00 00:00:00'),
(5, 2, '0', 'ram', '+918750024108', '2017-09-11 07:31:18', '0000-00-00 00:00:00'),
(6, 2, '0', 'ram', '+918750024108', '2017-09-11 07:31:45', '0000-00-00 00:00:00'),
(7, 2, '0', 'ram', '+918800383755', '2017-09-11 07:41:34', '0000-00-00 00:00:00'),
(8, 157, '0', 'meena', '456456456', '2017-10-03 12:53:42', '0000-00-00 00:00:00'),
(9, 157, '0', 'meelu', '654654654', '2017-10-03 12:53:42', '0000-00-00 00:00:00'),
(10, 161, '0', 'Techahead Ayush', '+918285943330', '2017-10-03 15:41:31', '0000-00-00 00:00:00'),
(11, 161, '0', 'Techahead Ayush', '+918285943330', '2017-10-03 15:41:34', '0000-00-00 00:00:00'),
(12, 164, '0', 'Ali Abbas', '(407) 782-7744', '2017-10-03 16:53:58', '0000-00-00 00:00:00'),
(13, 164, '0', 'Abby', '1 (617) 852-9203', '2017-10-03 16:53:58', '0000-00-00 00:00:00'),
(14, 164, '0', 'Hayder Abdul-Razzak', '(361) 549-4871', '2017-10-03 16:53:58', '0000-00-00 00:00:00'),
(15, 164, '0', 'Huda Abdul-Razzak', '(361) 739-8959', '2017-10-03 16:53:58', '0000-00-00 00:00:00'),
(16, 164, '0', 'Adil', '(571) 265-1693', '2017-10-03 16:53:58', '0000-00-00 00:00:00'),
(17, 164, '0', 'Thea Ahl', '4915787385550', '2017-10-03 16:53:58', '0000-00-00 00:00:00'),
(18, 164, '0', 'Neda Ahmad\'s Wife', '+1 (313) 980-0048', '2017-10-03 16:53:58', '0000-00-00 00:00:00'),
(19, 164, '0', 'Tyler Deken', '(207) 239-0042', '2017-10-03 16:59:23', '0000-00-00 00:00:00'),
(20, 2, '0', 'ram', '+918750024108', '2017-10-04 04:56:27', '0000-00-00 00:00:00'),
(21, 161, '0', 'ram', '+918750024108', '2017-10-04 04:58:43', '0000-00-00 00:00:00'),
(22, 161, '0', 'TA JD', '95606 24625', '2017-10-04 06:38:43', '0000-00-00 00:00:00'),
(23, 161, '0', 'TA JD', '+91 95606 24625', '2017-10-04 06:41:03', '0000-00-00 00:00:00'),
(24, 161, '0', 'TA JD', '+91 95606 24625', '2017-10-04 06:44:47', '0000-00-00 00:00:00'),
(25, 161, '0', 'TA JD', '+91 95606 24625', '2017-10-04 06:45:03', '0000-00-00 00:00:00'),
(26, 161, '0', 'TA JD', '+91 90151 25625', '2017-10-04 06:56:13', '0000-00-00 00:00:00'),
(27, 171, '0', 'meena', '456456456', '2017-10-04 07:16:39', '0000-00-00 00:00:00'),
(28, 160, '0', 'John Appleseed', '888-555-5512', '2017-10-04 10:42:03', '0000-00-00 00:00:00'),
(29, 160, '0', 'John Appleseed', '888-555-5512', '2017-10-04 10:45:36', '0000-00-00 00:00:00'),
(30, 160, '0', 'John Appleseed', '888-555-5512', '2017-10-04 10:45:46', '0000-00-00 00:00:00'),
(31, 185, '0', 'Xperia Helpline', '18001037799', '2017-10-05 09:18:46', '0000-00-00 00:00:00'),
(32, 185, '0', 'Ashu', '918800846228', '2017-10-05 09:18:46', '0000-00-00 00:00:00'),
(33, 191, '0', 'meena', '456456456', '2017-10-07 07:58:42', '0000-00-00 00:00:00'),
(34, 219, '0', 'Kate Bell', '(555) 564-8583', '2017-12-28 06:33:28', '0000-00-00 00:00:00'),
(35, 219, '0', 'Kate Bell', '(415) 555-3695', '2017-12-28 06:33:28', '0000-00-00 00:00:00'),
(36, 219, '0', 'Daniel Higgins Jr.', '555-478-7672', '2017-12-28 06:33:28', '0000-00-00 00:00:00'),
(37, 219, '0', 'Daniel Higgins Jr.', '(408) 555-5270', '2017-12-28 06:33:28', '0000-00-00 00:00:00'),
(38, 219, '0', 'John Appleseed', '888-555-5512', '2017-12-28 06:33:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_coupons`
--

CREATE TABLE `user_coupons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `coupon_code` varchar(45) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `expiry` datetime DEFAULT NULL,
  `redeemed_on` datetime DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `discount_in_percent` int(11) DEFAULT NULL,
  `is_redeemed` enum('Y','N') DEFAULT 'N',
  `received_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_coupons`
--

INSERT INTO `user_coupons` (`id`, `user_id`, `coupon_code`, `coupon_id`, `expiry`, `redeemed_on`, `points`, `discount_in_percent`, `is_redeemed`, `received_on`) VALUES
(1, 231, 'BOOM5', 1, '2018-04-04 00:00:00', NULL, NULL, 30, 'N', NULL),
(2, 231, 'BOOM5', 1, '2018-04-04 00:00:00', NULL, NULL, 30, 'N', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_points`
--

CREATE TABLE `user_points` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `point_source` enum('0','1','2','3') NOT NULL COMMENT '0=>Share on Facebook,1=>Share on Twitter,2=>Share on Instagram,3=>by refferal code',
  `transaction_type` enum('1','2') NOT NULL COMMENT '1=>credit,2=>debit',
  `point` double NOT NULL,
  `total_point` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_points`
--

INSERT INTO `user_points` (`id`, `user_id`, `point_source`, `transaction_type`, `point`, `total_point`, `created_at`, `updated_at`) VALUES
(1, 209, '0', '1', 100, 100, '2017-09-05 18:30:00', '0000-00-00 00:00:00'),
(2, 209, '0', '1', 100, 200, '2017-09-06 08:46:05', '0000-00-00 00:00:00'),
(3, 1, '0', '2', 100, 100, '2017-09-05 18:30:00', '0000-00-00 00:00:00'),
(45, 2, '3', '1', 100, 100, '2017-09-08 13:06:19', '0000-00-00 00:00:00'),
(46, 2, '3', '1', 100, 200, '2017-09-08 13:07:50', '0000-00-00 00:00:00'),
(47, 9, '3', '1', 100, 100, '2017-09-08 13:08:22', '0000-00-00 00:00:00'),
(48, 12, '0', '1', 100, 100, '2017-09-13 13:45:30', '0000-00-00 00:00:00'),
(49, 12, '1', '1', 100, 200, '2017-09-13 13:45:41', '0000-00-00 00:00:00'),
(50, 12, '2', '1', 100, 300, '2017-09-13 13:45:44', '0000-00-00 00:00:00'),
(51, 2, '3', '1', 100, 300, '2017-09-14 13:59:24', '0000-00-00 00:00:00'),
(52, 33, '2', '1', 100, 100, '2017-09-21 11:11:09', '0000-00-00 00:00:00'),
(53, 33, '0', '1', 100, 200, '2017-09-21 11:38:56', '0000-00-00 00:00:00'),
(54, 17, '0', '1', 100, 100, '2017-09-21 12:29:50', '0000-00-00 00:00:00'),
(55, 17, '2', '1', 100, 200, '2017-09-21 12:30:13', '0000-00-00 00:00:00'),
(56, 55, '2', '1', 100, 100, '2017-09-21 13:28:52', '0000-00-00 00:00:00'),
(57, 63, '2', '1', 100, 100, '2017-09-22 13:50:19', '0000-00-00 00:00:00'),
(58, 64, '0', '1', 100, 100, '2017-09-25 06:26:13', '0000-00-00 00:00:00'),
(59, 64, '2', '1', 100, 200, '2017-09-25 06:26:36', '0000-00-00 00:00:00'),
(60, 64, '1', '1', 100, 300, '2017-09-25 06:27:43', '0000-00-00 00:00:00'),
(61, 84, '2', '1', 100, 100, '2017-09-25 08:49:03', '0000-00-00 00:00:00'),
(62, 100, '0', '1', 100, 100, '2017-09-25 12:57:03', '0000-00-00 00:00:00'),
(63, 101, '0', '1', 100, 100, '2017-09-25 13:21:43', '0000-00-00 00:00:00'),
(64, 2, '3', '1', 100, 400, '2017-09-26 13:01:38', '0000-00-00 00:00:00'),
(65, 2, '3', '1', 100, 500, '2017-09-26 13:08:22', '0000-00-00 00:00:00'),
(66, 2, '3', '1', 100, 600, '2017-09-26 13:17:48', '0000-00-00 00:00:00'),
(67, 2, '3', '1', 100, 700, '2017-09-26 14:04:27', '0000-00-00 00:00:00'),
(68, 2, '3', '1', 100, 800, '2017-09-26 14:07:01', '0000-00-00 00:00:00'),
(69, 125, '0', '1', 100, 100, '2017-09-27 10:00:11', '0000-00-00 00:00:00'),
(70, 2, '3', '1', 100, 900, '2017-09-28 06:39:39', '0000-00-00 00:00:00'),
(71, 158, '2', '1', 100, 100, '2017-10-03 13:14:03', '0000-00-00 00:00:00'),
(72, 118, '0', '1', 100, 100, '2017-10-03 15:36:56', '0000-00-00 00:00:00'),
(73, 161, '2', '1', 100, 100, '2017-10-03 15:48:28', '0000-00-00 00:00:00'),
(74, 161, '1', '1', 100, 200, '2017-10-03 15:49:13', '0000-00-00 00:00:00'),
(75, 161, '0', '1', 100, 300, '2017-10-03 15:49:28', '0000-00-00 00:00:00'),
(76, 162, '0', '1', 100, 100, '2017-10-03 16:00:16', '0000-00-00 00:00:00'),
(77, 162, '1', '1', 100, 200, '2017-10-03 16:01:03', '0000-00-00 00:00:00'),
(78, 163, '0', '1', 100, 100, '2017-10-03 16:09:33', '0000-00-00 00:00:00'),
(79, 162, '2', '1', 100, 300, '2017-10-03 16:16:40', '0000-00-00 00:00:00'),
(80, 164, '1', '1', 100, 100, '2017-10-03 16:56:01', '0000-00-00 00:00:00'),
(81, 169, '2', '1', 100, 100, '2017-10-04 07:09:10', '0000-00-00 00:00:00'),
(82, 175, '0', '1', 100, 100, '2017-10-04 10:11:14', '0000-00-00 00:00:00'),
(83, 118, '1', '1', 100, 200, '2017-10-04 10:19:19', '0000-00-00 00:00:00'),
(84, 175, '2', '1', 100, 200, '2017-10-04 10:38:03', '0000-00-00 00:00:00'),
(85, 118, '2', '1', 100, 300, '2017-10-04 11:11:32', '0000-00-00 00:00:00'),
(86, 175, '3', '1', 100, 300, '2017-10-04 12:00:28', '0000-00-00 00:00:00'),
(87, 178, '0', '1', 100, 100, '2017-10-04 12:05:34', '0000-00-00 00:00:00'),
(88, 181, '0', '1', 100, 100, '2017-10-04 13:43:19', '0000-00-00 00:00:00'),
(89, 121, '2', '1', 100, 100, '2017-10-04 15:04:01', '0000-00-00 00:00:00'),
(90, 180, '2', '1', 100, 100, '2017-10-05 05:40:16', '0000-00-00 00:00:00'),
(91, 185, '2', '1', 100, 100, '2017-10-05 09:19:01', '0000-00-00 00:00:00'),
(92, 193, '3', '1', 100, 100, '2017-11-16 13:01:35', '0000-00-00 00:00:00'),
(93, 192, '3', '1', 100, 100, '2017-11-16 13:02:46', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0=>inactive,1=>active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id`, `name`, `address`, `lat`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Warehouse1', '21 Penobscot St, Orono, ME 04473, USA', '44.88457360', '-68.66045630', '1', '2017-08-28 18:30:00', '2018-01-07 23:07:48'),
(2, 'Warehose2', 'abc,first floar,new delhi', '12.3256', '52.3256', '1', '2017-08-28 18:30:00', '0000-00-00 00:00:00'),
(3, 'Retro Warehouse', 'Demo Address', '12.32442', '52.784321', '0', '2017-10-07 03:49:49', '0000-00-00 00:00:00'),
(4, 'Crashroad Warehouse', 'Sample Address', '12.31122', '52.788421', '1', '2017-10-07 08:14:43', '0000-00-00 00:00:00'),
(5, 'resgt', 'Dadri Main Rd, Sector - 106, Noida, Uttar Pradesh 201304, India', '28.53551610', '77.39102650', '0', '2017-11-21 06:10:38', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `zip_codes`
--

CREATE TABLE `zip_codes` (
  `id` int(11) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zip_codes`
--

INSERT INTO `zip_codes` (`id`, `zip_code`, `created_at`, `updated_at`) VALUES
(4, 3901, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(5, 3902, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(6, 3903, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(7, 3904, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(8, 3905, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(9, 3906, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(10, 3907, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(11, 3908, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(12, 3909, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(13, 3910, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(14, 3911, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(15, 4001, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(16, 4002, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(17, 4003, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(18, 4004, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(19, 4005, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(20, 4006, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(21, 4007, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(22, 4008, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(23, 4009, '2017-09-28 07:35:52', '0000-00-00 00:00:00'),
(24, 4010, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(25, 4011, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(26, 4013, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(27, 4014, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(28, 4015, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(29, 4016, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(30, 4017, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(31, 4019, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(32, 4020, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(33, 4021, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(34, 4022, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(35, 4024, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(36, 4027, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(37, 4028, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(38, 4029, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(39, 4030, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(40, 4032, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(41, 4033, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(42, 4034, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(43, 4037, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(44, 4038, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(45, 4039, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(46, 4040, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(47, 4041, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(48, 4042, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(49, 4043, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(50, 4046, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(51, 4047, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(52, 4048, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(53, 4049, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(54, 4050, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(55, 4051, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(56, 4054, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(57, 4055, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(58, 4056, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(59, 4057, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(60, 4061, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(61, 4062, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(62, 4063, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(63, 4064, '2017-09-28 07:35:53', '0000-00-00 00:00:00'),
(64, 4066, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(65, 4068, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(66, 4069, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(67, 4070, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(68, 4071, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(69, 4072, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(70, 4073, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(71, 4074, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(72, 4075, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(73, 4076, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(74, 4077, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(75, 4078, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(76, 4079, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(77, 4082, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(78, 4083, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(79, 4084, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(80, 4085, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(81, 4086, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(82, 4087, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(83, 4088, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(84, 4090, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(85, 4091, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(86, 4092, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(87, 4093, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(88, 4094, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(89, 4095, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(90, 4096, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(91, 4097, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(92, 4098, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(93, 4101, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(94, 4102, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(95, 4103, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(96, 4104, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(97, 4105, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(98, 4106, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(99, 4107, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(100, 4108, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(101, 4109, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(102, 4110, '2017-09-28 07:35:54', '0000-00-00 00:00:00'),
(103, 4112, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(104, 4116, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(105, 4122, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(106, 4123, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(107, 4124, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(108, 4210, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(109, 4211, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(110, 4212, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(111, 4216, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(112, 4217, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(113, 4219, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(114, 4220, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(115, 4221, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(116, 4222, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(117, 4223, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(118, 4224, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(119, 4225, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(120, 4226, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(121, 4227, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(122, 4228, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(123, 4230, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(124, 4231, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(125, 4234, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(126, 4236, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(127, 4237, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(128, 4238, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(129, 4239, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(130, 4240, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(131, 4241, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(132, 4243, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(133, 4250, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(134, 4252, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(135, 4253, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(136, 4254, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(137, 4255, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(138, 4256, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(139, 4257, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(140, 4258, '2017-09-28 07:35:55', '0000-00-00 00:00:00'),
(141, 4259, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(142, 4260, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(143, 4261, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(144, 4262, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(145, 4263, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(146, 4265, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(147, 4266, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(148, 4267, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(149, 4268, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(150, 4270, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(151, 4271, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(152, 4274, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(153, 4275, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(154, 4276, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(155, 4280, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(156, 4281, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(157, 4282, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(158, 4284, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(159, 4285, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(160, 4286, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(161, 4287, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(162, 4288, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(163, 4289, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(164, 4290, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(165, 4291, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(166, 4292, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(167, 4294, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(168, 4330, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(169, 4332, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(170, 4333, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(171, 4336, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(172, 4338, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(173, 4341, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(174, 4342, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(175, 4343, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(176, 4344, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(177, 4345, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(178, 4346, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(179, 4347, '2017-09-28 07:35:56', '0000-00-00 00:00:00'),
(180, 4348, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(181, 4349, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(182, 4350, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(183, 4351, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(184, 4352, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(185, 4353, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(186, 4354, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(187, 4355, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(188, 4357, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(189, 4358, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(190, 4359, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(191, 4360, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(192, 4363, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(193, 4364, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(194, 4401, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(195, 4402, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(196, 4406, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(197, 4408, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(198, 4410, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(199, 4411, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(200, 4412, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(201, 4413, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(202, 4414, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(203, 4415, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(204, 4416, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(205, 4417, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(206, 4418, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(207, 4419, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(208, 4420, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(209, 4421, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(210, 4422, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(211, 4424, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(212, 4426, '2017-09-28 07:35:57', '0000-00-00 00:00:00'),
(213, 4427, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(214, 4428, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(215, 4429, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(216, 4430, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(217, 4431, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(218, 4434, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(219, 4435, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(220, 4438, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(221, 4441, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(222, 4442, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(223, 4443, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(224, 4444, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(225, 4448, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(226, 4449, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(227, 4450, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(228, 4451, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(229, 4453, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(230, 4454, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(231, 4455, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(232, 4456, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(233, 4457, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(234, 4459, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(235, 4460, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(236, 4461, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(237, 4462, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(238, 4463, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(239, 4464, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(240, 4467, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(241, 4468, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(242, 4469, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(243, 4471, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(244, 4472, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(245, 4473, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(246, 4474, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(247, 4475, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(248, 4476, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(249, 4478, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(250, 4479, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(251, 4481, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(252, 4485, '2017-09-28 07:35:58', '0000-00-00 00:00:00'),
(253, 4487, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(254, 4488, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(255, 4489, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(256, 4490, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(257, 4491, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(258, 4492, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(259, 4493, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(260, 4495, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(261, 4496, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(262, 4497, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(263, 4530, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(264, 4535, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(265, 4537, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(266, 4538, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(267, 4539, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(268, 4541, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(269, 4543, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(270, 4544, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(271, 4547, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(272, 4548, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(273, 4549, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(274, 4551, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(275, 4553, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(276, 4554, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(277, 4555, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(278, 4556, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(279, 4558, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(280, 4562, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(281, 4563, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(282, 4564, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(283, 4565, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(284, 4568, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(285, 4570, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(286, 4571, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(287, 4572, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(288, 4573, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(289, 4574, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(290, 4575, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(291, 4576, '2017-09-28 07:35:59', '0000-00-00 00:00:00'),
(292, 4578, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(293, 4579, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(294, 4605, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(295, 4606, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(296, 4607, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(297, 4609, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(298, 4611, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(299, 4612, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(300, 4613, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(301, 4614, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(302, 4616, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(303, 4617, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(304, 4619, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(305, 4622, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(306, 4623, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(307, 4624, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(308, 4625, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(309, 4626, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(310, 4627, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(311, 4628, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(312, 4629, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(313, 4630, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(314, 4631, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(315, 4634, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(316, 4635, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(317, 4637, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(318, 4640, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(319, 4642, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(320, 4643, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(321, 4644, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(322, 4645, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(323, 4646, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(324, 4648, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(325, 4649, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(326, 4650, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(327, 4652, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(328, 4653, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(329, 4654, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(330, 4655, '2017-09-28 07:36:00', '0000-00-00 00:00:00'),
(331, 4657, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(332, 4658, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(333, 4660, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(334, 4662, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(335, 4664, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(336, 4666, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(337, 4667, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(338, 4668, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(339, 4669, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(340, 4671, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(341, 4672, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(342, 4673, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(343, 4674, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(344, 4675, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(345, 4676, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(346, 4677, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(347, 4679, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(348, 4680, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(349, 4681, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(350, 4683, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(351, 4684, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(352, 4685, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(353, 4686, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(354, 4691, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(355, 4693, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(356, 4694, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(357, 4730, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(358, 4732, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(359, 4733, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(360, 4734, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(361, 4735, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(362, 4736, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(363, 4737, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(364, 4738, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(365, 4739, '2017-09-28 07:36:01', '0000-00-00 00:00:00'),
(366, 4740, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(367, 4741, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(368, 4742, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(369, 4743, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(370, 4744, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(371, 4745, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(372, 4746, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(373, 4747, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(374, 4750, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(375, 4751, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(376, 4756, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(377, 4757, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(378, 4758, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(379, 4760, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(380, 4761, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(381, 4762, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(382, 4763, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(383, 4764, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(384, 4765, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(385, 4766, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(386, 4768, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(387, 4769, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(388, 4772, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(389, 4773, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(390, 4774, '2017-09-28 07:36:02', '0000-00-00 00:00:00'),
(391, 4775, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(392, 4776, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(393, 4777, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(394, 4779, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(395, 4780, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(396, 4781, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(397, 4783, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(398, 4785, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(399, 4786, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(400, 4787, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(401, 4841, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(402, 4843, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(403, 4846, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(404, 4847, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(405, 4848, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(406, 4849, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(407, 4850, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(408, 4851, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(409, 4852, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(410, 4853, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(411, 4854, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(412, 4855, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(413, 4856, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(414, 4858, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(415, 4859, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(416, 4860, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(417, 4861, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(418, 4862, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(419, 4863, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(420, 4864, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(421, 4865, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(422, 4901, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(423, 4903, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(424, 4910, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(425, 4911, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(426, 4912, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(427, 4915, '2017-09-28 07:36:03', '0000-00-00 00:00:00'),
(428, 4917, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(429, 4918, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(430, 4920, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(431, 4921, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(432, 4922, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(433, 4923, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(434, 4924, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(435, 4925, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(436, 4926, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(437, 4927, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(438, 4928, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(439, 4929, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(440, 4930, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(441, 4932, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(442, 4933, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(443, 4935, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(444, 4936, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(445, 4937, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(446, 4938, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(447, 4939, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(448, 4940, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(449, 4941, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(450, 4942, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(451, 4943, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(452, 4944, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(453, 4945, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(454, 4947, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(455, 4949, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(456, 4950, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(457, 4951, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(458, 4952, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(459, 4953, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(460, 4954, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(461, 4955, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(462, 4956, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(463, 4957, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(464, 4958, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(465, 4961, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(466, 4962, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(467, 4963, '2017-09-28 07:36:04', '0000-00-00 00:00:00'),
(468, 4964, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(469, 4965, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(470, 4966, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(471, 4967, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(472, 4969, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(473, 4970, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(474, 4971, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(475, 4972, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(476, 4973, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(477, 4974, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(478, 4975, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(479, 4976, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(480, 4978, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(481, 4979, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(482, 4981, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(483, 4982, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(484, 4983, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(485, 4984, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(486, 4985, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(487, 4986, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(488, 4987, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(489, 4988, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(490, 4989, '2017-09-28 07:36:05', '0000-00-00 00:00:00'),
(491, 4992, '2017-09-28 07:36:05', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_details`
--
ALTER TABLE `appointment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_fee_details`
--
ALTER TABLE `appointment_fee_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `break_clock`
--
ALTER TABLE `break_clock`
  ADD PRIMARY KEY (`break_id`);

--
-- Indexes for table `break_interval`
--
ALTER TABLE `break_interval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caregiver_details`
--
ALTER TABLE `caregiver_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `consultation_type`
--
ALTER TABLE `consultation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_support`
--
ALTER TABLE `contact_support`
  ADD PRIMARY KEY (`support_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_professional_information`
--
ALTER TABLE `doctor_professional_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`driver_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `driver_assigned_order`
--
ALTER TABLE `driver_assigned_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_availability`
--
ALTER TABLE `driver_availability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_inventory`
--
ALTER TABLE `driver_inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `inventory_id` (`inventory_id`);

--
-- Indexes for table `driver_professional_detail`
--
ALTER TABLE `driver_professional_detail`
  ADD PRIMARY KEY (`professional_detail_id`,`driver_id`),
  ADD KEY `fk_driver_professional_detail_driver1_idx` (`driver_id`);

--
-- Indexes for table `driver_review_rating`
--
ALTER TABLE `driver_review_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hold_reason`
--
ALTER TABLE `hold_reason`
  ADD PRIMARY KEY (`reason_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`,`driver_id`),
  ADD KEY `fk_image_driver1_idx` (`driver_id`);

--
-- Indexes for table `inventory_status`
--
ALTER TABLE `inventory_status`
  ADD KEY `fk_inventory_status_inventory1_idx` (`inventory_id`),
  ADD KEY `fk_inventory_status_driver1_idx` (`driver_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `item_category_mapping`
--
ALTER TABLE `item_category_mapping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_familly`
--
ALTER TABLE `item_familly`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manage_warehouse_items`
--
ALTER TABLE `manage_warehouse_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minimum_delivery_prices`
--
ALTER TABLE `minimum_delivery_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `points_details`
--
ALTER TABLE `points_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restricted_areas`
--
ALTER TABLE `restricted_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `shift_clock`
--
ALTER TABLE `shift_clock`
  ADD PRIMARY KEY (`shift_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_appointment_transaction`
--
ALTER TABLE `tbl_appointment_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_info_pages`
--
ALTER TABLE `tbl_info_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_caregivers`
--
ALTER TABLE `tbl_order_caregivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_items`
--
ALTER TABLE `template_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_consultation_request`
--
ALTER TABLE `user_consultation_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `consultation_type_id` (`consultation_type_id`),
  ADD KEY `consultation_type_id_2` (`consultation_type_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_contact_share_list`
--
ALTER TABLE `user_contact_share_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_points`
--
ALTER TABLE `user_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `zip_codes`
--
ALTER TABLE `zip_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `appointment_details`
--
ALTER TABLE `appointment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `appointment_fee_details`
--
ALTER TABLE `appointment_fee_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `break_clock`
--
ALTER TABLE `break_clock`
  MODIFY `break_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `break_interval`
--
ALTER TABLE `break_interval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `caregiver_details`
--
ALTER TABLE `caregiver_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `consultation_type`
--
ALTER TABLE `consultation_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact_support`
--
ALTER TABLE `contact_support`
  MODIFY `support_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_professional_information`
--
ALTER TABLE `doctor_professional_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `driver_assigned_order`
--
ALTER TABLE `driver_assigned_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `driver_availability`
--
ALTER TABLE `driver_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `driver_inventory`
--
ALTER TABLE `driver_inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `driver_professional_detail`
--
ALTER TABLE `driver_professional_detail`
  MODIFY `professional_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `driver_review_rating`
--
ALTER TABLE `driver_review_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hold_reason`
--
ALTER TABLE `hold_reason`
  MODIFY `reason_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `item_category_mapping`
--
ALTER TABLE `item_category_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `item_familly`
--
ALTER TABLE `item_familly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `manage_warehouse_items`
--
ALTER TABLE `manage_warehouse_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `minimum_delivery_prices`
--
ALTER TABLE `minimum_delivery_prices`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `points_details`
--
ALTER TABLE `points_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `restricted_areas`
--
ALTER TABLE `restricted_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shift_clock`
--
ALTER TABLE `shift_clock`
  MODIFY `shift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_appointment_transaction`
--
ALTER TABLE `tbl_appointment_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_info_pages`
--
ALTER TABLE `tbl_info_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_order_caregivers`
--
ALTER TABLE `tbl_order_caregivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `template_items`
--
ALTER TABLE `template_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `user_consultation_request`
--
ALTER TABLE `user_consultation_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_contact_share_list`
--
ALTER TABLE `user_contact_share_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_points`
--
ALTER TABLE `user_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zip_codes`
--
ALTER TABLE `zip_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=492;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `driver_professional_detail`
--
ALTER TABLE `driver_professional_detail`
  ADD CONSTRAINT `fk_driver_professional_detail_driver1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_image_driver1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `inventory_status`
--
ALTER TABLE `inventory_status`
  ADD CONSTRAINT `fk_inventory_status_inventory1` FOREIGN KEY (`inventory_id`) REFERENCES `driver_inventory` (`inventory_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `user_consultation_request`
--
ALTER TABLE `user_consultation_request`
  ADD CONSTRAINT `user_consultation_request_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_consultation_request_ibfk_2` FOREIGN KEY (`consultation_type_id`) REFERENCES `consultation_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_consultation_request_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
