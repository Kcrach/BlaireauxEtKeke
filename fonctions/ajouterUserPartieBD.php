<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/UserPartie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie']) && isset($_GET['typeUser'])){
			if(isset($_GET['posX']) && isset($_GET['posY']) && isset($_GET['direction']) ){
				$idPartie = htmlspecialchars($_GET['idPartie']);
				$typeUser = htmlspecialchars($_GET['typeUser']);
				$direction = htmlspecialchars(isset($_GET['direction']));
				$posX = htmlspecialchars($_GET['posX']);
				$posY = htmlspecialchars($_GET['posY']);
				$idUser = $_SESSION['user']->getID();

				$up = new UserPartie($idUser, $idPartie, $typeUser, $posX, $posY, $direction);
				if($up->exist()==false){
					$up->ajouterBDPlayer();
				}
			}
			else{
				$idPartie = htmlspecialchars($_GET['idPartie']);
				$typeUser = htmlspecialchars($_GET['typeUser']);
				$idUser = $_SESSION['user']->getID();

				$up = new UserPartie($idUser, $idPartie, $typeUser,"NULL","NULL","NULL");
				if($up->exist()==false){
					$up->ajouterBD();
				}
			}
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>