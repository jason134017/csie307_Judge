<?php
	$qidArr=$_POST['qid'];
	if(count($qidArr)<=0){
		echo "<script>alert('警告：請勾選題號');history.go(-1);</script>";	      
	}else {
		$Count=count($qidArr);
		$link =  mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");  // 建立MySQL的資料庫連結 
		mysqli_select_db($link,"Judge")or die ("無法選擇資料庫".mysql_error()); // 選擇資料庫
		mysqli_query($link, 'SET CHARACTER SET utf8');
		mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
		
		for($i=0;$i<$Count;$i++){ 
		  $sql = "SELECT * FROM `question` WHERE `qid`='".$qidArr[$i]."'";
		  $result = mysqli_query($link,$sql);
		  $row=mysqli_fetch_assoc($result);
		  if ( $row['permission']=="public" ){
				$permission="public";
			}else{
				$permission="private";
			}
		  if( $row['owner']!=$_COOKIE['account'] ){
			echo "<script>alert('沒有權限刪除!');window.location.href='".$permission."_question_bank.php';</script>";
			exit;
		  }
		}

		for($i=0;$i<$Count;++$i){ 
		  $sql = "DELETE FROM `question` WHERE `qid`='".$qidArr[$i]."'";
		  mysqli_query($link,$sql);
		  if($i+1==$Count)$success=true;
		}
		if($success) echo "<script>alert('刪除成功!');window.location.href='".$permission."_question_bank.php';</script>";
	}
?>