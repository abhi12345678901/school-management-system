-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2021 at 05:20 PM
-- Server version: 5.6.51-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_subject`
--

CREATE TABLE `additional_subject` (
  `subject_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_mark` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `additional_subject`
--

INSERT INTO `additional_subject` (`subject_id`, `name`, `total_mark`, `class_id`, `teacher_id`) VALUES
(41, 'G.K.', '50', 32, 8),
(42, 'Computer', '50', 32, 8),
(43, 'M.Sc.', '50', 32, 8),
(44, 'Computer', '50', 33, 8),
(45, 'G.K.', '50', 33, 8),
(46, 'M.Sc.', '50', 33, 8),
(47, 'Computer', '50', 30, 8),
(48, 'G.K.', '50', 30, 8),
(49, 'M.Sc.', '50', 30, 8);

-- --------------------------------------------------------

--
-- Table structure for table `additional_subject__marksheet_student`
--

CREATE TABLE `additional_subject__marksheet_student` (
  `marksheet_student_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `obtain_mark` varchar(255) NOT NULL,
  `obtain_mark_sa` varchar(255) NOT NULL,
  `subject_enrichmenth` varchar(255) NOT NULL,
  `h_yrly` varchar(255) NOT NULL,
  `obtain_mark_pt_2` varchar(255) NOT NULL,
  `obtain_mark_sa_2` varchar(255) NOT NULL,
  `subject_enrichmentf` varchar(255) NOT NULL,
  `yrly` varchar(255) NOT NULL,
  `marksheet_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `fname`, `lname`, `email`) VALUES
(1, 'admin', '80a19f669b02edfbc208a5386ab5036b', 'BSKD', 'SCHOOL', 'bskd@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `student_id` int(11) NOT NULL,
  `rollno` int(10) NOT NULL,
  `student_name` varchar(200) NOT NULL,
  `father_name` varchar(200) NOT NULL,
  `mother_name` varchar(200) NOT NULL,
  `i_disease` varchar(100) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `paralysed` varchar(100) NOT NULL,
  `dcattatch` varchar(100) NOT NULL,
  `age_proof` varchar(100) NOT NULL,
  `idparents` varchar(100) NOT NULL,
  `st_hobby` varchar(100) NOT NULL,
  `st_interest` varchar(100) NOT NULL,
  `disease` varchar(100) NOT NULL,
  `ex_detail` varchar(100) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `dob` date NOT NULL,
  `sex` varchar(20) NOT NULL,
  `weight` varchar(20) NOT NULL,
  `height` varchar(20) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `p_address` varchar(200) NOT NULL,
  `p_phone` varchar(100) NOT NULL,
  `f_address` varchar(200) NOT NULL,
  `f_phone` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `f_occupation` varchar(100) NOT NULL,
  `m_occupation` varchar(100) NOT NULL,
  `bpl_no` varchar(100) NOT NULL,
  `st_adhar` varchar(100) NOT NULL,
  `parents_adhar` varchar(100) NOT NULL,
  `st_bank` varchar(100) NOT NULL,
  `st_ifsc` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `pr_school` varchar(200) NOT NULL,
  `gd_name` varchar(150) NOT NULL,
  `admssion_no` varchar(100) NOT NULL,
  `registerDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admission`
--
-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `attendance_type` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `mark` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `numeric_name` varchar(255) NOT NULL,
  `class_monthly_fee` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`, `numeric_name`, `class_monthly_fee`) VALUES
(24, 'NURSERY', '0', 500),
(25, 'LKG', '00', 500),
(26, 'UKG', '000', 500),
(27, 'ONE', '1', 500),
(28, 'TWO', '2', 600),
(29, 'THREE', '3', 600),
(30, 'FOUR', '4', 600),
(31, 'FIVE', '5', 600),
(32, 'SIX', '6', 700),
(33, 'SEVEN', '7', 700),
(34, 'EIGHT', '8', 700);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expenses_id` int(11) NOT NULL,
  `expenses_name` varchar(255) NOT NULL,
  `expenses_amount` varchar(255) NOT NULL,
  `expenses_name_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_name`
--

CREATE TABLE `expenses_name` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `marksheet`
--

CREATE TABLE `marksheet` (
  `marksheet_id` int(11) NOT NULL,
  `marksheet_name` varchar(255) NOT NULL,
  `marksheet_date` date NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marksheet`
