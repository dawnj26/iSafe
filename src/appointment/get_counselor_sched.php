<?php
if (empty($_POST['counselor_id'])) {
    exit('Please fill in all fields');
}

require '../../config/config.php';

$id = $_POST['counselor_id'];

$q = "SELECT day_of_week FROM couselor_schedule WHERE couselor_id = '$id'";
$result = $mainConn->query($q);
$days = array();
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $days[] = $row['day_of_week'];
    }

}
echo json_encode($days);