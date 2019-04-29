
<?php

	class BaseDeDonnees{
		//Attribut de la class
		private $utilisateur; //Nom de l'utilisateur PhpMyAdmin (paramètre pour créer la connection PDO)
		private $motDePasse; //Mot de passe PhpMyAdmin (paramètre pour créer la connection PDO)
		private $host; //Nom de l'host (paramètre pour créer la connection PDO)
		private $nomDeBaseDeDonnees; // (paramètre pour créer la connection PDO)
		private $pdo; //Le PDO qui permet de se connecter à la BD


		/**
		 * Constructeur de la classe
		 * @param string $_utilisateur 
		 * @param string $_motDePasse
		 * @param string $_host
		 * @param string $_nomBD
		 **/
		public function __construct($_utilisateur,$_motDePasse,$_host,$_nomBD){
			$this->set_utilisateur($_utilisateur);
			$this->set_motDePasse($_motDePasse);
			$this->set_host($_host);
			$this->set_nomDeBaseDeDonnees($_nomBD);
		}


		//Set & Get

		/**
	     * Seter de $utilisateur 
		 * @param string $_utilisateur nom de l'utilisateur PhpMyAdmin 
		**/
		public function set_utilisateur($_utilisateur){
			$this->utilisateur = $_utilisateur;
		}

		/**
		 * Seter de $motDePasse
		 * @param string $_motDePasse mot de passe PhpMyAdmin
		**/
		public function set_motDePasse($_motDePasse){
			$this->motDePasse = $_motDePasse;
		}

		/**
		 * Seter de $host
		 * @param string $_host nom de l'host
		**/
		public function set_host($_host){
			$this->host = $_host;
		}

		/**
		 * Seter de $nomDeBaseDeDonnees
		 * @param string $_nomBD nom de l'host
		**/
		public function set_nomDeBaseDeDonnees($_nomBD){
			$this->nomDeBaseDeDonnees = $_nomBD;
		}

		/**
		 * Getter de $pdo
		 * @return pdo la base de données à laquelle on est connecté
		**/
		public function get_pdo(){
			return $this->pdo;
		}

		/**
		 * Fonction qui permet de se connecter à la base de données
		**/
		public function connexion(){
			try{
				$dsn = 'mysql:host='.$this->host.';port=3306;dbname='.$this->nomDeBaseDeDonnees.'';
				$this->pdo = new PDO($dsn,$this->utilisateur,$this->motDePasse,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
				$this->pdo->query("SET NAMES UTF8");
			}		
			catch(Exception $e){
				die('Erreur : '.$e->getMessage());
			}
		}

		/**
		 * Fonction sql 'SELECT' dans la base de données
		 * @param string $_attribut l'attribut que l'on veut chercher grâce à la requête
		 * @param string $_table la table dans laquelle on effectue la requête
		 * @param string $_condition la condition (s'il y en a) sur la requête
		 * @return array|string qui contient tout les résulats de notre requête
		*/
		public function select($_attribut,$_table,$_condition){
			$requete="SELECT $_attribut FROM $_table";

			//On test s'il y a une condition
			if($_condition != ""){
				$requete .= " WHERE ".$_condition."";
			}

			$res= $this->pdo->query($requete);
			return $res;
		}

		/**
		 * Faire une requete dans la base de données
		 * @param string $requete la requete que l'on veut faire
		 * @return array|string qui contient tout les résulats de notre requête
		*/
		public function query($_requete){
			$res= $this->pdo->query($_requete);
			return $res;
		}

	}