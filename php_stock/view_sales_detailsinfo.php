<?php

// Global variable for table object
$view_sales_details = NULL;

//
// Table class for view_sales_details
//
class cview_sales_details extends cTable {
	var $Sales_ID;
	var $Sales_Number;
	var $Supplier_Number;
	var $Stock_Item;
	var $Sales_Quantity;
	var $Purchasing_Price;
	var $Sales_Price;
	var $Sales_Total_Amount;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'view_sales_details';
		$this->TableName = 'view_sales_details';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`view_sales_details`";
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

		// Sales_ID
		$this->Sales_ID = new cField('view_sales_details', 'view_sales_details', 'x_Sales_ID', 'Sales_ID', '`Sales_ID`', '`Sales_ID`', 3, -1, FALSE, '`Sales_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Sales_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Sales_ID'] = &$this->Sales_ID;

		// Sales_Number
		$this->Sales_Number = new cField('view_sales_details', 'view_sales_details', 'x_Sales_Number', 'Sales_Number', '`Sales_Number`', '`Sales_Number`', 200, -1, FALSE, '`Sales_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Sales_Number'] = &$this->Sales_Number;

		// Supplier_Number
		$this->Supplier_Number = new cField('view_sales_details', 'view_sales_details', 'x_Supplier_Number', 'Supplier_Number', '`Supplier_Number`', '`Supplier_Number`', 200, -1, FALSE, '`Supplier_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Supplier_Number'] = &$this->Supplier_Number;

		// Stock_Item
		$this->Stock_Item = new cField('view_sales_details', 'view_sales_details', 'x_Stock_Item', 'Stock_Item', '`Stock_Item`', '`Stock_Item`', 200, -1, FALSE, '`Stock_Item`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Stock_Item'] = &$this->Stock_Item;

		// Sales_Quantity
		$this->Sales_Quantity = new cField('view_sales_details', 'view_sales_details', 'x_Sales_Quantity', 'Sales_Quantity', '`Sales_Quantity`', '`Sales_Quantity`', 5, -1, FALSE, '`Sales_Quantity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Sales_Quantity'] = &$this->Sales_Quantity;

		// Purchasing_Price
		$this->Purchasing_Price = new cField('view_sales_details', 'view_sales_details', 'x_Purchasing_Price', 'Purchasing_Price', '`Purchasing_Price`', '`Purchasing_Price`', 5, -1, FALSE, '`Purchasing_Price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Purchasing_Price'] = &$this->Purchasing_Price;

		// Sales_Price
		$this->Sales_Price = new cField('view_sales_details', 'view_sales_details', 'x_Sales_Price', 'Sales_Price', '`Sales_Price`', '`Sales_Price`', 5, -1, FALSE, '`Sales_Price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Sales_Price'] = &$this->Sales_Price;

