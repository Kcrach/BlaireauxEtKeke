<?php
	require_once SITE_ROOT."/classes/UserPartie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie']) && isset($_GET['typeUser'])){
			$idPartie = htmlspecialchars($_GET['idPartie']);
			$typeUser = htmlspecialchars($_GET['typeUser']);
			$idUser = $_SESSION['user']->getID();

			$up = new UserPartie($idUser, $idPartie, $typeUser);
			$up->ajouterBD();

			echo $typeUser;
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>