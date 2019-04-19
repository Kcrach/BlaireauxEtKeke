<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";

	class Flaque{
		//Attributs
		private $idMap;
		private $posX;
		private $posY;

		//Constructor
		public function __construct($idM, $x, $y){
			$this->idMap = $idM;
			$this->posX = $x;
			$this->posY = $y;
		}

		//Get&Set
		public function getIdMap(){
			return $this->idMap;
		}

		public function getPosX(){
			return $this->posX;
		}

		public function getPosY(){
			return $this->posY;
		}

		//Fonction
		public function ajouterBD(){
			$requete = "INSERT INTO Flaque VALUES(".$this->idMap.",".$this->posX.",".$this->posY.");";

			global $db;
			$db->query($requete);
		}
	}
?>