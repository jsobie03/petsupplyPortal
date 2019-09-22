<?php

// Global variable for table object
$a_purchases_detail = NULL;

//
// Table class for a_purchases_detail
//
class ca_purchases_detail extends cTable {
	var $Purchase_ID;
	var $Purchase_Number;
	var $Supplier_Number;
	var $Stock_Item;
	var $Purchasing_Quantity;
	var $Purchasing_Price;
	var $Selling_Price;
	var $Purchasing_Total_Amount;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'a_purchases_detail';
		$this->TableName = 'a_purchases_detail';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`a_purchases_detail`";
		$this->DBID = 'DB';

		// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
        $this->ExportAll = MS_EXPORT_RECORD_OPTIONS;

// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Purchase_ID
		$this->Purchase_ID = new cField('a_purchases_detail', 'a_purchases_detail', 'x_Purchase_ID', 'Purchase_ID', '`Purchase_ID`', '`Purchase_ID`', 3, -1, FALSE, '`Purchase_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Purchase_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Purchase_ID'] = &$this->Purchase_ID;

		// Purchase_Number
		$this->Purchase_Number = new cField('a_purchases_detail', 'a_purchases_detail', 'x_Purchase_Number', 'Purchase_Number', '`Purchase_Number`', '`Purchase_Number`', 200, -1, FALSE, '`Purchase_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Purchase_Number'] = &$this->Purchase_Number;

		// Supplier_Number
		$this->Supplier_Number = new cField('a_purchases_detail', 'a_purchases_detail', 'x_Supplier_Number', 'Supplier_Number', '`Supplier_Number`', '`Supplier_Number`', 200, -1, FALSE, '`Supplier_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Supplier_Number'] = &$this->Supplier_Number;

		// Stock_Item
		$this->Stock_Item = new cField('a_purchases_detail', 'a_purchases_detail', 'x_Stock_Item', 'Stock_Item', '`Stock_Item`', '`Stock_Item`', 200, -1, FALSE, '`Stock_Item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Stock_Item'] = &$this->Stock_Item;

		// Purchasing_Quantity
		$this->Purchasing_Quantity = new cField('a_purchases_detail', 'a_purchases_detail', 'x_Purchasing_Quantity', 'Purchasing_Quantity', '`Purchasing_Quantity`', '`Purchasing_Quantity`', 5, -1, FALSE, '`Purchasing_Quantity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Purchasing_Quantity'] = &$this->Purchasing_Quantity;

		// Purchasing_Price
		$this->Purchasing_Price = new cField('a_purchases_detail', 'a_purchases_detail', 'x_Purchasing_Price', 'Purchasing_Price', '`Purchasing_Price`', '`Purchasing_Price`', 5, -1, FALSE, '`Purchasing_Price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Purchasing_Price'] = &$this->Purchasing_Price;

		// Selling_Price
		$this->Selling_Price = new cField('a_purchases_detail', 'a_purchases_detail', 'x_Selling_Price', 'Selling_Price', '`Selling_Price`', '`Selling_Price`', 5, -1, FALSE, '`Selling_Price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Selling_Price'] = &$this->Selling_Price;

