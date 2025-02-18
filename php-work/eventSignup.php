<!DOCTYPE html>
<html>
<head>
    <title>Generating QR Codes with PHP</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Generating QR Codes with PHP</h1>
    
    <form method="post" action="process-event-signup.php">
        
        <form action="process-signup.php" method="post" novalidate>
            <div>
                <?php $eventID = isset($_GET["eventID"])?$_GET["eventID"]:""; ?>
                <label for="event ID">Event ID</label>
                <input type="text" id="eventID" name = "eventID" <?php echo "value = $eventID";?> <?php if($eventID != ""){echo "disabled";} ?>>
            </div>
            <div>
                <label for="name">Player Name</label>
                <input type="name" id="name" name="name">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
            </div>
            
    
            <button>Create Event</button>
        </form>
 
    </form>
</body>
</html>