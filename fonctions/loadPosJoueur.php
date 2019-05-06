<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/UserPartie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie'])){
			$idPartie = htmlspecialchars($_GET['idPartie']);
			$idUser = $_SESSION['user']->getID();

			global $db;

			$requete = "SELECT posX,posY FROM `User-Partie` WHERE idUser =".$idUser." AND idPartie=".$idPartie;
			$res= $db->query($requete);

			$coordJoueur = "";

			foreach($res as $joueur){
				$coordJoueur.=$joueur['posX'].','.$joueur['posY'].' ';			
			}

			echo $coordJoueur;
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>