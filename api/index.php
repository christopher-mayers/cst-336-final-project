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
use Valkyrie\DB\Entity\User;

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
		$dao = $app->db->flightDao;

		$response->json($dao->findAll());
	});

	$router->respond("GET", "/search/?", function($request, $response, $service, $app)
	{
		$origin = $request->param("origin", false);
		$destination = $request->param("destination", false);
		$date = $request->param("time", false);

		if ($origin && $destination)
		{
			$dao = $app->db->flightDao;

			/** @var Valkyrie\DB\Entity\Flight[] $results */
			$results = $dao->findByLocationPair($origin, $destination);

			if ($date)
			{
				$date = new DateTime($date);
				$final = [];

				foreach ($results as $flight)
				{
					$departure = new DateTime($flight->departureTime);

					if ($departure->format("d") === $date->format("d"))
						array_push($final, $flight);
				}

				$response->code(200);
				$response->json($final);

				return;
			}

			$response->code(200);
			$response->json($results);
		}
		else
		{
			$response->code(400);
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
		$response->code(400);
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
		$response->code(404); // Not Found
		$response->json(["status" => "invalid"]);

		return;
	}

	if (password_verify($password, $user->password))
	{
		session_start();

		$_SESSION["auth"] = true;
		$_SESSION["userid"] = $user->id;

		$response->code(200); // OK
		$response->json(["status" => "accepted"]);
	}
	else
	{
		$response->code(401); // Unauthorized
		$response->json(["status" => "denied"]);
	}
});

$router->respond("POST", "/register", function($request, $response, $service, $app)
{
	if (!($request->param("name", false) && $request->param("email", false) && $request->param("password", false)))
	{
		$response->code(400); // Bad Request
		$response->json(["status" => "error"]);

		return;
	}

	/** @var \Valkyrie\DB\Dao\UserDao $userDao */
	$userDao = $app->db->userDao;

	$fullName = explode(" ", $request->param("name"));
	$firstName = $fullName[0];
	$lastName = join(" ", array_slice($fullName, 1));
	$email = $request->param("email");
	$password = $request->param("password");

	$user = $userDao->findByEmail($email);

	if ($user != null)
	{
		$response->code(409); // Conflict
		$response->json(["status" => "invalid"]);

		return;
	}

	$hash = password_hash($password, PASSWORD_BCRYPT);

	$user = new User();
	$user->email = $email;
	$user->lastName = $lastName;
	$user->firstName = $firstName;
	$user->password = $hash;

	$userDao->save($user);

	session_start();

	$_SESSION["auth"] = true;
	$_SESSION["userid"] = $user->id;

	$response->code(201); // Created
	$response->json(["status" => "accepted"]);
});

$router->dispatch($request);