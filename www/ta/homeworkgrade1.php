<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="jquery-tablepage-1.0.js"></script>
<body>
	<table  border="2" name="table1">
	<tr align="center">		
		<td>題號</td>
		<td>答對人數</td>
		<td>答對率</td>	
		<td>難易度</td>	
	</tr>
<?php
	$login=$_COOKIE["account"];
	if($login==""){
		echo "<script>alert('請先登入!!!');window.location.href ='../login/Homepage.html';</script>";
	}
	else{
		$Q=$_GET["hw_id"];
		$Q= str_replace(" ","","$Q");
		echo "作業名稱:".$Q."<br>";
		
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
		mysqli_select_db($link, "Judge");
		
		$sql = "SELECT COUNT(DISTINCT `student_account`) AS count FROM `class`,`homework`,`student_hwgrade` WHERE `homework_id` LIKE '".$Q."' AND `homework_id` LIKE `hwID`
				AND `class`.`course_id` LIKE `homework`.`course_id` AND `class`.`student_account` LIKE `student_hwgrade`.`account`;";//查詢整個表單
		mysqli_query($link, 'SET CHARACTER SET utf8'); 
		mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
		$result = mysqli_query($link,$sql);
		$row= mysqli_fetch_assoc($result);
		$studentNum = $row['count'];
		echo "考試人數:".$row['count']."<br>";
		
		$right = 0;
		$qidArr = array();
		$sql = "SELECT count(*) FROM information_schema.columns WHERE table_schema='Judge' && table_name='homework'";
		$result = mysqli_query($link,$sql);
		$count= mysqli_fetch_assoc($result);
		
		$sql = "SELECT * FROM `homework` WHERE `homework_id` LIKE '".$Q."' ";
		$result = mysqli_query($link,$sql);
		$row= mysqli_fetch_assoc($result);
		for ( $i=1;$i<=($count['count(*)']-4);$i++ ){
			if ( $row["qid_$i"]==NULL ){ $count=$i;break;}
			$qidArr[$i]=$row["qid_$i"];
		}
		
		for ( $i=1;$i<$count;$i++ ){
			$sql = "SELECT COUNT(DISTINCT `student_account`) AS count FROM `class`,`homework`,`student_hwgrade` WHERE `homework_id` LIKE '".$Q."' AND `homework_id` LIKE `hwID`
					AND `class`.`course_id` LIKE `homework`.`course_id`  AND `class`.`student_account` LIKE `student_hwgrade`.`account` 
					AND `student_hwgrade`.`response` LIKE 'AC' AND `student_hwgrade`.`qid` LIKE '".$qidArr[$i]."'; ";
			mysqli_query($link, 'SET CHARACTER SET utf8'); 
			mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
			$result = mysqli_query($link,$sql);
			$row= mysqli_fetch_assoc($result);
			echo "<tr align='center'>		
				<td>".$qidArr[$i]."</td>
				<td>".$row['count']."</td>
				<td>".round($row['count']*100/$studentNum,2)."%</td>";
			$right += $row['count'];
			$sql = "SELECT *FROM `question` WHERE `qid` LIKE '".$qidArr[$i]."'; ";
			mysqli_query($link, 'SET CHARACTER SET utf8'); 
			mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
			$result = mysqli_query($link,$sql);
			$row= mysqli_fetch_assoc($result);
			echo"<td>".$row['difficulty']."</td>
				</tr>";
		}
		
		echo "平均答對題數:".round($right/$studentNum,2)."<br>";
?>
	</table><br>
	
	<table border='2' name='table2' id='table2'>
		<tr align='center'>
			<td>排名</td>
			<td>題數</td>
			<td>分數</td>
			<td>完成時間</td>	
		</tr>
<?php
		$studentArr = array();
		$right_num = array();
		$point = array();
		$datetime = array();
		
		$sql = "SELECT * FROM `class`,`homework` WHERE `homework_id` LIKE '".$Q."' AND `class`.`course_id` LIKE `homework`.`course_id` ORDER BY `class`.`student_account` ASC ; ";
		$result = mysqli_query($link,$sql);
		$t=1;
		while ( $row= mysqli_fetch_assoc($result) ){
			$studentArr[$t]=$row['student_account'];
			$t++;
		}
		
		for ( $i=1;$i<$t;$i++ ){
			$sql = "SELECT COUNT(DISTINCT `qid`) AS count FROM `class`,`homework`,`student_hwgrade` WHERE `homework_id` LIKE '".$Q."' AND `homework_id` LIKE `hwID`
					AND `class`.`course_id` LIKE `homework`.`course_id` AND `class`.`student_account` LIKE `student_hwgrade`.`account` 
					AND `student_hwgrade`.`response` LIKE 'AC' AND `student_hwgrade`.`account` LIKE '".$studentArr[$i]."'; ";
			mysqli_query($link, 'SET CHARACTER SET utf8'); 
			mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
			$result = mysqli_query($link,$sql);
			$row= mysqli_fetch_assoc($result);
			$right_num[$i] = $row['count'];
			$sum = 0;
			for ( $j=1;$j<$count;$j++ ){
				$sql = "SELECT * FROM `student_hwgrade` WHERE `hwID` LIKE '".$Q."' 
						AND `qid` LIKE '".$qidArr[$j]."' AND `account` LIKE '".$studentArr[$i]."' ORDER BY `grade` DESC ; ";
				$result = mysqli_query($link,$sql);
				$row= mysqli_fetch_assoc($result);
				$sum=$sum+$row['grade'];
				if ( $datetime[$i]<=$row['datetime'] ){
					$datetime[$i] = $row['datetime'];
				}
			}
			$point[$i] = $sum;
		}

		for ( $i=1;$i<$t-1;++$i){
			for ( $j=1;$j<$t-1;++$j){
				if ( $right_num[$j]<$right_num[$j+1] ){
					$tmp=$datetime[$j];
					$datetime[$j]=$datetime[$j+1];
					$datetime[$j+1]=$tmp;
					$tmp=$studentArr[$j];
					$studentArr[$j]=$studentArr[$j+1];
					$studentArr[$j+1]=$tmp;
					$tmp=$right_num[$j];
					$right_num[$j]=$right_num[$j+1];
					$right_num[$j+1]=$tmp;
					$tmp=$point[$j];
					$point[$j]=$point[$j+1];
					$point[$j+1]=$tmp;
				}else if ( $right_num[$j]==$right_num[$j+1] ){
					if ( $datetime[$j]>$datetime[$j+1] ){
						$tmp=$datetime[$j];
						$datetime[$j]=$datetime[$j+1];
						$datetime[$j+1]=$tmp;
						$tmp=$studentArr[$j];
						$studentArr[$j]=$studentArr[$j+1];
						$studentArr[$j+1]=$tmp;
						$tmp=$right_num[$j];
						$right_num[$j]=$right_num[$j+1];
						$right_num[$j+1]=$tmp;
						$tmp=$point[$j];
						$point[$j]=$point[$j+1];
						$point[$j+1]=$tmp;
					}
				}
			}
		}
		
		for ( $i=1;$i<$t;$i++){
			echo"<tr align='center'>
			<td>".$studentArr[$i]."</td>
			<td>".$right_num[$i]."</td>
			<td>".$point[$i]."</td>
			<td>".$datetime[$i]."</td>	
			</tr>";
		}
	}
?>
</table><br>
<span id='table_page' style="float:left;"></span>
<script>
	$("#table2").tablepage($("#table_page"), 10);
</script>
<br><br><a href="javascript:history.back()" >返回上一頁</a>
</body>
</html>
<!--SELECT `account`, COUNT(distinct `qid`) AS count FROM `student_examgrade` WHERE `response` LIKE 'AC' AND `examID` LIKE 'GAQuiz2' GROUP BY `account` ORDER BY count DESC LIMIT 20-->
<!--SELECT `account`, COUNT(*) AS count FROM `student_examgrade` WHERE `response` LIKE 'AC' AND `examID` LIKE 'GAQuiz2' GROUP BY `account` ORDER BY count DESC LIMIT 5
SELECT distinct `examID`,`account`,`response` FROM `student_examgrade` WHERE `account` LIKE 'U0%' AND `response` LIKE 'AC' AND `examID` LIKE 'GAQuiz2' ORDER BY `student_examgrade`.`account` ASC-->

