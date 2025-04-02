<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" href="game-running.css" />
        <link rel="stylesheet" href="styles.css" />
    
    </head>

    <?php
        //grab eventID from the URL
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


        //get all match data
        $sql = "SELECT * FROM eventMatch WHERE eventID=$eventID;";
        $matches = $conn->query($sql);

    ?>

    <body>
        <div class="scorekeeping">
            <div class="div">
                <div class="overlap">
                    <img class="element-f" src="https://t3.ftcdn.net/jpg/02/67/83/92/360_F_267839295_jVbzpVskpRpnPaq3xLFjjX9gYjNRocxN.jpg" />
                    <div class="rectangle"></div>
                    <div class="icon-button"><img class="user" src="img/user.svg" /></div>
                    <div class="text-wrapper">LAKF</div>
                    <div class="text-wrapper-2">Scorekeeping</div>
                </div>
                <button class="button-wrapper">
                    <button class="button"><img class="home" src="img/home.svg" /> <button class="button-2">Home</button>
                </button>
                </button>
            </div>
        </div>
        
        <form method = "post" action = "">
                    <div class="accordion" name="match-list">
                        <?php
                            while($match = $matches->fetch_assoc()){
                                $matchNo = $match["matchNo"];
                                $p1 = $match["player1"];
                                $p2 = $match["player2"];
                                $sql = "SELECT playerName FROM attendee WHERE eventID=$eventID AND userID IN ($p1, $p2);";
                                $players = $conn->query($sql);
                                $p1 = $players->fetch_assoc()["playerName"];
                                $p2 = $players->fetch_assoc()["playerName"];

                                $accordion = "<div class=\"accordion-item\">
                                            <h2 class=\"accordion-title\"> Match $matchNo</h2>
                                            <div class=\"match-menu\">
                                            <div class=\"player-label\">";
                                $accordion = $accordion . "<label class=\"p1Label\" for = \"M" . $matchNo . "P1Score\">". $p1 . " Score</label>
                                <input class = \"score\" type=\"number\" id=\"M" . $matchNo . "P1Score\" value = \"0\" readonly/>
                                <input id = \"M" . $matchNo . "P1\" class= \"increment-button\" type=\"button\" value=\"+\" />
                                <input id = \"M" . $matchNo . "P1\" class= \"decrement-button\" type=\"button\" value=\"-\" />
                                </div>";

                                $accordion = $accordion . "<div class=\"player-label\"><label class=\"p2Label\" for = \"M" . $matchNo . "P2Score\">". $p2 . " Score</label>
                                <input class = \"score\" type=\"number\" id=\"M" . $matchNo . "P2Score\" value = \"0\" readonly/>
                                <input id = \"M" . $matchNo . "P2\" class= \"increment-button\" type=\"button\" value=\"+\" />
                                <input id = \"M" . $matchNo . "P2\" class= \"decrement-button\" type=\"button\" value=\"-\" />
                                </div>
                                </div>
                                </div>";
                                echo $accordion;

                                
                            }
                        ?>


                    </div><br>


                </form>
                <script src="app.js"></script>
    </body>
</html>
