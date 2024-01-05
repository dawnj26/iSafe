<?php

if (empty($_POST['post-text']) || ! isset($_POST['post-text']) || empty($_POST['poster_id']) || ! isset($_POST['poster_id'])) {
    exit();
}

$anonymous = 0;
if (isset($_POST['anonymous-post'])) {
    $anonymous = 1;
}

// $temp_id = "21-UR-0001";
$user_id = $_POST['poster_id'];
$desc = $_POST['post-text'];

$image_file_path = upload();
require '../../config/config.php';

$query = "INSERT INTO post (poster_id, post_text, anonymous_post) VALUES ('$user_id', '$desc', $anonymous)";
$result = $mainConn->query($query);
if (! $result) {
    exit('Error: '.$mainConn->error);
}

if (! empty($image_file_path)) {
    $insert_id = $mainConn->insert_id;
    $query = "insert into post_images (image_file_path, post_id) values ('$image_file_path', $insert_id)";
    $result = $mainConn->query($query);

    if (! $result) {
        exit('Error: '.$mainConn->error);
    }
}

echo 'SUCCESS';

function upload()
{

    if (! isset($_FILES['image']) || empty($_FILES['image']['tmp_name'])) {
        return '';
    }
    $file_path = $_FILES['image']['tmp_name'];
    $file_size = filesize($file_path);

    if ($file_size === 0) {
        return '';
    }

    $file_name = basename($file_path);
    $target_dir = __DIR__.'/uploads/';
    $rand_string = uniqid();
    $unique_file_name = $rand_string.'_'.$file_name;

    $upload_file_path = $target_dir.$unique_file_name;

    if (! copy($file_path, $upload_file_path)) {
        return '';
    }

    unlink($file_path);

    return $upload_file_path;
}
