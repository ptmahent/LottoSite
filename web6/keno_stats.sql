
--
-- Table structure for table `tbl_comb_49`
--

DROP TABLE IF EXISTS `tbl_comb_49`;
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

DROP TABLE IF EXISTS `tbl_comb_649`;
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

DROP TABLE IF EXISTS `tbl_comb_early_bird`;
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

DROP TABLE IF EXISTS `tbl_comb_keno`;
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




DROP TABLE IF EXISTS `tbl_stats_keno`;
CREATE TABLE IF NOT EXISTS `tbl_stats_keno` (

	`istats_id` int(11) Not null auto_increment,
	`icycle_type` int(11) default null,
	`pattern_id` int(11) default null,
	
	
	`count` int(11) default null,
	`first_occour` datetime default null,
	`last_occour` datetime default null,
	
	`1d_skip_occour` int(11) default null,
	`2d_skip_occour` int(11) default null,
	`3d_skip_occour` int(11) default null,
	`4d_skip_occour` int(11) default null,
	`5d_skip_occour` int(11) default null,
	`6d_skip_occour` int(11) default null,
	`7d_skip_occour` int(11) default null,
	`8d_skip_occour` int(11) default null,
	`9d_skip_occour` int(11) default null,
	`10d_skip_occour` int(11) default null,
	`11d_skip_occour` int(11) default null,	
	`12d_skip_occour` int(11) default null,	
	`13d_skip_occour` int(11) default null,	
	`14d_skip_occour` int(11) default null,	
	`15d_skip_occour` int(11) default null,	
	`16d_skip_occour` int(11) default null,	
	`17d_skip_occour` int(11) default null,	
	`18d_skip_occour` int(11) default null,	
	`19d_skip_occour` int(11) default null,
	`20d_skip_occour` int(11) default null,	
	`21d_skip_occour` int(11) default null,		
	`22d_skip_occour` int(11) default null,
	`23d_skip_occour` int(11) default null,
	`24d_skip_occour` int(11) default null,
	`25d_skip_occour` int(11) default null,
	`26d_skip_occour` int(11) default null,								
	`27d_skip_occour` int(11) default null,
	`28d_skip_occour` int(11) default null,
	`29d_skip_occour` int(11) default null,
	`30d_skip_occour` int(11) default null,							
	`35d_skip_occour` int(11) default null,
	`40d_skip_occour` int(11) default null,	
	`45d_skip_occour` int(11) default null,									
	`50d_skip_occour` int(11) default null,				
	`55d_skip_occour` int(11) default null,				
	`60d_skip_occour` int(11) default null,				
				
				

	`1d_repeat_occour` int(11) default null,
	`2d_repeat_occour` int(11) default null,
	`3d_repeat_occour` int(11) default null,
	`4d_repeat_occour` int(11) default null,
	`5d_repeat_occour` int(11) default null,
	`6d_repeat_occour` int(11) default null,
	`7d_repeat_occour` int(11) default null,
	`8d_repeat_occour` int(11) default null,
	`9d_repeat_occour` int(11) default null,
	`10d_repeat_occour` int(11) default null,
	`11d_repeat_occour` int(11) default null,	
	`12d_repeat_occour` int(11) default null,	
	`13d_repeat_occour` int(11) default null,	
	`14d_repeat_occour` int(11) default null,	
	`15d_repeat_occour` int(11) default null,	
	`16d_repeat_occour` int(11) default null,	
	`17d_repeat_occour` int(11) default null,	
	`18d_repeat_occour` int(11) default null,	
	`19d_repeat_occour` int(11) default null,
	`20d_repeat_occour` int(11) default null,	
	`21d_repeat_occour` int(11) default null,		
	`22d_repeat_occour` int(11) default null,
	`23d_repeat_occour` int(11) default null,
	`24d_repeat_occour` int(11) default null,
	`25d_repeat_occour` int(11) default null,
	`26d_repeat_occour` int(11) default null,								
	`27d_repeat_occour` int(11) default null,
	`28d_repeat_occour` int(11) default null,
	`29d_repeat_occour` int(11) default null,
	`30d_repeat_occour` int(11) default null,							
	`35d_repeat_occour` int(11) default null,
	`40d_repeat_occour` int(11) default null,	
	`45d_repeat_occour` int(11) default null,									
	`50d_repeat_occour` int(11) default null,				
	`55d_repeat_occour` int(11) default null,				
	`60d_repeat_occour` int(11) default null,				
				
	`2_adj_occour` int(11) default null,
	`2_adj_id` int(11) default null,
	
	
	`2_cons_occour` int(11) default null,
	`2_first_occour` datetime default null,
	`2_last_occour` datetime default null,
	
	`3_adj_occour` int(11) default null,
	`3_adj_id` int(11) default null,
	
	`3_cons_occour` int(11) default null,
	`3_first_occour` datetime default null,
	`3_last_occour` datetime default null,
	
	`4_adj_occour` int(11) default null,
	`4_adj_id` int(11) default null,
	
	`4_cons_occour` int(11) default null,
	`4_first_occour` datetime default null,
	`4_last_occour` datetime default null,
	
	`5_adj_occour` int(11) default null,
	`5_adj_id` int(11) default null,
	
	`5_cons_occour` int(11) default null,
	`5_first_occour` datetime default null,
	`5_last_occour` datetime default null,

	`6_adj_occour` int(11) default null,
	`6_adj_id` int(11) default null,
	
	`6_cons_occour` int(11) default null,
	`6_first_occour` datetime default null,
	`6_last_occour` datetime default null,
	
	`7_adj_occour` int(11) default null,
	`7_adj_id` int(11) default null,
	
	`7_cons_occour` int(11) default null,
	`7_first_occour` datetime default null,
	`7_last_occour` datetime default null,
	
	`8_adj_occour` int(11) default null,
	`8_adj_id` int(11) default null,
	
	`8_cons_occour` int(11) default null,
	`8_first_occour` datetime default null,
	`8_last_occour` datetime default null,
	
	`9_adj_occour` int(11) default null,
	`9_adj_id` int(11) default null,
	
	`9_cons_occour` int(11) default null,
	`9_first_occour` datetime default null,
	`9_last_occour` datetime default null,
	
	
	`10_adj_occour` int(11) default null,
	`10_adj_id` int(11) default null,
	
	`10_cons_occour` int(11) default null,
	`10_first_occour` datetime default null,
	`10_last_occour` datetime default null,
	
	
	`11_adj_occour` int(11) default null,
	`11_adj_id` int(11) default null,
	
	`11_cons_occour` int(11) default null,
	`11_first_occour` datetime default null,
	`11_last_occour` datetime default null,
	
	`12_adj_occour` int(11) default null,
	`12_adj_id` int(11) default null,
	
	`12_cons_occour` int(11) default null,
	`12_first_occour` datetime default null,
	`12_last_occour` datetime default null,
	
	`13_adj_occour` int(11) default null,
	`13_adj_id` int(11) default null,
	
	`13_cons_occour` int(11) default null,
	`13_first_occour` datetime default null,
	`13_last_occour` datetime default null,
	
	`14_adj_occour` int(11) default null,
	`14_adj_id` int(11) default null,
	
	`14_cons_occour` int(11) default null,
	`14_first_occour` datetime default null,
	`14_last_occour` datetime default null,
	
	`15_adj_occour` int(11) default null,
	`15_adj_id` int(11) default null,
	
	`15_cons_occour` int(11) default null,
	`15_first_occour` datetime default null,
	`15_last_occour` datetime default null,
	
	Primary Key (`istats_id`)



) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- current .. one after ... two after [4 _ 6 _ _ 9]
-- current .. two after .. one after. [4 _ _ 7 _ 9]
-- current .. one after .. three after [4 _ 6 _ _ _ 10]
-- current .. three after .. one after [4 _ _ _ 8 _ 10]
-- current .. four after .. one after [4 _ _ _ _ 9 _ 11]
-- current .. one after .. four after [4 _ 6 _ _ _ _ 11]
-- current .. five after .. one after [4 _ _ _ _ _ 10 _ 12]
-- current .. one after .. five after [4 _ 6 _ _ _ _ _ 12]
-- current draw .. one after .. two after [4 _ 4 _ _ 4]
-- current draw .. two after .. one after [4 _ _ 4 _ 4]
-- current draw .. three after .. one after [4 _ _ _ 4 _ 4]
-- current draw .. one after .. three after [4 _ 4 _ _ _ 4]
-- current draw .. four after .. one after [4 _ _ _ _ 4 _ 4]
-- current draw .. five after .. one after [4 _ _ _ _ _ 4 _ 4]
-- current draw ..one after .. five after [4 _ 4 _ _ _ _ _ 4]
-- start 4 ... increment by 1  .. end 8 [4 5 6 7 8]
-- start 4 ... increment by 2 .. end 8 [4 _ 6 _ 8]
-- start 4 ... increment by 3 .. end 12 [4 _ _ 7 _ _ 10 _ _ ]
-- start 4 ... increment by 4 .. end 20 [4 _ _ _ 8 _ _ _ 12 _ _ _ 16 _ _ _ 20]"

