<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/UserPartie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie'])){
			global $db;
			$idPartie = htmlspecialchars($_GET['idPartie']);

			$requete = "SELECT posX,posY FROM `user-partie` WHERE idPartie=".$idPartie." AND idUser!=".$_SESSION['user']->getID();		
			$res = $db->query($requete);

			$coordPlayers = "";

			foreach($res as $player){
				$coordPlayers.=$player['posX'].','.$player['posY'].' ';			
			}

			echo $coordPlayers;
			
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>