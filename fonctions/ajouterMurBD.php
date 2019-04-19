<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/Mur.php";
	session_start();

	if(isset($_SESSION['user'])){
		echo $_GET['x'];

		if(isset($_GET['idMap']) && isset($_GET['y']) && isset($_GET['x'])){
			$idMap = htmlspecialchars($_GET['idMap']);
			$x=htmlspecialchars($_GET['x']);
			$y=htmlspecialchars($_GET['y']);

			$mur = new Mur($idMap,$x,$y);	
			$mur->ajouterBD();
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>