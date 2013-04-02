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
  // 3 = Extra debug info
  
  $debug_mode         = 2;
  
  $objLottery = new Lottery();
  $objOLG     = new OLGLottery();
  
  $cmdargs = arguments();
  
  
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^update/i", $cmdargs["standard"][1], $lmatches)) {
  		$lottery_draw_data_dates = $objOLG->OLGKenoGetFirstLastDataAvail();
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
  		$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "MM", $startDate, $endDate); 
  		
  	} elseif (preg_match("/^getMonth/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  			print "Month selected : " . print_r($lsubmat, 1);
  			$selectedMonth = $lsubmat[1];
      	  	$selectedYear = $lsubmat[2];
      	  	$startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      	    $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      	  	$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "MM", $startDate, $endDate); 
  		}
  	} elseif (preg_match("/^getYear/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{4})|(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		      $selectedYear = $lsubmat[1];
      	  	  $startDate    = mktime(0,0,0,1,1,$selectedYear);
      	  	  $endDate      = mktime(0,0,0,12,31,$selectedYear);
      	  	  $drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "YY", $startDate, $endDate);
  		}  	
  	} elseif (preg_match("/^getDraw/i", $cmdargs["standard"][1], $lmatches)) {
  		if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $cmdargs["standard"][2], $lsubmat)) {
  		    //print_r($lmatches); 
      	  	$selectedDay    = $lsubmat[1];
      	  	$selectedMonth  = $lsubmat[2];
      	  	$selectedYear   = $lsubmat[3];
      	  	$startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      	  	$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "DD", $startDate, $endDate);
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
      	$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "DD1DD2", $startDate, $endDate);
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
        on_fetch_first_step_keno(date('d-m-Y', $drawDate));
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
      		$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "DD1DD2", $startDate, $endDate);
    	} elseif (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
       		print_r($lmatches); 
      		$selectedDay    = $lmatches[1];
      		$selectedMonth  = $lmatches[2];
      		$selectedYear   = $lmatches[3];
      		$startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      		$endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      		$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "DD", $startDate, $endDate);
    	} elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
      		$selectedMonth = $lmatches[1];
      		$selectedYear = $lmatches[2];
      		$startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      		$endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      		$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "MM", $startDate, $endDate);    
    	} elseif (preg_match("/getYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
     	 	$selectedYear = $lmatches[1];
      		$startDate    = mktime(0,0,0,1,1,$selectedYear);
      		$endDate      = mktime(0,0,0,12,31,$selectedYear);
      		$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "YY", $startDate, $endDate);
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
			on_fetch_first_step_keno(date('d-m-Y', $drawDate));
		  }
		}    
		
	   } while (trim($selection) != 'q');
  }
  
  function on_fetch_first_step_keno($drawdate = "") {
      global $debug_mode;
          
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
      
      $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
      
       $onKenoGameId   = 9;
      
      $hp_day                = 0;   // All Days
      $hp_gameID             = $onKenoGameId;
      $hp_command            = 'submit';
      
      
      $onKeno_row             = $objLottery->dbLotteryGamesGet("onKeno");
    
    
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
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onKeno", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onKeno", $onKeno_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onKeno", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
      $onKenoGameId   = 9;
      
    
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
      
      
      
       
      //$html_body = preg_replace("/" . $spattern . "/i","$1", $html_body);
      $html_tr_list = preg_split("/" . $srgB_tr . "/i", $html_body);
      //$html_input_list = preg_split("/<br \/>/i", $html_tr_list[6]);
      //print_r($html_input_list);
      //print_r ($html_tr_list);
      
      $bKeno_m = 0;
	  $bKeno_m_1 = 0;
	        
      $srg_onEncore = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
        
      $srg_onKeno = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
      $srg_onKeno .= "(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
      $srg_onKeno .= "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
      $srg_onKeno .= "(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*" ;
      
      
      $skenoLinePattern = $srgB_td . "(.*?)" . $srgE_td;
      $skenoLinePattern .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;
      $skenoLinePattern .= "\s*" . $srgB_td . "(.*?)" . $srg_comment;
      $skenoLinePattern .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;
      $skenoLinePattern .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr; 
      
      
      
      $skenoLinePattern1 = $srgB_td . "(.*?)" . $srgE_td;						// date
      $skenoLinePattern1 .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;				// Time
      $skenoLinePattern1 .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;				// DAY
      $skenoLinePattern1 .= "\s*" . $srgB_td . "(.*?)" . $srg_comment;				// NUMBERS
      $skenoLinePattern1 .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;					// ENCORE
      $skenoLinePattern1 .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr;   // WINNING DETAILS
      
      /*
       * 		
		
		<tr bgcolor="#fab650">
			<td valign="middle" align="center" id="lottery_border" style="margin-top:0px">
			<p style="margin:0px 0 0 0;" class="blue"><strong>
				13-Feb-2013
			</strong></p>
			</td>
			<td valign="middle" align="left" id="lottery_border">
			  	  <p style="margin:0px 0 0 0;" class="blue"><strong>MIDDAY</strong></p>
			</td>
				<td valign="middle" align="center" id="lottery_border">
				<p class="blue"><strong>
					Wed
				</strong></p>
				</td>
			<td align="center" id="lottery_border">
			<strong>
			<p class="blue">
					02
					08
					11
					16
					19
					29
					34
					36
					39
					40
						<br>
					45
					47
					48
					53
					55
					57
					58
					64
					67
					70
						<br>
			<!-- Plus Numbers -->
			</p></strong></td><td valign="middle" align="center" id="lottery_border">
			<p style="margin:0px 0 0 0;" class="blue"><strong>2073672</strong></p>
			</td>
			<form action="/lotteries/viewPrizeShares.do" method="post" name="winningNumbersForm"></form>
				<td valign="middle" align="center" id="lottery_border">
				<input type="hidden" value="9" name="gameID"> 
				<input type="hidden" value="6388" name="drawNo"> 
				<input type="hidden" value="1360782060000" name="sdrawDate"> 
				<input type="hidden" value="21" name="spielID"> <input width="23px" type="image" height="25px" border="0" onclick="this.form.submit();" alt="WINNINGS" src="/assets/img/consumer_wn_pot_gold.gif" style="margin:0px 0 0 0;">
				</td>
		</tr>

       * 
       * 
       * 
       */
      
      
      
      
      
      
      
      
      
      /*
      <td id="lottery_border" align="center" valign="middle">     <p class="blue"  style="margin:0px 0 0 0;"><strong>      28-Feb-2010     </strong></p>     
      </td>   
              <td id="lottery_border" align="center">      <p class="blue"><strong>       Sun      </strong></p>      </td>          
      <td id="lottery_border" align="center">     <strong>               <p class="blue">    04  06    09  14  15  21 23  24 
      <br /> <!-- Plus Numbers -->  <td id="lottery_border" align="center"  valign="middle" >     <p class="blue" style="margin:0px 0 0 0;">
      <strong>6431714</strong></p>     </td>         
       <form name="winningNumbersForm" method="post" action="/lotteries/viewPrizeShares.do">  
           <td id="lottery_border" align="center" valign="middle" >    
             <input type="hidden" name="gameID" value="9">  
                  <input type="hidden" name="drawNo" value="5054">    
                     <input type="hidden" name="sdrawDate" value="1267408860000"> 
                           <input type="hidden" name="spielID" value="21">
                            <input       type="image" style="margin:0px 0 0 0;"  src="/assets/img/consumer_wn_pot_gold.gif" alt="WINNINGS"      
                             width="23px" height="25px" border="0" onclick="this.form.submit();">  
                                </td>     </form>    </tr>  
       * 
       * 
       * 
       *<td[^>]*>\s*<p[^>]*>\s*<strong>\s*(.*)\s*<\/strong>\s*<\/p>\s*<\/td>\s*<td[^>]*>\s*<p[^>]*>\s*<strong>\s*(\w*)\s*srgE_strong\s*\s*.*<strong>\s*<p[^>]*>\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*<br[^]*>\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*<br[^]*>.*<p[^>]*>\s*<strong>\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*<\/strong>\s*<\/p>\s*<\/td>.*<form .* action=.(.*). [^>]*>\s*<td[^>]*>\s*<input .*name=.gameID. \s*value=.(\d+).\s*>\s*\s*<input .*name=.drawNo. \s*value=.(\d+).\s*>\s*\s*<input .*name=.sdrawDate. \s*value=.(\d+).\s*>\s*\s*<input[^>]*>
       * 
      */  
      
      
      /*
      <tr>
      <th align="center" id="lottery_borderless" class="white_centre">
      DATE
      </th>
      <th align="center" id="lottery_borderless" class="white_centre">Time
      </th>
      <th align="center" id="lottery_borderless" class="white_centre">
      DAY
      </th>
      <th align="center" id="lottery_borderless" class="white_centre">
      NUMBERS
      </th><th align="center" id="lottery_borderless" class="white_centre">
      ENCORE
      </th>
      <th align="center" id="lottery_borderless" class="white_centre">
      WINNINGS</th>
      </tr>
      */
      
      
      
      

      $spattern =  $srgB_th . "\s*(DATE)\s*" . $srgE_th;
      $spattern .= "\s*" . $srgB_th . "\s*(DAY)\s*" . $srgE_th;
      $spattern .= "\s*" . $srgB_th . "\s*(NUMBERS)\s*" ;
      $spattern .= "\s*" . $srgB_th . "\s*(ENCORE)\s*" . $srgE_th;
      $spattern .= "\s*" . $srgB_th . "\s*(WINNINGS)\s*" . $srgE_th . "\s*" . $srgE_tr;
      
      
      
      $spattern1 =  $srgB_th . "\s*(DATE)\s*" . $srgE_th;
      $spattern1 .= "\s*" . $srgB_th . "\s*(Time)\s*" . $srgE_th;
      $spattern1 .= "\s*" . $srgB_th . "\s*(DAY)\s*" . $srgE_th;
      $spattern1 .= "\s*" . $srgB_th . "\s*(NUMBERS)\s*" ;
      $spattern1 .= "\s*" . $srgB_th . "\s*(ENCORE)\s*" . $srgE_th;
      $spattern1 .= "\s*" . $srgB_th . "\s*(WINNINGS)\s*" . $srgE_th . "\s*" . $srgE_tr;
      
      
      
      
      $srgDays    = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
      $srgMonths  = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
      
      $str_money_sym = array("$",","); 
      /*
       *  [1] =>      <p class="blue"  style="margin:0px 0 0 0;"><strong>      01-Feb-2010     </strong></p>     
          [2] =>       <p class="blue"><strong>       Mon      </strong></p>      
          [3] =>      <strong>               <p class="blue">                                    01                                                                            09                                                                            11                                                                            22                                                                            23                                                                            24                                                                            29                                                                            30                                                                            33                                                                            38                                          <br />                                                 39                                                                            41                                                                            45                                                                            47                                                                            48                                                                            50                                                                            52                                                                            62                                                                            66                                                                            70                                          <br />                                           
          [4] =>      <p class="blue" style="margin:0px 0 0 0;"><strong>6041557</strong></p>     
          [5] => /lotteries/viewPrizeShares.do
          [6] =>       <input type="hidden" name="gameID" value="9">       <input type="hidden" name="drawNo" value="5027">       <input type="hidden" name="sdrawDate" value="1265076060000">       <input type="hidden" name="spielID" value="21"> <input       type="image" style="margin:0px 0 0 0;"  src="/assets/img/consumer_wn_pot_gold.gif" alt="WINNINGS"       width="23px" height="25px" border="0" onclick="this.form.submit();">  
       * 
       * 
       */
      //print "<br />" . $skenoLinePattern . "<br />";
      //print "<br />" . $spattern . "<br />";
      
      if ($debug_mode > 0) {
        print "\nFetch " . $site_file . $site_querystr;
        print "\nDate: " . date('Y-m-d', $drawdate);
      }
      foreach ($html_tr_list as $html_tr) {
      	
      	
      	
      	
      	
      	if (preg_match("/" . $spattern1 . "/i" , $html_tr, $lmatches)) {
      		$bKeno_m_1 = 1;
      	} else if ($bKeno_m_1 == 1 && 
      			(preg_match("/" . $skenoLinePattern1 . "/i", $html_tr, $lmatches))) {
      		
      		if ($debug_mode > 1) {
      			print "\n KENO LINE: \n";
      			print_r($lmatches);
      		}
       		
      		if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
      			//print_r($lotResMat);
      		
      		
      			$sdrawMonthName       = trim($lotResMat[2]);
      			$sdrawMonthNum        = $objDate->getShortMonthNum($sdrawMonthName);
      			$sdrawDay             = $lotResMat[1];
      			$sdrawYear            = $lotResMat[3];
      			$sKeno_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
      			//print "\nKeno DrawDate: " . $sKeno_drawdate;
      			if ($debug_mode > 1) {
      				print "\n[" . $sKeno_drawdate . "] ";
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
      			$sdrawDayName         = trim($lotResMat[1]);
      		}
      		//print "<br />" . $srg_onKeno . "<br />";
      		$sKenoRes = preg_replace("/<[^>]*>|\s{2}/i", " ", $lmatches[4]);
      		//print_r($sKenoRes);
      		if (preg_match("/" . $srg_onKeno . "/i", $sKenoRes, $lotResMat)) {
      			//print_r($lotResMat);
      			$snum1 = $lotResMat[1];
      			$snum2 = $lotResMat[2];
      			$snum3 = $lotResMat[3];
      			$snum4 = $lotResMat[4];
      			$snum5 = $lotResMat[5];
      			$snum6 = $lotResMat[6];
      			$snum7 = $lotResMat[7];
      			$snum8 = $lotResMat[8];
      			$snum9 = $lotResMat[9];
      			$snum10 = $lotResMat[10];
      			$snum11 = $lotResMat[11];
      			$snum12 = $lotResMat[12];
      			$snum13 = $lotResMat[13];
      			$snum14 = $lotResMat[14];
      			$snum15 = $lotResMat[15];
      			$snum16 = $lotResMat[16];
      			$snum17 = $lotResMat[17];
      			$snum18 = $lotResMat[18];
      			$snum19 = $lotResMat[19];
      			$snum20 = $lotResMat[20];
      		
      			if ($debug_mode > 1) {
      				print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6;
      				print "|" . $snum7 . "|" . $snum8 . "|" . $snum9 . "|" . $snum10 . "|" . $snum11 . "|" . $snum12;
      				print "|" . $snum13 . "|" . $snum14 . "|" . $snum15 . "|" . $snum16 . "|" . $snum17 . "|" . $snum18;
      				print "|" . $snum19 . "|" . $snum20 . "]";
      			}
      		
      		}
      		if (preg_match("/\s*" . $srgB_p . $srgB_strong . $srg_onEncore . $srgE_strong . $srgE_p . "/i", $lmatches[5], $lotResMat)) {
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
      		if (preg_match("/\s*([a-zA-Z.+\/?=]*)\s*/i", $lmatches[6], $lotResMat)) {
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
      		
      		
      			$sKeno_drawdate  = strtotime($sKeno_drawdate);
      			$sKeno_drawdate  = date('Y-m-d', $sKeno_drawdate);
      			$onKenoDrawId    = $objOLG->OLGKenoGetDrawId($sKeno_drawdate , $sdrawTime);				// added sdrawTime as OLG ADDED midday draws
      			//printf("\nstr_gameid : %u - str_drawNo: %u - str_drawdate: %u - str_spielId : %u", $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
      			print "\n<br>sdrawTime:  Draw Time: " . $sdrawTime;
      			if (!$onKenoDrawId) {
      				$onKenoDrawId = $objOLG->OLGKenoAdd($sKeno_drawdate, 0, $snum1, $snum2, $snum3, $snum4,
      						$snum5, $snum6, $snum7, $snum8, $snum9, $snum10,
      						$snum11, $snum12, $snum13, $snum14, $snum15, $snum16,
      						$snum17, $snum18, $snum19, $snum20,  $str_drawNo, $str_drawDate, $str_spielId, $sdrawTime);
      		
      			}
      			if ($debug_mode > 1) {
      				print "[SD- ID " . $onKenoDrawId . "]";
      			}
      			$str_onEncoreId   = $objOLG->OLGEncoreGetDrawId($sKeno_drawdate, $sdrawTime);
      			if (!$str_onEncoreId) {
      				$str_onEncoreId = $objOLG->OLGEncoreAdd($sKeno_drawdate, "", $senc_num1, $senc_num2, $senc_num3, $senc_num4, $senc_num5, $senc_num6, $senc_num7, $sdrawTime);
      			}
      		
      			if ($onKenoDrawId != null) {
      				$onKenoWinningId = $objOLG->OLGOnKenoWinningsGetId($onKenoDrawId);
      				if (!$onKenoWinningId) {
      					on_fetch_second_step_keno($sKeno_drawdate, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId, $sdrawTime);
      				}
      		
      			}
      		
      		
      			if ($debug_mode > 1) {
      				print "\n[SD- ID " . $str_onEncoreId . "]";
      			}
      			//print "\n\nDraw Date: " . $sKeno_drawdate . "\n";
      		            
      		}
      		
      	} else if (preg_match("/" . $spattern . "/i", $html_tr, $lmatches)) {
          $bKeno_m = 1;
          //print_r($lmatches);
        } elseif ($bKeno_m == 1 && 
         (preg_match("/" . $skenoLinePattern . "/i", $html_tr, $lmatches))) {
          //print_r($lmatches);   
          
          if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
            //print_r($lotResMat);   
            
            
            $sdrawMonthName       = trim($lotResMat[2]);
            $sdrawMonthNum        = $objDate->getShortMonthNum($sdrawMonthName);
            $sdrawDay             = $lotResMat[1];
            $sdrawYear            = $lotResMat[3];
            $sKeno_drawdate      = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
            //print "\nKeno DrawDate: " . $sKeno_drawdate;   
            if ($debug_mode > 1) {
                  print "\n[" . $sKeno_drawdate . "] ";
            }   
          }
          if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\w{3})\s*" . $srgE_strong. $srgE_p . "/i",$lmatches[2], $lotResMat)) {
            //print_r($lotResMat);
            $sdrawDayName         = trim($lotResMat[1]);
          }
          //print "<br />" . $srg_onKeno . "<br />";
          $sKenoRes = preg_replace("/<[^>]*>|\s{2}/i", " ", $lmatches[3]);
          //print_r($sKenoRes);
          if (preg_match("/" . $srg_onKeno . "/i", $sKenoRes, $lotResMat)) {
            //print_r($lotResMat);
            $snum1 = $lotResMat[1];
            $snum2 = $lotResMat[2];
            $snum3 = $lotResMat[3];
            $snum4 = $lotResMat[4];
            $snum5 = $lotResMat[5];
            $snum6 = $lotResMat[6];
            $snum7 = $lotResMat[7];
            $snum8 = $lotResMat[8];
            $snum9 = $lotResMat[9];
            $snum10 = $lotResMat[10];
            $snum11 = $lotResMat[11];
            $snum12 = $lotResMat[12];
            $snum13 = $lotResMat[13];
            $snum14 = $lotResMat[14];
            $snum15 = $lotResMat[15];
            $snum16 = $lotResMat[16];
            $snum17 = $lotResMat[17];
            $snum18 = $lotResMat[18];
            $snum19 = $lotResMat[19];
            $snum20 = $lotResMat[20];
            
             if ($debug_mode > 1) {
                  print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6;
                  print "|" . $snum7 . "|" . $snum8 . "|" . $snum9 . "|" . $snum10 . "|" . $snum11 . "|" . $snum12;
                  print "|" . $snum13 . "|" . $snum14 . "|" . $snum15 . "|" . $snum16 . "|" . $snum17 . "|" . $snum18;
                  print "|" . $snum19 . "|" . $snum20 . "]";
              }   
            
          }
          if (preg_match("/\s*" . $srgB_p . $srgB_strong . $srg_onEncore . $srgE_strong . $srgE_p . "/i", $lmatches[5], $lotResMat)) {
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
          if (preg_match("/\s*([a-zA-Z.+\/?=]*)\s*/i", $lmatches[5], $lotResMat)) {
            //print_r($lotResMat);
          }    
          if (preg_match("/\s*" . $srg_gameid . "\s*" . $srg_drawNo . "\s*" . $srg_drawDate . "\s*" . $srg_spielId . "\s*<input[^>]*>" . "/i", $lmatches[6], $lotResMat)) {
            //print_r($lotResMat); 
            
            $str_gameid = $lotResMat[1];
            $str_drawNo = $lotResMat[2];
            $str_drawDate = $lotResMat[3];
            $str_spielId  = $lotResMat[4];   
            
             if ($debug_mode > 1) {
              print "[" .  $str_gameid . "|" . $str_drawNo . "|" . $str_drawDate . "|" . $str_spielId . "]";
            }
            
            
            $sKeno_drawdate  = strtotime($sKeno_drawdate);
            $sKeno_drawdate  = date('Y-m-d', $sKeno_drawdate);
            $onKenoDrawId    = $objOLG->OLGKenoGetDrawId($sKeno_drawdate);
            //printf("\nstr_gameid : %u - str_drawNo: %u - str_drawdate: %u - str_spielId : %u", $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
            if (!$onKenoDrawId) {
              $onKenoDrawId = $objOLG->OLGKenoAdd($sKeno_drawdate, 0, $snum1, $snum2, $snum3, $snum4, 
                                       $snum5, $snum6, $snum7, $snum8, $snum9, $snum10, 
                                       $snum11, $snum12, $snum13, $snum14, $snum15, $snum16,
                                       $snum17, $snum18, $snum19, $snum20, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
              
            }
            if ($debug_mode > 1) {
              print "[SD- ID " . $onKenoDrawId . "]";
            }
            $str_onEncoreId   = $objOLG->OLGEncoreGetDrawId($sKeno_drawdate);
            if (!$str_onEncoreId) {
              $str_onEncoreId = $objOLG->OLGEncoreAdd($sKeno_drawdate, "", $senc_num1, $senc_num2, $senc_num3, $senc_num4, $senc_num5, $senc_num6, $senc_num7);
            }
            
            if ($onKenoDrawId != null) {
            	$onKenoWinningId = $objOLG->OLGOnKenoWinningsGetId($onKenoDrawId);
            	if (!$onKenoWinningId) {
            		on_fetch_second_step_keno($sKeno_drawdate, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId); 
            	}
            
            }
            
            
            if ($debug_mode > 1) {
              print "\n[SD- ID " . $str_onEncoreId . "]";
            }
            //print "\n\nDraw Date: " . $sKeno_drawdate . "\n";
                       
          }
        }


      
      }
    
    
  } 
  
  function on_fetch_second_step_keno($sdrawdate, $str_gameid, $str_drawNo, $str_drawdate, $str_spielid, $sdrawTime = "") {
    
    
    global $debug_mode;
    
    $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
    $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
    $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";



    $objLottery   = new Lottery();
    $objDate      = new GenDates();
    $objOLG       = new OLGLottery();
    $naLottery    = new NALottery();
    $onKeno_row  = $objLottery->dbLotteryGamesGet("onKeno");
    $onEncore_row = $objLottery->dbLotteryGamesGet("onEncore");
    
    $drawdate = strtotime($sdrawdate);

    
    $onKenoGameId   = 9;
    
    $hp_gameID     = $onKenoGameId;
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
        $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("onKeno", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
        if (!$fetch_stats_id) {
          $fetch_date = date('Y-m-d H:i:s');
          $fetch_pos = 0;
          $fetch_process_suc = 0;
          //print_r($na649_row);
          // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
          $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("onKeno", $onKeno_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
          $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
         } else {
          $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("onKeno", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
 
$onKenoGameId   = 9;
 

$http->postvars['gameID']             = $onKenoGameId;
$http->postvars['drawNo']             = $hp_drawNo;
$http->postvars['sdrawDate']          = $hp_sdrawDate;
$http->postvars['spielID']            = $hp_spielID;
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

$bKeno_m = 0;

$srg_onEncore = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
  
$srg_onKeno = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
$srg_onKeno .= "(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
$srg_onKeno .= "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*";
$srg_onKeno .= "(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*" ;


$skenoLinePattern = $srgB_td . "(.*?)" . $srgE_td;
$skenoLinePattern .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;
$skenoLinePattern .= "\s*" . $srgB_td . "(.*?)" . $srg_comment;
$skenoLinePattern .= "\s*" . $srgB_td . "(.*?)" . $srgE_td;
$skenoLinePattern .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "(.*?)" . $srgE_td . "\s*" . $srgE_form . "\s*" . $srgE_tr; 

$srg_keno_Winnings_Hdr = "WINNINGS FOR DAILY KENO";
$srg_encore_Winnings_Hdr = "WINNINGS FOR ENCORE";

$sKeno_th_Line = $srgB_th . $srgB_p .  $srgB_span . "(.*?)" . $srgE_span . $srgE_p . $srgE_th;                 // category
$sKeno_th_Line .= "\s*" . $srgB_th . $srgB_p .  $srgB_span .  "(.*?)" . $srgE_span . $srgE_p .  $srgE_th;        // $1
$sKeno_th_Line .= "\s*" . $srgB_th . $srgB_p .  $srgB_span .  "(.*?)" . $srgE_span . $srgE_p .  $srgE_th;        // $2
$sKeno_th_Line .= "\s*" . $srgB_th . $srgB_p .  $srgB_span .  "(.*?)" . $srgE_span . $srgE_p .  $srgE_th;        // $5
$sKeno_th_Line .= "\s*" . $srgB_th . $srgB_p .  $srgB_span .  "(.*?)" . $srgE_span . $srgE_p .  $srgE_th;        // $10
$sKeno_th_Line .= "\s*" . $srgB_th . $srgB_p .  $srgB_span .  "(.*?)" . $srgE_span . $srgE_p .   $srgE_th;        // Prize Amt

$sEncore_th_Line = $srgB_th . "(.*?)" . $srgE_th;               // Match
$sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Number of Winners
$sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Prize

$sKeno_td_Line = $srgB_td . $srgB_p . $srgB_strong . "(.*?)" . $srgE_strong . $srgE_p . $srgE_td;                 // category
$sKeno_td_Line .= "\s*" .  $srgB_td . $srgB_p . $srgB_strong .  "(.*?)"  . $srgE_strong . $srgE_p .  $srgE_td;        // $1
$sKeno_td_Line .= "\s*" .  $srgB_td  . $srgB_p . $srgB_strong .  "(.*?)"  . $srgE_strong . $srgE_p .  $srgE_td;        // $2
$sKeno_td_Line .= "\s*" .   $srgB_td  . $srgB_p . $srgB_strong .  "(.*?)"  . $srgE_strong . $srgE_p .  $srgE_td;        // $5
$sKeno_td_Line .= "\s*" .   $srgB_td  . $srgB_p . $srgB_strong .  "(.*?)"  . $srgE_strong . $srgE_p .  $srgE_td;        // $10
$sKeno_td_Line .= "\s*" .   $srgB_td  . $srgB_p . $srgB_strong .  "(.*?)"  . $srgE_strong . $srgE_p .  $srgE_td;        // Prize Amt

$sEncore_td_Line = $srgB_td   . $srgB_p . $srgB_strong .  "(.*?)"  . $srgE_strong . $srgE_p .  $srgE_td;               // Match
$sEncore_td_Line .= "\s*" . $srgB_td .  $srgB_p . $srgB_strong .  "(.*?)"  . $srgE_strong . $srgE_p .  $srgE_td;      // Number of Winners
$sEncore_td_Line .= "\s*" . $srgB_td  . $srgB_p . $srgB_strong .  "(.*?)"  . $srgE_strong . $srgE_p .  $srgE_td;      // Prize

$sKeno_m    = 0;
$sEncore_m  = 0;
/*
 *  <th class="white_centre" id="lottery_borderless" align="center">
 * <p><span style="font-family:arial narrow; font-weight: normal;">
 * Category</span></p></th>    <th class="white_centre" id="lottery_borderless" align="center">
 * <p><span style="font-family:arial narrow; font-weight: normal;">$1 Bet</span></p></th>    
 * <th class="white_centre" id="lottery_borderless" align="center"><p>
 * <span style="font-family:arial narrow; font-weight: normal;">$2 Bet</span></p></th>    
 * <th class="white_centre" id="lottery_borderless" align="center"><p>
 * <span style="font-family:arial narrow; font-weight: normal;">$5 Bet</span></p></th>    
 * <th class="white_centre" id="lottery_borderless" align="center"><p>
 * <span style="font-family:arial narrow; font-weight: normal;">$10 Bet</span></p></th>    
 * <th class="white_centre" id="lottery_borderless" align="center"><p>
 * <span style="font-family:arial narrow; font-weight: normal;">Prize per $1 Wagered</span>
 * </p></th>   </tr>              
   
 <td id="lottery_border" align="center"><p class="blue"><strong>10/10</strong></p></td>    
 * <td id="lottery_border" align="center"><p class="blue"><strong>0</strong></p></td>    
 * <td id="lottery_border" align="center"><p class="blue"><strong>0</strong></p></td>    
 * <td id="lottery_border" align="center"><p class="blue"><strong>0</strong></p></td>    
 * <td id="lottery_border" align="center"><p class="blue"><strong>0</strong></p></td>    
 * <td id="lottery_border" align="right"><p class="blue"><strong>$250,000.00</strong></p></td>   </tr>                       
    [9] =>        
 * 
 * <th class="white_centre" id="lottery_borderless" align="left">     Match    </th>    
 * <th class="white_centre" id="lottery_borderless" align="center">     Number of Winners    </th>    
 * <th class="white_centre" id="lottery_borderless" align="right">     Prize    </th>   
 * </tr>   <!-- DISPLAY PRIZE SHARE INFO FOR ENCORE -->                                          
    [34] =>     <td id="lottery_border" width="128px"><p class="blue">
 * <strong>7392978</strong></p></td>    
 * <td id="lottery_border" width="114px" align="center">
 * <p class="blue"><strong>0</strong></p></td>    
 * <td id="lottery_border" align="right"><p class="blue">
 * <strong>$1,000,000.00</strong></p></td>   </tr>                                         
    [35] =>    
 * 
 */  


$srgDays    = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
$srgMonths  = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";


$str_money_sym = array("$",","); 

if ($debug_mode > 0) {
  print "\nFetch " . $site_file . $site_post_str;
  print "\nDate: " . date('Y-m-d', $drawdate);
}


//print "<br />" . $skenoLinePattern . "<br />";
//print "<br />" . $spattern . "<br />";
foreach ($html_tr_list as $html_tr) {
    if (preg_match("/" . $srg_keno_Winnings_Hdr . "/i", $html_tr, $lmatches )) {
      //print_r($lmatches);
      $sKeno_m    = 1;
      $sEncore_m  = 0;
    } elseif (preg_match("/" . $srg_encore_Winnings_Hdr . "/i", $html_tr, $lmatches)) {
      //print_r($lmatches);
      $sEncore_m    = 1;
      $sKeno_m      = 0;
    } elseif ($sKeno_m == 1 && 
              preg_match("/" . $sKeno_th_Line . "/i", $html_tr, $lmatches)) {
      //print_r($lmatches);
    } elseif ($sEncore_m == 1 &&
              preg_match("/" . $sEncore_th_Line . "/i", $html_tr, $lmatches)) {
      //print_r($lmatches);
      $arEncore_th = array();    
      $inEncore_th = 0;  
      
    } elseif ($sKeno_m == 1 &&
              preg_match("/" . $sKeno_td_Line . "/i", $html_tr, $lmatches)) {
        if ($debug_mode > 2) {
          print_r($lmatches);
        }
      if (preg_match("/10\/10/i", $lmatches[1], $m_lot_)) {
        $m_10_10_1_count = $lmatches[2];
        $m_10_10_2_count = $lmatches[3];
        $m_10_10_5_count = $lmatches[4];
        $m_10_10_10_count = $lmatches[5];
        $m_10_10_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_10_10_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_10_10_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_10_10_1_prize_id) {
          $m_10_10_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_10_10_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }  
        
        if ($debug_mode > 1) {
          print "[10/10|" .  $m_10_10_1_prize_amt . "|" . $m_10_10_1_count . "|" . $m_10_10_2_count . "|" . $m_10_10_5_count . "|" . $m_10_10_10_count . "|" . $m_10_10_1_prize_id . "]";
        }
        
        
         
      } elseif (preg_match("/9\/10/i", $lmatches[1], $m_lot_)) {
        $m_9_10_1_count = $lmatches[2];
        $m_9_10_2_count = $lmatches[3];
        $m_9_10_5_count = $lmatches[4];
        $m_9_10_10_count = $lmatches[5];
        $m_9_10_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_9_10_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_9_10_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_9_10_1_prize_id) {
          $m_9_10_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_9_10_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[9/10|" .  $m_9_10_1_prize_amt . "|" . $m_9_10_1_count . "|" . $m_9_10_2_count . "|" . $m_9_10_5_count . "|" . $m_9_10_10_count . "|" . $m_9_10_1_prize_id . "]";
        }
        
        
      } elseif (preg_match("/8\/10/i", $lmatches[1], $m_lot_)) {
        $m_8_10_1_count = $lmatches[2];
        $m_8_10_2_count = $lmatches[3];
        $m_8_10_5_count = $lmatches[4];
        $m_8_10_10_count = $lmatches[5];
        $m_8_10_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_8_10_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_8_10_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_8_10_1_prize_id) {
          $m_8_10_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_8_10_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[8/10|" .  $m_8_10_1_prize_amt . "|" . $m_8_10_1_count . "|" . $m_8_10_2_count . "|" . $m_8_10_5_count . "|" . $m_8_10_10_count . "|" . $m_8_10_1_prize_id . "]";
        }
      } elseif (preg_match("/7\/10/i", $lmatches[1], $m_lot_)) {
        $m_7_10_1_count = $lmatches[2];
        $m_7_10_2_count = $lmatches[3];
        $m_7_10_5_count = $lmatches[4];
        $m_7_10_10_count = $lmatches[5];
        $m_7_10_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_7_10_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_7_10_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_7_10_1_prize_id) {
          $m_7_10_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_7_10_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[7/10|" .  $m_7_10_1_prize_amt . "|" . $m_7_10_1_count . "|" . $m_7_10_2_count . "|" . $m_7_10_5_count . "|" . $m_7_10_10_count . "|" . $m_7_10_1_prize_id . "]";
        }
      } elseif (preg_match("/0\/10/i", $lmatches[1], $m_lot_)) {
        $m_0_10_1_count = $lmatches[2];
        $m_0_10_2_count = $lmatches[3];
        $m_0_10_5_count = $lmatches[4];
        $m_0_10_10_count = $lmatches[5];
        $m_0_10_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_0_10_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_0_10_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_0_10_1_prize_id) {
          $m_0_10_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_0_10_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[0/10|" .  $m_0_10_1_prize_amt . "|" . $m_0_10_1_count . "|" . $m_0_10_2_count . "|" . $m_0_10_5_count . "|" . $m_0_10_10_count . "|" . $m_0_10_1_prize_id . "]";
        }
      } elseif (preg_match("/9\/9/i", $lmatches[1], $m_lot_)) {
        $m_9_9_1_count = $lmatches[2];
        $m_9_9_2_count = $lmatches[3];
        $m_9_9_5_count = $lmatches[4];
        $m_9_9_10_count = $lmatches[5];
        $m_9_9_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_9_9_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_9_9_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_9_9_1_prize_id) {
          $m_9_9_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_9_9_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[9/9|" .  $m_9_9_1_prize_amt . "|" . $m_9_9_1_count . "|" . $m_9_9_2_count . "|" . $m_9_9_5_count . "|" . $m_9_9_10_count . "|" . $m_9_9_1_prize_id . "]";
        }
      } elseif (preg_match("/8\/9/i", $lmatches[1], $m_lot_)) {
        $m_8_9_1_count = $lmatches[2];
        $m_8_9_2_count = $lmatches[3];
        $m_8_9_5_count = $lmatches[4];
        $m_8_9_10_count = $lmatches[5];
        $m_8_9_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_8_9_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_8_9_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_8_9_1_prize_id) {
          $m_8_9_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_8_9_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[8/9|" .  $m_8_9_1_prize_amt . "|" . $m_8_9_1_count . "|" . $m_8_9_2_count . "|" . $m_8_9_5_count . "|" . $m_8_9_10_count . "|" . $m_8_9_1_prize_id . "]";
        }
      } elseif (preg_match("/7\/9/i", $lmatches[1], $m_lot_)) {
        $m_7_9_1_count = $lmatches[2];
        $m_7_9_2_count = $lmatches[3];
        $m_7_9_5_count = $lmatches[4];
        $m_7_9_10_count = $lmatches[5];
        $m_7_9_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_7_9_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_7_9_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_7_9_1_prize_id) {
          $m_7_9_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_7_9_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[7/9|" .  $m_7_9_1_prize_amt . "|" . $m_7_9_1_count . "|" . $m_7_9_2_count . "|" . $m_7_9_5_count . "|" . $m_7_9_10_count . "|" . $m_7_9_1_prize_id . "]";
        }
      } elseif (preg_match("/6\/9/i", $lmatches[1], $m_lot_)) {
        $m_6_9_1_count = $lmatches[2];
        $m_6_9_2_count = $lmatches[3];
        $m_6_9_5_count = $lmatches[4];
        $m_6_9_10_count = $lmatches[5];
        $m_6_9_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_6_9_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_6_9_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_6_9_1_prize_id) {
          $m_6_9_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_6_9_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[6/9|" .  $m_6_9_1_prize_amt . "|" . $m_6_9_1_count . "|" . $m_6_9_2_count . "|" . $m_6_9_5_count . "|" . $m_6_9_10_count . "|" . $m_6_9_1_prize_id . "]";
        }
      } elseif (preg_match("/8\/8/i", $lmatches[1], $m_lot_)) {
        $m_8_8_1_count = $lmatches[2];
        $m_8_8_2_count = $lmatches[3];
        $m_8_8_5_count = $lmatches[4];
        $m_8_8_10_count = $lmatches[5];
        $m_8_8_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_8_8_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_8_8_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_8_8_1_prize_id) {
          $m_8_8_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_8_8_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[8/8|" .  $m_8_8_1_prize_amt . "|" . $m_8_8_1_count . "|" . $m_8_8_2_count . "|" . $m_8_8_5_count . "|" . $m_8_8_10_count . "|" . $m_8_8_1_prize_id . "]";
        }
      } elseif (preg_match("/7\/8/i", $lmatches[1], $m_lot_)) {
        $m_7_8_1_count = $lmatches[1];
        $m_7_8_2_count = $lmatches[2];
        $m_7_8_5_count = $lmatches[3];
        $m_7_8_10_count = $lmatches[4];
        $m_7_8_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[5]);
        $m_7_8_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_7_8_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_7_8_1_prize_id) {
          $m_7_8_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_7_8_1_prize_amt, $objLottery->prz_money, trim($lmatches[5]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[7/8|" .  $m_7_8_1_prize_amt . "|" . $m_7_8_1_count . "|" . $m_7_8_2_count . "|" . $m_7_8_5_count . "|" . $m_7_8_10_count . "|" . $m_7_8_1_prize_id . "]";
        }
      } elseif (preg_match("/6\/8/i", $lmatches[1], $m_lot_)) {
        $m_6_8_1_count = $lmatches[2];
        $m_6_8_2_count = $lmatches[3];
        $m_6_8_5_count = $lmatches[4];
        $m_6_8_10_count = $lmatches[5];
        $m_6_8_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_6_8_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_6_8_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_6_8_1_prize_id) {
          $m_6_8_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_6_8_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[6/8|" .  $m_6_8_1_prize_amt . "|" . $m_6_8_1_count . "|" . $m_6_8_2_count . "|" . $m_6_8_5_count . "|" . $m_6_8_10_count . "|" . $m_6_8_1_prize_id . "]";
        }
      } elseif (preg_match("/7\/7/i", $lmatches[1], $m_lot_)) {
        $m_7_7_1_count = $lmatches[2];
        $m_7_7_2_count = $lmatches[3];
        $m_7_7_5_count = $lmatches[4];
        $m_7_7_10_count = $lmatches[5];
        $m_7_7_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_7_7_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_7_7_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_7_7_1_prize_id) {
          $m_7_7_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_7_7_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[7/7|" .  $m_7_7_1_prize_amt . "|" . $m_7_7_1_count . "|" . $m_7_7_2_count . "|" . $m_7_7_5_count . "|" . $m_7_7_10_count . "|" . $m_7_7_1_prize_id . "]";
        }
      } elseif (preg_match("/6\/7/i", $lmatches[1], $m_lot_)) {
        $m_6_7_1_count = $lmatches[2];
        $m_6_7_2_count = $lmatches[3];
        $m_6_7_5_count = $lmatches[4];
        $m_6_7_10_count = $lmatches[5];
        $m_6_7_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_6_7_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_6_7_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_6_7_1_prize_id) {
          $m_6_7_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_6_7_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[6/7|" .  $m_6_7_1_prize_amt . "|" . $m_6_7_1_count . "|" . $m_6_7_2_count . "|" . $m_6_7_5_count . "|" . $m_6_7_10_count . "|" . $m_6_7_1_prize_id . "]";
        }
      } elseif (preg_match("/5\/7/i", $lmatches[1], $m_lot_)) {
        $m_5_7_1_count = $lmatches[2];
        $m_5_7_2_count = $lmatches[3];
        $m_5_7_5_count = $lmatches[4];
        $m_5_7_10_count = $lmatches[5];
        $m_5_7_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_5_7_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_5_7_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_5_7_1_prize_id) {
          $m_5_7_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_5_7_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[5/7|" .  $m_5_7_1_prize_amt . "|" . $m_5_7_1_count . "|" . $m_5_7_2_count . "|" . $m_5_7_5_count . "|" . $m_5_7_10_count . "|" . $m_5_7_1_prize_id . "]";
        }
      } elseif (preg_match("/6\/6/i", $lmatches[1], $m_lot_)) {
        $m_6_6_1_count = $lmatches[2];
        $m_6_6_2_count = $lmatches[3];
        $m_6_6_5_count = $lmatches[4];
        $m_6_6_10_count = $lmatches[5];
        $m_6_6_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_6_6_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_6_6_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_6_6_1_prize_id) {
          $m_6_6_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_6_6_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[6/6|" .  $m_6_6_1_prize_amt . "|" . $m_6_6_1_count . "|" . $m_6_6_2_count . "|" . $m_6_6_5_count . "|" . $m_6_6_10_count . "|" . $m_6_6_1_prize_id . "]";
        }
      } elseif (preg_match("/5\/6/i", $lmatches[1], $m_lot_)) {
        $m_5_6_1_count = $lmatches[2];
        $m_5_6_2_count = $lmatches[3];
        $m_5_6_5_count = $lmatches[4];
        $m_5_6_10_count = $lmatches[5];
        $m_5_6_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_5_6_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_5_6_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_5_6_1_prize_id) {
          $m_5_6_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_5_6_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[5/6|" .  $m_5_6_1_prize_amt . "|" . $m_5_6_1_count . "|" . $m_5_6_2_count . "|" . $m_5_6_5_count . "|" . $m_5_6_10_count . "|" . $m_5_6_1_prize_id . "]";
        }
      } elseif (preg_match("/5\/5/i", $lmatches[1], $m_lot_)) {
        $m_5_5_1_count = $lmatches[2];
        $m_5_5_2_count = $lmatches[3];
        $m_5_5_5_count = $lmatches[4];
        $m_5_5_10_count = $lmatches[5];
        $m_5_5_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_5_5_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_5_5_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_5_5_1_prize_id) {
          $m_5_5_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_5_5_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[5/5|" .  $m_5_5_1_prize_amt . "|" . $m_5_5_1_count . "|" . $m_5_5_2_count . "|" . $m_5_5_5_count . "|" . $m_5_5_10_count . "|" . $m_5_5_1_prize_id . "]";
        }
      } elseif (preg_match("/4\/5/i", $lmatches[1], $m_lot_)) {
        $m_4_5_1_count = $lmatches[2];
        $m_4_5_2_count = $lmatches[3];
        $m_4_5_5_count = $lmatches[4];
        $m_4_5_10_count = $lmatches[5];
        $m_4_5_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_4_5_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_4_5_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_4_5_1_prize_id) {
          $m_4_5_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_4_5_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[4/5|" .  $m_4_5_1_prize_amt . "|" . $m_4_5_1_count . "|" . $m_4_5_2_count . "|" . $m_4_5_5_count . "|" . $m_4_5_10_count . "|" . $m_4_5_1_prize_id . "]";
        }
      } elseif (preg_match("/4\/4/i", $lmatches[1], $m_lot_)) {
        $m_4_4_1_count = $lmatches[2];
        $m_4_4_2_count = $lmatches[3];
        $m_4_4_5_count = $lmatches[4];
        $m_4_4_10_count = $lmatches[5];
        $m_4_4_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_4_4_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_4_4_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_4_4_1_prize_id) {
          $m_4_4_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_4_4_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[4/4|" .  $m_4_4_1_prize_amt . "|" . $m_4_4_1_count . "|" . $m_4_4_2_count . "|" . $m_4_4_5_count . "|" . $m_4_4_10_count . "|" . $m_4_4_1_prize_id . "]";
        }
      } elseif (preg_match("/3\/3/i", $lmatches[1], $m_lot_)) {
        $m_3_3_1_count = $lmatches[2];
        $m_3_3_2_count = $lmatches[3];
        $m_3_3_5_count = $lmatches[4];
        $m_3_3_10_count = $lmatches[5];
        $m_3_3_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_3_3_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_3_3_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_3_3_1_prize_id) {
          $m_3_3_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_3_3_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[3/3|" .  $m_3_3_1_prize_amt . "|" . $m_3_3_1_count . "|" . $m_3_3_2_count . "|" . $m_3_3_5_count . "|" . $m_3_3_10_count . "|" . $m_3_3_1_prize_id . "]";
        }
      } elseif (preg_match("/2\/2/i", $lmatches[1], $m_lot_)) {
        $m_2_2_1_count = $lmatches[2];
        $m_2_2_2_count = $lmatches[3];
        $m_2_2_5_count = $lmatches[4];
        $m_2_2_10_count = $lmatches[5];
        $m_2_2_1_prize_amt    = str_replace($str_money_sym, "", $lmatches[6]);
        $m_2_2_1_prize_id     = $objLottery->dbLotteryWinPrizesGetId($m_2_2_1_prize_amt, $objLottery->prz_money, $onKeno_row["gameid"]);
        if (!$m_2_2_1_prize_id) {
          $m_2_2_1_prize_id = $objLottery->dbLotteryWinPrizesAdd($m_2_2_1_prize_amt, $objLottery->prz_money, trim($lmatches[6]), $onKeno_row["gameid"]);
        }
        if ($debug_mode > 1) {
          print "[2/2|" .  $m_2_2_1_prize_amt . "|" . $m_2_2_1_count . "|" . $m_2_2_2_count . "|" . $m_2_2_5_count . "|" . $m_2_2_10_count . "|" . $m_2_2_1_prize_id . "]";
        }
        
        $sKeno_drawDate = strtotime($sdrawdate);
        $sKeno_drawDate = date('Y-m-d', $sKeno_drawDate);
        if ($sdrawTime != "") {
        	$onKenoId = $objOLG->OLGKenoGetDrawId($sKeno_drawDate, $sdrawTime);        	
        } else {
        	$onKenoId = $objOLG->OLGKenoGetDrawId($sKeno_drawDate);        	
        }

        if ($onKenoId != null) {
          $onKenoWinningId = $objOLG->OLGOnKenoWinningsGetId($onKenoId);
          if (!$onKenoWinningId) {
                $onKenoWinningId = $objOLG->OLGOnKenoWinningsAdd(
                    $onKenoId,
                    $m_10_10_1_count,$m_10_10_1_prize_id,$m_9_10_1_count,$m_9_10_1_prize_id,$m_8_10_1_count,$m_8_10_1_prize_id,$m_7_10_1_count,$m_7_10_1_prize_id,$m_0_10_1_count,$m_0_10_1_prize_id,
                    $m_9_9_1_count,$m_9_9_1_prize_id,$m_8_9_1_count,$m_8_9_1_prize_id,$m_7_9_1_count,$m_7_9_1_prize_id,$m_6_9_1_count,$m_6_9_1_prize_id,
                    $m_8_8_1_count,$m_8_8_1_prize_id,$m_7_8_1_count,$m_7_8_1_prize_id,$m_6_8_1_count,$m_6_8_1_prize_id,
                    $m_7_7_1_count,$m_7_7_1_prize_id,$m_6_7_1_count,$m_6_7_1_prize_id,$m_5_7_1_count,$m_5_7_1_prize_id,
                    $m_6_6_1_count,$m_6_6_1_prize_id,$m_5_6_1_count,$m_5_6_1_prize_id,
                    $m_5_5_1_count,$m_5_5_1_prize_id,$m_4_5_1_count,$m_4_5_1_prize_id,
                    $m_4_4_1_count,$m_4_4_1_prize_id,
                    $m_3_3_1_count,$m_3_3_1_prize_id,
                    $m_2_2_1_count,$m_2_2_1_prize_id,
                    $m_10_10_2_count,$m_9_10_2_count,$m_8_10_2_count,$m_7_10_2_count,$m_0_10_2_count,
                    $m_9_9_2_count,$m_8_9_2_count,$m_7_9_2_count,$m_6_9_2_count,
                    $m_8_8_2_count,$m_7_8_2_count,$m_6_8_2_count,
                    $m_7_7_2_count,$m_6_7_2_count,$m_5_7_2_count,
                    $m_6_6_2_count,$m_5_6_2_count,
                    $m_5_5_2_count,$m_4_5_2_count,
                    $m_4_4_2_count,
                    $m_3_3_2_count,
                    $m_2_2_2_count,
                    $m_10_10_5_count,$m_9_10_5_count,$m_8_10_5_count,$m_7_10_5_count,$m_0_10_5_count,
                    $m_9_9_5_count,$m_8_9_5_count,$m_7_9_5_count,$m_6_9_5_count,
                    $m_8_8_5_count,$m_7_8_5_count,$m_6_8_5_count,
                    $m_7_7_5_count,$m_6_7_5_count,$m_5_7_5_count,
                    $m_6_6_5_count,$m_5_6_5_count,
                    $m_5_5_5_count,$m_4_5_5_count,
                    $m_4_4_5_count,
                    $m_3_3_5_count,
                    $m_2_2_5_count,
                    $m_10_10_10_count,$m_9_10_10_count,$m_8_10_10_count,$m_7_10_10_count,$m_0_10_10_count,
                    $m_9_9_10_count,$m_8_9_10_count,$m_7_9_10_count,$m_6_9_10_count,
                    $m_8_8_10_count,$m_7_8_10_count,$m_6_8_10_count,
                    $m_7_7_10_count,$m_6_7_10_count,$m_5_7_10_count,
                    $m_6_6_10_count,$m_5_6_10_count,
                    $m_5_5_10_count,$m_4_5_10_count,
                    $m_4_4_10_count,
                    $m_3_3_10_count,
                    $m_2_2_10_count);
             }

          
        }

        if ($debug_mode > 1) {
          print "[" . $onKenoId . "]";
        }

      } 
      
    } elseif ($sEncore_m == 1 &&
              preg_match("/" . $sEncore_td_Line . "/i", $html_tr, $lmatches)) {
      //print_r($lmatches);
      
        // 8734252
           $arEncore_th[$inEncore_th] = $lmatches;
           $inEncore_th++;       
                // print_r($lmatches); 
        
    }    
}
    
    if (is_array($arEncore_th)) {
        $OLGData = new OLGData();
        if ($sdrawTime != "") {
	        $OLGData->OLGEncoreParse($arEncore_th, strtotime($sdrawdate), $debug_mode, $sdrawTime);
        } else {
        	$OLGData->OLGEncoreParse($arEncore_th, strtotime($sdrawdate), $debug_mode);
        }
      }
    
  }
  
  ?>