<html>
<head>
    <!--FIXME at some point change sizing for viewport <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="lobby.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head> <!--FIXME - add metadata?-->
<?php
    //needs to be called as Lobby.php?eventID=###
    $eventID=$_GET["eventID"];
    if($eventID == ""){
        $eventID = $_POST["eventID"];
    }

    //server connection details
    $host = 'sql.cianci.io';
    $dbname = 'frequentfliers';
    $username = 'rmorrell';
    $password = 'e2VaSdfES6sU';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
// Check if playerName and email are set
if (isset($_POST["playerName"]) && isset($_POST["email"])) {
    $playerName = $_POST["playerName"];
    $email = $_POST["email"]; // Optional, only use if we store emails

    // Insert player into attendee table
    $insertSQL = "INSERT INTO attendee (eventID, playerName) VALUES (?, ?)";
    $stmt = $conn->prepare($insertSQL);
    $stmt->bind_param("is", $eventID, $playerName);
    $stmt->execute();
    $stmt->close();
}

    // below is the code to get the QR code image from the database
    
    $sql = "SELECT img FROM QRCode where eventID = $eventID;";
    $result = $conn->query($sql);
    $img = mysqli_fetch_column($result);

    $sql = "SELECT eventName FROM kiteEvent where eventID = $eventID;";
    $result = $conn->query($sql);
    $eventName = mysqli_fetch_column($result);



?>
<body>
    <div class="top-menu">
        <a href="index.html"> <button class="logo-button">LAKF</button> </a>
    </div>
    <div class="banner-container">
        <img class="banner" src="cloudBanner.jpg"/> 
    </div>
    <div class="nav-menu">
        <a href= "index.html"> <button class="home-button">Home</button></a>
        <a href= "host-event.html"> <button class="home-button">Host an Event</button></a>
    </div>
    <div class="event-title-box">
        <p class="event-title"><?php echo $eventName; ?></p>
        <p class="instructions">🌟 Ready to play? Scan the QR code to join the lobby! 🪁✨<p>
    </div>
    <div class="pin-box">

        <div class="qrcontainer">
        <?php
            echo '<img class="qrcode" src="data:image/jpeg;base64,' . base64_encode($img) . '" alt="Event QR Code"">';
        ?>
        <br>
        <div class="pin">PIN: <?php echo $eventID;?></div>
        </div>
    </div>
    <div id= <?php echo $eventID?> class=table-spacer></div>
        <!--Player Table-->
    <div id="table-holder">
        

            <script>
            $(document).ready(function(){
            $('#table-holder').load('Guest-Lobby-Table.php?eventID=<?php echo $eventID?>');
            setInterval(function(){
                $('#table-holder').load('Guest-Lobby-Table.php?eventID=<?php echo $eventID?>');
            }, 5000);
            });
            </script>  
    </div>
    <div class="start-holder">
        <button class="leave-button" type="button" id="go-back">Leave Lobby</button>   
    </div>
    <script type="module" src="lobby.js"></script>
    <div class="social-media-bar">
    <!-- add social media stuff here? -->
    </div>


    
</body>