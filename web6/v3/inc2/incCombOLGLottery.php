<?php

include_once("class_db.php");
include_once("incGenDates.php");
include_once("incLottery.php");


class CombOLGLottery {
  
  // 649
  
  /*
   * INSERT INTO `dbaLotteries`.`tbl_comb_649`
(`icomb_649_id`,
`snum1`,
`snum2`,
`snum3`,
`snum4`,
`snum5`,
`snum6`)
VALUES
(
{icomb_649_id: INT},
{snum1: INT},
{snum2: INT},
{snum3: INT},
{snum4: INT},
{snum5: INT},
{snum6: INT}
);
   * 
   * 
   * 
   
   
     
  `userid` int(11) NOT NULL,
  `comb_select_id` int(11) NOT NULL,
  `drawdate` date NOT NULL,
  `gameid` int(11) NOT NULL,
  `amount_won` double NOT NULL,
  `match_cnt` int(11) NOT NULL,
  `match_str` varchar(10) NOT NULL,
  `free_ticket_cnt` int(11) NOT NULL,
  `ticket_cost` double NOT NULL,
  `envelope_no` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
   * 
   */
   
   var $db_obj; 
   
   
   
   
   function getUserPlayedDrawsTickets($st_drawdate, $ed_drawdate, $userid) {
   	  if (!$this->db_obj) {
        $this->db_obj = new db();
      }
   
   // tbl_user_lotto_lines
   
   // tbl_on_store_locs
   
   // tbl_user_ticket
   
   // tbl_winning_prizes
   
   
   
   		/* $ssql = sprintf("SELECT * FROM tbl_user_lotto_lines.*,
   		
   		  Where 
   		*/
   		
   		/*
   		
   		SELECT * FROM `tbl_user_ticket` WHERE `drawdate` = '%s' AND
      				`userid` = %u AND `store_id` = %u AND `uniq_no` = %u",
      				$drawdate, $userid, $store_id, $uniq_no);
      	$ssql = sprintf("UPDATE `tbl_on_store_locs` SET `address` = '%s',  `store_name` = '%s',  `city` = '%s',  `prov` = '%s',  `postal_code` = '%s',  `locnum` = %u WHERE store_id = %u",
					$address, $store_name, $city, $prov, $postal_code, $locnum, $store_id);
		$rows_affect = $this->db_obj->exec($ssql);
		retu			
      				
      				
   		   $ssql = sprintf("UPDATE `tbl_user_lotto_lines` SET `ticket_id` = %u,
  `comb_select_id` = %u,
	 	      `iSeqNo` = %u ,
  `gameid` = %u,
  `amount_won` = %u,
  `match_cnt` = %u,
  `match_str` = '%s',
  `free_ticket_cnt` = %u,`line_cost` = %u WHERE lotto_line_id = %u",
   		*/
   		
   	/*	 $ssql = sprintf("SELECT `on49winningid`, on_49.*, `m_6_count`, `m_6_amount`, 
                (SELECT prze_amount as m_6_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_6_amount) AS m_6_prze_amt,
                `m_6_region`, `m_5_b_count`, `m_5_b_amount`, 
                (SELECT prze_amount as m_5_b_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_5_b_amount)  AS m_5_b_prze_amt,
                `m_5_b_region`, `m_5_count`, `m_5_amount`, 
                (SELECT prze_amount as m_5_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_5_amount)  AS m_5_prze_amt, 
                `m_4_count`, `m_4_amount`, 
                (SELECT prze_amount as m_4_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_4_amount)  AS m_4_prze_amt, 
                `m_3_count`, `m_3_amount`, 
                (SELECT prze_amount as m_3_prze_amt FROM `tbl_winning_prizes` WHERE tbl_winning_prizes.prze_id = 49_winning.m_3_amount)  AS m_3_prze_amt
                FROM `tbl_on_49_winnings` as 49_winning,  `tbl_on_49` as on_49 WHERE 
                49_winning.on49id = on_49.on49id AND on_49.drawdate >= '%s' AND on_49.drawdate <= '%s'",
                $st_drawdate, $ed_drawdate);
      
   */
   
   	
   }
   /*
   
   
   CREATE TABLE IF NOT EXISTS `tbl_on_store_locs` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  `store_name` varchar(50) NOT NULL,
n zz
  `prov` varchar(2) NOT NULL,
  `postal_code` varchar(8) NOT NULL,
  `locnum` text NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


*/

