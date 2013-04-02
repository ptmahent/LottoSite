<?php
/*
 * 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.

*/

//ob_start();
session_start();


    setlocale(LC_MONETARY, 'en_CA.UTF-8');
  include_once("inc/smarty/libs/Smarty.class.php");
  require_once("../inc/validform/libraries/ValidForm/class.validform.php");
  include_once("../inc/class_db.php");
  include_once("../inc/incGenDates.php");
  include_once("../inc/incNaLottery.php");
  include_once("../inc/incLottery.php");
  include_once("../inc/incOLGLottery.php");
  include_once("../inc/class_http.php");
  require_once("../inc/incUser.php");
  require_once("../inc/incAnalytics.php");
  
  $sNickName = "";
  $bLoggedIn = false;
  
  
  $objUser    = new User();
  $objLottery = new Lottery();
  $objDate    = new GenDates();
  $OLGLottery  = new OLGLottery();
  
  if ($_SESSION['valid']) {
    $iuserNo    = $_SESSION['userid'];
    $sNickName  = $_SESSION['_nickname'];
    $ds_user    = $objUser->UserGet($iuserNo);
    //print_r($ds_user);
    if (is_array($ds_user)) {
      $bLoggedIn = true;
    }
  }
  
  /*
   * 
   * 
 * sort_by: [drawDate, Number]
 * start_date: 
 * end_date:
 * st_month
 * st_day
 * st_year
 * page_num:
 * rows:
 * limit:
 * 
 * 
 * 
   * 
   */ 
  
  /*
   * using _REQUEST instead of _GET or _POST
   * 
   */ 
  $st_year         = null;
  $st_month        = null;
  $st_day          = null;
  $st_date         = null;
  $sort_by         = null;
  $limit           = null;
  $rows_per_page   = null;
  if (isset($_REQUEST["st_year"])) {
    $st_year = $_REQUEST["st_year"];
  }
  if (isset($_REQUEST["st_month"])) {
    $st_month = $_REQUEST["st_month"];
  }
  if (isset($_REQUEST["st_day"])) {
    $st_day   = $_REQUEST["st_day"];
  }
  if (isset($_REQUEST["st_date"])) {
    $st_date  = $_REQUEST["st_date"];
  } else {
    if ($st_day != null && $st_month != null && $st_year != null) {
      $st_date = date('Y-m-d', mktime(0,0,0,$st_month, $st_day, $st_year));
    } elseif ($st_month != null && $st_year != null) {
      $st_date = date('Y-m-d', mktime(0,0,0,$st_month, 1, $st_year));
    } elseif ($st_year != null) {
      $st_date = date('Y-m-d', mktime(0,0,0,1,1,$st_year));
    } else {
      $st_date = date('Y-m-d');
    }
  }
  if (isset($_REQUEST['ed_date'])) {
  	$ed_date = $_REQUEST["ed_date"];
  }
  
  
  if (isset($_REQUEST["limit"])) {
    $limit    = $_REQUEST["limit"]; 
    
  } else {
    $limit    = "M";
  }
  // M -> Month --- Y -> Year --- [DDDD] --num of rows
   
  $st_day   = date('d', strtotime($st_date));
  $st_month = date('m', strtotime($st_date));
  $st_year  = date('Y', strtotime($st_date)); 
   
  
  //$sql_limit

  if (isset($_REQUEST["sort_by"]) ) {
    $sort_by  = $_REQUEST["sort_by"];
  } else {
    $sort_by  = "dd";
    // dd -> draw date
  }

  if (isset($_REQUEST["rows_per_page"])) {
    $rows_per_page  = $_REQUEST["rows_per_page"];
  } else {
    $rows_per_page  = 20;
  }
  
  if (isset($_REQUEST["page_num"])) {
    $page_num       = $_REQUEST["page_num"];
  } else {
    $page_num       = 1;
  }
  
  $st_row_num = ($page_num - 1) * $rows_per_page;
  $ed_row_num = $page_num * $rows_per_page;
  
  
  if ($limit == "Y") {
  	$st_date = date('Y-m-d', mktime(0,0,0, $st_month, 1, $st_year));
  	
  	
    $ed_date = date('Y-m-d', mktime(0,0,0, 12, 31, $st_year));
  } elseif ($limit == "M") {
    $ed_date = date('Y-m-d',mktime(0,0,0,$st_month + 1, 0, $st_year));
    $st_date = date('Y-m-d', mktime(0,0,0,$st_month, 1, $st_year));
  } elseif ($limit == "Y_C") {
  	$st_date = date('Y-m-d', mktime(0,0,0, $st_month, 1, $st_year));
    $ed_date = date('Y-m-d');    
  } elseif ($limit == "50") {
    // Num of rows
    
  } elseif ($limit == "100") {
    
  } elseif ($limit == "150") {
    
  } elseif ($limit == "200") {
    
  } elseif ($limit == "250") {
    
  } elseif ($limit == "300") {
    
  } elseif ($limit == "DR") {
  	// start date and end date
  	
  
  }
  
  if (isset($ed_date)) {
  	// 
  
  }
  
  
  $onKeno_row = $objLottery->dbLotteryGamesGet("onKeno");
  if ($onKeno_row["drawStartDate"] != null) {
    $sGameStartDate = $onKeno_row["drawStartDate"];
  } else {
    $sGameStartDate = "2009-04-10";
  }
  
  
  //$sSelectedDate = mktime(0,0,0,date('m'),date('d'),date('Y'));
  
  
  
  
   $data_avail = $OLGLottery->OLGKenoGetFirstLastDataAvail();

	$smarty = new Smarty();

	$smarty->template_dir = '/home1/tswebtek/tswlotto/web_2/templates/';
	$smarty->compile_dir  = '/home1/tswebtek/tswlotto/web_2/templates_c/';
	$smarty->config_dir   = '/home1/tswebtek/tswlotto/web_2/configs/';
	$smarty->cache_dir	  = '/home1/tswebtek/tswlotto/web_2/cache/';
	$smarty->left_delimiter = "[";
	$smarty->right_delimiter = "]";
	
