<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";
	require_once SITE_ROOT."/classes/User.php";

	class UserPartie{
		//Attribut
		private $idPartie;
		private $idUser;
		private $typeUser; //Spec/Host/Player
		private $posX;
		private $posY;

		//Constructeur
		public function __construct($idU, $idP, $typeU){
			$this->idPartie = $idP;
			$this->idUser = $idU;
			$this->typeUser = $typeU;
		}

		public function __construct($idU, $idP, $typeU, $x, $y){
			$this->idPartie = $idP;
			$this->idUser = $idU;
			$this->typeUser = $typeU;
			$this->posX = $x;
			$this->posY = $y;
		}

		//Set&Get
		public function getIDPartie(){
			return $this->idPartie;
		}

		public function getIDUser(){
			return $this->idUser;
		}

		public function getTypeUser(){
			return $this->typeUser;
		}

		public function getPosX(){
			return $this->posX;
		}

		public function getPosY(){
			return $this->posY;
		}

		//Fonctions
		public function ajouterBD(){

			$requete = "INSERT INTO `User-Partie` VALUES(".$this->idUser.",".$this->idPartie.",'".$this->typeUser."',NULL,NULL,NULL);";

			global $db;
			$db->query($requete);
		}

		public function ajouterBDPlayer(){

			$requete = "INSERT INTO `User-Partie` VALUES(".$this->idUser.",".$this->idPartie.",'".$this->typeUser."',NULL,".$this->posX.",".$this->posY.");";

			global $db;
			$db->query($requete);
		}
	}
?>