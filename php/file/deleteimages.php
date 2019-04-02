<?php

    require "includes/db.php";

    $user_id = trim($_GET['user_id']);
    $image_id = trim($_GET['image_id']);

    $user_id = mysqli_real_escape_string($connection, $user_id);
    $image_id = mysqli_real_escape_string($connection, $image_id);

    $query = "DELETE FROM images WHERE user_id = '{$user_id}' AND image_id = '{$image_id}' ";

    $delete_image_query = mysqli_query($connection, $query);

    if(!$delete_image_query) {
        
        echo "QUERY FAILED ." . mysqli_error($connection);
        
    } else {

    	echo "Success";
    }

 ?>