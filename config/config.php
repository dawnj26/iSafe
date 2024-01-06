<?php

$host = 'localhost';
$user = 'root';
$pwd = '';

$schoolDB = 'PSU';
$mainDB = 'iSafe';

$mainConn = new mysqli($host, $user, $pwd, $mainDB);
$schoolConn = new mysqli($host, $user, $pwd, $schoolDB);

$management_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MDI1MjE4NjAsImV4cCI6MTcwMjYwODI2MCwianRpIjoiand0X25vbmNlIiwidHlwZSI6Im1hbmFnZW1lbnQiLCJ2ZXJzaW9uIjoyLCJuYmYiOjE3MDI1MjE4NjAsImFjY2Vzc19rZXkiOiI2NTYwOGY4MzY4MTExZjZmZTRiNTdmOWIifQ.Vd4dTHzkqxohtmg-mSBT0X4CMS3THHFBKZFFnggshHk';

if ($mainConn->connect_errno || $schoolConn->connect_errno) {
    exit('Failed to connect to the database');
}

function get_user_info($id) {
    global $mainConn;
    global $schoolConn;

    $result = $mainConn->query("SELECT user_id, first_name, last_name, user_role, DATE_FORMAT(date_registered, '%M %e, %Y') AS date_registered FROM user WHERE user_id = '$id'");
    $data_isafe = $result->fetch_all(MYSQLI_ASSOC);

    $role = $data_isafe[0]['user_role'];

    $result = $schoolConn->query("SELECT DATE_FORMAT(birth_date, '%M %e, %Y') AS birth_date, student_address, course_code, student_gender FROM $role WHERE student_id = '$id'"); 
    $data_school = $result->fetch_all(MYSQLI_ASSOC);

    return array(
      'id' => $data_isafe[0]['user_id'],
      'first_name' => $data_isafe[0]['first_name'],
      'last_name' => $data_isafe[0]['last_name'],
      'role' => $role,
      'date_registered' => $data_isafe[0]['date_registered'],
      'birth_date' => $data_school[0]['birth_date'],
      'address' => $data_school[0]['student_address'],
      'course_code' => $data_school[0]['course_code'],
      'gender' => $data_school[0]['student_gender'],
    );
}

function get_user_posts($current_user, $user_id) {
  global $mainConn;

  $get_all_post = "SELECT user.first_name, user.last_name, user.user_role ,post.post_id,post.poster_id, post.post_text, post.anonymous_post, DATE_FORMAT(post.date_posted, '%M %e, %Y') AS formatted_date FROM post INNER JOIN user ON post.poster_id = user.user_id WHERE post.poster_id = '$user_id'"; 
  $all_post = $mainConn->query($get_all_post);
  // $temp_id  = "21-UR-0001";
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
  return $post_data;
}
function check_id_login($id_number): string
{
    global $schoolConn;
    global $mainConn;
    //    $tables = array("admin", "counselor", "student", "teacher");
    $count = 0;

    $result = $schoolConn->query("SELECT * FROM student WHERE student_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $count++;
    }
    $result = $schoolConn->query("SELECT * FROM admin WHERE admin_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $count++;
    }
    $result = $schoolConn->query("SELECT * FROM teacher WHERE teacher_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $count++;
    }

    $result = $schoolConn->query("SELECT * FROM counselor WHERE counselor_id =  '$id_number'");

    if ($result->num_rows > 0) {
        $count++;
    }

    //    foreach ($tables as $item) {
    //        $query = "SELECT * FROM $item WHERE $item." . $item ."_id = '$id_number'";
    //        $result = $schoolConn->query($query);
    //        if ($result->num_rows > 0) {
    //            $count++;
    //        }
    //        $result->free_result();
    //    }
    if ($count == 0) {
        return 'ID does not exist in the school database';
    }

    $res = $mainConn->query("SELECT user_id FROM user WHERE user_id = '$id_number'");
    if ($res->num_rows <= 0) {
        return 'ID exists but it is not registered';
    }

    return '';
}

function check_id_reg($id_number): string
{
    global $schoolConn;
    global $mainConn;
    //    $tables = array("admin", "counselor", "student", "teacher");
    $count = 0;

    $result = $schoolConn->query("SELECT * FROM student WHERE student_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $count++;
    }
    $result = $schoolConn->query("SELECT * FROM admin WHERE admin_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $count++;
    }
    $result = $schoolConn->query("SELECT * FROM teacher WHERE teacher_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $count++;
    }

    $result = $schoolConn->query("SELECT * FROM counselor WHERE counselor_id =  '$id_number'");

    if ($result->num_rows > 0) {
        $count++;
    }

    //    foreach ($tables as $item) {
    //        $query = "SELECT * FROM $item WHERE $item." . $item ."_id = '$id_number'";
    //        $result = $schoolConn->query($query);
    //        if ($result->num_rows > 0) {
    //            $count++;
    //        }
    //        $result->free_result();
    //    }
    if ($count == 0) {
        return 'ID does not exist in the school database';
    }

    $res = $mainConn->query("SELECT user_id FROM user WHERE user_id = '$id_number'");
    if ($res->num_rows > 0) {
        return 'ID already registered';
    }

    return '';
}

