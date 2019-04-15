<?php

namespace Valkyrie\DB\Entity;

/**
 * Class Flight
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
	 * @var int
	 */
	public $seats;
}