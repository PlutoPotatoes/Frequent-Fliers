<?php

/*
 * Last Edited By: Cael McDermott
 * Date: May 3rd, 2025
 * Course: CS 367 - Practicum
 * File: create-event.php
 *
 * This PHP file serves as an intermediary between the host-event.html form and the Host-Lobby.php page.
 * It performs the following:
 * 1. Connects to the database, creates a new QRCode and PNGWriter (using the Endroid package),
 *    and generates a QRCode linking to the signup page with the correct eventID.
 * 2. Stores the generated QRCode PNG as a temporary file, inserts it into the database, and deletes the temp file.
 * 3. Adds the event host to the database as a player.
 * 4. Redirects to Host-Lobby.php to display the event lobby.
 */



require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
include('database.php');
$conn = dbConn();

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



//Retrieve the QR Code
//can retrieve any QR code by replacing the eventID with a different event
$sql = "SELECT img FROM QRCode WHERE eventID = $eventID;";
$QRCode = $conn->query($sql);

//example echo used to call the QR Code
//echo '<img src="data:image/jpeg;base64,' . base64_encode($QRContent) . '" alt="Uploaded Image" style="max-width: 500px;">';


//add creator as player
$sql = "INSERT INTO attendee (playerName, email, eventID) 
VALUES (\"$name\", \"$email\", $eventID);";

//Delete Temporary QRCode image in this directory
unlink(__DIR__."/QRCodes/qrcode$eventID.png");

if ($conn->query($sql) === TRUE) {
    header("Location: Host-Lobby.php?eventID=$eventID"); //FIXME CHANGE THIS TO NEW EVENT LOBBY
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
