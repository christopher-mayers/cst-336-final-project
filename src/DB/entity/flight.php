<?php

namespace Valkyrie\DB\Entity;

use DateTime;

/**
 * Class Flight
 * @package Valkyrie\DB\Entity
 */
class Flight
{
	/**
	 * @var int
	 */
	public $id;
	/**
	 * @var string
	 */
	public $origin;
	/**
	 * @var string
	 */
	public $destination;
	/**
	 * @var DateTime
	 */
	public $boardingTime;
	/**
	 * @var DateTime
	 */
	public $departureTime;
	/**
	 * @var DateTime
	 */
	public $arrivalTime;
	/**
	 * @var int
	 */
	public $seats;
	/**
	 * @var float
	 */
	public $price;

	public function __construct()
	{
		if (isset($this->departureTime))
			$this->departureTime = date_create($this->departureTime);

		if (isset($this->boardingTime))
			$this->boardingTime = date_create($this->boardingTime);
	}
}