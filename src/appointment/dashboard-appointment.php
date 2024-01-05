<?php

session_start();
if (! isset($_SESSION['id'])) {
    exit('Please login');
}

$id = $_SESSION['id'];

require '../../config/config.php';

$appointments = get_appointments($id, 4);

echo json_encode($appointments);
