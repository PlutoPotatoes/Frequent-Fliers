<?php

require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


// before making the QR code create the Event instance in the DB
// use the Event ID to create the QR Code 
// QR code should go to a signup.php file where a global variable is set to the ID 
// So: when the form submits it creates an attendee with the event ID set to the prepopulated field
// link to signup.php/eventID in the QR Code

// insert event into DB with $_POST details
// get event PK
// link to prepopulated signup with event ID



//$qrCode = new QrCode($eventID);
$qrCode = new QrCode("Replace this with link to signup w/ eventID Populated");
$writer = new PngWriter();

$result = $writer->write($qrCode);

header("Content-Type: " . $result->getMimeType());
echo $result->getString();
exit;   