<?php

// Global variable for table object
$a_stock_items = NULL;

//
// Table class for a_stock_items
//
class ca_stock_items extends cTable {
	var $Stock_ID;
	var $Category;
	var $Supplier_Number;
	var $Stock_Number;
	var $Stock_Name;
	var $Unit_Of_Measurement;
	var $Purchasing_Price;
	var $Selling_Price;
	var $Quantity;
	var $Notes;
	var $Date_Added;
	var $Added_By;
	var $Date_Updated;
	var $Updated_By;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'a_stock_items';
		$this->TableName = 'a_stock_items';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`a_stock_items`";
		$this->DBID = 'DB';

		// Begin of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
        $this->ExportAll = MS_EXPORT_RECORD_OPTIONS;

// End of mofidication Flexibility of Export Records Options, by Masino Sinaga, May 14, 2012
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Stock_ID
		$this->Stock_ID = new cField('a_stock_items', 'a_stock_items', 'x_Stock_ID', 'Stock_ID', '`Stock_ID`', '`Stock_ID`', 3, -1, FALSE, '`Stock_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Stock_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Stock_ID'] = &$this->Stock_ID;

		// Category
		$this->Category = new cField('a_stock_items', 'a_stock_items', 'x_Category', 'Category', '`Category`', '`Category`', 3, -1, FALSE, '`Category`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Category->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Category'] = &$this->Category;

		// Supplier_Number
		$this->Supplier_Number = new cField('a_stock_items', 'a_stock_items', 'x_Supplier_Number', 'Supplier_Number', '`Supplier_Number`', '`Supplier_Number`', 200, -1, FALSE, '`Supplier_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Supplier_Number'] = &$this->Supplier_Number;

		// Stock_Number
		$this->Stock_Number = new cField('a_stock_items', 'a_stock_items', 'x_Stock_Number', 'Stock_Number', '`Stock_Number`', '`Stock_Number`', 200, -1, FALSE, '`Stock_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Stock_Number'] = &$this->Stock_Number;

		// Stock_Name
		$this->Stock_Name = new cField('a_stock_items', 'a_stock_items', 'x_Stock_Name', 'Stock_Name', '`Stock_Name`', '`Stock_Name`', 200, -1, FALSE, '`Stock_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Stock_Name'] = &$this->Stock_Name;

		// Unit_Of_Measurement
		$this->Unit_Of_Measurement = new cField('a_stock_items', 'a_stock_items', 'x_Unit_Of_Measurement', 'Unit_Of_Measurement', '`Unit_Of_Measurement`', '`Unit_Of_Measurement`', 200, -1, FALSE, '`Unit_Of_Measurement`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Unit_Of_Measurement'] = &$this->Unit_Of_Measurement;

		// Purchasing_Price
		$this->Purchasing_Price = new cField('a_stock_items', 'a_stock_items', 'x_Purchasing_Price', 'Purchasing_Price', '`Purchasing_Price`', '`Purchasing_Price`', 5, -1, FALSE, '`Purchasing_Price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Purchasing_Price'] = &$this->Purchasing_Price;

		// Selling_Price
		$this->Selling_Price = new cField('a_stock_items', 'a_stock_items', 'x_Selling_Price', 'Selling_Price', '`Selling_Price`', '`Selling_Price`', 5, -1, FALSE, '`Selling_Price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Selling_Price'] = &$this->Selling_Price;

		// Quantity
		$this->Quantity = new cField('a_stock_items', 'a_stock_items', 'x_Quantity', 'Quantity', '`Quantity`', '`Quantity`', 5, -1, FALSE, '`Quantity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Quantity'] = &$this->Quantity;

		// Notes
		$this->Notes = new cField('a_stock_items', 'a_stock_items', 'x_Notes', 'Notes', '`Notes`', '`Notes`', 200, -1, FALSE, '`Notes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Notes'] = &$this->Notes;

		// Date_Added
		$this->Date_Added = new cField('a_stock_items', 'a_stock_items', 'x_Date_Added', 'Date_Added', '`Date_Added`', 'DATE_FORMAT(`Date_Added`, \'%Y/%m/%d %H:%i:%s\')', 135, -1, FALSE, '`Date_Added`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Date_Added'] = &$this->Date_Added;

		// Added_By
		$this->Added_By = new cField('a_stock_items', 'a_stock_items', 'x_Added_By', 'Added_By', '`Added_By`', '`Added_By`', 200, -1, FALSE, '`Added_By`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Added_By'] = &$this->Added_By;

