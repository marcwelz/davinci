<?php	session_start();	if(!empty($_SESSION['username'])) {		$name = $_SESSION['username'];	}?><!doctype HTML>
<html>
<head>
<link rel="icon" type="image/vnd.microsoft.icon" href="logo.ico">
	<meta charset="utf-8">
	<title>Escape</title>
	<link href="home.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>	<br>	<br>	<br>
	<div class="log">	<?php 		if(!empty($name)) {				echo $name;		}	?>
	</div>	<a class="loginbtn" type="submit" href="loginerstellen.php">Login</a> 	<a class="gamebtn" href="intro.html">Game</a>		<a class="minigamebtn" href="generieren.html">Minispiel</a>		<a class="cargamebtn" href="cargame.html">Cargame</a>	<a class="shooterbtn" href="shooter.html">Shooter</a>			<img src="logo.png" alt="logo" class="logo">
<footer class="footer">
  © All Rights reserved 
  <br>
  Escape Inc.
</footer>
</body>
</html>