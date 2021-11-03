<?php
session_start();
if($_SESSION["UserPage"] == 4) {
    $_SESSION["UserPage"] = 5;
} if($_SESSION["UserPage"] < 5) {
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
	background-image: url("Mission_5background.png");
    background-color: #f1f1f1;
}
</style>
</head>
<body onload="startGame()">
<img src="Hindernis.png" id="hindernis" >
<img src="cop1.png" id="cop1">
<img src="Ziel.png" id="ziel">
<img src="Hindernisq.png" id="hindernisq">
<script>

var myGamePiece; 
var cop1 = document.getElementById("cop1");
var ziel = document.getElementById("ziel");

var screenHeight = window.innerHeight;
var screenWidth  = window.innerWidth;

var xPositionPlayer;
var yPositionPlayer;
var wPositionPlayer;
var hPositionPlayer;

//---------------------------- Für Booleans ----------------------------

var gameover = false;
var win = false;

//---------------------------- Für Objekte -----------------------------

var imageArray = [];
imageArray.push(hindernisq,hindernis,hindernisq,hindernis,hindernisq); //hindernisq,

var xPositionStaticObject = [];
xPositionStaticObject.push(1000,900,225,250,700); //1200,
	
var yPositionStaticObject = [];
yPositionStaticObject.push(970,0,200,550,600); //300,

var wPositionStaticObject = [];
wPositionStaticObject.push(200,100,525,100,500); //500,

var hPositionStaticObject = [];
hPositionStaticObject.push(100,400,100,300,100); //100,

//---------------------------- Für NPC --------------------------------

var imageArrayNpc = [];
imageArrayNpc.push();

var xPositionNpc = [];
xPositionNpc.push();
	
var yPositionNpc = [];
yPositionNpc.push();

var wPositionNpc = [];
wPositionNpc.push();

var hPositionNpc = [];
hPositionNpc.push();

var xture =0;
var yture =860;
var hture = 200;
var wture = 100;


var xCop =100;
var yCop =600;
var hCop = 182;
var wCop = 133;
var xCopspeed=0;
var yCopspeed=0;

var xCops =250;
var yCops =890;
var hCops = 182;
var wCops = 133;

var xCop3 =1100;
var yCop3 =100;
var hCop3 = 182;
var wCop3 = 133;
var xCopspeed3=0;
var yCopspeed3=0;

var xCop2 =-40;
var yCop2 =200;
var hCop2 = 182;
var wCop2 = 133;
var xCopspeed2 =0;
var yCopspeed2 =0;

function startGame() {
	myGamePiece = new component(133, 182, "vonRechts.png", 1900, 600, "image");
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
            myGameArea.keys = (myGameArea.keys || []);
            myGameArea.keys[e.keyCode] = (e.type == "keydown");
        })
        window.addEventListener('keyup', function (e) {
			clearmove();
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
	
	xPositionPlayer = this.x;
	yPositionPlayer = this.y;
	wPositionPlayer = this.width;
	hPositionPlayer = this.height;
	
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
        this.x += this.speedX;
        this.y += this.speedY;        
    }	
}

function collissionDetection(xPlayer, yPlayer, wPlayer, hPlayer, xObject, yObject, wObject, hObject) {
	
	if(xPlayer < xObject + wObject && xPlayer + wPlayer > xObject && yPlayer < yObject + hObject && yPlayer + hPlayer > yObject) {
		return true;
	} else {
		return false;
	}
}

