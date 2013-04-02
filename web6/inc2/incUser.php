<?php
/*
 * 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.

*/
 include_once("class_db.php");
 include_once("incCombOLGLottery.php");
 
 class User {
   
   /*
    * 
    * 
    * INSERT INTO `dbaLotteries`.`tbl_user`
(`iUserNo`,
`sUserName`,
`sFirstName`,
`sLastName`,
`sEmailAddr`,
`sPasswd`,
`sNickName`,
`sLastLogin`,
`sFirstLogin`,
`AccessCount`)
VALUES
(
{iUserNo: INT},
{sUserName: VARCHAR},
{sFirstName: VARCHAR},
{sLastName: VARCHAR},
{sEmailAddr: VARCHAR},
{sPasswd: VARCHAR},
{sNickName: VARCHAR},
{sLastLogin: DATETIME},
{sFirstLogin: DATETIME},
{AccessCount: INT}
);
    * 
    * 
    * 
class User { 
  var $db = null; // PEAR::DB pointer 
  var $failed = false; // failed login attempt 
  var $date; // current date GMT 
  var $id = 0; // the current user's id 

  function User(&$db) { 
    $this->db = $db; 
    $this->date = $GLOBALS['date']; 
    if ($_SESSION['logged']) { 
        $this->_checkSession(); 
    } elseif ( isset($_COOKIE['mtwebLogin']) ) { 
        $this->_checkRemembered($_COOKIE['mtwebLogin']); 
    } 
   }
    * 
  function _checkLogin($username, $password, $remember) { 
    $username = $this->db->quote($username); 
    $password = $this->db->quote(md5($password)); 
    $sql = "SELECT * FROM member WHERE " . 
        "username = $username AND " . 
        "password = $password"; 
    $result = $this->db->getRow($sql); 
    if ( is_object($result) ) { 
      $this->_setSession($result, $remember); 
      return true; 
    }  else { 
      $this->failed = true; 
      $this->_logout(); 
      return false; 
    } 
  }
 function _setSession(&$values, $remember, $init = true) { 
    $this->id = $values->id; 
    $_SESSION['uid'] = $this->id; 
    $_SESSION['username'] = htmlspecialchars($values->username); 
    $_SESSION['cookie'] = $values->cookie; 
    $_SESSION['logged'] = true; 
    if ($remember) { 
      $this->updateCookie($values->cookie, true); 
    } 
    if ($init) { 
      $session = $this->db->quote(session_id()); 
      $ip = $this->db->quote($_SERVER['REMOTE_ADDR']);

      $sql = "UPDATE member SET session = $session, ip = $ip WHERE " . 
        "id = $this->id"; 
      $this->db->query($sql); 
    } 
  }
 function updateCookie($cookie, $save) { 
    $_SESSION['cookie'] = $cookie; 
    if ($save) { 
      $cookie = serialize(array($_SESSION['username'], $cookie) ); 
      set_cookie('mtwebLogin', $cookie, time() + 31104000, '/directory/'); 
    } 
  }
  function _checkRemembered($cookie) { 
    list($username, $cookie) = @unserialize($cookie); 
    if (!$username or !$cookie) return; 
        $username = $this->db->quote($username); 
        $cookie = $this->db->quote($cookie); 
        $sql = "SELECT * FROM member WHERE " . 
          "(username = $username) AND (cookie = $cookie)"; 
        $result = $this->db->getRow($sql); 
        if (is_object($result) ) { 
           $this->_setSession($result, true); 
        } 
  }
  function _checkSession() { 
    $username = $this->db->quote($_SESSION['username']); 
    $cookie = $this->db->quote($_SESSION['cookie']); 
    $session = $this->db->quote(session_id()); 
    $ip = $this->db->quote($_SERVER['REMOTE_ADDR']); 
    $sql = "SELECT * FROM member WHERE " . 
        "(username = $username) AND (cookie = $cookie) AND " . 
        "(session = $session) AND (ip = $ip)"; 
    $result = $this->db->getRow($sql); 
    if (is_object($result) ) { 
      $this->_setSession($result, false, false); 
    } else { 
      $this->_logout(); 
    } 
  }
 function session_defaults() { 
    $_SESSION['logged'] = false; 
    $_SESSION['uid'] = 0; 
    $_SESSION['username'] = ''; 
    $_SESSION['cookie'] = 0; 
    $_SESSION['remember'] = false; 
 }
if (!isset($_SESSION['uid']) ) { 
  session_defaults(); 
}
    *     *    * 
    * 
    * 
    * 
    * 
    * 
    * 
    */
    
    //creates a 10 character sequence
    function createSalt()
    {
        $string = md5(uniqid(rand(), true));
        return substr($string, 0, 10);
    }
    
    function UserAdd($sUserName, $sFirstName, $sLastName, $sEmailAddr, $sPasswd, $sNickName) {
      
       // Mysql Password is encrypted in SHA
       
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      // Added salt verfication to password authentication // 
      // mysql's SHA1 -> password plus salt
      $salt = $this->createSalt();
      
      
      $ssql = sprintf("INSERT INTO `tbl_user` (`sUserName`,`sFirstName`,`sLastName`,`sEmailAddr`,`sPasswd`, `sSalt`, `sNickName`) ");
      $ssql .= sprintf(" VALUES('%s', '%s', '%s', '%s', SHA1('%s'), '%s', '%s')",
                    $sUserName, $sFirstName, $sLastName, strtolower($sEmailAddr), $salt.$sPasswd, $salt,  $sNickName);
      //print "SSQL: " . $ssql;
      $rows_affected = $this->db_obj->exec($ssql);
      if ($rows_affected > 0) {
        return $this->db_obj->last_id;           
      } else {
        return null;
      }     
    }
    
    

    
    /*
     * 
     * INSERT INTO `dbaLotteries`.`tbl_user_session`
(`session`,
`cookie`,
`userNo`,
`create_date`,
`last_access`)
VALUES
(
{session: VARCHAR},
{cookie: VARCHAR},
{userNo: INT},
{create_date: DATETIME},
{last_access: DATETIME}
);
     * 
     * 
     */ 
    
    function UserSessionAdd($session, $cookie, $userNo, $create_date, $last_access) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      
      $ssql = sprintf("INSERT INTO `tbl_user_session` (`session`,`cookie`,`userNo`,`create_date`,`last_access`) ");
      $ssql .= sprintf(" VALUES ('%s', '%s', %u, '%s', '%s')", $session, $cookie, $userNo, $create_date, $last_access);
      
      $rows_affected = $this->db_obj->exec($ssql);
      return $rows_affected;
    }
    
    
    function UserSessionModify($oldsession, $session, $cookie, $userNo, $create_date, $last_access) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("UPDATE `tbl_user_session` SET `session` = '%s' , `cookie` = '%s', 
                            `userNo` = %u, `create_date` = '%s',`last_access` = '%s' FROM `tbl_user_session` WHERE `session` = '%s'",
                          $session, $cookie, $userNo, $create_date, $last_access, $oldsession);
      $rows_affected = $this->db_obj->exec($ssql);
      return $rows_affected;
    }
    
    function UserSessionLastMod($session, $userNo, $last_access) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("UPDATE `tbl_user_session` SET `last_access` = '%s' FROM `tbl_user_session` WHERE `session` = '%s' AND `userNo` = %u",
                      $last_access, $session, $userNo );
      $rows_affected = $this->db_obj->exec($ssql);
      return $rows_affected;
    }
    
    function UserSessionRemove($session, $cookie) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("DELETE FROM `tbl_user_session` WHERE `session` = '%s' AND `cookie` = '%s'", $session, $cookie);
      $rows_affected = $this->db_obj->exec($ssql);
      return $rows_affected;
    }
    
    function UserRemove($iUserNo) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("DELETE FROM `tbl_user` WHERE iUserNo = %u", $iUserNo);
      $rows_affected = $this->db_obj->exec($ssql);
      return $rows_affected;
    }
     
    function UserEmailExists($sEmailAddr) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }   
      
      $ssql = sprintf("SELECT * FROM `tbl_user` WHERE sEmailAddr = '%s'", $sEmailAddr);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0]["iUserNo"];
      } else {
        return null;
      }
      
    }
    // added Sep 14 - 2011
    // gets user no based on email addr
    function UserGetNo($sEmailAddr) {
    	if (!$this->db_obj) {
          $this->db_obj = new db();
        }
        
        $ssql = sprintf("SELECT * FROM `tbl_user` WHERE sEmailAddr = '%s'", $sEmailAddr);
        $db_res = $this->db_obj->fetch($ssql);
	    if (is_array($db_res)) {
	    	return $db_rs[0]["iUserNo"];
	    } else {
	    	return null;
	    }
        
    
    }
    function UserGetId($sEmailAddr, $sPasswd) {
      if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       // Mysql Password is encrypted in SHA
       $ssql = sprintf("SELECT * FROM `tbl_user` WHERE sEmailAddr = '%s'", $sEmailAddr);
       $db_res = $this->db_obj->fetch($ssql);
       //print_r($db_res);
       if (is_array($db_res)) {
           
         $salt = $db_res[0]["sSalt"];
         $ssql = sprintf("SELECT * FROM `tbl_user` WHERE sEmailAddr = '%s' AND sPasswd = SHA1('%s')",
                  $sEmailAddr, $salt.$sPasswd);
         //print "\n SSQL: " . $ssql;
         $db_rs = $this->db_obj->fetch($ssql);
         //print_r($db_rs);
         if (is_array($db_rs)) {
           return $db_rs[0]["iUserNo"];           
         } else {
           return null;
         }
         

       } else {
         return null;
       }
    }
    
   function UserGet($iUserNo) {
      if (!$this->db_obj) {
        $this->db_obj = new db();
      }
      $ssql = sprintf("SELECT * FROM `tbl_user` WHERE ");
      $ssql .= sprintf(" iUserNo = %u", $iUserNo);
      
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
    }
    
    function validateUser($userNo)
    {
        session_regenerate_id (); //this is a security measure
        $_SESSION['valid'] = 1;
        $_SESSION['userid'] = $userid;
    }
    
    function isLoggedIn()
    {
        if($_SESSION['valid'])
            return true;
        return false;
    }
    
    function logout()
    {
        $_SESSION = array(); //destroy all of the session variables
        session_destroy();
    }
    
     function UserAuthenticate($sEmailAddr, $sPasswd) {
       if (!$this->db_obj) {
          $this->db_obj = new db();
        }
       // Mysql Password is encrypted in SHA
       $ssql = sprintf("SELECT * FROM `tbl_user` WHERE sEmailAddr = '%s'", $sEmailAddr);
       $db_res = $this->db_obj->fetch($ssql);
       
       //print_r($db_res);
       if (is_array($db_res)) {
           
         $salt = $db_res[0]["sSalt"];
         //print "PWD: " . sha1($salt.$sPasswd);
         $ssql = sprintf("SELECT * FROM `tbl_user` WHERE sEmailAddr = '%s' AND sPasswd = SHA1('%s')",
                  $sEmailAddr, $salt.$sPasswd);
         //print "\n SSQL: " . $ssql;
         $db_rs = $this->db_obj->fetch($ssql);
         //print_r($db_rs);
         if (is_array($db_rs)) {
           return $db_rs[0]["iUserNo"];           
         } else {
           return null;
         }
         

       } else {
         return null;
       }
      
    }    
    /* 
INSERT INTO `dbaLotteries`.`tbl_comb_play_hist`
(`icomb_play_hist_id`,
`iUserNo`,
`icomb_select_id`,
`gameId`,
`numPlayed`)
VALUES
(
{icomb_play_hist_id: BIGINT},
{iUserNo: INT},
{icomb_select_id: BIGINT},
{gameId: INT},
{numPlayed: INT}
);
     * 
     */ 
     
     function CombPlayHistAdd($iUserNo, $icomb_select_id, $gameId, $numPlayed) {
       if (!$this->db_obj) {
        $this->db_obj = new db();
        }
       $ssql = sprintf("INSERT INTO `tbl_comb_play_hist` (`iUserNo`,`icomb_select_id`,`gameId`,`numPlayed`) ");
        $ssql .= sprintf(" VALUES(%u, %u, %u, %u)", $iUserNo, $icomb_select_id, $gameId, $numPlayed);
        
        $rows_affected = $this->db_obj->exec($ssql);
        return $this->db_obj->last_id;
     }
     
     
     function CombPlayHistRemove($icomb_play_hist_id) {
       if (!$this->db_obj) {
        $this->db_obj = new db();
        }
       
       $ssql = sprintf("DELETE FROM `tbl_comb_play_hist` WHERE icomb_play_hist_id = %u", $icomb_play_hist_id);
       $rows_affected = $this->db_obj->exec($ssql);
       return $rows_affected;
     }
     
     function CombPlayHistGetId($iUserNo, $icomb_select_id, $gameId) {
       if (!$this->db_obj) {
        $this->db_obj = new db();
        }
       
       $ssql = sprintf("SELECT * FROM `tbl_comb_play_hist` WHERE ");
       $ssql .= sprintf(" iUserNo = %u AND icomb_select_id = %u AND gameId = %u", $iUserNo, $icomb_select_id, $gameId);
       
       $db_res = $this->db_obj->fetch($ssql);
       if (is_array($db_res)) {
         return $db_res[0]["icomb_play_hist_id"];
       } else {
         return null;
       }
     }
     /* 
INSERT INTO `dbaLotteries`.`tbl_comb_play_hist_detail`
(`icomb_play_hist_id`,
`playdate`,
`match_num`,
`match_code`,
`iprize_id`)
VALUES
(
{icomb_play_hist_id: BIGINT},
{playdate: DATETIME},
{match_num: INT},
{match_code: INT},
{iprize_id: INT}
);
    * 
    */
    
    function CombPlayHistDetailAdd($icomb_play_hist_id, $playdate, $match_num, $match_code, $prize_id) {
      if (!$this->db_obj) {
         $this->db_obj = new db();
      }
     
     $ssql = sprintf("INSERT INTO `tbl_comb_play_hist_detail` (`icomb_play_hist_id`,`playdate`,`match_num`,`match_code`,`iprize_id`) ");
     $ssql .= sprintf(" VALUES(%u, '%s', %u, %u)",$icomb_play_hist_id, $playdate, $match_num, $match_code, $prize_id );
     
     $rows_affected = $this->db_obj->exec($ssql);
     return $this->db_obj->last_id;
       
    }
   
   function CombPlayHistDetailRemove($icomb_play_hist_id, $play_date) {
      if (!$this->db_obj) {
         $this->db_obj = new db();
      }
     $ssql = sprintf("DELETE FROM `tbl_comb_play_hist_detail` WHERE `icomb_play_hist_id` = %u AND `playdate` = '%s'", $icomb_play_hist_id, $play_date);
     $rows_affected = $this->db_obj->exec($ssql);
     return $rows_affected;     
   }
   
   function CombPlayHistDetailGet($icomb_play_hist_id, $play_date) {
      if (!$this->db_obj) {
         $this->db_obj = new db();
      }
     $ssql = sprintf("SELECT * FROM `tbl_comb_play_hist_detail` WHERE `icomb_play_hist_id` = %u AND `playdate` = '%s'", $icomb_play_hist_id, $play_date);
      $db_res = $this->db_obj->fetch($ssql);
      if (is_array($db_res)) {
        return $db_res[0];
      } else {
        return null;
      }
   }
   
 }



?>