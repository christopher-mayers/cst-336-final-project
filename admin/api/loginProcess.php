<?php

    session_start();

    require "../../vendor/autoload.php";
    
    use Valkyrie\DB\Database;

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $loginResult = Database::verify($username, $password);

    if ($loginResult)
    {
        echo ("Success");
        
        $_SESSION['username'] = $username;
        header('location: ../pages/flights.php');
    }
    else
    {
        echo ("Incorrect username or password");
    }
?>