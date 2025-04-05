<?php

$eventID = $_GET["eventID"];
$userID = $_GET["userID"];


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

$sql = "DELETE FROM attendee WHERE eventID=" . $eventID . " AND userID=" . $userID. ";";
$conn->query($sql);
exit();