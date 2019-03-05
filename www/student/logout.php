<?php
	$account=$_COOKIE['account'];
	$conn=mysqli_connect("localhost","root","csie307") or die ("連結失敗");
	mysqli_select_db($conn, "Judge");
	$sql = "DELETE FROM `online_user` WHERE `account`='$account' ";
    mysqli_query($conn,$sql);
	setcookie("account","",time()-3600,"/student/");
	setcookie("identity","",time()-3600,"/student/");	
    header("location: ../login/Homepage.html");
?>