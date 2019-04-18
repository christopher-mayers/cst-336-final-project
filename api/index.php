<?php
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");

require dirname(__DIR__) . "/vendor/autoload.php";

define("APP_PATH", "valkyrie/api/");

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

$router->dispatch($request);