<?php
date_default_timezone_set("Asia/Manila");

if (empty($_POST['date'])) {
    exit('Please fill in all fields');
}

$date = $_POST['date'];


require '../../config/config.php';

$current_time = new DateTime();
$times = array("08:00", "09:00", "10:00", "11:00", "13:00", "14:00", "15:00", "16:00");
$available_times = array();

$current_date = date('m/d/Y');


if($current_date == $date) {
    foreach ($times as $time) {
        $time = DateTime::createFromFormat('H:i', $time);
        if ($time > $current_time) {
            $available_times[] = $time->format('H:i');
        }
    }
} else {
    $available_times = $times;
}


// Prepare the SQL statement with a placeholder for the date
$query = "SELECT appointment_time FROM appointment WHERE appointment_date = STR_TO_DATE(?, '%m/%d/%Y') AND status = 'unfinished'";
$stmt = $mainConn->prepare($query);

// Bind the parameter to the prepared statement
$stmt->bind_param("s", $date);

// Execute the prepared statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['appointment_time'];
    }
}

// Close the prepared statement and free up resources
$stmt->close();

$available_times = array_diff($available_times, $data);

echo json_encode($available_times);
