<?php
print_r($_POST);
if(empty($_POST["name"])){
    die("Name is Required");
}

if(! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Valid email is Required");
}


if(strlen($_POST["password"]) < 8){
    die("Password must be at least 8 Characters long");
}


if(! preg_match("/[a-z]/i", $_POST["password"])){
    die("Password must contain at least 1 letter");
}

if(! preg_match("/[0-9]/", $_POST["password"])){
    die("Password must contain at least 1 letter");
}

if($_POST["password"] !== $_POST["password_confirm"]){
    die("Password must match confirmation");
}


$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";


$sql = "INSERT INTO user (name, email, password_hash) VALUES (?,?,?)";

$stmt = $mysqli->stmt_init();

if( ! $stmt->prepare($sql)){
    die("SQL error " . $mysqli->error);
}

$stmt->bind_param("sss",$_POST["name"], $_POST["email"], $password_hash);  


if ($stmt->execute()){
    header("Location : signup-success.html");
    exit;
}else{
    die($mysqli->error . " " . $mysqli->errno);
}
