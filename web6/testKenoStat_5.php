<?php


$db_row = array();
$db_row["snum1"] = 1;
$db_row["snum2"] = 2;
$db_row["snum3"] = 3;
$db_row["snum4"] = 4;
$db_row["snum5"] = 5;
$db_row["snum6"] = 6;
$db_row["snum7"] = 7;
$db_row["snum8"] = 8;
$db_row["snum9"] = 9;
$db_row["snum10"] = 10;
$db_row["snum11"] = 11;
$db_row["snum12"] = 12;
$db_row["snum13"] = 13;
$db_row["snum14"] = 14;
$db_row["snum15"] = 15;
$db_row["snum16"] = 16;
$db_row["snum17"] = 17;
$db_row["snum18"] = 18;
$db_row["snum19"] = 19;
$db_row["snum20"] = 20;

print_r($db_row);

//1-2-3-4-5-6-7-8-9-10-11-12-13-14-15-16-17-18-19-20

genSingleKenoStat($db_row);


function genSingleKenoStat($db_row) {
	$possible_new_combos = array();
	if (is_array($db_row)) {
	
		
		/*
		print "\n\n\n Starting Second category ";
		for ($i_1 = 1; $i_1 < 21; $i_1++) {
		
					
			for ($i_2 = 1; $i_2 < 21; $i_2++) {
			
				if ($i_1 != $i_2) {
					//num1
					//print $comb_2_cnt . " - ";
					$possible_new_combos[2][$comb_2_cnt] = array($db_row["snum" . $i_1],
																$db_row["snum" . $i_2]
															);


					sort($possible_new_combos[2][$comb_2_cnt],SORT_ASC);
					$possible_new_combos[2][$comb_2_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoGetId (2, 
					$possible_new_combos[2][$comb_2_cnt][0], 
					$possible_new_combos[2][$comb_2_cnt][1]);
					if (!$possible_new_combos[2][$comb_2_cnt]["id"]) {
						$possible_new_combos[2][$comb_2_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoAdd (2, 
						$possible_new_combos[2][$comb_2_cnt][0], 
						$possible_new_combos[2][$comb_2_cnt][1]);
					}
					
					$lc_insertFound = $this->CombOLGLottery->OLGCombKenoStatsGetMatch($possible_new_combos[2][$comb_2_cnt]["id"], $db_row["drawdate"]);
					if (!$lc_insertFound) {
						$this->CombOLGLottery->OLGCombKenoStatsAdd($possible_new_combos[2][$comb_2_cnt]["id"], $db_row["drawdate"], 1);
					}
					
					$comb_2_cnt++;
				}
			}
		
		}
		
		
		//print "<pre>";
		print_r($possible_new_combos[2]);
  		print "\n\n\n Second Category Total Combinations: " . $comb_2_cnt;
		//print "</pre>";
		
	
		print "\n\n\n Starting Third category ";
		$possible_new_combos[3]= array();
		$comb_3_cnt = 0;
		for ($i_1 = 1; $i_1 < 21; $i_1++) {
		
			for ($i_2 = 1; $i_2 < 21; $i_2++) {
				for ($i_3 = 1; $i_3 < 21; $i_3++) {
			
					if (!(
						($i_1 == $i_2) || ($i_2 == $i_3) ||
						($i_1 == $i_3)
						)) {
						//print $comb_3_cnt . " - ";
					
				
						$possible_new_combos[3][$comb_3_cnt] = array($db_row["snum" . $i_1],
																$db_row["snum" . $i_2],
																$db_row["snum" . $i_3]);
						sort($possible_new_combos[3][$comb_3_cnt],SORT_ASC);
																	
						$comb_3_cnt++;
					}
				}
  				
  			}
  		} 
  			print "<pre>";
  			print_r($possible_new_combos[3]);
  		
  			print "</pre>";
  			print "\n\n\n third Category Total Combinations: " . $comb_3_cnt;
  			$total = $comb_2_cnt + $comb_3_cnt ;
			print "\n Total so far: " . $total . "\n";
	
	*/
	 /*
  			print "\n\n\n fourth Category Total Combinations: " . $comb_3_cnt;
  			print "\n\n\n Starting Fourth category ";
  			 
  			$possible_new_combos[4]= array();
  			$comb_4_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  					  	for ($i_4 = 1; $i_4 < 21; $i_4++) {
  				
  							if (!(
  								($i_1 == $i_2) || ($i_1 == $i_3) || ($i_1 == $i_4) ||
  								($i_2 == $i_3) || ($i_2 == $i_4) || ($i_3 == $i_4)
								)){
  						
  								print $comb_4_cnt . " - ";
  					
  								$possible_new_combos[4][$comb_4_cnt] = array($db_row["snum" . $i_1],
  																			$db_row["snum" . $i_2],
  																			$db_row["snum" . $i_3],
  																			$db_row["snum" . $i_4]);
  								sort($possible_new_combos[4][$comb_4_cnt],SORT_ASC);		
  								
  								
								$possible_new_combos[4][$comb_4_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoGetId (4, 
									$possible_new_combos[4][$comb_4_cnt][0], 
									$possible_new_combos[4][$comb_4_cnt][1], 
									$possible_new_combos[4][$comb_4_cnt][2], 
									$possible_new_combos[4][$comb_4_cnt][3]);
								if (!$possible_new_combos[4][$comb_4_cnt]["id"]) {
									$possible_new_combos[4][$comb_4_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoAdd (4, 
									$possible_new_combos[4][$comb_4_cnt][0],
									 $possible_new_combos[4][$comb_4_cnt][1], 
									 $possible_new_combos[4][$comb_4_cnt][2], 
									$possible_new_combos[4][$comb_4_cnt][3]);
								}
							
								$lc_insertFound = $this->CombOLGLottery->OLGCombKenoStatsGetMatch($possible_new_combos[4][$comb_4_cnt]["id"], $db_row["drawdate"]);
								if (!$lc_insertFound) {
									$this->CombOLGLottery->OLGCombKenoStatsAdd($possible_new_combos[4][$comb_4_cnt]["id"], $db_row["drawdate"], 1);
								}
									
  								
  								
  								$comb_4_cnt++;
  							}
  						}
  					}
  				}
  			
  			}
  			
  			print "<pre>";
  			print_r($possible_new_combos[4]);
  		
  			print "</pre>";
  			
  			print "\n\n\n fourth Category Total Combinations: " . $comb_4_cnt;
  			$total += $comb_4_cnt ;
			print "\n Total so far: " . $total . "\n";
			
			*/
			
			
			
  			print "\n\n\n Starting Fifth category ";  			 
  			 
  			  
  			$possible_new_combos[5]= array();
  			$comb_5_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  					  	for ($i_4 = 1; $i_4 < 21; $i_4++) {
							for ($i_5 = 1; $i_5 < 21; $i_5++) {
							
								if (!(
  									($i_1 == $i_2) || ($i_1 == $i_3) || ($i_1 == $i_4) ||
  									($i_2 == $i_3) || ($i_2 == $i_4) || ($i_3 == $i_4) ||
  									($i_1 == $i_5) || ($i_2 == $i_5) || ($i_3 == $i_5) ||
  									($i_4 == $i_5)
									)){
  						
							
							
									print $comb_5_cnt . " - ";
			/*
									$possible_new_combos[5][$comb_5_cnt] = array($db_row["snum" . $i_1],
																			$db_row["snum" . $i_2],
																			$db_row["snum" . $i_3],
																			$db_row["snum" . $i_4],
																			$db_row["snum" . $i_5]
																	);
	
									sort($possible_new_combos[5][$comb_5_cnt],SORT_ASC);
				
								
									$possible_new_combos[5][$comb_5_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoGetId (5, 
										$possible_new_combos[5][$comb_5_cnt][0], 
										$possible_new_combos[5][$comb_5_cnt][1], 
										$possible_new_combos[5][$comb_5_cnt][2], 
										$possible_new_combos[5][$comb_5_cnt][3], 
										$possible_new_combos[5][$comb_5_cnt][4]);
										if (!$possible_new_combos[5][$comb_5_cnt]["id"]) {
											$possible_new_combos[5][$comb_5_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoAdd (5, 
											$possible_new_combos[5][$comb_5_cnt][0],
											$possible_new_combos[5][$comb_5_cnt][1], 
											$possible_new_combos[5][$comb_5_cnt][2], 
											$possible_new_combos[5][$comb_5_cnt][3], 
											$possible_new_combos[5][$comb_5_cnt][4]);
										}			
												
								  	$lc_insertFound = $this->CombOLGLottery->OLGCombKenoStatsGetMatch($possible_new_combos[5][$comb_5_cnt]["id"], $db_row["drawdate"]);
								  	if (!$lc_insertFound) {
											$this->CombOLGLottery->OLGCombKenoStatsAdd($possible_new_combos[5][$comb_5_cnt]["id"], $db_row["drawdate"], 1);
								  	}
								  	*/
																				
																										
									$comb_5_cnt++;
								}
							}
  						}
  					}
  				}
  			
  			}
  			print "<pre>";
  			//print_r($possible_new_combos[5]);
  		
  			print "</pre>";
	
  			print "\n\n\n fifth Category Total Combinations: " . $comb_5_cnt;
	
	
	}


}



  

?>