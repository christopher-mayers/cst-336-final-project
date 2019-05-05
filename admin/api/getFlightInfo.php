<?php

session_start();

if (!isset ($_SESSION['username']))
{
    header('Location: ../login.html');
}

require "../../vendor/autoload.php";
    
use Valkyrie\DB\Database;

$id = $_GET['flightNum'];

$database = new Database;

//$flight = new Flight();

$dao = $database->flightDao;

echo json_encode($dao->find($id));

?>