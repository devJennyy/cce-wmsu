-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2024 at 02:38 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cce`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `faculty_role` varchar(255) DEFAULT NULL,
  `identification` varchar(255) DEFAULT NULL,
  `verified` int(11) NOT NULL DEFAULT 1,
  `last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`id`, `firstname`, `middlename`, `lastname`, `username`, `email`, `password`, `mobile`, `img`, `faculty_role`, `identification`, `verified`, `last_login`, `timestamp`) VALUES
(68, 'Claire', NULL, 'Madrazo', 'admin_cce', 'cceadmin@gmail.com', '$2y$10$PHfYMRsPUbDbIWIzyxJOZe0ntIYPpF/jYHoAIk3xyjouz5RNIUS5C', NULL, NULL, 'Administrator', 'CertificateSample.png', 2, '2024-01-24 06:58:46', '2023-10-12 12:11:58'),
(83, 'Jenelyn', '', 'Pieloor', 'jenny', 'jennypieloor.connect@gmail.com', '$2y$10$s6W8/qxHqH83lCiKJSk9NO.rh0/Jn3Uid.JPNNs0vOMI9VMTvJ9su', NULL, NULL, 'CCS', '4322070.jpg', 2, '2023-12-05 01:39:55', '2023-11-21 14:38:12'),
(84, 'Neca', '', 'Parcasio', 'Neca', 'neca@gmail.com', '$2y$10$s7MNNQmAkeyzQajGU/ujCeDiRQvKxyUU.Pe1ZxjGgvyNPcle.Bmta', NULL, NULL, 'CCS', '4322070.jpg', 2, '2023-12-05 01:39:55', '2023-11-21 14:38:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assessment`
--

CREATE TABLE `tbl_assessment` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `option_a` text DEFAULT NULL,
  `option_b` text DEFAULT NULL,
  `option_c` text DEFAULT NULL,
  `option_d` text DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `is_code` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_certificates`
--

CREATE TABLE `tbl_certificates` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `certificate_name` varchar(255) NOT NULL,
  `certificate_from` varchar(255) NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `x_pos` int(11) DEFAULT NULL,
  `y_pos` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `font_style` varchar(255) DEFAULT 'PoppinsSemiBold.ttf',
  `font_size` int(11) DEFAULT NULL,
  `font_weight` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `day` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `slots` int(11) NOT NULL,
  `slots_remaining` int(11) DEFAULT 0,
  `venue` varchar(255) DEFAULT NULL,
  `venue_type` varchar(255) NOT NULL,
  `venue_link` varchar(255) DEFAULT NULL,
  `reminder` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `agenda` mediumtext DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `unique_code` varchar(255) DEFAULT NULL,
  `visibility` int(11) NOT NULL,
  `gcash_number` varchar(255) DEFAULT NULL,
  `gcash_name` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_participants`
--

CREATE TABLE `tbl_event_participants` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Participant',
  `status` varchar(255) NOT NULL DEFAULT 'Invited',
  `type` varchar(255) NOT NULL DEFAULT 'Invited',
  `qr` text DEFAULT NULL,
  `certificate_sent` tinyint(1) NOT NULL DEFAULT 0,
  `attended` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_visibility`
--

CREATE TABLE `tbl_event_visibility` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_event_visibility`
--

INSERT INTO `tbl_event_visibility` (`id`, `status`) VALUES
(1, 'Event is visible and allows registration'),
(2, 'Event is visible but is closed'),
(3, 'Event is not visible for those who are not invited');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faculty_list`
--

CREATE TABLE `tbl_faculty_list` (
  `id` int(11) NOT NULL,
  `faculty_name` varchar(255) NOT NULL,
  `abbreviation` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_faculty_list`
--

INSERT INTO `tbl_faculty_list` (`id`, `faculty_name`, `abbreviation`, `color`) VALUES
(13, 'College of Agriculture', 'CA', '#388E3C'),
(14, 'College of Architecture', 'COA', '#004DCF'),
(15, 'College of Asian and Islamic Studies', 'CAIS', '#FCCB00'),
(16, 'College of Criminal Justice Education', 'CCJE', '#E91E63'),
(17, 'College of Engineering', 'COE', '#167FFC'),
(18, 'College of Forestry and Environmental Studies', 'CFES', '#8BC34A'),
(19, 'College of Home Economics', 'CHE', '#4CAF50'),
(20, 'College of Law', 'COL', '#E57373'),
(21, 'College of Liberal Arts', 'CLA', '#E64A19'),
(22, 'College of Nursing', 'CN', '#607D8B'),
(23, 'College of Public Administration and Development Studies', 'CPADS', '#512DA8'),
(24, 'College of Sport Science and Physical Education', 'CSSPE', '#673AB7'),
(25, 'College of Science and Mathematics', 'CSM', '#FF9800'),
(26, 'College of Social Work and Community Development', 'CSWCD', '#00BCD4'),
(27, 'College of Teacher Education', 'CTE', '#D32F2F'),
(28, 'College of Computing Studies', 'CCS', '#3DBE52'),
(29, 'Center of Continuing Education', 'CCE', '#9C2B23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_organization`
--

CREATE TABLE `tbl_organization` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `org_shortname` varchar(255) NOT NULL,
  `org_logo` text NOT NULL,
  `org_descrip` mediumtext NOT NULL,
  `org_activities` mediumtext NOT NULL,
  `org_mission` mediumtext NOT NULL,
  `org_goal` mediumtext NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_organization_members`
--

CREATE TABLE `tbl_organization_members` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratings`
--

CREATE TABLE `tbl_ratings` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `additional` text DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reschedule_reason`
--

CREATE TABLE `tbl_reschedule_reason` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `additional` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status_list`
--

CREATE TABLE `tbl_status_list` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_status_list`
--

INSERT INTO `tbl_status_list` (`id`, `status`) VALUES
(1, 'Not Verified'),
(2, 'Verified'),
(3, 'Pending'),
(4, 'Paid'),
(5, 'Approved'),
(6, 'Denied'),
(7, 'Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscriptions`
--

CREATE TABLE `tbl_subscriptions` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `initial_name` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `gcash_no` varchar(255) NOT NULL,
  `proof` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 3,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_verified` (`verified`);

--
-- Indexes for table `tbl_assessment`
--
ALTER TABLE `tbl_assessment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_assessment_id` (`event_id`);

--
-- Indexes for table `tbl_certificates`
--
ALTER TABLE `tbl_certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_certid` (`event_id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_event_visibility` (`visibility`),
  ADD KEY `fkc_event_status` (`status`);

--
-- Indexes for table `tbl_event_participants`
--
ALTER TABLE `tbl_event_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_accountid` (`account_id`),
  ADD KEY `fkc_eventid` (`event_id`);

--
-- Indexes for table `tbl_event_visibility`
--
ALTER TABLE `tbl_event_visibility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_faculty_list`
--
ALTER TABLE `tbl_faculty_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_organization`
--
ALTER TABLE `tbl_organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_organization_members`
--
ALTER TABLE `tbl_organization_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_accountid` (`account_id`),
  ADD KEY `c_orgid` (`organization_id`);

--
-- Indexes for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eventid` (`event_id`);

--
-- Indexes for table `tbl_reschedule_reason`
--
ALTER TABLE `tbl_reschedule_reason`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evid` (`event_id`);

--
-- Indexes for table `tbl_status_list`
--
ALTER TABLE `tbl_status_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subscriptions`
--
ALTER TABLE `tbl_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `tbl_assessment`
--
ALTER TABLE `tbl_assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `tbl_certificates`
--
ALTER TABLE `tbl_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_event_participants`
--
ALTER TABLE `tbl_event_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `tbl_event_visibility`
--
ALTER TABLE `tbl_event_visibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_faculty_list`
--
ALTER TABLE `tbl_faculty_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_organization`
--
ALTER TABLE `tbl_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_organization_members`
--
ALTER TABLE `tbl_organization_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `tbl_reschedule_reason`
--
ALTER TABLE `tbl_reschedule_reason`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_status_list`
--
ALTER TABLE `tbl_status_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_subscriptions`
--
ALTER TABLE `tbl_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD CONSTRAINT `fkc_verified` FOREIGN KEY (`verified`) REFERENCES `tbl_status_list` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_assessment`
--
ALTER TABLE `tbl_assessment`
  ADD CONSTRAINT `fkc_assessment_id` FOREIGN KEY (`event_id`) REFERENCES `tbl_events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_certificates`
--
ALTER TABLE `tbl_certificates`
  ADD CONSTRAINT `fkc_certid` FOREIGN KEY (`event_id`) REFERENCES `tbl_events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD CONSTRAINT `fkc_event_status` FOREIGN KEY (`status`) REFERENCES `tbl_status_list` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkc_event_visibility` FOREIGN KEY (`visibility`) REFERENCES `tbl_event_visibility` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_event_participants`
--
ALTER TABLE `tbl_event_participants`
  ADD CONSTRAINT `fkc_accountid` FOREIGN KEY (`account_id`) REFERENCES `tbl_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkc_eventid` FOREIGN KEY (`event_id`) REFERENCES `tbl_events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_organization_members`
--
ALTER TABLE `tbl_organization_members`
  ADD CONSTRAINT `c_accountid` FOREIGN KEY (`account_id`) REFERENCES `tbl_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD CONSTRAINT `eventid` FOREIGN KEY (`event_id`) REFERENCES `tbl_events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_reschedule_reason`
--
ALTER TABLE `tbl_reschedule_reason`
  ADD CONSTRAINT `evid` FOREIGN KEY (`event_id`) REFERENCES `tbl_events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
