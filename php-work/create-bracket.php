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
    //query database for event attendees
    $getAttendees = "SELECT * FROM attendee WHERE eventID = $eventID";
    $result = $conn->query($getAttendees);
    
    //convert query to array
    $attendees = [];
    while($row = $result->fetch_assoc()){
        $attendees[$row["userID"]] = array(
            "email" => $row["email"],
            "name" => $row["name"]
        );
    }

    //add rest round if needed
    $userIDs = array_keys($attendees);
    if(count($userIDs)%2 == 1){
        $userIDs[-1] = 00000;
    }

    //prepare matchup arrays and vars
    $matches = [];
    $n = count($userIDs);
    foreach($userIDs as $player){
        $matches[$player] = [];
    }

    for($i = 0; $i < intdiv($n,2); ++$i){
        for($i = 0; $i < intdiv($n,2); ++$i){
            //figure out how to number userIDs array or access in order with j and n-1-j
        }
    }



    /*
        https://stackoverflow.com/questions/658727/how-can-i-generate-a-round-robin-tournament-in-php-and-mysql
        has some good algorithms to check out
    */
    //python algorithm here creating matchup to populate the table
    //display the table in the HTML file Mel is making

    //somehow get each person's individual schedule 
    //create png with it
    //email to the email in the table   

    





?>

<body>

</body>
</html>