<?php

namespace Valkyrie\DB;

use PDO;
use Valkyrie\DB\Dao\FlightDao;

/**
 * Class Database
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
	 * @var LogDao
	 */
	public $logDao;

	/**
	 * Database constructor.
	 */
	public function __construct()
	{
		// Establish our database connection to Heroku
		$this->pdo = Connection::get();

		// Create our DAOs for easy access to MySQL info
		$this->flightDao = new FlightDao($this->pdo);
//		$this->userDao = new UserDao($this->pdo);
//		$this->logDao = new LogDao($this->pdo);
	}
}