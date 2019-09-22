<?php include_once "usersinfo.php" ?>
<?php

// Create page object
if (!isset($a_sales_detail_grid)) $a_sales_detail_grid = new ca_sales_detail_grid();

// Page init
$a_sales_detail_grid->Page_Init();

// Page main
$a_sales_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$a_sales_detail_grid->Page_Render();
?>
<?php if ($a_sales_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var fa_sales_detailgrid = new ew_Form("fa_sales_detailgrid", "grid");
fa_sales_detailgrid.FormKeyCountName = '<?php echo $a_sales_detail_grid->FormKeyCountName ?>';

// Validate form
fa_sales_detailgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Supplier_Number->FldCaption(), $a_sales_detail->Supplier_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Stock_Item");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Stock_Item->FldCaption(), $a_sales_detail->Stock_Item->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Quantity");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Sales_Quantity->FldCaption(), $a_sales_detail->Sales_Quantity->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Purchasing_Price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Purchasing_Price->FldCaption(), $a_sales_detail->Purchasing_Price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Sales_Price->FldCaption(), $a_sales_detail->Sales_Price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Total_Amount");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Sales_Total_Amount->FldCaption(), $a_sales_detail->Sales_Total_Amount->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fa_sales_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Supplier_Number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Stock_Item", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Sales_Quantity", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Purchasing_Price", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Sales_Price", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Sales_Total_Amount", false)) return false;
	return true;
}

