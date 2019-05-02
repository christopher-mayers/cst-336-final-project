<?php

namespace Valkyrie\DB;

use PDO;
use Valkyrie\DB\Dao\FlightDao;
use Valkyrie\DB\Dao\UserDao;

/**
 * Class Database
 * @package Valkyrie\DB
 */
class Database
{
	/**
	 * @var PDO
	 */
	private $pdo;

	/**
	 * @var FlightDao
	 */
	public $flightDao;
	/**
	 * @var UserDao
	 */
	public $userDao;

	/**
	 * Database constructor.
	 */
	public function __construct($host = null, $database = null, $username = null, $password = null)
	{
		// Establish our database connection
		if ($host === null)
			$this->pdo = Connection::getFromUrl(getenv("DATABASE_URL"));
		else if ($database === null)
			$this->pdo = Connection::getFromUrl($host);
		else
			$this->pdo = Connection::get($host, $database, $username, $password);

		// Create our DAOs for easy access to MySQL info
		$this->flightDao = new FlightDao($this->pdo);
		$this->userDao = new UserDao($this->pdo);
	}

	public static function verify($username, $password)
	{
		return ($username === getenv("ADMIN_USER")
		&& password_verify($password, getenv("ADMIN_PASS")));
	}
}