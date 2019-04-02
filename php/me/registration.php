<?php

    require "includes/db.php";

    $user_device_id = trim($_POST['user_device_id']);
    $user_nickname = trim($_POST['user_nickname']);
    $user_gender = trim($_POST['user_gender']);
    $user_birthyear = trim($_POST['user_birthyear']);
    $user_nation = trim($_POST['user_nation']);
    $user_region = trim($_POST['user_region']);

    $user_device_id = mysqli_real_escape_string($connection, $user_device_id);
    $user_nickname = mysqli_real_escape_string($connection, $user_nickname);
    $user_gender = mysqli_real_escape_string($connection, $user_gender);
    $user_birthyear = mysqli_real_escape_string($connection, $user_birthyear);
    $user_nation = mysqli_real_escape_string($connection, $user_nation);
    $user_region = mysqli_real_escape_string($connection, $user_region);

    $login_time = time();
    $user_profile_image = "";
    $user_introduction = "";
    $user_point = 0;

    $query = "INSERT INTO users (user_device_id, user_nickname, user_gender, user_birthyear, user_nation, user_region, user_login_time, user_profile_image, user_introduction, user_point) ";
    $query .= "VALUES ('{$user_device_id}', '{$user_nickname}', '{$user_gender}', '{$user_birthyear}', '{$user_nation}', '{$user_region}', '{$login_time}', '{$user_profile_image}', '{$user_introduction}', '{$user_point}') ";

    $registeration_user_query = mysqli_query($connection, $query);

    if(!$registeration_user_query) {
        
        echo "QUERY FAILED ." . mysqli_error($connection);
        
    } else {
        echo "Success";
    }

 ?>