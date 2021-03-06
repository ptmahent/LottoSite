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
  $OLGLottery  = new OLGLottery();
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

  $objForm = new ValidForm("Check_Lottario", "Required fields are printed in bold.");
  $objLottoLottario = $objForm->addArea("Validate Lottario", false, "validate_Lottario");

   $objEb_Lottario = $objLottoLottario->addMultiField("Lottario , Early Bird");
    
  

  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $objEb_Lottario->addField("OLG_Lottario",  VFORM_CUSTOM,
      array(
          "required" => true,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00",
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
  );
  
      //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $objEb_Lottario->addField("Early_Bird",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00",
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
  );
  
  $objst_drawdate = $objLottoLottario->addMultiField("START DRAW DATE");
  $onLottario_row = $objLottery->dbLotteryGamesGet("onLottario");
  if ($onLottario_row["drawStartDate"] != null) {
    $sGameStartDate = $onLottario_row["drawStartDate"];
  } else {
    $sGameStartDate = "1982-06-12";
  }
  
  if ($onLottario_row["validateDrawDate"] != null) {
    $sGameValidationAvailFrom = $onLottario_row["validateDrawDate"];
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
  
  $obj_2ndLottarioNum = $objForm->addArea("Check Additional Lottario Numbers", true, "addLottarionums", false);
  
 
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
  
    $objEb_2_Lottario = $obj_2ndLottarioNum->addMultiField("Lottario , Early Bird");
  
    $objEb_2_Lottario->addField("OLG_Lottario_2",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
    );
  
    $objEb_2_Lottario->addField("Early_Bird_2",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
    );
  
      $objEb_3_Lottario = $obj_2ndLottarioNum->addMultiField("Lottario , Early Bird");
  
      $objEb_3_Lottario->addField("OLG_Lottario_3",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
    );
  
      $objEb_3_Lottario->addField("Early_Bird_3",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
    );
    
    $objEb_4_Lottario = $obj_2ndLottarioNum->addMultiField("Lottario , Early Bird");
    
        $objEb_4_Lottario->addField("OLG_Lottario_4",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
    );
      $objEb_4_Lottario->addField("Early_Bird_4",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
    );
    
    $objEb_5_Lottario = $obj_2ndLottarioNum->addMultiField("Lottario , Early Bird");
    
        $objEb_5_Lottario->addField("OLG_Lottario_5",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
    );
    
        $objEb_5_Lottario->addField("Early_Bird_5",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
    );
    
    $objEb_6_Lottario = $obj_2ndLottarioNum->addMultiField("Lottario , Early Bird");
    
        $objEb_6_Lottario->addField("OLG_Lottario_6",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
    );
    
        $objEb_6_Lottario->addField("Early_Bird_6",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
    );
    
    
    $objEb_7_Lottario = $obj_2ndLottarioNum->addMultiField("Lottario , Early Bird");
    
        $objEb_7_Lottario->addField("OLG_Lottario_7",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
    );
    
        $objEb_7_Lottario->addField("Early_Bird_7",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
    );
    
    $objEb_8_Lottario = $obj_2ndLottarioNum->addMultiField("Lottario , Early Bird");
    
    
        $objEb_8_Lottario->addField("OLG_Lottario_8",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
    );
    
        $objEb_8_Lottario->addField("Early_Bird_8",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
    );
    
    
    $objEb_9_Lottario = $obj_2ndLottarioNum->addMultiField("Lottario , Early Bird");
        $objEb_9_Lottario->addField("OLG_Lottario_9",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
    );
    
        $objEb_9_Lottario->addField("Early_Bird_9",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
    );
    
    
    $objEb_10_Lottario = $obj_2ndLottarioNum->addMultiField("Lottario , Early Bird");
        $objEb_10_Lottario->addField("OLG_Lottario_10",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\\d{1,2})){5}$/i',
          "minLength" => 6,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid 649 number.",
          "minLength" => "A Lotto 649 number is at least %s characters long.",
          "maxLength" => "A Lotto 649 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Lottario number ex. 00-00-00-00-00-00"
      )
    );
    
        $objEb_10_Lottario->addField("Early_Bird_10",  VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/(\\d{1,2})(-(\\d{1,2})){3}$/i',
          "minLength" => 4,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Early Bird number.",
          "minLength" => "A Lotto Early Bird number is at least %s characters long.",
          "maxLength" => "A Lotto Early Bird number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "tip" => "Early Bird number ex. 00-00-00-00"
      )
    );
  
  $objForm->setMainAlert("One or more errors occurred. Check the marked fields and try again.");
  $objForm->setSubmitLabel("Submit");
      
  $strOutput = "";
   
  if ($objForm->isSubmitted() && $objForm->isValid()) {
      
     //print "\n<br /> lottario";
     $objst_drdt_ar = $objst_drawdate->getFields();
     $objed_drdt_ar = $objed_drawdate->getFields();
    
     
     $lotto_select_list = array();
     $lotto_select_list[0] = array();
     //print "testing 2";
    // 
     // lottario field 0
     $lottario_fields = $objEb_Lottario->getFields();
     $lotto_select_list[0][0] = $lottario_fields[0]->getValue();
     $lotto_select_list[0][1] = $lottario_fields[1]->getValue();
     $st_drawdate = date('Y-m-d',mktime(0,0,0,$objst_drdt_ar[1]->getValue(),$objst_drdt_ar[2]->getValue(),$objst_drdt_ar[0]->getValue()));
     if ($objed_drdt_ar[0]->getValue() != "" && $objed_drdt_ar[1]->getValue() != "" && $objed_drdt_ar[2]->getValue() != "") {
       $ed_drawdate = date('Y-m-d', mktime(0,0,0,$objed_drdt_ar[1]->getValue(), $objed_drdt_ar[2]->getValue(), $objed_drdt_ar[0]->getValue()));
     } else {
       $ed_drawdate = $st_drawdate;
     }
     //print_r($lotto_select_list);
    // print "\n st date: " . $st_drawdate;
    // print "\n ed date: " . $ed_drawdate;
     $iselection_cnt = 1;
     
     // lottario field 1
     
     $lottario_fields = $objEb_2_Lottario->getFields();
     if (is_array($lottario_fields) && $lottario_fields[0]->getValue() != "") {
       $lotto_select_list[1][0] = $lottario_fields[0]->getValue();
     }
     if (is_array($lottario_fields) && $lottario_fields[1]->getValue() != "") {
       $lotto_select_list[1][1] = $lottario_fields[1]->getValue();
     }
     
     // lottario field 2
     $lottario_fields = $objEb_3_Lottario->getFields();
     if (is_array($lottario_fields) && $lottario_fields[0]->getValue() != "") {
      $lotto_select_list[2][0] = $lottario_fields[0]->getValue();
     }
     if (is_array($lottario_fields) && $lottario_fields[1]->getValue() != "") {
      $lotto_select_list[2][1] = $lottario_fields[1]->getValue();
     }
     
     // lottario field 3
     $lottario_fields = $objEb_4_Lottario->getFields();
     if (is_array($lottario_fields) && $lottario_fields[0]->getValue() != "") {
      $lotto_select_list[3][0] = $lottario_fields[0]->getValue();
     }
     if (is_array($lottario_fields) && $lottario_fields[1]->getValue() != "") {
      $lotto_select_list[3][1] = $lottario_fields[1]->getValue();
     }
     
     // lottario field 4
     $lottario_fields = $objEb_5_Lottario->getFields();
     if (is_array($lottario_fields) && $lottario_fields[0]->getValue() != "") {
      $lotto_select_list[4][0] = $lottario_fields[0]->getValue();
     }
     if (is_array($lottario_fields) && $lottario_fields[1]->getValue() != "") {
      $lotto_select_list[4][1] = $lottario_fields[1]->getValue();
     }
     // lottario field 5
     $lottario_fields = $objEb_6_Lottario->getFields();
     if (is_array($lottario_fields) && $lottario_fields[0]->getValue() != "") {
      $lotto_select_list[5][0] = $lottario_fields[0]->getValue();
     }
     if (is_array($lottario_fields) && $lottario_fields[1]->getValue() != "") {
      $lotto_select_list[5][1] = $lottario_fields[1]->getValue();
     }
     // lottario field 6
     $lottario_fields = $objEb_7_Lottario->getFields();
     if (is_array($lottario_fields) && $lottario_fields[0]->getValue() != "") {
      $lotto_select_list[6][0] = $lottario_fields[0]->getValue();
     }
     if (is_array($lottario_fields) && $lottario_fields[1]->getValue() != "") {
      $lotto_select_list[6][1] = $lottario_fields[1]->getValue();
     }
     
     
     // lottario field 7
     $lottario_fields = $objEb_8_Lottario->getFields();
     if (is_array($lottario_fields) && $lottario_fields[0]->getValue() != "") {
      $lotto_select_list[7][0] = $lottario_fields[0]->getValue();
     }
     if (is_array($lottario_fields) && $lottario_fields[1]->getValue() != "") {
      $lotto_select_list[7][1] = $lottario_fields[1]->getValue();
     }
     
     // lottario field 8
     $lottario_fields = $objEb_9_Lottario->getFields();
     if (is_array($lottario_fields) && $lottario_fields[0]->getValue() != "") {
      $lotto_select_list[8][0] = $lottario_fields[0]->getValue();
     }
     if (is_array($lottario_fields) && $lottario_fields[1]->getValue() != "") {
      $lotto_select_list[8][1] = $lottario_fields[1]->getValue();
     }
     
     // lottario field 9
     $lottario_fields = $objEb_10_Lottario->getFields();
     if (is_array($lottario_fields) && $lottario_fields[0]->getValue() != "") {
      $lotto_select_list[9][0] = $lottario_fields[0]->getValue();
     }
     if (is_array($lottario_fields) && $lottario_fields[1]->getValue() != "") {
      $lotto_select_list[9][1] = $lottario_fields[1]->getValue();
     }
     
     // lottario field 10
     
     
    // print_r($lotto_select_list);
     
     $on_lottario_nums_ar = null;
     $lotto_validat_res = array();
     $ivalidat_cnt = 0;
     foreach ($lotto_select_list as $single_lotto_num) {
       $on_lottario_nums_ar[$ivalidat_cnt] = array();
       $lotto_validat_res[$ivalidat_cnt]["played_nums"] = array();
       if (preg_match("/\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*/i",$single_lotto_num[0], $on_lottario_match)) {
         $on_lottario_nums_ar[$ivalidat_cnt][0] = array($on_lottario_match[1], $on_lottario_match[2], $on_lottario_match[3], $on_lottario_match[4], $on_lottario_match[5], $on_lottario_match[6]);
         sort($on_lottario_nums_ar[$ivalidat_cnt][0], SORT_ASC);
         $on_lottario_nums_ar[$ivalidat_cnt][0] = array_unique($on_lottario_nums_ar[$ivalidat_cnt][0]);
         $lotto_validat_res[$ivalidat_cnt]["played_nums"][0] = $on_lottario_nums_ar[$ivalidat_cnt][0];
       }
       
       if (preg_match("/\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*-\s*(\d{1,2})\s*/i",$single_lotto_num[1], $on_early_bird_match)) {
         $on_lottario_nums_ar[$ivalidat_cnt][1] = array($on_early_bird_match[1], $on_early_bird_match[2], $on_early_bird_match[3], $on_early_bird_match[4]);
         sort($on_lottario_nums_ar[$ivalidat_cnt][1], SORT_ASC);
         $on_lottario_nums_ar[$ivalidat_cnt][1] = array_unique($on_lottario_nums_ar[$ivalidat_cnt][1]);
         $lotto_validat_res[$ivalidat_cnt]["played_nums"][1] = $on_lottario_nums_ar[$ivalidat_cnt][1]; 
         
       }
       
       if (count($on_lottario_nums_ar[$ivalidat_cnt][0]) == 6) {
         if (count($on_lottario_nums_ar[$ivalidat_cnt][1]) == 4) {
           $lotto_validat_res[$ivalidat_cnt]["validation_res"] = $OLGLottery->OLGLottarioValidateDraw($st_drawdate, $ed_drawdate, $on_lottario_nums_ar[$ivalidat_cnt][0][0], $on_lottario_nums_ar[$ivalidat_cnt][0][1], $on_lottario_nums_ar[$ivalidat_cnt][0][2], $on_lottario_nums_ar[$ivalidat_cnt][0][3], $on_lottario_nums_ar[$ivalidat_cnt][0][4], $on_lottario_nums_ar[$ivalidat_cnt][0][5], $on_lottario_nums_ar[$ivalidat_cnt][1][0], $on_lottario_nums_ar[$ivalidat_cnt][1][1], $on_lottario_nums_ar[$ivalidat_cnt][1][2], $on_lottario_nums_ar[$ivalidat_cnt][1][3]); 
         
           $ivalidat_cnt++;
         }
       }
       
       
     }
     
     
   // print_r($lotto_validat_res);
    
    
      //*** HTML body of the email.
      
  
      //*** Send the email.
     // mail("owner@awesomesite.com", "Contact form submitted", $strMessage, $strHeaders);
           
      //*** Set the output to a friendly thank you note.
      //$strOutput = $objForm->valuesAsHtml();
      
      //$strOutput = $objForm->getValidField("email").
      /*
      $objst_drdt_ar = $objst_drawdate->getFields();
      $objed_drdt_ar = $objed_drawdate->getFields();
      
      $lotto_select_list = array();
      $lotto_select_list[0] = $objForm->getValidField("OLG_Lottario")->getValue();
      $st_drawdate = date('Y-m-d',mktime(0,0,0,$objst_drdt_ar[1]->getValue(),$objst_drdt_ar[2]->getValue(),$objst_drdt_ar[0]->getValue()));
      if ($objed_drdt_ar[0]->getValue() != "" && $objed_drdt_ar[1]->getValue() != "" && $objed_drdt_ar[2]->getValue() != "") {
        $ed_drawdate = date('Y-m-d', mktime(0,0,0,$objed_drdt_ar[1]->getValue(), $objed_drdt_ar[2]->getValue(), $objed_drdt_ar[0]->getValue()));
      } else {
        $ed_drawdate = $st_drawdate;
      }
      $iselection_cnt = 1;
      for ($i = 2; $i <= 10; $i++) {
        if ($objForm->getValidField("OLG_Lottario_" . $i)->getValue() != "") {
          $lotto_select_list[$iselection_cnt] = $objForm->getValidField("OLG_49_" . $i)->getValue();
          $iselection_cnt++;
        }
      }
      
      */
  } else {
      //*** The form has not been submitted or is not valid.
      $strOutput = $objForm->toHtml();
  }
  
  
   $data_avail = $OLGLottery->OLGLottarioGetFirstLastDataAvail();
      



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
            if ($snum == $lotto_single_game["played_nums"][0][0]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][0][0] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][0][0] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][0][0] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][0][0] . "</span>";
          }
          ?>
      </td>
    <td><?php 
    
          $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][0][1]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][0][1] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][0][1] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][0][1] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][0][1] . "</span>";
          }
          ?></td>
    <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][0][2]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][0][2] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][0][2] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][0][2] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][0][2] . "</span>";
          }
         ?>
    </td>
    <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][0][3]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][0][3] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][0][3] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][0][3] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][0][3] . "</span>";
          }      ?>
    </td>
    <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][0][4]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][0][4] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][0][4] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][0][4] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][0][4] . "</span>";
          }      ?>
    </td>
    <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][0][5]) {
              $b_win_num_match = true;
              break;
            } elseif ($lotto_single_game["played_nums"][0][5] == $s_single_match["match_bonus_num"]) {
              $b_bonus_num_match = true;
              break;
            }
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][0][5] . "</span>";
          } elseif ($b_bonus_num_match) {
            print "<span class='matchBonusNumber'>" . $lotto_single_game["played_nums"][0][5] . "</span>";
             
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][0][5] . "</span>";
          }
          ?>
    </td>
    
    <?php
        if (is_array($s_single_match["played_nums"][1])) {
          ?>
        <td> EB: 
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_eb_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][1][0]) {
              $b_win_num_match = true;
              break;
            } 
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][1][0] . "</span>";
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][1][0] . "</span>";
          }
          ?>
    </td>
        <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_eb_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][1][1]) {
              $b_win_num_match = true;
              break;
            } 
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][1][1] . "</span>";
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][1][1] . "</span>";
          }
          ?>
    </td>
        <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_eb_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][1][2]) {
              $b_win_num_match = true;
              break;
            } 
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][1][2] . "</span>";
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][1][2] . "</span>";
          }
          ?>
    </td>
        <td>
    <?php 
        $b_win_num_match = false;
          $b_bonus_num_match = false;
          foreach ($s_single_match["match_eb_numbers"] as $snum) {
            if ($snum == $lotto_single_game["played_nums"][1][3]) {
              $b_win_num_match = true;
              break;
            } 
          }
          if ($b_win_num_match) {
            print "<span class='matchNumber'>" . $lotto_single_game["played_nums"][1][3] . "</span>";
          } else {
            print "<span class='notMatchNumber'>" . $lotto_single_game["played_nums"][1][3] . "</span>";
          }
          ?>
    </td>
    
    
    
    
    
    <?php } ?>
    
    <td nowrap><?php 
      if ($s_single_match["win_prze_amount"] > 0) {
        print " - <span class='win_amt'>$" . money_format('%(#12n',$s_single_match["win_prze_amount"]) . "</span><br />";
      }
      if ($s_single_match["win_prze_ebird_amount"] > 0) {
        print " - EB: <span class='win_amt'>$" . money_format('%(#12n',$s_single_match["win_prze_ebird_amount"]) . "</span><br />";
      }
    
    ?>
    </td>
    
    
     <td>Draw Numbers: <?php print $s_single_match["draw_numbers"][0] . " - " . $s_single_match["draw_numbers"][1] . " - " . $s_single_match["draw_numbers"][2] . " - " . $s_single_match["draw_numbers"][3] . " - " . $s_single_match["draw_numbers"][4] . " - " . $s_single_match["draw_numbers"][5] . " - B: " . $s_single_match["draw_bonus"]; ?> 
     Early Bird: <?php print $s_single_match["eb_draw_numbers"][0] . " - " . $s_single_match["eb_draw_numbers"][1] . " - " . $s_single_match["eb_draw_numbers"][2] . " - " . $s_single_match["eb_draw_numbers"][3]; ?></td>
    
    
    
    
    
    </tr>
      <?php
        }  
      
    $icur_game_cnt++;
    }
  }
}



?>






<tr>
<td ><?php echo $strOutput ?></td>
<td>&nbsp;</td>
</tr></table>
<?php print $objAnalytics->GoogleAnalytics(); ?>

</body>
</html>

