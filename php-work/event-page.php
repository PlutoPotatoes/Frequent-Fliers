<!DOCTYPE html>
<html>
    <?php
    // this page must be passed with a ?eventID=#### in the url

    $eventID = $_GET["eventID"];
    //server connection details
    //should probably be more secure with the password or make read only account
    $servername = "localhost";
    $username = "username";
    $password = "password";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection, kill site on fail
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    // Query connection, place the selected row in $row
    $qrQuery = "SELECT eventName, QRCode, eventTime, eventLocation from events where events.eventID= $eventID";
    $results = $conn->query($qrQuery);
    $row = $results->fetch_assoc();

    // Get column values from $row
    // once connected and entries exists replace text in the site with references to these variables
    $eventName = $row["eventName"];
    $eventTime = $row["eventTime"];
    $eventLocation = $row["eventLocation"];
    $QRCode = $row["QRCode"];

    // close connection
    $conn->close();
    ?>
<head>
    <!--FIXME at some point change sizing for viewport <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" href="styles.css">
</head> <!--FIXME - add metadata?-->
<div style="width: 393px; height: 849px; position: relative; background: #FFD6C0">
<img class="img" src="https://t3.ftcdn.net/jpg/02/67/83/92/360_F_267839295_jVbzpVskpRpnPaq3xLFjjX9gYjNRocxN.jpg"/> <!--added img, FIXME need to fix size-->
    <div style="width: 301px; height: 108px; left: 43px; top: 95px; position: absolute; text-align: center; color: #EC368D; font-size: 36px; font-family: Faster One; font-weight: 400; word-wrap: break-word; text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)">Los Angeles Kite Fighting</div>
    <div style="width: 393px; height: 55px; left: 0px; top: 0px; position: absolute; background: #FFA5A5"></div>
    <div style="width: 393px; height: 55px; left: 0px; top: 243px; position: absolute; background: #FFA5A5"></div>
    <div data-svg-wrapper style="left: 345px; top: 8px; position: absolute">
    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0.5 20C0.5 9.23045 9.23045 0.5 20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20Z" fill="#2C2C2C"/>
    <path d="M0.5 20C0.5 9.23045 9.23045 0.5 20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20Z" stroke="#2C2C2C" stroke-linecap="round"/>
    <path d="M26.6667 27.5V25.8333C26.6667 24.9493 26.3155 24.1014 25.6904 23.4763C25.0652 22.8512 24.2174 22.5 23.3333 22.5H16.6667C15.7826 22.5 14.9348 22.8512 14.3096 23.4763C13.6845 24.1014 13.3333 24.9493 13.3333 25.8333V27.5M23.3333 15.8333C23.3333 17.6743 21.8409 19.1667 20 19.1667C18.159 19.1667 16.6667 17.6743 16.6667 15.8333C16.6667 13.9924 18.159 12.5 20 12.5C21.8409 12.5 23.3333 13.9924 23.3333 15.8333Z" stroke="#F5F5F5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    </div>
    <div style="width: 86px; height: 27px; left: 0px; top: 18px; position: absolute; text-align: center; color: #EC368D; font-size: 20px; font-family: Faster One; font-weight: 400; word-wrap: break-word">LAKF</div>
    <div style="width: 317px; left: 34px; top: 249px; position: absolute; justify-content: flex-start; align-items: center; gap: 16px; display: inline-flex">
        <div style="flex: 1 1 0; height: 40px; padding: 12px; background: #78C0E0; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 8px; overflow: hidden; border: 1px #2C2C2C solid; justify-content: center; align-items: center; gap: 8px; display: flex">
            <div data-svg-wrapper style="position: relative">
            <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_138_297)">
            <path d="M8.25001 1.33337L10.31 5.50671L14.9167 6.18004L11.5833 9.42671L12.37 14.0134L8.25001 11.8467L4.13001 14.0134L4.91668 9.42671L1.58334 6.18004L6.19001 5.50671L8.25001 1.33337Z" stroke="#EC368D" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            <defs>
            <clipPath id="clip0_138_297">


            <img class="QRCode" src = "<?php echo "$QRCode"; ?>"  alt= "Event QR Code" width="16" height="16" /> <!--FIXME QR CODE STYLING WILL NEED ADJUSTMENT-->

            
            </clipPath>
            </defs>
            </svg>
            </div>
            <div style="color: #EC368D; font-size: 16px; font-family: Inter; font-weight: 400; line-height: 16px; word-wrap: break-word">Host an Event</div>
        </div>
        <div style="flex: 1 1 0; height: 40px; padding: 12px; background: #78C0E0; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 8px; overflow: hidden; border: 1px #2C2C2C solid; justify-content: center; align-items: center; gap: 8px; display: flex">
            <div data-svg-wrapper style="position: relative">
            <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.25 14.6667C11.6944 14.6667 11.2222 14.4723 10.8333 14.0834C10.4444 13.6945 10.25 13.2223 10.25 12.6667C10.25 12.5889 10.2556 12.5084 10.2667 12.425C10.2778 12.3417 10.2944 12.2667 10.3167 12.2L5.61667 9.46671C5.42778 9.63337 5.21667 9.76393 4.98333 9.85837C4.75 9.95282 4.50556 10 4.25 10C3.69444 10 3.22222 9.8056 2.83333 9.41671C2.44444 9.02782 2.25 8.5556 2.25 8.00004C2.25 7.44449 2.44444 6.97226 2.83333 6.58337C3.22222 6.19449 3.69444 6.00004 4.25 6.00004C4.50556 6.00004 4.75 6.04726 4.98333 6.14171C5.21667 6.23615 5.42778 6.36671 5.61667 6.53337L10.3167 3.80004C10.2944 3.73337 10.2778 3.65837 10.2667 3.57504C10.2556 3.49171 10.25 3.41115 10.25 3.33337C10.25 2.77782 10.4444 2.3056 10.8333 1.91671C11.2222 1.52782 11.6944 1.33337 12.25 1.33337C12.8056 1.33337 13.2778 1.52782 13.6667 1.91671C14.0556 2.3056 14.25 2.77782 14.25 3.33337C14.25 3.88893 14.0556 4.36115 13.6667 4.75004C13.2778 5.13893 12.8056 5.33337 12.25 5.33337C11.9944 5.33337 11.75 5.28615 11.5167 5.19171C11.2833 5.09726 11.0722 4.96671 10.8833 4.80004L6.18333 7.53337C6.20556 7.60004 6.22222 7.67504 6.23333 7.75837C6.24444 7.84171 6.25 7.92226 6.25 8.00004C6.25 8.07782 6.24444 8.15837 6.23333 8.24171C6.22222 8.32504 6.20556 8.40004 6.18333 8.46671L10.8833 11.2C11.0722 11.0334 11.2833 10.9028 11.5167 10.8084C11.75 10.7139 11.9944 10.6667 12.25 10.6667C12.8056 10.6667 13.2778 10.8612 13.6667 11.25C14.0556 11.6389 14.25 12.1112 14.25 12.6667C14.25 13.2223 14.0556 13.6945 13.6667 14.0834C13.2778 14.4723 12.8056 14.6667 12.25 14.6667ZM12.25 4.00004C12.4389 4.00004 12.5972 3.93615 12.725 3.80837C12.8528 3.6806 12.9167 3.52226 12.9167 3.33337C12.9167 3.14449 12.8528 2.98615 12.725 2.85837C12.5972 2.7306 12.4389 2.66671 12.25 2.66671C12.0611 2.66671 11.9028 2.7306 11.775 2.85837C11.6472 2.98615 11.5833 3.14449 11.5833 3.33337C11.5833 3.52226 11.6472 3.6806 11.775 3.80837C11.9028 3.93615 12.0611 4.00004 12.25 4.00004ZM4.25 8.66671C4.43889 8.66671 4.59722 8.60282 4.725 8.47504C4.85278 8.34726 4.91667 8.18893 4.91667 8.00004C4.91667 7.81115 4.85278 7.65282 4.725 7.52504C4.59722 7.39726 4.43889 7.33337 4.25 7.33337C4.06111 7.33337 3.90278 7.39726 3.775 7.52504C3.64722 7.65282 3.58333 7.81115 3.58333 8.00004C3.58333 8.18893 3.64722 8.34726 3.775 8.47504C3.90278 8.60282 4.06111 8.66671 4.25 8.66671ZM12.25 13.3334C12.4389 13.3334 12.5972 13.2695 12.725 13.1417C12.8528 13.0139 12.9167 12.8556 12.9167 12.6667C12.9167 12.4778 12.8528 12.3195 12.725 12.1917C12.5972 12.0639 12.4389 12 12.25 12C12.0611 12 11.9028 12.0639 11.775 12.1917C11.6472 12.3195 11.5833 12.4778 11.5833 12.6667C11.5833 12.8556 11.6472 13.0139 11.775 13.1417C11.9028 13.2695 12.0611 13.3334 12.25 13.3334Z" fill="#EC368D"/>
            </svg>
            </div>
            <div style="color: #EC368D; font-size: 16px; font-family: Inter; font-weight: 400; line-height: 16px; word-wrap: break-word">Home</div>
        </div>
    </div>
    <div style="width: 316px; height: 75px; left: 39px; top: 419px; position: absolute; background: #FFA5A5; border: 1px #EC368D solid"></div>
    <div style="width: 315px; height: 74px; left: 40px; top: 420px; position: absolute; text-align: center; color: #EC368D; font-size: 40px; font-family: Inter; font-weight: 400; line-height: 52px; word-wrap: break-word">PIN: <?php echo "$eventID"; ?> </div>
    <div style="width: 301px; height: 90px; left: 42px; top: 318px; position: absolute; text-align: center; color: #EC368D; font-size: 36px; font-family: Inter; font-weight: 700; word-wrap: break-word"><?php echo "$eventName";?> </div>
    <div style="width: 150px; height: 150px; left: 122px; top: 534px; position: absolute; background: white; border: 5px black solid"></div>
    <div style="width: 331px; height: 45.01px; left: 19px; top: 711px; position: absolute">
        <div style="width: 276px; height: 0px; left: 55px; top: 44px; position: absolute; border: 3px #EC368D solid"></div>
        <div style="width: 40px; height: 40px; left: 0px; top: 4px; position: absolute">
            <div style="width: 40px; height: 40px; left: 0px; top: 0px; position: absolute; background: #FFA5A5; border-radius: 9999px"></div>
            <div style="width: 22.67px; height: 0px; left: 28px; top: 12px; position: absolute; transform: rotate(139deg); transform-origin: top left; border: 1px #EC368D solid"></div>
            <div style="width: 22.67px; height: 0px; left: 11px; top: 13px; position: absolute; transform: rotate(41deg); transform-origin: top left; border: 1px #EC368D solid"></div>
        </div>
        <div style="width: 274px; height: 32px; left: 57px; top: 0px; position: absolute; color: black; font-size: 20px; font-family: Inter; font-weight: 400; word-wrap: break-word">Flier 1 Name</div>
    </div>
</div>