function directionAfterCollision(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
	xPositionObject, yPositionObject, wPositionObject, hPositionObject, k) {
		
	if (xPositionPlayer < xPositionObject && yPositionPlayer + hPositionPlayer > yPositionObject+8 && yPositionPlayer < yPositionObject+hPositionObject-8) {
		myGamePiece.speedX = -7;
		//xCopspeed=-7;
	} else if (xPositionPlayer >= xPositionObject+20 && yPositionPlayer + hPositionPlayer > yPositionObject+8 && yPositionPlayer < yPositionObject+hPositionObject-8) {
		myGamePiece.speedX = 7;
		//xCopspeed=7;
	} else if (yPositionPlayer+hPositionPlayer <= yPositionObject+8) {
		myGamePiece.speedY = -7;
		//yCopspeed=-7;
	} else if (yPositionPlayer >= yPositionObject + hPositionObject-8) {
		myGamePiece.speedY = 7;
		//yCopspeed=7;
	}
}
function directionAfterCollisionCop(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
	xPositionObject, yPositionObject, wPositionObject, hPositionObject, k,welcher) {
	
		
	if (xPositionPlayer < xPositionObject && yPositionPlayer + hPositionPlayer > yPositionObject+8 && yPositionPlayer < yPositionObject+hPositionObject-8) {
	console.log(welcher);
		if(welcher==1){
			xCopspeed=-7;
		}else if(welcher==3){
			xCopspeed3=-7;
		}
	} else if (xPositionPlayer >= xPositionObject+20 && yPositionPlayer + hPositionPlayer > yPositionObject+8 && yPositionPlayer < yPositionObject+hPositionObject-8) {
		if(welcher==1){
			xCopspeed=7;
		}else if(welcher==3){
			xCopspeed3=7;
		}
	} else if (yPositionPlayer+hPositionPlayer <= yPositionObject+8) {
		if(welcher==1){
			yCopspeed=-7;
		}else if(welcher==3){
			yCopspeed3=-7;
		}
	} else if (yPositionPlayer >= yPositionObject + hPositionObject-8) {
		if(welcher==1){
			yCopspeed=7;
		}else if(welcher==3){
			yCopspeed3=7;
		}
	}
}
function directionAfterCollisionCop2(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
	xPositionObject, yPositionObject, wPositionObject, hPositionObject, k) {
		
	if (xPositionPlayer < xPositionObject && yPositionPlayer + hPositionPlayer > yPositionObject+8 && yPositionPlayer < yPositionObject+hPositionObject-8) {
		xCopspeed2=-7;
	} else if (xPositionPlayer >= xPositionObject+20 && yPositionPlayer + hPositionPlayer > yPositionObject+8 && yPositionPlayer < yPositionObject+hPositionObject-8) {
		xCopspeed2=7;
	} else if (yPositionPlayer+hPositionPlayer <= yPositionObject+8) {
		yCopspeed2=-7;
	} else if (yPositionPlayer >= yPositionObject + hPositionObject-8) {
		yCopspeed2=7;
	}
}

function draw() {
	ctx = myGameArea.context;
	
	for(var k = 0; k < imageArray.length; k++) {
		ctx.drawImage(imageArray[k], xPositionStaticObject[k], yPositionStaticObject[k], wPositionStaticObject[k], hPositionStaticObject[k]);
	}
	ctx.drawImage(ziel,xture,yture,wture,hture);
	
	ctx.drawImage(cop1,xCops,yCops,wCops,hCops);
	
	xCop+=xCopspeed;
	yCop+=yCopspeed;
	ctx.drawImage(cop1,xCop,yCop,wCop,hCop);
	xCopspeed=myGamePiece.speedX;
	yCopspeed=myGamePiece.speedY;
	
	xCop3+=xCopspeed3;
	yCop3+=yCopspeed3;
	ctx.drawImage(cop1,xCop3,yCop3,wCop3,hCop3);
	xCopspeed3=myGamePiece.speedX;
	yCopspeed3=myGamePiece.speedY;
	
	xCop2+=xCopspeed2;
	yCop2+=yCopspeed2;
	ctx.drawImage(cop1,xCop2,yCop2,wCop2,hCop2);
	xCopspeed2=myGamePiece.speedX*-1;
	yCopspeed2=myGamePiece.speedY*-1;
}

