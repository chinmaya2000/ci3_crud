-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 08:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `state_master`
--

CREATE TABLE `state_master` (
  `id` int(11) NOT NULL,
  `state_name` varchar(50) NOT NULL,
  `state_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `state_master`
--

INSERT INTO `state_master` (`id`, `state_name`, `state_code`) VALUES
(1, 'Andhra Pradesh', 'AP'),
(2, 'Arunachal Pradesh', 'AR'),
(3, 'Assam', 'AS'),
(4, 'Bihar', 'BR'),
(5, 'Chhattisgarh', 'CG'),
(6, 'Goa', 'GA'),
(7, 'Gujarat', 'GJ'),
(8, 'Haryana', 'HR'),
(9, 'Himachal Pradesh', 'HP'),
(10, 'Jharkhand', 'JH'),
(11, 'Karnataka', 'KA'),
(12, 'Kerala', 'KL'),
(13, 'Madhya Pradesh', 'MP'),
(14, 'Maharashtra', 'MH'),
(15, 'Manipur', 'MN'),
(16, 'Meghalaya', 'ML'),
(17, 'Mizoram', 'MZ'),
(18, 'Nagaland', 'NL'),
(19, 'Odisha', 'OD'),
(20, 'Punjab', 'PB'),
(21, 'Rajasthan', 'RJ'),
(22, 'Sikkim', 'SK'),
(23, 'Tamil Nadu', 'TN'),
(24, 'Telangana', 'TS'),
(25, 'Tripura', 'TR'),
(26, 'Uttar Pradesh', 'UP'),
(27, 'Uttarakhand', 'UK'),
(28, 'West Bengal', 'WB'),
(29, 'Andaman and Nicobar Islands', 'AN'),
(30, 'Chandigarh', 'CH'),
(31, 'Dadra and Nagar Haveli and Daman and Diu', 'DN'),
(32, 'Delhi', 'DL'),
(33, 'Jammu and Kashmir', 'JK'),
(34, 'Ladakh', 'LA'),
(35, 'Lakshadweep', 'LD'),
(36, 'Puducherry', 'PY');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `state` varchar(100) NOT NULL,
  `record_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(100) DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `gender`, `state`, `record_status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'Chinmaya Behera', 'chinmaya@example.com', '9876543210', 'Male', 'OD', 1, 'System', '2025-11-25 06:21:30', NULL, NULL),
(2, 'Priya Das', 'priya@example.com', '8877665544', 'Female', 'KA', 1, 'System', '2025-11-25 06:21:30', NULL, NULL),
(4, 'Sneha Patnaik', 'sneha@example.com', '9090909090', 'Female', 'DL', 1, 'System', '2025-11-25 06:21:30', NULL, NULL),
(10, 'ABHISEK LABALA', 'abhiseklabala1@gmail.com', '8328826667', 'Male', 'AN', 1, 'System', '2025-11-25 20:03:34', 'System', '2025-11-25 20:09:19'),
(11, 'Abinash Das', 'abinash1@gmail.com', '8093452464', 'Female', 'OD', 1, 'System', '2025-11-25 20:14:30', 'System', '2025-11-25 20:14:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `state_master`
--
ALTER TABLE `state_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `state_master`
--
ALTER TABLE `state_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
