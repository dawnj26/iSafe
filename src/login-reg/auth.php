<?php
if (empty($_POST['id']) || empty($_POST['password'])) {
    echo "ID and Password must not be empty";
    die();
}

require "../../config/config.php";

$id = $_POST['id'];
$password = $_POST['password'];
$valid = check_id_login($id);

if (!empty($valid)) {
    echo $valid;
    return;
}

$result = $mainConn->query("SELECT user_id, user_password, user_role FROM user WHERE user.user_id = '$id'");

if ($result->num_rows <= 0) {
    echo "Account ID is not registered";
    return;
}

$data = $result->fetch_assoc();
if (!password_verify($password, $data['user_password'])) {
    echo "Incorrect password";
    return;
}

session_start();
$_SESSION['id'] = $id;
$_SESSION['role'] = $data['user_role'];

echo $data['user_role'];