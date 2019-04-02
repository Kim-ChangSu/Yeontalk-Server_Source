<?php 

$db['db_host'] = "localhost";
$db['db_user'] = "changsu";
$db['db_pass'] = "930*Ckdtn";
$db['db_name'] = "yeontalk";

foreach($db as $key => $value){
    define(strtoupper($key), $value);
}
 
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

?>