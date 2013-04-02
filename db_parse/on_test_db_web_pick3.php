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
  $cmdargs 	= arguments();
  
  
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^update/i", $cmdargs["standard"][1], $lmatches)) {
  		$lottery_draw_data_dates = $objOLG->OLGPick3GetFirstLastDataAvail();
                /*
                 * Added one year earlier default when database is empty
                 * 
                 * 
                 * 
                 */
                if ($lottery_draw_data_dates["latest"] == "") {
                    $lottery_draw_data_dates["latest"] = date('Y-m-d',strtotime(date('Y-m-d') . ' -1 year'));
                }                
                //print_r($lottery_draw_data_dates);

               // die();
  		$startDay 	= date('d',strtotime($lottery_draw_data_dates["latest"]));
  		$startMonth = date('m',strtotime($lottery_draw_data_dates["latest"]));
  		$startYear 	= date('Y',strtotime($lottery_draw_data_dates["latest"]));
  		$endDay 	= date('d');
  		$endMonth 	= date('m');
  		$endYear    = date('Y');
  		
  		
  		
  		
  		$startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
		$endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);
  		$drawDates  = $objLottery->dbLotteryGetDrawDates("onPick3", "MM", $startDate, $endDate); 
  		print "Start Date: " . $startDate . " --- End Date: " . $endDate;
                //die();
  	} elseif (preg_match("/^getMonth/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
                    $selectedMonth = $lsubmat[1];
                    $selectedYear  = $lsubmat[2];
                    $startDate     = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
                    $endDate       = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
                    $drawDates     = $objLottery->dbLotteryGetDrawDates("onPick3", "MM", $startDate, $endDate); 
  		}
  	} elseif (preg_match("/^getYear/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{4})|(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		      $selectedYear = $lsubmat[1];
      	  	  $startDate    = mktime(0,0,0,1,1,$selectedYear);
      	  	  $endDate      = mktime(0,0,0,12,31,$selectedYear);
      	  	  $drawDates    = $objLottery->dbLotteryGetDrawDates("onPick3", "YY", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/^getDraw/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		    //print_r($lmatches); 
      	  	$selectedDay    = $lsubmat[1];
      	  	$selectedMonth  = $lsubmat[2];
      	  	$selectedYear   = $lsubmat[3];
      	  	$startDate      = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$endDate        = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$drawDates      = $objLottery->dbLotteryGetDrawDates("onPick3", "DD", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4}) - (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][1], $lmatches)) {
            $startDay          = $lmatches[1];
            $startMonth        = $lmatches[2];
            $startYear         = $lmatches[3];
            $endDay            = $lmatches[4];
            $endMonth          = $lmatches[5];
            $endYear           = $lmatches[6];
            $startDate         = mktime(0,0,0,$startMonth, $startDay , $startYear);
            $endDate           = mktime(0,0,0,$endMonth, $endDay, $endYear);
            $drawDates         = $objLottery->dbLotteryGetDrawDates("onPick3", "DD1DD2", $startDate, $endDate);
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
        on_fetch_first_step_pick3(date('d-m-Y', $drawDate));  
       // die();
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
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onPick3", "DD1DD2", $startDate, $endDate);
		} elseif (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		   print_r($lmatches); 
		  $selectedDay    = $lmatches[1];
		  $selectedMonth  = $lmatches[2];
		  $selectedYear   = $lmatches[3];
		  $startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onPick3", "DD", $startDate, $endDate);
		} elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
		  $selectedMonth = $lmatches[1];
		  $selectedYear = $lmatches[2];
		  $startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
		  $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onPick3", "MM", $startDate, $endDate);   
		  //print_r($lmatches);
		  //print_r(date('d-m-Y',$startDate));
		  //print " -- ";
		  //print_r(date('d-m-Y',$endDate));
		  //print_r($drawDates);
		} elseif (preg_match("/getYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
		  $selectedYear = $lmatches[1];
		  $startDate    = mktime(0,0,0,1,1,$selectedYear);
		  $endDate      = mktime(0,0,0,12,31,$selectedYear);
		  $drawDates = $objLottery->dbLotteryGetDrawDates("onPick3", "YY", $startDate, $endDate);
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
			on_fetch_first_step_pick3(date('d-m-Y', $drawDate));    
		  }
		}    
		
  	} while (trim($selection) != 'q');
  }
  
  function on_fetch_first_step_pick3($drawdate = "") {
    
    
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
      
      
      $onPick3GameId          = 6;
      
      $hp_day                 = 0;
      $hp_gameID              = $onPick3GameId;
      $hp_command             = 'submit';
      
      $onPick3_row  = $objLottery->dbLotteryGamesGet("onPick3");
      
      
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
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onPick3", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onPick3", $onPick3_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onPick3", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
      $http->postvars['selectedMonthYear']    = $hp_selectedMonthYear;
      $http->postvars['day']                  = $hp_day;
      $http->postvars['gameID']               = $hp_gameID;
      $http->postvars['command']              = $hp_command;
      print_r($http->postvars);
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
      //print_r($html_tr_list);
      //die();
      
      
      $bOnPick3_m     	= 0;
      $bOnPick3_m_2 	= 0;
      
      
      $srg_onEncore     = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
      $srg_onPick3      = "\s*(\d)\s*(\d)\s*(\d)\s*"; 
        
      $sPick3_th_Line   = $srgB_th . "(.*?)" . $srgE_th;        // Date
      $sPick3_th_Line   .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // Day
      $sPick3_th_Line   .= "\s*" . $srgB_th . "(.*?)" ;                 // Numbers
      $sPick3_th_Line   .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // ENCORE
      $sPick3_th_Line   .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;       // WINNINGS
      
      $sPick3_th_Line_2 = $srgB_th . "\s*(.*?)\s*" . $srgE_th;        			// Date
      $sPick3_th_Line_2 .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th; 		// Time
      $sPick3_th_Line_2 .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;       // Day
      $sPick3_th_Line_2   .= "\s*" . $srgB_th . "\s*(.*?)" ;                 // Numbers
      $sPick3_th_Line_2   .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;       // ENCORE
      $sPick3_th_Line_2   .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;       // WINNINGS
      
      
      /*
       * 
       * 
       <tr>
        <th class="white_centre" id="lottery_borderless" align="center">
	DATE
	</th>
	<th class="white_centre" id="lottery_borderless" align="center">Time
	</th>
	<th class="white_centre" id="lottery_borderless" align="center">
	DAY
	</th>
	<th class="white_centre" id="lottery_borderless" align="center">
	NUMBERS
	<th class="white_centre" id="lottery_borderless" align="center">
	ENCORE
	</th>
	<th class="white_centre" id="lottery_borderless" align="center">
	WINNINGS</th>
	</tr>
       * 
       * 
       */
      
      
      
      
      
      
      /*
      $sPick3_td_Line     = $srgB_td . "(.*?)"  . $srgE_td;        // Date
      $sPick3_td_Line     .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day
      $sPick3_td_Line     .= "\s*" . $srgB_td .   "(.*?)" . $srg_comment;   // Numbers
      $sPick3_td_Line     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Encore
      $sPick3_td_Line     .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings

		*/
      
      
      $sPick3_td_Line     = $srgB_td . "(.*?)"  . $srgE_td;        // Date
      $sPick3_td_Line    .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day
      $sPick3_td_Line    .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;
      $sPick3_td_Line     .= "\s*" . $srgB_td .   "(.*?)" . $srg_comment;   // Numbers
      $sPick3_td_Line     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Encore
      $sPick3_td_Line    .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings
      
      
      $sPick3_td_Line_2     = $srgB_td . "(.*?)"  . $srgE_td;        			// Date
      $sPick3_td_Line_2     .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;			// Time
      $sPick3_td_Line_2     .= "\s*" . $srgB_td  . "(.*?)"  .  $srgE_td;       // Day
     // $sPick3_td_Line_2     .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;
      $sPick3_td_Line_2     .= "\s*" . $srgB_td .   "(.*?)" . $srg_comment;   // Numbers
      $sPick3_td_Line_2     .= "\s*" . $srgB_td .   "(.*?)" .  $srgE_td;       // Encore
      $sPick3_td_Line_2     .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;       // Winnings
      
      /*
       * 
       * 
       * 
       * 
       * 
    <tr bgcolor="#fab650">
   [1] <td style="margin-top:0px" id="lottery_border" align="center" valign="middle">
    <p class="blue"  style="margin:0px 0 0 0;"><strong>
        31-Mar-2012
    </strong></p>
    </td>
   [2] <td id="lottery_border" align="left" valign="middle">
    <p class="blue"  style="margin:0px 0 0 0;"> <strong>EVENING</strong></p>
    </td>
   [3] <td id="lottery_border" align="center" valign="middle">
    <p class="blue"><strong>
        Sat
    </strong></p>
    </td>
   [4] <td id="lottery_border" align="center">
    <strong>
    <p class="blue">
        5
	4
	8
	<!-- Plus Numbers -->
			<td id="lottery_border" align="center"  valign="middle" >
			<p class="blue" style="margin:0px 0 0 0;"><strong>8526414</strong></p>
			</td>
			
			<form name="winningNumbersForm" method="post" action="/lotteries/viewPrizeShares.do">
				<td id="lottery_border" align="center" valign="middle" >
				<input type="hidden" name="gameID" value="6"> 
				<input type="hidden" name="drawNo" value="8020"> 
				<input type="hidden" name="sdrawDate" value="1333242060000"> 
				<input type="hidden" name="spielID" value="20"> <input
					type="image" style="margin:0px 0 0 0;"  src="/assets/img/consumer_wn_pot_gold.gif" alt="WINNINGS"
					width="23px" height="25px" border="0" onclick="this.form.submit();">
				</td>
			</form>
		</tr>
			
       * 
       * 
       * 
       * 
       * 
       */
      
      
      
      
      
      
      $str_money_sym = array("$",","); 
      
      $srgDays          = "Sun|Mon|Tue|Wed|Thu|Fri|Sat"; 
      $srgMonths        = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
      
      // Debug POS: 3 --- return of html content for the whole month
      // print_r ($html_tr_list);
      
      
      if ($debug_mode > 0) {
        //print "\nFetch " . $site_file . $site_querystr;
        print "\nDate: " . date('Y-m-d', $drawdate);
      }    
      foreach($html_tr_list as $html_tr) {
        //print $html_tr;
        
        //die();
      	if (preg_match("/" . $sPick3_th_Line_2 . "/i", $html_tr, $lmatches)) {
      		$bOnPick3_m_2 = 1;
                //print $html_tr;
               // die();
      	} elseif ($bOnPick3_m_2 == 1 &&
      			(preg_match("/" . $sPick3_td_Line_2 . "/i", $html_tr, $lmatches))) {
      		
                        print $html_tr;
      		//print_r($lmatches);
                //die();
      		if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
      			//print_r($lotResMat);
      			$sdrawMonthName = trim($lotResMat[2]);
      			$sdrawMonthNum  = $objDate->getShortMonthNum($sdrawMonthName);
      			$sdrawDay       = $lotResMat[1];
      			$sdrawYear      = $lotResMat[3];
      			$sPick3_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
      			//print "\nPick 3 DrawDate: " . $sPick3_drawdate;
      			 
      			if ($debug_mode > 1) {
      				print "\n[" . $sPick3_drawdate . "]";
      			}
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
      			$sdrawDayName   = trim($lotResMat[1]);
      		}
      		
      		
      		// print_r($html_br_list);
      		
      		if (preg_match("/" . $srg_onPick3 . "/i", $lmatches[4], $lotResMat)) {
      			//print_r($lotResMat);
      			$snum1      = $lotResMat[1];
      			$snum2      = $lotResMat[2];
      			$snum3      = $lotResMat[3];
      		
      			if ($debug_mode > 1) {
      				print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "]";
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
      				print "[" . $str_gameid . "|" . $str_drawNo . "|" . $str_drawDate . "|" . $str_spielId . "]";
      			}
      		}
      		$sPick3_drawdate = strtotime($sPick3_drawdate);
      		$sPick3_drawdate = date('Y-m-d',$sPick3_drawdate);
      		
               
                
                $onPick3DrawId  = $objOLG->OLGPick3GetDrawId($sPick3_drawdate, $sdrawTime);
      		
                
      		
      		//printf("\nstr_gameid : %u - str_drawNo: %u - str_drawdate: %u - str_spielId : %u", $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
                
      		if (!$onPick3DrawId) {
                    
                    //($drawdate, $idrawnum, $snum1, $snum2, $snum3 , $drawNo, $sdrawDate, $spielID, $sdrawTime = "")
      			$onPick3DrawId = $objOLG->OLGPick3Add($sPick3_drawdate, 0, $snum1, $snum2, $snum3, $str_drawNo, $str_drawDate, $str_spielId, $sdrawTime);
      		}
      		
      		if ($debug_mode > 1) {
      			print "[" . $sPick3_drawdate . "|" . $onPick3DrawId . "]";
      		}
      		$str_onEncoreId = $objOLG->OLGEncoreGetDrawId($sPick3_drawdate, $sdrawTime);
      		if (!$str_onEncoreId) {
      			$str_onEncoreId = $objOLG->OLGEncoreAdd($sPick3_drawdate, "", $senc_num1, $senc_num2, $senc_num3, $senc_num4, $senc_num5, $senc_num6, $senc_num7, $sdrawTime);
      		}
      		
      		if ($onPick3DrawId != null) {
      			$onPick3WinningId = $objOLG->OLGOnPick3WinningsGetId($onPick3DrawId);
      			if (!$onPick3WinningId) {
      				on_fetch_second_step_pick3($sPick3_drawdate, $str_gameid,$str_drawNo, $str_drawDate, $str_spielId, $sdrawTime);
      			}
      		}
      		
      		if ($debug_mode > 1) {
      			print "[" . $sPick3_drawdate . "|" . $str_onEncoreId . "]";
      		}
      		//print "\n\nDraw Date:  " . $sPick3_drawdate . "\n";
      		
      		
      		
      	} else if (preg_match("/" . $sPick3_th_Line . "/i", $html_tr, $lmatches)) {
          $bOnPick3_m   = 1;
           //print_r($lmatches);
        } elseif ($bOnPick3_m == 1 &&
                (preg_match("/" . $sPick3_td_Line . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
              //print_r($lotResMat); 
              $sdrawMonthName = trim($lotResMat[2]);
              $sdrawMonthNum  = $objDate->getShortMonthNum($sdrawMonthName);
              $sdrawDay       = $lotResMat[1];
              $sdrawYear      = $lotResMat[3];
              $sPick3_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
              //print "\nPick 3 DrawDate: " . $sPick3_drawdate;
                   
              if ($debug_mode > 1) {
                print "\n[" . $sPick3_drawdate . "]";
              }
            }
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\w{3})\s*" . $srgE_strong. $srgE_p . "/i",$lmatches[2], $lotResMat)) {
              //print_r($lotResMat);
              $sdrawDayName   = trim($lotResMat[1]);
            }
        
           // print_r($html_br_list);      
      
            if (preg_match("/" . $srg_onPick3 . "/i", $lmatches[3], $lotResMat)) {
              //print_r($lotResMat);
              $snum1      = $lotResMat[1];
              $snum2      = $lotResMat[2];
              $snum3      = $lotResMat[3];
              
              if ($debug_mode > 1) {
                print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "]";
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
                print "[" . $senc_num1 . "|" . $senc_num2 . "|" . $senc_num3 . "|" . $senc_num4 . "|" . $senc_num5 . "|" . $senc_num6 . "|" . $senc_num7 . "]"; 
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
            $sPick3_drawdate = strtotime($sPick3_drawdate);
            $sPick3_drawdate = date('Y-m-d',$sPick3_drawdate);  
            
           
            $onPick3DrawId  = $objOLG->OLGPick3GetDrawId($sPick3_drawdate);
           
            //printf("\nstr_gameid : %u - str_drawNo: %u - str_drawdate: %u - str_spielId : %u", $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
            if (!$onPick3DrawId) {
            	  $onPick3DrawId = $objOLG->OLGPick3Add($sPick3_drawdate, 0, $snum1, $snum2, $snum3, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
            }

            if ($debug_mode > 1) {
              print "[" . $sPick3_drawdate . "|" . $onPick3DrawId . "]";
            }
           
            	$str_onEncoreId = $objOLG->OLGEncoreGetDrawId($sPick3_drawdate);
            if (!$str_onEncoreId) {
            	
            		$str_onEncoreId = $objOLG->OLGEncoreAdd($sPick3_drawdate, "", $senc_num1, $senc_num2, $senc_num3, $senc_num4, $senc_num5, $senc_num6, $senc_num7);
            	
            }
            
             if ($onPick3DrawId != null) {
              	$onPick3WinningId = $objOLG->OLGOnPick3WinningsGetId($onPick3DrawId);
              	if (!$onPick3WinningId) {
                            on_fetch_second_step_pick3($sPick3_drawdate, $str_gameid,$str_drawNo, $str_drawDate, $str_spielId);              			

              	}
            }
            
            if ($debug_mode > 1) {
              print "[" . $sPick3_drawdate . "|" . $str_onEncoreId . "]";
            }
            //print "\n\nDraw Date:  " . $sPick3_drawdate . "\n";
            
        }
      }
      
          
    
    
  } 
  
  function on_fetch_second_step_pick3($sdrawdate, $str_gameid, $str_drawNo, $str_drawdate, $str_spielid, $sdrawTime = "") {
      global $debug_mode;
    
      $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
      
      $objLottery   = new Lottery();
      $objDate      = new GenDates();
      $objOLG       = new OLGLottery();
      $naLottery    = new NALottery();
      $onPick3_row  = $objLottery->dbLotteryGamesGet("onPick3");
      $onEncore_row = $objLottery->dbLotteryGamesGet("onEncore");
      
      $drawdate = strtotime($sdrawdate);
      
      $onPick3GameId          = 6;
            
      $hp_gameID     = $onPick3GameId;
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
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onPick3", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onPick3", $onPick3_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onPick3", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
      
      
      $onPick3GameId          = 6;
      
      
      $http->postvars['gameID']     = $onPick3GameId;
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
      
      $sPick3_m     = 0;
      $sEncore_m  = 0;
      
      $srg_Pick3_Winning_Hdr = "WINNINGS FOR \s* PICK-3"; //WINNINGS FOR PICK-3
      $srg_encore_Winning_Hdr = "WINNINGS FOR ENCORE";
      
      $srgDays    = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
      $srgMonths  = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
      
      
      $sPick3_th_Lines  = $srgB_th . "(.*?)" . $srgE_th;            // Match
      $sPick3_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Number of Winnings 
      $sPick3_th_Lines .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;    // Prize
      
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
      
      $sPick3_td_Lines = $srgB_td . "\s*" . $srgB_p . $srgB_strong .  "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" .  $srgE_td;
      $sPick3_td_Lines .=  "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      $sPick3_td_Lines .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
      
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
        //print "\nFetch " . $site_file . $site_querystr;
        print "\nDate: " . date('Y-m-d', $drawdate);
      }    
      foreach ($html_tr_list as $html_tr) {
        if (preg_match("/". $srg_Pick3_Winning_Hdr . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
          $sPick3_m     = 1;
          $sEncore_m    = 0;
        } elseif (preg_match("/" . $srg_encore_Winning_Hdr . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
          $sPick3_m     = 0;
          $sEncore_m    = 1;
        } elseif ($sPick3_m == 1 &&
                  preg_match("/" . $sPick3_th_Lines . "/i", $html_tr, $lmatches)) {
          //print_r($lmatches);
          
           
        } elseif ($sPick3_m == 1 &&
                  preg_match("/" . $sPick3_td_Lines . "/i", $html_tr, $lmatches)) {
          //print_r ($lmatches);   
          if (preg_match("/Straight/i", $lmatches[1], $lot_m_ )) {
            $m_str_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $m_str_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m_str_prze_amt, $objLottery->prz_money, $onPick3_row["gameid"]);
            if (!$m_str_prze_id) {
              $m_str_prze_id = $objLottery->dbLotteryWinPrizesAdd($m_str_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onPick3_row["gameid"]);
            }
            $m_str_win_count  = trim($lmatches[2]);
            
            print "[STR|" . $m_str_prze_amt . "|" . $m_str_prze_id . "]";
            
          } elseif (preg_match("/BOX/i", $lmatches[1], $lot_m_ )) {
            $m_box_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
            $m_box_prze_id  = $objLottery->dbLotteryWinPrizesGetId($m_box_prze_amt, $objLottery->prz_money, $onPick3_row["gameid"]);
            if (!$m_box_prze_id) {
              $m_box_prze_id = $objLottery->dbLotteryWinPrizesAdd($m_box_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $onPick3_row["gameid"]);
            }
            $m_box_win_count  = trim($lmatches[2]);
            
            print "[BOX|" . $m_box_prze_amt . "|" . $m_box_prze_id . "]";
            
            $sPick3_drawDate = strtotime($sdrawdate);
            $sPick3_drawDate = date('Y-m-d', $sPick3_drawDate);
            if ($sdrawTime != "") {
	            $onPick3Id  = $objOLG->OLGPick3GetDrawId($sPick3_drawDate, $sdrawTime);
            } else {
            	$onPick3Id  = $objOLG->OLGPick3GetDrawId($sPick3_drawDate);
           	}
            if ($onPick3Id != null) {
              $onPick3WinningId = $objOLG->OLGOnPick3WinningsGetId($onPick3Id);
              if (!$onPick3WinningId) {
                $onPick3WinningId = $objOLG->OLGOnPick3WinningsAdd($onPick3Id, $m_str_win_count, $m_str_prze_id, $m_box_win_count, $m_box_prze_id, 0);
              }
              /*print "\nDraw DetailID: " . $onPick3WinningId . " Pick3Id: " . $onPick3Id;
              print "\nStr Count : " . $m_str_win_count . " Str Prze Amt: " . $m_str_prze_id;
              print "\nBox Count : " . $m_box_win_count . " Box Prze Amt: " . $m_box_prze_id;
               * 
               */
              
            }
            print "[" . $onPick3WinningId . "]";
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