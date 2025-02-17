<?php

// change these values to the correct database data
$host = "database-1.c18souwm2mtl.us-east-2.rds.amazonaws.com";
$dbname = "frequent_fliers";
$username = "";
$password = "";

$mysqli = new mysqli(hostname:$host,
                    username: $username,
                    password: $password,
                    database: $dbname);

if ($mysqli->connect_errno){
    die("Connection error: " . $mysqli->connect_errno);
}
return $mysqli;