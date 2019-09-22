<?php

// Global variable for table object
$languages = NULL;

//
// Table class for languages
//
class clanguages extends cTable {
	var $Language_Code;
	var $Language_Name;
	var $_Default;
	var $Site_Logo;
	var $Site_Title;
	var $Default_Thousands_Separator;
	var $Default_Decimal_Point;
	var $Default_Currency_Symbol;
	var $Default_Money_Thousands_Separator;
	var $Default_Money_Decimal_Point;
	var $Terms_And_Condition_Text;
	var $Announcement_Text;
	var $About_Text;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'languages';
		$this->TableName = 'languages';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`languages`";
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

		// Language_Code
		$this->Language_Code = new cField('languages', 'languages', 'x_Language_Code', 'Language_Code', '`Language_Code`', '`Language_Code`', 200, -1, FALSE, '`Language_Code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Language_Code'] = &$this->Language_Code;

		// Language_Name
		$this->Language_Name = new cField('languages', 'languages', 'x_Language_Name', 'Language_Name', '`Language_Name`', '`Language_Name`', 200, -1, FALSE, '`Language_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Language_Name'] = &$this->Language_Name;

		// Default
		$this->_Default = new cField('languages', 'languages', 'x__Default', 'Default', '`Default`', '`Default`', 202, -1, FALSE, '`Default`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->_Default->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->_Default->TrueValue = 'Y';
		$this->_Default->FalseValue = 'N';
		$this->_Default->OptionCount = 2;
		$this->fields['Default'] = &$this->_Default;

		// Site_Logo
		$this->Site_Logo = new cField('languages', 'languages', 'x_Site_Logo', 'Site_Logo', '`Site_Logo`', '`Site_Logo`', 200, -1, FALSE, '`Site_Logo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Site_Logo'] = &$this->Site_Logo;

		// Site_Title
		$this->Site_Title = new cField('languages', 'languages', 'x_Site_Title', 'Site_Title', '`Site_Title`', '`Site_Title`', 200, -1, FALSE, '`Site_Title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Site_Title'] = &$this->Site_Title;

		// Default_Thousands_Separator
		$this->Default_Thousands_Separator = new cField('languages', 'languages', 'x_Default_Thousands_Separator', 'Default_Thousands_Separator', '`Default_Thousands_Separator`', '`Default_Thousands_Separator`', 200, -1, FALSE, '`Default_Thousands_Separator`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Thousands_Separator'] = &$this->Default_Thousands_Separator;

		// Default_Decimal_Point
		$this->Default_Decimal_Point = new cField('languages', 'languages', 'x_Default_Decimal_Point', 'Default_Decimal_Point', '`Default_Decimal_Point`', '`Default_Decimal_Point`', 200, -1, FALSE, '`Default_Decimal_Point`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Decimal_Point'] = &$this->Default_Decimal_Point;

		// Default_Currency_Symbol
		$this->Default_Currency_Symbol = new cField('languages', 'languages', 'x_Default_Currency_Symbol', 'Default_Currency_Symbol', '`Default_Currency_Symbol`', '`Default_Currency_Symbol`', 200, -1, FALSE, '`Default_Currency_Symbol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Currency_Symbol'] = &$this->Default_Currency_Symbol;

		// Default_Money_Thousands_Separator
		$this->Default_Money_Thousands_Separator = new cField('languages', 'languages', 'x_Default_Money_Thousands_Separator', 'Default_Money_Thousands_Separator', '`Default_Money_Thousands_Separator`', '`Default_Money_Thousands_Separator`', 200, -1, FALSE, '`Default_Money_Thousands_Separator`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Money_Thousands_Separator'] = &$this->Default_Money_Thousands_Separator;

		// Default_Money_Decimal_Point
		$this->Default_Money_Decimal_Point = new cField('languages', 'languages', 'x_Default_Money_Decimal_Point', 'Default_Money_Decimal_Point', '`Default_Money_Decimal_Point`', '`Default_Money_Decimal_Point`', 200, -1, FALSE, '`Default_Money_Decimal_Point`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Default_Money_Decimal_Point'] = &$this->Default_Money_Decimal_Point;

		// Terms_And_Condition_Text
		$this->Terms_And_Condition_Text = new cField('languages', 'languages', 'x_Terms_And_Condition_Text', 'Terms_And_Condition_Text', '`Terms_And_Condition_Text`', '`Terms_And_Condition_Text`', 201, -1, FALSE, '`Terms_And_Condition_Text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['Terms_And_Condition_Text'] = &$this->Terms_And_Condition_Text;

		// Announcement_Text
		$this->Announcement_Text = new cField('languages', 'languages', 'x_Announcement_Text', 'Announcement_Text', '`Announcement_Text`', '`Announcement_Text`', 201, -1, FALSE, '`Announcement_Text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['Announcement_Text'] = &$this->Announcement_Text;

		// About_Text
		$this->About_Text = new cField('languages', 'languages', 'x_About_Text', 'About_Text', '`About_Text`', '`About_Text`', 201, -1, FALSE, '`About_Text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['About_Text'] = &$this->About_Text;
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`languages`";
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
			if (array_key_exists('Language_Code', $rs))
				ew_AddFilter($where, ew_QuotedName('Language_Code', $this->DBID) . '=' . ew_QuotedValue($rs['Language_Code'], $this->Language_Code->FldDataType, $this->DBID));
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
		return "`Language_Code` = '@Language_Code@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@Language_Code@", ew_AdjustSql($this->Language_Code->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "languageslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "languageslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("languagesview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("languagesview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "languagesadd.php?" . $this->UrlParm($parm);
		else
			$url = "languagesadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("languagesedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("languagesadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("languagesdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Language_Code:" . ew_VarToJson($this->Language_Code->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Language_Code->CurrentValue)) {
			$sUrl .= "Language_Code=" . urlencode($this->Language_Code->CurrentValue);
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
			if ($isPost && isset($_POST["Language_Code"]))
				$arKeys[] = ew_StripSlashes($_POST["Language_Code"]);
			elseif (isset($_GET["Language_Code"]))
				$arKeys[] = ew_StripSlashes($_GET["Language_Code"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
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
			$this->Language_Code->CurrentValue = $key;
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
		$this->Language_Code->setDbValue($rs->fields('Language_Code'));
		$this->Language_Name->setDbValue($rs->fields('Language_Name'));
		$this->_Default->setDbValue($rs->fields('Default'));
		$this->Site_Logo->setDbValue($rs->fields('Site_Logo'));
		$this->Site_Title->setDbValue($rs->fields('Site_Title'));
		$this->Default_Thousands_Separator->setDbValue($rs->fields('Default_Thousands_Separator'));
		$this->Default_Decimal_Point->setDbValue($rs->fields('Default_Decimal_Point'));
		$this->Default_Currency_Symbol->setDbValue($rs->fields('Default_Currency_Symbol'));
		$this->Default_Money_Thousands_Separator->setDbValue($rs->fields('Default_Money_Thousands_Separator'));
		$this->Default_Money_Decimal_Point->setDbValue($rs->fields('Default_Money_Decimal_Point'));
		$this->Terms_And_Condition_Text->setDbValue($rs->fields('Terms_And_Condition_Text'));
		$this->Announcement_Text->setDbValue($rs->fields('Announcement_Text'));
		$this->About_Text->setDbValue($rs->fields('About_Text'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Language_Code
		// Language_Name
		// Default
		// Site_Logo
		// Site_Title
		// Default_Thousands_Separator
		// Default_Decimal_Point
		// Default_Currency_Symbol
		// Default_Money_Thousands_Separator
		// Default_Money_Decimal_Point
		// Terms_And_Condition_Text
		// Announcement_Text
		// About_Text
		// Language_Code

		$this->Language_Code->ViewValue = $this->Language_Code->CurrentValue;
		$this->Language_Code->ViewCustomAttributes = "";

		// Language_Name
		$this->Language_Name->ViewValue = $this->Language_Name->CurrentValue;
		$this->Language_Name->ViewCustomAttributes = "";

		// Default
		if (ew_ConvertToBool($this->_Default->CurrentValue)) {
			$this->_Default->ViewValue = $this->_Default->FldTagCaption(1) <> "" ? $this->_Default->FldTagCaption(1) : "Y";
		} else {
			$this->_Default->ViewValue = $this->_Default->FldTagCaption(2) <> "" ? $this->_Default->FldTagCaption(2) : "N";
		}
		$this->_Default->ViewCustomAttributes = "";

		// Site_Logo
		$this->Site_Logo->ViewValue = $this->Site_Logo->CurrentValue;
		$this->Site_Logo->ViewCustomAttributes = "";

		// Site_Title
		$this->Site_Title->ViewValue = $this->Site_Title->CurrentValue;
		$this->Site_Title->ViewCustomAttributes = "";

		// Default_Thousands_Separator
		$this->Default_Thousands_Separator->ViewValue = $this->Default_Thousands_Separator->CurrentValue;
		$this->Default_Thousands_Separator->ViewCustomAttributes = "";

		// Default_Decimal_Point
		$this->Default_Decimal_Point->ViewValue = $this->Default_Decimal_Point->CurrentValue;
		$this->Default_Decimal_Point->ViewCustomAttributes = "";

		// Default_Currency_Symbol
		$this->Default_Currency_Symbol->ViewValue = $this->Default_Currency_Symbol->CurrentValue;
		$this->Default_Currency_Symbol->ViewCustomAttributes = "";

		// Default_Money_Thousands_Separator
		$this->Default_Money_Thousands_Separator->ViewValue = $this->Default_Money_Thousands_Separator->CurrentValue;
		$this->Default_Money_Thousands_Separator->ViewCustomAttributes = "";

		// Default_Money_Decimal_Point
		$this->Default_Money_Decimal_Point->ViewValue = $this->Default_Money_Decimal_Point->CurrentValue;
		$this->Default_Money_Decimal_Point->ViewCustomAttributes = "";

		// Terms_And_Condition_Text
		$this->Terms_And_Condition_Text->ViewValue = $this->Terms_And_Condition_Text->CurrentValue;
		$this->Terms_And_Condition_Text->ViewCustomAttributes = "";

		// Announcement_Text
		$this->Announcement_Text->ViewValue = $this->Announcement_Text->CurrentValue;
		$this->Announcement_Text->ViewCustomAttributes = "";

		// About_Text
		$this->About_Text->ViewValue = $this->About_Text->CurrentValue;
		$this->About_Text->ViewCustomAttributes = "";

		// Language_Code
		$this->Language_Code->LinkCustomAttributes = "";
		$this->Language_Code->HrefValue = "";
		$this->Language_Code->TooltipValue = "";

		// Language_Name
		$this->Language_Name->LinkCustomAttributes = "";
		$this->Language_Name->HrefValue = "";
		$this->Language_Name->TooltipValue = "";

		// Default
		$this->_Default->LinkCustomAttributes = "";
		$this->_Default->HrefValue = "";
		$this->_Default->TooltipValue = "";

		// Site_Logo
		$this->Site_Logo->LinkCustomAttributes = "";
		$this->Site_Logo->HrefValue = "";
		$this->Site_Logo->TooltipValue = "";

		// Site_Title
		$this->Site_Title->LinkCustomAttributes = "";
		$this->Site_Title->HrefValue = "";
		$this->Site_Title->TooltipValue = "";

		// Default_Thousands_Separator
		$this->Default_Thousands_Separator->LinkCustomAttributes = "";
		$this->Default_Thousands_Separator->HrefValue = "";
		$this->Default_Thousands_Separator->TooltipValue = "";

		// Default_Decimal_Point
		$this->Default_Decimal_Point->LinkCustomAttributes = "";
		$this->Default_Decimal_Point->HrefValue = "";
		$this->Default_Decimal_Point->TooltipValue = "";

		// Default_Currency_Symbol
		$this->Default_Currency_Symbol->LinkCustomAttributes = "";
		$this->Default_Currency_Symbol->HrefValue = "";
		$this->Default_Currency_Symbol->TooltipValue = "";

		// Default_Money_Thousands_Separator
		$this->Default_Money_Thousands_Separator->LinkCustomAttributes = "";
		$this->Default_Money_Thousands_Separator->HrefValue = "";
		$this->Default_Money_Thousands_Separator->TooltipValue = "";

		// Default_Money_Decimal_Point
		$this->Default_Money_Decimal_Point->LinkCustomAttributes = "";
		$this->Default_Money_Decimal_Point->HrefValue = "";
		$this->Default_Money_Decimal_Point->TooltipValue = "";

		// Terms_And_Condition_Text
		$this->Terms_And_Condition_Text->LinkCustomAttributes = "";
		$this->Terms_And_Condition_Text->HrefValue = "";
		$this->Terms_And_Condition_Text->TooltipValue = "";

		// Announcement_Text
		$this->Announcement_Text->LinkCustomAttributes = "";
		$this->Announcement_Text->HrefValue = "";
		$this->Announcement_Text->TooltipValue = "";

		// About_Text
		$this->About_Text->LinkCustomAttributes = "";
		$this->About_Text->HrefValue = "";
		$this->About_Text->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Language_Code
		$this->Language_Code->EditAttrs["class"] = "form-control";
		$this->Language_Code->EditCustomAttributes = "";
		$this->Language_Code->EditValue = $this->Language_Code->CurrentValue;
		$this->Language_Code->ViewCustomAttributes = "";

		// Language_Name
		$this->Language_Name->EditAttrs["class"] = "form-control";
		$this->Language_Name->EditCustomAttributes = "";
		$this->Language_Name->EditValue = $this->Language_Name->CurrentValue;
		$this->Language_Name->PlaceHolder = ew_RemoveHtml($this->Language_Name->FldCaption());

		// Default
		$this->_Default->EditCustomAttributes = "";
		$this->_Default->EditValue = $this->_Default->Options(FALSE);

		// Site_Logo
		$this->Site_Logo->EditAttrs["class"] = "form-control";
		$this->Site_Logo->EditCustomAttributes = "";
		$this->Site_Logo->EditValue = $this->Site_Logo->CurrentValue;
		$this->Site_Logo->PlaceHolder = ew_RemoveHtml($this->Site_Logo->FldCaption());

		// Site_Title
		$this->Site_Title->EditAttrs["class"] = "form-control";
		$this->Site_Title->EditCustomAttributes = "";
		$this->Site_Title->EditValue = $this->Site_Title->CurrentValue;
		$this->Site_Title->PlaceHolder = ew_RemoveHtml($this->Site_Title->FldCaption());

		// Default_Thousands_Separator
		$this->Default_Thousands_Separator->EditAttrs["class"] = "form-control";
		$this->Default_Thousands_Separator->EditCustomAttributes = "";
		$this->Default_Thousands_Separator->EditValue = $this->Default_Thousands_Separator->CurrentValue;
		$this->Default_Thousands_Separator->PlaceHolder = ew_RemoveHtml($this->Default_Thousands_Separator->FldCaption());

		// Default_Decimal_Point
		$this->Default_Decimal_Point->EditAttrs["class"] = "form-control";
		$this->Default_Decimal_Point->EditCustomAttributes = "";
		$this->Default_Decimal_Point->EditValue = $this->Default_Decimal_Point->CurrentValue;
		$this->Default_Decimal_Point->PlaceHolder = ew_RemoveHtml($this->Default_Decimal_Point->FldCaption());

		// Default_Currency_Symbol
		$this->Default_Currency_Symbol->EditAttrs["class"] = "form-control";
		$this->Default_Currency_Symbol->EditCustomAttributes = "";
		$this->Default_Currency_Symbol->EditValue = $this->Default_Currency_Symbol->CurrentValue;
		$this->Default_Currency_Symbol->PlaceHolder = ew_RemoveHtml($this->Default_Currency_Symbol->FldCaption());

		// Default_Money_Thousands_Separator
		$this->Default_Money_Thousands_Separator->EditAttrs["class"] = "form-control";
		$this->Default_Money_Thousands_Separator->EditCustomAttributes = "";
		$this->Default_Money_Thousands_Separator->EditValue = $this->Default_Money_Thousands_Separator->CurrentValue;
		$this->Default_Money_Thousands_Separator->PlaceHolder = ew_RemoveHtml($this->Default_Money_Thousands_Separator->FldCaption());

		// Default_Money_Decimal_Point
		$this->Default_Money_Decimal_Point->EditAttrs["class"] = "form-control";
		$this->Default_Money_Decimal_Point->EditCustomAttributes = "";
		$this->Default_Money_Decimal_Point->EditValue = $this->Default_Money_Decimal_Point->CurrentValue;
		$this->Default_Money_Decimal_Point->PlaceHolder = ew_RemoveHtml($this->Default_Money_Decimal_Point->FldCaption());

		// Terms_And_Condition_Text
		$this->Terms_And_Condition_Text->EditAttrs["class"] = "form-control";
		$this->Terms_And_Condition_Text->EditCustomAttributes = "";
		$this->Terms_And_Condition_Text->EditValue = $this->Terms_And_Condition_Text->CurrentValue;
		$this->Terms_And_Condition_Text->PlaceHolder = ew_RemoveHtml($this->Terms_And_Condition_Text->FldCaption());

		// Announcement_Text
		$this->Announcement_Text->EditAttrs["class"] = "form-control";
		$this->Announcement_Text->EditCustomAttributes = "";
		$this->Announcement_Text->EditValue = $this->Announcement_Text->CurrentValue;
		$this->Announcement_Text->PlaceHolder = ew_RemoveHtml($this->Announcement_Text->FldCaption());

		// About_Text
		$this->About_Text->EditAttrs["class"] = "form-control";
		$this->About_Text->EditCustomAttributes = "";
		$this->About_Text->EditValue = $this->About_Text->CurrentValue;
		$this->About_Text->PlaceHolder = ew_RemoveHtml($this->About_Text->FldCaption());

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
					if ($this->Language_Code->Exportable) $Doc->ExportCaption($this->Language_Code);
					if ($this->Language_Name->Exportable) $Doc->ExportCaption($this->Language_Name);
					if ($this->_Default->Exportable) $Doc->ExportCaption($this->_Default);
					if ($this->Site_Logo->Exportable) $Doc->ExportCaption($this->Site_Logo);
					if ($this->Site_Title->Exportable) $Doc->ExportCaption($this->Site_Title);
					if ($this->Default_Thousands_Separator->Exportable) $Doc->ExportCaption($this->Default_Thousands_Separator);
					if ($this->Default_Decimal_Point->Exportable) $Doc->ExportCaption($this->Default_Decimal_Point);
					if ($this->Default_Currency_Symbol->Exportable) $Doc->ExportCaption($this->Default_Currency_Symbol);
					if ($this->Default_Money_Thousands_Separator->Exportable) $Doc->ExportCaption($this->Default_Money_Thousands_Separator);
					if ($this->Default_Money_Decimal_Point->Exportable) $Doc->ExportCaption($this->Default_Money_Decimal_Point);
					if ($this->Terms_And_Condition_Text->Exportable) $Doc->ExportCaption($this->Terms_And_Condition_Text);
					if ($this->Announcement_Text->Exportable) $Doc->ExportCaption($this->Announcement_Text);
					if ($this->About_Text->Exportable) $Doc->ExportCaption($this->About_Text);
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
					if ($this->Language_Code->Exportable) $Doc->ExportCaption($this->Language_Code);
					if ($this->Language_Name->Exportable) $Doc->ExportCaption($this->Language_Name);
					if ($this->_Default->Exportable) $Doc->ExportCaption($this->_Default);
					if ($this->Site_Logo->Exportable) $Doc->ExportCaption($this->Site_Logo);
					if ($this->Site_Title->Exportable) $Doc->ExportCaption($this->Site_Title);
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
						if ($this->Language_Code->Exportable) $Doc->ExportField($this->Language_Code);
						if ($this->Language_Name->Exportable) $Doc->ExportField($this->Language_Name);
						if ($this->_Default->Exportable) $Doc->ExportField($this->_Default);
						if ($this->Site_Logo->Exportable) $Doc->ExportField($this->Site_Logo);
						if ($this->Site_Title->Exportable) $Doc->ExportField($this->Site_Title);
						if ($this->Default_Thousands_Separator->Exportable) $Doc->ExportField($this->Default_Thousands_Separator);
						if ($this->Default_Decimal_Point->Exportable) $Doc->ExportField($this->Default_Decimal_Point);
						if ($this->Default_Currency_Symbol->Exportable) $Doc->ExportField($this->Default_Currency_Symbol);
						if ($this->Default_Money_Thousands_Separator->Exportable) $Doc->ExportField($this->Default_Money_Thousands_Separator);
						if ($this->Default_Money_Decimal_Point->Exportable) $Doc->ExportField($this->Default_Money_Decimal_Point);
						if ($this->Terms_And_Condition_Text->Exportable) $Doc->ExportField($this->Terms_And_Condition_Text);
						if ($this->Announcement_Text->Exportable) $Doc->ExportField($this->Announcement_Text);
						if ($this->About_Text->Exportable) $Doc->ExportField($this->About_Text);
					} else {

					// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) {  
							$Doc->ExportText(ew_FormatSeqNo(CurrentPage()->getStartRecordNumber()+$RowCnt-1));
						}

					 // End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if ($this->Language_Code->Exportable) $Doc->ExportField($this->Language_Code);
						if ($this->Language_Name->Exportable) $Doc->ExportField($this->Language_Name);
						if ($this->_Default->Exportable) $Doc->ExportField($this->_Default);
						if ($this->Site_Logo->Exportable) $Doc->ExportField($this->Site_Logo);
						if ($this->Site_Title->Exportable) $Doc->ExportField($this->Site_Title);
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
