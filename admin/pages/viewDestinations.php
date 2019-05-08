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

$pdo = $database->pdo;

$query = $pdo->prepare("SELECT DISTINCT destination FROM valkyrie_flights");
$query->execute();
$arr = array();
$arr = ($query->fetchAll());

?>

<!DOCTYPE html>
<html>
    <head>
        <title> All Flight Destinations</title>
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
        
        <h1>All Flight Destinations</h1>

        <?php
        
        for ($i = 0; $i < count($arr); $i++)
        {
            echo $arr[$i]['destination'] . "<br>";
        }
        ?>
        
        <br></br>
        
        <form method="POST" action="flights.php"/>
        
           <!--<button type="button" id = "submitBtn" class="btn btn-warning">Done!</button>-->

            <input id = "submitBtn" type="submit" value="Done!" class="btn btn-warning"/>
            
        </form>

    </body>
</html>