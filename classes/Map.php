<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";

	class Map{
		//Constructor
		public function __construct(){}

		//Fonction
		function ajouterBD(){
			$requete = "INSERT INTO Map VALUES(NULL);";

			global $db;
			$db->query($requete);
		}

		function getID(){
			$requete = "SELECT max(id) as id FROM Map";

			global $db;
			$res = $db->query($requete);

			foreach($res as $idTmp){
				$id = $idTmp['id'];
			}

			return intval($id);
		}
	}
?>