	function StoreAdd ($address, $store_name, $city, $prov, $postal_code, $locnum) {
	  if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_on_store_locs` (  `address`,  `store_name`,  `city` ,  `prov`,  `postal_code` ,  `locnum` ) ");
	  $ssql .= sprintf(" VALUES('%s', '%s', '%s', '%s', '%s', %u)", $address, $store_name, $city, $prov, $postal_code, $locnum);
	  
	  $rows_affect = $this->db_obj->exec($ssql);
	  return $this->db_obj->last_id;
	}
	
	function StoreRemove($store_id) {
		if (!$this->db_obj) {
		  $this->db_obj = new db();
		}
		
		$ssql = sprintf("DELETE FROM `tbl_on_store_locs` WHERE store_id = %u", $store_id);
		$rows_affect = $this->db_obj->exec($ssql);
		return $rows_affect;
	
	}
	
	function StoreUpdate($store_id, $address, $store_name, $city, $prov, $postal_code, $locnum) {
		if (!$this->db_obj) {
		  $this->db_obj = new db();
		}
		
		$ssql = sprintf("UPDATE `tbl_on_store_locs` SET `address` = '%s',  `store_name` = '%s',  `city` = '%s',  `prov` = '%s',  `postal_code` = '%s',  `locnum` = %u WHERE store_id = %u",
					$address, $store_name, $city, $prov, $postal_code, $locnum, $store_id);
		$rows_affect = $this->db_obj->exec($ssql);
		return $rows_affect;
	
	}
	
	function StoreGetId($locnum) {
		if (!$this->db_obj) {
		  $this->db_obj = new db();
		}
		
		$ssql = sprintf("SELECT * FROM `tbl_on_store_locs` WHERE `locnum` = %u", $locnum);
		
		$db_res = $this->db_obj->fetch($ssql);
		
		if (!is_array($db_res)) {
			return $db_res["0"]["store_id"];
		} else {
			return null;
		}
		
		
	}
	
	function StoreGet($store_id) {
		if (!$this->db_obj) {
		  $this->db_obj = new db();
		}
		
		$ssql = sprintf("SELECT * FROM `tbl_on_store_locs` WHERE store_id = %u", $store_id);
		
		$db_res = $this->db_obj->fetch($ssql);
		
		if (!is_array($db_res)) {
			return $db_res["0"];
		} else {
			return null;
		}
	
	}
	
	
	
	/*
	
	

CREATE TABLE IF NOT EXISTS `tbl_user_ticket` (
 `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
 `drawdate` date NOT NULL,
 `userid` int(11) NOT NULL,
 `envelope_no` int(11) NOT NULL,
 `store_id` int(11) NOT NULL,
 `amount_won` double NOT NULL,
 `free_ticket_cnt` int(11) NOT NULL,
 `ticket_cost` double NOT NULL,
  PRIMARY KEY (`ticket_id`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
--
-- Table structure for table `tbl_user_lotto_lines`
--

CREATE TABLE IF NOT EXISTS `tbl_user_lotto_line` (
  `lotto_line_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `comb_select_id` int(11) NOT NULL,
  `iSeqNo` int(11) NOT NULL,
  `gameid` int(11) NOT NULL,
  `amount_won` double NOT NULL,
  `match_cnt` int(11) NOT NULL,
  `match_str` varchar(10) NOT NULL,
  `free_ticket_cnt` int(11) NOT NULL,
  `line_cost` double NOT NULL,
 
  PRIMARY KEY (`lotto_line_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	
	
	
	*/
	
	
   
   function LottoLineAdd( 
   
    
  $ticket_id,
  $comb_select_id,
  $iSeqNo,
  $gameid,
  $amount_won,
  $match_cnt,
  $match_str,
  $free_ticket_cnt,
  $line_cost
   
   ) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_user_lotto_lines` ( 
  `ticket_id` ,
  `comb_select_id` ,
  `iSeqNo` ,
  `gameid` ,
  `amount_won` ,
  `match_cnt`,
  `match_str`,
  `free_ticket_cnt`,
  `line_cost` ) ");
      $ssql .= sprintf(" VALUES(%u, %u, %u, %u, %u, %u, '%s', %u, %u)" ,      
  $ticket_id,
  $comb_select_id,
  $iSeqNo,
  $gameid,
  $amount_won,
  $match_cnt,
  $match_str,
  $free_ticket_cnt,
  $line_cost);
	  print "\n" . $ssql;
	  
	  $rows_affect = $this->db_obj->exec($ssql);
	  return $this->db_obj->last_id;
   }
   
   
   function LottoLineRemove($lotto_line_id) {
   	 if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_user_lotto_lines` WHERE  lotto_line_id = %u" , $lotto_line_id);
      
      $rows_affect = $this->db_obj->exec($ssql);
      return $rows_affect;
   
   }
   
   function LottoLineGet ( $ticket_id, $comb_select_id, $iSeqNo ) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_user_lotto_lines` WHERE `ticket_id` = %u AND `comb_select_id` = %u AND `iSeqNo` = %u",
      				$ticket_id, $comb_select_id, $iSeqNo);
      $db_res = $this->db_obj->fetch($ssql);
		
	  if (!is_array($db_res)) {
	  	return $db_res["0"];
	  } else {
		return null;
	  }
   
   }
   
   
   function LottoLineGetId ($ticket_id, $comb_select_id, $iSeqNo ) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_user_lotto_lines` WHERE `ticket_id` = %u AND `comb_select_id` = %u AND `iSeqNo` = %u",
      				$ticket_id, $comb_select_id, $iSeqNo);
      $db_res = $this->db_obj->fetch($ssql);
		
	  if (!is_array($db_res)) {
	  	return $db_res["0"]["lotto_line_id"];
	  } else {
		return null;
	  }
   
   
   }
   
