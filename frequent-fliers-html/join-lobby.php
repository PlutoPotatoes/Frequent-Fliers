<?php
    /*
        This file adds new players to the correct event in the database 
        before redirecting to Guest-Lobby.php

        Last edited by Ryan Morrell 4/28/25
    */
    include('database.php');    
    $conn = dbConn();
    
    $eventID=$_POST["eventID"];

    // Check if playerName and email are set
    if (isset($_POST["playerName"]) && isset($_POST["email"])) {
        $playerName = $_POST["playerName"];
        $email = $_POST["email"]; // Optional, only use if we store emails

        // Insert player into attendee table
        $insertSQL = "INSERT INTO attendee (eventID, playerName) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSQL);
        $stmt->bind_param("is", $eventID, $playerName);
        $stmt->execute();
        $stmt->close();
    }   
    $playerID = $conn->insert_id;

    header("Location: Guest-Lobby.php?eventID=$eventID&playerID=$playerID");
    exit();

?>  