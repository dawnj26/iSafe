<?php

require "../config/config.php";

global $mainConn;

$id = '21-UR-0001';

$query = "
            SELECT user.user_id, user.first_name, user.last_name, user.user_role
            FROM (
                SELECT sender_id AS user_id
                FROM chat
                WHERE receiver_id = '$id' -- Replace ? with your user ID
                UNION
                SELECT receiver_id AS user_id
                FROM chat
                WHERE sender_id = '$id' -- Replace ? with your user ID
            ) chat
            INNER JOIN user ON chat.user_id = user.user_id;
        ";

$result = $mainConn->query($query);
$json = array();

if ($result->num_rows > 0) {
    while($data = $result->fetch_assoc()) {
        $full_name = $data['first_name'] . " "  . $data['last_name'];
        $receiver_id = $data['user_id'];
        $initials = strtoupper(substr($data['first_name'], 0, 1)) . strtoupper(substr($data['last_name'], 0, 1));
        $message = $mainConn->query("
        SELECT text_message
            FROM chat
            WHERE (sender_id = '$id' AND receiver_id = '$receiver_id')
            	OR (sender_id = '$receiver_id' AND receiver_id = '$id')
            ORDER BY chat_date DESC LIMIT 1
        ")->fetch_assoc();
        $message = truncateString($message['text_message']);
        $json[] = array('user_id'=>$receiver_id, 'full_name'=>$full_name, 'initials'=>$initials, "user_role"=>$data['user_role'], "message"=>$message);

    }

}

function truncateString($str)
{
    $wordCount = 5;
    // Explode the string into an array of words
    $words = explode(' ', $str);

    // Check if the number of words exceeds the limit
    if (count($words) > $wordCount) {
        // Truncate the array of words and join them back to form a string
        $truncated = implode(' ', array_slice($words, 0, $wordCount)) . '...';
        return $truncated;
    }

    return $str; // Return the original string if it's within the limit
}


echo json_encode($json);