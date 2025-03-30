<?php


//<img src="getQR.php?eventID=###" > will call this and get the qr code for the event number ###
$eventID = $_GET["eventID"];

//server connection details
$host = 'sql.cianci.io';
$dbname = 'frequentfliers';
$username = 'rmorrell';
$password = 'e2VaSdfES6sU';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT img FROM QRCode where eventID = $eventID";
$result = $conn->query($sql);
$img = mysqli_fetch_column($result);


echo $img;

exit;