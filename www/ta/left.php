<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>left</title>
  </head>
  <script>
	/*function changeName(){
		var text = prompt("變更暱稱：","");
		if(text != null){
			if(text != ""){
				window.location.assign("ud_updata.php?type=username&text=" + text);
			}else{
				alert("請輸入欲變更的暱稱");
			}
		}
	}*/
	function changMode(){
		var type = document.getElementById("mode");
		if(type.value == "1"){
			type.value = "2";
			type.innerHTML = "取消";
		}else{
			type.value = "1";
			type.innerHTML = "變更密碼";
		}
		change("passwd");
		change("btn");
	}
	function change(object){
		var obj=document.getElementById(object);
		if(obj.style.display=="none"){
			obj.style.display="block"
		}else{
			obj.style.display="none"
		}
	}
</script>
  <body>
    <li>This page is only for teacher</li><br>
	歡迎 
	<?php 
	echo $_COOKIE['account']." 登入</br>";
	echo "<form action='ud_updata.php?type=passwd' method='post'>";
	echo "<input id='passwd' name='passwd' type='password' style='display:none'>&emsp;";
	echo "<input type='submit' id='btn' name='btn' value='變更' style='display:none'/>&emsp;";
	echo "</form>";
	echo "<button id='mode' onclick='changMode()' value='1' style='display:block;position:relative;top:-20px'>變更密碼</button>";
	?>
	<form action="" name="form1" method="post" target="_top" align='center'>
    <br><br><input value="登出" type="submit"  align="center" onclick="form1.action='logout.php';form1.submit();"/><br>
    </form>
  </body>
</html>