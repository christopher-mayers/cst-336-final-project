<?php

namespace Valkyrie\DB\Entity;

use PDO;

/**
 * Class User
 */
class User
{
	/**
	 * @var string
	 */
	private $table;
	/**
	 * @var PDO
	 */
	private $pdo;

	public function __construct($pdo)
	{
		$this->table = getenv("USER_TABLE");
		$this->pdo = $pdo;
	}

	/**
	 * @return User
	 */
	public function find($id)
	{
		$query = "SELECT * FROM {$this->table} WHERE id=:id LIMIT 1";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([":id" => $id]);
		$stmt->setFetchMode(PDO::FETCH_CLASS, "User");

		return $stmt->fetch();
	}

	/**
	 * @return User[]
	 */
	public function findAll()
	{
		$query = "SELECT * FROM {$this->table}";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, "User");

		return $stmt->fetchAll();
	}
}