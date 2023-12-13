<?php
if (empty($_POST['id']) || empty($_POST['email']) || empty($_POST['password'])) {
    die();
}

require "../../config/config.php";

$id = $_POST['id'];
$valid = check_id_reg($id);

if (!empty($valid)) {
    echo $valid;
    return;
}

$email = $_POST['email'];
$pwd = $_POST['password'];

if (register_user($id, $email,$pwd)) {
    echo "SUCCESS";
} else {
    echo "ERROR";
}
