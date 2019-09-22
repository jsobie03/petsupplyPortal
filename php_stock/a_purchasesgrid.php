<?php include_once "usersinfo.php" ?>
<?php

// Create page object
if (!isset($a_purchases_grid)) $a_purchases_grid = new ca_purchases_grid();

// Page init
$a_purchases_grid->Page_Init();

// Page main
$a_purchases_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$a_purchases_grid->Page_Render();
?>
<?php if ($a_purchases->Export == "") { ?>
<script type="text/javascript">

// Form object
var fa_purchasesgrid = new ew_Form("fa_purchasesgrid", "grid");
fa_purchasesgrid.FormKeyCountName = '<?php echo $a_purchases_grid->FormKeyCountName ?>';

// Validate form
fa_purchasesgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Purchase_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_purchases->Purchase_Number->FldCaption(), $a_purchases->Purchase_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Purchase_Date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_purchases->Purchase_Date->FldCaption(), $a_purchases->Purchase_Date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Purchase_Date");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_purchases->Purchase_Date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Supplier_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_purchases->Supplier_ID->FldCaption(), $a_purchases->Supplier_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Total_Amount");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_purchases->Total_Amount->FldCaption(), $a_purchases->Total_Amount->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Total_Amount");
			if (elm && !ew_CheckRange(elm.value, 1, 999999999))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_purchases->Total_Amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Total_Payment");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_purchases->Total_Payment->FldCaption(), $a_purchases->Total_Payment->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Total_Payment");
			if (elm && !ew_CheckRange(elm.value, 1, 999999999))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_purchases->Total_Payment->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Total_Balance");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_purchases->Total_Balance->FldCaption(), $a_purchases->Total_Balance->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Total_Balance");
			if (elm && !ew_CheckRange(elm.value, 0, 999999999))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_purchases->Total_Balance->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fa_purchasesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Purchase_Number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Purchase_Date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Supplier_ID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Total_Amount", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Total_Payment", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Total_Balance", false)) return false;
	return true;
}

