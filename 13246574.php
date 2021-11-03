<?php
session_start();
if($_SESSION["UserPage"] == 3) {
    $_SESSION["UserPage"] = 4;
} if($_SESSION["UserPage"] < 4) {
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
	background-image: url("jail.jpg");
    background-color: #f1f1f1;
}
</style>
</head>
<body onload="startGame()">
<img src="cop2.png" id="cop2" >
<img src="gangster1.png" id="gangster1">
<img src="gangster2.png" id="gangster2">
<img src="gangster3.png" id="gangster3">
<img src="box.png" id="box">

<script>

var cop2 = document.getElementById("cop2");
var gangster1 = document.getElementById("gangster1");
var gangster2 = document.getElementById("gangster2");
var gangster3 = document.getElementById("gangster3");
var box = document.getElementById("box");

var myGamePiece; 

var screenHeight = window.innerHeight;
var screenWidth  = window.innerWidth;
var cop2;
var gangster1;
var gangster2;
var gangster3;

var dialogAcc = 0;


box = document.getElementById("box");

var npcCount = 1;
var movementNpc = 0;
var direction = Math.floor(Math.random() * 4) + 1;


var ki = true;
var dialogE = true;
var showCop = true;
var drawPrisoners = false;
var drawPrisonersFight = false;
var gameover = false;

var xPositionPlayer;
var yPositionPlayer;
var wPositionPlayer;
var hPositionPlayer;

var xQuestEnd = 90;
var yQuestEnd = 220;
var wQuestEnd = 200;
var hQuestEnd = 200;


var imageArrayNpc = [];
imageArrayNpc.push(gangster3, gangster3, gangster2, cop2, gangster1, gangster3);

var xPositionNpc = [];
xPositionNpc.push(350, 1450, 500, 350, 750, 1000, 1300);
	
var yPositionNpc = [];
yPositionNpc.push(400, 350, 850, 100, 300, 600, 550);

var wPositionNpc = [];
wPositionNpc.push(133, 133, 133, 133, 133, 133, 133);

var hPositionNpc = [];
hPositionNpc.push(182, 182, 182, 182, 182, 182, 182);

var xcop2 =70;
var ycop2 =400;
var wcop2 =100;
var hcop2 = 180;

function startGame() {
	myGamePiece = new component(133, 182, "vonVorne.png", 1600, 800, "image");
	
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
	} else if (xPositionPlayer >= xPositionObject+20 && yPositionPlayer + hPositionPlayer > yPositionObject+8 && yPositionPlayer < yPositionObject+hPositionObject-8) {
		myGamePiece.speedX = 7;
	} else if (yPositionPlayer+hPositionPlayer <= yPositionObject+8) {
		myGamePiece.speedY = -7;
	} else if (yPositionPlayer >= yPositionObject + hPositionObject-8) {
		myGamePiece.speedY = 7;
	}
}

function directionAfterCollisionNpc(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
	xPositionObject, yPositionObject, wPositionObject, hPositionObject, i) {
		
	if (xPositionPlayer < xPositionObject && yPositionPlayer + hPositionPlayer > yPositionObject+8 && yPositionPlayer < yPositionObject+hPositionObject-8) {
		xPositionNpc[i] += -7;
	} else if (xPositionPlayer >= xPositionObject+20 && yPositionPlayer + hPositionPlayer > yPositionObject+8 && yPositionPlayer < yPositionObject+hPositionObject-8) {
		xPositionNpc[i] += 7;
	} else if (yPositionPlayer+hPositionPlayer <= yPositionObject+8) {
		yPositionNpc[i] += -7;
	} else if (yPositionPlayer >= yPositionObject + hPositionObject-8) {
		yPositionNpc[i] += 7;
	}
}

