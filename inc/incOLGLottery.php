
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
     
     
     
     
     
     
     function OLGPick2Add($drawDate, $idrawnum, $snum1, $snum2, $drawNo = "", $sdrawDate = "", $spielID = "", $sdrawTime = "") {
         if (!$this->db_obj) {
             $this->db_obj = new db();
         }
         
         $ssql = sprintf("INSERT INTO `tbl_on_pick2` (`idrawnum`, `drawdate`, `snum1`, `snum2`");
         if ($sdrawTime != "") {
             $ssql .= ", `gameTime`";
         }
         
         if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
             $ssql .= sprintf(" , `drawNo`, `sdrawDate`, `spielID`) ");
         } else {
             $ssql .= sprintf(") ");
         }
         
         $ssql .= sprintf(" VALUES (%u, '%s', %u, %u", $idrawnum, $drawDate, $snum1, $snum2);
         if ($sdrawTime != "") {
             $ssql .= sprintf(", '%s'", $sdrawTime);
         }
        if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
            $ssql .= sprintf(" , %u, %u, %u) ", $drawNo, $sdrawDate, $spielID);
        }  else {
            $ssql .= sprintf(") ");
        }
        print $ssql;
        
        
        $rows_affected = $this->db_obj->exec($ssql);
        //die();
        return $this->db_obj->last_id;
  }
     
     
     function OLGPick2Remove() {
         
     }
     
     function OLGPick2Modify() {
         
     }
     
    function OLGPick2GetSingleDraw() {

    }
     
    function OLGPick2GetDraw() {
        
    }
     
    
    // function OLGPick3GetDrawId($drawdate, $sdrawTime = "") {
    function OLGPick2GetDrawId($drawdate, $sdrawTime = "") {
        
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      if ($sdrawTime != null && $sdrawTime != "") {
      	$ssql = sprintf("SELECT * FROM `tbl_on_pick2` WHERE ");
      	$ssql .= sprintf(" drawdate = '%s' AND gameTime = '%s'", $drawdate, $sdrawTime);
      } else {
      	
	      $ssql = sprintf("SELECT * FROM `tbl_on_pick2` WHERE ");
    	  $ssql .= sprintf(" drawdate = '%s'", $drawdate);
      }
      //print "\n<br />SSQL: " . $ssql;
      $db_data = $this->db_obj->fetch($ssql);
      //print_r($db_data);
      //print $ssql;
     // die();
      if (is_array($db_data)) {
        return $db_data[0]["onpick2id"];
      } else {
        return null;
      }
        
        
        
    }
    
    function OLGPick2ValidateDraw($st_drawdate, $ed_drawdate,  $snum1, $snum2) {
        
        
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
     $ssql = sprintf("
        SELECT tbl_pick3.*,
            `onpick2winningid`,  `m_2_2_count`, `m_2_2_amount`,
            (SELECT prze_amount as m_2_2_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick2_win.m_2_2_amount) AS m_2_2_prze_amt,
       
             `m_f_1_2_count`, `m_f_1_2_amount`,
            (SELECT prze_amount as m_f_1_2_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick2_win.m_f_1_2_amount) AS m_f_1_2_prze_amt 

            FROM `tbl_on_pick2` as tbl_pick2, `tbl_on_pick2_winnings` as tbl_pick2_win 
                WHERE tbl_pick2.onpick2id = tbl_pick2_win.onpick2id AND 
            tbl_pick2.drawdate >= '%s' AND tbl_pick2.drawdate <= '%s'",
          $st_drawdate, $ed_drawdate);
    // print "SSQL: " . $ssql;
     $ssql .= sprintf(" order by tbl_pick2.drawdate");
      $db_data = $this->db_obj->fetch($ssql);
      //print_r($db_data);
      $play_type_st         = 0;
      $play_type_bx         = 1;
      $play_type_any        = 2;
      
      $imatch_cnt     = 0;
      $ibonus_match   = 0;
      $irow_cnt       = 0;
      $ieb_match_cnt  = 0;
      
      $smatch_wins    = null;
      
      $scomb_num      = array($snum1, $snum2);
      
      if (is_array($db_data)) {
          foreach ($db_data as $db_row) {
            
            $imatch_cnt                 = 0;
            $ieb_match_cnt              = 0;
            $ibonus_match               = 0;
            $istraight_match            = 0;
            $smatch_wins[$irow_cnt]     = array(
                "drawdate"                  => $db_row["drawdate"],
                "match_cnt"                 => 0,
                "match_numbers"             => array(),
                "match_bonus"               => 0,
                "match_bonus_num"           => 0,
                "win_prze_box_amount"       => 0,
                "win_prze_straight_amount"  => 0
            );
              
            $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_row["snum1"], $db_row["snum2"]);
                   
            $imatch_cnt = 0;
            
            
            if ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[1]) {
                $imatch_cnt = 2;
                $smatch_wins[$irow_cnt]["match_numbers"][0]         = $db_row["snum1"];
                $smatch_wins[$irow_cnt]["match_numbers"][1]         = $db_row["snum2"];
                $smatch_wins[$irow_cnt]["win_prze_box_amount"]      = $db_row["m_2_2_prze_amt"];
            } else if ($db_row["snum1"] == $scomb_num[0]) {
                $imatch_cnt = 1;
                $smatch_wins[$irow_cnt]["match_numbers"][0]         = $db_row["snum1"];
                $smatch_wins[$irow_cnt]["win_prze_box_amount"]      = $db_row["m_1_2_prze_amt"];
                
            }
             
            $irow_cnt++;
          }
      }
      //print ":: Match_wins: ) ";
      //print_r($smatch_wins);
      if (is_array($smatch_wins)) {
        return $smatch_wins;
      } else {
        return null;
      }
        
        
        
        
    }
     
    function OLGPick2Validate() {
        
    }
    
    
    function OLGOnPick2WinningsGetId($onpick2id) {
    
        if (!$this->db_obj) {
            $this->db_obj = new db();
        }
     
        $ssql = sprintf("SELECT * FROM `tbl_on_pick2_winnings` WHERE onpick2id = %u", $onpick2id);
        print "SSQL: " . $ssql;
        //die();
        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
            return $db_res["0"]["onpick2winningid"];
        } else {
            return null;
        }
        
        
    }
    
   function OLGOnPick2WinningsAdd($onpick2id, $m_2_2_count, $m_2_2_amount, $m_f_1_2_count, $m_f_1_2_amount, $game_total_sales) {
    
        if (!$this->db_obj) {
            $this->db_obj = new db();
        }
       
      $ssql = sprintf("INSERT INTO `tbl_on_pick2_winnings` (`onpick2id`,`m_2_2_count`,`m_2_2_amount`,`m_f_1_2_count`,`m_f_1_2_amount`,`game_total_sales`) ");
      $ssql .= sprintf(" VALUES(%u,%u,%u,%u,%u,%u)", $onpick2id, $m_2_2_count, $m_2_2_amount, $m_f_1_2_count, $m_f_1_2_amount, $game_total_sales);
      $rows_affected = $this->db_obj->exec($ssql);
      
      print "\nSSQL: " . $ssql; 
      return $this->db_obj->last_id;
        
       
   }
    
    function OLGMegaDiceAdd($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, 
            $snumbonus, $drawNo = "", $sdrawDate = "", $spielID = "") {
         
        
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      
  //    INSERT INTO `tbl_on_megadice`(`onmegadiceid`, `sproduct`, `snum1`, `snum2`, `snum3`, `snum4`, `snum5`, `snum6`, `snumbonus`, `drawdate`, `drawNo`, `sdrawDate`, `spielID`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13])
      
      $ssql = sprintf("INSERT INTO `tbl_on_megadice` (`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snumbonus` ");
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "" || $isequencenum != "") {
        $ssql .= sprintf(", `drawNo`,`sdrawDate`,`spielID` ");
        
	  }        
        $ssql .= sprintf(" )");
      
      $ssql .= sprintf(" VALUES ('%s', %u, %u, %u, %u, %u, %u, %u", $drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus);      
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "" || $isequencenum != "") {
        $ssql .= sprintf(", %u, %u, %u", $drawNo, $sdrawDate, $spielID);
        
	  }
      $ssql .= sprintf(" )");
      print "\nSQL: " . $ssql;
      
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id; 
        
        
        
        
        
        
        
    
    }
    
    
    function OLGMegaDiceRemove() {
        
    }
     
    function OLGMegaDiceModify() {
        
    }
    
    function OLGMegaDiceGetSingleDraw() {
        
    }
    
    function OLGMegaDiceGetDraw() {
        
    }
    
    
    function OLGMegaDiceGetDrawId($drawdate) {
    
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_on_megadice` WHERE ");
        $ssql .= sprintf(" drawdate = '%s' ", $drawdate);
        
        
        

        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res["0"]["onmegadiceid"];
        } else {
          return null; 
        } 
        
    }
    
    function OLGMegaDiceValidateDraw($st_drawdate , $ed_drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, $sroll1 = "", $sroll2 = "", $sroll3 = "", $sroll4 = "", $sroll5 = "", $sroll6 = "",$sroll7 = "") {
        
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }

      $ssql = sprintf("
                
            SELECT `onmegadicewinningid`, tbl_on_megadice.*,
                    `m_6_6_d_count`, `m_6_6_d_amount`
                    (SELECT prze_amount as m_6_6_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_6_6_d_amount) as m_6_6_d_prze_amt,
                    `m_5_6_b_d_count`, `m_5_6_b_d_amount`
                    (SELECT prze_amount as m_5_6_b_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_5_6_b_d_amount) as m_5_6_b_d_prze_amt,
                    `m_5_6_d_count`, `m_5_6_d_amount`
                    (SELECT prze_amount as m_5_6_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_5_6_d_amount) as m_5_6_d_prze_amt,
                    `m_4_6_d_count`, `m_4_6_d_amount`
                    (SELECT prze_amount as m_4_6_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_4_6_d_amount) as m_4_6_d_prze_amt,
                    `m_3_6_d_count`, `m_3_6_d_amount`
                    (SELECT prze_amount as m_3_6_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_3_6_d_amount) as m_3_6_d_prze_amt,
                    `m_7k_1s_i_count`, `m_7k_1s_i_amount`
                    (SELECT prze_amount as m_7k_1s_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_7k_1s_i_amount) as m_7k_1s_i_prze_amt,
                    `m_7k_2s_6s_i_count`, `m_7k_2s_6s_i_amount`
                    (SELECT prze_amount as m_7k_2s_6s_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_7k_2s_6s_i_amount) as m_7k_2s_6s_i_prze_amt,
                    `m_6k_i_count`, `m_6k_i_amount`
                    (SELECT prze_amount as m_6k_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_6k_i_amount) as m_6k_i_prze_amt,
                    `m_4k_3k_i_count`, `m_4k_3k_i_amount`
                    (SELECT prze_amount as m_4k_3k_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_4k_3k_i_amount) as m_4k_3k_i_prze_amt,
                    `m_5k_i_count`, `m_5k_i_amount`
                    (SELECT prze_amount as m_5k_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_5k_i_amount) as m_5k_i_prze_amt,
                    `m_3k_3k_i_count`, `m_3k_3k_i_amount`
                    (SELECT prze_amount as m_3k_3k_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_3k_3k_i_amount) as m_3k_3k_i_prze_amt,
                    `m_st_i_count`, `m_st_i_amount`
                    (SELECT prze_amount as m_st_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_megadice_win.m_st_i_amount) as m_st_i_prze_amt
                    
                    FROM `tbl_on_megadice_winnings as tbl_megadice_win, `tbl_on_megadice` as tbl_on_megadice
                    
                    WHERE tbl_megadice_win.onmegadiceid = tbl_on_megadice.onmegadiceid 
                    AND tbl_on_megadice.drawdate >= '%s' AND tbl_on_megadice.drawdate <= '%s'",
                      $st_drawdate, $ed_drawdate);
      
      
      $db_data = $this->db_obj->fetch($ssql);
     
      $imatch_cnt       = 0;
      $irow_cnt         = 0;
      $smatch_wins      = null;
      
      if (!($sroll1 == "" || $sroll2 = "" || $sroll3 = "" || $sroll4 = "" || $sroll5 = "" || $sroll6 = "" || $sroll7 = "")) {
          // if sroll1 .. sroll7 not empty then validate against instant draw
          
          if (is_array($db_data)) {
              $smatch_wins  = array();
              $irow_cnt     = 0;
              
              $instant_win  = null;
              
              $smatch_wins["instant_match"] = array();
              
              if ($sroll1 == 1 && $sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5
                      && $sroll1 == $sroll7) {
                  // instant win of $7500
                  // match seven one's
              } else if ($sroll1 > 1 &&
                      ($sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll6 
                      && $sroll1 == $sroll7)) {
                  // instant win of $1500
                  // match seven (2's to 6's)
              } else if (
                 ($sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll6 ) 
               || ($sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll7 )
               || ($sroll1 == $sroll2 && $sroll1 === $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll6 && $sroll1 = $sroll7 )
               || ($sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll5 && $sroll1 == $sroll6 && $sroll1 == $sroll7)
               || ($sroll1 == $sroll2 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll7 && $sroll1 == $sroll7)
               || ($sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll6 && $sroll1 == $sroll7)
               || ($sroll2 == $sroll3 && $sroll2 == $sroll4 && $sroll1 == $sroll5 && $sroll2 == $sroll6 && $sroll2 == $sroll7)
                ) {
                  // instant win of $100
                  // match 6 of a kind
              } else if (
                 (($sroll1 == $sroll2 && $sroll1 == $sroll3 ) && ($sroll4 == $sroll5 && $sroll4 == $sroll6 && $sroll4 == $sroll7))
                || (($sroll1 == $sroll3 && $sroll1 == $sroll4 ) && ($sroll2 == $sroll5 && $sroll2 == $sroll6 && $sroll2 == $sroll7))
                || (($sroll1 == $sroll2 && $sroll1 == $sroll4 ) && ($sroll3 == $sroll5 && $sroll3 == $sroll6 && $sroll3 == $sroll7))      
                || (($sroll1 == $sroll2 && $sroll1 == $sroll5 ) && ($sroll3 == $sroll6 && $sroll3 == $sroll4 && $sroll3 == $sroll7))
                || (($sroll1 == $sroll2 && $sroll1 == $sroll6 ) && ($sroll3 == $sroll4 && $sroll3 == $sroll5 && $sroll3 == $sroll7))                      
                || (($sroll1 == $sroll2 && $sroll1 == $sroll7 ) && ($sroll3 == $sroll4 && $sroll3 == $sroll5 && $sroll3 == $sroll6))                      
                || (($sroll1 == $sroll3 && $sroll1 == $sroll4 ) && ($sroll2 == $sroll5 && $sroll2 == $sroll6 && $sroll2 == $sroll7))                      
                || (($sroll1 == $sroll3 && $sroll1 == $sroll5 ) && ($sroll2 == $sroll4 && $sroll2 == $sroll6 && $sroll2 == $sroll7))                             
                || (($sroll1 == $sroll3 && $sroll1 == $sroll6 ) && ($sroll2 == $sroll4 && $sroll2 == $sroll5 && $sroll2 == $sroll7))                             
                || (($sroll1 == $sroll3 && $sroll1 == $sroll7 ) && ($sroll2 == $sroll4 && $sroll2 == $sroll5 && $sroll2 == $sroll6)) 
                || (($sroll1 == $sroll4 && $sroll1 == $sroll5 ) && ($sroll2 == $sroll3 && $sroll2 == $sroll6 && $sroll2 == $sroll7)) 
                || (($sroll1 == $sroll4 && $sroll1 == $sroll6 ) && ($sroll2 == $sroll3 && $sroll2 == $sroll5 && $sroll2 == $sroll7)) 
                || (($sroll1 == $sroll4 && $sroll1 == $sroll7 ) && ($sroll2 == $sroll3 && $sroll2 == $sroll5 && $sroll2 == $sroll6))                        
                || (($sroll1 == $sroll5 && $sroll1 == $sroll6 ) && ($sroll2 == $sroll3 && $sroll2 == $sroll4 && $sroll2 == $sroll7))
                || (($sroll1 == $sroll5 && $sroll1 == $sroll7 ) && ($sroll2 == $sroll3 && $sroll2 == $sroll4 && $sroll2 == $sroll6))                      
                || (($sroll1 == $sroll6 && $sroll1 == $sroll7 ) && ($sroll2 == $sroll3 && $sroll2 == $sroll4 && $sroll2 == $sroll5))                      
                || (($sroll2 == $sroll3 && $sroll2 == $sroll4 ) && ($sroll1 == $sroll5 && $sroll1 == $sroll6 && $sroll1 == $sroll7))   
                || (($sroll2 == $sroll3 && $sroll2 == $sroll5 ) && ($sroll1 == $sroll4 && $sroll1 == $sroll6 && $sroll1 == $sroll7))                         
                || (($sroll2 == $sroll3 && $sroll2 == $sroll6 ) && ($sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll7))                         
                || (($sroll2 == $sroll3 && $sroll2 == $sroll7 ) && ($sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll6)) 
                || (($sroll2 == $sroll4 && $sroll2 == $sroll5 ) && ($sroll1 == $sroll3 && $sroll1 == $sroll6 && $sroll1 == $sroll7))
                || (($sroll2 == $sroll4 && $sroll2 == $sroll6 ) && ($sroll1 == $sroll3 && $sroll1 == $sroll5 && $sroll1 == $sroll7))
                || (($sroll2 == $sroll4 && $sroll2 == $sroll7 ) && ($sroll1 == $sroll3 && $sroll1 == $sroll5 && $sroll1 == $sroll6))
                || (($sroll2 == $sroll5 && $sroll2 == $sroll6 ) && ($sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll7))
                || (($sroll2 == $sroll5 && $sroll2 == $sroll7 ) && ($sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll6))                            
                || (($sroll2 == $sroll6 && $sroll2 == $sroll7 ) && ($sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5))    
                || (($sroll3 == $sroll4 && $sroll3 == $sroll5 ) && ($sroll1 == $sroll2 && $sroll1 == $sroll6 && $sroll1 == $sroll7))    
                || (($sroll3 == $sroll4 && $sroll3 == $sroll6 ) && ($sroll1 == $sroll2 && $sroll1 == $sroll5 && $sroll1 == $sroll7))                
                || (($sroll3 == $sroll4 && $sroll3 == $sroll7 ) && ($sroll1 == $sroll2 && $sroll1 == $sroll5 && $sroll1 == $sroll6))                
                || (($sroll3 == $sroll5 && $sroll3 == $sroll6 ) && ($sroll1 == $sroll2 && $sroll1 == $sroll4 && $sroll1 == $sroll7))                       
                || (($sroll3 == $sroll5 && $sroll3 == $sroll7 ) && ($sroll1 == $sroll2 && $sroll1 == $sroll4 && $sroll1 == $sroll6))                      
                || (($sroll3 == $sroll6 && $sroll3 == $sroll7 ) && ($sroll1 == $sroll2 && $sroll1 == $sroll4 && $sroll1 == $sroll5))                       
                || (($sroll4 == $sroll5 && $sroll4 == $sroll6 ) && ($sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll7))                        
                || (($sroll4 == $sroll5 && $sroll4 == $sroll7 ) && ($sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll6))                      
                      
                      ) {
                  // 4 of a kind and 3 of a kind
              } else if (
                  ( ( $sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5 ))
                || (( $sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll6))
                || (( $sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll7))      
                || (( $sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll5 && $sroll1 == $sroll6))      
                || (( $sroll1 == $sroll2 && $sroll1 == $sroll3 && $sroll1 == $sroll5 && $sroll1 == $sroll6))
                || (( $sroll1 == $sroll2 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll6))      
                || (( $sroll1 == $sroll2 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll7))
                || (( $sroll1 == $sroll2 && $sroll1 == $sroll4 && $sroll1 == $sroll6 && $sroll1 == $sroll7))      
                || (( $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll6))
                || (( $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll6))      
                || (( $sroll1 == $sroll3 && $sroll1 == $sroll4 && $sroll1 == $sroll5 && $sroll1 == $sroll7))
                || (( $sroll2 == $sroll3 && $sroll2 == $sroll4 && $sroll2 == $sroll5 && $sroll2 == $sroll7))
                       ) {
                  
                  // match 5 of a kind
                  
              } else if (
                     (( ($sroll1 == $sroll2 && $sroll1 == $sroll3) 
                             && ($sroll4 == $sroll5 && $sroll4 == $sroll6)) 
                      || 
                      ($sroll1 == $sroll2 && $sroll1 == $sroll3) 
                             && ($sroll4 == $sroll5 && $sroll4 == $sroll7)
                      || 
                      ($sroll1 == $sroll2 && $sroll1 == $sroll3) 
                             && ($sroll4 == $sroll6 && $sroll4 == $sroll7)
                     
                      || 
                      ($sroll1 == $sroll2 && $sroll1 == $sroll3) 
                             && ($sroll5 == $sroll6 && $srol5 == $sroll7)
                      
                      ) ||
                     (( ($sroll1 == $sroll2 && $sroll1 == $sroll4) &&
                            ($sroll3 == $sroll5 && $sroll3 == $sroll6) ) 
                       || 
                          ( ($sroll1 == $sroll2 && $sroll1 == $sroll4) &&
                            ($sroll3 == $sroll5 && $sroll3 == $sroll7) )     
                       ||   ( ($sroll1 == $sroll2 && $sroll1 == $sroll4) &&
                            ($sroll3 == $sroll5 && $sroll3 == $sroll7) )           
                       ||   ( ($sroll1 == $sroll2 && $sroll1 == $sroll4) &&
                            ($sroll3 == $sroll6 && $sroll3 == $sroll7) )           
                       ||   ( ($sroll1 == $sroll2 && $sroll1 == $sroll4) &&
                            ($sroll5 == $sroll6 && $sroll5 == $sroll7) )           
                                                                                          
                              ) ||
                     (( ($sroll1 == $sroll2 && $sroll1 == $sroll5) && 
                            ( $sroll4 == $sroll6 && $sroll4 == $sroll7 ) )
                      || 
                     ( ($sroll1 == $sroll2 && $sroll1 == $sroll5) && 
                            ( $sroll3 == $sroll4 && $sroll3 == $sroll6 ) )                 
                      || 
                     ( ($sroll1 == $sroll2 && $sroll1 == $sroll5) && 
                            ( $sroll3 == $sroll4 && $sroll3 == $sroll7 ) )                                      
                      ||
                     ( ($sroll1 == $sroll2 && $sroll1 == $sroll5) && 
                            ( $sroll3 == $sroll6 && $sroll3 == $sroll7 ) )                                      
                                      
                                      
                                      ) ||

                      (( ($sroll1 == $sroll2 && $sroll1 == $sroll6) 
                              && ( $sroll3 == $sroll4 && $sroll3 == $sroll5  )
                              
                              ) 
                        ||
                       ( ($sroll1 == $sroll2 && $sroll1 == $sroll6) 
                              && ( $sroll3 == $sroll4 && $sroll3 == $sroll7  )
                              
                              )                        
                        ||                      
                      ( ($sroll1 == $sroll2 && $sroll1 == $sroll6) 
                              && ( $sroll3 == $sroll5 && $sroll3 == $sroll7  )
                              
                              )                          
                        ||
                      ( ($sroll1 == $sroll2 && $sroll1 == $sroll6) 
                              && ( $sroll4 == $sroll5 && $sroll4 == $sroll7  )
                              
                              )                                               
                       ) ||
                     (( ($sroll1 == $sroll2 && $sroll1 == $sroll7)  && 
                             ( $sroll3 == $sroll4 && $sroll3 == $sroll5 )) 
                      || ( ($sroll1 == $sroll2 && $sroll1 == $sroll7)  && 
                             ( $sroll3 == $sroll4 && $sroll3 == $sroll6 )) 
                      || ( ($sroll1 == $sroll2 && $sroll1 == $sroll7)  && 
                             ( $sroll3 == $sroll5 && $sroll3 == $sroll6 )) 
                      || ( ($sroll1 == $sroll2 && $sroll1 == $sroll7)  && 
                             ( $sroll4 == $sroll5 && $sroll4 == $sroll6 ))                       
                               
                               ) ||
                      
                     (( ($sroll1 == $sroll3 && $sroll1 == $sroll4) 
                             && ($sroll2 == $sroll5 && $sroll2 == $sroll6)
                             ) ||
                      ( ($sroll1 == $sroll3 && $sroll1 == $sroll4) 
                             && ($sroll2 == $sroll6 && $sroll2 == $sroll7)
                             ) ||
                    ( ($sroll1 == $sroll3 && $sroll1 == $sroll4) 
                             && ($sroll2 == $sroll5 && $sroll2 == $sroll7)
                             )                   
                       || 
                       ( ($sroll1 == $sroll3 && $sroll1 == $sroll4) 
                             && ($sroll5 == $sroll6 && $sroll5 == $sroll7)
                             )                
                                       ) ||
                      
                      
                      
                     (( ($sroll1 == $sroll3 && $sroll1 == $sroll5) &&
                            ( $sroll2 == $sroll4 && $sroll2 == $sroll6)
                             )  
                          || 
                     ( ($sroll1 == $sroll3 && $sroll1 == $sroll5) &&
                            ( $sroll2 == $sroll4 && $sroll2 == $sroll7)
                             ) 
                     || ( ($sroll1 == $sroll3 && $sroll1 == $sroll5) &&
                            ( $sroll2 == $sroll6 && $sroll2 == $sroll7)
                             )        
                     || ( ($sroll1 == $sroll3 && $sroll1 == $sroll5) &&
                            ( $sroll4 == $sroll6 && $sroll4 == $sroll7)
                             )
                             ) ||  
                     
                     (  ( ($sroll1 == $sroll3 && $sroll1 == $sroll6) && 
                            ($sroll2 == $sroll4 && $sroll2 == $sroll5) ) 
                       ||
                         ( ($sroll1 == $sroll3 && $sroll1 == $sroll6) && 
                            ($sroll2 == $sroll4 && $sroll2 == $sroll7) )              
                       || 
                          ( ($sroll1 == $sroll3 && $sroll1 == $sroll6) && 
                            ($sroll2 == $sroll5 && $sroll2 == $sroll7) ) 
                       ||
                          ( ($sroll1 == $sroll3 && $sroll1 == $sroll6) && 
                            ($sroll4 == $sroll5 && $sroll4 == $sroll7) )             
                    ) ||                      
                     (( ($sroll1 == $sroll3 && $sroll1 == $sroll7) &&
                            ($sroll2 == $sroll4 && $sroll2 == $sroll5) ) 
                       ||
                      ( ($sroll1 == $sroll3 && $sroll1 == $sroll7) &&
                            ($sroll2 == $sroll4 && $sroll2 == $sroll6) ) 
                       || 
                     ( ($sroll1 == $sroll3 && $sroll1 == $sroll7) &&
                            ($sroll2 == $sroll5 && $sroll2 == $sroll6) )                         
                       || 
                      ( ($sroll1 == $sroll3 && $sroll1 == $sroll7) &&
                            ($sroll4 == $sroll5 && $sroll4 == $sroll6) ) 
                    ) ||  
                      
                     (( ($sroll1 == $sroll4 && $sroll1 == $sroll5) && 
                           ( $sroll2 == $sroll3 && $sroll2 == $sroll6)  ) 
                      ||
                       ( ($sroll1 == $sroll4 && $sroll1 == $sroll5) && 
                           ( $sroll2 == $sroll6 && $sroll2 == $sroll7)  ) 
                      || 
                     ( ($sroll1 == $sroll4 && $sroll1 == $sroll5) && 
                           ( $sroll2 == $sroll3 && $sroll2 == $sroll7)  ) 
                      || 
                     ( ($sroll1 == $sroll4 && $sroll1 == $sroll5) && 
                           ( $sroll3 == $sroll6 && $sroll3 == $sroll7)  ) 
                    ) ||
                      
                      
                     (( ($sroll1 == $sroll4 && $sroll1 == $sroll6) &&
                           ( $sroll2 == $sroll3 && $sroll2 == $sroll5)  
                             ) 
                      || ( ($sroll1 == $sroll4 && $sroll1 == $sroll6) &&
                           ( $sroll2 == $sroll3 && $sroll2 == $sroll7)  
                             ) 
                      || ( ($sroll1 == $sroll4 && $sroll1 == $sroll6) &&
                           ( $sroll2 == $sroll5 && $sroll2 == $sroll7)  
                             ) 
                       || ( ($sroll1 == $sroll4 && $sroll1 == $sroll6) &&
                           ( $sroll3 == $sroll5 && $sroll3 == $sroll7)  
                             )      
                            
                            
                            ) || 
                      
                      
                      
                      
                     (( ($sroll1 == $sroll4 && $sroll1 == $sroll7) &&
                           ($sroll2 == $sroll3 && $sroll2 == $sroll5)
                             ) 
                      ||               
                      ( ($sroll1 == $sroll4 && $sroll1 == $sroll7) &&
                           ($sroll2 == $sroll3 && $sroll2 == $sroll6)
                             ) 
                      || 
                      ( ($sroll1 == $sroll4 && $sroll1 == $sroll7) &&
                           ($sroll2 == $sroll5 && $sroll2 == $sroll6)
                             )               
                      ||
                      ( ($sroll1 == $sroll4 && $sroll1 == $sroll7) &&
                           ($sroll3 == $sroll5 && $sroll3 == $sroll6)
                             ) 
                      ) ||  
                      
                     (( ($sroll1 == $sroll5 && $sroll1 == $sroll6) &&
                             ($sroll2 == $sroll3 && $sroll2 == $sroll4)
                             ) ||
                      ( ($sroll1 == $sroll5 && $sroll1 == $sroll6) &&
                             ($sroll2 == $sroll3 && $sroll2 == $sroll7)
                             )        
                      || 
                      ( ($sroll1 == $sroll5 && $sroll1 == $sroll6) &&
                             ($sroll2 == $sroll4 && $sroll2 == $sroll7)
                             )        
                      || 
                      ( ($sroll1 == $sroll5 && $sroll1 == $sroll6) &&
                             ($sroll3 == $sroll4 && $sroll3 == $sroll7)
                             )        
                              ) || 
                      
                      
                      
                      
                      
                     (( ($sroll1 == $sroll5 && $sroll1 == $sroll7) 
                             && ( $sroll2 == $sroll3 && $sroll2 == $sroll4)
                             
                             )  
                      ||  ( ($sroll1 == $sroll5 && $sroll1 == $sroll7) 
                             && ( $sroll2 == $sroll3 && $sroll2 == $sroll6)
                             
                             ) 
                      || ( ($sroll1 == $sroll5 && $sroll1 == $sroll7) 
                             && ( $sroll2 == $sroll4 && $sroll2 == $sroll6)
                             
                             ) 
                      || ( ($sroll1 == $sroll5 && $sroll1 == $sroll7) 
                             && ( $sroll3 == $sroll4 && $sroll3 == $sroll6)
                             
                             )                ) ||
                      
                     (( ($sroll1 == $sroll6 && $sroll1 == $sroll7) && 
                             ( $sroll2 == $sroll3 && $sroll2 == $sroll4)) ||
                                     
                      ( ($sroll1 == $sroll6 && $sroll1 == $sroll7) && 
                             ( $sroll2 == $sroll3 && $sroll2 == $sroll5)) ||
                       ( ($sroll1 == $sroll6 && $sroll1 == $sroll7) && 
                             ( $sroll2 == $sroll4 && $sroll2 == $sroll4))  || 
                     ( ($sroll1 == $sroll6 && $sroll1 == $sroll7) && 
                             ( $sroll3 == $sroll4 && $sroll3 == $sroll5))                
                                     
                                     
                                     ) ||                        
                      
                      
                      
                      
                     (( ($sroll2 == $sroll3 && $sroll2 == $sroll4) &&
                             ($sroll1 == $sroll5 && $sroll1 == $sroll6)) || 
                       ( ($sroll2 == $sroll3 && $sroll2 == $sroll4) &&
                             ($sroll1 == $sroll5 && $sroll1 == $sroll7)) || 
                       ( ($sroll2 == $sroll3 && $sroll2 == $sroll4) &&
                             ($sroll1 == $sroll6 && $sroll1 == $sroll7))  || 
                       ( ($sroll2 == $sroll3 && $sroll2 == $sroll4) &&
                             ($sroll5 == $sroll6 && $sroll5 == $sroll7))  ) ||  
                     (( ($sroll2 == $sroll3 && $sroll2 == $sroll5) &&
                           ($sroll1 == $sroll4 && $sroll1 == $sroll6)  ) ||
                        ( ($sroll2 == $sroll3 && $sroll2 == $sroll5) &&
                           ($sroll1 == $sroll4 && $sroll1 == $sroll7)  )  ||             
                        ( ($sroll2 == $sroll3 && $sroll2 == $sroll5) &&
                           ($sroll1 == $sroll6 && $sroll1 == $sroll6)  ) ||
                          ( ($sroll2 == $sroll3 && $sroll2 == $sroll5) &&
                           ($sroll4 == $sroll6 && $sroll4 == $sroll7)  )            
                                     ) ||                      
                     (( ($sroll2 == $sroll3 && $sroll2 == $sroll6) &&
                             ($sroll1 == $sroll4 && $sroll1 == $sroll5) ) ||
                         ( ($sroll2 == $sroll3 && $sroll2 == $sroll6) &&
                             ($sroll1 == $sroll5 && $sroll1 == $sroll7) ) || 
                         ( ($sroll2 == $sroll3 && $sroll2 == $sroll6) &&
                             ($sroll1 == $sroll4 && $sroll1 == $sroll7) ) || 
                           ( ($sroll2 == $sroll3 && $sroll2 == $sroll6) &&
                             ($sroll4 == $sroll5 && $sroll4 == $sroll7) )                   
                                             ) || 
                      
                      
                      
                      
                     (( ($sroll2 == $sroll3 && $sroll2 == $sroll7) &&
                             ($sroll1 == $sroll4 && $sroll1 == $sroll5)) || 
                      ( ($sroll2 == $sroll3 && $sroll2 == $sroll7) &&
                             ($sroll1 == $sroll4 && $sroll1 == $sroll6)) ||
                       ( ($sroll2 == $sroll3 && $sroll2 == $sroll7) &&
                             ($sroll1 == $sroll5 && $sroll1 == $sroll6)) ||
                      ( ($sroll2 == $sroll3 && $sroll2 == $sroll7) &&
                             ($sroll4 == $sroll5 && $sroll4 == $sroll6))                               
                                                     ) ||
                      
                     (( ($sroll3 == $sroll4 && $sroll3 == $sroll5) &&
                             ($sroll1 == $sroll2 && $sroll1 == $sroll6) ) ||
                      ( ($sroll3 == $sroll4 && $sroll3 == $sroll5) &&
                             ($sroll1 == $sroll2 && $sroll1 == $sroll7) ) ||
                     ( ($sroll3 == $sroll4 && $sroll3 == $sroll5) &&
                             ($sroll1 == $sroll6 && $sroll1 == $sroll7) ) ||
                     ( ($sroll3 == $sroll4 && $sroll3 == $sroll5) &&
                             ($sroll2 == $sroll6 && $sroll2 == $sroll7) )) ||
                      
                     (( ($sroll3 == $sroll4 && $sroll3 == $sroll6) && 
                             ($sroll1 == $sroll2 && $sroll1 == $sroll5)) ||
                      ( ($sroll3 == $sroll4 && $sroll3 == $sroll6) && 
                             ($sroll1 == $sroll5 && $sroll1 == $sroll7)) ||
                      ( ($sroll3 == $sroll4 && $sroll3 == $sroll6) && 
                             ($sroll1 == $sroll2 && $sroll1 == $sroll7)) || 
                      ( ($sroll3 == $sroll4 && $sroll3 == $sroll6) && 
                             ($sroll2 == $sroll5 && $sroll2 == $sroll7))  ) ||
                      
                     (( ($sroll3 == $sroll4 && $sroll3 == $sroll7) && 
                             ($sroll1 == $sroll2 && $sroll1 == $sroll5) ) || 
                     ( ($sroll3 == $sroll4 && $sroll3 == $sroll7) && 
                             ($sroll1 == $sroll2 && $sroll1 == $sroll6) ) ||
                     ( ($sroll3 == $sroll4 && $sroll3 == $sroll7) && 
                             ($sroll1 == $sroll5 && $sroll1 == $sroll6) ) || 
                     ( ($sroll3 == $sroll4 && $sroll3 == $sroll7) && 
                             ($sroll2 == $sroll5 && $sroll2 == $sroll6) )) ||                         
                      
                     (( ($sroll4 == $sroll5 && $sroll4 == $sroll6) && 
                            ($sroll1 == $sroll2 && $sroll1 == $sroll3) ) || 
                       ( ($sroll4 == $sroll5 && $sroll4 == $sroll6) && 
                            ($sroll1 == $sroll3 && $sroll1 == $sroll7) ) ||
                       ( ($sroll4 == $sroll5 && $sroll4 == $sroll6) && 
                            ($sroll1 == $sroll2 && $sroll1 == $sroll7) ) || 
                       ( ($sroll4 == $sroll5 && $sroll4 == $sroll6) && 
                            ($sroll2 == $sroll3 && $sroll2 == $sroll7) )  ) ||
                      
                      
                     (( ($sroll4 == $sroll5 && $sroll4 == $sroll7) && 
                             ($sroll1 == $sroll2 && $sroll1 == $sroll3)) ||
                       (( ($sroll4 == $sroll5 && $sroll4 == $sroll7) && 
                             ($sroll1 == $sroll2 && $sroll1 == $sroll6))) || 
                       ( ($sroll4 == $sroll5 && $sroll4 == $sroll7) && 
                             ($sroll1 == $sroll3 && $sroll1 == $sroll6)) || 
                      ( ($sroll4 == $sroll5 && $sroll4 == $sroll7) && 
                             ($sroll2 == $sroll3 && $sroll2 == $sroll7))  ) ||   
                      
                     (( ($sroll5 == $sroll6 && $sroll5 == $sroll7) && 
                             ($sroll1 == $sroll2 && $sroll1 == $sroll3)) ||
                       ( ($sroll5 == $sroll6 && $sroll5 == $sroll7) && 
                             ($sroll1 == $sroll2 && $sroll1 == $sroll4)) || 
                       ( ($sroll5 == $sroll6 && $sroll5 == $sroll7) && 
                            ($sroll1 == $sroll3 && $sroll1 == $sroll4)) ||
                       ( ($sroll5 == $sroll6 && $sroll5 == $sroll7) && 
                             ($sroll2 == $sroll3 && $sroll2 == $sroll4)) )                         
                      ) {
                  
                  // match 3 of a kind && 3 of a kind
                  
              } else if (
                   ( ( ($sroll1 == $sroll2 ) && ($sroll3 == $sroll4 && $sroll3 == $sroll5) ) ||
                    ( ($sroll1 == $sroll2 ) && ($sroll3 == $sroll4 && $sroll3 == $sroll6) ) ||
                    ( ($sroll1 == $sroll2 ) && ($sroll3 == $sroll4 && $sroll3 == $sroll7) ) ||             
                    ( ($sroll1 == $sroll2 ) && ($sroll3 == $sroll5 && $sroll3 == $sroll6) ) ||                      
                    ( ($sroll1 == $sroll2 ) && ($sroll3 == $sroll5 && $sroll3 == $sroll7) ) ||
                    ( ($sroll1 == $sroll2 ) && ($sroll3 == $sroll6 && $sroll3 == $sroll7) ) ||                      
                    ( ($sroll1 == $sroll2 ) && ($sroll4 == $sroll5 && $sroll4 == $sroll6) ) ||                      
                    ( ($sroll1 == $sroll2 ) && ($sroll4 == $sroll5 && $sroll4 == $sroll7) ) ||
                    ( ($sroll1 == $sroll2 ) && ($sroll4 == $sroll6 && $sroll4 == $sroll7) ) ||                      
                    ( ($sroll1 == $sroll2 ) && ($sroll5 == $sroll6 && $sroll5 == $sroll7) )                      
                      ) 
                      ||
                   ( ($sroll1 == $sroll3 ) && ($sroll2 == $sroll4 && $sroll2 == $sroll5) ) ||
                    ( ($sroll1 == $sroll3 ) && ($sroll2 == $sroll4 && $sroll2 == $sroll6) ) ||
                    ( ($sroll1 == $sroll3 ) && ($sroll2 == $sroll4 && $sroll2 == $sroll7) ) ||             
                    ( ($sroll1 == $sroll3 ) && ($sroll2 == $sroll5 && $sroll2 == $sroll6) ) ||                      
                    ( ($sroll1 == $sroll3 ) && ($sroll2 == $sroll5 && $sroll2 == $sroll7) ) ||
                    ( ($sroll1 == $sroll3 ) && ($sroll2 == $sroll6 && $sroll2 == $sroll7) ) ||                      
                    ( ($sroll1 == $sroll3 ) && ($sroll4 == $sroll5 && $sroll4 == $sroll6) ) ||                      
                    ( ($sroll1 == $sroll3 ) && ($sroll4 == $sroll5 && $sroll4 == $sroll7) ) ||
                    ( ($sroll1 == $sroll3 ) && ($sroll4 == $sroll6 && $sroll4 == $sroll7) ) ||                      
                    ( ($sroll1 == $sroll3 ) && ($sroll5 == $sroll6 && $sroll5 == $sroll7) )                      
                      ) 
                      ||   
                      
                      
                      
                      ) {
                  
              }
                      
              
              
          }
          
      }
      
      
      
      
      //print_r($spokerCards);
      if (count($spokerCards) < 5) {
        // duplicate cards found...
      } else {
          if (is_array($db_data)) {
              $smatch_wins      = array();
              $irow_cnt         = 0;
              
              $instant_win      = null;
              // Instant Poker Validation
                
                // 
                
                
                
                // Royal Flush  
                
                
                // Straight Flush  
                // 4 of a Kind 
                // Full House  
                // Flush Straight  
                // 3 of a Kind 
                // 2 Pair  Pair of Jacks or Better
              
              //
              
           
              
              $smatch_wins["instant_match"] = array();
              
              
              if ($snum1 == 1 && $snum1 == $snum2 && $snum1 == $snum3 && $snum1 == $snum4 && $snum1 == $snum5
                      && $snum1 == $snum6 && $snum1 == $snumbonus) {
                  // match 7 One's
                  
              } elseif ($snum1 > 1 &&
                 $snum1 == $snum2 && $snum1 == $snum3 && $snum1 == $snum4 && $snum1 == $snum5 && $snum1 == $snum6 && $snum1 == $snum7 ) {
                  // match 7 (2's to 6's)
                 
                  
                  /*
                  * [1,2,3,4,5,6]
                  * [1,2,3,4,5,7]
                  * [1,2,3,5,6,7]
                  * [1,2,4,5,6,7]
                  * [1,3,4,5,6,7]
                  * [2,3,4,5,6,7]
                  * [2,4,5,6,7,1]
                  * [2,3,5,6,7,1]
                  * [2,3,4,6,7,1]
                  * 
                  * 
                  */
              } elseif (
                 
                      
                      ($snum1 == $snum2 && $snum1 == $snum3 && $snum1 == $snum4 && $snum1 == $snum5 && $snum1 == $snum6) ||
                        ($snum1 == $snum2 && $snum1 == $snum3 && $snum1 == $snum4 && $snum1 == $snum5 && $snum1 == $snumbonus) 
                      
                      ) {
                  
                  
              } elseif (
                  (($snum1 == $snum2 && $snum1 == $snum3 && $snum1 == $snum4) && ($snum5 == $snum6 && $snum5 == $snumbonus)) ||
                  (($snum1 == $snum2 && $snum1 == $snum3 && $snum1 == $snum5) && ($snum4 == $snum6 && $snum4 == $snumbonus)) ||
                  (($snum1 == $snum2 && $snum1 == $snum3 && $snum1 == $snum6) && ($snum4 == $snum5 && $snum4 == $snumbonus)) ||
                  (($snum1 == $snum2 && $snum1 == $snum3 && $snum1 == $snumbonus) && ($snum4 == $snum5 && $snum4 == $snum6)) ||
                      
                  (($snum2 == $snum3 && $snum2 == $snum4 && $snum2 == $snum5) && ($snum1 == $snum6 && $snum1 == $snumbonus)) ||
                  (($snum2 == $snum4 && $snum2 == $snum5 && $snum2 == $snum6) && ($snum1 == $snumbonus && $snum1 == $snum3)) ||
                  (($snum2 == $snum4 && $snum2 == $snum6 && $snum2 == $snumbonus ) && ($snum))) {
                  
                  }
                      
              // Royal Flush
              if (
                    ($spokerCards[0][1] == $spokerCards[1][1] &&
                    $spokerCards[1][1] == $spokerCards[2][1] &&
                    $spokerCards[2][1] == $spokerCards[3][1] &&
                    $spokerCards[3][1] == $spokerCards[4][1]
                    ) &&
                    (
                    $spokerCards[0][0] == 9 && $spokerCards[1][0] == 10 &&
                    $spokerCards[2][0] == 11 && $spokerCards[3][0] == 12 && 
                    $spokerCards[4][0] == 13
                    )
                ) 
                {
                  // Royal Flush
                  $instant_win = "rf";
                  $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                  $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                  $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                  $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                  $smatch_wins["instant_match"][4] = $spokerCards[4][2];
                  
                  
              } elseif (
              
                  // Straight Flush
                  ($spokerCards[0][1] == $spokerCards[1][1] && 
                  $spokerCards[1][1] == $spokerCards[2][1] && 
                  $spokerCards[2][1] == $spokerCards[3][1] &&
                  $spokerCards[3][1] == $spokerCards[4][1] ) && 
                  ((    // 6 - 7 - 8 - 9 - 10
                  $spokerCards[0][0] == ($spokerCards[1][0] - 1) &&
                  $spokerCards[1][0] == ($spokerCards[2][0] - 1) &&
                  $spokerCards[2][0] == ($spokerCards[3][0] - 1) &&
                  $spokerCards[3][0] == ($spokerCards[4][0] - 1) 
                  ) || 
                  (    // A - 2 - 3 - 4 - 5
                  $spokerCards[4][0] == 13 && 
                  $spokerCards[0][0] == ($spokerCards[1][0] - 1) &&
                  $spokerCards[1][0] == ($spokerCards[2][0] - 1) &&
                  $spokerCards[2][0] == ($spokerCards[3][0] - 1)
                  ) 
                  )
                  ) {
                   // 10 - 9 - 8 - 7 - 6 
                   $instant_win = "sf";
                   if ($spokerCards[4][0] == 13) {
                     $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                     $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                     $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                     $smatch_wins["instant_match"][3] = $spokerCards[2][2];
                     $smatch_wins["instant_match"][4] = $spokerCards[3][2];                     
                   } else {
                     $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                     $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                     $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                     $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                     $smatch_wins["instant_match"][4] = $spokerCards[4][2];   
                   }

                   
                   
                  } elseif ( // 10 - 10 - 10 - 10 - 8
                  ( // Four of a kind
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0])
                  ||
                  (
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[4][0])                  
                  ||
                  (
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[4][0])
                  || 
                  (
                  $spokerCards[0][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[4][0])
                  ||
                  (
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0])
                  ||
                  (
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[4][0])
                  ) {
                    $instant_win = "4k";
                      if (
                       ( // Four of a kind
                          $spokerCards[0][0] == $spokerCards[1][0] &&
                          $spokerCards[1][0] == $spokerCards[2][0] &&
                          $spokerCards[2][0] == $spokerCards[3][0]) ) {
                          
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                      } elseif (
                          $spokerCards[0][0] == $spokerCards[1][0] &&
                          $spokerCards[1][0] == $spokerCards[2][0] &&
                          $spokerCards[2][0] == $spokerCards[4][0]) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][3] = $spokerCards[4][2];
                      } elseif (
                        $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[1][0] == $spokerCards[3][0] &&
                        $spokerCards[3][0] == $spokerCards[4][0]) {
                       $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                       $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                       $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                       $smatch_wins["instant_match"][3] = $spokerCards[4][2];                          
                      } elseif (
                        $spokerCards[0][0] == $spokerCards[2][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0] &&
                        $spokerCards[3][0] == $spokerCards[4][0]) {
                         $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                         $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                         $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                         $smatch_wins["instant_match"][3] = $spokerCards[4][2];  
                      } elseif (
                        $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[1][0] == $spokerCards[2][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0]) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][3] = $spokerCards[3][2];  
                      } elseif  (
                        $spokerCards[1][0] == $spokerCards[2][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0] &&
                        $spokerCards[3][0] == $spokerCards[4][0]) {
                         $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                         $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                         $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                         $smatch_wins["instant_match"][3] = $spokerCards[4][2];   
                     }



                    
                  } elseif (
                  //full house
                  ((
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0]
                  ) && ($spokerCards[3][0] == $spokerCards[4][0]))
                  || 
                  ((
                  $spokerCards[4][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0]
                  ) && ($spokerCards[3][0] == $spokerCards[0][0]))
                  ||
                  (
                  (
                  $spokerCards[0][0] == $spokerCards[4][0] &&
                  $spokerCards[4][0] == $spokerCards[2][0]
                  ) && ($spokerCards[3][0] == $spokerCards[1][0]))
                  ||
                  (
                  (
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[4][0]
                  ) && ($spokerCards[3][0] == $spokerCards[2][0]))
                  ||
                  (
                  (
                  $spokerCards[3][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0]
                  ) && ($spokerCards[0][0] == $spokerCards[4][0]))
                  ||
                  ((
                  $spokerCards[0][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[2][0]
                  ) && ($spokerCards[1][0] == $spokerCards[4][0]))
                  ||
                  ((
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[3][0]
                  ) && ($spokerCards[2][0] == $spokerCards[4][0]))
                  || (
                  (
                  $spokerCards[3][0] == $spokerCards[4][0] &&
                  $spokerCards[4][0] == $spokerCards[2][0]
                  ) && ($spokerCards[0][0] == $spokerCards[1][0]))
                  || ((
                  $spokerCards[3][0] == $spokerCards[4][0] &&
                  $spokerCards[4][0] == $spokerCards[1][0]
                  ) && ($spokerCards[0][0] == $spokerCards[2][0]))
                  || ((
                  $spokerCards[3][0] == $spokerCards[4][0] &&
                  $spokerCards[4][0] == $spokerCards[0][0]
                  ) && ($spokerCards[1][0] == $spokerCards[2][0])) 
                  ) {
                    $instant_win = "fh";
                    
                    if (($spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[1][0] == $spokerCards[2][0]
                        ) && ($spokerCards[3][0] == $spokerCards[4][0])) {
                          $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                          $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                          $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                          $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                          $smatch_wins["instant_match"][4] = $spokerCards[4][2];
                          
                     } elseif (($spokerCards[4][0] == $spokerCards[1][0] &&
                              $spokerCards[1][0] == $spokerCards[2][0]
                              ) && ($spokerCards[3][0] == $spokerCards[0][0])) {
                          $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                          $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                          $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                          $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                          $smatch_wins["instant_match"][4] = $spokerCards[0][2];      
                                
                     } elseif (
                            (
                            $spokerCards[0][0] == $spokerCards[4][0] &&
                            $spokerCards[4][0] == $spokerCards[2][0]
                            ) && ($spokerCards[3][0] == $spokerCards[1][0])) {
                              
                            $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                            $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                            $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                            $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                            $smatch_wins["instant_match"][4] = $spokerCards[1][2];    
                            }
                        
                  
                  
                  
                  } elseif (
                  // flush
                  // five cards all in same suit
                  ($spokerCards[0][1] == $spokerCards[1][1] &&
                  $spokerCards[1][1] == $spokerCards[2][1] &&
                  $spokerCards[2][1] == $spokerCards[3][1] &&
                  $spokerCards[3][1] == $spokerCards[4][1]))
                  {
                    $instant_win = "f";
                    $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                    $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                    $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                    $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                    $smatch_wins["instant_match"][4] = $spokerCards[4][2];    
                    
                  } elseif (
                  // straight
                  (    // 6 - 7 - 8 - 9 - 10
                  $spokerCards[0][0] == ($spokerCards[1][0] - 1) &&
                  $spokerCards[1][0] == ($spokerCards[2][0] - 1) &&
                  $spokerCards[2][0] == ($spokerCards[3][0] - 1) &&
                  $spokerCards[3][0] == ($spokerCards[4][0] - 1) 
                  ) || 
                  (    // A - 2 - 3 - 4 - 5
                  $spokerCards[4][0] == 13 && 
                  $spokerCards[0][0] == ($spokerCards[1][0] - 1) &&
                  $spokerCards[1][0] == ($spokerCards[2][0] - 1) &&
                  $spokerCards[2][0] == ($spokerCards[3][0] - 1)
                  ) 
                  
                  ) {
                    $instant_win = "s";
                    if ($spokerCards[4][0] == 13) {
                      $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                      $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                      $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                      $smatch_wins["instant_match"][3] = $spokerCards[2][2];
                      $smatch_wins["instant_match"][4] = $spokerCards[3][2];  
                    } else {
                      $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                      $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                      $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                      $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                      $smatch_wins["instant_match"][4] = $spokerCards[4][2];  
                    }
                    
                  } elseif (
                  // three of a kind
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0]
                  ) || 
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[4][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[4][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[4][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[2][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[4][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[3][0] == $spokerCards[0][0] &&
                  $spokerCards[0][0] == $spokerCards[4][0]
                  ) || 
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[3][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[4][0]
                  )
                  
                  
                  ) {
                    $instant_win = "3k";
                    
                    if ( //9C - 9D - 9H - 6C - 2H
                        $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[1][0] == $spokerCards[2][0]
                        ) {
                            $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                            $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                            $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                        } elseif   
                          ( //9C - 9D - 9H - 6C - 2H
                          $spokerCards[0][0] == $spokerCards[1][0] &&
                          $spokerCards[1][0] == $spokerCards[3][0]
                          ) {
                            $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                            $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                            $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                                  
                          } elseif 
                            ( //9C - 9D - 9H - 6C - 2H
                            $spokerCards[0][0] == $spokerCards[1][0] &&
                            $spokerCards[1][0] == $spokerCards[4][0]
                            ) {
                              $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                              $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                              $smatch_wins["instant_match"][2] = $spokerCards[4][2];
                              
                            } elseif  ( //9C - 9D - 9H - 6C - 2H
                              $spokerCards[0][0] == $spokerCards[2][0] &&
                              $spokerCards[2][0] == $spokerCards[3][0]
                              ) {
                                    $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                                    $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                                    $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                              } elseif 
                            ( //9C - 9D - 9H - 6C - 2H
                            $spokerCards[0][0] == $spokerCards[2][0] &&
                            $spokerCards[2][0] == $spokerCards[4][0]
                            ) {
                                $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                                $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                                $smatch_wins["instant_match"][2] = $spokerCards[4][2];

                            } elseif 
                            ( //9C - 9D - 9H - 6C - 2H
                            $spokerCards[1][0] == $spokerCards[2][0] &&
                            $spokerCards[2][0] == $spokerCards[3][0]
                            ) {
                                $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                                $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                                $smatch_wins["instant_match"][2] = $spokerCards[3][2];

                            } elseif 
                              ( //9C - 9D - 9H - 6C - 2H
                              $spokerCards[1][0] == $spokerCards[2][0] &&
                              $spokerCards[2][0] == $spokerCards[4][0]
                              ) {
                                  $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                                  $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                                  $smatch_wins["instant_match"][2] = $spokerCards[4][2];

                                
                              } elseif 
                                  ( //9C - 9D - 9H - 6C - 2H
                                  $spokerCards[2][0] == $spokerCards[3][0] &&
                                  $spokerCards[3][0] == $spokerCards[4][0]
                                  ) {
                                  $smatch_wins["instant_match"][0] = $spokerCards[2][2];
                                  $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                                  $smatch_wins["instant_match"][2] = $spokerCards[4][2];                                    
                                  } elseif 
                                ( //9C - 9D - 9H - 6C - 2H
                                $spokerCards[3][0] == $spokerCards[0][0] &&
                                $spokerCards[0][0] == $spokerCards[4][0]
                                ) {
                                  $smatch_wins["instant_match"][0] = $spokerCards[3][2];
                                  $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                                  $smatch_wins["instant_match"][2] = $spokerCards[4][2];
                                }elseif 
                                  ( //9C - 9D - 9H - 6C - 2H
                                $spokerCards[3][0] == $spokerCards[1][0] &&
                                $spokerCards[1][0] == $spokerCards[4][0]
                                ) {
                            $smatch_wins["instant_match"][0] = $spokerCards[3][2];
                            $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                            $smatch_wins["instant_match"][2] = $spokerCards[4][2];
                                }
              
                    
                  } elseif (
                  // 2 pair
                  ( $spokerCards[0][0] == $spokerCards[1][0] &&
                    $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[1][0] &&
                    $spokerCards[2][0] == $spokerCards[4][0]
                  ) || 
                  ( $spokerCards[0][0] == $spokerCards[1][0] &&
                    $spokerCards[4][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[2][0] &&
                    $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[3][0] &&
                    $spokerCards[1][0] == $spokerCards[2][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[4][0] &&
                    $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[4][0] &&
                    $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[1][0] == $spokerCards[4][0] &&
                    $spokerCards[0][0] == $spokerCards[2][0]
                  ) ||
                  ( $spokerCards[1][0] == $spokerCards[4][0] &&
                    $spokerCards[0][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[1][0] == $spokerCards[4][0] &&
                    $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[2][0] == $spokerCards[0][0] &&
                    $spokerCards[1][0] == $spokerCards[4][0]
                  ) ||
                  ( $spokerCards[3][0] == $spokerCards[0][0] &&
                    $spokerCards[1][0] == $spokerCards[4][0]
                  ) ||
                  ( $spokerCards[4][0] == $spokerCards[0][0] &&
                    $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[4][0] == $spokerCards[2][0] &&
                    $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[4][0] == $spokerCards[3][0] &&
                    $spokerCards[0][0] == $spokerCards[1][0]
                  ) ||
                  ( $spokerCards[4][0] == $spokerCards[3][0] &&
                    $spokerCards[2][0] == $spokerCards[1][0]
                  )
                  
                  ) {
                    $instant_win = "2p";
                    
                     if ( $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];

                      } elseif  
                      ( $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[2][0] == $spokerCards[4][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[4][2];

                      } elseif
                      ( $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[4][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                        
                      } elseif 
                      ( $spokerCards[0][0] == $spokerCards[2][0] &&
                        $spokerCards[1][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                      } elseif 
                      ( $spokerCards[0][0] == $spokerCards[3][0] &&
                        $spokerCards[1][0] == $spokerCards[2][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[2][2];                          
                      } elseif 
                      ( $spokerCards[0][0] == $spokerCards[4][0] &&
                        $spokerCards[1][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                      } elseif
                      ( $spokerCards[0][0] == $spokerCards[4][0] &&
                        $spokerCards[1][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                      } elseif 
                      ( $spokerCards[1][0] == $spokerCards[4][0] &&
                        $spokerCards[0][0] == $spokerCards[2][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[2][2];   
                      } elseif 
                      ( $spokerCards[1][0] == $spokerCards[4][0] &&
                        $spokerCards[0][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                      } elseif 
                      ( $spokerCards[1][0] == $spokerCards[4][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[2][2];   
                      } elseif ( $spokerCards[2][0] == $spokerCards[0][0] &&
                                  $spokerCards[1][0] == $spokerCards[4][0]
                       ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[2][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[4][2];   
                       } elseif  ( $spokerCards[3][0] == $spokerCards[0][0] &&
                                    $spokerCards[1][0] == $spokerCards[4][0]
                       ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[3][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[4][2];   
                       } elseif  ( $spokerCards[4][0] == $spokerCards[0][0] &&
                                  $spokerCards[2][0] == $spokerCards[3][0]
                          ) {
                             $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                             $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                             $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                             $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                          } elseif ( $spokerCards[4][0] == $spokerCards[2][0] &&
                                      $spokerCards[1][0] == $spokerCards[3][0]
                            ) {
                               $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                               $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                               $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                               $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                              
                            } elseif ( $spokerCards[4][0] == $spokerCards[3][0] &&
                                       $spokerCards[0][0] == $spokerCards[1][0]
                             ) {
                               $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                               $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                               $smatch_wins["instant_match"][2] = $spokerCards[0][2];
                               $smatch_wins["instant_match"][3] = $spokerCards[1][2];   
                             } elseif ( $spokerCards[4][0] == $spokerCards[3][0] &&
                                        $spokerCards[2][0] == $spokerCards[1][0]
                              ) {
                               $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                               $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                               $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                               $smatch_wins["instant_match"][3] = $spokerCards[1][2];  
                              }
                    
                    
                    
                    
                  } elseif (
                  
                  
                    ( ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 13) ) ||
                   ( ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 13) ) ||
                   ( ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 13) ) ||
                    ( ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 13) ) ||
                    ( ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 13) ) ||
                    ( ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 13) ) ||
                    ( ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 13) ) ||
                    ( ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 10) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 11) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 12) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 13) ) ||
                    ( ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 10) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 11) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 12) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 13) ) ||
                    ( ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 10) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 11) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 12) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 13) )
                   
                  
                  
                  ) {
                    $instant_win = "pj";
                    
                     if ( ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                      } elseif ( ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                      } elseif ( ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                      } elseif ( ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        
                      } elseif ( ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 13) ) 
                      {
                          $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                          $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                      } elseif ( ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                      } elseif  ( ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        
                      } elseif  ( ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 10) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 11) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 12) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                        
                      } elseif ( ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 10) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 11) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 12) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 13) )  {
                           $smatch_wins["instant_match"][0] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                      } elseif ( ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 10) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 11) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 12) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[3][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                      }
            
                  }
                $smatch_wins["instant_win"]  = $instant_win; 
                  
                  
                  
                  /* elseif (
                  (
                  
                  
                  )
                  
                  ) {
                    
                    
                  }
                */
              
              
              foreach ($db_data as $db_row) {
                $imatch_cnt       = 0;
                $smatch_wins[$irow_cnt]     = array(
                    "drawdate"            => $db_row["drawdate"],
                    "match_cnt"           => 0,
                    "match_cards"         => array(),
                    "instant_cards_win"   => $smatch_wins["instant_match"],
                    "instant_win_type"    => $instant_win
                );
                  
                //print_r($db_row);
                //print_r($spokerCards);
                $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_row["scard1"], $db_row["scard2"], $db_row["scard3"],
                                                                $db_row["scard4"], $db_row["scard5"]);
                                                                
                
                
                if (strtolower($db_row["scard1"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard1"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard1"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard1"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard1"]) == strtolower($spokerCards[4][2])) {
                  
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard1"]; 
                  $imatch_cnt++;
                } 
                if (strtolower($db_row["scard2"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard2"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard2"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard2"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard2"]) == strtolower($spokerCards[4][2])) {
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard2"]; 
                  $imatch_cnt++;
                }
                if (strtolower($db_row["scard3"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard3"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard3"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard3"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard3"]) == strtolower($spokerCards[4][2])) {
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard3"]; 
                  $imatch_cnt++;
                }
                if (strtolower($db_row["scard4"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard4"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard4"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard4"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard4"]) == strtolower($spokerCards[4][2])) {
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard4"]; 
                  $imatch_cnt++;
                } 
                if (strtolower($db_row["scard5"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard5"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard5"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard5"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard5"]) == strtolower($spokerCards[4][2])) {
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard5"]; 
                  $imatch_cnt++;
                }
              
              

                $smatch_wins[$irow_cnt]["match_cnt"]    = $imatch_cnt;
                if ($instant_win == "rf") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_rf_i_prze_amt"];
                } elseif ($instant_win == "sf") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_sf_i_prze_amt"];
                } elseif ($instant_win == "4k") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_4k_i_prze_amt"];
                } elseif ($instant_win == "fh") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_fh_i_prze_amt"];
                } elseif ($instant_win == "f") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_f_i_prze_amt"];
                } elseif ($instant_win == "s") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_s_i_prze_amt"];
                } elseif ($instant_win == "3k") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_3k_i_prze_amt"];
                } elseif ($instant_win == "2p") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_2p_i_prze_amt"];
                } elseif ($instant_win == "pj") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_pj_i_prze_amt"];
                }
              
                if ($imatch_cnt == 5) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_d_prze_amt"];
                } elseif ($imatch_cnt == 4) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_4_d_prze_amt"];
                } elseif ($imatch_cnt == 3) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_3_d_prze_amt"];
                } elseif ($imatch_cnt == 2) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_2_d_prze_amt"];
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
    
    
    function OLGMegaDiceValidate() {
        
    }
    
    
    function OLGMegaDiceWinningsAdd($onmegadiceid,
            
            $m_6_6_d_count, $m_6_6_d_amount, 
            $m_5_6_b_d_count, $m_5_6_b_d_amount,
            $m_5_6_d_count, $m_5_6_d_amount,
            $m_4_6_d_count, $m_4_6_d_amount,
            $m_3_6_d_count, $m_3_6_d_amount,
            
            $m_7k_1s_i_count, $m_7k_1s_i_amount,
            $m_7k_2s_6s_i_count, $m_7k_2s_6s_i_amount,
            $m_6k_i_count, $m_6k_i_amount,
            $m_4k_3k_i_count, $m_4k_3k_i_amount,
            $m_5k_i_count, $m_5k_i_amount,
            $m_3k_3k_i_count, $m_3k_3k_i_amount,
            $m_3k_2p_i_count, $m_3k_2p_i_amount,
            $m_st_i_count, $m_st_i_amount,
            $m_4k_i_count, $m_4k_i_amount
            
            ,$game_total_sales) {
        
        
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
        
     // INSERT INTO `tbl_on_megadice_winnings`(`onmegadicewinningid`, `onmegadiceid`, `m_6_6_d_count`,
     //  `m_6_6_d_amount`, `m_5_6_b_d_count`, `m_5_6_b_d_amount`, `m_5_6_d_count`, `m_5_6_d_amount`, 
     //  `m_4_6_d_count`, `m_4_6_d_amount`, `m_3_6_d_count`, `m_3_6_d_amount`, `m_7k_1s_i_count`, 
     //  `m_7k_1s_i_amount`, `m_7k_2s_to_6s_i_count`, `m_7k_2s_to_6s_i_amount`, `m_6k_i_amount`, 
     //  `m_6k_i_count`, `m_4k_3k_i_count`, `m_4k_3k_i_amount`, `m_5k_i_count`, `m_5k_i_amount`, 
     //  `m_3k_3k_i_count`, `m_3k_3k_i_amount`, `m_3k_2p_i_count`, `m_3k_2p_i_amount`, `m_st_i_count`,
     //   `m_st_i_amount`, `m_4k_i_count`, `m_4k_i_amount`) VALUES ([value-1],[value-2],[value-3],
     //   [value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],
     //   [value-13],[value-14],[value-15],[value-16],[value-17],[value-18],[value-19],[value-20],[value-21],
     //   [value-22],[value-23],[value-24],[value-25],[value-26],[value-27],[value-28],[value-29],[value-30])
    
        
      $ssql = sprintf("INSERT INTO `tbl_on_megadice_winnings`( `onmegadiceid`, 
          `m_6_6_d_count`, `m_6_6_d_amount`, `m_5_6_b_d_count`, `m_5_6_b_d_amount`, `m_5_6_d_count`, 
          `m_5_6_d_amount`, `m_4_6_d_count`, `m_4_6_d_amount`, `m_3_6_d_count`, `m_3_6_d_amount`, 
          `m_7k_1s_i_count`, `m_7k_1s_i_amount`, `m_7k_2s_to_6s_i_count`, `m_7k_2s_to_6s_i_amount`,
          `m_6k_i_amount`, `m_6k_i_count`, `m_4k_3k_i_count`, `m_4k_3k_i_amount`, `m_5k_i_count`, 
          `m_5k_i_amount`, `m_3k_3k_i_count`, `m_3k_3k_i_amount`, `m_3k_2p_i_count`, `m_3k_2p_i_amount`, 
          `m_st_i_count`, `m_st_i_amount`, `m_4k_i_count`, `m_4k_i_amount`) 
          VALUES (
          %u,
          %u,%u,%u,%u,%u,
          %u,%u,%u,%u,%u,
          %u,%u,%u,%u,
          %u,%u,%u,%u,%u,
          %u,%u,%u,%u,%u,
          %u,%u,%u,%u) ", 
              
               $onmegadiceid, 
          $m_6_6_d_count, $m_6_6_d_amount, $m_5_6_b_d_count, $m_5_6_b_d_amount, $m_5_6_d_count, 
          $m_5_6_d_amount, $m_4_6_d_count, $m_4_6_d_amount, $m_3_6_d_count, $m_3_6_d_amount, 
          $m_7k_1s_i_count, $m_7k_1s_i_amount, $m_7k_2s_6s_i_count, $m_7k_2s_6s_i_amount,
          $m_6k_i_amount, $m_6k_i_count, $m_4k_3k_i_count, $m_4k_3k_i_amount, $m_5k_i_count, 
          $m_5k_i_amount, $m_3k_3k_i_count, $m_3k_3k_i_amount, $m_3k_2p_i_count, $m_3k_2p_i_amount, 
          $m_st_i_count, $m_st_i_amount, $m_4k_i_count, $m_4k_i_amount
              
              );
              
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
      
      
      
    }
    
    
    
   function OLGMegaDiceWinningsGetId($onMegaDiceId) {
       
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_megadice_winnings` WHERE `onmegadiceid` = %u",
              $onMegaDiceId);
      $db_res = $this->db_obj->fetch($ssql);
      
      if (is_array($db_res)) {
        return $db_res[0]["onmegadicewinningid"];
      } else {
        return null;
      }
      
   }
    
    
     /*
      * 
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
    
    
   function OLGPick2GetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_on_pick2`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_on_pick2`");
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
     
    
    
    function OLGMegaDiceGetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_on_megadice`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_on_megadice`");
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
    * Feb 13 - 2013 
    *  Added gameTime
    *  to OLGKenoAdd and OLGKenoGetDrawId
    * 
    */
  
    
    function OLGKenoAdd($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, 
    		$snum10, $snum11, $snum12, $snum13, $snum14, $snum15, $snum16, $snum17, $snum18, $snum19, $snum20, $drawNo, 
    		$sdrawDate, $spielID, $sdrawTime = "") {
         
    	
    	print "drawdate: " . $drawdate . " -- " . $idrawnum  . " -- " . $snum1 . " -- " .  $snum2  . " -- " .  $snum3  . " -- " .  $snum4 . " -- " .  $snum5 . " -- " .  $snum6 . " -- " .  $snum7 . " -- " .  $snum8 . " -- " .  $snum9 . " -- " .  
    		$snum10 . " -- " .  $snum11   . " -- " .  $snum12  . " -- " .   $snum13 . " -- " .  $snum14 . " -- " .  $snum15 . " -- " .  $snum16 . " -- " .  $snum17 . " -- " .  $snum18 . " -- " .  $snum19 . " -- " .  $snum20 . " -- " .  $drawNo  . " -- " . 
    		$sdrawDate  . " -- " .  $spielID  . " -- " .  $sdrawTime . "\n<br>";
    	
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      print "\nIN----  frst time - : SDRAWTIME: " . $sdrawTime; 
      
      if ($sdrawTime != "") {
      	$ssql = sprintf("INSERT INTO `tbl_on_keno` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snum7`,`snum8`,
      			`snum9`,`snum10`,`snum11`,`snum12`,`snum13`,`snum14`,`snum15`,`snum16`,`snum17`,`snum18`,`snum19`,`snum20`, `gameTime` ");
      	 
      } else {
      	$ssql = sprintf("INSERT INTO `tbl_on_keno` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snum7`,`snum8`,
      			`snum9`,`snum10`,`snum11`,`snum12`,`snum13`,`snum14`,`snum15`,`snum16`,`snum17`,`snum18`,`snum19`,`snum20` ");
      	 
      }
      print "\nIN---- scnd time: SDRAWTIME: " . $sdrawTime;
       if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo`, `sdrawDate`, `spielID`) ");
      } else {
        $ssql .= sprintf(") ");
      }
      
      print "\nIN---- SDRAWTIME: " . $sdrawTime;
      if ($sdrawTime != "") {
      	$ssql .= sprintf(" VALUES(%u,'%s',%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u, '%s'",
      			$idrawnum, $drawdate,  $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, 
      			$snum10, $snum11, $snum12, $snum13, $snum14, $snum15, $snum16, $snum17, $snum18, $snum19, $snum20, $sdrawTime);
      	
      } else {
      	$ssql .= sprintf(" VALUES(%u,'%s',%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u",
      			$idrawnum, $drawdate,  $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, 
      			$snum10, $snum11, $snum12, $snum13, $snum14, $snum15, $snum16, $snum17, $snum18, $snum19, $snum20);
      	
      }
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,%u, %u, %u) ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(") ");
      }
      print "\nSQL: " . $ssql;
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
    
      function OLGKenoGetDrawId($drawdate, $sdrawTime = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      
      
      if ($sdrawTime != "") {
      	$ssql = sprintf(" SELECT * FROM `tbl_on_keno` WHERE drawdate = '%s' AND gameTime = '%s' ", $drawdate, $sdrawTime);
      	 
      } else {
      	$ssql = sprintf(" SELECT * FROM `tbl_on_keno` WHERE drawdate = '%s' ", $drawdate);
      }
      
      
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
  
      
    function OLGPick3Add($drawdate, $idrawnum, $snum1, $snum2, $snum3 , $drawNo, $sdrawDate, $spielID, $sdrawTime = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
	 $ssql = sprintf("INSERT INTO `tbl_on_pick3`(`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`");
	 if ($sdrawTime != "") {
            $ssql .= ", `gameTime`";
	      	
	 } 
	 if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
	    $ssql .= sprintf(" ,`drawNo`, `sdrawDate`, `spielID`) ");
	 } else {
            $ssql .= sprintf(") ");
	 }
	 $ssql .= sprintf(" VALUES  (%u,'%s',%u,%u,%u", $idrawnum, $drawdate, $snum1, $snum2, $snum3);
	 if ($sdrawTime != "") {
            $ssql .= sprintf(", '%s'", $sdrawTime);
	      
	 }
	 if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
	    $ssql .= sprintf(" ,%u, %u, %u) ", $drawNo, $sdrawDate, $spielID);
	 } else {
	    $ssql .= sprintf(") ");
	 }
      print $ssql;
      //die();
      $rows_affected = $this->db_obj->exec($ssql);  
      return $this->db_obj->last_id;
      
    }
    
    /*
     * drawdate
     * onpick3id
     * 
     */ 
    function OLGPick3Remove($drawdate, $onpick3id = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_on_pick3` WHERE ");
      $ssql .= sprintf(" drawdate = '%s'", $drawdate);
      if ($onpick3id != "") {
        $ssql .= sprintf(" AND onpick3id = %u", $onpick3id);
      }
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    /*
   * Pick3
     * 
   * olddrawdate
   * newdrawdate
   * drawdate
   * idrawnum
   * snum1
   * snum2
   * snum3
   * 
   * return onpick3id
   */
    
    function OLGPick3Modify($olddrawdate, $newdrawdate, $drawdate = "", $idrawnum, $snum1, $snum2, $snum3, $drawNo, $sdrawDate, $spielID) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("UPDATE `tbl_on_pick3` SET ");
      $ssql .= sprintf("`idrawnum` = %u,`drawdate` = '%s',`snum1` = %u,`snum2` = %u,`snum3` = %u", $idrawnum, $newdrawdate, $snum1, $snum2, $snum3);
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo` = %u, `sdrawDate` = %u, `spielID` = %u ", $drawNo, $sdrawDate, $spielID);
      }
      $ssql .= sprintf(" WHERE drawdate = '%s'", $olddrawdate);
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    /*
     * drawdate
     * onpick3id

     */ 
    
    
    function OLGPick3GetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_on_pick3`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_on_pick3`");
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
    
    function OLGPick3GetSingleDraw($drawdate, $onpick3id = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_pick3` WHERE ");
      $ssql .= sprintf(" drawdate = '%s'", $drawdate);
      
      if ($onpick3id != "") {
        $ssql .= sprintf(" AND onpick3id = %u", $onpick3id);
      }
      
      $db_data = $this->db_obj->fetch($ssql);
      if (is_array($db_data)) {
        return $db_data[0];
      } else {
        return null;
      }
    }
    
    function OLGPick3GetDraw($st_drawdate, $ed_drawdate, $st_pos = 0, $limit = 350) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT * FROM `tbl_on_pick3` WHERE ");
      $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s'",
                    $st_drawdate, $ed_drawdate);
      $ssql .= sprintf(" order by drawdate");
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res;
      } else {
        return null;
      }
      
    }
    
    
    function OLGPick3GetDrawId($drawdate, $sdrawTime = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      if ($sdrawTime != null && $sdrawTime != "") {
      	$ssql = sprintf("SELECT * FROM `tbl_on_pick3` WHERE ");
      	$ssql .= sprintf(" drawdate = '%s' AND gameTime = '%s'", $drawdate, $sdrawTime);
      } else {
      	
	      $ssql = sprintf("SELECT * FROM `tbl_on_pick3` WHERE ");
    	  $ssql .= sprintf(" drawdate = '%s'", $drawdate);
      }
      //print "\n<br />SSQL: " . $ssql;
      $db_data = $this->db_obj->fetch($ssql);
      //print_r($db_data);
      //print $ssql;
     // die();
      if (is_array($db_data)) {
        return $db_data[0]["onpick3id"];
      } else {
        return null;
      }
    }
    
    /*
     * drawdate
     * onpick3id
     * playtype
     *  0 = 'st'
     *  1 = 'bx'
     *  2 = 'both'
     *      * 
     */ 
    
    function OLGPick3ValidateDraw($st_drawdate, $ed_drawdate, $drawplaytype = 2,  $snum1, $snum2, $snum3) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
     $ssql = sprintf("
     SELECT tbl_pick3.*,
`onpick3winningid`,  `m_3_s_count`, `m_3_s_amount`,
(SELECT prze_amount as m_3_s_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick3_win.m_3_s_amount) AS m_3_s_prze_amt,
       
 `m_3_b_count`, `m_3_b_amount`,
(SELECT prze_amount as m_3_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick3_win.m_3_b_amount) AS m_3_b_prze_amt 


     
     
     FROM `tbl_on_pick3` as tbl_pick3, `tbl_on_pick3_winnings` as tbl_pick3_win 
       WHERE tbl_pick3.onpick3id = tbl_pick3_win.onpick3id AND 
          tbl_pick3.drawdate >= '%s' AND tbl_pick3.drawdate <= '%s'",
          $st_drawdate, $ed_drawdate);
    // print "SSQL: " . $ssql;
     $ssql .= sprintf(" order by tbl_pick3.drawdate");
      $db_data = $this->db_obj->fetch($ssql);
      //print_r($db_data);
      $play_type_st         = 0;
      $play_type_bx         = 1;
      $play_type_any        = 2;
      
      $imatch_cnt     = 0;
      $ibonus_match   = 0;
      $irow_cnt       = 0;
      $ieb_match_cnt  = 0;
      
      $smatch_wins    = null;
      
      $scomb_num      = array($snum1, $snum2, $snum3);
      
      if (is_array($db_data)) {
          foreach ($db_data as $db_row) {
            
            $imatch_cnt                 = 0;
            $ieb_match_cnt              = 0;
            $ibonus_match               = 0;
            $istraight_match            = 0;
            $smatch_wins[$irow_cnt]     = array(
                "drawdate"                  => $db_row["drawdate"],
                "match_cnt"                 => 0,
                "match_numbers"             => array(),
                "match_bonus"               => 0,
                "match_bonus_num"           => 0,
                "win_prze_box_amount"       => 0,
                "win_prze_straight_amount"  => 0
            );
              
            $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_row["snum1"], $db_row["snum2"], $db_row["snum3"]);
                   
            $imatch_cnt = 0;
            
            if ( ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[1] && $db_row["snum3"] == $scomb_num[2]) ||
                 ($db_row["snum1"] == $scomb_num[1] && $db_row["snum2"] == $scomb_num[0] && $db_row["snum3"] == $scomb_num[2]) ||
                 ($db_row["snum1"] == $scomb_num[2] && $db_row["snum2"] == $scomb_num[1] && $db_row["snum3"] == $scomb_num[0]) ||
                 ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[1]) ||
                 ($db_row["snum1"] == $scomb_num[2] && $db_row["snum2"] == $scomb_num[0] && $db_row["snum3"] == $scomb_num[1]) ||
                 ($db_row["snum1"] == $scomb_num[1] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[0])
              ) {
                
                $imatch_cnt = 3;
                
                $smatch_wins[$irow_cnt]["match_numbers"][0]         = $db_row["snum1"];
                $smatch_wins[$irow_cnt]["match_numbers"][1]         = $db_row["snum2"];
                $smatch_wins[$irow_cnt]["match_numbers"][2]         = $db_row["snum3"];
                
                $smatch_wins[$irow_cnt]["win_prze_box_amount"]      = $db_row["m_3_b_prze_amt"];
                
                 if ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[1] && $db_row["snum3"] == $scomb_num[2]) {
              
                      // straight Match...
                    $istraight_match      = 1;
                    $smatch_wins[$irow_cnt]["match_numbers"][0]         = $db_row["snum1"];
                    $smatch_wins[$irow_cnt]["match_numbers"][1]         = $db_row["snum2"];
                    $smatch_wins[$irow_cnt]["match_numbers"][2]         = $db_row["snum3"];
                    
                    $smatch_wins[$irow_cnt]["win_prze_straight_amount"] = $db_row["m_3_s_prze_amt"];
                }
            
              }
                 
              
            $irow_cnt++;
          }
      }
      //print ":: Match_wins: ) ";
      //print_r($smatch_wins);
      if (is_array($smatch_wins)) {
        return $smatch_wins;
      } else {
        return null;
      }

    }
    
     /*
     * drawdate
     * onpick3id
     * playtype
     *  0 = 'st'
     *  1 = 'bx'
     *  2 = 'both'
     *      * 
     */ 
    
    function OLGPick3Validate() {
     
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_pick3` WHERE ");
      $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s' ", $startdrawdate, $enddrawdate);
      
      if ($onpick3id != "" ) {
        $ssql .= sprintf(" AND onpick3id = %u" , $onpick3id);
      }
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
          foreach ($db_data as $db_row) {
            
            if ($db_row["snum1"] == $snum1 && $db_row["snum2"] == $snum2 && $db_row["snum3"] == $snum3) {
                  // straight Match...
             
            } else {
              
              if ($db_row["snum1"] == $snum1 || $db_row["snum1"] == $snum2 || $db_row["snum1"] == $snum3 ) {
                 
              }
              if ($db_row["snum2"] == $snum1 || $db_row["snum2"] == $snum2 || $db_row["snum2"] == $snum3 ) {
                 
              }
              if ($db_row["snum3"] == $snum1 || $db_row["snum3"] == $snum2 || $db_row["snum3"] == $snum3 ) {
                 
              }
            }
          } 
      }
    }
    
    
    
    
    
    
    function OLGPick3GetMonth() {
      
    }
    function OLGPick3GetYear() {
      
    }
    function OLGPick3GetAll() {
      
    }
  
   /*
    * Pick 4
    * 
    * drawdate
    * idrawnum
    * snum1
    * snum2
    * snum3
    * snum4
    * 
    */ 
        
    function OLGPick4Add($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $drawNo, $sdrawDate, $spielID, $sdrawTime = "") {
      
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_on_pick4` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4` ");
      
      if ($sdrawTime != "") {
      	$ssql .= ", `gameTime`";
      
      }
      
      
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo`, `sdrawDate`, `spielID`) ");
      } else {
        $ssql .= sprintf(") ");
      }
      $ssql .= sprintf(" VALUES (%u,'%s',%u,%u,%u,%u", $idrawnum, $drawdate, $snum1, $snum2, $snum3, $snum4);
      
      if ($sdrawTime != "") {
      	$ssql .= sprintf(", '%s'", $sdrawTime);
      }
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,%u, %u, %u) ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(") ");
      }
      $rows_affected = $this->db_obj->exec($ssql);     
      return $this->db_obj->last_id;
    }
    
    /*
     * drawdate 
     * onpick4id
     * 
     * 
     */
      
    function OLGPick4Remove($drawdate, $onpick4id = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf("DELETE FROM `tbl_on_pick4` WHERE ");
     $ssql .= sprintf(" WHERE drawdate = '%s'", $drawdate);
     
     if ($onpick4id != "") {
       $ssql .= sprintf(" AND onpick4id = %u", $onpick4id);
     }
     
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
    }
    
     /*
    * Pick 4
    * 
    * olddrawdate
    * newdrawdate
    * drawdate
    * idrawnum
    * snum1
    * snum2
    * snum3
    * snum4
    * 
    */ 
    
    function OLGPick4Modify($olddrawdate, $newdrawdate, $drawdate = "", $idrawnum, $snum1, $snum2, $snum3, $snum4, $drawNo, $sdrawDate, $spielID) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE `tbl_on_pick4` SET ");
      $ssql .= sprintf(" `idrawnum` = %u,`drawdate` = '%s',`snum1` = %u,`snum2` = %u, `snum3` = %u,`snum4` = %u ", $idrawnum, $newdrawdate, $snum1, $snum2, $snum3, $snum4);
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo` = %u, `sdrawDate` = %u, `spielID` = %u ", $drawNo, $sdrawDate, $spielID);
      }
      $ssql .= sprintf(" WHERE drawdate = '%s' ", $olddrawdate);
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    /*
     * drawdate
     * onpick4id
     * 
     * 
     */ 
    function OLGPick4GetSingleDraw($drawdate, $onpick4id = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_pick4` WHERE ");
      $ssql .= sprintf(" drawdate = '%s'", $drawdate);
      
      if ($onpick4id != "") {
        $ssql .= sprintf(" AND onpick4id = %u", $onpick4id);
      }  
      
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
      
    }
    
    function OLGPick4GetDraw($st_drawdate, $ed_drawdate, $st_pos = 0, $limit = 350) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_pick4` WHERE drawdate >= '%s' AND drawdate <= '%s' ",
                    $st_drawdate, $ed_drawdate);
      $ssql .= sprintf(" order by drawdate");
      //print "\nSSQL: " . $ssql;
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res;
      } else {
        return null;
      }                   
    }
    
        
    function OLGPick4GetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_on_pick4`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_on_pick4`");
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
    
      function OLGPick4GetDrawId($drawdate, $sdrawTime = "", $onpick4id = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_pick4` WHERE ");
      if ($sdrawTime != "") {
      	$ssql .= sprintf(" gameTime = '%s' AND ", $sdrawTime);
      }
      
      $ssql .= sprintf(" drawdate = '%s'", $drawdate);
      
      if ($onpick4id != "") {
        $ssql .= sprintf(" AND onpick4id = %u", $onpick4id);
      }  
      
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0]["onpick4id"];
      } else {
        return null;
      }
      
    }
    
    /*
     * drawdate
     * straight play
     * 4-Way Box Play
     * 6-Way Box Play
     * 12-Way Box Play
     * 24-Way Box Play
     * 
     * snum1
     * snum2
     * snum3
     * snum4
     * playtype
     *  0 = 'straight'
     *  1 = 'box'
     *  2 = 'both'
     *   = '4way'
     *   = '6way'
     *   = '12way'
     *   = '24way'
     * 
     */ 
    function OLGPick4ValidateDraw($st_drawdate, $ed_drawdate,  $playtype = 2, $snum1, $snum2, $snum3, $snum4) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
     $ssql = sprintf("SELECT 
     tbl_pick4.drawdate,
     `onpick4winningid`, tbl_pick4.*,
       `m_4_s_count`, `m_4_s_amount`, 
      (SELECT prze_amount as m_4_s_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_s_amount) AS m_4_s_prze_amt,
      
      
      `m_4_b_count`, `m_4_b_amount`,
      (SELECT prze_amount as m_4_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_b_amount) AS m_4_b_prze_amt,
      
       `m_4_4w_box_count`, `m_4_4w_box_amount`, 
      (SELECT prze_amount as m_4_4w_box_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_4w_box_amount) AS m_4_4w_box_prze_amt,
      
      
      `m_4_6w_box_count`, `m_4_6w_box_amount`, 
      (SELECT prze_amount as m_4_6w_box_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_6w_box_amount) AS m_4_6w_box_prze_amt,
      
      
      `m_4_12w_box_count`, `m_4_12w_box_amount`, 
      (SELECT prze_amount as m_4_12w_box_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_12w_box_amount) AS m_4_12w_box_prze_amt,
      
      `m_4_24w_box_count`, `m_4_24w_box_amount`, 
      (SELECT prze_amount as m_4_24w_box_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_24w_box_amount) AS m_4_24w_box_prze_amt
           
     
     FROM `tbl_on_pick4` as tbl_pick4, `tbl_on_pick4_winnings` as tbl_pick4_win 
     WHERE tbl_pick4.onpick4id = tbl_pick4_win.onpick4id AND 
     tbl_pick4.drawdate >= '%s' AND tbl_pick4.drawdate <= '%s' ",
     $st_drawdate, $ed_drawdate);
     //print "SSQL: " . $ssql;
     $ssql .= sprintf(" order by tbl_pick4.drawdate");
      $db_data = $this->db_obj->fetch($ssql);
      
      
      $play_type_st     = 0;
      $play_type_bx     = 1;
      $play_type_any    = 2;
      
      $imatch_cnt       = 0;
      $irow_cnt         = 0;
      $ist_match        = 0;
      $ibx_match        = 0;
      
      $smatch_wins      = null;
      $scomb_num        = array($snum1, $snum2, $snum3, $snum4);
      
      
      if (is_array($db_data)) {
            foreach ($db_data as $db_row) {

              $imatch_cnt                 = 0;
              
              $istraight_match            = 0;
              $i4way_bx_match              = 0;
              $i6way_bx_match              = 0;
              $i12way_bx_match             = 0;
              $i24way_bx_match             = 0; 
              
              $smatch_wins[$irow_cnt]     = array(
                "drawdate"          => $db_row["drawdate"],
                "match_cnt"         => 0,
                "match_numbers"     => null,
                "match_type"        => 0,
                "match_straight"    => 0,
                "match_box"         => 0,
                "match_st_prze_amt" => 0,
                "match_bx_prze_amt" => 0,
                "match_bonus"       => 0,
                "match_bonus_num"   => 0
              );
              
            $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_row["snum1"], $db_row["snum2"], $db_row["snum3"], $db_row["snum4"]);
                   
            
              
                /* 4way
                 * xxxy , xxyx, xyxx, yxxx
                 * 6way
                 * xxyy, xyxy, xyyx, yyxx, yxyx, yxxy
                 * 
                 * 12 way
                 * xxyz, xxzy, xyxz, xyzx, xzyx, xzxy, yzxx, yxxz, yxzx, zyxx, zxxy, zxyx
                 * 
                 * 24 way
                 * xyzd, xzyd, xdyz, xydz, xzdy, xd
                 * 
                 * Straight Play is matching all four digits in the exact order (e.g. 1234). A number with the same 4 digits (e.g. 2222) can be played only as a Straight Play. 
                 * For Box Play, the digits you select determine which Box Play prize category you are eligible for 
                 * (4-Way, 6-Way, 12-Way or 24-Way Box Play) 
                 * Only one Box Play type will apply per draw. Box Play can be won four different ways:
                 * 4 Way Box - Match all 4 digits in any order, where 3 of the digits are the same (e.g. 1112)
                 * 6 Way Box - Match all 4 digits in any order, where two sets of digits are the same (e.g. 1122)
                 * 12 Way Box - Match all 4 digits in any order, where 2 of the digits are the same (e.g. 1123)
                 * 24 Way Box - Match all 4 digits in any order, where all 4 digits are different (eg.1234)
                 *
            
                 * 
                 * */ 
                 if ( $db_row["snum1"] == $scomb_num[0] || $db_row["snum1"] == $scomb_num[1] || $db_row["snum1"] == $scomb_num[2] || $db_row["snum1"] == $scomb_num[3]) {
                   $imatch_cnt++;
                 }
                 if ( $db_row["snum2"] == $scomb_num[0] || $db_row["snum2"] == $scomb_num[1] || $db_row["snum2"] == $scomb_num[2] || $db_row["snum2"] == $scomb_num[3]) {
                   $imatch_cnt++;
                 }
                 if ( $db_row["snum3"] == $scomb_num[0] || $db_row["snum3"] == $scomb_num[1] || $db_row["snum3"] == $scomb_num[2] || $db_row["snum3"] == $scomb_num[3]) {
                   $imatch_cnt++;
                 }
                 if ( $db_row["snum4"] == $scomb_num[0] || $db_row["snum4"] == $scomb_num[1] || $db_row["snum4"] == $scomb_num[2] || $db_row["snum4"] == $scomb_num[3]) {
                   $imatch_cnt++;
                 }
                 
                  if ($imatch_cnt == 4) {
                      //print_r($db_row);
                      $smatch_wins[$irow_cnt]["match_numbers"] = array($db_row["snum1"], $db_row["snum2"], $db_row["snum3"], $db_row["snum4"]);
            
                    if ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[1] && $db_row["snum3"] == $scomb_num[2] && $db_row["snum4"] == $scomb_num[3]) {
                      $istraight_match  = 1;
                      $i4way_bx_match = 1;

                    } elseif ( ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[1] && $db_row["snum3"] == $scomb_num[2] && $db_row["snum4"] == $scomb_num[3]) ||
                         ($db_row["snum1"] == $scomb_num[3] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[1] && $db_row["snum4"] == $scomb_num[0]) ||
                         ($db_row["snum1"] == $scomb_num[3] && $db_row["snum2"] == $scomb_num[0] && $db_row["snum3"] == $scomb_num[1] && $db_row["snum4"] == $scomb_num[2]) ||
                         ($db_row["snum1"] == $scomb_num[1] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[3] && $db_row["snum4"] == $scomb_num[0])
                         )
                        {
                   // [xxx-][xx-x][x-xx][-xxx]
                          // 4way
                          /*
                           * 2345  | 1234
                           * 
                           * 3452  | 2341
                           * 5234  | 4123
                           * 5432  | 4321
                           * 
                           */ 
                          $i4way_bx_match = 1;

                          
                        } // [xx--] [--xx] [x--x] [xx--] [xx.-] [-.xx]
                    elseif ( ($db_row["snum1"] == $scomb_num[1] && $db_row["snum2"] == $scomb_num[0] && $db_row["snum3"] == $scomb_num[3] && $db_row["snum4"] == $scomb_num[2]) ||
                             ($db_row["snum1"] == $scomb_num[1] && $db_row["snum2"] == $scomb_num[0] && $db_row["snum3"] == $scomb_num[2] && $db_row["snum4"] == $scomb_num[3]) ||
                             ($db_row["snum1"] == $scomb_num[3] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[1] && $db_row["snum4"] == $scomb_num[0]) ||
                             ($db_row["snum1"] == $scomb_num[2] && $db_row["snum2"] == $scomb_num[3] && $db_row["snum3"] == $scomb_num[1] && $db_row["snum4"] == $scomb_num[0]) ||
                             ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[1] && $db_row["snum3"] == $scomb_num[3] && $db_row["snum4"] == $scomb_num[2]) ||
                             ($db_row["snum1"] == $scomb_num[3] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[0] && $db_row["snum4"] == $scomb_num[1])
                          )
                          {
                            // 6way
                            
                            /*
                             * 2345  | 1234
                             * 
                             * 3254  | 2143
                             * 3245  | 2134
                             * 
                             * 5432  | 4321
                             * 4532  | 3421
                             * 
                             * 2354  | 1243
                             * 5423  | 4312
                             * 
                             *  * 
                             */ 
                            $i6way_bx_match = 1;
         
                          }
                    elseif (
                             ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[1] && $db_row["snum3"] == $scomb_num[3] && $db_row["snum4"] == $scomb_num[2]) ||
                             ($db_row["snum1"] == $scomb_num[3] && $db_row["snum2"] == $scomb_num[0] && $db_row["snum3"] == $scomb_num[1] && $db_row["snum4"] == $scomb_num[2]) ||
                             ($db_row["snum1"] == $scomb_num[1] && $db_row["snum2"] == $scomb_num[0] && $db_row["snum3"] == $scomb_num[2] && $db_row["snum4"] == $scomb_num[3]) ||
                             ($db_row["snum1"] == $scomb_num[1] && $db_row["snum2"] == $scomb_num[0] && $db_row["snum3"] == $scomb_num[3] && $db_row["snum4"] == $scomb_num[2]) ||
                             ($db_row["snum1"] == $scomb_num[2] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[1] && $db_row["snum4"] == $scomb_num[0]) ||
                             ($db_row["snum1"] == $scomb_num[3] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[1] && $db_row["snum4"] == $scomb_num[0]) ||
                             ($db_row["snum1"] == $scomb_num[2] && $db_row["snum2"] == $scomb_num[3] && $db_row["snum3"] == $scomb_num[0] && $db_row["snum4"] == $scomb_num[1]) ||
                             ($db_row["snum1"] == $scomb_num[1] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[3] && $db_row["snum4"] == $scomb_num[0]) ||
                             ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[3] && $db_row["snum4"] == $scomb_num[1]) ||
                             ($db_row["snum1"] == $scomb_num[1] && $db_row["snum2"] == $scomb_num[2] && $db_row["snum3"] == $scomb_num[0] && $db_row["snum4"] == $scomb_num[3]) ||
                             ($db_row["snum1"] == $scomb_num[0] && $db_row["snum2"] == $scomb_num[3] && $db_row["snum3"] == $scomb_num[1] && $db_row["snum4"] == $scomb_num[2]) ||
                             ($db_row["snum1"] == $scomb_num[3] && $db_row["snum2"] == $scomb_num[1] && $db_row["snum3"] == $scomb_num[2] && $db_row["snum4"] == $scomb_num[0])
                    
                    
                          ){
                            
                            /*
                             * [ 2345  | 1234 ]
                             * [ 2354 | 1243 ]
                             * [ 5234 | 4123 ]
                             * 
                             * [ 3245 | 2134 ]
                             * [ 3254 | 2143 ]
                             * [ 4532 | 3421 ]
                             * [ 5432 | 4321 ]
                             * 
                             * [ 4523 | 3412 ]
                             * [ 3452 | 2341 ]
                             * [ 2453 | 1342 ]
                             * 
                             * [ 3425 | 2314 ]
          
                             * [ 2534 | 1423 ]
                             * [ 5342 | 4231 ]
                             
                             */ 
                            $i12way_bx_match = 1;
                            
                          }
                      else {
                        // 24 way
                        $i24way_bx_match  = 1;
                      }

                    }


              if ($imatch_cnt == 4) {
                
                if ($istraight_match == 1) {
                  $smatch_wins[$irow_cnt]["match_st_prze_amt"] = $db_row["m_4_s_prze_amt"];
                } 
                
                if ($i4way_bx_match == 1) {
                  $smatch_wins[$irow_cnt]["match_bx_prze_amt"] = $db_row["m_4_4w_box_prze_amt"];
                  $smatch_wins[$irow_cnt]["match_box"]         = 4;
                } elseif ($i6way_bx_match == 1) {
                  $smatch_wins[$irow_cnt]["match_bx_prze_amt"] = $db_row["m_4_6w_box_prze_amt"];
                  $smatch_wins[$irow_cnt]["match_box"]        = 6;
                } elseif ($i12way_box_match == 1) {
                  $smatch_wins[$irow_cnt]["match_bx_prze_amt"] = $db_row["m_4_12w_box_prze_amt"];
                  $smatch_wins[$irow_cnt]["match_box"]        = 12;
                } elseif ($i24way_bx_match == 1) {
                  $smatch_wins[$irow_cnt]["match_bx_prze_amt"] = $db_row["m_4_24w_box_prze_amt"];
                  $smatch_wins[$irow_cnt]["match_box"]        = 24;
                }
              }

              $irow_cnt++;

            }
       
       
        }
      
      
      
      if (is_array($smatch_wins)) {
        return $smatch_wins;
      } else {
        return null;
      }
      
    }



    /*
     * drawdate
     * straight play
     * 4-Way Box Play
     * 6-Way Box Play
     * 12-Way Box Play
     * 24-Way Box Play
     * 
     * snum1
     * snum2
     * snum3
     * snum4
     * playtype
     *  0 = 'straight'
     *  1 = 'box'
     *  2 = 'both'
     *   = '4way'
     *   = '6way'
     *   = '12way'
     *   = '24way'
     * 
     */
     
    function OLGPick4Validate($startdrawdate, $enddrawdate, $drawdate = "", $playtype = 2, $snum1, $snum2, $snum3, $snum4) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_pick4` WHERE ");
      $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s' ", $startdrawdate, $enddrawdate);
       
      $db_data = $this->db_obj->fetch($ssql);
      
      if (is_array($db_data)) {
              foreach ($db_data as $db_row) {
                if ($db_row["snum1"] == $snum1 && $db_row["snum2"] == $snum2 && $db_row["snum3"] == $snum3 && $db_row["snum4"] == $snum4) {
                  
                } else {
                  /* 4way
                   * xxxy , xxyx, xyxx, yxxx
                   * 6way
                   * xxyy, xyxy, xyyx, yyxx, yxyx, yxxy
                   * 
                   * 12 way
                   * xxyz, xxzy, xyxz, xyzx, xzyx, xzxy, yzxx, yxxz, yxzx, zyxx, zxxy, zxyx
                   * 
                   * 24 way
                   * xyzd, xzyd, xdyz, xydz, xzdy, xd
                   * 
                   * Straight Play is matching all four digits in the exact order (e.g. 1234). A number with the same 4 digits (e.g. 2222) can be played only as a Straight Play. For Box Play, the digits you select determine which Box Play prize category you are eligible for (4-Way, 6-Way, 12-Way or 24-Way Box Play) Only one Box Play type will apply per draw. Box Play can be won four different ways:
                   * 4 Way Box - Match all 4 digits in any order, where 3 of the digits are the same (e.g. 1112)
                   * 
                   * 
                   * 
                   * 6 Way Box - Match all 4 digits in any order, where two sets of digits are the same (e.g. 1122)
                   * 12 Way Box - Match all 4 digits in any order, where 2 of the digits are the same (e.g. 1123)
                   * 24 Way Box - Match all 4 digits in any order, where all 4 digits are different (eg.1234)
                   *
              
                   * 
                   * */ 
                   $match_cnt = 0;
                   if ( $db_row["snum1"] = $snum1 || $db_row["snum1"] = $snum2 || $db_row["snum1"] = $snum3 || $db_row["snum1"] = $snum4) {
                     $match_cnt++;
                   }
                   if ( $db_row["snum2"] = $snum1 || $db_row["snum2"] = $snum2 || $db_row["snum2"] = $snum3 || $db_row["snum2"] = $snum4) {
                     $match_cnt++;
                   }
                   if ( $db_row["snum3"] = $snum1 || $db_row["snum3"] = $snum2 || $db_row["snum3"] = $snum3 || $db_row["snum3"] = $snum4) {
                     $match_cnt++;
                   }
                   if ( $db_row["snum4"] = $snum1 || $db_row["snum4"] = $snum2 || $db_row["snum4"] = $snum3 || $db_row["snum4"] = $snum4) {
                     $match_cnt++;
                   }
                   
                     if ($match_cnt == 4) {
                         // [xxx-][xx-x][x-xx][-xxx]
                        if ( ($db_row["snum1"] == $snum1 && $db_row["snum2"] == $snum2 && $db_row["snum3"] == $snum3 && $db_row["snum4"] == $snum4) ||
                             ($db_row["snum1"] == $snum4 && $db_row["snum2"] == $snum3 && $db_row["snum3"] == $snum2 && $db_row["snum4"] == $snum1) ||
                             ($db_row["snum1"] == $snum4 && $db_row["snum2"] == $snum1 && $db_row["snum3"] == $snum2 && $db_row["snum4"] == $snum3) ||
                             ($db_row["snum1"] == $snum2 && $db_row["snum2"] == $snum3 && $db_row["snum3"] == $snum4 && $db_row["snum4"] == $snum1)
                             )
                            {
                              // 4way
                              /*
                               * 2345  | 1234
                               * 
                               * 3452  | 2341
                               * 5234  | 4123
                               * 5432  | 4321
                               * 
                               */ 
                              
                            } // [xx--] [--xx] [x--x] [xx--] [xx.-] [-.xx]
                        elseif ( ($db_row["snum1"] == $snum2 && $db_row["snum2"] == $snum1 && $db_row["snum3"] == $snum4 && $db_row["snum4"] == $snum3) ||
                                 ($db_row["snum1"] == $snum2 && $db_row["snum2"] == $snum1 && $db_row["snum3"] == $snum3 && $db_row["snum4"] == $snum4) ||
                                 ($db_row["snum1"] == $snum4 && $db_row["snum2"] == $snum3 && $db_row["snum3"] == $snum2 && $db_row["snum4"] == $snum1) ||
                                 ($db_row["snum1"] == $snum3 && $db_row["snum2"] == $snum4 && $db_row["snum3"] == $snum2 && $db_row["snum4"] == $snum1) ||
                                 ($db_row["snum1"] == $snum1 && $db_row["snum2"] == $snum2 && $db_row["snum3"] == $snum4 && $db_row["snum4"] == $snum3) ||
                                 ($db_row["snum1"] == $snum4 && $db_row["snum2"] == $snum3 && $db_row["snum3"] == $snum1 && $db_row["snum4"] == $snum2)
                              )
                              {
                                // 6way
                                
                                /*
                                 * 2345  | 1234
                                 * 
                                 * 3254  | 2143
                                 * 3245  | 2134
                                 * 
                                 * 5432  | 4321
                                 * 4532  | 3421
                                 * 
                                 * 2354  | 1243
                                 * 5423  | 4312
                                 * 
                                 *  * 
                                 */ 
                                
                              }
                        elseif (
                                 ($db_row["snum1"] == $snum1 && $db_row["snum2"] == $snum2 && $db_row["snum3"] == $snum4 && $db_row["snum4"] == $snum3) ||
                                 ($db_row["snum1"] == $snum4 && $db_row["snum2"] == $snum1 && $db_row["snum3"] == $snum2 && $db_row["snum4"] == $snum3) ||
                                 ($db_row["snum1"] == $snum2 && $db_row["snum2"] == $snum1 && $db_row["snum3"] == $snum3 && $db_row["snum4"] == $snum4) ||
                                 ($db_row["snum1"] == $snum2 && $db_row["snum2"] == $snum1 && $db_row["snum3"] == $snum4 && $db_row["snum4"] == $snum3) ||
                                 ($db_row["snum1"] == $snum3 && $db_row["snum2"] == $snum3 && $db_row["snum3"] == $snum2 && $db_row["snum4"] == $snum1) ||
                                 ($db_row["snum1"] == $snum4 && $db_row["snum2"] == $snum3 && $db_row["snum3"] == $snum2 && $db_row["snum4"] == $snum1) ||
                                 ($db_row["snum1"] == $snum3 && $db_row["snum2"] == $snum4 && $db_row["snum3"] == $snum1 && $db_row["snum4"] == $snum2) ||
                                 ($db_row["snum1"] == $snum2 && $db_row["snum2"] == $snum3 && $db_row["snum3"] == $snum4 && $db_row["snum4"] == $snum1) ||
                                 ($db_row["snum1"] == $snum1 && $db_row["snum2"] == $snum3 && $db_row["snum3"] == $snum4 && $db_row["snum4"] == $snum2) ||
                                 ($db_row["snum1"] == $snum2 && $db_row["snum2"] == $snum3 && $db_row["snum3"] == $snum1 && $db_row["snum4"] == $snum4) ||
                                 ($db_row["snum1"] == $snum1 && $db_row["snum2"] == $snum4 && $db_row["snum3"] == $snum2 && $db_row["snum4"] == $snum3) ||
                                 ($db_row["snum1"] == $snum4 && $db_row["snum2"] == $snum2 && $db_row["snum3"] == $snum3 && $db_row["snum4"] == $snum1)
                        
                        
                              ){
                                
                                /*
                                 *  2345  | 1234
                                 * 
                                 * 2354 | 1243
                                 * 5234 | 4123
                                 * 
                                 * 3245 | 2134
                                 * 3254 | 2143
                                 * 4532 | 3421
                                 * 5432 | 4321
                                 * 
                                 * 4523 | 3412
                                 * 3452 | 2341
                                 * 2453 | 1342
                                 * 
                                 * 3425 | 2314
              
                                 * 2534 | 1423
                                 * 5342 | 4231
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
                                 */ 
                                
                                
                              }
                          else {
                            // 12 way
                          }
                      }    
                  }
              }
        }
      
       
    }
    function OLGPick4GetMonth() {
      
    }
    function OLGPick4GetYear() {
      
    }
    function OLGPick4GetAll() {
      
    }
    
    /*
     * Poker
     * 
     * drawdate
     * idrawnum
     * scard1
     * scard2
     * scard3
     * scard4
     * scard5
     * 
     */
      
    function OLGPokerAdd($drawdate, $idrawnum, $scard1 , $scard2, $scard3, $scard4, $scard5, $drawNo, $sdrawDate, $spielID) {
       if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf("INSERT INTO `tbl_on_poker` (`idrawnum`,`drawdate`,`scard1`,`scard2`,`scard3`,`scard4`,`scard5` ");
     if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo`, `sdrawDate`, `spielID`) ");
      } else {
        $ssql .= sprintf(") ");
      }
     
     $ssql .= sprintf(" VALUES (%u, '%s', '%s', '%s', '%s', '%s','%s'", $idrawnum, $drawdate, $scard1, $scard2, $scard3, $scard4, $scard5);

      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,%u, %u, %u) ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(") ");
      }
      //print "\n" . $ssql;
     $rows_affected = $this->db_obj->exec($ssql);
     return $this->db_obj->last_id;
    }
    
    /*
     * drawdate
     * onpokerid
     * 
     * 
     */ 
    
    function OLGPokerRemove($drawdate, $onpokerid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf("DELETE FROM `tbl_on_poker` WHERE '%s'", $drawdate);
     
     if ($onpokerid != "") {
       $ssql .= sprintf(" AND onpokerid = %u", $onpokerid);
     }
     
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
    }
    
        /*
     * Poker
     *
     *
     * olddrawdate
     * newdrawdate
     * drawdate
     * idrawnum
     * scard1
     * scard2
     * scard3
     * scard4
     * scard5
     * ipokerid
     * 
     */
     
    function OLGPokerModify($olddrawdate, $newdrawdate, $drawdate = "", $idrawnum, $scard1, $scard2, $scard3, $scard4, $scard5, $drawNo, $sdrawDate, $spielID) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE `tbl_on_poker` SET ");
      $ssql .= sprintf(" drawdate = '%s', idrawnum = %u, scard1 = '%s', scard2 = '%s', scard3 = '%s', scard4 = '%s', scard5 = '%s'", $newdrawdate, $idrawnum, $scard1, $scard2, $scard3, $scard4, $scard5);
      if ($drawNo != "" || $sdrawDate != "" || $spielID != "") {
        $ssql .= sprintf(" ,`drawNo` = %u, `sdrawDate` = %u, `spielID` = %u ", $drawNo, $sdrawDate, $spielID);
      } else {
        $ssql .= sprintf(") ");
      }
      $ssql .= sprintf(" WHERE drawdate = '%s'", $olddrawdate);
      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
      
    }
    
    /*
     * drawdate
     * ipokerid
     * 
     * 
     */ 
    
    function OLGPokerGetSingleDraw($drawdate, $ipokerid = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_poker` ");
      $ssql .= sprintf(" WHERE drawdate = '%s'", $drawdate);
      
      $db_data = $this->db_obj->fetch($ssql);
      if (is_array($db_data)) {
        return $db_data[0];
      } else {
        return null;
      }
    }

    
    function OLGPokerGetDraw($st_drawdate, $ed_drawdate, $st_pos = 0, $limit = 350) {
      
      if (!$this->db_obj) {
          $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_poker` WHERE drawdate >= '%s' AND drawdate <= '%s' ",
                    $st_drawdate, $ed_drawdate);
    $ssql .= sprintf(" order by drawdate");
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        
        return $db_res;
      } else {
        return null;
      }
                    
        
    }
    
    function OLGPokerGetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_on_poker`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_on_poker`");
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
    
     function OLGPokerGetDrawId($drawdate) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_poker` ");
      $ssql .= sprintf(" WHERE drawdate = '%s'", $drawdate);
      
      $db_data = $this->db_obj->fetch($ssql);
      if (is_array($db_data)) {
        return $db_data[0]["onpokerid"];
      } else {
        return null;
      }
    }
    
    function PokerCardsSort($scard1, $scard2, $scard3, $scard4, $scard5, $sort_order = null) {
     
       $sPokerCards = array("two" => array(1,2),
                               "three" => array(2,3),
                               "four" => array(3,4),
                               "five" => array(4,5),
                               "six" => array(5,6),
                               "seven" => array(6,7),
                               "eight" => array(7,8),
                               "nine" => array(8,9),
                               "ten" => array(9,10),
                               "jack" => array(10,"J"),
                               "queen" => array(11,"Q"),
                               "king" => array(12,"K"),
                               "ace" => array(13,"A")
                               );
                               
      $sPokerClass = array("clubs" => array(1,"C"),
                              "spades" => array(2,"S"),
                              "diamonds" => array(3,"D"),
                              "hearts" => array(4,"H")
                              );
      //$iPokerPos = 0;    
      $iMatchCardPos = 0;
      $sMatchCardSet = array();
      //$sPokerCardSet = array();                  
      foreach ($sPokerClass as $classDesc => $classCode) {
        foreach ($sPokerCards as $pokerCardDesc => $pokerCardCode) {
          //$sPokerCardSet[$iPokerPos] = $classCode . $pokerCardCode;
          if (strtolower(trim($scard1)) == strtolower(  $pokerCardCode[1] . $classCode[1]   )) {
            $sMatchCardSet[$iMatchCardPos] = array($pokerCardCode[0], $classCode[0], $pokerCardCode[1] . $classCode[1]) ;
            $iMatchCardPos++;
          } elseif (strtolower(trim($scard2)) == strtolower(  $pokerCardCode[1] . $classCode[1]   )) {
            $sMatchCardSet[$iMatchCardPos] =  array($pokerCardCode[0], $classCode[0], $pokerCardCode[1] . $classCode[1])  ;
            $iMatchCardPos++;
          } elseif (strtolower(trim($scard3)) == strtolower(  $pokerCardCode[1] . $classCode[1]   )) {
            $sMatchCardSet[$iMatchCardPos] =  array($pokerCardCode[0], $classCode[0], $pokerCardCode[1] . $classCode[1]) ;
            $iMatchCardPos++;
          } elseif (strtolower(trim($scard4)) == strtolower(  $pokerCardCode[1] . $classCode[1] )) {
             $sMatchCardSet[$iMatchCardPos] =  array($pokerCardCode[0], $classCode[0], $pokerCardCode[1] . $classCode[1])   ;
            $iMatchCardPos++;
          } elseif (strtolower(trim($scard5)) == strtolower(  $pokerCardCode[1] . $classCode[1]   )) {
            $sMatchCardSet[$iMatchCardPos] =  array($pokerCardCode[0], $classCode[0], $pokerCardCode[1] . $classCode[1])  ;
            $iMatchCardPos++;
          }
            
          //$iPokerPos++;
        }
      }
        
      //print_r($sMatchCardSet); 
      if (count($sMatchCardSet) > 1) {
        return $sMatchCardSet;
      } else {
        return null;
      }
     }
     
    /*
     * $drawdate
     * scard1
     * scard2
     * scard3
     * scard4
     * scard5
     * 
     * 
     */ 
    function OLGPokerValidateDraw($st_drawdate , $ed_drawdate, $scard1, $scard2, $scard3, $scard4, $scard5) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }

       $ssql = sprintf("
         SELECT `onpokerwinningid`, tbl_poker.*, 
          `m_5_d_count`, `m_5_d_amount`, 
          (SELECT prze_amount as m_5_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_5_d_amount) AS m_5_d_prze_amt,
          `m_4_d_count`, `m_4_d_amount`, 
          (SELECT prze_amount as m_4_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_4_d_amount) AS m_4_d_prze_amt,
          `m_3_d_count`, `m_3_d_amount`, 
          (SELECT prze_amount as m_3_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_3_d_amount) AS m_3_d_prze_amt,
          `m_2_d_count`, `m_2_d_amount`, 
          (SELECT prze_amount as m_2_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_2_d_amount) AS m_2_d_prze_amt,
          `m_rf_i_count`, `m_rf_i_amount`, 
          (SELECT prze_amount as m_rf_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_rf_i_amount) AS m_rf_i_prze_amt,
          `m_sf_i_count`, `m_sf_i_amount`, 
          (SELECT prze_amount as m_sf_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_sf_i_amount) AS m_sf_i_prze_amt,
          `m_4k_i_count`, `m_4k_i_amount`, 
          (SELECT prze_amount as m_4k_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_4k_i_amount) AS m_4k_i_prze_amt,
          `m_fh_i_count`, `m_fh_i_amount`,
          (SELECT prze_amount as m_fh_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_fh_i_amount) AS m_fh_i_prze_amt,
           `m_f_i_count`, `m_f_i_amount`, 
          (SELECT prze_amount as m_f_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_f_i_amount) AS m_f_i_prze_amt,
          `m_s_i_count`, `m_s_i_amount`,
          (SELECT prze_amount as m_s_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_s_i_amount) AS m_s_i_prze_amt,
           `m_3k_i_count`, `m_3k_i_amount`, 
          (SELECT prze_amount as m_3k_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_3k_i_amount) AS m_3k_i_prze_amt,
          `m_2p_i_count`, `m_2p_i_amount`,
          (SELECT prze_amount as m_2p_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_2p_i_amount) AS m_2p_i_prze_amt,
           `m_pj_i_count`, `m_pj_i_amount`, 
          (SELECT prze_amount as m_pj_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_pj_i_amount) AS m_pj_i_prze_amt
          FROM `tbl_on_poker_winnings` AS tbl_poker_win, `tbl_on_poker` AS tbl_poker 
          
          WHERE tbl_poker_win.onpokerid = tbl_poker.onpokerid 
          
          AND tbl_poker.drawdate >= '%s' AND tbl_poker.drawdate <= '%s'",
                $st_drawdate, $ed_drawdate);
    $ssql .= sprintf(" order by tbl_poker.drawdate");
      
      $db_data = $this->db_obj->fetch($ssql);
     
     $sPokerCards = array("two" => array(1,2),
                       "three" => array(2,3),
                       "four" => array(3,4),
                       "five" => array(4,5),
                       "six" => array(5,6),
                       "seven" => array(6,7),
                       "eight" => array(7,8),
                       "nine" => array(8,9),
                       "ten" => array(9,10),
                       "jack" => array(10,"J"),
                       "queen" => array(11,"Q"),
                       "king" => array(12,"K"),
                       "ace" => array(13,"A")
                       );
                       
      $sPokerClass = array("clubs" => array(1,"C"),
                              "spades" => array(2,"S"),
                              "diamonds" => array(3,"D"),
                              "hearts" => array(4,"H")
                              );
      
      $spokerCards = $this->PokerCardsSort(strtolower(trim($scard1)), strtolower(trim($scard2)), strtolower(trim($scard3)), strtolower(trim($scard4)), strtolower(trim($scard5)));
      //print "\n<br />SSQL : " . $ssql;
      
      $imatch_cnt       = 0;
      $irow_cnt         = 0;
      $smatch_wins      = null;
      
      //print_r($spokerCards);
      if (count($spokerCards) < 5) {
        // duplicate cards found...
      } else {
          if (is_array($db_data)) {
              $smatch_wins      = array();
              $irow_cnt         = 0;
              
              $instant_win      = null;
              // Instant Poker Validation
                
                // 
                
                
                
                // Royal Flush  
                
                
                // Straight Flush  
                // 4 of a Kind 
                // Full House  
                // Flush Straight  
                // 3 of a Kind 
                // 2 Pair  Pair of Jacks or Better
              
              //
              
           
              
              $smatch_wins["instant_match"] = array();
              
              // Royal Flush
              if (
                    ($spokerCards[0][1] == $spokerCards[1][1] &&
                    $spokerCards[1][1] == $spokerCards[2][1] &&
                    $spokerCards[2][1] == $spokerCards[3][1] &&
                    $spokerCards[3][1] == $spokerCards[4][1]
                    ) &&
                    (
                    $spokerCards[0][0] == 9 && $spokerCards[1][0] == 10 &&
                    $spokerCards[2][0] == 11 && $spokerCards[3][0] == 12 && 
                    $spokerCards[4][0] == 13
                    )
                ) 
                {
                  // Royal Flush
                  $instant_win = "rf";
                  $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                  $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                  $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                  $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                  $smatch_wins["instant_match"][4] = $spokerCards[4][2];
                  
                  
              } elseif (
              
                  // Straight Flush
                  ($spokerCards[0][1] == $spokerCards[1][1] && 
                  $spokerCards[1][1] == $spokerCards[2][1] && 
                  $spokerCards[2][1] == $spokerCards[3][1] &&
                  $spokerCards[3][1] == $spokerCards[4][1] ) && 
                  ((    // 6 - 7 - 8 - 9 - 10
                  $spokerCards[0][0] == ($spokerCards[1][0] - 1) &&
                  $spokerCards[1][0] == ($spokerCards[2][0] - 1) &&
                  $spokerCards[2][0] == ($spokerCards[3][0] - 1) &&
                  $spokerCards[3][0] == ($spokerCards[4][0] - 1) 
                  ) || 
                  (    // A - 2 - 3 - 4 - 5
                  $spokerCards[4][0] == 13 && 
                  $spokerCards[0][0] == ($spokerCards[1][0] - 1) &&
                  $spokerCards[1][0] == ($spokerCards[2][0] - 1) &&
                  $spokerCards[2][0] == ($spokerCards[3][0] - 1)
                  ) 
                  )
                  ) {
                   // 10 - 9 - 8 - 7 - 6 
                   $instant_win = "sf";
                   if ($spokerCards[4][0] == 13) {
                     $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                     $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                     $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                     $smatch_wins["instant_match"][3] = $spokerCards[2][2];
                     $smatch_wins["instant_match"][4] = $spokerCards[3][2];                     
                   } else {
                     $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                     $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                     $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                     $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                     $smatch_wins["instant_match"][4] = $spokerCards[4][2];   
                   }

                   
                   
                  } elseif ( // 10 - 10 - 10 - 10 - 8
                  ( // Four of a kind
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0])
                  ||
                  (
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[4][0])                  
                  ||
                  (
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[4][0])
                  || 
                  (
                  $spokerCards[0][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[4][0])
                  ||
                  (
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0])
                  ||
                  (
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[4][0])
                  ) {
                    $instant_win = "4k";
                      if (
                       ( // Four of a kind
                          $spokerCards[0][0] == $spokerCards[1][0] &&
                          $spokerCards[1][0] == $spokerCards[2][0] &&
                          $spokerCards[2][0] == $spokerCards[3][0]) ) {
                          
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                      } elseif (
                          $spokerCards[0][0] == $spokerCards[1][0] &&
                          $spokerCards[1][0] == $spokerCards[2][0] &&
                          $spokerCards[2][0] == $spokerCards[4][0]) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][3] = $spokerCards[4][2];
                      } elseif (
                        $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[1][0] == $spokerCards[3][0] &&
                        $spokerCards[3][0] == $spokerCards[4][0]) {
                       $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                       $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                       $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                       $smatch_wins["instant_match"][3] = $spokerCards[4][2];                          
                      } elseif (
                        $spokerCards[0][0] == $spokerCards[2][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0] &&
                        $spokerCards[3][0] == $spokerCards[4][0]) {
                         $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                         $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                         $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                         $smatch_wins["instant_match"][3] = $spokerCards[4][2];  
                      } elseif (
                        $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[1][0] == $spokerCards[2][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0]) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][3] = $spokerCards[3][2];  
                      } elseif  (
                        $spokerCards[1][0] == $spokerCards[2][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0] &&
                        $spokerCards[3][0] == $spokerCards[4][0]) {
                         $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                         $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                         $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                         $smatch_wins["instant_match"][3] = $spokerCards[4][2];   
                     }



                    
                  } elseif (
                  //full house
                  ((
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0]
                  ) && ($spokerCards[3][0] == $spokerCards[4][0]))
                  || 
                  ((
                  $spokerCards[4][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0]
                  ) && ($spokerCards[3][0] == $spokerCards[0][0]))
                  ||
                  (
                  (
                  $spokerCards[0][0] == $spokerCards[4][0] &&
                  $spokerCards[4][0] == $spokerCards[2][0]
                  ) && ($spokerCards[3][0] == $spokerCards[1][0]))
                  ||
                  (
                  (
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[4][0]
                  ) && ($spokerCards[3][0] == $spokerCards[2][0]))
                  ||
                  (
                  (
                  $spokerCards[3][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0]
                  ) && ($spokerCards[0][0] == $spokerCards[4][0]))
                  ||
                  ((
                  $spokerCards[0][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[2][0]
                  ) && ($spokerCards[1][0] == $spokerCards[4][0]))
                  ||
                  ((
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[3][0]
                  ) && ($spokerCards[2][0] == $spokerCards[4][0]))
                  || (
                  (
                  $spokerCards[3][0] == $spokerCards[4][0] &&
                  $spokerCards[4][0] == $spokerCards[2][0]
                  ) && ($spokerCards[0][0] == $spokerCards[1][0]))
                  || ((
                  $spokerCards[3][0] == $spokerCards[4][0] &&
                  $spokerCards[4][0] == $spokerCards[1][0]
                  ) && ($spokerCards[0][0] == $spokerCards[2][0]))
                  || ((
                  $spokerCards[3][0] == $spokerCards[4][0] &&
                  $spokerCards[4][0] == $spokerCards[0][0]
                  ) && ($spokerCards[1][0] == $spokerCards[2][0])) 
                  ) {
                    $instant_win = "fh";
                    
                    if (($spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[1][0] == $spokerCards[2][0]
                        ) && ($spokerCards[3][0] == $spokerCards[4][0])) {
                          $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                          $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                          $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                          $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                          $smatch_wins["instant_match"][4] = $spokerCards[4][2];
                          
                     } elseif (($spokerCards[4][0] == $spokerCards[1][0] &&
                              $spokerCards[1][0] == $spokerCards[2][0]
                              ) && ($spokerCards[3][0] == $spokerCards[0][0])) {
                          $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                          $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                          $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                          $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                          $smatch_wins["instant_match"][4] = $spokerCards[0][2];      
                                
                     } elseif (
                            (
                            $spokerCards[0][0] == $spokerCards[4][0] &&
                            $spokerCards[4][0] == $spokerCards[2][0]
                            ) && ($spokerCards[3][0] == $spokerCards[1][0])) {
                              
                            $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                            $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                            $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                            $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                            $smatch_wins["instant_match"][4] = $spokerCards[1][2];    
                            }
                        
                  
                  
                  
                  } elseif (
                  // flush
                  // five cards all in same suit
                  ($spokerCards[0][1] == $spokerCards[1][1] &&
                  $spokerCards[1][1] == $spokerCards[2][1] &&
                  $spokerCards[2][1] == $spokerCards[3][1] &&
                  $spokerCards[3][1] == $spokerCards[4][1]))
                  {
                    $instant_win = "f";
                    $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                    $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                    $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                    $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                    $smatch_wins["instant_match"][4] = $spokerCards[4][2];    
                    
                  } elseif (
                  // straight
                  (    // 6 - 7 - 8 - 9 - 10
                  $spokerCards[0][0] == ($spokerCards[1][0] - 1) &&
                  $spokerCards[1][0] == ($spokerCards[2][0] - 1) &&
                  $spokerCards[2][0] == ($spokerCards[3][0] - 1) &&
                  $spokerCards[3][0] == ($spokerCards[4][0] - 1) 
                  ) || 
                  (    // A - 2 - 3 - 4 - 5
                  $spokerCards[4][0] == 13 && 
                  $spokerCards[0][0] == ($spokerCards[1][0] - 1) &&
                  $spokerCards[1][0] == ($spokerCards[2][0] - 1) &&
                  $spokerCards[2][0] == ($spokerCards[3][0] - 1)
                  ) 
                  
                  ) {
                    $instant_win = "s";
                    if ($spokerCards[4][0] == 13) {
                      $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                      $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                      $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                      $smatch_wins["instant_match"][3] = $spokerCards[2][2];
                      $smatch_wins["instant_match"][4] = $spokerCards[3][2];  
                    } else {
                      $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                      $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                      $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                      $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                      $smatch_wins["instant_match"][4] = $spokerCards[4][2];  
                    }
                    
                  } elseif (
                  // three of a kind
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[2][0]
                  ) || 
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[4][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[0][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[4][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[1][0] == $spokerCards[2][0] &&
                  $spokerCards[2][0] == $spokerCards[4][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[2][0] == $spokerCards[3][0] &&
                  $spokerCards[3][0] == $spokerCards[4][0]
                  ) ||
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[3][0] == $spokerCards[0][0] &&
                  $spokerCards[0][0] == $spokerCards[4][0]
                  ) || 
                  ( //9C - 9D - 9H - 6C - 2H
                  $spokerCards[3][0] == $spokerCards[1][0] &&
                  $spokerCards[1][0] == $spokerCards[4][0]
                  )
                  
                  
                  ) {
                    $instant_win = "3k";
                    
                    if ( //9C - 9D - 9H - 6C - 2H
                        $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[1][0] == $spokerCards[2][0]
                        ) {
                            $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                            $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                            $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                        } elseif   
                          ( //9C - 9D - 9H - 6C - 2H
                          $spokerCards[0][0] == $spokerCards[1][0] &&
                          $spokerCards[1][0] == $spokerCards[3][0]
                          ) {
                            $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                            $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                            $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                                  
                          } elseif 
                            ( //9C - 9D - 9H - 6C - 2H
                            $spokerCards[0][0] == $spokerCards[1][0] &&
                            $spokerCards[1][0] == $spokerCards[4][0]
                            ) {
                              $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                              $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                              $smatch_wins["instant_match"][2] = $spokerCards[4][2];
                              
                            } elseif  ( //9C - 9D - 9H - 6C - 2H
                              $spokerCards[0][0] == $spokerCards[2][0] &&
                              $spokerCards[2][0] == $spokerCards[3][0]
                              ) {
                                    $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                                    $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                                    $smatch_wins["instant_match"][2] = $spokerCards[3][2];
                              } elseif 
                            ( //9C - 9D - 9H - 6C - 2H
                            $spokerCards[0][0] == $spokerCards[2][0] &&
                            $spokerCards[2][0] == $spokerCards[4][0]
                            ) {
                                $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                                $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                                $smatch_wins["instant_match"][2] = $spokerCards[4][2];

                            } elseif 
                            ( //9C - 9D - 9H - 6C - 2H
                            $spokerCards[1][0] == $spokerCards[2][0] &&
                            $spokerCards[2][0] == $spokerCards[3][0]
                            ) {
                                $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                                $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                                $smatch_wins["instant_match"][2] = $spokerCards[3][2];

                            } elseif 
                              ( //9C - 9D - 9H - 6C - 2H
                              $spokerCards[1][0] == $spokerCards[2][0] &&
                              $spokerCards[2][0] == $spokerCards[4][0]
                              ) {
                                  $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                                  $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                                  $smatch_wins["instant_match"][2] = $spokerCards[4][2];

                                
                              } elseif 
                                  ( //9C - 9D - 9H - 6C - 2H
                                  $spokerCards[2][0] == $spokerCards[3][0] &&
                                  $spokerCards[3][0] == $spokerCards[4][0]
                                  ) {
                                  $smatch_wins["instant_match"][0] = $spokerCards[2][2];
                                  $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                                  $smatch_wins["instant_match"][2] = $spokerCards[4][2];                                    
                                  } elseif 
                                ( //9C - 9D - 9H - 6C - 2H
                                $spokerCards[3][0] == $spokerCards[0][0] &&
                                $spokerCards[0][0] == $spokerCards[4][0]
                                ) {
                                  $smatch_wins["instant_match"][0] = $spokerCards[3][2];
                                  $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                                  $smatch_wins["instant_match"][2] = $spokerCards[4][2];
                                }elseif 
                                  ( //9C - 9D - 9H - 6C - 2H
                                $spokerCards[3][0] == $spokerCards[1][0] &&
                                $spokerCards[1][0] == $spokerCards[4][0]
                                ) {
                            $smatch_wins["instant_match"][0] = $spokerCards[3][2];
                            $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                            $smatch_wins["instant_match"][2] = $spokerCards[4][2];
                                }
              
                    
                  } elseif (
                  // 2 pair
                  ( $spokerCards[0][0] == $spokerCards[1][0] &&
                    $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[1][0] &&
                    $spokerCards[2][0] == $spokerCards[4][0]
                  ) || 
                  ( $spokerCards[0][0] == $spokerCards[1][0] &&
                    $spokerCards[4][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[2][0] &&
                    $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[3][0] &&
                    $spokerCards[1][0] == $spokerCards[2][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[4][0] &&
                    $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[0][0] == $spokerCards[4][0] &&
                    $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[1][0] == $spokerCards[4][0] &&
                    $spokerCards[0][0] == $spokerCards[2][0]
                  ) ||
                  ( $spokerCards[1][0] == $spokerCards[4][0] &&
                    $spokerCards[0][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[1][0] == $spokerCards[4][0] &&
                    $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[2][0] == $spokerCards[0][0] &&
                    $spokerCards[1][0] == $spokerCards[4][0]
                  ) ||
                  ( $spokerCards[3][0] == $spokerCards[0][0] &&
                    $spokerCards[1][0] == $spokerCards[4][0]
                  ) ||
                  ( $spokerCards[4][0] == $spokerCards[0][0] &&
                    $spokerCards[2][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[4][0] == $spokerCards[2][0] &&
                    $spokerCards[1][0] == $spokerCards[3][0]
                  ) ||
                  ( $spokerCards[4][0] == $spokerCards[3][0] &&
                    $spokerCards[0][0] == $spokerCards[1][0]
                  ) ||
                  ( $spokerCards[4][0] == $spokerCards[3][0] &&
                    $spokerCards[2][0] == $spokerCards[1][0]
                  )
                  
                  ) {
                    $instant_win = "2p";
                    
                     if ( $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];

                      } elseif  
                      ( $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[2][0] == $spokerCards[4][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[4][2];

                      } elseif
                      ( $spokerCards[0][0] == $spokerCards[1][0] &&
                        $spokerCards[4][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                        
                      } elseif 
                      ( $spokerCards[0][0] == $spokerCards[2][0] &&
                        $spokerCards[1][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];
                      } elseif 
                      ( $spokerCards[0][0] == $spokerCards[3][0] &&
                        $spokerCards[1][0] == $spokerCards[2][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[2][2];                          
                      } elseif 
                      ( $spokerCards[0][0] == $spokerCards[4][0] &&
                        $spokerCards[1][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                      } elseif
                      ( $spokerCards[0][0] == $spokerCards[4][0] &&
                        $spokerCards[1][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                      } elseif 
                      ( $spokerCards[1][0] == $spokerCards[4][0] &&
                        $spokerCards[0][0] == $spokerCards[2][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[2][2];   
                      } elseif 
                      ( $spokerCards[1][0] == $spokerCards[4][0] &&
                        $spokerCards[0][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                      } elseif 
                      ( $spokerCards[1][0] == $spokerCards[4][0] &&
                        $spokerCards[2][0] == $spokerCards[3][0]
                      ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[2][2];   
                      } elseif ( $spokerCards[2][0] == $spokerCards[0][0] &&
                                  $spokerCards[1][0] == $spokerCards[4][0]
                       ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[2][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[4][2];   
                       } elseif  ( $spokerCards[3][0] == $spokerCards[0][0] &&
                                    $spokerCards[1][0] == $spokerCards[4][0]
                       ) {
                        $smatch_wins["instant_match"][0] = $spokerCards[3][2];
                        $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                        $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                        $smatch_wins["instant_match"][3] = $spokerCards[4][2];   
                       } elseif  ( $spokerCards[4][0] == $spokerCards[0][0] &&
                                  $spokerCards[2][0] == $spokerCards[3][0]
                          ) {
                             $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                             $smatch_wins["instant_match"][1] = $spokerCards[0][2];
                             $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                             $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                          } elseif ( $spokerCards[4][0] == $spokerCards[2][0] &&
                                      $spokerCards[1][0] == $spokerCards[3][0]
                            ) {
                               $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                               $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                               $smatch_wins["instant_match"][2] = $spokerCards[1][2];
                               $smatch_wins["instant_match"][3] = $spokerCards[3][2];   
                              
                            } elseif ( $spokerCards[4][0] == $spokerCards[3][0] &&
                                       $spokerCards[0][0] == $spokerCards[1][0]
                             ) {
                               $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                               $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                               $smatch_wins["instant_match"][2] = $spokerCards[0][2];
                               $smatch_wins["instant_match"][3] = $spokerCards[1][2];   
                             } elseif ( $spokerCards[4][0] == $spokerCards[3][0] &&
                                        $spokerCards[2][0] == $spokerCards[1][0]
                              ) {
                               $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                               $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                               $smatch_wins["instant_match"][2] = $spokerCards[2][2];
                               $smatch_wins["instant_match"][3] = $spokerCards[1][2];  
                              }
                    
                    
                    
                    
                  } elseif (
                  
                  
                    ( ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 13) ) ||
                   ( ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 13) ) ||
                   ( ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 13) ) ||
                    ( ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 13) ) ||
                    ( ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 13) ) ||
                    ( ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 13) ) ||
                    ( ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 13) ) ||
                    ( ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 10) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 11) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 12) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 13) ) ||
                    ( ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 10) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 11) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 12) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 13) ) ||
                    ( ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 10) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 11) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 12) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 13) )
                   
                  
                  
                  ) {
                    $instant_win = "pj";
                    
                     if ( ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[1][0] && $spokerCards[0][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[4][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                      } elseif ( ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[2][0] && $spokerCards[0][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                      } elseif ( ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[3][0] && $spokerCards[0][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                      } elseif ( ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 10) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 11) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 12) ||
                      ($spokerCards[0][0] == $spokerCards[4][0] && $spokerCards[0][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[0][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        
                      } elseif ( ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[2][0] && $spokerCards[1][0] == 13) ) 
                      {
                          $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                          $smatch_wins["instant_match"][1] = $spokerCards[2][2];
                      } elseif ( ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[3][0] && $spokerCards[1][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                      } elseif  ( ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 10) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 11) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 12) ||
                      ($spokerCards[1][0] == $spokerCards[4][0] && $spokerCards[1][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[1][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                        
                      } elseif  ( ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 10) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 11) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 12) ||
                      ($spokerCards[2][0] == $spokerCards[3][0] && $spokerCards[2][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[3][2];
                        
                      } elseif ( ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 10) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 11) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 12) ||
                      ($spokerCards[2][0] == $spokerCards[4][0] && $spokerCards[2][0] == 13) )  {
                           $smatch_wins["instant_match"][0] = $spokerCards[2][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                      } elseif ( ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 10) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 11) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 12) ||
                      ($spokerCards[3][0] == $spokerCards[4][0] && $spokerCards[3][0] == 13) ) {
                           $smatch_wins["instant_match"][0] = $spokerCards[3][2];
                           $smatch_wins["instant_match"][1] = $spokerCards[4][2];
                      }
            
                  }
                $smatch_wins["instant_win"]  = $instant_win; 
                  
                  
                  
                  /* elseif (
                  (
                  
                  
                  )
                  
                  ) {
                    
                    
                  }
                */
              
              
              foreach ($db_data as $db_row) {
                $imatch_cnt       = 0;
                $smatch_wins[$irow_cnt]     = array(
                    "drawdate"            => $db_row["drawdate"],
                    "match_cnt"           => 0,
                    "match_cards"         => array(),
                    "instant_cards_win"   => $smatch_wins["instant_match"],
                    "instant_win_type"    => $instant_win
                );
                  
                //print_r($db_row);
                //print_r($spokerCards);
                $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_row["scard1"], $db_row["scard2"], $db_row["scard3"],
                                                                $db_row["scard4"], $db_row["scard5"]);
                                                                
                
                
                if (strtolower($db_row["scard1"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard1"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard1"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard1"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard1"]) == strtolower($spokerCards[4][2])) {
                  
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard1"]; 
                  $imatch_cnt++;
                } 
                if (strtolower($db_row["scard2"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard2"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard2"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard2"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard2"]) == strtolower($spokerCards[4][2])) {
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard2"]; 
                  $imatch_cnt++;
                }
                if (strtolower($db_row["scard3"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard3"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard3"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard3"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard3"]) == strtolower($spokerCards[4][2])) {
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard3"]; 
                  $imatch_cnt++;
                }
                if (strtolower($db_row["scard4"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard4"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard4"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard4"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard4"]) == strtolower($spokerCards[4][2])) {
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard4"]; 
                  $imatch_cnt++;
                } 
                if (strtolower($db_row["scard5"]) == strtolower($spokerCards[0][2]) || strtolower($db_row["scard5"]) == strtolower($spokerCards[1][2]) || strtolower($db_row["scard5"]) == strtolower($spokerCards[2][2]) || strtolower($db_row["scard5"]) == strtolower($spokerCards[3][2]) || strtolower($db_row["scard5"]) == strtolower($spokerCards[4][2])) {
                  $smatch_wins[$irow_cnt]["match_cards"][$imatch_cnt] = $db_row["scard5"]; 
                  $imatch_cnt++;
                }
              
              

                $smatch_wins[$irow_cnt]["match_cnt"]    = $imatch_cnt;
                if ($instant_win == "rf") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_rf_i_prze_amt"];
                } elseif ($instant_win == "sf") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_sf_i_prze_amt"];
                } elseif ($instant_win == "4k") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_4k_i_prze_amt"];
                } elseif ($instant_win == "fh") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_fh_i_prze_amt"];
                } elseif ($instant_win == "f") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_f_i_prze_amt"];
                } elseif ($instant_win == "s") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_s_i_prze_amt"];
                } elseif ($instant_win == "3k") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_3k_i_prze_amt"];
                } elseif ($instant_win == "2p") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_2p_i_prze_amt"];
                } elseif ($instant_win == "pj") {
                  $smatch_wins[$irow_cnt]["instant_win_prze_amt"] = $db_row["m_pj_i_prze_amt"];
                }
              
                if ($imatch_cnt == 5) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_5_d_prze_amt"];
                } elseif ($imatch_cnt == 4) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_4_d_prze_amt"];
                } elseif ($imatch_cnt == 3) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_3_d_prze_amt"];
                } elseif ($imatch_cnt == 2) {
                  $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_row["m_2_d_prze_amt"];
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
      * startdrawdate
      * enddrawdate
     * $drawdate
     * scard1
     * scard2
     * scard3
     * scard4
     * scard5
     * 
     * 
     */ 
    
    function OLGPokerValidate($startdrawdate, $enddrawdate, $drawdate = "", $scard1, $scard2, $scard3, $scard4, $scard5) {
        
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
  
        $ssql = sprintf("SELECT * FROM `tbl_on_poker` ");
        $ssql .= sprintf(" drawdate >= '%s' AND drawdate <= '%s' ", $startdrawdate, $enddrawdate);

        
        $db_data = $this->db_obj->fetch($ssql);
  
        if (is_array($db_data)) {
            foreach ($db_data as $db_row) {
            
              if ($db_row["scard1"] == $scard1 || $db_row["scard1"] == $scard2 || $db_row["scard1"] == $scard3 || $db_row["scard1"] == $scard4 || $db_row["scard1"] == $scard5) {
                
              } elseif ($db_row["scard2"] == $scard1 || $db_row["scard2"] == $scard2 || $db_row["scard2"] == $scard3 || $db_row["scard2"] == $scard4 || $db_row["scard1"] == $scard5) {
            
              } elseif ($db_row["scard3"] == $scard1 || $db_row["scard3"] == $scard2 || $db_row["scard3"] == $scard3 || $db_row["scard3"] == $scard4 || $db_row["scard1"] == $scard5) {
            
              } elseif ($db_row["scard4"] == $scard1 || $db_row["scard4"] == $scard2 || $db_row["scard4"] == $scard3 || $db_row["scard4"] == $scard4 || $db_row["scard1"] == $scard5) {
                
              } elseif ($db_row["scard5"] == $scard1 || $db_row["scard5"] == $scard2 || $db_row["scard5"] == $scard3 || $db_row["scard5"] == $scard4 || $db_row["scard1"] == $scard5) {
                
              }
            }
      }
      
    }
    
    function OLGPokerGetMonth() {
      
    }
    function OLGPokerGetYear() {
      
    }
    function OLGPokerGetAll() {
      
    }
    
    /*
     * 
     * Payday
     * 
     * drawdate
     * idrawnum
     * snum1
     * snum2
     * snum3
     * snum4
     * 
     * 
     * 
     */
     
         
    function OLGPayDayAdd($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $drawNo, $sdrawDate, $spielID) {
      
    }
    function OLGPayDayRemove() {
      
    }
    function OLGPayDayModify() {
      
    }
    function OLGPayDayGet() {
      
    }
    function OLGPayDayGetMonth() {
      
    }
    function OLGPayDayGetYear() {
      
    }
    function OLGPayDayGetAll() {
      
    }
    
    /*
     * Encore 
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
     * 
     * return: onencoreid
     * 
     * Feb 13 2013
     *  Draw Time added to OLGEncoreAdd  and OLGEncoreGetDrawId
     */
     
         
    function OLGEncoreAdd($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $sdrawTime = "") {
 
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
      if ($sdrawTime != "") {
      	$ssql = sprintf("INSERT INTO `tbl_on_encore` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snum7`, `gameTime`) ");
      	$ssql .= sprintf(" VALUES(%u,'%s',%u,%u,%u,%u,%u,%u,%u, '%s')", $idrawnum, $drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $sdrawTime);
      	 
      } else {
      	$ssql = sprintf("INSERT INTO `tbl_on_encore` (`idrawnum`,`drawdate`,`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snum7`) ");
      	$ssql .= sprintf(" VALUES(%u,'%s',%u,%u,%u,%u,%u,%u,%u)", $idrawnum, $drawdate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7);
      	 
      }

      $rows_affected = $this->db_obj->exec($ssql);      
      return $this->db_obj->last_id;
    }
    function OLGEncoreRemove($drawdate, $onencoreid = "") {
 
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
      $ssql = sprintf("DELETE FROM `tbl_on_encore` WHERE `drawdate` = '%s'", $drawdate);
      if ($onencoreid != "") {
        $ssql .= sprintf(" AND onencoreid = %u", $onencoreid);
      }      
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
    }
    
    function OLGEncoreModify($onencoreid, $drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf(" UPDATE `tbl_on_encore` SET ");
     $ssql .= sprintf("`drawdate` = '%s',`snum1` = %u,`snum2` = %u,`snum3` = %u,`snum4` = %u,`snum5` = %u,`snum6` = %u,`snum7` = %u ", $drawdate,  $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7);
     $ssql .= sprintf(" WHERE onencoreid = %u", $onencoreid);
     
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
     
    }
    
     function OLGEncoreGetFirstLastDataAvail() {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT min(drawdate) as EarliestDate from `tbl_on_encore`");
      $db_res = $this->db_obj->fetch($ssql);
      $data_avail = array();
      if (is_array($db_res)) {
        $data_avail["earliest"] = $db_res[0]["EarliestDate"];
      }
      $ssql = sprintf("SELECT max(drawdate) as LatestDate from `tbl_on_encore`");
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
    
    
    function OLGEncoreGetSingleDraw($drawdate, $onencoreid) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf(" SELECT * FROM `tbl_on_encore` WHERE drawdate = '%s' ", $drawdate);
     if ($onencoreid != "") {
       $ssql .= sprintf(" AND onencoreid = %u", $onencoreid);
     } 
     
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res[0];
     } else {
       return null;
     }
     
    }
    
    function OLGEncoreGetDraw($st_drawdate, $ed_drawdate, $st_pos = 0, $limit = 350) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_encore` WHERE drawdate >= '%s' AND drawdate <= '%s'",
                    $st_drawdate, $ed_drawdate);
      $ssql .= sprintf(" order by drawdate");
      $db_res = $this->db_obj->fetch($ssql);
      //print "\n<br />SSQL: " . $ssql;
      if (is_array($db_res)) {
        return $db_res;
      } else {
        return null;
      }
                    
      
    }
    
    
    function OLGEncoreGetDrawId($drawdate, $sdrawTime = "") {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     if ($sdrawTime != "") {
     	$ssql = sprintf(" SELECT * FROM `tbl_on_encore` WHERE drawdate = '%s' AND gameTime = '%s' ", $drawdate, $sdrawTime);
     	
     } else {
     	$ssql = sprintf(" SELECT * FROM `tbl_on_encore` WHERE drawdate = '%s' ", $drawdate);
     	
     }
     //print "SSQL : " . $ssql;
     
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       //print_r($db_res);
       //print $db_res[0]["onencoreid"];
       return $db_res[0]["onencoreid"];
       
     } else {
       return null;
     }
     
    }
    
    function OLGEncoreValidateDraw( $st_drawdate, $ed_drawdate,$snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      

     $ssql = sprintf("SELECT tbl_enc.*, tbl_enc_win.`onencorewinningid` as onencorewinningid, tbl_enc_win.`onencoreid` as onencoreid, 
          `m_7_rl_count`, `m_7_rl_amount`, 
          (SELECT prze_amount as m_7_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_7_rl_amount) AS m_7_rl_prze_amt,
                
          `m_6_rl_count`, `m_6_rl_amount`, 
          
          (SELECT prze_amount as m_6_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_6_rl_amount) AS m_6_rl_prze_amt,
                
          `m_5_rl_count`, `m_5_rl_amount`, 
          (SELECT prze_amount as m_5_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_5_rl_amount) AS m_5_rl_prze_amt,

          `m_4_rl_count`, `m_4_rl_amount`, 
          (SELECT prze_amount as m_4_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_4_rl_amount) AS m_4_rl_prze_amt,
          
          `m_3_rl_count`, `m_3_rl_amount`, 
          (SELECT prze_amount as m_3_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_3_rl_amount) AS m_3_rl_prze_amt,
          
          `m_2_rl_count`, `m_2_rl_amount`, 
          (SELECT prze_amount as m_2_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_2_rl_amount) AS m_2_rl_prze_amt,
          
          `m_1_rl_count`, `m_1_rl_amount`, 
          (SELECT prze_amount as m_1_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_1_rl_amount) AS m_1_rl_prze_amt,
          
          `m_6_lr_count`, `m_6_lr_amount`,
          (SELECT prze_amount as m_6_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_6_lr_amount) AS m_6_lr_prze_amt,
           
          `m_5_lr_count`, `m_5_lr_amount`, 
          (SELECT prze_amount as m_5_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_5_lr_amount) AS m_5_lr_prze_amt,
          
          `m_4_lr_count`, `m_4_lr_amount`, 
          (SELECT prze_amount as m_4_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_4_lr_amount) AS m_4_lr_prze_amt,
          
          `m_3_lr_count`, `m_3_lr_amount`, 
          (SELECT prze_amount as m_3_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_3_lr_amount) AS m_3_lr_prze_amt,
          
          `m_2_lr_count`, `m_2_lr_amount`, 
          (SELECT prze_amount as m_2_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_2_lr_amount) AS m_2_lr_prze_amt,
          
          `m_f5_l1_count`, `m_f5_l1_amount`,
          (SELECT prze_amount as m_f5_l1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f5_l1_amount) AS m_f5_l1_prze_amt,
            
          
           `m_f4_l2_count`, `m_f4_l2_amount`, 
          (SELECT prze_amount as m_f4_l2_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f4_l2_amount) AS m_f4_l2_prze_amt,
           
           `m_f4_l1_count`, `m_f4_l1_amount`, 
          (SELECT prze_amount as m_f4_l1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f4_l1_amount) AS m_f4_l1_prze_amt,
                 
           `m_f3_l3_count`, `m_f3_l3_amount`,
           (SELECT prze_amount as m_f3_l3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f3_l3_amount) AS m_f3_l3_prze_amt,
          
            `m_f3_l2_count`, `m_f3_l2_amount`, 
            (SELECT prze_amount as m_f3_l2_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f3_l2_amount) AS m_f3_l2_prze_amt,
          
            `m_f3_l1_count`, `m_f3_l1_amount`, 
            (SELECT prze_amount as m_f3_l1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f3_l1_amount) AS m_f3_l1_prze_amt,
          
            `m_f2_l4_count`, `m_f2_l4_amount`,
            (SELECT prze_amount as m_f2_l4_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f2_l4_amount) AS m_f2_l4_prze_amt,
           
            `m_f2_l3_count`, `m_f2_l3_amount`,
            (SELECT prze_amount as m_f2_l3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f2_l3_amount) AS m_f2_l3_prze_amt,
          
             `m_f2_l2_count`, `m_f2_l2_amount`,
             (SELECT prze_amount as m_f2_l2_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f2_l2_amount) AS m_f2_l2_prze_amt,
           
             `m_f2_l1_count`, `m_f2_l1_amount`,         
             (SELECT prze_amount as m_f2_l1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f2_l1_amount) AS m_f2_l1_prze_amt
           
          FROM `tbl_on_encore_winnings` as tbl_enc_win, `tbl_on_encore` as tbl_enc 
          WHERE tbl_enc_win.onencoreid = tbl_enc.onencoreid AND tbl_enc.drawdate >= '%s' AND tbl_enc.drawdate <= '%s'",
                $st_drawdate, $ed_drawdate);
          $ssql .= sprintf(" order by tbl_enc.drawdate");
      $db_rs = $this->db_obj->fetch($ssql);
      //print "\n<br /> SSQL: " . $ssql;
      //print_r($db_rs);
      
      $scomb_num = array(
            $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7);
      
      if (count($scomb_num) == 7) {
        if (is_array($db_rs)) {
            foreach($db_rs as $db_res) {
                $imatch_cnt                 = 0;
                $ibonus_match               = 0;
                $encore_win                 = null;
                $smatch_wins[$irow_cnt]     = array(
                    "drawdate"        => $db_res["drawdate"],
                    "match_cnt"       => 0,
                    "match_numbers"   => array(),
                    "num_match_ar"    => array(),     // numbers match when theres no actual win
                    "num_match_cnt"   => 0,
                    "match_bonus"     => 0,
                    "match_bonus_num" => 0,
                    "encore_win"      => ""
                );
                //print_r($scomb_num);
            $smatch_wins[$irow_cnt]["draw_numbers"] = array($db_res["snum1"], $db_res["snum2"], $db_res["snum3"], $db_res["snum4"], $db_res["snum5"], $db_res["snum6"], $db_res["snum7"]);
            
            if ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum4"] == $scomb_num[3] && $db_res["snum5"] == $scomb_num[4] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //5713572
              $encore_win = "7_rl";
              $imatch_cnt = 7;
              $smatch_wins[$irow_cnt]["match_numbers"] = array(
                                              $scomb_num[0], $scomb_num[1],$scomb_num[2],$scomb_num[3],$scomb_num[4],$scomb_num[5],$scomb_num[6]);
            } elseif ($db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum4"] == $scomb_num[3] && $db_res["snum5"] == $scomb_num[4] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //_713572
              $encore_win = "6_rl";
              //$smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                  null, $scomb_num[1],$scomb_num[2],$scomb_num[3],$scomb_num[4],$scomb_num[5],$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 6;
                            
            } elseif ($db_res["snum3"] == $scomb_num[2] && $db_res["snum4"] == $scomb_num[3] && $db_res["snum5"] == $scomb_num[4] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //__13572
              $encore_win = "5_rl";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                null, null,$scomb_num[2],$scomb_num[3],$scomb_num[4],$scomb_num[5],$scomb_num[6]);
                                              

              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              $imatch_cnt = 5;
            } elseif ($db_res["snum4"] == $scomb_num[3] && $db_res["snum5"] == $scomb_num[4] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //___3572
              $encore_win = "4_rl";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                null, null, null,$scomb_num[3],$scomb_num[4],$scomb_num[5],$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];   
              $imatch_cnt = 4;                            
            } elseif ($db_res["snum5"] == $scomb_num[4] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //____572
              $encore_win = "3_rl";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                null, null, null, null,$scomb_num[4],$scomb_num[5],$scomb_num[6]);
              
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              $imatch_cnt = 3;
            } elseif ($db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //_____72
              $encore_win = "2_rl";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                null, null, null,null, null,$scomb_num[5],$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              $imatch_cnt = 2;
            } elseif ($db_res["snum7"] == $scomb_num[6]) {
              //______2
              $encore_win = "1_rl";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                null, null, null, null, null, null,$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              $imatch_cnt = 1;
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum4"] == $scomb_num[3] && $db_res["snum5"] == $scomb_num[4] && $db_res["snum6"] == $scomb_num[5]) {
              //571357_
              $encore_win = "6_lr";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],$scomb_num[3],$scomb_num[4],$scomb_num[5],null);

              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $imatch_cnt = 6;

            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum4"] == $scomb_num[3] && $db_res["snum5"] == $scomb_num[4]) {
              //57135__
              $encore_win = "5_lr";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],$scomb_num[3],$scomb_num[4],null,null);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              
              $imatch_cnt = 5;

              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum4"] == $scomb_num[3]) {
              //5713___
              $encore_win = "4_lr";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],$scomb_num[3],null,null,null);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];

              $imatch_cnt = 4;
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2]){
              //571____
              $encore_win = "3_lr";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],null,null,null,null);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              
              $imatch_cnt = 3;
              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1]) {
              //57_____
              $encore_win = "2_lr";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],null,null,null,null,null);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];

              $imatch_cnt = 2;
              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum4"] == $scomb_num[3] && $db_res["snum5"] == $scomb_num[4] && $db_res["snum7"] == $scomb_num[6]) {
              //57135_2
              $encore_win = "f5_l1";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],$scomb_num[3],$scomb_num[4],null,$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 6;
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum4"] == $scomb_num[3] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //5713_72
              $encore_win = "f4_l2";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],$scomb_num[3],null,$scomb_num[5],$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 6;
              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum4"] == $scomb_num[3] && $db_res["snum7"] == $scomb_num[6]) {
              //5713__2
              $encore_win = "f4_l1";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],$scomb_num[3],null,null,$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 5;
              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum5"] == $scomb_num[4] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //571_572
              $encore_win = "f3_l3";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],null,$scomb_num[4],$scomb_num[5],$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 6;
              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //571__72
              $encore_win = "f3_l2";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],null,null,$scomb_num[5],$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 5;
              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum3"] == $scomb_num[2] && $db_res["snum7"] == $scomb_num[6]) {
              //571___2
              $encore_win = "f3_l1";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],$scomb_num[2],null,null,null,$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 4;
              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum4"] == $scomb_num[3] && $db_res["snum5"] == $scomb_num[4] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //57_3572
              $encore_win = "f2_l4";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],null,$scomb_num[3],$scomb_num[4],$scomb_num[5],$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][2] = $scomb_num[2];
              $smatch_wins[$irow_cnt]["match_numbers"][3] = $scomb_num[3];
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              
              $imatch_cnt = 6;
              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum5"] == $scomb_num[4] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //57__572
              $encore_win = "f2_l3";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],null,null,$scomb_num[4],$scomb_num[5],$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              $smatch_wins[$irow_cnt]["match_numbers"][4] = $scomb_num[4];
              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 5;
              
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum6"] == $scomb_num[5] && $db_res["snum7"] == $scomb_num[6]) {
              //57___72
              $encore_win = "f2_l2";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],null,null,null,$scomb_num[5],$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];

              $smatch_wins[$irow_cnt]["match_numbers"][5] = $scomb_num[5];              
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 4;
            } elseif ($db_res["snum1"] == $scomb_num[0] && $db_res["snum2"] == $scomb_num[1] && $db_res["snum7"] == $scomb_num[6]) {
              //57____2
              $encore_win = "f2_l1";
              //              $smatch_wins[$irow_cnt]["match_numbers"] = array(
              //                                $scomb_num[0], $scomb_num[1],null,null,null,null,$scomb_num[6]);
              $smatch_wins[$irow_cnt]["match_numbers"][0] = $scomb_num[0];
              $smatch_wins[$irow_cnt]["match_numbers"][1] = $scomb_num[1];
              
              $smatch_wins[$irow_cnt]["match_numbers"][6] = $scomb_num[6];
              
              $imatch_cnt = 3;              

            } else {
              $encore_win = null;
              
              $num_match_cnt = 0;
              if ($db_res["snum1"] == $scomb_num[0]) {
                $smatch_wins[$irow_cnt]["num_match_ar"][0] = $db_res["snum1"];
                $num_match_cnt++;
              }
              if ($db_res["snum2"] == $scomb_num[1]) {
                $smatch_wins[$irow_cnt]["num_match_ar"][1] = $db_res["snum2"];                
                $num_match_cnt++;
              }
              if ($db_res["snum3"] == $scomb_num[2]) {
                $smatch_wins[$irow_cnt]["num_match_ar"][2] = $db_res["snum3"];                
                $num_match_cnt++;
              }
              if ($db_res["snum4"] == $scomb_num[3]) {
                $smatch_wins[$irow_cnt]["num_match_ar"][3] = $db_res["snum4"];                
                $num_match_cnt++;
              }
              if ($db_res["snum5"] == $scomb_num[4]) {
                $smatch_wins[$irow_cnt]["num_match_ar"][4] = $db_res["snum5"];                
                $num_match_cnt++;
              } 
              if ($db_res["snum6"] == $scomb_num[5]) {
                $smatch_wins[$irow_cnt]["num_match_ar"][5] = $db_res["snum6"];                
                $num_match_cnt++;
              }
              if ($db_res["snum7"] == $scomb_num[6]) {
                $smatch_wins[$irow_cnt]["num_match_ar"][6] = $db_res["snum7"];                
                $num_match_cnt++;
              }
              
              
            }
            
            $smatch_wins[$irow_cnt]["encore_win"]     = $encore_win;
            $smatch_wins[$irow_cnt]["match_cnt"]      = $imatch_cnt;
            $smatch_wins[$irow_cnt]["num_match_cnt"]  = $num_match_cnt;
            
            if ($encore_win == "7_rl") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_7_rl_prze_amt"];
            } elseif ($encore_win == "6_rl") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_6_rl_prze_amt"];
            } elseif ($encore_win == "5_rl") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_5_rl_prze_amt"];
            } elseif ($encore_win == "4_rl") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_4_rl_prze_amt"];
            } elseif ($encore_win == "3_rl") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_3_rl_prze_amt"];
            } elseif ($encore_win == "2_rl") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_2_rl_prze_amt"];
            } elseif ($encore_win == "1_rl") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_1_rl_prze_amt"];
            } elseif ($encore_win == "6_lr") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_6_lr_prze_amt"];
            } elseif ($encore_win == "5_lr") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_5_lr_prze_amt"];
            } elseif ($encore_win == "4_lr") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_4_lr_prze_amt"];
            } elseif ($encore_win == "3_lr") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_3_lr_prze_amt"];
            } elseif ($encore_win == "2_lr") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_2_lr_prze_amt"];
            } elseif ($encore_win == "f5_l1") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_f5_l1_prze_amt"];              
            } elseif ($encore_win == "f4_l2") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_f4_l2_prze_amt"];              
              
            } elseif ($encore_win == "f3_l3") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_f3_l3_prze_amt"];              
              
            } elseif ($encore_win == "f3_l2") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_f3_l2_prze_amt"];              
              
            } elseif ($encore_win == "f3_l1") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_f3_l1_prze_amt"];              
              
              
            } elseif ($encore_win == "f2_l4") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_f2_l4_prze_amt"];                  
            } elseif ($encore_win == "f2_l3") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_f2_l3_prze_amt"];                 
            } elseif ($encore_win == "f2_l2") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_f2_l2_prze_amt"];                  
            } elseif ($encore_win == "f2_l1") {
              $smatch_wins[$irow_cnt]["win_prze_amount"] = $db_res["m_f2_l1_prze_amt"];    
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
    
    function OLGEncoreGetMonth() {
      
    }
    function OLGEncoreGetYear() {
      
    }
    function OLGEncoreGetAll() {
      
    }
   
   
   /*
    * tbl_on_winning_locations
    * tbl_on_winners_1000_more
    * tbl_on_major_winners
    * 
    * 
    * 
    */
   
   /*
    * str_storename
    * str_storeaddr
    * str_lottogame
    * str_drawdate
    * dbl_winningamt
    * str_streetaddr
    * str_postalcode
    * str_cityname
    * 
    * 
    * return : winninglocid
    */
   
   
   function OLGWinningLocationsAdd($str_storename, $str_storeaddr, $str_lottogame, $str_lotto_gameid, $str_drawdate, $dbl_winningamt, $str_streetaddr, $str_postalcode, $str_cityname, $str_cityid) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_on_winning_locations` ");
      $ssql .= sprintf("(`str_store_name`,`str_store_addr`,`str_lotto_game`,`lotto_game_id`,`str_draw_date`,`dbl_winning_amount`,`str_street_addr`,`str_postal_code`,`str_city_name`,`str_city_id`) ");
      $ssql .= sprintf(" VALUES ('%s','%s','%s',%u,'%s',%u,'%s','%s','%s',%u)",$str_storename, $str_storeaddr, $str_lottogame, $str_lotto_gameid, $str_drawdate, $dbl_winningamt, $str_streetaddr, $str_postalcode, $str_cityname, $str_cityid);
      
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;      
     
   }
   
   /*
    * str_firstname
    * str_lastname
    * str_cityname
    * str_provcode
    * str_lottogame
    * str_drawdate
    * str_multipledraw
    * str_prize
    * str_insider
    * str_group
    * parent_group_id
    * str_address 
    * 
    *   winning_id  int(11)     No  None  AUTO_INCREMENT              
  str_first_name  varchar(255)  utf8_general_ci   Yes NULL                 
  str_last_name varchar(255)  utf8_general_ci   Yes NULL                 
  win_city_id int(11)     Yes NULL                
  win_prov_id int(11)     Yes NULL                
  lotto_game_id int(11)     Yes NULL                
  str_draw_date datetime      Yes NULL                
  is_multiple_draw  varchar(3)  utf8_general_ci   Yes NULL                 
  str_prize double      Yes NULL                
  is_insider  int(11)     Yes NULL                
  is_group  int(11)     Yes NULL                
  win_group_id  int(11)     Yes NULL                
  str_address varchar(255)  utf8_general_ci   Yes NULL                 
  win_list_date datetime      Yes NULL                
  win_list_pos  int(11)     Yes NULL                
    * 
    * 
    */
   
   
   function OLGWinners1000MoreAdd($str_firstname, $str_lastname, $str_city_id, $str_prov_id, $lotto_game_id, 
      $str_drawdate, $is_multiple_draw, $str_prize, $is_insider, $is_group, $parent_group_id, $str_address, $win_list_date, $win_list_pos) {
       
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("INSERT INTO `tbl_on_winners_1000_more` (`str_first_name`,`str_last_name`,`win_city_id`,
                    `win_prov_id`,`lotto_game_id`, `str_draw_date`,`is_multiple_draw`,`str_prize`,`is_insider`,
                    `is_group`,`win_group_id`,`str_address`,`win_list_date`,`win_list_pos`) ");
      $ssql .= sprintf(" VALUES ('%s','%s',%u,%u,%u,'%s',%u,%u,%u,%u,%u,'%s','%s',%u)",
                    $str_firstname, $str_lastname, $str_city_id, $str_prov_id, $lotto_game_id, 
                    $str_drawdate, $is_multiple_draw, $str_prize, $is_insider, $is_group, 
                    $parent_group_id, $str_address, $win_list_date, $win_list_pos); 
      $rows_affected = $this->exec($ssql);
      return $this->db_obj->last_id;
   }
   
   function OLGWinners1000MoreRemove($winning_id) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf("DELETE FROM `tbl_on_winners_1000_more` WHERE winning_id = %u", $winning_id);
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
   }
   
   function OLGWinners1000MoreModify($winning_id, $str_firstname, $str_lastname, $str_city_id, $str_prov_id, $lotto_game_id, 
      $str_drawdate, $is_multiple_draw, $str_prize, $is_insider, $is_group, $parent_group_id, $str_address, $win_list_date, $win_list_pos) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("UPDATE `tbl_on_winners_1000_more` SET ");
      $ssql .= sprintf(" `str_first_name` = '%s',`str_last_name` = '%s',`win_city_id` = %u,
                    `win_prov_id` = %u,`lotto_game_id` = %u, `str_draw_date` = '%s',`is_multiple_draw` = %u,
                    `str_prize` = %u,`is_insider` = %u,
                    `is_group` = %u,`win_group_id` = %u,`str_address` = '%s',`win_list_date` = '%s',
                    `win_list_pos` = %u",$str_firstname, $str_lastname, $str_city_id, $str_prov_id, 
                    $lotto_game_id, 
                    $str_drawdate, $is_multiple_draw, $str_prize, $is_insider, $is_group, $parent_group_id, 
                    $str_address, $win_list_date, $win_list_pos);
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;
   }
      
   function OLGWinners1000MoreGet($win_list_date) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     $ssql = sprintf("SELECT * FROM `tbl_on_winners_1000_more` WHERE win_list_date = '%s'",$win_list_date);
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res[0];
     } else {
       return null;
     }
   }
   
   function OLGWinners1000MoreGetGroup($win_list_date, $group_id) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT * FROM `tbl_on_winners_1000_more` WHERE win_list_date = '%s' AND $group_id = %u", $win_list_date, $group_id);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
   }
   
   /*
    * winning_date
    * winning_title
    * winning_content
    * winning_game_id
    * draw_date
    * winning_number
    * winning_url
    * winning_draw_id
    * winning_type
    * 
    * 
    */
   function OLGMajorWinnersAdd($winning_date, $winning_title, $winning_content, $winning_game_id, $draw_date, $winning_number, $winning_url, $winning_draw_id, $winning_type) {
     
   }
   
   
   /*
    * 
    * 
    * 

INSERT INTO `dbaLotteries`.`tbl_on_poker_winnings`
(`onpokerwinningid`,
`onpokerid`,
`m_5_d_count`,
`m_5_d_amount`,
`m_4_d_count`,
`m_4_d_amount`,
`m_3_d_count`,
`m_3_d_amount`,
`m_2_d_count`,
`m_2_d_amount`,
`m_rf_i_count`,
`m_rf_i_amount`,
`m_sf_i_count`,
`m_sf_i_amount`,
`m_4k_i_count`,
`m_4k_i_amount`,
`m_fh_i_count`,
`m_fh_i_amount`,
`m_f_i_count`,
`m_f_i_amount`,
`m_s_i_count`,
`m_s_i_amount`,
`m_3k_i_count`,
`m_3k_i_amount`,
`m_2p_i_count`,
`m_2p_i_amount`,
`m_pj_i_count`,
`m_pj_i_amount`,
`game_total_sales`)
VALUES
(
{onpokerwinningid: INT},
{onpokerid: INT},
{m_5_d_count: INT},
{m_5_d_amount: DOUBLE},
{m_4_d_count: INT},
{m_4_d_amount: DOUBLE},
{m_3_d_count: INT},
{m_3_d_amount: DOUBLE},
{m_2_d_count: INT},
{m_2_d_amount: DOUBLE},
{m_rf_i_count: INT},
{m_rf_i_amount: DOUBLE},
{m_sf_i_count: INT},
{m_sf_i_amount: DOUBLE},
{m_4k_i_count: INT},
{m_4k_i_amount: DOUBLE},
{m_fh_i_count: INT},
{m_fh_i_amount: DOUBLE},
{m_f_i_count: INT},
{m_f_i_amount: DOUBLE},
{m_s_i_count: INT},
{m_s_i_amount: DOUBLE},
{m_3k_i_count: INT},
{m_3k_i_amount: DOUBLE},
{m_2p_i_count: INT},
{m_2p_i_amount: DOUBLE},
{m_pj_i_count: INT},
{m_pj_i_amount: DOUBLE},
{game_total_sales: DOUBLE}
);
    * 
    * 
    * 
    * 
    */
   
    
   function OLGPokerWinningsAdd($onpokerid,$m_5_d_count,$m_5_d_amount,$m_4_d_count,$m_4_d_amount,$m_3_d_count,$m_3_d_amount,$m_2_d_count,$m_2_d_amount,$m_rf_i_count,$m_rf_i_amount,$m_sf_i_count,$m_sf_i_amount,$m_4k_i_count,$m_4k_i_amount,$m_fh_i_count,$m_fh_i_amount,$m_f_i_count,$m_f_i_amount,$m_s_i_count,$m_s_i_amount,$m_3k_i_count,$m_3k_i_amount,$m_2p_i_count,$m_2p_i_amount,$m_pj_i_count,$m_pj_i_amount,$game_total_sales) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf("INSERT INTO `tbl_on_poker_winnings` (`onpokerid`,`m_5_d_count`,`m_5_d_amount`,`m_4_d_count`,
     `m_4_d_amount`,`m_3_d_count`,`m_3_d_amount`,`m_2_d_count`,`m_2_d_amount`,`m_rf_i_count`,`m_rf_i_amount`,
     `m_sf_i_count`,`m_sf_i_amount`,`m_4k_i_count`,`m_4k_i_amount`,`m_fh_i_count`,`m_fh_i_amount`,`m_f_i_count`,
     `m_f_i_amount`,`m_s_i_count`,`m_s_i_amount`,`m_3k_i_count`,`m_3k_i_amount`,`m_2p_i_count`,`m_2p_i_amount`,
     `m_pj_i_count`,`m_pj_i_amount`,`game_total_sales`) ");
      $ssql .= sprintf(" VALUES (%u,%u,%u,%u,
                                 %u,%u,%u,%u,%u,%u,%u,
                                 %u,%u,%u,%u,%u,%u,%u,
                                 %u,%u,%u,%u,%u,%u,%u,
                                 %u,%u,%u)",$onpokerid,$m_5_d_count,$m_5_d_amount,$m_4_d_count,
                                 $m_4_d_amount,$m_3_d_count,$m_3_d_amount,$m_2_d_count,$m_2_d_amount,$m_rf_i_count,$m_rf_i_amount,
                                 $m_sf_i_count,$m_sf_i_amount,$m_4k_i_count,$m_4k_i_amount,$m_fh_i_count,$m_fh_i_amount,$m_f_i_count,
                                 $m_f_i_amount,$m_s_i_count,$m_s_i_amount,$m_3k_i_count,$m_3k_i_amount,$m_2p_i_count,$m_2p_i_amount,
                                 $m_pj_i_count,$m_pj_i_amount,$game_total_sales);

      //print "\n" . $ssql;
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
   }
   
   /*
    * onpokerid
    * onpokerwinningid
    * 
    */ 
   
   function OLGPokerWinningsRemove($onpokerid, $onpokerwinningid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf("DELETE FROM `tbl_on_poker_winnings` WHERE onpokerid = %u", $onpokerid);
     if ($onpokerwinningid != "") {
       $ssql .= sprintf(" AND onpokerwinningid = %u", $onpokerwinningid);
       
     }
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
     
   }
   
   /*
    * onpokerid
    * 
    */ 
   function OLGPokerWinningsModify($onpokerwinningid,$onpokerid,$m_5_d_count,$m_5_d_amount,$m_4_d_count,$m_4_d_amount,$m_3_d_count,$m_3_d_amount,$m_2_d_count,$m_2_d_amount,$m_rf_i_count,$m_rf_i_amount,$m_sf_i_count,$m_sf_i_amount,$m_4k_i_count,$m_4k_i_amount,$m_fh_i_count,$m_fh_i_amount,$m_f_i_count,$m_f_i_amount,$m_s_i_count,$m_s_i_amount,$m_3k_i_count,$m_3k_i_amount,$m_2p_i_count,$m_2p_i_amount,$m_pj_i_count,$m_pj_i_amount,$game_total_sales) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("UPDATE `tbl_on_poker_winnings` SET ");
      $ssql .= sprintf("`onpokerid` = %u,`m_5_d_count` = %u,`m_5_d_amount` = %u,`m_4_d_count` = %u,
      `m_4_d_amount` = %u,`m_3_d_count` = %u,`m_3_d_amount` = %u,`m_2_d_count` = %u,`m_2_d_amount` = %u,
      `m_rf_i_count` = %u,`m_rf_i_amount` = %u,`m_sf_i_count` = %u,`m_sf_i_amount` = %u,`m_4k_i_count` = %u,
      `m_4k_i_amount` = %u,`m_fh_i_count` = %u,`m_fh_i_amount` = %u,`m_f_i_count` = %u,`m_f_i_amount` = %u,
      `m_s_i_count` = %u,`m_s_i_amount` = %u,`m_3k_i_count` = %u,`m_3k_i_amount` = %u,`m_2p_i_count` = %u,
      `m_2p_i_amount` = %u,`m_pj_i_count` = %u,`m_pj_i_amount` = %u,`game_total_sales` = %u
       WHERE `onpokerwinningid` = %u",  $onpokerid, $m_5_d_count,$m_5_d_amount,$m_4_d_count,$m_4_d_amount,$m_3_d_count,$m_3_d_amount,$m_2_d_count,$m_2_d_amount,$m_rf_i_count,$m_rf_i_amount,$m_sf_i_count,$m_sf_i_amount,$m_4k_i_count,$m_4k_i_amount,$m_fh_i_count,$m_fh_i_amount,$m_f_i_count,$m_f_i_amount,$m_s_i_count,$m_s_i_amount,$m_3k_i_count,$m_3k_i_amount,$m_2p_i_count,$m_2p_i_amount,$m_pj_i_count,$m_pj_i_amount,$game_total_sales);

      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;           
   }
   
   /*
    * onpokerid
    * onpokerwinningid
    * 
    */ 
   function OLGPokerWinningsGet($onpokerid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_poker_winnings` WHERE `onpokerid` = %u", $onpokerid);
      $db_res = $this->db_obj->fetch($ssql);
      
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
   }
   
   function OLGPokerWinningsGetId($onpokerid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_on_poker_winnings` WHERE `onpokerid` = %u", $onpokerid);
      $db_res = $this->db_obj->fetch($ssql);
      
      if (is_array($db_res)) {
        return $db_res[0]["onpokerwinningid"];
      } else {
        return null;
      }
   }
   
   
   
    function OLGPokerWinningsGetDraw($st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }  
     
     $ssql = sprintf("
         SELECT `onpokerwinningid`, tbl_poker.*, 
          `m_5_d_count`, `m_5_d_amount`, 
                          (SELECT prze_amount as m_5_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_5_d_amount) AS m_5_d_prze_amt,
          `m_4_d_count`, `m_4_d_amount`, 
          (SELECT prze_amount as m_4_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_4_d_amount) AS m_4_d_prze_amt,
          `m_3_d_count`, `m_3_d_amount`, 
          (SELECT prze_amount as m_3_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_3_d_amount) AS m_3_d_prze_amt,
          `m_2_d_count`, `m_2_d_amount`, 
          (SELECT prze_amount as m_2_d_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_2_d_amount) AS m_2_d_prze_amt,
          `m_rf_i_count`, `m_rf_i_amount`, 
          (SELECT prze_amount as m_rf_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_rf_i_amount) AS m_rf_i_prze_amt,
          `m_sf_i_count`, `m_sf_i_amount`, 
          (SELECT prze_amount as m_sf_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_sf_i_amount) AS m_sf_i_prze_amt,
          `m_4k_i_count`, `m_4k_i_amount`, 
          (SELECT prze_amount as m_4k_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_4k_i_amount) AS m_4k_i_prze_amt,
          `m_fh_i_count`, `m_fh_i_amount`,
          (SELECT prze_amount as m_fh_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_fh_i_amount) AS m_fh_i_prze_amt,
           `m_f_i_count`, `m_f_i_amount`, 
          (SELECT prze_amount as m_f_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_f_i_amount) AS m_f_i_prze_amt,
          `m_s_i_count`, `m_s_i_amount`,
          (SELECT prze_amount as m_s_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_s_i_amount) AS m_s_i_prze_amt,
           `m_3k_i_count`, `m_3k_i_amount`, 
          (SELECT prze_amount as m_3k_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_3k_i_amount) AS m_3k_i_prze_amt,
          `m_2p_i_count`, `m_2p_i_amount`,
          (SELECT prze_amount as m_2p_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_2p_i_amount) AS m_2p_i_prze_amt,
           `m_pj_i_count`, `m_pj_i_amount`, 
          (SELECT prze_amount as m_pj_i_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_poker_win.m_pj_i_amount) AS m_pj_i_prze_amt
          FROM `tbl_on_poker_winnings` AS tbl_poker_win, `tbl_on_poker` AS tbl_poker 
          
          WHERE tbl_poker_win.onpokerid = tbl_poker.onpokerid 
          
          AND tbl_poker.drawdate >= '%s' AND tbl_poker.drawdate <= '%s'",
                $st_drawdate, $ed_drawdate);
    $ssql .= sprintf(" order by tbl_poker.drawdate");
    $db_res = $this->db_obj->fetch($ssql);
    //print "SSQL: " . $ssql;
    if (is_array($db_res)) {
      return $db_res;
    } else {
      return null;
    }
   }
   
   
   /*
    * 
    * INSERT INTO `tbl_on_49_winnings`
(`on49winningid`,
`on49id`,
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
`game_total_sales`)
VALUES
(
{on49winningid: INT},
{on49id: INT},
{m_6_count: INT},
{m_6_amount: DOUBLE},
{m_6_region: VARCHAR},
{m_5_b_count: INT},
{m_5_b_amount: DOUBLE},
{m_5_b_region: VARCHAR},
{m_5_count: INT},
{m_5_amount: DOUBLE},
{m_4_count: INT},
{m_4_amount: DOUBLE},
{m_3_count: INT},
{m_3_amount: DOUBLE},
{game_total_sales: DOUBLE}
);
    * 
    * ret : $on49winningid
    * 
    */ 
   
   function OLG49WinningsAdd($on49id,$m_6_count,$m_6_amount,$m_5_b_count,$m_5_b_amount,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_count,$m_3_amount,$game_total_sales) {
     
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
     
    $ssql = sprintf("INSERT INTO `tbl_on_49_winnings` (`on49id`,`m_6_count`,`m_6_amount`,`m_5_b_count`,`m_5_b_amount`,`m_5_count`,`m_5_amount`,`m_4_count`,`m_4_amount`,`m_3_count`,`m_3_amount`,`game_total_sales`) ");
    $ssql .= sprintf(" VALUES (%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u)", $on49id,$m_6_count,$m_6_amount,$m_5_b_count,$m_5_b_amount,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_count,$m_3_amount,$game_total_sales);
    //print "\n" . $ssql;
    $rows_affected = $this->db_obj->exec($ssql);
    return $this->db_obj->last_id;
   }
   
   /*
    * $on49id
    * $on49winningid
    */ 
   
   function OLG49WinningsRemove($on49id, $on49winningid = "") {
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_on_49_winnings` WHERE `on49id` = $u", $on49id);
      $this->db_obj->exec($ssql);
      return $this->db_obj->rows_affected;     
   }
   
   /*
    * $on49id
    * $on49winningid
    * 
    * 
    */ 
   
   function OLG49WinningsModify($on49winningid, $on49id,$m_6_count,$m_6_amount,$m_5_b_count,$m_5_b_amount,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_count,$m_3_amount,$game_total_sales) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("UPDATE `tbl_on_49_winnings` SET `on49id` = %u,`m_6_count` = %u,`m_6_amount` = %u,`m_5_b_count` = %u,`m_5_b_amount` = %u,`m_5_count` = %u,`m_5_amount` = %u,`m_4_count` = %u,`m_4_amount` = %u,`m_3_count` = %u,`m_3_amount` = %u,`game_total_sales` = %u WHERE on49winningid = $u)",  $on49id,$m_6_count,$m_6_amount,$m_5_b_count,$m_5_b_amount,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_count,$m_3_amount,$game_total_sales, $on49winningid) ;
     $this->db_obj->exec($ssql);
     
     return $this->db_obj->rows_affected;
   }
   
   /*
    * $on49id
    * $on49winningid
    * 
    */ 
   
   function OLG49WinningsGetSingleDraw($on49id) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("SELECT * FROM `tbl_on_49_winnings` WHERE `on49id` = %u", $on49id);
     $db_res = $this->db_obj->fetch($ssql);
     
     if (is_array($db_res)) {
       return $db_res[0];
     } else {
       return null;
     }
     
   }
   
   
   function OLG49WinningsGetDraw($st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num) {
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
    $db_res = $this->db_obj->fetch($ssql);
    //print "SSQL: " . $ssql;
    if (is_array($db_res)) {
      return $db_res;
    } else {
      return null;
    }
   }
   
   /*
    * $on49id
    * 
    */ 
   function OLG49WinningsGetId($on49id) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("SELECT * FROM `tbl_on_49_winnings` WHERE `on49id` = %u", $on49id);
     $db_res = $this->db_obj->fetch($ssql);
     
     if (is_array($db_res)) {
       //print_r($db_res);
       return $db_res["0"]["on49winningid"];
     } else {
       return null;
     }
   }
   
   /*
    * INSERT INTO `dbaLotteries`.`tbl_on_encore_winnings`
(`onencorewinningid`,
`onencoreid`,
`m_7_rl_count`,
`m_7_rl_amount`,
`m_6_rl_count`,
`m_6_rl_amount`,
`m_5_rl_count`,
`m_5_rl_amount`,
`m_4_rl_count`,
`m_4_rl_amount`,
`m_3_rl_count`,
`m_3_rl_amount`,
`m_2_rl_count`,
`m_2_rl_amount`,
`m_1_rl_count`,
`m_1_rl_amount`,
`m_6_lr_count`,
`m_6_lr_amount`,
`m_5_lr_count`,
`m_5_lr_amount`,
`m_4_lr_count`,
`m_4_lr_amount`,
`m_3_lr_count`,
`m_3_lr_amount`,
`m_2_lr_count`,
`m_2_lr_amount`,
`m_f5_l1_count`,
`m_f5_l1_amount`,
`m_f4_l2_count`,
`m_f4_l2_amount`,
`m_f4_l1_count`,
`m_f4_l1_amount`,
`m_f3_l3_count`,
`m_f3_l3_amount`,
`m_f3_l2_count`,
`m_f3_l2_amount`,
`m_f3_l1_count`,
`m_f3_l1_amount`,
`m_f2_l4_count`,
`m_f2_l4_amount`,
`m_f2_l3_count`,
`m_f2_l3_amount`,
`m_f2_l2_count`,
`m_f2_l2_amount`,
`m_f2_l1_count`,
`m_f2_l1_amount`,
`game_total_sales`)
VALUES
(
{onencorewinningid: INT},
{onencoreid: INT},
{m_7_rl_count: INT},
{m_7_rl_amount: DOUBLE},
{m_6_rl_count: INT},
{m_6_rl_amount: DOUBLE},
{m_5_rl_count: INT},
{m_5_rl_amount: DOUBLE},
{m_4_rl_count: INT},
{m_4_rl_amount: DOUBLE},
{m_3_rl_count: INT},
{m_3_rl_amount: DOUBLE},
{m_2_rl_count: INT},
{m_2_rl_amount: DOUBLE},
{m_1_rl_count: INT},
{m_1_rl_amount: DOUBLE},
{m_6_lr_count: INT},
{m_6_lr_amount: DOUBLE},
{m_5_lr_count: INT},
{m_5_lr_amount: DOUBLE},
{m_4_lr_count: INT},
{m_4_lr_amount: DOUBLE},
{m_3_lr_count: INT},
{m_3_lr_amount: DOUBLE},
{m_2_lr_count: INT},
{m_2_lr_amount: DOUBLE},
{m_f5_l1_count: INT},
{m_f5_l1_amount: DOUBLE},
{m_f4_l2_count: INT},
{m_f4_l2_amount: DOUBLE},
{m_f4_l1_count: INT},
{m_f4_l1_amount: DOUBLE},
{m_f3_l3_count: INT},
{m_f3_l3_amount: DOUBLE},
{m_f3_l2_count: INT},
{m_f3_l2_amount: DOUBLE},
{m_f3_l1_count: INT},
{m_f3_l1_amount: DOUBLE},
{m_f2_l4_count: INT},
{m_f2_l4_amount: DOUBLE},
{m_f2_l3_count: INT},
{m_f2_l3_amount: DOUBLE},
{m_f2_l2_count: INT},
{m_f2_l2_amount: DOUBLE},
{m_f2_l1_count: INT},
{m_f2_l1_amount: DOUBLE},
{game_total_sales: DOUBLE}
);
    * 
    * ret: onencorewinningid
    */ 
   
   
   function OLGOnEncoreWinningsAdd($onencoreid,$m_7_rl_count,$m_7_rl_amount,$m_6_rl_count,$m_6_rl_amount,$m_5_rl_count,$m_5_rl_amount,$m_4_rl_count,$m_4_rl_amount,$m_3_rl_count,$m_3_rl_amount,$m_2_rl_count,$m_2_rl_amount,$m_1_rl_count,$m_1_rl_amount,$m_6_lr_count,$m_6_lr_amount,$m_5_lr_count,$m_5_lr_amount,$m_4_lr_count,$m_4_lr_amount,$m_3_lr_count,$m_3_lr_amount,$m_2_lr_count,$m_2_lr_amount,$m_f5_l1_count,$m_f5_l1_amount,$m_f4_l2_count,$m_f4_l2_amount,$m_f4_l1_count,$m_f4_l1_amount,$m_f3_l3_count,$m_f3_l3_amount,$m_f3_l2_count,$m_f3_l2_amount,$m_f3_l1_count,$m_f3_l1_amount,$m_f2_l4_count,$m_f2_l4_amount,$m_f2_l3_count,$m_f2_l3_amount,$m_f2_l2_count,$m_f2_l2_amount,$m_f2_l1_count,$m_f2_l1_amount,$game_total_sales) {
    
    if (!$this->db_obj) {
        $this->db_obj = new db();
     }
    
     $ssql = sprintf("INSERT INTO `tbl_on_encore_winnings` (`onencoreid`,`m_7_rl_count`,`m_7_rl_amount`,`m_6_rl_count`,`m_6_rl_amount`,`m_5_rl_count`,`m_5_rl_amount`,`m_4_rl_count`,`m_4_rl_amount`,`m_3_rl_count`,`m_3_rl_amount`,`m_2_rl_count`,`m_2_rl_amount`,`m_1_rl_count`,`m_1_rl_amount`,`m_6_lr_count`,`m_6_lr_amount`,`m_5_lr_count`,`m_5_lr_amount`,`m_4_lr_count`,`m_4_lr_amount`,`m_3_lr_count`,`m_3_lr_amount`,`m_2_lr_count`,`m_2_lr_amount`,`m_f5_l1_count`,`m_f5_l1_amount`,`m_f4_l2_count`,`m_f4_l2_amount`,`m_f4_l1_count`,`m_f4_l1_amount`,`m_f3_l3_count`,`m_f3_l3_amount`,`m_f3_l2_count`,`m_f3_l2_amount`,`m_f3_l1_count`,`m_f3_l1_amount`,`m_f2_l4_count`,`m_f2_l4_amount`,`m_f2_l3_count`,`m_f2_l3_amount`,`m_f2_l2_count`,`m_f2_l2_amount`,`m_f2_l1_count`,`m_f2_l1_amount`,`game_total_sales`)
            VALUES
            (%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u)",
            $onencoreid,$m_7_rl_count,$m_7_rl_amount,$m_6_rl_count,$m_6_rl_amount,$m_5_rl_count,$m_5_rl_amount,$m_4_rl_count,$m_4_rl_amount,$m_3_rl_count,$m_3_rl_amount,$m_2_rl_count,$m_2_rl_amount,$m_1_rl_count,$m_1_rl_amount,$m_6_lr_count,$m_6_lr_amount,$m_5_lr_count,$m_5_lr_amount,$m_4_lr_count,$m_4_lr_amount,$m_3_lr_count,$m_3_lr_amount,$m_2_lr_count,$m_2_lr_amount,$m_f5_l1_count,$m_f5_l1_amount,$m_f4_l2_count,$m_f4_l2_amount,$m_f4_l1_count,$m_f4_l1_amount,$m_f3_l3_count,$m_f3_l3_amount,$m_f3_l2_count,$m_f3_l2_amount,$m_f3_l1_count,$m_f3_l1_amount,$m_f2_l4_count,$m_f2_l4_amount,$m_f2_l3_count,$m_f2_l3_amount,$m_f2_l2_count,$m_f2_l2_amount,$m_f2_l1_count,$m_f2_l1_amount,$game_total_sales);
      //printf("\nENC SQL : %s", $ssql);
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
  
   }
   
   /*
    * onencoreid
    */ 
   function OLGOnEncoreWinningsRemove($onencoreid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
    
    $ssql = sprintf("DELETE FROM `tbl_on_encore_winnings` WHERE onencoreid = %u", $onencoreid);
    
    $this->db_obj->exec($ssql);
    return $this->db_obj->rows_affected;
   }
   
   function OLGOnEncoreWinningsModify($onencorewinningid,$onencoreid,$m_7_rl_count,$m_7_rl_amount,$m_6_rl_count,$m_6_rl_amount,$m_5_rl_count,$m_5_rl_amount,$m_4_rl_count,$m_4_rl_amount,$m_3_rl_count,$m_3_rl_amount,$m_2_rl_count,$m_2_rl_amount,$m_1_rl_count,$m_1_rl_amount,$m_6_lr_count,$m_6_lr_amount,$m_5_lr_count,$m_5_lr_amount,$m_4_lr_count,$m_4_lr_amount,$m_3_lr_count,$m_3_lr_amount,$m_2_lr_count,$m_2_lr_amount,$m_f5_l1_count,$m_f5_l1_amount,$m_f4_l2_count,$m_f4_l2_amount,$m_f4_l1_count,$m_f4_l1_amount,$m_f3_l3_count,$m_f3_l3_amount,$m_f3_l2_count,$m_f3_l2_amount,$m_f3_l1_count,$m_f3_l1_amount,$m_f2_l4_count,$m_f2_l4_amount,$m_f2_l3_count,$m_f2_l3_amount,$m_f2_l2_count,$m_f2_l2_amount,$m_f2_l1_count,$m_f2_l1_amount,$game_total_sales) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("UPDATE `tbl_on_encore_winnings` SET ");
     $ssql .= sprintf("`onencoreid` = %u,`m_7_rl_count` = %u,`m_7_rl_amount` = %u,`m_6_rl_count` = %u,`m_6_rl_amount` = %u,`m_5_rl_count` = %u,`m_5_rl_amount` = %u,`m_4_rl_count` = %u,`m_4_rl_amount` = %u,`m_3_rl_count` = %u,`m_3_rl_amount` = %u,`m_2_rl_count` = %u,`m_2_rl_amount` = %u,`m_1_rl_count` = %u,`m_1_rl_amount` = %u,`m_6_lr_count` = %u,`m_6_lr_amount` = %u,`m_5_lr_count` = %u,`m_5_lr_amount` = %u,`m_4_lr_count` = %u,`m_4_lr_amount` = %u,`m_3_lr_count` = %u,`m_3_lr_amount` = %u,`m_2_lr_count` = %u,`m_2_lr_amount` = %u,`m_f5_l1_count` = %u,`m_f5_l1_amount` = %u,`m_f4_l2_count` = %u,`m_f4_l2_amount` = %u,`m_f4_l1_count` = %u,`m_f4_l1_amount` = %u,`m_f3_l3_count` = %u,`m_f3_l3_amount` = %u,`m_f3_l2_count` = %u,`m_f3_l2_amount` = %u,`m_f3_l1_count` = %u,`m_f3_l1_amount` = %u,`m_f2_l4_count` = %u,`m_f2_l4_amount` = %u,`m_f2_l3_count` = %u,`m_f2_l3_amount` = %u,`m_f2_l2_count` = %u,`m_f2_l2_amount` = %u,`m_f2_l1_count` = %u,`m_f2_l1_amount` = %u,`game_total_sales` = %u WHERE `onencorewinningid` = %u",
                  $onencoreid,$m_7_rl_count,$m_7_rl_amount,$m_6_rl_count,$m_6_rl_amount,$m_5_rl_count,$m_5_rl_amount,$m_4_rl_count,$m_4_rl_amount,$m_3_rl_count,$m_3_rl_amount,$m_2_rl_count,$m_2_rl_amount,$m_1_rl_count,$m_1_rl_amount,$m_6_lr_count,$m_6_lr_amount,$m_5_lr_count,$m_5_lr_amount,$m_4_lr_count,$m_4_lr_amount,$m_3_lr_count,$m_3_lr_amount,$m_2_lr_count,$m_2_lr_amount,$m_f5_l1_count,$m_f5_l1_amount,$m_f4_l2_count,$m_f4_l2_amount,$m_f4_l1_count,$m_f4_l1_amount,$m_f3_l3_count,$m_f3_l3_amount,$m_f3_l2_count,$m_f3_l2_amount,$m_f3_l1_count,$m_f3_l1_amount,$m_f2_l4_count,$m_f2_l4_amount,$m_f2_l3_count,$m_f2_l3_amount,$m_f2_l2_count,$m_f2_l2_amount,$m_f2_l1_count,$m_f2_l1_amount,$game_total_sales, $onencorewinningid);

     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;     
     
   }
   
   function OLGOnEncoreWinningsGet($onencoreid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("SELECT * FROM `tbl_on_encore_winnings` WHERE `onencoreid` = %u", $onencoreid);
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res[0];
     } else {
       return null;
     }
   }
   
   function OLGOnEncoreWinningsGetDraw($st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("SELECT tbl_enc.*, tbl_enc_win.`onencorewinningid` as onencorewinningid, tbl_enc_win.`onencoreid` as onencoreid, 
          `m_7_rl_count`, `m_7_rl_amount`, 
          (SELECT prze_amount as m_7_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_7_rl_amount) AS m_7_rl_prze_amt,
                
          `m_6_rl_count`, `m_6_rl_amount`, 
          
          (SELECT prze_amount as m_6_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_6_rl_amount) AS m_6_rl_prze_amt,
                
          `m_5_rl_count`, `m_5_rl_amount`, 
          (SELECT prze_amount as m_5_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_5_rl_amount) AS m_5_rl_prze_amt,

          `m_4_rl_count`, `m_4_rl_amount`, 
          (SELECT prze_amount as m_4_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_4_rl_amount) AS m_4_rl_prze_amt,
          
          `m_3_rl_count`, `m_3_rl_amount`, 
          (SELECT prze_amount as m_3_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_3_rl_amount) AS m_3_rl_prze_amt,
          
          `m_2_rl_count`, `m_2_rl_amount`, 
          (SELECT prze_amount as m_2_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_2_rl_amount) AS m_2_rl_prze_amt,
          
          `m_1_rl_count`, `m_1_rl_amount`, 
          (SELECT prze_amount as m_1_rl_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_1_rl_amount) AS m_1_rl_prze_amt,
          
          `m_6_lr_count`, `m_6_lr_amount`,
          (SELECT prze_amount as m_6_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_6_lr_amount) AS m_6_lr_prze_amt,
           
          `m_5_lr_count`, `m_5_lr_amount`, 
          (SELECT prze_amount as m_5_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_5_lr_amount) AS m_5_lr_prze_amt,
          
          `m_4_lr_count`, `m_4_lr_amount`, 
          (SELECT prze_amount as m_4_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_4_lr_amount) AS m_4_lr_prze_amt,
          
          `m_3_lr_count`, `m_3_lr_amount`, 
          (SELECT prze_amount as m_3_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_3_lr_amount) AS m_3_lr_prze_amt,
          
          `m_2_lr_count`, `m_2_lr_amount`, 
          (SELECT prze_amount as m_2_lr_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_2_lr_amount) AS m_2_lr_prze_amt,
          
          `m_f5_l1_count`, `m_f5_l1_amount`,
          (SELECT prze_amount as m_f5_l1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f5_l1_amount) AS m_f5_l1_prze_amt,
            
          
           `m_f4_l2_count`, `m_f4_l2_amount`, 
          (SELECT prze_amount as m_f4_l2_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f4_l2_amount) AS m_f4_l2_prze_amt,
           
           `m_f4_l1_count`, `m_f4_l1_amount`, 
          (SELECT prze_amount as m_f4_l1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f4_l1_amount) AS m_f4_l1_prze_amt,
                 
           `m_f3_l3_count`, `m_f3_l3_amount`,
           (SELECT prze_amount as m_f3_l3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f3_l3_amount) AS m_f3_l3_prze_amt,
          
            `m_f3_l2_count`, `m_f3_l2_amount`, 
            (SELECT prze_amount as m_f3_l2_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f3_l2_amount) AS m_f3_l2_prze_amt,
          
            `m_f3_l1_count`, `m_f3_l1_amount`, 
            (SELECT prze_amount as m_f3_l1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f3_l1_amount) AS m_f3_l1_prze_amt,
          
            `m_f2_l4_count`, `m_f2_l4_amount`,
            (SELECT prze_amount as m_f2_l4_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f2_l4_amount) AS m_f2_l4_prze_amt,
           
            `m_f2_l3_count`, `m_f2_l3_amount`,
            (SELECT prze_amount as m_f2_l3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f2_l3_amount) AS m_f2_l3_prze_amt,
          
             `m_f2_l2_count`, `m_f2_l2_amount`,
             (SELECT prze_amount as m_f2_l2_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f2_l2_amount) AS m_f2_l2_prze_amt,
           
             `m_f2_l1_count`, `m_f2_l1_amount`,         
             (SELECT prze_amount as m_f2_l1_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_enc_win.m_f2_l1_amount) AS m_f2_l1_prze_amt
           
          FROM `tbl_on_encore_winnings` as tbl_enc_win, `tbl_on_encore` as tbl_enc 
          WHERE tbl_enc_win.onencoreid = tbl_enc.onencoreid AND tbl_enc.drawdate >= '%s' AND tbl_enc.drawdate <= '%s'",
                $st_drawdate, $ed_drawdate);
          $ssql .= sprintf(" order by tbl_enc.drawdate");
          //print "\n<br />SSQL: " . $ssql;
          $db_res = $this->db_obj->fetch($ssql);
          if (is_array($db_res)) {
            return $db_res;
          } else {
            return null;
          }
     
   }
   
   function OLGOnEncoreWinningsGetId($onencoreid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("SELECT * FROM `tbl_on_encore_winnings` WHERE `onencoreid` = %u", $onencoreid);
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res["0"]["onencorewinningid"];
     } else {
       return null;
     }     
   }
   
   /*
    * 
    * INSERT INTO `dbaLotteries`.`tbl_on_pick4_winnings`
(`onpick4winningid`,
`onpick4id`,
`m_4_s_count`,
`m_4_s_amount`,
`m_4_b_count`,
`m_4_b_amount`,
`game_total_sales`)
VALUES
(
{onpick4winningid: INT},
{onpick4id: INT},
{m_4_s_count: INT},
{m_4_s_amount: DOUBLE},
{m_4_b_count: INT},
{m_4_b_amount: DOUBLE},
{game_total_sales: DOUBLE}
);
    * 
    * 
    * 
    * Field   Type  Collation   Attributes  Null  Default   Extra   Action
  onpick4winningid  int(11)       No  None  AUTO_INCREMENT  Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  onpick4id   int(11)       Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_s_count   int(11)       Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_s_amount  double      Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_b_count   int(11)       Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_b_amount  double      Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  game_total_sales  double      Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_4w_box_count  int(11)       Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_4w_box_amount   double      Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_6w_box_count  int(11)       Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_6w_box_amount   double      Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_12w_box_count   int(11)       Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_12w_box_amount  double      Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_24w_box_count   int(11)       Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
  m_4_24w_box_amount  double      Yes   NULL    Browse distinct values  Change  Drop  Primary   Unique  Index   Fulltext
With selected: Check All / Uncheck All With selected:
    * 
    */
   
   
   function OLGOnPick4WinningsAdd( $onpick4id, $m_4_s_count, $m_4_s_amount, 
            $m_4_b_count, $m_4_b_amount, $m_4_4w_box_count, $m_4_4w_box_amount, $m_4_6w_box_count, $m_4_6w_box_amount,
            $m_4_12w_box_count, $m_4_12w_box_amount, $m_4_24w_box_count, $m_4_24w_box_amount, $grand_total_sales ) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("INSERT INTO `tbl_on_pick4_winnings` (`onpick4id`,`m_4_s_count`,`m_4_s_amount`,`m_4_b_count`,`m_4_b_amount`,`m_4_4w_box_count`,`m_4_4w_box_amount`,`m_4_6w_box_count`,`m_4_6w_box_amount`,`m_4_12w_box_count`,`m_4_12w_box_amount`,`m_4_24w_box_count`,`m_4_24w_box_amount`,`game_total_sales`) VALUES(%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u)",
            $onpick4id, $m_4_s_count, $m_4_s_amount, 
            $m_4_b_count, $m_4_b_amount, $m_4_4w_box_count, $m_4_4w_box_amount, $m_4_6w_box_count, $m_4_6w_box_amount,
            $m_4_12w_box_count, $m_4_12w_box_amount, $m_4_24w_box_count, $m_4_24w_box_amount, $grand_total_sales); 
    //print "\nSSQL: " . $ssql;
     $rows_affected = $this->db_obj->exec($ssql);
     return $this->db_obj->last_id;
     
   }
   
   /*
    * $onpick4winningid, $onpick4id,
    */ 
   
   function OLGOnPick4WinningsRemove($onpick4winningid = "", $onpick4id = "") {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("DELETE FROM `tbl_on_pick4_winnings` ");
     if ($onpick4winningid != "") { 
       $ssql .= sprintf(" WHERE onpick4winningid = %u", $onpick4winningid);
     } elseif ($onpick4id != "") {
       $ssql .= sprintf(" WHERE onpick4id = %u", $onpick4id);
     }
     
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
     
   }
   
   /*
    * 
    * $onpick4winningid, $onpick4id, $m_4_s_count, $m_4_s_amount, 
            $m_4_b_count, $m_4_b_amount, $m_4_4w_box_count, $m_4_4w_box_amount, $m_4_6w_box_count, $m_4_6w_box_amount,
            $m_4_12w_box_count, $m_4_12w_box_amount, $m_4_24w_box_count, $m_4_24w_box_amount, $grand_total_sales 
    * 
    */ 
   
   function OLGOnPick4WinningsModify($onpick4winningid, $onpick4id, $m_4_s_count, $m_4_s_amount, 
            $m_4_b_count, $m_4_b_amount, $m_4_4w_box_count, $m_4_4w_box_amount, $m_4_6w_box_count, $m_4_6w_box_amount,
            $m_4_12w_box_count, $m_4_12w_box_amount, $m_4_24w_box_count, $m_4_24w_box_amount, $grand_total_sales ) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("UPDATE `tbl_on_pick4_winnings` SET ");
     $ssql .= sprintf(" `onpick4id` = %u,`m_4_s_count` = %u,`m_4_s_amount` = %u,`m_4_b_count` = %u,`m_4_b_amount` = %u,`m_4_4w_box_count` = %u,`m_4_4w_box_amount` = %u,`m_4_6w_box_count` = %u,`m_4_6w_box_amount` = %u, `m_4_12w_box_count` = %u,`m_4_12w_box_amount` = %u,`m_4_24w_box_count` = %u,`m_4_24w_box_amount` = %u,`game_total_sales` = %u",
               $onpick4id, $m_4_s_count, $m_4_s_amount, 
            $m_4_b_count, $m_4_b_amount, $m_4_4w_box_count, $m_4_4w_box_amount, $m_4_6w_box_count, $m_4_6w_box_amount,
            $m_4_12w_box_count, $m_4_12w_box_amount, $m_4_24w_box_count, $m_4_24w_box_amount, $grand_total_sales);
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
   }
   
   /*
    * $onpick4id
    */ 
   
   function OLGOnPick4WinningsGet($onpick4id, $onpick4winningid = "") {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("SELECT * FROM `tbl_on_pick4_winnings` WHERE ");
     $ssql .= sprintf(" onpick4id = %u", $onpick4id);
     if ($onpick4winningid != "") {
       $ssql .= sprintf(" AND onpick4winningid = %u", $onpick4winningid );
     }
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res[0];
     } else {
       return null;
     }
   }
   
   function OLGOnPick4WinningsGetDraw($st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("SELECT 
     tbl_pick4.drawdate,
     `onpick4winningid`, tbl_pick4.*,
 `m_4_s_count`, `m_4_s_amount`, 
      (SELECT prze_amount as m_4_s_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_s_amount) AS m_4_s_prze_amt,
 

`m_4_b_count`, `m_4_b_amount`,
(SELECT prze_amount as m_4_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_b_amount) AS m_4_b_prze_amt,

 `m_4_4w_box_count`, `m_4_4w_box_amount`, 
(SELECT prze_amount as m_4_4w_box_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_4w_box_amount) AS m_4_4w_box_prze_amt,


`m_4_6w_box_count`, `m_4_6w_box_amount`, 
(SELECT prze_amount as m_4_6w_box_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_6w_box_amount) AS m_4_6w_box_prze_amt,


`m_4_12w_box_count`, `m_4_12w_box_amount`, 
(SELECT prze_amount as m_4_12w_box_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_12w_box_amount) AS m_4_12w_box_prze_amt,

`m_4_24w_box_count`, `m_4_24w_box_amount`, 
(SELECT prze_amount as m_4_24w_box_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick4_win.m_4_24w_box_amount) AS m_4_24w_box_prze_amt
     
     
     FROM `tbl_on_pick4` as tbl_pick4, `tbl_on_pick4_winnings` as tbl_pick4_win 
     WHERE tbl_pick4.onpick4id = tbl_pick4_win.onpick4id AND 
     tbl_pick4.drawdate >= '%s' AND tbl_pick4.drawdate <= '%s' ",
     $st_drawdate, $ed_drawdate);
     //print "SSQL: " . $ssql;
     $ssql .= sprintf(" order by tbl_pick4.drawdate");
     $db_res = $this->db_obj->fetch($ssql);
     //print_r($db_res);
     if (is_array($db_res)) {
       return $db_res;
     } else {
       return null;
     }
     
   }
   
   function OLGOnPick4WinningsGetId($onpick4id) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("SELECT * FROM `tbl_on_pick4_winnings` WHERE ");
     $ssql .= sprintf(" onpick4id = %u", $onpick4id);

     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res["0"]["onpick4winningid"];
     } else {
       return null;
     }
   }
   
   /*
    * INSERT INTO `dbaLotteries`.`tbl_on_pick3_winnings`
(`onpick3winningid`,
`onpick3id`,
`m_3_s_count`,
`m_3_s_amount`,
`m_3_b_count`,
`m_3_b_amount`,
`game_total_sales`)
VALUES
(
{onpick3winningid: INT},
{onpick3id: INT},
{m_3_s_count: INT},
{m_3_s_amount: DOUBLE},
{m_3_b_count: INT},
{m_3_b_amount: DOUBLE},
{game_total_sales: DOUBLE}
);
    * 
    */
    
   function OLGOnPick3WinningsAdd($onpick3id, $m_3_s_count, $m_3_s_amount, $m_3_b_count, $m_3_b_amount, $game_total_sales) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("INSERT INTO `tbl_on_pick3_winnings` (`onpick3id`,`m_3_s_count`,`m_3_s_amount`,`m_3_b_count`,`m_3_b_amount`,`game_total_sales`) ");
      $ssql .= sprintf(" VALUES(%u,%u,%u,%u,%u,%u)", $onpick3id, $m_3_s_count, $m_3_s_amount, $m_3_b_count, $m_3_b_amount, $game_total_sales);
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
   }
   
   /*
    * onpick3id
    * onpick3winningid
    * 
    */ 
   
   function OLGOnPick3WinningsRemove($onpick3id, $onpick3winningid =  "") {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("DELETE FROM `tbl_on_pick3_winnings` WHERE onpick3id = %u", $onpick3id);
     if ($onpick3winningid != "") {
       $ssql .= sprintf(" AND onpick3winningid = %u", $onpick3winningid); 
       
     }
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
   }
   
   
   
   function OLGOnPick3WinningsModify($onpick3winningid, $onpick3id, $m_3_s_count, $m_3_s_amount, $m_3_b_count, $m_3_b_amount, $game_total_sales) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("UPDATE `tbl_on_pick3_winnings` SET `onpick3id` = %u,`m_3_s_count` = %u,`m_3_s_amount` = %u,`m_3_b_count` = %u,`m_3_b_amount` = %u,`game_total_sales` = %u",
     $onpick3id, $m_3_s_count, $m_3_s_amount, $m_3_b_count, $m_3_b_amount, $game_total_sales);
     $ssql .= sprintf(" WHERE onpick3winningid = %u", $onpick3winningid);
     
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected; 
   }
   
   /*
    * onpick3id
    * onpick3winningid
    * 
    */ 
   
   function OLGOnPick3WinningsGet($onpick3id, $onpick3winningid = "") {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("SELECT * FROM `tbl_on_pick3_winnings` WHERE onpick3id = %u", $onpick3id);
     if ($onpick3winningid != "") {
       $ssql .= sprintf(" AND onpick3winningid = %u", $onpick3winningid);
           
     }
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res[0];
     } else {
       return null;
     }
   }
   
     function OLGOnPick3WinningsGetDraw($st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("
     SELECT tbl_pick3.*,
`onpick3winningid`,  `m_3_s_count`, `m_3_s_amount`,
(SELECT prze_amount as m_3_s_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick3_win.m_3_s_amount) AS m_3_s_prze_amt,
       
 `m_3_b_count`, `m_3_b_amount`,
(SELECT prze_amount as m_3_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = tbl_pick3_win.m_3_b_amount) AS m_3_b_prze_amt 


     
     
     FROM `tbl_on_pick3` as tbl_pick3, `tbl_on_pick3_winnings` as tbl_pick3_win 
       WHERE tbl_pick3.onpick3id = tbl_pick3_win.onpick3id AND 
          tbl_pick3.drawdate >= '%s' AND tbl_pick3.drawdate <= '%s'",
          $st_drawdate, $ed_drawdate);
    // print "SSQL: " . $ssql;
     $ssql .= sprintf(" order by tbl_pick3.drawdate");
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res;
     } else {
       return null;
     }
     
   }
   
   
   function OLGOnPick3WinningsGetId($onpick3id) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("SELECT * FROM `tbl_on_pick3_winnings` WHERE onpick3id = %u", $onpick3id);

     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res["0"]["onpick3winningid"];
     } else {
       return null;
     }
   }
   
   /*
    * 
    * INSERT INTO `dbaLotteries`.`tbl_on_keno_winnings`
(`onkenowinningid`,
`onkenoid`,
`m_10_10_1_count`,
`m_10_10_1_amount`,
`m_10_9_1_count`,
`m_10_9_1_amount`,
`m_10_8_1_count`,
`m_10_8_1_amount`,
`m_10_7_1_count`,
`m_10_7_1_amount`,
`m_10_0_1_count`,
`m_10_0_1_amount`,
`m_9_9_1_count`,
`m_9_9_1_amount`,
`m_9_8_1_count`,
`m_9_8_1_amount`,
`m_9_7_1_count`,
`m_9_7_1_amount`,
`m_9_6_1_count`,
`m_9_6_1_amount`,
`m_8_8_1_count`,
`m_8_8_1_amount`,
`m_8_7_1_count`,
`m_8_7_1_amount`,
`m_8_6_1_count`,
`m_8_6_1_amount`,
`m_7_7_1_count`,
`m_7_7_1_amount`,
`m_7_6_1_count`,
`m_7_6_1_amount`,
`m_7_5_1_count`,
`m_7_5_1_amount`,
`m_6_6_1_count`,
`m_6_6_1_amount`,
`m_6_5_1_count`,
`m_6_5_1_amount`,
`m_5_5_1_count`,
`m_5_5_1_amount`,
`m_5_4_1_count`,
`m_5_4_1_amount`,
`m_4_4_1_count`,
`m_4_4_1_amount`,
`m_3_3_1_count`,
`m_3_3_1_amount`,
`m_2_2_1_count`,
`m_2_2_1_amount`,
`m_10_10_2_count`,

`m_10_9_2_count`,

`m_10_8_2_count`,

`m_10_7_2_count`,

`m_10_0_2_count`,

`m_9_9_2_count`,

`m_9_8_2_count`,

`m_9_7_2_count`,

`m_9_6_2_count`,

`m_8_8_2_count`,

`m_8_7_2_count`,

`m_8_6_2_count`,

`m_7_7_2_count`,

`m_7_6_2_count`,

`m_7_5_2_count`,

`m_6_6_2_count`,

`m_6_5_2_count`,

`m_5_5_2_count`,

`m_5_4_2_count`,

`m_4_4_2_count`,

`m_3_3_2_count`,

`m_2_2_2_count`,

`m_10_10_5_count`,

`m_10_9_5_count`,

`m_10_8_5_count`,

`m_10_7_5_count`,

`m_10_0_5_count`,

`m_9_9_5_count`,

`m_9_8_5_count`,

`m_9_7_5_count`,

`m_9_6_5_count`,

`m_8_8_5_count`,

`m_8_7_5_count`,

`m_8_6_5_count`,

`m_7_7_5_count`,

`m_7_6_5_count`,

`m_7_5_5_count`,

`m_6_6_5_count`,

`m_6_5_5_count`,

`m_5_5_5_count`,

`m_5_4_5_count`,

`m_4_4_5_count`,

`m_3_3_5_count`,

`m_2_2_5_count`,

`m_10_10_10_count`,

`m_10_9_10_count`,

`m_10_8_10_count`,

`m_10_7_10_count`,

`m_10_0_10_count`,

`m_9_9_10_count`,

`m_9_8_10_count`,

`m_9_7_10_count`,

`m_9_6_10_count`,

`m_8_8_10_count`,

`m_8_7_10_count`,

`m_8_6_10_count`,

`m_7_7_10_count`,

`m_7_6_10_count`,

`m_7_5_10_count`,

`m_6_6_10_count`,

`m_6_5_10_count`,

`m_5_5_10_count`,

`m_5_4_10_count`,

`m_4_4_10_count`,

`m_3_3_10_count`,

`m_2_2_10_count`,
`m_2_2_10_amount`)
VALUES
(
{onkenowinningid: INT},
{onkenoid: INT},
{m_10_10_1_count: INT},
{m_10_10_1_amount: INT},
{m_10_9_1_count: INT},
{m_10_9_1_amount: INT},
{m_10_8_1_count: INT},
{m_10_8_1_amount: INT},
{m_10_7_1_count: INT},
{m_10_7_1_amount: INT},
{m_10_0_1_count: INT},
{m_10_0_1_amount: INT},
{m_9_9_1_count: INT},
{m_9_9_1_amount: INT},
{m_9_8_1_count: INT},
{m_9_8_1_amount: INT},
{m_9_7_1_count: INT},
{m_9_7_1_amount: INT},
{m_9_6_1_count: INT},
{m_9_6_1_amount: INT},
{m_8_8_1_count: INT},
{m_8_8_1_amount: INT},
{m_8_7_1_count: INT},
{m_8_7_1_amount: INT},
{m_8_6_1_count: INT},
{m_8_6_1_amount: INT},
{m_7_7_1_count: INT},
{m_7_7_1_amount: INT},
{m_7_6_1_count: INT},
{m_7_6_1_amount: INT},
{m_7_5_1_count: INT},
{m_7_5_1_amount: INT},
{m_6_6_1_count: INT},
{m_6_6_1_amount: INT},
{m_6_5_1_count: INT},
{m_6_5_1_amount: INT},
{m_5_5_1_count: INT},
{m_5_5_1_amount: INT},
{m_5_4_1_count: INT},
{m_5_4_1_amount: INT},
{m_4_4_1_count: INT},
{m_4_4_1_amount: INT},
{m_3_3_1_count: INT},
{m_3_3_1_amount: INT},
{m_2_2_1_count: INT},
{m_2_2_1_amount: INT},
{m_10_10_2_count: INT},
{m_10_10_2_amount: INT},
{m_10_9_2_count: INT},
{m_10_9_2_amount: INT},
{m_10_8_2_count: INT},
{m_10_8_2_amount: INT},
{m_10_7_2_count: INT},
{m_10_7_2_amount: INT},
{m_10_0_2_count: INT},
{m_10_0_2_amount: INT},
{m_9_9_2_count: INT},
{m_9_9_2_amount: INT},
{m_9_8_2_count: INT},
{m_9_8_2_amount: INT},
{m_9_7_2_count: INT},
{m_9_7_2_amount: INT},
{m_9_6_2_count: INT},
{m_9_6_2_amount: INT},
{m_8_8_2_count: INT},
{m_8_8_2_amount: INT},
{m_8_7_2_count: INT},
{m_8_7_2_amount: INT},
{m_8_6_2_count: INT},
{m_8_6_2_amount: INT},
{m_7_7_2_count: INT},
{m_7_7_2_amount: INT},
{m_7_6_2_count: INT},
{m_7_6_2_amount: INT},
{m_7_5_2_count: INT},
{m_7_5_2_amount: INT},
{m_6_6_2_count: INT},
{m_6_6_2_amount: INT},
{m_6_5_2_count: INT},
{m_6_5_2_amount: INT},
{m_5_5_2_count: INT},
{m_5_5_2_amount: INT},
{m_5_4_2_count: INT},
{m_5_4_2_amount: INT},
{m_4_4_2_count: INT},
{m_4_4_2_amount: INT},
{m_3_3_2_count: INT},
{m_3_3_2_amount: INT},
{m_2_2_2_count: INT},
{m_2_2_2_amount: INT},
{m_10_10_5_count: INT},
{m_10_10_5_amount: INT},
{m_10_9_5_count: INT},
{m_10_9_5_amount: INT},
{m_10_8_5_count: INT},
{m_10_8_5_amount: INT},
{m_10_7_5_count: INT},
{m_10_7_5_amount: INT},
{m_10_0_5_count: INT},
{m_10_0_5_amount: INT},
{m_9_9_5_count: INT},
{m_9_9_5_amount: INT},
{m_9_8_5_count: INT},
{m_9_8_5_amount: INT},
{m_9_7_5_count: INT},
{m_9_7_5_amount: INT},
{m_9_6_5_count: INT},
{m_9_6_5_amount: INT},
{m_8_8_5_count: INT},
{m_8_8_5_amount: INT},
{m_8_7_5_count: INT},
{m_8_7_5_amount: INT},
{m_8_6_5_count: INT},
{m_8_6_5_amount: INT},
{m_7_7_5_count: INT},
{m_7_7_5_amount: INT},
{m_7_6_5_count: INT},
{m_7_6_5_amount: INT},
{m_7_5_5_count: INT},
{m_7_5_5_amount: INT},
{m_6_6_5_count: INT},
{m_6_6_5_amount: INT},
{m_6_5_5_count: INT},
{m_6_5_5_amount: INT},
{m_5_5_5_count: INT},
{m_5_5_5_amount: INT},
{m_5_4_5_count: INT},
{m_5_4_5_amount: INT},
{m_4_4_5_count: INT},
{m_4_4_5_amount: INT},
{m_3_3_5_count: INT},
{m_3_3_5_amount: INT},
{m_2_2_5_count: INT},
{m_2_2_5_amount: INT},
{m_10_10_10_count: INT},
{m_10_10_10_amount: INT},
{m_10_9_10_count: INT},
{m_10_9_10_amount: INT},
{m_10_8_10_count: INT},
{m_10_8_10_amount: INT},
{m_10_7_10_count: INT},
{m_10_7_10_amount: INT},
{m_10_0_10_count: INT},
{m_10_0_10_amount: INT},
{m_9_9_10_count: INT},
{m_9_9_10_amount: INT},
{m_9_8_10_count: INT},
{m_9_8_10_amount: INT},
{m_9_7_10_count: INT},
{m_9_7_10_amount: INT},
{m_9_6_10_count: INT},
{m_9_6_10_amount: INT},
{m_8_8_10_count: INT},
{m_8_8_10_amount: INT},
{m_8_7_10_count: INT},
{m_8_7_10_amount: INT},
{m_8_6_10_count: INT},
{m_8_6_10_amount: INT},
{m_7_7_10_count: INT},
{m_7_7_10_amount: INT},
{m_7_6_10_count: INT},
{m_7_6_10_amount: INT},
{m_7_5_10_count: INT},
{m_7_5_10_amount: INT},
{m_6_6_10_count: INT},
{m_6_6_10_amount: INT},
{m_6_5_10_count: INT},
{m_6_5_10_amount: INT},
{m_5_5_10_count: INT},
{m_5_5_10_amount: INT},
{m_5_4_10_count: INT},
{m_5_4_10_amount: INT},
{m_4_4_10_count: INT},
{m_4_4_10_amount: INT},
{m_3_3_10_count: INT},
{m_3_3_10_amount: INT},
{m_2_2_10_count: INT},
{m_2_2_10_amount: INT}
);
    * 
    * 
    */
   
   
   function OLGOnKenoWinningsAdd(
       $onkenoid,$m_10_10_1_count,$m_10_10_1_amount,$m_10_9_1_count,$m_10_9_1_amount,$m_10_8_1_count,$m_10_8_1_amount,$m_10_7_1_count,$m_10_7_1_amount,$m_10_0_1_count,$m_10_0_1_amount,
       $m_9_9_1_count,$m_9_9_1_amount,$m_9_8_1_count,$m_9_8_1_amount,$m_9_7_1_count,$m_9_7_1_amount,$m_9_6_1_count,$m_9_6_1_amount,
       $m_8_8_1_count,$m_8_8_1_amount,$m_8_7_1_count,$m_8_7_1_amount,$m_8_6_1_count,$m_8_6_1_amount,
       $m_7_7_1_count,$m_7_7_1_amount,$m_7_6_1_count,$m_7_6_1_amount,$m_7_5_1_count,$m_7_5_1_amount,
       $m_6_6_1_count,$m_6_6_1_amount,$m_6_5_1_count,$m_6_5_1_amount,
       $m_5_5_1_count,$m_5_5_1_amount,$m_5_4_1_count,$m_5_4_1_amount,
       $m_4_4_1_count,$m_4_4_1_amount,
       $m_3_3_1_count,$m_3_3_1_amount,
       $m_2_2_1_count,$m_2_2_1_amount,
       $m_10_10_2_count,$m_10_9_2_count,$m_10_8_2_count,$m_10_7_2_count,$m_10_0_2_count,
       $m_9_9_2_count,$m_9_8_2_count,$m_9_7_2_count,$m_9_6_2_count,
       $m_8_8_2_count,$m_8_7_2_count,$m_8_6_2_count,
       $m_7_7_2_count,$m_7_6_2_count,$m_7_5_2_count,
       $m_6_6_2_count,$m_6_5_2_count,
       $m_5_5_2_count,$m_5_4_2_count,
       $m_4_4_2_count,
       $m_3_3_2_count,
       $m_2_2_2_count,
       $m_10_10_5_count,$m_10_9_5_count,$m_10_8_5_count,$m_10_7_5_count,$m_10_0_5_count,
       $m_9_9_5_count,$m_9_8_5_count,$m_9_7_5_count,$m_9_6_5_count,
       $m_8_8_5_count,$m_8_7_5_count,$m_8_6_5_count,
       $m_7_7_5_count,$m_7_6_5_count,$m_7_5_5_count,
       $m_6_6_5_count,$m_6_5_5_count,
       $m_5_5_5_count,$m_5_4_5_count,
       $m_4_4_5_count,
       $m_3_3_5_count,
       $m_2_2_5_count,
       $m_10_10_10_count,$m_10_9_10_count,$m_10_8_10_count,$m_10_7_10_count,$m_10_0_10_count,
       $m_9_9_10_count,$m_9_8_10_count,$m_9_7_10_count,$m_9_6_10_count,
       $m_8_8_10_count,$m_8_7_10_count,$m_8_6_10_count,
       $m_7_7_10_count,$m_7_6_10_count,$m_7_5_10_count,
       $m_6_6_10_count,$m_6_5_10_count,
       $m_5_5_10_count,$m_5_4_10_count,
       $m_4_4_10_count,
       $m_3_3_10_count,
       $m_2_2_10_count) {
        
       if (!$this->db_obj) {
        $this->db_obj = new db();
       }
     
       $ssql = sprintf("INSERT INTO `tbl_on_keno_winnings`  (
       `onkenoid`,
       `m_10_10_1_count`,`m_10_10_1_amount`,`m_10_9_1_count`,`m_10_9_1_amount`,`m_10_8_1_count`,`m_10_8_1_amount`,`m_10_7_1_count`,`m_10_7_1_amount`,`m_10_0_1_count`,`m_10_0_1_amount`,
       `m_9_9_1_count`,`m_9_9_1_amount`,`m_9_8_1_count`,`m_9_8_1_amount`,`m_9_7_1_count`,`m_9_7_1_amount`,`m_9_6_1_count`,`m_9_6_1_amount`,
       `m_8_8_1_count`,`m_8_8_1_amount`,`m_8_7_1_count`,`m_8_7_1_amount`,`m_8_6_1_count`,`m_8_6_1_amount`,
       `m_7_7_1_count`,`m_7_7_1_amount`,`m_7_6_1_count`,`m_7_6_1_amount`,`m_7_5_1_count`,`m_7_5_1_amount`,
       `m_6_6_1_count`,`m_6_6_1_amount`,`m_6_5_1_count`,`m_6_5_1_amount`,
       `m_5_5_1_count`,`m_5_5_1_amount`,`m_5_4_1_count`,`m_5_4_1_amount`,
       `m_4_4_1_count`,`m_4_4_1_amount`,
       `m_3_3_1_count`,`m_3_3_1_amount`,
       `m_2_2_1_count`,`m_2_2_1_amount`,
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
       `m_2_2_10_count`) ");
       $ssql .= sprintf(" VALUES ( %u,
       %u,%u,%u,%u,%u,%u,%u,%u,%u,%u,
       %u,%u,%u,%u,%u,%u,%u,%u,
       %u,%u,%u,%u,%u,%u,
       %u,%u,%u,%u,%u,%u,
       %u,%u,%u,%u,
       %u,%u,%u,%u,
       %u,%u,
       %u,%u,
       %u,%u,
       %u,%u,%u,%u,%u,
       %u,%u,%u,%u,
       %u,%u,%u,
       %u,%u,%u,
       %u,%u,
       %u,%u,
       %u,
       %u,
       %u,
       %u,%u,%u,%u,%u,
       %u,%u,%u,%u,
       %u,%u,%u,
       %u,%u,%u,
       %u,%u,
       %u,%u,
       %u,
       %u,
       %u,
       %u,%u,%u,%u,%u,
       %u,%u,%u,%u,
       %u,%u,%u,
       %u,%u,%u,
       %u,%u,
       %u,%u,
       %u,
       %u,
       %u)",
       $onkenoid,
       $m_10_10_1_count,$m_10_10_1_amount,$m_10_9_1_count,$m_10_9_1_amount,$m_10_8_1_count,$m_10_8_1_amount,$m_10_7_1_count,$m_10_7_1_amount,$m_10_0_1_count,$m_10_0_1_amount,
       $m_9_9_1_count,$m_9_9_1_amount,$m_9_8_1_count,$m_9_8_1_amount,$m_9_7_1_count,$m_9_7_1_amount,$m_9_6_1_count,$m_9_6_1_amount,
       $m_8_8_1_count,$m_8_8_1_amount,$m_8_7_1_count,$m_8_7_1_amount,$m_8_6_1_count,$m_8_6_1_amount,
       $m_7_7_1_count,$m_7_7_1_amount,$m_7_6_1_count,$m_7_6_1_amount,$m_7_5_1_count,$m_7_5_1_amount,
       $m_6_6_1_count,$m_6_6_1_amount,$m_6_5_1_count,$m_6_5_1_amount,
       $m_5_5_1_count,$m_5_5_1_amount,$m_5_4_1_count,$m_5_4_1_amount,
       $m_4_4_1_count,$m_4_4_1_amount,
       $m_3_3_1_count,$m_3_3_1_amount,
       $m_2_2_1_count,$m_2_2_1_amount,
       $m_10_10_2_count,$m_10_9_2_count,$m_10_8_2_count,$m_10_7_2_count,$m_10_0_2_count,
       $m_9_9_2_count,$m_9_8_2_count,$m_9_7_2_count,$m_9_6_2_count,
       $m_8_8_2_count,$m_8_7_2_count,$m_8_6_2_count,
       $m_7_7_2_count,$m_7_6_2_count,$m_7_5_2_count,
       $m_6_6_2_count,$m_6_5_2_count,
       $m_5_5_2_count,$m_5_4_2_count,
       $m_4_4_2_count,
       $m_3_3_2_count,
       $m_2_2_2_count,
       $m_10_10_5_count,$m_10_9_5_count,$m_10_8_5_count,$m_10_7_5_count,$m_10_0_5_count,
       $m_9_9_5_count,$m_9_8_5_count,$m_9_7_5_count,$m_9_6_5_count,
       $m_8_8_5_count,$m_8_7_5_count,$m_8_6_5_count,
       $m_7_7_5_count,$m_7_6_5_count,$m_7_5_5_count,
       $m_6_6_5_count,$m_6_5_5_count,
       $m_5_5_5_count,$m_5_4_5_count,
       $m_4_4_5_count,
       $m_3_3_5_count,
       $m_2_2_5_count,
       $m_10_10_10_count,$m_10_9_10_count,$m_10_8_10_count,$m_10_7_10_count,$m_10_0_10_count,
       $m_9_9_10_count,$m_9_8_10_count,$m_9_7_10_count,$m_9_6_10_count,
       $m_8_8_10_count,$m_8_7_10_count,$m_8_6_10_count,
       $m_7_7_10_count,$m_7_6_10_count,$m_7_5_10_count,
       $m_6_6_10_count,$m_6_5_10_count,
       $m_5_5_10_count,$m_5_4_10_count,
       $m_4_4_10_count,
       $m_3_3_10_count,
       $m_2_2_10_count);
      //print "\n" . $ssql;
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
   }
   
   /*
    * $onkenoid
    * 
    */ 
   
   function OLGOnKenoWinningsRemove($onkenoid) {
       if (!$this->db_obj) {
        $this->db_obj = new db();
       }
       $ssql = sprintf("DELETE FROM `tbl_on_keno_winnings` WHERE onkenoid = %u", $onkenoid);
       
       $this->db_obj->exec($ssql);
       return $this->db_obj->rows_affected;
       
   }
   
   /*
    * 
    * 
    * 
    */ 
   
   function OLGOnKenoWinningsModify($onkenowinningid, 
        $onkenoid,
        $m_10_10_1_count,$m_10_10_1_amount,$m_10_9_1_count,$m_10_9_1_amount,$m_10_8_1_count,$m_10_8_1_amount,$m_10_7_1_count,$m_10_7_1_amount,$m_10_0_1_count,$m_10_0_1_amount,
        $m_9_9_1_count,$m_9_9_1_amount,$m_9_8_1_count,$m_9_8_1_amount,$m_9_7_1_count,$m_9_7_1_amount,$m_9_6_1_count,$m_9_6_1_amount,
        $m_8_8_1_count,$m_8_8_1_amount,$m_8_7_1_count,$m_8_7_1_amount,$m_8_6_1_count,$m_8_6_1_amount,
        $m_7_7_1_count,$m_7_7_1_amount,$m_7_6_1_count,$m_7_6_1_amount,$m_7_5_1_count,$m_7_5_1_amount,
        $m_6_6_1_count,$m_6_6_1_amount,$m_6_5_1_count,$m_6_5_1_amount,
        $m_5_5_1_count,$m_5_5_1_amount,$m_5_4_1_count,$m_5_4_1_amount,
        $m_4_4_1_count,$m_4_4_1_amount,$m_3_3_1_count,$m_3_3_1_amount,
        $m_2_2_1_count,$m_2_2_1_amount,
        $m_10_10_2_count,$m_10_9_2_count,$m_10_8_2_count,$m_10_7_2_count,$m_10_0_2_count,
        $m_9_9_2_count,$m_9_8_2_count,$m_9_7_2_count,$m_9_6_2_count,
        $m_8_8_2_count,$m_8_7_2_count,$m_8_6_2_count,
        $m_7_7_2_count,$m_7_6_2_count,$m_7_5_2_count,
        $m_6_6_2_count,$m_6_5_2_count,
        $m_5_5_2_count,$m_5_4_2_count,
        $m_4_4_2_count,
        $m_3_3_2_count,
        $m_2_2_2_count,
        $m_10_10_5_count,$m_10_9_5_count,$m_10_8_5_count,$m_10_7_5_count,$m_10_0_5_count,
        $m_9_9_5_count,$m_9_8_5_count,$m_9_7_5_count,$m_9_6_5_count,
        $m_8_8_5_count,$m_8_7_5_count,$m_8_6_5_count,
        $m_7_7_5_count,$m_7_6_5_count,$m_7_5_5_count,
        $m_6_6_5_count,$m_6_5_5_count,$m_5_5_5_count,$m_5_4_5_count,
        $m_4_4_5_count,
        $m_3_3_5_count,
        $m_2_2_5_count,
        $m_10_10_10_count,$m_10_9_10_count,$m_10_8_10_count,$m_10_7_10_count,$m_10_0_10_count,
        $m_9_9_10_count,$m_9_8_10_count,$m_9_7_10_count,$m_9_6_10_count,
        $m_8_8_10_count,$m_8_7_10_count,$m_8_6_10_count,
        $m_7_7_10_count,$m_7_6_10_count,$m_7_5_10_count,
        $m_6_6_10_count,$m_6_5_10_count,
        $m_5_5_10_count,$m_5_4_10_count,
        $m_4_4_10_count,
        $m_3_3_10_count,
        $m_2_2_10_count,
        $m_2_2_10_amount) {
     
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("UPDATE `tbl_on_keno_winnings` SET (
     `onkenoid` = %u, 
     `m_10_10_1_count` = %u, `m_10_10_1_amount` = %u, `m_10_9_1_count` = %u, `m_10_9_1_amount` = %u, `m_10_8_1_count` = %u, `m_10_8_1_amount` = %u, `m_10_7_1_count` = %u, `m_10_7_1_amount` = %u, `m_10_0_1_count` = %u, `m_10_0_1_amount` = %u, 
     `m_9_9_1_count` = %u, `m_9_9_1_amount` = %u, `m_9_8_1_count` = %u, `m_9_8_1_amount` = %u, `m_9_7_1_count` = %u, `m_9_7_1_amount` = %u, `m_9_6_1_count` = %u, `m_9_6_1_amount` = %u, 
     `m_8_8_1_count` = %u, `m_8_8_1_amount` = %u, `m_8_7_1_count` = %u, `m_8_7_1_amount` = %u, `m_8_6_1_count` = %u, `m_8_6_1_amount` = %u,
      `m_7_7_1_count`,`m_7_7_1_amount` = %u, `m_7_6_1_count` = %u, `m_7_6_1_amount` = %u, `m_7_5_1_count` = %u, `m_7_5_1_amount` = %u, 
      `m_6_6_1_count` = %u, `m_6_6_1_amount` = %u, `m_6_5_1_count` = %u, `m_6_5_1_amount` = %u,
       `m_5_5_1_count` = %u, `m_5_5_1_amount` = %u, `m_5_4_1_count` = %u, `m_5_4_1_amount` = %u,
        `m_4_4_1_count` = %u, `m_4_4_1_amount` = %u,
         `m_3_3_1_count` = %u, `m_3_3_1_amount` = %u,
          `m_2_2_1_count` = %u, `m_2_2_1_amount` = %u,
           `m_10_10_2_count` = %u,  `m_10_9_2_count` = %u,  `m_10_8_2_count` = %u,  `m_10_7_2_count` = %u,  `m_10_0_2_count` = %u, 
       `m_9_9_2_count` = %u,  `m_9_8_2_count` = %u,  `m_9_7_2_count` = %u,  `m_9_6_2_count` = %u,  
       `m_8_8_2_count` = %u,  `m_8_7_2_count` = %u,  `m_8_6_2_count` = %u, 
        `m_7_7_2_count` = %u,  `m_7_6_2_count` = %u,  `m_7_5_2_count` = %u, 
         `m_6_6_2_count` = %u,  `m_6_5_2_count` = %u, 
          `m_5_5_2_count` = %u,  `m_5_4_2_count` = %u, 
           `m_4_4_2_count`,
        `m_3_3_2_count` = %u, 
         `m_2_2_2_count` = %u, 
          `m_10_10_5_count` = %u,  `m_10_9_5_count` = %u,  `m_10_8_5_count` = %u,  `m_10_7_5_count` = %u,  `m_10_0_5_count` = %u,  
          `m_9_9_5_count` = %u,  `m_9_8_5_count` = %u,  `m_9_7_5_count` = %u,  `m_9_6_5_count` = %u, 
           `m_8_8_5_count` = %u,  `m_8_7_5_count` = %u,  `m_8_6_5_count`,
        `m_7_7_5_count` = %u,  `m_7_6_5_count` = %u,  `m_7_5_5_count` = %u, 
         `m_6_6_5_count` = %u,  `m_6_5_5_count` = %u, 
          `m_5_5_5_count` = %u,  `m_5_4_5_count` = %u, 
           `m_4_4_5_count` = %u, 
            `m_3_3_5_count` = %u, 
             `m_2_2_5_count` = %u,  
        `m_10_10_10_count` = %u,  `m_10_9_10_count` = %u,  `m_10_8_10_count` = %u,  `m_10_7_10_count`, `m_10_0_10_count` = %u, 
         `m_9_9_10_count` = %u,  `m_9_8_10_count` = %u,  `m_9_7_10_count` = %u,  `m_9_6_10_count` = %u, 
          `m_8_8_10_count` = %u,  `m_8_7_10_count` = %u,  `m_8_6_10_count` = %u, 
           `m_7_7_10_count` = %u,  `m_7_6_10_count` = %u,  `m_7_5_10_count` = %u, 
            `m_6_6_10_count` = %u,  `m_6_5_10_count` = %u, 
       `m_5_5_10_count` = %u,  `m_5_4_10_count` = %u, 
        `m_4_4_10_count` = %u, 
         `m_3_3_10_count` = %u, 
          `m_2_2_10_count` = %u) 
       WHERE onkenowinningid = %u",
        $onkenoid,
        $m_10_10_1_count,$m_10_10_1_amount,$m_10_9_1_count,$m_10_9_1_amount,$m_10_8_1_count,$m_10_8_1_amount,$m_10_7_1_count,$m_10_7_1_amount,$m_10_0_1_count,$m_10_0_1_amount,
        $m_9_9_1_count,$m_9_9_1_amount,$m_9_8_1_count,$m_9_8_1_amount,$m_9_7_1_count,$m_9_7_1_amount,$m_9_6_1_count,$m_9_6_1_amount,
        $m_8_8_1_count,$m_8_8_1_amount,$m_8_7_1_count,$m_8_7_1_amount,$m_8_6_1_count,$m_8_6_1_amount,
        $m_7_7_1_count,$m_7_7_1_amount,$m_7_6_1_count,$m_7_6_1_amount,$m_7_5_1_count,$m_7_5_1_amount,
       $m_6_6_1_count,$m_6_6_1_amount,$m_6_5_1_count,$m_6_5_1_amount,
       $m_5_5_1_count,$m_5_5_1_amount,$m_5_4_1_count,$m_5_4_1_amount,
       $m_4_4_1_count,$m_4_4_1_amount,
       $m_3_3_1_count,$m_3_3_1_amount,
       $m_2_2_1_count,$m_2_2_1_amount,
       $m_10_10_2_count,$m_10_9_2_count,$m_10_8_2_count,$m_10_7_2_count,$m_10_0_2_count,
       $m_9_9_2_count,$m_9_8_2_count,$m_9_7_2_count,$m_9_6_2_count,
       $m_8_8_2_count,$m_8_7_2_count,$m_8_6_2_count,
       $m_7_7_2_count,$m_7_6_2_count,$m_7_5_2_count,
       $m_6_6_2_count,$m_6_5_2_count,
       $m_5_5_2_count,$m_5_4_2_count,
       $m_4_4_2_count,
       $m_3_3_2_count,
       $m_2_2_2_count,
       $m_10_10_5_count,$m_10_9_5_count,$m_10_8_5_count,$m_10_7_5_count,$m_10_0_5_count,
       $m_9_9_5_count,$m_9_8_5_count,$m_9_7_5_count,$m_9_6_5_count,
       $m_8_8_5_count,$m_8_7_5_count,$m_8_6_5_count,
       $m_7_7_5_count,$m_7_6_5_count,$m_7_5_5_count,
       $m_6_6_5_count,$m_6_5_5_count,
       $m_5_5_5_count,$m_5_4_5_count,
       $m_4_4_5_count,
       $m_3_3_5_count,
       $m_2_2_5_count,
       $m_10_10_10_count,$m_10_9_10_count,$m_10_8_10_count,$m_10_7_10_count,$m_10_0_10_count,
       $m_9_9_10_count,$m_9_8_10_count,$m_9_7_10_count,$m_9_6_10_count,
       $m_8_8_10_count,$m_8_7_10_count,$m_8_6_10_count,
       $m_7_7_10_count,$m_7_6_10_count,$m_7_5_10_count,
       $m_6_6_10_count,$m_6_5_10_count,
       $m_5_5_10_count,$m_5_4_10_count,
       $m_4_4_10_count,
       $m_3_3_10_count,
       $m_2_2_10_count,
        $onkenowinningid);

    $this->db_obj->exec($ssql);
    return $this->rows_affected;       
     
   }
   /*
    * $onkenoid
    * 
    */ 
   function OLGOnKenoWinningsGet($onkenoid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("SELECT * FROM `tbl_on_keno_winnings` WHERE onkenoid = %u", $onkenoid);
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res[0];
     } else {
       return null;
     }
     
   }
   
   /*
    * $onkenoid
    */ 
   function OLGOnKenoWinningsGetId($onkenoid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("SELECT * FROM `tbl_on_keno_winnings` WHERE onkenoid = %u", $onkenoid);
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res["0"]["onkenowinningid"];
     } else {
       return null;
     }
   }
   
   
   function OLGOnKenoWinningsGetDraw($st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num) {
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
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res;
     } else {
       return null;
     }
   }
   
   /*
    * INSERT INTO `dbaLotteries`.`tbl_on_lottario_winnings`
(`onlottariowinningid`,
`onlottarioid`,
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
`m_e_bird_id`,
`m_e_bird_count`,
`m_e_bird_amount`,
`game_total_sales`)
VALUES
(
{onlottariowinningid: INT},
{onlottarioid: INT},
{m_6_count: INT},
{m_6_amount: DOUBLE},
{m_6_region: VARCHAR},
{m_5_b_count: INT},
{m_5_b_amount: DOUBLE},
{m_5_b_region: VARCHAR},
{m_5_count: INT},
{m_5_amount: DOUBLE},
{m_4_count: INT},
{m_4_amount: DOUBLE},
{m_3_count: INT},
{m_3_amount: DOUBLE},
{m_e_bird_id: INT},
{m_e_bird_count: INT},
{m_e_bird_amount: DOUBLE},
{game_total_sales: DOUBLE}
);
    * 
    * 
    * 
    */
   
   
   
   function OLGLottarioWinningsAdd($onlottarioid,$m_6_count,$m_6_amount,$m_6_region,$m_5_b_count,$m_5_b_amount,$m_5_b_region,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_count,$m_3_amount,$m_e_bird_id,$m_e_bird_count,$m_e_bird_amount,$game_total_sales) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("INSERT INTO `tbl_on_lottario_winnings`
          (`onlottarioid`,`m_6_count`,`m_6_amount`,`m_6_region`,`m_5_b_count`,`m_5_b_amount`,`m_5_b_region`,`m_5_count`,`m_5_amount`,`m_4_count`,
          `m_4_amount`,`m_3_count`,`m_3_amount`,`m_e_bird_id`,`m_e_bird_count`,`m_e_bird_amount`,`game_total_sales`)
          VALUES (%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u,%u)", $onlottarioid,$m_6_count,$m_6_amount,$m_6_region,$m_5_b_count,$m_5_b_amount,
          $m_5_b_region,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_count,$m_3_amount,$m_e_bird_id,$m_e_bird_count,$m_e_bird_amount,
          $game_total_sales);
    //print $ssql;
    
    $rows_affected  = $this->db_obj->exec($ssql);
    return $this->db_obj->last_id;     
   }
   
   /*
    * $onlottarioid
    * 
    * 
    */
   function OLGLottarioWinningsRemove($onlottarioid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("DELETE FROM `tbl_on_lottario_winnings` WHERE `onlottarioid` = %u", $onlottarioid);
     
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
   }
   
   /*
    * 
    * 
    * 
    */
   
   function OLGLottarioWinningsModify($onlottariowinningid, $onlottarioid,$m_6_count,$m_6_amount,$m_6_region,$m_5_b_count,$m_5_b_amount,$m_5_b_region,$m_5_count,$m_5_amount,$m_4_count,$m_4_amount,$m_3_count,$m_3_amount,$m_e_bird_id,$m_e_bird_count,$m_e_bird_amount,$game_total_sales) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     
     $ssql = sprintf("UPDATE `tbl_on_lottario_winnings` SET `onlottarioid` = %u,m_6_count` = %u,m_6_amount` = %u,m_6_region` = %u,m_5_b_count` = %u,m_5_b_amount` = %u,m_5_b_region` = %u,m_5_count` = %u,m_5_amount` = %u,m_4_count`,
          `m_4_amount` = %u,m_3_count` = %u,m_3_amount` = %u,m_e_bird_id` = %u,m_e_bird_count` = %u,m_e_bird_amount` = %u,game_total_sales` = %u 
          WHERE `onlottariowinningid` = %u",
          $onlottarioid,$m_6_count,$m_6_amount,$m_6_region,$m_5_b_count,$m_5_b_amount,$m_5_b_region,$m_5_count,$m_5_amount,
          $m_4_count,$m_4_amount,$m_3_count,$m_3_amount,$m_e_bird_id,$m_e_bird_count,$m_e_bird_amount,$game_total_sales, $onlottariowinningid);
          
       
     $this->db_obj->exec($ssql);
     return $this->db_obj->rows_affected;
   }
   
   /*
    * 
    * onlottarioid
    * onlottariowinnningid
    * 
    * 
    */
   function OLGLottarioWinningsGet($onlottarioid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("SELECT * FROM `tbl_on_lottario_winnings` WHERE `onlottarioid` = %u", $onlottarioid);
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res) ) {
       return $db_res[0];
     } else {
       return null;
     }
   }
   
   function OLGLottarioWinningsGetDraw($st_drawdate, $ed_drawdate, $st_row_num, $ed_row_num) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }  
     $ssql = sprintf(" SELECT 
                tbl_lottario.*, tbl_eb.snum1 as eb_snum1, tbl_eb.snum2 as eb_snum2, tbl_eb.snum3 as eb_snum3, tbl_eb.snum4 as eb_snum4,
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
      //print $ssql;
     $ssql .= sprintf(" order by tbl_lottario.drawdate");
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res)) {
       return $db_res;
     } else {
       return null;
     }
     
   }
   
   function OLGLottarioWinningsGetId($onlottarioid) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
     }
     $ssql = sprintf("SELECT * FROM `tbl_on_lottario_winnings` WHERE `onlottarioid` = %u", $onlottarioid);
     $db_res = $this->db_obj->fetch($ssql);
     if (is_array($db_res) ) {
       return $db_res["0"]["onlottariowinningid"];
     } else {
       return null;
     }     
   }
  }

?>