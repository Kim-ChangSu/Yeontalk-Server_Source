<?php

    require "includes/db.php";

    $user_id = trim($_POST['user_id']);
    

    $user_id = mysqli_real_escape_string($connection, $user_id);

    $query = "DELETE FROM favorites WHERE user_id_from = '{$user_id}' ";

    $delete_favorite_query = mysqli_query($connection, $query);

    if(!$delete_favorite_query) {
        
        die("QUERY FAILED ." . mysqli_error($connection));
        
    }

    $query = "DELETE FROM users_chat_room WHERE users_chat_room_user_id = '{$user_id}' ";

    $delete_users_chat_room_query = mysqli_query($connection, $query);

    if(!$delete_users_chat_room_query) {
        
        die("QUERY FAILED ." . mysqli_error($connection));
        
    }

    $query = "DELETE FROM images WHERE user_id = '{$user_id}' ";

    $delete_images_query = mysqli_query($connection, $query);

    if(!$delete_images_query) {
        
        die("QUERY FAILED ." . mysqli_error($connection));
        
    } 

    $query = "DELETE FROM users WHERE user_id = '{$user_id}' ";

    $delete_user_query = mysqli_query($connection, $query);


    if(!$delete_user_query) {
        
        die("QUERY FAILED ." . mysqli_error($connection));
        
    } else {
        echo "Success";
    }





 ?>