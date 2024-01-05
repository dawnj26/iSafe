-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2024 at 11:51 AM
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
-- Database: `iSafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `100ms_rooms`
--

CREATE TABLE `100ms_rooms` (
  `room_id` varchar(255) NOT NULL,
  `counselor_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `100ms_rooms`
--

INSERT INTO `100ms_rooms` (`room_id`, `counselor_id`) VALUES
('65772c2a30f8c1b3e3425310', 'CLR-UR-001');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `creator_id` varchar(10) NOT NULL,
  `counselor_id` varchar(10) NOT NULL,
  `report_title` varchar(255) NOT NULL,
  `report_desc` text NOT NULL,
  `time_of_event` time NOT NULL,
  `date_of_event` date NOT NULL,
  `status` enum('finished','unfinished') NOT NULL,
  `map_longitude` decimal(10,6) NOT NULL,
  `map_latitude` decimal(10,6) NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `creator_id`, `counselor_id`, `report_title`, `report_desc`, `time_of_event`, `date_of_event`, `status`, `map_longitude`, `map_latitude`, `appointment_time`, `appointment_date`) VALUES
(5, '21-UR-0001', 'CLR-UR-001', 'Bullying', 'bully', '15:41:00', '2023-12-16', 'unfinished', 120.902864, 15.593939, '13:00:00', '2023-12-20'),
(6, '21-UR-0001', 'CLR-UR-001', 'Rape', 'ako ay nirape sa school', '23:37:00', '2024-01-01', 'unfinished', 120.357980, 16.008938, '10:00:00', '2024-01-12');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `sender_id` varchar(10) NOT NULL,
  `receiver_id` varchar(10) NOT NULL,
  `chat_date` datetime NOT NULL DEFAULT current_timestamp(),
  `text_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`chat_id`, `sender_id`, `receiver_id`, `chat_date`, `text_message`) VALUES
(1, '21-UR-0001', '21-UR-0242', '2023-12-09 22:10:07', 'hi dave'),
(2, '21-UR-0001', '21-UR-0242', '2023-12-09 22:43:16', 'hello'),
(3, '21-UR-0001', '21-UR-0242', '2023-12-09 22:46:02', 'lolo'),
(4, '21-UR-0002', '21-UR-0001', '2023-12-10 11:22:11', 'hello pre'),
(5, '21-UR-0001', '21-UR-0002', '2023-12-10 11:59:08', 'ge'),
(6, '21-UR-0001', '21-UR-0002', '2023-12-10 12:22:57', 'mapapa lorem ipsum ka talaga bossing'),
(7, '21-UR-0001', '21-UR-0242', '2023-12-10 12:41:45', 'asd'),
(8, '21-UR-0001', '21-UR-0002', '2023-12-10 13:11:31', 'halop'),
(9, '21-UR-0001', '21-UR-0002', '2023-12-10 13:11:49', 'asd'),
(10, '21-UR-0001', '21-UR-0002', '2023-12-10 13:12:51', 'what the hell'),
(11, '21-UR-0001', '21-UR-0002', '2023-12-10 13:17:05', 'asd'),
(12, '21-UR-0001', '21-UR-0002', '2023-12-10 13:17:15', 'grabe'),
(13, '21-UR-0001', '21-UR-0242', '2023-12-10 13:18:15', 'asd'),
(14, '21-UR-0001', '21-UR-0002', '2023-12-10 13:18:25', 'asd'),
(15, '21-UR-0001', '21-UR-0242', '2023-12-10 13:24:27', 'asdfff'),
(16, '21-UR-0001', '21-UR-0002', '2023-12-10 13:32:30', 'sdf'),
(17, '21-UR-0001', '21-UR-0002', '2023-12-10 13:34:20', 'asd'),
(18, '21-UR-0001', '21-UR-0002', '2023-12-10 13:34:27', 'galing ko talaga pare'),
(19, '21-UR-0001', '21-UR-0002', '2023-12-10 13:34:33', 'holyshit'),
(20, '21-UR-0001', '21-UR-0002', '2023-12-10 13:38:02', 'holy shit matatapos kaya namin to'),
(21, '21-UR-0001', '21-UR-0242', '2023-12-11 14:44:05', 'hay nako ampogi ko talaga'),
(28, '21-UR-0001', '21-UR-0003', '2023-12-11 22:22:31', 'asd'),
(29, '21-UR-0001', '21-UR-0003', '2023-12-11 22:22:36', 'dsa'),
(30, '21-UR-0003', '21-UR-0001', '2023-12-11 22:26:02', 'what the hell'),
(31, '21-UR-0003', '21-UR-0242', '2023-12-11 22:26:17', 'hi dave'),
(32, '21-UR-0002', '21-UR-0001', '2023-12-11 23:13:58', 'hi'),
(33, '21-UR-0001', '21-UR-0002', '2023-12-11 23:14:09', 'hello'),
(34, 'CLR-UR-001', '21-UR-0001', '2023-12-11 23:56:44', 'hi bebe donn'),
(35, 'CLR-UR-001', '21-UR-0001', '2023-12-12 00:24:32', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kzi-vssm-ebr'),
(36, 'CLR-UR-001', '21-UR-0001', '2023-12-12 08:51:41', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kzi-vssm-ebr'),
(37, 'CLR-UR-001', '21-UR-0001', '2023-12-12 08:52:47', 'hi'),
(39, 'CLR-UR-001', '21-UR-0001', '2023-12-12 09:08:37', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kzi-vssm-ebr'),
(42, 'CLR-UR-001', '21-UR-0001', '2023-12-12 09:10:47', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kuq-eovf-qjf'),
(43, 'CLR-UR-001', '21-UR-0001', '2023-12-12 09:11:56', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kuq-eovf-qjf'),
(44, 'CLR-UR-001', '21-UR-0001', '2023-12-12 09:14:12', 'gawk'),
(45, '21-UR-0001', 'CLR-UR-001', '2023-12-14 04:28:01', 'hi'),
(46, '21-UR-0001', '21-UR-0242', '2023-12-14 04:30:01', 'asd'),
(51, 'CLR-UR-001', '21-UR-0001', '2023-12-14 05:05:13', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kuq-eovf-qjf'),
(52, 'CLR-UR-001', '21-UR-0001', '2023-12-14 05:13:14', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kzi-vssm-ebr'),
(53, 'CLR-UR-001', '21-UR-0001', '2023-12-14 05:13:34', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kzi-vssm-ebr'),
(54, '21-UR-0001', 'CLR-UR-001', '2023-12-14 10:47:55', 'helo'),
(55, 'CLR-UR-001', '21-UR-0001', '2023-12-14 10:49:49', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kuq-eovf-qjf'),
(56, 'CLR-UR-001', '21-UR-0001', '2023-12-14 10:49:54', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kzi-vssm-ebr'),
(57, 'CLR-UR-001', '21-UR-0001', '2023-12-14 10:51:37', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kuq-eovf-qjf'),
(58, 'CLR-UR-001', '21-UR-0001', '2023-12-14 10:53:21', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kzi-vssm-ebr'),
(59, 'CLR-UR-001', '21-UR-0001', '2023-12-14 14:51:36', 'https://dawnj26-videoconf-1956.app.100ms.live/meeting/kzi-vssm-ebr');

-- --------------------------------------------------------

--
-- Table structure for table `counselor_schedule`
--

CREATE TABLE `counselor_schedule` (
  `sched_id` int(11) NOT NULL,
  `counselor_id` varchar(10) NOT NULL,
  `day_of_week` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `counselor_schedule`
--

INSERT INTO `counselor_schedule` (`sched_id`, `counselor_id`, `day_of_week`) VALUES
(1, 'CLR-UR-001', 'Monday'),
(2, 'CLR-UR-001', 'Wednesday'),
(3, 'CLR-UR-001', 'Friday');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `poster_id` varchar(10) NOT NULL,
  `post_text` text NOT NULL,
  `anonymous_post` tinyint(1) NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `poster_id`, `post_text`, `anonymous_post`, `date_posted`) VALUES
(2, '21-UR-0001', 'What is on my mind boi', 0, '2023-12-30 22:55:48'),
(3, '21-UR-0001', 'ako si donn at ako ay na bully sa kalye', 0, '2023-12-31 16:54:53'),
(4, '21-UR-0001', 'ako si donn at ako ay na bully sa kalye number 2', 0, '2023-12-31 16:57:42'),
(5, '21-UR-0001', 'i am scared oh my gosh please help me hehehe', 0, '2023-12-31 17:00:10'),
(6, '21-UR-0001', 'ako ay ni rape ni gago hahaha joke lang', 1, '2023-12-31 17:03:26'),
(7, '21-UR-0001', 'ako ay ni rape ni gago totoo na', 0, '2023-12-31 17:03:52'),
(8, '21-UR-0001', 'asd', 0, '2023-12-31 17:28:09'),
(9, '21-UR-0001', 'hello akoy isang pinoy may puso at diwa', 0, '2024-01-01 15:52:58'),
(10, '21-UR-0001', 'what the hell walang image yung post ko', 0, '2024-01-01 15:54:23'),
(11, '21-UR-0001', 'asd', 0, '2024-01-01 15:56:39'),
(12, '21-UR-0001', 'dsa', 0, '2024-01-01 15:57:27'),
(13, '21-UR-0001', 'dsa', 0, '2024-01-01 15:57:29'),
(14, '21-UR-0001', 'dsa', 0, '2024-01-01 15:57:30'),
(15, '21-UR-0001', 'dsa', 0, '2024-01-01 16:01:40'),
(16, '21-UR-0001', 'dsa', 0, '2024-01-01 16:04:26'),
(17, '21-UR-0001', 'dog poop', 0, '2024-01-01 16:05:04'),
(18, '21-UR-0001', 'you dont even know my name do you?', 0, '2024-01-01 20:14:32'),
(19, '21-UR-0001', 'asd', 1, '2024-01-02 23:37:24'),
(20, '21-UR-0001', 'hay nako tangin', 1, '2024-01-02 23:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`comment_id`, `post_id`, `user_id`, `comment_text`, `comment_date_created`) VALUES
(1, 18, '21-UR-0001', 'hello my boi', '2024-01-02 15:39:40'),
(2, 18, '21-UR-0001', 'wassup', '2024-01-02 16:13:08'),
(3, 18, '21-UR-0001', 'galing naman', '2024-01-02 16:13:58'),
(4, 16, '21-UR-0001', 'laos', '2024-01-02 16:16:50'),
(9, 20, '21-UR-0001', 'matsuri', '2024-01-02 23:42:49'),
(10, 4, '21-UR-0001', 'hi donn', '2024-01-03 22:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE `post_images` (
  `image_id` int(11) NOT NULL,
  `image_file_path` varchar(255) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_images`
