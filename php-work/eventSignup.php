<!DOCTYPE html>
<html>
<head>
    <title>Generating QR Codes with PHP</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<?php
    $eventID = isset($_GET["eventID"])?$_GET["eventID"]:"";
?>
<body>
    <h1>Generating QR Codes with PHP</h1>
    

        
    <form action="process-event-signup.php" method="post" novalidate>
        <div>

            <label for="eventID">Event ID</label>
            <input type="text" id="eventID" name = "eventID" <?php echo "value =$eventID";?> <?php if($eventID != ""){echo "readonly";} ?>>
        </div>
        <div>
            <label for="name">Player Name</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        

        <button>Sign Up</button>
    </form>

</body>
</html>