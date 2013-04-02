
<?php


  include_once("./class_db.php");
  class parseOLGLottery {
    
    /*
     * 
     * Ontario 49
     * 
     */
    
    
    /*
     * 
     * Ontario Keno
     * 
     */
     /*
      * DrawStartDate
      * DrawEndDate
      * MonthYear
      * 
      * 
      */ 
    
    function parseOLGKenoNums($month, $year, $startDate = "", $endDate = "") {
      
        $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
        $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
        $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
        
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
        $onKenoGameId   = 9;
        
        $http->postvars['selectedMonthYear']  = "012010";
        $http->postvars['day']                = 0;   // All Days
        $http->postvars['gameID']             = $onKenoGameId;
        $http->postvars['command']            = 'submit';
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
        
        $spattern =  $srgB_th . "\s*(DATE)\s*" . $srgE_th;
        $spattern .= "\s*" . $srgB_th . "\s*(DAY)\s*" . $srgE_th;
        $spattern .= "\s*" . $srgB_th . "\s*(NUMBERS)\s*" ;
        $spattern .= "\s*" . $srgB_th . "\s*(ENCORE)\s*" . $srgE_th;
        $spattern .= "\s*" . $srgB_th . "\s*(WINNINGS)\s*" . $srgE_th . "\s*" . $srgE_tr;
        
        $srgDays    = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
        $srgMonths  = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
        
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
        foreach ($html_tr_list as $html_tr) {
          if (preg_match("/" . $spattern . "/i", $html_tr, $lmatches)) {
            $bKeno_m = 1;
            print_r($lmatches);
          } elseif ($bKeno_m == 1 && 
           (preg_match("/" . $skenoLinePattern . "/i", $html_tr, $lmatches))) {
            print_r($lmatches);   
            
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\d{2})-(\w{3})-(\d{4})\s*" . $srgE_strong . $srgE_p . "/i", $lmatches[1], $lotResMat)) {
              print_r($lotResMat);      
            }
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . "\s*(\w{3})\s*" . $srgE_strong. $srgE_p . "/i",$lmatches[2], $lotResMat)) {
              print_r($lotResMat);
            }
            //print "<br />" . $srg_onKeno . "<br />";
            $sKenoRes = preg_replace("/<[^>]*>|\s{2}/i", " ", $lmatches[3]);
            //print_r($sKenoRes);
            if (preg_match("/" . $srg_onKeno . "/i", $sKenoRes, $lotResMat)) {
              print_r($lotResMat);
            }
            if (preg_match("/\s*" . $srgB_p . $srgB_strong . $srg_onEncore . $srgE_strong . $srgE_p . "/i", $lmatches[4], $lotResMat)) {
              print_r($lotResMat);
            }
            if (preg_match("/\s*([a-zA-Z.+\/?=]*)\s*/i", $lmatches[5], $lotResMat)) {
              print_r($lotResMat);
            }    
            if (preg_match("/\s*" . $srg_gameid . "\s*" . $srg_drawNo . "\s*" . $srg_drawDate . "\s*" . $srg_spielId . "\s*<input[^>]*>" . "/i", $lmatches[6], $lotResMat)) {
              print_r($lotResMat);    
              
            }
          }
        
        }
              
    }

    function parseOLGSingleKenoDraw() {
      
    }
    
    /*
     * 
     * Lottario
     * 
     * 
     */
  
  /*
   * Pick3
   * 
   * 
   */
  
   /*
    * Pick 4
    * 
    */ 
        
    
    /*
     * Poker
     * 
     */
    /*
     * 
     * Payday
     * 
     */
     
    /*
     * Encore 
     * 
     */
     
    
  }

?>