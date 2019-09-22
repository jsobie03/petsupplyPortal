<?php include_once "usersinfo.php" ?>
<?php

// Create page object
if (!isset($help_grid)) $help_grid = new chelp_grid();

// Page init
$help_grid->Page_Init();

// Page main
$help_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$help_grid->Page_Render();
?>
<?php if ($help->Export == "") { ?>
<script type="text/javascript">

// Form object
var fhelpgrid = new ew_Form("fhelpgrid", "grid");
fhelpgrid.FormKeyCountName = '<?php echo $help_grid->FormKeyCountName ?>';

// Validate form
fhelpgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Topic");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->Topic->FldCaption(), $help->Topic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Description");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->Description->FldCaption(), $help->Description->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Category");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->Category->FldCaption(), $help->Category->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fhelpgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Topic", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Description", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Category", false)) return false;
	return true;
}

// Form_CustomValidate event
fhelpgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhelpgrid.ValidateRequired = true;
<?php } else { ?>
fhelpgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhelpgrid.Lists["x_Category"] = {"LinkField":"x_Category_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Category_Description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($help->CurrentAction == "gridadd") {
	if ($help->CurrentMode == "copy") {
		$bSelectLimit = $help_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$help_grid->TotalRecs = $help->SelectRecordCount();
			$help_grid->Recordset = $help_grid->LoadRecordset($help_grid->StartRec-1, $help_grid->DisplayRecs);
		} else {
			if ($help_grid->Recordset = $help_grid->LoadRecordset())
				$help_grid->TotalRecs = $help_grid->Recordset->RecordCount();
		}
		$help_grid->StartRec = 1;
		$help_grid->DisplayRecs = $help_grid->TotalRecs;
	} else {
		$help->CurrentFilter = "0=1";
		$help_grid->StartRec = 1;
		$help_grid->DisplayRecs = $help->GridAddRowCount;
	}
	$help_grid->TotalRecs = $help_grid->DisplayRecs;
	$help_grid->StopRec = $help_grid->DisplayRecs;
} else {
	$bSelectLimit = $help_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($help_grid->TotalRecs <= 0)
			$help_grid->TotalRecs = $help->SelectRecordCount();
	} else {
		if (!$help_grid->Recordset && ($help_grid->Recordset = $help_grid->LoadRecordset()))
			$help_grid->TotalRecs = $help_grid->Recordset->RecordCount();
	}
	$help_grid->StartRec = 1;
	$help_grid->DisplayRecs = $help_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$help_grid->Recordset = $help_grid->LoadRecordset($help_grid->StartRec-1, $help_grid->DisplayRecs);

	// Set no record found message
	if ($help->CurrentAction == "" && $help_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$help_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($help_grid->SearchWhere == "0=101")
			$help_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$help_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$help_grid->RenderOtherOptions();
?>
<?php $help_grid->ShowPageHeader(); ?>
<?php
$help_grid->ShowMessage();
?>
<?php if ($help_grid->TotalRecs > 0 || $help->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fhelpgrid" class="ewForm form-inline">
<?php if ($help_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($help_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_help" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_helpgrid" class="table ewTable">
<?php echo $help->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$help_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$help_grid->RenderListOptions();

// Render list options (header, left)
$help_grid->ListOptions->Render("header", "left");
?>
<?php if ($help->Topic->Visible) { // Topic ?>
	<?php if ($help->SortUrl($help->Topic) == "") { ?>
		<th data-name="Topic"><div id="elh_help_Topic" class="help_Topic"><div class="ewTableHeaderCaption"><?php echo $help->Topic->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Topic"><div><div id="elh_help_Topic" class="help_Topic">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $help->Topic->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($help->Topic->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($help->Topic->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($help->Description->Visible) { // Description ?>
	<?php if ($help->SortUrl($help->Description) == "") { ?>
		<th data-name="Description"><div id="elh_help_Description" class="help_Description"><div class="ewTableHeaderCaption"><?php echo $help->Description->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Description"><div><div id="elh_help_Description" class="help_Description">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $help->Description->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($help->Description->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($help->Description->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($help->Category->Visible) { // Category ?>
	<?php if ($help->SortUrl($help->Category) == "") { ?>
		<th data-name="Category"><div id="elh_help_Category" class="help_Category"><div class="ewTableHeaderCaption"><?php echo $help->Category->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Category"><div><div id="elh_help_Category" class="help_Category">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $help->Category->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($help->Category->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($help->Category->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$help_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$help_grid->StartRec = 1;
$help_grid->StopRec = $help_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($help_grid->FormKeyCountName) && ($help->CurrentAction == "gridadd" || $help->CurrentAction == "gridedit" || $help->CurrentAction == "F")) {
		$help_grid->KeyCount = $objForm->GetValue($help_grid->FormKeyCountName);
		$help_grid->StopRec = $help_grid->StartRec + $help_grid->KeyCount - 1;
	}
}
$help_grid->RecCnt = $help_grid->StartRec - 1;
if ($help_grid->Recordset && !$help_grid->Recordset->EOF) {
	$help_grid->Recordset->MoveFirst();
	$bSelectLimit = $help_grid->UseSelectLimit;
	if (!$bSelectLimit && $help_grid->StartRec > 1)
		$help_grid->Recordset->Move($help_grid->StartRec - 1);
} elseif (!$help->AllowAddDeleteRow && $help_grid->StopRec == 0) {
	$help_grid->StopRec = $help->GridAddRowCount;
}

// Initialize aggregate
$help->RowType = EW_ROWTYPE_AGGREGATEINIT;
$help->ResetAttrs();
$help_grid->RenderRow();
if ($help->CurrentAction == "gridadd")
	$help_grid->RowIndex = 0;
if ($help->CurrentAction == "gridedit")
	$help_grid->RowIndex = 0;
while ($help_grid->RecCnt < $help_grid->StopRec) {
	$help_grid->RecCnt++;
	if (intval($help_grid->RecCnt) >= intval($help_grid->StartRec)) {
		$help_grid->RowCnt++;
		if ($help->CurrentAction == "gridadd" || $help->CurrentAction == "gridedit" || $help->CurrentAction == "F") {
			$help_grid->RowIndex++;
			$objForm->Index = $help_grid->RowIndex;
			if ($objForm->HasValue($help_grid->FormActionName))
				$help_grid->RowAction = strval($objForm->GetValue($help_grid->FormActionName));
			elseif ($help->CurrentAction == "gridadd")
				$help_grid->RowAction = "insert";
			else
				$help_grid->RowAction = "";
		}

		// Set up key count
		$help_grid->KeyCount = $help_grid->RowIndex;

		// Init row class and style
		$help->ResetAttrs();
		$help->CssClass = "";
		if ($help->CurrentAction == "gridadd") {
			if ($help->CurrentMode == "copy") {
				$help_grid->LoadRowValues($help_grid->Recordset); // Load row values
				$help_grid->SetRecordKey($help_grid->RowOldKey, $help_grid->Recordset); // Set old record key
			} else {
				$help_grid->LoadDefaultValues(); // Load default values
				$help_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$help_grid->LoadRowValues($help_grid->Recordset); // Load row values
		}
		$help->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($help->CurrentAction == "gridadd") // Grid add
			$help->RowType = EW_ROWTYPE_ADD; // Render add
		if ($help->CurrentAction == "gridadd" && $help->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$help_grid->RestoreCurrentRowFormValues($help_grid->RowIndex); // Restore form values
		if ($help->CurrentAction == "gridedit") { // Grid edit
			if ($help->EventCancelled) {
				$help_grid->RestoreCurrentRowFormValues($help_grid->RowIndex); // Restore form values
			}
			if ($help_grid->RowAction == "insert")
				$help->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$help->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($help->CurrentAction == "gridedit" && ($help->RowType == EW_ROWTYPE_EDIT || $help->RowType == EW_ROWTYPE_ADD) && $help->EventCancelled) // Update failed
			$help_grid->RestoreCurrentRowFormValues($help_grid->RowIndex); // Restore form values
		if ($help->RowType == EW_ROWTYPE_EDIT) // Edit row
			$help_grid->EditRowCnt++;
		if ($help->CurrentAction == "F") // Confirm row
			$help_grid->RestoreCurrentRowFormValues($help_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$help->RowAttrs = array_merge($help->RowAttrs, array('data-rowindex'=>$help_grid->RowCnt, 'id'=>'r' . $help_grid->RowCnt . '_help', 'data-rowtype'=>$help->RowType));

		// Render row
		$help_grid->RenderRow();

		// Render list options
		$help_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($help_grid->RowAction <> "delete" && $help_grid->RowAction <> "insertdelete" && !($help_grid->RowAction == "insert" && $help->CurrentAction == "F" && $help_grid->EmptyRow())) {
?>
	<tr<?php echo $help->RowAttributes() ?>>
<?php

// Render list options (body, left)
$help_grid->ListOptions->Render("body", "left", $help_grid->RowCnt);
?>
	<?php if ($help->Topic->Visible) { // Topic ?>
		<td data-name="Topic"<?php echo $help->Topic->CellAttributes() ?>>
<?php if ($help->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Topic" class="form-group help_Topic">
<input type="text" data-table="help" data-field="x_Topic" name="x<?php echo $help_grid->RowIndex ?>_Topic" id="x<?php echo $help_grid->RowIndex ?>_Topic" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($help->Topic->getPlaceHolder()) ?>" value="<?php echo $help->Topic->EditValue ?>"<?php echo $help->Topic->EditAttributes() ?>>
</span>
<input type="hidden" data-table="help" data-field="x_Topic" name="o<?php echo $help_grid->RowIndex ?>_Topic" id="o<?php echo $help_grid->RowIndex ?>_Topic" value="<?php echo ew_HtmlEncode($help->Topic->OldValue) ?>">
<?php } ?>
<?php if ($help->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Topic" class="form-group help_Topic">
<input type="text" data-table="help" data-field="x_Topic" name="x<?php echo $help_grid->RowIndex ?>_Topic" id="x<?php echo $help_grid->RowIndex ?>_Topic" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($help->Topic->getPlaceHolder()) ?>" value="<?php echo $help->Topic->EditValue ?>"<?php echo $help->Topic->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($help->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Topic" class="help_Topic">
<span<?php echo $help->Topic->ViewAttributes() ?>>
<?php echo $help->Topic->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="help" data-field="x_Topic" name="x<?php echo $help_grid->RowIndex ?>_Topic" id="x<?php echo $help_grid->RowIndex ?>_Topic" value="<?php echo ew_HtmlEncode($help->Topic->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Topic" name="o<?php echo $help_grid->RowIndex ?>_Topic" id="o<?php echo $help_grid->RowIndex ?>_Topic" value="<?php echo ew_HtmlEncode($help->Topic->OldValue) ?>">
<?php } ?>
<a id="<?php echo $help_grid->PageObjName . "_row_" . $help_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($help->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="help" data-field="x_Help_ID" name="x<?php echo $help_grid->RowIndex ?>_Help_ID" id="x<?php echo $help_grid->RowIndex ?>_Help_ID" value="<?php echo ew_HtmlEncode($help->Help_ID->CurrentValue) ?>">
<input type="hidden" data-table="help" data-field="x_Help_ID" name="o<?php echo $help_grid->RowIndex ?>_Help_ID" id="o<?php echo $help_grid->RowIndex ?>_Help_ID" value="<?php echo ew_HtmlEncode($help->Help_ID->OldValue) ?>">
<?php } ?>
<?php if ($help->RowType == EW_ROWTYPE_EDIT || $help->CurrentMode == "edit") { ?>
<input type="hidden" data-table="help" data-field="x_Help_ID" name="x<?php echo $help_grid->RowIndex ?>_Help_ID" id="x<?php echo $help_grid->RowIndex ?>_Help_ID" value="<?php echo ew_HtmlEncode($help->Help_ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($help->Description->Visible) { // Description ?>
		<td data-name="Description"<?php echo $help->Description->CellAttributes() ?>>
<?php if ($help->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Description" class="form-group help_Description">
<textarea data-table="help" data-field="x_Description" name="x<?php echo $help_grid->RowIndex ?>_Description" id="x<?php echo $help_grid->RowIndex ?>_Description" cols="50" rows="6" placeholder="<?php echo ew_HtmlEncode($help->Description->getPlaceHolder()) ?>"<?php echo $help->Description->EditAttributes() ?>><?php echo $help->Description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="help" data-field="x_Description" name="o<?php echo $help_grid->RowIndex ?>_Description" id="o<?php echo $help_grid->RowIndex ?>_Description" value="<?php echo ew_HtmlEncode($help->Description->OldValue) ?>">
<?php } ?>
<?php if ($help->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Description" class="form-group help_Description">
<textarea data-table="help" data-field="x_Description" name="x<?php echo $help_grid->RowIndex ?>_Description" id="x<?php echo $help_grid->RowIndex ?>_Description" cols="50" rows="6" placeholder="<?php echo ew_HtmlEncode($help->Description->getPlaceHolder()) ?>"<?php echo $help->Description->EditAttributes() ?>><?php echo $help->Description->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($help->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Description" class="help_Description">
<span<?php echo $help->Description->ViewAttributes() ?>>
<?php echo $help->Description->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="help" data-field="x_Description" name="x<?php echo $help_grid->RowIndex ?>_Description" id="x<?php echo $help_grid->RowIndex ?>_Description" value="<?php echo ew_HtmlEncode($help->Description->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Description" name="o<?php echo $help_grid->RowIndex ?>_Description" id="o<?php echo $help_grid->RowIndex ?>_Description" value="<?php echo ew_HtmlEncode($help->Description->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($help->Category->Visible) { // Category ?>
		<td data-name="Category"<?php echo $help->Category->CellAttributes() ?>>
<?php if ($help->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($help->Category->getSessionValue() <> "") { ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Category" class="form-group help_Category">
<span<?php echo $help->Category->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $help->Category->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $help_grid->RowIndex ?>_Category" name="x<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo ew_HtmlEncode($help->Category->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Category" class="form-group help_Category">
<select data-table="help" data-field="x_Category" data-value-separator="<?php echo ew_HtmlEncode(is_array($help->Category->DisplayValueSeparator) ? json_encode($help->Category->DisplayValueSeparator) : $help->Category->DisplayValueSeparator) ?>" id="x<?php echo $help_grid->RowIndex ?>_Category" name="x<?php echo $help_grid->RowIndex ?>_Category"<?php echo $help->Category->EditAttributes() ?>>
<?php
if (is_array($help->Category->EditValue)) {
	$arwrk = $help->Category->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($help->Category->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $help->Category->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($help->Category->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($help->Category->CurrentValue) ?>" selected><?php echo $help->Category->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $help->Category->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Category_ID`, `Category_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `help_categories`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Category_ID`, `Category_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `help_categories`";
		$sWhereWrk = "";
		break;
}
$help->Category->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$help->Category->LookupFilters += array("f0" => "`Category_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$help->Lookup_Selecting($help->Category, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $help->Category->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $help_grid->RowIndex ?>_Category" id="s_x<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo $help->Category->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="help" data-field="x_Category" name="o<?php echo $help_grid->RowIndex ?>_Category" id="o<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo ew_HtmlEncode($help->Category->OldValue) ?>">
<?php } ?>
<?php if ($help->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($help->Category->getSessionValue() <> "") { ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Category" class="form-group help_Category">
<span<?php echo $help->Category->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $help->Category->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $help_grid->RowIndex ?>_Category" name="x<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo ew_HtmlEncode($help->Category->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Category" class="form-group help_Category">
<select data-table="help" data-field="x_Category" data-value-separator="<?php echo ew_HtmlEncode(is_array($help->Category->DisplayValueSeparator) ? json_encode($help->Category->DisplayValueSeparator) : $help->Category->DisplayValueSeparator) ?>" id="x<?php echo $help_grid->RowIndex ?>_Category" name="x<?php echo $help_grid->RowIndex ?>_Category"<?php echo $help->Category->EditAttributes() ?>>
<?php
if (is_array($help->Category->EditValue)) {
	$arwrk = $help->Category->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($help->Category->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $help->Category->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($help->Category->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($help->Category->CurrentValue) ?>" selected><?php echo $help->Category->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $help->Category->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Category_ID`, `Category_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `help_categories`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Category_ID`, `Category_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `help_categories`";
		$sWhereWrk = "";
		break;
}
$help->Category->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$help->Category->LookupFilters += array("f0" => "`Category_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$help->Lookup_Selecting($help->Category, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $help->Category->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $help_grid->RowIndex ?>_Category" id="s_x<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo $help->Category->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($help->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $help_grid->RowCnt ?>_help_Category" class="help_Category">
<span<?php echo $help->Category->ViewAttributes() ?>>
<?php echo $help->Category->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="help" data-field="x_Category" name="x<?php echo $help_grid->RowIndex ?>_Category" id="x<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo ew_HtmlEncode($help->Category->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Category" name="o<?php echo $help_grid->RowIndex ?>_Category" id="o<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo ew_HtmlEncode($help->Category->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$help_grid->ListOptions->Render("body", "right", $help_grid->RowCnt);
?>
	</tr>
<?php if ($help->RowType == EW_ROWTYPE_ADD || $help->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fhelpgrid.UpdateOpts(<?php echo $help_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($help->CurrentAction <> "gridadd" || $help->CurrentMode == "copy")
		if (!$help_grid->Recordset->EOF) $help_grid->Recordset->MoveNext();
}
?>
<?php
	if ($help->CurrentMode == "add" || $help->CurrentMode == "copy" || $help->CurrentMode == "edit") {
		$help_grid->RowIndex = '$rowindex$';
		$help_grid->LoadDefaultValues();

		// Set row properties
		$help->ResetAttrs();
		$help->RowAttrs = array_merge($help->RowAttrs, array('data-rowindex'=>$help_grid->RowIndex, 'id'=>'r0_help', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($help->RowAttrs["class"], "ewTemplate");
		$help->RowType = EW_ROWTYPE_ADD;

		// Render row
		$help_grid->RenderRow();

		// Render list options
		$help_grid->RenderListOptions();
		$help_grid->StartRowCnt = 0;
?>
	<tr<?php echo $help->RowAttributes() ?>>
<?php

// Render list options (body, left)
$help_grid->ListOptions->Render("body", "left", $help_grid->RowIndex);
?>
	<?php if ($help->Topic->Visible) { // Topic ?>
		<td data-name="Topic">
<?php if ($help->CurrentAction <> "F") { ?>
<span id="el$rowindex$_help_Topic" class="form-group help_Topic">
<input type="text" data-table="help" data-field="x_Topic" name="x<?php echo $help_grid->RowIndex ?>_Topic" id="x<?php echo $help_grid->RowIndex ?>_Topic" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($help->Topic->getPlaceHolder()) ?>" value="<?php echo $help->Topic->EditValue ?>"<?php echo $help->Topic->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_help_Topic" class="form-group help_Topic">
<span<?php echo $help->Topic->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $help->Topic->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="help" data-field="x_Topic" name="x<?php echo $help_grid->RowIndex ?>_Topic" id="x<?php echo $help_grid->RowIndex ?>_Topic" value="<?php echo ew_HtmlEncode($help->Topic->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="help" data-field="x_Topic" name="o<?php echo $help_grid->RowIndex ?>_Topic" id="o<?php echo $help_grid->RowIndex ?>_Topic" value="<?php echo ew_HtmlEncode($help->Topic->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($help->Description->Visible) { // Description ?>
		<td data-name="Description">
<?php if ($help->CurrentAction <> "F") { ?>
<span id="el$rowindex$_help_Description" class="form-group help_Description">
<textarea data-table="help" data-field="x_Description" name="x<?php echo $help_grid->RowIndex ?>_Description" id="x<?php echo $help_grid->RowIndex ?>_Description" cols="50" rows="6" placeholder="<?php echo ew_HtmlEncode($help->Description->getPlaceHolder()) ?>"<?php echo $help->Description->EditAttributes() ?>><?php echo $help->Description->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_help_Description" class="form-group help_Description">
<span<?php echo $help->Description->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $help->Description->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="help" data-field="x_Description" name="x<?php echo $help_grid->RowIndex ?>_Description" id="x<?php echo $help_grid->RowIndex ?>_Description" value="<?php echo ew_HtmlEncode($help->Description->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="help" data-field="x_Description" name="o<?php echo $help_grid->RowIndex ?>_Description" id="o<?php echo $help_grid->RowIndex ?>_Description" value="<?php echo ew_HtmlEncode($help->Description->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($help->Category->Visible) { // Category ?>
		<td data-name="Category">
<?php if ($help->CurrentAction <> "F") { ?>
<?php if ($help->Category->getSessionValue() <> "") { ?>
<span id="el$rowindex$_help_Category" class="form-group help_Category">
<span<?php echo $help->Category->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $help->Category->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $help_grid->RowIndex ?>_Category" name="x<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo ew_HtmlEncode($help->Category->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_help_Category" class="form-group help_Category">
<select data-table="help" data-field="x_Category" data-value-separator="<?php echo ew_HtmlEncode(is_array($help->Category->DisplayValueSeparator) ? json_encode($help->Category->DisplayValueSeparator) : $help->Category->DisplayValueSeparator) ?>" id="x<?php echo $help_grid->RowIndex ?>_Category" name="x<?php echo $help_grid->RowIndex ?>_Category"<?php echo $help->Category->EditAttributes() ?>>
<?php
if (is_array($help->Category->EditValue)) {
	$arwrk = $help->Category->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($help->Category->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $help->Category->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($help->Category->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($help->Category->CurrentValue) ?>" selected><?php echo $help->Category->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $help->Category->OldValue = "";
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Category_ID`, `Category_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `help_categories`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Category_ID`, `Category_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `help_categories`";
		$sWhereWrk = "";
		break;
}
$help->Category->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$help->Category->LookupFilters += array("f0" => "`Category_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$help->Lookup_Selecting($help->Category, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $help->Category->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $help_grid->RowIndex ?>_Category" id="s_x<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo $help->Category->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_help_Category" class="form-group help_Category">
<span<?php echo $help->Category->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $help->Category->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="help" data-field="x_Category" name="x<?php echo $help_grid->RowIndex ?>_Category" id="x<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo ew_HtmlEncode($help->Category->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="help" data-field="x_Category" name="o<?php echo $help_grid->RowIndex ?>_Category" id="o<?php echo $help_grid->RowIndex ?>_Category" value="<?php echo ew_HtmlEncode($help->Category->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$help_grid->ListOptions->Render("body", "right", $help_grid->RowCnt);
?>
<script type="text/javascript">
fhelpgrid.UpdateOpts(<?php echo $help_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($help->CurrentMode == "add" || $help->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $help_grid->FormKeyCountName ?>" id="<?php echo $help_grid->FormKeyCountName ?>" value="<?php echo $help_grid->KeyCount ?>">
<?php echo $help_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($help->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $help_grid->FormKeyCountName ?>" id="<?php echo $help_grid->FormKeyCountName ?>" value="<?php echo $help_grid->KeyCount ?>">
<?php echo $help_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($help->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fhelpgrid">
</div>
<?php

// Close recordset
if ($help_grid->Recordset)
	$help_grid->Recordset->Close();
?>
<?php if ($help_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($help_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($help_grid->TotalRecs == 0 && $help->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($help_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($help->Export == "") { ?>
<script type="text/javascript">
fhelpgrid.Init();
</script>
<?php } ?>
<?php
$help_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$help_grid->Page_Terminate();
?>
