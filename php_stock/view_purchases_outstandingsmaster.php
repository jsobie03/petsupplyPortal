<?php

// Purchase_Number
// Purchase_Date
// Supplier_ID
// Notes
// Total_Amount
// Total_Payment
// Total_Balance

?>
<?php if ($view_purchases_outstandings->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $view_purchases_outstandings->TableCaption() ?></h4> -->
<div id="t_view_purchases_outstandings" class="ewGrid <?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>">
<table id="tbl_view_purchases_outstandingsmaster" class="table ewTable">
<?php echo $view_purchases_outstandings->TableCustomInnerHtml ?>
	<thead>
		<tr>
<?php if ($view_purchases_outstandings->Purchase_Number->Visible) { // Purchase_Number ?>
			<th class="ewTableHeader"><?php echo $view_purchases_outstandings->Purchase_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($view_purchases_outstandings->Purchase_Date->Visible) { // Purchase_Date ?>
			<th class="ewTableHeader"><?php echo $view_purchases_outstandings->Purchase_Date->FldCaption() ?></th>
<?php } ?>
<?php if ($view_purchases_outstandings->Supplier_ID->Visible) { // Supplier_ID ?>
			<th class="ewTableHeader"><?php echo $view_purchases_outstandings->Supplier_ID->FldCaption() ?></th>
<?php } ?>
<?php if ($view_purchases_outstandings->Notes->Visible) { // Notes ?>
			<th class="ewTableHeader"><?php echo $view_purchases_outstandings->Notes->FldCaption() ?></th>
<?php } ?>
<?php if ($view_purchases_outstandings->Total_Amount->Visible) { // Total_Amount ?>
			<th class="ewTableHeader"><?php echo $view_purchases_outstandings->Total_Amount->FldCaption() ?></th>
<?php } ?>
<?php if ($view_purchases_outstandings->Total_Payment->Visible) { // Total_Payment ?>
			<th class="ewTableHeader"><?php echo $view_purchases_outstandings->Total_Payment->FldCaption() ?></th>
<?php } ?>
<?php if ($view_purchases_outstandings->Total_Balance->Visible) { // Total_Balance ?>
			<th class="ewTableHeader"><?php echo $view_purchases_outstandings->Total_Balance->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($view_purchases_outstandings->Purchase_Number->Visible) { // Purchase_Number ?>
			<td<?php echo $view_purchases_outstandings->Purchase_Number->CellAttributes() ?>>
<span id="el_view_purchases_outstandings_Purchase_Number">
<span<?php echo $view_purchases_outstandings->Purchase_Number->ViewAttributes() ?>>
<?php echo $view_purchases_outstandings->Purchase_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($view_purchases_outstandings->Purchase_Date->Visible) { // Purchase_Date ?>
			<td<?php echo $view_purchases_outstandings->Purchase_Date->CellAttributes() ?>>
<span id="el_view_purchases_outstandings_Purchase_Date">
<span<?php echo $view_purchases_outstandings->Purchase_Date->ViewAttributes() ?>>
<?php echo $view_purchases_outstandings->Purchase_Date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($view_purchases_outstandings->Supplier_ID->Visible) { // Supplier_ID ?>
			<td<?php echo $view_purchases_outstandings->Supplier_ID->CellAttributes() ?>>
<span id="el_view_purchases_outstandings_Supplier_ID">
<span<?php echo $view_purchases_outstandings->Supplier_ID->ViewAttributes() ?>>
<?php echo $view_purchases_outstandings->Supplier_ID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($view_purchases_outstandings->Notes->Visible) { // Notes ?>
			<td<?php echo $view_purchases_outstandings->Notes->CellAttributes() ?>>
<span id="el_view_purchases_outstandings_Notes">
<span<?php echo $view_purchases_outstandings->Notes->ViewAttributes() ?>>
<?php echo $view_purchases_outstandings->Notes->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($view_purchases_outstandings->Total_Amount->Visible) { // Total_Amount ?>
			<td<?php echo $view_purchases_outstandings->Total_Amount->CellAttributes() ?>>
<span id="el_view_purchases_outstandings_Total_Amount">
<span<?php echo $view_purchases_outstandings->Total_Amount->ViewAttributes() ?>>
<?php echo $view_purchases_outstandings->Total_Amount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($view_purchases_outstandings->Total_Payment->Visible) { // Total_Payment ?>
			<td<?php echo $view_purchases_outstandings->Total_Payment->CellAttributes() ?>>
<span id="el_view_purchases_outstandings_Total_Payment">
<span<?php echo $view_purchases_outstandings->Total_Payment->ViewAttributes() ?>>
<?php echo $view_purchases_outstandings->Total_Payment->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($view_purchases_outstandings->Total_Balance->Visible) { // Total_Balance ?>
			<td<?php echo $view_purchases_outstandings->Total_Balance->CellAttributes() ?>>
<span id="el_view_purchases_outstandings_Total_Balance">
<span<?php echo $view_purchases_outstandings->Total_Balance->ViewAttributes() ?>>
<?php echo $view_purchases_outstandings->Total_Balance->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
