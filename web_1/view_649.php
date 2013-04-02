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
  $naLottery  = new NALottery();
  
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
  
  $na649_row = $objLottery->dbLotteryGamesGet("na649");
  if ($na649["drawStartDate"] != null) {
    $sGameStartDate = $na649["drawStartDate"];
  } else {
    $sGameStartDate = "1982-06-12";
  }
  
  
  //$sSelectedDate = mktime(0,0,0,date('m'),date('d'),date('Y'));
  
  
  ?>
  


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head>
<title>TSWeb Lotto Center</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="../inc/validform/css/validform.css" />
<script type="text/javascript" src="../inc/validform/libraries/jquery.js"></script>
<script type="text/javascript" src="../inc/validform/libraries/validform.js"></script>
<script type="text/javascript">
  
  $(document).ready(function () {
    $("#nav_years span").click(function () {
      
      $("#nav_year_" + frmViewLotto.st_year.value).css("color","#AC3537");
      $("#nav_year_" + frmViewLotto.st_year.value).css("border","none");
      frmViewLotto.st_year.value = $(this).text();
      $("#nav_year_" + frmViewLotto.st_year.value).css("color","#405BA2");
      $("#nav_year_" + frmViewLotto.st_year.value).css("border", "1px solid #CF9B00");
      $("#nav_months").css("visibility", "visible");
      
    
    });  
  
   $("#nav_months span").click(function () {
      var nv_month = "nav_month_";
      $("#" + nv_month + frmViewLotto.st_month.value).css("color","#AC3537");
      $("#" + nv_month + frmViewLotto.st_month.value).css("border","none");
      frmViewLotto.st_month.value = $(this).attr("id").substring(nv_month.length);
      $("#" + nv_month + frmViewLotto.st_month.value).css("color","#405BA2");
      $("#" + nv_month + frmViewLotto.st_month.value).css("border", "1px solid #CF9B00");
      $("#nav_disp_limit").css("visibility", "visible");
   });
  
   $("#nav_disp_limit span").click(function () {
      var nv_disp_limit = "nav_disp_limit_";
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("color","#AC3537");
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("border","none");
      frmViewLotto.limit.value = $(this).attr("id").substring(nv_disp_limit.length);
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("color","#405BA2");
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("border", "1px solid #CF9B00");
      
   });
  });
 function setYear(intYear) {
  frmViewLotto.st_year.value = intYear;
  $("#nav_months").show("fast");
 }
 function setMonth(intMonth) {
  frmViewLotto.st_month.value = intMonth;
 }
 function setDay(intDay) {
  frmViewLotto.st_day.value = intDay;
 }
 function setLimit(intLimit) {
  frmViewLotto.limit.value = intLimit;
 }
 function setSortBy(strSort) {
  frmViewLotto.sort_by.value = strSort;
 }
 function setRowsPerPage(intRows) {
  frmViewLotto.rows_per_page.value = intRows;
 }
 function setPageNum(intPage) {
  frmViewLotto.page_num.value = intPage;
 }
</script>

<link type="text/css" rel="stylesheet" href="css/view_649.css" />

<style type="text/css">
body {
	background-color: #789103;
}
</style>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">



















<form name="frmViewLotto" method="get" action="view_649.php">
<input type="hidden" name="st_month" value="<?php print $st_month; ?>">
<input type="hidden" name="st_day" value="<?php print $st_day; ?>">
<input type="hidden" name="st_year" value="<?php print $st_year; ?>">
<input type="hidden" name="limit" value="<?php print $limit; ?>">
<input type="hidden" name="sort_by" value="<?php print $sort_by; ?>">
<input type="hidden" name="rows_per_page" value="<?php print $rows_per_page; ?>">
<input type="hidden" name="page_num" value="<?php print $page_num; ?>"> 

<table id="Table_01" width="1125" height="869" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="23">
			<img src="images/LottoWWW_01.png" width="1080" height="50" alt=""></td>
		<td rowspan="13">
			<img src="images/LottoWWW_02.png" width="44" height="868" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="50" alt=""></td>
	</tr>
	<tr>
		<td rowspan="12">
			<img src="images/LottoWWW_03.png" width="44" height="818" alt=""></td>
		<td rowspan="2">
			<img src="images/LottoWWW_04.png" width="6" height="148" alt=""></td>
		<td colspan="3" rowspan="2">
			<img src="images/logo1_lottosite.png" width="312" height="148" alt=""></td>
		<td rowspan="2">
			<img src="images/LottoWWW_06.png" width="17" height="148" alt=""></td>
		<td colspan="16" background="images/LottoWWW_06.png">

