<?php
/*
 * Last Edited By: Ryan Morrell
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: Guest_Lobby_Table.php
 *
 * This file condenses the Guest-Lobby table of all players into a single
 * output so the JavaScript can refresh the table on a timer. This keeps
 * the displayed lobby table up to date as new players join. The only
 * difference from getTable.php is the lack of kick buttons.
 */

// Get the event ID from the query string
include('database.php');

$eventID = $_GET["eventID"];

$conn = dbConn();

// Query the player names for the table
$sql = "SELECT playerName, userID FROM attendee WHERE eventID = $eventID;";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$tableSize = ($result->num_rows + 1) * 45;

// Build the HTML table
echo "<div class=\"lobby-table\"><table><thead><tr><th></th><th class=\"lobby-name\">Lobby</th></tr></thead><tbody>";

while ($row = $result->fetch_assoc()) {
    $name = $row["playerName"];
    $userID= $row["userID"];

    // Creates a HTML table row to showcase Lobby members, and assigns CSS class "flier-name" to the name of players within
    // the lobby.
    echo "<tr><td>
    
    </td><td class=\"flier-name\">$name</td></tr>";

}

echo "</tbody></table></div>";
//FIXME testing
$conn->close();
?>