// Form_CustomValidate event
fa_purchasesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_purchasesgrid.ValidateRequired = true;
<?php } else { ?>
fa_purchasesgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_purchasesgrid.Lists["x_Supplier_ID"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":["a_purchases_detail x_Supplier_Number"],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($a_purchases->CurrentAction == "gridadd") {
	if ($a_purchases->CurrentMode == "copy") {
		$bSelectLimit = $a_purchases_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$a_purchases_grid->TotalRecs = $a_purchases->SelectRecordCount();
			$a_purchases_grid->Recordset = $a_purchases_grid->LoadRecordset($a_purchases_grid->StartRec-1, $a_purchases_grid->DisplayRecs);
		} else {
			if ($a_purchases_grid->Recordset = $a_purchases_grid->LoadRecordset())
				$a_purchases_grid->TotalRecs = $a_purchases_grid->Recordset->RecordCount();
		}
		$a_purchases_grid->StartRec = 1;
		$a_purchases_grid->DisplayRecs = $a_purchases_grid->TotalRecs;
	} else {
		$a_purchases->CurrentFilter = "0=1";
		$a_purchases_grid->StartRec = 1;
		$a_purchases_grid->DisplayRecs = $a_purchases->GridAddRowCount;
	}
	$a_purchases_grid->TotalRecs = $a_purchases_grid->DisplayRecs;
	$a_purchases_grid->StopRec = $a_purchases_grid->DisplayRecs;
} else {
	$bSelectLimit = $a_purchases_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($a_purchases_grid->TotalRecs <= 0)
			$a_purchases_grid->TotalRecs = $a_purchases->SelectRecordCount();
	} else {
		if (!$a_purchases_grid->Recordset && ($a_purchases_grid->Recordset = $a_purchases_grid->LoadRecordset()))
			$a_purchases_grid->TotalRecs = $a_purchases_grid->Recordset->RecordCount();
	}
	$a_purchases_grid->StartRec = 1;
	$a_purchases_grid->DisplayRecs = $a_purchases_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$a_purchases_grid->Recordset = $a_purchases_grid->LoadRecordset($a_purchases_grid->StartRec-1, $a_purchases_grid->DisplayRecs);

	// Set no record found message
	if ($a_purchases->CurrentAction == "" && $a_purchases_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$a_purchases_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($a_purchases_grid->SearchWhere == "0=101")
			$a_purchases_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$a_purchases_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$a_purchases_grid->RenderOtherOptions();
?>
<?php $a_purchases_grid->ShowPageHeader(); ?>
<?php
$a_purchases_grid->ShowMessage();
?>
<?php if ($a_purchases_grid->TotalRecs > 0 || $a_purchases->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fa_purchasesgrid" class="ewForm form-inline">
<?php if ($a_purchases_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($a_purchases_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_a_purchases" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_a_purchasesgrid" class="table ewTable">
<?php echo $a_purchases->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$a_purchases_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$a_purchases_grid->RenderListOptions();

// Render list options (header, left)
$a_purchases_grid->ListOptions->Render("header", "left");
?>
<?php if ($a_purchases->Purchase_Number->Visible) { // Purchase_Number ?>
	<?php if ($a_purchases->SortUrl($a_purchases->Purchase_Number) == "") { ?>
		<th data-name="Purchase_Number"><div id="elh_a_purchases_Purchase_Number" class="a_purchases_Purchase_Number"><div class="ewTableHeaderCaption"><?php echo $a_purchases->Purchase_Number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Purchase_Number"><div><div id="elh_a_purchases_Purchase_Number" class="a_purchases_Purchase_Number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_purchases->Purchase_Number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_purchases->Purchase_Number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_purchases->Purchase_Number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_purchases->Purchase_Date->Visible) { // Purchase_Date ?>
	<?php if ($a_purchases->SortUrl($a_purchases->Purchase_Date) == "") { ?>
		<th data-name="Purchase_Date"><div id="elh_a_purchases_Purchase_Date" class="a_purchases_Purchase_Date"><div class="ewTableHeaderCaption"><?php echo $a_purchases->Purchase_Date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Purchase_Date"><div><div id="elh_a_purchases_Purchase_Date" class="a_purchases_Purchase_Date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_purchases->Purchase_Date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_purchases->Purchase_Date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_purchases->Purchase_Date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_purchases->Supplier_ID->Visible) { // Supplier_ID ?>
	<?php if ($a_purchases->SortUrl($a_purchases->Supplier_ID) == "") { ?>
		<th data-name="Supplier_ID"><div id="elh_a_purchases_Supplier_ID" class="a_purchases_Supplier_ID"><div class="ewTableHeaderCaption"><?php echo $a_purchases->Supplier_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Supplier_ID"><div><div id="elh_a_purchases_Supplier_ID" class="a_purchases_Supplier_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_purchases->Supplier_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_purchases->Supplier_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_purchases->Supplier_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_purchases->Total_Amount->Visible) { // Total_Amount ?>
	<?php if ($a_purchases->SortUrl($a_purchases->Total_Amount) == "") { ?>
		<th data-name="Total_Amount"><div id="elh_a_purchases_Total_Amount" class="a_purchases_Total_Amount"><div class="ewTableHeaderCaption"><?php echo $a_purchases->Total_Amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Amount"><div><div id="elh_a_purchases_Total_Amount" class="a_purchases_Total_Amount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_purchases->Total_Amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_purchases->Total_Amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_purchases->Total_Amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_purchases->Total_Payment->Visible) { // Total_Payment ?>
	<?php if ($a_purchases->SortUrl($a_purchases->Total_Payment) == "") { ?>
		<th data-name="Total_Payment"><div id="elh_a_purchases_Total_Payment" class="a_purchases_Total_Payment"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $a_purchases->Total_Payment->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Payment"><div><div id="elh_a_purchases_Total_Payment" class="a_purchases_Total_Payment">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $a_purchases->Total_Payment->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_purchases->Total_Payment->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_purchases->Total_Payment->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_purchases->Total_Balance->Visible) { // Total_Balance ?>
	<?php if ($a_purchases->SortUrl($a_purchases->Total_Balance) == "") { ?>
		<th data-name="Total_Balance"><div id="elh_a_purchases_Total_Balance" class="a_purchases_Total_Balance"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $a_purchases->Total_Balance->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Balance"><div><div id="elh_a_purchases_Total_Balance" class="a_purchases_Total_Balance">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $a_purchases->Total_Balance->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_purchases->Total_Balance->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_purchases->Total_Balance->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$a_purchases_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$a_purchases_grid->StartRec = 1;
$a_purchases_grid->StopRec = $a_purchases_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($a_purchases_grid->FormKeyCountName) && ($a_purchases->CurrentAction == "gridadd" || $a_purchases->CurrentAction == "gridedit" || $a_purchases->CurrentAction == "F")) {
		$a_purchases_grid->KeyCount = $objForm->GetValue($a_purchases_grid->FormKeyCountName);
		$a_purchases_grid->StopRec = $a_purchases_grid->StartRec + $a_purchases_grid->KeyCount - 1;
	}
}
$a_purchases_grid->RecCnt = $a_purchases_grid->StartRec - 1;
if ($a_purchases_grid->Recordset && !$a_purchases_grid->Recordset->EOF) {
	$a_purchases_grid->Recordset->MoveFirst();
	$bSelectLimit = $a_purchases_grid->UseSelectLimit;
	if (!$bSelectLimit && $a_purchases_grid->StartRec > 1)
		$a_purchases_grid->Recordset->Move($a_purchases_grid->StartRec - 1);
} elseif (!$a_purchases->AllowAddDeleteRow && $a_purchases_grid->StopRec == 0) {
	$a_purchases_grid->StopRec = $a_purchases->GridAddRowCount;
}

// Initialize aggregate
$a_purchases->RowType = EW_ROWTYPE_AGGREGATEINIT;
$a_purchases->ResetAttrs();
$a_purchases_grid->RenderRow();
if ($a_purchases->CurrentAction == "gridadd")
	$a_purchases_grid->RowIndex = 0;
if ($a_purchases->CurrentAction == "gridedit")
	$a_purchases_grid->RowIndex = 0;
while ($a_purchases_grid->RecCnt < $a_purchases_grid->StopRec) {
	$a_purchases_grid->RecCnt++;
	if (intval($a_purchases_grid->RecCnt) >= intval($a_purchases_grid->StartRec)) {
		$a_purchases_grid->RowCnt++;
		if ($a_purchases->CurrentAction == "gridadd" || $a_purchases->CurrentAction == "gridedit" || $a_purchases->CurrentAction == "F") {
			$a_purchases_grid->RowIndex++;
			$objForm->Index = $a_purchases_grid->RowIndex;
			if ($objForm->HasValue($a_purchases_grid->FormActionName))
				$a_purchases_grid->RowAction = strval($objForm->GetValue($a_purchases_grid->FormActionName));
			elseif ($a_purchases->CurrentAction == "gridadd")
				$a_purchases_grid->RowAction = "insert";
			else
				$a_purchases_grid->RowAction = "";
		}

		// Set up key count
		$a_purchases_grid->KeyCount = $a_purchases_grid->RowIndex;

		// Init row class and style
		$a_purchases->ResetAttrs();
		$a_purchases->CssClass = "";
		if ($a_purchases->CurrentAction == "gridadd") {
			if ($a_purchases->CurrentMode == "copy") {
				$a_purchases_grid->LoadRowValues($a_purchases_grid->Recordset); // Load row values
				$a_purchases_grid->SetRecordKey($a_purchases_grid->RowOldKey, $a_purchases_grid->Recordset); // Set old record key
			} else {
				$a_purchases_grid->LoadDefaultValues(); // Load default values
				$a_purchases_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$a_purchases_grid->LoadRowValues($a_purchases_grid->Recordset); // Load row values
		}
		$a_purchases->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($a_purchases->CurrentAction == "gridadd") // Grid add
			$a_purchases->RowType = EW_ROWTYPE_ADD; // Render add
		if ($a_purchases->CurrentAction == "gridadd" && $a_purchases->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$a_purchases_grid->RestoreCurrentRowFormValues($a_purchases_grid->RowIndex); // Restore form values
		if ($a_purchases->CurrentAction == "gridedit") { // Grid edit
			if ($a_purchases->EventCancelled) {
				$a_purchases_grid->RestoreCurrentRowFormValues($a_purchases_grid->RowIndex); // Restore form values
			}
			if ($a_purchases_grid->RowAction == "insert")
				$a_purchases->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$a_purchases->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($a_purchases->CurrentAction == "gridedit" && ($a_purchases->RowType == EW_ROWTYPE_EDIT || $a_purchases->RowType == EW_ROWTYPE_ADD) && $a_purchases->EventCancelled) // Update failed
			$a_purchases_grid->RestoreCurrentRowFormValues($a_purchases_grid->RowIndex); // Restore form values
		if ($a_purchases->RowType == EW_ROWTYPE_EDIT) // Edit row
			$a_purchases_grid->EditRowCnt++;
		if ($a_purchases->CurrentAction == "F") // Confirm row
			$a_purchases_grid->RestoreCurrentRowFormValues($a_purchases_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$a_purchases->RowAttrs = array_merge($a_purchases->RowAttrs, array('data-rowindex'=>$a_purchases_grid->RowCnt, 'id'=>'r' . $a_purchases_grid->RowCnt . '_a_purchases', 'data-rowtype'=>$a_purchases->RowType));

		// Render row
		$a_purchases_grid->RenderRow();

		// Render list options
		$a_purchases_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($a_purchases_grid->RowAction <> "delete" && $a_purchases_grid->RowAction <> "insertdelete" && !($a_purchases_grid->RowAction == "insert" && $a_purchases->CurrentAction == "F" && $a_purchases_grid->EmptyRow())) {
?>
	<tr<?php echo $a_purchases->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_purchases_grid->ListOptions->Render("body", "left", $a_purchases_grid->RowCnt);
?>
	<?php if ($a_purchases->Purchase_Number->Visible) { // Purchase_Number ?>
		<td data-name="Purchase_Number"<?php echo $a_purchases->Purchase_Number->CellAttributes() ?>>
<?php if ($a_purchases->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Purchase_Number" class="form-group a_purchases_Purchase_Number">
<input type="text" data-table="a_purchases" data-field="x_Purchase_Number" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_purchases->Purchase_Number->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Purchase_Number->EditValue ?>"<?php echo $a_purchases->Purchase_Number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Number" name="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" id="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Number->OldValue) ?>">
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Purchase_Number" class="form-group a_purchases_Purchase_Number">
<input type="text" data-table="a_purchases" data-field="x_Purchase_Number" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_purchases->Purchase_Number->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Purchase_Number->EditValue ?>"<?php echo $a_purchases->Purchase_Number->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Purchase_Number" class="a_purchases_Purchase_Number">
<span<?php echo $a_purchases->Purchase_Number->ViewAttributes() ?>>
<?php echo $a_purchases->Purchase_Number->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Number" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Number->FormValue) ?>">
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Number" name="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" id="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Number->OldValue) ?>">
<?php } ?>
<a id="<?php echo $a_purchases_grid->PageObjName . "_row_" . $a_purchases_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_ID" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_ID" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_ID->CurrentValue) ?>">
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_ID" name="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_ID" id="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_ID" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_ID->OldValue) ?>">
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_EDIT || $a_purchases->CurrentMode == "edit") { ?>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_ID" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_ID" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($a_purchases->Purchase_Date->Visible) { // Purchase_Date ?>
		<td data-name="Purchase_Date"<?php echo $a_purchases->Purchase_Date->CellAttributes() ?>>
<?php if ($a_purchases->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Purchase_Date" class="form-group a_purchases_Purchase_Date">
<input type="text" data-table="a_purchases" data-field="x_Purchase_Date" data-format="9" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" placeholder="<?php echo ew_HtmlEncode($a_purchases->Purchase_Date->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Purchase_Date->EditValue ?>"<?php echo $a_purchases->Purchase_Date->EditAttributes() ?>>
<?php if (!$a_purchases->Purchase_Date->ReadOnly && !$a_purchases->Purchase_Date->Disabled && !isset($a_purchases->Purchase_Date->EditAttrs["readonly"]) && !isset($a_purchases->Purchase_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_purchasesgrid", "x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Date" name="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" id="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Date->OldValue) ?>">
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Purchase_Date" class="form-group a_purchases_Purchase_Date">
<input type="text" data-table="a_purchases" data-field="x_Purchase_Date" data-format="9" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" placeholder="<?php echo ew_HtmlEncode($a_purchases->Purchase_Date->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Purchase_Date->EditValue ?>"<?php echo $a_purchases->Purchase_Date->EditAttributes() ?>>
<?php if (!$a_purchases->Purchase_Date->ReadOnly && !$a_purchases->Purchase_Date->Disabled && !isset($a_purchases->Purchase_Date->EditAttrs["readonly"]) && !isset($a_purchases->Purchase_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_purchasesgrid", "x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Purchase_Date" class="a_purchases_Purchase_Date">
<span<?php echo $a_purchases->Purchase_Date->ViewAttributes() ?>>
<?php echo $a_purchases->Purchase_Date->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Date" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Date->FormValue) ?>">
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Date" name="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" id="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Date->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_purchases->Supplier_ID->Visible) { // Supplier_ID ?>
		<td data-name="Supplier_ID"<?php echo $a_purchases->Supplier_ID->CellAttributes() ?>>
<?php if ($a_purchases->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($a_purchases->Supplier_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Supplier_ID" class="form-group a_purchases_Supplier_ID">
<span<?php echo $a_purchases->Supplier_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_purchases->Supplier_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Supplier_ID" class="form-group a_purchases_Supplier_ID">
<?php $a_purchases->Supplier_ID->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$a_purchases->Supplier_ID->EditAttrs["onchange"]; ?>
<select data-table="a_purchases" data-field="x_Supplier_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_purchases->Supplier_ID->DisplayValueSeparator) ? json_encode($a_purchases->Supplier_ID->DisplayValueSeparator) : $a_purchases->Supplier_ID->DisplayValueSeparator) ?>" id="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID"<?php echo $a_purchases->Supplier_ID->EditAttributes() ?>>
<?php
if (is_array($a_purchases->Supplier_ID->EditValue)) {
	$arwrk = $a_purchases->Supplier_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_purchases->Supplier_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_purchases->Supplier_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_purchases->Supplier_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->CurrentValue) ?>" selected><?php echo $a_purchases->Supplier_ID->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_purchases->Supplier_ID->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
		$sWhereWrk = "";
		break;
}
$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "Supplier_Number = '".$_GET["Supplier_Number"]."'" : "";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_purchases->Supplier_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_purchases->Supplier_ID->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_purchases->Lookup_Selecting($a_purchases->Supplier_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_purchases->Supplier_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" id="s_x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo $a_purchases->Supplier_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="a_purchases" data-field="x_Supplier_ID" name="o<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" id="o<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->OldValue) ?>">
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($a_purchases->Supplier_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Supplier_ID" class="form-group a_purchases_Supplier_ID">
<span<?php echo $a_purchases->Supplier_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_purchases->Supplier_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Supplier_ID" class="form-group a_purchases_Supplier_ID">
<select data-table="a_purchases" data-field="x_Supplier_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_purchases->Supplier_ID->DisplayValueSeparator) ? json_encode($a_purchases->Supplier_ID->DisplayValueSeparator) : $a_purchases->Supplier_ID->DisplayValueSeparator) ?>" id="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID"<?php echo $a_purchases->Supplier_ID->EditAttributes() ?>>
<?php
if (is_array($a_purchases->Supplier_ID->EditValue)) {
	$arwrk = $a_purchases->Supplier_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_purchases->Supplier_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_purchases->Supplier_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_purchases->Supplier_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->CurrentValue) ?>" selected><?php echo $a_purchases->Supplier_ID->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_purchases->Supplier_ID->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
		$sWhereWrk = "";
		break;
}
$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "Supplier_Number = '".$_GET["Supplier_Number"]."'" : "";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_purchases->Supplier_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_purchases->Supplier_ID->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_purchases->Lookup_Selecting($a_purchases->Supplier_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_purchases->Supplier_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" id="s_x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo $a_purchases->Supplier_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Supplier_ID" class="a_purchases_Supplier_ID">
<span<?php echo $a_purchases->Supplier_ID->ViewAttributes() ?>>
<?php echo $a_purchases->Supplier_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Supplier_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" id="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->FormValue) ?>">
<input type="hidden" data-table="a_purchases" data-field="x_Supplier_ID" name="o<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" id="o<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_purchases->Total_Amount->Visible) { // Total_Amount ?>
		<td data-name="Total_Amount"<?php echo $a_purchases->Total_Amount->CellAttributes() ?>>
<?php if ($a_purchases->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Total_Amount" class="form-group a_purchases_Total_Amount">
<input type="text" data-table="a_purchases" data-field="x_Total_Amount" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_purchases->Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Total_Amount->EditValue ?>"<?php echo $a_purchases->Total_Amount->EditAttributes() ?>>
<?php if (!$a_purchases->Total_Amount->ReadOnly && !$a_purchases->Total_Amount->Disabled && @$a_purchases->Total_Amount->EditAttrs["readonly"] == "" && @$a_purchases->Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Amount" name="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" id="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_purchases->Total_Amount->OldValue) ?>">
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Total_Amount" class="form-group a_purchases_Total_Amount">
<input type="text" data-table="a_purchases" data-field="x_Total_Amount" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_purchases->Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Total_Amount->EditValue ?>"<?php echo $a_purchases->Total_Amount->EditAttributes() ?>>
<?php if (!$a_purchases->Total_Amount->ReadOnly && !$a_purchases->Total_Amount->Disabled && @$a_purchases->Total_Amount->EditAttrs["readonly"] == "" && @$a_purchases->Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Total_Amount" class="a_purchases_Total_Amount">
<span<?php echo $a_purchases->Total_Amount->ViewAttributes() ?>>
<?php echo $a_purchases->Total_Amount->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Amount" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_purchases->Total_Amount->FormValue) ?>">
<input type="hidden" data-table="a_purchases" data-field="x_Total_Amount" name="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" id="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_purchases->Total_Amount->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_purchases->Total_Payment->Visible) { // Total_Payment ?>
		<td data-name="Total_Payment"<?php echo $a_purchases->Total_Payment->CellAttributes() ?>>
<?php if ($a_purchases->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Total_Payment" class="form-group a_purchases_Total_Payment">
<input type="text" data-table="a_purchases" data-field="x_Total_Payment" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_purchases->Total_Payment->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Total_Payment->EditValue ?>"<?php echo $a_purchases->Total_Payment->EditAttributes() ?>>
<?php if (!$a_purchases->Total_Payment->ReadOnly && !$a_purchases->Total_Payment->Disabled && @$a_purchases->Total_Payment->EditAttrs["readonly"] == "" && @$a_purchases->Total_Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Payment" name="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" id="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_purchases->Total_Payment->OldValue) ?>">
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Total_Payment" class="form-group a_purchases_Total_Payment">
<input type="text" data-table="a_purchases" data-field="x_Total_Payment" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_purchases->Total_Payment->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Total_Payment->EditValue ?>"<?php echo $a_purchases->Total_Payment->EditAttributes() ?>>
<?php if (!$a_purchases->Total_Payment->ReadOnly && !$a_purchases->Total_Payment->Disabled && @$a_purchases->Total_Payment->EditAttrs["readonly"] == "" && @$a_purchases->Total_Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Total_Payment" class="a_purchases_Total_Payment">
<span<?php echo $a_purchases->Total_Payment->ViewAttributes() ?>>
<?php echo $a_purchases->Total_Payment->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Payment" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_purchases->Total_Payment->FormValue) ?>">
<input type="hidden" data-table="a_purchases" data-field="x_Total_Payment" name="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" id="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_purchases->Total_Payment->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_purchases->Total_Balance->Visible) { // Total_Balance ?>
		<td data-name="Total_Balance"<?php echo $a_purchases->Total_Balance->CellAttributes() ?>>
<?php if ($a_purchases->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Total_Balance" class="form-group a_purchases_Total_Balance">
<input type="text" data-table="a_purchases" data-field="x_Total_Balance" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_purchases->Total_Balance->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Total_Balance->EditValue ?>"<?php echo $a_purchases->Total_Balance->EditAttributes() ?>>
<?php if (!$a_purchases->Total_Balance->ReadOnly && !$a_purchases->Total_Balance->Disabled && @$a_purchases->Total_Balance->EditAttrs["readonly"] == "" && @$a_purchases->Total_Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Balance" name="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" id="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_purchases->Total_Balance->OldValue) ?>">
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Total_Balance" class="form-group a_purchases_Total_Balance">
<input type="text" data-table="a_purchases" data-field="x_Total_Balance" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_purchases->Total_Balance->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Total_Balance->EditValue ?>"<?php echo $a_purchases->Total_Balance->EditAttributes() ?>>
<?php if (!$a_purchases->Total_Balance->ReadOnly && !$a_purchases->Total_Balance->Disabled && @$a_purchases->Total_Balance->EditAttrs["readonly"] == "" && @$a_purchases->Total_Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_purchases->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_purchases_grid->RowCnt ?>_a_purchases_Total_Balance" class="a_purchases_Total_Balance">
<span<?php echo $a_purchases->Total_Balance->ViewAttributes() ?>>
<?php echo $a_purchases->Total_Balance->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Balance" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_purchases->Total_Balance->FormValue) ?>">
<input type="hidden" data-table="a_purchases" data-field="x_Total_Balance" name="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" id="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_purchases->Total_Balance->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_purchases_grid->ListOptions->Render("body", "right", $a_purchases_grid->RowCnt);
?>
	</tr>
<?php if ($a_purchases->RowType == EW_ROWTYPE_ADD || $a_purchases->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fa_purchasesgrid.UpdateOpts(<?php echo $a_purchases_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($a_purchases->CurrentAction <> "gridadd" || $a_purchases->CurrentMode == "copy")
		if (!$a_purchases_grid->Recordset->EOF) $a_purchases_grid->Recordset->MoveNext();
}
?>
<?php
	if ($a_purchases->CurrentMode == "add" || $a_purchases->CurrentMode == "copy" || $a_purchases->CurrentMode == "edit") {
		$a_purchases_grid->RowIndex = '$rowindex$';
		$a_purchases_grid->LoadDefaultValues();

		// Set row properties
		$a_purchases->ResetAttrs();
		$a_purchases->RowAttrs = array_merge($a_purchases->RowAttrs, array('data-rowindex'=>$a_purchases_grid->RowIndex, 'id'=>'r0_a_purchases', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($a_purchases->RowAttrs["class"], "ewTemplate");
		$a_purchases->RowType = EW_ROWTYPE_ADD;

		// Render row
		$a_purchases_grid->RenderRow();

		// Render list options
		$a_purchases_grid->RenderListOptions();
		$a_purchases_grid->StartRowCnt = 0;
?>
	<tr<?php echo $a_purchases->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_purchases_grid->ListOptions->Render("body", "left", $a_purchases_grid->RowIndex);
?>
	<?php if ($a_purchases->Purchase_Number->Visible) { // Purchase_Number ?>
		<td data-name="Purchase_Number">
<?php if ($a_purchases->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_purchases_Purchase_Number" class="form-group a_purchases_Purchase_Number">
<input type="text" data-table="a_purchases" data-field="x_Purchase_Number" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_purchases->Purchase_Number->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Purchase_Number->EditValue ?>"<?php echo $a_purchases->Purchase_Number->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_purchases_Purchase_Number" class="form-group a_purchases_Purchase_Number">
<span<?php echo $a_purchases->Purchase_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_purchases->Purchase_Number->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Number" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Number" name="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" id="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Number" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_purchases->Purchase_Date->Visible) { // Purchase_Date ?>
		<td data-name="Purchase_Date">
<?php if ($a_purchases->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_purchases_Purchase_Date" class="form-group a_purchases_Purchase_Date">
<input type="text" data-table="a_purchases" data-field="x_Purchase_Date" data-format="9" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" placeholder="<?php echo ew_HtmlEncode($a_purchases->Purchase_Date->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Purchase_Date->EditValue ?>"<?php echo $a_purchases->Purchase_Date->EditAttributes() ?>>
<?php if (!$a_purchases->Purchase_Date->ReadOnly && !$a_purchases->Purchase_Date->Disabled && !isset($a_purchases->Purchase_Date->EditAttrs["readonly"]) && !isset($a_purchases->Purchase_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_purchasesgrid", "x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_purchases_Purchase_Date" class="form-group a_purchases_Purchase_Date">
<span<?php echo $a_purchases->Purchase_Date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_purchases->Purchase_Date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Date" name="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" id="x<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_purchases" data-field="x_Purchase_Date" name="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" id="o<?php echo $a_purchases_grid->RowIndex ?>_Purchase_Date" value="<?php echo ew_HtmlEncode($a_purchases->Purchase_Date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_purchases->Supplier_ID->Visible) { // Supplier_ID ?>
		<td data-name="Supplier_ID">
<?php if ($a_purchases->CurrentAction <> "F") { ?>
<?php if ($a_purchases->Supplier_ID->getSessionValue() <> "") { ?>
<span id="el$rowindex$_a_purchases_Supplier_ID" class="form-group a_purchases_Supplier_ID">
<span<?php echo $a_purchases->Supplier_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_purchases->Supplier_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_a_purchases_Supplier_ID" class="form-group a_purchases_Supplier_ID">
<?php $a_purchases->Supplier_ID->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$a_purchases->Supplier_ID->EditAttrs["onchange"]; ?>
<select data-table="a_purchases" data-field="x_Supplier_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_purchases->Supplier_ID->DisplayValueSeparator) ? json_encode($a_purchases->Supplier_ID->DisplayValueSeparator) : $a_purchases->Supplier_ID->DisplayValueSeparator) ?>" id="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID"<?php echo $a_purchases->Supplier_ID->EditAttributes() ?>>
<?php
if (is_array($a_purchases->Supplier_ID->EditValue)) {
	$arwrk = $a_purchases->Supplier_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_purchases->Supplier_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_purchases->Supplier_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_purchases->Supplier_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->CurrentValue) ?>" selected><?php echo $a_purchases->Supplier_ID->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_purchases->Supplier_ID->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
		$sWhereWrk = "";
		break;
}
$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "Supplier_Number = '".$_GET["Supplier_Number"]."'" : "";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_purchases->Supplier_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_purchases->Supplier_ID->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_purchases->Lookup_Selecting($a_purchases->Supplier_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_purchases->Supplier_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" id="s_x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo $a_purchases->Supplier_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_a_purchases_Supplier_ID" class="form-group a_purchases_Supplier_ID">
<span<?php echo $a_purchases->Supplier_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_purchases->Supplier_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Supplier_ID" name="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" id="x<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_purchases" data-field="x_Supplier_ID" name="o<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" id="o<?php echo $a_purchases_grid->RowIndex ?>_Supplier_ID" value="<?php echo ew_HtmlEncode($a_purchases->Supplier_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_purchases->Total_Amount->Visible) { // Total_Amount ?>
		<td data-name="Total_Amount">
<?php if ($a_purchases->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_purchases_Total_Amount" class="form-group a_purchases_Total_Amount">
<input type="text" data-table="a_purchases" data-field="x_Total_Amount" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_purchases->Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Total_Amount->EditValue ?>"<?php echo $a_purchases->Total_Amount->EditAttributes() ?>>
<?php if (!$a_purchases->Total_Amount->ReadOnly && !$a_purchases->Total_Amount->Disabled && @$a_purchases->Total_Amount->EditAttrs["readonly"] == "" && @$a_purchases->Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_purchases_Total_Amount" class="form-group a_purchases_Total_Amount">
<span<?php echo $a_purchases->Total_Amount->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_purchases->Total_Amount->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Amount" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_purchases->Total_Amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Amount" name="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" id="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Amount" value="<?php echo ew_HtmlEncode($a_purchases->Total_Amount->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_purchases->Total_Payment->Visible) { // Total_Payment ?>
		<td data-name="Total_Payment">
<?php if ($a_purchases->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_purchases_Total_Payment" class="form-group a_purchases_Total_Payment">
<input type="text" data-table="a_purchases" data-field="x_Total_Payment" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_purchases->Total_Payment->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Total_Payment->EditValue ?>"<?php echo $a_purchases->Total_Payment->EditAttributes() ?>>
<?php if (!$a_purchases->Total_Payment->ReadOnly && !$a_purchases->Total_Payment->Disabled && @$a_purchases->Total_Payment->EditAttrs["readonly"] == "" && @$a_purchases->Total_Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_purchases_Total_Payment" class="form-group a_purchases_Total_Payment">
<span<?php echo $a_purchases->Total_Payment->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_purchases->Total_Payment->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Payment" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_purchases->Total_Payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Payment" name="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" id="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Payment" value="<?php echo ew_HtmlEncode($a_purchases->Total_Payment->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_purchases->Total_Balance->Visible) { // Total_Balance ?>
		<td data-name="Total_Balance">
<?php if ($a_purchases->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_purchases_Total_Balance" class="form-group a_purchases_Total_Balance">
<input type="text" data-table="a_purchases" data-field="x_Total_Balance" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_purchases->Total_Balance->getPlaceHolder()) ?>" value="<?php echo $a_purchases->Total_Balance->EditValue ?>"<?php echo $a_purchases->Total_Balance->EditAttributes() ?>>
<?php if (!$a_purchases->Total_Balance->ReadOnly && !$a_purchases->Total_Balance->Disabled && @$a_purchases->Total_Balance->EditAttrs["readonly"] == "" && @$a_purchases->Total_Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_purchases_Total_Balance" class="form-group a_purchases_Total_Balance">
<span<?php echo $a_purchases->Total_Balance->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_purchases->Total_Balance->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Balance" name="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" id="x<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_purchases->Total_Balance->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_purchases" data-field="x_Total_Balance" name="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" id="o<?php echo $a_purchases_grid->RowIndex ?>_Total_Balance" value="<?php echo ew_HtmlEncode($a_purchases->Total_Balance->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_purchases_grid->ListOptions->Render("body", "right", $a_purchases_grid->RowCnt);
?>
<script type="text/javascript">
fa_purchasesgrid.UpdateOpts(<?php echo $a_purchases_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($a_purchases->CurrentMode == "add" || $a_purchases->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $a_purchases_grid->FormKeyCountName ?>" id="<?php echo $a_purchases_grid->FormKeyCountName ?>" value="<?php echo $a_purchases_grid->KeyCount ?>">
<?php echo $a_purchases_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_purchases->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $a_purchases_grid->FormKeyCountName ?>" id="<?php echo $a_purchases_grid->FormKeyCountName ?>" value="<?php echo $a_purchases_grid->KeyCount ?>">
<?php echo $a_purchases_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_purchases->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fa_purchasesgrid">
</div>
<?php

// Close recordset
if ($a_purchases_grid->Recordset)
	$a_purchases_grid->Recordset->Close();
?>
<?php if ($a_purchases_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($a_purchases_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($a_purchases_grid->TotalRecs == 0 && $a_purchases->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($a_purchases_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($a_purchases->Export == "") { ?>
<script type="text/javascript">
fa_purchasesgrid.Init();
</script>
<?php } ?>
<?php
$a_purchases_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$a_purchases_grid->Page_Terminate();
?>
