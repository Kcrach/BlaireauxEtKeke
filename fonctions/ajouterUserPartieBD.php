<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/UserPartie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie']) && isset($_GET['typeUser'])){
			if(isset($_GET['posX']) && isset($_GET['posY'])){
				$idPartie = htmlspecialchars($_GET['idPartie']);
				$typeUser = htmlspecialchars($_GET['typeUser']);
				$posX = htmlspecialchars($_GET['posX']);
				$posY = htmlspecialchars($_GET['posY']);
				$idUser = $_SESSION['user']->getID();

				$up = new UserPartie($idUser, $idPartie, $typeUser, $posX, $posY);
				$up->ajouterBDPlayer();
			}
			else{
				$idPartie = htmlspecialchars($_GET['idPartie']);
				$typeUser = htmlspecialchars($_GET['typeUser']);
				$idUser = $_SESSION['user']->getID();

				$up = new UserPartie($idUser, $idPartie, $typeUser);
				$up->ajouterBD();
			}
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>