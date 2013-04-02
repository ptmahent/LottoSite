<?php

include_once("phpArguments.php");


 $argum = arguments();
 print_r($argum);
// print_r($_SERVER['argv']);
    
 print "test: " . count($argum) . "\n";
 print "test 1cnt: " . count($argum,1) . "\n";
 print " is standard : ";
 //print_r($argum["standard"]);

 foreach ($argum as $key => $val) {
 	print " --:> " . $key . " =  " . $val . "\n";
 }
 
 foreach ($argum["standard"] as $key => $val) {
 	print " ==:> " . $key . " .. -> .. " . $val . "\n";
 }
 print " 0 -> " . $argum["standard"][0] . "\n";
 print " 1 -> " . $argum["standard"][1] . "\n";
 print " 2 -> " . $argum["standard"][2] . "\n";
 print " 3 -> " . $argum["standard"][3] . "\n";
 
 
 ?>