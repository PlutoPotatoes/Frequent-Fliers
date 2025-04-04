<?php

$eventID = $_GET["eventID"];
$matchID = $_GET["matchID"];
$player = $_GET["player"];
$score = $_GET["score"];

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

$sql = "UPDATE eventMatch SET player" . $player . "Score = $score WHERE eventID=$eventID AND matchNo=$matchID;";
$conn->query($sql);
exit();