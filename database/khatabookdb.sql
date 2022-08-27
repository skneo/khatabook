-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2022 at 05:00 AM
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
-- Database: `khatabookdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `enjoyers`
--

CREATE TABLE `enjoyers` (
  `username` varchar(32) NOT NULL,
  `password` varchar(256) NOT NULL,
  `pwdChangeOn` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `login_ip` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enjoyers`
--

INSERT INTO `enjoyers` (`username`, `password`, `pwdChangeOn`, `last_login`, `login_ip`) VALUES
('user', '$2y$10$ApSty6PmbAhmdghAdeN2QO7KQN.noOZjA9/seO1Kzwhgwu2GxVz7q', '2022-08-27 08:28:19', '2022-08-27 08:29:47', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `khatabook_all_cust`
--

CREATE TABLE `khatabook_all_cust` (
  `cust_name` varchar(64) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `khatabook_statements`
--

CREATE TABLE `khatabook_statements` (
  `trans_id` int(11) NOT NULL,
  `cust_name` varchar(64) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `remark` varchar(128) DEFAULT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enjoyers`
--
ALTER TABLE `enjoyers`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `khatabook_all_cust`
--
ALTER TABLE `khatabook_all_cust`
  ADD PRIMARY KEY (`cust_name`);

--
-- Indexes for table `khatabook_statements`
--
ALTER TABLE `khatabook_statements`
  ADD PRIMARY KEY (`trans_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
