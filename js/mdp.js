function typePartie()
{
	if (document.getElementById('Public').checked) 
		document.getElementById('bloqué').innerHTML="";
	else
		document.getElementById('bloqué').innerHTML="<label for=\"mdp\"> Mot de passe :</label> </br> <input type=\"text\" id=\"mdp\" name=\"mdpPartie\" />";
}