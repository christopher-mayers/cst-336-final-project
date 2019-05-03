<?php
session_start();

require "vendor/autoload.php";

$auth=isset($_SESSION["auth"]) && $_SESSION["auth"]?true:false;

if (!$auth)
{
	header("location: login.php");

	die();
}

$db = new \Valkyrie\DB\Database();
$flightDao = $db->flightDao;

if (isset($_SESSION["checkout"]))
	$flight = $flightDao->find($_SESSION["checkout"]);

// We didn't find a flight, they should be barred from the page
if (!$flight)
{
	header("location: index.php");

	die();
}

$ticketPrice = sprintf("%01.2f", $flight->price);
$tax = sprintf("%01.2f", $flight->price * 0.1);
$total = sprintf("%01.2f", $flight->price * 1.1);
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
	<title>Valkyrie Air - Checkout</title>

	<link rel="stylesheet" href="https://use.typekit.net/peh1sjo.css">
	<link rel="stylesheet" href="build/checkout.css">

	<link href="search.html" rel="prefetch">
	<link href="index.php" rel="prefetch">
</head>
<body>

<div class="content">
	<div class="heading">
		<h1>Booking Summary</h1>
	</div>
	<div class="sections">
		<div class="subsection fee">
			<table>
				<tbody>
				<tr>
					<td>
						<span class="subtle">Regular Fare — 1 Adult</span>
					</td>
					<td>
						<span class="subtle">$ <?= $ticketPrice ?></span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtle"><?= $flight->origin ?> → <?= $flight->destination ?></span>
					</td>
					<td>

					</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="subsection subtotal">
			<table>
				<tbody>
				<tr>
					<td>
						<span class="main">Subtotal</span>
					</td>
					<td>
						<span class="main">$ <?= $ticketPrice ?></span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtle">Tax</span>
					</td>
					<td>
						<span class="subtle">$ <?= $tax ?></span>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="total">
			<table>
				<tbody>
				<tr>
					<td>
						<span class="main">Total </span><span class="subtle">USD</span>
					</td>
					<td>
						<span class="important"><?= $total ?></span>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="buttons">
		<button class="submit" id="pay">
			<span>Make payment</span>
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
		</button>
	</div>
</div>

<script src="js/checkout.js"></script>
</body>
</html>
