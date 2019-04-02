<?php

    require "includes/db.php";

    $user_id = trim($_POST['user_id']);
  
	$target_dir = "uploads/";

	$images_num = 0;
	 
	// Check if image file is a actual image or fake image
	if (isset($_FILES["file1"])) {

		$target_file_name = $target_dir .basename($_FILES["file1"]["name"]);  
	
		$update_file_name = "http://52.79.51.149/yeontalk/" .$target_file_name;

		if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file_name)) {

			$stmt = mysqli_prepare($connection, "INSERT INTO images VALUES (null, ?, ?) ");

	        mysqli_stmt_bind_param($stmt, 'ss', $update_file_name, $user_id);

	        mysqli_stmt_execute($stmt);
		
	        mysqli_stmt_close($stmt);

	        $images_num++;

		}
	}

	if (isset($_FILES["file2"])) {

		$target_file_name = $target_dir .basename($_FILES["file2"]["name"]);  
	
		$update_file_name = "http://52.79.51.149/yeontalk/" .$target_file_name;

		if (move_uploaded_file($_FILES["file2"]["tmp_name"], $target_file_name)) {

			$stmt = mysqli_prepare($connection, "INSERT INTO images VALUES (null, ?, ?) ");

	        mysqli_stmt_bind_param($stmt, 'ss', $update_file_name, $user_id);

	        mysqli_stmt_execute($stmt);

	        mysqli_stmt_close($stmt);

	        $images_num++;

		} 

	}
	if (isset($_FILES["file3"])) {

		$target_file_name = $target_dir .basename($_FILES["file3"]["name"]);  
	
		$update_file_name = "http://52.79.51.149/yeontalk/" .$target_file_name;

		if (move_uploaded_file($_FILES["file3"]["tmp_name"], $target_file_name)) {

			$stmt = mysqli_prepare($connection, "INSERT INTO images VALUES (null, ?, ?) ");

	        mysqli_stmt_bind_param($stmt, 'ss', $update_file_name, $user_id);

	        mysqli_stmt_execute($stmt);

	        mysqli_stmt_close($stmt);

	        $images_num++;

		} 

	}
	if (isset($_FILES["file4"])) {

		$target_file_name = $target_dir .basename($_FILES["file4"]["name"]);  
	
		$update_file_name = "http://52.79.51.149/yeontalk/" .$target_file_name;

		if (move_uploaded_file($_FILES["file4"]["tmp_name"], $target_file_name)) {

			$stmt = mysqli_prepare($connection, "INSERT INTO images VALUES (null, ?, ?) ");

	        mysqli_stmt_bind_param($stmt, 'ss', $update_file_name, $user_id);

	        mysqli_stmt_execute($stmt);

	        mysqli_stmt_close($stmt);

	        $images_num++;

		} 

	}
	if (isset($_FILES["file5"])) {

		$target_file_name = $target_dir .basename($_FILES["file5"]["name"]);  
	
		$update_file_name = "http://52.79.51.149/yeontalk/" .$target_file_name;

		if (move_uploaded_file($_FILES["file5"]["tmp_name"], $target_file_name)) {

			$stmt = mysqli_prepare($connection, "INSERT INTO images VALUES (null, ?, ?) ");

	        mysqli_stmt_bind_param($stmt, 'ss', $update_file_name, $user_id);

	        mysqli_stmt_execute($stmt);


	        mysqli_stmt_close($stmt);

	        $images_num++;

		} 

	} 

	$query = "SELECT * FROM images ";

	$query .= "WHERE user_id = '{$user_id}' ";

	$query .= "ORDER BY image_id DESC ";

	$query .= "LIMIT $images_num ";

	$result = mysqli_query($connection, $query);  

	$response= array();

	while($row = mysqli_fetch_array($result))
	{
	    array_push($response ,array("image_id" => $row[0], "image_url" => $row[1]));
	}

	$response_reverse = array_reverse($response);

	echo json_encode(array("image_list"=>$response_reverse));

	mysqli_close($connection);
 
?>