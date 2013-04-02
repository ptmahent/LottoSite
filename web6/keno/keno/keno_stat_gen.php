<?php
include_once("inc2/incStatGen.php");
include_once("inc2/incLottery.php");

include_once("inc2/incCombOLGLottery.php");
include_once("inc2/incGenDates.php");
include_once("inc2/incArguments.php");


  $objLottery = new Lottery();
  $objStatGen = new StatGen();
  do {
    fwrite(STDOUT, "\tEnter one of the options Below: \n\n\n");
    fwrite(STDOUT, "\tgetYear [yyyy] : dddd should be year in 4 digits \n");          // 
    fwrite(STDOUT, "\tgetMonth [mm-yyyy] : mm-yyyy format of selected month\n");      //
    fwrite(STDOUT, "\tgetDraw [dd-mm-yyyy] : dd-mm-yyyy format of selected month\n\n");      //
    fwrite(STDOUT, "\t[dd-mm-yyyy] - [dd-mm-yyyy]");
    fwrite(STDOUT, "\n\t\n\t: ");    
    do {
      $selection = trim(fgets(STDIN));
    } while (trim($selection) == '');
    
    $drawDates = array();
    if (preg_match("/(\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4}) - (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
      $startDay     = $lmatches[1];
      $startMonth   = $lmatches[2];
      $startYear    = $lmatches[3];
      $endDay       = $lmatches[4];
      $endMonth     = $lmatches[5];
      $endYear      = $lmatches[6];
      $startDate = mktime(0,0,0,$startMonth, $startDay , $startYear);
      $endDate   = mktime(0,0,0,$endMonth, $endDay, $endYear);
      $drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "DD1DD2", $startDate, $endDate);
    } elseif (preg_match("/getDraw (\d{2})\s*[-\/]\s*(\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
       print_r($lmatches); 
      $selectedDay    = $lmatches[1];
      $selectedMonth  = $lmatches[2];
      $selectedYear   = $lmatches[3];
      $startDate = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      $endDate   = mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear);
      $drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "DD", $startDate, $endDate);
    } elseif (preg_match("/getMonth (\d{2})\s*[-\/]\s*(\d{4})/i", $selection, $lmatches)) {
      $selectedMonth = $lmatches[1];
      $selectedYear = $lmatches[2];
      $startDate    = mktime(0,0,0,$selectedMonth, 1, $selectedYear);
      $endDate      = mktime(0,0,0,$selectedMonth + 1, 0, $selectedYear);  
      $drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "MM", $startDate, $endDate);    
    } elseif (preg_match("/getYear (\d{4})|(\d{4})/i", $selection, $lmatches)) {
      $selectedYear = $lmatches[1];
      $startDate    = mktime(0,0,0,1,1,$selectedYear);
      $endDate      = mktime(0,0,0,12,31,$selectedYear);
      $drawDates = $objLottery->dbLotteryGetDrawDates("onKeno", "YY", $startDate, $endDate);
    }
      
    //print_r($drawDates);
    if (is_array($drawDates)) {
      foreach ($drawDates as $dtDate) {
          // 20090211
        $drawDate = strtotime($dtDate);
        //print "\n<br /> " . date('d-m-Y', $drawDate) . "\n"; 
        //print_r($dtDate);
        //alc_fetch_single_draw(date('d-m-Y',$drawDate));
        //on_fetch_first_step_649(date('d-m-Y', $drawDate));
        //on_fetch_first_step_max(date('d-m-Y', $drawDate));
        $objStatGen->KenoStatGen(date('d-m-Y', $drawDate), date('d-m-Y', $drawDate));
      }
    }    
    
  } while (trim($selection) != 'q');
  




?>