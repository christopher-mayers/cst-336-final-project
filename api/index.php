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

	if ($request->headers()->get('Content-Type') === "application/json" && in_array($request->method(), ['PUT', 'POST', 'DELETE']))
	{
		$request->paramsPost()->merge(json_decode($request->body(), true));
	}
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

	if (!($request->param("email", false) && $request->param("password", false)))
	{
		$response->json(["status" => "error"]);

		return;
	}

	/** @var \Valkyrie\DB\Dao\UserDao $userDao */
	$userDao = $app->db->userDao;

	$email = $request->param("email");
	$password = $request->param("password");

	$user = $userDao->findByEmail($email);

	if ($user == null)
	{
		header("HTTP/1.1 404 Not Found");

		$response->json(["status" => "invalid"]);

		return;
	}

	if (password_verify($password, $user->password))
	{
		header("HTTP/1.1 200 OK");

		session_start();

		$_SESSION["auth"] = true;
		$_SESSION["userid"] = $user->id;

		$response->json(["status" => "accepted"]);
	}
	else
	{
		header("HTTP/1.1 403 Forbidden");

		$response->json(["status" => "denied"]);
	}
});

$router->dispatch($request);