<html>
<head>
    <!--FIXME at some point change sizing for viewport <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="lobby.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head> <!--FIXME - add metadata?-->
<?php
/*
    This file is nearly identical to Host-Lobby but it uses Guest-Lobby-Table.php
    to generate a table without kick buttons. Additionally, the Leave Lobby button
    uses the playerID passed through the URL to remove the correct player before 
    redirecting to the homepage.

    Last edited by Ryan Morrell 4/28/25
*/
    //needs to be called as Lobby.php?eventID=###
    include('database.php');    
    $conn = dbConn();

    $eventID=$_GET["eventID"];
    $playerID = $_GET["playerID"];
    

    // below is the code to get the QR code image from the database
    
    $sql = "SELECT img FROM QRCode where eventID = $eventID;";
    $result = $conn->query($sql);
    $img = mysqli_fetch_column($result);

    $sql = "SELECT eventName FROM kiteEvent where eventID = $eventID;";
    $result = $conn->query($sql);
    $eventName = mysqli_fetch_column($result);



?>
<body>
    <div class="header-bar">
        <a href= "index.html"><div class="lakf-logo">LAKF</div></a>
        <a href="help.html" class="help-button">?</a>
    </div>
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
            $('#table-holder').load('Guest-Lobby-Table.php?eventID=<?php echo $eventID?>');
            setInterval(function(){
                $('#table-holder').load('Guest-Lobby-Table.php?eventID=<?php echo $eventID?>');
            }, 5000);
            });
            </script>  
    </div>
    <div class="start-holder">
        <button class="leave-button" type="button" id="leave-button" data-playerid=<?="$playerID"?> data-eventID = <?="$eventID"?>>Leave Lobby</button>   
    </div>
    <script type="module" src="guest-lobby.js"></script>
    <div class="social-media-bar">
    <!-- add social media stuff here? -->
    </div>


    
</body>