<?php
	session_start();
	if(isset($_SESSION['user'])){
		header("Location: //localhost/BlaireauxEtKeke/index.php");
	}
?>