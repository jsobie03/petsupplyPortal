<?php include_once "usersinfo.php" ?>
<?php

// Create page object
if (!isset($a_sales_grid)) $a_sales_grid = new ca_sales_grid();

// Page init
$a_sales_grid->Page_Init();

// Page main
$a_sales_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$a_sales_grid->Page_Render();
?>
<?php if ($a_sales->Export == "") { ?>
<script type="text/javascript">

// Form object
var fa_salesgrid = new ew_Form("fa_salesgrid", "grid");
fa_salesgrid.FormKeyCountName = '<?php echo $a_sales_grid->FormKeyCountName ?>';

// Validate form
fa_salesgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_Sales_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Sales_Number->FldCaption(), $a_sales->Sales_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Sales_Date->FldCaption(), $a_sales->Sales_Date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Date");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Sales_Date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Customer_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Customer_ID->FldCaption(), $a_sales->Customer_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Total_Amount");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Total_Amount->FldCaption(), $a_sales->Total_Amount->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Discount_Amount");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Discount_Amount->FldCaption(), $a_sales->Discount_Amount->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tax_Amount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Tax_Amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Final_Total_Amount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Final_Total_Amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Total_Payment");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Total_Payment->FldCaption(), $a_sales->Total_Payment->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Total_Payment");
			if (elm && !ew_CheckRange(elm.value, 1, 999999999))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Total_Payment->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Total_Balance");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Total_Balance->FldCaption(), $a_sales->Total_Balance->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fa_salesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Sales_Number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Sales_Date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Customer_ID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Total_Amount", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Discount_Amount", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tax_Amount", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Final_Total_Amount", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Total_Payment", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Total_Balance", false)) return false;
	return true;
}

