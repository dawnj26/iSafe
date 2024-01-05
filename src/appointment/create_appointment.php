<?php

if (empty($_POST['violence']) || empty($_POST['description']) || empty($_POST['dateOfEvent']) || empty($_POST['timeOfEvent']) || empty($_POST['counselor']) || empty($_POST['dateOfAppointment']) || empty($_POST['timeOfAppointment']) || empty($_POST['latitude']) || empty($_POST['longitude'])) {
    exit('Please fill in all fields');
}

//session_start();
//if (!isset($_SESSION['user_id'])) {
//    exit('Please login');
//}

$id = '21-UR-0001';
$violence = $_POST['violence'];
$description = $_POST['description'];
$dateOfEvent = $_POST['dateOfEvent'];
$timeOfEvent = $_POST['timeOfEvent'];
$counselor = $_POST['counselor'];
$dateOfAppointment = $_POST['dateOfAppointment'];
$timeOfAppointment = $_POST['timeOfAppointment'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

require '../../config/config.php';

$q = "INSERT INTO appointment (creator_id, counselor_id, report_title, report_desc, time_of_event, date_of_event,status,map_longitude, map_latitude, appointment_time, appointment_date) VALUES ('$id', '$counselor', '$violence', '$description', '$timeOfEvent', STR_TO_DATE('$dateOfEvent', '%m/%d/%Y'), 'unfinished', '$longitude', '$latitude', '$timeOfAppointment', STR_TO_DATE('$dateOfAppointment', '%m/%d/%Y'))";

if (! insert_data($q)) {
    exit('Query error');
}

echo 'SUCCESS';
