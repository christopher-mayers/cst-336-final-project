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
        <title> Update Flight</title>
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
      
      
        Flight Number: <input type = "text" id = "flightNum"><br>
        
        <button id = "getFlightInfo">Get Flight Info</button>
        
        <br></br>
        Origin: <input type="text" id="origin"/><br>
        Destination: <input type="text" id="destination"/>
        
        <br></br>
        
        Boarding Day: <button id="boardingDay"> Choose Day</button> 
        <div id="displayBoardingDay">
            
            <br>
            
        </div>
        Boarding Time: <input type="text" id="boardingTime"/> (Use 24 Hour Time) <br> 
        
        <br></br>
        
        Departure Day: <button id="departureDay"> Choose Day</button> 
        <div id = "displayDepartureDay">
            
            <br>
            
        </div>
        Departure Time: <input type="text" id="departureTime"/> (Use 24 Hour Time)<br> 
        
        <br></br>
        
        Arrival Day: <button id="arrivalDay"> Choose Day</button> 
        <div id = "displayArrivalDay">
            
            <br>
            
        </div>
        Arrival Time: <input type="text" id="arrivalTime"/> (Use 24 Hour Time)<br> 
        
        <br></br>
        
        Seats: <input type="text" id="seats"/><br>
        Price: <input type="text" id="price"/><br>
        
        <br></br>
        
        <button id = "addFlight">Update Flight!</button>
        
        <br></br>
        
        
        <form method="POST" action="flights.php"/>
        
           
            <input id = "submitBtn" type="submit" value="Done!"/>
            
        </form>

        <script>
            $("#getFlightInfo").on("click", function(){
                
                $.ajax({

                    method: "GET",
                    url: "../api/getFlightInfo.php",
                    dataType: "json",
                    data: { "flightNum": $("#flightNum").val() },
                    success: function(data,status) 
                    {
                        var bStr = data['boardingTime']['date'];
                        var dStr = data['departureTime']['date'];
                        var aStr = data['arrivalTime']['date'];
                        
                        var bArray = bStr.split(" ");
                        var dArray = dStr.split(" ");
                        var aArray = aStr.split(" ");
                        
                        var holdBDay = bArray[0];
                        var holdBTime = bArray[1];
                        var holdDDay = dArray[0];
                        var holdDTime = dArray[1];
                        var holdADay = aArray[0];
                        var holdATime = aArray[1];
                        
                        $("#origin").val(data['origin']);
                        $("#destination").val(data['destination']);
                        $("#boardingTime").val(holdBTime);
                        $("#displayBoardingDay").html(holdBDay);
                        $("#departureTime").val(holdDTime);
                        $("#displayDepartureDay").html(holdDDay);
                        $("#arrivalTime").val(holdATime);
                        $("#displayArrivalDay").html(holdADay);
                        $("#seats").val(data['seats']);
                        $("#price").val(data['price']);
                    
                    },
                    complete: function(data,status) 
                    { 
                        //optional, used for debugging purposes
                        //alert(status);
                    }
                    
                });//ajax
                
            });
        
            
            var flightNum
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
                
                var monthpicker1 = new MaterialDatepicker('#displayBoardingDay', {
                    lang: 'en',
                    orientation: 'portrait',
                    theme: 'light',
                    color: 'red',
                    outputFormat: 'YYYY-MM-DD',
                    outputElement: '#displayBoardingDay',
                    date: new Date,
                });
                
                monthpicker1.open();
                
            });
            
            $("#departureDay").on("click", function(){
                
                var monthpicker2 = new MaterialDatepicker('#displayDepartureDay', {
                    lang: 'en',
                    orientation: 'portrait',
                    theme: 'light',
                    color: 'red',
                    outputFormat: 'YYYY-MM-DD',
                    outputElement: '#displayDepartureDay',
                    date: new Date,
                });
                
                monthpicker2.open();
                
            });
            
            $("#arrivalDay").on("click", function(){
                
                var monthpicker3 = new MaterialDatepicker('#displayArrivalDay', {
                    lang: 'en',
                    orientation: 'portrait',
                    theme: 'light',
                    color: 'red',
                    outputFormat: 'YYYY-MM-DD',
                    outputElement: '#displayArrivalDay',
                    date: new Date,
                });
                
                monthpicker3.open();
                
            });
            
            $("#addFlight").on("click", function(){
                
                flightNum = $("#flightNum").val();
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
                    url: "../api/updateFlightAPI.php",
                    dataType: "json",
                    data: { "flightNum": flightNum,
                            "origin": origin,
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