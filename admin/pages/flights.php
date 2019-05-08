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
      	<!--bootstrap-->
      	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <h3>Flight Management</h3><br>
         <form method="POST" action="addFlight.php"/>
        
           <button type="button" id = "submitBtn" class="btn btn-primary">Add a Flight!</button>

            <!--<input id = "submitBtn" type="submit" value="Add a Flight!"/>-->
            
        </form><br>
        
          <form method="POST" action="deleteFlight.php"/>
        
           <button type="button" id = "submitBtn" class="btn btn-info">Delete a Flight!</button>

            <!--<input id = "submitBtn" type="submit" value="Delete a Flight!"/>-->
            
        </form><br>
        
          <form method="POST" action="viewAllFlights.php"/>
        
           <button type="button" id = "submitBtn" class="btn btn-info">View All Flights!</button>

            <!--<input id = "submitBtn" type="submit" value="View All Flights!"/>-->
            
        </form><br>
        
          <form method="POST" action="updateFlight.php"/>
        
          <button type="button" id = "submitBtn" class="btn btn-primary">Update a Flight!</button>

          <!--<input id = "submitBtn" type="submit" value="Update a Flight!"/>-->
            
        </form><br>
        
        <form method="POST" action="viewOrigins.php"/>
            
         <button type="button" id = "submitBtn" class="btn btn-primary">View All Flight Origins!</button>

            <!--<input id = "submitBtn" type="submit" value="View All Flight Origins!"/>-->
            
        </form><br>
        
          <form method="POST" action="viewDestinations.php"/>
        
           <button type="button" id = "submitBtn" class="btn btn-info">View All Flight Destinations</button>

            <!--<input id = "submitBtn" type="submit" value="View All Flight Destinations!"/>-->
            
        </form><br>
        
        <form method="POST" action="getLogs.php"/>
        
                      <button id = "submitBtn" type="button" class="btn btn-info">View All Logged Actions!</button>

            <!--<input id = "submitBtn" type="submit" value="View All Logged Actions!"/>-->
            
        </form><br>
        
        <br></br>
        
        <form method="POST" action="../api/logoutProcess.php"/>
        
           <button type="button" id = "submitBtn" class="btn btn-primary">Submit</button>

            <!--<input id = "submitBtn" type="submit" value="Logout"/>-->
            
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