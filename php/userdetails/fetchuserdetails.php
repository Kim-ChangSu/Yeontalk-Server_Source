<?php
  require "includes/db.php";

  $user_id = trim($_GET['user_id']);
  $user_id = mysqli_real_escape_string($connection, $user_id);

  $query = "SELECT * FROM users WHERE user_id = '{$user_id}'";  
  $result = mysqli_query($connection, $query);  
  $response= array();

  $query_image = "SELECT * FROM images WHERE user_id = '{$user_id}'";  
  $result_image = mysqli_query($connection, $query_image);  
  $response_image= array();

  while($row = mysqli_fetch_array($result_image))
  {
      array_push($response_image , $row['image']);
  }

  while($row = mysqli_fetch_array($result))
  {
      array_push($response ,array("user_id" => $row[0], "user_device_id" => $row[1], "user_nickname" => $row[2], "user_gender" => $row[3], "user_birthyear" => $row[4], "user_nation" => $row[5], "user_region" => $row[6], "user_login_time" => display_datetime($row[7]), "user_profile_image" => $row[8], "user_introduction" => $row[9], "user_images" => $response_image));
  }
 echo json_encode(array("users"=>$response));

 mysqli_close($connection);

?>  

<?php
function display_datetime($datetime)
{
    if (empty($datetime)) {
        return false;
    }
 
    $diff = time() - $datetime;
 
    $s = 60; //1분 = 60초
    $h = $s * 60; //1시간 = 60분
    $d = $h * 24; //1일 = 24시간
    $m = $d * 30; //1달 = 1일 * 30일
    $y = $m * 12; //1년 = 1달 * 12달
 
    if ($diff < $s) {
        $result = $diff . '초전';
    } elseif ($h > $diff && $diff >= $s) {
        $result = round($diff/$s) . '분전';
    } elseif ($d > $diff && $diff >= $h) {
        $result = round($diff/$h) . '시간전';
    } elseif ($m > $diff && $diff >= $d) {
        $result = round($diff/$d) . '일전';
    } elseif ($y > $diff && $diff >= $m) {
        $result = round($diff/$m) . '달전';
    }else {
    	$result = round($diff/$y) . '년전';
    }
 
    return $result;
}
?>