-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2021 at 03:00 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_pw`
--
CREATE DATABASE IF NOT EXISTS `project_pw` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `project_pw`;

-- --------------------------------------------------------

--
-- Table structure for table `dtrans`
--

DROP TABLE IF EXISTS `dtrans`;
CREATE TABLE `dtrans` (
  `id_htrans` int(25) NOT NULL,
  `id_product` int(25) NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `jumlah` int(25) NOT NULL,
  `subtotal` int(25) NOT NULL,
  `harga` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dtrans`
--

INSERT INTO `dtrans` (`id_htrans`, `id_product`, `nama_product`, `jumlah`, `subtotal`, `harga`) VALUES
(1, 1, 'ramen', 1, 50000, 50000),
(1, 2, 'sushi', 1, 30000, 30000),
(1, 3, 'green tea', 1, 15000, 15000),
(2, 1, 'ramen', 3, 150000, 50000),
(2, 2, 'sushi', 4, 120000, 30000),
(2, 3, 'green tea', 2, 30000, 15000),
(3, 2, 'sushi', 3, 90000, 30000),
(3, 1, 'ramen', 4, 200000, 50000),
(3, 3, 'green tea', 2, 30000, 15000),
(4, 2, 'sushi', 3, 90000, 30000),
(4, 3, 'green tea', 7, 105000, 15000),
(4, 1, 'ramen', 2, 100000, 50000),
(5, 3, 'green tea', 3, 45000, 15000),
(5, 2, 'sushi', 2, 60000, 30000),
(5, 1, 'ramen', 1, 50000, 50000),
(6, 1, 'ramen', 1, 50000, 50000),
(6, 2, 'sushi', 2, 60000, 30000),
(6, 3, 'green tea', 2, 30000, 15000),
(7, 1, 'ramen', 1, 50000, 50000),
(7, 2, 'sushi', 2, 60000, 30000),
(7, 3, 'green tea', 1, 15000, 15000),
(8, 1, 'ramen', 3, 150000, 50000),
(8, 2, 'sushi', 1, 30000, 30000),
(8, 3, 'green tea', 1, 15000, 15000),
(9, 1, 'ramen', 1, 50000, 50000),
(9, 2, 'sushi', 3, 90000, 30000),
(9, 3, 'green tea', 3, 45000, 15000),
(10, 3, 'green tea', 1, 15000, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `id_history` int(11) NOT NULL,
  `waktu` time NOT NULL DEFAULT current_timestamp(),
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `saldo` int(25) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `htrans`
--

DROP TABLE IF EXISTS `htrans`;
CREATE TABLE `htrans` (
  `id_htrans` int(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `total` int(25) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `waktu` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `htrans`
--

INSERT INTO `htrans` (`id_htrans`, `email`, `total`, `tanggal`, `waktu`) VALUES
(1, 'aaa@gmail.com', 95000, '2021-11-16', '06:08:53'),
(2, 'aaa@gmail.com', 300000, '2021-11-16', '06:12:10'),
(3, 'aaa@gmail.com', 320000, '2021-11-16', '06:12:54'),
(4, 'aaa@gmail.com', 295000, '2021-11-16', '06:13:55'),
(5, 'aaa@gmail.com', 155000, '2021-11-16', '06:14:11'),
(6, 'aaa@gmail.com', 140000, '2021-11-16', '06:14:23'),
(7, 'aaa@gmail.com', 125000, '2021-11-16', '19:56:40'),
(8, 'aaa@gmail.com', 195000, '2021-11-16', '19:57:49'),
(9, 'aaa@gmail.com', 185000, '2021-11-16', '20:58:43'),
(10, 'aaa@gmail.com', 15000, '2021-11-16', '20:58:53');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id_jenis` int(25) NOT NULL,
  `jenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_jenis`, `jenis`) VALUES
(1, 'makanan'),
(2, 'minuman'),
(3, 'dessert');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id_product` int(25) NOT NULL,
  `id_jenis` int(25) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(25) NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_product`, `id_jenis`, `nama`, `harga`, `deskripsi`) VALUES
(1, 1, 'ramen', 50000, 'ini adalah ramen'),
(2, 1, 'sushi', 30000, 'ini adalah sushi'),
(3, 2, 'green tea', 15000, 'ini adalah green tea');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `saldo` int(25) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`, `nama`, `saldo`, `alamat`, `kota`) VALUES
('aaa@gmail.com', '123', 'aaa', 4845000, 'jl.aaa', 'surabaya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dtrans`
--
ALTER TABLE `dtrans`
  ADD KEY `fk_id_product` (`id_product`),
  ADD KEY `fk_id_htrans` (`id_htrans`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `fk_email` (`email`);

--
-- Indexes for table `htrans`
--
ALTER TABLE `htrans`
  ADD PRIMARY KEY (`id_htrans`),
  ADD KEY `fk_email_htrans` (`email`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `FK_id_jenis` (`id_jenis`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `htrans`
--
ALTER TABLE `htrans`
  MODIFY `id_htrans` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_jenis` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dtrans`
--
ALTER TABLE `dtrans`
  ADD CONSTRAINT `fk_id_htrans` FOREIGN KEY (`id_htrans`) REFERENCES `htrans` (`id_htrans`),
  ADD CONSTRAINT `fk_id_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `fk_email` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `htrans`
--
ALTER TABLE `htrans`
  ADD CONSTRAINT `fk_email_htrans` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_id_jenis` FOREIGN KEY (`id_jenis`) REFERENCES `kategori` (`id_jenis`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