$htmltopOut = "";
// Display User if logged in
 if ($bLoggedIn == true) {
	$smarty->assign('userLoggedIn', 1);
	$smarty->assign('arUser', array('_nickname'=> $_SESSION['_nickname'],
									'userid' => $_SESSION['userid']
									)
					);
	$htmltopOut .= "Hi " . $_SESSION['_nickname'];
	$htmltopOut .= "| <a href='user_logout.php'>Logout</a>";
} else {
		$smarty->assign('userLoggedIn', 0);
	$htmltopOut .= "<a href='user_login.php'>Login</a>";
}

// Display earliest and latest date of lotto data available									
if (is_array($data_avail)) {
	$smarty->assign('data_avail', array("earliest" => date('Y-m-d',strtotime($data_avail["earliest"])),
										"latest" =>  date('Y-m-d',strtotime($data_avail["latest"]))
										)
					);
	$htmltopOut .= "<br />Data Available from " . date('Y-m-d',strtotime($data_avail["earliest"])) . " till " . date('Y-m-d',strtotime($data_avail["latest"]));
}

$smarty->assign('GAME', 'OLGKENO');
$smarty->assign('htmltopOut', $htmltopOut);

$htmlFormStartOut = "";


$htmlFormStartOut .= '<form name="frmViewLotto" id="frmViewLotto" method="get" action="view_keno.php">'
			 . '<input type="hidden" name="st_month" value="' . $st_month . '">'
			 . '<input type="hidden" name="st_day" value="' . $st_day . '">'
			 . '<input type="hidden" name="st_year" value="' .  $st_year . '">'
			 . '<input type="hidden" name="limit" value="' . $limit . '">'
			 . '<input type="hidden" name="sort_by" value="' . $sort_by .'">'
			 . '<input type="hidden" name="rows_per_page" value="' . $rows_per_page . '">'
			 . '<input type="hidden" name="page_num" value="' . $page_num . '">';

$htmlThirdNav = "";
$htmlThirdNav .= '<div id="nav_years">';

  $dGameStartDate = strtotime($sGameStartDate);
  for ($i = date('Y', $dGameStartDate); $i <= date('Y'); $i++) {
    if ($i != date('Y', $dGameStartDate)) {
      $htmlThirdNav .=  " | ";
    }  
    if ($i == date('Y', strtotime($st_date))) {
      $htmlThirdNav .= sprintf("<a href='javascript: setYear(%u);'><span class='selected' id='nav_year_%u'>%u</span></a>", $i, $i, $i);
    } else {
      $htmlThirdNav .= sprintf("<a href='javascript: setYear(%u);'><span class='not-selected' id='nav_year_%u'>%u</span></a>", $i, $i, $i);
    }
  }
