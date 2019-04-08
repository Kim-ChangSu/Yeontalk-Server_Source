<?php

    require "includes/db.php";

    $user_device_id = "";
    $user_nickname = "";
    $user_gender = "";
    $user_birthyear = "1993";
    $user_nation = "대한민국";
    $user_region = "서울";

    $login_time = 1554376371;
    $user_profile_image = "";
    $user_introduction = "";
    $user_point = 0;

    $user_id = 2766;

    for($i = 1; $i < 48; $i++) {


        $login_time = $login_time - ($i*10);

		mysqli_query($connection, "UPDATE  users SET user_login_time = '$login_time' WHERE user_id = '$user_id' ");

	    $user_id = $user_id + 1;
        
    }

   
 ?>