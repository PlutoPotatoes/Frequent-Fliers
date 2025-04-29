<?php
/*
    This file condenses the Guest-Lobby table of all players into
    a single file so the javascript can refresh the table on a timer. 
    This keeps the table up to date as people join the lobby. The
    only difference from getTable.php is the lack of kick buttons.

    Last edited by Ryan Morrell 4/28/25
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
