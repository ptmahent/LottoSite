<?php

 /* 
  * James Earlywine - July 20th 2011 
  * 
  * Translates a jagged associative array 
  * to XML 
  * 
  * @param : $theArray - The jagged Associative Array 
  * @param : $tabCount - for persisting tab count across recursive function calls 
  */ 
function assocToXML ($theArray, $tabCount=2) { 
    //echo "The Array: "; 
    //var_dump($theArray); 
    // variables for making the XML output easier to read 
    // with human eyes, with tabs delineating nested relationships, etc. 
    
    $tabCount++; 
    $tabSpace = ""; 
    $extraTabSpace = ""; 
     for ($i = 0; $i<$tabCount; $i++) { 
        $tabSpace .= "\t"; 
     } 
     
     for ($i = 0; $i<$tabCount+1; $i++) { 
        $extraTabSpace .= "\t"; 
     } 
     
     
    // parse the array for data and output xml 
    foreach($theArray as $tag => $val) { 
        if (!is_array($val)) { 
            $theXML .= PHP_EOL.$tabSpace.'<'.$tag.'>'.htmlentities($val).'</'.$tag.'>'; 
        } else { 
            $tabCount++; 
            $theXML .= PHP_EOL.$extraTabSpace.'<'.$tag.'>'.assocToXML($val, $tabCount); 
            $theXML .= PHP_EOL.$extraTabSpace.'</'.$tag.'>'; 
        } 
    } 
    
return $theXML; 
} 

?>
