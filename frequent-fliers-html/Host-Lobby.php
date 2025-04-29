<html>
<head>
    <!--FIXME at some point change sizing for viewport <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="lobby.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head> <!--FIXME - add metadata?-->
<?php
    /*
        This file contains the Host-Lobby. this includes:
            1. a dynamic table that updates as players join the lobby
                using a javascript interval to refresh getTable.php 
            2. Kick buttons on the table to remove players from the lobby
            3. a QR Code the directs new players to the signup page and
                autofills the event pin

        Last edited by Ryan Morrell 4/28/25
    */
    //needs to be called as Lobby.php?eventID=###
    include('database.php');    
    $conn = dbConn();
    
    $eventID=$_GET["eventID"];
    

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // below is the code to get the QR code image from the database
    
    $sql = "SELECT img FROM QRCode where eventID = $eventID";
    $result = $conn->query($sql);
    $img = mysqli_fetch_column($result);

    $sql = "SELECT eventName FROM kiteEvent where eventID = $eventID;";
    $result = $conn->query($sql);
    $eventName = mysqli_fetch_column($result);



?>
<body>
    <div class="header-bar"></div>
    <a href= "index.html"><div class="lakf-logo">LAKF</div></a>
    <a href="help.html" class="help-button">?</a>

    <img class="img" src="cloudBanner.jpg" alt="Cloud Banner"/> <!-- Local path should work once hosted or in same folder -->
    <h1>Event<br>Lobby</h1>

    <div class="button-bar">
        <div class="button-container">
            <a href="index.html">
                <button class="home-button">Home</button>
            </a>
            <a href="host-event.html">
                <button class="home-button">Host an Event</button>
            </a>
        </div>
    </div>
    <div class="event-title-box">
        <p class="event-title"><?php echo $eventName; ?></p>
        <p class="instructions">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;🌟 Ready to play? Scan the QR code to join the lobby! 🪁✨
        <p>
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
        $('#table-holder').load('getTable.php?eventID=<?php echo $eventID?>');
        setInterval(function(){
            $('#table-holder').load('getTable.php?eventID=<?php echo $eventID?>');
        }, 500);
        });
        </script>  

        <div class="start-holder">
            <a href="create-bracket-email.php?eventID=<?=$eventID?>"><button class="start-button">Start Tournament</button></a>
        </div>
    </div>


    <div class="start-holder">
        <a href="create-bracket-email.php?eventID=<?=$eventID?>"><button class="start-button">Start Tournament</button></a>
    </div>
    <script type="module" src="lobby.js"></script>

    <div class="social-media-bar">
        <p>Insert social media stuff</p>
    </div>

</body>