-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2023 at 08:52 AM
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
-- Database: `vravylxq_apu`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_id` int(11) NOT NULL,
  `donor_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `donation_amount` int(11) DEFAULT NULL,
  `platform_fee` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `currency` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_id`, `donor_id`, `event_id`, `donation_amount`, `platform_fee`, `transaction_id`, `status`, `currency`) VALUES
(1, 3, 24, 450, 50, 0, 'Processing', 'BDT'),
(2, 2, 1, 1800, 200, 0, 'Processing', 'BDT'),
(3, 2, 26, 1800, 200, 0, 'Processing', 'BDT'),
(4, 3, 20, 450, 50, 0, 'Processing', 'BDT');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `user_type` int(2) NOT NULL DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `user_name`, `password`, `user_type`) VALUES
(1, 'admin@gmail.com', 'admin', '25d55ad283aa400af464c76d713c07ad', 4);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `donor_id` int(11) NOT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `user_type` int(11) DEFAULT 2,
  `address` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `account_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`donor_id`, `user_name`, `email`, `mobile`, `user_type`, `address`, `password`, `account_status`) VALUES
(2, 'Limon', 'limon@gmail.com', '01797856943', 2, 'gdsgsg', 'c42e2708b7b60ff89f54a4dcc76d301c', 1),
(3, 'limonroy', 'limonroy.19cse013@gmail.com', '01521570320', 2, 'dhaka', 'c42e2708b7b60ff89f54a4dcc76d301c', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `e_name` varchar(250) DEFAULT NULL,
  `e_type` varchar(250) DEFAULT NULL,
  `e_organizer` varchar(250) DEFAULT NULL,
  `e_location` mediumtext DEFAULT NULL,
  `e_image` varchar(250) DEFAULT NULL,
  `e_description` text DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `total_volunteer` int(11) DEFAULT NULL,
  `e_start` timestamp NULL DEFAULT NULL,
  `e_end` timestamp NULL DEFAULT NULL,
  `event_status` int(11) DEFAULT 0,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `e_name`, `e_type`, `e_organizer`, `e_location`, `e_image`, `e_description`, `priority`, `total_volunteer`, `e_start`, `e_end`, `event_status`, `status`) VALUES
