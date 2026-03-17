-- phpMyAdmin SQL Dump
-- version 5.2.2
-- Host: localhost:3306
-- Generation Time: Jan 06, 2026 at 01:04 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sidara`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_arsip`
--
CREATE TABLE `data_arsip` (
  `id_arsip` int NOT NULL,
  `no_perkara` varchar(100) NOT NULL,
  `nama_terdakwa` varchar(100) NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `id_jaksa` int DEFAULT NULL,
  `id_lokasi` int DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `status` enum('Ada','Dipinjam') DEFAULT 'Ada',
  `file_arsip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_arsip`
--
INSERT INTO `data_arsip` (`id_arsip`, `no_perkara`, `nama_terdakwa`, `id_kategori`, `id_jaksa`, `id_lokasi`, `tanggal_masuk`, `status`, `file_arsip`) VALUES
(6, 'PDM-126/BJM/2025', 'Fadhil', 1, 1, 1, '2026-01-06', 'Dipinjam', '714478740_kk.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `data_jaksa`
--
CREATE TABLE `data_jaksa` (
  `id_jaksa` int NOT NULL,
  `nip` varchar(50) NOT NULL,
  `nama_jaksa` varchar(100) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_jaksa`
--
INSERT INTO `data_jaksa` (`id_jaksa`, `nip`, `nama_jaksa`, `jabatan`) VALUES
(1, '32131231231234', 'Gusti Amanda Sielviana', 'Jaksa Pratama');

-- --------------------------------------------------------

--
-- Table structure for table `data_lokasi`
--
CREATE TABLE `data_lokasi` (
  `id_lokasi` int NOT NULL,
  `nama_lokasi` varchar(100) NOT NULL,
  `rak` varchar(50) DEFAULT NULL,
  `baris` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_lokasi`
--
INSERT INTO `data_lokasi` (`id_lokasi`, `nama_lokasi`, `rak`, `baris`) VALUES
(1, 'Ruang Arsip Pidum', 'A- 01', '3'),
(2, 'Ruang Hakim', 'B-03', '4');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_perkara`
--
CREATE TABLE `kategori_perkara` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_perkara`
--
INSERT INTO `kategori_perkara` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Tindak Pidana Umum');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--
CREATE TABLE `pengguna` (
  `id_pengguna` int NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `peran` enum('admin','pimpinan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengguna`
--
INSERT INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `kata_sandi`, `nama_lengkap`, `peran`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator Sistem', 'admin'),
(2, 'pimpinan', '7d3207a13dc221ac13c2f3dac3011f50', 'Kepala Pimpinan', 'pimpinan');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_peminjaman`
--
CREATE TABLE `transaksi_peminjaman` (
  `id_transaksi` int NOT NULL,
  `id_arsip` int DEFAULT NULL,
  `nama_peminjam` varchar(100) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `keterangan` text,
  `status` enum('Dipinjam','Kembali') DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_peminjaman`
--
INSERT INTO `transaksi_peminjaman` (`id_transaksi`, `id_arsip`, `nama_peminjam`, `tanggal_pinjam`, `tanggal_kembali`, `keterangan`, `status`) VALUES
(4, 6, 'Nazar', '2026-01-06', NULL, 'Keperluan sidang final', 'Dipinjam');

--
-- Indexes for dumped tables
--

ALTER TABLE `data_arsip`
  ADD PRIMARY KEY (`id_arsip`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_jaksa` (`id_jaksa`),
  ADD KEY `id_lokasi` (`id_lokasi`);

ALTER TABLE `data_jaksa`
  ADD PRIMARY KEY (`id_jaksa`);

ALTER TABLE `data_lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

ALTER TABLE `kategori_perkara`
  ADD PRIMARY KEY (`id_kategori`);

ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

ALTER TABLE `transaksi_peminjaman`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_arsip` (`id_arsip`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `data_arsip`
  MODIFY `id_arsip` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `data_jaksa`
  MODIFY `id_jaksa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `data_lokasi`
  MODIFY `id_lokasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `kategori_perkara`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `transaksi_peminjaman`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

ALTER TABLE `data_arsip`
  ADD CONSTRAINT `data_arsip_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_perkara` (`id_kategori`),
  ADD CONSTRAINT `data_arsip_ibfk_2` FOREIGN KEY (`id_jaksa`) REFERENCES `data_jaksa` (`id_jaksa`),
  ADD CONSTRAINT `data_arsip_ibfk_3` FOREIGN KEY (`id_lokasi`) REFERENCES `data_lokasi` (`id_lokasi`);

ALTER TABLE `transaksi_peminjaman`
  ADD CONSTRAINT `transaksi_peminjaman_ibfk_1` FOREIGN KEY (`id_arsip`) REFERENCES `data_arsip` (`id_arsip`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;