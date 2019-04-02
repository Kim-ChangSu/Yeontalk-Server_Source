<?php

    require "../includes/db.php";

    $room_id = trim($_POST['room_id']);
    $me_id = trim($_POST['me_id']);

    $room_id = mysqli_real_escape_string($connection, $room_id);
    $me_id = mysqli_real_escape_string($connection, $me_id);

    $query_delete_chat_unshown = "DELETE FROM chat_unshown WHERE chat_unshown_room_id = '{$room_id}' AND chat_unshown_to_user_id = '{$me_id}' ";

    $result_query_delete_chat_unshown = mysqli_query($connection, $query_delete_chat_unshown); 


    if(!$result_query_delete_chat_unshown) {
        
        echo "QUERY FAILED ." . mysqli_error($connection);
        
    } else {
        echo "Success";
    }

 ?>