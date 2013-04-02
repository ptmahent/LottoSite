<?php
  setlocale(LC_MONETARY, 'en_CA.UTF-8');
  
  session_start();
  
  
  include_once("inc/smarty/libs/Smarty.class.php");
  
  require_once("../inc/validform/libraries/ValidForm/class.validform.php");
  include_once("../inc/class_db.php");
  include_once("../inc/incGenDates.php");
  include_once("../inc/incNaLottery.php");
  include_once("../inc/incLottery.php");
  include_once("../inc/incOLGLottery.php");
  include_once("../inc/class_http.php");
  require_once("../inc/incUser.php");
  require_once("../inc/incJackpot.php");
  require_once("../inc/incAnalytics.php");
  
  
  
  $objUser    = new User();
  $objLottery = new Lottery();
  $objDate    = new GenDates();
  $naLottery  = new NALottery();
  $OLGLottery  = new OLGLottery();
  
  
	$smarty = new Smarty();

	$smarty->template_dir = '/home1/tswebtek/tswlotto/web3/templates/';
	$smarty->compile_dir  = '/home1/tswebtek/tswlotto/web3/templates_c/';
	$smarty->config_dir   = '/home1/tswebtek/tswlotto/web3/configs/';
	$smarty->cache_dir	  = '/home1/tswebtek/tswlotto/web3/cache/';
	$smarty->left_delimiter = "[";
	$smarty->right_delimiter = "]";
	  
	  
  $sNickName = "";
  $bLoggedIn = false;
  $objUser = new User();
  
  $htmltopOut = "";
	  
if (array_key_exists('valid',$_SESSION)) {
    $iuserNo    = $_SESSION['userid'];
    $sNickName  = $_SESSION['_nickname'];
    $ds_user    = $objUser->UserGet($iuserNo);
    //print_r($ds_user);
    if (is_array($ds_user)) {
      $bLoggedIn = true;
    }
  }
	
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

$na649_data_avail = $naLottery->na649GetFirstLastDataAvail();
$olg49_data_avail = $OLGLottery->OLG49GetFirstLastDataAvail();
$olgpoker_data_avail = $OLGLottery->OLGPokerGetFirstLastDataAvail();
$olgpick4_data_avail = $OLGLottery->OLGPick4GetFirstLastDataAvail();
$olgpick3_data_avail = $OLGLottery->OLGPick3GetFirstLastDataAvail();
$namax_data_avail = $naLottery->naMAXGetFirstLastDataAvail();
$olglottario_data_avail = $OLGLottery->OLGLottarioGetFirstLastDataAvail();
 $olgencore_data_avail = $OLGLottery->OLGEncoreGetFirstLastDataAvail();
 $olgkeno_data_avail = $data_avail = $OLGLottery->OLGKenoGetFirstLastDataAvail();



$smarty->assign('htmltopOut', $htmltopOut);

//$htmlOut = "<div id='lotto_welcome'>";

$htmlOut = "<table border='0' width='100%'><tr><td align='center'>
<h3><a href='http://lottoblog.co/i/?q=forum'> Visit our Lotto Forum</a></h3>

<h2>Upcomming Lotto Jackpots</h2>
<br /><br />
<h3><a href='check_649.php'>Lotto 649</a></h3>
<h3>Wed, May 2 -$7 000,000 EST.<br /></h3>
<a href='view_649_winnings.php'>Winnings</a>
<br />";

