<?php

// Global variable for table object
$view_sales_outstandings = NULL;

//
// Table class for view_sales_outstandings
//
class cview_sales_outstandings extends cTable {
	var $Sales_ID;
	var $Sales_Number;
	var $Sales_Date;
	var $Customer_ID;
	var $Notes;
	var $Total_Amount;
	var $Final_Total_Amount;
	var $Total_Payment;
	var $Total_Balance;
	var $Discount_Type;
	var $Discount_Percentage;
	var $Discount_Amount;
	var $Tax_Percentage;
	var $Tax_Description;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'view_sales_outstandings';
		$this->TableName = 'view_sales_outstandings';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`view_sales_outstandings`";
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
		$this->Sales_ID = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Sales_ID', 'Sales_ID', '`Sales_ID`', '`Sales_ID`', 3, -1, FALSE, '`Sales_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Sales_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Sales_ID'] = &$this->Sales_ID;

		// Sales_Number
		$this->Sales_Number = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Sales_Number', 'Sales_Number', '`Sales_Number`', '`Sales_Number`', 200, -1, FALSE, '`Sales_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Sales_Number'] = &$this->Sales_Number;

		// Sales_Date
		$this->Sales_Date = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Sales_Date', 'Sales_Date', '`Sales_Date`', 'DATE_FORMAT(`Sales_Date`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`Sales_Date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Sales_Date->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Sales_Date'] = &$this->Sales_Date;

		// Customer_ID
		$this->Customer_ID = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Customer_ID', 'Customer_ID', '`Customer_ID`', '`Customer_ID`', 200, -1, FALSE, '`Customer_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Customer_ID'] = &$this->Customer_ID;

		// Notes
		$this->Notes = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Notes', 'Notes', '`Notes`', '`Notes`', 200, -1, FALSE, '`Notes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Notes'] = &$this->Notes;

		// Total_Amount
		$this->Total_Amount = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Total_Amount', 'Total_Amount', '`Total_Amount`', '`Total_Amount`', 5, -1, FALSE, '`Total_Amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Total_Amount'] = &$this->Total_Amount;

		// Final_Total_Amount
		$this->Final_Total_Amount = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Final_Total_Amount', 'Final_Total_Amount', '`Final_Total_Amount`', '`Final_Total_Amount`', 5, -1, FALSE, '`Final_Total_Amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Final_Total_Amount->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Final_Total_Amount'] = &$this->Final_Total_Amount;

		// Total_Payment
		$this->Total_Payment = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Total_Payment', 'Total_Payment', '`Total_Payment`', '`Total_Payment`', 5, -1, FALSE, '`Total_Payment`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Total_Payment->FldDefaultErrMsg = str_replace(array("%1", "%2"), array("1", "999999999"), $Language->Phrase("IncorrectRange"));
		$this->fields['Total_Payment'] = &$this->Total_Payment;

		// Total_Balance
		$this->Total_Balance = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Total_Balance', 'Total_Balance', '`Total_Balance`', '`Total_Balance`', 5, -1, FALSE, '`Total_Balance`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Total_Balance'] = &$this->Total_Balance;

		// Discount_Type
		$this->Discount_Type = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Discount_Type', 'Discount_Type', '`Discount_Type`', '`Discount_Type`', 200, -1, FALSE, '`Discount_Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Discount_Type->OptionCount = 2;
		$this->fields['Discount_Type'] = &$this->Discount_Type;

		// Discount_Percentage
		$this->Discount_Percentage = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Discount_Percentage', 'Discount_Percentage', '`Discount_Percentage`', '`Discount_Percentage`', 5, -1, FALSE, '`Discount_Percentage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Discount_Percentage->FldDefaultErrMsg = str_replace(array("%1", "%2"), array("0", "100"), $Language->Phrase("IncorrectRange"));
		$this->fields['Discount_Percentage'] = &$this->Discount_Percentage;

		// Discount_Amount
		$this->Discount_Amount = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Discount_Amount', 'Discount_Amount', '`Discount_Amount`', '`Discount_Amount`', 5, -1, FALSE, '`Discount_Amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Discount_Amount'] = &$this->Discount_Amount;

		// Tax_Percentage
		$this->Tax_Percentage = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Tax_Percentage', 'Tax_Percentage', '`Tax_Percentage`', '`Tax_Percentage`', 5, -1, FALSE, '`Tax_Percentage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tax_Percentage->FldDefaultErrMsg = str_replace(array("%1", "%2"), array("0", "100"), $Language->Phrase("IncorrectRange"));
		$this->fields['Tax_Percentage'] = &$this->Tax_Percentage;

		// Tax_Description
		$this->Tax_Description = new cField('view_sales_outstandings', 'view_sales_outstandings', 'x_Tax_Description', 'Tax_Description', '`Tax_Description`', '`Tax_Description`', 200, -1, FALSE, '`Tax_Description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Tax_Description'] = &$this->Tax_Description;
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
		if ($this->getCurrentDetailTable() == "a_payment_transactions") {
			$sDetailUrl = $GLOBALS["a_payment_transactions"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Sales_Number=" . urlencode($this->Sales_Number->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "view_sales_outstandingslist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`view_sales_outstandings`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Sales_Date` DESC";
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
			return "view_sales_outstandingslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "view_sales_outstandingslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("view_sales_outstandingsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("view_sales_outstandingsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "view_sales_outstandingsadd.php?" . $this->UrlParm($parm);
		else
			$url = "view_sales_outstandingsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("view_sales_outstandingsedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("view_sales_outstandingsedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("view_sales_outstandingsadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("view_sales_outstandingsadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("view_sales_outstandingsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
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
		$this->Sales_Date->setDbValue($rs->fields('Sales_Date'));
		$this->Customer_ID->setDbValue($rs->fields('Customer_ID'));
		$this->Notes->setDbValue($rs->fields('Notes'));
		$this->Total_Amount->setDbValue($rs->fields('Total_Amount'));
		$this->Final_Total_Amount->setDbValue($rs->fields('Final_Total_Amount'));
		$this->Total_Payment->setDbValue($rs->fields('Total_Payment'));
		$this->Total_Balance->setDbValue($rs->fields('Total_Balance'));
		$this->Discount_Type->setDbValue($rs->fields('Discount_Type'));
		$this->Discount_Percentage->setDbValue($rs->fields('Discount_Percentage'));
		$this->Discount_Amount->setDbValue($rs->fields('Discount_Amount'));
		$this->Tax_Percentage->setDbValue($rs->fields('Tax_Percentage'));
		$this->Tax_Description->setDbValue($rs->fields('Tax_Description'));
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
		// Sales_Date
		// Customer_ID
		// Notes
		// Total_Amount
		// Final_Total_Amount
		// Total_Payment

		$this->Total_Payment->CellCssStyle = "white-space: nowrap;";

		// Total_Balance
		$this->Total_Balance->CellCssStyle = "white-space: nowrap;";

		// Discount_Type
		// Discount_Percentage
		// Discount_Amount
		// Tax_Percentage
		// Tax_Description
		// Sales_ID

		$this->Sales_ID->ViewValue = $this->Sales_ID->CurrentValue;
		$this->Sales_ID->ViewCustomAttributes = "";

		// Sales_Number
		$this->Sales_Number->ViewValue = $this->Sales_Number->CurrentValue;
		$this->Sales_Number->ViewCustomAttributes = "";

		// Sales_Date
		$this->Sales_Date->ViewValue = $this->Sales_Date->CurrentValue;
		$this->Sales_Date->ViewValue = ew_FormatDateTime($this->Sales_Date->ViewValue, 9);
		$this->Sales_Date->ViewCustomAttributes = "";

		// Customer_ID
		if (strval($this->Customer_ID->CurrentValue) <> "") {
			$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer_ID->CurrentValue, EW_DATATYPE_STRING, "");
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
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Customer_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Customer_ID->ViewValue = $this->Customer_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Customer_ID->ViewValue = $this->Customer_ID->CurrentValue;
			}
		} else {
			$this->Customer_ID->ViewValue = NULL;
		}
		$this->Customer_ID->ViewCustomAttributes = "";

		// Notes
		$this->Notes->ViewValue = $this->Notes->CurrentValue;
		$this->Notes->ViewCustomAttributes = "";

		// Total_Amount
		$this->Total_Amount->ViewValue = $this->Total_Amount->CurrentValue;
		$this->Total_Amount->ViewValue = ew_FormatCurrency($this->Total_Amount->ViewValue, 2, -2, -2, -2);
		$this->Total_Amount->CellCssStyle .= "text-align: right;";
		$this->Total_Amount->ViewCustomAttributes = "";

		// Final_Total_Amount
		$this->Final_Total_Amount->ViewValue = $this->Final_Total_Amount->CurrentValue;
		$this->Final_Total_Amount->ViewValue = ew_FormatCurrency($this->Final_Total_Amount->ViewValue, 2, -2, -2, -2);
		$this->Final_Total_Amount->CellCssStyle .= "text-align: right;";
		$this->Final_Total_Amount->ViewCustomAttributes = "";

		// Total_Payment
		$this->Total_Payment->ViewValue = $this->Total_Payment->CurrentValue;
		$this->Total_Payment->ViewValue = ew_FormatCurrency($this->Total_Payment->ViewValue, 2, -2, -2, -2);
		$this->Total_Payment->CellCssStyle .= "text-align: right;";
		$this->Total_Payment->ViewCustomAttributes = "";

		// Total_Balance
		$this->Total_Balance->ViewValue = $this->Total_Balance->CurrentValue;
		$this->Total_Balance->ViewValue = ew_FormatCurrency($this->Total_Balance->ViewValue, 2, -2, -2, -2);
		$this->Total_Balance->CellCssStyle .= "text-align: right;";
		$this->Total_Balance->ViewCustomAttributes = "";

		// Discount_Type
		if (strval($this->Discount_Type->CurrentValue) <> "") {
			$this->Discount_Type->ViewValue = $this->Discount_Type->OptionCaption($this->Discount_Type->CurrentValue);
		} else {
			$this->Discount_Type->ViewValue = NULL;
		}
		$this->Discount_Type->ViewCustomAttributes = "";

		// Discount_Percentage
		$this->Discount_Percentage->ViewValue = $this->Discount_Percentage->CurrentValue;
		$this->Discount_Percentage->ViewValue = ew_FormatNumber($this->Discount_Percentage->ViewValue, 0, -2, -2, -2);
		$this->Discount_Percentage->CellCssStyle .= "text-align: right;";
		$this->Discount_Percentage->ViewCustomAttributes = "";

		// Discount_Amount
		$this->Discount_Amount->ViewValue = $this->Discount_Amount->CurrentValue;
		$this->Discount_Amount->ViewValue = ew_FormatNumber($this->Discount_Amount->ViewValue, 0, -2, -2, -2);
		$this->Discount_Amount->CellCssStyle .= "text-align: right;";
		$this->Discount_Amount->ViewCustomAttributes = "";

		// Tax_Percentage
		$this->Tax_Percentage->ViewValue = $this->Tax_Percentage->CurrentValue;
		$this->Tax_Percentage->ViewValue = ew_FormatNumber($this->Tax_Percentage->ViewValue, 0, -2, -2, -2);
		$this->Tax_Percentage->CellCssStyle .= "text-align: right;";
		$this->Tax_Percentage->ViewCustomAttributes = "";

		// Tax_Description
		$this->Tax_Description->ViewValue = $this->Tax_Description->CurrentValue;
		$this->Tax_Description->ViewCustomAttributes = "";

		// Sales_ID
		$this->Sales_ID->LinkCustomAttributes = "";
		$this->Sales_ID->HrefValue = "";
		$this->Sales_ID->TooltipValue = "";

		// Sales_Number
		$this->Sales_Number->LinkCustomAttributes = "";
		$this->Sales_Number->HrefValue = "";
		$this->Sales_Number->TooltipValue = "";

		// Sales_Date
		$this->Sales_Date->LinkCustomAttributes = "";
		$this->Sales_Date->HrefValue = "";
		$this->Sales_Date->TooltipValue = "";

		// Customer_ID
		$this->Customer_ID->LinkCustomAttributes = "";
		$this->Customer_ID->HrefValue = "";
		$this->Customer_ID->TooltipValue = "";

		// Notes
		$this->Notes->LinkCustomAttributes = "";
		$this->Notes->HrefValue = "";
		$this->Notes->TooltipValue = "";

		// Total_Amount
		$this->Total_Amount->LinkCustomAttributes = "";
		$this->Total_Amount->HrefValue = "";
		$this->Total_Amount->TooltipValue = "";

		// Final_Total_Amount
		$this->Final_Total_Amount->LinkCustomAttributes = "";
		$this->Final_Total_Amount->HrefValue = "";
		$this->Final_Total_Amount->TooltipValue = "";

		// Total_Payment
		$this->Total_Payment->LinkCustomAttributes = "";
		$this->Total_Payment->HrefValue = "";
		$this->Total_Payment->TooltipValue = "";

		// Total_Balance
		$this->Total_Balance->LinkCustomAttributes = "";
		$this->Total_Balance->HrefValue = "";
		$this->Total_Balance->TooltipValue = "";

		// Discount_Type
		$this->Discount_Type->LinkCustomAttributes = "";
		$this->Discount_Type->HrefValue = "";
		$this->Discount_Type->TooltipValue = "";

		// Discount_Percentage
		$this->Discount_Percentage->LinkCustomAttributes = "";
		$this->Discount_Percentage->HrefValue = "";
		$this->Discount_Percentage->TooltipValue = "";

		// Discount_Amount
		$this->Discount_Amount->LinkCustomAttributes = "";
		$this->Discount_Amount->HrefValue = "";
		$this->Discount_Amount->TooltipValue = "";

		// Tax_Percentage
		$this->Tax_Percentage->LinkCustomAttributes = "";
		$this->Tax_Percentage->HrefValue = "";
		$this->Tax_Percentage->TooltipValue = "";

		// Tax_Description
		$this->Tax_Description->LinkCustomAttributes = "";
		$this->Tax_Description->HrefValue = "";
		$this->Tax_Description->TooltipValue = "";

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

		// Sales_Date
		$this->Sales_Date->EditAttrs["class"] = "form-control";
		$this->Sales_Date->EditCustomAttributes = "";
		$this->Sales_Date->EditValue = ew_FormatDateTime($this->Sales_Date->CurrentValue, 9);
		$this->Sales_Date->PlaceHolder = ew_RemoveHtml($this->Sales_Date->FldCaption());

		// Customer_ID
		$this->Customer_ID->EditAttrs["class"] = "form-control";
		$this->Customer_ID->EditCustomAttributes = "";

		// Notes
		$this->Notes->EditAttrs["class"] = "form-control";
		$this->Notes->EditCustomAttributes = "";
		$this->Notes->EditValue = $this->Notes->CurrentValue;
		$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

		// Total_Amount
		$this->Total_Amount->EditAttrs["class"] = "form-control";
		$this->Total_Amount->EditCustomAttributes = "";
		$this->Total_Amount->EditValue = $this->Total_Amount->CurrentValue;
		$this->Total_Amount->PlaceHolder = ew_RemoveHtml($this->Total_Amount->FldCaption());
		if (strval($this->Total_Amount->EditValue) <> "" && is_numeric($this->Total_Amount->EditValue)) $this->Total_Amount->EditValue = ew_FormatNumber($this->Total_Amount->EditValue, -2, -2, -2, -2);

		// Final_Total_Amount
		$this->Final_Total_Amount->EditAttrs["class"] = "form-control";
		$this->Final_Total_Amount->EditCustomAttributes = "";
		$this->Final_Total_Amount->EditValue = $this->Final_Total_Amount->CurrentValue;
		$this->Final_Total_Amount->PlaceHolder = ew_RemoveHtml($this->Final_Total_Amount->FldCaption());
		if (strval($this->Final_Total_Amount->EditValue) <> "" && is_numeric($this->Final_Total_Amount->EditValue)) $this->Final_Total_Amount->EditValue = ew_FormatNumber($this->Final_Total_Amount->EditValue, -2, -2, -2, -2);

		// Total_Payment
		$this->Total_Payment->EditAttrs["class"] = "form-control";
		$this->Total_Payment->EditCustomAttributes = "";
		$this->Total_Payment->EditValue = $this->Total_Payment->CurrentValue;
		$this->Total_Payment->PlaceHolder = ew_RemoveHtml($this->Total_Payment->FldCaption());
		if (strval($this->Total_Payment->EditValue) <> "" && is_numeric($this->Total_Payment->EditValue)) $this->Total_Payment->EditValue = ew_FormatNumber($this->Total_Payment->EditValue, -2, -2, -2, -2);

		// Total_Balance
		$this->Total_Balance->EditAttrs["class"] = "form-control";
		$this->Total_Balance->EditCustomAttributes = "";
		$this->Total_Balance->EditValue = $this->Total_Balance->CurrentValue;
		$this->Total_Balance->PlaceHolder = ew_RemoveHtml($this->Total_Balance->FldCaption());
		if (strval($this->Total_Balance->EditValue) <> "" && is_numeric($this->Total_Balance->EditValue)) $this->Total_Balance->EditValue = ew_FormatNumber($this->Total_Balance->EditValue, -2, -2, -2, -2);

		// Discount_Type
		$this->Discount_Type->EditCustomAttributes = "";
		$this->Discount_Type->EditValue = $this->Discount_Type->Options(FALSE);

		// Discount_Percentage
		$this->Discount_Percentage->EditAttrs["class"] = "form-control";
		$this->Discount_Percentage->EditCustomAttributes = "";
		$this->Discount_Percentage->EditValue = $this->Discount_Percentage->CurrentValue;
		$this->Discount_Percentage->PlaceHolder = ew_RemoveHtml($this->Discount_Percentage->FldCaption());
		if (strval($this->Discount_Percentage->EditValue) <> "" && is_numeric($this->Discount_Percentage->EditValue)) $this->Discount_Percentage->EditValue = ew_FormatNumber($this->Discount_Percentage->EditValue, -2, -2, -2, -2);

		// Discount_Amount
		$this->Discount_Amount->EditAttrs["class"] = "form-control";
		$this->Discount_Amount->EditCustomAttributes = "";
		$this->Discount_Amount->EditValue = $this->Discount_Amount->CurrentValue;
		$this->Discount_Amount->PlaceHolder = ew_RemoveHtml($this->Discount_Amount->FldCaption());
		if (strval($this->Discount_Amount->EditValue) <> "" && is_numeric($this->Discount_Amount->EditValue)) $this->Discount_Amount->EditValue = ew_FormatNumber($this->Discount_Amount->EditValue, -2, -2, -2, -2);

		// Tax_Percentage
		$this->Tax_Percentage->EditAttrs["class"] = "form-control";
		$this->Tax_Percentage->EditCustomAttributes = "";
		$this->Tax_Percentage->EditValue = $this->Tax_Percentage->CurrentValue;
		$this->Tax_Percentage->PlaceHolder = ew_RemoveHtml($this->Tax_Percentage->FldCaption());
		if (strval($this->Tax_Percentage->EditValue) <> "" && is_numeric($this->Tax_Percentage->EditValue)) $this->Tax_Percentage->EditValue = ew_FormatNumber($this->Tax_Percentage->EditValue, -2, -2, -2, -2);

		// Tax_Description
		$this->Tax_Description->EditAttrs["class"] = "form-control";
		$this->Tax_Description->EditCustomAttributes = "";
		$this->Tax_Description->EditValue = $this->Tax_Description->CurrentValue;
		$this->Tax_Description->PlaceHolder = ew_RemoveHtml($this->Tax_Description->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			if (is_numeric($this->Total_Amount->CurrentValue))
				$this->Total_Amount->Total += $this->Total_Amount->CurrentValue; // Accumulate total
			if (is_numeric($this->Final_Total_Amount->CurrentValue))
				$this->Final_Total_Amount->Total += $this->Final_Total_Amount->CurrentValue; // Accumulate total
			if (is_numeric($this->Total_Payment->CurrentValue))
				$this->Total_Payment->Total += $this->Total_Payment->CurrentValue; // Accumulate total
			if (is_numeric($this->Total_Balance->CurrentValue))
				$this->Total_Balance->Total += $this->Total_Balance->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->Total_Amount->CurrentValue = $this->Total_Amount->Total;
			$this->Total_Amount->ViewValue = $this->Total_Amount->CurrentValue;
			$this->Total_Amount->ViewValue = ew_FormatCurrency($this->Total_Amount->ViewValue, 2, -2, -2, -2);
			$this->Total_Amount->CellCssStyle .= "text-align: right;";
			$this->Total_Amount->ViewCustomAttributes = "";
			$this->Total_Amount->HrefValue = ""; // Clear href value
			$this->Final_Total_Amount->CurrentValue = $this->Final_Total_Amount->Total;
			$this->Final_Total_Amount->ViewValue = $this->Final_Total_Amount->CurrentValue;
			$this->Final_Total_Amount->ViewValue = ew_FormatCurrency($this->Final_Total_Amount->ViewValue, 2, -2, -2, -2);
			$this->Final_Total_Amount->CellCssStyle .= "text-align: right;";
			$this->Final_Total_Amount->ViewCustomAttributes = "";
			$this->Final_Total_Amount->HrefValue = ""; // Clear href value
			$this->Total_Payment->CurrentValue = $this->Total_Payment->Total;
			$this->Total_Payment->ViewValue = $this->Total_Payment->CurrentValue;
			$this->Total_Payment->ViewValue = ew_FormatCurrency($this->Total_Payment->ViewValue, 2, -2, -2, -2);
			$this->Total_Payment->CellCssStyle .= "text-align: right;";
			$this->Total_Payment->ViewCustomAttributes = "";
			$this->Total_Payment->HrefValue = ""; // Clear href value
			$this->Total_Balance->CurrentValue = $this->Total_Balance->Total;
			$this->Total_Balance->ViewValue = $this->Total_Balance->CurrentValue;
			$this->Total_Balance->ViewValue = ew_FormatCurrency($this->Total_Balance->ViewValue, 2, -2, -2, -2);
			$this->Total_Balance->CellCssStyle .= "text-align: right;";
			$this->Total_Balance->ViewCustomAttributes = "";
			$this->Total_Balance->HrefValue = ""; // Clear href value

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
					if ($this->Sales_Date->Exportable) $Doc->ExportCaption($this->Sales_Date);
					if ($this->Customer_ID->Exportable) $Doc->ExportCaption($this->Customer_ID);
					if ($this->Notes->Exportable) $Doc->ExportCaption($this->Notes);
					if ($this->Total_Amount->Exportable) $Doc->ExportCaption($this->Total_Amount);
					if ($this->Final_Total_Amount->Exportable) $Doc->ExportCaption($this->Final_Total_Amount);
					if ($this->Total_Payment->Exportable) $Doc->ExportCaption($this->Total_Payment);
					if ($this->Total_Balance->Exportable) $Doc->ExportCaption($this->Total_Balance);
					if ($this->Discount_Type->Exportable) $Doc->ExportCaption($this->Discount_Type);
					if ($this->Discount_Percentage->Exportable) $Doc->ExportCaption($this->Discount_Percentage);
					if ($this->Discount_Amount->Exportable) $Doc->ExportCaption($this->Discount_Amount);
					if ($this->Tax_Percentage->Exportable) $Doc->ExportCaption($this->Tax_Percentage);
					if ($this->Tax_Description->Exportable) $Doc->ExportCaption($this->Tax_Description);
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
					if ($this->Sales_Date->Exportable) $Doc->ExportCaption($this->Sales_Date);
					if ($this->Customer_ID->Exportable) $Doc->ExportCaption($this->Customer_ID);
					if ($this->Notes->Exportable) $Doc->ExportCaption($this->Notes);
					if ($this->Total_Amount->Exportable) $Doc->ExportCaption($this->Total_Amount);
					if ($this->Final_Total_Amount->Exportable) $Doc->ExportCaption($this->Final_Total_Amount);
					if ($this->Total_Payment->Exportable) $Doc->ExportCaption($this->Total_Payment);
					if ($this->Total_Balance->Exportable) $Doc->ExportCaption($this->Total_Balance);
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
						if ($this->Sales_Date->Exportable) $Doc->ExportField($this->Sales_Date);
						if ($this->Customer_ID->Exportable) $Doc->ExportField($this->Customer_ID);
						if ($this->Notes->Exportable) $Doc->ExportField($this->Notes);
						if ($this->Total_Amount->Exportable) $Doc->ExportField($this->Total_Amount);
						if ($this->Final_Total_Amount->Exportable) $Doc->ExportField($this->Final_Total_Amount);
						if ($this->Total_Payment->Exportable) $Doc->ExportField($this->Total_Payment);
						if ($this->Total_Balance->Exportable) $Doc->ExportField($this->Total_Balance);
						if ($this->Discount_Type->Exportable) $Doc->ExportField($this->Discount_Type);
						if ($this->Discount_Percentage->Exportable) $Doc->ExportField($this->Discount_Percentage);
						if ($this->Discount_Amount->Exportable) $Doc->ExportField($this->Discount_Amount);
						if ($this->Tax_Percentage->Exportable) $Doc->ExportField($this->Tax_Percentage);
						if ($this->Tax_Description->Exportable) $Doc->ExportField($this->Tax_Description);
					} else {

					// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) {  
							$Doc->ExportText(ew_FormatSeqNo(CurrentPage()->getStartRecordNumber()+$RowCnt-1));
						}

					 // End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if ($this->Sales_Number->Exportable) $Doc->ExportField($this->Sales_Number);
						if ($this->Sales_Date->Exportable) $Doc->ExportField($this->Sales_Date);
						if ($this->Customer_ID->Exportable) $Doc->ExportField($this->Customer_ID);
						if ($this->Notes->Exportable) $Doc->ExportField($this->Notes);
						if ($this->Total_Amount->Exportable) $Doc->ExportField($this->Total_Amount);
						if ($this->Final_Total_Amount->Exportable) $Doc->ExportField($this->Final_Total_Amount);
						if ($this->Total_Payment->Exportable) $Doc->ExportField($this->Total_Payment);
						if ($this->Total_Balance->Exportable) $Doc->ExportField($this->Total_Balance);
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
				$Doc->ExportAggregate($this->Sales_Date, '');
				$Doc->ExportAggregate($this->Customer_ID, '');
				$Doc->ExportAggregate($this->Notes, '');
				$Doc->ExportAggregate($this->Total_Amount, 'TOTAL');
				$Doc->ExportAggregate($this->Final_Total_Amount, 'TOTAL');
				$Doc->ExportAggregate($this->Total_Payment, 'TOTAL');
				$Doc->ExportAggregate($this->Total_Balance, 'TOTAL');
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

		if (CurrentPageID() == "list") {
			$this->Total_Amount->CellCssStyle = "text-align: right;";
			$this->Final_Total_Amount->CellCssStyle = "text-align: right;";
			$this->Total_Payment->CellCssStyle = "text-align: right;";
			$this->Total_Balance->CellCssStyle = "text-align: right;";
		}
		if ($this->RowType == EW_ROWTYPE_AGGREGATE) {
			$this->Total_Amount->ViewValue = "<div style='text-align: right; font-weight: bold;'>".$this->Total_Amount->ViewValue."</div>";
			$this->Final_Total_Amount->ViewValue = "<div style='text-align: right; font-weight: bold;'>".$this->Final_Total_Amount->ViewValue."</div>";
			$this->Total_Payment->ViewValue = "<div style='text-align: right; font-weight: bold;'>".$this->Total_Payment->ViewValue."</div>";
			$this->Total_Balance->ViewValue = "<div style='text-align: right; font-weight: bold;'>".$this->Total_Balance->ViewValue."</div>";		
		}	
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
