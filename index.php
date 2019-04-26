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
	<title>Valkyrie Air</title>

	<link rel="stylesheet" href="build/style.css">

	<link rel="preconnect" href="https://lh6.googleusercontent.com/">
	<link href="search.html" rel="prefetch">
	<link href="login.php" rel="prefetch">

	<script src="https://cdn.jsdelivr.net/npm/animejs@3.0.1/lib/anime.min.js"></script>
	<script src="js/main.js"></script>
</head>
<body>

<div class="outer">
	<div class="splash">
		<header class="navheader">
			<nav>
				<span class="branding">
					<!--<svg xmlns="http://www.w3.org/2000/svg" width="82.35" height="85.522" viewBox="0 0 82.35 85.522">-->
						<!--<path id="Path_1" data-name="Path 1" d="M2.623,0,41.175-85.522H22.265L.061-36.966-22.265-85.522h-18.91L-2.5,0Z" transform="translate(41.175 85.522)" fill="#fff"/>-->
					<!--</svg>-->
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
						<path id="Path_10" data-name="arrow" d="M10.682-55.529,21.667-41.54v.956L10.643-26.594H4.38L15.97-41.071,4.38-55.529Z" transform="translate(-26.594 -4.38) rotate(90)" fill="#fff"/>
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
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>

</body>
</html>