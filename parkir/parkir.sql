-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 31, 2017 at 12:05 pm
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `parkir`
--

CREATE TABLE IF NOT EXISTS `parkir` (
`id` int(5) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `price` text,
  `picture_dir` varchar(50) DEFAULT NULL,
  `capacity` int(5) DEFAULT NULL,
  `available` int(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parkir`
--

INSERT INTO `parkir` (`id`, `latitude`, `longitude`, `name`, `address`, `price`, `picture_dir`, `capacity`, `available`) VALUES
(1, '-6.59963240', '106.80693690', 'Gedung Ekstensi IPB', 'Jl. Ekstensi Ilkom', '2000', NULL, 500, 222),
(2, '-6.58954960', '106.80402610', 'Botani Square', 'Jl. botani', '5000', NULL, 2500, 2100),
(3, '-6.58958430', '106.80621170', 'Diploma IPB', 'Jl. diploma', '0', NULL, 500, 300),
(4, '-6.61236910', '106.81193820', 'Taman Kencana', 'Jl. Taman Kencana', '2000', NULL, 100, 50),
(5, '-6.59648790', '106.80736270', 'Universitas Pakuan', 'Jl. Universitas Pakuan', '2000', NULL, 1100, 500);

-- --------------------------------------------------------

--
-- Table structure for table `parkir_operator`
--

CREATE TABLE IF NOT EXISTS `parkir_operator` (
  `id_parkir` int(5) NOT NULL,
  `operator` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parkir_operator`
--

INSERT INTO `parkir_operator` (`id_parkir`, `operator`) VALUES
(1, 'steve@gmail.com'),
(1, 'budi@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `parkir_request`
--

CREATE TABLE IF NOT EXISTS `parkir_request` (
`id` int(5) NOT NULL,
  `user` varchar(25) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `price` text,
  `capacity` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parkir_request`
--

INSERT INTO `parkir_request` (`id`, `user`, `latitude`, `longitude`, `name`, `address`, `price`, `capacity`) VALUES
(8, 'a@gmail.com', '99.99999999', '222.00000000', 'aa', 'aaaa', 'a', 200),
(9, 'a@gmail.com', '99.99999999', '222.00000000', 'aa', 'aa', 'aaa', 444),
(10, 'a@gmail.com', '-6.59980470', '106.80700670', 'sss', 'aa', 'aa', 74),
(11, 'a@gmail.com', '-6.59980470', '106.80700670', 'qqqqq', 'qqqq', 'aaa', 123),
(12, 'a@gmail.com', '-6.59980470', '106.80700670', 'tre', 'qwe', '123', 444),
(13, 'a@gmail.com', '-6.59980470', '106.80700670', 'dff', 't', '5', 55),
(14, 'a@gmail.com', '-6.59980470', '106.80700670', 'aa', 'aa', '11', 444),
(15, 'albert@gmail.com', '-6.59983344', '106.80699527', 'aaa', 'aaa', '444', 213),
(16, 'albert@gmail.com', '-6.36395750', '106.70512109', 'avc', 'Jl. aPerumahan Bukit Dago, Rawakalong, Gn. Sindur, Bogor, Jawa Barat 16340, Indonesia', '4444', 444),
(17, 'albert@gmail.com', '99.99999999', '222.00000000', 'Aa', 'Jalan Pajajaran Bogor', '2000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `parkir_save`
--

CREATE TABLE IF NOT EXISTS `parkir_save` (
  `customer` varchar(75) NOT NULL,
  `id_parkir` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parkir_save`
--

INSERT INTO `parkir_save` (`customer`, `id_parkir`) VALUES
('a@gmail.com', 5),
('a@gmail.com', 3),
('albert@gmail.com', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE IF NOT EXISTS `user_admin` (
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_customer`
--

CREATE TABLE IF NOT EXISTS `user_customer` (
  `id` varchar(75) NOT NULL,
  `user_key` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_customer`
--

INSERT INTO `user_customer` (`id`, `user_key`, `password`) VALUES
('a@gmail.com', 'aaaaa', 'eb074f73819c85db0cf8bc99819b8481'),
('albert@gmail.com', 'aaaaa', 'ad2cdf944c7f5852bbed446983bc289e');

-- --------------------------------------------------------

--
-- Table structure for table `user_operator`
--

CREATE TABLE IF NOT EXISTS `user_operator` (
  `id` varchar(25) NOT NULL,
  `user_key` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_operator`
--

INSERT INTO `user_operator` (`id`, `user_key`, `password`) VALUES
('budi@gmail.com', 'aaaaa', NULL),
('steve@gmail.com', 'aaaaa', '2f06356139771eabe1be97e456839409');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parkir`
--
ALTER TABLE `parkir`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkir_operator`
--
ALTER TABLE `parkir_operator`
 ADD KEY `id_parkir` (`id_parkir`), ADD KEY `operator` (`operator`);

--
-- Indexes for table `parkir_request`
--
ALTER TABLE `parkir_request`
 ADD PRIMARY KEY (`id`), ADD KEY `user` (`user`);

--
-- Indexes for table `parkir_save`
--
ALTER TABLE `parkir_save`
 ADD KEY `customer` (`customer`), ADD KEY `id_parkir` (`id_parkir`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
 ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user_customer`
--
ALTER TABLE `user_customer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_operator`
--
ALTER TABLE `user_operator`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parkir`
--
ALTER TABLE `parkir`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `parkir_request`
--
ALTER TABLE `parkir_request`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `parkir_operator`
--
ALTER TABLE `parkir_operator`
ADD CONSTRAINT `fk_id_parkir` FOREIGN KEY (`id_parkir`) REFERENCES `parkir` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_operator` FOREIGN KEY (`operator`) REFERENCES `user_operator` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parkir_request`
--
ALTER TABLE `parkir_request`
ADD CONSTRAINT `fk_user` FOREIGN KEY (`user`) REFERENCES `user_customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parkir_save`
--
ALTER TABLE `parkir_save`
ADD CONSTRAINT `parkir_save_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `user_customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `parkir_save_ibfk_2` FOREIGN KEY (`id_parkir`) REFERENCES `parkir` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
