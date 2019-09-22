<?php
	include 'config.php';
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	// sql to create table
	$sql = "CREATE TABLE $tablename (
		id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(50) NOT NULL,
		petname VARCHAR(50) NOT NULL,
		phone VARCHAR(20) NOT NULL,
		item VARCHAR(20) NOT NULL,
		start_day INT(11),
		end_day INT(11),
		start_time INT(11),
		end_time INT(11),
		canceled INT(1)
	)";
	
	if (mysqli_query($conn, $sql)) {
		echo "Table " . $tablename . " created successfully";
	} else {
		echo "Error creating table: " . mysqli_error($conn);
	}
	
	mysqli_close($conn);
?>