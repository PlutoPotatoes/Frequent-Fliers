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
    <div class="button-container">
        <form method="post" action="archive_creation.php">
            <button class="home-button" type="submit" style="border-radius: 12px;">Update Archive</button>
        </form>
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
