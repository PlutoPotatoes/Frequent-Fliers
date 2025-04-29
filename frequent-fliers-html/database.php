<?php

// change these values to the correct database data
// Put these in a function we can include whereever needed??
// return $mysqli/$conn



//info is correct for Cianci's database but access is denied for my user


function dbConn(){
    $host = 'sql.cianci.io';
    $dbname = 'frequentfliers';
    $username = 'rmorrell';
    $password = 'e2VaSdfES6sU';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


