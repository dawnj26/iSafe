<?php

$host = "localhost";
$user = "root";
$pwd = "";

$schoolDB = "school_db";
$mainDB = "iSafe";

$mainConn = new mysqli($host, $user, $pwd, $mainDB);
$schoolConn = new mysqli($host, $user, $pwd, $schoolDB);

if ($mainConn->connect_errno || $schoolConn->connect_errno) {
    die("Failed to connect to the database");
}

function get_user_role($id): string
{
    global $schoolConn;

    $tables = array("admin", "counselor", "student", "teacher");

    foreach ($tables as $item) {
        $query = "SELECT " . $item ."_id FROM $item";
        $result = $schoolConn->query($query);
        if ($result->num_rows > 0) {
            return $item;
        }
    }

    return "";
}

function register_user($id, $email, $password) : bool{
    // check if the user is a student in PSU
    if(empty(get_user_role($id))) {
        return false;
    }

    global $mainConn;

    // encrypt password
    $encrypted_pwd = password_hash($password, PASSWORD_DEFAULT);

    $insert_query = "INSERT INTO user (user_id, email_address, password) VALUES '$id', '$email', '$encrypted_pwd'";
    $result = $mainConn->query($insert_query);

    if (!$result) {
        echo "Error: " . $mainConn->error;
        return false;
    }

    return true;
}