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
  include_once("../web3/inc/smarty/libs/Smarty.class.php");
  
  require_once("../inc/validform/libraries/ValidForm/class.validform.php");
  include_once("../inc/class_db.php");
  include_once("../inc/incGenDates.php");
  include_once("../inc/incNaLottery.php");
  include_once("../inc/incLottery.php");
  include_once("../inc/incOLGLottery.php");
  include_once("../inc/class_http.php");
  require_once("../inc/incUser.php");
  require_once("../inc/incAnalytics.php");
  require_once("../inc/incQuickPick.php");
  
  $sNickName = "";
  $bLoggedIn = false;
  
  
  $objUser    = new User();
  $objLottery = new Lottery();
  $objDate    = new GenDates();
  $naLottery  = new NALottery();
  
  if (array_key_exists("valid",$_SESSION)) {
    $iuserNo    = $_SESSION['userid'];
    $sNickName  = $_SESSION['_nickname'];
    $ds_user    = $objUser->UserGet($iuserNo);
    //print_r($ds_user);
    if (is_array($ds_user)) {
      $bLoggedIn = true;
    }
  }
  
  $htmlThirdNav  = "";
  
  //$sSelectedDate = mktime(0,0,0,date('m'),date('d'),date('Y'));
  
  
  
  
   $data_avail = $naLottery->na649GetFirstLastDataAvail();

	$smarty = new Smarty();

	$smarty->template_dir = '/home1/tswebtek/tswlotto/web5/templates/';
	$smarty->compile_dir  = '/home1/tswebtek/tswlotto/web5/templates_c/';
	$smarty->config_dir   = '/home1/tswebtek/tswlotto/web5/configs/';
	$smarty->cache_dir	  = '/home1/tswebtek/tswlotto/web5/cache/';
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

$smarty->assign('GAME', 'NAMAX');
$smarty->assign('htmltopOut', $htmltopOut);

$htmlFormStartOut = "";

$htmlFormStartOut .= '<form name="Check_Keno" id="Check_Keno" method="post" enctype="multipart/form-data" action="check_max.php">';


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
$htmlMainCont .= '<div id="game_draw_body"><table border="0" colspan="0" width="100%" height="400px">';
/*
print "st DT: " . $st_date;
print "\n ed DT: " . $ed_date;
print "\n stRowNum: " . $st_row_num;
print "\n edRowNum: " . $ed_row_num;
 * 
 */
//$db_res = $naLottery->na649GetDraw($st_date, $ed_date, $st_row_num, $ed_row_num);
//print_r($db_res);



$QuickPick = new QuickPick();
$sQuickPick1  =  implode("-",$QuickPick->naMaxQuickPick());
$sQuickPick2  =  implode("-",$QuickPick->naMaxQuickPick()) ;
$sQuickPick3  =  implode("-",$QuickPick->naMaxQuickPick()) ;
$sQuickPick4  =  implode("-",$QuickPick->naMaxQuickPick()) ;
$sQuickPick5  =  implode("-",$QuickPick->naMaxQuickPick()) ;
$sQuickPick6  =  implode("-",$QuickPick->naMaxQuickPick()) ;
$sQuickPick7  =  implode("-",$QuickPick->naMaxQuickPick()) ;
$sQuickPick8  =  implode("-",$QuickPick->naMaxQuickPick()) ;
$sQuickPick9  =  implode("-",$QuickPick->naMaxQuickPick()) ;
$sQuickPick10 =  implode("-",$QuickPick->naMaxQuickPick()) ;

$htmlMainCont .= '
<tr><td id="quickCell">&nbsp;

<input type="hidden" name="st_DrawYear" value="2009" />
<input type="hidden" name="st_DrawMonth" value="1" />
<input type="hidden" name="st_DrawDay" value="1" />
<input type="hidden" name="ed_DrawYear" value="2012" />
<input type="hidden" name="ed_DrawMonth" value="12" />
<input type="hidden" name="ed_DrawDay" value="1" />

<input type="hidden" name="multi_draw" value="on" />
<input type="hidden" name="addMaxnums" value="on" />

<input type="hidden" name="NA_Max" value="' . $sQuickPick1 . '" />
<input type="hidden" name="NA_Max_2" value="' . $sQuickPick2 . '" />
<input type="hidden" name="NA_Max_3" value="' . $sQuickPick3 . '" />
<input type="hidden" name="NA_Max_4" value="' . $sQuickPick4 . '" />
<input type="hidden" name="NA_Max_5" value="' . $sQuickPick5 . '" />
<input type="hidden" name="NA_Max_6" value="' . $sQuickPick6 . '" />
<input type="hidden" name="NA_Max_7" value="' . $sQuickPick7 . '" />
<input type="hidden" name="NA_Max_8" value="' . $sQuickPick8 . '" />
<input type="hidden" name="NA_Max_9" value="' . $sQuickPick9 . '" />
<input type="hidden" name="NA_Max_10" value="' . $sQuickPick10 . '" />
<input type="hidden" name="vf__dispatch" value="Check_Max" />

</td></tr>
';



$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick1 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick2 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick3 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick4 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick5 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick6 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick7 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick8 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick9 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell"><h3>Lotto Max Quick Pick : ' . $sQuickPick10 . '</h3></td></tr>';
$htmlMainCont .= '<tr><td id="quickCell">To see winning history for selected numbers above <input type="Submit" value="Click Here" /></td></tr>';




$htmlMainCont .= '</table>';

  $objAnalytics   = new Analytics();
  $htmlMainCont .= $objAnalytics->GoogleAnalytics();


$htmlFormEndOut = '</form>';

$smarty->assign("htmlFormStart", $htmlFormStartOut);
$smarty->assign("htmlThirdNav", $htmlThirdNav);
$smarty->assign("htmlOut", $htmlMainCont);
$smarty->assign("htmlFormEnd", $htmlFormEndOut);
$smarty->display('templates/quick_numbers.tpl');
