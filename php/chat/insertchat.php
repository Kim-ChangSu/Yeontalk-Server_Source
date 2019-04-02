<?php

    require "../includes/db.php";

    $from_user_id = trim($_POST['from_user_id']);
    $to_user_id = trim($_POST['to_user_id']);
    $chat_type = trim($_POST['chat_type']);
    $chat_message = $_POST['chat_message'];
    $chat_date = trim($_POST['chat_date']);
    $chat_time = time();
    $chat_status = trim($_POST['chat_status']);
    $chat_file_size = "";

    if (!isset($_POST['chat_room_id'])) {

    	$insert_chat_room_query = "INSERT INTO chat_room (chat_room_id, chat_room_user_id) ";
    	$insert_chat_room_query .= "VALUES (null, '{$from_user_id}') ";

	    $insert_chat_room_query = mysqli_query($connection, $insert_chat_room_query);

	    if($insert_chat_room_query) {

	    	$result = mysqli_query($connection, "SELECT*FROM chat_room WHERE chat_room_user_id= $from_user_id ORDER BY chat_room_id DESC LIMIT 1 ");

	        $chat_room = mysqli_fetch_array($result);

	        $chat_room_id = mysqli_num_rows($result) >= 1 ? $chat_room['chat_room_id'] : false;

	        if(!$chat_room_id == "") {

	        	$insert_users_chat_room_query = "INSERT INTO users_chat_room (id, users_chat_room_chat_room_id, users_chat_room_user_id) ";
		    	$insert_users_chat_room_query .= "VALUES (null, '{$chat_room_id}', '{$from_user_id}') ";

		    	$insert_users_chat_room_query = mysqli_query($connection, $insert_users_chat_room_query);

		    	$insert_users_chat_room_query = "INSERT INTO users_chat_room (id, users_chat_room_chat_room_id, users_chat_room_user_id) ";
		    	$insert_users_chat_room_query .= "VALUES (null, '{$chat_room_id}', '{$to_user_id}') ";

		    	$insert_users_chat_room_query = mysqli_query($connection, $insert_users_chat_room_query);

		    	$insert_chat_query = "INSERT INTO chat (chat_id, chat_chat_room_id, chat_user_id, chat_type, chat_message, chat_date, chat_time, chat_status, chat_file_size) ";
    			$insert_chat_query .= "VALUES (null, '{$chat_room_id}', '{$from_user_id}', '{$chat_type}','{$chat_message}', '{$chat_date}', '{$chat_time}', '{$chat_status}', '{$chat_file_size}') "; 

		    	$insert_chat_query = mysqli_query($connection, $insert_chat_query);

		    	$select_last_chat_id = "SELECT * FROM chat WHERE chat_user_id = '{$from_user_id}' ORDER BY chat_id DESC LIMIT 1 ";

		    	$result_select_last_chat_id = mysqli_query($connection, $select_last_chat_id);

		    	while ($row = mysqli_fetch_array($result_select_last_chat_id)) {
		    		$chat_id = $row['chat_id'];
		    	}

		    	$insert_chat_unshown_query = "INSERT INTO chat_unshown (chat_unshown_id, chat_unshown_chat_id, chat_unshown_room_id, chat_unshown_to_user_id) ";
				$insert_chat_unshown_query .= "VALUES (null, '{$chat_id}', '{$chat_room_id}', '{$to_user_id}') "; 

		    	$insert_chat_unshown_query = mysqli_query($connection, $insert_chat_unshown_query);

		    	if(!$insert_chat_unshown_query) {
		        
		        echo "QUERY FAILED 4." . $from_user_id . mysqli_error($connection);
		        
			    } else {
			        echo $chat_room_id;
			    }

	        }else {

	        	echo "QUERY FAILED 2." . mysqli_error($connection);

	        }
	        
	    } else {
	        echo "QUERY FAILED 3." . $from_user_id . mysqli_error($connection);
	    }

    } else {

    	$chat_room_id = trim($_POST['chat_room_id']);
    	$chat_id;

    	$insert_chat_query = "INSERT INTO chat (chat_id, chat_chat_room_id, chat_user_id, chat_type, chat_message, chat_date, chat_time, chat_status, chat_file_size) ";
		$insert_chat_query .= "VALUES (null, '{$chat_room_id}', '{$from_user_id}', '{$chat_type}','{$chat_message}', '{$chat_date}', '{$chat_time}', '{$chat_status}', '{$chat_file_size}') "; 

    	$insert_chat_query = mysqli_query($connection, $insert_chat_query);

    	$select_last_chat_id = "SELECT * FROM chat WHERE chat_user_id = '{$from_user_id}' ORDER BY chat_id DESC LIMIT 1 ";

    	$result_select_last_chat_id = mysqli_query($connection, $select_last_chat_id);

    	while ($row = mysqli_fetch_array($result_select_last_chat_id)) {
    		$chat_id = $row['chat_id'];
    	}

    	$insert_chat_unshown_query = "INSERT INTO chat_unshown (chat_unshown_id, chat_unshown_chat_id, chat_unshown_room_id, chat_unshown_to_user_id) ";
    	
		$insert_chat_unshown_query .= "VALUES (null, '{$chat_id}', '{$chat_room_id}', '{$to_user_id}') "; 

    	$insert_chat_unshown_query = mysqli_query($connection, $insert_chat_unshown_query);

    	if(!$insert_chat_unshown_query) {
        
        echo "QUERY FAILED 4." . $from_user_id . mysqli_error($connection);
        
	    } else {
	        echo $chat_room_id;
	    }
	}

    

    

 ?>