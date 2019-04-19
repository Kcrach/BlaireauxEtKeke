<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";

	class Partie{
		//Attribut
		private $etat;
		private $date;
		private $idMap;

		//Constructeur
		public function __construct($idM){
			$this->etat = 0;
			$this->idMap = $idM;
		}

		//Set&Get
		public function isEtat(){
			return $this->etat;
		}

		public function getDate(){
			return $this->date;
		}

		public function getidMap(){
			return $this->idMap;
		}

		//Fonctions
		public function ajouterBD(){

			$requete = "INSERT INTO Partie VALUES(NULL,".$this->etat.",SYSDATE(),".$this->idMap.");";

			global $db;
			$db->query($requete);
		}

		public function getID(){
			$requete = "SELECT max(id) as id FROM Partie";

			global $db;
			$res = $db->query($requete);

			foreach($res as $idTmp){
				$id = $idTmp['id'];
			}

			return intval($id);
		}
	}
?>