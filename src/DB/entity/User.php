<?php

namespace Valkyrie\DB\Entity;


/**
 * Class User
 * @package Valkyrie\DB\Entity
 */
class User
{
	/**
	 * @var int
	 */
	public $id;
	/**
	 * @var string
	 */
	public $firstName;
	/**
	 * @var string
	 */
	public $lastName;
	/**
	 * @var string
	 */
	public $email;
	/**
	 * @var string
	 */
	public $password;
	public $flights;
}