<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";

$html = '<!DOCTYPE html>
	<html lang="fr">
	
		<head>
			<meta charset="utf-8">
			<title>Connexion</title>
			<link rel="stylesheet" href="../styles/login.css" >
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
		$html.='<tr><td>'.$i.'</td><td>'.$nomj.'</td></tr>';
		
	}
	
		
	  $html.='</body>';

	

	$html.="<script src='../js/popup.js'></script></html>";
	$html.="<script src='../js/themes.js'></script></html>";


	
		echo $html;
	
?>