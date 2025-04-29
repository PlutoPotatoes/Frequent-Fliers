<?php

/*
    This file holds the database connection function:
    1. change the host, database name, username, and password as needed
    2. in any file that needs DB access call
        include('database.php');
        $conn = dbConn();

    Last edited by Ryan Morrell 4/28/25
*/



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