// Form_CustomValidate event
fa_salesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_salesgrid.ValidateRequired = true;
<?php } else { ?>
fa_salesgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_salesgrid.Lists["x_Customer_ID"] = {"LinkField":"x_Customer_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($a_sales->CurrentAction == "gridadd") {
	if ($a_sales->CurrentMode == "copy") {
		$bSelectLimit = $a_sales_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$a_sales_grid->TotalRecs = $a_sales->SelectRecordCount();
			$a_sales_grid->Recordset = $a_sales_grid->LoadRecordset($a_sales_grid->StartRec-1, $a_sales_grid->DisplayRecs);
		} else {
			if ($a_sales_grid->Recordset = $a_sales_grid->LoadRecordset())
				$a_sales_grid->TotalRecs = $a_sales_grid->Recordset->RecordCount();
		}
		$a_sales_grid->StartRec = 1;
		$a_sales_grid->DisplayRecs = $a_sales_grid->TotalRecs;
	} else {
		$a_sales->CurrentFilter = "0=1";
		$a_sales_grid->StartRec = 1;
		$a_sales_grid->DisplayRecs = $a_sales->GridAddRowCount;
	}
	$a_sales_grid->TotalRecs = $a_sales_grid->DisplayRecs;
	$a_sales_grid->StopRec = $a_sales_grid->DisplayRecs;
} else {
	$bSelectLimit = $a_sales_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($a_sales_grid->TotalRecs <= 0)
			$a_sales_grid->TotalRecs = $a_sales->SelectRecordCount();
	} else {
		if (!$a_sales_grid->Recordset && ($a_sales_grid->Recordset = $a_sales_grid->LoadRecordset()))
			$a_sales_grid->TotalRecs = $a_sales_grid->Recordset->RecordCount();
	}
	$a_sales_grid->StartRec = 1;
	$a_sales_grid->DisplayRecs = $a_sales_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$a_sales_grid->Recordset = $a_sales_grid->LoadRecordset($a_sales_grid->StartRec-1, $a_sales_grid->DisplayRecs);

	// Set no record found message
	if ($a_sales->CurrentAction == "" && $a_sales_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$a_sales_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($a_sales_grid->SearchWhere == "0=101")
			$a_sales_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$a_sales_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$a_sales_grid->RenderOtherOptions();
?>
<?php $a_sales_grid->ShowPageHeader(); ?>
<?php
$a_sales_grid->ShowMessage();
?>
<?php if ($a_sales_grid->TotalRecs > 0 || $a_sales->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fa_salesgrid" class="ewForm form-inline">
<?php if ($a_sales_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($a_sales_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_a_sales" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_a_salesgrid" class="table ewTable">
<?php echo $a_sales->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$a_sales_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$a_sales_grid->RenderListOptions();

// Render list options (header, left)
$a_sales_grid->ListOptions->Render("header", "left");
?>
<?php if ($a_sales->Sales_Number->Visible) { // Sales_Number ?>
	<?php if ($a_sales->SortUrl($a_sales->Sales_Number) == "") { ?>
		<th data-name="Sales_Number"><div id="elh_a_sales_Sales_Number" class="a_sales_Sales_Number"><div class="ewTableHeaderCaption"><?php echo $a_sales->Sales_Number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Number"><div><div id="elh_a_sales_Sales_Number" class="a_sales_Sales_Number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_sales->Sales_Number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales->Sales_Number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales->Sales_Number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales->Sales_Date->Visible) { // Sales_Date ?>
	<?php if ($a_sales->SortUrl($a_sales->Sales_Date) == "") { ?>
		<th data-name="Sales_Date"><div id="elh_a_sales_Sales_Date" class="a_sales_Sales_Date"><div class="ewTableHeaderCaption"><?php echo $a_sales->Sales_Date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Date"><div><div id="elh_a_sales_Sales_Date" class="a_sales_Sales_Date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_sales->Sales_Date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales->Sales_Date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales->Sales_Date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales->Customer_ID->Visible) { // Customer_ID ?>
	<?php if ($a_sales->SortUrl($a_sales->Customer_ID) == "") { ?>
		<th data-name="Customer_ID"><div id="elh_a_sales_Customer_ID" class="a_sales_Customer_ID"><div class="ewTableHeaderCaption"><?php echo $a_sales->Customer_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Customer_ID"><div><div id="elh_a_sales_Customer_ID" class="a_sales_Customer_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_sales->Customer_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales->Customer_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales->Customer_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales->Total_Amount->Visible) { // Total_Amount ?>
	<?php if ($a_sales->SortUrl($a_sales->Total_Amount) == "") { ?>
		<th data-name="Total_Amount"><div id="elh_a_sales_Total_Amount" class="a_sales_Total_Amount"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $a_sales->Total_Amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Amount"><div><div id="elh_a_sales_Total_Amount" class="a_sales_Total_Amount">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $a_sales->Total_Amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales->Total_Amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales->Total_Amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales->Discount_Amount->Visible) { // Discount_Amount ?>
	<?php if ($a_sales->SortUrl($a_sales->Discount_Amount) == "") { ?>
		<th data-name="Discount_Amount"><div id="elh_a_sales_Discount_Amount" class="a_sales_Discount_Amount"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $a_sales->Discount_Amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Discount_Amount"><div><div id="elh_a_sales_Discount_Amount" class="a_sales_Discount_Amount">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $a_sales->Discount_Amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales->Discount_Amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales->Discount_Amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales->Tax_Amount->Visible) { // Tax_Amount ?>
	<?php if ($a_sales->SortUrl($a_sales->Tax_Amount) == "") { ?>
		<th data-name="Tax_Amount"><div id="elh_a_sales_Tax_Amount" class="a_sales_Tax_Amount"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $a_sales->Tax_Amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tax_Amount"><div><div id="elh_a_sales_Tax_Amount" class="a_sales_Tax_Amount">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $a_sales->Tax_Amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales->Tax_Amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales->Tax_Amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales->Final_Total_Amount->Visible) { // Final_Total_Amount ?>
	<?php if ($a_sales->SortUrl($a_sales->Final_Total_Amount) == "") { ?>
		<th data-name="Final_Total_Amount"><div id="elh_a_sales_Final_Total_Amount" class="a_sales_Final_Total_Amount"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $a_sales->Final_Total_Amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Final_Total_Amount"><div><div id="elh_a_sales_Final_Total_Amount" class="a_sales_Final_Total_Amount">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $a_sales->Final_Total_Amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales->Final_Total_Amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales->Final_Total_Amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales->Total_Payment->Visible) { // Total_Payment ?>
	<?php if ($a_sales->SortUrl($a_sales->Total_Payment) == "") { ?>
		<th data-name="Total_Payment"><div id="elh_a_sales_Total_Payment" class="a_sales_Total_Payment"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $a_sales->Total_Payment->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Payment"><div><div id="elh_a_sales_Total_Payment" class="a_sales_Total_Payment">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $a_sales->Total_Payment->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales->Total_Payment->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales->Total_Payment->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales->Total_Balance->Visible) { // Total_Balance ?>
	<?php if ($a_sales->SortUrl($a_sales->Total_Balance) == "") { ?>
		<th data-name="Total_Balance"><div id="elh_a_sales_Total_Balance" class="a_sales_Total_Balance"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $a_sales->Total_Balance->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Balance"><div><div id="elh_a_sales_Total_Balance" class="a_sales_Total_Balance">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $a_sales->Total_Balance->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales->Total_Balance->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales->Total_Balance->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$a_sales_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$a_sales_grid->StartRec = 1;
$a_sales_grid->StopRec = $a_sales_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($a_sales_grid->FormKeyCountName) && ($a_sales->CurrentAction == "gridadd" || $a_sales->CurrentAction == "gridedit" || $a_sales->CurrentAction == "F")) {
		$a_sales_grid->KeyCount = $objForm->GetValue($a_sales_grid->FormKeyCountName);
		$a_sales_grid->StopRec = $a_sales_grid->StartRec + $a_sales_grid->KeyCount - 1;
	}
}
$a_sales_grid->RecCnt = $a_sales_grid->StartRec - 1;
if ($a_sales_grid->Recordset && !$a_sales_grid->Recordset->EOF) {
	$a_sales_grid->Recordset->MoveFirst();
	$bSelectLimit = $a_sales_grid->UseSelectLimit;
	if (!$bSelectLimit && $a_sales_grid->StartRec > 1)
		$a_sales_grid->Recordset->Move($a_sales_grid->StartRec - 1);
} elseif (!$a_sales->AllowAddDeleteRow && $a_sales_grid->StopRec == 0) {
	$a_sales_grid->StopRec = $a_sales->GridAddRowCount;
}

// Initialize aggregate
$a_sales->RowType = EW_ROWTYPE_AGGREGATEINIT;
$a_sales->ResetAttrs();
$a_sales_grid->RenderRow();
if ($a_sales->CurrentAction == "gridadd")
	$a_sales_grid->RowIndex = 0;
if ($a_sales->CurrentAction == "gridedit")
	$a_sales_grid->RowIndex = 0;
while ($a_sales_grid->RecCnt < $a_sales_grid->StopRec) {
	$a_sales_grid->RecCnt++;
	if (intval($a_sales_grid->RecCnt) >= intval($a_sales_grid->StartRec)) {
		$a_sales_grid->RowCnt++;
		if ($a_sales->CurrentAction == "gridadd" || $a_sales->CurrentAction == "gridedit" || $a_sales->CurrentAction == "F") {
			$a_sales_grid->RowIndex++;
			$objForm->Index = $a_sales_grid->RowIndex;
			if ($objForm->HasValue($a_sales_grid->FormActionName))
				$a_sales_grid->RowAction = strval($objForm->GetValue($a_sales_grid->FormActionName));
			elseif ($a_sales->CurrentAction == "gridadd")
				$a_sales_grid->RowAction = "insert";
			else
				$a_sales_grid->RowAction = "";
		}

		// Set up key count
		$a_sales_grid->KeyCount = $a_sales_grid->RowIndex;

		// Init row class and style
		$a_sales->ResetAttrs();
		$a_sales->CssClass = "";
		if ($a_sales->CurrentAction == "gridadd") {
			if ($a_sales->CurrentMode == "copy") {
				$a_sales_grid->LoadRowValues($a_sales_grid->Recordset); // Load row values
				$a_sales_grid->SetRecordKey($a_sales_grid->RowOldKey, $a_sales_grid->Recordset); // Set old record key
			} else {
				$a_sales_grid->LoadDefaultValues(); // Load default values
				$a_sales_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$a_sales_grid->LoadRowValues($a_sales_grid->Recordset); // Load row values
		}
		$a_sales->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($a_sales->CurrentAction == "gridadd") // Grid add
			$a_sales->RowType = EW_ROWTYPE_ADD; // Render add
		if ($a_sales->CurrentAction == "gridadd" && $a_sales->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$a_sales_grid->RestoreCurrentRowFormValues($a_sales_grid->RowIndex); // Restore form values
		if ($a_sales->CurrentAction == "gridedit") { // Grid edit
			if ($a_sales->EventCancelled) {
				$a_sales_grid->RestoreCurrentRowFormValues($a_sales_grid->RowIndex); // Restore form values
			}
			if ($a_sales_grid->RowAction == "insert")
				$a_sales->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$a_sales->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($a_sales->CurrentAction == "gridedit" && ($a_sales->RowType == EW_ROWTYPE_EDIT || $a_sales->RowType == EW_ROWTYPE_ADD) && $a_sales->EventCancelled) // Update failed
			$a_sales_grid->RestoreCurrentRowFormValues($a_sales_grid->RowIndex); // Restore form values
		if ($a_sales->RowType == EW_ROWTYPE_EDIT) // Edit row
			$a_sales_grid->EditRowCnt++;
		if ($a_sales->CurrentAction == "F") // Confirm row
			$a_sales_grid->RestoreCurrentRowFormValues($a_sales_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$a_sales->RowAttrs = array_merge($a_sales->RowAttrs, array('data-rowindex'=>$a_sales_grid->RowCnt, 'id'=>'r' . $a_sales_grid->RowCnt . '_a_sales', 'data-rowtype'=>$a_sales->RowType));

		// Render row
		$a_sales_grid->RenderRow();

		// Render list options
		$a_sales_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($a_sales_grid->RowAction <> "delete" && $a_sales_grid->RowAction <> "insertdelete" && !($a_sales_grid->RowAction == "insert" && $a_sales->CurrentAction == "F" && $a_sales_grid->EmptyRow())) {
?>
	<tr<?php echo $a_sales->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_sales_grid->ListOptions->Render("body", "left", $a_sales_grid->RowCnt);
?>
	<?php if ($a_sales->Sales_Number->Visible) { // Sales_Number ?>
		<td data-name="Sales_Number"<?php echo $a_sales->Sales_Number->CellAttributes() ?>>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Sales_Number" class="form-group a_sales_Sales_Number">
<input type="text" data-table="a_sales" data-field="x_Sales_Number" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Number->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Number->EditValue ?>"<?php echo $a_sales->Sales_Number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Sales_Number" name="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" id="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" value="<?php echo ew_HtmlEncode($a_sales->Sales_Number->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Sales_Number" class="form-group a_sales_Sales_Number">
<input type="text" data-table="a_sales" data-field="x_Sales_Number" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Number->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Number->EditValue ?>"<?php echo $a_sales->Sales_Number->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Sales_Number" class="a_sales_Sales_Number">
<span<?php echo $a_sales->Sales_Number->ViewAttributes() ?>>
<?php echo $a_sales->Sales_Number->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Sales_Number" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" value="<?php echo ew_HtmlEncode($a_sales->Sales_Number->FormValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Sales_Number" name="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" id="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" value="<?php echo ew_HtmlEncode($a_sales->Sales_Number->OldValue) ?>">
<?php } ?>
<a id="<?php echo $a_sales_grid->PageObjName . "_row_" . $a_sales_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="a_sales" data-field="x_Sales_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_ID" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_ID" value="<?php echo ew_HtmlEncode($a_sales->Sales_ID->CurrentValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Sales_ID" name="o<?php echo $a_sales_grid->RowIndex ?>_Sales_ID" id="o<?php echo $a_sales_grid->RowIndex ?>_Sales_ID" value="<?php echo ew_HtmlEncode($a_sales->Sales_ID->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT || $a_sales->CurrentMode == "edit") { ?>
<input type="hidden" data-table="a_sales" data-field="x_Sales_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_ID" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_ID" value="<?php echo ew_HtmlEncode($a_sales->Sales_ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($a_sales->Sales_Date->Visible) { // Sales_Date ?>
		<td data-name="Sales_Date"<?php echo $a_sales->Sales_Date->CellAttributes() ?>>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Sales_Date" class="form-group a_sales_Sales_Date">
<input type="text" data-table="a_sales" data-field="x_Sales_Date" data-format="9" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Date->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Date->EditValue ?>"<?php echo $a_sales->Sales_Date->EditAttributes() ?>>
<?php if (!$a_sales->Sales_Date->ReadOnly && !$a_sales->Sales_Date->Disabled && !isset($a_sales->Sales_Date->EditAttrs["readonly"]) && !isset($a_sales->Sales_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_salesgrid", "x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Sales_Date" name="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" id="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" value="<?php echo ew_HtmlEncode($a_sales->Sales_Date->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Sales_Date" class="form-group a_sales_Sales_Date">
<input type="text" data-table="a_sales" data-field="x_Sales_Date" data-format="9" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Date->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Date->EditValue ?>"<?php echo $a_sales->Sales_Date->EditAttributes() ?>>
<?php if (!$a_sales->Sales_Date->ReadOnly && !$a_sales->Sales_Date->Disabled && !isset($a_sales->Sales_Date->EditAttrs["readonly"]) && !isset($a_sales->Sales_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_salesgrid", "x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Sales_Date" class="a_sales_Sales_Date">
<span<?php echo $a_sales->Sales_Date->ViewAttributes() ?>>
<?php echo $a_sales->Sales_Date->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Sales_Date" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" value="<?php echo ew_HtmlEncode($a_sales->Sales_Date->FormValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Sales_Date" name="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" id="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" value="<?php echo ew_HtmlEncode($a_sales->Sales_Date->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales->Customer_ID->Visible) { // Customer_ID ?>
		<td data-name="Customer_ID"<?php echo $a_sales->Customer_ID->CellAttributes() ?>>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($a_sales->Customer_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Customer_ID" class="form-group a_sales_Customer_ID">
<span<?php echo $a_sales->Customer_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Customer_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Customer_ID" class="form-group a_sales_Customer_ID">
<select data-table="a_sales" data-field="x_Customer_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales->Customer_ID->DisplayValueSeparator) ? json_encode($a_sales->Customer_ID->DisplayValueSeparator) : $a_sales->Customer_ID->DisplayValueSeparator) ?>" id="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID"<?php echo $a_sales->Customer_ID->EditAttributes() ?>>
<?php
if (is_array($a_sales->Customer_ID->EditValue)) {
	$arwrk = $a_sales->Customer_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales->Customer_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales->Customer_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales->Customer_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->CurrentValue) ?>" selected><?php echo $a_sales->Customer_ID->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_sales->Customer_ID->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
		$sWhereWrk = "";
		break;
}
$a_sales->Customer_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales->Customer_ID->LookupFilters += array("f0" => "`Customer_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_sales->Lookup_Selecting($a_sales->Customer_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_sales->Customer_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" id="s_x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo $a_sales->Customer_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Customer_ID" name="o<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" id="o<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($a_sales->Customer_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Customer_ID" class="form-group a_sales_Customer_ID">
<span<?php echo $a_sales->Customer_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Customer_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Customer_ID" class="form-group a_sales_Customer_ID">
<select data-table="a_sales" data-field="x_Customer_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales->Customer_ID->DisplayValueSeparator) ? json_encode($a_sales->Customer_ID->DisplayValueSeparator) : $a_sales->Customer_ID->DisplayValueSeparator) ?>" id="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID"<?php echo $a_sales->Customer_ID->EditAttributes() ?>>
<?php
if (is_array($a_sales->Customer_ID->EditValue)) {
	$arwrk = $a_sales->Customer_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales->Customer_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales->Customer_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales->Customer_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->CurrentValue) ?>" selected><?php echo $a_sales->Customer_ID->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_sales->Customer_ID->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
		$sWhereWrk = "";
		break;
}
$a_sales->Customer_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales->Customer_ID->LookupFilters += array("f0" => "`Customer_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_sales->Lookup_Selecting($a_sales->Customer_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_sales->Customer_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" id="s_x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo $a_sales->Customer_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Customer_ID" class="a_sales_Customer_ID">
<span<?php echo $a_sales->Customer_ID->ViewAttributes() ?>>
<?php echo $a_sales->Customer_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Customer_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" id="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->FormValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Customer_ID" name="o<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" id="o<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales->Total_Amount->Visible) { // Total_Amount ?>
		<td data-name="Total_Amount"<?php echo $a_sales->Total_Amount->CellAttributes() ?>>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Total_Amount" class="form-group a_sales_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Amount->EditValue ?>"<?php echo $a_sales->Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Total_Amount->ReadOnly && !$a_sales->Total_Amount->Disabled && @$a_sales->Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Total_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Total_Amount->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Total_Amount" class="form-group a_sales_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Amount->EditValue ?>"<?php echo $a_sales->Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Total_Amount->ReadOnly && !$a_sales->Total_Amount->Disabled && @$a_sales->Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Total_Amount" class="a_sales_Total_Amount">
<span<?php echo $a_sales->Total_Amount->ViewAttributes() ?>>
<?php echo $a_sales->Total_Amount->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Total_Amount->FormValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Total_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Total_Amount->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales->Discount_Amount->Visible) { // Discount_Amount ?>
		<td data-name="Discount_Amount"<?php echo $a_sales->Discount_Amount->CellAttributes() ?>>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Discount_Amount" class="form-group a_sales_Discount_Amount">
<input type="text" data-table="a_sales" data-field="x_Discount_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Discount_Amount->EditValue ?>"<?php echo $a_sales->Discount_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Discount_Amount->ReadOnly && !$a_sales->Discount_Amount->Disabled && @$a_sales->Discount_Amount->EditAttrs["readonly"] == "" && @$a_sales->Discount_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Discount_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" value="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Discount_Amount" class="form-group a_sales_Discount_Amount">
<input type="text" data-table="a_sales" data-field="x_Discount_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Discount_Amount->EditValue ?>"<?php echo $a_sales->Discount_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Discount_Amount->ReadOnly && !$a_sales->Discount_Amount->Disabled && @$a_sales->Discount_Amount->EditAttrs["readonly"] == "" && @$a_sales->Discount_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Discount_Amount" class="a_sales_Discount_Amount">
<span<?php echo $a_sales->Discount_Amount->ViewAttributes() ?>>
<?php echo $a_sales->Discount_Amount->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Discount_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" value="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->FormValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Discount_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" value="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales->Tax_Amount->Visible) { // Tax_Amount ?>
		<td data-name="Tax_Amount"<?php echo $a_sales->Tax_Amount->CellAttributes() ?>>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Tax_Amount" class="form-group a_sales_Tax_Amount">
<input type="text" data-table="a_sales" data-field="x_Tax_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Amount->EditValue ?>"<?php echo $a_sales->Tax_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Tax_Amount->ReadOnly && !$a_sales->Tax_Amount->Disabled && @$a_sales->Tax_Amount->EditAttrs["readonly"] == "" && @$a_sales->Tax_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Tax_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" value="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Tax_Amount" class="form-group a_sales_Tax_Amount">
<input type="text" data-table="a_sales" data-field="x_Tax_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Amount->EditValue ?>"<?php echo $a_sales->Tax_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Tax_Amount->ReadOnly && !$a_sales->Tax_Amount->Disabled && @$a_sales->Tax_Amount->EditAttrs["readonly"] == "" && @$a_sales->Tax_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Tax_Amount" class="a_sales_Tax_Amount">
<span<?php echo $a_sales->Tax_Amount->ViewAttributes() ?>>
<?php echo $a_sales->Tax_Amount->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Tax_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" value="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->FormValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Tax_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" value="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales->Final_Total_Amount->Visible) { // Final_Total_Amount ?>
		<td data-name="Final_Total_Amount"<?php echo $a_sales->Final_Total_Amount->CellAttributes() ?>>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Final_Total_Amount" class="form-group a_sales_Final_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Final_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Final_Total_Amount->EditValue ?>"<?php echo $a_sales->Final_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Final_Total_Amount->ReadOnly && !$a_sales->Final_Total_Amount->Disabled && @$a_sales->Final_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Final_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Final_Total_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Final_Total_Amount" class="form-group a_sales_Final_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Final_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Final_Total_Amount->EditValue ?>"<?php echo $a_sales->Final_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Final_Total_Amount->ReadOnly && !$a_sales->Final_Total_Amount->Disabled && @$a_sales->Final_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Final_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Final_Total_Amount" class="a_sales_Final_Total_Amount">
<span<?php echo $a_sales->Final_Total_Amount->ViewAttributes() ?>>
<?php echo $a_sales->Final_Total_Amount->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Final_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->FormValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Final_Total_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales->Total_Payment->Visible) { // Total_Payment ?>
		<td data-name="Total_Payment"<?php echo $a_sales->Total_Payment->CellAttributes() ?>>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Total_Payment" class="form-group a_sales_Total_Payment">
<input type="text" data-table="a_sales" data-field="x_Total_Payment" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Payment->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Payment->EditValue ?>"<?php echo $a_sales->Total_Payment->EditAttributes() ?>>
<?php if (!$a_sales->Total_Payment->ReadOnly && !$a_sales->Total_Payment->Disabled && @$a_sales->Total_Payment->EditAttrs["readonly"] == "" && @$a_sales->Total_Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Total_Payment" name="o<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" id="o<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_sales->Total_Payment->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Total_Payment" class="form-group a_sales_Total_Payment">
<input type="text" data-table="a_sales" data-field="x_Total_Payment" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Payment->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Payment->EditValue ?>"<?php echo $a_sales->Total_Payment->EditAttributes() ?>>
<?php if (!$a_sales->Total_Payment->ReadOnly && !$a_sales->Total_Payment->Disabled && @$a_sales->Total_Payment->EditAttrs["readonly"] == "" && @$a_sales->Total_Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Total_Payment" class="a_sales_Total_Payment">
<span<?php echo $a_sales->Total_Payment->ViewAttributes() ?>>
<?php echo $a_sales->Total_Payment->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Total_Payment" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_sales->Total_Payment->FormValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Total_Payment" name="o<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" id="o<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_sales->Total_Payment->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales->Total_Balance->Visible) { // Total_Balance ?>
		<td data-name="Total_Balance"<?php echo $a_sales->Total_Balance->CellAttributes() ?>>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Total_Balance" class="form-group a_sales_Total_Balance">
<input type="text" data-table="a_sales" data-field="x_Total_Balance" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Balance->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Balance->EditValue ?>"<?php echo $a_sales->Total_Balance->EditAttributes() ?>>
<?php if (!$a_sales->Total_Balance->ReadOnly && !$a_sales->Total_Balance->Disabled && @$a_sales->Total_Balance->EditAttrs["readonly"] == "" && @$a_sales->Total_Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Total_Balance" name="o<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" id="o<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_sales->Total_Balance->OldValue) ?>">
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Total_Balance" class="form-group a_sales_Total_Balance">
<input type="text" data-table="a_sales" data-field="x_Total_Balance" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Balance->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Balance->EditValue ?>"<?php echo $a_sales->Total_Balance->EditAttributes() ?>>
<?php if (!$a_sales->Total_Balance->ReadOnly && !$a_sales->Total_Balance->Disabled && @$a_sales->Total_Balance->EditAttrs["readonly"] == "" && @$a_sales->Total_Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_grid->RowCnt ?>_a_sales_Total_Balance" class="a_sales_Total_Balance">
<span<?php echo $a_sales->Total_Balance->ViewAttributes() ?>>
<?php echo $a_sales->Total_Balance->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Total_Balance" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_sales->Total_Balance->FormValue) ?>">
<input type="hidden" data-table="a_sales" data-field="x_Total_Balance" name="o<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" id="o<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_sales->Total_Balance->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_sales_grid->ListOptions->Render("body", "right", $a_sales_grid->RowCnt);
?>
	</tr>
<?php if ($a_sales->RowType == EW_ROWTYPE_ADD || $a_sales->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fa_salesgrid.UpdateOpts(<?php echo $a_sales_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($a_sales->CurrentAction <> "gridadd" || $a_sales->CurrentMode == "copy")
		if (!$a_sales_grid->Recordset->EOF) $a_sales_grid->Recordset->MoveNext();
}
?>
<?php
	if ($a_sales->CurrentMode == "add" || $a_sales->CurrentMode == "copy" || $a_sales->CurrentMode == "edit") {
		$a_sales_grid->RowIndex = '$rowindex$';
		$a_sales_grid->LoadDefaultValues();

		// Set row properties
		$a_sales->ResetAttrs();
		$a_sales->RowAttrs = array_merge($a_sales->RowAttrs, array('data-rowindex'=>$a_sales_grid->RowIndex, 'id'=>'r0_a_sales', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($a_sales->RowAttrs["class"], "ewTemplate");
		$a_sales->RowType = EW_ROWTYPE_ADD;

		// Render row
		$a_sales_grid->RenderRow();

		// Render list options
		$a_sales_grid->RenderListOptions();
		$a_sales_grid->StartRowCnt = 0;
?>
	<tr<?php echo $a_sales->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_sales_grid->ListOptions->Render("body", "left", $a_sales_grid->RowIndex);
?>
	<?php if ($a_sales->Sales_Number->Visible) { // Sales_Number ?>
		<td data-name="Sales_Number">
<?php if ($a_sales->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_Sales_Number" class="form-group a_sales_Sales_Number">
<input type="text" data-table="a_sales" data-field="x_Sales_Number" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Number->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Number->EditValue ?>"<?php echo $a_sales->Sales_Number->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_Sales_Number" class="form-group a_sales_Sales_Number">
<span<?php echo $a_sales->Sales_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Sales_Number->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Sales_Number" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" value="<?php echo ew_HtmlEncode($a_sales->Sales_Number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Sales_Number" name="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" id="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Number" value="<?php echo ew_HtmlEncode($a_sales->Sales_Number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales->Sales_Date->Visible) { // Sales_Date ?>
		<td data-name="Sales_Date">
<?php if ($a_sales->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_Sales_Date" class="form-group a_sales_Sales_Date">
<input type="text" data-table="a_sales" data-field="x_Sales_Date" data-format="9" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Date->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Date->EditValue ?>"<?php echo $a_sales->Sales_Date->EditAttributes() ?>>
<?php if (!$a_sales->Sales_Date->ReadOnly && !$a_sales->Sales_Date->Disabled && !isset($a_sales->Sales_Date->EditAttrs["readonly"]) && !isset($a_sales->Sales_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_salesgrid", "x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_Sales_Date" class="form-group a_sales_Sales_Date">
<span<?php echo $a_sales->Sales_Date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Sales_Date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Sales_Date" name="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" id="x<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" value="<?php echo ew_HtmlEncode($a_sales->Sales_Date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Sales_Date" name="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" id="o<?php echo $a_sales_grid->RowIndex ?>_Sales_Date" value="<?php echo ew_HtmlEncode($a_sales->Sales_Date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales->Customer_ID->Visible) { // Customer_ID ?>
		<td data-name="Customer_ID">
<?php if ($a_sales->CurrentAction <> "F") { ?>
<?php if ($a_sales->Customer_ID->getSessionValue() <> "") { ?>
<span id="el$rowindex$_a_sales_Customer_ID" class="form-group a_sales_Customer_ID">
<span<?php echo $a_sales->Customer_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Customer_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_a_sales_Customer_ID" class="form-group a_sales_Customer_ID">
<select data-table="a_sales" data-field="x_Customer_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales->Customer_ID->DisplayValueSeparator) ? json_encode($a_sales->Customer_ID->DisplayValueSeparator) : $a_sales->Customer_ID->DisplayValueSeparator) ?>" id="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID"<?php echo $a_sales->Customer_ID->EditAttributes() ?>>
<?php
if (is_array($a_sales->Customer_ID->EditValue)) {
	$arwrk = $a_sales->Customer_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales->Customer_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales->Customer_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales->Customer_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->CurrentValue) ?>" selected><?php echo $a_sales->Customer_ID->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_sales->Customer_ID->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
		$sWhereWrk = "";
		break;
}
$a_sales->Customer_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales->Customer_ID->LookupFilters += array("f0" => "`Customer_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_sales->Lookup_Selecting($a_sales->Customer_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_sales->Customer_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" id="s_x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo $a_sales->Customer_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_a_sales_Customer_ID" class="form-group a_sales_Customer_ID">
<span<?php echo $a_sales->Customer_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Customer_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Customer_ID" name="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" id="x<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Customer_ID" name="o<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" id="o<?php echo $a_sales_grid->RowIndex ?>_Customer_ID" value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales->Total_Amount->Visible) { // Total_Amount ?>
		<td data-name="Total_Amount">
<?php if ($a_sales->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_Total_Amount" class="form-group a_sales_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Amount->EditValue ?>"<?php echo $a_sales->Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Total_Amount->ReadOnly && !$a_sales->Total_Amount->Disabled && @$a_sales->Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_Total_Amount" class="form-group a_sales_Total_Amount">
<span<?php echo $a_sales->Total_Amount->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Total_Amount->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Total_Amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Total_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Total_Amount->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales->Discount_Amount->Visible) { // Discount_Amount ?>
		<td data-name="Discount_Amount">
<?php if ($a_sales->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_Discount_Amount" class="form-group a_sales_Discount_Amount">
<input type="text" data-table="a_sales" data-field="x_Discount_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Discount_Amount->EditValue ?>"<?php echo $a_sales->Discount_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Discount_Amount->ReadOnly && !$a_sales->Discount_Amount->Disabled && @$a_sales->Discount_Amount->EditAttrs["readonly"] == "" && @$a_sales->Discount_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_Discount_Amount" class="form-group a_sales_Discount_Amount">
<span<?php echo $a_sales->Discount_Amount->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Discount_Amount->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Discount_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" value="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Discount_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Discount_Amount" value="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales->Tax_Amount->Visible) { // Tax_Amount ?>
		<td data-name="Tax_Amount">
<?php if ($a_sales->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_Tax_Amount" class="form-group a_sales_Tax_Amount">
<input type="text" data-table="a_sales" data-field="x_Tax_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Amount->EditValue ?>"<?php echo $a_sales->Tax_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Tax_Amount->ReadOnly && !$a_sales->Tax_Amount->Disabled && @$a_sales->Tax_Amount->EditAttrs["readonly"] == "" && @$a_sales->Tax_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_Tax_Amount" class="form-group a_sales_Tax_Amount">
<span<?php echo $a_sales->Tax_Amount->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Tax_Amount->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Tax_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" value="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Tax_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Tax_Amount" value="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales->Final_Total_Amount->Visible) { // Final_Total_Amount ?>
		<td data-name="Final_Total_Amount">
<?php if ($a_sales->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_Final_Total_Amount" class="form-group a_sales_Final_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Final_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Final_Total_Amount->EditValue ?>"<?php echo $a_sales->Final_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Final_Total_Amount->ReadOnly && !$a_sales->Final_Total_Amount->Disabled && @$a_sales->Final_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Final_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_Final_Total_Amount" class="form-group a_sales_Final_Total_Amount">
<span<?php echo $a_sales->Final_Total_Amount->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Final_Total_Amount->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Final_Total_Amount" name="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" id="x<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Final_Total_Amount" name="o<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" id="o<?php echo $a_sales_grid->RowIndex ?>_Final_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales->Total_Payment->Visible) { // Total_Payment ?>
		<td data-name="Total_Payment">
<?php if ($a_sales->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_Total_Payment" class="form-group a_sales_Total_Payment">
<input type="text" data-table="a_sales" data-field="x_Total_Payment" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Payment->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Payment->EditValue ?>"<?php echo $a_sales->Total_Payment->EditAttributes() ?>>
<?php if (!$a_sales->Total_Payment->ReadOnly && !$a_sales->Total_Payment->Disabled && @$a_sales->Total_Payment->EditAttrs["readonly"] == "" && @$a_sales->Total_Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_Total_Payment" class="form-group a_sales_Total_Payment">
<span<?php echo $a_sales->Total_Payment->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Total_Payment->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Total_Payment" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_sales->Total_Payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Total_Payment" name="o<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" id="o<?php echo $a_sales_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_sales->Total_Payment->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales->Total_Balance->Visible) { // Total_Balance ?>
		<td data-name="Total_Balance">
<?php if ($a_sales->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_Total_Balance" class="form-group a_sales_Total_Balance">
<input type="text" data-table="a_sales" data-field="x_Total_Balance" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Balance->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Balance->EditValue ?>"<?php echo $a_sales->Total_Balance->EditAttributes() ?>>
<?php if (!$a_sales->Total_Balance->ReadOnly && !$a_sales->Total_Balance->Disabled && @$a_sales->Total_Balance->EditAttrs["readonly"] == "" && @$a_sales->Total_Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_Total_Balance" class="form-group a_sales_Total_Balance">
<span<?php echo $a_sales->Total_Balance->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Total_Balance->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales" data-field="x_Total_Balance" name="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_sales->Total_Balance->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales" data-field="x_Total_Balance" name="o<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" id="o<?php echo $a_sales_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_sales->Total_Balance->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_sales_grid->ListOptions->Render("body", "right", $a_sales_grid->RowCnt);
?>
<script type="text/javascript">
fa_salesgrid.UpdateOpts(<?php echo $a_sales_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($a_sales->CurrentMode == "add" || $a_sales->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $a_sales_grid->FormKeyCountName ?>" id="<?php echo $a_sales_grid->FormKeyCountName ?>" value="<?php echo $a_sales_grid->KeyCount ?>">
<?php echo $a_sales_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_sales->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $a_sales_grid->FormKeyCountName ?>" id="<?php echo $a_sales_grid->FormKeyCountName ?>" value="<?php echo $a_sales_grid->KeyCount ?>">
<?php echo $a_sales_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_sales->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fa_salesgrid">
</div>
<?php

// Close recordset
if ($a_sales_grid->Recordset)
	$a_sales_grid->Recordset->Close();
?>
<?php if ($a_sales_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($a_sales_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($a_sales_grid->TotalRecs == 0 && $a_sales->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($a_sales_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($a_sales->Export == "") { ?>
<script type="text/javascript">
fa_salesgrid.Init();
</script>
<?php } ?>
<?php
$a_sales_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$a_sales_grid->Page_Terminate();
?>
