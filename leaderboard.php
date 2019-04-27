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

		<header>
			<h1 id="titre">BLAIREAUX vs KÉKÉS</h1>
			<span>Theme : </span>
			<select id="themes" onchange="switchTheme(this.selectedIndex)">
				<option selected="selected">Défaut</option>
				<option>Royal</option>
				<option>Hiver</option>
			</select>
		</header>

		<img src="../img/badger.png" align="center"/>
	
		
	  </body>';

	

	$html.="<script src='../js/popup.js'></script></html>";


	$lignes=$db->select("count(*) as nb","user","");
	//Plutôt que de faire un foreach, on récupère le nombre de lignes de la table.
	$donnes=$lignes->fetch();
	$nb=$donnes['nb'];
	$i=1;
	$html.="<table>";
	for($i=1;$i<=$nb;$i++)
	{
		$cond="classement=".$i."";
		$joueur=$db->select("login as player","user",$cond);
			$play=$joueur->fetch();
			$nomj=$play['player'];
		$html.='<tr><td>'.$i.'</td><td>'.$nomj.'</td></tr>';
		
	}
	
		echo $html;
	
?>