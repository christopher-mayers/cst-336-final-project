<?php

namespace Valkyrie\DB;


class Logger
{
	private static $instance;
	private $table = "valkyrie_logs";
	private $connection;

	private function __construct()
	{
		$this->connection = Connection::getFromUrl(getenv("DATABASE_URL"));
	}

	public static function log($action, $details)
	{
		$instance = self::get();
		$pdo = $instance->connection;

		$query = "
		INSERT INTO {$instance->table}
			(timestamp, action, details)
		VALUES
			(NOW(), :action, :details)
		";

		$stmt = $pdo->prepare($query);
		$stmt->bindParam(":action", $action);
		$stmt->bindParam(":details", $details);

		$stmt->execute();
	}

	public static function get()
	{
		if (self::$instance == null)
		{
			self::$instance = new Logger();
		}

		return self::$instance;
	}
}