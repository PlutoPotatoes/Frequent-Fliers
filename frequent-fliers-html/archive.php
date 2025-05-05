<?php
/*
 * Last Edited By: Jake Moore
 * Date: May 3rd, 2025
 * File: archive.php
 *
 * This file holds the archive page that displays previously completed tournaments.
 */

// Database credentials
include('database.php');
$conn = dbConn();



$host = 'sql.cianci.io';
$dbname = 'frequentfliers';
$username = 'rmorrell';
$password = 'e2VaSdfES6sU';

// Establish database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

$arcRes = $conn->query($sql);

$events = [];

if ($arcRes->num_rows > 0) {
    while ($row = $arcRes->fetch_assoc()) {
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

// Fetch the 10 most recent events based on eventID
$sql = "
    SELECT em.eventID, ke.eventName, em.matchData
    FROM matchArchive em
    JOIN kiteEvent ke ON em.eventID = ke.eventID
    ORDER BY em.eventID DESC
    LIMIT 10
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Archive - Los Angeles Kite Fighting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to your existing CSS for consistent styling -->
    <!-- Bootstrap CSS for accordion functionality -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="archive.css">
</head>
<body>
    <div class="header-bar"></div>
    <a href= "index.html"><div class="lakf-logo">LAKF</div></a>

    <img class="banner" src="cloudBanner.jpg" alt="Cloud Banner">

    <h1>Event Archive</h1>
    <div class="button-bar">
        <div class="button-container">
            <a href="index.html">
                <button class="home-button" style="border-radius: 12px;">Home</button>
            </a>
        </div>
    </div>

    <div class="container my-5">
        <div class="accordion" id="eventAccordion">
            <?php
            if ($result && $result->num_rows > 0) {
                $index = 0;
                while ($row = $result->fetch_assoc()) {
                    $eventID = htmlspecialchars($row['eventID']);
                    $eventName = htmlspecialchars($row['eventName']);
                    $matchData = json_decode($row['matchData'], true);

                    $collapseID = "collapse$index";
                    $headingID = "heading$index";
                    ?>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="<?php echo $headingID; ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#<?php echo $collapseID; ?>" aria-expanded="false"
                                    aria-controls="<?php echo $collapseID; ?>">
                                <?php echo "$eventName"; ?>
                            </button>
                        </h2>
                        <div id="<?php echo $collapseID; ?>" class="accordion-collapse collapse"
                             aria-labelledby="<?php echo $headingID; ?>" data-bs-parent="#eventAccordion">
                            <div class="accordion-body">
                                <?php if (is_array($matchData) && count($matchData) > 0): ?>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Match #</th>
                                            <th>Player 1</th>
                                            <th>Player 1 Score</th>
                                            <th>Player 2</th>
                                            <th>Player 2 Score</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($matchData as $match): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($match['matchNo']); ?></td>
                                                <td><?php echo htmlspecialchars($match['player1']); ?></td>
                                                <td><?php echo htmlspecialchars($match['player1Score']); ?></td>
                                                <td><?php echo htmlspecialchars($match['player2']); ?></td>
                                                <td><?php echo htmlspecialchars($match['player2Score']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No match data available for this event.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    $index++;
                }
            } else {
                echo "<p>No recent events found.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
