-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2020 at 02:07 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `creativeaging`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(10) NOT NULL,
  `event_type` varchar(20) NOT NULL,
  `program_id` int(10) UNSIGNED NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `event_notes` varchar(150) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_type`, `program_id`, `date_start`, `date_end`, `event_notes`, `date_created`) VALUES
(7, 'scp', 1, '2020-05-12', '2020-05-12', NULL, '2020-05-08 16:16:51'),
(8, 'scp', 3, '2020-05-05', '2020-05-05', NULL, '2020-05-08 16:17:29'),
(9, 'scp', 1, '2020-05-14', '2020-05-14', NULL, '2020-05-08 16:17:52');

-- --------------------------------------------------------

--
-- Table structure for table `events_facilities`
--

CREATE TABLE `events_facilities` (
  `event_id` int(10) DEFAULT NULL,
  `facility_id` int(10) DEFAULT NULL,
  `funding_id` int(10) UNSIGNED DEFAULT NULL,
  `num_children` int(10) DEFAULT NULL,
  `num_adults` int(10) DEFAULT NULL,
  `num_seniors` int(10) DEFAULT NULL,
  `feedback` varchar(150) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events_facilities`
--

INSERT INTO `events_facilities` (`event_id`, `facility_id`, `funding_id`, `num_children`, `num_adults`, `num_seniors`, `feedback`, `date_created`) VALUES
(7, 1, 1, 9, 7, 8, NULL, '2020-05-08 16:16:51'),
(8, 1, 3, 0, 88, 77, '', '2020-05-08 16:17:29'),
(9, 4, 2, 8, 8, 5, '', '2020-05-08 16:17:52');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `facility_id` int(10) NOT NULL,
  `facility_name` varchar(50) DEFAULT NULL,
  `facility_contact` varchar(50) DEFAULT NULL,
  `facility_notes` varchar(150) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`facility_id`, `facility_name`, `facility_contact`, `facility_notes`, `date_created`) VALUES
(1, 'A Facility', 'A contact', 'Hell', '2020-05-07 20:53:54'),
(2, 'Facility0', '', '', '2020-05-07 21:35:34'),
(3, 'Facility1', '', '', '2020-05-07 21:43:23'),
(4, 'Facility2', '', '', '2020-05-07 22:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `funding`
--

CREATE TABLE `funding` (
  `funding_id` int(10) UNSIGNED NOT NULL,
  `funding_name` varchar(50) DEFAULT NULL,
  `funding_amount` varchar(20) DEFAULT NULL,
  `funding_type` varchar(20) DEFAULT NULL,
  `funding_period` varchar(20) DEFAULT NULL,
  `funding_notes` varchar(250) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `funding`
--

INSERT INTO `funding` (`funding_id`, `funding_name`, `funding_amount`, `funding_type`, `funding_period`, `funding_notes`, `date_created`) VALUES
(1, 'A funding', '1', NULL, NULL, NULL, '2020-05-07 20:53:12'),
(2, 'Funding1', '', 'grant', '', '', '2020-05-07 21:35:35'),
(3, 'Another Source', NULL, 'scholarship', NULL, NULL, '2020-05-07 21:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` int(10) UNSIGNED NOT NULL,
  `program_name` varchar(50) DEFAULT NULL,
  `program_topic` varchar(50) DEFAULT NULL,
  `program_description` varchar(250) DEFAULT NULL,
  `program_notes` varchar(250) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_id`, `program_name`, `program_topic`, `program_description`, `program_notes`, `date_created`) VALUES
(1, 'A Program', 'A topic', 'A description', 'I require release from this hell we call reality, end my suffering', '2020-05-07 20:45:54'),
(2, 'program2', 'art', '', '', '2020-05-07 21:23:09'),
(3, 'Another other program', 'wellness', 'yes', 'Call a bondulance', '2020-05-07 22:01:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `events_ibfk_1` (`program_id`);

--
-- Indexes for table `events_facilities`
--
ALTER TABLE `events_facilities`
  ADD KEY `funding_Id` (`funding_id`),
  ADD KEY `facility_id` (`facility_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`facility_id`);

--
-- Indexes for table `funding`
--
ALTER TABLE `funding`
  ADD PRIMARY KEY (`funding_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `facility_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `funding`
--
ALTER TABLE `funding`
  MODIFY `funding_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events_facilities`
--
ALTER TABLE `events_facilities`
  ADD CONSTRAINT `events_facilities_ibfk_1` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`facility_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_facilities_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_facilities_ibfk_3` FOREIGN KEY (`funding_id`) REFERENCES `funding` (`funding_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_facilities_ibfk_4` FOREIGN KEY (`funding_id`) REFERENCES `funding` (`funding_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_facilities_ibfk_5` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`facility_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_facilities_ibfk_6` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
