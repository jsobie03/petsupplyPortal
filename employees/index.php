<?php 
	//include the database connection file
	include "../inc/db_connect.php";
	//starting our session to preserve the login info
	session_start();

	//check whether data with the session name username has already been 
    //created
	//if so redirect to homepage
	if (isset($_SESSION['username'])){
		//redirecting if there is already a session with the name username
		header("Location: viewEmployees.php");
	}
	
	//check whether data with the name username has been submitted
	if (isset($_POST['username'])) {
		
		//variables to hold the submitted data with post
		$username = $_POST['username'];
			//encrypting the login password
		$pass = md5($_POST['password']);
		
		//sql statement the will execute at login                
		$sql = "SELECT * FROM employees WHERE employeeID = '$username' AND password = '$pass'";
		
		//execute the sql query with the connection
		$re = mysqli_query($con, $sql);
		
		//check to see if there is any record/row in the database
		//if there is then the user exists
		if(mysqli_num_rows($re)) {
			//echo "Welcome";
			//creating a session name with username ad inserting the submitted username
			$_SESSION['username'] = $username;
			
			//redirecting to homepage
			header("Location: viewEmployees.php");
		}else{
			//display error if no record exists
			echo "Error: Invalid Login Credentials";
		}
	}
?>	

<!DOCTYPE html>
<html>
<head>
	<title> Employee Login</title>
	<link rel="stylesheet" href="main.css">
	<center><img src="../images/logo.png"></center>
</head>
<body>
		<center><form method="POST" action="viewEmployees.php">
			<header><h1>Welcome To The Employee Portal</h1></header>
			<p></p>
			<h2>Enter EmployeeID and Password to Login</h2>
				<label>Enter Your EmployeeID: </label> <input type="text" name="username" placeholder="EmployeeID" />	
				<p></p>
				<label>Enter Your Password: </label><input type="password" name="password" placeholder="password"/>
			</div>
			<p></p>
			<input type="submit" value="LOGIN"/>
		</form></center>
	</div>
<?php include "../inc/footer.php" ?>
</body>
</html>