		// Sales_Total_Amount
		$this->Sales_Total_Amount = new cField('view_sales_details', 'view_sales_details', 'x_Sales_Total_Amount', 'Sales_Total_Amount', '`Sales_Total_Amount`', '`Sales_Total_Amount`', 5, -1, FALSE, '`Sales_Total_Amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Sales_Total_Amount'] = &$this->Sales_Total_Amount;
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
		if ($this->getCurrentMasterTable() == "a_stock_items") {
			if ($this->Stock_Item->getSessionValue() <> "")
				$sMasterFilter .= "`Stock_Number`=" . ew_QuotedValue($this->Stock_Item->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "a_stock_items") {
			if ($this->Stock_Item->getSessionValue() <> "")
				$sDetailFilter .= "`Stock_Item`=" . ew_QuotedValue($this->Stock_Item->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_a_stock_items() {
		return "`Stock_Number`='@Stock_Number@'";
	}

	// Detail filter
	function SqlDetailFilter_a_stock_items() {
		return "`Stock_Item`='@Stock_Item@'";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`view_sales_details`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Sales_ID` DESC";
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
			if (array_key_exists('Sales_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('Sales_ID', $this->DBID) . '=' . ew_QuotedValue($rs['Sales_ID'], $this->Sales_ID->FldDataType, $this->DBID));
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
		return "`Sales_ID` = @Sales_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Sales_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Sales_ID@", ew_AdjustSql($this->Sales_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "view_sales_detailslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "view_sales_detailslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("view_sales_detailsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("view_sales_detailsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "view_sales_detailsadd.php?" . $this->UrlParm($parm);
		else
			$url = "view_sales_detailsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("view_sales_detailsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("view_sales_detailsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("view_sales_detailsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "a_stock_items" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Stock_Number=" . urlencode($this->Stock_Item->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Sales_ID:" . ew_VarToJson($this->Sales_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Sales_ID->CurrentValue)) {
			$sUrl .= "Sales_ID=" . urlencode($this->Sales_ID->CurrentValue);
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
			if ($isPost && isset($_POST["Sales_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["Sales_ID"]);
			elseif (isset($_GET["Sales_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["Sales_ID"]);
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
			$this->Sales_ID->CurrentValue = $key;
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
		$this->Sales_ID->setDbValue($rs->fields('Sales_ID'));
		$this->Sales_Number->setDbValue($rs->fields('Sales_Number'));
		$this->Supplier_Number->setDbValue($rs->fields('Supplier_Number'));
		$this->Stock_Item->setDbValue($rs->fields('Stock_Item'));
		$this->Sales_Quantity->setDbValue($rs->fields('Sales_Quantity'));
		$this->Purchasing_Price->setDbValue($rs->fields('Purchasing_Price'));
		$this->Sales_Price->setDbValue($rs->fields('Sales_Price'));
		$this->Sales_Total_Amount->setDbValue($rs->fields('Sales_Total_Amount'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Sales_ID

		$this->Sales_ID->CellCssStyle = "white-space: nowrap;";

		// Sales_Number
		// Supplier_Number
		// Stock_Item
		// Sales_Quantity
		// Purchasing_Price
		// Sales_Price
		// Sales_Total_Amount
		// Sales_ID

		$this->Sales_ID->ViewValue = $this->Sales_ID->CurrentValue;
		$this->Sales_ID->ViewCustomAttributes = "";

		// Sales_Number
		$this->Sales_Number->ViewValue = $this->Sales_Number->CurrentValue;
		$this->Sales_Number->ViewCustomAttributes = "";

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
		$lookuptblfilter = "`Is_Stock_Available` = 'Y'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Supplier_ID`";
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
		$lookuptblfilter = "`Quantity` > 0";
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

		// Sales_Quantity
		$this->Sales_Quantity->ViewValue = $this->Sales_Quantity->CurrentValue;
		$this->Sales_Quantity->ViewValue = ew_FormatNumber($this->Sales_Quantity->ViewValue, 0, -2, -2, -2);
		$this->Sales_Quantity->CellCssStyle .= "text-align: right;";
		$this->Sales_Quantity->ViewCustomAttributes = "";

		// Purchasing_Price
		$this->Purchasing_Price->ViewValue = $this->Purchasing_Price->CurrentValue;
		$this->Purchasing_Price->ViewValue = ew_FormatCurrency($this->Purchasing_Price->ViewValue, 2, -2, -2, -2);
		$this->Purchasing_Price->CellCssStyle .= "text-align: right;";
		$this->Purchasing_Price->ViewCustomAttributes = "";

		// Sales_Price
		$this->Sales_Price->ViewValue = $this->Sales_Price->CurrentValue;
		$this->Sales_Price->ViewValue = ew_FormatCurrency($this->Sales_Price->ViewValue, 2, -2, -2, -2);
		$this->Sales_Price->CellCssStyle .= "text-align: right;";
		$this->Sales_Price->ViewCustomAttributes = "";

		// Sales_Total_Amount
		$this->Sales_Total_Amount->ViewValue = $this->Sales_Total_Amount->CurrentValue;
		$this->Sales_Total_Amount->ViewValue = ew_FormatCurrency($this->Sales_Total_Amount->ViewValue, 2, -2, -2, -2);
		$this->Sales_Total_Amount->CellCssStyle .= "text-align: right;";
		$this->Sales_Total_Amount->ViewCustomAttributes = "";

		// Sales_ID
		$this->Sales_ID->LinkCustomAttributes = "";
		$this->Sales_ID->HrefValue = "";
		$this->Sales_ID->TooltipValue = "";

		// Sales_Number
		$this->Sales_Number->LinkCustomAttributes = "";
		$this->Sales_Number->HrefValue = "";
		$this->Sales_Number->TooltipValue = "";

		// Supplier_Number
		$this->Supplier_Number->LinkCustomAttributes = "";
		$this->Supplier_Number->HrefValue = "";
		$this->Supplier_Number->TooltipValue = "";

		// Stock_Item
		$this->Stock_Item->LinkCustomAttributes = "";
		$this->Stock_Item->HrefValue = "";
		$this->Stock_Item->TooltipValue = "";

		// Sales_Quantity
		$this->Sales_Quantity->LinkCustomAttributes = "";
		$this->Sales_Quantity->HrefValue = "";
		$this->Sales_Quantity->TooltipValue = "";

		// Purchasing_Price
		$this->Purchasing_Price->LinkCustomAttributes = "";
		$this->Purchasing_Price->HrefValue = "";
		$this->Purchasing_Price->TooltipValue = "";

		// Sales_Price
		$this->Sales_Price->LinkCustomAttributes = "";
		$this->Sales_Price->HrefValue = "";
		$this->Sales_Price->TooltipValue = "";

		// Sales_Total_Amount
		$this->Sales_Total_Amount->LinkCustomAttributes = "";
		$this->Sales_Total_Amount->HrefValue = "";
		$this->Sales_Total_Amount->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Sales_ID
		$this->Sales_ID->EditAttrs["class"] = "form-control";
		$this->Sales_ID->EditCustomAttributes = "";
		$this->Sales_ID->EditValue = $this->Sales_ID->CurrentValue;
		$this->Sales_ID->ViewCustomAttributes = "";

		// Sales_Number
		$this->Sales_Number->EditAttrs["class"] = "form-control";
		$this->Sales_Number->EditCustomAttributes = "";
		$this->Sales_Number->EditValue = $this->Sales_Number->CurrentValue;
		$this->Sales_Number->PlaceHolder = ew_RemoveHtml($this->Sales_Number->FldCaption());

		// Supplier_Number
		$this->Supplier_Number->EditAttrs["class"] = "form-control";
		$this->Supplier_Number->EditCustomAttributes = "";

		// Stock_Item
		$this->Stock_Item->EditAttrs["class"] = "form-control";
		$this->Stock_Item->EditCustomAttributes = "";
		if ($this->Stock_Item->getSessionValue() <> "") {
			$this->Stock_Item->CurrentValue = $this->Stock_Item->getSessionValue();
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
		$lookuptblfilter = "`Quantity` > 0";
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
		} else {
		}

		// Sales_Quantity
		$this->Sales_Quantity->EditAttrs["class"] = "form-control";
		$this->Sales_Quantity->EditCustomAttributes = "";
		$this->Sales_Quantity->EditValue = $this->Sales_Quantity->CurrentValue;
		$this->Sales_Quantity->PlaceHolder = ew_RemoveHtml($this->Sales_Quantity->FldCaption());
		if (strval($this->Sales_Quantity->EditValue) <> "" && is_numeric($this->Sales_Quantity->EditValue)) $this->Sales_Quantity->EditValue = ew_FormatNumber($this->Sales_Quantity->EditValue, -2, -2, -2, -2);

		// Purchasing_Price
		$this->Purchasing_Price->EditAttrs["class"] = "form-control";
		$this->Purchasing_Price->EditCustomAttributes = "";
		$this->Purchasing_Price->EditValue = $this->Purchasing_Price->CurrentValue;
		$this->Purchasing_Price->PlaceHolder = ew_RemoveHtml($this->Purchasing_Price->FldCaption());
		if (strval($this->Purchasing_Price->EditValue) <> "" && is_numeric($this->Purchasing_Price->EditValue)) $this->Purchasing_Price->EditValue = ew_FormatNumber($this->Purchasing_Price->EditValue, -2, -2, -2, -2);

		// Sales_Price
		$this->Sales_Price->EditAttrs["class"] = "form-control";
		$this->Sales_Price->EditCustomAttributes = "";
		$this->Sales_Price->EditValue = $this->Sales_Price->CurrentValue;
		$this->Sales_Price->PlaceHolder = ew_RemoveHtml($this->Sales_Price->FldCaption());
		if (strval($this->Sales_Price->EditValue) <> "" && is_numeric($this->Sales_Price->EditValue)) $this->Sales_Price->EditValue = ew_FormatNumber($this->Sales_Price->EditValue, -2, -2, -2, -2);

		// Sales_Total_Amount
		$this->Sales_Total_Amount->EditAttrs["class"] = "form-control";
		$this->Sales_Total_Amount->EditCustomAttributes = "";
		$this->Sales_Total_Amount->EditValue = $this->Sales_Total_Amount->CurrentValue;
		$this->Sales_Total_Amount->PlaceHolder = ew_RemoveHtml($this->Sales_Total_Amount->FldCaption());
		if (strval($this->Sales_Total_Amount->EditValue) <> "" && is_numeric($this->Sales_Total_Amount->EditValue)) $this->Sales_Total_Amount->EditValue = ew_FormatNumber($this->Sales_Total_Amount->EditValue, -2, -2, -2, -2);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			if (is_numeric($this->Sales_Quantity->CurrentValue))
				$this->Sales_Quantity->Total += $this->Sales_Quantity->CurrentValue; // Accumulate total
			if (is_numeric($this->Sales_Total_Amount->CurrentValue))
				$this->Sales_Total_Amount->Total += $this->Sales_Total_Amount->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->Sales_Quantity->CurrentValue = $this->Sales_Quantity->Total;
			$this->Sales_Quantity->ViewValue = $this->Sales_Quantity->CurrentValue;
			$this->Sales_Quantity->ViewValue = ew_FormatNumber($this->Sales_Quantity->ViewValue, 0, -2, -2, -2);
			$this->Sales_Quantity->CellCssStyle .= "text-align: right;";
			$this->Sales_Quantity->ViewCustomAttributes = "";
			$this->Sales_Quantity->HrefValue = ""; // Clear href value
			$this->Sales_Total_Amount->CurrentValue = $this->Sales_Total_Amount->Total;
			$this->Sales_Total_Amount->ViewValue = $this->Sales_Total_Amount->CurrentValue;
			$this->Sales_Total_Amount->ViewValue = ew_FormatCurrency($this->Sales_Total_Amount->ViewValue, 2, -2, -2, -2);
			$this->Sales_Total_Amount->CellCssStyle .= "text-align: right;";
			$this->Sales_Total_Amount->ViewCustomAttributes = "";
			$this->Sales_Total_Amount->HrefValue = ""; // Clear href value

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
					if ($this->Sales_ID->Exportable) $Doc->ExportCaption($this->Sales_ID);
					if ($this->Sales_Number->Exportable) $Doc->ExportCaption($this->Sales_Number);
					if ($this->Supplier_Number->Exportable) $Doc->ExportCaption($this->Supplier_Number);
					if ($this->Stock_Item->Exportable) $Doc->ExportCaption($this->Stock_Item);
					if ($this->Sales_Quantity->Exportable) $Doc->ExportCaption($this->Sales_Quantity);
					if ($this->Purchasing_Price->Exportable) $Doc->ExportCaption($this->Purchasing_Price);
					if ($this->Sales_Price->Exportable) $Doc->ExportCaption($this->Sales_Price);
					if ($this->Sales_Total_Amount->Exportable) $Doc->ExportCaption($this->Sales_Total_Amount);
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
					if ($this->Sales_Number->Exportable) $Doc->ExportCaption($this->Sales_Number);
					if ($this->Supplier_Number->Exportable) $Doc->ExportCaption($this->Supplier_Number);
					if ($this->Stock_Item->Exportable) $Doc->ExportCaption($this->Stock_Item);
					if ($this->Sales_Quantity->Exportable) $Doc->ExportCaption($this->Sales_Quantity);
					if ($this->Purchasing_Price->Exportable) $Doc->ExportCaption($this->Purchasing_Price);
					if ($this->Sales_Price->Exportable) $Doc->ExportCaption($this->Sales_Price);
					if ($this->Sales_Total_Amount->Exportable) $Doc->ExportCaption($this->Sales_Total_Amount);
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
						if ($this->Sales_ID->Exportable) $Doc->ExportField($this->Sales_ID);
						if ($this->Sales_Number->Exportable) $Doc->ExportField($this->Sales_Number);
						if ($this->Supplier_Number->Exportable) $Doc->ExportField($this->Supplier_Number);
						if ($this->Stock_Item->Exportable) $Doc->ExportField($this->Stock_Item);
						if ($this->Sales_Quantity->Exportable) $Doc->ExportField($this->Sales_Quantity);
						if ($this->Purchasing_Price->Exportable) $Doc->ExportField($this->Purchasing_Price);
						if ($this->Sales_Price->Exportable) $Doc->ExportField($this->Sales_Price);
						if ($this->Sales_Total_Amount->Exportable) $Doc->ExportField($this->Sales_Total_Amount);
					} else {

					// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) {  
							$Doc->ExportText(ew_FormatSeqNo(CurrentPage()->getStartRecordNumber()+$RowCnt-1));
						}

					 // End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if ($this->Sales_Number->Exportable) $Doc->ExportField($this->Sales_Number);
						if ($this->Supplier_Number->Exportable) $Doc->ExportField($this->Supplier_Number);
						if ($this->Stock_Item->Exportable) $Doc->ExportField($this->Stock_Item);
						if ($this->Sales_Quantity->Exportable) $Doc->ExportField($this->Sales_Quantity);
						if ($this->Purchasing_Price->Exportable) $Doc->ExportField($this->Purchasing_Price);
						if ($this->Sales_Price->Exportable) $Doc->ExportField($this->Sales_Price);
						if ($this->Sales_Total_Amount->Exportable) $Doc->ExportField($this->Sales_Total_Amount);
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
				$Doc->ExportAggregate($this->Sales_Number, '');
				$Doc->ExportAggregate($this->Supplier_Number, '');
				$Doc->ExportAggregate($this->Stock_Item, '');
				$Doc->ExportAggregate($this->Sales_Quantity, 'TOTAL');
				$Doc->ExportAggregate($this->Purchasing_Price, '');
				$Doc->ExportAggregate($this->Sales_Price, '');
				$Doc->ExportAggregate($this->Sales_Total_Amount, 'TOTAL');
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
			$lookuptblfilter = "`Quantity` > 0";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->Stock_Item, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->Purchasing_Price->setDbValue($rs->fields[0]);
					$this->Sales_Price->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->Purchasing_Price->AutoFillOriginalValue) ? $this->Purchasing_Price->CurrentValue : $this->Purchasing_Price->EditValue;
					$ar[] = ($this->Sales_Price->AutoFillOriginalValue) ? $this->Sales_Price->CurrentValue : $this->Sales_Price->EditValue;
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

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
