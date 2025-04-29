<?php
include('database.php');    
$conn = dbConn();
// Added (ints) to prevent SQL injection
$eventID = (int) $_GET["eventID"];
$userID = (int) $_GET["userID"];


    

//FIXME cast values as integer to avoid sql injection

$sql = "DELETE FROM attendee WHERE eventID=" . $eventID . " AND userID=" . $userID. ";";
$conn->query($sql);
exit();