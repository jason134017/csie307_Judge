<html>
<body align="center">
            <br><br>
			<table  style="font-size:18px" border='2' name='table1' width="500" align="center">
				  <tr align="center" style="font-size:20px;font-weight:bold;">			  
					<td >題號</td>
					<td width="80">難度</td>
					<td>標題</td>
					<td>繳交狀況</td>
				</tr>
<?php
	$login=$_COOKIE["account"];
	if($login==""){
		echo "<script>alert('請先登入!!!');top.location.href ='../login/Homepage.html';</script>";
	}
	else{
		$exam_id=$_POST["exam"];
		$exam_id=$exam_id[0];
		echo $exam_id;
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
        mysqli_select_db($link, "Judge");
		mysqli_query($link, 'SET CHARACTER SET utf8'); 
        mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
		
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
        mysqli_select_db($link, "Judge");
		mysqli_query($link, 'SET CHARACTER SET utf8'); 
        mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
    
		$sql = "SELECT count(*) FROM information_schema.columns WHERE table_schema='Judge' && table_name='exam'";
		$result = mysqli_query($link,$sql);
		$count= mysqli_fetch_assoc($result);
		
		$qidArr=array();
		$difficultyArr=array();
		$titleArr=array();
		
		for ( $i=1;$i<=($count['count(*)']-4);$i++ ){
			$sql = "SELECT * FROM `question`,`exam` WHERE `exam_id` LIKE '".$exam_id."' AND `qid_".$i."` LIKE `question`.`qid` ;";//查詢整個表單
			$result = mysqli_query($link,$sql);
			$row = mysqli_fetch_assoc($result);
			if ( $row["qid_$i"]==NULL ){break;}	
			$qidArr[$i] = $row["qid_$i"];
			$difficultyArr[$i] = $row['difficulty'];
			$titleArr[$i] = $row['title'];
		}
				
		for( $i=1;$i<=($count['count(*)']-4);$i++ ){
			if ( $qidArr[$i]==NULL ){break;}
			mysqli_select_db($link, "Judge");
			mysqli_query($link, 'SET CHARACTER SET utf8'); 
			mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
			$sql = "SELECT * FROM `teacher_grade` WHERE `account` LIKE '".$login."' AND `ID` LIKE '".$exam_id."' AND `qid` LIKE '".$qidArr[$i]."' ORDER BY `grade` DESC;";
			
			$result=mysqli_query($link,$sql);
			$row = mysqli_fetch_assoc($result);
			$response=$row['response'];	
				echo "<tr align='center'>
					<td><a href='Question_EXAM.php?qid=".$qidArr[$i]."&exam_id=".$exam_id."' target='right'>".$qidArr[$i]."</a></td>
					<td><font>".$difficultyArr[$i]."</font></td>
					<td><font>".$titleArr[$i]."</font></td>";
					echo "<td><font color='red'>".$response."</font></td>";
	              echo "</tr>";				 
			}
		}
?>
			</table>
<a href="javascript:history.back()" >返回上一頁</a>
</html>