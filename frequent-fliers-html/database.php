<?php

/*
 * Last Edited By: Cael McDermott
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: database.php
 *
 * This file holds the database connection function.
 * Change the host, database name, username, and password as needed.
 * In any file that needs DB access, include this file:
 *     include('database.php');
 *     $conn = dbConn();
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


