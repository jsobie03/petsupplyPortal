<?php

// Category_ID
// Category_Description

?>
<?php if ($help_categories->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $help_categories->TableCaption() ?></h4> -->
<div id="t_help_categories" class="ewGrid <?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>">
<table id="tbl_help_categoriesmaster" class="table ewTable">
<?php echo $help_categories->TableCustomInnerHtml ?>
	<thead>
		<tr>
<?php if ($help_categories->Category_ID->Visible) { // Category_ID ?>
			<th class="ewTableHeader"><?php echo $help_categories->Category_ID->FldCaption() ?></th>
<?php } ?>
<?php if ($help_categories->Category_Description->Visible) { // Category_Description ?>
			<th class="ewTableHeader"><?php echo $help_categories->Category_Description->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($help_categories->Category_ID->Visible) { // Category_ID ?>
			<td<?php echo $help_categories->Category_ID->CellAttributes() ?>>
<span id="el_help_categories_Category_ID">
<span<?php echo $help_categories->Category_ID->ViewAttributes() ?>>
<?php echo $help_categories->Category_ID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($help_categories->Category_Description->Visible) { // Category_Description ?>
			<td<?php echo $help_categories->Category_Description->CellAttributes() ?>>
<span id="el_help_categories_Category_Description">
<span<?php echo $help_categories->Category_Description->ViewAttributes() ?>>
<?php echo $help_categories->Category_Description->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
