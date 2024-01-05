<?php

session_start();

if (! isset($_SESSION['id'])) {
    exit('Please login first');
}

require '../../config/config.php';

$locations = get_incident_locations();

echo json_encode($locations);
