<html>
<body align="center">
            <br><br>
		<form action="" method="post" id="delete" name="form">
			<table  style="font-size:18px" border='2' name='table1' width="550" align="center">
				  <tr align="center" style="font-size:20px;font-weight:bold;">	
					<td width="50">勾選</td>
					<td >題號</td>
					<td >開始時間</td>
					<td >結束時間</td>
					<td>狀態 </td>
				</tr>				
<?php
	$course = $_POST['course'];
	$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
    mysqli_select_db($link, "Judge");
	
	$sql = "SELECT * FROM `exam` WHERE `course_id` LIKE '".$course."' ;";//查詢整個表單
    mysqli_query($link, 'SET CHARACTER SET utf8'); 
	mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
	$result = mysqli_query($link,$sql);

	while($row= mysqli_fetch_assoc($result)){
		echo "<tr align='center'>
					<td> <input type='checkbox' name='exam[]' id='exam[]' value='".$row['exam_id']."'></td>
					<td>  <a href='examgrade.php?exam_id=".$row['exam_id']."' target='right' >".$row['exam_id']."</a></td>
					<td> <font> ".$row['startdate']." </font></td>
					<td> <font> ".$row['enddate']." </font></td>";
			if(strtotime($row['startdate'])>strtotime("now")){
				echo "<td> <font color='red'>未開始 </font></td>";
			}
			if(strtotime($row['enddate'])<strtotime("now")){
				echo "<td> <font color='red'>已結束 </font></td>";
			}
			if (strtotime($row['startdate'])<strtotime("now") && strtotime($row['enddate'])>strtotime("now") ){
				echo "<td> <font color='red'>進行中 </font></td>";
			}
	    echo "</tr>";
	}
?>
		</table>
		<?php
			echo "<input type='submit' name='submit' value='測試' style='font-size:18px target='right' onclick=\"form.action='examtopic.php'\">";
		?>
		<input type="submit" name="submit" value="刪除" style="font-size:18px" formtarget="_parent" onclick="form.action='DeleteExam.php'">	
	</form><br>
</html>