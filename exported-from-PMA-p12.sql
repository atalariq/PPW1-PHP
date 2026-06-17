-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Jun 17, 2026 at 12:26 PM
-- Server version: 8.4.10
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppw1`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `prodi_id` int NOT NULL,
  `ipk` decimal(3,2) NOT NULL,
  `semester` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nama`, `nim`, `prodi_id`, `ipk`, `semester`, `created_at`) VALUES
(1, 'Atalariq Barra Hadinugraha', '25/557554/SV/26192', 80, 3.95, 2, '2026-06-17 08:48:26'),
(2, 'Budi Santoso', '21/494561/TK/56231', 26, 3.75, 6, '2026-06-17 09:33:32'),
(3, 'Siti Rahayu', '21/494562/PA/56232', 23, 3.52, 5, '2026-06-17 09:33:32'),
(4, 'Ahmad Fauzi', '22/512341/TK/12341', 57, 2.89, 4, '2026-06-17 09:33:32'),
(5, 'Dewi Kusuma', '20/481231/PA/81231', 34, 3.91, 8, '2026-06-17 09:33:32'),
(6, 'Reza Pratama', '22/512342/TK/12342', 62, 2.45, 3, '2026-06-17 09:33:32'),
(7, 'Anita Wijaya', '21/494563/SB/56233', 32, 3.21, 6, '2026-06-17 09:33:32'),
(8, 'Hendra Gunawan', '20/481232/TK/81232', 68, 2.76, 7, '2026-06-17 09:33:32'),
(9, 'Putri Handayani', '23/531231/PS/31231', 45, 3.60, 2, '2026-06-17 09:33:32'),
(10, 'Fajar Nugroho', '22/512343/TK/12343', 26, 1.85, 4, '2026-06-17 09:33:32'),
(11, 'Maya Sari', '21/494564/SB/56234', 22, 3.45, 5, '2026-06-17 09:33:32'),
(12, 'Rizki Maulana', '23/531232/MI/31232', 59, 3.88, 2, '2026-06-17 09:33:32'),
(13, 'Eka Putranti', '20/481233/HK/81233', 17, 3.15, 8, '2026-06-17 09:33:32'),
(14, 'Dimas Arya', '22/512344/TK/12344', 60, 2.95, 4, '2026-06-17 09:33:32'),
(15, 'Indah Permata', '21/494565/MIPA/5235', 34, 3.55, 6, '2026-06-17 09:33:32'),
(16, 'Wahyu Hidayat', '23/531233/PA/31233', 23, 2.10, 2, '2026-06-17 09:33:32'),
(17, 'Nurul Hikmah', '20/481234/FK/81234', 27, 3.82, 9, '2026-06-17 09:33:32'),
(18, 'Fitriani Amalia', '22/512345/EK/12345', 2, 3.30, 4, '2026-06-17 09:33:32'),
(19, 'Galih Prabowo', '20/481235/TK/81235', 91, 3.05, 7, '2026-06-17 09:33:32'),
(33, 'John Doe', '26/666666/SV/26666', 80, 3.66, 2, '2026-06-17 12:03:37');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `nama`) VALUES
(1, 'Agronomi'),
(2, 'Akuntansi'),
(90, 'Antropologi Budaya'),
(3, 'Arkeologi'),
(4, 'Arsitektur'),
(5, 'Bahasa dan Kebudayaan Korea'),
(6, 'Bahasa dan Sastra Indonesia'),
(7, 'Biologi'),
(8, 'Bioteknologi'),
(88, 'Bisnis Internasional'),
(89, 'Bisnis Perjalanan Wisata'),
(91, 'Ekonomi Terapan'),
(9, 'Elektronika dan Instrumentasi'),
(10, 'Farmasi'),
(11, 'Filsafat'),
(12, 'Fisika'),
(13, 'Geofisika'),
(14, 'Geografi dan Ilmu Lingkungan'),
(15, 'Geologi'),
(16, 'Higiene Gigi'),
(17, 'Hukum'),
(18, 'Ilmu Aktuaria'),
(19, 'Ilmu Ekonomi'),
(20, 'Ilmu Hubungan Internasional'),
(21, 'Ilmu Keperawatan'),
(23, 'Ilmu Komputer'),
(22, 'Ilmu Komunikasi'),
(24, 'Ilmu Pemerintahan'),
(25, 'Ilmu Sejarah'),
(26, 'Informatika'),
(27, 'Kedokteran'),
(28, 'Kedokteran Gigi'),
(29, 'Kedokteran Hewan'),
(30, 'Kehutanan'),
(31, 'Kimia'),
(32, 'Manajemen'),
(33, 'Manajemen dan Kebijakan Publik'),
(84, 'Manajemen Informasi'),
(85, 'Manajemen Sumber Daya Akuatik'),
(34, 'Matematika'),
(35, 'Mikrobiologi Pertanian'),
(36, 'Nutrisi dan Kesehatan Hewan'),
(37, 'Pariwisata'),
(39, 'Pembangunan Sosial dan Kesejahteraan'),
(38, 'Pembangunan Wilayah'),
(40, 'Pendidikan Dokter'),
(86, 'Pengelolaan Hutan'),
(41, 'Penyuluhan dan Komunikasi Pertanian'),
(42, 'Perencanaan Wilayah dan Kota'),
(43, 'Pertanian'),
(44, 'Peternakan'),
(87, 'Proteksi Tanaman'),
(45, 'Psikologi'),
(46, 'Sastra Arab'),
(47, 'Sastra Indonesia'),
(48, 'Sastra Inggris'),
(49, 'Sastra Jawa'),
(50, 'Sastra Jepang'),
(51, 'Sastra Nusantara'),
(52, 'Sastra Perancis'),
(53, 'Sastra Yunani dan Latin'),
(54, 'Seni Murni'),
(55, 'Seni Pertunjukan'),
(56, 'Seni Rupa'),
(57, 'Sistem Informasi'),
(58, 'Sosiologi'),
(59, 'Statistika'),
(61, 'Teknik Biomedis'),
(62, 'Teknik Elektro'),
(63, 'Teknik Fisika'),
(64, 'Teknik Geodesi'),
(65, 'Teknik Geologi'),
(66, 'Teknik Industri'),
(72, 'Teknik Infrastruktur Lingkungan'),
(67, 'Teknik Kimia'),
(68, 'Teknik Mesin'),
(69, 'Teknik Nuklir'),
(70, 'Teknik Pertanian'),
(71, 'Teknik Sipil'),
(73, 'Teknologi Hasil Hutan'),
(74, 'Teknologi Hasil Perikanan'),
(75, 'Teknologi Industri Pertanian'),
(60, 'Teknologi Informasi'),
(76, 'Teknologi Pangan dan Hasil Pertanian'),
(81, 'Teknologi Rekayasa Elektro'),
(77, 'Teknologi Rekayasa Instrumentasi dan Kontrol'),
(78, 'Teknologi Rekayasa Mesin'),
(79, 'Teknologi Rekayasa Pelaksanaan Bangunan Sipil'),
(80, 'Teknologi Rekayasa Perangkat Lunak'),
(82, 'Teknologi Veteriner'),
(83, 'Usaha Perjalanan Wisata');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
