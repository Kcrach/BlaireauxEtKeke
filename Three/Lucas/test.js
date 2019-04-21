var width = 1000;
var height = 700;

var mapWidth = 7;
var mapHeight = 7;

var vitDep = 0.1;
var vitRot = 9;

var nbmurs = 5;
var listemurs = [];
var nbflaques = 2;
var listeflaques = [];

var nbbonusVue = 3;
var listebonus = [];

// objet tenu, 0 = pas d'objet, 1 = super-vue, ...
var objetTenu = 0;

// définit si il y a un obstacle en face du joueur ou non
var blocked = false;

/*
Directions :
	GAUCHE = 0
	HAUT = 1
	DROITE = 2
	BAS = 3
*/
var direction = 0; // direction regardée
var rotDir = 0; // 0, rotation à gauche, 1=rotation à droite

// bool pour arrêt des animations
var moving = false;
var rot = false; 
// compteur pour les animations
var moveCpt = 0;
var rotCpt = 0; 

var supervue = 0; // bool pour la super-vue

function Point(x, y) {
	this.x = x;
	this.y = y;
}

function Bonus(type, objet) {
	this.type = type;
	this.objet = objet;
	this.anim = 0;
}

function init() {
	//scene et rendu
	var scene = new THREE.Scene();
	var cam = new THREE.PerspectiveCamera(45,width/height, 0.1,1000);
	var renderer = new THREE.WebGLRenderer();
	renderer.setSize(width,height);

	document.body.appendChild(renderer.domElement);

	//lumieres
	var ambient = new THREE.AmbientLight({color: 0xffffff});
	var dlight = new THREE.DirectionalLight({color: 0xffffff});
	dlight.position.set(8, 15, 13);

	/* objets */
	// joueur
	var geometry = new THREE.BoxGeometry(0.8,0.8,0.8);
	var material = new THREE.MeshPhongMaterial({color: 0xaa0000});
	var cube = new THREE.Mesh(geometry, material);
	
	// sol
	var plan = new THREE.BoxGeometry(mapWidth,1,mapHeight);
	var solmat = new THREE.MeshPhongMaterial({color: 0x0000aa});
	var sol = new THREE.Mesh(plan, solmat);
	
	// tous les murs, aleatoirement mais pas aux limites de la map
	for(var i=0; i<nbmurs ; i++) {
		var wall = new THREE.BoxGeometry(1,1,1);
		var wallmat = new THREE.MeshPhongMaterial({color: 0x888888});
		var mur = new THREE.Mesh(wall, wallmat);
		
		do {
			var ok = true;
			var x = Math.floor(Math.random() * Math.floor(mapWidth-2)) +1;
			var z = Math.floor(Math.random() * Math.floor(mapHeight-2)) +1;	
			listemurs.forEach(function(element) {
				if(x == element.x && z == element.y) {
					ok = false;
				}
			});
		}
		while(!ok);
		
		listemurs.push(new Point(x,z));
		
		mur.position.set(x,0.5,z);
		scene.add(mur);
	}
	
	// flaques magiques
	for(var i=0; i<nbflaques ; i++) {
		var cylindre = new THREE.CylinderGeometry(0.5,0.5,0.001,20,32);
		var flaquemat = new THREE.MeshPhongMaterial({color: 0x00aa00});
		var flaque = new THREE.Mesh(cylindre, flaquemat);
		
		do {
			var ok = true;
			var x = Math.floor(Math.random() * Math.floor(mapWidth));
			var z = Math.floor(Math.random() * Math.floor(mapHeight));
			
			listeflaques.forEach(function(element) {
				if(x == element.x && z == element.y) {
						ok = false;
				}
			});
			listemurs.forEach(function(element) {
				if(x == element.x && z == element.y) {
						ok = false;
				}
			});
			
		}
		while(!ok);
		
		listeflaques.push(new Point(x,z));
		
		flaque.position.set(x,0,z);
		scene.add(flaque);
	}
	
	// bonus super-vue
	for(var i=0; i<nbbonusVue ; i++) {
		var sphere = new THREE.SphereGeometry(0.05, 8,8);
		var bonusmat = new THREE.MeshPhongMaterial({color: 0xffffff});
		var bonus = new THREE.Mesh(sphere, bonusmat);
		
		do {
			var ok = true;
			var x = Math.floor(Math.random() * Math.floor(mapWidth));
			var z = Math.floor(Math.random() * Math.floor(mapHeight));
			
			listeflaques.forEach(function(element) {
				if(x == element.x && z == element.y) {
						ok = false;
				}
			});
			listemurs.forEach(function(element) {
				if(x == element.x && z == element.y) {
						ok = false;
				}
			});
			listebonus.forEach(function(element) {
				if(x == element.x && z == element.y) {
						ok = false;
				}
			});
			
		}
		while(!ok);

		bonus.name = "supervue"+i;
		bonus.position.set(x,0.3,z);
		listebonus.push(new Bonus(1,bonus));
		scene.add(bonus);
	}

	//ajouts et positionnements
	scene.add(sol);
	
	scene.add(ambient);
	scene.add(dlight);
	
	sol.position.y = -0.5;
	cube.position.y = 0.5;
	sol.position.x = mapWidth / 2 - 0.5;
	sol.position.z = mapHeight / 2 - 0.5;
	
	randomPosition();
		
		
	renderer.render(scene,cam);
	animate();
	animBonus();
	
	// position aléatoire sur le plateau
	function randomPosition() {
		do {
			var ok = true;
			var x = Math.floor(Math.random() * Math.floor(mapWidth));
			var z = Math.floor(Math.random() * Math.floor(mapHeight));
			listemurs.forEach(function(element) {
				if(x == element.x && z == element.y) {
					ok = false;
				}
			});
		} while(!ok);
		
		cube.position.x = x;
		cube.position.z = z;
		scene.add(cube);

		direction = Math.floor(Math.random() * Math.floor(4));
		
		// réglages cam
		cam.position.y = 0.5;
		cam.position.x = x;
		cam.position.z = z;
		cam.rotation.y = THREE.Math.degToRad(90 - (90*direction));
		
		debugDir();
		console.log("Position :"); console.log(cube.position);
		console.log("\n");
		checkCol();
	}	
	
	function animate(){
		requestAnimationFrame(animate);
		renderer.render(scene,cam);
	}

	function animBonus() {
		listebonus.forEach(function(element) {
			if(element.type == 1) {
				if(element.anim == 0) {
					element.objet.position.y += 0.005;
				}
				else {
					element.objet.position.y -= 0.005;
				}
				if(element.objet.position.y >= 0.45) {
					element.anim = 1;
				}
				if(element.objet.position.y <= 0.3) {
					element.anim = 0;
				}
			}
		});
		requestAnimationFrame(animBonus);
		renderer.render(scene,cam);
	}

	// déplacement
	function move() {
		moving = true;
		if(direction == 0) {
			if(cube.position.x <= 0) {
				cube.position.x = mapWidth;
				cam.position.x  = mapWidth; 
			}
			cube.position.x -= vitDep;
			cam.position.x -= vitDep;
		}
		else if(direction == 1) {
			if(cube.position.z <= 0) {
				cube.position.z = mapHeight;
				cam.position.z  = mapHeight; 
			}
			cube.position.z -= vitDep;
			cam.position.z -= vitDep;
		}
		else if(direction == 2) {
			if(cube.position.x >= mapWidth - 1) {
				cube.position.x = -1;
				cam.position.x  = -1; 
			}
			cube.position.x += vitDep;
			cam.position.x += vitDep;
		}
		else if(direction == 3) {
			if(cube.position.z >= mapHeight - 1) {
				cube.position.z = -1;
				cam.position.z  = -1; 
			}
			cube.position.z += vitDep;
			cam.position.z += vitDep;
		}
		
		moveCpt += vitDep;
		
		// corrige pb de precision
		moveCpt = roundNumber(moveCpt,1);
		cube.position.x = roundNumber(cube.position.x,1);
		cube.position.z = roundNumber(cube.position.z,1);
		cam.position.x = roundNumber(cam.position.x,1);
		cam.position.z = roundNumber(cam.position.z,1);
		
		if(moveCpt >= 1) {
			moving = false;
			moveCpt = 0;
			console.log(cube.position);
			console.log("\n");
			
			checkTeleportFlaque();
			checkCol();
			checkBonus()
		}
		else requestAnimationFrame(move);			
	}
	
	// pour changement de direction
	function rotate() {
		rot = true;
		if(rotDir == 0) {
			rotCpt += THREE.Math.degToRad(vitRot);
			cube.rotation.y += THREE.Math.degToRad(vitRot);
			cam.rotation.y += THREE.Math.degToRad(vitRot);
		}
		else {
			rotCpt += THREE.Math.degToRad(vitRot);
			cube.rotation.y -= THREE.Math.degToRad(vitRot);
			cam.rotation.y -= THREE.Math.degToRad(vitRot);
		}
		
		if(rotCpt >= THREE.Math.degToRad(90)) {
			if(rotDir == 0) direction = mod(direction-1,4);
			else direction = mod(direction+1,4);
			debugDir();
			rot = false;
			rotCpt = 0;
			
			checkCol();
		}
		else requestAnimationFrame(rotate);			
	}
	
	// met à jour le booléen blocked 
	// en fonction de la présence ou non d'un mur face au joueur
	function checkCol() {
		var p = new Point();
		switch(direction) {
			case 0:
				p.x = cube.position.x - 1;
				p.y = cube.position.y;
				p.z = cube.position.z; 
				break;
			case 1:
				p.x = cube.position.x;
				p.y = cube.position.y;
				p.z = cube.position.z - 1; 
				break;
			case 2:
				p.x = cube.position.x + 1;
				p.y = cube.position.y;
				p.z = cube.position.z; 
				break;
			case 3:
				p.x = cube.position.x;
				p.y = cube.position.y;
				p.z = cube.position.z + 1; 
				break;
		}
		
		blocked = false;
		listemurs.forEach(function(element) {
			if(p.x == element.x && p.z == element.y) {
				blocked = true;
			}
		});
	}
	
	// vérifie si l'on marche sur une flaque, téléporte si besoin
	function checkTeleportFlaque() {
		var ok = false;
		var e;
		listeflaques.forEach(function(element) {
			if(cube.position.x == element.x && cube.position.z == element.y) {
				ok = true;
				e = element;
			}
		});
		if(ok) {
			do {
				var random = Math.floor(Math.random() * Math.floor(nbflaques));
				var f = listeflaques[random];
			}
			while(f == e);
			
			cube.position.x = f.x;
			cube.position.z = f.y;
			cam.position.x = f.x;
			cam.position.z = f.y;
		}
	}

	// vérifie si l'on marche sur un objet, l'ajoute si oui
	function checkBonus() {
		var ok = false;
		var e;
		listebonus.forEach(function(element) {
			if(cube.position.x == element.objet.position.x && cube.position.z == element.objet.position.z) {
				ok = true;
				e = element;
			}
		});
		if(ok) {
			// ramasse objet, supprime de la map
			objetTenu = e.type;
			scene.remove(e.objet);

			for(var i = 0; i < listebonus.length; i++){ 
				if(listebonus[i].objet.name == e.objet.name) {
			    	listebonus.splice(i, 1); 
			   	}
			}
			switch(e.type) {
				case 1:
					nbbonusVue -= 1;
					break;
				case 2:
					// decrementer autre compteur
					break;
			}
		}
	}

	function utiliserBonus() {
		//action super-vue
		if(objetTenu == 1) {
			if(supervue == 0) {
				// active super-vue
				supervue = 1;
				cam.position.y = 9;
				switch(direction) {
					case 0:
						cam.rotation.y -= THREE.Math.degToRad(90);
						cam.rotation.x = THREE.Math.degToRad(-90);
						cam.rotation.z = THREE.Math.degToRad(90);
						break;
					case 1:
						cam.rotation.x = THREE.Math.degToRad(-90);
						break;
					case 2:
						cam.rotation.y += THREE.Math.degToRad(90);
						cam.rotation.x = THREE.Math.degToRad(-90);
						cam.rotation.z = THREE.Math.degToRad(-90);
						break;
					case 3:
						cam.rotation.x = THREE.Math.degToRad(90);
						break;
				}
			}
			else {
				// annule super-vue
				supervue = 0;
				cam.position.y = 0.5;
				cam.rotation.z = THREE.Math.degToRad(0);
				cam.rotation.x = THREE.Math.degToRad(0);
				cam.rotation.y = THREE.Math.degToRad(90 - (90*direction));
				objetTenu = 0;
			}
		}

		// action autre objet
		if(objetTenu == 2) {
			

		}
		
	}
	
	// modulo fonctionnant sur les negatifs
	function mod(n, m) {
		var reste = n % m;
		return Math.floor(reste >= 0 ? reste : reste + m);
	};
	
	// fonction corrigeant le pb de precision des flottants
	function roundNumber(number, decimals) {
		var newnumber = new Number(number+'').toFixed(parseInt(decimals));
		return parseFloat(newnumber); 
	}
	
	// écouteur clavier
	document.addEventListener("keydown", keyPressed);
	function keyPressed(e){
		// on vérifie qu'une animation ne soit pas déjà en cours
		if(!moving && !rot) {
			switch(e.code) {
				case "ArrowUp":
					if(!blocked && supervue!=1) {
						console.log("Nouveau déplacement");
						console.log(cube.position);
						move();
					}
					break;
				case "ArrowDown":
					utiliserBonus();
					break;
				case "ArrowLeft":
					if(supervue!=1) {
						rotDir = 0;
						rotate();
						break;
					}
				case "ArrowRight":
					if(supervue!=1) {
						rotDir = 1;
						rotate();
						break;
					}
			}
		}
	}
	
	function debugDir() {
		if(direction == 0) {
			console.log("Direction : "+direction+" (GAUCHE)");
		}
		else if(direction == 1) {
			console.log("Direction : "+direction+" (HAUT)");
		}
		else if(direction == 2) {
			console.log("Direction : "+direction+" (DROITE)");
		}
		else if(direction == 3) {
			console.log("Direction : "+direction+" (BAS)");
		}
	}

}

//Compte à Rebours
	var temps = 30;
	var intervalId = null;
	function compteArebours(){
		intervalId = setInterval(bip, 1000);
	}	
	function bip() {
		temps--;
		if(temps == 0){
			gong();
			temps=30;
			compteArebours();
		}
		else {	
			document.getElementById("chronoSecondes").innerHTML = temps;
		}	
	}	
	function gong(){
		clearInterval(intervalId);
		document.getElementById("chronoSecondes").innerHTML = "GONG!";
	}
