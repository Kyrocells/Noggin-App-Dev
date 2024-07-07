-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2024 at 05:34 AM
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
-- Database: `video_rental_noggin`
--

-- --------------------------------------------------------

--
-- Table structure for table `rented_videos`
--

CREATE TABLE `rented_videos` (
  `rental_id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `renter_name` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `returned` int(1) DEFAULT NULL,
  `video_format` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rented_videos`
--

INSERT INTO `rented_videos` (`rental_id`, `video_id`, `user_id`, `renter_name`, `start_date`, `return_date`, `returned`, `video_format`) VALUES
(29, 23, 9, 'Kelsey Myle Rivera', '2024-07-07', '2024-07-07', 1, 'Blu-ray'),
(30, 23, 9, 'Kelsey Myle Rivera', '2024-07-07', '2024-07-07', 1, 'DVD'),
(31, 23, 9, 'Kelsey Myle Rivera', '2024-07-07', '2024-07-07', 1, 'Blu-ray'),
(32, 23, 9, 'Kelsey Myle Rivera', '2024-07-07', '2024-07-07', 1, 'DVD'),
(33, 23, 9, 'Kelsey Myle Rivera', '2024-07-07', '2024-07-07', 1, 'Blu-ray'),
(34, 23, 9, 'Kelsey Myle Rivera', '2024-07-07', '2024-07-07', 1, 'Blu-ray');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `transaction_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `method_of_payment` varchar(50) DEFAULT NULL,
  `video_format` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`transaction_id`, `date`, `total_price`, `user_id`, `video_id`, `method_of_payment`, `video_format`) VALUES
(25, '2024-07-07', 1055.00, 9, 23, 'Gcash', 'Blu-ray'),
(26, '2024-07-07', 855.00, 9, 23, 'Gcash', 'DVD'),
(27, '2024-07-07', 1055.00, 9, 23, 'Gcash', 'Blu-ray'),
(28, '2024-07-07', 855.00, 9, 23, 'Gcash', 'DVD'),
(29, '2024-07-07', 1055.00, 9, 23, 'Gcash', 'Blu-ray'),
(30, '2024-07-07', 1055.00, 9, 23, 'Gcash', 'Blu-ray');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `admin_rights` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `address`, `city`, `email`, `contact_number`, `profile_picture`, `admin_rights`) VALUES
(8, 'admin', '123', 'kyle', 'de castro', 'quezon city', 'NCR', 'hh.santako@gmail.com', '09398550155', '../img/Mock Interviews with AI.png', NULL),
(9, 'kyro', '123', 'Kelsey Myle', 'Rivera', 'Laguna', 'City', 'tryagain@gmail.com', '09398550155', '../img/Subscription page for job seeker.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL,
  `video_title` varchar(100) NOT NULL,
  `actors` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `release_date` varchar(11) DEFAULT NULL,
  `rental_fee` decimal(10,2) DEFAULT NULL,
  `length` varchar(255) NOT NULL,
  `num_videos_available` int(11) DEFAULT NULL,
  `dvd_stocks` int(11) DEFAULT NULL,
  `bray_stocks` int(11) DEFAULT NULL,
  `digital` int(1) DEFAULT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`video_id`, `video_title`, `actors`, `description`, `genre`, `release_date`, `rental_fee`, `length`, `num_videos_available`, `dvd_stocks`, `bray_stocks`, `digital`, `Image`) VALUES
(23, 'asdas', 'adasdas', 'asdasdasd', 'Comedy', '2323', 555.00, '1:30', 8, 5, 2, 0, '../img/Screenshot 2024-07-02 091058.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rented_videos`
--
ALTER TABLE `rented_videos`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`video_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rented_videos`
--
ALTER TABLE `rented_videos`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rented_videos`
--
ALTER TABLE `rented_videos`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `rented_videos_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`video_id`);

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `transaction_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `transaction_history_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `videos` (`video_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
