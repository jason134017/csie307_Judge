<?php
	session_start();
		if( isset($_COOKIE['account']) ){
			$type=$_GET['type'];
			
			$link = mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
			mysqli_select_db($link, "Judge");
			mysqli_query($link, 'SET CHARACTER SET utf8'); 
			mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
			
			switch($type){
				/*case "username" : $text = $_GET['text'];
								  $sql = "UPDATE `account` SET `username` = '".$text."' WHERE account = '".$_SESSION['account']."';";
								  mysqli_query($link,$sql) or die (mysqli_error($link));
								  $_SESSION['username'] = $text;
								  echo "<script>alert('暱稱更改成功，重新整理後即可生效');window.location.href='userdata.php';</script>";
								  break;*/
				case "passwd"   : $passwd = $_POST['passwd'];
								  $sql = "UPDATE `teacher_account` SET `passwd` = '".$passwd."' WHERE teacher_account = '".$_COOKIE['account']."';";
								  mysqli_query($link,$sql) or die (mysqli_error($link));
								  echo "<script>alert('密碼更改成功');window.location.href='left.php';</script>";
								  break;
			}
		}else{
			echo "<script>alert('發生錯誤，請重新登錄後再嘗試或反應給站務人員');window.history.go(-1);</script>";
		}
?>