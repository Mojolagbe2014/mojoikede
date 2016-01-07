-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2015 at 09:41 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `customblog`
--
DROP DATABASE `customblog`;

CREATE DATABASE `customblog`;

USE `customblog`;
-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT 'NULL',
  `meta` varchar(165) DEFAULT 'NULL',
  `title` varchar(75) NOT NULL DEFAULT 'NULL',
  `parent` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `meta`, `title`, `parent`) VALUES
(4, 'Environmental Sanitation', 'Environmental Sanitation', 'Environmental Sanitation', 0),
(7, 'Health', 'New Life', 'New Life', 0),
(9, 'Marketing', 'Marketing', 'Marketing', 0),
(11, 'Rice Sales and Purchase ', 'Rice Sales and ', 'Rice Sales and Purchase in Africa and around the world', 9),
(12, 'Management', 'Management', 'Management', 0),
(13, 'Information Technology', 'Information Technology', 'Information Technology', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'NULL',
  `email` varchar(255) NOT NULL DEFAULT 'NULL',
  `date` date NOT NULL,
  `post_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `name`, `email`, `date`, `post_id`, `status`) VALUES
(3, 'testq.kvjqlkv qlfnv qlnv qljv qj vqjv qljv nqlf', 'Franklin', 'training@lonadek.com', '2015-06-08', 6, 1),
(4, 'Hello my people, awayu doing today?', 'Franklin Anyaso', 'franko172000@yahoo.com', '2015-07-03', 7, 1),
(5, 'Firefox can''t find the server at www.nigerianseminarsandtrainings.com.', 'Franklin Anyaso', 'franko172000@yahoo.com', '2015-07-03', 7, 1),
(6, 'Firefox can''t find the server at www.nigerianseminarsandtrainings.com.', 'Franklin Anyaso', 'franko172000@yahoo.com', '2015-07-03', 7, 1),
(7, 'Wonder ful post, i love this, it has really help me', 'Franklin Anyaso', 'franko172000@yahoo.com', '2015-07-03', 9, 1),
(8, 'Wonder ful post, i love this, it has really help me', 'Franklin Anyaso', 'franko172000@yahoo.com', '2015-07-03', 9, 1),
(10, 'testing thig thing okay', 'Franklin Anyaso', 'franko172000@yahoo.com', '2015-07-03', 9, 1),
(12, 'Wonder ful post, i love this, it has really help meWonder ful post, i love this, it has really help meWonder ful post, i love this, it has really help meWonder ful post, i love this, it has really help meWonder ful post, i love this, it has really help meWonder ful post, i love this, it has really help meWonder ful post, i love this, it has really help meWonder ful post, i love this, it has really help me', 'Franklin Anyaso', 'franko172000@yahoo.com', '2015-07-03', 9, 1),
(14, 'The way I use to show it to the client is by giving them a link to a place where i keep this one PHP file, and a ‘img’ folder where i keep all the images in. The PHP file automatically shows all the images in this folder, and I don’t have to manually update anything, just upload to the folder. You can also use this as a simple photo album with your holiday pictures if you’d like.', 'Kelechi Anyaso', 'franko172000@yahoo.com', '2015-07-03', 9, 1),
(15, 'The way I use to show it to the client is by giving them a link to a place where i keep this one PHP file, and a ‘img’ folder where i keep all the images in. The PHP file automatically shows all the images in this folder, and I don’t have to manually update anything, just upload to the folder. You can also use this as a simple photo album with your holiday pictures if you’d like.', 'Blssing Kaku', 'franko172000@yahoo.com', '2015-07-03', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `link` varchar(1000) NOT NULL,
  `type` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`, `link`, `type`) VALUES
(25, 'Environmental Sanitation', 'environmental-sanitation', 'category'),
(26, 'Health', 'health', 'category'),
(27, 'Marketing', 'marketing', 'category');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `meta_description` varchar(1000) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `category`, `date`, `featured_image`, `meta_description`, `status`) VALUES
(6, 'Management Skills', '<p>Management Skills</p>\r\n', '9:', '2015-06-04', 'http://localhost/customblog/media/storyStrategicManagement.jpg', 'Management Skills', 0),
(7, 'Enterpreneur and Business Management', '<p>Management Skills</p>\r\n', '7:', '2015-06-04', 'http://localhost/customblog/media/training managers.jpg', 'Management Skills', 1),
(9, 'Human Management', '<p>Human Management</p>\r\n', '12:', '2015-06-08', 'http://localhost/customblog/media/udc_hr.jpg', 'Human Management', 0),
(10, 'ICT in Afrcica', '<p>ICT in Afrcica</p>\r\n', '13:', '2015-06-09', 'http://localhost/customblog/media/time.jpg', 'ICT in Afrcica', 0),
(11, 'Ebola Curbing Techniques', '<p>Ebola Curbing Techniques..</p>\r\n\r\n<p>Ebola Curbing Techniques</p>\r\n', '7:', '2015-06-09', 'http://localhost/customblog/media/Promote-CEE-Convention-Tourism-icon.png', 'Ebola Curbing Techniques', 0),
(14, 'HTML Problems', '<p>HTML Problems</p>\r\n', '13:', '2015-06-11', 'http://localhost/customblog/media/write.jpg', 'HTML Problems', 1);

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
