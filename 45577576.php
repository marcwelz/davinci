<?php
session_start();
if($_SESSION["UserPage"] == 5) {
    $_SESSION["UserPage"] = 6;
} if($_SESSION["UserPage"] < 6) {
    header('Location: Mission' . $_SESSION["UserPage"] . '.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style>
html, body {
    margin: 0;
  overflow: hidden;
}
canvas {
	background-image: url("street2.PNG");
	background-size: cover;
	height: 100%;
}
</style>
</head>
<body onload="startGame()">
<img src="cop1.png" id="cop1" >
<img src="cop2.png" id="cop2" >
<img src="cop3.png" id="cop3" >
<img src="cop2.png" id="cop4" >
<img src="cop2.png" id="cop5" >
<img src="cop1.png" id="cop6" >
<img src="cop3.png" id="cop7" >
<img src="cop1.png" id="cop8" >
<script>

var myGamePiece; 

var zahler = 0;

var x = 10, y = 100;

var zahl = 3;
var position_x =200;
var position_y =200;

var direction =3;

var gameover = false;

var lastLoop = new Date();
var ki = true;
var screenHeight = window.innerHeight;
var screenWidth = window.innerWidth;
var img;

var x0 = 1;
var x1 = 120;
var x2 = 300;
var x3 = 465;
var x4 = 610;
var x5 = 800;
var x6 = 960;
var x7 = 1100;
var x8 = 1350;
var x9 = 1460;
var x10 = 1600;
var x11 = 1800;

var y1 = 420;

var xPositionCar = x3;
var yPositionCar = y1;
var wPositionCar;
var hPositionCar;

var yCop1 = 0;
var yPositionCop1 = 0;
var xPositionCop1 = 135;

var yCop2 = 0;
var yPositionCop2 = 860;
var xPositionCop2 = 300;

var yCop3 = 0;
var yPositionCop3 = 0;
var xPositionCop3 = 610;

var yCop4 = 0;
var yPositionCop4 = 860;
var xPositionCop4 = 800;

var yCop5 = 0;
var yPositionCop5 = 0;
var xPositionCop5 = 1100;

var yCop6 = 0;
var yPositionCop6 = 860;
var xPositionCop6 = 1250;



var yCop7 = 0;
var yPositionCop7 = 0;
var xPositionCop7 = 1600;

var yCop8 = 0;
var yPositionCop8 = 860;
var xPositionCop8 = 1650;

var hCop = 182;
var wCop = 123;

var xPerson = 1;
var yPerson = 420;
var hPerson = 182;
var wPerson = 123;


function startGame() {
	if(gameover == false){
	myGamePiece = new component(123, 182, "vonLinks.png", x0, y1, "image");
	}
	var cop1 = document.getElementById("cop1");
	var cop2 = document.getElementById("cop2");
	var cop3 = document.getElementById("cop3");
	var cop4 = document.getElementById("cop4");
	var cop5 = document.getElementById("cop5");
	var cop6 = document.getElementById("cop6");
	var cop7 = document.getElementById("cop7");
	var cop8 = document.getElementById("cop8");
	
    myGameArea.start();
}

var myGameArea = {
    canvas : document.createElement("canvas"),
    start : function() {
        this.canvas.width =window.innerWidth;
        this.canvas.height = window.innerHeight;
        
        this.context = this.canvas.getContext("2d");
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
        this.frameNo = 0;
        this.interval = setInterval(updateGameArea, 16);

        window.addEventListener('keydown', function (e) {
            e.preventDefault();
			zahl = 4;
            myGameArea.keys = (myGameArea.keys || []);
            myGameArea.keys[e.keyCode] = (e.type == "keydown");
        })
        window.addEventListener('keyup', function (e) {
			clearmove();
			zahl = 4;
            myGameArea.keys[e.keyCode] = (e.type == "keydown");
        })

    },

    clear : function() {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    },
    stop : function() {
        clearInterval(this.interval);
    }
}


function component(width, height, color, x, y, type) {
    this.type = type;
	
    if (type == "image") {
        this.image = new Image();
        this.image.src = color;
    }
    this.width = width;
    this.height = height;
    this.speedX = 0;
    this.speedY = 0;    
    this.x = x;
    this.y = y;    
    this.update = function() {
    ctx = myGameArea.context;
	
	
	yPositionCar = this.y;
	wPositionCar = this.width;
	hPositionCar = this.height;
	
	draw();
        if (type == "image") {
            ctx.drawImage(this.image, 
                this.x, 
                this.y,
                this.width, this.height);
        } else {
            ctx.fillStyle = color;
            ctx.fillRect(this.x, this.y, this.width, this.height);
			
        }
    }
    this.newPos = function() {
        this.x = xPerson;
        this.y = y;     
    }	
}

function collissionDetection(xPlayer, yPlayer, wPlayer, hPlayer
		, xObject, yObject, wObject, hObject) {
	
	if(xPlayer < xObject + wObject && xPlayer + wPlayer > xObject && yPlayer < yObject + hObject && yPlayer + hPlayer > yObject) {
		return true;
	} else {
		return false;
	}
	
}

function draw() {
	ctx = myGameArea.context;
	
	if(ki == true) {
		ctx.font = "bold 35px Consolas";
	}
	
	if(gameover == false){

	
	ctx.drawImage(cop1, xPositionCop1, yPositionCop1, 123, 182)
	ctx.drawImage(cop2, xPositionCop2, yPositionCop2, 123, 182)
	ctx.drawImage(cop3, xPositionCop3, yPositionCop3, 123, 182)
	ctx.drawImage(cop4, xPositionCop4, yPositionCop4, 123, 182)
	ctx.drawImage(cop5, xPositionCop5, yPositionCop5, 123, 182)
	ctx.drawImage(cop6, xPositionCop6, yPositionCop6, 123, 182)
	ctx.drawImage(cop7, xPositionCop7, yPositionCop7, 123, 182)
	ctx.drawImage(cop8, xPositionCop8, yPositionCop8, 123, 182)
	
	}
	
	
	//Cop 1
	if(yCop1 == 0){
	yPositionCop1+= 7;
	}
	
	if(yCop1 == 1){
	yPositionCop1-= 7;
	}
	
	if(yPositionCop1>=900){
	yPositionCop1 = 860;
	yCop1 = 1;
	}
	
	
	if(yPositionCop1<=1 && yCop1 == 1){
	yPositionCop1 = 0
	yCop1 = 0;
	}
	
	//Cop 2
	if(yCop2 == 0){
	yPositionCop2+= 10;
	}
	
	if(yCop2 == 1){
	yPositionCop2-= 10;
	}
	
	if(yPositionCop2>=900){
	yPositionCop2 = 860;
	yCop2 = 1;
	}
	
	if(yPositionCop2<=1 && yCop2 == 1){
	yPositionCop2 = 0
	yCop2 = 0;
	}
	
	
	//Cop 3
	if(yCop3 == 0){
	yPositionCop3+= 10;
	}
	
	if(yCop3 == 1){
	yPositionCop3-= 11;
	}
	
	if(yPositionCop3>=900){
	yPositionCop3 = 860;
	yCop3 = 1;
	}
	
	if(yPositionCop3<=1 && yCop3 == 1){
	yPositionCop3 = 0
	yCop3 = 0;
	}
	
	//Cop 4
	if(yCop4 == 0){
	yPositionCop4+= 5;
	}
	
	if(yCop4 == 1){
	yPositionCop4-= 15;
	}
	
	if(yPositionCop4>=900){
	yPositionCop4 = 860;
	yCop4 = 1;
	}
	
	if(yPositionCop4<=1 && yCop4 == 1){
	yPositionCop4 = 0
	yCop4 = 0;
	}
	
	//Cop 5
	if(yCop5 == 0){
	yPositionCop5+= 12;
	}
	
	if(yCop5 == 1){
	yPositionCop5-= 8;
	}
	
	if(yPositionCop5>=900){
	yPositionCop5 = 860;
	yCop5 = 1;
	}
	
	if(yPositionCop5<=1 && yCop5 == 1){
	yPositionCop5 = 0
	yCop5 = 0;
	}
	
	
	//Cop 6
	if(yCop6 == 0){
	yPositionCop6+= 12;
	}
	
	if(yCop6 == 1){
	yPositionCop6-= 8;
	}
	
	if(yPositionCop6>=900){
	yPositionCop6 = 860;
	yCop6 = 1;
	}
	
	if(yPositionCop6<=1 && yCop6 == 1){
	yPositionCop6 = 0;
	yCop6 = 0;
	}
	
	
	//Cop 7
	if(yCop7 == 0){
	yPositionCop7+= 20;
	}
	
	if(yCop7 == 1){
	yPositionCop7-= 20;
	}
	
	if(yPositionCop7>=900){
	yPositionCop7 = 860;
	yCop7 = 1;
	}
	
	if(yPositionCop7<=1 && yCop7 == 1){
	yPositionCop7 = 0;
	yCop7 = 0;
	}
	
	
	//Cop 8
	if(yCop8 == 0){
	yPositionCop8+= 2;
	}
	
	if(yCop8 == 1){
	yPositionCop8-= 2;
	}
	
	if(yPositionCop8>=900){
	yPositionCop8 = 860;
	yCop8 = 1;
	}
	
	if(yPositionCop8<=1 && yCop8 == 1){
	yPositionCop8 = 0;
	yCop8 = 0;
	}



	
}

function getDistanceCircles(x1, y1, x2, y2){
	let xDistance = x2-x1;
	let yDistance = y2-y1;
	
	return Math.sqrt(Math.pow(xDistance, 2) + Math.pow(yDistance, 2));
}

function updateGameArea() {
	ctx = myGameArea.context;
	myGameArea.clear();
	
	
	if(collissionDetection(xPerson, yPerson, wPerson, hPerson,
		xPositionCop1, yPositionCop1, 123, 182) == true) {
				showVender = false;
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0; 
				gameover = true;
			
		
	}else if(collissionDetection(xPerson, yPerson, wPerson, hPerson,
		xPositionCop2, yPositionCop2, 123, 182) == true) {
				showVender = false;
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0; 
				gameover = true;
	
	
	
	}else if(collissionDetection(xPerson, yPerson, wPerson, hPerson,
		xPositionCop3, yPositionCop3, 123, 182) == true) {
				showVender = false;
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0; 
				gameover = true;
		
	}else if(collissionDetection(xPerson, yPerson, wPerson, hPerson,
		xPositionCop4, yPositionCop4, 123, 182) == true) {
				showVender = false;
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0; 
				gameover = true;
			
		
	}else if(collissionDetection(xPerson, yPerson, wPerson, hPerson,
		xPositionCop5, yPositionCop5, 123, 182) == true) {
				showVender = false;
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0; 
				gameover = true;
		
	}else if(collissionDetection(xPerson, yPerson, wPerson, hPerson,
		xPositionCop6, yPositionCop6, 123, 182) == true) {
				showVender = false;
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0; 
				gameover = true;				
		
	}else if(collissionDetection(xPerson, yPerson, wPerson, hPerson,
		xPositionCop7, yPositionCop7, 123, 182) == true) {
		
				showVender = false;
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0; 
				gameover = true;
			
		
	}else if(collissionDetection(xPerson, yPerson, wPerson, hPerson,
		xPositionCop8, yPositionCop8, 123, 182) == true) {
				showVender = false;
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0; 
				gameover = true;
			
		
	}
	
	
	
	if (myGameArea.keys && myGameArea.keys[39] && gameover == false) {
		
			if(xPerson == x0){
			xPerson = x1; 
			zahl = 3;
			}
			
			if(xPerson == x1 && zahl !=3){
			xPerson = x2; 
			zahl = 3;
			}
			
			if(xPerson == x2 && zahl !=3){
			xPerson = x3; 
			zahl = 3;
			}
			
			if(xPerson == x3 && zahl !=3){
			xPerson = x4; 
			zahl = 3;
			}
			
			if(xPerson == x4 && zahl !=3){
			xPerson = x5; 
			zahl = 3;
			}
			
			if(xPerson == x5 && zahl !=3){
			xPerson = x6; 
			zahl = 3;
			}
			
			if(xPerson == x6 && zahl !=3){
			xPerson = x7; 
			zahl = 3;
			}
			
			if(xPerson == x7 && zahl !=3){
			xPerson = x8; 
			zahl = 3;
			}
			
			if(xPerson == x8 && zahl !=3){
			xPerson = x9; 
			zahl = 3;
			}
			
			if(xPerson == x9 && zahl !=3){
			xPerson = x10; 
			zahl = 3;
			}
			
			if(xPerson == x10 && zahl !=3){
			xPerson = x11; 
			zahl = 3;
			}
			
			
			if(xPerson == x11){
			
			window.location.href='outro.html';
			
			}
					
	}
	
	
	if (myGameArea.keys && myGameArea.keys[37] && gameover == false) {
	
		
	if(xPerson == x0){
	xPerson = x0; 
	zahl = 3;
	}
	
	
	if(xPerson == x1 && zahl !=3){
		xPerson = x0; 
		zahl = 3;
	}
			
			if(xPerson == x2 && zahl !=3){
			xPerson = x1; 
			zahl = 3;
			}
			
			if(xPerson == x3 && zahl !=3){
			xPerson = x2; 
			zahl = 3;
			}
			
			if(xPerson == x4 && zahl !=3){
			xPerson = x3; 
			zahl = 3;
			}
			
			if(xPerson == x5 && zahl !=3){
			xPerson = x4; 
			zahl = 3;
			}
			
			if(xPerson == x6 && zahl !=3){
			xPerson = x5; 
			zahl = 3;
			}
			
			if(xPerson == x7 && zahl !=3){
			xPerson = x6; 
			zahl = 3;
			}
			
			if(xPerson == x8 && zahl !=3){
			xPerson = x7; 
			zahl = 3;
			}
			
			if(xPerson == x9 && zahl !=3){
			xPerson = x8; 
			zahl = 3;
			}
			
			if(xPerson == x10 && zahl !=3){
			xPerson = x9; 
			zahl = 3;
			}
	
	
	
	
	}
	
	if(gameover == true){
	ctx.fillText("try it again....." ,screenWidth/2-180, screenHeight/3*2+150);
				ctx.font = "bold 80px Consolas";
				ctx.fillText("Game Over" ,screenWidth/2-180, screenHeight/3*2-180);
				ctx.font = "bold 50px Consolas";
				ctx.fillText("Press enter to restart" ,screenWidth/2-300, screenHeight/3*2-100);
	
	}
	
	
	if(myGameArea.keys && myGameArea.keys[13]) {
			window.location.href='45577576.php';
	}


	
    myGamePiece.newPos();
    myGamePiece.update();
}

function directionAfterCollision(xPositionCar, yPositionCar, wPositionCar, hPositionCar,
		xPositionEnemy, yPositionEnemy, wPositionEnemy, hPositionEnemy) {
		
		if (xPositionCar < xPositionEnemy && yPositionCar + hPositionCar > yPositionEnemy+8 && yPositionCar < yPositionEnemy+hPositionEnemy-8) {
			myGamePiece.speedX = -7;
		} else if (xPositionCar >= xPositionEnemy+20 && yPositionCar + hPositionCar > yPositionEnemy+8 && yPositionCar < yPositionEnemy+hPositionEnemy-8) {
			myGamePiece.speedX = 7;
		} else if (yPositionCar+hPositionCar <= yPositionEnemy+8) {
			myGamePiece.speedY = -7;
		} else if (yPositionCar >= yPositionEnemy + hPositionEnemy-8) {
			myGamePiece.speedY = 7;
		}
}


function clearmove() {
    myGamePiece.speedX = 0; 
    myGamePiece.speedY = 0; 
	
}
</script>

</body>
</html>