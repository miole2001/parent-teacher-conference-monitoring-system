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
-- Database: `ptcms_conferenceData`
--

-- --------------------------------------------------------

--
-- Table structure for table `conference`
--

CREATE TABLE `conference` (
  `id` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `meeting_title` varchar(100) NOT NULL,
  `date_of_meeting` date NOT NULL,
  `time_meeting_starts` time NOT NULL,
  `year_level` varchar(40) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conference`
--

INSERT INTO `conference` (`id`, `teacher_name`, `meeting_title`, `date_of_meeting`, `time_meeting_starts`, `year_level`, `status`) VALUES
(2, 'teacher', 'meeting ra gud', '2024-11-20', '20:34:00', '3rd', 'ongoing');

-- --------------------------------------------------------

--
-- Table structure for table `conference_attendance`
--

CREATE TABLE `conference_attendance` (
  `id` int(11) NOT NULL,
  `meeting_title` varchar(100) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `parent_name` varchar(100) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `date_of_meeting` date NOT NULL,
  `year_level` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conference_attendance`
--

INSERT INTO `conference_attendance` (`id`, `meeting_title`, `student_name`, `parent_name`, `teacher_name`, `date_of_meeting`, `year_level`) VALUES
(1, 'meeting ra gud', 'John Doe', 'parent', 'teacher', '2024-11-20', '3rd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conference`
--
ALTER TABLE `conference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conference_attendance`
--
ALTER TABLE `conference_attendance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conference`
--
ALTER TABLE `conference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `conference_attendance`
--
ALTER TABLE `conference_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
