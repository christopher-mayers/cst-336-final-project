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

$database = new Database();

$dao = $database->flightDao; // your top variable set as static

$arr = array();

$arr = json_encode($dao->findAll());

$arr2 = json_decode($arr, true);

?>


<!DOCTYPE html>
<html>
    <head>
        <title> All Flights</title>
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
    </head>
    <body>

        <div id = "flightInfo"><?php
        
        for ($i = 0; $i < count($arr2); $i++)
        {
            echo "Flight ID: " . $arr2[$i]['id'];
            echo ("<br>");
            echo "Flight Origin: " . $arr2[$i]['origin'];
            echo ("<br>");
            echo "Flight Destination: " . $arr2[$i]['destination'];
            echo ("<br>");
            echo "Boarding Time: " . $arr2[$i]['boardingTime'];
            echo ("<br>");
            echo "Depature Time: " . $arr2[$i]['departureTime'];
            echo ("<br>");
            echo "Arrival Time: " . $arr2[$i]['arrivalTime'];
            echo ("<br>");
            echo "Seats on Flight: " . $arr2[$i]['seats'];
            echo ("<br>");
            echo "Ticket Price: $" . $arr2[$i]['price'];

            echo ("<hr>");
            echo ("<br>");
        }
    
        ?></h1>
        
        <form method="POST" action="flights.php"/>
        
           
            <input id = "submitBtn" type="submit" value="Done!"/>
            
        </form>

    </body>
</html>