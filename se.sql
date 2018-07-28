-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2018 at 03:43 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 5.6.36-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `se`
--

-- --------------------------------------------------------

--
-- Table structure for table `se_users`
--

CREATE TABLE `se_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `data` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `se_users`
--

INSERT INTO `se_users` (`id`, `name`, `password`, `email`, `data`, `updated_at`, `created_at`) VALUES
(1, 'root', 'root', 'psofttech123@gmail.com', '{"watchlist":{"PCJEWELLER":"PCJEWELLER-PC Jeweller Limited","VAKRANGEE":"VAKRANGEE-Vakrangee Limited","BANDHANBNK":"BANDHANBNK-Bandhan Bank Limited","PHILIPCARB":"PHILIPCARB-Phillips Carbon Black Limited","GOACARBON":"GOACARBON-Goa Carbon Limited"},"portfolio":{"PCJEWELLER":"PCJEWELLER- PC Jeweller Limited"}}', '2018-06-09 16:40:17', '2018-06-09 16:40:17'),
(3, 'admin', 'admin', 'admin', '{"watchlist":{"PHILIPCARB":"PHILIPCARB- Phillips Carbon Black Limited","PCJEWELLER":"PCJEWELLER- PC Jeweller Limited"},"portfolio":{"PCJEWELLER":"PCJEWELLER- PC Jeweller Limited"}}', '2018-06-09 17:25:01', '2018-06-09 17:25:01'),
(4, 'test', 'test', 'test@gmail.com', '{"watchlist":{"PCJEWELLER":"PCJEWELLER-PC Jeweller Limited","AIFL":"AIFL-Ashapura Intimates Fashion Limited","PHILIPCARB":"PHILIPCARB-Phillips Carbon Black Limited"}}', '2018-06-23 18:15:59', '2018-06-23 18:15:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `se_users`
--
ALTER TABLE `se_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `se_users`
--
ALTER TABLE `se_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