--

INSERT INTO `post_images` (`image_id`, `image_file_path`, `post_id`) VALUES
(1, '/opt/lampp/htdocs/IJuanaBeSafe/src/post/uploads/65902f7436e3d_phpZePtco', 2),
(2, '/opt/lampp/htdocs/IJuanaBeSafe/src/post/uploads/65912c5d7e674_phpu0j2ZG', 3),
(3, '/opt/lampp/htdocs/IJuanaBeSafe/src/post/uploads/65912d06aa1a3_phpP3f3HK', 4),
(4, '/opt/lampp/htdocs/IJuanaBeSafe/src/post/uploads/65912d9ad14bd_phpfxEeyg', 5),
(5, '/opt/lampp/htdocs/IJuanaBeSafe/src/post/uploads/65912e5ea859e_phphdJJGq', 6),
(6, '/opt/lampp/htdocs/IJuanaBeSafe/src/post/uploads/65912e7824119_php7qMRUj', 7),
(7, '/opt/lampp/htdocs/IJuanaBeSafe/src/post/uploads/659272304fd80_phpRKQ08d', 17),
(8, '/opt/lampp/htdocs/IJuanaBeSafe/src/post/uploads/6592aca8982b9_phpnSlyJE', 18),
(9, '/opt/lampp/htdocs/IJuanaBeSafe/src/post/uploads/65942deb4ade4_php1MvkZk', 20);

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `date_liked` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`like_id`, `post_id`, `user_id`, `date_liked`) VALUES
(22, 16, '21-UR-0001', '2024-01-02 00:18:07'),
(23, 14, '21-UR-0001', '2024-01-02 16:16:15'),
(26, 13, '21-UR-0001', '2024-01-02 23:11:16'),
(28, 4, '21-UR-0001', '2024-01-03 22:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_gender` enum('Male','Female') NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` enum('student','counselor','employee','admin') NOT NULL,
  `date_registered` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `user_gender`, `email_address`, `user_password`, `user_role`, `date_registered`) VALUES
