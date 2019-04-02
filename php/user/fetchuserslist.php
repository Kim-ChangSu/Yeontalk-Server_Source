<?php
  require "includes/db.php";

  $user_device_id = trim($_POST['user_device_id']);
  $user_login_time = time();
  $load_limit = $_POST['load_limit'];
  $user_login_time_loaded_last = $_POST['user_login_time_loaded_last'];

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

  $me_id = "";

  // User Login Time Update
  mysqli_query($connection, "UPDATE  users SET user_login_time = '$user_login_time' WHERE user_device_id = '$user_device_id' ");

  // Fetch me
  $query_fetch_me = "SELECT * FROM users WHERE user_device_id = '{$user_device_id}'";  

  $result_query_fetch_me = mysqli_query($connection, $query_fetch_me); 
  $response_fetch_me= array();

  while($row = mysqli_fetch_array($result_query_fetch_me))
    {
      $me_id = $row[0];

      $query_image = "SELECT * FROM images WHERE user_id = '{$me_id}'";  
      $result_image = mysqli_query($connection, $query_image);  
      $response_image= array();

      while($row_image = mysqli_fetch_array($result_image))
      {
          array_push($response_image , array("image_id" => $row_image[0], "image_url" => $row_image[1]));
      }
    
     array_push($response_fetch_me ,array("me_id" => $row[0], "me_device_id" => $row[1], "me_nickname" => $row[2], "me_gender" => $row[3], "me_birthyear" => $row[4], "me_nation" => $row[5], "me_region" => $row[6], "me_login_time" => $row[7], "me_profile_image" => $row[8],"me_introduction" => $row[9], "me_point" => $row[10], "me_images" => $response_image));
    }

  // Fetch chatbot
  $query_fetch_chatbot = "SELECT * FROM users ";
  $query_fetch_chatbot .= "WHERE user_device_id = 'chatbot' ";

  $result_query_fetch_chatbot = mysqli_query($connection, $query_fetch_chatbot);  
  $response_fetch_chatbot = array();

  while($row = mysqli_fetch_array($result_query_fetch_chatbot))
  {
  array_push($response_fetch_chatbot ,array("user_id" => $row[0], "user_device_id" => $row[1], "user_nickname" => $row[2], "user_gender" => $row[3], "user_birthyear" => $row[4], "user_nation" => $row[5], "user_region" => $row[6], "user_login_time" => $row[7], "user_profile_image" => $row[8], "user_introduction" => $row[9]));
  }
  
  // Fetch Favorites
  $query_fetch_favorites = "SELECT * FROM users ";
  $query_fetch_favorites .= "INNER JOIN favorites ";
  $query_fetch_favorites .= "ON users.user_id = favorites.user_id_to ";
  $query_fetch_favorites .= "WHERE favorites.user_id_from = '{$me_id}'";
  $query_fetch_favorites .= "ORDER BY user_login_time DESC ";

  $result_query_fetch_favorites = mysqli_query($connection, $query_fetch_favorites);  
  $response_fetch_favorites= array();

  while($row = mysqli_fetch_array($result_query_fetch_favorites))
  {
  array_push($response_fetch_favorites ,array("user_id" => $row[0], "user_device_id" => $row[1], "user_nickname" => $row[2], "user_gender" => $row[3], "user_birthyear" => $row[4], "user_nation" => $row[5], "user_region" => $row[6], "user_login_time" => $row[7], "user_profile_image" => $row[8], "user_introduction" => $row[9]));
  }

  // Fetch Users

  $favorites_query = "SELECT * FROM favorites WHERE user_id_from = '{$me_id}' ";
  $select_favorites_for_excepting = mysqli_query($connection, $favorites_query);

  $query_fetch_users = "SELECT * FROM users ";

  $query_fetch_users .= "WHERE user_id != '{$me_id}' ";

  while($row = mysqli_fetch_assoc($select_favorites_for_excepting)) {

      $user_id_to = $row['user_id_to'];

      $query_fetch_users .= "AND user_id != '{$user_id_to}' ";
        
  }

  $query_fetch_users .= "AND user_device_id != 'chatbot' ";

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

  if ($user_login_time_loaded_last != "") {

    $query_fetch_users .= "AND user_login_time < $user_login_time_loaded_last ";
  
  } else {
    $query_fetch_users .= "AND user_login_time < $user_login_time ";
  }

  $query_fetch_users .= "ORDER BY user_login_time DESC ";

  $query_fetch_users .= "LIMIT $load_limit ";

  $result_query_fetch_users = mysqli_query($connection, $query_fetch_users);  

  $response_fetch_users= array();

  while($row = mysqli_fetch_array($result_query_fetch_users))
  {
  array_push($response_fetch_users ,array("user_id" => $row[0], "user_device_id" => $row[1], "user_nickname" => $row[2], "user_gender" => $row[3], "user_birthyear" => $row[4], "user_nation" => $row[5], "user_region" => $row[6], "user_login_time" => $row[7], "user_profile_image" => $row[8], "user_introduction" => $row[9]));
  }

  $response = array();

  array_push($response, array('fetch_me' => $response_fetch_me, 'fetch_chatbot' => $response_fetch_chatbot, 'fetch_favorites' =>$response_fetch_favorites, 'fetch_users' =>$response_fetch_users));

  echo json_encode(array("fetch_multiple_userlist"=>$response));

  mysqli_close($connection);
   
?>  