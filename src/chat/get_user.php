<?php

if (empty($_POST['id'])) {
  exit('Data is not set');
}

$id = $_POST['id'];

require '../../config/config.php';
$q = "SELECT user_id, first_name, last_name, user_role FROM user WHERE user_id != '$id'";
echo json_encode(get_user_info($id));
