<?php

// Supplier_Number
// Stock_Number
// Stock_Name
// Purchasing_Price
// Selling_Price
// Quantity

?>
<?php if ($a_stock_items->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $a_stock_items->TableCaption() ?></h4> -->
<div id="t_a_stock_items" class="ewGrid <?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>">
<table id="tbl_a_stock_itemsmaster" class="table ewTable">
<?php echo $a_stock_items->TableCustomInnerHtml ?>
	<thead>
		<tr>
<?php if ($a_stock_items->Supplier_Number->Visible) { // Supplier_Number ?>
			<th class="ewTableHeader"><?php echo $a_stock_items->Supplier_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_stock_items->Stock_Number->Visible) { // Stock_Number ?>
			<th class="ewTableHeader"><?php echo $a_stock_items->Stock_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_stock_items->Stock_Name->Visible) { // Stock_Name ?>
			<th class="ewTableHeader"><?php echo $a_stock_items->Stock_Name->FldCaption() ?></th>
<?php } ?>
<?php if ($a_stock_items->Purchasing_Price->Visible) { // Purchasing_Price ?>
			<th class="ewTableHeader"><?php echo $a_stock_items->Purchasing_Price->FldCaption() ?></th>
<?php } ?>
<?php if ($a_stock_items->Selling_Price->Visible) { // Selling_Price ?>
			<th class="ewTableHeader"><?php echo $a_stock_items->Selling_Price->FldCaption() ?></th>
<?php } ?>
<?php if ($a_stock_items->Quantity->Visible) { // Quantity ?>
			<th class="ewTableHeader"><?php echo $a_stock_items->Quantity->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($a_stock_items->Supplier_Number->Visible) { // Supplier_Number ?>
			<td<?php echo $a_stock_items->Supplier_Number->CellAttributes() ?>>
<span id="el_a_stock_items_Supplier_Number">
<span<?php echo $a_stock_items->Supplier_Number->ViewAttributes() ?>>
<?php echo $a_stock_items->Supplier_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_stock_items->Stock_Number->Visible) { // Stock_Number ?>
			<td<?php echo $a_stock_items->Stock_Number->CellAttributes() ?>>
<span id="el_a_stock_items_Stock_Number">
<span<?php echo $a_stock_items->Stock_Number->ViewAttributes() ?>>
<?php echo $a_stock_items->Stock_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_stock_items->Stock_Name->Visible) { // Stock_Name ?>
			<td<?php echo $a_stock_items->Stock_Name->CellAttributes() ?>>
<span id="el_a_stock_items_Stock_Name">
<span<?php echo $a_stock_items->Stock_Name->ViewAttributes() ?>>
<?php echo $a_stock_items->Stock_Name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_stock_items->Purchasing_Price->Visible) { // Purchasing_Price ?>
			<td<?php echo $a_stock_items->Purchasing_Price->CellAttributes() ?>>
<span id="el_a_stock_items_Purchasing_Price">
<span<?php echo $a_stock_items->Purchasing_Price->ViewAttributes() ?>>
<?php echo $a_stock_items->Purchasing_Price->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_stock_items->Selling_Price->Visible) { // Selling_Price ?>
			<td<?php echo $a_stock_items->Selling_Price->CellAttributes() ?>>
<span id="el_a_stock_items_Selling_Price">
<span<?php echo $a_stock_items->Selling_Price->ViewAttributes() ?>>
<?php echo $a_stock_items->Selling_Price->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_stock_items->Quantity->Visible) { // Quantity ?>
			<td<?php echo $a_stock_items->Quantity->CellAttributes() ?>>
<span id="el_a_stock_items_Quantity">
<span<?php echo $a_stock_items->Quantity->ViewAttributes() ?>>
<?php echo $a_stock_items->Quantity->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
