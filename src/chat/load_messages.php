<?php

if (empty($_POST['receiver'])) {
    exit();
}
session_start();
if (! isset($_SESSION['id'])) {
    exit();
}

require '../../config/config.php';

global $mainConn;

$sender = $_SESSION['id'];
$receiver = $_POST['receiver'];

//echo $sender;

//$receiver = "21-UR-0002";

$query = "SELECT sender_id, receiver_id, text_message, DATE_FORMAT(chat_date, '%W %h:%i %p') AS chat_date
            FROM chat
            WHERE (sender_id = '$sender' AND receiver_id = '$receiver')
            	OR (sender_id = '$receiver' AND receiver_id = '$sender')
            ORDER BY chat.chat_date";

$result = $mainConn->query($query);

if ($result->num_rows > 0) {
    $usr = $mainConn->query("SELECT first_name, last_name FROM user WHERE user_id = '$receiver'")->fetch_assoc();
    $full_name = $usr['first_name'].' '.$usr['last_name'];
    $initials = strtoupper(substr($usr['first_name'], 0, 1)).strtoupper(substr($usr['last_name'], 0, 1));

    while ($data = $result->fetch_assoc()) {
        $msg = $data['text_message'];
        $time = $data['chat_date'];
        $id = $data['sender_id'];
        $template_sender = "
                            <div class='grid grid-cols-[1fr_auto] w-full gap-2'>
	                            <div class='flex flex-col'>
                                    <div class='flex items-center justify-between mb-2 place-self-end'>
                                        <p class='text-xs text-gray-700 font-medium'>You</p>
                                    </div>
                                    <div class='bg-brand-600 rounded-lg p-4 text-white max-w-[20rem] place-self-end'>
                                        $msg
                                    </div>
                                </div>
                            </div>
                            ";

        $template_call_sender = "

                            <div class='grid grid-cols-[1fr_auto] w-full gap-2'>
	                            <div class='flex flex-col'>
                                    <div class='flex items-center justify-between mb-2 place-self-end'>
                                        <p class='text-xs text-gray-700 font-medium'>You</p>
                                    </div>
                                    <div class='bg-brand-600 rounded-lg p-4 text-white max-w-[20rem] place-self-end'>

                                    You started a call

                                    <a href='$msg' target='_blank' class='px-4 py-2 bg-warning-400 text-black rounded-lg'>Join call</a>
                                    </div>
                                </div>
                            </div>
                            ";

        $template_call_receiver = "
                              <div class='grid grid-cols-[auto_1fr] w-full gap-2'>
                                <div id='avatar' CLASS='rounded-full bg-gray-200 text-brand-600 font-medium w-max h-max p-2'>
                                    <p class=''>$initials</p>
                                </div>
                                <div class='max-w-[20rem] flex flex-col'>
                                    <div class='flex items-center justify-between mb-2'>
                                        <p class='text-xs text-gray-700 font-medium'>$full_name</p>
                                        <p class='text-xs text-gray-700'>$time</p>
                                    </div>
                                    <div class='bg-blue-light-300 rounded-lg p-4 flex items-center gap-2'>
                                        $full_name started a call
                                        <a href='$msg' target='_blank' class='px-4 py-2 bg-warning-400 text-black rounded-lg'>Join call</a>
                                    </div>
                                </div>
                            </div>

                            ";

        $template_receiver = "
                            <div class='grid grid-cols-[auto_1fr] w-full gap-2'>
                                <div id='avatar' CLASS='rounded-full bg-gray-200 text-brand-600 font-medium w-max h-max p-2'>
                                    <p class=''>$initials</p>
                                </div>
                                <div class='max-w-[20rem] flex flex-col'>
                                    <div class='flex items-center justify-between mb-2'>
                                        <p class='text-xs text-gray-700 font-medium'>$full_name</p>
                                        <p class='text-xs text-gray-700'>$time</p>
                                    </div>
                                    <div class='bg-white rounded-lg p-4'>
                                        $msg
                                    </div>
                                </div>
                            </div>


                            ";

        if (str_contains($msg, 'https')) {
            echo $id != $sender ? $template_call_receiver : $template_call_sender;

            continue;

        }

        echo $id != $sender ? $template_receiver : $template_sender;
    }
}
