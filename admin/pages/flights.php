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
        
        <form method="POST" action="viewOrigins.php"/>
        
           
            <input id = "submitBtn" type="submit" value="View All Flight Origins!"/>
            
        </form>
        
          <form method="POST" action="viewDestinations.php"/>
        
           
            <input id = "submitBtn" type="submit" value="View All Flight Destinations!"/>
            
        </form>
        
        <form method="POST" action="getLogs.php"/>
        
           
            <input id = "submitBtn" type="submit" value="View All Logged Actions!"/>
            
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