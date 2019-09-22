<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "announcementinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$announcement_delete = NULL; // Initialize page object first

class cannouncement_delete extends cannouncement {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'announcement';

	// Page object name
	var $PageObjName = 'announcement_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {

		// $hidden = TRUE;
		$hidden = MS_USE_JAVASCRIPT_MESSAGE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display

			// if (!$hidden)
			//	 $sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			// $html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			// Begin of modification Auto Hide Message, by Masino Sinaga, January 24, 2013

			if (@MS_AUTO_HIDE_SUCCESS_MESSAGE) {

				//$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
				$html .= "<p class=\"alert alert-success msSuccessMessage\" id=\"ewSuccessMessage\">" . $sSuccessMessage . "</p>";
			} else {
				if (!$hidden)
					$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
				$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			}

			// End of modification Auto Hide Message, by Masino Sinaga, January 24, 2013
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}

		// echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
		if (@MS_AUTO_HIDE_SUCCESS_MESSAGE || MS_USE_JAVASCRIPT_MESSAGE==0) {
			echo $html;
		} else {
			if (MS_USE_ALERTIFY_FOR_MESSAGE_DIALOG) {
				if ($html <> "") {
					$html = str_replace("'", "\'", $html);
					echo "<script type='text/javascript'>alertify.alert('".$html."', function (ok) { }).set('title', ewLanguage.Phrase('AlertifyAlert'));</script>";
				}
			} else {
				echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
			}
		}
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (announcement)
		if (!isset($GLOBALS["announcement"]) || get_class($GLOBALS["announcement"]) == "cannouncement") {
			$GLOBALS["announcement"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["announcement"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'announcement', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (users)
		if (!isset($UserTable)) {
			$UserTable = new cusers();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm, $UserTableConn;
		if (!isset($_SESSION['table_announcement_views'])) { 
			$_SESSION['table_announcement_views'] = 0;
		}
		$_SESSION['table_announcement_views'] = $_SESSION['table_announcement_views']+1;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (IsPasswordExpired())
			$this->Page_Terminate(ew_GetUrl("changepwd.php"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("announcementlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Begin of modification Auto Logout After Idle for the Certain Time, by Masino Sinaga, May 5, 2012
		if (IsLoggedIn() && !IsSysAdmin()) {

			// Begin of modification by Masino Sinaga, May 25, 2012 in order to not autologout after clear another user's session ID whenever back to another page.           
			$UserProfile->LoadProfileFromDatabase(CurrentUserName());

			// End of modification by Masino Sinaga, May 25, 2012 in order to not autologout after clear another user's session ID whenever back to another page.
			// Begin of modification Save Last Users' Visitted Page, by Masino Sinaga, May 25, 2012

			$lastpage = ew_CurrentPage();
			if ($lastpage!='logout.php' && $lastpage!='index.php') {
				$lasturl = ew_CurrentUrl();
				$sFilterUserID = str_replace("%u", ew_AdjustSql(CurrentUserName(), EW_USER_TABLE_DBID), EW_USER_NAME_FILTER);
				ew_Execute("UPDATE ".EW_USER_TABLE." SET Current_URL = '".$lasturl."' WHERE ".$sFilterUserID."", $UserTableConn);
			}

			// End of modification Save Last Users' Visitted Page, by Masino Sinaga, May 25, 2012
			$LastAccessDateTime = strval(@$UserProfile->Profile[EW_USER_PROFILE_LAST_ACCESSED_DATE_TIME]);
			$nDiff = intval(ew_DateDiff($LastAccessDateTime, ew_StdCurrentDateTime(), "s"));
			$nCons = intval(MS_AUTO_LOGOUT_AFTER_IDLE_IN_MINUTES) * 60;
			if ($nDiff > $nCons) {

				//header("Location: logout.php?expired=1");
			}
		}

		// End of modification Auto Logout After Idle for the Certain Time, by Masino Sinaga, May 5, 2012
		// Update last accessed time

		if ($UserProfile->IsValidUser(CurrentUserName(), session_id())) {

			// Do nothing since it's a valid user! SaveProfileToDatabase has been handled from IsValidUser method of UserProfile object.
		} else {

			// Begin of modification How to Overcome "User X already logged in" Issue, by Masino Sinaga, July 22, 2014
			// echo $Language->Phrase("UserProfileCorrupted");

			header("Location: logout.php");

			// End of modification How to Overcome "User X already logged in" Issue, by Masino Sinaga, July 22, 2014
		}
		if (@MS_USE_CONSTANTS_IN_CONFIG_FILE == FALSE) {

			// Call this new function from userfn*.php file
			My_Global_Check();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Announcement_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

// Begin of modification Disable/Enable Registration Page, by Masino Sinaga, May 14, 2012
// End of modification Disable/Enable Registration Page, by Masino Sinaga, May 14, 2012
		// Page Load event

		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}
		if (ALWAYS_COMPARE_ROOT_URL == TRUE) {
			if ($_SESSION['php_stock_Root_URL'] <> Get_Root_URL()) {
				header("Location: " . $_SESSION['php_stock_Root_URL']);
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $announcement;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($announcement);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("announcementlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in announcement class, announcementinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Begin of modification (20140916): http://www.hkvforums.com/viewtopic.php?f=4&t=35486&p=102440#p102440
		// Load List page SQL

		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Announcement_ID->DbValue = $row['Announcement_ID'];
		$this->Is_Active->DbValue = $row['Is_Active'];
		$this->Topic->DbValue = $row['Topic'];
		$this->Message->DbValue = $row['Message'];
		$this->Date_LastUpdate->DbValue = $row['Date_LastUpdate'];
		$this->_Language->DbValue = $row['Language'];
		$this->Auto_Publish->DbValue = $row['Auto_Publish'];
		$this->Date_Start->DbValue = $row['Date_Start'];
		$this->Date_End->DbValue = $row['Date_End'];
		$this->Date_Created->DbValue = $row['Date_Created'];
		$this->Created_By->DbValue = $row['Created_By'];
		$this->Translated_ID->DbValue = $row['Translated_ID'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// Translated_ID
			$this->Translated_ID->LinkCustomAttributes = "";
			$this->Translated_ID->HrefValue = "";
			$this->Translated_ID->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Announcement_ID'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Build export filter for selected records
	function BuildExportSelectedFilter() {
		global $Language;
		$sWrkFilter = "";
		if ($this->Export <> "") {
			$sWrkFilter = $this->GetKeyFilter();
		}
		return $sWrkFilter;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("announcementlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url); // v11.0.4
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($announcement_delete)) $announcement_delete = new cannouncement_delete();

// Page init
$announcement_delete->Page_Init();

// Page main
$announcement_delete->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$announcement_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fannouncementdelete = new ew_Form("fannouncementdelete", "delete");

// Form_CustomValidate event
fannouncementdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fannouncementdelete.ValidateRequired = true;
<?php } else { ?>
fannouncementdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fannouncementdelete.Lists["x_Is_Active[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fannouncementdelete.Lists["x_Is_Active[]"].Options = <?php echo json_encode($announcement->Is_Active->Options()) ?>;
fannouncementdelete.Lists["x__Language"] = {"LinkField":"x_Language_Code","Ajax":true,"AutoFill":false,"DisplayFields":["x_Language_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fannouncementdelete.Lists["x_Auto_Publish[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fannouncementdelete.Lists["x_Auto_Publish[]"].Options = <?php echo json_encode($announcement->Auto_Publish->Options()) ?>;
fannouncementdelete.Lists["x_Translated_ID"] = {"LinkField":"x_Announcement_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Topic","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($announcement_delete->Recordset = $announcement_delete->LoadRecordset())
	$announcement_deleteTotalRecs = $announcement_delete->Recordset->RecordCount(); // Get record count
if ($announcement_deleteTotalRecs <= 0) { // No record found, exit
	if ($announcement_delete->Recordset)
		$announcement_delete->Recordset->Close();
	$announcement_delete->Page_Terminate("announcementlist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php if (MS_SHOW_PHPMAKER_BREADCRUMBLINKS) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if (MS_SHOW_MASINO_BREADCRUMBLINKS) { ?>
<?php echo MasinoBreadcrumbLinks(); ?>
<?php } ?>
<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="belowheader") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $announcement_delete->ShowPageHeader(); ?>
<?php
$announcement_delete->ShowMessage();
?>
<form name="fannouncementdelete" id="fannouncementdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($announcement_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $announcement_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="announcement">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($announcement_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $announcement->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($announcement->Announcement_ID->Visible) { // Announcement_ID ?>
		<th><span id="elh_announcement_Announcement_ID" class="announcement_Announcement_ID"><?php echo $announcement->Announcement_ID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($announcement->Is_Active->Visible) { // Is_Active ?>
		<th><span id="elh_announcement_Is_Active" class="announcement_Is_Active"><?php echo $announcement->Is_Active->FldCaption() ?></span></th>
<?php } ?>
<?php if ($announcement->Topic->Visible) { // Topic ?>
		<th><span id="elh_announcement_Topic" class="announcement_Topic"><?php echo $announcement->Topic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($announcement->_Language->Visible) { // Language ?>
		<th><span id="elh_announcement__Language" class="announcement__Language"><?php echo $announcement->_Language->FldCaption() ?></span></th>
<?php } ?>
<?php if ($announcement->Auto_Publish->Visible) { // Auto_Publish ?>
		<th><span id="elh_announcement_Auto_Publish" class="announcement_Auto_Publish"><?php echo $announcement->Auto_Publish->FldCaption() ?></span></th>
<?php } ?>
<?php if ($announcement->Date_Start->Visible) { // Date_Start ?>
		<th><span id="elh_announcement_Date_Start" class="announcement_Date_Start"><?php echo $announcement->Date_Start->FldCaption() ?></span></th>
<?php } ?>
<?php if ($announcement->Date_End->Visible) { // Date_End ?>
		<th><span id="elh_announcement_Date_End" class="announcement_Date_End"><?php echo $announcement->Date_End->FldCaption() ?></span></th>
<?php } ?>
<?php if ($announcement->Translated_ID->Visible) { // Translated_ID ?>
		<th><span id="elh_announcement_Translated_ID" class="announcement_Translated_ID"><?php echo $announcement->Translated_ID->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$announcement_delete->RecCnt = 0;
$i = 0;
while (!$announcement_delete->Recordset->EOF) {
	$announcement_delete->RecCnt++;
	$announcement_delete->RowCnt++;

	// Set row properties
	$announcement->ResetAttrs();
	$announcement->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$announcement_delete->LoadRowValues($announcement_delete->Recordset);

	// Render row
	$announcement_delete->RenderRow();
?>
	<tr<?php echo $announcement->RowAttributes() ?>>
<?php if ($announcement->Announcement_ID->Visible) { // Announcement_ID ?>
		<td<?php echo $announcement->Announcement_ID->CellAttributes() ?>>
<span id="el<?php echo $announcement_delete->RowCnt ?>_announcement_Announcement_ID" class="announcement_Announcement_ID">
<span<?php echo $announcement->Announcement_ID->ViewAttributes() ?>>
<?php echo $announcement->Announcement_ID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($announcement->Is_Active->Visible) { // Is_Active ?>
		<td<?php echo $announcement->Is_Active->CellAttributes() ?>>
<span id="el<?php echo $announcement_delete->RowCnt ?>_announcement_Is_Active" class="announcement_Is_Active">
<span<?php echo $announcement->Is_Active->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($announcement->Is_Active->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $announcement->Is_Active->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $announcement->Is_Active->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($announcement->Topic->Visible) { // Topic ?>
		<td<?php echo $announcement->Topic->CellAttributes() ?>>
<span id="el<?php echo $announcement_delete->RowCnt ?>_announcement_Topic" class="announcement_Topic">
<span<?php echo $announcement->Topic->ViewAttributes() ?>>
<?php echo $announcement->Topic->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($announcement->_Language->Visible) { // Language ?>
		<td<?php echo $announcement->_Language->CellAttributes() ?>>
<span id="el<?php echo $announcement_delete->RowCnt ?>_announcement__Language" class="announcement__Language">
<span<?php echo $announcement->_Language->ViewAttributes() ?>>
<?php echo $announcement->_Language->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($announcement->Auto_Publish->Visible) { // Auto_Publish ?>
		<td<?php echo $announcement->Auto_Publish->CellAttributes() ?>>
<span id="el<?php echo $announcement_delete->RowCnt ?>_announcement_Auto_Publish" class="announcement_Auto_Publish">
<span<?php echo $announcement->Auto_Publish->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($announcement->Auto_Publish->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $announcement->Auto_Publish->ListViewValue() ?>" checked="checked" disabled="disabled">
<?php } else { ?>
<input type="checkbox" value="<?php echo $announcement->Auto_Publish->ListViewValue() ?>" disabled="disabled">
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($announcement->Date_Start->Visible) { // Date_Start ?>
		<td<?php echo $announcement->Date_Start->CellAttributes() ?>>
<span id="el<?php echo $announcement_delete->RowCnt ?>_announcement_Date_Start" class="announcement_Date_Start">
<span<?php echo $announcement->Date_Start->ViewAttributes() ?>>
<?php echo $announcement->Date_Start->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($announcement->Date_End->Visible) { // Date_End ?>
		<td<?php echo $announcement->Date_End->CellAttributes() ?>>
<span id="el<?php echo $announcement_delete->RowCnt ?>_announcement_Date_End" class="announcement_Date_End">
<span<?php echo $announcement->Date_End->ViewAttributes() ?>>
<?php echo $announcement->Date_End->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($announcement->Translated_ID->Visible) { // Translated_ID ?>
		<td<?php echo $announcement->Translated_ID->CellAttributes() ?>>
<span id="el<?php echo $announcement_delete->RowCnt ?>_announcement_Translated_ID" class="announcement_Translated_ID">
<span<?php echo $announcement->Translated_ID->ViewAttributes() ?>>
<?php echo $announcement->Translated_ID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$announcement_delete->Recordset->MoveNext();
}
$announcement_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $announcement_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fannouncementdelete.Init();
</script>
<?php
$announcement_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if ($announcement->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyDelete(this)'); function alertifyDelete(obj) { <?php global $Language; ?> if (fannouncementdelete.Validate() == true ) { alertify.confirm("<?php echo  $Language->Phrase('AlertifyDeleteConfirm'); ?>", function (e) { if (e) {	$(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyDelete'); ?>"); $("#fannouncementdelete").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$announcement_delete->Page_Terminate();
?>
