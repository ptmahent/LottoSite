<?php


 /* 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.
 **
 
 ** history of changes
 ** Aug 26 - 2011
*/


      
      
	  $incdir = "inc2";
	  
	  include_once($incdir . "/class_db.php");
	  include_once($incdir . "/incGenDates.php");
	  include_once($incdir . "/incNaLottery.php");
	  include_once($incdir . "/incLottery.php");
	  include_once($incdir . "/incOLGLottery.php");
	  include_once($incdir . "/class_http.php");
	  require_once($incdir . "/incUser.php");
	  require_once($incdir . "/incAnalytics.php");
	  require_once($incdir . "/phpArguments.php");



   $cmdargs = arguments();
   
    $TSWLottoValidator = new TSWLottoValidate();
 
 
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^continue/i", $cmdargs["standard"][1], $lmatches)) {
  	

	} elseif (preg_match("/^startnew/i", $cmdargs["standard"][1], $lmatches)) {
		$TSWLottoValidator->First_Stp_ValidateGames();
	} elseif (preg_match("/^deletehistory/i", $cmdargs["standard"][1], $lmatches)) {
  	
	}
  	

  } else {
	  do {
		fwrite(STDOUT, "\tEnter one of the options Below: \n\n\n");
		fwrite(STDOUT, "\tstartnew \t Start New \n");          // 
		fwrite(STDOUT, "\tcontinue \t Continue from where left off\n");      //
		fwrite(STDOUT, "\tdeletehistory \t Delete History\n\n");      //
		fwrite(STDOUT, "\n\t\n\t: ");   
		do {
		  $selection = trim(fgets(STDIN));
		} while (trim($selection) == '');
		
		
    } while (trim($selection) != 'q');
  }





class TSWLottoValidate {
	
	
	  var $reg_desc_namax ;
	  var $reg_desc_na649 ;
	  var $reg_desc_on49 ;
	  var $reg_desc_onencore ;
	  var $reg_desc_onpoker ;
	  var $reg_desc_onpick3 ;
	  var $reg_desc_onpick4;
	  var $reg_desc_onkeno ;
	  var $reg_desc_onlottario ;
	  var $reg_desc_onearlybird ;
	  
	  var $lbl_namax;
	  var $lbl_na649;
	  var $lbl_on49 ;
	  var $lbl_onencore ;
	  var $lbl_onpick3 ;
	  var $lbl_onpick4 ;
	  var $lbl_onpoker ;
	  var $lbl_onkeno  ;
	  var $lbl_onlottario ;
	  var $lbl_onearlybird ;
	  
	  var $tkt_ln_cost ;
	  
	  
	  var $objLottery;
	  var $objDate   ;
	  var $naLottery ;
	  var $objOLG 	 ;
	  
	  var $initialdir;
	  var $destdir;
	  var $incdir;
	
	function __construct() {
	
	
	
	
	
	 

	  
	  $this->initialdir = "./v2";
      $this->destdir    = "./v2/dest";
	  
	  // availavle games
	  
	  
	  /*$avGames = array("namax" => array("namax"),
					   "na649" => array("na649"),
					   "on49" => array("on49"),
					   "onencore" => array("encore"),
					   "onpick3" => array("pick3"),
					   "onpick4" => array("pick4"),
					   "onkeno" => array("keno"),
					   "onpoker" => array("poker"));
					   
					   */
					   
		
	  
	  
	  // games match variables
	  $this->reg_desc_namax = "max|namax";
	  
	  $this->reg_desc_na649 = "na649|649";
	  $this->reg_desc_on49 = "49|on49";
	  $this->reg_desc_onencore = "encore|onencore";
	  $this->reg_desc_onpoker = "poker|onpoker";
	  $this->reg_desc_onpick3 = "pick3|onpick3";
	  $this->reg_desc_onpick4 = "pick4|onpick4";
	  $this->reg_desc_onkeno = "keno|onkeno";
	  $this->reg_desc_onlottario = "onlottario|lottario";
	  $this->reg_desc_onearlybird = "onearlybird|earlybird";
	  
	  $this->lbl_namax = "namax";
	  $this->lbl_na649 = "na649";
	  $this->lbl_on49  = "on49";
	  $this->lbl_onencore = "onencore";
	  $this->lbl_onpick3 = "onpick3";
	  $this->lbl_onpick4 = "onpick4";
	  $this->lbl_onpoker = "onpoker";
	  $this->lbl_onkeno  = "onkeno";
	  $this->lbl_onlottario = "onlottario";
	  $this->lbl_onearlybird = "onearlybird";
	  
	  $this->tkt_ln_cost = array($this->lbl_namax => 5,
						   $this->lbl_na649 => 2,
						   $this->lbl_on49 => .50,
						   $this->lbl_onencore => 1,
						   $this->lbl_onpick3 => 1,
						   $this->lbl_onpick4 => 1,
						   $this->lbl_onpoker => 2,
						   $this->lbl_onkeno => 1,
						   $this->lbl_onlottario => 1);
	  
	  
	  $this->objLottery = new Lottery();
	  $this->objDate    = new GenDates();
	  $this->naLottery  = new NALottery();
	  $this->objOLG 	= new OLGLottery();
	
	}
	
	
	
	  
	  // check dir for data files
	  
      function First_Stp_ValidateGames() {
      	  
      	  $fl_names = scandir($this->initialdir);
      	  $htmlOut = null;
      	  $totalWinCnt = 0;
      	  $totalWinAmt = 0;
      	  $totalCostAmt = 0;
      	  $totalTktCnt = 0;
      	  $totalLnCnt = 0 ;
      	  $FreeTicketCnt = array(	$this->lbl_namax => 0,
				 					$this->lbl_na649 => 0,
				 					$this->lbl_on49 => 0,
				 					$this->lbl_onencore => 0,
				 					$this->lbl_onpick3 => 0,
				 					$this->lbl_onpick4 => 0,
				 					$this->lbl_onpoker => 0,
				 					$this->lbl_onlottario => 0,
				 					"totalTickets" => 0);
      	  $dataOut = null;
      	  print_r($fl_names);
      	  foreach ($fl_names as $fl_name) {
		     print_r($fl_name);
			 if (preg_match("/\.dat\.php/i",$fl_name,$fl_matches)) {
				 $file_cont = file_get_contents($this->initialdir . "/" . $fl_name);
				 $file_lines = split("\n", $file_cont);
				 
				 $file_htmlOut = null;
				 $file_totalWinCnt = 0;
				 $file_totalWinAmt = 0;
				 $file_totalCostAmt = 0;
				 $file_totalTktCnt = 0;
				 $file_totalLnCnt = 0;
				 $file_totalFreeTicket = array(
				 					$this->lbl_namax => 0,
				 					$this->lbl_na649 => 0,
				 					$this->lbl_on49 => 0,
				 					$this->lbl_onencore => 0,
				 					$this->lbl_onpick3 => 0,
				 					$this->lbl_onpick4 => 0,
				 					$this->lbl_onpoker => 0,
				 					$this->lbl_onlottario => 0
				 					);				 
				 
				 //$file_lotto_ln_ar = array();
				 
				 $file_gm_oldest_date = null;
				 $file_gm_newest_date = null;
				 
				 $tkt_game = null;
				 $tkt_cost = null;
				 $tkt_date = null;
				 $tkt_loc_num = null;
				 $tkt_uniqnum = null;
				 $tkt_extra = null;
				 $tkt_data = null;
				 
				 $lst_game = null;
				 $lst_gm_numbers = null;
				 $lst_gm_cards = null;
				 $lst_gm_date = null;
				 $lst_gm_locnum = null;
				 $lst_gm_uniqnum = null;
				 $lst_gm_extra = null;
				 $lst_gm_data = null;
				 
				 $cur_game= null;
				 $cur_gm_numbers = null;
				 $cur_gm_cards = null;
				 $cur_gm_date = null;
				 $cur_gm_locnum = null;
				 $cur_gm_uniqnum = null;
				 $cur_gm_extra = null;
				 $cur_gm_data = null; 	 
				 
				 
				 foreach ($file_lines as $sl_line) {
				/* 
				 MAX|11-12-17-28-41-46-48|Feb-25-2011|019872-258787
		MAX|01-05-14-17-26-40-42||
		MAX|06-15-26-28-29-39-46||
		NA649|15-23-25-32-34-39|Feb-19-2011|001627-457126
		NA649|03-07-08-09-10-31||
		NA649|09-13-17-19-25-30|Feb-19-2011|001627-622913
		ENCORE|5484141|Feb-19-2011|
		
				 */
				 
				 
					 if (preg_match("/^(" . $this->reg_desc_namax . ")/i", $sl_line, $sl_line_matches)) {
						 
						 
		
						 // match max
						 if (preg_match("/(" . $this->reg_desc_namax . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 print_r($sl_ln_matches);
								
								  $cur_gm_data = array();
								  $cur_gm_data["game"] = $this->lbl_namax;
						 
								  $tkt_data = array();
								  $tkt_data["game"] = "namax";
								  $tkt_data["date"] = strtotime($sl_ln_matches[9]);
								  $tkt_data["locnum"] = $sl_ln_matches[10];
								  $tkt_data["uniqnum"] = $sl_ln_matches[11];
																 
																																 
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
									$sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
									$sl_ln_matches[6],$sl_ln_matches[7],$sl_ln_matches[8]);
								
								  $cur_gm_data["date"] = strtotime($sl_ln_matches[9]);
								  
								  $cur_gm_data["locnum"] = $sl_ln_matches[10];
								  
								  $cur_gm_data["uniqnum"] = $sl_ln_matches[11];
		
		
								// Every New Ticket includes store detail
								$file_totalTktCnt++;
								
		
		
								 
						 } elseif (preg_match("/(" . $this->reg_desc_namax . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
									$sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
									$sl_ln_matches[6],$sl_ln_matches[7],$sl_ln_matches[8]);
		
						 }
						 
						 
						 print_r($cur_gm_data);
						 print "\ndate: " . date('m-d-Y', $cur_gm_data["date"]) . "\n";
						 print_r($lst_gm_data);
						 print_r($tkt_data);
						 $dataOut = $this->ValidateGame($this->lbl_namax, $cur_gm_data, $lst_gm_data, $tkt_data);
					 } elseif (preg_match("/^(" . $this->reg_desc_na649 . ")/i", $sl_line, $sl_line_matches)) {
					 
					 
						 // match 
						 if (preg_match("/(" . $this->reg_desc_na649 . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 print_r($sl_ln_matches);
							
								  $cur_gm_data = array();
								  $cur_gm_data["game"] = $this->lbl_na649;  	 	 	 	 	
							
								  $txt_data["game"] = $this->lbl_na649;
								  $tkt_data["date"] = strtotime($sl_ln_matches[8]);
								  $tkt_data["locnum"] = $sl_ln_matches[9];
								  $tkt_data["uniqnum"] = $sl_ln_matches[10];
						
									  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
									$sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
									$sl_ln_matches[6],$sl_ln_matches[7]);
								
								  $cur_gm_data["date"] = strtotime($sl_ln_matches[8]);
								  
								  $cur_gm_data["locnum"] = $sl_ln_matches[9];
								  
								  $cur_gm_data["uniqnum"] = $sl_ln_matches[10];
		
								 $file_totalTktCnt++;
								 
						 } elseif (preg_match("/(" . $this->reg_desc_na649 . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);
								  $cur_gm_data = array();   	  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
									$sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
									$sl_ln_matches[6],$sl_ln_matches[7]);
		
								  
						 }
						 print_r($cur_gm_data);
						 print_r($lst_gm_data);
						 print_r($tkt_data);
						 
						 //$dataOut = $this->ValidateGame($this->lbl_na649, $cur_gm_data, $lst_gm_data, $tkt_data);
					 } elseif (preg_match("/^(" . $this->reg_desc_on49 . ")/i", $sl_line, $sl_line_matches)) {
					 
						 // match max
						 if (preg_match("/(" . $this->reg_desc_on49 . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches); 
								 
							
								  $tkt_data["game"] = $this->lbl_on49;
								  $tkt_data["date"] = strtotime($sl_ln_matches[8]);
								  $tkt_data["locnum"] = $sl_ln_matches[9];
								  $tkt_data["uniqnum"] = $sl_ln_matches[10];
						
									  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
									$sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
									$sl_ln_matches[6],$sl_ln_matches[7]);
								
								  $cur_gm_data["date"] = strtotime($sl_ln_matches[8]);
								  
								  $cur_gm_data["locnum"] = $sl_ln_matches[9];
								  
								  $cur_gm_data["uniqnum"] = $sl_ln_matches[10];
								 
								 $file_totalTktCnt++;
								 
						 } elseif (preg_match("/(" . $this->reg_desc_on49 . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								  $sl_ln_matches[6],$sl_ln_matches[7]);
						 }
						 
						 print_r($cur_gm_data);
						 print_r($lst_gm_data);
						 print_r($tkt_data);
						 //$dataOut = $this->ValidateGame($this->lbl_on49, $cur_gm_data, $lst_gm_data, $tkt_gm_data);
					 } 
					 elseif (preg_match("/^(" . $this->reg_desc_onlottario . ")/i", $sl_line, $sl_line_matches)) {
					 
						 // match max
						 if (preg_match("/(" . $this->reg_desc_onlottario . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);								 
								 
								 
								  $tkt_data["game"] = "onlottario";
								  $tkt_data["date"] = strtotime($sl_ln_matches[8]);
								  $tkt_data["locnum"] = $sl_ln_matches[9];
								  $tkt_data["uniqnum"] = $sl_ln_matches[10];
						
									  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								  $sl_ln_matches[6],$sl_ln_matches[7]);
								
								  $cur_gm_data["date"] = strtotime($sl_ln_matches[8]);
								  
								  $cur_gm_data["locnum"] = $sl_ln_matches[9];
								  
								  $cur_gm_data["uniqnum"] = $sl_ln_matches[10];
								  
								  $file_totalTktCnt++;
								 
						 } elseif (preg_match("/(" . $this->reg_desc_onlottario . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);								  
								  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								  $sl_ln_matches[6],$sl_ln_matches[7]);
		
						 }
						 print_r($cur_gm_data);
						 print_r($lst_gm_data);
						 print_r($tkt_data);
						 
						//$dataOut = $this->ValidateGame($this->lbl_onlottario, $cur_gm_data, $lst_gm_data, $tkt_data);
					 } elseif (preg_match("/^(" . $this->reg_desc_onearlybird . ")/i", $sl_line, $sl_line_matches)) {
					 
						 // match max
						 if (preg_match("/(" . $this->reg_desc_onearlybird . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);								 
								 
								 
								  $tkt_data["game"] = "onearlybird";
								  $tkt_data["date"] = strtotime($sl_ln_matches[5]);
								  $tkt_data["locnum"] = $sl_ln_matches[6];
								  $tkt_data["uniqnum"] = $sl_ln_matches[7];
						
									  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5]);
								
