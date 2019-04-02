<?php

    require "includes/db.php";

    $user_device_id = "";
    $user_nickname = "";
    $user_gender = "";
    $user_birthyear = "1993";
    $user_nation = "대한민국";
    $user_region = "서울";

    $login_time = time();
    $user_profile_image = "";
    $user_introduction = "";
    $user_point = 0;


    for($i = 1; $i < 50; $i++) {

		$query = "INSERT INTO users (user_device_id, user_nickname, user_gender, user_birthyear, user_nation, user_region, user_login_time, user_profile_image, user_introduction, user_point) ";
	    $query .= "VALUES ('{$user_device_id}', '{$user_nickname}', '{$user_gender}', '{$user_birthyear}', '{$user_nation}', '{$user_region}', '{$login_time}', '{$user_profile_image}', '{$user_introduction}', '{$user_point}') ";

	    $registeration_user_query = mysqli_query($connection, $query);

	    if(!$registeration_user_query) {
	        
	        echo "QUERY FAILED ." . mysqli_error($connection);
	        
	    } else {
	        echo "Success";
	    }
        
    }

   
 ?>