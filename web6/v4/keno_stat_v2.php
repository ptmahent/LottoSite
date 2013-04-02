<?php


/*
 * 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.

*/

include_once("inc2/class_db.php");
include_once("inc2/execution_time.php");
include_once("inc2/incOLGLottery.php");
include_once("inc2/incCombOLGLottery.php");
include_once("inc2/cli_compatibility.php");
include_once("inc2/phpArguments.php");
include_once("inc2/incGenDates.php");
  
  // Debug Mode
  // 0 = verbose disabled
  // 1 = verbose enabled
  // 2 = verbose extra info
  // 3 = Extra debug info
  
  $debug_mode         = 2;
  
  $objLottery = new Lottery();
  //$objOLG     = new OLGLottery();
  
  $cmdargs = arguments();
  
  
  if (count($cmdargs,1) > 2) {
  	print_r($cmdargs);
  } else {
  
      do {
        fwrite(STDOUT, "\tEnter one of the options Below: \n\n\n");
        fwrite(STDOUT, "\tstatGenYear [yyyy] : dddd should be year in 4 digits \n");          // 
        fwrite(STDOUT, "\tstatGenMonth [mm-yyyy] : mm-yyyy format of selected month\n");      //
        fwrite(STDOUT, "\tstatGenDraw [dd-mm-yyyy] : dd-mm-yyyy format of selected month\n\n");      //
        fwrite(STDOUT, "\tstatRepeatYear [yyyy] : dddd should be year in 4 digits \n");     
        //fwrite(STDOUT, "\tstatRepeatMonth [mm-yyyy] : dddd should be year in 4 digits \n");     
        fwrite(STDOUT, "\tstatGenYearCount [yyyy] : dddd should be year in 4 digits \n");
       // fwrite(STDOUT, "\tstat
        fwrite(STDOUT, "\t[dd-mm-yyyy] - [dd-mm-yyyy]");
        fwrite(STDOUT, "\n\t\n\t: ");    
        do {
          $selection = trim(fgets(STDIN));
    	} while (trim($selection) == '');
    	$startDate = null;
    	$endDate = null;
    	$drawDates = array();
    	
    	if (preg_match("/statRepeatYear (\d{4})/i", $selection, $lmatches)) {
    		$selectedYear = $lmatches[1];
      		//$startDate    = mktime(0,0,0,1,1,$selectedYear);
      		//$endDate      = mktime(0,0,0,12,31,$selectedYear);
      		
      		print_r($lmatches);
      		
    		Generate_Keno_Repeats($selectedYear);

    	} elseif (preg_match("/statGenYearCount (\d{4})/i", $selection, $lmatches)) {
    		$selectedYear = $lmatches[1];
      		//$startDate    = mktime(0,0,0,1,1,$selectedYear);
      		//$endDate      = mktime(0,0,0,12,31,$selectedYear);
      		print_r($lmatches);
      		
    		Generate_Keno_Stats_Wk_Mnthly($selectedYear) ;
    		
    	} elseif (preg_match("/statGenDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
       		print_r($lmatches); 
      		$selectedDay    = $lmatches[1];
      		$selectedMonth  = $lmatches[2];
      		$selectedYear   = $lmatches[3];
      		$startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      		$endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      		//$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "DD", $startDate, $endDate);
    	} elseif (preg_match("/statGenMonth (\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
      		$selectedMonth = $lmatches[1];
      		$selectedYear = $lmatches[2];
      		$startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      		$endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      		//$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "MM", $startDate, $endDate);    
    	} elseif (preg_match("/statGenYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
     	 	$selectedYear = $lmatches[1];
      		$startDate    = mktime(0,0,0,1,1,$selectedYear);
      		$endDate      = mktime(0,0,0,12,31,$selectedYear);
      		//$drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "YY", $startDate, $endDate);
    	}
		
		//print_r($drawDates);
		//if (is_array($drawDates)) {
		
		
		  //foreach ($drawDates as $dtDate) {
			  // 20090211
			//$drawDate = strtotime($dtDate);
			//print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
			//print_r($dtDate);
			//alc_fetch_single_draw(date('d-m-Y',$drawDate));
			//on_fetch_first_step_649(date('d-m-Y', $drawDate));
			//on_fetch_first_step_max(date('d-m-Y', $drawDate));
			//on_fetch_first_step_keno(date('d-m-Y', $drawDate));
		  //}
		  
		   // call next stage function
		   
		
	   } while (trim($selection) != 'q');
  }
  



function OLGKenoGenerateIncr($st_date, $ed_date) {

	$_start_Stat_Gen_Time = slog_time();
	
	$db_obj = new db();
	
	$ssql = "SELECT `drawdate`, `snum1`, `snum2`, `snum3`, `snum4`, `snum5`, `snum6`, `snum7`, `snum8`, `snum9`, `snum10`, `snum11`, `snum12`, `snum13`, `snum14`, `snum15`, `snum16`, `snum17`, `snum18`, `snum19`, `snum20` FROM `tbl_on_keno` WHERE ";
	$ssql .= sprintf("`drawdate` >= '%s' AND `drawdate` <= '%s'", date('Y-m-d',$st_date), date('Y-m-d',$ed_date));
	print "\nSSQL : " . $ssql;

	$db_res = $db_obj->fetch($ssql);
	
	print_r($db_res);
	$OLGLottery = new OLGLottery();
	$CombOLGLottery = new CombOLGLottery();

	if (is_array($db_res)) {
		$xcnt = count($db_res);
		for ($i = 0; $i < $xcnt; $i++ ) {
			//print_r($db_set
			$comb_items = keno_stat_gen_increment($db_res[$i]);
	
	
			foreach ($comb_items as $comb_it_name => $comb_it_val) {
		
			if ($comb_it_name == "adj") {
				
				//print $comb_it_name . "\n";
				foreach ($comb_it_val as $adj_comb_it_name => $adj_comb_it_val) {
					print "\nADJ - " . $adj_comb_it_name . "\n";
					//print_r($adj_comb_it_val);
					print "\n XXCOMB -- ";
					$_incr_ = explode("_",$adj_comb_it_name);
					print_r($_incr_);
					$_incr_ = $_incr_[1];
					
					print "\n incr - : " . $_incr_;
					//print_r($adj_comb_it_val);
					print "\n pos 1 -> " . $adj_comb_it_val["pos"] . " -- pos 2 - " . $adj_comb_it_val[0]["pos"];
					print "\n Date: " . $comb_items["drawdate"];
					
	
					
					if (is_array($adj_comb_it_val)) {
						
						if ($_incr_ == 0) {
							print_r($adj_comb_it_val);
							
							$_i_cat = 20;
							$comb_draw_date = date('Y-m-d',strtotime($comb_items["drawdate"]));						
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $adj_comb_it_val[0], $adj_comb_it_val[1], $adj_comb_it_val[2], $adj_comb_it_val[3], $adj_comb_it_val[4], $adj_comb_it_val[5], $adj_comb_it_val[6], $adj_comb_it_val[7], $adj_comb_it_val[8], $adj_comb_it_val[9], $adj_comb_it_val[10], $adj_comb_it_val[11] , $adj_comb_it_val[12]  , $adj_comb_it_val[13], $adj_comb_it_val[14], $adj_comb_it_val[15], $adj_comb_it_val[16], $adj_comb_it_val[17], $adj_comb_it_val[18], $adj_comb_it_val[19]);
							if (!$i_comb_keno_id) {
								$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $adj_comb_it_val[0], $adj_comb_it_val[1], $adj_comb_it_val[2], $adj_comb_it_val[3], $adj_comb_it_val[4], $adj_comb_it_val[5], $adj_comb_it_val[6], $adj_comb_it_val[7], $adj_comb_it_val[8], $adj_comb_it_val[9], $adj_comb_it_val[10], $adj_comb_it_val[11], $adj_comb_it_val[12] , $adj_comb_it_val[13]  , $adj_comb_it_val[14], $adj_comb_it_val[15],$adj_comb_it_val[16], $adj_comb_it_val[17], $adj_comb_it_val[18], $adj_comb_it_val[19]);
							}
								
							// add all 20 combination id to occur table
							// Add comb keno id to occur table for the specific date
							if ($i_comb_keno_id != null) {
	
								$c_k_occur = $CombOLGLottery->OLGCombKenoOccurGet($i_comb_keno_id, $comb_draw_date);
								if ($c_k_occur == null) {
									$CombOLGLottery->OLGCombKenoOccurAdd($i_comb_keno_id, $comb_draw_date, 1);
								} else {
									if ($c_k_occur["adj_"] != 1) {
										$CombOLGLottery->OLGCombKenoOccurSet($i_comb_keno_id, $comb_draw_date, 1);
									}
								}
							
							}
							
							// add all 20 individual numbers to combination table
							//
							$_i_cat = 1;
							for ($_x_1 = 0; $_x_1 < 20; $_x_1++) {
							
							
								$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId($_i_cat, $_incr_, $adj_comb_it_val[$_x_1]);
								if (!$i_comb_keno_id) {
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $adj_comb_it_val[$_x_1]);
								}
								// Add comb keno id to occur table for the specific date
								if ($i_comb_keno_id != null) {
									$c_k_occur = $CombOLGLottery->OLGCombKenoOccurGet($i_comb_keno_id, $comb_draw_date);
									if ($c_k_occur == null) {
										$CombOLGLottery->OLGCombKenoOccurAdd($i_comb_keno_id, $comb_draw_date, 0);
									} 
								
								}
							}
						
	
							
							
						}
									
					
						foreach ($adj_comb_it_val as $__adj_comb_id => $__adj_comb_it_val) {
							print_r($__adj_comb_it_val);
							if ($_incr_ == 0) {
							
							
							} else {
							
							
								$_i_cat = $__adj_comb_it_val["pos"] + 1;	
								print "\n cat : " . $_i_cat;
								print_r($__adj_comb_it_val);
								if (is_array($__adj_comb_it_val)) {
									$i_comb_keno_id = null;
									switch ($_i_cat)
									{
										case 2:
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1]);
											}
											//print "\n N1: " . $__adj_comb_it_val[0];
											//print "\n N2: " . $__adj_comb_it_val[1];
											break;
										case 3:
	
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2]);
											}
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];
											*/						
											break;
				
										case 4:
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3]);
											}
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											*/
											break;
									
										case 5:
										
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4]);
											}
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];	
											*/
											break;
											
										case 6:
										
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5]);
											}
										
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											*/
											break;
									
										case 7:
										
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6]);
											}
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];								
											*/
											break;
										case 8:
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7]);
											}
										
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];								
											*/
											break;
									
										case 9:
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8]);
											}
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											*/
											break;
										
										case 10:
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9] );
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9]);
											}
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];							
											
											*/
											break;
									
										case 11:
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10] );
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10]);
											}
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];							
											*/
											
											break;
										case 12:
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11]  );
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] );
											}
										
										
										
										
										/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];
											print "\n N12: " . $__adj_comb_it_val[11];							
											*/
											
											break;
									
										case 13:
										
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  );
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12]  );
											}
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];
											print "\n N12: " . $__adj_comb_it_val[11];
											print "\n N13: " . $__adj_comb_it_val[12];						
											
											*/
											break;
										
										case 14:
										
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13] );
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  );
											}
										
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];
											print "\n N12: " . $__adj_comb_it_val[11];
											print "\n N13: " . $__adj_comb_it_val[12];						
											print "\n N14: " . $__adj_comb_it_val[13];						
											*/
											
											break;
									
										case 15:
										
										
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14] );
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14]);
											}
										
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];
											print "\n N12: " . $__adj_comb_it_val[11];
											print "\n N13: " . $__adj_comb_it_val[12];						
											print "\n N14: " . $__adj_comb_it_val[13];
											print "\n N15: " . $__adj_comb_it_val[14];						
											
											*/
											break;
										case 16:
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15] );
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15]);
											}
										
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];
											print "\n N12: " . $__adj_comb_it_val[11];
											print "\n N13: " . $__adj_comb_it_val[12];						
											print "\n N14: " . $__adj_comb_it_val[13];
											print "\n N15: " . $__adj_comb_it_val[14];
											print "\n N16: " . $__adj_comb_it_val[15];
											
											*/
											break;
									
										case 17:
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15], $__adj_comb_it_val[16]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15],$__adj_comb_it_val[16]);
											}
										
										
										
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];
											print "\n N12: " . $__adj_comb_it_val[11];
											print "\n N13: " . $__adj_comb_it_val[12];						
											print "\n N14: " . $__adj_comb_it_val[13];
											print "\n N15: " . $__adj_comb_it_val[14];
											print "\n N16: " . $__adj_comb_it_val[15];
											print "\n N17: " . $__adj_comb_it_val[16];
											*/
											
											break;
										case 18:
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15], $__adj_comb_it_val[16], $__adj_comb_it_val[17]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15],$__adj_comb_it_val[16], $__adj_comb_it_val[17]);
											}
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];
											print "\n N12: " . $__adj_comb_it_val[11];
											print "\n N13: " . $__adj_comb_it_val[12];						
											print "\n N14: " . $__adj_comb_it_val[13];
											print "\n N15: " . $__adj_comb_it_val[14];
											print "\n N16: " . $__adj_comb_it_val[15];
											print "\n N17: " . $__adj_comb_it_val[16];
											print "\n N18: " . $__adj_comb_it_val[17];
											
											*/
											break;
									
										case 19:
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15], $__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15],$__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18]);
											}
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];
											print "\n N12: " . $__adj_comb_it_val[11];
											print "\n N13: " . $__adj_comb_it_val[12];						
											print "\n N14: " . $__adj_comb_it_val[13];
											print "\n N15: " . $__adj_comb_it_val[14];
											print "\n N16: " . $__adj_comb_it_val[15];
											print "\n N17: " . $__adj_comb_it_val[16];
											print "\n N18: " . $__adj_comb_it_val[17];
											print "\n N19: " . $__adj_comb_it_val[18];
											
											*/
											break;
										case 20:
										
										
											$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15], $__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18], $__adj_comb_it_val[19]);
											if (!$i_comb_keno_id) {
												$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15],$__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18], $__adj_comb_it_val[19]);
											}
										
										
											/*
											print "\n N1: " . $__adj_comb_it_val[0];
											print "\n N2: " . $__adj_comb_it_val[1];
											print "\n N3: " . $__adj_comb_it_val[2];						
											print "\n N4: " . $__adj_comb_it_val[3];	
											print "\n N5: " . $__adj_comb_it_val[4];
											print "\n N6: " . $__adj_comb_it_val[5];							
											print "\n N7: " . $__adj_comb_it_val[6];	
											print "\n N8: " . $__adj_comb_it_val[7];
											print "\n N9: " . $__adj_comb_it_val[8];
											print "\n N10: " . $__adj_comb_it_val[9];	
											print "\n N11: " . $__adj_comb_it_val[10];
											print "\n N12: " . $__adj_comb_it_val[11];
											print "\n N13: " . $__adj_comb_it_val[12];						
											print "\n N14: " . $__adj_comb_it_val[13];
											print "\n N15: " . $__adj_comb_it_val[14];
											print "\n N16: " . $__adj_comb_it_val[15];
											print "\n N17: " . $__adj_comb_it_val[16];
											print "\n N18: " . $__adj_comb_it_val[17];
											print "\n N19: " . $__adj_comb_it_val[18];
											print "\n N20: " . $__adj_comb_it_val[19];
											
											*/
											break;
									
				
										
									}
									// add combination to database for occured table database
									if ($i_comb_keno_id != null) {
										$comb_draw_date = date('Y-m-d',strtotime($comb_items["drawdate"]));
										$c_k_occur = $CombOLGLottery->OLGCombKenoOccurGet($i_comb_keno_id, $comb_draw_date);
										if ($c_k_occur == null) {
											// set adjacent to true
											$CombOLGLottery->OLGCombKenoOccurAdd($i_comb_keno_id, $comb_draw_date, 1);
										} else {
											if ($c_k_occur["adj_"] != 1) {
												$CombOLGLottery->OLGCombKenoOccurSet($i_comb_keno_id, $comb_draw_date, 1);
											}
										}
										
									}
								}
								//$_comb_id = $CombOLGLottery->OLGCombKenoAdd($)
							
							}
						}
						
					}	
					
					//foreach ($adj_comb_it_val as $_adj_comb_items) {
						
						//for ($x = 0; $x < $_adj_comb_items.length; $x++) {
							
							//print "\n: " . $_adj_comb_items[$x];
							//print_r($_adj_comb_items);
						//	print "\n";
							//print "\n<hr>";
						//}
						
					//}
					//match_wins = $OLGLottery->OLGKenoValidateDraw($st_drawdate, $ed_drawdate, $category, $snum1);
				}
			} else {
			
			
				print "\n Normal - XCOMB - " . $comb_it_name . "\n";
				$_incr_ = explode("_",$comb_it_name);
				print_r($_incr_);
				$_incr_ = $_incr_[1];
				//print_r($comb_it_val); 
				print "\n";
				print "\n Date: " . $comb_items["drawdate"];
				
				
				if (is_array($comb_it_val)) {
					foreach ($comb_it_val as $_comb_it_pos => $_comb_it_val) {
					//print_r($_comb_it_val);
					print "\nNormal - " . $_comb_it_pos . "\n";
					//print_r($_comb_it_val);
				
					$_i_cat = $_comb_it_val["pos"] + 1;
					
					print "\n CAT: " . $_i_cat . " -- INCR: " . $_incr_;
					switch ($_i_cat)
					{
					case 2:
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1]);
						}
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						*/
						break;
					case 3:
					
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2]);
						}
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];
						*/						
						break;
	
					case 4:
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3]);
						}
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						
						*/
						break;
				
					case 5:
					
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4]);
						}
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];	
						*/
						break;
						
					case 6:
					
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5]);
						}
					
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						*/
						
						break;
				
					case 7:
					
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6]);
						}
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];								
						*/
						
						break;
					case 8:
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7]);
						}
					
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];								
						*/
						
						break;
				
					case 9:
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8]);
						}
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						*/
						break;
					
					case 10:
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9] );
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9]);
						}
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];							
						*/
						
						break;
				
					case 11:
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10] );
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10]);
						}
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];							
						*/
						
						break;
					case 12:
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11]  );
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] );
						}
					
					
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];
						print "\n N12: " . $_comb_it_val[11];							
						*/
						
						break;
				
					case 13:
					
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  );
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12]  );
						}
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];
						print "\n N12: " . $_comb_it_val[11];
						print "\n N13: " . $_comb_it_val[12];						
						*/
						break;
					
					case 14:
					
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13] );
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  );
						}
					
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];
						print "\n N12: " . $_comb_it_val[11];
						print "\n N13: " . $_comb_it_val[12];						
						print "\n N14: " . $_comb_it_val[13];						
						*/
						break;
				
					case 15:
					
					
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14] );
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14]);
						}
					
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];
						print "\n N12: " . $_comb_it_val[11];
						print "\n N13: " . $_comb_it_val[12];						
						print "\n N14: " . $_comb_it_val[13];
						print "\n N15: " . $_comb_it_val[14];						
						*/
						break;
					case 16:
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15] );
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15]);
						}
					
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];
						print "\n N12: " . $_comb_it_val[11];
						print "\n N13: " . $_comb_it_val[12];						
						print "\n N14: " . $_comb_it_val[13];
						print "\n N15: " . $_comb_it_val[14];
						print "\n N16: " . $_comb_it_val[15];
						*/
						break;
				
					case 17:
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15], $_comb_it_val[16]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15],$_comb_it_val[16]);
						}
					
					
					
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];
						print "\n N12: " . $_comb_it_val[11];
						print "\n N13: " . $_comb_it_val[12];						
						print "\n N14: " . $_comb_it_val[13];
						print "\n N15: " . $_comb_it_val[14];
						print "\n N16: " . $_comb_it_val[15];
						print "\n N17: " . $_comb_it_val[16];
						*/
						
						break;
					case 18:
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15], $_comb_it_val[16], $_comb_it_val[17]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15],$_comb_it_val[16], $_comb_it_val[17]);
						}
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];
						print "\n N12: " . $_comb_it_val[11];
						print "\n N13: " . $_comb_it_val[12];						
						print "\n N14: " . $_comb_it_val[13];
						print "\n N15: " . $_comb_it_val[14];
						print "\n N16: " . $_comb_it_val[15];
						print "\n N17: " . $_comb_it_val[16];
						print "\n N18: " . $_comb_it_val[17];
						
						*/
						break;
				
					case 19:
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15], $_comb_it_val[16], $_comb_it_val[17], $_comb_it_val[18]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15],$_comb_it_val[16], $_comb_it_val[17], $_comb_it_val[18]);
						}
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];
						print "\n N12: " . $_comb_it_val[11];
						print "\n N13: " . $_comb_it_val[12];						
						print "\n N14: " . $_comb_it_val[13];
						print "\n N15: " . $_comb_it_val[14];
						print "\n N16: " . $_comb_it_val[15];
						print "\n N17: " . $_comb_it_val[16];
						print "\n N18: " . $_comb_it_val[17];
						print "\n N19: " . $_comb_it_val[18];
						
						*/
						break;
					case 20:
					
					
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15], $_comb_it_val[16], $_comb_it_val[17], $_comb_it_val[18], $_comb_it_val[19]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15],$_comb_it_val[16], $_comb_it_val[17], $_comb_it_val[18], $_comb_it_val[19]);
						}
					
					
						/*
						print "\n N1: " . $_comb_it_val[0];
						print "\n N2: " . $_comb_it_val[1];
						print "\n N3: " . $_comb_it_val[2];						
						print "\n N4: " . $_comb_it_val[3];	
						print "\n N5: " . $_comb_it_val[4];
						print "\n N6: " . $_comb_it_val[5];							
						print "\n N7: " . $_comb_it_val[6];	
						print "\n N8: " . $_comb_it_val[7];
						print "\n N9: " . $_comb_it_val[8];
						print "\n N10: " . $_comb_it_val[9];	
						print "\n N11: " . $_comb_it_val[10];
						print "\n N12: " . $_comb_it_val[11];
						print "\n N13: " . $_comb_it_val[12];						
						print "\n N14: " . $_comb_it_val[13];
						print "\n N15: " . $_comb_it_val[14];
						print "\n N16: " . $_comb_it_val[15];
						print "\n N17: " . $_comb_it_val[16];
						print "\n N18: " . $_comb_it_val[17];
						print "\n N19: " . $_comb_it_val[18];
						print "\n N20: " . $_comb_it_val[19];
						*/
						break;
				
	
						
					}
	
	
					if ($i_comb_keno_id != null) {
						$comb_draw_date = date('Y-m-d',strtotime($comb_items["drawdate"]));
						$c_k_occur = $CombOLGLottery->OLGCombKenoOccurGet($i_comb_keno_id, $comb_draw_date);
						if ($c_k_occur == null) {
							// set adjacent to true
							$CombOLGLottery->OLGCombKenoOccurAdd($i_comb_keno_id, $comb_draw_date, 0);
						}
						/* else {
							if ($c_k_occur["adj_"] != 1) {
								$CombOLGLottery->OLGCombKenoOccurSet($i_comb_keno_id, $comb_draw_date, 1);
							}
						} */
						
					}
						
				}
				}
			
				
		}
		
		
	}
			//	OLGKenoValidateDraw($st_drawdate, $ed_drawdate, $category, $snum1, $snum2="", $snum3="", $snum4="", $snum5="", $snum6="", $snum7="", $snum8="", $snum9="", $snum10="");
    	
    		print "\n-- " . $x . "--";
    	}
    	print "\n-- " . $xcnt . "--";
	} 
	
	$_Total_Stat_Gen_Time = elog_time($_start_Stat_Gen_Time);
	print "\n ---- Start Time: " . $_start_Stat_Gen_Time . " --- Generation Time: " . $_Total_Stat_Gen_Time;
}





