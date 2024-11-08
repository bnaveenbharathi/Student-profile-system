-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 02:02 PM
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
-- Database: `studentmanage`
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
  `student_roll_no` varchar(255) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `issue_description` text DEFAULT NULL,
  `action_taken` text DEFAULT NULL,
  `staff_handle` varchar(255) DEFAULT NULL,
  `document_upload` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `disciplinary_issues`
--

INSERT INTO `disciplinary_issues` (`id`, `student_roll_no`, `issue_date`, `issue_description`, `action_taken`, `staff_handle`, `document_upload`) VALUES
(1, '921022205011', NULL, 'MOBILE USING', 'no', 'Principal', NULL);

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
-- Table structure for table `reference_persons`
--

CREATE TABLE `reference_persons` (
  `id` int(11) NOT NULL,
  `student_roll_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reference_persons`
--

INSERT INTO `reference_persons` (`id`, `student_roll_no`, `name`, `phone_no`, `address`) VALUES
(1, '921022205011', 'bala', '6369800', '12/4');

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
(1, 'Naveen', '9210', 'IT', 3, 'B.Tech', 'staff@gmail.com', '9210', NULL);

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
  `caste` varchar(100) DEFAULT NULL,
  `age` text DEFAULT NULL,
  `mother_occupation` varchar(500) DEFAULT NULL,
  `father_occupation` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `profile_photo`, `dob`, `roll_no`, `sex`, `password`, `branch`, `department`, `year`, `semester`, `place_of_birth`, `blood_group`, `religion`, `community`, `mother_tongue`, `reference_persons`, `personal_identifications`, `email`, `phone`, `mother_name`, `mother_age`, `mother_phone`, `father_name`, `father_age`, `father_phone`, `family_photo`, `disciplinary_issues`, `address_detail`, `linkedin_link`, `github_link`, `skills`, `caste`, `age`, `mother_occupation`, `father_occupation`) VALUES
(1, 'B.Naveen Bharathi', 'images.png', '0000-00-00', '921022205011', 'Male', '921022205011', 'B.Tech', 'IT', 3, 5, 'periyakulam', 'A-', 'not to say', 'NOT TO SAY', 'TAMIL', NULL, 'ITS GIVE THE PERSONAL IDENTIFCATIONS', 'naveenbharathi5050@gmail.com', '6369800627', 'muru', 48, '636', 'Bala', 48, '6369', 'nscet.jpg', NULL, NULL, 'https://github.com/bnaveenbharathi', 'https://github.com/bnaveenbharathi', '[\"html\",\"css\",\"java\"]', 'not to say', '', 'cook', 'cook'),
(2, 'AASWIN', NULL, NULL, '921022205001', '', '921022205001', 'B.Tech', 'IT', 3, 5, 'New York', 'A+', 'Christianity', 'General', 'English', NULL, NULL, 'tony.stack@example.com', '1234567890', 'Maria Stack', 50, '1234567890', 'Howard Stack', 55, '0987654321', NULL, NULL, '123 Main St, New York', NULL, NULL, '[\"coding\",\"python\"]', 'General', NULL, NULL, NULL),
(3, 'Srihari Prash', NULL, NULL, '921022205021', NULL, '', 'B.Tech', 'IT', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sri@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Santhosh', NULL, NULL, '92102205011', NULL, '', 'B.Tech', 'IT', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'santhosh@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'pranav', NULL, NULL, '921022205089', NULL, '', 'B.Tech', 'IT', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pranav@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_cgpa`
--

CREATE TABLE `student_cgpa` (
  `id` int(11) NOT NULL,
  `cgpa_sem1` float(3,2) DEFAULT NULL,
  `cgpa_sem2` float(3,2) DEFAULT NULL,
  `cgpa_sem3` float(3,2) DEFAULT NULL,
  `cgpa_sem4` float(3,2) DEFAULT NULL,
  `cgpa_sem5` float(3,2) DEFAULT NULL,
  `cgpa_sem6` float(3,2) DEFAULT NULL,
  `cgpa_sem7` float(3,2) DEFAULT NULL,
  `cgpa_sem8` float(3,2) DEFAULT NULL,
  `cgpa_cumulative` float(4,2) DEFAULT NULL,
  `student_roll_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student_cgpa`
--

INSERT INTO `student_cgpa` (`id`, `cgpa_sem1`, `cgpa_sem2`, `cgpa_sem3`, `cgpa_sem4`, `cgpa_sem5`, `cgpa_sem6`, `cgpa_sem7`, `cgpa_sem8`, `cgpa_cumulative`, `student_roll_no`) VALUES
(1, 1.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '921022205011');

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
  ADD KEY `fk_student_roll_no` (`student_roll_no`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `reference_persons`
--
ALTER TABLE `reference_persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_roll_no` (`student_roll_no`);

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
  ADD KEY `fk_student_rollno` (`student_roll_no`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reference_persons`
--
ALTER TABLE `reference_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_cgpa`
--
ALTER TABLE `student_cgpa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `fk_student_roll_no` FOREIGN KEY (`student_roll_no`) REFERENCES `students` (`roll_no`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reference_persons`
--
ALTER TABLE `reference_persons`
  ADD CONSTRAINT `reference_persons_ibfk_1` FOREIGN KEY (`student_roll_no`) REFERENCES `students` (`roll_no`) ON DELETE CASCADE;

--
-- Constraints for table `student_cgpa`
--
ALTER TABLE `student_cgpa`
  ADD CONSTRAINT `fk_student_rollno` FOREIGN KEY (`student_roll_no`) REFERENCES `students` (`roll_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
