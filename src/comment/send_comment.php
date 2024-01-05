<?php

if (empty($_POST['user_id']) || empty($_POST['comment']) || empty($_POST['post_id'])) {
    exit('Comment not found');
}

$current_user = $_POST['user_id'];
$comment = $_POST['comment'];
$post_id = $_POST['post_id'];

require '../../config/config.php';

$query = "INSERT INTO post_comments (post_id, user_id, comment_text) VALUES ($post_id, '$current_user', '$comment')";

$result = $mainConn->query($query);

if (! $result) {
    exit($mainConn->error);
}

echo 'SUCCESS';