//include_once("inc2/incStatGen.php");
//include_once("inc2/incLottery.php");

//
/*


adjacent combinations

incrementals



*/

/*

incrementals
from 1 to 34


*/

/*

repeats


$db_set = array();


$db_set[0] = array('drawdate' => '2010-05-31','snum1' => '10','snum2' => '15','snum3' => '16','snum4' => '19','snum5' => '20','snum6' => '21','snum7' => '24','snum8' => '31','snum9' => '35','snum10' => '38','snum11' => '39','snum12' => '49','snum13' => '56','snum14' => '59','snum15' => '61','snum16' => '62','snum17' => '64','snum18' => '66','snum19' => '67','snum20' => '70'); 
$db_set[1] = array('drawdate' => '2010-05-30','snum1' => '1','snum2' => '4','snum3' => '6','snum4' => '8','snum5' => '16','snum6' => '18','snum7' => '19','snum8' => '23','snum9' => '24','snum10' => '37','snum11' => '39','snum12' => '49','snum13' => '53','snum14' => '55','snum15' => '57','snum16' => '58','snum17' => '61','snum18' => '63','snum19' => '64','snum20' => '65'); 
$db_set[2] = array('drawdate' => '2010-05-29','snum1' => '3','snum2' => '7','snum3' => '12','snum4' => '15','snum5' => '29','snum6' => '33','snum7' => '34','snum8' => '35','snum9' => '37','snum10' => '42','snum11' => '46','snum12' => '51','snum13' => '56','snum14' => '58','snum15' => '59','snum16' => '60','snum17' => '61','snum18' => '62','snum19' => '65','snum20' => '67'); 
$db_set[3] = array('drawdate' => '2010-05-28','snum1' => '1','snum2' => '4','snum3' => '8','snum4' => '9','snum5' => '12','snum6' => '17','snum7' => '18','snum8' => '29','snum9' => '40','snum10' => '41','snum11' => '42','snum12' => '46','snum13' => '51','snum14' => '53','snum15' => '54','snum16' => '56','snum17' => '60','snum18' => '63','snum19' => '64','snum20' => '70'); 
$db_set[4] = array('drawdate' => '2010-05-27','snum1' => '2','snum2' => '5','snum3' => '15','snum4' => '18','snum5' => '20','snum6' => '23','snum7' => '32','snum8' => '34','snum9' => '37','snum10' => '46','snum11' => '47','snum12' => '50','snum13' => '53','snum14' => '57','snum15' => '59','snum16' => '60','snum17' => '61','snum18' => '66','snum19' => '69','snum20' => '70'); 
$db_set[5] = array('drawdate' => '2010-05-26','snum1' => '4','snum2' => '6','snum3' => '9','snum4' => '11','snum5' => '12','snum6' => '16','snum7' => '17','snum8' => '23','snum9' => '24','snum10' => '26','snum11' => '30','snum12' => '34','snum13' => '37','snum14' => '42','snum15' => '47','snum16' => '56','snum17' => '57','snum18' => '64','snum19' => '67','snum20' => '68'); 
$db_set[6] = array('drawdate' => '2010-05-25','snum1' => '1','snum2' => '2','snum3' => '4','snum4' => '5','snum5' => '8','snum6' => '10','snum7' => '18','snum8' => '20','snum9' => '30','snum10' => '31','snum11' => '32','snum12' => '34','snum13' => '47','snum14' => '51','snum15' => '55','snum16' => '58','snum17' => '59','snum18' => '65','snum19' => '69','snum20' => '70'); 
$db_set[7] = array('drawdate' => '2010-05-24','snum1' => '3','snum2' => '5','snum3' => '16','snum4' => '22','snum5' => '23','snum6' => '24','snum7' => '26','snum8' => '28','snum9' => '32','snum10' => '36','snum11' => '37','snum12' => '39','snum13' => '45','snum14' => '51','snum15' => '53','snum16' => '54','snum17' => '60','snum18' => '61','snum19' => '67','snum20' => '68'); 
$db_set[8] = array('drawdate' => '2010-05-23','snum1' => '3','snum2' => '6','snum3' => '13','snum4' => '16','snum5' => '21','snum6' => '24','snum7' => '25','snum8' => '30','snum9' => '31','snum10' => '33','snum11' => '37','snum12' => '39','snum13' => '40','snum14' => '41','snum15' => '48','snum16' => '51','snum17' => '53','snum18' => '57','snum19' => '64','snum20' => '65'); 
$db_set[9] = array('drawdate' => '2010-05-22','snum1' => '2','snum2' => '3','snum3' => '7','snum4' => '10','snum5' => '15','snum6' => '19','snum7' => '22','snum8' => '26','snum9' => '28','snum10' => '32','snum11' => '34','snum12' => '43','snum13' => '45','snum14' => '51','snum15' => '53','snum16' => '54','snum17' => '61','snum18' => '64','snum19' => '65','snum20' => '70'); 
$db_set[10] = array('drawdate' => '2010-05-21','snum1' => '1','snum2' => '6','snum3' => '12','snum4' => '17','snum5' => '20','snum6' => '21','snum7' => '23','snum8' => '25','snum9' => '31','snum10' => '32','snum11' => '34','snum12' => '36','snum13' => '48','snum14' => '55','snum15' => '58','snum16' => '59','snum17' => '66','snum18' => '67','snum19' => '68','snum20' => '69'); 
$db_set[11] = array('drawdate' => '2010-05-20','snum1' => '4','snum2' => '10','snum3' => '11','snum4' => '12','snum5' => '16','snum6' => '18','snum7' => '23','snum8' => '26','snum9' => '28','snum10' => '31','snum11' => '32','snum12' => '35','snum13' => '42','snum14' => '45','snum15' => '50','snum16' => '52','snum17' => '59','snum18' => '64','snum19' => '67','snum20' => '69'); 
$db_set[12] = array('drawdate' => '2010-05-19','snum1' => '2','snum2' => '14','snum3' => '17','snum4' => '20','snum5' => '21','snum6' => '29','snum7' => '30','snum8' => '37','snum9' => '38','snum10' => '45','snum11' => '48','snum12' => '51','snum13' => '56','snum14' => '60','snum15' => '61','snum16' => '63','snum17' => '64','snum18' => '66','snum19' => '68','snum20' => '69'); 
$db_set[13] = array('drawdate' => '2010-05-18','snum1' => '1','snum2' => '3','snum3' => '5','snum4' => '8','snum5' => '9','snum6' => '10','snum7' => '13','snum8' => '14','snum9' => '16','snum10' => '20','snum11' => '22','snum12' => '34','snum13' => '35','snum14' => '36','snum15' => '39','snum16' => '40','snum17' => '43','snum18' => '49','snum19' => '50','snum20' => '52'); 


$db_row = array(
	"snum1" => 4,
	"snum2" => 5,
	"snum3" => 8,
	"snum4" => 11,
	"snum5" => 12, 
	"snum6" => 14,
	"snum7" => 16,
	"snum8" => 33,
	"snum9" => 35,
	"snum10" => 37,
	"snum11" => 41,
	"snum12" => 46,
	"snum13" => 53,
	"snum14" => 56,
	"snum15" => 58, 
	"snum16" => 59,
	"snum17" => 61,
	"snum18" => 63,
	"snum19" => 67,
	"snum20" => 70
	);

*/
//print_r($db_row);
//keno_stat_gen_increment($db_row);

