-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2016 at 12:51 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `advert-manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `role`, `date_registered`) VALUES
(1, 'Admin1', 'ae2b1fca515949e5d54fb22b8ed95575', 'Anyasos', 'Franklin', 'Editor', '2015-05-28'),
(2, 'Mojolagbe', 'ae2b1fca515949e5d54fb22b8ed95575', 'Babatunde', 'Jamiu', 'Admin', '2015-06-19');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
