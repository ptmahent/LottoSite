<?php
include_once("inc/smarty/libs/Smarty.class.php");
require_once("../inc/incUser.php");

	$smarty = new Smarty();

	$smarty->template_dir = '/home1/tswebtek/tswlotto/web3/templates/';
	$smarty->compile_dir  = '/home1/tswebtek/tswlotto/web3/templates_c/';
	$smarty->config_dir   = '/home1/tswebtek/tswlotto/web3/configs/';
	$smarty->cache_dir	  = '/home1/tswebtek/tswlotto/web3/cache/';
	$smarty->left_delimiter = "[";
	$smarty->right_delimiter = "]";
	  
	  
  $sNickName = "";
  $bLoggedIn = false;
  $objUser = new User();
	  
if ($_SESSION['valid']) {
    $iuserNo    = $_SESSION['userid'];
    $sNickName  = $_SESSION['_nickname'];
    $ds_user    = $objUser->UserGet($iuserNo);
    //print_r($ds_user);
    if (is_array($ds_user)) {
      $bLoggedIn = true;
    }
  }
	
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

$htmlOut = "<table border='0' width='100%'><tr><td align='center'>
<h1>Upcomming Lotto Jackpots</h1>
<br /><br />
<h2><a href='check_649.php'>Lotto 649</a></h2>
<h3>Wed, Sep 28 $3,000,000 EST.</h3>
<a href='view_649_winnings.php'>Winnings</a>
<br /><br />
<h2><a href='check_max.php'>Lotto MAX</a></h2>
<h3>Fri, Sep 30 $40,000,000 EST.</h3>
<a href='view_max_winnings.php'>Winnings</a>
<br /><br />
<h2><a href='check_lottario.php'>Lottario</a></h2>
<h3>Sat, Oct 01 - $290,000 EST.</h3>
<a href='view_lottario_winnings.php'>Winnings</a>
<br /><br />
</td></tr></table>";

$htmlCSSOut = "#twitter {
    height: 200px;
	position: relative;
	float: left;
	width: 1004px;
	margin: 0px;
	padding: 0px;
	top: 0px;
				}";



$htmlOut .= "<div id='twitter'></div>";
$htmlJSOut = "
$(document).ready(function() {
$('#twitter').twitterSearch({
term: 'lottomax',
title: 'Lotto',
titleLink: '',
			bird: true, 
			birdSrc: 'images/tweet.gif', 
			birdLink: 'http://www.twitter.com',
			avatar: true,
			anchors: true,
			animOutSpeed: 500,
			animInSpeed: 500,
			pause: true,	
			time: true,
			timeout: 4000,
		css: { 
		a:     { textDecoration: 'none', color: '#990000', fontWeight: 'normal'},
		container: { backgroundColor: '#ffffcc' },
		frame: { border: '10px solid #ff9933', borderRadius: '10px', '-moz-border-radius': '10px', '-webkit-border-radius': '10px' },
		img:   { width: '30px', height: '30px' },
		loading: { color: '#000000' },
		text:  {fontWeight: 'normal', fontSize: '12px', color:'#000000'},
		time:  { fontSize: '12px', color: '#66cccc' },
		title: { backgroundColor: '#ffcc66', padding: '0px 0 0px 0', textAlign: 'center', fontWeight: 'bold', fontSize: '14px'},
		titleLink: { textDecoration: 'none', color: '#000066' },
		user:  { fontSize: '12px'},
		fail:  { background: '#6cc5c3 url(/images/failwhale.png) no-repeat 50% 50%'}
		} }); });";
$smarty->assign("JSOut", $htmlJSOut);
$smarty->assign("CSSOut", $htmlCSSOut);
$smarty->assign("htmlOut", $htmlOut);
$smarty->display('welcome.tpl');


?>
