<?php

class Analytics {
  
  
  function GoogleAnalytics() {
    $goog_analy_acct = "UA-24087615-1";
    
    $strCode = "<script type=\"text/javascript\">";
    $strCode .= "var _gaq = _gaq || [];";
    $strCode .= "_gaq.push(['_setAccount', '" . $goog_analy_acct . "']);";
    $strCode .= "_gaq.push(['_trackPageview']);";

    $strCode .= "(function() {";
    $strCode .= "var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
    $strCode .= "ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
    $strCode .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
    $strCode .= "})();";

    $strCode .= "</script>";
    
    return $strCode;
  }
  
  
}


?>