<?php

  include_once("class_db.php");
  include_once("incGenDates.php");
  class Lottery {
    
    var $db_obj;
    var $vstr = 0;
    var $vnum = 1;
     
    var $olg49V;
    
    var $prz_money = 0;
    var $prz_other = 1;
    
    var $loc_city   = 0;
    var $loc_prov   = 1;
    var $loc_cntry  = 2;
    var $loc_any    = 3;
    
      // Debug Mode
    // 0 = verbose disabled
    // 1 = verbose enabled
    // 2 = verbose extra info
    
    
    //var $debug_mode         = 2;
    
    /*
     * 
 

INSERT INTO `dbaLotteries`.`tbl_lot_win_locations`
(`lot_loc_id`,
`loc_city`,
`loc_prov`,
`loc_country`,
`loc_any`,
`loc_type`)
VALUES
(
{lot_loc_id: INT},
{loc_city: VARCHAR},
{loc_prov: VARCHAR},
{loc_country: VARCHAR},
{loc_any: VARCHAR},
{loc_type: INT}
);


     * 
     * 
     * 
     * 
     */ 
    
    function dbLotWinLocationAdd($loc_city, $loc_prov, $loc_country, $loc_any, $loc_type) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("INSERT INTO `tbl_lot_win_locations` (`loc_city`,`loc_prov`,`loc_country`,`loc_any`,`loc_type`) ");
        $ssql .= sprintf(" VALUES ('%s','%s','%s','%s',%u)", $loc_city, $loc_prov, $loc_country, $loc_any, $loc_type);    
        ///print "\n SSQL Loc Add: " . $ssql;
        $rows_affect = $this->db_obj->exec($ssql);
        return $this->db_obj->last_id; 
    }
    
    function dbLotWinLocationRemove($lot_loc_id = "") {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("DELETE FROM `tbl_lot_win_locations` ");
        $ssql .= sprintf(" WHERE lot_loc_id = %u", $lot_loc_id);
        
        $this->db_obj->exec($ssql);
    }
    
    function dbLotWinLocationModify($lot_loc_id = "",$loc_city, $loc_prov, $loc_country, $loc_any, $loc_type) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      
        $ssql = sprintf("UPDATE `tbl_lot_win_locations` SET ");
        $ssql .= sprintf(" loc_city = '%s', loc_prov = '%s', loc_country = '%s', loc_any = '%s', loc_type = %u", $loc_city, $loc_prov, $loc_country, $loc_any, $loc_type);
        
        $this->db_obj->exec($ssql);
    }
    
    function dbLotWinLocationGet($lot_loc_id) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $ssql = sprintf("SELECT * FROM `tbl_lot_win_locations` WHERE lot_loc_id = %u", $lot_loc_id);
        
        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res[0];
        } else {
          return null;
        }
    }
    
    function dbLotWinLocationGetId($loc_field, $loc_type = "") {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_lot_win_locations` WHERE (loc_city = '%s' OR loc_prov = '%s' OR loc_country = '%s' OR loc_any = '%s')", $loc_field, $loc_field, $loc_field, $loc_field);
        
        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          //print_r ($db_res);
          return $db_res[0]["lot_loc_id"];
        } else {
          return null;
        }
    }
    
    /*
     * 
     * INSERT INTO `dbaLotteries`.`tbl_fetch_data_stats`
(`fetch_stats_Id`,
`game`,
`gameid`,
`DrawDate`,
`s_web_domain`,
`s_web_path`,
`s_web_file`,
`s_web_query`,
`fetch_date`,
`fetch_count`,
`prev_fetch_date`)
VALUES
(
{fetch_stats_Id: INT},
{game: VARCHAR},
{gameid: INT},
{DrawDate: DATETIME},
{s_web_domain: INT},
{s_web_path: INT},
{s_web_file: INT},
{s_web_query: INT},
{fetch_date: DATETIME},
{fetch_count: INT},
{prev_fetch_date: DATETIME}
);
     * 
     * 
     * INSERT INTO `dbaLotteries`.`tbl_fetch_detail`
(`fetch_stat_id`,
`fetch_date`,
`fetch_pos`)
VALUES
(
{fetch_stat_id: INT},
{fetch_date: DATETIME},
{fetch_pos: INT}
);
     * 
     * 
     */
     
      function dbFetchDetailAdd($fetch_stat_id, $fetch_date, $fetch_pos, $is_success) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        //$ssql = sprintf("SELECT * FROM `tbl_fetch_detail` WHERE fetch_stat_id = %u AND is_success = 0", $fetch_stat_id);
        //$db_res = $this->db_obj->fetch($ssql);
        //if (!is_array($db_res)) {
          $ssql = sprintf("INSERT INTO `tbl_fetch_detail` (`fetch_stat_id`,`fetch_date`,`fetch_pos`, `is_success`) ");
          $ssql .= sprintf(" VALUES(%u,'%s',%u,%u)", $fetch_stat_id, $fetch_date, $fetch_pos, $is_success);  
          $rows_affected = $this->db_obj->exec($ssql);
          //print " \nDetail Add: " . $ssql ;

        /*} else {
          $ssql = sprintf("UPDATE `tbl_fetch_detail` SET `fetch_date` = '%s', `fetch_pos` = %u, `is_success` = %u ", $fetch_date, $fetch_pos, $is_success);
          $ssql .= sprintf(" WHERE fetch_stat_id = %u", $fetch_stat_id);
          $rows_affected = $this->db_obj->exec($ssql);
          print "\n Detail Upd: " . $ssql;
        }*/
        return $rows_affected;
      }
     
      function dbFetchDetailGetMaxPos($fetch_stat_id) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $ssql = sprintf("SELECT Max(fetch_pos) as Max_Pos FROM `tbl_fetch_detail` WHERE fetch_stat_id = %u", $fetch_stat_id);
        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res[0]["Max_Pos"];        
        } else {
          return null;
        }
      }
      function dbFetchDataStatsAdd($gameCode, $gameId, $drawDate, $s_web_domain, $s_web_path, $s_web_file, $s_web_query, $fetch_date, $fetch_count, $prev_fetch_date) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("INSERT INTO `tbl_fetch_data_stats` (`game`,`gameid`,`DrawDate`,`s_web_domain`,`s_web_path`,`s_web_file`,`s_web_query`,`fetch_date`,`fetch_count`,`prev_fetch_date`) ");
        $ssql .= sprintf(" VALUES ('%s',%u,'%s',%u,%u,%u,%u,'%s',%u,'%s')", $gameCode, $gameId, $drawDate, $s_web_domain, $s_web_path, $s_web_file, $s_web_query, $fetch_date, $fetch_count, $prev_fetch_date);

        $row_affected = $this->db_obj->exec($ssql);
        
        return $this->db_obj->last_id;        
        
      }
     
      function dbFetchDataStatsRemove($fetch_stats_id = "") {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("DELETE FROM `tbl_fetch_data_stats` WHERE ");
        $ssql .= sprintf(" fetch_stats_Id = %u", $fetch_stats_id);
        
       return $this->db_obj->exec($ssql);
      }
      
      function dbFetchDataStatsCntAdd ($fetch_stats_id, $fetch_count) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $ssql = sprintf("UPDATE `tbl_fetch_data_stats` SET ");
        $ssql .= sprintf(" fetch_count = %u ", $fetch_count);
        $ssql .= sprintf(" WHERE fetch_stats_id = %u", $fetch_stats_id);
        
        //print_r($ssql);
        return $this->db_obj->exec($ssql);
      }
      
      function dbFetchDataStatsModify ($fetch_stats_id, $gameCode, $gameId, $drawDate, $s_web_domain, $s_web_path, $s_web_file, $s_web_query, $fetch_date, $fetch_count, $prev_fetch_date) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("UPDATE `tbl_fetch_data_stats` SET ");
        $ssql .= sprintf("game = '%s', gameid = %u, DrawDate = '%s', s_web_domain = %u, s_web_path = %u, s_web_file = %u, s_web_query = %u, fetch_date = '%s', fetch_count = %u, prev_fetch_date = '%s'", 
         $gameCode, $gameId, $drawDate, $s_web_domain, $s_web_path, $s_web_file, $s_web_query, $fetch_date, $fetch_count, $prev_fetch_date);    
        $ssql .= sprintf(" WHERE fetch_stats_id = %u", $fetch_stats_id);
        
        $this->db_obj->exec($ssql); 
        return $this->db_obj->rows_affected;
         
       }
     
      function dbFetchDataStatsGet($gameCode = "", $s_web_domain = "", $s_web_path = "", $s_web_file = "", $s_web_query = "" ) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $ssql = sprintf("SELECT * FROM `tbl_fetch_data_stats` ");
        $ssql .= sprintf(" WHERE s_web_domain = %u AND s_web_path = %u AND s_web_file = %u AND s_web_query = %u", $s_web_domain, $s_web_path, $s_web_file, $s_web_query);
        
        $db_result = $this->db_obj->fetch($ssql);
        if (is_array($db_result)) {
          return $db_result[0];
        } 
      }
      
      function dbFetchDataStatsGetId($gameCode = "", $s_web_domain = "", $s_web_path = "", $s_web_file = "", $s_web_query = "" ) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $ssql = sprintf("SELECT * FROM `tbl_fetch_data_stats` ");
        $ssql .= sprintf(" WHERE s_web_domain = %u AND s_web_path = %u AND s_web_file = %u AND s_web_query = %u", $s_web_domain, $s_web_path, $s_web_file, $s_web_query);
        $db_result = $this->db_obj->fetch($ssql);
        //print "FETCH DATA: ";
        //print_r($db_result);
        //print "\n";
        if (is_array($db_result)) {
          return $db_result[0]["fetch_stats_id"];
        } else {
          return null;
        }
      }
      
      
     /* 
     * 
     * INSERT INTO `dbaLotteries`.`tbl_web_urls`
(`web_url_id`,
`web_url_content`,
`web_url_type`)
VALUES
(
{web_url_id: INT},
{web_url_content: VARCHAR},
{web_url_type: VARCHAR}
);
     *
     * 
     */ 
     function dbWebUrlsGetId($web_url_content, $web_url_type) {
       if (!$this->db_obj) {
        $this->db_obj = new db();
       }
       $ssql = sprintf("SELECT * FROM `tbl_web_urls` WHERE web_url_content = '%s' AND web_url_type = '%s'",$web_url_content, $web_url_type);
       $db_result = $this->db_obj->fetch($ssql);
       //print_r($db_result);
       if (is_array($db_result)) {
         return $db_result[0]["web_url_id"];
       } 
       
     }
     function dbWebUrlsAdd($web_url_content, $web_url_type) {
       if (!$this->db_obj) {
        $this->db_obj = new db();
       }
       
       $ssql = sprintf("INSERT INTO `tbl_web_urls` (`web_url_content`,`web_url_type`) VALUES ");
       $ssql .= sprintf("('%s','%s')",$web_url_content, $web_url_type);
       $rows_affec = $this->db_obj->exec($ssql);
       return $this->db_obj->last_id;
     }
     
     function dbWebUrlsRemove($web_url_id = "", $web_url_content = "", $web_url_type = "") {
       if (!$this->db_obj) {
        $this->db_obj = new db();
       }
       
       $ssql = sprintf("DELETE FROM `tbl_web_urls` WHERE ");
       $ssql .= sprintf("web_url_id = %u");
       $this->db_obj->exec($ssql);
       return $this->db_obj->rows_affected;
     } 
     
     
     function dbWebUrlsModify($web_url_id = "", $web_url_content = "", $web_url_type = "") {
       if (!$this->db_obj) {
         $this->db_obj = new db();
       }  
       $ssql = sprintf("UPDATE `tbl_web_urls` SET ");
       $ssql .= sprintf(" web_url_content = '%s' , web_url_type = '%s'", $web_url_content, $web_url_type);
       $ssql .= sprintf(" WHERE web_url_id = %u", $web_url_id);
       
       $this->db_obj->exec($ssql);
       return $this->db_obj->rows_affected;
     }
     /* 
     * 
     *  
     * 
     * INSERT INTO `dbaLotteries`.`tbl_winning_prizes`
(`prze_id`,
`prze_amount`,
`prze_type`,
`prze_desc`,
`gameId`,
`prze_code`)
VALUES
(
{prze_id: INT},
{prze_amount: DOUBLE},
{prze_type: INT},
{prze_desc: VARCHAR},
{gameId: INT},
{prze_code: INT}
);
     * 
     * 
     * INSERT INTO `dbaLotteries`.`tbl_na_649_wins_loc`
(`na649wins_locid`,
`na649winningid`,
`wamount`,
`wcount`,
`wlocation`)
VALUES
(
{na649wins_locid: INT},
{na649winningid: INT},
{wamount: DOUBLE},
{wcount: INT},
{wlocation: VARCHAR}
);
     * 
     * 
     * 
     * INSERT INTO `dbaLotteries`.`tbl_on_winners_1000_more`
(`winning_id`,
`str_first_name`,
`str_last_name`,
`win_city`,
`win_prov`,
`str_lotto_game`,
`str_draw_date`,
`str_multiple_draw`,
`str_prize`,
`str_insider`,
`str_group`,
`parent_group_id`,
`str_address`)
VALUES
(
{winning_id: INT},
{str_first_name: VARCHAR},
{str_last_name: VARCHAR},
{win_city: INT},
{win_prov: INT},
{str_lotto_game: VARCHAR},
{str_draw_date: VARCHAR},
{str_multiple_draw: VARCHAR},
{str_prize: VARCHAR},
{str_insider: VARCHAR},
{str_group: VARCHAR},
{parent_group_id: INT},
{str_address: VARCHAR}
);
     * 
     * 
INSERT INTO `dbaLotteries`.`tbl_on_winning_locations`
(`winninglocid`,
`str_store_name`,
`str_store_addr`,
`str_lotto_game`,
`str_draw_date`,
`dbl_winning_amount`,
`str_street_addr`,
`str_postal_code`,
`str_city_name`)
VALUES
(
{winninglocid: INT},
{str_store_name: VARCHAR},
{str_store_addr: VARCHAR},
{str_lotto_game: VARCHAR},
{str_draw_date: DATETIME},
{dbl_winning_amount: DOUBLE},
{str_street_addr: VARCHAR},
{str_postal_code: VARCHAR},
{str_city_name: VARCHAR}
);
     * 
     * 
     */ 
     
     
     /* 
     * 
     * 
     * 
INSERT INTO `dbaLotteries`.`tbl_variable`
(`name`,
`value`)
VALUES
(
{name: VARCHAR},
{value: LONGTEXT}
);
     */
     
      
    function dbLotteryVariable($svarName, $svarValue) {
      
    } 
    
    function dbLotteryVariableAdd($svarName, $svarValue) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_variable` (`name`,`value`) ");
      $ssql .= sprintf(" VALUES ('%s','%s')", $svarName, $svarValue);
      
      $this->exec($ssql);   
      
    }
      
    function dbLotteryVariableRemove($svarName) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("DELETE from `tbl_variable` WHERE name = '%s'", $svarName);
      $this->exec($ssql);
      return $this->db_obj->rows_affected;
    }
      
     function dbLotteryVariableModify($svarName, $svarValue) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("UPDATE `tbl_variable` SET svarValue = '%s'", $svarValue);
      $ssql .= sprintf(" WHERE svarName = '%s'", $svarName);
      $this->exec($ssql); 
      return $this->db_obj->rows_affected;
     }
      
     /* 
INSERT INTO `dbaLotteries`.`tbl_winning_prizes`
(`prze_id`,
`prze_amount`,
`prze_type`,
`prze_desc`,
`gameId`,
`prze_code`)
VALUES
(
{prze_id: INT},
{prze_amount: DOUBLE},
{prze_type: INT},
{prze_desc: VARCHAR},
{gameId: INT},
{prze_code: INT}
);
     * return prze_id
     * 
     */ 
    
    
    function dbLotteryWinPrizes($prze_amount, $prze_type, $prze_desc, $gameId, $prze_code) {
      
    }
    
    function dbLotteryWinPrizesModify($prze_id, $old_prze_code = "", $prze_amount, $prze_type, $prze_desc, $gameId, $prze_code = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE `tbl_winning_prizes` SET ");
      $ssql .= sprintf(" prze_amount = %01.2f, prze_type = %u, prze_desc = '%s', gameId = %u, prze_code = '%s'",trim($prze_amount), $prze_type, trim($prze_desc), $gameId, $prze_code);   
      $ssql .= sprintf(" WHERE prze_id = %u", $prze_id);
      
      if ($old_prze_code != "") {
        $ssql .= sprintf(" AND prze_code = '%s'", $old_prze_code);
      }
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    
    function dbLotteryWinPrizesGet($prze_amount, $prze_type, $gameId) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_winning_prizes` WHERE ");
      $ssql .= sprintf(" prze_amount = %01.2f AND prze_type = %u AND gameId = %u", $prze_amount, $prze_type, $gameId);
      //print "\nSSQL : " . $ssql;

      $db_res = $this->db_obj->fetch($ssql);
      print_r ($db_res);
      if (is_array($db_res)) {
        return $db_res["0"];
      } else {
        return null;
      }
    }
    
     function dbLotteryWinPrizesGetId($prze_amount, $prze_type, $gameId) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_winning_prizes` WHERE ");
      $ssql .= sprintf(" prze_amount = %01.2f AND prze_type = %u AND gameId = %u", $prze_amount, $prze_type, $gameId);
      //print "\nSSQL : " . $ssql;

      $db_res = $this->db_obj->fetch($ssql);
      //print_r ($db_res);
      if (is_array($db_res)) {
        return $db_res["0"]["prze_id"];
      } else {
        return null;
      }
    }
    /*
     * prze_type
     *  0 - money
     *  1 - Free Ticket
     * 
     */ 
    
    function dbLotteryWinPrizesAdd($prze_amount, $prze_type, $prze_desc, $gameId) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("INSERT INTO `tbl_winning_prizes` (`prze_amount`, `prze_type`, `prze_desc`, `gameId`) VALUES ");
      $ssql .= sprintf("(%01.2f, %u, '%s', %u)", $prze_amount, $prze_type, $prze_desc, $gameId);
      $rows_aff = $this->db_obj->exec($ssql);
      //print "SSQL: " . $ssql . "\n ins ID: " . $this->db_obj->last_id;
      
      return $this->db_obj->last_id;
    }
    
    /*
    function dbLotteryWinPrizesAdd($prze_amount, $prze_type, $prze_desc, $gameId, $prze_code) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_winning_prizes` (`prze_amount`,`prze_type`,`prze_desc`,`gameId`,`prze_code`) VALUES ");

      $ssql .= sprintf("(%u,%u,'%s',%u,'%s')", $prze_amount, $prze_type, $prze_desc, $gameId, $prze_code);
      $insert_ret = $this->db_obj->exec($ssql);
      
      return $insert_ret;
        
    }    
    */
    function dbLotteryWinPrizesRemove($prze_id = "", $prze_code = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_winning_prizes` WHERE ");
      $ssql .= sprintf(" prze_id = %u ", $prze_id);
      
      if ($prze_code != "") {
        $ssql .= sprintf(" AND prze_code = '%s'", $prze_code);
       
      } 
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    /*
     * `gamecode`
     * `gamedesc`
     * `drawstartdate`
     * `drawenddate`
     * `drawSchedule`
     * `db_table_name`
     * `iMon`
     * `iTue`
     * `iWed`
     * `iThu`
     * `iFri`
     * `iSat`
     * `iSun`
     * `iWeekly`
     * `iBiWeekly`
     * `iMonthly`
     * `region`
     * `iDaily`
     * `iWedSat`
     * 
     * `gameid`
     * 
     */
    
    
    function dbLotteryGamesAdd($gamecode, $gamedesc, $region, $drawstartdate, $drawenddate, $drawSchedule, $db_table_name, $iMon, $iTue,
         $iWed, $iThu, $iFri, $iSat, $iSun, $iWeekly, $iBiWeekly, $iMonthly, $iDaily, $iWedSat) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("INSERT INTO `tbl_lottery_games` (`gamecode`,`gamedesc`,`drawstartdate`,`drawenddate`,`drawSchedule`,
                `region`, `db_table_name`,`iMon`,`iTue`,`iWed`,`iThu`,`iFri`,`iSat`,`iSun`,`iWeekly`,`iBiWeekly`,`iMonthly`, `iDaily`) ");

      $ssql .= sprintf(" VALUES ('%s','%s', '%s','%s', '%s', '%s', '%s', '%s', %u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %u)", 
                $gamecode, $gamedesc, $region, $drawstartdate, $drawenddate, $drawSchedule, $region, 
                $db_table_name, $iMon, $iTue, $iWed, $iThu, $iFri, $iSat, $iSun, $iWeekly, $iBiWeekly, $iMonthly, $iDaily);

      $rows_affec = $this->db_obj->exec($ssql);
      
      return $this->db_obj->last_id;
      
    }    

   function dbLotteryGamesShortAdd($gamecode, $gamedesc, $region, $drawstartdate, $drawenddate) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("INSERT INTO `tbl_lottery_games` (`gamecode`,`gamedesc`,`drawstartdate`,`drawenddate`, `region`) ");

      $ssql .= sprintf(" VALUES ('%s','%s', '%s','%s', '%s')", 
                $gamecode, $gamedesc,  $drawstartdate, $drawenddate, $region);

      $rows_affec = $this->db_obj->exec($ssql);
      
      return $this->db_obj->last_id;
      
    }   
    /*
     * dbLotteryGetDrawDates
     * 
     * gamecode
     * startdrawdate
     * enddrawdate
     * 
     * datetype
     *   MM = Month
     *   YY - Year
     *   DD - Date
     *   DD1DD2 - Date 1 to Date 2
     *   YY1YY2 - Year 1 to Year 2
     *   MM1MM2 - Month 1 to Month 2
     * 
     */ 
    
    function dbLotteryGetDrawDates($gamecode, $dateType = "MM",$startdrawdate = "", $enddrawdate = "") {
      
      
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE ");
      $ssql .= sprintf(" gamecode = '%s'", $gamecode);
      
      $dtes_list = array();
      $today = mktime(0,0,0,date('m'),date('d'),date('Y'));
      if ($dateType == "MM") {
          $startDate = mktime(0,0,0,date('m', $startdrawdate), 1 , date('Y',$startdrawdate));
          $endDate   = mktime(0,0,0,date('m', $enddrawdate) + 1, 0 , date('Y',$enddrawdate));
             
          if ($endDate > $today) {
            $endDate = $today;
          }
          
          //print "-- " . $startDate . " -- " . $endDate . " -- " . $today;
          //print "-- " . date('m-d-Y', $startDate) . " -- " . date('m-d-Y', $endDate) . " -- " . date('m-d-Y', $today);
      } elseif ($dateType == "YY") {
          $startDate = mktime(0,0,0,1, 1 , date('Y',$startdrawdate));
          $endDate   = mktime(0,0,0,12, 31 , date('Y',$enddrawdate));
          
          if ($endDate > $today) {
            $endDate = $today;
          }
          
      } elseif ($dateType == "DD") {
          $startDate = $startdrawdate;
          $endDate = $startdrawdate;
          
          if ($endDate > $today) {
            $endDate = $today;
          }
      } elseif ($dateType == "DD1DD2") {
          $startDate  = $startdrawdate;
          $endDate    = $enddrawdate;
          if ($endDate > $today) {
            $endDate = $today;
          }
      } elseif ($dateType == "MM1MM2") {
          $startDate  = mktime(0,0,0,date('m',$startdrawdate),1,date('Y',$startdrawdate));
          $endDate    = mktime(0,0,0,date('m',$enddrawdate)+1, 0, date('Y', $enddrawdate));
          
          if ($endDate > $today) {
            $endDate = $today;
          }
          
      } elseif ($dateType == "YY1YY2") {
          $startDate  = mktime(0,0,0,1,1,date('Y',$startdrawdate));
          $endDate    = mktime(0,0,0,12,31,date('Y',$enddrawdate));     
          
          if ($endDate > $today) {
            $endDate = $today;
          }   
      }
      
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }

      $game_draw_sch = array();
      $db_data = $this->db_obj->fetch($ssql);
      $objGnDate = new GenDates();
      //print "StDt: " . date('Y-m-d',$startDate) . " -> EdDt: " . date('Y-m-d',$endDate) . "\n";
      
      if (is_array($db_data)) {
        $db_row = $db_data[0];
        if ($db_row["iWedSat"] == 1) {
          $game_draw_sch["iWedSat"] = 1;
          
          if  ($dateType == "DD") {
            $dtes_list[0] = $objGnDate->getNextWedSat(date('d-m-Y',$startDate));
          } else { 
            $dtes_list = $objGnDate->getAllWedSat(date('d-m-Y',$startDate), date('d-m-Y',$endDate)); 
          }
          
        } else {
 
          if ($db_row["iMon"] == 1) {
            $game_draw_sch["iMon"] = 1;
          }
          
          if ($db_row["iTue"] == 1) {
            $game_draw_sch["iTue"] = 1;
          }
          
          if ($db_row["iWed"] == 1) {
            $game_draw_sch["iWed"] = 1;
            if ($dateType == "DD") {
              $dtes_list[0] = $objGnDate->getNextWed(date('d-m-Y',$startDate));
            } else {
              $dtes_list = $objGnDate->getAllWednesdays(date('d-m-Y',$startDate), date('d-m-Y',$endDate));
            }
          }
        
          if ($db_row["iThu"] == 1) {
            $game_draw_sch["iThu"] = 1;
          }
        
          if ($db_row["iFri"] == 1) {
            $game_draw_sch["iFri"] = 1;
             if ($dateType == "DD") {
               $dtes_list[0] = $objGnDate->getNextFri(date('d-m-Y',$startDate));
             } else {
               $dtes_list = $objGnDate->getAllFridays(date('d-m-Y',$startDate), date('d-m-Y',$endDate));
             }
          }
        
          if ($db_row["iSat"] == 1) {
            $game_draw_sch["iSat"] = 1;
            if ($dateType == "DD") {
              $dtes_list[0] = $objGnDate->getNextSat(date('d-m-Y',$startDate));        
           } else {
              $dtes_list = $objGnDate->getAllSaturdays(date('d-m-Y',$startDate), date('d-m-Y',$endDate)); 
           }
          }
        
          if ($db_row["iSun"]) {
            $game_draw_sch["iSun"] = 1;
          }
          
         if ($db_row["iDaily"] == 1) {
            $game_draw_sch["iDaily"] = 1;
            $dtes_list = $objGnDate->getAllDays(date('d-m-Y',$startDate), date('d-m-Y',$endDate));
            //print "-- Daily Game --";
            //print_r($dtes_list);
          }
        }        
      }
       print_r($dtes_list);   
       print "--- final test -- ";
        print_r($dtes_list);
      return $dtes_list;
    }
    
    /*
     * gameid
     * gamecode
     * 
     */     
         
    function dbLotteryGamesGetTableName($gamecode, $gameid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE gamecode = '%s'", $gamecode);
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
        return $db_data[0];
      } else {
        return null;
      }
    
      
    }
  
    /*
     * gameid
     * gamecode
     * 
     */     
         
    function dbLotteryGamesGetRegion($gamecode, $gameid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE gamecode = '%s'", $gamecode);
      $db_data = $this->db_obj->fetch($ssql);
      if (is_array($db_data)) {
        return $db_data[0];
      } else {
        return null;
      }
      
    
      
    }

    
  
    
    /*
     * gameid
     * gamecode
     * 
     */     
         
    function dbLotteryGamesGetSched($gamecode, $gameid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE gamecode = '%s'", $gamecode);
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
        return $db_data[0];
      
      } else {
        return null;
      }
    
      
    }
  
    /*
     * gameid
     * gamecode
     * 
     */     
         
    
    function dbLotteryGamesGet($gamecode, $gameid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE gamecode = '%s'", $gamecode);
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
        return $db_data[0];
      } else {
        return null;
      }
    }
 
    /*
     * gameid
     * gamecode
     * 
     */     
         
    
    function dbLotteryGamesGetId($gamecode) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE gamecode = '%s'", $gamecode);
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
        return $db_data[0]["gameid"];
      } else {
        return null;
      }
    }


    function dbLotteryGamesGetIdByDesc($gamedesc) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE gamedesc = '%s'", $gamedesc);
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
        return $db_data[0]["gameid"];
      } else {
        return null;
      }
    }    
    /*
     * gameid
     * gamecode
     * 
     */     
         
    function dbLotteryGamesStartDate($gamecode, $gameid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE gamecode = '%s'", $gamecode);
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
        return $db_data[0];
      } else {
        return null;
      }
    
      
    }  
      
    /*
     * gameid
     * gamecode
     * 
     */     
         
    function dbLotteryGamesNextDrawDate($gamecode, $gameid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE gamecode = '%s'", $gamecode);
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
        return $db_data[0];
      } else {
        return null;
      }
      
    
      
    }
      
    /*
     * gameid
     * gamecode
     * 
     */     
         
    function dbLotteryGamesEndDate($gamecode, $gameid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_lottery_games` WHERE gamecode = '%s'", $gamecode);
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
        return $db_data[0];
      } else {
        return null;
      }
    
      
    }
    /*
     * gameid
     * gamecode
     * 
     */     
         
    function dbLotteryGamesRemove($gamecode, $gameid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("DELETE FROM `tbl_lottery_games` WHERE `gamecode` = '%s' ", $gamecode);
      
      if ($gameid != "") {
        $ssql .= sprintf(" AND gameid = %u", $gameid);
      }
      
      $this->db_obj->exec($ssql);
      
      return $this->db_obj->rows_affected;
          
    }
    
    
    
    /*
     * `gamecode`
     * `gamedesc`
     * `drawstartdate`
     * `drawenddate`
     * `drawSchedule`
     * `db_table_name`
     * `iMon`
     * `iTue`
     * `iWed`
     * `iThu`
     * `iFri`
     * `iSat`
     * `iSun`
     * `iWeekly`
     * `iBiWeekly`
     * `iMonthly`
     * `region`
     * 
     * `gameid`
     * 
     */
     
     function dbLotteryGamesModify($gamecode, $gameid, $gamedesc, $drawstartdate, $drawenddate, $drawSchedule, $db_table_name, 
     $iMon, $iTue, $iWed, $iThu, $iFri, $iSat, $iSun, $iWeekly, $iBiWeekly, $iMonthly, $region) {
       
       if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE `tbl_lottery_games` SET ");
      $ssql .= sprintf(" gamecode = '%s', gamedesc = '%s', drawstartdate = '%s', drawenddate = '%s', drawSchedule = '%s', db_table_name = '%s'", $gamecode, $gamedesc, $drawstartdate, $drawenddate, $drawSchedule, $db_table_name);
      
      $ssql .= sprintf(" , iMon = %u, iTue = %u, iWed = %u, iThu = %u, iFri = %u, iSat = %u, iSun = %u, iWeekly = %u, iBiWeekly = %u, iMonthly = %u, region = '%s' ", $iMon, $iTue, $iWed, $iThu, $iFri, $iSat, $iSun, $iWeekly, $iBiWeekly, $iMonthly, $region );
      
      $this->db_obj->exec($ssql); 
      return $this->db_obj->rows_affected;
      
     }
     
     
     function dbLotteryGamesModSched($gamecode, $gameid = "", $iMon = "", $iTue = "", $iWed = "", $iThu = "", $iFri = "", $iSat = "", $iSun = "") {
       if (!$this->db_obj) {
        $this->db_obj = new db();
       
       }
       
      $ssql = sprintf("UPDATE `tbl_lottery_games` SET ");
      $ssql .= sprintf(" iMon = %u, iTue = %u, iWed = %u, iThu = %u, iFri = %u, iSat = %u, iSun = %u", $iMon, $iTue, $iWed, $iThu, $iFri, $iSat, $iSun);
      
      $this->db_obj->exec($ssql); 
      return $this->db_obj->rows_affected;      
     }
     
     
     
  }


?>