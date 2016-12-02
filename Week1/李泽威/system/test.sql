-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-12 00:00:42
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `edit`
--

CREATE TABLE IF NOT EXISTS `edit` (
  `id_tr` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `studyid` int(11) NOT NULL,
  `name` char(255) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `class` varchar(50) NOT NULL,
  `identity` char(50) NOT NULL,
  `birth` date NOT NULL,
  `idtype` varchar(50) NOT NULL,
  `idnub` varchar(255) NOT NULL,
  `telenub` varchar(255) NOT NULL,
  `nation` char(255) NOT NULL,
  `home` char(255) NOT NULL,
  `award` text NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id_tr`),
  UNIQUE KEY `studyid` (`studyid`),
  UNIQUE KEY `studyid_2` (`studyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `edit_t`
--

CREATE TABLE IF NOT EXISTS `edit_t` (
  `id_tr` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `studyid` int(11) NOT NULL,
  `name` char(255) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `class` varchar(50) NOT NULL,
  `identity` char(50) NOT NULL,
  `birth` date NOT NULL,
  `idtype` varchar(50) NOT NULL,
  `idnub` varchar(255) NOT NULL,
  `telenub` varchar(255) NOT NULL,
  `nation` char(255) NOT NULL,
  `home` char(255) NOT NULL,
  `award` text NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id_tr`),
  UNIQUE KEY `studyid` (`studyid`),
  UNIQUE KEY `studyid_2` (`studyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studyid` int(11) NOT NULL,
  `name` char(255) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `class` varchar(50) NOT NULL,
  `identity` char(50) NOT NULL,
  `password` char(100) NOT NULL,
  `birth` date DEFAULT NULL,
  `idtype` varchar(50) DEFAULT NULL,
  `idnub` varchar(255) DEFAULT NULL,
  `telenub` varchar(255) DEFAULT NULL,
  `nation` char(255) DEFAULT NULL,
  `home` char(255) DEFAULT NULL,
  `award` text,
  `image` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `studyid` (`studyid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`id`, `studyid`, `name`, `age`, `sex`, `class`, `identity`, `password`, `birth`, `idtype`, `idnub`, `telenub`, `nation`, `home`, `award`, `image`) VALUES
(1, 100000, '李泽威', 29, 'male', 'g1b1', 'teacher', '111', '0000-00-00', 'town', '                     ', '                     ', '', '', '                     ', '13667110938.jpg'),
(2, 100001, '李一', 11, 'male', 'g1b1', 'teacher', '123', '0000-00-00', '', '   ', '   ', '', '', '   ', '13667110938.jpg'),
(3, 100002, '李二', 10, 'male', 'g1b1', 'teacher', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(4, 100004, '李三', 9, 'male', 'g1b1', 'teacher', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(5, 100005, '李四', 12, 'male', 'g1b1', 'teacher', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(6, 100006, '李五', 13, 'male', 'g1b1', 'teacher', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(7, 100007, '李六', 12, 'male', 'g1b1', 'teacher', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(8, 100009, '李八', 14, 'male', 'g1b1', 'teacher', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(9, 100010, '李九', 11, 'male', 'g1b1', 'teacher', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(10, 100008, '李七', 10, 'male', 'g1b1', 'teacher', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(12, 111110, '马大山', 11, 'male', 'g1b1', 'student', '123', '0000-00-00', 'vill', '       ', '       ', '', '', '       ', '22-090423_51.jpg'),
(13, 111111, '马一', 8, 'male', 'g1b1', 'student', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(14, 111112, '马二', 10, 'male', 'g1b1', 'student', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(15, 111113, '马三', 13, 'male', 'g1b1', 'student', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(17, 111115, '马五', 9, 'male', 'g1b1', 'student', '123', '0000-00-00', '', ' ', ' ', '', '', ' ', ''),
(18, 111116, '马六', 11, 'male', 'g1b1', 'student', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(19, 111117, '马七', 10, 'male', 'g1b1', 'student', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(20, 111118, '马八', 10, 'male', 'g1b1', 'student', '123', '0000-00-00', '', ' ', ' ', '', '', ' ', ''),
(21, 111119, '马九', 14, 'male', 'g1b1', 'student', '123', '0000-00-00', '', ' ', ' ', '', '', ' ', ''),
(22, 111121, '王大山', 8, 'male', 'g1b1', 'student', '123', '0000-00-00', '', '  ', '  ', '', '', '  ', ''),
(24, 123456, '李大柱', 4, 'male', 'g1b1', 'student', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(27, 145678, 'zhangsan', 6, 'male', 'g1b1', 'root', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(28, 666666, 'root', 16, 'male', 'g1b1', 'root', 'root', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(29, 666665, 'root', 16, 'male', 'g1b1', 'root', 'root', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(30, 666664, 'root', 17, 'male', 'g1b1', 'root', 'root', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(31, 666663, 'root', 17, 'male', 'g1b1', 'root', 'root', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(32, 555555, '陈泽康', 11, 'male', 'g1b1', 'student', '123', '0000-00-00', '', '  ', '  ', '', '', '  ', '13667110938.jpg'),
(36, 454545, '江晓晴', 3, 'female', 'g2b2', 'teacher', '123', '0000-00-00', 'town', ' ', ' ', '', '', ' ', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