function keno_stat_gen_increment($db_row) {


	$comb_items = array();
	$comb_items["drawdate"] = $db_row["drawdate"];
	$i_min = 1;
	$i_max = 20;
	
	$incr_by_min = 1;
	$incr_by_max = 34;
	
	// $comb_items["adj"]
	// $comb_items["adj"]["pos"]
	// $comb_items["adj"]["n_1"] --
	// $comb_items["adj"]["n_34"]
	
	/*
	  $comb_items["n_0"] ---- original combo
	  $comb_items["n_1"] ---- from incremental by 1
	  
	  ---
	  
	  $comb_items["n_34"] ---- to incremental by 34
	
	
	*/
	$incr_by = 0;
	// Loop 1 to 20
	for ($i_1 = $i_min; $i_1 < $i_max; $i_1++) 
	{
		

		
		// create array for adjacent items
		if (!is_array($comb_items["adj"])) {
			$comb_items["adj"] = array();
			$comb_items["adj"]["n_0"] = array();
		
			for ($i_3 = 0; $i_3 < $i_max; $i_3++) {
				$comb_items["adj"]["n_0"][$i_3] = $db_row["snum" . ($i_3 + 1)];
				
			}
			$comb_items["adj"]["n_0"]["pos"] =  19;
			
		} 
		// check if cur item eq next item + incr_by
		if ($incr_by != 0) {
			
			$c_incr_by = $db_row["snum" . ($i_1 + 1)] - $db_row["snum" . ($i_1)];
			//print "<hr />" . intval($c_incr_by) . "<hr />";
			// if prev incr_by == current incr_by
			if ($incr_by == $c_incr_by) {
				//print "\ntesting <hr /> incre by match\n";
				$it_1_pos = $comb_items["adj"]["n_" . $incr_by]["pos"];
				$comb_items["adj"]["n_" . $incr_by][$it_1_pos]["pos"]++;
				$it_2_pos = $comb_items["adj"]["n_" . $incr_by][$it_1_pos]["pos"];
				
				$comb_items["adj"]["n_" . $incr_by][$it_1_pos][$it_2_pos] = $db_row["snum" . ($i_1 + 1)];
				//print "\n <hr />it_2 : " . $db_row["snum" . ($i_1 + 1)];

				print_r($comb_items["adj"]["n_0"]);
			
			} else {
			// when prev incr_by != curr incr_by
			
				$incr_by = $c_incr_by;
				if (is_array($comb_items["adj"]["n_" . $incr_by])) {
					// when current incr_by already holds items
				
					$comb_items["adj"]["n_" . $incr_by]["pos"]++;
					$it_1_pos = $comb_items["adj"]["n_" . $incr_by]["pos"];
					
					$comb_items["adj"]["n_" . $incr_by][$it_1_pos] = array();
					$comb_items["adj"]["n_" . $incr_by][$it_1_pos][0] =  $db_row["snum" . $i_1];
					$comb_items["adj"]["n_" . $incr_by][$it_1_pos][1] =  $db_row["snum" . ($i_1 + 1)];
					$comb_items["adj"]["n_" . $incr_by][$it_1_pos]["pos"] = 1;
				} else {
					// when current incr_by is empty
					$comb_items["adj"]["n_" . $incr_by] = array();
					$comb_items["adj"]["n_" . $incr_by][0] = array();
					
					$comb_items["adj"]["n_" . $incr_by][0][0] = $db_row["snum" . $i_1];
					$comb_items["adj"]["n_" . $incr_by][0][1] = $db_row["snum" . ($i_1 + 1)];
					$comb_items["adj"]["n_" . $incr_by][0]["pos"] = 1;
					$comb_items["adj"]["n_" . $incr_by]["pos"] = 0;
			
				
				}
				
				
			}
		} else {
			
			// when incr_by is zero whic means first item and also comb_item is empty
			// have to initialize
			
			$incr_by = $db_row["snum" . ($i_1 + 1)] - $db_row["snum" . $i_1 ];
			$comb_items["adj"]["n_" . $incr_by] = array();
			$comb_items["adj"]["n_" . $incr_by][0] = array();
			
			
			$comb_items["adj"]["n_" . $incr_by][0][0] = $db_row["snum" . $i_1];
			$comb_items["adj"]["n_" . $incr_by][0][1] = $db_row["snum" . ($i_1 + 1)];
			$comb_items["adj"]["n_" . $incr_by][0]["pos"] = 1;
			$comb_items["adj"]["n_" . $incr_by]["pos"] = 0;
			
		}
		
		//print_r($comb_items);
		// normal incr by
				
		$n_incr_by = 0;
		$k_incr_by_match = 0;
		$k_prev_num = 0;
		for ($k_incr_by = $incr_by_min; $k_incr_by <= $incr_by_max; $k_incr_by++) {
			
			$k_cur_incr_val = 0;
			/*
			print "\n<br /> i_1 : " . $i_1;
			print "\n<br /> i_2 : " . $i_2;
			print "\n<br /> k_incr_by: " . $k_incr_by;
			print "\n<hr />";
			 * */
			for ($i_2 = $i_1; $i_2 <= $i_max; $i_2++) {
				$k_c_incr_by = ($db_row["snum" . $i_2] - $db_row["snum" . $i_1]);
				//$k_prev_num = $db_row["snum" . ($i_2 - 1)];
				// get prev incr by by holding onto last matched incre by and subtracting it from current number
				$k_prv_incr_by = ($db_row["snum" . $i_2] - $k_prev_num);
				
				
				if ($k_incr_by == 2 ) {
					
					//print "\n" . $k_incr_by_match . " --- ";
					//print_r($comb_items["n_". $k_incr_by]);
					
					//print "\n k_incr by: " . $k_incr_by . " -- ";
					
					
				}
				
				if (($k_incr_by_match == 1) && ($k_prv_incr_by > $k_incr_by))  {
				// current difference of the two numbers more than incr by
				// which means current continuous of incr_by is broken
					$k_incr_by_match = 0;
					//print "\nk_incr: " . $k_incr_by_match . " - " . $k_incr_by;	
					//print "\n" . $k_prv_incr_by . "\n";
				} elseif ($k_c_incr_by == $k_incr_by || (($db_row["snum" . $i_2] - $k_prev_num ) == $k_incr_by) && ($k_incr_by_match == 1)) {
	
					// current num - prev num matches current increment
					// added it to current array
					
					if (is_array($comb_items["n_" . $k_incr_by])) {
						if (($db_row["snum" . $i_2] - $k_prev_num ) == $k_incr_by) {
							// when situation like
							// incr-by: 2
							// [2][3][4][5][6][16][17][18][19][20]
							//
							$_cur_pos = $comb_items["n_" . $k_incr_by]["pos"];
							$comb_items["n_" . $k_incr_by][$_cur_pos]["pos"]++;
							$_cur_item_pos 	= $comb_items["n_" . $k_incr_by][$_cur_pos]["pos"];
							$comb_items["n_" . $k_incr_by][$_cur_pos][$_cur_item_pos] = $db_row["snum" . $i_2];
													
							
						} else {
							// increment the array position to new one
							$comb_items["n_" . $k_incr_by]["pos"]++;
							$_cur_pos = $comb_items["n_" . $k_incr_by]["pos"];
							$comb_items["n_" . $k_incr_by][$_cur_pos] = array();
							
							$comb_items["n_" . $k_incr_by][$_cur_pos][0] = $db_row["snum" . $i_1];
							$comb_items["n_" . $k_incr_by][$_cur_pos][1] = $db_row["snum" . $i_2];
							$comb_items["n_" . $k_incr_by][$_cur_pos]["pos"] = 1;
							
						}
					} else {
						// current increment by array is empty
						
						$comb_items["n_" . $k_incr_by] = array();
						$comb_items["n_" . $k_incr_by][0] = array();
						$comb_items["n_" . $k_incr_by][0][0] = $db_row["snum" . $i_1];
						$comb_items["n_" . $k_incr_by][0][1] = $db_row["snum" . $i_2];
						$comb_items["n_" . $k_incr_by][0]["pos"] = 1;
						$comb_items["n_" . $k_incr_by]["pos"] = 0;
						
						
					}
					$k_prev_num = $db_row["snum" . $i_2];
					$k_incr_by_match = 1;
					
				
				} 
				
			}
		
		}		
		
	}
	

	return $comb_items;
		
		
}


