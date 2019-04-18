<?php
	session_start();

	if(isset($_SESSION['user'])){
		$html = '<!DOCTYPE html>
					<html lang="fr">

						<head>
							<meta charset="utf-8">
							<title>Connexion</title>
							<link rel="stylesheet" href="../styles/accueil.css" name="theme" id="theme">
							<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
							<!--<script src="../js/login.js"></script>-->
						</head>

					<body>

						<header>
							<h1 id="titre">BLAIREAUX vs KÉKÉS</h1>
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

						<form method="post" enctype="" action="../fonctions/deconnexion.php">
							<input type="submit" id="deconnexion" value="Déconnexion"/>
						</form>
						 
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