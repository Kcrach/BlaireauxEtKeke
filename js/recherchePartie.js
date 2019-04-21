function trouve(){
	
	//On supprime la roue de chargement
	document.getElementById('loader').parentNode.removeChild(document.getElementById('loader'));
	
	//On change le message et on met une barre de progression pour le lancement confirmé de la partie
	document.getElementById('h1-01').innerHTML="Recherche terminée";
	document.getElementById('message').innerHTML="La partie va débuter <br><br>";
	document.getElementById("progressBar").hidden = false;
	var timeleft = 5;
	var downloadTimer = setInterval(function(){
		document.getElementById("progressBar").value = 6 - timeleft;
		timeleft -= 1;
		if(timeleft <= 0)
			clearInterval(downloadTimer);
		if(document.getElementById("progressBar").value == 5)
			document.location.href="../Three/Lucas/test.html";// juste pour y acceder, au final emmenera vers une vraie partie
		}, 1000);
	
}

function echec(){
	document.getElementById('loader').parentNode.removeChild(document.getElementById('loader'));
	document.getElementById('h1-01').innerHTML="Recherche terminée";
	document.getElementById('message').innerHTML="Aucune partie disponible pour le moment.";
}