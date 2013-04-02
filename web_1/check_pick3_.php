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
  require_once("../../../libraries/ValidForm/class.validform.php");
  include_once("../../class_db.php");
  include_once("../../incGenDates.php");
  include_once("../../incALCLottery.php");
  include_once("../../incNaLottery.php");
  include_once("../../incLottery.php");
  include_once("../../incOLGLottery.php");
  include_once("../../class_http.php");
  require_once("../../incUser.php");
  
  
  $sNickName = "";
  $bLoggedIn = false;
  $objUser = new User();
  $objLottery = new Lottery();
  $objDate    = new GenDates();
  $OLGLottery  = new OLGLottery();
  
  if (isset($_SESSION['_LoggedIn']) && ($_SESSION['_LoggedIn'] == "yes")) {
    $iuserNo    = $_SESSION['_userNo'];
    $sNickName  = $_SESSION['_nickname'];
    $ds_user    = $objUser->UserGet($iuserNo);
    print_r($ds_user);
    if (is_array($ds_user)) {
      $bLoggedIn = true;
    }
  }

  $objForm = new ValidForm("Check_Pick4", "Required fields are printed in bold.");
     $objLottoPick3 = $objForm->addArea("Validate Pick 3", false, "validate_Pick3");

  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $objLottoPick3->addField("OLG_Pick3", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => true,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "0-0-0",
          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
  $objst_drawdate = $objLottoPick3->addMultiField("START DRAW DATE");
  $onPick3_row    = $objLottery->dbLotteryGamesGet("onPick3");
  if ($onPick3_row["drawStartDate"] != null) {
    $sGameStartDate = $onPick3_row["drawStartDate"];
  } else {
    $sGameStartDate = "1982-06-12";
  }
  
  if ($onPick3_row["validateDrawDate"] != null) {
    $sGameValidationAvailFrom = $onPick3_row["validateDrawDate"];
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
  
  
  $objed_drawdate = $obj_MultiDraw->addMultiField("END DRAW DATE");
  
  $obj_2ndPick3 = $objForm->addArea("Check Additional Pick 3 Numbers", true, "addPick4Nums", false);
  
   $obj_2ndPick3->addField("OLG_Pick3_2", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
   $obj_2ndPick3->addField("OLG_Pick3_3", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
   $obj_2ndPick3->addField("OLG_Pick3_4", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
   $obj_2ndPick3->addField("OLG_Pick3_5", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
   $obj_2ndPick3->addField("OLG_Pick3_6", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
   $obj_2ndPick3->addField("OLG_Pick3_7", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
   $obj_2ndPick3->addField("OLG_Pick3_8", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
   $obj_2ndPick3->addField("OLG_Pick3_9", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
   $obj_2ndPick3->addField("OLG_Pick3_10", "Pick 3", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 3 number.",
          "minLength" => "A Pick 3 number is at least %s characters long.",
          "maxLength" => "A Pick 3 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 3 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 3 number ex. 0-0-0"
      )
  );
  
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
     $lotto_select_list[0] = $objForm->getValidField("Pick_3")->getValue();
     $st_drawdate = date('Y-m-d',mktime(0,0,0,$objst_drdt_ar[1]->getValue(),$objst_drdt_ar[2]->getValue(),$objst_drdt_ar[0]->getValue()));
     if ($objed_drdt_ar[0]->getValue() != "" && $objed_drdt_ar[1]->getValue() != "" && $objed_drdt_ar[2]->getValue() != "") {
       $ed_drawdate = date('Y-m-d', mktime(0,0,0,$objed_drdt_ar[1]->getValue(), $objed_drdt_ar[2]->getValue(), $objed_drdt_ar[0]->getValue()));
     } else {
       $ed_drawdate = $st_drawdate;
     }
     $iselection_cnt = 1;
     for ($i = 2; $i <= 10; $i++) {
       if ($objForm->getValidField("Pick_3_" . $i)->getValue() != "") {
         $lotto_select_list[$iselection_cnt] = $objForm->getValidField("Pick_3_" . $i)->getValue();
         $iselection_cnt++;
       }
     }
     
     $on_pick4_nums_ar    = null;
     $lotto_validat_res   = array();
     $ivalidat_cnt        = 0;
     foreach ($lotto_select_list as $single_lotto_num) {
       
       if (preg_match("/(\d)-(\d)-(\d)-(\d)/i", $single_lotto_num, $on_pick3_match)) {
         $on_pick3_nums_ar = array($on_pick3_match[1], $on_pick3_match[2], $on_pick3_match[3]);
         $lotto_validat_res[$ivalidat_cnt] = array();
         $lotto_validat_res[$ivalidat_cnt]["played_nums"] = $on_pick3_nums_ar;
         $play_type_any    = 2;
         if (count($scomb_num) == 3) {
           $lotto_validat_res[$ivalidat_cnt]["validation_res"] = $OLGLottery->OLGPick4ValidateDraw($drawdate,$play_type_any, $on_pick3_nums_ar[0], $on_pick3_nums_ar[1], $on_pick3_nums_ar[2]);
           $ivalidat_cnt++;
         }
       }
     }
  
      
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
  

    



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head>
<title>TSWeb Lotto Center</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="../../../css/validform.css" />
<script type="text/javascript" src="../../../libraries/jquery.js"></script>
<script type="text/javascript" src="../../../libraries/validform.js"></script>
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
Hi Guest | <a href="user_login.php">Login</a> <?php } ?>
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
    <td>
      <?php
      $b_win_num_match = false;
      foreach ($s_single_match["match_numbers"] as $snum) {
        if ($snum == $lotto_single_game["played_nums"][0]) {
          $b_win_num_match = true;
          break;
        } 
        
      }
      if ($b_win_num_match) {
        print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][0] . "</span>";
      } else {
        print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][0] . "</span>";
      }
      
      $b_win_num_match = false;
      foreach ($s_single_match["match_numbers"] as $snum) {
        if ($snum == $lotto_single_game["played_nums"][1]) {
          $b_win_num_match = true;
          break;
        } 
        
      }
      if ($b_win_num_match) {
        print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][1] . "</span>";
      } else {
        print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][1] . "</span>";
      }
      
      $b_win_num_match = false;
      foreach ($s_single_match["match_numbers"] as $snum) {
        if ($snum == $lotto_single_game["played_nums"][2]) {
          $b_win_num_match = true;
          break;
        } 
        
      }
      if ($b_win_num_match) {
        print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][2] . "</span>";
      } else {
        print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][2] . "</span>";
      }
      
      ?>
      </td>
      <td>
      <?php
      if ($s_single_match["win_prze_straight_amount"] > 0) {
        print "Straight Win - <span class='win_amt'>$" . money_format('%(#12n',$s_single_match["win_prze_straight_amount"]) . "</span><br />";
      }
      ?>
    </td>
    <td>
    <?php
      if ($s_single_match["win_prze_box_amount"] > 0) {
        print "Straight Win - <span class='win_amt'>$" . money_format('%(#12n',$s_single_match["win_prze_box_amount"]) . "</span><br />";
      }
      ?>
    </td>
    <td> Draw Numbers: 
    <?php
    $i_draw_pos = 0;
    foreach ($s_single_match["draw_numbers"] as $snum) {
       print $snum; 
       if ($i_draw_pos < 2) {
         print " - ";
       }
       $i_draw_pos++;
    }
    ?>
    </td>
    </tr>
    
    
    
      
    <?php
      } 
    }
    $icur_game_cnt++;
  }
}
?>



<tr>
<td ><?php echo $strOutput ?></td>
<td>&nbsp;</td>
</tr></table>


</body>
</html>


