<?php

require_once("../inc/db_connect.php");

if(!isset($id)) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
if(!isset($search)) {
    $search = filter_input(INPUT_GET, 'search', FILTER_VALIDATE_INT);
}

 


$action= filter_input(INPUT_GET, 'select');

$queryAllOrders = 'SELECT * FROM orders
					  ORDER BY id';
$statement733 = $db1->prepare($queryAllOrders);
$statement733->execute();
$orders = $statement733->fetchAll();
$statement733->closeCursor();


$searchQuery222 = "SELECT * FROM orders WHERE id = '$search'";
$statement999=$db1->prepare($searchQuery222);
$statement999->execute();
$searchOrders = $statement999->fetchAll();
$statement999->closeCursor();

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
<h2>View Customer Information</h2>
<a href="../customers/viewCustomers.php">Access Customer Information</a>
<p></p>
<h2>View Supplier Information</h2>
<a href="../suppliers/viewSuppliers.php">Access Supplier Information</a>
<p></p>
<h2>View Invoice Information</h2>
<a href="../invoices/viewInvoices.php">Access Invoice Information</a>
<p></p>
<h2>View Purchase Order Information</h2>
<a href="../purchaseOrders/viewpurchaseOrders.php">Access Purchase Order Information</a>
<p></p>
</section>
   
        <center><h2>View Order Information By Order ID:</h2></center>
		 <form action="" method="GET">
		<select name="id">
		<option selected="selected">Choose An Order</option>
		<?php foreach($orders as $order): ?>
			<option value="<?php echo $order["id"]; ?>"><?php echo $order['id'];?></option>
		<?php endforeach; ?>
		
		</select>
		<p></p>
				<input type = "submit" name= "order" value="View Order" >
				<p></p>
		</form>
</nav>
</aside>
<p></p>
<section>
<?php if(isset($id)){?>  
    
	          <?php foreach ($orders as $order) : ?>
			  <?php if($order["id"] == $id){?>
				 <p><?php echo 'ID: '.$order["id"]; ?></p>
				 <p><?php echo 'Employee ID: '.$order["employee_id"]; ?></p>
				 <p><?php echo 'Customer ID: '.$order["customer_id"]; ?></p>
				 <p><?php echo 'Order Date: '.$order["order_date"]; ?></p>
				 <p><?php echo 'Date Shipped: '.$order["shipped_date"]; ?> </p>
				 <p><?php echo 'Shipper ID: '.$order["shipper_id"]; ?></p>
				 <p><?php echo 'Ship Name: '.$order["ship_name"]; ?></p>
				 <p><?php echo 'Ship Address: '.$order["ship_address"]; ?></p>
				 <p><?php echo 'Ship City: '.$order["ship_city"]; ?></p>
				 <p><?php echo 'Ship State: '.$order["ship_state_province"]; ?></p>
				 <p><?php echo 'Ship Zip Code: '.$order["ship_zip_postal_code"]; ?></p>
				 <p><?php echo 'Ship Country Region: '.$order["ship_country_region"]; ?></p>
				 <p><?php echo 'Shipping Fee: '.$order["shipping_fee"]; ?></p>
				 <p><?php echo 'Taxes: '.$order["taxes"]; ?></p>
				 <p><?php echo 'Payment Type: '.$order["payment_type"]; ?></p>
				 <p><?php echo 'Paid Date: '.$order["paid_date"]; ?></p>
				 <p><?php echo 'Any Notes: '.$order["notes"]; ?></p>
			  
				 
				 <form action = "" method = "get">
					  
					  <input type = "hidden" name = "id" value = "<?php echo $order["id"]; ?> ">

					  </form>
			     
	      
		     <? } ?>
             <?php endforeach ; ?>   
         
<?php } ?>	

</section>

<p>Search For Order By ID:</p>
<form name="searchForm" method="GET" action="">
<input name="search" type="text" />
<input type="submit" name="Submit" value="Search" />
</form>
<section>

<?php if(isset($search)){?>
<p>Search Results of ID: <?php echo $search; ?></p>


<?php foreach ($searchOrders as $order) : ?>
			  <?php if($order["id"] == $search){?>
				<p><?php echo 'ID: '.$order["id"]; ?></p>
				 <p><?php echo 'Employee ID: '.$order["employee_id"]; ?></p>
				 <p><?php echo 'Customer ID: '.$order["customer_id"]; ?></p>
				 <p><?php echo 'Order Date: '.$order["order_date"]; ?></p>
				 <p><?php echo 'Date Shipped: '.$order["shipped_date"]; ?> </p>
				 <p><?php echo 'Shipper ID: '.$order["shipper_id"]; ?></p>
				 <p><?php echo 'Ship Name: '.$order["ship_name"]; ?></p>
				 <p><?php echo 'Ship Address: '.$order["ship_address"]; ?></p>
				 <p><?php echo 'Ship City: '.$order["ship_city"]; ?></p>
				 <p><?php echo 'Ship State: '.$order["ship_state_province"]; ?></p>
				 <p><?php echo 'Ship Zip Code: '.$order["ship_zip_postal_code"]; ?></p>
				 <p><?php echo 'Ship Country Region: '.$order["ship_country_region"]; ?></p>
				 <p><?php echo 'Shipping Fee: '.$order["shipping_fee"]; ?></p>
				 <p><?php echo 'Taxes: '.$order["taxes"]; ?></p>
				 <p><?php echo 'Payment Type: '.$order["payment_type"]; ?></p>
				 <p><?php echo 'Paid Date: '.$order["paid_date"]; ?></p>
				 <p><?php echo 'Any Notes: '.$order["notes"]; ?></p>
				 
				 
				 
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