<?php
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");

require dirname(__DIR__) . "/vendor/autoload.php";

use Klein\App;
use Klein\Klein;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Valkyrie\DB\Database;
use Valkyrie\DB\Entity\User;

define("APP_PATH", "api/");

$request = Request::createFromGlobals();
$uri = $request->server()->get('REQUEST_URI');
$request->server()->set('REQUEST_URI', rtrim(substr($uri, strlen(APP_PATH)), "/"));

function GET($url, $options = null)
{
	$defaultHeader = "Content-type: application/x-www-form-urlencoded\r\n";

	if ($options === null)
		$options = [];

	$header = isset($options["header"]) ? $options["header"] : $defaultHeader;
	$queryString = isset($options["data"]) ? "?" . http_build_query($options["data"]) : "";

	$model = [
		"http" => [
			"header" => $header,
			"method" => "GET",
		]
	];

	$context = stream_context_create($model);

	return file_get_contents($url . $queryString, false, $context);
}

$router = new Klein();

$router->respond(function(Request $request, Response $response, ServiceProvider $service, App $app)
{
	$app->register("db", function()
	{
		return new Database();
	});

//	if ($request->headers()->get('Content-Type') === "application/json" && in_array($request->method(), ['PUT', 'POST', 'DELETE']))
//	{
//		$request->paramsPost()->merge(json_decode($request->body(), true));
//	}
});

$router->respond("GET", "/photo/[:city]",
function(Request $request, Response $response, ServiceProvider $service, App $app)
{
	if (!$request->city)
	{
		$response->code(400);

		return;
	}

	$result = GET("https://api.flickr.com/services/rest", [
		"data" => [
			"method" => "flickr.photos.search",
			"api_key" => "2bc0c21f9891f277dda56abd8271d28c",
			"content_type" => "1",
			"media" => "photos",
			"per_page" => 1,
			"format" => "json",
			"safe_search" => 1,
			"tags" => $request->city,
			"nojsoncallback" => 1
		]
	]);

	$data = json_decode($result, true);

	$id = $data["photos"]["photo"][0]["id"];

	$result = GET("https://api.flickr.com/services/rest", [
		"data" => [
			"method" => "flickr.photos.getSizes",
			"api_key" => "2bc0c21f9891f277dda56abd8271d28c",
			"photo_id" => $id,
			"format" => "json",
			"nojsoncallback" => 1
		]
	]);

	$data = json_decode($result, true);

	$sizes = $data["sizes"]["size"];

	foreach ($sizes as $obj)
	{
		if ($obj["label"] === "Large 1600")
		{
			$response->json(["img" => $obj["source"]]);
		}
	}
});

