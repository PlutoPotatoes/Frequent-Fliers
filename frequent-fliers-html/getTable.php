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
$sql = "SELECT playerName FROM attendee WHERE eventID = $eventID;";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$tableSize = ($result->num_rows + 1) * 45;

// Build the HTML table
echo "<div style=\"width: 301px; height: {$tableSize}px; border:1px solid black; background:#FFA5A5; font-size: 36px; font-family: Inter;\">";
echo "<table><thead><tr><th></th><th>Flier Name</th></tr></thead><tbody>";

while ($row = $result->fetch_assoc()) {
    $name = htmlspecialchars($row["playerName"]);
    echo "<tr><td><button>X</button></td><td>$name</td></tr>";
}

echo "</tbody></table></div>";

$conn->close();
?>
