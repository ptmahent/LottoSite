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
  		$lottery_draw_data_dates = $naLottery->na649GetFirstLastDataAvail();
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
             alc_fetch_single_draw(date('d-m-Y',$drawDate));
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
		  // print_r($lmatches); 
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
			alc_fetch_single_draw(date('d-m-Y',$drawDate));
			
		  }
		}    
		
	  } while (trim($selection) != 'q');
  }
  
  
  function alc_fetch_single_draw($drawdate = "") {
    
       global $debug_mode;
        //$url1 = "http://corp.alc.ca/Lotto649.aspx?tab=2";
        $drawdate = strtotime($drawdate);
        if ($drawdate == "") {
            $url1 = "http://corp.alc.ca/Lotto649.aspx?tab=2";
        } else {
            $selDate = date('Ymd', $drawdate);
            $url1 = "http://corp.alc.ca/Lotto649.aspx?tab=2&date=" . $selDate;
        }
        //$url1 = "http://corp.alc.ca/Lotto649.aspx?tab=2&date=20090211";
        
        $objLottery = new Lottery();
        $objDate    = new GenDates();
        $na649_row = $objLottery->dbLotteryGamesGet("na649");
        //print_r($na649_row);
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
          //print_r($lmatches);
          //print "\nSiteDomain: " . $site_domain_id;
          //print "\nSitePath  : " . $site_path_id;
          //print "\nSiteFile  : " . $site_file_id;
          //print "\nSiteQuery : " . $site_querystr_id;
          
                 
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("na649", $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("na649", $na649_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("na649", $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id);
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
        
        /*
        
        
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr><td colspan="5"><h2 class="noIndentTableH2"><img src="../images/en/649BonusLogoENG.png" /></h2></td></tr>
        <tr><td class="chartTitle" valign="top">Match</td><td class="chartDivider" width="1" /><td class="chartTitle" valign="top">Winning Number</td><td class="chartDivider" width="1" /><td class="chartTitleRight" valign="top">Number of Prizes</td><td class="chartDivider" width="1" /><td class="chartTitleRight" valign="top">Prize Amount</td></tr>
        <tr><td class="chartContentWhite" valign="top">
                                            6 of 6
                                          </td><td class="chartDivider" width="1" /><td class="chartContentWhite" valign="top">05-08-15-16-41-46</td><td class="chartDivider" width="1" /><td class="chartContentWhiteRight" valign="top">
        0
      </td><td class="chartDivider" width="1" /><td class="chartContentWhiteRight" valign="top">$649,000.00</td></tr>
      
      
      <tr><td class="chartContentGrey" valign="top">

                                            6 of 6
                                          </td><td class="chartDivider" width="1" /><td class="chartContentGrey" valign="top">19-29-32-40-43-46</td><td class="chartDivider" width="1" /><td class="chartContentGreyRight" valign="top">
        0
      </td><td class="chartDivider" width="1" /><td class="chartContentGreyRight" valign="top">$649,000.00</td></tr></table>
      
      */
        
        
        $html_tr_list = preg_split("/<tr>/i", $html_body);
        
        $srg649_num = "images\/en\/bkgWNL_649.gif.*For the draw of ([^ ]*)\s*(\d*),\s*(\d*):.*class=.lotteryWN.>(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2}).*Bonus:\s*(\d{2})";
        $srg49_num  = "images\/en\/bkgWNL_A49.gif.*For the draw of ([^ ]*)\s*(\d*),\s*(\d*):.*class=.lotteryWN.>(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2}).*Bonus:\s*(\d{2})";
        $sPrze_649_hdr  = "Prize Payout of Lotto 6\/49";
        $sPrze_49_hdr   = "Prize Payout of Atlantic 49";
        $sPrze_Tag_hdr  = "Prize Payout of TAG";
      //  $sOct2011_BonusDraw_Hdr
    //    $sOct2011_BonusDraw_Hdr = "<img src=\"../images/en/649BonusLogoENG.png\" \/>";
     //   $sOct2011_BonusDraw_Hdr = "<img src=\"..\/images\/en\/649BonusLogoENG\.png\" \/>";
        $sOct2011_BonusDraw_Hdr = "649BonusLogoENG.png";
        $sMar2012_BonusDraw_Hdr = "649BonusLogoENG.png";
        
        
        //$sOct2011_BonusDraw_Hdr = "..\/images\/en\/649BonusLogoENG.png";
        $b649_Prze_m         = 0;
        $b49_Prze_m          = 0;
        $bTag_Prze_m         = 0;
        $b649_Oct11_Prze_m	 = 0;
        $b649_Mar12_Prze_m 	 = 0;
        /*
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td colspan="5"><h2 class="noIndentTableH2"><img src="../images/en/649BonusLogoENG.png" /></h2></td></tr>
        <tr><td class="chartTitle" valign="top">Match</td>
        <td class="chartDivider" width="1" />
        <td class="chartTitle" valign="top">Winning Number</td>
        <td class="chartDivider" width="1" />
        <td class="chartTitleRight" valign="top">Number of Prizes</td>
        <td class="chartDivider" width="1" />
        <td class="chartTitleRight" valign="top">Prize Amount</td>
        </tr>
        <tr>
        <td class="chartContentWhite" valign="top">
                                            6 of 6
                                          </td>
                                          <td class="chartDivider" width="1" />
                                          <td class="chartContentWhite" valign="top">
                                          10-15-16-18-23-26</td>
                                          <td class="crhatDivider" width="1" />
                                          <td class="chartContentWhiteRight" valign="top">
                                          1 - British Columbia
          <br /></td><td class="chartDivider" width="1" />
          <td class="chartContentWhiteRight" valign="top">$1,500,000.00</td></tr></table>
          
          
          
          //
          
          <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td colspan="5"><h2 class="noIndentTableH2"><img src="../images/en/649BonusLogoENG.png" /></h2></td></tr><tr><td class="chartTitle" valign="top">Match</td><td class="chartDivider" width="1" /><td class="chartTitle" valign="top">Winning Number</td><td class="chartDivider" width="1" /><td class="chartTitleRight" valign="top">Number of Prizes</td><td class="chartDivider" width="1" /><td class="chartTitleRight" valign="top">Prize Amount</td></tr><tr><td class="chartContentWhite" valign="top">
                                            6 of 6
                                          </td><td class="chartDivider" width="1" /><td class="chartContentWhite" valign="top">04-13-15-20-26-41</td><td class="chartDivider" width="1" /><td class="chartContentWhiteRight" valign="top">1 - Ontario
          <br /></td><td class="chartDivider" width="1" /><td class="chartContentWhiteRight" valign="top">$1,500,000.00</td></tr></table>
          
          
        
        */
        
        $sMar2012_BonusDraw = "(6 of 6)\s*" . $srgE_td . $srgB_td . $srgB_td . "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})" . $srgE_td .  $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
        
        $sOct2011_BonusDraw = "(6 of 6)\s*" . $srgE_td . $srgB_td . $srgB_td . "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
        $swinloc = "(\d*)\s*-\s*(.*)";
        $s6of6  = "(6 of 6)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
        $s5of6B = "(5 of 6 . Bonus)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
        $s5of6  = "(5 of 6)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
        $s4of6  = "(4 of 6)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
        $s3of6  = "(3 of 6)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
        $s2of6B  = "(2 of 6 . Bonus)" . $srgE_td . $srgB_td . $srgB_td . "\s*(\d.*)\s*" . $srgE_td . $srgB_td . $srgB_td . "([^<]*)" . $srgE_td;
        $str_money_sym = array("$",",");  
        $str_clean_sym = array("  ",",","-");
              
        $naLottery = new NALottery();
        // print Fetch Detail
        if ($debug_mode > 0) { 
          print "\nFetch " . $site_file . $site_querystr;
          print "\nDate: " . date('Y-m-d', $drawdate);
        }    
        
        
        $i_mar_sequence = 1;          // set the initial to 1
        
        $s_c_drawdate = date('Y-m-d', $drawdate);
        
        $debug_mode = 1;
        
        //$alcLottery = new ALCLottery();
        foreach ($html_tr_list as $html_tr) {
        
        
        
          if ($b649_Mar12_Prze_m == 1 && 
          	(preg_match("/" . $sMar2012_BonusDraw . "/i", $html_tr, $lmatches))) {
          	print "\n March Bonus Draw:: ";
          	print_r($lmatches);
          	

            $snum1 = $lmatches[2];
            $snum2 = $lmatches[3];
            $snum3 = $lmatches[4];
            $snum4 = $lmatches[5];
            $snum5 = $lmatches[6];
            $snum6 = $lmatches[7];
            $snumbonus = 0;
            $idrawnum = 0;
            $isequencenum = $i_mar_sequence;
            
          	$na649BonusDrawId = $naLottery->na649GetDrawId($s_c_drawdate, $isequencenum);
          	if (!$na649BonusDrawId) {
          		$na649BonusDrawId = $naLottery->na649Add($s_c_drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, "", "", "", "", $isequencenum);
          	}
          	
          	if (trim($lmatches[8]) != 0) {
          		$html_locs = preg_split("/\s*<br \/>/i", $lmatches[8]);
          		$s649_Oct11_total_win_amount = 0;
          		$s649_Oct11_total_win_count = 0;
          		$s649_Oct11_win_loc_detail = array();
          		
          		foreach ($html_locs as $html_loc) {
          			if (preg_match("/" . $swinloc . "/i", $html_loc, $loc_matches)) {
          				$str_location =  trim(str_replace($str_clean_sym, " ", $loc_matches[2]));
          				$s649_Oct11_loc_id = $objLottery->dbLotWinLocationGetId($str_location, $objLottery->loc_prov);
          				if (!$s649_Oct11_loc_id) {
          					$s649_Oct11_loc_id = $objLottery->dbLotWinLocationAdd("", $str_location, "", "", $objLottery->loc_prov);
          				}
          				$s649_Oct11_win_loc_detail[$s649_Oct11_loc_id]["count"] = trim($loc_matches[1]);
          				$s649_Oct11_total_win_count += trim($loc_matches[1]);
          			}
          		}
          		$s649_Oct11_Bonus_win_amt = str_replace($str_money_sym,"",trim($lmatches[9]));
          		
          	
                $s6of6BonusDraw_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s649_Oct11_Bonus_win_amt, $objLottery->prz_money,  $na649_row["gameid"]);
                if (!$s6of6BonusDraw_win_prz_id) {
                  $s6of6BonusDraw_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s649_Oct11_Bonus_win_amt, $objLottery->prz_money,trim($lmatches[9]), $na649_row["gameid"]);
                }
                
          	} else {
          		$s649_Oct11_total_win_count = 0;
          		$s649_Oct11_Bonus_win_amt = str_replace($str_money_sym,"",trim($lmatches[9]));
          	    $s6of6BonusDraw_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s649_Oct11_Bonus_win_amt, $objLottery->prz_money,  $na649_row["gameid"]);
                if (!$s6of6BonusDraw_win_prz_id) {
                  $s6of6BonusDraw_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s649_Oct11_Bonus_win_amt, $objLottery->prz_money,trim($lmatches[9]), $na649_row["gameid"]);
                }
                
          	}
          	  if ($debug_mode > 1) {
                  print "[m6of6BonusDraw|" . $s649_Oct11_Bonus_win_amt . "|" . $s6of6BonusDraw_win_prz_id . "|" . $s649_Oct11_total_win_count . "|" . $s649_Oct11_Bonus_win_amt . "|" . $s6of6BonusDraw_win_prz_id . "]";
              }
          	
          	
          	// add the Bonus Draw winning to DB
          	
            
            $na649BonusDrawWinningId = $naLottery->na649WinningsGetId($na649BonusDrawId);
            if (!$na649BonusDrawWinningId) {
                $na649BonusDrawWinningId = $naLottery->na649WinningsAdd($na649BonusDrawId, $s649_Oct11_total_win_count, $s6of6BonusDraw_win_prz_id, 0,
                 0, 0, 0,0,0, 0, 0, 0, 0, 0);
                
                
                 if ($na649BonusDrawWinningId != "") {
               
                  //print_r($s6of6_win_loc_detail);
                  //print_r($s5of6B_win_loc_detail);  
                  if (is_array($s649_Oct11_win_loc_detail)) {
                    foreach ($s649_Oct11_win_loc_detail as $win_loc_id => $win_loc) {
                      if (!$naLottery->dbNa649WinLocGetId($na649BonusDrawWinningId, $win_loc_id, 6)) {   
                        $naLottery->dbNa649WinLocAdd($na649BonusDrawWinningId, $s6of6BonusDraw_win_prz_id, $win_loc["count"], $win_loc_id, 6);
                      	}
                    }
                  }
                
                }
          	}
          	
          	$i_mar_sequence++;
          } elseif ($b649_Oct11_Prze_m  == 1  &&
          	(preg_match("/" . $sOct2011_BonusDraw . "/i", $html_tr, $lmatches))) {
          	print "\n BONUS DRAW:::::: ";
          	print_r($lmatches);
          	
          	/*
          	
          	1
          	2-7
          	8 - location
          	9 - prize
          	
          	
          	
          	*/
          	
          	
          	
            $snum1 = $lmatches[2];
            $snum2 = $lmatches[3];
            $snum3 = $lmatches[4];
            $snum4 = $lmatches[5];
            $snum5 = $lmatches[6];
            $snum6 = $lmatches[7];
            $snumbonus = 0;
            $idrawnum = 0;
            $isequencenum = 1;
            
          	$na649BonusDrawId = $naLottery->na649GetDrawId($s_c_drawdate, $isequencenum);
          	if (!$na649BonusDrawId) {
          		$na649BonusDrawId = $naLottery->na649Add($s_c_drawdate, $idrawnum, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus, "", "", "", "", $isequencenum);
          	}
          	
          	if (trim($lmatches[8]) != 0) {
          		$html_locs = preg_split("/\s*<br \/>/i", $lmatches[8]);
          		$s649_Oct11_total_win_amount = 0;
          		$s649_Oct11_total_win_count = 0;
          		$s649_Oct11_win_loc_detail = array();
          		
          		foreach ($html_locs as $html_loc) {
          			if (preg_match("/" . $swinloc . "/i", $html_loc, $loc_matches)) {
          				$str_location =  trim(str_replace($str_clean_sym, " ", $loc_matches[2]));
          				$s649_Oct11_loc_id = $objLottery->dbLotWinLocationGetId($str_location, $objLottery->loc_prov);
          				if (!$s649_Oct11_loc_id) {
          					$s649_Oct11_loc_id = $objLottery->dbLotWinLocationAdd("", $str_location, "", "", $objLottery->loc_prov);
          				}
          				$s649_Oct11_win_loc_detail[$s649_Oct11_loc_id]["count"] = trim($loc_matches[1]);
          				$s649_Oct11_total_win_count += trim($loc_matches[1]);
          			}
          		}
          		$s649_Oct11_Bonus_win_amt = str_replace($str_money_sym,"",trim($lmatches[9]));
          		
          	
                $s6of6BonusDraw_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s649_Oct11_Bonus_win_amt, $objLottery->prz_money,  $na649_row["gameid"]);
                if (!$s6of6BonusDraw_win_prz_id) {
                  $s6of6BonusDraw_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s649_Oct11_Bonus_win_amt, $objLottery->prz_money,trim($lmatches[9]), $na649_row["gameid"]);
                }
                
          	} else {
          		$s649_Oct11_total_win_count = 0;
          		$s649_Oct11_Bonus_win_amt = str_replace($str_money_sym,"",trim($lmatches[9]));
          	    $s6of6BonusDraw_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s649_Oct11_Bonus_win_amt, $objLottery->prz_money,  $na649_row["gameid"]);
                if (!$s6of6BonusDraw_win_prz_id) {
                  $s6of6BonusDraw_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s649_Oct11_Bonus_win_amt, $objLottery->prz_money,trim($lmatches[9]), $na649_row["gameid"]);
                }
                
          	}
          	  if ($debug_mode > 1) {
                  print "[m6of6BonusDraw|" . $s649_Oct11_Bonus_win_amt . "|" . $s6of6BonusDraw_win_prz_id . "|" . $s649_Oct11_total_win_count . "|" . $s649_Oct11_Bonus_win_amt . "|" . $s6of6BonusDraw_win_prz_id . "]";
              }
          	
          	
          	// add the Bonus Draw winning to DB
          	
            
            $na649BonusDrawWinningId = $naLottery->na649WinningsGetId($na649BonusDrawId);
            if (!$na649BonusDrawWinningId) {
                $na649BonusDrawWinningId = $naLottery->na649WinningsAdd($na649BonusDrawId, $s649_Oct11_total_win_count, $s6of6BonusDraw_win_prz_id, 0,
                 0, 0, 0,0,0, 0, 0, 0, 0, 0);
                
                
                 if ($na649BonusDrawWinningId != "") {
               
                  //print_r($s6of6_win_loc_detail);
                  //print_r($s5of6B_win_loc_detail);  
                  if (is_array($s649_Oct11_win_loc_detail)) {
                    foreach ($s649_Oct11_win_loc_detail as $win_loc_id => $win_loc) {
                      if (!$naLottery->dbNa649WinLocGetId($na649BonusDrawWinningId, $win_loc_id, 6)) {   
                        $naLottery->dbNa649WinLocAdd($na649BonusDrawWinningId, $s6of6BonusDraw_win_prz_id, $win_loc["count"], $win_loc_id, 6);
                      	}
                    }
                  }
                
                }
          	}
          	
          	
          } elseif ($b649_Prze_m == 1 && 
             (preg_match("/" . $s6of6 . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);
             if (trim($lmatches[2]) != 0) {
                $html_locs = preg_split("/\s*<br \/>/i", $lmatches[2]);
                $s6of6_total_win_amount = 0;
                $s6of6_total_win_count = 0;
                $s6of6_win_loc_detail = array();
                foreach ($html_locs as $html_loc) {
                  if (preg_match("/" . $swinloc . "/i", $html_loc, $loc_matches)) {
                    //print_r($loc_matches);
                    
                    $str_location =  trim(str_replace($str_clean_sym, " ", $loc_matches[2]));
                    $s6of6_win_loc_id = $objLottery->dbLotWinLocationGetId($str_location, $objLottery->loc_prov);
                    if (!$s6of6_win_loc_id) {
                       $s6of6_win_loc_id = $objLottery->dbLotWinLocationAdd("", $str_location, "", "", $objLottery->loc_prov);
                    }
                    $s6of6_win_loc_detail[$s6of6_win_loc_id]["count"] = trim($loc_matches[1]);
                    $s6of6_total_win_count += trim($loc_matches[1]);
                  }
                
                }
                
                $s6of6_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
                
                $s6of6_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s6of6_prze_amt, $objLottery->prz_money,  $na649_row["gameid"]);
                if (!$s6of6_win_prz_id) {
                  $s6of6_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s6of6_prze_amt, $objLottery->prz_money,trim($lmatches[3]), $na649_row["gameid"]);
                }
                
                
                $s6of6_total_win_amount = $s6of6_total_win_count * $s6of6_prze_amt;
                $s6of6_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s6of6_total_win_amount, $objLottery->prz_money, $na649_row["gameid"]);
                //print "\nPrize : " . $s6of6_total_win_amount;
                
                if (!$s6of6_total_win_prz_id) {
                  $s6of6_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s6of6_total_win_amount, $objLottery->prz_money, number_format($s6of6_total_win_amount,2),$na649_row["gameid"]);
                }  
                
                
                      
              } else {
                //echo "<br />zero wins<br />";
                $s6of6_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
                $s6of6_total_win_amount = $s6of6_prze_amt;
                $s6of6_total_win_count = 0; 
                //print "\nPrize : " . $s6of6_total_win_amount;
             
                $s6of6_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s6of6_total_win_amount, $objLottery->prz_money, $na649_row["gameid"]);
                if (!$s6of6_total_win_prz_id) {
                  $s6of6_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s6of6_total_win_amount, $objLottery->prz_money, number_format($s6of6_total_win_amount,2), $na649_row["gameid"]);
                }

              }
              if ($debug_mode > 1) {
                  print "[m6of6|" . $s6of6_total_win_amount . "|" . $s6of6_total_win_prz_id . "|" . $s6of6_total_win_count . "|" . $s6of6_prze_amt . "|" . $s6of6_win_prz_id . "]";
              }
          } elseif ($b649_Prze_m == 1 &&
              (preg_match("/" . $s5of6B . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);    
           if (trim($lmatches[2]) != 0) {
                $html_locs = preg_split("/\s*<br \/>/i", $lmatches[2]);
                $s5of6B_total_win_amount = 0;
                $s5of6B_total_win_count  = 0;
                $s5of6B_win_loc_detail   = array();
                foreach ($html_locs as $html_loc) {
                  if (preg_match("/" . $swinloc . "/i", $html_loc, $loc_matches)) {
                    //print_r($loc_matches);
                    $str_location =  trim(str_replace($str_clean_sym, " ", $loc_matches[2]));
                    $s5of6B_win_loc_id = $objLottery->dbLotWinLocationGetId($str_location, $objLottery->loc_prov);
                    if (!$s5of6B_win_loc_id) {
                       $s5of6B_win_loc_id = $objLottery->dbLotWinLocationAdd("", $str_location, "", "", $objLottery->loc_prov);
                    }
                    $s5of6B_win_loc_detail[$s5of6B_win_loc_id]["count"] = trim($loc_matches[1]);
                    $s5of6B_total_win_count += trim($loc_matches[1]);                 
                  }
                }  
                $s5of6B_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
                
                $s5of6B_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s5of6B_prze_amt, $objLottery->prz_money, $na649_row["gameid"]);
                if (!$s5of6B_win_prz_id) {
                  $s5of6B_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s5of6B_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $na649_row["gameid"]);
                }
                
                $s5of6B_total_win_amount = $s5of6B_total_win_count * $s5of6B_prze_amt;  
                $s5of6B_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s5of6B_total_win_amount, $objLottery->prz_money, $na649_row["gameid"]);
                //print "\nPrize : " . $s5of6B_total_win_amount;

                if (!$s5of6B_total_win_prz_id) {
                  $s5of6B_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s5of6B_total_win_amount, $objLottery->prz_money, number_format($s5of6B_total_win_amount,2), $na649_row["gameid"]);
                }  
              } else {
                
                $s5of6B_prze_amt = str_replace($str_money_sym, "", trim($lmatches[3]));
                $s5of6B_total_win_count = 0;
                $s5of6B_total_win_amount = $s5of6B_prze_amt;
                
                //print "\nPrize : " . $s5of6B_total_win_amount;
                //echo "<br />zero wins<br />";
                
                $s5of6B_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s5of6B_total_win_amount, $objLottery->prz_money, $na649_row["gameid"]);
                if (!$s5of6B_total_win_prz_id) {
                  $s5of6B_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s5of6B_total_win_amount, $objLottery->prz_money, trim($lmatches[3]), $na649_row["gameid"]);
                }
              }
              if ($debug_mode > 1) {
                  print "[m5of6B|" . $s5of6B_total_win_amount . "|" . $s5of6B_total_win_prz_id . "|" . $s5of6B_total_win_count . "|" . $s5of6B_prze_amt . "|" . $s5of6B_win_prz_id . "]";
              }
            
          } elseif ($b649_Prze_m == 1 && (preg_match("/" . $s5of6 . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);
            $s5of6_win_cnt  = preg_replace("/,/i","",trim($lmatches[2]));
            $s5of6_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
              
            $s5of6_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s5of6_prze_amt, $objLottery->prz_money, $na649_row["gameid"]);
            if (!$s5of6_win_prz_id) {
              $s5of6_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s5of6_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $na649_row["gameid"]);
            }
            
            if ($debug_mode > 1) {
              print "[m5of6|" . $s5of6_prze_amt . "|" . $s5of6_win_prz_id . "|" . $s5of6_win_cnt . "]";
            }
          } elseif ($b649_Prze_m == 1 && 
              (preg_match("/" . $s4of6 . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);
            $s4of6_win_cnt  = preg_replace("/,/i","",trim($lmatches[2]));
            $s4of6_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
            $s4of6_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s4of6_prze_amt, $objLottery->prz_money, $na649_row["gameid"]);
            if (!$s4of6_win_prz_id) {
              $s4of6_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s4of6_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $na649_row["gameid"]);
            }  
               
            if ($debug_mode > 1) {
              print "[m4of6|" . $s4of6_prze_amt . "|" . $s4of6_win_prz_id . "|" . $s4of6_win_cnt . "]";
            }
          } elseif ($b649_Prze_m == 1 && 
              (preg_match("/" . $s3of6 . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);
            $s3of6_win_cnt  = preg_replace("/,/i","",trim($lmatches[2]));
            $s3of6_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
            $s3of6_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s3of6_prze_amt, $objLottery->prz_money, $na649_row["gameid"]);
            if (!$s3of6_win_prz_id) {
              $s3of6_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s3of6_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $na649_row["gameid"]);
            }
            
            if ($debug_mode > 1) {
              print "[m3of6|" . $s3of6_prze_amt . "|" . $s3of6_win_prz_id . "|" . $s3of6_win_cnt . "]";
              
            }
            
          } elseif ($b649_Prze_m == 1 && 
              (preg_match("/" . $s2of6B . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);  
            
            $s2of6B_win_cnt  = preg_replace("/,/i","",trim($lmatches[2]));
            //$s2of6B_prze_amt = preg_replace("/(\$|,)/i","",trim($lmatches[3]));
            $s2of6B_prze_amt = str_replace($str_money_sym,"",trim($lmatches[3]));
            
            //print " 2of6 Prze Amt : " . $s2of6B_prze_amt . "\n";
            $s2of6B_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($s2of6B_prze_amt, $objLottery->prz_money, $na649_row["gameid"]);
            if (!$s2of6B_win_prz_id) {
              $s2of6B_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($s2of6B_prze_amt, $objLottery->prz_money, trim($lmatches[3]),$na649_row["gameid"]);
            }          
            
            if ($debug_mode > 1) {
              print "[m2of6B|" . $s2of6B_prze_amt . "|" . $s2of6B_win_prz_id . "|" . $s2of6B_win_cnt . "]";
              
            }
            
            print "\nParse " . $site_file . $site_querystr;
            print "\nDate: " . date('Y-m-d', $drawdate);
        
            
            $na649WinningId = $naLottery->na649WinningsGetId($na649DrawId);
            if (!$na649WinningId) {
                $na649WinningId = $naLottery->na649WinningsAdd($na649DrawId, $s6of6_total_win_count, $s6of6_total_win_prz_id, $s5of6B_total_win_count,
                 $s5of6B_total_win_prz_id, $s5of6_win_cnt, $s5of6_win_prz_id, $s4of6_win_cnt, $s4of6_win_prz_id, $s3of6_win_cnt, $s3of6_win_prz_id, $s2of6B_win_cnt, $s2of6B_win_prz_id, 0);
                
                /*print "\nDraw Detail: ID: " . $na649DrawId;
                print " Win 6of6: " . $s6of6_total_win_count . " " . $s6of6_total_win_amount . " " . $s6of6_total_win_prz_id; 
                print " 5of6 : " .  $s5of6B_total_win_count . " " .  $s5of6B_total_win_amount . " " . $s5of6B_total_win_prz_id;
                print " 5of6: " .  $s5of6_win_cnt . " " .  $s5of6_prze_amt . " " . $s5of6_win_prz_id;
                print " 4of6 Cnt: " . $s4of6_win_cnt . " " .  $s4of6_prze_amt . " " . $s4of6_win_prz_id;
                print " 3 of 6 cnt: " .  $s3of6_win_cnt . " " .  $s3of6_prze_amt . " " . $s3of6_win_prz_id; 
                print " 2 of 6 cnt: " . $s2of6B_win_cnt . " " .  $s2of6B_prze_amt . " " . $s2of6B_win_prz_id; 
                 */ 
                 print "\nSave - NewRecord: " . $na649WinningId . " -- " . $na649DrawId;
                if ($na649WinningId != "") {
               
                  //print_r($s6of6_win_loc_detail);
                  //print_r($s5of6B_win_loc_detail);  
                  if (is_array($s6of6_win_loc_detail)) {
                    foreach ($s6of6_win_loc_detail as $win_loc_id => $win_loc) {
                      if (!$naLottery->dbNa649WinLocGetId($na649WinningId, $win_loc_id, 6)) {   
                        $naLottery->dbNa649WinLocAdd($na649WinningId, $s6of6_win_prz_id, $win_loc["count"], $win_loc_id, 6);
                      }
                    }
                  }
                  if (is_array($s5of6B_win_loc_detail)) {
                    foreach ($s5of6B_win_loc_detail as $win_loc_id => $win_loc) {
                      if  (!$naLottery->dbNa649WinLocGetId($na649WinningId, $win_loc_id, 5)) {    
                        $naLottery->dbNa649WinLocAdd($na649WinningId, $s5of6B_win_prz_id, $win_loc["count"], $win_loc_id, 5);
                      }
                    }
                  }
                }
            }
            
            if ($debug_mode > 1) {
              print "[" . $na649WinningId . "]";
            }            
          } elseif (preg_match("/" . $srg649_num . "/i", $html_tr, $lmatches)) {
            
            $sdrawMonthName = $lmatches[1];
            $sdrawMonthNum  = $objDate->getMonthNum($sdrawMonthName);
            $sdrawDay       = $lmatches[2];
            $sdrawYear      = $lmatches[3];
            $s649_date = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
            
            if ($debug_mode > 1) {
              print "[" . $s649_date . "]";
            }
            //print "\nDrawDate: " . $s649_date;
            //print_r($lmatches);
            $snum1 = $lmatches[4];
            $snum2 = $lmatches[5];
            $snum3 = $lmatches[6];
            $snum4 = $lmatches[7];
            $snum5 = $lmatches[8];
            $snum6 = $lmatches[9];
            $snumbonus = $lmatches[10];
            
            if ($debug_mode > 1) {
              print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6 . "|B:" . $snumbonus . "]";
            }
            
            $na649DrawId = $naLottery->na649GetDrawId($s649_date);
            if (!$na649DrawId) {
              //print "\nSave - New Number : " . $na649DrawId;
              $na649DrawId = $naLottery->na649Add($s649_date, 0, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snumbonus);
            } 
            if ($debug_mode > 1) {
              print "[" . $na649DrawId . "]";
            }   
        
          } elseif (preg_match("/" . $sPrze_Tag_hdr . "/i", $html_tr, $lmatches)) {
            $bTag_Prze_m  		= 1;
            $b649_Prze_m  		= 0;
            $b49_Prze_m   		= 0;
          	$b649_Oct11_Prze_m 	= 0;
          	$b649_Mar12_Prze_m 	= 0;
            //print_r($lmatches);
          } elseif (preg_match("/" . $sPrze_649_hdr . "/i", $html_tr, $lmatches)) {
            $bTag_Prze_m  		= 0;
            $b649_Prze_m  		= 1;
            $b49_Prze_m   		= 0;
          	$b649_Oct11_Prze_m 	= 0;      
          	$b649_Mar12_Prze_m 	= 0;
            //print_r($lmatches);
          } elseif (preg_match("/" . $sPrze_49_hdr . "/i", $html_tr, $lmatches)) {
            $bTag_Prze_m  		= 0;
            $b649_Prze_m  		= 0;
            $b49_Prze_m   		= 1;
          	$b649_Oct11_Prze_m 	= 0;
          	$b649_Mar12_Prze_m	= 0;
            //print_r($lmatches);
        /*  } elseif (preg_match("/" . $sOct2011_BonusDraw_Hdr . "/i", $html_tr, $lmatches)) {
          	$bTag_prze_m 		= 0;
          	$b649_Prze_m 		= 0;
          	$b49_Prze_m 		= 0;
          	$b649_Oct11_Prze_m 	= 1;
          	$b649_Mar12_Prze_m 	= 0;
          	
          	print_r($lmatches);
          	*/
          } elseif (preg_match("/" .  $sMar2012_BonusDraw_Hdr . "/i", $html_tr, $lmatches)) {
          	$b649_Mar12_Prze_m = 1;
          	$bTag_prze_m 	   = 0;
          	$b649_Prze_m 	   = 0;
          	$b49_Prze_m 	   = 0;
          	$b649_Oct11_Prze_m = 0;
          }
        }

    /* 
    * 
    */
  }
  
  
  
  ?>