$router->with('/flights', function() use ($router)
{
	$router->respond("GET", '/?',
	function(Request $request, Response $response, ServiceProvider $service, App $app)
	{
		$dao = $app->db->flightDao;

		$response->json($dao->findAll());
	});

	$router->respond("GET", '/random',
	function(Request $request, Response $response, ServiceProvider $service, App $app)
	{
		$query = "
		SELECT DISTINCT destination, price FROM valkyrie_flights
		ORDER BY RAND() LIMIT 1;
		";
		$stmt = $app->db->pdo->prepare($query);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$query = "
			SELECT flights.destination, flights.price FROM valkyrie_flights AS flights
			WHERE
			      flights.price = (SELECT MIN(price) FROM valkyrie_flights WHERE destination = :destination)
			  AND
			      flights.destination = :destination;
		";
		$stmt = $app->db->pdo->prepare($query);
		$stmt->bindValue(":destination", $row["destination"]);
		$stmt->execute();

		$output = $stmt->fetch(PDO::FETCH_ASSOC);

		$result = GET("https://api.flickr.com/services/rest", [
			"data" => [
				"method" => "flickr.photos.search",
				"api_key" => "2bc0c21f9891f277dda56abd8271d28c",
				"content_type" => "1",
				"media" => "photos",
				"per_page" => 100,
				"format" => "json",
				"text" => $row["destination"],
				"sort" => "interestingness-desc",
				"nojsoncallback" => 1
			]
		]);

		$data = json_decode($result, true);

		shuffle($data["photos"]["photo"]);

		$id = $data["photos"]["photo"][0]["id"];

		$result = GET("https://api.flickr.com/services/rest", [
			"data" => [
				"method" => "flickr.photos.getSizes",
				"api_key" => "2bc0c21f9891f277dda56abd8271d28c",
				"photo_id" => $id,
				"format" => "json",
				"nojsoncallback" => 1
			]
		]);

		$data = json_decode($result, true);

		$sizes = $data["sizes"]["size"];

		$output["img"] = end($sizes)["source"];

		$response->json($output);
	});

	$router->respond("GET", "/search/?",
	function(Request $request, Response $response, ServiceProvider $service, App $app)
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
					$departure = $flight->departureTime;

					if ($departure->format("Y-m-d") === $date->format("Y-m-d"))
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

	$router->respond("GET", '/[i:id]',
	function(Request $request, Response $response, ServiceProvider $service, App $app)
	{
		$dao = $app->db->flightDao;

		$response->json($dao->find($request->id));
	});
});

$router->respond("POST", "/logout",
function(Request $request, Response $response, ServiceProvider $service, App $app)
{
	session_start();

	if (isset($_SESSION["userid"]))
	{
		$userDao = $app->db->userDao;

		$user = $userDao->find($_SESSION["userid"]);

		if ($user)
			\Valkyrie\DB\Logger::log("logout", "(" . $user->email . ":" . $user->id . ") logged out");
	}

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

$router->respond("POST", "/login",
function(Request $request, Response $response, ServiceProvider $service, App $app)
{
	session_start();

	$email = $request->server()->get("PHP_AUTH_USER");
	$password = $request->server()->get("PHP_AUTH_PW");

	if (!($email && $password))
	{
		$response->code(400);
		$response->json(["status" => "error"]);

		return;
	}

	/** @var \Valkyrie\DB\Dao\UserDao $userDao */
	$userDao = $app->db->userDao;

	$user = $userDao->findByEmail($email);

	if ($user == null)
	{
		$response->code(404); // Not Found

		$response->json(["status" => "invalid"]);

		return;
	}

	if (password_verify($password, $user->password))
	{
		$_SESSION["auth"] = true;
		$_SESSION["userid"] = $user->id;

		$response->code(200); // OK

		\Valkyrie\DB\Logger::log("login", "(" . $user->email . ":" . $user->id . ") logged in");

		if (isset($_SESSION["checkout"]))
			$response->json(["status" => "accepted", "redirect" => "checkout.php"]);
		else
			$response->json(["status" => "accepted"]);
	}
	else
	{
		$response->code(401); // Unauthorized
		$response->json(["status" => "denied"]);
	}
});

$router->respond("POST", "/register",
function(Request $request, Response $response, ServiceProvider $service, App $app)
{
	session_start();

	$email = $request->server()->get("PHP_AUTH_USER");
	$password = $request->server()->get("PHP_AUTH_PW");

	if (!($request->param("name", false) && $email && $password))
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

	$_SESSION["auth"] = true;
	$_SESSION["userid"] = $user->id;

	$response->code(201); // Created

	\Valkyrie\DB\Logger::log("register", "(" . $user->email . ":" . $user->id . ") registered");

	if (isset($_SESSION["checkout"]))
		$response->json(["status" => "accepted", "redirect" => "checkout.php"]);
	else
		$response->json(["status" => "accepted"]);
});

$router->respond("POST", "/precheckout",
function(Request $request, Response $response, ServiceProvider $service, App $app)
{
	session_start();

	$flightDao = $app->db->flightDao;
	$flightId = $request->param("flight", false);
	$flight = $flightDao->find($flightId);

	if (!$flightId || !$flight)
	{
		$response->code(400);

		return;
	}

	$response->code(200);
	$_SESSION["checkout"] = $flightId;
});

$router->respond("POST", "/checkout",
function(Request $request, Response $response, ServiceProvider $service, App $app)
{
	/**
	 * @var \Klein\Request $request
	 * @var \Klein\Response $response
	 * @var \Klein\ServiceProvider $service
	 * @var \Klein\App $app
	 */

	session_start();

	if (!isset($_SESSION["checkout"]) || !isset($_SESSION["auth"]))
	{
		$response->code(400);
		$response->json(["status" => "denied"]);

		return;
	}

	$db = $app->db;
	$flightDao = $db->flightDao;
	$userDao = $db->userDao;
	$flightId = $_SESSION["checkout"];
	$flight = $flightDao->find($flightId);

	$user = $userDao->find($_SESSION["userid"]);

	if (!$flight)
	{
		$response->code(400);
		$response->json(["status" => "denied"]);

		return;
	}

	$response->code(200);
	$response->json(["status" => "accepted"]);

	$query = "
	INSERT INTO valkyrie_bookings
		(flight, user)
	VALUES
		(:flightId, :userId)
	";

	$stmt = $db->pdo->prepare($query);
	$stmt->bindParam(":flightId", $flight->id);
	$stmt->bindParam(":userId", $user->id);
	$stmt->execute();

	unset($_SESSION["checkout"]);

	\Valkyrie\DB\Logger::log("purchase", "(" . $user->email . ":" . $user->id . ") purchased ticket for flight " . $flightId);
});

$router->respond("POST", "/cancel",
function(Request $request, Response $response, ServiceProvider $service, App $app)
{
	/**
	 * @var \Klein\Request $request
	 * @var \Klein\Response $response
	 * @var \Klein\ServiceProvider $service
	 * @var \Klein\App $app
	 */

	session_start();

	$flightId = $request->param("flight", false);

	if (!$flightId)
	{
		$response->code(400);
		$response->json(["status" => "denied"]);

		return;
	}

	if (!isset($_SESSION["auth"]))
	{
		$response->code(403);
		$response->json(["status" => "denied"]);

		return;
	}

	$db = $app->db;
	$flightDao = $db->flightDao;
	$userDao = $db->userDao;

	$flight = $flightDao->find($flightId);
	$user = $userDao->find($_SESSION["userid"]);

	if (!$flight)
	{
		$response->code(404);
		$response->json(["status" => "invalid"]);

		return;
	}

	$response->code(200);
	$response->json(["status" => "accepted"]);

	$query = "
	DELETE FROM valkyrie_bookings
	WHERE flight=:id
	LIMIT 1
	";

	$stmt = $db->pdo->prepare($query);
	$stmt->bindParam(":id", $flightId);
	$stmt->execute();

	\Valkyrie\DB\Logger::log("cancellation", "(" . $user->email . ":" . $user->id . ") canceled reservation for flight " . $flightId);
});

$router->dispatch($request);