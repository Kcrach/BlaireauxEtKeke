<?php
	class Form{
		private $form; //Le code HTML qui correspond au form

		/**
		 * Constructeur de la class form qui permet de commencer le formulaire HTML
		 * @param string $_nom le nom du formulaire crée
		 * @param string $_action la fonction utilisé à l'envoi du formulaire
		 * @param string $_methode la méthode utilisée pour l'envoi des données (POST || GET)
		 * @param string $_enctype l'enctype utilisé pour le formulaire (peut être égal à '')
		 * @param string $_id l'ID CSS pour mettre en forme le formulaire
		 * @param string $_onsubmit l'action réaliser au moment du submit
		*/
		public function __construct($_nom,$_action,$_methode,$_enctype,$_id, $_onsubmit){
			$this->form ="<form id='".$_id."' name='".$_nom."' method='".$_methode."' action='".$_action."' onsubmit='".$_onsubmit."'";

			if($_enctype == ""){
				$this->form .= ">";
			}
			else{
				$this->form .= " enctype='".$_enctype."'>";
			}
		}


		/**
		 * Fonction qui permet d'ajouter un input au form
		 * @param string $_type le type d'input que l'on veut ajouter (text, radio, etc...)
		 * @param string $_nom le nom de l'input
		 * @param string $_id l'ID CSS pour modifier le style de l'input
		 * @param string $_placeholder pour mettre un texte indicatif
		 * @param boolean $_requis pour obliger l'utilisateur a remplir le champ avant de valider le form
		 * @param string $_label le texte qui apparait à coté de l'input
		*/
		public function set_input($_type,$_nom,$_id,$_placeholder,$_requis,$_label){
			$this->form .='<p id="label_'.$_nom.'">'.$_label.'</p>';
			$this->form .= '<input id="'.$_id.'" type="'.$_type.'"';

			if($_nom != ""){
				$this->form .= ' name="'.$_nom.'"';
			}
			if($_placeholder != ""){
				$this->form .= " placeholder='".$_placeholder."'";
			}
			if($_requis == "true"){
				$this->form .= " required";
			}

			$this->form .= ">";
		}

		/**
		 * Fonction qui permet d'ajouter un input au form
		 * @param string $_nom le nom de l'input
		 * @param string $_id l'ID CSS pour modifier le style de l'input
		 * @param string $_placeholder pour mettre un texte indicatif
		 * @param boolean $_requis pour obliger l'utilisateur a remplir le champ avant de valider le form
		 * @param string $_label le texte qui apparait à coté de l'input
		 * @param int $_max le nombre maximum que l'utilisateur peut mettre
		 * @param int $_min le nombre minimum que l'utilisateur peut mettre
		 * @param string $_value la valeur par défaut dans la zone de texte
		*/
		public function set_input_number($_nom,$_id,$_placeholder,$_requis,$_label, $_max,$_min, $_value){
			$this->form .='<p id="label_'.$_nom.'">'.$_label.'</p>';
			$this->form .= '<input id="'.$_id.'" type="number"';

			if($_nom != ""){
				$this->form .= ' name="'.$_nom.'"';
			}
			if($_placeholder != ""){
				$this->form .= " placeholder='".$_placeholder."'";
			}
			if($_max != ""){
				$this->form .= "max='".$_max."'";
			}
			if($_min != ""){
				$this->form .= "min='".$_min."'";
			}
			if($_value != ""){
				$this->form .= "value='".$_value."'";
			}
			if($_requis == "true"){
				$this->form .= " required";
			}

			$this->form .= ">";
		}

		/**
		 * Fonction qui permet de commencer une div
		 * @param string $_id l'ID CSS de la div 
		*/
		public function set_start_div($_id){
			$this->form .= "<div id='".$_id."'>";
		}

		/**
		 * Fonction qui permet de terminer une div
		*/
		public function set_end_div(){
			$this->form .= "</div>";
		}

		/**
		 * Fonction qui permet d'ajouter le bouton Submit au form
		 * @param string $_nom le nom du bouton
		 * @param string $_id l'ID CSS pour modifier le style du bouton
		 * @param string $_valeur le texte affiché dans le bouton Submit
		*/
		public function set_submit($_nom,$_id,$_valeur){
			$this->form .= "<input type='submit' name='".$_nom."' id='".$_id ."' value='".$_valeur."'>";
		}

		/**
		 * Fonction pour supprimer le form
		*/
		public function reset_form(){
			$this->form = "";
		}

		/**
		 * Function pour récuperer le code du formulaire
		 * @return string $form le code HTML du formulaire
		*/
		public function get_form(){
			$this->form .= "</form>";

			return $this->form;
		}

		/**
		 * Fonction qui permet d'ajouter un élément au formulaire mais avec une valeur par défaut
		 * @param string $_type le type d'input que l'on veut ajouter (text, radio, etc...)
		 * @param string $_nom le nom de l'input
		 * @param string $_id l'ID CSS pour modifier le style de l'input
		 * @param string $_placeholder pour mettre un texte indicatif
		 * @param boolean $_requis pour obliger l'utilisateur a remplir le champ avant de valider le form
		 * @param string $_valeur la valeur par défaut assignée à l'élément ajouté
		 * @param string $_label le texte qui apparait à coté de l'input
		*/
		public function set_input_valeur($_type,$_nom,$_id,$_placeholder,$_requis, $_valeur,$_label){
			$this->form .='<p id="label_'.$_nom.'">'.$_label.'</p>';
			$this->form .= '<input id="'.$_id.'" type="'.$_type.'"';

			if($_nom != ""){
				$this->form .= " name='".$_nom."'";
			}
			if($_placeholder != ""){
				$this->form .= " placeholder='".$_placeholder."'";
			}
			if($_requis == "true"){
				$this->form .= " required";
			}
			if($_valeur != ""){
				$this->form .= " value='".$_valeur."'";
			}

			$this->form .= ">";
		}

		/**
		 * Fonction qui permet d'ajouter un élément au formulaire mais avec une valeur par défaut
		 * @param string $_type le type d'input que l'on veut ajouter (text, radio, etc...)
		 * @param string $_nom le nom de l'input
		 * @param string $_id l'ID CSS pour modifier le style de l'input
		 * @param string $_placeholder pour mettre un texte indicatif
		 * @param boolean $_requis pour obliger l'utilisateur a remplir le champ avant de valider le form
		 * @param string $_valeur la valeur par défaut assignée à l'élément ajouté
		 * @param string $_label le texte qui apparait à coté de l'input
		 * @param string $_onclick la fonction qui est appelé au click
		*/
		public function set_input_valeur_onclick($_type,$_nom,$_id,$_placeholder,$_requis, $_valeur,$_label,$_onclick){
			$this->form .= '<input id="'.$_id.'" type="'.$_type.'"';

			if($_nom != ""){
				$this->form .= " name='".$_nom."'";
			}
			if($_placeholder != ""){
				$this->form .= " placeholder='".$_placeholder."'";
			}
			if($_requis == "true"){
				$this->form .= " required";
			}
			if($_valeur != ""){
				$this->form .= " value='".$_valeur."'";
			}
			if($_onclick!=""){
				$this->form .= " onclick='".$_onclick."'";
			}

			$this->form .= ">";
			$this->form .='<p id="label_'.$_nom.'">'.$_label.'</p>';
		}

		/**
		 * Fonction qui permet d'ajouter un radio group
		 * @param string $_nom le nom des boutons
		 * @param string $_value
		 * @param string $_id l'ID CSS pour modifier le style des boutons
		 * @param string $_label le texte affiché à coté des boutons 
		 * @param boolean $_checked si le bouton est check ou pas
		 * @param string $_onclick si on fait une action au clic
 		*/
		public function set_radio_group($_nom,$_id,$_value,$_label,$_checked,$_onclick){			
			$this->form .= '<input type="radio" name="'.$_nom.'" id="'.$_id.'" value="'.$_value.'"';
			
			if($_checked == "true"){
				$this->form .= 'checked';
			}
			if($_onclick != ""){
				$this->form .= ' onclick="'.$_onclick.'">';
			}
			else {
				$this->form .= '>';
			}

			$this->form .= '<label id="label'.$_id.'"for="'.$_id.'" >'.$_label.'</label>';
		}

		/**
		 * Fonction qui permet d'ajouter une liste déroulante au form
		 * @param string $_nom le nom de la liste déroulante
		 * @param array|string $_valeurs les différentes options de la liste déroulante
		 * @param string $_label le texte qui s'affiche au dessus de la liste déroulante
		 * @param string $_id l'ID CSS pour modifier le style de nos listes
		 * @param string $_onclick l'action effectué au clic sur le select
		*/
		public function set_select($_nom,$_valeurs,$_label,$_id, $_onclick){
			$this->form .= '<label id="label_'.$_id.'" for="'.$_nom.'">'.$_label."</label><br/>";
			$this->form .= '<select id="'.$_id.'"name="'.$_nom.'"';

			if($_onclick != ""){
				$this->form .= " onclick='".$_onclick."'>";
			}
			else{
				$this->form .= '>';
			}

			foreach($_valeurs as $key){
				$this->form.= '<option value="'.$key.'">'.$key."</option>";
			}
			$this->form .= "</select><br/>";
		}

		/**
		 * Fonction qui permet d'ajouter une liste déroulante au form
		 * @param string $_nom le nom de la liste déroulante
		 * @param array|string $_valeurs les différentes options de la liste déroulante
		 * @param string $_label le texte qui s'affiche au dessus de la liste déroulante
		 * @param string $_id l'ID CSS pour modifier le style de nos listes
		 * @param string $_onclick l'action effectué au clic sur le select
		*/
		public function set_locked_select($_nom,$_valeurs,$_label,$_id, $_onclick){
			$this->form .= '<label id="label_'.$_id.'" for="'.$_nom.'">'.$_label."</label><br/>";
			$this->form .= '<select id="'.$_id.'"name="'.$_nom.'"';

			if($_onclick != ""){
				$this->form .= " onclick='".$_onclick."'disabled>";
			}
			else{
				$this->form .= 'disabled>';
			}

			foreach($_valeurs as $key){
				$this->form.= '<option value="'.$key.'">'.$key."</option>";
			}
			$this->form .= "</select><br/>";
		}

		/**
		 * Fonction qui permet d'ajouter un saut de ligne dans le formulaire
		*/
		public function ajouter_br(){
			$this->form .= "</br>";
		}

		/**
		 *Fonction qui permet d'ajouter une image
		 * @param string $_id l'id de l'image
		 * @param string $_src l'endroit pour aller chercher l'image
		*/
		public function ajouter_image($_id,$_src){
			$html = '<img id="'.$_id.'" src="'.$_src.'"/>';

			$this->form .= $html;
		}

		/**
		 *Fonction qui permet d'ajouter un titre au form
		 * @param string $_id l'id du titre
		 * @param string $_txt le contenu du titre
		 * @param int $_taille la taille du titre (h1,h2,h3...)
		*/
		public function ajouter_titre($_id,$_txt,$_taille){
			$html = '<h'.$_taille.' id="'.$_id.'">'.$_txt.'</h'.$_taille.'>';

			$this->form .= $html;
		}

		/**
		 * Fonction qui permet d'ajouter une zone de texte
		 * @param  string $_id m'id de la zone de texte
		 * @param string $_texte le texte dans la zone
		*/
		public function ajouter_texte($_id,$_texte){
			$html ='<p id="'.$_id.'">'.$_texte.'</p>';

			$this->form .= $html;
		}

	}





?>