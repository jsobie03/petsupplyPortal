<?php include_once "usersinfo.php" ?>
<?php

// Create page object
if (!isset($a_stock_items_grid)) $a_stock_items_grid = new ca_stock_items_grid();

// Page init
$a_stock_items_grid->Page_Init();

// Page main
$a_stock_items_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$a_stock_items_grid->Page_Render();
?>
<?php if ($a_stock_items->Export == "") { ?>
<script type="text/javascript">

// Form object
var fa_stock_itemsgrid = new ew_Form("fa_stock_itemsgrid", "grid");
fa_stock_itemsgrid.FormKeyCountName = '<?php echo $a_stock_items_grid->FormKeyCountName ?>';

// Validate form
fa_stock_itemsgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Supplier_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Supplier_Number->FldCaption(), $a_stock_items->Supplier_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Stock_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Stock_Number->FldCaption(), $a_stock_items->Stock_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Stock_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Stock_Name->FldCaption(), $a_stock_items->Stock_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Purchasing_Price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Purchasing_Price->FldCaption(), $a_stock_items->Purchasing_Price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Selling_Price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Selling_Price->FldCaption(), $a_stock_items->Selling_Price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Quantity");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Quantity->FldCaption(), $a_stock_items->Quantity->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fa_stock_itemsgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Supplier_Number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Stock_Number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Stock_Name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Purchasing_Price", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Selling_Price", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Quantity", false)) return false;
	return true;
}

