<html>
<head>
    <!--FIXME at some point change sizing for viewport <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="lobby.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<?php
 $eventID = $_GET["eventID"];

 //server connection details
 $host = 'sql.cianci.io';
 $dbname = 'frequentfliers';
 $username = 'rmorrell';
 $password = 'e2VaSdfES6sU';

 $conn = new mysqli($host, $username, $password, $dbname);

 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

//get event name
 $sql = "SELECT eventName FROM kiteEvent where eventID = $eventID;";
 $result = $conn->query($sql);
 $eventName = mysqli_fetch_column($result);

//get player names and IDs
 $sql = "SELECT userID, playerName FROM attendee WHERE eventID=$eventID;";
 $players = $conn->query($sql);

?>
<body>
    <div class="top-menu">
        <a href="FF-home-screen.html"> <button class="logo-button">LAKF</button> </a>
    </div>
    <div class="banner-container">
        <img class="banner" src="cloudBanner.jpg"/> 
    </div>
    <div class="nav-menu">
        <a href= "FF-home-screen.html"> <button class="home-button">Home</button></a>
        <a href= "FF-event-signup.html"> <button class="home-button">Join an Event</button></a>

    </div>
    <div class="event-title-box">
        <p class="event-title"><?php echo $eventName; ?> Results</p>
    </div>
    

    
    <div style="height: 15px">
    <!-- add social media stuff here? -->
    </div>

</body>
</html>