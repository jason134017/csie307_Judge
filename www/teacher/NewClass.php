<?php
	$class = str_replace("'","&apos;",$_POST['class']);
	
	$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
	mysqli_select_db($link, "Judge");
	mysqli_query($link,"SET NAMES UTF8");
	mysqli_query($link,"SET collation_connection = 'utf8_general_ci'");
	$sql = "INSERT INTO `course`(`course_name`) VALUES('".$class."')";
	if ( mysqli_query($link,$sql) ){
		echo "<script>alert('新增成功');window.location.href='NewClass.html';</script>";
	}else{
		echo "<script>alert('新增失敗');window.location.href='NewClass.html';</script>";
	}
?>