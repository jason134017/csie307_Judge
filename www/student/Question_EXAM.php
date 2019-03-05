<html>
<?php
	$login=$_COOKIE["account"];
	if($login==""){
		echo "<script>alert('請先登入!!!');top.location.href ='../login/Homepage.html';</script>";
	}else{		
		$Q=$_GET["qid"];
		$exam_id=$_GET['exam_id'];
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
        mysqli_select_db($link, "Judge");
		mysqli_query($link, 'SET CHARACTER SET utf8'); 
        mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
		
		$sql = "SELECT * FROM `exam` WHERE `exam_id` LIKE '".$exam_id."' ;";//查詢整個表單
        $result = mysqli_query($link,$sql) ;
		$row= mysqli_fetch_assoc($result);
		
		if(strtotime($row['startdate'])>strtotime("now")){
			echo "<script>alert('尚未開始');window.location.href ='exam.php';</script>";
		}
		if(strtotime($row['enddate'])<strtotime("now")){
			echo "<script>alert('超出時限');window.location.href ='exam.php';</script>";
		}
		
		$sql = "SELECT * FROM `question` WHERE `qid` LIKE '".$Q."' ;";//查詢整個表單
		$result = mysqli_query($link,$sql) ;
		$row= mysqli_fetch_assoc($result);
		
		echo "<font size='6' color='red'>題號:</font><font size='6' color='orange'>".$row['qid']."</font><br>";
		echo "<font size='4' color='blue'>難度:".$row['difficulty']."</font><br><br><br>";
		$que=$row['question_contents'];
		echo nl2br($que);
	}
	echo "<br><font size='8px'><a href='answer_EXAM.php?qid=".$Q."&exam_id=".$exam_id."'>點此作答</a></font><br><br>";
?>
<a href="javascript:history.back()" >返回上一頁</a>
</html>