-- start draw 4 .. inrement by 1 .... end draw 8 [dr4 ~ dr5 ~ dr6 ~ dr7 ~ dr8]
-- start draw 4 .. incr by 2 .. end draw 8 [dr4 ~ _ ~ dr6 ~ _ ~ dr8]
-- start draw 4 .. incr by 3 .. end draw 12 [dr4 ~ _ ~ _ ~ dr7 ~ _ ~ _ ~ dr10]

--




DROP TABLE IF EXISTS `tbl_comb_pattern`;
CREATE TABLE IF NOT EXISTS `tbl_comb_pattern` (
  `icomb_pattern_id` int(11) NOT NULL AUTO_INCREMENT,

  `st_num` int(11) default null,
  `ed_num` int(11) default null,
  `incr_by` int(11) default null,
  `incr_type` int(11) default null,
  
  
  
  
  PRIMARY KEY (`icomb_pattern_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;





-- --------------------------------------------------------

--
-- Table structure for table `tbl_comb_lottario`
--

DROP TABLE IF EXISTS `tbl_comb_lottario`;
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

DROP TABLE IF EXISTS `tbl_comb_max`;
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

DROP TABLE IF EXISTS `tbl_comb_pick3`;
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

DROP TABLE IF EXISTS `tbl_comb_pick4`;
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

DROP TABLE IF EXISTS `tbl_comb_play_hist`;
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

DROP TABLE IF EXISTS `tbl_comb_play_hist_detail`;
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

DROP TABLE IF EXISTS `tbl_comb_poker`;
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
--
-- Table structure for table `tbl_na_649`
--

DROP TABLE IF EXISTS `tbl_na_649`;
CREATE TABLE IF NOT EXISTS `tbl_na_649` (
  `na649id` int(11) NOT NULL AUTO_INCREMENT,
  `isequencenum` int(11) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=212 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_649_winnings`
--

DROP TABLE IF EXISTS `tbl_na_649_winnings`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=252 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_649_wins_loc`
--

DROP TABLE IF EXISTS `tbl_na_649_wins_loc`;
CREATE TABLE IF NOT EXISTS `tbl_na_649_wins_loc` (
  `na649wins_locid` int(11) NOT NULL AUTO_INCREMENT,
  `na649winningid` int(11) DEFAULT NULL,
  `wcount` int(11) DEFAULT NULL,
  `wamount` int(11) NOT NULL,
  `wlocid` int(11) DEFAULT NULL,
  `wnum_m` int(11) DEFAULT NULL,
  PRIMARY KEY (`na649wins_locid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=575 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_lottomax`
--

DROP TABLE IF EXISTS `tbl_na_lottomax`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=974 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_lottomax_winning`
--

DROP TABLE IF EXISTS `tbl_na_lottomax_winning`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=973 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_lottomax_wins_loc`
--

DROP TABLE IF EXISTS `tbl_na_lottomax_wins_loc`;
CREATE TABLE IF NOT EXISTS `tbl_na_lottomax_wins_loc` (
  `namaxwins_locid` int(11) NOT NULL AUTO_INCREMENT,
  `namaxwinningid` int(11) DEFAULT NULL,
  `wamount` int(11) DEFAULT NULL,
  `wcount` int(11) DEFAULT NULL,
  `wlocid` int(11) DEFAULT NULL,
  `wnum_m` int(11) DEFAULT NULL,
  PRIMARY KEY (`namaxwins_locid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=761 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_na_super7`
--

DROP TABLE IF EXISTS `tbl_na_super7`;
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

DROP TABLE IF EXISTS `tbl_na_super7_winning`;
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

DROP TABLE IF EXISTS `tbl_on_49`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=200 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_49_winnings`
--

DROP TABLE IF EXISTS `tbl_on_49_winnings`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=199 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_early_bird`
--

DROP TABLE IF EXISTS `tbl_on_early_bird`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_encore`
--

DROP TABLE IF EXISTS `tbl_on_encore`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=810 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_encore_winnings`
--

DROP TABLE IF EXISTS `tbl_on_encore_winnings`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=646 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_keno`
--

DROP TABLE IF EXISTS `tbl_on_keno`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=711 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_on_keno_winnings`
--

DROP TABLE IF EXISTS `tbl_on_keno_winnings`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=601 ;

-- --------------------------------------------------------
