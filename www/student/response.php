<html>
<meta charset="UTF-8">
<title>回報區</title> 
<body>
<form action="" method="post" id="response">
<font color="red" size="5">請告訴我們你的意見:<br></font> 
   <textarea cols="40" rows="20"  name="suggest"></textarea> <br>
<input name="submit" type="submit" value="送出" style="font-size :18px">*採用SMTP發送郵件，可能會稍有緩慢

</form>
<?php
$account=$_COOKIE['account'];
if($_POST['suggest']!=""){
	$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
	mysqli_query($link,"SET NAMES UTF8");
	mysqli_query($link,  "SET collation_connection = ‘utf8_general_ci");
	mysqli_select_db($link, "Judge");	   
	$s=$_POST['suggest'];
	$insert = "INSERT INTO `user_response` (`account`,`suggest`) VALUES ('$account','$s')";
	mysqli_query($link,$insert);//or die ("無法新增");
	//echo "謝謝你的回報與建議!";
	echo "<script>alert('謝謝你的回報與建議!');window.location.href ='response.php';</script>";

//smtp test
$to = "csie307@googlegroups.com";
$subject = "NUU CSIE Judge 問題回報";
$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
回報者".$account."：<br/>
<br/>
問題:
</body>".$s."
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <websiter@example.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);
}
?>
</body>
</html>