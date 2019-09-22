<?php
	$conn = new mysqli('www.jonsobier.com', 'jsobieze_psPort', 'adminPS', 'jsobieze_petsupply');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>