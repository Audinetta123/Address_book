-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2017 at 10:11 AM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `address_book`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `street` varchar(25) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `city` varchar(20) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `id_contact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `street`, `postal_code`, `city`, `created_on`, `updated_on`, `id_contact`) VALUES
(1, 'rue victor hugo', 70200, 'Lure', '2017-01-09 06:10:06', '2017-01-13 10:27:30', 2),
(3, 'alfred', 70300, 'St Sauveur', '2017-01-09 09:20:00', '2017-01-10 09:26:38', 3),
(4, 'alfred', 70300, 'St Sauveur', '2017-01-09 09:20:00', '2017-01-10 09:26:38', 4);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `civility` varchar(20) NOT NULL,
  `Surname` varchar(25) NOT NULL,
  `Firstname` varchar(25) NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `civility`, `Surname`, `Firstname`, `date_of_birth`, `created_on`, `updated_on`) VALUES
(2, 'Female', 'Warren', 'Helen', '2016-05-02', '2016-04-13 05:14:25', '2016-02-23 16:17:37'),
(3, 'Male', 'Flores', 'Harry', '2016-09-05', '2016-10-25 05:11:22', '2016-04-06 07:11:20'),
(4, 'Female', 'Mills', 'Margaret', '2016-11-24', '2016-08-24 09:43:42', '2016-02-05 01:01:14'),
(5, 'Female', 'Banks', 'Betty', '2016-03-11', '2016-08-08 04:44:03', '2016-10-14 03:03:07'),
(6, 'Male', 'Stephens', 'Juan', '2016-06-17', '2016-06-05 15:51:33', '2016-11-07 11:10:49'),
(7, 'Male', 'Chapman', 'Scott', '2016-11-27', '2016-04-29 21:11:43', '2016-11-29 06:49:10'),
(8, 'Male', 'Roberts', 'Scott', '2016-06-15', '2016-05-29 18:15:12', '2016-12-15 15:32:58'),
(9, 'Female', 'Patterson', 'Donna', '2016-08-07', '2016-10-17 17:44:33', '2016-06-08 18:17:28'),
(10, 'Male', 'Johnston', 'Benjamin', '2016-08-26', '2016-11-09 00:03:27', '2016-09-19 23:51:29'),
(11, 'Male', 'Montgomery', 'Henry', '2016-08-05', '2016-02-19 08:55:18', '2016-06-18 21:14:32'),
(12, 'Female', 'Powell', 'Wanda', '2016-09-12', '2016-06-10 15:15:55', '2016-08-22 01:14:34'),
(13, 'Female', 'Romero', 'Lois', '2016-06-01', '2016-08-03 14:30:36', '2016-04-07 00:57:50'),
(14, 'Female', 'Fox', 'Kathryn', '2016-02-28', '2016-10-13 00:30:48', '2016-09-26 20:36:52'),
(15, 'Female', 'West', 'Annie', '2016-02-01', '2016-06-10 04:51:42', '2016-12-27 19:23:22'),
(16, 'Male', 'Wilson', 'Terry', '2016-11-19', '2016-04-11 03:56:33', '2016-10-28 14:03:07'),
(17, 'Female', 'Chapman', 'Ann', '2016-07-20', '2016-04-08 17:27:40', '2016-08-31 16:01:47'),
(18, 'Male', 'Tucker', 'Carlos', '2016-05-18', '2016-11-06 20:19:28', '2016-10-07 01:27:27'),
(19, 'Male', 'Thompson', 'Brian', '2016-11-24', '2016-07-14 23:09:26', '2016-04-10 14:54:18'),
(20, 'Female', 'Medina', 'Brenda', '2016-09-16', '2016-10-25 06:07:59', '2016-02-23 20:56:58'),
(21, 'Female', 'Nelson', 'Denise', '2016-12-01', '2016-03-04 15:42:50', '2016-01-15 13:27:06'),
(22, 'Male', 'Shaw', 'Ralph', '2017-01-09', '2016-06-13 07:50:56', '2016-07-29 16:41:01'),
(23, 'Female', 'West', 'Teresa', '2016-10-03', '2016-11-01 02:13:41', '2016-08-01 08:03:04'),
(24, 'Male', 'Olson', 'Todd', '2016-07-28', '2016-09-08 04:57:29', '2016-06-23 14:59:08'),
(25, 'Female', 'Murphy', 'Phyllis', '2016-03-16', '2016-04-16 19:29:27', '2016-06-14 09:24:01'),
(26, 'Female', 'Phillips', 'Sarah', '2016-01-30', '2016-10-02 21:16:35', '2016-05-26 05:14:42'),
(27, 'Female', 'Perry', 'Mary', '2016-08-18', '2016-08-27 12:14:27', '2016-08-03 16:35:23'),
(28, 'Male', 'Simmons', 'Sean', '2016-01-14', '2016-02-10 15:31:21', '2016-08-25 07:18:35'),
(29, 'Female', 'Morris', 'Carol', '2016-03-27', '2016-08-01 08:00:05', '2016-05-05 02:56:23'),
(30, 'Male', 'Scott', 'Aaron', '2016-08-12', '2016-10-28 05:01:42', '2016-08-20 19:00:03'),
(31, 'Male', 'West', 'Clarence', '2016-12-06', '2016-12-28 22:40:15', '2016-01-12 11:55:43'),
(32, 'Female', 'Adams', 'Kathryn', '2016-11-05', '2016-02-03 01:51:37', '2016-12-11 23:17:04'),
(33, 'Male', 'Armstrong', 'Gerald', '2016-04-09', '2016-01-21 13:36:01', '2016-04-24 20:36:45'),
(34, 'Male', 'Gonzalez', 'Jose', '2016-01-25', '2016-02-25 01:04:33', '2016-06-20 20:51:45'),
(35, 'Male', 'Mccoy', 'Jeffrey', '2016-08-12', '2016-07-02 20:02:02', '2016-11-04 04:44:38'),
(36, 'Female', 'Fox', 'Patricia', '2016-02-15', '2016-07-02 09:34:03', '2016-10-16 05:37:43'),
(37, 'Female', 'Dixon', 'Sarah', '2016-11-14', '2016-12-01 05:45:10', '2016-05-25 15:12:32'),
(38, 'Male', 'Fisher', 'Douglas', '2016-03-03', '2016-10-15 05:28:47', '2016-12-06 21:12:55'),
(39, 'Male', 'Wagner', 'Jeffrey', '2016-02-09', '2017-01-08 00:41:14', '2016-11-29 06:50:00'),
(40, 'Male', 'Turner', 'Mark', '2016-06-06', '2016-09-30 05:59:16', '2016-11-21 07:47:21'),
(41, 'Male', 'Ward', 'Andrew', '2016-06-02', '2016-01-22 19:03:42', '2016-01-20 08:41:52'),
(42, 'Female', 'Burns', 'Jane', '2016-03-28', '2016-10-23 14:52:05', '2016-02-10 11:08:40'),
(43, 'Female', 'Collins', 'Judith', '2016-11-03', '2016-11-14 21:21:32', '2016-02-27 12:55:16'),
(44, 'Male', 'Myers', 'Brandon', '2017-01-04', '2016-09-05 11:54:07', '2016-12-21 20:48:57'),
(45, 'Female', 'Holmes', 'Diane', '2016-03-08', '2016-01-27 07:59:37', '2016-11-22 08:49:24'),
(46, 'Male', 'Dunn', 'Eugene', '2016-08-21', '2016-07-13 05:40:47', '2016-06-14 05:43:43'),
(47, 'Male', 'Harvey', 'Joshua', '2016-06-09', '2016-08-07 03:37:01', '2016-07-20 01:03:16'),
(48, 'Male', 'Martinez', 'William', '2016-06-25', '2016-05-20 06:41:18', '2016-01-31 07:08:22'),
(49, 'Female', 'Reed', 'Janice', '2016-03-24', '2016-04-04 08:12:06', '2016-02-17 10:43:31'),
(50, 'Male', 'Jackson', 'Peter', '2016-05-27', '2016-09-27 19:12:09', '2016-08-07 12:11:55'),
(51, 'Female', 'Porter', 'Frances', '2016-01-18', '2016-10-15 01:24:30', '2016-12-12 15:40:05'),
(52, 'Male', 'Brooks', 'Ernest', '2016-04-22', '2016-05-07 22:25:53', '2016-08-24 10:32:57'),
(53, 'Male', 'James', 'Douglas', '2016-05-04', '2016-11-03 18:58:43', '2016-11-08 08:45:36'),
(54, 'Male', 'Stanley', 'Gary', '2016-12-27', '2016-02-06 02:07:25', '2016-10-28 11:05:02'),
(55, 'Male', 'Diaz', 'Johnny', '2016-04-20', '2016-10-12 02:57:00', '2016-05-25 15:33:39'),
(56, 'Male', 'Armstrong', 'Raymond', '2017-01-07', '2016-10-24 11:20:30', '2016-04-10 19:58:27'),
(57, 'Female', 'Ray', 'Ashley', '2016-09-23', '2016-09-15 01:08:38', '2016-05-07 21:59:42'),
(58, 'Female', 'Weaver', 'Ruth', '2016-04-09', '2016-05-04 06:10:32', '2016-07-25 23:38:03'),
(59, 'Female', 'Peters', 'Alice', '2016-09-18', '2016-07-04 10:48:10', '2016-02-23 21:35:30'),
(60, 'Male', 'Riley', 'Billy', '2016-07-09', '2016-01-28 13:57:43', '2016-01-12 10:36:37'),
(61, 'Male', 'Webb', 'Jack', '2016-10-26', '2016-11-10 14:02:24', '2016-03-26 01:00:23'),
(62, 'Female', 'Dunn', 'Alice', '2016-05-25', '2016-01-20 21:51:48', '2016-07-24 00:35:36'),
(63, 'Female', 'Holmes', 'Diane', '2016-06-07', '2016-09-23 13:00:53', '2016-09-10 12:48:40'),
(64, 'Female', 'Carter', 'Linda', '2016-08-10', '2016-09-25 07:04:50', '2016-04-11 21:07:34'),
(65, 'Female', 'Reed', 'Frances', '2016-10-02', '2016-12-23 13:47:35', '2016-10-21 07:38:18'),
(66, 'Male', 'Cole', 'Wayne', '2016-03-03', '2016-09-27 17:44:29', '2016-05-29 13:54:52'),
(67, 'Female', 'Moore', 'Robin', '2016-11-09', '2016-10-08 22:28:45', '2016-10-02 14:52:35'),
(68, 'Male', 'Reynolds', 'Arthur', '2016-05-17', '2016-12-04 12:39:43', '2016-10-17 09:58:23'),
(69, 'Female', 'Hughes', 'Stephanie', '2016-11-23', '2016-03-07 18:38:00', '2016-12-24 04:57:31'),
(70, 'Male', 'Long', 'Nicholas', '2016-09-27', '2016-02-19 22:58:42', '2016-09-03 01:47:42'),
(71, 'Male', 'Hernandez', 'Jonathan', '2016-04-16', '2016-12-12 17:28:33', '2016-11-04 00:29:10'),
(72, 'Male', 'Garza', 'Douglas', '2016-08-23', '2016-11-21 21:48:00', '2016-05-01 08:47:49'),
(73, 'Male', 'Wells', 'William', '2016-10-30', '2016-08-10 20:36:53', '2016-02-10 16:45:11'),
(74, 'Female', 'Stanley', 'Martha', '2016-02-18', '2016-01-28 11:44:29', '2016-06-20 03:13:59'),
(75, 'Male', 'Morris', 'Sean', '2016-02-06', '2016-06-12 11:51:35', '2016-11-24 18:13:01'),
(76, 'Male', 'Hansen', 'Mark', '2016-07-13', '2016-03-31 04:30:39', '2016-05-26 06:36:32'),
(77, 'Female', 'Frazier', 'Lillian', '2016-08-19', '2016-01-12 08:04:52', '2016-04-11 00:45:51'),
(78, 'Female', 'Romero', 'Pamela', '2016-08-16', '2016-03-01 12:25:27', '2016-11-19 01:53:39'),
(79, 'Male', 'Robinson', 'Victor', '2016-07-25', '2016-03-23 09:06:58', '2016-12-24 19:26:11'),
(80, 'Male', 'Simpson', 'Johnny', '2016-08-20', '2016-05-21 16:32:04', '2016-02-15 18:37:19'),
(81, 'Female', 'Carter', 'Joan', '2016-12-25', '2016-07-04 18:37:59', '2017-01-02 10:34:20'),
(82, 'Female', 'Phillips', 'Carol', '2016-01-21', '2016-09-04 16:07:06', '2016-02-28 05:33:32'),
(83, 'Female', 'Ortiz', 'Andrea', '2016-07-21', '2016-05-16 10:23:17', '2016-08-08 13:49:17'),
(84, 'Female', 'Fernandez', 'Janet', '2016-11-29', '2016-02-07 11:41:52', '2016-02-05 12:22:21'),
(85, 'Male', 'Woods', 'Arthur', '2016-08-03', '2016-04-24 05:18:40', '2016-06-26 20:05:10'),
(86, 'Male', 'Vasquez', 'Donald', '2016-09-30', '2016-12-11 05:05:08', '2016-10-02 21:21:12'),
(87, 'Female', 'Wagner', 'Diana', '2016-07-22', '2016-04-10 12:43:08', '2016-03-01 08:01:56'),
(88, 'Male', 'Murphy', 'Charles', '2016-12-15', '2016-11-13 17:10:55', '2016-02-19 17:32:31'),
(89, 'Female', 'Bennett', 'Brenda', '2016-11-24', '2016-06-29 22:56:44', '2016-01-15 20:22:55'),
(90, 'Male', 'Frazier', 'Juan', '2016-01-13', '2016-12-29 02:38:44', '2016-11-23 08:04:04'),
(91, 'Male', 'Elliott', 'Kevin', '2016-08-20', '2016-04-24 07:21:34', '2016-11-20 10:34:05'),
(92, 'Female', 'Davis', 'Kathryn', '2016-10-16', '2016-08-04 00:27:04', '2016-12-15 09:54:52'),
(93, 'Female', 'Fox', 'Margaret', '2016-12-22', '2016-10-06 23:08:00', '2016-07-05 17:00:24'),
(94, 'Male', 'Daniels', 'Justin', '2016-03-06', '2017-01-09 01:06:13', '2016-07-09 11:58:44'),
(95, 'Female', 'Allen', 'Amy', '2016-04-18', '2016-08-24 10:54:55', '2016-09-20 14:16:58'),
(96, 'Male', 'Cruz', 'Timothy', '2016-08-02', '2016-07-09 08:17:23', '2016-09-14 22:44:34'),
(97, 'Male', 'Diaz', 'Roger', '2016-03-26', '2016-05-28 16:01:32', '2016-03-30 05:41:37'),
(98, 'Female', 'Welch', 'Kathleen', '2016-02-17', '2016-11-06 06:27:16', '2016-01-23 02:16:14'),
(99, 'Female', 'Davis', 'Virginia', '2016-06-23', '2016-08-12 06:58:40', '2016-04-07 23:14:21'),
(100, 'Male', 'Thompson', 'Carlos', '2016-08-26', '2016-04-15 01:20:29', '2016-07-25 09:59:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_contact` (`id_contact`),
  ADD KEY `id_contact_2` (`id_contact`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`id_contact`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
