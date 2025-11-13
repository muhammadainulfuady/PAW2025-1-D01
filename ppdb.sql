-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2025 at 11:27 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID_ADMIN` int NOT NULL,
  `NAMA_ADMIN` varchar(255) DEFAULT NULL,
  `USERNAME_ADMIN` varchar(255) DEFAULT NULL,
  `PASSWORD_ADMIN` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID_ADMIN`, `NAMA_ADMIN`, `USERNAME_ADMIN`, `PASSWORD_ADMIN`) VALUES
(1, 'Admin PPDB', 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE `dokumen` (
  `ID_DOKUMEN` int NOT NULL,
  `ID_PENDAFTARAN` int DEFAULT NULL,
  `KETERANGAN` varchar(255) DEFAULT NULL,
  `JENIS_DOKUMEM` varchar(255) DEFAULT NULL,
  `PATH_FILE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `ID_JURUSAN` int NOT NULL,
  `NAMA_JURUSAN` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `ID_PENDAFTARAN` int NOT NULL,
  `NISN_SISWA` varchar(255) DEFAULT NULL,
  `ID_JURUSAN` int DEFAULT NULL,
  `TANGGAL_PENDAFTARAN` varchar(255) DEFAULT NULL,
  `NAMA_WALI` varchar(255) DEFAULT NULL,
  `NO_HP_WALI` varchar(255) DEFAULT NULL,
  `STATUS` varchar(255) DEFAULT NULL,
  `JURUSAN` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `NISN_SISWA` varchar(255) NOT NULL,
  `NAMA_LENGKAP_SISWA` varchar(255) DEFAULT NULL,
  `ALAMAT_SISWA` varchar(255) DEFAULT NULL,
  `TANGGAL_LAHIR_SISWA` date DEFAULT NULL,
  `JENIS_KELAMIN_SISWA` varchar(255) DEFAULT NULL,
  `NO_TELPON_SISWA` varchar(255) DEFAULT NULL,
  `FOTO_SISWA_SISWA` varchar(255) DEFAULT NULL,
  `PASSWORD_SISWA` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`NISN_SISWA`, `NAMA_LENGKAP_SISWA`, `ALAMAT_SISWA`, `TANGGAL_LAHIR_SISWA`, `JENIS_KELAMIN_SISWA`, `NO_TELPON_SISWA`, `FOTO_SISWA_SISWA`, `PASSWORD_SISWA`) VALUES
('123', 'Muhammad Ainul Fuady', 'Pereng kulon bungah gresiik', '2006-05-18', 'L', '085808406892', '6915bc2d2d1ff.jpg', '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_ADMIN`);

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`ID_DOKUMEN`),
  ADD KEY `FK_MEMILIKI_DOKUMEN` (`ID_PENDAFTARAN`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`ID_JURUSAN`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`ID_PENDAFTARAN`),
  ADD KEY `FK_MELAKUKAN` (`NISN_SISWA`),
  ADD KEY `FK_RELATIONSHIP_3` (`ID_JURUSAN`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`NISN_SISWA`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_ADMIN` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `ID_DOKUMEN` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `ID_JURUSAN` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `ID_PENDAFTARAN` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD CONSTRAINT `FK_MEMILIKI_DOKUMEN` FOREIGN KEY (`ID_PENDAFTARAN`) REFERENCES `pendaftaran` (`ID_PENDAFTARAN`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `FK_MELAKUKAN` FOREIGN KEY (`NISN_SISWA`) REFERENCES `siswa` (`NISN_SISWA`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_RELATIONSHIP_3` FOREIGN KEY (`ID_JURUSAN`) REFERENCES `jurusan` (`ID_JURUSAN`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
