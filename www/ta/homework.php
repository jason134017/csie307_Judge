<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>homework</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="js/jquery-tablepage-1.0.js"></script>
</head>
<body align="center">
	<form name="show" action="ShowHW.php" method="post" id="code" name="form" target='showhw' >
	選擇課程:
	<select name="course" form="code" id="sel" style="font-size :20px">  
		<option value='0'>--------</option>
	</select><br></br>
	<?php
	$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
    mysqli_select_db($link, "Judge");
	mysqli_query($link,"SET NAMES UTF8");
	mysqli_query($link,"SET collation_connection = 'utf8_general_ci'");
    
    $sql = "SELECT * FROM `TA_account`,`course` WHERE `TA_account` LIKE '".$_COOKIE['account']."' AND `TA_account`.`course_id` LIKE `course`.`course_id` ;";//查詢整個表單
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
	<input type="submit" name="show" id="show" value="顯示作業" /><br>
	<iframe id="showhw" name="showhw" style="width:600px;height:300px"></iframe></form>
</body>
</html>