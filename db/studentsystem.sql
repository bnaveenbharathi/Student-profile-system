-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 05:10 AM
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
-- Database: `studentsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certifications`
--

CREATE TABLE `certifications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disciplinary_issues`
--

CREATE TABLE `disciplinary_issues` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `documentation` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `issue_list` text DEFAULT NULL,
  `staff_handle_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `staff_id`, `department`, `year`, `branch`, `email`, `password`, `profile_photo`) VALUES
(1, 'Naveen', '9210', 'IT', 3, 'B.Tech', 'naveen@gmail.com', '9210', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `roll_no` varchar(50) NOT NULL,
  `sex` enum('Male','Female','Other') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `community` varchar(50) DEFAULT NULL,
  `mother_tongue` varchar(50) DEFAULT NULL,
  `reference_persons` text DEFAULT NULL,
  `personal_identifications` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_age` int(11) DEFAULT NULL,
  `mother_phone` varchar(20) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_age` int(11) DEFAULT NULL,
  `father_phone` varchar(20) DEFAULT NULL,
  `family_photo` varchar(255) DEFAULT NULL,
  `disciplinary_issues` text DEFAULT NULL,
  `address_detail` text DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `github_link` varchar(255) DEFAULT NULL,
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills`)),
  `caste` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `profile_photo`, `dob`, `roll_no`, `sex`, `password`, `branch`, `department`, `year`, `semester`, `place_of_birth`, `blood_group`, `religion`, `community`, `mother_tongue`, `reference_persons`, `personal_identifications`, `email`, `phone`, `mother_name`, `mother_age`, `mother_phone`, `father_name`, `father_age`, `father_phone`, `family_photo`, `disciplinary_issues`, `address_detail`, `linkedin_link`, `github_link`, `skills`, `caste`) VALUES
(1, 'B.Naveen Bharathi', NULL, NULL, '921022205011', NULL, '$2y$10$HQ.hBeYX04VU.Vjn6rwfa.q3US2tjKJkRU54wbtt7PeQ5h565H3i.', 'B.Tech', 'IT', 3, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'naveenbharathi5050@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://github.com/bnaveenbharathi', 'https://github.com/bnaveenbharathi', '[\"html\",\"css\",\"java\"]', NULL),
(2, 'Tony Stack', NULL, NULL, '921022205001', '', '921022205001', 'B.Tech', 'IT', 3, 5, 'New York', 'A+', 'Christianity', 'General', 'English', NULL, NULL, 'tony.stack@example.com', '1234567890', 'Maria Stack', 50, '1234567890', 'Howard Stack', 55, '0987654321', NULL, NULL, '123 Main St, New York', NULL, NULL, '[\"coding\",\"python\"]', 'General');

-- --------------------------------------------------------

--
-- Table structure for table `student_cgpa`
--

CREATE TABLE `student_cgpa` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `cgpa_sem1` float(3,2) DEFAULT NULL,
  `cgpa_sem2` float(3,2) DEFAULT NULL,
  `cgpa_sem3` float(3,2) DEFAULT NULL,
  `cgpa_sem4` float(3,2) DEFAULT NULL,
  `cgpa_sem5` float(3,2) DEFAULT NULL,
  `cgpa_sem6` float(3,2) DEFAULT NULL,
  `cgpa_sem7` float(3,2) DEFAULT NULL,
  `cgpa_sem8` float(3,2) DEFAULT NULL,
  `cgpa_cumulative` float(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `disciplinary_issues`
--
ALTER TABLE `disciplinary_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roll_no` (`roll_no`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `roll_no_2` (`roll_no`);

--
-- Indexes for table `student_cgpa`
--
ALTER TABLE `student_cgpa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disciplinary_issues`
--
ALTER TABLE `disciplinary_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_cgpa`
--
ALTER TABLE `student_cgpa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `achievements_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certifications`
--
ALTER TABLE `certifications`
  ADD CONSTRAINT `certifications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disciplinary_issues`
--
ALTER TABLE `disciplinary_issues`
  ADD CONSTRAINT `disciplinary_issues_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_cgpa`
--
ALTER TABLE `student_cgpa`
  ADD CONSTRAINT `student_cgpa_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
