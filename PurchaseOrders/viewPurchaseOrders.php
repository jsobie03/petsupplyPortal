<?php

require_once("../inc/db_connect.php");

if(!isset($id)) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
if(!isset($search)) {
    $search = filter_input(INPUT_GET, 'search', FILTER_VALIDATE_INT);
}

 


$action= filter_input(INPUT_GET, 'select');

$queryAllPurchaseOrders = 'SELECT * FROM purchase_orders
					  ORDER BY id';
$statement333 = $db1->prepare($queryAllPurchaseOrders);
$statement333->execute();
$purchaseOrders = $statement333->fetchAll();
$statement333->closeCursor();		

$searchQuery333 = "SELECT * FROM purchase_orders WHERE id = '$search'";
$statement333=$db1->prepare($searchQuery333);
$statement333->execute();
$searchPurchaseOrders = $statement333->fetchAll();
$statement333->closeCursor();

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
<h2>View Order Information</h2>
<a href="../productOrders/viewProductOrders.php">Access Order Information</a>
<p></p>
<h2>View Supplier Information</h2>
<a href="../suppliers/viewSuppliers.php">Access Supplier Information</a>
<p></p>
<h2>View Invoice Information</h2>
<a href="../invoices/viewInvoices.php">Access Invoice Information</a>
</section>
   
        <center><h2>View Purchase Order Information</h2></center>
		 <form action="" method="GET">
		<select name="id">
		<option selected="selected">Choose A Purchase Order</option>
		<?php foreach($purchaseOrders as $purchaseOrder): ?>
			<option value="<?php echo $purchaseOrder["id"]; ?>"><?php echo $purchaseOrder['id'];?></option>
		<?php endforeach; ?>
		
		</select>
		<p></p>
				<input type = "submit" name= "purchaseOrder" value="View Purchase Order" >
				<p></p>
		</form>
</nav>
</aside>
<p></p>
<section>
<?php if(isset($id)){?>
   
	          <?php foreach ($purchaseOrders as $purchaseOrder) : ?>
			  <?php if($purchaseOrder["id"] == $id){?>
				<p><?php echo 'ID: '.$purchaseOrder["id"]; ?></p>
				 <p><?php echo 'Supplier ID: '.$purchaseOrder["supplier_id"]; ?></p>
				 <p><?php echo 'Created By: '.$purchaseOrder["created_by"]; ?></p>
				 <p><?php echo 'Submitted Date: '.$purchaseOrder["submitted_date"]; ?></p>
				 <p><?php echo 'Creation Date: '.$purchaseOrder["creation_date"]; ?> </p>
				 <p><?php echo 'Status ID: '.$purchaseOrder["status_id"]; ?></p>
				 <p><?php echo 'Expected Date: '.$purchaseOrder["expected_date"]; ?></p>
				 <p><?php echo 'Shipping Fee: '.$purchaseOrder["shipping_fee"]; ?></p>
				 <p><?php echo 'Taxes: '.$purchaseOrder["taxes"]; ?></p>
				 <p><?php echo 'Payment Date: '.$purchaseOrder["payment_date"]; ?></p>
				 <p><?php echo 'Payment Amount: '.$purchaseOrder["payment_amount"]; ?></p>
				 <p><?php echo 'Payment Method: '.$purchaseOrder["payment_method"]; ?></p>
				 <p><?php echo 'Notes: '.$purchaseOrder["notes"]; ?></p>
				 <p><?php echo 'Approved By: '.$purchaseOrder["approved_by"]; ?></p>
				 <p><?php echo 'Approved Date: '.$purchaseOrder["approved_date"]; ?></p>
				 <p><?php echo 'Submitted By: '.$purchaseOrder["submitted_by"]; ?></p>
			  
				 
				 <form action = "" method = "get">
					  
					  <input type = "hidden" name = "id" value = "<?php echo $purchaseOrder["id"]; ?> ">

					  </form>
			     
		     <? } ?>
             <?php endforeach ; ?>   
<?php } ?>	
</section>


<p>Search For Invoice By ID:</p>
<form name="searchForm" method="GET" action="">
<input name="search" type="text" />
<input type="submit" name="Submit" value="Search" />
</form>
<section>

<?php if(isset($search)){?>
<p>Search Results of ID: <?php echo $search; ?></p>

<?php foreach ($searchPurchaseOrders as $purchaseOrder) : ?>
			  <?php if($purchaseOrder["id"] == $search){?>
				<p><?php echo 'ID: '.$purchaseOrder["id"]; ?></p>
				 <p><?php echo 'Supplier ID: '.$purchaseOrder["supplier_id"]; ?></p>
				 <p><?php echo 'Created By: '.$purchaseOrder["created_by"]; ?></p>
				 <p><?php echo 'Submitted Date: '.$purchaseOrder["submitted_date"]; ?></p>
				 <p><?php echo 'Creation Date: '.$purchaseOrder["creation_date"]; ?> </p>
				 <p><?php echo 'Status ID: '.$purchaseOrder["status_id"]; ?></p>
				 <p><?php echo 'Expected Date: '.$purchaseOrder["expected_date"]; ?></p>
				 <p><?php echo 'Shipping Fee: '.$purchaseOrder["shipping_fee"]; ?></p>
				 <p><?php echo 'Taxes: '.$purchaseOrder["taxes"]; ?></p>
				 <p><?php echo 'Payment Date: '.$purchaseOrder["payment_date"]; ?></p>
				 <p><?php echo 'Payment Amount: '.$purchaseOrder["payment_amount"]; ?></p>
				 <p><?php echo 'Payment Method: '.$purchaseOrder["payment_method"]; ?></p>
				 <p><?php echo 'Notes: '.$purchaseOrder["notes"]; ?></p>
				 <p><?php echo 'Approved By: '.$purchaseOrder["approved_by"]; ?></p>
				 <p><?php echo 'Approved Date: '.$purchaseOrder["approved_date"]; ?></p>
				 <p><?php echo 'Submitted By: '.$purchaseOrder["submitted_by"]; ?></p>
				 
				 
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