// Form_CustomValidate event
fa_stock_itemsgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_stock_itemsgrid.ValidateRequired = true;
<?php } else { ?>
fa_stock_itemsgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_stock_itemsgrid.Lists["x_Supplier_Number"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($a_stock_items->CurrentAction == "gridadd") {
	if ($a_stock_items->CurrentMode == "copy") {
		$bSelectLimit = $a_stock_items_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$a_stock_items_grid->TotalRecs = $a_stock_items->SelectRecordCount();
			$a_stock_items_grid->Recordset = $a_stock_items_grid->LoadRecordset($a_stock_items_grid->StartRec-1, $a_stock_items_grid->DisplayRecs);
		} else {
			if ($a_stock_items_grid->Recordset = $a_stock_items_grid->LoadRecordset())
				$a_stock_items_grid->TotalRecs = $a_stock_items_grid->Recordset->RecordCount();
		}
		$a_stock_items_grid->StartRec = 1;
		$a_stock_items_grid->DisplayRecs = $a_stock_items_grid->TotalRecs;
	} else {
		$a_stock_items->CurrentFilter = "0=1";
		$a_stock_items_grid->StartRec = 1;
		$a_stock_items_grid->DisplayRecs = $a_stock_items->GridAddRowCount;
	}
	$a_stock_items_grid->TotalRecs = $a_stock_items_grid->DisplayRecs;
	$a_stock_items_grid->StopRec = $a_stock_items_grid->DisplayRecs;
} else {
	$bSelectLimit = $a_stock_items_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($a_stock_items_grid->TotalRecs <= 0)
			$a_stock_items_grid->TotalRecs = $a_stock_items->SelectRecordCount();
	} else {
		if (!$a_stock_items_grid->Recordset && ($a_stock_items_grid->Recordset = $a_stock_items_grid->LoadRecordset()))
			$a_stock_items_grid->TotalRecs = $a_stock_items_grid->Recordset->RecordCount();
	}
	$a_stock_items_grid->StartRec = 1;
	$a_stock_items_grid->DisplayRecs = $a_stock_items_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$a_stock_items_grid->Recordset = $a_stock_items_grid->LoadRecordset($a_stock_items_grid->StartRec-1, $a_stock_items_grid->DisplayRecs);

	// Set no record found message
	if ($a_stock_items->CurrentAction == "" && $a_stock_items_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$a_stock_items_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($a_stock_items_grid->SearchWhere == "0=101")
			$a_stock_items_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$a_stock_items_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$a_stock_items_grid->RenderOtherOptions();
?>
<?php $a_stock_items_grid->ShowPageHeader(); ?>
<?php
$a_stock_items_grid->ShowMessage();
?>
<?php if ($a_stock_items_grid->TotalRecs > 0 || $a_stock_items->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fa_stock_itemsgrid" class="ewForm form-inline">
<?php if ($a_stock_items_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($a_stock_items_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_a_stock_items" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_a_stock_itemsgrid" class="table ewTable">
<?php echo $a_stock_items->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$a_stock_items_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$a_stock_items_grid->RenderListOptions();

// Render list options (header, left)
$a_stock_items_grid->ListOptions->Render("header", "left");
?>
<?php if ($a_stock_items->Supplier_Number->Visible) { // Supplier_Number ?>
	<?php if ($a_stock_items->SortUrl($a_stock_items->Supplier_Number) == "") { ?>
		<th data-name="Supplier_Number"><div id="elh_a_stock_items_Supplier_Number" class="a_stock_items_Supplier_Number"><div class="ewTableHeaderCaption"><?php echo $a_stock_items->Supplier_Number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Supplier_Number"><div><div id="elh_a_stock_items_Supplier_Number" class="a_stock_items_Supplier_Number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_stock_items->Supplier_Number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_stock_items->Supplier_Number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_stock_items->Supplier_Number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_stock_items->Stock_Number->Visible) { // Stock_Number ?>
	<?php if ($a_stock_items->SortUrl($a_stock_items->Stock_Number) == "") { ?>
		<th data-name="Stock_Number"><div id="elh_a_stock_items_Stock_Number" class="a_stock_items_Stock_Number"><div class="ewTableHeaderCaption"><?php echo $a_stock_items->Stock_Number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Stock_Number"><div><div id="elh_a_stock_items_Stock_Number" class="a_stock_items_Stock_Number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_stock_items->Stock_Number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_stock_items->Stock_Number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_stock_items->Stock_Number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_stock_items->Stock_Name->Visible) { // Stock_Name ?>
	<?php if ($a_stock_items->SortUrl($a_stock_items->Stock_Name) == "") { ?>
		<th data-name="Stock_Name"><div id="elh_a_stock_items_Stock_Name" class="a_stock_items_Stock_Name"><div class="ewTableHeaderCaption"><?php echo $a_stock_items->Stock_Name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Stock_Name"><div><div id="elh_a_stock_items_Stock_Name" class="a_stock_items_Stock_Name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_stock_items->Stock_Name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_stock_items->Stock_Name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_stock_items->Stock_Name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_stock_items->Purchasing_Price->Visible) { // Purchasing_Price ?>
	<?php if ($a_stock_items->SortUrl($a_stock_items->Purchasing_Price) == "") { ?>
		<th data-name="Purchasing_Price"><div id="elh_a_stock_items_Purchasing_Price" class="a_stock_items_Purchasing_Price"><div class="ewTableHeaderCaption"><?php echo $a_stock_items->Purchasing_Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Purchasing_Price"><div><div id="elh_a_stock_items_Purchasing_Price" class="a_stock_items_Purchasing_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_stock_items->Purchasing_Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_stock_items->Purchasing_Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_stock_items->Purchasing_Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_stock_items->Selling_Price->Visible) { // Selling_Price ?>
	<?php if ($a_stock_items->SortUrl($a_stock_items->Selling_Price) == "") { ?>
		<th data-name="Selling_Price"><div id="elh_a_stock_items_Selling_Price" class="a_stock_items_Selling_Price"><div class="ewTableHeaderCaption"><?php echo $a_stock_items->Selling_Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Selling_Price"><div><div id="elh_a_stock_items_Selling_Price" class="a_stock_items_Selling_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_stock_items->Selling_Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_stock_items->Selling_Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_stock_items->Selling_Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_stock_items->Quantity->Visible) { // Quantity ?>
	<?php if ($a_stock_items->SortUrl($a_stock_items->Quantity) == "") { ?>
		<th data-name="Quantity"><div id="elh_a_stock_items_Quantity" class="a_stock_items_Quantity"><div class="ewTableHeaderCaption"><?php echo $a_stock_items->Quantity->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Quantity"><div><div id="elh_a_stock_items_Quantity" class="a_stock_items_Quantity">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_stock_items->Quantity->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_stock_items->Quantity->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_stock_items->Quantity->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$a_stock_items_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$a_stock_items_grid->StartRec = 1;
$a_stock_items_grid->StopRec = $a_stock_items_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($a_stock_items_grid->FormKeyCountName) && ($a_stock_items->CurrentAction == "gridadd" || $a_stock_items->CurrentAction == "gridedit" || $a_stock_items->CurrentAction == "F")) {
		$a_stock_items_grid->KeyCount = $objForm->GetValue($a_stock_items_grid->FormKeyCountName);
		$a_stock_items_grid->StopRec = $a_stock_items_grid->StartRec + $a_stock_items_grid->KeyCount - 1;
	}
}
$a_stock_items_grid->RecCnt = $a_stock_items_grid->StartRec - 1;
if ($a_stock_items_grid->Recordset && !$a_stock_items_grid->Recordset->EOF) {
	$a_stock_items_grid->Recordset->MoveFirst();
	$bSelectLimit = $a_stock_items_grid->UseSelectLimit;
	if (!$bSelectLimit && $a_stock_items_grid->StartRec > 1)
		$a_stock_items_grid->Recordset->Move($a_stock_items_grid->StartRec - 1);
} elseif (!$a_stock_items->AllowAddDeleteRow && $a_stock_items_grid->StopRec == 0) {
	$a_stock_items_grid->StopRec = $a_stock_items->GridAddRowCount;
}

// Initialize aggregate
$a_stock_items->RowType = EW_ROWTYPE_AGGREGATEINIT;
$a_stock_items->ResetAttrs();
$a_stock_items_grid->RenderRow();
if ($a_stock_items->CurrentAction == "gridadd")
	$a_stock_items_grid->RowIndex = 0;
if ($a_stock_items->CurrentAction == "gridedit")
	$a_stock_items_grid->RowIndex = 0;
while ($a_stock_items_grid->RecCnt < $a_stock_items_grid->StopRec) {
	$a_stock_items_grid->RecCnt++;
	if (intval($a_stock_items_grid->RecCnt) >= intval($a_stock_items_grid->StartRec)) {
		$a_stock_items_grid->RowCnt++;
		if ($a_stock_items->CurrentAction == "gridadd" || $a_stock_items->CurrentAction == "gridedit" || $a_stock_items->CurrentAction == "F") {
			$a_stock_items_grid->RowIndex++;
			$objForm->Index = $a_stock_items_grid->RowIndex;
			if ($objForm->HasValue($a_stock_items_grid->FormActionName))
				$a_stock_items_grid->RowAction = strval($objForm->GetValue($a_stock_items_grid->FormActionName));
			elseif ($a_stock_items->CurrentAction == "gridadd")
				$a_stock_items_grid->RowAction = "insert";
			else
				$a_stock_items_grid->RowAction = "";
		}

		// Set up key count
		$a_stock_items_grid->KeyCount = $a_stock_items_grid->RowIndex;

		// Init row class and style
		$a_stock_items->ResetAttrs();
		$a_stock_items->CssClass = "";
		if ($a_stock_items->CurrentAction == "gridadd") {
			if ($a_stock_items->CurrentMode == "copy") {
				$a_stock_items_grid->LoadRowValues($a_stock_items_grid->Recordset); // Load row values
				$a_stock_items_grid->SetRecordKey($a_stock_items_grid->RowOldKey, $a_stock_items_grid->Recordset); // Set old record key
			} else {
				$a_stock_items_grid->LoadDefaultValues(); // Load default values
				$a_stock_items_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$a_stock_items_grid->LoadRowValues($a_stock_items_grid->Recordset); // Load row values
		}
		$a_stock_items->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($a_stock_items->CurrentAction == "gridadd") // Grid add
			$a_stock_items->RowType = EW_ROWTYPE_ADD; // Render add
		if ($a_stock_items->CurrentAction == "gridadd" && $a_stock_items->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$a_stock_items_grid->RestoreCurrentRowFormValues($a_stock_items_grid->RowIndex); // Restore form values
		if ($a_stock_items->CurrentAction == "gridedit") { // Grid edit
			if ($a_stock_items->EventCancelled) {
				$a_stock_items_grid->RestoreCurrentRowFormValues($a_stock_items_grid->RowIndex); // Restore form values
			}
			if ($a_stock_items_grid->RowAction == "insert")
				$a_stock_items->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$a_stock_items->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($a_stock_items->CurrentAction == "gridedit" && ($a_stock_items->RowType == EW_ROWTYPE_EDIT || $a_stock_items->RowType == EW_ROWTYPE_ADD) && $a_stock_items->EventCancelled) // Update failed
			$a_stock_items_grid->RestoreCurrentRowFormValues($a_stock_items_grid->RowIndex); // Restore form values
		if ($a_stock_items->RowType == EW_ROWTYPE_EDIT) // Edit row
			$a_stock_items_grid->EditRowCnt++;
		if ($a_stock_items->CurrentAction == "F") // Confirm row
			$a_stock_items_grid->RestoreCurrentRowFormValues($a_stock_items_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$a_stock_items->RowAttrs = array_merge($a_stock_items->RowAttrs, array('data-rowindex'=>$a_stock_items_grid->RowCnt, 'id'=>'r' . $a_stock_items_grid->RowCnt . '_a_stock_items', 'data-rowtype'=>$a_stock_items->RowType));

		// Render row
		$a_stock_items_grid->RenderRow();

		// Render list options
		$a_stock_items_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($a_stock_items_grid->RowAction <> "delete" && $a_stock_items_grid->RowAction <> "insertdelete" && !($a_stock_items_grid->RowAction == "insert" && $a_stock_items->CurrentAction == "F" && $a_stock_items_grid->EmptyRow())) {
?>
	<tr<?php echo $a_stock_items->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_stock_items_grid->ListOptions->Render("body", "left", $a_stock_items_grid->RowCnt);
?>
	<?php if ($a_stock_items->Supplier_Number->Visible) { // Supplier_Number ?>
		<td data-name="Supplier_Number"<?php echo $a_stock_items->Supplier_Number->CellAttributes() ?>>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($a_stock_items->Supplier_Number->getSessionValue() <> "") { ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Supplier_Number" class="form-group a_stock_items_Supplier_Number">
<span<?php echo $a_stock_items->Supplier_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Supplier_Number->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Supplier_Number" class="form-group a_stock_items_Supplier_Number">
<select data-table="a_stock_items" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Supplier_Number->DisplayValueSeparator) ? json_encode($a_stock_items->Supplier_Number->DisplayValueSeparator) : $a_stock_items->Supplier_Number->DisplayValueSeparator) ?>" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number"<?php echo $a_stock_items->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Supplier_Number->EditValue)) {
	$arwrk = $a_stock_items->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Supplier_Number->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_stock_items->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_stock_items->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->CurrentValue) ?>" selected><?php echo $a_stock_items->Supplier_Number->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_stock_items->Supplier_Number->OldValue = "";
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
$a_stock_items->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_stock_items->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_stock_items->Lookup_Selecting($a_stock_items->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Supplier_Name`";
if ($sSqlWrk <> "") $a_stock_items->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" id="s_x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo $a_stock_items->Supplier_Number->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="a_stock_items" data-field="x_Supplier_Number" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->OldValue) ?>">
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($a_stock_items->Supplier_Number->getSessionValue() <> "") { ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Supplier_Number" class="form-group a_stock_items_Supplier_Number">
<span<?php echo $a_stock_items->Supplier_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Supplier_Number->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Supplier_Number" class="form-group a_stock_items_Supplier_Number">
<select data-table="a_stock_items" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Supplier_Number->DisplayValueSeparator) ? json_encode($a_stock_items->Supplier_Number->DisplayValueSeparator) : $a_stock_items->Supplier_Number->DisplayValueSeparator) ?>" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number"<?php echo $a_stock_items->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Supplier_Number->EditValue)) {
	$arwrk = $a_stock_items->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Supplier_Number->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_stock_items->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_stock_items->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->CurrentValue) ?>" selected><?php echo $a_stock_items->Supplier_Number->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_stock_items->Supplier_Number->OldValue = "";
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
$a_stock_items->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_stock_items->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_stock_items->Lookup_Selecting($a_stock_items->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Supplier_Name`";
if ($sSqlWrk <> "") $a_stock_items->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" id="s_x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo $a_stock_items->Supplier_Number->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Supplier_Number" class="a_stock_items_Supplier_Number">
<span<?php echo $a_stock_items->Supplier_Number->ViewAttributes() ?>>
<?php echo $a_stock_items->Supplier_Number->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Supplier_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->FormValue) ?>">
<input type="hidden" data-table="a_stock_items" data-field="x_Supplier_Number" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->OldValue) ?>">
<?php } ?>
<a id="<?php echo $a_stock_items_grid->PageObjName . "_row_" . $a_stock_items_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_ID" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_ID" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_ID" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_ID->CurrentValue) ?>">
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_ID" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_ID" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_ID" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_ID->OldValue) ?>">
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_EDIT || $a_stock_items->CurrentMode == "edit") { ?>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_ID" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_ID" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_ID" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($a_stock_items->Stock_Number->Visible) { // Stock_Number ?>
		<td data-name="Stock_Number"<?php echo $a_stock_items->Stock_Number->CellAttributes() ?>>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Stock_Number" class="form-group a_stock_items_Stock_Number">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Number->EditValue ?>"<?php echo $a_stock_items->Stock_Number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Number" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->OldValue) ?>">
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Stock_Number" class="form-group a_stock_items_Stock_Number">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Number->EditValue ?>"<?php echo $a_stock_items->Stock_Number->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Stock_Number" class="a_stock_items_Stock_Number">
<span<?php echo $a_stock_items->Stock_Number->ViewAttributes() ?>>
<?php echo $a_stock_items->Stock_Number->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->FormValue) ?>">
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Number" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_stock_items->Stock_Name->Visible) { // Stock_Name ?>
		<td data-name="Stock_Name"<?php echo $a_stock_items->Stock_Name->CellAttributes() ?>>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Stock_Name" class="form-group a_stock_items_Stock_Name">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Name" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Name->EditValue ?>"<?php echo $a_stock_items->Stock_Name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Name" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->OldValue) ?>">
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Stock_Name" class="form-group a_stock_items_Stock_Name">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Name" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Name->EditValue ?>"<?php echo $a_stock_items->Stock_Name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Stock_Name" class="a_stock_items_Stock_Name">
<span<?php echo $a_stock_items->Stock_Name->ViewAttributes() ?>>
<?php echo $a_stock_items->Stock_Name->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Name" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->FormValue) ?>">
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Name" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_stock_items->Purchasing_Price->Visible) { // Purchasing_Price ?>
		<td data-name="Purchasing_Price"<?php echo $a_stock_items->Purchasing_Price->CellAttributes() ?>>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Purchasing_Price" class="form-group a_stock_items_Purchasing_Price">
<input type="text" data-table="a_stock_items" data-field="x_Purchasing_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Purchasing_Price->EditValue ?>"<?php echo $a_stock_items->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Purchasing_Price->ReadOnly && !$a_stock_items->Purchasing_Price->Disabled && @$a_stock_items->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Purchasing_Price" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->OldValue) ?>">
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Purchasing_Price" class="form-group a_stock_items_Purchasing_Price">
<input type="text" data-table="a_stock_items" data-field="x_Purchasing_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Purchasing_Price->EditValue ?>"<?php echo $a_stock_items->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Purchasing_Price->ReadOnly && !$a_stock_items->Purchasing_Price->Disabled && @$a_stock_items->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Purchasing_Price" class="a_stock_items_Purchasing_Price">
<span<?php echo $a_stock_items->Purchasing_Price->ViewAttributes() ?>>
<?php echo $a_stock_items->Purchasing_Price->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Purchasing_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->FormValue) ?>">
<input type="hidden" data-table="a_stock_items" data-field="x_Purchasing_Price" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_stock_items->Selling_Price->Visible) { // Selling_Price ?>
		<td data-name="Selling_Price"<?php echo $a_stock_items->Selling_Price->CellAttributes() ?>>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Selling_Price" class="form-group a_stock_items_Selling_Price">
<input type="text" data-table="a_stock_items" data-field="x_Selling_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Selling_Price->EditValue ?>"<?php echo $a_stock_items->Selling_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Selling_Price->ReadOnly && !$a_stock_items->Selling_Price->Disabled && @$a_stock_items->Selling_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Selling_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Selling_Price" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->OldValue) ?>">
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Selling_Price" class="form-group a_stock_items_Selling_Price">
<input type="text" data-table="a_stock_items" data-field="x_Selling_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Selling_Price->EditValue ?>"<?php echo $a_stock_items->Selling_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Selling_Price->ReadOnly && !$a_stock_items->Selling_Price->Disabled && @$a_stock_items->Selling_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Selling_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Selling_Price" class="a_stock_items_Selling_Price">
<span<?php echo $a_stock_items->Selling_Price->ViewAttributes() ?>>
<?php echo $a_stock_items->Selling_Price->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Selling_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->FormValue) ?>">
<input type="hidden" data-table="a_stock_items" data-field="x_Selling_Price" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_stock_items->Quantity->Visible) { // Quantity ?>
		<td data-name="Quantity"<?php echo $a_stock_items->Quantity->CellAttributes() ?>>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Quantity" class="form-group a_stock_items_Quantity">
<input type="text" data-table="a_stock_items" data-field="x_Quantity" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Quantity->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Quantity->EditValue ?>"<?php echo $a_stock_items->Quantity->EditAttributes() ?>>
<?php if (!$a_stock_items->Quantity->ReadOnly && !$a_stock_items->Quantity->Disabled && @$a_stock_items->Quantity->EditAttrs["readonly"] == "" && @$a_stock_items->Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Quantity" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($a_stock_items->Quantity->OldValue) ?>">
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Quantity" class="form-group a_stock_items_Quantity">
<input type="text" data-table="a_stock_items" data-field="x_Quantity" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Quantity->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Quantity->EditValue ?>"<?php echo $a_stock_items->Quantity->EditAttributes() ?>>
<?php if (!$a_stock_items->Quantity->ReadOnly && !$a_stock_items->Quantity->Disabled && @$a_stock_items->Quantity->EditAttrs["readonly"] == "" && @$a_stock_items->Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_stock_items_grid->RowCnt ?>_a_stock_items_Quantity" class="a_stock_items_Quantity">
<span<?php echo $a_stock_items->Quantity->ViewAttributes() ?>>
<?php echo $a_stock_items->Quantity->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Quantity" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($a_stock_items->Quantity->FormValue) ?>">
<input type="hidden" data-table="a_stock_items" data-field="x_Quantity" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($a_stock_items->Quantity->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_stock_items_grid->ListOptions->Render("body", "right", $a_stock_items_grid->RowCnt);
?>
	</tr>
<?php if ($a_stock_items->RowType == EW_ROWTYPE_ADD || $a_stock_items->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fa_stock_itemsgrid.UpdateOpts(<?php echo $a_stock_items_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($a_stock_items->CurrentAction <> "gridadd" || $a_stock_items->CurrentMode == "copy")
		if (!$a_stock_items_grid->Recordset->EOF) $a_stock_items_grid->Recordset->MoveNext();
}
?>
<?php
	if ($a_stock_items->CurrentMode == "add" || $a_stock_items->CurrentMode == "copy" || $a_stock_items->CurrentMode == "edit") {
		$a_stock_items_grid->RowIndex = '$rowindex$';
		$a_stock_items_grid->LoadDefaultValues();

		// Set row properties
		$a_stock_items->ResetAttrs();
		$a_stock_items->RowAttrs = array_merge($a_stock_items->RowAttrs, array('data-rowindex'=>$a_stock_items_grid->RowIndex, 'id'=>'r0_a_stock_items', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($a_stock_items->RowAttrs["class"], "ewTemplate");
		$a_stock_items->RowType = EW_ROWTYPE_ADD;

		// Render row
		$a_stock_items_grid->RenderRow();

		// Render list options
		$a_stock_items_grid->RenderListOptions();
		$a_stock_items_grid->StartRowCnt = 0;
?>
	<tr<?php echo $a_stock_items->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_stock_items_grid->ListOptions->Render("body", "left", $a_stock_items_grid->RowIndex);
?>
	<?php if ($a_stock_items->Supplier_Number->Visible) { // Supplier_Number ?>
		<td data-name="Supplier_Number">
<?php if ($a_stock_items->CurrentAction <> "F") { ?>
<?php if ($a_stock_items->Supplier_Number->getSessionValue() <> "") { ?>
<span id="el$rowindex$_a_stock_items_Supplier_Number" class="form-group a_stock_items_Supplier_Number">
<span<?php echo $a_stock_items->Supplier_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Supplier_Number->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_a_stock_items_Supplier_Number" class="form-group a_stock_items_Supplier_Number">
<select data-table="a_stock_items" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Supplier_Number->DisplayValueSeparator) ? json_encode($a_stock_items->Supplier_Number->DisplayValueSeparator) : $a_stock_items->Supplier_Number->DisplayValueSeparator) ?>" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number"<?php echo $a_stock_items->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Supplier_Number->EditValue)) {
	$arwrk = $a_stock_items->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Supplier_Number->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_stock_items->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_stock_items->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->CurrentValue) ?>" selected><?php echo $a_stock_items->Supplier_Number->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_stock_items->Supplier_Number->OldValue = "";
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
$a_stock_items->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_stock_items->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_stock_items->Lookup_Selecting($a_stock_items->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Supplier_Name`";
if ($sSqlWrk <> "") $a_stock_items->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" id="s_x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo $a_stock_items->Supplier_Number->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_a_stock_items_Supplier_Number" class="form-group a_stock_items_Supplier_Number">
<span<?php echo $a_stock_items->Supplier_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Supplier_Number->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Supplier_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_stock_items" data-field="x_Supplier_Number" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_stock_items->Stock_Number->Visible) { // Stock_Number ?>
		<td data-name="Stock_Number">
<?php if ($a_stock_items->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_stock_items_Stock_Number" class="form-group a_stock_items_Stock_Number">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Number->EditValue ?>"<?php echo $a_stock_items->Stock_Number->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_stock_items_Stock_Number" class="form-group a_stock_items_Stock_Number">
<span<?php echo $a_stock_items->Stock_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Stock_Number->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Number" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Number" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_stock_items->Stock_Name->Visible) { // Stock_Name ?>
		<td data-name="Stock_Name">
<?php if ($a_stock_items->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_stock_items_Stock_Name" class="form-group a_stock_items_Stock_Name">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Name" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Name->EditValue ?>"<?php echo $a_stock_items->Stock_Name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_stock_items_Stock_Name" class="form-group a_stock_items_Stock_Name">
<span<?php echo $a_stock_items->Stock_Name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Stock_Name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Name" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_Name" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Stock_Name" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_stock_items->Purchasing_Price->Visible) { // Purchasing_Price ?>
		<td data-name="Purchasing_Price">
<?php if ($a_stock_items->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_stock_items_Purchasing_Price" class="form-group a_stock_items_Purchasing_Price">
<input type="text" data-table="a_stock_items" data-field="x_Purchasing_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Purchasing_Price->EditValue ?>"<?php echo $a_stock_items->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Purchasing_Price->ReadOnly && !$a_stock_items->Purchasing_Price->Disabled && @$a_stock_items->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_stock_items_Purchasing_Price" class="form-group a_stock_items_Purchasing_Price">
<span<?php echo $a_stock_items->Purchasing_Price->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Purchasing_Price->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Purchasing_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_stock_items" data-field="x_Purchasing_Price" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_stock_items->Selling_Price->Visible) { // Selling_Price ?>
		<td data-name="Selling_Price">
<?php if ($a_stock_items->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_stock_items_Selling_Price" class="form-group a_stock_items_Selling_Price">
<input type="text" data-table="a_stock_items" data-field="x_Selling_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Selling_Price->EditValue ?>"<?php echo $a_stock_items->Selling_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Selling_Price->ReadOnly && !$a_stock_items->Selling_Price->Disabled && @$a_stock_items->Selling_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Selling_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_stock_items_Selling_Price" class="form-group a_stock_items_Selling_Price">
<span<?php echo $a_stock_items->Selling_Price->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Selling_Price->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Selling_Price" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_stock_items" data-field="x_Selling_Price" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Selling_Price" value="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_stock_items->Quantity->Visible) { // Quantity ?>
		<td data-name="Quantity">
<?php if ($a_stock_items->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_stock_items_Quantity" class="form-group a_stock_items_Quantity">
<input type="text" data-table="a_stock_items" data-field="x_Quantity" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Quantity->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Quantity->EditValue ?>"<?php echo $a_stock_items->Quantity->EditAttributes() ?>>
<?php if (!$a_stock_items->Quantity->ReadOnly && !$a_stock_items->Quantity->Disabled && @$a_stock_items->Quantity->EditAttrs["readonly"] == "" && @$a_stock_items->Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_stock_items_Quantity" class="form-group a_stock_items_Quantity">
<span<?php echo $a_stock_items->Quantity->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Quantity->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Quantity" name="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" id="x<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($a_stock_items->Quantity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_stock_items" data-field="x_Quantity" name="o<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" id="o<?php echo $a_stock_items_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($a_stock_items->Quantity->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_stock_items_grid->ListOptions->Render("body", "right", $a_stock_items_grid->RowCnt);
?>
<script type="text/javascript">
fa_stock_itemsgrid.UpdateOpts(<?php echo $a_stock_items_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($a_stock_items->CurrentMode == "add" || $a_stock_items->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $a_stock_items_grid->FormKeyCountName ?>" id="<?php echo $a_stock_items_grid->FormKeyCountName ?>" value="<?php echo $a_stock_items_grid->KeyCount ?>">
<?php echo $a_stock_items_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_stock_items->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $a_stock_items_grid->FormKeyCountName ?>" id="<?php echo $a_stock_items_grid->FormKeyCountName ?>" value="<?php echo $a_stock_items_grid->KeyCount ?>">
<?php echo $a_stock_items_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_stock_items->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fa_stock_itemsgrid">
</div>
<?php

// Close recordset
if ($a_stock_items_grid->Recordset)
	$a_stock_items_grid->Recordset->Close();
?>
<?php if ($a_stock_items_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($a_stock_items_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($a_stock_items_grid->TotalRecs == 0 && $a_stock_items->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($a_stock_items_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($a_stock_items->Export == "") { ?>
<script type="text/javascript">
fa_stock_itemsgrid.Init();
</script>
<?php } ?>
<?php
$a_stock_items_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$a_stock_items_grid->Page_Terminate();
?>
