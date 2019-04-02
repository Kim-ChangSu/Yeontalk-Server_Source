<?php

    require "includes/db.php";

    $user_id = trim($_POST['user_id']);
  
	$target_dir = "uploads/";

	$target_file_name = $target_dir .basename($_FILES["file"]["name"]);

	$update_file_name = "http://52.79.51.149/yeontalk/" .$target_file_name;

	$response = array();
	 
	// Check if image file is a actual image or fake image
	if (isset($_FILES["file"])) {

		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file_name)) {

			$stmt = mysqli_prepare($connection, "UPDATE users SET user_profile_image = ? WHERE user_id = ? ");

	        mysqli_stmt_bind_param($stmt, 'ss', $update_file_name, $user_id);

	        mysqli_stmt_execute($stmt);

			if(!$stmt){

	            echo mysqli_error($connection);

	        } else {

	        	echo "Success";

	        }

	        mysqli_stmt_close($stmt);

		} else {
		
		echo "Error while uploading";

		}

	} else {

	 echo "Required Field Missing";

	}
 
?>

    