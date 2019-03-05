<?php
	$permission = $_POST['permission'];
	$Tqid = str_replace("'","&apos;",$_POST['qid']);
	$difficulty = $_POST['difficulty'];
	$category = str_replace("'","&apos;",$_POST['category']);
	$title = str_replace("'","&apos;",$_POST['title']);
	$question = str_replace("'","&apos;",$_POST['question']);
	$input1 = str_replace("'","&apos;",$_POST['input1']);
	$input2 = str_replace("'","&apos;",$_POST['input2']);
	$input3 = str_replace("'","&apos;",$_POST['input3']);
	$input4 = str_replace("'","&apos;",$_POST['input4']);
	$input5 = str_replace("'","&apos;",$_POST['input5']);
	$answer1 = str_replace("'","&apos;",$_POST['answer1']);
	$answer2 = str_replace("'","&apos;",$_POST['answer2']);
	$answer3 = str_replace("'","&apos;",$_POST['answer3']);
	$answer4 = str_replace("'","&apos;",$_POST['answer4']);
	$answer5 = str_replace("'","&apos;",$_POST['answer5']);
	/*處理未輸入區塊*/
	echo "<input name='qid'  type='hidden' value='".$Tqid."' >";
	$err=false;
	if($Tqid==""){
		echo "<script>alert('警告：請輸入題號');window.location.href='update_question.php';</script>";    
	}else if($difficulty==""){
		echo "<script>alert('警告：請設定難度');window.location.href='update_question.php';</script>";	
    }else if($difficulty>5||$difficulty<1){	
		echo "<script>alert('警告：難度需介於1~5區間');window.location.href='update_question.php';</script>";	
	}else if($title==""){
		echo "<script>alert('警告：請輸入標題');window.location.href='update_question.php';</script>";	      
	}else if($question==""){
		echo "<script>alert('警告：請輸入問題');window.location.href='update_question.php';</script>";	      
	}else if($input1==""){
		echo "<script>alert('警告：請輸入input1');window.location.href='update_question.php';</script>";	  		
	}else if($input2==""){
		echo "<script>alert('警告：請輸入input2');window.location.href='update_question.php';</script>";
	}else if($input3==""){
		echo "<script>alert('警告：請輸入input3');window.location.href='update_question.php';</script>";
	}else if($input4==""){
		echo "<script>alert('警告：請輸入input4');window.location.href='update_question.php';</script>";
	}else if($input5==""){
		echo "<script>alert('警告：請輸入input5');window.location.href='NewQuestion.html';</script>";
	}else if($answer1==""||$answer2==""||$answer3==""||$answer4==""||$answer5==""){
		echo "<script>alert('警告：請輸入answer');window.location.href='update_question.php';</script>";
	}else{
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
		mysqli_query($link,"SET NAMES UTF8");
		mysqli_query($link,  "SET collation_connection = ‘utf8_general_ci");
		mysqli_select_db($link, "Judge");
	
		$sql = "UPDATE `question` SET `difficulty` = '".$difficulty."', `category` = '".$category."', `title` = '".$title."',
				`question_contents` = '".$question."', `input1` = '".$input1."', `input2` = '".$input2."', `input3` = '".$input3."',
				`input4` = '".$input4."', `input5` = '".$input5."', `answer1` = '".$answer1."', `answer2` = '".$answer2."', `answer3` = '".$answer3."',
				`answer4` = '".$answer4."', `answer5` = '".$answer5."' WHERE `question`.`qid` = '".$Tqid."'; ";
		mysqli_query($link,$sql)or die ("無法新增".mysqli_error());
		echo "<script>alert('修改成功!');window.location.href='".$permission."_question_bank.php';</script>";
	}
?>