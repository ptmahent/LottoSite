
<?php


  include_once("class_db.php");
  include_once("incOLGLottery.php");
  include_once("incNaLottery.php");
  include_once("incComboOLGLottery.php");
  
  
  class StatGen2 {
  
  	var $OLGLottery;
  	var $NALottery;
  	var $CombOLGLottery;
  	
  	function KenoStatGen( $st_date, $ed_date) {
  	
  		if (!$this->OLGLottery) {
  			$this->OLGLottery = new OLGLottery();
  		
  		}
  		
  		if (!$this->CombOLGLottery) {
  			$this->CombOLGLottery = new CombOLGLottery();
  		}
  	
  		$db_rs = $this->OLGLottery->OLGKenoGetDraw($st_date, $ed_date);
  		
  		if (is_array($db_rs)) {
  			foreach ($db_rs as $db_row) {
  				
  				
  				$x = 20;
  				$cons_numbers = array();
  				$icnt = 0;
  				
  				
  				if (($db_row["snum1"] + 20) == $db_row["snum20"]) {
  				
  				
  				} elseif (($db_row["snum1"] + 19) == $db_row["snum19"]) {
  				
  				} elseif (($db_row["snum1"] + 18) == $db_row["snum18"]) {
  				
  				} elseif (($db_row["snum1"] + 17) == $db_row["snum17"]) {
  				
  				} elseif (($db_row["snum1"] + 16) == $db_row["snum16"]) {
  				
  				} elseif (($db_row["snum1"] + 15) == $db_row["snum"]) {
  				
  				
  				for ($x = 20; $x > 0; $x++) {
  					if (($db_row["snum1"]  + $x) == ($db_row["snum20"])) ) {
  						//$cons_numbers[$icnt]  = $db_row["
  						
  					}
  					$icnt++;
  				
  				}
  				
  				if (($db_row["snum1"] + 1 == $db_row["snum2"])  ) {
  					
  				}
  			}
  		
  		}
  	
  	}
  
  
  }
  
  
  class StatGen {
  
  	var $OLGLottery;
  	var $NALottery;
  	var $CombOLGLottery;
  	function KenoStatGen($st_date, $ed_date) {
  	
  	   
      if (!$this->OLGLottery) {
        $this->OLGLottery = new OLGLottery();
      }
      
      if (!$this->CombOLGLottery) {
      	$this->CombOLGLottery = new CombOLGLottery();
      }
  	
  		$db_rs = $this->OLGLottery->OLGKenoGetDraw($st_date, $ed_date);
  	
  		if (is_array($db_rs)) {
  		
  			foreach ($db_rs as $db_row) {
  			
  				$this->genSingleKenoStat($db_row);
  			}
  		
  		}
  	
  	
  	
  	
  	
  	
  	}
  	
  	
  	/*
  	
  	2-3-4-5-6
  	
  	
  	*/
  
  
  
  
  
  	function genSingleKenoStat($db_row) {
  	
  	  if (!$this->CombOLGLottery) {
      	$this->CombOLGLottery = new CombOLGLottery();
      }
  	
  		$possible_new_combos = array();
  	
  		if (is_array($db_row)) {
  		
  			/*
  			generate all combination for possible winning number
  			
  			
  			
  			*/
  			$possible_new_combos[2]= array();
  			$comb_2_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  			  			
				for ($i_2 = 1; $i_2 < 21; $i_2++) {
				
					if ($i_1 != $i_2) {
						//num1
					
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
  			 
  			 
  			$possible_new_combos[3]= array();
  			$comb_3_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  				
  					if (($i_1 != $i_2) && ($i_2 != $i_3)) {
  						
  						
  					
  						$possible_new_combos[3][$comb_3_cnt] = array($db_row["snum" . $i_1],
  																	$db_row["snum" . $i_2],
  																	$db_row["snum" . $i_3]);
  						sort($possible_new_combos[3][$comb_3_cnt],SORT_ASC);
    					
    					$possible_new_combos[3][$comb_3_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoGetId (3, 
    						$possible_new_combos[3][$comb_3_cnt][0], 
    						$possible_new_combos[3][$comb_3_cnt][1], 
    						$possible_new_combos[3][$comb_3_cnt][2]);
   						if (!$possible_new_combos[3][$comb_3_cnt]["id"]) {
   							$possible_new_combos[3][$comb_3_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoAdd (3, 
   							$possible_new_combos[3][$comb_3_cnt][0],
   							$possible_new_combos[3][$comb_3_cnt][1], 
   							$possible_new_combos[3][$comb_3_cnt][2]);
   						}
   						
   								
    					$lc_insertFound = $this->CombOLGLottery->OLGCombKenoStatsGetMatch($possible_new_combos[3][$comb_3_cnt]["id"], $db_row["drawdate"]);
   						if (!$lc_insertFound) {
   							$this->CombOLGLottery->OLGCombKenoStatsAdd($possible_new_combos[3][$comb_3_cnt]["id"], $db_row["drawdate"], 1);
   						}					
    																	
  						$comb_3_cnt++;
  					}
  					}
  				}
  			
  			}
  			 
  			 
  			 
  			$possible_new_combos[4]= array();
  			$comb_4_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  					  	for ($i_4 = 1; $i_4 < 21; $i_4++) {
  				
  							if (($i_1 != $i_2) && ($i_2 != $i_3) && ($i_3 != $i_4)) {
  						
  						
  					
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
  			 
  			 
  			 
  			  
  			$possible_new_combos[5]= array();
  			$comb_5_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  					  	for ($i_4 = 1; $i_4 < 21; $i_4++) {
							for ($i_5 = 1; $i_5 < 21; $i_5++) {
								if (($i_1 != $i_2) && ($i_2 != $i_3) && ($i_3 != $i_4) && ($i_4 != $i_5)) {
				
				
			
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
																				
																										
									$comb_5_cnt++;
								}
							}
  						}
  					}
  				}
  			
  			}
  			
  			
  			$possible_new_combos[6]= array();
  			$comb_6_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  					  	for ($i_4 = 1; $i_4 < 21; $i_4++) {
  							
							for ($i_5 = 1; $i_5 < 21; $i_5++) {
							
								for ($i_6 = 1; $i_6 < 21; $i_6++) {
									if (($i_1 != $i_2) && ($i_2 != $i_3) && ($i_3 != $i_4) && ($i_4 != $i_5) && ($i_5 != $i_6)) {
										$possible_new_combos[6][$comb_6_cnt] = array(
																		$db_row["snum" . $i_1],
																		$db_row["snum" . $i_2],
																		$db_row["snum" . $i_3],
																		$db_row["snum" . $i_4],
																		$db_row["snum" . $i_5],
																		$db_row["snum" . $i_6]
																	);
									
										sort($possible_new_combos[6][$comb_6_cnt],SORT_ASC);
								
										$possible_new_combos[6][$comb_6_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoGetId (6, 
												$possible_new_combos[6][$comb_6_cnt][0], 
												$possible_new_combos[6][$comb_6_cnt][1], 
												$possible_new_combos[6][$comb_6_cnt][2], 
												$possible_new_combos[6][$comb_6_cnt][3], 
												$possible_new_combos[6][$comb_6_cnt][4], 
												$possible_new_combos[6][$comb_6_cnt][5]);
											if (!$possible_new_combos[6][$comb_6_cnt]["id"]) {
															$possible_new_combos[6][$comb_6_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoAdd (6, 
															$possible_new_combos[6][$comb_6_cnt][0],
															$possible_new_combos[6][$comb_6_cnt][1], 
															$possible_new_combos[6][$comb_6_cnt][2], 
															$possible_new_combos[6][$comb_6_cnt][3], 
															$possible_new_combos[6][$comb_6_cnt][4], 
															$possible_new_combos[6][$comb_6_cnt][5]);
											}			
																	
											
												
										$lc_insertFound = $this->CombOLGLottery->OLGCombKenoStatsGetMatch($possible_new_combos[6][$comb_6_cnt]["id"], $db_row["drawdate"]);
										if (!$lc_insertFound) {
											$this->CombOLGLottery->OLGCombKenoStatsAdd($possible_new_combos[6][$comb_6_cnt]["id"], $db_row["drawdate"], 1);
										}				
														
															
																
																		
										$comb_6_cnt++;
									}
								}
							}
					
  						}
  					}
  				}
  				
  				
  				
  				
  				
  			$possible_new_combos[7]= array();
  			$comb_7_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  					  	for ($i_4 = 1; $i_4 < 21; $i_4++) {

  				  					for ($i_5 = 1; $i_5 < 21; $i_5++) {
  				  					
  				  						for ($i_6 = 1; $i_6 < 21; $i_6++) {
  				  						
  				  						
											for ($i_7 = 1; $i_7 < 21; $i_7++) {
												if (($i_1 != $i_2) && ($i_2 != $i_3) && ($i_3 != $i_4) && ($i_4 != $i_5) && ($i_5 != $i_6) && ($i_6 != $i_7)) {
					
					
				
													$possible_new_combos[7][$comb_7_cnt] = array($db_row["snum" . $i_1],
																							$db_row["snum" . $i_2],
																							$db_row["snum" . $i_3],
																							$db_row["snum" . $i_4],
																							$db_row["snum" . $i_5],
																							$db_row["snum" . $i_6],
																							$db_row["snum" . $i_7]
																							);
												
													sort($possible_new_combos[7][$comb_7_cnt],SORT_ASC);
												
												
													$possible_new_combos[7][$comb_7_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoGetId (7, 
														$possible_new_combos[7][$comb_7_cnt][0], 
														$possible_new_combos[7][$comb_7_cnt][1], 
														$possible_new_combos[7][$comb_7_cnt][2], 
														$possible_new_combos[7][$comb_7_cnt][3], 
														$possible_new_combos[7][$comb_7_cnt][4], 
														$possible_new_combos[7][$comb_7_cnt][5], 
														$possible_new_combos[7][$comb_7_cnt][6]);
													if (!$possible_new_combos[7][$comb_7_cnt]["id"]) {
														$possible_new_combos[7][$comb_7_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoAdd (7, 
														$possible_new_combos[7][$comb_7_cnt][0],
														$possible_new_combos[7][$comb_7_cnt][1], 
														$possible_new_combos[7][$comb_7_cnt][2], 
														$possible_new_combos[7][$comb_7_cnt][3], 
														$possible_new_combos[7][$comb_7_cnt][4], 
														$possible_new_combos[7][$comb_7_cnt][5], 
														$possible_new_combos[7][$comb_7_cnt][6]);
													}		
												$lc_insertFound = $this->CombOLGLottery->OLGCombKenoStatsGetMatch($possible_new_combos[7][$comb_7_cnt]["id"], $db_row["drawdate"]);
												if (!$lc_insertFound) {
													$this->CombOLGLottery->OLGCombKenoStatsAdd($possible_new_combos[7][$comb_7_cnt]["id"], $db_row["drawdate"], 1);
												}
												
												
												
												$comb_7_cnt++;
											}// #8
										}// #7
							
  									}// #6
  								}// #5
  							}// #4
  						}
  					}// #3
  				}// #2
  			
  			}// #1
  			
  			
  			
  			$possible_new_combos[8]= array();
  			$comb_8_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  					  	for ($i_4 = 1; $i_4 < 21; $i_4++) {
  		
							for ($i_5 = 1; $i_5 < 21; $i_5++) {
								
								for ($i_6 = 1; $i_6 < 21; $i_6++) {
									
									
									for ($i_7 = 1; $i_7 < 21; $i_7++) {
										
										for ($i_8 = 1; $i_8 < 21; $i_8++) {
										
											if (($i_1 != $i_2) && ($i_2 != $i_3) && ($i_3 != $i_4) && ($i_4 != $i_5) && ($i_5 != $i_6) && ($i_6 != $i_7) && ($i_7 != $i_8)) {
					
					
				
													$possible_new_combos[8][$comb_8_cnt] = array($db_row["snum" . $i_1],
																									$db_row["snum" . $i_2],
																									$db_row["snum" . $i_3],
																									$db_row["snum" . $i_4],
																									$db_row["snum" . $i_5],
																									$db_row["snum" . $i_6],
																									$db_row["snum" . $i_7],
																									$db_row["snum" . $i_8]
																						);
														
													sort($possible_new_combos[8][$comb_8_cnt],SORT_ASC);
														
														
													$possible_new_combos[8][$comb_8_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoGetId (8, 
														$possible_new_combos[8][$comb_8_cnt][0], 
														$possible_new_combos[8][$comb_8_cnt][1], 
														$possible_new_combos[8][$comb_8_cnt][2], 
														$possible_new_combos[8][$comb_8_cnt][3], 
														$possible_new_combos[8][$comb_8_cnt][4], 
														$possible_new_combos[8][$comb_8_cnt][5], 
														$possible_new_combos[8][$comb_8_cnt][6], 
														$possible_new_combos[8][$comb_8_cnt][7]);
													if (!$possible_new_combos[8][$comb_8_cnt]["id"]) {
															$possible_new_combos[8][$comb_8_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoAdd (8, 
															$possible_new_combos[8][$comb_8_cnt][0],
															 $possible_new_combos[8][$comb_8_cnt][1], 
															 $possible_new_combos[8][$comb_8_cnt][2], 
															$possible_new_combos[8][$comb_8_cnt][3], 
															$possible_new_combos[8][$comb_8_cnt][4], 
															$possible_new_combos[8][$comb_8_cnt][5], 
															$possible_new_combos[8][$comb_8_cnt][6], 
															$possible_new_combos[8][$comb_8_cnt][7]);
													}		
													
														
													$lc_insertFound = $this->CombOLGLottery->OLGCombKenoStatsGetMatch($possible_new_combos[8][$comb_8_cnt]["id"], $db_row["drawdate"]);
													if (!$lc_insertFound) {
														$this->CombOLGLottery->OLGCombKenoStatsAdd($possible_new_combos[8][$comb_8_cnt]["id"], $db_row["drawdate"], 1);
													}
												
													
													
													$comb_8_cnt++;
												} //#10
											}// #9
										}// #8
									}// #7
								}// #6
							}// #5

  						}// #4
  					}// #3
  				}// #2
  			
  			} // #1
  			
  			
  			$possible_new_combos[9]= array();
  			$comb_9_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  					  	for ($i_4 = 1; $i_4 < 21; $i_4++) {
							for ($i_5 = 1; $i_5 < 21; $i_5++) {
								
								for ($i_6 = 1; $i_6 < 21; $i_6++) {
									
									
									for ($i_7 = 1; $i_7 < 21; $i_7++) {
										
										for ($i_8 = 1; $i_8 < 21; $i_8++) {
											
											for ($i_9 = 1; $i_9 < 21; $i_9++) {
										
												if (($i_1 != $i_2) && ($i_2 != $i_3) && ($i_3 != $i_4) && ($i_4 != $i_5) && ($i_5 != $i_6) && ($i_6 != $i_7) && ($i_7 != $i_8) && ($i_8 != $i_9)) {
					
					
					
													$possible_new_combos[9][$comb_9_cnt] = array($db_row["snum" . $i_1],
																								$db_row["snum" . $i_2],
																								$db_row["snum" . $i_3],
																								$db_row["snum" . $i_4],
																								$db_row["snum" . $i_5],
																								$db_row["snum" . $i_6],
																								$db_row["snum" . $i_7],
																								$db_row["snum" . $i_8],
																								$db_row["snum" . $i_9]
																								
																					);
													
													sort($possible_new_combos[9][$comb_9_cnt],SORT_ASC);
												

														
														
													$possible_new_combos[9][$comb_9_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoGetId (9, 
																									$possible_new_combos[9][$comb_9_cnt][0], 
																									$possible_new_combos[9][$comb_9_cnt][1], 
																									$possible_new_combos[9][$comb_9_cnt][2], 
																									$possible_new_combos[9][$comb_9_cnt][3], 
																									$possible_new_combos[9][$comb_9_cnt][4], 
																									$possible_new_combos[9][$comb_9_cnt][5], 
																									$possible_new_combos[9][$comb_9_cnt][6], 
																									$possible_new_combos[9][$comb_9_cnt][7], 
																									$possible_new_combos[9][$comb_9_cnt][8]);
													if (!$possible_new_combos[9][$comb_9_cnt]["id"]) {
														$possible_new_combos[9][$comb_9_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoAdd (9, 
																									$possible_new_combos[9][$comb_9_cnt][0],
																									 $possible_new_combos[9][$comb_9_cnt][1], 
																									 $possible_new_combos[9][$comb_9_cnt][2], 
																									$possible_new_combos[9][$comb_9_cnt][3], 
																									$possible_new_combos[9][$comb_9_cnt][4], 
																									$possible_new_combos[9][$comb_9_cnt][5], 
																									$possible_new_combos[9][$comb_9_cnt][6], 
																									$possible_new_combos[9][$comb_9_cnt][7], 
																									$possible_new_combos[9][$comb_9_cnt][8]);
													}		
												
														
														
													$lc_insertFound = $this->CombOLGLottery->OLGCombKenoStatsGetMatch($possible_new_combos[9][$comb_9_cnt]["id"], $db_row["drawdate"]);
													if (!$lc_insertFound) {
														$this->CombOLGLottery->OLGCombKenoStatsAdd($possible_new_combos[9][$comb_9_cnt]["id"], $db_row["drawdate"], 1);
													}
														
														
														
													$comb_9_cnt++;
													
												} // #10
											}// #10
										}// #9
									}// #8
								}// #7
							}// #6

  						}// #4
  					}// #3
  				}// #2
  			
  			} // #1
  			
  			
  			
  			
  			
  			$possible_new_combos[10]= array();
  			$comb_10_cnt = 0;
  			for ($i_1 = 1; $i_1 < 21; $i_1++) {
  			
  				for ($i_2 = 1; $i_2 < 21; $i_2++) {
  					for ($i_3 = 1; $i_3 < 21; $i_3++) {
  					  	for ($i_4 = 1; $i_4 < 21; $i_4++) {
  				  			for ($i_5 = 1; $i_5 < 21; $i_5++) {
  				  					
  				  				for ($i_6 = 1; $i_6 < 21; $i_6++) {
  				  						
  				  						
  				  					for ($i_7 = 1; $i_7 < 21; $i_7++) {
  				  							
  				  						for ($i_8 = 1; $i_8 < 21; $i_8++) {
  				  								
  				  							for ($i_9 = 1; $i_9 < 21; $i_9++) {
  				  									
  				  								for ($i_10 = 1; $i_10 < 21; $i_10++) {
  				  							
  				  							
  													if (($i_1 != $i_2) && ($i_2 != $i_3) && ($i_3 != $i_4) && ($i_4 != $i_5) && ($i_5 != $i_6) && ($i_6 != $i_7) && ($i_7 != $i_8) && ($i_8 != $i_9) && ($i_9 != $i_10)) {
  						
  						

  														$possible_new_combos[10][$comb_10_cnt] = array($db_row["snum" . $i_1],
  																									$db_row["snum" . $i_2],
  																									$db_row["snum" . $i_3],
  																									$db_row["snum" . $i_4],
  																									$db_row["snum" . $i_5],
  																									$db_row["snum" . $i_6],
  																									$db_row["snum" . $i_7],
  																									$db_row["snum" . $i_8],
  																									$db_row["snum" . $i_9],
  																									$db_row["snum" . $i_10]
  																						);
  														
    													sort($possible_new_combos[10][$comb_10_cnt],SORT_ASC);
    												
  					
    														
    													$possible_new_combos[10][$comb_10_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoGetId (10, 
    														$possible_new_combos[10][$comb_10_cnt][0], 
    														$possible_new_combos[10][$comb_10_cnt][1], 
    														$possible_new_combos[10][$comb_10_cnt][2], 
    														$possible_new_combos[10][$comb_10_cnt][3], 
    														$possible_new_combos[10][$comb_10_cnt][4], 
    														$possible_new_combos[10][$comb_10_cnt][5], 
    														$possible_new_combos[10][$comb_10_cnt][6], 
    														$possible_new_combos[10][$comb_10_cnt][7], 
    														$possible_new_combos[10][$comb_10_cnt][8], 
    														$possible_new_combos[10][$comb_10_cnt][9]);
   														if (!$possible_new_combos[10][$comb_10_cnt]["id"]) {
   															$possible_new_combos[10][$comb_10_cnt]["id"] = $this->CombOLGLottery->OLGCombKenoAdd (10, 
   																$possible_new_combos[10][$comb_10_cnt][0],
   																$possible_new_combos[10][$comb_10_cnt][1], 
   																$possible_new_combos[10][$comb_10_cnt][2], 
    															$possible_new_combos[10][$comb_10_cnt][3], 
    															$possible_new_combos[10][$comb_10_cnt][4], 
    															$possible_new_combos[10][$comb_10_cnt][5], 
    															$possible_new_combos[10][$comb_10_cnt][6], 
    															$possible_new_combos[10][$comb_10_cnt][7], 
    															$possible_new_combos[10][$comb_10_cnt][8], 
    															$possible_new_combos[10][$comb_10_cnt][9]);
   														}		
    												
    														
    														
    													$lc_insertFound = $this->CombOLGLottery->OLGCombKenoStatsGetMatch($possible_new_combos[10][$comb_10_cnt]["id"], $db_row["drawdate"]);
   														if (!$lc_insertFound) {
   															$this->CombOLGLottery->OLGCombKenoStatsAdd($possible_new_combos[10][$comb_10_cnt]["id"], $db_row["drawdate"], 1);
   														}
    														
    														
    														
  														$comb_10_cnt++;
  														
  													}// #11
  												}// #10
  											}// #9
  										}// #8
  									}// #7
  								}// #6
  							}// #5
  						}// #4
  					}// #3
  				}// #2
  			
  			}// #1
  			
  			print "<br /><hr />" . 
  				"Keno Cat 10 ... Possible Combos : " . $comb_10_cnt . "<br /><hr />\n" .
  				"Keno Cat 9 ... Possible Combos : " . $comb_9_cnt . "<br /><hr />\n" . 
  				"Keno Cat 8 ... Possible Combos : " . $comb_8_cnt . "<br /><hr />\n" .
  				"Keno Cat 7 ... Possible Combos : " . $comb_7_cnt . "<br /><hr />\n" .
  				"Keno Cat 6 ... Possible Combos : " . $comb_6_cnt . "<br /><hr />\n" .
  				"Keno Cat 5 ... Possible Combos : " . $comb_5_cnt . "<br /><hr />\n" .
  				"Keno Cat 4 ... Possible Combos : " . $comb_4_cnt . "<br /><hr />\n" .
  				"Keno Cat 3 ... Possible Combos : " . $comb_3_cnt . "<br /><hr />\n" .
  				"Keno Cat 2 ... Possible Combos : " . $comb_2_cnt . "<br /><hr />\n";
  		}
  	
  	
  	}
  
  }
    