-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2011 at 12:30 PM
-- Server version: 5.5.15
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lottoCntr`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alc_49`
--

CREATE TABLE IF NOT EXISTS `tbl_alc_49` (
  `alc49id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`alc49id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alc_bucko`
--

CREATE TABLE IF NOT EXISTS `tbl_alc_bucko` (
  `alcbuckoid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` int(11) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  PRIMARY KEY (`alcbuckoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alc_keno`
--

CREATE TABLE IF NOT EXISTS `tbl_alc_keno` (
  `alckenoid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  `snum8` int(11) DEFAULT NULL,
  `snum9` int(11) DEFAULT NULL,
  `snum10` int(11) DEFAULT NULL,
  `snum11` int(11) DEFAULT NULL,
  `snum12` int(11) DEFAULT NULL,
  `snum13` int(11) DEFAULT NULL,
  `snum14` int(11) DEFAULT NULL,
  `snum15` int(11) DEFAULT NULL,
  `snum16` int(11) DEFAULT NULL,
  `snum17` int(11) DEFAULT NULL,
  `snum18` int(11) DEFAULT NULL,
  `snum19` int(11) DEFAULT NULL,
  `snum20` int(11) DEFAULT NULL,
  PRIMARY KEY (`alckenoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alc_pik4`
--

CREATE TABLE IF NOT EXISTS `tbl_alc_pik4` (
  `alcpik4id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  PRIMARY KEY (`alcpik4id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alc_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_alc_tag` (
  `alctagid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  PRIMARY KEY (`alctagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_archive_stats`
--

CREATE TABLE IF NOT EXISTS `tbl_archive_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surl` varchar(255) DEFAULT NULL,
  `last-fetched` datetime DEFAULT NULL,
  `sgame` varchar(45) DEFAULT NULL,
  `iday` int(11) DEFAULT NULL,
  `imonth` int(11) DEFAULT NULL,
  `iyear` int(11) DEFAULT NULL,
  `sfile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bclc_49`
--

CREATE TABLE IF NOT EXISTS `tbl_bclc_49` (
  `bclc49id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`bclc49id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bclc_49_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_bclc_49_winnings` (
  `bclc49winningid` int(11) NOT NULL AUTO_INCREMENT,
  `bclc49id` int(11) DEFAULT NULL,
  `m_6_count` int(11) DEFAULT NULL,
  `m_6_amount` double DEFAULT NULL,
  `m_6_region` varchar(45) DEFAULT NULL,
  `m_5_b_count` int(11) DEFAULT NULL,
  `m_5_b_amount` double DEFAULT NULL,
  `m_5_b_region` varchar(45) DEFAULT NULL,
  `m_5_count` int(11) DEFAULT NULL,
  `m_5_amount` double DEFAULT NULL,
  `m_4_count` int(11) DEFAULT NULL,
  `m_4_amount` double DEFAULT NULL,
  `m_3_count` int(11) DEFAULT NULL,
  `m_3_amount` double DEFAULT NULL,
  `m_2_b_count` int(11) DEFAULT NULL,
  `m_2_b_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`bclc49winningid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bclc_extra`
--

CREATE TABLE IF NOT EXISTS `tbl_bclc_extra` (
  `bclcextraid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`bclcextraid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bclc_extra_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_bclc_extra_winnings` (
  `bclcextrawinningid` int(11) NOT NULL AUTO_INCREMENT,
  `bclcextraid` int(11) DEFAULT NULL,
  `m_4_count` int(11) DEFAULT NULL,
  `m_4_amount` double DEFAULT NULL,
  `m_3_count` int(11) DEFAULT NULL,
  `m_3_amount` double DEFAULT NULL,
  `m_2_count` int(11) DEFAULT NULL,
  `m_2_amount` double DEFAULT NULL,
  `m_1_count` int(11) DEFAULT NULL,
  `m_1_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`bclcextrawinningid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bclc_keno`
--

CREATE TABLE IF NOT EXISTS `tbl_bclc_keno` (
  `bclckenoid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  `snum8` int(11) DEFAULT NULL,
  `snum9` int(11) DEFAULT NULL,
  `snum10` int(11) DEFAULT NULL,
  `snum11` int(11) DEFAULT NULL,
  `snum12` int(11) DEFAULT NULL,
  `snum13` int(11) DEFAULT NULL,
  `snum14` int(11) DEFAULT NULL,
  `snum15` int(11) DEFAULT NULL,
  `snum16` int(11) DEFAULT NULL,
  `snum17` int(11) DEFAULT NULL,
  `snum18` int(11) DEFAULT NULL,
  `snum19` int(11) DEFAULT NULL,
  `snum20` int(11) DEFAULT NULL,
  PRIMARY KEY (`bclckenoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bclc_keno_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_bclc_keno_winnings` (
  `bclckenowinningid` int(11) NOT NULL AUTO_INCREMENT,
  `bclckenoid` int(11) DEFAULT NULL,
  `m_10_10_1_count` int(11) DEFAULT NULL,
  `m_10_10_1_amount` int(11) DEFAULT NULL,
  `m_10_9_1_count` int(11) DEFAULT NULL,
  `m_10_9_1_amount` int(11) DEFAULT NULL,
  `m_10_8_1_count` int(11) DEFAULT NULL,
  `m_10_8_1_amount` int(11) DEFAULT NULL,
  `m_10_7_1_count` int(11) DEFAULT NULL,
  `m_10_7_1_amount` int(11) DEFAULT NULL,
  `m_10_6_1_count` int(11) DEFAULT NULL,
  `m_10_6_1_amount` int(11) DEFAULT NULL,
  `m_10_5_1_count` int(11) DEFAULT NULL,
  `m_10_5_1_amount` int(11) DEFAULT NULL,
  `m_10_0_1_count` int(11) DEFAULT NULL,
  `m_10_0_1_amount` int(11) DEFAULT NULL,
  `m_9_9_1_count` int(11) DEFAULT NULL,
  `m_9_9_1_amount` int(11) DEFAULT NULL,
  `m_9_8_1_count` int(11) DEFAULT NULL,
  `m_9_8_1_amount` int(11) DEFAULT NULL,
  `m_9_7_1_count` int(11) DEFAULT NULL,
  `m_9_7_1_amount` int(11) DEFAULT NULL,
  `m_9_6_1_count` int(11) DEFAULT NULL,
  `m_9_6_1_amount` int(11) DEFAULT NULL,
  `m_9_5_1_count` int(11) DEFAULT NULL,
  `m_9_5_1_amount` int(11) DEFAULT NULL,
  `m_9_4_1_count` int(11) DEFAULT NULL,
  `m_9_4_1_amount` int(11) DEFAULT NULL,
  `m_8_8_1_count` int(11) DEFAULT NULL,
  `m_8_8_1_amount` int(11) DEFAULT NULL,
  `m_8_7_1_count` int(11) DEFAULT NULL,
  `m_8_7_1_amount` int(11) DEFAULT NULL,
  `m_8_6_1_count` int(11) DEFAULT NULL,
  `m_8_6_1_amount` int(11) DEFAULT NULL,
  `m_8_5_1_count` int(11) DEFAULT NULL,
  `m_8_5_1_amount` int(11) DEFAULT NULL,
  `m_8_4_1_count` int(11) DEFAULT NULL,
  `m_8_4_1_amount` int(11) DEFAULT NULL,
  `m_7_7_1_count` int(11) DEFAULT NULL,
  `m_7_7_1_amount` int(11) DEFAULT NULL,
  `m_7_6_1_count` int(11) DEFAULT NULL,
  `m_7_6_1_amount` int(11) DEFAULT NULL,
  `m_7_5_1_count` int(11) DEFAULT NULL,
  `m_7_5_1_amount` int(11) DEFAULT NULL,
  `m_7_4_1_count` int(11) DEFAULT NULL,
  `m_7_4_1_amount` int(11) DEFAULT NULL,
  `m_7_3_1_count` int(11) DEFAULT NULL,
  `m_7_3_1_amount` int(11) DEFAULT NULL,
  `m_6_6_1_count` int(11) DEFAULT NULL,
  `m_6_6_1_amount` int(11) DEFAULT NULL,
  `m_6_5_1_count` int(11) DEFAULT NULL,
  `m_6_5_1_amount` int(11) DEFAULT NULL,
  `m_6_4_1_count` int(11) DEFAULT NULL,
  `m_6_4_1_amount` int(11) DEFAULT NULL,
  `m_6_3_1_count` int(11) DEFAULT NULL,
  `m_6_3_1_amount` int(11) DEFAULT NULL,
  `m_5_5_1_count` int(11) DEFAULT NULL,
  `m_5_5_1_amount` int(11) DEFAULT NULL,
  `m_5_4_1_count` int(11) DEFAULT NULL,
  `m_5_4_1_amount` int(11) DEFAULT NULL,
  `m_5_3_1_count` int(11) DEFAULT NULL,
  `m_5_3_1_amount` int(11) DEFAULT NULL,
  `m_4_4_1_count` int(11) DEFAULT NULL,
  `m_4_4_1_amount` int(11) DEFAULT NULL,
  `m_4_3_1_count` int(11) DEFAULT NULL,
  `m_4_3_1_amount` int(11) DEFAULT NULL,
  `m_4_2_1_count` int(11) DEFAULT NULL,
  `m_4_2_1_amount` int(11) DEFAULT NULL,
  `m_3_3_1_count` int(11) DEFAULT NULL,
  `m_3_3_1_amount` int(11) DEFAULT NULL,
  `m_3_2_1_count` int(11) DEFAULT NULL,
  `m_3_2_1_amount` int(11) DEFAULT NULL,
  `m_2_2_1_count` int(11) DEFAULT NULL,
  `m_2_2_1_amount` int(11) DEFAULT NULL,
  `m_1_1_1_count` int(11) DEFAULT NULL,
  `m_1_1_1_amount` int(11) DEFAULT NULL,
  `m_10_10_3_count` int(11) DEFAULT NULL,
  `m_10_10_3_amount` int(11) DEFAULT NULL,
  `m_10_9_3_count` int(11) DEFAULT NULL,
  `m_10_9_3_amount` int(11) DEFAULT NULL,
  `m_10_8_3_count` int(11) DEFAULT NULL,
  `m_10_8_3_amount` int(11) DEFAULT NULL,
  `m_10_7_3_count` int(11) DEFAULT NULL,
  `m_10_7_3_amount` int(11) DEFAULT NULL,
  `m_10_6_3_count` int(11) DEFAULT NULL,
  `m_10_6_3_amount` int(11) DEFAULT NULL,
  `m_10_5_3_count` int(11) DEFAULT NULL,
  `m_10_5_3_amount` int(11) DEFAULT NULL,
  `m_10_0_3_count` int(11) DEFAULT NULL,
  `m_10_0_3_amount` int(11) DEFAULT NULL,
  `m_9_9_3_count` int(11) DEFAULT NULL,
  `m_9_9_3_amount` int(11) DEFAULT NULL,
  `m_9_8_3_count` int(11) DEFAULT NULL,
  `m_9_8_3_amount` int(11) DEFAULT NULL,
  `m_9_7_3_count` int(11) DEFAULT NULL,
  `m_9_7_3_amount` int(11) DEFAULT NULL,
  `m_9_6_3_count` int(11) DEFAULT NULL,
  `m_9_6_3_amount` int(11) DEFAULT NULL,
  `m_9_5_3_count` int(11) DEFAULT NULL,
  `m_9_5_3_amount` int(11) DEFAULT NULL,
  `m_9_4_3_count` int(11) DEFAULT NULL,
  `m_9_4_3_amount` int(11) DEFAULT NULL,
  `m_8_8_3_count` int(11) DEFAULT NULL,
  `m_8_8_3_amount` int(11) DEFAULT NULL,
  `m_8_7_3_count` int(11) DEFAULT NULL,
  `m_8_7_3_amount` int(11) DEFAULT NULL,
  `m_8_6_3_count` int(11) DEFAULT NULL,
  `m_8_6_3_amount` int(11) DEFAULT NULL,
  `m_8_5_3_count` int(11) DEFAULT NULL,
  `m_8_5_3_amount` int(11) DEFAULT NULL,
  `m_8_4_3_count` int(11) DEFAULT NULL,
  `m_8_4_3_amount` int(11) DEFAULT NULL,
  `m_7_7_3_count` int(11) DEFAULT NULL,
  `m_7_7_3_amount` int(11) DEFAULT NULL,
  `m_7_6_3_count` int(11) DEFAULT NULL,
  `m_7_6_3_amount` int(11) DEFAULT NULL,
  `m_7_5_3_count` int(11) DEFAULT NULL,
  `m_7_5_3_amount` int(11) DEFAULT NULL,
  `m_7_4_3_count` int(11) DEFAULT NULL,
  `m_7_4_3_amount` int(11) DEFAULT NULL,
  `m_7_3_3_count` int(11) DEFAULT NULL,
  `m_7_3_3_amount` int(11) DEFAULT NULL,
  `m_6_6_3_count` int(11) DEFAULT NULL,
  `m_6_6_3_amount` int(11) DEFAULT NULL,
  `m_6_5_3_count` int(11) DEFAULT NULL,
  `m_6_5_3_amount` int(11) DEFAULT NULL,
  `m_6_4_3_count` int(11) DEFAULT NULL,
  `m_6_4_3_amount` int(11) DEFAULT NULL,
  `m_6_3_3_count` int(11) DEFAULT NULL,
  `m_6_3_3_amount` int(11) DEFAULT NULL,
  `m_5_5_3_count` int(11) DEFAULT NULL,
  `m_5_5_3_amount` int(11) DEFAULT NULL,
  `m_5_4_3_count` int(11) DEFAULT NULL,
  `m_5_4_3_amount` int(11) DEFAULT NULL,
  `m_5_3_3_count` int(11) DEFAULT NULL,
  `m_5_3_3_amount` int(11) DEFAULT NULL,
  `m_4_4_3_count` int(11) DEFAULT NULL,
  `m_4_4_3_amount` int(11) DEFAULT NULL,
  `m_4_3_3_count` int(11) DEFAULT NULL,
  `m_4_3_3_amount` int(11) DEFAULT NULL,
  `m_4_2_3_count` int(11) DEFAULT NULL,
  `m_4_2_3_amount` int(11) DEFAULT NULL,
  `m_3_3_3_count` int(11) DEFAULT NULL,
  `m_3_3_3_amount` int(11) DEFAULT NULL,
  `m_3_2_3_count` int(11) DEFAULT NULL,
  `m_3_2_3_amount` int(11) DEFAULT NULL,
  `m_2_2_3_count` int(11) DEFAULT NULL,
  `m_2_2_3_amount` int(11) DEFAULT NULL,
  `m_1_1_3_count` int(11) DEFAULT NULL,
  `m_1_1_3_amount` int(11) DEFAULT NULL,
  `m_cc_20_0_count` int(11) DEFAULT NULL,
  `m_cc_20_0_amount` int(11) DEFAULT NULL,
  `m_cc_19_1_count` int(11) DEFAULT NULL,
  `m_cc_19_1_amount` int(11) DEFAULT NULL,
  `m_cc_18_2_count` int(11) DEFAULT NULL,
  `m_cc_18_2_amount` int(11) DEFAULT NULL,
  `m_cc_17_3_count` int(11) DEFAULT NULL,
  `m_cc_17_3_amount` int(11) DEFAULT NULL,
  `m_cc_16_4_count` int(11) DEFAULT NULL,
  `m_cc_16_4_amount` int(11) DEFAULT NULL,
  `m_cc_15_5_count` int(11) DEFAULT NULL,
  `m_cc_15_5_amount` int(11) DEFAULT NULL,
  `m_cc_14_6_count` int(11) DEFAULT NULL,
  `m_cc_14_6_amount` int(11) DEFAULT NULL,
  `m_cc_13_7_count` int(11) DEFAULT NULL,
  `m_cc_13_7_amount` int(11) DEFAULT NULL,
  `m_dd_20_0_count` int(11) DEFAULT NULL,
  `m_dd_20_0_amount` int(11) DEFAULT NULL,
  `m_dd_19_1_count` int(11) DEFAULT NULL,
  `m_dd_19_1_amount` int(11) DEFAULT NULL,
  `m_dd_18_2_count` int(11) DEFAULT NULL,
  `m_dd_18_2_amount` int(11) DEFAULT NULL,
  `m_dd_17_3_count` int(11) DEFAULT NULL,
  `m_dd_17_3_amount` int(11) DEFAULT NULL,
  `m_dd_16_4_count` int(11) DEFAULT NULL,
  `m_dd_16_4_amount` int(11) DEFAULT NULL,
  `m_dd_15_5_count` int(11) DEFAULT NULL,
  `m_dd_15_5_amount` int(11) DEFAULT NULL,
  `m_dd_14_6_count` int(11) DEFAULT NULL,
  `m_dd_14_6_amount` int(11) DEFAULT NULL,
  `m_dd_13_7_count` int(11) DEFAULT NULL,
  `m_dd_13_7_amount` int(11) DEFAULT NULL,
  `m_be_20_0_count` int(11) DEFAULT NULL,
  `m_be_20_0_amount` int(11) DEFAULT NULL,
  `m_be_19_1_count` int(11) DEFAULT NULL,
  `m_be_19_1_amount` int(11) DEFAULT NULL,
  `m_be_18_2_count` int(11) DEFAULT NULL,
  `m_be_18_2_amount` int(11) DEFAULT NULL,
  `m_be_17_3_count` int(11) DEFAULT NULL,
  `m_be_17_3_amount` int(11) DEFAULT NULL,
  `m_be_16_4_count` int(11) DEFAULT NULL,
  `m_be_16_4_amount` int(11) DEFAULT NULL,
  `m_be_15_5_count` int(11) DEFAULT NULL,
  `m_be_15_5_amount` int(11) DEFAULT NULL,
  `m_be_14_6_count` int(11) DEFAULT NULL,
  `m_be_14_6_amount` int(11) DEFAULT NULL,
  `m_be_13_7_count` int(11) DEFAULT NULL,
  `m_be_13_7_amount` int(11) DEFAULT NULL,
  `m_a4r_20_0_count` int(11) DEFAULT NULL,
  `m_a4r_20_0_amount` int(11) DEFAULT NULL,
  `m_a4r_19_1_count` int(11) DEFAULT NULL,
  `m_a4r_19_1_amount` int(11) DEFAULT NULL,
  `m_a4r_18_2_count` int(11) DEFAULT NULL,
  `m_a4r_18_2_amount` int(11) DEFAULT NULL,
  `m_a4r_17_3_count` int(11) DEFAULT NULL,
  `m_a4r_17_3_amount` int(11) DEFAULT NULL,
  `m_a4r_16_4_count` int(11) DEFAULT NULL,
  `m_a4r_16_4_amount` int(11) DEFAULT NULL,
  `m_a4r_15_5_count` int(11) DEFAULT NULL,
  `m_a4r_15_5_amount` int(11) DEFAULT NULL,
  `m_a4r_14_6_count` int(11) DEFAULT NULL,
  `m_a4r_14_6_amount` int(11) DEFAULT NULL,
  `m_a4r_13_7_count` int(11) DEFAULT NULL,
  `m_a4r_13_7_amount` int(11) DEFAULT NULL,
  `m_a5c_20_0_count` int(11) DEFAULT NULL,
  `m_a5c_20_0_amount` int(11) DEFAULT NULL,
  `m_a5c_19_1_count` int(11) DEFAULT NULL,
  `m_a5c_19_1_amount` int(11) DEFAULT NULL,
  `m_a5c_18_2_count` int(11) DEFAULT NULL,
  `m_a5c_18_2_amount` int(11) DEFAULT NULL,
  `m_a5c_17_3_count` int(11) DEFAULT NULL,
  `m_a5c_17_3_amount` int(11) DEFAULT NULL,
  `m_a5c_16_4_count` int(11) DEFAULT NULL,
  `m_a5c_16_4_amount` int(11) DEFAULT NULL,
  `m_a5c_15_5_count` int(11) DEFAULT NULL,
  `m_a5c_15_5_amount` int(11) DEFAULT NULL,
  `m_a5c_14_6_count` int(11) DEFAULT NULL,
  `m_a5c_14_6_amount` int(11) DEFAULT NULL,
  `m_a5c_13_7_count` int(11) DEFAULT NULL,
  `m_a5c_13_7_amount` int(11) DEFAULT NULL,
  `m_a3ra2c_20_0_count` int(11) DEFAULT NULL,
  `m_a3ra2c_20_0_amount` int(11) DEFAULT NULL,
  `m_a3ra2c_19_1_count` int(11) DEFAULT NULL,
  `m_a3ra2c_19_1_amount` int(11) DEFAULT NULL,
  `m_a3ra2c_18_2_count` int(11) DEFAULT NULL,
  `m_a3ra2c_18_2_amount` int(11) DEFAULT NULL,
  `m_a3ra2c_17_3_count` int(11) DEFAULT NULL,
  `m_a3ra2c_17_3_amount` int(11) DEFAULT NULL,
  `m_a3ra2c_16_4_count` int(11) DEFAULT NULL,
  `m_a3ra2c_16_4_amount` int(11) DEFAULT NULL,
  `m_a3ra2c_15_5_count` int(11) DEFAULT NULL,
  `m_a3ra2c_15_5_amount` int(11) DEFAULT NULL,
  `m_a3ra2c_14_6_count` int(11) DEFAULT NULL,
  `m_a3ra2c_14_6_amount` int(11) DEFAULT NULL,
  `m_a3ra2c_13_7_count` int(11) DEFAULT NULL,
  `m_a3ra2c_13_7_amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`bclckenowinningid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_49`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_49` (
  `icomb_49_id` int(11) NOT NULL AUTO_INCREMENT,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_49_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_649`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_649` (
  `icomb_649_id` int(11) NOT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_649_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_early_bird`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_early_bird` (
  `icomb_early_bird_id` int(11) NOT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_early_bird_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_keno`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_keno` (
  `icomb_keno_id` int(11) NOT NULL AUTO_INCREMENT,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  `snum8` int(11) DEFAULT NULL,
  `snum9` int(11) DEFAULT NULL,
  `snum10` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_keno_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_lottario`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_lottario` (
  `icomb_lottario_id` int(11) NOT NULL AUTO_INCREMENT,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_lottario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_max`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_max` (
  `icomb_max_id` int(11) NOT NULL AUTO_INCREMENT,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_max_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_pick3`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_pick3` (
  `icomb_pick3_id` int(11) NOT NULL AUTO_INCREMENT,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_pick3_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_pick4`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_pick4` (
  `icomb_pick4_id` int(11) NOT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_pick4_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_play_hist`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_play_hist` (
  `icomb_play_hist_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `iUserNo` int(11) DEFAULT NULL,
  `icomb_select_id` bigint(20) DEFAULT NULL,
  `gameId` int(11) DEFAULT NULL,
  `numPlayed` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_play_hist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_play_hist_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_play_hist_detail` (
  `icomb_play_hist_id` bigint(20) NOT NULL,
  `playdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `match_num` int(11) DEFAULT NULL,
  `match_code` int(11) DEFAULT NULL,
  `iprize_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`icomb_play_hist_id`,`playdate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_poker`
--

CREATE TABLE IF NOT EXISTS `tbl_comb_poker` (
  `icomb_poker_id` int(11) NOT NULL AUTO_INCREMENT,
  `scard1` varchar(3) DEFAULT NULL,
  `scard2` varchar(3) DEFAULT NULL,
  `scard3` varchar(3) DEFAULT NULL,
  `scard4` varchar(3) DEFAULT NULL,
  `scard5` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`icomb_poker_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fetch_data_stats`
--

CREATE TABLE IF NOT EXISTS `tbl_fetch_data_stats` (
  `fetch_stats_id` int(11) NOT NULL AUTO_INCREMENT,
  `game` varchar(45) DEFAULT NULL,
  `gameid` int(11) DEFAULT NULL,
  `DrawDate` datetime DEFAULT NULL,
  `s_web_domain` int(11) DEFAULT NULL,
  `s_web_path` int(11) DEFAULT NULL,
  `s_web_file` int(11) DEFAULT NULL,
  `s_web_query` int(11) DEFAULT NULL,
  `fetch_date` datetime DEFAULT NULL,
  `fetch_count` int(11) DEFAULT NULL,
  `prev_fetch_date` datetime DEFAULT NULL,
  PRIMARY KEY (`fetch_stats_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3036 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fetch_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_fetch_detail` (
  `fetch_stat_id` int(45) DEFAULT NULL,
  `fetch_date` datetime DEFAULT NULL,
  `fetch_pos` int(11) DEFAULT NULL,
  `is_success` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lottery_games`
--

CREATE TABLE IF NOT EXISTS `tbl_lottery_games` (
  `gameid` int(11) NOT NULL AUTO_INCREMENT,
  `gamecode` varchar(45) DEFAULT NULL,
  `gamedesc` varchar(45) DEFAULT NULL,
  `drawStartDate` datetime DEFAULT NULL,
  `validateDrawDate` datetime DEFAULT NULL,
  `drawEndDate` datetime DEFAULT NULL,
  `nextDrawDate` datetime NOT NULL,
  `currentDrawDate` datetime NOT NULL,
  `drawSchedule` varchar(45) DEFAULT NULL,
  `db_table_name` varchar(100) DEFAULT NULL,
  `iMon` tinyint(4) DEFAULT '0',
  `iTue` tinyint(4) DEFAULT '0',
  `iWed` tinyint(4) DEFAULT '0',
  `iThu` tinyint(4) DEFAULT '0',
  `iFri` tinyint(4) DEFAULT '0',
  `iSat` tinyint(4) DEFAULT '0',
  `iSun` tinyint(4) DEFAULT '0',
  `iWeekly` tinyint(4) DEFAULT '0',
  `iBiWeekly` tinyint(4) DEFAULT '0',
  `iMonthly` tinyint(4) DEFAULT '0',
  `region` varchar(10) DEFAULT NULL,
  `iDaily` int(11) NOT NULL DEFAULT '0',
  `iWedSat` int(11) NOT NULL DEFAULT '0',
  `gameType` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lotto_summary`
--

CREATE TABLE IF NOT EXISTS `tbl_lotto_summary` (
  `summary_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `envelope_no` int(11) NOT NULL,
  `total_lines` int(11) NOT NULL,
  `lines_won_cnt` int(11) NOT NULL,
  `lines_win_amt` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lot_win_locations`
--

CREATE TABLE IF NOT EXISTS `tbl_lot_win_locations` (
  `lot_loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_city` varchar(50) DEFAULT NULL,
  `loc_prov` varchar(25) DEFAULT NULL,
  `loc_country` varchar(45) DEFAULT NULL,
  `loc_any` varchar(100) DEFAULT NULL,
  `loc_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`lot_loc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_649`
--

CREATE TABLE IF NOT EXISTS `tbl_na_649` (
  `na649id` int(11) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` int(11) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  `region_only` varchar(4) DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  `is_num_correct` int(11) DEFAULT NULL,
  PRIMARY KEY (`na649id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=176 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_649_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_na_649_winnings` (
  `na649winningid` int(11) NOT NULL AUTO_INCREMENT,
  `na649id` int(11) DEFAULT NULL,
  `m_6_count` int(11) DEFAULT NULL,
  `m_6_amount` double DEFAULT NULL,
  `m_6_region` varchar(45) DEFAULT NULL,
  `m_5_b_count` int(11) DEFAULT NULL,
  `m_5_b_amount` double DEFAULT NULL,
  `m_5_b_region` varchar(45) DEFAULT NULL,
  `m_5_count` int(11) DEFAULT NULL,
  `m_5_amount` double DEFAULT NULL,
  `m_4_count` int(11) DEFAULT NULL,
  `m_4_amount` double DEFAULT NULL,
  `m_3_count` int(11) DEFAULT NULL,
  `m_3_amount` double DEFAULT NULL,
  `m_2_b_count` int(11) DEFAULT NULL,
  `m_2_b_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`na649winningid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=220 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_649_wins_loc`
--

CREATE TABLE IF NOT EXISTS `tbl_na_649_wins_loc` (
  `na649wins_locid` int(11) NOT NULL AUTO_INCREMENT,
  `na649winningid` int(11) DEFAULT NULL,
  `wcount` int(11) DEFAULT NULL,
  `wamount` int(11) NOT NULL,
  `wlocid` int(11) DEFAULT NULL,
  `wnum_m` int(11) DEFAULT NULL,
  PRIMARY KEY (`na649wins_locid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=517 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_lottomax`
--

CREATE TABLE IF NOT EXISTS `tbl_na_lottomax` (
  `namaxid` int(11) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` int(11) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `isequencenum` int(11) DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  `region_only` varchar(4) DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  PRIMARY KEY (`namaxid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=965 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_lottomax_winning`
--

CREATE TABLE IF NOT EXISTS `tbl_na_lottomax_winning` (
  `namaxwinningid` int(11) NOT NULL AUTO_INCREMENT,
  `namaxid` int(11) DEFAULT NULL,
  `m_7_count` int(11) DEFAULT NULL,
  `m_7_amount` double DEFAULT NULL,
  `m_7_region` varchar(45) DEFAULT NULL,
  `m_6_b_count` int(11) DEFAULT NULL,
  `m_6_b_amount` double DEFAULT NULL,
  `m_6_b_region` varchar(45) DEFAULT NULL,
  `m_6_count` int(11) DEFAULT NULL,
  `m_6_amount` double DEFAULT NULL,
  `m_5_count` int(11) DEFAULT NULL,
  `m_5_amount` double DEFAULT NULL,
  `m_4_count` int(11) DEFAULT NULL,
  `m_4_amount` double DEFAULT NULL,
  `m_3_b_count` int(11) DEFAULT NULL,
  `m_3_b_amount` double DEFAULT NULL,
  `m_3_count` int(11) DEFAULT NULL,
  `m_3_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`namaxwinningid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=964 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_lottomax_wins_loc`
--

CREATE TABLE IF NOT EXISTS `tbl_na_lottomax_wins_loc` (
  `namaxwins_locid` int(11) NOT NULL AUTO_INCREMENT,
  `namaxwinningid` int(11) DEFAULT NULL,
  `wamount` int(11) DEFAULT NULL,
  `wcount` int(11) DEFAULT NULL,
  `wlocid` int(11) DEFAULT NULL,
  `wnum_m` int(11) DEFAULT NULL,
  PRIMARY KEY (`namaxwins_locid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=751 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_super7`
--

CREATE TABLE IF NOT EXISTS `tbl_na_super7` (
  `nasuper7id` int(11) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` int(11) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  `region_only` varchar(4) DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  PRIMARY KEY (`nasuper7id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_super7_winning`
--

CREATE TABLE IF NOT EXISTS `tbl_na_super7_winning` (
  `nasuper7winningid` int(11) NOT NULL AUTO_INCREMENT,
  `nasuper7id` int(11) DEFAULT NULL,
  `m_7_count` int(11) DEFAULT NULL,
  `m_7_amount` double DEFAULT NULL,
  `m_7_region` varchar(45) DEFAULT NULL,
  `m_6_b_count` int(11) DEFAULT NULL,
  `m_6_b_amount` double DEFAULT NULL,
  `m_6_b_region` varchar(45) DEFAULT NULL,
  `m_6_count` int(11) DEFAULT NULL,
  `m_6_amount` double DEFAULT NULL,
  `m_5_count` int(11) DEFAULT NULL,
  `m_5_amount` double DEFAULT NULL,
  `m_4_count` int(11) DEFAULT NULL,
  `m_4_amount` double DEFAULT NULL,
  `m_3_b_count` int(11) DEFAULT NULL,
  `m_3_b_amount` double DEFAULT NULL,
  `m_3_count` int(11) DEFAULT NULL,
  `m_3_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`nasuper7winningid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_49`
--

CREATE TABLE IF NOT EXISTS `tbl_on_49` (
  `on49id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  PRIMARY KEY (`on49id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=187 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_49_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_on_49_winnings` (
  `on49winningid` int(11) NOT NULL AUTO_INCREMENT,
  `on49id` int(11) DEFAULT NULL,
  `m_6_count` int(11) DEFAULT NULL,
  `m_6_amount` double DEFAULT NULL,
  `m_6_region` varchar(45) DEFAULT NULL,
  `m_5_b_count` int(11) DEFAULT NULL,
  `m_5_b_amount` double DEFAULT NULL,
  `m_5_b_region` varchar(45) DEFAULT NULL,
  `m_5_count` int(11) DEFAULT NULL,
  `m_5_amount` double DEFAULT NULL,
  `m_4_count` int(11) DEFAULT NULL,
  `m_4_amount` double DEFAULT NULL,
  `m_3_count` int(11) DEFAULT NULL,
  `m_3_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`on49winningid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=186 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_early_bird`
--

CREATE TABLE IF NOT EXISTS `tbl_on_early_bird` (
  `onearlybirdid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `onlottarioid` int(11) DEFAULT NULL,
  PRIMARY KEY (`onearlybirdid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_encore`
--

CREATE TABLE IF NOT EXISTS `tbl_on_encore` (
  `onencoreid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  PRIMARY KEY (`onencoreid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=762 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_encore_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_on_encore_winnings` (
  `onencorewinningid` int(11) NOT NULL AUTO_INCREMENT,
  `onencoreid` int(11) DEFAULT NULL,
  `m_7_rl_count` int(11) DEFAULT NULL,
  `m_7_rl_amount` double DEFAULT NULL,
  `m_6_rl_count` int(11) DEFAULT NULL,
  `m_6_rl_amount` double DEFAULT NULL,
  `m_5_rl_count` int(11) DEFAULT NULL,
  `m_5_rl_amount` double DEFAULT NULL,
  `m_4_rl_count` int(11) DEFAULT NULL,
  `m_4_rl_amount` double DEFAULT NULL,
  `m_3_rl_count` int(11) DEFAULT NULL,
  `m_3_rl_amount` double DEFAULT NULL,
  `m_2_rl_count` int(11) DEFAULT NULL,
  `m_2_rl_amount` double DEFAULT NULL,
  `m_1_rl_count` int(11) DEFAULT NULL,
  `m_1_rl_amount` double DEFAULT NULL,
  `m_6_lr_count` int(11) DEFAULT NULL,
  `m_6_lr_amount` double DEFAULT NULL,
  `m_5_lr_count` int(11) DEFAULT NULL,
  `m_5_lr_amount` double DEFAULT NULL,
  `m_4_lr_count` int(11) DEFAULT NULL,
  `m_4_lr_amount` double DEFAULT NULL,
  `m_3_lr_count` int(11) DEFAULT NULL,
  `m_3_lr_amount` double DEFAULT NULL,
  `m_2_lr_count` int(11) DEFAULT NULL,
  `m_2_lr_amount` double DEFAULT NULL,
  `m_f5_l1_count` int(11) DEFAULT NULL,
  `m_f5_l1_amount` double DEFAULT NULL,
  `m_f4_l2_count` int(11) DEFAULT NULL,
  `m_f4_l2_amount` double DEFAULT NULL,
  `m_f4_l1_count` int(11) DEFAULT NULL,
  `m_f4_l1_amount` double DEFAULT NULL,
  `m_f3_l3_count` int(11) DEFAULT NULL,
  `m_f3_l3_amount` double DEFAULT NULL,
  `m_f3_l2_count` int(11) DEFAULT NULL,
  `m_f3_l2_amount` double DEFAULT NULL,
  `m_f3_l1_count` int(11) DEFAULT NULL,
  `m_f3_l1_amount` double DEFAULT NULL,
  `m_f2_l4_count` int(11) DEFAULT NULL,
  `m_f2_l4_amount` double DEFAULT NULL,
  `m_f2_l3_count` int(11) DEFAULT NULL,
  `m_f2_l3_amount` double DEFAULT NULL,
  `m_f2_l2_count` int(11) DEFAULT NULL,
  `m_f2_l2_amount` double DEFAULT NULL,
  `m_f2_l1_count` int(11) DEFAULT NULL,
  `m_f2_l1_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`onencorewinningid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=598 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_keno`
--

CREATE TABLE IF NOT EXISTS `tbl_on_keno` (
  `onkenoid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  `snum8` int(11) DEFAULT NULL,
  `snum9` int(11) DEFAULT NULL,
  `snum10` int(11) DEFAULT NULL,
  `snum11` int(11) DEFAULT NULL,
  `snum12` int(11) DEFAULT NULL,
  `snum13` int(11) DEFAULT NULL,
  `snum14` int(11) DEFAULT NULL,
  `snum15` int(11) DEFAULT NULL,
  `snum16` int(11) DEFAULT NULL,
  `snum17` int(11) DEFAULT NULL,
  `snum18` int(11) DEFAULT NULL,
  `snum19` int(11) DEFAULT NULL,
  `snum20` int(11) DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  PRIMARY KEY (`onkenoid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=660 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_keno_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_on_keno_winnings` (
  `onkenowinningid` int(11) NOT NULL AUTO_INCREMENT,
  `onkenoid` int(11) DEFAULT NULL,
  `m_10_10_1_count` int(11) DEFAULT NULL,
  `m_10_10_1_amount` int(11) DEFAULT NULL,
  `m_10_9_1_count` int(11) DEFAULT NULL,
  `m_10_9_1_amount` int(11) DEFAULT NULL,
  `m_10_8_1_count` int(11) DEFAULT NULL,
  `m_10_8_1_amount` int(11) DEFAULT NULL,
  `m_10_7_1_count` int(11) DEFAULT NULL,
  `m_10_7_1_amount` int(11) DEFAULT NULL,
  `m_10_0_1_count` int(11) DEFAULT NULL,
  `m_10_0_1_amount` int(11) DEFAULT NULL,
  `m_9_9_1_count` int(11) DEFAULT NULL,
  `m_9_9_1_amount` int(11) DEFAULT NULL,
  `m_9_8_1_count` int(11) DEFAULT NULL,
  `m_9_8_1_amount` int(11) DEFAULT NULL,
  `m_9_7_1_count` int(11) DEFAULT NULL,
  `m_9_7_1_amount` int(11) DEFAULT NULL,
  `m_9_6_1_count` int(11) DEFAULT NULL,
  `m_9_6_1_amount` int(11) DEFAULT NULL,
  `m_8_8_1_count` int(11) DEFAULT NULL,
  `m_8_8_1_amount` int(11) DEFAULT NULL,
  `m_8_7_1_count` int(11) DEFAULT NULL,
  `m_8_7_1_amount` int(11) DEFAULT NULL,
  `m_8_6_1_count` int(11) DEFAULT NULL,
  `m_8_6_1_amount` int(11) DEFAULT NULL,
  `m_7_7_1_count` int(11) DEFAULT NULL,
  `m_7_7_1_amount` int(11) DEFAULT NULL,
  `m_7_6_1_count` int(11) DEFAULT NULL,
  `m_7_6_1_amount` int(11) DEFAULT NULL,
  `m_7_5_1_count` int(11) DEFAULT NULL,
  `m_7_5_1_amount` int(11) DEFAULT NULL,
  `m_6_6_1_count` int(11) DEFAULT NULL,
  `m_6_6_1_amount` int(11) DEFAULT NULL,
  `m_6_5_1_count` int(11) DEFAULT NULL,
  `m_6_5_1_amount` int(11) DEFAULT NULL,
  `m_5_5_1_count` int(11) DEFAULT NULL,
  `m_5_5_1_amount` int(11) DEFAULT NULL,
  `m_5_4_1_count` int(11) DEFAULT NULL,
  `m_5_4_1_amount` int(11) DEFAULT NULL,
  `m_4_4_1_count` int(11) DEFAULT NULL,
  `m_4_4_1_amount` int(11) DEFAULT NULL,
  `m_3_3_1_count` int(11) DEFAULT NULL,
  `m_3_3_1_amount` int(11) DEFAULT NULL,
  `m_2_2_1_count` int(11) DEFAULT NULL,
  `m_2_2_1_amount` int(11) DEFAULT NULL,
  `m_10_10_2_count` int(11) DEFAULT NULL,
  `m_10_9_2_count` int(11) DEFAULT NULL,
  `m_10_8_2_count` int(11) DEFAULT NULL,
  `m_10_7_2_count` int(11) DEFAULT NULL,
  `m_10_0_2_count` int(11) DEFAULT NULL,
  `m_9_9_2_count` int(11) DEFAULT NULL,
  `m_9_8_2_count` int(11) DEFAULT NULL,
  `m_9_7_2_count` int(11) DEFAULT NULL,
  `m_9_6_2_count` int(11) DEFAULT NULL,
  `m_8_8_2_count` int(11) DEFAULT NULL,
  `m_8_7_2_count` int(11) DEFAULT NULL,
  `m_8_6_2_count` int(11) DEFAULT NULL,
  `m_7_7_2_count` int(11) DEFAULT NULL,
  `m_7_6_2_count` int(11) DEFAULT NULL,
  `m_7_5_2_count` int(11) DEFAULT NULL,
  `m_6_6_2_count` int(11) DEFAULT NULL,
  `m_6_5_2_count` int(11) DEFAULT NULL,
  `m_5_5_2_count` int(11) DEFAULT NULL,
  `m_5_4_2_count` int(11) DEFAULT NULL,
  `m_4_4_2_count` int(11) DEFAULT NULL,
  `m_3_3_2_count` int(11) DEFAULT NULL,
  `m_2_2_2_count` int(11) DEFAULT NULL,
  `m_10_10_5_count` int(11) DEFAULT NULL,
  `m_10_9_5_count` int(11) DEFAULT NULL,
  `m_10_8_5_count` int(11) DEFAULT NULL,
  `m_10_7_5_count` int(11) DEFAULT NULL,
  `m_10_0_5_count` int(11) DEFAULT NULL,
  `m_9_9_5_count` int(11) DEFAULT NULL,
  `m_9_8_5_count` int(11) DEFAULT NULL,
  `m_9_7_5_count` int(11) DEFAULT NULL,
  `m_9_6_5_count` int(11) DEFAULT NULL,
  `m_8_8_5_count` int(11) DEFAULT NULL,
  `m_8_7_5_count` int(11) DEFAULT NULL,
  `m_8_6_5_count` int(11) DEFAULT NULL,
  `m_7_7_5_count` int(11) DEFAULT NULL,
  `m_7_6_5_count` int(11) DEFAULT NULL,
  `m_7_5_5_count` int(11) DEFAULT NULL,
  `m_6_6_5_count` int(11) DEFAULT NULL,
  `m_6_5_5_count` int(11) DEFAULT NULL,
  `m_5_5_5_count` int(11) DEFAULT NULL,
  `m_5_4_5_count` int(11) DEFAULT NULL,
  `m_4_4_5_count` int(11) DEFAULT NULL,
  `m_3_3_5_count` int(11) DEFAULT NULL,
  `m_2_2_5_count` int(11) DEFAULT NULL,
  `m_10_10_10_count` int(11) DEFAULT NULL,
  `m_10_9_10_count` int(11) DEFAULT NULL,
  `m_10_8_10_count` int(11) DEFAULT NULL,
  `m_10_7_10_count` int(11) DEFAULT NULL,
  `m_10_0_10_count` int(11) DEFAULT NULL,
  `m_9_9_10_count` int(11) DEFAULT NULL,
  `m_9_8_10_count` int(11) DEFAULT NULL,
  `m_9_7_10_count` int(11) DEFAULT NULL,
  `m_9_6_10_count` int(11) DEFAULT NULL,
  `m_8_8_10_count` int(11) DEFAULT NULL,
  `m_8_7_10_count` int(11) DEFAULT NULL,
  `m_8_6_10_count` int(11) DEFAULT NULL,
  `m_7_7_10_count` int(11) DEFAULT NULL,
  `m_7_6_10_count` int(11) DEFAULT NULL,
  `m_7_5_10_count` int(11) DEFAULT NULL,
  `m_6_6_10_count` int(11) DEFAULT NULL,
  `m_6_5_10_count` int(11) DEFAULT NULL,
  `m_5_5_10_count` int(11) DEFAULT NULL,
  `m_5_4_10_count` int(11) DEFAULT NULL,
  `m_4_4_10_count` int(11) DEFAULT NULL,
  `m_3_3_10_count` int(11) DEFAULT NULL,
  `m_2_2_10_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`onkenowinningid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=553 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_lottario`
--

CREATE TABLE IF NOT EXISTS `tbl_on_lottario` (
  `onlottarioid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  PRIMARY KEY (`onlottarioid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_lottario_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_on_lottario_winnings` (
  `onlottariowinningid` int(11) NOT NULL AUTO_INCREMENT,
  `onlottarioid` int(11) DEFAULT NULL,
  `m_6_count` int(11) DEFAULT NULL,
  `m_6_amount` double DEFAULT NULL,
  `m_6_region` varchar(45) DEFAULT NULL,
  `m_5_b_count` int(11) DEFAULT NULL,
  `m_5_b_amount` double DEFAULT NULL,
  `m_5_b_region` varchar(45) DEFAULT NULL,
  `m_5_count` int(11) DEFAULT NULL,
  `m_5_amount` double DEFAULT NULL,
  `m_4_count` int(11) DEFAULT NULL,
  `m_4_amount` double DEFAULT NULL,
  `m_3_count` int(11) DEFAULT NULL,
  `m_3_amount` double DEFAULT NULL,
  `m_e_bird_id` int(11) DEFAULT NULL,
  `m_e_bird_count` int(11) DEFAULT NULL,
  `m_e_bird_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`onlottariowinningid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_major_winners`
--

CREATE TABLE IF NOT EXISTS `tbl_on_major_winners` (
  `major_winning_id` int(11) NOT NULL AUTO_INCREMENT,
  `winning_date` datetime DEFAULT NULL,
  `winning_title` mediumtext,
  `winning_content` longtext,
  `winning_game_id` int(11) DEFAULT NULL,
  `draw_date` datetime DEFAULT NULL,
  `winning_number` varchar(255) DEFAULT NULL,
  `winning_url` varchar(255) DEFAULT NULL,
  `winning_draw_id` int(11) DEFAULT NULL,
  `winning_type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`major_winning_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_payday`
--

CREATE TABLE IF NOT EXISTS `tbl_on_payday` (
  `onpaydayid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  PRIMARY KEY (`onpaydayid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_pick3`
--

CREATE TABLE IF NOT EXISTS `tbl_on_pick3` (
  `onpick3id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  PRIMARY KEY (`onpick3id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=686 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_pick3_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_on_pick3_winnings` (
  `onpick3winningid` int(11) NOT NULL AUTO_INCREMENT,
  `onpick3id` int(11) DEFAULT NULL,
  `m_3_s_count` int(11) DEFAULT NULL,
  `m_3_s_amount` double DEFAULT NULL,
  `m_3_b_count` int(11) DEFAULT NULL,
  `m_3_b_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`onpick3winningid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=991 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_pick4`
--

CREATE TABLE IF NOT EXISTS `tbl_on_pick4` (
  `onpick4id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  PRIMARY KEY (`onpick4id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=715 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_pick4_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_on_pick4_winnings` (
  `onpick4winningid` int(11) NOT NULL AUTO_INCREMENT,
  `onpick4id` int(11) DEFAULT NULL,
  `m_4_s_count` int(11) DEFAULT NULL,
  `m_4_s_amount` double DEFAULT NULL,
  `m_4_b_count` int(11) DEFAULT NULL,
  `m_4_b_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  `m_4_4w_box_count` int(11) DEFAULT NULL,
  `m_4_4w_box_amount` double DEFAULT NULL,
  `m_4_6w_box_count` int(11) DEFAULT NULL,
  `m_4_6w_box_amount` double DEFAULT NULL,
  `m_4_12w_box_count` int(11) DEFAULT NULL,
  `m_4_12w_box_amount` double DEFAULT NULL,
  `m_4_24w_box_count` int(11) DEFAULT NULL,
  `m_4_24w_box_amount` double DEFAULT NULL,
  PRIMARY KEY (`onpick4winningid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=551 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_poker`
--

CREATE TABLE IF NOT EXISTS `tbl_on_poker` (
  `onpokerid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `scard1` varchar(4) DEFAULT NULL,
  `scard2` varchar(4) DEFAULT NULL,
  `scard3` varchar(4) DEFAULT NULL,
  `scard4` varchar(4) DEFAULT NULL,
  `scard5` varchar(4) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `drawNo` int(11) DEFAULT NULL,
  `sdrawDate` bigint(20) DEFAULT NULL,
  `spielID` int(11) DEFAULT NULL,
  PRIMARY KEY (`onpokerid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=466 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_poker_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_on_poker_winnings` (
  `onpokerwinningid` int(11) NOT NULL AUTO_INCREMENT,
  `onpokerid` int(11) DEFAULT NULL,
  `m_5_d_count` int(11) DEFAULT NULL,
  `m_5_d_amount` double DEFAULT NULL,
  `m_4_d_count` int(11) DEFAULT NULL,
  `m_4_d_amount` double DEFAULT NULL,
  `m_3_d_count` int(11) DEFAULT NULL,
  `m_3_d_amount` double DEFAULT NULL,
  `m_2_d_count` int(11) DEFAULT NULL,
  `m_2_d_amount` double DEFAULT NULL,
  `m_rf_i_count` int(11) DEFAULT NULL,
  `m_rf_i_amount` double DEFAULT NULL,
  `m_sf_i_count` int(11) DEFAULT NULL,
  `m_sf_i_amount` double DEFAULT NULL,
  `m_4k_i_count` int(11) DEFAULT NULL,
  `m_4k_i_amount` double DEFAULT NULL,
  `m_fh_i_count` int(11) DEFAULT NULL,
  `m_fh_i_amount` double DEFAULT NULL,
  `m_f_i_count` int(11) DEFAULT NULL,
  `m_f_i_amount` double DEFAULT NULL,
  `m_s_i_count` int(11) DEFAULT NULL,
  `m_s_i_amount` double DEFAULT NULL,
  `m_3k_i_count` int(11) DEFAULT NULL,
  `m_3k_i_amount` double DEFAULT NULL,
  `m_2p_i_count` int(11) DEFAULT NULL,
  `m_2p_i_amount` double DEFAULT NULL,
  `m_pj_i_count` int(11) DEFAULT NULL,
  `m_pj_i_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`onpokerwinningid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=466 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_store_locs`
--

CREATE TABLE IF NOT EXISTS `tbl_on_store_locs` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  `store_name` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `prov` varchar(2) NOT NULL,
  `postal_code` varchar(8) NOT NULL,
  `locnum` text NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_winners_1000_more`
--

CREATE TABLE IF NOT EXISTS `tbl_on_winners_1000_more` (
  `winning_id` int(11) NOT NULL AUTO_INCREMENT,
  `str_first_name` varchar(255) DEFAULT NULL,
  `str_last_name` varchar(255) DEFAULT NULL,
  `win_city_id` int(11) DEFAULT NULL,
  `win_prov_id` int(11) DEFAULT NULL,
  `lotto_game_id` int(11) DEFAULT NULL,
  `win_draw_date` datetime DEFAULT NULL,
  `is_multiple_draw` int(11) DEFAULT NULL,
  `win_prize_amt` bigint(20) DEFAULT NULL,
  `is_insider` int(11) DEFAULT NULL,
  `is_group` int(11) DEFAULT NULL,
  `win_group_id` int(11) DEFAULT NULL,
  `str_address` varchar(255) DEFAULT NULL,
  `win_list_date` datetime DEFAULT NULL,
  `win_list_pos` int(11) DEFAULT NULL,
  `strInstantWin` varchar(45) NOT NULL,
  `iGameNo` int(11) NOT NULL,
  `strGameNo` varchar(20) NOT NULL,
  PRIMARY KEY (`winning_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_winning_group`
--

CREATE TABLE IF NOT EXISTS `tbl_on_winning_group` (
  `winning_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `drawdate` datetime DEFAULT NULL,
  `listdate` datetime DEFAULT NULL,
  `win_prize` bigint(20) DEFAULT NULL,
  `member_cnt` int(11) DEFAULT NULL,
  `win_list_pos` int(11) DEFAULT NULL,
  `win_list_group_pos` int(11) NOT NULL,
  PRIMARY KEY (`winning_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_winning_locations`
--

CREATE TABLE IF NOT EXISTS `tbl_on_winning_locations` (
  `winninglocid` int(11) NOT NULL AUTO_INCREMENT,
  `iRowId` int(11) NOT NULL,
  `str_store_name` varchar(255) DEFAULT NULL,
  `str_store_addr` varchar(255) DEFAULT NULL,
  `iLottoGameId` int(45) DEFAULT NULL,
  `str_draw_date` datetime DEFAULT NULL,
  `winning_amount` bigint(20) DEFAULT NULL,
  `str_postal_code` varchar(7) DEFAULT NULL,
  `iCity` int(11) DEFAULT NULL,
  `iInstGameNo` int(11) NOT NULL,
  `strGameNo` varchar(20) NOT NULL,
  `iProv` int(11) NOT NULL,
  PRIMARY KEY (`winninglocid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1139 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_49`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_49` (
  `qlc49id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlc49id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_49_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_49_winnings` (
  `qlc49winningid` int(11) NOT NULL AUTO_INCREMENT,
  `qlc49id` int(11) DEFAULT NULL,
  `m_6_count` int(11) DEFAULT NULL,
  `m_6_amount` double DEFAULT NULL,
  `m_6_region` varchar(45) DEFAULT NULL,
  `m_5_b_count` int(11) DEFAULT NULL,
  `m_5_b_amount` double DEFAULT NULL,
  `m_5_b_region` varchar(45) DEFAULT NULL,
  `m_5_count` int(11) DEFAULT NULL,
  `m_5_amount` double DEFAULT NULL,
  `m_4_count` int(11) DEFAULT NULL,
  `m_4_amount` double DEFAULT NULL,
  `m_3_count` int(11) DEFAULT NULL,
  `m_3_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`qlc49winningid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_astro`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_astro` (
  `qlcastroid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlcastroid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_banco`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_banco` (
  `qlcbancoid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  `snum8` int(11) DEFAULT NULL,
  `snum9` int(11) DEFAULT NULL,
  `snum10` int(11) DEFAULT NULL,
  `snum11` int(11) DEFAULT NULL,
  `snum12` int(11) DEFAULT NULL,
  `snum13` int(11) DEFAULT NULL,
  `snum14` int(11) DEFAULT NULL,
  `snum15` int(11) DEFAULT NULL,
  `snum16` int(11) DEFAULT NULL,
  `snum17` int(11) DEFAULT NULL,
  `snum18` int(11) DEFAULT NULL,
  `snum19` int(11) DEFAULT NULL,
  `snum20` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlcbancoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_extra`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_extra` (
  `qlcextraid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlcextraid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_jour_de_paye`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_jour_de_paye` (
  `qlcjour_de_payeid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlcjour_de_payeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_la_mini`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_la_mini` (
  `qlcla_mini_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlcla_mini_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_la_quotidienne_3`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_la_quotidienne_3` (
  `qlc_la_quotidienne_3id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlc_la_quotidienne_3id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_la_quotidienne_4`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_la_quotidienne_4` (
  `qlc_la_quotidienne_4id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlc_la_quotidienne_4id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_tango`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_tango` (
  `qlctangoid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlctangoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qlc_triplex`
--

CREATE TABLE IF NOT EXISTS `tbl_qlc_triplex` (
  `qlctriplexid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlctriplexid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_select_match`
--

CREATE TABLE IF NOT EXISTS `tbl_select_match` (
  `match_code` int(11) NOT NULL AUTO_INCREMENT,
  `match_num` int(11) DEFAULT NULL,
  `total_num` int(11) DEFAULT NULL,
  `match_bonus` int(11) DEFAULT NULL,
  `gameid` int(11) DEFAULT NULL,
  `is_straight` int(11) DEFAULT NULL,
  `is_box` int(11) DEFAULT NULL,
  `m_box_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`match_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `iUserNo` int(11) NOT NULL AUTO_INCREMENT,
  `sUserName` varchar(255) DEFAULT NULL,
  `sFirstName` varchar(50) NOT NULL,
  `sLastName` varchar(50) NOT NULL,
  `sEmailAddr` varchar(255) DEFAULT NULL,
  `sPasswd` varchar(40) DEFAULT NULL,
  `sSalt` varchar(10) NOT NULL,
  `sNickName` varchar(255) DEFAULT NULL,
  `sLastLogin` datetime DEFAULT NULL,
  `sFirstLogin` datetime DEFAULT NULL,
  `AccessCount` int(11) DEFAULT NULL,
  PRIMARY KEY (`iUserNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `tbl_user_ticket` (
 `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
 `drawdate` date NOT NULL,
 `userid` int(11) NOT NULL,
 `envelope_no` int(11) NOT NULL,
 `gameid` int(11) not null,
 `store_id` int(11) NOT NULL,
 `uniq_no` int(11) NOT NULL,
 `amount_won` double NOT NULL,
 `free_ticket_cnt` int(11) NOT NULL,
 `ticket_cost` double NOT NULL,
  PRIMARY KEY (`ticket_id`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
--
-- Table structure for table `tbl_user_lotto_lines`
--

CREATE TABLE IF NOT EXISTS `tbl_user_lotto_line` (
  `lotto_line_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `comb_select_id` int(11) NOT NULL,
  `iSeqNo` int(11) NOT NULL,
  `gameid` int(11) NOT NULL,
  `amount_won` double NOT NULL,
  `match_cnt` int(11) NOT NULL,
  `match_str` varchar(10) NOT NULL,
  `free_ticket_cnt` int(11) NOT NULL,
  `line_cost` double NOT NULL,
 
  PRIMARY KEY (`lotto_line_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_session`
--

CREATE TABLE IF NOT EXISTS `tbl_user_session` (
  `session` varchar(40) NOT NULL,
  `cookie` varchar(40) DEFAULT NULL,
  `userNo` int(11) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `last_access` datetime NOT NULL,
  `ip_addr` varchar(128) NOT NULL,
  PRIMARY KEY (`session`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_variable`
--

CREATE TABLE IF NOT EXISTS `tbl_variable` (
  `name` varchar(128) NOT NULL DEFAULT '',
  `value` longtext NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wclc_49`
--

CREATE TABLE IF NOT EXISTS `tbl_wclc_49` (
  `wclc49id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`wclc49id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wclc_49_winnings`
--

CREATE TABLE IF NOT EXISTS `tbl_wclc_49_winnings` (
  `wclc49winningid` int(11) NOT NULL AUTO_INCREMENT,
  `wclc49id` int(11) DEFAULT NULL,
  `m_6_count` int(11) DEFAULT NULL,
  `m_6_amount` double DEFAULT NULL,
  `m_6_region` varchar(45) DEFAULT NULL,
  `m_5_b_count` int(11) DEFAULT NULL,
  `m_5_b_amount` double DEFAULT NULL,
  `m_5_b_region` varchar(45) DEFAULT NULL,
  `m_5_count` int(11) DEFAULT NULL,
  `m_5_amount` double DEFAULT NULL,
  `m_4_count` int(11) DEFAULT NULL,
  `m_4_amount` double DEFAULT NULL,
  `m_3_count` int(11) DEFAULT NULL,
  `m_3_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`wclc49winningid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wclc_extra`
--

CREATE TABLE IF NOT EXISTS `tbl_wclc_extra` (
  `wclcextraid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  PRIMARY KEY (`wclcextraid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wclc_keno`
--

CREATE TABLE IF NOT EXISTS `tbl_wclc_keno` (
  `wclckenoid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  `snum6` int(11) DEFAULT NULL,
  `snum7` int(11) DEFAULT NULL,
  `snum8` int(11) DEFAULT NULL,
  `snum9` int(11) DEFAULT NULL,
  `snum10` int(11) DEFAULT NULL,
  `snum11` int(11) DEFAULT NULL,
  `snum12` int(11) DEFAULT NULL,
  `snum13` int(11) DEFAULT NULL,
  `snum14` int(11) DEFAULT NULL,
  `snum15` int(11) DEFAULT NULL,
  `snum16` int(11) DEFAULT NULL,
  `snum17` int(11) DEFAULT NULL,
  `snum18` int(11) DEFAULT NULL,
  `snum19` int(11) DEFAULT NULL,
  `snum20` int(11) DEFAULT NULL,
  PRIMARY KEY (`wclckenoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wclc_payday`
--

CREATE TABLE IF NOT EXISTS `tbl_wclc_payday` (
  `wclcpaydayid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`wclcpaydayid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wclc_pick3`
--

CREATE TABLE IF NOT EXISTS `tbl_wclc_pick3` (
  `wclcpick3id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  PRIMARY KEY (`wclcpick3id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wclc_pick4`
--

CREATE TABLE IF NOT EXISTS `tbl_wclc_pick4` (
  `wclcpick4id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`wclcpick4id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_urls`
--

CREATE TABLE IF NOT EXISTS `tbl_web_urls` (
  `web_url_id` int(11) NOT NULL AUTO_INCREMENT,
  `web_url_content` varchar(255) DEFAULT NULL,
  `web_url_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`web_url_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3816 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_winning_prizes`
--

CREATE TABLE IF NOT EXISTS `tbl_winning_prizes` (
  `prze_id` int(11) NOT NULL AUTO_INCREMENT,
  `prze_amount` double DEFAULT NULL,
  `prze_type` int(11) DEFAULT NULL,
  `prze_desc` varchar(255) DEFAULT NULL,
  `gameId` int(11) DEFAULT NULL,
  `prze_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`prze_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6872 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
