<?php

/*
 * Last Edited By: Ryan Morrell
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: updateDB.php
 *
 * This file runs when either scorekeeping button in dashboard.php is pressed.
 * It expects eventID, matchID, player, and score to be passed in the URL and
 * updates the specified player's score in the database.
 */

include('database.php');    
$conn = dbConn();

$eventID = $_GET["eventID"];
$matchID = $_GET["matchID"];
$player = $_GET["player"];
$score = $_GET["score"];


    

//FIXME cast values as integer to avoid sql injection

$sql = "UPDATE eventMatch SET player" . $player . "Score = $score WHERE eventID=$eventID AND matchNo=$matchID;";
$conn->query($sql);
exit();