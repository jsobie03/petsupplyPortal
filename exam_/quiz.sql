-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2018 at 09:42 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_admin`
--

CREATE TABLE `login_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_type` varchar(10) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `birthday` varchar(50) NOT NULL,
  `profile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_admin`
--

INSERT INTO `login_admin` (`id`, `username`, `password`, `account_type`, `firstname`, `middlename`, `lastname`, `gender`, `birthday`, `profile`) VALUES
(1, 'admin', 'admin', 'admin', 'christopher', 'platino', 'vistal', 'male', '01/06/1997', '');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_desc` text NOT NULL,
  `q_answer1` varchar(255) NOT NULL,
  `q_answer2` varchar(255) NOT NULL,
  `q_answer3` varchar(255) NOT NULL,
  `q_answer4` varchar(255) NOT NULL,
  `exact_answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_desc`, `q_answer1`, `q_answer2`, `q_answer3`, `q_answer4`, `exact_answer`) VALUES
(37, 'Question 3 ', 'This is a new', 'new a ', 'bc', 'sdkf', 'A'),
(41, 'Question 5', 'a', 'b', 'c', 'd', 'A'),
(42, 'Question 1', 'Sample', 'Sample for print', 'Testing for print', 'New to print', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `taker`
--

CREATE TABLE `taker` (
  `taker_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `take_date` int(11) NOT NULL,
  `is_finish` enum('yes','no','','') DEFAULT 'no',
  `exam_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taker`
--

INSERT INTO `taker` (`taker_id`, `firstname`, `middlename`, `lastname`, `take_date`, `is_finish`, `exam_id`) VALUES
(1, 's', 'f', 'a', 1521312469, 'yes', 'h7vv3644e95ijmshvnfdkd8303'),
(2, 'christpher', '2', 'a', 1521315489, 'yes', 'bj9h6k3ual4chp6a32gchkble0');

-- --------------------------------------------------------

--
-- Table structure for table `take_finish`
--

CREATE TABLE `take_finish` (
  `takef_id` int(11) NOT NULL,
  `exam_id` varchar(50) NOT NULL,
  `correct` int(11) NOT NULL,
  `wrong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `take_finish`
--

INSERT INTO `take_finish` (`takef_id`, `exam_id`, `correct`, `wrong`) VALUES
(1, 'h7vv3644e95ijmshvnfdkd8303', 2, 0),
(2, 'bj9h6k3ual4chp6a32gchkble0', 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_admin`
--
ALTER TABLE `login_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `taker`
--
ALTER TABLE `taker`
  ADD PRIMARY KEY (`taker_id`);

--
-- Indexes for table `take_finish`
--
ALTER TABLE `take_finish`
  ADD PRIMARY KEY (`takef_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_admin`
--
ALTER TABLE `login_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `taker`
--
ALTER TABLE `taker`
  MODIFY `taker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `take_finish`
--
ALTER TABLE `take_finish`
  MODIFY `takef_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
