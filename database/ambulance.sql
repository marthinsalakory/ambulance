-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2022 at 09:42 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ambulance`
--

-- --------------------------------------------------------

--
-- Table structure for table `pesanmasuk`
--

CREATE TABLE `pesanmasuk` (
  `id` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `lokasi_user` varchar(255) NOT NULL,
  `supir` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL DEFAULT 'Menunggu',
  `tugas` varchar(255) NOT NULL DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `id`, `nama`, `email`, `no_telp`, `sandi`, `asal_rumah_sakit`, `no_kendaraan`, `status`, `role`) VALUES
(NULL, '637a32c4370e6', 'rsup dr. johannes leimena', 'leimena@gmail.com', '081248808575', '$2y$10$aPXyjlQZT9ogueo1bmWNmeP7kLWRaVeQOyfKV7CHDJYXnS6ZV605S', '-3.6615921,128.1864637', NULL, NULL, 'admin'),
(NULL, '637a50f3c553a', 'rsud dr. m. haulussy', 'haulussy@gmail.com', '081248808576', '$2y$10$uQDFsYCHEwDjCeK8ew24j.5NNSu1UhyP/38bZr/tc5RB/vfz6hF3i', '-3.7091944,128.1623248', NULL, NULL, 'admin'),
(NULL, '637a53053ce1f', 'user', 'user@gmail.com', '081318812027', '$2y$10$pH9dIK7iR81uxVLtRzspG.4/5BQr48QD1m9DlTqOVG2sv5TWgXD6m', NULL, NULL, NULL, 'user'),
(NULL, '637a67958838c', 'elton', 'elton@gmail.com', '085243836364', '$2y$10$/tpY6EUpZlvhDDl5cz1jauVywxwGv9cNkUHFfo4LZ0sMzvYQ9HB06', '', NULL, NULL, 'user'),
(NULL, '637a7bc57f82a', 'rsu. hative', 'hative@gmail.com', '0915362512', '$2y$10$x/avKzm37GV8.0abQPKaSeMF9yy/JVHCuIN4x.opPSjBoMA.5oVgO', '-3.7065789,128.1601596', NULL, NULL, 'admin'),
('637a32c4370e6', '637a9ba08b226', 'supir', 'supir@gmail.com', '081318812028', NULL, NULL, 'de4323is', 'tersedia', 'supir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
