<?php

// Global variable for table object
$a_payment_transactions = NULL;

//
// Table class for a_payment_transactions
//
class ca_payment_transactions extends cTable {
	var $Payment_ID;
	var $Ref_ID;
	var $Type;
	var $Customer;
	var $Supplier;
	var $Sub_Total;
	var $Payment;
	var $Balance;
	var $Due_Date;
	var $Date_Transaction;
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
		$this->TableVar = 'a_payment_transactions';
		$this->TableName = 'a_payment_transactions';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`a_payment_transactions`";
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

		// Payment_ID
		$this->Payment_ID = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Payment_ID', 'Payment_ID', '`Payment_ID`', '`Payment_ID`', 3, -1, FALSE, '`Payment_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Payment_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Payment_ID'] = &$this->Payment_ID;

		// Ref_ID
		$this->Ref_ID = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Ref_ID', 'Ref_ID', '`Ref_ID`', '`Ref_ID`', 200, -1, FALSE, '`Ref_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Ref_ID'] = &$this->Ref_ID;

		// Type
		$this->Type = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Type', 'Type', '`Type`', '`Type`', 202, -1, FALSE, '`Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Type->OptionCount = 2;
		$this->fields['Type'] = &$this->Type;

		// Customer
		$this->Customer = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Customer', 'Customer', '`Customer`', '`Customer`', 200, -1, FALSE, '`Customer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Customer'] = &$this->Customer;

		// Supplier
		$this->Supplier = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Supplier', 'Supplier', '`Supplier`', '`Supplier`', 200, -1, FALSE, '`Supplier`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Supplier'] = &$this->Supplier;

		// Sub_Total
		$this->Sub_Total = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Sub_Total', 'Sub_Total', '`Sub_Total`', '`Sub_Total`', 5, -1, FALSE, '`Sub_Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Sub_Total'] = &$this->Sub_Total;

		// Payment
		$this->Payment = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Payment', 'Payment', '`Payment`', '`Payment`', 5, -1, FALSE, '`Payment`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Payment->FldDefaultErrMsg = str_replace(array("%1", "%2"), array("1", "999999999"), $Language->Phrase("IncorrectRange"));
		$this->fields['Payment'] = &$this->Payment;

		// Balance
		$this->Balance = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Balance', 'Balance', '`Balance`', '`Balance`', 5, -1, FALSE, '`Balance`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Balance'] = &$this->Balance;

		// Due_Date
		$this->Due_Date = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Due_Date', 'Due_Date', '`Due_Date`', 'DATE_FORMAT(`Due_Date`, \'%Y/%m/%d %H:%i:%s\')', 133, 5, FALSE, '`Due_Date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Due_Date->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Due_Date'] = &$this->Due_Date;

		// Date_Transaction
		$this->Date_Transaction = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Date_Transaction', 'Date_Transaction', '`Date_Transaction`', 'DATE_FORMAT(`Date_Transaction`, \'%Y/%m/%d %H:%i:%s\')', 133, 5, FALSE, '`Date_Transaction`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Date_Transaction->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Date_Transaction'] = &$this->Date_Transaction;

		// Date_Added
		$this->Date_Added = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Date_Added', 'Date_Added', '`Date_Added`', 'DATE_FORMAT(`Date_Added`, \'%Y/%m/%d %H:%i:%s\')', 135, -1, FALSE, '`Date_Added`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Date_Added'] = &$this->Date_Added;

		// Added_By
		$this->Added_By = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Added_By', 'Added_By', '`Added_By`', '`Added_By`', 200, -1, FALSE, '`Added_By`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Added_By'] = &$this->Added_By;

		// Date_Updated
		$this->Date_Updated = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Date_Updated', 'Date_Updated', '`Date_Updated`', 'DATE_FORMAT(`Date_Updated`, \'%Y/%m/%d %H:%i:%s\')', 135, -1, FALSE, '`Date_Updated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Date_Updated'] = &$this->Date_Updated;

