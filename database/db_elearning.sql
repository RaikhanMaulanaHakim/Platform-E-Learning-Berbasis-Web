-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 02, 2026 at 12:54 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10
CREATE DATABASE IF NOT EXISTS elearning;
USE elearning;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `file` varchar(255) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `id_guru` int NOT NULL,
  `tgl_upload` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan`
--

CREATE TABLE `pengumpulan` (
  `id_pengumpulan` int NOT NULL,
  `id_tugas` int NOT NULL,
  `id_murid` int NOT NULL,
  `file_tugas` varchar(255) NOT NULL,
  `catatan_murid` text,
  `nilai` int DEFAULT NULL,
  `catatan_guru` text,
  `status` varchar(50) DEFAULT 'Sudah Dikumpulkan',
  `waktu_kumpul` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `deadline` datetime NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `id_guru` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `nama`, `role`, `kelas`, `status`) VALUES
(1, 'kelas1@gmail.com', 'kelas1@gmail.com', '$2y$10$0x6PT2uc5th7Os1kHcC5GewH33Q/F9KVff2LkuFEKrsfle/dtpQ46', 'Dani', 'murid', '1', 'aktif'),
(2, 'kelas2@gmail.com', 'kelas2@gmail.com', '$2y$10$uTTwHoKG4Iw5VTflgkjT3uiuZXOYHEuRhKCcG31Rbes4pK.gaMKtC', 'jono', 'murid', '2', 'aktif'),
(3, 'kelas3@gmail.com', 'kelas3@gmail.com', '$2y$10$vplnE8R7QvuEtwmdR.JB.OO8Lqz7bEivDwei.9vjQcwsUeQYUsHTa', 'Budi', 'murid', '3', 'aktif'),
(4, 'kelas4@gmail.com', 'kelas4@gmail.com', '$2y$10$YABvFaS2O2x18ZOHTJPAZepBTsJXVPIxJNAz6X.kdkQNenU46cyNq', 'Yanto', 'murid', '4', 'aktif'),
(5, 'kelas5@gmail.com', 'kelas5@gmail.com', '$2y$10$CEDqgAIdn2qRk/bjrK/.6epd.Y4DB19.U9OgKlguaIV6i25RVdqxO', 'Yunus', 'murid', '5', 'aktif'),
(6, 'kelas6@gmail.com', 'kelas6@gmail.com', '$2y$10$fs7f0pL0rbw1o/W6EIF4Huzz//TQVhi4uQ4NCV45Bcmw6ws9nSbJm', 'Kevin Adhiyasa', 'murid', '6', 'aktif'),
(7, 'gurukelas1@gmail.com', 'gurukelas1@gmail.com', '$2y$10$Trjd08wSk67hzI8jr8hH6.en.y90YNLxo543rZXVR6Vm02Ecu6f86', 'guru kelas 1', 'guru', '1', 'aktif'),
(8, 'gurukelas2@gmail.com', 'gurukelas2@gmail.com', '$2y$10$KGcSK2yG5nyYmTeQlcX/Z.GpWSWz7E/kCs8Ms5rhPyyy97VncNK1i', 'guru kelas 2', 'guru', '2', 'aktif'),
(9, 'gurukelas3@gmail.com', 'gurukelas3@gmail.com', '$2y$10$F.8kL0bAtmAKKBheFBZQ9OMVRIrAvu3tKJB7WS5gWWKdrsQqfkQf2', 'guru kelas 3', 'guru', '3', 'aktif'),
(10, 'gurukelas4@gmail.com', 'gurukelas4@gmail.com', '$2y$10$7KJ85/EBUNOnd2i3fYVWSuRuVlch/1RmB5ulbAErW1wbEj5ru/2j.', 'guru kelas 4', 'guru', '4', 'aktif'),
(11, 'gurukelas5@gmail.com', 'gurukelas5@gmail.com', '$2y$10$oYTk0bKyFz8p1aLK2kqWUu4QHb8FSySN72iDmLrUF0yOqAWaOTNpq', 'guru kelas 5', 'guru', '5', 'aktif'),
(12, 'gurukelas6@gmail.com', 'gurukelas6@gmail.com', '$2y$10$auMuuXD9eJDW/.zyq7EHoei.5kgD4kHAcWL2zcNGD7.JNKI2nbAju', 'guru kelas 6', 'guru', '6', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `pengumpulan`
--
ALTER TABLE `pengumpulan`
  ADD PRIMARY KEY (`id_pengumpulan`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `pengumpulan`
--
ALTER TABLE `pengumpulan`
  MODIFY `id_pengumpulan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
