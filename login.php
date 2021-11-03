<?phpsession_start();?><!doctype HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link href="login.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>    <form action="index.php" method="post">	<br><br><br> <label for="username"></label> <input type="text" id="username" name="username" placeholder="Benutzername"><br><br> <label for="username"></label> <input type="password" id="passwort" name="passwort" placeholder="Passwort"><br><br> <input name="abschicken" type="submit" value="Submit"> <p><a href="loginerstellen.php" value="Submit">Register</a></p> <p><a href="index.php" value="Submit">Home</a></p></form><?phpif(isset($_POST["abschicken"])){$mysql = new mysqli("localhost", "root", "", "test"); $mysql->set_charset('utf8');$stmt = $mysql->prepare("SELECT username, password FROM users WHERE username LIKE ?");echo $mysql->error;    $stmt->bind_param("s", $_POST["username"]);    $stmt->bind_result($username,$passwort);    $stmt->execute();    	 $_SESSION['username'] = $_POST["username"];if( $stmt->fetch() && ($_POST["passwort"] ==  $passwort)){       echo "Anmeldung erfolgreich" ;	 }}?> 
</html>