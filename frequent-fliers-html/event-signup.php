<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Los Angeles Kite Fighting</title>
    <link rel="stylesheet" href="styles.css">
</head>

<?php
    $eventID = isset($_GET["eventID"])?$_GET["eventID"]:"";
?>

<div class="header-bar"></div>
    <h3>LAKF</h3>
    <img class="img" src="https://t3.ftcdn.net/jpg/02/67/83/92/360_F_267839295_jVbzpVskpRpnPaq3xLFjjX9gYjNRocxN.jpg"/> <!--added img, FIXME need to fix size-->
    <h1>Sign Up<br/>To Fly!</h1>
    <form action = "process-event-signup.php" method="post">
        <div>
            <label for="eventID">Pin Number:</label>
            <input name="eventID" type="text" id="eventID" <?php echo "value =$eventID";?> <?php if($eventID != "") {echo "readonly";}?>>
        </div>
        <br>
        <div>
            <label for="name">Flier Name:</label>
            <input name="name" type="text" id="name">
        </div>
        <br>
            <label for="email">Email:</label>
            <input name="email" type="email" id="email" placeholder="johndoe@gmail.com">
        </div>

        <div>
            <input type="reset">
        </div>

        <div>
            <input type="submit">
    </form>
    </body>
    </html>