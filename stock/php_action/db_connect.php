<?php 	

$localhost = "www.jonsobier.com";
$username = "jsobieze_psPort";
$password = "adminPS";
$dbname = "jsobieze_stock";

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>