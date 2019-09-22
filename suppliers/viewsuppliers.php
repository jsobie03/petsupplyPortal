<?php

require_once("../inc/db_connect.php");

if(!isset($id)) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
if(!isset($search)) {
    $search = filter_input(INPUT_GET, 'search', FILTER_VALIDATE_INT);
}

 


$action= filter_input(INPUT_GET, 'select');

$queryAllSuppliers = 'SELECT * FROM suppliers
					  ORDER BY id';
$statement7 = $db1->prepare($queryAllSuppliers);
$statement7->execute();
$suppliers = $statement7->fetchAll();
$statement7->closeCursor();


$supplierFName="";
$supplierLName="";
foreach($suppliers as $supplier){
if($supplier['id'] == $id){
$supplierCompany = $supplier["company"];
}
}		

$searchQuery2 = "SELECT * FROM suppliers WHERE id = '$search'";
$statement9=$db1->prepare($searchQuery2);
$statement9->execute();
$searchSuppliers = $statement9->fetchAll();
$statement9->closeCursor();

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
<h2>View Invoice Information</h2>
<a href="../invoices/viewInvoices.php">Access Invoice Information</a>
<p></p>
<h2>View Purchase Order Information</h2>
<a href="../purchaseOrders/viewpurchaseOrders.php">Access Purchase Order Information</a>
<p></p>
</section>
   
        <center><h2>View Supplier Information</h2></center>
		 <form action="" method="GET">
		<select name="id">
		<option selected="selected">Choose A Supplier</option>
		<?php foreach($suppliers as $supplier): ?>
			<option value="<?php echo $supplier["id"]; ?>"><?php echo $supplier['company'];?></option>
		<?php endforeach; ?>
		
		</select>
		<p></p>
				<input type = "submit" name= "supplier" value="View Supplier" >
				<p></p>
		</form>
</nav>
</aside>
<p></p>
<?php if(isset($id)){?>
<center><h2><?php echo $supplierCompany; ?> </h2></center>
		<table>
           <tr>
        	<th>ID</th>
			<th>Company</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Job Title</th>
           </tr>
   
           
          <tr>
	          <?php foreach ($suppliers as $supplier) : ?>
			  <?php if($supplier["id"] == $id){?>
				<td> <?php echo $supplier["id"]; ?></td>
				 <td> <?php echo $supplier["company"]; ?></td>
				 <td> <?php echo $supplier["first_name"]; ?></td>
				 <td> <?php echo $supplier["last_name"]; ?></td>
				 <td> <?php echo $supplier["job_title"]; ?></td>	 
			  
				 
				 <form action = "" method = "get">
					  
					  <input type = "hidden" name = "id" value = "<?php echo $supplier["id"]; ?> ">

					  </form>
			     
	      </tr>
		     <? } ?>
             <?php endforeach ; ?>   
         </table>
<?php } ?>	



<p>Search For Supplier By ID:</p>
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
			<th>Job Title</th>
           </tr>
   
           
          <tr>

<?php foreach ($searchSuppliers as $supplier) : ?>
			  <?php if($supplier["id"] == $search){?>
				<td> <?php echo $supplier["id"]; ?></td>
				 <td> <?php echo $supplier["company"]; ?></td>
				 <td> <?php echo $supplier["first_name"]; ?></td>
				 <td> <?php echo $supplier["last_name"]; ?></td>
				 <td> <?php echo $supplier["job_title"]; ?></td>
				 
				 
				 </tr>
		     <? } ?>
             <?php endforeach ; ?>   
<?php } ?>
</section>
</main>
<?php include "../inc/footer.php" ?>
</body>

</html>