--

-- --------------------------------------------------------

--
-- Table structure for table `marksheet_student`
--

CREATE TABLE `marksheet_student` (
  `marksheet_student_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `obtain_mark` varchar(255) NOT NULL,
  `obtain_mark_sa` varchar(255) NOT NULL,
  `subject_enrichmenth` varchar(255) NOT NULL,
  `h_yrly` varchar(255) NOT NULL,
  `obtain_mark_pt_2` varchar(255) NOT NULL,
  `obtain_mark_sa_2` varchar(255) NOT NULL,
  `subject_enrichmentf` varchar(255) NOT NULL,
  `yrly` varchar(255) NOT NULL,
  `marksheet_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `paid_amount` int(100) NOT NULL,
  `current_paid_amount` int(100) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `status` int(11) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `payment_name_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paymentdaterecord`
--

CREATE TABLE `paymentdaterecord` (
  `id` int(100) NOT NULL,
  `paymentID` int(100) NOT NULL,
  `paymentNameID` int(100) NOT NULL,
  `currentPaidAmount` int(100) NOT NULL,
  `currentPaidDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paymentdaterecord`
--

-- --------------------------------------------------------

--
-- Table structure for table `payment_name`
--

CREATE TABLE `payment_name` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_amount` int(255) NOT NULL,
  `reg_no` varchar(100) NOT NULL,
  `admission_fee` int(100) NOT NULL,
  `transport_fee` int(200) NOT NULL,
  `payabletransportfee` int(10) NOT NULL,
  `duration` int(10) NOT NULL,
  `monthly_fee` int(100) NOT NULL,
  `payablemonthlyfee` int(20) NOT NULL,
  `examination_fee` int(100) NOT NULL,
  `development_fee` int(100) NOT NULL,
  `late_fine` int(100) NOT NULL,
  `prospectus_fee` int(100) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_name`
--


-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `register_date` date NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `age` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_mark` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(1) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `user_level`, `fname`, `lname`, `email`) VALUES
(1, 'admin@bskd', '35d464257a134a596ecff192081b6610', 1, 'BSKD PUBLIC SCHOOL', 'SCHOOL', 'bskd@gmail.com'),
(2, 'user@bskd', '2ca1baa7ce3d3accd947eecf5f292693', 2, 'BSKD', 'USER', 'user@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_subject`
--
ALTER TABLE `additional_subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `additional_subject__marksheet_student`
--
ALTER TABLE `additional_subject__marksheet_student`
  ADD PRIMARY KEY (`marksheet_student_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expenses_id`);

--
-- Indexes for table `expenses_name`
--
ALTER TABLE `expenses_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marksheet`
--
ALTER TABLE `marksheet`
  ADD PRIMARY KEY (`marksheet_id`);

--
-- Indexes for table `marksheet_student`
--
ALTER TABLE `marksheet_student`
  ADD PRIMARY KEY (`marksheet_student_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `paymentdaterecord`
--
ALTER TABLE `paymentdaterecord`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_name`
--
ALTER TABLE `payment_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_subject`
--
ALTER TABLE `additional_subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `additional_subject__marksheet_student`
--
ALTER TABLE `additional_subject__marksheet_student`
  MODIFY `marksheet_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1846;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1056;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expenses_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_name`
--
ALTER TABLE `expenses_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marksheet`
--
ALTER TABLE `marksheet`
  MODIFY `marksheet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `marksheet_student`
--
ALTER TABLE `marksheet_student`
  MODIFY `marksheet_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4927;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7108;

--
-- AUTO_INCREMENT for table `paymentdaterecord`
--
ALTER TABLE `paymentdaterecord`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_name`
--
ALTER TABLE `payment_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7109;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
