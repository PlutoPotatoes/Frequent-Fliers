<?php
/*
 * Last Edited By: Cael McDermott
 * Date: May 3rd, 2025
 * File: archive_creation.php
 *
 * Description:
 * This script retrieves all match data grouped by event from the database,
 * formats it into JSON, and stores it in the matchArchive table.
 *
 * Steps:
 * 1. Connect to the database.
 * 2. Query match data (with event and player details) grouped by eventID.
 * 3. Format matches per event into JSON.
 * 4. Insert or update the JSON data in the matchArchive table.
 * 5. Close the connection and confirm success.
 */

 include('database.php');
$conn = dbConn();

// Query to fetch match data along with event details
$sql = "
SELECT em.eventID, ke.eventName, em.matchNo, a1.playerName AS player1_name, a2.playerName AS player2_name, 
       em.player1Score, em.player2Score
FROM eventMatch em
JOIN attendee a1 ON em.player1 = a1.userID
JOIN attendee a2 ON em.player2 = a2.userID
JOIN kiteEvent ke ON em.eventID = ke.eventID
ORDER BY em.eventID, em.matchNo
";

$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventID = $row["eventID"];
        $eventName = $row["eventName"];
        
        // Ensure matches are grouped strictly by eventID
        if (!isset($events[$eventID])) {
            $events[$eventID] = [
                "eventName" => $eventName,
                "matches" => []
            ];
        }

        // Add match only if it belongs to the same eventID
        $events[$eventID]["matches"][] = [
            "matchNo" => $row["matchNo"],
            "player1" => $row["player1_name"],
            "player2" => $row["player2_name"],
            "player1Score" => $row["player1Score"],
            "player2Score" => $row["player2Score"]
        ];
    }
}

// Insert JSON data into matchArchive table, ensuring only matches of the same eventID are stored together
$insertStmt = $conn->prepare("INSERT INTO matchArchive (eventID, eventName, matchData) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE matchData = VALUES(matchData)");

foreach ($events as $eventID => $event) {
    $jsonData = json_encode($event["matches"], JSON_PRETTY_PRINT);
    $insertStmt->bind_param("iss", $eventID, $event["eventName"], $jsonData);
    $insertStmt->execute();
}

$insertStmt->close();
$conn->close();

echo "Match archive stored successfully.";
?>
