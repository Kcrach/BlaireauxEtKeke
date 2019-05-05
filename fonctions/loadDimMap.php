<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/Partie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie'])){
			global $db;
			$idPartie = htmlspecialchars($_GET['idPartie']);

			$requete = "SELECT dimension FROM Partie WHERE id=".$idPartie;
			$res = $db->query($requete);

			foreach($res as $dimensionTmp){
				$dimension = $dimensionTmp['dimension'];
			}

			echo intval($dimension);			
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>