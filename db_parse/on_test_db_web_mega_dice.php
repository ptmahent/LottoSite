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
  
  
  $debug_mode   = 2;
  
  $objLottery 	= new Lottery();
  $objOLG     	= new OLGLottery();
  $cmdargs 	= arguments();
  
  
  
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^update/i", $cmdargs["standard"][1], $lmatches)) {
  		$lottery_draw_data_dates = $objOLG->OLGMegaDiceGetFirstLastDataAvail();
                
                 /*
                 * Added one year earlier default when database is empty
                 * 
                 *  - make sure start date is greater than Oct 1 - 2012
                 * 
                 */
                if ($lottery_draw_data_dates["latest"] == "") {
                    $lottery_draw_data_dates["latest"] = date('Y-m-d',strtotime(date('Y-m-d') . ' -1 year'));
                    if (strtotime( $lottery_draw_data_dates["latest"]) < strtotime("2012-10-01")) {
                        $lottery_draw_data_dates["latest"] = date('Y-m-d', strtotime("2012-10-01"));
                    }
                }                
                
                
                
  		$startDay 	= date('d',strtotime($lottery_draw_data_dates["latest"]));
  		$startMonth = date('m',strtotime($lottery_draw_data_dates["latest"]));
  		$startYear 	= date('Y',strtotime($lottery_draw_data_dates["latest"]));
  		$endDay 	= date('d');
  		$endMonth 	= date('m');
  		$endYear    = date('Y');
  		$startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
		$endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);  		
  		$drawDates 	= $objLottery->dbLotteryGetDrawDates("onMegaDice", "MM", $startDate, $endDate); 
  		
  	} elseif (preg_match("/^getMonth/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  			$selectedMonth 	= $lmatches[1];
      	  	$selectedYear 	= $lmatches[2];
      	  	$startDate    	= mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      	    $endDate      	= mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      	  	$drawDates 		= $objLottery->dbLotteryGetDrawDates("onMegaDice", "MM", $startDate, $endDate); 
  		}
  	} elseif (preg_match("/^getYear/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{4})|(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		      $selectedYear = $lsubmat[1];
      	  	  $startDate    = mktime(0,0,0,1,1,$selectedYear);
      	  	  $endDate      = mktime(0,0,0,12,31,$selectedYear);
      	  	  $drawDates 	= $objLottery->dbLotteryGetDrawDates("onMegaDice", "YY", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/^getDraw/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		    //print_r($lmatches); 
      	  	$selectedDay    = $lsubmat[1];
      	  	$selectedMonth  = $lsubmat[2];
      	  	$selectedYear   = $lsubmat[3];
      	  	$startDate 		= mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$endDate   		= mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$drawDates 		= $objLottery->dbLotteryGetDrawDates("onMegaDice", "DD", $startDate, $endDate);
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
      	$drawDates 			= $objLottery->dbLotteryGetDrawDates("onMegaDice", "DD1DD2", $startDate, $endDate);
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
		on_fetch_first_step_mega_dice(date('d-m-Y', $drawDate));
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
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onMegaDice", "DD1DD2", $startDate, $endDate);
		} elseif (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		   //print_r($lmatches); 
		  $selectedDay    = $lmatches[1];
		  $selectedMonth  = $lmatches[2];
		  $selectedYear   = $lmatches[3];
		  $startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onMegaDice", "DD", $startDate, $endDate);
		} elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		  $selectedMonth = $lmatches[1];
		  $selectedYear = $lmatches[2];
		  $startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
		  $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onMegaDice", "MM", $startDate, $endDate);    
		} elseif (preg_match("/getYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
		  $selectedYear = $lmatches[1];
		  $startDate    = mktime(0,0,0,1,1,$selectedYear);
		  $endDate      = mktime(0,0,0,12,31,$selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onMegaDice", "YY", $startDate, $endDate);
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
			on_fetch_first_step_mega_dice(date('d-m-Y', $drawDate));
		  }
		}    
		
	  } while (trim($selection) != 'q');
	  
  }
  
  function on_fetch_first_step_mega_dice($drawdate = "") {
    
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
      
      $onMegaDiceGameId    = 80;
      
      
      $hp_day                  = 0;
      $hp_gameID               = $onMegaDiceGameId;
      $hp_command              = 'submit';      
      
      
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
      
       $onMegaDice_row             = $objLottery->dbLotteryGamesGet("onMegaDice");
    
    
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
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onMegaDice", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onPick4", $onMegaDice_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onMegaDice", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
      
      
      
      $bOnMegaDice_m     = 0;
      
//      
//      $sMegaDiceCards = array("two" => 2,
//                               "three" => 3,
//                               "four" => 4,
//                               "five" => 5,
//                               "six" => 6,
//                               "seven" => 7,
//                               "eight" => 8,
//                               "nine" => 9,
//                               "ten" => 10,
//                               "jack" => "J",
//                               "queen" => "Q",
//                               "king" => "K",
//                               "ace" => "A");
//                               
//      $sMegaDiceClass = array("clubs" => "C",
//                              "spades" => "S",
//                              "diamonds" => "D",
//                              "hearts" => "H");
//      $srg_onPkrSingleCrd = "<img .*?alt=\"(.*?) of (.*?)\"[^>]*>";
//      $srg_onMegaDice = "\s*" . $srg_onPkrSingleCrd . "\s*" . $srg_onPkrSingleCrd . "\s*" . $srg_onPkrSingleCrd . "\s*";
//      $srg_onMegaDice .= $srg_onPkrSingleCrd . "\s*" . $srg_onPkrSingleCrd . "\s*";
//      
//      
      
      $srg_MegaDice_Numbers = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
      $srg_onEncore         = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
      $srg_bonusnum         = "\s*(\d{2})\s*";
      
      

      $srg_onEncore     = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";

        
      
      /*
       * 
    <tr>
      <th class="white_centre" id="lottery_borderless" align="center">
	DATE
     </th>
	<th class="white_centre" id="lottery_borderless" align="center">
	DAY
       </th>
       <th class="white_centre" id="lottery_borderless" align="center">
	NUMBERS
	<th class="white_centre" id="lottery_borderless" align="center">
	BONUS</th>
	<th class="white_centre" id="lottery_borderless" align="center">
	ENCORE
	</th>
	<th class="white_centre" id="lottery_borderless" align="center">
	WINNINGS</th>
	</tr>
	
       * 
       */
      
      
      
      
      $sMegaDice_th_Line     = $srgB_th . "(.*?)" . $srgE_th;                // Date        (1)
      $sMegaDice_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Day         (2)
      $sMegaDice_th_Line     .= "\s*" . $srgB_th . "(.*?)" ;                 // Numbers     (3)
      $sMegaDice_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Bonus       (4)
      $sMegaDice_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // ENCORE      (5)
      $sMegaDice_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // WINNINGS    (6)
      
      $sMegaDice_td_Line     = $srgB_td . "(.*?)"  . $srgE_td;                  // Date     (1)
      $sMegaDice_td_Line     .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day      (2)
      $sMegaDice_td_Line     .= "\s*" . $srgB_td .   "(.*?)" . $srg_comment;    // Numbers  (3)
      $sMegaDice_td_Line     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Bonus    (4)
      $sMegaDice_td_Line     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Encore   (5)
      $sMegaDice_td_Line     .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings
     
      
      /*
       * 
     <tr bgcolor="#fab650">
	<td style="margin-top:0px" id="lottery_border" align="center" valign="middle">
	<p class="blue"  style="margin:0px 0 0 0;"><strong>
	21-Mar-2013
	</strong></p>
	</td>
	<td id="lottery_border" align="center" valign="middle">
	<p class="blue"><strong>
	Thu
	</strong></p>
	</td>
	<td id="lottery_border" align="center">
	<strong>
	<p class="blue">
	09				
	16
	20
	23
	29
	36
	<!-- Plus Numbers -->
	<td id="lottery_border" align="center" valign="middle" >
	<p style="margin:0px 0 0 0;" class="blue"><strong>
	19
	</strong></p>
	</td>
	<td id="lottery_border" align="center"  valign="middle" >
	<p class="blue" style="margin:0px 0 0 0;"><strong></strong></p>
	</td>
	<form name="winningNumbersForm" method="post" action="/lotteries/viewPrizeShares.do">
	<td id="lottery_border" align="center" valign="middle" >
	<input type="hidden" name="gameID" value="80"> 
	<input type="hidden" name="drawNo" value="171"> 
	<input type="hidden" name="sdrawDate" value="1363914060000"> 
	<input type="hidden" name="spielID" value="0"> <input
	type="image" style="margin:0px 0 0 0;"  src="/assets/img/consumer_wn_pot_gold.gif" alt="WINNINGS"
	width="23px" height="25px" border="0" onclick="this.form.submit();">
	</td>
	</form>
	</tr> 
       * 
       */
      
      
      
      
      
      /*
      
      $sPkr_th_Line     = $srgB_th . "(.*?)" . $srgE_th;        // Date
      $sPkr_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Day
      $sPkr_th_Line     .= "\s*" . $srgB_th . "(.*?)" ;                 // Cards
      $sPkr_th_Line     .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // WINNINGS
      
      $sPkr_td_Line     = $srgB_td . "(.*?)"  . $srgE_td;        // Date
      $sPkr_td_Line     .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day
      $sPkr_td_Line     .= "\s*" . $srgB_td .   "(.*?)";                  // Cards
      $sPkr_td_Line     .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings
      */
      
      $str_money_sym = array("$",","); 
      
      $srgDays          = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
      $srgMonths        = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";

    
     if ($debug_mode > 0) {
        //print "\nFetch " . $site_file . $site_querystr;
        print "\nDate: " . date('Y-m-d', $drawdate);
      }    
    
      foreach($html_tr_list as $html_tr) {
        
        if (preg_match("/" . $sMegaDice_th_Line . "/i", $html_tr, $lmatches)) {
          $bOnMegaDice_m   = 1;
           //print_r($lmatches);
        } elseif ($bOnMegaDice_m == 1 &&
                (preg_match("/" . $sMegaDice_td_Line . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
              //print_r($lotResMat);
              
              $sdrawMonthName       = trim($lotResMat[2]);
              $sdrawMonthNum        = $objDate->getShortMonthNum($sdrawMonthName);
              $sdrawDay             = $lotResMat[1];
              $sdrawYear            = $lotResMat[3];
              $sMegaDice_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
              //print "\nPick 4 DrawDate: " . $sMegaDice_drawdate;      
              
              if ($debug_mode > 1) {
                print "\n[" . $sMegaDice_drawdate . "]";
              }
              
            }
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\w{3})\s*" . $srgE_strong. $srgE_p . "/i",$lmatches[2], $lotResMat)) {
              //print_r($lotResMat);
            }
        
           // print_r($html_br_list);      
      
            if (preg_match("/" . $srg_MegaDice_Numbers . "/i", $lmatches[3], $lotResMat)) {
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
              
              //printf("\nCard1: %s - Card2: %s - Card3: %s - Card4: %s - Card5: %s", $scard1, $scard2, $scard3, $scard4, $scard5);
            }
            if (preg_match("/" . $srgB_p . $srgB_strong . $srg_bonusnum . $srgE_strong . $srgE_p . "/i", $lmatches[4], $lotResMat)) {
              //print_r($lotResMat);
              $snumBonus  = $lotResMat[1];
              if ($debug_mode > 1) {       
                  print "[B" . $snumBonus . "]";         
              }
            }
            /*
           print $lmatches[5];
           print "\n<br>";
           print $lmatches[6];
           print "\n<br>";
           print $lmatches[7];
           */ 
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
            // First Testing
            //die();
            
            $sMegaDice_drawdate = strtotime($sMegaDice_drawdate);
            $sMegaDice_drawdate = date('Y-m-d', $sMegaDice_drawdate);
            $onMegaDiceDrawId = $objOLG->OLGMegaDiceGetDrawId($sMegaDice_drawdate);
             //printf("\nstr_gameid : %u - str_drawNo: %u - str_drawdate: %u - str_spielId : %u", $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
            if (!$onMegaDiceDrawId) {
                
                //   function OLGMegaDiceAdd($drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, 
                // $snumbonus, $drawNo = "", $sdrawDate = "", $spielID = "") {

                
                
                //$onMegaDiceDrawId = $objOLG->na649Add($sMegaDice_drawdate, 0, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumBonus,  $str_drawNo, $str_drawDate, $str_spielId);
                
              $onMegaDiceDrawId = $objOLG->OLGMegaDiceAdd($sMegaDice_drawdate, 0, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumBonus,  $str_drawNo, $str_drawDate, $str_spielId);
              
            }
            
             if ($onMegaDiceDrawId != null) {
              $onMegaDiceWinningsId = $objOLG->OLGMegaDiceWinningsGetId($onMegaDiceDrawId);
              if (!$onMegaDiceWinningsId) {
            	on_fetch_second_step_mega_dice($sMegaDice_drawdate, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
            	}
        	}
            if ($debug_mode > 1) {
              print "[" . $sMegaDice_drawdate . "|" . $onMegaDiceDrawId . "]";
            }
            //printf("\nMegaDiceId : %u", $onMegaDiceDrawId);
            
        }
      }
      
          
    
  } 
  
  function on_fetch_second_step_mega_dice($sdrawdate, $str_gameid, $str_drawNo, $str_drawdate, $str_spielid) {
    
      global $debug_mode;
      
      $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
      
      $objLottery   = new Lottery();
      $objDate      = new GenDates();
      $objOLG       = new OLGLottery();
      $naLottery    = new NALottery();
      $onMegaDice_row  = $objLottery->dbLotteryGamesGet("onMegaDice");
      
      $drawdate = strtotime($sdrawdate);
      
      $onMegaDiceGameId = 80;
      
      $hp_gameID     = $onMegaDiceGameId;
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
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onMegaDice", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onMegaDice", $onMegaDice_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onMegaDice", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
      
      
      $onMegaDiceGameId    = 80;
      
      $http->postvars['gameID']     = $onMegaDiceGameId;
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
      
      $sMegaDice_m     = 0;
      
      $sMegaDiceInst_m = 0;
      
      $srg_MegaDice_Winning_Hdr = "WINNINGS FOR \s* MEGADICE LOTTO"; //WINNINGS FOR POKER LOTTO
      $srg_MegaDice_Inst_Winning_Hdr = "WINNINGS FOR MEGADICE INSTANT WINS";
      //$srg_encore_Winning_Hdr = "WINNINGS FOR \s* ENCORE";
      
      $srgDays    = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
      $srgMonths  = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
      
      
      $sMegaDice_th_Lines  = $srgB_th . "(.*?)" . $srgE_th;            // Match
      $sMegaDice_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Number of Winnings 
      $sMegaDice_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Prize
      
      
      $sMegaDice_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong .  "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" .  $srgE_td;
      $sMegaDice_td_Lines .=  "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      $sMegaDice_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      
      $sMegaDice_Inst_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_p . "\s*" .  $srgE_td;
      $sMegaDice_Inst_td_Lines .=  "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      $sMegaDice_Inst_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      
      $str_money_sym = array("$",","); 
      
      foreach ($html_tr_list as $html_tr) {
        if (preg_match("/". $srg_MegaDice_Winning_Hdr . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
          $sMegaDice_m      = 1;
          $sMegaDiceInst_m  = 0;
        } elseif (preg_match("/" . $srg_MegaDice_Inst_Winning_Hdr . "/i", $html_tr, $lmatches)) {
          print_r($lmatches);
          $sMegaDice_m      = 0;
          $sMegaDiceInst_m  = 1;
        } elseif ($sMegaDice_m == 1 &&
                  preg_match("/" . $sMegaDice_th_Lines . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
           
        } elseif ($sMegaDice_m == 1 &&
                  preg_match("/" . $sMegaDice_td_Lines . "/i", $html_tr, $lmatches)) {
          //print_r ($lmatches);   
            
            // 6 / 6
            // 5 / 6 + Bonus
            // 4 / 6
            // 3 / 6
            
            // 7 Ones (1's)
            // 7 of a Kind (2's-6's)
            // 6 of a Kind
            // 4 of a Kind + 3 of a Kind
            // 5 of a Kind
            // 3 of a Kind + 3 of a Kind
            // 3 of a Kind + 2 Pairs
            // Straight
            // 4 of a Kind
            
          /*
           $m_6_6_d_count, $m_6_6_d_amount, $m_5_6_b_d_count, $m_5_6_d_amount,
           $m_5_6_d_count, $m_5_6_d_amount, $m_4_6_d_count, $m_4_6_d_amount, 
           $m_3_6_d_count, $m_3_6_d_amount,
           * 
           */
          
          if (preg_match("/6\/6/i", $lmatches[1], $lot_mat_)) {
             // $m_6_6_d_count, $m_6_6_d_amount
          
            $m_6_6_d_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_6_6_d_count  = trim($lmatches[2]);
            $m_6_6_d_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_6_6_d_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
            if (!$m_6_6_d_prize_id) {
              $m_6_6_d_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_6_6_d_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[m6of6|" .  $m_6_6_d_amount . "|" . $m_6_6_d_prize_id . "|" . $m_6_6_d_count . "]";
            }   
            
            
            
          } else if (preg_match("/5\/6 \+ Bonus/i", $lmatches[1], $lot_mat_)) {
               //$m_5_6_b_d_count, $m_5_6_d_amount
            $m_5_6_b_d_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_5_6_b_d_count  = trim($lmatches[2]);
            $m_5_6_b_d_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_5_6_b_d_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
            if (!$m_5_6_b_d_prize_id) {
              $m_5_6_b_d_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_5_6_b_d_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[m5+Bof6|" .  $m_5_6_b_d_amount . "|" . $m_5_6_b_d_prize_id . "|" . $m_5_6_b_d_count . "]";
            }
            
          } elseif (preg_match("/5\/6/i", $lmatches[1], $lot_mat_)) {
              //$m_5_6_d_count, $m_5_6_d_amount
              
            $m_5_6_d_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_5_6_d_count  = trim($lmatches[2]);
            $m_5_6_d_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_5_6_d_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
            if (!$m_5_6_d_prize_id) {
              $m_5_6_d_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_5_6_d_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[m5of6|" . $m_5_6_d_amount . "|" . $m_5_6_d_prize_id . "|" . $m_5_6_d_count . "]";
            }
              
          } elseif (preg_match("/4\/6/i", $lmatches[1], $lot_mat_)) {
              //$m_4_6_d_count, $m_4_6_d_amount
            $m_4_6_d_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_4_6_d_count  = trim($lmatches[2]);
            $m_4_6_d_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_4_6_d_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
            if (!$m_4_6_d_prize_id) {
              $m_4_6_d_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_4_6_d_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[m4of6|" . $m_4_6_d_amount . "|" . $m_4_6_d_prize_id . "|" . $m_4_6_d_count . "]";
            }
          } elseif (preg_match("/3\/6/i", $lmatches[1], $lot_mat_)) {
              // $m_3_6_d_count, $m_3_6_d_amount
            $m_3_6_d_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
            $m_3_6_d_count  = trim($lmatches[2]);
            $m_3_6_d_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_3_6_d_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
            if (!$m_3_6_d_prize_id) {
              $m_3_6_d_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_3_6_d_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
            }
            if ($debug_mode > 1) {
              print "[m3of6|" . $m_3_6_d_amount . "|" . $m_3_6_d_prize_id . "|" . $m_3_6_d_count . "]";
            }
            
            
          }
          
        } elseif ($sMegaDiceInst_m == 1 &&
                  preg_match("/" . $sMegaDice_th_Lines . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);            
        } elseif ($sMegaDiceInst_m == 1 &&
                  preg_match("/" . $sMegaDice_Inst_td_Lines . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);     
            
                        // 7 Ones (1's) --- > 7 Ones (1&#39;s)
            // 7 of a Kind (2's-6's)  --> 7 of a Kind (2&#39;s-6&#39;s)
            // 6 of a Kind
            // 4 of a Kind + 3 of a Kind
            // 5 of a Kind
            // 3 of a Kind + 3 of a Kind
            // 3 of a Kind + 2 Pairs
            // Straight
            // 4 of a Kind
            
            /*
                    $m_6_6_d_count, $m_6_6_d_amount, $m_5_6_b_d_count, $m_5_6_b_d_amount, $m_5_6_d_count, 
          $m_5_6_d_amount, $m_4_6_d_count, $m_4_6_d_amount, $m_3_6_d_count, $m_3_6_d_amount, 
             * 
             * 
             * 
                $m_7k_1s_i_count, $m_7k_1s_i_amount, 
             *  $m_7k_2s_to_6s_i_count, $m_7k_2s_to_6s_i_amount,
                $m_6k_i_amount, $m_6k_i_count, 
             *  $m_4k_3k_i_count, $m_4k_3k_i_amount, 
             *  $m_5k_i_count,  $m_5k_i_amount, 
             *  $m_3k_3k_i_count, $m_3k_3k_i_amount, 
             *  $m_3k_2p_i_count, $m_3k_2p_i_amount, 
                $m_st_i_count, $m_st_i_amount, 
             * $m_4k_i_count, $m_4k_i_amount
            */
            
            print "\n" . $lmatches[1] . "\n";
              if (preg_match("/7 Ones \(1&#39;s\)/i", $lmatches[1], $lot_mat_)) {
                  // m_7k_1s_i_count
                  // m_7k_1s_i_amount
                  print_r($lot_mat_);
                  print $lmatches[1];
                $m_7k_1s_i_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
                $m_7k_1s_i_count  = trim($lmatches[2]);
                $m_7k_1s_i_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_7k_1s_i_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
                if (!$m_7k_1s_i_prize_id) {
                    $m_7k_1s_i_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_7k_1s_i_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
                }
                if ($debug_mode > 1) {
                    print "[m_7k_1s|" . $m_7k_1s_i_amount . "|" . $m_7k_1s_i_prize_id . "|" . $m_7k_1s_i_count . "]";
                }                
              } else if (preg_match("/7 of a Kind \(2&#39;s-6&#39;s\)/i", $lmatches[1], $lot_mat_)) {
                  // m_7k_2s_6s_i_count
                  // m_7k_2s_6s_i_amount
                $m_7k_2s_6s_i_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
                $m_7k_2s_6s_i_count  = trim($lmatches[2]);
                $m_7k_2s_6s_i_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_7k_2s_6s_i_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
                if (!$m_7k_2s_6s_i_prize_id) {
                    $m_7k_2s_6s_i_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_7k_2s_6s_i_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
                }
                if ($debug_mode > 1) {
                    print "[m_7k_2s_6s|" . $m_7k_2s_6s_i_amount . "|" . $m_7k_2s_6s_i_prize_id . "|" . $m_7k_2s_6s_i_count . "]";
                }      
                  
              } else if (preg_match("/6 of a Kind/i", $lmatches[1], $lot_mat_)) {
                   // m_6k_i_count
                  // m_6k_i_amount 
                  
                $m_6k_i_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
                $m_6k_i_count  = trim($lmatches[2]);
                $m_6k_i_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_6k_i_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
                if (!$m_6k_i_prize_id) {
                    $m_6k_i_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_6k_i_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
                }
                if ($debug_mode > 1) {
                    print "[m_6k|" . $m_6k_i_amount . "|" . $m_6k_i_prize_id . "|" . $m_6k_i_count . "]";
                }     
              } else if (preg_match("/4 of a Kind \+ 3 of a Kind/i", $lmatches[1], $lot_mat_)) {
                  // $m_4k_3k_i_count, 
                  //$m_4k_3k_i_amount, 
              
                $m_4k_3k_i_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
                $m_4k_3k_i_count  = trim($lmatches[2]);
                $m_4k_3k_i_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_4k_3k_i_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
                if (!$m_4k_3k_i_prize_id) {
                    $m_4k_3k_i_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_4k_3k_i_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
                }
                if ($debug_mode > 1) {
                    print "[m4k_3k|" . $m_4k_3k_i_amount . "|" . $m_4k_3k_i_prize_id . "|" . $m_4k_3k_i_count . "]";
                }      
                                
                  
              } else if (preg_match("/5 of a Kind/i", $lmatches[1], $lot_mat_)) {
                  // m_5k_i_count
                  // m_5k_i_amount
              
                    $m_5k_i_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
                    $m_5k_i_count  = trim($lmatches[2]);
                    $m_5k_i_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_5k_i_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
                    if (!$m_5k_i_prize_id) {
                        $m_5k_i_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_5k_i_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
                    }
                    if ($debug_mode > 1) {
                        print "[m5k|" . $m_5k_i_amount . "|" . $m_5k_i_prize_id . "|" . $m_5k_i_count . "]";
                    }      
                          
                  
              
              
              } else  if (preg_match("/3 of a Kind \+ 3 of a Kind/i", $lmatches[1], $lot_mat_)) {
                  
                  // m_3k_3k_i_count
                  // m_3k_3k_i_amount
              
                    $m_3k_3k_i_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
                    $m_3k_3k_i_count  = trim($lmatches[2]);
                    $m_3k_3k_i_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_3k_3k_i_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
                    if (!$m_3k_3k_i_prize_id) {
                        $m_3k_3k_i_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_3k_3k_i_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
                    }
                    if ($debug_mode > 1) {
                        print "[m3k_3k|" . $m_3k_3k_i_amount . "|" . $m_3k_3k_i_prize_id . "|" . $m_3k_3k_i_count . "]";
                    }      
                                            
                  
              } else if (preg_match("/3 of a Kind \+ 2 Pairs/i", $lmatches[1], $lot_mat_)) {
                  // m_3k_2p_i_count
                  // m_3k_2p_i_amount
                    $m_3k_2p_i_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
                    $m_3k_2p_i_count  = trim($lmatches[2]);
                    $m_3k_2p_i_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_3k_2p_i_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
                    if (!$m_3k_2p_i_prize_id) {
                        $m_3k_2p_i_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_3k_2p_i_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
                    }
                    if ($debug_mode > 1) {
                        print "[m3k_2p|" . $m_3k_2p_i_amount . "|" . $m_3k_2p_i_prize_id . "|" . $m_3k_2p_i_count . "]";
                    }                    
                  
              
              } else if (preg_match("/Straight/i", $lmatches[1], $lot_mat_)) {
                  // m_st_i_count
                  // m_st_i_amount
              
                    $m_st_i_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
                    $m_st_i_count  = trim($lmatches[2]);
                    $m_st_i_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_st_i_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
                    if (!$m_st_i_prize_id) {
                        $m_st_i_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_st_i_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
                    }
                    if ($debug_mode > 1) {
                        print "[mst|" . $m_st_i_amount . "|" . $m_st_i_prize_id . "|" . $m_st_i_count . "]";
                    }                    
                                    
                  
              } else if (preg_match("/4 of a Kind/i", $lmatches[1], $lot_mat_)) {
                  // m_4k_i_count
                  // m_4k_i_amount
                    $m_4k_i_amount  = str_replace($str_money_sym,"", trim($lmatches[3]));
                    $m_4k_i_count  = trim($lmatches[2]);
                    $m_4k_i_prize_id   = $objLottery->dbLotteryWinPrizesGetId($m_4k_i_amount, $objLottery->prz_money, $onMegaDice_row["gameid"]);
                    if (!$m_4k_i_prize_id) {
                        $m_4k_i_prize_id   = $objLottery->dbLotteryWinPrizesAdd($m_4k_i_amount, $objLottery->prz_money, trim($lmatches[3]), $onMegaDice_row["gameid"]);
                    }
                    if ($debug_mode > 1) {
                        print "[m4k|" . $m_4k_i_amount . "|" . $m_4k_i_prize_id . "|" . $m_4k_i_count . "]";
                    } 
                    
                    $sMegaDice_drawDate = strtotime($sdrawdate);
                    $sMegaDice_drawDate = date('Y-m-d', $sMegaDice_drawDate);
                    $onMegaDiceId = $objOLG->OLGMegaDiceGetDrawId($sMegaDice_drawDate);
                    
                    
                    
                    
                    if ($onMegaDiceId != null) {
                        
                        $onMegaDiceWinningsId = $objOLG->OLGMegaDiceWinningsGetId($onMegaDiceId);
                        $onMegaDiceWinningsId = $objOLG->OLGMegaDiceWinningsAdd($onMegaDiceId, $m_6_6_d_count, $m_6_6_d_prize_id, $m_5_6_b_d_count, $m_5_6_b_d_prize_id,
                                    $m_5_6_d_count, $m_5_6_b_d_prize_id, $m_4_6_d_count, $m_4_6_d_prize_id, $m_3_6_d_count, $m_3_6_d_prize_id,
                                    $m_7k_1s_i_count, $m_7k_1s_i_prize_id, $m_7k_2s_6s_i_count, $m_7k_2s_6s_i_prize_id, $m_6k_i_count, $m_6k_i_prize_id,
                                    $m_4k_3k_i_count, $m_4k_3k_i_prize_id, $m_5k_i_count, $m_5k_i_prize_id, $m_3k_3k_i_count, $m_3k_3k_i_prize_id,
                                    $m_3k_2p_i_count, $m_3k_2p_i_prize_id, $m_st_i_count, $m_st_i_prize_id, $m_4k_i_count, $m_4k_i_prize_id
                                    ,0); 
                    }
                    if ($debug_mode > 1) {
                        print "[pkId: " . $onMegaDiceId . "|" . $onMegaDiceWinningsId . "]";
                    }   
                    
              }
              
         
          }
        }
        
      }
      
          
    
  
  
  ?>