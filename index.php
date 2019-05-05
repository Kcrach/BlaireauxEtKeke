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
							<title>Blaireaux vs Kékés</title>
							<link rel="stylesheet" href="styles/accueil.css" name="theme" id="theme">
							<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
							<!--<script src="js/login.js"></script>-->
						</head>

					<body>

						<header id="header">
							<h1 id="titre">BLAIREAUX vs KÉKÉS</h1>
							<span>Theme : </span>';
							if(isset($_POST['themes'])){
			$var = $_POST['themes'];
			if($var == "Défaut"){
				$html1.='<select method="post" id="themes" onchange="switchTheme(this.selectedIndex)">
				<option selected="selected">Défaut</option>
				<option>Corail</option>
				<option>Hiver</option>
			</select>
			</header>';}
			else{
			if($var == "Corail"){
				$html1.='<select method="post" id="themes" onchange="switchTheme(this.selectedIndex)">
				<option>Défaut</option>
				<option selected="selected">Corail</option>
				<option>Hiver</option>
			</select>
			</header>';}
			else{
				if($var == "Hiver"){
				$html1.='<select method="post" id="themes" onchange="switchTheme(this.selectedIndex)">
				<option >Défaut</option>
				<option>Corail</option>
				<option selected="selected">Hiver</option>
			</select>
							</header>';}}}}

			else{
			$html1.='<select method="post" id="themes" onchange="switchTheme(this.selectedIndex)">
				<option selected="selected">Défaut</option>
				<option>Corail</option>
				<option>Hiver</option>
			</select>
			</header>';}


					$html1.='<img src="img/badger.png"/>

						<table id="table">
							<tr>
								<th id="liens">
									<form method="post" action="pages/creerPartie.php">
										<input type="submit" id="CréerPartie" value="Créer une partie"/>
									</form>
									
									<form method="post" action="pages/recherchePartie.php">
										<input type="submit" id="RechPartie" value="Rejoindre partie"/>
									</form>
								
									<a href="pages/enConstruction.php"><p> Liens utiles </p></a>

									<form method="post" action="pages/leaderboard.php">
										<input type="submit" id="Rank" value="Leaderboard"/>
									</form>
									
									<a href="pages/enConstruction.php"><p> F.A.Q </p></a>

								</th>

								<th>
										<h2 id="règles"> Règles du jeu </h2>
										<p align=left>

											- Les joueurs sont répartis aléatoirement en deux équipes: les kékés en surnombre et les blaireaux moins nombreux.<br/>
											- Les vilains blaireaux ont pour objectif de manger les gentils kékés.<br/>
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
												- La potion de super vue qui permet une vision de dessus en appuyant sur [🠣]. Pendant cette vision, aucun déplacement n\'est possible, il faut revenir avec la même touche en vue classique.
										</p>
								</th>

								<th id="infos">';
									$html2 = 
								'</th>
							</tr>

						</table>

						<form method="post" enctype="" action="fonctions/deconnexion.php">
							<input type="submit" id="deconnexion" value="Déconnexion"/>
 						</form>

 					  </body>';
					$html2.="<script src='js/themes.js'></script></html>";


		echo $html1;
		$user = $_SESSION['user'];
		$login = $user->getLogin();
		echo "<h1> $login </h1>";
		echo "Score : ";
		echo  $user->getScore();
		echo "<p></p>";
		echo "Classement : ";
		echo $user->getClassement();
		echo $html2;
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}

?>