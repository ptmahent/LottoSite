<?php

	$userid = "theepanm@yahoo.com"
	
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
	require_once($incdir . "/incCombOLGLottery.php");


   $cmdargs = arguments();
   
    //$TSWLottoValidator = new TSWLottoValidate();
 
 
  if (count($cmdargs,1) > 2) {
  	if (preg_match("/^continue/i", $cmdargs["standard"][1], $lmatches)) {
  	

	} elseif (preg_match("/^startnew/i", $cmdargs["standard"][1], $lmatches)) {
		//$TSWLottoValidator->First_Stp_ValidateGames();
	} elseif (preg_match("/^deletehistory/i", $cmdargs["standard"][1], $lmatches)) {
  	
	} elseif (preg_match("/^update_user_lotto_lines/i", $cmdargs["standard"][1], $lmatches)) {
	
	}
  	

  } else {
	  do {
		fwrite(STDOUT, "\tEnter one of the options Below: \n\n\n");
		fwrite(STDOUT, "\tupdate_user_lotto_lines \t Update User Lotto Lines \n");          // 

		fwrite(STDOUT, "\n\t\n\t: ");   
		do {
		  $selection = trim(fgets(STDIN));
		} while (trim($selection) == '');
		
		
    } while (trim($selection) != 'q');
  }



class TSWUserLottoLines {
	
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
	  var $objOLGComb;
	  var $objUser;
	  
	  var $initialdir;
	  var $destdir;
	  var $incdir;
	  
	  var $default_user_email_id;
	  var $default_user_id;
	
	function __construct() {
	
	
	
	
	
	 

	  

	  
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
	  $this->objOLGComb = new CombOLGLottery();
	  $this->objUser 	= new User();
	
	
	  $this->initialdir 	       = "./v2";
      $this->destdir    		   = "./v2/dest";
      $this->default_user_email_id = "theepanm@yahoo.com";
      $this->default_user_id	   = $this->objUser->UserGetNo($this->default_user_email_id );
	
	} // end of __construct
	
	
	function UpdateLottoLines() {
	
		$fl_names = scandir($this->initialdir);
		$dataOut = null;
		foreach ($fl_names as $fl_name) {
		     print_r($fl_name);
			 if (preg_match("/\.dat\.php/i",$fl_name,$fl_matches)) {
			 	 $file_cont = file_get_contents($this->initialdir . "/" . $fl_name);
			 	 
			 	 
			 	 if (preg_match("/_(\d*)\.dat\.php/i", $fl_name, $fl_name_matches)) {
			 	 	$envelope_no = $fl_name_matches[1];
			 	 }
				 $file_lines = split("\n", $file_cont);
			 
			 	 foreach ($file_lines as $sl_line) {
			 		if (preg_match("/^(" . $this->reg_desc_namax . ")/i", $sl_line, $sl_line_matches)) {
						 
						 	 if (preg_match("/(" . $this->reg_desc_namax . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 
								  
								  $tkt_data = array();
								  $tkt_data["game"] = $this->lbl_namax;
								  $tkt_data["date"] = strtotime($sl_ln_matches[9]);
								  $tkt_data["locnum"] = $sl_ln_matches[10];
								  $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
								  if (!$tkt_data["store_id"]) {
								  	$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
								  }
								  
								  
								  $tkt_data["uniqnum"] = $sl_ln_matches[11];
								  $tkt_data["envelope_no"] = $envelope_no;
								  $tkt_data["line_cnt"] = 1;
								  $tkt_data["encore_cnt"] = 0;
								  
								  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
								  if (!$tkt_data["ticket_id"]) {
									  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
   null, null);
								  }							  
								  $cur_gm_data = array();
								  $cur_gm_data["game"] = $this->lbl_namax;
						 
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
									$sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
									$sl_ln_matches[6],$sl_ln_matches[7],$sl_ln_matches[8]);
								
								 
								 
							} elseif (preg_match("/(" . $this->reg_desc_namax . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  
								  $cur_gm_data = array();
								  $cur_gm_data["game"] 		= $this->lbl_namax;
								  $tkt_data["line_cnt"]++;
								  $cur_gm_data["numbers"] 	= array($sl_ln_matches[2],
									$sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
									$sl_ln_matches[6],$sl_ln_matches[7],$sl_ln_matches[8]);
								  
							}
							$dataOut = $this->ValidateGames($this->lbl_namax, $cur_gm_data, $lst_gm_data, $tkt_gm_data);
							
					} elseif (preg_match("/^(" . $this->reg_desc_na649 . ")/i", $sl_line, $sl_line_matches)) {
			 				if (preg_match("/(" . $this->reg_desc_na649 . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 
								 
								  $tkt_data = array();
								  
								  $txt_data["game"] = $this->lbl_na649;
								  $tkt_data["date"] = strtotime($sl_ln_matches[8]);
								  $tkt_data["locnum"] = $sl_ln_matches[9];
								  $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
								  if (!$tkt_data["store_id"]) {
								  	$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
								  }
								  
								  $tkt_data["uniqnum"] = $sl_ln_matches[10];
								  $tkt_data["envelope_no"] = $envelope_no;
								  $tkt_data["line_cnt"] = 1;
								  $tkt_data["encore_cnt"] = 0;
								  
								  
							 	  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
								  if (!$tkt_data["ticket_id"]) {
									  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
   null, null);
								  }		
								   
								  $cur_gm_data = array();
								  $cur_gm_data["game"] = $this->lbl_na649;  	 	 	 	 	
								 
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
									$sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
									$sl_ln_matches[6],$sl_ln_matches[7]);
								
								  
								 
							} elseif (preg_match("/(" . $this->reg_desc_na649 . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  
								   $cur_gm_data = array(); 
								   $tkt_data["line_cnt"]++;
								   $cur_gm_data["game"] = $this->lbl_na649; 
								   $cur_gm_data["numbers"] = array($sl_ln_matches[2],
									$sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
									$sl_ln_matches[6],$sl_ln_matches[7]);
							}
							
							$dataOut = $this->ValidateGames($this->lbl_na649, $cur_gm_data, $lst_gm_data, $tkt_gm_data);
							
			 		} elseif (preg_match("/^(" . $this->reg_desc_on49 . ")/i", $sl_line, $sl_line_matches)) {
			 				if (preg_match("/(" . $this->reg_desc_on49 . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {

								  $tkt_data = array();
								  $tkt_data["game"] = $this->lbl_on49;
								  $tkt_data["date"] = strtotime($sl_ln_matches[8]);
								  $tkt_data["locnum"] = $sl_ln_matches[9];
								  $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
								  if (!$tkt_data["store_id"]) {
								  	$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
								  }
								  
								  
								  $tkt_data["uniqnum"] = $sl_ln_matches[10];
							 	  $tkt_data["envelope_no"] = $envelope_no;
							      $tkt_data["line_cnt"] = 1;
								  $tkt_data["encore_cnt"] = 0;
	  
								  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
								  if (!$tkt_data["ticket_id"]) {
									  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
   null, null);
								  }			
								  
								  $cur_gm_data = array();
								  $cur_gm_data["game"] = $this->lbl_on49;
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								    $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								    $sl_ln_matches[6],$sl_ln_matches[7]);
								
								 



							} elseif (preg_match("/(" . $this->reg_desc_on49 . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  
								  $cur_gm_data = array();
	     						  $tkt_data["line_cnt"]++;
								  $cur_gm_data["game"] = $this->lbl_on49;
									  
								   $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								     $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								     $sl_ln_matches[6],$sl_ln_matches[7]);
								  
							}
							$dataOut = $this->ValidateGames($this->lbl_on49, $cur_gm_data, $lst_gm_data, $tkt_gm_data);
							
			 		} elseif (preg_match("/^(" . $this->reg_desc_onlottario . ")/i", $sl_line, $sl_line_matches)) {
			 				if (preg_match("/(" . $this->reg_desc_onlottario . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								
								  $tkt_data = array();
								  $tkt_data["game"] = $this->lbl_onlottario;
								  $tkt_data["date"] = strtotime($sl_ln_matches[8]);
								  $tkt_data["locnum"] = $sl_ln_matches[9];
	  							  $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
								  if (!$tkt_data["store_id"]) {
								  	$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
								  }
								  
								  
								  $tkt_data["uniqnum"] = $sl_ln_matches[10];
							      $tkt_data["envelope_no"] = $envelope_no;
							      $tkt_data["line_cnt"] = 1;
								  $tkt_data["encore_cnt"] = 0;							      
	  
								  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
								  if (!$tkt_data["ticket_id"]) {
									  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
   null, null);
								  }		
								  $cur_gm_data = array();
								  $cur_gm_data["game"] = $this->lbl_onlottario;	 	 	
								 
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								  $sl_ln_matches[6],$sl_ln_matches[7]);
								
						

							} elseif (preg_match("/(" . $this->reg_desc_onlottario . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  
								  $cur_gm_data = array();
								  $cur_gm_data["game"] = $this->lbl_onlottario;	 
								  $cur_gm_data["line_cnt"]++;
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								  $sl_ln_matches[6],$sl_ln_matches[7]);
								  
							}
							
							$dataOut = $this->ValidateGames($this->lbl_onlottario, $cur_gm_data, $lst_gm_data, $tkt_gm_data);
							
			 		 } elseif (preg_match("/^(" . $this->reg_desc_onearlybird . ")/i", $sl_line, $sl_line_matches)) {
			 		 		if (preg_match("/(" . $this->reg_desc_onearlybird . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								  
								  $tkt_data = array();
								  $tkt_data["game"] = $this->lbl_onearlybird;
								  $tkt_data["date"] = strtotime($sl_ln_matches[5]);
								  $tkt_data["locnum"] = $sl_ln_matches[6];
								  $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
								  if (!$tkt_data["store_id"]) {
								  	$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
								  }
								  
								  
								  $tkt_data["uniqnum"] = $sl_ln_matches[7];
							      $tkt_data["envelope_no"] = $envelope_no;
							      $tkt_data["line_cnt"] = 1;
								  $tkt_data["encore_cnt"] = 0;							      
							      
	  							  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
								  if (!$tkt_data["ticket_id"]) {
									  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
   null, null);
								  }		

								  $cur_gm_data = array();
								  $cur_gm_data["game"] = $this->lbl_onlottario;
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5]);

								 
							} elseif (preg_match("/(" . $this->reg_desc_onearlybird . ")\|" .
								 "(\d{1,2})-(\d{1,2})-(\d{1,2})-(\d{1,2})/i",
								  $sl_line, $sl_ln_matches)) {
								  
								  $cur_gm_data = array();
								  $cur_gm_data["game"] = $this->lbl_onearlybird;
								  $tkt_data["line_cnt"]++;
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5]);
							}
							
