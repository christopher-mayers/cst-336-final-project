<?php /** @noinspection SqlWithoutWhere */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlResolve */

namespace Valkyrie\DB\Dao;

use PDO;
use Valkyrie\DB\Entity\Flight;

/**
 * Class FlightDao
 * @package Valkyrie\DB\Dao
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
	 * @param int $id
	 * @return Flight|false
	 */
	public function find($id)
	{
		$query = "SELECT * FROM {$this->table} WHERE id=:id LIMIT 1";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, Flight::class);

		return $stmt->fetch();
	}

	/**
	 * Finds all flights which match the given origin and destination.
	 *
	 * @param string $origin
	 * @param string $destination
	 * @return Flight|false A Flight object if the flight exists, false otherwise.
	 */
	public function findByLocationPair($origin, $destination)
	{
		$query = "SELECT * FROM {$this->table} WHERE origin=:origin AND destination=:destination";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":origin", $origin);
		$stmt->bindParam(":destination", $destination);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, Flight::class);

		return $stmt->fetch();
	}

	/**
	 * Fetch every flight in the database. Depending on how many flights are present, it would be wise to not use this.
	 * Use a custom query with "LIMIT offset,count" for paging.
	 *
	 * @return Flight[] All flights in the database.
	 */
	public function findAll()
	{
		$query = "SELECT * FROM {$this->table}";

		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, Flight::class);

		return $stmt->fetchAll();
	}

	/**
	 * Update an existing flight in the database.
	 *
	 * @param Flight $flight
	 * @return bool
	 */
	public function update(Flight $flight)
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
		$stmt->bindParam(":destination", $flight->destination);
		$stmt->bindValue(":boardingTime", $flight->boardingTime->format("Y-m-d H:i:s"));
		$stmt->bindValue(":departureTime", $flight->departureTime->format("Y-m-d H:i:s"));
		$stmt->bindParam(":seats", $flight->seats, PDO::PARAM_INT);

		return $stmt->execute();
	}

	/**
	 * Saves a flight to the database.
	 * If the flight object has no ID, this assumes it is a new object and will insert it into the database.
	 *
	 * @param Flight $flight
	 * @return bool True if the operation was successful, false otherwise.
	 */
	public function save(Flight $flight)
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
		$stmt->bindParam(":destination", $flight->destination);
		$stmt->bindValue(":boardingTime", $flight->boardingTime->format("Y-m-d H:i:s"));
		$stmt->bindValue(":departureTime", $flight->departureTime->format("Y-m-d H:i:s"));
		$stmt->bindParam(":seats", $flight->seats, PDO::PARAM_INT);

		$result = $stmt->execute();

		$flight->id = $this->pdo->lastInsertId();

		return $result;
	}

	/**
	 * @param Flight $flight
	 * @return bool
	 */
	public function delete(Flight $flight)
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