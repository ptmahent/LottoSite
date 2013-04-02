<?php
/*
 * 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.

*/

  include_once("../inc/cli_compatibility.php");
  include_once("../inc/class_db.php");
  include_once("../inc/incGenDates.php");
  include_once("../inc/incALCLottery.php");
  include_once("../inc/incNaLottery.php");
  include_once("../inc/incLottery.php");
  include_once("../inc/class_http.php");
  include_once("phpArguments.php");
        // Debug Mode
  // 0 = verbose disabled
  // 1 = verbose enabled
  // 2 = verbose extra info
  

  $debug_mode         = 2;
  

  
  $objLottery = new Lottery();
  
  $cmdargs = arguments();
  
  $naLottery = new NALottery();
  
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^update/i", $cmdargs["standard"][1], $lmatches)) {
  		$lottery_draw_data_dates = $naLottery->naMaxGetFirstLastDataAvail();
  		$startDay 	= date('d',strtotime($lottery_draw_data_dates["latest"]));
  		$startMonth = date('m',strtotime($lottery_draw_data_dates["latest"]));
  		$startYear 	= date('Y',strtotime($lottery_draw_data_dates["latest"]));
  		$endDay 	= date('d');
  		$endMonth 	= date('m');
  		$endYear    = date('Y');
  		$startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
		$endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);  		
  		$drawDates = $objLottery->dbLotteryGetDrawDates("naMAX", "MM", $startDate, $endDate); 
  		
  	} elseif (preg_match("/^getMonth/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  			$selectedMonth = $lmatches[1];
      	  	$selectedYear = $lmatches[2];
      	  	$startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      	    $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      	  	$drawDates = $objLottery->dbLotteryGetDrawDates("naMAX", "MM", $startDate, $endDate); 
  		}
  	} elseif (preg_match("/^getYear/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{4})|(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		      $selectedYear = $lsubmat[1];
      	  	  $startDate    = mktime(0,0,0,1,1,$selectedYear);
      	  	  $endDate      = mktime(0,0,0,12,31,$selectedYear);
      	  	  $drawDates = $objLottery->dbLotteryGetDrawDates("naMAX", "YY", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/^getDraw/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		    //print_r($lmatches); 
      	  	$selectedDay    = $lsubmat[1];
      	  	$selectedMonth  = $lsubmat[2];
      	  	$selectedYear   = $lsubmat[3];
      	  	$startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$drawDates = $objLottery->dbLotteryGetDrawDates("naMAX", "DD", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4}) - (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][1], $lmatches)) {
  		$startDay     = $lmatches[1];
      	$startMonth   = $lmatches[2];
      	$startYear    = $lmatches[3];
      	$endDay       = $lmatches[4];
      	$endMonth     = $lmatches[5];
      	$endYear      = $lmatches[6];
      	$startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
      	$endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);
      	$drawDates = $objLottery->dbLotteryGetDrawDates("naMAX", "DD1DD2", $startDate, $endDate);
  	}
  	
  	   	   //print_r($drawDates);
   	  if (is_array($drawDates)) {
     	  foreach ($drawDates as $dtDate) {
             // 20090211
             $drawDate = strtotime($dtDate);
             //print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
             //print_r($dtDate);
             //alc_fetch_single_draw(date('d-m-Y',$drawDate));
             alc_max_fetch_single_draw(date('d-m-Y',$drawDate));
          }
      } 
  	
  } else {
  
	  do {
		
		fwrite(STDOUT, "\tEnter one of the options Below: \n\n\n");
		fwrite(STDOUT, "\tgetYear [yyyy] : dddd should be year in 4 digits \n");          // 
		fwrite(STDOUT, "\tgetMonth [mm-yyyy] : mm-yyyy format of selected month\n");      //
		fwrite(STDOUT, "\tgetDraw [dd-mm-yyyy] : dd-mm-yyyy format of selected month\n\n");      //
		fwrite(STDOUT, "\t[dd-mm-yyyy] - [dd-mm-yyyy]");
		fwrite(STDOUT, "\n\t\n\t: ");
		
		
		do {
		  $selection = trim(fgets(STDIN));
		} while (trim($selection) == '');
		
		$drawDates = array();
		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4}) - (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		  $startDay     = $lmatches[1];
		  $startMonth   = $lmatches[2];
		  $startYear    = $lmatches[3];
		  $endDay       = $lmatches[4];
		  $endMonth     = $lmatches[5];
		  $endYear      = $lmatches[6];
		  $startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
		  $endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("naMAX", "DD1DD2", $startDate, $endDate);
		} elseif (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		   //print_r($lmatches); 
		  $selectedDay    = $lmatches[1];
		  $selectedMonth  = $lmatches[2];
		  $selectedYear   = $lmatches[3];
		  $startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("naMAX", "DD", $startDate, $endDate);
		} elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		  $selectedMonth = $lmatches[1];
		  $selectedYear = $lmatches[2];
		  $startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
		  $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
		  $drawDates = $objLottery->dbLotteryGetDrawDates("naMAX", "MM", $startDate, $endDate);    
		} elseif (preg_match("/getYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
		  $selectedYear = $lmatches[1];
		  $startDate    = mktime(0,0,0,1,1,$selectedYear);
		  $endDate      = mktime(0,0,0,12,31,$selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("naMAX", "YY", $startDate, $endDate);
		}
		  
		//print_r($drawDates);
		if (is_array($drawDates)) {
		  foreach ($drawDates as $dtDate) {
			  // 20090211
			$drawDate = strtotime($dtDate);
			//print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
			//print_r($dtDate);
			alc_max_fetch_single_draw(date('d-m-Y',$drawDate));
			
		  }
		}    
		
	  } while (trim($selection) != 'q');
  }
  function alc_max_fetch_single_draw($drawdate = "") {
    
    global $debug_mode;
    $drawdate = strtotime($drawdate);
    if ($drawdate == "") {
      $url1 = "http://corp.alc.ca/LottoMax.aspx?tab=2";
    } else {
      $selDate = date('Ymd', $drawdate);
      $url1 = "http://corp.alc.ca/LottoMax.aspx?tab=2&date=" . $selDate;
    } 
    
    //$url1 = "http://corp.alc.ca/LottoMax.aspx?tab=2";
    //$url1 = "http://corp.alc.ca/LottoMax.aspx?tab=2&date=20110101";
    
    $objLottery   = new Lottery();
    $objDate      = new GenDates();
    
    $naMax_row    = $objLottery->dbLotteryGamesGet("naMAX");
    //print_r($naMax_row);
    //print_r($url1);
    
    if (preg_match("/http:\/\/([^\/]*)(.*)\/(.*?)\?(.*)/i", $url1, $lmatches) ) {
     
     
          $site_domain    = trim($lmatches[1]);
          $site_domain_id = $objLottery->dbWebUrlsGetId($site_domain, "DOMAIN");
          if (!$site_domain_id) {
            $site_domain_id = $objLottery->dbWebUrlsAdd($site_domain, "DOMAIN");
          }
          $site_path      = trim($lmatches[2]);
          if (trim($site_path) != "") {
            $site_path_id   = $objLottery->dbWebUrlsGetId($site_path, "SITEPATH");
            if (!$site_path_id) {
              $site_path_id   = $objLottery->dbWebUrlsAdd($site_path, "SITEPATH");
            }
            
          } else {
            $site_path_id = 0;
          }
          $site_file      = trim($lmatches[3]);
          $site_file_id   = $objLottery->dbWebUrlsGetId($site_file, "SITEFILE");
          if (!$site_file_id) {
            $site_file_id   = $objLottery->dbWebUrlsAdd($site_file, "SITEFILE");
          }
          $site_querystr  = trim($lmatches[4]);
          $site_querystr_id = $objLottery->dbWebUrlsGetId($site_querystr, "QUERYSTR");
          
          if (!$site_querystr_id) {
            $site_querystr_id = $objLottery->dbWebUrlsAdd($site_querystr, "QUERYSTR");
          }
          /*print_r($lmatches);
          print "\nSiteDomain: " . $site_domain_id;
          print "\nSitePath  : " . $site_path_id;
          print "\nSiteFile  : " . $site_file_id;
          print "\nSiteQuery : " . $site_querystr_id;
          */
                 
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("naMAX", $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($naMax_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("naMAX", $naMax_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("naMAX", $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id);
            //print_r($fetch_data_stats_row);
            if (is_array($fetch_data_stats_row)) {
              $fetch_cnt = $fetch_data_stats_row["fetch_count"];
              $fetch_cnt++;
              $objLottery->dbFetchDataStatsCntAdd($fetch_stats_id, $fetch_cnt);
              $fetch_date = date('Y-m-d H:i:s');
              $fetch_process_suc = 0;
              $max_pos = $objLottery->dbFetchDetailGetMaxPos($fetch_stats_id);
              $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $max_pos + 1, $fetch_process_suc);
            } 
          } 

          //print "\nSD: " . $site_domain_id . " SPD: " . $site_path_id . " SFD: " . $site_file_id . " SQD "  . $site_querystr_id . "\n";     
    }
    
    $http = new http();
    
    $http->headers['Referer'] = $url1;
    if (!$http->fetch($url1)) {
      $status_msg = "... ";
      
    }
    
    
    $ary_headers = split("\n", $http->header);
    $jsessionid = "";
    foreach($ary_headers as $hdr) {
        if (eregi("^Set-Cookie\:", $hdr)) {
            $hdr = str_replace("Set-Cookie: ", "", $hdr);
            
            $ary_cookies = split(";", $hdr);
            foreach ($ary_cookies as $ckie) {
              if (preg_match("/JSESSIONID=/i",$ckie, $lmatches)) {
                $jsessionid = $ckie;
              }
            }
            $http->headers['Cookie'] = $jsessionid; 
            break;
        }
    }
    
    
    if (!$http->fetch($url1)) {
        $status_msg = "... ";
    
    }
    
    
    $html_body = preg_replace("/\s|\t|\n|\r\n/"," ",$http->body);
    
    $srgE_CA = "<!-- content area -->";
    
    $srgE_FN = "<!-- floating nav -->";
    
    $srgB_table = "<table[^>]*>";
    $srgE_table = "<\/table>";
    $srgB_tr    = "<tr>";
    $srgE_tr    = "<\/tr>";
    $srgB_td    = "<td[^>]*>";
    $srgE_td    = "<\/td>";
    $srgB_th    = "<th[^>]*>";
    $srgE_th    = "<\/th>";
    
    
    
    if (preg_match("/" . $srgE_CA . "(.*)" . $srgE_FN . "/i", $html_body, $lmatches)) {
      $html_body = $lmatches[1];
    }
    
    //$html_body = preg_replace("/<(table[^>]*)>/i","\n<$1>",$html_body);
    //$html_body = preg_replace("/<(tr)>/i","\n<$1>", $html_body);
    
    $html_tr_list = preg_split("/<tr>/i", $html_body);
    
    $srgMax_num = "images\/en\/bkgWNL_LottoMax.gif.*For the draw of ([^ ]*)\s*(\d*),\s*(\d*):.*class=.lotteryWN.>(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2}).*Bonus:\s*(\d{2})";
    
    $sPrze_Max_Hdr = "Prize Payout of LOTTO MAX";
    $sPrze_Twist_Hdr = "Prize Payout of Twist";
    $sPrze_Tag_Hdr = "Prize Payout of TAG";
    $sPrze_MaxMills_Hdr = "Prize Payout of MAXMILLIONS";
    
    $bMax_Prze_m      = 0;
    $bTwist_Prze_m    = 0;
    $bTag_Prze_m      = 0;
    $bMaxMills_Prze_m = 0;
    
    $swinloc = "(\d*)\s*-\s*(.*)";
    $s7of7  = "(7 of 7)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
    $s6of7B = "(6 of 7 . Bonus)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
    $s6of7  = "(6 of 7)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
    $s5of7  = "(5 of 7)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
    $s4of7  = "(4 of 7)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
    $s3of7B = "(3 of 7 . Bonus)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
    $s3of7  = "(3 of 7)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
    $str_money_sym = array("$",","); 
    $str_clean_sym = array("  ",",","-");
    
    $sMaxMills  = ">(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2})" . $srgE_td . $srgB_td . $srgB_td . "(\d*)";
    $sMaxMills .=  $srgE_td . $srgB_td . $srgB_td . "(.*)" .  $srgE_td . $srgB_td . $srgB_td ."(.*)" . $srgE_td . $srgE_tr;
   
    $naLottery = new NALottery();
    
    if ($debug_mode > 1) {
      print "\nFetch " . $site_file . $site_querystr;
      print "\nDate: " . date('Y-m-d', $drawdate);
    }    
    
    
    foreach ($html_tr_list as $html_tr) {
      if ($bMax_Prze_m == 1 &&
        (preg_match("/" . $s7of7 . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          if (trim($lmatches[2]) != 0) {
            $html_locs = preg_split("/\s*<br \/>/i", $lmatches[2]);
            $s7of7_total_win_amount = 0;
            $s7of7_total_win_count  = 0;
            $s7of7_win_loc_detail   = array();
          
            foreach ($html_locs as $html_loc) {
              if (preg_match("/" . $swinloc . "/i", $html_loc, $loc_matches)) {
                //print_r($loc_matches);
                //print "*";
                $str_location = trim(str_replace($str_clean_sym, " ", $loc_matches[2]));
                $s7of7_win_loc_id   = $objLottery->dbLotWinLocationGetId($str_location, $objLottery->loc_prov);
                if (!$s7of7_win_loc_id) {
                  $s7of7_win_loc_id = $objLottery->dbLotWinLocationAdd("", $str_location, "", "", $objLottery->loc_prov);
                }
                $s7of7_win_loc_detail[$s7of7_win_loc_id]["count"] = trim($loc_matches[1]);
                $s7of7_total_win_count += trim($loc_matches[1]);
              }
            }      
            
            $s7of7_prze_amt   = str_replace($str_money_sym, "", trim($lmatches[3]));
            $s7of7_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s7of7_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
            if (!$s7of7_win_prz_id) {
              $s7of7_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s7of7_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
            }
            
            $s7of7_total_win_amount = $s7of7_total_win_count * $s7of7_prze_amt;
            $s7of7_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s7of7_total_win_amount, $objLottery->prz_money, $naMax_row["gameid"]);
            
            if (!$s7of7_total_win_prz_id) {
              $s7of7_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s7of7_total_win_amount, $objLottery->prz_money, number_format($s7of7_total_win_amount, 2), $naMax_row["gameid"]);
            }
            

          } else {
            //echo "<br />zero wins<br />";
            $s7of7_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $s7of7_total_win_amount = $s7of7_prze_amt;
            $s7of7_total_win_count  = 0;
            
            $s7of7_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s7of7_total_win_amount, $objLottery->prz_money, $naMax_row["gameid"]);
            if (!$s7of7_total_win_prz_id) {
              $s7of7_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s7of7_total_win_amount, $objLottery->prz_money, number_format($s7of7_total_win_amount, 2), $naMax_row["gameid"]);
            }            
          }
            if ($debug_mode > 1) {
              print "[m7of7|" . $s7of7_total_win_amount . "|" . $s7of7_total_win_prz_id . "|" . $s7of7_total_win_count . "|" . $s7of7_prze_amt . "]";
            }
        } elseif ($bMax_Prze_m == 1 &&
        (preg_match("/" . $s6of7B . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          //print "*6+";
          if (trim($lmatches[2]) != 0) {
            $html_locs = preg_split("/\s*<br \/>/i", $lmatches[2]);
            
            $s6of7B_total_win_amount = 0;
            $s6of7B_total_win_count  = 0;
            $s6of7B_win_loc_detail   = array();
            foreach ($html_locs as $html_loc) {
              if (preg_match("/" . $swinloc . "/i", $html_loc, $loc_matches)) {
                //print_r($lmatches);
                //print "*";
                $str_location = trim(str_replace($str_clean_sym," ",$loc_matches[2]));
                $s6of7B_win_loc_id = $objLottery->dbLotWinLocationGetId($str_location, $objLottery->loc_prov);
                if (!$s6of7B_win_loc_id) {
                  $s6of7B_win_loc_id = $objLottery->dbLotWinLocationAdd("", $str_location, "", "", $objLottery->loc_prov);
                }
                $s6of7B_win_loc_detail[$s6of7B_win_loc_id]["count"] = trim($loc_matches[1]);
                $s6of7B_total_win_count += trim($loc_matches[1]);                 
              }
            }
            
            $s6of7B_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            
            $s6of7B_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s6of7B_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
            if (!$s6of7B_win_prz_id) {
              $s6of7B_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s6of7B_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
            }
            
            $s6of7B_total_win_amount = $s6of7B_total_win_count * $s6of7B_prze_amt;  
            $s6of7B_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s6of7B_total_win_amount, $objLottery->prz_money, $naMax_row["gameid"]);
            //print "\nPrize : " . $s6of7B_total_win_amount;

            if (!$s6of7B_total_win_prz_id) {
              $s6of7B_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s6of7B_total_win_amount, $objLottery->prz_money, number_format($s6of7B_total_win_amount,2), $naMax_row["gameid"]);
            }  
          
          } else {
            //echo "<br />zero wins<br />";
            
            $s6of7B_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $s6of7B_total_win_count = 0;
            $s6of7B_total_win_amount = $s6of7B_prze_amt;
            
            //print "\nPrize : " . $s6of7B_total_win_amount;
            $s6of7B_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s6of7B_total_win_amount, $objLottery->prz_money, $naMax_row["gameid"]);
            if (!$s6of7B_total_win_prz_id) {
              $s6of7B_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s6of7B_total_win_amount, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
            }                 
          }
        
           if ($debug_mode > 1) {
            print "[m6of7B|" . $s6of7B_total_win_amount . "|" . $s6of7B_total_win_prz_id . "|" . $s6of7B_total_win_count . "|" . $s6of7B_prze_amt . "]";
          }    
        } elseif ($bMax_Prze_m == 1 &&
        (preg_match("/" . $s6of7 . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          //print "*6";
          $s6of7_win_cnt  = preg_replace("/,/i","",trim($lmatches[2]));
          $s6of7_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
            
          $s6of7_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s6of7_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
          if (!$s6of7_win_prz_id) {
            $s6of7_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s6of7_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
          }
          if ($debug_mode > 1) {
            print "[" . $s6of7_prze_amt . "|" . $s6of7_win_prz_id . "|" . $s6of7_win_cnt . "]";
          }
        } elseif ($bMax_Prze_m == 1 &&
        (preg_match("/" . $s5of7 . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          //print "*5";
          $s5of7_win_cnt  = preg_replace("/,/i","",trim($lmatches[2]));
          $s5of7_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
            
          $s5of7_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s5of7_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
          if (!$s5of7_win_prz_id) {
            $s5of7_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s5of7_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
          }
            
          if ($debug_mode > 1) {
            print "[" . $s5of7_prze_amt . "|" . $s5of7_win_prz_id . "|" . $s5of7_win_cnt . "]";
          }
        } elseif ($bMax_Prze_m == 1 &&
        (preg_match("/" . $s4of7 . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          //print "*4";
          $s4of7_win_cnt  = preg_replace("/,/i","",trim($lmatches[2]));
          $s4of7_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
            
          $s4of7_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s4of7_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
          if (!$s4of7_win_prz_id) {
            $s4of7_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s4of7_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
          }
            
          if ($debug_mode > 1) {
            print "[" . $s4of7_prze_amt . "|" . $s4of7_win_prz_id . "|" . $s4of7_win_cnt . "]";
          }
        } elseif ($bMax_Prze_m == 1 &&
        (preg_match("/" . $s3of7B . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          //print "*3+";
          $s3of7B_win_cnt  = preg_replace("/,/i","",trim($lmatches[2]));
          $s3of7B_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
            
          $s3of7B_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s3of7B_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
          if (!$s3of7B_win_prz_id) {
            $s3of7B_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s3of7B_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
          }
          
          if ($debug_mode > 1) {
            print "[" . $s3of7B_prze_amt . "|" . $s3of7B_win_prz_id . "|" . $s3of7B_win_cnt . "]";
          }
        } elseif ($bMax_Prze_m == 1 &&
        (preg_match("/" . $s3of7 . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          //print "*3";
          $s3of7_win_cnt  = preg_replace("/,/i","",trim($lmatches[2]));
          //$s3of7_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
          
         if (preg_match("/(\d+)/i",trim($lmatches[3]),$lprz_matches)) {
            $s3of7_prze_amt = $lprz_matches[1]; 
            //print_r($lprz_matches);
          }
            
          $s3of7_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s3of7_prze_amt, $objLottery->prz_other, $naMax_row["gameid"]);
          if (!$s3of7_win_prz_id) {
            $s3of7_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s3of7_prze_amt, $objLottery->prz_other, trim($lmatches[3]), $naMax_row["gameid"]);
          } 
          if ($debug_mode > 1) {
            print "[" . $s3of7_prze_amt . "|" . $s3of7_win_prz_id . "|" . $s3of7_win_cnt . "]";
          }
          $naMaxWinningId = $naLottery->naMaxWinningsGetId($naMaxId);
          if (!$naMaxWinningId) {
              $naMaxWinningId = $naLottery->naMaxWinningsAdd($naMaxId, $s7of7_total_win_count, $s7of7_total_win_prz_id, 
                                                                   $s6of7B_total_win_count, $s6of7B_total_win_prz_id,
                                                                   $s6of7_win_cnt, $s6of7_win_prz_id,
                                                                   $s5of7_win_cnt, $s5of7_win_prz_id,
                                                                   $s4of7_win_cnt, $s4of7_win_prz_id,
                                                                   $s3of7B_win_cnt, $s3of7B_win_prz_id,
                                                                   $s3of7_win_cnt, $s3of7_win_prz_id, 0);
             ///print "\nSD - New Record - " . $naMaxWinningId;
          }
          
          if ($debug_mode > 1) {
            print "[MID|" . $naMaxId . "|" . $naMaxWinningId . "]";
          }
          //printf("\n7of7 : %u, 6of7B : %u, 5of7 : %u, 4of7 : %u, ");
          if ($naMaxWinningId != "") {
            if (is_array($s7of7_win_loc_detail)) {
              foreach ($s7of7_win_loc_detail as $win_loc_id => $win_loc) {
                  if (!$naLottery->dbNaMaxWinLocGetId($naMaxWinningId, $win_loc_id, 7)) {
                    $naLottery->dbNaMaxWinLocAdd($naMaxWinningId, $s7of7_win_prz_id, $win_loc["count"], $win_loc_id, 7);
                    //print "_";
                  }
                }
            }
            if (is_array($s6of7B_win_loc_detail)) {
               foreach ($s6of7B_win_loc_detail as $win_loc_id => $win_loc) {
                  if (!$naLottery->dbNaMaxWinLocGetId($naMaxWinningId, $win_loc_id, 6)) {                 
                    $naLottery->dbNaMaxWinLocAdd($naMaxWinningId, $s6of7B_win_prz_id, $win_loc["count"], $win_loc_id, 6);
                    //print "_";
                  } 
               }
            }
          }
          
          
        } elseif (preg_match("/" . $srgMax_num . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
          
          
            $sdrawMonthName = $lmatches[1];
            $sdrawMonthNum  = $objDate->getMonthNum($sdrawMonthName);
            $sdrawDay       = $lmatches[2];
            $sdrawYear      = $lmatches[3];
            $sMax_Ddate     = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
            
            if ($debug_mode > 1) {
              print "\n[" . $sMax_Ddate . "]";
            }
            //print "\nDrawDate: " . $sMax_Ddate;
            //print_r($lmatches);
            $snum1 = $lmatches[4];
            $snum2 = $lmatches[5];
            $snum3 = $lmatches[6];
            $snum4 = $lmatches[7];
            $snum5 = $lmatches[8];
            $snum6 = $lmatches[9];
            $snum7 = $lmatches[10];
            $snumbonus = $lmatches[11];
            if ($debug_mode > 1) {
              print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6 . "|" . $snum7 . "|B:" . $snumbonus . "]";
            }
            $snumPos  = 0;
            $naMaxId = $naLottery->naMaxGetDrawId($sMax_Ddate, $snumPos);
            
            
            print "*";
          if (!$naMaxId) {
            $naMaxId = $naLottery->naMaxAdd($sMax_Ddate, "", $snumPos, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus, "", "", "", "");
            print "[_]";
            //print "\nSD - New Record: " . $naMaxId;
          }
          if ($debug_mode > 1) {
              print "[" . $naMaxId . "]";
            }
          //print "\nDraw Detail Id: " . $naMaxId;
          //printf ("\nSN: %u - %u - %u - %u - %u - %u - %u - %u", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus);
                   
        } elseif ($bMaxMills_Prze_m == 1 &&
          (preg_match("/" . $sMaxMills . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          
          $snumPos = $snumPos + 1;
          $snum1 = $lmatches[1];
          $snum2 = $lmatches[2];
          $snum3 = $lmatches[3];
          $snum4 = $lmatches[4];
          $snum5 = $lmatches[5];
          $snum6 = $lmatches[6];
          $snum7 = $lmatches[7];
          $snumbonus = 0;
          if ($debug_mode > 1) {
            print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6 . "|" . $snum7 . "|B:" . $snumbonus . "]";
          }
          
          $naMaxMillId = $naLottery->naMaxGetDrawId($sMax_Ddate, $snumPos);
          if (!$naMaxMillId) {
            $naMaxMillId = $naLottery->naMaxAdd($sMax_Ddate, "", $snumPos, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus, "", "", "", "");
          }
            if ($debug_mode > 1) {
              print "[" . $naMaxId . "]";
            }
          //print "\nDraw Detail Id: " . $naMaxMillId;
          //printf ("\nSN: %u - %u - %u - %u - %u - %u - %u - %u", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumbonus);
                   
          
          if (trim($lmatches[8]) != 0) {
            $html_locs = preg_split("/\s*<br \/>/i", $lmatches[9]);
            $sMaxMill_total_win_amount = 0;
            $sMaxMill_total_win_count  = 0;
            $sMaxMill_win_loc_detail   = array();
            
            
            foreach ($html_locs as $html_loc) {
              if (preg_match("/" . $swinloc . "/i", $html_loc, $loc_matches)) {
                //print_r($lmatches);
                
                $sMaxMill_win_loc_id = $objLottery->dbLotWinLocationGetId(trim($loc_matches[2]), $objLottery->loc_prov);
                if (!$sMaxMill_win_loc_id) {
                  $sMaxMill_win_loc_id = $objLottery->dbLotWinLocationAdd("", trim($loc_matches[2]), "", "", $objLottery->loc_prov);
                }
                $sMaxMill_win_loc_detail[$sMaxMill_win_loc_id]["count"] = trim($loc_matches[1]);
                $sMaxMill_total_win_count += trim($loc_matches[1]); 
                
              }
            }
            
            $sMaxMill_prze_amt = str_replace($str_money_sym, "", trim($lmatches[10]));
            
            $sMaxMill_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($sMaxMill_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
            if (!$sMaxMill_win_prz_id) {
              $sMaxMill_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($sMaxMill_prze_amt, $objLottery->prz_money, trim($lmatches[10]), $naMax_row["gameid"]);
            }
            
            $sMaxMill_total_win_amount = $sMaxMill_total_win_count * $sMaxMill_prze_amt;  
            $sMaxMill_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($sMaxMill_total_win_amount, $objLottery->prz_money, $naMax_row["gameid"]);
            //print "\nPrize : " . $sMaxMill_total_win_amount;
            
            if (!$sMaxMill_total_win_prz_id) {
              $sMaxMill_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($sMaxMill_total_win_amount, $objLottery->prz_money, number_format($sMaxMill_total_win_amount,2), $naMax_row["gameid"]);
            }             
            
            $sMaxMillWinningId = $naLottery->naMaxWinningsGetId($naMaxMillId);
            if (!$sMaxMillWinningId) {
              
              $sMaxMillWinningId = $naLottery->naMaxWinningsAdd($naMaxMillId, $sMaxMill_total_win_count, 
                                                                $sMaxMill_total_win_prz_id, 0, 0,0,0,0,
                                                                0,0,0,0,0,0,0,0);
              print "\nSD-New Record: " . $sMaxMillWinningId;
            }
            if ($sMaxMillWinningId != "") {
              if (is_array($sMaxMill_win_loc_detail)) {
                foreach ($sMaxMill_win_loc_detail as $win_loc_id => $win_loc) {
                  if (!$naLottery->dbNaMaxWinLocGetId($sMaxMillWinningId, $win_loc_id, 7)) {
                    $naLottery->dbNaMaxWinLocAdd($sMaxMillWinningId, $sMaxMill_win_prz_id, $win_loc["count"], $win_loc_id, 7);
                  }
                }
              }
            }  
            //printf ("\nMaxMillWinId: %u", $sMaxMillWinningId);          
          } else {
            //echo "<br />zero wins<br />";
            
            $sMaxMill_prze_amt = str_replace($str_money_sym, "", trim($lmatches[10]));
            $sMaxMill_total_win_count = 0;
            $sMaxMill_total_win_amount = $sMaxMill_prze_amt;
            
            //print "\nPrize : " . $sMaxMill_total_win_amount;
            $sMaxMill_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($sMaxMill_total_win_amount, $objLottery->prz_money, $naMax_row["gameid"]);
            if (!$sMaxMill_total_win_prz_id) {
              $sMaxMill_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($sMaxMill_total_win_amount, $objLottery->prz_money, trim($lmatches[10]), $naMax_row["gameid"]);
            }    
            
            $sMaxMillWinningId = $naLottery->naMaxWinningsGetId($naMaxMillId);
            if (!$sMaxMillWinningId) {
              $sMaxMillWinningId = $naLottery->naMaxWinningsAdd($naMaxMillId, 0, $sMaxMill_total_win_prz_id, 0, 0,0,0,0,
                                                                0,0,0,0,0,0,0,0);
              print "\nSD-New Record: " . $sMaxMillWinningId;
            }             
          }

          if ($debug_mode > 1) {
            print "[" . $sMaxMill_total_win_amount . "|" . $sMaxMill_total_win_prz_id . "|" . $sMaxMillWinningId . "|" . $sMaxMill_total_win_count . "|" . $sMaxMill_prze_amt . "]";
          } 
            
        }elseif (preg_match("/" . $sPrze_Max_Hdr . "/i", $html_tr, $lmatches)) {
          //$sMax_date = $lmatches[1] . " " . $lmatches[2] . ", "  . $lmatches[3];
          $bMax_Prze_m    = 1;
          $bTwist_Prze_m  = 0;
          $bTag_Prze_m    = 0;
          $bMaxMills_Prze_m = 0;
    
          //print_r($lmatches);
        } elseif (preg_match("/" . $sPrze_Twist_Hdr . "/i", $html_tr, $lmatches)) {
          $bMax_Prze_m    = 0;
          $bTwist_Prze_m  = 1;
          $bTag_Prze_m    = 0;
          $bMaxMills_Prze_m = 0;
          
          //print_r($lmatches);
        } elseif (preg_match("/" . $sPrze_MaxMills_Hdr . "/i", $html_tr, $lmatches)) {
          $bMax_Prze_m      = 0;
          $bTwist_Prze_m    = 0;
          $bTag_Prze_m      = 0;
          $bMaxMills_Prze_m = 1;
           
        }elseif (preg_match("/" . $sPrze_Tag_Hdr . "/i", $html_tr, $lmatches)) {
          $bMax_Prze_m    = 0;
          $bTwist_Prze_m  = 0;
          $bTag_Prze_m    = 1;
          $bMaxMills_Prze_m = 0;
          
          //print_r($lmatches);
        }
      
    }
        
  }

?>