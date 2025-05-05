<?php
/*
 * Last Edited By: Cael McDermott
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: getTable.php
 *
 * This file condenses the Host-Lobby table of all players into a single
 * output so the JavaScript can refresh the table on a timer. This keeps
 * the displayed lobby table up to date as new players join.
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
    
    echo "<tr><td><button class=\"kick-button\" id=\"$userID\">👟</button></td><td class=\"flier-name\">$name</td></tr>";

}

echo "</tbody></table></div>";
$conn->close();
exit();
?>