if (is_array($na649_data_avail)) {
    $st_row_num = 0;
    $ed_row_num = 1;
$db_res = $naLottery->na649GetDraw(date('Y-m-d',strtotime($na649_data_avail["latest"])), date('Y-m-d',strtotime($na649_data_avail["latest"])), $st_row_num, $ed_row_num);

if (is_array($db_res)) {
$htmlOut .= '<table id="lottery_result" >'
			  . '<thead><tr><th id="head_drawDate">Draw Date</th>
			  	<th id="head_drawNumber">N1</th>
				<th id="head_drawNumber">N2</th>
				<th id="head_drawNumber">N3</th>
				<th id="head_drawNumber">N4</th>
				<th id="head_drawNumber">N5</th>
				<th id="head_drawNumber">N6</th>
				<th id="head_drawNumber">BONUS</th><th>&nbsp;</th></tr></thead><tbody>';
  foreach ($db_res as $db_row) {
 $drawDateINT  = strtotime($db_row["drawdate"]);
	$oct2011START = strtotime("2011-10-01 00:00:00");
	$oct2011END	  = strtotime("2011-10-31 00:00:00");
	//print "<hr /> iseq: " . $db_row["isequencenum"] . " -- DRWINT: " . $drawDateINT . " | " . $db_row["drawdate"] . " -- " . "OCT ST: " .  $oct2011START . " -- OCT END: " . $oct2011END;
	if ($drawDateINT >= $oct2011START && $drawDateINT <= $oct2011END) {
		if ($db_row["isequencenum"] == 0) {
			$htmlOut .= '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
			  . '<td id="drawNumber">' . $db_row["snum1"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum2"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum3"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum4"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum5"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum6"] . '</td>'
			  . '<td id="matchBonusNumber">' . $db_row["snumbonus"] . '</td>'
			  . '<td id="drawNumber">&nbsp;</td></tr>';
		 } else {
		 	$htmlOut .= '<tr ><td id="drawDate" nowrap>Bonus Draw<br />' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
			  . '<td id="drawNumber">' . $db_row["snum1"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum2"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum3"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum4"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum5"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum6"] . '</td>'
			  . '<td id="matchBonusNumber">&nbsp;</td>'
			  . '<td id="drawNumber">&nbsp;</td></tr>';
		 
		 }
	
	} else {
		$htmlOut .= '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
			  . '<td id="drawNumber">' . $db_row["snum1"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum2"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum3"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum4"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum5"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum6"] . '</td>'
			  . '<td id="matchBonusNumber">' . $db_row["snumbonus"] . '</td>'
			  . '<td id="drawNumber">&nbsp;</td></tr>';
	}
	}
	$htmlOut .= "</tbody></table>";
}

}

$htmlOut .= "
<h3><a href='check_max.php'>Lotto Max</a></h3>

<h3>Fri, May 4,
$50 000,000 EST. <br />
</h3>
<a href='view_max_winnings.php'>Winnings</a>
<br />2 Max Millions";


if (is_array($namax_data_avail)) {
$db_res = $naLottery->naMaxGetDraw(date('Y-m-d',strtotime($namax_data_avail["latest"])), date('Y-m-d',strtotime($namax_data_avail["latest"])), $st_row_num, $ed_row_num);

if (is_array($db_res)) {
$htmlOut .= '<table id="lottery_result" >'
			  . '<thead><tr><th id="head_drawDate">Draw Date</th>
			    <th id="head_drawNumber">SEQ NUM</th>
			  	<th id="head_drawNumber">N1</th>
				<th id="head_drawNumber">N2</th>
				<th id="head_drawNumber">N3</th>
				<th id="head_drawNumber">N4</th>
				<th id="head_drawNumber">N5</th>
				<th id="head_drawNumber">N6</th>
				<th id="head_drawNumber">N7</th>
				<th id="head_drawNumber">BONUS</th><th>&nbsp;</th></tr></thead><tbody>';
  foreach ($db_res as $db_row) {



$htmlOut .=  '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
			  . '<td id="drawNumber">' .  $db_row["isequencenum"] . '</td>'
			 . '<td id="drawNumber">' .  $db_row["snum1"] . '</td>'
			  . '<td id="drawNumber">' .  $db_row["snum2"] . '</td>'
			  . '<td id="drawNumber">' .  $db_row["snum3"] . '</td>'
			 . '<td id="drawNumber">' .  $db_row["snum4"] . '</td>'
			  . '<td id="drawNumber">' .  $db_row["snum5"] . '</td>'
			  . '<td id="drawNumber">' .  $db_row["snum6"] . '</td>'
			 . '<td id="drawNumber">' .  $db_row["snum7"] . '</td>'
			  . '<td id="matchBonusNumber">' .  $db_row["snumbonus"] . '</td>'
			  . '<td id="drawNumber">&nbsp;</td>'
			 . '</tr>';

}
	$htmlOut .= "</tbody></table>";
}
}


$htmlOut .= "
<h3><a href='check_lottario.php'>Lottario</a></h3>
<h3>Sat, May 05 - $250, 000 EST.</h3>
<a href='view_lottario_winnings.php'>Winnings</a>
<br />";

if (is_array($olglottario_data_avail)) {
$db_res = $OLGLottery->OLGLottarioGetDraw(date('Y-m-d',strtotime($olglottario_data_avail["latest"])), date('Y-m-d',strtotime($olglottario_data_avail["latest"])), $st_row_num, $ed_row_num);
//print_r($db_res);
if (is_array($db_res)) {



$htmlOut .= '<table id="lottery_result" >'
			  . '<thead><tr><th id="head_drawDate">Draw Date</th>
		
			  	<th id="head_drawNumber">N1</th>
				<th id="head_drawNumber">N2</th>
				<th id="head_drawNumber">N3</th>
				<th id="head_drawNumber">N4</th>
				<th id="head_drawNumber">N5</th>
				<th id="head_drawNumber">N6</th>
				<th id="head_drawNumber">BONUS NUM</th>
				<th>&nbsp;</th>
				<th id="head_drawNumber">EB1</th>
				<th id="head_drawNumber">EB2</th>
				<th id="head_drawNumber">EB3</th>
				<th id="head_drawNumber">EB4</th>
				<th>&nbsp;</th></tr></thead><tbody>';
  foreach ($db_res as $db_row) {
  
  $htmlOut .= '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
. '<td id="drawNumber">' .  $db_row["snum1"] . '</td>'
. '<td id="drawNumber">' .  $db_row["snum2"] . '</td>'
. '<td id="drawNumber">' .  $db_row["snum3"] . '</td>'
. '<td id="drawNumber">' .  $db_row["snum4"] . '</td>'
. '<td id="drawNumber">' .  $db_row["snum5"] . '</td>'
. '<td id="drawNumber">' .  $db_row["snum6"] . '</td>'
. '<td id="matchBonusNumber">' .  $db_row["snumbonus"] . '</td>'
. '<td  id="drawNumber">&nbsp;</td>'
. '<td id="drawNumber">' .   $db_row["eb_snum1"] . '</td>'
. '<td id="drawNumber">' .  $db_row["eb_snum2"] . '</td>'
. '<td id="drawNumber">' .  $db_row["eb_snum3"] . '</td>'
. '<td id="drawNumber">' .  $db_row["eb_snum4"] . '</td>'
. '</tr>';

  
  
  }
  $htmlOut .= "</tbody></table>";
}


}


if (is_array($olg49_data_avail)) {
$db_res = $OLGLottery->OLG49GetDraw(date('Y-m-d',strtotime($olg49_data_avail["latest"])), date('Y-m-d',strtotime($olg49_data_avail["latest"])), $st_row_num, $ed_row_num);

$htmlOut .= "<h3><a href='check_49.php'>Ontario 49</a></h3>";
if (is_array($db_res)) {

$htmlOut .= '<table id="lottery_result" >'
			  . '<thead><tr><th id="head_drawDate">Draw Date</th>
			  	<th id="head_drawNumber">N1</th>
				<th id="head_drawNumber">N2</th>
				<th id="head_drawNumber">N3</th>
				<th id="head_drawNumber">N4</th>
				<th id="head_drawNumber">N5</th>
				<th id="head_drawNumber">N6</th>
				<th id="head_drawNumber">BONUS</th><th>&nbsp;</th></tr></thead><tbody>';


  foreach ($db_res as $db_row) {
$htmlOut .= '<tr ><td id="drawDate" nowrap >' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
			  . '<td id="drawNumber">' . $db_row["snum1"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum2"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum3"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum4"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum5"] . '</td>'
			  . '<td id="drawNumber">' . $db_row["snum6"] . '</td>'
			  . '<td id="matchBonusNumber">' . $db_row["snumbonus"] . '</td>'
			  . '<td id="drawNumber">&nbsp;</td>'
			  . '</tr>';
	}
		$htmlOut .= "</tbody></table>";
}

}
if (is_array($olgpoker_data_avail)) {
$db_res = $OLGLottery->OLGPokerGetDraw(date('Y-m-d',strtotime($olgpoker_data_avail["latest"])), date('Y-m-d',strtotime($olgpoker_data_avail["latest"])), $st_row_num, $ed_row_num);

$htmlOut .= "<h3><a href='check_poker.php'>Ontario Poker</a></h3>";

if (is_array($db_res)) {

$htmlOut .= '<table id="lottery_result" >'
			  . '<thead><tr><th  id="head_drawDate">Draw Date</th>'
			  .  '<th id="head_drawNumber">CARD 1</th>'
			  . '<th id="head_drawNumber">CARD 2</th>'
			  . '<th id="head_drawNumber">CARD 3</th>'
			  . '<th id="head_drawNumber">CARD 4</th>'
			  . '<th id="head_drawNumber">CARD 5</th>'
			  . '<th id="head_drawNumber">&nbsp;</th></tr></thead><tbody>';
  foreach ($db_res as $db_row) {

 $htmlOut .=  '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
			 . '<td id="drawNumber">' . $db_row["scard1"] . '</td>'
			 . '<td id="drawNumber">' . $db_row["scard2"] . '</td>'
			 . '<td id="drawNumber">' . $db_row["scard3"] . '</td>'
			 . '<td id="drawNumber">' . $db_row["scard4"] . '</td>'
			 . '<td id="drawNumber">' . $db_row["scard5"] . '</td>'
			 . '<td id="drawNumber">&nbsp;</td>'
			 . '</tr>';
	}
	$htmlOut .= "</tbody></table>";
	
}

}



if (is_array($olgkeno_data_avail)) {


/*
print "st DT: " . $st_date;
print "\n ed DT: " . $ed_date;
print "\n stRowNum: " . $st_row_num;
print "\n edRowNum: " . $ed_row_num;
 * 
 */
$db_res = $OLGLottery->OLGKenoGetDraw(date('Y-m-d',strtotime($olgkeno_data_avail["latest"])), date('Y-m-d',strtotime($olgkeno_data_avail["latest"])), $st_row_num, $ed_row_num);
//print_r($db_res);
$htmlOut .= "<h3><a href='check_keno.php'>Ontario Keno</a></h3>";
if (is_array($db_res)) {

$htmlOut .= '<table id="lottery_result" >'
			  . '<thead><tr><th id="head_drawDate">Draw Date</th>
			   
			  	<th id="head_drawNumber">N1</th>
				<th id="head_drawNumber">N2</th>
				<th id="head_drawNumber">N3</th>
				<th id="head_drawNumber">N4</th>
				<th id="head_drawNumber">N5</th>
				<th id="head_drawNumber">N6</th>
				<th id="head_drawNumber">N7</th>
				<th id="head_drawNumber">N8</th>
				<th id="head_drawNumber">N9</th>
				<th id="head_drawNumber">N10</th>
				<th id="head_drawNumber">N11</th>
				<th id="head_drawNumber">N12</th>
				<th id="head_drawNumber">N13</th>
				<th id="head_drawNumber">N14</th>
				<th id="head_drawNumber">N15</th>
				<th id="head_drawNumber">N16</th>
				<th id="head_drawNumber">N17</th>
				<th id="head_drawNumber">N18</th>
				<th id="head_drawNumber">N19</th>
				<th id="head_drawNumber">N20</th>
				<th>&nbsp;</th></tr></thead><tbody>';
  $total_rs_count = count($db_res);
  foreach ($db_res as $db_row) {
 $htmlOut .=  '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
			  . '<td id="drawNumber">' .  $db_row["snum1"] . '</td>'
			. '<td id="drawNumber">' .  $db_row["snum2"] . '</td>'
			. '<td id="drawNumber">' .  $db_row["snum3"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum4"] . '</td>' 
			. '<td id="drawNumber">' .   $db_row["snum5"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum6"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum7"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum8"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum9"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum10"] . '</td>' 
			. '<td id="drawNumber">' .   $db_row["snum11"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum12"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum13"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum14"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum15"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum16"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum17"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum18"] .  '</td>'
			. '<td id="drawNumber">' .  $db_row["snum19"] . '</td>' 
			. '<td id="drawNumber">' .  $db_row["snum20"] . '</td>' 
		    . '<td id="drawNumber">&nbsp;</td>'
		    . '</tr>';

  }
}

 $htmlOut .= '</tbody></table>';
}







if (is_array($olgpick4_data_avail)) {
$db_res = $OLGLottery->OLGPick4GetDraw(date('Y-m-d',strtotime($olgpick4_data_avail["latest"])), date('Y-m-d',strtotime($olgpick4_data_avail["latest"])), $st_row_num, $ed_row_num);

$htmlOut .= "<h3><a href='check_pick4.php'>Ontario Pick 4</a></h3>";
if (is_array($db_res)) {

$htmlOut .= '<table id="lottery_result" >'
			  . '<thead><tr><th  id="head_drawDate">Draw Date</th>
			   
			  	<th id="head_drawNumber">N1</th>
				<th id="head_drawNumber">N2</th>
				<th id="head_drawNumber">N3</th>
				<th id="head_drawNumber">N4</th><th id="head_drawNumber">&nbsp;</th></tr></thead><tbody>';

  foreach ($db_res as $db_row) {


  $htmlOut .=  '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
			  . '<td id="drawNumber">' .  $db_row["snum1"] . '</td>'
			   . '<td id="drawNumber">' .  $db_row["snum2"] . '</td>'
				 . '<td id="drawNumber">' .  $db_row["snum3"] . '</td>'
				 . '<td id="drawNumber">' .  $db_row["snum4"] . '</td>'
				 . '<td id="drawNumber">&nbsp;</td>'
				. '</tr>';

}

	$htmlOut .= "</tbody></table>";

}

}
if (is_array($olgpick3_data_avail)) {
$db_res = $OLGLottery->OLGPick3GetDraw(date('Y-m-d',strtotime($olgpick3_data_avail["latest"])), date('Y-m-d',strtotime($olgpick3_data_avail["latest"])), $st_row_num, $ed_row_num);
$htmlOut .= "<h3><a href='check_pick3.php'>Ontario Pick 3</a></h3>";
if (is_array($db_res)) {


$htmlOut .= '<table id="lottery_result" >'
			  . '<thead><tr><th  id="head_drawDate">Draw Date</th>
			   
			  	<th id="head_drawNumber">N1</th>
				<th id="head_drawNumber">N2</th>
				<th id="head_drawNumber">N3</th>
				<th>&nbsp;</th></tr></thead><tbody>';

  foreach ($db_res as $db_row) {

$htmlOut .=  '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
			  . '<td id="drawNumber">' .  $db_row["snum1"] . '</td>'
			. '<td id="drawNumber">' .  $db_row["snum2"] . '</td>'
			. '<td id="drawNumber">' .   $db_row["snum3"] . '</td>'
			. '<td id="drawNumber">&nbsp;</td>'
			. '</tr>';


}
	$htmlOut .= "</tbody></table>";
}
}


if (is_array( $olgencore_data_avail) ) {
$db_res = $OLGLottery->OLGEncoreGetDraw(date('Y-m-d',strtotime($olgencore_data_avail["latest"])), date('Y-m-d',strtotime($olgencore_data_avail["latest"])), $st_row_num, $ed_row_num);
//print_r($db_res);

$htmlOut .= "<h3><a href='check_encore.php'>Ontario Encore</a></h3>";

if (is_array($db_res)) {

$htmlOut .= '<table id="lottery_result" >'
			  . '<thead><tr><th id="head_drawDate">Draw Date</th>
			  	<th id="head_drawNumber">N1</th>
				<th id="head_drawNumber">N2</th>
				<th id="head_drawNumber">N3</th>
				<th id="head_drawNumber">N4</th>
				<th id="head_drawNumber">N5</th>
				<th id="head_drawNumber">N6</th>
				<th id="head_drawNumber">N7</th>
				<th id="head_drawNumber">&nbsp;</th>'
			 . '</tr></thead><tbody>';

  foreach ($db_res as $db_row) {


$htmlOut .= '<tr ><td id="drawDate" nowrap>' . date('Y-m-d',strtotime($db_row["drawdate"])) . "</td>"
		. '<td id="drawNumber">' . $db_row["snum1"] . '</td>'
		. '<td id="drawNumber">' . $db_row["snum2"] . '</td>'
		. '<td id="drawNumber">' . $db_row["snum3"] . '</td>'
		. '<td id="drawNumber">' . $db_row["snum4"] . '</td>'
		. '<td id="drawNumber">' . $db_row["snum5"] . '</td>'
		. '<td id="drawNumber">' . $db_row["snum6"] . '</td>'
		. '<td id="drawNumber">' . $db_row["snum7"] . '</td>'
		. '<td id="drawNumber">&nbsp;</td>'
		. '</tr>';


	}
	$htmlOut .= '</tbody></table></div>';
}
}

$htmlOut .= "
</td></tr></table>";


$objAnalytics   = new Analytics();
  $htmlOut .= $objAnalytics->GoogleAnalytics();
  
$htmlCSSOut = "#twitter {
    height: 200px;
	position: relative;
	float: left;
	width: 1004px;
	margin: 0px;
	padding: 0px;
	top: 0px;
				}";



$htmlOut .= ' <div id="twitter_holder">
<h4>&nbsp;&nbsp;&nbsp;<a href="http://www.lottoblog.co">LottoBlog.Co</a></h4>
<div id="twitter"></div>
</div>';
//$htmlOut .= '</div>';
$htmlJSOut = "
$(document).ready(function() {
$('#twitter').twitterSearch({
term: 'lottomax',
title: 'Lotto',
titleLink: '',
			bird: true, 
			birdSrc: 'images/tweet.gif', 
			birdLink: 'http://www.twitter.com',
			avatar: true,
			anchors: true,
			animOutSpeed: 500,
			animInSpeed: 500,
			pause: true,	
			time: true,
			timeout: 4000,
		css: { 
		a:     { textDecoration: 'none', color: '#990000', fontWeight: 'normal'},
		container: { backgroundColor: '#ffffcc' },
		frame: { border: '10px solid #ff9933', borderRadius: '10px', '-moz-border-radius': '10px', '-webkit-border-radius': '10px' },
		img:   { width: '30px', height: '30px' },
		loading: { color: '#000000' },
		text:  {fontWeight: 'normal', fontSize: '12px', color:'#000000'},
		time:  { fontSize: '12px', color: '#66cccc' },
		title: { backgroundColor: '#ffcc66', padding: '0px 0 0px 0', textAlign: 'center', fontWeight: 'bold', fontSize: '14px'},
		titleLink: { textDecoration: 'none', color: '#000066' },
		user:  { fontSize: '12px'},
		fail:  { background: '#6cc5c3 url(/images/failwhale.png) no-repeat 50% 50%'}
		} }); });";
$smarty->assign("JSOut", $htmlJSOut);
$page_generated = date("l dS \of F Y h:i:s A");
$smarty->assign("PageGenerated", $page_generated);

$smarty->assign("CSSOut", $htmlCSSOut);
$smarty->assign("htmlOut", $htmlOut);
$smarty->display('templates/welcome.tpl');


?>