							$dataOut = $this->ValidateGames($this->lbl_onearlybird, $cur_gm_data, $lst_gm_data, $tkt_gm_data);
							
			 		 } elseif (preg_match("/^(" . $this->reg_desc_onkeno . ")/i", $sl_line, $sl_line_matches)) {
							if (preg_match("/(" . $this->reg_desc_onkeno . ")\|" .
								 "(\d{1,2})(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}(-(\d{1,2})){0,1}\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 
							  $tkt_keno = array();
							  $tkt_data["game"] = $this->lbl_onkeno;
								
							  $tkt_data["date"] = strtotime($sl_ln_matches[21]);
							  $tkt_data["locnum"] = $sl_ln_matches[22];
							   $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
							  if (!$tkt_data["store_id"]) {
								$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
							  }
							  
							  
							  $tkt_data["uniqnum"] = $sl_ln_matches[23];
							  
							  $tkt_data["envelope_no"] = $envelope_no;
							  $tkt_data["line_cnt"] = 1;
							  $tkt_data["encore_cnt"] = 0;								  
							  
							  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
							  if (!$tkt_data["ticket_id"]) {
								  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
null, null);
							  }			

							  $cur_gm_data = array();
							  $cur_gm_data["game"] = $this->lbl_onkeno;
								
							  //$file_totalTktCnt++;
								 
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
							
							 
							 $cur_gm_data = array();
							 $cur_gm_data["category"] = 0;
							 $cur_gm_data["game"] = $this->lbl_onkeno;
							 
							 $tkt_data["line_cnt"]++;
							 
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
					 } elseif (preg_match("/^(" . $this->reg_desc_onencore . ")/i", $sl_line, $sl_line_matches)) {
					 	
					 		if (preg_match("/(" . $this->reg_desc_onencore . ")\|" .
								 "(\d)(\d)(\d)(\d)(\d)(\d)(\d)\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 
								  $tkt_data = array();
								  $tkt_data["game"] = $this->lbl_onencore;
								  $tkt_data["date"] = strtotime($sl_ln_matches[9]);
							  	  $tkt_data["locnum"] = $sl_ln_matches[10];
							  	  
							  	  $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
								  if (!$tkt_data["store_id"]) {
								  	$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
								  }
								  
							  	  $tkt_data["uniqnum"] = $sl_ln_matches[11];
							  	  $tkt_data["line_cnt"] = 1;
								  $tkt_data["encore_cnt"] = 1;
							  
							  	    
								  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
								  if (!$tkt_data["ticket_id"]) {
									  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
   null, null);
								  }			
							  
							  	  $cur_gm_data = array();
							  	  $cur_gm_data["game"] = $this->lbl_onencore;
								  
									  
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								  $sl_ln_matches[6],$sl_ln_matches[7],$sl_ln_matches[8]);
								
								 
								 
							} elseif (preg_match("/(" . $this->reg_desc_onencore . ")\|" .
								 "(\d)(\d)(\d)(\d)(\d)(\d)(\d)\|" .
								 "([^|]+)/i",
								  $sl_line, $sl_ln_matches)) {
								  
								  $cur_gm_data = array();
								  $tkt_data["encore_cnt"]++;
								  $cur_gm_data["game"] = $this->lbl_onencore;
	   							 /* $cur_gm_data["game"] = $this->lbl_onencore;
								  $cur_gm_data["date"] = strtotime($sl_ln_matches[9]);  
								  
								  */
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2],
								        $sl_ln_matches[3],$sl_ln_matches[4],$sl_ln_matches[5],
								        $sl_ln_matches[6],$sl_ln_matches[7],$sl_ln_matches[8]);
							
							}
					 
					 }  elseif (preg_match("/^(" . $this->reg_desc_onpick4 . ")/i", $sl_line, $sl_line_matches)) {
						 	if (preg_match("/(" . $this->reg_desc_onpick4 . ")\|" .
								 "(\d)(\d)(\d)(\d)\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 
								  $tkt_data = array();
								  $tkt_data["date"] = strtotime($sl_ln_matches[6]);
							  	  $tkt_data["locnum"] = $sl_ln_matches[7];
							  	  $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
								  if (!$tkt_data["store_id"]) {
								  	$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
								  }
							  	  
							  	  
							  	  $tkt_data["uniqnum"] = $sl_ln_matches[8];
							  	  $tkt_data["envelope_no"] = $envelope_no;

								  $tkt_data["line_cnt"] = 1;
							  	  $tkt_data["encore_cnt"] = 0;
							  	  
	  							  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
								  if (!$tkt_data["ticket_id"]) {
									  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
   null, null);
								  }	
							  	  $cur_gm_data = array();
							  	  $cur_gm_data["game"] = $this->lbl_onpick4;
							  	  
							  	 /* $cur_gm_data["date"] = strtotime($sl_ln_matches[8]);
							  	  $cur_gm_data["locnum"] = $sl_ln_matches[7];
							  	  $cur_gm_data["uniqnum"] = $sl_ln_matches[8]; */
								  
								 $cur_gm_data["numbers"] = array($sl_ln_matches[2], 
								 $sl_ln_matches[3], $sl_ln_matches[4],
								 $sl_ln_matches[5]);
								 
								 
							 } elseif (preg_match("/(" . $this->reg_desc_onpick4 . ")\|" .
								 "(\d)(\d)(\d)(\d)/i",
								  $sl_line, $sl_ln_matches)) {
								  
								 $cur_gm_data = array();
								 $tkt_data["line_cnt"]++;
								 $cur_gm_data["game"] = $this->lbl_onpick4;
								 $cur_gm_data["numbers"] = array($sl_ln_matches[2], 
								 	$sl_ln_matches[3], $sl_ln_matches[4],
								 	$sl_ln_matches[5]);	  
							}
					 		$dataOut = $this->ValidateGames($this->lbl_onpick4, $cur_gm_data, $lst_gm_data, $tkt_gm_data);
							
					 } elseif (preg_match("/^(" . $this->reg_desc_onpick3 . ")/i", $sl_line, $sl_line_matches)) {
					 	if (preg_match("/(" . $this->reg_desc_onpick3 . ")\|" .
								 "(\d)(\d)(\d)\|" .
								 "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {

								  $tkt_data = array();
			  					  $tkt_data["date"] = strtotime($sl_ln_matches[5]);
							  	  $tkt_data["locnum"] = $sl_ln_matches[6];
							  	  $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
								  if (!$tkt_data["store_id"]) {
								  	$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
								  }
							  	  
							  	  
							  	  $tkt_data["uniqnum"] = $sl_ln_matches[7];
							  	  $tkt_data["envelope_no"] = $envelope_no;
							  	  
							  	  $tkt_data["line_cnt"] = 1;
							  	  $tkt_data["encore_cnt"] = 0;

								    $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
								  if (!$tkt_data["ticket_id"]) {
									  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
   null, null);
								  }		
								   
								  
							  	  $cur_gm_data = array();
							  	 // $cur_gm_data["date"] = strtotime($sl_ln_matches[5]);
							  	  //$cur_gm_data["locnum"] = $sl_ln_matches[6];
							  	  //$cur_gm_data["uniqnum"] = $sl_ln_matches[7];								 
								 
								 $cur_gm_data["game"] = $this->lbl_onpick3;
								  $cur_gm_data["numbers"] = array($sl_ln_matches[2], 
								     $sl_ln_matches[3], $sl_ln_matches[4]);
								 
								
						} elseif (preg_match("/(" . $this->reg_desc_onpick3 . ")\|" .
								 "(\d)(\d)(\d)/i",
								  $sl_line, $sl_ln_matches)) {
								  	
								  $tkt_data["line_cnt"]++;
								  
							  	  $cur_gm_data = array();
							  	  $cur_gm_data["game"] = $this->lbl_onpick3;
								$cur_gm_data["numbers"] = array($sl_ln_matches[2],
								  $sl_ln_matches[3], $sl_ln_matches[4]);
					    }
					    
					    $dataOut = $this->ValidateGames($this->lbl_onpick3, $cur_gm_data, $lst_gm_data, $tkt_gm_data);
					 
					 } elseif (preg_match("/^(" . $this->reg_desc_onpoker . ")/i", $sl_line, $sl_line_matches)) {
					 
					 	if (preg_match("/(" . $this->reg_desc_onpoker . ")\|" .
								 "([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}\|" . "([^|]+)\|([^-]+)-(\d+)/i", $sl_line, $sl_ln_matches)) {
								 
								 $tkt_data = array();
								 
								  
								  $tkt_data["date"] = strtotime($sl_ln_matches[11]);
							  	  $tkt_data["locnum"] = $sl_ln_matches[12];
							  	  $tkt_data["store_id"] = $this->objOLGComb->StoreGetId($tkt_data["locnum"] );
								  if (!$tkt_data["store_id"]) {
								  	$tkt_data["store_id"] = $this->objOLGComb->StoreAdd(null, null, null, null, null, $tkt_data["locnum"]);
								  }
							  	  
							  	  
							  	  $tkt_data["uniqnum"] = $sl_ln_matches[13];
							  	  $tkt_data["envelope_no"] = $envelope_no;
								  $tkt_data["line_cnt"] = 1;
								  $tkt_data["encore_cnt"] = 0;
								  
								  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketGetid(  $tkt_data["date"] , $this->default_user_id, $tkt_data["store_id"], $tkt_data["uniqnum"]  );
								  if (!$tkt_data["ticket_id"]) {
									  $tkt_data["ticket_id"] = $this->objOLGComb->LottoTicketAdd( $tkt_data["date"], $this->default_user_id, $tkt_data["envelope_no"], $tkt_data["store_id"], $tkt_data["uniqnum"], null,
   null, null);
								  }		
							  	  $cur_gm_data = array();
							  	  $cur_gm_data["game"] = $this->lbl_onpoker;
							  	  
							  	//  $cur_gm_data["date"] = strtotime($sl_ln_matches[11]);
							  	//  $cur_gm_data["locnum"] = $sl_ln_matches[12];
							  	 // $cur_gm_data["uniqnum"] = $sl_ln_matches[13];
								  
								  
								 $cur_gm_data["cards"] = array($sl_ln_matches[2], $sl_ln_matches[4],
								 $sl_ln_matches[6],$sl_ln_matches[8], $sl_ln_matches[10]);
								 
								 
						} elseif (preg_match("/(" . $this->reg_desc_onpoker . ")\|" .
								 "([0-9JQKAjqka]{1,2}[CSDHcsdh])(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}(-([0-9JQKAjqka]{1,2}[CSDHcsdh])){0,1}/i", $sl_line, $sl_ln_matches)) {

							
							 
							   $tkt_data["line_cnt"]++;
							    $cur_gm_data = array();
								$cur_gm_data["game"] = $this->lbl_onpoker;
								$cur_gm_data["cards"] = array($sl_ln_matches[2], $sl_ln_matches[4],
								 $sl_ln_matches[6],$sl_ln_matches[8], $sl_ln_matches[10]);
						}
						$dataOut = $this->ValidateGames($this->lbl_onpoker, $cur_gm_data, $lst_gm_data, $tkt_gm_data);
					 }
			 	 }
			 }
		} // end of foreach loop
	
	
	
	} // end of function 
	
	function ValidateGames($theGame, $cur_gm_data, $lst_gm_data, $tkt_gm_data) {
	
		
		 if ($cur_gm_data["locnum"] != null) {
		 	$store_id = StoreAdd ("", "", "", "ON", "", $cur_gm_data["locnum"]);
		 } else {
		 	$store_id = 0;
		 }
		 
		$game_row = $this->objLottery->dbLotteryGamesGet($theGame);
		$game_id = $game_row["gameid"];
		
		$user_id = $this->objUser->UserGetNo($this->default_user_email_id);
	
		if ($theGame == $this->lbl_namax) {
		
		
		
			$comb_select_id =  $this->objOLGComb->NACombMaxGetId($cur_gm_data["numbers"][0],
				 	 	 	 	 	   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5],
									   $cur_gm_data["numbers"][6]);
			if (!$comb_select_id) {
				   $comb_select_id = $this->objOLGComb->NACombMaxAdd($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5],
									   $cur_gm_data["numbers"][6]);		
			}
			
			$dataOut = $this->naLottery->ValidateNaMax($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5],
									   $cur_gm_data["numbers"][6]);
			
			
			
			$total_amt_won = 0;
			$total_free_ticket_cnt = 0;
			$total_win_cnt = 0;
			$total_line_cost = 0;
			
			$iSeqNo = 0;
			foreach ($dataOut as $singleData) {					   
				$amt_won = 0;
				$free_ticket_cnt = 0;
				$match_str = "";
				
				if ($singleData["prze_amt"] > 0) {
					$total_amt_won += $singleData["prze_amt"];
					$total_win_cnt++;
					
				}
				if ($singleData["FreeTicket"] == 1) {
					$total_free_ticket_cnt++;
					$total_win_cnt++;
				} 
				if ($singleData["ln_cost"] > 0) {
					
					$total_line_cost += $singleData["ln_cost"];
				}
				if ($singleData["bonus_match"] == 1) {
					$match_str = $singleData["match_cnt"] . "B";
					
				} else {
					$match_str = $singleData["match_cnt"];
				}
				
				$lotto_line_id = $this->objOLGComb->LottoLineGetId( $tkt_data["ticket_id"], $comb_select_id, $iSeqNo);
				if (!$lotto_line_id) {
		 	 	   $lotto_line_id = $this->objOLGComb->LottoLineAdd(  $tkt_data["ticket_id"],
					   $comb_select_id,  $singleData["isequencenum"], $cur_gm_data["game"],  $singleData["prze_amt"],
					  $singleData["match_cnt"],  $match_str,  $singleData["FreeTicket"], $singleData["ln_cost"]);
				}			
				
				/*
				$lotto_line_id = $this->objOLGComb->LottoLineAdd( $user_id, $comb_select_id, $iSeqNo,
				  $cur_gm_data["date"], $game_id, $amt_won, $singleData["match_cnt"], "", $free_ticket_cnt, $ln_cost, $envelope_no, $store_id);

*/
				$iSeqNo++;
			}
			
			$this_ticket = $this->objOLGComb->LottoTicketGet($tkt_data["ticket_id"] );
			
			if ($total_line_cost > 0) {
				$total_line_cost += $this_ticket["ticket_cost"];
			} else {
				$total_line_cost = null;
			}
			
			if ($total_free_ticket_cnt > 0) {
				$total_free_ticket_cnt += $this_ticket["free_ticket_cnt"];
			} else {
				$total_free_ticket_cnt = 0;
			}
			
			
			$this->objOLGComb->LottoTicketUpdate(   $tkt_data["ticket_id"],null, null, null, null, 	$total_amt_won, $total_free_ticket_cnt, $total_line_cost );
   
				
		} elseif ($theGame == $this->lbl_na649) {
		
			$comb_select_id = $this->objOLGComb->NAComb649GetId($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
			if (!$comb_select_id) {
				$comb_select_id = $this->objOLGComb->NAComb649Add($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
			
			}
			
			$dataOut = $this->naLottery->ValidateNa649($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
									   
			$total_amt_won = 0;
			$total_free_ticket_cnt = 0;
			$total_win_cnt = 0;
			$total_line_cost = 0;
			
			$iSeqNo = 0;
			foreach ($dataOut as $singleData) {					   
				$amt_won = 0;
				$free_ticket_cnt = 0;
				$match_str = "";
				
				if ($singleData["prze_amt"] > 0) {
					$total_amt_won += $singleData["prze_amt"];
					$total_win_cnt++;
					
				}
				if ($singleData["FreeTicket"] == 1) {
					$total_free_ticket_cnt++;
					$total_win_cnt++;
				} 
				if ($singleData["ln_cost"] > 0) {
					
					$total_line_cost += $singleData["ln_cost"];
				}
				if ($singleData["bonus_match"] == 1) {
					$match_str = $singleData["match_cnt"] . "B";
					
				} else {
					$match_str = $singleData["match_cnt"];
				}
				
				$lotto_line_id = $this->objOLGComb->LottoLineGetId( $tkt_data["ticket_id"], $comb_select_id, $iSeqNo);
				if (!$lotto_line_id) {
	 	 	   		$lotto_line_id = $this->objOLGComb->LottoLineAdd(  $tkt_data["ticket_id"],
					   $comb_select_id,  null, $cur_gm_data["game"],  $singleData["prze_amt"],
					  $singleData["match_cnt"],  $match_str,  $singleData["FreeTicket"], $singleData["ln_cost"]);
				}
				
				/*
				$lotto_line_id = $this->objOLGComb->LottoLineAdd( $user_id, $comb_select_id, $iSeqNo,
				  $cur_gm_data["date"], $game_id, $amt_won, $singleData["match_cnt"], "", $free_ticket_cnt, $ln_cost, $envelope_no, $store_id);

*/
				$iSeqNo++;
			}
			
			$this_ticket = $this->objOLGComb->LottoTicketGet($tkt_data["ticket_id"] );
			
			if ($total_line_cost > 0) {
				$total_line_cost += $this_ticket["ticket_cost"];
			} else {
				$total_line_cost = null;
			}
			
			if ($total_free_ticket_cnt > 0) {
				$total_free_ticket_cnt += $this_ticket["free_ticket_cnt"];
			} else {
				$total_free_ticket_cnt = 0;
			}
			
			
			$this->objOLGComb->LottoTicketUpdate(   $tkt_data["ticket_id"],null, null, null, null, 	$total_amt_won, $total_free_ticket_cnt, $total_line_cost );
   
		} elseif ($theGame == $this->lbl_on49) {
		
			
		
			$comb_select_id = $this->objOLGComb->OLGComb49GetId($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
			if (!$comb_select_id) {
				$comb_select_id = $this->objOLGComb->OLGComb49Add($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
			}
			
			$dataOut = $this->objOLG->ValidateOn49($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]
									   );
	
	
			$total_amt_won = 0;
			$total_free_ticket_cnt = 0;
			$total_win_cnt = 0;
			$total_line_cost = 0;
			
			$iSeqNo = 0;
			
			foreach ($dataOut as $singleData) {
				$amt_won = 0;
				$free_ticket_cnt = 0;
				$match_str = "";
				
				if ($singleData["prze_amt"] > 0) {
					$total_amt_won += $singleData["prze_amt"];
					$total_win_cnt++;
					
				}
				if ($singleData["FreeTicket"] == 1) {
					$total_free_ticket_cnt++;
					$total_win_cnt++;
				} 
				if ($singleData["ln_cost"] > 0) {
					
					$total_line_cost += $singleData["ln_cost"];
				}
				if ($singleData["bonus_match"] == 1) {
					$match_str = $singleData["match_cnt"] . "B";
					
				} else {
					$match_str = $singleData["match_cnt"];
				}
				
				$lotto_line_id = $this->objOLGComb->LottoLineGetId( $tkt_data["ticket_id"], $comb_select_id, $iSeqNo);
				if (!$lotto_line_id) {
				    $lotto_line_id = $this->objOLGComb->LottoLineAdd(  $tkt_data["ticket_id"],
					   $comb_select_id,  null, $cur_gm_data["game"],  $singleData["prze_amt"],
					  $singleData["match_cnt"],  $match_str,  $singleData["FreeTicket"], $singleData["ln_cost"]);
				}
				$iSeqNo++;
			
			}
			
			$this_ticket = $this->objOLGComb->LottoTicketGet($tkt_data["ticket_id"] );
			
			if ($total_line_cost > 0) {
				$total_line_cost += $this_ticket["ticket_cost"];
			} else {
				$total_line_cost = null;
			}
			
			if ($total_free_ticket_cnt > 0) {
				$total_free_ticket_cnt += $this_ticket["free_ticket_cnt"];
			} else {
				$total_free_ticket_cnt = 0;
			}
			
			
			$this->objOLGComb->LottoTicketUpdate(   $tkt_data["ticket_id"],null, null, null, null, 	$total_amt_won, $total_free_ticket_cnt, $total_line_cost );
   
			
	
		} elseif  ($theGame == $this->lbl_onencore) {
			
			$comb_select_id =  $this->objOLGComb->OLGCombEncoreGetId($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5],
									   $cur_gm_data["numbers"][6]);
			if (!$comb_select_id) {
				$comb_select_id = $this->objOLGComb->OLGCombEncoreAdd($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5],
									   $cur_gm_data["numbers"][6]);
			
			}
			
			
			
			$dataOut .= $this->ValidateOnEncore($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5],
									   $cur_gm_data["numbers"][6]);
									   
			$total_amt_won = 0;
			$total_free_ticket_cnt = 0;
			$total_win_cnt = 0;
			$total_line_cost = 0;
			
			$iSqlNo = 0;
			
			foreach ($dataOut as $singleData) {
				$amt_won = 0;
				$free_ticket_cnt = 0;
				$match_str = "";
				
				
				if ($singleData["prze_amt"] > 0) {
					$total_amt_won += $singleData["prze_amt"];
					$total_win_cnt++;
					
				}
				if ($singleData["FreeTicket"] == 1) {
					$total_free_ticket_cnt++;
					$total_win_cnt++;
				} 
				if ($singleData["ln_cost"] > 0) {
					
					$total_line_cost += $singleData["ln_cost"];
				}
				if ($singleData["bonus_match"] == 1) {
					$match_str = $singleData["match_cnt"] . "B";
					
				} else {
					$match_str = $singleData["match_cnt"];
				}
				
				$lotto_line_id = $this->objOLGComb->LottoLineGetId( $tkt_data["ticket_id"], $comb_select_id, $iSeqNo);
				if (!$lotto_line_id) {
					$lotto_line_id = $this->objOLGComb->LottoLineAdd(  $tkt_data["ticket_id"],
					   $comb_select_id,  null, $cur_gm_data["game"],  $singleData["prze_amt"],
					  $singleData["match_cnt"],  $match_str,  $singleData["FreeTicket"], $singleData["ln_cost"]);
			
				}
				$iSeqNo++;
			}
		
		
			$this_ticket = $this->objOLGComb->LottoTicketGet($tkt_data["ticket_id"] );
			
			if ($total_line_cost > 0) {
				$total_line_cost += $this_ticket["ticket_cost"];
			} else {
				$total_line_cost = null;
			}
			
			if ($total_free_ticket_cnt > 0) {
				$total_free_ticket_cnt += $this_ticket["free_ticket_cnt"];
			} else {
				$total_free_ticket_cnt = 0;
			}
			
			
			$this->objOLGComb->LottoTicketUpdate(   $tkt_data["ticket_id"],null, null, null, null, 	$total_amt_won, $total_free_ticket_cnt, $total_line_cost );
   
		
		 } elseif ($theGame == $this->lbl_onpick3) {
		 	$comb_select_id = $this->objOLGComb->OLGCombPick3GetId($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2]);
			if (!$comb_select_id) {
				$comb_select_id = $this->objOLGComb->OLGCombPick3Add($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2]);
			
			}
		 
			$dataOut .= $this->ValidateOnPick3($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2]);
									   
			$total_amt_won = 0;
			$total_free_ticket_cnt = 0;
			$total_win_cnt = 0;
			$total_line_cost = 0;
			
			$iSeqNo = 0;	   
			$total_amt_won = 0;
			$total_free_ticket_cnt = 0;
			$total_win_cnt = 0;
			$total_line_cost = 0;
			
			$iSeqNo = 0;
			
			foreach ($dataOut as $singleData) {
				$amt_won = 0;
				$free_ticket_cnt = 0;
				$match_str = "";
				
				if ($singleData["prze_amt"] > 0) {
					$total_amt_won += $singleData["prze_amt"];
					$total_win_cnt++;
					
				}
				if ($singleData["FreeTicket"] == 1) {
					$total_free_ticket_cnt++;
					$total_win_cnt++;
				} 
				if ($singleData["ln_cost"] > 0) {
					
					$total_line_cost += $singleData["ln_cost"];
				}
				if ($singleData["bonus_match"] == 1) {
					$match_str = $singleData["match_cnt"] . "B";
					
				} else {
					$match_str = $singleData["match_cnt"];
				}
				$lotto_line_id = $this->objOLGComb->LottoLineGetId( $tkt_data["ticket_id"], $comb_select_id, $iSeqNo);
				if (!$lotto_line_id) {
				    $lotto_line_id = $this->objOLGComb->LottoLineAdd(  $tkt_data["ticket_id"],
					   $comb_select_id,  null, $cur_gm_data["game"],  $singleData["prze_amt"],
					  $singleData["match_cnt"],  $match_str,  $singleData["FreeTicket"], $singleData["ln_cost"]);
				}
				$iSeqNo++;
			}
			$this_ticket = $this->objOLGComb->LottoTicketGet($tkt_data["ticket_id"] );
									   
			if ($total_line_cost > 0) {
				$total_line_cost += $this_ticket["ticket_cost"];
			} else {
				$total_line_cost = null;
			}
			
			if ($total_free_ticket_cnt > 0) {
				$total_free_ticket_cnt += $this_ticket["free_ticket_cnt"];
			} else {
				$total_free_ticket_cnt = 0;
			}
			
			
			$this->objOLGComb->LottoTicketUpdate(   $tkt_data["ticket_id"],null, null, null, null, 	$total_amt_won, $total_free_ticket_cnt, $total_line_cost );
   
								
		 } elseif ($theGame == $this->lbl_onpick4) {
		 
		 	$comb_select_id = $this->objOLGComb->OLGCombPick4GetId($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3]);
			if (!$comb_select_id) {
				$comb_select_id = $this->objOLGComb->OLGCombPick4Add($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3]);
			
			}
			
		 
			$dataOut .= $this->ValidateOnPick4($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3]
									  );
									  
			$total_amt_won = 0;
			$total_free_ticket_cnt = 0;
			$total_win_cnt = 0;
			$total_line_cost = 0;
			
			$iSeqNo = 0;
			
			
			foreach ($dataOut as $singleData) {
				$amt_won = 0;
				$free_ticket_cnt = 0;
				$match_str = "";
				
				if ($singleData["prze_amt"] > 0) {
					$total_amt_won += $singleData["prze_amt"];
					$total_win_cnt++;
					
				}
				if ($singleData["FreeTicket"] == 1) {
					$total_free_ticket_cnt++;
					$total_win_cnt++;
				} 
				if ($singleData["ln_cost"] > 0) {
					
					$total_line_cost += $singleData["ln_cost"];
				}
				if ($singleData["bonus_match"] == 1) {
					$match_str = $singleData["match_cnt"] . "B";
					
				} else {
					$match_str = $singleData["match_cnt"];
				}
				
				$lotto_line_id = $this->objOLGComb->LottoLineGetId( $tkt_data["ticket_id"], $comb_select_id, $iSeqNo);
				if (!$lotto_line_id) {
				    $lotto_line_id = $this->objOLGComb->LottoLineAdd(  $tkt_data["ticket_id"],
					   $comb_select_id,  null, $cur_gm_data["game"],  $singleData["prze_amt"],
					  $singleData["match_cnt"],  $match_str,  $singleData["FreeTicket"], $singleData["ln_cost"]);
				}
				$iSeqNo++;
			}
			
			$this_ticket = $this->objOLGComb->LottoTicketGet($tkt_data["ticket_id"] );
			
			
			if ($total_line_cost > 0) {
				$total_line_cost += $this_ticket["ticket_cost"];
			} else {
				$total_line_cost = null;
			}
			
			if ($total_free_ticket_cnt > 0) {
				$total_free_ticket_cnt += $this_ticket["free_ticket_cnt"];
			} else {
				$total_free_ticket_cnt = 0;
			}
			
			
			$this->objOLGComb->LottoTicketUpdate(   $tkt_data["ticket_id"],null, null, null, null, 	$total_amt_won, $total_free_ticket_cnt, $total_line_cost );
   
			
									  
									  
		 } elseif ($theGame == $this->lbl_onkeno) {
		 	$comb_select_id = $this->objOLGComb->OLGCombKenoGetId($cur_gm_data["category"],
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
			
			if (!$comb_select_id) {
				$comb_select_id = $this->objOLGComb->OLGCombKenoAdd($cur_gm_data["category"],
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
			}
			
			
		 
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
									   
			$total_amt_won = 0;
			$total_free_ticket_cnt = 0;
			$total_win_cnt = 0;
			$total_line_cost = 0;
			
			$iSeqNo = 0;
			foreach ($dataOut as $singleData) {					   
				$amt_won = 0;
				$free_ticket_cnt = 0;
				$match_str = "";
				
				if ($singleData["prze_amt"] > 0) {
					$total_amt_won += $singleData["prze_amt"];
					$total_win_cnt++;
					
				}
				if ($singleData["FreeTicket"] == 1) {
					$total_free_ticket_cnt++;
					$total_win_cnt++;
				} 
				if ($singleData["ln_cost"] > 0) {
					
					$total_line_cost += $singleData["ln_cost"];
				}
				if ($singleData["bonus_match"] == 1) {
					$match_str = $singleData["match_cnt"] . "B";
					
				} else {
					$match_str = $singleData["match_cnt"];
				}
				
				$lotto_line_id = $this->objOLGComb->LottoLineGetId( $tkt_data["ticket_id"], $comb_select_id, $iSeqNo);
				if (!$lotto_line_id) {
	 	 	   		$lotto_line_id = $this->objOLGComb->LottoLineAdd(  $tkt_data["ticket_id"],
					   $comb_select_id,  null, $cur_gm_data["game"],  $singleData["prze_amt"],
					  $singleData["match_cnt"],  $match_str,  $singleData["FreeTicket"], $singleData["ln_cost"]);
				}
				
*/
				$iSeqNo++;
			}
			
			$this_ticket = $this->objOLGComb->LottoTicketGet($tkt_data["ticket_id"] );
			
			if ($total_line_cost > 0) {
				$total_line_cost += $this_ticket["ticket_cost"];
			} else {
				$total_line_cost = null;
			}
			
			if ($total_free_ticket_cnt > 0) {
				$total_free_ticket_cnt += $this_ticket["free_ticket_cnt"];
			} else {
				$total_free_ticket_cnt = 0;
			}
			
			
			$this->objOLGComb->LottoTicketUpdate(   $tkt_data["ticket_id"],null, null, null, null, 	$total_amt_won, $total_free_ticket_cnt, $total_line_cost );
   
									   
			} elseif ($theGame == $this->lbl_onlottario) {
			
				$comb_select_id = $this->objOLGComb->OLGCombLottarioGetId( $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
				if (!$comb_select_id) {
					$comb_select_id = $this->objOLGComb->OLGCombLottarioAdd($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
				
				}
				$dataOut .= $this->ValidateOnLottario($cur_gm_data["date"],
									   $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3],
									   $cur_gm_data["numbers"][4],
									   $cur_gm_data["numbers"][5]);
									   
				$total_amt_won = 0;
				$total_free_ticket_cnt = 0;
				$total_win_cnt = 0;
				$total_line_cost = 0;
				
				$iSeqNo = 0;
			foreach ($dataOut as $singleData) {					   
				$amt_won = 0;
				$free_ticket_cnt = 0;
				$match_str = "";
				
				if ($singleData["prze_amt"] > 0) {
					$total_amt_won += $singleData["prze_amt"];
					$total_win_cnt++;
					
				}
				if ($singleData["FreeTicket"] == 1) {
					$total_free_ticket_cnt++;
					$total_win_cnt++;
				} 
				if ($singleData["ln_cost"] > 0) {
					
					$total_line_cost += $singleData["ln_cost"];
				}
				if ($singleData["bonus_match"] == 1) {
					$match_str = $singleData["match_cnt"] . "B";
					
				} else {
					$match_str = $singleData["match_cnt"];
				}
				
				$lotto_line_id = $this->objOLGComb->LottoLineGetId( $tkt_data["ticket_id"], $comb_select_id, $iSeqNo);
				if (!$lotto_line_id) {
	 	 	   		$lotto_line_id = $this->objOLGComb->LottoLineAdd(  $tkt_data["ticket_id"],
					   $comb_select_id,  null, $cur_gm_data["game"],  $singleData["prze_amt"],
					  $singleData["match_cnt"],  $match_str,  $singleData["FreeTicket"], $singleData["ln_cost"]);
				}
				
				
				$iSeqNo++;
			}
			
			$this_ticket = $this->objOLGComb->LottoTicketGet($tkt_data["ticket_id"] );
			
			if ($total_line_cost > 0) {
				$total_line_cost += $this_ticket["ticket_cost"];
			} else {
				$total_line_cost = null;
			}
			
			if ($total_free_ticket_cnt > 0) {
				$total_free_ticket_cnt += $this_ticket["free_ticket_cnt"];
			} else {
				$total_free_ticket_cnt = 0;
			}
			
			
			$this->objOLGComb->LottoTicketUpdate(   $tkt_data["ticket_id"],null, null, null, null, 	$total_amt_won, $total_free_ticket_cnt, $total_line_cost );
   
			
									   
			} elseif ($theGame == $lbl_onearlybird) {
			
			$comb_select_id = $this->objOLGComb->OLGCombEarlyBirdGetId( $cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3]);
			if (!$comb_select_id) {
				$comb_select_id = $this->objOLGComb->OLGCombEarlyBirdAdd($cur_gm_data["numbers"][0],
									   $cur_gm_data["numbers"][1],
									   $cur_gm_data["numbers"][2],
									   $cur_gm_data["numbers"][3]);
			
			}
			
			
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
									   
			$total_amt_won = 0;
			$total_free_ticket_cnt = 0;
			$total_win_cnt = 0;
			$total_line_cost = 0;
			
			$iSeqNo = 0;
			foreach ($dataOut as $singleData) {					   
				$amt_won = 0;
				$free_ticket_cnt = 0;
				$match_str = "";
				
				if ($singleData["prze_amt"] > 0) {
					$total_amt_won += $singleData["prze_amt"];
					$total_win_cnt++;
					
				}
				if ($singleData["FreeTicket"] == 1) {
					$total_free_ticket_cnt++;
					$total_win_cnt++;
				} 
				if ($singleData["ln_cost"] > 0) {
					
					$total_line_cost += $singleData["ln_cost"];
				}
				if ($singleData["bonus_match"] == 1) {
					$match_str = $singleData["match_cnt"] . "B";
					
				} else {
					$match_str = $singleData["match_cnt"];
				}
				
				$lotto_line_id = $this->objOLGComb->LottoLineGetId( $tkt_data["ticket_id"], $comb_select_id, $iSeqNo);
				if (!$lotto_line_id) {
	 	 	   		$lotto_line_id = $this->objOLGComb->LottoLineAdd(  $tkt_data["ticket_id"],
					   $comb_select_id,  null, $cur_gm_data["game"],  $singleData["prze_amt"],
					  $singleData["match_cnt"],  $match_str,  $singleData["FreeTicket"], $singleData["ln_cost"]);
				}
				
				/*
				$lotto_line_id = $this->objOLGComb->LottoLineAdd( $user_id, $comb_select_id, $iSeqNo,
				  $cur_gm_data["date"], $game_id, $amt_won, $singleData["match_cnt"], "", $free_ticket_cnt, $ln_cost, $envelope_no, $store_id);

*/
				$iSeqNo++;
			}
			
			$this_ticket = $this->objOLGComb->LottoTicketGet($tkt_data["ticket_id"] );
			
			
			if ($total_line_cost > 0) {
				$total_line_cost += $this_ticket["ticket_cost"];
			} else {
				$total_line_cost = null;
			}
			
			if ($total_free_ticket_cnt > 0) {
				$total_free_ticket_cnt += $this_ticket["free_ticket_cnt"];
			} else {
				$total_free_ticket_cnt = 0;
			}
			
			
			$this->objOLGComb->LottoTicketUpdate(   $tkt_data["ticket_id"],null, null, null, null, 	$total_amt_won, $total_free_ticket_cnt, $total_line_cost );
									   
			}
		  	return $dataOut;
	
			// ( $userid, $comb_select_id, $drawdate, $game_id, $amount_won, $match_cnt, $match_str, $free_ticket_cnt, $ticket_cost, $envelope_no, $store_id)

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
			 $dataOut[$irec_cnt]["bonus_match"] = 0;
			 $dataOut[$irec_cnt]["match_cnt"] = $single_result["match_cnt"];
			 $dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];

			 $dataOut[$irec_cnt]["html"] .= "\n<br />649 Draw Date: " . $single_result["drawdate"];
			 $dataOut[$irec_cnt]["win_prze_type"] = $single_result["win_prze_type"];
			 if ($single_result["match_bonus_num"] > 0) {
			    $dataOut[$irec_cnt]["bonus_match"] = 1;
			 }
			 
			 if ($single_result["win_prze_type"] == 1) {
					/// Free Ticket
					$dataOut[$irec_cnt]["prze_amt"] = 0;
					$dataOut[$irec_cnt]["FreeTicket"] = 1;
			}
			$dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_na649];
			$dataOut[$irec_cnt]["game"] = $this->lbl_na649;
			
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
			 
			 
			 
			 
			 if ($dataOut[$irec_cnt]["FreeTicket"] == 1) {
				$dataOut[$irec_cnt]["html"] .= " Won a Free Ticket";
			 } elseif ($dataOut[$irec_cnt]["prze_amt"] > 0) {
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
			 $dataOut[$irec_cnt]["bonus_match"] = 0;
			 
			 $dataOut[$irec_cnt]["match_cnt"] = $single_result["match_cnt"];
			 $dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 $dataOut[$irec_cnt]["isequencenum"] = $single_result["isequencenum"];
			 $dataOut[$irec_cnt]["win_prze_type"] = $single_result["win_prze_type"];
			 if ($single_result["match_bonus_num"] > 0) {
			    $dataOut[$irec_cnt]["bonus_match"] = 1;
			 }
			 if ($single_result["win_prze_type"] == 1) {
					/// Free Ticket
					$dataOut[$irec_cnt]["prze_amt"] = 0;
					$dataOut[$irec_cnt]["FreeTicket"] = 1;
			}
			
			
			 if ($single_result["isequencenum"] == 0) {
			 	 $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_namax];
			 }
			
			 $dataOut[$irec_cnt]["game"] = $this->lbl_namax;
			 
			
			 
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
			 
			 
			 
			
		
					 
			 if ($dataOut[$irec_cnt]["FreeTicket"] == 1) {
				$dataOut[$irec_cnt]["html"] .= " Won a Free Ticket";
			 } elseif ($dataOut[$irec_cnt]["prze_amt"] > 0) {
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
			 $dataOut[$irec_cnt]["bonus_match"] = 0;
			 $dataOut[$irec_cnt]["match_cnt"] = $single_result["match_cnt"];
			 $dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 
			 $dataOut[$irec_cnt]["html"] .= "\n<br />Ontario 49 Draw Date: " . $single_result["drawdate"];
			 $dataOut[$irec_cnt]["win_prze_type"] = $single_result["win_prze_type"];
			 if ($single_result["match_bonus_num"] > 0) {
			    $dataOut[$irec_cnt]["bonus_match"] = 1;
			 }
			 
			 if ($single_result["win_prze_type"] == 1) {
					/// Free Ticket
					$dataOut[$irec_cnt]["prze_amt"] = 0;
					$dataOut[$irec_cnt]["FreeTicket"] = 1;
			}
			$dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_on49];
			$dataOut[$irec_cnt]["game"] = $this->lbl_on49;
			 
			 
			 
			 
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
			 $dataOut[$irec_cnt]["match_cnt"] = $single_result["match_cnt"];
			 $dataout[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			 $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onkeno];
			 $dataOut[$irec_cnt]["game"] = $this->lbl_onkeno;
			 $dataOut[$irec_cnt]["category"] = $single_result["category"];
			 if ($single_result["win_prze_type"] == 1) {
			 		$dataOut[$irec_cnt]["prze_amt"] = 0;
					$dataOut[$irec_cnt]["FreeTicket"] = 1;
			 
			 }
			 
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
			 

			 $dataOut[$irow_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onpoker];
			 $dataOut[$irow_cnt]["game"] = $this->lbl_onpoker;
			 $dataOut[$irow_cnt]["instant_win"] = $result["instant_win"];
			 $dataOut[$irow_cnt]["instant_win_prze_amt"] = $result["instant_win_prze_amt"];
			 $dataOut[$irow_cnt]["win_prze_amount"]  = $single_result["win_prze_amount"];
			 $dataOut[$irow_cnt]["match_cnt"] = $single_result["match_cnt"];
	
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
			
		  
		 
		  if ($result["instant_win"] != "") {
		
		  $dataOut[$irow_cnt]["instant_win"] = $result["instant_win"];
		  $dataOut[$irow_cnt]["instant_win_amount"] = $result["instant_win_prze_amt"];
		  // instant wins
		  
				  
		  if ($result["instant_win"] == "rf") {
			//$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];
			
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Royal Flush <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
	
		  } elseif ($result["instant_win"] == "sf") {
			//$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Straight Flush <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
		  } elseif ($result["instant_win"] == "4k") {
			//$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: 4 of a Kind <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>"; 
		  } elseif ($result["instant_win"] == "fh") {
			//$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Full House <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
			
		  } elseif ($result["instant_win"] == "f") {
			//$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Flush <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
		  
		  } elseif ($result["instant_win"] == "s") {
			//$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: Straight <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
		  } elseif ($result["instant_win"] == "3k") {
			//$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: 3 of a Kind <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";  
		  } elseif ($result["instant_win"] == "2p") {
			//$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	
			$dataOut[$irow_cnt]["html"] .= "\n<br />Instant Win: 2 pair <span class='win_amt'>$" . money_format('%(#12n',$dataOut["prze_amt"]) . "</span>";
		  
		  } elseif ($result["instant_win"] == "pj") {
			//$dataOut[$irow_cnt]["instant_match"] = $result["instant_match"];  	  
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
			 $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onlottario];
			 $dataOut[$irec_cnt]["game"] = $this->lbl_onlottario;
			 $dataOut[$irec_cnt]["win_prze_ebird_amt"] = $single_result["win_prze_ebird_amount"];
			 $dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];			 
			 if ($single_result["match_bonus_num"] > 0) {
			    $dataOut[$irec_cnt]["bonus_match"] = 1;
			 }
			 $dataOut[$irec_cnt]["match_cnt"] = $single_result["match_cnt"];
			 $dataOut[$irec_cnt]["win_prze_type"] = $single_result["win_prze_type"];
			if ($single_result["win_prze_type"] == 1) {
					/// Free Ticket
					$dataOut[$irec_cnt]["prze_amt"] = 0;
					$dataOut[$irec_cnt]["FreeTicket"] = 1;
			}
			 
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
		$dataOut = array();
		foreach ($result as $single_result) {
		
		 $dataOut[$irec_cnt] = array();
		 
		 $dataOut[$irec_cnt]["match_cnt"] = $single_result["match_cnt"];
		 $dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
		 $dataOut[$irec_cnt]["win_prze_type"] = $single_result["win_prze_type"];
		 $dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onencore];
		 $dataOut[$irec_cnt]["game"] = $this->lbl_onencore;
		 
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
	   
		
		
		$irec_cnt++;
		
		}
		return $dataOut;
		
	  }
	  
	  function ValidateOnPick3($sdrawDate, $snum1, $snum2, $snum3) {
		 
		 
		 $sdrawDate = date('Y-m-d', $sdrawDate);
		 $play_type_any = 2;
		 $result = $this->objOLG->OLGPick3ValidateDraw($sdrawDate, $sdrawDate,$play_type_any, $snum1, $snum2, $snum3);
	  
	  $irec_cnt = 0;
	     $dataOut = array();
		foreach ($result as $single_result) {
		$dataOut[$irec_cnt] = array();
		$dataOut[$irec_cnt]["match_cnt"] = $single_result["match_cnt"];
		$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
		$dataOut[$irec_cnt]["win_prze_straight_amount"] = $single_result["win_prze_straight_amount"];
		$dataOut[$irec_cnt]["win_prze_box_amount"] = $single_result["win_prze_box_amount"];
		$dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onpick3];
	  	$dataOut[$irec_cnt]["game"] = $this->lbl_onpick3;

	    
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
      
      
	   
	  

     
    
    $irec_cnt++;
    }

	  return $dataOut;
	  
	  }
	  
	  
	  
	  function ValidateOnPick4($sdrawDate, $snum1, $snum2, $snum3, $snum4) {
		 
		 
		 $sdrawDate = date('Y-m-d', $sdrawDate);
		 $play_type_any = 2;
		 
		 $result = $this->objOLG->OLGPick4ValidateDraw($sdrawDate, $sdrawDate,$play_type_any, $snum1, $snum2, $snum3, $snum4);
	
		  $irec_cnt = 0;
		  $dataOut = array();
		foreach ($result as $single_result) {
			$dataOut[$irec_cnt] = array();
			$dataOut[$irec_cnt]["match_cnt"] = $single_result["match_cnt"];
			$dataOut[$irec_cnt]["prze_amt"] = $single_result["win_prze_amount"];
			$dataOut[$irec_cnt]["win_prze_straight_amount"] = $single_result["win_prze_straight_amount"];
			$dataOut[$irec_cnt]["win_prze_box_amount"] = $single_result["win_prze_box_amount"];
			$dataOut[$irec_cnt]["ln_cost"] = $this->tkt_ln_cost[$this->lbl_onpick3];
			$dataOut[$irec_cnt]["game"] = $this->lbl_onpick3;

		
	
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
		  }
	
		  if ($single_result["win_prze_box_amount"] > 0) {
			$dataOut[$irec_cnt]["html"] .= $single_result["match_box"];
			$dataOut[$irec_cnt]["html"] .= " Box Win - <span class='win_amt'>$" . money_format('%(#12n',$single_result["win_prze_box_amount"]) . "</span><br />";
		  }
	
	   
		
			$irec_cnt++;
		}
		 return $dataOut;
		
	  }
	

}


?>