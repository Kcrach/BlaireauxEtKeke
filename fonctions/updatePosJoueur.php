<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/UserPartie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie']) && isset($_GET['posX']) && isset($_GET['posY'])){
			$idPartie = htmlspecialchars($_GET['idPartie']);
			$posX = htmlspecialchars($_GET['posX']);
			$posY = htmlspecialchars($_GET['posY']);
			$idUser = $_SESSION['user']->getID();

			global $db;

			$requete = "UPDATE `User-Partie` SET posX=".$posX.", posY=".$posY." WHERE idUser =".$idUser." AND idPartie=".$idPartie;
			$err = $db->query($requete);

			//echo $err;
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>