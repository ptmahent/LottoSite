<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lotto Site.Net - Latest and historical Draw Result for [if $GAME eq 'OLGPOKER']
  Ontario Poker
  [elseif $GAME eq 'NA649']
  Lotto 649
  [elseif $GAME eq 'OLG49']
  Ontario 49
  [elseif $GAME eq 'OLGKENO']
  Ontario Keno
  [elseif $GAME eq 'OLGPICK3']
  Ontario Pick 3
  [elseif $GAME eq 'OLGLOTTARIO']  
  Ontario Lottario
  [elseif $GAME eq 'OLGPICK4']
  Ontario Pick 4
  [elseif $GAME eq 'OLGENCORE']
  Ontario Encore
  [elseif $GAME eq 'NAMAX']
  Lotto Max
  [else]
  Lotto 649, Lotto Max, Ontario 49, Keno, Poker, Pick 4, Pick 3
  [/if]
</title>
[literal]
<link type="text/css" rel="stylesheet" href="../inc/validform/css/validform.css" />
<script type="text/javascript" src="../inc/validform/libraries/jquery.js"></script>
<script type="text/javascript" src="../inc/validform/libraries/validform.js"></script>
<script type="text/javascript" src="../inc/lib/picnet.table.filter.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function () {
    $("#nav_years span").click(function () {
      
      $("#nav_year_" + frmViewLotto.st_year.value).css("color","#AC3537");
      $("#nav_year_" + frmViewLotto.st_year.value).css("border","none");
      frmViewLotto.st_year.value = $(this).text();
      $("#nav_year_" + frmViewLotto.st_year.value).css("color","#405BA2");
      $("#nav_year_" + frmViewLotto.st_year.value).css("border", "1px solid #CF9B00");
      $("#nav_months").css("visibility", "visible");
      $("#nav_action").css("visibility", "hidden");
      
    
    });  
  
   $("#nav_months span").click(function () {
      var nv_month = "nav_month_";
      $("#" + nv_month + frmViewLotto.st_month.value).css("color","#AC3537");
      $("#" + nv_month + frmViewLotto.st_month.value).css("border","none");
      frmViewLotto.st_month.value = $(this).attr("id").substring(nv_month.length);
      $("#" + nv_month + frmViewLotto.st_month.value).css("color","#405BA2");
      $("#" + nv_month + frmViewLotto.st_month.value).css("border", "1px solid #CF9B00");
   //   $("#nav_disp_limit").css("visibility", "visible");
      $("#frmViewLotto").submit();
      //$("#nav_action").css("visibility", "visible");
   });
  
   $("#nav_disp_limit span").click(function () {
      var nv_disp_limit = "nav_disp_limit_";
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("color","#AC3537");
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("border","none");
      frmViewLotto.limit.value = $(this).attr("id").substring(nv_disp_limit.length);
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("color","#405BA2");
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("border", "1px solid #CF9B00");
 //     $("#frmViewLotto").submit();
   });
  });
 
  function showDiv(divEle) { 
	var divs = document.getElementsByTagName('div'); 
	for(i=0;i<divs.length;i++){ 
		if(divs[i].id.match(divEle)){ 
		if (document.getElementById) 
		divs[i].style.visibility="visible"; 
		else 
		if (document.layers) // Netscape 4 
		document.layers[divs[i]].display = 'visible'; 
		else // IE 4 
		document.all.hideShow.divs[i].visibility = 'visible'; 
		} 
	} 
 }	 
  
 function setYear(intYear) {
  
  //alert(intYear);
  showDiv('nav_months');
  document.frmViewLotto.st_year.value = intYear;
  
  //$("#nav_months").css("visibility", "visible");
  //$("#nav_action").css("visibility", "hidden");
 }
 function setMonth(intMonth) {
  document.frmViewLotto.st_month.value = intMonth;
  document.frmViewLotto.submit();

  //$("#frmViewLotto").submit();
  //$("#nav_action").css("visibility", "visible");
 }
 function setDay(intDay) {
  frmViewLotto.st_day.value = intDay;
 }
 function setLimit(intLimit) {
  frmViewLotto.limit.value = intLimit;
 }
 function setSortBy(strSort) {
  frmViewLotto.sort_by.value = strSort;
 }
 function setRowsPerPage(intRows) {
  frmViewLotto.rows_per_page.value = intRows;
 }
 function setPageNum(intPage) {
  frmViewLotto.page_num.value = intPage;
 }
