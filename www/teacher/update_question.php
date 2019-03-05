<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>UpdateQuestion</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="js/jquery-tablepage-1.0.js"></script>
<body>
<form action="" method="post" id="insert" enctype="multipart/form-data" name="form">
<?php
	$tqid=$_POST['qid'];
	if($tqid==""){
		echo "<script>alert('警告：請勾選題號');history.go(-1);</script>";	      
	}
	$link =  mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");  // 建立MySQL的資料庫連結 
	mysqli_select_db($link,"Judge")or die ("無法選擇資料庫".mysql_error()); // 選擇資料庫
	mysqli_query($link, 'SET CHARACTER SET utf8');
	mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");

	$sql = "SELECT * FROM `question` WHERE `qid`='".$tqid[0]."'";
	$result=mysqli_query($link,$sql);
	$row= mysqli_fetch_assoc($result);
	
	if ( $row['permission']=="public" ){
		$permission="public";
	}else{
		$permission="private";
	}
	if( $row['owner']!=$_COOKIE['account'] ){
		echo "<script>alert('沒有權限修改!');window.location.href='".$permission."_question_bank.php';</script>";
		exit;
	}
	echo "<input type='hidden' name='permission' value='".$permission."'>";
?>
<font size="5"color="red">請修改題目:</font><br>
<font size="3"color="#7A0099">Hint:可照html格式輸入</font><br><br>
<!--題號難度標題-->
<table border="2" name="table1" width="700px">
	<tbody><tr align="center" width="100%">		
		<td>題號</td>
		<td>難度(1~5)</td>
        <td>分類</td>
		<td>標題</td>		
	</tr>
	<?php
		echo"<tr>
		<td width='30%'><textarea cols=\"7\" rows=\"8\"  name=\"qid\" style='resize:none; width: 100%;'>".$row['qid']."</textarea></td>
		<td width='15%'><textarea cols=\"8\" rows=\"8\"  name=\"difficulty\" style='resize:none; width: 100%;'>".$row['difficulty']."</textarea></td>
		<td width='15%'><textarea cols=\"8\" rows=\"8\"  name=\"category\" style='resize:none; width: 100%;'>".$row['category']."</textarea></td>
		<td width='50%'><textarea cols=\"22\" rows=\"8\" name=\"title\" style='resize:none; width: 100%;'>".$row['title']."</textarea></td>
		</tr>";
	?>
</tbody></table><br>
<!--問題內容-->
<table border="2" name="table2" width="700px">
	<tr align="center" width="100%">
		<td>問題內容</td>
	</tr>
	<?php
		echo"<tr width='100%'>
		<td width='100%'><textarea cols=\"32\" rows=\"8\"  name=\"question\" style='resize:none; width: 100%;'>".$row['question_contents']."</textarea></td>
		</tr>";
	?>
</table><br>
<!--測資-->
	<font size="5"color="red">請輸入測資/解答:</font><br>
	<font size="3"color="#7A0099">Hint:請照輸入格式輸入，換行按Enter</font><br><br>
	
	<table border="2" name="input1" width="700px">
	<tr align="center" width="100%">		
		<td>input1</td>
		<td>answer1</td>
	</tr>
	<?php
		echo"<tr width='100%'>
		<td width='40%'><textarea cols='10' rows='6' name='input1' style='resize:none;width: 100%;'>".$row['input1']."</textarea></td>
		<td width='60%'><textarea cols='10' rows='6' name='answer1' style='resize:none;width: 100%;'>".$row['answer1']."</textarea></td>
		</tr>";
	?>
	<tr align="center" width="100%">		
		<td>input2</td>
		<td>answer2</td>
	</tr>
	<?php
		echo"<tr width='100%'>
		<td width='40%'><textarea cols='10' rows='6' name='input2' style='resize:none;width: 100%;'>".$row['input2']."</textarea></td>
		<td width='60%'><textarea cols='10' rows='6' name='answer2' style='resize:none;width: 100%;'>".$row['answer2']."</textarea></td>
		</tr>";
	?>
	<tr align="center" width="100%">		
		<td>input3</td>
		<td>answer3</td>
	</tr>
	<?php
		echo"<tr width='100%'>
		<td width='40%'><textarea cols='10' rows='6' name='input3' style='resize:none;width: 100%;'>".$row['input3']."</textarea></td>
		<td width='60%'><textarea cols='10' rows='6' name='answer3' style='resize:none;width: 100%;'>".$row['answer3']."</textarea></td>
		</tr>";
	?>
	<tr align="center" width="100%">		
		<td>input4</td>
		<td>answer4</td>
	</tr>
	<?php
		echo"<tr width='100%'>
		<td width='40%'><textarea cols='10' rows='6' name='input4' style='resize:none;width: 100%;'>".$row['input4']."</textarea></td>
		<td width='60%'><textarea cols='10' rows='6' name='answer4' style='resize:none;width: 100%;'>".$row['answer4']."</textarea></td>
		</tr>";
	?>
	<tr align="center" width="100%">		
		<td>input5</td>
		<td>answer5</td>
	</tr>
	<?php
		echo"<tr width='100%'>
		<td width='40%'><textarea cols='10' rows='6' name='input5' style='resize:none;width: 100%;'>".$row['input5']."</textarea></td>
		<td width='60%'><textarea cols='10' rows='6' name='answer5' style='resize:none;width: 100%;'>".$row['answer5']."</textarea></td>
		</tr>";
	?>
</table><br>
<input type="submit" name="submit" value="送出"  onclick="form.action='update_question1.php';" style='position: relative; left:600px; font-size :20px'/>
</form>
</html>	