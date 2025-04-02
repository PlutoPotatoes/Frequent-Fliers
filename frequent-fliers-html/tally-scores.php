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

//get match numbers
$sql = "SELECT matchNo FROM eventMatch where eventID=$eventID;";
$matches = $conn->query($sql);

//for each match get scores and add them to the DB
while($m = $matches->fetch_assoc()){
    $matchNo = $m["matchNo"];
    echo "M$matchNo" . "P1Score";
    $p1Score = $_POST["M$matchNo" . "P1Score"];
    $p2Score = $_POST["M$matchNo" . "P2Score"];

    $sql = "UPDATE eventMatch SET player1Score = $p1Score, player2Score = $p2Score WHERE eventID = $eventID AND matchNo=$matchNo;";
    $conn->query($sql);
}