/*
	st_date -> should be first day of the year
	ed_date -> should be last day of the year

*/

function Generate_Keno_Stats_Wk_Mnthly($the_year) {
	print "\n-- year -- " . $the_year . "-- ";
	$st_date = mktime(0,0,0,1, 1 , $the_year);
	$ed_date = mktime(0,0,0,12, 31, $the_year);
	
	$objGenDates = new GenDates();
	$CombOLGLottery = new CombOLGLottery();
	// weekly stats for the whole year
	
	for ($wk_pos = 1; $wk_pos <= 52; $wk_pos++) {
		
		$the_week_dates = $objGenDates->findWeekDates($wk_pos, $the_year );
		
		$st_wk_date = date('Y-m-d', $the_week_dates[0]);
		$ed_wk_date = date('Y-m-d', $the_week_dates[6]);
		
		//$db_res = $CombOLGLottery->OLGCombKenoOccurIncrCombos($st_wk_date,$ed_wk_date, $st_wk_date, $ed_wk_date);
		$db_res =  $CombOLGLottery->OLGCombKenoOccurDT_ID($st_wk_date, $ed_wk_date);
		// returns data for the whole week
		
		print_r($db_res);
		if (is_array($db_res)) {
			foreach ($db_res as $db_rs) {
				//print "\n --- \n";
				$i_occur_cnt = $db_rs["keno_comb_count"];
				$i_comb_id	 = $db_rs["icomb_id"];
				$i_wk_no 	 = $wk_pos;
				$i_year 	 = $the_year;
				
				print "\n --- \n" . $i_comb_id . " -- " . $i_occur_cnt . " -- wk: " . $i_wk_no . " -- yr: " . $i_year;
				$i_wkly_occur_cnt = $CombOLGLottery->OLGCombKenoStatWklyGetById($i_year, $i_wk_no, $i_comb_id);
				if ( $i_wkly_occur_cnt == null ) {
					$CombOLGLottery->OLGCombKenoStatWklyAddById($i_year, $i_wk_no, $i_comb_id, $i_occur_cnt);
				} else {
					 //if record exists replace with new occur Cnt
					 $CombOLGLottery->OLGCombKenoStatWklySetById($i_year, $i_wk_no, $i_comb_id, $i_occur_cnt);
				}
			
			
			}
			
			
			
		
		}
		
	}
	
	
	// monthly stats for the whole year
	print "\n\n -- Month --";
	for ($mnth_pos = 1; $mnth_pos <= 12; $mnth_pos++) {
		print "\n month Num: " . $mnth_pos;
		$st_month_date = date('Y-m-d', mktime(0,0,0,$mnth_pos, 1, $the_year));
      	$ed_month_date = date('Y-m-d', mktime(0,0,0,$mnth_pos + 1, 0, $the_year));  
		print "\n st mnth: " . $st_month_date . " -- " . $ed_month_date;
		//$db_res = $CombOLGLottery->OLGCombKenoOccurIncrCombos($st_wk_date,$ed_wk_date, $st_wk_date, $ed_wk_date);

		$db_res =  $CombOLGLottery->OLGCombKenoOccurDT_ID($st_month_date, $ed_month_date);
		print "\n --- db_res --";
		print_r($db_res);
		if (is_array($db_res)) {
			foreach ($db_res as $db_rs) {

				$i_occur_cnt = $db_rs["keno_comb_count"];
				$i_comb_id	 = $db_rs["icomb_id"];
				$i_month 	 = $mnth_pos;
				$i_year 	 = $the_year;
				print "\n --- \n" . $i_comb_id . " -- " . $i_occur_cnt . " -- mnth: " . $i_month . " -- yr: " . $i_year;
				
				$i_mnthly_occur_cnt = $CombOLGLottery->OLGCombKenoStatMnthlyGetById($the_year, $i_month, $icomb_id);
				if ($i_mnthly_occur_cnt == null) {
					if ( $i_mnthly_occur_cnt == null ) {
						$CombOLGLottery->OLGCombKenoStatMnthlyAddById($i_year, $i_month, $i_comb_id, $i_occur_cnt);
					} else {
						 //if record exists replace with new occur Cnt
						 $CombOLGLottery->OLGCombKenoStatWklySetById($i_year, $i_month, $i_comb_id, $i_occur_cnt);
					}
				
				}
				
				
			}
			
		}
	
	}

}


