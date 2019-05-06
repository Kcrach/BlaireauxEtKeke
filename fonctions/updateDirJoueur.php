<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/UserPartie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie']) && isset($_GET['direction'])){
			$idPartie = htmlspecialchars($_GET['idPartie']);
			$direction = htmlspecialchars($_GET['direction']);
			$idUser = $_SESSION['user']->getID();

			global $db;

			$requete = "UPDATE `User-Partie` SET direction=".$direction." WHERE idUser =".$idUser." AND idPartie=".$idPartie;
			$db->query($requete);
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>