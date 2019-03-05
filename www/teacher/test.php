<?php
	echo $_POST['course']."<br>";
	$student_account = $_POST['student_account'];
	$count = count($student_account);
	echo $count."<br>";
	for ( $i=0;$i<$count;$i++ ){
		echo $student_account[$i]."<br>";
	}
?>