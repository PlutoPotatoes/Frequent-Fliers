<html>
<head>
    <!--FIXME at some point change sizing for viewport <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="results.css">
    

</head>
<?php 

/*
 * Last Edited By: Cael McDermott
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: standings_table.php
 *
 * This file creates a dynamic table to display the submitted results
 * of a completed event. The standings table is built using a series
 * of PHP echo statements that add a new row for each player found
 * in the database. Scores are tallied using an SQL COUNT query
 * that selects all rounds won by each player.
 */

include('database.php');

$eventID = $_GET["eventID"];


$conn = dbConn();
 
//add results to DB
$sql = "SELECT matchNo, player1, player2, player1Score, player2Score FROM eventMatch where eventID=$eventID;";
$matches = $conn->query($sql);

//get event name
$sql = "SELECT eventName FROM kiteEvent where eventID = $eventID;";
$result = $conn->query($sql);
$eventName = mysqli_fetch_column($result);

$standings = [];
//get player names and IDs
$sql = "SELECT userID, playerName FROM attendee WHERE eventID=$eventID;";
$players = $conn->query($sql);

// create json

?>
<body>
    <div class="header-bar">
        <a  href="index.html" ><div class="lakf-logo">LAKF</div></a>
        <a href="help.html" class="help-button">?</a>

    </div>

    <img class="banner" src="cloudBanner.jpg" alt="lakf banner" />
    <h1>Results</h1>

    <div class="button-bar">
        <div class="button-container">
            <a href="index.html">
                <button class="nav-button">Home</button>
            </a>
            <a href="host-event.html">
                <button class="nav-button">Host an Event</button> 
            </a>
        </div>
    </div>
    </div>
    <div class="event-title-box">
        <p class="event-title"><?php echo $eventName; ?> Results</p>
    </div>
    
    <div class="standings-holder" >
        <?php
        echo "<div class=\"standings-table\"><table class=\"ranking-table\"><thead><tr><th class=\"rank-spacer\"></th><th>Flyer Name</th><th>Wins</th></tr></thead><tbody>";

        while($player = $players->fetch_assoc()){
            //get player info
            $userID = $player["userID"];
            $name = $player["playerName"];
            //count player wins in DB
            $sql = "SELECT COUNT(matchNo) 
            FROM eventMatch
            WHERE (player1 = $userID AND player1Score > player2Score) 
            OR (player2 = $userID AND player2Score > player1Score);";
            $wins = $conn->query($sql)->fetch_assoc();
            $wins = array_pop($wins);
            array_push($standings, array('id'=>$userID, 'wins'=>$wins, 'name'=>$name));
        
        
        }
        $winCol = array_column($standings, 'wins');
        $nameCol = array_column($standings, 'name');
        $idCol = array_column($standings, 'id');

        array_multisort($winCol, SORT_DESC, $standings);
?>
        <div class="winner-text-holder">
            <p class="winner-text"><?php echo $standings[0]['name'] . " is your winner!"?></p>
        </div>
<?php
        $rank = 1;
        foreach($standings as $player){
            if($player['id'] == -1){
                continue;
            }
            $playerName = $player['name'];
            $playerWins = $player['wins'];
            echo "<tr><td class=\"table-rank\">$rank</td><td class=\"table-name\">$playerName</td><td class=\"table-wins\">$playerWins</td></tr>";
            $rank++;
        }
        
        echo "</tbody></table></div>";
        ?>
    </div>
    
    <div style="height: 15px">
    <!-- add social media stuff here? -->
    </div>

</body>
</html>