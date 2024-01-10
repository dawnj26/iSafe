<?php

if (empty($_POST['post_id'])) {
    exit('ID not found');
}

$post_id = $_POST['post_id'];

require '../../config/config.php';

$query = "SELECT user.user_id, user.first_name, user.last_name, post_comments.comment_text, DATE_FORMAT(post_comments.comment_date_created, '%M %e, %Y') AS formatted_date FROM post_comments INNER JOIN user ON post_comments.user_id = user.user_id WHERE post_id = $post_id";
$result = $mainConn->query($query);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row_data = [
            'user_id' => $row['user_id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'comment' => $row['comment_text'],
            'date' => $row['formatted_date'],
        ];

        $data[] = $row_data;
    }
}

echo json_encode($data);
