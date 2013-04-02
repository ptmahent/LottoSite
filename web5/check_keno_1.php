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
  require_once("../inc/incVARS.php");

  $sNickName = "";
  $bLoggedIn = false;
  $objUser = new User();
  $objLottery = new Lottery();
  $objDate    = new GenDates();
  $naLottery  = new NALottery();
  $OLGLottery = new OLGLottery();
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
  


  $objForm = new ValidForm("Check_Keno", "Required fields are printed in bold.");
  $objLottoKeno = $objForm->addArea("Validate Keno", false, "validate_keno");

  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $objLottoKeno->addField("OLG_Keno", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => true,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
      )
  );
  
  $objst_drawdate = $objLottoKeno->addMultiField("START DRAW DATE");
    
  $onKeno_row   = $objLottery->dbLotteryGamesGet("onKeno");
  
  if ($onKeno_row["drawStartDate"] != null) {
    $sGameStartDate = $onKeno_row["drawStartDate"];
  } else {
    $sGameStartDate = "2009-04-01";
  }
  if ($onKeno_row["validateDrawDate"] != null) {
    $sGameValidationAvailFrom = $onKeno_row["validateDrawDate"];
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
  
  $obj_2ndKenoNum = $objForm->addArea("Check Additional Keno Numbers", true, "addKenoNums", false);
 
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $obj_2ndKenoNum->addField("OLG_Keno_2", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
      )
  );
  
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $obj_2ndKenoNum->addField("OLG_Keno_3", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
      )
  );
  
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $obj_2ndKenoNum->addField("OLG_Keno_4", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
      )
  );
  
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $obj_2ndKenoNum->addField("OLG_Keno_5", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
      )
  );
  
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $obj_2ndKenoNum->addField("OLG_Keno_6", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
      )
  );
  
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $obj_2ndKenoNum->addField("OLG_Keno_7", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
      )
  );
  
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $obj_2ndKenoNum->addField("OLG_Keno_8", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
      )
  );
  
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $obj_2ndKenoNum->addField("OLG_Keno_9", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
      )
  );
  
  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $obj_2ndKenoNum->addField("OLG_Keno_10", "Ontario Keno Numbers", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d{1,2})(-(\d{1,2})){1,9}$/i',
          "minLength" => 3,
          "maxLength" => 31
         
      ),
      array(
          "type" => "This is not a valid Keno number.",
          "minLength" => "A Keno number is at least %s characters long.",
          "maxLength" => "A Keno number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Lotto 649 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "00-00-00-00-00-00-00-00-00-00",
          "tip" => "Keno ex. 00-00-00-00-00-00-00-00-00-00 --> Keno can range from 2 numbers to 10 numbers"
          
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
   
  if ($objForm->isSubmitted() && $objForm->isValid()) {
      
    
      //*** HTML body of the email.
      
  
      //*** Send the email.
     // mail("owner@awesomesite.com", "Contact form submitted", $strMessage, $strHeaders);
           
      //*** Set the output to a friendly thank you note.
      //$strOutput = $objForm->valuesAsHtml();
      
      //$strOutput = $objForm->getValidField("email").
      
      
      $objst_drdt_ar = $objst_drawdate->getFields();
      
      $objed_drdt_ar = $objed_drawdate->getFields();
      
      $lotto_select_list = array();
      $lotto_select_list[0] = $objForm->getValidField("OLG_Keno")->getValue();
      $st_drawdate = date('Y-m-d', mktime(0,0,0, $objst_drdt_ar[1]->getValue(), $objst_drdt_ar[2]->getValue(), $objst_drdt_ar[0]->getValue()));
       if ($objed_drdt_ar[0]->getValue() != "" && $objed_drdt_ar[1]->getValue() != "" && $objed_drdt_ar[2]->getValue() != "") {
         $ed_drawdate = date('Y-m-d', mktime(0,0,0,$objed_drdt_ar[1]->getValue(), $objed_drdt_ar[2]->getValue(), $objed_drdt_ar[0]->getValue()));
       } else {
         $ed_drawdate = $st_drawdate;
       }
       $iselection_cnt = 1;
       $str_clean_sym = array("  ",",");
       for ($i = 2; $i <= 10; $i++) {
         if ($objForm->getValidField("OLG_Keno_" . $i)->getValue() != "") {
           $lotto_select_list[$iselection_cnt] = $objForm->getValidField("OLG_Keno_" . $i)->getValue();
           $iselection_cnt++;
         }
       }
       $on_keno_nums_ar = null;
       $ivalidat_cnt = 0;
        
       foreach ($lotto_select_list as $single_lotto_num) {
        str_replace($str_clean_sym,"",$single_lotto_num);
        if (preg_match("/^(\d{1,2})(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}$/i",$single_lotto_num, $on_keno_match)) {
            //print "\n<br />" . $single_lotto_num;
            $ikeno_category = 0;
            $on_keno_nums_ar = array();
            
            $snum1    = null;
            $snum2    = null;
            $snum3    = null;
            $snum4    = null;
            $snum5    = null;
            $snum6    = null;
            $snum7    = null;
            $snum8    = null;
            $snum9    = null;
            $snum10   = null;
            if (array_key_exists(19,$on_keno_match)) {
              // 10
              $snum1 = $on_keno_match[1];
              $snum2 = $on_keno_match[3];
              $snum3 = $on_keno_match[5];
              $snum4 = $on_keno_match[7];
              $snum5 = $on_keno_match[9];
              $snum6 = $on_keno_match[11];
              $snum7 = $on_keno_match[13];
              $snum8 = $on_keno_match[15];
              $snum9 = $on_keno_match[17];
              $snum10 = $on_keno_match[19];
              $on_keno_nums_ar = array(  $snum1, $snum2 , $snum3, $snum4, $snum5, $snum6, $snum7, $snum8 , $snum9, $snum10);
              $ikeno_category = 10;          
            }elseif (array_key_exists(17,$on_keno_match)) {
             // 9
              $snum1 = $on_keno_match[1];
              $snum2 = $on_keno_match[3];
              $snum3 = $on_keno_match[5];
              $snum4 = $on_keno_match[7];
              $snum5 = $on_keno_match[9];
              $snum6 = $on_keno_match[11];
              $snum7 = $on_keno_match[13];
              $snum8 = $on_keno_match[15];
              $snum9 = $on_keno_match[17];
              $on_keno_nums_ar = array(  $snum1, $snum2 , $snum3, $snum4, $snum5, $snum6, $snum7, $snum8 , $snum9);
              
              $ikeno_category = 9;
            }elseif (array_key_exists(15,$on_keno_match)) {
              // 8
              $snum1 = $on_keno_match[1];
              $snum2 = $on_keno_match[3];
              $snum3 = $on_keno_match[5];
              $snum4 = $on_keno_match[7];
              $snum5 = $on_keno_match[9];
              $snum6 = $on_keno_match[11];
              $snum7 = $on_keno_match[13];
              $snum8 = $on_keno_match[15];
              $on_keno_nums_ar = array(  $snum1, $snum2 , $snum3, $snum4, $snum5, $snum6, $snum7, $snum8 );
              
              $ikeno_category = 8;
            }elseif (array_key_exists(13,$on_keno_match)) {
              // 7
              $snum1 = $on_keno_match[1];
              $snum2 = $on_keno_match[3];
              $snum3 = $on_keno_match[5];
              $snum4 = $on_keno_match[7];
              $snum5 = $on_keno_match[9];
              $snum6 = $on_keno_match[11];
              $snum7 = $on_keno_match[13];
              $on_keno_nums_ar = array(  $snum1, $snum2 , $snum3, $snum4, $snum5, $snum6, $snum7);
              
              $ikeno_category = 7;
            }elseif (array_key_exists(11,$on_keno_match)) {
              // 6
              $snum1 = $on_keno_match[1];
              $snum2 = $on_keno_match[3];
              $snum3 = $on_keno_match[5];
              $snum4 = $on_keno_match[7];
              $snum5 = $on_keno_match[9];
              $snum6 = $on_keno_match[11];
              $on_keno_nums_ar = array(  $snum1, $snum2 , $snum3, $snum4, $snum5, $snum6);
              
              $ikeno_category = 6;
            }elseif (array_key_exists(9,$on_keno_match)) {
              // 5
              $snum1 = $on_keno_match[1];
              $snum2 = $on_keno_match[3];
              $snum3 = $on_keno_match[5];
              $snum4 = $on_keno_match[7];
              $snum5 = $on_keno_match[9];
              $on_keno_nums_ar = array(  $snum1, $snum2 , $snum3, $snum4, $snum5);
              
              $ikeno_category = 5;
            }elseif (array_key_exists(7,$on_keno_match)) {
              // 4
              $snum1 = $on_keno_match[1];
              $snum2 = $on_keno_match[3];
              $snum3 = $on_keno_match[5];
              $snum4 = $on_keno_match[7];
              $on_keno_nums_ar = array(  $snum1, $snum2 , $snum3, $snum4);
              
              $ikeno_category = 4;
            }elseif (array_key_exists(5,$on_keno_match)) {
              //3
              $snum1 = $on_keno_match[1];
              $snum2 = $on_keno_match[3];
              $snum3 = $on_keno_match[5];
              $on_keno_nums_ar = array(  $snum1, $snum2 , $snum3);
              
              $ikeno_category = 3;
            }elseif (array_key_exists(3,$on_keno_match)) {
              // 2
              $snum1 = $on_keno_match[1];
              $snum2 = $on_keno_match[3];
              $on_keno_nums_ar = array(  $snum1, $snum2 );
              
              $ikeno_category = 2;
             
            }
            $lotto_validat_res[$ivalidat_cnt] = array();
            $lotto_validat_res[$ivalidat_cnt]["played_nums"]  = $on_keno_nums_ar;
            $lotto_validat_res[$ivalidat_cnt]["category"]     = $ikeno_category;
            //print_r($lotto_validat_res);
            //print "\n<br />Category : " . $ikeno_category;
            if ($ikeno_category > 0) {
              sort($on_keno_nums_ar, SORT_ASC);
              //print_r($on_keno_nums_ar);
              $lotto_validat_res[$ivalidat_cnt]["validation_res"] = $OLGLottery->OLGKenoValidateDraw
                      ($st_drawdate, $ed_drawdate, $ikeno_category, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10);
              //print_r($lotto_validat_res);
              $ivalidat_cnt++;
            }
               
          //print_r($on_keno_match);
          
        }
       }       
       
  } else {
      //*** The form has not been submitted or is not valid.
      $strOutput = $objForm->toHtml();
  }
  
  
      
  $data_avail = $OLGLottery->OLGKenoGetFirstLastDataAvail();


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

$JSOUTPUT = "$(document).ready(function() {
			var options = {
				additionalFilterTriggers: [$('#quickfind')],
				clearFiltersControls: [$('#cleanfilters')] 
				
			};


			$('#lottery_result').tableFilter(options);
			});";





