-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 14, 2013 at 09:57 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yamaha`
--

-- --------------------------------------------------------

--
-- Table structure for table `konsumen`
--

CREATE TABLE IF NOT EXISTS `konsumen` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `batasan` int(20) NOT NULL,
  `id_sales` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `konsumen`
--

INSERT INTO `konsumen` (`id`, `nama`, `alamat`, `batasan`, `id_sales`) VALUES
(7, 'Rizaldy Mulyatno', 'petung //31', 1000000, 0),
(9, 'Boan Tando', 'Jl Petung 31', 10000, 8);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `id_user` int(10) NOT NULL,
  `Action` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `tanggal`, `id_user`, `Action`) VALUES
(1, '2013-05-13 13:20:21', 1, 'tambah account sales Nama=Rizaldy Mulyatno dan id=8'),
(2, '2013-05-13 13:22:10', 1, 'tambah account konsumen Nama=Boan Tando dan id=9'),
(7, '2013-05-13 13:42:21', 1, 'Edit account konsumen Nama=Boan Tando dan id=9 set limit=20000000 set alamat = Jl Petung 31'),
(8, '2013-05-13 13:51:05', 1, 'Edit konsumen id=9 set limit 20000000=>1 set alamat = Jl Petung 31'),
(9, '2013-05-13 13:51:26', 1, 'Edit konsumen id=9 set limit 1=>1000000000 set alamat = Jl Petung 31'),
(10, '2013-05-13 13:51:50', 1, 'Edit sales id=8 set target 5000000=>1000000');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `id_parent_modul` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `module`, `id_parent_modul`) VALUES
(1, 'Master Data', NULL),
(2, 'Administrasi', NULL),
(3, 'Transaksi', NULL),
(4, 'Informasi', NULL),
(8, 'Inventori', 5),
(9, 'Farmasi', 5);

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(15) NOT NULL,
  `icon_extra` varchar(10) NOT NULL,
  `id_module` int(11) DEFAULT NULL,
  `status_module` char(1) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_module` (`id_module`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164 ;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `icon`, `icon_extra`, `id_module`, `status_module`, `nama`, `url`) VALUES
(21, '0 -108px', '', 2, '1', 'User System', 'administrasi/usersystem');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`, `status`) VALUES
(1, 'Admin', 1),
(23, 'Sales', 1),
(24, 'Konsumen', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE IF NOT EXISTS `role_permission` (
  `id_role` int(10) unsigned NOT NULL,
  `id_privileges` int(11) DEFAULT NULL,
  KEY `id_role` (`id_role`),
  KEY `id_privileges` (`id_privileges`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id_role`, `id_privileges`) VALUES
