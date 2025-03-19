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
    $host = 'sql.cianci.io';
    $dbname = 'frequentfliers';
    $username = 'rmorrell';
    $password = 'e2VaSdfES6sU';
    
    $conn = new mysqli($host, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert form data into attendees
    // use autoincrement for unique attendee ID
    $sql = "INSERT INTO attendee (playerName, email, eventID) 
    VALUES ('$name', '$email', $eventID);";

    if ($conn->query($sql) === TRUE) {
        header("http://localhost:8000/signup-success.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    
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