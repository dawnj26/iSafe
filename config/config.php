<?php

$host = "localhost";
$user = "root";
$pwd = "";

$schoolDB = "school_db";
$mainDB = "iSafe";

$mainConn = new mysqli($host, $user, $pwd, $mainDB);
$schoolConn = new mysqli($host, $user, $pwd, $schoolDB);

$management_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MDE1MjE3NzcsImV4cCI6MTcwMTYwODE3NywianRpIjoiand0X25vbmNlIiwidHlwZSI6Im1hbmFnZW1lbnQiLCJ2ZXJzaW9uIjoyLCJuYmYiOjE3MDE1MjE3NzcsImFjY2Vzc19rZXkiOiI2NTYwOGY4MzY4MTExZjZmZTRiNTdmOWIifQ.-MjLdJwVegd9Z4COeH3z2dt_vxrgtb_-wt5QE2KiCpg>';

if ($mainConn->connect_errno || $schoolConn->connect_errno) {
    die("Failed to connect to the database");
}

function get_user_role($id): array
{
    global $schoolConn;

    $tables = array("admin", "counselor", "student", "teacher");

    foreach ($tables as $item) {
        $query = "SELECT " . $item . "_id, first_name, last_name FROM $item";
        $result = $schoolConn->query($query);
        if ($result->num_rows > 0) {
            $data = $result->fetch_array();
            return array('id' => $data[0], 'first_name' => $data[1], 'last_name' => $data[2]);
        }
    }

    return array();
}

function register_user($id, $email, $password): bool
{

    $user_info = get_user_role($id);
    // check if the user is a student in PSU
    if (empty($user_info)) {
        return false;
    }

    global $mainConn;

    // encrypt password
    $encrypted_pwd = password_hash($password, PASSWORD_DEFAULT);

    $insert_query = "INSERT INTO user (user_id, email_address, password) VALUES '$id', '$email', '$encrypted_pwd'";

    if (!insert_data($insert_query))
        return false;

    // set room id for 100ms vid call for counselors
    if ($user_info['id'] === "counselor") {
        return set_room_id($user_info['id']);
    }

    return true;
}

function set_room_id($user_id): bool
{

    global $management_token;
    $url = 'https://api.100ms.live/v2/rooms';
    $templateId = '65608f96b198c75233a7fcb0';

    $room_id = "";

    $data = array(
        'name' => 'new-room-1662723668',
        'description' => 'This is a sample description for the room',
        'template_id' => $templateId
    );

    $headers = array(
        'Authorization: Bearer ' . $management_token,
        'Content-Type: application/json'
    );

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = json_decode(curl_exec($ch), true);

    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
        curl_close($ch);
        return false;
    }

    $room_id = $response['id'];

    curl_close($ch);

    $q = "INSERT INTO 100ms_rooms VALUES '$room_id', '$user_id'";

    return insert_data($q);
}

function insert_data($insert_query): bool
{
    global $mainConn;

    $result = $mainConn->query($insert_query);
    if (!$result) {
        echo "Error: " . $mainConn->error;
        return false;
    }

    return true;
}

function get_room_code($room_id)
{
    global $management_token;

    $url = 'https://api.100ms.live/v2/room-codes/room/' . $room_id;

    $headers = array(
        'Authorization: Bearer ' . $management_token,
        'Content-Type: application/json'
    );

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = json_decode(curl_exec($ch), true);

    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
        curl_close($ch);
        return array();
    }

    curl_close($ch);

    return array('host' => $response['data'][0]['code'], 'patient' => $response['data'][1]['code']);
}
