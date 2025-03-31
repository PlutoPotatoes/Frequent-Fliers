<?php

// change these values to the correct database data
// Put these in a function we can include whereever needed??
// return $mysqli/$conn



//info is correct for Cianci's database but access is denied for my user
$host = 'sql.cianci.io';
$dbname = 'frequentfliers';
$username = 'rmorrell';
$password = 'e2VaSdfES6sU';

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno){
    die("Connection error: " . $mysqli->connect_errno);
}
return $mysqli;
