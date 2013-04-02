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
  include_once("../inc/incTools.php");
  include_once("../inc/incOLGData.php");
  
  include_once("phpArguments.php");
  
      // Debug Mode
  // 0 = verbose disabled
  // 1 = verbose enabled
  // 2 = verbose extra info
  
  
  $debug_mode         = 2;
  
  $objLottery = new Lottery();
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
       print_r($lmatches); 
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
        //alc_fetch_single_draw(date('d-m-Y',$drawDate));
        //on_fetch_first_step_649(date('d-m-Y', $drawDate));
        on_fetch_first_step_max(date('d-m-Y', $drawDate));
      }
    }    
    
  } while (trim($selection) != 'q');
  
  function on_fetch_first_step_max($drawdate = "") {
    
      global $debug_mode;
          
      $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
      
      $objLottery = new Lottery();
      $objDate    = new GenDates();
      $objOLG     = new OLGLottery();
      $naLottery  = new NALottery();
      
      //print "\n\n" . $drawdate . " --- ";
      $drawdate = strtotime($drawdate);
      //print date('mY', $drawdate);
            
      $naMaxGameId      = 73;
      
      if ($drawdate == "") {
        $hp_selectedMonthYear = date('mY', mktime(0,0,0,date('m') - 1, 1, date('Y')));
      } else {
        $hp_selectedMonthYear = date('mY', mktime(0,0,0,date('m', $drawdate) - 1, 1, date('Y', $drawdate)));
      }
      //print "\nSelectedMonth Year: " . $hp_selectedMonthYear;
      
      $hp_day           = 0;
      $hp_gameID        = $naMaxGameId;
      $hp_command       = "submit";
      
      $naMax_row        = $objLottery->dbLotteryGamesGet("naMax");
      
      
      
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
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("naMAX", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($naMax_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("naMAX", $naMax_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("naMAX", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
      
      $bNaMax_m     = 0;
      
      $srg_maxNum       = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*"; 
      $srg_maxMillNum   = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*"; 
      
      $srg_encore = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
      $srg_bonusnum  = "\s*(\d{2})\s*";
       
      $srg_onMaxMainDraw = "\s*Main Draw\s*";
      $srg_onMaxMillions = "\s*MAXMILLIONS\s*";
      
      $str_money_sym = array("$",","); 
      
      $b_Max_m          = 0;
      $b_Max_Mill_m     = 0;
      $b_On_Max_Mill_m  = 0;
      /*
       *    <th class="white_centre" id="lottery_borderless" align="center">         DATE   </th>
       *         <th class="white_centre" id="lottery_borderless" align="center">                              NUMBERS                          
       *   <th class="white_centre" id="lottery_borderless" align="center">     BONUS</th>           
       *  <th class="white_centre" id="lottery_borderless" align="center">         ENCORE   </th>       
       *  <th class="white_centre" id="lottery_borderless" align="center">    WINNINGS</th>   </tr>                                                                             
          [7] =>   
       * 
       */
      
      
      $sMax_th_Lines = $srgB_th . "\s*(.*?)\s*" . $srgE_th;             // Date
      $sMax_th_Lines .= "\s*" . $srgB_th . "\s*(.*?)\s*";               // Numbers
      $sMax_th_Lines .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Bonus
      $sMax_th_Lines .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Encore
      $sMax_th_Lines .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;    // Winnings
      
      $sMax_td_Lines = $srgB_td . "\s*(.*?)\s*" . $srgE_td;             // Date
      $sMax_td_Lines .= "\s*" . $srgB_td . "\s*(.*?)\s*";     // Numbers
      $sMax_td_Lines .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;     // Bonus
      $sMax_td_Lines .= "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td;     // Encore
      $sMax_td_Lines .= "\s*" . $srg_form_act . "\s*" . $srgB_td . "\s*(.*?)\s*" . $srgE_td . "\s*" . $srgE_form;     // Winnings 
      //print_r($html_tr_list);
      //print_r($sMax_th_Lines);
      //print_r($sMax_td_Lines);
      
      if ($debug_mode > 0) {
        print "\nFetch " . $site_file . $site_querystr;
        print "\nDate: " . date('Y-m-d', $drawdate);
      }  
      
      
      
      foreach ($html_tr_list as $html_tr) {
        if (preg_match("/" . $sMax_th_Lines . "/i", $html_tr, $lmatches)) {
          $b_Max_m  = 1;
          //print_r($lmatches);
        } 
        // Matches Max Row
        elseif ($b_Max_m == 1 &&
                  (preg_match("/" . $sMax_td_Lines . "/i", $html_tr, $lmatches))) {
            //print_r($lmatches);
            
            // Match Draw Date
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
                //print_r($lotResMat);  
                
                $sdrawMonthName = trim($lotResMat[2]);
                $sdrawMonthNum  = $objDate->getShortMonthNum($sdrawMonthName);
                $sdrawDay       = $lotResMat[1];
                $sdrawYear      = $lotResMat[3];
                $sMax_drawdate  = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
                
                if ($debug_mode > 1) {
                  print "\n [" . $sMax_drawdate . "]";
                }
                //print "\nMax Draw Date: " . $sMax_drawdate;    
             }
            // Match Max With Max Millions Draws
            if (preg_match("/" . $srg_onMaxMainDraw . "/i", $lmatches[2] , $lotResMat)) {
                //print_r($lotResMat);
                $html_br_list = preg_split("/<br[^>]>/i", $lmatches[2]);
                //print_r($html_br_list);
        
                $b_Max_Mill_m = 0;
                $b_On_Max_Mill_m = 0;
                foreach ($html_br_list as $html_br) {
                  // Max Main Draw
                  if (preg_match("/" . $srg_onMaxMainDraw . ".*?" . $srgB_p . "\s*" . $srg_maxNum . "/i", $html_br, $lotResMat)) {
                    //print_r($lotResMat);
                      $snum1      = $lotResMat[1];
                      $snum2      = $lotResMat[2];
                      $snum3      = $lotResMat[3];
                      $snum4      = $lotResMat[4];
                      $snum5      = $lotResMat[5];
                      $snum6      = $lotResMat[6];
                      $snum7      = $lotResMat[7];
                      
                      $sSeqPos = 0;
                      
                      if ($debug_mode > 1) {
                        print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6 . "|" . $snum7 . "]";
                      }
                      
                  } 
                  // Match Max Million Number
                  elseif (preg_match("/" . $srg_onMaxMillions . "/i", $html_br, $lotResMat)) {
                    
                    if ($b_Max_Mill_m  == 0) {        // Regular Max Millions
                      $b_Max_Mill_m = 1;
                      $b_On_Max_Mill_m = 0;
                    } else {
                      $b_On_Max_Mill_m = 1;           // Ontario Max Millions
                      $b_Max_Mill_m = 0;
                    }
                  }
                  
                  // Match Regular Max Million
                   elseif ($b_Max_Mill_m == 1 &&
                          (preg_match("/" . $srg_maxMillNum . "/i", $html_br, $lotResMat))) {
                      //print_r($lotResMat);       
                      // Max Million Numbers into DB
                      $mill_snum1      = $lotResMat[1];
                      $mill_snum2      = $lotResMat[2];
                      $mill_snum3      = $lotResMat[3];
                      $mill_snum4      = $lotResMat[4];
                      $mill_snum5      = $lotResMat[5];
                      $mill_snum6      = $lotResMat[6];
                      $mill_snum7      = $lotResMat[7];
                      $mill_snumBonus  = 0;
                      $sSeqPos = $sSeqPos + 1;
                      $naMaxMillId = $naLottery->naMaxGetDrawId($sMax_drawdate, $sSeqPos);
                      if (!$naMaxMillId) {
                        $naMaxMillId = $naLottery->naMaxAdd($sMax_drawdate, "", $sSeqPos, $mill_snum1, $mill_snum2, $mill_snum3, $mill_snum4, $mill_snum5, $mill_snum6, $mill_snum7, $mill_snumBonus, $sregion = "na", "", "", "");
        
                      }
                      if ($debug_mode > 1) {
                        print "\n[" . $mill_snum1 . "|" . $mill_snum2 . "|" . $mill_snum3 . "|" . $mill_snum4 . "|" . $mill_snum5 . "|" . $mill_snum6 . "|" . $mill_snum7 . "]"; 
                      }
                  } 
                  
                  // Match only Ontario Max Million
                  elseif ($b_On_Max_Mill_m == 1 &&
                          (preg_match("/" . $srg_maxMillNum . "/i", $html_br, $lotResMat))) {
                      //print "\n<br /> Ontario Only \n<br />";
                      
                      // Ontario Max Million Numbers Into DB
                      //print_r($lotResMat);          
                      $mill_snum1      = $lotResMat[1];
                      $mill_snum2      = $lotResMat[2];
                      $mill_snum3      = $lotResMat[3];
                      $mill_snum4      = $lotResMat[4];
                      $mill_snum5      = $lotResMat[5];
                      $mill_snum6      = $lotResMat[6];
                      $mill_snum7      = $lotResMat[7];
                      $mill_snumBonus  = 0;
                      $sSeqPos = $sSeqPos + 1;
                      $naMaxMillId = $naLottery->naMaxGetDrawId($sMax_drawdate, $sSeqPos);
                      if (!$naMaxMillId) {
                        $naMaxMillId = $naLottery->naMaxAdd($sMax_drawdate, "", $sSeqPos, $mill_snum1, $mill_snum2, $mill_snum3, $mill_snum4, $mill_snum5, $mill_snum6, $mill_snum7, $mill_snumBonus, $sregion = "on", "", "", "");
        
                      } 
                      if ($debug_mode > 1) {
                        print "\n[" . $mill_snum1 . "|" . $mill_snum2 . "|" . $mill_snum3 . "|" . $mill_snum4 . "|" . $mill_snum5 . "|" . $mill_snum6 . "|" . $mill_snum7 . "]"; 
                      }
                      
                  }
                }
            }
            // Match Regular Max Draw
            elseif (preg_match("/" . $srgB_strong . "\s*" . $srgB_p . $srg_maxNum . "/i", $lmatches[2], $lotResMat)) {
              //print_r($lotResMat);
              //$snumBonus = $lotResMat[1];
              
              $snum1      = $lotResMat[1];
              $snum2      = $lotResMat[2];
              $snum3      = $lotResMat[3];
              $snum4      = $lotResMat[4];
              $snum5      = $lotResMat[5];
              $snum6      = $lotResMat[6];
              $snum7      = $lotResMat[7];
              if ($debug_mode > 1) {
                print "\n[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6 . "|" . $snum7 . "]";
              }
              
              $sSeqPos = 0;
            }
            // Match Max Bonus Number
            if (preg_match("/" . $srgB_p . $srgB_strong . $srg_bonusnum . $srgE_strong . $srgE_p . "/i", $lmatches[3], $lotResMat)) {
              //print_r($lotResMat);
              $snumBonus = $lotResMat[1];
              
            }
            // Match Max Encore
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . $srg_encore . $srgE_strong . $srgE_p . "/i", $lmatches[4], $lotResMat )) {
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
            // Match Post Url 
            if (preg_match("/\s*([a-zA-Z.*\/?=]*)\s*/i", $lmatches[5], $lotResMat)) {
              //print_r($lotResMat);
            }
            // Match Post Variables for Prize Detail Page
            if (preg_match("/\s*" . $srg_gameid . "\s*" . $srg_drawNo . "\s*" . $srg_drawDate . "\s*" . $srg_spielId . "\s*<input[^>]*>" . "/i", $lmatches[6], $lotResMat)) {
              //print_r($lotResMat);
              $str_gameid   = $lotResMat[1];
              $str_drawNo   = $lotResMat[2];
              $str_drawDate = $lotResMat[3];
              $str_spielId  = $lotResMat[4];
              
              if ($debug_mode > 1) {
                print "[" . $str_gameid . "|" . $str_drawNo . "|" . $str_drawDate . "|" . $str_spielId . "]";
              }
              
              // Insert Lotto Max Numbers in DB
              //print "\nInsert Main Lotto Numbers\n" . "Draw Date: " .  $sMax_drawdate;
              $sSeqPos = 0;
              $naMaxId = $naLottery->naMaxGetDrawId( $sMax_drawdate, $sSeqPos);
              if (!$naMaxId) {
                $naMaxId = $naLottery->naMaxAdd($sMax_drawdate, "", $sSeqPos, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumBonus, $sregion = "na", $str_drawNo, $str_drawDate, $str_spielId);
              }   
              if ($debug_mode > 1) {
                print "[" . $naMaxId . "]";
              }
              $str_onEncoreId = $objOLG->OLGEncoreGetDrawId( $sMax_drawdate);
               if (!$str_onEncoreId) {
                 $str_onEncoreId = $objOLG->OLGEncoreAdd($sMax_drawdate, "", $senc_num1, $senc_num2, $senc_num3, $senc_num4, $senc_num5, $senc_num6, $senc_num7);
               }
               
               if ($debug_mode > 1) {
                 print "[" . $str_onEncoreId . "]";
               }
               // Call the Next Function
               on_fetch_second_step_Max( $sMax_drawdate, $str_gameid, $str_drawNo, $str_drawDate, $str_spielId);
            }
            

            
            
        } 
        
        
      }
          
    
    
  }


function on_fetch_second_step_Max($sdrawdate, $str_gameid, $str_drawNo, $str_drawdate, $str_spielid) {
     
      global $debug_mode;
     
      $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
      $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
      
      $objLottery = new Lottery();
      $objDate    = new GenDates();
      $objOLG     = new OLGLottery();
      $naLottery  = new NALottery();
      
      $drawdate   = strtotime($sdrawdate);
      
      $naMaxGameId      = 73;
      
      $naMax_row        = $objLottery->dbLotteryGamesGet("naMax");
      $onEncore_row     = $objLottery->dbLotteryGamesGet("onEncore");
      
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
          $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("naMAX", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
          if (!$fetch_stats_id) {
            $fetch_date = date('Y-m-d H:i:s');
            $fetch_pos = 0;
            $fetch_process_suc = 0;
            //print_r($naMax_row);
            // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
            $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("naMAX", $naMax_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_post_id, $fetch_date, 1, "");
            $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
           } else {
            $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("naMAX", $site_domain_id, $site_path_id, $site_file_id, $site_post_id);
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
    
    
      
  $naMaxGameId      = 73;
  // $str_gameid, $str_drawNo, $str_drawdate, $str_spielid
  $http->postvars['gameID']     = $naMaxGameId;
  $http->postvars['drawNo']     = $str_drawNo;
  $http->postvars['sdrawDate']  = $str_drawdate;
  $http->postvars['spielID']    = $str_spielid;
  
  
  if (!$http->fetch($url_step3)) {
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
  
  $bNaMax_m     = 0;
  
  $srg_maxNum       = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*"; 
  $srg_maxMillNum   = "\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*(\d{2})\s*"; 
  
  $srg_encore = "\s*(\d)(\d)(\d)(\d)(\d)(\d)(\d)\s*";
  $srg_bonusnum  = "\s*(\d{2})\s*";
  
  //print_r($html_tr_list);
  
  
  $srg_onMaxMainDraw = "\s*Main Draw\s*";
  $srg_onMaxMillions = "\s*MAXMILLIONS\s*";
  
  $b_Max_m          = 0;
  $b_Max_Mill_m     = 0;
  $b_On_Max_Mill_m  = 0;
  $b_encore_m       = 0;
  $s_MaxWinNormalHdr       = "WINNINGS FOR \s* LOTTO MAX DRAW";
  $s_MaxWinningHdr         = "WINNINGS FOR \s* LOTTO MAX DRAW";
  $s_OnMaxBonusWinningHdr  = "WINNINGS FOR ONTARIO LOTTO MAX BONUS";
  $s_MaxMillWinningHdr     = "WINNINGS FOR MAXMILLIONS";
  
  $s_encoreWinningHdr      = "WINNINGS FOR ENCORE";
  
  $sMax_Main_th = $srgB_th . "\s*(.*?)\s*" . $srgE_th;            // Match
  $sMax_Main_th .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;   // Number of winnings
  $sMax_Main_th .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;   // Prize
  
  $sMax_Main_td = $srgB_td . "\s*" . $srgB_p . $srgB_strong .  "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" .  $srgE_td;
  $sMax_Main_td .=  "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
  $sMax_Main_td .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
  
  $sMax_Mill_th = $srgB_th . "\s*(.*?)\s*" . $srgE_th;            // Match
  $sMax_Mill_th .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;   // Number of winnings
  $sMax_Mill_th .= "\s*" . $srgB_th . "\s*(.*?)\s*" . $srgE_th;   // Prize
  
  $srg_MaxMill = "\s*" . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong;
  $srg_MaxMill .= "\s*" . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong;
  $srg_MaxMill .= "\s*" . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong;
  $srg_MaxMill .= "\s*" . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong;
  $srg_MaxMill .= "\s*" . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong;
  $srg_MaxMill .= "\s*" . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong;
  $srg_MaxMill .= "\s*" . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong;
  
  $sMax_Mill_td = $srgB_td . ".*?" . $srg_MaxMill . ".*?" . $srgE_td;
  $sMax_Mill_td .= "\s*" .  $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*" . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
  $sMax_Mill_td .= "\s*" . $srgB_td . "\s*" . $srgB_p . $srgB_strong . "\s*(.*?)\s*"  . $srgE_strong . $srgE_p . "\s*" . $srgE_td;
  
  $sEncore_th_Line = $srgB_th . "(.*?)" . $srgE_th;               // Match
  $sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Number of Winners
  $sEncore_th_Line .= "\s*" . $srgB_th . "(.*?)" . $srgE_th;      // Prize
  
  $sEncore_td_Line = $srgB_td    . "\s*" .  $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;               // Match
  $sEncore_td_Line .= "\s*" . $srgB_td  . "\s*" .   $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;      // Number of Winners
  $sEncore_td_Line .= "\s*" . $srgB_td   . "\s*" .  $srgB_p . $srgB_strong .  "\s*(.*?)\s*"  . $srgE_strong . $srgE_p  . "\s*" .   $srgE_td;      // Prize
  
  $str_money_sym = array("$",","); 
  $win_location = "Canada";
  
   if ($debug_mode > 0) {
      print "\nFetch " . $site_file . $site_querystr;
      print "\nDate: " . date('Y-m-d', $drawdate);
   }    
    
  
  foreach ($html_tr_list as $html_tr) {
    
    // Detect Max Winning Header
    if (preg_match("/" . $s_MaxWinningHdr . "/i", $html_tr, $lmatches)) {
      $b_Max_m          = 1;
      $b_Max_Mill_m     = 0;
      $b_On_Max_Mill_m  = 0;
      $b_encore_m       = 0;
      
    } 
    // Detect Max Winning Header Row
    elseif ($b_Max_m == 1 &&
            (preg_match("/" . $sMax_Main_th  . "/i", $html_tr, $lmatches))) {
      //print_r($lmatches);
      
      
    } 
    // Detect Max Winning Cell
    elseif ($b_Max_m == 1 &&
             (preg_match("/" . $sMax_Main_td . "/i", $html_tr, $lmatches))) {
      
      //print_r($lmatches);
      
      
      if (preg_match("/7\/7/i", $lmatches[1], $lot_m_)) {
        $s7of7_total_win_amount = 0;
        $s7of7_total_win_count  = $lmatches[2];
        $s7of7_prze_amt         = str_replace($str_money_sym, "", trim($lmatches[3]));
        $s7of7_win_loc_detail   = array();
        
        $s7of7_prze_id          = $objLottery->dbLotteryWinPrizesGetId($s7of7_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
        if (!$s7of7_prze_id) {
          $s7of7_prze_id        = $objLottery->dbLotteryWinPrizesAdd($s7of7_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
        }
        
        //print "\n 7/7 : " . $s7of7_total_win_count;
        if ($s7of7_total_win_count > 0) {
          $s7of7_total_win_amount = $s7of7_total_win_count * $s7of7_prze_amt;
          $s7of7_total_win_prze_id = $objLottery->dbLotteryWinPrizesGetId($s7of7_total_win_amount, $objLottery->prz_money, $naMax_row["gameid"]);
          if (!$s7of7_total_win_prze_id) {
            $s7of7_total_win_prze_id = $objLottery->dbLotteryWinPrizesAdd($s7of7_total_win_amount, $objLottery->prz_money, number_format($s7of7_total_win_amount, 2), $naMax_row["gameid"]);
          }

          $s7of7_win_loc_id = $objLottery->dbLotWinLocationGetId($win_location);
          if (!$s7of7_win_loc_id) {
            $s7of7_win_loc_id = $objLottery->dbLotWinLocationAdd("", "", $win_location, "", $objLottery->loc_cntry);
          }
          $s7of7_win_loc_detail[$s7of7_win_loc_id]["count"] = $s7of7_total_win_count;
          
          
        } else {
          
          $s7of7_total_win_prze_id = $s7of7_prze_id;
        }
        
        if ($debug_mode > 1) {
          print "[m7of7|" . $s7of7_total_win_amount . "|" . $s7of7_total_win_prze_id . "|" . $s7of7_total_win_count . "]";
        }
        
      } elseif (preg_match("/6\/7 \+ Bonus/i", $lmatches[1], $lot_m_)) {
        $s6of7B_total_win_amount = 0;
        $s6of7B_total_win_count  = $lmatches[2];
        $s6of7B_prze_amt         = str_replace($str_money_sym, "", trim($lmatches[3]));
        $s6of7B_win_loc_detail   = array();
        
        $s6of7B_prze_id          = $objLottery->dbLotteryWinPrizesGetId($s6of7B_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
        if (!$s6of7B_prze_id) {
          $s6of7B_prze_id        = $objLottery->dbLotteryWinPrizesAdd($s6of7B_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
        }
        //print "\n 6/7 Bonus: " . $s6of7B_total_win_count;
        if ($s6of7B_total_win_count > 0) {
          $s6of7B_total_win_amount = $s6of7B_total_win_count * $s6of7B_prze_amt;
          $s6of7B_total_win_prze_id = $objLottery->dbLotteryWinPrizesGetId($s6of7B_total_win_amount, $objLottery->prz_money, $naMax_row["gameid"]);
          if (!$s6of7B_total_win_prze_id) {
            $s6of7B_total_win_prze_id = $objLottery->dbLotteryWinPrizesAdd($s6of7B_total_win_amount, $objLottery->prz_money, number_format($s6of7B_total_win_amount, 2), $naMax_row["gameid"]);
          }

          $s6of7B_win_loc_id = $objLottery->dbLotWinLocationGetId($win_location);
          if (!$s6of7B_win_loc_id) {
            $s6of7B_win_loc_id = $objLottery->dbLotWinLocationAdd("", "", $win_location, "", $objLottery->loc_cntry);
          }
          $s6of7B_win_loc_detail[$s6of7B_win_loc_id]["count"] = $s6of7B_total_win_count;
          
        } else {
          
          $s6of7B_total_win_prze_id = $s6of7B_prze_id;
        }
        
        if ($debug_mode > 1) {
          print "[m6of7B|" . $s6of7B_total_win_amount . "|" . $s6of7B_total_win_prze_id . "|" . $s6of7B_total_win_count . "]";
        }
      } elseif (preg_match("/6\/7/i", $lmatches[1], $lot_m_)) {
        $s6of7_prze_amt         = str_replace($str_money_sym, "", trim($lmatches[3]));
        $s6of7_prze_id          = $objLottery->dbLotteryWinPrizesGetId($s6of7_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
        if (!$s6of7_prze_id) {
          $s6of7_prze_id        = $objLottery->dbLotteryWinPrizesAdd($s6of7_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
        }
        $s6of7_win_count        = trim($lmatches[2]);
        if ($debug_mode > 1) {
          print "[m6of7|]" . $s6of7_prze_amt . "|" . $s6of7_prze_id . "|" . $s6of7_win_count . "]";
        }
      } elseif (preg_match("/5\/7/i", $lmatches[1], $lot_m_)) {
        $s5of7_prze_amt         = str_replace($str_money_sym, "", trim($lmatches[3]));
        $s5of7_prze_id          = $objLottery->dbLotteryWinPrizesGetId($s5of7_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);        
        if (!$s5of7_prze_id) {
          $s5of7_prze_id        = $objLottery->dbLotteryWinPrizesAdd($s5of7_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
        }
        $s5of7_win_count        = trim($lmatches[2]);
        if ($debug_mode > 1) {
          print "[m5of7|" . $s5of7_prze_amt . "|" . $s5of7_prze_id . "|" . $s5of7_win_count . "]";
        }
      } elseif (preg_match("/4\/7/i", $lmatches[1], $lot_m_)) {
        $s4of7_prze_amt         = str_replace($str_money_sym, "", trim($lmatches[3]));
        $s4of7_prze_id          = $objLottery->dbLotteryWinPrizesGetId($s4of7_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);        
        if (!$s4of7_prze_id) {
          $s4of7_prze_id        = $objLottery->dbLotteryWinPrizesAdd($s4of7_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
        }
        $s4of7_win_count        = trim($lmatches[2]);
        if ($debug_mode > 1) {
          print "[m4of7|" . $s4of7_prze_amt . "|" . $s4of7_prze_id . "|" . $s4of7_win_count . "]";
        }
      } elseif (preg_match("/3\/7 \+ Bonus/i", $lmatches[1], $lot_m_)) {
        $s3of7B_prze_amt        = str_replace($str_money_sym, "", trim($lmatches[3]));
        $s3of7B_prze_id         = $objLottery->dbLotteryWinPrizesGetId($s3of7B_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);  
        if (!$s3of7B_prze_id) {
          $s3of7B_prze_id       = $objLottery->dbLotteryWinPrizesAdd($s3of7B_prze_amt, $objLottery->prz_money, trim($lmatches[3]), $naMax_row["gameid"]);
        }  
        $s3of7B_win_count        = trim($lmatches[2]);    
        if ($debug_mode > 1) {
          print "[m3of7B|" . $s3of7B_prze_amt . "|" . $s3of7B_prze_id . "|" . $s3of7B_win_count . "]";
        }
      } elseif (preg_match("/3\/7/i", $lmatches[1], $lot_m_)) {
        $s3of7_prze_amt         = str_replace($str_money_sym, "", trim($lmatches[3]));
        if ($s3of7_prze_amt == "FREE PLAY") {
          $s3of7_prze_amt = 5;
          $s3of7_prze_amt_free_play = "FREE PLAY";
        }
        $s3of7_prze_id          = $objLottery->dbLotteryWinPrizesGetId($s3of7_prze_amt, $objLottery->prz_other, $naMax_row["gameid"]);        
        if (!$s3of7_prze_id) {
          $s3of7_prze_id        = $objLottery->dbLotteryWinPrizesAdd($s3of7_prze_amt, $objLottery->prz_other, trim($lmatches[3]), $naMax_row["gameid"]);
        }
        $s3of7_win_count        = trim($lmatches[2]);
        
        if ($debug_mode > 1) {
          print "[m3of7|" . $s3of7_prze_amt_free_play . "|" . $s3of7_prze_amt . "|" . $s3of7_prze_id . "|" . $s3of7_win_count . "]";
        }
        $naMaxId = $naLottery->naMaxGetDrawID(date('Y-m-d', $drawdate));
        //print "\nMaxId: "  . $naMaxId . " Date: " . date('Y-m-d', $drawdate);
        if ($debug_mode > 1) {
          print "[" . $naMaxId . "]";
        }
        if ($naMaxId != null) {
              $naMaxWinningId = $naLottery->naMaxWinningsGetId($naMaxId);
              //print "\n naMaxWinningId: " . $naMaxWinningId;
              if ($naMaxWinningId == null) {
                  $naMaxWinningId = $naLottery->naMaxWinningsAdd($naMaxId, $s7of7_total_win_count, $s7of7_total_win_prze_id, 
                                                                         $s6of7B_total_win_count, $s6of7B_total_win_prze_id,
                                                                         $s6of7_win_count, $s6of7_win_prz_id,
                                                                         $s5of7_win_count, $s5of7_win_prz_id,
                                                                         $s4of7_win_count, $s4of7_win_prz_id,
                                                                         $s3of7B_win_count, $s3of7B_win_prz_id,
                                                                         $s3of7_win_count, $s3of7_win_prz_id, 0);
                  //print "\n naMaxWinningId : " . $naMaxWinningId . " - naMaxId: " . $naMaxId . " Date: " . date('Y-m-d', $drawdate);
                  if ($naMaxWinningId != null) {
                      if (is_array($s7of7_win_loc_detail)) {
                        foreach ($s7of7_win_loc_detail as $win_loc_id => $win_loc) {
                            $naLottery->dbNaMaxWinLocAdd($naMaxWinningId, $s7of7_win_prze_id, $win_loc["count"], $win_loc_id, 7);
                          }
                      }
                      if (is_array($s6of7B_win_loc_detail)) {
                         foreach ($s6of7B_win_loc_detail as $win_loc_id => $win_loc) {
                            $naLottery->dbNaMaxWinLocAdd($naMaxWinningId, $s6of7B_win_prze_id, $win_loc["count"], $win_loc_id, 7);
                          }
                      }
                    }        
             
              }
          if ($debug_mode > 1) {
            print "[" . $naMaxWinningId . "]";
          } 
        }

        
        
      }
      
    } elseif ($b_Max_Mill_m == 1 &&
            (preg_match("/" . $sMax_Mill_th . "/i", $html_tr, $lmatches))) {
      //print_r($lmatches);
                
    }  
    elseif ($b_Max_Mill_m == 1 &&
            (preg_match("/" . $sMax_Mill_td . "/i", $html_tr, $lmatches))) {
       //print_r($lmatches);
        $snum1      = $lmatches[1];
        $snum2      = $lmatches[2];
        $snum3      = $lmatches[3];
        $snum4      = $lmatches[4];
        $snum5      = $lmatches[5];
        $snum6      = $lmatches[6];
        $snum7      = $lmatches[7];
        if ($debug_mode > 1) {
          print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6 . "|" . $snum7 . "]";
        }
        
        
        $snumBonus  = 0;       
        $sMaxMill_win_cnt          = trim($lmatches[8]);
        $sMaxMill_prze_amt     = str_replace($str_money_sym, "", trim($lmatches[9]));
        $sMaxMill_id           = $naLottery->naMaxGetDrawIdByNum(date('Y-m-d',$drawdate), $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumBonus);
        if ($sMaxMill_id != null) {
          $sMaxMill_prze_id          = $objLottery->dbLotteryWinPrizesGetId($sMaxMill_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);        
        
          if (!$sMaxMill_prze_id) {
            $sMaxMill_prze_id        = $objLottery->dbLotteryWinPrizesAdd($sMaxMill_prze_amt, $objLottery->prz_money, trim($lmatches[9]), $naMax_row["gameid"]);
          }
          $sMaxMill_win_loc_detail = array();
          $sMaxMill_total_win_count = $sMaxMill_win_cnt;
          $sMaxMill_total_prze_amt = $sMaxMill_total_win_count * $smaxMill_prze_amt;

          $win_location = "Canada";
          
          $sMaxMill_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($sMaxMill_total_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
          if (!$sMaxMill_total_win_prz_id) {
            $sMaxMill_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($sMaxMill_total_prze_amt, $objLottery->prz_money, trim($lmatches[9]), $naMax_row["gameid"]);
          }
          $sMaxMill_win_loc_id = $objLottery->dbLotWinLocationGetId($win_location);
          if (!$sMaxMill_win_loc_id) {
            $sMaxMill_win_loc_id = $objLottery->dbLotWinLocationAdd("", "", $win_location, "", $objLottery->loc_cntry);
          }
          $sMaxMill_win_loc_detail[$sMaxMill_win_loc_id]["count"] = $sMaxMill_total_win_count;  
          $sMaxMillWinningId = $naLottery->naMaxWinningsGetId($sMaxMill_id);
          if (!$sMaxMillWinningId) {
            
            $sMaxMillWinningId = $naLottery->naMaxWinningsAdd($sMaxMill_id, $sMaxMill_total_win_count, 
                                                              $sMaxMill_total_win_prz_id, 0, 0,0,0,0,
                                                              0,0,0,0,0,0,0,0);
          }
          if ($sMaxMillWinningId != null) {
            if (is_array($sMaxMill_win_loc_detail)) {
              foreach ($sMaxMill_win_loc_detail as $win_loc_id => $win_loc) {
                $naLottery->dbNaMaxWinLocAdd($sMaxMillWinningId, $sMaxMill_prze_id, $win_loc["count"], $win_loc_id, 7);
              }
            }
          }
          if ($debug_mode > 1) {
            print "[" . $sMaxMill_prze_amt  . "|"  . $sMaxMill_prze_id . "|" . $sMaxMill_total_win_count . "]";
          }
        }
    } elseif ($b_On_Max_Mill_m == 1 &&
            (preg_match("/" . $sMax_Mill_th  . "/i", $html_tr, $lmatches))) {
        //print_r($lmatches);
    
    } elseif ($b_On_Max_Mill_m == 1 &&
            (preg_match("/" . $sMax_Mill_td . "/i", $html_tr, $lmatches))) {
       //print_r($lmatches);
        $snum1      = $lmatches[1];
        $snum2      = $lmatches[2];
        $snum3      = $lmatches[3];
        $snum4      = $lmatches[4];
        $snum5      = $lmatches[5];
        $snum6      = $lmatches[6];
        $snum7      = $lmatches[7];
        
        if ($debug_mode > 1) {
          print "[" . $snum1 . "|" . $snum2 . "|" . $snum3 . "|" . $snum4 . "|" . $snum5 . "|" . $snum6 . "|" . $snum7 . "]";
        }
        
        $snumBonus  = 0;       
        $sMaxMill_win_cnt          = trim($lmatches[8]);
        $sMaxMill_prze_amt     = str_replace($str_money_sym, "", trim($lmatches[9]));
        $sMaxMill_id           = $naLottery->naMaxGetDrawIdByNum(date('Y-m-d',$drawdate), $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snumBonus);
        if ($sMaxMill_id != null) {
          $sMaxMill_prze_id          = $objLottery->dbLotteryWinPrizesGetId($sMaxMill_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);        
        
          if (!$sMaxMill_prze_id) {
            $sMaxMill_prze_id        = $objLottery->dbLotteryWinPrizesAdd($sMaxMill_prze_amt, $objLottery->prz_money, trim($lmatches[9]), $naMax_row["gameid"]);
          }
          $sMaxMill_win_loc_detail = array();
          $sMaxMill_total_win_count = $sMaxMill_win_cnt;
          $sMaxMill_total_prze_amt = $sMaxMill_total_win_count * $smaxMill_prze_amt;

          $win_location = "Canada";
          
          $sMaxMill_total_win_prz_id = $objLottery->dbLotteryWinPrizesGetId($sMaxMill_total_prze_amt, $objLottery->prz_money, $naMax_row["gameid"]);
          if (!$sMaxMill_total_win_prz_id) {
            $sMaxMill_total_win_prz_id = $objLottery->dbLotteryWinPrizesAdd($sMaxMill_total_prze_amt, $objLottery->prz_money, trim($lmatches[9]), $naMax_row["gameid"]);
          }
          $sMaxMill_win_loc_id = $objLottery->dbLotWinLocationGetId($win_location, $objLottery->loc_cntry);
          if (!$sMaxMill_win_loc_id) {
            $sMaxMill_win_loc_id = $objLottery->dbLotWinLocationAdd("", "", $win_location, "", $objLottery->loc_cntry);
          }
          $sMaxMill_win_loc_detail[$sMaxMill_win_loc_id]["count"] = $sMaxMill_total_win_count;  
          $sMaxMillWinningId = $naLottery->naMaxWinningsGetId($sMaxMill_id);
          if (!$sMaxMillWinningId) {
            
            $sMaxMillWinningId = $naLottery->naMaxWinningsAdd($sMaxMill_id, $sMaxMill_total_win_count, 
                                                              $sMaxMill_total_win_prz_id, 0, 0,0,0,0,
                                                              0,0,0,0,0,0,0,0);
          }
          if ($sMaxMillWinningId != null) {
            if (is_array($sMaxMill_win_loc_detail)) {
              foreach ($sMaxMill_win_loc_detail as $win_loc_id => $win_loc) {
                $naLottery->dbNaMaxWinLocAdd($sMaxMillWinningId, $sMaxMill_prze_id, $win_loc["count"], $win_loc_id, 7);
              }
            }
          }
        }
        if ($debug_mode > 1) {
          print "[" . $sMaxMill_prze_amt  . "|"  . $sMaxMill_prze_id . "|" . $sMaxMill_total_win_count . "]";
        }
    } elseif ($b_encore_m == 1 &&
            (preg_match("/" . $sEncore_th_Line . "/i", $html_tr, $lmatches))) {
      //print_r($lmatches);          
      
          $arEncore_th = array();    
          $inEncore_th = 0;  
    } elseif ($b_encore_m == 1 &&
            (preg_match("/" . $sEncore_td_Line . "/i", $html_tr, $lmatches))) {
      //print_r($lmatches);          
           $arEncore_th[$inEncore_th] = $lmatches;
           $inEncore_th++;
        // print_r($lmatches); 
    
    } elseif (preg_match("/" . $s_MaxMillWinningHdr . "/i", $html_tr, $lmatches)) {
      $b_Max_m          = 0;
      $b_Max_Mill_m     = 1;
      $b_On_Max_Mill_m  = 0;
      $b_encore_m       = 0;
      //print_r($lmatches);
          
    } elseif (preg_match("/" . $s_OnMaxBonusWinningHdr . "/i", $html_tr, $lmatches)) {
      $b_Max_m          = 0;
      $b_Max_Mill_m     = 0;
      $b_On_Max_Mill_m  = 1;
      $b_encore_m       = 0;
      //print_r($lmatches);
    } elseif (preg_match("/" . $s_encoreWinningHdr . "/i", $html_tr, $lmatches)) {
      $b_Max_m          = 0;
      $b_Max_Mill_m     = 0;
      $b_On_Max_Mill_m  = 0;
      $b_encore_m       = 1;
      //print_r($lmatches);
    }
  }  
  
  if (is_array($arEncore_th)) {
      $OLGData = new OLGData();
      $OLGData->OLGEncoreParse($arEncore_th, strtotime($sdrawdate), $debug_mode);
    }
}


