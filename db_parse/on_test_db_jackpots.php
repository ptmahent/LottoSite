<?php

  include_once("../inc/cli_compatibility.php");
  include_once("../inc/class_http.php");
  include_once("../inc/class_db.php");
  include_once("../inc/incLottery.php");
  include_once("../inc/incGenDates.php");
  include_once("../inc/incJackpot.php");
  include_once("phpArguments.php");
  
  // Debug Mode
  // 0 = verbose disabled
  // 1 = verbose enabled
  // 2 = verbose extra info
  // 3 = Extra debug info
  
  $debug_mode         = 2;
  
  $objLottery = new Lottery();

  
  $cmdargs = arguments();
  
  print_r($cmdargs);
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^update/i", $cmdargs["standard"][1], $lmatches)) {
		OLG_Parse_Jackpots();
  		
  	}
  }



function OLG_Parse_Jackpots() {

	global $objLottery;
	
	$url_step1 = "http://www.olg.ca/index.jsp";

    if (!$http = new http()) {
        $status_msg = "...";
    }
    $http->headers['Referer'] = $url_step1;

   if (!$http->fetch($url_step1)) {
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
    $srgB_div  = "<div[^>]*>";
    $srgE_div  = "<\/div>";
    
    $srg_comment = "<!--.*-->";
	
	//print_r($html_body);
    $str_money_sym = array("$",","); 	
	//$html_tr_list = preg_split("/" . $srgB_div . "/i", $html_body);
	
	
	$naMax_row             		= $objLottery->dbLotteryGamesGet("naMAX");
	$na649_row             		= $objLottery->dbLotteryGamesGet("na649");
	$onLottario_row             = $objLottery->dbLotteryGamesGet("onLottario");
	
	$srgB_jackpot = " JACKPOT DISPLAY START ================== -->";
	$srgE_jackpot = " JACKPOT DISPLAY END ================= -->";
	
	
	
	
	$srg_alt_Max_Jackpot		= "lottoMax_small\.png.*alt=\"LOTTO MAX";
	$srg_Max_Jackpot 			= "<strong>([^<]*)<\/strong>[^<]*<br \/>[^<]*<strong>([^<]*)<\/strong>";
	$srg_Max_m					= 0;
	
	$srg_Max_W_mill_Jackpot 	= "";
	
	$srg_alt_649_Jackpot		= "lotto649_small.png.*alt=\"LOTTO 6\/49\"";
	$srg_649_Jackpot 			= "<strong>([^<]*)<\/strong>[^<]*<br \/>[^<]*<strong>([^<]*)<\/strong>";
	$srg_649_m					= 0;
	
	$srg_alt_Lottario_Jackpot	= "lottoLottario_small.png.*alt=\"LOTTARIO\"";
	$srg_Lottario_Jackpot 		= "<strong>([^<]*)<\/strong>[^<]*<br \/>[^<]*<strong>([^<]*)<\/strong>";
	$srg_Lottario_m				= 0;
	
	//print_r($html_body);
	//print "\n\n\n" .  $srgB_jackpot . "(.*)" . $srgE_jackpot ;
	if (preg_match("/" . $srgB_jackpot . "(.*)" . $srgE_jackpot . "/i", $html_body, $lmatches)) {
		$html_jackpot = $lmatches[1];		
		//print "\n\n\n" . $html_jackpot;
	}
	

	$jackpot_detail_ar = array();
	$html_div_list = preg_split("/" . $srgB_div . "/i", $html_jackpot);
	//print_r($html_div_list);
	foreach ($html_div_list as $html_div) {
		print_r($html_div);
		if ($srg_Max_m == 1 && (preg_match("/" . $srg_Max_Jackpot  . "/i", $html_div, $html_mats))) {
			print_r($html_mats);
			$jackpot_detail_ar["naMAX"] = array();
			$jackpot_detail_ar["naMAX"]["jackpot_drawdate"] 			= $html_mats[1] . " " . date('Y');
			$jackpot_detail_ar["naMAX"]["jackpot_amount"]				= str_replace($str_money_sym, "", $html_mats[2]);
			print_r($jackpot_detail_ar["naMAX"]);
		} elseif ($srg_649_m == 1 && (preg_match("/" . $srg_649_Jackpot  . "/i", $html_div, $html_mats))) {
			print_r($html_mats);
			$jackpot_detail_ar["na649"] = array();
			$jackpot_detail_ar["na649"]["jackpot_drawdate"] 			= $html_mats[1] . " " . date('Y');
			$jackpot_detail_ar["na649"]["jackpot_amount"]				= str_replace($str_money_sym, "", $html_mats[2]);
			print_r($jackpot_detail_ar["na649"]);
		} elseif ($srg_Lottario_m == 1 && (preg_match("/" . $srg_Lottario_Jackpot  . "/i", $html_div, $html_mats))) {
			print_r($html_mats);
			$jackpot_detail_ar["onLottario"] = array();
			$jackpot_detail_ar["onLottario"]["jackpot_drawdate"] 		= $html_mats[1] . " " . date('Y');
			$jackpot_detail_ar["onLottario"]["jackpot_amount"]			= str_replace($str_money_sym, "", $html_mats[2]);
			print_r($jackpot_detail_ar["onLottario"] );
		
		} elseif (preg_match("/" . $srg_alt_Max_Jackpot . "/i", $html_div, $html_mats)) {
			print_r($html_mats);
			$srg_Max_m = 1;
			$srg_649_m = 0;
			$srg_Lottario_m	= 0;
		} elseif (preg_match("/" . $srg_alt_649_Jackpot . "/i", $html_div, $html_mats)) {
			print_r($html_mats);
			$srg_Max_m = 0;
			$srg_649_m = 1;
			$srg_Lottario_m	= 0;
		} elseif (preg_match("/" . $srg_alt_Lottario_Jackpot . "/i", $html_div, $html_mats)) {
			print_r($html_mats);
			$srg_Max_m = 0;
			$srg_649_m = 0;
			$srg_Lottario_m	= 1;
		}
	
	}
	
	
	$obj_jackpot = new LottoJackpot();
	
	// Lotto Max
		if (is_array($jackpot_detail_ar["naMAX"])) {
			$max_drawdate = date('Y-m-d', strtotime($jackpot_detail_ar["naMAX"]["jackpot_drawdate"]));
			$max_jackpot_id = $obj_jackpot->Jackpot_getid($max_drawdate, $naMax_row["gameid"]);
			if (!$max_jackpot_id) {
				$obj_jackpot->Jackpot_add($max_drawdate, $naMax_row["gameid"], "", $jackpot_detail_ar["naMAX"]["jackpot_amount"], "", "", ""); 
			}
		}
	
	// 649
		if (is_array($jackpot_detail_ar["na649"])) {
			$na649_drawdate = date('Y-m-d',  strtotime($jackpot_detail_ar["na649"]["jackpot_drawdate"]));
			$na649_jackpot_id = $obj_jackpot->Jackpot_getid($na649_drawdate, $na649_row["gameid"]);
			if (!$na649_jackpot_id) {
				$obj_jackpot->Jackpot_add($na649_drawdate, $na649_row["gameid"], "", $jackpot_detail_ar["na649"]["jackpot_amount"], "", "", "");
			}
			
		}

	// Lottario
		if (is_array($jackpot_detail_ar["onLottario"])) {
			$onLottario_drawdate = date('Y-m-d',  strtotime($jackpot_detail_ar["onLottario"]["jackpot_drawdate"]));
			$onLottario_jackpot_id = $obj_jackpot->Jackpot_getid($onLottario_drawdate, $onLottario_row["gameid"]);
			if (!$onLottario_jackpot_id) {
				$obj_jackpot->Jackpot_add($onLottario_drawdate, $onLottario_row["gameid"], "", $jackpot_detail_ar["onLottario"]["jackpot_amount"], "", "", "");
			}
			
		
		}
	

	


/*


<!--======= LOTTO JACKPOTS =====================-->
					
				<!-- === JACKPOT DISPLAY START ================== -->
				
				
				

				<!-- ===== JACKPOT WITHOUT MAX MILLION ===== -->
				<div id="mainBodyJackpot1">
					<!--== LOTTO MAX ==-->
					<div class="mainBodyJackpotBig">
						<div class="mainBodyJackpotLogoBig">
							<a href="/lotteries/games/howtoplay.do?game=lottomax"><img src="/assets/home/2009/lottoMax_small.png" width="80" height="42" alt="LOTTO MAX" border="0" /></a>
						</div>
						
                         
						<div class="mainBodyJackpotEstBig">
							<strong>Fri,  Oct 21</strong><br />
							<strong>$20,000,000</strong>&nbsp;<span style="font-weight:normal; font-size: 80%;">EST.</span>
						</div>
						
			            
			            
					</div> 
					<!-- == 649 == -->
					<div class="mainBodyJackpotBig" >
						
							
								<div class="mainBodyJackpotLogoSmall">
									<a href="/lotteries/games/howtoplay.do?game=lotto649"><img src="/assets/home/2009/lotto649_small.png" width="80" height="42" alt="LOTTO 6/49" border="0" /></a>
								</div>
							
							
						
						
							 
								<div class="mainBodyJackpotEstSmall">
									<strong>Wed, Oct 19</strong><br />
									<strong>$3,000,000</strong>&nbsp;<span style="font-weight:normal; font-size: 80%;">EST.</span>
									<p style="font-weight:bold;margin-left:-55px;margin-top:5px;">PLUS</p>
									<a href="/lotteries/games/lotto649_bonusdraw.jsp"><img src="/assets/logos/lottery/bonus_649_horz_sm.png" style="float:left;width:85px;height:26px;margin:-32px 0 0 0;"  alt="" title="" border="0"/></a>
								</div>
							
							
							
						
					</div>
					<!--== LOTTARIO ==-->
					<div class="mainBodyJackpotBig">
						<div class="mainBodyJackpotLogoBig">
							<a href="/lotteries/games/howtoplay.do?game=lottario"><img src="/assets/home/2009/lottoLottario_small.png" width="80" height="42" alt="LOTTARIO" border="0" /></a>
						</div>
						
					    
						<div class="mainBodyJackpotEstBig">
							<strong>Sat, Oct 22</strong><br />
							<strong>$540,000</strong>&nbsp;<span style="font-weight:normal; font-size: 80%;">EST.</span>
						</div>
						 
					      
			            
					</div>
					<div style="clear: both;"></div>
				</div>		
				
				
				
			
				<!-- === JACKPOT DISPLAY END ================= -->


*/





}












?>