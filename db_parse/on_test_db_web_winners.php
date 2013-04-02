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
  
  

  
  $objLottery = new Lottery();
  $objGenDates = new GenDates();
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
    
      $drawDates = null;
      if (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
           print_r($lmatches); 
          $selectedDay    = $lmatches[1];
          $selectedMonth  = $lmatches[2];
          $selectedYear   = $lmatches[3];
          $startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
          $endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
          //$drawDates = $objLottery->dbLotteryGetDrawDates("onPoker", "DD", $startDate, $endDate);
          $drawDates[0] = date('d-m-Y',$startDate);
        } elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})|(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
          $selectedMonth = $lmatches[1];
          $selectedYear = $lmatches[2];
          $startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
          $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
          $drawDates = $objGenDates->getAllWeekDays(date('d-m-Y',$startDate), date('d-m-Y',$endDate));
          //$drawDates = $objLottery->dbLotteryGetDrawDates("onPoker", "MM", $startDate, $endDate);    
        } elseif (preg_match("/getAll/i", $selection, $lmatches)) {
          $drawDates = "ALL";
        }
         
        print_r($drawDates);
        if (is_array($drawDates)) {
          foreach ($drawDates as $dtDate) {
              // 20090211
            $drawDate = strtotime($dtDate);
            print "\n<br /> " . date('d-m-Y', $drawDate); 
            //print_r($dtDate);
            //alc_fetch_single_draw(date('d-m-Y',$drawDate));
            //on_fetch_first_step_649(date('d-m-Y', $drawDate));
            //on_fetch_first_step_max(date('d-m-Y', $drawDate));
            
            on_fetch_first_step_winners(date('d-m-Y', $drawDate));
          }
        } elseif ($drawDates == "ALL") {
          on_fetch_first_step_winners();
        }
        
    } while (trim($selection) != 'q');
  
  
  function on_fetch_first_step_winners($drawdate = "") {

      
      // http://www.olg.ca/about/media/winner_list.jsp
      
      // PRIZE WINNERS OF $1,000 OR MORE
      $drawdate = strtotime($drawdate);
      print "\nDraw Date: " . $drawdate . " DT: " . date('mdy', $drawdate);
      if ($drawdate == "" || $drawdate == null) {
          $url1 = "http://www.olg.ca/about/media/winner_list.jsp";
          
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
          
          $h1_winners_1000 = "<h1 class=\"about\">Prize Winners of $1,000 or more<\/h1>";
          
          $html_h2_list = preg_split("/<h2 class=\"about\">/i", $html_body);
          
          print_r($html_h2_list);
          
          foreach ($html_h2_list as $html_h2) {
              if (preg_match("/<a class=.*? href=\"(.*?contentID=winner_list_)(\d{2})(\d{2})(\d{2})\">(.*?)<\/a>/i", $html_h2, $lmatches)) {
                print_r($lmatches);      
                
                $surl = "http://www.olg.ca/" . $lmatches[1] . $lmatches[2] . $lmatches[3] . $lmatches[4];
                
                $smonth = $lmatches[2];
                $sday   = $lmatches[3];
                $syear  = $lmatches[4];
                $win_claim_date      = mktime(0,0,0,$smonth, $sday, $syear); 
                on_fetch_second_step_winners(date('d-m-Y',$win_claim_date), $surl);   
              }
            
          }
     } else {
          
          $swin_claim_date = date('mdy', $drawdate);
          $surl = "http://www.olg.ca/about/media/winner_release.jsp?contentID=winner_list_" . $swin_claim_date;
          print $surl;
          on_fetch_second_step_winners(date('d-m-Y', $drawdate), $surl);

     }
  } 
  
  function on_fetch_second_step_winners($drawdate, $surl = "") {
    
            
        // http://www.olg.ca/about/media/winner_list.jsp
        
        // PRIZE WINNERS OF $1,000 OR MORE
        /*
         *  <th class="wn" style="text-align: left;">First Name</th>
         * <th class="wn" style="text-align: left;">Last Name</th>
         * <th class="wn" style="text-align: left;">Town/City</th>
         * <th class="wn">Prov/<br />State</th>
         * <th class="wn">Game</th>
         * <th class="wn">*Draw Date<br />or<br />INSTANT<br />Game No.</th>
         * <th class="wn" style="text-align: left;">Prize</th>
         * <th class="wn" style="text-align: left;">
         * <span style="font-size: 70%; font-weight: normal; vertical-align: text-top;">†</span>I</th>
         * <th class="wn" style="text-align: right;"><span style="font-size: 70%; font-weight: normal; vertical-align: text-top;">‡
         * </span>G</th>
         * </tr> 
         *     </thead> 
         *     <tbody>     <!-- paste content here --> 
         * 
         * 
         */
        
         /*
          *  <td class="wn">          RENWICK </td> 
          * <td class="wn">             MORRISON </td> 
          * <td class="wn">                 AJAX </td> 
          * <td class="wn cntr">    ON </td> 
          * <td class="wn cntr">                     LOTTO 6/49 </td> 
          * <td class="wn cntr">       12-Jan-2011 </td> 
          * <td class="wn"> $1,435.30  </td> 
          * <td class="wn">  N </td> 
          * <td class="wn rght">  N </td>
          *  </tr> 
          * 
          *         $url1 = "http://www.olg.ca/about/media/winner_list.jsp";
          *          $url2 = "http://www.olg.ca/about/media/winner_release.jsp?contentID=winner_list_012111";
          * 
          */
          
        if ($surl == null || $surl == "") {
            $swin_claim_date = date('mdy', $drawdate);
            $surl = "http://www.olg.ca/about/media/winner_release.jsp?contentID=winner_list_" . $swin_claim_date;
        } 
        
        
      $objLottery   = new Lottery();
      $objDate      = new GenDates();
      $objOLG       = new OLGLottery();
      $naLottery    = new NALottery();
      $olgWinners_row   = $objLottery->dbLotteryGamesGet("olgWinners");
      $na649_row        = $objLottery->dbLotteryGamesGet("na649");
      $onEncore_row     = $objLottery->dbLotteryGamesGet("onEncore"); 
  
      $drawdate = strtotime($drawdate);
      if (preg_match("/http:\/\/([^\/]*)(.*)\/(.*?)\?(.*)/i", $surl, $lmatches) ) {
          
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
        
          //$site_post_str = sprintf("gameID=%u&drawNo=%usdrawDate=%u&spielID=%u", $str_gameid, $str_drawNo, $str_drawdate, $str_spielid);
          //$site_post_id = $objLottery->dbWebUrlsGetId($site_post_str, "POSTSTR");
          //if (!$site_post_id) {
          //  $site_post_id = $objLottery->dbWebUrlsAdd($site_post_str, "POSTSTR");
          //}          
          
        /*  print_r($lmatches);
          print "\nSiteDomain: " . $site_domain_id;
          print "\nSitePath  : " . $site_path_id;
          print "\nSiteFile  : " . $site_file_id;
          print "\nSitePost : " . $site_post_id;
          print "\n\n" . $site_post_str;
          */       
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("olgWinners", $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($na649_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("olgWinners", $olgWinners_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("olgWinners", $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id);
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
        
        
        $http = new http();
        
        $http->headers['Referer'] = $surl;
        if (!$http->fetch($surl)) {
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
        
        if (!$http->fetch($surl)) {
            $this->status_msg = "... ";
        
        }
        
        $html_body = preg_replace("/\s|\t|\n|\r\n/"," ",$http->body);
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
        
        
        $h1_winners_1000 = "<h1 class=\"about\">Prize Winners of $1,000 or more<\/h1>";
        
        $html_tr_list = preg_split("/<tr[^>]*>/i", $html_body);
        
        //print_r($html_tr_list);
        
        $winners_th_list = $srgB_th . "\s*(.*?)\s*" . $srgE_th;             // First Name
        $winners_th_list .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Last Name
        $winners_th_list .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Town / City
        $winners_th_list .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Prov / State
        $winners_th_list .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Game
        $winners_th_list .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Draw Date / INSTANT
        $winners_th_list .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Prize
        $winners_th_list .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Insider
        $winners_th_list .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Group
        $winners_th_list .= "\s*" . $srgE_tr;
        
        $winners_td_list = $srgB_td . "\s*(.*?)\s*" . $srgE_td;             // First Name
        $winners_td_list .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;    // Last Name
        $winners_td_list .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;    // Town / City
        $winners_td_list .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;    // Prov / State
        $winners_td_list .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;    // Game
        $winners_td_list .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;    // Draw Date / INSTANT
        $winners_td_list .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;    // Prize
        $winners_td_list .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;    // Insider
        $winners_td_list .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;    // Group
        $winners_td_list .= "\s*" . $srgE_tr;

        
        $str_money_sym = array("$",",");
        
        $bWinners_m     = 0;
        $bNewGroup      = 1;
        $iLastGroupId   = 0;
        $iPrizeClaimPos = 0;
        $iGroupClaimPos = 0;
        foreach ($html_tr_list as $html_tr) {
            if ($bWinners_m == 0 &&
                preg_match("/" . $winners_th_list . "/i", $html_tr, $lmatches)) {
                //print_r($lmatches);
                $bWinners_m = 1;      
            } elseif ( $bWinners_m == 1 &&
                preg_match("/" . $winners_td_list . "/i", $html_tr, $lmatches)) {
                //print_r($lmatches);  
                
                $strFirstName = trim($lmatches[1]);
                $strLastName  = trim($lmatches[2]);
                $strCity      = trim($lmatches[3]);
                $iCityId      = $objLottery->dbLotWinLocationGetId($strCity, $objLottery->loc_city);
                if (!$iCityId) {
                  $iCityId = $objLottery->dbLotWinLocationAdd($strCity, "","","", $objLottery->loc_city);
                }
                $strProv        = trim($lmatches[