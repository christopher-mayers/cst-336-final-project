<?php

    require "vendor/autoload.php";
    
    use Valkyrie\DB\Database;

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $loginResult = Database::verify($username, $password);

    $result = array();

    if ($loginResult == true)
    {
        echo ("Success");
    }
    else
    {
        echo ("fail");
    }
?>