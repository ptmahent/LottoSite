
<?php

include_once("./incGenDates.php");
$date1 = "1-2-2010";
$date2 = "1-12-2010";

$oDate = new GenDates();
//$sat_list = getAllSaturdays($date1, $date2);
//$wed_list = getAllWednesdays($date1, $date2);
$fri_list = $oDate->getAllFridays($date1, $date2);
$wedsat_list = $oDate->getAllWedSat($date1, $date2);
$nextweek = $oDate->getNextWeek($date1);
$nextday = $oDate->getNextDay($date1);
$nextwed = $oDate->getNextWed($date1);
$nextsat = $oDate->getNextSat($date1);
print "Saturday <br />";
print_r ($sat_list);
print "<br /> Wednesday <br />";
//print_r ($wed_list);
print "<br /> Friday <br />";
print_r($fri_list);
print "<br /> Wed & Sat <br />";
print_r($wedsat_list);
print "\n<br /> Testing LastDay: " . date("d-m-Y", mktime(0,0,0,13,0,2011));
print "\n<br /> Date: " . date('Ymd', mktime(0,0,0,13,0,2011));
print "\n<br />" . $date1 . " Next Week " . $nextweek . "<br />";
print "<br />" . $date1 . " Next Day " . $nextday . "<br />";
print "<br />" . $date1 . " Next Wed " . $nextwed . "<br />";
print "<br />" . $date1 . "Next Sat " . $nextsat . "<br />";


  $url_step1 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
  $url_step2 = "http://www.olg.ca/lotteries/viewPastNumbers.do";
  $url_step3 = "http://www.olg.ca/lotteries/viewPrizeShares.do";
  
  

?>