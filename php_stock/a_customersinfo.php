<?php

// Global variable for table object
$a_customers = NULL;

//
// Table class for a_customers
//
class ca_customers extends cTable {
	var $Customer_ID;
	var $Customer_Number;
	var $Customer_Name;
	var $Address;
	var $City;
	var $Country;
	var $Contact_Person;
	var $Phone_Number;
	var $_Email;
	var $Mobile_Number;
	var $Notes;
	var $Balance;
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
		$this->TableVar = 'a_customers';
		$this->TableName = 'a_customers';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`a_customers`";
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

		// Customer_ID
		$this->Customer_ID = new cField('a_customers', 'a_customers', 'x_Customer_ID', 'Customer_ID', '`Customer_ID`', '`Customer_ID`', 3, -1, FALSE, '`Customer_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Customer_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Customer_ID'] = &$this->Customer_ID;

		// Customer_Number
		$this->Customer_Number = new cField('a_customers', 'a_customers', 'x_Customer_Number', 'Customer_Number', '`Customer_Number`', '`Customer_Number`', 200, -1, FALSE, '`Customer_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Customer_Number'] = &$this->Customer_Number;

		// Customer_Name
		$this->Customer_Name = new cField('a_customers', 'a_customers', 'x_Customer_Name', 'Customer_Name', '`Customer_Name`', '`Customer_Name`', 200, -1, FALSE, '`Customer_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Customer_Name'] = &$this->Customer_Name;

