<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/classes/DataBase.php";
	require_once SITE_ROOT."/db/configBD.php";

	global $db;
	$db = new BaseDeDonnees($login,$mdp,$host,$database); //Instanciation d'un objet BaseDeDonnees
	$db->connexion(); //Connexion à la BD à partir du fichier de config

	//Test
	/*$res = $db->select("login","user","");
	foreach ($res as $login) {
		echo $login['login'];
	}*/
?>