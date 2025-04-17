<?php
    //get eventID
    $eventID = $_POST["eventID"];

    //server connection details
    $host = 'sql.cianci.io';
    $dbname = 'frequentfliers';
    $username = 'rmorrell';
    $password = 'e2VaSdfES6sU';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
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