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

    <!--updates HTML form to send data to nonAdminGetTable.php-->
    
    <form action=<?php echo "Guest-Lobby.php" . $eventID ?> method="Post">
        <label for="eventID">Pin Number:</label>
        <input type="text" id="evenID" name="eventID" placeholder="12345678" <?php echo "value =$eventID";?> <?php if($eventID != ""){echo "readonly";} ?> required />
      
        <label for="name">Flier Name:</label>
        <input type="text" id="name" name="playerName" required />
      
        <label for="email">Confirmation Email:</label>
        <input type="email" id="email" name="email" required />
      
        <input type="reset" />
        <input type="submit" value="Submit Query" />
      </form>
      
    </html>