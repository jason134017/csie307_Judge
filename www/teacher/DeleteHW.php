<?php
	$HWArr=$_POST["HW"];
	if(count($HWArr)<=0){
		echo "<script>alert('警告：請勾選題號');window.location.href ='homework.php';</script>";	      
	}else {
		$link =  mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");  // 建立MySQL的資料庫連結 
		mysqli_select_db($link,"Judge");
		mysqli_query($link, 'SET CHARACTER SET utf8');
		mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
	
		$Count=count($HWArr);
		for($i=0;$i<$Count;$i++){ 
			$sql = "DELETE FROM `student_hwgrade` WHERE `hwID` LIKE '".$HWArr[$i]."'";
			mysqli_query($link,$sql);
			$sql = "DELETE FROM `homework` WHERE `homework_id` LIKE '".$HWArr[$i]."'";
			mysqli_query($link,$sql);
			if($i+1==$Count)$success=true;
		}
		if($success) echo "<script>alert('刪除成功!');window.location.href ='homework.php';</script>";
	}
?>