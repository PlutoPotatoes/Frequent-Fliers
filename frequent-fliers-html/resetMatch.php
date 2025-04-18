<?php

$eventID = (int)$_GET["eventID"];
$matchID = (int)$_GET["matchID"];


//server connection details
$host = 'sql.cianci.io';
$dbname = 'frequentfliers';
$username = 'rmorrell';
$password = 'e2VaSdfES6sU';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//FIXME cast values as integer to avoid sql injection

$sql = "UPDATE eventMatch SET player1Score = 0, player2Score = 0 WHERE eventID=$eventID AND matchNo=$matchID;";
$conn->query($sql);
exit();