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
  include_once("../inc/incOLGLottery.php");
  include_once("../inc/incLottery.php");
  include_once("../inc/class_http.php");
  include_once("../inc/incOLGData.php");
  
  include_once("phpArguments.php");
  
  $objLottery = new Lottery();
  $objOLG     = new OLGLottery();
  
  // Debug Mode
  // 0 = verbose disabled
  // 1 = verbose enabled
  // 2 = verbose extra info
  
  
  $debug_mode         = 2;
  
  
  // Implement php arguments
  
  $cmdargs = arguments();
 
  
  
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^update/i", $cmdargs["standard"][1], $lmatches)) {
  		$lottery_draw_data_dates = $objOLG->OLG49GetFirstLastDataAvail();
  		$startDay 	= date('d',strtotime($lottery_draw_data_dates["latest"]));
  		$startMonth = date('m',strtotime($lottery_draw_data_dates["latest"]));
  		$startYear 	= date('Y',strtotime($lottery_draw_data_dates["latest"]));
  		$endDay 	= date('d');
  		$endMonth 	= date('m');
  		$endYear    = date('Y');
  		$startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
		$endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);  		
  		$drawDates = $objLottery->dbLotteryGetDrawDates("na649", "MM", $startDate, $endDate); 
  		
  	} elseif (preg_match("/^getMonth/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  			$selectedMonth = $lmatches[1];
      	  	$selectedYear = $lmatches[2];
      	  	$startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      	    $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      	  	$drawDates = $objLottery->dbLotteryGetDrawDates("na649", "MM", $startDate, $endDate); 
  		}
  	} elseif (preg_match("/^getYear/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{4})|(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		      $selectedYear = $lsubmat[1];
      	  	  $startDate    = mktime(0,0,0,1,1,$selectedYear);
      	  	  $endDate      = mktime(0,0,0,12,31,$selectedYear);
      	  	  $drawDates = $objLottery->dbLotteryGetDrawDates("na649", "YY", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/^getDraw/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		    //print_r($lmatches); 
      	  	$selectedDay    = $lsubmat[1];
      	  	$selectedMonth  = $lsubmat[2];
      	  	$selectedYear   = $lsubmat[3];
      	  	$startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$drawDates = $objLottery->dbLotteryGetDrawDates("na649", "DD", $startDate, $endDate);
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
      	$drawDates = $objLottery->dbLotteryGetDrawDates("na649", "DD1DD2", $startDate, $endDate);
  	}
  	
  	   	   //print_r($drawDates);
   	  if (is_array($drawDates)) {
     	  foreach ($drawDates as $dtDate) {
             // 20090211
             $drawDate = strtotime($dtDate);
             //print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
             //print_r($dtDate);
             //alc_fetch_single_draw(date('d-m-Y',$drawDate));
             on_fetch_first_step_49(date('d-m-Y', $drawDate));
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
      	  	  $drawDates = $objLottery->dbLotteryGetDrawDates("na649", "DD1DD2", $startDate, $endDate);
    	  } elseif (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
       	  	  //print_r($lmatches); 
      	  	  $selectedDay    = $lmatches[1];
      	  	  $selectedMonth  = $lmatches[2];
      	  	  $selectedYear   = $lmatches[3];
      	  	  $startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	  $endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	  $drawDates = $objLottery->dbLotteryGetDrawDates("na649", "DD", $startDate, $endDate);
    	 } elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
      	  	  $selectedMonth = $lmatches[1];
      	  	  $selectedYear = $lmatches[2];
      	  	  $startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      	  	  $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      	  	  $drawDates = $objLottery->dbLotteryGetDrawDates("na649", "MM", $startDate, $endDate);    
    	} elseif (preg_match("/getYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
      	  	  $selectedYear = $lmatches[1];
      	  	  $startDate    = mktime(0,0,0,1,1,$selectedYear);
      	  	  $endDate      = mktime(0,0,0,12,31,$selectedYear);
      	  	  $drawDates = $objLottery->dbLotteryGetDrawDates("na649", "YY", $startDate, $endDate);
    	}
      
   	   //print_r($drawDates);
   	  if (is_array($drawDates)) {
     	  foreach ($drawDates as $dtDate) {
             // 20090211
             $drawDate = strtotime($dtDate);
             //print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
             //print_r($dtDate);
             //alc_fetch_single_draw(date('d-m-Y',$drawDate));
             on_fetch_first_step_49(date('d-m-Y', $drawDate));
          }
      }    
    
     } while (trim($selection) != 'q');
  	}
  
    function on_fetch_first_step_49($drawdate = "") {
      
        global $debug_mode;
        
        $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
        $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
        $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
        
        $objLottery   = new Lottery();
        $objDate      = new GenDates();
        $objOLG       = new OLGLottery();
        $naLottery    = new NALottery();
        $na49_row     = $objLottery->dbLotteryGamesGet("na49");
        $onEncore_row = $objLottery->dbLotteryGamesGet("onEncore"); 
    
        //print "\n\n" . $drawdate . " --- " ;
        $drawdate = strtotime($drawdate);
        //print  date('mY', $drawdate);
        
        $on49GameId       = 13;
        
        if ($drawdate == "") {
          
            $hp_selectedMonthYear = date('mY',mktime(0,0,0,date('m') - 1,date('d'),date('Y')));
        } else {
  
            $hp_selectedMonthYear = date('mY', mktime(0,0,0,date('m',$drawdate) - 1, date('d', $drawdate), date('Y', $drawdate)));
        }
        
        $hp_day                   = 0;
        $hp_gameID               = $on49GameId;
        $hp_command              = 'submit';
    
        $on49_row = $objLottery->dbLotteryGamesGet("on49");
        
        
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
          /*print_r($lmatches);
          print "\nSiteDomain: " . $site_domain_id;
          print "\nSitePath  : " . $site_path_id;
          print "\nSiteFile  : " . $site_file_id;
          print "\nSitePost : " . $site_post_id;
          print "\n" . $site_post_str;
           */ 
                 
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("on49", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($on49_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("on49", $on49_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("on49", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
        
        $on49GameId       = 13;
        
        $http->postvars['selectedMonthYear']    = $hp_selectedMonthYear;
        $http->postvars['day']                  = $hp_day;
        $http->postvars['gameID']               = $hp_gameID;
        $http->postvars['command']              = 'submit';
        if (!$http->fetch($url_step2)) {
          $status_msg = "...";
        } else {
          //print_r($http->body);
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
        //print_r($html_tr_list);
        //print_r($html_body);
        $bOn49_m    = 0;
        
        $srg_49          = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
        $srg_onEncore     = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
        $srg_bonusnum     = "\s*(\d{2})\s*";
        
        $s49_th_Line     = $srgB_th . "(.*?)" . $srgE_th;        // Date
        $s49_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Day
        $s49_th_Line     .= "\s*" . $srgB_th . "(.*?)" ;                 // Numbers
        $s49_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Bonus
        $s49_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // ENCORE
        $s49_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // WINNINGS
        
        $s49_td_Line     = $srgB_td . "(.*?)"  . $srgE_td;        // Date
        $s49_td_Line     .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day
        $s49_td_Line     .= "\s*" . $srgB_td .   "(.*?)" . $srg_comment;   // Numbers
        $s49_td_Line     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Bonus
        $s49_td_Line     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Encore
        $s49_td_Line     .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings
        
        $srgDays          = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
        $srgMonths        = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
        
        if ($debug_mode > 0) {
          print "\nFetch " . $site_file . $site_querystr;
          print "\nDate: " . date('Y-m-d', $drawdate);
        }    
        
        //print_r ($html_tr_list);
        
        foreach ($html_tr_list as $html_tr) {
          if (preg_match("/" . $s49_th_Line . "/i", $html_tr, $lmatches)) {
            $bOn49_m  = 1;
            //print_r($lmatches);
          } elseif ($bOn49_m == 1 &&
                   (preg_match("/" . $s49_td_Line . "/i", $html_tr, $lmatches))) {
              //print_r($lmatches);
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
                //print_r($lotResMat);  
                
                $sdrawMonthName = trim($lotResMat[2]);
                $sdrawMonthNum  = $objDate->getShortMonthNum($sdrawMonthName);
                $sdrawDay       = $lotResMat[1];
                $sdrawYear      = $lotResMat[3];
                $s49_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
                //print "\n49DrawDate: " . $s49_drawdate;
                if ($debug_mode > 1) {
                  print "\n[" . $s49_drawdate . "] ";
                }                 
              }
              if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\w{3})\s*" . $srgE_strong. $srgE_p . "/i",$lmatches[2], $lotResMat)) {
                //print_r($lotResMat);
                $sdrawDayName   = trim($lotResMat[1]);
              }
              $s49Res = preg_replace("/<[^>]*]|\s{2}/i", " ", $lmatches[3]);
              if (preg_match("/" . $srg_49 . "/i", $s49Res, $lotResMat)) {
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
               if (preg_match("/" . $srgB_p . $srgB_strong . $srg_bonusnum . $srgE_strong . $srgE_p . "/i", $lmatches[4], $lotResMat)) {
                //print_r($lotResMat);
                $snumBonus  = $lotResMat[1]; 
                if ($debug_mode > 1) {       
                  print "[B" . $snumBonus . "]";         
                }
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
                //print_r($lotResMat);
                
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
                
                    // INSERT Into Database
               $s49_drawdate = strtotime($s49_drawdate);
               $s49_drawdate = date('Y-m-d', $s49_drawdate);
               $on49DrawId = $objOLG->OLG49GetDrawId($s49_drawdate);
               //printf("\nstr_gameid : %u - str_drawNo: %u - str_drawDate : %u - str_spieldId : %u", $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
               //print "\nParse " . $s49_drawdate;
               if (!$on49DrawId) {

                 $on49DrawId = $objOLG->OLG49Add($s49_drawdate, 0, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumBonus, "on" , $str_drawNo, $str_drawDate, $str_spielId);
               
               }
               if ($debug_mode > 1) {
                 print "[SD- ID " . $on49DrawId . "]";
               } 
               $sEncore_date = $s49_drawdate;
               $str_onEncoreId = $objOLG->OLGEncoreGetDrawId($sEncore_date);
               if (!$str_onEncoreId) {
                
                 $str_onEncoreId = $objOLG->OLGEncoreAdd($sEncore_date, "", $senc_num1, $senc_num2, $senc_num3, $senc_num4, $senc_num5, $senc_num6, $senc_num7);
                  
               }
               
               if ($on49DrawId != null) {
               
               		$on49WinningId = $objOLG->OLG49WinningsGetId($on49DrawId);
               		if (!$on49WinningId) {
		               on_fetch_second_step_49($s49_drawdate, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);			
               		}
               
               }
               
               
               
               if ($debug_mode > 1) {
                 print "\n[" . $s49_drawdate . "]";
               
                 print "[SD - ENC " . $str_onEncoreId . "]";
               }
               //print " \n\nDraw Date : " . $s49_drawdate . "\n";
               
              }
          }
        }
             
     
      
    }
    
    function on_fetch_second_step_49($sdrawdate, $str_gameid, $str_drawNo, $str_drawdate, $str_spielid) {
  
        global $debug_mode;
  
        $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
        $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
        $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
        
        $objLottery = new Lottery();
        $objDate    = new GenDates();
        $objOLG     = new OLGLottery();
        $naLottery  = new NALottery();
        $on49_row     = $objLottery->dbLotteryGamesGet("on49");
        $onEncore_row = $objLottery->dbLotteryGamesGet("onEncore"); 
    
      
        $drawdate = strtotime($sdrawdate);
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
            $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("on49", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
            if (!$fetch_stats_id) {
              $fetch_date = date('Y-m-d H:i:s');
              $fetch_pos = 0;
              $fetch_process_suc = 0;
              //print_r($na649_row);
              // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
              $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("on49", $on49_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
              $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
             } else {
              $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("on49", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
        
        
        $on49GameId    = 13;
        
        $http->postvars['gameID']     = $on49GameId;
        $http->postvars['drawNo']     = $str_drawNo;
        $http->postvars['sdrawDate']  = $str_drawdate;
        $http->postvars['spielID']    = $str_spielid;
        
        
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
        
        $s49_m     = 0;
        $sEncore_m  = 0;
        
        $srg_49_Winning_Hdr = "WINNINGS FOR \s* ONTARIO 49";  //WINNINGS FOR ONTARIO 49
        $srg_encore_Winning_Hdr = "WINNINGS FOR ENCORE";
        
        
        $srgDays    = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
        $srgMonths  = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
        
        
        $s49_th_Lines  = $srgB_th . "(.*?)" . $srgE_th;            // Match
        $s49_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Number of Winnings 
        $s49_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Prize
        
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
        
        $s49_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong .  "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" .  $srgE_td;
        $s49_td_Lines .=  "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
        $s49_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
        
        /*
        $s49_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p  . "\s*" .  $srgE_td;               // Match
        $s49_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p  . "\s*" .  $srgE_td;      // Number of winnings
        $s49_td_Lines .= "\s*" . $srgB_td  . "\s*" .  $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p  . "\s*" .  $srgE_td;      // Prize
        */
        
        $sEncore_th_Line = $srgB_th . "(.*?)" . $srgE_th;               // Match
        $sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Number of Winners
        $sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Prize
        
        $sEncore_td_Line = $srgB_td    . "\s*" .  $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;               // Match
        $sEncore_td_Line .= "\s*" . $srgB_td  . "\s*" .   $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;      // Number of Winners
        $sEncore_td_Line .= "\s*" . $srgB_td   . "\s*" .  $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;      // Prize
        
            
        $str_money_sym = array("$",","); 
        
        if ($debug_mode > 0) {
          print "\nFetch " . $site_file . $site_post_str;
          print "\nDate: " . date('Y-m-d', $drawdate);
        }    
        
        
        foreach ($html_tr_list as $html_tr) {
          if (preg_match("/". $srg_49_Winning_Hdr . "/i", $html_tr, $lmatches)) {
            //print_r($lmatches);
            $s49_m     = 1;
            $sEncore_m  = 0;
          } elseif (preg_match("/" . $srg_encore_Winning_Hdr . "/i", $html_tr, $lmatches)) {
            //print_r($lmatches);
            $s49_m     = 0;
            $sEncore_m  = 1;
          } elseif ($s49_m == 1 &&
                    preg_match("/" . $s49_th_Lines . "/i", $html_tr, $lmatches)) {
            //print_r($lmatches);
             
          } elseif ($s49_m == 1 &&
                    preg_match("/" . $s49_td_Lines . "/i", $html_tr, $lmatches)) {
            //print_r ($lmatches);   
            
           if (trim($lmatches[1]) == "6/6") {
            $s6of6_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $s6of6_prze_id  = $objLottery->dbLotteryWinPrizesGetId($s6of6_prze_amt, $objLottery->prz_money, $on49_row["gameid"]);
            if (!$s6of6_prze_id) {
              $s6of6_prze_id = $objLottery->dbLotteryWinPrizesAdd($s6of6_prze_amt, $objLottery->prz_money, trim($lmatches[3]),  $on49_row["gameid"]);
            }
            $s6of6_win_count  = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[m6of6|" . $s6of6_prze_amt . "|" . $s6of6_prze_id . "]";
            }
          } elseif (trim($lmatches[1]) == "5/6 + Bonus") {
            $s5of6B_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $s5of6B_prze_id  = $objLottery->dbLotteryWinPrizesGetId($s5of6B_prze_amt, $objLottery->prz_money, $on49_row["gameid"]);
            if (!$s5of6B_prze_id) {
              $s5of6B_prze_id = $objLottery->dbLotteryWinPrizesAdd($s5of6B_prze_amt, $objLottery->prz_money, trim($lmatches[3]),  $on49_row["gameid"]);
            }
            $s5of6B_win_count  = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[m5of6B|" . $s5of6B_prze_amt . "|" . $s5of6B_prze_id . "]";
            }
          } elseif (trim($lmatches[1]) == "5/6") {
            $s5of6_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $s5of6_prze_id  = $objLottery->dbLotteryWinPrizesGetId($s5of6_prze_amt, $objLottery->prz_money, $on49_row["gameid"]);
            if (!$s5of6_prze_id) {
              $s5of6_prze_id = $objLottery->dbLotteryWinPrizesAdd($s5of6_prze_amt, $objLottery->prz_money,  trim($lmatches[3]), $on49_row["gameid"]);
            }
            $s5of6_win_count  = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[m5of6|" . $s5of6_prze_amt . "|" . $s5of6_prze_id . "]";
            }
          } elseif (trim($lmatches[1]) == "4/6") {
            $s4of6_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $s4of6_prze_id  = $objLottery->dbLotteryWinPrizesGetId($s4of6_prze_amt, $objLottery->prz_money, $on49_row["gameid"]);
            if (!$s4of6_prze_id) {
              $s4of6_prze_id = $objLottery->dbLotteryWinPrizesAdd($s4of6_prze_amt, $objLottery->prz_money,  trim($lmatches[3]), $on49_row["gameid"]);
            }
            $s4of6_win_count  = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[m4of6|" . $s4of6_prze_amt . "|" . $s4of6_prze_id . "]";
            }          
          } elseif (trim($lmatches[1]) == "3/6") {
            $s3of6_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $s3of6_prze_id  = $objLottery->dbLotteryWinPrizesGetId($s3of6_prze_amt, $objLottery->prz_money, $on49_row["gameid"]);
            if (!$s3of6_prze_id) {
              $s3of6_prze_id = $objLottery->dbLotteryWinPrizesAdd($s3of6_prze_amt, $objLottery->prz_money, trim($lmatches[3]),  $on49_row["gameid"]);
            }
            $s3of6_win_count  = trim($lmatches[2]);
            if ($debug_mode > 1) {
              print "[m3of6|" . $s3of6_prze_amt . "|" . $s3of6_prze_id . "]";
            }
            $s49_drawDate = strtotime($sdrawdate);
            $on49DrawId = $objOLG->OLG49GetDrawId(date('Y-m-d',$s49_drawDate));
            //print "\nParse Winning " . $sdrawdate;
            if ($on49DrawId != null) {
              $on49WinningId = $objOLG->OLG49WinningsGetId($on49DrawId);
              //print "\non49WinningId : " . $on49WinningId . " - on49Id: " . $on49DrawId;
              if (!$on49WinningId) {
                $on49WinningId = $objOLG->OLG49WinningsAdd($on49DrawId,$s6of6_win_count,$s6of6_prze_id,
                                          $s5of6B_win_count, $s5of6B_prze_id, $s5of6_win_count, $s5of6_prze_id,
                                          $s4of6_win_count, $s4of6_prze_id, $s3of6_win_count, $s3of6_prze_id,
                                          0);
                //print "\nSD - Winning " . $on49WinningId;
               }
            /*    print "\nDraw Detail: ID: " . $na649DrawId;
                print " Win 6of6: " . $s6of6_win_count . " " . $s6of6_prze_amt . " " . $s6of6_prze_id; 
                print " 5of6 : " .  $s5of6B_win_count . " " .  $s5of6B_prze_amt . " " . $s5of6B_prze_id;
                print " 5of6: " .  $s5of6_win_count . " " .  $s5of6_prze_amt . " " . $s5of6_prze_id;
                print " 4of6 Cnt: " . $s4of6_win_count . " " .  $s4of6_prze_amt . " " . $s4of6_prze_id;
                print " 3 of 6 cnt: " .  $s3of6_win_count . " " .  $s3of6_prze_amt . " " . $s3of6_prze_id; 
                print " 2 of 6 cnt: " . $s3of6B_win_count . " " .  $s2of6B_prze_amt . " " . $s2of6B_prze_id; 
           
             * 
             */
            } 
            if ($debug_mode > 1) {
              print "[" . $on49WinningId . "]";
            }
          } 
            
            
            
          } elseif ($sEncore_m == 1 &&
                    preg_match("/" . $sEncore_th_Line . "/i", $html_tr, $lmatches)) {
            //print_r($lmatches);            
            
            $arEncore_th = array();    
            $inEncore_th = 0;   
          } elseif ($sEncore_m == 1 &&
                    preg_match("/" . $sEncore_td_Line . "/i", $html_tr, $lmatches)) {
            //print_r($lmatches);     
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