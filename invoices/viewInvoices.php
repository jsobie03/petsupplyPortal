<?php

require_once("../inc/db_connect.php");

if(!isset($id)) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
if(!isset($search)) {
    $search = filter_input(INPUT_GET, 'search', FILTER_VALIDATE_INT);
}

 


$action= filter_input(INPUT_GET, 'select');

$queryAllInvoices = 'SELECT * FROM invoices
					  ORDER BY id';
$statement734 = $db1->prepare($queryAllInvoices);
$statement734->execute();
$invoices = $statement734->fetchAll();
$statement734->closeCursor();		

$searchQuery234 = "SELECT * FROM invoices WHERE id = '$search'";
$statement934=$db1->prepare($searchQuery234);
$statement934->execute();
$searchInvoices = $statement934->fetchAll();
$statement934->closeCursor();

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
<h2>View Purchase Order Information</h2>
<a href="../purchaseOrders/viewpurchaseOrders.php">Access Purchase Order Information</a>
<p></p>
</section>
   
        <center><h2>View Invoice Information</h2></center>
		 <form action="" method="GET">
		<select name="id">
		<option selected="selected">Choose An Invoice</option>
		<?php foreach($invoices as $invoice): ?>
			<option value="<?php echo $invoice["id"]; ?>"><?php echo $invoice['id'];?></option>
		<?php endforeach; ?>
		
		</select>
		<p></p>
				<input type = "submit" name= "invoice" value="View Invoice" >
				<p></p>
		</form>
</nav>
</aside>
<p></p>
<?php if(isset($id)){?>
		<table>
           <tr>
        	<th>ID</th>
			<th>Order ID</th>
			<th>Invoice Date</th>
			<th>Due Date</th>
			<th>Tax</th>
			<th>Shipping</th>
			<th>Amount Due</th>
           </tr>
   
           
          <tr>
	          <?php foreach ($invoices as $invoice) : ?>
			  <?php if($invoice["id"] == $id){?>
				<td> <?php echo $invoice["id"]; ?></td>
				 <td> <?php echo $invoice["order_id"]; ?></td>
				 <td> <?php echo $invoice["invoice_date"]; ?></td>
				 <td> <?php echo $invoice["due_date"]; ?></td>
				 <td> <?php echo $invoice["tax"]; ?></td>
				<td> <?php echo $invoice["shipping"]; ?></td>
				 <td> <?php echo $invoice["amount_due"]; ?></td>
			  
				 
				 <form action = "" method = "get">
					  
					  <input type = "hidden" name = "id" value = "<?php echo $invoice["id"]; ?> ">

					  </form>
			     
	      </tr>
		     <? } ?>
             <?php endforeach ; ?>   
         </table>
<?php } ?>	



<p>Search For Invoice By ID:</p>
<form name="searchForm" method="GET" action="">
<input name="search" type="text" />
<input type="submit" name="Submit" value="Search" />
</form>
<?php if(isset($search)){?>
<p>Search Results of ID: <?php echo $search; ?></p>

<table>
           <tr>
        	<th>ID</th>
			<th>Order ID</th>
			<th>Invoice Date</th>
			<th>Due Date</th>
			<th>Tax</th>
			<th>Shipping</th>
			<th>Amount Due</th>
           </tr>
   
           
          <tr>

<?php foreach ($searchInvoices as $invoice) : ?>
			  <?php if($invoice["id"] == $search){?>
				<td> <?php echo $invoice["id"]; ?></td>
				 <td> <?php echo $invoice["order_id"]; ?></td>
				 <td> <?php echo $invoice["invoice_date"]; ?></td>
				 <td> <?php echo $invoice["due_date"]; ?></td>
				 <td> <?php echo $invoice["tax"]; ?></td>
				<td> <?php echo $invoice["shipping"]; ?></td>
				 <td> <?php echo $invoice["amount_due"]; ?></td>
				 
				 
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