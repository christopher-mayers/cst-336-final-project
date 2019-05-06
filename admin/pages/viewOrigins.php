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

$query = $pdo->prepare("SELECT DISTINCT origin FROM valkyrie_flights");
$query->execute();
$arr = array();
$arr = ($query->fetchAll());

?>

<!DOCTYPE html>
<html>
    <head>
        <title> All Flight Origins</title>
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
    </head>
    <body>
        
        <h1>All Flight Origins</h1>

        <?php
        
        for ($i = 0; $i < count($arr); $i++)
        {
            echo $arr[$i]['origin'] . "<br>";
        }
        ?>
        
        <br></br>
        
        <form method="POST" action="flights.php"/>
        
           
            <input id = "submitBtn" type="submit" value="Done!"/>
            
        </form>

    </body>
</html>