		// Address
		$this->Address = new cField('a_customers', 'a_customers', 'x_Address', 'Address', '`Address`', '`Address`', 201, -1, FALSE, '`Address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['Address'] = &$this->Address;

		// City
		$this->City = new cField('a_customers', 'a_customers', 'x_City', 'City', '`City`', '`City`', 200, -1, FALSE, '`City`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['City'] = &$this->City;

		// Country
		$this->Country = new cField('a_customers', 'a_customers', 'x_Country', 'Country', '`Country`', '`Country`', 200, -1, FALSE, '`Country`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Country'] = &$this->Country;

		// Contact_Person
		$this->Contact_Person = new cField('a_customers', 'a_customers', 'x_Contact_Person', 'Contact_Person', '`Contact_Person`', '`Contact_Person`', 200, -1, FALSE, '`Contact_Person`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Contact_Person'] = &$this->Contact_Person;

		// Phone_Number
		$this->Phone_Number = new cField('a_customers', 'a_customers', 'x_Phone_Number', 'Phone_Number', '`Phone_Number`', '`Phone_Number`', 200, -1, FALSE, '`Phone_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Phone_Number'] = &$this->Phone_Number;

		// Email
		$this->_Email = new cField('a_customers', 'a_customers', 'x__Email', 'Email', '`Email`', '`Email`', 200, -1, FALSE, '`Email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Email'] = &$this->_Email;

		// Mobile_Number
		$this->Mobile_Number = new cField('a_customers', 'a_customers', 'x_Mobile_Number', 'Mobile_Number', '`Mobile_Number`', '`Mobile_Number`', 200, -1, FALSE, '`Mobile_Number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Mobile_Number'] = &$this->Mobile_Number;

		// Notes
		$this->Notes = new cField('a_customers', 'a_customers', 'x_Notes', 'Notes', '`Notes`', '`Notes`', 200, -1, FALSE, '`Notes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Notes'] = &$this->Notes;

		// Balance
		$this->Balance = new cField('a_customers', 'a_customers', 'x_Balance', 'Balance', '`Balance`', '`Balance`', 5, -1, FALSE, '`Balance`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Balance'] = &$this->Balance;

		// Date_Added
		$this->Date_Added = new cField('a_customers', 'a_customers', 'x_Date_Added', 'Date_Added', '`Date_Added`', 'DATE_FORMAT(`Date_Added`, \'%Y/%m/%d %H:%i:%s\')', 135, -1, FALSE, '`Date_Added`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Date_Added'] = &$this->Date_Added;

		// Added_By
		$this->Added_By = new cField('a_customers', 'a_customers', 'x_Added_By', 'Added_By', '`Added_By`', '`Added_By`', 200, -1, FALSE, '`Added_By`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Added_By'] = &$this->Added_By;

		// Date_Updated
		$this->Date_Updated = new cField('a_customers', 'a_customers', 'x_Date_Updated', 'Date_Updated', '`Date_Updated`', 'DATE_FORMAT(`Date_Updated`, \'%Y/%m/%d %H:%i:%s\')', 135, -1, FALSE, '`Date_Updated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['Date_Updated'] = &$this->Date_Updated;

		// Updated_By
		$this->Updated_By = new cField('a_customers', 'a_customers', 'x_Updated_By', 'Updated_By', '`Updated_By`', '`Updated_By`', 200, -1, FALSE, '`Updated_By`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
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
		if ($this->getCurrentDetailTable() == "a_sales") {
			$sDetailUrl = $GLOBALS["a_sales"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_Customer_Number=" . urlencode($this->Customer_Number->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "a_customerslist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`a_customers`";
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
			if (array_key_exists('Customer_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('Customer_ID', $this->DBID) . '=' . ew_QuotedValue($rs['Customer_ID'], $this->Customer_ID->FldDataType, $this->DBID));
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
		return "`Customer_ID` = @Customer_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Customer_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Customer_ID@", ew_AdjustSql($this->Customer_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "a_customerslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "a_customerslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("a_customersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("a_customersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "a_customersadd.php?" . $this->UrlParm($parm);
		else
			$url = "a_customersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("a_customersedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("a_customersedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("a_customersadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("a_customersadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("a_customersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Customer_ID:" . ew_VarToJson($this->Customer_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Customer_ID->CurrentValue)) {
			$sUrl .= "Customer_ID=" . urlencode($this->Customer_ID->CurrentValue);
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
			if ($isPost && isset($_POST["Customer_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["Customer_ID"]);
			elseif (isset($_GET["Customer_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["Customer_ID"]);
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
			$this->Customer_ID->CurrentValue = $key;
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
		$this->Customer_ID->setDbValue($rs->fields('Customer_ID'));
		$this->Customer_Number->setDbValue($rs->fields('Customer_Number'));
		$this->Customer_Name->setDbValue($rs->fields('Customer_Name'));
		$this->Address->setDbValue($rs->fields('Address'));
		$this->City->setDbValue($rs->fields('City'));
		$this->Country->setDbValue($rs->fields('Country'));
		$this->Contact_Person->setDbValue($rs->fields('Contact_Person'));
		$this->Phone_Number->setDbValue($rs->fields('Phone_Number'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Mobile_Number->setDbValue($rs->fields('Mobile_Number'));
		$this->Notes->setDbValue($rs->fields('Notes'));
		$this->Balance->setDbValue($rs->fields('Balance'));
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
		// Customer_ID

		$this->Customer_ID->CellCssStyle = "white-space: nowrap;";

		// Customer_Number
		// Customer_Name
		// Address

		$this->Address->CellCssStyle = "white-space: nowrap;";

		// City
		$this->City->CellCssStyle = "white-space: nowrap;";

		// Country
		$this->Country->CellCssStyle = "white-space: nowrap;";

		// Contact_Person
		// Phone_Number
		// Email
		// Mobile_Number
		// Notes

		$this->Notes->CellCssStyle = "white-space: nowrap;";

		// Balance
		// Date_Added
		// Added_By
		// Date_Updated
		// Updated_By
		// Customer_ID

		$this->Customer_ID->ViewValue = $this->Customer_ID->CurrentValue;
		$this->Customer_ID->ViewCustomAttributes = "";

		// Customer_Number
		$this->Customer_Number->ViewValue = $this->Customer_Number->CurrentValue;
		$this->Customer_Number->ViewCustomAttributes = "";

		// Customer_Name
		$this->Customer_Name->ViewValue = $this->Customer_Name->CurrentValue;
		$this->Customer_Name->ViewCustomAttributes = "";

		// Address
		$this->Address->ViewValue = $this->Address->CurrentValue;
		$this->Address->ViewCustomAttributes = "";

		// City
		$this->City->ViewValue = $this->City->CurrentValue;
		$this->City->ViewCustomAttributes = "";

		// Country
		$this->Country->ViewValue = $this->Country->CurrentValue;
		$this->Country->ViewCustomAttributes = "";

		// Contact_Person
		$this->Contact_Person->ViewValue = $this->Contact_Person->CurrentValue;
		$this->Contact_Person->ViewCustomAttributes = "";

		// Phone_Number
		$this->Phone_Number->ViewValue = $this->Phone_Number->CurrentValue;
		$this->Phone_Number->ViewCustomAttributes = "";

		// Email
		$this->_Email->ViewValue = $this->_Email->CurrentValue;
		$this->_Email->ViewCustomAttributes = "";

		// Mobile_Number
		$this->Mobile_Number->ViewValue = $this->Mobile_Number->CurrentValue;
		$this->Mobile_Number->ViewCustomAttributes = "";

		// Notes
		$this->Notes->ViewValue = $this->Notes->CurrentValue;
		$this->Notes->ViewCustomAttributes = "";

		// Balance
		$this->Balance->ViewValue = $this->Balance->CurrentValue;
		$this->Balance->ViewValue = ew_FormatCurrency($this->Balance->ViewValue, 2, -2, -2, -2);
		$this->Balance->CellCssStyle .= "text-align: right;";
		$this->Balance->ViewCustomAttributes = "";

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

		// Customer_ID
		$this->Customer_ID->LinkCustomAttributes = "";
		$this->Customer_ID->HrefValue = "";
		$this->Customer_ID->TooltipValue = "";

		// Customer_Number
		$this->Customer_Number->LinkCustomAttributes = "";
		$this->Customer_Number->HrefValue = "";
		$this->Customer_Number->TooltipValue = "";

		// Customer_Name
		$this->Customer_Name->LinkCustomAttributes = "";
		$this->Customer_Name->HrefValue = "";
		$this->Customer_Name->TooltipValue = "";

		// Address
		$this->Address->LinkCustomAttributes = "";
		$this->Address->HrefValue = "";
		$this->Address->TooltipValue = "";

		// City
		$this->City->LinkCustomAttributes = "";
		$this->City->HrefValue = "";
		$this->City->TooltipValue = "";

		// Country
		$this->Country->LinkCustomAttributes = "";
		$this->Country->HrefValue = "";
		$this->Country->TooltipValue = "";

		// Contact_Person
		$this->Contact_Person->LinkCustomAttributes = "";
		$this->Contact_Person->HrefValue = "";
		$this->Contact_Person->TooltipValue = "";

		// Phone_Number
		$this->Phone_Number->LinkCustomAttributes = "";
		$this->Phone_Number->HrefValue = "";
		$this->Phone_Number->TooltipValue = "";

		// Email
		$this->_Email->LinkCustomAttributes = "";
		$this->_Email->HrefValue = "";
		$this->_Email->TooltipValue = "";

		// Mobile_Number
		$this->Mobile_Number->LinkCustomAttributes = "";
		$this->Mobile_Number->HrefValue = "";
		$this->Mobile_Number->TooltipValue = "";

		// Notes
		$this->Notes->LinkCustomAttributes = "";
		$this->Notes->HrefValue = "";
		$this->Notes->TooltipValue = "";

		// Balance
		$this->Balance->LinkCustomAttributes = "";
		$this->Balance->HrefValue = "";
		$this->Balance->TooltipValue = "";

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

		// Customer_ID
		$this->Customer_ID->EditAttrs["class"] = "form-control";
		$this->Customer_ID->EditCustomAttributes = "";
		$this->Customer_ID->EditValue = $this->Customer_ID->CurrentValue;
		$this->Customer_ID->ViewCustomAttributes = "";

		// Customer_Number
		$this->Customer_Number->EditAttrs["class"] = "form-control";
		$this->Customer_Number->EditCustomAttributes = "";
		$this->Customer_Number->EditValue = $this->Customer_Number->CurrentValue;
		$this->Customer_Number->PlaceHolder = ew_RemoveHtml($this->Customer_Number->FldCaption());

		// Customer_Name
		$this->Customer_Name->EditAttrs["class"] = "form-control";
		$this->Customer_Name->EditCustomAttributes = "";
		$this->Customer_Name->EditValue = $this->Customer_Name->CurrentValue;
		$this->Customer_Name->PlaceHolder = ew_RemoveHtml($this->Customer_Name->FldCaption());

		// Address
		$this->Address->EditAttrs["class"] = "form-control";
		$this->Address->EditCustomAttributes = "";
		$this->Address->EditValue = $this->Address->CurrentValue;
		$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

		// City
		$this->City->EditAttrs["class"] = "form-control";
		$this->City->EditCustomAttributes = "";
		$this->City->EditValue = $this->City->CurrentValue;
		$this->City->PlaceHolder = ew_RemoveHtml($this->City->FldCaption());

		// Country
		$this->Country->EditAttrs["class"] = "form-control";
		$this->Country->EditCustomAttributes = "";
		$this->Country->EditValue = $this->Country->CurrentValue;
		$this->Country->PlaceHolder = ew_RemoveHtml($this->Country->FldCaption());

		// Contact_Person
		$this->Contact_Person->EditAttrs["class"] = "form-control";
		$this->Contact_Person->EditCustomAttributes = "";
		$this->Contact_Person->EditValue = $this->Contact_Person->CurrentValue;
		$this->Contact_Person->PlaceHolder = ew_RemoveHtml($this->Contact_Person->FldCaption());

		// Phone_Number
		$this->Phone_Number->EditAttrs["class"] = "form-control";
		$this->Phone_Number->EditCustomAttributes = "";
		$this->Phone_Number->EditValue = $this->Phone_Number->CurrentValue;
		$this->Phone_Number->PlaceHolder = ew_RemoveHtml($this->Phone_Number->FldCaption());

		// Email
		$this->_Email->EditAttrs["class"] = "form-control";
		$this->_Email->EditCustomAttributes = "";
		$this->_Email->EditValue = $this->_Email->CurrentValue;
		$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

		// Mobile_Number
		$this->Mobile_Number->EditAttrs["class"] = "form-control";
		$this->Mobile_Number->EditCustomAttributes = "";
		$this->Mobile_Number->EditValue = $this->Mobile_Number->CurrentValue;
		$this->Mobile_Number->PlaceHolder = ew_RemoveHtml($this->Mobile_Number->FldCaption());

		// Notes
		$this->Notes->EditAttrs["class"] = "form-control";
		$this->Notes->EditCustomAttributes = "";
		$this->Notes->EditValue = $this->Notes->CurrentValue;
		$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

		// Balance
		$this->Balance->EditAttrs["class"] = "form-control";
		$this->Balance->EditCustomAttributes = "";
		$this->Balance->EditValue = $this->Balance->CurrentValue;
		$this->Balance->PlaceHolder = ew_RemoveHtml($this->Balance->FldCaption());
		if (strval($this->Balance->EditValue) <> "" && is_numeric($this->Balance->EditValue)) $this->Balance->EditValue = ew_FormatNumber($this->Balance->EditValue, -2, -2, -2, -2);

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
			if (is_numeric($this->Balance->CurrentValue))
				$this->Balance->Total += $this->Balance->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
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
					if ($this->Customer_ID->Exportable) $Doc->ExportCaption($this->Customer_ID);
					if ($this->Customer_Number->Exportable) $Doc->ExportCaption($this->Customer_Number);
					if ($this->Customer_Name->Exportable) $Doc->ExportCaption($this->Customer_Name);
					if ($this->Address->Exportable) $Doc->ExportCaption($this->Address);
					if ($this->City->Exportable) $Doc->ExportCaption($this->City);
					if ($this->Country->Exportable) $Doc->ExportCaption($this->Country);
					if ($this->Contact_Person->Exportable) $Doc->ExportCaption($this->Contact_Person);
					if ($this->Phone_Number->Exportable) $Doc->ExportCaption($this->Phone_Number);
					if ($this->_Email->Exportable) $Doc->ExportCaption($this->_Email);
					if ($this->Mobile_Number->Exportable) $Doc->ExportCaption($this->Mobile_Number);
					if ($this->Notes->Exportable) $Doc->ExportCaption($this->Notes);
					if ($this->Balance->Exportable) $Doc->ExportCaption($this->Balance);
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
					if ($this->Customer_Number->Exportable) $Doc->ExportCaption($this->Customer_Number);
					if ($this->Customer_Name->Exportable) $Doc->ExportCaption($this->Customer_Name);
					if ($this->Contact_Person->Exportable) $Doc->ExportCaption($this->Contact_Person);
					if ($this->Phone_Number->Exportable) $Doc->ExportCaption($this->Phone_Number);
					if ($this->Mobile_Number->Exportable) $Doc->ExportCaption($this->Mobile_Number);
					if ($this->Balance->Exportable) $Doc->ExportCaption($this->Balance);
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
						if ($this->Customer_ID->Exportable) $Doc->ExportField($this->Customer_ID);
						if ($this->Customer_Number->Exportable) $Doc->ExportField($this->Customer_Number);
						if ($this->Customer_Name->Exportable) $Doc->ExportField($this->Customer_Name);
						if ($this->Address->Exportable) $Doc->ExportField($this->Address);
						if ($this->City->Exportable) $Doc->ExportField($this->City);
						if ($this->Country->Exportable) $Doc->ExportField($this->Country);
						if ($this->Contact_Person->Exportable) $Doc->ExportField($this->Contact_Person);
						if ($this->Phone_Number->Exportable) $Doc->ExportField($this->Phone_Number);
						if ($this->_Email->Exportable) $Doc->ExportField($this->_Email);
						if ($this->Mobile_Number->Exportable) $Doc->ExportField($this->Mobile_Number);
						if ($this->Notes->Exportable) $Doc->ExportField($this->Notes);
						if ($this->Balance->Exportable) $Doc->ExportField($this->Balance);
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
						if ($this->Customer_Number->Exportable) $Doc->ExportField($this->Customer_Number);
						if ($this->Customer_Name->Exportable) $Doc->ExportField($this->Customer_Name);
						if ($this->Contact_Person->Exportable) $Doc->ExportField($this->Contact_Person);
						if ($this->Phone_Number->Exportable) $Doc->ExportField($this->Phone_Number);
						if ($this->Mobile_Number->Exportable) $Doc->ExportField($this->Mobile_Number);
						if ($this->Balance->Exportable) $Doc->ExportField($this->Balance);
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
				$Doc->ExportAggregate($this->Customer_Number, '');
				$Doc->ExportAggregate($this->Customer_Name, '');
				$Doc->ExportAggregate($this->Contact_Person, '');
				$Doc->ExportAggregate($this->Phone_Number, '');
				$Doc->ExportAggregate($this->Mobile_Number, '');
				$Doc->ExportAggregate($this->Balance, 'TOTAL');
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

		$rsnew["Customer_Number"] = GetNextCustomerNumber();
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

		$validate_balance = ValidateCustomerBalance($rsold["Customer_Number"]);
		if ($rsnew["Balance"] <> $validate_balance) {
			$rsnew["Balance"] = $validate_balance;
		}
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
			$this->Customer_Number->CurrentValue = GetNextCustomerNumber();
			$this->Customer_Number->EditValue = $this->Customer_Number->CurrentValue; 
			$this->Customer_Number->ReadOnly = TRUE; 
		}

		// Confirm mode
		if ($this->CurrentAction == "add" && $this->CurrentAction=="F") {
			$this->Customer_Number->ViewValue = $this->Customer_Number->CurrentValue;
		}
		if (CurrentPageID() == "list") {
			$this->Balance->CellCssStyle = "text-align: right;";
		}
		if (CurrentPageID() == "list") {
			$this->Balance->CellCssStyle = "text-align: right;";
		}
		if ($this->RowType == EW_ROWTYPE_AGGREGATE) {
			$this->Balance->ViewValue = "<div style='text-align: right; font-weight: bold;'>".$this->Balance->ViewValue."</div>";
		}	
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
