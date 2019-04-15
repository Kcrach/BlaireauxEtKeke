<?php
	require("../classes/User.php");

	if(!empty($_POST['loginConnexion']) && !empty($_POST['passwordConnexion'])){
			$login = htmlspecialchars($_POST['loginConnexion']);
			$mdp = htmlspecialchars($_POST['passwordConnexion']);

			$user = new User($login,$mdp);

			if($user->existe()){
				header("Location: //localhost/BlaireauxEtKeke/index.php");
				session_start();

				$_SESSION['user']=$user;
			}
		else header("Location: //localhost/BlaireauxEtKeke/pages/login.php?&pb=badLoginOuMdp");

	}
	else{
		header("Location: //localhost/BlaireauxEtKeke/pages/login.php?&pb=champsVide");
	}
?>