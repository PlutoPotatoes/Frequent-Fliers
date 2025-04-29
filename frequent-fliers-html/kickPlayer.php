<?php
/*
    This file contains the script that runs whenever a kick button
    in Host-Lobby is pressed. eventID and UserID must be passed in 
    the URL.

    Last edited by Ryan Morrell 4/28/25
*/
include('database.php');    
$conn = dbConn();
// Added (ints) to prevent SQL injection
$eventID = (int) $_GET["eventID"];
$userID = (int) $_GET["userID"];


    

//FIXME cast values as integer to avoid sql injection

$sql = "DELETE FROM attendee WHERE eventID=" . $eventID . " AND userID=" . $userID. ";";
$conn->query($sql);
exit();