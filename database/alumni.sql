-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2020 at 05:08 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumni`
--

-- --------------------------------------------------------

--
-- Table structure for table `nilai_kepuasan`
--

CREATE TABLE `nilai_kepuasan` (
  `id` varchar(255) NOT NULL,
  `a1` varchar(1000) NOT NULL,
  `a2` varchar(1000) NOT NULL,
  `a3` varchar(1000) NOT NULL,
  `a4` varchar(1000) NOT NULL,
  `a5` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai_kepuasan`
--

INSERT INTO `nilai_kepuasan` (`id`, `a1`, `a2`, `a3`, `a4`, `a5`) VALUES
('1', '0', '0', '1', '11', '13'),
('2', '0', '1', '2', '13', '9'),
('3', '0', '0', '4', '12', '9'),
('2', '0', '1', '2', '13', '9'),
('3', '0', '0', '4', '12', '9');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(45) NOT NULL,
  `username_user` varchar(20) NOT NULL,
  `password_user` varchar(32) NOT NULL,
  `keterangan_user` text NOT NULL,
  `status_user` enum('Admin','User','','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username_user`, `password_user`, `keterangan_user`, `status_user`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin', 'admin di aplikasi', 'Admin', '2020-01-24 05:18:06', '2020-01-24 05:18:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