if (!is_array($lotto_validat_res)) {

	/*$htmlOut .= "<tr><td>";
	$htmlOut .= $TSWL_VAR_MSG["unknown_error"];
  	$htmlOut .= "</td></tr>";

	*/
} else {
  $icur_game_cnt = 0;
  
  $htmlOut .= "<div id='filter_Controls'>			
			Quick Find: <input type='text' id='quickfind' /> | 
			<a id='cleanfilters' href='#'>Clear Filters</a></div>
			"; 	
		$htmlOut .= "<table id='lottery_result' >";
    	$htmlOut .= "<thead>
			<tr>
			<th>DATE</th>
			<th>N1</th>
			<th>N2</th>
			<th>N3</th>
			<th>N4</th>
			<th>N5</th>
			<th>N6</th>
			<th>N7</th>
			<th>N8</th>
			<th>N9</th>
			<th>N10</th>
			<th>--></th>
			<th>N1</th>
			<th>N2</th>
			<th>N3</th>
			<th>N4</th>
			<th>N5</th>
			<th>N6</th>
			<th>N7</th>
			<th>N8</th>
			<th>N9</th>
			<th>N10</th>
			<th>N11</th>
			<th>N12</th>
			<th>N13</th>
			<th>N14</th>
			<th>N15</th>
			<th>N16</th>
			<th>N17</th>
			<th>N18</th>
			<th>N19</th>
			<th>N20</th>
			</tr>

			</thead>
			
			<tbody>";
  foreach ($lotto_validat_res as $lotto_single_game) {
  
  	if (!is_array($lotto_single_game["validation_res"])) {
  	
  		$htmlOut .=  $TSWL_VAR_MSG["invalid_format"] ;
  		
  		
  	} 
  	else {
  	
  		
      foreach ($lotto_single_game["validation_res"] as $s_single_match) {
     
      	$htmlOut .= "<tr><td nowrap id='drawDate'>" .  date('Y-m-d',strtotime($s_single_match["drawdate"])) . "</td>";
       $b_win_num_match = false;
       $style_id = "";

       foreach ($s_single_match["match_numbers"] as $snum) {
         if ($snum == $lotto_single_game["played_nums"][0]) {
              $b_win_num_match = true;
              break;
         } 
       }
       if ($b_win_num_match) {
       		$style_id = "matchNumber";
          }
       else {
			$style_id = "notMatchNumber";
          }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][0] . "</td>";
      
       
       if ($s_single_match["category"] >= 2) {
		   $b_win_num_match = false;
		   foreach ($s_single_match["match_numbers"] as $snum) {
			 if ($snum == $lotto_single_game["played_nums"][1]) {
				  $b_win_num_match = true;
				  break;
			 } 
		   }
		   if ($b_win_num_match) {
       		$style_id = "matchNumber";
           } else {
			$style_id = "notMatchNumber";
           }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][1] . "</td>";
        
       } else {
         $htmlOut .=  "<td > &nbsp;</td>";
       }
       
       
       if ($s_single_match["category"] >= 3) {
         $b_win_num_match = false;
         foreach ($s_single_match["match_numbers"] as $snum) {
           if ($snum == $lotto_single_game["played_nums"][2]) {
                $b_win_num_match = true;
                break;
           } 
         }
		   if ($b_win_num_match) {
       		$style_id = "matchNumber";
           } else {
			$style_id = "notMatchNumber";
           }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][2] . "</td>";
        
       } else {
         $htmlOut .=  "<td > &nbsp;</td>";
       }
      
       if ($s_single_match["category"] >= 4) {
         $b_win_num_match = false;
         foreach ($s_single_match["match_numbers"] as $snum) {
           if ($snum == $lotto_single_game["played_nums"][3]) {
                $b_win_num_match = true;
                break;
           } 
         }
		   if ($b_win_num_match) {
       		$style_id = "matchNumber";
           } else {
			$style_id = "notMatchNumber";
           }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][3] . "</td>";
        
       } else {
         $htmlOut .=  "<td > &nbsp;</td>";
       }
       
       if ($s_single_match["category"] >= 5) {
         $b_win_num_match = false;
         foreach ($s_single_match["match_numbers"] as $snum) {
           if ($snum == $lotto_single_game["played_nums"][4]) {
                $b_win_num_match = true;
                break;
           } 
         }
		   if ($b_win_num_match) {
       		$style_id = "matchNumber";
           } else {
			$style_id = "notMatchNumber";
           }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][4] . "</td>";
        
       } else {
         $htmlOut .=  "<td > &nbsp;</td>";
       }
       if ($s_single_match["category"] >= 6) {
         $b_win_num_match = false;
         foreach ($s_single_match["match_numbers"] as $snum) {
           if ($snum == $lotto_single_game["played_nums"][5]) {
                $b_win_num_match = true;
                break;
           } 
         }
		   if ($b_win_num_match) {
       		$style_id = "matchNumber";
           } else {
			$style_id = "notMatchNumber";
           }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][5] . "</td>";
        
       } else {
         $htmlOut .=  "<td > &nbsp;</td>";
       }
      
      if ($s_single_match["category"] >= 7) {
         $b_win_num_match = false;
         foreach ($s_single_match["match_numbers"] as $snum) {
           if ($snum == $lotto_single_game["played_nums"][6]) {
                $b_win_num_match = true;
                break;
           } 
         }
		   if ($b_win_num_match) {
       		$style_id = "matchNumber";
           } else {
			$style_id = "notMatchNumber";
           }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][6] . "</td>";
        
       } else {
         $htmlOut .=  "<td > &nbsp;</td>";
       }
       
       if ($s_single_match["category"] >= 8) {
         $b_win_num_match = false;
         foreach ($s_single_match["match_numbers"] as $snum) {
           if ($snum == $lotto_single_game["played_nums"][7]) {
                $b_win_num_match = true;
                break;
           } 
         }
		   if ($b_win_num_match) {
       		$style_id = "matchNumber";
           } else {
			$style_id = "notMatchNumber";
           }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][7] . "</td>";
        
       } else {
         $htmlOut .=  "<td > &nbsp;</td>";
       }
       
       if ($s_single_match["category"] >= 9) {
         $b_win_num_match = false;
         foreach ($s_single_match["match_numbers"] as $snum) {
           if ($snum == $lotto_single_game["played_nums"][8]) {
                $b_win_num_match = true;
                break;
           } 
         }
		   if ($b_win_num_match) {
       		$style_id = "matchNumber";
           } else {
			$style_id = "notMatchNumber";
           }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][8] . "</td>";
        
       } else {
         $htmlOut .=  "<td > &nbsp;</td>";
       }
       
       if ($s_single_match["category"] >= 10) {
         $b_win_num_match = false;
         foreach ($s_single_match["match_numbers"] as $snum) {
           if ($snum == $lotto_single_game["played_nums"][9]) {
                $b_win_num_match = true;
                break;
           } 
         }
		   if ($b_win_num_match) {
       		$style_id = "matchNumber";
           } else {
			$style_id = "notMatchNumber";
           }
        $htmlOut .= "<td id='" . $style_id . "'>" . $lotto_single_game["played_nums"][9] . "</td>";
        
       } else {
         $htmlOut .=  "<td > &nbsp;</td>";
       }

		if ($s_single_match["win_prze_amount"] > 0) {
			$htmlOut .= "<td id='win_amt'> $" . money_format('%(#12n',$s_single_match["win_prze_amount"]) . "</td>";
		} else {
			$htmlOut .= "<td> &nbsp; </td>";
		}

		$htmlOut .= "<td id='drawNumber'>" .  $s_single_match["draw_numbers"][0] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][1] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][2] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][3] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][4] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][5] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][6] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][7] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][8] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][9] . "</td>" .
		     "<td id='drawNumber'>" .  $s_single_match["draw_numbers"][10] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][11] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][12] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][13] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][14] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][15] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][16] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][17] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][18] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][19] . "</td>";
       $htmlOut .= "</tr>";
      } 
      
     
      }

    $icur_game_cnt++;
  }
      $htmlOut .= "</tbody></table>"; 
    $htmlOut .= "<br /><a href='javascript: history.go(-1)'>Go Back</a>"; 
    
}
$htmlOut .= "<table><tr><td >" . $strOutput  . "</td>" 
		. "</tr>"
		. "</table>"
		. $objAnalytics->GoogleAnalytics(); 
$smarty->assign("JSOUTPUT", $JSOUTPUT);
$smarty->assign("htmlOut", $htmlOut);
$smarty->display('validate_numbers.tpl');