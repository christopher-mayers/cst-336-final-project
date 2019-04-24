<?php
session_start();

// They are logged in already, no need to be here.
if (isset($_SESSION["auth"]) && $_SESSION["auth"])
{
	header("location: index.php");
	die();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Valkyrie Air - Login</title>

	<link rel="stylesheet" href="build/login.css">
	<script src="js/login.js"></script>
</head>
<body>



</body>
</html>