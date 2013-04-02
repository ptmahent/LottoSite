<?php
/*
 * 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.

*/
ob_start();
session_start();

require_once("../inc/validform/libraries/ValidForm/class.validform.php");
require_once("../inc/incUser.php");
require_once("../inc/incAnalytics.php");


$objForm = new ValidForm("UserLoginForm", "Required fields are printed in bold.");

$objForm->addField("email", "Email address", VFORM_EMAIL,
    array(
        "maxLength" => 100,
        "required" => TRUE
    ),
    array(
        "maxLength" => "Your input is too long. A maximum of %s characters is OK.",
        "required" => "This field is required.",
        "type" => "Use the format name@domain.com"
    ), array(
        "tip" => "name@domain.com"
    )
);

$objForm->addField("password","Password", VFORM_PASSWORD,
    array(
        "required" => true
    ),
    array(
        "type" => "This is not a valid password!",
        "required" => "Please fill in a password"
    )
);

$objRemember = $objForm->addField("login_remember","Remember", VFORM_CHECK_LIST);
$objRemember->addField("Yes", "yes", true);
$objForm->setMainAlert("One or more errors occurred. Check the marked fields and try again.");
$objForm->setSubmitLabel("Submit");

$strOutput = "";

$objUser = new User();
$LoginSuccess = false;
 
if ($objForm->isSubmitted() && $objForm->isValid()) {
    
  
    //*** HTML body of the email.
    

    //*** Send the email.
   // mail("owner@awesomesite.com", "Contact form submitted", $strMessage, $strHeaders);
         
    //*** Set the output to a friendly thank you note.
    //$strOutput = $objForm->valuesAsHtml();
    
    //$strOutput = $objForm->getValidField("email").
    
    $susername      = $objForm->getValidField("email")->getValue();
    $spasswd        = $objForm->getValidField("password")->getValue();
    $remember_true  = $objForm->getValidField("login_remember")->getValue();
    
    
    
   
   // print "\n<br />Passwd   : " . $spasswd;
   // print "\n<br />Remember : " ;
    /*if (is_array($remember_true)) {
      
      if ($remember_true[0] == "yes") {
        
        
      }
      print $remember_true[0];
     }*/
    
    
    /*
     * 
     *   
     * time_t t = time(NULL) - 31536001;
        dt = php_format_date("D, d-M-Y H:i:s T", sizeof("D, d-M-Y H:i:s T")-1, t, 0 TSRMLS_CC);
        sprintf(cookie, "Set-Cookie: %s=deleted; expires=%s", name, dt);
     * 
     * 
     */
     //print $susername;
     //print "SUSER: " . $susername . " --- PWD: " . $spasswd;
    $iuserNo = $objUser->UserAuthenticate($susername, $spasswd);
    //print "UserNo: " . $iuserNo;
    
    //print $iuserNo;
    
    if ($iuserNo != null) {
      
      
      $ds_user = $objUser->UserGet($iuserNo);
      
      //print_r($ds_user);
      if (is_array($ds_user)) {
        //session_destroy();
        session_regenerate_id();
        $_SESSION['valid']          = 1;
        $_SESSION['userid']         = $ds_user["iUserNo"];
        $_SESSION['_nickname']      = $ds_user["sNickName"];
        $_SESSION['_lastloginTime'] = time();
        $_SESSION['_initLoginTime'] = time();
        $objUser->UserSessionAdd($session_id, "", $iuserNo, date('Y-m-d'), date('Y-m-d'));
        $LoginSuccess = true;
        header("Location: check_649.php\n\n");
        
      }
      
      //print_r($_SESSION);
      //print_r($iuserNo);
    } else {
      $LoginSuccess = false;
      $loginFailure = true;
    }
    
     
    
} else {
    //*** The form has not been submitted or is not valid.
    $strOutput = $objForm->toHtml();
}


//ob_flush();
//ob_end_clean();
if (!$LoginSuccess && !$loginFailure) {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head>
<title>TSWeb Lotto Center</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="../../../css/validform.css" />
<script type="text/javascript" src="../../../libraries/jquery.js"></script>
<script type="text/javascript" src="../../../libraries/validform.js"></script>
<style type="text/css">
input.vf__button {
  float: left;
  width: auto;
  border: 1px solid #ccc;
  padding: 3px 6px;
  font: normal 12px Arial, Helvetica, sans-serif;
  color: #000;
  cursor: pointer;
  background-color: #efefef;
  text-decoration: none;
}

</style>


</head>
<body>
<table border="0">
<tr>
<td >
<a href="user_add.php">User Add</a><br />
<?php echo $strOutput ?></td>
<td>&nbsp;</td>
</tr></table>
<?php
  $objAnalytics   = new Analytics();
  print $objAnalytics->GoogleAnalytics();

?>

</body>
</html>

<?php 
} elseif ($loginFailure) {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head>
<title>TSWeb Lotto Center</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="../../../css/validform.css" />
<script type="text/javascript" src="../../../libraries/jquery.js"></script>
<script type="text/javascript" src="../../../libraries/validform.js"></script>
<style type="text/css">
input.vf__button {
  float: left;
  width: auto;
  border: 1px solid #ccc;
  padding: 3px 6px;
  font: normal 12px Arial, Helvetica, sans-serif;
  color: #000;
  cursor: pointer;
  background-color: #efefef;
  text-decoration: none;
}

</style>


</head>
<body>

Login Failure... Try again
<br />
<a href='user_login.php'>Back to Login</a>
</body>
</html>

<?php
  
}



?>

