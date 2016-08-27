-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2016 at 12:30 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `advert_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `advert`
--

DROP TABLE IF EXISTS `advert`;
CREATE TABLE IF NOT EXISTS `advert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `format` varchar(100) NOT NULL,
  `follow` tinyint(2) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `background` varchar(100) NOT NULL,
  `zone_one` varchar(100) NOT NULL,
  `zone_one_alt` varchar(100) NOT NULL,
  `zone_two` varchar(100) NOT NULL,
  `zone_two_alt` varchar(100) NOT NULL,
  `zone_three` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advert`
--

INSERT INTO `advert` (`id`, `name`, `link`, `format`, `follow`, `status`, `background`, `zone_one`, `zone_one_alt`, `zone_two`, `zone_two_alt`, `zone_three`) VALUES
(1, 'Testing Advert', 'http://www.mojolagbe.com', 'landscape', 0, 1, '436044_background.jpg', '800708_zoneone.png', '653739_zoneonealt.png', '144989_zonetwo.png', '983494_zonetwoalt.png', '228869_zonethree.png'),
(2, 'Testing Advert2', 'http://www.mojolagbe.com', 'landscape', 0, 1, '564255_background.png', '881897_zoneone.png', '784586_zoneonealt.png', '963581_zonetwo.png', '941196_zonetwoalt.png', '624707_zonethree.png');

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

DROP TABLE IF EXISTS `adverts`;
CREATE TABLE IF NOT EXISTS `adverts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `link` varchar(600) NOT NULL,
  `content` text NOT NULL,
  `size` varchar(230) NOT NULL,
  `type` varchar(400) NOT NULL,
  `position` varchar(400) NOT NULL,
  `location` varchar(500) NOT NULL,
  `follow` varchar(30) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adverts`
--

INSERT INTO `adverts` (`id`, `name`, `link`, `content`, `size`, `type`, `position`, `location`, `follow`, `status`) VALUES
(3, 'Header', 'https://www.nigerianseminarsandtrainings.com/', 'https://www.nigerianseminarsandtrainings.com/', 'Landscape (728 x 90)', 'PPC (Pay Per Click)', 'Main Page', 'Top Banner', '1', 1),
(6, 'New Advert', 'https://www.nigerianseminarsandtrainings.com/', 'https://www.nigerianseminarsandtrainings.com/images/favicon.ico', 'Portrait 2 (300 X 300)', 'DIA (Direct Image Ads)', 'Top Banner', 'Main Page', '0', 1),
(7, 'Header', 'https://www.nigerianseminarsandtrainings.com/', 'https://www.nigerianseminarsandtrainings.com/', 'Landscape (728 x 90)', 'PPC (Pay Per Click)', 'Main Page', 'Top Banner', '0', 0),
(8, 'Header', 'https://www.nigerianseminarsandtrainings.com/', 'https://www.nigerianseminarsandtrainings.com/', 'Landscape (728 x 90)', 'DIA (Direct Image Ads)', 'Main Page', 'Page Banner Bottom', '', 1),
(9, 'Jamiu', 'https://www.nigerianseminarsandtrainings.com/', 'https://www.nigerianseminarsandtrainings.com/', 'Portrait 1 (250 x 300)', 'DIA (Direct Image Ads)', 'Main Page', 'Side Banner 2', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `firstname` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `lastname` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `role` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `date_registered` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `role`, `date_registered`) VALUES
(1, 'Admin1', 'ae2b1fca515949e5d54fb22b8ed95575', 'Anyasos', 'Franklin', 'Editor', '2015-05-28'),
(2, 'Mojolagbe', 'ae2b1fca515949e5d54fb22b8ed95575', 'Babatunde', 'Jamiu', 'Admin', '2015-06-19');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
