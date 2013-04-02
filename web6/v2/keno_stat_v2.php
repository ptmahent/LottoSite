<?php

include_once("inc2/incStatGen.php");
include_once("inc2/incLottery.php");

include_once("inc2/incCombOLGLottery.php");
include_once("inc2/class_db.php");

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

*/


function keno_stat_gen_increment($db_row) {


	$comb_items = array();
	
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
	for ($i_1 = $i_min; $i_1 <= $i_max; $i_1++) 
	{
		$comb_items["adj"] = array();
		// check if cur item eq next item + incr_by
		if ($incr_by != 0) {
			
			$c_incr_by = $db_row["snum" . $i_1] - $db_row["snum" . ($i_1 + 1)];
			// if prev incr_by == current incr_by
			if ($incr_by == $c_incr_by) {
				$it_1_pos = $comb_items["adj"]["n_" . $incr_by]["pos"];
				$it_2_pos = $comb_items["adj"]["n_" . $incr_by][$it_1_pos]["pos"];
				
				$comb_items["adj"]["n_" . $incr_by][$it_1_pos][$it_2_pos] = $db_row["snum" . ($i_1 + 1)];
				
				$comb_items["adj"]["n_" . $incr_by][$it_1_pos]["pos"]++;
				
			
			} else {
			// when prev incr_by != curr incr_by
			
				$incr_by = $c_incr_by;
				if (is_array($comb_items["adj"]["n_" . $incr_by])) {
					// when current incr_by already holds items
				
					$it_1_pos = $comb_items["adj"]["n_" . $incr_by]["pos"];
				
					$comb_items["adj"]["n_" . $incr_by][$it_1_pos] = array();
					$comb_items["adj"]["n_" . $incr_by][$it_1_pos][0] =  $db_row["snum" . $i_1];
					$comb_items["adj"]["n_" . $incr_by][$it_1_pos][1] =  $db_row["snum" . ($i_1 + 1)];
					$comb_items["adj"]["n_" . $incr_by][$it_1_pos]["pos"] = 2;
				} else {
					// when current incr_by is empty
					$comb_items["adj"]["n_" . $incr_by] = array();
					$comb_items["adj"]["n_" . $incr_by][0] = array();
					
					$comb_items["adj"]["n_" . $incr_by][0][0] = $db_row["snum" . $i_1];
					$comb_items["adj"]["n_" . $incr_by][0][1] = $db_row["snum" . ($i_1 + 1)];
					$comb_items["adj"]["n_" . $incr_by][0]["pos"] = 2;
					$comb_items["adj"]["n_" . $incr_by]["pos"] = 1;
			
				
				}
				
				
			}
		} else {
			
			// when incr_by is zero whic means first item and also comb_item is empty
			// have to initialize
			
			$incr_by = $db_row["snum" . $i_1] - $db_row["snum" . ($i_1 + 1)];
			$comb_items["adj"]["n_" . $incr_by] = array();
			$comb_items["adj"]["n_" . $incr_by][0] = array();
			
			
			$comb_items["adj"]["n_" . $incr_by][0][0] = $db_row["snum" . $i_1];
			$comb_items["adj"]["n_" . $incr_by][0][1] = $db_row["snum" . ($i_1 + 1)];
			$comb_items["adj"]["n_" . $incr_by][0]["pos"] = 2;
			$comb_items["adj"]["n_" . $incr_by]["pos"] = 1;
			
		}
		
		
		// normal incr by
		
		$n_incr_by = 0;
		
		for ($k_incr_by = $incr_by_min; $k_incr_by <= $incr_by_max; $k_incr_by++) {
			$k_incr_by_match = 0;
			for ($i_2 = $i_1; $i_2 <= $i_max; $i_2++) {
				
				if (($db_row["snum" . $i_2] - $db_row["snum" . $i_1]) == $k_incr_by) {
					$k_incr_by_match = 1;
					
					
					
				}
				
				
			}
		
		}
		for ($i_2 = $i_1; $i_2 <= $i_max; $i_2++) {
		
			//
			// 
			//
			//
			//
			//
			for ($k_incr_by = $incr_by_min; $k_incr_by <= $incr_by_max; $k_incr_by++) {
			
				$comb_items["n_" . $k_incr_by] = array();
				$comb_items["n_" . $k_incr_by][0] = array();
			
				
			}
		
		
		}
		
		
	}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$incr_by = $db_row["snum" . $i_1] - $db_row["snum" . ($i_1 + 1)];
		for ($incr_num = $incr_by_min; $incr_num <= $incr_by_max; $incr_num++) {
		
		
		
		
			if ($db_row["snum" . $i_1] == ($db_row["snum" . $i_1] + $incr_num)) {
				
				if (is_array($comb_items["adj"]["n_" . $incr_num])) {
					$comb_items["adj"]["n_" . $incr_num] = array();
					
					$comb_items["adj"]["n_" . $incr_num][0] = $db_row["snum" . $i_1];
					$comb_items["adj"]["n_" . $incr_num][1] = $db_row["snum" . ($i_1 + 1)];
					$comb_items["adj"]["n_" . $incr_num]["pos"] = 1;
				} else {
					$comb_items["adj"]["n_" . $incr_num][$comb_items["adj"]["n_" . $incr_num]["pos"] + 1] = $db_row["snum" . ($i_1 + 1)];
				
				}
				
				
				$comb_items["adj"]["pos"]++;
			
			
			}
		
		
		}

	
	}




}






?>