<?php

if (empty($_POST['id']) || empty($_POST['message'])) {
    die("Data is empty");
}

require "../config/config.php";

global $mainConn;

$sender = "21-UR-0001";
$receiver = $_POST['id'];
$message = $_POST['message'];

if (!$mainConn->query("INSERT INTO chat (sender_id, receiver_id, text_message) VALUES ('$sender', '$receiver', '$message')")) {
    die("Query Error!");
}