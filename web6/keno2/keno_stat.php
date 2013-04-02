

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

/*
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
	
  		
  	
	


}



  

?>




