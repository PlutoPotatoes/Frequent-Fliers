<?php

require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// this code cannot be used to display a png in an HTML file
// instead we have to use this to create the image, save the png to the database, 
// and then display the png in an <img> tag as the source file.

//$qrCode = new QrCode($eventID);
$qrCode = new QrCode("http://localhost:8000/eventSignup.php?eventID=$eventID");
$writer = new PngWriter();

$result = $writer->write($qrCode);

header("Content-Type: " . $result->getMimeType());
echo $result->getString();
exit;   

