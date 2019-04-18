<?php
	require_once __DIR__."/config.php"; // Pour résoudre les problèmes d'include, mettre cette ligne au début de chaque fichier
										//avec le chemin de config.php par rapport au fichier actuel
	require_once SITE_ROOT."/classes/User.php"; //puis si besoin d'un autre fichier, l'inclure comme ça depuis la racine du site
	session_start();

	if(isset($_SESSION['user'])){
		$html1 = '<!DOCTYPE html>
					<html lang="fr">

						<head>
							<meta charset="utf-8">
							<title>Connexion</title>
							<link rel="stylesheet" href="styles/accueil.css" name="theme" id="theme">
							<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
							<!--<script src="js/login.js"></script>-->
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

						<img src="img/badger.png" align="center"/>

						<table>
							<tr>
								<th id="liens">
										<a href="#"><p> Liens utiles </p></a>
										<a href="#"><p> Rejoindre partie </p></a>
										<a href="pages/creerPartie.php"><p> Créer une partie </p></a>
										<a href="#"><p> Leaderboard </p></a>
										<a href="#"><p> F.A.Q </p></a>

								</th>

								<th>
										<p id="règles"> Règles du jeu </p>
										<p align=left>

											- Les joueurs sont répartis aléatoirement en deux équipes: les kékés en surnombre et les blaireaux moins nombreux.<br/>
											- Les vilans blaireaux ont pour objectif de manger les gentils kékés.<br/>
											- Mais régulièrement, lorsque le gong sonne, les rôles sont inversés les gentils kékés deviennent des vilains kékés ayant pour seul objectif de dévorer les blaireaux devenus alors gentils.<br/>
											- La partie est limitée dans le temps. A la fin les plus nombreux ont gagnés.<br/>
											<br/>
											- Les avatars des joueurs apparaissent répartis aléatoirement sur le terrain.<br/>
											- Le terrain est pourvu de flaques magiques. Si un joueur tombe dans une flaque il réapparaît sur une autre flaque du terrain.<br/>
											<br/>
											Les super pouvoirs:<br/>
												- Cape d\'invisibilité durant [?] secondes.<br/>
												- Les bottes de sept lieux permettant de se déplacer deux fois plus vite.<br/>
												- La potion incognito qui rend de couleur neutre.<br/>
												- La potion de super vue qui permet une vision de dessus en appuyant sur [?]. Pendant cette vision, aucun déplacement n\'est possible, il faut revenir avec la même touche en vue classique.
										</p>
								</th>

								<th id="infos">';
										

		$html2 = 				'</th>
							</tr>

						</table>

						<form methos="post" enctype="" action="fonctions/deconnexion.php">
							<input type="submit" value="Déconnexion"/>
 						</form>

 					  </body>

					</html>';

		echo $html1;
		$user = $_SESSION['user'];
		$login = $user->getLogin();
		echo "<h1> $login </h1>";
		echo "Score : ";
		echo  $user->getScore();
		echo "<p></p>";
		echo "Place : ";
		echo $user->getClassement();
		echo $html2;
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}

?>