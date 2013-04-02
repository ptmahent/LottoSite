<?php

  include_once("class_db.php");
  class LottoJackpot {
    
    
    // tbl_lottery_jackpots
  	/// `jackpot_id`, `jackpot_drawdate`, `current_drawdate`, 
  	//`jackpot_amount`, `jackpot_bonus`, `jackpot_desc`, 
  	//`jackpot_maxmill`, `jackpot_gameid`
  	
  	
  	
  	
  	function Jackpot_add($jackpot_drawdate, $jackpot_gameid, $current_date, $jackpot_amount, $jackpot_bonus, $jackpot_desc, $jackpot_maxmill) {
  		if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = "INSERT INTO tbl_lottery_jackpots (`jackpot_drawdate`, `current_drawdate`, `jackpot_amount`, `jackpot_bonus`, `jackpot_desc`, `jackpot_maxmill`, `jackpot_gameid`) ";
        $ssql .= sprintf(" VALUES('%s', '%s', %u, %u, '%s', %u, %u)", $jackpot_drawdate, $current_date, $jackpot_amount, $jackpot_bonus, $jackpot_desc, $jackpot_maxmill, $jackpot_gameid);
        
        $rows_affect = $this->db_obj->exec($ssql);
        
        return $this->db_obj->last_id;
  	
  	}
  	
  	
  	function Jackpot_remove($jackpot_drawdate, $jackpot_gameid) {
  		if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("DELETE FROM tbl_lottery_jackpots WHERE `jackpot_gameid` = %u AND jackpot_drawdate = '%s'",  $jackpot_gameid, $jackpot_drawdate);
        $rows_affect = $this->db_obj->exec($ssql);
        
        return $rows_affect;
        
  	
  	}
  	
  	function Jackpot_modify($jackpot_id, $jackpot_drawdate, $jackpot_gameid, $current_date, $jackpot_amount, $jackpot_bonus, $jackpot_desc, $jackpot_maxmill) {
  		if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("UPDATE tbl_lottery_jackpots SET `jackpot_drawdate` = '%s', `current_drawdate` = '%s', `jackpot_amount` = %u, 
        		`jackpot_bonus` = %u, `jackpot_desc` = '%s', `jackpot_maxmill` = %u, `jackpot_gameid` = %u WHERE jackpot_id = %u",
        		$jackpot_drawdate, $current_date, $jackpot_amount, $jackpot_bonus, $jackpot_desc, $jackpot_maxmill, 
        		$jackpot_gameid, $jackpot_id);
        $rows_affect = $this->db_obj->exec($ssql);
        return $rows_affect;
  	
  	}
  	
  	function Jackpot_getid($jackpot_drawdate, $jackpot_gameid) {
  		if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM tbl_lottery_jackpots WHERE  `jackpot_drawdate` = '%s' AND `jackpot_gameid` = %u", $jackpot_drawdate, $jackpot_gameid);
        $db_result = $this->db_obj->fetch($ssql);
        if (is_array($db_result)) {
          return $db_result[0]["jackpot_id"];
        } else {
          return null;
        }
        
        
  	}
  
  	function Jackpot_get($jackpot_drawdate, $jackpot_gameid) {
  		if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM tbl_lottery_jackpots WHERE  `jackpot_drawdate` = '%s' AND `jackpot_gameid` = %u", $jackpot_drawdate, $jackpot_gameid);
        $db_result = $this->db_obj->fetch($ssql);
        if (is_array($db_result)) {
          return $db_result[0];
        } else {
          return null;
        }
        
        
        
  	}  
  
    
  }
?>