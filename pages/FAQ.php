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
			<title>Blaireaux vs Kékés</title>
			<link rel="stylesheet" href="../styles/FAQ.css" >
			<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet"> 
		</head>
	
	<body>

		<header id="header">
			<h1 id="titre">BLAIREAUX vs KÉKÉS</h1>
				<form  id="theme" method="post">
			  <fieldset id="changetheme">
				<legend>Theme : </legend>
				<select id="themes" onchange="switchTheme(this.selectedIndex)">
					<option selected="selected">Défaut</option>
					<option>Corail</option>
					<option>Hiver</option>
				</select>
			  </fieldset>
			</form>
		</header>

		<img src="../img/badger.png" align="center"/>';
		
	

		
	   $html.='
	   <table id="table">
							<tr>
								<th id="liens">
									<form method="post" >
										<input type="button" id="Q1" value="Qui sommes nous?" onClick="applitexte1()"/>
									</form>
									
									<form method="post">
										<input type="button" id="Q2" value="Blaireaux et Keke?" onClick="texte2()"/>
									</form>
								
									<form method="post" >
										<input type="button" id="Q3" value="Nos objectifs" onClick="texte3()"/>
									</form>

									<form method="post" >
										<input type="button" id="Q4" value="Un mentor?" onClick="texte4()"/>
									</form>
									
									<form method="post" >
										<input type="button" id="Q5" value="Remerciements" onClick="texte5()"/>
									</form>

								</th>
								
								<th id="reponse">Cliquez sur une des rubriques pour en afficher le contenu</th></tr></table>
	  <form method="post" enctype="" action="../fonctions/RetourAccueil.php">
			<input type="submit" id="retour" value="Retour accueil"/>
			</form>
						 
			<form method="post" enctype="" action="../fonctions/deconnexion.php">
			<input type="submit" id="deconnexion" value="Déconnexion"/>
			</form>	
								';				
			
	
	 $html.="</body>";

	

	$html.="<script src='../js/popup.js'></script>";
	$html.="<script src='../js/themes.js'></script>";
	$html.="<script src='../js/question.js'></script></html>";


	
		echo $html;
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>