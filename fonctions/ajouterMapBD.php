<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/Map.php";
	session_start();

	if(isset($_SESSION['user'])){
			$map = new Map();
			$map->ajouterBD();

			echo intval($map->getID()); //On renvoie la réponse sur le flux
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>