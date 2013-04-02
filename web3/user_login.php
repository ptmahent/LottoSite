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
include_once("inc/smarty/libs/Smarty.class.php");
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


$smarty = new Smarty();

	$smarty->template_dir = '/home1/tswebtek/tswlotto/web3/templates/';
	$smarty->compile_dir  = '/home1/tswebtek/tswlotto/web3/templates_c/';
	$smarty->config_dir   = '/home1/tswebtek/tswlotto/web3/configs/';
	$smarty->cache_dir	  = '/home1/tswebtek/tswlotto/web3/cache/';
	$smarty->left_delimiter = "[";
	$smarty->right_delimiter = "]";
	
	$htmltopOut = "";
// Display User if logged in
 if ($bLoggedIn == true) {
	$smarty->assign('userLoggedIn', 1);
	$smarty->assign('arUser', array('_nickname'=> $_SESSION['_nickname'],
									'userid' => $_SESSION['userid']
									)
					);
	$htmltopOut .= "Hi " . $_SESSION['_nickname'];
	$htmltopOut .= "| <a href='user_logout.php'>Logout</a>";
} else {
		$smarty->assign('userLoggedIn', 0);
	$htmltopOut .= "<a href='user_login.php'>Login</a>";
}
$smarty->assign('htmltopOut', $htmltopOut);
$htmlOut = "";
if (!$LoginSuccess && !$loginFailure) {



$htmlOut .= '<table border="0"><tr><td ><a href="user_add.php">New User</a><br />'
		. $strOutput . '</td>'
		. '<td>&nbsp;</td>'
		. '</tr></table>';
  $objAnalytics   = new Analytics();
$htmlOut .=  $objAnalytics->GoogleAnalytics();



} elseif ($loginFailure) {


$htmlOut .= 'Login Failure... Try again'
		. '<br />'
		. '<a href="user_login.php">Back to Login</a>';
  
}

$smarty->assign("htmlOut", $htmlOut);
$smarty->display('users.tpl');

?>

