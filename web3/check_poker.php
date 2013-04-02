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
  $naLottery  = new NALottery();
  $OLGLottery = new OLGLottery();
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
  
     $data_avail = $OLGLottery->OLGPokerGetFirstLastDataAvail();
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

  
  
  $objForm = new ValidForm("Check_Poker", "Required fields are printed in bold.");
  $objLottoPoker = $objForm->addArea("Validate Poker", false, "validate_poker");

  //*** A VFORM_CUSTOM field uses a custom regular expression
  //*** for field validation, server- and clientside.
  $objLottoPoker->addField("OLG_Poker", "Poker", VFORM_CUSTOM,
      array(
          "required" => true,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          "hint" => "0C-0D-0H-0S-0C",
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
      )
  );
  
   $objst_drawdate  = $objLottoPoker->addMultiField("START DRAW DATE");
   $onPoker_row     = $objLottery->dbLotteryGamesGet("onPoker");
   
   
   if ($onPoker_row["drawStartDate"] != null) {
     $sGameStartDate = $onPoker_row["drawStartDate"];
   } else {
     $sGameStartDate = "2009-04-01";
   }
   
   if ($onPoker_row["validateDrawDate"] != null) {
     $sGameValidationAvailFrom = $onPoker_row["validateDrawDate"];
   } else {
     $sGameValidationAvailFrom = "2009-04-01";
   }
   
   $st_valid_year       = date('Y', strtotime($sGameValidationAvailFrom));
   $st_valid_year_till  = date('Y');
   $ed_valid_year       = $st_valid_year;
   $ed_valid_year_till  = $st_valid_year;
   
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
 
  $obj_2ndPokerNum = $objForm->addArea("Check Additional Poker Numbers", true, "addPokerNums", false);
  
  $obj_2ndPokerNum->addField("OLG_Poker_2", "Poker", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
      )
  );
  
  $obj_2ndPokerNum->addField("OLG_Poker_3", "Poker", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
      )
  );
  
  $obj_2ndPokerNum->addField("OLG_Poker_4", "Poker", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
      )
  );
  
  $obj_2ndPokerNum->addField("OLG_Poker_5", "Poker", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
      )
  );
  
  $obj_2ndPokerNum->addField("OLG_Poker_6", "Poker", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
      )
  );
  
  $obj_2ndPokerNum->addField("OLG_Poker_7", "Poker", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
      )
  );
  
  $obj_2ndPokerNum->addField("OLG_Poker_8", "Poker", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
      )
  );
  
  $obj_2ndPokerNum->addField("OLG_Poker_9", "Poker", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
          
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
      )
  );
  
  $obj_2ndPokerNum->addField("OLG_Poker_10", "Poker", VFORM_CUSTOM,
      array(
          "required" => false,
          //*** This is a custom regular expression
          //*** for a Dutch tax number.
          "validation" => '/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){4}$/i',
          "minLength" => 3,
          "maxLength" => 25
      ),
      array(
          "type" => "This is not a valid Poker card values.",
          "minLength" => "A Poker card is at least %s characters long.",
          "maxLength" => "A Poker cardhas a maximum of %s characters.",
          "hint" => "This value is just a hint. Insert your Poker or remove the hint value."
      ),
      array(
          //*** A hint value is displayed inside the input field
          //*** and is not allowed to be submitted.
         
          "tip" => "Poker cards example  {5S-10D-3H-2C-4C} -- {{2 - 10 , J, Q, K, A}{C -> Clubs, S -> Spades, D -> Diamonds, H -> Hearts}} "
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
      
    
      //*** HTML body of the email.
      
  
      //*** Send the email.
     // mail("owner@awesomesite.com", "Contact form submitted", $strMessage, $strHeaders);
           
      //*** Set the output to a friendly thank you note.
      //$strOutput = $objForm->valuesAsHtml();
      
      //$strOutput = $objForm->getValidField("email").
      
      
      $objst_drdt_ar = $objst_drawdate->getFields();
      
      $objed_drdt_ar = $objed_drawdate->getFields();
      
      $lotto_select_list = array();
      $lotto_select_list[0] = $objForm->getValidField("OLG_Poker")->getValue();
      $st_drawdate = date('Y-m-d', mktime(0,0,0, $objst_drdt_ar[1]->getValue(), $objst_drdt_ar[2]->getValue(), $objst_drdt_ar[0]->getValue()));
       if ($objed_drdt_ar[0]->getValue() != "" && $objed_drdt_ar[1]->getValue() != "" && $objed_drdt_ar[2]->getValue() != "") {
         $ed_drawdate = date('Y-m-d', mktime(0,0,0,$objed_drdt_ar[1]->getValue(), $objed_drdt_ar[2]->getValue(), $objed_drdt_ar[0]->getValue()));
       } else {
         $ed_drawdate = $st_drawdate;
       }
       $iselection_cnt = 1;
       $str_clean_sym = array("  ",",");
       for ($i = 2; $i <= 10; $i++) {
         if ($objForm->getValidField("OLG_Poker_" . $i)->getValue() != "") {
           $lotto_select_list[$iselection_cnt] = $objForm->getValidField("OLG_Poker_" . $i)->getValue();
           $iselection_cnt++;
         }
       }
       $on_poker_cards_ar = null;
       $ivalidat_cnt = 0;
       
      $lotto_validat_res = array();
      foreach ($lotto_select_list as $single_lotto_num) {
        str_replace($str_clean_sym,"",$single_lotto_num);
      
        if (preg_match("/^([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}$/i", $single_lotto_num, $on_poker_match)) {
          //print_r($on_poker_match);
          $scard1 = $on_poker_match[1];
          $scard2 = $on_poker_match[3];
          $scard3 = $on_poker_match[5];
          $scard4 = $on_poker_match[7];
          $scard5 = $on_poker_match[9];
          
          $on_poker_cards_ar = $OLGLottery->PokerCardsSort($scard1, $scard2, $scard3, $scard4, $scard5); 
          //print_r($on_poker_cards_ar);
           if (count($on_poker_cards_ar) == 5) {
              $lotto_validat_res[$ivalidat_cnt] = array();
              $lotto_validat_res[$ivalidat_cnt]["played_cards"] = $on_poker_cards_ar; 
              $lotto_validat_res[$ivalidat_cnt]["validation_res"] = $OLGLottery->OLGPokerValidateDraw($st_drawdate, $ed_drawdate, $on_poker_cards_ar[0][2],$on_poker_cards_ar[1][2],$on_poker_cards_ar[2][2],$on_poker_cards_ar[3][2],$on_poker_cards_ar[4][2]);
              $ivalidat_cnt++;
           }
          
        }
      
      
      }
      //print_r($lotto_validat_res);
      
      
      
  } else {
      //*** The form has not been submitted or is not valid.
      $strOutput = $objForm->toHtml();
  }
  
  $data_avail = $OLGLottery->OLGPokerGetFirstLastDataAvail();
      

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

$smarty->assign('GAME', 'OLGPOKER');
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
			<th>C1</th>
			<th>C2</th>
			<th>C3</th>
			<th>C4</th>
			<th>C5</th>
			<th>--></th>
			<th>C1</th>
			<th>C2</th>
			<th>C3</th>
			<th>C4</th>
			<th>C5</th>
			</tr>

			</thead>
			
			<tbody>";
     
  
   foreach ($lotto_validat_res as $lotto_single_game) {
  
  	if (!is_array($lotto_single_game["validation_res"])) {
  	
  		$htmlOut .=  $TSWL_VAR_MSG["invalid_format"];
  		
  		
  	} else {
      //
      if ($lotto_single_game["validation_res"]["instant_win"] != "") {
       
       // print "Instant win";
        $htmlOut .= "<tr><td id='matchNumber'>";
            if ($lotto_single_game["validation_res"]["instant_win"] == "rf") {
                 
                   $htmlOut .=  "Royal Flush!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "sf") {
                   
                  $htmlOut .=  "Straight Flush!!!"; 
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "4k") {
                  $htmlOut .=  "4 of a Kind!!!";
                
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "fh") {
                  $htmlOut .=  "Full House!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "f") {
               
                   $htmlOut .=  "Flush!!!"; 
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "s") {
                  
                 $htmlOut .=  "Straight!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "3k") {
                   $htmlOut .=  "3 of a Kind!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "2p") {
                   $htmlOut .=  "Two Pairs!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "pj") {
                 $htmlOut .=  "Pairs!!!"; 
              } 
               $htmlOut .= "</td>";
              $int_match_cnt = 0;
              foreach ($lotto_single_game["validation_res"]["instant_match"] as $i_card) {
                 $htmlOut .=  "<td id='matchNumber'>" . $i_card . "</td>";
                
                $int_match_cnt++;
              }
              

               $htmlOut .= "<td id='win_amt'>" . money_format('%(#12n',$lotto_single_game["validation_res"]["0"]["instant_win_prze_amt"]) . "</td>";
                $htmlOut .= "<td id='notMatchNumber'>&nbsp;</td><td id='notMatchNumber'>&nbsp;</td><td id='notMatchNumber'>&nbsp;</td><td id='notMatchNumber'>&nbsp;</td><td id='notMatchNumber'>&nbsp;</td></tr>";
       }
        
        
      foreach ($lotto_single_game["validation_res"] as $s_single_match) {
        // print "\n<br /> Single Match :\n"; 
        // print_r($s_single_match);
        // print "\n<br /> Single Match :\n";
        if (is_array($s_single_match["draw_numbers"])) {
	      	$htmlOut .= "<tr><td nowrap id='drawDate'>" .  date('Y-m-d',strtotime($s_single_match["drawdate"])) . "</td>";
             $i_crd_pos = 0;
             
             foreach ($lotto_single_game["played_cards"] as $played_crd) {
               $i_match_crd = 0;
               $style_id = "";
              foreach ($s_single_match["match_cards"] as $single_card) {
               if (strtolower($played_crd[2]) == strtolower($single_card)) {
                  $htmlOut .=  "<td id='matchNumber'>" . $played_crd[2] . "<sub>&nbsp;&nbsp;Y</sub></td>";
              
                 $i_match_crd = 1;
               } 


              }
              if ($i_match_crd == 0) {
                 $htmlOut .=  "<td id='notMatchNumber'>" .  $played_crd[2] . "<sub>&nbsp;&nbsp;N</sub></td>";
                
              }
              
             $i_crd_pos++;
            }   
             $i_crd_pos = 0; 

              
              if ($s_single_match["win_prze_amount"] != "" || $s_single_match["win_prze_amount"] != null) {

    		 	$htmlOut .= "<td id='win_amt'>" . " $ " . money_format('%(#12n',$s_single_match["win_prze_amount"]) . "</td>";
        	  }  else {
        	  	$htmlOut .= "<td id='win_amt'>&nbsp;</td>";
        	  }
            foreach ($s_single_match["draw_numbers"] as $draw_num) {
                 $htmlOut .=  "<td id='drawNumber'>" . $draw_num . "</td>";
 
                $i_crd_pos++;
            }
     		$htmlOut .= "</tr>";
    		//print_r($s_single_match);
        
      
    		$icur_game_cnt++;
    		
    	}
    	
  		}
  		
	}
	
	
	}
	
	
	$htmlOut .= "</tbody></table>";
  		$htmlOut .= "<br /><a href='javascript: history.go(-1)'>Go Back</a>";
} else {



$strInst =
 "
Instructions: <br />
To Validate a ticket for a single draw, <br />
Enter the Lotto Poker Cards from your Ticket and 
select the appropriate draw date and click submit. <br />
[H -> Hearts , C -> Clubs, D -> Diamonds, S -> Spades ]
<br />
To validate multiple draws for same number select start draw date and an end draw date.
<br /><br />To validate multiple multiple numbers <br /> 
please select [enable additional numbers] check box <br />
and enter as much as 9 more numbers at same submission. <br /><br />


<br /><br />




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

