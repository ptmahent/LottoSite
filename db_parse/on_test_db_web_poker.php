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
  include_once("../inc/incOLGLottery.php");
  include_once("../inc/class_http.php");

  
  include_once("../inc/incOLGData.php");
  include_once("phpArguments.php");
  // Debug Mode
  // 0 = verbose disabled
  // 1 = verbose enabled
  // 2 = verbose extra info
  
  
  $debug_mode         = 2;
  
  $objLottery 	= new Lottery();
  $objOLG     	= new OLGLottery();
  $cmdargs 		= arguments();
  
  
  
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^update/i", $cmdargs["standard"][1], $lmatches)) {
  		$lottery_draw_data_dates = $objOLG->OLGPokerGetFirstLastDataAvail();
  		$startDay 	= date('d',strtotime($lottery_draw_data_dates["latest"]));
  		$startMonth = date('m',strtotime($lottery_draw_data_dates["latest"]));
  		$startYear 	= date('Y',strtotime($lottery_draw_data_dates["latest"]));
  		$endDay 	= date('d');
  		$endMonth 	= date('m');
  		$endYear    = date('Y');
  		$startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
		$endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);  		
  		$drawDates 	= $objLottery->dbLotteryGetDrawDates("onPoker", "MM", $startDate, $endDate); 
  		
  	} elseif (preg_match("/^getMonth/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  			$selectedMonth 	= $lmatches[1];
      	  	$selectedYear 	= $lmatches[2];
      	  	$startDate    	= mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      	    $endDate      	= mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      	  	$drawDates 		= $objLottery->dbLotteryGetDrawDates("onPoker", "MM", $startDate, $endDate); 
  		}
  	} elseif (preg_match("/^getYear/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{4})|(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		      $selectedYear = $lsubmat[1];
      	  	  $startDate    = mktime(0,0,0,1,1,$selectedYear);
      	  	  $endDate      = mktime(0,0,0,12,31,$selectedYear);
      	  	  $drawDates 	= $objLottery->dbLotteryGetDrawDates("onPoker", "YY", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/^getDraw/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		    //print_r($lmatches); 
      	  	$selectedDay    = $lsubmat[1];
      	  	$selectedMonth  = $lsubmat[2];
      	  	$selectedYear   = $lsubmat[3];
      	  	$startDate 		= mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$endDate   		= mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$drawDates 		= $objLottery->dbLotteryGetDrawDates("onPoker", "DD", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4}) - (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][1], $lmatches)) {
  		$startDay     		= $lmatches[1];
      	$startMonth   		= $lmatches[2];
      	$startYear    		= $lmatches[3];
      	$endDay       		= $lmatches[4];
      	$endMonth     		= $lmatches[5];
      	$endYear      		= $lmatches[6];
      	$startDate 			= mktime(0,0,0,$startMonth, $startDay , $startYear);
      	$endDate   			= mktime(0,0,0,$endMonth, $endDay, $endYear);
      	$drawDates 			= $objLottery->dbLotteryGetDrawDates("onPoker", "DD1DD2", $startDate, $endDate);
  	}

		//print_r($drawDates);
	if (is_array($drawDates)) {
	  foreach ($drawDates as $dtDate) {
		  // 20090211
		$drawDate = strtotime($dtDate);
		print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
		//print_r($dtDate);
		//alc_fetch_single_draw(date('d-m-Y',$drawDate));
		//on_fetch_first_step_649(date('d-m-Y', $drawDate));
		//on_fetch_first_step_max(date('d-m-Y', $drawDate));
		on_fetch_first_step_poker(date('d-m-Y', $drawDate));
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
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onPoker", "DD1DD2", $startDate, $endDate);
		} elseif (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		   //print_r($lmatches); 
		  $selectedDay    = $lmatches[1];
		  $selectedMonth  = $lmatches[2];
		  $selectedYear   = $lmatches[3];
		  $startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onPoker", "DD", $startDate, $endDate);
		} elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		  $selectedMonth = $lmatches[1];
		  $selectedYear = $lmatches[2];
		  $startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
		  $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onPoker", "MM", $startDate, $endDate);    
		} elseif (preg_match("/getYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
		  $selectedYear = $lmatches[1];
		  $startDate    = mktime(0,0,0,1,1,$selectedYear);
		  $endDate      = mktime(0,0,0,12,31,$selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onPoker", "YY", $startDate, $endDate);
		}
	
		//print_r($drawDates);
		if (is_array($drawDates)) {
		  foreach ($drawDates as $dtDate) {
			  // 20090211
			$drawDate = strtotime($dtDate);
			print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
			//print_r($dtDate);
			//alc_fetch_single_draw(date('d-m-Y',$drawDate));
			//on_fetch_first_step_649(date('d-m-Y', $drawDate));
			//on_fetch_first_step_max(date('d-m-Y', $drawDate));
			on_fetch_first_step_poker(date('d-m-Y', $drawDate));
		  }
		}    
		
	  } while (trim($selection) != 'q');
	  
  }
  
  function on_fetch_first_step_poker($drawdate = "") {
    
      global $debug_mode;
      
      $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
      
      
      $objLottery   = new Lottery();
      $objDate      = new GenDates();
      $objOLG       = new OLGLottery();
      $naLottery    = new NALottery();
      
      //print "\n\n" . $drawdate . " --- ";
      $drawdate = strtotime($drawdate);
      //print date('mY', $drawdate);
      
      if ($drawdate == "") {
        $hp_selectedMonthYear     = date('mY', mktime(0,0,0,date('m') - 1, date('d'), date('Y')));
        
      } else {
        $hp_selectedMonthYear     = date('mY', mktime(0,0,0, date('m', $drawdate) - 1, date('d', $drawdate), date('Y', $drawdate)));
      }
      
      $onPokerGameId    = 69;
      
      
      $hp_day                  = 0;
      $hp_gameID               = $onPokerGameId;
      $hp_command              = 'submit';      
      
      
      if (!$http = new http()) {
        $status_msg = "...";
      }
      
      $http->headers['Referer'] = $url_step2;
      if (!$http->fetch($url_step2)) {
        $status_msg = "...";
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
      
       $onPoker_row             = $objLottery->dbLotteryGamesGet("onPoker");
    
    
      if (preg_match("/http:\/\/([^\/]*)(.*)\/(.*?)/i", $url_step2, $lmatches) ) {
          
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
        
          $site_post_str = sprintf("selectedMonthYear=%s&day=%u&gameID=%u&command=submit", $hp_selectedMonthYear, $hp_day, $hp_gameID);

          $site_post_id = $objLottery->dbWebUrlsGetId($site_post_str, "POSTSTR");
          if (!$site_post_id) {
            $site_post_id = $objLottery->dbWebUrlsAdd($site_post_str, "POSTSTR");
          }          
          /*
          print_r($lmatches);
          print "\nSiteDomain: " . $site_domain_id;
          print "\nSitePath  : " . $site_path_id;
          print "\nSiteFile  : " . $site_file_id;
          print "\nSitePost : " . $site_post_id;
          print "\n" . $site_post_str;
          */       
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onPoker", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onPick4", $onPoker_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onPoker", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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

          //print "\nSD: " . $site_domain_id . " SPD: " . $site_path_id . " SFD: " . $site_file_id . " SQD "  . $site_post_id . "\n";
        }
    
      
      
      $onPokerGameId    = 69;
      
      $http->postvars['selectedMonthYear']    = $hp_selectedMonthYear;
      $http->postvars['day']                  = $hp_day;
      $http->postvars['gameID']               = $hp_gameID;
      $http->postvars['command']              = $hp_command;
      if (!$http->fetch($url_step2)) {
        $status_msg = "...";
      }
      
      
      
      $html_body = preg_replace("/\s|\t|\n|\r\n/i"," ",$http->body);
      $srgB_table   = "<table[^>]*>";
      $srgE_table   = "<\/table>";
      $srgB_tr      = "<tr[^>]*>";
      $srgE_tr      = "<\/tr>";
      $srgB_th      = "<th[^>]*>";
      $srgE_th      = "<\/th>";
      $srgB_td = "<td[^>]*>";
      $srgE_td = "<\/td>";
      $srgB_p = "<p[^>]*>";
      $srgE_p = "<\/p>";
      $srgB_strong = "<strong>";
      $srgE_strong = "<\/strong>";
      $srgB_form = "<form [^>]*>";
      $srgE_form = "<\/form>";
      $srgB_br   = "<br[^]*>";
      $srg_comment = "<!--.*-->";
      $srg_input = "<input .*?name=\"(.*)\"\s*value=\"(.*?)\"\s*>";
      $srg_gameid = "<input .*?name=\"gameID\" \s*value=\"(\d+)\"\s*>\s*";
      $srg_drawNo = "<input .*?name=\"drawNo\" \s*value=.(\d+)\"\s*>\s*";
      $srg_drawDate = "<input .*?name=\"sdrawDate\" \s*value=\"(\d+)\"\s*>\s*";
      $srg_spielId = "<input .*?name=\"spielID\" \s*value=\"(\d+)\">\s*";   
      $srg_form_act = "<form.*?action=\"(.*)\"[^>]*>";
      
      
      $html_tr_list = preg_split("/" . $srgB_tr . "/i", $html_body);
      
      
      
      $bOnPoker_m     = 0;
      
      
      $sPokerCards = array("two" => 2,
                               "three" => 3,
                               "four" => 4,
                               "five" => 5,
                               "six" => 6,
                               "seven" => 7,
                               "eight" => 8,
                               "nine" => 9,
                               "ten" => 10,
                               "jack" => "J",
                               "queen" => "Q",
                               "king" => "K",
                               "ace" => "A");
                               
      $sPokerClass = array("clubs" => "C",
                              "spades" => "S",
                              "diamonds" => "D",
                              "hearts" => "H");
      $srg_onPkrSingleCrd = "<img .*?alt=\"(.*?) of (.*?)\"[^>]*>";
      $srg_onPoker = "\s*" . $srg_onPkrSingleCrd . "\s*" . $srg_onPkrSingleCrd . "\s*" . $srg_onPkrSingleCrd . "\s*";
      $srg_onPoker .= $srg_onPkrSingleCrd . "\s*" . $srg_onPkrSingleCrd . "\s*";
      
      
      
      $srg_onlottario   = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
      $srg_onearlybird  = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
      $srg_onEncore     = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
      $srg_bonusnum     = "\s*(\d{2})\s*";
        
      $sPkr_th_Line     = $srgB_th . "(.*?)" . $srgE_th;        // Date
      $sPkr_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Day
      $sPkr_th_Line     .= "\s*" . $srgB_th . "(.*?)" ;                 // Cards
      $sPkr_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // WINNINGS
      
      $sPkr_td_Line     = $srgB_td . "(.*?)"  . $srgE_td;        // Date
      $sPkr_td_Line     .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day
      $sPkr_td_Line     .= "\s*" . $srgB_td .   "(.*?)";                  // Cards
      $sPkr_td_Line     .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings
      
      $str_money_sym = array("$",","); 
      
      $srgDays          = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
      $srgMonths        = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";

    
     if ($debug_mode > 0) {
        print "\nFetch " . $site_file . $site_querystr;
        print "\nDate: " . date('Y-m-d', $drawdate);
      }    
    
      foreach($html_tr_list as $html_tr) {
        
        if (preg_match("/" . $sPkr_th_Line . "/i", $html_tr, $lmatches)) {
          $bOnPoker_m   = 1;
           //print_r($lmatches);
        } elseif ($bOnPoker_m == 1 &&
                (preg_match("/" . $sPkr_td_Line . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
              //print_r($lotResMat);
              
              $sdrawMonthName       = trim($lotResMat[2]);
              $sdrawMonthNum        = $objDate->getShortMonthNum($sdrawMonthName);
              $sdrawDay             = $lotResMat[1];
              $sdrawYear            = $lotResMat[3];
              $sPoker_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
              //print "\nPick 4 DrawDate: " . $sPoker_drawdate;      
              
              if ($debug_mode > 1) {
                print "\n[" . $sPoker_drawdate . "]";
              }
              
            }
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\w{3})\s*" . $srgE_strong. $srgE_p . "/i",$lmatches[2], $lotResMat)) {
              //print_r($lotResMat);
            }
        
           // print_r($html_br_list);      
      
            if (preg_match("/" . $srg_onPoker . "/i", $lmatches[3], $lotResMat)) {
              //print_r($lotResMat);
              $scard1 = $sPokerCards[strtolower(trim($lotResMat[1]))] . $sPokerClass[strtolower(trim($lotResMat[2]))];
              $scard2 = $sPokerCards[strtolower(trim($lotResMat[3]))] . $sPokerClass[strtolower(trim($lotResMat[4]))];
              $scard3 = $sPokerCards[strtolower(trim($lotResMat[5]))] . $sPokerClass[strtolower(trim($lotResMat[6]))];
              $scard4 = $sPokerCards[strtolower(trim($lotResMat[7]))] . $sPokerClass[strtolower(trim($lotResMat[8]))];
              $scard5 = $sPokerCards[strtolower(trim($lotResMat[9]))] . $sPokerClass[strtolower(trim($lotResMat[10]))];
              
              if ($debug_mode > 1) {
                print "[" . $scard1 . "|" . $scard2 . "|" . $scard3 . "|" . $scard4 . "|" . $scard5 ."]";
              }
              
              //printf("\nCard1: %s - Card2: %s - Card3: %s - Card4: %s - Card5: %s", $scard1, $scard2, $scard3, $scard4, $scard5);
            }
            if (preg_match("/\s*([a-zA-Z.*\/?=]*)\s*/i", $lmatches[4], $lotResMat)) {
              //print_r($lotResMat);
            } 
            if (preg_match("/\s*" . $srg_gameid . "\s*" . $srg_drawNo . "\s*" . $srg_drawDate . "\s*" . $srg_spielId . "\s*<input[^>]*>" . "/i", $lmatches[5], $lotResMat)) {
              //print_r($lotResMat);
              $str_gameid = $lotResMat[1];
              $str_drawNo = $lotResMat[2];
              $str_drawDate = $lotResMat[3];
              $str_spielId  = $lotResMat[4];
              
              if ($debug_mode > 1) {
                print "[" . $str_gameid . "|" . $str_drawNo . "|" . $str_drawDate . "|" . $str_spielId . "]";
              }
            }
            $sPoker_drawdate = strtotime($sPoker_drawdate);
            $sPoker_drawdate = date('Y-m-d', $sPoker_drawdate);
            $onPokerDrawId = $objOLG->OLGPokerGetDrawId($sPoker_drawdate);
             //printf("\nstr_gameid : %u - str_drawNo: %u - str_drawdate: %u - str_spielId : %u", $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
            if (!$onPokerDrawId) {
              $onPokerDrawId = $objOLG->OLGPokerAdd($sPoker_drawdate, "", $scard1 , $scard2, $scard3, $scard4, $scard5, $str_drawNo, $str_drawDate, $str_spielId);
              
            }
            
             if ($onPokerDrawId != null) {
              $onPokerWinningsId = $objOLG->OLGPokerWinningsGetId($onPokerDrawId);
              if (!$onPokerWinningsId) {
            	on_fetch_second_step_poker($sPoker_drawdate, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
            	}
        	}
            if ($debug_mode > 1) {
              print "[" . $sPoker_drawdate . "|" . $onPokerDrawId . "]";
            }
            //printf("\nPokerId : %u", $onPokerDrawId);
            
        }
      }
      
          
    
  } 
  
  function on_fetch_second_step_poker($sdrawdate, $str_gameid, $str_drawNo, $str_drawdate, $str_spielid) {
    
      global $debug_mode;
      
      $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
      
      $objLottery   = new Lottery();
      $objDate      = new GenDates();
      $objOLG       = new OLGLottery();
      $naLottery    = new NALottery();
      $onPoker_row  = $objLottery->dbLotteryGamesGet("onPoker");
      
      $drawdate = strtotime($sdrawdate);
      
      $onPokerGameId = 69;
      
      $hp_gameID     = $onPokerGameId;
      $hp_drawNo     = $str_drawNo;
      $hp_sdrawDate  = $str_drawdate;
      $hp_spielID    = $str_spielid;
      
      
      if (preg_match("/http:\/\/([^\/]*)(.*)\/(.*?)/i", $url_step3, $lmatches) ) {
          
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
        
          $site_post_str = sprintf("gameID=%u&drawNo=%usdrawDate=%u&spielID=%u", $str_gameid, $str_drawNo, $str_drawdate, $str_spielid);
          $site_post_id = $objLottery->dbWebUrlsGetId($site_post_str, "POSTSTR");
          if (!$site_post_id) {
            $site_post_id = $objLottery->dbWebUrlsAdd($site_post_str, "POSTSTR");
          }          
          
        /*  print_r($lmatches);
          print "\nSiteDomain: " . $site_domain_id;
          print "\nSitePath  : " . $site_path_id;
          print "\nSiteFile  : " . $site_file_id;
          print "\nSitePost : " . $site_post_id;
          print "\n\n" . $site_post_str;
          */       
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onPoker", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onPoker", $onPoker_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onPoker", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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

         // print "\nSD: " . $site_domain_id . " SPD: " . $site_path_id . " SFD: " . $site_file_id . " SQD "  . $site_post_id . "\n";
        }
      
      if (!$http = new http()) {
        $status_msg = "...";
      }
      
      $http->headers['Referer'] = $url_step2;
      
      if (!$http->fetch($url_step2)) {
        $status_msg = "...";
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
      
      
      $onPokerGameId    = 69;
      
      $http->postvars['gameID']     = $onPokerGameId;
      $http->postvars['drawNo']     = $hp_drawNo;
      $http->postvars['sdrawDate']  = $hp_sdrawDate;
      $http->postvars['spielID']    = $hp_spielID;
      
      
      if (!$http->fetch($url_step3)) {
        $status_msg = "...";
      }
      
      //print_r($http->body);
      
      $html_body = preg_replace("/\s|\t|\n|\r\n/i"," ",$http->body);
      $srgB_table   = "<table[^>]*>";
      $srgE_table   = "<\/table>";
      $srgB_tr      = "<tr[^>]*>";
      $srgE_tr      = "<\/tr>";
      $srgB_th      = "<th[^>]*>";
      $srgE_th      = "<\/th>";
      $srgB_td = "<td[^>]*>";
      $srgE_td = "<\/td>";
      $srgB_p = "<p[^>]*>";
      $srgE_p = "<\/p>";
      $srgB_strong = "<strong>";
      $srgE_strong = "<\/strong>";
      $srgB_span    = "<span[^>]*>";
      $srgE_span    = "<\/span>";
      $srgB_form = "<form [^>]*>";
      $srgE_form = "<\/form>";
      $srgB_br   = "<br[^]*>";
      $srg_comment = "<!--.*-->";
      $srg_input = "<input .*?name=\"(.*)\"\s*value=\"(.*?)\"\s*>";
      $srg_gameid = "<input .*?name=\"gameID\" \s*value=\"(\d+)\"\s*>\s*";
      $srg_drawNo = "<input .*?name=\"drawNo\" \s*value=.(\d+)\"\s*>\s*";
      $srg_drawDate = "<input .*?name=\"sdrawDate\" \s*value=\"(\d+)\"\s*>\s*";
      $srg_spielId = "<input .*?name=\"spielID\" \s*value=\"(\d+)\">\s*";   
      $srg_form_act = "<form.*?action=\"(.*)\"[^>]*>";
      
      
      
       
      //$html_body = preg_replace("/" . $spattern . "/i","$1", $html_body);
      $html_tr_list = preg_split("/" . $srgB_tr . "/i", $html_body);
      //$html_input_list = preg_split("/<br \/>/i", $html_tr_list[6]);
      //print_r($html_input_list);
      //print_r ($html_tr_list);
      
      $sPoker_m     = 0;
      
      $sPokerInst_m = 0;
      
      $srg_Pkr_Winning_Hdr = "WINNINGS FOR \s* POKER LOTTO"; //WINNINGS FOR POKER LOTTO
      $srg_Pkr_Inst_Winning_Hdr = "WINNINGS FOR POKER LOTTO INSTANT WINS";
      //$srg_encore_Winning_Hdr = "WINNINGS FOR \s* ENCORE";
      
      $srgDays    = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
      $srgMonths  = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
      
      
      $sPkr_th_Lines  = $srgB_th . "(.*?)" . $srgE_th;            // Match
      $sPkr_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Number of Winnings 
      $sPkr_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Prize
      
      
      $sPkr_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong .  "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" .  $srgE_td;
      $sPkr_td_Lines .=  "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      $sPkr_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      
      $sPkr_Inst_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_p . "\s*" .  $srgE_td;
      $sPkr_Inst_td_Lines .=  "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      $sPkr_Inst_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      
      $str_money_sym = array("$",","); 
      
      foreach ($html_tr_list as $html_tr) {
        if (preg_match("/". $srg_Pkr_Winning_Hdr . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
          $sPoker_m      = 1;
          $sPokerInst_m  = 0;
        } elseif (preg_match("/" . $srg_Pkr_Inst_Winning_Hdr . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
          $sPoker_m      = 0;
          $sPokerInst_m  = 1;
        } elseif ($sPoker_m == 1 &&
                  preg_match("/" . $sPkr_th_Lines . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
           
        } elseif ($sPoker_m == 1 &&
                  preg_match("/" . $sPkr_td_Lines . "/i", $html_tr, $lmatches)) {
          //print_r ($lmatches);   
          if (preg_match("/5\/5/i", $lmatches[1], $lot_mat_)) {
            $m_5_5_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_5_5_win_count  = trim($lmatches[2]);
            $m_5_5_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_5_5_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_5_5_prize_id) {
              $m_5_5_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_5_5_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[m5of5|" .  $m_5_5_prize_amt . "|" . $m_5_5_prize_id . "|" . $m_5_5_win_count . "]";
            }
            
            
          } elseif (preg_match("/4\/5/i", $lmatches[1], $lot_mat_)) {
            $m_4_5_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_4_5_win_count  = trim($lmatches[2]);
            $m_4_5_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_4_5_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_4_5_prize_id) {
              $m_4_5_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_4_5_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[m4of5|" . $m_4_5_prize_amt . "|" . $m_4_5_prize_id . "|" . $m_4_5_win_count . "]";
            }
          } elseif (preg_match("/3\/5/i", $lmatches[1], $lot_mat_)) {
            $m_3_5_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_3_5_win_count  = trim($lmatches[2]);
            $m_3_5_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_3_5_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_3_5_prize_id) {
              $m_3_5_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_3_5_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[m3of5|" . $m_3_5_prize_amt . "|" . $m_3_5_prize_id . "|" . $m_3_5_win_count . "]";
            }
            
            
          } elseif (preg_match("/2\/5/i", $lmatches[1], $lot_mat_)) {
            $m_2_5_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_2_5_win_count  = trim($lmatches[2]);
            $m_2_5_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_2_5_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_2_5_prize_id) {
              $m_2_5_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_2_5_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            
            if ($debug_mode > 1) {
              print "[m2of5|" . $m_2_5_prize_amt . "|" . $m_2_5_prize_id . "|" . $m_2_5_win_count . "]";
            }
          }
          
        } elseif ($sPokerInst_m == 1 &&
                  preg_match("/" . $sPkr_th_Lines . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);            
        } elseif ($sPokerInst_m == 1 &&
                  preg_match("/" . $sPkr_Inst_td_Lines . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);            
          if (preg_match("/Royal Flush/i", $lmatches[1], $lot_mat_)) {
            $m_rf_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_rf_win_count  = trim($lmatches[2]);
            $m_rf_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_rf_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_rf_prize_id) {
              $m_rf_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_rf_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[mRF|" . $m_rf_prize_amt . "|" . $m_rf_prize_id . "|" . $m_rf_win_count . "]";
            }
          } elseif (preg_match("/Straight Flush/i", $lmatches[1], $lot_mat_)) {
            $m_sf_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_sf_win_count  = trim($lmatches[2]);
            $m_sf_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_sf_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_sf_prize_id) {
              $m_sf_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_sf_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[mSF|" . $m_sf_prize_amt . "|" . $m_sf_prize_id . "|" . $m_sf_win_count . "]";
            }
            
          } elseif (preg_match("/4 of a kind/i", $lmatches[1], $lot_mat_) ) {
            $m_4k_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_4k_win_count  = trim($lmatches[2]);
            $m_4k_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_4k_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_4k_prize_id) {
              $m_4k_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_4k_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[m4K|" . $m_4k_prize_amt . "|" . $m_4k_prize_id . "|" . $m_4k_win_count . "]";
            }
          } elseif (preg_match("/Full House/i", $lmatches[1], $lot_mat_)) {
            $m_fh_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_fh_win_count  = trim($lmatches[2]);
            $m_fh_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_fh_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_fh_prize_id) {
              $m_fh_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_fh_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[mFH|" . $m_fh_prize_amt . "|" . $m_fh_prize_id . "|" . $m_fh_win_count . "]";
            }
            
          } elseif (preg_match("/Flush/i", $lmatches[1], $lot_mat_)) {
            $m_f_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_f_win_count  = trim($lmatches[2]);
            $m_f_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_f_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_f_prize_id) {
              $m_f_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_f_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[mF|" . $m_f_prize_amt . "|" . $m_f_prize_id . "|" . $m_f_win_count . "]";
            }
            
            
          } elseif (preg_match("/Straight/i", $lmatches[1], $lot_mat_)) {
            $m_s_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_s_win_count  = trim($lmatches[2]);
            $m_s_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_s_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_s_prize_id) {
              $m_s_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_s_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            
            if ($debug_mode > 1) {
              print "[mST|" . $m_s_prize_amt . "|" . $m_s_prize_id . "|" . $m_s_win_count . "]";
            }
          } elseif (preg_match("/3 of a kind/i", $lmatches[1], $lot_mat_)) {
            $m_3k_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_3k_win_count  = trim($lmatches[2]);
            $m_3k_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_3k_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_3k_prize_id) {
              $m_3k_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_3k_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }            
            
            if ($debug_mode > 1) {
              print "[m3K|" . $m_3k_prize_amt . "|" . $m_3k_prize_id . "|" . $m_3k_win_count . "]";
            }
          } elseif (preg_match("/2 Pair/i", $lmatches[1], $lot_mat_)) {
            $m_2p_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_2p_win_count  = trim($lmatches[2]);
            $m_2p_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_2p_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_2p_prize_id) {
              $m_2p_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_2p_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }            
            
            if ($debug_mode > 1) {
              print "[m2P|" . $m_2p_prize_amt . "|" . $m_2p_prize_id . "|" . $m_2p_win_count . "]";
            }
          } elseif (preg_match("/Pair Jacks\+\(J\.Q\.K\.A\)/i", $lmatches[1], $lot_mat_)) {
            $m_pj_prize_amt  = str_replace($str_money_sym,"", trim($lmatches[3]));
            if ($m_pj_prize_amt == "FREE PLAY") {
              $m_pj_prize_amt = 2;
              $m_pj_prize_amt_freeplay = "FREE PLAY";
            }
            $m_pj_win_count  = trim($lmatches[2]);
            $m_pj_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_pj_prize_amt, $objLottery->prz_money, $onPoker_row["gameid"]);
            if (!$m_pj_prize_id) {
              $m_pj_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_pj_prize_amt, $objLottery->prz_money, trim($lmatches[3]), $onPoker_row["gameid"]);
            }
            
            if ($debug_mode > 1) {
              print "[mPJ|" . $m_pj_prize_amt . "|" . $m_pj_prize_amt_freeplay . "|" . $m_pj_prize_id . "|" . $m_pj_win_count . "]";
            }
            $sPoker_drawDate = strtotime($sdrawdate);
            $sPoker_drawDate = date('Y-m-d', $sPoker_drawDate);
            $onPokerId = $objOLG->OLGPokerGetDrawId($sPoker_drawDate);
            //print "\nPoker Draw Date: " . $sPoker_drawDate . " - PokerId: " . $onPokerId;
            if ($onPokerId != null) {
              $onPokerWinningsId = $objOLG->OLGPokerWinningsGetId($onPokerId);
              if (!$onPokerWinningsId) {
                  $onPokerWinningsId = $objOLG->OLGPokerWinningsAdd(
                    $onPokerId,$m_5_5_win_count,$m_5_5_prize_id,$m_4_5_win_count,$m_4_5_prize_id,$m_3_5_win_count,$m_3_5_prize_id,$m_2_5_win_count,$m_2_5_prize_id,
                    $m_rf_win_count,$m_rf_prize_id,$m_sf_win_count,$m_sf_prize_id,$m_4k_win_count,$m_4k_prize_id,$m_fh_win_count,$m_fh_prize_id,
                    $m_f_win_count,$m_f_prize_id,$m_s_win_count,$m_s_prize_id,$m_3k_win_count,$m_3k_prize_id,$m_2p_win_count,$m_2p_prize_id,
                    $m_pj_win_count,$m_pj_prize_id,0);
              }
              
            }
            if ($debug_mode > 1) {
              print "[pkId: " . $onPokerId . "|" . $onPokerWinningsId . "]";
            }    
                  
          }
        }
        
      }
      
          
    
  }
  
  ?>