function Generate_Keno_Repeats($the_year) {

	print "\n-- year -- " . $the_year . "-- ";
	//$st_drawdate = date('Y-m-d', mktime(0,0,0,1, 1, $the_year));
	//$ed_drawdate = date('Y-m-d', mktime(0,0,0,12, 31, $the_year));
	
	$st_drawdate = date('Y-m-d', mktime(0,0,0,5, 1, 2010));
	$ed_drawdate = date('Y-m-d', mktime(0,0,0,5, 10, 2010));
	

	$objGenDates = new GenDates();
	$CombOLGLottery = new CombOLGLottery();
	
	// Generate Repeats for the year
	
	// loop through each day of the year
	
	
	$db_res = $CombOLGLottery->OLGCombKenoUniqueOccurCombos_2($st_drawdate, $ed_drawdate);
	
	//$db_res = $CombOLGLottery->OLGCombKenoOccurIncrCombos($st_date,$ed_date, $st_date, $ed_date);
	print_r($db_res);
	if (is_array($db_res)) {
		foreach ($db_res as $db_row) {
			//OLGCombKenoOccurById($icomb_keno_id, $st_drawdate, $ed_drawdate, $onlyOccurTable = false)
			$db_comb_res = $CombOLGLottery->OLGCombKenoOccurById($db_row["icomb_keno_id"], $st_drawdate, $ed_drawdate, true);
			
			print_r($db_comb_res);
			$uniq_comb_rs_cnt 	= count($db_comb_res);
			print "\n db_comb_res - contains " . count($db_comb_res) . " elements";
			if (is_array($db_comb_res)) {
				
				
				$comb_rs_rec_cnt	= count($db_comb_res);
				$cur_step_by_cnt	= 0;
				$pre_step_by_cnt	= 0;
				$c_start_comb_date	= null;
				$p_start_comb_date	= null;
				$rec_cnt 			= 0;
				$c_comb_date		= null;
				$p_comb_date		= null;
				$cur_date_diff		= 0;
				$pre_date_diff 		= 0;
				
				
				foreach ($db_comb_res as $db_comb_row) {
					
					$c_comb_date = $db_comb_row["occur_date"];
					
					if ($rec_cnt != 0) {
						$cur_date_diff = $objGenDates->count_days( strtotime($c_comb_date) , strtotime($p_comb_date) ); 
						
						$pre_step_by_count = $cur_step_by_count;
						
							
						if ($rec_cnt == ($comb_rs_rec_cnt - 1)) {
								
							$db_comb_keno = $CombOLGLottery->OLGCombKenoRepeatGet($db_comb_row["icomb_id"], $c_start_comb_date, $cur_date_diff);

							if (!$db_comb_keno) {
							
								$CombOLGLottery->OLGCombKenoRepeatAdd($db_comb_row["icomb_id"],  $c_start_comb_date, $cur_date_diff, $cur_step_by_count);
							
							}
							
						}
							

						
						
						if ($cur_date_diff == $pre_date_diff) {
						
							$cur_step_by_count++;
						
						} else {
						
							
						
							$p_start_comb_date = $c_start_comb_date;
							
							
							// previous continuous step by record
							
							$db_comb_keno = $CombOLGLottery->OLGCombKenoRepeatGet($db_comb_row["icomb_id"], $c_start_comb_date, $pre_date_diff);
							if (!$db_comb_keno) {
							
								$CombOLGLottery->OLGCombKenoRepeatAdd($db_comb_row["icomb_id"],  $c_start_comb_date, $pre_date_diff, $cur_step_by_count);
							}
							// current contiuouus step by record
							
							$c_start_comb_date = $p_comb_date;
							$pre_step_by_cnt = $cur_step_by_cnt;
							$cur_step_by_cnt = 2;
							
							$pre_date_diff = $cur_date_diff;
						
						
						}
						
						// sets the prev date with current date
						
						$p_comb_date = $c_comb_date;
						
						
						
											
					} else {
						$c_start_comb_date 	= $c_comb_date;
						
						$p_comb_date 		= $c_comb_date;
						$cur_step_by_count 	= 1;
					
					}
					
					
					print "\n iRecCNT: " . $rec_cnt . " -- cst_date: " . $c_start_comb_date;
					print "\n c_comb_date : " . $c_comb_date . " -- p comb date : " . $p_comb_date;
					print "\n p_days_diff : " . $pre_date_diff . " -- c_days_diff : " . $c_days_diff;
					print "\n step_by_count : " . $cur_step_by_count . "\n";
					print "\n c_start_date : " . $c_start_comb_date . "\n";
					

					
					
					
					
					$rec_cnt++;

				}
			}
		
		}
	}
	
}
	


				/*
					
					
					
					// dt: 2 , 3, 4, 5, 7, 9, 10
					// frst itr:pos num 2 -- st_dt 2, cur_step_by_cnt  1
					// snd itr:  pos num 3 -- st_dt 2, pr_dt 2, cur_dt 3, c_date_diff = 1, cur_step_by_cnt 2
					// thrd itr: pos num 4 -- st_dt 2, pr_dt 3, cur_dt 4, c_date_diff = 1, pr_date_diff = 1, cur_step_by_cnt 3
					// frth itr: pos num 5 -- st_dt 2, pr_dt 4, cur_dt 5, c_date_diff = 1, pr_date_diff = 1, cur_step_by_cnt 4
					// sxt itr: pos num 7 -- st_dt 2, pr_dt 5, cur_dt 7, c_date_diff = 2, pr_date_diff = 1 , pre_step_by_cnt = 4, cur_step_by_cnt 2
						// ---> store db -> [st_dt: 2 --- pre step_by: 1 -- 4]
						// --> st_dt: 5
					// seven itr: pos num 9 -- st_dt 5, pr_dt 7, cur_dt 9, c_date_diff = 2, pr_date_diff = 2, cur_step_by_cnt 3
					// eight itr: pos num 10 -- st_dt 5, pr_dt, 9, cur_dt 10, c_date_diff = 1, pr_date_diff = 2, pre_step_by_cnt = 3, cur_step_by_cnt 2
					   // ---> stor db -> [st_dt 5 -- pre_step_by: 2 --- pre step cnt: 3]
					// when rec_cnt == ($comb_rs_rec_cnt -1)
					   // ---> stor db -> [st_dt 9 -- pre_step_by: 1 --- 2]
					// 3-2 	= 1 [st_dt: 2 --- step_by: 1 -- 4]
					// 4-3 	= 1   [2, 3, 4, 5]
					// 5-4 	= 1
					// 7-5 	= 2 [st_dt: 5 -- step_by: 2 -- 3]
					// 9-7 	= 2 [5,7, 9]
					// 10-9 = 1 [st_dt: 9 -- step_by: 1 -- 2]
					//			[9,10]
					
					
					
			
					if ($rec_cnt != 0) {
						// 
						
						
						
						$c_days_diff 		= $objGenDates->count_days( strtotime($c_comb_date) , strtotime($p_comb_date) ); 

						if ($rec_cnt != 1) {
							if ($c_days_diff == $p_days_diff) {
								// dt: 2 , 3, 4, 5, 7, 9, 10
								// frst itr:pos num 2 -- st_dt 2, cur_step_by_cnt  1
								// snd itr:  pos num 3 -- st_dt 2, pr_dt 2, cur_dt 3, c_date_diff = 1, cur_step_by_cnt 2
								// thrd itr: pos num 4 -- st_dt 2, pr_dt 3, cur_dt 4, c_date_diff = 1, pr_date_diff = 1, cur_step_by_cnt 3
								// frth itr: pos num 5 -- st_dt 2, pr_dt 4, cur_dt 5, c_date_diff = 1, pr_date_diff = 1, cur_step_by_cnt 4
								// sxt itr: pos num 7 -- st_dt 2, pr_dt 5, cur_dt 7, c_date_diff = 2, pr_date_diff = 1 , pre_step_by_cnt = 4, cur_step_by_cnt 2
								    // ---> store db -> [st_dt: 2 --- pre step_by: 1 -- 4]
								    // --> st_dt: 5
								// seven itr: pos num 9 -- st_dt 5, pr_dt 7, cur_dt 9, c_date_diff = 2, pr_date_diff = 2, cur_step_by_cnt 3
								// eight itr: pos num 10 -- st_dt 5, pr_dt, 9, cur_dt 10, c_date_diff = 1, pr_date_diff = 2, pre_step_by_cnt = 3, cur_step_by_cnt 2
								   // ---> stor db -> [st_dt 5 -- pre_step_by: 2 --- pre step cnt: 3]
								// when rec_cnt == ($comb_rs_rec_cnt -1)
								   // ---> stor db -> [st_dt 9 -- pre_step_by: 1 --- 2]
								// 3-2 	= 1 [st_dt: 2 --- step_by: 1 -- 4]
								// 4-3 	= 1   [2, 3, 4, 5]
								// 5-4 	= 1
								// 7-5 	= 2 [st_dt: 5 -- step_by: 2 -- 3]
								// 9-7 	= 2 [5,7, 9]
								// 10-9 = 1 [st_dt: 9 -- step_by: 1 -- 2]
								//			[9,10]
								$step_by_count++;
							} else {
								// 
						
						
							}
						} else {
							// rec count equals 1 then 
							$p_days_diff = $c_days_diff;
							$step_by_count = 2;
						
						}
						if ($rec_cnt != 1) {
						
						} else {


							print "\n rec_cnt --> 1 --> setting c_days_diff : ". $c_days_diff;							
							$step_by_count = 2;
						}
					
					} else {
						// rec_cnt = 0 means first record in the db recordset
						
						$c_start_comb_date 	= $c_comb_date;
						$p_comb_date 		= $c_comb_date;
						$step_by_count = 1;
						print "\n rec_cnt -> 0 -> setting initial variables";
					}
			
			
					if ($rec_cnt == 0 ) {
					
					} else {
						// set the current days different ... (step by)
						$c_days_diff 		= $objGenDates->count_days( strtotime($c_comb_date) , strtotime($p_comb_date) ); 
						if ($rec_cnt == 1) {
							// second record
							$p_days_diff 	= $c_days_diff;
							$step_by_count++;
						} else {
							// first set is finishing so store the set in the database
							if ((count($db_comb_res) - 1) == $rec_cnt) {
								// end of the array reached so save current combo kenos
								$db_comb_keno = $CombOLGLottery->OLGCombKenoRepeatGet($db_comb_row["icomb_id"], $c_start_comb_date, $c_days_diff);
							} else {
						
								if ($p_days_diff == $c_days_diff) {
									// prev step by and current step by is same
									$step_by_count++;
								} else {
									
									
									
									if (!$db_comb_keno) {
										$CombOLGLottery->OLGCombKenoRepeatAdd($db_comb_row["icomb_id"],  $c_start_comb_date, $p_days_diff, $step_by_count);
									}
									
									// set the new start date
									$c_start_comb_date = $p_comb_date;
									$step_by_count = 0;
								}
							}
						}
					}
					
					
					// set the p_comb_date to c_comb_date if they are not same
					
					if ($p_comb_date != $c_comb_date) {
						$p_comb_date = $c_comb_date;
					}
					
							
					print "\n iRecCNT: " . $rec_cnt . " -- cst_date: " . $s_start_comb_date;
					print "\n c_comb_date : " . $c_comb_date . " -- p comb date : " . $p_comb_date;
					print "\n p_days_diff : " . $p_days_diff . " -- c_days_diff : " . $c_days_diff;
					print "\n step_by_count : " . $step_by_count . "\n";
					ptint "\n c_start_date : " . $c_start_comb_date . "\n";
					
					
					
					*/
				
			// occur_date -- icomb_id -- 
	





?>