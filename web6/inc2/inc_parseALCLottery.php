<?php


  include_once("./class_db.php");

/*
 *  
 * tbl_alc_49
 tbl_alc_bucko
 tbl_alc_keno
 tbl_alc_pik4
 tbl_alc_tag
 * 
 * 
 * ALC LottoMax
 * http://corp.alc.ca/LottoMax.aspx?tab=2
 * http://corp.alc.ca/LottoMax.aspx?tab=2&date=20091107
 * 
 * ALC Lotto 649
 * http://corp.alc.ca/Lotto649.aspx?tab=2
 * http://corp.alc.ca/Lotto649.aspx?tab=2&date=20100101
 * 
 */
 
 class parseALCLottery {
   
   
    /*
     * Lotto Max
     *
     * [Draw Date]
     * [snum1] [snum2] [snum3] [snum4] [snum5] [snum6] [snum7] [snumbonus]
     * 
     * [mat7of7]        [location - numofprizes]  [przeamt]
     *                  
     * [mat6of7+bonus]  [location - numofprizes]  [przeamt]
     *                  
     * [mat6of7]        [numofprizes]  [przeamt]
     * [mat5of7]        [numofprizes]  [przeamt]
     * [mat4of7]        [numofprizes]  [przeamt]
     * [mat3of7+bonus]  [numofprizes]  [przeamt]
     * [mat3of7]        [numofprizes]  [przeamt]
     * 
     * 
     * --------------------------
     * 
     * Maxmillions
     * [snum1] [snum2] [snum3] [snum4] [snum5] [snum6] [snum7]
     * [quantity]       [location - numofprzes]      [przeamt]
     *  
     * 
     * drawdate
     * startdrawdate
     * enddrawdate
     */ 
     
     function parseMax($startdrawdate = "", $enddrawdate = "", $drawdate = "") {
       $startDrawDate = 
     }
    
    
    /*
     * Lotto 649
     * 
     * [Draw Date]
     * [snum1] [snum2] [snum3] [snum4] [snum5] [snum6] [snumbonus]
     * 
     * [mat6of6]              [location - numofprizes] [przeamt]
     * [mat5of6+bonus]        [location - numofprizes] [przeamt]
     * [mat5of6]              [numofprizes]            [przeamt]
     * [mat4of6]              [numofprizes]            [przeamt]
     * [mat3of6]              [numofprizes]            [przeamt]
     * [mat2of6+bonus]        [numofprizes]            [przeamt]
     * 
     * 
     */ 
    
    
    /*
     * Lotto ALC 49
     * 
     * [Draw Date]
     * [snum1] [snum2] [snum3] [snum4] [snum5] [snum6] [snumbonus]
     *
     * [mat6of6]            [location - numofprizes]  [przeamt]
     * [mat5of6 + bonus]    [location - numofprizes]  [przeamt]
     * [mat5of6]            [numofprizes]             [przeamt]
     * [mat4of6]            [numofprizes]             [przeamt]
     * [mat3of6]            [numofprizes]             [przeamt]
     * 
     */ 
    
    /*
     * ALC Tag
     * [snum1] [snum2] [snum3] [snum4] [snum5] [snum6]
     * 
     * 
     * 
     */ 
    
   /*
    * 
    * ALC49
    */

/* ALCBucko
 * 
 */   
  
   
   /*
    * 
    * ALCKeno
    */
   
/*
 * ALCPik4
 * 
 * 
 */

/*
 * ALCTag
 */   
 }



?>