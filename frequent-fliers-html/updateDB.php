<?php
include('database.php');    
$conn = dbConn();

$eventID = $_GET["eventID"];
$matchID = $_GET["matchID"];
$player = $_GET["player"];
$score = $_GET["score"];


    

//FIXME cast values as integer to avoid sql injection

$sql = "UPDATE eventMatch SET player" . $player . "Score = $score WHERE eventID=$eventID AND matchNo=$matchID;";
$conn->query($sql);
exit();