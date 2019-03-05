<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SelectQuestion</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="js/jquery-tablepage-1.0.js"></script>
</head>
<body align="center">
	<form action="addHomeExam.php" method="post" id="code" name="form">
	<table  border='2' name='table1' id='table1' width="500" align="center">
		<tr align='center'>	
        <td width="50">勾選</td>				  
		<td>題號</td>
		<td width="80">難度(1~5)</td>
		<td>標題</td>	
		</tr>
		<?php
			$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
			mysqli_select_db($link, "Judge");
			mysqli_query($link, 'SET CHARACTER SET utf8'); 
			mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
			
			$sql = "SELECT * FROM `question` ;";//查詢整個表單
			$result = mysqli_query($link,$sql) ;
				
			$qidArr=array();     //用來存哪些選項的陣列
			$difficultyArr=array(); 
			$titleArr=array(); 
			$questionArr=array();
			$Count=1;
				
			while($row= mysqli_fetch_assoc($result)){
				$qidArr[$Count]=$row['qid'];
				$difficultyArr[$Count]=$row['difficulty'];
				$titleArr[$Count]=$row['title'];
				$questionArr[$Count]=$row['question'];
				echo "<tr align='center'>
				<td> <input type='checkbox' name='qid[]' value='".$qidArr[$Count]."'></td>
				<td>  <a href='Question.php?A=".$qidArr[$Count]."' >".$qidArr[$Count]."</a></td>
				<td> <font> $difficultyArr[$Count] </font></td>
				<td> <font> $titleArr[$Count] </font></td>
				</tr>";
				$Count++;
			}
		?>
	</table><br>
	<center><div style="position:absolute; left:45%" id="table_page"></div></center>
	</br></br>
	選擇課程:
	<select name="course" form="code" id="sel" style="font-size :20px">  
		<option value='0'>--------</option>
	</select><br></br>
	<?php
	$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
    mysqli_select_db($link, "Judge");
	mysqli_query($link,"SET NAMES UTF8");
	mysqli_query($link,"SET collation_connection = 'utf8_general_ci'");
    
    $sql = "SELECT * FROM `course` ;";//查詢整個表單
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
	作業名稱:<Input Type="text" name="tablename"><br>
	<font color ="	#7700BB"  style="font-weight:bold;" >開始時間： </font>
	<input type="datetime-local" id="Startdate" name="Startdate"><br>
	<font color ="	#7700BB"  style="font-weight:bold;" >截止時間： </font>
	<input type="datetime-local" id="Enddate" name="Enddate"><br><br>
	<input name="submit" type="submit" value="送出作業" style="font-size :18px">
	<input name="submit" type="submit" value="送出考試" style="font-size :18px">
	</form>
	<script>
	$("#table1").tablepage($("#table_page"), 20);
	</script>
</body>
</html>