<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/Flaque.php";
	session_start();

	if(isset($_SESSION['user'])){
		echo $_GET['x'];

		if(isset($_GET['idMap']) && isset($_GET['y']) && isset($_GET['x'])){
			$idMap = $_GET['idMap'];
			$x=$_GET['x'];
			$y=$_GET['y'];

			$flaque = new Flaque($idMap,$x,$y);	
			$flaque->ajouterBD();		
		}
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php");
	}
	
?>