<?php

if (empty($_POST['current_user'])) {
    exit('User not found');
}

require '../../config/config.php';

$get_all_post = "SELECT user.first_name, user.last_name, user.user_role ,post.post_id,post.poster_id, post.post_text, post.anonymous_post, DATE_FORMAT(post.date_posted, '%M %e, %Y') AS formatted_date FROM post INNER JOIN user ON post.poster_id = user.user_id ORDER BY post.date_posted DESC";
$all_post = $mainConn->query($get_all_post);

// $temp_id  = "21-UR-0001";
$current_user = $_POST['current_user'];
$post_data = [];

if ($all_post->num_rows > 0) {
    while ($row = $all_post->fetch_assoc()) {

        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $post_id = $row['post_id'];
        $post_text = $row['post_text'];
        $poster_id = $row['poster_id'];
        $is_anonymous = $row['anonymous_post'] == 1;
        $date_posted = $row['formatted_date'];
        $user_role = $row['user_role'];

        $get_image = "SELECT * FROM post_images WHERE post_id = '$post_id'";
        $image = $mainConn->query($get_image);
        $image_path = '';

        $get_likes = "SELECT * FROM post_likes WHERE post_id = '$post_id'";
        $likes = $mainConn->query($get_likes)->num_rows;

        $get_liked = "SELECT * FROM post_likes WHERE post_id = '$post_id' AND user_id = '$current_user'";
        $is_liked = $mainConn->query($get_liked)->num_rows > 0;

        $get_comments = "SELECT * FROM post_comments WHERE post_id = '$post_id'";
        $comments = $mainConn->query($get_comments)->num_rows;

        if ($image->num_rows > 0) {
            $image_path = $image->fetch_assoc()['image_file_path'];
        }

        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'post_id' => $post_id,
            'post_text' => $post_text,
            'poster_id' => $poster_id,
            'is_anonymous' => $is_anonymous,
            'date_posted' => $date_posted,
            'user_role' => $user_role,
            'image' => $image_path,
            'likes' => $likes,
            'liked' => $is_liked,
            'comments' => $comments,
        ];
        $post_data[] = $data;
    }
}

echo json_encode($post_data);
