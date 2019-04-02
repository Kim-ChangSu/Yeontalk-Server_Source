<?php
  require "includes/db.php";

  $me_id = trim($_POST['me_id']);
	$user_login_time_loaded_last = trim($_POST['user_login_time_loaded_last']);
	$load_limit = trim($_POST['load_limit']);

	if($user_login_time_loaded_last == "") {
		$user_login_time_loaded_last = time();
	}

  // Selection Conditions
  $selection_gender = trim($_POST['selection_gender']);
  $selection_max_birthyear = trim($_POST['selection_max_birthyear']);
  $selection_min_birthyear = trim($_POST['selection_min_birthyear']);
  $selection_nation = trim($_POST['selection_nation']);
  $selection_region = trim($_POST['selection_region']);

  $selection_gender = mysqli_real_escape_string($connection, $selection_gender);
  $selection_max_birthyear = (int) mysqli_real_escape_string($connection, $selection_max_birthyear);
  $selection_min_birthyear = (int)mysqli_real_escape_string($connection, $selection_min_birthyear);
  $selection_nation = mysqli_real_escape_string($connection, $selection_nation);
  $selection_region = mysqli_real_escape_string($connection, $selection_region);

  $query_fetch_users = "SELECT * FROM users ";

  $query_fetch_users .= "WHERE user_id != '{$me_id}' ";

  if ($selection_max_birthyear != "") {
  $query_fetch_users .= "AND user_birthyear <= {$selection_max_birthyear} ";  
  }
  if ($selection_min_birthyear != "") {
  $query_fetch_users .= "AND user_birthyear >= {$selection_min_birthyear} ";  
  }
  if ($selection_gender != "") {
  $query_fetch_users .= "AND user_gender = '{$selection_gender}' ";  
  }
  if ($selection_nation != "") {
  $query_fetch_users .= "AND user_nation = '{$selection_nation}' ";  
  }
  if ($selection_region != "") {
  $query_fetch_users .= "AND user_region = '{$selection_region}' ";  
  }

  $query_fetch_users .= "AND user_profile_image != '' ";

  $query_fetch_users .= "AND user_login_time < $user_login_time_loaded_last ";
  
  $query_fetch_users .= "ORDER BY user_login_time DESC ";

  $query_fetch_users .= "LIMIT $load_limit ";

  $result_query_fetch_users = mysqli_query($connection, $query_fetch_users);  

  $response= array();

  while($row = mysqli_fetch_array($result_query_fetch_users))
  {
      array_push($response ,array("user_id" => $row[0], "user_device_id" => $row[1], "user_nickname" => $row[2], "user_gender" => $row[3], "user_birthyear" => $row[4], "user_nation" => $row[5], "user_region" => $row[6], "user_login_time" => $row[7], "user_profile_image" => $row[8], "user_introduction" => $row[9]));
  }
   echo json_encode(array("fetch_users"=>$response));

   mysqli_close($connection);
  
	 
?>  