<?php

  include_once("class_db.php");
  class DBUtil {
     var $db_obj;
     
     
     function listAllGames() {
       
       $arGameList = array("na649",
                            "naMax",
                            "on49",
                            "onEncore",
                            "onKeno",
                            "onLottario",
                            "onPick3",
                            "onPick4",
                            "onPoker",
                            "onWinners",
                            "onUserSession");
        $ssql = "SELECT * FROM tbl_lottery_games";
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }                        
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         
         $arGameList["allGames"] = array();
         foreach ($db_res as $db_rs) {
           $arGameList["allGames"][$db_rs["gameid"]] = $db_rs["gamecode"];
         }
       }
                    
      return $arGameList;
      
              
     }
     
     
    function removeAllData() {
     /*
      * 
      * 
      * 
      * 
      * 
      */
      
      
      
      $del_sql_stmt = array("DELETE FROM tbl_fetch_data_stats",
                    "DELETE FROM tbl_fetch_detail",
                    "DELETE FROM tbl_lot_win_locations",
                    "DELETE FROM tbl_na_649",
                    "DELETE FROM tbl_na_649_winnings",
                    "DELETE FROM tbl_na_649_wins_loc",
                    "DELETE FROM tbl_na_lottomax",
                    "DELETE FROM tbl_na_lottomax_winning",
                    "DELETE FROM tbl_na_lottomax_wins_loc",
                    "DELETE FROM tbl_on_49",
                    "DELETE FROM tbl_on_49_winnings",
                    "DELETE FROM tbl_on_early_bird",
                    "DELETE FROM tbl_on_encore",
                    "DELETE FROM tbl_on_encore_winnings",
                    "DELETE FROM tbl_on_keno",
                    "DELETE FROM tbl_on_keno_winnings",
                    "DELETE FROM tbl_on_lottario",
                    "DELETE FROM tbl_on_lottario_winnings",
                    "DELETE FROM tbl_on_major_winners",
                    "DELETE FROM tbl_on_pick3",
                    "DELETE FROM tbl_on_pick3_winnings",
                    "DELETE FROM tbl_on_pick4",
                    "DELETE FROM tbl_on_pick4_winnings",
                    "DELETE FROM tbl_on_poker",
                    "DELETE FROM tbl_on_poker_winnings",
                    "DELETE FROM tbl_on_winners_1000_more",
                    "DELETE FROM tbl_web_urls",
                    "DELETE FROM tbl_winning_prizes",
                    "DELETE FROM tbl_user",
                    "DELETE FROM tbl_user_session",
                    "DELETE FROM tbl_comb_49",
                    "DELETE FROM tbl_comb_649",
                    "DELETE FROM tbl_comb_keno",
                    "DELETE FROM tbl_comb_lottario",
                    "DELETE FROM tbl_comb_max",
                    "DELETE FROM tbl_comb_pick3",
                    "DELETE FROM tbl_comb_pick4",
                    "DELETE FROM tbl_comb_play_hist",
                    "DELETE FROM tbl_comb_play_hist_detail"
                    );
                
                
                
      if (!$this->db_obj) {
          $this->db_obj = new db();
      }                        
      $total_rows_affected = 0;
      foreach ($del_sql_stmt as $del_stmt) {
        $total_rows_affected = $total_rows_affected + $this->db_obj->exec($del_stmt);
      }
                    
      return $total_rows_affected;             
      
      
      
    }
    
    function removeGameData($strGame) {
           $del_sql_stmt = array(
                    "other" => array("DELETE FROM tbl_fetch_data_stats",
                                "DELETE FROM tbl_fetch_detail",
                                "DELETE FROM tbl_lot_win_locations",
                                "DELETE FROM tbl_web_urls"
                                ),
                    "na649" => array ("DELETE FROM tbl_na_649",
                                      "DELETE FROM tbl_na_649_winnings",
                                      "DELETE FROM tbl_na_649_wins_loc"),
                    "naMax" => array("DELETE FROM tbl_na_lottomax",
                                     "DELETE FROM tbl_na_lottomax_winning",
                                     "DELETE FROM tbl_na_lottomax_wins_loc"
                                      ),
                    "on49" => array("DELETE FROM tbl_on_49",
                                    "DELETE FROM tbl_on_49_winnings"),
                    "onEncore" => array("DELETE FROM tbl_on_encore",
                                        "DELETE FROM tbl_on_encore_winnings"),
                    "onKeno" => array("DELETE FROM tbl_on_keno",
                                      "DELETE FROM tbl_on_keno_winnings"),
                    "onLottario" => array("DELETE FROM tbl_on_lottario",
                                          "DELETE FROM tbl_on_lottario_winnings",
                                           "DELETE FROM tbl_on_early_bird"),
                    
                    "onPick3" => array("DELETE FROM tbl_on_pick3",
                                        "DELETE FROM tbl_on_pick3_winnings"),
                    "onPick4" => array("DELETE FROM tbl_on_pick4",
                                    "DELETE FROM tbl_on_pick4_winnings"),
                    "onPoker" => array("DELETE FROM tbl_on_poker",
                                    "DELETE FROM tbl_on_poker_winnings"),
                    "onWinners" => array("DELETE FROM tbl_on_major_winners",
                                      "DELETE FROM tbl_on_winners_1000_more",
                                      "DELETE FROM tbl_winning_prizes"),
                    

                    "onUserSession" => array(
                                    "DELETE FROM tbl_user",
                                    "DELETE FROM tbl_user_session",
                                    "DELETE FROM tbl_comb_49",
                                    "DELETE FROM tbl_comb_649",
                                    "DELETE FROM tbl_comb_keno",
                                    "DELETE FROM tbl_comb_lottario",
                                    "DELETE FROM tbl_comb_max",
                                    "DELETE FROM tbl_comb_pick3",
                                    "DELETE FROM tbl_comb_pick4",
                                    "DELETE FROM tbl_comb_play_hist",
                                    "DELETE FROM tbl_comb_play_hist_detail")
                    );
        
      if (!$this->db_obj) {
          $this->db_obj = new db();
      }                        


      $total_rows_affected = 0;
      if ($strGame != "") {
        if (array_key_exists($strGame, $del_sql_stmt)) {
          $arGameDelSql = $strGame[$strGame];
          foreach ($arGameDelSql as $del_stmt) {
            $total_rows_affected = $total_rows_affected + $this->db_obj->exec($del_stmt);            
          }
        }
      }
     
     return $total_rows_affected; 
    }
    
    function removeGameDraw($strGame, $drawDate) {
        $del_sql_stmt = array(
                    "other" => array("DELETE FROM tbl_fetch_data_stats",
                                "DELETE FROM tbl_fetch_detail",
                                "DELETE FROM tbl_lot_win_locations",
                                "DELETE FROM tbl_web_urls"
                                ),
                    "na649" => array ("DELETE tbl_na_649_winnings, tbl_na_649 FROM tbl_na_649_winnings, tbl_na_649
                                       WHERE tbl_na_649_winnings.na649id = tbl_na_649.na649id AND tbl_na_649.na649id = 
                                       (SELECT na649id FROM tbl_na_649 WHERE drawdate = '" . $drawdate . "')"
                                     ),
                    "on49" => array("DELETE tbl_on_49_winnings, tbl_on_49 FROM tbl_on_49_winnings, tbl_on_49
                                       WHERE tbl_on_49_winnings.on49id = tbl_on_49.on49id AND tbl_on_49.on49id = 
                                       (SELECT on49id FROM tbl_on_49 WHERE drawdate = '" . $drawdate . "')"
                                     ),
                    "onEncore" => array("DELETE tbl_on_encore_winnings, tbl_on_encore FROM tbl_on_encore_winnings, tbl_on_encore
                                       WHERE tbl_on_encore_winnings.onencoreid = tbl_on_encore.onencoreid AND tbl_on_encore.onencoreid = 
                                       (SELECT onencoreid FROM tbl_on_encore WHERE drawdate = '" . $drawdate . "')"
                                       ),
                    "onKeno" => array("DELETE tbl_on_keno_winnings, tbl_on_keno FROM tbl_on_keno_winnings, tbl_on_keno
                                       WHERE tbl_on_keno_winnings.onkenoid = tbl_on_keno.onkenoid AND tbl_on_keno.onkenoid = 
                                       (SELECT onkenoid FROM tbl_on_keno WHERE drawdate = '" . $drawdate . "')"
                                     ),
                    "onLottario" => array("DELETE tbl_on_lottario_winnings, tbl_on_early_bird, tbl_on_lottario  FROM tbl_on_lottario_winnings, tbl_on_lottario, tbl_on_early_bird
                                       WHERE tbl_on_lottario_winnings.onlottarioid = tbl_on_lottario.onlottarioid AND tbl_on_lottario.onlottarioid = tbl_on_early_bird.onlottarioid AND tbl_on_lottario.onlottarioid = 
                                       (SELECT onlottarioid FROM tbl_on_lottario WHERE drawdate = '" . $drawdate . "')"
                                      ),
                    
                    "onPick3" => array("DELETE tbl_on_pick3_winnings, tbl_on_pick3 FROM tbl_on_pick3_winnings, tbl_on_pick3
                                       WHERE tbl_on_pick3_winnings.onpick3id = tbl_on_pick3.onpick3id AND tbl_on_pick3.onpick3id = 
                                       (SELECT onpick3id FROM tbl_on_pick3 WHERE drawdate = '" . $drawdate . "')"
                                       ),
                    "onPick4" => array("DELETE tbl_on_pick4_winnings, tbl_on_49 FROM tbl_on_pick4_winnings, tbl_on_49
                                       WHERE tbl_on_pick4_winnings.onpick4id = tbl_on_49.onpick4id AND tbl_on_49.onpick4id = 
                                       (SELECT onpick4id FROM tbl_on_49 WHERE drawdate = '" . $drawdate . "')"
                                    ),
                    "onPoker" => array("DELETE tbl_on_poker_winnings, tbl_on_poker FROM tbl_on_poker_winnings, tbl_on_poker
                                       WHERE tbl_on_poker_winnings.onpokerid = tbl_on_poker.onpokerid AND tbl_on_poker.onpokerid = 
                                       (SELECT onpokerid FROM tbl_on_poker WHERE drawdate = '" . $drawdate . "')"
                                       ),
                    "onWinners" => array("DELETE FROM tbl_on_major_winners",
                                      "DELETE FROM tbl_on_winners_1000_more",
                                      "DELETE FROM tbl_winning_prizes"),
                    

                    "onUserSession" => array(
                                    "DELETE FROM tbl_user",
                                    "DELETE FROM tbl_user_session",
                                    "DELETE FROM tbl_comb_49",
                                    "DELETE FROM tbl_comb_649",
                                    "DELETE FROM tbl_comb_keno",
                                    "DELETE FROM tbl_comb_lottario",
                                    "DELETE FROM tbl_comb_max",
                                    "DELETE FROM tbl_comb_pick3",
                                    "DELETE FROM tbl_comb_pick4",
                                    "DELETE FROM tbl_comb_play_hist",
                                    "DELETE FROM tbl_comb_play_hist_detail")
                    );
                    
                    
     if (!$this->db_obj) {
          $this->db_obj = new db();
      }                        


      $total_rows_affected = 0;
      if ($strGame != "") {
        if (array_key_exists($strGame, $del_sql_stmt)) {
          $arGameDelSql = $strGame[$strGame];
          foreach ($arGameDelSql as $del_stmt) {
            $total_rows_affected = $total_rows_affected + $this->db_obj->exec($del_stmt);            
          }
        }
      }
     
     return $total_rows_affected; 
    }
    
    
    
    function removeGameDataOn($strGame, $startDate, $endDate) {
              
          // get start and end date of month  
         //$startDate = date('Y-m-d', mktime(0,0,0,$month, 1 , $year));
         // $endDate   = date('Y-m-d', mktime(0,0,0,$month + 1, 0 , $year));
           
          $del_sql_stmt = array(
                  
                    "na649" => array ("DELETE tbl_na_649_winnings, tbl_na_649 FROM tbl_na_649_winnings, tbl_na_649
                                       WHERE tbl_na_649_winnings.na649id = tbl_na_649.na649id AND tbl_na_649.na649id = 
                                       (SELECT na649id FROM tbl_na_649 WHERE tbl_na_649.drawdate >= '" . $startDate . "' AND tbl_na_649.drawdate <= '" . $endDate . "' )"
                                     ),
                    "on49" => array("DELETE tbl_on_49_winnings, tbl_on_49 FROM tbl_on_49_winnings, tbl_on_49
                                       WHERE tbl_on_49_winnings.on49id = tbl_on_49.on49id AND tbl_on_49.on49id = 
                                       (SELECT on49id FROM tbl_on_49 WHERE tbl_on_49.drawdate >= '" . $startDate . "' AND tbl_on_49.drawdate <= '" . $endDate . "')"
                                     ),
                    "onEncore" => array("DELETE tbl_on_encore_winnings, tbl_on_encore FROM tbl_on_encore_winnings, tbl_on_encore
                                       WHERE tbl_on_encore_winnings.onencoreid = tbl_on_encore.onencoreid AND tbl_on_encore.onencoreid = 
                                       (SELECT onencoreid FROM tbl_on_encore WHERE tbl_on_encore.drawdate >= '" . $startDate . "' AND tbl_on_encore.drawdate <= '" . $endDate . "')"
                                       ),
                    "onKeno" => array("DELETE tbl_on_keno_winnings, tbl_on_keno FROM tbl_on_keno_winnings, tbl_on_keno
                                       WHERE tbl_on_keno_winnings.onkenoid = tbl_on_keno.onkenoid AND tbl_on_keno.onkenoid = 
                                       (SELECT onkenoid FROM tbl_on_keno WHERE tbl_on_keno.drawdate >= '" . $startDate . "' AND tbl_on_keno.drawdate <= '" . $endDate . "')"
                                     ),
                    "onLottario" => array("DELETE tbl_on_lottario_winnings, tbl_on_early_bird, tbl_on_lottario  FROM tbl_on_lottario_winnings, tbl_on_lottario, tbl_on_early_bird
                                       WHERE tbl_on_lottario_winnings.onlottarioid = tbl_on_lottario.onlottarioid AND tbl_on_lottario.onlottarioid = tbl_on_early_bird.onlottarioid AND tbl_on_lottario.onlottarioid = 
                                       (SELECT onlottarioid FROM tbl_on_lottario WHERE tbl_on_lottario.drawdate >= '" . $startDate . "' AND tbl_on_lottario.drawdate <= '" . $endDate . "')"
                                      ),
                    
                    "onPick3" => array("DELETE tbl_on_pick3_winnings, tbl_on_pick3 FROM tbl_on_pick3_winnings, tbl_on_pick3
                                       WHERE tbl_on_pick3_winnings.onpick3id = tbl_on_pick3.onpick3id AND tbl_on_pick3.onpick3id = 
                                       (SELECT onpick3id FROM tbl_on_pick3 WHERE tbl_on_pick3.drawdate >= '" . $startDate . "' AND tbl_on_pick3.drawdate <= '" . $endDate . "')"
                                       ),
                    "onPick4" => array("DELETE tbl_on_pick4_winnings, tbl_on_pick4 FROM tbl_on_pick4_winnings, tbl_on_pick4
                                       WHERE tbl_on_pick4_winnings.onpick4id = tbl_on_pick4.onpick4id AND tbl_on_pick4.onpick4id = 
                                       (SELECT onpick4id FROM tbl_on_pick4 WHERE tbl_on_pick4.drawdate >= '" . $startDate . "' AND tbl_on_pick4.drawdate <= '" . $endDate . "')"
                                    ),
                    "onPoker" => array("DELETE tbl_on_poker_winnings, tbl_on_poker FROM tbl_on_poker_winnings, tbl_on_poker
                                       WHERE tbl_on_poker_winnings.onpokerid = tbl_on_poker.onpokerid AND tbl_on_poker.onpokerid = 
                                       (SELECT onpokerid FROM tbl_on_poker WHERE tbl_on_poker.drawdate >= '" . $startDate . "' AND tbl_on_poker.drawdate <= '" . $endDate . "')"
                   
                        ));
                     
                    
       if (!$this->db_obj) {
            $this->db_obj = new db();
        }                        
  
  
        $total_rows_affected = 0;
        if ($strGame != "") {
          if (array_key_exists($strGame, $del_sql_stmt)) {
            $arGameDelSql = $strGame[$strGame];
            foreach ($arGameDelSql as $del_stmt) {
              $total_rows_affected = $total_rows_affected + $this->db_obj->exec($del_stmt);            
            }
          }
        }
       
       return $total_rows_affected;           
                     
                
        
      
    }
    function removeGameMonthDraw($strGame, $month, $year) {
              
          // get start and end date of month  
         $startDate = date('Y-m-d', mktime(0,0,0,$month, 1 , $year));
          $endDate   = date('Y-m-d', mktime(0,0,0,$month + 1, 0 , $year));
           
          $del_sql_stmt = array(
                  
                    "na649" => array ("DELETE tbl_na_649_winnings, tbl_na_649 FROM tbl_na_649_winnings, tbl_na_649
                                       WHERE tbl_na_649_winnings.na649id = tbl_na_649.na649id AND tbl_na_649.na649id = 
                                       (SELECT na649id FROM tbl_na_649 WHERE tbl_na_649.drawdate >= '" . $startDate . "' AND tbl_na_649.drawdate <= '" . $endDate . "' )"
                                     ),
                    "on49" => array("DELETE tbl_on_49_winnings, tbl_on_49 FROM tbl_on_49_winnings, tbl_on_49
                                       WHERE tbl_on_49_winnings.on49id = tbl_on_49.on49id AND tbl_on_49.on49id = 
                                       (SELECT on49id FROM tbl_on_49 WHERE tbl_on_49.drawdate >= '" . $startDate . "' AND tbl_on_49.drawdate <= '" . $endDate . "')"
                                     ),
                    "onEncore" => array("DELETE tbl_on_encore_winnings, tbl_on_encore FROM tbl_on_encore_winnings, tbl_on_encore
                                       WHERE tbl_on_encore_winnings.onencoreid = tbl_on_encore.onencoreid AND tbl_on_encore.onencoreid = 
                                       (SELECT onencoreid FROM tbl_on_encore WHERE tbl_on_encore.drawdate >= '" . $startDate . "' AND tbl_on_encore.drawdate <= '" . $endDate . "')"
                                       ),
                    "onKeno" => array("DELETE tbl_on_keno_winnings, tbl_on_keno FROM tbl_on_keno_winnings, tbl_on_keno
                                       WHERE tbl_on_keno_winnings.onkenoid = tbl_on_keno.onkenoid AND tbl_on_keno.onkenoid = 
                                       (SELECT onkenoid FROM tbl_on_keno WHERE tbl_on_keno.drawdate >= '" . $startDate . "' AND tbl_on_keno.drawdate <= '" . $endDate . "')"
                                     ),
                    "onLottario" => array("DELETE tbl_on_lottario_winnings, tbl_on_early_bird, tbl_on_lottario  FROM tbl_on_lottario_winnings, tbl_on_lottario, tbl_on_early_bird
                                       WHERE tbl_on_lottario_winnings.onlottarioid = tbl_on_lottario.onlottarioid AND tbl_on_lottario.onlottarioid = tbl_on_early_bird.onlottarioid AND tbl_on_lottario.onlottarioid = 
                                       (SELECT onlottarioid FROM tbl_on_lottario WHERE tbl_on_lottario.drawdate >= '" . $startDate . "' AND tbl_on_lottario.drawdate <= '" . $endDate . "')"
                                      ),
                    
                    "onPick3" => array("DELETE tbl_on_pick3_winnings, tbl_on_pick3 FROM tbl_on_pick3_winnings, tbl_on_pick3
                                       WHERE tbl_on_pick3_winnings.onpick3id = tbl_on_pick3.onpick3id AND tbl_on_pick3.onpick3id = 
                                       (SELECT onpick3id FROM tbl_on_pick3 WHERE tbl_on_pick3.drawdate >= '" . $startDate . "' AND tbl_on_pick3.drawdate <= '" . $endDate . "')"
                                       ),
                    "onPick4" => array("DELETE tbl_on_pick4_winnings, tbl_on_pick4 FROM tbl_on_pick4_winnings, tbl_on_pick4
                                       WHERE tbl_on_pick4_winnings.onpick4id = tbl_on_pick4.onpick4id AND tbl_on_pick4.onpick4id = 
                                       (SELECT onpick4id FROM tbl_on_pick4 WHERE tbl_on_pick4.drawdate >= '" . $startDate . "' AND tbl_on_pick4.drawdate <= '" . $endDate . "')"
                                    ),
                    "onPoker" => array("DELETE tbl_on_poker_winnings, tbl_on_poker FROM tbl_on_poker_winnings, tbl_on_poker
                                       WHERE tbl_on_poker_winnings.onpokerid = tbl_on_poker.onpokerid AND tbl_on_poker.onpokerid = 
                                       (SELECT onpokerid FROM tbl_on_poker WHERE tbl_on_poker.drawdate >= '" . $startDate . "' AND tbl_on_poker.drawdate <= '" . $endDate . "')"
                   
                        ));
                     
                    
       if (!$this->db_obj) {
            $this->db_obj = new db();
        }                        
  
  
        $total_rows_affected = 0;
        if ($strGame != "") {
          if (array_key_exists($strGame, $del_sql_stmt)) {
            $arGameDelSql = $strGame[$strGame];
            foreach ($arGameDelSql as $del_stmt) {
              $total_rows_affected = $total_rows_affected + $this->db_obj->exec($del_stmt);            
            }
          }
        }
       
       return $total_rows_affected;           
                     
                
        
      
    }
    
    function removeGameYearDraw($strGame, $year) {
              
        // get start and end date of month  
        $startDate = date('Y-m-d', mktime(0,0,0,1, 1 , $year));
        $endDate   = date('Y-m-d', mktime(0,0,0,12, 31 , $year));
         
       $del_sql_stmt = array(
                  
                    "na649" => array ("DELETE tbl_na_649_winnings, tbl_na_649 FROM tbl_na_649_winnings, tbl_na_649
                                       WHERE tbl_na_649_winnings.na649id = tbl_na_649.na649id AND tbl_na_649.na649id = 
                                       (SELECT na649id FROM tbl_na_649 WHERE tbl_na_649.drawdate >= '" . $startDate . "' AND tbl_na_649.drawdate <= '" . $endDate . "' )"
                                     ),
                    "on49" => array("DELETE tbl_on_49_winnings, tbl_on_49 FROM tbl_on_49_winnings, tbl_on_49
                                       WHERE tbl_on_49_winnings.on49id = tbl_on_49.on49id AND tbl_on_49.on49id = 
                                       (SELECT on49id FROM tbl_on_49 WHERE tbl_on_49.drawdate >= '" . $startDate . "' AND tbl_on_49.drawdate <= '" . $endDate . "')"
                                     ),
                    "onEncore" => array("DELETE tbl_on_encore_winnings, tbl_on_encore FROM tbl_on_encore_winnings, tbl_on_encore
                                       WHERE tbl_on_encore_winnings.onencoreid = tbl_on_encore.onencoreid AND tbl_on_encore.onencoreid = 
                                       (SELECT onencoreid FROM tbl_on_encore WHERE tbl_on_encore.drawdate >= '" . $startDate . "' AND tbl_on_encore.drawdate <= '" . $endDate . "')"
                                       ),
                    "onKeno" => array("DELETE tbl_on_keno_winnings, tbl_on_keno FROM tbl_on_keno_winnings, tbl_on_keno
                                       WHERE tbl_on_keno_winnings.onkenoid = tbl_on_keno.onkenoid AND tbl_on_keno.onkenoid = 
                                       (SELECT onkenoid FROM tbl_on_keno WHERE tbl_on_keno.drawdate >= '" . $startDate . "' AND tbl_on_keno.drawdate <= '" . $endDate . "')"
                                     ),
                    "onLottario" => array("DELETE tbl_on_lottario_winnings, tbl_on_early_bird, tbl_on_lottario  FROM tbl_on_lottario_winnings, tbl_on_lottario, tbl_on_early_bird
                                       WHERE tbl_on_lottario_winnings.onlottarioid = tbl_on_lottario.onlottarioid AND tbl_on_lottario.onlottarioid = tbl_on_early_bird.onlottarioid AND tbl_on_lottario.onlottarioid = 
                                       (SELECT onlottarioid FROM tbl_on_lottario WHERE tbl_on_lottario.drawdate >= '" . $startDate . "' AND tbl_on_lottario.drawdate <= '" . $endDate . "')"
                                      ),
                    
                    "onPick3" => array("DELETE tbl_on_pick3_winnings, tbl_on_pick3 FROM tbl_on_pick3_winnings, tbl_on_pick3
                                       WHERE tbl_on_pick3_winnings.onpick3id = tbl_on_pick3.onpick3id AND tbl_on_pick3.onpick3id = 
                                       (SELECT onpick3id FROM tbl_on_pick3 WHERE tbl_on_pick3.drawdate >= '" . $startDate . "' AND tbl_on_pick3.drawdate <= '" . $endDate . "')"
                                       ),
                    "onPick4" => array("DELETE tbl_on_pick4_winnings, tbl_on_pick4 FROM tbl_on_pick4_winnings, tbl_on_pick4
                                       WHERE tbl_on_pick4_winnings.onpick4id = tbl_on_pick4.onpick4id AND tbl_on_pick4.onpick4id = 
                                       (SELECT onpick4id FROM tbl_on_pick4 WHERE tbl_on_pick4.drawdate >= '" . $startDate . "' AND tbl_on_pick4.drawdate <= '" . $endDate . "')"
                                    ),
                    "onPoker" => array("DELETE tbl_on_poker_winnings, tbl_on_poker FROM tbl_on_poker_winnings, tbl_on_poker
                                       WHERE tbl_on_poker_winnings.onpokerid = tbl_on_poker.onpokerid AND tbl_on_poker.onpokerid = 
                                       (SELECT onpokerid FROM tbl_on_poker WHERE tbl_on_poker.drawdate >= '" . $startDate . "' AND tbl_on_poker.drawdate <= '" . $endDate . "')"
                   
                                  ));
                     
      
                     
       if (!$this->db_obj) {
            $this->db_obj = new db();
        }                        
  
  
        $total_rows_affected = 0;
        if ($strGame != "") {
          if (array_key_exists($strGame, $del_sql_stmt)) {
            $arGameDelSql = $strGame[$strGame];
            foreach ($arGameDelSql as $del_stmt) {
              $total_rows_affected = $total_rows_affected + $this->db_obj->exec($del_stmt);            
            }
          }
        }
       
       return $total_rows_affected;           
                     
        
    }
    
    
    
  }




?>