<div id="top_wel_msg">
<?php if ($bLoggedIn == true) {?> Hi <?php echo $sNickName;?> | <a href="user_logout.php">Logout</a><?php } else { ?>
Hi Guest | <a href="user_login.php">Login</a> <?php } ?>
</div>


</td>
		<td>
			<img src="images/LottoWWW_08.png" width="6" height="116" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="116" alt=""></td>
	</tr>
	<tr>
		<td colspan="2">
			<img src="images/LottoWWW_08-10.png" width="83" height="32" alt=""></td>
		<td colspan="3"><a href="check_649.php"><img src="images/nav1_btn_validate.png" alt="" width="140" height="32" border="0"></a></td>
		<td colspan="3"><a href="view_649.php"><img src="images/click/nav1_btn_click_view_numbers.png" alt="" width="146" height="32" border="0"></a></td>
		<td colspan="3"><a href="view_649_winnings.php"><img src="images/nav1_btn_viewwinnings.png" alt="" width="140" height="32" border="0"></a></td>
		<td colspan="3">
			<img src="images/nav1_btn_quickpick.png" width="115" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_11_01.png" width="54" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_11_02_01.png" width="17" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_11_02_02.png" width="6" height="32" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="32" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/LottoWWW_17.png" width="6" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_18.png" width="18" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_19.png" width="20" height="32" alt=""></td>
		<td colspan="2">
			<img src="images/LottoWWW_20.png" width="291" height="32" alt=""></td>
		<td colspan="3"><a href="view_max.php"><img src="images/nav2_btn_lottomax.png" alt="" width="106" height="32" border="0"></a></td>
		<td><a href="view_649.php"><img src="images/nav2_btn_lotto649.png" alt="" width="93" height="32" border="0"></a></td>
		<td colspan="2"><a href="view_49.php"><img src="images/nav2_btn_on49.png" alt="" width="44" height="32" border="0"></a></td>
		<td><a href="view_lottario.php"><img src="images/nav2_btn_lottario.png" alt="" width="81" height="32" border="0"></a></td>
		<td colspan="2"><a href="view_keno.php"><img src="images/nav2_btn_keno.png" alt="" width="65" height="32" border="0"></a></td>
		<td><a href="view_poker.php"><img src="images/nav2_btn_poker.png" alt="" width="67" height="32" border="0"></a></td>
		<td colspan="2"><a href="view_pick4.php"><img src="images/nav2_btn_pick4.png" alt="" width="72" height="32" border="0"></a></td>
		<td><a href="view_pick3.php"><img src="images/nav2_btn_pick3.png" alt="" width="67" height="32" border="0"></a></td>
		<td colspan="2">
			<img src="images/LottoWWW_29.png" width="83" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_30.png" width="17" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_31.png" width="6" height="32" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="32" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/LottoWWW_32.png" width="6" height="64" alt=""></td>
		<td>
			<img src="images/LottoWWW_33.png" width="18" height="64" alt=""></td>
		<td>
			<img src="images/LottoWWW_34.png" width="20" height="64" alt=""></td>
		<td colspan="17" rowspan="2" valign="top">


<div id="nav_years">
<?php 
  $dGameStartDate = strtotime($sGameStartDate);
  for ($i = date('Y', $dGameStartDate); $i <= date('Y'); $i++) {
    if ($i != date('Y', $dGameStartDate)) {
      print " | ";
    }  
    if ($i == date('Y', strtotime($st_date))) {
      printf("<span class='selected' id='nav_year_%u'>%u</span>", $i, $i);
    } else {
      printf("<span class='not-selected' id='nav_year_%u'>%u</span>", $i, $i);
    }
  }
  
?>
</div><br />
<div id="nav_months">
<?php
  for ($i = 1; $i <= 12; $i++) {
    if ($i != 1) {
      print " | ";
    }
    
    if (date('m',strtotime($st_date)) == $i) {
      if ($i < 10) {
        printf("<span class='selected' id='nav_month_0%u'>%s</span>", $i, $objDate->getMonthName($i));          
      } else {
        printf("<span class='selected' id='nav_month_%u'>%s</span>", $i, $objDate->getMonthName($i));      
      }
    } else {
      if ($i < 10) {
        printf("<span class='not-selected' id='nav_month_0%u'>%s</span>",$i, $objDate->getMonthName($i));
      } else {
        printf("<span class='not-selected' id='nav_month_%u'>%s</span>",$i, $objDate->getMonthName($i));
      }
    }  
  }
  ?>
</div>
<br />
<div id="nav_disp_limit">
  <span class='not-selected' id='nav_disp_limit_M'>Month</span> | <span class='not-selected' id='nav_disp_limit_Y'>Year</span> | <span class='not-selected' id='nav_disp_limit_100'>100 Draws</span> | <span class='not-selected' id='nav_disp_limit_200'>200 Draws</span>
