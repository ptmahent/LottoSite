<?php
/*
 * 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.

*/


date_default_timezone_set('America/Toronto');
// will echo all saturdays found between date range. 

class GenDates {
    function getNextWeek($from_date = "") {
      $first_dte = getdate(strtotime($from_date));
      
      $numofdays = 7;
      $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $numofdays,  $first_dte["year"]));
      //print $date_dte;
      return $date_dte;
    }
    function getNextDay($from_date = "") {
      $first_dte = getdate(strtotime($from_date));
      $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + 1,  $first_dte["year"]));
      return $date_dte;
    }
    
    function getAllDays($from_date = "", $to_date) {
      $first_dte  = getdate(strtotime($from_date));
      $last_dte   = getdate(strtotime($to_date));
      
       $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $allDays_list = array();
        $days_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          $allDays_list[$days_cnt] = $date_dte;
          $days_cnt++;
         /* if ($day_dte == 'Wednesday') {
            $wed_list[$days_cnt] = $date_dte;
            $days_cnt++;
          }
          * 
          */
         
        }
        return $allDays_list;
      
    }
    function getNextWed($from_date = "") {
      $first_dte = getdate(strtotime($from_date));
      
      $numofdays = 7;
      $wed_date = "";
      for ($i = 0; $i <= $numofdays; $i++) {
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
          
          if ($day_dte == 'Wednesday') {
            $wed_date = $date_dte;
            break;
          }
      }
      return $wed_date;
    }
    
    function getNextFri($from_date = "") {
      $first_dte = getdate(strtotime($from_date));
      
      $numofdays = 7;
      $wed_date = "";
      for ($i = 0; $i <= $numofdays; $i++) {
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
          
          if ($day_dte == 'Friday') {
            $wed_date = $date_dte;
            break;
          }
      }
      return $wed_date;
    }
    
    
    function getNextSat($from_date = "") {
      $first_dte = getdate(strtotime($from_date));
      
      $numofdays = 7;
      $sat_date = "";
      for ($i = 0; $i <= $numofdays; $i++) {
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
          
          if ($day_dte == 'Saturday') {
            $sat_date = $date_dte;
            break;
          }
      }
      return $sat_date;
    }

    function getNextWedSat($from_date = "") {
      $first_dte = getdate(strtotime($from_date));
      
      $numofdays = 7;
      $wedsat_date = "";
      for ($i = 0; $i <= $numofdays; $i++) {
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
          if ($day_dte == 'Wednesday') {
            $wedsat_date = $date_dte;
            break;  
          }
          if ($day_dte == 'Saturday') {
            $wedsat_date = $date_dte;
            break;
          }
      }
      return $wedsat_date;
    }
        
    function getAllWedSat($from_date, $to_date){
        //print_r($from_date);
        //print_r($to_date); 
        $first_dte = getdate(strtotime($from_date));
        $last_dte = getdate(strtotime($to_date));
        
        $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $wedsat_list = array();
        $wedsat_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          if ($day_dte == 'Saturday') {
            $wedsat_list[$wedsat_cnt] = $date_dte;
            $wedsat_cnt++;
          } elseif ($day_dte == 'Wednesday') {
            $wedsat_list[$wedsat_cnt] = $date_dte;
            $wedsat_cnt++;
          }
         
        }
        return $wedsat_list;
    } 
    
    function getAllWeekDays($from_date, $to_date){
        //print_r($from_date);
        //print_r($to_date); 
        $first_dte = getdate(strtotime($from_date));
        $last_dte = getdate(strtotime($to_date));
        
        $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $weekdays_list = array();
        $weekdays_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          if ($day_dte == 'Monday') {
            $weekdays_list[$weekdays_cnt] = $date_dte;
            $weekdays_cnt++;
          } elseif ($day_dte == 'Tuesday') {
            $weekdays_list[$weekdays_cnt] = $date_dte;
            $weekdays_cnt++;
          } elseif ($day_dte == 'Wednesday') {
            $weekdays_list[$weekdays_cnt] = $date_dte;
            $weekdays_cnt++;
          } elseif ($day_dte == 'Thursday') {
            $weekdays_list[$weekdays_cnt] = $date_dte;
            $weekdays_cnt++;
          } elseif ($day_dte == 'Friday') {
            $weekdays_list[$weekdays_cnt] = $date_dte;
            $weekdays_cnt++;
          }
         
        }
        return $weekdays_list;
    } 
    
    
    // will echo all saturdays found between date range. 
    function getAllSundays($from_date, $to_date){ 
        $first_dte = getdate(strtotime($from_date));
        $last_dte = getdate(strtotime($to_date));
        
        $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $sun_list = array();
        $sun_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          if ($day_dte == 'Sunday') {
            $sun_list[$sun_cnt] = $date_dte;
            $sun_cnt++;
          }
         
        }
        return $sun_list;
    } 
    
    // will echo all saturdays found between date range. 
    function getAllThursday($from_date, $to_date){ 
        $first_dte = getdate(strtotime($from_date));
        $last_dte = getdate(strtotime($to_date));
        
        $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $thu_list = array();
        $thu_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          if ($day_dte == 'Thursday') {
            $thu_list[$thu_cnt] = $date_dte;
            $thu_cnt++;
          }
         
        }
        return $thu_list;
    } 
    
    
    // will echo all saturdays found between date range. 
    function getAllTuesday($from_date, $to_date){ 
        $first_dte = getdate(strtotime($from_date));
        $last_dte = getdate(strtotime($to_date));
        
        $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $tue_list = array();
        $tue_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          if ($day_dte == 'Tuesday') {
            $tue_list[$tue_cnt] = $date_dte;
            $tue_cnt++;
          }
         
        }
        return $tue_list;
    } 
    
     // will echo all saturdays found between date range. 
    function getAllMondays($from_date, $to_date){ 
        $first_dte = getdate(strtotime($from_date));
        $last_dte = getdate(strtotime($to_date));
        
        $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $mon_list = array();
        $mon_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          if ($day_dte == 'Monday') {
            $mon_list[$mon_cnt] = $date_dte;
            $mon_cnt++;
          }
         
        }
        return $mon_list;
    } 
    
    // will echo all saturdays found between date range. 
    function getAllFridays($from_date, $to_date){ 
        $first_dte = getdate(strtotime($from_date));
        $last_dte = getdate(strtotime($to_date));
        
        $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $fri_list = array();
        $fri_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          if ($day_dte == 'Friday') {
            $fri_list[$fri_cnt] = $date_dte;
            $fri_cnt++;
          }
         
        }
        return $fri_list;
    } 
    
    
    
    // will echo all saturdays found between date range. 
    function getAllWednesdays($from_date, $to_date){ 
         // getting number of days between two date range.
        
        $first_dte = getdate(strtotime($from_date));
        $last_dte = getdate(strtotime($to_date));
        
        $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $wed_list = array();
        $wed_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          if ($day_dte == 'Wednesday') {
            $wed_list[$wed_cnt] = $date_dte;
            $wed_cnt++;
          }
         
        }
        return $wed_list;
    } 
    
    // will echo all saturdays found between date range. 
    function getAllSaturdays($from_date, $to_date){ 
        // getting number of days between two date range.
        
        $first_dte = getdate(strtotime($from_date));
        $last_dte = getdate(strtotime($to_date));
        
        $numofdays = $this->count_days(strtotime($from_date), strtotime($to_date));
        //echo "numofdays: " . $numofdays . " <br />";
        $sat_list = array();
        $sat_cnt = 0;
        for ($i = 0; $i <= $numofdays; $i++) {
          
          $day_dte = Date('l', mktime(0,0,0,$first_dte["mon"],$first_dte["mday"] + $i,  $first_dte["year"]));
          $date_dte = Date('d-m-Y', mktime(0,0,0,$first_dte["mon"], $first_dte["mday"] + $i,  $first_dte["year"]));
        
          if ($day_dte == 'Saturday') {
            $sat_list[$sat_cnt] = $date_dte;
            $sat_cnt++;
          }
         
        }
        return $sat_list;
    } 
    // Will return the number of days between the two dates passed in 
    function count_days( $a, $b ) 
    { 
        // First we need to break these dates into their constituent parts: 
        $gd_a = getdate( $a ); 
        $gd_b = getdate( $b ); 
        // Now recreate these timestamps, based upon noon on each day 
        // The specific time doesn't matter but it must be the same each day 
        $a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] ); 
        $b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] ); 
        // Subtract these two numbers and divide by the number of seconds in a 
        // day. Round the result since crossing over a daylight savings time 
        // barrier will cause this time to be off by an hour or two. 
        return round( abs( $a_new - $b_new ) / 86400 ); 
    } 

    function getMonthNum($monthName) {
      $monthNum = array (
                "january" => 1,
                "february" => 2,
                "march" => 3,
                "april" => 4,
                "may" => 5,
                "june" => 6,
                "july" => 7,
                "august" => 8,
                "september" => 9,
                "october" => 10,
                "november" => 11,
                "december" => 12);
      return $monthNum[trim(strtolower($monthName))];
    }

    function getMonthName($monthNum) {
      $monthName = array(
                1 => "January",
                2 => "February",
                3 => "March",
                4 => "April",
                5 => "May",
                6 => "June",
                7 => "July",
                8 => "August",
                9 => "September",
                10 => "October",
                11 => "November",
                12 => "December"
      
      );
      return $monthName[$monthNum];
    }

    function getShortMonthName($monthNum) {
      $monthName = array(
                1 => "Jan",
                2 => "Feb",
                3 => "Mar",
                4 => "Apr",
                5 => "May",
                6 => "Jun",
                7 => "Jul",
                8 => "Aug",
                9 => "Sep",
                10 => "Oct",
                11 => "Nov",
                12 => "Dec"
      
      );
      return $monthName[$monthNum];
    }
    function getShortMonthNum($monthName) {
      $monthNum = array (
                "jan" => 1,
                "feb" => 2,
                "mar" => 3,
                "apr" => 4,
                "may" => 5,
                "jun" => 6,
                "jul" => 7,
                "aug" => 8,
                "sep" => 9,
                "oct" => 10,
                "nov" => 11,
                "dec" => 12);
                print "\n MonthName: " . $monthName . " Month Num: " . $monthNum[trim(strtolower($monthName))];
       return $monthNum[trim(strtolower($monthName))];
    }
    
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}
?>