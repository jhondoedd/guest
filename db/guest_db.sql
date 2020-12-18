-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2020 at 07:47 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `guest_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_guest`
--

CREATE TABLE `m_guest` (
  `guest_name` varchar(100) DEFAULT '',
  `guest_addr` text DEFAULT NULL,
  `guest_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_guest`
--
ALTER TABLE `m_guest` ADD FULLTEXT KEY `m_guest_idx1` (`guest_name`);
ALTER TABLE `m_guest` ADD FULLTEXT KEY `m_guest_idx2` (`guest_addr`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
