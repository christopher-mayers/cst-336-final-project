<?php
session_start();

require "vendor/autoload.php";

$auth=isset($_SESSION["auth"]) && $_SESSION["auth"]?true:false;

if ($auth)
{
	$db = new \Valkyrie\DB\Database();
	$userDao = $db->userDao;

	$user = $userDao->find($_SESSION["userid"]);
	$name = $user->firstName . " " . $user->lastName;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
	<link rel="manifest" href="/icon/site.webmanifest">
	<link rel="mask-icon" href="/icon/safari-pinned-tab.svg" color="#406abc">
	<link rel="shortcut icon" href="/icon/favicon.ico">
	<meta name="msapplication-TileColor" content="#f2f5fb">
	<meta name="msapplication-config" content="/icon/browserconfig.xml">
	<meta name="theme-color" content="#406abc">
	<title>Valkyrie Air</title>

	<link rel="stylesheet" href="build/style.css">

	<link rel="preconnect" href="https://lh6.googleusercontent.com/">
	<link href="search.html" rel="prefetch">
	<link href="login.php" rel="prefetch">
</head>
<body>

<div class="outer">
	<div class="splash">
		<header class="navheader">
			<nav>
				<span class="branding">
				<svg version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" x="0px"
				     y="0px" width="218.04px" height="248.82px" viewBox="0 0 218.04 248.82" xml:space="preserve">
					<g>
						<g>
							<path fill="#4A77BC" d="M200.17,49.31c-24.2,66.52-48.39,133.05-72.57,199.51c-12.49,0-24.24,0-36.59,0
								c-4.93-13.27-9.88-26.41-14.71-39.61C61.76,169.47,47.27,129.7,32.75,89.95c-4.94-13.52-12.5-33.78-17.44-47.29
								c1.27-0.01,0.98-0.01,2.62,0c17.01,0.37,34.13,2.53,50.16,9.14c20.86,8.61,35.27,23.71,41.46,48.94
								c5.75-22.41,17.09-37.05,35.51-46.07c17.62-8.63,37.9-11.75,57.54-12.01C201.75,45.44,200.64,47.57,200.17,49.31z"></path>
							<path fill="#71B6E5" d="M202.61,42.65c0,0,0,0-1.5,0.03c-19.71,0.68-38.41,3.36-56.04,11.99c-18.42,9.02-29.76,23.66-35.51,46.07
								c-6.19-25.23-20.6-40.34-41.46-48.94c-16.03-6.61-33.15-8.78-50.16-9.14c-2.07,0-0.3-0.02-2.62,0c-2.35-6.13-2.16-5.49-4.43-11.65
								C7.41,21.56,4.04,12.07,0,0.86c25.03,3.63,46.58,11.77,66.47,24.32c20.37,12.86,35.68,29.95,42.12,55.27
								C126.84,28.18,168.98,11.65,218.04,0c-2.92,8.2-4.91,13.87-6.96,19.52C207.46,29.46,206.25,32.73,202.61,42.65z"></path>
						</g>
					</g>
				</svg>
				</span>
				<ul>
					<li>
						<a class="navlink">Book & Manage</a>
					</li>
					<li>
						<a class="navlink">Prepare</a>
					</li>
				</ul>
			</nav>

			<div class="profile">
				<?php if ($auth): ?>
				<span class="username"><?= $name ?></span>
				<span class="arrow">
					<svg xmlns="http://www.w3.org/2000/svg" width="28.935" height="17.287" viewBox="0 0 28.935 17.287">
						<path id="Path_10" d="M10.682-55.529,21.667-41.54v.956L10.643-26.594H4.38L15.97-41.071,4.38-55.529Z" transform="translate(-26.594 -4.38) rotate(90)" fill="#fff"></path>
					</svg>
				</span>
				<div class="dropdown-content">
					<a href="booked.php">Manage Bookings</a>
					<a href="#" name="logout">Logout</a>
				</div>
				<?php else: ?>
				<span class="username" onclick="window.location='login.php'">Login</span>
				<?php endif; ?>
			</div>
		</header>

		<div class="carousel">
			<div class="card starter">
				<div class="info">
					<h1>Scotland</h1>
					<h2>from $599</h2>
				</div>
			</div>
		</div>
	</div>

	<div class="picker-container">
		<div class="picker">
			<h5>Find flights</h5>

			<div class="picker-content">
				<form method="get" action="search.html">
					<span class="field">
						<input type="text" name="origin" id="from"><label for="from">Origin</label>
					</span>
					<span class="field">
						<input type="text" name="destination" id="to"><label for="to">Destination</label>
					</span>
					<button class="picker-submit" type="submit">
						<span>Search</span>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path></svg>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="js/main.js"></script>
</body>
</html>