<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";
	require_once SITE_ROOT."/classes/User.php";
	session_start();

	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
$html = '<!DOCTYPE html>
	<html lang="fr">
	
		<head>
			<meta charset="utf-8">
			<title>Connexion</title>
			<link rel="stylesheet" href="../styles/leaderboard.css" >
			<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet"> 
		</head>
	
	<body>

		<header id="header">
			<h1 id="titre">BLAIREAUX vs KÉKÉS</h1>
			<span>Theme : </span>';
			
	if(isset($_POST['themes'])){
			$var = $_POST['themes'];
			if($var == "Défaut"){
				$html.='<select method="post" id="themes" onchange="switchTheme(this.selectedIndex)">
				<option selected="selected">Défaut</option>
				<option>Royal</option>
				<option>Hiver</option>
			</select>
			</header>';}
			else{
			if($var == "Royal"){
				$html.='<select method="post" id="themes" onchange="switchTheme(this.selectedIndex)">
				<option>Défaut</option>
				<option selected="selected">Royal</option>
				<option>Hiver</option>
			</select>
			</header>';}
			else{
				if($var == "Hiver"){
				$html.='<select method="post" id="themes" onchange="switchTheme(this.selectedIndex)">
				<option >Défaut</option>
				<option>Royal</option>
				<option selected="selected">Hiver</option>
			</select>
			</header>';}}}}

			
			else{
			$html.='<select method="post" id="themes" onchange="switchTheme(this.selectedIndex)">
				<option selected="selected">Défaut</option>
				<option>Royal</option>
				<option>Hiver</option>
			</select>
			</header>';}


		$html.='<img src="../img/badger.png" align="center"/>';
		$jou=$_GET['profil'];
	$info=$db->select(" * "," user ", 'login="'.$jou.'"');
	//Plutôt que de faire un foreach, on récupère le nombre de lignes de la table.
	$transmis=$info->fetch();
	$html.="<table id='table'>";
		
		$html.='<tr><td>Nom du joueur</td><td>'.$transmis["login"].'</td>';
		$html.='<tr><td>Classement</td><td>'.$transmis["classement"].'</td>';
		$html.='<tr><td>Score total</td><td>'.$transmis["score"].'</td>';
			

	
	
		
	 $html.='</table><form method="post" enctype="" action="../fonctions/RetourAccueil.php">
			<input type="submit" id="retour" value="Retour accueil"/>
			</form>
						 
			<form method="post" enctype="" action="../fonctions/deconnexion.php">
			<input type="submit" id="deconnexion" value="Déconnexion"/>
			</form>	';				

	 $html.='</body>';

	

	$html.="<script src='../js/popup.js'></script></html>";
	$html.="<script src='../js/themes.js'></script></html>";
	
		echo $html;
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>