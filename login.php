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
	<title>Valkyrie Air - Login</title>

	<link rel="stylesheet" href="build/login.css">
	<script src="js/login.js"></script>

	<template id="loginForm">
		<div class="template-holder" data-option="signin" data-pad="true">
			<span class="field">
				<input type="text" name="email" id="email"><label for="email">Email</label>
			</span>
			<span class="field">
				<input type="password" name="password" id="password"><label for="password">Password</label>
			</span>
			<button class="form-submit">
				<span>Login</span>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
			</button>
		</div>

		<script>
			for (let obj of document.querySelectorAll(".field input"))
			{
				obj.addEventListener("input", function(e)
				{
					const value = e.currentTarget.value;

					if (value.length > 0)
						obj.nextElementSibling.style.display = "none";
					else
						obj.nextElementSibling.style.display = "";
				});
			}

			const submit = document.querySelector("button.form-submit");
			submit.addEventListener("click", function(e)
			{
				const email = document.querySelector("input#email").value;
				const password = document.querySelector("input#password").value;

				const data = {email, password};

				fetch("api/login", {
					method: "POST",
					headers: {"Content-Type": "application/json"},
					body: JSON.stringify(data)
				})
					.then((r) => r.json())
					.then((r) => {
						if (r.status === "accepted")
							window.location = "index.php"
					})
			})
		</script>
	</template>

	<template id="registerForm">
		<div data-option="register">
			<span class="field">
				<input type="text" name="name" id="name"><label for="name">Full Name</label>
			</span>
			<span class="field">
				<input type="text" name="email" id="email"><label for="email">Email</label>
			</span>
			<span class="field">
				<input type="password" name="password" id="password"><label for="password">Password</label>
			</span>
			<button class="form-submit">
				<span>Register</span>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
			</button>
		</div>

		<script>
			for (let obj of document.querySelectorAll(".field input"))
			{
				obj.addEventListener("input", function(e)
				{
					const value = e.currentTarget.value;

					if (value.length > 0)
						obj.nextElementSibling.style.display = "none";
					else
						obj.nextElementSibling.style.display = "";
				});
			}
		</script>
	</template>
</head>
<body>

<span class="branding">
	<svg height="167pt" version="1.1" viewBox="0 0 154 167" width="154pt"
	     xmlns="http://www.w3.org/2000/svg">
		<g id="#e2e8f7ff">
		</g>
		<g id="#4f78c2ff">
		<path d=" M 66.74 7.57 C 74.36 7.31 82.00 7.36 89.61 7.52 C 90.43 8.49 90.64 9.81 91.13 10.96 C 106.21 52.52 121.57 93.97 136.57 135.55 C 121.09 135.45 104.53 132.82 92.04 122.99 C 83.95 116.66 79.45 106.96 77.63 97.04 C 77.97 106.59 72.57 115.51 65.78 121.85 C 53.36 132.58 36.28 135.15 20.42 135.76 C 35.52 92.92 51.58 50.40 66.74 7.57 Z" fill="#4f78c2"
		      opacity="1.00"/>
		</g>
		<g id="#70bbfeff">
		<path d=" M 77.63 97.04 C 79.45 106.96 83.95 116.66 92.04 122.99 C 104.53 132.82 121.09 135.45 136.57 135.55 L 136.84 135.55 C 139.30 142.58 141.78 149.60 144.50 156.53 C 145.15 158.21 145.87 159.96 145.58 161.81 C 126.02 157.86 106.25 150.49 92.02 135.99 C 84.94 128.70 79.77 119.32 78.67 109.12 C 76.58 123.11 67.84 135.38 56.44 143.45 C 43.22 153.19 27.32 158.85 11.23 161.61 C 13.90 152.87 17.18 144.30 20.42 135.76 C 36.28 135.15 53.36 132.58 65.78 121.85 C 72.57 115.51 77.97 106.59 77.63 97.04 Z" fill="#70bbfe"
		      opacity="1.00"/>
		</g>
	</svg>
</span>

<div class="fullpage center">
	<div class="container">
		<div class="controls">
			<div class="option" data-selected="true" role="button" data-target="loginForm">
				<span>Sign In</span>
			</div>
			<div class="option" data-selected="false" role="button" data-target="registerForm">
				<span>Register</span>
			</div>
		</div>
		<div class="form-container">
		</div>
	</div>
</div>

</body>
</html>