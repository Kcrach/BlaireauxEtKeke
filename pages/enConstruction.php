<?php
	session_start();

	if(isset($_SESSION['user'])){
		$html = 
		'<!DOCTYPE html>
		<html lang="fr">

			<head>
				<meta charset="utf-8">
				<title>Recherche d\'une partie</title>
				<link rel="stylesheet" href="../styles/recherchePartie.css" name="theme" id="theme">
				<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
			</head>

		<body>

			<header id="header">
				<h1 id="titre">BLAIREAUX vs KÉKÉS</h1>
				
				<span>Theme : </span>
				<select id="themes" onchange="switchTheme(this.selectedIndex)">
					<option selected="selected">Défaut</option>
					<option>Corail</option>
					<option>Hiver</option>
				</select>
			  
			</header>

			<img src="../img/enConstruction.jpg"/>
			
			<form method="post" enctype="" action="../fonctions/RetourAccueil.php">
				<input type="submit" id="retour" value="Retour accueil"/>
 			</form>
			
		</body>';
		$html.="<script src='../js/themes.js'></script></html>";
		echo $html;
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
?>