   function LottoLineUpdate( $lotto_line_id,  
  $ticket_id,
  $comb_select_id,
  $iSeqNo,
  $gameid,
  $amount_won,
  $match_cnt,
  $match_str,
  $free_ticket_cnt,
  $line_cost
   ) 
   {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE `tbl_user_lotto_lines` SET `ticket_id` = %u,
  `comb_select_id` = %u,
  `iSeqNo` = %u ,
  `gameid` = %u,
  `amount_won` = %u,
  `match_cnt` = %u,
  `match_str` = '%s',
  `free_ticket_cnt` = %u,
  `line_cost` = %u WHERE lotto_line_id = %u", 
      					  
  $ticket_id,
  $comb_select_id,
  $iSeqNo,
  $gameid,
  $amount_won,
  $match_cnt,
  $match_str,
  $free_ticket_cnt,
  $line_cost, 
   $lotto_line_id
   );
      $rows_affect = $this->db_obj->exec($ssql);
      return $rows_affect;
   
   }
   
   function LottoTicketAdd( $drawdate, $userid, $envelope_no, $store_id, $uniq_no, $amount_won,
   $free_ticket_cnt, $ticket_cost) {
   
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
   
      $ssql = sprintf("INSERT INTO `tbl_user_ticket` (" .
" `drawdate`, `userid` , `envelope_no` , `store_id` , `amount_won` , `free_ticket_cnt` ,`ticket_cost`) VALUES('%s', %u, %u, %u, %u, %u, %u)", 
 $drawdate, $userid, $envelope_no, $store_id, $amount_won,
   $free_ticket_cnt, $ticket_cost);
   
      $rows_affect = $this->db_obj->exec($ssql);
   
      
   	  return $this->db_obj->last_id;
   
   }

   
   function LottoTicketRemove( $ticket_id ) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_user_ticket` WHERE ticket_id = %u", $ticket_id);
      $rows_affect = $this->db_obj->exec($ssql);
      
      return $rows_affect;
   
   }
   
   
   function LottoTicketGetid( $drawdate, $userid, $store_id, $uniq_no ) {
   	  if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_user_ticket` WHERE `drawdate` = '%s' AND
      				`userid` = %u AND `store_id` = %u AND `uniq_no` = %u",
      				$drawdate, $userid, $store_id, $uniq_no);
      $db_res = $this->db_obj->fetch($ssql);
      
      if (!is_array($db_res)) {
      	return $db_res["0"]["ticket_id"];
      } else {
      	return null;
      }
      
   }
   
   function LottoTicketGet( $ticket_id ) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("Select * from `tbl_user_ticket` Where ticket_id = %u", $ticket_id);
      
      $db_res = $this->db_obj->fetch($ssql);
      
      if (!is_array($db_res)) {
      	return $db_res;
      } else {
        return null;
      }
   }
   
   function LottoTicketUpdate(   $ticket_id, $drawdate, $userid, $envelope_no, $store_id, $amount_won,
   $free_ticket_cnt, $ticket_cost ) {
   
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = null;
     
      if (!$drawdate) {
   	    if ($ssql) {
   	       $ssql .= ",";
   	    }
      $ssql .= sprintf("`drawdate` = '%s',",$drawdate);
      }
      
      if (!$userid) {
      if ($ssql) {
   	       $ssql .= ",";
   	    }
      $ssql .= sprintf("`userid` = %u,", $userid);
      }
      
      if (!$envelope_no) {
      if ($ssql) {
   	       $ssql .= ",";
   	    }
      $ssql .= sprintf("`envelope_no` = %u ,", $envelope_no);
      }
      if (!$store_id){
      
      if ($ssql) {
   	       $ssql .= ",";
   	    }
      $ssql .= sprintf("`store_id` = %u ",$store_id);
      }
      
      
      if (!$amount_won) {
      if ($ssql) {
   	       $ssql .= ",";
   	    }
      $ssql .= sprintf("`amount_won` = %u,", $amount_won);
        
      }
      if (!$ticket_cost) {
      if ($ssql) {
   	       $ssql .= ",";
   	    }
      $ssql .= sprintf("`ticket_cost` = %u", $ticket_cost);
      }
      
      if (!$free_ticket_cnt) {
      
      if ($ssql) {
   	       $ssql .= ",";
   	    }
      $ssql .= sprintf("`free_ticket_cnt` = %u", $free_ticket_cnt);
      }
     $ssql = "UPDATE `tbl_user_ticket` SET " . $ssql;
    
 
 	  $ssql .= sprintf(" WHERE ticket_id = %u", $ticket_id);
      $rows_affect = $this->db_obj->exec($ssql);
    return $rows_affect;
    
    
   }
   
   function LottoSummaryAdd($user_id, $envelope_no, $total_lines, $lines_won_cnt, $lines_win_amt) {
   	  if (!$this->db_obj) {
        $this->db_obj = new db();
      }
   
   	$ssql = sprintf("INSERT INTO `tbl_lotto_summary` (`userid`, `envelope_no`, `total_lines`, `lines_won_cnt`, `lines_win_amt`) ");
   	$ssql .= sprintf(" VALUES(%u, %u, %u, %u, %u)", $user_id, $envelope_no, $total_lines, $lines_won_cnt, $lines_win_amt);
   	
   	$rows_affect = $this->db_obj->exec($ssql);
   	return $this->db_obj->last_id;
   }
   
   
   function LottoSummaryRemove($summary_id) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_lotto_summary` WHERE summary_id = %u", $summary_id);
      $rows_affect = $this->db_obj->exec($ssql);
      
      return $rows_affect;
   
   }
   
   function LottoSummaryUpdate($summary_id, $user_id, $envelope_no, $total_lines, $lines_won_cnt, $lines_win_amt) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("UPDATE tbl_lotto_summary SET `userid` = %u, `envelope_no` = %u , `total_lines` = %u, `lines_won_cnt` = %u, `lines_win_amt` = %u WHERE summary_id = %u",
						$user_id, $envelope_no, $total_lines, $lines_won_cnt, $lines_win_amt, $summary_id);   	
   	  $rows_affect = $this->db_obj->exec($ssql);
   	  
   	  return $rows_affect;
   }
   
   /*
   
   --
-- Table structure for table `tbl_lotto_summary`
--

CREATE TABLE IF NOT EXISTS `tbl_lotto_summary` (
  `summary_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `envelope_no` int(11) NOT NULL,
  `total_lines` int(11) NOT NULL,
  `lines_won_cnt` int(11) NOT NULL,
  `lines_win_amt` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

   --
-- Table structure for table `tbl_on_store_locs`
--

CREATE TABLE IF NOT EXISTS `tbl_on_store_locs` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  `store_name` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `prov` varchar(2) NOT NULL,
  `postal_code` varchar(8) NOT NULL,
  `locnum` text NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

   
   
   --
-- Table structure for table `tbl_select_match`
--

