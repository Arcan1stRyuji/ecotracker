-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2025 at 07:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecotrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda_rt`
--

CREATE TABLE `agenda_rt` (
  `id` int(11) NOT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kategori` enum('Rutin','Kesehatan','Keagamaan','Karang Taruna','Lainnya') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda_rt`
--

INSERT INTO `agenda_rt` (`id`, `judul`, `deskripsi`, `tanggal`, `kategori`) VALUES
(1, 'Rapat Karang Taruna', NULL, '2025-11-10', 'Karang Taruna'),
(2, 'Kerja Bakti Pemuda', NULL, '2025-11-17', 'Karang Taruna');

-- --------------------------------------------------------

--
-- Table structure for table `bukti_ronda`
--

CREATE TABLE `bukti_ronda` (
  `id` int(11) NOT NULL,
  `jadwal_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `status` enum('menunggu','valid','ditolak') DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bukti_ronda`
--

INSERT INTO `bukti_ronda` (`id`, `jadwal_id`, `user_id`, `foto`, `tanggal`, `status`) VALUES
(1, NULL, 4, '695001fe9adb2.png', '2025-12-13', 'menunggu');

-- --------------------------------------------------------

--
-- Table structure for table `informasi_rt`
--

CREATE TABLE `informasi_rt` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `informasi_rt`
--

INSERT INTO `informasi_rt` (`id`, `judul`, `isi`, `foto`, `created_at`) VALUES
(2, 'test', '234123414', '6951789fcde09.png', '2025-12-28 18:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ronda`
--

CREATE TABLE `jadwal_ronda` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('belum','sudah') DEFAULT 'belum',
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_warga`
--

CREATE TABLE `laporan_warga` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `isi_laporan` text DEFAULT NULL,
  `status` enum('pending','diproses','selesai') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','warga') DEFAULT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `no_wa`, `alamat`, `created_at`, `foto`) VALUES
(1, 'admin', 'rt@admin.id', 'admin123', 'admin', '081290336923', 'Taman Raya Rajeg ', '2025-12-27 08:29:00', NULL),
(2, 'Alma', 'alma@warga.id', '$2y$10$icghH7Jz6uiADOm3znbQeO2hjfhB/Jsa9B7g5jMju1liLbBEPIbTm', 'warga', NULL, NULL, '2025-12-25 02:18:38', NULL),
(3, 'kastono', 'kastono23@gmail.com', '230167', 'warga', '081317677991', 'Taman Raya Rajeg Blok K17/07', '2025-12-26 03:40:02', NULL),
(4, 'kenan', 'kenan@warga.id', '$2y$10$QaElIZvJOxrSUQ6Zdirmu.mmRsM4Hc58NaBfzanUDclCJc1mlm95K', 'warga', '+62 821-2497-9020', 'Taman Raya Rajeg Blok K 17/03', '2025-12-27 08:01:57', NULL),
(5, 'Administrator', 'admin@ecotrack.id', 'HASIL_HASH_DI_SINI', 'admin', NULL, NULL, '2025-12-27 11:37:43', NULL),
(6, 'Admin', 'admin@rt18.com', '$2y$10$/kYNcJJj6kSLk2NQwf5HuO5zSOIHjSpCxXsbBDPqIYo2SlSFtHF/.', 'admin', NULL, NULL, '2025-12-27 11:42:53', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda_rt`
--
ALTER TABLE `agenda_rt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bukti_ronda`
--
ALTER TABLE `bukti_ronda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bukti_jadwal` (`jadwal_id`);

--
-- Indexes for table `informasi_rt`
--
ALTER TABLE `informasi_rt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_ronda`
--
ALTER TABLE `jadwal_ronda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_warga`
--
ALTER TABLE `laporan_warga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda_rt`
--
ALTER TABLE `agenda_rt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bukti_ronda`
--
ALTER TABLE `bukti_ronda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `informasi_rt`
--
ALTER TABLE `informasi_rt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jadwal_ronda`
--
ALTER TABLE `jadwal_ronda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `laporan_warga`
--
ALTER TABLE `laporan_warga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bukti_ronda`
--
ALTER TABLE `bukti_ronda`
  ADD CONSTRAINT `fk_bukti_jadwal` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_ronda` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
