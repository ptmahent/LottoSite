
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

--
-- Table structure for table `tbl_user_lotto_lines`
--

CREATE TABLE IF NOT EXISTS `tbl_user_lotto_lines` (
  `lotto_line_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `comb_select_id` int(11) NOT NULL,
  `iSeqNo` int(11) NOT NULL,
  `drawdate` date NOT NULL,
  `gameid` int(11) NOT NULL,
  `amount_won` double NOT NULL,
  `match_cnt` int(11) NOT NULL,
  `match_str` varchar(10) NOT NULL,
  `free_ticket_cnt` int(11) NOT NULL,
  `ticket_cost` double NOT NULL,
  `envelope_no` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
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
