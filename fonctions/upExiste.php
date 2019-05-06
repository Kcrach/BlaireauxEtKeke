<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/UserPartie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie'])){
			$idPartie = htmlspecialchars($_GET['idPartie']);
			$idUser = $_SESSION['user']->getID();

			global $db;

			$ups = $db->select("idUser, idPartie","`User-Partie`","typeUser='player'");

			$existe = false;

			foreach($ups as $up){
				if($up['idUser'] == $idUser){
					if($up['idPartie'] == $idPartie){
						$existe = true;
					}
				}
			}

			echo $existe;
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>