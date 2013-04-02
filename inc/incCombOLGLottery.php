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
   * 
   */
   
   var $db_obj; 
   
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
       
    function OLGCombKenoAdd($snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10) {
         if (!$this->db_obj) {
            $this->db_obj = new db();
          }
              
        $ssql = sprintf("INSERT INTO `tbl_comb_keno` (`snum1`,`snum2`,`snum3`,`snum4`,`snum5`,`snum6`,`snum7`,`snum8`,`snum9`,`snum10`) ");
        $ssql .= sprintf(" VALUES(%u, %u, %u, %u, %u, %u, %u, %u, %u, %u)",
                    $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10);
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
     
     function OLGCombKenoGetId ($snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10) {
        if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
       $ssql = sprintf("SELECT * FROM `tbl_combo_keno` WHERE ");
       $ssql .= sprintf(" snum1 = %u AND snum2 = %u AND snum3 = %u AND snum4 = %u AND snum5 = %u AND snum6 = %u AND snum7 = %u AND snum8 = %u AND snum9 = %u AND snum10 = %u",
                        $snum1, $snum2, $snum3, $snum4, $snum5, $snum6, $snum7, $snum8, $snum9, $snum10);
                        
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res[0]["icomb_keno_id"];
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
  // Lottario
  
  // Keno
  
  // Pick 4
  
  // Pick 3
  
  // Poker
  
}


?>