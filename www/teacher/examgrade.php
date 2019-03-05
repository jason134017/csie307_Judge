<html>
<body align="center">
            <br><br>
<?php
	$login=$_COOKIE["identity"];
	if($login!="teacher"){
		echo "<script>alert('請先登入!!!');window.location.href ='../login/Homepage.html';</script>";
	}
	else{		
		$Q=$_GET["exam_id"];
		$qidArr=array();
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
		mysqli_select_db($link, "Judge");
		mysqli_query($link, 'SET CHARACTER SET utf8'); 
		mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");

		$sql = "SELECT count(*) FROM information_schema.columns WHERE table_schema='Judge' && table_name='exam'";
		$result = mysqli_query($link,$sql);
		$count= mysqli_fetch_assoc($result);

		echo "<table  style='font-size:18px' border='2' name='table1' width='500' align='center'>";
		echo "<td>".$Q."</td>";
		echo "<tr align='center' style='font-size:20px;font-weight:bold;'>";
		echo "<td width='80'>userID</td>";
		
		$sql = "SELECT * FROM `exam` WHERE `exam_id` LIKE '".$Q."' ";
		$result = mysqli_query($link,$sql);
		$row= mysqli_fetch_assoc($result);
		for ( $i=1;$i<=($count['count(*)']-4);$i++ ){
			if ( $row["qid_$i"]==NULL ){ $count=$i;break;}
			if ( $i==($count['count(*)']-4) ){ $count=$i;break;}
			echo "<td>".$row["qid_$i"]."</td>";
			$qidArr[$i]=$row["qid_$i"];
		}
		echo "<td>Grade</td>";
		echo "</tr>";
		
		$studentArr=array();
		$sql = "SELECT * FROM `class`,`exam` WHERE `exam_id` LIKE '".$Q."' AND `class`.`course_id` LIKE `exam`.`course_id` ORDER BY `class`.`student_account` ASC ; ";
		$result = mysqli_query($link,$sql);
		$t=1;
		while ( $row= mysqli_fetch_assoc($result) ){
			$studentArr[$t]=$row['student_account'];
			$t++;
		}
		
		for ( $i=1;$i<$t;$i++ ){
			echo "<tr align='center' style='font-size:20px;font-weight:bold;'>";
			echo "<td>".$studentArr[$i]."</td>";
			$sum=0;
			for ( $j=1;$j<$count;$j++ ){
				$sql = "SELECT * FROM `student_examgrade` WHERE `examID` LIKE '".$Q."' AND `qid` LIKE '".$qidArr[$j]."' AND `account` LIKE '".$studentArr[$i]."' ORDER BY `grade` DESC ; ";
				$result = mysqli_query($link,$sql);
				$row= mysqli_fetch_assoc($result);
				echo "<td>".$row['grade']."</td>";
				$sum=$sum+$row['grade'];
			}
			echo "<td>".$sum."</td>";
			echo "</tr>";
		}
	}
	echo "</table><br>";
	echo "<a href='examgrade1.php?exam_id=".$Q."' >成績統計</a></br>";
?>
<a href="javascript:history.back()" >返回上一頁</a>
</body>
</html>