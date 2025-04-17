<?php
$host = 'sql.cianci.io';
$dbname = 'frequentfliers';
$username = 'rmorrell';
$password = 'e2VaSdfES6sU';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['matchNo']) ? intval($_GET['matchNo']) : null;

// HTML for search bar
echo '
    <form method="get" style="margin-bottom: 20px;">
        <label for="matchNo">Search by Match Number:</label>
        <input type="number" id="matchNo" name="matchNo" placeholder="Enter match number" required>
        <button type="submit">Search</button>
    </form>
';

if ($search !== null) {
    // If searching for a specific match based on eventID
    $sql = "
    SELECT em.eventID, ke.eventName, em.matchData
    FROM matchArchive em
    JOIN kiteEvent ke ON em.eventID = ke.eventID
    WHERE em.eventID = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $search);  // Bind the eventID search parameter
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Search Result for Event ID #$search:</h2>";
} else {
    // When the page is first loaded, don't show any matches
    exit;
}

// Display results if any
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventID = $row['eventID'];
        $eventName = $row['eventName'];
        $matchData = json_decode($row['matchData'], true); // Decode the JSON data

        // Display the event and its matches
        echo "<h3>Event: $eventName</h3>";
        echo "<table border='1' cellpadding='8'>
                <tr>
                    <th>Match #</th>
                    <th>Player 1</th>
                    <th>Player 1 Score</th>
                    <th>Player 2</th>
                    <th>Player 2 Score</th>
                </tr>";

        // Only display the matches for this eventID
        foreach ($matchData as $match) {
            echo "<tr>
                    <td>{$match['matchNo']}</td>
                    <td>{$match['player1']}</td>
                    <td>{$match['player1Score']}</td>
                    <td>{$match['player2']}</td>
                    <td>{$match['player2Score']}</td>
                  </tr>";
        }

        echo "</table>";
    }
} elseif ($search !== null) {
    echo "<p>No event found with Event ID #$search.</p>";
}

$conn->close();
?>
