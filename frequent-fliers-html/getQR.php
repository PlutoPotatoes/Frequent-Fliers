<?php

/*
 * Last Edited By: Cael McDermott
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: getQR.php
 *
 * This file retrieves the correct QR code for easy use in lobbies.
 * Called using:
 *     <img src="getQR.php?eventID=###">
 * It queries the database for the QR code image associated with the
 * provided eventID and returns the image.
 */

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