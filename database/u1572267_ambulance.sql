-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 07 Des 2022 pada 06.52
-- Versi server: 10.5.17-MariaDB-cll-lve
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1572267_ambulance`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanmasuk`
--

CREATE TABLE `pesanmasuk` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `lokasi_user` varchar(255) NOT NULL,
  `lokasi_supir` varchar(255) DEFAULT NULL,
  `supir_id` varchar(255) DEFAULT NULL,
  `rs_id` varchar(255) NOT NULL,
  `tugas_pasien` varchar(255) DEFAULT 'Mencari Ambulance',
  `tugas_supir` varchar(255) DEFAULT 'Belum Dikonfirmasi'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pesanmasuk`
--

INSERT INTO `pesanmasuk` (`id`, `user_id`, `lokasi_user`, `lokasi_supir`, `supir_id`, `rs_id`, `tugas_pasien`, `tugas_supir`) VALUES
('638d3d265bd42', '638d3c873f2bf', '-3.649204043718922, 128.19328184722934', '-3.6585197, 128.1826854', '638d3c5103054', '638d3bc795047', 'selesai', 'selesai'),
('638d5e4820931', '638d3c873f2bf', '-3.705100321408294, 128.16179819453572', '-3.6578408, 128.182417', '638d3c5103054', '638d3bc795047', 'selesai', 'selesai'),
('638d5fb40cf33', '638d5f7a75a08', '-3.70828027007496, 128.15428041169227', '-3.6578661, 128.1824316', '638d3c5103054', '638d3bc795047', 'selesai', 'selesai'),
('638d97f45c01e', '638d9768b77c8', '-3.6436721154507565, 128.23828518390658', '-3.6539818, 128.1940698', '638d9855de267', '638d3bc795047', 'selesai', 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` varchar(255) DEFAULT NULL,
  `id` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `sandi` varchar(255) DEFAULT NULL,
  `asal_rumah_sakit` varchar(255) DEFAULT NULL,
  `no_kendaraan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `tersedia` varchar(255) DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `id`, `nama`, `email`, `no_telp`, `sandi`, `asal_rumah_sakit`, `no_kendaraan`, `status`, `role`, `tersedia`) VALUES
(NULL, '638d3bc795047', 'rsud dr. m. haulussy', 'haulussy@gmail.com', '0911344871', '$2y$10$mLnHFHzV0yv9zNpfiMykOe7dahH/u9CT1BYmXK4cixzY9bP/zZPIy', '-3.7087173310784545, 128.16549018297084', NULL, NULL, 'admin', 'on'),
(NULL, '638d3c873f2bf', 'gizella', 'giz011200@gmail.com', '082198213262', '$2y$10$um3dBft9aBjAVML5dboAT.1THNQ4V5xio39WYclxpES5PbCPkfHvS', NULL, NULL, NULL, 'user', 'on'),
(NULL, '638d5f7a75a08', 'ella', 'ellat@gmail.com', '082399628270', '$2y$10$RvBfit6IYPzwFcTwP7OVJeBET.9yNLwQbCGTJ083zKSqzQbZ5Moi2', NULL, NULL, NULL, 'user', 'on'),
(NULL, '638d9768b77c8', 'marthin alfreinsco salakory', 'marthinsalakory11@gmail.com', '081318812027', '$2y$10$5FrvX3K.ZBHC8UhKM4piHuGx04WbcHBTWNNS6VrwtRoK7srSpqLAW', NULL, NULL, NULL, 'user', 'on'),
(NULL, '638f3677aa177', 'maverick', 'mpical66@gmail.com', '0821980000124', '$2y$10$34jIyngrpunTfqDPFEsWZuhQDoLmCfth2ZKS2jLndUAsM2RCJp.nS', NULL, NULL, NULL, 'user', 'on'),
(NULL, '638fa67c295db', 'rsup dr. johannes leimena', 'leimena@gmail.com', '09113687000', '$2y$10$Nfa.a62GO4GB4i/1Zn3pUeVQVhPxUzPE92.P6yx6D9CoNsbXMoRi2', '-3.6615124487891153, 128.18629966460193', NULL, NULL, 'admin', 'on'),
(NULL, '638fa7f559ebb', 'rs bhayangkara', 'bhayangkara@gmail.com', '0911349450', '$2y$10$zMnzZwdRnNEZDcID5ZgvE.ow5LlzsEp2Rmoxd2gD5aYgaLrDLtLNm', '-3.6719097372587117, 128.19624890574653', NULL, NULL, 'admin', 'off'),
(NULL, '638fac7d20ddd', 'rumkit tk ii dr. j. a. latumeten', 'latumeten@gmail.com', '0911353555', '$2y$10$5rwTT6QgnF2h.l3cDaJ.COjx7Jpz4ztOUb/8xkZ3qJxOopSXLypCa', '-3.701167603844891, 128.17765950142896', NULL, NULL, 'admin', 'off'),
('638fac7d20ddd', '638fad94dc371', 'supir_haulussy', '', '082134567899', '$2y$10$ulxG2ZCwDN46OInVO3LKweIJLcwSZIoP7UtGdRaIsoSSQQYV6YIrK', NULL, 'de123ab', NULL, 'supir', 'on'),
('638fac7d20ddd', '638faf6bcf8e2', 'supir_latumeten', '', '081112349876', '$2y$10$nGRm9cFayzFIy2wIotwc2O421P41CLoT8zx6/7/WFrhlsUetJb7qu', NULL, 'de654hg', NULL, 'supir', 'on'),
('638fa7f559ebb', '638faff4e1aff', 'supir_bhayangkara', '', '081221113456', '$2y$10$7xT4BThLDNNNhZUiMmVRQeavG8bBibVKlMjS74IKFmJ/DjaKxOGIq', NULL, 'de987ef', NULL, 'supir', 'on'),
('638fa67c295db', '638fb06bbdaa5', 'supir_leimena', '', '085243347005', '$2y$10$EVRecx8Z8VtxO3n.JoF7e.sjC1i6uS7EdU5dZ7hdzVvz0lARa.gPC', NULL, 'de345cd', NULL, 'supir', 'on');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pesanmasuk`
--
ALTER TABLE `pesanmasuk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
