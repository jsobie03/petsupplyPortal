<?php

// Global variable for table object
$announcement = NULL;

//
// Table class for announcement
//
class cannouncement extends cTable {
	var $Announcement_ID;
	var $Is_Active;
	var $Topic;
	var $Message;
	var $Date_LastUpdate;
	var $_Language;
	var $Auto_Publish;
	var $Date_Start;
	var $Date_End;
	var $Date_Created;
	var $Created_By;
	var $Translated_ID;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'announcement';
		$this->TableName = 'announcement';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`announcement`";
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

		// Announcement_ID
		$this->Announcement_ID = new cField('announcement', 'announcement', 'x_Announcement_ID', 'Announcement_ID', '`Announcement_ID`', '`Announcement_ID`', 19, -1, FALSE, '`Announcement_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->Announcement_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Announcement_ID'] = &$this->Announcement_ID;

		// Is_Active
		$this->Is_Active = new cField('announcement', 'announcement', 'x_Is_Active', 'Is_Active', '`Is_Active`', '`Is_Active`', 202, -1, FALSE, '`Is_Active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Is_Active->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Is_Active->TrueValue = 'Y';
		$this->Is_Active->FalseValue = 'N';
		$this->Is_Active->OptionCount = 2;
		$this->fields['Is_Active'] = &$this->Is_Active;

		// Topic
		$this->Topic = new cField('announcement', 'announcement', 'x_Topic', 'Topic', '`Topic`', '`Topic`', 200, -1, FALSE, '`Topic`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Topic'] = &$this->Topic;

		// Message
		$this->Message = new cField('announcement', 'announcement', 'x_Message', 'Message', '`Message`', '`Message`', 201, -1, FALSE, '`Message`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['Message'] = &$this->Message;

		// Date_LastUpdate
		$this->Date_LastUpdate = new cField('announcement', 'announcement', 'x_Date_LastUpdate', 'Date_LastUpdate', '`Date_LastUpdate`', 'DATE_FORMAT(`Date_LastUpdate`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`Date_LastUpdate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Date_LastUpdate->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Date_LastUpdate'] = &$this->Date_LastUpdate;

		// Language
		$this->_Language = new cField('announcement', 'announcement', 'x__Language', 'Language', '`Language`', '`Language`', 200, -1, FALSE, '`Language`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fields['Language'] = &$this->_Language;

		// Auto_Publish
		$this->Auto_Publish = new cField('announcement', 'announcement', 'x_Auto_Publish', 'Auto_Publish', '`Auto_Publish`', '`Auto_Publish`', 202, -1, FALSE, '`Auto_Publish`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->Auto_Publish->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Auto_Publish->TrueValue = 'Y';
		$this->Auto_Publish->FalseValue = 'N';
		$this->Auto_Publish->OptionCount = 2;
		$this->fields['Auto_Publish'] = &$this->Auto_Publish;

		// Date_Start
		$this->Date_Start = new cField('announcement', 'announcement', 'x_Date_Start', 'Date_Start', '`Date_Start`', 'DATE_FORMAT(`Date_Start`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`Date_Start`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Date_Start->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Date_Start'] = &$this->Date_Start;

		// Date_End
		$this->Date_End = new cField('announcement', 'announcement', 'x_Date_End', 'Date_End', '`Date_End`', 'DATE_FORMAT(`Date_End`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`Date_End`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Date_End->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Date_End'] = &$this->Date_End;

		// Date_Created
		$this->Date_Created = new cField('announcement', 'announcement', 'x_Date_Created', 'Date_Created', '`Date_Created`', 'DATE_FORMAT(`Date_Created`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`Date_Created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Date_Created->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['Date_Created'] = &$this->Date_Created;

		// Created_By
		$this->Created_By = new cField('announcement', 'announcement', 'x_Created_By', 'Created_By', '`Created_By`', '`Created_By`', 200, -1, FALSE, '`Created_By`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['Created_By'] = &$this->Created_By;

		// Translated_ID
		$this->Translated_ID = new cField('announcement', 'announcement', 'x_Translated_ID', 'Translated_ID', '`Translated_ID`', '`Translated_ID`', 3, -1, FALSE, '`Translated_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Translated_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Translated_ID'] = &$this->Translated_ID;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`announcement`";
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
			if (array_key_exists('Announcement_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('Announcement_ID', $this->DBID) . '=' . ew_QuotedValue($rs['Announcement_ID'], $this->Announcement_ID->FldDataType, $this->DBID));
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
		return "`Announcement_ID` = @Announcement_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Announcement_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Announcement_ID@", ew_AdjustSql($this->Announcement_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "announcementlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "announcementlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("announcementview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("announcementview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "announcementadd.php?" . $this->UrlParm($parm);
		else
			$url = "announcementadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("announcementedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("announcementadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("announcementdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Announcement_ID:" . ew_VarToJson($this->Announcement_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Announcement_ID->CurrentValue)) {
			$sUrl .= "Announcement_ID=" . urlencode($this->Announcement_ID->CurrentValue);
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
			if ($isPost && isset($_POST["Announcement_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["Announcement_ID"]);
			elseif (isset($_GET["Announcement_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["Announcement_ID"]);
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
			$this->Announcement_ID->CurrentValue = $key;
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
		$this->Announcement_ID->setDbValue($rs->fields('Announcement_ID'));
		$this->Is_Active->setDbValue($rs->fields('Is_Active'));
		$this->Topic->setDbValue($rs->fields('Topic'));
		$this->Message->setDbValue($rs->fields('Message'));
		$this->Date_LastUpdate->setDbValue($rs->fields('Date_LastUpdate'));
		$this->_Language->setDbValue($rs->fields('Language'));
		$this->Auto_Publish->setDbValue($rs->fields('Auto_Publish'));
		$this->Date_Start->setDbValue($rs->fields('Date_Start'));
		$this->Date_End->setDbValue($rs->fields('Date_End'));
		$this->Date_Created->setDbValue($rs->fields('Date_Created'));
		$this->Created_By->setDbValue($rs->fields('Created_By'));
		$this->Translated_ID->setDbValue($rs->fields('Translated_ID'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Announcement_ID
		// Is_Active
		// Topic
		// Message
		// Date_LastUpdate
		// Language
		// Auto_Publish
		// Date_Start
		// Date_End
		// Date_Created
		// Created_By
		// Translated_ID
		// Announcement_ID

		$this->Announcement_ID->ViewValue = $this->Announcement_ID->CurrentValue;
		$this->Announcement_ID->ViewCustomAttributes = "";

		// Is_Active
		if (ew_ConvertToBool($this->Is_Active->CurrentValue)) {
			$this->Is_Active->ViewValue = $this->Is_Active->FldTagCaption(2) <> "" ? $this->Is_Active->FldTagCaption(2) : "Y";
		} else {
			$this->Is_Active->ViewValue = $this->Is_Active->FldTagCaption(1) <> "" ? $this->Is_Active->FldTagCaption(1) : "N";
		}
		$this->Is_Active->ViewCustomAttributes = "";

		// Topic
		$this->Topic->ViewValue = $this->Topic->CurrentValue;
		$this->Topic->ViewCustomAttributes = "";

		// Message
		$this->Message->ViewValue = $this->Message->CurrentValue;
		$this->Message->ViewCustomAttributes = "";

		// Date_LastUpdate
		$this->Date_LastUpdate->ViewValue = $this->Date_LastUpdate->CurrentValue;
		$this->Date_LastUpdate->ViewValue = ew_FormatDateTime($this->Date_LastUpdate->ViewValue, 9);
		$this->Date_LastUpdate->ViewCustomAttributes = "";

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

		// Auto_Publish
		if (ew_ConvertToBool($this->Auto_Publish->CurrentValue)) {
			$this->Auto_Publish->ViewValue = $this->Auto_Publish->FldTagCaption(1) <> "" ? $this->Auto_Publish->FldTagCaption(1) : "Y";
		} else {
			$this->Auto_Publish->ViewValue = $this->Auto_Publish->FldTagCaption(2) <> "" ? $this->Auto_Publish->FldTagCaption(2) : "N";
		}
		$this->Auto_Publish->ViewCustomAttributes = "";

		// Date_Start
		$this->Date_Start->ViewValue = $this->Date_Start->CurrentValue;
		$this->Date_Start->ViewValue = ew_FormatDateTime($this->Date_Start->ViewValue, 9);
		$this->Date_Start->ViewCustomAttributes = "";

		// Date_End
		$this->Date_End->ViewValue = $this->Date_End->CurrentValue;
		$this->Date_End->ViewValue = ew_FormatDateTime($this->Date_End->ViewValue, 9);
		$this->Date_End->ViewCustomAttributes = "";

		// Date_Created
		$this->Date_Created->ViewValue = $this->Date_Created->CurrentValue;
		$this->Date_Created->ViewValue = ew_FormatDateTime($this->Date_Created->ViewValue, 9);
		$this->Date_Created->ViewCustomAttributes = "";

		// Created_By
		$this->Created_By->ViewValue = $this->Created_By->CurrentValue;
		$this->Created_By->ViewCustomAttributes = "";

		// Translated_ID
		if (strval($this->Translated_ID->CurrentValue) <> "") {
			$sFilterWrk = "`Announcement_ID`" . ew_SearchString("=", $this->Translated_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Announcement_ID`, `Topic` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `announcement`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Announcement_ID`, `Topic` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `announcement`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Translated_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Translated_ID->ViewValue = $this->Translated_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Translated_ID->ViewValue = $this->Translated_ID->CurrentValue;
			}
		} else {
			$this->Translated_ID->ViewValue = NULL;
		}
		$this->Translated_ID->ViewCustomAttributes = "";

		// Announcement_ID
		$this->Announcement_ID->LinkCustomAttributes = "";
		$this->Announcement_ID->HrefValue = "";
		$this->Announcement_ID->TooltipValue = "";

		// Is_Active
		$this->Is_Active->LinkCustomAttributes = "";
		$this->Is_Active->HrefValue = "";
		$this->Is_Active->TooltipValue = "";

		// Topic
		$this->Topic->LinkCustomAttributes = "";
		$this->Topic->HrefValue = "";
		$this->Topic->TooltipValue = "";

		// Message
		$this->Message->LinkCustomAttributes = "";
		$this->Message->HrefValue = "";
		$this->Message->TooltipValue = "";

		// Date_LastUpdate
		$this->Date_LastUpdate->LinkCustomAttributes = "";
		$this->Date_LastUpdate->HrefValue = "";
		$this->Date_LastUpdate->TooltipValue = "";

		// Language
		$this->_Language->LinkCustomAttributes = "";
		$this->_Language->HrefValue = "";
		$this->_Language->TooltipValue = "";

		// Auto_Publish
		$this->Auto_Publish->LinkCustomAttributes = "";
		$this->Auto_Publish->HrefValue = "";
		$this->Auto_Publish->TooltipValue = "";

		// Date_Start
		$this->Date_Start->LinkCustomAttributes = "";
		$this->Date_Start->HrefValue = "";
		$this->Date_Start->TooltipValue = "";

		// Date_End
		$this->Date_End->LinkCustomAttributes = "";
		$this->Date_End->HrefValue = "";
		$this->Date_End->TooltipValue = "";

		// Date_Created
		$this->Date_Created->LinkCustomAttributes = "";
		$this->Date_Created->HrefValue = "";
		$this->Date_Created->TooltipValue = "";

		// Created_By
		$this->Created_By->LinkCustomAttributes = "";
		$this->Created_By->HrefValue = "";
		$this->Created_By->TooltipValue = "";

		// Translated_ID
		$this->Translated_ID->LinkCustomAttributes = "";
		$this->Translated_ID->HrefValue = "";
		$this->Translated_ID->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Announcement_ID
		$this->Announcement_ID->EditAttrs["class"] = "form-control";
		$this->Announcement_ID->EditCustomAttributes = "";
		$this->Announcement_ID->EditValue = $this->Announcement_ID->CurrentValue;
		$this->Announcement_ID->ViewCustomAttributes = "";

		// Is_Active
		$this->Is_Active->EditCustomAttributes = "";
		$this->Is_Active->EditValue = $this->Is_Active->Options(FALSE);

		// Topic
		$this->Topic->EditAttrs["class"] = "form-control";
		$this->Topic->EditCustomAttributes = "";
		$this->Topic->EditValue = $this->Topic->CurrentValue;
		$this->Topic->PlaceHolder = ew_RemoveHtml($this->Topic->FldCaption());

		// Message
		$this->Message->EditAttrs["class"] = "form-control";
		$this->Message->EditCustomAttributes = "";
		$this->Message->EditValue = $this->Message->CurrentValue;
		$this->Message->PlaceHolder = ew_RemoveHtml($this->Message->FldCaption());

		// Date_LastUpdate
		$this->Date_LastUpdate->EditAttrs["class"] = "form-control";
		$this->Date_LastUpdate->EditCustomAttributes = "";
		$this->Date_LastUpdate->EditValue = ew_FormatDateTime($this->Date_LastUpdate->CurrentValue, 9);
		$this->Date_LastUpdate->PlaceHolder = ew_RemoveHtml($this->Date_LastUpdate->FldCaption());

		// Language
		$this->_Language->EditAttrs["class"] = "form-control";
		$this->_Language->EditCustomAttributes = "";

		// Auto_Publish
		$this->Auto_Publish->EditCustomAttributes = "";
		$this->Auto_Publish->EditValue = $this->Auto_Publish->Options(FALSE);

		// Date_Start
		$this->Date_Start->EditAttrs["class"] = "form-control";
		$this->Date_Start->EditCustomAttributes = "";
		$this->Date_Start->EditValue = ew_FormatDateTime($this->Date_Start->CurrentValue, 9);
		$this->Date_Start->PlaceHolder = ew_RemoveHtml($this->Date_Start->FldCaption());

		// Date_End
		$this->Date_End->EditAttrs["class"] = "form-control";
		$this->Date_End->EditCustomAttributes = "";
		$this->Date_End->EditValue = ew_FormatDateTime($this->Date_End->CurrentValue, 9);
		$this->Date_End->PlaceHolder = ew_RemoveHtml($this->Date_End->FldCaption());

		// Date_Created
		$this->Date_Created->EditAttrs["class"] = "form-control";
		$this->Date_Created->EditCustomAttributes = "";
		$this->Date_Created->EditValue = ew_FormatDateTime($this->Date_Created->CurrentValue, 9);
		$this->Date_Created->PlaceHolder = ew_RemoveHtml($this->Date_Created->FldCaption());

		// Created_By
		$this->Created_By->EditAttrs["class"] = "form-control";
		$this->Created_By->EditCustomAttributes = "";
		$this->Created_By->EditValue = $this->Created_By->CurrentValue;
		$this->Created_By->PlaceHolder = ew_RemoveHtml($this->Created_By->FldCaption());

		// Translated_ID
		$this->Translated_ID->EditAttrs["class"] = "form-control";
		$this->Translated_ID->EditCustomAttributes = "";

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
					if ($this->Announcement_ID->Exportable) $Doc->ExportCaption($this->Announcement_ID);
					if ($this->Is_Active->Exportable) $Doc->ExportCaption($this->Is_Active);
					if ($this->Topic->Exportable) $Doc->ExportCaption($this->Topic);
					if ($this->Message->Exportable) $Doc->ExportCaption($this->Message);
					if ($this->Date_LastUpdate->Exportable) $Doc->ExportCaption($this->Date_LastUpdate);
					if ($this->_Language->Exportable) $Doc->ExportCaption($this->_Language);
					if ($this->Auto_Publish->Exportable) $Doc->ExportCaption($this->Auto_Publish);
					if ($this->Date_Start->Exportable) $Doc->ExportCaption($this->Date_Start);
					if ($this->Date_End->Exportable) $Doc->ExportCaption($this->Date_End);
					if ($this->Date_Created->Exportable) $Doc->ExportCaption($this->Date_Created);
					if ($this->Created_By->Exportable) $Doc->ExportCaption($this->Created_By);
					if ($this->Translated_ID->Exportable) $Doc->ExportCaption($this->Translated_ID);
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
					if ($this->Announcement_ID->Exportable) $Doc->ExportCaption($this->Announcement_ID);
					if ($this->Is_Active->Exportable) $Doc->ExportCaption($this->Is_Active);
					if ($this->Topic->Exportable) $Doc->ExportCaption($this->Topic);
					if ($this->_Language->Exportable) $Doc->ExportCaption($this->_Language);
					if ($this->Auto_Publish->Exportable) $Doc->ExportCaption($this->Auto_Publish);
					if ($this->Date_Start->Exportable) $Doc->ExportCaption($this->Date_Start);
					if ($this->Date_End->Exportable) $Doc->ExportCaption($this->Date_End);
					if ($this->Translated_ID->Exportable) $Doc->ExportCaption($this->Translated_ID);
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
						if ($this->Announcement_ID->Exportable) $Doc->ExportField($this->Announcement_ID);
						if ($this->Is_Active->Exportable) $Doc->ExportField($this->Is_Active);
						if ($this->Topic->Exportable) $Doc->ExportField($this->Topic);
						if ($this->Message->Exportable) $Doc->ExportField($this->Message);
						if ($this->Date_LastUpdate->Exportable) $Doc->ExportField($this->Date_LastUpdate);
						if ($this->_Language->Exportable) $Doc->ExportField($this->_Language);
						if ($this->Auto_Publish->Exportable) $Doc->ExportField($this->Auto_Publish);
						if ($this->Date_Start->Exportable) $Doc->ExportField($this->Date_Start);
						if ($this->Date_End->Exportable) $Doc->ExportField($this->Date_End);
						if ($this->Date_Created->Exportable) $Doc->ExportField($this->Date_Created);
						if ($this->Created_By->Exportable) $Doc->ExportField($this->Created_By);
						if ($this->Translated_ID->Exportable) $Doc->ExportField($this->Translated_ID);
					} else {

					// Begin of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if (MS_SHOW_RECNUM_COLUMN_ON_EXPORTED_LIST) {  
							$Doc->ExportText(ew_FormatSeqNo(CurrentPage()->getStartRecordNumber()+$RowCnt-1));
						}

					 // End of modification Add Record Number Column on Exported List, modified by Masino Sinaga, June 3, 2012
						if ($this->Announcement_ID->Exportable) $Doc->ExportField($this->Announcement_ID);
						if ($this->Is_Active->Exportable) $Doc->ExportField($this->Is_Active);
						if ($this->Topic->Exportable) $Doc->ExportField($this->Topic);
						if ($this->_Language->Exportable) $Doc->ExportField($this->_Language);
						if ($this->Auto_Publish->Exportable) $Doc->ExportField($this->Auto_Publish);
						if ($this->Date_Start->Exportable) $Doc->ExportField($this->Date_Start);
						if ($this->Date_End->Exportable) $Doc->ExportField($this->Date_End);
						if ($this->Translated_ID->Exportable) $Doc->ExportField($this->Translated_ID);
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
