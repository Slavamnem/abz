-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 09, 2018 at 12:25 AM
-- Server version: 5.6.38
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TestTask`
--

-- --------------------------------------------------------

--
-- Table structure for table `father_name`
--

CREATE TABLE `father_name` (
  `id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `father_name`
--

INSERT INTO `father_name` (`id`, `gender`, `value`) VALUES
(1, 'Male', 'Александрович'),
(2, 'Male', 'Петрович'),
(3, 'Male', 'Сергеевич'),
(4, 'Male', 'Дмитриевич'),
(5, 'Male', 'Андреевич'),
(6, 'Male', 'Валерьевич'),
(7, 'Male', 'Семенович'),
(8, 'Male', 'Аркадиевич'),
(9, 'Male', 'Борисович'),
(10, 'Male', 'Константинович'),
(11, 'Female', 'Петровна'),
(12, 'Female', 'Сергеевна'),
(13, 'Female', 'Александровна'),
(14, 'Female', 'Дмитриевна'),
(15, 'Female', 'Андреевна'),
(16, 'Female', 'Семеновна'),
(17, 'Female', 'Григорьевна'),
(18, 'Female', 'Васильевна'),
(19, 'Female', 'Николаевна'),
(20, 'Female', 'Викторовна');

-- --------------------------------------------------------

--
-- Table structure for table `first_name`
--

CREATE TABLE `first_name` (
  `id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `first_name`
--

INSERT INTO `first_name` (`id`, `gender`, `value`) VALUES
(1, 'Male', 'Сергей'),
(2, 'Male', 'Олег'),
(3, 'Male', 'Александр'),
(4, 'Male', 'Василий'),
(5, 'Male', 'Максим'),
(6, 'Male', 'Андрей'),
(7, 'Male', 'Петр'),
(8, 'Male', 'Иван'),
(9, 'Male', 'Константин'),
(10, 'Male', 'Дмитрий'),
(11, 'Female', 'Ольга'),
(12, 'Female', 'Лариса'),
(13, 'Female', 'Анастасия'),
(14, 'Female', 'Анна'),
(15, 'Female', 'Наталья'),
(16, 'Female', 'Марина'),
(17, 'Female', 'Светлана'),
(18, 'Female', 'Юлия'),
(19, 'Female', 'Лена'),
(20, 'Female', 'Татьяна');

-- --------------------------------------------------------

--
-- Table structure for table `hierarchy`
--

CREATE TABLE `hierarchy` (
  `id` int(11) NOT NULL,
  `post` varchar(255) NOT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `last_name`
--

CREATE TABLE `last_name` (
  `id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `last_name`
--

INSERT INTO `last_name` (`id`, `gender`, `value`) VALUES
(1, 'Male', 'Иванов'),
(2, 'Male', 'Смирнов'),
(3, 'Male', 'Кузнецов'),
(4, 'Male', 'Скворцов'),
(5, 'Male', 'Семенов'),
(6, 'Male', 'Васильев'),
(7, 'Male', 'Соколов'),
(8, 'Male', 'Михайлов'),
(9, 'Male', 'Новиков'),
(10, 'Male', 'Федоров'),
(11, 'Female', 'Прасолова'),
(12, 'Female', 'Максимова'),
(13, 'Female', 'Прокопенко'),
(14, 'Female', 'Нестерчук'),
(15, 'Female', 'Васильева'),
(16, 'Female', 'Петрова'),
(17, 'Female', 'Федорова'),
(18, 'Female', 'Соколова'),
(19, 'Female', 'Михайлова'),
(20, 'Female', 'Новикова');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `post` varchar(255) NOT NULL,
  `employment_start` date DEFAULT NULL,
  `salary` double DEFAULT NULL,
  `chief_id` int(11) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `father_name`
--
ALTER TABLE `father_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `first_name`
--
ALTER TABLE `first_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hierarchy`
--
ALTER TABLE `hierarchy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `last_name`
--
ALTER TABLE `last_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `father_name`
--
ALTER TABLE `father_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `first_name`
--
ALTER TABLE `first_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hierarchy`
--
ALTER TABLE `hierarchy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `last_name`
--
ALTER TABLE `last_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