$htmlThirdNav .= '</div><br /><div id="nav_months">';
  for ($i = 1; $i <= 12; $i++) {
    if ($i != 1) {
      $htmlThirdNav .=  " | ";
    }
    
    if (date('m',strtotime($st_date)) == $i) {
      if ($i < 10) {
        $htmlThirdNav .= sprintf("<a href='javascript: setMonth(%u);'><span class='selected' id='nav_month_0%u'>%s</span></a>", $i, $i, $objDate->getMonthName($i));          
      } else {
        $htmlThirdNav .= sprintf("<a href='javascript: setMonth(%u);'><span class='selected' id='nav_month_%u'>%s</span></a>", $i, $i, $objDate->getMonthName($i));      
      }
    } else {
      if ($i < 10) {
        $htmlThirdNav .= sprintf("<a href='javascript: setMonth(%u);'><span class='not-selected' id='nav_month_0%u'>%s</span></a>",$i, $i, $objDate->getMonthName($i));
      } else {
        $htmlThirdNav .= sprintf("<a href='javascript: setMonth(%u);'><span class='not-selected' id='nav_month_%u'>%s</span></a>",$i, $i, $objDate->getMonthName($i));
      }
    }  
  }
$htmlThirdNav .= '</div>';

/*
$htmlThirdNav .= '<br /><div id="nav_disp_limit">';
$htmlThirdNav .= "<span class='not-selected' id='nav_disp_limit_M'>Month</span> | <span class='not-selected' id='nav_disp_limit_Y'>Year</span> | <span class='not-selected' id='nav_disp_limit_100'>100 Draws</span> | <span class='not-selected' id='nav_disp_limit_200'>200 Draws</span>"
			  . "</div>";
$htmlThirdNav .= '<div id="nav_action">'
			  . '<span id="nav_act_submit"><input type="submit" name="action" value="submit" /></span>'
			  . '</div>';
			  

$htmlThirdNav .= '<div id="nav_draw_view_date">'
  			  . '<span class="not-selected">Prev Month</span> | <span class="selected">Current Month</span> | <span class="not-selected">Next Month</span>'
			  . '</div>'
			  . '<div id="game_draw_header">'
			  . '&nbsp;</div>';
			  
*/	
/*
 * sortBy: [drawDate, Number]
 * startDate: 
 * endDate:
 * PageNum:
 * rows:
 * limit:
 * 
 * 
 * 
 */

$htmlMainCont = "";
$htmlMainCont .=  '<div id="game_draw_body">';


$htmlMainCont .= "<div id='filter_Controls'>			
			Quick Find: <input type='text' id='quickfind' /> | 
			<a id='cleanfilters' href='#'>Clear Filters</a></div>";


$htmlMainCont .= '<table id="lottery_result" >'
			  . '<thead><tr><th id="head_drawDate">Draw Date</th>';
			   
			  
for ($i = 1; $i <= 70; $i++) {

	if ($i < 10) {
		$htmlMainCont .= '<th id="head_drawNumber">0' . $i . "</th>";
	} else {
		$htmlMainCont .= '<th id="head_drawNumber">' . $i . "</th>";
	}
}

		$htmlMainCont .= '<th id="head_drawNumber">Total</th>
						 <th id="head_drawNumber">Avg</th>
						 <th id="head_drawNumber">Low</th>
						 <th id="head_drawNumber">High</th>
						 <th id="head_drawNumber">Mid1</th>
						 <th id="head_drawNumber">Mid2</th>
						 <th id="head_drawNumber">Std Dev</th>
						 ';
// total
  // average
  // lowest
  // highest
  // middleFirst
  // middleSecond


			  
$htmlMainCont .= '</tr></thead><tbody>';
/*
print "st DT: " . $st_date;
print "\n ed DT: " . $ed_date;
print "\n stRowNum: " . $st_row_num;
print "\n edRowNum: " . $ed_row_num;
 * 
 */
