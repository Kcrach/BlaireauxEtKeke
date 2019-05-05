<?php
	session_start();

	if(isset($_SESSION['user'])){
		if(isset($_POST['dimensionGrille']) && isset($_POST['nbFlaque']) && isset($_POST['nbMur'])){
			$dimensionGrille = htmlspecialchars($_POST['dimensionGrille']);
			$nbFlaques = htmlspecialchars($_POST['nbFlaque']);
			$nbMurs = htmlspecialchars($_POST['nbMur']);
		}

		$html =  '<!DOCTYPE html>
					<html lang="fr">

						<head>
							<meta charset="utf-8">
							<title>Blaireaux vs Kékés : le jeu</title>
							<link rel="stylesheet" href="../styles/Jeu.css" name="theme" id="theme">
							<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
							<script src="../js/jeu.js"></script>
							<script src="../lib/three.js"></script>
						</head>

						<body onload="createPartie('.$nbFlaques.','.$nbMurs.','.$dimensionGrille.');">

						<div>
							<h2>COMMANDES</h2>
							Avancer : [↑]<br/>
							Rotation :  [←]  [→] <br/>
							Super-vue : [🠣]<br/>
						</div>
						<br/>
						<div id="chrono">
							<strong>Temps restant avant le Gong</strong> :
							<span id="chronoSecondes" ></span><br/>
							<span id="spanEquipe"></span><br/>
						</div>
						<div id="bonus">
							<strong>Bonus dans l inventaire </strong> :
							<span id="nbBonus" ></span><br/>
						</div>

						<form method="post" enctype="" action="RetourAccueil.php">
							<input type="submit" id="retour" value="Quitter la partie"/>
						</form>
 						</body>
						
					</html>';

		echo $html;

	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
?>