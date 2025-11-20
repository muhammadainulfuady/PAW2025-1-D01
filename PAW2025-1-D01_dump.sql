-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2025 at 03:03 PM
-- Server version: 8.0.30
-- PHP Version: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `USERNAME_SISWA` varchar(100) NOT NULL,
  `NAMA_LENGKAP_SISWA` varchar(30) DEFAULT NULL,
  `FOTO_SISWA` varchar(20) DEFAULT NULL,
  `PASSWORD_SISWA` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`USERNAME_SISWA`, `NAMA_LENGKAP_SISWA`, `FOTO_SISWA`, `PASSWORD_SISWA`) VALUES
('AinulFuady24', 'Muhammad Ainul Fuady', '691e71729fece.jpg', 'ea1907de8478edf88bcb9860c4b715dd'),
('AinulFuady26', 'Muhammad Ainul Fuady', '691f28c71d81e.jpg', 'e0beee608131945bbed276d62c29074d'),
('Akuadi34', 'Muhammad Ainul Fuady', 'default.jpg', 'c5f91f2ba500b47f2c6a2346eac75258'),
('SayaAdigtg', 'Muhammad Ainul Fuady', 'default.jpg', '6560dff47accb58ed6972d53471234ea');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`USERNAME_SISWA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
