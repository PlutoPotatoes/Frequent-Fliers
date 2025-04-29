<?php
include('database.php');    
$conn = dbConn();

$eventID = $_GET["eventID"];
$userID = $_GET["userID"];


    


$sql = "DELETE FROM attendee WHERE eventID=" . $eventID . " AND userID=" . $userID. ";";
$conn->query($sql);

header("Location: index.html");
exit();