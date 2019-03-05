<?php
	setcookie("account","",time()-3600,"/competition/");
	setcookie("identity","",time()-3600,"/competition/");	
    header("location: Homepage.html");
?>