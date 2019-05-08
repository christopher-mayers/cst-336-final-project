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

$id = $_GET['flightNum'];

$database = new Database;

$dao = $database->flightDao;

$flight = new Flight();

$flight->id=$id;

$dao->delete($flight);

?>
