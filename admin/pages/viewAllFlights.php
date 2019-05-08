<?php
session_start();

if (!isset ($_SESSION['username']))
{
    header('Location: ../login.html');
}

require "../../vendor/autoload.php";
    
use Valkyrie\DB\Dao\FlightDao;
use Valkyrie\DB\Database;
use Valkyrie\DB\Entity\Flight;

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
        <link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon.png">
    	<link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
    	<link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
    	<link rel="manifest" href="/icon/site.webmanifest">
    	<link rel="mask-icon" href="/icon/safari-pinned-tab.svg" color="#406abc">
    	<link rel="shortcut icon" href="/icon/favicon.ico">
    	<meta name="msapplication-TileColor" content="#f2f5fb">
    	<meta name="msapplication-config" content="/icon/browserconfig.xml">
    	<meta name="theme-color" content="#406abc">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
            echo "Boarding Time: " . $arr2[$i]['boardingTime']['date'];
            echo ("<br>");
            echo "Depature Time: " . $arr2[$i]['departureTime']['date'];
            echo ("<br>");
            echo "Arrival Time: " . $arr2[$i]['arrivalTime']['date'];
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