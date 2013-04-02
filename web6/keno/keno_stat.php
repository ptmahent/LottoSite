<?php

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


function generateSingleKeno() {

	$num_incr = array();
	$num_incr[1] = array();
	$num_incr[1]["cur_pos"] = 0;
	$num_incr[1]["ar_item_pos"] = 0;
	$num_incr[2] = array();
	$num_incr[2]["cur_pos"] = 0;
	$num_incr[2]["ar_item_pos"] = 0;
	$num_incr[3] = array();
	$num_incr[3]["cur_pos"] = 0;
	$num_incr[3]["ar_item_pos"] = 0;
	
	$num_incr[4] = array();
	$num_incr[4]["cur_pos"] = 0;
	$num_incr[4]["ar_item_pos"] = 0;
	
	$num_incr[5] = array();
	$num_incr[5]["cur_pos"] = 0;
	$num_incr[5]["ar_item_pos"] = 0;
	
	$num_incr[6] = array();
	$num_incr[6]["cur_pos"] = 0;
	$num_incr[6]["ar_item_pos"] = 0;
	
	$num_incr[7] = array();
	$num_incr[7]["cur_pos"] = 0;
	$num_incr[7]["ar_item_pos"] = 0;
	
	$num_incr[8] = array();
	$num_incr[8]["cur_pos"] = 0;
	$num_incr[8]["ar_item_pos"] = 0;

	$num_incr[9] = array();
	$num_incr[9]["cur_pos"] = 0;
	$num_incr[9]["ar_item_pos"] = 0;
	
	$num_incr[10] = array();

	$num_incr[10]["cur_pos"] = 0;
	$num_incr[10]["ar_item_pos"] = 0;
	
	
	/*
	
	2-3-5-6-7-8-9-11-15-17-19-21-27-30-33-36-45-50-56  
	
	
	cons_items[1]
		->cur_pos
		->ar_item_pos
		
		[0][0]  -> 2
		[0][1]  -> 3
		
		[1][0]  -> 5 
		[1][0]  -> 6 
		[1][0]  -> 7 
		[1][0]  -> 8 
		[1][0]  -> 9 
		
	
	cons_items[2]
		->cur_pos
		->ar_item_pos
		
		[0][0] -> 3
		[0][1] -> 5
		[0][2] -> 7
		[0][3] -> 9
		[0][4] -> 11
		
		[1][0] -> 15
		[1][0] -> 17
		[1][0] -> 19
		[1][0] -> 21
		
	
	
	cons_items[3]
		->cur_pos
		->ar_item_pos
		
		[0][0] -> 2
		[0][1] -> 5
		[0][2] -> 8
		[0][3] -> 11		
		
		
		[1][0] -> 27
		[1][1] -> 30
		[1][2] -> 33
		[1][0] -> 36
		
		
	cons_items[4]
		->cur_pos
		->ar_item_pos
		
		[0][0] -> 2
		[0][1] -> 6
		
		
		[1][0] -> 3
		[1][1] -> 7
		[1][2] -> 11
		[1][3] -> 15
		[1][0] -> 19		
		
		[2]
		
		[3]
		
		[4]
	
	cons_items[5]
		->cur_pos
		->ar_item_pos
		
		[0][0] = 2
		[0][1] = 7
	

		[1][0] = 3
		[1][1] = 8

		
		[2][0] = 6
		[2][1] = 11
		
		[3][0] = 45
		[3][1] = 50

		
	
	cons_items[6]
		->cur_pos
		->ar_item_pos
		[0][0] -> 2
		[0][1] -> 8
		
		[1][0] -> 3
		[1][1] -> 9
		[1][2] -> 15
		[1][3] -> 21
		[1][4] -> 27
		[1][5] -> 33
	*/
	
	
	$cons_items = array();
	
	
	// Max Increment Var
	$max_incr_var = 15;
	$min_incr_var = 1;
	
	for ($c_i_1 = $min_incr_var; $c_i_1 < $max_incr_var; $c_i_1++) {
	
		$cons_items[$c_i_1] = array();
		$cons_items[$c_i_1]["cur_pos"] = 0;
		$cons_items[$c_i_1]["ar_item_pos"] = 0;
		
		
		$cur_i_pos = 0;
		for ($i_2 = 1; $i_2 < 21; $i_2++) {
			
			$still_1 = 1;
			$cons_items[$c_i_1]["ar_sub_item_pos"] = 0;
			do {
				
				$cons_items[$c_i_1]["cur_pos"]++;
				
				if ($db_row["snum" . $cons_items[$c_i_1]["cur_pos"]] == ($db_row["snum" . ($cons_items[$c_i_1]["cur_pos"] + 1)] - $c_i_1)) {
				
					if (is_array($cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"]])) {
						$cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"] - 1][$cons_items[$c_i_1]["ar_sub_item_pos"]] = $db_row["snum" . $cons_items[$c_i_1]["cur_pos"] + 1];
						
					} else {
						$cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"]] = array();
						
						$cons_items[$c_i_1]["ar_item_pos"]++;
						$cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"] - 1][0] = $db_row["snum" . $cons_items[$c_i_1]["cur_pos"]];
						$cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"] - 1][1] = $db_row["snum" . $cons_items[$c_i_1]["cur_pos"] + 1];					
						
						$cons_items[$c_i_1]["ar_sub_item_pos"] = 2;
					}
				
				}
			
			
			
			} while ($still_1 == 1);
		
		}
	
	
	}
	
	
	$cons_items = array();
	
	for ($c_i_1 = 1; $c_i_1 < 15; $c_i_1++) {
  		$cons_items[$c_i_1] = array();
  		$cons_items[$c_i_1]["cur_pos"] = 0;
  		$cons_items[$c_i_1]["ar_item_pos"] = 0;

  		
		for ($i_2 = 1; $i_2 < 21; $i_2++) {
  				
  				
  			$cons_items[$c_i_1]["ar_sub_item"] = 0;
  			do {
  			
  				$still_1 = 1;
  				
  				$cons_items[$c_i_1]["cur_pos"]++;
  				// snum == ([snum + 1] - 1)
  				if ($db_row["snum" . $cons_items[$c_i_1]["cur_pos"]] == ($db_row["snum" .  ($cons_items[$c_i_1]["cur_pos"] + 1)] - $c_i_1 )) {
  					// is_array -- means 
  					if (is_array($cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"]]) {
  						$cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"] - 1][$cons_items[$c_i_1]["ar_sub_item"]] = $db_row["snum" . ($cons_items[$c_i_1]["cur_pos"] + 1)];
  						$cons_items[$c_i_1]["ar_sub_item"]++;
  					} else {
  						$cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"]] = array();
  						
  						$cons_items[$c_i_1]["ar_item_pos"]++;
  						$cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"] - 1][0] = $db_row["snum" . $cons_items[$c_i_1]["cur_pos"]];
  						$cons_items[$c_i_1][$cons_items[$c_i_1]["ar_item_pos"] - 1][1] = $db_row["snum" . $cons_items[$c_i_1]["cur_pos"] + 1];
  						$cons_items[$c_i_1]["ar_sub_item"] = 1;
   					}
  					
  					
  				} else {
  				
  				}
  			
  			
  			} while ($still_1 == 1);
  			
  			
  		}
  			
  			
  			
  	}
	
	
	

	for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  			
  		// if cons numbers incr by one add it to this array
  		$curr_incr_by = 1;
  		if ($i_1 > $num_incr[1]["cur_pos"]) {
  			do {
  				$still_1 = 1;
  				$num_incr[$curr_incr_by]["cur_pos"]++;
  			
  				if ($db_row["snum" . $num_incr[$curr_incr_by]["cur_pos"]] == ($db_row["snum" . ($num_incr[$curr_incr_by]["cur_pos"] + 1)] + $curr_incr_by)) {
  				// 
  					$num_incr[$curr_incr_by][$num_incr[$curr_incr_by]["ar_item_pos"]] = array();
  					$num_incr[$curr_incr_by][$num_incr[$curr_incr_by]["ar_item_pos"]][0] = $db_row["snum" . $num_incr[$curr_incr_by]["cur_pos"]];
  					$num_incr[$curr_incr_by][$num_incr[$curr_incr_by]["ar_item_pos"]][1] = $db_row["snum" . $num_incr[$curr_incr_by]["cur_pos"]+1];
  					$intr_cntr = 1;
  				
  					do {
  						$still_1_2 = 1;
  					
  						if ($db_row["snum" . ($num_incr[$curr_incr_by]["cur_pos"] + $intr_cntr)] == 	($db_row["snum" . ($num_incr[$curr_incr_by]["cur_pos"] + $intr_cntr + 1)] ) {
  							$num_incr[$curr_incr_by][$num_incr[$curr_incr_by]["ar_item_pos"]][$num_incr[$curr_incr_by]["cur_pos"] + $intr_cntr ];
  							
  							$intr_cntr++;
  						
  						
  					
  						} else {
  							$still_1_2 = 0;
  							$num_incr[1]["cur_pos"] = $num_incr[1]["cur_pos"] + $intr_cntr;
   						}
  				
  				
  				
  				
  					} while ($still_1_2 == 1);
  					$num_incr[1]["ar_item_pos"]++;
  				} else {
  					$still_1 = 0;
  				}
  			
  			
  			
  		
  				} while ($still_1 == 1);
  		
  			}
  		
  		// in cons numbers incr by two add it to this array
  		$curr_incr_by = 2;
  		  if ($i_1 > $num_incr[2]["cur_pos"]) {
  			do {
  				$still_2 = 1;
  				$num_incr[2]["cur_pos"]++;
  			
  				if ($db_row["snum" . $num_incr[2]["cur_pos"]] == ($db_row["snum" . ($num_incr[2]["cur_pos"] + 2)] ) {
  				// 
  					$num_incr[2][$num_incr[2]["ar_item_pos"]] = array();
  					$num_incr[2][$num_incr[2]["ar_item_pos"]][0] = $db_row["snum" . $num_incr[2]["cur_pos"]];
  					$num_incr[2][$num_incr[2]["ar_item_pos"]][1] = $db_row["snum" . $num_incr[2]["cur_pos"]+1];
  					$intr_cntr = 2;
  				
  					do {
  						$still_2_2 = 1;
  					
  						if ($db_row["snum" . ($num_incr[2]["cur_pos"] + $intr_cntr)] == 	($db_row["snum" . ($num_incr[2]["cur_pos"] + $intr_cntr + 2)] ) {
  							$num_incr[2][$num_incr[2]["ar_item_pos"]][$num_incr[2]["cur_pos"] + $intr_cntr ];
  							
  							$intr_cntr++;
  						
  						
  					
  						} else {
  							$still_2_2 = 0;
  							$num_incr[2]["cur_pos"] = $num_incr[2]["cur_pos"] + $intr_cntr;
   						}
  				
  				
  				
  				
  					} while ($still_2_2 == 1);
  					$num_incr[2]["ar_item_pos"]++;
  				} else {
  					$still_2 = 0;
  				}
  			
  			
  			
  		
  				} while ($still_2 == 1);
  		
  			}
  		
  		
  		
  		
  		// in cons numbers incr by three add it to this array
  		$curr_incr_by = 3;
  		  if ($i_1 > $num_incr[3]["cur_pos"]) {
  			do {
  				$still_3 = 1;
  				$num_incr[3]["cur_pos"]++;
  			
  				if ($db_row["snum" . $num_incr[3]["cur_pos"]] == ($db_row["snum" . ($num_incr[3]["cur_pos"] + 3)] ) {
  				// 
  					$num_incr[3][$num_incr[3]["ar_item_pos"]] = array();
  					$num_incr[3][$num_incr[3]["ar_item_pos"]][0] = $db_row["snum" . $num_incr[3]["cur_pos"]];
  					$num_incr[3][$num_incr[3]["ar_item_pos"]][1] = $db_row["snum" . $num_incr[3]["cur_pos"]+2];
  					$intr_cntr = 3;
  				
  					do {
  						$still_3_2 = 1;
  					
  						if ($db_row["snum" . ($num_incr[3]["cur_pos"] + $intr_cntr)] == 	($db_row["snum" . ($num_incr[3]["cur_pos"] + $intr_cntr + 3)] ) {
  							$num_incr[3][$num_incr[3]["ar_item_pos"]][$num_incr[3]["cur_pos"] + $intr_cntr ];
  							
  							$intr_cntr++;
  						
  						
  					
  						} else {
  							$still_3_2 = 0;
  							$num_incr[3]["cur_pos"] = $num_incr[3]["cur_pos"] + $intr_cntr;
   						}
  				
  				
  				
  				
  					} while ($still_3_2 == 1);
  					$num_incr[3]["ar_item_pos"]++;
  				} else {
  					$still_3 = 0;
  				}
  			
  			
  			
  		
  				} while ($still_3 == 1);
  		
  			}
  			
  		
  		
  		
  		// in cons numbers incr by four add it to this array
  		$curr_incr_by = 4;
  		  		
  		  if ($i_1 > $num_incr[4]["cur_pos"]) {
  			do {
  				$still_4 = 1;
  				$num_incr[4]["cur_pos"]++;
  			
  				if ($db_row["snum" . $num_incr[4]["cur_pos"]] == ($db_row["snum" . ($num_incr[4]["cur_pos"] + 4)] ) {
  				// 
  					$num_incr[4][$num_incr[4]["ar_item_pos"]] = array();
  					$num_incr[4][$num_incr[4]["ar_item_pos"]][0] = $db_row["snum" . $num_incr[4]["cur_pos"]];
  					$num_incr[4][$num_incr[4]["ar_item_pos"]][1] = $db_row["snum" . $num_incr[4]["cur_pos"]+2];
  					$intr_cntr = 4;
  				
  					do {
  						$still_4_2 = 1;
  					
  						if ($db_row["snum" . ($num_incr[4]["cur_pos"] + $intr_cntr)] == 	($db_row["snum" . ($num_incr[4]["cur_pos"] + $intr_cntr + 3)] ) {
  							$num_incr[4][$num_incr[4]["ar_item_pos"]][$num_incr[4]["cur_pos"] + $intr_cntr ];
  							
  							$intr_cntr++;
  						
  						
  					
  						} else {
  							$still_4_2 = 0;
  							$num_incr[4]["cur_pos"] = $num_incr[4]["cur_pos"] + $intr_cntr;
   						}
  				
  				
  				
  				
  					} while ($still_4_2 == 1);
  					$num_incr[4]["ar_item_pos"]++;
  				} else {
  					$still_4 = 0;
  				}
  			
  			
  			
  		
  				} while ($still_4 == 1);
  		
  			}
  			
  		
  		
  		
  		// in cons numbers incr by five add it to this array
  		$curr_incr_by = 5;  		
  		  if ($i_1 > $num_incr[5]["cur_pos"]) {
  			do {
  				$still_5 = 1;
  				$num_incr[5]["cur_pos"]++;
  			
  				if ($db_row["snum" . $num_incr[5]["cur_pos"]] == ($db_row["snum" . ($num_incr[5]["cur_pos"] + 3)] ) {
  				// 
  					$num_incr[5][$num_incr[5]["ar_item_pos"]] = array();
  					$num_incr[5][$num_incr[5]["ar_item_pos"]][0] = $db_row["snum" . $num_incr[5]["cur_pos"]];
  					$num_incr[5][$num_incr[5]["ar_item_pos"]][1] = $db_row["snum" . $num_incr[5]["cur_pos"]+2];
  					$intr_cntr = 1;
  				
  					do {
  						$still_5_2 = 1;
  					
  						if ($db_row["snum" . ($num_incr[5]["cur_pos"] + $intr_cntr)] == 	($db_row["snum" . ($num_incr[5]["cur_pos"] + $intr_cntr + 1)] ) {
  							$num_incr[5][$num_incr[5]["ar_item_pos"]][$num_incr[5]["cur_pos"] + $intr_cntr ];
  							
  							$intr_cntr++;
  						
  						
  					
  						} else {
  							$still_5_2 = 0;
  							$num_incr[5]["cur_pos"] = $num_incr[5]["cur_pos"] + $intr_cntr;
   						}
  				
  				
  				
  				
  					} while ($still_5_2 == 1);
  					$num_incr[5]["ar_item_pos"]++;
  				} else {
  					$still_5 = 0;
  				}
  			
  			
  			
  		
  				} while ($still_5 == 1);
  		
  			}
  			
  		// in cons numbers incr by six add it to this array
  		$curr_incr_by = 6;
  		
  		if ($i_1 > $num_incr[6]["cur_pos"]) {
  			do {
  				$still_6 = 1;
  				$num_incr[6]["cur_pos"]++;
  			
  				if ($db_row["snum" . $num_incr[6]["cur_pos"]] == ($db_row["snum" . ($num_incr[6]["cur_pos"] + 1)] ) {
  				// 
  					$num_incr[6][$num_incr[6]["ar_item_pos"]] = array();
  					$num_incr[6][$num_incr[6]["ar_item_pos"]][0] = $db_row["snum" . $num_incr[6]["cur_pos"]];
  					$num_incr[6][$num_incr[6]["ar_item_pos"]][1] = $db_row["snum" . $num_incr[6]["cur_pos"]+1];
  					$intr_cntr = 1;
  				
  					do {
  						$still_6_2 = 1;
  					
  						if ($db_row["snum" . ($num_incr[6]["cur_pos"] + $intr_cntr)] == 	($db_row["snum" . ($num_incr[6]["cur_pos"] + $intr_cntr + 1)] ) {
  							$num_incr[6][$num_incr[1]["ar_item_pos"]][$num_incr[6]["cur_pos"] + $intr_cntr ];
  							
  							$intr_cntr++;
  						
  						
  					
  						} else {
  							$still_6_2 = 0;
  							$num_incr[6]["cur_pos"] = $num_incr[6]["cur_pos"] + $intr_cntr;
   						}
  				
  				
  				
  				
  					} while ($still_6_2 == 1);
  					$num_incr[6]["ar_item_pos"]++;
  				} else {
  					$still_6 = 0;
  				}
  			
  			
  			
  		
  				} while ($still_6 == 1);
  		
  			}
  		
  		
  		
  		
  		
  		// in cons numbers incr by seven add it to this array
  		
  		
  		// in cons numbers incr by eight add it to this array
  		
  		
  		// in cons numbers incr by nine add it to this array
  		
  		
  		// in cons numbers incr by ten add it to this array
  		
  		
  		
  		$db_row["snum" . $i_1];
  		for ($i_2 = 1; $i_2 < 21; $i_2++) {
  			for ($i_3 = 1; $i_3 < 21; $i_3++) {
  				for ($i_4 = 1; $i_4 < 21; $i_4++) {
  					  	
  					  	
  				}
  			}
  		}
  	}

}



genSingleKenoStat($db_row);


function genSingleKenoStat($db_row) {
	$possible_new_combos = array();
	if (is_array($db_row)) {
	
		$possible_new_combos[2]= array();
		$comb_2_cnt = 0;
		
		$comb_2_cnt = 0;
		
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
  								
  								/*
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
									
  								*/
  								
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
	
	
	
	}


}



  

?>




?>