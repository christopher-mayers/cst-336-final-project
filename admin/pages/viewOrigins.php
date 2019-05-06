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
        <link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon.png">
    	<link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
    	<link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
    	<link rel="manifest" href="/icon/site.webmanifest">
    	<link rel="mask-icon" href="/icon/safari-pinned-tab.svg" color="#406abc">
    	<link rel="shortcut icon" href="/icon/favicon.ico">
    	<meta name="msapplication-TileColor" content="#f2f5fb">
    	<meta name="msapplication-config" content="/icon/browserconfig.xml">
    	<meta name="theme-color" content="#406abc">
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