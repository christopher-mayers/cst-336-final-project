<!DOCTYPE html>
<html>
    <head>
        <title>Flight Management</title>
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
        
        <br></br>
        
        <form method="POST" action="../api/logoutProcess.php"/>
        
           
            <input id = "submitBtn" type="submit" value="Logout"/>
            
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