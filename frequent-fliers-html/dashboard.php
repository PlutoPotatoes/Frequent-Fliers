<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Los Angeles Kite Fighting</title>
    <link rel="stylesheet" href="game-running.css">
</header>

<?php

include('database.php');

$conn = dbConn();
$eventID = $_GET["eventID"];


$sql = "SELECT eventName FROM kiteEvent WHERE eventID=$eventID;";
$event = $conn->query($sql);
$eventName = $event->fetch_assoc()["eventName"];

$sql = "SELECT * FROM eventMatch WHERE eventID=$eventID;";
$matches = $conn->query($sql);

?>

<body>

    <div class="header-bar">
        <a  href="index.html" ><div class="lakf-logo">LAKF</div></a>
        <a href="help.html" class="help-button">?</a>

    </div>

    <img class="banner" src="cloudBanner.jpg" alt="lakf banner" />
    <h1>Event<br>Dashboard</h1>

    <div class="button-bar">
        <div class="button-container">
            <a href="index.html">
                <button class="nav-button">Home</button>
            </a>
            <a href="event-signup.php">
                <button class="nav-button">Join a Match</button> 
            </a>
        </div>
    </div>

    <div>
        <p class="title"><?php echo $eventName ?></p>
        <p class="instructions">Enter scores for each match below. Good Luck!</p>
    </div>


    <form method = "post" action = <?php echo "event-results.php?eventID=$eventID"; ?>>
        <div class="accordion" name="match-list" id=<?php echo $eventID?>>
            <?php
                while($match = $matches->fetch_assoc()){
                    $matchNo = $match["matchNo"];
                    $p1 = $match["player1"];
                    $p2 = $match["player2"];
                    $p1Score = $match["player1Score"];
                    $p2Score = $match["player2Score"];
                    $attackSide = $match["attackSide"];

                    $sql = "SELECT playerName FROM attendee WHERE eventID=$eventID AND userID = $p1;";
                    $players = $conn->query($sql);
                    $p1 = $players->fetch_assoc()["playerName"];

                    $sql = "SELECT playerName FROM attendee WHERE eventID=$eventID AND userID = $p2;";
                    $players = $conn->query($sql);
                    $p2 = $players->fetch_assoc()["playerName"];
                    
                    if($p1=="Rest Round"){
                        continue;
                    }elseif($p2=="Rest Round"){
                        continue;
                    }

                    //p1 and p2 crash button ID's are swapped because they add points to the other person's score
                    $accordion = "<div class=\"accordion-item\">
                                <h2 class=\"accordion-title\" id=\"M$matchNo\"> Match $matchNo: $p1 vs. $p2 (attacking $attackSide)</h2>
                                <div class=\"match-menu\">
                                <div class=\"player-label\">";
                    $accordion = $accordion . "<label class=\"p1Label\" for = \"M" . $matchNo . "P1Score\">". $p1 . "'s Score</label>
                    <input name=\"M" . $matchNo . "P1Score\" class = \"score\" type=\"number\" id=\"M" . $matchNo . "P1Score\" value = $p1Score readonly/>
                    <div class=\"score-button-holder\">
                    <input id = \"M" . $matchNo . "P1\" class= \"touch-button\" type=\"button\" value=\"Touch\" />
                    <input id = \"M" . $matchNo . "P2\" class= \"crash-button\" type=\"button\" value=\"Crash\" />
                    </div>
                    </div>";

                    $accordion = $accordion . "<div class=\"player-label\"><label class=\"p2Label\" for = \"M" . $matchNo . "P2Score\">". $p2 . "'s Score</label>
                    <input name=\"M" . $matchNo . "P2Score\" class = \"score\" type=\"number\" id=\"M" . $matchNo . "P2Score\" value = $p2Score readonly/>
                    <div class=\"score-button-holder\">
                    <input id = \"M" . $matchNo . "P2\" class= \"touch-button\" type=\"button\" value=\"Touch\" />
                    <input id = \"M" . $matchNo . "P1\" class= \"crash-button\" type=\"button\" value=\"Crash\" />
                    </div>
                    </div>
                    <input id = \"M$matchNo\" class= \"reset-button\" type=\"button\" value=\"Reset\" />
                    </div>
                    </div>";
                    echo $accordion;


                }
            ?>
            
            <div class="submit-wrapper">
                <input class="submit-button" type="submit" value="Finish Tournament">
            </div>
        </div><br>

        
    </form>
    <script type="module" src="app.js"></script>
</body>
</html>