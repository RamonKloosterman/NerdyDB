-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2022 at 12:24 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nerdygadgets`
--

-- --------------------------------------------------------

--
-- Table structure for table `webitemcomments`
--

CREATE TABLE `webitemcomments` (
  `commentID` int(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` int(2) NOT NULL,
  `stockItemID` int(255) NOT NULL,
  `webCustomerID` int(255) NOT NULL,
  `currentTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webitemcomments`
--

INSERT INTO `webitemcomments` (`commentID`, `comment`, `rating`, `stockItemID`, `webCustomerID`, `currentTimestamp`) VALUES
(1, 'anonnnn', 2, 150, 0, '2022-12-21 19:07:24'),
(2, 'test', 3, 138, 0, '2022-12-21 19:07:34'),
(3, 'inhgelgod', 4, 220, 1, '2022-12-21 19:08:08'),
(4, 'ayo', 3, 16, 1, '2022-12-21 19:08:46'),
(5, 'ayo', 3, 16, 1, '2022-12-21 19:09:56'),
(6, 'ayo', 3, 16, 1, '2022-12-21 19:17:10'),
(7, 'test', 4, 1, 1, '2022-12-22 10:42:36'),
(8, 'test', 3, 1, 0, '2022-12-22 10:42:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `webitemcomments`
--
ALTER TABLE `webitemcomments`
  ADD PRIMARY KEY (`commentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `webitemcomments`
--
ALTER TABLE `webitemcomments`
  MODIFY `commentID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
