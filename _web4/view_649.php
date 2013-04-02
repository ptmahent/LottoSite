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
  require_once("../inc/incXML.php");
  
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
    $sGameStartDate = "2009-04-10";
  }
  

 
 
 $data_avail = $naLottery->na649GetFirstLastDataAvail();
 print assocToXML ($data_avail, 2);
$db_res = $naLottery->na649GetDraw($st_date, $ed_date, $st_row_num, $ed_row_num);
//print_r($db_res);
if (is_array($db_res)) {
  
  print assocToXML ($db_res, 2);
}

