<?php /** @noinspection SqlWithoutWhere */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlResolve */

namespace Valkyrie\DB\Dao;

use PDO;
use Valkyrie\DB\Entity\User;

/**
 * Class UserDao
 * @package Valkyrie\DB\Dao
 */
class UserDao
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
	 * @param int $id
	 * @return User|false A User object if the user exists, false otherwise.
	 */
	public function find($id)
	{
		$query = "SELECT * FROM {$this->table} WHERE id=:id LIMIT 1";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, User::class);

		return $stmt->fetch();
	}

	/**
	 * @param string $email The email to search for.
	 * @return User|false A User object if the user exists, false otherwise.
	 */
	public function findByEmail($email)
	{
		$query = "SELECT * FROM {$this->table} WHERE email=:email LIMIT 1";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":email", $email);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, User::class);

		return $stmt->fetch();
	}

	/**
	 * Fetch every user in the database. Depending on how many users are present, it would be wise to not use this.
	 * Use a custom query with "LIMIT offset,count" for paging.
	 *
	 * @return User[] All users in the database.
	 */
	public function findAll()
	{
		$query = "SELECT * FROM {$this->table}";

		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, User::class);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function update(User $user)
	{
		if (!isset($user->id))
		{
			throw new \LogicException("Cannot update user which does not exist in database!");
		}

		$query = "
		UPDATE {$this->table}
		SET
			last_name = :lastName,
			first_name = :firstName,
			email = :email,
			password = :password
		WHERE id = :id
		";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":id", $user->id, PDO::PARAM_INT);
		$stmt->bindParam(":lastName", $user->lastName);
		$stmt->bindParam(":firstName", $user->firstName);
		$stmt->bindParam(":email", $user->email);
		$stmt->bindParam(":password", $user->password);

		return $stmt->execute();
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function save(User $user)
	{
		if (isset($user->id))
		{
			return $this->update($user);
		}

		$query = "
		INSERT INTO {$this->table}
			(last_name, first_name, email, password)
		VALUES
			(:lastName, :firstName, :email, :password)
		";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":lastName", $user->lastName);
		$stmt->bindParam(":firstName", $user->firstName);
		$stmt->bindParam(":email", $user->email);
		$stmt->bindParam(":password", $user->password);

		$result = $stmt->execute();

		$user->id = $this->pdo->lastInsertId();

		return $result;
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function delete(User $user)
	{
		if (!isset($user->id))
		{
			throw new \LogicException("Cannot delete user which does not exist in database!");
		}

		$query = "DELETE FROM {$this->table} WHERE id = :id";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":id", $user->id);

		return $stmt->execute();
	}
}