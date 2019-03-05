<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="js/jquery-tablepage-1.0.js"></script>
<body align="center">
            <br><br>
			<form action="" method="post" id="delete" name="form">
			<table  style="font-size:18px" border='2' name='table1'  id='table1' width="500" align="center">
				  <tr align="center" style="font-size:20px;font-weight:bold;">			  
					<td >題號</td>
					<td width="80">難度</td>
					<td>標題</td>	
					<td>繳交狀況</td>
				</tr>				
<?php
	$login=$_COOKIE["account"];
	if($login==""){
		echo "<script>alert('請先登入!!!');top.location.href ='/login/Homepage.html';</script>";
	}else{		
        $link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
        mysqli_select_db($link, "Judge");
    
         $sql = "SELECT * FROM `question` WHERE `permission` LIKE 'public' ;";//查詢整個表單
         mysqli_query($link, 'SET CHARACTER SET utf8'); 
         mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
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
			$questionArr[$Count]=$row['question_contents'];
	        $Count++;
		 }
		 
		mysqli_select_db($link, "Judge");
		for($i=1;$i<$Count;$i++){  
			$sql = "SELECT * FROM `student_grade` WHERE `account` LIKE '".$login."' AND `qid` LIKE '".$qidArr[$i]."' ORDER BY `grade` DESC;";
			$result=mysqli_query($link,$sql);
			$row = mysqli_fetch_assoc($result);
			$response=$row['response'];
			
			echo "<tr align='center'>
					<td>  <a href='Question_BANK1.php?qid=".$qidArr[$i]."' >".$qidArr[$i]."</a></td>
					<td> <font> $difficultyArr[$i] </font></td>
					<td> <font> $titleArr[$i] </font></td>";
					/*if($response=="AC")echo"<td><font color='red'>已繳交</font></td>";
					else echo"<td></td>";*/
					echo "<td><font color='red'>".$response."</font></td>";
	              echo "</tr>";				 
        }
		echo  "</table><br>";			
			
		}
?>
		 
		<span id='table_page'></span>
			</br></br>
		 </form><br>
		<script>
		$("#table1").tablepage($("#table_page"), 20);
		</script>
</body>
</html>