<?php include_once "usersinfo.php" ?>
<?php

// Create page object
if (!isset($a_payment_transactions_grid)) $a_payment_transactions_grid = new ca_payment_transactions_grid();

// Page init
$a_payment_transactions_grid->Page_Init();

// Page main
$a_payment_transactions_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$a_payment_transactions_grid->Page_Render();
?>
<?php if ($a_payment_transactions->Export == "") { ?>
<script type="text/javascript">

// Form object
var fa_payment_transactionsgrid = new ew_Form("fa_payment_transactionsgrid", "grid");
fa_payment_transactionsgrid.FormKeyCountName = '<?php echo $a_payment_transactions_grid->FormKeyCountName ?>';

// Validate form
fa_payment_transactionsgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Payment");
			if (elm && !ew_CheckRange(elm.value, 1, 999999999))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_payment_transactions->Payment->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Due_Date");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_payment_transactions->Due_Date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Date_Transaction");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_payment_transactions->Date_Transaction->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fa_payment_transactionsgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Ref_ID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Customer", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Supplier", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Sub_Total", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Payment", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Balance", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Due_Date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Date_Transaction", false)) return false;
	return true;
}

// Form_CustomValidate event
fa_payment_transactionsgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_payment_transactionsgrid.ValidateRequired = true;
<?php } else { ?>
fa_payment_transactionsgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_payment_transactionsgrid.Lists["x_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_payment_transactionsgrid.Lists["x_Type"].Options = <?php echo json_encode($a_payment_transactions->Type->Options()) ?>;
fa_payment_transactionsgrid.Lists["x_Customer"] = {"LinkField":"x_Customer_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_payment_transactionsgrid.Lists["x_Supplier"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($a_payment_transactions->CurrentAction == "gridadd") {
	if ($a_payment_transactions->CurrentMode == "copy") {
		$bSelectLimit = $a_payment_transactions_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$a_payment_transactions_grid->TotalRecs = $a_payment_transactions->SelectRecordCount();
			$a_payment_transactions_grid->Recordset = $a_payment_transactions_grid->LoadRecordset($a_payment_transactions_grid->StartRec-1, $a_payment_transactions_grid->DisplayRecs);
		} else {
			if ($a_payment_transactions_grid->Recordset = $a_payment_transactions_grid->LoadRecordset())
				$a_payment_transactions_grid->TotalRecs = $a_payment_transactions_grid->Recordset->RecordCount();
		}
		$a_payment_transactions_grid->StartRec = 1;
		$a_payment_transactions_grid->DisplayRecs = $a_payment_transactions_grid->TotalRecs;
	} else {
		$a_payment_transactions->CurrentFilter = "0=1";
		$a_payment_transactions_grid->StartRec = 1;
		$a_payment_transactions_grid->DisplayRecs = $a_payment_transactions->GridAddRowCount;
	}
	$a_payment_transactions_grid->TotalRecs = $a_payment_transactions_grid->DisplayRecs;
	$a_payment_transactions_grid->StopRec = $a_payment_transactions_grid->DisplayRecs;
} else {
	$bSelectLimit = $a_payment_transactions_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($a_payment_transactions_grid->TotalRecs <= 0)
			$a_payment_transactions_grid->TotalRecs = $a_payment_transactions->SelectRecordCount();
	} else {
		if (!$a_payment_transactions_grid->Recordset && ($a_payment_transactions_grid->Recordset = $a_payment_transactions_grid->LoadRecordset()))
			$a_payment_transactions_grid->TotalRecs = $a_payment_transactions_grid->Recordset->RecordCount();
	}
	$a_payment_transactions_grid->StartRec = 1;
	$a_payment_transactions_grid->DisplayRecs = $a_payment_transactions_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$a_payment_transactions_grid->Recordset = $a_payment_transactions_grid->LoadRecordset($a_payment_transactions_grid->StartRec-1, $a_payment_transactions_grid->DisplayRecs);

	// Set no record found message
	if ($a_payment_transactions->CurrentAction == "" && $a_payment_transactions_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$a_payment_transactions_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($a_payment_transactions_grid->SearchWhere == "0=101")
			$a_payment_transactions_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$a_payment_transactions_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$a_payment_transactions_grid->RenderOtherOptions();
?>
<?php $a_payment_transactions_grid->ShowPageHeader(); ?>
<?php
$a_payment_transactions_grid->ShowMessage();
?>
<?php if ($a_payment_transactions_grid->TotalRecs > 0 || $a_payment_transactions->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fa_payment_transactionsgrid" class="ewForm form-inline">
<?php if ($a_payment_transactions_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($a_payment_transactions_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_a_payment_transactions" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_a_payment_transactionsgrid" class="table ewTable">
<?php echo $a_payment_transactions->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$a_payment_transactions_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$a_payment_transactions_grid->RenderListOptions();

// Render list options (header, left)
$a_payment_transactions_grid->ListOptions->Render("header", "left");
?>
<?php if ($a_payment_transactions->Ref_ID->Visible) { // Ref_ID ?>
	<?php if ($a_payment_transactions->SortUrl($a_payment_transactions->Ref_ID) == "") { ?>
		<th data-name="Ref_ID"><div id="elh_a_payment_transactions_Ref_ID" class="a_payment_transactions_Ref_ID"><div class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Ref_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Ref_ID"><div><div id="elh_a_payment_transactions_Ref_ID" class="a_payment_transactions_Ref_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Ref_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_payment_transactions->Ref_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_payment_transactions->Ref_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_payment_transactions->Type->Visible) { // Type ?>
	<?php if ($a_payment_transactions->SortUrl($a_payment_transactions->Type) == "") { ?>
		<th data-name="Type"><div id="elh_a_payment_transactions_Type" class="a_payment_transactions_Type"><div class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Type"><div><div id="elh_a_payment_transactions_Type" class="a_payment_transactions_Type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_payment_transactions->Type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_payment_transactions->Type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_payment_transactions->Customer->Visible) { // Customer ?>
	<?php if ($a_payment_transactions->SortUrl($a_payment_transactions->Customer) == "") { ?>
		<th data-name="Customer"><div id="elh_a_payment_transactions_Customer" class="a_payment_transactions_Customer"><div class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Customer->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Customer"><div><div id="elh_a_payment_transactions_Customer" class="a_payment_transactions_Customer">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Customer->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_payment_transactions->Customer->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_payment_transactions->Customer->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_payment_transactions->Supplier->Visible) { // Supplier ?>
	<?php if ($a_payment_transactions->SortUrl($a_payment_transactions->Supplier) == "") { ?>
		<th data-name="Supplier"><div id="elh_a_payment_transactions_Supplier" class="a_payment_transactions_Supplier"><div class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Supplier->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Supplier"><div><div id="elh_a_payment_transactions_Supplier" class="a_payment_transactions_Supplier">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Supplier->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_payment_transactions->Supplier->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_payment_transactions->Supplier->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_payment_transactions->Sub_Total->Visible) { // Sub_Total ?>
	<?php if ($a_payment_transactions->SortUrl($a_payment_transactions->Sub_Total) == "") { ?>
		<th data-name="Sub_Total"><div id="elh_a_payment_transactions_Sub_Total" class="a_payment_transactions_Sub_Total"><div class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Sub_Total->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sub_Total"><div><div id="elh_a_payment_transactions_Sub_Total" class="a_payment_transactions_Sub_Total">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Sub_Total->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_payment_transactions->Sub_Total->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_payment_transactions->Sub_Total->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_payment_transactions->Payment->Visible) { // Payment ?>
	<?php if ($a_payment_transactions->SortUrl($a_payment_transactions->Payment) == "") { ?>
		<th data-name="Payment"><div id="elh_a_payment_transactions_Payment" class="a_payment_transactions_Payment"><div class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Payment->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Payment"><div><div id="elh_a_payment_transactions_Payment" class="a_payment_transactions_Payment">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Payment->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_payment_transactions->Payment->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_payment_transactions->Payment->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_payment_transactions->Balance->Visible) { // Balance ?>
	<?php if ($a_payment_transactions->SortUrl($a_payment_transactions->Balance) == "") { ?>
		<th data-name="Balance"><div id="elh_a_payment_transactions_Balance" class="a_payment_transactions_Balance"><div class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Balance->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Balance"><div><div id="elh_a_payment_transactions_Balance" class="a_payment_transactions_Balance">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Balance->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_payment_transactions->Balance->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_payment_transactions->Balance->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_payment_transactions->Due_Date->Visible) { // Due_Date ?>
	<?php if ($a_payment_transactions->SortUrl($a_payment_transactions->Due_Date) == "") { ?>
		<th data-name="Due_Date"><div id="elh_a_payment_transactions_Due_Date" class="a_payment_transactions_Due_Date"><div class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Due_Date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Due_Date"><div><div id="elh_a_payment_transactions_Due_Date" class="a_payment_transactions_Due_Date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Due_Date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_payment_transactions->Due_Date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_payment_transactions->Due_Date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_payment_transactions->Date_Transaction->Visible) { // Date_Transaction ?>
	<?php if ($a_payment_transactions->SortUrl($a_payment_transactions->Date_Transaction) == "") { ?>
		<th data-name="Date_Transaction"><div id="elh_a_payment_transactions_Date_Transaction" class="a_payment_transactions_Date_Transaction"><div class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Date_Transaction->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Date_Transaction"><div><div id="elh_a_payment_transactions_Date_Transaction" class="a_payment_transactions_Date_Transaction">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_payment_transactions->Date_Transaction->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_payment_transactions->Date_Transaction->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_payment_transactions->Date_Transaction->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$a_payment_transactions_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$a_payment_transactions_grid->StartRec = 1;
$a_payment_transactions_grid->StopRec = $a_payment_transactions_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($a_payment_transactions_grid->FormKeyCountName) && ($a_payment_transactions->CurrentAction == "gridadd" || $a_payment_transactions->CurrentAction == "gridedit" || $a_payment_transactions->CurrentAction == "F")) {
		$a_payment_transactions_grid->KeyCount = $objForm->GetValue($a_payment_transactions_grid->FormKeyCountName);
		$a_payment_transactions_grid->StopRec = $a_payment_transactions_grid->StartRec + $a_payment_transactions_grid->KeyCount - 1;
	}
}
$a_payment_transactions_grid->RecCnt = $a_payment_transactions_grid->StartRec - 1;
if ($a_payment_transactions_grid->Recordset && !$a_payment_transactions_grid->Recordset->EOF) {
	$a_payment_transactions_grid->Recordset->MoveFirst();
	$bSelectLimit = $a_payment_transactions_grid->UseSelectLimit;
	if (!$bSelectLimit && $a_payment_transactions_grid->StartRec > 1)
		$a_payment_transactions_grid->Recordset->Move($a_payment_transactions_grid->StartRec - 1);
} elseif (!$a_payment_transactions->AllowAddDeleteRow && $a_payment_transactions_grid->StopRec == 0) {
	$a_payment_transactions_grid->StopRec = $a_payment_transactions->GridAddRowCount;
}

// Initialize aggregate
$a_payment_transactions->RowType = EW_ROWTYPE_AGGREGATEINIT;
$a_payment_transactions->ResetAttrs();
$a_payment_transactions_grid->RenderRow();
if ($a_payment_transactions->CurrentAction == "gridadd")
	$a_payment_transactions_grid->RowIndex = 0;
if ($a_payment_transactions->CurrentAction == "gridedit")
	$a_payment_transactions_grid->RowIndex = 0;
while ($a_payment_transactions_grid->RecCnt < $a_payment_transactions_grid->StopRec) {
	$a_payment_transactions_grid->RecCnt++;
	if (intval($a_payment_transactions_grid->RecCnt) >= intval($a_payment_transactions_grid->StartRec)) {
		$a_payment_transactions_grid->RowCnt++;
		if ($a_payment_transactions->CurrentAction == "gridadd" || $a_payment_transactions->CurrentAction == "gridedit" || $a_payment_transactions->CurrentAction == "F") {
			$a_payment_transactions_grid->RowIndex++;
			$objForm->Index = $a_payment_transactions_grid->RowIndex;
			if ($objForm->HasValue($a_payment_transactions_grid->FormActionName))
				$a_payment_transactions_grid->RowAction = strval($objForm->GetValue($a_payment_transactions_grid->FormActionName));
			elseif ($a_payment_transactions->CurrentAction == "gridadd")
				$a_payment_transactions_grid->RowAction = "insert";
			else
				$a_payment_transactions_grid->RowAction = "";
		}

		// Set up key count
		$a_payment_transactions_grid->KeyCount = $a_payment_transactions_grid->RowIndex;

		// Init row class and style
		$a_payment_transactions->ResetAttrs();
		$a_payment_transactions->CssClass = "";
		if ($a_payment_transactions->CurrentAction == "gridadd") {
			if ($a_payment_transactions->CurrentMode == "copy") {
				$a_payment_transactions_grid->LoadRowValues($a_payment_transactions_grid->Recordset); // Load row values
				$a_payment_transactions_grid->SetRecordKey($a_payment_transactions_grid->RowOldKey, $a_payment_transactions_grid->Recordset); // Set old record key
			} else {
				$a_payment_transactions_grid->LoadDefaultValues(); // Load default values
				$a_payment_transactions_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$a_payment_transactions_grid->LoadRowValues($a_payment_transactions_grid->Recordset); // Load row values
		}
		$a_payment_transactions->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($a_payment_transactions->CurrentAction == "gridadd") // Grid add
			$a_payment_transactions->RowType = EW_ROWTYPE_ADD; // Render add
		if ($a_payment_transactions->CurrentAction == "gridadd" && $a_payment_transactions->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$a_payment_transactions_grid->RestoreCurrentRowFormValues($a_payment_transactions_grid->RowIndex); // Restore form values
		if ($a_payment_transactions->CurrentAction == "gridedit") { // Grid edit
			if ($a_payment_transactions->EventCancelled) {
				$a_payment_transactions_grid->RestoreCurrentRowFormValues($a_payment_transactions_grid->RowIndex); // Restore form values
			}
			if ($a_payment_transactions_grid->RowAction == "insert")
				$a_payment_transactions->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$a_payment_transactions->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($a_payment_transactions->CurrentAction == "gridedit" && ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT || $a_payment_transactions->RowType == EW_ROWTYPE_ADD) && $a_payment_transactions->EventCancelled) // Update failed
			$a_payment_transactions_grid->RestoreCurrentRowFormValues($a_payment_transactions_grid->RowIndex); // Restore form values
		if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) // Edit row
			$a_payment_transactions_grid->EditRowCnt++;
		if ($a_payment_transactions->CurrentAction == "F") // Confirm row
			$a_payment_transactions_grid->RestoreCurrentRowFormValues($a_payment_transactions_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$a_payment_transactions->RowAttrs = array_merge($a_payment_transactions->RowAttrs, array('data-rowindex'=>$a_payment_transactions_grid->RowCnt, 'id'=>'r' . $a_payment_transactions_grid->RowCnt . '_a_payment_transactions', 'data-rowtype'=>$a_payment_transactions->RowType));

		// Render row
		$a_payment_transactions_grid->RenderRow();

		// Render list options
		$a_payment_transactions_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($a_payment_transactions_grid->RowAction <> "delete" && $a_payment_transactions_grid->RowAction <> "insertdelete" && !($a_payment_transactions_grid->RowAction == "insert" && $a_payment_transactions->CurrentAction == "F" && $a_payment_transactions_grid->EmptyRow())) {
?>
	<tr<?php echo $a_payment_transactions->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_payment_transactions_grid->ListOptions->Render("body", "left", $a_payment_transactions_grid->RowCnt);
?>
	<?php if ($a_payment_transactions->Ref_ID->Visible) { // Ref_ID ?>
		<td data-name="Ref_ID"<?php echo $a_payment_transactions->Ref_ID->CellAttributes() ?>>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($a_payment_transactions->Ref_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Ref_ID" class="form-group a_payment_transactions_Ref_ID">
<span<?php echo $a_payment_transactions->Ref_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Ref_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Ref_ID" class="form-group a_payment_transactions_Ref_ID">
<input type="text" data-table="a_payment_transactions" data-field="x_Ref_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Ref_ID->EditValue ?>"<?php echo $a_payment_transactions->Ref_ID->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Ref_ID" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($a_payment_transactions->Ref_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Ref_ID" class="form-group a_payment_transactions_Ref_ID">
<span<?php echo $a_payment_transactions->Ref_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Ref_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Ref_ID" class="form-group a_payment_transactions_Ref_ID">
<input type="text" data-table="a_payment_transactions" data-field="x_Ref_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Ref_ID->EditValue ?>"<?php echo $a_payment_transactions->Ref_ID->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Ref_ID" class="a_payment_transactions_Ref_ID">
<span<?php echo $a_payment_transactions->Ref_ID->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Ref_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Ref_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->FormValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Ref_ID" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->OldValue) ?>">
<?php } ?>
<a id="<?php echo $a_payment_transactions_grid->PageObjName . "_row_" . $a_payment_transactions_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Payment_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment_ID" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Payment_ID->CurrentValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Payment_ID" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment_ID" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Payment_ID->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT || $a_payment_transactions->CurrentMode == "edit") { ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Payment_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment_ID" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Payment_ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($a_payment_transactions->Type->Visible) { // Type ?>
		<td data-name="Type"<?php echo $a_payment_transactions->Type->CellAttributes() ?>>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Type" class="form-group a_payment_transactions_Type">
<div id="tp_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" class="ewTemplate"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Type->DisplayValueSeparator) ? json_encode($a_payment_transactions->Type->DisplayValueSeparator) : $a_payment_transactions->Type->DisplayValueSeparator) ?>" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" value="{value}"<?php echo $a_payment_transactions->Type->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $a_payment_transactions->Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_payment_transactions->Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->CurrentValue) ?>" checked<?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $a_payment_transactions->Type->OldValue = "";
?>
</div></div>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Type" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Type" class="form-group a_payment_transactions_Type">
<div id="tp_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" class="ewTemplate"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Type->DisplayValueSeparator) ? json_encode($a_payment_transactions->Type->DisplayValueSeparator) : $a_payment_transactions->Type->DisplayValueSeparator) ?>" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" value="{value}"<?php echo $a_payment_transactions->Type->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $a_payment_transactions->Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_payment_transactions->Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->CurrentValue) ?>" checked<?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $a_payment_transactions->Type->OldValue = "";
?>
</div></div>
</span>
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Type" class="a_payment_transactions_Type">
<span<?php echo $a_payment_transactions->Type->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Type->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Type" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->FormValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Type" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Customer->Visible) { // Customer ?>
		<td data-name="Customer"<?php echo $a_payment_transactions->Customer->CellAttributes() ?>>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Customer" class="form-group a_payment_transactions_Customer">
<select data-table="a_payment_transactions" data-field="x_Customer" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Customer->DisplayValueSeparator) ? json_encode($a_payment_transactions->Customer->DisplayValueSeparator) : $a_payment_transactions->Customer->DisplayValueSeparator) ?>" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer"<?php echo $a_payment_transactions->Customer->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Customer->EditValue)) {
	$arwrk = $a_payment_transactions->Customer->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Customer->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_payment_transactions->Customer->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Customer->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_payment_transactions->Customer->CurrentValue) ?>" selected><?php echo $a_payment_transactions->Customer->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_payment_transactions->Customer->OldValue = "";
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
$a_payment_transactions->Customer->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_payment_transactions->Customer->LookupFilters += array("f0" => "`Customer_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_payment_transactions->Lookup_Selecting($a_payment_transactions->Customer, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_payment_transactions->Customer->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" id="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" value="<?php echo $a_payment_transactions->Customer->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Customer" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" value="<?php echo ew_HtmlEncode($a_payment_transactions->Customer->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Customer" class="form-group a_payment_transactions_Customer">
<select data-table="a_payment_transactions" data-field="x_Customer" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Customer->DisplayValueSeparator) ? json_encode($a_payment_transactions->Customer->DisplayValueSeparator) : $a_payment_transactions->Customer->DisplayValueSeparator) ?>" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer"<?php echo $a_payment_transactions->Customer->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Customer->EditValue)) {
	$arwrk = $a_payment_transactions->Customer->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Customer->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_payment_transactions->Customer->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Customer->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_payment_transactions->Customer->CurrentValue) ?>" selected><?php echo $a_payment_transactions->Customer->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_payment_transactions->Customer->OldValue = "";
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
$a_payment_transactions->Customer->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_payment_transactions->Customer->LookupFilters += array("f0" => "`Customer_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_payment_transactions->Lookup_Selecting($a_payment_transactions->Customer, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_payment_transactions->Customer->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" id="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" value="<?php echo $a_payment_transactions->Customer->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Customer" class="a_payment_transactions_Customer">
<span<?php echo $a_payment_transactions->Customer->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Customer->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Customer" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" value="<?php echo ew_HtmlEncode($a_payment_transactions->Customer->FormValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Customer" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" value="<?php echo ew_HtmlEncode($a_payment_transactions->Customer->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Supplier->Visible) { // Supplier ?>
		<td data-name="Supplier"<?php echo $a_payment_transactions->Supplier->CellAttributes() ?>>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Supplier" class="form-group a_payment_transactions_Supplier">
<select data-table="a_payment_transactions" data-field="x_Supplier" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Supplier->DisplayValueSeparator) ? json_encode($a_payment_transactions->Supplier->DisplayValueSeparator) : $a_payment_transactions->Supplier->DisplayValueSeparator) ?>" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier"<?php echo $a_payment_transactions->Supplier->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Supplier->EditValue)) {
	$arwrk = $a_payment_transactions->Supplier->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Supplier->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_payment_transactions->Supplier->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Supplier->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_payment_transactions->Supplier->CurrentValue) ?>" selected><?php echo $a_payment_transactions->Supplier->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_payment_transactions->Supplier->OldValue = "";
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
$a_payment_transactions->Supplier->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_payment_transactions->Supplier->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_payment_transactions->Lookup_Selecting($a_payment_transactions->Supplier, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_payment_transactions->Supplier->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" id="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" value="<?php echo $a_payment_transactions->Supplier->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Supplier" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" value="<?php echo ew_HtmlEncode($a_payment_transactions->Supplier->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Supplier" class="form-group a_payment_transactions_Supplier">
<select data-table="a_payment_transactions" data-field="x_Supplier" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Supplier->DisplayValueSeparator) ? json_encode($a_payment_transactions->Supplier->DisplayValueSeparator) : $a_payment_transactions->Supplier->DisplayValueSeparator) ?>" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier"<?php echo $a_payment_transactions->Supplier->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Supplier->EditValue)) {
	$arwrk = $a_payment_transactions->Supplier->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Supplier->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_payment_transactions->Supplier->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Supplier->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_payment_transactions->Supplier->CurrentValue) ?>" selected><?php echo $a_payment_transactions->Supplier->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_payment_transactions->Supplier->OldValue = "";
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
$a_payment_transactions->Supplier->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_payment_transactions->Supplier->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_payment_transactions->Lookup_Selecting($a_payment_transactions->Supplier, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_payment_transactions->Supplier->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" id="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" value="<?php echo $a_payment_transactions->Supplier->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Supplier" class="a_payment_transactions_Supplier">
<span<?php echo $a_payment_transactions->Supplier->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Supplier->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Supplier" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" value="<?php echo ew_HtmlEncode($a_payment_transactions->Supplier->FormValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Supplier" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" value="<?php echo ew_HtmlEncode($a_payment_transactions->Supplier->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Sub_Total->Visible) { // Sub_Total ?>
		<td data-name="Sub_Total"<?php echo $a_payment_transactions->Sub_Total->CellAttributes() ?>>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Sub_Total" class="form-group a_payment_transactions_Sub_Total">
<input type="text" data-table="a_payment_transactions" data-field="x_Sub_Total" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Sub_Total->EditValue ?>"<?php echo $a_payment_transactions->Sub_Total->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Sub_Total->ReadOnly && !$a_payment_transactions->Sub_Total->Disabled && @$a_payment_transactions->Sub_Total->EditAttrs["readonly"] == "" && @$a_payment_transactions->Sub_Total->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Sub_Total" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" value="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Sub_Total" class="form-group a_payment_transactions_Sub_Total">
<input type="text" data-table="a_payment_transactions" data-field="x_Sub_Total" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Sub_Total->EditValue ?>"<?php echo $a_payment_transactions->Sub_Total->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Sub_Total->ReadOnly && !$a_payment_transactions->Sub_Total->Disabled && @$a_payment_transactions->Sub_Total->EditAttrs["readonly"] == "" && @$a_payment_transactions->Sub_Total->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Sub_Total" class="a_payment_transactions_Sub_Total">
<span<?php echo $a_payment_transactions->Sub_Total->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Sub_Total->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Sub_Total" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" value="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->FormValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Sub_Total" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" value="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Payment->Visible) { // Payment ?>
		<td data-name="Payment"<?php echo $a_payment_transactions->Payment->CellAttributes() ?>>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Payment" class="form-group a_payment_transactions_Payment">
<input type="text" data-table="a_payment_transactions" data-field="x_Payment" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Payment->EditValue ?>"<?php echo $a_payment_transactions->Payment->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Payment->ReadOnly && !$a_payment_transactions->Payment->Disabled && @$a_payment_transactions->Payment->EditAttrs["readonly"] == "" && @$a_payment_transactions->Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Payment" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" value="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Payment" class="form-group a_payment_transactions_Payment">
<input type="text" data-table="a_payment_transactions" data-field="x_Payment" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Payment->EditValue ?>"<?php echo $a_payment_transactions->Payment->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Payment->ReadOnly && !$a_payment_transactions->Payment->Disabled && @$a_payment_transactions->Payment->EditAttrs["readonly"] == "" && @$a_payment_transactions->Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Payment" class="a_payment_transactions_Payment">
<span<?php echo $a_payment_transactions->Payment->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Payment->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Payment" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" value="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->FormValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Payment" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" value="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Balance->Visible) { // Balance ?>
		<td data-name="Balance"<?php echo $a_payment_transactions->Balance->CellAttributes() ?>>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Balance" class="form-group a_payment_transactions_Balance">
<input type="text" data-table="a_payment_transactions" data-field="x_Balance" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Balance->EditValue ?>"<?php echo $a_payment_transactions->Balance->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Balance->ReadOnly && !$a_payment_transactions->Balance->Disabled && @$a_payment_transactions->Balance->EditAttrs["readonly"] == "" && @$a_payment_transactions->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Balance" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" value="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Balance" class="form-group a_payment_transactions_Balance">
<input type="text" data-table="a_payment_transactions" data-field="x_Balance" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Balance->EditValue ?>"<?php echo $a_payment_transactions->Balance->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Balance->ReadOnly && !$a_payment_transactions->Balance->Disabled && @$a_payment_transactions->Balance->EditAttrs["readonly"] == "" && @$a_payment_transactions->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Balance" class="a_payment_transactions_Balance">
<span<?php echo $a_payment_transactions->Balance->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Balance->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Balance" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" value="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->FormValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Balance" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" value="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Due_Date->Visible) { // Due_Date ?>
		<td data-name="Due_Date"<?php echo $a_payment_transactions->Due_Date->CellAttributes() ?>>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Due_Date" class="form-group a_payment_transactions_Due_Date">
<input type="text" data-table="a_payment_transactions" data-field="x_Due_Date" data-format="5" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Due_Date->EditValue ?>"<?php echo $a_payment_transactions->Due_Date->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Due_Date->ReadOnly && !$a_payment_transactions->Due_Date->Disabled && !isset($a_payment_transactions->Due_Date->EditAttrs["readonly"]) && !isset($a_payment_transactions->Due_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionsgrid", "x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Due_Date" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" value="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Due_Date" class="form-group a_payment_transactions_Due_Date">
<input type="text" data-table="a_payment_transactions" data-field="x_Due_Date" data-format="5" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Due_Date->EditValue ?>"<?php echo $a_payment_transactions->Due_Date->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Due_Date->ReadOnly && !$a_payment_transactions->Due_Date->Disabled && !isset($a_payment_transactions->Due_Date->EditAttrs["readonly"]) && !isset($a_payment_transactions->Due_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionsgrid", "x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Due_Date" class="a_payment_transactions_Due_Date">
<span<?php echo $a_payment_transactions->Due_Date->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Due_Date->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Due_Date" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" value="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->FormValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Due_Date" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" value="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Date_Transaction->Visible) { // Date_Transaction ?>
		<td data-name="Date_Transaction"<?php echo $a_payment_transactions->Date_Transaction->CellAttributes() ?>>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Date_Transaction" class="form-group a_payment_transactions_Date_Transaction">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Transaction" data-format="5" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Transaction->EditValue ?>"<?php echo $a_payment_transactions->Date_Transaction->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Date_Transaction->ReadOnly && !$a_payment_transactions->Date_Transaction->Disabled && !isset($a_payment_transactions->Date_Transaction->EditAttrs["readonly"]) && !isset($a_payment_transactions->Date_Transaction->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionsgrid", "x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Date_Transaction" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" value="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->OldValue) ?>">
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Date_Transaction" class="form-group a_payment_transactions_Date_Transaction">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Transaction" data-format="5" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Transaction->EditValue ?>"<?php echo $a_payment_transactions->Date_Transaction->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Date_Transaction->ReadOnly && !$a_payment_transactions->Date_Transaction->Disabled && !isset($a_payment_transactions->Date_Transaction->EditAttrs["readonly"]) && !isset($a_payment_transactions->Date_Transaction->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionsgrid", "x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_payment_transactions_grid->RowCnt ?>_a_payment_transactions_Date_Transaction" class="a_payment_transactions_Date_Transaction">
<span<?php echo $a_payment_transactions->Date_Transaction->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Date_Transaction->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Date_Transaction" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" value="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->FormValue) ?>">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Date_Transaction" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" value="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_payment_transactions_grid->ListOptions->Render("body", "right", $a_payment_transactions_grid->RowCnt);
?>
	</tr>
<?php if ($a_payment_transactions->RowType == EW_ROWTYPE_ADD || $a_payment_transactions->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fa_payment_transactionsgrid.UpdateOpts(<?php echo $a_payment_transactions_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($a_payment_transactions->CurrentAction <> "gridadd" || $a_payment_transactions->CurrentMode == "copy")
		if (!$a_payment_transactions_grid->Recordset->EOF) $a_payment_transactions_grid->Recordset->MoveNext();
}
?>
<?php
	if ($a_payment_transactions->CurrentMode == "add" || $a_payment_transactions->CurrentMode == "copy" || $a_payment_transactions->CurrentMode == "edit") {
		$a_payment_transactions_grid->RowIndex = '$rowindex$';
		$a_payment_transactions_grid->LoadDefaultValues();

		// Set row properties
		$a_payment_transactions->ResetAttrs();
		$a_payment_transactions->RowAttrs = array_merge($a_payment_transactions->RowAttrs, array('data-rowindex'=>$a_payment_transactions_grid->RowIndex, 'id'=>'r0_a_payment_transactions', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($a_payment_transactions->RowAttrs["class"], "ewTemplate");
		$a_payment_transactions->RowType = EW_ROWTYPE_ADD;

		// Render row
		$a_payment_transactions_grid->RenderRow();

		// Render list options
		$a_payment_transactions_grid->RenderListOptions();
		$a_payment_transactions_grid->StartRowCnt = 0;
?>
	<tr<?php echo $a_payment_transactions->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_payment_transactions_grid->ListOptions->Render("body", "left", $a_payment_transactions_grid->RowIndex);
?>
	<?php if ($a_payment_transactions->Ref_ID->Visible) { // Ref_ID ?>
		<td data-name="Ref_ID">
<?php if ($a_payment_transactions->CurrentAction <> "F") { ?>
<?php if ($a_payment_transactions->Ref_ID->getSessionValue() <> "") { ?>
<span id="el$rowindex$_a_payment_transactions_Ref_ID" class="form-group a_payment_transactions_Ref_ID">
<span<?php echo $a_payment_transactions->Ref_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Ref_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Ref_ID" class="form-group a_payment_transactions_Ref_ID">
<input type="text" data-table="a_payment_transactions" data-field="x_Ref_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Ref_ID->EditValue ?>"<?php echo $a_payment_transactions->Ref_ID->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Ref_ID" class="form-group a_payment_transactions_Ref_ID">
<span<?php echo $a_payment_transactions->Ref_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Ref_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Ref_ID" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Ref_ID" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Ref_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Type->Visible) { // Type ?>
		<td data-name="Type">
<?php if ($a_payment_transactions->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_payment_transactions_Type" class="form-group a_payment_transactions_Type">
<div id="tp_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" class="ewTemplate"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Type->DisplayValueSeparator) ? json_encode($a_payment_transactions->Type->DisplayValueSeparator) : $a_payment_transactions->Type->DisplayValueSeparator) ?>" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" value="{value}"<?php echo $a_payment_transactions->Type->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $a_payment_transactions->Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_payment_transactions->Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->CurrentValue) ?>" checked<?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $a_payment_transactions->Type->OldValue = "";
?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Type" class="form-group a_payment_transactions_Type">
<span<?php echo $a_payment_transactions->Type->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Type->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Type" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Type" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Type" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Customer->Visible) { // Customer ?>
		<td data-name="Customer">
<?php if ($a_payment_transactions->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_payment_transactions_Customer" class="form-group a_payment_transactions_Customer">
<select data-table="a_payment_transactions" data-field="x_Customer" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Customer->DisplayValueSeparator) ? json_encode($a_payment_transactions->Customer->DisplayValueSeparator) : $a_payment_transactions->Customer->DisplayValueSeparator) ?>" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer"<?php echo $a_payment_transactions->Customer->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Customer->EditValue)) {
	$arwrk = $a_payment_transactions->Customer->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Customer->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_payment_transactions->Customer->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Customer->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_payment_transactions->Customer->CurrentValue) ?>" selected><?php echo $a_payment_transactions->Customer->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_payment_transactions->Customer->OldValue = "";
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
$a_payment_transactions->Customer->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_payment_transactions->Customer->LookupFilters += array("f0" => "`Customer_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_payment_transactions->Lookup_Selecting($a_payment_transactions->Customer, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_payment_transactions->Customer->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" id="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" value="<?php echo $a_payment_transactions->Customer->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Customer" class="form-group a_payment_transactions_Customer">
<span<?php echo $a_payment_transactions->Customer->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Customer->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Customer" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" value="<?php echo ew_HtmlEncode($a_payment_transactions->Customer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Customer" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Customer" value="<?php echo ew_HtmlEncode($a_payment_transactions->Customer->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Supplier->Visible) { // Supplier ?>
		<td data-name="Supplier">
<?php if ($a_payment_transactions->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_payment_transactions_Supplier" class="form-group a_payment_transactions_Supplier">
<select data-table="a_payment_transactions" data-field="x_Supplier" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Supplier->DisplayValueSeparator) ? json_encode($a_payment_transactions->Supplier->DisplayValueSeparator) : $a_payment_transactions->Supplier->DisplayValueSeparator) ?>" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier"<?php echo $a_payment_transactions->Supplier->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Supplier->EditValue)) {
	$arwrk = $a_payment_transactions->Supplier->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Supplier->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_payment_transactions->Supplier->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Supplier->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_payment_transactions->Supplier->CurrentValue) ?>" selected><?php echo $a_payment_transactions->Supplier->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_payment_transactions->Supplier->OldValue = "";
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
$a_payment_transactions->Supplier->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_payment_transactions->Supplier->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_payment_transactions->Lookup_Selecting($a_payment_transactions->Supplier, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_payment_transactions->Supplier->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" id="s_x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" value="<?php echo $a_payment_transactions->Supplier->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Supplier" class="form-group a_payment_transactions_Supplier">
<span<?php echo $a_payment_transactions->Supplier->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Supplier->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Supplier" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" value="<?php echo ew_HtmlEncode($a_payment_transactions->Supplier->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Supplier" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Supplier" value="<?php echo ew_HtmlEncode($a_payment_transactions->Supplier->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Sub_Total->Visible) { // Sub_Total ?>
		<td data-name="Sub_Total">
<?php if ($a_payment_transactions->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_payment_transactions_Sub_Total" class="form-group a_payment_transactions_Sub_Total">
<input type="text" data-table="a_payment_transactions" data-field="x_Sub_Total" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Sub_Total->EditValue ?>"<?php echo $a_payment_transactions->Sub_Total->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Sub_Total->ReadOnly && !$a_payment_transactions->Sub_Total->Disabled && @$a_payment_transactions->Sub_Total->EditAttrs["readonly"] == "" && @$a_payment_transactions->Sub_Total->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Sub_Total" class="form-group a_payment_transactions_Sub_Total">
<span<?php echo $a_payment_transactions->Sub_Total->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Sub_Total->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Sub_Total" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" value="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Sub_Total" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Sub_Total" value="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Payment->Visible) { // Payment ?>
		<td data-name="Payment">
<?php if ($a_payment_transactions->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_payment_transactions_Payment" class="form-group a_payment_transactions_Payment">
<input type="text" data-table="a_payment_transactions" data-field="x_Payment" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Payment->EditValue ?>"<?php echo $a_payment_transactions->Payment->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Payment->ReadOnly && !$a_payment_transactions->Payment->Disabled && @$a_payment_transactions->Payment->EditAttrs["readonly"] == "" && @$a_payment_transactions->Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Payment" class="form-group a_payment_transactions_Payment">
<span<?php echo $a_payment_transactions->Payment->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Payment->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Payment" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" value="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Payment" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Payment" value="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Balance->Visible) { // Balance ?>
		<td data-name="Balance">
<?php if ($a_payment_transactions->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_payment_transactions_Balance" class="form-group a_payment_transactions_Balance">
<input type="text" data-table="a_payment_transactions" data-field="x_Balance" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Balance->EditValue ?>"<?php echo $a_payment_transactions->Balance->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Balance->ReadOnly && !$a_payment_transactions->Balance->Disabled && @$a_payment_transactions->Balance->EditAttrs["readonly"] == "" && @$a_payment_transactions->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Balance" class="form-group a_payment_transactions_Balance">
<span<?php echo $a_payment_transactions->Balance->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Balance->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Balance" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" value="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Balance" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Balance" value="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Due_Date->Visible) { // Due_Date ?>
		<td data-name="Due_Date">
<?php if ($a_payment_transactions->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_payment_transactions_Due_Date" class="form-group a_payment_transactions_Due_Date">
<input type="text" data-table="a_payment_transactions" data-field="x_Due_Date" data-format="5" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Due_Date->EditValue ?>"<?php echo $a_payment_transactions->Due_Date->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Due_Date->ReadOnly && !$a_payment_transactions->Due_Date->Disabled && !isset($a_payment_transactions->Due_Date->EditAttrs["readonly"]) && !isset($a_payment_transactions->Due_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionsgrid", "x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Due_Date" class="form-group a_payment_transactions_Due_Date">
<span<?php echo $a_payment_transactions->Due_Date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Due_Date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Due_Date" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" value="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Due_Date" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Due_Date" value="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_payment_transactions->Date_Transaction->Visible) { // Date_Transaction ?>
		<td data-name="Date_Transaction">
<?php if ($a_payment_transactions->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_payment_transactions_Date_Transaction" class="form-group a_payment_transactions_Date_Transaction">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Transaction" data-format="5" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Transaction->EditValue ?>"<?php echo $a_payment_transactions->Date_Transaction->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Date_Transaction->ReadOnly && !$a_payment_transactions->Date_Transaction->Disabled && !isset($a_payment_transactions->Date_Transaction->EditAttrs["readonly"]) && !isset($a_payment_transactions->Date_Transaction->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionsgrid", "x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_payment_transactions_Date_Transaction" class="form-group a_payment_transactions_Date_Transaction">
<span<?php echo $a_payment_transactions->Date_Transaction->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Date_Transaction->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Date_Transaction" name="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" id="x<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" value="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_payment_transactions" data-field="x_Date_Transaction" name="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" id="o<?php echo $a_payment_transactions_grid->RowIndex ?>_Date_Transaction" value="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_payment_transactions_grid->ListOptions->Render("body", "right", $a_payment_transactions_grid->RowCnt);
?>
<script type="text/javascript">
fa_payment_transactionsgrid.UpdateOpts(<?php echo $a_payment_transactions_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($a_payment_transactions->CurrentMode == "add" || $a_payment_transactions->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $a_payment_transactions_grid->FormKeyCountName ?>" id="<?php echo $a_payment_transactions_grid->FormKeyCountName ?>" value="<?php echo $a_payment_transactions_grid->KeyCount ?>">
<?php echo $a_payment_transactions_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_payment_transactions->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $a_payment_transactions_grid->FormKeyCountName ?>" id="<?php echo $a_payment_transactions_grid->FormKeyCountName ?>" value="<?php echo $a_payment_transactions_grid->KeyCount ?>">
<?php echo $a_payment_transactions_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_payment_transactions->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fa_payment_transactionsgrid">
</div>
<?php

// Close recordset
if ($a_payment_transactions_grid->Recordset)
	$a_payment_transactions_grid->Recordset->Close();
?>
<?php if ($a_payment_transactions_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($a_payment_transactions_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($a_payment_transactions_grid->TotalRecs == 0 && $a_payment_transactions->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($a_payment_transactions_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($a_payment_transactions->Export == "") { ?>
<script type="text/javascript">
fa_payment_transactionsgrid.Init();
</script>
<?php } ?>
<?php
$a_payment_transactions_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$a_payment_transactions_grid->Page_Terminate();
?>
