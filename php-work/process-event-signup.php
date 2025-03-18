<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <meta charset = "UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<?php
    //get database connection and data

    // get eventID given during signup
    $eventID = $_POST["eventID"];
    $email = $_POST["email"];
    $name = $_POST["name"];

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

    // Insert form data into attendees
    // use autoincrement for unique attendee ID
    $attendeeQuery = "INSERT INTO attendees (eventID, email, playerName) VALUES ($eventID, $email, $name)";
    
    if($conn->query($attendeeQuery) !== true){
        die("Connection Error: " . $conn->error);
    }




    // Query connection, place the selected row in $row
    $qrQuery = "SELECT eventName, QRCode, eventTime, eventLocation from events where events.eventID= $eventID";
    $results = $conn->query($qrQuery);
    $row = $results->fetch_assoc();
    // Get column values from $row
    // once connected and entries exists replace text in the site with references to these variables
    $eventName = $row["eventName"];
    $eventTime = $row["eventTime"];
    $eventLocation = $row["eventLocation"];
    // add a place in the DB for a small blurb (250 words max)
    $QRCode = $row["QRCode"];
    
?>
<body> 
    <h1>Signup Successful</h1>
    <div>
    <h2><?php echo $eventName;?> Details:</h2>
    <p>Location: <?php echo  $eventLocation;?> <br></p> 
    <p>Time: <?php echo  $eventTime;?> <br></p> 
    <!--Add small blurb here -->
    </div>

    
</body>