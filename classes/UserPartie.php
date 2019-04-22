<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";
	require_once SITE_ROOT."/classes/User.php";

	class UserPartie{
		//Attribut
		private $idPartie;
		private $idUser;
		private $typeUser; //Spec/Host/Player
		//private $posUserX;
		//private $posUserY;

		//Constructeur
		public function __construct($idU, $idP, $typeU){
			$this->idPartie = $idP;
			$this->idUser = $idU;
			$this->typeUser = $typeU;
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

		//Fonctions
		public function ajouterBD(){

			$requete = "INSERT INTO `User-Partie` VALUES(".$this->idUser.",".$this->idPartie.",'".$this->typeUser."');";

			global $db;
			$db->query($requete);
		}
	}
?>