</script>


<style type="text/css">
body
{
	margin: 0;
	padding: 0;
}
#container {
	height: auto;
	width: 1024px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	position: relative;
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

#secondnav {
	height: 31px;
	width: 1024px;
	font-family: Verdana, Geneva, sans-serif;
	background-image: url(images/header/SecondNav01.jpg);
	margin: 0px;
	padding: 0px;
	position: relative;
	left: 0px;
	top: 148px;
	right: auto;
	bottom: 0px;
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
	float: left;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
	position: relative;
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
	position: relative;
	left: 413px;
	top: 117px;
	right: auto;
	bottom: auto;
	

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
#mainContent {
	margin: 0px;
	padding: 0px;
	height: 700px;
	width: 1024px;
	float: left;
	position: relative;
	
	
	-moz-box-shadow: 1px 5px 10px gray;
	-webkit-box-shadow: 1px 5px 10px gray;
	box-shadow: 1px 5px 10px gray;
	
}

#footer {
	background-image: url(images/footer.png);
	margin: 0px;
	padding: 0px;
	height: 40px;
	width: 1024px;
	position: relative;
	float: left;
	text-align: right;
}
#thirdNav {
	margin: 0px;
	padding: 0px;
	float: left;
	height: auto;
	width: 1024px;
	
	-moz-box-shadow: 1px 5px 10px gray;
	-webkit-box-shadow: 1px 5px 10px gray;
	box-shadow: 1px 5px 10px gray;
	
}
#game_draw_body {
	float: left;
	width: 1024px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	padding: 0px;
}
#top_wel_msg {
  float: right;
  border: 1px solid #ccc;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;


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
    vertical-align: top;

}

td#notMatchNumber { 
  color: #D00000;
  background-color: #FCFCFC;
  text-align: center;  
  font: normal 12px Arial, Helvetica, sans-serif;
    vertical-align: top;
}


td#noWinButMatch {
  color: #D00000;
  background-color: #FCFCFC;
  text-align: center;  
  font: normal 12px Arial, Helvetica, sans-serif;
    vertical-align: top;
}
td#matchBonusNumber {
  color: #0000CC;
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
    vertical-align: top;


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


td#100_thousand_bonus_drawDate {
  color: #336600;
  background-color: #FCFCFC;
  text-align: center;
  font: normal 12px Arial, Helvetica, sans-serif;
    vertical-align: top;

}

td#100_thousand_drawNumber {
  color: #99FF00;
  background-color: #FCFCFC;
  text-align: center;
  font: normal 12px Arial, Helvetica, sans-serif;
    vertical-align: top;
}

td#drawNumber {
  color: #D00000;
  background-color: #FCFCFC;
  text-align: center;
  font: normal 12px Arial, Helvetica, sans-serif;
    vertical-align: top;
}
td#winCount {
  color: #D00000;
  background-color: #FCFCFC;
  text-align: center;
  font: normal 12px Arial, Helvetica, sans-serif;
  vertical-align: top;
}


td#win_amt {
 color: #000000;
 background-color: #FCFCFC;
  text-align: center; 
 font: normal 12px Arial, Helvetica, sans-serif;
   vertical-align: top;

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


#top_nav_bar {
  float: center;
  border: 1px solid #ccc;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;
  

}
#top_wel_msg {
  float: right;
  border: 1px solid #ccc;
  font: normal 12px Arial, Helvetica, sans-serif;
  width: 400px;


}
#nav_years {
	width: 1024px;
	float: left;
	position: relative;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	padding: 0px;
}

#nav_months {
	width: 1024px;
	float: left;
	position: relative;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	padding: 0px;
	visibility: hidden;
}

#nav_disp_limit {
	width: 1024px;
	float: left;
	position: relative;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	padding: 0px;
	visibility: hidden;
}

#nav_draw_view_date {
	visibility: hidden;

}
#nav_action {
	visibility: hidden;
}
#nav_disp_limit_M {
	width: 1024px;
	float: left;
	position: relative;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	padding: 0px;
}

