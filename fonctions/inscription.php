<?php
	require("../classes/User.php");

	//On récupère les données passé dans le formulaire
	if(!empty($_POST['login']) && !empty($_POST['password'] && !empty($_POST['cPassword']))){
		$login = htmlspecialchars($_POST['login']);
		$mdp = htmlspecialchars($_POST['password']);
		$cmdp = htmlspecialchars($_POST['cPassword']);

		$users = $db->select("login, mdp","User","");
		$userExistant = false;

		//Première vérif : mdp == cmdp
		if($mdp == $cmdp){
			foreach($users as $user){
				if($user['login'] == $login){ //Vérif si le login est utilisé ou pas
					$userExistant = true;
				}
			}

			if($userExistant == false){
				$userAAjouter = new User($login,$mdp);
				$userAAjouter->ajouterBD();
			}
			else{
				header("Location: //localhost/BlaireauxEtKeke/pages/login.php?&pb=loginExistant"	);
			}
		}
		else{
			header("Location: //localhost/BlaireauxEtKeke/pages/login.php?&pb=mdpDiff");
		}

		
	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php?&pb=champsVide");
	}

	
?>