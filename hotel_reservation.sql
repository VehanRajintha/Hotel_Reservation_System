-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2024 at 02:46 PM
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
-- Database: `hotel_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@gmail.com', '123', '2024-10-06 05:41:24'),
(8, 'IT23646360@my.sliit.lk', '12345', '2024-10-06 11:05:53'),
(10, 'IT236460@my.sliit.lk', '123', '2024-10-06 11:19:06'),
(11, 'IT23640@my.sliit.lk', '123', '2024-10-06 11:19:16'),
(12, 'vehna@gmail.com', '123', '2024-10-06 11:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL DEFAULT 'Admin',
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `guests` int(11) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `special_requests` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_email`, `reservation_date`, `reservation_time`, `guests`, `venue`, `special_requests`, `created_at`) VALUES
(3, 'IT23646360@my.sliit.lk', '2024-10-10', '03:45:00', 23, 'Venue 3', 'nothing', '2024-10-06 07:13:41'),
(5, 'Admin', '2024-10-09', '13:59:00', 6, 'Venue 3', 'werdew', '2024-10-06 07:28:16'),
(6, 'Admin', '2024-10-03', '15:12:00', 6575, 'Venue 3', '567', '2024-10-06 09:39:28'),
(7, 'IT23646360@my.sliit.lk', '2024-09-29', '07:12:00', 69, 'Venue 3', '..', '2024-10-06 10:40:27'),
(9, 'buddi@gmail.com', '2024-10-09', '20:09:00', 4, 'Venue 1', '1wqdxcW', '2024-10-06 12:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`) VALUES
(4, 'Vehan Rajintha', 'IT23646360@my.sliit.lk', '$2y$10$7y4wHIAuG9K.wneYjHKVHeAAZCMbyKTHDr.YZCxOKgYZDju7Yx/4K');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `capacity` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `name`, `description`, `capacity`, `image_url`) VALUES
(15, 'Grand Ballroom', 'Elegant and spacious, perfect for large weddings and grand celebrations.', 300, 'uploads/v1.jpg'),
(16, 'Garden Terrace', 'Beautiful outdoor setting surrounded by lush gardens and water features.', 150, 'uploads/v2.jpg'),
(17, 'Seaside Pavilion', 'Breathtaking ocean views with a modern, open-air design.', 200, 'uploads/v3.jpg'),
(18, 'Skyline Lounge', 'Chic rooftop venue offering panoramic city views and a sophisticated ambiance.', 100, 'uploads/v4.jpg'),
(19, 'Rustic Barn', 'Charming countryside venue with a cozy and intimate atmosphere.', 120, 'uploads/v5.jpg'),
(20, 'Crystal Hall', 'Luxurious indoor venue with stunning chandeliers and marble floors.', 250, 'uploads/v6.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
