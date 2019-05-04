<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";
	require_once SITE_ROOT."/classes/User.php";
	session_start();

	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
$html = '<!DOCTYPE html>
	<html lang="fr">
	
		<head>
			<meta charset="utf-8">
			<title>Blaireaux vs Kékés</title>
			<link rel="stylesheet" href="../styles/leaderboard.css" >
			<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet"> 
		</head>
	
	<body>

		<header id="header">
			<h1 id="titre">BLAIREAUX vs KÉKÉS</h1>
			<span>Theme : </span>
			<select id="themes" onchange="switchTheme(this.selectedIndex)">
				<option selected="selected">Défaut</option>
				<option>Royal</option>
				<option>Hiver</option>
			</select>
		</header>

		<img src="../img/badger.png" align="center"/>';
		
	$lignes=$db->select("count(*) as nb","user","");
	//Plutôt que de faire un foreach, on récupère le nombre de lignes de la table.
	$donnes=$lignes->fetch();
	$nb=$donnes['nb'];
	$i=1;
	$html.="<table id='table'>";
	for($i=1;$i<=$nb;$i++)
	{
		$cond="classement=".$i."";
		$joueur=$db->select("login as player","user",$cond);
			$play=$joueur->fetch();
			$nomj=$play['player'];
			if ($nomj==$user->getLogin()){
				$html.='<tr><td>'.$i.'</td><td><a href="profil.php?profil='.$nomj.'">'.$nomj.'</a></td><td>Votre place</td></tr>';
			}
			else{
			$html.='<tr><td>'.$i.'</td><td><a href="profil.php?profil=' .$nomj .'">'.$nomj.'</a></td></tr>';
			}
		
	}
	
		
	   $html.='</table><form method="post" enctype="" action="../fonctions/RetourAccueil.php">
			<input type="submit" id="retour" value="Retour accueil"/>
			</form>
						 
			<form method="post" enctype="" action="../fonctions/deconnexion.php">
			<input type="submit" id="deconnexion" value="Déconnexion"/>
			</form>	';				

	
	 $html.='</body>';

	

	$html.="<script src='../js/popup.js'></script>";
	$html.="<script src='../js/themes.js'></script></html>";


	
		echo $html;
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>