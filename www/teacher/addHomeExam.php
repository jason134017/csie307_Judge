<?php
	$qidArr=$_POST['qid'];
	$tablename=$_POST['tablename'];
	$Startdate=$_POST['Startdate'];
	$Enddate=$_POST['Enddate'];
	$course=$_POST['course'];
	$count=count($qidArr);
	
	if ( $_POST['course']==0 ){
		echo "<script>alert('警告：請選擇課程');window.location.href ='SelectQuestion.php';</script>";
	}else if($count<=0){
		echo "<script>alert('警告：請勾選題號');window.location.href ='SelectQuestion.php';</script>";	      
	}else if($tablename==""){
		echo "<script>alert('警告：請輸入作業名稱');window.location.href ='SelectQuestion.php';</script>";	
    }else if($Startdate==""){	
		echo "<script>alert('警告：請選擇開始時間');window.location.href ='SelectQuestion.php';</script>";	
	}else if($Enddate==""){	
		echo "<script>alert('警告：請選擇結束時間');window.location.href ='SelectQuestion.php';</script>";	
	}else{
		if ( strpos($_POST['submit'],"考試") ){
			$type = "exam";
		}else{
			$type = "homework";
		}
		$link =  mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");  // 建立MySQL的資料庫連結 
		mysqli_select_db($link,"Judge")or die ("無法選擇資料庫".mysql_error()); // 選擇資料庫
		mysqli_query($link, 'SET CHARACTER SET utf8');
		mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
		
		$sql = "SELECT count(*) FROM information_schema.columns WHERE table_schema='Judge' && table_name='".$type."'";
		$result = mysqli_query($link,$sql);
		
		$row= mysqli_fetch_assoc($result);
		if ( $row['count(*)']-4<$count ){
			for ( $i=2;$i<=$count;$i++ ){
				$tmp = $i-1;
				$sql = "ALTER TABLE `".$type."` ADD `qid_$i` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `qid_$tmp` ";
				mysqli_query($link,$sql);
			}
		}
		
		$sql ="INSERT INTO `".$type."` (`course_id`,`".$type."_id`,`startdate`,`enddate`,`qid_1`) 
			VALUES ('".$course."','".$tablename."','".$Startdate."','".$Enddate."','".$qidArr[0]."')";
		mysqli_query($link,$sql) or die ("新增失敗");
		
		for ( $i=2;$i<=$count;$i++ ){
			$sql = "UPDATE `".$type."` SET `qid_".$i."` = '".$qidArr[$i-1]."' WHERE `".$type."`.`".$type."_id` = '".$tablename."';";
			mysqli_query($link,$sql);
		}
		
		echo "<script>alert('新增成功!');window.location.href ='SelectQuestion.php';</script>";
	}
	
?>
