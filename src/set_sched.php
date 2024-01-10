<?php
session_start();
if (!isset($_POST['schedule'], $_SESSION['id'])) {
  die('Sched not set');
}

$sched = $_POST['schedule'];
$id = $_SESSION['id'];

require "../config/config.php";

$delete = $mainConn->query("DELETE FROM counselor_schedule WHERE counselor_id = '$id'");
if (!$delete) {
  die("Something went wrong");
}

foreach ($sched as $i) {
  if (!$mainConn->query("INSERT INTO counselor_schedule (counselor_id, day_of_week) VALUES ('$id', '$i')")) {
    die("Insert error");
  }
}

echo "success";
