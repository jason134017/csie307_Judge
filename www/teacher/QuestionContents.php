<html>
<?php
	$login=$_COOKIE["account"];
	if($login==""){
		echo "<script>alert('請先登入!!!');window.location.href ='/login/home.php';</script>";
	}
	else{		
$Q=$_GET["Q"];
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
		mysqli_select_db($link, "Judge");
		
		$sql = "SELECT * FROM `question` WHERE qid='".$Q."' ;";//查詢整個表單
		mysqli_query($link, 'SET CHARACTER SET utf8'); 
		mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
		$result = mysqli_query($link,$sql) ;
		
		$HWqid=array();
		
		while($row= mysqli_fetch_assoc($result)){
			echo "<font size='6' color='red'>題號:</font><font size='6' color='orange'>".$row['qid']."</font><br>";
			echo "<font size='4' color='blue'>難度:".$row['difficulty']."</font><br><br><br>";
			$que=$row['question_contents'];
			echo nl2br($que);
		}
	}
?>
<br>
<a href="javascript:history.back()" >返回上一頁</a>
</html>