<?php
	session_start();
	if(isset($_SESSION['user'])){
		session_destroy();
		header("Location: //localhost/projetweb-master/pages/login.php");
	}
?>