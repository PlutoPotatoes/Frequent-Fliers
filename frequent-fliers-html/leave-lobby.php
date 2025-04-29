<?php
/*
    This file contains the script called when an attendee presses
    the leave lobby button in Guest Lobby. eventID and userID must be passed in the URL.

    Last edited by Ryan Morrell 4/28/25
*/
include('database.php');    
$conn = dbConn();

$eventID = $_GET["eventID"];
$userID = $_GET["userID"];


    


$sql = "DELETE FROM attendee WHERE eventID=" . $eventID . " AND userID=" . $userID. ";";
$conn->query($sql);

header("Location: index.html");
exit();