		// Updated_By
		$this->Updated_By = new cField('a_payment_transactions', 'a_payment_transactions', 'x_Updated_By', 'Updated_By', '`Updated_By`', '`Updated_By`', 200, -1, FALSE, '`Updated_By`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
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
		if ($this->getCurrentMasterTable() == "view_sales_outstandings") {
			if ($this->Ref_ID->getSessionValue() <> "")
				$sMasterFilter .= "`Sales_Number`=" . ew_QuotedValue($this->Ref_ID->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "view_purchases_outstandings") {
			if ($this->Ref_ID->getSessionValue() <> "")
				$sMasterFilter .= "`Purchase_Number`=" . ew_QuotedValue($this->Ref_ID->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "view_sales_outstandings") {
			if ($this->Ref_ID->getSessionValue() <> "")
				$sDetailFilter .= "`Ref_ID`=" . ew_QuotedValue($this->Ref_ID->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "view_purchases_outstandings") {
			if ($this->Ref_ID->getSessionValue() <> "")
				$sDetailFilter .= "`Ref_ID`=" . ew_QuotedValue($this->Ref_ID->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_view_sales_outstandings() {
		return "`Sales_Number`='@Sales_Number@'";
	}

	// Detail filter
	function SqlDetailFilter_view_sales_outstandings() {
		return "`Ref_ID`='@Ref_ID@'";
	}

	// Master filter
	function SqlMasterFilter_view_purchases_outstandings() {
		return "`Purchase_Number`='@Purchase_Number@'";
	}

	// Detail filter
	function SqlDetailFilter_view_purchases_outstandings() {
		return "`Ref_ID`='@Ref_ID@'";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`a_payment_transactions`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Date_Added` DESC";
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
			if (array_key_exists('Payment_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('Payment_ID', $this->DBID) . '=' . ew_QuotedValue($rs['Payment_ID'], $this->Payment_ID->FldDataType, $this->DBID));
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
		return "`Payment_ID` = @Payment_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Payment_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Payment_ID@", ew_AdjustSql($this->Payment_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "a_payment_transactionslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "a_payment_transactionslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("a_payment_transactionsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("a_payment_transactionsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "a_payment_transactionsadd.php?" . $this->UrlParm($parm);
		else
			$url = "a_payment_transactionsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("a_payment_transactionsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("a_payment_transactionsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("a_payment_transactionsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "view_sales_outstandings" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Sales_Number=" . urlencode($this->Ref_ID->CurrentValue);
		}
		if ($this->getCurrentMasterTable() == "view_purchases_outstandings" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Purchase_Number=" . urlencode($this->Ref_ID->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Payment_ID:" . ew_VarToJson($this->Payment_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Payment_ID->CurrentValue)) {
			$sUrl .= "Payment_ID=" . urlencode($this->Payment_ID->CurrentValue);
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
			if ($isPost && isset($_POST["Payment_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["Payment_ID"]);
			elseif (isset($_GET["Payment_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["Payment_ID"]);
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
			$this->Payment_ID->CurrentValue = $key;
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
		$this->Payment_ID->setDbValue($rs->fields('Payment_ID'));
		$this->Ref_ID->setDbValue($rs->fields('Ref_ID'));
		$this->Type->setDbValue($rs->fields('Type'));
		$this->Customer->setDbValue($rs->fields('Customer'));
		$this->Supplier->setDbValue($rs->fields('Supplier'));
		$this->Sub_Total->setDbValue($rs->fields('Sub_Total'));
		$this->Payment->setDbValue($rs->fields('Payment'));
		$this->Balance->setDbValue($rs->fields('Balance'));
		$this->Due_Date->setDbValue($rs->fields('Due_Date'));
		$this->Date_Transaction->setDbValue($rs->fields('Date_Transaction'));
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
		// Payment_ID
		// Ref_ID
		// Type
		// Customer
		// Supplier
		// Sub_Total
		// Payment
		// Balance
		// Due_Date
		// Date_Transaction
		// Date_Added
		// Added_By
		// Date_Updated
		// Updated_By
		// Payment_ID

		$this->Payment_ID->ViewValue = $this->Payment_ID->CurrentValue;
		$this->Payment_ID->ViewCustomAttributes = "";

		// Ref_ID
		$this->Ref_ID->ViewValue = $this->Ref_ID->CurrentValue;
		$this->Ref_ID->ViewCustomAttributes = "";

		// Type
		if (strval($this->Type->CurrentValue) <> "") {
			$this->Type->ViewValue = $this->Type->OptionCaption($this->Type->CurrentValue);
		} else {
			$this->Type->ViewValue = NULL;
		}
		$this->Type->ViewCustomAttributes = "";

		// Customer
		if (strval($this->Customer->CurrentValue) <> "") {
			$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer->CurrentValue, EW_DATATYPE_STRING, "");
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
		$this->Lookup_Selecting($this->Customer, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Customer->ViewValue = $this->Customer->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Customer->ViewValue = $this->Customer->CurrentValue;
			}
		} else {
			$this->Customer->ViewValue = NULL;
		}
		$this->Customer->ViewCustomAttributes = "";

		// Supplier
		if (strval($this->Supplier->CurrentValue) <> "") {
			$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier->CurrentValue, EW_DATATYPE_STRING, "");
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
		$this->Lookup_Selecting($this->Supplier, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Supplier->ViewValue = $this->Supplier->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Supplier->ViewValue = $this->Supplier->CurrentValue;
			}
		} else {
			$this->Supplier->ViewValue = NULL;
		}
		$this->Supplier->ViewCustomAttributes = "";

		// Sub_Total
		$this->Sub_Total->ViewValue = $this->Sub_Total->CurrentValue;
		$this->Sub_Total->ViewValue = ew_FormatCurrency($this->Sub_Total->ViewValue, 2, -2, -2, -2);
		$this->Sub_Total->CellCssStyle .= "text-align: right;";
		$this->Sub_Total->ViewCustomAttributes = "";

		// Payment
		$this->Payment->ViewValue = $this->Payment->CurrentValue;
		$this->Payment->ViewValue = ew_FormatCurrency($this->Payment->ViewValue, 2, -2, -2, -2);
		$this->Payment->CellCssStyle .= "text-align: right;";
		$this->Payment->ViewCustomAttributes = "";

		// Balance
		$this->Balance->ViewValue = $this->Balance->CurrentValue;
		$this->Balance->ViewValue = ew_FormatCurrency($this->Balance->ViewValue, 2, -2, -2, -2);
		$this->Balance->CellCssStyle .= "text-align: right;";
		$this->Balance->ViewCustomAttributes = "";

		// Due_Date
		$this->Due_Date->ViewValue = $this->Due_Date->CurrentValue;
		$this->Due_Date->ViewValue = ew_FormatDateTime($this->Due_Date->ViewValue, 5);
		$this->Due_Date->ViewCustomAttributes = "";

		// Date_Transaction
		$this->Date_Transaction->ViewValue = $this->Date_Transaction->CurrentValue;
		$this->Date_Transaction->ViewValue = ew_FormatDateTime($this->Date_Transaction->ViewValue, 5);
		$this->Date_Transaction->ViewCustomAttributes = "";

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

		// Payment_ID
		$this->Payment_ID->LinkCustomAttributes = "";
		$this->Payment_ID->HrefValue = "";
		$this->Payment_ID->TooltipValue = "";

		// Ref_ID
		$this->Ref_ID->LinkCustomAttributes = "";
		$this->Ref_ID->HrefValue = "";
		$this->Ref_ID->TooltipValue = "";

		// Type
		$this->Type->LinkCustomAttributes = "";
		$this->Type->HrefValue = "";
		$this->Type->TooltipValue = "";

		// Customer
		$this->Customer->LinkCustomAttributes = "";
		$this->Customer->HrefValue = "";
		$this->Customer->TooltipValue = "";

		// Supplier
		$this->Supplier->LinkCustomAttributes = "";
		$this->Supplier->HrefValue = "";
		$this->Supplier->TooltipValue = "";

		// Sub_Total
		$this->Sub_Total->LinkCustomAttributes = "";
		$this->Sub_Total->HrefValue = "";
		$this->Sub_Total->TooltipValue = "";

		// Payment
		$this->Payment->LinkCustomAttributes = "";
		$this->Payment->HrefValue = "";
		$this->Payment->TooltipValue = "";

		// Balance
		$this->Balance->LinkCustomAttributes = "";
		$this->Balance->HrefValue = "";
		$this->Balance->TooltipValue = "";

		// Due_Date
		$this->Due_Date->LinkCustomAttributes = "";
		$this->Due_Date->HrefValue = "";
		$this->Due_Date->TooltipValue = "";

		// Date_Transaction
		$this->Date_Transaction->LinkCustomAttributes = "";
		$this->Date_Transaction->HrefValue = "";
		$this->Date_Transaction->TooltipValue = "";

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

		// Payment_ID
		$this->Payment_ID->EditAttrs["class"] = "form-control";
		$this->Payment_ID->EditCustomAttributes = "";
		$this->Payment_ID->EditValue = $this->Payment_ID->CurrentValue;
		$this->Payment_ID->ViewCustomAttributes = "";

		// Ref_ID
		$this->Ref_ID->EditAttrs["class"] = "form-control";
		$this->Ref_ID->EditCustomAttributes = "";
		if ($this->Ref_ID->getSessionValue() <> "") {
			$this->Ref_ID->CurrentValue = $this->Ref_ID->getSessionValue();
		$this->Ref_ID->ViewValue = $this->Ref_ID->CurrentValue;
		$this->Ref_ID->ViewCustomAttributes = "";
		} else {
		$this->Ref_ID->EditValue = $this->Ref_ID->CurrentValue;
		$this->Ref_ID->PlaceHolder = ew_RemoveHtml($this->Ref_ID->FldCaption());
		}

		// Type
		$this->Type->EditCustomAttributes = "";
		$this->Type->EditValue = $this->Type->Options(FALSE);

		// Customer
		$this->Customer->EditAttrs["class"] = "form-control";
		$this->Customer->EditCustomAttributes = "";

		// Supplier
		$this->Supplier->EditAttrs["class"] = "form-control";
		$this->Supplier->EditCustomAttributes = "";

		// Sub_Total
		$this->Sub_Total->EditAttrs["class"] = "form-control";
		$this->Sub_Total->EditCustomAttributes = "";
		$this->Sub_Total->EditValue = $this->Sub_Total->CurrentValue;
		$this->Sub_Total->PlaceHolder = ew_RemoveHtml($this->Sub_Total->FldCaption());
		if (strval($this->Sub_Total->EditValue) <> "" && is_numeric($this->Sub_Total->EditValue)) $this->Sub_Total->EditValue = ew_FormatNumber($this->Sub_Total->EditValue, -2, -2, -2, -2);

		// Payment
		$this->Payment->EditAttrs["class"] = "form-control";
		$this->Payment->EditCustomAttributes = "";
		$this->Payment->EditValue = $this->Payment->CurrentValue;
		$this->Payment->PlaceHolder = ew_RemoveHtml($this->Payment->FldCaption());
		if (strval($this->Payment->EditValue) <> "" && is_numeric($this->Payment->EditValue)) $this->Payment->EditValue = ew_FormatNumber($this->Payment->EditValue, -2, -2, -2, -2);

		// Balance
		$this->Balance->EditAttrs["class"] = "form-control";
		$this->Balance->EditCustomAttributes = "";
		$this->Balance->EditValue = $this->Balance->CurrentValue;
		$this->Balance->PlaceHolder = ew_RemoveHtml($this->Balance->FldCaption());
		if (strval($this->Balance->EditValue) <> "" && is_numeric($this->Balance->EditValue)) $this->Balance->EditValue = ew_FormatNumber($this->Balance->EditValue, -2, -2, -2, -2);

		// Due_Date
		$this->Due_Date->EditAttrs["class"] = "form-control";
		$this->Due_Date->EditCustomAttributes = "";
		$this->Due_Date->EditValue = ew_FormatDateTime($this->Due_Date->CurrentValue, 5);
		$this->Due_Date->PlaceHolder = ew_RemoveHtml($this->Due_Date->FldCaption());

		// Date_Transaction
		$this->Date_Transaction->EditAttrs["class"] = "form-control";
		$this->Date_Transaction->EditCustomAttributes = "";
		$this->Date_Transaction->EditValue = ew_FormatDateTime($this->Date_Transaction->CurrentValue, 5);
		$this->Date_Transaction->PlaceHolder = ew_RemoveHtml($this->Date_Transaction->FldCaption());

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
			if (is_numeric($this->Sub_Total->CurrentValue))
				$this->Sub_Total->Total += $this->Sub_Total->CurrentValue; // Accumulate total
			if (is_numeric($this->Payment->CurrentValue))
				$this->Payment->Total += $this->Payment->CurrentValue; // Accumulate total
			if (is_numeric($this->Balance->CurrentValue))
				$this->Balance->Total += $this->Balance->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->Sub_Total->CurrentValue = $this->Sub_Total->Total;
			$this->Sub_Total->ViewValue = $this->Sub_Total->CurrentValue;
			$this->Sub_Total->ViewValue = ew_FormatCurrency($this->Sub_Total->ViewValue, 2, -2, -2, -2);
			$this->Sub_Total->CellCssStyle .= "text-align: right;";
			$this->Sub_Total->ViewCustomAttributes = "";
			$this->Sub_Total->HrefValue = ""; // Clear href value
			$this->Payment->CurrentValue = $this->Payment->Total;
			$this->Payment->ViewValue = $this->Payment->CurrentValue;
			$this->Payment->ViewValue = ew_FormatCurrency($this->Payment->ViewValue, 2, -2, -2, -2);
			$this->Payment->CellCssStyle .= "text-align: right;";
			$this->Payment->ViewCustomAttributes = "";
			$this->Payment->HrefValue = ""; // Clear href value
			$this->Balance->CurrentValue = $this->Balance->Total;
			$this->Balance->ViewValue = $this->Balance->CurrentValue;
			$this->Balance->ViewValue = ew_FormatCurrency($this->Balance->ViewValue, 2, -2, -2, -2);
			$this->Balance->CellCssStyle .= "text-align: right;";
			$this->Balance->ViewCustomAttributes = "";
			$this->Balance->HrefValue = ""; // Clear href value

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
					if ($this->Payment_ID->Exportable) $Doc->ExportCaption($this->Payment_ID);
					if ($this->Ref_ID->Exportable) $Doc->ExportCaption($this->Ref_ID);
					if ($this->Type->Exportable) $Doc->ExportCaption($this->Type);
					if ($this->Customer->Exportable) $Doc->ExportCaption($this->Customer);
					if ($this->Supplier->Exportable) $Doc->ExportCaption($this->Supplier);
					if ($this->Sub_Total->Exportable) $Doc->ExportCaption($this->Sub_Total);
					if ($this->Payment->Exportable) $Doc->ExportCaption($this->Payment);
					if ($this->Balance->Exportable) $Doc->ExportCaption($this->Balance);
					if ($this->Due_Date->Exportable) $Doc->ExportCaption($this->Due_Date);
					if ($this->Date_Transaction->Exportable) $Doc->ExportCaption($this->Date_Transaction);
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
					if ($this->Ref_ID->Exportable) $Doc->ExportCaption($this->Ref_ID);
					if ($this->Type->Exportable) $Doc->ExportCaption($this->Type);
					if ($this->Customer->Exportable) $Doc->ExportCaption($this->Customer);
					if ($this->Supplier->Exportable) $Doc->ExportCaption($this->Supplier);
					if ($this->Sub_Total->Exportable) $Doc->ExportCaption($this->Sub_Total);
					if ($this->Payment->Exportable) $Doc->ExportCaption($this->Payment);
					if ($this->Balance->Exportable) $Doc->ExportCaption($this->Balance);
					if ($this->Due_Date->Exportable) $Doc->ExportCaption($this->Due_Date);
					if ($this->Date_Transaction->Exportable) $Doc->ExportCaption($this->Date_Transaction);
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
						if ($this->Payment_ID->Exportable) $Doc->ExportField($this->Payment_ID);
						if ($this->Ref_ID->Exportable) $Doc->ExportField($this->Ref_ID);
						if ($this->Type->Exportable) $Doc->ExportField($this->Type);
						if ($this->Customer->Exportable) $Doc->ExportField($this->Customer);
						if ($this->Supplier->Exportable) $Doc->ExportField($this->Supplier);
						if ($this->Sub_Total->Exportable) $Doc->ExportField($this->Sub_Total);
						if ($this->Payment->Exportable) $Doc->ExportField($this->Payment);
						if ($this->Balance->Exportable) $Doc->ExportField($this->Balance);
						if ($this->Due_Date->Exportable) $Doc->ExportField($this->Due_Date);
						if ($this->Date_Transaction->Exportable) $Doc->ExportField($this->Date_Transaction);
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
						if ($this->Ref_ID->Exportable) $Doc->ExportField($this->Ref_ID);
						if ($this->Type->Exportable) $Doc->ExportField($this->Type);
						if ($this->Customer->Exportable) $Doc->ExportField($this->Customer);
						if ($this->Supplier->Exportable) $Doc->ExportField($this->Supplier);
						if ($this->Sub_Total->Exportable) $Doc->ExportField($this->Sub_Total);
						if ($this->Payment->Exportable) $Doc->ExportField($this->Payment);
						if ($this->Balance->Exportable) $Doc->ExportField($this->Balance);
						if ($this->Due_Date->Exportable) $Doc->ExportField($this->Due_Date);
						if ($this->Date_Transaction->Exportable) $Doc->ExportField($this->Date_Transaction);
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
				$Doc->ExportAggregate($this->Ref_ID, '');
				$Doc->ExportAggregate($this->Type, '');
				$Doc->ExportAggregate($this->Customer, '');
				$Doc->ExportAggregate($this->Supplier, '');
				$Doc->ExportAggregate($this->Sub_Total, 'TOTAL');
				$Doc->ExportAggregate($this->Payment, 'TOTAL');
				$Doc->ExportAggregate($this->Balance, 'TOTAL');
				$Doc->ExportAggregate($this->Due_Date, '');
				$Doc->ExportAggregate($this->Date_Transaction, '');
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

		if ($_SESSION["Transaction_Type"] == "sales") {
			$rsnew["Ref_ID"] = $_SESSION["Sales_Number_Payment"];
			$rsnew["Customer"] = GetCustomerNumber($_SESSION["Sales_Number_Payment"]);
			$rsnew["Type"] = "sales";
			$rsnew["Supplier"] = "-";
		} elseif ($_SESSION["Transaction_Type"] == "purchase") {
			$rsnew["Ref_ID"] = $_SESSION["Purchase_Number_Payment"];
			$rsnew["Supplier"] = GetSupplierNumber($_SESSION["Purchase_Number_Payment"]);
			$rsnew["Type"] = "purchase";
			$rsnew["Customer"] = "-";
		}
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		if ($_SESSION["Transaction_Type"] == "sales") {
			ew_Execute("UPDATE a_sales SET Total_Balance = ".$rsnew["Balance"].", Total_Payment = Total_Payment + ".$rsnew["Payment"]." WHERE Sales_Number = '".$rsnew["Ref_ID"]."'");
			ew_Execute("UPDATE a_customers SET Balance = Balance - ".$rsnew["Payment"]." WHERE Customer_Number = '".$rsnew["Customer"]."'");
		} elseif ($_SESSION["Transaction_Type"] == "purchase") {
			ew_Execute("UPDATE a_purchases SET Total_Balance = ".$rsnew["Balance"].", Total_Payment = Total_Payment + ".$rsnew["Payment"]." WHERE Purchase_Number = '".$rsnew["Ref_ID"]."'");
			ew_Execute("UPDATE a_suppliers SET Balance = Balance - ".$rsnew["Payment"]." WHERE Supplier_Number = '".$rsnew["Supplier"]."'");
		}
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

		if (CurrentPageID() == "add" && $this->CurrentAction != "F") {
			if ($_SESSION["Transaction_Type"] == "sales") {
				$this->Ref_ID->EditValue = $_SESSION["Sales_Number_Payment"];
				$this->Ref_ID->ReadOnly = TRUE;
				$this->Type->CurrentValue = "sales";
				$this->Type->Disabled = TRUE;
				$this->Customer->Disabled = TRUE;
				$this->Customer->CurrentValue = GetCustomerNumber($_SESSION["Sales_Number_Payment"]);
				$this->Sub_Total->EditValue = GetStartBalance("sales", $_SESSION["Sales_Number_Payment"]);
				$this->Sub_Total->ReadOnly = TRUE;
			} elseif ($_SESSION["Transaction_Type"] == "purchase") {
				$this->Ref_ID->EditValue = $_SESSION["Purchase_Number_Payment"];
				$this->Ref_ID->ReadOnly = TRUE;
				$this->Type->CurrentValue = "purchase";
				$this->Type->Disabled = TRUE;
				$this->Supplier->Disabled = TRUE;
				$this->Supplier->CurrentValue = GetSupplierNumber($_SESSION["Purchase_Number_Payment"]);
				$this->Sub_Total->EditValue = GetStartBalance("purchase", $_SESSION["Purchase_Number_Payment"]);
				$this->Sub_Total->ReadOnly = TRUE;
			}
		}

		// Confirm mode
		if ($this->CurrentAction == "add" && $this->CurrentAction=="F") {
			if ($_SESSION["Transaction_Type"] == "sales") {
				$this->Ref_ID->ViewValue = $this->Ref_ID->CurrentValue;
				$this->Type->ViewValue = $this->Type->CurrentValue;
				$this->Customer->ViewValue = $this->Customer->CurrentValue;
				$this->Sub_Total->ViewValue = $this->Sub_Total->CurrentValue;
			} elseif ($_SESSION["Transaction_Type"] == "purchase") {
				$this->Ref_ID->ViewValue = $this->Ref_ID->CurrentValue;
				$this->Type->ViewValue = $this->Type->CurrentValue;
				$this->Supplier->ViewValue = $this->Supplier->CurrentValue;
				$this->Sub_Total->ViewValue = $this->Sub_Total->CurrentValue;
			}
		}
		$this->Payment->EditAttrs["onkeyup"] = "GetBalancePayment();";
		$this->Payment->EditAttrs["onclick"] = "GetBalancePayment();";
		$this->Payment->EditAttrs["onfocus"] = "SetFocusTextBox('Payment');";
		$this->Balance->EditAttrs["onfocus"] = "SetFocusTextBox('Balance');";
		if (CurrentPageID() == "list") {
			$this->Sub_Total->CellCssStyle = "text-align: right;";
			$this->Payment->CellCssStyle = "text-align: right;";
			$this->Balance->CellCssStyle = "text-align: right;";
		}
		if ($this->RowType == EW_ROWTYPE_AGGREGATE) {
			$this->Sub_Total->ViewValue = "<div style='text-align: right; font-weight: bold;'>".$this->Sub_Total->ViewValue."</div>";
			$this->Payment->ViewValue = "<div style='text-align: right; font-weight: bold;'>".$this->Payment->ViewValue."</div>";
			$this->Balance->ViewValue = "<div style='text-align: right; font-weight: bold;'>".$this->Balance->ViewValue."</div>";		
		}	
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
