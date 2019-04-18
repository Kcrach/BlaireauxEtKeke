<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";

	class Partie{
		//Attribut
		private $etat;
		private $date;
		private $idMap;

		//Constructeur
		public function __construct($d, $idM){
			$this->etat = 0;
			$this->date = $d;
			$this->idMap = $idm;
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

			$requete = "INSERT INTO Partie VALUES(NULL,".$this->etat.",'".$this->date."',".$this->idMap.");";

			global $db;
			$db->query($requete);
		}
	}
?>