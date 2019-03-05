<?php
	$course_id = $_GET['course_id'];
	$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
	mysqli_select_db($link, "Judge");
	mysqli_query($link,"SET NAMES UTF8");
	mysqli_query($link,"SET collation_connection = 'utf8_general_ci'");
	
	$sql="SELECT * FROM `class`,`student_account` WHERE `course_id` LIKE '".$course_id."' AND `class`.`student_account` LIKE `student_account`.`student_account`";
	
	$result = mysqli_query($link,$sql);
	
	echo "<table border='2'>";
	echo "<tr align='center'>";
	echo "<td>學生帳號</td>";
	echo "<td>學生姓名</td>";
	echo "</tr>";
	while ( $row=mysqli_fetch_assoc($result) ){
		echo "<tr align='center'>";
		echo "<td>".$row['student_account']."</td>";
		echo "<td>".$row['truename']."</td>";
		echo "</tr>";
	}
	echo "</table>";
?>