CREATE TABLE IF NOT EXISTS `tbl_select_match` (
  `match_code` int(11) NOT NULL AUTO_INCREMENT,
  `match_num` int(11) DEFAULT NULL,
  `total_num` int(11) DEFAULT NULL,
  `match_bonus` int(11) DEFAULT NULL,
  `gameid` int(11) DEFAULT NULL,
  `is_straight` int(11) DEFAULT NULL,
  `is_box` int(11) DEFAULT NULL,
  `m_box_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`match_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

   
   */
   
   
   function NAComb649Add($snum1, $snum2, $snum3, $snum4, $snum5, $snum6)
   {
        
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf("INSERT INTO `tbl_comb_649` (`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`)");
     $ssql .= sprintf(" VALUES(%u, %u, %u, %u, %u, %u)", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6);
     
     print "\n" . $ssql;
     
     $rows_affect = $this->db_obj->exec($ssql);
     return $this->db_obj->last_id;
     
   }
   
   function NAComb649Remove($icomb_649_id) {
     if (!$this->db_obj) {
        $this->db_obj = new db();
      }
     
     $ssql = sprintf("DELETE FROM `tbl_comb_649` WHERE `icomb_649_id` = %u", $icomb_649_id);
     print "\n" . $ssql;
     
     $rows_affect = $this->db_obj->exec($ssql);
     return $rows_affect;
     
   }
   
   function NAComb649GetId($snum1, $snum2, $snum3, $snum4, $snum5, $snum6)
   {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT * FROM `tbl_comb_649` WHERE ");
      $ssql .= sprintf(" snum1 = %u AND snum2 = %u AND snum3 = %u AND snum4 = %u AND snum5 = %u AND snum6 = %u", 
                $snum1, $snum2, $snum3, $snum4, $snum5, $snum6);
                
      $db_res = $this->db_obj->fetch($ssql);
      if (!is_array($db_res)) {
        return $db_res[0]["icomb_649_id"];
      } else {
        return null;
      }
   }
   
   
   
   function NAComb649Get($icomb_id)
   {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT * FROM `tbl_comb_649` WHERE ");
      $ssql .= sprintf(" icomb_649_id = %u", 
                $icomb_id);
                
      $db_res = $this->db_obj->fetch($ssql);
      if (!is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
   }
  
  
  // Max
  /*
   * 
   * INSERT INTO `dbaLotteries`.`tbl_comb_max`
(`icomb_max_id`,
`snum1`,
`snum2`,
`snum3`,
`snum4`,
`snum5`,
`snum6`,
`snum7`)
VALUES
(
{icomb_max_id: INT},
{snum1: INT},
{snum2: INT},
{snum3: INT},
{snum4: INT},
{snum5: INT},
{snum6: INT},
{snum7: INT}
);

   * 
   * 
   */
  
  function NACombMaxAdd($snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7) {
    
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("INSERT INTO `tbl_comb_max` (`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snum7`) ");
      $ssql .= sprintf(" VALUES(%u, %u, %u, %u, %u, %u, %u)", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7);
      
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;
  }
  
  function NACombMaxRemove($icomb_max_id) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("DELETE FROM `tbl_comb_max` WHERE icomb_max_id = %u", $icomb_max_id);
      $rows_affected = $this->db_obj->exec($ssql);
      return $rows_affected;
    
  }
  
  function NACombMaxGetId($snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_comb_max` WHERE ");
      $ssql .= sprintf(" snum1 = %u AND snum2 = %u AND snum3 = %u AND snum4 = %u AND snum5 = %u AND snum6 = %u AND snum7 = %u",
                      $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0]["icomb_max_id"];
      } else {
        return null;
      }
    
  }
  
  
  
  function NACombMaxGet($icomb_id) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("SELECT * FROM `tbl_comb_max` WHERE ");
      $ssql .= sprintf(" icomb_max_id = %u",
                      $icomb_id);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
    
  }
  
  
  // 49
  /*
   * INSERT INTO `dbaLotteries`.`tbl_comb_49`
(`icomb_49_id`,
`snum1`,
`snum2`,
`snum3`,
`snum4`,
`snum5`,
`snum6`)
VALUES
(
{icomb_49_id: INT},
{snum1: INT},
{snum2: INT},
{snum3: INT},
{snum4: INT},
{snum5: INT},
{snum6: INT}
);
   * 
   * 
   */
  
  function OLGComb49Add($snum1, $snum2, $snum3, $snum4, $snum5, $snum6)
  {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
    
      $ssql = sprintf("INSERT INTO `tbl_comb_49` (`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`) ");
      $ssql .= sprintf(" VALUES(%u, %u, %u, %u, %u, %u)", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6);
      
      $rows_affected = $this->db_obj->exec($ssql);
      return $this->db_obj->last_id;    
    
    
  }
  
  function OLGComb49Remove($icomb_49_id) {
    if (!$this->db_obj) {
      $this->db_obj = new db();
    }
  
    $ssql = sprintf("DELETE FROM `tbl_comb_49` WHERE icomb_49_id = %u", $icomb_49_id);
    $rows_affected = $this->db_obj->exec($ssql);
    
    return $rows_affected;
  }
  
  
  function OLGComb49GetId($snum1, $snum2, $snum3, $snum4, $snum5, $snum6)
  {
    if (!$this->db_obj) {
      $this->db_obj = new db();
    }
  
    $ssql = sprintf("SELECT * FROM `tbl_comb_49` WHERE ");
    $ssql .= sprintf(" snum1 = %u AND snum2 = %u AND snum3 = %u AND snum4 = %u AND snum5 = %u AND snum6 - %u",
                  $snum1, $snum2, $snum3, $snum4, $snum5, $snum6);
    $db_res = $this->db_obj->fetch($ssql);
    if (is_array($db_res)) {
      return $db_res[0]["icomb_49_id"];
    } else {
      return null;
    }
    
    
  }
  
  function OLGComb49Get($icomb_id)
  {
    if (!$this->db_obj) {
      $this->db_obj = new db();
    }
  
    $ssql = sprintf("SELECT * FROM `tbl_comb_49` WHERE ");
    $ssql .= sprintf(" icomb_49_id = %u",
                  $icomb_id);
    $db_res = $this->db_obj->fetch($ssql);
    if (is_array($db_res)) {
      return $db_res[0];
    } else {
      return null;
    }
    
    
  }
  
  
  /*
   * INSERT INTO `dbaLotteries`.`tbl_comb_poker`
(`icomb_poker_id`,
`scard1`,
`scard2`,
`scard3`,
`scard4`,
`scard5`)
VALUES
(
{icomb_poker_id: INT},
{scard1: VARCHAR},
{scard2: VARCHAR},
{scard3: VARCHAR},
{scard4: VARCHAR},
{scard5: VARCHAR}
);
   * 
   */ 
    
   function OLGCombPokerAdd($scard1, $scard2, $scard3, $scard4, $scard5) {
    if (!$this->db_obj) {
      $this->db_obj = new db();
    }
    $ssql = sprintf("INSERT INTO `tbl_comb_poker` (`scard1`,`scard2`,`scard3`,`scard4`,`scard5`) ");
    $ssql .= sprintf(" VALUES('%s', '%s', '%s', '%s', '%s')", $scard1, $scard2, $scard3, $scard4, $scard5);
    
    $rows_affected = $this->db_obj->exec($ssql);
    return $this->db_obj->last_id;
    
    
   }
   
   function OLGCombPokerRemove($icomb_poker_id) {
    if (!$this->db_obj) {
      $this->db_obj = new db();
    }
    $ssql = sprintf("DELETE FROM `tbl_comb_poker` WHERE icomb_poker_id = %u", $icomb_poker_id);
    $rows_affected = $this->db_obj->exec($ssql);
    return $rows_affected; 
   }
   
   function OLGCombPokerGetId($scard1, $scard2, $scard3, $scard4, $scard5) {
    if (!$this->db_obj) {
      $this->db_obj = new db();
    }
    
    $ssql = sprint("SELECT * FROM `tbl_comb_poker` ");
    $ssql .= sprintf(" WHERE scard1 = '%s' AND scard2 = '%s' AND scard3 = '%s' AND scard4 = '%s' AND scard5 = '%s'",
                      $scard1, $scard2, $scard3, $scard4, $scard5);
    $db_res = $this->db_obj->fetch($ssql);
    if (is_array($db_res)) {
      return $db_res[0]["icomb_poker_id"];
    } else {
      return null;
    }
   }
   
   
   
   function OLGCombPokerGet($icomb_id) {
    if (!$this->db_obj) {
      $this->db_obj = new db();
    }
    
    $ssql = sprint("SELECT * FROM `tbl_comb_poker` ");
    $ssql .= sprintf(" WHERE icomb_poker_id = %u",
                      $icomb_id);
    $db_res = $this->db_obj->fetch($ssql);
    if (is_array($db_res)) {
      return $db_res[0];
    } else {
      return null;
    }
   }
   
   
   /* 
   * 
INSERT INTO `dbaLotteries`.`tbl_comb_pick4`
(`icomb_pick4_id`,
`snum1`,
`snum2`,
`snum3`,
`snum4`)
VALUES
(
{icomb_pick4_id: INT},
{snum1: INT},
{snum2: INT},
{snum3: INT},
{snum4: INT}
);
    * 
    * 
    */
    
    function OLGCombPick4Add($snum1, $snum2, $snum3, $snum4) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_comb_pick4` (`snum1`,`snum2`,`snum3`,`snum4`) ");
      $ssql .= sprintf(" VALUES(%u, %u, %u, %u)", $snum1, $snum2, $snum3, $snum4);
      
      $rows_affected = $this->db_obj->exec($ssql);
      return $rows_affected;
    }
    
    function OLGCombPick4Remove($icomb_pick4_id) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
      }
      
      $ssql = sprintf("DELETE FROM `tbl_comb_pick4` WHERE icomb_pick4_id = %u", $icomb_pick4_id);
      $rows_affected = $this->db_obj->exec($ssql);
      
      return $rows_affected;
    }
    
     function OLGCombPick4GetId($snum1, $snum2, $snum3, $snum4) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_comb_pick4` WHERE ");
      $ssql .= sprintf(" snum1 = %u AND snum2 = %u AND snum3 = %u AND snum4 = %u", 
                        $snum1, $snum2, $snum3, $snum4);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0]["icomb_pick4_id"];
      } else {
        return null;
      }
     }
     
     
     function OLGCombPick4Get($icomb_id) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
      }
      
      $ssql = sprintf("SELECT * FROM `tbl_comb_pick4` WHERE ");
      $ssql .= sprintf(" icomb_pick4_id = %u", 
                        $icomb_id);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
     }
     
    /* 
    * 
INSERT INTO `dbaLotteries`.`tbl_comb_pick3`
(`icomb_pick3_id`,
`snum1`,
`snum2`,
`snum3`)
VALUES
(
{icomb_pick3_id: INT},
{snum1: INT},
{snum2: INT},
{snum3: INT}
);
     * 
     */
     
     
     function OLGCombPick3Add($snum1, $snum2, $snum3) {
       
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
       $ssql = sprintf("INSERT INTO `tbl_comb_pick3` (`snum1`,`snum2`,`snum3`) ");
       $ssql .= sprintf(" VALUES(%u, %u, %u)", $snum1, $snum2, $snum3);
       
       $rows_affected = $this->db_obj->exec($ssql);
       return $this->db_obj->last_id; 
       
     }
     
     function OLGCombPick3Remove($icomb_pick3_id) {
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       $ssql = sprintf("DELETE FROM `tbl_comb_pick3` WHERE icomb_pick3_id = %u", $icomb_pick3_id);
       $rows_affected = $this->db_obj->exec($ssql);
       return $rows_affected;
       
     }
     
     function OLGCombPick3GetId($snum1, $snum2, $snum3) {
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       $ssql = sprintf("SELECT * FROM `tbl_comb_pick3` WHERE ");
       $ssql .= sprintf(" snum1 = %u AND snum2 = %u AND snum3 = %u", $snum1, $snum2, $snum3);
       
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res[0]["icomb_pick3_id"];
       } else {
         return null;
       }
       
     }
      
      
     function OLGCombPick3Get($icomb_id) {
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       $ssql = sprintf("SELECT * FROM `tbl_comb_pick3` WHERE ");
       $ssql .= sprintf(" icomb_pick3_id = %u", $icomb_id);
       
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res[0];
       } else {
         return null;
       }
       
     }
      
 
      /* 
INSERT INTO `dbaLotteries`.`tbl_comb_lottario`
(`icomb_lottario_id`,
`snum1`,
`snum2`,
`snum3`,
`snum4`,
`snum5`,
`snum6`)
VALUES
(
{icomb_lottario_id: INT},
{snum1: INT},
{snum2: INT},
{snum3: INT},
{snum4: INT},
{snum5: INT},
{snum6: INT}
);
       * 
       */ 
       
       function OLGCombLottarioAdd($snum1, $snum2, $snum3, $snum4, $snum5, $snum6) {
          if (!$this->db_obj) {
            $this->db_obj = new db();
          }
          
          $ssql = sprintf("INSERT INTO `tbl_comb_lottario` (`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`) ");
          $ssql .= sprintf(" VALUES(%u, %u, %u, %u, %u, %u)", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6);
          
          $rows_affected = $this->db_obj->exec($ssql);
          return $this->db_obj->last_id;
       }
       
       function OLGCombLottarioRemove($icomb_lottario_id) {
           
         if (!$this->db_obj) {
            $this->db_obj = new db();
          }
          
          $ssql = sprintf("DELETE FROM `tbl_comb_lottario` WHERE icomb_lottario_id = %u", $icomb_lottario_id);
          $rows_affected = $this->db_obj->exec($ssql);
          return $rows_affected;
         
       }
       
       function OLGCombLottarioGetId($snum1, $snum2, $snum3, $snum4, $snum5, $snum6) {
         if (!$this->db_obj) {
            $this->db_obj = new db();
          }
         
         $ssql = sprintf("SELECT * FROM `tbl_comb_lottario` ");
         $ssql .= sprintf(" WHERE snum1 = %u AND snum2 = %u AND snum3 = %u AND snum4 = %u AND snum5 = %u AND snum6 = %u",
                  $snum1, $snum2, $snum3, $snum4, $snum5, $snum6);
         $db_res = $this->db_obj->fetch($ssql);
         if (is_array($db_res)) {
           return $db_res[0]["icomb_lottario_id"];
         } else {
           return null;
         }
         
         
       }
       
       
       
       function OLGCombLottarioGet($icomb_id) {
         if (!$this->db_obj) {
            $this->db_obj = new db();
          }
         
         $ssql = sprintf("SELECT * FROM `tbl_comb_lottario` ");
         $ssql .= sprintf(" WHERE icomb_lottario_id = %u",
                  $icomb_id);
         $db_res = $this->db_obj->fetch($ssql);
         if (is_array($db_res)) {
           return $db_res[0];
         } else {
           return null;
         }
         
         
       }
       
       /* 
INSERT INTO `dbaLotteries`.`tbl_comb_keno`
(`icomb_keno_id`,
`snum1`,
`snum2`,
`snum3`,
`snum4`,
`snum5`,
`snum6`,
`snum7`,
`snum8`,
`snum9`,
`snum10`)
VALUES
(
{icomb_keno_id: INT},
{snum1: INT},
{snum2: INT},
{snum3: INT},
{snum4: INT},
{snum5: INT},
{snum6: INT},
{snum7: INT},
{snum8: INT},
{snum9: INT},
{snum10: INT}
);
        * 
        */ 
       
    function OLGCombKenoAdd($iCategory, $incr_by, $snum1 = "", $snum2 = "", $snum3 = "", $snum4 = "", $snum5 = "", $snum6 = "", $snum7 = "", $snum8 = "", $snum9 = "", $snum10 = "", $snum11 = "", $snum12 = "", $snum13 = "", $snum14 = "", $snum15 = "", $snum16 = "", $snum17 = "", $snum18 = "", $snum19 = "", $snum20 = "") {
         if (!$this->db_obj) {
            $this->db_obj = new db();
          }
        
        $ssql1 = sprintf("INSERT INTO `tbl_comb_keno` (`iCategory`, `incr_by`, `snum1`");
        $ssql2 = sprintf(" VALUES (%u, %u, %u", $iCategory, $incr_by, $snum1);
        
        
        
        
        if ($iCategory >= 2) {
        	$ssql1 .= sprintf(",`snum2`");
        	$ssql2 .= sprintf(", %u", $snum2);
        }
        if ($iCategory >= 3) {
        	$ssql1 .= sprintf(",`snum3`");
        	$ssql2 .= sprintf(", %u", $snum3);        
        }
        if ($iCategory >= 4) {
            $ssql1 .= sprintf(",`snum4`");
        	$ssql2 .= sprintf(", %u", $snum4);
        }
        if ($iCategory >= 5) {
            $ssql1 .= sprintf(",`snum5`");
        	$ssql2 .= sprintf(", %u", $snum5);
        }
        if ($iCategory >= 6) {
            $ssql1 .= sprintf(",`snum6`");
        	$ssql2 .= sprintf(", %u", $snum6);
        } 
        if ($iCategory >= 7) {
            $ssql1 .= sprintf(",`snum7`");
        	$ssql2 .= sprintf(", %u", $snum7);
        }
        if ($iCategory >= 8) {
            $ssql1 .= sprintf(",`snum8`");
        	$ssql2 .= sprintf(", %u", $snum8);
        }
        if ($iCategory >= 9) {
        	$ssql1 .= sprintf(",`snum9`");
        	$ssql2 .= sprintf(", %u", $snum9);
        }
        if ($iCategory >= 10) {
            $ssql1 .= sprintf(",`snum10`");
        	$ssql2 .= sprintf(", %u", $snum10);
        }
        
        if ($iCategory >= 11) {
            $ssql1 .= sprintf(",`snum11`");
        	$ssql2 .= sprintf(", %u", $snum11);
        }
        
        if ($iCategory >= 12) {
        	$ssql1 .= sprintf(",`snum12`");
        	$ssql2 .= sprintf(", %u", $snum12);
        }
        if ($iCategory >= 13) {
        	$ssql1 .= sprintf(",`snum13`");
        	$ssql2 .= sprintf(", %u", $snum13);        
        }
        if ($iCategory >= 14) {
            $ssql1 .= sprintf(",`snum14`");
        	$ssql2 .= sprintf(", %u", $snum14);
        }
        if ($iCategory >= 15) {
            $ssql1 .= sprintf(",`snum15`");
        	$ssql2 .= sprintf(", %u", $snum15);
        }
        if ($iCategory >= 16) {
            $ssql1 .= sprintf(",`snum16`");
        	$ssql2 .= sprintf(", %u", $snum16);
        } 
        if ($iCategory >= 17) {
            $ssql1 .= sprintf(",`snum17`");
        	$ssql2 .= sprintf(", %u", $snum17);
        }
        if ($iCategory >= 18) {
            $ssql1 .= sprintf(",`snum18`");
        	$ssql2 .= sprintf(", %u", $snum18);
        }
        if ($iCategory >= 19) {
        	$ssql1 .= sprintf(",`snum19`");
        	$ssql2 .= sprintf(", %u", $snum19);
        }
        if ($iCategory == 20) {
            $ssql1 .= sprintf(",`snum20`");
        	$ssql2 .= sprintf(", %u", $snum20);
        }        
        $ssql = $ssql1 . ") " . $ssql2 . ")";
        $rows_affected = $this->db_obj->exec($ssql);
        return $this->db_obj->last_id;
              
    }
         
         
     function OLGCombKenoRemove($icomb_keno_id) {
         
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("DELETE FROM `tbl_combo_keno` WHERE icomb_keno_id = %u", $icomb_keno_id);
        $rows_affected = $this->db_obj->exec($ssql);
        return $rows_affected;
            
     } 
     
     function OLGCombKenoGetId ($iCategory, $incr_by, $snum1, $snum2, $snum3 = "", $snum4 = "", $snum5 = "", $snum6 = "", $snum7 = "", $snum8 = "", $snum9 = "", $snum10 = "", $snum11 = "", $snum12 = "", $snum13 = "", $snum14 = "", $snum15 = "", $snum16 = "", $snum17 = "", $snum18 = "", $snum19 = "", $snum20 = "") {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        
    	if ($iCategory >= 2) {
    		$ssql1 = sprintf(" incr_by = %u AND iCategory = %u AND snum1 = %u AND snum2 = %u ", $incr_by, $iCategory, $snum1, $snum2);
    	}
    	if ($iCategory >= 3) {
    		$ssql1 .= sprintf(" AND snum3 = %u", $snum3);
    	}
    	if ($iCategory >= 4) {
    		$ssql1 .= sprintf(" AND snum4 = %u", $snum4);
    	}
    	if ($iCategory >= 5) {
    		$ssql1 .= sprintf(" AND snum5 = %u", $snum5);
    	} 
    	if ($iCategory >= 6) {
    		$ssql1 .= sprintf(" AND snum6 = %u", $snum6);
    	} 
    	if ($iCategory >= 7) {
    		$ssql1 .= sprintf(" AND snum7 = %u", $snum7);
    	} 
    	if ($iCategory >= 8) {
    		$ssql1 .= sprintf(" AND snum8 = %u", $snum8);
    	} 
    	if ($iCategory >= 9) {
    		$ssql1 .= sprintf(" AND snum9 = %u", $snum9);
    	}
    	if ($iCategory >= 10) {
    		$ssql1 .= sprintf(" AND snum10 = %u", $snum10);
    	}
    	
    	      
        if ($iCategory >= 11) {

        	$ssql1 .= sprintf(" AND snum11 = %u", $snum11);
        }
        
        if ($iCategory >= 12) {

        	$ssql1 .= sprintf(" AND snum12 = %u", $snum12);
        }
        if ($iCategory >= 13) {

        	$ssql1 .= sprintf(" AND snum13 = %u", $snum13);        
        }
        if ($iCategory >= 14) {

        	$ssql1 .= sprintf(" AND snum14 = %u", $snum14);
        }
        if ($iCategory >= 15) {

        	$ssql1 .= sprintf(" AND snum15 = %u", $snum15);
        }
        if ($iCategory >= 16) {

        	$ssql .= sprintf(" AND snum16 = %u", $snum16);
        } 
        if ($iCategory >= 17) {

        	$ssql1 .= sprintf(" AND snum17 = %u", $snum17);
        }
        if ($iCategory >= 18) {

        	$ssql1 .= sprintf(" AND snum18 = %u", $snum18);
        }
        if ($iCategory >= 19) {

        	$ssql1 .= sprintf(" AND snum19 = %u", $snum19);
        }
        if ($iCategory == 20) {

        	$ssql1 .= sprintf(" AND snum20 = %u", $snum20);
        }        
    	
    	
    	
    	
        
       $ssql = sprintf("SELECT * FROM `tbl_combo_keno` WHERE ");
       $ssql .= $ssql1;
                        
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res[0]["icomb_keno_id"];
       } else {
         return null;
       }
     }
     
     function OLGCombKenoOccurAdd($icomb_keno_id, $sdrawdate, $i_adj) {
     	if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("INSERT INTO `tbl_keno_comb_occur` (`icomb_id`, `occur_date`, `adj_`) ");
        $ssql .= sprintf(" VALUES (%u, '%s', %u)", $icomb_keno_id, $sdrawdate, $i_adj);
        
        $rows_affected = $this->db_obj->exec($ssql);
        return $this->db_obj->last_id;
     
     }
     function OLGCombKenoOccurSet($icomb_keno_id, $sdrawdate, $adj_) {
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
      
      $ssql = sprintf("UPDATE `tbl_keno_comb_occur` SET `adj_` = %u WHERE `icomb_id` = %u AND `occur_date` = '%s'",
      				$adj_, $icomb_keno_id, $sdrawdate);
      $rows_affected = $this->db_obj->exec($ssql);
      return $rows_affected;
     }
     function OLGCombKenoOccurGet($icomb_keno_id, $sdrawdate) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_keno_comb_occur` WHERE icomb_id = %u AND occur_date = '%s'", $icomb_keno_id, $sdrawdate);
		$db_res = $this->db_obj->fetch($ssql);
		
		if (is_array($db_res)) {
			return $db_res[0];
		} else {
			return null;
		}
     }
     function OLGCombKenoStatsAdd($icomb_keno_id, $sdrawdate, $i_match) {
     	if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
     	$ssql = sprintf("INSERT INTO `tbl_keno_comb_stats` (`icomb_keno_id`, `drawdate`, `i_match`) ");
     	$ssql .= sprintf(" VALUES (%u, '%s', %u)", $icomb_keno_id, $sdrawdate, $i_match);
     
		$rows_affected = $this->db_obj->exec($ssql);
        return $this->db_obj->last_id;
     
     }
     
     function OLGCombKenoStatsRemove($icomb_keno_id, $sdrawdate) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
     	$ssql = sprintf("DELETE FROM `tbl_keno_comb_stats` WHERE icomb_keno_id = %u AND drawdate = '%s'",
     			$icomb_keno_id, $sdrawdate);
     	$rows_affected = $this->db_obj->exec($ssql);
     	return $rows_affected;
     }
     
     function OLGCombKenoStatsGetById ($icomb_keno_id) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_keno_comb_stats` WHERE icomb_keno_id = %u", $icomb_keno_id);

        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res;
        } else {
          return null;
        }        
        
     	
     }
     
     
     function OLGCombKenoStatsGetId ($icomb_keno_id, $sdrawdate) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_keno_comb_stats` WHERE icomb_keno_id = %u AND drawdate = '%s'", $icomb_keno_id,  $sdrawdate);

        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res[0]["i_match"];
        } else {
          return null;
        }        
        
     	
     }
     
     
     
     function OLGCombKenoStatsGet ( $sdrawdate) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_keno_comb_stats` WHERE drawdate = '%s'",  $sdrawdate);

        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res;
        } else {
          return null;
        }        
        
     	
     }
     
     
     
     
     
     function OLGCombKenoGet ($icomb_keno_id) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        
       $ssql = sprintf("SELECT * FROM `tbl_combo_keno` WHERE icomb_keno_id = %u", $icomb_id);
                       
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res[0];
       } else {
         return null;
       }
     }
     
       /* 
        * 
INSERT INTO `dbaLotteries`.`tbl_comb_early_bird`
(`icomb_early_bird_id`,
`snum1`,
`snum2`,
`snum3`,
`snum4`)
VALUES
(
{icomb_early_bird_id: INT},
{snum1: INT},
{snum2: INT},
{snum3: INT},
{snum4: INT}
);
   * 
   */
   
   
   function OLGCombEncoreAdd( $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7 ) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
   		$ssql = sprintf("INSERT INTO `tbl_comb_encore` (`snum1`, `snum2`, `snum3`, `snum4`, `snum5`, `snum6`, `snum7`) ");
   		$ssql .= sprintf(" VALUES (%u, %u, %u, %u, %u, %u, %u)", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7 );
   		
   		$rows_affected = $this->db_obj->exec($ssql);
        return $this->db_obj->last_id;
   	}
   
   
   function OLGCombEncoreRemove($icomb_encore_id) {
	   if (!$this->db_obj) {
	       $this->db_obj = new db();
    	}
   
   		$ssql = sprintf("DELETE FROM `tbl_comb_encore` WHERE icomb_encore_id = %u", $icomb_encore_id);
   		
		$rows_affected = $this->db_obj->exec($ssql);
		return $rows_affected;
   
   }
   
   function OLGCombEncoreGetId( $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7 ) {
   	   if (!$this->db_obj) {
	       $this->db_obj = new db();
    	}
    	
    	$ssql = sprintf("SELECT * FROM `tbl_comb_encore` WHERE snum1 = %u AND snum2 = %u AND snum3 = %u"
    			. " snum4 = %u AND snum5 = %u AND snum6 = %u AND snum7 = %u", $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7);
    	
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res[0]["icomb_encore_id"];
       } else {
         return null;
       }
   }
   
   
   function OLGCombEncoreGet( $icomb_id ) {
   	   if (!$this->db_obj) {
	       $this->db_obj = new db();
    	}
    	
    	$ssql = sprintf("SELECT * FROM `tbl_comb_encore` WHERE icomb_encore_id = %u", $icomb_id);
    	
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res[0];
       } else {
         return null;
       }
   }
   
   
     function OLGCombEarlyBirdAdd ($snum1, $snum2, $snum3, $snum4) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("INSERT INTO `tbl_comb_early_bird` (`snum1`,`snum2`,`snum3`,`snum4`) ");
        $ssql .= sprintf(" VALUES(%u, %u, %u, %u)", $snum1, $snum2, $snum3, $snum4);
        
        $rows_affected = $this->db_obj->exec($ssql);
        return $rows_affected;  
     }
     
     function OLGCombEarlyBirdRemove($icomb_early_bird_id) {
         if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("DELETE FROM `tbl_comb_early_bird` WHERE icomb_early_bird_id = %u", $icomb_early_bird_id);
        $rows_affected = $this->db_obj->exec($ssql);
        return $rows_affected; 
     }
   
    function OLGCombEarlyBirdGetId($snum1, $snum2, $snum3, $snum4) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_comb_early_bird` WHERE snum1 = %u AND snum2 = %u AND snum3 = %u AND snum4 = %u",
                   $snum1, $snum2, $snum3, $snum4);
        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res[0]["icomb_early_bird_id"];
        } else {
          return null;
        }
      
    }
    
    
    
    
    function OLGCombEarlyBirdGet($icomb_id) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_comb_early_bird` WHERE  icomb_early_bird_id = %u",
                   $icomb_id);
        $db_res = $this->db_obj->fetch($ssql);
        if (is_array($db_res)) {
          return $db_res[0];
        } else {
          return null;
        }
      
    }
  // Lottario
  
  // Keno
  
  // Pick 4
  
  // Pick 3
  
  // Poker
  
}


?>