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
	
	$sql="SELECT * FROM `student_account` WHERE `student_account` LIKE '".$account."' ;";
	$result=mysqli_query($link,$sql);
	$row=mysqli_fetch_assoc($result);
	
	if ( $row==NULL ){
		//非學生帳號 搜尋競賽
		/*$sql="SELECT * FROM `competition_account` WHERE `student_id` LIKE '".$account."' ;";
		$result=mysqli_query($link,$sql);
		$row=mysqli_fetch_assoc($result);
		if ( $row==NULL ){*/
			//非競賽帳號 搜尋老師
			$sql="SELECT * FROM `teacher_account` WHERE `teacher_account` LIKE '".$account."' ;";
			$result=mysqli_query($link,$sql);
			$row=mysqli_fetch_assoc($result);
			if ( $row==NULL ){
				//非老師帳號 搜尋管理者
				$sql="SELECT * FROM `root_account` WHERE `root_account` LIKE '".$account."' ;";
				$result=mysqli_query($link,$sql);
				$row=mysqli_fetch_assoc($result);
				if ( $row==NULL ){
					//非管理者帳號 搜尋助教
					$sql="SELECT * FROM `TA_account` WHERE `TA_account` LIKE '".$account."' ;";
					$result=mysqli_query($link,$sql);
					$row=mysqli_fetch_assoc($result);
					if ( $row==NULL ){
						//沒有帳號
						echo "<script>alert('警告：帳號錯誤');window.location.href ='Homepage.html';</script>";
					}else if ( $row['passwd']!=$password ){
						echo "<script>alert('警告：密碼錯誤');window.location.href ='Homepage.html';</script>";
					}else {
						setcookie("account",$account,time()+3600,"/ta/");
						setcookie("identity","ta",time()+3600,"/ta/");
						echo "<script>alert('歡迎 ".$account." 登入');window.location.href ='../ta/Homepage.php';</script>";
					}
					
				}
				else if ( $row['passwd']!=$password ){
					echo "<script>alert('警告：密碼錯誤');window.location.href ='Homepage.html';</script>";
				}else {
					setcookie("account",$account,time()+3600,"/root/");
					setcookie("identity","root",time()+3600,"/root/");
					echo "<script>alert('歡迎 ".$account." 登入');window.location.href ='../root/Homepage.php';</script>";
				}
			}else if ( $row['passwd']!=$password ){
				echo "<script>alert('警告：密碼錯誤');window.location.href ='Homepage.html';</script>";
			}else {
				setcookie("account",$account,time()+3600,"/teacher/");
				setcookie("identity","teacher",time()+3600,"/teacher/");
				echo "<script>alert('歡迎 ".$account." 登入');window.location.href ='../teacher/Homepage.php';</script>";
			}
		/*}else if ( $row['passwd']!=$password ){
			echo "<script>alert('警告：密碼錯誤');window.location.href ='Homepage.html';</script>";
		}else {
			setcookie("account",$account,time()+3600,"/competition/");
			setcookie("identity","competition",time()+3600,"/competition/");
			echo "<script>alert('歡迎 ".$account." 登入');window.location.href ='/competition/Homepage.html';</script>";
		}*/
	}else if ( $row['passwd']!=$password ){
		echo "<script>alert('警告：密碼錯誤');window.location.href ='Homepage.html';</script>";
	}else {
		setcookie("account",$account,time()+3600,"/student/");
		setcookie("identity","student",time()+3600,"/student/");
		echo "<script>alert('歡迎 ".$account." 登入');window.location.href ='../student/Homepage.php';</script>";
	}
}
?>