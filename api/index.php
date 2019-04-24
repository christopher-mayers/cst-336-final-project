<?php
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");

require dirname(__DIR__) . "/vendor/autoload.php";

define("APP_PATH", "api/");

$request = \Klein\Request::createFromGlobals();
$uri = $request->server()->get('REQUEST_URI');
$request->server()->set('REQUEST_URI', rtrim(substr($uri, strlen(APP_PATH)), "/"));

/*
 * These are your callbacks for when a specific request is made to this page.
 * Depending on what kind of method was used, one of these callbacks will activate.
 *
 * If you need the user to be authenticated, use session_start() INSIDE the callback function, then check
 * $_SESSION stuff like normal.
 *
 * Put the appropriate logic inside each.
 *
 * GET    — Get all flights. If $data["id"] exists, then they want a specific flight!
 *            Consider checking if parameters like "origin" and "destination" are passed,
 *            so you can get a flight that way.
 * POST   — Someone wants to add a new flight!
 * PUT    — Someone wants to update an existing flight!
 * DELETE — YES
 */

use Klein\Klein;
use Valkyrie\DB\Database;

$router = new Klein();

$router->respond(function($request, $response, $service, $app)
{
	$app->register("db", function()
	{
		return new Database();
	});
});

$router->with('/flights', function() use ($router)
{
	$router->respond("GET", '/?', function($request, $response, $service, $app)
	{
		$range = $request->param("range");

		if ($range)
		{
			return;
		}
		else
		{
			$dao = $app->db->flightDao;

			$response->json($dao->findAll());
		}
	});

	$router->respond("GET", '/[i:id]', function($request, $response)
	{
		return "Hi, " . $request->id;
	});
});

$router->respond("POST", "/logout", function()
{
	session_start();

	$_SESSION = [];

	if (ini_get("session.use_cookies"))
	{
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	session_destroy();
});

$router->respond("POST", "/login", function($request, $response, $service, $app)
{
	/** @var \Valkyrie\DB\Dao\UserDao $userDao */
	$userDao = $app->db->userDao;

	$user = $userDao->findByEmail($request->email);

	if ($user == null)
	{
		header("HTTP/1.1 404 Not Found");

		$response->json(["status" => "invalid"]);

		die();
	}

	if (password_verify($request->password, $user->password))
	{
		header("HTTP/1.1 200 OK");

		session_start();

		$_SESSION["auth"] = true;
		$_SESSION["userid"] = $user->id;

		$response->json(["status" => "accepted"]);

		die();
	}
	else
	{
		header("HTTP/1.1 403 Forbidden");

		$response->json(["status" => "denied"]);

		die();
	}
});

$router->dispatch($request);