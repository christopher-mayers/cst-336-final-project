<?php

namespace Valkyrie;
use Closure;


/**
 * Glorified switch statement for executing callbacks based on request method
 *
 * Class Route
 * @package Valkyrie
 */
class Route
{
	/**
	 * @param Closure|null $closure
	 */
	public static function get(Closure $closure = null)
	{
		if ($closure === null)
		{
			throw new \InvalidArgumentException("Closure cannot be null!");
		}

		if ($_SERVER["REQUEST_METHOD"] === "GET")
		{
			$closure($_GET);
		}
	}

	/**
	 * @param Closure|null $closure
	 */
	public static function post(Closure $closure = null)
	{
		if ($closure === null)
		{
			throw new \InvalidArgumentException("Closure cannot be null!");
		}

		if ($_SERVER["REQUEST_METHOD"] === "POST")
		{
			$closure($_POST);
		}
	}

	/**
	 * @param Closure|null $closure
	 */
	public static function put(Closure $closure = null)
	{
		if ($closure === null)
		{
			throw new \InvalidArgumentException("Closure cannot be null!");
		}

		if ($_SERVER["REQUEST_METHOD"] === "POST")
		{
			parse_str(file_get_contents("php://input"), $data);

			$closure($data);
		}
	}

	/**
	 * @param Closure|null $closure
	 */
	public static function delete(Closure $closure = null)
	{
		if ($closure === null)
		{
			throw new \InvalidArgumentException("Closure cannot be null!");
		}

		if ($_SERVER["REQUEST_METHOD"] === "DELETE")
		{
			parse_str(file_get_contents("php://input"), $data);

			$closure($data);
		}
	}
}