<?php

if (empty($_POST['id']) || empty($_POST['role'])) {
    die("Data is not set");
}

require "../config/config.php";

global $schoolConn;

$role = $_POST['role'];
$id = $_POST['id'];
$gender = $role . "_gender";

$result = $schoolConn->query("SELECT DATE_FORMAT(birth_date, '%M %e, %Y') AS birth_date, $gender AS gender  FROM student WHERE student_id = '$id'");

$data = $result->fetch_assoc();

echo json_encode($data);