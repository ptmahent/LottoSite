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
    
    
  if ($_SESSION['valid']) {
    $iuserNo    = $_SESSION['userid'];
    $sNickName  = $_SESSION['_nickname'];
    $ds_user    = $objUser->UserGet($iuserNo);
    //print_r($ds_user);
    if (is_array($ds_user)) {
      $bLoggedIn = true;
    }
  }
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
	$htmltopOut .= "| Logout";
} else {
		$smarty->assign('userLoggedIn', 0);
	$htmltopOut .= "Login";
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

$htmlOut = "<table border='0'>";


if (!is_array($lotto_validat_res)) {

	/*$htmlOut .= "<tr><td>";
	$htmlOut .= $TSWL_VAR_MSG["unknown_error"];
  	$htmlOut .= "</td></tr>";

	*/
} else {
  $icur_game_cnt = 0;
   foreach ($lotto_validat_res as $lotto_single_game) {
  
  	if (!is_array($lotto_single_game["validation_res"])) {
  	
  		$htmlOut .= "<tr><td>" . $TSWL_VAR_MSG["invalid_format"] . "</td></tr>";
  		
  		
  	} else {
      //
      if ($lotto_single_game["validation_res"]["instant_win"] != "") {
       
       // print "Instant win";
        $htmlOut .= "<tr><td>";
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
               $htmlOut .= "<br />";
              $int_match_cnt = 0;
              foreach ($lotto_single_game["validation_res"]["instant_match"] as $i_card) {
                 $htmlOut .=  $i_card;
                if ($int_match_cnt < 4) {
                   $htmlOut .=  " - ";
                }
                $int_match_cnt++;
              }
              
               $htmlOut .= "<br />";
               $htmlOut .= money_format('%(#12n',$lotto_single_game["validation_res"]["0"]["instant_win_prze_amt"]);
                $htmlOut .= "</td></tr>";
       }
        
     
      foreach ($lotto_single_game["validation_res"] as $s_single_match) {
        // print "\n<br /> Single Match :\n"; 
        // print_r($s_single_match);
        // print "\n<br /> Single Match :\n";
        if (is_array($s_single_match["draw_numbers"])) {
        $htmlOut .= "<tr><td>" . $s_single_match["drawdate"] . "</td><td>";
             $i_crd_pos = 0;
             
             foreach ($lotto_single_game["played_cards"] as $played_crd) {
               $i_match_crd = 0;
              foreach ($s_single_match["match_cards"] as $single_card) {
               if (strtolower($played_crd[2]) == strtolower($single_card)) {
                  $htmlOut .=  "<span class='matchNumber'>" . $played_crd[2] . "</span>";
               if ($i_crd_pos < 4) {
                  $htmlOut .=  " - ";
                }  
                 $i_match_crd = 1;
               } 


              }
              if ($i_match_crd == 0) {
                 $htmlOut .=  "<span class='notMatchNumber'>" .  $played_crd[2] . "</span>";
                if ($i_crd_pos < 4) {
                   $htmlOut .=  " - ";
                }  
              }
              
             $i_crd_pos++;
            }   
             $i_crd_pos = 0; 
              $htmlOut .=  " Draw Cards: ";
            foreach ($s_single_match["draw_numbers"] as $draw_num) {
                 $htmlOut .=  $draw_num;
                if ($i_crd_pos < 4) {
                   $htmlOut .=  " - "; 
                }
                $i_crd_pos++;
            }
     $htmlOut .= "</td></tr>";
    //print_r($s_single_match);
        if ($s_single_match["win_prze_amount"] != "" || $s_single_match["win_prze_amount"] != null) {

    		 $htmlOut .= "<tr><td>" . " $ " . money_format('%(#12n',$s_single_match["win_prze_amount"]) . "</td></tr>";
        }  
      
    $icur_game_cnt++;
    }
    $htmlOut .= "<tr><td><a href='javascript: history.go(-1)'>Go Back</a>";
  }
}
}
}

 $htmlOut .= "</table><table border='0'><tr><td >" . $strOutput . "</td>"
			. "<td>&nbsp;</td></tr></table>"
			. $objAnalytics->GoogleAnalytics(); 

$smarty->assign("htmlOut", $htmlOut);
$smarty->display('validate_numbers.tpl');

