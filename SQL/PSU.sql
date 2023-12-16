-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 16, 2023 at 04:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `PSU`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `admin_gender` enum('Male','Female') NOT NULL,
  `admin_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `admin_gender`, `admin_address`) VALUES
('ADM-UR-001', 'Lord Christian', 'Manzon', 'Male', 'Uminggan, Pangasinan');

-- --------------------------------------------------------

--
-- Table structure for table `counselor`
--

CREATE TABLE `counselor` (
  `counselor_id` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `counselor_gender` enum('Male','Female') NOT NULL,
  `counselor_address` varchar(255) NOT NULL,
  `years_exp` int(11) NOT NULL,
  `educ_background` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `counselor`
--

INSERT INTO `counselor` (`counselor_id`, `first_name`, `last_name`, `birth_date`, `counselor_gender`, `counselor_address`, `years_exp`, `educ_background`) VALUES
('CLR-UR-001', 'Ernico', 'Uy', '2023-12-07', 'Male', 'Uminggan, Pangasinan', 12, 'Greatest guidance counselor of all time, whenever wherever in the universe. Great curls in the hair'),
('CLR-UR-002', 'Joel', 'Gutlay', '2023-12-15', 'Male', 'Alcala, Pangasinan', 1, 'PSU Urdaneta');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `student_address` varchar(255) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `student_gender` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `first_name`, `last_name`, `student_address`, `course_code`, `year`, `birth_date`, `student_gender`) VALUES
('21-UR-0001', 'Donn Jayson', 'Quinto', 'Bayambang, Pangasinan', 'BSIT', 3, '2003-03-26', 'Male'),
('21-UR-0002', 'Lord Christian', 'Manzon', 'Uminggan, Pangasinan', 'BSIT', 3, '2023-12-13', 'Female'),
('21-UR-0003', 'John Virgil', 'Carvajal', 'Bolinao, Pangasinan', 'BSEE', 3, '2023-12-16', 'Male'),
('21-UR-0004', 'Dino', 'Paraan', 'Rosales, Pangasinan', 'BSEE', 3, '2023-12-21', 'Female'),
('21-UR-0242', 'Dave', 'Barrientos', 'Tayug, Pangasinan', 'BSIT', 3, '2003-09-10', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `teacher_gender` enum('Male','Female') NOT NULL,
  `teacher_address` varchar(255) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `first_name`, `last_name`, `teacher_gender`, `teacher_address`, `contact_number`, `department`) VALUES
('EMP-UR-001', 'Frederick', 'Magno', 'Male', 'Anonas East, Urdaneta City, Pangasinan', '09123456789', 'College of Computing');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `counselor`
--
ALTER TABLE `counselor`
  ADD PRIMARY KEY (`counselor_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
