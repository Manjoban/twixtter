-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 11:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `fname`, `lname`, `email`) VALUES
(1, 'msingh1', 'ITr0cks!', 'Manjoban', 'Singh', 'manjobanrehal29@gmail.com'),
(2, 'jkaur', 'ITr0cks!', 'Jashan', 'kaur', 'jk2019@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `posted_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `account_id`, `message`, `posted_date`) VALUES
(1, 1, 'Hello !!!', '2025-04-18 00:56:55'),
(2, 2, 'Manjoban ki haal aa', '2025-04-18 01:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `search_history`
--

CREATE TABLE `search_history` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `search_term` varchar(255) NOT NULL,
  `search_type` enum('posts','users') NOT NULL,
  `searched_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_history`
--

INSERT INTO `search_history` (`id`, `account_id`, `search_term`, `search_type`, `searched_at`) VALUES
(1, 1, 'he', 'posts', '2025-04-18 01:51:25'),
(2, 2, 'he', 'posts', '2025-04-18 01:53:00'),
(3, 2, 'ma', 'users', '2025-04-18 01:53:08'),
(4, 2, 'ms', 'users', '2025-04-18 01:53:16'),
(5, 1, 'h', 'posts', '2025-04-18 01:53:55'),
(6, 1, 'haal', 'posts', '2025-04-18 01:54:04'),
(7, 1, 'm', 'posts', '2025-04-18 02:25:03'),
(8, 1, 'm', 'posts', '2025-04-18 02:28:06'),
(9, 2, 'n', 'posts', '2025-04-18 16:24:50'),
(10, 2, 'n', 'users', '2025-04-18 16:24:58'),
(11, 2, 'n', 'users', '2025-04-18 16:32:39'),
(12, 2, 's', 'users', '2025-04-18 16:32:52'),
(13, 2, 'k', 'users', '2025-04-18 16:33:02'),
(14, 2, 'haal', 'posts', '2025-04-18 16:41:54'),
(15, 1, 'N', 'users', '2025-04-18 16:42:46'),
(16, 1, 'N', 'posts', '2025-04-18 16:59:01'),
(17, 1, 'N', 'posts', '2025-04-18 17:01:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_account_post` (`account_id`);

--
-- Indexes for table `search_history`
--
ALTER TABLE `search_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `search_history`
--
ALTER TABLE `search_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_account_post` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `search_history`
--
ALTER TABLE `search_history`
  ADD CONSTRAINT `search_history_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