function updateGameArea() {
	var g = true;
	
	ctx = myGameArea.context;
	myGameArea.clear();
	
	if(gameover == false && win == false) {
		if((xPositionPlayer+133) > screenWidth || xPositionPlayer <= 0 || (yPositionPlayer+182) > screenHeight || yPositionPlayer <= 0) {
			g = false;
			if((xPositionPlayer+133) > screenWidth) {
				myGamePiece.speedX = -2;	//rechts
				//xCopspeed=2;
			}
			if(xPositionPlayer <= 0) {
				myGamePiece.speedX = 2;				//links
				//xCopspeed =2;
			}
				
			if((yPositionPlayer+182) > screenHeight) {
				myGamePiece.speedY = -2;	//oben
				//yCopspeed=-2;
			}
			
			if(yPositionPlayer <= 0) {
				myGamePiece.speedY = 2;
				//yCopspeed=2;
			}
		}
		if((xCop+133) > screenWidth || xCop<= 0 || (yCop+182) > screenHeight || yCop <= 0) {
			g = false;
			if((xCop+133) > screenWidth) {
				xCopspeed = -2;	//rechts
			}
			if(xCop <= 0) {
				xCopspeed= 2;		//links
			}
				
			if((yCop+182) > screenHeight) {
				yCopspeed = -2;	//oben
			}
			
			if(yCop <= 0) {
				yCopspeed = 2;
			}
		}
		if((xCop3+133) > screenWidth || xCop3<= 0 || (yCop3+182) > screenHeight || yCop3 <= 0) {
			g = false;
			if((xCop3+133) > screenWidth) {
				xCopspeed3 = -2;	//rechts
			}
			if(xCop3 <= 0) {
				xCopspeed3= 2;		//links
			}
				
			if((yCop3+182) > screenHeight) {
				yCopspeed3 = -2;	//oben
			}
			
			if(yCop3 <= 0) {
				yCopspeed3 = 2;
			}
		}
		if((xCop2+133) > screenWidth || xCop2<= 0 || (yCop2+182) > screenHeight || yCop2 <= 0) {
			g = false;
			if((xCop2+133) > screenWidth) {
				xCopspeed2 = -2;	//rechts
			}
			if(xCop2 <= 0) {
				xCopspeed2= 2;		//links
			}
				
			if((yCop2+182) > screenHeight) {
				yCopspeed2 = -2;	//oben
			}
			
			if(yCop2 <= 0) {
				yCopspeed2 = 2;
			}
		}
		for(var k = 0; k < imageArray.length; k++) {
				
			if (collissionDetection(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
				xPositionStaticObject[k], yPositionStaticObject[k], wPositionStaticObject[k], hPositionStaticObject[k]) == true) {
				g = false;
				directionAfterCollision(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
				xPositionStaticObject[k], yPositionStaticObject[k], wPositionStaticObject[k], hPositionStaticObject[k]);
				}
			if (collissionDetection(xCop, yCop, wCop, hCop,
				xPositionStaticObject[k], yPositionStaticObject[k], wPositionStaticObject[k], hPositionStaticObject[k]) == true) {
				g = false;
				directionAfterCollisionCop(xCop, yCop, wCop, hCop,
				xPositionStaticObject[k], yPositionStaticObject[k], wPositionStaticObject[k], hPositionStaticObject[k],k,1);
				}
			if (collissionDetection(xCop3, yCop3, wCop3, hCop3,
				xPositionStaticObject[k], yPositionStaticObject[k], wPositionStaticObject[k], hPositionStaticObject[k]) == true) {
				g = false;
				directionAfterCollisionCop(xCop3, yCop3, wCop3, hCop3,
				xPositionStaticObject[k], yPositionStaticObject[k], wPositionStaticObject[k], hPositionStaticObject[k],k,3);
				}
			if (collissionDetection(xCop2, yCop2, wCop2, hCop2,
				xPositionStaticObject[k], yPositionStaticObject[k], wPositionStaticObject[k], hPositionStaticObject[k]) == true) {
				g = false;
				directionAfterCollisionCop2(xCop2, yCop2, wCop2, hCop2,
				xPositionStaticObject[k], yPositionStaticObject[k], wPositionStaticObject[k], hPositionStaticObject[k]);
				}
			}
			if (collissionDetection(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
				xCops,yCops, wCops, hCops) == true) {
				g = false;
				gameover=true;
				}
			if (collissionDetection(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
				xCop,yCop, wCop, hCop) == true) {
				g = false;
				gameover=true;
				}
			if (collissionDetection(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
				xCop3,yCop3, wCop3, hCop3) == true) {
				g = false;
				gameover=true;
				}
			if (collissionDetection(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
				xCop2,yCop2, wCop2, hCop2) == true) {
				g = false;
				gameover=true;
				}
		if (g == true) {
			var check = false;
			if (myGameArea.keys && myGameArea.keys[87]) {
			myGamePiece.speedY = -2; check = true; myGamePiece.image.src = "vonHinten.png";
			//yCopspeed = -2;
			}	//oben
			if (myGameArea.keys && myGameArea.keys[68]) {
			myGamePiece.speedX = 2; check = true; myGamePiece.image.src = "vonLinks.png";	
			//xCopspeed = 2;
			}	//rechts
			if (myGameArea.keys && myGameArea.keys[65]) {
			myGamePiece.speedX = -2; check = true; myGamePiece.image.src = "vonRechts.png";	
			//xCopspeed = -2;
			}	//links
			if (myGameArea.keys && myGameArea.keys[83]) {
			myGamePiece.speedY = 2; check = true; myGamePiece.image.src = "vonVorne.png";	
			//yCopspeed=2;
			}	//unten 
			
			if (myGameArea.keys && myGameArea.keys[87] && myGameArea.keys[16]) {
			myGamePiece.speedY = -6; check = true;
			//yCopspeed = -6;
			}	//oben
			if (myGameArea.keys && myGameArea.keys[68] && myGameArea.keys[16]) {
			myGamePiece.speedX = 6; check = true; 
			//xCopspeed = 6;
			}	//rechts
			if (myGameArea.keys && myGameArea.keys[65] && myGameArea.keys[16]) {
			myGamePiece.speedX = -6; check = true;
			//xCopspeed = -6;
			}	//links
			if (myGameArea.keys && myGameArea.keys[83] && myGameArea.keys[16]) {
			myGamePiece.speedY = 6; check = true;
			//yCopspeed = 6;
			}	//unten 
			
			if(check == false) {
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0;
				xCopspeed=0;
				yCopspeed=0;		
			} 
			
		}
	}
	
	
	if(gameover == true && win== false) {
	myGamePiece.speedX = 0; 
    myGamePiece.speedY = 0;
		myGameArea.clear();
		ctx.textAlign = "center";
		ctx.fillText("He got busted " ,screenWidth/2, screenHeight/3*2+150);
		ctx.textAlignlign ="center";
		ctx.font = "bold 80px Consolas";
		ctx.fillText("Game Over" ,screenWidth/2, screenHeight/3*2-180);
		ctx.font = "bold 50px Consolas";
		ctx.fillText("Press enter to restart" ,screenWidth/2, screenHeight/3*2-140);
		ctx.textAlign = "center";
	}
	if(gameover != true && xPositionPlayer <=50 && yPositionPlayer>800) {
	myGamePiece.speedX = 0; 
    myGamePiece.speedY = 0;
		myGameArea.clear();
		ctx.textAlign = "center";
		ctx.fillText("He escaped " ,screenWidth/2, screenHeight/3*2+150);
		ctx.textAlignlign ="center";
		ctx.font = "bold 80px Consolas";
		ctx.fillText("You have won" ,screenWidth/2, screenHeight/3*2-180);
		ctx.font = "bold 50px Consolas";
		ctx.fillText("Press enter to continue" ,screenWidth/2, screenHeight/3*2-140);
		ctx.textAlign = "center";
		win = true;
	}
	
	
	if(myGameArea.keys && myGameArea.keys[13] ) {
		window.location.href='75315985.php';
	}
	myGamePiece.newPos();
    myGamePiece.update();
	}
	


function clearmove() {
    myGamePiece.speedX = 0; 
    myGamePiece.speedY = 0;
	
}

</script>

</body>
</html>