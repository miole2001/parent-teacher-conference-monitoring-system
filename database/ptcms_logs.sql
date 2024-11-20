-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2024 at 03:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ptcms_logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `email`, `activity_type`, `user_type`, `timestamp`) VALUES
(1, 'admin@gmail.com', 'Login', 'admin', '2024-11-20 11:18:26'),
(2, 'admin@gmail.com', 'Login', 'admin', '2024-11-20 14:31:25'),
(3, 'admin@gmail.com', 'Login', 'admin', '2024-11-20 14:48:17'),
(4, 'admin@gmail.com', 'Logout', 'admin', '2024-11-20 14:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `parent_logs`
--

CREATE TABLE `parent_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_logs`
--

INSERT INTO `parent_logs` (`id`, `email`, `activity_type`, `user_type`, `timestamp`) VALUES
(1, 'parent@gmail.com', 'Login', 'parent', '2024-11-19 10:01:47'),
(2, 'parent@gmail.com', 'Login', 'parent', '2024-11-20 13:05:17');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_logs`
--

CREATE TABLE `teacher_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_logs`
--

INSERT INTO `teacher_logs` (`id`, `email`, `activity_type`, `user_type`, `timestamp`) VALUES
(1, 'teacher@gmail.com', 'Login', 'teacher', '2024-11-19 10:01:11'),
(2, 'teacher@gmail.com', 'Logout', 'teacher', '2024-11-19 10:01:19'),
(3, 'teacher@gmail.com', 'Logout', 'teacher', '2024-11-19 10:01:49'),
(4, 'teacher@gmail.com', 'Logout', 'teacher', '2024-11-20 11:31:04'),
(5, 'teacher@gmail.com', 'Login', 'teacher', '2024-11-20 11:31:11'),
(6, 'teacher@gmail.com', 'Logout', 'teacher', '2024-11-20 13:05:06'),
(7, 'teacher@gmail.com', 'Logout', 'teacher', '2024-11-20 14:31:19'),
(8, 'teacher@gmail.com', 'Login', 'teacher', '2024-11-20 14:48:44'),
(9, 'teacher@gmail.com', 'Logout', 'teacher', '2024-11-20 14:49:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_logs`
--
ALTER TABLE `parent_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_logs`
--
ALTER TABLE `teacher_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parent_logs`
--
ALTER TABLE `parent_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_logs`
--
ALTER TABLE `teacher_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
