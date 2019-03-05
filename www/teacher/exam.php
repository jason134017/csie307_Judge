<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>exam</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="js/jquery-tablepage-1.0.js"></script>
</head>
<body align="center">
	<form name="show" action="ShowExam.php" method="post" id="code" name="form" target='showexam' >
	選擇課程:
	<select name="course" form="code" id="sel" style="font-size :20px">  
		<option value='0'>--------</option>
	</select><br></br>
	<?php
	$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
    mysqli_select_db($link, "Judge");
	mysqli_query($link,"SET NAMES UTF8");
	mysqli_query($link,"SET collation_connection = 'utf8_general_ci'");
    
    $sql = "SELECT * FROM `course` WHERE `teacher_account` LIKE '".$_COOKIE['account']."';";//查詢整個表單
    $result = mysqli_query($link,$sql) ;
    
	$course_id=array();
    $courseArr=array();     //用來存哪些選項的陣列
    $count=1;	
		 
	while( $row= mysqli_fetch_assoc($result) ){
		$course_id[$count]=$row['course_id'];
		$courseArr[$count]=$row['course_name'];
	    $count++;
	}
	for($i=1;$i<$count;$i++){	 
	    echo "<script type=\"text/javascript\">";
	    echo "document.getElementById(\"sel\").options[$i]=new Option(\"$course_id[$i] $courseArr[$i]\",\"$course_id[$i]\")";
	    echo "</script>";
    }
	?>
	<input type="submit" name="show" id="show" value="顯示考試" /><br>
	<iframe id="showexam" name="showexam" style="width:600px;height:300px"></iframe></form>
</body>
</html>