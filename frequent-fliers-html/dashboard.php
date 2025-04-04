<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Los Angeles Kite Fighting</title>
    <link rel="stylesheet" href="game-running.css">
</header>

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

$sql = "SELECT eventName FROM kiteEvent WHERE eventID=$eventID;";
$event = $conn->query($sql);
$eventName = $event->fetch_assoc()["eventName"];

$sql = "SELECT * FROM eventMatch WHERE eventID=$eventID;";
$matches = $conn->query($sql);

?>

<body>

    <div class="top-menu">
        <button class="logo-button">LAKF</button>
    </div>
    <div class="banner-container">
        <img class="banner" src="cloudBanner.jpg" />
    </div>
    <div class="nav-banner">
        <button class="home-button" >HOME</button>
        <button class="home-button" >HOME</button>
    </div>

    <div>
        <p class="title"><?php echo $eventName ?></p>
        <p class="instructions">Enter scores for each match below. Good Luck!</p>
    </div>


    <form method = "post" action = <?php echo "tally-scores.php?eventID=$eventID"; ?>>
        <div class="accordion" name="match-list" id=<?php echo $eventID?>>
            <?php
                while($match = $matches->fetch_assoc()){
                    $matchNo = $match["matchNo"];
                    $p1 = $match["player1"];
                    $p2 = $match["player2"];
                    $p1Score = $match["player1Score"];
                    $p2Score = $match["player2Score"];

                    $sql = "SELECT playerName FROM attendee WHERE eventID=$eventID AND userID IN ($p1, $p2);";
                    $players = $conn->query($sql);
                    $p1 = $players->fetch_assoc()["playerName"];
                    $p2 = $players->fetch_assoc()["playerName"];
                    if($p1=="Rest Round"){
                        $accordion = "<div class=\"accordion-item\">
                                <h2 class=\"accordion-title\"> Match $matchNo</h2>
                                <div class=\"match-menu\">
                                <div class=\"player-label\">";
                        $accordion = $accordion . "<label class=\"p1Label\" for = \"M" . $matchNo . "P1Score\">". $p2 . "'s Rest Round</label>
                        </div>
                        </div>
                        </div>";
                        echo $accordion;
                        continue;
                    }elseif($p2=="Rest Round"){
                        $accordion = "<div class=\"accordion-item\">
                                <h2 class=\"accordion-title\"> Match $matchNo</h2>
                                <div class=\"match-menu\">
                                <div class=\"player-label\">";
                        $accordion = $accordion . "<label class=\"p1Label\" for = \"M" . $matchNo . "P1Score\">". $p1 . "'s Rest Round</label>
                        </div>
                        </div>
                        </div>";
                        echo $accordion;
                        continue;
                    }
                    $accordion = "<div class=\"accordion-item\">
                                <h2 class=\"accordion-title\" id=\"M$matchNo\"> Match $matchNo</h2>
                                <div class=\"match-menu\">
                                <div class=\"player-label\">";
                    $accordion = $accordion . "<label class=\"p1Label\" for = \"M" . $matchNo . "P1Score\">". $p1 . "'s Score</label>
                    <input name=\"M" . $matchNo . "P1Score\" class = \"score\" type=\"number\" id=\"M" . $matchNo . "P1Score\" value = $p1Score readonly/>
                    <input id = \"M" . $matchNo . "P1\" class= \"increment-button\" type=\"button\" value=\"+\" />
                    <input id = \"M" . $matchNo . "P1\" class= \"decrement-button\" type=\"button\" value=\"-\" />
                    </div>";

                    $accordion = $accordion . "<div class=\"player-label\"><label class=\"p2Label\" for = \"M" . $matchNo . "P2Score\">". $p2 . "'s Score</label>
                    <input name=\"M" . $matchNo . "P2Score\" class = \"score\" type=\"number\" id=\"M" . $matchNo . "P2Score\" value = $p2Score readonly/>
                    <input id = \"M" . $matchNo . "P2\" class= \"increment-button\" type=\"button\" value=\"+\" />
                    <input id = \"M" . $matchNo . "P2\" class= \"decrement-button\" type=\"button\" value=\"-\" />
                    </div>
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