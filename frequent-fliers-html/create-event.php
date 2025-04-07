<?php

require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;



//connect to DB
$host = 'sql.cianci.io';
$dbname = 'frequentfliers';
$username = 'rmorrell';
$password = 'e2VaSdfES6sU';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//grab data from the form
$event = $_POST["event-name"];
$name = $_POST["host-name"];
$email = $_POST["email"];

//create event in the kiteEvent table
$sql = "INSERT INTO kiteEvent (eventName)
VALUES (\"$event\");";

if ($conn->query($sql) === TRUE) {
    //on success get eventID
    $eventID = $conn -> insert_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    die();
}


//create QR code using new eventID
$qrCode = new QrCode("http://localhost:8000/event-signup.php?eventID=$eventID");
$writer = new PngWriter();

//save the QRCode Momentarily 
$QRPNG = $writer->write($qrCode);
$QRPNG -> saveToFile(__DIR__."/QRCodes/qrcode$eventID.png");

//get QRCode string data
$QRContent = file_get_contents(__DIR__."/QRCodes/qrcode$eventID.png");

//Insert QRCode String into QRCode table
$sql = "INSERT INTO QRCode (img, eventID) VALUES (?, $eventID);";
$statement = $conn -> prepare($sql);
$statement->bind_param('s', $QRContent);
$current_id = $statement->execute() or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_connect_error());

//Delete Temporary QRCode image in this directory
unlink(__DIR__."/QRCodes/qrcode$eventID.png");

//Retrieve the QR Code and echo
//can retrieve any QR code by replacing the eventID with a different event
$sql = "SELECT img FROM QRCode WHERE eventID = $eventID;";
$QRCode = $conn->query($sql);

//echos the img embedding script in HTML
echo '<img src="data:image/jpeg;base64,' . base64_encode($QRContent) . '" alt="Uploaded Image" style="max-width: 500px;">';


//add creator as player
$sql = "INSERT INTO attendee (playerName, email, eventID) 
VALUES (\"$name\", \"$email\", $eventID);";

if ($conn->query($sql) === TRUE) {
    header("Location: http://localhost:8000/Host-Lobby.php?eventID=$eventID"); //FIXME CHANGE THIS TO NEW EVENT LOBBY
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
