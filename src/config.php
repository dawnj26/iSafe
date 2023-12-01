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