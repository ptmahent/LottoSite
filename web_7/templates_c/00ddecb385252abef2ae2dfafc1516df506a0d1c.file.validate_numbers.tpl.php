<?php /* Smarty version Smarty-3.0.8, created on 2011-10-05 19:43:03
         compiled from "/home1/tswebtek/tswlotto/web3/templates/validate_numbers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20473175624e8ceb87425899-90520067%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00ddecb385252abef2ae2dfafc1516df506a0d1c' => 
    array (
      0 => '/home1/tswebtek/tswlotto/web3/templates/validate_numbers.tpl',
      1 => 1317858176,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20473175624e8ceb87425899-90520067',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lotto Site.Net -<?php echo $_smarty_tpl->getVariable('pageName')->value;?>
</title>
<link type="text/css" rel="stylesheet" href="../inc/validform/css/validform.css" />
<script type="text/javascript" src="../inc/validform/libraries/jquery.js"></script>
<script type="text/javascript" src="../inc/validform/libraries/validform.js"></script>
<script type="text/javascript" src="../inc/lib/picnet.table.filter.min.js"></script>


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

span.selected {
  color:#405BA2;
  border: 1px solid #CF9B00;
}

span.not-selected {
  color: #AC3537;
  border: none;
}

span.win_amt {
 color: #000000;
 font: normal 12px Arial, Helvetica, sans-serif;
  
  
}

span.matchNumber {
  color: #04A107;
  font: normal 12px Arial, Helvetica, sans-serif;
  
}

span.matchBonusNumber {
  color: #0000CC;
  font: normal 12px Arial, Helvetica, sans-serif; 
}

span.notMatchNumber {
  color: #D00000;
  font: normal 12px Arial, Helvetica, sans-serif;
  
}

#lottery_result {
	border: none;
}

td#matchNumber {
  color: #04A107;
  background-color: #FCFCFC;
  text-align: center;  
  font: normal 12px Arial, Helvetica, sans-serif;

}

td#notMatchNumber { 
  color: #D00000;
  background-color: #FCFCFC;
  text-align: center;  
  font: normal 12px Arial, Helvetica, sans-serif;
}


td#noWinButMatch {
  color: #D00000;
  background-color: #FCFCFC;
  text-align: center;  
  font: normal 12px Arial, Helvetica, sans-serif;
}
td#matchBonusNumber {
  color: #0000CC;
  background-color: #FCFCFC;
  text-align: center;
  font: normal 12px Arial, Helvetica, sans-serif; 

}


th#head_drawDate {
  color: #000000;
  background-color: #FCFCFC;
  text-align: center;
  font: normal 12px Arial, Helvetica, sans-serif;
    vertical-align: top;


}


th#head_drawNumber {
  color: #000000;
  background-color: #FCFCFC;
  text-align: center;
  font: normal 12px Arial, Helvetica, sans-serif;
    vertical-align: top;
}



td#drawDate {
  color: #D00000;
  background-color: #FCFCFC;
  text-align: center;
  font: normal 12px Arial, Helvetica, sans-serif;


}
td#drawNumber {
  color: #D00000;
  background-color: #FCFCFC;
  text-align: center;
  font: normal 12px Arial, Helvetica, sans-serif;
}

td#instruct {
  color: #000000;
  background-color: #FCFCFC;
  text-align: left;
  vertical-align: top;
  font: normal 12px Arial, Helvetica, sans-serif;
}



td#win_amt {
 color: #000000;
 background-color: #FCFCFC;
  text-align: center; 
 font: normal 12px Arial, Helvetica, sans-serif;

}
td#not-selected td#selected{
  color: #AC3537;
  background-color: #FCFCFC;
  text-align: center;
  border: none;
}

td#selected {
  color:#405BA2;
  background-color: #FCFCFC;
  text-align: center;
  border: 1px solid #CF9B00;
}

div#top_nav_bar {
  float: center;
  border: 1px solid #ccc;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;
  

}
div#top_wel_msg {
  float: right;
  border: 1px solid #ccc;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;


}
div#nav_years {
  float: center;
  border: 1px solid #ccc;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;
}
div#nav_months {
  float: center;
  border: 1px solid #ccc;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;
  visibility: hidden;
}
div#nav_disp_limit {
  float: center;
  border: 1px solid #ccc;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;
  visibility: hidden;

}



.649Row {
  
  
}

input.vf__text,
input.vf__text_tiny,
input.vf__text_small,
input.vf__text_large,
input.vf__button,
select.vf__one,
select.vf__multiple,
textarea.vf__text
{
  font: normal 12px Arial, Helvetica, sans-serif;
  color: #666;
  padding: 2px;
  width: 147px;  
  background-color: #fff;
  border: 1px solid #ccc;
}

fieldset.vf__disabled input.vf__text,
fieldset.vf__disabled input.vf__text_tiny,
fieldset.vf__disabled input.vf__text_small,
fieldset.vf__disabled input.vf__text_large,
fieldset.vf__disabled input.vf__button,
fieldset.vf__disabled select.vf__one,
fieldset.vf__disabled select.vf__multiple,
fieldset.vf__disabled textarea.vf__text
{
  border: 1px solid #ddd;
  color: #aaa;
  width: 147px;
}



select.vf__multiple {
  width: 147px;
  height: 84px;
  font: normal 12px Arial, Helvetica, sans-serif;
}



</style>


<style type="text/css">
#container {
	height: auto;
	width: 1024px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	left: 0px;
	top: 0px;
	right: auto;
	bottom: auto;

}
#banner {
	height: 147px;
	width: 1024px;
	margin: 0px;
	padding: 0px;
	float: left;
	position: relative;
	left: 0px;
	top: 0px;
}
#thidNav {
	height: 31px;
	width: 1024px;
	position: relative;

}

#mContent {
	width: 1024px;
	height: auto;
	position:relative;
}

#footer {
	background-image: url(images/footer.png);
	margin: 0px;
	padding: 0px;
	height: 40px;
	width: 1024px;
	position: relative;
	text-align: right;
}
#secondnav {
	height: 31px;
	width: 1024px;
	font-family: Verdana, Geneva, sans-serif;
	background-image: url(images/header/SecondNav01.jpg);
	margin: 0px;
	padding: 0px;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	position: relative;
	left: 0px;
	top: 148px;
	right: auto;
	bottom: auto;
	clear: left;
	float: left;
}
#logo {
	font-family: Verdana, Geneva, sans-serif;
	margin: 0px;
	height: 147px;
	width: 412px;
	background-image: url(images/header/logo01.jpg);
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	float: left;
}
#topbox {
	background-image: url(images/header/top_header_banner01.jpg);
	float: right;
	height: 116px;
	width: 612px;
}
#topnav {
	float: right;
	height: 31px;
	width: 612px;
}
#topNavBanner {
	font-family: Verdana, Geneva, sans-serif;
	background-image: url(images/header/top_header_banner01.jpg);
	margin: 0px;
	height: 116px;
	width: 612px;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	float: left;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
	position: absolute;
	left: 413px;
	top: 0px;
	right: auto;
	bottom: auto;
}
#topHeaderNav {
	font-family: Verdana, Geneva, sans-serif;
	background-image: url(images/header/topNav01.jpg);
	margin: 0px;
	padding: 0px;
	float: left;
	height: 31px;
	width: 612px;
	position: absolute;
	left: 413px;
	top: 117px;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	right: auto;
	bottom: auto;

	clear: left;
}
#box {
	height: 147px;
	width: 612px;
	float: right;
}
#secondNav {
	font-family: Verdana, Geneva, sans-serif;
	height: 33px;
	width: 1024px;
	float: left;
	position: relative;
}

</style>
<script type="text/javascript">

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

</script>

<script type="text/javascript">
<?php echo $_smarty_tpl->getVariable('JSOUTPUT')->value;?>

</script>



</head>

<body onload="MM_preloadImages('images/header/topNav01a.jpg','images/header/topNav01b.jpg','images/header/topNav01c.jpg','images/header/topNav01d.jpg','images/header/SecondNav01a.jpg','images/header/SecondNav01b.jpg','images/header/SecondNav01c.jpg','images/header/SecondNav01d.jpg','images/header/SecondNav01e.jpg','images/header/SecondNav01f.jpg','images/header/SecondNav01g.jpg','images/header/SecondNav01h.jpg','images/header/SecondNav01i.jpg')">
<div id="container">
  <div id="logo"><a href="/"><img src="images/header/logo01.jpg" border="0" height="147px" width="412px"></a></div>
  <div id="box">
    <div id="topbox"><?php echo $_smarty_tpl->getVariable('htmltopOut')->value;?>
</div>
    <div id="topnav"><img src="images/header/topNav01a.jpg" width="612" height="31" border="0" usemap="#Map" id="Image1" />
      <map name="Map" id="Map">
        <area shape="rect" coords="55,5,138,29" href="../web3/check_649.php" target="_self" alt="Validate" onmouseover="MM_swapImage('Image1','','images/header/topNav01a.jpg',1)" onmouseout="MM_swapImgRestore()" />
        <area shape="rect" coords="148,5,277,28" href="../web3/view_649.php" onmouseover="MM_swapImage('Image1','','images/header/topNav01b.jpg',1)" onmouseout="MM_swapImgRestore()" />
        <area shape="rect" coords="288,4,421,29" href="../web3/view_649_winnings.php" onmouseover="MM_swapImage('Image1','','images/header/topNav01c.jpg',1)" onmouseout="MM_swapImgRestore()" />
        <area shape="rect" coords="430,4,529,30" href="../web5/quick_649.php" onmouseover="MM_swapImage('Image1','','images/header/topNav01d.jpg',1)" onmouseout="MM_swapImgRestore()" />
      </map>
    </div>
    
  </div>
  <div id="secondNav"><img src="<?php if ($_smarty_tpl->getVariable('GAME')->value=='OLGPOKER'){?>
  images/header/SecondNav01h.jpg
  <?php }elseif($_smarty_tpl->getVariable('GAME')->value=='NA649'){?>
  images/header/SecondNav01b.jpg
  <?php }elseif($_smarty_tpl->getVariable('GAME')->value=='OLG49'){?>
  images/header/SecondNav01c.jpg
  <?php }elseif($_smarty_tpl->getVariable('GAME')->value=='OLGKENO'){?>
  images/header/SecondNav01e.jpg
  <?php }elseif($_smarty_tpl->getVariable('GAME')->value=='OLGPICK3'){?>
  images/header/SecondNav01g.jpg
  <?php }elseif($_smarty_tpl->getVariable('GAME')->value=='OLGLOTTARIO'){?>  
  images/header/SecondNav01d.jpg
  <?php }elseif($_smarty_tpl->getVariable('GAME')->value=='OLGPICK4'){?>
  images/header/SecondNav01f.jpg
  <?php }elseif($_smarty_tpl->getVariable('GAME')->value=='OLGENCORE'){?>
  images/header/SecondNav01i.jpg
  <?php }elseif($_smarty_tpl->getVariable('GAME')->value=='NAMAX'){?>
  images/header/SecondNav01a.jpg
  <?php }else{ ?>
  images/header/SecondNav01.jpg
  <?php }?>" width="1024" height="33" border="0" usemap="#Map2" id="Image2" />
    <map name="Map2" id="Map2">
      <area shape="rect" coords="37,3,135,30" href="../web3/check_max.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01a.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="161,4,252,31" href="../web3/check_649.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01b.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="271,5,366,31" href="../web3/check_49.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01c.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="389,5,465,31" href="../web3/check_lottario.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01d.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="495,6,554,31" href="../web3/check_keno.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01e.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="578,7,633,30" href="../web3/check_pick4.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01f.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="648,9,709,30" href="../web3/check_pick3.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01g.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="750,7,807,31" href="../web3/check_poker.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01h.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="832,7,905,31" href="../web3/check_encore.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01i.jpg',1)" onmouseout="MM_swapImgRestore()" />
    </map>
  </div>
  <div id="thirdNav">
 &nbsp;
    
  </div>
  <div id="mContent">
 
   <?php echo $_smarty_tpl->getVariable('htmlOut')->value;?>


    </div>
  <div id="footer">
 
 
 &nbsp;
  </div>
  
</div>
</body>
</html>