		// Date_Updated
		$this->Date_Updated = new cField('a_stock_items', 'a_stock_items', 'x_Date_Updated', 'Date_Updated', '`Date_Updated`', 'DATE_FORMAT(`Date_Updated`, \'%Y/%m/%d %H:%i:%s\')', 135, -1, FALSE, '`Date_Updated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Date_Updated'] = &$this->Date_Updated;

		// Updated_By
		$this->Updated_By = new cField('a_stock_items', 'a_stock_items', 'x_Updated_By', 'Updated_By', '`Updated_By`', '`Updated_By`', 200, -1, FALSE, '`Updated_By`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Updated_By'] = &$this->Updated_By;
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
		if ($this->getCurrentMasterTable() == "a_suppliers") {
			if ($this->Supplier_Number->getSessionValue() <> "")
				$sMasterFilter .= "`Supplier_Number`=" . ew_QuotedValue($this->Supplier_Number->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "a_suppliers") {
			if ($this->Supplier_Number->getSessionValue() <> "")
				$sDetailFilter .= "`Supplier_Number`=" . ew_QuotedValue($this->Supplier_Number->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_a_suppliers() {
		return "`Supplier_Number`='@Supplier_Number@'";
	}

	// Detail filter
	function SqlDetailFilter_a_suppliers() {
		return "`Supplier_Number`='@Supplier_Number@'";
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "view_sales_details") {
			$sDetailUrl = $GLOBALS["view_sales_details"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Stock_Number=" . urlencode($this->Stock_Number->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "view_purchases_details") {
			$sDetailUrl = $GLOBALS["view_purchases_details"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Stock_Number=" . urlencode($this->Stock_Number->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "a_stock_itemslist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`a_stock_items`";
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
			if (array_key_exists('Stock_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('Stock_ID', $this->DBID) . '=' . ew_QuotedValue($rs['Stock_ID'], $this->Stock_ID->FldDataType, $this->DBID));
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
		return "`Stock_ID` = @Stock_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Stock_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Stock_ID@", ew_AdjustSql($this->Stock_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "a_stock_itemslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "a_stock_itemslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("a_stock_itemsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("a_stock_itemsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "a_stock_itemsadd.php?" . $this->UrlParm($parm);
		else
			$url = "a_stock_itemsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("a_stock_itemsedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("a_stock_itemsedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("a_stock_itemsadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("a_stock_itemsadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("a_stock_itemsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "a_suppliers" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Supplier_Number=" . urlencode($this->Supplier_Number->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Stock_ID:" . ew_VarToJson($this->Stock_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Stock_ID->CurrentValue)) {
			$sUrl .= "Stock_ID=" . urlencode($this->Stock_ID->CurrentValue);
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
			if ($isPost && isset($_POST["Stock_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["Stock_ID"]);
			elseif (isset($_GET["Stock_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["Stock_ID"]);
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
			$this->Stock_ID->CurrentValue = $key;
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
		$this->Stock_ID->setDbValue($rs->fields('Stock_ID'));
		$this->Category->setDbValue($rs->fields('Category'));
		$this->Supplier_Number->setDbValue($rs->fields('Supplier_Number'));
		$this->Stock_Number->setDbValue($rs->fields('Stock_Number'));
		$this->Stock_Name->setDbValue($rs->fields('Stock_Name'));
		$this->Unit_Of_Measurement->setDbValue($rs->fields('Unit_Of_Measurement'));
		$this->Purchasing_Price->setDbValue($rs->fields('Purchasing_Price'));
		$this->Selling_Price->setDbValue($rs->fields('Selling_Price'));
		$this->Quantity->setDbValue($rs->fields('Quantity'));
		$this->Notes->setDbValue($rs->fields('Notes'));
		$this->Date_Added->setDbValue($rs->fields('Date_Added'));
		$this->Added_By->setDbValue($rs->fields('Added_By'));
		$this->Date_Updated->setDbValue($rs->fields('Date_Updated'));
		$this->Updated_By->setDbValue($rs->fields('Updated_By'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Stock_ID

		$this->Stock_ID->CellCssStyle = "white-space: nowrap;";

		// Category
		// Supplier_Number
		// Stock_Number
		// Stock_Name
		// Unit_Of_Measurement
		// Purchasing_Price
		// Selling_Price
		// Quantity
		// Notes
		// Date_Added
		// Added_By
		// Date_Updated
		// Updated_By
		// Stock_ID

		$this->Stock_ID->ViewValue = $this->Stock_ID->CurrentValue;
		$this->Stock_ID->ViewCustomAttributes = "";

		// Category
		if (strval($this->Category->CurrentValue) <> "") {
			$sFilterWrk = "`Category_ID`" . ew_SearchString("=", $this->Category->CurrentValue, EW_DATATYPE_NUMBER, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Category_ID`, `Category_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_categories`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Category_ID`, `Category_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_categories`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Category, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Category->ViewValue = $this->Category->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Category->ViewValue = $this->Category->CurrentValue;
			}
		} else {
			$this->Category->ViewValue = NULL;
		}
		$this->Category->ViewCustomAttributes = "";

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
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Supplier_Name`";
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

		// Stock_Number
		$this->Stock_Number->ViewValue = $this->Stock_Number->CurrentValue;
		$this->Stock_Number->ViewCustomAttributes = "";

		// Stock_Name
		$this->Stock_Name->ViewValue = $this->Stock_Name->CurrentValue;
		$this->Stock_Name->ViewCustomAttributes = "";

		// Unit_Of_Measurement
		if (strval($this->Unit_Of_Measurement->CurrentValue) <> "") {
			$sFilterWrk = "`UOM_ID`" . ew_SearchString("=", $this->Unit_Of_Measurement->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `UOM_ID`, `UOM_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_unit_of_measurement`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `UOM_ID`, `UOM_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_unit_of_measurement`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Unit_Of_Measurement, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Unit_Of_Measurement->ViewValue = $this->Unit_Of_Measurement->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Unit_Of_Measurement->ViewValue = $this->Unit_Of_Measurement->CurrentValue;
			}
		} else {
			$this->Unit_Of_Measurement->ViewValue = NULL;
		}
		$this->Unit_Of_Measurement->ViewCustomAttributes = "";

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

		// Quantity
		$this->Quantity->ViewValue = $this->Quantity->CurrentValue;
		$this->Quantity->ViewValue = ew_FormatNumber($this->Quantity->ViewValue, 0, -2, -2, -2);
		$this->Quantity->CellCssStyle .= "text-align: right;";
		$this->Quantity->ViewCustomAttributes = "";

		// Notes
		$this->Notes->ViewValue = $this->Notes->CurrentValue;
		$this->Notes->ViewCustomAttributes = "";

		// Date_Added
		$this->Date_Added->ViewValue = $this->Date_Added->CurrentValue;
		$this->Date_Added->ViewCustomAttributes = "";

		// Added_By
		$this->Added_By->ViewValue = $this->Added_By->CurrentValue;
		$this->Added_By->ViewCustomAttributes = "";

		// Date_Updated
		$this->Date_Updated->ViewValue = $this->Date_Updated->CurrentValue;
		$this->Date_Updated->ViewCustomAttributes = "";

		// Updated_By
		$this->Updated_By->ViewValue = $this->Updated_By->CurrentValue;
		$this->Updated_By->ViewCustomAttributes = "";

		// Stock_ID
		$this->Stock_ID->LinkCustomAttributes = "";
		$this->Stock_ID->HrefValue = "";
		$this->Stock_ID->TooltipValue = "";

		// Category
		$this->Category->LinkCustomAttributes = "";
		$this->Category->HrefValue = "";
		$this->Category->TooltipValue = "";

		// Supplier_Number
		$this->Supplier_Number->LinkCustomAttributes = "";
		$this->Supplier_Number->HrefValue = "";
		$this->Supplier_Number->TooltipValue = "";

		// Stock_Number
		$this->Stock_Number->LinkCustomAttributes = "";
		$this->Stock_Number->HrefValue = "";
		$this->Stock_Number->TooltipValue = "";

		// Stock_Name
		$this->Stock_Name->LinkCustomAttributes = "";
		$this->Stock_Name->HrefValue = "";
		$this->Stock_Name->TooltipValue = "";

		// Unit_Of_Measurement
		$this->Unit_Of_Measurement->LinkCustomAttributes = "";
		$this->Unit_Of_Measurement->HrefValue = "";
		$this->Unit_Of_Measurement->TooltipValue = "";

		// Purchasing_Price
		$this->Purchasing_Price->LinkCustomAttributes = "";
		$this->Purchasing_Price->HrefValue = "";
		$this->Purchasing_Price->TooltipValue = "";

		// Selling_Price
		$this->Selling_Price->LinkCustomAttributes = "";
		$this->Selling_Price->HrefValue = "";
		$this->Selling_Price->TooltipValue = "";

		// Quantity
		$this->Quantity->LinkCustomAttributes = "";
		$this->Quantity->HrefValue = "";
		$this->Quantity->TooltipValue = "";

		// Notes
		$this->Notes->LinkCustomAttributes = "";
		$this->Notes->HrefValue = "";
		$this->Notes->TooltipValue = "";

		// Date_Added
		$this->Date_Added->LinkCustomAttributes = "";
		$this->Date_Added->HrefValue = "";
		$this->Date_Added->TooltipValue = "";

		// Added_By
		$this->Added_By->LinkCustomAttributes = "";
		$this->Added_By->HrefValue = "";
		$this->Added_By->TooltipValue = "";

		// Date_Updated
		$this->Date_Updated->LinkCustomAttributes = "";
		$this->Date_Updated->HrefValue = "";
		$this->Date_Updated->TooltipValue = "";

		// Updated_By
		$this->Updated_By->LinkCustomAttributes = "";
		$this->Updated_By->HrefValue = "";
		$this->Updated_By->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Stock_ID
		$this->Stock_ID->EditAttrs["class"] = "form-control";
		$this->Stock_ID->EditCustomAttributes = "";
		$this->Stock_ID->EditValue = $this->Stock_ID->CurrentValue;
		$this->Stock_ID->ViewCustomAttributes = "";

		// Category
		$this->Category->EditAttrs["class"] = "form-control";
		$this->Category->EditCustomAttributes = "";

		// Supplier_Number
		$this->Supplier_Number->EditAttrs["class"] = "form-control";
		$this->Supplier_Number->EditCustomAttributes = "";
		if ($this->Supplier_Number->getSessionValue() <> "") {
			$this->Supplier_Number->CurrentValue = $this->Supplier_Number->getSessionValue();
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
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Supplier_Name`";
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
		} else {
		}

		// Stock_Number
		$this->Stock_Number->EditAttrs["class"] = "form-control";
		$this->Stock_Number->EditCustomAttributes = "";
		$this->Stock_Number->EditValue = $this->Stock_Number->CurrentValue;
		$this->Stock_Number->PlaceHolder = ew_RemoveHtml($this->Stock_Number->FldCaption());

		// Stock_Name
		$this->Stock_Name->EditAttrs["class"] = "form-control";
		$this->Stock_Name->EditCustomAttributes = "";
		$this->Stock_Name->EditValue = $this->Stock_Name->CurrentValue;
		$this->Stock_Name->PlaceHolder = ew_RemoveHtml($this->Stock_Name->FldCaption());

		// Unit_Of_Measurement
		$this->Unit_Of_Measurement->EditAttrs["class"] = "form-control";
		$this->Unit_Of_Measurement->EditCustomAttributes = "";

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

		// Quantity
		$this->Quantity->EditAttrs["class"] = "form-control";
		$this->Quantity->EditCustomAttributes = "";
		$this->Quantity->EditValue = $this->Quantity->CurrentValue;
		$this->Quantity->PlaceHolder = ew_RemoveHtml($this->Quantity->FldCaption());
		if (strval($this->Quantity->EditValue) <> "" && is_numeric($this->Quantity->EditValue)) $this->Quantity->EditValue = ew_FormatNumber($this->Quantity->EditValue, -2, -2, -2, -2);

		// Notes
		$this->Notes->EditAttrs["class"] = "form-control";
		$this->Notes->EditCustomAttributes = "";
		$this->Notes->EditValue = $this->Notes->CurrentValue;
		$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

		// Date_Added
		$this->Date_Added->EditAttrs["class"] = "form-control";
		$this->Date_Added->EditCustomAttributes = "";

		// Added_By
		$this->Added_By->EditAttrs["class"] = "form-control";
		$this->Added_By->EditCustomAttributes = "";

		// Date_Updated
		// Updated_By
		// Call Row Rendered event

		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

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
					if ($this->Stock_ID->Exportable) $Doc->ExportCaption($this->Stock_ID);
					if ($this->Category->Exportable) $Doc->ExportCaption($this->Category);
					if ($this->Supplier_Number->Exportable) $Doc->ExportCaption($this->Supplier_Number);
					if ($this->Stock_Number->Exportable) $Doc->ExportCaption($this->Stock_Number);
					if ($this->Stock_Name->Exportable) $Doc->ExportCaption($this->Stock_Name);
					if ($this->Unit_Of_Measurement->Exportable) $Doc->ExportCaption($this->Unit_Of_Measurement);
					if ($this->Purchasing_Price->Exportable) $Doc->ExportCaption($this->Purchasing_Price);
					if ($this->Selling_Price->Exportable) $Doc->ExportCaption($this->Selling_Price);
					if ($this->Quantity->Exportable) $Doc->ExportCaption($this->Quantity);
					if ($this->Notes->Exportable) $Doc->ExportCaption($this->Notes);
					if ($this->Date_Added->Exportable) $Doc->ExportCaption($this->Date_Added);
					if ($this->Added_By->Exportable) $Doc->ExportCaption($this->Added_By);
					if ($this->Date_Updated->Exportable) $Doc->ExportCaption($this->Date_Updated);
					if ($this->Updated_By->Exportable) $Doc->ExportCaption($this->Updated_By);
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
					if ($this->Stock_Number->Exportable) $Doc->ExportCaption($this->Stock_Number);
					if ($this->Stock_Name->Exportable) $Doc->ExportCaption($this->Stock_Name);
					if ($this->Purchasing_Price->Exportable) $Doc->ExportCaption($this->Purchasing_Price);
					if ($this->Selling_Price->Exportable) $Doc->ExportCaption($this->Selling_Price);
					if ($this->Quantity->Exportable) $Doc->ExportCaption($this->Quantity);
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

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->Stock_ID->Exportable) $Doc->ExportField($this->Stock_ID);
						if ($this->Category->Exportable) $Doc->ExportField($this->Category);
						if ($this->Supplier_Number->Exportable) $Doc->ExportField($this->Supplier_Number);
						if ($this->Stock_Number->Exportable) $Doc->ExportField($this->Stock_Number);
						if ($this->Stock_Name->Exportable) $Doc->ExportField($this->Stock_Name);
						if ($this->Unit_Of_Measurement->Exportable) $Doc->ExportField($this->Unit_Of_Measurement);
						if ($this->Purchasing_Price->Exportable) $Doc->ExportField($this->Purchasing_Price);
						if ($this->Selling_Price->Exportable) $Doc->ExportField($this->Selling_Price);
						if ($this->Quantity->Exportable) $Doc->ExportField($this->Quantity);
						if ($this->Notes->Exportable) $Doc->ExportField($this->Notes);
						if ($this->Date_Added->Exportable) $Doc->ExportField($this->Date_Added);
						if ($this->Added_By->Exportable) $Doc->ExportField($this->Added_By);
						if ($this->Date_Updated->Exportable) $Doc->ExportField($this->Date_Updated);
						if ($this->Updated_By->Exportable) $Doc->ExportField($this->Updated_By);
					} else {

					// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) {  
							$Doc->ExportText(ew_FormatSeqNo(CurrentPage()->getStartRecordNumber()+$RowCnt-1));
						}

					 // End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if ($this->Supplier_Number->Exportable) $Doc->ExportField($this->Supplier_Number);
						if ($this->Stock_Number->Exportable) $Doc->ExportField($this->Stock_Number);
						if ($this->Stock_Name->Exportable) $Doc->ExportField($this->Stock_Name);
						if ($this->Purchasing_Price->Exportable) $Doc->ExportField($this->Purchasing_Price);
						if ($this->Selling_Price->Exportable) $Doc->ExportField($this->Selling_Price);
						if ($this->Quantity->Exportable) $Doc->ExportField($this->Quantity);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

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

		$rsnew["Stock_Number"] = GetNextStockNumber();
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
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

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
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
		// Add mode (not confirm mode)

		if (CurrentPageID() == "add" && $this->CurrentAction != "F") {
			$this->Stock_Number->CurrentValue = GetNextStockNumber();
			$this->Stock_Number->EditValue = $this->Stock_Number->CurrentValue; 
			$this->Stock_Number->ReadOnly = TRUE; 
		}

		// Confirm mode
		if ($this->CurrentAction == "add" && $this->CurrentAction=="F") {
			$this->Stock_Number->ViewValue = $this->Stock_Number->CurrentValue;
		}
		if (CurrentPageID() == "list") {
			$this->Purchasing_Price->CellCssStyle = "text-align: right;";
			$this->Selling_Price->CellCssStyle = "text-align: right;";
			$this->Quantity->CellCssStyle = "text-align: right;";
		}	
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
