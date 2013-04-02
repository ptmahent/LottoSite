<?php

class QuickPick {


	function QuickPickLottery($maxn = 49, $maxb = 6, $gameType = 0) {
		srand((double) microtime() * 1000000);
		// $gameType == 0
		// normal games
		// $gameType == 1
		  // pick 3 , pick 4 -- starting 0
		  
		/*
		
		function rand_best($min, $max) {
    $generated = array();
    for ($i = 0; $i < 100; $i++) {
        $generated[] = mt_rand($min, $max);
    }
    shuffle($generated);
    $position = mt_rand(0, 99);
    return $generated[$position];
}
		
		
		
		
		*/
		  
		  
		  
		if ($gameType == 0) {
			$lottery = array();
			$lottery_2 = array();
			for ($i = 0; $i < 100; $i++) {
				$lottery[] = mt_rand(1, $maxn);
			}
			shuffle($lottery);
			while (1 > 0) {
				$lottery_2[] = $lottery[mt_rand(0,99)];
				$lottery_2 = array_unique($lottery_2);
				if (sizeof($lottery_2) == $maxb) break;
			}
			sort($lottery_2);
		} else {
			$lottery = array();
			$lottery_2 = array();
			for ($i = 0; $i < 100; $i++) {
				$lottery[] = mt_rand(0, $maxn);
			}
			shuffle($lottery);
			
			while (1 > 0) {
			
				$lottery_2[] = $lottery[mt_rand(0, $maxn)];
				if (sizeof($lottery_2) == $maxb) break;
				
			}
			
		}
		return $lottery_2;
	
	}

	function na649QuickPick() {
		return $this->QuickPickLottery(49, 6);
	
	}
	
	function naMaxQuickPick() {
		return $this->QuickPickLottery(49, 7);	
	
	}
	
	function OLG49QuickPick() {
		return $this->QuickPickLottery(49, 6);	
	}
	
	
	function OLGLottarioQuickPick() {
		return $this->QuickPickLottery(49, 6);	
	
	}
	
	function OLGKenoQuickPick($category = 10) {
		return $this->QuickPickLottery(49, $category);	
	}
	
	function OLGPick4QuickPick() {
		return $this->QuickPickLottery(9, 4, 1);
	
	}
	
	function OLGPick3QuickPick() {
		return $this->QuickPickLottery(9, 3, 1);
	}



}


?>