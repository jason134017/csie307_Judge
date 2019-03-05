<?php
	$student_account = $_POST['student_account'];
	$count = count($student_account);
	if ( $_POST['course']==0 ){
		echo "<script>alert('警告：請選擇課程');window.location.href ='SelectStudent.php';</script>";
	}else if ( $count<=0 ){
		echo "<script>alert('警告：請選擇學生');window.location.href ='SelectStudent.php';</script>";
	}else{
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
		mysqli_select_db($link, "Judge");
		mysqli_query($link,"SET NAMES UTF8");
		mysqli_query($link,"SET collation_connection = 'utf8_general_ci'");
		
		for ( $i=0;$i<$count;$i++ ){
			$sql = "SELECT * FROM `class` WHERE `student_account` LIKE '".$student_account[$i]."' AND `course_id` LIKE '".$_POST['course']."' ";
			$result = mysqli_query($link,$sql);
			if ( $row= mysqli_fetch_assoc($result) ){
				continue;
			}
			$sql="INSERT INTO `class` (`student_account`, `course_id`, `teacher_account`) VALUES 
				('".$student_account[$i]."','".$_POST['course']."','".$_COOKIE['account']."')";
			if ( !mysqli_query($link,$sql) ){
				echo "<script>alert('警告：新增失敗');window.location.href ='SelectStudent.php';</script>";
			}
		}
		echo "<script>alert('新增成功');window.location.href ='SelectStudent.php';</script>";
	}
?>