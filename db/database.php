<?php

include "connection.php";

class Database
{
	private $pdo;

	public $flightDao;
	public $userDao;
	public $logDao;

	public function __construct()
	{
		$this->pdo = getDatabaseConnection();
		$this->flightDao = new FlightDao($this->pdo);
		$this->userDao = new UserDao($this->pdo);
		$this->logDao = new LogDao($this->pdo);
	}
}