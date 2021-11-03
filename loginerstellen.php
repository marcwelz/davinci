<?php
session_start();
?>
<!doctype HTML>
<html>
<head>
<link rel="icon" type="image/vnd.microsoft.icon" href="logo.ico">
    <meta charset="utf-8">
    <title>Mein Profil</title>
    <link href="login.css" rel="stylesheet">
</head>
<body>

<form action="index.php" method="post">

<br><br><br>
 <label for="username"></label> <input type="text" id="username" name="username" placeholder="Username"><br><br>
 <label for="passwort"></label> <input type="password" id="passwort" name="passwort" placeholder="Password"><br><br>
 <label for="passwort2"></label> <input type="password" id="passwort2" name="passwort2" placeholder="repeat Password"><br><br><br>
 <input type="submit" name="abschicken" value="Register">
 <p><a href="login.php">I already have an account</a></p>
 <p><a href="index.php" value="Submit">Home</a></p>

</form>

<?php
if(isset($_POST['username'])){
 $zahl = 0;
$username = $_POST['username'];
$passwort = $_POST['passwort'];
$passwort2 = $_POST['passwort2'];

$mysql = new mysqli("localhost", "root", "", "test"); 
$mysql->set_charset('utf8');
$stmt = $mysql->prepare("SELECT username FROM users WHERE USERNAME LIKE ?");
echo $mysql->error;
    $stmt->bind_param("s", $username); 
    $stmt->bind_result($ergebnis);
    $stmt->execute();

IF    ($stmt->fetch()){
echo "Diesen Benutzernamen gibt es schon. Bitte versuche es mit einem anderen.";
}

else{
    
if($passwort == $passwort2){
    $mysql = new mysqli("localhost", "root", "", "test"); 
    $stmt = $mysql->prepare("INSERT INTO `test`.`users` (`username`, `password`) VALUES (?, ?);"); 
    $stmt->bind_param("ss", $username, $passwort);
    $stmt->execute(); 
    $_SESSION['username'] = $username;
}else{
echo "Die Passwörter müssen übereinstimmen.";

}
}

$stmt->close();
}
?>

</body>
</html>

