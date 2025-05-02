<?php

/*
 * Last Edited By: Ryan Morrell
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: reset_match.php
 *
 * This file runs when the host presses the reset match button in dashboard.php.
 * It expects eventID and matchID to be passed in the URL and resets the scores
 * of the specified match in the database.
 */

include('database.php');    
$conn = dbConn();

$eventID = (int)$_GET["eventID"];
$matchID = (int)$_GET["matchID"];



    

//FIXME cast values as integer to avoid sql injection

$sql = "UPDATE eventMatch SET player1Score = 0, player2Score = 0 WHERE eventID=$eventID AND matchNo=$matchID;";
$conn->query($sql);
exit();