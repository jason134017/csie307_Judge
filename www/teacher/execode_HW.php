<?php
    $login=$_COOKIE["account"];
	$id=1;
	$grade=0;
	$response="";
	$WE=false;
	$AC=false;
    $Q=$_POST['qid'];
	$N=$_POST['homework_id'];
    if($Q=="0" ){
        echo "<script>history.go(-1);</script>";
    }else{
		if( !empty($_POST['code']) ){
			//connect database
			$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
			mysqli_select_db($link, "Judge");
			mysqli_query($link, 'SET CHARACTER SET utf8'); 
			mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");
		
			$sql = "SELECT * FROM `question` WHERE `qid` LIKE '".$Q."'; ";//查詢整個表單
			$result = mysqli_query($link,$sql) ;
			$row = mysqli_fetch_assoc($result);
		
			$Qid=$row['qid'];
			for($i=1;$i<=5;$i++){
				$input=str_replace("&apos;","'",$row["input$i"]); 
				$file=fopen("$Qid"."_$i"."_input.txt",'w');
				fwrite($file,$input);
				fclose($file);
			
				$answer=$row["answer$i"];
			
				$answer=str_replace(array("\r"), '', $answer);
				
				$file=fopen("$Qid"."_$i"."_answer.txt",'w');
				fwrite($file,$answer);			
				fclose($file);			
			}       
			/*file process*/
			$idnumber=fopen("id.txt","r");
			flock("id.txt", LOCK_EX);
			$id=fgets($idnumber);
			flock("id.txt", LOCK_UN);
			fclose($idnumber);
		

			$file=fopen("$id.cpp",'w');
			fwrite($file,$_POST['code']);		
			fclose($file);
		
			$changeid=fopen("id.txt",'w');
			flock("id.txt", LOCK_EX);
			fwrite($changeid,(int)$id+1);
			flock("id.txt", LOCK_UN);	
			fclose($changeid);
	
			echo 'Execute Result:<br><br>';
	 
			$exe='g++ /var/www/teacher/'.$id.'.cpp -o /var/www/teacher/'.$id.'.out -Wall ';
			
			//測試
			$tmp=shell_exec($exe);			    
			//echo $tmp."<br>"
			///
			
			/*結果比對*/
			$output=$id.".out";
			if (!fopen($output,"r")){
				/*編譯器錯誤*/
				$WE=true;
				echo '<font size=\'4\' color=\'#7700BB\'>CE:編譯錯誤</font>';
				$errMsg=0;
				$move = 'rm -r /var/www/teacher/'.$id.'.cpp ';
				shell_exec($move);
			}else{
				for($i=1;$i<=5;$i++){
					$filename="$Qid"."_$i"."_input.txt";
					$time=date("U");
					$exe2='timeout 2 ./'.$id.'.out < '.$filename.' > '.$id.'_'.$i.'output.txt';
					shell_exec($exe2);
					$time2=date("U");
				/*Time-Out*/
					if(($time2-$time)>=2){
						$WE=true;
						echo $i.' - <font size=\'4\' color=\'#0000FF\'>Time-Out!</font>' ;
						$errMsg=1;
						//shell_exec('mv /var/www/code/'.$output.' /var/www/code/'.$id.'.cpp /var/www/code/source/');
					}else{
						$answer ="$Qid"."_$i"."_answer.txt";
						$compare='diff '.$answer.' '.$id.'_'.$i.'output.txt > '.$id.'_'.$i.'compareresult.txt';		
						shell_exec($compare);	
				
						$file=$id.'_'.$i.'compareresult.txt';
						$result=fopen($file,"r");		
						$str=fread($result,filesize($file));		
						fclose($result);
	        
						if(strlen($str)==0){
						
							echo $i.' - '.'<font size=\'4\' color=\'#00FF00\'>AC:正確答案</font><br>' ;
							$grade+=20;
						}else{
							$WE=true;
							$errMsg=2;
							echo $i.' - '.'<font size=\'4\' color=\'#0000FF\'>WA:錯誤答案</font><br>' ;
						}
					}
				}
		    }
		}else{
			$WE=true;
			echo'No code input!<br>';
			$idnumber=fopen("id.txt","r");	
			flock("id.txt", LOCK_EX);		
			$id=fgets($idnumber);	
			flock("id.txt", LOCK_UN);		
			fclose($idnumber);
		
			$changeid=fopen("id.txt",'w');
			flock("id.txt", LOCK_EX);
			fwrite($changeid,(int)$id+1);
			flock("id.txt", LOCK_UN);
			fclose($changeid);
			$errMsg=3;
			$grade=0;
		}
		echo '<br><br>Your compile ID: ' .$id .'<br>';
		echo '<br><font size=\'6\'>Your grade is : </font>';
		echo '<font size=\'6\' color=\'#FF0000\'>'.$grade.'</font> <br>';
	
		/*統整錯誤訊息*/
		if($WE){
			switch($errMsg){
				case 0:
					$response="CE";
					break;
				case 1:
					$response="Time-Out";
					break;
				case 2:
					$response="WA";
					break;
				case 3:
					$response="Empty";
					break;
			}	
		}else{
			$response="AC";
		}
		/*移動檔案進入souce*/
				
		/*從伺服器刪除檔案*/
        $move = 'rm -r /var/www/teacher/'.$id.'.cpp ';
		shell_exec($move);	
        $move2 ='rm -r /var/www/teacher/'.$id.'.out';
        shell_exec($move2);	
		for( $i=1;$i<=5;++$i){
			$answerf ="$Qid"."_$i"."_answer.txt";
			$inputf="$Qid"."_$i"."_input.txt";
			$outputf="$id"."_$i"."output.txt";
			$comparef="$id"."_$i"."compareresult.txt";
					
			$remove='rm -r /var/www/teacher/'.$answerf;
			$remove2='rm -r /var/www/teacher/'.$inputf;
			$remove3='rm -r /var/www/teacher/'.$outputf;
			$remove4='rm -r /var/www/teacher/'.$comparef;
					
			shell_exec($remove);
			shell_exec($remove2);
			shell_exec($remove3);
			shell_exec($remove4);
		}
		/*將成績回傳資料庫*/	
		$link=mysqli_connect("localhost","root","csie307") or die ("無法開啟Mysql資料庫連結");
        mysqli_query($link, 'SET NAMES utf8'); 
		mysqli_query($link,  "SET collation_connection = ‘utf8_general_ci");
		mysqli_select_db($link, "Judge");
		
		$code =str_replace("'","&apos;",$_POST['code']);
		$insert = "INSERT INTO `teacher_grade`(`compileID`, `account`, `ID`, `qid`, `response`,`grade`,`code`) VALUES ('".$id."','".$login."','".$N."','".$Q."','".$response."','".$grade."','".$code."')";
		mysqli_query($link,$insert)or die ("無法新增".mysqli_error());
	}

	echo '<p><input name="submit" type="submit" value = "返回" style="font-size:20px;"font-size="25" onclick="goback()"/></p> <script>function goback() {history.go(-1);}</script>';  
?>