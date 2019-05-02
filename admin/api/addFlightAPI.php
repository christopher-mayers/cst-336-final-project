<?php

session_start();

if (!isset ($_SESSION['username']))
{
    header('Location: ../login.html');
}

require "../../vendor/autoload.php";
    
use Valkyrie\DB\Dao\FlightDao;
use Valkyrie\DB\Database;
use Valkyrie\DB\entity\flight;

$database = new Database;

$dao = $database->flightDao;

$origin = $_POST['origin'];
$destination = $_POST['destination'];
$boardingTime = $_POST['boardingTime'];
$boardingDay = $_POST['boardingDay'];
$departureTime = $_POST['departureTime'];
$departureDay = $_POST['departureDay'];
$arrivalTime = $_POST['arrivalTime'];
$arrivalDay = $_POST['arrivalDay'];
$seats = $_POST['seats'];
$price = $_POST['price'];

$boardingDay .= " " . $boardingTime;
$departureDay .= " " . $departureTime;
$arrivalDay .= " " . $arrivalTime;

$flight = new Flight();
$flight->origin = $origin;
$flight->destination = $destination;
$flight->seats = $seats;
$flight->boardingTime = new DateTime($boardingDay);
$flight->departureTime = new DateTime($departureDay);
$flight->arrivalTime = new DateTime($arrivalDay);
$flight->price= $price;

$dao->save($flight);

?>