<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/Partie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idMap'])){
			$date = new DateTime();
			$idMap = htmlspecialchars($_GET['idMap']);

			$partie = new Partie($idMap);
			$partie->ajouterBD();

			echo $partie->getID();
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>