<?php

require_once("../inc/db_connect.php");

if(!isset($id)) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
if(!isset($search)) {
    $search = filter_input(INPUT_GET, 'search', FILTER_VALIDATE_INT);
}

$actionCust= filter_input(INPUT_GET, 'cust');    


$action= filter_input(INPUT_GET, 'select');

// Get all customers
$queryAllCustomers = 'SELECT * FROM customers 
					  ORDER BY id';
$statement7 = $db1->prepare($queryAllCustomers);
$statement7->execute();
$customers = $statement7->fetchAll();
$statement7->closeCursor();


$customerFName="";
$customerLName="";
foreach($customers as $customer){
if($customer['id'] == $id){
$customerFName = $customer["first_name"];
$customerLName = $customer["last_name"];
}
}		

$searchQuery = "SELECT * FROM customers WHERE id = '$search'";
$statement8=$db1->prepare($searchQuery);
$statement8->execute();
$searchCust = $statement8->fetchAll();
$statement8->closeCursor();

?>

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
<h2>View Employee Information</h2>
<a href="../employees/employeeInformation.php">Access Employee Information</a>
<p></p>
<h2>View Supplier Information</h2>
<a href="../suppliers/viewSuppliers.php">Access Supplier Information</a>
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
   
        <center><h2>View Customer Information</h2></center>
		 <form action="" method="GET">
		<select name="id">
		<option selected="selected">Choose A Customer</option>
		<?php foreach($customers as $customer): ?>
			<option value="<?php echo $customer["id"]; ?>"><?php echo $customer['first_name']." ".$customer['last_name']; ?></option>
		<?php endforeach; ?>
		
		</select>
		<p></p>
				<input type = "submit" name= "cust" value="View Customer" >
				<p></p>
		</form>
</nav>
</aside>
<p></p>
<?php if(isset($id)){?>
<center><h2><?php echo $customerFName." ".$customerLName; ?> </h2></center>
		<table>
           <tr>
        	<th>ID</th>
			<th>Company</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email Address</th>
			<th>Business Phone #</th>
			<th>Fax Number</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip Code</th>
           </tr>
   
           
          <tr>
	          <?php foreach ($customers as $customer) : ?>
			  <?php if($customer["id"] == $id){?>
				<td> <?php echo $customer["id"]; ?></td>
				 <td> <?php echo $customer["company"]; ?></td>
				 <td> <?php echo $customer["first_name"]; ?></td>
				 <td> <?php echo $customer["last_name"]; ?></td>
				 <td> <?php echo $customer["email_address"]; ?></td>
				 <td> <?php echo $customer["business_phone"]; ?></td>
				 <td> <?php echo $customer["fax_number"]; ?></td>
				 <td> <?php echo $customer["address"]; ?></td>
				 <td> <?php echo $customer["city"]; ?></td>
				 <td> <?php echo $customer["state_province"]; ?></td>
				 <td> <?php echo $customer["zip_postal_code"]; ?></td>

				 
			  
				 
				 <form action = "" method = "get">
					  
					  <input type = "hidden" name = "id" value = "<?php echo $customer["id"]; ?> ">

					  </form>
			     
	      </tr>
		     <? } ?>
             <?php endforeach ; ?>   
         </table>
<?php } ?>	



<p>Search For Customer By ID:</p>
<form name="searchForm" method="GET" action="">
<input name="search" type="text" />
<input type="submit" name="Submit" value="Search" />
</form>
<?php if(isset($search)){?>
<p>Search Results of ID: <?php echo $search; ?></p>

<table>
           <tr>
        	<th>ID</th>
			<th>Company</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email Address</th>
			<th>Business Phone #</th>
			<th>Fax Number</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip Code</th>
           </tr>
   
           
          <tr>

<?php foreach ($searchCust as $customer) : ?>
			  <?php if($customer["id"] == $search){?>
				<td> <?php echo $customer["id"]; ?></td>
				 <td> <?php echo $customer["company"]; ?></td>
				 <td> <?php echo $customer["first_name"]; ?></td>
				 <td> <?php echo $customer["last_name"]; ?></td>
				 <td> <?php echo $customer["email_address"]; ?></td>
				 <td> <?php echo $customer["business_phone"]; ?></td>
				 <td> <?php echo $customer["fax_number"]; ?></td>
				 <td> <?php echo $customer["address"]; ?></td>
				 <td> <?php echo $customer["city"]; ?></td>
				 <td> <?php echo $customer["state_province"]; ?></td>
				 <td> <?php echo $customer["zip_postal_code"]; ?></td>
				 
				 </tr>
		     <? } ?>
             <?php endforeach ; ?>   
<?php } ?>
</section>
</main>

<footer>
        <p>&copy; <?php echo date("Y"); ?> Trade Winds, Inc.</p>
    </footer>
</body>

</html>
	