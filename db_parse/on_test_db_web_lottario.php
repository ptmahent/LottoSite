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

  
  $objLottery = new Lottery();
  $objOLG     = new OLGLottery();
  
  
  $cmdargs = arguments();
  
  
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^update/i", $cmdargs["standard"][1], $lmatches)) {
  		$lottery_draw_data_dates = $objOLG->OLGLottarioGetFirstLastDataAvail();
  		$startDay 	= date('d',strtotime($lottery_draw_data_dates["latest"]));
  		$startMonth = date('m',strtotime($lottery_draw_data_dates["latest"]));
  		$startYear 	= date('Y',strtotime($lottery_draw_data_dates["latest"]));
  		$endDay 	= date('d');
  		$endMonth 	= date('m');
  		$endYear    = date('Y');
  		$startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
		$endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);  		
  		$drawDates = $objLottery->dbLotteryGetDrawDates("onLottario", "MM", $startDate, $endDate); 
  		
  	} elseif (preg_match("/^getMonth/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  			$selectedMonth = $lmatches[1];
      	  	$selectedYear = $lmatches[2];
      	  	$startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      	    $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      	  	$drawDates = $objLottery->dbLotteryGetDrawDates("onLottario", "MM", $startDate, $endDate); 
  		}
  	} elseif (preg_match("/^getYear/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{4})|(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		      $selectedYear = $lsubmat[1];
      	  	  $startDate    = mktime(0,0,0,1,1,$selectedYear);
      	  	  $endDate      = mktime(0,0,0,12,31,$selectedYear);
      	  	  $drawDates = $objLottery->dbLotteryGetDrawDates("onLottario", "YY", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/^getDraw/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		    //print_r($lmatches); 
      	  	$selectedDay    = $lsubmat[1];
      	  	$selectedMonth  = $lsubmat[2];
      	  	$selectedYear   = $lsubmat[3];
      	  	$startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$drawDates = $objLottery->dbLotteryGetDrawDates("onLottario", "DD", $startDate, $endDate);
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
      	$drawDates = $objLottery->dbLotteryGetDrawDates("onLottario", "DD1DD2", $startDate, $endDate);
  	}
  	
  	    //print_r($drawDates);
    if (is_array($drawDates)) {
      foreach ($drawDates as $dtDate) {
          // 20090211
        $drawDate = strtotime($dtDate);
        //print "\n<br /> " . date('d-m-Y', $drawDate); 
        //print_r($dtDate);
        //alc_fetch_single_draw(date('d-m-Y',$drawDate));
        //on_fetch_first_step_649(date('d-m-Y', $drawDate));
        //on_fetch_first_step_max(date('d-m-Y', $drawDate));
        on_fetch_first_step_lottario(date('d-m-Y', $drawDate));
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
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onLottario", "DD1DD2", $startDate, $endDate);
		} elseif (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		   print_r($lmatches); 
		  $selectedDay    = $lmatches[1];
		  $selectedMonth  = $lmatches[2];
		  $selectedYear   = $lmatches[3];
		  $startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onLottario", "DD", $startDate, $endDate);
		} elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		  $selectedMonth = $lmatches[1];
		  $selectedYear = $lmatches[2];
		  $startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
		  $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onLottario", "MM", $startDate, $endDate);    
		} elseif (preg_match("/getYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
		  $selectedYear = $lmatches[1];
		  $startDate    = mktime(0,0,0,1,1,$selectedYear);
		  $endDate      = mktime(0,0,0,12,31,$selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onLottario", "YY", $startDate, $endDate);
		}
      
    
		//print_r($drawDates);
		if (is_array($drawDates)) {
		  foreach ($drawDates as $dtDate) {
			  // 20090211
			$drawDate = strtotime($dtDate);
			//print "\n<br /> " . date('d-m-Y', $drawDate); 
			//print_r($dtDate);
			//alc_fetch_single_draw(date('d-m-Y',$drawDate));
			//on_fetch_first_step_649(date('d-m-Y', $drawDate));
			//on_fetch_first_step_max(date('d-m-Y', $drawDate));
			on_fetch_first_step_lottario(date('d-m-Y', $drawDate));
		  }
		}    
		
	  } while (trim($selection) != 'q');
	}
  
  function on_fetch_first_step_lottario($drawdate = "") {
        
    global $debug_mode;
    
    $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
    $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
    $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
    
    
      $objLottery = new Lottery();
      $objDate    = new GenDates();
      $objOLG     = new OLGLottery();
      $naLottery  = new NALottery();
      
      //print "\n\n" . $drawdate . " --- " ;
      $drawdate = strtotime($drawdate);
      //print date('mY', $drawdate);
      $onLottarioGameId    = 5;
      if ($drawdate == "") {
        
          $hp_selectedMonthYear = date('mY',mktime(0,0,0,date('m') - 1,date('d'),date('Y')));
      } else {

          $hp_selectedMonthYear = date('mY', mktime(0,0,0,date('m',$drawdate) - 1, date('d', $drawdate), date('Y', $drawdate)));
      }
      
      $hp_day                   = 0;
      $hp_gameID               = $onLottarioGameId;
      $hp_command              = 'submit';
  
      $onLottario_row = $objLottery->dbLotteryGamesGet("onLottario");
    
    
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
          //print_r($lmatches);
          //print "\nSiteDomain: " . $site_domain_id;
          //print "\nSitePath  : " . $site_path_id;
          //print "\nSiteFile  : " . $site_file_id;
          //print "\nSitePost : " . $site_post_id;
          //print "\n" . $site_post_str;
                 
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onLottario", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($onLottario_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onLottario", $onLottario_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onLottario", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
    
    $onLottarioGameId    = 5;
    
      $http->postvars['selectedMonthYear']    = $hp_selectedMonthYear;
      $http->postvars['day']                  = $hp_day;
      $http->postvars['gameID']               = $hp_gameID;
      $http->postvars['command']              = 'submit';
      
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
    
    
    
    $bOnLottario_m     = 0;
    
    $srg_onlottario   = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
    $srg_onearlybird  = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
    $srg_onEncore     = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
    $srg_bonusnum     = "\s*(\d{2})\s*";
      
    $sLot_th_Line     = $srgB_th . "(.*?)" . $srgE_th;        // Date
    $sLot_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Day
    $sLot_th_Line     .= "\s*" . $srgB_th . "(.*?)" ;                 // Numbers
    $sLot_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Bonus
    $sLot_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // ENCORE
    $sLot_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // WINNINGS
    
    $sLot_td_Line     = $srgB_td . "(.*?)"  . $srgE_td;        // Date
    $sLot_td_Line     .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day
    $sLot_td_Line     .= "\s*" . $srgB_td .   "(.*?)";                  // Numbers
    $sLot_td_Line     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Bonus
    $sLot_td_Line     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Encore
    $sLot_td_Line     .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings
    
    $str_money_sym = array("$",","); 
    $srgDays          = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
    $srgMonths        = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
    
    //print_r ($html_tr_list);
    

    if ($debug_mode > 0) {
      print "\nFetch " . $site_file . $site_querystr;
      print "\nDate: " . date('Y-m-d', $drawdate);
    }    
    
    foreach($html_tr_list as $html_tr) {
      
      if (preg_match("/" . $sLot_th_Line . "/i", $html_tr, $lmatches)) {
        $bOnLottario_m   = 1;
         //print_r($lmatches);
      } elseif ($bOnLottario_m == 1 &&
              (preg_match("/" . $sLot_td_Line . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
            //print_r($lotResMat);     
            $sdrawMonthName = trim($lotResMat[2]);
            $sdrawMonthNum  = $objDate->getShortMonthNum($sdrawMonthName);
            $sdrawDay       = $lotResMat[1];
            $sdrawYear      = $lotResMat[3];
            $sLottario_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
            //print "\nDrawDate: " . $sLottario_drawdate;
            if ($debug_mode > 1) {
              print "\n[" . $sLottario_drawdate . "]";
            }
         
          }
          if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\w{3})\s*" . $srgE_strong. $srgE_p . "/i",$lmatches[2], $lotResMat)) {
            //print_r($lotResMat);
            $sdrawDayNam = trim($lotResMat[1]);
          }
          //print_r($lmatches[3]);
          
          
      
          $html_br_list = preg_split("/<br[^>]*>/i", $lmatches[3]);
         // print_r($html_br_list);      
    
          if (preg_match("/" . $srg_onlottario . "/i", $html_br_list[0], $lotResMat)) {
            //print_r($lotResMat);
            
            $snum1  = $lotResMat[1];
            $snum2  = $lotResMat[2];
            $snum3  = $lotResMat[3];
            $snum4  = $lotResMat[4];
            $snum5  = $lotResMat[5];
            $snum6  = $lotResMat[6];
            if ($debug_mode > 1) {
                print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6 . "]";
            }  
            
          }
          if (preg_match("/" . $srg_onearlybird . "/i", $html_br_list[1], $lotResMat )) {
            //print_r($lotResMat);
            
            $seb_num1 = $lotResMat[1];
            $seb_num2 = $lotResMat[2];
            $seb_num3 = $lotResMat[3];
            $seb_num4 = $lotResMat[4];
            
            if ($debug_mode > 1) {
              print "[" . $seb_num1 . "|" . $seb_num2 . "|" . $seb_num3 . "|" . $seb_num4 . "]";
            }
          }
    
          if (preg_match("/" . $srgB_p . $srgB_strong . $srg_bonusnum . $srgE_strong . $srgE_p . "/i", $lmatches[4], $lotResMat)) {
            //print_r($lotResMat);
            $snumBonus = $lotResMat[1];
            print "[B" . $snumBonus . "]";
          }
          if (preg_match("/\s*" . $srgB_p . $srgB_strong . $srg_onEncore . $srgE_strong . $srgE_p . "/i", $lmatches[5], $lotResMat )) {
            //print_r($lotResMat);
              $senc_num1 = $lotResMat[1];
              $senc_num2 = $lotResMat[2];
              $senc_num3 = $lotResMat[3];
              $senc_num4 = $lotResMat[4];
              $senc_num5 = $lotResMat[5];
              $senc_num6 = $lotResMat[6];
              $senc_num7 = $lotResMat[7];
              if ($debug_mode > 1) {
                  print "[" . $senc_num1 . "|" . $senc_num2 . "|" . $senc_num3 . "|" . $senc_num4 . "|" . $senc_num5 . "|" . $senc_num6 . "|" . $senc_num7 . "]";
                }
              
          }
          if (preg_match("/\s*([a-zA-Z.*\/?=]*)\s*/i", $lmatches[6], $lotResMat)) {
            ///print_r($lotResMat);
          } 
          if (preg_match("/\s*" . $srg_gameid . "\s*" . $srg_drawNo . "\s*" . $srg_drawDate . "\s*" . $srg_spielId . "\s*<input[^>]*>" . "/i", $lmatches[7], $lotResMat)) {
            //print_r($lotResMat);
              $str_gameid = $lotResMat[1];
              $str_drawNo = $lotResMat[2];
              $str_drawDate = $lotResMat[3];
              $str_spielId  = $lotResMat[4];
              
               if ($debug_mode > 1) {
                  print "[" .  $str_gameid . "|" . $str_drawNo . "|" . $str_drawDate . "|" . $str_spielId . "]";
                }
          }
          
          $sLottario_drawdate = strtotime($sLottario_drawdate);
          $sLottario_drawdate = date('Y-m-d', $sLottario_drawdate);
          $onLottarioDrawId = $objOLG->OLGLottarioGetDrawId($sLottario_drawdate);
          if (!$onLottarioDrawId) {
            $onLottarioDrawId = $objOLG->OLGLottarioAdd($sLottario_drawdate, 0, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumBonus, 0, $seb_num1, $seb_num2 , $seb_num3 , $seb_num4 , $str_drawNo, $str_drawDate, $str_spielId);
          }
          if ($debug_mode > 1) {
            print "[SD - ID " .  $onLottarioDrawId . "]";
          }
          $str_onEncoreId = $objOLG->OLGEncoreGetDrawId($sLottario_drawdate);
          if (!$str_onEncoreId) {
            $str_onEncoreId = $objOLG->OLGEncoreAdd($sLottario_drawdate, "", $senc_num1, $senc_num2, $senc_num3, $senc_num4, $senc_num5, $senc_num6, $senc_num7);
          }
          
          if ($onLottarioDrawId != null) {
              $onLottarioWinningId = $objOLG->OLGLottarioWinningsGetId($onLottarioDrawId);
              if (!$onLottarioWinningId) {
          			on_fetch_second_step_lottario($sLottario_drawdate, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
          		}
          }
          
          if ($debug_mode > 1) {
            print "\n[" . $str_onEncoreId . "]";
          }
         // print "\n\nDraw Date: " . $sLottario_drawdate . "\n";
          
          
      }
    }
        
    
  } 
  
  function on_fetch_second_step_lottario($sdrawdate, $str_gameid, $str_drawNo, $str_drawdate, $str_spielid) {
    
      //print "\n\n\n\n\n<br />Second Step \n\n\n\n";
      
      global $debug_mode;
      
      $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
      
      
    $objLottery   = new Lottery();
    $objDate      = new GenDates();
    $objOLG       = new OLGLottery();
    $naLottery    = new NALottery();
    $onLottario_row  = $objLottery->dbLotteryGamesGet("onLottario");
    $onEncore_row = $objLottery->dbLotteryGamesGet("onEncore");
    
    $drawdate = strtotime($sdrawdate);

     $onLottarioGameId    = 5;
    
    $hp_gameID     = $onLottarioGameId;
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
        $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onLottario", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
        if (!$fetch_stats_id) {
          $fetch_date = date('Y-m-d H:i:s');
          $fetch_pos = 0;
          $fetch_process_suc = 0;
          //print_r($na649_row);
          // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
          $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onLottario", $onLottario_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
          $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
         } else {
          $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onLottario", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
      
      
      $onLottarioGameId    = 5;
      $http->postvars['gameID']     = $onLottarioGameId;
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
      
      $sLottario_m     = 0;
      $sEncore_m  = 0;
      
      $srg_649_Winning_Hdr = "WINNINGS FOR \s* LOTTARIO"; //WINNINGS FOR      LOTTARIO  
      $srg_encore_Winning_Hdr = "WINNINGS FOR ENCORE"; // WINNINGS FOR ENCORE
      
      $srgDays    = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
      $srgMonths  = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
      
      
      $sLot_th_Lines  = $srgB_th . "(.*?)" . $srgE_th;            // Match
      $sLot_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Number of Winnings 
      $sLot_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Prize
      
     /* 
      <th class="white_centre" id="lottery_borderless" align="left">      Match</th>     
      <th class="white_centre" id="lottery_borderless" align="center">     Number of Winning Tickets Sold   </th>
      <th class="white_centre" id="lottery_borderless" align="right">     Prize</th>
      */
      /*
         [8] =>       <td id="lottery_border" width="128px">      
       * <p class="blue"><strong>6/6</strong></p>      
       * </td>      
       * <td id="lottery_border" width="134px" align="center">      
       * <p class="blue"><strong>1</strong></p>      
       * </td>      
       * <td id="lottery_border" align="right"><p class="blue"><strong>         $12,518,450.00   
                        </strong></p></td>     </tr>                                             
       
       */
      
      
      /*
       * 
       * 
       * 
       *    [0] =>                        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">  <html>  <head>   <meta content="text/html; charset=ISO-8859-1" http-equiv="Content-Type" />  <meta http-equiv="Content-Script-Type" content="text/javascript" />  <meta http-equiv="Content-Style-Type" content="text/css" />  <meta name="title" content="Ontario's Official Web site for Lottery Information"/>  <meta name="keywords" content="Ontario, Canada, lottery, lotteries, Ontario Lottery and Gaming Corporation, OLGC, Ontario Lottery Corporation, OLC, games, gaming, gambling, responsible gaming, responsible gambling, jackpot, jackpots, winning numbers, government, sport, sports, sports betting, loterie, loteries, Soci?t? des loteries et des jeux de l'Ontario, SLJO, Soci?t? des loteries de l'Ontario, SLO, jeux, jouer, pari, jeux de loterie sur terminal, gros lot, gros lots, num?ros gagnants, gouvernement, sport, sports, pari sportif, Bingo, Instant Bingo, Bingo Instant, Superstar Bingo, 6/49, Lotto 6/49, Lotto Super 7, Super 7, Ontario 49, Lottario, Pick 3, Daily Keno, Instant Keno, Keno Instant, Winner Take All, Keno, Cash for Life, Ontario Instant Millions, Instant Millions, Instant Crossword, Crossword, Instant Battleship, Battleship Instant, Battleship, Lotto Advance, Loto-Courrier, Encore, Scratch and Win, gratter et gagner, Scratch Tickets, billets ? gratter, Proline, Pro-line, Pro line, Pro Line, Pointspread, Point-Spread, Point Spread, spread, ?cart, Propicks, Pro-Picks, Pro*Picks, Pro Picks, Sportselect, Sport Select, Sports Select, Sportsselect, Sport-Select, Sports-Select, Overunder, Over-Under, Over/Under, Over Under, sports wagering, Big Ticket Lottery, mise sportive, Ontario sports gaming, loteries sportives de l'Ontario."/>  <meta name="description" content="Official Web site for Ontario Lottery and Gaming Corporation's lottery players, aged 18 and over. Featuring winning numbers, upcoming jackpots, game demos, winners and beneficiaries.  Site Web officiel des joueurs de la Soci?t? des loteries et des jeux de l'Ontario, ?g?s de 18 ans ou plus. Num?ros gagnants, prochains gros lots, d?monstration des jeux, gagnants et b?n?ficiaires."/>  <!-- HTTP 1.1 -->  <meta http-equiv="Cache-Control" content="no-store"/>  <!-- HTTP 1.0 -->  <meta http-equiv="pragma" content="no-cache"/>  <meta http-equiv="expires" content="-1"/>     <title>OLG - </title>   <script type="text/javascript" src="/assets/home/swfobject.js"></script>                           <link rel="stylesheet" type="text/css" href="/css/normstyle.css" title="normstyle" />   <link rel="alternate stylesheet" type="text/css" href="/css/plusstyle.css" title="plusstyle" />   <link rel="alternate stylesheet" type="text/css" href="/css/minusstyle.css" title="minusstyle" />   <link rel="stylesheet" type="text/css" href="/css/interface.css" />   <link rel="stylesheet" type="text/css" href="/css/photoboard.css" />   <script type="text/javascript" src="/js/styleswitcher.js"></script>   <script type="text/javascript" src="/js/funcs.js"></script>   <script type="text/javascript" src="/js/flash_scripts.js"></script>                <script type="text/javascript" src="http://www.google-analytics.com/ga.js"></script>          <script type="text/javascript" src="/js/analyse.js"></script>    </head>  <body class="lotteries">  <!-- google analytics code -->  <script type="text/javascript">   pageTracker._trackPageview();  </script>  <!-- /google analytics code -->  <!-- header table -->  <table cellspacing="0" cellpadding="0" border="0" width="100%" height="160px">   
    [1] =>     <td width="33%"></td>    <td width="750px" bgcolor="#ffffff" height="160px">                              <script type="text/javascript" language="javascript">   globalNavOn = new Array();   globalNavOff = new Array();     globalNavOn["navHome"] = new Image();   globalNavOff["navHome"] = new Image();   globalNavOn["navHome"].src = "/assets/buttons/btn_global_home_on.gif";   globalNavOff["navHome"].src = "/assets/buttons/btn_global_home_off.gif";   globalNavOn["navLotteries"] = new Image();   globalNavOff["navLotteries"] = new Image();   globalNavOn["navLotteries"].src = "/assets/buttons/btn_global_lotteries_on.gif";   globalNavOff["navLotteries"].src = "/assets/buttons/btn_global_lotteries_off.gif";   globalNavOn["navProline"] = new Image();   globalNavOff["navProline"] = new Image();   globalNavOn["navProline"].src = "/assets/buttons/btn_global_proline_on.gif";   globalNavOff["navProline"].src = "/assets/buttons/btn_global_proline_off.gif";   globalNavOn["navSlots-casinos"] = new Image();   globalNavOff["navSlots-casinos"] = new Image();   globalNavOn["navSlots-casinos"].src = "/assets/buttons/btn_global_slots-casinos_on.gif";   globalNavOff["navSlots-casinos"].src = "/assets/buttons/btn_global_slots-casinos_off.gif";   globalNavOn["navBingo"] = new Image();   globalNavOff["navBingo"] = new Image();   globalNavOn["navBingo"].src = "/assets/buttons/btn_global_bingo_on.gif";   globalNavOff["navBingo"].src = "/assets/buttons/btn_global_bingo_off.gif";   globalNavOn["navContests"] = new Image();   globalNavOff["navContests"] = new Image();   globalNavOn["navContests"].src = "/assets/buttons/btn_global_contests_on.gif";   globalNavOff["navContests"].src = "/assets/buttons/btn_global_contests_off.gif";   globalNavOn["navEntertainment"] = new Image();   globalNavOff["navEntertainment"] = new Image();   globalNavOn["navEntertainment"].src = "/assets/buttons/btn_global_entertainment_on.gif";   globalNavOff["navEntertainment"].src = "/assets/buttons/btn_global_entertainment_off.gif";   globalNavOn["navAbout"] = new Image();   globalNavOff["navAbout"] = new Image();   globalNavOn["navAbout"].src = "/assets/buttons/btn_global_about_on.gif";   globalNavOff["navAbout"].src = "/assets/buttons/btn_global_about_off.gif";    function globalOn(i) {   if (document.images && document.images[i].complete)    document.images[i].src = globalNavOn[i].src;  }    function globalOff(i) {   if (document.images && document.images[i].complete)    document.images[i].src = globalNavOff[i].src;  }  </script>  <div class="globalmenu">   <a href="http://www.olg.ca/index.jsp"  onmouseover="globalOn('navHome');" onmouseout="globalOff('navHome');" onfocus="globalOn('navHome');" onblur="globalOff('navHome');"><img name="navHome" src="/assets/buttons/btn_global_home_off.gif" width="93px" height="30px" alt="Home" border="0" /></a><a href="http://www.olg.ca/lotteries/index.jsp" ><img name="navGLotteries" src="/assets/buttons/btn_global_lotteries_on.gif" width="93px" height="30px" alt="Lotteries" border="0" /></a><a href="http://proline.olg.ca/"  onmouseover="globalOn('navProline');" onmouseout="globalOff('navProline');" onfocus="globalOn('navProline');" onblur="globalOff('navProline');"><img name="navProline" src="/assets/buttons/btn_global_proline_off.gif" width="93px" height="30px" alt="PRO?LINE" border="0" /><a href="http://www.olg.ca/slots-casinos/index.jsp"  onmouseover="globalOn('navSlots-casinos');" onmouseout="globalOff('navSlots-casinos');" onfocus="globalOn('navSlots-casinos');" onblur="globalOff('navSlots-casinos');"><img name="navSlots-casinos" src="/assets/buttons/btn_global_slots-casinos_off.gif"  width="93px" height="30px" alt="Slots &amp; Casinos" border="0" /></a><a href="http://www.olg.ca/bingo/index.jsp"  onmouseover="globalOn('navBingo');" onmouseout="globalOff('navBingo');" onfocus="globalOn('navBingo');" onblur="globalOff('navBingo');"><img name="navBingo" src="/assets/buttons/btn_global_bingo_off.gif" width="93px" height="30px" alt="Charitable<br/>Gaming" border="0" /></a><a href="http://www.olg.ca/contests/index.jsp"  onmouseover="globalOn('navContests');" onmouseout="globalOff('navContests');" onfocus="globalOn('navContests');" onblur="globalOff('navContests');"><img name="navContests" src="/assets/buttons/btn_global_contests_off.gif" width="93px" height="30px" alt="Contests &amp; Promos" border="0" /></a><a href="http://www.olg.ca/entertainment/index.jsp"  onmouseover="globalOn('navEntertainment');" onmouseout="globalOff('navEntertainment');" onfocus="globalOn('navEntertainment');" onblur="globalOff('navEntertainment');"><img name="navEntertainment" src="/assets/buttons/btn_global_entertainment_off.gif" width="93px" height="30px" alt="Entertainment" border="0" /></a><a href="http://www.olg.ca/about/index.jsp"  onmouseover="globalOn('navAbout');" onmouseout="globalOff('navAbout');" onfocus="globalOn('navAbout');" onblur="globalOff('navAbout');"><img name="navAbout" src="/assets/buttons/btn_global_about_off.gif" width="99px" height="30px" alt="About OLG" border="0" /></a></div>  <table height="130px" border="0" cellpadding="0" cellspacing="0" width="750px">   
    [2] =>     <td width="750px" height="130px">     <a href="/lotteries/index.jsp"><img src="/assets/headers/hdr_lotteries_link.jpg" width="160px" height="130px" alt="OLG" border="0" /></a><img src="/assets/headers/hdr_lotteries.jpg" width="590px" height="130px" alt="" border="0" /><br />    </td>   </tr>  </table>      </td>    <td width="33%"></td>   </tr>  </table>  <!-- /header table -->  <!-- content table -->  <table cellspacing="0" cellpadding="0" border="0" width="100%" height="50%">   
    [3] =>     <td width="33%" rowspan="2"></td>    <td class="nav_lotteries" width="160px" valign="top">                            <a href="#skip_menu"><img src="/assets/spacer.gif" width="0" height="0" border="0" alt="skip main menu" /><br /></a>  <!-- Winning Numbers -->  <div id="lotteriesNavContainer" style="width:160px;" class="font">   <ul>    <li><a href="http://www.olg.ca/lotteries/viewWinningNumbers.do" id="numbers" class="section">Winning Numbers</a>    </li>   </ul>  </div>     <div id="lotteriesNavContainerL2" class="font">    <ul>     <li><a href="http://www.olg.ca/lotteries/viewPastNumbers.do" id="past">Past Winning Numbers</a></li>     <li><a href="http://www.olg.ca/lotteries/check_ticket.jsp" id="check">Have Your Numbers Ever Won?</a></li>     <li><a href="http://www.olg.ca/lotteries/number_frequency.jsp" id="frequency">Most Frequent Winning Numbers</a></li>     <li><a href="http://www.olg.ca/lotteries/draw_info_information.jsp" id="drawinfo">Draw Information</a></li>     <li><a href="http://www.olg.ca/lotteries/email_alerts.jsp" id="email">Sign Up for E-mail Alerts</a></li>                        <li><a href="http://www.olg.ca/mobile_alerts.html" id="email">Sign Up for Mobile Alerts</a></li>               </ul>   </div>    <div id="lotteriesNavContainer" class="font">   <ul>  <!-- Winners -->    <li><a href="http://www.olg.ca/lotteries/winners/index.jsp" id="winners" class="section">Recent Winners</a></li>   </ul>  </div>  <!-- Lottery Games -->    <div id="lotteriesNavContainer" class="font">    <ul>     <li><a href="http://www.olg.ca/lotteries/games/games.jsp?game=lotto" id="lotto" class="section">Lotto Games</a></li>    </ul>    </div>        <!-- INSTANT Games -->    <div id="lotteriesNavContainer" class="font">    <ul>     <li><a href="http://www.olg.ca/lotteries/games/games.jsp?game=instants" id="instants" class="section">Instant Games</a></li>    </ul>    </div>        <!-- How to buy -->  <div id="lotteriesNavContainer" class="font">   <ul>    <li><a href="http://proline.olg.ca/">Sports Games</a></li>  <!-- Group Play -->    <li><a href="http://www.olg.ca/lotteries/group_play/index.jsp" id="group" class="section">Group Play</a></li>    <li><a href="http://www.olg.ca/lotteries/guide/buying.jsp" id="buying" class="section">How To Buy Tickets</a></li>  <!-- How to check -->    <li><a href="http://www.olg.ca/lotteries/guide/checking.jsp" id="checking" class="section">How To Check Tickets</a>    </li>   </ul>  </div>    <!-- How to claim -->  <div id="lotteriesNavContainer" class="font">   <ul>    <li><a href="http://www.olg.ca/lotteries/guide/claiming.jsp" id="claiming" class="section">How To Claim Prizes</a>    </li>   </ul>  </div>    <div id="lotteriesNavContainer" class="font">   <ul>  <!-- Tickets and Receipts -->    <li><a href="http://www.olg.ca/lotteries/guide/about_tickets.jsp" id="tickets" class="section">Tickets and Receipts</a></li>  </ul>   </div>      <!-- Lotto 6/49 subscriptions -->  <div id="lotteriesNavContainer" class="font">   <ul>    <li><a href="https://secure.olg.ca/lotteries/lottoadvance.jsp" id="lottoadvance" class="section">Subscribe to LOTTO 6/49</a></li>  </ul>   </div>        <div id="lotteriesNavContainer" class="font">   <ul>  <!-- Watch the Draws -->    <li><a href="http://www.olg.ca/lotteries/draws.jsp" id="draws" class="section">Watch Lottery Draws</a></li>  <!-- Mobile Alerts -->                    <li><a href="https://www.olgmobile.ca/" id="mobile" class="section">Mobile Alerts</a></li>           <!-- Sign up for Email Alerts and E-newsletter -->    <li><a href="http://www.olg.ca/lotteries/email_alerts.jsp" id="email">E-mail Alerts &amp; Newsletters</a></li>  <!-- Lottery FAQ -->    <li style="border-width:1px 0 1px 0;"><a href="http://www.olg.ca/lotteries/faq.jsp" id="faq" class="section">FAQ</a></li>   </ul>  </div><br />  <div id="navContainerRG" class="font">   <ul>    <li><a href="http://www.olg.ca/lotteries/guide/responsible_play.jsp" id="responsible_play" class="section">Manage Your Play</a></li>    <li><a href="http://www.olg.ca/about/economic_benefits/index.jsp">OLG Gives Back</a></li>   </ul>  </div>      <div style="text-align:center;margin-top:20px;">   <a href="http://www.olg.ca/lotteries/guide/index.jsp"><img src="/assets/promotions/sign_your_ticket_tp.gif" width="140px" height="139px" border="0" alt="sign your ticket" title="" /></a><br /><br />   <img src="/assets/promotions/18_plus.png" width="140px" height="141px" border="0" alt="sign your ticket" title="" />  </div>  <script type="text/javascript" src="/js/menu.js"></script>  <script type="text/javascript">     var section = "numbers";     if(section == "responsible_play"){      var play=document.getElementById('responsible_play');     play.style.background="url(/assets/backgrounds/bkgrd_rgnav_over.jpg)";   }   highlightMenu("numbers", "#ffd609");   highlightMenu("", "#FF1C1F");   highlightMenu("", "#FF1C1F");   highlightMenu("", "#FF1C1F");  </script>      </td>    <td class="body_lotteries" width="590px" valign="top">        <a name="skip_menu"></a>     <div class="font">      <div class="normal">                              <img src="/assets/headers/hdr_title_lotteries_winnings.gif" width="410px" height="40px"   alt="Winnings" border="0" />  <br />  <br />  <!-- REGULAR PRIZE SHARES -->               <table class="font" id="lottery_border" width="570px" cellspacing="0" cellpadding="0" border="0">   
    [4] =>     <td width="410px">          <table class="font" id="lottery_border" width="410" cellspacing="0" cellpadding="0" border="0">     
    [5] =>       <td width="14px"><img src="/assets/headers/num_table_top_left_trans.gif" width="14px" height="14px" alt="" border="0" /><br />      </td>      <td width="382px" bgcolor="#ff9900"><img src="/assets/spacer.gif" width="1px" height="1px" alt="" border="0" /><br />      </td>      <td width="14px"><img src="/assets/headers/num_table_top_right_trans.gif" width="14px" height="14px" alt="" border="0" /><br />      </td>     </tr>     
    [6] =>       <th colspan="3" class="white_centre" id="lottery_borderless" align="left">&nbsp;05-Mar-2011       WINNINGS FOR      LOTTARIO            </th>     </tr>    </table>     <table class="font" id="lottery_border" width="410px" cellspacing="0" cellpadding="2" border="0">    
    [7] =>      <th class="white_centre" id="lottery_borderless" align="left">      Match</th>     <th class="white_centre" id="lottery_borderless" align="center">                                 Number of Winning Tickets Sold                  </th>     <th class="white_centre" id="lottery_borderless" align="right">     Prize</th>    </tr>   <!-- DISPLAY PRIZE SHARES -->                                            
    [8] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>6/6</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>1</strong></p>      </td>      <td id="lottery_border" align="right"><p class="blue"><strong>                                                                                       $368,371.00                                          </strong></p></td>     </tr>                                             
    [9] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>5/6 + Bonus</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>1</strong></p>      </td>      <td id="lottery_border" align="right"><p class="blue"><strong>                                                                                       $10,138.00                                          </strong></p></td>     </tr>                                             
    [10] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>5/6</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>32</strong></p>      </td>      <td id="lottery_border" align="right"><p class="blue"><strong>                                                                                       $1,114.70                                          </strong></p></td>     </tr>                                             
    [11] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>4/6</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>1867</strong></p>      </td>      <td id="lottery_border" align="right"><p class="blue"><strong>                                                                                       $31.80                                          </strong></p></td>     </tr>                                             
    [12] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>3/6</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>32210</strong></p>      </td>      <td id="lottery_border" align="right"><p class="blue"><strong>                                                                                       $5.00                                          </strong></p></td>     </tr>                                             
    [13] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>Early Bird</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>135</strong></p>      </td>      <td id="lottery_border" align="right"><p class="blue"><strong>                                                                                       $370.40                                          </strong></p></td>     </tr>         <!-- /DISPLAY PRIZE SHARES -->   </table>   <table width="410px" cellspacing="0" cellpadding="0" border="0">    
    [14] =>      <td width="14px"><img src="/assets/headers/num_table_btm_left_trans.gif" width="14px" height="14px" alt="" border="0" /><br />     </td>     <td width="382px" bgcolor="#ff9900"><img src="/assets/spacer.gif" width="1px" height="1px" alt="" border="0" /><br />     </td>     <td width="14px"><img src="/assets/headers/num_table_btm_right_trans.gif" width="14px" height="14px" alt="" border="0" /><br />     </td>    </tr>   </table>    <!-- DISPLAY PRIZE SHARES for Lotto Max supplementary draw -->         <!--/ DISPLAY PRIZE SHARES for Lotto Max supplementary draw -->            <!-- DISPLAY PRIZE SHARES for Lotto Max Promotion draw -->         <!--/ DISPLAY PRIZE SHARES for Lotto Max promition draw -->       <!-- DISPLAY PRIZE SHARES for Instant draw -->         <!-- /Instant PRIZE SHARES -->       <!-- /REGULAR PRIZE SHARES -->  <!-- ENCORE PRIZE SHARES -->     <br />   <br />   <table class="font" id="lottery_border" width="410px" cellspacing="0" cellpadding="0" border="0">    
    [15] =>      <td width="14px"><img src="/assets/headers/num_table_top_left_trans.gif" width="14px" height="14px" alt="" border="0" /><br />     </td>     <td width="382px" bgcolor="#ff9900"><img src="/assets/spacer.gif" width="1px" height="1px" alt="" border="0" /><br />     </td>     <td width="14px"><img src="/assets/headers/num_table_top_right_trans.gif" width="14px" height="14px" alt="" border="0" /><br />     </td>    </tr>    
    [16] =>      <th colspan="3" class="white_centre" id="lottery_borderless" align="left">&nbsp;     WINNINGS FOR ENCORE</th>    </tr>   </table>   <table class="font" id="lottery_border" width="410px" cellspacing="0" cellpadding="2" border="0">    
    [17] =>      <th class="white_centre" id="lottery_borderless" align="left">     Match</th>     <th class="white_centre" id="lottery_borderless" align="center">     Number of Winning Tickets Sold</th>     <th class="white_centre" id="lottery_borderless" align="right">     Prize</th>    </tr>    <!-- DISPLAY PRIZE SHARE INFO FOR ENCORE -->                                            
    [18] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>8105376</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>0</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$1,000,000.00</strong></p>                                                                   </td>     </tr>                                            
    [19] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>_105376</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>2</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$100,000.00</strong></p>                                                                   </td>     </tr>                                            
    [20] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>__05376</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>8</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$1,000.00</strong></p>                                                                   </td>     </tr>                                            
    [21] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>___5376</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>79</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$100.00</strong></p>                                                                   </td>     </tr>                                            
    [22] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>____376</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>1088</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$10.00</strong></p>                                                                   </td>     </tr>                                            
    [23] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>_____76</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>10236</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$5.00</strong></p>                                                                   </td>     </tr>                                            
    [24] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>______6</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>102934</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$2.00</strong></p>                                                                   </td>     </tr>                                            
    [25] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>810537_</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>0</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$10,000.00</strong></p>                                                                   </td>     </tr>                                            
    [26] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>81053__</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>11</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$500.00</strong></p>                                                                   </td>     </tr>                                            
    [27] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>8105___</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>85</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$50.00</strong></p>                                                                   </td>     </tr>                                            
    [28] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>810____</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>945</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$10.00</strong></p>                                                                   </td>     </tr>                                            
    [29] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>81_____</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>9302</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$5.00</strong></p>                                                                   </td>     </tr>                                            
    [30] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>81053_6</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>0</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$502.00</strong></p>                                                                   </td>     </tr>                                            
    [31] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>8105_76</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>1</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$55.00</strong></p>                                                                   </td>     </tr>                                            
    [32] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>8105__6</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>8</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$52.00</strong></p>                                                                   </td>     </tr>                                            
    [33] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>810_376</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>0</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$20.00</strong></p>                                                                   </td>     </tr>                                            
    [34] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>810__76</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>8</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$15.00</strong></p>                                                                   </td>     </tr>                                            
    [35] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>810___6</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>85</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$12.00</strong></p>                                                                   </td>     </tr>                                            
    [36] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>81_5376</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>1</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$105.00</strong></p>                                                                   </td>     </tr>                                            
    [37] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>81__376</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>7</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$15.00</strong></p>                                                                   </td>     </tr>                                            
    [38] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>81___76</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>95</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$10.00</strong></p>                                                                   </td>     </tr>                                            
    [39] =>       <td id="lottery_border" width="128px">      <p class="blue"><strong>81____6</strong></p>      </td>      <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>910</strong></p>      </td>      <td id="lottery_border" align="right">      <p class="blue"><strong>$7.00</strong></p>                                                                   </td>     </tr>        <!-- /DISPLAY PRIZE SHARE INFO FOR ENCORE -->   </table>   <table width="410px" cellspacing="0" cellpadding="0" border="0">    
    [40] =>      <td width="14px"><img src="/assets/headers/num_table_btm_left_trans.gif" width="14px" height="14px" alt="" border="0" /><br />     </td>     <td width="382px" bgcolor="#ff9900"><img src="/assets/spacer.gif" width="1px" height="1px" alt="" border="0" /><br />     </td>     <td width="14px"><img src="/assets/headers/num_table_btm_right_trans.gif" width="14px" height="14px" alt="" border="0" /><br />     </td>    </tr>   </table>    <!-- /ENCORE PRIZE SHARES -->    </td>    <td width="160px" valign="top">                                                 </td>     </tr>    </table>   <!-- ADDITIONAL ENCORE PRIZE PAYOUT INFO -->  <p class="grey">               For complete information on the ENCORE Prize Payout, see the <a class="lottery" href="/lotteries/games/new_encore.jsp">Odds &#38; Prizes</a> or visit an OLG lottery retail outlet. Ask the retailer for a printout of the information or call OLG's Customer Excellence Centre at 1-800-387-0098.            </p>  <a class="lottery" href="javascript:history.back()">     Back to draw results   </a>  <!-- /ADDITIONAL ENCORE PRIZE PAYOUT INFO -->  <!-- DISCLAIMER -->  <p class="grey">          DISCLAIMER      <br/>The numbers that appear on this site do not constitute official winning numbers. Please contact your participating retailer for confirmation.<br/>        </p>  <!-- /DISCLAIMER -->        </div>     </div>    </td>    <td width="33%" rowspan="2"></td>   </tr>   
    [41] =>     <td bgcolor="#052261" width="160px">     <img src="/assets/spacer.gif" alt="" width="160px" height="1px" /><br />    </td>    <td bgcolor="#052261" width="590px">     <img src="/assets/spacer.gif" alt="" width="590px" height="1px" /><br />    </td>   </tr>  </table>    <!-- /content table -->  <!-- footer table -->  <table cellspacing="0" cellpadding="0" border="0" width="100%" height="115px">   
    [42] =>     <td width="33%" rowspan="2"></td>    <td align="center" bgcolor="#ffffff" width="750px">     <div class="font">      <div class="normal">                              <script language="JavaScript" src="/js/funcs.js"></script>  <form name="languageForm" method="post" action="/changeLanguage.do">   <p class="grey" style="text-align:center;margin-bottom:0;"><a class="grey" href="http://www.olg.ca/contact.jsp">Contact Us</a> | <a class="grey" href="http://www.olg.ca/about/careers/index.jsp">Careers</a> | <a class="grey" href="http://www.olg.ca/about/play_safe/index.jsp">Consumer Protection</a> | <a class="grey" href="http://www.olg.ca/site_map.jsp">Site Map</a> | <a class="grey" href="javascript:submit();" onmouseover="this.style.cursor='hand'" onmouseout="this.style.cursor='default'">Fran?ais</a></p>   <img style="float:left;margin:20px 0 0 10px;" src="/assets/logos/olg/footer_know_your_limit.png" alt="Know your limit play within it" border="0" />   <p class="grey" id="small" style="margin-top:20px;padding-top:0;text-align:center;">    <img style="float:right;margin:-23px 0 0 0;" src="/assets/logos/olg/footer_olg.png" width="79px" height="63px" alt="O L G" border="0" />    This Web site is for the use of consumers in Ontario, who meet the minimum age requirements <br />(at least 18 years of age in the case of lottery and bingo, and 19 years of age in the case of gaming).<a class="about" href="http://www.olg.ca/legal.jsp">Terms of Use</a></p>   <p class="grey" style="text-align:center;margin-top:0;"><a class="grey" href="http://www.olg.ca/privacy.jsp">Privacy</a> | <a class="grey" href="http://www.gov.on.ca/MBS/english/common/privacy.html" target="_blank">Government of Ontario Privacy Policy</a> | <a class="grey" href="http://www.olg.ca/security.jsp">Security</a> | <a class="grey" href="http://www.olg.ca/accessibility.jsp">Accessibility</a> | <a class="grey" href="http://www.olg.ca/legal.jsp">Legal</a></p>   <p class="grey" id="small" style="text-align:center;">? 2011 Ontario Lottery and Gaming Corporation</p>   <input type="hidden" name="language" value="en">  </form>  <p class="grey" align="right">Text Size : <a style="font-size:.7em" class="lottery" href="#" onclick="setActiveStyleSheet('minusstyle'); return false;">A</a><a class="lottery" href="#" onclick="setActiveStyleSheet('normstyle'); return false;">A</a><a style="font-size:1.3em" class="lottery" href="#" onclick="setActiveStyleSheet('plusstyle'); return false;">A</a></p>      </div>     </div>    </td>    <td width="33%" rowspan="2"></td>   </tr>   
    [43] =>     <td width="750px">     <img src="/assets/spacer.gif" alt="" width="750px" height="1px" /><br />    </td>   </tr>  </table>  <!-- /footer table -->  </body>
       * 
       * 
       */ 
      
      
      $sLot_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong .  "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" .  $srgE_td;
      $sLot_td_Lines .=  "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      $sLot_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      
      /*
       * <td id="lottery_border" width="128px">      <p class="blue"><strong>6/6</strong></p>      </td>
       *       <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>1</strong></p>      </td>
       *       <td id="lottery_border" align="right"><p class="blue"><strong>                                                                                       $368,371.00                                          </strong></p></td>
       * */
      
      
      /*
      $s649_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p  . "\s*" .  $srgE_td;               // Match
      $s649_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p  . "\s*" .  $srgE_td;      // Number of winnings
      $s649_td_Lines .= "\s*" . $srgB_td  . "\s*" .  $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p  . "\s*" .  $srgE_td;      // Prize
      */
      
      $sEncore_th_Line = $srgB_th . "(.*?)" . $srgE_th;               // Match
      $sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Number of Winners
      $sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Prize
      
      
      /*
       *    <th class="white_centre" id="lottery_borderless" align="left">     Match</th>
       *      <th class="white_centre" id="lottery_borderless" align="center">     Number of Winning Tickets Sold</th>
       *      <th class="white_centre" id="lottery_borderless" align="right">     Prize</th>  
       * 
       * 
       */
      
      $sEncore_td_Line = $srgB_td    . "\s*" .  $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;               // Match
      $sEncore_td_Line .= "\s*" . $srgB_td  . "\s*" .   $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;      // Number of Winners
      $sEncore_td_Line .= "\s*" . $srgB_td   . "\s*" .  $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;      // Prize
      
      
      /*
       * <td id="lottery_border" width="128px">      <p class="blue"><strong>8105376</strong></p>      </td>
       *       <td id="lottery_border" width="134px" align="center">      <p class="blue"><strong>0</strong></p>      </td>
       *       <td id="lottery_border" align="right">      <p class="blue"><strong>$1,000,000.00</strong></p>            </td>
       *      </tr>       
       * 
       * 
       */
       if ($debug_mode > 0) {
          print "\nFetch " . $site_file . $site_querystr;
          print "\nDate: " . date('Y-m-d', $drawdate);
       }    
        
      
      $str_money_sym = array("$",","); 
      
      foreach ($html_tr_list as $html_tr) {
        if (preg_match("/". $srg_649_Winning_Hdr . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
          $sLottario_m     = 1;
          $sEncore_m  = 0;
        } elseif (preg_match("/" . $srg_encore_Winning_Hdr . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
          $sLottario_m     = 0;
          $sEncore_m  = 1;
        } elseif ($sLottario_m == 1 &&
                  preg_match("/" . $sLot_th_Lines . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
           
        } elseif ($sLottario_m == 1 &&
                  preg_match("/" . $sLot_td_Lines . "/i", $html_tr, $lmatches)) {
          //print_r ($lmatches);   
          
          if (preg_match("/6\/6/i", $lmatches[1],$lot_mat_)) {
            $m_6_6_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $m_6_6_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m_6_6_prze_amt, $objLottery->prz_money, $onLottario_row["gameid"]);
            if (!$m_6_6_prze_id) {
              $m_6_6_prze_id = $objLottery->dbLotteryWinPrizesAdd($m_6_6_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onLottario_row["gameid"]);
            }
            $m_6_6_win_count = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[m6of6|" . $m_6_6_prze_amt . "|" . $m_6_6_prze_id . "]";
            }
            
          } elseif (preg_match("/5\/6 \+ Bonus/i", $lmatches[1], $lot_mat_)) {
            $m_5_6B_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $m_5_6B_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m_5_6B_prze_amt, $objLottery->prz_money, $onLottario_row["gameid"]);
            if (!$m_5_6B_prze_id) {
              $m_5_6B_prze_id = $objLottery->dbLotteryWinPrizesAdd($m_5_6B_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onLottario_row["gameid"]);
            }
            $m_5_6B_win_count = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[m5of6B|" . $m_5_6B_prze_amt . "|" . $m_5_6B_prze_id . "]";
            }
              
          } elseif (preg_match("/5\/6/i", $lmatches[1], $lot_mat_)) {
            $m_5_6_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $m_5_6_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m_5_6_prze_amt, $objLottery->prz_money, $onLottario_row["gameid"]);
            if (!$m_5_6_prze_id) {
              $m_5_6_prze_id = $objLottery->dbLotteryWinPrizesAdd($m_5_6_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onLottario_row["gameid"]);
            }
            $m_5_6_win_count = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[m5of6|" . $m_5_6_prze_amt . "|" . $m_5_6_prze_id . "]";
            }
            
            
            
          } elseif (preg_match("/4\/6/i", $lmatches[1], $lot_mat_)) {
            $m_4_6_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $m_4_6_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m_4_6_prze_amt, $objLottery->prz_money, $onLottario_row["gameid"]);
            if (!$m_4_6_prze_id) {
              $m_4_6_prze_id = $objLottery->dbLotteryWinPrizesAdd($m_4_6_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onLottario_row["gameid"]);
            }
            $m_4_6_win_count = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[m4of6|" . $m_4_6_prze_amt . "|" . $m_4_6_prze_id . "]";
            }    
            
            
          } elseif (preg_match("/3\/6/i", $lmatches[1], $lot_mat_)) {
            $m_3_6_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $m_3_6_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m_3_6_prze_amt, $objLottery->prz_money, $onLottario_row["gameid"]);
            if (!$m_3_6_prze_id) {
              $m_3_6_prze_id = $objLottery->dbLotteryWinPrizesAdd($m_3_6_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onLottario_row["gameid"]);
            }
            $m_3_6_win_count = trim($lmatches[2]);
            
            if ($debug_mode > 1) {
              print "[m3of6|" . $m_3_6_prze_amt . "|" . $m_3_6_prze_id . "]";
            }
            
            
            
            
          } elseif (preg_match("/Early Bird/i", $lmatches[1], $lot_mat_)) {
            $m_eb_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $m_eb_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m_eb_prze_amt, $objLottery->prz_money, $onLottario_row["gameid"]);
            if (!$m_eb_prze_id) {
              $m_eb_prze_id = $objLottery->dbLotteryWinPrizesAdd($m_eb_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onLottario_row["gameid"]);
            }
            $m_eb_win_count = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[eb|" . $m_eb_prze_amt . "|" . $m_eb_prze_id . "]";
            }
            
            $sLottario_drawdate = strtotime($sdrawdate);
            $sLottario_drawdate = date('Y-m-d', $sLottario_drawdate);
            //print "\nLottario Draw Date: " . $sLottario_drawdate;
            $onLottarioId       = $objOLG->OLGLottarioGetDrawId($sLottario_drawdate);
            $onEarlyBirdId      = $objOLG->OLGEarlyBirdGetDrawId($sLottario_drawdate);
            //print "\nLotID : " . $onLottarioId . " EB ID: " . $onEarlyBirdId;
            
            if ($onLottarioId != null) {
              $onLottarioWinningId = $objOLG->OLGLottarioWinningsGetId($onLottarioId);
              if (!$onLottarioWinningId) {
                  $onLottarioWinningId = $objOLG->OLGLottarioWinningsAdd($onLottarioId,
                    $m_6_6_win_count,$m_6_6_prze_id,"",
                    $m_5_6B_win_count,$m_5_6B_prze_id,"",
                    $m_5_6_win_count,$m_5_6_prze_id,$m_4_6_win_count,$m_4_6_prze_id,$m_3_6_win_count,
                    $m_3_6_prze_id,$onEarlyBirdId,$m_eb_win_count,$m_eb_prze_id,
                    0);
              }
            }
            if ($debug_mode > 1) {
              print "[L: " . $onLottarioId . "][" . $onEarlyBirdId . "]";
            }
            
          }
          
        } elseif ($sEncore_m == 1 &&
                  preg_match("/" . $sEncore_th_Line . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);   
          $arEncore_th = array();    
          $inEncore_th = 0;          
        } elseif ($sEncore_m == 1 &&
                  preg_match("/" . $sEncore_td_Line . "/i", $html_tr, $lmatches)) {
             // print_r($lmatches); 
           $arEncore_th[$inEncore_th] = $lmatches;
           $inEncore_th++;
        }
        
      }
      if (is_array($arEncore_th)) {
        $OLGData = new OLGData();
        $OLGData->OLGEncoreParse($arEncore_th, strtotime($sdrawdate), $debug_mode);
      }
      
          
    
  }
  
  ?>