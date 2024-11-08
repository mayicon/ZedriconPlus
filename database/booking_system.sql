-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 02:07 AM
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
-- Database: `booking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booked_by` varchar(255) NOT NULL,
  `user_id` varchar(225) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `treatment_type` varchar(255) NOT NULL,
  `date_of_treatment` varchar(225) NOT NULL,
  `contract_price` varchar(255) NOT NULL,
  `technician` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type_of_treatment` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_date`, `booked_by`, `user_id`, `address`, `phone`, `remarks`, `treatment_type`, `date_of_treatment`, `contract_price`, `technician`, `created_at`, `type_of_treatment`) VALUES
(49, '2024-08-13', 'ads', '18', 'asd', '123', '', 'specific', '', '', '', '2024-08-24 08:12:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `is_verified` varchar(255) NOT NULL,
  `acc_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `username`, `email`, `password`, `otp`, `is_verified`, `acc_type`) VALUES
(18, 'zxc', '', '$2y$10$kWsY8HijryHr110hQToeWecp3N3NWYk34LW/i/1jOmDKYrI.QG5hi', '', '', 'admin'),
(19, 'asd', '', '$2y$10$CaJxg3FvojDbE75CLpidx.Qxs1GqNN0.7pb46C6jppGvYJlIH9oRq', '', '', ''),
(20, 'try', '', '$2y$10$yLilYQ5Bcb6mPoTLGWdOQu4t27fbbfZsYAyE1eGR4V/vHiMf6G3qa', '', '', ''),
(21, 'paphew', '', '$2y$10$EWn.ZjG2cKhz0MlKuoqjTu0hKT4kt6x3St1A2YRUZYX0/T/Cv4O7K', '', '', ''),
(27, 'qwe', '', '$2y$10$eN8T.NqYZKvUR5PxDXbQVuJUQKF8fF56RlEZm.yLjjAKYFwOc0MsK', '', '', 'admin'),
(28, 'azrael', 'josephdechavez1515@gmail.com', '$2y$10$Ghd.MaJbRUUEnZIFfpanYOybEn7LnyrSV2OVPGEYfPD.4H2psFgAC', '415483', '0', ''),
(29, 'azrael', 'jjdechavez@lspu.edu.ph', '$2y$10$RR8byuR5xnp3T/GYMn1.HuYVMBud5zT1Q9pEYfwFkXQ.S0Af4qM3q', '998821', '1', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
