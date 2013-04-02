<?php


include_once("inc2/class_db.php");
include_once("inc2/execution_time.php");
include_once("inc2/incOLGLottery.php");
include_once("inc2/incCombOLGLottery.php");


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

*/
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

/*
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
print_r($db_row);
keno_stat_gen_increment($db_row);

$OLGLottery = new OLGLottery();
$CombOLGLottery = new CombOLGLottery();

for ($i = 0; $i < 2; $i++ ) {
	
	$comb_items = keno_stat_gen_increment($db_set[$i]);
	
	
	foreach ($comb_items as $comb_it_name => $comb_it_val) {
		
		if ($comb_it_name == "adj") {
			
			//print $comb_it_name . "\n";
			foreach ($comb_it_val as $adj_comb_it_name => $adj_comb_it_val) {
				print "\nADJ - " . $adj_comb_it_name . "\n";
				//print_r($adj_comb_it_val);
				print "\n";
				$_incr_ = explode("_",$adj_comb_it_name);
				$_incr_ = $_incr_[1];
				
				print "\n incr - : " . $_incr_;
				//print_r($adj_comb_it_val);
				print "\n pos 1 -> " . $adj_comb_it_val["pos"] . " -- pos 2 - " . $adj_comb_it_val[0]["pos"];
		
				foreach ($adj_comb_it_val as $__adj_comb_id => $__adj_comb_it_val) {
					if ($_incr_ == 0) {
						// Add all 20 numbers to combination table
						$_i_cat = 20;
						$comb_draw_date = date('Y-m-d',strtotime($db_row["drawdate"]));
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15], $__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18], $__adj_comb_it_val[19]);
						if (!$i_comb_keno_id) {
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15],$__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18], $__adj_comb_it_val[19]);
						}
						// add all 20 combination id to occur table
						// Add comb keno id to occur table for the specific date
						if (!$i_comb_keno_id) {

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
						
						
							$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId($_i_cat, $_incr_, $__adj_comb_it_val[$_x_1]);
							if (!$i_comb_keno_id) {
								$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[$_x_1]);
							}
							// Add comb keno id to occur table for the specific date
							if (!$i_comb_keno_id) {
								$c_k_occur = $CombOLGLottery->OLGCombKenoOccurGet($i_comb_keno_id, $comb_draw_date);
								if ($c_k_occur == null) {
									$CombOLGLottery->OLGCombKenoOccurAdd($i_comb_keno_id, $comb_draw_date, 0);
								} 
							
							}
						}
					
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
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1]);
									}
									print "\n N1: " . $__adj_comb_it_val[0];
									print "\n N2: " . $__adj_comb_it_val[1];
									break;
								case 3:
								
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2]);
									}
								
								
								
									print "\n N1: " . $__adj_comb_it_val[0];
									print "\n N2: " . $__adj_comb_it_val[1];
									print "\n N3: " . $__adj_comb_it_val[2];
															
									break;
		
								case 4:
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3]);
									}
								
								
								
									print "\n N1: " . $__adj_comb_it_val[0];
									print "\n N2: " . $__adj_comb_it_val[1];
									print "\n N3: " . $__adj_comb_it_val[2];						
									print "\n N4: " . $__adj_comb_it_val[3];	
									break;
							
								case 5:
								
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4]);
									}
								
								
									print "\n N1: " . $__adj_comb_it_val[0];
									print "\n N2: " . $__adj_comb_it_val[1];
									print "\n N3: " . $__adj_comb_it_val[2];						
									print "\n N4: " . $__adj_comb_it_val[3];	
									print "\n N5: " . $__adj_comb_it_val[4];	
								
									break;
									
								case 6:
								
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5]);
									}
								
								
								
								
									print "\n N1: " . $__adj_comb_it_val[0];
									print "\n N2: " . $__adj_comb_it_val[1];
									print "\n N3: " . $__adj_comb_it_val[2];						
									print "\n N4: " . $__adj_comb_it_val[3];	
									print "\n N5: " . $__adj_comb_it_val[4];
									print "\n N6: " . $__adj_comb_it_val[5];							
									break;
							
								case 7:
								
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6]);
									}
								
									print "\n N1: " . $__adj_comb_it_val[0];
									print "\n N2: " . $__adj_comb_it_val[1];
									print "\n N3: " . $__adj_comb_it_val[2];						
									print "\n N4: " . $__adj_comb_it_val[3];	
									print "\n N5: " . $__adj_comb_it_val[4];
									print "\n N6: " . $__adj_comb_it_val[5];							
									print "\n N7: " . $__adj_comb_it_val[6];								
									break;
								case 8:
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7]);
									}
								
								
								
								
									print "\n N1: " . $__adj_comb_it_val[0];
									print "\n N2: " . $__adj_comb_it_val[1];
									print "\n N3: " . $__adj_comb_it_val[2];						
									print "\n N4: " . $__adj_comb_it_val[3];	
									print "\n N5: " . $__adj_comb_it_val[4];
									print "\n N6: " . $__adj_comb_it_val[5];							
									print "\n N7: " . $__adj_comb_it_val[6];	
									print "\n N8: " . $__adj_comb_it_val[7];								
									break;
							
								case 9:
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8]);
									}
								
								
									print "\n N1: " . $__adj_comb_it_val[0];
									print "\n N2: " . $__adj_comb_it_val[1];
									print "\n N3: " . $__adj_comb_it_val[2];						
									print "\n N4: " . $__adj_comb_it_val[3];	
									print "\n N5: " . $__adj_comb_it_val[4];
									print "\n N6: " . $__adj_comb_it_val[5];							
									print "\n N7: " . $__adj_comb_it_val[6];	
									print "\n N8: " . $__adj_comb_it_val[7];
									print "\n N9: " . $__adj_comb_it_val[8];
								
									break;
								
								case 10:
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9] );
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9]);
									}
								
								
								
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
									break;
							
								case 11:
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10] );
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10]);
									}
								
								
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
									break;
								case 12:
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11]  );
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] );
									}
								
								
								
								
								
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
									break;
							
								case 13:
								
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  );
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12]  );
									}
								
								
								
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
									break;
								
								case 14:
								
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13] );
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  );
									}
								
								
								
								
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
									
									break;
							
								case 15:
								
								
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14] );
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14]);
									}
								
								
								
								
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
									break;
								case 16:
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15] );
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15]);
									}
								
								
								
							
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
									break;
							
								case 17:
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15], $__adj_comb_it_val[16]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15],$__adj_comb_it_val[16]);
									}
								
								
								
								
								
								
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
									
									
									break;
								case 18:
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15], $__adj_comb_it_val[16], $__adj_comb_it_val[17]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15],$__adj_comb_it_val[16], $__adj_comb_it_val[17]);
									}
								
								
								
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
									
									break;
							
								case 19:
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15], $__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15],$__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18]);
									}
								
								
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
									
									break;
								case 20:
								
								
									$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11] , $__adj_comb_it_val[12]  , $__adj_comb_it_val[13], $__adj_comb_it_val[14], $__adj_comb_it_val[15], $__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18], $__adj_comb_it_val[19]);
									if (!$i_comb_keno_id) {
										$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $__adj_comb_it_val[0], $__adj_comb_it_val[1], $__adj_comb_it_val[2], $__adj_comb_it_val[3], $__adj_comb_it_val[4], $__adj_comb_it_val[5], $__adj_comb_it_val[6], $__adj_comb_it_val[7], $__adj_comb_it_val[8], $__adj_comb_it_val[9], $__adj_comb_it_val[10], $__adj_comb_it_val[11], $__adj_comb_it_val[12] , $__adj_comb_it_val[13]  , $__adj_comb_it_val[14], $__adj_comb_it_val[15],$__adj_comb_it_val[16], $__adj_comb_it_val[17], $__adj_comb_it_val[18], $__adj_comb_it_val[19]);
									}
								
								
								
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
									
									break;
							
		
								
							}
							// add combination to database for occured table database
							if (!$i_comb_keno_id) {
								$comb_draw_date = date('Y-m-d',strtotime($db_row["drawdate"]));
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
			print "\n Normal - " . $comb_it_name . "\n";
			//print_r($comb_it_val); 
			print "\n";
			foreach ($comb_it_val as $_comb_it_name => $_comb_it_val) {
				//print_r($_comb_it_val);
				print "\nNormal - " . _comb_it_name . "\n";
				//print_r($_comb_it_val);
				print "\n";
				$_incr_ = explode("_",$_comb_it_name);
				$_incr_ = $_incr_[1];
				
				
				
				$_i_cat = $_comb_it_val["pos"] + 1;
				switch ($_i_cat)
				{
				case 2:
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1]);
					}
					print "\n N1: " . $_comb_it_val[0];
					print "\n N2: " . $_comb_it_val[1];
					break;
				case 3:
				
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2]);
					}
				
				
				
					print "\n N1: " . $_comb_it_val[0];
					print "\n N2: " . $_comb_it_val[1];
					print "\n N3: " . $_comb_it_val[2];
											
					break;

				case 4:
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3]);
					}
				
				
				
					print "\n N1: " . $_comb_it_val[0];
					print "\n N2: " . $_comb_it_val[1];
					print "\n N3: " . $_comb_it_val[2];						
					print "\n N4: " . $_comb_it_val[3];	
					break;
			
				case 5:
				
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4]);
					}
				
				
					print "\n N1: " . $_comb_it_val[0];
					print "\n N2: " . $_comb_it_val[1];
					print "\n N3: " . $_comb_it_val[2];						
					print "\n N4: " . $_comb_it_val[3];	
					print "\n N5: " . $_comb_it_val[4];	
				
					break;
					
				case 6:
				
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5]);
					}
				
				
				
				
					print "\n N1: " . $_comb_it_val[0];
					print "\n N2: " . $_comb_it_val[1];
					print "\n N3: " . $_comb_it_val[2];						
					print "\n N4: " . $_comb_it_val[3];	
					print "\n N5: " . $_comb_it_val[4];
					print "\n N6: " . $_comb_it_val[5];							
					break;
			
				case 7:
				
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6]);
					}
				
					print "\n N1: " . $_comb_it_val[0];
					print "\n N2: " . $_comb_it_val[1];
					print "\n N3: " . $_comb_it_val[2];						
					print "\n N4: " . $_comb_it_val[3];	
					print "\n N5: " . $_comb_it_val[4];
					print "\n N6: " . $_comb_it_val[5];							
					print "\n N7: " . $_comb_it_val[6];								
					break;
				case 8:
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7]);
					}
				
				
				
				
					print "\n N1: " . $_comb_it_val[0];
					print "\n N2: " . $_comb_it_val[1];
					print "\n N3: " . $_comb_it_val[2];						
					print "\n N4: " . $_comb_it_val[3];	
					print "\n N5: " . $_comb_it_val[4];
					print "\n N6: " . $_comb_it_val[5];							
					print "\n N7: " . $_comb_it_val[6];	
					print "\n N8: " . $_comb_it_val[7];								
					break;
			
				case 9:
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8]);
					}
				
				
					print "\n N1: " . $_comb_it_val[0];
					print "\n N2: " . $_comb_it_val[1];
					print "\n N3: " . $_comb_it_val[2];						
					print "\n N4: " . $_comb_it_val[3];	
					print "\n N5: " . $_comb_it_val[4];
					print "\n N6: " . $_comb_it_val[5];							
					print "\n N7: " . $_comb_it_val[6];	
					print "\n N8: " . $_comb_it_val[7];
					print "\n N9: " . $_comb_it_val[8];
				
					break;
				
				case 10:
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9] );
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9]);
					}
				
				
				
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
					break;
			
				case 11:
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10] );
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10]);
					}
				
				
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
					break;
				case 12:
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11]  );
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] );
					}
				
				
				
				
				
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
					break;
			
				case 13:
				
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  );
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12]  );
					}
				
				
				
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
					break;
				
				case 14:
				
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13] );
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  );
					}
				
				
				
				
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
					
					break;
			
				case 15:
				
				
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14] );
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14]);
					}
				
				
				
				
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
					break;
				case 16:
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15] );
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15]);
					}
				
				
				
			
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
					break;
			
				case 17:
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15], $_comb_it_val[16]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15],$_comb_it_val[16]);
					}
				
				
				
				
				
				
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
					
					
					break;
				case 18:
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15], $_comb_it_val[16], $_comb_it_val[17]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15],$_comb_it_val[16], $_comb_it_val[17]);
					}
				
				
				
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
					
					break;
			
				case 19:
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15], $_comb_it_val[16], $_comb_it_val[17], $_comb_it_val[18]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15],$_comb_it_val[16], $_comb_it_val[17], $_comb_it_val[18]);
					}
				
				
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
					
					break;
				case 20:
				
				
					$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetId ($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11] , $_comb_it_val[12]  , $_comb_it_val[13], $_comb_it_val[14], $_comb_it_val[15], $_comb_it_val[16], $_comb_it_val[17], $_comb_it_val[18], $_comb_it_val[19]);
					if (!$i_comb_keno_id) {
						$i_comb_keno_id = $CombOLGLottery->OLGCombKenoGetAdd($_i_cat, $_incr_, $_comb_it_val[0], $_comb_it_val[1], $_comb_it_val[2], $_comb_it_val[3], $_comb_it_val[4], $_comb_it_val[5], $_comb_it_val[6], $_comb_it_val[7], $_comb_it_val[8], $_comb_it_val[9], $_comb_it_val[10], $_comb_it_val[11], $_comb_it_val[12] , $_comb_it_val[13]  , $_comb_it_val[14], $_comb_it_val[15],$_comb_it_val[16], $_comb_it_val[17], $_comb_it_val[18], $_comb_it_val[19]);
					}
				
				
				
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
					
					break;
			

					
				}


				if (!$i_comb_keno_id) {
					$comb_draw_date = date('Y-m-d',strtotime($db_row["drawdate"]));
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
//	OLGKenoValidateDraw($st_drawdate, $ed_drawdate, $category, $snum1, $snum2="", $snum3="", $snum4="", $snum5="", $snum6="", $snum7="", $snum8="", $snum9="", $snum10="");
    
	
	
	
}

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
			$comb_items["adj"]["pos"] =  $i_max - 1;
			
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






?>