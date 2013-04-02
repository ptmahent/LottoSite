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

  $objForm = new ValidForm("Check_Pick4", "Required fields are printed in bold.");
     $objLottoPick4 = $objForm->addArea("Validate Pick 4", false, "validate_Pick4");

  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $objLottoPick4->addField("OLG_Pick4", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => true,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "0-0-0-0",
          "tip" => "Pick 4 number ex. 0-0-0-0"
      )
  );
  
  $objst_drawdate = $objLottoPick4->addMultiField("START DRAW DATE");
  $onPick4_row    = $objLottery->dbLotteryGamesGet("onPick4");
  if ($onPick4_row["drawStartDate"] != null) {
    $sGameStartDate = $onPick4_row["drawStartDate"];
  } else {
    $sGameStartDate = "1982-06-12";
  }
  
  if ($onPick4_row["validateDrawDate"] != null) {
    $sGameValidationAvailFrom = $onPick4_row["validateDrawDate"];
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
  
  $obj_2ndPick4 = $objForm->addArea("Check Additional Pick 4 Numbers", true, "addPick4Nums", false);
  
   $obj_2ndPick4->addField("OLG_Pick4_2", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 4 number ex. 0-0-0-0"
      )
  );
  
     $obj_2ndPick4->addField("OLG_Pick4_3", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 4 number ex. 0-0-0-0"
      )
  );
  
     $obj_2ndPick4->addField("OLG_Pick4_4", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 4 number ex. 0-0-0-0"
      )
  );
  
   $obj_2ndPick4->addField("OLG_Pick4_5", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 4 number ex. 0-0-0-0"
      )
  );
  

   $obj_2ndPick4->addField("OLG_Pick4_6", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 4 number ex. 0-0-0-0"
      )
  );
  
     $obj_2ndPick4->addField("OLG_Pick4_7", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 4 number ex. 0-0-0-0"
      )
  );
  
     $obj_2ndPick4->addField("OLG_Pick4_8", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 4 number ex. 0-0-0-0"
      )
  );
  
     $obj_2ndPick4->addField("OLG_Pick4_9", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 4 number ex. 0-0-0-0"
      )
  );
  
     $obj_2ndPick4->addField("OLG_Pick4_10", "Pick 4", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^(\d)-(\d)-(\d)-(\d)$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Pick 4 number.",
          "minLength" => "A Pick 4 number is at least %s characters long.",
          "maxLength" => "A Pick 4 number has a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Pick 4 or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.

          "tip" => "Pick 4 number ex. 0-0-0-0"
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
     $lotto_select_list[0] = $objForm->getValidField("OLG_Pick4")->getValue();
     $st_drawdate = date('Y-m-d',mktime(0,0,0,$objst_drdt_ar[1]->getValue(),$objst_drdt_ar[2]->getValue(),$objst_drdt_ar[0]->getValue()));
     if ($objed_drdt_ar[0]->getValue() != "" && $objed_drdt_ar[1]->getValue() != "" && $objed_drdt_ar[2]->getValue() != "") {
       $ed_drawdate = date('Y-m-d', mktime(0,0,0,$objed_drdt_ar[1]->getValue(), $objed_drdt_ar[2]->getValue(), $objed_drdt_ar[0]->getValue()));
     } else {
       $ed_drawdate = $st_drawdate;
     }
     $iselection_cnt = 1;
     for ($i = 2; $i <= 10; $i++) {
       if ($objForm->getValidField("OLG_Pick4_" . $i)->getValue() != "") {
         $lotto_select_list[$iselection_cnt] = $objForm->getValidField("OLG_Pick4_" . $i)->getValue();
         $iselection_cnt++;
       }
     }
     
     $on_pick4_nums_ar    = null;
     $lotto_validat_res   = array();
     $ivalidat_cnt        = 0;
     foreach ($lotto_select_list as $single_lotto_num) {
       
       if (preg_match("/(\d)-(\d)-(\d)-(\d)/i", $single_lotto_num, $on_pick4_match)) {
         //print_r($on_pick4_match);
         $on_pick4_nums_ar = array($on_pick4_match[1], $on_pick4_match[2], $on_pick4_match[3], $on_pick4_match[4]);
         $lotto_validat_res[$ivalidat_cnt] = array();
         $lotto_validat_res[$ivalidat_cnt]["played_nums"] = $on_pick4_nums_ar;
         $play_type_any    = 2;
         if (count($on_pick4_nums_ar) == 4) {
           $lotto_validat_res[$ivalidat_cnt]["validation_res"] = $OLGLottery->OLGPick4ValidateDraw($st_drawdate, $ed_drawdate,$play_type_any, $on_pick4_nums_ar[0], $on_pick4_nums_ar[1], $on_pick4_nums_ar[2], $on_pick4_nums_ar[3]);
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
      
      //print_r($lotto_validat_res);
      
  } else {
      //*** The form has not been submitted or is not valid.
      $strOutput = $objForm->toHtml();
  }
  
  
    $data_avail = $OLGLottery->OLGPick4GetFirstLastDataAvail();


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
	//$htmlOut .= $TSWL_VAR_MSG["invalid_format"] ;
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
			<th>--></th>
			<th>--></th>
			<th>N1</th>
			<th>N2</th>
			<th>N3</th>
			<th>N4</th>
			
			</tr>

			</thead>
			
			<tbody>";
  	
  
  foreach ($lotto_validat_res as $lotto_single_game) {
  
  	if (!is_array($lotto_single_game["validation_res"])) {
  	
  		$htmlOut .= "<tr><td>" . $TSWL_VAR_MSG["invalid_format"] . "</td></tr>";
  		
  		
  	} else {
      //print_r($lotto_single_game["played_nums"]);
      foreach ($lotto_single_game["validation_res"] as $s_single_match) {
     //print_r($s_single_match);
      	$htmlOut .= "<tr><td nowrap id='drawDate'>" .  date('Y-m-d',strtotime($s_single_match["drawdate"])) . "</td>";
      //print_r($s_single_match["match_numbers"]);
      $b_win_num_match = false;
     if (is_array($s_single_match["match_numbers"])) {
        foreach ($s_single_match["match_numbers"] as $snum) {
          if ($snum == $lotto_single_game["played_nums"][0]) {
            $b_win_num_match = true;
            //print "SNUM: " . $snum . " > " . $lotto_single_game["played_nums"][0];
            break;
          } 
          
        }
      }
      if ($b_win_num_match) {
        $htmlOut .= "<td id='matchNumber'>" . $lotto_single_game["played_nums"][0] . "</td>";
      } else {
        $htmlOut .= "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][0] . "</td>";
      }
      
      $b_win_num_match = false;
      if (is_array($s_single_match["match_numbers"])) {
      
        foreach ($s_single_match["match_numbers"] as $snum) {
          if ($snum == $lotto_single_game["played_nums"][1]) {
            $b_win_num_match = true;
            break;
          } 
          
        }
      }
      if ($b_win_num_match) {
        $htmlOut .= "<td id='matchNumber'>" . $lotto_single_game["played_nums"][1] . "</td>";
      } else {
        $htmlOut .= "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][1] . "</td>";
      }
      
      $b_win_num_match = false;
      if (is_array($s_single_match["match_numbers"])) {
      
        foreach ($s_single_match["match_numbers"] as $snum) {
          if ($snum == $lotto_single_game["played_nums"][2]) {
            $b_win_num_match = true;
            break;
          } 
          
        }
      }
      if ($b_win_num_match) {
        $htmlOut .= "<td id='matchNumber'>" . $lotto_single_game["played_nums"][2] . "</td>";
      } else {
        $htmlOut .= "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][2] . "</td>";
      }
      
      
      $b_win_num_match = false;
      if (is_array($s_single_match["match_numbers"])) {
      
        foreach ($s_single_match["match_numbers"] as $snum) {
          if ($snum == $lotto_single_game["played_nums"][3]) {
            $b_win_num_match = true;
            break;
          } 
          
        }
      }
      if ($b_win_num_match) {
        $htmlOut .= "<td id='matchNumber'>" . $lotto_single_game["played_nums"][3] . "</td>";
      } else {
        $htmlOut .= "<td id='notMatchNumber'>" . $lotto_single_game["played_nums"][3] . "</td>";
      }


      if ($s_single_match["win_prze_straight_amount"] > 0) {
        $htmlOut .= "<td id='win_amt'>Straight Win - $" . money_format('%(#12n',$s_single_match["win_prze_straight_amount"]) . "</td>";
      } else {
      	$htmlOut .= "<td id='win_amt'>&nbsp;</td>";
      }


      if ($s_single_match["win_prze_box_amount"] > 0) {
        $htmlOut .= $s_single_match["match_box"];
        $htmlOut .= "<td id='win_amt'> Box Win - $" . money_format('%(#12n',$s_single_match["win_prze_box_amount"]) . "</td>";
      } else {
      	$htmlOut .= "<td id='win_amt'>&nbsp;</td>";
      }

	  $i_draw_pos = 0;
      foreach ($s_single_match["draw_numbers"] as $snum) {
         $htmlOut .= "<td id='drawNumber'>" . $snum . "</td>"; 
         
         $i_draw_pos++;
      }
	$htmlOut .= "</tr>";
    
    
    

      } 
    }
    $icur_game_cnt++;

  }
  $htmlOut .= "</tbody></table>";
  $htmlOut .= "<a href='javascript: history.go(-1)'>Go Back</a>";
}
$htmlOut .= "<table border='0'><tr><td >" . $strOutput . "</td>" 
		. "<td>&nbsp;</td>"
		. "</tr></table>"
		. $objAnalytics->GoogleAnalytics(); 
		
$smarty->assign("htmlOut", $htmlOut);
$smarty->assign("JSOUTPUT", $JSOUTPUT);
$smarty->display('validate_numbers.tpl');


 

