<?php

namespace Valkyrie\DB;

use PDO;

use Dotenv\Dotenv;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

function getDatabaseConnection()
{
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$host = $url["host"];
	$dbname = substr($url["path"], 1);
	$username = $url["user"];
	$password = $url["pass"];

	//creates db connection
	$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

	//display errors when accessing tables
	$dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $dbConn;
}