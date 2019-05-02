<?php

session_start();

if (!isset ($_SESSION['username']))
{
    header('Location: ../login.html');
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title> Add Flight</title>
        <link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
        <script src="https://momentjs.com/downloads/moment.min.js"></script>
        <script src="https://cdn.rawgit.com/FreddyFY/material-datepicker/1.0.6/dist/material-datepicker.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/FreddyFY/material-datepicker/1.0.6/dist/material-datepicker.css">
      <script type="text/javascript" src="https://cdn.rawgit.com/FreddyFY/material-datepicker/1.0.6/dist/material-datepicker.min.js"></script>    
    </head>
    <body>

    <?php /*'id' => 
      'origin' => 
      'destination' 
      'boardingTime'
      'departureTime'
      'arrivalTime' 
      'seats' 
      'price'*/ ?>
      
        <input type="text" id = "hold" style="visibility: hidden"></input>
        
        <br>
      
        Origin: <input type="text" id="origin"/><br>
        Destination: <input type="text" id="destination"/>
        
        <br></br>
        
        Boarding Day: <button id="boardingDay"> Choose Day</button> 
        <div id="displayBoardingDay">
            
            <br>
            
        </div>
        Boarding Time: <input type="text" id="boardingTime"/><br>
        
        <br></br>
        
        Departure Day: <button id="departureDay"> Choose Day</button> 
        <div id = "displayDepartureDay">
            
            <br>
            
        </div>
        Departure Time: <input type="text" id="departureTime"/><br>
        
        <br></br>
        
        Arrival Day: <button id="arrivalDay"> Choose Day</button> 
        <div id = "displayArrivalDay">
            
            <br>
            
        </div>
        Arrival Time: <input type="text" id="arrivalTime"/><br>
        
        <br></br>
        
        Seats: <input type="text" id="seats"/><br>
        Price: <input type="text" id="price"/><br>
        
        <br></br>
        
        <button id = "addFlight">Add Flight!</button>
        
        <br></br>
        
        
        <form method="POST" action="flights.php"/>
        
           
            <input id = "submitBtn" type="submit" value="Done!"/>
            
        </form>

        <script>
            
    var origin;
    var destination;
    var boardingTime;
    var boardingDay;
    var departureTime;
    var departureDay;
    var arrivalTime;
    var arrivalDay;
    var seats;
    var price;
            
            $("#boardingDay").on("click", function(){
                
                var monthpicker1 = new MaterialDatepicker('input', {
                    lang: 'en',
                    orientation: 'portrait',
                    theme: 'light',
                    color: 'red',
                    outputFormat: 'YYYY-MM-DD',
                    outputElment: '#displayBoardingDay',
                    date: new Date,
                    onChange: function()
                    {
                        
                        $("#displayBoardingDay").html($("#hold").val())
                        
                    }
                 
                });
                
                monthpicker1.open();
                
            });
            
            $("#departureDay").on("click", function(){
                
                var monthpicker2 = new MaterialDatepicker('input', {
                    lang: 'en',
                    orientation: 'portrait',
                    theme: 'light',
                    color: 'red',
                    outputFormat: 'YYYY-MM-DD',
                    outputElment: '#displayDepartureDay',
                    date: new Date,
                    onChange: function()
                    {
                        $("#displayDepartureDay").html($("#hold").val())
                    }
                 
                });
                
                monthpicker2.open();
                
            });
            
            $("#arrivalDay").on("click", function(){
                
                var monthpicker3 = new MaterialDatepicker('input', {
                    lang: 'en',
                    orientation: 'portrait',
                    theme: 'light',
                    color: 'red',
                    outputFormat: 'YYYY-MM-DD',
                    outputElment: '#displayArrivalDay',
                    date: new Date,
                    onChange: function()
                    {
                        $("#displayArrivalDay").html($("#hold").val())
                    }
                 
                });
                
                monthpicker3.open();
                
            });
            
            $("#addFlight").on("click", function(){
                
                origin = $("#origin").val();
                destination = $("#destination").val();
                boardingTime = $("#boardingTime").val();
                boardingDay = $("#disaplayBoardingDay").val();
                departureTime = $("#departureTime").val();
                departureDay = $("#displayDepartureDay").val();
                arrivalTime = $("#arrivalTime").val();
                arrivalDay = $("#displayArrivalDay").val();
                seats = $("#seats").val();
                price = $("#price").val();
                
                
                $.ajax({

                    method: "POST",
                    url: "addFlightAPI.php",
                    dataType: "json",
                    data: { "origin": origin,
                            "destination" : destination,
                            "boardingTime" : boardingTime,
                            "boardingDay" : boardingDay,
                            "departureTime" : departureTime,
                            "departureDay" : departureDay,
                            "arrivalTime" : arrivalTime,
                            "arrivalDay" : arrivalDay,
                            "seats" : seats,
                            "price" : price
                    },
                    success: function(data,status) 
                    {
                        //alert(data);
                    
                    },
                    complete: function(data,status) 
                    { 
                        //optional, used for debugging purposes
                        //alert(status);
                    }
                    
                });//ajax
                
                
            });
            
        </script>

    </body>
</html>