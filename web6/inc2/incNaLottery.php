<?php
/*
 * 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.

*/
  include_once("class_db.php");
  class NALottery {
    
     var $db_obj;
     
     var $vstr = 0;
     var $vnum = 1;
     
     var $na649V;
     var $naMaxV;
     
    
    
    /*
     * 
     * 
     * INSERT INTO `dbaLotteries`.`tbl_na_lottomax_wins_loc`
(`namaxwins_locid`,
`namaxwinningid`,
`wamount`,
`wcount`,
`wlocation`)
VALUES
(
{namaxwins_locid: INT},
{namaxwinningid: INT},
{wamount: DOUBLE},
{wcount: INT},
{wlocation: INT}
);
     * 
     * 
     */ 
     
     function dbNaMaxWinLocAdd($naMaxWinningId, $wamount, $wcount, $wlocid, $wnum_m) {
       
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_na_lottomax_wins_loc` (`namaxwinningid`,`wamount`,`wcount`,`wlocid`,`wnum_m`) ");
      $ssql .= sprintf(" VALUES (%u,%u,%u,%u,%u)", $naMaxWinningId, $wamount, $wcount, $wlocid, $wnum_m);
      
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
     }
     
     function dbNaMaxWinLocRemove($namaxwins_locid) {
      
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_na_lottomax_wins_loc` WHERE namaxwins_locid = %u", $namaxwins_locid);
      $this->db_obj->exec($ssql); 
      return $this->db_obj->rows_affected;
     }
     
     function dbNaMaxWinLocModify($namaxwins_locid, $naMaxWinningId, $wamount, $wcount, $wlocation, $wlocid) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("UPDATE `tbl_na_lottomax_wins_loc` ");
        $ssql .= sprintf(" SET `namaxwinningid` = %u,`wamount` = %u,`wcount` = %u,`wlocid` = %u,`wnum_m` = %u", $naMaxWinningId, $wamount, $wcount, $wlocid, $wnum_m);
        $ssql .= sprintf(" WHERE namaxwins_locid = %u", $namaxwins_locid);
        
        $this->db_obj->exec($ssql);
        return $this->db_obj->rows_affected;
     }
     
     function dbNaMaxWinLocGetId($namaxwinningid, $wlocid, $wnum_m) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       
        $ssql = sprintf("SELECT namaxwins_locid FROM tbl_na_lottomax_wins_loc WHERE
                          namaxwinningid = %u AND wlocid = %u AND wnum_m = %u",$namaxwinningid, $wlocid, $wnum_m);
        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res[0]["namaxwins_locid"];
        } else {
          return null;
        }
     }
     
     function dbNaMaxWinLocGet($namaxwins_locid) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
       $ssql = sprintf("SELECT * FROM `tbl_na_lottomax_wins_loc` WHERE namaxwins_locid = %u", $namaxwins_locid);
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res[0];
       } else {
         return null;
       }
     }
     
     function dbNaMaxWinsLocGetId($namaxwinningid, $wlocid) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       
       $ssql = sprintf("SELECT * FROM `tbl_na_lottomax_wins_loc` WHERE namaxwins_locid = %u AND wlocid = %u", $namaxwins_locid, $wlocid);
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res["0"]["namaxwins_locid"];
       } else {
         return null;
       }
     }
     
     /* 
     * 
     * 
INSERT INTO `dbaLotteries`.`tbl_na_649_wins_loc`
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
{wlocation: INT}
);
     */ 
    function dbNa649WinLocAdd($na649winningid, $wamount, $wcount, $wlocid, $wnum_m) {
      
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_na_649_wins_loc` (`na649winningid`,`wamount`,`wcount`,`wlocid`,`wnum_m`) ");
      $ssql .= sprintf(" VALUES (%u,%u,%u,%u,%u);", $na649winningid, $wamount, $wcount, $wlocid, $wnum_m);
      
      $rows_affected= $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
      
    }
    
    function dbNa649WinLocRemove($na649wins_locid) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_na_649_wins_loc` WHERE na649wins_locid = %u", $na649wins_locid);
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    function dbNa649WinLocModify($na649wins_locid, $na649winningid, $wamount, $wcount, $wlocid, $wnum_m) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("UPDATE `tbl_na_649_wins_loc` SET ");
      $ssql .= sprintf(" na649winningid = %u, wamount = %u, wcount = %u, wlocid = %u, wnum_m = %u", $na649winningid, $wamount, $wcount, $wlocid, $wnum_m);
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
      
    }
    
    function dbNa649WinLocGet($na649wins_locid) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_na_649_wins_loc` WHERE na649wins_locid = %u", $na649wins_locid);
      
      $db_result = $this->db_obj->fetch($ssql);
      if (is_array($db_result)) {
        return $db_result[0];
      } else {
        return null;
      }
    }
    
    function dbNa649WinLocGetId($na649winningid, $wlocid, $wnum_m) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_na_649_wins_loc` WHERE na649winningid = %u AND wlocid = %u AND wnum_m = %u", $na649winningid, $wlocid, $wnum_m);
      
      $db_result = $this->db_obj->fetch($ssql);
      if (is_array($db_result)) {
        return $db_result["0"]["na649wins_locid"];
      } else {
        return null;
      }
    }
    /*
     * Lotto 649
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
     * drawNo
     * sdrawDate
     * spielID
     * 
     * 
     * sregion
     * return: na649id
     */ 
     
     
     
    function na649Add($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, $sregion = "", $drawNo ="", $sdrawDate = "", $spielID = "") {
      
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_na_649` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snumbonus`,`region_only` ");
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(", `drawNo`,`sdrawDate`,`spielID`) ");
      } else {
        $ssql .= sprintf(" )");
      }
      
      $ssql .= sprintf("VALUES (%u, '%s', %u, %u, %u, %u, %u, %u, %u, '%s'", $idrawnum, $drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, $sregion);      
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(", %u, %u, %u)", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(" )");
      }
      
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id; 
    }
    
    
    
     /*
     * Lotto 649
     * 
     * drawdate
     * na649id
      * 
     * return: 
     */
    function na649Remove($drawdate, $na649id = "") {
      
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("DELETE FROM `tbl_na_649` WHERE drawdate = '%s' ", $drawdate);
      
      if ($na649id != "") {
        $ssql .= sprintf(" AND idrawnum = %u", $na649id);
      }
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
     
      /*
     * Lotto 649
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
     * sregion
     * return: na649id
     */
     
    function na649Modify($olddrawdate, $newdrawdate = "", $na649id = "", $idrawnum = "", $snum1 = "", $snum2 = "", $snum3 = "", $snum4 = "", $snum5 = "", $snum6 = "", $snumbonus = "", $drawNo = "", $sdrawDate = "", $spielID = "") {
          
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        $ssql = sprintf("UPDATE `tbl_na_649` SET ");
        $ssql .= sprintf("drawdate = '%s'", $olddrawdate);
        if ($idrawnum != "") {
          $ssql .= sprintf(", idrawnum = %u" , $idrawnum);
        }
        $ssql .= sprintf(", snum1 = %u, snum2 = %u, snum3 = %u, snum4 = %u, snum5 = %u, snum6 = %u, snumbonus = %u ", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus);
        $ssql .= sprintf(" WHERE drawdate = '%s' ", $olddrawdate);
        if ($na649id != "") {
          $ssql .= sprintf(" AND na649id = %u", $na649id); 
        }
        $this->db_obj->exec($ssql);
        return $this->db_obj->rows_affected;
    }
    
     function na649GetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_na_649`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_na_649`");
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
    
    
    function na649GetDrawId($drawdate) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_na_649` WHERE ");
        $ssql .= sprintf(" drawdate = '%s' ", $drawdate);
        

        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res["0"]["na649id"];
        } else {
          return null; 
        } 
    }
    
    /*
     * drawdate
     * na649id
     * 
     * return: db result
     */ 
    
    
    function na649GetSingleDraw($drawdate, $na649id = "") {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_na_649` WHERE ");
        $ssql .= sprintf(" drawdate = '%s' ", $drawdate);
        
        if ($na649id != "") {
          $na649id .= sprintf(" AND na649id = %u", $na649id);
        }
        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res[0];
        } else {
          return null; 
        }
    }
    
    function na649GetDraw($st_drawdate, $ed_drawdate, $st_pos = 0, $limit = 350) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_na_649` WHERE drawdate >= '%s' AND drawdate <= '%s'",
                    $st_drawdate, $ed_drawdate, $st_pos, $limit);
        $ssql .= sprintf (" order by drawdate");
        //print $ssql;
        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res;
        } else {
          return null;
        }
    } 
    
    
    function na649ValidateDraw($st_drawdate, $ed_drawdate = "", $snum1 = "", $snum2 = "", $snum3 = "", $snum4 = "", $snum5 = "" , $snum6 = "")
    {
     
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
     
        $ssql = sprintf("
                SELECT `na649winningid`, na_649.`drawdate`, na_649.`na649id`, na_649.*, `m_6_count`, `m_6_amount`, 
                (SELECT prze_amount as m_6_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_6_amount) AS m_6_prze_amt,
                `m_6_region`, `m_5_b_count`, `m_5_b_amount`, 
                (SELECT prze_amount as m_5_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_5_b_amount)  AS m_5_b_prze_amt,
                `m_5_b_region`, `m_5_count`, `m_5_amount`, 
                (SELECT prze_amount as m_5_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_5_amount)  AS m_5_prze_amt, 
                `m_4_count`, `m_4_amount`, 
                (SELECT prze_amount as m_4_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_4_amount)  AS m_4_prze_amt, 
                `m_3_count`, `m_3_amount`, 
                (SELECT prze_amount as m_3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_3_amount)  AS m_3_prze_amt, 
                `m_2_b_count`, `m_2_b_amount`, 
                (SELECT prze_amount as m_2_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_2_b_amount)  AS m_2_b_prze_amt, 
                (SELECT prze_desc as m_2_b_prze_desc FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_2_b_amount)  AS m_2_b_prze_amt_desc,
                (SELECT prze_type as m_2_b_prze_type FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_2_b_amount)  AS m_2_b_prze_amt_type
                FROM `tbl_na_649_winnings` as 649_winning,  `tbl_na_649` as na_649 WHERE 
                649_winning.na649id = na_649.na649id AND na_649.drawdate >= '%s' AND na_649.drawdate <= '%s' ",
                $st_drawdate, $ed_drawdate);
       $ssql .= sprintf(" order by na_649.drawdate");
       
                
        //print "\n<br />SSQL: " . $ssql;
        $imatch_cnt   = 0;
        $ibonus_match = 0;
        $irow_cnt     = 0;
        $smatch_wins  = null;
        
        $scomb_num = array(
                    $snum1, $snum2, $snum3, $snum4, $snum5, $snum6);
        //print_r($scomb_num);
        sort($scomb_num,SORT_ASC);
        $scomb_num = array_unique($scomb_num);
        //print_r($scomb_num);
        if (count($scomb_num) < 6) {
          // some duplicate numbers found ..
        } else {
          $db_data = $this->db_obj->fetch($ssql);
          //print "\n<br />SQL: " . $ssql;
         // print_r($db_data);
          if (is_array($db_data)) {
            $smatch_wins = array();
            foreach ($db_data as $db_row) {
              $imatch_cnt = 0;
              $ibonus_match = 0;
              $smatch_wins[$irow_cnt] = array(
                "drawdate"  => $db_row["drawdate"],
                "match_cnt" => 0,
                "match_numbers" => array(),
                "match_bonus" => 0,
                "match_bonus_num" => 0
              );
              //print_r($smatch_wins);
              
              $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_row["snum1"],$db_row["snum2"],$db_row["snum3"],
                                                              $db_row["snum4"],$db_row["snum5"],$db_row["snum6"]);
              $smatch_wins[$irow_cnt]["draw_bonus"]   = $db_row["snumbonus"];
              if ($db_row["snum1"] == $scomb_num[0] || $db_row["snum1"] == $scomb_num[1] || $db_row["snum1"] == $scomb_num[2] || $db_row["snum1"] == $scomb_num[3] || $db_row["snum1"] == $scomb_num[4] || $db_row["snum1"] == $scomb_num[5] ) {
                $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum1"];
                $imatch_cnt++;
              } 
              if ($db_row["snum2"] == $scomb_num[0] || $db_row["snum2"] == $scomb_num[1] || $db_row["snum2"] == $scomb_num[2] || $db_row["snum2"] == $scomb_num[3] || $db_row["snum2"] == $scomb_num[4] || $db_row["snum2"] == $scomb_num[5] ) {
                 $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum2"];
                $imatch_cnt++;
  
              } 
              if ($db_row["snum3"] == $scomb_num[0] || $db_row["snum3"] == $scomb_num[1] || $db_row["snum3"] == $scomb_num[2] || $db_row["snum3"] == $scomb_num[3] || $db_row["snum3"] == $scomb_num[4] || $db_row["snum3"] == $scomb_num[5]  ) {
                $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum3"];
                $imatch_cnt++;
              } 
              if ($db_row["snum4"] == $scomb_num[0] || $db_row["snum4"] == $scomb_num[1] || $db_row["snum4"] == $scomb_num[2] || $db_row["snum4"] == $scomb_num[3] || $db_row["snum4"] == $scomb_num[4] || $db_row["snum4"] == $scomb_num[5] ) {
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
              if ($db_row["snumbonus"] == $scomb_num[0] || $db_row["snumbonus"] == $scomb_num[1] || $db_row["snumbonus"] == $scomb_num[2] || $db_row["snumbonus"] == $scomb_num[3] || $db_row["snumbonus"] == $scomb_num[4] || $db_row["snumbonus"] == $scomb_num[5] ) {
                 $smatch_wins[$irow_cnt]["match_bonus_num"]             = $db_row["snumbonus"];
                 $smatch_wins[$irow_cnt]["match_bonus"]                 = 1;
                 $ibonus_match                                          = 1;
              }            
              $smatch_wins[$irow_cnt]["match_cnt"] = $imatch_cnt;
              //print "\n After Matching";
              //print_r($smatch_wins);
              
              
              
              if ($imatch_cnt == 6) {
                  //print "\n <br />Testing Match 6 numbers";
                  $db_loc_res = $this->na649WinningGetLocs($db_row['na649winningid']);
                  //print "\n After Test phase 2";
                  //print_r($db_loc_res);
                  if (is_array($db_loc_res)) {
                   foreach ($db_loc_res as $db_6_loc) {
                      if ($db_6_loc["wnum_m"] == 6) {
                        $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_6_loc["win_prze_amt"];
                        if ($db_row["m_6_count"] == 0) {
                          $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 6/6 for the specified draw.";
                        }                      
                      }
                    }
                  } else {
                    $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_6_prze_amt"];
                    $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 6/6 for the specified draw.";
                  }              
              } elseif ($imatch_cnt == 5 && $ibonus_match == 1) {
               
                  
                $db_loc_res = $this->na649WinningGetLocs($db_row['na649winningid']);
                if (is_array($db_loc_res)) {
                  foreach ($db_loc_res as $db_5_b_loc) {
                    if ($db_5_b_loc["wnum_m"] == 5) {
                      $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_5_b_loc["win_prze_amt"];
                       if ($db_row["m_5_b_count"] > 0) {
                           $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 5/6 + bonus for the specified draw.";
                       }
                    }
                    
                  }
                } else {
                  $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 5/6 + bonus for the specified draw.";
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_b_prze_amt"];
                }
              } elseif ($imatch_cnt == 5) {
                $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_prze_amt"];
                
              } elseif ($imatch_cnt == 4) {
                $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_4_prze_amt"];
              } elseif ($imatch_cnt == 3) {
                $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_3_prze_amt"];
              } elseif ($imatch_cnt == 2 && $ibonus_match == 1) {
                $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_2_b_prze_amt"];
              }
              
              //print "\n After Winning Detail";
              //print_r($smatch_wins);
              
              
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
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     */ 
    function na649Validate($startdrawdate, $enddrawdate, $drawdate = "", $snum1 = "", $snum2 = "", $snum3 = "", $snum4 = "", $snum5 = "" , $snum6 = "") {
     
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
      $ssql = sprintf("SELECT * FROM `tbl_na_649` WHERE ");
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
    
    function na649GetMonth() {
      
    }
    
    function na649GetYear() {
      
    }
    
    function na649GetAll() {
      
    }
    
    
    /*
     * 
     * Lotto Max
     * drawnum
     * drawdate
     * sequencenum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snum7
     * snumbonus
     * region - default: na
     * 
     * 
     * return: namaxid
     */
    
    function naMaxAdd($drawdate, $idrawnum = 0, $isequencenum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus, $sregion = "na", $drawNo, $sdrawDate, $spielID) {
        
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
        
      $ssql = sprintf("INSERT INTO `tbl_na_lottomax` (`idrawnum`,`drawdate`,`isequencenum`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snum7`,`snumbonus`,`region_only` ");
    
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(", `drawNo`, `sdrawDate`, `spielID`)");
      } else {
        $ssql .= sprintf(" )");
      }
         
      $ssql .= sprintf(" VALUES (%u , '%s', %u, %u, %u, %u, %u, %u, %u, %u, %u, '%s'", 
      $idrawnum, $drawdate, $isequencenum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus, $sregion);
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(", %u, %u, %u)", $drawNo, $sdrawDate, $spieldID);
      } else {
        $ssql .= ")";
      }
      //print "\nMax  SSQL :" . $ssql;
          
      $rows_affected = $this->db_obj->exec($ssql);
      //print "rows Affected: "  . $rows_affected;
      return $this->db_obj->last_id;
        
    }
    
    /*
     * drawdate
     * namaxid
     * 
     * 
     */ 
    
    function naMaxRemove($drawdate, $namaxid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("DELETE FROM `tbl_na_lottomax` WHERE ");
      $ssql .= sprintf(" drawdate = '%s' ", $drawdate);
      if ($namaxid != "") {
        $ssql .= sprintf(" AND namaxid = %u", $namaxid);
      }

      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;      
    }
    
    /*
     * 
     * Lotto Max
     * idrawnum
     * drawdate
     * sequencenum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snum7
     * snumbonus
     * region - default: na
     * 
     * 
     * return: namaxid
     */
    
    function naMaxModify( $olddrawdate, $newdrawdate, $namaxid = "", $idrawnum = "", $isequencenum = "", $snum1 = "", $snum2 = "", $snum3 = "", $snum4 = "", $snum5 = "", $snum6 = "", $snum7 = "", $snumbonus = "", $sregion = "na", $drawNo, $sdrawDate, $spielID) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE `tbl_na_lottomax` SET ");
      $ssql .= sprintf(" drawdate = '%s', idrawnum = %u, isequencenum = %u, snum1 = %u, snum2 = %u, snum3 = %u, snum4 = %u, snum5 = %u, snum6 = %u, snum7 = %u, snumbonus = %u, region_only = '%s'",$newdrawdate, $idrawnum, $isequencenum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6,$snum7, $sregion);
      
      $ssql .= sprintf(" WHERE drawdate = '%s' ", $olddrawdate);      
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" , `drawNo` = %u, `sdrawDate` = %u, `spielID` = %u", $drawNo, $sdrawDate, $spielID);
      }
      if ($namaxid != "") {
        $ssql .= sprintf(" AND namaxid = %u", $namaxid);
      }
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
       
    }
    
    /*
     * drawdate
     * namaxid
     * 
     * 
     */ 
    
    
    function naMaxGetSingleDraw($drawdate, $iSeqNum = "0") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_na_lottomax` WHERE ");
      $ssql .= sprintf(" drawdate = '%s' ", $drawdate);
     
      $ssql .= sprintf(" AND isequencenum = %u", $iSeqNum);
 
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
    }
    
    function naMaxGetDraw($st_drawdate, $ed_drawdate, $st_pos = 0, $limit = 350) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_na_lottomax` WHERE drawdate >= '%s' AND drawdate <= '%s' ",
                    $st_drawdate, $ed_drawdate, $st_pos, $limit);
      $ssql .= sprintf(" order by drawdate,isequencenum");
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res;
      } else {
        return null;
      }
    }
    
    
    function naMaxGetDrawIdByNum($drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_na_lottomax` WHERE ");
      $ssql .= sprintf("drawdate = '%s' AND snum1 = %u AND snum2 = %u AND snum3 = %u AND snum4 = %u AND snum5 = %u AND snum6 = %u AND snum7 = %u AND snumbonus = %u ",
                    $drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0]["namaxid"];
      } else {
        return null;
      }
    }
    
    
    function naMaxGetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_na_lottomax`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_na_lottomax`");
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
    
    function naMaxGetDrawId($drawdate, $iSeqNum = 0){
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_na_lottomax` WHERE ");
      $ssql .= sprintf(" drawdate = '%s' ", $drawdate);
      $ssql .= sprintf(" AND isequencenum = %u", $iSeqNum);
      
      //print "\n Draw SQL : " . $ssql;
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res["0"]["namaxid"];
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
     * snum7
     * 
     * 
     */ 
    
    function naMaxValidateDraw($st_drawdate, $ed_drawdate, $snum1 = "", $snum2 = "", $snum3 = "", $snum4 = "", $snum5 = "" , $snum6 = "", $snum7 = "")
    {
     
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
     
     /*
     
     Sep 29-2011
     
     (SELECT prze_type as prze_type FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_3_amount) AS m_3_prze_type,
     (SELECT prze_desc as prze_desc FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_3_amount) AS m_3_prze_desc
     
     */
     
     
            $ssql = sprintf("SELECT 
            max_winning.namaxwinningid,
            na_max.`namaxid`,na_max.drawdate, na_max.isequencenum, 
            na_max.snum1,na_max.snum2,na_max.snum3,na_max.snum4,na_max.snum5,na_max.snum6,na_max.snum7,
            na_max.snumbonus,
            `m_7_count`,`m_7_amount`, 
            (SELECT prze_amount as m_7_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_7_amount) AS m_7_prze_amt, 
            `m_6_b_count`,`m_6_b_amount`, 
            (SELECT prze_amount as m_6_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_6_b_amount) AS m_6_b_prze_amt, 
            `m_6_count`,`m_6_amount`, 
            (SELECT prze_amount as m_6_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_6_amount) AS m_6_prze_amt, 
            `m_5_count`,`m_5_amount`, 
            (SELECT prze_amount as m_5_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_5_amount) AS m_5_prze_amt, 
            `m_4_count`,`m_4_amount`,
             (SELECT prze_amount as m_4_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_4_amount) AS m_4_prze_amt, 
             `m_3_b_count`,`m_3_b_amount`, 
             (SELECT prze_amount as m_3_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_3_b_amount) AS m_3_b_prze_amt,
              `m_3_count`,`m_3_amount`, 
              (SELECT prze_amount as m_3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_3_amount) AS m_3_prze_amt ,
              (SELECT prze_type as m_3_prze_type FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_3_amount) AS m_3_prze_type,
     		  (SELECT prze_desc as m_3_prze_desc FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_3_amount) AS m_3_prze_desc
              
              FROM `tbl_na_lottomax_winning` as max_winning,  `tbl_na_lottomax` as na_max WHERE 
                max_winning.namaxid = na_max.namaxid AND na_max.drawdate >= '%s' AND na_max.drawdate <= '%s'",
                $st_drawdate, $ed_drawdate);
        // LIMIT %u, %u",
        $ssql .= sprintf(" order by na_max.drawdate ASC, na_max.isequencenum ASC");
        
        //print "\nSQL: " . $ssql;
        
        $scomb_num      = array(
                          $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7);
                          
        sort($scomb_num, SORT_ASC);
        // $scomb_num      = array_unique($scomb_num);
        //print "\n<br /> Comb Nums: ";
        //print_r($scomb_num);
        $imatch_cnt     = 0;
        $ibonus_match   = 0;
        $irow_cnt       = 0;
        $smatch_wins    = null;
        
        $db_data = $this->db_obj->fetch($ssql);
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
                                                                $db_row["snum4"], $db_row["snum5"], $db_row["snum6"], $db_row["snum7"]);
                                                                
            $smatch_wins[$irow_cnt]["draw_bonus"]   = $db_row["snumbonus"];
            $smatch_wins[$irow_cnt]["isequencenum"] = $db_row["isequencenum"];
            
            
            //print_r($smatch_wins[$irow_cnt]["draw_numbers"]);
            //print_r($scomb_num);
            if ($db_row["snum1"] == $scomb_num[0] || $db_row["snum1"] == $scomb_num[1] || $db_row["snum1"] == $scomb_num[2] || $db_row["snum1"] == $scomb_num[3] || $db_row["snum1"] == $scomb_num[4] || $db_row["snum1"] == $scomb_num[5] || $db_row["snum1"] == $scomb_num[6] ) {
              $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum1"];
              $imatch_cnt++;

            } 
            if ($db_row["snum2"] == $scomb_num[0] || $db_row["snum2"] == $scomb_num[1] || $db_row["snum2"] == $scomb_num[2] || $db_row["snum2"] == $scomb_num[3] || $db_row["snum2"] == $scomb_num[4] || $db_row["snum2"] == $scomb_num[5] || $db_row["snum2"] == $scomb_num[6]) {
              $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum2"];
              $imatch_cnt++;
            } 
            if ($db_row["snum3"] == $scomb_num[0] || $db_row["snum3"] == $scomb_num[1] || $db_row["snum3"] == $scomb_num[2] || $db_row["snum3"] == $scomb_num[3] || $db_row["snum3"] == $scomb_num[4] || $db_row["snum3"] == $scomb_num[5] || $db_row["snum3"] == $scomb_num[6]  ) {
              $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum3"];
              $imatch_cnt++;
            } 
            if ($db_row["snum4"] == $scomb_num[0] || $db_row["snum4"] == $scomb_num[1] || $db_row["snum4"] == $scomb_num[2] || $db_row["snum4"] == $scomb_num[3] || $db_row["snum4"] == $scomb_num[4] || $db_row["snum4"] == $scomb_num[5] || $db_row["snum4"] == $scomb_num[6] ) {
              $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum4"];
              $imatch_cnt++;
            } 
            if ($db_row["snum5"] == $scomb_num[0] || $db_row["snum5"] == $scomb_num[1] || $db_row["snum5"] == $scomb_num[2] || $db_row["snum5"] == $scomb_num[3] || $db_row["snum5"] == $scomb_num[4] || $db_row["snum5"] == $scomb_num[5] || $db_row["snum5"] == $scomb_num[6]  ) {
              $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum5"];
              $imatch_cnt++;
            } 
            if ($db_row["snum6"] == $scomb_num[0] || $db_row["snum6"] == $scomb_num[1] || $db_row["snum6"] == $scomb_num[2] || $db_row["snum6"] == $scomb_num[3] || $db_row["snum6"] == $scomb_num[4] || $db_row["snum6"] == $scomb_num[5] || $db_row["snum6"] == $scomb_num[6]  ) {
              $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum6"];
              $imatch_cnt++;
            } 
            if ($db_row["snum7"] == $scomb_num[0] || $db_row["snum7"] == $scomb_num[1] || $db_row["snum7"] == $scomb_num[2] || $db_row["snum7"] == $scomb_num[3] || $db_row["snum7"] == $scomb_num[4] || $db_row["snum7"] == $scomb_num[5] || $db_row["snum7"] == $scomb_num[6]  ) {
              $smatch_wins[$irow_cnt]["match_numbers"][$imatch_cnt] = $db_row["snum7"];
              $imatch_cnt++;
            } 
  
            if ($db_row["snumbonus"] == $scomb_num[0] || $db_row["snumbonus"] == $scomb_num[1] || $db_row["snumbonus"] == $scomb_num[2] || $db_row["snumbonus"] == $scomb_num[3] || $db_row["snumbonus"] == $scomb_num[4] || $db_row["snumbonus"] == $scomb_num[5] || $db_row["snumbonus"] == $scomb_num[6]  ) {
              $ibonus_match = 1;
              $smatch_wins[$irow_cnt]["match_bonus_num"] = $db_row["snumbonus"];
            }
            if ($db_row["isequencenum"] == 0) {
              if ($imatch_cnt == 7) {
                      
                    $db_loc_res = $this->naMaxWinningGetLocs($db_row['namaxwinningid']);
                  //print "\n After Test phase 2";
                  //print_r($db_loc_res);
                  if (is_array($db_loc_res)) {
                   foreach ($db_loc_res as $db_7_loc) {
                      if ($db_7_loc["wnum_m"] == 7) {
                        $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_7_loc["win_prze_amt"];
                        if ($db_row["m_7_count"] == 0) {
                          $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 7/7 for the specified draw.";
                        }                      
                      }
                    }
                  } else {
                    $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_7_prze_amt"];
                    $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 7/7 for the specified draw.";
                  }              
                  
                
              } elseif ($imatch_cnt == 6 && $ibonus_match == 1) {
                   $db_loc_res = $this->naMaxWinningGetLocs($db_row['namaxwinningid']);
                  //print "\n After Test phase 2";
                  //print_r($db_loc_res);
                  if (is_array($db_loc_res)) {
                   foreach ($db_loc_res as $db_6_loc) {
                      if ($db_6_loc["wnum_m"] == 6) {
                        $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_6_loc["win_prze_amt"];
                        if ($db_row["m_6_count"] == 0) {
                          $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 6/7 + bonus for the specified draw.";
                        }                      
                      }
                    }
                  } else {
                    $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_6_b_prze_amt"];
                    $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 6/7 + bonus for the specified draw.";
                  }   
                
                
              } elseif ($imatch_cnt == 6) {
                $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_6_prze_amt"];
              } elseif ($imatch_cnt == 5) {
                $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_prze_amt"];
              } elseif ($imatch_cnt == 4) {
                $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_4_prze_amt"];
              } elseif ($imatch_cnt == 3 && $ibonus_match == 1) {
                $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_3_b_prze_amt"];
              } elseif ($imatch_cnt == 3) {
                $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_3_prze_amt"];
              }
            } else {
              if ($imatch_cnt == 7) {
                // Max Million win
                $db_loc_res = $this->naMaxWinningGetLocs($db_row['namaxwinningid']);
                //print "\n After Test phase 2";
                //print_r($db_loc_res);
                if (is_array($db_loc_res)) {
                 foreach ($db_loc_res as $db_7_loc) {
                    if ($db_7_loc["wnum_m"] == 7) {
                      $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_7_loc["win_prze_amt"];
                      if ($db_row["m_7_count"] == 0) {
                        $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 7/7 for the specified Maxmillion draw.";
                      }                      
                    }
                  }
                } else {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_7_prze_amt"];
                  $smatch_wins[$irow_cnt]["err_msg"] = "no one matched 7/7 for the specified Maxmillion draw.";
                }   
              
              }
            } 
           $irow_cnt++;
          }

          
        }

      if (is_array($smatch_wins)) {
        return $smatch_wins;
      } else {
        return false;
      }          
      
    }
    
     /*
     * startdrawdate
     * enddrawdate
     * drawdate
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snum7
     * 
     * 
     */ 
    
    function naMaxValidate($startdrawdate, $enddrawdate, $drawdate = "", $snum1 = "", $snum2 = "", $snum3 = "", $snum4 = "", $snum5 = "" , $snum6 = "", $snum7 = "")
    {
     
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
     
        $ssql = sprintf("SELECT * FROM `tbl_na_lottomax` WHERE ");
        $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s'", $startdrawdate, $enddrawdate);
        
        $db_data = $this->db_obj->fetch($ssql);
        
        if (is_array($db_data)) {
          foreach ($db_data as $db_row) {
  
            if ($db_row["snum1"] == $snum1 || $db_row["snum1"] == $snum2 || $db_row["snum1"] == $snum3 || $db_row["snum1"] == $snum4 || $db_row["snum1"] == $snum5 || $db_row["snum1"] == $snum6 || $db_row["snum1"] == $snum7 ) {
              
            } 
            if ($db_row["snum2"] == $snum1 || $db_row["snum2"] == $snum2 || $db_row["snum2"] == $snum3 || $db_row["snum2"] == $snum4 || $db_row["snum2"] == $snum5 || $db_row["snum2"] == $snum6 || $db_row["snum2"] == $snum7) {
              
            } 
            if ($db_row["snum3"] == $snum1 || $db_row["snum3"] == $snum2 || $db_row["snum3"] == $snum3 || $db_row["snum3"] == $snum4 || $db_row["snum3"] == $snum5 || $db_row["snum3"] == $snum6 || $db_row["snum3"] == $snum7  ) {
              
            } 
            if ($db_row["snum4"] == $snum1 || $db_row["snum4"] == $snum2 || $db_row["snum4"] == $snum3 || $db_row["snum4"] == $snum4 || $db_row["snum4"] == $snum5 || $db_row["snum4"] == $snum6 || $db_row["snum4"] == $snum7 ) {
              
            } 
            if ($db_row["snum5"] == $snum1 || $db_row["snum5"] == $snum2 || $db_row["snum5"] == $snum3 || $db_row["snum5"] == $snum4 || $db_row["snum5"] == $snum5 || $db_row["snum5"] == $snum6 || $db_row["snum5"] == $snum7  ) {
              
            } 
            if ($db_row["snum6"] == $snum1 || $db_row["snum6"] == $snum2 || $db_row["snum6"] == $snum3 || $db_row["snum6"] == $snum4 || $db_row["snum6"] == $snum5 || $db_row["snum6"] == $snum6 || $db_row["snum6"] == $snum7  ) {
              
            } 
            if ($db_row["snum7"] == $snum1 || $db_row["snum7"] == $snum2 || $db_row["snum7"] == $snum3 || $db_row["snum7"] == $snum4 || $db_row["snum7"] == $snum5 || $db_row["snum7"] == $snum6 || $db_row["snum7"] == $snum7  ) {
              
            } 
  
            if ($db_row["snumbonus"] == $snum1 || $db_row["snumbonus"] == $snum2 || $db_row["snumbonus"] == $snum3 || $db_row["snumbonus"] == $snum4 || $db_row["snumbonus"] == $snum5 || $db_row["snumbonus"] == $snum6 || $db_row["snumbonus"] == $snum7  ) {
              
            }
            if ($db_row["isequencenum"] != 0) {
              
            }            
          }
        }           
      
    }
    
    
    
    function naMaxGetMonth() {
      
      
    }
    
    function naMaxGetYear() {
      
      
    }
    
    function naMaxGetAll() {
      
    }
    
    /*
     * 
     * Lotto Super 7
     * 
     * drawdate
     * idrawnum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snum7
     * snumbonus
     * region_only -> default 'na'
     * 
     * return: nasuper7id
     * 
     */
    
    function naSuper7Add($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus, $sregion = "na", $drawNo, $sdrawDate, $spielID) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_na_super7` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snum7`,`snumbonus`,`region_only`) ");
      $ssql .= sprintf(" VALUES(%u,'%s', %u, %u, %u, %u, %u, %u, %u, %u, '%s')", $idrawnum, $drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, $sregion);

      $rows_affected = $this->db_obj->exec($ssql); 
      return $this->db_obj->last_id;     
      
    }
    
    /*
     * drawdate
     * nasuper7id
     * 
     * 
     */
    function naSuper7Remove($drawdate, $nasuper7id = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_na_super7` WHERE drawdate = '%s' ", $drawdate);
      if ($nasuper7id != "") {
        $ssql .= sprintf(" AND nasuper7id = %u", $nasuper7id);
      }
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
        
    /*
     * 
     * Lotto Super 7
     * 
     * olddrawdate
     * newdrawdate
     * idrawnum
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snum7
     * snumbonus
     * region_only -> default 'na'
     * 
     * return: nasuper7id
     * 
     */
    
    function naSuper7Modify($olddrawdate, $newdrawdate, $nasuper7id = "", $idrawnum = "", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus, $sregion = "na", $drawNo, $sdrawDate, $spielID) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE `tbl_na_super7` SET ");
      $ssql .= sprintf(" drawdate = '%s', idrawnum = %u, snum1 = %u, snum2 = %u, snum3 = %u, snum4 = %u, snum5 = %u, snum6 = %u, snum7 = %u, snumbonus = %u, sregion_only = '%s'", $drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus, $sregion );
      
      $ssql .= sprintf(" WHERE drawdate = '%s' ", $newdrawdate);
      if ($nasuper7id != "") {
        $ssql .= sprintf(" AND nasuper7id = %u", $nasuper7id);
      }
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    /*
     * drawdate
     * nasuper7id
     * 
     * 
     */
    
    
    function naSuper7GetDraw($drawdate, $nasuper7id) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_na_super7 `");
      $ssql .= sprintf(" WHERE drawdate = '%s' ");
      
      if ($nasuper7id != "") {
        $ssql .= sprintf(" AND nasuper7id = %u" , $nasuper7id);
      }
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
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
     * snum7
     * 
     */ 
    
    function naSuper7ValidateDraw($drawdate, $snum1 = "", $snum2 = "", $snum3 = "", $snum4 = "", $snum5 = "" , $snum6 = "", $snum7 = "" ) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
     
        $ssql = sprintf("SELECT * FROM `tbl_na_super7` WHERE ");
        $ssql .= sprintf(" drawdate = '%s'", $drawdate);
        
        $db_data = $this->db_obj->fetch($ssql);
        
        foreach ($db_data as $db_row) {

          if ($db_row["snum1"] == $snum1 || $db_row["snum1"] == $snum2 || $db_row["snum1"] == $snum3 || $db_row["snum1"] == $snum4 || $db_row["snum1"] == $snum5 || $db_row["snum1"] == $snum6 || $db_row["snum1"] == $snum7 ) {
            
          } 
          if ($db_row["snum2"] == $snum1 || $db_row["snum2"] == $snum2 || $db_row["snum2"] == $snum3 || $db_row["snum2"] == $snum4 || $db_row["snum2"] == $snum5 || $db_row["snum2"] == $snum6 || $db_row["snum2"] == $snum7) {
            
          } 
          if ($db_row["snum3"] == $snum1 || $db_row["snum3"] == $snum2 || $db_row["snum3"] == $snum3 || $db_row["snum3"] == $snum4 || $db_row["snum3"] == $snum5 || $db_row["snum3"] == $snum6 || $db_row["snum3"] == $snum7  ) {
            
          } 
          if ($db_row["snum4"] == $snum1 || $db_row["snum4"] == $snum2 || $db_row["snum4"] == $snum3 || $db_row["snum4"] == $snum4 || $db_row["snum4"] == $snum5 || $db_row["snum4"] == $snum6 || $db_row["snum4"] == $snum7 ) {
            
          } 
          if ($db_row["snum5"] == $snum1 || $db_row["snum5"] == $snum2 || $db_row["snum5"] == $snum3 || $db_row["snum5"] == $snum4 || $db_row["snum5"] == $snum5 || $db_row["snum5"] == $snum6 || $db_row["snum5"] == $snum7  ) {
            
          } 
          if ($db_row["snum6"] == $snum1 || $db_row["snum6"] == $snum2 || $db_row["snum6"] == $snum3 || $db_row["snum6"] == $snum4 || $db_row["snum6"] == $snum5 || $db_row["snum6"] == $snum6 || $db_row["snum6"] == $snum7  ) {
            
          } 
          if ($db_row["snum7"] == $snum1 || $db_row["snum7"] == $snum2 || $db_row["snum7"] == $snum3 || $db_row["snum7"] == $snum4 || $db_row["snum7"] == $snum5 || $db_row["snum7"] == $snum6 || $db_row["snum7"] == $snum7  ) {
            
          } 

          if ($db_row["snumbonus"] == $snum1 || $db_row["snumbonus"] == $snum2 || $db_row["snumbonus"] == $snum3 || $db_row["snumbonus"] == $snum4 || $db_row["snumbonus"] == $snum5 || $db_row["snumbonus"] == $snum6 || $db_row["snumbonus"] == $snum7  ) {
            
          }
                
        }
      
    }
    
    /*
     * startdrawdate
     * enddrawdate
     * drawdate
     * snum1
     * snum2
     * snum3
     * snum4
     * snum5
     * snum6
     * snum7
     * 
     */
    function naSuper7Validate($startdrawdate, $enddrawdate, $drawdate = "", $snum1 = "", $snum2 = "", $snum3 = "", $snum4 = "", $snum5 = "" , $snum6 = "", $snum7 = "" ) {
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
     
        $ssql = sprintf("SELECT * FROM `tbl_na_super7` WHERE ");
        $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s'", $startdrawdate, $enddrawdate);
        
        $db_data = $this->db_obj->fetch($ssql);
        
        foreach ($db_data as $db_row) {

          if ($db_row["snum1"] == $snum1 || $db_row["snum1"] == $snum2 || $db_row["snum1"] == $snum3 || $db_row["snum1"] == $snum4 || $db_row["snum1"] == $snum5 || $db_row["snum1"] == $snum6 || $db_row["snum1"] == $snum7 ) {
            
          } 
          if ($db_row["snum2"] == $snum1 || $db_row["snum2"] == $snum2 || $db_row["snum2"] == $snum3 || $db_row["snum2"] == $snum4 || $db_row["snum2"] == $snum5 || $db_row["snum2"] == $snum6 || $db_row["snum2"] == $snum7) {
            
          } 
          if ($db_row["snum3"] == $snum1 || $db_row["snum3"] == $snum2 || $db_row["snum3"] == $snum3 || $db_row["snum3"] == $snum4 || $db_row["snum3"] == $snum5 || $db_row["snum3"] == $snum6 || $db_row["snum3"] == $snum7  ) {
            
          } 
          if ($db_row["snum4"] == $snum1 || $db_row["snum4"] == $snum2 || $db_row["snum4"] == $snum3 || $db_row["snum4"] == $snum4 || $db_row["snum4"] == $snum5 || $db_row["snum4"] == $snum6 || $db_row["snum4"] == $snum7 ) {
            
          } 
          if ($db_row["snum5"] == $snum1 || $db_row["snum5"] == $snum2 || $db_row["snum5"] == $snum3 || $db_row["snum5"] == $snum4 || $db_row["snum5"] == $snum5 || $db_row["snum5"] == $snum6 || $db_row["snum5"] == $snum7  ) {
            
          } 
          if ($db_row["snum6"] == $snum1 || $db_row["snum6"] == $snum2 || $db_row["snum6"] == $snum3 || $db_row["snum6"] == $snum4 || $db_row["snum6"] == $snum5 || $db_row["snum6"] == $snum6 || $db_row["snum6"] == $snum7  ) {
            
          } 
          if ($db_row["snum7"] == $snum1 || $db_row["snum7"] == $snum2 || $db_row["snum7"] == $snum3 || $db_row["snum7"] == $snum4 || $db_row["snum7"] == $snum5 || $db_row["snum7"] == $snum6 || $db_row["snum7"] == $snum7  ) {
            
          } 

          if ($db_row["snumbonus"] == $snum1 || $db_row["snumbonus"] == $snum2 || $db_row["snumbonus"] == $snum3 || $db_row["snumbonus"] == $snum4 || $db_row["snumbonus"] == $snum5 || $db_row["snumbonus"] == $snum6 || $db_row["snumbonus"] == $snum7  ) {
            
          }
     
        }
           
    }
    
    function naSuper7GetMonth() {
      
    }
    
    function naSuper7GetYear() {
      
      
    }
    
    function naSuper7GetAll() {
      
      
    }
    
    /*
     * INSERT INTO `dbaLotteries`.`tbl_na_649_winnings`
(`na649winningid`,
`na649id`,
`m_6_count`,
`m_6_amount`,
`m_6_region`,
`m_5_b_count`,
`m_5_b_amount`,
`m_5_b_region`,
`m_5_count`,
`m_5_amount`,
`m_4_count`,
`m_4_amount`,
`m_3_count`,
`m_3_amount`,
`m_2_b_count`,
`m_2_b_amount`,
`game_total_sales`)
VALUES
(

{na649id: INT},
{m_6_count: INT},
{m_6_amount: DOUBLE},
{m_5_b_count: INT},
{m_5_b_amount: DOUBLE},
{m_5_count: INT},
{m_5_amount: DOUBLE},
{m_4_count: INT},
{m_4_amount: DOUBLE},
{m_3_count: INT},
{m_3_amount: DOUBLE},
{m_2_b_count: INT},
{m_2_b_amount: DOUBLE},
{game_total_sales: DOUBLE}
);
     * 
     * 
     * return {na649winningid: INT}, 
     * 
     * 
     */
    
    function na649WinningsAdd($na649id, $m_6_count, $m_6_amount, $m_5_b_count, $m_5_b_amount, $m_5_count, $m_5_amount, $m_4_count, $m_4_amount, $m_3_count, $m_3_amount, $m_2_b_count, $m_2_b_amount, $game_total_sales) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      
      $ssql = sprintf("INSERT INTO `tbl_na_649_winnings` (`na649id`,`m_6_count`,`m_6_amount`,`m_5_b_count`,`m_5_b_amount`,`m_5_count`,`m_5_amount`,`m_4_count`,`m_4_amount`,`m_3_count`,`m_3_amount`,`m_2_b_count`,`m_2_b_amount`,`game_total_sales`) ");
      $ssql .= sprintf(" VALUES (%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u)",$na649id, $m_6_count, $m_6_amount, $m_5_b_count, $m_5_b_amount, $m_5_count, $m_5_amount, $m_4_count, $m_4_amount, $m_3_count, $m_3_amount, $m_2_b_count, $m_2_b_amount, $game_total_sales);
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
    }
    
    /*
     * na649winningid
     * 
     * 
     */
    
    function na649WinningsRemove($na649winningid) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      
      $ssql = sprintf("DELETE FROM `tbl_na_649_winnings` WHERE na649winningid = %u", $na649winningid);
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    function na649WinnginsModify($na649winningid, $na649id, $m_6_count, $m_6_amount, $m_5_b_count, $m_5_b_amount, $m_5_count, $m_5_amount, $m_4_count, $m_4_amount, $m_3_count, $m_3_amount, $m_2_b_count, $m_2_b_amount, $game_total_sales) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      
      $ssql = sprintf("UPDATE `tbl_na_649_winnings` SET ");
      $ssql .= sprintf(" `na649id` = %u,`m_6_count` = %u,`m_6_amount` = %u,`m_5_b_count` = %u,`m_5_b_amount` = %u,`m_5_count` = %u,`m_5_amount` = %u,`m_4_count` = %u,`m_4_amount` = %u,`m_3_count` = %u,`m_3_amount` = %u,`m_2_b_count` = %u,`m_2_b_amount` = %u,`game_total_sales` = %u", $na649id, $m_6_count, $m_6_amount, $m_5_b_count, $m_5_b_amount, $m_5_count, $m_5_amount, $m_4_count, $m_4_amount, $m_3_count, $m_3_amount, $m_2_b_count, $m_2_b_amount, $game_total_sales);
      $ssql .= sprintf(" WHERE na649winningid = %u", $na649winningid);
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    function na649WinningsGetSingleDraw($na649winningid) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      
      $ssql = sprintf("SELECT * FROM `tbl_na_649_winnings` WHERE na649winningid = %u", $na649winningid);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
    }
    
    function na649GetDrawWinnings($st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      
        $ssql = sprintf("
        
              SELECT `na649winningid`, na_649.*, na_649.`drawdate`, na_649.`na649id`, `m_6_count`, `m_6_amount`, 
                (SELECT prze_amount as m_6_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_6_amount) AS m_6_prze_amt,
                `m_6_region`, `m_5_b_count`, `m_5_b_amount`, 
                (SELECT prze_amount as m_5_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_5_b_amount)  AS m_5_b_prze_amt,
                `m_5_b_region`, `m_5_count`, `m_5_amount`, 
                (SELECT prze_amount as m_5_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_5_amount)  AS m_5_prze_amt, 
                `m_4_count`, `m_4_amount`, 
                (SELECT prze_amount as m_4_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_4_amount)  AS m_4_prze_amt, 
                `m_3_count`, `m_3_amount`, 
                (SELECT prze_amount as m_3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_3_amount)  AS m_3_prze_amt, 
                `m_2_b_count`, `m_2_b_amount`, 
                (SELECT prze_amount as m_2_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_2_b_amount)  AS m_2_b_prze_amt, 
                (SELECT prze_amount as m_2_b_prze_desc FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 649_winning.m_2_b_amount)  AS m_2_b_prze_amt_desc
                FROM `tbl_na_649_winnings` as 649_winning,  `tbl_na_649` as na_649 WHERE 
                649_winning.na649id = na_649.na649id AND na_649.drawdate >= '%s' AND na_649.drawdate <= '%s' ",
                $st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num);
      $ssql .= sprintf(" order by na_649.drawdate");
      $db_res = $this->db_obj->fetch($ssql);
      //print "SQL: " . $ssql;
      if (is_array($db_res)) {
        return $db_res;
      } else {
        return null;
      }
 
    }

    function na649WinningGetLocs($na649winningid) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }  
        $ssql = sprintf("SELECT `na649wins_locid`, `na649winningid`, `wcount`, `wamount`,
              
               (SELECT prze_amount FROM `tbl_winning_prizes` as win_prze WHERE win_prze.prze_id = na_649_loc.wamount) as win_prze_amt 
              ,(SELECT loc_prov FROM `tbl_lot_win_locations` as win_loc WHERE win_loc.lot_loc_id = na_649_loc.wlocid) as win_loc, 
              `wlocid`, `wnum_m` FROM `tbl_na_649_wins_loc` as na_649_loc WHERE na_649_loc.na649winningid = %u", $na649winningid);

        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res;
        } else {
          return null;
        }
    }
    
    
    function na649WinningsGetId($na649id) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      
      $ssql = sprintf("SELECT * FROM `tbl_na_649_winnings` WHERE na649id = %u", $na649id);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res["0"]["na649winningid"];
      } else {
        return null;
      }
    }
    
    /*
     * INSERT INTO `dbaLotteries`.`tbl_na_lottomax_winning`
(`namaxwinningid`,
`namaxid`,
`m_7_count`,
`m_7_amount`,
`m_7_region`,
`m_6_b_count`,
`m_6_b_amount`,
`m_6_b_region`,
`m_6_count`,
`m_6_amount`,
`m_5_count`,
`m_5_amount`,
`m_4_count`,
`m_4_amount`,
`m_3_b_count`,
`m_3_b_amount`,
`m_3_count`,
`m_3_amount`,
`game_total_sales`)
VALUES
(
{namaxwinningid: INT},
{namaxid: INT},
{m_7_count: INT},
{m_7_amount: DOUBLE},
{m_7_region: VARCHAR},
{m_6_b_count: INT},
{m_6_b_amount: DOUBLE},
{m_6_b_region: VARCHAR},
{m_6_count: INT},
{m_6_amount: DOUBLE},
{m_5_count: INT},
{m_5_amount: DOUBLE},
{m_4_count: INT},
{m_4_amount: DOUBLE},
{m_3_b_count: INT},
{m_3_b_amount: DOUBLE},
{m_3_count: INT},
{m_3_amount: DOUBLE},
{game_total_sales: DOUBLE}
);
     * 
     * return namaxwinningid
     * 
     */
        
    function naMaxWinningsAdd($namaxid,$m_7_count,$m_7_amount,$m_6_b_count,$m_6_b_amount,$m_6_count,$m_6_amount,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_b_count,$m_3_b_amount,$m_3_count,$m_3_amount,$game_total_sales) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      $ssql = sprintf("INSERT INTO `tbl_na_lottomax_winning` 
              (`namaxid`,`m_7_count`,`m_7_amount`,`m_6_b_count`,`m_6_b_amount`,`m_6_count`,`m_6_amount`,`m_5_count`,`m_5_amount`,
              `m_4_count`,`m_4_amount`,`m_3_b_count`,`m_3_b_amount`,`m_3_count`,`m_3_amount`,`game_total_sales`) ");
      $ssql .= sprintf("VALUES (%u,%u,%u,%u,%u,%u,%u,%u,%u,
                      %u,%u,%u,%u,%u,%u,%u)",
               $namaxid,$m_7_count,$m_7_amount,$m_6_b_count,$m_6_b_amount,$m_6_count,$m_6_amount,$m_5_count,$m_5_amount,
               $m_4_count,$m_4_amount,$m_3_b_count,$m_3_b_amount,$m_3_count,$m_3_amount,$game_total_sales);      
      //print "\nMax  SSQL :" . $ssql;
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
    }
    
    /*
     * namaxwinningid
     * 
     * 
     */
    function naMaxWinningsRemove($namaxwinningid) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_na_lottomax_winning` WHERE namaxwinningid = %u", $namaxwinningid);
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    /*
     * INSERT INTO `dbaLotteries`.`tbl_na_lottomax_winning`
(`namaxwinningid`,
`namaxid`,
`m_7_count`,
`m_7_amount`,
`m_7_region`,
`m_6_b_count`,
`m_6_b_amount`,
`m_6_b_region`,
`m_6_count`,
`m_6_amount`,
`m_5_count`,
`m_5_amount`,
`m_4_count`,
`m_4_amount`,
`m_3_b_count`,
`m_3_b_amount`,
`m_3_count`,
`m_3_amount`,
`game_total_sales`)
VALUES
(
{namaxwinningid: INT},
{namaxid: INT},
{m_7_count: INT},
{m_7_amount: DOUBLE},
{m_7_region: VARCHAR},
{m_6_b_count: INT},
{m_6_b_amount: DOUBLE},
{m_6_b_region: VARCHAR},
{m_6_count: INT},
{m_6_amount: DOUBLE},
{m_5_count: INT},
{m_5_amount: DOUBLE},
{m_4_count: INT},
{m_4_amount: DOUBLE},
{m_3_b_count: INT},
{m_3_b_amount: DOUBLE},
{m_3_count: INT},
{m_3_amount: DOUBLE},
{game_total_sales: DOUBLE}
);
     * 
     * 
     * 
     */
    
    function naMaxWinnginsModify($namaxwinningid, $namaxid,$m_7_count,$m_7_amount,$m_6_b_count,$m_6_b_amount,$m_6_count,$m_6_amount,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_b_count,$m_3_b_amount,$m_3_count,$m_3_amount,$game_total_sales) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE `tbl_na_lottomax_winning` SET ");
      $ssql .= sprintf(" `namaxid` = %u,`m_7_count` = %u,`m_7_amount` = %u,`m_6_b_count` = %u,`m_6_b_amount` = %u,`m_6_count` = %u,`m_6_amount` = %u,`m_5_count` = %u,`m_5_amount` = %u,`m_4_count` = %u,`m_4_amount` = %u,`m_3_b_count` = %u,`m_3_b_amount` = %u,`m_3_count` = %u,`m_3_amount` = %u,`game_total_sales` = %u",
       $namaxid,$m_7_count,$m_7_amount,$m_6_b_count,$m_6_b_amount,$m_6_count,$m_6_amount,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_b_count,$m_3_b_amount,$m_3_count,$m_3_amount,$game_total_sales);
      $ssql .= sprintf(" WHERE namaxwinningid = %u", $namaxwinningid); 
      $this->db_obj->execute($ssql);
      return $this->db_obj->rows_affected;
    
    }
    
    function naMaxWinningsGetSingleDraw($namaxid) {
      $ssql = sprintf("SELECT * FROM `tbl_na_lottomax_winning` WHERE `namaxid` = %u", $namaxid);
      
      $db_res = $this->db_obj->fetch($ssql);
      
      if (is_array($db_res)) {
        return $db_res[0];
        
      } else {
        return null;
      }
    }
    
    function naMaxWinningGetLocs($namaxwinningid) {
    if (!$this->db_obj) {
      $this->db_obj = new db();
    }  
    $ssql = sprintf("SELECT `namaxwins_locid`, `namaxwinningid`, `wcount`, `wamount`,
          
           (SELECT prze_amount FROM `tbl_winning_prizes` as win_prze WHERE win_prze.prze_id = na_max_loc.wamount) as win_prze_amt 
          ,(SELECT loc_prov FROM `tbl_lot_win_locations` as win_loc WHERE win_loc.lot_loc_id = na_max_loc.wlocid) as win_loc, 
          `wlocid`, `wnum_m` FROM `tbl_na_lottomax_wins_loc` as na_max_loc WHERE na_max_loc.namaxwinningid = %u", $namaxwinningid);

    $db_res = $this->db_obj->fetch($ssql);
    if (is_array($db_res)) {
      return $db_res;
    } else {
      return null;
    }
    }
    
    
    
    function naMaxWinningsGetDraw($st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num = null) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      
        if ($ed_row_num == null) {
          $ed_row_num = $st_row_num + 200;
        }
        $ssql = sprintf("SELECT 
            max_winning.namaxwinningid,
            na_max.`namaxid`,na_max.drawdate, na_max.isequencenum, 
            na_max.snum1,na_max.snum2,na_max.snum3,na_max.snum4,na_max.snum5,na_max.snum6,na_max.snum7,
            na_max.snumbonus,
            `m_7_count`,`m_7_amount`, 
            (SELECT prze_amount as m_7_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_7_amount) AS m_7_prze_amt, 
            `m_6_b_count`,`m_6_b_amount`, 
            (SELECT prze_amount as m_6_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_6_b_amount) AS m_6_b_prze_amt, 
            `m_6_count`,`m_6_amount`, 
            (SELECT prze_amount as m_6_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_6_amount) AS m_6_prze_amt, 
            `m_5_count`,`m_5_amount`, 
            (SELECT prze_amount as m_5_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_5_amount) AS m_5_prze_amt, 
            `m_4_count`,`m_4_amount`,
             (SELECT prze_amount as m_4_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_4_amount) AS m_4_prze_amt, 
             `m_3_b_count`,`m_3_b_amount`, 
             (SELECT prze_amount as m_3_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_3_b_amount) AS m_3_b_prze_amt,
              `m_3_count`,`m_3_amount`, 
              (SELECT prze_amount as m_3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = max_winning.m_3_amount) AS m_3_prze_amt 
              FROM `tbl_na_lottomax_winning` as max_winning,  `tbl_na_lottomax` as na_max WHERE 
                max_winning.namaxid = na_max.namaxid AND na_max.drawdate >= '%s' AND na_max.drawdate <= '%s'",
                $st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num);
        // LIMIT %u, %u",
        $ssql .= sprintf(" order by na_max.drawdate ASC, na_max.isequencenum ASC");
                
      $db_res = $this->db_obj->fetch($ssql);
      //print "SQL: " . $ssql;
      if (is_array($db_res)) {
        return $db_res;
      } else {
        return null;
      }
 
    }
    
    
    function naMaxWinningsGetId($namaxid) {
      $ssql = sprintf("SELECT * FROM `tbl_na_lottomax_winning` WHERE `namaxid` = %u", $namaxid);
      
      $db_res = $this->db_obj->fetch($ssql);
      //namaxwinningid
      if (is_array($db_res)) {
        //print_r($db_res);
        return $db_res[0]["namaxwinningid"];
        
      } else {
        return null;
      }
    }
    
  }

?>