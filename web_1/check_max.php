<?php
/*
 * 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.

*/
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
  $objUser = new User();
  $objLottery = new Lottery();
  $objDate    = new GenDates();
  $naLottery  = new NALottery();
  $objAnalytics   = new Analytics();
  
  if ($_SESSION['valid']) {
    $iuserNo    = $_SESSION['userid'];
    $sNickName  = $_SESSION['_nickname'];
    $ds_user    = $objUser->UserGet($iuserNo);
    //print_r($ds_user);
    if (is_array($ds_user)) {
      $bLoggedIn = true;
    }
  }  
  
  $objForm = new ValidForm("UserLoginForm", "Required fields are printed in bold.");
         $objLottoMax = $objForm->addArea("Validate Max", false, "validate_max");

  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $objLottoMax->addField("NA_Max", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => true,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00",
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
  
   $objst_drawdate = $objLottoMax->addMultiField("START DRAW DATE");
    
    $naMAX_row = $objLottery->dbLotteryGamesGet("naMAX");
    
    if ($naMAX_row["drawStartDate"] != null) {
      $sGameStartDate = $naMAX_row["drawStartDate"];
    } else {
      $sGameStartDate = "1982-06-12";
    }
    
    if ($naMAX_row["validateDrawDate"] != null) {
      $sGameValidationAvailFrom = $naMAX_row["validateDrawDate"];
    } else {
      $sGameValidationAvailFrom = "2009-04-17";
    }
  $st_valid_year = date('Y',strtotime($sGameValidationAvailFrom));
  $st_valid_year_till = date('Y');
  $ed_valid_year = $st_valid_year;
  $ed_valid_year_till = $st_valid_year;
  $objst_drawdate->addField("st_DrawYear", VFORM_SELECT_LIST,
    array(
      "required" => true
    ),
    array("required" => "Select a year"),
    array(

      "start" => intval($st_valid_year),
      "end" => intval($st_valid_year_till))
  );
  
  $objst_drawdate->addField("st_DrawMonth",  VFORM_SELECT_LIST,
    array(
      "required" => true),
    array(
      "required" => "Select A Month"
    ),
    array(
      "start" => 1,
      "end" => 12)
  
  );
  
  $objst_drawdate->addField("st_DrawDay",  VFORM_SELECT_LIST,
    array(
      "required" => true
    ),
    array(
      "required" => "Select a Day"),
    array(
      "start" => 1,
      "end" => 31)
  
  );
  
  
  
  $obj_MultiDraw = $objForm->addArea("Multiple Draws", true, "multi_draw", false);
  
  $obj_2ndMaxNum = $objForm->addArea("Check Additional Max Numbers", true, "addMaxnums", false);
    
  $obj_2ndMaxNum->addField("NA_Max_2", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
     
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
  
  $obj_2ndMaxNum->addField("NA_Max_3", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
     
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
    
  $obj_2ndMaxNum->addField("NA_Max_4", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
     
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
  
  $obj_2ndMaxNum->addField("NA_Max_5", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
     
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
  
  $obj_2ndMaxNum->addField("NA_Max_6", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
     
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
  
  $obj_2ndMaxNum->addField("NA_Max_7", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
     
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
  
  $obj_2ndMaxNum->addField("NA_Max_8", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
     
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
  
  $obj_2ndMaxNum->addField("NA_Max_9", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
     
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
  
  $obj_2ndMaxNum->addField("NA_Max_10", "Lotto Max Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){6}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Max number.",
          "minLength" => "A Lotto Max number is at least %s characters long.",
          "maxLength" => "A Lotto Max number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
     
          "tip" => "Lotto Max number ex. 00-00-00-00-00-00-00"
      )
  );
  

  
  $objed_drawdate = $obj_MultiDraw->addMultiField("END DRAW DATE");
  
 
  $objed_drawdate->addField("ed_DrawYear", VFORM_SELECT_LIST,
    array(
      "required" => true
    ),
    array("required" => "Select a year"),
    array(
      "start" => 1982,
      "end" => 2011)
  );
  
  $objed_drawdate->addField("ed_DrawMonth",  VFORM_SELECT_LIST,
    array(
      "required" => true),
    array(
      "required" => "Select A Month"
    ),
    array(
      "start" => 1,
      "end" => 12)
  
  );
  
  $objed_drawdate->addField("ed_DrawDay",  VFORM_SELECT_LIST,
    array(
      "required" => true
    ),
    array(
      "required" => "Select a Day"),
    array(
      "start" => 1,
      "end" => 31)
  
  );
  
  $objForm->setMainAlert("One or more errors occurred. Check the marked fields and try again.");
  $objForm->setSubmitLabel("Submit");
      
  $strOutput = "";
   
  if ($objForm->isSubmitted() && $objForm->isValid()) {
      
      $objst_drdt_ar = $objst_drawdate->getFields();
      $objed_drdt_ar = $objed_drawdate->getFields();
      
      $lotto_select_list = array();
     $lotto_select_list[0] = $objForm->getValidField("NA_Max")->getValue();
     $st_drawdate = date('Y-m-d',mktime(0,0,0,$objst_drdt_ar[1]->getValue(),$objst_drdt_ar[2]->getValue(),$objst_drdt_ar[0]->getValue()));
     if ($objed_drdt_ar[0]->getValue() != "" && $objed_drdt_ar[1]->getValue() != "" && $objed_drdt_ar[2]->getValue() != "") {
       $ed_drawdate = date('Y-m-d', mktime(0,0,0,$objed_drdt_ar[1]->getValue(), $objed_drdt_ar[2]->getValue(), $objed_drdt_ar[0]->getValue()));
     } else {
       $ed_drawdate = $st_drawdate;
     }
     $iselection_cnt = 1;
     for ($i = 2; $i <= 10; $i++) {
       if ($objForm->getValidField("NA_Max_" . $i)->getValue() != "") {
         $lotto_select_list[$iselection_cnt] = $objForm->getValidField("NA_Max_" . $i)->getValue();
         $iselection_cnt++;
       }
     }
     
     $na_max_nums_ar = null;
     $lotto_validat_res = array();
     $ivalidat_cnt = 0;
     foreach ($lotto_select_list as $single_lotto_num) {
          if (preg_match("/\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*/i",$single_lotto_num, $na_max_match)) {
     
            $na_max_nums_ar = array($na_max_match[1], $na_max_match[2], $na_max_match[3], $na_max_match[4], $na_max_match[5], $na_max_match[6], $na_max_match[7]);
            sort($na_max_nums_ar, SORT_ASC);
            
            $scomb_num = array_unique($na_max_nums_ar);
           
            $lotto_validat_res[$ivalidat_cnt] = array();
            $lotto_validat_res[$ivalidat_cnt]["played_nums"] = $na_max_nums_ar;
          
            if (count($scomb_num) == 7) {
              $lotto_validat_res[$ivalidat_cnt]["validation_res"] = $naLottery->naMaxValidateDraw($st_drawdate, $ed_drawdate, $na_max_nums_ar[0], $na_max_nums_ar[1], $na_max_nums_ar[2], $na_max_nums_ar[3], $na_max_nums_ar[4], $na_max_nums_ar[5], $na_max_nums_ar[6]);
              $ivalidat_cnt++;
            }
          }
      
     } 
      //print_r($lotto_validat_res);
      //*** HTML body of the email.
      
  
      //*** Send the email.
     // mail("owner@awesomesite.com", "Contact form submitted", $strMessage, $strHeaders);
           
      //*** Set the output to a friendly thank you note.
      //$strOutput = $objForm->valuesAsHtml();
      
      //$strOutput = $objForm->getValidField("email").
      
      
      
  } else {
      //*** The form has not been submitted or is not valid.
      $strOutput = $objForm->toHtml();
  }
  
      $data_avail = $naLottery->naMaxGetFirstLastDataAvail();
  
      



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head>
<title>TSWeb Lotto Center</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="../inc/validform/css/validform.css" />
<script type="text/javascript" src="../inc/validform/libraries/jquery.js"></script>
<script type="text/javascript" src="../inc/validform/libraries/validform.js"></script>
<style type="text/css">
input.vf__button {
  float: left;
  width: auto;
  border: 1px solid #ccc;
  padding: 3px 6px;
  font: normal 12px Arial, Helvetica, sans-serif;
  color: #000;
  cursor: pointer;
  background-color: #efefef;
  text-decoration: none;
}

div#top_nav_bar {
  float: center;
  border: 1px solid #ccc;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;
  

}
div#top_wel_msg {
  float: right;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;
  

}
</style>
<link type="text/css" rel="stylesheet" href="css/view_649.css" />


</head>
<body>
<div id="top_nav_bar">
<p align="center">
[ <a href="check_649.php">Lotto 649</a> | <a href="check_max.php">Lotto Max</a> ] <br />
[ <a href="check_encore.php">Ontario Encore</a> | <a href="check_poker.php">Ontario Poker</a> | <a href="check_keno.php">Ontario Keno</a> | <a href="check_49.php">Ontario 49</a>  | <a href="check_lottario.php">Lottario</a> |  <a href="check_pick3.php">Pick 3</a> | <a href="check_pick4.php">Pick 4</a> ] </p>
<br />
[ <a href="view_649.php">Lotto 649</a> | <a href="view_max.php">Lotto Max</a> ] 
[ <a href="view_encore.php">Ontario Encore</a> | <a href="view_poker.php">Ontario Poker</a> | <a href="view_keno.php">Ontario Keno</a> | <a href="view_49.php">Ontario 49</a>  | <a href="view_lottario.php">Lottario</a> |  <a href="view_pick3.php">Pick 3</a> | <a href="view_pick4.php">Pick 4</a> ] </p>
<br />
[ <a href="view_649_winnings.php">Lotto 649</a> | <a href="view_max_winnings.php">Lotto Max</a> ] 
[ <a href="view_encore_winnings.php">Ontario Encore</a> | <a href="view_poker_winnings.php">Ontario Poker</a> | <a href="view_keno_winnings.php">Ontario Keno</a> | <a href="view_49_winnings.php">Ontario 49</a>  | <a href="view_lottario_winnings.php">Lottario</a> |  <a href="view_pick3_winnings.php">Pick 3</a> | <a href="view_pick4_winnings.php">Pick 4</a> ] </p>
<br />

</div>
<div id="top_wel_msg">
<?php if ($bLoggedIn == true) {?> Hi <?php echo $sNickName;?> | <a href="user_logout.php">Logout</a><?php } else { ?>
Hi Guest | <a href="user_login.php">Login</a> <?php } 

if (is_array($data_avail)) {
    print "<br />Data Available from " . date('Y-m-d',strtotime($data_avail["earliest"])) . " till " . date('Y-m-d',strtotime($data_avail["latest"]));
}

?>
</div>

<table border="0">


<?php

if (is_array($lotto_validat_res)) {
  $icur_game_cnt = 0;
  foreach ($lotto_validat_res as $lotto_single_game) {
    
    if (is_array($lotto_single_game["validation_res"])) {
    
      foreach ($lotto_single_game["validation_res"] as $s_single_match) {
     
    ?>
    <tr>
    <td><?php print date('Y-m-d',strtotime($s_single_match["drawdate"]));?></td>
     <td><?php 
    
          $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            //print_r($s_single_match);
            if ($snum == $lotto_single_game["played_nums"][0]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][0] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][0] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][0] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][0] . "</span>";
          }
          ?>
      </td>
    <td><?php 
    
          $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][1]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][1] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][1] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][1] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][1] . "</span>";
          }
          ?></td>
    <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][2]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][2] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][2] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][2] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][2] . "</span>";
          }
         ?>
    </td>
    <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][3]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][3] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][3] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][3] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][3] . "</span>";
          }      ?>
    </td>
    <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][4]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][4] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][4] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][4] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][4] . "</span>";
          }      ?>
    </td>
    <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][5]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][5] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][5] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][5] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][5] . "</span>";
          }
          ?>
    </td>
    <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][6]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][6] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][6] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][6] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][6] . "</span>";
          }
          ?>
    </td>
    
    <td><?php 
      if ($s_single_match["win_prze_amount"] > 0) {
        print " - <span class='win_amt'>$" . money_format('%(#12n',$s_single_match["win_prze_amount"]) . "</span><br />";
      }
    
    ?>
    </td>
    <td>Draw Numbers: <?php print $s_single_match["draw_numbers"][0] . " - " . $s_single_match["draw_numbers"][1] . " - " . $s_single_match["draw_numbers"][2] . " - " . $s_single_match["draw_numbers"][3] . " - " . $s_single_match["draw_numbers"][4] . " - " . $s_single_match["draw_numbers"][5] . " - " . $s_single_match["draw_numbers"][6] . " - B: " . $s_single_match["draw_bonus"]; ?> </td>
    
    </tr>
      
    <?php
      } 
    }
    $icur_game_cnt++;
  }
}
?>
</table>
<table border="0">
<tr>
<td ><?php echo $strOutput ?></td>
<td>&nbsp;</td>
</tr></table>
<?php print $objAnalytics->GoogleAnalytics(); ?>

</body>
</html>


