<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/Partie.php";

	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_GET['idPartie'])){
			global $db;
			$idPartie = htmlspecialchars($_GET['idPartie']);

			$requeteIdMap = "SELECT idMap FROM Partie WHERE id=".$idPartie;
			$res = $db->query($requeteIdMap);

			foreach($res as $idMapTmp){
				$idMap = $idMapTmp['idMap'];
			}

			$idMap = intval($idMap);

			$requete = "SELECT posX,posY FROM Mur WHERE idMap=".$idMap;		
			$res = $db->query($requete);

			$coordMur = "";

			foreach($res as $mur){
				$coordMur.=$mur['posX'].','.$mur['posY'].' ';			
			}

			echo $coordMur;
			
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>