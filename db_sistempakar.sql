-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 11:39 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sistempakar`
--

-- --------------------------------------------------------

--
-- Table structure for table `bpa`
--

CREATE TABLE `bpa` (
  `id_bpa` int(11) NOT NULL,
  `id_gejala` int(11) NOT NULL,
  `hipertensi_primer` decimal(5,2) NOT NULL DEFAULT 0.00,
  `hipertensi_sekunder` decimal(5,2) NOT NULL DEFAULT 0.00,
  `hipertensi_pulmonal` decimal(5,2) NOT NULL DEFAULT 0.00,
  `hipertensi_maligna` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bpa`
--

INSERT INTO `bpa` (`id_bpa`, `id_gejala`, `hipertensi_primer`, `hipertensi_sekunder`, `hipertensi_pulmonal`, `hipertensi_maligna`) VALUES
(1, 1, 0.50, 0.20, 0.10, 0.10),
(2, 2, 0.40, 0.30, 0.10, 0.10),
(3, 3, 0.60, 0.10, 0.10, 0.10),
(4, 4, 0.50, 0.20, 0.10, 0.10),
(5, 5, 0.30, 0.30, 0.20, 0.10),
(6, 6, 0.20, 0.20, 0.40, 0.10),
(7, 7, 0.40, 0.20, 0.20, 0.10),
(8, 8, 0.30, 0.30, 0.10, 0.20),
(9, 9, 0.20, 0.20, 0.10, 0.40),
(10, 10, 0.20, 0.30, 0.10, 0.30);

-- --------------------------------------------------------

--
-- Table structure for table `edukasi_saran`
--

CREATE TABLE `edukasi_saran` (
  `id_saran` int(11) NOT NULL,
  `penyakit` varchar(50) NOT NULL,
  `saran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `edukasi_saran`
--

INSERT INTO `edukasi_saran` (`id_saran`, `penyakit`, `saran`) VALUES
(1, 'Hipertensi Primer', 'Kemungkinan hipertensi tipe Primer. Disarankan mengukur tekanan darah secara rutin, menerapkan pola makan sehat rendah garam, menjaga berat badan ideal, dan olahraga teratur. Konsultasikan ke dokter untuk pemeriksaan lebih lanjut.'),
(2, 'Hipertensi Sekunder', 'Kemungkinan hipertensi tipe Sekunder, yang biasanya disebabkan oleh kondisi medis lain. Disarankan segera melakukan pemeriksaan medis untuk identifikasi penyebab dan penanganan yang tepat.'),
(3, 'Hipertensi Pulmonal', 'Kemungkinan hipertensi tipe Pulmonal. Disarankan segera konsultasi ke dokter spesialis jantung atau paru, hindari aktivitas fisik berat sebelum mendapat saran medis, dan lakukan pemeriksaan lanjutan.'),
(4, 'Hipertensi Maligna', 'Kemungkinan hipertensi tipe Maligna, kondisi serius yang membutuhkan penanganan medis segera. Segera hubungi tenaga kesehatan atau fasilitas medis terdekat.');

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int(11) NOT NULL,
  `nama_gejala` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `nama_gejala`) VALUES
(1, 'Pandangan mata sering kabur'),
(2, 'Jantung terasa berdebar-debar'),
(3, 'Sakit kepala'),
(4, 'Sulit berkonsentrasi'),
(5, 'Nyeri dada'),
(6, 'Sesak napas'),
(7, 'Mudah lelah'),
(8, 'Telinga berdenging'),
(9, 'Mimisan'),
(10, 'Mual dan muntah');

-- --------------------------------------------------------

--
-- Table structure for table `hipertensi`
--

CREATE TABLE `hipertensi` (
  `id_hiper` varchar(20) NOT NULL,
  `nama_hiper` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hipertensi`
--

INSERT INTO `hipertensi` (`id_hiper`, `nama_hiper`) VALUES
('H1', 'Hipertensi Primer'),
('H2', 'Hipertensi Sekunder'),
('H3', 'Hipertensi Pulmonal'),
('H4', 'Hipertensi Maligna');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `umur` int(11) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `gejala` text NOT NULL,
  `hasil` text NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp(),
  `belief_h` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `nama`, `umur`, `jk`, `gejala`, `hasil`, `tgl`, `belief_h`) VALUES
