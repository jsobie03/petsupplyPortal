<?php
//MySQLi connection
$con = mysqli_connect("www.jonsobier.com", "jsobieze_psPort", "adminPS", "jsobieze_petsupply");

// Check connection for errors
if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
?>


