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
  
  
  fwrite(STDOUT, "\tEnter one of the options Below: \n\n\n");
  fwrite(STDOUT, "\n\tgetPage: [\d] -- gets selected page");
  fwrite(STDOUT, "\n\tgetPage: [\d] - [\d] -- gets pages [\d] to [\d]");
  fwrite(STDOUT, "\n\tgetAllPages -- gets all the pages");
  fwrite(STDOUT, "\t[dd-mm-yyyy] - [dd-mm-yyyy]");
  fwrite(STDOUT, "\n\t\n\t: ");
  
  $objLottery = new Lottery();
  
  
  do {
    
    do {
      $selection = trim(fgets(STDIN));
    } while (trim($selection) == '');
    $ar_pages = null;
    if (preg_match("/getPage[:]? (\d*)/i", $selection, $opt_select_)) {
      $ar_pages = array(
              0 => $opt_select_[1]);  
      
    } elseif (preg_match("/getPage[:]? (\d*) - (\d*)/i", $selection, $opt_select_)) {
      $ar_pages = array();  
      for ($y = 1, $i = $opt_select_[1]; $i < $opt_select_[1]; $y++,$i++ ) {
        $ar_pages[$y] = $i;
      }
    } elseif (preg_match("/getAllPages/i", $selection, $opt_select_)) {
      $ar_pages = null;
      // call the fetch function here so it don't unnescessarily loop
      on_fetch_first_step_locations($ar_pages);
      
    }
      
    print_r($ar_pages);
    if (is_array($ar_pages)) {
      on_fetch_first_step_locations($ar_pages);
    }  
  } while (trim($selection) != 'q');
  
  
  function on_fetch_first_step_locations($ar_pages = "") {
      $url1 = "http://dart.olg.ca/";
      
      
      $objLottery       = new Lottery();
      $objDate          = new GenDates();
      $objOLG           = new OLGLottery();
      $naLottery        = new NALottery();
      $onLocation_row   = $objLottery->dbLotteryGamesGet("olgWinLocations");
      
      
      
        
        if (!$http = new http()) {
          $status_msg = "...";
        }
        
        $http->headers['Referer'] = $url1;
        if (!$http->fetch($url1)) {
          $status_msg = "... ";
          
        }
        
        $ary_headers = split("\n", $http->header);
        $asp_sessionid = "";
        print_r($ary_headers);
        foreach($ary_headers as $hdr) {
            if (eregi("^Set-Cookie\:", $hdr)) {
                $hdr = str_replace("Set-Cookie: ", "", $hdr);
                
                $ary_cookies = split(";", $hdr);
                foreach ($ary_cookies as $ckie) {
                  if (preg_match("/ASP\.NET_SessionId/i",$ckie, $lmatches)) {
                    $asp_sessionid = $ckie;
                    print "\n SessID: " . $asp_sessionid;
                  }
                }
        
                break;
            }
        
        
        }
        $nd_time = (int)$objDate->microtime_float() * 1000;
        $url2 = "http://dart.olg.ca/_partnerpages/olglo/wtt_xhr.aspx?";
        $url2 .= "region=&postal=&";
        $url2 .= "nd=" . $nd_time;
        $url2 .= "&_search=false&rows=20";
        $url2 .= "&page=1&sidx=&sord=asc";
        $http->headers['Cookie'] = $asp_sessionid; 
        $http->headers['X-Requested-With'] = "XMLHttpRequest";
        $http->headers['Referer'] = $url1;
        if (!$http->fetch($url2)) {
          
        }
        
        
        /*print "\n" . $url1;
        print "\n" . mktime() * 1111;
        print "\n Time stamp: " . time();
        print "\n microtime : " . microtime();
        for ($i = 0; $i < 25000; $i = $i + 1) {
          if (($i % 500) == 0 ) {
            print "\n Time stamp: " . time();
            print "\n microtime : " . microtime();
            print "\n microtime fl: " . microtime_float();
            print "\n microtime fl: " . microtime_float() * 1000;
          }
        }
         */ 
        print "\n";
        print "nd: " . $nd_time;
        print "\n" . $url2;
        print_r($ary_headers);
        $ary_headers = split("\n", $http->header);
        $asp_sessionid = "";
        print_r($ary_headers);
        
        $win_locations_xml_result = $http->body;
        //print_r($http->body);
     
      
      $xml_win_loc = simplexml_load_string($win_locations_xml_result);
      $drawdate  = date('Y-m-d');
      $drawdate = strtotime($drawdate);
      print "\nPage: " . $xml_win_loc->page;
      print "\ntotal: " . $xml_win_loc->total;
      print "\nrecords: " . $xml_win_loc->records;
    
      if ($ar_pages == "" || $ar_pages == null) {
        $ar_pages = array();  
        for ($x = 1; $x <= $xml_win_loc->total; $x++) {
          $ar_pages[$x] = $x;
        }
      }
      if (is_array($ar_pages)) {
        foreach ($ar_pages as $curPage) {
          if ($curPage == 1) {
            on_fetch_second_step_locations($curPage, $win_locations_xml_result);
          } else {
            if ($curPage <= $xml_win_loc->total) {
                $nd_time = (int)$objDate->microtime_float() * 1000;
                $url2 = "http://dart.olg.ca/_partnerpages/olglo/wtt_xhr.aspx?";
                $url2 .= "region=&postal=&";
                $url2 .= "nd=" . $nd_time;
                $url2 .= "&_search=false&rows=20";
                $url2 .= "&page=" . $curPage;
                $url2 .= "&sidx=&sord=asc";
                $http->headers['Cookie'] = $asp_sessionid; 
                $http->headers['X-Requested-With'] = "XMLHttpRequest";
                $http->headers['Referer'] = $url1;
                if (!$http->fetch($url2)) {
                  
                }
                $win_locations_xml_result = $http->body;
                on_fetch_second_step_locations($curPage, $win_locations_xml_result);
            } 
         }
          
          
          
          // Store Fetching History
          

          if (preg_match("/http:\/\/([^\/]*)(.*)\/(.*?)\?(.*)/i", $url2, $lmatches) ) {
              print_r($lmatches);
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

              $fetch_stats_id = $objLottery->dbFetchDataStatsGetId("olgWinLocations", $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id);
              if (!$fetch_stats_id) {
                $fetch_date = date('Y-m-d H:i:s');
                $fetch_pos = 0;
                $fetch_process_suc = 0;
                //print_r($na649_row);
                // $s_web_domain, $s_web_path, $s_web_file, $s_web_query
                $fetch_stats_id = $objLottery->dbFetchDataStatsAdd("olgWinLocations", $onLocation_row["gameid"], date('Y-m-d',$drawdate), $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id, $fetch_date, 1, "");
                $objLottery->dbFetchDetailAdd($fetch_stats_id, $fetch_date, $fetch_pos, $fetch_process_suc);
               } else {
                $fetch_data_stats_row = $objLottery->dbFetchDataStatsGet("olgWinLocations", $site_domain_id, $site_path_id, $site_file_id, $site_querystr_id);
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
        }
      }
      
  
      
  }

  function on_fetch_second_step_locations($pageNum, $win_locations_fetch_result = "") {
          
          
      $url1 = "http://dart.olg.ca/";
      
      
      $objLottery       = new Lottery();
      $objDate          = new GenDates();
      $objOLG           = new OLGLottery();
      $naLottery        = new NALottery();
      $onLocation_row   = $objLottery->dbLotteryGamesGet("olgWinLocations");
      
      
      if (!$win_locations_fetch_result) {
        
        if (!$http = new http()) {
          $status_msg = "...";
        }
        
        $http->headers['Referer'] = $url1;
        if (!$http->fetch($url1)) {
          $status_msg = "... ";
          
        }
        
        $ary_headers = split("\n", $http->header);
        $asp_sessionid = "";
        print_r($ary_headers);
        foreach($ary_headers as $hdr) {
            if (eregi("^Set-Cookie\:", $hdr)) {
                $hdr = str_replace("Set-Cookie: ", "", $hdr);
                
                $ary_cookies = split(";", $hdr);
                foreach ($ary_cookies as $ckie) {
                  if (preg_match("/ASP\.NET_SessionId/i",$ckie, $lmatches)) {
                    $asp_sessionid = $ckie;
                    print "\n SessID: " . $asp_sessionid;
                  }
                }
        
                break;
            }
        
        
        }
        $nd_time = (int)$objDate->microtime_float() * 1000;
        $url2 = "http://dart.olg.ca/_partnerpages/olglo/wtt_xhr.aspx?";
        $url2 .= "region=&postal=&";
        $url2 .= "nd=" . $nd_time;
        $url2 .= "&_search=false&rows=20";
        $url2 .= "&page=1&sidx=&sord=asc";
        $http->headers['Cookie'] = $asp_sessionid; 
        $http->headers['X-Requested-With'] = "XMLHttpRequest";
        $http->headers['Referer'] = $url1;
        if (!$http->fetch($url2)) {
          
        }
        
        
        /*print "\n" . $url1;
        print "\n" . mktime() * 1111;
        print "\n Time stamp: " . time();
        print "\n microtime : " . microtime();
        for ($i = 0; $i < 25000; $i = $i + 1) {
          if (($i % 500) == 0 ) {
            print "\n Time stamp: " . time();
            print "\n microtime : " . microtime();
            print "\n microtime fl: " . microtime_float();
            print "\n microtime fl: " . microtime_float() * 1000;
          }
        }
         */ 
        print "\n";
        print "nd: " . $nd_time;
        print "\n" . $url2;
        print_r($ary_headers);
        $ary_headers = split("\n", $http->header);
        $asp_sessionid = "";
        print_r($ary_headers);
        
        $win_locations_xml_result = $http->body;
        //print_r($http->body);
      } else {
        $win_locations_xml_result = $win_locations_fetch_result;
      }       
      
      $xml_win_loc = simplexml_load_string($win_locations_xml_result);
      
      print "\nPage: " . $xml_win_loc->page;
      print "\ntotal: " . $xml_win_loc->total;
      print "\nrecords: " . $xml_win_loc->records;
      
      $str_money_sym = array("$",","); 
      $str_num_sym = array("$", ",", "-");
      
      foreach ($xml_win_loc->row as $xml_win_row) {
        //print_r($xml_win_row);
      //  print "\nRowID: " . $xml_win_row->id;
        print "\n";
        print "\nID:          " . $xml_win_row->cell[0];
        print "\nStore Name:  " . $xml_win_row->cell[1];
        $winning_row_id     = $xml_win_row->cell[0];
        $winning_store_name = trim($xml_win_row->cell[1]);
        
        if (preg_match("/(.*)?(\w\d\w-\d\w\d) (.*)/i", $xml_win_row->cell[2], $lot_mat_)) {
          print_r($lot_mat_);
          $streetAddr     = trim($lot_mat_[1]);
          $postalCode     = trim($lot_mat_[2]);
          $strCity        = trim($lot_mat_[3]);
          $iCityId        = $objLottery->dbLotWinLocationGetId($strCity, $objLottery->loc_city);
          if (!$iCityId) {
            $iCityId      = $objLottery->dbLotWinLocationAdd($strCity, "", "", "", $objLottery->loc_city); 
          }
          $strProv        = "Ontario";
          $iProvId        = $objLottery->dbLotWinLocationGetId($strProv, $objLottery->loc_prov);
          if (!$iProvId) {
            $iProvId      = $objLottery->dbLotWinLocationAdd("", $strProv, "", "", $objLottery->loc_prov);
          }
        }
        print "\nAddr:      " . $xml_win_row->cell[2];
        
        print "\nGame:      " . $xml_win_row->cell[3];
        $strGameDesc      = trim($xml_win_row->cell[3]);
        $iLotGameId = $objLottery->dbLotteryGamesGetIdByDesc($strGameDesc);
        if (!$iLotGameId) {
          $iLotGameId = $objLottery->dbLotteryGamesShortAdd($strGameDesc, $strGameDesc, "on", "", "");
        }
        print "\nDate  :    " . $xml_win_row->cell[4];
        $strDrawDate  = "";
        $iInstGameNo  = null;
        $sGameInstant = "";
        if (preg_match("/(\w{3}) (\d*), (\d{4})/i", $xml_win_row->cell[4], $lot_mat_)) {
            print_r($lot_mat_);
            $sdrawMonthName = trim($lot_mat_[1]);
            $sdrawMonthNum  = $objDate->getShortMonthNum($sdrawMonthName);
            $sdrawDay       = $lot_mat_[2];
            $sdrawYear      = $lot_mat_[3];
            $strDrawDate    = $sdrawYear . "-" . $sdrawMonthNum . "-" . $sdrawDay;
            $strDrawDate    = strtotime($strDrawDate);
            $strDrawDate    = date('Y-m-d', $strDrawDate);
        } elseif (preg_match("/(\d*-\d*)/i", $xml_win_row->cell[4], $lot_mat_)) {
          $sGameInstant          = $lot_mat_[1];
        } elseif (preg_match("/(\d*)/i", $xml_win_row->cell[4], $lot_mat_)) {
          $iInstGameNo          = $lot_mat_[1];  
        } else {  
          $sGameInstant = trim($xml_win_row->cell[4]);
        }
        if (!$iInstGameNo ) {
          $iInstGameNo = str_replace($str_num_sym,"", $sGameInstant);
        }
        print "\nAmount:    " . $xml_win_row->cell[5];  
        print "\nInst: " . $iInstGameNo;
        $sWinAmt = str_replace($str_money_sym, "", trim($xml_win_row->cell[5])); 
        $iWinAmtId  = $objLottery->dbLotteryWinPrizesGetId($sWinAmt, $objLottery->prz_money, $onLocation_row["gameid"]);
        if (!$iWinAmtId) {
          $iWinAmtId = $objLottery->dbLotteryWinPrizesAdd($sWinAmt, $objLottery->prz_money, trim($xml_win_row->cell[5]), $onLocation_row["gameid"]);
        }
        
        $iWinLocId = $objOLG->dbOnWinningLocationGetId($streetAddr, $iLotGameId, $strDrawDate, $iInstGameNo, $sGameInstant);
        if (!$iWinLocId) {
          $iWinLocId = $objOLG->dbOnWinningLocationAdd($winning_row_id, $winning_store_name, $streetAddr, $iLotGameId, $strDrawDate, 
              $iWinAmtId, $postalCode, $iCityId, $iInstGameNo, $sGameInstant, $iProvId);
        
        
        }
     }  
          
  }
  
  ?>