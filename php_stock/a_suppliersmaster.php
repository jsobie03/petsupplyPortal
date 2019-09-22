<?php

// Supplier_Number
// Supplier_Name
// Contact_Person
// Phone_Number
// Mobile_Number
// Balance
// Is_Stock_Available

?>
<?php if ($a_suppliers->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $a_suppliers->TableCaption() ?></h4> -->
<div id="t_a_suppliers" class="ewGrid <?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>">
<table id="tbl_a_suppliersmaster" class="table ewTable">
<?php echo $a_suppliers->TableCustomInnerHtml ?>
	<thead>
		<tr>
<?php if ($a_suppliers->Supplier_Number->Visible) { // Supplier_Number ?>
			<th class="ewTableHeader"><?php echo $a_suppliers->Supplier_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_suppliers->Supplier_Name->Visible) { // Supplier_Name ?>
			<th class="ewTableHeader"><?php echo $a_suppliers->Supplier_Name->FldCaption() ?></th>
<?php } ?>
<?php if ($a_suppliers->Contact_Person->Visible) { // Contact_Person ?>
			<th class="ewTableHeader"><?php echo $a_suppliers->Contact_Person->FldCaption() ?></th>
<?php } ?>
<?php if ($a_suppliers->Phone_Number->Visible) { // Phone_Number ?>
			<th class="ewTableHeader"><?php echo $a_suppliers->Phone_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_suppliers->Mobile_Number->Visible) { // Mobile_Number ?>
			<th class="ewTableHeader"><?php echo $a_suppliers->Mobile_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_suppliers->Balance->Visible) { // Balance ?>
			<th class="ewTableHeader"><?php echo $a_suppliers->Balance->FldCaption() ?></th>
<?php } ?>
<?php if ($a_suppliers->Is_Stock_Available->Visible) { // Is_Stock_Available ?>
			<th class="ewTableHeader"><?php echo $a_suppliers->Is_Stock_Available->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($a_suppliers->Supplier_Number->Visible) { // Supplier_Number ?>
			<td<?php echo $a_suppliers->Supplier_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_Number">
<span<?php echo $a_suppliers->Supplier_Number->ViewAttributes() ?>>
<?php echo $a_suppliers->Supplier_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_suppliers->Supplier_Name->Visible) { // Supplier_Name ?>
			<td<?php echo $a_suppliers->Supplier_Name->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_Name">
<span<?php echo $a_suppliers->Supplier_Name->ViewAttributes() ?>>
<?php echo $a_suppliers->Supplier_Name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_suppliers->Contact_Person->Visible) { // Contact_Person ?>
			<td<?php echo $a_suppliers->Contact_Person->CellAttributes() ?>>
<span id="el_a_suppliers_Contact_Person">
<span<?php echo $a_suppliers->Contact_Person->ViewAttributes() ?>>
<?php echo $a_suppliers->Contact_Person->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_suppliers->Phone_Number->Visible) { // Phone_Number ?>
			<td<?php echo $a_suppliers->Phone_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Phone_Number">
<span<?php echo $a_suppliers->Phone_Number->ViewAttributes() ?>>
<?php echo $a_suppliers->Phone_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_suppliers->Mobile_Number->Visible) { // Mobile_Number ?>
			<td<?php echo $a_suppliers->Mobile_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Mobile_Number">
<span<?php echo $a_suppliers->Mobile_Number->ViewAttributes() ?>>
<?php echo $a_suppliers->Mobile_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_suppliers->Balance->Visible) { // Balance ?>
			<td<?php echo $a_suppliers->Balance->CellAttributes() ?>>
<span id="el_a_suppliers_Balance">
<span<?php echo $a_suppliers->Balance->ViewAttributes() ?>>
<?php echo $a_suppliers->Balance->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_suppliers->Is_Stock_Available->Visible) { // Is_Stock_Available ?>
			<td<?php echo $a_suppliers->Is_Stock_Available->CellAttributes() ?>>
<span id="el_a_suppliers_Is_Stock_Available">
<span<?php echo $a_suppliers->Is_Stock_Available->ViewAttributes() ?>>
<?php echo $a_suppliers->Is_Stock_Available->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
