<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "userlevelsinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$userlevels_add = NULL; // Initialize page object first

class cuserlevels_add extends cuserlevels {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'userlevels';

	// Page object name
	var $PageObjName = 'userlevels_add';

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

		// Table object (userlevels)
		if (!isset($GLOBALS["userlevels"]) || get_class($GLOBALS["userlevels"]) == "cuserlevels") {
			$GLOBALS["userlevels"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["userlevels"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'userlevels', TRUE);

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
		if (!isset($_SESSION['table_userlevels_views'])) { 
			$_SESSION['table_userlevels_views'] = 0;
		}
		$_SESSION['table_userlevels_views'] = $_SESSION['table_userlevels_views']+1;

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
		if (!$Security->CanAdmin()) {
			$Security->SaveLastUrl();
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
		global $EW_EXPORT, $userlevels;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($userlevels);
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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Load values for user privileges
			$AllowAdd = @$_POST["x__AllowAdd"];
			if ($AllowAdd == "") $AllowAdd = 0;
			$AllowEdit = @$_POST["x__AllowEdit"];
			if ($AllowEdit == "") $AllowEdit = 0;
			$AllowDelete = @$_POST["x__AllowDelete"];
			if ($AllowDelete == "") $AllowDelete = 0;
			$AllowList = @$_POST["x__AllowList"];
			if ($AllowList == "") $AllowList = 0;
			if (defined("EW_USER_LEVEL_COMPAT")) {
				$this->Priv = intval($AllowAdd) + intval($AllowEdit) +
					intval($AllowDelete) + intval($AllowList);
			} else {
				$AllowView = @$_POST["x__AllowView"];
				if ($AllowView == "") $AllowView = 0;
				$AllowSearch = @$_POST["x__AllowSearch"];
				if ($AllowSearch == "") $AllowSearch = 0;
				$this->Priv = intval($AllowAdd) + intval($AllowEdit) +
					intval($AllowDelete) + intval($AllowList) +
					intval($AllowView) + intval($AllowSearch);
			}

			// Begin of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012
			$AllowExportToPrint = @$_POST["x__AllowExportToPrint"];
			if ($AllowExportToPrint == "") $AllowExportToPrint = 0;
			$AllowExportToHTML = @$_POST["x__AllowExportToHTML"];
			if ($AllowExportToHTML == "") $AllowExportToHTML = 0;
			$AllowExportToExcel = @$_POST["x__AllowExportToExcel"];
			if ($AllowExportToExcel == "") $AllowExportToExcel = 0;
			$AllowExportToWord = @$_POST["x__AllowExportToWord"];
			if ($AllowExportToWord == "") $AllowExportToWord = 0;
			$AllowExportToPDF = @$_POST["x__AllowExportToPDF"];
			if ($AllowExportToPDF == "") $AllowExportToPDF = 0;
			$AllowExportToXML = @$_POST["x__AllowExportToXML"];
			if ($AllowExportToXML == "") $AllowExportToXML = 0;
			$AllowExportToCSV = @$_POST["x__AllowExportToCSV"];
			if ($AllowExportToCSV == "") $AllowExportToCSV = 0;
			$AllowExportToEmail = @$_POST["x__AllowExportToEmail"];
			if ($AllowExportToEmail == "") $AllowExportToEmail = 0;
			$this->Priv = $this->Priv + intval($AllowExportToPrint) + intval($AllowExportToHTML) +
						 intval($AllowExportToExcel) + intval($AllowExportToWord) +
										 intval($AllowExportToPDF) + intval($AllowExportToXML) +
										 intval($AllowExportToCSV) + intval($AllowExportToEmail);

			// End of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["User_Level_ID"] != "") {
				$this->User_Level_ID->setQueryStringValue($_GET["User_Level_ID"]);
				$this->setKey("User_Level_ID", $this->User_Level_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("User_Level_ID", ""); // Clear key
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
					$this->Page_Terminate("userlevelslist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "userlevelslist.php")
						$sReturnUrl = $this->AddMasterUrl($this->GetListUrl()); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "userlevelsview.php")
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
		$this->User_Level_ID->CurrentValue = NULL;
		$this->User_Level_ID->OldValue = $this->User_Level_ID->CurrentValue;
		$this->User_Level_Name->CurrentValue = NULL;
		$this->User_Level_Name->OldValue = $this->User_Level_Name->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->User_Level_ID->FldIsDetailKey) {
			$this->User_Level_ID->setFormValue($objForm->GetValue("x_User_Level_ID"));
		}
		if (!$this->User_Level_Name->FldIsDetailKey) {
			$this->User_Level_Name->setFormValue($objForm->GetValue("x_User_Level_Name"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->User_Level_ID->CurrentValue = $this->User_Level_ID->FormValue;
		$this->User_Level_Name->CurrentValue = $this->User_Level_Name->FormValue;
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
		$this->User_Level_ID->setDbValue($rs->fields('User_Level_ID'));
		if (is_null($this->User_Level_ID->CurrentValue)) {
			$this->User_Level_ID->CurrentValue = 0;
		} else {
			$this->User_Level_ID->CurrentValue = intval($this->User_Level_ID->CurrentValue);
		}
		$this->User_Level_Name->setDbValue($rs->fields('User_Level_Name'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->User_Level_ID->DbValue = $row['User_Level_ID'];
		$this->User_Level_Name->DbValue = $row['User_Level_Name'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("User_Level_ID")) <> "")
			$this->User_Level_ID->CurrentValue = $this->getKey("User_Level_ID"); // User_Level_ID
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
		// User_Level_ID
		// User_Level_Name

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// User_Level_ID
		$this->User_Level_ID->ViewValue = $this->User_Level_ID->CurrentValue;
		$this->User_Level_ID->ViewCustomAttributes = "";

		// User_Level_Name
		$this->User_Level_Name->ViewValue = $this->User_Level_Name->CurrentValue;
		if ($Security->GetUserLevelName($this->User_Level_ID->CurrentValue) <> "") $this->User_Level_Name->ViewValue = $Security->GetUserLevelName($this->User_Level_ID->CurrentValue);
		$this->User_Level_Name->ViewCustomAttributes = "";

			// User_Level_ID
			$this->User_Level_ID->LinkCustomAttributes = "";
			$this->User_Level_ID->HrefValue = "";
			$this->User_Level_ID->TooltipValue = "";

			// User_Level_Name
			$this->User_Level_Name->LinkCustomAttributes = "";
			$this->User_Level_Name->HrefValue = "";
			$this->User_Level_Name->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// User_Level_ID
			$this->User_Level_ID->EditAttrs["class"] = "form-control";
			$this->User_Level_ID->EditCustomAttributes = "";
			$this->User_Level_ID->EditValue = ew_HtmlEncode($this->User_Level_ID->CurrentValue);
			$this->User_Level_ID->PlaceHolder = ew_RemoveHtml($this->User_Level_ID->FldCaption());

			// User_Level_Name
			$this->User_Level_Name->EditAttrs["class"] = "form-control";
			$this->User_Level_Name->EditCustomAttributes = "";
			$this->User_Level_Name->EditValue = ew_HtmlEncode($this->User_Level_Name->CurrentValue);
			$this->User_Level_Name->PlaceHolder = ew_RemoveHtml($this->User_Level_Name->FldCaption());

			// Add refer script
			// User_Level_ID

			$this->User_Level_ID->LinkCustomAttributes = "";
			$this->User_Level_ID->HrefValue = "";

			// User_Level_Name
			$this->User_Level_Name->LinkCustomAttributes = "";
			$this->User_Level_Name->HrefValue = "";
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
		if (!$this->User_Level_ID->FldIsDetailKey && !is_null($this->User_Level_ID->FormValue) && $this->User_Level_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->User_Level_ID->FldCaption(), $this->User_Level_ID->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->User_Level_ID->FormValue)) {
			ew_AddMessage($gsFormError, $this->User_Level_ID->FldErrMsg());
		}
		if (!$this->User_Level_Name->FldIsDetailKey && !is_null($this->User_Level_Name->FormValue) && $this->User_Level_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->User_Level_Name->FldCaption(), $this->User_Level_Name->ReqErrMsg));
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
		if (trim(strval($this->User_Level_ID->CurrentValue)) == "") {
			$this->setFailureMessage($Language->Phrase("MissingUserLevelID"));
		} elseif (trim($this->User_Level_Name->CurrentValue) == "") {
			$this->setFailureMessage($Language->Phrase("MissingUserLevelName"));
		} elseif (!is_numeric($this->User_Level_ID->CurrentValue)) {
			$this->setFailureMessage($Language->Phrase("UserLevelIDInteger"));
		} elseif (intval($this->User_Level_ID->CurrentValue) < -2) {
			$this->setFailureMessage($Language->Phrase("UserLevelIDIncorrect"));
		} elseif (intval($this->User_Level_ID->CurrentValue) == 0 && !ew_SameText($this->User_Level_Name->CurrentValue, "Default")) {
			$this->setFailureMessage($Language->Phrase("UserLevelDefaultName"));
		} elseif (intval($this->User_Level_ID->CurrentValue) == -1 && !ew_SameText($this->User_Level_Name->CurrentValue, "Administrator")) {
			$this->setFailureMessage($Language->Phrase("UserLevelAdministratorName"));
		} elseif (intval($this->User_Level_ID->CurrentValue) == -2 && !ew_SameText($this->User_Level_Name->CurrentValue, "Anonymous")) {
			$this->setFailureMessage($Language->Phrase("UserLevelAnonymousName"));
		} elseif (intval($this->User_Level_ID->CurrentValue) > 0 && in_array(strtolower(trim($this->User_Level_Name->CurrentValue)), array("anonymous", "administrator", "default"))) {
			$this->setFailureMessage($Language->Phrase("UserLevelNameIncorrect"));
		}
		if ($this->getFailureMessage() <> "")
			return FALSE;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// User_Level_ID
		$this->User_Level_ID->SetDbValueDef($rsnew, $this->User_Level_ID->CurrentValue, 0, FALSE);

		// User_Level_Name
		$this->User_Level_Name->SetDbValueDef($rsnew, $this->User_Level_Name->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['User_Level_ID']) == "") {
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

		// Add User Level priv
		if ($this->Priv > 0) {
			$UserLevelList = array();
			$UserLevelPrivList = array();
			$TableList = array();
			$GLOBALS["Security"]->LoadUserLevelFromConfigFile($UserLevelList, $UserLevelPrivList, $TableList, TRUE);
			$TableNameCount = count($TableList);
			for ($i = 0; $i < $TableNameCount; $i++) {
				$sSql = "INSERT INTO " . EW_USER_LEVEL_PRIV_TABLE . " (" .
					EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . ", " .
					EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . ", " .
					EW_USER_LEVEL_PRIV_PRIV_FIELD . ") VALUES ('" .
					ew_AdjustSql($TableList[$i][4] . $TableList[$i][0], EW_USER_LEVEL_PRIV_DBID) .
					"', " . $this->User_Level_ID->CurrentValue . ", " . $this->Priv . ")";
				$conn->Execute($sSql);
			}
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("userlevelslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($userlevels_add)) $userlevels_add = new cuserlevels_add();

// Page init
$userlevels_add->Page_Init();

// Page main
$userlevels_add->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$userlevels_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fuserlevelsadd = new ew_Form("fuserlevelsadd", "add");

// Validate form
fuserlevelsadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_User_Level_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $userlevels->User_Level_ID->FldCaption(), $userlevels->User_Level_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_User_Level_ID");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($userlevels->User_Level_ID->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_User_Level_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $userlevels->User_Level_Name->FldCaption(), $userlevels->User_Level_Name->ReqErrMsg)) ?>");
			var elId = fobj.elements["x" + infix + "_User_Level_ID"];
			var elName = fobj.elements["x" + infix + "_User_Level_Name"];
			if (elId && elName) {
				elId.value = $.trim(elId.value);
				elName.value = $.trim(elName.value);
				if (elId && !ew_CheckInteger(elId.value))
					return this.OnError(elId, ewLanguage.Phrase("UserLevelIDInteger"));
				var level = parseInt(elId.value, 10);
				if (level == 0 && !ew_SameText(elName.value, "Default")) {
					return this.OnError(elName, ewLanguage.Phrase("UserLevelDefaultName"));
				} else if (level == -1 && !ew_SameText(elName.value, "Administrator")) {
					return this.OnError(elName, ewLanguage.Phrase("UserLevelAdministratorName"));
				} else if (level == -2 && !ew_SameText(elName.value, "Anonymous")) {
					return this.OnError(elName, ewLanguage.Phrase("UserLevelAnonymousName"));
				} else if (level < -2) {
					return this.OnError(elId, ewLanguage.Phrase("UserLevelIDIncorrect"));
				} else if (level > 0 && ew_InArray(elName.value.toLowerCase(), ["anonymous", "administrator", "default"]) > -1) {
					return this.OnError(elName, ewLanguage.Phrase("UserLevelNameIncorrect"));
				}
			}

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
fuserlevelsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fuserlevelsadd.ValidateRequired = true;
<?php } else { ?>
fuserlevelsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $userlevels_add->ShowPageHeader(); ?>
<?php
$userlevels_add->ShowMessage();
?>
<form name="fuserlevelsadd" id="fuserlevelsadd" class="<?php echo $userlevels_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($userlevels_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $userlevels_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($userlevels->User_Level_ID->Visible) { // User_Level_ID ?>
	<div id="r_User_Level_ID" class="form-group">
		<label id="elh_userlevels_User_Level_ID" for="x_User_Level_ID" class="col-sm-4 control-label ewLabel"><?php echo $userlevels->User_Level_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $userlevels->User_Level_ID->CellAttributes() ?>>
<span id="el_userlevels_User_Level_ID">
<input type="text" data-table="userlevels" data-field="x_User_Level_ID" name="x_User_Level_ID" id="x_User_Level_ID" size="30" placeholder="<?php echo ew_HtmlEncode($userlevels->User_Level_ID->getPlaceHolder()) ?>" value="<?php echo $userlevels->User_Level_ID->EditValue ?>"<?php echo $userlevels->User_Level_ID->EditAttributes() ?>>
</span>
<?php echo $userlevels->User_Level_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userlevels->User_Level_Name->Visible) { // User_Level_Name ?>
	<div id="r_User_Level_Name" class="form-group">
		<label id="elh_userlevels_User_Level_Name" for="x_User_Level_Name" class="col-sm-4 control-label ewLabel"><?php echo $userlevels->User_Level_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $userlevels->User_Level_Name->CellAttributes() ?>>
<span id="el_userlevels_User_Level_Name">
<input type="text" data-table="userlevels" data-field="x_User_Level_Name" name="x_User_Level_Name" id="x_User_Level_Name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($userlevels->User_Level_Name->getPlaceHolder()) ?>" value="<?php echo $userlevels->User_Level_Name->EditValue ?>"<?php echo $userlevels->User_Level_Name->EditAttributes() ?>>
</span>
<?php echo $userlevels->User_Level_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
	<!-- row for permission values -->
	<div id="rp_permission" class="form-group">
		<label class="col-sm-4 control-label ewLabel"><?php echo ew_HtmlTitle($Language->Phrase("Permission")) ?></label>
		<div class="col-sm-8">
<label class="checkbox-inline"><input type="checkbox" name="x__AllowAdd" id="Add" value="<?php echo EW_ALLOW_ADD ?>"><?php echo $Language->Phrase("PermissionAddCopy") ?></label>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowDelete" id="Delete" value="<?php echo EW_ALLOW_DELETE ?>"><?php echo $Language->Phrase("PermissionDelete") ?></label>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowEdit" id="Edit" value="<?php echo EW_ALLOW_EDIT ?>"><?php echo $Language->Phrase("PermissionEdit") ?></label>
<?php if (defined("EW_USER_LEVEL_COMPAT")) { ?>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowList" id="List" value="<?php echo EW_ALLOW_LIST ?>"><?php echo $Language->Phrase("PermissionListSearchView") ?></label>
<?php } else { ?>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowList" id="List" value="<?php echo EW_ALLOW_LIST ?>"><?php echo $Language->Phrase("PermissionList") ?></label>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowView" id="View" value="<?php echo EW_ALLOW_VIEW ?>"><?php echo $Language->Phrase("PermissionView") ?></label>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowSearch" id="Search" value="<?php echo EW_ALLOW_SEARCH ?>"><?php echo $Language->Phrase("PermissionSearch") ?></label>
<?php } ?>
<?php // Begin of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012 ?>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowExportToPrint" id="Print" value="<?php echo MS_ALLOW_EXPORT_TO_PRINT ?>"><?php echo $Language->Phrase("PermissionPrinterFriendly") ?></label><br>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowExportToExcel" id="Excel" value="<?php echo MS_ALLOW_EXPORT_TO_EXCEL ?>"><?php echo $Language->Phrase("PermissionExportToExcel") ?></label><br>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowExportToWord" id="Word" value="<?php echo MS_ALLOW_EXPORT_TO_WORD ?>"><?php echo $Language->Phrase("PermissionExportToWord") ?></label><br>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowExportToHTML" id="HTML" value="<?php echo MS_ALLOW_EXPORT_TO_HTML ?>"><?php echo $Language->Phrase("PermissionExportToHTML") ?></label><br>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowExportToXML" id="XML" value="<?php echo MS_ALLOW_EXPORT_TO_XML ?>"><?php echo $Language->Phrase("PermissionExportToXML") ?></label><br>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowExportToCSV" id="CSV" value="<?php echo MS_ALLOW_EXPORT_TO_CSV ?>"><?php echo $Language->Phrase("PermissionExportToCSV") ?></label><br>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowExportToPDF" id="PDF" value="<?php echo MS_ALLOW_EXPORT_TO_PDF ?>"><?php echo $Language->Phrase("PermissionExportToPDF") ?></label><br>
<label class="checkbox-inline"><input type="checkbox" name="x__AllowExportToEmail" id="Email" value="<?php echo MS_ALLOW_EXPORT_TO_EMAIL ?>"><?php echo $Language->Phrase("PermissionExportToEmail") ?></label><br>
<?php // End of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012 ?>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $userlevels_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fuserlevelsadd.Init();
</script>
<?php
$userlevels_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fuserlevelsadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($userlevels->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyAdd(this)'); function alertifyAdd(obj) { <?php global $Language; ?> if (fuserlevelsadd.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyAddConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyAdd'); ?>"); $("#fuserlevelsadd").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$userlevels_add->Page_Terminate();
?>
