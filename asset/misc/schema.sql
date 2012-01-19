-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: *****************
-- Generation Time: Jan 19, 2012 at 12:50 PM
-- Server version: 5.1.53
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `mozhunt`
--

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

CREATE TABLE IF NOT EXISTS `domain` (
  `domainID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `imgSet` tinyint(1) DEFAULT '0',
  `apiKey` char(32) DEFAULT NULL,
  `apiSecret` char(32) DEFAULT NULL,
  `domainStatus` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`domainID`),
  UNIQUE KEY `apiKey` (`apiKey`,`apiSecret`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `tokenID` int(11) NOT NULL AUTO_INCREMENT,
  `domainID` int(11) DEFAULT NULL,
  `name` varchar(140) DEFAULT NULL,
  `clue` varchar(140) DEFAULT NULL,
  `tokenStatus` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`tokenID`),
  UNIQUE KEY `clue` (`clue`),
  KEY `domainID` (`domainID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(254) DEFAULT NULL,
  `password` char(128) DEFAULT NULL COMMENT 'sha512',
  `nickname` varchar(30) DEFAULT NULL,
  `userStatus` tinyint(4) DEFAULT '4',
  `lastActive` int(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `email` (`email`,`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userToken`
--

CREATE TABLE IF NOT EXISTS `userToken` (
  `userID` int(11) NOT NULL DEFAULT '0',
  `tokenID` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`userID`,`tokenID`,`id`),
  UNIQUE KEY `id` (`id`),
  KEY `tokenID` (`tokenID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `domain`
--
ALTER TABLE `domain`
  ADD CONSTRAINT `domain_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`domainID`) REFERENCES `domain` (`domainID`);

--
-- Constraints for table `userToken`
--
ALTER TABLE `userToken`
  ADD CONSTRAINT `userToken_ibfk_2` FOREIGN KEY (`tokenID`) REFERENCES `token` (`tokenID`),
  ADD CONSTRAINT `userToken_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);
