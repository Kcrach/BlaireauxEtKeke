<?php
	require_once __DIR__."/../config.php";
	/*require_once SITE_ROOT."/classes/UserPartie.php";
	require_once SITE_ROOT."/classes/Partie.php";
	require_once SITE_ROOT."/classes/Map.php";
	require_once SITE_ROOT."/classes/User.php";*/

	session_start();

	if(isset($_SESSION['user'])){
		$html = '<!DOCTYPE html>
					<html lang="fr">

						<head>
							<meta charset="utf-8">
							<title>Blaireaux vs Kékés</title>
							<link rel="stylesheet" href="../styles/creerPartie.css" name="theme" id="theme">
							<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
							<!--<script src="../js/login.js"></script>-->
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

						<img src="../img/badger.png" align="center"/>

						<form method="post" enctype="" action="../fonctions/initPartie.php" align=center>
							<label for="dimensionGrille">Dimension de la grille</label></br>
							<input type="number" min="0" id="dimensionGrille" name="dimensionGrille"/></br>

							</br>

							<label for="nbFlaque">Nombre de flaque :</label></br>
							<input type="number" min="0" id="nbFlaque" name="nbFlaque"/></br>

							</br>

							<label for="nbMur">Nombre de mur :</label></br>
							<input type="number" min="0" id="nbMur" name="nbMur"/></br>

							</br>

							<input type="submit" id="créerPartie" value="Créer la partie"/>

						</form>

						<form method="post" enctype="" action="../fonctions/RetourAccueil.php">
							<input type="submit" id="retour" value="Retour accueil"/>
						</form>
						 
						<form method="post" enctype="" action="../fonctions/deconnexion.php">
							<input type="submit" id="deconnexion" value="Déconnexion"/>
						</form>

 					  </body>';
		$html.="<script src='../js/themes.js'></script></html>";
		echo $html;

		/*$m = new Map();
		$m->ajouterBD();

		$p = new Partie(1);
		$p -> ajouterBD();

		$idUser = $_SESSION['user']->getID();

		$up = new UserPartie($idUser, 1, "host");
		$up->ajouterBD();*/
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
?>