function draw() {
	ctx = myGameArea.context;
	
	ctx.drawImage(cop2, xcop2, ycop2, wcop2, hcop2);
	
	
	movementNpc++;

	/*if(verhaften == true) {
		policeGetCriminal();
	} else {*/
		for(var i = 0; i < imageArrayNpc.length; i++) {
			ctx.drawImage(imageArrayNpc[i], xPositionNpc[i], yPositionNpc[i], wPositionNpc[i], hPositionNpc[i]);
			
			if(movementNpc >= 150) {
				if(movementNpc <= 450) {
					for(var k = 0; k < imageArrayNpc.length; k++) {
						if(k == i) {
							k++
						} else {
							if(collissionDetection(xPositionNpc[i], yPositionNpc[i], wPositionNpc[i], hPositionNpc[i], 
								xPositionNpc[k]-40, yPositionNpc[k]-40, wPositionNpc[k]+40, hPositionNpc[k]+40) == false && !(movementNpc >= 700)) {
								

							} else if(collissionDetection(xPositionNpc[i], yPositionNpc[i], wPositionNpc[i], hPositionNpc[i], 
								xPositionNpc[k], yPositionNpc[k], wPositionNpc[k], hPositionNpc[k]) == true) {

								directionAfterCollisionNpc(xPositionNpc[i], yPositionNpc[i], wPositionNpc[i], hPositionNpc[i], 
								xPositionNpc[k], yPositionNpc[k], wPositionNpc[k], hPositionNpc[k], i);

								movementNpc = 1200;
							}
						}
					}
				} else if(movementNpc >= 450){
					//console.log("NPC: " + nameNpc[i] + " Richtung:" + direction)
					direction = Math.floor(Math.random() * 4) + 1;
					npcCount = Math.floor(Math.random() * imageArrayNpc.length);
					movementNpc = 0;
				}
			}
		}
		
		ctx.textAlign = 'center'; 
		ctx.font = "20px Consolas";
		ctx.fillStyle = "#FFFFFF";
		
		//ctx.fillText(xPositionNpc[i] + wPositionNpc[i] / 2, yPositionNpc[i]-5);
		
	}



