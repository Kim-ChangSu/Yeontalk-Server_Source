<?php

    require "../includes/db.php";

    $room_id = trim($_POST['room_id']);
    $me_id = trim($_POST['me_id']);
    $chat_time = time();

    $room_id = mysqli_real_escape_string($connection, $room_id);
    $me_id = mysqli_real_escape_string($connection, $me_id);

    $query_delete_users_chat_room = "DELETE FROM users_chat_room WHERE users_chat_room_chat_room_id = '{$room_id}' AND users_chat_room_user_id = '{$me_id}' ";

    $result_query_delete_users_chat_room = mysqli_query($connection, $query_delete_users_chat_room); 

    $insert_chat_query = "INSERT INTO chat (chat_id, chat_chat_room_id, chat_user_id, chat_type, chat_message, chat_date, chat_time, chat_status, chat_file_size) ";

    $insert_chat_query .= "VALUES (null, '{$room_id}', '{$me_id}', 'EXIT','', '', '{$chat_time}', '', '') "; 

    $insert_chat_query = mysqli_query($connection, $insert_chat_query);


    if(!$insert_chat_query) {
        
        echo "QUERY FAILED ." . mysqli_error($connection);
        
    } else {
        echo "Success";
    }

 ?>