(4, 73),
(4, 32),
(4, 37),
(4, 41),
(4, 14),
(4, 15),
(4, 46),
(4, 69),
(4, 70),
(4, 43),
(4, 58),
(4, 40),
(4, 47),
(4, 62),
(4, 13),
(4, 100),
(4, 53),
(4, 61),
(4, 99),
(4, 57),
(4, 101),
(4, 31),
(4, 50),
(4, 49),
(4, 68),
(4, 97),
(4, 66),
(4, 71),
(4, 85),
(4, 56),
(4, 88),
(4, 83),
(4, 84),
(4, 118),
(4, 82),
(4, 63),
(4, 67),
(4, 96),
(4, 95),
(4, 91),
(4, 92),
(5, 14),
(5, 69),
(5, 70),
(5, 19),
(5, 86),
(5, 13),
(5, 103),
(5, 22),
(5, 72),
(5, 93),
(5, 77),
(5, 94),
(5, 74),
(5, 85),
(5, 112),
(5, 78),
(5, 107),
(5, 27),
(5, 28),
(2, 18),
(2, 15),
(2, 46),
(2, 12),
(2, 87),
(2, 16),
(2, 86),
(2, 17),
(2, 62),
(2, 13),
(2, 88),
(6, 18),
(6, 73),
(6, 37),
(6, 41),
(6, 14),
(6, 15),
(6, 46),
(6, 103),
(6, 126),
(6, 69),
(6, 70),
(6, 43),
(6, 12),
(6, 87),
(6, 10),
(6, 127),
(6, 120),
(6, 58),
(6, 40),
(6, 86),
(6, 47),
(6, 17),
(6, 62),
(6, 13),
(6, 60),
(6, 139),
(6, 57),
(6, 128),
(6, 22),
(6, 72),
(6, 48),
(6, 23),
(6, 11),
(6, 77),
(6, 94),
(6, 34),
(6, 31),
(6, 51),
(6, 89),
(6, 50),
(6, 108),
(6, 49),
(6, 106),
(6, 44),
(6, 68),
(6, 97),
(6, 111),
(6, 66),
(6, 122),
(6, 74),
(6, 75),
(6, 76),
(6, 98),
(6, 85),
(6, 24),
(6, 25),
(6, 26),
(6, 80),
(6, 107),
(6, 78),
(6, 36),
(6, 30),
(6, 52),
(6, 27),
(6, 28),
(6, 110),
(6, 56),
(6, 131),
(6, 88),
(6, 109),
(6, 81),
(6, 83),
(6, 84),
(6, 118),
(6, 82),
(6, 63),
(6, 67),
(6, 96),
(6, 95),
(6, 91),
(6, 92),
(6, 113),
(11, 18),
(11, 73),
(11, 32),
(11, 142),
(11, 37),
(11, 145),
(11, 41),
(11, 143),
(11, 144),
(11, 14),
(11, 15),
(11, 46),
(11, 103),
(11, 126),
(11, 69),
(11, 70),
(11, 43),
(11, 12),
(11, 87),
(11, 10),
(11, 19),
(11, 16),
(11, 127),
(11, 120),
(11, 58),
(11, 40),
(11, 86),
(11, 47),
(11, 17),
(11, 62),
(11, 150),
(11, 13),
(11, 100),
(11, 60),
(11, 90),
(11, 130),
(11, 129),
(11, 128),
(11, 133),
(11, 22),
(11, 21),
(11, 23),
(11, 59),
(11, 11),
(11, 121),
(11, 122),
(11, 71),
(11, 65),
(11, 74),
(11, 151),
(11, 75),
(11, 76),
(11, 98),
(11, 85),
(11, 149),
(11, 136),
(11, 141),
(11, 156),
(11, 148),
(11, 117),
(11, 112),
(11, 24),
(11, 147),
(11, 25),
(11, 26),
(11, 154),
(11, 152),
(11, 80),
(11, 153),
(11, 155),
(11, 107),
(11, 78),
(11, 36),
(11, 30),
(11, 52),
(11, 27),
(11, 28),
(11, 110),
(11, 56),
(11, 132),
(11, 134),
(11, 131),
(11, 123),
(11, 88),
(11, 140),
(11, 109),
(11, 81),
(11, 83),
(11, 84),
(11, 118),
(11, 82),
(11, 63),
(11, 67),
(11, 96),
(11, 95),
(11, 91),
(11, 92),
(11, 113),
(12, 142),
(12, 103),
(12, 70),
(12, 16),
(12, 86),
(12, 62),
(12, 139),
(12, 22),
(12, 72),
(12, 59),
(12, 77),
(12, 94),
(12, 74),
(12, 85),
(12, 112),
(12, 24),
(12, 147),
(12, 154),
(12, 152),
(12, 80),
(12, 155),
(12, 27),
(12, 28),
(14, 150),
(14, 145),
(14, 120),
(14, 146),
(14, 119),
(14, 151),
(14, 149),
(14, 147),
(14, 153),
(14, 162),
(17, 49),
(1, 18),
(1, 150),
(1, 73),
(1, 32),
(1, 142),
(1, 37),
(1, 145),
(1, 41),
(1, 143),
(1, 144),
(1, 14),
(1, 15),
(1, 46),
(1, 103),
(1, 126),
(1, 69),
(1, 70),
(1, 43),
(1, 12),
(1, 87),
(1, 10),
(1, 19),
(1, 16),
(1, 127),
(1, 120),
(1, 58),
(1, 40),
(1, 86),
(1, 47),
(1, 17),
(1, 62),
(1, 13),
(1, 100),
(1, 60),
(1, 53),
(1, 61),
(1, 139),
(1, 99),
(1, 57),
(1, 90),
(1, 130),
(1, 129),
(1, 128),
(1, 133),
(1, 22),
(1, 21),
(1, 72),
(1, 48),
(1, 146),
(1, 119),
(1, 23),
(1, 59),
(1, 11),
(1, 121),
(1, 101),
(1, 163),
(1, 77),
(1, 94),
(1, 34),
(1, 31),
(1, 51),
(1, 89),
(1, 50),
(1, 108),
(1, 49),
(1, 102),
(1, 106),
(1, 44),
(1, 68),
(1, 97),
(1, 111),
(1, 66),
(1, 122),
(1, 71),
(1, 65),
(1, 74),
(1, 151),
(1, 75),
(1, 76),
(1, 98),
(1, 85),
(1, 149),
(1, 136),
(1, 141),
(1, 156),
(1, 148),
(1, 117),
(1, 112),
(1, 24),
(1, 147),
(1, 25),
(1, 26),
(1, 154),
(1, 152),
(1, 80),
(1, 153),
(1, 155),
(1, 107),
(1, 78),
(1, 36),
(1, 30),
(1, 52),
(1, 27),
(1, 28),
(1, 162),
(1, 110),
(1, 56),
(1, 132),
(1, 134),
(1, 131),
(1, 123),
(1, 88),
(1, 140),
(1, 109),
(1, 81),
(1, 83),
(1, 84),
(1, 118),
(1, 82),
(1, 63),
(1, 67),
(1, 96),
(1, 95),
(1, 91),
(1, 92),
(1, 113),
(18, 128),
(18, 72),
(18, 24),
(18, 80),
(3, 73),
(3, 32),
(3, 37),
(3, 41),
(3, 15),
(3, 46),
(3, 69),
(3, 43),
(3, 19),
(3, 58),
(3, 40),
(3, 86),
(3, 47),
(3, 100),
(3, 61),
(3, 99),
(3, 57),
(3, 48),
(3, 101),
(3, 34),
(3, 31),
(3, 51),
(3, 89),
(3, 108),
(3, 106),
(3, 44),
(3, 111),
(3, 65),
(3, 76),
(3, 36),
(3, 30),
(3, 52),
(3, 110),
(3, 88),
(3, 109),
(3, 83),
(3, 82),
(3, 96),
(3, 91),
(3, 113),
(16, 117),
(16, 24),
(16, 80),
(9, 77),
(9, 94),
(7, 23),
(7, 59),
(7, 75),
(7, 117),
(7, 24),
(7, 25),
(7, 26),
(7, 80),
(10, 72),
(10, 49),
(10, 24),
(13, 143),
(13, 144),
(13, 127),
(13, 130),
(13, 129),
(13, 128),
(13, 133),
(13, 122),
(13, 98),
(13, 136),
(13, 141),
(13, 132),
(13, 134),
(13, 131),
(13, 140),
(15, 24),
(15, 134),
(15, 131),
(15, 123),
(8, 73),
(8, 32),
(8, 37),
(8, 41),
(8, 69),
(8, 43),
(8, 58),
(8, 40),
(8, 47),
(8, 100),
(8, 57),
(8, 50),
(8, 68),
(8, 66),
(8, 65),
(8, 76),
(8, 85),
(8, 78),
(8, 56),
(8, 84),
(8, 63),
(8, 67),
(8, 92),
(23, 21);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `nama`, `target`) VALUES
(4, 'Adhy', '1000000'),
(8, 'Rizaldy Mulyatno', '1000000');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `nama`) VALUES
(7, 'Main Dealer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `last_access` datetime NOT NULL,
  `member_for` datetime NOT NULL,
  `id_role` int(10) unsigned DEFAULT NULL,
  `status` int(1) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `id_layout` char(1) NOT NULL,
  UNIQUE KEY `username` (`username`),
  KEY `id` (`id`),
  KEY `id_role` (`id_role`),
  KEY `id_unit` (`id_unit`),
  KEY `id_unit_2` (`id_unit`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `last_access`, `member_for`, `id_role`, `status`, `id_unit`, `id_layout`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '2013-05-14 14:51:56', '2011-09-14 11:47:31', 1, 1, 7, '1'),
(9, 'boan', '9ae4ade0adc6950b80a670d2070a9a6c', '0000-00-00 00:00:00', '2013-05-13 13:22:10', 24, 1, 7, '1'),
(8, 'orankaneh', '9ae4ade0adc6950b80a670d2070a9a6c', '2013-05-14 14:02:40', '2013-05-13 13:20:21', 23, 1, 7, '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
