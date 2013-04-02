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
  
   $sNickName     = "";
  $bLoggedIn      = false;
  $objUser        = new User();
  $objLottery     = new Lottery();
  $objDate        = new GenDates();
  $OLGLottery     = new OLGLottery();
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
  
  /*print_r($_SESSION);
  print "\nLogged - " . $_SESSION['_userNo'] . $_SESSION['_nickname'] . $_SESSION['_LoggedIn'];
  if ($_SESSION['_LoggedIn'] != "yes") {
    ///header("Location: user_login.php\n\n"); 
  } else {
    $iuserNo    = $_SESSION['_userNo'];
    $sNickName  = $_SESSION['_nickname'];
    $ds_user    = $objUser->UserGet($iuserNo);
    
    if (!is_array($ds_user)) {
      //header("Location: user_login.php\n\n"); 
    }
  }*/

  $objForm = new ValidForm("Check_49", "Required fields are printed in bold.");
  $objLotto49 = $objForm->addArea("Validate 49", false, "validate_49");
  
  
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $objLotto49->addField("OLG_49", "Lotto 49 Numbers", VFORM_CUSTOM,
      array(
          "required" => true,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 49 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );
  
   $objst_drawdate = $objLotto49->addMultiField("START DRAW DATE");
    
  
  $on49_row = $objLottery->dbLotteryGamesGet("on49");
  if ($on49_row["drawStartDate"] != null) {
    $sGameStartDate = $on49_row["drawStartDate"];
  } else {
    $sGameStartDate = "1982-06-12";
  }
  
  if ($on49_row["validateDrawDate"] != null) {
    $sGameValidationAvailFrom = $on49_row["validateDrawDate"];
  } else {
    $sGameValidationAvailFrom = "2009-04-17";
  }
  $st_valid_year = date('Y',strtotime($sGameValidationAvailFrom));
  $st_valid_year_till = date('Y');
  $ed_valid_year = $st_valid_year;
  $ed_valid_year_till = $st_valid_year;
  
  /*print "<br /> valid Year: " . $st_valid_year . " -- " . $sGameValidationAvailFrom;
  print "<br /> valid Year: " . $ed_valid_year . " -- " . $sGameValidationAvailFrom;
  print "<br /> valid Year: " . $st_valid_year_till . " -- " . $sGameValidationAvailFrom;
  */
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
  
  $obj_2nd649Num = $objForm->addArea("Check Additional 49 Numbers", true, "add49nums", false);
  
  $obj_2nd649Num->addField("OLG_49_2", "Lotto 49 Number", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 49 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
        //  "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );
  $obj_2nd649Num->addField("OLG_49_3", "Lotto 49 Number", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
        //  "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );

   $obj_2nd649Num->addField("OLG_49_4", "Lotto 49 Number", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 49 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         // "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );
 
   $obj_2nd649Num->addField("OLG_49_5", "Lotto 49 Number", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 49 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
        //  "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );
 
   $obj_2nd649Num->addField("OLG_49_6", "Lotto 49 Number", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 49 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
        ///  "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );
 
   $obj_2nd649Num->addField("OLG_49_7", "Lotto 49 Number", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 49 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         // "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );
 
   $obj_2nd649Num->addField("OLG_49_8", "Lotto 49 Number", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 49 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         // "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );
 
   $obj_2nd649Num->addField("OLG_49_9", "Lotto 49 Number", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 49 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         // "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );
 
   $obj_2nd649Num->addField("OLG_49_10", "Lotto 49 Number", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 49 number.",
          "minLength" => "A Lotto 49 number is at least %s characters long.",
          "maxLength" => "A Lotto 49 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 49 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         // "hint" => "00-00-00-00-00-00",
          "tip" => "Lotto 49 number ex. 00-00-00-00-00-00"
      )
  );
 
  $objed_drawdate->addField("ed_DrawYear", VFORM_SELECT_LIST,
    array(
      "required" => true
    ),
    array("required" => "Select a year"),
    array(
      "start" => intval($st_valid_year),
      "end" => intval($st_valid_year_till))
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
   
  // print "Form Valid: " . $objForm->isValid() . " --- " . $objForm->isSubmitted(); 
   
  if ($objForm->isSubmitted() && $objForm->isValid()) {
    
    //print "\n<br /> Testing ";
    //print "<br />Testing ";
    //print_r($objst_drawdate);
   // print_r($objed_drawdate);
   //print_r($objForm->getValidField("NA_649")->getValue());
   $objst_drdt_ar = $objst_drawdate->getFields();
   /*foreach ($objst_drdt_ar as $objst_field) {
     print "\n<br />" . $objst_field->getValue();
     
   }*/
   
   $objed_drdt_ar = $objed_drawdate->getFields();
   /*foreach ($objed_drdt_ar as $objst_field) {
     print "\n<br />" . $objst_field->getValue();
     
   }*/
   $lotto_select_list = array();
   $lotto_select_list[0] = $objForm->getValidField("OLG_49")->getValue();
   $st_drawdate = date('Y-m-d',mktime(0,0,0,$objst_drdt_ar[1]->getValue(),$objst_drdt_ar[2]->getValue(),$objst_drdt_ar[0]->getValue()));
   if ($objed_drdt_ar[0]->getValue() != "" && $objed_drdt_ar[1]->getValue() != "" && $objed_drdt_ar[2]->getValue() != "") {
     $ed_drawdate = date('Y-m-d', mktime(0,0,0,$objed_drdt_ar[1]->getValue(), $objed_drdt_ar[2]->getValue(), $objed_drdt_ar[0]->getValue()));
   } else {
     $ed_drawdate = $st_drawdate;
   }
   $iselection_cnt = 1;
   for ($i = 2; $i <= 10; $i++) {
     if ($objForm->getValidField("OLG_49_" . $i)->getValue() != "") {
       $lotto_select_list[$iselection_cnt] = $objForm->getValidField("OLG_49_" . $i)->getValue();
       $iselection_cnt++;
     }
   }
   
   //print "\nTesting 2: ";
   //print_r($lotto_select_list);
   $on_49_nums_ar = null;
   $lotto_validat_res = array();
   $ivalidat_cnt = 0;
   foreach ($lotto_select_list as $single_lotto_num) {
       print "testing 3: ";
     if (preg_match("/\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*/i",$single_lotto_num, $on_49_match)) {
           //mktime()
           print "testing 4: ";
        //print_r($on_49_match);
       //  print "\n<br />Start Date: " . $st_drawdate . " ---- " . $ed_drawdate;
         $on_49_nums_ar = array($on_49_match[1],$on_49_match[2],$on_49_match[3],$on_49_match[4],$on_49_match[5],$on_49_match[6]);
        // print "\n\n<br />Testing --- ";
        // print_r($na_649_nums_ar);
       // print_r($on_49_nums_ar);
         sort($on_49_nums_ar,SORT_ASC);
         
         //print_r($on_49_nums_ar);
        // print "\n\n<br />Testing 2--- ";
         $scomb_num = array_unique($on_49_nums_ar);
        // print_r($scomb_num);
        //  print "\n\n<br />Testing 3--- " . count($scomb_num);
        $lotto_validat_res[$ivalidat_cnt] = array();
        $lotto_validat_res[$ivalidat_cnt]["played_nums"] = $on_49_nums_ar;
         if (count($scomb_num) == 6) {
         //   print "\n\n<br />Testing 4--- ";
           $lotto_validat_res[$ivalidat_cnt]["validation_res"] = $OLGLottery->OLG49ValidateDraw($st_drawdate, $ed_drawdate, $scomb_num[0] , $scomb_num[1] , $scomb_num[2] , $scomb_num[3] , $scomb_num[4]  , $scomb_num[5] );
           $ivalidat_cnt++;
         }
      /*  print_r($validation_res);       
        print_r($na_649_match);
       */
       
       
       
     }
   }
  //print_r($lotto_validat_res);
//   print_r($objst_drawdate->getFields());
//     print    "<br /> $st_DrawDay " .  $objForm->getValidField("st_DrawDay")->getValue();
    
    //if ($objForm->getValidField("ed_DrawDay")->getValue() != null) {
    //  print "<br />Ed Draw Day " . $objForm->getValidField("ed_DrawDay")->getValue();
    //}
    
    //print "<br /> Multi Draw " . $objForm->getValidField("multi_draw")->getValue();
       /*
    if ($objForm->getValidField("multi_draw")->getValue() == true) {
    
    print    "<br /> $ed_DrawDay   = " .  $objForm->getValidField("ed_DrawDay")->getValue();
    print    "<br /> $ed_DrawMonth = " . $objForm->getValidField("ed_DrawMonth")->getValue();
    print    "<br /> $ed_DrawYear  = " . $objForm->getValidField("ed_DrawYear")->getValue();
    
      $ed_DrawDay   = $objForm->getValidField("ed_DrawDay")->getValue();
      $ed_DrawMonth = $objForm->getValidField("ed_DrawMonth")->getValue();
      $ed_DrawYear  = $objForm->getValidField("ed_DrawYear")->getValue();  
    }
     print    "<br /> $st_DrawDay " .  $objForm->getValidField("st_DrawDay")->getValue();
    print    "<br /> $st_DrawMonth =  " .  $objForm->getValidField("st_DrawMonth")->getValue();
    print    "<br /> $st_DrawYear  = " . $objForm->getValidField("st_DrawYear")->getValue();
     
    $st_DrawDay   = $objForm->getValidField("st_DrawDay")->getValue();
    $st_DrawMonth = $objForm->getValidField("st_DrawMonth")->getValue();
    $st_DrawYear  = $objForm->getValidField("st_DrawYear")->getValue();
    
    
    print "\n<br />" . $objForm->getValidField("multi_draw");
    printf("\n<br />%u - %u - %u ----> %u - %u - %u", $st_DrawDay,
          $st_DrawMonth, $st_DrawYear,
          $ed_DrawDay, $ed_DrawMonth, 
          $ed_DrawYear);
    print "\n<br />" . $objForm->getValidField("NA_649")->getValue();
    
      //*** HTML body of the email.
      
    */
      //*** Send the email.
     // mail("owner@awesomesite.com", "Contact form submitted", $strMessage, $strHeaders);
           
      //*** Set the output to a friendly thank you note.
      //$strOutput = $objForm->valuesAsHtml();
      
      //$strOutput = $objForm->getValidField("email").
      
      
      
  } else {
      //*** The form has not been submitted or is not valid.
      $strOutput = $objForm->toHtml();
  }
  
  
     
    $data_avail = $OLGLottery->OLG49GetFirstLastDataAvail();
      

//ob_flush();
//ob_end_clean();

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
<h3>Validate</h3>
[ <a href="check_649.php">Lotto 649</a> | <a href="check_max.php">Lotto Max</a> ] 
[ <a href="check_encore.php">Ontario Encore</a> | <a href="check_poker.php">Ontario Poker</a> | <a href="check_keno.php">Ontario Keno</a> | <a href="check_49.php">Ontario 49</a>  | <a href="check_lottario.php">Lottario</a> |  <a href="check_pick3.php">Pick 3</a> | <a href="check_pick4.php">Pick 4</a> ] </p>
<br />
<h3>View Numbers</h3>
[ <a href="view_649.php">Lotto 649</a> | <a href="view_max.php">Lotto Max</a> ] 
[ <a href="view_encore.php">Ontario Encore</a> | <a href="view_poker.php">Ontario Poker</a> | <a href="view_keno.php">Ontario Keno</a> | <a href="view_49.php">Ontario 49</a>  | <a href="view_lottario.php">Lottario</a> |  <a href="view_pick3.php">Pick 3</a> | <a href="view_pick4.php">Pick 4</a> ] </p>
<br />
<h3>View Winnings</h3>
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
    <td><?php 
      if ($s_single_match["win_prze_amount"] > 0) {
        print " - <span class='win_amt'>$" . money_format('%(#12n',$s_single_match["win_prze_amount"]) . "</span><br />";
      }
    
    ?></td>
    <td>Draw Numbers: <?php print $s_single_match["draw_numbers"][0] . " - " . $s_single_match["draw_numbers"][1] . " - " . $s_single_match["draw_numbers"][2] . " - " . $s_single_match["draw_numbers"][3] . " - " . $s_single_match["draw_numbers"][4] . " - " . $s_single_match["draw_numbers"][5] . " - " . $s_single_match["draw_numbers"][0] . " - B: " . $s_single_match["draw_bonus"]; ?> </td>
    
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

  