function get_user_role($id_number): array
{
    global $schoolConn;

    $result = $schoolConn->query("SELECT counselor_id, first_name, last_name, counselor_gender FROM counselor WHERE counselor_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        return ['role' => 'counselor', 'first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'gender' => $data['counselor_gender']];
    }
    $result = $schoolConn->query("SELECT admin_id, first_name, last_name, admin_gender FROM admin WHERE admin_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        return ['role' => 'admin', 'first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'gender' => $data['admin_gender']];
    }
    $result = $schoolConn->query("SELECT teacher_id, first_name, last_name, teacher_gender FROM teacher WHERE teacher_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        return ['role' => 'teacher', 'first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'gender' => $data['teacher_gender']];
    }

    $result = $schoolConn->query("SELECT student_id, first_name, last_name, student_gender FROM student WHERE student_id =  '$id_number'");
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        return ['role' => 'student', 'first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'gender' => $data['student_gender']];
    }

    //    $tables = array("admin", "counselor", "student", "teacher");
    //
    //    foreach ($tables as $item) {
    //        $query = "SELECT " . $item ."_id, first_name, last_name FROM $item";
    //        $result = $schoolConn->query($query);
    //        if ($result->num_rows > 0) {
    //            $data = $result->fetch_array();
    //            return array('id'=>$data[0], 'first_name'=>$data[1], 'last_name'=>$data[2]);
    //        }
    //    }

    return [];
}

function register_user($id, $email, $password): bool
{

    $user_info = get_user_role($id);
    // check if the user is a student in PSU
    if (empty($user_info)) {
        return false;
    }

    $role = $user_info['role'];
    $first_name = $user_info['first_name'];
    $last_name = $user_info['last_name'];
    global $mainConn;

    // encrypt password
    $encrypted_pwd = password_hash($password, PASSWORD_DEFAULT);

    $insert_query = "INSERT INTO user (user_id, email_address, user_password, first_name, last_name, user_role) VALUES ('$id', '$email', '$encrypted_pwd', '$first_name', '$last_name', '$role')";

    if (! insert_data($insert_query)) {
        return false;
    }

    // set room id for 100ms vid call for counselors
    if ($user_info['role'] === 'counselor') {
        return set_room_id($id);
    }

    return true;
}

function set_room_id($user_id): bool
{

    global $management_token; // get the management token from your account
    $url = 'https://api.100ms.live/v2/rooms';
    $templateId = '65608f96b198c75233a7fcb0'; // change this to your template id

    $room_id = '';

    $data = [
        'name' => $user_id,
        'description' => 'This is a sample description for the room',
        'template_id' => $templateId,
    ];

    $headers = [
        'Authorization: Bearer '.$management_token,
        'Content-Type: application/json',
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = json_decode(curl_exec($ch), true);

    if (curl_errno($ch)) {
        echo 'Error: '.curl_error($ch);
        curl_close($ch);

        return false;
    }

    $room_id = $response['id'];

    curl_close($ch);

    $q = "INSERT INTO 100ms_rooms (room_id, counselor_id) VALUES ('$room_id', '$user_id')";

    return insert_data($q);
}

function insert_data($insert_query): bool
{
    global $mainConn;

    $result = $mainConn->query($insert_query);
    if (! $result) {
        echo 'Error: '.$mainConn->error;

        return false;
    }

    return true;
}

function get_room_code($room_id)
{
    global $management_token;

    $url = 'https://api.100ms.live/v2/room-codes/room/'.$room_id;

    $headers = [
        'Authorization: Bearer '.$management_token,
        'Content-Type: application/json',
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = json_decode(curl_exec($ch), true);

    if (curl_errno($ch)) {
        echo 'Error: '.curl_error($ch);
        curl_close($ch);

        return [];
    }

    curl_close($ch);

    return ['host' => $response['data'][0]['code'], 'patient' => $response['data'][1]['code']];
}

function get_counselors()
{
    global $mainConn;

    $result = $mainConn->query("SELECT * FROM user WHERE user_role = 'counselor'");
    $counselors = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $full_name = $row['first_name'].' '.$row['last_name'];
            $counselors[] = ['full_name' => $full_name, 'user_id' => $row['user_id']];
        }
    }

    return $counselors;
}

function get_all_appointments($id)
{
    global $mainConn;

    $result = $mainConn->query("SELECT * FROM appointment INNER JOIN user ON user.user_id = appointment.counselor_id WHERE creator_id = '$id'");

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function get_incident_locations()
{

    global $mainConn;

    $result = $mainConn->query('SELECT report_title, map_latitude, map_longitude FROM appointment INNER JOIN user ON user.user_id = appointment.counselor_id');

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function get_appointments($id, $limit)
{
    global $mainConn;

    $result = $mainConn->query("SELECT * FROM appointment INNER JOIN user ON user.user_id = appointment.counselor_id WHERE creator_id = '$id'");

    if ($result->num_rows === 0) {
        return [];
    }
    $appointments = [];
    $count = 0;

    while ($row = $result->fetch_assoc()) {
        if ($count === $limit) {
            break;
        }

        $appointments[] = $row;
        $count++;
    }

    return $appointments;
}
function get_todays_appointments($id)
{
    global $mainConn;

    $date = date('Y-m-d');

    $result = $mainConn->query("SELECT * FROM appointment INNER JOIN user ON user.user_id = appointment.counselor_id WHERE date = '$date' AND creator_id = '$id'");
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function get_tomorrow_appointments($id)
{
    global $mainConn;

    $date = date('Y-m-d');

    $result = $mainConn->query("SELECT * FROM appointment INNER JOIN user ON user.user_id = appointment.counselor_id WHERE DATE(appointment_date) = DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND creator_id = '$id'");

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function get_unfinished_appointments($id)
{
    global $mainConn;

    $result = $mainConn->query("SELECT * FROM appointment INNER JOIN user ON user.user_id = appointment.counselor_id WHERE status = 'unfinished' AND creator_id = '$id'");

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

function get_finished_appointments($id)
{
    global $mainConn;

    $result = $mainConn->query("SELECT * FROM appointment INNER JOIN user ON user.user_id = appointment.counselor_id WHERE status = 'finished' AND creator_id = '$id'");

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}
