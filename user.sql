-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2022 at 12:00 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_auth_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` enum('admin','client') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`, `role`) VALUES
(2, 'rim3332a', 'mmmmm', 'rimaaaaaa@riiima.com', '$2y$10$3fEub1qllRl1HBZ4e7Nf2.5ARjQC3bvhTc6ULitr/W3wjCKdcNyw2', 'admin'),
(4, 'walid', 'walid', 'walid@walid.com', '$2y$10$UKPRQmEBE4qDzeI717elxO8Axhy871zYFnbY.Ldhlu3NHD1F9uj0e', 'admin'),
(5, 'said', 'said', 'said@said.com', '$2y$10$IbNmJFX7XtVGhR3ZOUEgbO8ZFKH8rCJnokRk8aQWX7X7RoMriy.e.', 'client'),
(6, 'nizar', 'nizar', 'nizar@nizar.com', '$2y$10$g8d2MUKD1/7ILPZ0u5YYx.AufMxWfX78OcItCz1DJgT0xVBqGBGqe', 'client'),
(7, 'samir', 'samir', 'samir@samir.com', '$2y$10$3KiPAObmb7qTzSD0ofXm2.T1/m5gJmm.kl7nWLm8.iPqNY/jRL3ue', 'client'),
(8, 'houda', 'houda', 'houda@houda.com', '$2y$10$EscLPlbU6GAuaz9j2nJD0O9pwROAo4q/ffcJybRKEohfPNYR1vgd2', 'admin'),
(9, 'sana', 'sana', 'sana@sana.com', '$2y$10$ShMZKXPXocBvaGpqKGRk8uwFlAdOR538s5kTng.dt2cnyG0xe8bFG', 'client'),
(10, 'ali', 'ali', 'ali@ali.com', '$2y$10$vgaWOQFsutPRXdfDkmjZbOdis8AKG/3xxh50eUEB0tPoQpyVkhvje', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
