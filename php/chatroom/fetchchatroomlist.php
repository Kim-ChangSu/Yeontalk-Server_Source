<?php

	require "../includes/db.php";

    $user_id = trim($_POST['user_id']);

    $response = array();


// 채팅방의 마지막 채팅 시간을 기준으로 최신 시간순으로  치탱방들을 나열

    $query_fetch_room_id = "SELECT * FROM (SELECT users_chat_room.users_chat_room_chat_room_id, max(chat.chat_time) as max_time FROM users_chat_room JOIN chat ON users_chat_room.users_chat_room_chat_room_id = chat.chat_chat_room_id WHERE users_chat_room.users_chat_room_user_id = '{$user_id}' GROUP BY users_chat_room.users_chat_room_chat_room_id) AS sub  ORDER BY max_time DESC";  
	$result_query_fetch_room_id = mysqli_query($connection, $query_fetch_room_id); 

	if (!$result_query_fetch_room_id) {
		echo mysqli_error($connection);

	}

	while($row = mysqli_fetch_array($result_query_fetch_room_id))
		{
			$room_id = $row['users_chat_room_chat_room_id'];

			// 해당 채팅방에서 같이 채팅하고 있는 유저 ID 가져오기 
			$query_fetch_user_id = "SELECT * FROM users_chat_room  WHERE users_chat_room_chat_room_id = '{$room_id}' AND users_chat_room_user_id != '{$user_id}'";  
			$result_query_fetch_user_id = mysqli_query($connection, $query_fetch_user_id); 

			if (!$result_query_fetch_user_id) {
				echo mysqli_error($connection);

			}

			$count_user_with_chat = mysqli_num_rows($result_query_fetch_user_id);

			if ($count_user_with_chat == 0) {
				// 채팅 상대방이 채팅방을 나간 경우

				// 해당 채팅방의 마지막 채팅에 관련된 정보 가져오기 

				$query_fetch_last_chat = "SELECT * FROM chat WHERE chat_chat_room_id = '{$room_id}' ORDER BY chat_time DESC LIMIT 1 ";  
				$result_query_fetch_last_chat = mysqli_query($connection, $query_fetch_last_chat); 

				if (!$result_query_fetch_last_chat) {
					echo mysqli_error($connection);

				}

				$chat_user_id = "";
				$chat_message = "";
				$chat_date = "";
				$chat_type = "";

				while($row = mysqli_fetch_array($result_query_fetch_last_chat)) {

					$chat_user_id = $row['chat_user_id'];
					$chat_message = $row['chat_message'];
					$chat_date = $row['chat_date'];
					$chat_type = $row['chat_type'];

				}

				// 해당 채팅방에서 내가 아직 안 읽은 채팅 개수 가져오기

				$query_fetch_chat_unshown_num = "SELECT * FROM chat_unshown WHERE chat_unshown_room_id = '{$room_id}' AND chat_unshown_to_user_id = '{$user_id}' ";  
				$result_query_fetch_chat_unshown_num = mysqli_query($connection, $query_fetch_chat_unshown_num); 

				if (!$result_query_fetch_chat_unshown_num) {
					echo mysqli_error($connection);

				}

				$chat_unshown_num = mysqli_num_rows($result_query_fetch_chat_unshown_num);

				array_push($response ,array("chat_room_id" => $room_id, "chat_room_user_id" => "", "chat_room_user_image" => "", "chat_room_user_nickname" => "(알 수 없음)", "chat_room_last_user_id" => "", "chat_room_user_device_id" => "", "chat_room_last_message" => $chat_message, "chat_room_last_date" => $chat_date, "chat_room_last_type" => $chat_type, "chat_room_unshown_num" => $chat_unshown_num));

			} else {

				// 채팅 상대방이 채팅방이 존재하는 경우

				while($row = mysqli_fetch_array($result_query_fetch_user_id)) {

				$chat_room_user_id = $row['users_chat_room_user_id'];

				}

				// 해당 채팅방에서 같이 채팅하고 있는 유저 정보 가져오기

				$query_fetch_user_data = "SELECT * FROM users WHERE user_id = '{$chat_room_user_id}' ";  
				$result_query_fetch_user_data = mysqli_query($connection, $query_fetch_user_data); 

				if (!$result_query_fetch_user_data) {
					echo mysqli_error($connection);

				}

				while($row = mysqli_fetch_array($result_query_fetch_user_data)) {

					$user_image = $row['user_profile_image'];
					$user_nickname = $row['user_nickname'];
					$user_device_id = $row['user_device_id'];
				
				}

				// 해당 채팅방의 마지막 채팅에 관련된 정보 가져오기 

				$query_fetch_last_chat = "SELECT * FROM chat WHERE chat_chat_room_id = '{$room_id}' ORDER BY chat_time DESC LIMIT 1 ";  
				$result_query_fetch_last_chat = mysqli_query($connection, $query_fetch_last_chat); 

				if (!$result_query_fetch_last_chat) {
					echo mysqli_error($connection);

				}

				$chat_user_id = "";
				$chat_message = "";
				$chat_date = "";
				$chat_type = "";

				while($row = mysqli_fetch_array($result_query_fetch_last_chat)) {

					$chat_user_id = $row['chat_user_id'];
					$chat_message = $row['chat_message'];
					$chat_date = $row['chat_date'];
					$chat_type = $row['chat_type'];

				}

				// 해당 채팅방에서 내가 아직 안 읽은 채팅 개수 가져오기

				$query_fetch_chat_unshown_num = "SELECT * FROM chat_unshown WHERE chat_unshown_room_id = '{$room_id}' AND chat_unshown_to_user_id = '{$user_id}' ";  
				$result_query_fetch_chat_unshown_num = mysqli_query($connection, $query_fetch_chat_unshown_num); 

				if (!$result_query_fetch_chat_unshown_num) {
					echo mysqli_error($connection);

				}

				$chat_unshown_num = mysqli_num_rows($result_query_fetch_chat_unshown_num);

				array_push($response ,array("chat_room_id" => $room_id, "chat_room_user_id" => $chat_room_user_id, "chat_room_user_image" => $user_image, "chat_room_user_nickname" => $user_nickname, "chat_room_last_user_id" => $chat_user_id, "chat_room_user_device_id" => $user_device_id, "chat_room_last_message" => $chat_message, "chat_room_last_date" => $chat_date, "chat_room_last_type" => $chat_type, "chat_room_unshown_num" => $chat_unshown_num));

			}
		
		}

		echo json_encode(array("chat_room_list"=>$response));

	 	mysqli_close($connection);
    

?>