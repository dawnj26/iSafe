<?php
if (empty($_POST['id'])) {
    die();
}

require "../../config/config.php";

$id = $_POST['id'];
$valid = check_id_login($id);

if (!empty($valid)) {
    echo $valid;
    return;
}


