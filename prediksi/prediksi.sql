-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 15, 2024 at 06:12 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prediksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `dataset_risma`
--

CREATE TABLE `dataset_risma` (
  `data_id` int NOT NULL,
  `tugas` varchar(5) DEFAULT NULL,
  `uts` varchar(5) DEFAULT NULL,
  `uas` varchar(5) DEFAULT NULL,
  `ketidakhadiran` varchar(15) DEFAULT NULL,
  `ekskul` varchar(5) DEFAULT NULL,
  `class` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(15) NOT NULL,
  `password` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dataset_risma`
--

INSERT INTO `dataset_risma` (`data_id`, `tugas`, `uts`, `uas`, `ketidakhadiran`, `ekskul`, `class`) VALUES
(1, '70-80', '> 80', '> 80', 'Kurang dari 3', 'B', 'Naik'),
(2, '< 70', '70-80', '70-80', 'Kurang dari 3', 'B', 'Naik'),
(3, '70-80', '70-80', '70-80', 'Kurang dari 3', 'B', 'Naik'),
(4, '> 80', '> 80', '> 80', 'Kurang dari 3', 'A', 'Naik'),
(5, '< 70', '70-80', '< 70', 'Lebih dari 3', 'A', 'Tidak Naik'),
(6, '70-80', '> 80', '> 80', 'Kurang dari 3', 'B', 'Naik'),
(7, '70-80', '> 80', '70-80', 'Kurang dari 3', 'A', 'Naik'),
(8, '70-80', '< 70', '< 70', 'Lebih dari 3', 'C', 'Tidak Naik'),
(9, '70-80', '> 80', '> 80', 'Kurang dari 3', 'B', 'Naik'),
(10, '70-80', '> 80', '70-80', 'Kurang dari 3', 'A', 'Naik'),
(11, '> 80', '> 80', '< 70', 'Kurang dari 3', 'B', 'Naik'),
(12, '70-80', '> 80', '70-80', 'Kurang dari 3', 'C', 'Naik'),
(13, '70-80', '> 80', '70-80', 'Kurang dari 3', 'C', 'Naik'),
(14, '70-80', '> 80', '70-80', 'Kurang dari 3', 'B', 'Naik'),
(15, '70-80', '< 70', '< 70', 'Lebih dari 3', 'B', 'Tidak Naik'),
(16, '70-80', '> 80', '< 70', 'Kurang dari 3', 'C', 'Naik'),
(17, '70-80', '> 80', '70-80', 'Kurang dari 3', 'A', 'Naik'),
(18, '70-80', '> 80', '< 70', 'Kurang dari 3', 'B', 'Naik'),
(19, '> 80', '> 80', '> 80', 'Kurang dari 3', 'A', 'Naik'),
(20, '> 80', '> 80', '> 80', 'Kurang dari 3', 'B', 'Naik'),
(21, '> 80', '> 80', '> 80', 'Kurang dari 3', 'B', 'Naik'),
(22, '70-80', '> 80', '> 80', 'Kurang dari 3', 'B', 'Naik'),
(23, '< 70', '70-80', '< 70', 'Lebih dari 3', 'C', 'Tidak Naik'),
(24, '70-80', '> 80', '70-80', 'Kurang dari 3', 'C', 'Naik'),
(25, '70-80', '70-80', '70-80', 'Kurang dari 3', 'C', 'Naik'),
(26, '70-80', '> 80', '> 80', 'Kurang dari 3', 'B', 'Naik'),
(27, '70-80', '> 80', '70-80', 'Lebih dari 3', 'A', 'Naik'),
(28, '70-80', '> 80', '> 80', 'Kurang dari 3', 'B', 'Naik'),
(29, '> 80', '70-80', '> 80', 'Kurang dari 3', 'B', 'Naik'),
(30, '70-80', '> 80', '70-80', 'Kurang dari 3', 'C', 'Naik');

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dataset_risma`
--
ALTER TABLE `dataset_risma`
  ADD PRIMARY KEY (`data_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dataset_risma`
--
ALTER TABLE `dataset_risma`
  MODIFY `data_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
