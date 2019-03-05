<?php
	$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
	mysqli_select_db($link, "Judge");
	mysqli_query($link,"SET NAMES UTF8");
	mysqli_query($link,"SET collation_connection = 'utf8_general_ci'");
	
	$sql="SELECT * FROM `course` WHERE `teacher_account` LIKE '".$_COOKIE['account']."' ";
	$result = mysqli_query($link,$sql);
	
	echo "<table border='2'>";
	echo "<tr align='center'>";
	echo "<td>課程編號</td>";
	echo "<td>課程名稱</td>";
	echo "</tr>";
	while ( $row=mysqli_fetch_assoc($result) ){
		echo "<tr align='center'>";
		echo "<td><a href='ShowStudent.php?course_id=".$row['course_id']."'/>".$row['course_id']."</td>";
		echo "<td>".$row['course_name']."</td>";
		echo "</tr>";
	}
	echo "</table>";
?>