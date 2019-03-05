<html>
<head>
<meta charset="utf-8">
<title>作答區</title>
</head>
<body>
<form action="execode_EXAM.php" name="form" method="post" id="code">
<?php
	$Q=$_GET["qid"];
	$exam_id=$_GET['exam_id'];
	$login=$_COOKIE["account"];
	if($login==""){
		echo "<script>alert('請先登入!!!');top.location.href ='../login/Homepage.html';</script>";
	}else{
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
		echo "<font size='6' color='red'>題號:</font><font size='6' color='orange'>".$Q."</font><br>";	
	}
    echo "<input name='exam_id'  type='hidden' value='".$exam_id."'>";
    echo "<input name='qid'  type='hidden' value='".$Q."'>";
	echo "<input name='exam'  type='hidden' value='".$exam_id."'>";
    echo '<font color="red" size="5">請在此輸入程式碼:<br></font>';
    echo '<textarea cols="50" rows="30"  name="code"></textarea> <br>';
?>
<input name="submit" type="submit" value="送出" style="font-size :18px" >
<input name="back" type="button" value="返回題目" style="font-size:18px" onclick="history.go(-1)">
<?php
	//echo "<input name='back' type='button' value='返回選項' style='font-size:18px' onclick=\"window.location.href='examtopic.php'\">";
?>
</form>
</body>
</html>