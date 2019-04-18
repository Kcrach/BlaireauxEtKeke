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
				<script src="../js/recherchePartie.js"></script>
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

			<img src="../img/badger.png"/>
			
			<table>
				<th>
					<fieldset>
						<legend><h1 id="h1-01">Recherche d\'une partie en cours</h1></legend>
						<form>
							<div id="loader"></div> <br>
							<div><p id="message">En attente de joueurs...</p></div>
							<progress value="0" max="10" id="progressBar" hidden></progress>
						</form>
					</fieldset>
				</th>
				
			</table>
			<input type="button" id="BTtrouvée" onclick="trouve();" value="Trouvée">
			<input type="button" id="BTechec" onclick="echec();" value="Echec">

			<form method="post" enctype="" action="../fonctions/RetourAccueil.php">
				<input type="submit" id="retour" value="Retour accueil"/>
 			</form>
		</body>
			
		</html>';
		echo $html;
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
?>