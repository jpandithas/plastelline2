-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2015 at 02:51 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fyp3`
--

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE IF NOT EXISTS `basket` (
  `basket_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `status` enum('ordered','processed','empty','complete') DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`basket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `layer1`
--

CREATE TABLE IF NOT EXISTS `layer1` (
  `tier_id` int(11) NOT NULL,
  `wordname` varchar(20) NOT NULL,
  `reference_wordname` varchar(20) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `wordgroup` int(11) NOT NULL,
  PRIMARY KEY (`wordname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `layer1`
--

INSERT INTO `layer1` (`tier_id`, `wordname`, `reference_wordname`, `reference_id`, `wordgroup`) VALUES
(4, 'a', NULL, NULL, 0),
(4, 'about', NULL, NULL, 0),
(1, 'add', NULL, NULL, 2),
(4, 'all', NULL, NULL, 0),
(4, 'also', NULL, NULL, 0),
(3, 'alter', 'edit', 1, 2),
(4, 'an', NULL, NULL, 0),
(4, 'and', NULL, NULL, 0),
(4, 'any', NULL, NULL, 0),
(4, 'as', NULL, NULL, 0),
(4, 'at', NULL, NULL, 0),
(4, 'be', NULL, NULL, 0),
(4, 'but', NULL, NULL, 0),
(4, 'by', NULL, NULL, 0),
(4, 'can', NULL, NULL, 0),
(2, 'category', NULL, NULL, 2),
(3, 'change', 'edit', 1, 2),
(2, 'chat', NULL, NULL, 5),
(2, 'commands', NULL, NULL, 5),
(3, 'create', 'add', 1, 2),
(1, 'delete', NULL, NULL, 2),
(1, 'display', NULL, NULL, 2),
(4, 'do', NULL, NULL, 0),
(1, 'edit', NULL, NULL, 2),
(3, 'exit', 'logout', 1, 3),
(4, 'for', NULL, NULL, 0),
(4, 'from', NULL, NULL, 0),
(3, 'get', 'display', 1, 2),
(4, 'give', NULL, NULL, 0),
(4, 'go', NULL, NULL, 0),
(4, 'have', NULL, NULL, 0),
(4, 'how', NULL, NULL, 0),
(4, 'i', NULL, NULL, 0),
(4, 'in', NULL, NULL, 0),
(4, 'into', NULL, NULL, 0),
(4, 'it', NULL, NULL, 0),
(3, 'leave', 'logout', 1, 2),
(4, 'like', NULL, NULL, 0),
(1, 'logout', NULL, NULL, 3),
(4, 'look', NULL, NULL, 0),
(3, 'make', 'add', 1, 2),
(3, 'modify', 'edit', 1, 2),
(4, 'most', NULL, NULL, 0),
(4, 'my', NULL, NULL, 0),
(4, 'new', NULL, NULL, 0),
(4, 'no', NULL, NULL, 0),
(4, 'not', NULL, NULL, 0),
(4, 'of', NULL, NULL, 0),
(4, 'on', NULL, NULL, 0),
(4, 'or', NULL, NULL, 0),
(4, 'other', NULL, NULL, 0),
(2, 'page', NULL, NULL, 2),
(4, 'people', NULL, NULL, 0),
(2, 'product', NULL, NULL, 2),
(3, 'quit', 'logout', 1, 2),
(3, 'remove', 'delete', 1, 2),
(4, 'say', NULL, NULL, 0),
(4, 'see', NULL, NULL, 0),
(3, 'show', 'display', 1, 2),
(4, 'so', NULL, NULL, 0),
(4, 'some', NULL, NULL, 0),
(3, 'teach', 'train', 1, 5),
(4, 'than', NULL, NULL, 0),
(4, 'that', NULL, NULL, 0),
(4, 'the', NULL, NULL, 0),
(4, 'then', NULL, NULL, 0),
(4, 'these', NULL, NULL, 0),
(4, 'this', NULL, NULL, 0),
(4, 'to', NULL, NULL, 0),
(1, 'train', NULL, 1, 5),
(4, 'use', NULL, NULL, 0),
(2, 'user', NULL, NULL, 2),
(4, 'what', NULL, NULL, 0),
(4, 'will', NULL, NULL, 0),
(4, 'with', NULL, NULL, 0),
(4, 'work', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(40) NOT NULL,
  `cat_specs` text,
  `cat_table_name` varchar(50) NOT NULL,
  `cat_img` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_name`
--

CREATE TABLE IF NOT EXISTS `prod_name` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `prod_name` varchar(50) NOT NULL,
  `prod_desc` text,
  `prod_price` float NOT NULL,
  `prod_avail` int(11) NOT NULL,
  `prod_img` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `rid` bigint(20) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `function` varchar(255) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`rid`, `action`, `type`, `id`, `function`) VALUES
(1, 'edit', 'page', NULL, 'mod_edit_page'),
(2, 'logout', NULL, NULL, 'mod_logout');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setid` int(11) NOT NULL AUTO_INCREMENT,
  `logo_path` varchar(50) NOT NULL,
  `site_name` varchar(50) NOT NULL,
  `footer_msg` text,
  `currency` varchar(30) NOT NULL,
  PRIMARY KEY (`setid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `userclass` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `email`, `name`, `surname`, `userclass`) VALUES
(1, 'root', 'root', 'iampanoz@hotmail.com', 'root', 'root', 0);

-- --------------------------------------------------------

--
-- Table structure for table `web_content`
--

CREATE TABLE IF NOT EXISTS `web_content` (
  `wcid` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `wtitle` varchar(150) NOT NULL,
  PRIMARY KEY (`wcid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `web_content`
--

INSERT INTO `web_content` (`wcid`, `content`, `alias`, `wtitle`) VALUES
(2, 'Body Text', 'Alias 1', 'Sample Page'),
(3, 'This is another page made easy with Plasteline ', 'demopage2', 'This is another page'),
(4, 'This is a new page edited', 'pagenew', 'New Web Page');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
