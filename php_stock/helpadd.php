<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "helpinfo.php" ?>
<?php include_once "help_categoriesinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$help_add = NULL; // Initialize page object first

class chelp_add extends chelp {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'help';

	// Page object name
	var $PageObjName = 'help_add';

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

		// Table object (help)
		if (!isset($GLOBALS["help"]) || get_class($GLOBALS["help"]) == "chelp") {
			$GLOBALS["help"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["help"];
		}

		// Table object (help_categories)
		if (!isset($GLOBALS['help_categories'])) $GLOBALS['help_categories'] = new chelp_categories();

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'help', TRUE);

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
		if (!isset($_SESSION['table_help_views'])) { 
			$_SESSION['table_help_views'] = 0;
		}
		$_SESSION['table_help_views'] = $_SESSION['table_help_views']+1;

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("helplist.php"));
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
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
		global $EW_EXPORT, $help;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($help);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// End of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Help_ID"] != "") {
				$this->Help_ID->setQueryStringValue($_GET["Help_ID"]);
				$this->setKey("Help_ID", $this->Help_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("Help_ID", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("helplist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful

					// Begin of modification Disable Add/Edit Success Message Box, by Masino Sinaga, August 1, 2012
					if (MS_SHOW_ADD_SUCCESS_MESSAGE==TRUE) {
						if ($this->getSuccessMessage() == "")
							$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					}

					// End of modification Disable Add/Edit Success Message Box, by Masino Sinaga, August 1, 2012
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "helplist.php")
						$sReturnUrl = $this->AddMasterUrl($this->GetListUrl()); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "helpview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Help_ID->CurrentValue = NULL;
		$this->Help_ID->OldValue = $this->Help_ID->CurrentValue;
		$this->_Language->CurrentValue = NULL;
		$this->_Language->OldValue = $this->_Language->CurrentValue;
		$this->Topic->CurrentValue = NULL;
		$this->Topic->OldValue = $this->Topic->CurrentValue;
		$this->Description->CurrentValue = NULL;
		$this->Description->OldValue = $this->Description->CurrentValue;
		$this->Category->CurrentValue = NULL;
		$this->Category->OldValue = $this->Category->CurrentValue;
		$this->Order->CurrentValue = NULL;
		$this->Order->OldValue = $this->Order->CurrentValue;
		$this->Display_in_Page->CurrentValue = NULL;
		$this->Display_in_Page->OldValue = $this->Display_in_Page->CurrentValue;
		$this->Updated_By->CurrentValue = CurrentUserName();
		$this->Last_Updated->CurrentValue = ew_CurrentDateTime();
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Help_ID->FldIsDetailKey) {
			$this->Help_ID->setFormValue($objForm->GetValue("x_Help_ID"));
		}
		if (!$this->_Language->FldIsDetailKey) {
			$this->_Language->setFormValue($objForm->GetValue("x__Language"));
		}
		if (!$this->Topic->FldIsDetailKey) {
			$this->Topic->setFormValue($objForm->GetValue("x_Topic"));
		}
		if (!$this->Description->FldIsDetailKey) {
			$this->Description->setFormValue($objForm->GetValue("x_Description"));
		}
		if (!$this->Category->FldIsDetailKey) {
			$this->Category->setFormValue($objForm->GetValue("x_Category"));
		}
		if (!$this->Order->FldIsDetailKey) {
			$this->Order->setFormValue($objForm->GetValue("x_Order"));
		}
		if (!$this->Display_in_Page->FldIsDetailKey) {
			$this->Display_in_Page->setFormValue($objForm->GetValue("x_Display_in_Page"));
		}
		if (!$this->Updated_By->FldIsDetailKey) {
			$this->Updated_By->setFormValue($objForm->GetValue("x_Updated_By"));
		}
		if (!$this->Last_Updated->FldIsDetailKey) {
			$this->Last_Updated->setFormValue($objForm->GetValue("x_Last_Updated"));
			$this->Last_Updated->CurrentValue = ew_UnFormatDateTime($this->Last_Updated->CurrentValue, 9);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Help_ID->CurrentValue = $this->Help_ID->FormValue;
		$this->_Language->CurrentValue = $this->_Language->FormValue;
		$this->Topic->CurrentValue = $this->Topic->FormValue;
		$this->Description->CurrentValue = $this->Description->FormValue;
		$this->Category->CurrentValue = $this->Category->FormValue;
		$this->Order->CurrentValue = $this->Order->FormValue;
		$this->Display_in_Page->CurrentValue = $this->Display_in_Page->FormValue;
		$this->Updated_By->CurrentValue = $this->Updated_By->FormValue;
		$this->Last_Updated->CurrentValue = $this->Last_Updated->FormValue;
		$this->Last_Updated->CurrentValue = ew_UnFormatDateTime($this->Last_Updated->CurrentValue, 9);
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Help_ID->DbValue = $row['Help_ID'];
		$this->_Language->DbValue = $row['Language'];
		$this->Topic->DbValue = $row['Topic'];
		$this->Description->DbValue = $row['Description'];
		$this->Category->DbValue = $row['Category'];
		$this->Order->DbValue = $row['Order'];
		$this->Display_in_Page->DbValue = $row['Display_in_Page'];
		$this->Updated_By->DbValue = $row['Updated_By'];
		$this->Last_Updated->DbValue = $row['Last_Updated'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Help_ID")) <> "")
			$this->Help_ID->CurrentValue = $this->getKey("Help_ID"); // Help_ID
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Help_ID
		// Language
		// Topic
		// Description
		// Category
		// Order
		// Display_in_Page
		// Updated_By
		// Last_Updated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Help_ID
			$this->Help_ID->EditAttrs["class"] = "form-control";
			$this->Help_ID->EditCustomAttributes = "";
			$this->Help_ID->EditValue = ew_HtmlEncode($this->Help_ID->CurrentValue);
			$this->Help_ID->PlaceHolder = ew_RemoveHtml($this->Help_ID->FldCaption());

			// Language
			$this->_Language->EditAttrs["class"] = "form-control";
			$this->_Language->EditCustomAttributes = "";
			if (trim(strval($this->_Language->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Language_Code`" . ew_SearchString("=", $this->_Language->CurrentValue, EW_DATATYPE_STRING, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Language_Code`, `Language_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `languages`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `Language_Code`, `Language_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `languages`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->_Language, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->_Language->EditValue = $arwrk;

			// Topic
			$this->Topic->EditAttrs["class"] = "form-control";
			$this->Topic->EditCustomAttributes = "";
			$this->Topic->EditValue = ew_HtmlEncode($this->Topic->CurrentValue);
			$this->Topic->PlaceHolder = ew_RemoveHtml($this->Topic->FldCaption());

			// Description
			$this->Description->EditAttrs["class"] = "form-control";
			$this->Description->EditCustomAttributes = "";
			$this->Description->EditValue = ew_HtmlEncode($this->Description->CurrentValue);
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
			if (trim(strval($this->Category->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Category_ID`" . ew_SearchString("=", $this->Category->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Category_ID`, `Category_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `help_categories`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `Category_ID`, `Category_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `help_categories`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Category, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Category->EditValue = $arwrk;
			}

			// Order
			$this->Order->EditAttrs["class"] = "form-control";
			$this->Order->EditCustomAttributes = "";
			$this->Order->EditValue = ew_HtmlEncode($this->Order->CurrentValue);
			$this->Order->PlaceHolder = ew_RemoveHtml($this->Order->FldCaption());

			// Display_in_Page
			$this->Display_in_Page->EditAttrs["class"] = "form-control";
			$this->Display_in_Page->EditCustomAttributes = "";
			$this->Display_in_Page->EditValue = ew_HtmlEncode($this->Display_in_Page->CurrentValue);
			$this->Display_in_Page->PlaceHolder = ew_RemoveHtml($this->Display_in_Page->FldCaption());

			// Updated_By
			// Last_Updated
			// Add refer script
			// Help_ID

			$this->Help_ID->LinkCustomAttributes = "";
			$this->Help_ID->HrefValue = "";

			// Language
			$this->_Language->LinkCustomAttributes = "";
			$this->_Language->HrefValue = "";

			// Topic
			$this->Topic->LinkCustomAttributes = "";
			$this->Topic->HrefValue = "";

			// Description
			$this->Description->LinkCustomAttributes = "";
			$this->Description->HrefValue = "";

			// Category
			$this->Category->LinkCustomAttributes = "";
			$this->Category->HrefValue = "";

			// Order
			$this->Order->LinkCustomAttributes = "";
			$this->Order->HrefValue = "";

			// Display_in_Page
			$this->Display_in_Page->LinkCustomAttributes = "";
			$this->Display_in_Page->HrefValue = "";

			// Updated_By
			$this->Updated_By->LinkCustomAttributes = "";
			$this->Updated_By->HrefValue = "";

			// Last_Updated
			$this->Last_Updated->LinkCustomAttributes = "";
			$this->Last_Updated->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->Help_ID->FldIsDetailKey && !is_null($this->Help_ID->FormValue) && $this->Help_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Help_ID->FldCaption(), $this->Help_ID->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Help_ID->FormValue)) {
			ew_AddMessage($gsFormError, $this->Help_ID->FldErrMsg());
		}
		if (!$this->_Language->FldIsDetailKey && !is_null($this->_Language->FormValue) && $this->_Language->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_Language->FldCaption(), $this->_Language->ReqErrMsg));
		}
		if (!$this->Topic->FldIsDetailKey && !is_null($this->Topic->FormValue) && $this->Topic->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Topic->FldCaption(), $this->Topic->ReqErrMsg));
		}
		if (!$this->Description->FldIsDetailKey && !is_null($this->Description->FormValue) && $this->Description->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Description->FldCaption(), $this->Description->ReqErrMsg));
		}
		if (!$this->Category->FldIsDetailKey && !is_null($this->Category->FormValue) && $this->Category->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Category->FldCaption(), $this->Category->ReqErrMsg));
		}
		if (!$this->Order->FldIsDetailKey && !is_null($this->Order->FormValue) && $this->Order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Order->FldCaption(), $this->Order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Order->FormValue)) {
			ew_AddMessage($gsFormError, $this->Order->FldErrMsg());
		}
		if (!$this->Display_in_Page->FldIsDetailKey && !is_null($this->Display_in_Page->FormValue) && $this->Display_in_Page->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Display_in_Page->FldCaption(), $this->Display_in_Page->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Help_ID
		$this->Help_ID->SetDbValueDef($rsnew, $this->Help_ID->CurrentValue, 0, FALSE);

		// Language
		$this->_Language->SetDbValueDef($rsnew, $this->_Language->CurrentValue, "", FALSE);

		// Topic
		$this->Topic->SetDbValueDef($rsnew, $this->Topic->CurrentValue, "", FALSE);

		// Description
		$this->Description->SetDbValueDef($rsnew, $this->Description->CurrentValue, "", FALSE);

		// Category
		$this->Category->SetDbValueDef($rsnew, $this->Category->CurrentValue, 0, FALSE);

		// Order
		$this->Order->SetDbValueDef($rsnew, $this->Order->CurrentValue, 0, FALSE);

		// Display_in_Page
		$this->Display_in_Page->SetDbValueDef($rsnew, $this->Display_in_Page->CurrentValue, "", FALSE);

		// Updated_By
		$this->Updated_By->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Updated_By'] = &$this->Updated_By->DbValue;

		// Last_Updated
		$this->Last_Updated->SetDbValueDef($rsnew, ew_CurrentDateTime(), NULL);
		$rsnew['Last_Updated'] = &$this->Last_Updated->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Help_ID']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "help_categories") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Category_ID"] <> "") {
					$GLOBALS["help_categories"]->Category_ID->setQueryStringValue($_GET["fk_Category_ID"]);
					$this->Category->setQueryStringValue($GLOBALS["help_categories"]->Category_ID->QueryStringValue);
					$this->Category->setSessionValue($this->Category->QueryStringValue);
					if (!is_numeric($GLOBALS["help_categories"]->Category_ID->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "help_categories") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Category_ID"] <> "") {
					$GLOBALS["help_categories"]->Category_ID->setFormValue($_POST["fk_Category_ID"]);
					$this->Category->setFormValue($GLOBALS["help_categories"]->Category_ID->FormValue);
					$this->Category->setSessionValue($this->Category->FormValue);
					if (!is_numeric($GLOBALS["help_categories"]->Category_ID->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "help_categories") {
				if ($this->Category->CurrentValue == "") $this->Category->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("helplist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url); // v11.0.4
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($help_add)) $help_add = new chelp_add();

// Page init
$help_add->Page_Init();

// Page main
$help_add->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$help_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fhelpadd = new ew_Form("fhelpadd", "add");

// Validate form
fhelpadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_Help_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->Help_ID->FldCaption(), $help->Help_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Help_ID");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($help->Help_ID->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "__Language");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->_Language->FldCaption(), $help->_Language->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Topic");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->Topic->FldCaption(), $help->Topic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Description");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->Description->FldCaption(), $help->Description->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Category");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->Category->FldCaption(), $help->Category->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->Order->FldCaption(), $help->Order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($help->Order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Display_in_Page");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $help->Display_in_Page->FldCaption(), $help->Display_in_Page->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fhelpadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhelpadd.ValidateRequired = true;
<?php } else { ?>
fhelpadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhelpadd.Lists["x__Language"] = {"LinkField":"x_Language_Code","Ajax":true,"AutoFill":false,"DisplayFields":["x_Language_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhelpadd.Lists["x_Category"] = {"LinkField":"x_Category_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Category_Description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhelpadd.Lists["x_Updated_By"] = {"LinkField":"x_Username","Ajax":true,"AutoFill":false,"DisplayFields":["x_First_Name","x_Last_Name","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
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
<?php $help_add->ShowPageHeader(); ?>
<?php
$help_add->ShowMessage();
?>
<form name="fhelpadd" id="fhelpadd" class="<?php echo $help_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($help_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $help_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="help">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($help->getCurrentMasterTable() == "help_categories") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="help_categories">
<input type="hidden" name="fk_Category_ID" value="<?php echo $help->Category->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($help->Help_ID->Visible) { // Help_ID ?>
	<div id="r_Help_ID" class="form-group">
		<label id="elh_help_Help_ID" for="x_Help_ID" class="col-sm-4 control-label ewLabel"><?php echo $help->Help_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $help->Help_ID->CellAttributes() ?>>
<span id="el_help_Help_ID">
<input type="text" data-table="help" data-field="x_Help_ID" name="x_Help_ID" id="x_Help_ID" size="30" placeholder="<?php echo ew_HtmlEncode($help->Help_ID->getPlaceHolder()) ?>" value="<?php echo $help->Help_ID->EditValue ?>"<?php echo $help->Help_ID->EditAttributes() ?>>
</span>
<?php echo $help->Help_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($help->_Language->Visible) { // Language ?>
	<div id="r__Language" class="form-group">
		<label id="elh_help__Language" for="x__Language" class="col-sm-4 control-label ewLabel"><?php echo $help->_Language->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $help->_Language->CellAttributes() ?>>
<span id="el_help__Language">
<select data-table="help" data-field="x__Language" data-value-separator="<?php echo ew_HtmlEncode(is_array($help->_Language->DisplayValueSeparator) ? json_encode($help->_Language->DisplayValueSeparator) : $help->_Language->DisplayValueSeparator) ?>" id="x__Language" name="x__Language"<?php echo $help->_Language->EditAttributes() ?>>
<?php
if (is_array($help->_Language->EditValue)) {
	$arwrk = $help->_Language->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($help->_Language->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $help->_Language->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($help->_Language->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($help->_Language->CurrentValue) ?>" selected><?php echo $help->_Language->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
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
$help->_Language->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$help->_Language->LookupFilters += array("f0" => "`Language_Code` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$help->Lookup_Selecting($help->_Language, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $help->_Language->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x__Language" id="s_x__Language" value="<?php echo $help->_Language->LookupFilterQuery() ?>">
</span>
<?php echo $help->_Language->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($help->Topic->Visible) { // Topic ?>
	<div id="r_Topic" class="form-group">
		<label id="elh_help_Topic" for="x_Topic" class="col-sm-4 control-label ewLabel"><?php echo $help->Topic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $help->Topic->CellAttributes() ?>>
<span id="el_help_Topic">
<input type="text" data-table="help" data-field="x_Topic" name="x_Topic" id="x_Topic" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($help->Topic->getPlaceHolder()) ?>" value="<?php echo $help->Topic->EditValue ?>"<?php echo $help->Topic->EditAttributes() ?>>
</span>
<?php echo $help->Topic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($help->Description->Visible) { // Description ?>
	<div id="r_Description" class="form-group">
		<label id="elh_help_Description" for="x_Description" class="col-sm-4 control-label ewLabel"><?php echo $help->Description->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $help->Description->CellAttributes() ?>>
<span id="el_help_Description">
<textarea data-table="help" data-field="x_Description" name="x_Description" id="x_Description" cols="50" rows="6" placeholder="<?php echo ew_HtmlEncode($help->Description->getPlaceHolder()) ?>"<?php echo $help->Description->EditAttributes() ?>><?php echo $help->Description->EditValue ?></textarea>
</span>
<?php echo $help->Description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($help->Category->Visible) { // Category ?>
	<div id="r_Category" class="form-group">
		<label id="elh_help_Category" for="x_Category" class="col-sm-4 control-label ewLabel"><?php echo $help->Category->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $help->Category->CellAttributes() ?>>
<?php if ($help->Category->getSessionValue() <> "") { ?>
<span id="el_help_Category">
<span<?php echo $help->Category->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $help->Category->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_Category" name="x_Category" value="<?php echo ew_HtmlEncode($help->Category->CurrentValue) ?>">
<?php } else { ?>
<span id="el_help_Category">
<select data-table="help" data-field="x_Category" data-value-separator="<?php echo ew_HtmlEncode(is_array($help->Category->DisplayValueSeparator) ? json_encode($help->Category->DisplayValueSeparator) : $help->Category->DisplayValueSeparator) ?>" id="x_Category" name="x_Category"<?php echo $help->Category->EditAttributes() ?>>
<?php
if (is_array($help->Category->EditValue)) {
	$arwrk = $help->Category->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($help->Category->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $help->Category->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($help->Category->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($help->Category->CurrentValue) ?>" selected><?php echo $help->Category->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
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
$help->Category->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$help->Category->LookupFilters += array("f0" => "`Category_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$help->Lookup_Selecting($help->Category, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $help->Category->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Category" id="s_x_Category" value="<?php echo $help->Category->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $help->Category->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($help->Order->Visible) { // Order ?>
	<div id="r_Order" class="form-group">
		<label id="elh_help_Order" for="x_Order" class="col-sm-4 control-label ewLabel"><?php echo $help->Order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $help->Order->CellAttributes() ?>>
<span id="el_help_Order">
<input type="text" data-table="help" data-field="x_Order" name="x_Order" id="x_Order" size="30" placeholder="<?php echo ew_HtmlEncode($help->Order->getPlaceHolder()) ?>" value="<?php echo $help->Order->EditValue ?>"<?php echo $help->Order->EditAttributes() ?>>
</span>
<?php echo $help->Order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($help->Display_in_Page->Visible) { // Display_in_Page ?>
	<div id="r_Display_in_Page" class="form-group">
		<label id="elh_help_Display_in_Page" for="x_Display_in_Page" class="col-sm-4 control-label ewLabel"><?php echo $help->Display_in_Page->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $help->Display_in_Page->CellAttributes() ?>>
<span id="el_help_Display_in_Page">
<input type="text" data-table="help" data-field="x_Display_in_Page" name="x_Display_in_Page" id="x_Display_in_Page" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($help->Display_in_Page->getPlaceHolder()) ?>" value="<?php echo $help->Display_in_Page->EditValue ?>"<?php echo $help->Display_in_Page->EditAttributes() ?>>
</span>
<?php echo $help->Display_in_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $help_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fhelpadd.Init();
</script>
<?php
$help_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fhelpadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($help->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyAdd(this)'); function alertifyAdd(obj) { <?php global $Language; ?> if (fhelpadd.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyAddConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyAdd'); ?>"); $("#fhelpadd").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$help_add->Page_Terminate();
?>
