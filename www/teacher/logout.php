<?php
	setcookie("account","",time()-3600,"/teacher/");
	setcookie("identity","",time()-3600,"/teacher/");
	header("location: ../login/Homepage.html");
?>