#nav_disp_limit_Y {
	width: 1024px;
	float: left;
	position: relative;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	padding: 0px;
}

#nav_disp_limit_100 {
	width: 1024px;
	float: left;
	position: relative;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	padding: 0px;
}

#nav_disp_limit_200 {
	width: 1024px;
	float: left;
	position: relative;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	padding: 0px;
}

a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
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
[/literal]


<script type="text/javascript">
[$JSOUTPUT]
</script>
</head>

<body onload="MM_preloadImages('images/header/topNav01a.jpg','images/header/topNav01b.jpg','images/header/topNav01c.jpg','images/header/topNav01d.jpg','images/header/SecondNav01a.jpg','images/header/SecondNav01b.jpg','images/header/SecondNav01c.jpg','images/header/SecondNav01d.jpg','images/header/SecondNav01e.jpg','images/header/SecondNav01f.jpg','images/header/SecondNav01g.jpg','images/header/SecondNav01h.jpg','images/header/SecondNav01i.jpg')">
<div id="container">
[$htmlFormStart]
  <div id="logo"><a href="/"><img src="images/header/logo01.jpg" border="0" height="147px" width="412px"></a></div>
  <div id="box">
    <div id="topbox">[$htmltopOut]</div>
    <div id="topnav"><img src="images/header/topNav01b.jpg" width="612" height="31" border="0" usemap="#Map" id="Image1" />
      <map name="Map" id="Map">
        <area shape="rect" coords="55,5,138,29" href="../web3/check_649.php" target="_self" alt="Validate" onmouseover="MM_swapImage('Image1','','images/header/topNav01a.jpg',1)" onmouseout="MM_swapImgRestore()" />
        <area shape="rect" coords="148,5,277,28" href="../web3/view_649.php" onmouseover="MM_swapImage('Image1','','images/header/topNav01b.jpg',1)" onmouseout="MM_swapImgRestore()" />
        <area shape="rect" coords="288,4,421,29" href="../web3/view_649_winnings.php" onmouseover="MM_swapImage('Image1','','images/header/topNav01c.jpg',1)" onmouseout="MM_swapImgRestore()" />
        <area shape="rect" coords="430,4,529,30" href="../web5/quick_649.php" onmouseover="MM_swapImage('Image1','','images/header/topNav01d.jpg',1)" onmouseout="MM_swapImgRestore()" />
      </map>
    </div>
    
  </div>
  <div id="secondNav"><img src="[if $GAME eq 'OLGPOKER']
  images/header/SecondNav01h.jpg
  [elseif $GAME eq 'NA649']
  images/header/SecondNav01b.jpg
  [elseif $GAME eq 'OLG49']
  images/header/SecondNav01c.jpg
  [elseif $GAME eq 'OLGKENO']
  images/header/SecondNav01e.jpg
  [elseif $GAME eq 'OLGPICK3']
  images/header/SecondNav01g.jpg
  [elseif $GAME eq 'OLGLOTTARIO']  
  images/header/SecondNav01d.jpg
  [elseif $GAME eq 'OLGPICK4']
  images/header/SecondNav01f.jpg
  [elseif $GAME eq 'OLGENCORE']
  images/header/SecondNav01i.jpg
  [elseif $GAME eq 'NAMAX']
  images/header/SecondNav01a.jpg
  [else]
  images/header/SecondNav01.jpg
  [/if]" width="1024" height="33" border="0" usemap="#Map2" id="Image2" />
    <map name="Map2" id="Map2">
      <area shape="rect" coords="37,3,135,30" href="view_max.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01a.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="161,4,252,31" href="view_649.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01b.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="271,5,366,31" href="view_49.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01c.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="389,5,465,31" href="view_lottario.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01d.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="495,6,554,31" href="view_keno.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01e.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="578,7,633,30" href="view_pick4.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01f.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="648,9,709,30" href="view_pick3.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01g.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="750,7,807,31" href="view_poker.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01h.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="832,7,905,31" href="view_encore.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01i.jpg',1)" onmouseout="MM_swapImgRestore()" />
    </map>
  </div>
  <div id="thirdNav">[$htmlThirdNav]</div>
  <div id="mainContent">[$htmlOut]</div>
  <div id="footer">
&nbsp;</div>
[$htmlFormEnd]
</div>
</body>
</html>
