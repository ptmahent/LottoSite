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
    $ed_date = date('Y-m-d', mktime(0,0,0, $st_month, 1, $st_year));
  } elseif ($limit == "M") {
    $ed_date = date('Y-m-d',mktime(0,0,0,$st_month + 1, 0, $st_year));
    $st_date = date('Y-m-d', mktime(0,0,0,$st_month, 1, $st_year));
  } elseif ($limit == "50") {
    // Num of rows
    
  } elseif ($limit == "100") {
    
  } elseif ($limit == "150") {
    
  } elseif ($limit == "200") {
    
  } elseif ($limit == "250") {
    
  } elseif ($limit == "300") {
    
  } 
  
  $onPoker_row = $objLottery->dbLotteryGamesGet("onPoker");
  if ($onPoker_row["drawStartDate"] != null) {
    $sGameStartDate = $onPoker_row["drawStartDate"];
  } else {
    $sGameStartDate = "2009-04-10";
  }
  
  
  //$sSelectedDate = mktime(0,0,0,date('m'),date('d'),date('Y'));
  
  
  
  
   $data_avail = $OLGLottery->OLGPokerGetFirstLastDataAvail();

	$smarty = new Smarty();

	$smarty->template_dir = '/home1/tswebtek/tswlotto/web3/templates/';
	$smarty->compile_dir  = '/home1/tswebtek/tswlotto/web3/templates_c/';
	$smarty->config_dir   = '/home1/tswebtek/tswlotto/web3/configs/';
	$smarty->cache_dir	  = '/home1/tswebtek/tswlotto/web3/cache/';
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

$smarty->assign('htmltopOut', $htmltopOut);

$htmlFormStartOut = "";


$htmlFormStartOut .= '<form name="frmViewLotto" id="frmViewLotto" method="get" action="view_poker.php">'
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
      $htmlThirdNav .= sprintf("<span class='selected' id='nav_year_%u'>%u</span>", $i, $i);
    } else {
      $htmlThirdNav .= sprintf("<span class='not-selected' id='nav_year_%u'>%u</span>", $i, $i);
    }
  }
$htmlThirdNav .= '</div><br /><div id="nav_months">';
  for ($i = 1; $i <= 12; $i++) {
    if ($i != 1) {
      $htmlThirdNav .=  " | ";
    }
    
    if (date('m',strtotime($st_date)) == $i) {
      if ($i < 10) {
        $htmlThirdNav .= sprintf("<span class='selected' id='nav_month_0%u'>%s</span>", $i, $objDate->getMonthName($i));          
      } else {
        $htmlThirdNav .= sprintf("<span class='selected' id='nav_month_%u'>%s</span>", $i, $objDate->getMonthName($i));      
      }
    } else {
      if ($i < 10) {
        $htmlThirdNav .= sprintf("<span class='not-selected' id='nav_month_0%u'>%s</span>",$i, $objDate->getMonthName($i));
      } else {
        $htmlThirdNav .= sprintf("<span class='not-selected' id='nav_month_%u'>%s</span>",$i, $objDate->getMonthName($i));
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
$htmlMainCont .= '<div id="game_draw_body"><table border="0" colspan="0" width="100%">'
				. '<tr><td>Draw Date</td><td colspan="5">Winning Number</td><td>&nbsp;</td></tr>';
/*
print "st DT: " . $st_date;
print "\n ed DT: " . $ed_date;
print "\n stRowNum: " . $st_row_num;
print "\n edRowNum: " . $ed_row_num;
 * 
 */
$db_res = $OLGLottery->OLGPokerGetDraw($st_date, $ed_date, $st_row_num, $ed_row_num);
//print_r($db_res);
if (is_array($db_res)) {
  foreach ($db_res as $db_row) {
  
 $htmlMainCont .= '<tr class="649Row">'
			 . '<td>' . date('Y-m-d',strtotime($db_row["drawdate"])) . '</td>'
			 . '<td>' . $db_row["scard1"] . '</td>'
			 . '<td>' . $db_row["scard2"] . '</td>'
			 . '<td>' . $db_row["scard3"] . '</td>'
			 . '<td>' . $db_row["scard4"] . '</td>'
			 . '<td>' . $db_row["scard5"] . '</td>'
			 . '<td>&nbsp;</td>'
			 . '</tr>';


  }
}

 
 $htmlMainCont .= '</table></div>';
$objAnalytics   = new Analytics();
  $htmlMainCont .= $objAnalytics->GoogleAnalytics();


$htmlFormEndOut = '</form>';

$smarty->assign("htmlFormStart", $htmlFormStartOut);
$smarty->assign("htmlThirdNav", $htmlThirdNav);
$smarty->assign("htmlOut", $htmlMainCont);
$smarty->assign("htmlFormEnd", $htmlFormEndOut);
$smarty->display('view_numbers.tpl');


