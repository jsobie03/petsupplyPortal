<?php

// Global variable for table object
$help = NULL;

//
// Table class for help
//
class chelp extends cTable {
	var $Help_ID;
	var $_Language;
	var $Topic;
	var $Description;
	var $Category;
	var $Order;
	var $Display_in_Page;
	var $Updated_By;
	var $Last_Updated;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'help';
		$this->TableName = 'help';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`help`";
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

		// Help_ID
		$this->Help_ID = new cField('help', 'help', 'x_Help_ID', 'Help_ID', '`Help_ID`', '`Help_ID`', 3, -1, FALSE, '`Help_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Help_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Help_ID'] = &$this->Help_ID;

		// Language
		$this->_Language = new cField('help', 'help', 'x__Language', 'Language', '`Language`', '`Language`', 200, -1, FALSE, '`Language`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Language'] = &$this->_Language;

		// Topic
		$this->Topic = new cField('help', 'help', 'x_Topic', 'Topic', '`Topic`', '`Topic`', 200, -1, FALSE, '`Topic`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Topic'] = &$this->Topic;

		// Description
		$this->Description = new cField('help', 'help', 'x_Description', 'Description', '`Description`', '`Description`', 201, -1, FALSE, '`Description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['Description'] = &$this->Description;

		// Category
		$this->Category = new cField('help', 'help', 'x_Category', 'Category', '`Category`', '`Category`', 3, -1, FALSE, '`Category`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Category->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Category'] = &$this->Category;

		// Order
		$this->Order = new cField('help', 'help', 'x_Order', 'Order', '`Order`', '`Order`', 3, -1, FALSE, '`Order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Order->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Order'] = &$this->Order;

		// Display_in_Page
		$this->Display_in_Page = new cField('help', 'help', 'x_Display_in_Page', 'Display_in_Page', '`Display_in_Page`', '`Display_in_Page`', 200, -1, FALSE, '`Display_in_Page`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Display_in_Page'] = &$this->Display_in_Page;

		// Updated_By
		$this->Updated_By = new cField('help', 'help', 'x_Updated_By', 'Updated_By', '`Updated_By`', '`Updated_By`', 200, -1, FALSE, '`Updated_By`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Updated_By'] = &$this->Updated_By;

		// Last_Updated
		$this->Last_Updated = new cField('help', 'help', 'x_Last_Updated', 'Last_Updated', '`Last_Updated`', 'DATE_FORMAT(`Last_Updated`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`Last_Updated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Last_Updated->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Last_Updated'] = &$this->Last_Updated;
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
		if ($this->getCurrentMasterTable() == "help_categories") {
			if ($this->Category->getSessionValue() <> "")
				$sMasterFilter .= "`Category_ID`=" . ew_QuotedValue($this->Category->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "help_categories") {
			if ($this->Category->getSessionValue() <> "")
				$sDetailFilter .= "`Category`=" . ew_QuotedValue($this->Category->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_help_categories() {
		return "`Category_ID`=@Category_ID@";
	}

	// Detail filter
	function SqlDetailFilter_help_categories() {
		return "`Category`=@Category@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`help`";
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
			if (array_key_exists('Help_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('Help_ID', $this->DBID) . '=' . ew_QuotedValue($rs['Help_ID'], $this->Help_ID->FldDataType, $this->DBID));
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
		return "`Help_ID` = @Help_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Help_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Help_ID@", ew_AdjustSql($this->Help_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "helplist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "helplist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("helpview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("helpview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "helpadd.php?" . $this->UrlParm($parm);
		else
			$url = "helpadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("helpedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("helpadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("helpdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "help_categories" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_Category_ID=" . urlencode($this->Category->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Help_ID:" . ew_VarToJson($this->Help_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Help_ID->CurrentValue)) {
			$sUrl .= "Help_ID=" . urlencode($this->Help_ID->CurrentValue);
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
			if ($isPost && isset($_POST["Help_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["Help_ID"]);
			elseif (isset($_GET["Help_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["Help_ID"]);
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
			$this->Help_ID->CurrentValue = $key;
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
		$this->Help_ID->setDbValue($rs->fields('Help_ID'));
		$this->_Language->setDbValue($rs->fields('Language'));
		$this->Topic->setDbValue($rs->fields('Topic'));
		$this->Description->setDbValue($rs->fields('Description'));
		$this->Category->setDbValue($rs->fields('Category'));
		$this->Order->setDbValue($rs->fields('Order'));
		$this->Display_in_Page->setDbValue($rs->fields('Display_in_Page'));
		$this->Updated_By->setDbValue($rs->fields('Updated_By'));
		$this->Last_Updated->setDbValue($rs->fields('Last_Updated'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Help_ID
		// Language
		// Topic
		// Description
		// Category
		// Order
		// Display_in_Page
		// Updated_By
		// Last_Updated
		// Help_ID

		$this->Help_ID->ViewValue = $this->Help_ID->CurrentValue;
		$this->Help_ID->ViewCustomAttributes = "";

		// Language
		if (strval($this->_Language->CurrentValue) <> "") {
			$sFilterWrk = "`Language_Code`" . ew_SearchString("=", $this->_Language->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Language_Code`, `Language_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `languages`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Language_Code`, `Language_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `languages`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->_Language, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->_Language->ViewValue = $this->_Language->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->_Language->ViewValue = $this->_Language->CurrentValue;
			}
		} else {
			$this->_Language->ViewValue = NULL;
		}
		$this->_Language->ViewCustomAttributes = "";

		// Topic
		$this->Topic->ViewValue = $this->Topic->CurrentValue;
		$this->Topic->ViewCustomAttributes = "";

		// Description
		$this->Description->ViewValue = $this->Description->CurrentValue;
		$this->Description->ViewCustomAttributes = "";

		// Category
		if (strval($this->Category->CurrentValue) <> "") {
			$sFilterWrk = "`Category_ID`" . ew_SearchString("=", $this->Category->CurrentValue, EW_DATATYPE_NUMBER, "");
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

		// Order
		$this->Order->ViewValue = $this->Order->CurrentValue;
		$this->Order->ViewCustomAttributes = "";

		// Display_in_Page
		$this->Display_in_Page->ViewValue = $this->Display_in_Page->CurrentValue;
		$this->Display_in_Page->ViewCustomAttributes = "";

		// Updated_By
		if (strval($this->Updated_By->CurrentValue) <> "") {
			$sFilterWrk = "`Username`" . ew_SearchString("=", $this->Updated_By->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Username`, `First_Name` AS `DispFld`, `Last_Name` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `users`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Username`, `First_Name` AS `DispFld`, `Last_Name` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `users`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Updated_By, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Updated_By->ViewValue = $this->Updated_By->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Updated_By->ViewValue = $this->Updated_By->CurrentValue;
			}
		} else {
			$this->Updated_By->ViewValue = NULL;
		}
		$this->Updated_By->ViewCustomAttributes = "";

		// Last_Updated
		$this->Last_Updated->ViewValue = $this->Last_Updated->CurrentValue;
		$this->Last_Updated->ViewValue = ew_FormatDateTime($this->Last_Updated->ViewValue, 9);
		$this->Last_Updated->ViewCustomAttributes = "";

		// Help_ID
		$this->Help_ID->LinkCustomAttributes = "";
		$this->Help_ID->HrefValue = "";
		$this->Help_ID->TooltipValue = "";

		// Language
		$this->_Language->LinkCustomAttributes = "";
		$this->_Language->HrefValue = "";
		$this->_Language->TooltipValue = "";

		// Topic
		$this->Topic->LinkCustomAttributes = "";
		$this->Topic->HrefValue = "";
		$this->Topic->TooltipValue = "";

		// Description
		$this->Description->LinkCustomAttributes = "";
		$this->Description->HrefValue = "";
		$this->Description->TooltipValue = "";

		// Category
		$this->Category->LinkCustomAttributes = "";
		$this->Category->HrefValue = "";
		$this->Category->TooltipValue = "";

		// Order
		$this->Order->LinkCustomAttributes = "";
		$this->Order->HrefValue = "";
		$this->Order->TooltipValue = "";

		// Display_in_Page
		$this->Display_in_Page->LinkCustomAttributes = "";
		$this->Display_in_Page->HrefValue = "";
		$this->Display_in_Page->TooltipValue = "";

		// Updated_By
		$this->Updated_By->LinkCustomAttributes = "";
		$this->Updated_By->HrefValue = "";
		$this->Updated_By->TooltipValue = "";

		// Last_Updated
		$this->Last_Updated->LinkCustomAttributes = "";
		$this->Last_Updated->HrefValue = "";
		$this->Last_Updated->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Help_ID
		$this->Help_ID->EditAttrs["class"] = "form-control";
		$this->Help_ID->EditCustomAttributes = "";
		$this->Help_ID->EditValue = $this->Help_ID->CurrentValue;
		$this->Help_ID->ViewCustomAttributes = "";

		// Language
		$this->_Language->EditAttrs["class"] = "form-control";
		$this->_Language->EditCustomAttributes = "";

		// Topic
		$this->Topic->EditAttrs["class"] = "form-control";
		$this->Topic->EditCustomAttributes = "";
		$this->Topic->EditValue = $this->Topic->CurrentValue;
		$this->Topic->PlaceHolder = ew_RemoveHtml($this->Topic->FldCaption());

		// Description
		$this->Description->EditAttrs["class"] = "form-control";
		$this->Description->EditCustomAttributes = "";
		$this->Description->EditValue = $this->Description->CurrentValue;
		$this->Description->PlaceHolder = ew_RemoveHtml($this->Description->FldCaption());

		// Category
		$this->Category->EditAttrs["class"] = "form-control";
		$this->Category->EditCustomAttributes = "";
		if ($this->Category->getSessionValue() <> "") {
			$this->Category->CurrentValue = $this->Category->getSessionValue();
		if (strval($this->Category->CurrentValue) <> "") {
			$sFilterWrk = "`Category_ID`" . ew_SearchString("=", $this->Category->CurrentValue, EW_DATATYPE_NUMBER, "");
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
		} else {
		}

		// Order
		$this->Order->EditAttrs["class"] = "form-control";
		$this->Order->EditCustomAttributes = "";
		$this->Order->EditValue = $this->Order->CurrentValue;
		$this->Order->PlaceHolder = ew_RemoveHtml($this->Order->FldCaption());

		// Display_in_Page
		$this->Display_in_Page->EditAttrs["class"] = "form-control";
		$this->Display_in_Page->EditCustomAttributes = "";
		$this->Display_in_Page->EditValue = $this->Display_in_Page->CurrentValue;
		$this->Display_in_Page->PlaceHolder = ew_RemoveHtml($this->Display_in_Page->FldCaption());

		// Updated_By
		// Last_Updated
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
					if ($this->Help_ID->Exportable) $Doc->ExportCaption($this->Help_ID);
					if ($this->_Language->Exportable) $Doc->ExportCaption($this->_Language);
					if ($this->Topic->Exportable) $Doc->ExportCaption($this->Topic);
					if ($this->Description->Exportable) $Doc->ExportCaption($this->Description);
					if ($this->Category->Exportable) $Doc->ExportCaption($this->Category);
					if ($this->Order->Exportable) $Doc->ExportCaption($this->Order);
					if ($this->Display_in_Page->Exportable) $Doc->ExportCaption($this->Display_in_Page);
					if ($this->Updated_By->Exportable) $Doc->ExportCaption($this->Updated_By);
					if ($this->Last_Updated->Exportable) $Doc->ExportCaption($this->Last_Updated);
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
					if ($this->Topic->Exportable) $Doc->ExportCaption($this->Topic);
					if ($this->Description->Exportable) $Doc->ExportCaption($this->Description);
					if ($this->Category->Exportable) $Doc->ExportCaption($this->Category);
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
						if ($this->Help_ID->Exportable) $Doc->ExportField($this->Help_ID);
						if ($this->_Language->Exportable) $Doc->ExportField($this->_Language);
						if ($this->Topic->Exportable) $Doc->ExportField($this->Topic);
						if ($this->Description->Exportable) $Doc->ExportField($this->Description);
						if ($this->Category->Exportable) $Doc->ExportField($this->Category);
						if ($this->Order->Exportable) $Doc->ExportField($this->Order);
						if ($this->Display_in_Page->Exportable) $Doc->ExportField($this->Display_in_Page);
						if ($this->Updated_By->Exportable) $Doc->ExportField($this->Updated_By);
						if ($this->Last_Updated->Exportable) $Doc->ExportField($this->Last_Updated);
					} else {

					// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) {  
							$Doc->ExportText(ew_FormatSeqNo(CurrentPage()->getStartRecordNumber()+$RowCnt-1));
						}

					 // End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if ($this->Topic->Exportable) $Doc->ExportField($this->Topic);
						if ($this->Description->Exportable) $Doc->ExportField($this->Description);
						if ($this->Category->Exportable) $Doc->ExportField($this->Category);
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
