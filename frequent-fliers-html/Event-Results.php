<html>
<head>
    <!--FIXME at some point change sizing for viewport <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="lobby.css">
    <link rel="stylesheet" href="results.css">
    

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
    
    <div class="standings-holder" >
        <?php
        echo "<div class=\"standings-table\"><table><thead><tr><th></th><th>Flyer Name</th><th>Wins</th></tr></thead><tbody>";

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
            //$standings["userID"][0] for that persons winds and [1] for their name
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
            $playerName = $player['name'];
            $playerWins = $player['wins'];
            echo "<tr ><td class=\"table-rank\">$rank</td><td class=\"table-name\">$playerName</td><td class=\"table-wins\">$playerWins</td></tr>";
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