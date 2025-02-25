<!DOCTYPE html>
<html>


<head>

</head>

<?php
    $eventID = $_GET["eventID"];

    //server connection details
    //should probably be more secure with the password or make read only account
    $servername = "localhost";
    $username = "username";
    $password = "password";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection, kill site on fail
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $getAttendees = "SELECT * FROM attendee WHERE eventID = $eventID";



    //python algorithm here creating matchup to populate the table
    //display the table in the HTML file Mel is making

    //somehow get each person's individual schedule 
    //create png with it
    //email to the email in the table   

    





?>

<body>

</body>
</html>