$db_res = $OLGLottery->OLGKenoGetDraw($st_date, $ed_date, $st_row_num, $ed_row_num);
//print_r($db_res);
if (is_array($db_res)) {
  $total_rs_count = count($db_res);
  $match_cnt_ar = array();
  // total
  // average
  // lowest
  // highest
  // middleFirst
  // middleSecond
  
  
  $irow_cnt = 0;
  
  foreach ($db_res as $db_row) {
	 $htmlMainCont .=  '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>";
	 
	  	$itotal = 0;
	  	$iaverage = 0;
	  	$ilowest = 0;
	  	$ihighest = 0;
	  	$iMidFirst = 0;
	  	$iMidSecond = 0;
	  	$irow_cnt++;
	  for ($i = 1; $i <= 70; $i++) {
	  
	  
		if ($db_row["snum1"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum1"] . '</td>';
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		}elseif ($db_row["snum2"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum2"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum3"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum3"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum4"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum4"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum5"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum5"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum6"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum6"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum7"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum7"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum8"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum8"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum9"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum9"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum10"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum10"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum11"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum11"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		}  elseif ($db_row["snum12"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum12"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum13"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum13"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum14"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum14"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum15"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum15"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum16"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum16"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum17"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum17"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum18"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum18"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum19"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum19"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} elseif ($db_row["snum20"] == $i) {
			$htmlMainCont .= '<td id="drawNumber">' . $db_row["snum20"] . '</td>';	
			$match_cnt_ar[$i] += 1;
			$itotal += $i;
		} else {
			$htmlMainCont .= '<td id="drawNumber">&nbsp;</td>';
		}
		
	
	  	
	  	
	  }
	  
	  	// Total numbers
	  	$i_total_numbers = $irow_cnt * 20;
	  	
	  	
	  
	  
		$lineavg = $itotal / 20;
	  	$htmlMainCont .=  '<td id="statNumber">' . $itotal . '</td>';
	  	$htmlMainCont .=  '<td id="statNumber">' . number_format($lineavg) . '</td>';
	  	$htmlMainCont .=  '<td id="statNumber">' . $db_row["snum1"] . '</td>';
	  	$htmlMainCont .=  '<td id="statNumber">' . $db_row["snum20"] . '</td>';
	  	$htmlMainCont .=  '<td id="statNumber">' . $db_row["snum10"] . '</td>';
		$htmlMainCont .=  '<td id="statNumber">' . $db_row["snum11"] . '</td>';
		$match_cnt_ar[71] += $itotal;
		$match_cnt_ar[72] += $lineavg;
		$match_cnt_ar[73] += $db_row["snum1"];
		$match_cnt_ar[74] += $db_row["snum20"];
		$match_cnt_ar[75] += $db_row["snum10"];
		$match_cnt_ar[76] += $db_row["snum11"];
		
		
		
		$std_dev = number_format(sqrt(
		
		(
		(($db_row["snum1"] - $lineavg) * ($db_row["snum1"] - $lineavg)) +
		(($db_row["snum2"] - $lineavg) * ($db_row["snum2"] - $lineavg)) +
		(($db_row["snum3"] - $lineavg) * ($db_row["snum3"] - $lineavg)) +
		(($db_row["snum4"] - $lineavg) * ($db_row["snum4"] - $lineavg)) +
		(($db_row["snum5"] - $lineavg) * ($db_row["snum5"] - $lineavg)) +
		(($db_row["snum6"] - $lineavg) * ($db_row["snum6"] - $lineavg)) +
		
		(($db_row["snum7"] - $lineavg) * ($db_row["snum7"] - $lineavg)) +
		
		(($db_row["snum8"] - $lineavg) * ($db_row["snum8"] - $lineavg)) +
		
		(($db_row["snum9"] - $lineavg) * ($db_row["snum9"] - $lineavg)) +
		
		(($db_row["snum10"] - $lineavg) * ($db_row["snum10"] - $lineavg)) +
		
		
			
		(($db_row["snum11"] - $lineavg) * ($db_row["snum11"] - $lineavg)) +
		(($db_row["snum12"] - $lineavg) * ($db_row["snum12"] - $lineavg)) +
		(($db_row["snum13"] - $lineavg) * ($db_row["snum13"] - $lineavg)) +
		(($db_row["snum14"] - $lineavg) * ($db_row["snum14"] - $lineavg)) +
		(($db_row["snum15"] - $lineavg) * ($db_row["snum15"] - $lineavg)) +
		(($db_row["snum16"] - $lineavg) * ($db_row["snum16"] - $lineavg)) +
		
		(($db_row["snum17"] - $lineavg) * ($db_row["snum17"] - $lineavg)) +
		
		(($db_row["snum18"] - $lineavg) * ($db_row["snum18"] - $lineavg)) +
		
		(($db_row["snum19"] - $lineavg) * ($db_row["snum19"] - $lineavg)) +
		
		(($db_row["snum20"] - $lineavg) * ($db_row["snum20"] - $lineavg)) 
		
		) / 20));
		
		
		$match_cnt_ar[77] += $std_dev;
				
		$htmlMainCont .=  '<td id="statNumber">' . $std_dev . '</td>';
		/*
		sqrt(
		((num1 - average) ^ 2 + (num2 - average) ^ 2 + (num2 - average) ^ 2) / 3) 
		
		
		*/
			
		    $htmlMainCont .=  '</tr>';

  }
}

$avg_nums = array();

$htmlMainCont .=  '<tr><td>T:</td>';
$avg_tr_cont = '<tr><td>%: </td>';

for ($i = 1; $i <= 70; $i++) {
	if ($match_cnt_ar[$i] > 0) {
		//print "\n<br />irow_cnt : " . $irow_cnt . " -- Count: " .  $match_cnt_ar[$i] . " -- " . $i_total_numbers . " -- " .  $match_cnt_ar[$i] / $i_total_numbers;
		$cur_item_avg = (($match_cnt_ar[$i] / $i_total_numbers) * 100) ;
		$htmlMainCont .=  '<td id="statNumber">' . $match_cnt_ar[$i] . '</td>';
		$avg_tr_cont .= '<td id="avgNumber">' . number_format($cur_item_avg) . '</td>';
		
		if (!array_key_exists('_' . $cur_item_avg, $avg_nums)) {
			$avg_nums['_' . $cur_item_avg] = array($i);
		} else {
			array_push($avg_nums['_' . $cur_item_avg], $i);
		}
		
	} else {
		if (!array_key_exists('_0', $avg_nums)) {
			$avg_nums['_0'] = array($i);
		} else {
			array_push($avg_nums['_0'], $i);
		}	
		$htmlMainCont .=  '<td>&nbsp;</td>';
		$avg_tr_cont .= '<td>0</td>';
	}

}



	  	$htmlMainCont .=  '<td id="statNumber">' . number_format($match_cnt_ar[71] / $irow_cnt) . '</td>';
	  	$htmlMainCont .=  '<td id="statNumber">' . number_format($match_cnt_ar[72]  / $irow_cnt) . '</td>';
	  	$htmlMainCont .=  '<td id="statNumber">' . number_format($match_cnt_ar[73]  / $irow_cnt) . '</td>';
	  	$htmlMainCont .=  '<td id="statNumber">' . number_format($match_cnt_ar[74]   / $irow_cnt) . '</td>';
	  	$htmlMainCont .=  '<td id="statNumber">' . number_format($match_cnt_ar[75]  / $irow_cnt) . '</td>';
		$htmlMainCont .=  '<td id="statNumber">' . number_format($match_cnt_ar[76]  / $irow_cnt) . '</td>';
		$htmlMainCont .=  '<td id="statNumber">' . number_format($match_cnt_ar[77]  / $irow_cnt) . '</td>';
		
$htmlMainCont .=  '</tr>';
$htmlMainCont .= $avg_tr_cont;

$htmlMainCont .= '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
$htmlMainCont .= '</tr>';
 $htmlMainCont .= '</tbody></table>';
 

 $htmlMainCont .= '</div>';
 
 $html_rand_avg = "<table border='0'><tr><td>";
 foreach ($avg_nums as $a_nums) {
 	$html_rand_avg .=  $a_nums . " ";
 }
 $html_rand_avg .=  "</td></tr></table>";
 
 
 
$objAnalytics   = new Analytics();
  $htmlMainCont .= $objAnalytics->GoogleAnalytics();


$htmlFormEndOut = '</form>';

$JSOUTPUT = "$(document).ready(function() {
			var options = {
				additionalFilterTriggers: [$('#quickfind')],
				clearFiltersControls: [$('#cleanfilters')]           
			};


			$('#lottery_result').tableFilter(options);
			});";



$smarty->assign("JSOUTPUT", $JSOUTPUT);

$smarty->assign("htmlFormStart", $htmlFormStartOut);
$smarty->assign("htmlThirdNav", $htmlThirdNav);
$smarty->assign("htmlOut", $htmlMainCont);
$smarty->assign("htmlFormEnd", $htmlFormEndOut);
$smarty->display('view_numbers_year.tpl');


