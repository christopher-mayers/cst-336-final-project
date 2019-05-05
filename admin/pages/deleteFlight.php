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
        <title>Delete Flight</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    </head>
    <body>
        <h1>Delete Flight</h1>
        
        <input type="text" id="flightNum" name='flightNum'/>
        
        <br></br>
        
        <button id='submit'>Submit</button>
        <br></br>
        <form>
            <input type="button" value="Done!" onclick="history.back()">
        </form>
    </body>
    
    <script>
    
        $("#submit").on("click", function(){
            
            $.ajax({

                method: "GET",
                url: "../api/deleteFlightAPI.php",
                dataType: "json",
                data: { "flightNum": $("#flightNum").val()},
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
    
</html>