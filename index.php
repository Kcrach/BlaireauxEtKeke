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
										<p>

											Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tincidunt velit ligula, ut posuere augue hendrerit vitae. Ut viverra felis ac felis dapibus, sed euismod elit lobortis. In hac habitasse platea dictumst. Nunc justo mauris, fermentum in accumsan a, finibus in ante. Nullam a tincidunt massa, tincidunt bibendum ligula. Suspendisse risus tellus, vehicula ut vestibulum non, congue consequat ex. Vestibulum maximus aliquam dapibus. Maecenas sodales urna arcu, id commodo nisl gravida eu. Sed eu neque egestas, sodales urna quis, finibus leo. Curabitur non tincidunt magna. Nunc vel finibus nulla. Maecenas fermentum libero in purus vestibulum, et euismod erat dictum.

											Quisque nec nibh mi. Aliquam aliquet viverra magna, id ornare massa lobortis quis. Duis tempus pretium risus, sit amet blandit justo suscipit eget. Fusce ut nisl commodo, ullamcorper nisl vel, sagittis tellus. Suspendisse neque nisl, vulputate ultricies sapien ut, luctus dapibus ante. Nunc eget leo pulvinar, pulvinar augue nec, porttitor lorem. Donec quis euismod leo. Integer lacinia risus in justo rhoncus rhoncus. Pellentesque cursus ac velit nec posuere. Ut aliquet facilisis ante, ac pulvinar sapien tempor et. Integer ex nibh, facilisis vel lorem sed, aliquet posuere ex. Pellentesque porttitor rhoncus elit vitae interdum.

											Pellentesque tincidunt lectus vel libero dictum porttitor bibendum nec libero. Suspendisse varius tortor enim, sed imperdiet lectus pretium et. Nunc tincidunt, velit bibendum venenatis ultrices, elit felis suscipit nulla, eget vulputate nibh sem vel erat. Nullam dui magna, porttitor vitae placerat vitae, porta vel justo. Mauris aliquam mauris ultrices dui consectetur ultrices. Etiam porta sollicitudin nunc, non tempor urna consequat ut. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam sit amet risus ac augue interdum accumsan a eu metus. Fusce vitae tristique felis, id consectetur mauris. Duis eget dui eu diam tincidunt congue. Maecenas vitae enim congue, congue ante eu, ullamcorper ex.

											Proin sit amet hendrerit nisi, efficitur tempus massa. Vivamus vitae gravida lectus. Quisque viverra massa felis, eu ornare libero auctor eu. Ut varius libero ante, ut dapibus justo consectetur eu. Nunc et tellus luctus libero tempus dapibus sit amet in ligula. Ut purus orci, consectetur eget odio sed, suscipit auctor est. Nam iaculis dapibus mauris eu hendrerit. Nulla vitae arcu vel odio rhoncus tristique ut sodales mi.

											Mauris cursus magna in eros elementum fringilla. Quisque finibus lectus ac sapien pharetra semper. Curabitur eget elit a mauris molestie maximus. In eu laoreet dui. Vestibulum sodales pharetra suscipit. Sed aliquam nunc vitae eros aliquam, sit amet faucibus ante rutrum. Fusce elementum posuere ante, id elementum mi.
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