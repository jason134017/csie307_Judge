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
		$now = date("Y/m/d H:i:s");
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
        mysqli_select_db($link, "Judge");
		mysqli_query($link, 'SET CHARACTER SET utf8'); 
        mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
		
        $sql = "SELECT * FROM `competition`,`competition_account` WHERE `startdate` <= '".$now."' AND `enddate` >= '".$now."' 
				AND `competition`.`competition_id` LIKE `competition_account`.`competition_id`;";//查詢整個表單
        $result = mysqli_query($link,$sql) ;
		$row= mysqli_fetch_assoc($result);
		
		$competition=$row['competition_id'];
    
		$qidArr=array();
		$difficultyArr=array();
		$titleArr=array();
		
		for ( $i=1;$i<=7;$i++ ){
			$sql = "SELECT * FROM `question`,`competition` WHERE `competition_id` LIKE '".$competition."' AND `qid_".$i."` LIKE `question`.`qid` ;";//查詢整個表單
			$result = mysqli_query($link,$sql);
			$row = mysqli_fetch_assoc($result);
			$qidArr[$i] = $row["qid_$i"];
			$difficultyArr[$i] = $row['difficulty'];
			$titleArr[$i] = $row['title'];
		}
				
		for( $i=1;$i<=7;$i++ ){
			mysqli_select_db($link, "Judge");
			mysqli_query($link, 'SET CHARACTER SET utf8'); 
			mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
			$sql = "SELECT * FROM `competition_grade` WHERE `account` LIKE '".$login."' AND `competitionID` LIKE '".$competition."' AND `qid` LIKE '".$qidArr[$i]."' ORDER BY `grade` DESC;";
			
			$result=mysqli_query($link,$sql);
			$row = mysqli_fetch_assoc($result);
			$response=$row['response'];	
				echo "<tr align='center'>
					<td><a href='Question_EXAM.php?qid=".$qidArr[$i]."&competition=".$competition."'>".$qidArr[$i]."</a></td>
					<td><font>".$difficultyArr[$i]."</font></td>
					<td><font>".$titleArr[$i]."</font></td>";
					echo "<td><font color='red'>".$response."</font></td>";
	              echo "</tr>";				 
			}
		}
?>
			</table>
</html>