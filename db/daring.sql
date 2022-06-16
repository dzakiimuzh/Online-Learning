-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2022 at 08:19 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daring`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_tgs_essay`
--

CREATE TABLE `detail_tgs_essay` (
  `id_detail_essay` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `tgl_kerjakan` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `kelas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `kelas`) VALUES
(1, 'XI RPL'),
(2, 'XII RPL'),
(3, 'X MM'),
(4, 'XII TKJ');

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `id_leaderboard` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `poin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leaderboard`
--

INSERT INTO `leaderboard` (`id_leaderboard`, `id_user`, `poin`) VALUES
(13, 26, '300'),
(14, 39, '550');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `mapel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `mapel`) VALUES
(1, 'Matematika'),
(2, 'PWPB'),
(3, 'Kimia'),
(5, 'Bahasa jepang');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_absen`
--

CREATE TABLE `tbl_absen` (
  `id_absen` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `hari` varchar(100) NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  `jam` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `id_guru` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_guru`
--

INSERT INTO `tbl_guru` (`id_guru`, `id_user`, `nama`, `kelas`, `mapel`, `no_hp`, `img`) VALUES
(12, 46, 'ibnu', 'XI RPL,XII RPL', 'Matematika', '083894883912', 'profile.svg'),
(13, 48, 'asep', 'XI RPL,XII RPL,X MM', 'Matematika', '082122940643', 'profile.svg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jawaban`
--

CREATE TABLE `tbl_jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_soal` int(11) NOT NULL,
  `desk` varchar(100) NOT NULL,
  `pg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jawaban`
--

INSERT INTO `tbl_jawaban` (`id_jawaban`, `id_soal`, `desk`, `pg`) VALUES
(229, 64, '200', 'A'),
(230, 64, '250', 'B'),
(231, 64, '225', 'C'),
(232, 64, '275', 'D'),
(233, 65, '110', 'A'),
(234, 65, '105', 'B'),
(235, 65, '115', 'C'),
(236, 65, '120', 'D'),
(237, 66, '100', 'A'),
(238, 66, '125', 'B'),
(239, 66, '150', 'C'),
(240, 66, '175', 'D'),
(241, 67, '200', 'A'),
(242, 67, '100', 'B'),
(243, 67, '199', 'C'),
(244, 67, '198', 'D'),
(245, 68, '80', 'A'),
(246, 68, '70', 'B'),
(247, 68, '65', 'C'),
(248, 68, '60', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jawaban_essay`
--

CREATE TABLE `tbl_jawaban_essay` (
  `id_jwbn_essay` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_essay` int(11) NOT NULL,
  `jawaban` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_materi`
--

CREATE TABLE `tbl_materi` (
  `id_materi` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `guru` varchar(100) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `materi` varchar(100) NOT NULL,
  `desk` text NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `tgl` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_materi`
--

INSERT INTO `tbl_materi` (`id_materi`, `id_guru`, `guru`, `mapel`, `materi`, `desk`, `kelas`, `file`, `tgl`, `status`) VALUES
(23, 48, 'asep', 'Matematika', 'Luas Lingkaran', '.', 'XI RPL', '62a979822effb.docx', '15 Jun 2022', 'belum');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_meet`
--

CREATE TABLE `tbl_meet` (
  `id_meet` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `guru` varchar(100) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `link` varchar(250) NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `mulai` varchar(100) NOT NULL,
  `selesai` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_meet`
--

INSERT INTO `tbl_meet` (`id_meet`, `id_guru`, `guru`, `mapel`, `link`, `kelas`, `mulai`, `selesai`, `status`) VALUES
(15, 48, 'asep', 'Matematika', 'https://meet.google.com/xxc-ygiu-nrv', 'XI RPL', '16:00', '17:30', 'belum');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nilai`
--

CREATE TABLE `tbl_nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `soal` varchar(100) NOT NULL,
  `salah` varchar(100) NOT NULL,
  `benar` varchar(100) NOT NULL,
  `nilai` varchar(100) NOT NULL,
  `tgl_pengerjaan` varchar(100) NOT NULL,
  `jam` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `id_siswa` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`id_siswa`, `id_user`, `nama`, `id_kelas`, `img`) VALUES
(22, 39, 'Dzaki Muzhaffar', 2, '620e27ef279ed.png'),
(26, 47, 'firman', 1, 'profile.svg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_soal`
--

CREATE TABLE `tbl_soal` (
  `id_soal` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `no` varchar(100) NOT NULL,
  `soal` text NOT NULL,
  `jawaban_benar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_soal`
--

INSERT INTO `tbl_soal` (`id_soal`, `id_tugas`, `no`, `soal`, `jawaban_benar`) VALUES
(64, 65, '1', '125 +125', 'B'),
(65, 65, '2', '55 + 55', 'A'),
(66, 65, '3', '75 + 75', 'C'),
(67, 65, '4', '100 + 100', 'A'),
(68, 65, '5', '35 + 35', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_soal_essay`
--

CREATE TABLE `tbl_soal_essay` (
  `id_essay` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `no` varchar(100) NOT NULL,
  `soal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_soal_essay`
--

INSERT INTO `tbl_soal_essay` (`id_essay`, `id_tugas`, `no`, `soal`) VALUES
(34, 66, '1', '50 x 50'),
(35, 66, '2', '10 x 10'),
(36, 66, '3', '100 x 100'),
(37, 66, '4', '200 x 100'),
(38, 66, '5', '150 x 130');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tugas`
--

CREATE TABLE `tbl_tugas` (
  `id_tugas` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `guru` varchar(100) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `materi` varchar(100) NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `jenis_soal` varchar(100) NOT NULL,
  `jumlah_soal` varchar(100) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `countdown` varchar(100) NOT NULL,
  `tgl` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tugas`
--

INSERT INTO `tbl_tugas` (`id_tugas`, `id_guru`, `guru`, `mapel`, `materi`, `kelas`, `jenis_soal`, `jumlah_soal`, `deskripsi`, `countdown`, `tgl`, `status`) VALUES
(65, 48, 'asep', 'Matematika', 'Penjumlahan', 'XI RPL', 'Pilihan Ganda', '5', '.', '10', '15 Jun 2022', 'belum'),
(66, 48, 'asep', 'Matematika', 'Perkalian', 'XI RPL', 'Essay', '5', '.', '10', '15 Jun 2022', 'belum');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(38, 'admin', '$2y$10$FHssytdoxqpxrjMXYVOVkejPWF64XP4Dvt9dDrSX33ksOiQuEqABS', 'admin'),
(39, 'dzakimuzh', '$2y$10$qp0JU5XcerF61A/WUqU2K.haxf38ye.ZwW.jGkbuohj4/LYjVchBK', 'siswa'),
(46, 'ibnu', '$2y$10$wKhzLYSRJ21COR1Lxu/xTO90GQzArv/Pq.r3swIPH0FqYDQDbJ16K', 'guru'),
(47, 'firman', '$2y$10$pZTMiFLUaJ7V1vKC4vfl5exMQEBLtnQncYYDr6SQLtz1bvBICo6UO', 'siswa'),
(48, 'asep', '$2y$10$17TbncW3vNPoMSSEOahfGuZid1hUnzyOBjzwvoNaSRFAl1HfBQloa', 'guru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_tgs_essay`
--
ALTER TABLE `detail_tgs_essay`
  ADD PRIMARY KEY (`id_detail_essay`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`id_leaderboard`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `tbl_absen`
--
ALTER TABLE `tbl_absen`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `tbl_jawaban`
--
ALTER TABLE `tbl_jawaban`
  ADD PRIMARY KEY (`id_jawaban`);

--
-- Indexes for table `tbl_jawaban_essay`
--
ALTER TABLE `tbl_jawaban_essay`
  ADD PRIMARY KEY (`id_jwbn_essay`);

--
-- Indexes for table `tbl_materi`
--
ALTER TABLE `tbl_materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `tbl_meet`
--
ALTER TABLE `tbl_meet`
  ADD PRIMARY KEY (`id_meet`);

--
-- Indexes for table `tbl_nilai`
--
ALTER TABLE `tbl_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  ADD PRIMARY KEY (`id_soal`);

--
-- Indexes for table `tbl_soal_essay`
--
ALTER TABLE `tbl_soal_essay`
  ADD PRIMARY KEY (`id_essay`);

--
-- Indexes for table `tbl_tugas`
--
ALTER TABLE `tbl_tugas`
  ADD PRIMARY KEY (`id_tugas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_tgs_essay`
--
ALTER TABLE `detail_tgs_essay`
  MODIFY `id_detail_essay` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `id_leaderboard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_absen`
--
ALTER TABLE `tbl_absen`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_jawaban`
--
ALTER TABLE `tbl_jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `tbl_jawaban_essay`
--
ALTER TABLE `tbl_jawaban_essay`
  MODIFY `id_jwbn_essay` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_materi`
--
ALTER TABLE `tbl_materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_meet`
--
ALTER TABLE `tbl_meet`
  MODIFY `id_meet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_nilai`
--
ALTER TABLE `tbl_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_soal`
--
ALTER TABLE `tbl_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tbl_soal_essay`
--
ALTER TABLE `tbl_soal_essay`
  MODIFY `id_essay` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_tugas`
--
ALTER TABLE `tbl_tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
