<?php
$account = $_POST['account'];
$userpasswd = $_POST['userpasswd'];
$checkpasswd = $_POST['checkpasswd'];
$username = $_POST['username'];
$identityID ="A000000000";
$truename = $_POST['truename'];
$email = $_POST['email'];

$link=mysqli_connect("localhost","root","csie307","Judge") or die ("連結失敗");
mysqli_query($link, 'SET NAMES utf8'); 
mysqli_query($link,"SET collation_connection ='utf8_general_ci'");
$sql="SELECT * FROM `student_account` WHERE `username` LIKE '".$username."'; ";
$result=mysqli_query($link,$sql);

if($account==""){
	echo "<script>alert('警告：請輸入帳號');history.go(-1);</script>";	      
}else if(strlen($userpasswd)<6){
	echo "<script>alert('警告：密碼長度不得小於6個字元');history.go(-1);</script>";	      
}else if(strlen($checkpasswd)<6){
	echo "<script>alert('警告：確認密碼長度不得小於6個字元');history.go(-1);</script>";	      
}else if($userpasswd != $checkpasswd){
	echo "<script>alert('警告：兩次密碼並不相同，請重新輸入!!');history.go(-1);</script>";	      
}else if($username==""){
	echo "<script>alert('警告：請輸入公開暱稱');history.go(-1);</script>";	  		
}else if($row=mysqli_fetch_assoc($result)){
	echo "<script>alert('警告：暱稱有人使用');history.go(-1);</script>";
}else if($truename==""){
	echo "<script>alert('警告：請輸入真實暱稱');history.go(-1);</script>";	      
}else if($email==""){
	echo "<script>alert('警告：請輸入您常用的 email');history.go(-1);</script>";	      
}else{
	$md5=hash('md5',$userpasswd);
	$link=mysqli_connect("localhost","root","csie307","Judge") or die ("連結失敗");
	mysqli_query($link, 'SET NAMES utf8'); 
	mysqli_query($link,"SET collation_connection ='utf8_general_ci'");
	$sql ="INSERT INTO `student_account` (`student_account`,`passwd`,`username`,`identityID`,`truename`,`e-mail`,`passwd_md5`)
		   VALUES ('".$account."','".$userpasswd."','".$username."','".$identityID."','".$truename."','".$email."','".$md5."');";
	if (mysqli_query($link,$sql) === TRUE) {
		echo "<script>alert('創建成功,返回登入頁面');window.location.href ='Homepage.html';</script>";
	}else{
		echo "<script>alert('創建失敗,帳號存在');window.location.href ='Register.html';</script>";
	}
	$link->close();
}
?>