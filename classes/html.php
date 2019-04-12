<?php
	require_once("Form.php");
	require_once("../fonctions/connexion_bdd.php");
?>
<?php
	class HTML{
		private $icon;
		private $charset;
		private $titre;
		private $css;

		

		/**
		 * Constructeur de la classe HTML
		 * @param string $_icon le lien pour l'icone du site
		 * @param string $_charset définit le type de charset
		 * @param string $_titre définit le titre du site Web
		 * @param string $_css le lien vers le css
		*/
		public function __construct($_icon,$_charset,$_titre,$_css){
			$this->icon = $_icon;
			$this->charset = $_charset;
			$this->titre = $_titre;
			$this->css = $_css;
		}


		/**
		 * Fonction qui créé le code HTML dans la balise <head>
		 * @return string $html le code html de la balise <head>
		*/
		public function meta_data(){
			$html ="";
			if(!is_null($this->icon) && isset($this->icon)){
				$html .= '<link rel="shorcut icon" type="image/x-icon" href="'.$this->icon.'">'; //L'icone qui s'affiche dans l'onglet de la page
			}
			if(!is_null($this->charset) && isset($this->charset)){
				$html .= '<meta charset="'.$this->charset.'">'; //Pour définir quel charset on utilise (UTF8)
			}
			if(!is_null($this->titre) && isset($this->titre)){
				$html .='<title>'.$this->titre.'</title>'; 	//Le titre qui s'affiche dans l'onglet de la page
			}
			if(!is_null($this->css) && isset($this->css)){
				$html .='<link rel="stylesheet" href="'.$this->css.'">'; //Pour faire le lien avec le fichier css
			}

			return $html;
		}

		/**
		 * Fonction qui créé le code HTML du menu de navigation
		 * @return $html le code HTML de la barre de navigation
		*/
		public function menu_nav_bar(){
			$html = '<nav id="barre_navigation">
						<img onclick="afficherMenuMobile()" id="menu_deroulant_icon" src="../imgs/menu_deroulant_icon"/>

						<ul id="menu">
							<li><a href="../fonctions/index.php">Recherche</a></li>
							<li><a href="../fonctions/index.php">Recherche par palette</a></li>
							<li><a href="#">Calcul MRK</a></li>
						</ul>
					</nav>';

			return $html;
		}

		/**
		 * Fonction qui créé le code HTML pour mettre le logo au bon endroit
		 * @return $html le code HTML du logo
		*/
		public function logo(){
			$html = '<img id="logo" src="../imgs/logo_corner.png" alt="Logo Feralco"/>';

			return $html;
		}

		/**
		 * Fonction qui génère le code HTML de la partie "Recherche"
		 * @return string @html le code HTML de la partie "Recherche"
		*/
		public function partieRecherche(){		
			/*On met les valeurs des liste déroulante*/
			$arrayHauteurDesNiveau = $this->calcHauteurDesNiveaux(); //Le select pour les hauteurs de niveaux
			$arrayPortee = array(1850,2250,2700,2800,3300,3600,4000); //Le select pour les portées
			$arrayLargeurEchelle = array(1050,1100); //Le select pour la largeur de l'échelle
			$arrayNbTravee = array(1,2,3,"4 et plus"); //Le select pour le nombre de travées
			$arrayMontant = $this->setArrayMontant(); //Le select pour les montants
			$arrayLisse =$this->setArrayLisse(); //Le select pour les lisses

			$html = '<script type="text/javascript" src="../js/configurerNombreDeNiveauMax.js"></script>'; //On inclut le JS pour configurer le nombre de niveaux max 																																				selon la hauteur des niveaux

			/*Création du form*/
			$formRecherche = new Form("form_recherche","validerFormRecherche.php","post","","form_recherche","");

			$formRecherche->set_start_div("div_info_rech");
			$formRecherche->set_select("hauteur_des_niveaux",$arrayHauteurDesNiveau,"Hauteur des niveaux :","select_hauteur_niveaux","configurerNbNiveauMax()");
			$formRecherche->set_select("portee",$arrayPortee,"Portée :","select_portee","");
			$formRecherche->set_select("largeur_echelle",$arrayLargeurEchelle,"Largeur de l'échelle :","select_largeur_echelle","");
			$formRecherche->set_select("nb_travee",$arrayNbTravee,"Nombre de travées :","select_nb_travee","");
			$formRecherche->set_input_number("nb_niveaux","text_nb_niveaux","Nombre de niveaux","true","Nombre de niveaux :","7","1","1");
			$formRecherche->set_start_div("div_rg_type_rech");
			$formRecherche->set_radio_group("type_de_recherche","rb_recherche_charge","recherche_charge","Recherche d'une charge","true","afficherRechercheChargeOuCouple()");
			$formRecherche->set_radio_group("type_de_recherche","rb_recherche_couple","recherche_couple","Recherche d'un couple","false","afficherRechercheChargeOuCouple()");
			$formRecherche->set_end_div();

			/*Partie recherche d'une charge*/
			$formRecherche->set_start_div("div_recherche_charge");
			$formRecherche->set_select("type_montant",$arrayMontant,"Montant :","select_type_montant","");
			$formRecherche->set_select("type_lisse",$arrayLisse,"Lisse :","select_type_lisse","");
			$formRecherche->ajouter_br();
			$formRecherche->set_submit("valider_recherche_charge","submit_valider_charge","VALIDER");
			$formRecherche->set_end_div();

			/*Partie recherche d'un couple*/
			$formRecherche->set_start_div("div_recherche_couple");
			$formRecherche->set_input_valeur("number","charge_recherchee","txt_charge_recherchee","","true","100","Charge recherchee :");
			$formRecherche->ajouter_br();
			$formRecherche->set_submit("valider_recherche_couple","submit_valider_couple","VALIDER");
			$formRecherche->set_end_div();

			$formRecherche->set_end_div();

			$html .= $formRecherche->get_form(); //On récupère le code du form dans notre variable $html
			return $html;
		}

		/**
		 * Fonction qui génère le code de la partie recherche par palette
		 * @return string $_hmtl le code de la partie recherche par palette
		*/
		public function partieRechercheParPalette(){
			
			//Les arrays des listes déroulantes
			$arrayProfondeurPalette	 = array(1200);
			$arrayProfondeurEchelle = array(1050,1100);
			$arrayLargeur =array(800,1000,1200);
			$arrayJeuEntre = array(75,100);
			$arrayJeuDessus = array(75,100,125,150);
			$arrayChariot = array('Chariot 300A','Chariot 300B','Chariot 400');

			$formRechercheParPalette = new Form('form_recherche_par_palette','validerFormRPP.php',"post","",'form_rpp',"");

			$formRechercheParPalette->set_start_div("div_info_rech_par_palette");

			$formRechercheParPalette->set_start_div("form_dim_palette");
			$formRechercheParPalette->ajouter_titre("titre_dim_palette"	,"Dimension de la palette","2");
			$formRechercheParPalette->ajouter_image("img_dim_palette","../imgs/palette_form_recherche_par_palette.png");
			$formRechercheParPalette->set_locked_select('profondeur_de_la_palette',$arrayProfondeurPalette,"Profondeur de la palette :","select_profondeur_palette","");
			$formRechercheParPalette->set_select('profondeur_echelle',$arrayProfondeurEchelle,"Profondeur de l'échelle :","select_profondeur_echelle","");
			$formRechercheParPalette->set_select('largeur',$arrayLargeur,"Largeur :","select_largeur","");
			$formRechercheParPalette->set_input_number("poid_palette","number_poid_palette","Poid (Kg)","true","Poid (Kg) :","","0","");
			$formRechercheParPalette->set_input_number("hauteur_palette","number_hauteur_palette","Hauteur de la palette","true","Hauteur de la palette sans jeu :","","0","");
			$formRechercheParPalette->set_end_div();

			$formRechercheParPalette->set_start_div("form_dist_secu");	
			$formRechercheParPalette->ajouter_titre("titre_dist_secu","Distance de sécurité","2");
			$formRechercheParPalette->ajouter_image("img_dist_secu","../imgs/distance_de_secu.png");	
			$formRechercheParPalette->set_select('jeu_dessus_palette',$arrayJeuDessus,"Jeu au-dessus de la palette :","select_jeu_dessus_palette","");		
			$formRechercheParPalette->set_select('jeu_entre_palette',$arrayJeuEntre,"Jeu entre les palette :","select_jeu_entre_palette","");
			$formRechercheParPalette->set_end_div();

			$formRechercheParPalette->set_start_div("form_dim_bat");	
			$formRechercheParPalette->ajouter_titre("titre_dim_bat","Dimension du bâtiment","2");
			$formRechercheParPalette->ajouter_image("img_dim_bat","../imgs/dim_bat.png");	
			$formRechercheParPalette->set_input_number("largeur_bat","number_largeur_bat","Largeur (m)","true","Largeur (m) :","","0","");
			$formRechercheParPalette->set_input_number("longueur_bat","number_longueur_bat","Longueur (m)","true","Longueur (m) :","","0","");
			$formRechercheParPalette->set_input_number("hauteur_bat","number_largeur_bat","Hauteur (m)","true","Hauteur (m) :","","0","");
			$formRechercheParPalette->set_end_div();

			$formRechercheParPalette->set_start_div("form_select_chariot");	
			$formRechercheParPalette->ajouter_titre("titre_select_chariot","Choix du chariot","2");
			$formRechercheParPalette->set_select("select_chariot",$arrayChariot,"Chariot :","select_chariot","afficherImgChariot()");
			$formRechercheParPalette->ajouter_image("img_chariot_400","../imgs/chariot_400.jpg");
			$formRechercheParPalette->ajouter_image("img_chariot_300A","../imgs/chariot_300A.jpg");	
			$formRechercheParPalette->ajouter_image("img_chariot_300B","../imgs/chariot_300B.jpg");	
			$formRechercheParPalette->ajouter_texte("txt_chariot_300A","Chariot élévateur tri-directionnel avec conducteur embarqué. Le conducteur accompagne la charge." );
			$formRechercheParPalette->ajouter_texte("txt_chariot_300B","Chariot élévateur tri-directionnel avec conducteur au sol." );
			$formRechercheParPalette->ajouter_texte("txt_chariot_400","Chariot élévateur à contre-poids ou mat rétractable" );	
			$formRechercheParPalette->set_input_valeur_onclick("button","btn_info_chariot","btn_info_chariot","","","INFOS","","afficherInfoChariot()");
			$formRechercheParPalette->ajouter_image("img_jeu_chariot","../imgs/jeu_niveau.jpg");
			$formRechercheParPalette->set_end_div();

			$formRechercheParPalette->set_start_div("form_autres_param");
			$formRechercheParPalette->ajouter_titre("titre_autres_param","Autres paramètres","2");
			$formRechercheParPalette->set_start_div("checkbox_nb_palette");
			$formRechercheParPalette->ajouter_titre("titre_nb_palette","Nombre de palette","4");
			$formRechercheParPalette->set_input("checkbox","checkbox_2_palettes","checkbox_2_palettes","","","2 palettes");
			$formRechercheParPalette->set_input("checkbox","checkbox_3_palettes","checkbox_3_palettes","","","3 palettes");
			$formRechercheParPalette->set_input("checkbox","checkbox_4_palettes","checkbox_4_palettes","","","4 palettes");
			$formRechercheParPalette->set_end_div();
			$formRechercheParPalette->set_start_div("rg_protection");
			$formRechercheParPalette->ajouter_titre("titre_protection","Protections","4");
			$formRechercheParPalette->set_radio_group("protection","rb_avec","rb_avec","Avec protection","true","");
			$formRechercheParPalette->set_radio_group("protection","rb_sans","rb_sans","Sans protection","false","");
			$formRechercheParPalette->set_end_div();
			$formRechercheParPalette->set_start_div("rg_revetement");
			$formRechercheParPalette->ajouter_titre("titre_revetement","Revêtement","4");
			$formRechercheParPalette->set_radio_group("revetement","rb_ZN","rb_ZN","ZN","true","");
			$formRechercheParPalette->set_radio_group("revetement","rb_peint","rb_peint","Peint","false","");
			$formRechercheParPalette->set_end_div();
			$formRechercheParPalette->set_end_div();
			$formRechercheParPalette->set_submit("valider_recherche_par_palette","submit_valider_par_palette","VALIDER");

			$html = $formRechercheParPalette->get_form();

			return $html;
		}

		/**
		 * Fonction quig génére les valeurs de la liste déroulante Hauteur des niveaux
		 * @return array|int $_hauteurDesNiveaux qui contient toutes les hauteurs
		*/
		public function calcHauteurDesNiveaux(){
			$arrayHauteurDesNiveau = array();
			$i =0;
			for($i = 0; $i < 9; $i+=1){
				array_push($arrayHauteurDesNiveau, 1000+$i*250); //A chaque itération, l'array ajoute une valeur égale à 1000+i*250
			}

			return $arrayHauteurDesNiveau;
		}

		/**
		 * Fonction qui génère les valeurs de la liste déroulanle Montant (Grâce à la BD)
		 * @return array|string $_montants qui contient les noms des différents montants
		*/
		public function setArrayMontant(){
			$bdd = new BaseDeDonnees("root","","localhost","liretdcpalettierferalco");
			$bdd->connexion();

			$res =$bdd->select("m.nom_montant,p.lib_tdc","Montant m  inner join PiedMontant pm on pm.id_montant=m.id_montant inner join Pied p on pm.id_pied=p.id_pied "," m.pour_recherche=1 and m.filiale='FERALCO' "); //Requete SQL pour récupérer le nom de montants ainsi que le type de pied associé
			$arrayMontant = array();
			foreach ($res as $key) {
				$stringTmp = $key["nom_montant"]." ".$key["lib_tdc"]; 
				array_push($arrayMontant, $stringTmp); //A chaque itération, l'array ajoute une valeur égale à "nom montant type pied"
			}
			return $arrayMontant;
		}

		/**
		 * Fonction qui génère les valeurs de la liste déroulanle Lisse (Grâce à la BD)
		 * @return array|string $_lisses qui contient les noms des différents montants
		*/
		public function setArrayLisse(){
			$bdd = new BaseDeDonnees("root","","localhost","liretdcpalettierferalco");
			$bdd->connexion();

			$res= $bdd->select("nom_lisse","Lisse",""); //Requête SQL pour récupérer les nom des lisses
			$arrayLisse = array();
			foreach ($res as $key) {
				array_push($arrayLisse, $key["nom_lisse"]);
			}
			return $arrayLisse;
		}

		/**
		 * Fonction qui permet d'afficher les boutons EXPORT PDF et RETOUR
		 * @return string $_html le code html de la popup
		*/
		public function boutonResRechCplOuCharge(){
			$html = '<div id="btns_res_rech_cpl_ou_charge">';
			$html .=	'<form target="_blank" action="../fonctions/exportPDFResCplOuCharge.php" method="post" id="form_export_pdf">';
			$html .= 		'<input type="submit" value="EXPORTER (PDF)"/>';
			$html .=	'</form>';
			$html .=	'<a href="../fonctions/index.php">RETOUR</a>';
			$html .= '</div>';

			return $html;
		}

		/**
		 *Fonction qui permet de générer le code de l'index
		 * @return string $_html le code HTML de l'index
		*/
		public function index(){
			$html ='<div id="div_recherche">';
			//$html .=		'<img id="img_recherche" src="../imgs/rayonnage_palette.png">';	
			$html .=		'<button onclick="afficherRecherche()" id="btn_recherche_simple">RECHERCHE SIMPLE</button>';
			$html .=		'<button onclick="afficherRechercheParPalette()" id="btn_recherche_par_palette">RECHERCHE PAR PALETTE</button>';
			$html .=		'<img id="img_recherche_simple" src="../imgs/rayonnage_palette_recherche_simple_form.png">';
			$html .= 		$this->partieRecherche();
			$html .=		$this->partieRechercheParPalette();
			$html .='</div>';

			return $html;
		}

		public function boutonExporterTout(){
			$html = 	'<form action="../fonctions/exportPDFResRPP.php" method="post" id="form_export_res_rpp" target="_blank">
							<input id="btn_export_res_rpp" type="submit" value="TOUT EXPORTER (PDF)"/>
						</form>';

			return $html;
		}

		/**
		 *Fonction pour affciher les boutons de la page résultat lors d'une recherche par palette
		 * @return string $html le code HTLM des boutons
		 */
		public function boutonsResRechRPP(){
			$html = '<div id="btns_res_rech_rpp">';

			$html .= 	'<form action="../fonctions/exportPDFResSelectionRPP.php" method="post" id="form_export_res_selection_rpp" target="_blank">
							<input id="btn_export_res_selection_rpp" type="submit" value="EXPORTER RESULTAT CHOISI (PDF)"/>
						</form>';

			$html .=	'<form action="../fonctions/exportNomResRPP.php" method="post" id="btn_export_nom_res_rpp">
							<input type="submit" value="EXPORTER (NOMENCLATURE)"/>
						</form>';

			$html .=	'<form action="../fonctions/versSRPRO.php" method="post" id="btn_visualiser_SRPRO">
							<input type="submit" value="VISUALISER EN 3D"/>
						</form>';

			$html .=	'<form action="../fonctions/configurerCalculPalettier.php method="post" id="btn_config_calc">
							<input type="submit" value="CONFIGURER CALCUL"/>
						</form>';

			$html .=	'<a id="btn_retour" href="../fonctions/index.php">RETOUR</a>';
			$html .= '</div>';

			return $html;
		}
	}
?>