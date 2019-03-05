<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/left_style.css" rel="stylesheet">
	<title>left</title>
 </head>
  <body>
  <META HTTP-EQUIV="REFRESH" CONTENT="1800;URL=logout.php">
	歡迎 
	<?php 
	echo $_COOKIE['account']." 登入</br>";
	?>
	<form action="" name="form1" method="post" target="_top" align='center'>
	<br><br><input value="登出" type="submit"  align="center" onclick="form1.action='logout.php';form1.submit();"/><br>
	</form>
  </body>
</html>