		// Purchasing_Total_Amount
		$this->Purchasing_Total_Amount = new cField('a_purchases_detail', 'a_purchases_detail', 'x_Purchasing_Total_Amount', 'Purchasing_Total_Amount', '`Purchasing_Total_Amount`', '`Purchasing_Total_Amount`', 5, -1, FALSE, '`Purchasing_Total_Amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Purchasing_Total_Amount'] = &$this->Purchasing_Total_Amount;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "a_purchases") {
			if ($this->Purchase_Number->getSessionValue() <> "")
				$sMasterFilter .= "`Purchase_Number`=" . ew_QuotedValue($this->Purchase_Number->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "a_purchases") {
			if ($this->Purchase_Number->getSessionValue() <> "")
				$sDetailFilter .= "`Purchase_Number`=" . ew_QuotedValue($this->Purchase_Number->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_a_purchases() {
		return "`Purchase_Number`='@Purchase_Number@'";
	}

	// Detail filter
	function SqlDetailFilter_a_purchases() {
		return "`Purchase_Number`='@Purchase_Number@'";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`a_purchases_detail`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('Purchase_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('Purchase_ID', $this->DBID) . '=' . ew_QuotedValue($rs['Purchase_ID'], $this->Purchase_ID->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`Purchase_ID` = @Purchase_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Purchase_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Purchase_ID@", ew_AdjustSql($this->Purchase_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "a_purchases_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "a_purchases_detaillist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("a_purchases_detailview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("a_purchases_detailview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "a_purchases_detailadd.php?" . $this->UrlParm($parm);
		else
			$url = "a_purchases_detailadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("a_purchases_detailedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("a_purchases_detailadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("a_purchases_detaildelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "a_purchases" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Purchase_Number=" . urlencode($this->Purchase_Number->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Purchase_ID:" . ew_VarToJson($this->Purchase_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Purchase_ID->CurrentValue)) {
			$sUrl .= "Purchase_ID=" . urlencode($this->Purchase_ID->CurrentValue);
		} else {
			return "javascript:alertify.alert(ewLanguage.Phrase('InvalidRecord'), function (ok) { }).set('title', ewLanguage.Phrase('AlertifyAlert'));"; // Modification Alertify by Masino Sinaga, October 14, 2013
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["Purchase_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["Purchase_ID"]);
			elseif (isset($_GET["Purchase_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["Purchase_ID"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->Purchase_ID->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->Purchase_ID->setDbValue($rs->fields('Purchase_ID'));
		$this->Purchase_Number->setDbValue($rs->fields('Purchase_Number'));
		$this->Supplier_Number->setDbValue($rs->fields('Supplier_Number'));
		$this->Stock_Item->setDbValue($rs->fields('Stock_Item'));
		$this->Purchasing_Quantity->setDbValue($rs->fields('Purchasing_Quantity'));
		$this->Purchasing_Price->setDbValue($rs->fields('Purchasing_Price'));
		$this->Selling_Price->setDbValue($rs->fields('Selling_Price'));
		$this->Purchasing_Total_Amount->setDbValue($rs->fields('Purchasing_Total_Amount'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Purchase_ID

		$this->Purchase_ID->CellCssStyle = "white-space: nowrap;";

		// Purchase_Number
		// Supplier_Number
		// Stock_Item
		// Purchasing_Quantity
		// Purchasing_Price
		// Selling_Price
		// Purchasing_Total_Amount
		// Purchase_ID

		$this->Purchase_ID->ViewValue = $this->Purchase_ID->CurrentValue;
		$this->Purchase_ID->ViewCustomAttributes = "";

		// Purchase_Number
		$this->Purchase_Number->ViewValue = $this->Purchase_Number->CurrentValue;
		$this->Purchase_Number->ViewCustomAttributes = "";

		// Supplier_Number
		if (strval($this->Supplier_Number->CurrentValue) <> "") {
			$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier_Number->CurrentValue, EW_DATATYPE_STRING, "");
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
		$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Supplier_Number->ViewValue = $this->Supplier_Number->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Supplier_Number->ViewValue = $this->Supplier_Number->CurrentValue;
			}
		} else {
			$this->Supplier_Number->ViewValue = NULL;
		}
		$this->Supplier_Number->ViewCustomAttributes = "";

		// Stock_Item
		if (strval($this->Stock_Item->CurrentValue) <> "") {
			$sFilterWrk = "`Stock_Number`" . ew_SearchString("=", $this->Stock_Item->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
				$sWhereWrk = "";
				break;
		}
		$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Stock_Item, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Stock_Item->ViewValue = $this->Stock_Item->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Stock_Item->ViewValue = $this->Stock_Item->CurrentValue;
			}
		} else {
			$this->Stock_Item->ViewValue = NULL;
		}
		$this->Stock_Item->ViewCustomAttributes = "";

		// Purchasing_Quantity
		$this->Purchasing_Quantity->ViewValue = $this->Purchasing_Quantity->CurrentValue;
		$this->Purchasing_Quantity->ViewValue = ew_FormatNumber($this->Purchasing_Quantity->ViewValue, 0, -1, -1, -1);
		$this->Purchasing_Quantity->CellCssStyle .= "text-align: right;";
		$this->Purchasing_Quantity->ViewCustomAttributes = "";

		// Purchasing_Price
		$this->Purchasing_Price->ViewValue = $this->Purchasing_Price->CurrentValue;
		$this->Purchasing_Price->ViewValue = ew_FormatCurrency($this->Purchasing_Price->ViewValue, 2, -2, -2, -2);
		$this->Purchasing_Price->CellCssStyle .= "text-align: right;";
		$this->Purchasing_Price->ViewCustomAttributes = "";

		// Selling_Price
		$this->Selling_Price->ViewValue = $this->Selling_Price->CurrentValue;
		$this->Selling_Price->ViewValue = ew_FormatCurrency($this->Selling_Price->ViewValue, 2, -2, -2, -2);
		$this->Selling_Price->CellCssStyle .= "text-align: right;";
		$this->Selling_Price->ViewCustomAttributes = "";

		// Purchasing_Total_Amount
		$this->Purchasing_Total_Amount->ViewValue = $this->Purchasing_Total_Amount->CurrentValue;
		$this->Purchasing_Total_Amount->ViewValue = ew_FormatCurrency($this->Purchasing_Total_Amount->ViewValue, 2, -2, -2, -2);
		$this->Purchasing_Total_Amount->CellCssStyle .= "text-align: right;";
		$this->Purchasing_Total_Amount->ViewCustomAttributes = "";

		// Purchase_ID
		$this->Purchase_ID->LinkCustomAttributes = "";
		$this->Purchase_ID->HrefValue = "";
		$this->Purchase_ID->TooltipValue = "";

		// Purchase_Number
		$this->Purchase_Number->LinkCustomAttributes = "";
		$this->Purchase_Number->HrefValue = "";
		$this->Purchase_Number->TooltipValue = "";

		// Supplier_Number
		$this->Supplier_Number->LinkCustomAttributes = "";
		$this->Supplier_Number->HrefValue = "";
		$this->Supplier_Number->TooltipValue = "";

		// Stock_Item
		$this->Stock_Item->LinkCustomAttributes = "";
		$this->Stock_Item->HrefValue = "";
		$this->Stock_Item->TooltipValue = "";

		// Purchasing_Quantity
		$this->Purchasing_Quantity->LinkCustomAttributes = "";
		$this->Purchasing_Quantity->HrefValue = "";
		$this->Purchasing_Quantity->TooltipValue = "";

		// Purchasing_Price
		$this->Purchasing_Price->LinkCustomAttributes = "";
		$this->Purchasing_Price->HrefValue = "";
		$this->Purchasing_Price->TooltipValue = "";

		// Selling_Price
		$this->Selling_Price->LinkCustomAttributes = "";
		$this->Selling_Price->HrefValue = "";
		$this->Selling_Price->TooltipValue = "";

		// Purchasing_Total_Amount
		$this->Purchasing_Total_Amount->LinkCustomAttributes = "";
		$this->Purchasing_Total_Amount->HrefValue = "";
		$this->Purchasing_Total_Amount->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Purchase_ID
		$this->Purchase_ID->EditAttrs["class"] = "form-control";
		$this->Purchase_ID->EditCustomAttributes = "";
		$this->Purchase_ID->EditValue = $this->Purchase_ID->CurrentValue;
		$this->Purchase_ID->ViewCustomAttributes = "";

		// Purchase_Number
		$this->Purchase_Number->EditAttrs["class"] = "form-control";
		$this->Purchase_Number->EditCustomAttributes = "";
		if ($this->Purchase_Number->getSessionValue() <> "") {
			$this->Purchase_Number->CurrentValue = $this->Purchase_Number->getSessionValue();
		$this->Purchase_Number->ViewValue = $this->Purchase_Number->CurrentValue;
		$this->Purchase_Number->ViewCustomAttributes = "";
		} else {
		$this->Purchase_Number->EditValue = $this->Purchase_Number->CurrentValue;
		$this->Purchase_Number->PlaceHolder = ew_RemoveHtml($this->Purchase_Number->FldCaption());
		}

		// Supplier_Number
		$this->Supplier_Number->EditAttrs["class"] = "form-control";
		$this->Supplier_Number->EditCustomAttributes = "";

		// Stock_Item
		$this->Stock_Item->EditAttrs["class"] = "form-control";
		$this->Stock_Item->EditCustomAttributes = "";

		// Purchasing_Quantity
		$this->Purchasing_Quantity->EditAttrs["class"] = "form-control";
		$this->Purchasing_Quantity->EditCustomAttributes = "";
		$this->Purchasing_Quantity->EditValue = $this->Purchasing_Quantity->CurrentValue;
		$this->Purchasing_Quantity->PlaceHolder = ew_RemoveHtml($this->Purchasing_Quantity->FldCaption());
		if (strval($this->Purchasing_Quantity->EditValue) <> "" && is_numeric($this->Purchasing_Quantity->EditValue)) $this->Purchasing_Quantity->EditValue = ew_FormatNumber($this->Purchasing_Quantity->EditValue, -2, -1, -1, -1);

		// Purchasing_Price
		$this->Purchasing_Price->EditAttrs["class"] = "form-control";
		$this->Purchasing_Price->EditCustomAttributes = "";
		$this->Purchasing_Price->EditValue = $this->Purchasing_Price->CurrentValue;
		$this->Purchasing_Price->PlaceHolder = ew_RemoveHtml($this->Purchasing_Price->FldCaption());
		if (strval($this->Purchasing_Price->EditValue) <> "" && is_numeric($this->Purchasing_Price->EditValue)) $this->Purchasing_Price->EditValue = ew_FormatNumber($this->Purchasing_Price->EditValue, -2, -2, -2, -2);

		// Selling_Price
		$this->Selling_Price->EditAttrs["class"] = "form-control";
		$this->Selling_Price->EditCustomAttributes = "";
		$this->Selling_Price->EditValue = $this->Selling_Price->CurrentValue;
		$this->Selling_Price->PlaceHolder = ew_RemoveHtml($this->Selling_Price->FldCaption());
		if (strval($this->Selling_Price->EditValue) <> "" && is_numeric($this->Selling_Price->EditValue)) $this->Selling_Price->EditValue = ew_FormatNumber($this->Selling_Price->EditValue, -2, -2, -2, -2);

		// Purchasing_Total_Amount
		$this->Purchasing_Total_Amount->EditAttrs["class"] = "form-control";
		$this->Purchasing_Total_Amount->EditCustomAttributes = "";
		$this->Purchasing_Total_Amount->EditValue = $this->Purchasing_Total_Amount->CurrentValue;
		$this->Purchasing_Total_Amount->PlaceHolder = ew_RemoveHtml($this->Purchasing_Total_Amount->FldCaption());
		if (strval($this->Purchasing_Total_Amount->EditValue) <> "" && is_numeric($this->Purchasing_Total_Amount->EditValue)) $this->Purchasing_Total_Amount->EditValue = ew_FormatNumber($this->Purchasing_Total_Amount->EditValue, -2, -2, -2, -2);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			if (is_numeric($this->Purchasing_Quantity->CurrentValue))
				$this->Purchasing_Quantity->Total += $this->Purchasing_Quantity->CurrentValue; // Accumulate total
			if (is_numeric($this->Purchasing_Total_Amount->CurrentValue))
				$this->Purchasing_Total_Amount->Total += $this->Purchasing_Total_Amount->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->Purchasing_Quantity->CurrentValue = $this->Purchasing_Quantity->Total;
			$this->Purchasing_Quantity->ViewValue = $this->Purchasing_Quantity->CurrentValue;
			$this->Purchasing_Quantity->ViewValue = ew_FormatNumber($this->Purchasing_Quantity->ViewValue, 0, -1, -1, -1);
			$this->Purchasing_Quantity->CellCssStyle .= "text-align: right;";
			$this->Purchasing_Quantity->ViewCustomAttributes = "";
			$this->Purchasing_Quantity->HrefValue = ""; // Clear href value
			$this->Purchasing_Total_Amount->CurrentValue = $this->Purchasing_Total_Amount->Total;
			$this->Purchasing_Total_Amount->ViewValue = $this->Purchasing_Total_Amount->CurrentValue;
			$this->Purchasing_Total_Amount->ViewValue = ew_FormatCurrency($this->Purchasing_Total_Amount->ViewValue, 2, -2, -2, -2);
			$this->Purchasing_Total_Amount->CellCssStyle .= "text-align: right;";
			$this->Purchasing_Total_Amount->ViewCustomAttributes = "";
			$this->Purchasing_Total_Amount->HrefValue = ""; // Clear href value

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		global $Language, $gsLanguage;
		if (MS_USE_TABLE_SETTING_FOR_EXPORT_FIELD_CAPTION) {
			define("EW_EXPORT_FIELD_CAPTION", FALSE, FALSE);
		}
		if (MS_USE_TABLE_SETTING_FOR_EXPORT_ORIGINAL_VALUE) {
			define("EW_EXPORT_ORIGINAL_VALUE", FALSE, FALSE);
		}
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->Purchase_ID->Exportable) $Doc->ExportCaption($this->Purchase_ID);
					if ($this->Purchase_Number->Exportable) $Doc->ExportCaption($this->Purchase_Number);
					if ($this->Supplier_Number->Exportable) $Doc->ExportCaption($this->Supplier_Number);
					if ($this->Stock_Item->Exportable) $Doc->ExportCaption($this->Stock_Item);
					if ($this->Purchasing_Quantity->Exportable) $Doc->ExportCaption($this->Purchasing_Quantity);
					if ($this->Purchasing_Price->Exportable) $Doc->ExportCaption($this->Purchasing_Price);
					if ($this->Selling_Price->Exportable) $Doc->ExportCaption($this->Selling_Price);
					if ($this->Purchasing_Total_Amount->Exportable) $Doc->ExportCaption($this->Purchasing_Total_Amount);
				} else {

				// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
					if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) { 
						if (MS_RECORD_NUMBER_LONG_CAPTION_COLUMN_TABLE) {
							$Doc->ExportText($Language->Phrase('LongRecNo'));
						} else {
							$Doc->ExportText($Language->Phrase('ShortRecNo'));
						}
					}

				// End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
					if ($this->Supplier_Number->Exportable) $Doc->ExportCaption($this->Supplier_Number);
					if ($this->Stock_Item->Exportable) $Doc->ExportCaption($this->Stock_Item);
					if ($this->Purchasing_Quantity->Exportable) $Doc->ExportCaption($this->Purchasing_Quantity);
					if ($this->Purchasing_Price->Exportable) $Doc->ExportCaption($this->Purchasing_Price);
					if ($this->Selling_Price->Exportable) $Doc->ExportCaption($this->Selling_Price);
					if ($this->Purchasing_Total_Amount->Exportable) $Doc->ExportCaption($this->Purchasing_Total_Amount);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);
				$this->AggregateListRowValues(); // Aggregate row values

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->Purchase_ID->Exportable) $Doc->ExportField($this->Purchase_ID);
						if ($this->Purchase_Number->Exportable) $Doc->ExportField($this->Purchase_Number);
						if ($this->Supplier_Number->Exportable) $Doc->ExportField($this->Supplier_Number);
						if ($this->Stock_Item->Exportable) $Doc->ExportField($this->Stock_Item);
						if ($this->Purchasing_Quantity->Exportable) $Doc->ExportField($this->Purchasing_Quantity);
						if ($this->Purchasing_Price->Exportable) $Doc->ExportField($this->Purchasing_Price);
						if ($this->Selling_Price->Exportable) $Doc->ExportField($this->Selling_Price);
						if ($this->Purchasing_Total_Amount->Exportable) $Doc->ExportField($this->Purchasing_Total_Amount);
					} else {

					// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) {  
							$Doc->ExportText(ew_FormatSeqNo(CurrentPage()->getStartRecordNumber()+$RowCnt-1));
						}

					 // End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if ($this->Supplier_Number->Exportable) $Doc->ExportField($this->Supplier_Number);
						if ($this->Stock_Item->Exportable) $Doc->ExportField($this->Stock_Item);
						if ($this->Purchasing_Quantity->Exportable) $Doc->ExportField($this->Purchasing_Quantity);
						if ($this->Purchasing_Price->Exportable) $Doc->ExportField($this->Purchasing_Price);
						if ($this->Selling_Price->Exportable) $Doc->ExportField($this->Selling_Price);
						if ($this->Purchasing_Total_Amount->Exportable) $Doc->ExportField($this->Purchasing_Total_Amount);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}

		// Export aggregates (horizontal format only)
		if ($Doc->Horizontal) {
			$this->RowType = EW_ROWTYPE_AGGREGATE;
			$this->ResetAttrs();
			$this->AggregateListRow();
			if (!$Doc->ExportCustom) {
				$Doc->BeginExportRow(-1);

				// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
				if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST && $Doc->Horizontal) {
					$Doc->ExportText(''); // Add an additional column in the aggregate row if necessary
				}

				// End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
				$Doc->ExportAggregate($this->Supplier_Number, '');
				$Doc->ExportAggregate($this->Stock_Item, '');
				$Doc->ExportAggregate($this->Purchasing_Quantity, 'TOTAL');
				$Doc->ExportAggregate($this->Purchasing_Price, '');
				$Doc->ExportAggregate($this->Selling_Price, '');
				$Doc->ExportAggregate($this->Purchasing_Total_Amount, 'TOTAL');
				$Doc->EndExportRow();
			}
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;
		if (preg_match('/^x(\d)*_Stock_Item$/', $id)) {
			$conn = &$this->Connection();
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Purchasing_Price` AS FIELD0, `Selling_Price` AS FIELD1 FROM `a_stock_items`";
					$sWhereWrk = "(`Stock_Number` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
					break;
				default:
					$sSqlWrk = "SELECT `Purchasing_Price` AS FIELD0, `Selling_Price` AS FIELD1 FROM `a_stock_items`";
					$sWhereWrk = "(`Stock_Number` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
					break;
			}
			$lookuptblfilter = (isset($_GET["Supplier_Number"])) ? "`Supplier_Number` = '".$_GET["Supplier_Number"]."' " : "";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->Stock_Item, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Purchasing_Price->setDbValue($rs->fields[0]);
					$this->Selling_Price->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Purchasing_Price->AutoFillOriginalValue) ? $this->Purchasing_Price->CurrentValue : $this->Purchasing_Price->EditValue;
					$ar[] = ($this->Selling_Price->AutoFillOriginalValue) ? $this->Selling_Price->CurrentValue : $this->Selling_Price->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		$purchase_number = ($rsold["Purchase_Number"] <> "") ? $rsold["Purchase_Number"] : $rsnew["Purchase_Number"];
		$stock_item = ($rsold["Stock_Item"] <> "") ? $rsold["Stock_Item"] : $rsnew["Stock_Item"];
		$check_stock = ew_ExecuteScalar("SELECT Stock_Item FROM a_purchases_detail WHERE Purchase_Number = '".$purchase_number."' AND Stock_Item = '".$stock_item."'");
		if ($check_stock == $stock_item) {
			$this->setFailureMessage("Stock <strong>".$check_stock."</strong> already exists in Database. Please choose another stock!");
			return FALSE;
		}
		if (isset($_SESSION["Detail_Supplier_Number"]) && $_SESSION["Detail_Supplier_Number"] <> "") {
			$rsnew["Supplier_Number"] = $_SESSION["Detail_Supplier_Number"];
			$_SESSION["Detail_Supplier_Number"] = "";
		}
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		ew_Execute("UPDATE a_stock_items SET Quantity = Quantity + ".$rsnew["Purchasing_Quantity"]." WHERE Stock_Number = '".$rsnew["Stock_Item"]."'");
		$purchasing_total = ew_ExecuteScalar("SELECT SUM(Purchasing_Total_Amount) FROM a_purchases_detail WHERE Purchase_Number = '".$rsnew["Purchase_Number"]."'");
		ew_Execute("UPDATE a_purchases SET Total_Amount = ".$purchasing_total." WHERE Purchase_Number = '".$rsnew["Purchase_Number"]."'");
		$total_payment = ew_ExecuteScalar("SELECT Total_Payment FROM a_purchases WHERE Purchase_Number = '".$rsnew["Purchase_Number"]."'");
		$total_amount = ew_ExecuteScalar("SELECT Total_Amount FROM a_purchases WHERE Purchase_Number = '".$rsnew["Purchase_Number"]."'");
		$total_balance = $total_amount - $total_payment;
		ew_Execute("UPDATE a_purchases SET Total_Balance = ".$total_balance." WHERE Purchase_Number = '".$rsnew["Purchase_Number"]."'");
		if ($total_balance <> 0) {
			$supplier_balance = ew_ExecuteScalar("SELECT SUM(Total_Balance) FROM a_purchases WHERE Supplier_ID = '".$rsnew["Supplier_Number"]."'");
			ew_Execute("UPDATE a_suppliers SET Balance =  ".$supplier_balance." WHERE Supplier_Number = '".$rsnew["Supplier_Number"]."'");
		}
		if (CheckStockAvailability($rsnew["Supplier_Number"]) > 0) {
			ew_Execute("UPDATE a_suppliers SET Is_Stock_Available = 'Y' WHERE Supplier_Number = '".$rsnew["Supplier_Number"]."'");
		}
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		if ($rsold["Stock_Item"] <> $rsnew["Stock_Item"]) {
			$purchase_number = ($rsold["Purchase_Number"] <> "") ? $rsold["Purchase_Number"] : $rsnew["Purchase_Number"];
			$stock_item = $rsnew["Stock_Item"];
			$check_stock = ew_ExecuteScalar("SELECT Stock_Item FROM a_purchases_detail WHERE Purchase_Number = '".$purchase_number."' AND Stock_Item = '".$stock_item."'");
			if ($check_stock == $stock_item) {
				$this->setFailureMessage("Stock <strong>".$check_stock."</strong> already exists in Database. Please choose another stock!");
				return FALSE;
			}
		}
		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
		$purchasing_total = ew_ExecuteScalar("SELECT SUM(Purchasing_Total_Amount) FROM a_purchases_detail WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
		ew_Execute("UPDATE a_purchases SET Total_Amount = ".$purchasing_total." WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
		$total_payment = ew_ExecuteScalar("SELECT Total_Payment FROM a_purchases WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
		$total_amount = ew_ExecuteScalar("SELECT Total_Amount FROM a_purchases WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
		$total_balance = $total_amount - $total_payment;
		ew_Execute("UPDATE a_purchases SET Total_Balance = ".$total_balance." WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
		if ($rsold["Purchasing_Quantity"] <> $rsnew["Purchasing_Quantity"]) {
			$purchasing_total = ew_ExecuteScalar("SELECT SUM(Purchasing_Total_Amount) FROM a_purchases_detail WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
			ew_Execute("UPDATE a_purchases SET Total_Amount = ".$purchasing_total." WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
			$total_payment = ew_ExecuteScalar("SELECT Total_Payment FROM a_purchases WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
			$total_amount = ew_ExecuteScalar("SELECT Total_Amount FROM a_purchases WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
			$total_balance = $total_amount - $total_payment;
			ew_Execute("UPDATE a_purchases SET Total_Balance = ".$total_balance." WHERE Purchase_Number = '".$rsold["Purchase_Number"]."'");
		}
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		$rs_new = $this->GetGridFormValues(); // Get the form values of the new records as an array of array
		$_SESSION["Purchasing_Total_Amount"] = 0;
		foreach ($rs_new as $row) // Loop through the new records
			$_SESSION["Purchasing_Total_Amount"] += intval($row["Purchasing_Total_Amount"]);
		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
		$total_amount = $_SESSION["Purchasing_Total_Amount"]; 
		ew_Execute("UPDATE a_purchases SET Total_Amount = ".$total_amount." WHERE Purchase_Number = '".$rsnew["Purchase_Number"]."'");
		$total_payment = ew_ExecuteScalar("SELECT Total_Payment FROM a_purchases WHERE Purchase_Number = '".$rsnew["Purchase_Number"]."'");
		$total_balance = $total_amount - $total_payment;
		ew_Execute("UPDATE a_purchases SET Total_Balance = ".$total_balance." WHERE Purchase_Number = '".$rsnew["Purchase_Number"]."'");
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
		$purchasing_total = ew_ExecuteScalar("SELECT SUM(Purchasing_Total_Amount) FROM a_purchases_detail WHERE Purchase_Number = '".$rs["Purchase_Number"]."'");
		$val_purchasing_total = ($purchasing_total > 0) ? $purchasing_total : 0;
		ew_Execute("UPDATE a_purchases SET Total_Amount = ".$val_purchasing_total." WHERE Purchase_Number = '".$rs["Purchase_Number"]."'");
		$total_payment = ew_ExecuteScalar("SELECT Total_Payment FROM a_purchases WHERE Purchase_Number = '".$rs["Purchase_Number"]."'");
		$total_amount = ew_ExecuteScalar("SELECT Total_Amount FROM a_purchases WHERE Purchase_Number = '".$rs["Purchase_Number"]."'");
		$total_balance = $total_amount - $total_payment;
		ew_Execute("UPDATE a_purchases SET Total_Balance = ".$total_balance." WHERE Purchase_Number = '".$rs["Purchase_Number"]."'");
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

		$this->Purchasing_Quantity->EditAttrs["onkeyup"] = "CalculateGrid(event);GetBalanceTotal(event);";
		$this->Purchasing_Quantity->EditAttrs["onclick"] = "CalculateGrid(event);GetBalanceTotal(event);";
		$this->Purchasing_Quantity->EditAttrs["onfocus"] = "SetFocusPurchasingQuantity(event);";
		$this->Purchasing_Price->EditAttrs["onkeyup"] = "CalculateGrid(event);GetBalanceTotal(event);";
		$this->Purchasing_Price->EditAttrs["onclick"] = "CalculateGrid(event);GetBalanceTotal(event);";
		$this->Purchasing_Total_Amount->EditAttrs["onblur"] = "CalculateGrid(event);GetBalanceTotal(event);";
		if ( (CurrentPageID() == "edit" && !isset($_GET["showdetail"])) || (CurrentPageID() == "add" && !isset($_GET["showdetail"])) ) {
			$this->Purchasing_Quantity->EditAttrs["onkeyup"] = "CalculateSinglePurchasing();";
			$this->Purchasing_Price->EditAttrs["onchange"] = "CalculateSinglePurchasing();";
		}
		if (CurrentPageID() == "list") {
			$this->Purchasing_Quantity->CellCssStyle = "text-align: right;";
			$this->Purchasing_Price->CellCssStyle = "text-align: right;";
			$this->Selling_Price->CellCssStyle = "text-align: right;";
			$this->Purchasing_Total_Amount->CellCssStyle = "text-align: right;";
		}

		// array_shift($this->Supplier_Number->EditValue);
		if ($_SESSION["Detail_Purchase_Number"] <> "" && ew_CurrentPage()=="a_purchases_detailadd.php") {
			$sSql = "SELECT Supplier_Number FROM a_purchases_detail WHERE Purchase_Number = '".$_SESSION["Detail_Purchase_Number"]."'";
			$val = ew_ExecuteScalar($sSql);
			$_SESSION["Detail_Supplier_Number"] = $val; 
			$this->Supplier_Number->CurrentValue = $val;
			$this->Supplier_Number->Disabled = TRUE;
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
