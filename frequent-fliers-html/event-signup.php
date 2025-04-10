<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Los Angeles Kite Fighting</title>
    <link rel="stylesheet" href="sign-up-styles.css">
</head>
<?php
    $eventID = isset($_GET["eventID"])?$_GET["eventID"]:"";
?>
    <div class="header-bar"></div>
    <div class="lakf-logo">LAKF</div>
    <img class="img" src="cloudBanner.jpg" alt="Cloud Banner"/> <!-- Local path should work once hosted or in same folder -->
    <h1>Sign Up<br/>To Fly!</h1>

    <!--updates HTML form to send data to nonAdminGetTable.php-->
    
    <form action=<?php echo "Guest-Lobby.php?eventID=" . $eventID; ?> method="Post" class="event-form">
    <!-- Need to actually require this, causes errors when not filled out -->
        <div class="form-group">
            <label for="pin">Pin Number*:</label>
            <div class="form-container">
                <input type="text" id="pin" name="eventID" class="form-input" placeholder="1234" required <?php echo "value =$eventID";?> <?php if($eventID != ""){echo "readonly";} ?>>
            </div>
        </div>

        <div class="form-group">
            <label for="name">Flier Name*:</label>
            <div class="form-container">
                <input type="text" id="name" class="form-input" name="playerName" required />
            </div>
        </div>

        <div class="form-group">
            <label for="email">Confirmation Email:*</label>
            <div class="form-container">
                <input type="email" id="email" class="form-input" class="form-input" name="email" required />
            </div>
        </div>

        <div class="form-buttons">
            <input type="reset" />
            <input type="submit" value="Submit Query" />
        </div>
    </form>
      
    </html>