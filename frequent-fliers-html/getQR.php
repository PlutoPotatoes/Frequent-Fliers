<?php


//<img src="getQR.php?eventID=###" > will call this and get the qr code for the event number ###
include('database.php');

$eventID = $_GET["eventID"];


$conn = dbConn();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT img FROM QRCode where eventID = $eventID";
$result = $conn->query($sql);
$img = mysqli_fetch_column($result);


echo $img;

exit;