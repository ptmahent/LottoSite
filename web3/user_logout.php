<?php
ob_start();
session_start();
require_once("../inc/incUser.php");
require_once("../inc/incAnalytics.php");
$objUser = new User();
$objUser->logout();



?>
<html>
<head>
<title>
LottoSite.Net
</title>
<meta HTTP-EQUIV="REFRESH" content="0; url=http://www.lottosite.net">
</head>
<body>
<a href="http://www.lottosite.net">LottoSite.Net Home</a>
</body>

</html>
