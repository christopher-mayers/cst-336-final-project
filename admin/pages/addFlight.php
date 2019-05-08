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
      
        <br>
          <!--in this section. i did not close my strong tag. therefore, every text is bold. fix if throwing errors.-->
        <strong>Origin: <input type="text" id="origin"/><br>
        Destination: <input type="text" id="destination"/>
        
        <br></br>
        
        Boarding Day:  <input id = "submitBtn" type="submit" value="Choose Day" class="btn btn-success"/>
        <!--<button type="button" class="btn btn-primary">Choose Day</button>                                             -->
        <div id="displayBoardingDay">
            
            <br>
            
        </div>
        Boarding Time: <input type="text" id="boardingTime"/> (Use 24 Hour Time) <br> 
        
        <br></br>
        
        Departure Day: <input id = "submitBtn" type="submit" value="Choose Day" class="btn btn-info"/>
        <!--<button type="button" class="btn btn-info">Choose Day</button>                      -->
        <div id = "displayDepartureDay">
            
            <br>
            
        </div>
        Departure Time: <input type="text" id="departureTime"/> (Use 24 Hour Time)<br> 
        
        <br></br>
        
        Arrival Day: <input id = "submitBtn" type="submit" value="Choose Day" class="btn btn-info"/>
        <!--<button type="button" class="btn btn-info">Choose Day</button>-->
        <div id = "displayArrivalDay">
            
            <br>
            
        </div>
        Arrival Time: <input type="text" id="arrivalTime"/> (Use 24 Hour Time)<br> 
        
        <br></br>
        
        Seats: <input type="text" id="seats"/><br>
        Price: <input type="text" id="price"/><br>
        </strong>
        <br></br>
        
        <input id = "submitBtn" type="submit" value="Add Flight!" class="btn btn-primary"/>
        <!--<button type="button" class="btn btn-primary">Add Flight!</button>-->

        
        <br></br>
        
        
        <form method="POST" action="flights.php"/>
        
             
            <input id = "submitBtn" type="submit" value="Done!" class="btn btn-primary"/>         
            <!--<button type="button" class="btn btn-primary">Done!</button>-->

            
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
                    url: "../api/addFlightAPI.php",
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