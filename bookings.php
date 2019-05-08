<?php
session_start();

require "vendor/autoload.php";

$auth=isset($_SESSION["auth"]) && $_SESSION["auth"]?true:false;

if ($auth)
{
	$db = new \Valkyrie\DB\Database();
	$userDao = $db->userDao;

	$user = $userDao->find($_SESSION["userid"]);
}
else
{
	header("location: login.php");
	die();
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

	<link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
	<link rel="stylesheet" href="build/bookings.css">

	<link href="login.php" rel="prefetch">

	<template id="flight-card">
		<div class="card-table">
			<div class="card-info">
				<div class="card-header card-number">
					<span></span>
				</div>
				<div class="card-header card-airline">
					<span>Valkyrie Airline Flight</span>
				</div>
				<div class="card-header card-time">
					<div class="card-time-container">
						<svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
							<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
							<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
						</svg>
						<span></span>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="card-data card-departure">
					<span></span>
				</div>
				<div class="card-data card-decor">
				</div>
				<div class="card-data card-arrival">
					<span></span>
				</div>
			</div>
		</div>
		<div class="card-button">
			<div class="button-price" role="button">
				<span class="price-content">Cancel Flight</span>
				<span class="arrow">
					<svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path></svg>
				</span>
			</div>
		</div>
	</template>
</head>
<body>

<header>
	<div class="gutter sky item">
		<a class="nav" href="index.php">
			<svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path></svg>
		</a>
	</div>
	<h1>My bookings</h1>
</header>

<div class="flight-list" data-simplebar>
	<?php foreach ($user->flights as $index=>$flight): ?>
		<flight-card
				index="<?= $index + 1 ?>"
				departure-time="<?= $flight->departureTime->format("Y-m-d H:i:s") ?>"
				arrival-time="<?= $flight->arrivalTime->format("Y-m-d H:i:s") ?>"
				flight="<?= $flight->id ?>"
				origin="<?= $flight->origin ?>"
				destination="<?= $flight->destination ?>">
		</flight-card>
	<?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
<script src="https://momentjs.com/downloads/moment.min.js"></script>
<script src="js/bookings.js"></script>
</body>
</html>