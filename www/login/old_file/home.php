<?php
session_start();
if (!isset($_SESSION['account'])) {
    echo "<script>alert('沒有權限登入,返回登入頁面');window.location.href ='/login/Homepage.html';</script>";
	//header("location:../index2.html");
}
else{
?>
<html  lang="zh_tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="Shortcut Icon" type="image/x-icon" href="../Logo/LOGO.png" />
    <title>聯大資工線上程式答題系統</title>
</head>

<frameset rows="20%,80%" cols="*">
    
   
    <frame src="toptest666.html" name="top" scrolling="no" noresize="noresize"/>
    <frameset rows="*" cols="20%,80%" frameborder="1" framespacing="1" border="1">        
     
        <frame src="userinformation.php" name="left" scrolling="auto" noresize="noresize"/>       
        
        <frame src="right.html" name="right" scrolling="auto" noresize="noresize"/>
    </frameset>
</frameset>
</html>
<?php } ?>



