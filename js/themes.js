function switchTheme(index){
	var body = document.body;
	var header = document.getElementById("header");
	var table = document.getElementById("table");
	switch (index){
		case 0 :
			body.style.backgroundColor = "#172935";
			header.style.animation = "couleur0 5s infinite alternate-reverse";
			table.style.animation = "couleur0 5s infinite alternate-reverse";
			break;

		case 1 :
			body.style.backgroundColor = "#cc0000";
			header.style.animation = "couleur1 5s infinite alternate-reverse";
			table.style.animation = "couleur1 5s infinite alternate-reverse";
			header.style.WebkitAnimation = "couleur1 5s infinite alternate-reverse";
			table.style.WebkitAnimation = "couleur1 5s infinite alternate-reverse";
			break;

		case 2 :
			body.style.backgroundColor = "#595959";
			header.style.animation = "couleur2 5s infinite alternate-reverse";
			table.style.animation = "couleur2 5s infinite alternate-reverse";
			header.style.WebkitAnimation = "couleur2 5s infinite alternate-reverse";
			table.style.WebkitAnimation = "couleur2 5s infinite alternate-reverse";
			break;


	}
}