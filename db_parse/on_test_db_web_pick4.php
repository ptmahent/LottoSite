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
    // Debug Mode
    
  include_once("phpArguments.php");
  // 0 = verbose disabled
  // 1 = verbose enabled
  // 2 = verbose extra info
  
  
  $debug_mode         = 2;

  $objLottery = new Lottery();
  $objOLG     = new OLGLottery();
  $cmdargs = arguments();
  
  
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^update/i", $cmdargs["standard"][1], $lmatches)) {
  		$lottery_draw_data_dates = $objOLG->OLGPick4GetFirstLastDataAvail();
                /*
                 * Added one year earlier default when database is empty
                 */
                if ($lottery_draw_data_dates["latest"] == "") {
                    $lottery_draw_data_dates["latest"] = date('Y-m-d',strtotime(date('Y-m-d') . ' -1 year'));
                }      
                
                
  		$startDay 	= date('d',strtotime($lottery_draw_data_dates["latest"]));
  		$startMonth = date('m',strtotime($lottery_draw_data_dates["latest"]));
  		$startYear 	= date('Y',strtotime($lottery_draw_data_dates["latest"]));
  		$endDay 	= date('d');
  		$endMonth 	= date('m');
  		$endYear    = date('Y');
  		$startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
		$endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);  		
  		$drawDates  = $objLottery->dbLotteryGetDrawDates("onPick4", "MM", $startDate, $endDate); 
  		
  	} elseif (preg_match("/^getMonth/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
                    $selectedMonth = $lsubmat[1];
                    $selectedYear  = $lsubmat[2];
                    $startDate     = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
                    $endDate       = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
                    $drawDates 	   = $objLottery->dbLotteryGetDrawDates("onPick4", "MM", $startDate, $endDate); 
  		}
  	} elseif (preg_match("/^getYear/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{4})|(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		    $selectedYear = $lsubmat[1];
                    $startDate    = mktime(0,0,0,1,1,$selectedYear);
                    $endDate      = mktime(0,0,0,12,31,$selectedYear);
                    $drawDates    = $objLottery->dbLotteryGetDrawDates("onPick4", "YY", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/^getDraw/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		    //print_r($lmatches); 
                    $selectedDay    = $lsubmat[1];
                    $selectedMonth  = $lsubmat[2];
                    $selectedYear   = $lsubmat[3];
                    $startDate 		= mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
                    $endDate   		= mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
                    $drawDates 		= $objLottery->dbLotteryGetDrawDates("onPick4", "DD", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4}) - (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][1], $lmatches)) {
  		$startDay     		= $lmatches[1];
                $startMonth   		= $lmatches[2];
      		$startYear    		= $lmatches[3];
      		$endDay       		= $lmatches[4];
      		$endMonth     		= $lmatches[5];
      		$endYear      		= $lmatches[6];
      		$startDate 		= mktime(0,0,0,$startMonth, $startDay , $startYear);
      		$endDate   		= mktime(0,0,0,$endMonth, $endDay, $endYear);
      		$drawDates 		= $objLottery->dbLotteryGetDrawDates("onPick4", "DD1DD2", $startDate, $endDate);
  	}
  	
  	 //print_r($drawDates);
    if (is_array($drawDates)) {
      foreach ($drawDates as $dtDate) {
          // 20090211
        $drawDate = strtotime($dtDate);
        //print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
        //print_r($dtDate);
        //alc_fetch_single_draw(date('d-m-Y',$drawDate));
        //on_fetch_first_step_649(date('d-m-Y', $drawDate));
        //on_fetch_first_step_max(date('d-m-Y', $drawDate));
        on_fetch_first_step_pick4(date('d-m-Y', $drawDate));
        die();
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
			  $drawDates = $objLottery->dbLotteryGetDrawDates("onPick4", "DD1DD2", $startDate, $endDate);
			} elseif (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
			   //print_r($lmatches); 
			  $selectedDay    = $lmatches[1];
			  $selectedMonth  = $lmatches[2];
			  $selectedYear   = $lmatches[3];
			  $startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
			  $endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
			  $drawDates = $objLottery->dbLotteryGetDrawDates("onPick4", "DD", $startDate, $endDate);
			} elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
			  $selectedMonth 	= $lmatches[1];
			  $selectedYear 	= $lmatches[2];
			  $startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
			  $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
			  $drawDates = $objLottery->dbLotteryGetDrawDates("onPick4", "MM", $startDate, $endDate);    
			} elseif (preg_match("/getYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
			  $selectedYear = $lmatches[1];
			  $startDate    = mktime(0,0,0,1,1,$selectedYear);
			  $endDate      = mktime(0,0,0,12,31,$selectedYear);
			  $drawDates = $objLottery->dbLotteryGetDrawDates("onPick4", "YY", $startDate, $endDate);
			}
			
	
		//print_r($drawDates);
		if (is_array($drawDates)) {
		  foreach ($drawDates as $dtDate) {
			  // 20090211
			$drawDate = strtotime($dtDate);
			//print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
			//print_r($dtDate);
			//alc_fetch_single_draw(date('d-m-Y',$drawDate));
			//on_fetch_first_step_649(date('d-m-Y', $drawDate));
			//on_fetch_first_step_max(date('d-m-Y', $drawDate));
			on_fetch_first_step_pick4(date('d-m-Y', $drawDate));
		  }
		}    
		
	  } while (trim($selection) != 'q');
	  
  }
  function on_fetch_first_step_pick4($drawdate = "") {
        
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
    
    
    $onPick4GameId         = 26;
    

    $hp_day                  = 0;
    $hp_gameID               = $onPick4GameId;
    $hp_command              = 'submit';
    
    $onPick4_row             = $objLottery->dbLotteryGamesGet("onPick4");
    
    
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
           * print_r($lmatches);
          print "\nSiteDomain: " . $site_domain_id;
          print "\nSitePath  : " . $site_path_id;
          print "\nSiteFile  : " . $site_file_id;
          print "\nSitePost : " . $site_post_id;
          print "\n" . $site_post_str;
           */ 
                 
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onPick4", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onPick4", $onPick4_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onPick4", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
    
    $ary_headers = preg_split("/\n/", $http->header);
    $jsessionid = "";
    foreach($ary_headers as $hdr) {
        if (preg_match("/^Set-Cookie\:/i", $hdr)) {
            $hdr = str_replace("Set-Cookie: ", "", $hdr);
            
            $ary_cookies = preg_split("/;/", $hdr);
            foreach ($ary_cookies as $ckie) {
              if (preg_match("/JSESSIONID=/i",$ckie, $lmatches)) {
                $jsessionid = $ckie;
              }
            }
            $http->headers['Cookie'] = $jsessionid; 
            break;
        }
    }
    
    $onPick4GameId         = 26;
    
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
    
    
    
    $bOnPick4_m     = 0;
    $bOnPick4_m_1 	= 0;
    
    
    $srg_onEncore     = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
    $srg_onPick4      = "\s*(\d)\s*(\d)\s*(\d)\s*(\d)\s*"; 
      
    $sPick4_th_Line   = $srgB_th . "(.*?)" . $srgE_th;        // Date
    $sPick4_th_Line   .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Day
    $sPick4_th_Line   .= "\s*" . $srgB_th . "(.*?)" ;                 // Numbers
    $sPick4_th_Line   .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // ENCORE
    $sPick4_th_Line   .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // WINNINGS

    
    $sPick4_th_Line_1	= $srgB_th . "(.*?)" . $srgE_th;        // Date
    $sPick4_th_Line_1	.= "\s*" . $srgB_th . "(.*?)" . $srgE_th;		// Time
    $sPick4_th_Line_1   .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Day
    $sPick4_th_Line_1   .= "\s*" . $srgB_th . "(.*?)" ;                 // Numbers
    $sPick4_th_Line_1   .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // ENCORE
    $sPick4_th_Line_1   .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // WINNINGS
    
    $sPick4_td_Line     = $srgB_td . "(.*?)"  . $srgE_td;        // Date
    $sPick4_td_Line     .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day
    $sPick4_td_Line     .= "\s*" . $srgB_td .   "(.*?)" . $srg_comment;   // Numbers
    $sPick4_td_Line     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Encore
    $sPick4_td_Line     .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings
    
    $sPick4_td_Line_1	= $srgB_td . "(.*?)"  . $srgE_td;        			// Date
    $sPick4_td_Line_1	.= "\s*" . $srgB_td . "(.*?)" . $srgE_td;			// Time
    $sPick4_td_Line_1   .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day
    $sPick4_td_Line_1   .= "\s*" . $srgB_td .   "(.*?)" . $srg_comment;   // Numbers
    $sPick4_td_Line_1   .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Encore
    $sPick4_td_Line_1   .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings
    
    
    
    $str_money_sym = array("$",","); 
    
    $srgDays          = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
    $srgMonths        = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
    
    //print_r ($html_tr_list);
    
     if ($debug_mode > 0) {
        //print "\nFetch " . $site_file . $site_querystr;
        print "\nDate: " . date('Y-m-d', $drawdate);
      }    
    
    foreach($html_tr_list as $html_tr) {
      
    	
		if (preg_match("/" . $sPick4_th_Line_1 . "/i", $html_tr, $lmatches)) {
			$bOnPick4_m_1 = 1;
		} else if ($bOnPick4_m_1 == 1 && 
				(preg_match("/" . $sPick4_td_Line_1 . "/i" , $html_tr, $lmatches))) {
			

			//print_r($lmatches);
			if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
				//print_r($lotResMat);
			
				$sdrawMonthName       = trim($lotResMat[2]);
				$sdrawMonthNum        = $objDate->getShortMonthNum($sdrawMonthName);
				$sdrawDay             = $lotResMat[1];
				$sdrawYear            = $lotResMat[3];
				$sPick4_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
			
				if ($debug_mode > 1) {
					print "[" . $sPick4_drawdate . "]";
				}
				//print "\nPick 4 DrawDate: " . $sPick4_drawdate;
			
			}
			$sdrawTime = "";
			if (preg_match("/\s*" . $srgB_p . "\s*" . $srgB_strong . "\s*(EVENING|MIDDAY)\s*" . $srgE_strong . "\s*" . $srgE_p . "/i", $lmatches[2], $lotResMat)) {
				if ($debug_mode > 1) {
					print "\n[Time: " . print_r($lotResMat,1);
				}
				$sdrawTime = $lotResMat[1];
				print "\n SDRAWTIME: " . $sdrawTime . "\n";
			}
			
			
			if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\w{3})\s*" . $srgE_strong. $srgE_p . "/i",$lmatches[3], $lotResMat)) {
				//print_r($lotResMat);
				$sdrawDayName         = trim($lotResMat[1]);
			}
			
			// print_r($html_br_list);
			
			if (preg_match("/" . $srg_onPick4 . "/i", $lmatches[4], $lotResMat)) {
				//print_r($lotResMat);
				$snum1                = $lotResMat[1];
				$snum2                = $lotResMat[2];
				$snum3                = $lotResMat[3];
				$snum4                = $lotResMat[4];
			
				if ($debug_mode > 1) {
					print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "]";
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
					print "[" . $senc_num1 . "|" . $senc_num2 . "|" . $senc_num3 . "|" . $senc_num4 . "|" . $senc_num5 . "|" . $senc_num6 . "|"  . $senc_num7 . "]";
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
					print "[" . $str_gameid . "|" . $str_drawNo . "|" . $str_drawDate . "|" . $str_spielId . "]";
				}
			}
			
			$sPick4_drawdate  = strtotime($sPick4_drawdate);
			$sPick4_drawdate  = date('Y-m-d', $sPick4_drawdate);
			$onPick4DrawId    = $objOLG->OLGPick4GetDrawId($sPick4_drawdate, $sdrawTime);
			//printf("\nstr_gameid : %u - str_drawNo: %u - str_drawdate: %u - str_spielId : %u", $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
			if (!$onPick4DrawId) {
                                // OLGPick4Add($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $drawNo, $sdrawDate, $spielID, $sdrawTime = "")
				$onPick4DrawId = $objOLG->OLGPick4Add($sPick4_drawdate, 0, $snum1, $snum2, $snum3, $snum4,  $str_drawNo, $str_drawDate, $str_spielId, $sdrawTime);
			
			}
			if ($debug_mode > 1) {
				print "[" . $onPick4DrawId . "|" . $sPick4_drawdate . "]";
			}
			
			$str_onEncoreId   = $objOLG->OLGEncoreGetDrawId($sPick4_drawdate, $sdrawTime);
			if (!$str_onEncoreId) {
				$str_onEncoreId = $objOLG->OLGEncoreAdd($sPick4_drawdate, "", $senc_num1, $senc_num2, $senc_num3, $senc_num4, $senc_num5, $senc_num6, $senc_num7, $sdrawTime);
			}
			
			if ($onPick4DrawId != null) {
				$onPick4WinningId = $objOLG->OLGOnPick4WinningsGetId($onPick4DrawId);
				if (!$onPick4WinningId) {
					on_fetch_second_step_pick4($sPick4_drawdate, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId, $sdrawTime);
				}
			
			}
			
			
			if ($debug_mode > 1 ) {
				print "[" . $str_onEncoreId . "]";
			}
			
			//print "\n\nDraw Date: " . $sPick4_drawdate . "\n";
			
			
			
		} else if (preg_match("/" . $sPick4_th_Line . "/i", $html_tr, $lmatches)) {
        $bOnPick4_m   = 1;
        
        
         //print_r($lmatches);
      } elseif ($bOnPick4_m == 1 &&
              (preg_match("/" . $sPick4_td_Line . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);
          if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
            //print_r($lotResMat);
            
            $sdrawMonthName       = trim($lotResMat[2]);
            $sdrawMonthNum        = $objDate->getShortMonthNum($sdrawMonthName);
            $sdrawDay             = $lotResMat[1];
            $sdrawYear            = $lotResMat[3];
            $sPick4_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
            
            if ($debug_mode > 1) {
              print "[" . $sPick4_drawdate . "]";
            }
            //print "\nPick 4 DrawDate: " . $sPick4_drawdate;
                  
          }
          if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\w{3})\s*" . $srgE_strong. $srgE_p . "/i",$lmatches[2], $lotResMat)) {
            //print_r($lotResMat);
            $sdrawDayName         = trim($lotResMat[1]);
          }
      
         // print_r($html_br_list);      
    
          if (preg_match("/" . $srg_onPick4 . "/i", $lmatches[3], $lotResMat)) {
            //print_r($lotResMat);
            $snum1                = $lotResMat[1];
            $snum2                = $lotResMat[2];
            $snum3                = $lotResMat[3];
            $snum4                = $lotResMat[4];
            
            if ($debug_mode > 1) {
              print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "]";
            }
          }
          if (preg_match("/\s*" . $srgB_p . $srgB_strong . $srg_onEncore . $srgE_strong . $srgE_p . "/i", $lmatches[4], $lotResMat )) {
            //print_r($lotResMat);
              $senc_num1 = $lotResMat[1];
              $senc_num2 = $lotResMat[2];
              $senc_num3 = $lotResMat[3];
              $senc_num4 = $lotResMat[4];
              $senc_num5 = $lotResMat[5];
              $senc_num6 = $lotResMat[6];
              $senc_num7 = $lotResMat[7];
              
              if ($debug_mode > 1) {
                print "[" . $senc_num1 . "|" . $senc_num2 . "|" . $senc_num3 . "|" . $senc_num4 . "|" . $senc_num5 . "|" . $senc_num6 . "|"  . $senc_num7 . "]";
              }
            
          }
          
          if (preg_match("/\s*([a-zA-Z.*\/?=]*)\s*/i", $lmatches[5], $lotResMat)) {
            //print_r($lotResMat);
          } 
          if (preg_match("/\s*" . $srg_gameid . "\s*" . $srg_drawNo . "\s*" . $srg_drawDate . "\s*" . $srg_spielId . "\s*<input[^>]*>" . "/i", $lmatches[6], $lotResMat)) {
            //print_r($lotResMat);
            
            $str_gameid = $lotResMat[1];
            $str_drawNo = $lotResMat[2];
            $str_drawDate = $lotResMat[3];
            $str_spielId  = $lotResMat[4];
            
            if ($debug_mode > 1) {
              print "[" . $str_gameid . "|" . $str_drawNo . "|" . $str_drawDate . "|" . $str_spielId . "]";
            }
          }
          
          $sPick4_drawdate  = strtotime($sPick4_drawdate);
          $sPick4_drawdate  = date('Y-m-d', $sPick4_drawdate);
          $onPick4DrawId    = $objOLG->OLGPick4GetDrawId($sPick4_drawdate);
          //printf("\nstr_gameid : %u - str_drawNo: %u - str_drawdate: %u - str_spielId : %u", $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
          if (!$onPick4DrawId) {
            $onPick4DrawId = $objOLG->OLGPick4Add($sPick4_drawdate, 0, $snum1, $snum2, $snum3, $snum4, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
            
          }
          if ($debug_mode > 1) {
            print "[" . $onPick4DrawId . "|" . $sPick4_drawdate . "]";
          }
          
          $str_onEncoreId   = $objOLG->OLGEncoreGetDrawId($sPick4_drawdate);
          if (!$str_onEncoreId) {
            $str_onEncoreId = $objOLG->OLGEncoreAdd($sPick4_drawdate, "", $senc_num1, $senc_num2, $senc_num3, $senc_num4, $senc_num5, $senc_num6, $senc_num7);
          }
          
          if ($onPick4DrawId != null) {
          	$onPick4WinningId = $objOLG->OLGOnPick4WinningsGetId($onPick4DrawId);
          	if (!$onPick4WinningId) {
          		on_fetch_second_step_pick4($sPick4_drawdate, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
          	}
          
          }
          
          
          if ($debug_mode > 1 ) {
            print "[" . $str_onEncoreId . "]";
          }
          
          //print "\n\nDraw Date: " . $sPick4_drawdate . "\n";
          
      }
    }
    
        
  } 
  
  function on_fetch_second_step_pick4($sdrawdate, $str_gameid, $str_drawNo, $str_drawdate, $str_spielid, $sdrawTime = "") {
    
        
    global $debug_mode;
    
    $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
    $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
    $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
    
    $objLottery   = new Lottery();
    $objDate      = new GenDates();
    $objOLG       = new OLGLottery();
    $naLottery    = new NALottery();
    $onPick4_row  = $objLottery->dbLotteryGamesGet("onPick4");
    $onEncore_row = $objLottery->dbLotteryGamesGet("onEncore");
    
    $drawdate = strtotime($sdrawdate);

    
    $onPick4GameId          = 26;
    
    $hp_gameID     = $onPick4GameId;
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
        $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onPick4", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
        if (!$fetch_stats_id) {
          $fetch_date = date('Y-m-d H:i:s');
          $fetch_pos = 0;
          $fetch_process_suc = 0;
          //print_r($na649_row);
          // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
          $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onPick4", $onPick4_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
          $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
         } else {
          $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onPick4", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
    
    $ary_headers = preg_split("/\n/", $http->header);
    $jsessionid = "";
    foreach($ary_headers as $hdr) {
        if (preg_match("/^Set-Cookie\:/", $hdr)) {
            $hdr = str_replace("Set-Cookie: ", "", $hdr);
            
            $ary_cookies = preg_split("/;/", $hdr);
            foreach ($ary_cookies as $ckie) {
              if (preg_match("/JSESSIONID=/i",$ckie, $lmatches)) {
                $jsessionid = $ckie;
              }
            }
            $http->headers['Cookie'] = $jsessionid; 
            break;
        }
    }
    
    
    $onPick4GameId          = 26;
    
    $http->postvars['gameID']     = $onPick4GameId;
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
    
    $sPick4_m     = 0;
    $sEncore_m  = 0;
    
    $srg_Pick4_Winning_Hdr = "WINNINGS FOR \s* PICK-4"; // WINNINGS FOR PICK-4
    $srg_encore_Winning_Hdr = "WINNINGS FOR ENCORE";
    
    $srgDays    = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
    $srgMonths  = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
    
    
    $sPick4_th_Lines  = $srgB_th . "(.*?)" . $srgE_th;            // Match
    $sPick4_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Number of Winnings 
    $sPick4_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Prize
    
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
    
    $sPick4_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong .  "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" .  $srgE_td;
    $sPick4_td_Lines .=  "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
    $sPick4_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
    
    /*
    $s649_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p  . "\s*" .  $srgE_td;               // Match
    $s649_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p  . "\s*" .  $srgE_td;      // Number of winnings
    $s649_td_Lines .= "\s*" . $srgB_td  . "\s*" .  $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p  . "\s*" .  $srgE_td;      // Prize
    */
    
    $sEncore_th_Line = $srgB_th . "(.*?)" . $srgE_th;               // Match
    $sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Number of Winners
    $sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Prize
    
    $sEncore_td_Line = $srgB_td    . "\s*" .  $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;               // Match
    $sEncore_td_Line .= "\s*" . $srgB_td  . "\s*" .   $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;      // Number of Winners
    $sEncore_td_Line .= "\s*" . $srgB_td   . "\s*" .  $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;      // Prize
    
    $str_money_sym = array("$",","); 
    
     if ($debug_mode > 0) {
      //  print "\nFetch " . $site_file . $site_querystr;
        print "\nDate: " . date('Y-m-d', $drawdate);
      }    
    
    
    foreach ($html_tr_list as $html_tr) {
      if (preg_match("/". $srg_Pick4_Winning_Hdr . "/i", $html_tr, $lmatches)) {
        //print_r($lmatches);
        $sPick4_m     = 1;
        $sEncore_m    = 0;
      } elseif (preg_match("/" . $srg_encore_Winning_Hdr . "/i", $html_tr, $lmatches)) {
        //print_r($lmatches);
        $sPick4_m     = 0;
        $sEncore_m    = 1;
      } elseif ($sPick4_m == 1 &&
                preg_match("/" . $sPick4_th_Lines . "/i", $html_tr, $lmatches)) {
        //print_r($lmatches);
        
      } elseif ($sPick4_m == 1 &&
                preg_match("/" . $sPick4_td_Lines . "/i", $html_tr, $lmatches)) {
        //print_r ($lmatches);   
        if (preg_match("/Straight/i", $lmatches[1], $lot_mat_)) {
          $m_str_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
          $m_str_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m_str_prze_amt, $objLottery->prz_money, $onPick4_row["gameid"]);
          if (!$m_str_prze_id) {
            $m_str_prze_id = $objLottery->dbLotteryWinPrizesAdd($m_str_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onPick4_row["gameid"]);
          }
          $m_str_win_count = trim($lmatches[2]);
          
          if ($debug_mode > 1) {
            print "[STR|" . $m_str_prze_amt . "|" . $m_str_prze_id . "|" . $m_str_win_count . "]";
          }
        } elseif (preg_match("/4-Way Box/i", $lmatches[1], $lot_mat_)) {
          $m4w_box_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
          $m4w_box_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m4w_box_prze_amt, $objLottery->prz_money, $onPick4_row["gameid"]);
          if (!$m4w_box_prze_id) {
            $m4w_box_prze_id = $objLottery->dbLotteryWinPrizesAdd($m4w_box_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onPick4_row["gameid"]);
          }
          $m4w_box_win_count = trim($lmatches[2]);   
          if ($debug_mode > 1) {
            print "[4W-Box|" . $m4w_box_prze_amt . "|" . $m4w_box_prze_id . "|" . $m4w_box_win_count . "]";
          }      
        } elseif (preg_match("/6-Way Box/i", $lmatches[1], $lot_mat_)) {
          $m6w_box_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
          $m6w_box_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m6w_box_prze_amt, $objLottery->prz_money, $onPick4_row["gameid"]);
          if (!$m6w_box_prze_id) {
            $m6w_box_prze_id = $objLottery->dbLotteryWinPrizesAdd($m6w_box_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onPick4_row["gameid"]);
          }
          $m6w_box_win_count = trim($lmatches[2]);   
          if ($debug_mode > 1) {
            print "[6W-Box|" . $m6w_box_prze_amt . "|" . $m6w_box_prze_id . "|" . $m6w_box_win_count . "]";
          }      
                  
        } elseif (preg_match("/12-Way Box/i", $lmatches[1], $lot_mat_)) {
          $m12w_box_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
          $m12w_box_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m12w_box_prze_amt, $objLottery->prz_money, $onPick4_row["gameid"]);
          if (!$m12w_box_prze_id) {
            $m12w_box_prze_id = $objLottery->dbLotteryWinPrizesAdd($m12w_box_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onPick4_row["gameid"]);
          }
          $m12w_box_win_count = trim($lmatches[2]);    
          
          if ($debug_mode > 1) {
            print "[12W-Box|" . $m12w_box_prze_amt . "|" . $m12w_box_prze_id . "|" . $m12w_box_win_count . "]";
          }       
        } elseif (preg_match("/24-Way Box/i", $lmatches[1], $lot_mat_)) {
          $m24w_box_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
          $m24w_box_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m24w_box_prze_amt, $objLottery->prz_money, $onPick4_row["gameid"]);
          if (!$m24w_box_prze_id) {
            $m24w_box_prze_id = $objLottery->dbLotteryWinPrizesAdd($m24w_box_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onPick4_row["gameid"]);
          }
          $m24w_box_win_count = trim($lmatches[2]); 
          if ($debug_mode > 1) {
            print "24W-Box|" . $m24w_box_prze_amt . "|" . $m24w_box_prze_id . "|" . $m24w_box_win_count . "]";
          }
        }
      } elseif ($sEncore_m == 1 &&
                preg_match("/" . $sEncore_th_Line . "/i", $html_tr, $lmatches)) {
        //print_r($lmatches);    
        //print "\n Pick 4 prizes into db";
        /* Insert the Pick 4 prizes into DB
         */        
         $sPick4_drawDate = strtotime($sdrawdate);
         $sPick4_drawDate = date('Y-m-d', $sPick4_drawDate);
         print "\nSDRAWTIME: " . $sdrawTime . " --- SPICK 4 DrawDate: "  . $sPick4_drawDate;
         $onPick4Id       = $objOLG->OLGPick4GetDrawId($sPick4_drawDate, $sdrawTime);
        print "\nONPICK4ID: " . $onPick4Id;
         
         if ($onPick4Id != null) {
           $onPick4WinningId = $objOLG->OLGOnPick4WinningsGetId($onPick4Id);
           if (!$onPick4WinningId) {
               if (!isset($m4w_box_prze_id)) {
                   $m4w_box_prze_id = "";
                   $m4w_box_win_count = "";
               }
               if (!isset($m6w_box_prze_id)) {
                   $m6w_box_prze_id = "";
                   $m6w_box_win_count = "";
               }
               if (!isset($m24w_box_prze_id)) {
                   $m24w_box_prze_id = "";
                   $m24w_box_win_count = "";
               }
               if (!isset($m12w_box_prze_id)) {
                   $m12w_box_prze_id = "";
                   $m12w_box_win_count = "";
               }
               
               
             $onPick4WinningId = $objOLG->OLGOnPick4WinningsAdd( $onPick4Id, $m_str_win_count, $m_str_prze_id, 
                    "", "",$m4w_box_win_count , $m4w_box_prze_id, $m6w_box_win_count, $m6w_box_prze_id,
                    $m12w_box_win_count, $m12w_box_prze_id, $m24w_box_win_count, $m24w_box_prze_id, 0 ); 
           }
           
               print "\nDraw DetailID: " . $onPick4WinningId . " Pick3Id: " . $onPick4Id;
              print "\nStr Count : " . $m_str_win_count . " Str Prze Amt: " . $m_str_prze_id;
              print "\nBox Count : " . $m4w_box_win_count . " Box Prze Amt: " . $m4w_box_prze_id;
              print "\nBox Count : " . $m6w_box_win_count . " Box Prze Amt: " . $m6w_box_prze_id;
              print "\nBox Count : " . $m12w_box_win_count . " Box Prze Amt: " . $m12w_box_prze_id;
              print "\nBox Count : " . $m24w_box_win_count . " Box Prze Amt: " . $m24w_box_prze_id;
              
         }

        if ($debug_mode > 1) {
          print "[" . $sPick4_drawDate . "|" . $onPick4Id . "|" . $onPick4WinningId . "]";
        }
        
          $arEncore_th = array();    
          $inEncore_th = 0;  
         // die();
      } elseif ($sEncore_m == 1 &&
                preg_match("/" . $sEncore_td_Line . "/i", $html_tr, $lmatches)) {
       // print_r($lmatches);    
           $arEncore_th[$inEncore_th] = $lmatches;
           $inEncore_th++;
                 // print_r($lmatches); 
           
      }
      
    }
    
  if (is_array($arEncore_th)) {
      $OLGData = new OLGData();
      $OLGData->OLGEncoreParse($arEncore_th, strtotime($sdrawdate), $debug_mode);
    }
        
    
  }
  
  ?>