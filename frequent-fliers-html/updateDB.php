<?php

/*
    This file contains the script called when either scorekeeping button in dashboard.php
    is pressed. eventID, matchID, player, and score must be passed in the URL.

    Last edited by Ryan Morrell 4/28/25
*/

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