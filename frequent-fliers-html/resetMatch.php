<?php
include('database.php');    
$conn = dbConn();

$eventID = (int)$_GET["eventID"];
$matchID = (int)$_GET["matchID"];



    

//FIXME cast values as integer to avoid sql injection

$sql = "UPDATE eventMatch SET player1Score = 0, player2Score = 0 WHERE eventID=$eventID AND matchNo=$matchID;";
$conn->query($sql);
exit();