</div>
<div id="nav_action">
  <span id='nav_act_submit'><input type="submit" name="action" value="submit" /></span>
</div>
<br />
<?php

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

?>
<div id="nav_draw_view_date">
</div>

</td>
		<td>
			<img src="images/LottoWWW_36.png" width="17" height="64" alt=""></td>
		<td>
			<img src="images/LottoWWW_37.png" width="6" height="64" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="64" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/LottoWWW_38.png" width="6" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_39.png" width="18" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_40.png" width="20" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_41.png" width="17" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_42.png" width="6" height="32" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="32" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/LottoWWW_43.png" width="6" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_44.png" width="18" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_45.png" width="20" height="32" alt=""></td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
		<td colspan="12">&nbsp;</td>
		<td>
			<img src="images/LottoWWW_49.png" width="17" height="32" alt=""></td>
		<td>
			<img src="images/LottoWWW_50.png" width="6" height="32" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="32" alt=""></td>
	</tr>
	<tr>
		<td rowspan="3">
			<img src="images/LottoWWW_51.png" width="6" height="421" alt=""></td>
		<td colspan="20" rowspan="2" bgcolor="#789103" valign="top">
        
        


<div id="game_draw_header">

</div>
<div id="game_draw_body">
<table border="0" colspan="0" width="100%">
<tr>
<td>Draw Date</td>
<td colspan="6">Winning Number</td>
<td>Bonus</td>
<td>Winnings</td>
</tr>
<?php
/*
print "st DT: " . $st_date;
print "\n ed DT: " . $ed_date;
print "\n stRowNum: " . $st_row_num;
print "\n edRowNum: " . $ed_row_num;
 * 
 */
$db_res = $naLottery->na649GetDraw($st_date, $ed_date, $st_row_num, $ed_row_num);
//print_r($db_res);
if (is_array($db_res)) {
  foreach ($db_res as $db_row) {
  ?>

<tr class="649Row">
<td><?php print date('Y-m-d',strtotime($db_row["drawdate"])); // drawdate ?></td>
<td><?php print $db_row["snum1"]; // NUM1 ?></td>
<td><?php print $db_row["snum2"]; // NUM2 ?></td>
<td><?php print $db_row["snum3"]; // NUM3 ?></td>
<td><?php print $db_row["snum4"]; // NUM4 ?></td>
<td><?php print $db_row["snum5"]; // NUM5 ?></td>
<td><?php print $db_row["snum6"]; // NUM6 ?></td>
<td><?php print $db_row["snumbonus"]; // BONUSNUM ?></td>
<td><?php // Link to Winning ?></td>
</tr>

<?php
  }
}

?>

</table>
</div>
<table border="0">
<tr>
</tr>
<td ><?php echo $strOutput ?></td>
<td>&nbsp;</td>
</tr></table>
<?php
  $objAnalytics   = new Analytics();
  print $objAnalytics->GoogleAnalytics();

?>

</td>
		<td>
			<img src="images/LottoWWW_53.png" width="6" height="418" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="418" alt=""></td>
	</tr>
	<tr>
		<td rowspan="3">
			<img src="images/LottoWWW_54.png" width="6" height="42" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="2" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="images/LottoWWW_38-56.png" width="18" height="40" alt=""></td>
		<td rowspan="2">
			<img src="images/LottoWWW_41-57.png" width="20" height="40" alt=""></td>
		<td colspan="17" rowspan="2">
			<img src="images/LottoWWW_40-58.png" width="969" height="40" alt=""></td>
		<td rowspan="2">
			<img src="images/LottoWWW_41-59.png" width="17" height="40" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="1" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/LottoWWW_59.png" width="6" height="39" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="39" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/LottoWWW_60.png" width="6" height="8" alt=""></td>
		<td colspan="20">
			<img src="images/LottoWWW_61.png" width="1024" height="8" alt=""></td>
		<td>
			<img src="images/LottoWWW_62.png" width="6" height="8" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="8" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/LottoWWW_63.png" width="6" height="42" alt=""></td>
		<td colspan="20">
			<img src="images/LottoWWW_64.png" width="1024" height="42" alt=""></td>
		<td>
			<img src="images/LottoWWW_65.png" width="6" height="42" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="42" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/spacer.gif" width="44" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="6" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="18" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="20" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="274" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="17" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="16" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="67" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="23" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="93" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="24" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="20" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="81" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="45" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="20" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="67" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="53" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="19" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="67" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="29" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="54" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="17" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="6" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="44" height="1" alt=""></td>
		<td></td>
	</tr>
</table>


</form>
</body>
</html>
