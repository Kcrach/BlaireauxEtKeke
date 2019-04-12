function genererMapRandom(largeur,  longueur,  nbFlaque){
	// 0 = sol
	// 1 = mur
	// 2 = flaque
	// 3/4/5/6/etc.. = bonus 

	//Création de la matrice
	var matrice = new Array();

	//Matrice 2D et initialisation 
	for(var i =0; i < largeur; i++){
		matrice[i] = new Array();
		for(var j = 0 ; j < longueur; j++){
			matrice[i][j]=0;
		}
	}

	//Mise en place des murs

	//On prend 50 case random dans la matrice
	for(var k = 0; k < (largeur*longueur)/2; k++){
		randLarg = getRandomInt(largeur-1);
		randLong = getRandomInt(longueur-1);
		matrice[randLarg][randLong]=1;
	}

	//On supprime tout les murs sans entourages
	for(var i =0; i < largeur; i++){
		for(var j =0; j < longueur; j++){
			if(matrice[i][j]==1){
				garder = false;
				if(i==0 && j == 0 ){
					if(matrice[i+1][j] ==1 || matrice[i][j+1] == 1){
						garder=true;
					}
				}
				else if(i==0 && j == (longueur-1) ){
					if(matrice[i+1][j] ==1 || matrice[i][j-1] == 1){
						garder=true;
					}
				}
				else if(i== (largeur-1) && j == 0 ){
					if(matrice[i-1][j] ==1 || matrice[i][j+1] == 1){
						garder=true;
					}
				}
				else if(i== (largeur-1) && j == (longueur-1) ){
					if(matrice[i-1][j] ==1 || matrice[i][j-1] == 1){
						garder=true;
					}
				}
				else if(i==0){
					if( matrice[i+1][j] ==1 || matrice[i][j-1] ==1 || matrice[i][j+1] == 1){
						garder=true;
					}
				}
				else if(i==(largeur-1)){
					if( matrice[i-1][j] ==1 || matrice[i][j-1] ==1 || matrice[i][j+1] == 1){
						garder=true;
					}
				}
				else if(j==0){
					if(matrice[i-1][j]==1 || matrice[i+1][j] ==1 || matrice[i][j+1] == 1){
						garder=true;
					}
				}
				else if(j==(longueur-1)){
					if(matrice[i-1][j]==1 || matrice[i+1][j] ==1 || matrice[i][j-1] == 1){
						garder=true;
					}
				}
				else{
					if(matrice[i-1][j]==1 || matrice[i+1][j] ==1 || matrice[i][j-1] ==1 || matrice[i][j+1] == 1){
						garder=true;
					}
				}
				if(garder == false){
					matrice[i][j]=0;
				}
			}
		}
	}

	//On s'assure qu'aucune ligne ou colonne soit un mur complet
	for(var i = 0; i < largeur;i++){
		rand = getRandomInt(longueur-1);
		matrice[i][rand] = 0;
	}

	for(var i = 0; i < longueur;i++){
		rand = getRandomInt(longueur-1);
		matrice[rand][i] = 0;
	}

	//On met les flaques (évite que 2 flaques soit trop proche)
	for(var i = 0; i < nbFlaque; i++){		
		voisinage = longueur/5;
		randLarg = getRandomInt(largeur-voisinage-1)+voisinage;
		randLong = getRandomInt(longueur-voisinage-1)+voisinage;
		if(matrice[randLarg][randLong]==0){
			mettreFlaque = true;
			for(var j=0;j<voisinage;j++){
				if(matrice[randLarg-j][randLong] == 2 || matrice[randLarg+j][randLong] == 2 || matrice[randLarg][randLong-j] == 2 || matrice[randLarg][randLong+j] == 2 || matrice[randLarg+j][randLong+j] == 2 || matrice[randLarg+j][randLong-j] == 2 || matrice[randLarg-j][randLong+j] == 2|| matrice[randLarg-j][randLong-j] == 2){
					mettreFlaque = false;
				}
			}
			if(mettreFlaque == true){
				matrice[randLarg][randLong]=2;
			}
			else{nbFlaque++;}
		}
		else{
			nbFlaque++;
		}
	}

	console.log(matrice);
}

genererMapRandom(10,10,3);

function getRandomInt(max) {
  return Math.floor(Math.random() * Math.floor(max));
}