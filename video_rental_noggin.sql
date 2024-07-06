-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 05:07 PM
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
  `returned` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rented_videos`
--

INSERT INTO `rented_videos` (`rental_id`, `video_id`, `user_id`, `renter_name`, `start_date`, `return_date`, `returned`) VALUES
(14, 15, 8, 'kyle de castro', '2024-07-06', '2024-07-08', 1),
(15, 16, 8, 'kyle de castro', '2024-07-06', '2024-07-09', 0);

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
  `method_of_payment` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`transaction_id`, `date`, `total_price`, `user_id`, `video_id`, `method_of_payment`) VALUES
(13, '2024-07-06', 200.00, 8, 15, 'Card'),
(14, '2024-07-06', 1500.00, 8, 16, 'Gcash');

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
(8, 'admin', '123', 'kyle', 'de castro', 'quezon city', 'NCR', 'hh.santako@gmail.com', '09398550155', '../img/447594959_811695147284411_7219273012520996506_n.jpg', NULL);

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
  `video_format` varchar(50) DEFAULT NULL,
  `release_date` varchar(11) DEFAULT NULL,
  `rental_fee` decimal(10,2) DEFAULT NULL,
  `num_videos_available` int(11) DEFAULT NULL,
  `length` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`video_id`, `video_title`, `actors`, `description`, `genre`, `video_format`, `release_date`, `rental_fee`, `num_videos_available`, `length`, `Image`) VALUES
(15, 'Kyro the 3rd', 'WUWUWU', 'wqeqwewq', 'Action', 'DVD', '2024', 100.00, 0, '1:40', '../img/Subscription page for job seeker.png'),
(16, 'UWUWU', 'wewew', 'qweqw', 'Drama', 'Blu-ray', '2021', 500.00, 9, '1:30', '../img/MacBook Pro 14_ - 1.png');

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
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
