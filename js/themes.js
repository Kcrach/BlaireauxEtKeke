function switchTheme(index){
	var body = document.body;
	var header = document.getElementById("header");
	var table = document.getElementById("table");
	switch (index){
		case 0 :
			body.style.backgroundColor = "#172935";
			header.style.backgroundImage = 'linear-gradient(to top, #172935, #0498A2 80%)';
			table.style.backgroundImage = 'linear-gradient(to top, #172935, #0498A2 25%)';
			break;

		case 1 :
			body.style.backgroundColor = "#cc0000";
			header.style.backgroundImage = 'linear-gradient(to top, #cc0000, #ff4d4d 80%)';
			table.style.backgroundImage = 'linear-gradient(to top, #cc0000, #ff4d4d 25%)';
			break;

		case 2 :
			body.style.backgroundColor = "#595959";
			header.style.backgroundImage = 'linear-gradient(to top, #595959, #bfbfbf 80%)';
			table.style.backgroundImage = 'linear-gradient(to top, #595959, #bfbfbf 25%)';
			break;


	}
}