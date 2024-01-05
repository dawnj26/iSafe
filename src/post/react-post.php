<?php

if (empty($_POST['post_id']) || empty($_POST['user_id'])) {
    echo $_POST['post_id'].' '.$_POST['user_id'].' '.$_POST['is_liked'];
    exit();
}

require '../../config/config.php';

$post_id = $_POST['post_id'];
$user_id = $_POST['user_id'];
$is_liked = $_POST['is_liked'] === '1';

$query = "INSERT INTO post_likes (post_id, user_id) VALUES ('$post_id', '$user_id')";

if ($is_liked) {

    $get_like_id = "SELECT like_id FROM post_likes WHERE post_id = $post_id AND user_id = '$user_id'";
    $like_id = $mainConn->query($get_like_id)->fetch_assoc()['like_id'];

    $query = "DELETE FROM post_likes WHERE like_id = $like_id";
    $is_liked = false;
}

$result = $mainConn->query($query);

if (! $result) {
    exit($mainConn->error);
}

echo 'SUCCESS';
