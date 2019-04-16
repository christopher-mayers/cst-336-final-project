<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Valkyrie\Route;

header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");

/*
 * These are your callbacks for when a specific request is made to this page.
 * Depending on what kind of method was used, one of these callbacks will activate.
 *
 * Put the appropriate logic inside each.
 * $data contains all the data passed to the API, whether it be $_GET parameters from the url,
 * or $_POST variables.
 *
 * GET    — Get all flights. If $data["id"] exists, then they want a specific flight!
 *            Consider checking if parameters like "origin" and "destination" are passed,
 *            so you can get a flight that way.
 * POST   — Someone wants to add a new flight!
 * PUT    — Someone wants to update an existing flight!
 * DELETE — YES
 */

Route::get(function($data)
{
	echo "Get request!<br/>";
	echo json_encode($data);
});

Route::post(function($data)
{
	echo "Post request!<br/>";
	echo json_encode($data);
});

Route::put(function($data)
{
	echo "Put request!<br/>";
	echo json_encode($data);
});

Route::delete(function($data)
{
	echo "Delete request!<br/>";
	echo json_encode($data);
});