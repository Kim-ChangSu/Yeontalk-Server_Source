<?php

    require "includes/db.php";

    $user_id_from = trim($_POST['user_id_from']);
    $user_id_to = trim($_POST['user_id_to']);

    $user_id_from = mysqli_real_escape_string($connection, $user_id_from);
    $user_id_to = mysqli_real_escape_string($connection, $user_id_to);
   

    $query = "INSERT INTO favorites (user_id_from, user_id_to) ";
    $query .= "VALUES ('{$user_id_from}', '{$user_id_to}')";

    $insert_favorite_query = mysqli_query($connection, $query);

    if(!$insert_favorite_query) {
        
        die("QUERY FAILED ." . mysqli_error($connection));
        
    } else {
        echo "Success";
    }

 ?>