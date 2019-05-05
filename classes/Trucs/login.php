<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8">
		<title>Connexion</title>
		<link rel="stylesheet" href="login.css" name="theme" id="theme">
		<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet"> 
		<script src="login.js"></script>
	</head>

<body>

	<header>
		<h1 id="titre">BLAIREAUX vs KÉKÉS</h1>
		<span>Theme : </span>
		<select id="themes" onchange="switchTheme(this.selectedIndex)">
			<option selected="selected">Défaut</option>
			<option>Royal</option>
			<option>Hiver</option>
		</select>
	</header>

	<img src="badger.png" align="center"/>
	
	<table>
		<th>
			<fieldset>
				<legend><h1>Se connecter</h1></legend>
				<form>
					<label>Pseudo : </label><br/>
					<input type="text" id="inputtext"/><br/>
					
					<label>Mot de passe : </label> <br/>
					<input type="password" id="inputtext"/> <br/>			
					
					<input type="submit" id="connexion" value="Connexion"/>
				</form>
			</fieldset>
		</th>
		
		<th>
			<fieldset>
				<legend><h1>Créer un compte</h1></legend>
				<form>
					<label>Pseudo : </label> <br/>
					<input type="text" id="inputtext"/> <br/>
					
					<label>Adresse email : </label> <br/>
					<input type="text" id="inputtext"/> <br/>
					
					<label>Mot de passe : </label> <br/>
					<input type="password" id="inputtext"/> <br/>	

					<label>Confirmer mot de passe : </label> <br/>
					<input type="password" id="inputtext"/> <br/>						
					
					<input type="submit" id="inscription" value="S'inscrire"/>
				</form>	
			</fieldset>
		</th>
		
	</table>
	
  </body>
	
</html>
