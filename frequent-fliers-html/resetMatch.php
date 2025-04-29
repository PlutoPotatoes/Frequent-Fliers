<?php

/*
    This file contains the script called when the host presses
    the reset match button in dashboard.php. eventID and matchID must be passed in the URL.

    Last edited by Ryan Morrell 4/28/25
*/

include('database.php');    
$conn = dbConn();

$eventID = (int)$_GET["eventID"];
$matchID = (int)$_GET["matchID"];



    

//FIXME cast values as integer to avoid sql injection

$sql = "UPDATE eventMatch SET player1Score = 0, player2Score = 0 WHERE eventID=$eventID AND matchNo=$matchID;";
$conn->query($sql);
exit();