('21-UR-0001', 'Donn Jayson', 'Quinto', 'Male', 'donn@gmail.com', '$2y$10$zH5nUtHzx2Ws3TkXFSON/.Tb8DngOj02ArpeVdejnOPVLFdSGLMGa', 'student', '2023-12-09 12:26:05'),
('21-UR-0002', 'Lord Christian', 'Manzon', 'Female', 'lmanzon@gmail.com', '$2y$10$gFy8YKqMCxfp/EFfYgYLU.JqBbK1rcmk4HtgyuOYY6yE3IOIVBC26', 'student', '2023-12-10 11:21:17'),
('21-UR-0003', 'John Virgil', 'Carvajal', 'Male', 'JV@gmail.com', '$2y$10$X39VTwc59.1A92Ja6bRItOeoBhtNLINgohbC9TxZLyr7T0H0ekZgK', 'student', '2023-12-11 01:11:05'),
('21-UR-0004', 'Dino', 'Paraan', 'Male', 'DONN@gmail.com', '$2y$10$pqdc/tsjbfJNzBNv4a/4qO02J/UMGJg68huIU9T.M6yezO0gMdAzi', 'student', '2023-12-14 14:25:15'),
('21-UR-0242', 'Dave', 'Barrientos', 'Male', 'dave@gmail.com', '$2y$10$pSaaNRjMw9uGjXt7y0YfjOLiP6KZzgImeqiSrpc0Uqwb1Fn1klF42', 'student', '2023-12-09 12:24:06'),
('CLR-UR-001', 'Ernico', 'Uy', 'Male', 'asd@asd.asd', '$2y$10$N/tuOf1vNrMFvn/AnBEpAOMW3voArhY90gDLQMDUNc6PwpVSkoZjG', 'counselor', '2023-12-11 23:48:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `100ms_rooms`
--
ALTER TABLE `100ms_rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `counselor_id_fk` (`counselor_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `creator_fk` (`creator_id`),
  ADD KEY `counselor_fk` (`counselor_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `receiver_fk` (`receiver_id`),
  ADD KEY `sender_fk` (`sender_id`);

--
-- Indexes for table `counselor_schedule`
--
ALTER TABLE `counselor_schedule`
  ADD PRIMARY KEY (`sched_id`),
  ADD KEY `counselor_sched_fk` (`counselor_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `poster_fk` (`poster_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_fk` (`post_id`),
  ADD KEY `commentor_fk` (`user_id`);

--
-- Indexes for table `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `post_id_fk` (`post_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `post_like_fk` (`post_id`),
  ADD KEY `post_like_usr` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `counselor_schedule`
--
ALTER TABLE `counselor_schedule`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_images`
--
ALTER TABLE `post_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `100ms_rooms`
--
ALTER TABLE `100ms_rooms`
  ADD CONSTRAINT `counselor_id_fk` FOREIGN KEY (`counselor_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `counselor_fk` FOREIGN KEY (`counselor_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `creator_fk` FOREIGN KEY (`creator_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `receiver_fk` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `sender_fk` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `counselor_schedule`
--
ALTER TABLE `counselor_schedule`
  ADD CONSTRAINT `counselor_sched_fk` FOREIGN KEY (`counselor_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `poster_fk` FOREIGN KEY (`poster_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `commentor_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `post_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`);

--
-- Constraints for table `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`);

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_like_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  ADD CONSTRAINT `post_like_usr` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
