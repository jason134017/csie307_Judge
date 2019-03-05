<?php
	setcookie("account","",time()-3600,"/ta/");
	setcookie("identity","",time()-3600,"/ta/");
	header("location: ../login/Homepage.html");
?>