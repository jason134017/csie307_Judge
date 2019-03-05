<html>
<head>
<meta charset="utf-8">
<title>作答區</title>
</head>
<body>
<form action="execode_BANK.php" name="form" id="form" method="post" id="code">
<?php
	$Q=$_GET["qid"];
	$login=$_COOKIE["account"];
	if($login==""){
		echo "<script>alert('請先登入!!!');top.location.href ='../login/Homepage.html';</script>";
	}else{
		echo "<font size='6' color='red'>題號:</font><font size='6' color='orange'>".$Q."</font><br>";	
	}
    echo "<input name='qid'  type='hidden' value='".$Q."'>";
    echo '<font color="red" size="5">請在此輸入程式碼:<br></font>';
    echo '<textarea cols="50" rows="30"  name="code"></textarea> <br>';
?>
選擇編譯器:
<select name="compiler" form="form" id="sel" style="font-size :20px">  
	<option value='0'>--------</option>
	<option value='1'>c++</option>
	<option value='2'>java</option>
	<option value='3'>python</option>
</select><br></br>
<input name="submit" type="submit" value="送出" style="font-size :18px" >
<input name="back" type="button" value="返回題目" style="font-size:18px" onclick="history.go(-1)">
<?php
	echo "<input name='back' type='button' value='返回選項' style='font-size:18px' onclick=\"window.location.href='question_bank.php'\">";
?>
</form>
</body>
</html>