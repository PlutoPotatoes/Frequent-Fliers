<?php

$host = "localhost";
$dbname = "login_db";
$username = "root";
$passwork = "";

$mysqli = new mysqli(hostname:$host,
                    username: $username,
                    password: $password,
                    database: $dbname);

if ($mysqli->connect_errno){
    die("Connection error: " . $mysqli->connect_errno);
}
return $mysqli;