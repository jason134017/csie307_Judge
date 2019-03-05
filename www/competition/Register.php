<?php
$account = $_POST['account'];
$truename = $_POST['truename'];
$email = $_POST['email'];

if($account==""){
	echo "<script>alert('警告：請輸入學號');history.go(-1);</script>";	      
}else if($truename==""){
	echo "<script>alert('警告：請輸入真實姓名');history.go(-1);</script>";	      
}else if($email==""){
	echo "<script>alert('警告：請輸入您常用的 email');history.go(-1);</script>";	      
}else{
	$now = date("Y/m/d H:i:s",strtotime("+1 day"));
	$now15 = date("Y/m/d H:i:s",strtotime("+15 day"));
	$link=mysqli_connect("localhost","root","csie307","Judge") or die ("連結失敗");
	mysqli_query($link, 'SET NAMES utf8'); 
	mysqli_query($link,"SET collation_connection ='utf8_general_ci'");
	
	$sql = "SELECT * FROM `competition` WHERE `startdate` >= '".$now."' AND `enddate` <= '".$now15."'; ";
	$result = mysqli_query($link,$sql);
	$row= mysqli_fetch_assoc($result);
	
	$competition = $row['competition_id'];
	
	$sql = "SELECT * FROM `competition_account` WHERE `student_id` LIKE '".$account."' AND `competition_id` LIKE '".$competition."' ; ";
	$result = mysqli_query($link,$sql);
	if ( $row= mysqli_fetch_assoc($result) ){
		echo "<script>alert('報名失敗,學號存在');window.location.href ='Register.html';</script>";
		exit;
	}
	
	$passwd = "";
	//A~Z 65~90 a~z 97~122 1~9 30~39
	for ( $i=0;$i<6;$i++ ){
		$tmp = rand(0,2);
		if ( $tmp==0 ){
			$c = rand(0,25)+65;
			$passwd .= chr($c);
		}else if ( $tmp==1 ){
			$c = rand(0,25)+97;
			$passwd .= chr($c);
		}else if ( $tmp==2 ){
			$c = rand(0,9)+48;
			$passwd .= chr($c);
		}
	}
	
	$sql ="INSERT INTO `competition_account` (`student_id`,`truename`,`e-mail`,`passwd`,`competition_id`)
		   VALUES ('".$account."','".$truename."','".$email."','".$passwd."','".$competition."');";
	if (mysqli_query($link,$sql) === TRUE) {
		echo "<script>alert('報名成功,返回登入頁面');window.location.href ='Homepage.html';</script>";
	}else{
		echo "<script>alert('報名失敗,學號存在');window.location.href ='Register.html';</script>";
	}
	$link->close();
}
?>