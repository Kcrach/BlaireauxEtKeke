<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/Partie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idMap']) && isset($_GET['dim'])){
			$date = new DateTime();
			$idMap = htmlspecialchars($_GET['idMap']);
			$dim = htmlspecialchars($_GET['dim']);

			$partie = new Partie($idMap, $dim);
			$partie->ajouterBD();

			echo intval($partie->getID());
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>