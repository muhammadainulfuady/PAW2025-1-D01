-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2025 at 06:07 PM
-- Server version: 8.0.30
-- PHP Version: 8.4.11
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

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
CREATE TABLE
  `admin` (
    `ID_ADMIN` int NOT NULL,
    `NAMA_ADMIN` varchar(255) DEFAULT NULL,
    `USERNAME_ADMIN` varchar(255) DEFAULT NULL,
    `PASSWORD_ADMIN` varchar(255) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `admin`
--
INSERT INTO
  `admin` (
    `ID_ADMIN`,
    `NAMA_ADMIN`,
    `USERNAME_ADMIN`,
    `PASSWORD_ADMIN`
  )
VALUES
  (
    1,
    'Ainulfuady',
    'admin',
    'e66055e8e308770492a44bf16e875127'
  );

-- --------------------------------------------------------
--
-- Table structure for table `dokumen`
--
CREATE TABLE
  `dokumen` (
    `ID_DOKUMEN` int NOT NULL,
    `ID_PENDAFTARAN` int DEFAULT NULL,
    `KETERANGAN` varchar(255) DEFAULT NULL,
    `JENIS_DOKUMEN` varchar(255) DEFAULT NULL,
    `PATH_FILE` varchar(255) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `dokumen`
--
INSERT INTO
  `dokumen` (
    `ID_DOKUMEN`,
    `ID_PENDAFTARAN`,
    `KETERANGAN`,
    `JENIS_DOKUMEN`,
    `PATH_FILE`
  )
VALUES
  (
    17,
    9,
    'Akte Kelahiran Siswa',
    'Akte Kelahiran',
    'doc_691f35e28b600.jpg'
  ),
  (
    18,
    9,
    'Kartu Keluarga Siswa',
    'Kartu Keluarga',
    'doc_691f35e28d47d.jpg'
  );

-- --------------------------------------------------------
--
-- Table structure for table `jurusan`
--
CREATE TABLE
  `jurusan` (
    `ID_JURUSAN` int NOT NULL,
    `NAMA_JURUSAN` varchar(255) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `jurusan`
--
INSERT INTO
  `jurusan` (`ID_JURUSAN`, `NAMA_JURUSAN`)
VALUES
  (7, 'TKR');

-- --------------------------------------------------------
--
-- Table structure for table `pendaftaran`
--
CREATE TABLE
  `pendaftaran` (
    `ID_PENDAFTARAN` int NOT NULL,
    `ID_JURUSAN` int DEFAULT NULL,
    `USERNAME_SISWA` varchar(100) DEFAULT NULL,
    `NISN` varchar(15) DEFAULT NULL,
    `JENIS_KELAMIN` varchar(20) DEFAULT NULL,
    `TANGGAL_LAHIR` date DEFAULT NULL,
    `TEMPAT_LAHIR` varchar(20) DEFAULT NULL,
    `NO_HP_SISWA` varchar(20) DEFAULT NULL,
    `TANGGAL_PENDAFTARAN` datetime DEFAULT CURRENT_TIMESTAMP,
    `ASAL_SEKOLAH` varchar(30) DEFAULT NULL,
    `ALAMAT` varchar(255) DEFAULT NULL,
    `NAMA_WALI` varchar(30) DEFAULT NULL,
    `NO_HP_WALI` varchar(20) DEFAULT NULL,
    `STATUS` varchar(5) DEFAULT NULL,
    `PROGRAM_PONDOK` varchar(20) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `pendaftaran`
--
INSERT INTO
  `pendaftaran` (
    `ID_PENDAFTARAN`,
    `ID_JURUSAN`,
    `USERNAME_SISWA`,
    `NISN`,
    `JENIS_KELAMIN`,
    `TANGGAL_LAHIR`,
    `TEMPAT_LAHIR`,
    `NO_HP_SISWA`,
    `TANGGAL_PENDAFTARAN`,
    `ASAL_SEKOLAH`,
    `ALAMAT`,
    `NAMA_WALI`,
    `NO_HP_WALI`,
    `STATUS`,
    `PROGRAM_PONDOK`
  )
VALUES
  (
    9,
    7,
    'AinulFuady24',
    '1234567890',
    'L',
    '2006-05-18',
    'Bungah Gresik',
    '085808406486',
    '2025-11-20 22:38:10',
    'Smks Nurul Hidayah',
    'Pereng kulon, Melirang, Bungah, gresik',
    'Amin Thohari',
    '085808406489',
    '2',
    'Tahfidz Alquran'
  );

-- --------------------------------------------------------
--
-- Table structure for table `siswa`
--
CREATE TABLE
  `siswa` (
    `USERNAME_SISWA` varchar(100) NOT NULL,
    `NAMA_LENGKAP_SISWA` varchar(30) DEFAULT NULL,
    `FOTO_SISWA` varchar(20) DEFAULT NULL,
    `PASSWORD_SISWA` varchar(40) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `siswa`
--
INSERT INTO
  `siswa` (
    `USERNAME_SISWA`,
    `NAMA_LENGKAP_SISWA`,
    `FOTO_SISWA`,
    `PASSWORD_SISWA`
  )
VALUES
  (
    'AfifUddin',
    'Muhammad Afifuddin',
    'default.jpg',
    '92cd760cae9061910fa475bb66d491e5'
  ),
  (
    'AinulFuady24',
    'Muhammad Ainul Fuady',
    '691f356214443.jpg',
    'ea1907de8478edf88bcb9860c4b715dd'
  );

--
-- Indexes for dumped tables
--
--
-- Indexes for table `admin`
--
ALTER TABLE `admin` ADD PRIMARY KEY (`ID_ADMIN`);

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen` ADD PRIMARY KEY (`ID_DOKUMEN`),
ADD KEY `FK_MEMILIKI_DOKUMEN` (`ID_PENDAFTARAN`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan` ADD PRIMARY KEY (`ID_JURUSAN`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran` ADD PRIMARY KEY (`ID_PENDAFTARAN`),
ADD KEY `FK_MELAKUKAN` (`USERNAME_SISWA`),
ADD KEY `FK_MEMILIH` (`ID_JURUSAN`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa` ADD PRIMARY KEY (`USERNAME_SISWA`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin` MODIFY `ID_ADMIN` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `dokumen`
--
ALTER TABLE `dokumen` MODIFY `ID_DOKUMEN` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 19;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan` MODIFY `ID_JURUSAN` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 13;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran` MODIFY `ID_PENDAFTARAN` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 10;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `dokumen`
--
ALTER TABLE `dokumen` ADD CONSTRAINT `FK_MEMILIKI_DOKUMEN` FOREIGN KEY (`ID_PENDAFTARAN`) REFERENCES `pendaftaran` (`ID_PENDAFTARAN`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran` ADD CONSTRAINT `FK_MELAKUKAN` FOREIGN KEY (`USERNAME_SISWA`) REFERENCES `siswa` (`USERNAME_SISWA`) ON DELETE RESTRICT ON UPDATE RESTRICT,
ADD CONSTRAINT `FK_MEMILIH` FOREIGN KEY (`ID_JURUSAN`) REFERENCES `jurusan` (`ID_JURUSAN`) ON DELETE RESTRICT ON UPDATE RESTRICT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;