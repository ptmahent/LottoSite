<?php
/*
 * 
 * Program      : TSWebTek Lotto Center ver. 0.5
 * File         : 
 * Programmed By: Piratheep Mahenthiran
 * Date         : Mar 2011
 * Copyright (C) 2011 TSWebTek Ltd.

*/
include_once("inc/smarty/libs/Smarty.class.php");
require_once("../inc/validform/libraries/ValidForm/class.validform.php");
require_once("../inc/incUser.php");
require_once("../inc/incAnalytics.php");

$objForm = new ValidForm("AddUserForm", "Required fields are printed in bold.");


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



//*** There is also built-in support for password fields

$objForm->addField("password1","Password", VFORM_PASSWORD,
    array(
        "required" => true
    ),
    array(
        "type" => "This is not a valid password!",
        "required" => "Please fill in a password"    
    )
);

$objForm->addField("password2","Repeat password", VFORM_PASSWORD,
    array(
        "required" => true,
        "matchwith" => "password1"
    ),
    array(
        "type" => "This is not a valid password!",
        "required" => "Please retype your password",
        "matchwith" => "You must re-enter password exactly same in this field"
    )
);

$objForm->addField("First_Name", "First Name", VFORM_STRING,
    array(
        "maxLength" => 50,
        "required" => TRUE
    ),
    array(
        "maxLength" => "Your input is too long. A maximum of %s characters is OK.",
        "required" => "This field is required.",
        "type" => "Enter only letters and spaces."

    )
);

$objForm->addField("Last_Name", "Last Name", VFORM_STRING,
    array(
        "maxLength" => 50,
        "required" => TRUE
    ),
    array(
        "maxLength" => "Your input is too long. A maximum of %s characters is OK.",
        "required" => "This field is required.",
        "type" => "Enter only letters and spaces."

    )
);

$objForm->addField("Nick_Name", "Nick Name", VFORM_STRING,
    array(
        "maxLength" => 50,
        "required" => TRUE
    ),
    array(
        "maxLength" => "Your input is too long. A maximum of %s characters is OK.",
        "required" => "This field is required.",
        "type" => "Enter only letters and spaces."

    )
);

//*** Captcha image validation to keep those bots out.
//$objForm->addField("captcha", "Are you human?", VFORM_CAPTCHA, array("required" => true));


$objForm->setMainAlert("One or more errors occurred. Check the marked fields and try again.");
$objForm->setSubmitLabel("Submit");



$strOutput = "";

 $objUser = new User();
if ($objForm->isSubmitted() && $objForm->isValid()) {
    
  //print_r($objForm->getValidField("password1"));
  //print "<hr />";
  //print_r($objForm->getValidField("password2"));
    //*** HTML body of the email.
    

    //*** Send the email.
   // mail("owner@awesomesite.com", "Contact form submitted", $strMessage, $strHeaders);
         
    //*** Set the output to a friendly thank you note.
    //$strOutput = $objForm->valuesAsHtml();
    
    //$strOutput = $objForm->getValidField("email").
    
    $sUserName = null;
    $sFirstName = $objForm->getValidField("First_Name")->getValue();
    $sLastName  = $objForm->getValidField("Last_Name")->getValue();
    $sEmailAddr = $objForm->getValidField("email")->getValue();
    $sPasswd    = $objForm->getValidField("password1")->getValue();
    $sNickName  = $objForm->getValidField("Nick_Name")->getValue();
    
    $iUserId = $objUser->UserEmailExists($sEmailAddr); // check if email address already used
    if (!$iUserId) {
      $iUserId = $objUser->UserAdd($sUserName, $sFirstName, $sLastName, $sEmailAddr, $sPasswd, $sNickName);
      $strOutput = "Your account has been created. Please go to login page.";
      $strOutput .= "<br />Go to Login Page <a href='user_login.php'>Login</a>";
    } else {
      $strOutput = "Please go back and correct your email address or you already have an account with us. ";
      $strOutput .= "<br /><a href='javascript:history.go(-1)'>Go Back</a>";
    } 
 
    
} else {
    //*** The form has not been submitted or is not valid.
    $strOutput = $objForm->toHtml();
}


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
	
	$html_out = '<table border="0"><tr><td ><a href="user_login.php">User Login</a><br />'
			 . $strOutput . '</td>'
			. '<td>&nbsp;</td>'
			. '</tr></table>';
	  $objAnalytics   = new Analytics();
  	$html_out .=  $objAnalytics->GoogleAnalytics();

$smarty->assign("htmlOut", $html_out);
$smarty->display('users.tpl');

?>