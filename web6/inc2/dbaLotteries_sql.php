<?php

// NATIONAL (Lotto 649 / Lotto Max / Lotto Super 7)


// ONTARIO [OLG](On 49 / Encore / Keno / Lottario / PayDay / Pick 3 / Pick 4 / Poker)

// ALC (Atlantic Lotto Corporation)
// (Atlantic 49 / Bucko / Keno / Pik 4 / Tag)

// BCLC (British Columbia Lotto Corporation)
// 

// [WC | ALC | QUE | ONT | BC]
// WC - Western Canada Lottery Corporation
//      (Alberta, Saskatchewan, Manitoba) & (NU [Nunavut], NT [Northwest Territories], YT [Yukon Territory]) 
// ALC - Atlantic Lottery Corporation
//      (Newfoundland, Prince Edward Island, Nova Scotia, New Brunswick)
// QUE - Lotto Quebec
//       
// ONT - Ontario Lottery and Gaming Corporation
// BC  - British Columbia Lottery Corporation

/*
 * NA
 *  DB:
 *  tbl_na_649
 *  tbl_na_max
 *  tbl_na_super7
 * 
 * WC - WCLC
 *  DB:
 *  tbl_wclc_49
 *  tbl_wclc_extra
 *  tbl_wclc_keno
 *  tbl_wclc_payday
 *  tbl_wclc_pick3
 *  tbl_wclc_pick4
 *  
 * ALC
 *  DB:
 *  tbl_alc_49
 *  tbl_alc_bucko
 *  tbl_alc_pik4
 *  tbl_alc_keno
 *  tbl_alc_tag
 * QUE - QLC
 *  DB:
 *  tbl_qlc_49
 *  tbl_qlc_astro
 *  tbl_qlc_banco
 *  tbl_qlc_extra
 *  tbl_qlc_jour_de_paye
 *  tbl_qlc_la_mini
 *  tbl_qlc_la_quotidienne_3
 *  tbl_qlc_la_quotidienne_4
 *  tbl_qlc_tango
 *  tbl_qlc_triplex
 * 
 * ONT - ON
 *  DB:
 *  tbl_on_49
 *  tbl_on_early_bird
 *  tbl_on_encore
 *  tbl_on_keno
 *  tbl_on_lottario
 *  tbl_on_payday
 *  tbl_on_pick3
 *  tbl_on_pick4
 *  tbl_on_poker
 * 
 * BC
 *  DB:
 *  tbl_bclc_49
 *  tbl_bclc_keno
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * delimiter $$

CREATE TABLE `tbl_bclc_keno_winnings` (
  `bclckenowinningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

 * 
 * 
 * 
 * 
 * 
 * 
 * delimiter $$

CREATE TABLE `tbl_alc_49` (
  `alc49id` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_alc_bucko` (
  `alcbuckoid` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` int(11) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  PRIMARY KEY (`alcbuckoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_alc_keno` (
  `alckenoid` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_alc_pik4` (
  `alcpik4id` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_alc_tag` (
  `alctagid` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_archive_stats` (
  `id` int(11) NOT NULL,
  `surl` varchar(255) DEFAULT NULL,
  `last-fetched` datetime DEFAULT NULL,
  `sgame` varchar(45) DEFAULT NULL,
  `iday` int(11) DEFAULT NULL,
  `imonth` int(11) DEFAULT NULL,
  `iyear` int(11) DEFAULT NULL,
  `sfile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_game_status` (
  `gameStatusId` int(11) NOT NULL,
  `game` varchar(45) DEFAULT NULL,
  `nextDrawDate` datetime DEFAULT NULL,
  `currentDrawDate` datetime DEFAULT NULL,
  `monday` tinyint(4) DEFAULT NULL,
  `tuesday` tinyint(4) DEFAULT NULL,
  `wednesday` tinyint(4) DEFAULT NULL,
  `thursday` tinyint(4) DEFAULT NULL,
  `friday` tinyint(4) DEFAULT NULL,
  `saturday` tinyint(4) DEFAULT NULL,
  `sunday` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`gameStatusId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_lottery_games` (
  `gameid` int(11) NOT NULL,
  `gamecode` varchar(45) DEFAULT NULL,
  `gamedesc` varchar(45) DEFAULT NULL,
  `drawstartdate` datetime DEFAULT NULL,
  `drawenddate` datetime DEFAULT NULL,
  `drawSchedule` varchar(45) DEFAULT NULL,
  `db_table_name` varchar(100) DEFAULT NULL,
  `iMon` tinyint(4) DEFAULT NULL,
  `iTue` tinyint(4) DEFAULT NULL,
  `iWed` tinyint(4) DEFAULT NULL,
  `iThu` tinyint(4) DEFAULT NULL,
  `iFri` tinyint(4) DEFAULT NULL,
  `iSat` tinyint(4) DEFAULT NULL,
  `iSun` tinyint(4) DEFAULT NULL,
  `iWeekly` tinyint(4) DEFAULT NULL,
  `iBiWeekly` tinyint(4) DEFAULT NULL,
  `iMonthly` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_major_winners` (
  `major_winning_id` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_na_649` (
  `na649id` int(11) NOT NULL,
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
  PRIMARY KEY (`na649id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_na_649_winnings` (
  `na649winningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_na_lottomax` (
  `namaxid` int(11) NOT NULL,
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
  PRIMARY KEY (`namaxid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_na_lottomax_winning` (
  `namaxwinningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_na_super7` (
  `nasuper7id` int(11) NOT NULL,
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
  PRIMARY KEY (`nasuper7id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_na_super7_winning` (
  `nasuper7winningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_49` (
  `on49id` bigint(20) NOT NULL,
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
  PRIMARY KEY (`on49id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_49_winnings` (
  `on49winningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_big_winnings` (
  `winning_id` int(11) NOT NULL,
  `str_wstore_name` varchar(255) DEFAULT NULL,
  `str_wstore_addr` varchar(255) DEFAULT NULL,
  `str_wgame` varchar(255) DEFAULT NULL,
  `str_wdraw_date` datetime DEFAULT NULL,
  `str_wamount` decimal(10,0) DEFAULT NULL,
  `str_wstore_postal` varchar(7) DEFAULT NULL,
  `str_wstore_city` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`winning_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_early_bird` (
  `onearlybirdid` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`onearlybirdid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_encore` (
  `onencoreid` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_encore_winnings` (
  `onencorewinningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_keno` (
  `onkenoid` bigint(20) NOT NULL,
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
  PRIMARY KEY (`onkenoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_keno_winnings` (
  `onkenowinningid` int(11) NOT NULL,
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
  `m_10_10_2_amount` int(11) DEFAULT NULL,
  `m_10_9_2_count` int(11) DEFAULT NULL,
  `m_10_9_2_amount` int(11) DEFAULT NULL,
  `m_10_8_2_count` int(11) DEFAULT NULL,
  `m_10_8_2_amount` int(11) DEFAULT NULL,
  `m_10_7_2_count` int(11) DEFAULT NULL,
  `m_10_7_2_amount` int(11) DEFAULT NULL,
  `m_10_0_2_count` int(11) DEFAULT NULL,
  `m_10_0_2_amount` int(11) DEFAULT NULL,
  `m_9_9_2_count` int(11) DEFAULT NULL,
  `m_9_9_2_amount` int(11) DEFAULT NULL,
  `m_9_8_2_count` int(11) DEFAULT NULL,
  `m_9_8_2_amount` int(11) DEFAULT NULL,
  `m_9_7_2_count` int(11) DEFAULT NULL,
  `m_9_7_2_amount` int(11) DEFAULT NULL,
  `m_9_6_2_count` int(11) DEFAULT NULL,
  `m_9_6_2_amount` int(11) DEFAULT NULL,
  `m_8_8_2_count` int(11) DEFAULT NULL,
  `m_8_8_2_amount` int(11) DEFAULT NULL,
  `m_8_7_2_count` int(11) DEFAULT NULL,
  `m_8_7_2_amount` int(11) DEFAULT NULL,
  `m_8_6_2_count` int(11) DEFAULT NULL,
  `m_8_6_2_amount` int(11) DEFAULT NULL,
  `m_7_7_2_count` int(11) DEFAULT NULL,
  `m_7_7_2_amount` int(11) DEFAULT NULL,
  `m_7_6_2_count` int(11) DEFAULT NULL,
  `m_7_6_2_amount` int(11) DEFAULT NULL,
  `m_7_5_2_count` int(11) DEFAULT NULL,
  `m_7_5_2_amount` int(11) DEFAULT NULL,
  `m_6_6_2_count` int(11) DEFAULT NULL,
  `m_6_6_2_amount` int(11) DEFAULT NULL,
  `m_6_5_2_count` int(11) DEFAULT NULL,
  `m_6_5_2_amount` int(11) DEFAULT NULL,
  `m_5_5_2_count` int(11) DEFAULT NULL,
  `m_5_5_2_amount` int(11) DEFAULT NULL,
  `m_5_4_2_count` int(11) DEFAULT NULL,
  `m_5_4_2_amount` int(11) DEFAULT NULL,
  `m_4_4_2_count` int(11) DEFAULT NULL,
  `m_4_4_2_amount` int(11) DEFAULT NULL,
  `m_3_3_2_count` int(11) DEFAULT NULL,
  `m_3_3_2_amount` int(11) DEFAULT NULL,
  `m_2_2_2_count` int(11) DEFAULT NULL,
  `m_2_2_2_amount` int(11) DEFAULT NULL,
  `m_10_10_5_count` int(11) DEFAULT NULL,
  `m_10_10_5_amount` int(11) DEFAULT NULL,
  `m_10_9_5_count` int(11) DEFAULT NULL,
  `m_10_9_5_amount` int(11) DEFAULT NULL,
  `m_10_8_5_count` int(11) DEFAULT NULL,
  `m_10_8_5_amount` int(11) DEFAULT NULL,
  `m_10_7_5_count` int(11) DEFAULT NULL,
  `m_10_7_5_amount` int(11) DEFAULT NULL,
  `m_10_0_5_count` int(11) DEFAULT NULL,
  `m_10_0_5_amount` int(11) DEFAULT NULL,
  `m_9_9_5_count` int(11) DEFAULT NULL,
  `m_9_9_5_amount` int(11) DEFAULT NULL,
  `m_9_8_5_count` int(11) DEFAULT NULL,
  `m_9_8_5_amount` int(11) DEFAULT NULL,
  `m_9_7_5_count` int(11) DEFAULT NULL,
  `m_9_7_5_amount` int(11) DEFAULT NULL,
  `m_9_6_5_count` int(11) DEFAULT NULL,
  `m_9_6_5_amount` int(11) DEFAULT NULL,
  `m_8_8_5_count` int(11) DEFAULT NULL,
  `m_8_8_5_amount` int(11) DEFAULT NULL,
  `m_8_7_5_count` int(11) DEFAULT NULL,
  `m_8_7_5_amount` int(11) DEFAULT NULL,
  `m_8_6_5_count` int(11) DEFAULT NULL,
  `m_8_6_5_amount` int(11) DEFAULT NULL,
  `m_7_7_5_count` int(11) DEFAULT NULL,
  `m_7_7_5_amount` int(11) DEFAULT NULL,
  `m_7_6_5_count` int(11) DEFAULT NULL,
  `m_7_6_5_amount` int(11) DEFAULT NULL,
  `m_7_5_5_count` int(11) DEFAULT NULL,
  `m_7_5_5_amount` int(11) DEFAULT NULL,
  `m_6_6_5_count` int(11) DEFAULT NULL,
  `m_6_6_5_amount` int(11) DEFAULT NULL,
  `m_6_5_5_count` int(11) DEFAULT NULL,
  `m_6_5_5_amount` int(11) DEFAULT NULL,
  `m_5_5_5_count` int(11) DEFAULT NULL,
  `m_5_5_5_amount` int(11) DEFAULT NULL,
  `m_5_4_5_count` int(11) DEFAULT NULL,
  `m_5_4_5_amount` int(11) DEFAULT NULL,
  `m_4_4_5_count` int(11) DEFAULT NULL,
  `m_4_4_5_amount` int(11) DEFAULT NULL,
  `m_3_3_5_count` int(11) DEFAULT NULL,
  `m_3_3_5_amount` int(11) DEFAULT NULL,
  `m_2_2_5_count` int(11) DEFAULT NULL,
  `m_2_2_5_amount` int(11) DEFAULT NULL,
  `m_10_10_10_count` int(11) DEFAULT NULL,
  `m_10_10_10_amount` int(11) DEFAULT NULL,
  `m_10_9_10_count` int(11) DEFAULT NULL,
  `m_10_9_10_amount` int(11) DEFAULT NULL,
  `m_10_8_10_count` int(11) DEFAULT NULL,
  `m_10_8_10_amount` int(11) DEFAULT NULL,
  `m_10_7_10_count` int(11) DEFAULT NULL,
  `m_10_7_10_amount` int(11) DEFAULT NULL,
  `m_10_0_10_count` int(11) DEFAULT NULL,
  `m_10_0_10_amount` int(11) DEFAULT NULL,
  `m_9_9_10_count` int(11) DEFAULT NULL,
  `m_9_9_10_amount` int(11) DEFAULT NULL,
  `m_9_8_10_count` int(11) DEFAULT NULL,
  `m_9_8_10_amount` int(11) DEFAULT NULL,
  `m_9_7_10_count` int(11) DEFAULT NULL,
  `m_9_7_10_amount` int(11) DEFAULT NULL,
  `m_9_6_10_count` int(11) DEFAULT NULL,
  `m_9_6_10_amount` int(11) DEFAULT NULL,
  `m_8_8_10_count` int(11) DEFAULT NULL,
  `m_8_8_10_amount` int(11) DEFAULT NULL,
  `m_8_7_10_count` int(11) DEFAULT NULL,
  `m_8_7_10_amount` int(11) DEFAULT NULL,
  `m_8_6_10_count` int(11) DEFAULT NULL,
  `m_8_6_10_amount` int(11) DEFAULT NULL,
  `m_7_7_10_count` int(11) DEFAULT NULL,
  `m_7_7_10_amount` int(11) DEFAULT NULL,
  `m_7_6_10_count` int(11) DEFAULT NULL,
  `m_7_6_10_amount` int(11) DEFAULT NULL,
  `m_7_5_10_count` int(11) DEFAULT NULL,
  `m_7_5_10_amount` int(11) DEFAULT NULL,
  `m_6_6_10_count` int(11) DEFAULT NULL,
  `m_6_6_10_amount` int(11) DEFAULT NULL,
  `m_6_5_10_count` int(11) DEFAULT NULL,
  `m_6_5_10_amount` int(11) DEFAULT NULL,
  `m_5_5_10_count` int(11) DEFAULT NULL,
  `m_5_5_10_amount` int(11) DEFAULT NULL,
  `m_5_4_10_count` int(11) DEFAULT NULL,
  `m_5_4_10_amount` int(11) DEFAULT NULL,
  `m_4_4_10_count` int(11) DEFAULT NULL,
  `m_4_4_10_amount` int(11) DEFAULT NULL,
  `m_3_3_10_count` int(11) DEFAULT NULL,
  `m_3_3_10_amount` int(11) DEFAULT NULL,
  `m_2_2_10_count` int(11) DEFAULT NULL,
  `m_2_2_10_amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`onkenowinningid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_lottario` (
  `onlottarioid` bigint(20) NOT NULL,
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
  PRIMARY KEY (`onlottarioid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_lottario_winnings` (
  `onlottariowinningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_payday` (
  `onpaydayid` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`onpaydayid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_pick3` (
  `onpick3id` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  PRIMARY KEY (`onpick3id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_pick3_winnings` (
  `onpick3winningid` int(11) NOT NULL,
  `onpick3id` int(11) DEFAULT NULL,
  `m_3_s_count` int(11) DEFAULT NULL,
  `m_3_s_amount` double DEFAULT NULL,
  `m_3_b_count` int(11) DEFAULT NULL,
  `m_3_b_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`onpick3winningid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_pick4` (
  `onpick4id` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`onpick4id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_pick4_winnings` (
  `onpick4winningid` int(11) NOT NULL,
  `onpick4id` int(11) DEFAULT NULL,
  `m_4_s_count` int(11) DEFAULT NULL,
  `m_4_s_amount` double DEFAULT NULL,
  `m_4_b_count` int(11) DEFAULT NULL,
  `m_4_b_amount` double DEFAULT NULL,
  `game_total_sales` double DEFAULT NULL,
  PRIMARY KEY (`onpick4winningid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_poker` (
  `onpokerid` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `scard1` varchar(2) DEFAULT NULL,
  `scard2` varchar(2) DEFAULT NULL,
  `scard3` varchar(2) DEFAULT NULL,
  `scard4` varchar(2) DEFAULT NULL,
  `scard5` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`onpokerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_on_poker_winnings` (
  `onpokerwinningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_49` (
  `qlc49id` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_49_winnings` (
  `qlc49winningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_astro` (
  `qlcastroid` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlcastroid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_banco` (
  `qlcbancoid` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_extra` (
  `qlcextraid` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_jour_de_paye` (
  `qlcjour_de_payeid` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_la_mini` (
  `qlcla_mini_id` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_la_quotidienne_3` (
  `qlc_la_quotidienne_3id` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlc_la_quotidienne_3id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_la_quotidienne_4` (
  `qlc_la_quotidienne_4id` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlc_la_quotidienne_4id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_tango` (
  `qlctangoid` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snumbonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlctangoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_qlc_triplex` (
  `qlctriplexid` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  `snum5` int(11) DEFAULT NULL,
  PRIMARY KEY (`qlctriplexid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_wclc49_winnings` (
  `wclc49winningid` int(11) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_wclc_49` (
  `wclc49id` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_wclc_extra` (
  `wclcextraid` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_wclc_keno` (
  `wclckenoid` bigint(20) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_wclc_payday` (
  `wclcpaydayid` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`wclcpaydayid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_wclc_pick3` (
  `wclcpick3id` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  PRIMARY KEY (`wclcpick3id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_wclc_pick4` (
  `wclcpick4id` bigint(20) NOT NULL,
  `sproduct` varchar(10) DEFAULT NULL,
  `idrawnum` bigint(20) DEFAULT NULL,
  `drawdate` datetime DEFAULT NULL,
  `snum1` int(11) DEFAULT NULL,
  `snum2` int(11) DEFAULT NULL,
  `snum3` int(11) DEFAULT NULL,
  `snum4` int(11) DEFAULT NULL,
  PRIMARY KEY (`wclcpick4id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

delimiter $$

CREATE TABLE `tbl_winners_1000_more` (
  `winning_id` int(11) NOT NULL,
  `str_first_name` varchar(255) DEFAULT NULL,
  `str_last_name` varchar(255) DEFAULT NULL,
  `str_city_name` varchar(255) DEFAULT NULL,
  `str_prov_code` varchar(45) DEFAULT NULL,
  `str_lotto_game` varchar(45) DEFAULT NULL,
  `str_draw_date` varchar(20) DEFAULT NULL,
  `str_multiple_draw` varchar(3) DEFAULT NULL,
  `str_prize` varchar(45) DEFAULT NULL,
  `str_insider` varchar(2) DEFAULT NULL,
  `str_group` varchar(2) DEFAULT NULL,
  `parent_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`winning_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8$$

 * 
 * 
 * 
 * 
 * 
 * 
 */
?>