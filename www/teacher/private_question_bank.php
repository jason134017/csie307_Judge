<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="js/jquery-tablepage-1.0.js"></script>

<body align="center">
<form action="" method="post" id="form" name="form">

	<table  style="font-size:18px" border='2' name='table1' id='table1' width="600" align="center">
		<tr align="center" style="font-size:20px;font-weight:bold;">			  
		    <td width="50">勾選</td>
			<td >題號</td>
			<td width="80">難度</td>
			<td>標題</td>
			<td>分類</td>
			<td>出題者</td>
		</tr>				
<?php
	if($_COOKIE['account']==""){
		//top.location.href讓整個畫面跳轉
		echo "<script>alert('請先登入!!!');top.location.href ='/login/Homepage.html';</script>";
	}else{	
        $link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
        mysqli_select_db($link, "Judge");
    
         $sql = "SELECT * FROM `question` WHERE `permission` LIKE 'private';";//查詢私人題庫
         mysqli_query($link, 'SET CHARACTER SET utf8'); 
         mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
         $result = mysqli_query($link,$sql) ;
		 
		 while ( $row=mysqli_fetch_assoc($result) ){
			 echo "<tr align='center'>";
			 echo "<td><input type='checkbox' name='qid[]' value='".$row['qid']."'></td>";
			 echo "<td><a href='QuestionContents.php?Q=".$row['qid']."'/>".$row['qid']."</td>";
			 echo "<td>".$row['difficulty']."</td>";
			 echo "<td>".$row['title']."</td>";
			 echo "<td>".$row['category']."</td>";
			 echo "<td>".$row['owner']."</td>";
			 echo "</tr>";
		}
	}
?>
	</table>
	<span id='table_page'></span><br>
	<input type="submit" name="submit" value="修改" style="font-size:18px" onclick="form.action='update_question.php'">
	<input type="submit" name="submit" value="刪除" style="font-size:18px" onclick="form.action='Delete_question.php'">	
</form>
<script>
	$("#table1").tablepage($("#table_page"), 20);
</script>
</body>
</html>