<?php

require '../../config/config.php';

$query = "SELECT * FROM appointment";
$result = $mainConn->query($query);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $current_date = new DateTime(date('Y-m-d'));
    $appointment_date = new DateTime($row['appointment_date']);
    $appointment_time = new DateTime($row['appointment_time']);

    if ($current_date > $appointment_date || ($current_date == $appointment_date && $current_time > $appointment_time)) {
      $q = "UPDATE appointment SET status = 'finished' WHERE appointment_id = '$row[appointment_id]'";
      $mainConn->query($q);
    }

  }
}
