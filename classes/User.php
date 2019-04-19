<?php
	require_once __DIR__."/../config.php";
	require_once SITE_ROOT."/fonctions/connexionBD.php";

	class User{
		//Attribut
		private $login;
		private $mdp;
		private $score;
		private $classement;
		private $admin;

		//Constructeur
		public function __construct($l, $m){
			$this->login = $l;
			$this->mdp = md5($m);
			$this->score = 0;
			$this->classement = "NULL";
			$this->admin = 0;
		}

		//Set&Get
		public function getLogin(){
			return $this->login;
		}

		public function getMdp(){
			return $this->mdp;
		}

		public function getScore(){
			return $this->score;
		}

		public function getClassement(){
			return $this->classement;
		}

		public function isAdmin(){	
			return $this->admin;
		}

		//Fonctions
		public function ajouterBD(){

			$requete = "INSERT INTO User VALUES(NULL,'".$this->login."','".$this->mdp."',".$this->admin.",".$this->score.",".$this->classement.");";

			global $db;
			$db->query($requete);
		}

		public function existe(){
			global $db;
			$users = $db->select("login, mdp","User","");

			$existe = false;

			foreach($users as $user){
				if($user['login'] == $this->login){
					if($user['mdp'] == $this->mdp){
						$existe = true;
					}
				}
			}

			return $existe;
		}

		public function getID(){
			$requete = "SELECT id FROM User WHERE login ='".$this->login."'";

			global $db;
			$res = $db->query($requete);

			foreach($res as $idTmp){
				$id = $idTmp['id'];
			}

			return intval($id);
		}
	}
?>