<?php
$account=$_POST['account'];
$password=$_POST['userpasswd'];

if ( !isset($account) ){
	echo "<script>alert('警告：請輸入帳號');window.location.href ='Homepage.html';</script>";
}else if ( $account=="" ){
	echo "<script>alert('警告：請輸入帳號');window.location.href ='Homepage.html';</script>";
}else if ( $password=="" ){
	echo "<script>alert('警告：請輸入密碼');window.location.href ='Homepage.html';</script>";
}else{
	$link =  mysqli_connect("localhost","root","csie307","Judge");
	mysqli_query($conn, 'SET NAMES utf8');
	mysqli_query($link,"SET collation_connection ='utf8_general_ci'");
	
	$sql="SELECT * FROM `competition_account` WHERE `student_id` LIKE '".$account."' ;";
	$result=mysqli_query($link,$sql);
	$row=mysqli_fetch_assoc($result);
	if ( $row==NULL ){
		echo "<script>alert('警告：帳號錯誤');window.location.href ='Homepage.html';</script>";
	}else if ( $row['passwd']!=$password ){
		echo "<script>alert('警告：密碼錯誤');window.location.href ='Homepage.html';</script>";
	}else {
		setcookie("account",$account,time()+3600,"/competition/");
		setcookie("identity","student",time()+3600,"/competition/");
		echo "<script>alert('歡迎 ".$account." 登入');window.location.href ='Homepage.php';</script>";
	}
}
?>