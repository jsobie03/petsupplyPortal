<?php

// Sales_Number
// Sales_Date
// Customer_ID
// Total_Amount
// Discount_Amount
// Tax_Amount
// Final_Total_Amount
// Total_Payment
// Total_Balance

?>
<?php if ($a_sales->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $a_sales->TableCaption() ?></h4> -->
<div id="t_a_sales" class="ewGrid <?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>">
<table id="tbl_a_salesmaster" class="table ewTable">
<?php echo $a_sales->TableCustomInnerHtml ?>
	<thead>
		<tr>
<?php if ($a_sales->Sales_Number->Visible) { // Sales_Number ?>
			<th class="ewTableHeader"><?php echo $a_sales->Sales_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_sales->Sales_Date->Visible) { // Sales_Date ?>
			<th class="ewTableHeader"><?php echo $a_sales->Sales_Date->FldCaption() ?></th>
<?php } ?>
<?php if ($a_sales->Customer_ID->Visible) { // Customer_ID ?>
			<th class="ewTableHeader"><?php echo $a_sales->Customer_ID->FldCaption() ?></th>
<?php } ?>
<?php if ($a_sales->Total_Amount->Visible) { // Total_Amount ?>
			<th class="ewTableHeader"><?php echo $a_sales->Total_Amount->FldCaption() ?></th>
<?php } ?>
<?php if ($a_sales->Discount_Amount->Visible) { // Discount_Amount ?>
			<th class="ewTableHeader"><?php echo $a_sales->Discount_Amount->FldCaption() ?></th>
<?php } ?>
<?php if ($a_sales->Tax_Amount->Visible) { // Tax_Amount ?>
			<th class="ewTableHeader"><?php echo $a_sales->Tax_Amount->FldCaption() ?></th>
<?php } ?>
<?php if ($a_sales->Final_Total_Amount->Visible) { // Final_Total_Amount ?>
			<th class="ewTableHeader"><?php echo $a_sales->Final_Total_Amount->FldCaption() ?></th>
<?php } ?>
<?php if ($a_sales->Total_Payment->Visible) { // Total_Payment ?>
			<th class="ewTableHeader"><?php echo $a_sales->Total_Payment->FldCaption() ?></th>
<?php } ?>
<?php if ($a_sales->Total_Balance->Visible) { // Total_Balance ?>
			<th class="ewTableHeader"><?php echo $a_sales->Total_Balance->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($a_sales->Sales_Number->Visible) { // Sales_Number ?>
			<td<?php echo $a_sales->Sales_Number->CellAttributes() ?>>
<span id="el_a_sales_Sales_Number">
<span<?php echo $a_sales->Sales_Number->ViewAttributes() ?>>
<?php echo $a_sales->Sales_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_sales->Sales_Date->Visible) { // Sales_Date ?>
			<td<?php echo $a_sales->Sales_Date->CellAttributes() ?>>
<span id="el_a_sales_Sales_Date">
<span<?php echo $a_sales->Sales_Date->ViewAttributes() ?>>
<?php echo $a_sales->Sales_Date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_sales->Customer_ID->Visible) { // Customer_ID ?>
			<td<?php echo $a_sales->Customer_ID->CellAttributes() ?>>
<span id="el_a_sales_Customer_ID">
<span<?php echo $a_sales->Customer_ID->ViewAttributes() ?>>
<?php echo $a_sales->Customer_ID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_sales->Total_Amount->Visible) { // Total_Amount ?>
			<td<?php echo $a_sales->Total_Amount->CellAttributes() ?>>
<span id="el_a_sales_Total_Amount">
<span<?php echo $a_sales->Total_Amount->ViewAttributes() ?>>
<?php echo $a_sales->Total_Amount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_sales->Discount_Amount->Visible) { // Discount_Amount ?>
			<td<?php echo $a_sales->Discount_Amount->CellAttributes() ?>>
<span id="el_a_sales_Discount_Amount">
<span<?php echo $a_sales->Discount_Amount->ViewAttributes() ?>>
<?php echo $a_sales->Discount_Amount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_sales->Tax_Amount->Visible) { // Tax_Amount ?>
			<td<?php echo $a_sales->Tax_Amount->CellAttributes() ?>>
<span id="el_a_sales_Tax_Amount">
<span<?php echo $a_sales->Tax_Amount->ViewAttributes() ?>>
<?php echo $a_sales->Tax_Amount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_sales->Final_Total_Amount->Visible) { // Final_Total_Amount ?>
			<td<?php echo $a_sales->Final_Total_Amount->CellAttributes() ?>>
<span id="el_a_sales_Final_Total_Amount">
<span<?php echo $a_sales->Final_Total_Amount->ViewAttributes() ?>>
<?php echo $a_sales->Final_Total_Amount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_sales->Total_Payment->Visible) { // Total_Payment ?>
			<td<?php echo $a_sales->Total_Payment->CellAttributes() ?>>
<span id="el_a_sales_Total_Payment">
<span<?php echo $a_sales->Total_Payment->ViewAttributes() ?>>
<?php echo $a_sales->Total_Payment->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_sales->Total_Balance->Visible) { // Total_Balance ?>
			<td<?php echo $a_sales->Total_Balance->CellAttributes() ?>>
<span id="el_a_sales_Total_Balance">
<span<?php echo $a_sales->Total_Balance->ViewAttributes() ?>>
<?php echo $a_sales->Total_Balance->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
