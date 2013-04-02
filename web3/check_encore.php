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
  require_once("../inc/incVARS.php");

  $sNickName = "";
  $bLoggedIn = false;
  $objUser = new User();
  $objLottery = new Lottery();
  $objDate    = new GenDates();
  $OLGLottery  = new OLGLottery();
  $objAnalytics   = new Analytics();
  
  if (array_key_exists("valid", $_SESSION)) {
    $iuserNo    = $_SESSION['userid'];
    $sNickName  = $_SESSION['_nickname'];
    $ds_user    = $objUser->UserGet($iuserNo);
    //print_r($ds_user);
    if (is_array($ds_user)) {
      $bLoggedIn = true;
    }
  }
  
  $st_date = "";
  $lotto_validat_res = "";
  $htmlOut = "";
  
   $data_avail = $OLGLottery->OLGEncoreGetFirstLastDataAvail();
  
  if (strtotime($st_date) > strtotime($data_avail["latest"])) {
  	$st_date = date('Y-m-d', 
  					mktime(0,0,0, 
  							date('m', strtotime($data_avail["latest"])), 1, 
  										date('Y',strtotime($data_avail["latest"]))
  										));
  }
  
  $last_draw_year = date('Y',strtotime($data_avail["latest"]));
  $last_draw_month = date('m', strtotime($data_avail["latest"]));
  $last_draw_day = date('d',strtotime($data_avail["latest"]));
  
  
  
  $objForm = new ValidForm("Encore_Validator", "Required fields are printed in bold.");
           $objLottoEncore = $objForm->addArea("Validate Encore", false, "validate_Encore");
    
  
  
      //*** A VFORM_CUSTOM field uses a custom regular expression
      //*** for field validation, server- and clientside.
      $objLottoEncore->addField("OLG_Encore", "Encore", VFORM_CUSTOM,
          array(
              "required" => true,
              //*** This is a custom regular expression
              //*** for a Dutch tax number.
              "validation" => '/^(\d){7}$/i',
              "minLength" => 7,
              "maxLength" => 7
          ),
          array(
              "type" => "This is not a valid Encore number.",
              "minLength" => "An Encore number is at least %s characters long.",
              "maxLength" => "An Encore number has a maximum of %s characters.",
              "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
          ),
          array(
              //*** A hint value is displayed inside the input field
              //*** and is not allowed to be submitted.
              "hint" => "0000000",
              "tip" => "Encore number ex. 1234567"
          )
      );
      
   $objst_drawdate  = $objLottoEncore->addMultiField("START DRAW DATE");
   $onEncore_row    = $objLottery->dbLotteryGamesGet("onEncore");
  if ($onEncore_row["drawStartDate"] != null) {
    $sGameStartDate = $onEncore_row["drawStartDate"];
  } else {
    $sGameStartDate = "1982-06-12";
  }
  
  if ($onEncore_row["validateDrawDate"] != null) {
    $sGameValidationAvailFrom = $onEncore_row["validateDrawDate"];
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
      "end" => intval($st_valid_year_till),
      "selectedValue" => $last_draw_year)
  );
  
  $objst_drawdate->addField("st_DrawMonth",  VFORM_SELECT_LIST,
    array(
      "required" => true),
    array(
      "required" => "Select A Month"
    ),
    array(
      "start" => 1,
      "end" => 12,
      "selectedValue" => $last_draw_month
      )
  
  );
  
  $objst_drawdate->addField("st_DrawDay",  VFORM_SELECT_LIST,
    array(
      "required" => true
    ),
    array(
      "required" => "Select a Day"),
    array(
      "start" => 1,
      "end" => 31,
      "selectedValue" => $last_draw_day
      )
  
  );
  
 
  $obj_MultiDraw = $objForm->addArea("Multiple Draws", true, "multi_draw", false);
  
  
  $objed_drawdate = $obj_MultiDraw->addMultiField("END DRAW DATE");
  
  $obj_2ndLottoEncore = $objForm->addArea("Check Additional Encore Numbers", true, "addEncorenums", false);
  
  $obj_2ndLottoEncore->addField("OLG_Encore_2", "Encore", VFORM_CUSTOM,
        array(
            "required" => false,
            //*** This is a custom regular expression
            //*** for a Dutch tax number.
            "validation" => '/^(\d){7}$/i',
            "minLength" => 7,
            "maxLength" => 7
        ),
        array(
            "type" => "This is not a valid Encore number.",
            "minLength" => "An Encore number is at least %s characters long.",
            "maxLength" => "An Encore number has a maximum of %s characters.",
            "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
        ),
        array(
            //*** A hint value is displayed inside the input field
            //*** and is not allowed to be submitted.
           
            "tip" => "Encore number ex. 1234567"
        )
    );
  
  $obj_2ndLottoEncore->addField("OLG_Encore_3", "Encore", VFORM_CUSTOM,
        array(
            "required" => false,
            //*** This is a custom regular expression
            //*** for a Dutch tax number.
            "validation" => '/^(\d){7}$/i',
            "minLength" => 7,
            "maxLength" => 7
        ),
        array(
            "type" => "This is not a valid Encore number.",
            "minLength" => "An Encore number is at least %s characters long.",
            "maxLength" => "An Encore number has a maximum of %s characters.",
            "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
        ),
        array(
            //*** A hint value is displayed inside the input field
            //*** and is not allowed to be submitted.
           
            "tip" => "Encore number ex. 1234567"
        )
    );
  
  $obj_2ndLottoEncore->addField("OLG_Encore_4", "Encore", VFORM_CUSTOM,
        array(
            "required" => false,
            //*** This is a custom regular expression
            //*** for a Dutch tax number.
            "validation" => '/^(\d){7}$/i',
            "minLength" => 7,
            "maxLength" => 7
        ),
        array(
            "type" => "This is not a valid Encore number.",
            "minLength" => "An Encore number is at least %s characters long.",
            "maxLength" => "An Encore number has a maximum of %s characters.",
            "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
        ),
        array(
            //*** A hint value is displayed inside the input field
            //*** and is not allowed to be submitted.
           
            "tip" => "Encore number ex. 1234567"
        )
    );
  
  $obj_2ndLottoEncore->addField("OLG_Encore_5", "Encore", VFORM_CUSTOM,
        array(
            "required" => false,
            //*** This is a custom regular expression
            //*** for a Dutch tax number.
            "validation" => '/^(\d){7}$/i',
            "minLength" => 7,
            "maxLength" => 7
        ),
        array(
            "type" => "This is not a valid Encore number.",
            "minLength" => "An Encore number is at least %s characters long.",
            "maxLength" => "An Encore number has a maximum of %s characters.",
            "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
        ),
        array(
            //*** A hint value is displayed inside the input field
            //*** and is not allowed to be submitted.
           
            "tip" => "Encore number ex. 1234567"
        )
    );
  
  $obj_2ndLottoEncore->addField("OLG_Encore_6", "Encore", VFORM_CUSTOM,
        array(
            "required" => false,
            //*** This is a custom regular expression
            //*** for a Dutch tax number.
            "validation" => '/^(\d){7}$/i',
            "minLength" => 7,
            "maxLength" => 7
        ),
        array(
            "type" => "This is not a valid Encore number.",
            "minLength" => "An Encore number is at least %s characters long.",
            "maxLength" => "An Encore number has a maximum of %s characters.",
            "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
        ),
        array(
            //*** A hint value is displayed inside the input field
            //*** and is not allowed to be submitted.
           
            "tip" => "Encore number ex. 1234567"
        )
    );
    
    $obj_2ndLottoEncore->addField("OLG_Encore_7", "Encore", VFORM_CUSTOM,
        array(
            "required" => false,
            //*** This is a custom regular expression
            //*** for a Dutch tax number.
            "validation" => '/^(\d){7}$/i',
            "minLength" => 7,
            "maxLength" => 7
        ),
        array(
            "type" => "This is not a valid Encore number.",
            "minLength" => "An Encore number is at least %s characters long.",
            "maxLength" => "An Encore number has a maximum of %s characters.",
            "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
        ),
        array(
            //*** A hint value is displayed inside the input field
            //*** and is not allowed to be submitted.
           
            "tip" => "Encore number ex. 1234567"
        )
    );
  
  $obj_2ndLottoEncore->addField("OLG_Encore_8", "Encore", VFORM_CUSTOM,
        array(
            "required" => false,
            //*** This is a custom regular expression
            //*** for a Dutch tax number.
            "validation" => '/^(\d){7}$/i',
            "minLength" => 7,
            "maxLength" => 7
        ),
        array(
            "type" => "This is not a valid Encore number.",
            "minLength" => "An Encore number is at least %s characters long.",
            "maxLength" => "An Encore number has a maximum of %s characters.",
            "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
        ),
        array(
            //*** A hint value is displayed inside the input field
            //*** and is not allowed to be submitted.
           
            "tip" => "Encore number ex. 1234567"
        )
    );
    
    $obj_2ndLottoEncore->addField("OLG_Encore_9", "Encore", VFORM_CUSTOM,
        array(
            "required" => false,
            //*** This is a custom regular expression
            //*** for a Dutch tax number.
            "validation" => '/^(\d){7}$/i',
            "minLength" => 7,
            "maxLength" => 7
        ),
        array(
            "type" => "This is not a valid Encore number.",
            "minLength" => "An Encore number is at least %s characters long.",
            "maxLength" => "An Encore number has a maximum of %s characters.",
            "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
        ),
        array(
            //*** A hint value is displayed inside the input field
            //*** and is not allowed to be submitted.
           
            "tip" => "Encore number ex. 1234567"
        )
    );
  
  $obj_2ndLottoEncore->addField("OLG_Encore_10", "Encore", VFORM_CUSTOM,
        array(
            "required" => false,
            //*** This is a custom regular expression
            //*** for a Dutch tax number.
            "validation" => '/^(\d){7}$/i',
            "minLength" => 7,
            "maxLength" => 7
        ),
        array(
            "type" => "This is not a valid Encore number.",
            "minLength" => "An Encore number is at least %s characters long.",
            "maxLength" => "An Encore number has a maximum of %s characters.",
            "hint" => "This value is just a hint. Insert your Encore or remove the hint value."
        ),
        array(
            //*** A hint value is displayed inside the input field
            //*** and is not allowed to be submitted.
           
            "tip" => "Encore number ex. 1234567"
        )
    );
  
  
  
  $objed_drawdate->addField("ed_DrawYear", VFORM_SELECT_LIST,
    array(
      "required" => true
    ),
    array("required" => "Select a year"),
    array(
      "start" => intval($st_valid_year),
      "end" => intval($st_valid_year_till),
      "selectedValue" => $last_draw_year)
  );
  
  $objed_drawdate->addField("ed_DrawMonth",  VFORM_SELECT_LIST,
    array(
      "required" => true),
    array(
      "required" => "Select A Month"
    ),
    array(
      "start" => 1,
      "end" => 12,
      "selectedValue" => $last_draw_month
      )
  
  );
  
  $objed_drawdate->addField("ed_DrawDay",  VFORM_SELECT_LIST,
    array(
      "required" => true
    ),
    array(
      "required" => "Select a Day"),
    array(
      "start" => 1,
      "end" => 31,
      "selectedValue" => $last_draw_day
      )
  
  );
  
  
      
  $objForm->setMainAlert("One or more errors occurred. Check the marked fields and try again.");
  $objForm->setSubmitLabel("Submit");
      
  $strOutput = "";
   
  if ($objForm->isSubmitted() && $objForm->isValid()) {
      
     $objst_drdt_ar = $objst_drawdate->getFields();
     $objed_drdt_ar = $objed_drawdate->getFields();

     $lotto_select_list = array();
     $lotto_select_list[0] = $objForm->getValidField("OLG_Encore")->getValue();
     $st_drawdate = date('Y-m-d',mktime(0,0,0,$objst_drdt_ar[1]->getValue(),$objst_drdt_ar[2]->getValue(),$objst_drdt_ar[0]->getValue()));
     if ($objed_drdt_ar[0]->getValue() != "" && $objed_drdt_ar[1]->getValue() != "" && $objed_drdt_ar[2]->getValue() != "") {
       $ed_drawdate = date('Y-m-d', mktime(0,0,0,$objed_drdt_ar[1]->getValue(), $objed_drdt_ar[2]->getValue(), $objed_drdt_ar[0]->getValue()));
     } else {
       $ed_drawdate = $st_drawdate;
     }
   // print "\nst dt: " . $st_drawdate . " --- " . $ed_drawdate;
     $iselection_cnt = 1;
     for ($i = 2; $i <= 10; $i++) {
       if ($objForm->getValidField("OLG_Encore_" . $i)->getValue() != "") {
         $lotto_select_list[$iselection_cnt] = $objForm->getValidField("OLG_Encore_" . $i)->getValue();
         $iselection_cnt++;
       }
     }
     
     $on_encore_nums_ar = null;
     $lotto_validat_res = array();
     $ivalidat_cnt = 0;
     foreach ($lotto_select_list as $single_lotto_num) {
        if (preg_match("/^(\d)(\d)(\d)(\d)(\d)(\d)(\d)$/i", $single_lotto_num, $encore_match)) {
         //print_r($encore_match);
         $on_encore_nums_ar = array($encore_match[1],$encore_match[2],$encore_match[3],$encore_match[4],$encore_match[5],$encore_match[6],$encore_match[7]);
         $lotto_validat_res[$ivalidat_cnt] = array();
         $lotto_validat_res[$ivalidat_cnt]["played_nums"] = $on_encore_nums_ar;
        if (count($on_encore_nums_ar) == 7) {
          //print "\n\n<br />Testing 4--- ";
           $lotto_validat_res[$ivalidat_cnt]["validation_res"] = $OLGLottery->OLGEncoreValidateDraw($st_drawdate, $ed_drawdate, $on_encore_nums_ar[0] , $on_encore_nums_ar[1] , $on_encore_nums_ar[2] , $on_encore_nums_ar[3] , $on_encore_nums_ar[4]  , $on_encore_nums_ar[5], $on_encore_nums_ar[6] );
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
      
      
      
  } else {
      //*** The form has not been submitted or is not valid.
      $strOutput = $objForm->toHtml();
  }


    $data_avail = $OLGLottery->OLGEncoreGetFirstLastDataAvail();


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

$smarty->assign('GAME', 'OLGENCORE');
$smarty->assign('htmltopOut', $htmltopOut);

$JSOUTPUT = "$(document).ready(function() {
			var options = {
				additionalFilterTriggers: [$('#quickfind')],
				clearFiltersControls: [$('#cleanfilters')]           
			};


			$('#lottery_result').tableFilter(options);
			});";





if (is_array($lotto_validat_res)) {
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
			<th>--></th>
			<th>N1</th>
			<th>N2</th>
			<th>N3</th>
			<th>N4</th>
			<th>N5</th>
			<th>N6</th>
			<th>N7</th>
			</tr>

			</thead>
			
			<tbody>";
  	
  
  
  foreach ($lotto_validat_res as $lotto_single_game) {
  
  	if (!is_array($lotto_single_game["validation_res"])) {
  	
  		$htmlOut .= "<tr><td>" . $TSWL_VAR_MSG["invalid_format"] . "</td></tr>";
  		
  		
  	} else {
    
      foreach ($lotto_single_game["validation_res"] as $s_single_match) {
     //print_r($s_single_match);
    $htmlOut .= "<tr><td nowrap id='drawDate'>" .  date('Y-m-d',strtotime($s_single_match["drawdate"])) . "</td>";
    
      $b_win_num_match = false;
      if ($s_single_match["match_numbers"][0] == $lotto_single_game["played_nums"][0]) {
          $htmlOut .=  "<td id='matchNumber'>" . $lotto_single_game["played_nums"][0] . "<sub>&nbsp;&nbsp;Y</sub></td>";
      } elseif ($s_single_match["num_match_ar"][0] == $lotto_single_game["played_nums"][0]) {
          $htmlOut .=  "<td id='noWinButMatch'>" . $lotto_single_game["played_nums"][0] . "<sub>&nbsp;&nbsp;B</sub></td>";
      } else {
          $htmlOut .=  "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][0] . "<sub>&nbsp;&nbsp;N</sub></td>";
      }
     
      if ($s_single_match["match_numbers"][1] == $lotto_single_game["played_nums"][1]) {
          $htmlOut .=  "<td id='matchNumber'>" . $lotto_single_game["played_nums"][1] . "<sub>&nbsp;&nbsp;Y</sub></td>";
      } elseif ($s_single_match["num_match_ar"][1] == $lotto_single_game["played_nums"][1]) {
          $htmlOut .=  "<td id='noWinButMatch'>" . $lotto_single_game["played_nums"][1] . "<sub>&nbsp;&nbsp;B</sub></td>";
      } else {
          $htmlOut .=  "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][1] . "<sub>&nbsp;&nbsp;N</sub></td>";
      }
     
       if ($s_single_match["match_numbers"][2] == $lotto_single_game["played_nums"][2]) {
          $htmlOut .=  "<td id='matchNumber'>" . $lotto_single_game["played_nums"][2] . "<sub>&nbsp;&nbsp;Y</sub></td>";
      } elseif ($s_single_match["num_match_ar"][2] == $lotto_single_game["played_nums"][2]) {
          $htmlOut .=  "<td id='noWinButMatch'>" . $lotto_single_game["played_nums"][2] . "<sub>&nbsp;&nbsp;B</sub></td>";
      } else {
          $htmlOut .=  "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][2] . "<sub>&nbsp;&nbsp;N</sub></td>";
      }
     
      if ($s_single_match["match_numbers"][3] == $lotto_single_game["played_nums"][3]) {
          $htmlOut .=  "<td id='matchNumber'>" . $lotto_single_game["played_nums"][3] . "<sub>&nbsp;&nbsp;Y</sub></td>";
      } elseif ($s_single_match["num_match_ar"][3] == $lotto_single_game["played_nums"][3]) {
          $htmlOut .=  "<td id='noWinButMatch'>" . $lotto_single_game["played_nums"][3] . "<sub>&nbsp;&nbsp;B</sub></td>";
      } else {
          $htmlOut .=  "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][3] . "<sub>&nbsp;&nbsp;N</sub></td>";
      }
     
      if ($s_single_match["match_numbers"][4] == $lotto_single_game["played_nums"][4]) {
          $htmlOut .=  "<td id='matchNumber'>" . $lotto_single_game["played_nums"][4] . "<sub>&nbsp;&nbsp;Y</sub></td>";
      } elseif ($s_single_match["num_match_ar"][4] == $lotto_single_game["played_nums"][4]) {
          $htmlOut .=  "<td id='noWinButMatch'>" . $lotto_single_game["played_nums"][4] . "<sub>&nbsp;&nbsp;B</sub></td>";
      } else {
          $htmlOut .=  "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][4] . "<sub>&nbsp;&nbsp;N</sub></td>";
      }
     
      if ($s_single_match["match_numbers"][5] == $lotto_single_game["played_nums"][5]) {
          $htmlOut .=  "<td id='matchNumber'>" . $lotto_single_game["played_nums"][5] . "<sub>&nbsp;&nbsp;Y</sub></td>";
      } elseif ($s_single_match["num_match_ar"][5] == $lotto_single_game["played_nums"][5]) {
          $htmlOut .=  "<td id='noWinButMatch'>" . $lotto_single_game["played_nums"][5] . "<sub>&nbsp;&nbsp;B</sub></td>";
      } else {
          $htmlOut .=  "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][5] . "<sub>&nbsp;&nbsp;N</sub></td>";
      }
      if ($s_single_match["match_numbers"][6] == $lotto_single_game["played_nums"][6]) {
          $htmlOut .=  "<td id='matchNumber'>" . $lotto_single_game["played_nums"][6] . "<sub>&nbsp;&nbsp;Y</sub></td>";
      } elseif ($s_single_match["num_match_ar"][6] == $lotto_single_game["played_nums"][6]) {
          $htmlOut .=  "<td id='noWinButMatch'>" . $lotto_single_game["played_nums"][6] . "<sub>&nbsp;&nbsp;B</sub></td>";
      } else {
          $htmlOut .=  "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][6] . "<sub>&nbsp;&nbsp;N</sub></td>";
      }
     

      if ($s_single_match["win_prze_amount"] > 0) {
        $htmlOut .=  "<td id='win_amt'>$" . money_format('%(#12n',$s_single_match["win_prze_amount"]) . "</td>";
      } else {
      	$htmlOut .= "<td> &nbsp; </td>";
      }
    
    $htmlOut .= "<td id='drawNumber'>" . $s_single_match["draw_numbers"][0]  . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][1] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][2] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][3] . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][4]  . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][5]  . "</td><td id='drawNumber'>" . $s_single_match["draw_numbers"][6] . "</td></tr>";
 			
      } 
    }
    $icur_game_cnt++;
    
  }
  $htmlOut .= "</tbody></table>";
    $htmlOut .= "<a href='javascript: history.go(-1)'>Go Back</a>";
} else {


$strInst =
 "
Instructions: <br />
To Validate a ticket for a single draw, <br />
Enter the Numbers from your Ticket and 
select the appropriate draw date and click submit. <br /><br />
To validate multiple draws for same number select start draw date and an end draw date.
<br /><br />To validate multiple multiple numbers <br /> 
please select [enable additional numbers] check box <br />
and enter as much as 9 more numbers at same submission. <br /><br />







";

$htmlOut .=
		"<table border='0'>" .
		"<tr>" .
		"<td  width='80%'>" . $strOutput . "</td>" .
		"<td id='instruct'>" .
	$strInst .
		"</td>" .
		"</tr></table>";
}

$htmlOut .= $objAnalytics->GoogleAnalytics();
		
		
$smarty->assign("JSOUTPUT", $JSOUTPUT);
$smarty->assign("htmlOut", $htmlOut);
$smarty->display('templates/validate_numbers.tpl');