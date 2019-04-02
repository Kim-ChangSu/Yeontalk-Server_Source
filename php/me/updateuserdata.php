<?php

require "includes/db.php";

$user_id = trim($_POST['user_id']);
$key = trim($_POST['data_key']);
$value = trim($_POST['data_value']);

$user_id = mysqli_real_escape_string($connection, $user_id);
$key = mysqli_real_escape_string($connection, $key);
$value = mysqli_real_escape_string($connection, $value);

    if($key == "닉네임") {

        $stmt = mysqli_prepare($connection, "UPDATE users SET user_nickname = ? WHERE user_id = ? ");

        mysqli_stmt_bind_param($stmt, 'ss', $value, $user_id);

        mysqli_stmt_execute($stmt);

        if(!$stmt){
            echo "QUERY FAILED" . mysqli_error($connection);
        } else {
            echo "Success";
        }
        mysqli_stmt_close($stmt);
    }

    else if($key == "성별") {

        $stmt = mysqli_prepare($connection, "UPDATE users SET user_gender = ? WHERE user_id = ? ");

        mysqli_stmt_bind_param($stmt, 'ss', $value, $user_id);

        mysqli_stmt_execute($stmt);

        if(!$stmt){
            echo "QUERY FAILED" . mysqli_error($connection);
        }else {
            echo "Success";
        }
        mysqli_stmt_close($stmt);
    }

    else if($key == "생년") {

        $stmt = mysqli_prepare($connection, "UPDATE users SET user_birthyear = ? WHERE user_id = ? ");

        mysqli_stmt_bind_param($stmt, 'ss', $value, $user_id);

        mysqli_stmt_execute($stmt);

        if(!$stmt){
            echo "QUERY FAILED" . mysqli_error($connection);
        }else {
            echo "Success";
        }
        mysqli_stmt_close($stmt);
    }

    else if ($key == "국가") {
        
        $region = "";

        $stmt = mysqli_prepare($connection, "UPDATE users SET user_nation = ?, user_region = ? WHERE user_id = ? ");

        mysqli_stmt_bind_param($stmt, 'sss', $value, $region ,$user_id);

        mysqli_stmt_execute($stmt);

        if(!$stmt){

            echo "QUERY FAILED" . mysqli_error($connection);
        }else {
            echo "Success";
        }
        mysqli_stmt_close($stmt);
    }

    else if($key == "지역") {

        $stmt = mysqli_prepare($connection, "UPDATE users SET user_region = ? WHERE user_id = ? ");

        mysqli_stmt_bind_param($stmt, 'ss', $value, $user_id);

        mysqli_stmt_execute($stmt);

        if(!$stmt){
            echo "QUERY FAILED" . mysqli_error($connection);
        }else {
            echo "Success";
        }
        mysqli_stmt_close($stmt);
    }
    else if($key == "이미지") {

        $stmt = mysqli_prepare($connection, "UPDATE users SET user_profile_image = ? WHERE user_id = ? ");

        mysqli_stmt_bind_param($stmt, 'ss', $value, $user_id);

        mysqli_stmt_execute($stmt);

        if(!$stmt){

            echo "QUERY FAILED" . mysqli_error($connection);

        }else {
            echo "Success";
        }
        mysqli_stmt_close($stmt);
    }

    else if($key == "자기소개") {

        $stmt = mysqli_prepare($connection, "UPDATE users SET user_introduction = ? WHERE user_id = ? ");

        mysqli_stmt_bind_param($stmt, 'ss', $value, $user_id);

        mysqli_stmt_execute($stmt);

        if(!$stmt){

            echo "QUERY FAILED" . mysqli_error($connection);

        }else {
            echo "Success";
        }
        mysqli_stmt_close($stmt);
    }

    else if($key == "포인트") {

        $stmt = mysqli_prepare($connection, "UPDATE users SET user_point = ? WHERE user_id = ? ");

        mysqli_stmt_bind_param($stmt, 'ss', $value, $user_id);

        mysqli_stmt_execute($stmt);

        if(!$stmt){

            echo "QUERY FAILED" . mysqli_error($connection);

        }else {
            echo "Success";
        }
        mysqli_stmt_close($stmt);
    }
     else {
        echo "key error";
    }

?>

 