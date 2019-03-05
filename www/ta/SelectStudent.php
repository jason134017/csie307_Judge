<html>
<head> 
	<meta charset="UTF-8">
	<title>SelectClass</title> 
	<!-- // 引用 jQuery.js 和 jQuery-TablePage.js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="js/jquery-tablepage-1.0.js"></script>
</head>
<body>
	<form action="JoinClass.php" method="post" id="code" align="left">
	請選擇課程:
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
	<table  style="font-size:18px" border='2' name='table1' id='table1' width="200" >
		<tr style="font-size:20px;font-weight:bold;">			  
		    <td width="50">勾選</td>
			<td >學生</td>
		</tr>
	<?php
		if($_COOKIE['account']==""){
			//top.location.href讓整個畫面跳轉
			echo "<script>alert('請先登入!!!');top.location.href ='/login/Homepage.html';</script>";
		}else{	
			$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
			mysqli_select_db($link, "Judge");
    
			$sql = "SELECT * FROM `student_account` ORDER BY `student_account` ASC;";//查詢私人題庫
			mysqli_query($link, 'SET CHARACTER SET utf8'); 
			mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
			$result = mysqli_query($link,$sql) ;
		 
			while ( $row=mysqli_fetch_assoc($result) ){
				echo "<tr>";
				echo "<td><input type='checkbox' name='student_account[]' value='".$row['student_account']."'></td>";
				echo "<td>".$row['student_account']."</td>";
				echo "</tr>";
			}		 
		}
	?>
	</table>
	<span id='table_page' style="float:left;"></span><br><br>
	<input type="submit" name="submit" value="送出" style="font-size:18px">
</form>
<script>
	$("#table1").tablepage($("#table_page"), 20);
</script>
</body>
</html>