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
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<link rel="apple-touch-icon" sizes="57x57" href="icon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="icon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="icon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="icon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="icon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="icon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="icon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="icon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="icon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="icon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#406abc">
	<meta name="msapplication-TileImage" content="icon/ms-icon-144x144.png">
	<meta name="theme-color" content="#406abc">
	<title>Valkyrie Air - Login</title>

	<link href="index.php" rel="prefetch">

	<link rel="stylesheet" href="build/login.css">
	<script src="js/login.js"></script>

	<template id="login-form">
		<span class="field">
			<input type="email" name="email" id="email"><label for="email">Email</label>
		</span>
		<span class="field">
			<input type="password" name="password" id="password"><label for="password">Password</label>
		</span>
		<button class="form-submit">
			<span>Login</span>
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
		</button>
	</template>

	<template id="register-form">
		<span class="field">
			<input type="text" name="name" id="name"><label for="name">Full Name</label>
		</span>
		<span class="field">
			<input type="email" name="email" id="email"><label for="email">Email</label>
		</span>
		<span class="field">
			<input type="password" name="password" id="password"><label for="password">Password</label>
		</span>
		<button class="form-submit">
			<span>Register</span>
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
		</button>
	</template>

	<template id="error-message">
		<span></span>
	</template>
</head>
<body>

<a class="branding" href="index.php">
	<svg version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" x="0px"
	     y="0px" width="218.04px" height="248.82px" viewBox="0 0 218.04 248.82" xml:space="preserve">
		<g>
			<g>
				<path fill="#4A77BC" d="M200.17,49.31c-24.2,66.52-48.39,133.05-72.57,199.51c-12.49,0-24.24,0-36.59,0
					c-4.93-13.27-9.88-26.41-14.71-39.61C61.76,169.47,47.27,129.7,32.75,89.95c-4.94-13.52-12.5-33.78-17.44-47.29
					c1.27-0.01,0.98-0.01,2.62,0c17.01,0.37,34.13,2.53,50.16,9.14c20.86,8.61,35.27,23.71,41.46,48.94
					c5.75-22.41,17.09-37.05,35.51-46.07c17.62-8.63,37.9-11.75,57.54-12.01C201.75,45.44,200.64,47.57,200.17,49.31z"/>
				<path fill="#71B6E5" d="M202.61,42.65c0,0,0,0-1.5,0.03c-19.71,0.68-38.41,3.36-56.04,11.99c-18.42,9.02-29.76,23.66-35.51,46.07
					c-6.19-25.23-20.6-40.34-41.46-48.94c-16.03-6.61-33.15-8.78-50.16-9.14c-2.07,0-0.3-0.02-2.62,0c-2.35-6.13-2.16-5.49-4.43-11.65
					C7.41,21.56,4.04,12.07,0,0.86c25.03,3.63,46.58,11.77,66.47,24.32c20.37,12.86,35.68,29.95,42.12,55.27
					C126.84,28.18,168.98,11.65,218.04,0c-2.92,8.2-4.91,13.87-6.96,19.52C207.46,29.46,206.25,32.73,202.61,42.65z"/>
			</g>
		</g>
	</svg>
</a>

<div class="fullpage center">
	<div class="container" hidden>
		<div class="controls">
			<div class="option" data-selected="true" role="button" data-target="login-form">
				<span>Sign In</span>
			</div>
			<div class="option" data-selected="false" role="button" data-target="register-form">
				<span>Register</span>
			</div>
		</div>
		<div class="form-container">
			<login-form></login-form>
		</div>

		<error-message></error-message>
	</div>
</div>

</body>
</html>