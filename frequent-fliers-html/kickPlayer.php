<?php
/*
 * Last Edited By: Ryan Morrell
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: kickPlayer.php
 *
 * This file runs whenever a kick button in the Host-Lobby is pressed.
 * It expects eventID and userID to be passed in the URL and removes
 * the specified player from the attendee table in the database.
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