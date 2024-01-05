<?php

if (empty($_POST['id']) || empty($_POST['message'])) {
    exit('Data is empty');
}
session_start();
if (! isset($_SESSION['id'])) {
    exit();
}
require '../../config/config.php';

global $mainConn;

$sender = $_SESSION['id'];
$receiver = $_POST['id'];
$message = $_POST['message'];

if (! $mainConn->query("INSERT INTO chat (sender_id, receiver_id, text_message) VALUES ('$sender', '$receiver', '$message')")) {
    exit('Query Error!');
}
