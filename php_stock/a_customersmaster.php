<?php

// Customer_Number
// Customer_Name
// Contact_Person
// Phone_Number
// Mobile_Number
// Balance

?>
<?php if ($a_customers->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $a_customers->TableCaption() ?></h4> -->
<div id="t_a_customers" class="ewGrid <?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>">
<table id="tbl_a_customersmaster" class="table ewTable">
<?php echo $a_customers->TableCustomInnerHtml ?>
	<thead>
		<tr>
<?php if ($a_customers->Customer_Number->Visible) { // Customer_Number ?>
			<th class="ewTableHeader"><?php echo $a_customers->Customer_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_customers->Customer_Name->Visible) { // Customer_Name ?>
			<th class="ewTableHeader"><?php echo $a_customers->Customer_Name->FldCaption() ?></th>
<?php } ?>
<?php if ($a_customers->Contact_Person->Visible) { // Contact_Person ?>
			<th class="ewTableHeader"><?php echo $a_customers->Contact_Person->FldCaption() ?></th>
<?php } ?>
<?php if ($a_customers->Phone_Number->Visible) { // Phone_Number ?>
			<th class="ewTableHeader"><?php echo $a_customers->Phone_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_customers->Mobile_Number->Visible) { // Mobile_Number ?>
			<th class="ewTableHeader"><?php echo $a_customers->Mobile_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_customers->Balance->Visible) { // Balance ?>
			<th class="ewTableHeader"><?php echo $a_customers->Balance->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($a_customers->Customer_Number->Visible) { // Customer_Number ?>
			<td<?php echo $a_customers->Customer_Number->CellAttributes() ?>>
<span id="el_a_customers_Customer_Number">
<span<?php echo $a_customers->Customer_Number->ViewAttributes() ?>>
<?php echo $a_customers->Customer_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Customer_Name->Visible) { // Customer_Name ?>
			<td<?php echo $a_customers->Customer_Name->CellAttributes() ?>>
<span id="el_a_customers_Customer_Name">
<span<?php echo $a_customers->Customer_Name->ViewAttributes() ?>>
<?php echo $a_customers->Customer_Name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Contact_Person->Visible) { // Contact_Person ?>
			<td<?php echo $a_customers->Contact_Person->CellAttributes() ?>>
<span id="el_a_customers_Contact_Person">
<span<?php echo $a_customers->Contact_Person->ViewAttributes() ?>>
<?php echo $a_customers->Contact_Person->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Phone_Number->Visible) { // Phone_Number ?>
			<td<?php echo $a_customers->Phone_Number->CellAttributes() ?>>
<span id="el_a_customers_Phone_Number">
<span<?php echo $a_customers->Phone_Number->ViewAttributes() ?>>
<?php echo $a_customers->Phone_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Mobile_Number->Visible) { // Mobile_Number ?>
			<td<?php echo $a_customers->Mobile_Number->CellAttributes() ?>>
<span id="el_a_customers_Mobile_Number">
<span<?php echo $a_customers->Mobile_Number->ViewAttributes() ?>>
<?php echo $a_customers->Mobile_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_customers->Balance->Visible) { // Balance ?>
			<td<?php echo $a_customers->Balance->CellAttributes() ?>>
<span id="el_a_customers_Balance">
<span<?php echo $a_customers->Balance->ViewAttributes() ?>>
<?php echo $a_customers->Balance->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
