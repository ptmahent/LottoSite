
<?php


  include_once("class_db.php");
  class OLGLottery {
    

    
     var $db_obj;
     var $vstr = 0;
     var $vnum = 1;
     
     var $olg49V;
    
      // Debug Mode
    // 0 = verbose disabled
    // 1 = verbose enabled
    // 2 = verbose extra info
    
    
    //var $debug_mode         = 2;
     
     
     
     
     /*
      * 
      * 
      *     INSERT INTO `dbaLotteries`.`tbl_on_winners_1000_more`
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
`win_group_id`,
`str_address`,
`win_list_date`,
`win_list_pos`)
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
{win_group_id: INT},
{str_address: VARCHAR},
{win_list_date: DATETIME},
{win_list_pos: INT}
);
INSERT INTO `dbaLotteries`.`tbl_on_winning_group`
(`winning_group_id`,
`drawdate`,
`listdate`,
`win_prize`,
`member_cnt`)
VALUES
(
{winning_group_id: INT},
{drawdate: DATETIME},
{listdate: DATETIME},
{win_prize: DOUBLE},
{member_cnt: INT}
);
      *     */
     
     
     function dbOLGWinGroupAdd($drawdate, $listdate, $win_prize, $member_cnt, $win_list_pos, $win_list_group_pos)
     {
            
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       
        $ssql = sprintf("INSERT INTO `tbl_on_winning_group` (`drawdate`,`listdate`,`win_prize`,`member_cnt`,`win_list_pos`, `win_list_group_pos`) ");
        $ssql .= sprintf(" VALUES('%s','%s',%u,%u,%u, %u)", $drawdate, $listdate, $win_prize, $member_cnt, $win_list_pos, $win_list_group_pos);
        //print "\n" . $ssql;
        $rows_affect = $this->db_obj->exec($ssql);
        return $this->db_obj->last_id;
     }
     
     function dbOLGWinGroupRemove($win_group_id) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       $ssql = sprintf("DELETE FROM `tbl_on_winning_group` WHERE winning_group_id = %u", $win_group_id);
       $this->db_obj->exec($ssql);
       return $this->db_obj->rows_affected;
     }
     
     function dbOLGWinGroupModify($win_group_id, $drawdate, $listdate, $win_prize, $member_cnt, $win_list_pos) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $ssql = sprintf("UPDATE `tbl_on_winning_group` SET ");
        $ssql .= sprintf(" drawdate = '%s', listdate = '%s', win_prize = %f, member_cnt = %u, win_list_pos = %u", $drawdate, $listdate, $win_prize, $member_cnt, $win_list_pos);
        $ssql .= sprintf(" WHERE winning_group_id = %u", $win_group_id);
        
        $this->db_obj->exec($ssql);
        return $this->db_obj->rows_affected;
        
     }

     function dbOLGWinGroupGetId($win_list_date, $iGroupPos) {
       
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       
       $ssql = sprintf("SELECT * FROM `tbl_on_winning_group` WHERE listdate = '%s' AND win_list_group_pos = %u", $win_list_date, $iGroupPos);
       $db_result = $this->db_obj->fetch($ssql);
       if (is_array($db_result)) {
         return $db_result[0]["winning_group_id"];
       } else {
         return null;
       }
     }

     function dbOLGWinGroupGet($win_list_date, $iGroupPos) {
       
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       
       $ssql = sprintf("SELECT * FROM `tbl_on_winning_group` WHERE listdate = '%s' AND win_list_group_pos = %u", $win_list_date, $iGroupPos);
       $db_result = $this->db_obj->fetch($ssql);
       if (is_array($db_result)) {
         return $db_result[0];
       } else {
         return null;
       }
     }     
   


     
     function dbOLGWinGroupMemberCnt($win_group_id, $member_cnt) {
       if (!$this->db_obj) {
         $this->db_obj = new db();
       }
       $ssql = sprintf("UPDATE `tbl_on_winning_group` SET ");
       $ssql .= sprintf(" member_cnt = %u WHERE winning_group_id = %u", $member_cnt, $win_group_id);
       
       $this->db_obj->exec($ssql);
       return $this->db_obj->rows_affected;
     }
     /*
      * winning_id  int(11)     No  None  AUTO_INCREMENT              
  str_first_name  varchar(255)  utf8_general_ci   Yes NULL                 
  str_last_name varchar(255)  utf8_general_ci   Yes NULL                 
  win_city_id int(11)     Yes NULL                
  win_prov_id int(11)     Yes NULL                
  lotto_game_id int(11)     Yes NULL                
  win_draw_date datetime      Yes NULL                
  is_multiple_draw  int(11)     Yes NULL                
  win_prize_amt double      Yes NULL                
  is_insider  int(11)     Yes NULL                
  is_group  int(11)     Yes NULL                
  win_group_id  int(11)     Yes NULL                
  str_address varchar(255)  utf8_general_ci   Yes NULL                 
  win_list_date datetime      Yes NULL                
  win_list_pos  int(11)     Yes NULL                
  strInstantWin varchar(45) utf8_general_ci   No  None                 
  iGameNo int(11)     
      * 
      * 
      (`str_first_name`,`str_last_name`,`win_city`,`win_prov`,`str_lotto_game`,`str_draw_date`,`str_multiple_draw`,`str_prize`,`str_insider`,
      `str_group`,`win_group_id`,`str_address`,`win_list_date`,`win_list_pos`, `strInstantWin`, `iGameNo`)
      * 
      * 
      * 
      */ 
     
     
     
     
     
     function dbOLGWinnerAdd($str_first_name,$str_last_name,$win_city,$win_prov,$str_lotto_game,$str_draw_date,$str_multiple_draw,$str_prize,$str_insider,$str_group,$win_group_id,$str_address,$win_list_date,$win_list_pos, $strInstantWin,$instGameNo)
      {
            
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("INSERT INTO `tbl_on_winners_1000_more` (`str_first_name`,`str_last_name`,`win_city_id`,`win_prov_id`,`lotto_game_id`,`win_draw_date`,`is_multiple_draw`,`win_prize_amt`,`is_insider`,
                        `is_group`,`win_group_id`,`str_address`,`win_list_date`,`win_list_pos`, `strInstantWin`, `iGameNo`)");
        $ssql .= sprintf(" VALUES('%s', '%s', %u, %u, %u, '%s',%u, %u, %u, %u, %u, '%s', '%s', %u, '%s', %u )", 
                $str_first_name,$str_last_name,$win_city,$win_prov,$str_lotto_game,$str_draw_date,$str_multiple_draw,$str_prize,$str_insider,$str_group,
                                                                                                                  $win_group_id,$str_address,$win_list_date,$win_list_pos, $strInstantWin, $instGameNo); 
        //print "\n" . $ssql;
        $rows_affect = $this->db_obj->exec($ssql);
        
        return $this->db_obj->last_id;
      
      }     
      
      function dbOLGWinnerRemove($winning_id ) {
        
          
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("DELETE FROM `tbl_on_winners_1000_more` WHERE winning_id = %u", $winning_id);
        $this->db_obj->exec($ssql);
        return $this->db_obj->rows_affected;
      }
      
      function dbOLGWinnerModify($winning_id, $str_first_name,$str_last_name,$win_city,$win_prov,$str_lotto_game,$str_draw_date,$str_multiple_draw,$str_prize,$str_insider,$str_group,$win_group_id,$str_address,$win_list_date,$win_list_pos)
      {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("UPDATE `tbl_on_winners_1000_more` SET ");
        $ssql .= sprintf(" `str_first_name` = '%s',`str_last_name` = '%s', `win_city` = %u, `win_prov` = %u," , $str_first_name, $str_last_name, $win_city, $win_prov);
        $ssql .= sprintf(" `str_lotto_game` = '%s',`str_draw_date` = '%s', `str_multiple_draw` = '%s',`str_prize` = %f,", $str_lotto_game, $str_draw_date, $str_multiple_draw, $str_prize);
        $ssql .= sprintf(" `str_insider` = '%s', `str_group` = '%s',`win_group_id` = %u,`str_address` = '%s',`win_list_date` = '%s',`win_list_pos` = %u", $str_insider, $str_group, $win_group_id, $str_address, $win_list_date, $win_list_pos);
        $ssql .= sprintf(" WHERE winning_id = %u", $winning_id);

        $this->db_obj->exec($ssql);     
        return $this->db_obj->rows_affected;     
      }
      function dbOLGWinnerGetId($win_list_date, $win_list_pos) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_on_winners_1000_more` WHERE win_list_date = '%s' AND win_list_pos = %u", $win_list_date, $win_list_pos );
        
        $db_result = $this->db_obj->fetch($ssql);
        if (is_array($db_result)) {
          return $db_result[0]["winning_id"];
        } else {
          return null;
        }
      }
      
      function dbOLGWinnerGet($win_list_date, $win_list_pos) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_on_winners_1000_more` WHERE win_list_date = '%s' AND win_list_pos = %u", $win_list_date, $win_list_pos );
        
        $db_result = $this->db_obj->fetch($ssql);
        if (is_array($db_result)) {
          return $db_result[0];
        } else {
          return null;
        }
      }
      
     
     /* 
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
      * 
      * 
      *   Field Type  Collation Attributes  Null  Default Extra Action
  winninglocid  int(11)     No  None  AUTO_INCREMENT              
  str_store_name  varchar(255)  utf8_general_ci   Yes NULL                 
  str_store_addr  varchar(255)  utf8_general_ci   Yes NULL                 
  iLottoGame  int(45)     Yes NULL                
  str_draw_date datetime      Yes NULL                
  winning_amount  bigint(20)      Yes NULL                
  str_postal_code varchar(7)  utf8_general_ci   Yes NULL                 
  iCity int(11)     Yes NULL                
  lotto_game_id int(11)     Yes NULL                
  iGameNo int(11)     No  None                
  strGameNo varchar(20) utf8_general_ci   No  None                 
  iProv int(11) 
     * 
     */ 
     
      
     function dbOnWinningLocation($win_loc_id, $str_store_name, $str_store_addr, $iLottoGame, $str_draw_date, 
          $winning_amount, $str_postal_code, $iCity, $lotto_game_id, $iGameNo, $strGameNo, $iProv){
       
     }
     
     function dbOnWinningLocationAdd($iRowId, $str_store_name, $str_store_addr, $iLottoGameId, $str_draw_date, 
          $winning_amount, $str_postal_code, $iCity, $iInstGameNo, $strGameNo, $iProv) {
       
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        
        $iRowId           = mysql_real_escape_string($iRowId);
        $str_store_name   = mysql_real_escape_string($str_store_name);
        $str_store_addr   = mysql_real_escape_string($str_store_addr);
        $iLottoGameId     = mysql_real_escape_string($iLottoGameId);
        $str_draw_date    = mysql_real_escape_string($str_draw_date);
        $winning_amount   = mysql_real_escape_string($winning_amount);
        $str_postal_code  = mysql_real_escape_string($str_postal_code);
        $iCity            = mysql_real_escape_string($iCity);
        $iInstGameNo      = mysql_real_escape_string($iInstGameNo);
        $strGameNo        = mysql_real_escape_string($strGameNo);
        $iProv            = mysql_real_escape_string($iProv);
        $ssql = sprintf("INSERT INTO `tbl_on_winning_locations` (`iRowId`, `str_store_name`, `str_store_addr`, `iLottoGameId`, 
              `str_draw_date`, `winning_amount`, `str_postal_code`, `iCity`, `iInstGameNo`, `strGameNo`, `iProv`) ");
  
        $ssql .= sprintf(" VALUES(%u, '%s', '%s', %u, '%s', 
                  %u, '%s', %u, %u, '%s', %u)", $iRowId, $str_store_name, $str_store_addr, $iLottoGameId, $str_draw_date, 
                  $winning_amount, $str_postal_code, $iCity,  $iInstGameNo, $strGameNo, $iProv);
         //print "\n" . $ssql;
        $rows_affect = $this->db_obj->exec($ssql);
        return $this->db_obj->last_id;
     }
     
     function dbOnWinningLocationRemove($win_loc_id) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       
       $ssql = sprintf("DELETE FROM `tbl_on_winning_locations` ");
       $ssql .= sprintf(" WHERE winninglocid = %u", $win_loc_id);
       
       $this->db_obj->exec($ssql);
       return $this->db_obj->rows_affected;
       
     }
     
     function dbOnWinningLocationModify($win_loc_id, $str_store_name, $str_store_addr, $iLottoGame, $str_draw_date, 
          $winning_amount, $str_postal_code, $iCity, $lotto_game_id, $iInstGameNo, $strGameNo, $iProv) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $ssql = sprintf("UPDATE `tbl_on_winning_locations` SET ");
        $ssql .= sprintf(" `iRowId` = %u, `str_store_name` = '%s', `str_store_addr` = '%s', `iLottoGame` = %u, 
              `str_draw_date` = '%s', `winning_amount` = %u, `str_postal_code` = '%s', `iCity` = %u, `lotto_game_id` = %u, `iInstGameNo` = %u, `strGameNo` = '%s', `iProv` = %u", $iRowId, $str_store_name, $str_store_addr, $iLottoGame, $str_draw_date, 
                  $winning_amount, $str_postal_code, $iCity, $lotto_game_id, $iGameNo, $strGameNo, $iProv);
        $ssql .= sprintf(" WHERE winninglocid = %u", $win_loc_id);
        
        $this->db_obj->exec($ssql);
        return $this->db_obj->rows_affected;
         
      } 
     
     function dbOnWinningLocationGet($win_loc_id) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $ssql = sprintf("SELECT * FROM `tbl_on_winning_locations` WHERE winninglocid = %u", $win_loc_id);
        $db_result = $this->db_obj->fetch($ssql);
        if (is_array($db_result)) {
          return $db_result[0];
        }
     }
     
      function dbOnWinningLocationGetId($loc_street_addr, $gameId, $drawdate = "", $instGameNo = "", $strGameNo = "") {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $loc_street_addr  = mysql_real_escape_string($loc_street_addr);
        $gameId           = mysql_real_escape_string($gameId);
        $drawdate         = mysql_real_escape_string($drawdate);
        $instGameNo       = mysql_real_escape_string($instGameNo);
        $strGameNo        = mysql_real_escape_string($strGameNo);
        
        
        $ssql = sprintf("SELECT * FROM `tbl_on_winning_locations` WHERE 
            `str_store_addr` = '%s' AND `iLottoGameId` = %u AND (`str_draw_date` = '%s' OR iInstGameNo = %u OR strGameNo = '%s')", 
            $loc_street_addr, $gameId, $drawdate, $instGameNo, $strGameNo);
            //print "\n" . $ssql;
        $db_result = $this->db_obj->fetch($ssql);
        if (is_array($db_result)) {
          return $db_result[0];
        } else {
          return null;
        }
     }
         /*
     * 
     * Ontario 49
     * 
     * drawdate
     * idrawnum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snumbonus
     * 
     * return: on49id
     * 
     * 
     * 
     */
     
    function OLG49Add($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, $drawNo, $sdrawDate, $spielID) {
      
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_on_49` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snumbonus` ");
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo`, `sdrawDate`, `spielID`) ");
      } else {
        $ssql .= sprintf(") ");
      }
      
      $ssql .= sprintf(" VALUES( %u, '%s',%u,%u,%u,%u,%u,%u,%u", $idrawnum, $drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus);
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,%u, %u, %u) ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(") ");
      }
      $rows_affect = $this->db_obj->exec($ssql);    
      return $this->db_obj->last_id;  
    }
    
    /*
     * drawdate
     * on49id
     * 
     * 
     */ 
    
    
    function OLG49Remove($drawdate, $on49id = "") {
      
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_on_49` WHERE ");
      $ssql .= sprintf(" drawdate = '%s' ", $drawdate);
      if ($on49id != "") {
        $ssql .= sprintf(" AND on49id = %u", $on49id);
      }
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
             /*
     * 
     * Ontario 49
     * 
     * drawdate
     * idrawnum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snumbonus
     * 
     * return: on49id
     * 
     * 
     * 
     */
     
    function OLG49Modify($olddrawdate, $newdrawdate, $drawdate = "", $on49id = "", $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, $drawNo, $sdrawDate, $spielID) {
         
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE `tbl_on_49` SET ");
      $ssql .= sprintf("`idrawnum` = %u, `drawdate` = '%s',`snum1` = %u,`snum2` = %u,`snum3` = %u,`snum4` = %u,`snum5` = %u,`snum6` = %u,`snumbonus` = %u WHERE ",$idrawnum, $newdrawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus);
       if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo` = %u, `sdrawDate` = %u, `spielID` = %u ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(") ");
      }

      $ssql .= sprintf(" drawdate = '%s'", $olddrawdate);
      if ($on49id != "") {
        $ssql .= sprintf(" AND on49id = %u", $on49id);
      }    
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    /*
     * $drawdate
     * $on49id
     * 
     */ 
    
    
    function OLG49GetSingleDraw($drawdate, $on49id = "") {
         
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_49` WHERE ");
      $ssql .= sprintf(" drawdate = '%s'", $drawdate);
      if ($on49id != "") {
        $ssql .= sprintf(" AND on49id = %u", $on49id);
      }
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
    }
    
    
    function OLG49GetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_on_49`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_on_49`");
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        $data_avail["latest"] = $db_res[0]["LatestDate"];
      }
      if (is_array($db_res)) {
        return $data_avail;
      } else {
        return null;
      }
    }
    
    function OLG49GetDraw($st_drawdate, $ed_drawdate, $st_pos = 0, $limit = 350) {
       if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT * FROM `tbl_on_49` WHERE drawdate >= '%s' AND drawdate <= '%s'",
                      $st_drawdate, $ed_drawdate);
      $ssql .= sprintf(" order by drawdate");
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res;
      } else {
        return null;
      }
      
    }
    
     function OLG49GetDrawId($drawdate) {
         
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_49` WHERE ");
      $ssql .= sprintf(" drawdate = '%s'", $drawdate);
     
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0]["on49id"];
      } else {
        return null;
      }
    }
    /*
     * 
     * Ontario 49
     * 
     * drawdate
     * idrawnum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snumbonus
     * 
     * return: on49id
     * 
     * 
     * 
     */
      
    function OLG49ValidateDraw($st_drawdate, $ed_drawdate = "", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6) {
           
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT `on49winningid`, on_49.*, `m_6_count`, `m_6_amount`, 
                (SELECT prze_amount as m_6_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_6_amount) AS m_6_prze_amt,
                `m_6_region`, `m_5_b_count`, `m_5_b_amount`, 
                (SELECT prze_amount as m_5_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_5_b_amount)  AS m_5_b_prze_amt,
                `m_5_b_region`, `m_5_count`, `m_5_amount`, 
                (SELECT prze_amount as m_5_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_5_amount)  AS m_5_prze_amt, 
                `m_4_count`, `m_4_amount`, 
                (SELECT prze_amount as m_4_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_4_amount)  AS m_4_prze_amt, 
                `m_3_count`, `m_3_amount`, 
                (SELECT prze_amount as m_3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_3_amount)  AS m_3_prze_amt
                FROM `tbl_on_49_winnings` as 49_winning,  `tbl_on_49` as on_49 WHERE 
                49_winning.on49id = on_49.on49id AND on_49.drawdate >= '%s' AND on_49.drawdate <= '%s'",
                $st_drawdate, $ed_drawdate);
      $ssql .= sprintf(" order by on_49.drawdate");
      $db_data = $this->db_obj->fetch($ssql);
      
      
      $imatch_cnt     = 0;
      $ibonus_match   = 0;
      $irow_cnt       = 0;
      $smatch_wins    = null;
      
      $scomb_num      = array(
                        $snum1, $snum2, $snum3, $snum4, $snum5, $snum6);
      //print_r($db_data);
      //print "SQL: " . $ssql;    
      sort($scomb_num, SORT_ASC);
      $scomb_num      = array_unique($scomb_num);
      //print "Sorted Numbers: ";
      //print_r($scomb_num);
      if (count($scomb_num) < 6) {
        // user entered some duplicate numbers
      } else {
        
        if (is_array($db_data)) {
            $smatch_wins      = array();
            
          
            foreach ($db_data as $db_row) {
                $imatch_cnt                 = 0;
                $ibonus_match               = 0;
                $smatch_wins[$irow_cnt]     = array(
                    "drawdate"        => $db_row["drawdate"],
                    "match_cnt"       => 0,
                    "match_numbers"   => array(),
                    "match_bonus"     => 0,
                    "match_bonus_num" => 0
                );
                  
                $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_row["snum1"], $db_row["snum2"], $db_row["snum3"],
                                                                $db_row["snum4"], $db_row["snum5"], $db_row["snum6"]);
                                                                
                $smatch_wins[$irow_cnt]["draw_bonus"]   = $db_row["snumbonus"];
                
              
                if ($db_row["snum1"] == $scomb_num[0] || $db_row["snum1"] == $scomb_num[1] || $db_row["snum1"] == $scomb_num[2] || $db_row["snum1"] == $scomb_num[3] || $db_row["snum1"] == $scomb_num[4] || $db_row["snum1"] == $scomb_num[5] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt]   = $db_row["snum1"];
                  $imatch_cnt++;
                } 
                if ($db_row["snum2"] == $scomb_num[0] || $db_row["snum2"] == $scomb_num[1] || $db_row["snum2"] == $scomb_num[2] || $db_row["snum2"] == $scomb_num[3] || $db_row["snum2"] == $scomb_num[4] || $db_row["snum2"] == $scomb_num[5] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt]   = $db_row["snum2"];
                  $imatch_cnt++;
                } 
                if ($db_row["snum3"] == $scomb_num[0] || $db_row["snum3"] == $scomb_num[1] || $db_row["snum3"] == $scomb_num[2] || $db_row["snum3"] == $scomb_num[3] || $db_row["snum3"] == $scomb_num[4] || $db_row["snum3"] == $scomb_num[5]  ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt]   = $db_row["snum3"];
                  $imatch_cnt++;
                } 
                if ($db_row["snum4"] == $scomb_num[0] || $db_row["snum4"] == $scomb_num[1] || $db_row["snum4"] == $scomb_num[2] || $db_row["snum4"] == $scomb_num[3] || $db_row["snum4"] == $scomb_num[4] || $db_row["snum4"] == $scomb_num[5] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt]   = $db_row["snum4"];
                  $imatch_cnt++;
                } 
                if ($db_row["snum5"] == $scomb_num[0] || $db_row["snum5"] == $scomb_num[1] || $db_row["snum5"] == $scomb_num[2] || $db_row["snum5"] == $scomb_num[3] || $db_row["snum5"] == $scomb_num[4] || $db_row["snum5"] == $scomb_num[5]  ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt]   = $db_row["snum5"];
                  $imatch_cnt++;
                } 
                if ($db_row["snum6"] == $scomb_num[0] || $db_row["snum6"] == $scomb_num[1] || $db_row["snum6"] == $scomb_num[2] || $db_row["snum6"] == $scomb_num[3] || $db_row["snum6"] == $scomb_num[4] || $db_row["snum6"] == $scomb_num[5]  ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt]   = $db_row["snum6"];
                  $imatch_cnt++;
                } 
                if ($db_row["snumbonus"] == $scomb_num[0] || $db_row["snumbonus"] == $scomb_num[1] || $db_row["snumbonus"] == $scomb_num[2] || $db_row["snumbonus"] == $scomb_num[3] || $db_row["snumbonus"] == $scomb_num[4] || $db_row["snumbonus"] == $scomb_num[5] ) {
                  $smatch_wins[$irow_cnt]["match_bonus_num"] = $db_row["snumbonus"];
                  $smatch_wins[$irow_cnt]["match_bonus"]                  = 1;
                }
                
                
                // 
                
                if ($imatch_cnt == 6) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_6_prze_amt"];
                } elseif ($imatch_cnt == 5 && $ibonus_match == 1) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_b_prze_amt"];
                } elseif ($imatch_cnt == 5) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_prze_amt"];
                  
                } elseif ($imatch_cnt == 4) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_4_prze_amt"];
                } elseif ($imatch_cnt == 3) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_3_prze_amt"];
                }  
                $irow_cnt++;
            }
          
          
        }
    }
  
  
  if (is_array($smatch_wins)) {
    return $smatch_wins;
  } else {
    return null;
  }


}
    
      /*
     * 
     * Ontario 49
     * 
     * drawdate
     * idrawnum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snumbonus
     * 
     * return: on49id
     * 
     * 
     * 
     */
     
    function OLG49Validate($startdrawdate, $enddrawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6) {
           
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
        
      $ssql = sprintf("SELECT * FROM `tbl_on_49` WHERE ");
      $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s'", $startdrawdate, $enddrawdate);
      
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
        foreach ($db_data as $db_row) {
          if ($db_row["snum1"] == $snum1 || $db_row["snum1"] == $snum2 || $db_row["snum1"] == $snum3 || $db_row["snum1"] == $snum4 || $db_row["snum1"] == $snum5 || $db_row["snum1"] == $snum6 ) {
            
          } 
          if ($db_row["snum2"] == $snum1 || $db_row["snum2"] == $snum2 || $db_row["snum2"] == $snum3 || $db_row["snum2"] == $snum4 || $db_row["snum2"] == $snum5 || $db_row["snum2"] == $snum6 ) {
            
          } 
          if ($db_row["snum3"] == $snum1 || $db_row["snum3"] == $snum2 || $db_row["snum3"] == $snum3 || $db_row["snum3"] == $snum4 || $db_row["snum3"] == $snum5 || $db_row["snum3"] == $snum6  ) {
            
          } 
          if ($db_row["snum4"] == $snum1 || $db_row["snum4"] == $snum2 || $db_row["snum4"] == $snum3 || $db_row["snum4"] == $snum4 || $db_row["snum4"] == $snum5 || $db_row["snum4"] == $snum6 ) {
            
          } 
          if ($db_row["snum5"] == $snum1 || $db_row["snum5"] == $snum2 || $db_row["snum5"] == $snum3 || $db_row["snum5"] == $snum4 || $db_row["snum5"] == $snum5 || $db_row["snum5"] == $snum6  ) {
            
          } 
          if ($db_row["snum6"] == $snum1 || $db_row["snum6"] == $snum2 || $db_row["snum6"] == $snum3 || $db_row["snum6"] == $snum4 || $db_row["snum6"] == $snum5 || $db_row["snum6"] == $snum6  ) {
            
          } 
          if ($db_row["snumbonus"] == $snum1 || $db_row["snumbonus"] == $snum2 || $db_row["snumbonus"] == $snum3 || $db_row["snumbonus"] == $snum4 || $db_row["snumbonus"] == $snum5 || $db_row["snumbonus"] == $snum6 ) {
            
          }   
   
        }
      }      
    }
    
    function OLG49GetMonth() {
      
    }
    function OLG49GetYear() {
      
    }
    function OLG49GetAll() {
      
    }
    
 /*
    * drawdate
    * idrawnum
    * snum1
    * snum2
    * snum3
    * snum4
    * snum5
    * snum6
    * snum7
    * snum8
    * snum9
    * snum10
    * snum11
    * snum12
    * snum13
    * snum14
    * snum15
    * snum16
    * snum17
    * snum18
    * snum19
    * snum20
    * 
    * 
    * return: onkenoid
    * 
    */
  
    
    function OLGKenoAdd($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10, $snum11, $snum12, $snum13, $snum14, $snum15, $snum16, $snum17, $snum18, $snum19, $snum20, $drawNo, $sdrawDate, $spielID) {
         
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_on_keno` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snum7`,`snum8`,`snum9`,`snum10`,`snum11`,`snum12`,`snum13`,`snum14`,`snum15`,`snum16`,`snum17`,`snum18`,`snum19`,`snum20` ");
       if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo`, `sdrawDate`, `spielID`) ");
      } else {
        $ssql .= sprintf(") ");
      }
      
      
      $ssql .= sprintf(" VALUES(%u,'%s',%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u",$idrawnum, $drawdate,  $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10, $snum11, $snum12, $snum13, $snum14, $snum15, $snum16, $snum17, $snum18, $snum19, $snum20);
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,%u, %u, %u) ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(") ");
      }
      $rows_affected = $this->db_obj->exec($ssql);
      
      return $this->db_obj->last_id;      
    }
    
    
    /*
     * $drawdate
     * $onkenoid
     * 
     * 
     * 
     */
      
    function OLGKenoRemove($drawdate, $onkenoid) {
         
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_on_keno` WHERE ");
      $ssql .= sprintf(" drawdate = '%s' ", $drawdate);
      
      if ($onkenoid != "") {
        $ssql .= sprintf(" AND onkenoid = %u", $onkenoid);
      }
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;    
    }
    
       
 /*
    * drawdate
    * idrawnum
    * snum1
    * snum2
    * snum3
    * snum4
    * snum5
    * snum6
    * snum7
    * snum8
    * snum9
    * snum10
    * snum11
    * snum12
    * snum13
    * snum14
    * snum15
    * snum16
    * snum17
    * snum18
    * snum19
    * snum20
    * 
    * 
    * return: onkenoid
    * 
    */
  
    function OLGKenoModify($olddrawdate, $newdrawdate, $drawdate = "", $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10, $snum11, $snum12, $snum13, $snum14, $snum15, $snum16, $snum17, $snum18, $snum19, $snum20, $drawNo, $sdrawDate, $spielID) {
         
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf(" UPDATE `tbl_on_keno` SET `idrawnum` = %u, ", $idrawnum);

      $ssql .= sprintf("`drawdate` = '%s',`snum1` = %u,`snum2` = %u,`snum3` = %u,`snum4` = %u,`snum5` = %u,`snum6` = %u,`snum7` = %u,`snum8` = %u,`snum9` = %u,`snum10` = %u,`snum11` = %u,`snum12` = %u,`snum13` = %u,`snum14` = %u,`snum15` = %u,`snum16` = %u,`snum17` = %u,`snum18` = %u,`snum19` = %u,`snum20` = %u ", $drawdate,  $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10, $snum11, $snum12, $snum13, $snum14, $snum15, $snum16, $snum17, $snum18, $snum19, $snum20);
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo` = %u, `sdrawDate` = %u, `spielID` = %u ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(" ");
      }
      $ssql .= sprintf(" WHERE drawdate = '%s'", $olddrawdate);
      
      $this->db_obj->exec($ssql);     
     
      return $this->db_obj->rows_affected;
      
    }
    
    /*
     * drawdate
     * onkenoid
     * 
     * 
     */ 
    
    
    function OLGKenoGetSingleDraw($drawdate) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf(" SELECT * FROM `tbl_on_keno` WHERE drawdate = '%s' ", $drawdate);
      
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
    }
    
    function OLGKenoGetDraw($st_drawdate, $ed_drawdate, $st_pos = 0, $limit = 350) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT * FROM `tbl_on_keno` WHERE drawdate >= '%s' AND drawdate <= '%s' ",
                    $st_drawdate, $ed_drawdate);
      $ssql .= sprintf(" order by drawdate");              
      $db_res = $this->db_obj->fetch($ssql);
      //print "\nSSQL: " . $ssql;
      if (is_array($db_res)) {
        return $db_res;
      } else {
        return null;
      }      
    }
    
    function OLGKenoGetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_on_keno`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_on_keno`");
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        $data_avail["latest"] = $db_res[0]["LatestDate"];
      }
      if (is_array($db_res)) {
        return $data_avail;
      } else {
        return null;
      }
    }
    
      function OLGKenoGetDrawId($drawdate) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf(" SELECT * FROM `tbl_on_keno` WHERE drawdate = '%s' ", $drawdate);
      
      
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0]["onkenoid"];
      } else {
        return null;
      }
    }
    
    /*
     * drawdate
     * onkenoid
     * category
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snum7
     * snum8
     * snum9
     * snum10
     * 
     */ 
    
    function OLGKenoValidateDraw($st_drawdate, $ed_drawdate, $category, $snum1, $snum2="", $snum3="", $snum4="", $snum5="", $snum6="", $snum7="", $snum8="", $snum9="", $snum10="") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
    $ssql = sprintf("SELECT
       tbl_keno.*,
       `m_10_10_1_count`,`m_10_10_1_amount`,
       (SELECT prze_amount as m_10_10_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_10_10_1_amount) AS m_10_10_1_prze_amt,
       `m_10_9_1_count`,`m_10_9_1_amount`,
       (SELECT prze_amount as m_10_9_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_10_9_1_amount) AS m_10_9_1_prze_amt,
              
       `m_10_8_1_count`,`m_10_8_1_amount`,
       (SELECT prze_amount as m_10_8_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_10_8_1_amount) AS m_10_8_1_prze_amt,
       
       `m_10_7_1_count`,`m_10_7_1_amount`,
       (SELECT prze_amount as m_10_7_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_10_7_1_amount) AS m_10_7_1_prze_amt,
       
       `m_10_0_1_count`,`m_10_0_1_amount`,
       (SELECT prze_amount as m_10_0_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_10_0_1_amount) AS m_10_0_1_prze_amt,
              
       `m_9_9_1_count`,`m_9_9_1_amount`,
       (SELECT prze_amount as m_9_9_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_9_9_1_amount) AS m_9_9_1_prze_amt,
       
       `m_9_8_1_count`,`m_9_8_1_amount`,
       (SELECT prze_amount as m_9_8_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_9_8_1_amount) AS m_9_8_1_prze_amt,

       `m_9_7_1_count`,`m_9_7_1_amount`,
       (SELECT prze_amount as m_9_7_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_9_7_1_amount) AS m_9_7_1_prze_amt,

       `m_9_6_1_count`,`m_9_6_1_amount`,
       (SELECT prze_amount as m_9_6_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_9_6_1_amount) AS m_9_6_1_prze_amt,

       `m_8_8_1_count`,`m_8_8_1_amount`,
       (SELECT prze_amount as m_8_8_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_8_8_1_amount) AS m_8_8_1_prze_amt,

       `m_8_7_1_count`,`m_8_7_1_amount`,
       (SELECT prze_amount as m_8_7_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_8_7_1_amount) AS m_8_7_1_prze_amt,

       `m_8_6_1_count`,`m_8_6_1_amount`,
       (SELECT prze_amount as m_8_6_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_8_6_1_amount) AS m_8_6_1_prze_amt,
       
       `m_7_7_1_count`,`m_7_7_1_amount`,
       (SELECT prze_amount as m_7_7_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_7_7_1_amount) AS m_7_7_1_prze_amt,
       
       `m_7_6_1_count`,`m_7_6_1_amount`,
       (SELECT prze_amount as m_7_6_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_7_6_1_amount) AS m_7_6_1_prze_amt,

       `m_7_5_1_count`,`m_7_5_1_amount`,
       (SELECT prze_amount as m_7_5_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_7_5_1_amount) AS m_7_5_1_prze_amt,

       `m_6_6_1_count`,`m_6_6_1_amount`,
       (SELECT prze_amount as m_6_6_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_6_6_1_amount) AS m_6_6_1_prze_amt,

       `m_6_5_1_count`,`m_6_5_1_amount`,
       (SELECT prze_amount as m_6_5_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_6_5_1_amount) AS m_6_5_1_prze_amt,

       `m_5_5_1_count`,`m_5_5_1_amount`,
       (SELECT prze_amount as m_5_5_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_5_5_1_amount) AS m_5_5_1_prze_amt,

       `m_5_4_1_count`,`m_5_4_1_amount`,
       (SELECT prze_amount as m_5_4_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_5_4_1_amount) AS m_5_4_1_prze_amt,
       
       `m_4_4_1_count`,`m_4_4_1_amount`,
       (SELECT prze_amount as m_4_4_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_4_4_1_amount) AS m_4_4_1_prze_amt,

       `m_3_3_1_count`,`m_3_3_1_amount`,
       (SELECT prze_amount as m_3_3_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_3_3_1_amount) AS m_3_3_1_prze_amt,

       `m_2_2_1_count`,`m_2_2_1_amount`,
       (SELECT prze_amount as m_2_2_1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_keno_win.m_2_2_1_amount) AS m_2_2_1_prze_amt,

       `m_10_10_2_count`,`m_10_9_2_count`,`m_10_8_2_count`,`m_10_7_2_count`,`m_10_0_2_count`,
       `m_9_9_2_count`,`m_9_8_2_count`,`m_9_7_2_count`,`m_9_6_2_count`,
       `m_8_8_2_count`,`m_8_7_2_count`,`m_8_6_2_count`,
       `m_7_7_2_count`,`m_7_6_2_count`,`m_7_5_2_count`,
       `m_6_6_2_count`,`m_6_5_2_count`,
       `m_5_5_2_count`,`m_5_4_2_count`,
       `m_4_4_2_count`,
       `m_3_3_2_count`,
       `m_2_2_2_count`,
       `m_10_10_5_count`,`m_10_9_5_count`,`m_10_8_5_count`,`m_10_7_5_count`,`m_10_0_5_count`,
       `m_9_9_5_count`,`m_9_8_5_count`,`m_9_7_5_count`,`m_9_6_5_count`,
       `m_8_8_5_count`,`m_8_7_5_count`,`m_8_6_5_count`,
       `m_7_7_5_count`,`m_7_6_5_count`,`m_7_5_5_count`,
       `m_6_6_5_count`,`m_6_5_5_count`,
       `m_5_5_5_count`,`m_5_4_5_count`,
       `m_4_4_5_count`,
       `m_3_3_5_count`,
       `m_2_2_5_count`,
       `m_10_10_10_count`,`m_10_9_10_count`,`m_10_8_10_count`,`m_10_7_10_count`,`m_10_0_10_count`,
       `m_9_9_10_count`,`m_9_8_10_count`,`m_9_7_10_count`,`m_9_6_10_count`,
       `m_8_8_10_count`,`m_8_7_10_count`,`m_8_6_10_count`,
       `m_7_7_10_count`,`m_7_6_10_count`,`m_7_5_10_count`,
       `m_6_6_10_count`,`m_6_5_10_count`,
       `m_5_5_10_count`,`m_5_4_10_count`,
       `m_4_4_10_count`,
       `m_3_3_10_count`,
       `m_2_2_10_count` FROM tbl_on_keno_winnings AS tbl_keno_win, tbl_on_keno AS tbl_keno WHERE tbl_keno.onkenoid = tbl_keno_win.onkenoid AND 
          tbl_keno.drawdate >= '%s' AND tbl_keno.drawdate <= '%s' ",
          $st_drawdate, $ed_drawdate);
     //print "\nSSQL: " . $ssql;
     $ssql .= sprintf(" order by tbl_keno.drawdate");
     $db_data = $this->db_obj->fetch($ssql);
      
      
      $imatch_cnt     = 0;
      $ibonus_match   = 0;
      $irow_cnt       = 0;
      $smatch_wins    = null;
     
     $scomb_num = array();
     $scomb_num[0] = $snum1;
     if ($snum2 != "") {
       $scomb_num[1] = $snum2;
     }
     if ($snum3 != "") {
       $scomb_num[2] = $snum3;
     }
     
     if ($snum4 != "") {
       $scomb_num[3] = $snum4;
     }
     if ($snum5 != "") {
       $scomb_num[4] = $snum5;
     }
     if ($snum6 != "") {
       $scomb_num[5] = $snum6;
     }
     if ($snum7 != "") {
       $scomb_num[6] = $snum7;
     }
     if ($snum8 != "") {
       $scomb_num[7] = $snum8;
     }
     if ($snum9 != "") {
       $scomb_num[8] = $snum9;
     }
     if ($snum10 != "") {
       $scomb_num[9] = $snum10;
     }
     
  
     sort($scomb_num, SORT_ASC);
     $scomb_num      = array_unique($scomb_num);
             
     //print_r($scomb_num);   
     //print "\nArray Count: " . count($scomb_num) . " --- category: " . $category;
     if (count($scomb_num) != $category) {
       
       // numbers don't match
     } else {
        if (is_array($db_data)) {
          $imatch_cnt = 0;
          
          foreach ($db_data as $db_row) {
            $imatch_cnt = 0;  
            
              $imatch_cnt                 = 0;
              $ibonus_match               = 0;
              $smatch_wins[$irow_cnt]     = array(
                  "drawdate"        => $db_row["drawdate"],
                  "match_cnt"       => 0,
                  "match_numbers"   => array(),
                  "match_bonus"     => 0,
                  "match_bonus_num" => 0
              );
                
              $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_row["snum1"], $db_row["snum2"], $db_row["snum3"],
                                                              $db_row["snum4"], $db_row["snum5"], $db_row["snum6"],
                                                              $db_row["snum7"], $db_row["snum8"], $db_row["snum9"],
                                                              $db_row["snum10"], $db_row["snum11"], $db_row["snum12"],
                                                              $db_row["snum13"], $db_row["snum14"], $db_row["snum15"],
                                                              $db_row["snum16"], $db_row["snum17"], $db_row["snum18"],
                                                              $db_row["snum19"], $db_row["snum20"]
                                                              );
                                                              
              
            
            
            
            
             if ($db_row["snum1"] == $scomb_num[0] || $db_row["snum2"] == $scomb_num[0] || $db_row["snum3"] == $scomb_num[0] || $db_row["snum4"] == $scomb_num[0] || $db_row["snum5"] == $scomb_num[0] || 
                  $db_row["snum6"] == $scomb_num[0] || $db_row["snum7"] == $scomb_num[0] || $db_row["snum8"] == $scomb_num[0] || $db_row["snum9"] == $scomb_num[0] || $db_row["snum10"] == $scomb_num[0] || 
                  $db_row["snum11"] == $scomb_num[0] || $db_row["snum12"] == $scomb_num[0] || $db_row["snum13"] == $scomb_num[0] || $db_row["snum14"] == $scomb_num[0] || $db_row["snum15"] == $scomb_num[0] || 
                  $db_row["snum16"] == $scomb_num[0] || $db_row["snum17"] == $scomb_num[0] || $db_row["snum18"] == $scomb_num[0] || $db_row["snum19"] == $scomb_num[0] || $db_row["snum20"] == $scomb_num[0]) {
                    $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[0];
                    $imatch_cnt++;

                  }
             if ($category >= 2) {
               if ($db_row["snum1"] == $scomb_num[1] || $db_row["snum2"] == $scomb_num[1] || $db_row["snum3"] == $scomb_num[1] || $db_row["snum4"] == $scomb_num[1] || $db_row["snum5"] == $scomb_num[1] || 
                  $db_row["snum6"] == $scomb_num[1] || $db_row["snum7"] == $scomb_num[1] || $db_row["snum8"] == $scomb_num[1] || $db_row["snum9"] == $scomb_num[1] || $db_row["snum10"] == $scomb_num[1] || 
                  $db_row["snum11"] == $scomb_num[1] || $db_row["snum12"] == $scomb_num[1] || $db_row["snum13"] == $scomb_num[1] || $db_row["snum14"] == $scomb_num[1] || $db_row["snum15"] == $scomb_num[1] || 
                  $db_row["snum16"] == $scomb_num[1] || $db_row["snum17"] == $scomb_num[1] || $db_row["snum18"] == $scomb_num[1] || $db_row["snum19"] == $scomb_num[1] || $db_row["snum20"] == $scomb_num[1] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[1];  
                  $imatch_cnt++;
                } 
             }
             if ($category >= 3) {
               if ($db_row["snum1"] == $scomb_num[2] || $db_row["snum2"] == $scomb_num[2] || $db_row["snum3"] == $scomb_num[2] || $db_row["snum4"] == $scomb_num[2] || $db_row["snum5"] == $scomb_num[2] || 
                  $db_row["snum6"] == $scomb_num[2] || $db_row["snum7"] == $scomb_num[2] || $db_row["snum8"] == $scomb_num[2] || $db_row["snum9"] == $scomb_num[2] || $db_row["snum10"] == $scomb_num[2] || 
                  $db_row["snum11"] == $scomb_num[2] || $db_row["snum12"] == $scomb_num[2] || $db_row["snum13"] == $scomb_num[2] || $db_row["snum14"] == $scomb_num[2] || $db_row["snum15"] == $scomb_num[2] || 
                  $db_row["snum16"] == $scomb_num[2] || $db_row["snum17"] == $scomb_num[2] || $db_row["snum18"] == $scomb_num[2] || $db_row["snum19"] == $scomb_num[2] || $db_row["snum20"] == $scomb_num[2] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[2];
                  $imatch_cnt++;
                } 
             }
             if ($category >= 4) {
               if ($db_row["snum1"] == $scomb_num[3] || $db_row["snum2"] == $scomb_num[3] || $db_row["snum3"] == $scomb_num[3] || $db_row["snum4"] == $scomb_num[3] || $db_row["snum5"] == $scomb_num[3] || 
                  $db_row["snum6"] == $scomb_num[3] || $db_row["snum7"] == $scomb_num[3] || $db_row["snum8"] == $scomb_num[3] || $db_row["snum9"] == $scomb_num[3] || $db_row["snum10"] == $scomb_num[3] || 
                  $db_row["snum11"] == $scomb_num[3] || $db_row["snum12"] == $scomb_num[3] || $db_row["snum13"] == $scomb_num[3] || $db_row["snum14"] == $scomb_num[3] || $db_row["snum15"] == $scomb_num[3] || 
                  $db_row["snum16"] == $scomb_num[3] || $db_row["snum17"] == $scomb_num[3] || $db_row["snum18"] == $scomb_num[3] || $db_row["snum19"] == $scomb_num[3] || $db_row["snum20"] == $scomb_num[3] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[3];  
                  $imatch_cnt++;
                } 
             }
             if ($category >= 5) {
               if ($db_row["snum1"] == $scomb_num[4] || $db_row["snum2"] == $scomb_num[4] || $db_row["snum3"] == $scomb_num[4] || $db_row["snum4"] == $scomb_num[4] || $db_row["snum5"] == $scomb_num[4] || 
                  $db_row["snum6"] == $scomb_num[4] || $db_row["snum7"] == $scomb_num[4] || $db_row["snum8"] == $scomb_num[4] || $db_row["snum9"] == $scomb_num[4] || $db_row["snum10"] == $scomb_num[4] || 
                  $db_row["snum11"] == $scomb_num[4] || $db_row["snum12"] == $scomb_num[4] || $db_row["snum13"] == $scomb_num[4] || $db_row["snum14"] == $scomb_num[4] || $db_row["snum15"] == $scomb_num[4] || 
                  $db_row["snum16"] == $scomb_num[4] || $db_row["snum17"] == $scomb_num[4] || $db_row["snum18"] == $scomb_num[4] || $db_row["snum19"] == $scomb_num[4] || $db_row["snum20"] == $scomb_num[4] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[4];  
                  $imatch_cnt++;
                } 
             }
             if ($category >= 6) {
               if ($db_row["snum1"] == $scomb_num[5] || $db_row["snum2"] == $scomb_num[5] || $db_row["snum3"] == $scomb_num[5] || $db_row["snum4"] == $scomb_num[5] || $db_row["snum5"] == $scomb_num[5] || 
                  $db_row["snum6"] == $scomb_num[5] || $db_row["snum7"] == $scomb_num[5] || $db_row["snum8"] == $scomb_num[5] || $db_row["snum9"] == $scomb_num[5] || $db_row["snum10"] == $scomb_num[5] || 
                  $db_row["snum11"] == $scomb_num[5] || $db_row["snum12"] == $scomb_num[5] || $db_row["snum13"] == $scomb_num[5] || $db_row["snum14"] == $scomb_num[5] || $db_row["snum15"] == $scomb_num[5] || 
                  $db_row["snum16"] == $scomb_num[5] || $db_row["snum17"] == $scomb_num[5] || $db_row["snum18"] == $scomb_num[5] || $db_row["snum19"] == $scomb_num[5] || $db_row["snum20"] == $scomb_num[5]) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[5];  
                  $imatch_cnt++;
                }
             }
             if ($category >= 7) { 
               if ($db_row["snum1"] == $scomb_num[6] || $db_row["snum2"] == $scomb_num[6] || $db_row["snum3"] == $scomb_num[6] || $db_row["snum4"] == $scomb_num[6] || $db_row["snum5"] == $scomb_num[6] || 
                  $db_row["snum6"] == $scomb_num[6] || $db_row["snum7"] == $scomb_num[6] || $db_row["snum8"] == $scomb_num[6] || $db_row["snum9"] == $scomb_num[6] || $db_row["snum10"] == $scomb_num[6] || 
                  $db_row["snum11"] == $scomb_num[6] || $db_row["snum12"] == $scomb_num[6] || $db_row["snum13"] == $scomb_num[6] || $db_row["snum14"] == $scomb_num[6] || $db_row["snum15"] == $scomb_num[6] || 
                  $db_row["snum16"] == $scomb_num[6] || $db_row["snum17"] == $scomb_num[6] || $db_row["snum18"] == $scomb_num[6] || $db_row["snum19"] == $scomb_num[6] || $db_row["snum20"] == $scomb_num[6] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[6];
                  $imatch_cnt++;
                 
                } 
             }
             if ($category >= 8) {
               if ($db_row["snum1"] == $scomb_num[7] || $db_row["snum2"] == $scomb_num[7] || $db_row["snum3"] == $scomb_num[7] || $db_row["snum4"] == $scomb_num[7] || $db_row["snum5"] == $scomb_num[7] || 
                  $db_row["snum6"] == $scomb_num[7] || $db_row["snum7"] == $scomb_num[7] || $db_row["snum8"] == $scomb_num[7] || $db_row["snum9"] == $scomb_num[7] || $db_row["snum10"] == $scomb_num[7] || 
                  $db_row["snum11"] == $scomb_num[7] || $db_row["snum12"] == $scomb_num[7] || $db_row["snum13"] == $scomb_num[7] || $db_row["snum14"] == $scomb_num[7] || $db_row["snum15"] == $scomb_num[7] || 
                  $db_row["snum16"] == $scomb_num[7] || $db_row["snum17"] == $scomb_num[7] || $db_row["snum18"] == $scomb_num[7] || $db_row["snum19"] == $scomb_num[7] || $db_row["snum20"] == $scomb_num[7] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[7];
                  $imatch_cnt++;
                }
             }
             if ($category >= 9) { 
               if ($db_row["snum1"] == $scomb_num[8] || $db_row["snum2"] == $scomb_num[8] || $db_row["snum3"] == $scomb_num[8] || $db_row["snum4"] == $scomb_num[8] || $db_row["snum5"] == $scomb_num[8] || 
                  $db_row["snum6"] == $scomb_num[8] || $db_row["snum7"] == $scomb_num[8] || $db_row["snum8"] == $scomb_num[8] || $db_row["snum9"] == $scomb_num[8] || $db_row["snum10"] == $scomb_num[8] || 
                  $db_row["snum11"] == $scomb_num[8] || $db_row["snum12"] == $scomb_num[8] || $db_row["snum13"] == $scomb_num[8] || $db_row["snum14"] == $scomb_num[8] || $db_row["snum15"] == $scomb_num[8] || 
                  $db_row["snum16"] == $scomb_num[8] || $db_row["snum17"] == $scomb_num[8] || $db_row["snum18"] == $scomb_num[8] || $db_row["snum19"] == $scomb_num[8] || $db_row["snum20"] == $scomb_num[8] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[8];  
                  $imatch_cnt++;
                } 
             }
             if ($category == 10) {
              if ($db_row["snum1"] == $scomb_num[9] || $db_row["snum2"] == $scomb_num[9] || $db_row["snum3"] == $scomb_num[9] || $db_row["snum4"] == $scomb_num[9] || $db_row["snum5"] == $scomb_num[9] || 
                  $db_row["snum6"] == $scomb_num[9] || $db_row["snum7"] == $scomb_num[9] || $db_row["snum8"] == $scomb_num[9] || $db_row["snum9"] == $scomb_num[9] || $db_row["snum10"] == $scomb_num[9] || 
                  $db_row["snum11"] == $scomb_num[9] || $db_row["snum12"] == $scomb_num[9] || $db_row["snum13"] == $scomb_num[9] || $db_row["snum14"] == $scomb_num[9] || $db_row["snum15"] == $scomb_num[9] || 
                  $db_row["snum16"] == $scomb_num[9] || $db_row["snum17"] == $scomb_num[9] || $db_row["snum18"] == $scomb_num[9] || $db_row["snum19"] == $scomb_num[9] || $db_row["snum20"] == $scomb_num[9]) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $scomb_num[9];
                  
                  $imatch_cnt++;
               } 
             }
             $smatch_wins[$irow_cnt]["category"] = $category;
             $smatch_wins[$irow_cnt]["match_cnt"] = $imatch_cnt;
             //
             if ($category == 10) {
               if ($imatch_cnt == 10) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_10_10_1_prze_amt"];
               } elseif ($imatch_cnt == 9) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_10_9_1_prze_amt"];
               } elseif ($imatch_cnt == 8) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_10_8_1_prze_amt"];
               } elseif ($imatch_cnt == 7) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_10_7_1_prze_amt"];
               } elseif ($imatch_cnt == 0) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_10_0_1_prze_amt"];
               }
             } elseif ($category == 9) {
               if ($imatch_cnt == 9) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_9_9_1_prze_amt"];
               } elseif ($imatch_cnt == 8) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_9_8_1_prze_amt"];
               } elseif ($imatch_cnt == 7) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_9_7_1_prze_amt"];
               } elseif ($imatch_cnt == 6) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_9_6_1_prze_amt"];
               }
             } elseif ($category == 8) {
               if ($imatch_cnt == 8) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_8_8_1_prze_amt"];
               } elseif ($imatch_cnt == 7) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_8_7_1_prze_amt"];
               } elseif ($imatch_cnt == 6) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_8_6_1_prze_amt"];
               }
             } elseif ($category == 7) {
               if ($imatch_cnt == 7) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_7_7_1_prze_amt"];
               } elseif ($imatch_cnt == 6) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_7_6_1_prze_amt"];
               } elseif ($imatch_cnt == 5) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_7_5_1_prze_amt"];
               }
               
             } elseif ($category == 6) {
               if ($imatch_cnt == 6) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_6_6_1_prze_amt"];
               } elseif ($imatch_cnt == 5) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_6_5_1_prze_amt"];
               }
             } elseif ($category == 5) {
               if ($imatch_cnt == 5) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_5_1_prze_amt"];
               } elseif ($imatch_cnt == 4) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_4_1_prze_amt"];
               }
             } elseif ($category == 4) {
               if ($imatch_cnt == 4) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_4_4_1_prze_amt"];
               }
             } elseif ($category == 3) {
               if ($imatch_cnt == 3) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_3_3_1_prze_amt"];
               }
             } elseif ($category == 2) {
               if ($imatch_cnt == 2) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_2_2_1_prze_amt"];
               }
             }
           
           
           $irow_cnt++;           
          }
        }
      }      
  if (is_array($smatch_wins)) {
    return $smatch_wins;
  } else {
    return null;
  }   


}
    
    /*
     * startdrawdate
     * enddrawdate
     * drawdate
     * onkenoid
     * category
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snum7
     * snum8
     * snum9
     * snum10
     * 
     */ 
    
    function OLGKenoValidate($startdrawdate, $enddrawdate, $drawdate = "", $category, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf(" SELECT * FROM `tbl_on_keno` WHERE ");
     $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s'", $startdrawdate, $enddrawdate);
    
      
      $db_data = $this->db_obj->fetch($ssql);
      if (is_array($db_data)) {
        foreach ($db_data as $db_row) {
           if ($db_row["snum1"] == $snum1 || $db_row["snum1"] == $snum2 || $db_row["snum1"] == $snum3 || $db_row["snum1"] == $snum4 || $db_row["snum1"] == $snum5 || $db_row["snum1"] == $snum6 || $db_row["snum1"] == $snum7 || $db_row["snum1"] == $snum8 || $db_row["snum1"] == $snum9 || $db_row["snum1"] == $snum10 || $db_row["snum1"] == $snum11 || $db_row["snum1"] == $snum12 || $db_row["snum1"] == $snum13 || $db_row["snum1"] == $snum14 || $db_row["snum1"] == $snum15 || $db_row["snum1"] == $snum16 || $db_row["snum1"] == $snum17  || $db_row["snum1"] == $snum18  || $db_row["snum1"] == $snum19  || $db_row["snum1"] == $snum20) {
              
            } 
           if ($category >= 2) {
             if ($db_row["snum2"] == $snum1 || $db_row["snum2"] == $snum2 || $db_row["snum2"] == $snum3 || $db_row["snum2"] == $snum4 || $db_row["snum2"] == $snum5 || $db_row["snum2"] == $snum6 || $db_row["snum2"] == $snum7 || $db_row["snum2"] == $snum8 || $db_row["snum2"] == $snum9 || $db_row["snum2"] == $snum10 || $db_row["snum2"] == $snum11 || $db_row["snum2"] == $snum12 || $db_row["snum2"] == $snum13 || $db_row["snum2"] == $snum14 || $db_row["snum2"] == $snum15 || $db_row["snum2"] == $snum16 || $db_row["snum2"] == $snum17  || $db_row["snum2"] == $snum18  || $db_row["snum2"] == $snum19  || $db_row["snum2"] == $snum20) {
                
              } 
           }
           if ($category >= 3) {
             if ($db_row["snum3"] == $snum1 || $db_row["snum3"] == $snum2 || $db_row["snum3"] == $snum3 || $db_row["snum3"] == $snum4 || $db_row["snum3"] == $snum5 || $db_row["snum3"] == $snum6 || $db_row["snum3"] == $snum7 || $db_row["snum3"] == $snum8 || $db_row["snum3"] == $snum9 || $db_row["snum3"] == $snum10 || $db_row["snum3"] == $snum11 || $db_row["snum3"] == $snum12 || $db_row["snum3"] == $snum13 || $db_row["snum3"] == $snum14 || $db_row["snum3"] == $snum15 || $db_row["snum3"] == $snum16 || $db_row["snum3"] == $snum17  || $db_row["snum3"] == $snum18  || $db_row["snum3"] == $snum19  || $db_row["snum3"] == $snum20) {
                
              } 
           }
           if ($category >= 4) {
             if ($db_row["snum4"] == $snum1 || $db_row["snum4"] == $snum2 || $db_row["snum4"] == $snum3 || $db_row["snum4"] == $snum4 || $db_row["snum4"] == $snum5 || $db_row["snum4"] == $snum6 || $db_row["snum4"] == $snum7 || $db_row["snum4"] == $snum8 || $db_row["snum4"] == $snum9 || $db_row["snum4"] == $snum10 || $db_row["snum4"] == $snum11 || $db_row["snum4"] == $snum12 || $db_row["snum4"] == $snum13 || $db_row["snum4"] == $snum14 || $db_row["snum4"] == $snum15 || $db_row["snum4"] == $snum16 || $db_row["snum4"] == $snum17  || $db_row["snum4"] == $snum18  || $db_row["snum4"] == $snum19  || $db_row["snum4"] == $snum20) {
                
              } 
           }
           if ($category >= 5) {
             if ($db_row["snum5"] == $snum1 || $db_row["snum5"] == $snum2 || $db_row["snum5"] == $snum3 || $db_row["snum5"] == $snum4 || $db_row["snum5"] == $snum5 || $db_row["snum5"] == $snum6 || $db_row["snum5"] == $snum7 || $db_row["snum5"] == $snum8 || $db_row["snum5"] == $snum9 || $db_row["snum5"] == $snum10 || $db_row["snum5"] == $snum11 || $db_row["snum5"] == $snum12 || $db_row["snum5"] == $snum13 || $db_row["snum5"] == $snum14 || $db_row["snum5"] == $snum15 || $db_row["snum5"] == $snum16 || $db_row["snum5"] == $snum17  || $db_row["snum5"] == $snum18  || $db_row["snum5"] == $snum19  || $db_row["snum5"] == $snum20) {
                
              } 
           }
           if ($category >= 6) {
             if ($db_row["snum6"] == $snum1 || $db_row["snum6"] == $snum2 || $db_row["snum6"] == $snum3 || $db_row["snum6"] == $snum4 || $db_row["snum6"] == $snum5 || $db_row["snum6"] == $snum6 || $db_row["snum6"] == $snum7 || $db_row["snum6"] == $snum8 || $db_row["snum6"] == $snum9 || $db_row["snum6"] == $snum10 || $db_row["snum6"] == $snum11 || $db_row["snum6"] == $snum12 || $db_row["snum6"] == $snum13 || $db_row["snum6"] == $snum14 || $db_row["snum6"] == $snum15 || $db_row["snum6"] == $snum16 || $db_row["snum6"] == $snum17  || $db_row["snum6"] == $snum18  || $db_row["snum6"] == $snum19  || $db_row["snum6"] == $snum20) {
                
              }
           }
           if ($category >= 7) { 
             if ($db_row["snum7"] == $snum1 || $db_row["snum7"] == $snum2 || $db_row["snum7"] == $snum3 || $db_row["snum7"] == $snum4 || $db_row["snum7"] == $snum5 || $db_row["snum7"] == $snum6 || $db_row["snum7"] == $snum7 || $db_row["snum7"] == $snum8 || $db_row["snum7"] == $snum9 || $db_row["snum7"] == $snum10 || $db_row["snum7"] == $snum11 || $db_row["snum7"] == $snum12 || $db_row["snum7"] == $snum13 || $db_row["snum7"] == $snum14 || $db_row["snum7"] == $snum15 || $db_row["snum7"] == $snum16 || $db_row["snum7"] == $snum17  || $db_row["snum7"] == $snum18  || $db_row["snum7"] == $snum19  || $db_row["snum7"] == $snum20) {
                
              } 
           }
           if ($category >= 8) {
             if ($db_row["snum8"] == $snum1 || $db_row["snum8"] == $snum2 || $db_row["snum8"] == $snum3 || $db_row["snum8"] == $snum4 || $db_row["snum8"] == $snum5 || $db_row["snum8"] == $snum6 || $db_row["snum8"] == $snum7 || $db_row["snum8"] == $snum8 || $db_row["snum8"] == $snum9 || $db_row["snum8"] == $snum10 || $db_row["snum8"] == $snum11 || $db_row["snum8"] == $snum12 || $db_row["snum8"] == $snum13 || $db_row["snum8"] == $snum14 || $db_row["snum8"] == $snum15 || $db_row["snum8"] == $snum16 || $db_row["snum8"] == $snum17  || $db_row["snum8"] == $snum18  || $db_row["snum8"] == $snum19  || $db_row["snum8"] == $snum20) {
                
              }
           }
           if ($category >= 9) { 
             if ($db_row["snum9"] == $snum1 || $db_row["snum9"] == $snum2 || $db_row["snum9"] == $snum3 || $db_row["snum9"] == $snum4 || $db_row["snum9"] == $snum5 || $db_row["snum9"] == $snum6 || $db_row["snum9"] == $snum7 || $db_row["snum9"] == $snum8 || $db_row["snum9"] == $snum9 || $db_row["snum9"] == $snum10 || $db_row["snum9"] == $snum11 || $db_row["snum9"] == $snum12 || $db_row["snum9"] == $snum13 || $db_row["snum9"] == $snum14 || $db_row["snum9"] == $snum15 || $db_row["snum9"] == $snum16 || $db_row["snum9"] == $snum17  || $db_row["snum9"] == $snum18  || $db_row["snum9"] == $snum19  || $db_row["snum9"] == $snum20) {
                
              } 
           }
           if ($category == 10) {
            if ($db_row["snum10"] == $snum1 || $db_row["snum10"] == $snum2 || $db_row["snum10"] == $snum3 || $db_row["snum10"] == $snum4 || $db_row["snum10"] == $snum5 || $db_row["snum10"] == $snum6 || $db_row["snum10"] == $snum7 || $db_row["snum10"] == $snum8 || $db_row["snum10"] == $snum9 || $db_row["snum10"] == $snum10 || $db_row["snum10"] == $snum11 || $db_row["snum10"] == $snum12 || $db_row["snum10"] == $snum13 || $db_row["snum10"] == $snum14 || $db_row["snum10"] == $snum15 || $db_row["snum10"] == $snum16 || $db_row["snum10"] == $snum17  || $db_row["snum10"] == $snum18  || $db_row["snum10"] == $snum19  || $db_row["snum10"] == $snum20) {
                
              } 
           }         
        }
      }
    }
    
    
    
    function OLGKenoGetMonth() {
      
    }
    function OLGKenoGetYear() {
      
    }
    function OLGKenoGetAll() {
      
    }
    
    
    /*
     * 
     * Lottario
     * 
     * drawdate
     * idrawnum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snumbonus
     * 
     * EarlyBird
     * eb_idrawnum
     * eb_snum1
     * eb_snum2
     * eb_snum3
     * eb_snum4
     * 
     * 
     * return: onlottarioid
     * 
     */
  
      
    function OLGLottarioAdd($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, $eb_idrawnum = 0, $eb_snum1 = "", $eb_snum2 = "", $eb_snum3 = "", $eb_snum4 = "", $drawNo, $sdrawDate, $spielID) {
        
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
   
      $ssql = sprintf("INSERT INTO `tbl_on_lottario` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snumbonus` ");
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo`, `sdrawDate`, `spielID`) ");
      } else {
        $ssql .= sprintf(") ");
      }
      
      $ssql .= sprintf(" VALUES (%u,'%s',%u,%u,%u,%u,%u,%u,%u", $idrawnum, $drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus);
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,%u, %u, %u) ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(") ");
      }
      

      $rows_affected = $this->db_obj->exec($ssql);      
      $onlottarioid = $this->db_obj->last_id;
      
      //print "\nSQL: " . $ssql;
      $ssql = sprintf("INSERT INTO `tbl_on_early_bird` (`onlottarioid`,`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`)");
      $ssql .= sprintf(" VALUES (%u, %u,'%s',%u,%u,%u,%u)", $onlottarioid, $idrawnum, $drawdate, $eb_snum1, $eb_snum2, $eb_snum3, $eb_snum4);
      //print "\nSQL: " . $ssql;
      $rows_affected =  $this->db_obj->exec($ssql);      
      
      return $onlottarioid;      
    }
    
    
    /*
     * 
     * drawdate
     * onlottarioid
     * 
     * 
     * 
     */ 
    function OLGLottarioRemove($drawdate, $onlottarioid) {
     
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
   
      $ssql = sprintf("DELETE FROM `tbl_on_early_bird` WHERE ");
      $ssql .= sprintf(" onlottarioid = %u");      
      
      $this->db_obj->exec($ssql);
      $eb_af_cnt = $this->db_obj->rows_affected;
      $ssql = sprintf("DELETE FROM `tbl_on_lottario` WHERE ");
      $ssql .= sprintf(" drawdate = '%s' ", $drawdate);
      $ssql .= sprintf(" AND onlottarioid = %u", $drawdate);
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected + $eb_af_cnt;
    }
    
    
     /*
     * 
     * Lottario
     * 
     * drawdate
     * idrawnum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snumbonus
     * 
     * EarlyBird
     * eb_idrawnum
     * onlottarioid
     * eb_snum1
     * eb_snum2
     * eb_snum3
     * eb_snum4
     * 
     * 
     * return: onlottarioid
     * 
     */
    function OLGLottarioModify($olddrawdate, $newdrawdate, $drawdate = "", $onlottarioid,  $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, $eb_idrawnum = 0, $eb_snum1 = "", $eb_snum2 = "", $eb_snum3 = "", $eb_snum4 = "", $drawNo, $sdrawDate, $spielID) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
   
      $ssql = sprintf("UPDATE `tbl_on_lottario` SET ");
      $ssql .= sprintf(" `idrawnum` = %u, `drawdate` = '%s',`snum1` = %u,`snum2` = %u,`snum3` = %u,`snum4` = %u,`snum5` = %u,`snum6` = %u,`snumbonus` = %u ", $idrawnum, $newdrawdate,  $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus);
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo` = %u, `sdrawDate` = %u, `spielID` = %u ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(") ");
      }
      
      $ssql .= sprintf(" WHERE drawdate = '%s'", $olddrawdate);
      $this->db_obj->exec($ssql);
      $eb_af_cnt = $this->db_obj->rows_affected;
      $ssql = sprintf("UPDATE `tbl_on_early_bird` SET ");
      $ssql .= sprintf(" `idrawnum` = %u,`drawdate` = '%s',`snum1` = %u,`snum2` = %u,`snum3` = %u,`snum4` = %u", $eb_idrawnum, $newdrawdate, $eb_snum1, $eb_snum2, $eb_snum3, $eb_snum4);
      $ssql .= sprintf(" WHERE drawdate = '%s'", $olddrawdate);
      $this->db_obj->exec($ssql);
      
      return $this->db_obj->rows_affected + $eb_af_cnt;
    }
    
    /*
     * drawdate
     * onlottarioid
     * 
     * 
     * 
     */ 
    
    function OLGLottarioGetSingleDraw($drawdate) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT tbl_on_lottario.*, tbl_on_early_bird.* FROM `tbl_on_lottario` , `tbl_on_early_bird`  WHERE ");
      $ssql .= sprintf(" (`tbl_on_lottario`.onlottarioid = `tbl_on_early_bird`.onlottarioid) AND `tbl_on_lottario`.drawdate = '%s' ", $drawdate);
     
     
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
    }
    
    
    function OLGLottarioGetDraw($st_drawdate, $ed_drawdate, $st_pos = 0, $limit = 350) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT onlot.*, eb.snum1 as `eb_snum1`, eb.snum2 as `eb_snum2`, eb.snum3 as `eb_snum3`, eb.snum4 as `eb_snum4`  FROM `tbl_on_lottario` AS onlot, `tbl_on_early_bird` AS eb WHERE ");
      $ssql .= sprintf(" (`onlot`.onlottarioid = `eb`.onlottarioid) AND `onlot`.drawdate >= '%s' AND  `onlot`.drawdate <= '%s' ",
                    $st_drawdate, $ed_drawdate);
      $ssql .= sprintf(" order by onlot.drawdate");
      $db_res = $this->db_obj->fetch($ssql);
      
      /*
       * onlot
       * 
       * eb.snum1
       * eb.snum2
       * eb.snum3
       * eb.snum4
       * 
       * 
       */ 
      //print "\n<br />SQL : " . $ssql;
      if (is_array($db_res)) {
        return $db_res;
      } else {
        return null;
      }
      
    }
    
    function OLGLottarioGetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_on_lottario`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_on_lottario`");
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        $data_avail["latest"] = $db_res[0]["LatestDate"];
      }
      if (is_array($db_res)) {
        return $data_avail;
      } else {
        return null;
      }
    }
    
    
     function OLGLottarioGetDrawId($drawdate) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT * FROM `tbl_on_lottario`  WHERE");
      $ssql .= sprintf(" drawdate = '%s'", $drawdate);
     
      
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0]["onlottarioid"];
      } else {
        return null;
      }
      
    }
     
    function OLGEarlyBirdGetDrawId($drawdate) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT * FROM `tbl_on_early_bird`  WHERE");
      $ssql .= sprintf(" drawdate = '%s'", $drawdate);
      //print $ssql;
      
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        //print_r($db_res);
        return $db_res[0]["onearlybirdid"];
      } else {
        return null;
      }
      
    }
     
      
    /*
      * drawdate
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snumbonus
     * 
     * EarlyBird
     * eb_idrawnum
     * onlottarioid
     * eb_snum1
     * eb_snum2
     * eb_snum3
     * eb_snum4
    * 
     * 
     * 
     */ 
    
    
    function OLGLottarioValidateDraw($st_drawdate, $ed_drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $eb_snum1 = "", $eb_snum2 = "", $eb_snum3 = "", $eb_snum4 = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf(" SELECT 
                tbl_lottario.*, 
                
                
                tbl_eb.snum1 as `eb_snum1`, tbl_eb.snum2 as `eb_snum2`,
                tbl_eb.snum3 as `eb_snum3`, tbl_eb.snum4 as `eb_snum4`,
                `m_6_count`,`m_6_amount`,
                (SELECT prze_amount as m_6_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_lottario_win.m_6_amount) AS m_6_prze_amt,
       
                `m_6_region`,`m_5_b_count`,`m_5_b_amount`,
                (SELECT prze_amount as m_5_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_lottario_win.m_5_b_amount) AS m_5_b_prze_amt,
                
                `m_5_b_region`,`m_5_count`,`m_5_amount`,
                (SELECT prze_amount as m_5_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_lottario_win.m_5_amount) AS m_5_prze_amt,
                
                `m_4_count`, `m_4_amount`,
                (SELECT prze_amount as m_4_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_lottario_win.m_4_amount) AS m_4_prze_amt,
                
                `m_3_count`,`m_3_amount`,
                (SELECT prze_amount as m_3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_lottario_win.m_3_amount) AS m_3_prze_amt,
                
                `m_e_bird_id`,`m_e_bird_count`,`m_e_bird_amount`,
                (SELECT prze_amount as m_e_bird_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_lottario_win.m_e_bird_amount) AS m_e_bird_prze_amt

                 FROM tbl_on_lottario_winnings AS tbl_lottario_win, tbl_on_lottario AS tbl_lottario, tbl_on_early_bird as tbl_eb WHERE 
                 tbl_eb.onlottarioid = tbl_lottario.onlottarioid AND
                 tbl_lottario.onlottarioid = tbl_lottario_win.onlottarioid AND 
                tbl_lottario.drawdate >= '%s' AND tbl_lottario.drawdate <= '%s'",
                $st_drawdate, $ed_drawdate);
     // print $ssql;
     $ssql .= sprintf(" order by tbl_lottario.drawdate");
     $db_data = $this->db_obj->fetch($ssql);
    
    $imatch_cnt     = 0;
    $ibonus_match   = 0;
    $irow_cnt       = 0;
    $ieb_match_cnt  = 0;
    
    $smatch_wins    = null;
   
     
     $scomb_num       = array(
                $snum1, $snum2, $snum3, $snum4, $snum5, $snum6
                );
     $sebcomb_num     = array(
                $eb_snum1, $eb_snum2, $eb_snum3, $eb_snum4);
     sort($scomb_num, SORT_ASC);
     sort($sebcomb_num, SORT_ASC);
     $scomb_num     = array_unique($scomb_num);
     $sebcomb_num   = array_unique($sebcomb_num);
     //print "\nInside Validate Draw Function\n";
     //print_r($scomb_num);
     //print_r($sebcomb_num);
     //print_r($db_data);
     if (count($scomb_num) == 6) {
       $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_data)) {
            $imatch_cnt = 0;
            //print "\nInside Iterations\n";
            foreach ($db_data as $db_row) {
                $imatch_cnt                 = 0;
                $ieb_match_cnt              = 0;
                $ibonus_match               = 0;
                $smatch_wins[$irow_cnt]     = array(
                    "drawdate"          => $db_row["drawdate"],
                    "match_cnt"         => 0,
                    "match_eb_cnt"      => 0,
                    "match_numbers"     => array(),
                    "match_eb_numbers"  => array(),
                    "match_bonus"       => 0,
                    "match_bonus_num"   => 0
                );
                  
                $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_row["snum1"], $db_row["snum2"], $db_row["snum3"],
                                                                $db_row["snum4"], $db_row["snum5"], $db_row["snum6"]);
                           
                $smatch_wins[$irow_cnt]["eb_draw_numbers"] = array(
                    $db_row["eb_snum1"], $db_row["eb_snum2"], $db_row["eb_snum3"],
                    $db_row["eb_snum4"]
                   );                                
                $smatch_wins[$irow_cnt]["draw_bonus"]   = $db_row["snumbonus"];
                
              
                if ($db_row["snum1"] == $scomb_num[0] || $db_row["snum1"] == $scomb_num[1] || $db_row["snum1"] == $scomb_num[2] || $db_row["snum1"] == $scomb_num[3] || $db_row["snum1"] == $scomb_num[4] || $db_row["snum1"] == $scomb_num[5]  ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum1"];
                  $imatch_cnt++;
                  
                } 
                if ($db_row["snum2"] == $scomb_num[0] || $db_row["snum2"] == $scomb_num[1] || $db_row["snum2"] == $scomb_num[2] || $db_row["snum2"] == $scomb_num[3] || $db_row["snum2"] == $scomb_num[4] || $db_row["snum2"] == $scomb_num[5] ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum2"];
                  $imatch_cnt++;
                } 
                if ($db_row["snum3"] == $scomb_num[0] || $db_row["snum3"] == $scomb_num[1] || $db_row["snum3"] == $scomb_num[2] || $db_row["snum3"] == $scomb_num[3] || $db_row["snum3"] == $scomb_num[4] || $db_row["snum3"] == $scomb_num[5]   ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum3"];
                  $imatch_cnt++;
                } 
                if ($db_row["snum4"] == $scomb_num[0] || $db_row["snum4"] == $scomb_num[1] || $db_row["snum4"] == $scomb_num[2] || $db_row["snum4"] == $scomb_num[3] || $db_row["snum4"] == $scomb_num[4] || $db_row["snum4"] == $scomb_num[5]  ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum4"];
                  $imatch_cnt++;
                } 
                if ($db_row["snum5"] == $scomb_num[0] || $db_row["snum5"] == $scomb_num[1] || $db_row["snum5"] == $scomb_num[2] || $db_row["snum5"] == $scomb_num[3] || $db_row["snum5"] == $scomb_num[4] || $db_row["snum5"] == $scomb_num[5]  ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum5"];
                  $imatch_cnt++;
                } 
                if ($db_row["snum6"] == $scomb_num[0] || $db_row["snum6"] == $scomb_num[1] || $db_row["snum6"] == $scomb_num[2] || $db_row["snum6"] == $scomb_num[3] || $db_row["snum6"] == $scomb_num[4] || $db_row["snum6"] == $scomb_num[5]  ) {
                  $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum6"];
                  $imatch_cnt++;
                } 
                   
               if ($db_row["snumbonus"] == $scomb_num[0] || $db_row["snumbonus"] == $scomb_num[1] || $db_row["snumbonus"] == $scomb_num[2] || $db_row["snumbonus"] == $scomb_num[3] || $db_row["snumbonus"] == $scomb_num[4] || $db_row["snumbonus"] == $scomb_num[5]  ) {
                  $ibonus_match = 1;
                  $smatch_wins[$irow_cnt]["match_bonus_num"]  = $db_row["snumbonus"];
                  $smatch_wins[$irow_cnt]["match_bonus"]      = 1;
               }   
               

                
               if ($eb_snum1 != "" && count($sebcomb_num) == 4) {
                 $ieb_match_cnt = 0;  
               
                  
                 if ($db_row["eb_snum1"] == $sebcomb_num[0] || $db_row["eb_snum1"] == $sebcomb_num[1] || $db_row["eb_snum1"] == $sebcomb_num[2] || $db_row["eb_snum1"] == $sebcomb_num[3] )  {
                    $smatch_wins[$irow_cnt]["match_eb_numbers"][$ieb_match_cnt] = $db_row["eb_snum1"];
                    $ieb_match_cnt++;
                  }
                  if ($db_row["eb_snum2"] == $sebcomb_num[0] || $db_row["eb_snum2"] == $sebcomb_num[1] || $db_row["eb_snum2"] == $sebcomb_num[2] || $db_row["eb_snum2"] == $sebcomb_num[3] )  {
                    $smatch_wins[$irow_cnt]["match_eb_numbers"][$ieb_match_cnt] = $db_row["eb_snum2"];
                    $ieb_match_cnt++;
                  }
                  if ($db_row["eb_snum3"] == $sebcomb_num[0] || $db_row["eb_snum3"] == $sebcomb_num[1] || $db_row["eb_snum3"] == $sebcomb_num[2] || $db_row["eb_snum3"] == $sebcomb_num[3] )  {
                    $smatch_wins[$irow_cnt]["match_eb_numbers"][$ieb_match_cnt] = $db_row["eb_snum3"];
                    $ieb_match_cnt++;
                  }
                  if ($db_row["eb_snum4"] == $sebcomb_num[0] || $db_row["eb_snum4"] == $sebcomb_num[1] || $db_row["eb_snum4"] == $sebcomb_num[2] || $db_row["eb_snum4"] == $sebcomb_num[3] )  {
                    $smatch_wins[$irow_cnt]["match_eb_numbers"][$ieb_match_cnt] = $db_row["eb_snum4"];
                    $ieb_match_cnt++;
                  } 
                  
                  
               }
               $smatch_wins[$irow_cnt]["match_cnt"]     = $imatch_cnt;
               $smatch_wins[$irow_cnt]["match_eb_cnt"]  = $ieb_match_cnt;
               
         
               
              if ($imatch_cnt == 6) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_6_prze_amt"];
               } elseif ($imatch_cnt == 5 && $ibonus_match == 1) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_b_prze_amt"];
               } elseif ($imatch_cnt == 5) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_prze_amt"];
               } elseif ($imatch_cnt == 4) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_4_prze_amt"];
               } elseif ($imatch_cnt == 3) {
                 $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_3_prze_amt"];
               }
               
               if ($ieb_match_cnt == 4) {
                $smatch_wins[$irow_cnt]["win_prze_ebird_amount"] = $db_row["m_e_bird_prze_amt"];  
               } 
               $irow_cnt++;
            }
        }      
      }
      //print_r($smatch_wins);
      if (is_array($smatch_wins)) {
        return $smatch_wins;
      } else {
        return null;
      }

    }
    /*
     * drawdate
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * eb_snum1
     * eb_snum2
     * eb_snum3
     * eb_snum4
     * 
     * 
     * 
     */ 
    function OLGLottarioValidate($drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $eb_snum1, $eb_snum2, $eb_snum3, $eb_snum4) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_lottario` WHERE ");
      $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s'", $startdrawdate, $enddrawdate);
    
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
           foreach ($db_data as $db_row) {
              if ($db_row["snum1"] == $snum1 || $db_row["snum1"] == $snum2 || $db_row["snum1"] == $snum3 || $db_row["snum1"] == $snum4 || $db_row["snum1"] == $snum5 || $db_row["snum1"] == $snum6  ) {
                
              } 
              if ($db_row["snum2"] == $snum1 || $db_row["snum2"] == $snum2 || $db_row["snum2"] == $snum3 || $db_row["snum2"] == $snum4 || $db_row["snum2"] == $snum5 || $db_row["snum2"] == $snum6 ) {
                
              } 
              if ($db_row["snum3"] == $snum1 || $db_row["snum3"] == $snum2 || $db_row["snum3"] == $snum3 || $db_row["snum3"] == $snum4 || $db_row["snum3"] == $snum5 || $db_row["snum3"] == $snum6   ) {
                
              } 
              if ($db_row["snum4"] == $snum1 || $db_row["snum4"] == $snum2 || $db_row["snum4"] == $snum3 || $db_row["snum4"] == $snum4 || $db_row["snum4"] == $snum5 || $db_row["snum4"] == $snum6  ) {
                
              } 
              if ($db_row["snum5"] == $snum1 || $db_row["snum5"] == $snum2 || $db_row["snum5"] == $snum3 || $db_row["snum5"] == $snum4 || $db_row["snum5"] == $snum5 || $db_row["snum5"] == $snum6  ) {
                
              } 
              if ($db_row["snum6"] == $snum1 || $db_row["snum6"] == $snum2 || $db_row["snum6"] == $snum3 || $db_row["snum6"] == $snum4 || $db_row["snum6"] == $snum5 || $db_row["snum6"] == $snum6  ) {
                
              } 
                 
             if ($db_row["snumbonus"] == $snum1 || $db_row["snumbonus"] == $snum2 || $db_row["snumbonus"] == $snum3 || $db_row["snumbonus"] == $snum4 || $db_row["snumbonus"] == $snum5 || $db_row["snumbonus"] == $snum6  ) {
                
             }   
              
          }
      }     
      
      $ssql = sprintf("SELECT * FROM `tbl_on_early_bird` WHERE ");
      $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s'", $startdrawdate, $enddrawdate);
    
      $db2_data = $this->db_obj->fetch($ssql);
      if (is_array($db2_data)) {
         if ($eb_snum1 != "") {
         foreach ($db2_data as $db_row) {
            if ($db_row["snum1"] == $eb_snum1 || $db_row["snum1"] == $eb_snum2 || $db_row["snum1"] == $eb_snum3 || $db_row["snum1"] == $eb_snum4 )  {
              
            }
            if ($db_row["snum2"] == $eb_snum1 || $db_row["snum2"] == $eb_snum2 || $db_row["snum2"] == $eb_snum3 || $db_row["snum2"] == $eb_snum4 )  {
            
            }
            if ($db_row["snum3"] == $eb_snum1 || $db_row["snum3"] == $eb_snum2 || $db_row["snum3"] == $eb_snum3 || $db_row["snum3"] == $eb_snum4 )  {
             
            }
            if ($db_row["snum4"] == $eb_snum1 || $db_row["snum4"] == $eb_snum2 || $db_row["snum4"] == $eb_snum3 || $db_row["snum4"] == $eb_snum4 )  {
              
            }
             
                
          }
        }
      }      
    }
    function OLGLottarioGetMonth() {
      
    }
    function OLGLottarioGetYear() {
      
    }
    function OLGLottarioGetAll() {
      
    }
  
  /*
   * Pick3
   * 
   * drawdate
   * idrawnum
   * snum1
   * snum2
   * snum3
   * 
   * return onpick3id
   */
  
      
    function OLGPick3Add($drawdate, $idrawnum, $snum1, $snum2, $snum3 , $drawNo, $sdrawDate, $spielID) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_on_pick3`(`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`");
      if (