(1, 'Ryan Kurniawan', 24, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar, Sakit kepala, Sulit berkonsentrasi, Nyeri dada, Sesak napas, Mudah lelah, Telinga berdenging, Mimisan', 'Berdasarkan 10 gejala yang Anda pilih, kemungkinan Anda mengalami hipertensi cukup tinggi.', '2025-11-19 06:52:12', 0),
(2, 'Ryan Kurniawan', 24, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar, Sakit kepala, Sulit berkonsentrasi, Nyeri dada, Sesak napas, Mudah lelah, Telinga berdenging, Mimisan', 'Berdasarkan 10 gejala yang Anda pilih, kemungkinan Anda mengalami hipertensi cukup tinggi.', '2025-11-19 06:52:44', 0),
(3, 'Ryan Kurniawan', 24, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar, Sakit kepala, Sulit berkonsentrasi, Nyeri dada, Sesak napas, Mudah lelah, Telinga berdenging, Mimisan', 'Berdasarkan 10 gejala yang Anda pilih, kemungkinan Anda mengalami hipertensi cukup tinggi.', '2025-11-19 06:53:06', 0),
(4, 'Ryan Kurniawan', 12, 'Laki-laki', 'Jantung terasa berdebar-debar, Sakit kepala, Sulit berkonsentrasi', 'Berdasarkan 3 gejala yang Anda pilih, kemungkinan Anda mengalami hipertensi cukup tinggi.', '2025-11-19 08:27:09', 0),
(5, 'Ryan Kurniawan', 12, 'Laki-laki', 'Jantung terasa berdebar-debar, Sakit kepala, Sulit berkonsentrasi', 'Berdasarkan 3 gejala yang Anda pilih, kemungkinan Anda mengalami hipertensi cukup tinggi.', '2025-11-19 08:27:10', 0),
(6, 'Adam Noor M', 23, 'Laki-laki', 'Jantung terasa berdebar-debar, Sakit kepala, Sulit berkonsentrasi', 'Berdasarkan 3 gejala yang Anda pilih, kemungkinan Anda mengalami hipertensi cukup tinggi.', '2025-11-19 08:28:55', 0),
(7, 'Adam Noor M', 22, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar', 'Berdasarkan 3 gejala yang Anda pilih, kemungkinan Anda mengalami hipertensi cukup tinggi.', '2025-11-19 09:04:30', 0),
(8, 'Adam Noor M', 22, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar', 'Berdasarkan perhitungan Dempster‑Shafer, belief hipertensi = -42.9%.', '2025-11-19 09:11:08', 0),
(9, 'Adam Noor M', 22, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar', 'Berdasarkan perhitungan Dempster‑Shafer, belief hipertensi = -42.9%.', '2025-11-19 09:11:09', 0),
(10, 'Adam Noor M', 22, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar, Sakit kepala', 'Berdasarkan perhitungan Dempster‑Shafer, belief hipertensi = -42.9%.', '2025-11-19 09:12:33', 0),
(11, 'Adam Noor M', 22, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar, Sakit kepala, Sulit berkonsentrasi', 'Berdasarkan perhitungan Dempster‑Shafer, belief hipertensi = -42.9%.', '2025-11-19 09:12:36', 0),
(12, 'Adam Noor M', 22, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar, Sakit kepala, Sulit berkonsentrasi, Nyeri dada', 'Berdasarkan perhitungan Dempster‑Shafer, belief hipertensi = -42.9%.', '2025-11-19 09:12:39', 0),
(13, 'Adam Noor M', 22, 'Laki-laki', 'Pandangan mata sering kabur, Mual dan muntah, Jantung terasa berdebar-debar, Sakit kepala, Sulit berkonsentrasi, Nyeri dada, Sesak napas, Mudah lelah, Telinga berdenging, Mimisan', 'Berdasarkan perhitungan Dempster‑Shafer, belief hipertensi = -42.9%.', '2025-11-19 09:12:45', 0),
(14, 'Ryan Kurniawan', 22, 'Laki-laki', 'Sulit berkonsentrasi, Nyeri dada, Sesak napas, Mudah lelah, Telinga berdenging', 'Berdasarkan perhitungan Dempster‑Shafer, belief hipertensi = 0%.', '2025-11-19 09:13:15', 0),
(15, 'user', 22, 'Laki-laki', 'Sulit berkonsentrasi, Nyeri dada, Sesak napas, Mudah lelah, Telinga berdenging, Mimisan', 'Berdasarkan perhitungan Dempster‑Shafer, belief hipertensi = 0%.', '2025-11-19 09:13:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `umur` int(11) NOT NULL,
  `jk` varchar(255) NOT NULL,
  `noTelp` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `umur`, `jk`, `noTelp`, `password`, `role`) VALUES
(1, 'admin', 14, 'Laki-laki', '12345678910', '$2y$10$JuCoTnf9JYpOlTgyxE1Uc.m4pThTD1.pr/z6Mjbhv6i3JmE9eBJ/.', 'admin'),
(7, 'user', 22, 'Perempuan', '12345678911', '$2y$10$8H0nWpnDV4WLh0x041q.t.KxJQjDVJyna06pZbjQRCSUr9rTJ3/pe', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bpa`
--
ALTER TABLE `bpa`
  ADD PRIMARY KEY (`id_bpa`),
  ADD KEY `fk_bpa_gejala` (`id_gejala`);

--
-- Indexes for table `edukasi_saran`
--
ALTER TABLE `edukasi_saran`
  ADD PRIMARY KEY (`id_saran`);

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indexes for table `hipertensi`
--
ALTER TABLE `hipertensi`
  ADD PRIMARY KEY (`id_hiper`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bpa`
--
ALTER TABLE `bpa`
  MODIFY `id_bpa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `edukasi_saran`
--
ALTER TABLE `edukasi_saran`
  MODIFY `id_saran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bpa`
--
ALTER TABLE `bpa`
  ADD CONSTRAINT `fk_bpa_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