function updateGameArea() {
	var g = true;
	ctx = myGameArea.context;
	myGameArea.clear();
	
	if(gameover == false) {
		if((xPositionPlayer+133) > screenWidth || xPositionPlayer <= 0 || (yPositionPlayer+182) > screenHeight || yPositionPlayer <= 0) {
			g = false;
			if((xPositionPlayer+133) > screenWidth) {
				myGamePiece.speedX = -2;	//rechts
			}
			if(xPositionPlayer <= 0) {
				myGamePiece.speedX = 2;		//links
			}
			
			if((yPositionPlayer+182) > screenHeight) {
				myGamePiece.speedY = -2;	//oben
			}
			
			if(yPositionPlayer <= 0) {
				myGamePiece.speedY = 2;
			}
		}
		for(var k = 0; k < imageArrayNpc.length; k++) {
			
			if (collissionDetection(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
			xPositionNpc[k], yPositionNpc[k], wPositionNpc[k], hPositionNpc[k]) == true) {
				g = false;
				gameover=true;
			}
		}
		
		if (g == true) {
			var check = false;
			if (myGameArea.keys && myGameArea.keys[87]) {myGamePiece.speedY = -2; check = true; myGamePiece.image.src = "vonHinten.png";	
			}	//oben
			if (myGameArea.keys && myGameArea.keys[68]) {myGamePiece.speedX = 2; check = true; myGamePiece.image.src = "vonLinks.png";	
			}	//rechts
			if (myGameArea.keys && myGameArea.keys[65]) {myGamePiece.speedX = -2; check = true; myGamePiece.image.src = "vonRechts.png";	
			}	//links
			if (myGameArea.keys && myGameArea.keys[83]) {myGamePiece.speedY = 2; check = true; myGamePiece.image.src = "vonVorne.png";	
			}	//unten 
			
			if (myGameArea.keys && myGameArea.keys[87] && myGameArea.keys[16]) {myGamePiece.speedY = -6; check = true;
			}	//oben
			if (myGameArea.keys && myGameArea.keys[68] && myGameArea.keys[16]) {myGamePiece.speedX = 6; check = true;
			}	//rechts
			if (myGameArea.keys && myGameArea.keys[65] && myGameArea.keys[16]) {myGamePiece.speedX = -6; check = true;
			}	//links
			if (myGameArea.keys && myGameArea.keys[83] && myGameArea.keys[16]) {myGamePiece.speedY = 6; check = true;
			}	//unten 
			
			
			
			 if (myGameArea.keys && myGameArea.keys[69] && dialogAcc == 1) {
				dialogE = false;
				dialogAcc = 2;
			}
			if(dialogAcc == 2) {
				ctx.font = "bold 24px Consolas";
				ctx.fillText("What you want", 140, 350);
				
				
				ctx.drawImage(box, 10, 180, 340, 127);
				ctx.fillStyle = "#000000";
				ctx.fillText("Press 1: Beat him", 140, 210);
				ctx.fillText("Press 2: Slap him", 140, 250);
				ctx.fillText("Press 3: Stab him", 140, 290);
			}
			
			if (myGameArea.keys && myGameArea.keys[49] && dialogAcc == 2) {
				dialogAcc = 3;
			}
			if(myGameArea.keys && myGameArea.keys[50] && dialogAcc == 2) {
				dialogAcc = 4;
			}
			if(myGameArea.keys && myGameArea.keys[51] && dialogAcc == 2) {
				dialogAcc = 5;
			}
			
			if(check == false) {
				myGamePiece.speedX = 0; 
				myGamePiece.speedY = 0; 
			}
			
			if(dialogAcc > 2) {
				if(dialogAcc == 5) {
					
					window.location.href='75315985.php';
					ctx.fillStyle = 'black';
					if(drawPrisonersFight == false) {
					myGamePiece.image.src = "waffe.png"
					
					}
					
					/*else if (collissionDetection(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
						xQuestEnd, yQuestEnd, wQuestEnd, hQuestEnd) == true) {
						
						ctx.font = "bold 80px Consolas";
						ctx.fillText("Finished!" ,1160, 300);
					}*/ else {
						ctx.font = "bold 80px Consolas";
						ctx.fillText("Success!" ,1160, 300);
						ctx.font = "bold 30px Consolas";
						ctx.fillText("enjoy escaping from mission 5" ,1150, 350);
						ctx.fillStyle = 'rgba(255, 53, 53, 0.6)';
					}
					
					drawPrisonersFight = true;
					//Erste Option
				} else if (dialogAcc == 4) {
					//Zweite Option = He escapes Game Over
					ctx.fillText("He escaped..." ,screenWidth/2-230, screenHeight/3*2+150);
					ctx.font = "bold 80px Consolas";
					ctx.fillText("Game Over" ,screenWidth/2-140, screenHeight/3*2-180);
					ctx.font = "bold 50px Consolas";
					ctx.fillText("Press enter to restart" ,screenWidth/2-230, screenHeight/3*2-140);
					showVender = false;
					dialogAcc == 6;
					gameover == true;
				} else if (dialogAcc == 3) {
					//Dritte Option: Game Over
					ctx.font = "bold 22px Consolas";
					ctx.fillText("Loser", 1615, 530);
					ctx.font = "bold 80px Consolas";
					ctx.fillText("Game Over" ,screenWidth/2-140, screenHeight/3*2-180);
					drawPrisoners = true;
					ctx.font = "bold 50px Consolas";
					ctx.fillText("Press enter to restart" ,screenWidth/2-230, screenHeight/3*2-140);
					dialogAcc == 6;
					gameover == true;
				}
			
			}
			
		}
		
		if (collissionDetection(xPositionPlayer, yPositionPlayer, wPositionPlayer, hPositionPlayer,
			xcop2, ycop2, wcop2, hcop2) == true) {
			
			if(dialogE == true) {
				ctx.font = "bold 35px Consolas";
				ctx.fillText("Press E to continue" ,screenWidth/3-400, screenHeight/3);
				dialogAcc = 1;
			}
			
		} 
	
	}
	
	if(dialogAcc == 0) {
		ctx.font = "bold 80px Consolas";
		ctx.fillText("Fourth Mission" ,1200, 300);
		ctx.font = "bold 30px Consolas";
		ctx.fillText("Kill the cop to escape" ,1200, 350);
	}
	
	if(gameover == true) {
		myGameArea.clear();
		ctx.font = "bold 100px Consolas";
		ctx.fillText("Knife lost" ,1200, 200);
		ctx.font = "bold 50px Consolas";
		ctx.fillText("Press enter to restart" ,1220, 250);
	}
	
	if(myGameArea.keys && myGameArea.keys[13] ) {
		window.location.href='13246574.php';
	}
	
	myGamePiece.newPos();
    myGamePiece.update();
}

function gameover() {
	gameover = true;
}

function clearmove() {
    myGamePiece.speedX = 0; 
    myGamePiece.speedY = 0; 
	
}

</script>

</body>
</html>