								  $cur_gm_data["date"] = strtotime($sl_ln_matches[6]);
								  
								  $cur_gm_data["locnum"] = $sl_ln_matches[7];
								  
								  $cur_gm_data["uniqnum"] = $sl_ln_matches[8];
								 
						 } elseif (preg_match("/(" . $this->reg_desc_onearlybird . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);								  
								  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5]);
		
						 }
						 
						 
						 print_r($cur_gm_data);
						 print_r($lst_gm_data);
						 print_r($tkt_data);
						 //$dataOut = $this->ValidateGame($lbl_onearlybird, $cur_gm_data, $lst_gm_data, $tkt_data);
					 }
					 elseif (preg_match("/^(" . $this->reg_desc_onkeno . ")/i", $sl_line, $sl_line_matches)) {
					 
						 // match keno
					
						 
						 if (preg_match("/(" . $this->reg_desc_onkeno . ")\|" .
								 "(\d{1,2})(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								   
							   print_r($sl_ln_matches);		
							   
							   
							  $tkt_data["game"] = "onkeno";
								
							  $tkt_data["date"] = strtotime($sl_ln_matches[21]);
							  $tkt_data["locnum"] = $sl_ln_matches[22];
							  $tkt_data["uniqnum"] = $sl_ln_matches[23];
							  
							  $cur_gm_data["date"] = strtotime($sl_ln_matches[21]);
							  $cur_gm_data["locnum"] = $sl_ln_matches[22];
							  $cur_gm_data["uniqnum"] = $sl_ln_matches[23];
								
							  $file_totalTktCnt++;
								 
							  $cur_gm_data["category"] = 0;
							  $cur_gm_data["numbers"] = array();
					
							  $cur_gm_data["numbers"]["snum1"]  = null;
							  $cur_gm_data["numbers"]["snum2"]   = null;
							  $cur_gm_data["numbers"]["snum3"]   = null;
							  $cur_gm_data["numbers"]["snum4"]   = null;
							  $cur_gm_data["numbers"]["snum5"]   = null;
							  $cur_gm_data["numbers"]["snum6"]   = null;
							  $cur_gm_data["numbers"]["snum7"]   = null;
							  $cur_gm_data["numbers"]["snum8"]   = null;
							  $cur_gm_data["numbers"]["snum9"]   = null;
							  $cur_gm_data["numbers"]["snum10"]  = null;
							if (array_key_exists(20,$sl_ln_matches)) {
							  // 10
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  $cur_gm_data["numbers"]["snum7"] = $sl_ln_matches[14];
							  $cur_gm_data["numbers"]["snum8"] = $sl_ln_matches[16];
							  $cur_gm_data["numbers"]["snum9"] = $sl_ln_matches[18];
							  $cur_gm_data["numbers"]["snum10"] = $sl_ln_matches[20];
							  $cur_gm_data["category"] = 10;          
							}elseif (array_key_exists(18,$sl_ln_matches)) {
							 // 9
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  $cur_gm_data["numbers"]["snum7"] = $sl_ln_matches[14];
							  $cur_gm_data["numbers"]["snum8"] = $sl_ln_matches[16];
							  $cur_gm_data["numbers"]["snum9"] = $sl_ln_matches[18];
							  
							  $cur_gm_data["category"] = 9;
							}elseif (array_key_exists(16,$sl_ln_matches)) {
							  // 8
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  $cur_gm_data["numbers"]["snum7"] = $sl_ln_matches[14];
							  $cur_gm_data["numbers"]["snum8"] = $sl_ln_matches[16];
							  
							  $cur_gm_data["category"] = 8;
							}elseif (array_key_exists(14,$sl_ln_matches)) {
							  // 7
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  $cur_gm_data["numbers"]["snum7"] = $sl_ln_matches[14];
							  
							  $cur_gm_data["category"] = 7;
							}elseif (array_key_exists(12,$sl_ln_matches)) {
							  // 6
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  
							  $cur_gm_data["category"] = 6;
							}elseif (array_key_exists(10,$sl_ln_matches)) {
							  // 5
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  
							  $cur_gm_data["category"] = 5;
							}elseif (array_key_exists(8,$sl_ln_matches)) {
							  // 4
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  
							  $cur_gm_data["category"] = 4;
							}elseif (array_key_exists(6,$sl_ln_matches)) {
							  //3
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["category"] = 3;
							}elseif (array_key_exists(4,$sl_ln_matches)) {
							  // 2
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  
							  $cur_gm_data["category"] = 2;
							 
							} 
								 
								 
								 
						 } elseif (preg_match("/(" . $this->reg_desc_onkeno . ")\|" .
								 "(\d{1,2})(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}/i",
								  $sl_line, $sl_ln_matches)) {
							 print_r($sl_ln_matches);
							 $cur_gm_data["category"] = 0;
							 $cur_gm_numbers = array();
					
							 $cur_gm_data["numbers"]["snum1"]    = null;
							 $cur_gm_data["numbers"]["snum2"]    = null;
							 $cur_gm_data["numbers"]["snum3"]    = null;
							 $cur_gm_data["numbers"]["snum4"]    = null;
							 $cur_gm_data["numbers"]["snum5"]    = null;
							 $cur_gm_data["numbers"]["snum6"]    = null;
							 $cur_gm_data["numbers"]["snum7"]    = null;
							 $cur_gm_data["numbers"]["snum8"]    = null;
							 $cur_gm_data["numbers"]["snum9"]    = null;
							 $cur_gm_data["numbers"]["snum10"]   = null;
							if (array_key_exists(20,$sl_ln_matches)) {
							  // 10
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  $cur_gm_data["numbers"]["snum7"] = $sl_ln_matches[14];
							  $cur_gm_data["numbers"]["snum8"] = $sl_ln_matches[16];
							  $cur_gm_data["numbers"]["snum9"] = $sl_ln_matches[18];
							  $cur_gm_data["numbers"]["snum10"] = $sl_ln_matches[20];
			
							  $cur_gm_data["category"] = 10;          
							}elseif (array_key_exists(18,$sl_ln_matches)) {
							 // 9
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  $cur_gm_data["numbers"]["snum7"] = $sl_ln_matches[14];
							  $cur_gm_data["numbers"]["snum8"] = $sl_ln_matches[16];
							  $cur_gm_data["numbers"]["snum9"] = $sl_ln_matches[18];
							  
							  $cur_gm_data["category"] = 9;
							}elseif (array_key_exists(16,$sl_ln_matches)) {
							  // 8
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  $cur_gm_data["numbers"]["snum7"] = $sl_ln_matches[14];
							  $cur_gm_data["numbers"]["snum8"] = $sl_ln_matches[16];
							  
							  $cur_gm_data["category"] = 8;
							}elseif (array_key_exists(14,$sl_ln_matches)) {
							  // 7
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  $cur_gm_data["numbers"]["snum7"] = $sl_ln_matches[14];
							  
							  $cur_gm_data["category"] = 7;
							}elseif (array_key_exists(12,$sl_ln_matches)) {
							  // 6
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  $cur_gm_data["numbers"]["snum6"] = $sl_ln_matches[12];
							  
							  $cur_gm_data["category"] = 6;
							}elseif (array_key_exists(10,$sl_ln_matches)) {
							  // 5
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  $cur_gm_data["numbers"]["snum5"] = $sl_ln_matches[10];
							  
							  $cur_gm_data["category"] = 5;
							}elseif (array_key_exists(8,$sl_ln_matches)) {
							  // 4
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  $cur_gm_data["numbers"]["snum4"] = $sl_ln_matches[8];
							  
							  $cur_gm_data["category"] = 4;
							}elseif (array_key_exists(6,$sl_ln_matches)) {
							  //3
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  $cur_gm_data["numbers"]["snum3"] = $sl_ln_matches[6];
							  
							  $cur_gm_data["category"] = 3;
							}elseif (array_key_exists(4,$sl_ln_matches)) {
							  // 2
							  $cur_gm_data["numbers"]["snum1"] = $sl_ln_matches[2];
							  $cur_gm_data["numbers"]["snum2"] = $sl_ln_matches[4];
							  
							  $cur_gm_data["category"] = 2;
							 
							} 
		
						 }
						 
						  print_r($cur_gm_data);
						 print_r($lst_gm_data);
						 print_r($tkt_data);
						 
						 //$dataOut = $this->ValidateGame($this->lbl_onkeno, $cur_gm_data, $lst_gm_data, $tkt_data);
					 } elseif (preg_match("/^(" . $this->reg_desc_onencore . ")/i", $sl_line, $sl_line_matches)) {
					 
						 // match encore
						 
							
						 
						 if (preg_match("/(" . $this->reg_desc_onencore . ")\|" .
								 "(\d)(\d)(\d)(\d)(\d)(\d)(\d)\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 
								  print_r($sl_ln_matches);								 
								  
								  $tkt_data["game"] = $this->lbl_onencore;
								  $tkt_data["date"] = strtotime($sl_ln_matches[9]);
							  	  $tkt_data["locnum"] = $sl_ln_matches[10];
							  	  $tkt_data["uniqnum"] = $sl_ln_matches[11];
							  
							  	  $cur_gm_data["date"] = strtotime($sl_ln_matches[9]);
							  	  $cur_gm_data["locnum"] = $sl_ln_matches[10];
							  	  $cur_gm_data["uniqnum"] = $sl_ln_matches[11];
							  	  $cur_gm_data["game"] = $this->lbl_onencore;
								  						
									  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								  $sl_ln_matches[6],$sl_ln_matches[7],$sl_ln_matches[8]);
								
								
								 
						 } elseif (preg_match("/(" . $this->reg_desc_onencore . ")\|" .
								 "(\d)(\d)(\d)(\d)(\d)(\d)(\d)\|" .
								 "([^|]+)/i",
								  $sl_line, $sl_ln_matches)) {
	
								  print_r($sl_ln_matches);								 
								  $cur_gm_data["game"] = $this->lbl_onencore;
								  $cur_gm_data["date"] = strtotime($sl_ln_matches[9]);  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								  $sl_ln_matches[6],$sl_ln_matches[7],$sl_ln_matches[8]);
								
								
								  
						 }
						  print_r($cur_gm_data);
						 print_r($lst_gm_data);
						 print_r($tkt_data);						 
						 
						//$dataOut = $this->ValidateGame($this->lbl_onencore, $cur_gm_data, $lst_gm_data, $tkt_data);
					 }  elseif (preg_match("/^(" . $this->reg_desc_onpick4 . ")/i", $sl_line, $sl_line_matches)) {
					 
						 // match pick 4
						 
							
						 
						 if (preg_match("/(" . $this->reg_desc_onpick4 . ")\|" .
								 "(\d)(\d)(\d)(\d)\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 
								  print_r($sl_ln_matches);	
								  
								  $tkt_data["date"] = strtotime($sl_ln_matches[6]);
							  	  $tkt_data["locnum"] = $sl_ln_matches[7];
							  	  $tkt_data["uniqnum"] = $sl_ln_matches[8];
							  
							  	  $cur_gm_data["date"] = strtotime($sl_ln_matches[8]);
							  	  $cur_gm_data["locnum"] = $sl_ln_matches[7];
							  	  $cur_gm_data["uniqnum"] = $sl_ln_matches[8];
								  
								 $cur_gm_data["numbers"] = array($sl_ln_matches[2], 
								 $sl_ln_matches[3], $sl_ln_matches[4],
								 $sl_ln_matches[5]);
								 
								  $file_totalTktCnt++;
		
								 
								 
						 } elseif (preg_match("/(" . $this->reg_desc_onpick4 . ")\|" .
								 "(\d)(\d)(\d)(\d)/i",
								  $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);									  
								 
								 $cur_gm_data["numbers"] = array($sl_ln_matches[2], 
								 $sl_ln_matches[3], $sl_ln_matches[4],
								 $sl_ln_matches[5]);
		
								  
						 }
						  print_r($cur_gm_data);
						 print_r($lst_gm_data);
						 print_r($tkt_data);						 
						 						 
						 
						//$dataOut = $this->ValidateGame($this->lbl_onpick4, $cur_gm_data, $lst_gm_data, $tkt_data);
					 }elseif (preg_match("/^(" . $this->reg_desc_onpick3 . ")/i", $sl_line, $sl_line_matches)) {
					 
						 // match pick 3
						 
							
						 
						 if (preg_match("/(" . $this->reg_desc_onpick3 . ")\|" .
								 "(\d)(\d)(\d)\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);								 
								 
			  					  $tkt_data["date"] = strtotime($sl_ln_matches[5]);
							  	  $tkt_data["locnum"] = $sl_ln_matches[6];
							  	  $tkt_data["uniqnum"] = $sl_ln_matches[7];
							  
							  	  $cur_gm_data["date"] = strtotime($sl_ln_matches[5]);
							  	  $cur_gm_data["locnum"] = $sl_ln_matches[6];
							  	  $cur_gm_data["uniqnum"] = $sl_ln_matches[7];								 
								 
								 
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2], 
								     $sl_ln_matches[3], $sl_ln_matches[4]);
								 
									  
								  
								 $file_totalTktCnt++;
								 
						 } elseif (preg_match("/(" . $this->reg_desc_onpick3 . ")\|" .
								 "(\d)(\d)(\d)/i",
								  $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);								  
								
								$cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3], $sl_ln_matches[4]);
												  
								  
						 }
						 
			  			 print_r($cur_gm_data);
						 print_r($lst_gm_data);
						 print_r($tkt_data);								 
						//$dataOut = $this->ValidateGame($this->lbl_onpick3, $cur_gm_data, $lst_gm_data, $tkt_data);	 
					 }elseif (preg_match("/^(" . $this->reg_desc_onpoker . ")/i", $sl_line, $sl_line_matches)) {
					 
						 // match poker
						 
							
						 
						 if (preg_match("/(" . $this->reg_desc_onpoker . ")\|" .
								 "([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}\|" . "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);	
								  
								  $tkt_data["date"] = strtotime($sl_ln_matches[11]);
							  	  $tkt_data["locnum"] = $sl_ln_matches[12];
							  	  $tkt_data["uniqnum"] = $sl_ln_matches[13];
							  
							  	  $cur_gm_data["date"] = strtotime($sl_ln_matches[11]);
							  	  $cur_gm_data["locnum"] = $sl_ln_matches[12];
							  	  $cur_gm_data["uniqnum"] = $sl_ln_matches[13];
								  
								  
								 $cur_gm_data["cards"] = array($sl_ln_matches[2], $sl_ln_matches[4],
								 $sl_ln_matches[6],$sl_ln_matches[8], $sl_ln_matches[10]);
								 
								 
								 $file_totalTktCnt++;
						 } elseif (preg_match("/(" . $this->reg_desc_onpoker . ")\|" .
								 "([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}/i", $sl_line, $sl_ln_matches)) {
								  print_r($sl_ln_matches);								  
								  
								 
								 $cur_gm_data["cards"] = array($sl_ln_matches[2], $sl_ln_matches[4],
								 $sl_ln_matches[6],$sl_ln_matches[8], $sl_ln_matches[10]);
								 
						 }
						 
						 print_r($cur_gm_data);
						 print_r($lst_gm_data);
						 print_r($tkt_data);		
						 //$dataOut = $this->ValidateGame($this->lbl_onpick3, $cur_gm_data, $lst_gm_data, $tkt_data);
					 }
		/*
		
				 
				 $file_htmlOut = null;
				 $file_totalWinCnt = 0;
				 $file_totalWinAmt = 0;
				 $file_totalCostAmt = 0;
				 $file_totalFreeTicket = array();		
				 */
				 
				 
						 if ($cur_gm_data["date"] < $file_gm_oldest_date) {
						    $file_gm_oldest_date = $cur_gm_data["date"];
						 } 
						 if ($cur_gm_data["date"] > $file_gm_newest_date) {
						    $file_gm_newest_date = $cur_gm_data["date"];
						 }
						// Count total Tickets
						$totalLnCnt++;
						
						
					foreach ($dataOut as $singleData) {
						$file_htmlOut .= $singleData["html"];
						
						if ($singleData["prze_amt"] > 0) {
						  $file_totalWinAmt .= $singleData["prze_amt"];
					      $file_totalWinCnt += 1;
					    }

					   if ($singleData["FreeTicket"] == 1) {
						if ($singleData["game"] == $this->lbl_namax) {
							$file_totalFreeTicket[$this->lbl_namax] += 1;
						} elseif ($singleData["game"] == $this->lbl_na649) {
							$file_totalFreeTicket[$this->lbl_na649] += 1;
						} elseif ($singleData["game"] == $this->lbl_on49) {
							$file_totalFreeTicket[$this->lbl_on49] += 1;
						} elseif ($singleData["game"] == $this->lbl_onencore) {
							$file_totalFreeTicket[$this->lbl_onencore] += 1;
						} elseif ($singleData["game"] == $this->lbl_onpick3) {
							$file_totalFreeTicket[$this->lbl_onpick3] += 1;
						} elseif ($singleData["game"] == $this->lbl_onpick4) {
							$file_totalFreeTicket[$this->lbl_onpick4] += 1;
						} elseif ($singleData["game"] == $this->lbl_onpoker) {
							$file_totalFreeTicket[$this->lbl_onpoker] += 1;
						} elseif ($singleData["game"] == $this->lbl_onlottario) {
							$file_totalFreeTicket[$this->lbl_onlottario] += 1;
						} 
					   }
						
					  if ($singleData["ln_cost"] > 0) {
						$file_totalCostAmt += $singleData["ln_cost"];
					  }
					}
					
					
					
		
					// End of each Data Line
				 }
				 
				 // Write to html file
				 
				 // dest dir
				 //      /destdir/filename_out.html
				 
				 if (is_dir($this->destdir)) {
				 
				 
				 
				 
				 	$file_totalFreeTicket["totalTickets"] = $file_totalFreeTicket[$this->lbl_namax] + $file_totalFreeTicket[$this->lbl_na649]
				 										+ $file_totalFreeTicket[$this->lbl_on49] + $file_totalFreeTicket[$this->lbl_onencore]
				 										+ $file_totalFreeTicket[$this->lbl_onpick3] + $file_totalFreeTicket[$this->lbl_onpick4]
				 										+ $file_totalFreeTicket[$this->lbl_onpoker];
				 	$file_htmlOut = "<html><head></head><body><div>" . $file_htmlOut . 
				 					"</div><span><br /> Total Win Amount: " . $file_totalWinAmt . 
				 					"<br /> Total Win Count: " . $file_totalWinCnt . 
				 					"<br /> Total Free Tickets : " . 
				 					"<br /> Max : " . $file_totalFreeTicket[$this->lbl_namax] . 
				 					"<br /> 649 : " . $file_totalFreeTicket[$this->lbl_na649] .
				 					"<br /> On 49 : " .  $file_totalFreeTicket[$this->lbl_on49] .
				 					"<br /> On Encore: " .  $file_totalFreeTicket[$this->lbl_onencore] .
				 					"<br /> On Pick 3: " .  $file_totalFreeTicket[$this->lbl_onpick3] .
				 					"<br /> On Pick 4: " .  $file_totalFreeTicket[$this->lbl_onpick4] .
				 					"<br /> On Poker: " .  $file_totalFreeTicket[$this->lbl_onpoker] .
				 					"<br /> On Lottario: " .  $file_totalFreeTicket[$this->lbl_onlottario] .
				 					"<br /> Total Free Tickets: " . $file_totalFreeTicket["totalTickets"] . 
								 	"</span></body></html>";
								 	
								 	$totalWinCnt += $file_totalWinCnt;
								 	$totalWinAmt += $file_totalWinAmt;
								 	$totalCostAmt += $file_totalCostAmt;
								 	$FreeTicketCnt[$this->lbl_namax] += $file_totalFreeTicket[$this->lbl_namax];
								 	$FreeTicketCnt[$this->lbl_na649] += $file_totalFreeTicket[$this->lbl_na649];
								 	$FreeTicketCnt[$this->lbl_on49] += $file_totalFreeTicket[$this->lbl_on49];
								 	$FreeTicketCnt[$this->lbl_onencore] += $file_totalFreeTicket[$this->lbl_onencore];
								 	$FreeTicketCnt[$this->lbl_onpick3] += $file_totalFreeTicket[$this->lbl_onpick3];
								 	$FreeTicketCnt[$this->lbl_onpick4] += $file_totalFreeTicket[$this->lbl_na649];
								 	$FreeTicketCnt[$this->lbl_onlottario] += $file_totalFreeTicket[$this->lbl_onlottario];
								 	$FreeTicketCnt["totalTickets"] += $file_totalFreeTicket["totalTickets"];
					print_r($file_htmlOut);			 	
								 	
				 	if (!file_exists($this->destdir . "/" . $fl_name . ".html")) {
					 	file_put_contents($this->destdir . "/" . $fl_name . ".html", $file_htmlOut);
					}			 	
				 	
				 }
				 
				 // end of If dat.php match
			 }
			 
			 // Total Summary for the run
			 // dest dir
			 //    /destdir/totalSummary_out_[n].html
			 
			 if (is_dir($this->destdir)) {
			 
			 	// data validation history
			 	//
			 	// saves filename ... 
			 	// current date time
			 	// total win amount.. total win cnt... total tickets ..
			 	// total free tickets ... 
			 	// planned
			 	//start date --- end date of tickets
			 	// file_path|strt_date|end_date|total_win_cnt|total_win_amt|total_lotto_ln_cnt|total_tkt_cnt
			 	$history_txt = "\n";
			 	$history_txt .= $this->initialdir . "/" . $fl_name . "|";
			 	$history_txt .= date("M-d-Y h:i:s A");
			 	$history_txt .= "|" . $file_gm_oldest_date;
			 	$history_txt .= "|" . $file_gm_newest_date;
			 	$history_txt .= "|" . $totalWinCnt;
			 	$history_txt .= "|" . $totalWinAmt;
			 	$history_txt .= "|" . $totalLnCnt;
			 	$history_txt .= "|" . $file_totalTktCnt ;
			 	
			    
			    if (!file_exists($this->destdir . "/history.tswlotto.html")) {
			       file_put_contents($this->destdir . "/history.tswlotto.html" , $history_txt);
			    } else {
			       file_put_contents($this->destdir . "/history.tswlotto.html" , $history_txt, FILE_APPEND);
			    }
			    
			 
			 	// open the totoalSummary_out_[n] not available
			 	$initcnt = 0;
			 	while (file_exists($this->destdir . "/totalSummary_out_" . $initcnt . ".html")) {
			 	   $initcnt++;
			 	}
			 	$htmlSummary = "";
			 	$htmlSummary .= "<html><head></head><body><div>" .
			 				"\n<br />Total Win Amount: " . $totalWinAmt . 
			 				"\n<br />Total Win Count: " . $totalWinCnt . 
			 				"\n<br />Total Free Tickets: " . $FreeTicketCnt["totalTickets"] .
			 				"<br /> Total Free Tickets : " . 
				 			"<br /> Max : " . $FreeTicketCnt[$this->lbl_namax] . 
				 			"<br /> 649 : " . $FreeTicketCnt[$this->lbl_na649] .
				 			"<br /> On 49 : " .  $FreeTicketCnt[$this->lbl_on49] .
				 			"<br /> On Encore: " .  $FreeTicketCnt[$this->lbl_onencore] .
				 			"<br /> On Pick 3: " .  $FreeTicketCnt[$this->lbl_onpick3] .
				 			"<br /> On Pick 4: " .  $FreeTicketCnt[$this->lbl_onpick4] .
				 			"<br /> On Poker: " .  $FreeTicketCnt[$this->lbl_onpoker] .
				 			"<br /> On Lottario: " .  $FreeTicketCnt[$this->lbl_onlottario] .
				 			"<br /> Total Free Tickets: " . $FreeTicketCnt["totalTickets"] . 
				 			"</div></body></html>";
			 	print_r($htmlSummary);
			 	file_put_contents($this->destdir . "/totalSummary_out_" . $initcnt . ".html", $htmlSummary);
			 	
			 	
			 }
			 
			 
		    // End of File List from Dir Loop
		  }
       // End of Function
      }
	  
	  function ValidateGame($theGame, $cur_gm_data, $lst_gm_data, $tkt_gm_data) {
	  
		 /*
		 
		   $this->lbl_namax = "namax";
	  $this->lbl_na649 = "na649";
	  $this->lbl_on49  = "on49";
	  $this->lbl_onencore = "onencore";
	  $this->lbl_onpick3 = "onpick3";
	  $this->lbl_onpick4 = "onpick4";
	  $this->lbl_onkeno  = "onkeno";
	  $this->lbl_onlottario = "onlottario";
	  $lbl_onearlybird = "onearlybird";
		 
		 
		 */
		 $dataOut = null;
		 $htmlOut = null;
		 $totalCost = 0;
		 $totalWin = 0;
		 $totalFreeTicket = 0;
		 $gameCount = 0;
		 
		 if ($theGame == $this->lbl_namax) {
			$dataOut .= $this->ValidateNaMax($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5],
									   $cur_gm_data["numbers"][6]);
			/*if ($dataOut["html"] != "") {
				$htmlOut .= $dataOut["html"];
			}
			if ($dataOut["prze_amt"] > 0) {
				$totalWin = $totalWin + $dataOut["prze_amt"];
			}
			if ($dataOut["FreeTicket"] == 1) {
				$totalFreeTicket = $totalFreeTicket + 1;
			} 
		
			if ($dataOut["ln_cost"] > 0) {
				$totalCost = $totalCost + $dataOut["ln_cost"];
			}
		    */
	
	
	
	
			
		 } elseif ($theGame == $this->lbl_na649) {
			$dataOut .= $this->ValidateNa649($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
	
		 	/*if ($dataOut["html"] != "") {
				$htmlOut .= $dataOut["html"];
			}
			if ($dataOut["prze_amt"] > 0) {
				$totalWin = $totalWin + $dataOut["prze_amt"];
			}
			if ($dataOut["FreeTicket"] == 1) {
				$totalFreeTicket = $totalFreeTicket + 1;
			} 
			if ($dataOut["ln_cost"] > 0) {
				$totalCost = $totalCost + $dataOut["ln_cost"];
			}
			*/
		 } elseif ($theGame == $this->lbl_on49) {
			$dataOut .= $this->ValidateOn49($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]
									   );
	
		    /*
	 	    if ($dataOut["html"] != "") {
				$htmlOut .= $dataOut["html"];
			}
			if ($dataOut["prze_amt"] > 0) {
				$totalWin = $totalWin + $dataOut["prze_amt"];
			}
			if ($dataOut["FreeTicket"] == 1) {
				$totalFreeTicket = $totalFreeTicket + 1;
			} 
			
			if ($dataOut["ln_cost"] > 0) {
				$totalCost = $totalCost + $dataOut["ln_cost"];
			}
			*/
	
		 } elseif ($theGame == $this->lbl_onencore) {
			$dataOut .= $this->ValidateOnEncore($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5],
									   $cur_gm_data["numbers"][6]);
	 	  /*
	 	    if ($dataOut["html"] != "") {
				$htmlOut .= $dataOut["html"];
			}
			if ($dataOut["prze_amt"] > 0) {
				$totalWin = $totalWin + $dataOut["prze_amt"];
			}
			if ($dataOut["FreeTicket"] == 1) {
				$totalFreeTicket = $totalFreeTicket + 1;
			} 
	
		 	if ($dataOut["ln_cost"] > 0) {
				$totalCost = $totalCost + $dataOut["ln_cost"];
			}
			
			*/
		 } elseif ($theGame == $this->lbl_onpick3) {
			$dataOut .= $this->ValidateOnPick3($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2]);
								
	    /*
	        if ($dataOut["html"] != "") {
				$htmlOut .= $dataOut["html"];
			}
			if ($dataOut["prze_amt"] > 0) {
				$totalWin = $totalWin + $dataOut["prze_amt"];
			}
			if ($dataOut["FreeTicket"] == 1) {
				$totalFreeTicket = $totalFreeTicket + 1;
			} 
			if ($dataOut["ln_cost"] > 0) {
				$totalCost = $totalCost + $dataOut["ln_cost"];
			}
			
			*/
		 } elseif ($theGame == $this->lbl_onpick4) {
			$dataOut .= $this->ValidateOnPick4($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3]
									  );
	     /*
	        if ($dataOut["html"] != "") {
				$htmlOut .= $dataOut["html"];
			}
			if ($dataOut["prze_amt"] > 0) {
				$totalWin = $totalWin + $dataOut["prze_amt"];
			}
			if ($dataOut["FreeTicket"] == 1) {
				$totalFreeTicket = $totalFreeTicket + 1;
			} 
			if ($dataOut["ln_cost"] > 0) {
				$totalCost = $totalCost + $dataOut["ln_cost"];
			}
			
			*/
		 } elseif ($theGame == $this->lbl_onkeno) {
			$dataOut .= $this->ValidateOnKeno($cur_gm_data["date"],
									   $cur_gm_data["category"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5],
									   $cur_gm_data["numbers"][6],
									   $cur_gm_data["numbers"][7],
									   $cur_gm_data["numbers"][8],
									   $cur_gm_data["numbers"][9]);
	
	       /*
	         if ($dataOut["html"] != "") {
				$htmlOut .= $dataOut["html"];
			}
			if ($dataOut["prze_amt"] > 0) {
				$totalWin = $totalWin + $dataOut["prze_amt"];
			}
			if ($dataOut["FreeTicket"] == 1) {
				$totalFreeTicket = $totalFreeTicket + 1;
			} 
			if ($dataOut["ln_cost"] > 0) {
				$totalCost = $totalCost + $dataOut["ln_cost"];
			}
			
			*/
		 } elseif ($theGame == $this->lbl_onlottario) {
			$dataOut .= $this->ValidateOnLottario($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
	
	      /*  if ($dataOut["html"] != "") {
				$htmlOut .= $dataOut["html"];
			}
			if ($dataOut["prze_amt"] > 0) {
				$totalWin = $totalWin + $dataOut["prze_amt"];
			}
			if ($dataOut["FreeTicket"] == 1) {
				$totalFreeTicket = $totalFreeTicket + 1;
			} 
			if ($dataOut["ln_cost"] > 0) {
				$totalCost = $totalCost + $dataOut["ln_cost"];
			}
			*/
		 } elseif ($theGame == $lbl_onearlybird) {
			$dataOut .= $this->ValidateOnLottario($cur_gm_data["date"],
									   0,
									   0,
									   0,
									   0,
									   0,
									   0,
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3]);
			
			/*if ($dataOut["html"] != "") {
				$htmlOut .= $dataOut["html"];
			}
			if ($dataOut["prze_amt"] > 0) {
				$totalWin = $totalWin + $dataOut["prze_amt"];
			}
			if ($dataOut["FreeTicket"] == 1) {
				$totalFreeTicket = $totalFreeTicket + 1;
			} 
			if ($dataOut["ln_cost"] > 0) {
				$totalCost = $totalCost + $dataOut["ln_cost"];
			}
			*/
		 }
	  
	  
	     /// Append Data to HTML OUTPUT
	     
	     //$htmlOut .= "<tr><td>" . $htmlOut . "</td></tr>";
	  	return $dataOut;
	  }
	  
	  function ValidateNa649($sdrawDate, $snum1, $num2, $snum3, $snum4, $snum5, $snum6) {
	  
		 $sdrawDate = date('Y-m-d', $sdrawDate);
		 $result =  $this->naLottery->na649ValidateDraw($sdrawDate, $sdrawDate, $snum1, $snum2 , $snum3, $snum4 , $snum5 , $snum6 );
	
		 $dataOut = array();
		 
		 
		 
		 $irec_cnt = 0;
		 foreach ($result as $single_result) {
			 $b_win_num_match = false;
			 $b_bonus_num_match = false;
			 $b_match_cnt = 0;
			 $dataOut[$irec_cnt] = array();
			 $dataOut[$irec_cnt]["html"] .= "\n<br />649 Draw Date: " . $single_result["drawdate"];
			 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum1) {
					$b_win_num_match = true;
					break;
				} elseif ($snum1 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum1 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum1 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum1 . "</span>";
			 }
		
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum2) {
					$b_win_num_match = true;
					break;
				} elseif ($snum2 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum2 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum2 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum2 . "</span>";
			 }
				 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum3) {
					$b_win_num_match = true;
					break;
				} elseif ($snum3 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum3 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum3 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum3 . "</span>";
			 }
			 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum4) {
					$b_win_num_match = true;
					break;
				} elseif ($snum4 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum4 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum4 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum4 . "</span>";
			 }
			$b_win_num_match = false; 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum5) {
					$b_win_num_match = true;
					break;
				} elseif ($snum5 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum5 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum5 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum5 . "</span>";
			 }
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum6) {
					$b_win_num_match = true;
					break;
				} elseif ($snum6 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum6 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum6 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum6 . "</span>";
			 }
			 
			 
			 
			 
			 $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_na649];
			 $dataOut[$irec_cnt]["game"] = $this->lbl_na649;
			 
			 if ($b_match_cnt == 6) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 5 && $b_bonus_num_match) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 5) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 4) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 3) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 2 && $b_bonus_num_match) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				if ($single_result["win_prze_type"] == 1) {
					/// Free Ticket
					$dataOut[$irec_cnt]["prze_amt"] = 0;
					$dataOut[$irec_cnt]["FreeTicket"] = 1;
				}
			 } else {
				// no prize
			 }
			 
			 if ($dataOut["FreeTicket"] == 1) {
				$dataOut[$irec_cnt]["html"] .= " Won a Free Ticket";
			 } elseif ($dataOut["prze_amt"] > 0) {
				$dataOut[$irec_cnt]["html"] .= "Won - <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
			 } 
			 
			 
			 
			 
			 $irec_cnt++;
			 // end of foreach loop
			 
		 }
		 
	
		 return $dataOut;
	  
	  }
	  
	  function ValidateNaMax($sdrawDate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7) {
	  

		$sdrawDate = date('Y-m-d', $sdrawDate);
		  $result = $this->naLottery->naMaxValidateDraw($sdrawDate,$sdrawDate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7);
	  
		 print "\nMax Result: \n";
		 print_r($result);
		 $dataOut = array();
		 
		 
		 
		 $irec_cnt = 0;
		 foreach ($result as $single_result) {
		    print "\nSingle Result: " ;
		 	print_r($single_result);
			 $b_win_num_match = false;
			 $b_bonus_num_match = false;
			 $b_match_cnt = 0;
			 $dataOut[$irec_cnt] = array();
			 $dataOut[$irec_cnt]["html"] = "\n<br />Max Draw Date: " . $single_result["drawdate"];
			 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum1) {
					$b_win_num_match = true;
					break;
				} elseif ($snum1 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum1 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum1 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum1 . "</span>";
			 }
		
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum2) {
					$b_win_num_match = true;
					break;
				} elseif ($snum2 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum2 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum2 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum2 . "</span>";
			 }
				 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum3) {
					$b_win_num_match = true;
					break;
				} elseif ($snum3 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum3 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum3 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum3 . "</span>";
			 }
			 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum4) {
					$b_win_num_match = true;
					break;
				} elseif ($snum4 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum4 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum4 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum4 . "</span>";
			 }
			$b_win_num_match = false; 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum5) {
					$b_win_num_match = true;
					break;
				} elseif ($snum5 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum5 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum5 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum5 . "</span>";
			 }
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum6) {
					$b_win_num_match = true;
					break;
				} elseif ($snum6 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum6 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum6 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum6 . "</span>";
			 }
			 
			 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum7) {
					$b_win_num_match = true;
					break;
				} elseif ($snum7 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum7 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum7 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum7 . "</span>";
			 }
			 
			 
			 
			 
			 $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_namax];
			 $dataOut[$irec_cnt]["game"] = $this->lbl_namax;
			 
			 if ($single_result["isequencenum"] > 0) {
				if ($b_match_cnt == 6) {
				   $dataOut[$irec_cnt]["isequencenum"] = $single_result["isequencenum"];
				   $dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				}
			 } else {
			 $dataOut[$irec_cnt]["isequencenum"] = $single_result["isequencenum"];
			 if ($b_match_cnt == 6) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 5 && $b_bonus_num_match) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 5) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 4) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 3) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 2 && $b_bonus_num_match) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				if ($single_result["win_prze_type"] == 1) {
					/// Free Ticket
					$dataOut[$irec_cnt]["prze_amt"] = 0;
					$dataOut[$irec_cnt]["FreeTicket"] = 1;
				}
			 } else {
				// no prize
			 }
		
			 }
					 
			 if ($dataOut["FreeTicket"] == 1) {
				$dataOut[$irec_cnt]["html"] .= " Won a Free Ticket";
			 } elseif ($dataOut["prze_amt"] > 0) {
				$dataOut[$irec_cnt]["html"] .= "Won - <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
			 } else {
				$dataOut[$irec_cnt]["html"] .= " Not A Winning Line";
			 }
			 
			 
			 
			 
			 $irec_cnt++;
			 // end of foreach loop
			 
		 }
		 return $dataOut;
		 
	  
	  }
	  
	  function ValidateOn49($sdrawDate, $snum1, $num2, $snum3, $snum4, $snum5, $snum6) {
	  
		  $sdrawDate = date('Y-m-d', $sdrawDate);
		  $result = $this->objOLG->OLG49ValidateDraw($sdrawDate, $sdrawDate, $snum1 , $snum2, $snum3 , $snum4 , $snum5  , $snum6);
	
	
		$dataOut = array();
		 
		 
		 
		 $irec_cnt = 0;
		 foreach ($result as $single_result) {
			 $b_win_num_match = false;
			 $b_bonus_num_match = false;
			 $b_match_cnt = 0;
			 $dataOut[$irec_cnt] = array();
			 $dataOut[$irec_cnt]["html"] .= "\n<br />Ontario 49 Draw Date: " . $single_result["drawdate"];
			 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum1) {
					$b_win_num_match = true;
					break;
				} elseif ($snum1 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum1 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum1 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum1 . "</span>";
			 }
		
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum2) {
					$b_win_num_match = true;
					break;
				} elseif ($snum2 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum2 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum2 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum2 . "</span>";
			 }
				 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum3) {
					$b_win_num_match = true;
					break;
				} elseif ($snum3 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum3 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum3 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum3 . "</span>";
			 }
			 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum4) {
					$b_win_num_match = true;
					break;
				} elseif ($snum4 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum4 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum4 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum4 . "</span>";
			 }
			$b_win_num_match = false; 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum5) {
					$b_win_num_match = true;
					break;
				} elseif ($snum5 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum5 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum5 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum5 . "</span>";
			 }
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum6) {
					$b_win_num_match = true;
					break;
				} elseif ($snum6 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum6 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum6 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum6 . "</span>";
			 }
			 
			 
			 
			 
			 $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_on49];
			 $dataOut[$irec_cnt]["game"] = $this->lbl_on49;
			 
			 if ($b_match_cnt == 6) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 5 && $b_bonus_num_match) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 5) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 4) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 3) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 
			 } else {
				// no prize
			 }
			 
			 if ($dataOut["prze_amt"] > 0) {
				$dataOut[$irec_cnt]["html"] .= "Won - <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
			 } 
			 
			 
			 
			 
			 $irec_cnt++;
			 // end of foreach loop
			 
		 }
		 
	
		 return $dataOut;
	
	
	
	  }
	  
	  function ValidateOnKeno($sdrawDate, $icat, $snum1, $num2 = null, $num3 = null, $num4 = null, $num5 = null, $num6 = null, $num7 = null, $num8 = null, $num9 = null, $num10 = null) {
		  
		  $sdrawDate = date('Y-m-d', $sdrawDate);
		  $result = $this->objOLG->OLGKenoValidateDraw
						  ($sdrawDate, $sdrawDate, $icat, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10);
		  
		  
		  
		 $dataOut = array();
	
		 $irec_cnt = 0;
		 foreach ($result as $single_result) {
			 $b_win_num_match = false;
			 $b_bonus_num_match = false;
			 $b_match_cnt = 0;
			 $dataOut[$irec_cnt] = array();
			 $dataOut[$irec_cnt]["html"] .= "\n<br />Ontario Keno Draw Date: " . $single_result["drawdate"];	 
			 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum1) {
					$b_win_num_match = true;
					break;
				} 
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum1 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum1 . "</span>";
			 }
		
			 if ($single_result["category"] >= 2) {
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum2) {
					$b_win_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum2 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum2 . "</span>";
			 }
				 
			 }
			 
			 if ($single_result["category"] >= 3) {
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum3) {
					$b_win_num_match = true;
					break;
				} 
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum3 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum3 . "</span>";
			 }
			 
			 }
			 
			 if ($single_result["category"] >= 4) {
			 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum4) {
					$b_win_num_match = true;
					break;
				} 
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum4 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum4 . "</span>";
			 }
			 
			 }
			 
			 if ($single_result["category"] >= 5) {
			 $b_win_num_match = false; 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum5) {
					$b_win_num_match = true;
					break;
				} 
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum5 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum5 . "</span>";
			 }
			 
			 }
			 
			 if ($single_result["category"] >= 6) {
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum6) {
					$b_win_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum6 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum6 . "</span>";
			 }
			 
			 }
			 
		
			 
					 
			 if ($single_result["category"] >= 7) {
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum7) {
					$b_win_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum7 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum7 . "</span>";
			 }
			 
			 }
		
			 if ($single_result["category"] >= 8) {
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum8) {
					$b_win_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum8 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum8 . "</span>";
			 }
			 
			 }
			 
			 
			 if ($single_result["category"] >= 9) {
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum9) {
					$b_win_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum9 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum9 . "</span>";
			 }
			 
			 }
			 
			 
		 
			  if ($single_result["category"] >= 10) {
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum10) {
					$b_win_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum10 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum10 . "</span>";
			 }
			 
			 }
			 
			 
					 
							 
			 $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onkeno];
			 $dataOut[$irec_cnt]["game"] = $this->lbl_onkeno;
			 $dataOut["category"] = $single_result["category"];
			 
			 if ($single_result["category"] == 10) {
				 if ($b_match_cnt == 10) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				 
				 } elseif ($b_match_cnt == 9) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				 } elseif ($b_match_cnt == 8) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				 } elseif ($b_match_cnt == 7) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				 } elseif ($b_match_cnt == 0) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				 }
			  } elseif ($single_result["category"] == 9) {
				 if ($b_match_cnt == 9) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				 } elseif ($b_match_cnt == 8) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				 } elseif ($b_match_cnt == 7) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];     
				 } elseif ($b_match_cnt == 6) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	     
				 }
			  
			  } elseif ($single_result["category"] == 8) {
			  
				 if ($b_match_cnt == 8) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	     
				 } elseif ($b_match_cnt == 7) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	     
				 } elseif ($b_match_cnt == 6) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	     
				 }
			  
			  
			  } elseif ($single_result["category"] == 7) {
			  
				 if ($b_match_cnt == 7) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	     
				 } elseif ($b_match_cnt == 6) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	     
				 } elseif ($b_match_cnt == 5) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	     
				 }
			  
			  } elseif ($single_result["category"] == 6) {
				if ($b_match_cnt == 6) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	  	
				} elseif ($b_match_cnt == 5) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
				}
			  
			  
			  } elseif ($single_result["category"] == 5) {
				if ($b_match_cnt == 5) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	    
				} elseif ($b_match_cnt == 4) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	    
				
				}
			  
			  } elseif ($single_result["category"] == 4) {
			  
				if ($b_match_cnt == 4) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	    
				} 
			  
			  
			  } elseif ($single_result["category"] == 3) {
				if ($b_match_cnt == 3) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];    
				}
			  
			  } elseif ($single_result["category"] == 2) {
				if ($b_match_cnt == 2) {
					$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];	  	
				}
			  }
			  
			 
			 
			 if ($dataOut["prze_amt"] > 0) {
				$dataOut[$irec_cnt]["html"] .= "Won - <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
			 } 
			 
			 
			 
			 
			 $irec_cnt++;
			 // end of foreach loop
			 
		 }
		 
	
		 return $dataOut;
	
		  
		  
	 
		  
	  }
	  
	  function ValidateOnPoker($sdrawDate, $scard1, $scard2, $scard3, $scard4, $scard5) {
	  
		  $sdrawDate = date('Y-m-d', $sdrawDate);
		  $result = $this->objOLG->OLGPokerValidateDraw($sdrawDate, $sdrawDate, $scard1,$scard2,$scard3,$scard4,$scard5);
	  
		  $dataOut = array();
		  $irow_cnt = 0;
		  
	
		  
		  foreach ($result as $single_result) {
			 
			 $dataOut[$irow_cnt] = array();
	
			$imatch_cnt = 0;  	  	
			$i_crd_pos = 0;
			$i_match_crd = 0;
			// First Card
			
			$dataOut[$irec_cnt]["html"] .= "\n<br />Ontario Poker Draw Date: " . $single_result["drawdate"];
			foreach ($single_result["match_cards"] as $single_card) {
		  
			  if (strtolower($scard1) == strtolower($single_card)) {
				 $dataOut["html"] .= "<span class='matchNumber'>" . $scard1 . "</span>";
				 
				 if ($i_crd_pos < 4) {
				   $dataOut["html"] .=  " - ";
				 }  
				 $i_crd_pos++;
				 $i_match_crd = 1;
				 $imatch_cnt++;
			   } 
			}
			
			
			if ($i_match_crd == 0) {
			   $dataOut["html"] .= "<span class='notMatchNumber'>" .  $scard1 . "</span>";
			   if ($i_crd_pos < 4) {
				 $dataOut["html"] .= " - ";
				}  
				$i_crd_pos++;
			 }
			 $i_match_crd = 0;
			 
			 // Second Card
		  
		  foreach ($single_result["match_cards"] as $single_card) {
		  
			  if (strtolower($scard2) == strtolower($single_card)) {
				 $dataOut["html"] .= "<span class='matchNumber'>" . $scard2 . "</span>";
				 if ($i_crd_pos < 4) {
				   $dataOut["html"] .=  " - ";
				 }  
				 $i_crd_pos++;
				 $i_match_crd = 1;
				 $imatch_cnt++;
			   } 
			}
			
			
			if ($i_match_crd == 0) {
			   $dataOut["html"] .= "<span class='notMatchNumber'>" .  $scard2 . "</span>";
			   if ($i_crd_pos < 4) {
				 $dataOut["html"] .= " - ";
				}  
				$i_crd_pos++;
			 }
				  
			// Third Card
			
		  
			foreach ($single_result["match_cards"] as $single_card) {
		  
			  if (strtolower($scard3) == strtolower($single_card)) {
				 $dataOut["html"] .= "<span class='matchNumber'>" . $scard3 . "</span>";
				 if ($i_crd_pos < 4) {
				   $dataOut["html"] .=  " - ";
				 }  
				 $i_crd_pos++;
				 $i_match_crd = 1;
				 $imatch_cnt++;
			   } 
			}
			
			
			if ($i_match_crd == 0) {
			   $dataOut["html"] .= "<span class='notMatchNumber'>" .  $scard3 . "</span>";
			   if ($i_crd_pos < 4) {
				 $dataOut["html"] .= " - ";
				}  
				$i_crd_pos++;
			 }
			 
			 // Fourth Card
			 
			 
		  foreach ($single_result["match_cards"] as $single_card) {
		  
			  if (strtolower($scard4) == strtolower($single_card)) {
				 $dataOut["html"] .= "<span class='matchNumber'>" . $scard4 . "</span>";
				 if ($i_crd_pos < 4) {
				   $dataOut["html"] .=  " - ";
				 }  
				 $i_crd_pos++;
				 $i_match_crd = 1;
				 $imatch_cnt++;
			   } 
			}
			
			
			if ($i_match_crd == 0) {
			   $dataOut["html"] .= "<span class='notMatchNumber'>" .  $scard4 . "</span>";
			   if ($i_crd_pos < 4) {
				 $dataOut["html"] .= " - ";
				}  
				$i_crd_pos++;
			 }
			
			// Fifth Card
			
			
		  foreach ($single_result["match_cards"] as $single_card) {
		  
			  if (strtolower($scard5) == strtolower($single_card)) {
				 $dataOut["html"] .= "<span class='matchNumber'>" . $scard5 . "</span>";
				 if ($i_crd_pos < 4) {
				   $dataOut["html"] .=  " - ";
				 }  
				 $i_crd_pos++;
				 $i_match_crd = 1;
				 $imatch_cnt++;
			   } 
			}
			
			
			if ($i_match_crd == 0) {
			   $dataOut["html"] .= "<span class='notMatchNumber'>" .  $scard5 . "</span>";
			   if ($i_crd_pos < 4) {
				 $dataOut["html"] .= " - ";
				}  
				$i_crd_pos++;
			 }
			
		  
		  
		  $dataOut[$irow_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onpoker];
		  $dataOut[$irow_cnt]["game"] = $this->lbl_onpoker;
		  if ($result["instant_win"] != "") {
		  $dataOut[$irow_cnt] = array();
		  $dataOut[$irow_cnt]["instant_win"] = $result["instant_win"];
		  $dataOut[$irow_cnt]["instant_win_amount"] = $result["instant_win_prze_amt"];
		  // instant wins
		  
				  
		  if ($result["instant_win"] == "rf") {
			$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];
			
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Royal Flush <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
	
		  } elseif ($result["instant_win"] == "sf") {
			$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Straight Flush <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
		  } elseif ($result["instant_win"] == "4k") {
			$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: 4 of a Kind <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>"; 
		  } elseif ($result["instant_win"] == "fh") {
			$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Full House <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
			
		  } elseif ($result["instant_win"] == "f") {
			$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Flush <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
		  
		  } elseif ($result["instant_win"] == "s") {
			$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Straight <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
		  } elseif ($result["instant_win"] == "3k") {
			$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: 3 of a Kind <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";  
		  } elseif ($result["instant_win"] == "2p") {
			$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: 2 pair <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
		  
		  } elseif ($result["instant_win"] == "pj") {
			$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Pair of Jacks <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
		  }
		  
		  }
		  
	
			
			 if ($single_result["match_cnt"] == 5) {
				$dataOut[$irow_cnt]["win_prze_amount"]  = $single_result["win_prze_amount"];
				
			 } elseif ($single_result["match_cnt"] == 4) {
				$dataOut[$irow_cnt]["win_prze_amount"]  = $single_result["win_prze_amount"];
			 } elseif ($single_result["match_cnt"] == 3) {
				$dataOut[$irow_cnt]["win_prze_amount"]  = $single_result["win_prze_amount"];
			 } elseif ($single_result["match_cnt"] == 2){
				$dataOut[$irow_cnt]["win_prze_amount"]  = $single_result["win_prze_amount"];
			 }
			 
			 $dataOut[$irow_cnt]["html"] .= "\n<br />Match " . $single_result["match_cnt"] . " of 5 ";
			 $dataOut[$irow_cnt]["html"] .= "\n<br />Win : <span class='win_amt'>$" . money_format('%(#12n',$dataOut[$irow_cnt]["win_prze_amount"]) . "</span>";
			 
			 $irow_cnt++;
		  }
		  
		  return $dataOut;
	  
	  
	  }
	  
	  function ValidateOnLottario($sdrawDate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $seb_num1 = null, $seb_num2 = null, $seb_num3 = null, $seb_num4 = null) {
		  
		  $sdrawDate = date('Y-m-d', $sdrawDate);
		  if ($seb_num1 != null) {
			 $result = $this->objOLG->OLGLottarioValidateDraw($sdrawDate, $sdrawDate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $seb_num1, $seb_num2, $seb_num3, $seb_num4); 
		  
		  } else {
		  
			$result = $this->objOLG->OLGLottarioValidateDraw($sdrawDate, $sdrawDate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6); 
		  }
	
		$dataOut = array();
		 
		 
		 
		 $irec_cnt = 0;
		 foreach ($result as $single_result) {
			 $b_win_num_match = false;
			 $b_bonus_num_match = false;
			 $b_match_cnt = 0;
			 $dataOut[$irec_cnt] = array();
			 $dataOut[$irec_cnt]["html"] .= "\n<br />Lottario Draw Date: " . $single_result["drawdate"];
			 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum1) {
					$b_win_num_match = true;
					break;
				} elseif ($snum1 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 
			 // match Lottario Numbers
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum1 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum1 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum1 . "</span>";
			 }
		
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum2) {
					$b_win_num_match = true;
					break;
				} elseif ($snum2 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum2 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum2 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum2 . "</span>";
			 }
				 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum3) {
					$b_win_num_match = true;
					break;
				} elseif ($snum3 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum3 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum3 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum3 . "</span>";
			 }
			 
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum4) {
					$b_win_num_match = true;
					break;
				} elseif ($snum4 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum4 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum4 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum4 . "</span>";
			 }
			$b_win_num_match = false; 
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum5) {
					$b_win_num_match = true;
					break;
				} elseif ($snum5 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum5 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum5 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum5 . "</span>";
			 }
			 $b_win_num_match = false;
			 foreach ($single_result["match_numbers"] as $m_num) {
			 
				if ($m_num == $snum6) {
					$b_win_num_match = true;
					break;
				} elseif ($snum6 == $single_result["match_bonus_num"]) {
					$b_bonus_num_match = true;
					break;
				}
			 
			 }
			 if ($b_win_num_match) {  // match
				$b_match_cnt++;
				$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum6 . "</span>";
			 } elseif ($b_bonus_num_match) { // bonus match
				$dataOut[$irec_cnt]["html"] .= "<span class='matchBonusNumber'>" . $snum6 . "</span>";
			 } else { // not match
				$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum6 . "</span>";
			 }
			 
			 
			 // Match Early Bird Numbers
				$b_win_num_match = false;
				  $ieb_match_cnt = 0;
				  foreach ($single_result["match_eb_numbers"] as $snum) {
					if ($snum == $seb_num1) {
					  $b_win_num_match = true;
					  $ieb_match_cnt++;
					  break;
					} 
				  }
				  if ($b_win_num_match) {
					$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $seb_num1 . "</span>";
				  } else {
					$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $seb_num1 . "</span>";
				  }
		
				  $b_win_num_match = false;
		
				  foreach ($single_result["match_eb_numbers"] as $snum) {
					if ($snum == $seb_num2) {
					  $b_win_num_match = true;
					  $ieb_match_cnt++;
					  break;
					} 
				  }
				  if ($b_win_num_match) {
					$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $seb_num2 . "</span>";
				  } else {
					$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $seb_num2 . "</span>";
				  }
				  
				 $b_win_num_match = false;
		
				  foreach ($single_result["match_eb_numbers"] as $snum) {
					if ($snum == $seb_num3) {
					  $b_win_num_match = true;
					  $ieb_match_cnt++;
					  break;
					} 
				  }
				  if ($b_win_num_match) {
					$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $seb_num3 . "</span>";
				  } else {
					$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $seb_num3 . "</span>";
				  }
		
				  $b_win_num_match = false;
		
				  foreach ($single_result["match_eb_numbers"] as $snum) {
					if ($snum == $seb_num4) {
					  $b_win_num_match = true;
					  $ieb_match_cnt++;
					  break;
					} 
				  }
				  if ($b_win_num_match) {
					$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $seb_num4 . "</span>";
				  } else {
					$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $seb_num4 . "</span>";
				  }
				  
				  if ($ieb_match_cnt == 4) {
					 $dataOut[$irec_cnt]["win_prze_ebird_amt"] = $single_result["win_prze_ebird_amount"];
				  }
				 
				  
			 
			 
			 $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onlottario];
			 $dataOut[$irec_cnt]["game"] = $this->lbl_onlottario;
			 
			 if ($b_match_cnt == 6) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 5 && $b_bonus_num_match) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 5) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 4) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 } elseif ($b_match_cnt == 3) {
				$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 
			 } else {
				// no prize
			 }
			 
			 
				   
			 
			 
			 if ($dataOut[$irec_cnt]["prze_amt"] > 0) {
				$dataOut[$irec_cnt]["html"] .= "Won - <span class='win_amt'>$" . money_format('%(#12n',$dataOut[$irec_cnt]["prze_amt"]) . "</span>";
			 } 
			 if ($dataOut[$irec_cnt]["win_prze_ebird_amt"] > 0) {
				 $dataOut[$irec_cnt]["html"] .= "Won Early Bird - <span class='win_amt'>$" . money_format('%(#12n',$dataOut[$irec_cnt]["prze_amt"]["win_prze_ebird_amt"]) . "</span>";
			 }
			 
			 
			 
			 
			 
			 $irec_cnt++;
			 // end of foreach loop
		 
		 }
		 
	
		 return $dataOut;
	
			 
	  }
	  
	
	  
	  function ValidateOnEncore($sdrawDate, $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7) {
				
		$sdrawDate = date('Y-m-d', $sdrawDate);
		$result = $this->objOLG->OLGEncoreValidateDraw($sdrawDate, $sdrawDate, $snum1 , $snum2 , $snum3 , $snum4 , $snum5  , $snum6, $snum7 );
		
		$irec_cnt = 0;
		foreach ($result as $single_result) {
		
		
		 $dataOut[$irec_cnt]["html"] .= "\n<br />Encore Draw Date: " . $single_result["drawdate"];
		
		  $b_win_num_match = false;
		  if ($single_result["match_numbers"][0] == $snum1) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='matchNumber'>" . $snum1 . "</span>";
		  } elseif ($single_result["num_match_ar"][0] == $snum1) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='noWinButMatch'>" . $snum1 . "</span>";
		  } else {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='notMatchNumber'>" . $snum1 . "</span>";
		  }
		 
		  if ($single_result["match_numbers"][1] == $snum2) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='matchNumber'>" . $snum2 . "</span>";
		  } elseif ($single_result["num_match_ar"][1] == $snum2) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='noWinButMatch'>" . $snum2 . "</span>";
		  } else {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='notMatchNumber'>" . $snum2 . "</span>";
		  }
		 
		   if ($single_result["match_numbers"][2] == $snum3) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='matchNumber'>" . $snum3 . "</span>";
		  } elseif ($single_result["num_match_ar"][2] == $snum3) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='noWinButMatch'>" . $snum3 . "</span>";
		  } else {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='notMatchNumber'>" . $snum3 . "</span>";
		  }
		 
		  if ($single_result["match_numbers"][3] == $snum4) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='matchNumber'>" . $snum4 . "</span>";
		  } elseif ($single_result["num_match_ar"][3] == $snum4) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='noWinButMatch'>" . $snum4 . "</span>";
		  } else {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='notMatchNumber'>" . $snum4 . "</span>";
		  }
		 
		  if ($single_result["match_numbers"][4] == $snum5) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='matchNumber'>" . $snum5 . "</span>";
		  } elseif ($single_result["num_match_ar"][4] == $snum5) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='noWinButMatch'>" . $snum5 . "</span>";
		  } else {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='notMatchNumber'>" . $snum5 . "</span>";
		  }
		 
		  if ($single_result["match_numbers"][5] == $snum6) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='matchNumber'>" . $snum6 . "</span>";
		  } elseif ($single_result["num_match_ar"][5] == $snum6) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='noWinButMatch'>" . $snum6 . "</span>";
		  } else {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='notMatchNumber'>" . $snum6 . "</span>";
		  }
		  if ($single_result["match_numbers"][6] == $snum7) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='matchNumber'>" . $snum7 . "</span>";
		  } elseif ($single_result["num_match_ar"][6] == $snum7) {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='noWinButMatch'>" . $snum7 . "</span>";
		  } else {
			  $dataOut[$irec_cnt]["html"] .=  "<span class='notMatchNumber'>" . $snum7 . "</span>";
		  }
		 
	   
	  
		  if ($single_result["win_prze_amount"] > 0) {
			$dataOut[$irec_cnt]["html"] .=  " - <span class='win_amt'>$" . money_format('%(#12n',$single_result["win_prze_amount"]) . "</span><br />";
			$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
		  }
	   
		  $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onencore];
		  $dataOut[$irec_cnt]["game"] = $this->lbl_onencore;
		
		
		
		$irec_cnt++;
		
		}
		return $dataOut;
		
	  }
	  
	  function ValidateOnPick3($sdrawDate, $snum1, $snum2, $snum3) {
		 
		 
		 $sdrawDate = date('Y-m-d', $sdrawDate);
		 $play_type_any = 2;
		 $result = $this->objOLG->OLGPick3ValidateDraw($sdrawDate, $sdrawDate,$play_type_any, $snum1, $snum2, $snum3);
	  
	  $irec_cnt = 0;
		foreach ($result as $single_result) {
		
		

	    
    $dataOut[$irec_cnt]["html"] .= "\n<br />Pick 3 - " . date('Y-m-d',strtotime( $single_result["drawdate"]));
    
      $b_win_num_match = false;
      foreach ( $single_result["match_numbers"] as $snum) {
        if ($snum == $snum1) {
          $b_win_num_match = true;
          break;
        } 
        
      }
      if ($b_win_num_match) {
        $dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum1 . "</span>";
      } else {
        $dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum1 . "</span>";
      }
      
      $b_win_num_match = false;
      foreach ($single_result["match_numbers"] as $snum) {
        if ($snum == $snum2) {
          $b_win_num_match = true;
          break;
        } 
        
      }
      if ($b_win_num_match) {
        $dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum2 . "</span>";
      } else {
        $dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum2 . "</span>";
      }
      
      $b_win_num_match = false;
      foreach ($single_result["match_numbers"] as $snum) {
        if ($snum == $snum3) {
          $b_win_num_match = true;
          break;
        } 
        
      }
      if ($b_win_num_match) {
        $dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum3 . "</span>";
      } else {
        $dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum3 . "</span>";
      }
      
       if ($single_result["win_prze_straight_amount"] > 0) {
        $dataOut[$irec_cnt]["html"] .= "Straight Win - <span class='win_amt'>$" . money_format('%(#12n',$s_single_match["win_prze_straight_amount"]) . "</span><br />";
      }

      if ($single_result["win_prze_box_amount"] > 0) {
        $dataOut[$irec_cnt]["html"] .= "Box Win - <span class='win_amt'>$" . money_format('%(#12n',$s_single_match["win_prze_box_amount"]) . "</span><br />";
      }
      
      
	   
	  $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onpick3];
	  $dataOut[$irec_cnt]["game"] = $this->lbl_onpick3;

     
    
    $irec_cnt++;
    }

	  return $dataOut;
	  
	  }
	  
	  
	  
	  function ValidateOnPick4($sdrawDate, $snum1, $snum2, $snum3, $snum4) {
		 
		 
		 $sdrawDate = date('Y-m-d', $sdrawDate);
		 $play_type_any = 2;
		 
		 $result = $this->objOLG->OLGPick4ValidateDraw($sdrawDate, $sdrawDate,$play_type_any, $snum1, $snum2, $snum3, $snum4);
	
		  $irec_cnt = 0;
		foreach ($result as $single_result) {
	
			$dataOut[$irec_cnt]["html"] .= "Ontario Pick 4 - " . date('Y-m-d',strtotime($single_result["drawdate"]));
	  
		  $b_win_num_match = false;
		 if (is_array($single_result["match_numbers"])) {
			foreach ($single_result["match_numbers"] as $snum) {
			  if ($snum == $snum1) {
				$b_win_num_match = true;
				//$dataOut[$irec_cnt]["html"] .= "SNUM: " . $snum . " > " . $lotto_single_game["played_nums"][0];
				break;
			  } 
			  
			}
		  }
		  if ($b_win_num_match) {
			$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum1 . "</span>";
		  } else {
			$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum1 . "</span>";
		  }
		  
		  $b_win_num_match = false;
		  if (is_array($single_result["match_numbers"])) {
		  
			foreach ($single_result["match_numbers"] as $snum) {
			  if ($snum == $snum2) {
				$b_win_num_match = true;
				break;
			  } 
			  
			}
		  }
		  if ($b_win_num_match) {
			$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum2 . "</span>";
		  } else {
			$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum2. "</span>";
		  }
		  
		  $b_win_num_match = false;
		  if (is_array($single_result["match_numbers"])) {
		  
			foreach ($single_result["match_numbers"] as $snum) {
			  if ($snum == $snum3) {
				$b_win_num_match = true;
				break;
			  } 
			  
			}
		  }
		  if ($b_win_num_match) {
			$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum3 . "</span>";
		  } else {
			$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum3 . "</span>";
		  }
		  
		  
		  $b_win_num_match = false;
		  if (is_array($single_result["match_numbers"])) {
		  
			foreach ($single_result["match_numbers"] as $snum) {
			  if ($snum == $snum4) {
				$b_win_num_match = true;
				break;
			  } 
			  
			}
		  }
		  if ($b_win_num_match) {
			$dataOut[$irec_cnt]["html"] .= "<span class='matchNumber'>" . $snum4 . "</span>";
		  } else {
			$dataOut[$irec_cnt]["html"] .= "<span class='notMatchNumber'>" . $snum4 . "</span>";
		  }
	
		  if ($single_result["win_prze_straight_amount"] > 0) {
			$dataOut[$irec_cnt]["html"] .= "Straight Win - <span class='win_amt'>$" . money_format('%(#12n',$single_result["win_prze_straight_amount"]) . "</span><br />";
			$dataOut[$irec_cnt]["win_prze_straight_amount"] = $single_result["win_prze_straight_amount"];
		  }
	
		  if ($single_result["win_prze_box_amount"] > 0) {
			$dataOut[$irec_cnt]["html"] .= $single_result["match_box"];
			$dataOut[$irec_cnt]["html"] .= " Box Win - <span class='win_amt'>$" . money_format('%(#12n',$single_result["win_prze_box_amount"]) . "</span><br />";
			$dataOut[$irec_cnt]["win_prze_box_amount"] = $single_result["win_prze_box_amount"];
		  }
	
	   
		  $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onpick4];
		  $dataOut[$irec_cnt]["game"] = $this->lbl_onpick4;
			$irec_cnt++;
		}
		 return $dataOut;
		
	  }
	  
  
}
  
?>
