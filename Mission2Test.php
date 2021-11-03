<?php
session_start();
$i = $_SESSION["UserPage"];
if($i == 1) { 
	$_SESSION["UserPage"] = 2;
} if($i < 2) {
	header('Location: Mission' . $i . '.php');
}
?>
<!DOCTYPE html>
<html>
<body>
</body>
</html