// Form_CustomValidate event
fa_sales_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_sales_detailgrid.ValidateRequired = true;
<?php } else { ?>
fa_sales_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_sales_detailgrid.Lists["x_Supplier_Number"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":["x_Stock_Item"],"FilterFields":[],"Options":[],"Template":""};
fa_sales_detailgrid.Lists["x_Stock_Item"] = {"LinkField":"x_Stock_Number","Ajax":true,"AutoFill":true,"DisplayFields":["x_Stock_Name","","",""],"ParentFields":["x_Supplier_Number"],"ChildFields":[],"FilterFields":["x_Supplier_Number"],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($a_sales_detail->CurrentAction == "gridadd") {
	if ($a_sales_detail->CurrentMode == "copy") {
		$bSelectLimit = $a_sales_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$a_sales_detail_grid->TotalRecs = $a_sales_detail->SelectRecordCount();
			$a_sales_detail_grid->Recordset = $a_sales_detail_grid->LoadRecordset($a_sales_detail_grid->StartRec-1, $a_sales_detail_grid->DisplayRecs);
		} else {
			if ($a_sales_detail_grid->Recordset = $a_sales_detail_grid->LoadRecordset())
				$a_sales_detail_grid->TotalRecs = $a_sales_detail_grid->Recordset->RecordCount();
		}
		$a_sales_detail_grid->StartRec = 1;
		$a_sales_detail_grid->DisplayRecs = $a_sales_detail_grid->TotalRecs;
	} else {
		$a_sales_detail->CurrentFilter = "0=1";
		$a_sales_detail_grid->StartRec = 1;
		$a_sales_detail_grid->DisplayRecs = $a_sales_detail->GridAddRowCount;
	}
	$a_sales_detail_grid->TotalRecs = $a_sales_detail_grid->DisplayRecs;
	$a_sales_detail_grid->StopRec = $a_sales_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $a_sales_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($a_sales_detail_grid->TotalRecs <= 0)
			$a_sales_detail_grid->TotalRecs = $a_sales_detail->SelectRecordCount();
	} else {
		if (!$a_sales_detail_grid->Recordset && ($a_sales_detail_grid->Recordset = $a_sales_detail_grid->LoadRecordset()))
			$a_sales_detail_grid->TotalRecs = $a_sales_detail_grid->Recordset->RecordCount();
	}
	$a_sales_detail_grid->StartRec = 1;
	$a_sales_detail_grid->DisplayRecs = $a_sales_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$a_sales_detail_grid->Recordset = $a_sales_detail_grid->LoadRecordset($a_sales_detail_grid->StartRec-1, $a_sales_detail_grid->DisplayRecs);

	// Set no record found message
	if ($a_sales_detail->CurrentAction == "" && $a_sales_detail_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$a_sales_detail_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($a_sales_detail_grid->SearchWhere == "0=101")
			$a_sales_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$a_sales_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$a_sales_detail_grid->RenderOtherOptions();
?>
<?php $a_sales_detail_grid->ShowPageHeader(); ?>
<?php
$a_sales_detail_grid->ShowMessage();
?>
<?php if ($a_sales_detail_grid->TotalRecs > 0 || $a_sales_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fa_sales_detailgrid" class="ewForm form-inline">
<?php if ($a_sales_detail_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($a_sales_detail_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_a_sales_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_a_sales_detailgrid" class="table ewTable">
<?php echo $a_sales_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$a_sales_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$a_sales_detail_grid->RenderListOptions();

// Render list options (header, left)
$a_sales_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($a_sales_detail->Supplier_Number->Visible) { // Supplier_Number ?>
	<?php if ($a_sales_detail->SortUrl($a_sales_detail->Supplier_Number) == "") { ?>
		<th data-name="Supplier_Number"><div id="elh_a_sales_detail_Supplier_Number" class="a_sales_detail_Supplier_Number"><div class="ewTableHeaderCaption"><?php echo $a_sales_detail->Supplier_Number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Supplier_Number"><div><div id="elh_a_sales_detail_Supplier_Number" class="a_sales_detail_Supplier_Number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_sales_detail->Supplier_Number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales_detail->Supplier_Number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales_detail->Supplier_Number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales_detail->Stock_Item->Visible) { // Stock_Item ?>
	<?php if ($a_sales_detail->SortUrl($a_sales_detail->Stock_Item) == "") { ?>
		<th data-name="Stock_Item"><div id="elh_a_sales_detail_Stock_Item" class="a_sales_detail_Stock_Item"><div class="ewTableHeaderCaption"><?php echo $a_sales_detail->Stock_Item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Stock_Item"><div><div id="elh_a_sales_detail_Stock_Item" class="a_sales_detail_Stock_Item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_sales_detail->Stock_Item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales_detail->Stock_Item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales_detail->Stock_Item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales_detail->Sales_Quantity->Visible) { // Sales_Quantity ?>
	<?php if ($a_sales_detail->SortUrl($a_sales_detail->Sales_Quantity) == "") { ?>
		<th data-name="Sales_Quantity"><div id="elh_a_sales_detail_Sales_Quantity" class="a_sales_detail_Sales_Quantity"><div class="ewTableHeaderCaption"><?php echo $a_sales_detail->Sales_Quantity->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Quantity"><div><div id="elh_a_sales_detail_Sales_Quantity" class="a_sales_detail_Sales_Quantity">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_sales_detail->Sales_Quantity->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales_detail->Sales_Quantity->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales_detail->Sales_Quantity->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales_detail->Purchasing_Price->Visible) { // Purchasing_Price ?>
	<?php if ($a_sales_detail->SortUrl($a_sales_detail->Purchasing_Price) == "") { ?>
		<th data-name="Purchasing_Price"><div id="elh_a_sales_detail_Purchasing_Price" class="a_sales_detail_Purchasing_Price"><div class="ewTableHeaderCaption"><?php echo $a_sales_detail->Purchasing_Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Purchasing_Price"><div><div id="elh_a_sales_detail_Purchasing_Price" class="a_sales_detail_Purchasing_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_sales_detail->Purchasing_Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales_detail->Purchasing_Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales_detail->Purchasing_Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales_detail->Sales_Price->Visible) { // Sales_Price ?>
	<?php if ($a_sales_detail->SortUrl($a_sales_detail->Sales_Price) == "") { ?>
		<th data-name="Sales_Price"><div id="elh_a_sales_detail_Sales_Price" class="a_sales_detail_Sales_Price"><div class="ewTableHeaderCaption"><?php echo $a_sales_detail->Sales_Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Price"><div><div id="elh_a_sales_detail_Sales_Price" class="a_sales_detail_Sales_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_sales_detail->Sales_Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales_detail->Sales_Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales_detail->Sales_Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($a_sales_detail->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
	<?php if ($a_sales_detail->SortUrl($a_sales_detail->Sales_Total_Amount) == "") { ?>
		<th data-name="Sales_Total_Amount"><div id="elh_a_sales_detail_Sales_Total_Amount" class="a_sales_detail_Sales_Total_Amount"><div class="ewTableHeaderCaption"><?php echo $a_sales_detail->Sales_Total_Amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sales_Total_Amount"><div><div id="elh_a_sales_detail_Sales_Total_Amount" class="a_sales_detail_Sales_Total_Amount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $a_sales_detail->Sales_Total_Amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($a_sales_detail->Sales_Total_Amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($a_sales_detail->Sales_Total_Amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$a_sales_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$a_sales_detail_grid->StartRec = 1;
$a_sales_detail_grid->StopRec = $a_sales_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($a_sales_detail_grid->FormKeyCountName) && ($a_sales_detail->CurrentAction == "gridadd" || $a_sales_detail->CurrentAction == "gridedit" || $a_sales_detail->CurrentAction == "F")) {
		$a_sales_detail_grid->KeyCount = $objForm->GetValue($a_sales_detail_grid->FormKeyCountName);
		$a_sales_detail_grid->StopRec = $a_sales_detail_grid->StartRec + $a_sales_detail_grid->KeyCount - 1;
	}
}
$a_sales_detail_grid->RecCnt = $a_sales_detail_grid->StartRec - 1;
if ($a_sales_detail_grid->Recordset && !$a_sales_detail_grid->Recordset->EOF) {
	$a_sales_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $a_sales_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $a_sales_detail_grid->StartRec > 1)
		$a_sales_detail_grid->Recordset->Move($a_sales_detail_grid->StartRec - 1);
} elseif (!$a_sales_detail->AllowAddDeleteRow && $a_sales_detail_grid->StopRec == 0) {
	$a_sales_detail_grid->StopRec = $a_sales_detail->GridAddRowCount;
}

// Initialize aggregate
$a_sales_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$a_sales_detail->ResetAttrs();
$a_sales_detail_grid->RenderRow();
if ($a_sales_detail->CurrentAction == "gridadd")
	$a_sales_detail_grid->RowIndex = 0;
if ($a_sales_detail->CurrentAction == "gridedit")
	$a_sales_detail_grid->RowIndex = 0;
while ($a_sales_detail_grid->RecCnt < $a_sales_detail_grid->StopRec) {
	$a_sales_detail_grid->RecCnt++;
	if (intval($a_sales_detail_grid->RecCnt) >= intval($a_sales_detail_grid->StartRec)) {
		$a_sales_detail_grid->RowCnt++;
		if ($a_sales_detail->CurrentAction == "gridadd" || $a_sales_detail->CurrentAction == "gridedit" || $a_sales_detail->CurrentAction == "F") {
			$a_sales_detail_grid->RowIndex++;
			$objForm->Index = $a_sales_detail_grid->RowIndex;
			if ($objForm->HasValue($a_sales_detail_grid->FormActionName))
				$a_sales_detail_grid->RowAction = strval($objForm->GetValue($a_sales_detail_grid->FormActionName));
			elseif ($a_sales_detail->CurrentAction == "gridadd")
				$a_sales_detail_grid->RowAction = "insert";
			else
				$a_sales_detail_grid->RowAction = "";
		}

		// Set up key count
		$a_sales_detail_grid->KeyCount = $a_sales_detail_grid->RowIndex;

		// Init row class and style
		$a_sales_detail->ResetAttrs();
		$a_sales_detail->CssClass = "";
		if ($a_sales_detail->CurrentAction == "gridadd") {
			if ($a_sales_detail->CurrentMode == "copy") {
				$a_sales_detail_grid->LoadRowValues($a_sales_detail_grid->Recordset); // Load row values
				$a_sales_detail_grid->SetRecordKey($a_sales_detail_grid->RowOldKey, $a_sales_detail_grid->Recordset); // Set old record key
			} else {
				$a_sales_detail_grid->LoadDefaultValues(); // Load default values
				$a_sales_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$a_sales_detail_grid->LoadRowValues($a_sales_detail_grid->Recordset); // Load row values
		}
		$a_sales_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($a_sales_detail->CurrentAction == "gridadd") // Grid add
			$a_sales_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($a_sales_detail->CurrentAction == "gridadd" && $a_sales_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$a_sales_detail_grid->RestoreCurrentRowFormValues($a_sales_detail_grid->RowIndex); // Restore form values
		if ($a_sales_detail->CurrentAction == "gridedit") { // Grid edit
			if ($a_sales_detail->EventCancelled) {
				$a_sales_detail_grid->RestoreCurrentRowFormValues($a_sales_detail_grid->RowIndex); // Restore form values
			}
			if ($a_sales_detail_grid->RowAction == "insert")
				$a_sales_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$a_sales_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($a_sales_detail->CurrentAction == "gridedit" && ($a_sales_detail->RowType == EW_ROWTYPE_EDIT || $a_sales_detail->RowType == EW_ROWTYPE_ADD) && $a_sales_detail->EventCancelled) // Update failed
			$a_sales_detail_grid->RestoreCurrentRowFormValues($a_sales_detail_grid->RowIndex); // Restore form values
		if ($a_sales_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$a_sales_detail_grid->EditRowCnt++;
		if ($a_sales_detail->CurrentAction == "F") // Confirm row
			$a_sales_detail_grid->RestoreCurrentRowFormValues($a_sales_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$a_sales_detail->RowAttrs = array_merge($a_sales_detail->RowAttrs, array('data-rowindex'=>$a_sales_detail_grid->RowCnt, 'id'=>'r' . $a_sales_detail_grid->RowCnt . '_a_sales_detail', 'data-rowtype'=>$a_sales_detail->RowType));

		// Render row
		$a_sales_detail_grid->RenderRow();

		// Render list options
		$a_sales_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($a_sales_detail_grid->RowAction <> "delete" && $a_sales_detail_grid->RowAction <> "insertdelete" && !($a_sales_detail_grid->RowAction == "insert" && $a_sales_detail->CurrentAction == "F" && $a_sales_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $a_sales_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_sales_detail_grid->ListOptions->Render("body", "left", $a_sales_detail_grid->RowCnt);
?>
	<?php if ($a_sales_detail->Supplier_Number->Visible) { // Supplier_Number ?>
		<td data-name="Supplier_Number"<?php echo $a_sales_detail->Supplier_Number->CellAttributes() ?>>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Supplier_Number" class="form-group a_sales_detail_Supplier_Number">
<?php $a_sales_detail->Supplier_Number->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$a_sales_detail->Supplier_Number->EditAttrs["onchange"]; ?>
<select data-table="a_sales_detail" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales_detail->Supplier_Number->DisplayValueSeparator) ? json_encode($a_sales_detail->Supplier_Number->DisplayValueSeparator) : $a_sales_detail->Supplier_Number->DisplayValueSeparator) ?>" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number"<?php echo $a_sales_detail->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_sales_detail->Supplier_Number->EditValue)) {
	$arwrk = $a_sales_detail->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales_detail->Supplier_Number->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales_detail->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales_detail->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales_detail->Supplier_Number->CurrentValue) ?>" selected><?php echo $a_sales_detail->Supplier_Number->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_sales_detail->Supplier_Number->OldValue = "";
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
$lookuptblfilter = "`Is_Stock_Available` = 'Y'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_sales_detail->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales_detail->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_sales_detail->Lookup_Selecting($a_sales_detail->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Supplier_ID`";
if ($sSqlWrk <> "") $a_sales_detail->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" id="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" value="<?php echo $a_sales_detail->Supplier_Number->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Supplier_Number" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_sales_detail->Supplier_Number->OldValue) ?>">
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Supplier_Number" class="form-group a_sales_detail_Supplier_Number">
<?php $a_sales_detail->Supplier_Number->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$a_sales_detail->Supplier_Number->EditAttrs["onchange"]; ?>
<select data-table="a_sales_detail" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales_detail->Supplier_Number->DisplayValueSeparator) ? json_encode($a_sales_detail->Supplier_Number->DisplayValueSeparator) : $a_sales_detail->Supplier_Number->DisplayValueSeparator) ?>" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number"<?php echo $a_sales_detail->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_sales_detail->Supplier_Number->EditValue)) {
	$arwrk = $a_sales_detail->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales_detail->Supplier_Number->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales_detail->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales_detail->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales_detail->Supplier_Number->CurrentValue) ?>" selected><?php echo $a_sales_detail->Supplier_Number->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_sales_detail->Supplier_Number->OldValue = "";
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
$lookuptblfilter = "`Is_Stock_Available` = 'Y'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_sales_detail->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales_detail->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_sales_detail->Lookup_Selecting($a_sales_detail->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Supplier_ID`";
if ($sSqlWrk <> "") $a_sales_detail->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" id="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" value="<?php echo $a_sales_detail->Supplier_Number->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Supplier_Number" class="a_sales_detail_Supplier_Number">
<span<?php echo $a_sales_detail->Supplier_Number->ViewAttributes() ?>>
<?php echo $a_sales_detail->Supplier_Number->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Supplier_Number" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_sales_detail->Supplier_Number->FormValue) ?>">
<input type="hidden" data-table="a_sales_detail" data-field="x_Supplier_Number" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_sales_detail->Supplier_Number->OldValue) ?>">
<?php } ?>
<a id="<?php echo $a_sales_detail_grid->PageObjName . "_row_" . $a_sales_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_ID" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_ID" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_ID" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_ID->CurrentValue) ?>">
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_ID" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_ID" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_ID" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_ID->OldValue) ?>">
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_EDIT || $a_sales_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_ID" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_ID" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_ID" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($a_sales_detail->Stock_Item->Visible) { // Stock_Item ?>
		<td data-name="Stock_Item"<?php echo $a_sales_detail->Stock_Item->CellAttributes() ?>>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Stock_Item" class="form-group a_sales_detail_Stock_Item">
<?php $a_sales_detail->Stock_Item->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$a_sales_detail->Stock_Item->EditAttrs["onchange"]; ?>
<select data-table="a_sales_detail" data-field="x_Stock_Item" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales_detail->Stock_Item->DisplayValueSeparator) ? json_encode($a_sales_detail->Stock_Item->DisplayValueSeparator) : $a_sales_detail->Stock_Item->DisplayValueSeparator) ?>" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item"<?php echo $a_sales_detail->Stock_Item->EditAttributes() ?>>
<?php
if (is_array($a_sales_detail->Stock_Item->EditValue)) {
	$arwrk = $a_sales_detail->Stock_Item->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales_detail->Stock_Item->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales_detail->Stock_Item->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales_detail->Stock_Item->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales_detail->Stock_Item->CurrentValue) ?>" selected><?php echo $a_sales_detail->Stock_Item->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_sales_detail->Stock_Item->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
		$sWhereWrk = "{filter}";
		break;
	default:
		$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
		$sWhereWrk = "{filter}";
		break;
}
$lookuptblfilter = "`Quantity` > 0";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_sales_detail->Stock_Item->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales_detail->Stock_Item->LookupFilters += array("f0" => "`Stock_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$a_sales_detail->Stock_Item->LookupFilters += array("f1" => "`Supplier_Number` IN ({filter_value})", "t1" => "200", "fn1" => "");
$sSqlWrk = "";
$a_sales_detail->Lookup_Selecting($a_sales_detail->Stock_Item, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_sales_detail->Stock_Item->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="<?php echo $a_sales_detail->Stock_Item->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="ln_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price,x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price">
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Stock_Item" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="<?php echo ew_HtmlEncode($a_sales_detail->Stock_Item->OldValue) ?>">
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Stock_Item" class="form-group a_sales_detail_Stock_Item">
<?php $a_sales_detail->Stock_Item->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$a_sales_detail->Stock_Item->EditAttrs["onchange"]; ?>
<select data-table="a_sales_detail" data-field="x_Stock_Item" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales_detail->Stock_Item->DisplayValueSeparator) ? json_encode($a_sales_detail->Stock_Item->DisplayValueSeparator) : $a_sales_detail->Stock_Item->DisplayValueSeparator) ?>" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item"<?php echo $a_sales_detail->Stock_Item->EditAttributes() ?>>
<?php
if (is_array($a_sales_detail->Stock_Item->EditValue)) {
	$arwrk = $a_sales_detail->Stock_Item->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales_detail->Stock_Item->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales_detail->Stock_Item->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales_detail->Stock_Item->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales_detail->Stock_Item->CurrentValue) ?>" selected><?php echo $a_sales_detail->Stock_Item->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_sales_detail->Stock_Item->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
		$sWhereWrk = "{filter}";
		break;
	default:
		$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
		$sWhereWrk = "{filter}";
		break;
}
$lookuptblfilter = "`Quantity` > 0";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_sales_detail->Stock_Item->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales_detail->Stock_Item->LookupFilters += array("f0" => "`Stock_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$a_sales_detail->Stock_Item->LookupFilters += array("f1" => "`Supplier_Number` IN ({filter_value})", "t1" => "200", "fn1" => "");
$sSqlWrk = "";
$a_sales_detail->Lookup_Selecting($a_sales_detail->Stock_Item, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_sales_detail->Stock_Item->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="<?php echo $a_sales_detail->Stock_Item->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="ln_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price,x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price">
</span>
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Stock_Item" class="a_sales_detail_Stock_Item">
<span<?php echo $a_sales_detail->Stock_Item->ViewAttributes() ?>>
<?php echo $a_sales_detail->Stock_Item->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Stock_Item" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="<?php echo ew_HtmlEncode($a_sales_detail->Stock_Item->FormValue) ?>">
<input type="hidden" data-table="a_sales_detail" data-field="x_Stock_Item" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="<?php echo ew_HtmlEncode($a_sales_detail->Stock_Item->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales_detail->Sales_Quantity->Visible) { // Sales_Quantity ?>
		<td data-name="Sales_Quantity"<?php echo $a_sales_detail->Sales_Quantity->CellAttributes() ?>>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Sales_Quantity" class="form-group a_sales_detail_Sales_Quantity">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Quantity" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Quantity->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Quantity->EditValue ?>"<?php echo $a_sales_detail->Sales_Quantity->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Quantity->ReadOnly && !$a_sales_detail->Sales_Quantity->Disabled && @$a_sales_detail->Sales_Quantity->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Quantity" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Quantity->OldValue) ?>">
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Sales_Quantity" class="form-group a_sales_detail_Sales_Quantity">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Quantity" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Quantity->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Quantity->EditValue ?>"<?php echo $a_sales_detail->Sales_Quantity->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Quantity->ReadOnly && !$a_sales_detail->Sales_Quantity->Disabled && @$a_sales_detail->Sales_Quantity->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Sales_Quantity" class="a_sales_detail_Sales_Quantity">
<span<?php echo $a_sales_detail->Sales_Quantity->ViewAttributes() ?>>
<?php echo $a_sales_detail->Sales_Quantity->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Quantity" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Quantity->FormValue) ?>">
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Quantity" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Quantity->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales_detail->Purchasing_Price->Visible) { // Purchasing_Price ?>
		<td data-name="Purchasing_Price"<?php echo $a_sales_detail->Purchasing_Price->CellAttributes() ?>>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Purchasing_Price" class="form-group a_sales_detail_Purchasing_Price">
<input type="text" data-table="a_sales_detail" data-field="x_Purchasing_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Purchasing_Price->EditValue ?>"<?php echo $a_sales_detail->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_sales_detail->Purchasing_Price->ReadOnly && !$a_sales_detail->Purchasing_Price->Disabled && @$a_sales_detail->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_sales_detail->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Purchasing_Price" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Purchasing_Price->OldValue) ?>">
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Purchasing_Price" class="form-group a_sales_detail_Purchasing_Price">
<input type="text" data-table="a_sales_detail" data-field="x_Purchasing_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Purchasing_Price->EditValue ?>"<?php echo $a_sales_detail->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_sales_detail->Purchasing_Price->ReadOnly && !$a_sales_detail->Purchasing_Price->Disabled && @$a_sales_detail->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_sales_detail->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Purchasing_Price" class="a_sales_detail_Purchasing_Price">
<span<?php echo $a_sales_detail->Purchasing_Price->ViewAttributes() ?>>
<?php echo $a_sales_detail->Purchasing_Price->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Purchasing_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Purchasing_Price->FormValue) ?>">
<input type="hidden" data-table="a_sales_detail" data-field="x_Purchasing_Price" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Purchasing_Price->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales_detail->Sales_Price->Visible) { // Sales_Price ?>
		<td data-name="Sales_Price"<?php echo $a_sales_detail->Sales_Price->CellAttributes() ?>>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Sales_Price" class="form-group a_sales_detail_Sales_Price">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Price->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Price->EditValue ?>"<?php echo $a_sales_detail->Sales_Price->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Price->ReadOnly && !$a_sales_detail->Sales_Price->Disabled && @$a_sales_detail->Sales_Price->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Price" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Price->OldValue) ?>">
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Sales_Price" class="form-group a_sales_detail_Sales_Price">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Price->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Price->EditValue ?>"<?php echo $a_sales_detail->Sales_Price->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Price->ReadOnly && !$a_sales_detail->Sales_Price->Disabled && @$a_sales_detail->Sales_Price->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Sales_Price" class="a_sales_detail_Sales_Price">
<span<?php echo $a_sales_detail->Sales_Price->ViewAttributes() ?>>
<?php echo $a_sales_detail->Sales_Price->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Price->FormValue) ?>">
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Price" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Price->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($a_sales_detail->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
		<td data-name="Sales_Total_Amount"<?php echo $a_sales_detail->Sales_Total_Amount->CellAttributes() ?>>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Sales_Total_Amount" class="form-group a_sales_detail_Sales_Total_Amount">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Total_Amount" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Total_Amount->EditValue ?>"<?php echo $a_sales_detail->Sales_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Total_Amount->ReadOnly && !$a_sales_detail->Sales_Total_Amount->Disabled && @$a_sales_detail->Sales_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Total_Amount" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Total_Amount->OldValue) ?>">
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Sales_Total_Amount" class="form-group a_sales_detail_Sales_Total_Amount">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Total_Amount" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Total_Amount->EditValue ?>"<?php echo $a_sales_detail->Sales_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Total_Amount->ReadOnly && !$a_sales_detail->Sales_Total_Amount->Disabled && @$a_sales_detail->Sales_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $a_sales_detail_grid->RowCnt ?>_a_sales_detail_Sales_Total_Amount" class="a_sales_detail_Sales_Total_Amount">
<span<?php echo $a_sales_detail->Sales_Total_Amount->ViewAttributes() ?>>
<?php echo $a_sales_detail->Sales_Total_Amount->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Total_Amount" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Total_Amount->FormValue) ?>">
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Total_Amount" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Total_Amount->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_sales_detail_grid->ListOptions->Render("body", "right", $a_sales_detail_grid->RowCnt);
?>
	</tr>
<?php if ($a_sales_detail->RowType == EW_ROWTYPE_ADD || $a_sales_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fa_sales_detailgrid.UpdateOpts(<?php echo $a_sales_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($a_sales_detail->CurrentAction <> "gridadd" || $a_sales_detail->CurrentMode == "copy")
		if (!$a_sales_detail_grid->Recordset->EOF) $a_sales_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($a_sales_detail->CurrentMode == "add" || $a_sales_detail->CurrentMode == "copy" || $a_sales_detail->CurrentMode == "edit") {
		$a_sales_detail_grid->RowIndex = '$rowindex$';
		$a_sales_detail_grid->LoadDefaultValues();

		// Set row properties
		$a_sales_detail->ResetAttrs();
		$a_sales_detail->RowAttrs = array_merge($a_sales_detail->RowAttrs, array('data-rowindex'=>$a_sales_detail_grid->RowIndex, 'id'=>'r0_a_sales_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($a_sales_detail->RowAttrs["class"], "ewTemplate");
		$a_sales_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$a_sales_detail_grid->RenderRow();

		// Render list options
		$a_sales_detail_grid->RenderListOptions();
		$a_sales_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $a_sales_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$a_sales_detail_grid->ListOptions->Render("body", "left", $a_sales_detail_grid->RowIndex);
?>
	<?php if ($a_sales_detail->Supplier_Number->Visible) { // Supplier_Number ?>
		<td data-name="Supplier_Number">
<?php if ($a_sales_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_detail_Supplier_Number" class="form-group a_sales_detail_Supplier_Number">
<?php $a_sales_detail->Supplier_Number->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$a_sales_detail->Supplier_Number->EditAttrs["onchange"]; ?>
<select data-table="a_sales_detail" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales_detail->Supplier_Number->DisplayValueSeparator) ? json_encode($a_sales_detail->Supplier_Number->DisplayValueSeparator) : $a_sales_detail->Supplier_Number->DisplayValueSeparator) ?>" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number"<?php echo $a_sales_detail->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_sales_detail->Supplier_Number->EditValue)) {
	$arwrk = $a_sales_detail->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales_detail->Supplier_Number->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales_detail->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales_detail->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales_detail->Supplier_Number->CurrentValue) ?>" selected><?php echo $a_sales_detail->Supplier_Number->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_sales_detail->Supplier_Number->OldValue = "";
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
$lookuptblfilter = "`Is_Stock_Available` = 'Y'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_sales_detail->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales_detail->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_sales_detail->Lookup_Selecting($a_sales_detail->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Supplier_ID`";
if ($sSqlWrk <> "") $a_sales_detail->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" id="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" value="<?php echo $a_sales_detail->Supplier_Number->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_detail_Supplier_Number" class="form-group a_sales_detail_Supplier_Number">
<span<?php echo $a_sales_detail->Supplier_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales_detail->Supplier_Number->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Supplier_Number" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_sales_detail->Supplier_Number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales_detail" data-field="x_Supplier_Number" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Supplier_Number" value="<?php echo ew_HtmlEncode($a_sales_detail->Supplier_Number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales_detail->Stock_Item->Visible) { // Stock_Item ?>
		<td data-name="Stock_Item">
<?php if ($a_sales_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_detail_Stock_Item" class="form-group a_sales_detail_Stock_Item">
<?php $a_sales_detail->Stock_Item->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$a_sales_detail->Stock_Item->EditAttrs["onchange"]; ?>
<select data-table="a_sales_detail" data-field="x_Stock_Item" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales_detail->Stock_Item->DisplayValueSeparator) ? json_encode($a_sales_detail->Stock_Item->DisplayValueSeparator) : $a_sales_detail->Stock_Item->DisplayValueSeparator) ?>" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item"<?php echo $a_sales_detail->Stock_Item->EditAttributes() ?>>
<?php
if (is_array($a_sales_detail->Stock_Item->EditValue)) {
	$arwrk = $a_sales_detail->Stock_Item->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales_detail->Stock_Item->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales_detail->Stock_Item->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales_detail->Stock_Item->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales_detail->Stock_Item->CurrentValue) ?>" selected><?php echo $a_sales_detail->Stock_Item->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $a_sales_detail->Stock_Item->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
		$sWhereWrk = "{filter}";
		break;
	default:
		$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
		$sWhereWrk = "{filter}";
		break;
}
$lookuptblfilter = "`Quantity` > 0";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_sales_detail->Stock_Item->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales_detail->Stock_Item->LookupFilters += array("f0" => "`Stock_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$a_sales_detail->Stock_Item->LookupFilters += array("f1" => "`Supplier_Number` IN ({filter_value})", "t1" => "200", "fn1" => "");
$sSqlWrk = "";
$a_sales_detail->Lookup_Selecting($a_sales_detail->Stock_Item, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_sales_detail->Stock_Item->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="s_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="<?php echo $a_sales_detail->Stock_Item->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="ln_x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price,x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price">
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_detail_Stock_Item" class="form-group a_sales_detail_Stock_Item">
<span<?php echo $a_sales_detail->Stock_Item->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales_detail->Stock_Item->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Stock_Item" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="<?php echo ew_HtmlEncode($a_sales_detail->Stock_Item->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales_detail" data-field="x_Stock_Item" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Stock_Item" value="<?php echo ew_HtmlEncode($a_sales_detail->Stock_Item->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales_detail->Sales_Quantity->Visible) { // Sales_Quantity ?>
		<td data-name="Sales_Quantity">
<?php if ($a_sales_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_detail_Sales_Quantity" class="form-group a_sales_detail_Sales_Quantity">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Quantity" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Quantity->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Quantity->EditValue ?>"<?php echo $a_sales_detail->Sales_Quantity->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Quantity->ReadOnly && !$a_sales_detail->Sales_Quantity->Disabled && @$a_sales_detail->Sales_Quantity->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_detail_Sales_Quantity" class="form-group a_sales_detail_Sales_Quantity">
<span<?php echo $a_sales_detail->Sales_Quantity->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales_detail->Sales_Quantity->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Quantity" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Quantity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Quantity" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Quantity" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Quantity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales_detail->Purchasing_Price->Visible) { // Purchasing_Price ?>
		<td data-name="Purchasing_Price">
<?php if ($a_sales_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_detail_Purchasing_Price" class="form-group a_sales_detail_Purchasing_Price">
<input type="text" data-table="a_sales_detail" data-field="x_Purchasing_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Purchasing_Price->EditValue ?>"<?php echo $a_sales_detail->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_sales_detail->Purchasing_Price->ReadOnly && !$a_sales_detail->Purchasing_Price->Disabled && @$a_sales_detail->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_sales_detail->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_detail_Purchasing_Price" class="form-group a_sales_detail_Purchasing_Price">
<span<?php echo $a_sales_detail->Purchasing_Price->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales_detail->Purchasing_Price->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Purchasing_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Purchasing_Price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales_detail" data-field="x_Purchasing_Price" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Purchasing_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Purchasing_Price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales_detail->Sales_Price->Visible) { // Sales_Price ?>
		<td data-name="Sales_Price">
<?php if ($a_sales_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_detail_Sales_Price" class="form-group a_sales_detail_Sales_Price">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Price->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Price->EditValue ?>"<?php echo $a_sales_detail->Sales_Price->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Price->ReadOnly && !$a_sales_detail->Sales_Price->Disabled && @$a_sales_detail->Sales_Price->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_detail_Sales_Price" class="form-group a_sales_detail_Sales_Price">
<span<?php echo $a_sales_detail->Sales_Price->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales_detail->Sales_Price->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Price" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Price" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Price" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($a_sales_detail->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
		<td data-name="Sales_Total_Amount">
<?php if ($a_sales_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_a_sales_detail_Sales_Total_Amount" class="form-group a_sales_detail_Sales_Total_Amount">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Total_Amount" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Total_Amount->EditValue ?>"<?php echo $a_sales_detail->Sales_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Total_Amount->ReadOnly && !$a_sales_detail->Sales_Total_Amount->Disabled && @$a_sales_detail->Sales_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_a_sales_detail_Sales_Total_Amount" class="form-group a_sales_detail_Sales_Total_Amount">
<span<?php echo $a_sales_detail->Sales_Total_Amount->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales_detail->Sales_Total_Amount->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Total_Amount" name="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" id="x<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Total_Amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="a_sales_detail" data-field="x_Sales_Total_Amount" name="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" id="o<?php echo $a_sales_detail_grid->RowIndex ?>_Sales_Total_Amount" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Total_Amount->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$a_sales_detail_grid->ListOptions->Render("body", "right", $a_sales_detail_grid->RowCnt);
?>
<script type="text/javascript">
fa_sales_detailgrid.UpdateOpts(<?php echo $a_sales_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($a_sales_detail->CurrentMode == "add" || $a_sales_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $a_sales_detail_grid->FormKeyCountName ?>" id="<?php echo $a_sales_detail_grid->FormKeyCountName ?>" value="<?php echo $a_sales_detail_grid->KeyCount ?>">
<?php echo $a_sales_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_sales_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $a_sales_detail_grid->FormKeyCountName ?>" id="<?php echo $a_sales_detail_grid->FormKeyCountName ?>" value="<?php echo $a_sales_detail_grid->KeyCount ?>">
<?php echo $a_sales_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($a_sales_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fa_sales_detailgrid">
</div>
<?php

// Close recordset
if ($a_sales_detail_grid->Recordset)
	$a_sales_detail_grid->Recordset->Close();
?>
<?php if ($a_sales_detail_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($a_sales_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($a_sales_detail_grid->TotalRecs == 0 && $a_sales_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($a_sales_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($a_sales_detail->Export == "") { ?>
<script type="text/javascript">
fa_sales_detailgrid.Init();
</script>
<?php } ?>
<?php
$a_sales_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$a_sales_detail_grid->Page_Terminate();
?>
