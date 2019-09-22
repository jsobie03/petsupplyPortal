<?php

// Global variable for table object
$users = NULL;

//
// Table class for users
//
class cusers extends cTable {
	var $Username;
	var $Password;
	var $First_Name;
	var $Last_Name;
	var $_Email;
	var $User_Level;
	var $Report_To;
	var $Activated;
	var $Locked;
	var $Profile;
	var $Current_URL;
	var $Theme;
	var $Menu_Horizontal;
	var $Table_Width_Style;
	var $Scroll_Table_Width;
	var $Scroll_Table_Height;
	var $Rows_Vertical_Align_Top;
	var $_Language;
	var $Redirect_To_Last_Visited_Page_After_Login;
	var $Font_Name;
	var $Font_Size;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'users';
		$this->TableName = 'users';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`users`";
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

		// Username
		$this->Username = new cField('users', 'users', 'x_Username', 'Username', '`Username`', '`Username`', 200, -1, FALSE, '`Username`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Username'] = &$this->Username;

		// Password
		$this->Password = new cField('users', 'users', 'x_Password', 'Password', '`Password`', '`Password`', 200, -1, FALSE, '`Password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'PASSWORD');
		$this->fields['Password'] = &$this->Password;

		// First_Name
		$this->First_Name = new cField('users', 'users', 'x_First_Name', 'First_Name', '`First_Name`', '`First_Name`', 200, -1, FALSE, '`First_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['First_Name'] = &$this->First_Name;

		// Last_Name
		$this->Last_Name = new cField('users', 'users', 'x_Last_Name', 'Last_Name', '`Last_Name`', '`Last_Name`', 200, -1, FALSE, '`Last_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Last_Name'] = &$this->Last_Name;

		// Email
		$this->_Email = new cField('users', 'users', 'x__Email', 'Email', '`Email`', '`Email`', 200, -1, FALSE, '`Email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_Email->FldDefaultErrMsg = $Language->Phrase("IncorrectEmail");
		$this->fields['Email'] = &$this->_Email;

		// User_Level
		$this->User_Level = new cField('users', 'users', 'x_User_Level', 'User_Level', '`User_Level`', '`User_Level`', 3, -1, FALSE, '`User_Level`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->User_Level->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['User_Level'] = &$this->User_Level;

		// Report_To
		$this->Report_To = new cField('users', 'users', 'x_Report_To', 'Report_To', '`Report_To`', '`Report_To`', 3, -1, FALSE, '`Report_To`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Report_To->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Report_To'] = &$this->Report_To;

		// Activated
		$this->Activated = new cField('users', 'users', 'x_Activated', 'Activated', '`Activated`', '`Activated`', 202, -1, FALSE, '`Activated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Activated->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Activated->TrueValue = 'Y';
		$this->Activated->FalseValue = 'N';
		$this->Activated->OptionCount = 2;
		$this->fields['Activated'] = &$this->Activated;

		// Locked
		$this->Locked = new cField('users', 'users', 'x_Locked', 'Locked', '`Locked`', '`Locked`', 202, -1, FALSE, '`Locked`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Locked->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Locked->TrueValue = 'Y';
		$this->Locked->FalseValue = 'N';
		$this->Locked->OptionCount = 2;
		$this->fields['Locked'] = &$this->Locked;

		// Profile
		$this->Profile = new cField('users', 'users', 'x_Profile', 'Profile', '`Profile`', '`Profile`', 201, -1, FALSE, '`Profile`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['Profile'] = &$this->Profile;

		// Current_URL
		$this->Current_URL = new cField('users', 'users', 'x_Current_URL', 'Current_URL', '`Current_URL`', '`Current_URL`', 201, -1, FALSE, '`Current_URL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['Current_URL'] = &$this->Current_URL;

		// Theme
		$this->Theme = new cField('users', 'users', 'x_Theme', 'Theme', '`Theme`', '`Theme`', 200, -1, FALSE, '`Theme`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Theme'] = &$this->Theme;

		// Menu_Horizontal
		$this->Menu_Horizontal = new cField('users', 'users', 'x_Menu_Horizontal', 'Menu_Horizontal', '`Menu_Horizontal`', '`Menu_Horizontal`', 202, -1, FALSE, '`Menu_Horizontal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Menu_Horizontal->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Menu_Horizontal->TrueValue = 'Y';
		$this->Menu_Horizontal->FalseValue = 'N';
		$this->Menu_Horizontal->OptionCount = 2;
		$this->fields['Menu_Horizontal'] = &$this->Menu_Horizontal;

		// Table_Width_Style
		$this->Table_Width_Style = new cField('users', 'users', 'x_Table_Width_Style', 'Table_Width_Style', '`Table_Width_Style`', '`Table_Width_Style`', 202, -1, FALSE, '`Table_Width_Style`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Table_Width_Style->OptionCount = 3;
		$this->fields['Table_Width_Style'] = &$this->Table_Width_Style;

		// Scroll_Table_Width
		$this->Scroll_Table_Width = new cField('users', 'users', 'x_Scroll_Table_Width', 'Scroll_Table_Width', '`Scroll_Table_Width`', '`Scroll_Table_Width`', 3, -1, FALSE, '`Scroll_Table_Width`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Scroll_Table_Width->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Scroll_Table_Width'] = &$this->Scroll_Table_Width;

		// Scroll_Table_Height
		$this->Scroll_Table_Height = new cField('users', 'users', 'x_Scroll_Table_Height', 'Scroll_Table_Height', '`Scroll_Table_Height`', '`Scroll_Table_Height`', 3, -1, FALSE, '`Scroll_Table_Height`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Scroll_Table_Height->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Scroll_Table_Height'] = &$this->Scroll_Table_Height;

		// Rows_Vertical_Align_Top
		$this->Rows_Vertical_Align_Top = new cField('users', 'users', 'x_Rows_Vertical_Align_Top', 'Rows_Vertical_Align_Top', '`Rows_Vertical_Align_Top`', '`Rows_Vertical_Align_Top`', 202, -1, FALSE, '`Rows_Vertical_Align_Top`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Rows_Vertical_Align_Top->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Rows_Vertical_Align_Top->TrueValue = 'Y';
		$this->Rows_Vertical_Align_Top->FalseValue = 'N';
		$this->Rows_Vertical_Align_Top->OptionCount = 2;
		$this->fields['Rows_Vertical_Align_Top'] = &$this->Rows_Vertical_Align_Top;

		// Language
		$this->_Language = new cField('users', 'users', 'x__Language', 'Language', '`Language`', '`Language`', 200, -1, FALSE, '`Language`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Language'] = &$this->_Language;

		// Redirect_To_Last_Visited_Page_After_Login
		$this->Redirect_To_Last_Visited_Page_After_Login = new cField('users', 'users', 'x_Redirect_To_Last_Visited_Page_After_Login', 'Redirect_To_Last_Visited_Page_After_Login', '`Redirect_To_Last_Visited_Page_After_Login`', '`Redirect_To_Last_Visited_Page_After_Login`', 202, -1, FALSE, '`Redirect_To_Last_Visited_Page_After_Login`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Redirect_To_Last_Visited_Page_After_Login->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Redirect_To_Last_Visited_Page_After_Login->TrueValue = 'Y';
		$this->Redirect_To_Last_Visited_Page_After_Login->FalseValue = 'N';
		$this->Redirect_To_Last_Visited_Page_After_Login->OptionCount = 2;
		$this->fields['Redirect_To_Last_Visited_Page_After_Login'] = &$this->Redirect_To_Last_Visited_Page_After_Login;

		// Font_Name
		$this->Font_Name = new cField('users', 'users', 'x_Font_Name', 'Font_Name', '`Font_Name`', '`Font_Name`', 200, -1, FALSE, '`Font_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Font_Name->OptionCount = 14;
		$this->fields['Font_Name'] = &$this->Font_Name;

		// Font_Size
		$this->Font_Size = new cField('users', 'users', 'x_Font_Size', 'Font_Size', '`Font_Size`', '`Font_Size`', 200, -1, FALSE, '`Font_Size`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Font_Size->OptionCount = 4;
		$this->fields['Font_Size'] = &$this->Font_Size;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`users`";
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'Password')
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'Password') {
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
			}
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
			if (array_key_exists('Username', $rs))
				ew_AddFilter($where, ew_QuotedName('Username', $this->DBID) . '=' . ew_QuotedValue($rs['Username'], $this->Username->FldDataType, $this->DBID));
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
		return "`Username` = '@Username@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@Username@", ew_AdjustSql($this->Username->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "userslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "userslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("usersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("usersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "usersadd.php?" . $this->UrlParm($parm);
		else
			$url = "usersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("usersedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("usersadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("usersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Username:" . ew_VarToJson($this->Username->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Username->CurrentValue)) {
			$sUrl .= "Username=" . urlencode($this->Username->CurrentValue);
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
			if ($isPost && isset($_POST["Username"]))
				$arKeys[] = ew_StripSlashes($_POST["Username"]);
			elseif (isset($_GET["Username"]))
				$arKeys[] = ew_StripSlashes($_GET["Username"]);
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
			$this->Username->CurrentValue = $key;
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
		$this->Username->setDbValue($rs->fields('Username'));
		$this->Password->setDbValue($rs->fields('Password'));
		$this->First_Name->setDbValue($rs->fields('First_Name'));
		$this->Last_Name->setDbValue($rs->fields('Last_Name'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->User_Level->setDbValue($rs->fields('User_Level'));
		$this->Report_To->setDbValue($rs->fields('Report_To'));
		$this->Activated->setDbValue($rs->fields('Activated'));
		$this->Locked->setDbValue($rs->fields('Locked'));
		$this->Profile->setDbValue($rs->fields('Profile'));
		$this->Current_URL->setDbValue($rs->fields('Current_URL'));
		$this->Theme->setDbValue($rs->fields('Theme'));
		$this->Menu_Horizontal->setDbValue($rs->fields('Menu_Horizontal'));
		$this->Table_Width_Style->setDbValue($rs->fields('Table_Width_Style'));
		$this->Scroll_Table_Width->setDbValue($rs->fields('Scroll_Table_Width'));
		$this->Scroll_Table_Height->setDbValue($rs->fields('Scroll_Table_Height'));
		$this->Rows_Vertical_Align_Top->setDbValue($rs->fields('Rows_Vertical_Align_Top'));
		$this->_Language->setDbValue($rs->fields('Language'));
		$this->Redirect_To_Last_Visited_Page_After_Login->setDbValue($rs->fields('Redirect_To_Last_Visited_Page_After_Login'));
		$this->Font_Name->setDbValue($rs->fields('Font_Name'));
		$this->Font_Size->setDbValue($rs->fields('Font_Size'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Username
		// Password
		// First_Name
		// Last_Name
		// Email
		// User_Level
		// Report_To
		// Activated
		// Locked
		// Profile
		// Current_URL
		// Theme
		// Menu_Horizontal
		// Table_Width_Style
		// Scroll_Table_Width
		// Scroll_Table_Height
		// Rows_Vertical_Align_Top
		// Language
		// Redirect_To_Last_Visited_Page_After_Login
		// Font_Name
		// Font_Size
		// Username

		$this->Username->ViewValue = $this->Username->CurrentValue;
		$this->Username->ViewCustomAttributes = "";

		// Password
		$this->Password->ViewValue = $Language->Phrase("PasswordMask");
		$this->Password->ViewCustomAttributes = "";

		// First_Name
		$this->First_Name->ViewValue = $this->First_Name->CurrentValue;
		$this->First_Name->ViewCustomAttributes = "";

		// Last_Name
		$this->Last_Name->ViewValue = $this->Last_Name->CurrentValue;
		$this->Last_Name->ViewCustomAttributes = "";

		// Email
		$this->_Email->ViewValue = $this->_Email->CurrentValue;
		$this->_Email->ViewCustomAttributes = "";

		// User_Level
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->User_Level->CurrentValue) <> "") {
			$sFilterWrk = "`User_Level_ID`" . ew_SearchString("=", $this->User_Level->CurrentValue, EW_DATATYPE_NUMBER, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `User_Level_ID`, `User_Level_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `User_Level_ID`, `User_Level_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->User_Level, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->User_Level->ViewValue = $this->User_Level->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->User_Level->ViewValue = $this->User_Level->CurrentValue;
			}
		} else {
			$this->User_Level->ViewValue = NULL;
		}
		} else {
			$this->User_Level->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->User_Level->ViewCustomAttributes = "";

		// Report_To
		$this->Report_To->ViewValue = $this->Report_To->CurrentValue;
		$this->Report_To->ViewCustomAttributes = "";

		// Activated
		if (ew_ConvertToBool($this->Activated->CurrentValue)) {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(2) <> "" ? $this->Activated->FldTagCaption(2) : "Yes";
		} else {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(1) <> "" ? $this->Activated->FldTagCaption(1) : "No";
		}
		$this->Activated->ViewCustomAttributes = "";

		// Locked
		if (ew_ConvertToBool($this->Locked->CurrentValue)) {
			$this->Locked->ViewValue = $this->Locked->FldTagCaption(1) <> "" ? $this->Locked->FldTagCaption(1) : "Yes";
		} else {
			$this->Locked->ViewValue = $this->Locked->FldTagCaption(2) <> "" ? $this->Locked->FldTagCaption(2) : "No";
		}
		$this->Locked->ViewCustomAttributes = "";

		// Profile
		$this->Profile->ViewValue = $this->Profile->CurrentValue;
		$this->Profile->ViewCustomAttributes = "";

		// Current_URL
		$this->Current_URL->ViewValue = $this->Current_URL->CurrentValue;
		$this->Current_URL->ViewCustomAttributes = "";

		// Theme
		if (strval($this->Theme->CurrentValue) <> "") {
			$sFilterWrk = "`Theme_ID`" . ew_SearchString("=", $this->Theme->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Theme_ID`, `Theme_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `themes`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Theme_ID`, `Theme_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `themes`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Theme, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Theme->ViewValue = $this->Theme->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Theme->ViewValue = $this->Theme->CurrentValue;
			}
		} else {
			$this->Theme->ViewValue = NULL;
		}
		$this->Theme->ViewCustomAttributes = "";

		// Menu_Horizontal
		if (ew_ConvertToBool($this->Menu_Horizontal->CurrentValue)) {
			$this->Menu_Horizontal->ViewValue = $this->Menu_Horizontal->FldTagCaption(2) <> "" ? $this->Menu_Horizontal->FldTagCaption(2) : "Yes";
		} else {
			$this->Menu_Horizontal->ViewValue = $this->Menu_Horizontal->FldTagCaption(1) <> "" ? $this->Menu_Horizontal->FldTagCaption(1) : "No";
		}
		$this->Menu_Horizontal->ViewCustomAttributes = "";

		// Table_Width_Style
		if (strval($this->Table_Width_Style->CurrentValue) <> "") {
			$this->Table_Width_Style->ViewValue = $this->Table_Width_Style->OptionCaption($this->Table_Width_Style->CurrentValue);
		} else {
			$this->Table_Width_Style->ViewValue = NULL;
		}
		$this->Table_Width_Style->ViewCustomAttributes = "";

		// Scroll_Table_Width
		$this->Scroll_Table_Width->ViewValue = $this->Scroll_Table_Width->CurrentValue;
		$this->Scroll_Table_Width->ViewCustomAttributes = "";

		// Scroll_Table_Height
		$this->Scroll_Table_Height->ViewValue = $this->Scroll_Table_Height->CurrentValue;
		$this->Scroll_Table_Height->ViewCustomAttributes = "";

		// Rows_Vertical_Align_Top
		if (ew_ConvertToBool($this->Rows_Vertical_Align_Top->CurrentValue)) {
			$this->Rows_Vertical_Align_Top->ViewValue = $this->Rows_Vertical_Align_Top->FldTagCaption(1) <> "" ? $this->Rows_Vertical_Align_Top->FldTagCaption(1) : "Yes";
		} else {
			$this->Rows_Vertical_Align_Top->ViewValue = $this->Rows_Vertical_Align_Top->FldTagCaption(2) <> "" ? $this->Rows_Vertical_Align_Top->FldTagCaption(2) : "No";
		}
		$this->Rows_Vertical_Align_Top->ViewCustomAttributes = "";

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

		// Redirect_To_Last_Visited_Page_After_Login
		if (ew_ConvertToBool($this->Redirect_To_Last_Visited_Page_After_Login->CurrentValue)) {
			$this->Redirect_To_Last_Visited_Page_After_Login->ViewValue = $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(1) <> "" ? $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(1) : "Yes";
		} else {
			$this->Redirect_To_Last_Visited_Page_After_Login->ViewValue = $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(2) <> "" ? $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(2) : "No";
		}
		$this->Redirect_To_Last_Visited_Page_After_Login->ViewCustomAttributes = "";

		// Font_Name
		if (strval($this->Font_Name->CurrentValue) <> "") {
			$this->Font_Name->ViewValue = $this->Font_Name->OptionCaption($this->Font_Name->CurrentValue);
		} else {
			$this->Font_Name->ViewValue = NULL;
		}
		$this->Font_Name->ViewCustomAttributes = "";

		// Font_Size
		if (strval($this->Font_Size->CurrentValue) <> "") {
			$this->Font_Size->ViewValue = $this->Font_Size->OptionCaption($this->Font_Size->CurrentValue);
		} else {
			$this->Font_Size->ViewValue = NULL;
		}
		$this->Font_Size->ViewCustomAttributes = "";

		// Username
		$this->Username->LinkCustomAttributes = "";
		$this->Username->HrefValue = "";
		$this->Username->TooltipValue = "";

		// Password
		$this->Password->LinkCustomAttributes = "";
		$this->Password->HrefValue = "";
		$this->Password->TooltipValue = "";

		// First_Name
		$this->First_Name->LinkCustomAttributes = "";
		$this->First_Name->HrefValue = "";
		$this->First_Name->TooltipValue = "";

		// Last_Name
		$this->Last_Name->LinkCustomAttributes = "";
		$this->Last_Name->HrefValue = "";
		$this->Last_Name->TooltipValue = "";

		// Email
		$this->_Email->LinkCustomAttributes = "";
		$this->_Email->HrefValue = "";
		$this->_Email->TooltipValue = "";

		// User_Level
		$this->User_Level->LinkCustomAttributes = "";
		$this->User_Level->HrefValue = "";
		$this->User_Level->TooltipValue = "";

		// Report_To
		$this->Report_To->LinkCustomAttributes = "";
		$this->Report_To->HrefValue = "";
		$this->Report_To->TooltipValue = "";

		// Activated
		$this->Activated->LinkCustomAttributes = "";
		$this->Activated->HrefValue = "";
		$this->Activated->TooltipValue = "";

		// Locked
		$this->Locked->LinkCustomAttributes = "";
		$this->Locked->HrefValue = "";
		$this->Locked->TooltipValue = "";

		// Profile
		$this->Profile->LinkCustomAttributes = "";
		$this->Profile->HrefValue = "";
		$this->Profile->TooltipValue = "";

		// Current_URL
		$this->Current_URL->LinkCustomAttributes = "";
		$this->Current_URL->HrefValue = "";
		$this->Current_URL->TooltipValue = "";

		// Theme
		$this->Theme->LinkCustomAttributes = "";
		$this->Theme->HrefValue = "";
		$this->Theme->TooltipValue = "";

		// Menu_Horizontal
		$this->Menu_Horizontal->LinkCustomAttributes = "";
		$this->Menu_Horizontal->HrefValue = "";
		$this->Menu_Horizontal->TooltipValue = "";

		// Table_Width_Style
		$this->Table_Width_Style->LinkCustomAttributes = "";
		$this->Table_Width_Style->HrefValue = "";
		$this->Table_Width_Style->TooltipValue = "";

		// Scroll_Table_Width
		$this->Scroll_Table_Width->LinkCustomAttributes = "";
		$this->Scroll_Table_Width->HrefValue = "";
		$this->Scroll_Table_Width->TooltipValue = "";

		// Scroll_Table_Height
		$this->Scroll_Table_Height->LinkCustomAttributes = "";
		$this->Scroll_Table_Height->HrefValue = "";
		$this->Scroll_Table_Height->TooltipValue = "";

		// Rows_Vertical_Align_Top
		$this->Rows_Vertical_Align_Top->LinkCustomAttributes = "";
		$this->Rows_Vertical_Align_Top->HrefValue = "";
		$this->Rows_Vertical_Align_Top->TooltipValue = "";

		// Language
		$this->_Language->LinkCustomAttributes = "";
		$this->_Language->HrefValue = "";
		$this->_Language->TooltipValue = "";

		// Redirect_To_Last_Visited_Page_After_Login
		$this->Redirect_To_Last_Visited_Page_After_Login->LinkCustomAttributes = "";
		$this->Redirect_To_Last_Visited_Page_After_Login->HrefValue = "";
		$this->Redirect_To_Last_Visited_Page_After_Login->TooltipValue = "";

		// Font_Name
		$this->Font_Name->LinkCustomAttributes = "";
		$this->Font_Name->HrefValue = "";
		$this->Font_Name->TooltipValue = "";

		// Font_Size
		$this->Font_Size->LinkCustomAttributes = "";
		$this->Font_Size->HrefValue = "";
		$this->Font_Size->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Username
		$this->Username->EditAttrs["class"] = "form-control";
		$this->Username->EditCustomAttributes = "";
		$this->Username->EditValue = $this->Username->CurrentValue;
		$this->Username->ViewCustomAttributes = "";

		// Password
		$this->Password->EditAttrs["class"] = "form-control ewPasswordStrength";
		$this->Password->EditCustomAttributes = "";
		$this->Password->EditValue = $this->Password->CurrentValue;
		$this->Password->PlaceHolder = ew_RemoveHtml($this->Password->FldCaption());

		// First_Name
		$this->First_Name->EditAttrs["class"] = "form-control";
		$this->First_Name->EditCustomAttributes = "";
		$this->First_Name->EditValue = $this->First_Name->CurrentValue;
		$this->First_Name->PlaceHolder = ew_RemoveHtml($this->First_Name->FldCaption());

		// Last_Name
		$this->Last_Name->EditAttrs["class"] = "form-control";
		$this->Last_Name->EditCustomAttributes = "";
		$this->Last_Name->EditValue = $this->Last_Name->CurrentValue;
		$this->Last_Name->PlaceHolder = ew_RemoveHtml($this->Last_Name->FldCaption());

		// Email
		$this->_Email->EditAttrs["class"] = "form-control";
		$this->_Email->EditCustomAttributes = "";
		$this->_Email->EditValue = $this->_Email->CurrentValue;
		$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

		// User_Level
		$this->User_Level->EditAttrs["class"] = "form-control";
		$this->User_Level->EditCustomAttributes = "";
		if (!$Security->CanAdmin()) { // System admin
			$this->User_Level->EditValue = $Language->Phrase("PasswordMask");
		} else {
		}

		// Report_To
		$this->Report_To->EditAttrs["class"] = "form-control";
		$this->Report_To->EditCustomAttributes = "";
		$this->Report_To->EditValue = $this->Report_To->CurrentValue;
		$this->Report_To->PlaceHolder = ew_RemoveHtml($this->Report_To->FldCaption());

		// Activated
		$this->Activated->EditAttrs["class"] = "form-control";
		$this->Activated->EditCustomAttributes = "";
		$this->Activated->EditValue = $this->Activated->Options(TRUE);

		// Locked
		$this->Locked->EditCustomAttributes = "";
		$this->Locked->EditValue = $this->Locked->Options(FALSE);

		// Profile
		$this->Profile->EditAttrs["class"] = "form-control";
		$this->Profile->EditCustomAttributes = "";
		$this->Profile->EditValue = $this->Profile->CurrentValue;
		$this->Profile->PlaceHolder = ew_RemoveHtml($this->Profile->FldCaption());

		// Current_URL
		$this->Current_URL->EditAttrs["class"] = "form-control";
		$this->Current_URL->EditCustomAttributes = "";
		$this->Current_URL->EditValue = $this->Current_URL->CurrentValue;
		$this->Current_URL->PlaceHolder = ew_RemoveHtml($this->Current_URL->FldCaption());

		// Theme
		$this->Theme->EditAttrs["class"] = "form-control";
		$this->Theme->EditCustomAttributes = "";

		// Menu_Horizontal
		$this->Menu_Horizontal->EditCustomAttributes = "";
		$this->Menu_Horizontal->EditValue = $this->Menu_Horizontal->Options(FALSE);

		// Table_Width_Style
		$this->Table_Width_Style->EditCustomAttributes = "";
		$this->Table_Width_Style->EditValue = $this->Table_Width_Style->Options(FALSE);

		// Scroll_Table_Width
		$this->Scroll_Table_Width->EditAttrs["class"] = "form-control";
		$this->Scroll_Table_Width->EditCustomAttributes = "";
		$this->Scroll_Table_Width->EditValue = $this->Scroll_Table_Width->CurrentValue;
		$this->Scroll_Table_Width->PlaceHolder = ew_RemoveHtml($this->Scroll_Table_Width->FldCaption());

		// Scroll_Table_Height
		$this->Scroll_Table_Height->EditAttrs["class"] = "form-control";
		$this->Scroll_Table_Height->EditCustomAttributes = "";
		$this->Scroll_Table_Height->EditValue = $this->Scroll_Table_Height->CurrentValue;
		$this->Scroll_Table_Height->PlaceHolder = ew_RemoveHtml($this->Scroll_Table_Height->FldCaption());

		// Rows_Vertical_Align_Top
		$this->Rows_Vertical_Align_Top->EditCustomAttributes = "";
		$this->Rows_Vertical_Align_Top->EditValue = $this->Rows_Vertical_Align_Top->Options(FALSE);

		// Language
		$this->_Language->EditAttrs["class"] = "form-control";
		$this->_Language->EditCustomAttributes = "";

		// Redirect_To_Last_Visited_Page_After_Login
		$this->Redirect_To_Last_Visited_Page_After_Login->EditCustomAttributes = "";
		$this->Redirect_To_Last_Visited_Page_After_Login->EditValue = $this->Redirect_To_Last_Visited_Page_After_Login->Options(FALSE);

		// Font_Name
		$this->Font_Name->EditAttrs["class"] = "form-control";
		$this->Font_Name->EditCustomAttributes = "";
		$this->Font_Name->EditValue = $this->Font_Name->Options(TRUE);

		// Font_Size
		$this->Font_Size->EditAttrs["class"] = "form-control";
		$this->Font_Size->EditCustomAttributes = "";
		$this->Font_Size->EditValue = $this->Font_Size->Options(TRUE);

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
					if ($this->Username->Exportable) $Doc->ExportCaption($this->Username);
					if ($this->Password->Exportable) $Doc->ExportCaption($this->Password);
					if ($this->First_Name->Exportable) $Doc->ExportCaption($this->First_Name);
					if ($this->Last_Name->Exportable) $Doc->ExportCaption($this->Last_Name);
					if ($this->_Email->Exportable) $Doc->ExportCaption($this->_Email);
					if ($this->User_Level->Exportable) $Doc->ExportCaption($this->User_Level);
					if ($this->Report_To->Exportable) $Doc->ExportCaption($this->Report_To);
					if ($this->Activated->Exportable) $Doc->ExportCaption($this->Activated);
					if ($this->Locked->Exportable) $Doc->ExportCaption($this->Locked);
					if ($this->Profile->Exportable) $Doc->ExportCaption($this->Profile);
					if ($this->Current_URL->Exportable) $Doc->ExportCaption($this->Current_URL);
					if ($this->Theme->Exportable) $Doc->ExportCaption($this->Theme);
					if ($this->Menu_Horizontal->Exportable) $Doc->ExportCaption($this->Menu_Horizontal);
					if ($this->Table_Width_Style->Exportable) $Doc->ExportCaption($this->Table_Width_Style);
					if ($this->Scroll_Table_Width->Exportable) $Doc->ExportCaption($this->Scroll_Table_Width);
					if ($this->Scroll_Table_Height->Exportable) $Doc->ExportCaption($this->Scroll_Table_Height);
					if ($this->Rows_Vertical_Align_Top->Exportable) $Doc->ExportCaption($this->Rows_Vertical_Align_Top);
					if ($this->_Language->Exportable) $Doc->ExportCaption($this->_Language);
					if ($this->Redirect_To_Last_Visited_Page_After_Login->Exportable) $Doc->ExportCaption($this->Redirect_To_Last_Visited_Page_After_Login);
					if ($this->Font_Name->Exportable) $Doc->ExportCaption($this->Font_Name);
					if ($this->Font_Size->Exportable) $Doc->ExportCaption($this->Font_Size);
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
					if ($this->Username->Exportable) $Doc->ExportCaption($this->Username);
					if ($this->First_Name->Exportable) $Doc->ExportCaption($this->First_Name);
					if ($this->Last_Name->Exportable) $Doc->ExportCaption($this->Last_Name);
					if ($this->_Email->Exportable) $Doc->ExportCaption($this->_Email);
					if ($this->Activated->Exportable) $Doc->ExportCaption($this->Activated);
					if ($this->Locked->Exportable) $Doc->ExportCaption($this->Locked);
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
						if ($this->Username->Exportable) $Doc->ExportField($this->Username);
						if ($this->Password->Exportable) $Doc->ExportField($this->Password);
						if ($this->First_Name->Exportable) $Doc->ExportField($this->First_Name);
						if ($this->Last_Name->Exportable) $Doc->ExportField($this->Last_Name);
						if ($this->_Email->Exportable) $Doc->ExportField($this->_Email);
						if ($this->User_Level->Exportable) $Doc->ExportField($this->User_Level);
						if ($this->Report_To->Exportable) $Doc->ExportField($this->Report_To);
						if ($this->Activated->Exportable) $Doc->ExportField($this->Activated);
						if ($this->Locked->Exportable) $Doc->ExportField($this->Locked);
						if ($this->Profile->Exportable) $Doc->ExportField($this->Profile);
						if ($this->Current_URL->Exportable) $Doc->ExportField($this->Current_URL);
						if ($this->Theme->Exportable) $Doc->ExportField($this->Theme);
						if ($this->Menu_Horizontal->Exportable) $Doc->ExportField($this->Menu_Horizontal);
						if ($this->Table_Width_Style->Exportable) $Doc->ExportField($this->Table_Width_Style);
						if ($this->Scroll_Table_Width->Exportable) $Doc->ExportField($this->Scroll_Table_Width);
						if ($this->Scroll_Table_Height->Exportable) $Doc->ExportField($this->Scroll_Table_Height);
						if ($this->Rows_Vertical_Align_Top->Exportable) $Doc->ExportField($this->Rows_Vertical_Align_Top);
						if ($this->_Language->Exportable) $Doc->ExportField($this->_Language);
						if ($this->Redirect_To_Last_Visited_Page_After_Login->Exportable) $Doc->ExportField($this->Redirect_To_Last_Visited_Page_After_Login);
						if ($this->Font_Name->Exportable) $Doc->ExportField($this->Font_Name);
						if ($this->Font_Size->Exportable) $Doc->ExportField($this->Font_Size);
					} else {

					// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) {  
							$Doc->ExportText(ew_FormatSeqNo(CurrentPage()->getStartRecordNumber()+$RowCnt-1));
						}

					 // End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if ($this->Username->Exportable) $Doc->ExportField($this->Username);
						if ($this->First_Name->Exportable) $Doc->ExportField($this->First_Name);
						if ($this->Last_Name->Exportable) $Doc->ExportField($this->Last_Name);
						if ($this->_Email->Exportable) $Doc->ExportField($this->_Email);
						if ($this->Activated->Exportable) $Doc->ExportField($this->Activated);
						if ($this->Locked->Exportable) $Doc->ExportField($this->Locked);
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

	// Send register email
	function SendRegisterEmail($row) {

		// Get user language
		global $UserProfile;
		$sUsername = $row['Username'];
		$langid = $UserProfile->GetLanguageId($sUsername);
		$Email = $this->PrepareRegisterEmail($row, $langid);
		$Args = array();
		$Args["rs"] = $row;
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $Args)) // NOTE: use Email_Sending server event of user table
			$bEmailSent = $Email->Send();
		return $bEmailSent;
	}

	// Prepare register email
	function PrepareRegisterEmail($row = NULL, $langid = "") {
		global $Language;
		$Email = new cEmail;
		$Email->Load(EW_EMAIL_REGISTER_TEMPLATE, $langid);
		$sReceiverEmail = ($row == NULL) ? $this->_Email->CurrentValue : $row['Email'];
		if ($sReceiverEmail == "") { // Send to recipient directly
			$sReceiverEmail = EW_RECIPIENT_EMAIL;
			$sBccEmail = "";
		} else { // Bcc recipient
			$sBccEmail = EW_RECIPIENT_EMAIL;
		}
		$Email->ReplaceSubject($Language->Phrase("SubjectRegistrationInformation").' '.$Language->ProjectPhrase("BodyTitle"));
		$Email->ReplaceSender(EW_SENDER_EMAIL); // Replace Sender
		$Email->ReplaceRecipient($sReceiverEmail); // Replace Recipient
		if ($sBccEmail <> "") $Email->AddBcc($sBccEmail); // Add Bcc
		$Email->ReplaceContent('<!--FieldCaption_Username-->', $this->Username->FldCaption());
		$Email->ReplaceContent('<!--Username-->', ($row == NULL) ? strval($this->Username->FormValue) : $row['Username']);
		$Email->ReplaceContent('<!--FieldCaption_Password-->', $this->Password->FldCaption());
		if (EW_ENCRYPTED_PASSWORD) { // Begin of customization encrypted password check, modified by Masino Sinaga, October 9, 2015
		$Email->ReplaceContent('<!--Password-->', $Language->Phrase("ResendRegisterEmailPasswordEncrypted"));
		} else {
		$Email->ReplaceContent('<!--Password-->', ($row == NULL) ? strval($this->Password->FormValue) : $row['Password']);
		} // End of customization encrypted password check, modified by Masino Sinaga, October 9, 2015
		$Email->ReplaceContent('<!--FieldCaption_First_Name-->', $this->First_Name->FldCaption());
		$Email->ReplaceContent('<!--First_Name-->', ($row == NULL) ? strval($this->First_Name->FormValue) : $row['First_Name']);
		$Email->ReplaceContent('<!--FieldCaption_Last_Name-->', $this->Last_Name->FldCaption());
		$Email->ReplaceContent('<!--Last_Name-->', ($row == NULL) ? strval($this->Last_Name->FormValue) : $row['Last_Name']);
		$Email->ReplaceContent('<!--FieldCaption_Email-->', $this->_Email->FldCaption());
		$Email->ReplaceContent('<!--Email-->', ($row == NULL) ? strval($this->_Email->FormValue) : $row['Email']);
		$sLoginID = ($row == NULL) ? $this->Username->CurrentValue : $row['Username'];
		$sPassword = ($row == NULL) ? $this->Password->CurrentValue : $row['Password'];
		$sActivateLink = ew_ConvertFullUrl("register.php") . "?action=confirm";
		$sActivateLink .= "&email=" . $sReceiverEmail;
		$sToken = ew_Encrypt($sReceiverEmail) . "," . ew_Encrypt($sLoginID) . "," . ew_Encrypt($sPassword);
		$sActivateLink .= "&token=" . $sToken;
		$Email->ReplaceContent("<!--ActivateLink-->", $sActivateLink);
		$Email->Content = preg_replace('/<!--\s*register_activate_link[\s\S]*?-->/i', '', $Email->Content); // Remove comments
		return $Email;
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
