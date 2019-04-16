<?php /** @noinspection SqlWithoutWhere */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlResolve */

namespace Valkyrie\DB\Dao;

use PDO;
use Valkyrie\DB\Entity\User;

/**
 * Class FlightDao
 */
class FlightDao
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
		$this->table = getenv("FLIGHT_TABLE");
		$this->pdo = $pdo;
	}

	/**
	 * @return User|null
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
	 * @return User[]
	 */
	public function findAll()
	{
		$query = "SELECT * FROM {$this->table}";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, User::class);

		return $stmt->fetchAll();
	}

	/**
	 * @param User $flight
	 * @return bool
	 */
	public function update(User $flight)
	{
		if (!isset($flight->id))
		{
			throw new \LogicException("Cannot update flight which does not exist in database!");
		}

		$query = "
		UPDATE {$this->table}
		SET
			origin = :origin,
		  	destination = :destination,
		  	boardingTime = :boardingTime,
		  	departureTime = :departureTime,
		  	seats = :seats
		WHERE id = :id
		";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":id", $flight->id, PDO::PARAM_INT);
		$stmt->bindParam(":origin", $flight->origin);
		$stmt->bindParam(":destination", date("Y-m-d H:i:s", $flight->destination));
		$stmt->bindParam(":boardingTime", date("Y-m-d H:i:s", $flight->boardingTime));
		$stmt->bindParam(":departureTime", $flight->departureTime);
		$stmt->bindParam(":seats", $flight->seats, PDO::PARAM_INT);

		return $stmt->execute();
	}

	/**
	 * @param User $flight
	 * @return bool
	 */
	public function save(User $flight)
	{
		if (isset($flight->id))
		{
			return $this->update($flight);
		}

		$query = "
		INSERT INTO {$this->table}
			(origin, destination, boardingTime, departureTime, seats)
		VALUES
			(:origin, :destination, :boardingTime, :departureTime, :seats)
		";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":origin", $flight->origin);
		$stmt->bindParam(":destination", date("Y-m-d H:i:s", $flight->destination));
		$stmt->bindParam(":boardingTime", date("Y-m-d H:i:s", $flight->boardingTime));
		$stmt->bindParam(":departureTime", $flight->departureTime);
		$stmt->bindParam(":seats", $flight->seats, PDO::PARAM_INT);

		$result = $stmt->execute();

		$flight->id = $this->pdo->lastInsertId();

		return $result;
	}

	/**
	 * @param User $flight
	 * @return bool
	 */
	public function delete(User $flight)
	{
		if (!isset($flight->id))
		{
			throw new \LogicException("Cannot delete flight which does not exist in database!");
		}

		$query = "DELETE FROM {$this->table} WHERE id = :id";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":id", $flight->id);

		return $stmt->execute();
	}
}