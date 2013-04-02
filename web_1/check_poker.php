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
    
    //print_r($lotto_single_game);
    if (is_array($lotto_single_game["validation_res"])) {
      //
      if ($lotto_single_game["validation_res"]["instant_win"] != "") {
       
       // print "Instant win";
        ?>
        <tr><td>
        <?php
            if ($lotto_single_game["validation_res"]["instant_win"] == "rf") {
                 
                  echo "Royal Flush!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "sf") {
                   
                 echo "Straight Flush!!!"; 
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "4k") {
                 echo "4 of a Kind!!!";
                
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "fh") {
                 echo "Full House!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "f") {
               
                  echo "Flush!!!"; 
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "s") {
                  
                echo "Straight!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "3k") {
                  echo "3 of a Kind!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "2p") {
                  echo "Two Pairs!!!";
              } elseif ($lotto_single_game["validation_res"]["instant_win"] == "pj") {
                echo "Pairs!!!"; 
              } ?>
              <br />
              <?php
              $int_match_cnt = 0;
              foreach ($lotto_single_game["validation_res"]["instant_match"] as $i_card) {
                print $i_card;
                if ($int_match_cnt < 4) {
                  print " - ";
                }
                $int_match_cnt++;
              }
              
              ?>
              <br />
              <?php print money_format('%(#12n',$lotto_single_game["validation_res"]["0"]["instant_win_prze_amt"]); ?>
                  </td>
                  </tr>

         
          <?php
       }
        
        
      
      
      
      
      
      foreach ($lotto_single_game["validation_res"] as $s_single_match) {
        // print "\n<br /> Single Match :\n"; 
        // print_r($s_single_match);
        // print "\n<br /> Single Match :\n";
        if (is_array($s_single_match["draw_numbers"])) {
       ?>
     <tr>
    <td><?php print $s_single_match["drawdate"];?></td>
    <td><?php
             $i_crd_pos = 0;
             
             foreach ($lotto_single_game["played_cards"] as $played_crd) {
               $i_match_crd = 0;
              foreach ($s_single_match["match_cards"] as $single_card) {
               if (strtolower($played_crd[2]) == strtolower($single_card)) {
                 echo "<span class='matchNumber'>" . $played_crd[2] . "</span>";
               if ($i_crd_pos < 4) {
                 echo " - ";
                }  
                 $i_match_crd = 1;
               } 


              }
              if ($i_match_crd == 0) {
                echo "<span class='notMatchNumber'>" .  $played_crd[2] . "</span>";
                if ($i_crd_pos < 4) {
                  echo " - ";
                }  
              }
              
             $i_crd_pos++;
            }   
             $i_crd_pos = 0; 
             echo " Draw Cards: ";
            foreach ($s_single_match["draw_numbers"] as $draw_num) {
                echo $draw_num;
                if ($i_crd_pos < 4) {
                  echo " - "; 
                }
                $i_crd_pos++;
            }
    ?></td>
    </tr>
    <?php
    //print_r($s_single_match);
        if ($s_single_match["win_prze_amount"] != "" || $s_single_match["win_prze_amount"] != null) {
      
    
    ?>
                  <tr>
                  <td>
                  <?php print " $ " . money_format('%(#12n',$s_single_match["win_prze_amount"]); ?>
                  </td>
                  </tr>
    <?php
        }  
      
    $icur_game_cnt++;
    }
  }
}
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


