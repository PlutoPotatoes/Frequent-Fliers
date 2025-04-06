<?php
// Get the event ID from the query string
$eventID = $_GET["eventID"];

// DB connection
$host = 'sql.cianci.io';
$dbname = 'frequentfliers';
$username = 'rmorrell';
$password = 'e2VaSdfES6sU';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the player names for the table
$sql = "SELECT playerName, userID FROM attendee WHERE eventID = $eventID;";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$tableSize = ($result->num_rows + 1) * 45;

// Build the HTML table
echo "<div class=\"lobby-table\"><table><thead><tr><th></th><th>Lobby</th></tr></thead><tbody>";

while ($row = $result->fetch_assoc()) {
    $name = $row["playerName"];
    $userID= $row["userID"];

    echo "<tr><td><button class=\"deleteButton\" data-userid=\"$userID\">👟</button></td><td class=\"flier-name\">$name</td></tr>";

}

echo "</tbody></table></div>";
//FIXME testing
$conn->close();
?>
