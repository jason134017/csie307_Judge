<?php
if (!isset($_COOKIE['account']) || $_COOKIE['identity']!="student" ) {
    echo "<script>alert('沒有權限登入,返回登入頁面');window.location.href ='../login/Homepage.html';</script>";
}
?>
<!doctype html>
<html  lang="zh_tw">

<head> 
<meta charset="UTF-8">
<title>歡迎登入</title> 
<link href="./css/left_style.css" rel="stylesheet">
<script src="./lib/jquery/jquery-3.3.1.min.js"></script>
<script type='text/javascript'>
/*$(window).on('beforeunload', function() {
  return 'Your own message goes here...';
});*/
</script>
</head>

<body>
<META HTTP-EQUIV="REFRESH" CONTENT="1800;URL=logout.php">
歡迎 <?php 

echo $_SESSION['account']." 登入</br>";
$conn=mysqli_connect("localhost","student","student","student");
 mysqli_query($conn, 'SET NAMES utf8');  
mysqli_select_db($conn,"student");
if (!$conn) 
           { die("資料庫意外: " . mysqli_connect_error()); 
           } else{
	         $query = "SELECT * FROM student_account". 
	                 " WHERE account='".$_SESSION['account']."' ";  //帳號
		     $result = mysqli_query($conn,$query);	
	            //把撈出來的資料讀取出來
             $row_result=mysqli_fetch_assoc($result);
			 $account=$row_result['account'];
			 $username=$row_result['username'];
			 $truename=$row_result['truename'];
			 $IPaddr=$_SERVER['REMOTE_ADDR'];
			 
			 echo "暱稱:".$username."</br>";
			// echo "email:".$row_result["email"]."</br>";
			 
             $sql = "SELECT * FROM `online_user` WHERE account='$account'";
             $result = mysqli_query($conn,$sql);					 					  
             $row_result=mysqli_fetch_assoc($result); //取得資料筆數					 
		     $acc =  $row_result['account'];
		     date_default_timezone_set('Asia/Taipei');
	         $datetime= date("Y/m/d H:i:s");
			 $_SESSION['time']=$datetime;
		  //  echo $acc;
					  
				    if ($acc == $account) {
                         $sql = "UPDATE `online_user` SET `datetime`='$datetime', `IPaddr`= '$IPaddr' WHERE `account`='$account'";
                        } else {
                          $sql="INSERT INTO `online_user` (`account`, `username`, `IPaddr`) VALUES ('$account','$username','$IPaddr')";
                       }
              		  mysqli_query($conn, 'SET NAMES utf8');  
				      mysqli_query($conn,$sql)or die("fail");
			 
		    }		
      
	  			
	          
?>
<form action="" name="form1" method="post" target="_top" align='center'>
<br><br><input value="登出" type="submit"  align="center" onclick="form1.action='logout.php';form1.submit();"/><br>
</form>
<form  align='center'>
<?php  
       $sql="SELECT * FROM online_user;";
       $result= mysqli_query($conn,$sql) or die ("ERROR");
	   $count=0;
	   $people=array();
	   while($row_result=mysqli_fetch_assoc($result))
	   {
		   $datetime2=$row_result['datetime'];
		   $last=strtotime($datetime)-strtotime($datetime2);
		   if($last>=1800)
		   {
			  $delete = "DELETE FROM `online_user` WHERE `datetime`='$datetime2'";
              mysqli_query($conn,$delete) or die ("ERROR");			  
		   }
	   }
	   $result= mysqli_query($conn,$sql) or die ("ERROR");
	    while($row_result=mysqli_fetch_assoc($result))
	   {
	   $people[$count]=$row_result['username'];
		++$count;
	   }
	   echo "<font color='blue' size = '5px'>最近登入使用者:</font><br><br><font size = '4px'>";
	   for($i=$count-1;$i>($count-10);--$i)
	   {
		   echo $people[$i]."<br>";
	   }
	   for($i=0;$i<10;++$i)  echo"<br>";

	   echo "</font>";
	   echo "<font>線上總人數:".$count."</font><br>";
       $sql="SELECT max(login_times) FROM login_information ;";
       $result= mysqli_query($conn,$sql) or die ("ERROR");
	   $row_result=mysqli_fetch_assoc($result);
	   $max=$row_result['max(login_times)'];
	   echo "<font>登入總人次:".$max."</font>";
	   
	    $sql="SELECT * FROM `online_user` WHERE account='$account'";
			  $result = mysqli_query($conn,$sql);
			  $row_result=mysqli_fetch_assoc($result); //取得資料筆數				 
			   
						
                if ($row_result['account'] == $account) {
                     $exist=true;
                    } else {
                     $exist=false;
                    }
			
			if ( !$exist  || !isset($_SESSION['come'])) {
			//echo "HI".$_SESSION['come'];
			 $sql="INSERT INTO `login_information` (`account`, `username`, `truename`, `IPaddr`) VALUES (' $account','$username','$truename','$IPaddr')";
			 mysqli_query($conn,$sql) ;
			 $_SESSION['come']="yes";
			}
			elseif ($exist){
				$sql = "UPDATE `login_information` SET `datetime`='$datetime', `IPaddr`= '$IPaddr' WHERE `login_times`='$max'";
				mysqli_query($conn,$sql) ;
			}

?>
</form>
</body>

</html>
