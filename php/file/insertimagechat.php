<?php

    require "../includes/db.php";

    $chat_room_id = trim($_POST['chat_room_id']);
    $from_user_id = trim($_POST['from_user_id']);
    $to_user_id = trim($_POST['to_user_id']);
    $chat_type = trim($_POST['chat_type']);
    $chat_date = trim($_POST['chat_date']);
    $chat_time = time();
    $chat_status = trim($_POST['chat_status']);
    $chat_file_size = trim($_POST['chat_file_size']);

  
	$target_dir = "../uploads/";

	$target_file_name = $target_dir .basename($_FILES["file"]["name"]);

	$update_file_name = "uploads/" .basename($_FILES["file"]["name"]);

	$update_file_name = "http://52.79.51.149/yeontalk/" .$update_file_name;
	 
	// Check if image file is a actual image or fake image
	if (isset($_FILES["file"])) {

		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file_name)) {

			$insert_chat_query = "INSERT INTO chat (chat_id, chat_chat_room_id, chat_user_id, chat_type, chat_message, chat_date, chat_time, chat_status, chat_file_size) ";
			$insert_chat_query .= "VALUES (null, '{$chat_room_id}', '{$from_user_id}', '{$chat_type}','{$update_file_name}', '{$chat_date}', '{$chat_time}', '{$chat_status}', '{$chat_file_size}') "; 

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

		} else {

			echo "Failure1";

		}

	} else {

	echo "Failure2";

	}

?>

