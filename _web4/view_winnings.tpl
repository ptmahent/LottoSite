<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lotto Site.Net</title>
[literal]
<link type="text/css" rel="stylesheet" href="../inc/validform/css/validform.css" />
<script type="text/javascript" src="../inc/validform/libraries/jquery.js"></script>
<script type="text/javascript" src="../inc/validform/libraries/validform.js"></script>
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
      $("#nav_disp_limit").css("visibility", "hidden");
      $("#nav_action").css("visibility", "visible");
   });
  
   $("#nav_disp_limit span").click(function () {
      var nv_disp_limit = "nav_disp_limit_";
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("color","#AC3537");
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("border","none");
      frmViewLotto.limit.value = $(this).attr("id").substring(nv_disp_limit.length);
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("color","#405BA2");
      $("#" + nv_disp_limit + frmViewLotto.limit.value).css("border", "1px solid #CF9B00");
      
   });
  });
 function setYear(intYear) {
  frmViewLotto.st_year.value = intYear;
  $("#nav_months").show("fast");
  $("#nav_action").css("visibility", "hidden");
 }
 function setMonth(intMonth) {
  frmViewLotto.st_month.value = intMonth;
  $("#nav_action").show("fast");
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
}

#footer {
	background-image: url(images/footer.png);
	margin: 0px;
	padding: 0px;
	height: 40px;
	width: 1024px;
	position: relative;
}
#thirdNav {
	margin: 0px;
	padding: 0px;
	float: left;
	height: 180px;
	width: 1024px;
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
</head>

<body onload="MM_preloadImages('images/header/topNav01a.jpg','images/header/topNav01b.jpg','images/header/topNav01c.jpg','images/header/topNav01d.jpg','images/header/SecondNav01a.jpg','images/header/SecondNav01b.jpg','images/header/SecondNav01c.jpg','images/header/SecondNav01d.jpg','images/header/SecondNav01e.jpg','images/header/SecondNav01f.jpg','images/header/SecondNav01g.jpg','images/header/SecondNav01h.jpg','images/header/SecondNav01i.jpg')">
<div id="container">
[$htmlFormStart]
  <div id="logo"> </div>
  <div id="box">
    <div id="topbox">[$htmltopOut]</div>
    <div id="topnav"><img src="images/header/topNav01.jpg" width="612" height="31" border="0" usemap="#Map" id="Image1" />
      <map name="Map" id="Map">
        <area shape="rect" coords="55,5,138,29" href="check_649.php" target="_self" alt="Validate" onmouseover="MM_swapImage('Image1','','images/header/topNav01a.jpg',1)" onmouseout="MM_swapImgRestore()" />
        <area shape="rect" coords="148,5,277,28" href="view_649.php" onmouseover="MM_swapImage('Image1','','images/header/topNav01b.jpg',1)" onmouseout="MM_swapImgRestore()" />
        <area shape="rect" coords="288,4,421,29" href="view_649_winnings.php" onmouseover="MM_swapImage('Image1','','images/header/topNav01c.jpg',1)" onmouseout="MM_swapImgRestore()" />
        <area shape="rect" coords="430,4,529,30" href="#" onmouseover="MM_swapImage('Image1','','images/header/topNav01d.jpg',1)" onmouseout="MM_swapImgRestore()" />
      </map>
    </div>
    
  </div>
  <div id="secondNav"><img src="images/header/SecondNav01.jpg" width="1024" height="33" border="0" usemap="#Map2" id="Image2" />
    <map name="Map2" id="Map2">
      <area shape="rect" coords="37,3,135,30" href="view_max_winnings.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01a.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="161,4,252,31" href="view_649_winnings.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01b.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="271,5,366,31" href="view_49_winnings.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01c.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="389,5,465,31" href="view_lottario_winnings.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01d.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="495,6,554,31" href="view_keno_winnings.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01e.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="578,7,633,30" href="view_pick4_winnings.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01f.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="648,9,709,30" href="view_pick3_winnings.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01g.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="750,7,807,31" href="view_encore_winnings.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01h.jpg',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="832,7,905,31" href="view_poker_winnings.php" onmouseover="MM_swapImage('Image2','','images/header/SecondNav01i.jpg',1)" onmouseout="MM_swapImgRestore()" />
    </map>
  </div>
  <div id="thirdNav">[$htmlThirdNav]</div>
  <div id="mainContent">[$htmlOut]</div>
  <div id="footer">[$htmlFormEnd]</div>
</div>
</body>
</html>
