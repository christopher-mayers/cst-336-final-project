<?php

namespace Valkyrie\DB;
use PDO;

/**
 * Class Connection
 * @package Valkyrie\DB
 */
class Connection
{
	/**
	 * @param string $url
	 * @return PDO
	 */
	public static function getFromUrl($url)
	{
		$url = parse_url($url);
		$host = $url["host"];
		$database = substr($url["path"], 1);
		$username = $url["user"];
		$password = $url["pass"];

		$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $pdo;
	}

	/**
	 * @param string $host
	 * @param string $database
	 * @param string $username
	 * @param string $password
	 * @return PDO
	 */
	public static function get($host, $database, $username, $password)
	{
		$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $pdo;
	}
}