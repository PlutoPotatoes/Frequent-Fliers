<?php
/*
 * Last Edited By: Cael McDermott
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: leave-lobby.php
 *
 * This file runs when an attendee presses the leave lobby button
 * in the Guest Lobby. It expects eventID and userID to be passed
 * in the URL and removes the specified player from the attendee
 * table before redirecting to the homepage.
 */

include('database.php');    
$conn = dbConn();

$eventID = $_GET["eventID"];
$userID = $_GET["userID"];


$sql = "DELETE FROM attendee WHERE eventID=" . $eventID . " AND userID=" . $userID. ";";
$conn->query($sql);

header("Location: index.html");
exit();