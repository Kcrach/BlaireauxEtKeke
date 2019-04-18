<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/Map.php";
	session_start();

	if(isset($_SESSION['user'])){
			$map = new Map();
			$map->ajouterBD();
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>