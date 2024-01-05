<?php

if (empty($_POST['id'])) {
    exit('No filter selected');
}

require '../../config/config.php';

$id = $_POST['id'];

$result = $mainConn->query("DELETE FROM appointment WHERE appointment_id = '$id'");

if ($result) {
    echo 'SUCCESS';
} else {
    echo 'ERROR';
}
