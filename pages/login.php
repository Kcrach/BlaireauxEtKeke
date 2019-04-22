<?php
if(isset($_SESSION['user'])){
	session_destroy();
}

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
	
		<table>
			<th>
				<fieldset>
					<legend><h1>Se connecter</h1></legend>
					<form method="post" action="../fonctions/connexion.php">
						<label>Pseudo : </label><br/>
						<input type="text" id="inputtext" name="loginConnexion"/><br/>
						
						<label>Mot de passe : </label> <br/>
						<input type="password" id="inputtext" name="passwordConnexion"/> <br/>			

						<input type="submit" id="connexion" value="Connexion"/>
					</form>
				</fieldset>
			</th>
			
			<th>
				<fieldset>
					<legend><h1>Créer un compte</h1></legend>
					<form method="post" action="../fonctions/inscription.php">
						<label>Pseudo : </label> <br/>
						<input type="text" id="inputtext" name="login"/> <br/>
						
						<!--<label>Adresse email : </label> <br/>
						<input type="text" id="inputtext"/> <br/>-->
						
						<label>Mot de passe : </label> <br/>
						<input type="password" id="inputtext" name="password"/> <br/>

						<label>Confirmer mot de passe : </label> <br/>
						<input type="password" id="inputtext" name="cPassword"/> <br/>						
						
						<input type="submit" id="inscription" value="S\'inscrire"/>
					</form>	
				</fieldset>
			</th>
			
		</table>
		
	  </body>';

	//On regarde si il y a un problème
	if(isset($_GET['pb'])){
		$pb = $_GET['pb'];
	}
	else $pb ="";

	//On agit en fonction du pb
	switch ($pb) {
		case 'loginExistant':
			$html .=  '<div id="popup_pb_login">
						<div id="popup_content">
							<p>Le login choisi n\'est pas disponible.</p>
							<button onclick="fermerPopup();" type="button">OK</button>
						</div>
					</div></html>';
			break;
		
		case 'mdpDiff':
			$html .=  '<div id="popup_pb_login">
						<div id="popup_content">
							<p>Les 2 mots de passe sont différents.</p>
							<button onclick="fermerPopup();" type="button">OK</button>
						</div>
					</div></html>';
			break;

		case 'champsVide':
			$html .=  '<div id="popup_pb_login">
						<div id="popup_content">
							<p>Veuillez remplir touts les champs.</p>
							<button onclick="fermerPopup();" type="button">OK</button>
						</div>
					</div></html>';
			break;

		case 'badLoginOuMdp':
			$html .=  '<div id="popup_pb_login">
						<div id="popup_content">
							<p>Login ou Mot de passe incorrect.</p>
							<button onclick="fermerPopup();" type="button">OK</button>
						</div>
					</div></html>';
			break;
	}

	$html.="<script src='../js/popup.js'></script></html>";

	echo $html;
?>