<?php

require_once("../inc/db_connect.php");

if(!isset($id)) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
if(!isset($search)) {
    $search = filter_input(INPUT_GET, 'search', FILTER_VALIDATE_INT);
}

$action= filter_input(INPUT_GET, 'select');

$queryAllEmployees = 'SELECT * FROM employees
					  ORDER BY id';
$statement75 = $db1->prepare($queryAllEmployees);
$statement75->execute();
$employees = $statement75->fetchAll();
$statement75->closeCursor();


$employeeFName="";
$employeeLName="";

foreach($employees as $employee):
if($employee['id'] == $id){
$employeeFName = $employee["first_name"];
$employeeLName = $employee["last_name"];
}


$searchQuery22 = "SELECT * FROM employees WHERE id = '$search'";
$statement92=$db1->prepare($searchQuery22);
$statement92->execute();
$searchEmployees = $statement92->fetchAll();
$statement92->closeCursor();

endforeach ?>

<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Customers</title>
    <link rel="stylesheet" href="../main.css">
</head>

<!-- the body section -->
<body>
<main>
<header><h1>Employee Portal</h1></header>
<section>
<h2>View Supplier Information</h2>
<a href="../suppliers/viewSuppliers.php">Access Supplier Information</a>
<p></p>
<h2>View Customer Information</h2>
<a href="../customers/viewCustomers.php">Access Customer Information</a>
<p></p>
<h2>View Order Information</h2>
<a href="../productOrders/viewProductOrders.php">Access Order Information</a>
<p></p>
<h2>View Invoice Information</h2>
<a href="../invoices/viewInvoices.php">Access Invoice Information</a>
<p></p>
<h2>View Purchase Order Information</h2>
<a href="../purchaseOrders/viewpurchaseOrders.php">Access Purchase Order Information</a>
<p></p>
</section>
   
        <center><h2>View Employee Information</h2></center>
		 <form action="viewEmployeeInformation.php" method="GET">
		<select name="id">
		<option selected="selected">Choose An Employee</option>
		<?php foreach($employees as $employee): ?>
			<option value="<?php echo $employee["id"]; ?>">
			<?php echo $employee["first_name"]." ".$employee["last_name"]; ?></option> 
			<?php endforeach; ?>
		 
		</select>
		<p></p>
				<input type = "submit" name= "employee" value="View Employee" >
				
		</form>
</nav>
</aside>
<p></p>
<section>
<?php if(isset($id)){?>
		
	          <p><?php foreach ($employees as $employee) : ?></p>
			  <p><?php if($employee["id"] == $id){?></p>
				<p><?php echo $employee["first_name"]." ".$employee["last_name"]; ?></p>
				<p> <?php echo 'ID: '.$employee["id"]; ?></p>
				<p> <?php echo 'Company: '.$employee["company"]; ?></p>
				 <p> <?php echo 'Email Address: '.$employee["email_address"]; ?></p>
				 <p> <?php echo 'Business Phone # '.$employee["business_phone"]; ?></p>
				 <p> <?php echo 'Fax # '.$employee["fax_number"]; ?></p>
				 <p> <?php echo 'Street Address: '.$employee["address"]; ?></p>
				 <p> <?php echo 'City: '.$employee["city"]; ?></p>
				 <p> <?php echo 'State: '.$employee["state_province"]; ?></p>
				 <p> <?php echo 'Zip Code: '.$employee["zip_postal_code"]; ?>	</p> 
			  
				 
				 <form action ="" method = "get">
					  
					  <input type = "hidden" name = "id" value = "<?php echo $employee["id"]; ?> ">

					  </form>
                 <?php } ?>
	<?php endforeach; ?>
	   <?php } ?>
		     

</section>

<center><p>Search For Employee By ID:</p>
<form name="searchForm" method="GET" action="viewEmployeeInformation.php">
<input name="search" type="text" />
<input type="submit" name="Submit" value="Search" />
</form>
</center>
<section>
<?php if(isset($search)){?>
<p>Search Results of ID: <?php echo $search; ?></p>

			<p><?php foreach ($employees as $employee) : ?></p>
			  <p><?php if($employee["id"] == $search){?></p>
				<p><?php echo $employee["first_name"]." ".$employee["last_name"]; ?></p>
				 <p><?php echo 'ID: '.$employee["id"]; ?></p>
				 <p><?php echo 'Company: '.$employee["company"]; ?></p>
				 <p> <?php echo 'Email Address: '.$employee["email_address"]; ?></p>
				 <p> <?php echo 'Business Phone # '.$employee["business_phone"]; ?></p>
				 <p> <?php echo 'Fax # '.$employee["fax_number"]; ?></p>
				 <p> <?php echo 'Street Address: '.$employee["address"]; ?></p>
				 <p> <?php echo 'City: '.$employee["city"]; ?></p>
				 <p><?php echo 'State: '.$employee["state_province"]; ?></p>
				  <p><?php echo 'Zip Code: '.$employee["zip_postal_code"]; ?>	</p>
				  
		     <?php } ?>
             <?php endforeach ; ?>   
<?php } ?>
</section>
</main>

<?php include "../inc/footer.php" ?>
</body>

</html>