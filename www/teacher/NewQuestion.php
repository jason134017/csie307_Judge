<?php
	$qid = str_replace("'","&apos;",$_POST['qid']);
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

	if ( strpos($_POST['submit'],"公開") ){
		$permission = "public";
	}else{
		$permission = "private";
	}
	
	/*處理未輸入區塊*/
	$err=false;
	if($qid==""){
		echo "<script>alert('警告：請輸入題號');window.location.href='NewQuestion.html';</script>";    
	}else if($difficulty==""){
		echo "<script>alert('警告：請設定難度');window.location.href='NewQuestion.html';</script>";	
    }else if($difficulty>5||$difficulty<1){	
		echo "<script>alert('警告：難度需介於1~5區間');window.location.href='NewQuestion.html';</script>";	
	}else if($title==""){
		echo "<script>alert('警告：請輸入標題');window.location.href='NewQuestion.html';</script>";	      
	}else if($question==""){
		echo "<script>alert('警告：請輸入問題');window.location.href='NewQuestion.html';</script>";	      
	}else if($input1==""){
		echo "<script>alert('警告：請輸入input1');window.location.href='NewQuestion.html';</script>";	  		
	}else if($input2==""){
		echo "<script>alert('警告：請輸入input2');window.location.href='NewQuestion.html';</script>";
	}else if($input3==""){
		echo "<script>alert('警告：請輸入input3');window.location.href='NewQuestion.html';</script>";
	}else if($input4==""){
		echo "<script>alert('警告：請輸入input4');window.location.href='NewQuestion.html';</script>";
	}else if($input5==""){
		echo "<script>alert('警告：請輸入input5');window.location.href='NewQuestion.html';</script>";
	}else if($answer1==""||$answer2==""||$answer3==""||$answer4==""||$answer5==""){
		$err=true;
	}
	if ($_FILES["pfile"]["name"]!=""){
		if (@move_uploaded_file($_FILES["pfile"]["tmp_name"],"/var/www/picture/".$_FILES["pfile"]["name"])) {
			echo "<b>File successfully upload</b>";
			//$question=$question+"<img src='/picture/".$_FILES["pfile"]["name"]."'>";
			//$question = str_replace("'","&apos;",$question);
		}else{
			echo "<b>Error: failed to upload file</b>";
		}
	}
	$allOK=false;
	for($i=1;$i<=5;$i++)
		{
			if(${'answer'.$i}=="")break;
			elseif($_FILES["file"]["name"]!="" && ${'answer'.$i}!=""){
				echo "<script>alert('警告：answer和檔案只需擇一輸入!');right.location.href=NewQusetion.html;</script>";
				break;
			}elseif($i==5&&($difficulty>0&&$difficulty<=5))$allOK=true;
		}		
	
	$ok=false;
	if($err){
		//
		if ($_FILES["file"]["name"]==""){
			echo "<script>alert('警告：answer或檔案需擇一輸入或檔案上傳有誤，請重新檢查檔案');right.location.href=NewQusetion.html;</script>";
		}
		else{
			
				if (@move_uploaded_file($_FILES["file"]["tmp_name"],"/var/www/code/upload/".$_FILES["file"]["name"])) {
					$ok=true;
				echo "<b>File successfully upload</b>";
				}else{
				echo "<b>Error: failed to upload file</b>";
				}
			
		}	    
	}
	if($ok){
	 /*fileProcess*/
	 $file=$_FILES["file"]["name"];
     $exe='g++ /var/www/code/upload/'.$file.' -o /var/www/code/upload/'.$qid.'.out -Wall ';		    
     shell_exec($exe);

	for($i=1;$i<=5;$i++)
		{
			$input=${'input'.$i};
			$file=fopen("$qid"."_$i"."_input.txt",'w');
			fwrite($file,$input);			
			fclose($file);
			$move = 'mv /var/www/teacher/'.$qid.'_'.$i.'_input.txt   /var/www/code/upload/';
			shell_exec($move);
			
			$exe2='/var/www/code/upload/'.$qid.'.out < /var/www/code/upload/'.$qid.'_'.$i.'_input.txt > /var/www/code/upload/'.$qid.'_'.$i.'_output.txt';
			shell_exec($exe2);
			
			$file=fopen("/var/www/code/upload/$qid"."_$i"."_output.txt",'r') or die ("no file");
			${'answer'.$i}= file_get_contents("/var/www/code/upload/$qid"."_$i"."_output.txt");
			fclose($file);
			
			$file=$_FILES["file"]["name"];
			$remove="rm -r /var/www/code/upload/$qid"."_$i"."_output.txt";
			$remove2="rm -r /var/www/code/upload/$qid"."_$i"."_input.txt";
			shell_exec($remove);
			shell_exec($remove2);
			
		}
		    $remove3="rm -r /var/www/code/upload/$qid.out";
			$remove4="rm -r /var/www/code/upload/$file";
			shell_exec($remove3);
			shell_exec($remove4);
			$allOK=true;
	}
	/*上傳資料庫*/	
	
	if($allOK){
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
		mysqli_select_db($link, "Judge");
		mysqli_query($link,"SET NAMES UTF8");
		mysqli_query($link,"SET collation_connection = 'utf8_general_ci'");
		$sql = "INSERT INTO `question`(`qid`, `difficulty`,`title`,`category`,`question_contents` ,`owner`,`permission`,
				`input1`, `input2`,`input3`,`input4`,`input5`,`answer1`,`answer2`,`answer3`,`answer4`,`answer5`) VALUES
				('".$qid."','".$difficulty."','".$title."','".$category."','".$question."','".$_COOKIE['account']."',
				'".$permission."','".$input1."','".$input2."','".$input3."','".$input4."','".$input5."',
				'".$answer1."','".$answer2."','".$answer3."','".$answer4."','".$answer5."')";
		if ( mysqli_query($link,$sql) ){
			echo "<script>alert('新增成功');window.location.href='NewQuestion.html';</script>";
		}else{
			echo "<script>alert('新增失敗');window.location.href='NewQuestion.html';</script>";
		}
	}
?>