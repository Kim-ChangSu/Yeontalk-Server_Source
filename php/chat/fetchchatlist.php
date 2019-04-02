<?php
  require "../includes/db.php";

	$chat_time_last_loaded = $_POST['chat_time_last_loaded'];
	$load_limit = $_POST['load_limit'];
	$me_id = $_POST['me_id'];
	$user_id = $_POST['user_id'];

	if (isset($_POST['room_id'])) {

		$room_id = trim($_POST['room_id']);

		// 사용자가 해당 채팅방에 들어왔기 때문에.... 안 봤던 채팅들을 안 봤던 채팅 목록에서 지워준다.

		$query_delete_chat_unshown = "DELETE FROM chat_unshown WHERE chat_unshown_room_id = '{$room_id}' AND chat_unshown_to_user_id = '{$me_id}' ";

		$result_query_delete_chat_unshown = mysqli_query($connection, $query_delete_chat_unshown); 

		// 해당 채팅방에서 같이 채팅하고 있는 user ID 가져오기 
		$query_is_user_in_room = "SELECT * FROM users_chat_room WHERE users_chat_room_chat_room_id = '{$room_id}' AND users_chat_room_user_id != '{$me_id}' " ;

		$result_query_is_user_in_room = mysqli_query($connection, $query_is_user_in_room); 

		$count_query_is_user_in_room = mysqli_num_rows($result_query_is_user_in_room);

		if ($count_query_is_user_in_room == 0) {

			// 해당 채팅방의 상대 유저가 나간 경우

			$query = "SELECT * FROM chat JOIN users ON chat.chat_user_id = users.user_id WHERE chat.chat_chat_room_id = '{$room_id}' ORDER BY chat.chat_time DESC LIMIT $load_limit";

			$result = mysqli_query($connection, $query);  

			$response= array();

			while($row = mysqli_fetch_array($result))
			{
				$chat_id = $row['chat_id'];
				$query_chat_unshown = "SELECT * FROM chat_unshown WHERE chat_unshown_chat_id = '{$chat_id}'";
				$result_chat_unshown = mysqli_query($connection, $query_chat_unshown);  
				$count_chat_unshown = mysqli_num_rows($result_chat_unshown);

			    array_push($response ,array("chat_id" => $chat_id, "chat_user_id" => $row['chat_user_id'], "chat_type" => $row['chat_type'], "chat_message" => $row['chat_message'], "chat_user_nickname" => "(알 수 없음)", "chat_user_image" => "", "chat_date" => $row['chat_date'], "chat_status" => $row['chat_status'], "chat_file_size" => $row['chat_file_size'], "chat_seen" => $count_chat_unshown, "chat_room_id" => $row['chat_chat_room_id']));
			}

			$response = array_reverse($response);

			 echo json_encode(array("chat_list"=>$response));

			 mysqli_close($connection);

		} else {

			// 해당 채팅방의 상대 유저가 존재하는 경우

			$query = "SELECT * FROM chat JOIN users ON chat.chat_user_id = users.user_id WHERE chat.chat_chat_room_id = '{$room_id}' ORDER BY chat.chat_time DESC LIMIT $load_limit";

			$result = mysqli_query($connection, $query);  

			$response= array();

			while($row = mysqli_fetch_array($result))
			{
				$chat_id = $row['chat_id'];
				$query_chat_unshown = "SELECT * FROM chat_unshown WHERE chat_unshown_chat_id = '{$chat_id}'";
				$result_chat_unshown = mysqli_query($connection, $query_chat_unshown);  
				$count_chat_unshown = mysqli_num_rows($result_chat_unshown);

			    array_push($response ,array("chat_id" => $chat_id, "chat_user_id" => $row['chat_user_id'], "chat_type" => $row['chat_type'], "chat_message" => $row['chat_message'], "chat_user_nickname" => $row['user_nickname'], "chat_user_image" => $row['user_profile_image'], "chat_date" => $row['chat_date'], "chat_status" => $row['chat_status'], "chat_file_size" => $row['chat_file_size'], "chat_seen" => $count_chat_unshown, "chat_room_id" => $row['chat_chat_room_id']));
			}

			$response = array_reverse($response);

			 echo json_encode(array("chat_list"=>$response));

			 mysqli_close($connection);


		}

	} else {

		$is_room_with_me = false;

		$room_id;

		$query_room_of_user = "SELECT * FROM users_chat_room WHERE users_chat_room_user_id = '{$user_id}' " ;

		$result_room_of_user = mysqli_query($connection, $query_room_of_user); 

		while($row = mysqli_fetch_array($result_room_of_user))
		{
			$room_id = $row['users_chat_room_chat_room_id'];

			$query_user_of_room = "SELECT * FROM users_chat_room WHERE users_chat_room_chat_room_id = '{$room_id}' AND users_chat_room_user_id != '{$user_id}' " ;

			$result_query_user_of_room = mysqli_query($connection, $query_user_of_room);

			while($row_user = mysqli_fetch_array($result_query_user_of_room)) {
				if ($row_user['users_chat_room_user_id']  == $me_id) {
					$is_room_with_me = true;
					$room_id = $row_user['users_chat_room_chat_room_id'];

				}
			}
		}


		if ($is_room_with_me == true) {

			// 사용자가 해당 채팅방에 들어왔기 때문에.... 안 봤던 채팅들을 안 봤던 채팅 목록에서 지워준다.

			$query_delete_chat_unshown = "DELETE FROM chat_unshown WHERE chat_unshown_room_id = '{$room_id}' AND chat_unshown_to_user_id = '{$me_id}' ";

			$result_query_delete_chat_unshown = mysqli_query($connection, $query_delete_chat_unshown); 

			$query = "SELECT * FROM chat JOIN users ON chat.chat_user_id = users.user_id WHERE chat.chat_chat_room_id = '{$room_id}' ORDER BY chat.chat_time DESC LIMIT $load_limit";

			$result = mysqli_query($connection, $query);  

			$response= array();

			while($row = mysqli_fetch_array($result))
			{
				$chat_id = $row['chat_id'];

				$query_chat_unshown = "SELECT * FROM chat_unshown WHERE chat_unshown_chat_id = '{$chat_id}'";
				$result_chat_unshown = mysqli_query($connection, $query_chat_unshown);  
				$count_chat_unshown = mysqli_num_rows($result_chat_unshown);

			    array_push($response ,array("chat_id" => $chat_id, "chat_user_id" => $row['chat_user_id'], "chat_type" => $row['chat_type'], "chat_message" => $row['chat_message'], "chat_user_nickname" => $row['user_nickname'], "chat_user_image" => $row['user_profile_image'], "chat_date" => $row['chat_date'], "chat_status" => $row['chat_status'], "chat_file_size" => $row['chat_file_size'], "chat_seen" => $count_chat_unshown, "chat_room_id" => $row['chat_chat_room_id']));
			}

			$response = array_reverse($response);

			 echo json_encode(array("chat_list"=>$response));

			 mysqli_close($connection);


		} else {

			$response = array();

			array_push ($response ,array("chat_id" => "No", "chat_user_id" => "No", "chat_type" => "No", "chat_message" => "No", "chat_user_nickname" => "No", "chat_user_image" => "No", "chat_date" => "No", "chat_status" => "No", "chat_seen" => "No","chat_room_id" => "No"));

			echo json_encode(array("chat_list"=>$response));

			mysqli_close($connection);

		}

	}	
	 
?>  