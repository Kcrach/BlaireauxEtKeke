<?php
	session_start();

	if(isset($_SESSION['user'])){
		
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>