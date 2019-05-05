<!DOCTYPE html>
<html>
    <head>
        <title>Flight Management</title>
    </head>
    <body>
        
         <form method="POST" action="addFlight.php"/>
        
           
            <input id = "submitBtn" type="submit" value="Add a Flight!"/>
            
        </form>
        
          <form method="POST" action="deleteFlight.php"/>
        
           
            <input id = "submitBtn" type="submit" value="Delete a Flight!"/>
            
        </form>
        
          <form method="POST" action="viewAllFlights.php"/>
        
           
            <input id = "submitBtn" type="submit" value="View All Flights!"/>
            
        </form>
        
          <form method="POST" action="updateFlight.php"/>
        
           
            <input id = "submitBtn" type="submit" value="Update a Flight!"/>
            
        </form>
        
    </body>
</html>

<?php

session_start();

if (!isset ($_SESSION['username']))
{
    header('Location: ../login.html');
}

?>