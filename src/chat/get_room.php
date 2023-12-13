<?php
session_start();
if (empty($_POST['receiver']) || empty($_SESSION['id'])) {
    die();
}

require "../../config/config.php";

$sender = $_SESSION['id'];
$receiver = $_POST['receiver'];
$result = $mainConn->query("SELECT room_id FROM 100ms_rooms WHERE counselor_id = '$sender'");
$data = $result->fetch_assoc();

$codes = get_room_code($data['room_id']);
$room_patient = "https://dawnj26-videoconf-1956.app.100ms.live/meeting/" . $codes['patient'];
$room_host = "https://dawnj26-videoconf-1956.app.100ms.live/meeting/" . $codes['host'];

insert_data("INSERT INTO chat (sender_id, receiver_id, text_message) VALUES ('$sender', '$receiver', '$room_patient')");

$links = array($room_host, $room_patient);

echo json_encode($links);