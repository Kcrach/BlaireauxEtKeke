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
var nbcapes = 3;
var listecapes = [];

var nbbonusVue = 2;
var nbbonusBottes = 2;
var nbbonusCapes = 2;
var nbbonusIncognito = 3;
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

//bonus
var supervue = 0; // bool pour la super-vue

var bottesActives = 0; // bool super vitesse
var boostBottes = null; // compte à rebour vitesse
var dureeBottes = 6;
var tempsActuelBottes = 6;

var invisible = 0 // bool cape d'invisibilité
var boostInvisibilite = null // compte à rebour invisibilité
var dureeInvisibilite = 6;
var tempsActuelInvisiblite = 6;

var incognito = 0 // bool cape d'invisibilité
var boostIncognito = null // compte à rebour invisibilité
var dureeIncognito = 6;
var tempsActuelIncognito = 6;

// mode spectateur
var modespectateur = 0;
var tabCamJoueur = [];
var navigCam = 0;

function Point(x, y) {
	this.x = x;
	this.y = y;
}

function Bonus(type, objet) {
	this.type = type;
	this.objet = objet;
	this.anim = 0;
}

function init(idPartie) {
	//scene et rendu
	var scene = new THREE.Scene();
	var cam = new THREE.PerspectiveCamera(60,width/height, 0.1,1000);
	tabCamJoueur.push(cam);
	scene.fog = new THREE.Fog(0x000000,3,3.5);
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
	var solmat = new THREE.MeshPhongMaterial({color: 0x000080});
	var sol = new THREE.Mesh(plan, solmat);


		
	//Pour load les murs depuis l'ID de la partie
	objetXHRLoadMur  = new XMLHttpRequest();

	objetXHRLoadMur.open("get","../../fonctions/loadMurBD.php?idPartie="+idPartie,false);
	objetXHRLoadMur.send(null);
	
	murs = objetXHRLoadMur.responseText;

	//Parse le message de retour
	var coordMur = murs.split(' ');

	
	for(i =0; i < coordMur.length-1; i++){
		var coordX = parseInt(coordMur[i].split(',')[0],10);
		var coordZ = parseInt(coordMur[i].split(',')[1],10);

		var wall = new THREE.BoxGeometry(1,1,1);
		var wallmat = new THREE.MeshPhongMaterial({color: 0x888888});
		var mur = new THREE.Mesh(wall, wallmat);

		listemurs.push(new Point(coordX,coordZ));
		/*for(i = 0; i < listemurs.length; i++){
			console.log(listemurs[i]);
		}*/

		mur.position.set(coordX,0.5,coordZ);
		scene.add(mur);
	}
	
	//On load les flaques
	objetXHRLoadFlaques  = new XMLHttpRequest();

	objetXHRLoadFlaques.open("get","../../fonctions/loadFlaqueBD.php?idPartie="+idPartie,false);
	objetXHRLoadFlaques.send(null);
	
	flaques = objetXHRLoadFlaques.responseText;

	//Parse le message de retour
	var coordFlaque = flaques.split(' ');

	for(i =0; i < coordFlaque.length-1; i++){
		var coordX = parseInt(coordFlaque[i].split(',')[0],10);
		var coordZ = parseInt(coordFlaque[i].split(',')[1],10);

		var cylindre = new THREE.CylinderGeometry(0.5,0.5,0.001,64);
		var flaquemat = new THREE.MeshPhongMaterial({color: 0x800080});
		var flaque = new THREE.Mesh(cylindre, flaquemat);
		
		var light = new THREE.PointLight( 0x800080, 1,2);
		light.position.set(x,0.1,z);
		scene.add(light);

		listeflaques.push(new Point(coordX,coordZ));
		
		flaque.position.set(coordX,0,coordZ);
		scene.add(flaque);
	}
	
	// bonus super-vue
	for(var i=0; i<nbbonusVue ; i++) {
		var sphere1 = new THREE.SphereGeometry(0.05, 16,16);
		var sphere2 = new THREE.SphereGeometry(0.035, 16,16);
		var sphere3 = new THREE.SphereGeometry(0.02, 16,16);	

		var sphere1mat = new THREE.MeshPhongMaterial({color: 0xffffff});
		var sphere2mat = new THREE.MeshPhongMaterial({color: 0x00ff7f});
		var sphere3mat = new THREE.MeshPhongMaterial({color: 0x000000});

		var mesh1 = new THREE.Mesh(sphere1,sphere1mat);
		mesh1.position.y = 0.2;
		var mesh2 = new THREE.Mesh(sphere2,sphere2mat);
		mesh2.position.y = 0.2;
		mesh2.position.x = 0.023;
		var mesh3 = new THREE.Mesh(sphere3,sphere3mat);
		mesh3.position.y = 0.2;
		mesh3.position.x = 0.043;

		var light = new THREE.PointLight( 0x00ff7f, 1,1);
		light.position.y = 0.2;

		var oeil = new THREE.Group();
		oeil.add(mesh1);
		oeil.add(mesh2);
		oeil.add(mesh3);
		oeil.add(light);

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
				if(x == element.objet.position.x && z == element.objet.position.z){
						ok = false;
				}
			});
			
		}
		while(!ok);

		oeil.name = "supervue"+i;
		oeil.position.set(x,0,z);
		listebonus.push(new Bonus(1,oeil));
		scene.add(oeil);
	}

	// bonus bottes
	for(var i=0; i<nbbonusBottes ; i++) {
		var cylindre1 = new THREE.CylinderGeometry(0.05,0.05,0.2,32);
		var sphere = new THREE.SphereGeometry(0.05,16,16);
		var cylindre2 = new THREE.CylinderGeometry(0.05,0.05,0.1,32);

		var torus = new THREE.TorusGeometry(0.02, 0.006, 16, 100 );

		var circle1 = new THREE.CircleGeometry(0.03,16,0,7);
		var circle2 = new THREE.CircleGeometry(0.07,3,0,0.4);
		var circle3 = new THREE.CircleGeometry(0.06,3,0,0.3);
		var circle4 = new THREE.CircleGeometry(0.05,3,0,0.2);

		var mat1 = new THREE.MeshPhongMaterial({color: 0x371B07});
		var mat2 = new THREE.MeshPhongMaterial({color: 0xffffff, side: THREE.DoubleSide});
		var mat3 = new THREE.MeshPhongMaterial({color: 0xffff00});

		var mesh1 = new THREE.Mesh(cylindre1,mat1);
		mesh1.position.y = 0.4;
		var mesh2 = new THREE.Mesh(sphere,mat1);
		mesh2.position.y = 0.3;
		var mesh3 = new THREE.Mesh(cylindre2,mat1);
		mesh3.position.y = 0.3;
		mesh3.position.z = 0.05;
		mesh3.rotation.x = THREE.Math.degToRad(90);
		var mesh4 = new THREE.Mesh(sphere,mat1);
		mesh4.position.y = 0.3;
		mesh4.position.z = 0.1;

		var mesh5 = new THREE.Mesh(circle1, mat2);
		mesh5.rotation.y = THREE.Math.degToRad(90);
		mesh5.position.y = 0.3;
		mesh5.position.x = 0.05;
		var mesh6 = new THREE.Mesh(circle2, mat2);
		mesh6.rotation.y = THREE.Math.degToRad(90);
		mesh6.rotation.x = THREE.Math.degToRad(13);
		mesh6.position.z = 0.01;
		mesh6.position.y = 0.325;
		mesh6.position.x = 0.05;
		var mesh7 = new THREE.Mesh(circle3, mat2);
		mesh7.rotation.y = THREE.Math.degToRad(90);
		mesh7.rotation.x = THREE.Math.degToRad(-3);
		mesh6.position.z = 0.005;
		mesh7.position.y = 0.31;
		mesh7.position.x = 0.05;
		var mesh8 = new THREE.Mesh(circle4, mat2);
		mesh8.rotation.y = THREE.Math.degToRad(90);
		mesh8.rotation.x = THREE.Math.degToRad(-19);
		mesh8.position.y = 0.3;
		mesh8.position.x = 0.05;

		var mesh12 = new THREE.Mesh(circle1, mat2);
		mesh12.rotation.y = THREE.Math.degToRad(90);
		mesh12.position.y = 0.3;
		mesh12.position.x = -0.05;
		var mesh13 = new THREE.Mesh(circle2, mat2);
		mesh13.rotation.y = THREE.Math.degToRad(90);
		mesh13.rotation.x = THREE.Math.degToRad(13);
		mesh13.position.z = 0.01;
		mesh13.position.y = 0.325;
		mesh13.position.x = -0.05;
		var mesh14 = new THREE.Mesh(circle3, mat2);
		mesh14.rotation.y = THREE.Math.degToRad(90);
		mesh14.rotation.x = THREE.Math.degToRad(-3);
		mesh14.position.z = 0.005;
		mesh14.position.y = 0.31;
		mesh14.position.x = -0.05;
		var mesh15 = new THREE.Mesh(circle4, mat2);
		mesh15.rotation.y = THREE.Math.degToRad(90);
		mesh15.rotation.x = THREE.Math.degToRad(-19);
		mesh15.position.y = 0.3;
		mesh15.position.x = -0.05;

		var mesh9 = new THREE.Mesh(torus, mat3);
		mesh9.position.y = 0.44;
		mesh9.position.z = 0.03;
		mesh9.rotation.x = THREE.Math.degToRad(90);
		var mesh10 = new THREE.Mesh(torus, mat3);
		mesh10.position.y = 0.41;
		mesh10.position.z = 0.03;
		mesh10.rotation.x = THREE.Math.degToRad(90);
		var mesh11 = new THREE.Mesh(torus, mat3);
		mesh11.position.y = 0.38;
		mesh11.position.z = 0.03;
		mesh11.rotation.x = THREE.Math.degToRad(90);

		var light = new THREE.PointLight( 0xffffff, 1,1);
		light.position.y = 0.4;

		var botte = new THREE.Group();
		botte.add(mesh1);
		botte.add(mesh2);
		botte.add(mesh3);
		botte.add(mesh4);
		botte.add(mesh5);
		botte.add(mesh6);
		botte.add(mesh7);
		botte.add(mesh8);
		botte.add(mesh9);
		botte.add(mesh10);
		botte.add(mesh11);
		botte.add(mesh12);
		botte.add(mesh13);
		botte.add(mesh14);
		botte.add(mesh15);
		botte.add(light);

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
				if(x == element.objet.position.x && z == element.objet.position.z) {
						ok = false;
				}
			});
			
		}
		while(!ok);

		botte.name = "bottes"+i;
		botte.position.set(x,0,z);
		listebonus.push(new Bonus(2,botte));
		scene.add(botte);
	}

	// bonus capes
	for(var i=0; i<nbbonusCapes ; i++) {
		var bascape = new THREE.CylinderGeometry(0.037,0.175,0.25,12,1,true,0,4);
		var hautcape = new THREE.CylinderGeometry(0.075,0.037,0.075,12,1,true,0,4);
		var torus = new THREE.TorusGeometry(0.05, 0.007, 16, 100 );

		var material = new THREE.MeshBasicMaterial({color: 0x8B0000});
		material.transparent = true;
		material.opacity = 0.5;
		var material2 = new THREE.MeshBasicMaterial({color: 0xffff00});
		
		var cape1 = new THREE.Mesh(bascape, material);
		cape1.position.y = 0.25;
		var cape2 = new THREE.Mesh(hautcape, material);
		cape2.position.y = 0.4125;
		var tore = new THREE.Mesh(torus,material2);
		tore.position.y = 0.375;
		tore.rotation.x = THREE.Math.degToRad(90);

		var light = new THREE.PointLight(0xff0000,1,1.5);
		light.position.y = 0.3;

		var cape = new THREE.Group();
		cape.add(cape1);
		cape.add(cape2);
		cape.add(tore);
		cape.add(light);

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
				if(x == element.objet.position.x && z == element.objet.position.z) {
						ok = false;
				}
			});
			
		}
		while(!ok);

		cape.name = "cape"+i;
		cape.position.set(x,0,z);
		listebonus.push(new Bonus(3,cape));
		scene.add(cape);
	}

	// bonus incognito
	for(var i=0; i<nbbonusIncognito ; i++) {
 		var geom1 = new THREE.BoxGeometry(0.08,0.05,0.02);
 		var geom2 = new THREE.BoxGeometry(0.1,0.02,0.015);
 		var geom3 = new THREE.BoxGeometry(0.1,0.02,0.02);

 		var material = new THREE.MeshBasicMaterial({color: 0x222222}); 
 		var material2 = new THREE.MeshBasicMaterial({color: 0x333333}); 

 		var mesh1 = new THREE.Mesh(geom1,material);
 		mesh1.position.y = 0.4;
 		mesh1.position.x = -0.06;
 		mesh1.position.z = 0.09;

 		var mesh2 = new THREE.Mesh(geom1,material);
 		mesh2.position.y = 0.4;
 		mesh2.position.x = 0.06;
 		mesh2.position.z = 0.09;

 		var mesh3 = new THREE.Mesh(geom2,material2);
 		mesh3.position.y = 0.41;
 		mesh3.position.z = 0.09;

 		var mesh4 = new THREE.Mesh(geom3,material2);
 		mesh4.position.y = 0.41;
 		mesh4.position.z = 0.048;
 		mesh4.position.x = 0.088;
 		mesh4.rotation.y = THREE.Math.degToRad(90);

 		var mesh5 = new THREE.Mesh(geom3,material2);
 		mesh5.position.y = 0.41;
 		mesh5.position.z = 0.048;
 		mesh5.position.x = -0.088;
 		mesh5.rotation.y = THREE.Math.degToRad(90);

		var light = new THREE.PointLight(0x0000ff,1,1.5);
		light.position.y = 0.3;

		var inco = new THREE.Group();
		inco.add(mesh1);
		inco.add(mesh2);
		inco.add(mesh3);
		inco.add(mesh4);
		inco.add(mesh5);
		inco.add(light);

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
				if(x == element.objet.position.x && z == element.objet.position.z) {
						ok = false;
				}
			});
			
		}
		while(!ok);

		inco.name = "incognito"+i;
		inco.position.set(x,0,z);
		listebonus.push(new Bonus(4,inco));
		scene.add(inco);
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
			listebonus.forEach(function(element) {
				if(x == element.objet.position.x && z == element.objet.position.z){
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
				if(element.objet.position.y <= 0) {
					element.anim = 0;
				}
				element.objet.rotation.y += THREE.Math.degToRad(4);
			}
			if(element.type == 2) {
				if(element.anim == 0) {
					element.objet.position.y += 0.001;
				}
				else {
					element.objet.position.y -= 0.001;
				}
				if(element.objet.position.y >= 0.08) {
					element.anim = 1;
				}
				if(element.objet.position.y <= -0.1) {
					element.anim = 0;
				}
				element.objet.rotation.y += THREE.Math.degToRad(2);
			}
			if(element.type == 3) {
				if(element.anim == 0) {
					element.objet.position.y += 0.001;
				}
				else {
					element.objet.position.y -= 0.001;
				}
				if(element.objet.position.y >= 0.15) {
					element.anim = 1;
				}
				if(element.objet.position.y <= 0.05) {
					element.anim = 0;
				}
				element.objet.rotation.y += THREE.Math.degToRad(2);
			}
			if(element.type == 4) {
				if(element.anim == 0) {
					element.objet.position.y += 0.001;
				}
				else {
					element.objet.position.y -= 0.001;
				}
				if(element.objet.position.y >= 0.15) {
					element.anim = 1;
				}
				if(element.objet.position.y <= 0.05) {
					element.anim = 0;
				}
				element.objet.rotation.y += THREE.Math.degToRad(1);
			}
			
		});
		requestAnimationFrame(animBonus);
		renderer.render(scene,cam);
		switch(objetTenu){
			case 0 :
				document.getElementById("nbBonus").innerHTML = "Rien";
				break;
			case 1 :
				document.getElementById("nbBonus").innerHTML = "Super-Vue";
				break;
			case 2 :
				document.getElementById("nbBonus").innerHTML = "Bottes de vitesse ("+tempsActuelBottes+" secs)";
				break;
			case 3 :
				document.getElementById("nbBonus").innerHTML = "Cape d'invisibilité ("+tempsActuelInvisiblite+" secs)";
				break;
			case 4 :
				document.getElementById("nbBonus").innerHTML = "Incognito ("+tempsActuelIncognito+" secs)";
				break;
			default :
				document.getElementById("nbBonus").innerHTML = "Objet inconnu";
				break;
		}
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
			checkBonus();
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
		if(ok && objetTenu==0) {
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
					nbbonusBottes -= 1;
					break;
				case 3:
					nbbonusCapes -= 1;
					break;	
				case 4:
					nbbonusIncognito -= 1;
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
				scene.fog = null;
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
				scene.fog = new THREE.Fog(0x000000,3,3.5);
				cam.position.y = 0.5;
				cam.rotation.z = THREE.Math.degToRad(0);
				cam.rotation.x = THREE.Math.degToRad(0);
				cam.rotation.y = THREE.Math.degToRad(90 - (90*direction));
				objetTenu = 0;
			}
		}

		// bottes de vitesse
		if(objetTenu == 2) {
			if(bottesActives==0){
				bottesActives = 1;
				tempsActuelBottes = dureeBottes;
				vitDep = 0.2;
				boostBottes = setInterval(boostVitesse, 1000);
			}
		}

		// invisibilité
		if(objetTenu == 3) {
			if(invisible==0){
				invisible = 1;
				tempsActuelInvisiblite = dureeInvisibilite;
				cube.visible = false;
				boostInvisibilite = setInterval(modeInvisible, 1000);
			}
		}

		// incognito
		if(objetTenu == 4) {
			if(incognito==0){
				incognito = 1;
				cube.material.color.setHex(0x808080);
				tempsActuelIncognito = dureeIncognito;
				boostIncognito = setInterval(modeIncognito, 1000);
			}
		}
	}

	function boostVitesse() {
		tempsActuelBottes--;
		if(tempsActuelBottes <= 0) {
			clearInterval(boostBottes);
			boostBottes = null;
			vitDep = 0.1;
			objetTenu = 0;
			bottesActives = 0;
			tempsActuelBottes = dureeBottes;
			document.getElementById("nbBonus").innerHTML = "Rien";
		}
	}

	function modeInvisible() {
		tempsActuelInvisiblite--;
		if(tempsActuelInvisiblite <= 0) {
			clearInterval(boostInvisibilite);
			cube.visible = true;
			boostInvisibilite = null;
			objetTenu = 0;
			invisible = 0;
			tempsActuelInvisiblite = dureeInvisibilite;
			document.getElementById("nbBonus").innerHTML = "Rien";
		}
	} 

	function modeIncognito() {
		tempsActuelIncognito--;
		if(tempsActuelIncognito <= 0) {
			clearInterval(boostIncognito);
			if(equipe == 0) {
				cube.material.color.setHex(0xaa0000);	
			}
			else {
				cube.material.color.setHex(0xaaaa00);
			}
			boostIncognito = null;
			objetTenu = 0;
			incognito = 0;
			tempsActuelIncognito = dureeIncognito;
			document.getElementById("nbBonus").innerHTML = "Rien";
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
		if(!moving && !rot && modespectateur==0) {
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
					}
					break;
				case "ArrowRight":
					if(supervue!=1) {
						rotDir = 1;
						rotate();
					}
					break;
				// TEST du mode spectateur
				case "Space":
					spectate();
					break;
			}
		}
		else {
			if(modespectateur == 1) {
				switch(e.code) {
					case "ArrowUp":
						if(cam.position.z >= 1)cam.position.z -= 1;
						break;
					case "ArrowDown":
						if(cam.position.z < mapHeight-0.5) cam.position.z += 1;
						break;
					case "ArrowLeft":
						if(cam.position.x >= 1) cam.position.x -= 1;
						break;
					case "ArrowRight":
						if(cam.position.x < mapWidth-0.5) cam.position.x += 1;
						break;
				}	
			}
			if(modespectateur >= 1) {
				switch(e.code) {
					case "Space":
						spectate();
						break;
					case "KeyQ": // A
						specJoueur(-1);
						break;
					case "KeyW": // Z
						specJoueur(1);
						break;
				}
			}
		}
	}

	var camStockee = null;
	var speccam = new THREE.PerspectiveCamera(60,width/height, 0.1,1000);

	// 2e camera pour simuler un autre joueur
	var cam2 = new THREE.PerspectiveCamera(60,width/height, 0.1,1000);
	cam2.position.set(0,0.5,0);
	cam2.rotation.y = THREE.Math.degToRad(90 - (90*3));
	tabCamJoueur.push(cam2);
	scene.add(cam2);

	// 3e camera pour simuler un autre joueur
	var cam3 = new THREE.PerspectiveCamera(60,width/height, 0.1,1000);
	cam3.position.set(0,0.5,3);
	cam3.rotation.y = THREE.Math.degToRad(90 - (90*3));
	tabCamJoueur.push(cam3);
	scene.add(cam3);


	function spectate() {
		// mise en mode spectateur

		// uniquement pour joueur ayant perdu ou exterieur à la partie
		switch(modespectateur) {

			case 0: // passage en camera libre
				modespectateur = 1;
				camStockee = cam;
				cam = speccam;

				cam.position.y = 9;
				cam.position.x = roundNumber(mapWidth/2,1);
				cam.position.z = roundNumber(mapHeight/2,1);
				cam.rotation.z = THREE.Math.degToRad(0);
				cam.rotation.x = THREE.Math.degToRad(0);
				cam.rotation.y = THREE.Math.degToRad(90 - (90*direction));
				// vue aerienne de la map
				switch(direction) {
					case 0:
						cam.rotation.y -= THREE.Math.degToRad(90);
						cam.rotation.x = THREE.Math.degToRad(-90);
						break;
					case 1:
						cam.rotation.x = THREE.Math.degToRad(-90);

						break;
					case 2:
						cam.rotation.y += THREE.Math.degToRad(90);
						cam.rotation.x = THREE.Math.degToRad(-90);
						break;
					case 3:
						cam.rotation.y -= THREE.Math.degToRad(180);
						cam.rotation.x = THREE.Math.degToRad(-90);
						break;
				}
				scene.fog = null;
				break;

			case 1: // annule mode spectateur
				modespectateur = 0;
				cam.rotation.z = THREE.Math.degToRad(0);
				cam.rotation.x = THREE.Math.degToRad(0);
				cam.rotation.y = THREE.Math.degToRad(90 - (90*direction));
				cam = camStockee;
				camStockee = null;	
				cam.position.y = 0.5;
				scene.fog = new THREE.Fog(0x000000,3,3.5);	
				break;

			case 2: // camera de joueur vers camera libre
				modespectateur = 0;
				cam = camStockee;
				spectate();
				break;
		}
	}

	// fonction pour switch entre les joueurs en mode spectateur
	function specJoueur(x) {
		// x = 1 ou -1, pour naviguer dans le tableau
		if(modespectateur==2) navigCam = mod(navigCam-x,tabCamJoueur.length);
		modespectateur = 2;
		cam = tabCamJoueur[navigCam];
		scene.fog = new THREE.Fog(0x000000,3,3.5);	
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


	
//Compte à Rebours
	var termine = false;
	
	compteArebours();
	
	var dureeGong = 5; // à ajuster
	var temps = dureeGong;
	var intervalId = null;

	var equipe = 0;
	document.getElementById("spanEquipe").innerHTML = "TEAM BLAIREAUX";

	function compteArebours(){
		intervalId = setInterval(bip, 1000);
	}	
	function bip() {
		if(!termine){
			temps--;
			if(temps == 0){
				gong();
				temps = dureeGong;
			}
			else {	
				document.getElementById("chronoSecondes").innerHTML = temps;
			}
		}
		else
			document.getElementById("chronoSecondes").innerHTML = "Partie terminée";
	}	
	function gong(){
		clearInterval(intervalId);
		document.getElementById("chronoSecondes").innerHTML = "GONG!";
		if(equipe == 0) {
			equipe = 1;
			document.getElementById("spanEquipe").innerHTML = "TEAM KEKE";
			if(incognito!=1) {
				cube.material.color.setHex(0xaaaa00);
			}	
		}
		else {
			equipe = 0;
			document.getElementById("spanEquipe").innerHTML = "TEAM BLAIREAUX";
			if(incognito!=1) {
				cube.material.color.setHex(0xaa0000);	
			}
		}
	}
	
//Temps limite de la partie
	dureePartie();
	
	var dureeMaxPartie = 12;
	var tempsRestant = dureeMaxPartie;
	var decomptePartie = null;
	
	function dureePartie(){
		decomptePartie = setInterval(decompte, 1000);
	}	
	function decompte(){
		if(tempsRestant>0)
			tempsRestant--;
		if(tempsRestant == 0){
			finPartie();
		}
		else {	
			document.getElementById("tempsPartie").innerHTML = tempsRestant;
		}	
	}
	function finPartie(){
		clearInterval(decomptePartie);
		termine = true;
		document.getElementById("tempsPartie").innerHTML = "TERMINE";
		//Il faudra que le jeu s'arrete et verification des conditions de victoires, là seul le gong est annulé
	}
}
