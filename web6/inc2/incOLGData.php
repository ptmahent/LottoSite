<?php

  include_once("class_db.php");
  include_once("incGenDates.php");
  include_once("incALCLottery.php");
  include_once("incNaLottery.php");
  include_once("incLottery.php");
  include_once("incOLGLottery.php");
  include_once("class_http.php");


  class OLGData {
  
  
  function OLGEncoreParse($arEncore_th, $drawdate, $debug_mode = 0) {
        $objOLG       = new OLGLottery();
        $objLottery   = new Lottery();
        $objDate      = new GenDates();

         $onEncore_row = $objLottery->dbLotteryGamesGet("onEncore"); 
        $str_money_sym = array("$",","); 
        foreach ($arEncore_th as $th_cnt => $lmatches) {
          if (preg_match("/\d{7}/i", $lmatches[1], $lot_match)) {
              $s7m_count    = trim($lmatches[2]);
              $s7m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $s7m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($s7m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$s7m_prze_id) {
                $s7m_prze_id = $objLottery->dbLotteryWinPrizesAdd($s7m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }
            // _734252
              if ($debug_mode > 1) {
                print "[m7|" . $s7m_prze_amt . "|" . $s7m_prze_id . "]";
              }
            } elseif (preg_match("/[_]{1}\d{6}/i", $lmatches[1], $lot_match)) {
              $sr6m_count    = trim($lmatches[2]);
              $sr6m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sr6m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sr6m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sr6m_prze_id) {
                $sr6m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sr6m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }
            // __34252
              if ($debug_mode > 1) {
                print "[m6r|" . $sr6m_prze_amt . "|" . $sr6m_prze_id . "]";
              }
            } elseif (preg_match("/[_]{2}\d{5}/i", $lmatches[1], $lot_match)) {
              $sr5m_count    = trim($lmatches[2]);
              $sr5m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sr5m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sr5m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sr5m_prze_id) {
                $sr5m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sr5m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }
              if ($debug_mode > 1) {
                print "[m5r|" . $sr5m_prze_amt . "|" . $sr5m_prze_id . "]";
              }
            // ___4252  
            } elseif (preg_match("/[_]{3}\d{4}/i", $lmatches[1], $lot_match)) {
              $sr4m_count    = trim($lmatches[2]);
              $sr4m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sr4m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sr4m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sr4m_prze_id) {
                $sr4m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sr4m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }
              if ($debug_mode > 1) {
                print "[m4r|" . $sr4m_prze_amt . "|" . $sr4m_prze_id . "]";
              }
            // ____252
            } elseif (preg_match("/[_]{4}\d{3}/i", $lmatches[1], $lot_match)) {
              $sr3m_count    = trim($lmatches[2]);
              $sr3m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sr3m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sr3m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sr3m_prze_id) {
                $sr3m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sr3m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }
              if ($debug_mode > 1) {
                print "[m3r|" . $sr3m_prze_amt . "|" . $sr3m_prze_id . "]"; 
              }
            // _____52
            } elseif (preg_match("/[_]{5}\d{2}/i", $lmatches[1], $lot_match)) {
              $sr2m_count    = trim($lmatches[2]);
              $sr2m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sr2m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sr2m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sr2m_prze_id) {
                $sr2m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sr2m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }
              if ($debug_mode > 1) {
                print "[m2r|" . $sr2m_prze_amt . "|" . $sr2m_prze_id . "]";
              }
            // ______2
            } elseif (preg_match("/[_]{6}\d{1}/i", $lmatches[1], $lot_match)) {
              $sr1m_count    = trim($lmatches[2]);
              $sr1m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sr1m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sr1m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sr1m_prze_id) {
                $sr1m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sr1m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }
              if ($debug_mode > 1) {
                print "[m1r|" . $sr1m_prze_amt . "|" . $sr1m_prze_id . "]";
              }
            // 873425_
            } elseif (preg_match("/\d{6}[_]{1}/i", $lmatches[1], $lot_match)) {
              $sL6m_count    = trim($lmatches[2]);
              $sL6m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL6m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL6m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL6m_prze_id) {
                $sL6m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL6m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              } 
              if ($debug_mode > 1) {
                print "[m6L|" . $sL6m_prze_amt . "|" . $sL6m_prze_id . "]";
              }
            // 87342__
            } elseif (preg_match("/\d{5}[_]{2}/i", $lmatches[1], $lot_match)) {
              $sL5m_count    = trim($lmatches[2]);
              $sL5m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL5m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL5m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL5m_prze_id) {
                $sL5m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL5m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              } 
              if ($debug_mode > 1) {
                print "[m5L|" . $sL5m_prze_amt . "|" . $sL5m_prze_id . "]";
              }
            // 8734___
            } elseif (preg_match("/\d{4}[_]{3}/i", $lmatches[1], $lot_match)) {
              $sL4m_count    = trim($lmatches[2]);
              $sL4m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL4m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL4m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL4m_prze_id) {
                $sL4m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL4m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }       
              if ($debug_mode > 1) {
                print "[m4L|" . $sL4m_prze_amt . "|" . $sL4m_prze_id . "]";
              }
            // 873____    
            } elseif (preg_match("/\d{3}[_]{4}/i", $lmatches[1], $lot_match)) {
              $sL3m_count    = trim($lmatches[2]);
              $sL3m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL3m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL3m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL3m_prze_id) {
                $sL3m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL3m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }
              if ($debug_mode > 1) {
                print "[m3L|" . $sL3m_prze_amt  . "|" . $sL3m_prze_id . "]";
              }
            // 87_____
            } elseif (preg_match("/\d{2}[_]{5}/i", $lmatches[1], $lot_match)) {
              $sL2m_count    = trim($lmatches[2]);
              $sL2m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL2m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL2m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL2m_prze_id) {
                $sL2m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL2m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }          
              if ($debug_mode > 1) {
                print "[m2L|" . $sL2m_prze_amt . "|" . $sL2m_prze_id . "]";
              }
            // 87342_2
            } elseif (preg_match("/\d{5}[_]{1}\d{1}/i", $lmatches[1], $lot_match)) {
              $sL5r1m_count    = trim($lmatches[2]);
              $sL5r1m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL5r1m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL5r1m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL5r1m_prze_id) {
                $sL5r1m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL5r1m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }          
              if ($debug_mode > 1) {
                print "[m5L1R|" . $sL5r1m_prze_amt . "|" . $sL5r1m_prze_id . "]";
              }
            // 8734_52
            } elseif (preg_match("/\d{4}[_]{1}\d{2}/i", $lmatches[1], $lot_match)) {
              $sL4r2m_count    = trim($lmatches[2]);
              $sL4r2m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL4r2m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL4r2m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL4r2m_prze_id) {
                $sL4r2m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL4r2m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }             
              if ($debug_mode > 1) {
                print "[m4L2R|" . $sL4r2m_prze_amt . "|" . $sL4r2m_prze_id . "]";
              }
            // 8734__2  
            } elseif (preg_match("/\d{4}[_]{2}\d{1}/i", $lmatches[1], $lot_match)) {
              $sL4r1m_count    = trim($lmatches[2]);
              $sL4r1m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL4r1m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL4r1m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL4r1m_prze_id) {
                $sL4r1m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL4r1m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }            
              if ($debug_mode > 1) {
                print "[m4L1R|" . $sL4r1m_prze_amt . "|" . $sL4r1m_prze_id . "]";
              }
            // 873_252
            } elseif (preg_match("/\d{3}[_]{1}\d{3}/i", $lmatches[1], $lot_match)) {
              $sL3r3m_count    = trim($lmatches[2]);
              $sL3r3m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL3r3m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL3r3m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL3r3m_prze_id) {
                $sL3r3m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL3r3m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }  
              if ($debug_mode > 1) {
                print "[m3L3R|" . $sL3r3m_prze_amt . "|" . $sL3r3m_prze_id . "]";
              }
              // 873__52
            } elseif(preg_match("/\d{3}[_]{2}\d{2}/i", $lmatches[1], $lot_match)) { 
              $sL3r2m_count    = trim($lmatches[2]);
              $sL3r2m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL3r2m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL3r2m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL3r2m_prze_id) {
                $sL3r2m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL3r2m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }                       
              if ($debug_mode > 1) {
                print "[m3L2R|" . $sL3r2m_prze_amt . "|" . $sL3r2m_prze_id . "]";
              }
            // 873___2
            } elseif (preg_match("/\d{3}[_]{3}\d{1}/i", $lmatches[1], $lot_match)) {
              $sL3r1m_count    = trim($lmatches[2]);
              $sL3r1m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL3r1m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL3r1m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL3r1m_prze_id) {
                $sL3r1m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL3r1m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }                                
              if ($debug_mode > 1) {
                print "[m3L1R|" . $sL3r1m_prze_amt . "|" . $sL3r1m_prze_id . "]";
              }
            // 87_4252
            } elseif (preg_match("/\d{2}[_]{1}\d{4}/i", $lmatches[1], $lot_match)) {
              $sL2r4m_count    = trim($lmatches[2]);
              $sL2r4m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL2r4m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL2r4m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL2r4m_prze_id) {
                $sL2r4m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL2r4m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }                  
              if ($debug_mode > 1) {
                print "[m2L4R|" . $sL2r4m_prze_amt . "|" . $sL2r4m_prze_id . "]";
              }                        
            // 87__252
            } elseif (preg_match("/\d{2}[_]{2}\d{3}/i", $lmatches[1], $lot_match)) {
              $sL2r3m_count    = trim($lmatches[2]);
              $sL2r3m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL2r3m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL2r3m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL2r3m_prze_id) {
                $sL2r3m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL2r3m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }           
              if ($debug_mode > 1) {
                print "[m2L3R|" . $sL2r3m_prze_amt . "|" . $sL2r3m_prze_id . "]";
              } 
            // 87___52
            } elseif (preg_match("/\d{2}[_]{3}\d{2}/i", $lmatches[1], $lot_match)) {
              $sL2r2m_count    = trim($lmatches[2]);
              $sL2r2m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL2r2m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL2r2m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL2r2m_prze_id) {
                $sL2r2m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL2r2m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }                  
              if ($debug_mode > 1) {
                print "[m2L2R|" . $sL2r2m_prze_amt . "|" . $sL2r2m_prze_id  . "]";
              }
            // 87____2
            } elseif (preg_match("/\d{2}[_]{4}\d{1}/i", $lmatches[1], $lot_match)) {
              $sL2r1m_count    = trim($lmatches[2]);
              $sL2r1m_prze_amt = str_replace($str_money_sym,"", trim($lmatches[3]));
              $sL2r1m_prze_id  = $objLottery->dbLotteryWinPrizesGetId($sL2r1m_prze_amt, $objLottery->prz_money, $onEncore_row["gameid"]);
              if (!$sL2r1m_prze_id) {
                $sL2r1m_prze_id = $objLottery->dbLotteryWinPrizesAdd($sL2r1m_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onEncore_row["gameid"]);
              }
              if ($debug_mode > 1) {
                print "m2L1R|" . $sL2r1m_prze_amt . "|" . $sL2r1m_prze_id . "]";
              }
              $sencore_drawDate = $drawdate;
              if ($debug_mode < 0) {
                print "\nParse Encore " . date('Y-m-d', $drawdate);
              }              
              
              //print "\n\nEncore Date: " . $sencore_drawDate . " --- " . date('Y-m-d',$drawdate);
              $str_on_encore_drawId = $objOLG->OLGEncoreGetDrawId(date('Y-m-d',$drawdate));
              //print "\nEncore Id: " . $str_on_encore_drawId;
              if ($str_on_encore_drawId != "")  {
                $str_on_encore_winning_id = $objOLG->OLGOnEncoreWinningsGetId($str_on_encore_drawId);
               // print "\nEncore Win Id: " . $str_on_encore_winning_id;
                if (!$str_on_encore_winning_id) {
                    $str_on_encore_winning_id = $objOLG->OLGOnEncoreWinningsAdd($str_on_encore_drawId,
                          $s7m_count,$s7m_prze_id,            // 8734252
                          $sr6m_count,$sr6m_prze_id,          // _734252
                          $sr5m_count,$sr5m_prze_id,          // __34252
                          $sr4m_count,$sr4m_prze_id,          // ___4252  
                          $sr3m_count,$sr3m_prze_id,          // ____252
                          $sr2m_count,$sr2m_prze_id,          // _____52
                          $sr1m_count,$sr1m_prze_id,          // ______2
                          $sL6m_count,$sL6m_prze_id,          // 873425_
                          $sL5m_count,$sL5m_prze_id,          // 87342__
                          $sL4m_count,$sL4m_prze_id,          // 8734___
                          $sL3m_count,$sL3m_prze_id,          // 873____
                          $sL2m_count,$sL2m_prze_id,          // 87_____
                          $sL5r1m_count,$sL5r1m_prze_id,      // 87342_2
                          $sL4r2m_count,$sL4r2m_prze_id,      // 8734_52
                          $sL4r1m_count,$sL4r1m_prze_id,      // 8734__2  
                          $sL3r3m_count,$sL3r3m_prze_id,      // 873_252
                          $sL3r2m_count,$sL3r2m_prze_id,      // 873__52
                          $sL3r1m_count,$sL3r1m_prze_id,      // 873___2
                          $sL2r4m_count,$sL2r4m_prze_id,      // 87_4252
                          $sL2r3m_count,$sL2r3m_prze_id,      // 87__252
                          $sL2r2m_count,$sL2r2m_prze_id,      // 87___52
                          $sL2r1m_count,$sL2r1m_prze_id,      // 87____2
                          0); 
                          //print "\nEncore Win Id Added: " . $str_on_encore_winning_id;
                         // print "\nSD Encore: " . $str_on_encore_winning_id;
                  }
              }
              if ($debug_mode > 1) {
                print "[" . $str_on_encore_winning_id . "]";
              } 
           } 
         }              
       }
  
  
  
}

?>