(1, 'event one', 'event type name', '32', 'fsfds', 'IMG-6450d6a2ebc29.jpg', 'fsdfdsf', 3, NULL, '2023-04-30 18:00:00', '2023-05-15 18:00:00', 2, 1),
(3, 'Plant trees', 'Planting', '35', 'Chawkbazar', 'IMG-6456846d0f31d.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, '2023-05-24 00:00:00', '2023-05-30 00:00:00', NULL, NULL),
(4, 'Bijoy Dibosh Celebration', 'Celebration', '35', 'CRB', 'IMG-64568576c46f6.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, '2023-12-16 00:00:00', '2023-05-16 00:00:00', 2, 1),
(6, 'Meal giving to orphan', 'Meal giving', '35', 'Bayejid bostami orphanage', 'IMG-6456898ec3319.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, '2023-05-17 00:00:00', '2023-05-18 00:00:00', NULL, NULL),
(8, 'Buy cloths for underprevileged children', 'Cloths buying', '35', 'Bandarban', 'IMG-64568b3049f26.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, '2023-05-30 00:00:00', '2023-06-06 00:00:00', 2, 1),
(9, 'An event in hill track', 'One day meal', '35', 'Bandarban', 'IMG-64568c904a150.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, '2023-07-06 00:00:00', '2023-07-14 00:00:00', NULL, NULL),
(10, 'Share your iftar', 'Iftar mahfil', '35', 'CRB', 'IMG-64568da31ecb8.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, '2023-05-31 00:00:00', '2023-06-14 00:00:00', NULL, NULL),
(12, 'Our mother language day celebration', 'Celebration', '35', 'CRB', 'IMG-64568f71a4338.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, '2024-02-18 00:00:00', '2023-05-21 00:00:00', 2, 1),
(15, 'Get together of member', 'Get together', '35', 'Sitakunda', 'IMG-64568ff60ab47.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, '2023-06-01 00:00:00', '2023-06-01 00:00:00', 2, 1),
(16, 'Help flood infected people', 'Release', '35', 'Sylhet', 'IMG-645690ddd3946.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, NULL, '2023-05-17 00:00:00', '2023-06-15 00:00:00', 2, 1),
(17, 'sylhet bornna', 'Climate change', '32', 'aa', 'IMG-6456aaf8c4aaa.png', 'aa', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(18, 'das', 'dasd', '32', 'fsdf', 'IMG-6456b5fff0435.png', 'fafas', NULL, NULL, '2023-05-10 00:00:00', '2023-05-31 00:00:00', 2, 1),
(19, 'event two', 'sfsdf', '32', 'fdsfs', 'IMG-645a863e44a19.png', 'fdsfsf', NULL, NULL, '2023-05-09 18:00:00', '2023-05-16 18:00:00', NULL, NULL),
(20, 'New Event', 'fsdfsf', '32', 'fdsfs', 'IMG-645b288a6b0d3.png', 'fdsfs', 1, NULL, '2023-05-10 18:00:00', '2023-05-17 18:00:00', 2, 1),
(21, 'new 2', 'faf', '32', 'fafa', 'IMG-645b28b23d28c.png', 'fasfas', 3, NULL, '2023-05-19 18:00:00', '2023-05-31 18:00:00', NULL, NULL),
(22, 'fafafsa', 'Celebration', '32', 'asfaf', 'IMG-645b3db42b3e3.png', 'fafaf', 3, NULL, '2023-05-10 18:00:00', '2023-05-22 18:00:00', 2, 1),
(23, 'new new', 'Education', '32', 'new location', 'IMG-646078425b597.png', 'dfhdhdh', 3, NULL, '2023-05-15 18:00:00', '2023-05-30 18:00:00', 2, 1),
(24, 'Limon new Event', 'Education', '1', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3673.5222100882493!2d89.81439947591852!3d22.96781691836814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39ffe84dce5c576d%3A0xcd97ddce2afaf407!2sBSMRSTU%20Library!5e0!3m2!1sen!2sbd!4v1688705301348!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'IMG-64a799d73fcc6.jpg', 'Book fair', 2, 1, '2023-07-09 18:00:00', '2023-08-09 18:00:00', 3, 1),
(25, 'bada', 'Education', '1', 'fasa', 'IMG-64a7bb72d2699.jpg', 'dasda', 2, 12, '2023-07-25 18:00:00', '2023-08-02 18:00:00', 3, 1),
(26, 'notification event', 'Education', '1', 'dhaka,bangladesh', 'IMG-64a8596f500dc.jpg', 'good event', 2, 100, '2023-07-13 18:00:00', '2023-07-27 18:00:00', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_cost`
--

CREATE TABLE `event_cost` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `cost_text` varchar(250) DEFAULT NULL,
  `cost_amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_cost`
--

INSERT INTO `event_cost` (`id`, `event_id`, `cost_text`, `cost_amount`) VALUES
(1, 18, '', 0),
(2, 18, 'Travel Cost', 15000),
(3, 1, 'Travel Cost', 50000),
(4, 1, 'Packet', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `event_organizer`
--

CREATE TABLE `event_organizer` (
  `organizer_id` int(11) NOT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `organization_name` varchar(250) NOT NULL,
  `user_type` int(2) NOT NULL DEFAULT 3,
  `password` varchar(250) DEFAULT NULL,
  `account_status` int(11) DEFAULT 0,
  `experience` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_organizer`
--

INSERT INTO `event_organizer` (`organizer_id`, `user_name`, `email`, `mobile`, `address`, `organization_name`, `user_type`, `password`, `account_status`, `experience`) VALUES
(1, 'limon ray', 'limonroy.19cse013@gmail.com', '01797856948', 'Tetulia,Panchagarh,Rangpur,Dhaka', 'DevLimon', 3, 'c42e2708b7b60ff89f54a4dcc76d301c', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_review`
--

CREATE TABLE `event_review` (
  `id` int(11) NOT NULL,
  `by_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `review` int(11) DEFAULT NULL,
  `review_text` varchar(250) DEFAULT NULL,
  `review_status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_review`
--

INSERT INTO `event_review` (`id`, `by_id`, `event_id`, `review`, `review_text`, `review_status`, `created_at`, `user_type`) VALUES
(6, 5, 24, 4, 'Good', 0, '2023-07-16 20:21:09', 1),
(7, 2, 26, 5, 'abal event', 1, '2023-07-16 20:55:07', 2),
(8, 2, 26, 4, 'good event', 1, '2023-07-16 20:58:35', 2),
(9, 3, 24, 5, 'Good product', 1, '2023-07-17 05:26:56', 2);

-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE `event_type` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_type`
--

INSERT INTO `event_type` (`id`, `name`) VALUES
(14, 'Celebration'),
(4, 'Education'),
(8, 'Fitra'),
(11, 'Helping hand'),
(2, 'Orphan'),
(15, 'Others'),
(13, 'Outing'),
(12, 'Picnic'),
(9, 'Planting'),
(3, 'Poor'),
(6, 'Qurban'),
(5, 'Ramadan'),
(10, 'Recycling '),
(1, 'Underprivileged'),
(7, 'Zakat');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `notification_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `event_id`, `user_id`, `user_type`, `notification_status`) VALUES
(3, 26, 5, 1, 2),
(4, 26, 6, 1, 0),
(5, 26, 2, 2, 1),
(6, 26, 3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `participator`
--

CREATE TABLE `participator` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`id`, `name`) VALUES
(1, 'Writing'),
(2, 'Riding'),
(3, 'Swimming '),
(4, 'Crafting'),
(5, 'Finance'),
(6, 'It/Web'),
(7, 'Others ');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `volunteer_id` int(11) NOT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `user_type` int(2) NOT NULL DEFAULT 1,
  `address` text DEFAULT NULL,
  `password` varchar(250) NOT NULL,
  `account_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`volunteer_id`, `user_name`, `email`, `mobile`, `user_type`, `address`, `password`, `account_status`) VALUES
(5, 'Limon', 'limon@gmail.com', '01797856948', 1, 'Dhaka', 'c42e2708b7b60ff89f54a4dcc76d301c', 1),
(6, 'limonray', 'limonroy.19cse013@gmail.com', '01797856941', 1, 'Dhaka', 'e10adc3949ba59abbe56e057f20f883e', 1);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_interest`
--

CREATE TABLE `volunteer_interest` (
  `interest_id` int(11) NOT NULL,
  `volunteer_id` int(11) DEFAULT NULL,
  `event_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_interest`
--

INSERT INTO `volunteer_interest` (`interest_id`, `volunteer_id`, `event_type_id`) VALUES
(1, 5, 4),
(2, 5, 11),
(3, 5, 12),
(4, 5, 9),
(5, 6, 14),
(6, 6, 2),
(7, 6, 12),
(8, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_skill`
--

CREATE TABLE `volunteer_skill` (
  `vskill_id` int(11) NOT NULL,
  `volunteer_id` int(11) DEFAULT NULL,
  `skill_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_skill`
--

INSERT INTO `volunteer_skill` (`vskill_id`, `volunteer_id`, `skill_id`) VALUES
(1, 5, 5),
(2, 5, 6),
(3, 6, 1),
(4, 6, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`),
  ADD UNIQUE KEY `enail` (`email`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`donor_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_cost`
--
ALTER TABLE `event_cost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_organizer`
--
ALTER TABLE `event_organizer`
  ADD PRIMARY KEY (`organizer_id`),
  ADD UNIQUE KEY `organizer_id` (`organizer_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `event_review`
--
ALTER TABLE `event_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_type`
--
ALTER TABLE `event_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `participator`
--
ALTER TABLE `participator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`volunteer_id`),
  ADD UNIQUE KEY `volunteer_id` (`volunteer_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `volunteer_interest`
--
ALTER TABLE `volunteer_interest`
  ADD PRIMARY KEY (`interest_id`),
  ADD KEY `volunteer_id` (`volunteer_id`),
  ADD KEY `event_type_id` (`event_type_id`);

--
-- Indexes for table `volunteer_skill`
--
ALTER TABLE `volunteer_skill`
  ADD PRIMARY KEY (`vskill_id`),
  ADD KEY `volunteer_id` (`volunteer_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `event_cost`
--
ALTER TABLE `event_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_organizer`
--
ALTER TABLE `event_organizer`
  MODIFY `organizer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_review`
--
ALTER TABLE `event_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `event_type`
--
ALTER TABLE `event_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `participator`
--
ALTER TABLE `participator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `volunteer_interest`
--
ALTER TABLE `volunteer_interest`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `volunteer_skill`
--
ALTER TABLE `volunteer_skill`
  MODIFY `vskill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `volunteer_interest`
--
ALTER TABLE `volunteer_interest`
  ADD CONSTRAINT `volunteer_interest_ibfk_1` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteer` (`volunteer_id`),
  ADD CONSTRAINT `volunteer_interest_ibfk_2` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`id`);

--
-- Constraints for table `volunteer_skill`
--
ALTER TABLE `volunteer_skill`
  ADD CONSTRAINT `volunteer_skill_ibfk_1` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteer` (`volunteer_id`),
  ADD CONSTRAINT `volunteer_skill_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
