<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "settingsinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$settings_edit = NULL; // Initialize page object first

class csettings_edit extends csettings {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'settings';

	// Page object name
	var $PageObjName = 'settings_edit';

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

		// Table object (settings)
		if (!isset($GLOBALS["settings"]) || get_class($GLOBALS["settings"]) == "csettings") {
			$GLOBALS["settings"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["settings"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'settings', TRUE);

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
		if (!isset($_SESSION['table_settings_views'])) { 
			$_SESSION['table_settings_views'] = 0;
		}
		$_SESSION['table_settings_views'] = $_SESSION['table_settings_views']+1;

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("settingslist.php"));
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
		$this->Option_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Set up multi page object
		$this->SetupMultiPages();

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
		global $EW_EXPORT, $settings;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($settings);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;
	var $MultiPages; // Multi pages object

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["Option_ID"] <> "") {
			$this->Option_ID->setQueryStringValue($_GET["Option_ID"]);
			$this->RecKey["Option_ID"] = $this->Option_ID->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("settingslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->Option_ID->CurrentValue) == strval($this->Recordset->fields('Option_ID'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("settingslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "settingslist.php")
					$sReturnUrl = $this->AddMasterUrl($this->GetListUrl()); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key

					// Begin of modification Disable Add/Edit Success Message Box, by Masino Sinaga, August 1, 2012
					if (MS_SHOW_EDIT_SUCCESS_MESSAGE==TRUE) {
						if ($this->getSuccessMessage() == "")
							$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					}

					// Begin of modification Disable Add/Edit Success Message Box, by Masino Sinaga, August 1, 2012
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Option_ID->FldIsDetailKey)
			$this->Option_ID->setFormValue($objForm->GetValue("x_Option_ID"));
		if (!$this->Option_Default->FldIsDetailKey) {
			$this->Option_Default->setFormValue($objForm->GetValue("x_Option_Default"));
		}
		if (!$this->Default_Theme->FldIsDetailKey) {
			$this->Default_Theme->setFormValue($objForm->GetValue("x_Default_Theme"));
		}
		if (!$this->Font_Name->FldIsDetailKey) {
			$this->Font_Name->setFormValue($objForm->GetValue("x_Font_Name"));
		}
		if (!$this->Font_Size->FldIsDetailKey) {
			$this->Font_Size->setFormValue($objForm->GetValue("x_Font_Size"));
		}
		if (!$this->Show_Border_Layout->FldIsDetailKey) {
			$this->Show_Border_Layout->setFormValue($objForm->GetValue("x_Show_Border_Layout"));
		}
		if (!$this->Show_Shadow_Layout->FldIsDetailKey) {
			$this->Show_Shadow_Layout->setFormValue($objForm->GetValue("x_Show_Shadow_Layout"));
		}
		if (!$this->Menu_Horizontal->FldIsDetailKey) {
			$this->Menu_Horizontal->setFormValue($objForm->GetValue("x_Menu_Horizontal"));
		}
		if (!$this->Vertical_Menu_Width->FldIsDetailKey) {
			$this->Vertical_Menu_Width->setFormValue($objForm->GetValue("x_Vertical_Menu_Width"));
		}
		if (!$this->Show_Announcement->FldIsDetailKey) {
			$this->Show_Announcement->setFormValue($objForm->GetValue("x_Show_Announcement"));
		}
		if (!$this->Demo_Mode->FldIsDetailKey) {
			$this->Demo_Mode->setFormValue($objForm->GetValue("x_Demo_Mode"));
		}
		if (!$this->Show_Page_Processing_Time->FldIsDetailKey) {
			$this->Show_Page_Processing_Time->setFormValue($objForm->GetValue("x_Show_Page_Processing_Time"));
		}
		if (!$this->Allow_User_Preferences->FldIsDetailKey) {
			$this->Allow_User_Preferences->setFormValue($objForm->GetValue("x_Allow_User_Preferences"));
		}
		if (!$this->SMTP_Server->FldIsDetailKey) {
			$this->SMTP_Server->setFormValue($objForm->GetValue("x_SMTP_Server"));
		}
		if (!$this->SMTP_Server_Port->FldIsDetailKey) {
			$this->SMTP_Server_Port->setFormValue($objForm->GetValue("x_SMTP_Server_Port"));
		}
		if (!$this->SMTP_Server_Username->FldIsDetailKey) {
			$this->SMTP_Server_Username->setFormValue($objForm->GetValue("x_SMTP_Server_Username"));
		}
		if (!$this->SMTP_Server_Password->FldIsDetailKey) {
			$this->SMTP_Server_Password->setFormValue($objForm->GetValue("x_SMTP_Server_Password"));
		}
		if (!$this->Sender_Email->FldIsDetailKey) {
			$this->Sender_Email->setFormValue($objForm->GetValue("x_Sender_Email"));
		}
		if (!$this->Recipient_Email->FldIsDetailKey) {
			$this->Recipient_Email->setFormValue($objForm->GetValue("x_Recipient_Email"));
		}
		if (!$this->Use_Default_Locale->FldIsDetailKey) {
			$this->Use_Default_Locale->setFormValue($objForm->GetValue("x_Use_Default_Locale"));
		}
		if (!$this->Default_Language->FldIsDetailKey) {
			$this->Default_Language->setFormValue($objForm->GetValue("x_Default_Language"));
		}
		if (!$this->Default_Timezone->FldIsDetailKey) {
			$this->Default_Timezone->setFormValue($objForm->GetValue("x_Default_Timezone"));
		}
		if (!$this->Default_Thousands_Separator->FldIsDetailKey) {
			$this->Default_Thousands_Separator->setFormValue($objForm->GetValue("x_Default_Thousands_Separator"));
		}
		if (!$this->Default_Decimal_Point->FldIsDetailKey) {
			$this->Default_Decimal_Point->setFormValue($objForm->GetValue("x_Default_Decimal_Point"));
		}
		if (!$this->Default_Currency_Symbol->FldIsDetailKey) {
			$this->Default_Currency_Symbol->setFormValue($objForm->GetValue("x_Default_Currency_Symbol"));
		}
		if (!$this->Default_Money_Thousands_Separator->FldIsDetailKey) {
			$this->Default_Money_Thousands_Separator->setFormValue($objForm->GetValue("x_Default_Money_Thousands_Separator"));
		}
		if (!$this->Default_Money_Decimal_Point->FldIsDetailKey) {
			$this->Default_Money_Decimal_Point->setFormValue($objForm->GetValue("x_Default_Money_Decimal_Point"));
		}
		if (!$this->Maintenance_Mode->FldIsDetailKey) {
			$this->Maintenance_Mode->setFormValue($objForm->GetValue("x_Maintenance_Mode"));
		}
		if (!$this->Maintenance_Finish_DateTime->FldIsDetailKey) {
			$this->Maintenance_Finish_DateTime->setFormValue($objForm->GetValue("x_Maintenance_Finish_DateTime"));
			$this->Maintenance_Finish_DateTime->CurrentValue = ew_UnFormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, 9);
		}
		if (!$this->Auto_Normal_After_Maintenance->FldIsDetailKey) {
			$this->Auto_Normal_After_Maintenance->setFormValue($objForm->GetValue("x_Auto_Normal_After_Maintenance"));
		}
		if (!$this->Allow_User_To_Register->FldIsDetailKey) {
			$this->Allow_User_To_Register->setFormValue($objForm->GetValue("x_Allow_User_To_Register"));
		}
		if (!$this->Suspend_New_User_Account->FldIsDetailKey) {
			$this->Suspend_New_User_Account->setFormValue($objForm->GetValue("x_Suspend_New_User_Account"));
		}
		if (!$this->User_Need_Activation_After_Registered->FldIsDetailKey) {
			$this->User_Need_Activation_After_Registered->setFormValue($objForm->GetValue("x_User_Need_Activation_After_Registered"));
		}
		if (!$this->Show_Captcha_On_Registration_Page->FldIsDetailKey) {
			$this->Show_Captcha_On_Registration_Page->setFormValue($objForm->GetValue("x_Show_Captcha_On_Registration_Page"));
		}
		if (!$this->Show_Terms_And_Conditions_On_Registration_Page->FldIsDetailKey) {
			$this->Show_Terms_And_Conditions_On_Registration_Page->setFormValue($objForm->GetValue("x_Show_Terms_And_Conditions_On_Registration_Page"));
		}
		if (!$this->User_Auto_Login_After_Activation_Or_Registration->FldIsDetailKey) {
			$this->User_Auto_Login_After_Activation_Or_Registration->setFormValue($objForm->GetValue("x_User_Auto_Login_After_Activation_Or_Registration"));
		}
		if (!$this->Show_Captcha_On_Login_Page->FldIsDetailKey) {
			$this->Show_Captcha_On_Login_Page->setFormValue($objForm->GetValue("x_Show_Captcha_On_Login_Page"));
		}
		if (!$this->Show_Captcha_On_Forgot_Password_Page->FldIsDetailKey) {
			$this->Show_Captcha_On_Forgot_Password_Page->setFormValue($objForm->GetValue("x_Show_Captcha_On_Forgot_Password_Page"));
		}
		if (!$this->Show_Captcha_On_Change_Password_Page->FldIsDetailKey) {
			$this->Show_Captcha_On_Change_Password_Page->setFormValue($objForm->GetValue("x_Show_Captcha_On_Change_Password_Page"));
		}
		if (!$this->User_Auto_Logout_After_Idle_In_Minutes->FldIsDetailKey) {
			$this->User_Auto_Logout_After_Idle_In_Minutes->setFormValue($objForm->GetValue("x_User_Auto_Logout_After_Idle_In_Minutes"));
		}
		if (!$this->User_Login_Maximum_Retry->FldIsDetailKey) {
			$this->User_Login_Maximum_Retry->setFormValue($objForm->GetValue("x_User_Login_Maximum_Retry"));
		}
		if (!$this->User_Login_Retry_Lockout->FldIsDetailKey) {
			$this->User_Login_Retry_Lockout->setFormValue($objForm->GetValue("x_User_Login_Retry_Lockout"));
		}
		if (!$this->Redirect_To_Last_Visited_Page_After_Login->FldIsDetailKey) {
			$this->Redirect_To_Last_Visited_Page_After_Login->setFormValue($objForm->GetValue("x_Redirect_To_Last_Visited_Page_After_Login"));
		}
		if (!$this->Enable_Password_Expiry->FldIsDetailKey) {
			$this->Enable_Password_Expiry->setFormValue($objForm->GetValue("x_Enable_Password_Expiry"));
		}
		if (!$this->Password_Expiry_In_Days->FldIsDetailKey) {
			$this->Password_Expiry_In_Days->setFormValue($objForm->GetValue("x_Password_Expiry_In_Days"));
		}
		if (!$this->Show_Entire_Header->FldIsDetailKey) {
			$this->Show_Entire_Header->setFormValue($objForm->GetValue("x_Show_Entire_Header"));
		}
		if (!$this->Logo_Width->FldIsDetailKey) {
			$this->Logo_Width->setFormValue($objForm->GetValue("x_Logo_Width"));
		}
		if (!$this->Show_Site_Title_In_Header->FldIsDetailKey) {
			$this->Show_Site_Title_In_Header->setFormValue($objForm->GetValue("x_Show_Site_Title_In_Header"));
		}
		if (!$this->Show_Current_User_In_Header->FldIsDetailKey) {
			$this->Show_Current_User_In_Header->setFormValue($objForm->GetValue("x_Show_Current_User_In_Header"));
		}
		if (!$this->Text_Align_In_Header->FldIsDetailKey) {
			$this->Text_Align_In_Header->setFormValue($objForm->GetValue("x_Text_Align_In_Header"));
		}
		if (!$this->Site_Title_Text_Style->FldIsDetailKey) {
			$this->Site_Title_Text_Style->setFormValue($objForm->GetValue("x_Site_Title_Text_Style"));
		}
		if (!$this->Language_Selector_Visibility->FldIsDetailKey) {
			$this->Language_Selector_Visibility->setFormValue($objForm->GetValue("x_Language_Selector_Visibility"));
		}
		if (!$this->Language_Selector_Align->FldIsDetailKey) {
			$this->Language_Selector_Align->setFormValue($objForm->GetValue("x_Language_Selector_Align"));
		}
		if (!$this->Show_Entire_Footer->FldIsDetailKey) {
			$this->Show_Entire_Footer->setFormValue($objForm->GetValue("x_Show_Entire_Footer"));
		}
		if (!$this->Show_Text_In_Footer->FldIsDetailKey) {
			$this->Show_Text_In_Footer->setFormValue($objForm->GetValue("x_Show_Text_In_Footer"));
		}
		if (!$this->Show_Back_To_Top_On_Footer->FldIsDetailKey) {
			$this->Show_Back_To_Top_On_Footer->setFormValue($objForm->GetValue("x_Show_Back_To_Top_On_Footer"));
		}
		if (!$this->Show_Terms_And_Conditions_On_Footer->FldIsDetailKey) {
			$this->Show_Terms_And_Conditions_On_Footer->setFormValue($objForm->GetValue("x_Show_Terms_And_Conditions_On_Footer"));
		}
		if (!$this->Show_About_Us_On_Footer->FldIsDetailKey) {
			$this->Show_About_Us_On_Footer->setFormValue($objForm->GetValue("x_Show_About_Us_On_Footer"));
		}
		if (!$this->Pagination_Position->FldIsDetailKey) {
			$this->Pagination_Position->setFormValue($objForm->GetValue("x_Pagination_Position"));
		}
		if (!$this->Pagination_Style->FldIsDetailKey) {
			$this->Pagination_Style->setFormValue($objForm->GetValue("x_Pagination_Style"));
		}
		if (!$this->Selectable_Records_Per_Page->FldIsDetailKey) {
			$this->Selectable_Records_Per_Page->setFormValue($objForm->GetValue("x_Selectable_Records_Per_Page"));
		}
		if (!$this->Selectable_Groups_Per_Page->FldIsDetailKey) {
			$this->Selectable_Groups_Per_Page->setFormValue($objForm->GetValue("x_Selectable_Groups_Per_Page"));
		}
		if (!$this->Default_Record_Per_Page->FldIsDetailKey) {
			$this->Default_Record_Per_Page->setFormValue($objForm->GetValue("x_Default_Record_Per_Page"));
		}
		if (!$this->Default_Group_Per_Page->FldIsDetailKey) {
			$this->Default_Group_Per_Page->setFormValue($objForm->GetValue("x_Default_Group_Per_Page"));
		}
		if (!$this->Maximum_Selected_Records->FldIsDetailKey) {
			$this->Maximum_Selected_Records->setFormValue($objForm->GetValue("x_Maximum_Selected_Records"));
		}
		if (!$this->Maximum_Selected_Groups->FldIsDetailKey) {
			$this->Maximum_Selected_Groups->setFormValue($objForm->GetValue("x_Maximum_Selected_Groups"));
		}
		if (!$this->Show_PageNum_If_Record_Not_Over_Pagesize->FldIsDetailKey) {
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->setFormValue($objForm->GetValue("x_Show_PageNum_If_Record_Not_Over_Pagesize"));
		}
		if (!$this->Table_Width_Style->FldIsDetailKey) {
			$this->Table_Width_Style->setFormValue($objForm->GetValue("x_Table_Width_Style"));
		}
		if (!$this->Scroll_Table_Width->FldIsDetailKey) {
			$this->Scroll_Table_Width->setFormValue($objForm->GetValue("x_Scroll_Table_Width"));
		}
		if (!$this->Scroll_Table_Height->FldIsDetailKey) {
			$this->Scroll_Table_Height->setFormValue($objForm->GetValue("x_Scroll_Table_Height"));
		}
		if (!$this->Search_Panel_Collapsed->FldIsDetailKey) {
			$this->Search_Panel_Collapsed->setFormValue($objForm->GetValue("x_Search_Panel_Collapsed"));
		}
		if (!$this->Filter_Panel_Collapsed->FldIsDetailKey) {
			$this->Filter_Panel_Collapsed->setFormValue($objForm->GetValue("x_Filter_Panel_Collapsed"));
		}
		if (!$this->Show_Record_Number_On_List_Page->FldIsDetailKey) {
			$this->Show_Record_Number_On_List_Page->setFormValue($objForm->GetValue("x_Show_Record_Number_On_List_Page"));
		}
		if (!$this->Show_Empty_Table_On_List_Page->FldIsDetailKey) {
			$this->Show_Empty_Table_On_List_Page->setFormValue($objForm->GetValue("x_Show_Empty_Table_On_List_Page"));
		}
		if (!$this->Rows_Vertical_Align_Top->FldIsDetailKey) {
			$this->Rows_Vertical_Align_Top->setFormValue($objForm->GetValue("x_Rows_Vertical_Align_Top"));
		}
		if (!$this->Action_Button_Alignment->FldIsDetailKey) {
			$this->Action_Button_Alignment->setFormValue($objForm->GetValue("x_Action_Button_Alignment"));
		}
		if (!$this->Show_Add_Success_Message->FldIsDetailKey) {
			$this->Show_Add_Success_Message->setFormValue($objForm->GetValue("x_Show_Add_Success_Message"));
		}
		if (!$this->Show_Edit_Success_Message->FldIsDetailKey) {
			$this->Show_Edit_Success_Message->setFormValue($objForm->GetValue("x_Show_Edit_Success_Message"));
		}
		if (!$this->jQuery_Auto_Hide_Success_Message->FldIsDetailKey) {
			$this->jQuery_Auto_Hide_Success_Message->setFormValue($objForm->GetValue("x_jQuery_Auto_Hide_Success_Message"));
		}
		if (!$this->Use_Javascript_Message->FldIsDetailKey) {
			$this->Use_Javascript_Message->setFormValue($objForm->GetValue("x_Use_Javascript_Message"));
		}
		if (!$this->Login_Window_Type->FldIsDetailKey) {
			$this->Login_Window_Type->setFormValue($objForm->GetValue("x_Login_Window_Type"));
		}
		if (!$this->Forgot_Password_Window_Type->FldIsDetailKey) {
			$this->Forgot_Password_Window_Type->setFormValue($objForm->GetValue("x_Forgot_Password_Window_Type"));
		}
		if (!$this->Change_Password_Window_Type->FldIsDetailKey) {
			$this->Change_Password_Window_Type->setFormValue($objForm->GetValue("x_Change_Password_Window_Type"));
		}
		if (!$this->Registration_Window_Type->FldIsDetailKey) {
			$this->Registration_Window_Type->setFormValue($objForm->GetValue("x_Registration_Window_Type"));
		}
		if (!$this->Show_Record_Number_On_Detail_Preview->FldIsDetailKey) {
			$this->Show_Record_Number_On_Detail_Preview->setFormValue($objForm->GetValue("x_Show_Record_Number_On_Detail_Preview"));
		}
		if (!$this->Show_Empty_Table_In_Detail_Preview->FldIsDetailKey) {
			$this->Show_Empty_Table_In_Detail_Preview->setFormValue($objForm->GetValue("x_Show_Empty_Table_In_Detail_Preview"));
		}
		if (!$this->Detail_Preview_Table_Width->FldIsDetailKey) {
			$this->Detail_Preview_Table_Width->setFormValue($objForm->GetValue("x_Detail_Preview_Table_Width"));
		}
		if (!$this->Password_Minimum_Length->FldIsDetailKey) {
			$this->Password_Minimum_Length->setFormValue($objForm->GetValue("x_Password_Minimum_Length"));
		}
		if (!$this->Password_Maximum_Length->FldIsDetailKey) {
			$this->Password_Maximum_Length->setFormValue($objForm->GetValue("x_Password_Maximum_Length"));
		}
		if (!$this->Password_Must_Contain_At_Least_One_Lower_Case->FldIsDetailKey) {
			$this->Password_Must_Contain_At_Least_One_Lower_Case->setFormValue($objForm->GetValue("x_Password_Must_Contain_At_Least_One_Lower_Case"));
		}
		if (!$this->Password_Must_Comply_With_Minumum_Length->FldIsDetailKey) {
			$this->Password_Must_Comply_With_Minumum_Length->setFormValue($objForm->GetValue("x_Password_Must_Comply_With_Minumum_Length"));
		}
		if (!$this->Password_Must_Comply_With_Maximum_Length->FldIsDetailKey) {
			$this->Password_Must_Comply_With_Maximum_Length->setFormValue($objForm->GetValue("x_Password_Must_Comply_With_Maximum_Length"));
		}
		if (!$this->Password_Must_Contain_At_Least_One_Upper_Case->FldIsDetailKey) {
			$this->Password_Must_Contain_At_Least_One_Upper_Case->setFormValue($objForm->GetValue("x_Password_Must_Contain_At_Least_One_Upper_Case"));
		}
		if (!$this->Password_Must_Contain_At_Least_One_Numeric->FldIsDetailKey) {
			$this->Password_Must_Contain_At_Least_One_Numeric->setFormValue($objForm->GetValue("x_Password_Must_Contain_At_Least_One_Numeric"));
		}
		if (!$this->Password_Must_Contain_At_Least_One_Symbol->FldIsDetailKey) {
			$this->Password_Must_Contain_At_Least_One_Symbol->setFormValue($objForm->GetValue("x_Password_Must_Contain_At_Least_One_Symbol"));
		}
		if (!$this->Password_Must_Be_Difference_Between_Old_And_New->FldIsDetailKey) {
			$this->Password_Must_Be_Difference_Between_Old_And_New->setFormValue($objForm->GetValue("x_Password_Must_Be_Difference_Between_Old_And_New"));
		}
		if (!$this->Reset_Password_Field_Options->FldIsDetailKey) {
			$this->Reset_Password_Field_Options->setFormValue($objForm->GetValue("x_Reset_Password_Field_Options"));
		}
		if (!$this->Export_Record_Options->FldIsDetailKey) {
			$this->Export_Record_Options->setFormValue($objForm->GetValue("x_Export_Record_Options"));
		}
		if (!$this->Show_Record_Number_On_Exported_List_Page->FldIsDetailKey) {
			$this->Show_Record_Number_On_Exported_List_Page->setFormValue($objForm->GetValue("x_Show_Record_Number_On_Exported_List_Page"));
		}
		if (!$this->Use_Table_Setting_For_Export_Field_Caption->FldIsDetailKey) {
			$this->Use_Table_Setting_For_Export_Field_Caption->setFormValue($objForm->GetValue("x_Use_Table_Setting_For_Export_Field_Caption"));
		}
		if (!$this->Use_Table_Setting_For_Export_Original_Value->FldIsDetailKey) {
			$this->Use_Table_Setting_For_Export_Original_Value->setFormValue($objForm->GetValue("x_Use_Table_Setting_For_Export_Original_Value"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Option_ID->CurrentValue = $this->Option_ID->FormValue;
		$this->Option_Default->CurrentValue = $this->Option_Default->FormValue;
		$this->Default_Theme->CurrentValue = $this->Default_Theme->FormValue;
		$this->Font_Name->CurrentValue = $this->Font_Name->FormValue;
		$this->Font_Size->CurrentValue = $this->Font_Size->FormValue;
		$this->Show_Border_Layout->CurrentValue = $this->Show_Border_Layout->FormValue;
		$this->Show_Shadow_Layout->CurrentValue = $this->Show_Shadow_Layout->FormValue;
		$this->Menu_Horizontal->CurrentValue = $this->Menu_Horizontal->FormValue;
		$this->Vertical_Menu_Width->CurrentValue = $this->Vertical_Menu_Width->FormValue;
		$this->Show_Announcement->CurrentValue = $this->Show_Announcement->FormValue;
		$this->Demo_Mode->CurrentValue = $this->Demo_Mode->FormValue;
		$this->Show_Page_Processing_Time->CurrentValue = $this->Show_Page_Processing_Time->FormValue;
		$this->Allow_User_Preferences->CurrentValue = $this->Allow_User_Preferences->FormValue;
		$this->SMTP_Server->CurrentValue = $this->SMTP_Server->FormValue;
		$this->SMTP_Server_Port->CurrentValue = $this->SMTP_Server_Port->FormValue;
		$this->SMTP_Server_Username->CurrentValue = $this->SMTP_Server_Username->FormValue;
		$this->SMTP_Server_Password->CurrentValue = $this->SMTP_Server_Password->FormValue;
		$this->Sender_Email->CurrentValue = $this->Sender_Email->FormValue;
		$this->Recipient_Email->CurrentValue = $this->Recipient_Email->FormValue;
		$this->Use_Default_Locale->CurrentValue = $this->Use_Default_Locale->FormValue;
		$this->Default_Language->CurrentValue = $this->Default_Language->FormValue;
		$this->Default_Timezone->CurrentValue = $this->Default_Timezone->FormValue;
		$this->Default_Thousands_Separator->CurrentValue = $this->Default_Thousands_Separator->FormValue;
		$this->Default_Decimal_Point->CurrentValue = $this->Default_Decimal_Point->FormValue;
		$this->Default_Currency_Symbol->CurrentValue = $this->Default_Currency_Symbol->FormValue;
		$this->Default_Money_Thousands_Separator->CurrentValue = $this->Default_Money_Thousands_Separator->FormValue;
		$this->Default_Money_Decimal_Point->CurrentValue = $this->Default_Money_Decimal_Point->FormValue;
		$this->Maintenance_Mode->CurrentValue = $this->Maintenance_Mode->FormValue;
		$this->Maintenance_Finish_DateTime->CurrentValue = $this->Maintenance_Finish_DateTime->FormValue;
		$this->Maintenance_Finish_DateTime->CurrentValue = ew_UnFormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, 9);
		$this->Auto_Normal_After_Maintenance->CurrentValue = $this->Auto_Normal_After_Maintenance->FormValue;
		$this->Allow_User_To_Register->CurrentValue = $this->Allow_User_To_Register->FormValue;
		$this->Suspend_New_User_Account->CurrentValue = $this->Suspend_New_User_Account->FormValue;
		$this->User_Need_Activation_After_Registered->CurrentValue = $this->User_Need_Activation_After_Registered->FormValue;
		$this->Show_Captcha_On_Registration_Page->CurrentValue = $this->Show_Captcha_On_Registration_Page->FormValue;
		$this->Show_Terms_And_Conditions_On_Registration_Page->CurrentValue = $this->Show_Terms_And_Conditions_On_Registration_Page->FormValue;
		$this->User_Auto_Login_After_Activation_Or_Registration->CurrentValue = $this->User_Auto_Login_After_Activation_Or_Registration->FormValue;
		$this->Show_Captcha_On_Login_Page->CurrentValue = $this->Show_Captcha_On_Login_Page->FormValue;
		$this->Show_Captcha_On_Forgot_Password_Page->CurrentValue = $this->Show_Captcha_On_Forgot_Password_Page->FormValue;
		$this->Show_Captcha_On_Change_Password_Page->CurrentValue = $this->Show_Captcha_On_Change_Password_Page->FormValue;
		$this->User_Auto_Logout_After_Idle_In_Minutes->CurrentValue = $this->User_Auto_Logout_After_Idle_In_Minutes->FormValue;
		$this->User_Login_Maximum_Retry->CurrentValue = $this->User_Login_Maximum_Retry->FormValue;
		$this->User_Login_Retry_Lockout->CurrentValue = $this->User_Login_Retry_Lockout->FormValue;
		$this->Redirect_To_Last_Visited_Page_After_Login->CurrentValue = $this->Redirect_To_Last_Visited_Page_After_Login->FormValue;
		$this->Enable_Password_Expiry->CurrentValue = $this->Enable_Password_Expiry->FormValue;
		$this->Password_Expiry_In_Days->CurrentValue = $this->Password_Expiry_In_Days->FormValue;
		$this->Show_Entire_Header->CurrentValue = $this->Show_Entire_Header->FormValue;
		$this->Logo_Width->CurrentValue = $this->Logo_Width->FormValue;
		$this->Show_Site_Title_In_Header->CurrentValue = $this->Show_Site_Title_In_Header->FormValue;
		$this->Show_Current_User_In_Header->CurrentValue = $this->Show_Current_User_In_Header->FormValue;
		$this->Text_Align_In_Header->CurrentValue = $this->Text_Align_In_Header->FormValue;
		$this->Site_Title_Text_Style->CurrentValue = $this->Site_Title_Text_Style->FormValue;
		$this->Language_Selector_Visibility->CurrentValue = $this->Language_Selector_Visibility->FormValue;
		$this->Language_Selector_Align->CurrentValue = $this->Language_Selector_Align->FormValue;
		$this->Show_Entire_Footer->CurrentValue = $this->Show_Entire_Footer->FormValue;
		$this->Show_Text_In_Footer->CurrentValue = $this->Show_Text_In_Footer->FormValue;
		$this->Show_Back_To_Top_On_Footer->CurrentValue = $this->Show_Back_To_Top_On_Footer->FormValue;
		$this->Show_Terms_And_Conditions_On_Footer->CurrentValue = $this->Show_Terms_And_Conditions_On_Footer->FormValue;
		$this->Show_About_Us_On_Footer->CurrentValue = $this->Show_About_Us_On_Footer->FormValue;
		$this->Pagination_Position->CurrentValue = $this->Pagination_Position->FormValue;
		$this->Pagination_Style->CurrentValue = $this->Pagination_Style->FormValue;
		$this->Selectable_Records_Per_Page->CurrentValue = $this->Selectable_Records_Per_Page->FormValue;
		$this->Selectable_Groups_Per_Page->CurrentValue = $this->Selectable_Groups_Per_Page->FormValue;
		$this->Default_Record_Per_Page->CurrentValue = $this->Default_Record_Per_Page->FormValue;
		$this->Default_Group_Per_Page->CurrentValue = $this->Default_Group_Per_Page->FormValue;
		$this->Maximum_Selected_Records->CurrentValue = $this->Maximum_Selected_Records->FormValue;
		$this->Maximum_Selected_Groups->CurrentValue = $this->Maximum_Selected_Groups->FormValue;
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->CurrentValue = $this->Show_PageNum_If_Record_Not_Over_Pagesize->FormValue;
		$this->Table_Width_Style->CurrentValue = $this->Table_Width_Style->FormValue;
		$this->Scroll_Table_Width->CurrentValue = $this->Scroll_Table_Width->FormValue;
		$this->Scroll_Table_Height->CurrentValue = $this->Scroll_Table_Height->FormValue;
		$this->Search_Panel_Collapsed->CurrentValue = $this->Search_Panel_Collapsed->FormValue;
		$this->Filter_Panel_Collapsed->CurrentValue = $this->Filter_Panel_Collapsed->FormValue;
		$this->Show_Record_Number_On_List_Page->CurrentValue = $this->Show_Record_Number_On_List_Page->FormValue;
		$this->Show_Empty_Table_On_List_Page->CurrentValue = $this->Show_Empty_Table_On_List_Page->FormValue;
		$this->Rows_Vertical_Align_Top->CurrentValue = $this->Rows_Vertical_Align_Top->FormValue;
		$this->Action_Button_Alignment->CurrentValue = $this->Action_Button_Alignment->FormValue;
		$this->Show_Add_Success_Message->CurrentValue = $this->Show_Add_Success_Message->FormValue;
		$this->Show_Edit_Success_Message->CurrentValue = $this->Show_Edit_Success_Message->FormValue;
		$this->jQuery_Auto_Hide_Success_Message->CurrentValue = $this->jQuery_Auto_Hide_Success_Message->FormValue;
		$this->Use_Javascript_Message->CurrentValue = $this->Use_Javascript_Message->FormValue;
		$this->Login_Window_Type->CurrentValue = $this->Login_Window_Type->FormValue;
		$this->Forgot_Password_Window_Type->CurrentValue = $this->Forgot_Password_Window_Type->FormValue;
		$this->Change_Password_Window_Type->CurrentValue = $this->Change_Password_Window_Type->FormValue;
		$this->Registration_Window_Type->CurrentValue = $this->Registration_Window_Type->FormValue;
		$this->Show_Record_Number_On_Detail_Preview->CurrentValue = $this->Show_Record_Number_On_Detail_Preview->FormValue;
		$this->Show_Empty_Table_In_Detail_Preview->CurrentValue = $this->Show_Empty_Table_In_Detail_Preview->FormValue;
		$this->Detail_Preview_Table_Width->CurrentValue = $this->Detail_Preview_Table_Width->FormValue;
		$this->Password_Minimum_Length->CurrentValue = $this->Password_Minimum_Length->FormValue;
		$this->Password_Maximum_Length->CurrentValue = $this->Password_Maximum_Length->FormValue;
		$this->Password_Must_Contain_At_Least_One_Lower_Case->CurrentValue = $this->Password_Must_Contain_At_Least_One_Lower_Case->FormValue;
		$this->Password_Must_Comply_With_Minumum_Length->CurrentValue = $this->Password_Must_Comply_With_Minumum_Length->FormValue;
		$this->Password_Must_Comply_With_Maximum_Length->CurrentValue = $this->Password_Must_Comply_With_Maximum_Length->FormValue;
		$this->Password_Must_Contain_At_Least_One_Upper_Case->CurrentValue = $this->Password_Must_Contain_At_Least_One_Upper_Case->FormValue;
		$this->Password_Must_Contain_At_Least_One_Numeric->CurrentValue = $this->Password_Must_Contain_At_Least_One_Numeric->FormValue;
		$this->Password_Must_Contain_At_Least_One_Symbol->CurrentValue = $this->Password_Must_Contain_At_Least_One_Symbol->FormValue;
		$this->Password_Must_Be_Difference_Between_Old_And_New->CurrentValue = $this->Password_Must_Be_Difference_Between_Old_And_New->FormValue;
		$this->Reset_Password_Field_Options->CurrentValue = $this->Reset_Password_Field_Options->FormValue;
		$this->Export_Record_Options->CurrentValue = $this->Export_Record_Options->FormValue;
		$this->Show_Record_Number_On_Exported_List_Page->CurrentValue = $this->Show_Record_Number_On_Exported_List_Page->FormValue;
		$this->Use_Table_Setting_For_Export_Field_Caption->CurrentValue = $this->Use_Table_Setting_For_Export_Field_Caption->FormValue;
		$this->Use_Table_Setting_For_Export_Original_Value->CurrentValue = $this->Use_Table_Setting_For_Export_Original_Value->FormValue;
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
		$this->Option_ID->setDbValue($rs->fields('Option_ID'));
		$this->Option_Default->setDbValue($rs->fields('Option_Default'));
		$this->Default_Theme->setDbValue($rs->fields('Default_Theme'));
		$this->Font_Name->setDbValue($rs->fields('Font_Name'));
		$this->Font_Size->setDbValue($rs->fields('Font_Size'));
		$this->Show_Border_Layout->setDbValue($rs->fields('Show_Border_Layout'));
		$this->Show_Shadow_Layout->setDbValue($rs->fields('Show_Shadow_Layout'));
		$this->Menu_Horizontal->setDbValue($rs->fields('Menu_Horizontal'));
		$this->Vertical_Menu_Width->setDbValue($rs->fields('Vertical_Menu_Width'));
		$this->Show_Announcement->setDbValue($rs->fields('Show_Announcement'));
		$this->Demo_Mode->setDbValue($rs->fields('Demo_Mode'));
		$this->Show_Page_Processing_Time->setDbValue($rs->fields('Show_Page_Processing_Time'));
		$this->Allow_User_Preferences->setDbValue($rs->fields('Allow_User_Preferences'));
		$this->SMTP_Server->setDbValue($rs->fields('SMTP_Server'));
		$this->SMTP_Server_Port->setDbValue($rs->fields('SMTP_Server_Port'));
		$this->SMTP_Server_Username->setDbValue($rs->fields('SMTP_Server_Username'));
		$this->SMTP_Server_Password->setDbValue($rs->fields('SMTP_Server_Password'));
		$this->Sender_Email->setDbValue($rs->fields('Sender_Email'));
		$this->Recipient_Email->setDbValue($rs->fields('Recipient_Email'));
		$this->Use_Default_Locale->setDbValue($rs->fields('Use_Default_Locale'));
		$this->Default_Language->setDbValue($rs->fields('Default_Language'));
		$this->Default_Timezone->setDbValue($rs->fields('Default_Timezone'));
		$this->Default_Thousands_Separator->setDbValue($rs->fields('Default_Thousands_Separator'));
		$this->Default_Decimal_Point->setDbValue($rs->fields('Default_Decimal_Point'));
		$this->Default_Currency_Symbol->setDbValue($rs->fields('Default_Currency_Symbol'));
		$this->Default_Money_Thousands_Separator->setDbValue($rs->fields('Default_Money_Thousands_Separator'));
		$this->Default_Money_Decimal_Point->setDbValue($rs->fields('Default_Money_Decimal_Point'));
		$this->Maintenance_Mode->setDbValue($rs->fields('Maintenance_Mode'));
		$this->Maintenance_Finish_DateTime->setDbValue($rs->fields('Maintenance_Finish_DateTime'));
		$this->Auto_Normal_After_Maintenance->setDbValue($rs->fields('Auto_Normal_After_Maintenance'));
		$this->Allow_User_To_Register->setDbValue($rs->fields('Allow_User_To_Register'));
		$this->Suspend_New_User_Account->setDbValue($rs->fields('Suspend_New_User_Account'));
		$this->User_Need_Activation_After_Registered->setDbValue($rs->fields('User_Need_Activation_After_Registered'));
		$this->Show_Captcha_On_Registration_Page->setDbValue($rs->fields('Show_Captcha_On_Registration_Page'));
		$this->Show_Terms_And_Conditions_On_Registration_Page->setDbValue($rs->fields('Show_Terms_And_Conditions_On_Registration_Page'));
		$this->User_Auto_Login_After_Activation_Or_Registration->setDbValue($rs->fields('User_Auto_Login_After_Activation_Or_Registration'));
		$this->Show_Captcha_On_Login_Page->setDbValue($rs->fields('Show_Captcha_On_Login_Page'));
		$this->Show_Captcha_On_Forgot_Password_Page->setDbValue($rs->fields('Show_Captcha_On_Forgot_Password_Page'));
		$this->Show_Captcha_On_Change_Password_Page->setDbValue($rs->fields('Show_Captcha_On_Change_Password_Page'));
		$this->User_Auto_Logout_After_Idle_In_Minutes->setDbValue($rs->fields('User_Auto_Logout_After_Idle_In_Minutes'));
		$this->User_Login_Maximum_Retry->setDbValue($rs->fields('User_Login_Maximum_Retry'));
		$this->User_Login_Retry_Lockout->setDbValue($rs->fields('User_Login_Retry_Lockout'));
		$this->Redirect_To_Last_Visited_Page_After_Login->setDbValue($rs->fields('Redirect_To_Last_Visited_Page_After_Login'));
		$this->Enable_Password_Expiry->setDbValue($rs->fields('Enable_Password_Expiry'));
		$this->Password_Expiry_In_Days->setDbValue($rs->fields('Password_Expiry_In_Days'));
		$this->Show_Entire_Header->setDbValue($rs->fields('Show_Entire_Header'));
		$this->Logo_Width->setDbValue($rs->fields('Logo_Width'));
		$this->Show_Site_Title_In_Header->setDbValue($rs->fields('Show_Site_Title_In_Header'));
		$this->Show_Current_User_In_Header->setDbValue($rs->fields('Show_Current_User_In_Header'));
		$this->Text_Align_In_Header->setDbValue($rs->fields('Text_Align_In_Header'));
		$this->Site_Title_Text_Style->setDbValue($rs->fields('Site_Title_Text_Style'));
		$this->Language_Selector_Visibility->setDbValue($rs->fields('Language_Selector_Visibility'));
		$this->Language_Selector_Align->setDbValue($rs->fields('Language_Selector_Align'));
		$this->Show_Entire_Footer->setDbValue($rs->fields('Show_Entire_Footer'));
		$this->Show_Text_In_Footer->setDbValue($rs->fields('Show_Text_In_Footer'));
		$this->Show_Back_To_Top_On_Footer->setDbValue($rs->fields('Show_Back_To_Top_On_Footer'));
		$this->Show_Terms_And_Conditions_On_Footer->setDbValue($rs->fields('Show_Terms_And_Conditions_On_Footer'));
		$this->Show_About_Us_On_Footer->setDbValue($rs->fields('Show_About_Us_On_Footer'));
		$this->Pagination_Position->setDbValue($rs->fields('Pagination_Position'));
		$this->Pagination_Style->setDbValue($rs->fields('Pagination_Style'));
		$this->Selectable_Records_Per_Page->setDbValue($rs->fields('Selectable_Records_Per_Page'));
		$this->Selectable_Groups_Per_Page->setDbValue($rs->fields('Selectable_Groups_Per_Page'));
		$this->Default_Record_Per_Page->setDbValue($rs->fields('Default_Record_Per_Page'));
		$this->Default_Group_Per_Page->setDbValue($rs->fields('Default_Group_Per_Page'));
		$this->Maximum_Selected_Records->setDbValue($rs->fields('Maximum_Selected_Records'));
		$this->Maximum_Selected_Groups->setDbValue($rs->fields('Maximum_Selected_Groups'));
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->setDbValue($rs->fields('Show_PageNum_If_Record_Not_Over_Pagesize'));
		$this->Table_Width_Style->setDbValue($rs->fields('Table_Width_Style'));
		$this->Scroll_Table_Width->setDbValue($rs->fields('Scroll_Table_Width'));
		$this->Scroll_Table_Height->setDbValue($rs->fields('Scroll_Table_Height'));
		$this->Search_Panel_Collapsed->setDbValue($rs->fields('Search_Panel_Collapsed'));
		$this->Filter_Panel_Collapsed->setDbValue($rs->fields('Filter_Panel_Collapsed'));
		$this->Show_Record_Number_On_List_Page->setDbValue($rs->fields('Show_Record_Number_On_List_Page'));
		$this->Show_Empty_Table_On_List_Page->setDbValue($rs->fields('Show_Empty_Table_On_List_Page'));
		$this->Rows_Vertical_Align_Top->setDbValue($rs->fields('Rows_Vertical_Align_Top'));
		$this->Action_Button_Alignment->setDbValue($rs->fields('Action_Button_Alignment'));
		$this->Show_Add_Success_Message->setDbValue($rs->fields('Show_Add_Success_Message'));
		$this->Show_Edit_Success_Message->setDbValue($rs->fields('Show_Edit_Success_Message'));
		$this->jQuery_Auto_Hide_Success_Message->setDbValue($rs->fields('jQuery_Auto_Hide_Success_Message'));
		$this->Use_Javascript_Message->setDbValue($rs->fields('Use_Javascript_Message'));
		$this->Login_Window_Type->setDbValue($rs->fields('Login_Window_Type'));
		$this->Forgot_Password_Window_Type->setDbValue($rs->fields('Forgot_Password_Window_Type'));
		$this->Change_Password_Window_Type->setDbValue($rs->fields('Change_Password_Window_Type'));
		$this->Registration_Window_Type->setDbValue($rs->fields('Registration_Window_Type'));
		$this->Show_Record_Number_On_Detail_Preview->setDbValue($rs->fields('Show_Record_Number_On_Detail_Preview'));
		$this->Show_Empty_Table_In_Detail_Preview->setDbValue($rs->fields('Show_Empty_Table_In_Detail_Preview'));
		$this->Detail_Preview_Table_Width->setDbValue($rs->fields('Detail_Preview_Table_Width'));
		$this->Password_Minimum_Length->setDbValue($rs->fields('Password_Minimum_Length'));
		$this->Password_Maximum_Length->setDbValue($rs->fields('Password_Maximum_Length'));
		$this->Password_Must_Contain_At_Least_One_Lower_Case->setDbValue($rs->fields('Password_Must_Contain_At_Least_One_Lower_Case'));
		$this->Password_Must_Comply_With_Minumum_Length->setDbValue($rs->fields('Password_Must_Comply_With_Minumum_Length'));
		$this->Password_Must_Comply_With_Maximum_Length->setDbValue($rs->fields('Password_Must_Comply_With_Maximum_Length'));
		$this->Password_Must_Contain_At_Least_One_Upper_Case->setDbValue($rs->fields('Password_Must_Contain_At_Least_One_Upper_Case'));
		$this->Password_Must_Contain_At_Least_One_Numeric->setDbValue($rs->fields('Password_Must_Contain_At_Least_One_Numeric'));
		$this->Password_Must_Contain_At_Least_One_Symbol->setDbValue($rs->fields('Password_Must_Contain_At_Least_One_Symbol'));
		$this->Password_Must_Be_Difference_Between_Old_And_New->setDbValue($rs->fields('Password_Must_Be_Difference_Between_Old_And_New'));
		$this->Reset_Password_Field_Options->setDbValue($rs->fields('Reset_Password_Field_Options'));
		$this->Export_Record_Options->setDbValue($rs->fields('Export_Record_Options'));
		$this->Show_Record_Number_On_Exported_List_Page->setDbValue($rs->fields('Show_Record_Number_On_Exported_List_Page'));
		$this->Use_Table_Setting_For_Export_Field_Caption->setDbValue($rs->fields('Use_Table_Setting_For_Export_Field_Caption'));
		$this->Use_Table_Setting_For_Export_Original_Value->setDbValue($rs->fields('Use_Table_Setting_For_Export_Original_Value'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Option_ID->DbValue = $row['Option_ID'];
		$this->Option_Default->DbValue = $row['Option_Default'];
		$this->Default_Theme->DbValue = $row['Default_Theme'];
		$this->Font_Name->DbValue = $row['Font_Name'];
		$this->Font_Size->DbValue = $row['Font_Size'];
		$this->Show_Border_Layout->DbValue = $row['Show_Border_Layout'];
		$this->Show_Shadow_Layout->DbValue = $row['Show_Shadow_Layout'];
		$this->Menu_Horizontal->DbValue = $row['Menu_Horizontal'];
		$this->Vertical_Menu_Width->DbValue = $row['Vertical_Menu_Width'];
		$this->Show_Announcement->DbValue = $row['Show_Announcement'];
		$this->Demo_Mode->DbValue = $row['Demo_Mode'];
		$this->Show_Page_Processing_Time->DbValue = $row['Show_Page_Processing_Time'];
		$this->Allow_User_Preferences->DbValue = $row['Allow_User_Preferences'];
		$this->SMTP_Server->DbValue = $row['SMTP_Server'];
		$this->SMTP_Server_Port->DbValue = $row['SMTP_Server_Port'];
		$this->SMTP_Server_Username->DbValue = $row['SMTP_Server_Username'];
		$this->SMTP_Server_Password->DbValue = $row['SMTP_Server_Password'];
		$this->Sender_Email->DbValue = $row['Sender_Email'];
		$this->Recipient_Email->DbValue = $row['Recipient_Email'];
		$this->Use_Default_Locale->DbValue = $row['Use_Default_Locale'];
		$this->Default_Language->DbValue = $row['Default_Language'];
		$this->Default_Timezone->DbValue = $row['Default_Timezone'];
		$this->Default_Thousands_Separator->DbValue = $row['Default_Thousands_Separator'];
		$this->Default_Decimal_Point->DbValue = $row['Default_Decimal_Point'];
		$this->Default_Currency_Symbol->DbValue = $row['Default_Currency_Symbol'];
		$this->Default_Money_Thousands_Separator->DbValue = $row['Default_Money_Thousands_Separator'];
		$this->Default_Money_Decimal_Point->DbValue = $row['Default_Money_Decimal_Point'];
		$this->Maintenance_Mode->DbValue = $row['Maintenance_Mode'];
		$this->Maintenance_Finish_DateTime->DbValue = $row['Maintenance_Finish_DateTime'];
		$this->Auto_Normal_After_Maintenance->DbValue = $row['Auto_Normal_After_Maintenance'];
		$this->Allow_User_To_Register->DbValue = $row['Allow_User_To_Register'];
		$this->Suspend_New_User_Account->DbValue = $row['Suspend_New_User_Account'];
		$this->User_Need_Activation_After_Registered->DbValue = $row['User_Need_Activation_After_Registered'];
		$this->Show_Captcha_On_Registration_Page->DbValue = $row['Show_Captcha_On_Registration_Page'];
		$this->Show_Terms_And_Conditions_On_Registration_Page->DbValue = $row['Show_Terms_And_Conditions_On_Registration_Page'];
		$this->User_Auto_Login_After_Activation_Or_Registration->DbValue = $row['User_Auto_Login_After_Activation_Or_Registration'];
		$this->Show_Captcha_On_Login_Page->DbValue = $row['Show_Captcha_On_Login_Page'];
		$this->Show_Captcha_On_Forgot_Password_Page->DbValue = $row['Show_Captcha_On_Forgot_Password_Page'];
		$this->Show_Captcha_On_Change_Password_Page->DbValue = $row['Show_Captcha_On_Change_Password_Page'];
		$this->User_Auto_Logout_After_Idle_In_Minutes->DbValue = $row['User_Auto_Logout_After_Idle_In_Minutes'];
		$this->User_Login_Maximum_Retry->DbValue = $row['User_Login_Maximum_Retry'];
		$this->User_Login_Retry_Lockout->DbValue = $row['User_Login_Retry_Lockout'];
		$this->Redirect_To_Last_Visited_Page_After_Login->DbValue = $row['Redirect_To_Last_Visited_Page_After_Login'];
		$this->Enable_Password_Expiry->DbValue = $row['Enable_Password_Expiry'];
		$this->Password_Expiry_In_Days->DbValue = $row['Password_Expiry_In_Days'];
		$this->Show_Entire_Header->DbValue = $row['Show_Entire_Header'];
		$this->Logo_Width->DbValue = $row['Logo_Width'];
		$this->Show_Site_Title_In_Header->DbValue = $row['Show_Site_Title_In_Header'];
		$this->Show_Current_User_In_Header->DbValue = $row['Show_Current_User_In_Header'];
		$this->Text_Align_In_Header->DbValue = $row['Text_Align_In_Header'];
		$this->Site_Title_Text_Style->DbValue = $row['Site_Title_Text_Style'];
		$this->Language_Selector_Visibility->DbValue = $row['Language_Selector_Visibility'];
		$this->Language_Selector_Align->DbValue = $row['Language_Selector_Align'];
		$this->Show_Entire_Footer->DbValue = $row['Show_Entire_Footer'];
		$this->Show_Text_In_Footer->DbValue = $row['Show_Text_In_Footer'];
		$this->Show_Back_To_Top_On_Footer->DbValue = $row['Show_Back_To_Top_On_Footer'];
		$this->Show_Terms_And_Conditions_On_Footer->DbValue = $row['Show_Terms_And_Conditions_On_Footer'];
		$this->Show_About_Us_On_Footer->DbValue = $row['Show_About_Us_On_Footer'];
		$this->Pagination_Position->DbValue = $row['Pagination_Position'];
		$this->Pagination_Style->DbValue = $row['Pagination_Style'];
		$this->Selectable_Records_Per_Page->DbValue = $row['Selectable_Records_Per_Page'];
		$this->Selectable_Groups_Per_Page->DbValue = $row['Selectable_Groups_Per_Page'];
		$this->Default_Record_Per_Page->DbValue = $row['Default_Record_Per_Page'];
		$this->Default_Group_Per_Page->DbValue = $row['Default_Group_Per_Page'];
		$this->Maximum_Selected_Records->DbValue = $row['Maximum_Selected_Records'];
		$this->Maximum_Selected_Groups->DbValue = $row['Maximum_Selected_Groups'];
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->DbValue = $row['Show_PageNum_If_Record_Not_Over_Pagesize'];
		$this->Table_Width_Style->DbValue = $row['Table_Width_Style'];
		$this->Scroll_Table_Width->DbValue = $row['Scroll_Table_Width'];
		$this->Scroll_Table_Height->DbValue = $row['Scroll_Table_Height'];
		$this->Search_Panel_Collapsed->DbValue = $row['Search_Panel_Collapsed'];
		$this->Filter_Panel_Collapsed->DbValue = $row['Filter_Panel_Collapsed'];
		$this->Show_Record_Number_On_List_Page->DbValue = $row['Show_Record_Number_On_List_Page'];
		$this->Show_Empty_Table_On_List_Page->DbValue = $row['Show_Empty_Table_On_List_Page'];
		$this->Rows_Vertical_Align_Top->DbValue = $row['Rows_Vertical_Align_Top'];
		$this->Action_Button_Alignment->DbValue = $row['Action_Button_Alignment'];
		$this->Show_Add_Success_Message->DbValue = $row['Show_Add_Success_Message'];
		$this->Show_Edit_Success_Message->DbValue = $row['Show_Edit_Success_Message'];
		$this->jQuery_Auto_Hide_Success_Message->DbValue = $row['jQuery_Auto_Hide_Success_Message'];
		$this->Use_Javascript_Message->DbValue = $row['Use_Javascript_Message'];
		$this->Login_Window_Type->DbValue = $row['Login_Window_Type'];
		$this->Forgot_Password_Window_Type->DbValue = $row['Forgot_Password_Window_Type'];
		$this->Change_Password_Window_Type->DbValue = $row['Change_Password_Window_Type'];
		$this->Registration_Window_Type->DbValue = $row['Registration_Window_Type'];
		$this->Show_Record_Number_On_Detail_Preview->DbValue = $row['Show_Record_Number_On_Detail_Preview'];
		$this->Show_Empty_Table_In_Detail_Preview->DbValue = $row['Show_Empty_Table_In_Detail_Preview'];
		$this->Detail_Preview_Table_Width->DbValue = $row['Detail_Preview_Table_Width'];
		$this->Password_Minimum_Length->DbValue = $row['Password_Minimum_Length'];
		$this->Password_Maximum_Length->DbValue = $row['Password_Maximum_Length'];
		$this->Password_Must_Contain_At_Least_One_Lower_Case->DbValue = $row['Password_Must_Contain_At_Least_One_Lower_Case'];
		$this->Password_Must_Comply_With_Minumum_Length->DbValue = $row['Password_Must_Comply_With_Minumum_Length'];
		$this->Password_Must_Comply_With_Maximum_Length->DbValue = $row['Password_Must_Comply_With_Maximum_Length'];
		$this->Password_Must_Contain_At_Least_One_Upper_Case->DbValue = $row['Password_Must_Contain_At_Least_One_Upper_Case'];
		$this->Password_Must_Contain_At_Least_One_Numeric->DbValue = $row['Password_Must_Contain_At_Least_One_Numeric'];
		$this->Password_Must_Contain_At_Least_One_Symbol->DbValue = $row['Password_Must_Contain_At_Least_One_Symbol'];
		$this->Password_Must_Be_Difference_Between_Old_And_New->DbValue = $row['Password_Must_Be_Difference_Between_Old_And_New'];
		$this->Reset_Password_Field_Options->DbValue = $row['Reset_Password_Field_Options'];
		$this->Export_Record_Options->DbValue = $row['Export_Record_Options'];
		$this->Show_Record_Number_On_Exported_List_Page->DbValue = $row['Show_Record_Number_On_Exported_List_Page'];
		$this->Use_Table_Setting_For_Export_Field_Caption->DbValue = $row['Use_Table_Setting_For_Export_Field_Caption'];
		$this->Use_Table_Setting_For_Export_Original_Value->DbValue = $row['Use_Table_Setting_For_Export_Original_Value'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Option_ID
		// Option_Default
		// Default_Theme
		// Font_Name
		// Font_Size
		// Show_Border_Layout
		// Show_Shadow_Layout
		// Menu_Horizontal
		// Vertical_Menu_Width
		// Show_Announcement
		// Demo_Mode
		// Show_Page_Processing_Time
		// Allow_User_Preferences
		// SMTP_Server
		// SMTP_Server_Port
		// SMTP_Server_Username
		// SMTP_Server_Password
		// Sender_Email
		// Recipient_Email
		// Use_Default_Locale
		// Default_Language
		// Default_Timezone
		// Default_Thousands_Separator
		// Default_Decimal_Point
		// Default_Currency_Symbol
		// Default_Money_Thousands_Separator
		// Default_Money_Decimal_Point
		// Maintenance_Mode
		// Maintenance_Finish_DateTime
		// Auto_Normal_After_Maintenance
		// Allow_User_To_Register
		// Suspend_New_User_Account
		// User_Need_Activation_After_Registered
		// Show_Captcha_On_Registration_Page
		// Show_Terms_And_Conditions_On_Registration_Page
		// User_Auto_Login_After_Activation_Or_Registration
		// Show_Captcha_On_Login_Page
		// Show_Captcha_On_Forgot_Password_Page
		// Show_Captcha_On_Change_Password_Page
		// User_Auto_Logout_After_Idle_In_Minutes
		// User_Login_Maximum_Retry
		// User_Login_Retry_Lockout
		// Redirect_To_Last_Visited_Page_After_Login
		// Enable_Password_Expiry
		// Password_Expiry_In_Days
		// Show_Entire_Header
		// Logo_Width
		// Show_Site_Title_In_Header
		// Show_Current_User_In_Header
		// Text_Align_In_Header
		// Site_Title_Text_Style
		// Language_Selector_Visibility
		// Language_Selector_Align
		// Show_Entire_Footer
		// Show_Text_In_Footer
		// Show_Back_To_Top_On_Footer
		// Show_Terms_And_Conditions_On_Footer
		// Show_About_Us_On_Footer
		// Pagination_Position
		// Pagination_Style
		// Selectable_Records_Per_Page
		// Selectable_Groups_Per_Page
		// Default_Record_Per_Page
		// Default_Group_Per_Page
		// Maximum_Selected_Records
		// Maximum_Selected_Groups
		// Show_PageNum_If_Record_Not_Over_Pagesize
		// Table_Width_Style
		// Scroll_Table_Width
		// Scroll_Table_Height
		// Search_Panel_Collapsed
		// Filter_Panel_Collapsed
		// Show_Record_Number_On_List_Page
		// Show_Empty_Table_On_List_Page
		// Rows_Vertical_Align_Top
		// Action_Button_Alignment
		// Show_Add_Success_Message
		// Show_Edit_Success_Message
		// jQuery_Auto_Hide_Success_Message
		// Use_Javascript_Message
		// Login_Window_Type
		// Forgot_Password_Window_Type
		// Change_Password_Window_Type
		// Registration_Window_Type
		// Show_Record_Number_On_Detail_Preview
		// Show_Empty_Table_In_Detail_Preview
		// Detail_Preview_Table_Width
		// Password_Minimum_Length
		// Password_Maximum_Length
		// Password_Must_Contain_At_Least_One_Lower_Case
		// Password_Must_Comply_With_Minumum_Length
		// Password_Must_Comply_With_Maximum_Length
		// Password_Must_Contain_At_Least_One_Upper_Case
		// Password_Must_Contain_At_Least_One_Numeric
		// Password_Must_Contain_At_Least_One_Symbol
		// Password_Must_Be_Difference_Between_Old_And_New
		// Reset_Password_Field_Options
		// Export_Record_Options
		// Show_Record_Number_On_Exported_List_Page
		// Use_Table_Setting_For_Export_Field_Caption
		// Use_Table_Setting_For_Export_Original_Value

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Option_ID
		$this->Option_ID->ViewValue = $this->Option_ID->CurrentValue;
		$this->Option_ID->ViewCustomAttributes = "";

		// Option_Default
		if (ew_ConvertToBool($this->Option_Default->CurrentValue)) {
			$this->Option_Default->ViewValue = $this->Option_Default->FldTagCaption(1) <> "" ? $this->Option_Default->FldTagCaption(1) : "Yes";
		} else {
			$this->Option_Default->ViewValue = $this->Option_Default->FldTagCaption(2) <> "" ? $this->Option_Default->FldTagCaption(2) : "No";
		}
		$this->Option_Default->ViewCustomAttributes = "";

		// Default_Theme
		if (strval($this->Default_Theme->CurrentValue) <> "") {
			$sFilterWrk = "`Theme_ID`" . ew_SearchString("=", $this->Default_Theme->CurrentValue, EW_DATATYPE_STRING, "");
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
		$this->Lookup_Selecting($this->Default_Theme, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Theme_ID`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Default_Theme->ViewValue = $this->Default_Theme->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Default_Theme->ViewValue = $this->Default_Theme->CurrentValue;
			}
		} else {
			$this->Default_Theme->ViewValue = NULL;
		}
		$this->Default_Theme->ViewCustomAttributes = "";

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

		// Show_Border_Layout
		if (ew_ConvertToBool($this->Show_Border_Layout->CurrentValue)) {
			$this->Show_Border_Layout->ViewValue = $this->Show_Border_Layout->FldTagCaption(2) <> "" ? $this->Show_Border_Layout->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Border_Layout->ViewValue = $this->Show_Border_Layout->FldTagCaption(1) <> "" ? $this->Show_Border_Layout->FldTagCaption(1) : "No";
		}
		$this->Show_Border_Layout->ViewCustomAttributes = "";

		// Show_Shadow_Layout
		if (ew_ConvertToBool($this->Show_Shadow_Layout->CurrentValue)) {
			$this->Show_Shadow_Layout->ViewValue = $this->Show_Shadow_Layout->FldTagCaption(2) <> "" ? $this->Show_Shadow_Layout->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Shadow_Layout->ViewValue = $this->Show_Shadow_Layout->FldTagCaption(1) <> "" ? $this->Show_Shadow_Layout->FldTagCaption(1) : "No";
		}
		$this->Show_Shadow_Layout->ViewCustomAttributes = "";

		// Menu_Horizontal
		if (ew_ConvertToBool($this->Menu_Horizontal->CurrentValue)) {
			$this->Menu_Horizontal->ViewValue = $this->Menu_Horizontal->FldTagCaption(1) <> "" ? $this->Menu_Horizontal->FldTagCaption(1) : "Yes";
		} else {
			$this->Menu_Horizontal->ViewValue = $this->Menu_Horizontal->FldTagCaption(2) <> "" ? $this->Menu_Horizontal->FldTagCaption(2) : "No";
		}
		$this->Menu_Horizontal->ViewCustomAttributes = "";

		// Vertical_Menu_Width
		$this->Vertical_Menu_Width->ViewValue = $this->Vertical_Menu_Width->CurrentValue;
		$this->Vertical_Menu_Width->ViewCustomAttributes = "";

		// Show_Announcement
		if (ew_ConvertToBool($this->Show_Announcement->CurrentValue)) {
			$this->Show_Announcement->ViewValue = $this->Show_Announcement->FldTagCaption(1) <> "" ? $this->Show_Announcement->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Announcement->ViewValue = $this->Show_Announcement->FldTagCaption(2) <> "" ? $this->Show_Announcement->FldTagCaption(2) : "No";
		}
		$this->Show_Announcement->ViewCustomAttributes = "";

		// Demo_Mode
		if (ew_ConvertToBool($this->Demo_Mode->CurrentValue)) {
			$this->Demo_Mode->ViewValue = $this->Demo_Mode->FldTagCaption(2) <> "" ? $this->Demo_Mode->FldTagCaption(2) : "Yes";
		} else {
			$this->Demo_Mode->ViewValue = $this->Demo_Mode->FldTagCaption(1) <> "" ? $this->Demo_Mode->FldTagCaption(1) : "No";
		}
		$this->Demo_Mode->ViewCustomAttributes = "";

		// Show_Page_Processing_Time
		if (ew_ConvertToBool($this->Show_Page_Processing_Time->CurrentValue)) {
			$this->Show_Page_Processing_Time->ViewValue = $this->Show_Page_Processing_Time->FldTagCaption(1) <> "" ? $this->Show_Page_Processing_Time->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Page_Processing_Time->ViewValue = $this->Show_Page_Processing_Time->FldTagCaption(2) <> "" ? $this->Show_Page_Processing_Time->FldTagCaption(2) : "No";
		}
		$this->Show_Page_Processing_Time->ViewCustomAttributes = "";

		// Allow_User_Preferences
		if (ew_ConvertToBool($this->Allow_User_Preferences->CurrentValue)) {
			$this->Allow_User_Preferences->ViewValue = $this->Allow_User_Preferences->FldTagCaption(2) <> "" ? $this->Allow_User_Preferences->FldTagCaption(2) : "Yes";
		} else {
			$this->Allow_User_Preferences->ViewValue = $this->Allow_User_Preferences->FldTagCaption(1) <> "" ? $this->Allow_User_Preferences->FldTagCaption(1) : "No";
		}
		$this->Allow_User_Preferences->ViewCustomAttributes = "";

		// SMTP_Server
		$this->SMTP_Server->ViewValue = $this->SMTP_Server->CurrentValue;
		$this->SMTP_Server->ViewCustomAttributes = "";

		// SMTP_Server_Port
		$this->SMTP_Server_Port->ViewValue = $this->SMTP_Server_Port->CurrentValue;
		$this->SMTP_Server_Port->ViewCustomAttributes = "";

		// SMTP_Server_Username
		$this->SMTP_Server_Username->ViewValue = $this->SMTP_Server_Username->CurrentValue;
		$this->SMTP_Server_Username->ViewCustomAttributes = "";

		// SMTP_Server_Password
		$this->SMTP_Server_Password->ViewValue = $this->SMTP_Server_Password->CurrentValue;
		$this->SMTP_Server_Password->ViewCustomAttributes = "";

		// Sender_Email
		$this->Sender_Email->ViewValue = $this->Sender_Email->CurrentValue;
		$this->Sender_Email->ViewCustomAttributes = "";

		// Recipient_Email
		$this->Recipient_Email->ViewValue = $this->Recipient_Email->CurrentValue;
		$this->Recipient_Email->ViewCustomAttributes = "";

		// Use_Default_Locale
		if (ew_ConvertToBool($this->Use_Default_Locale->CurrentValue)) {
			$this->Use_Default_Locale->ViewValue = $this->Use_Default_Locale->FldTagCaption(1) <> "" ? $this->Use_Default_Locale->FldTagCaption(1) : "Yes";
		} else {
			$this->Use_Default_Locale->ViewValue = $this->Use_Default_Locale->FldTagCaption(2) <> "" ? $this->Use_Default_Locale->FldTagCaption(2) : "No";
		}
		$this->Use_Default_Locale->ViewCustomAttributes = "";

		// Default_Language
		if (strval($this->Default_Language->CurrentValue) <> "") {
			$sFilterWrk = "`Language_Code`" . ew_SearchString("=", $this->Default_Language->CurrentValue, EW_DATATYPE_STRING, "");
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
		$this->Lookup_Selecting($this->Default_Language, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Default_Language->ViewValue = $this->Default_Language->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Default_Language->ViewValue = $this->Default_Language->CurrentValue;
			}
		} else {
			$this->Default_Language->ViewValue = NULL;
		}
		$this->Default_Language->ViewCustomAttributes = "";

		// Default_Timezone
		if (strval($this->Default_Timezone->CurrentValue) <> "") {
			$sFilterWrk = "`Timezone`" . ew_SearchString("=", $this->Default_Timezone->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Timezone`, `Timezone` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `timezone`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Timezone`, `Timezone` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `timezone`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Default_Timezone, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Default_Timezone->ViewValue = $this->Default_Timezone->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Default_Timezone->ViewValue = $this->Default_Timezone->CurrentValue;
			}
		} else {
			$this->Default_Timezone->ViewValue = NULL;
		}
		$this->Default_Timezone->ViewCustomAttributes = "";

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

		// Maintenance_Mode
		if (ew_ConvertToBool($this->Maintenance_Mode->CurrentValue)) {
			$this->Maintenance_Mode->ViewValue = $this->Maintenance_Mode->FldTagCaption(2) <> "" ? $this->Maintenance_Mode->FldTagCaption(2) : "Yes";
		} else {
			$this->Maintenance_Mode->ViewValue = $this->Maintenance_Mode->FldTagCaption(1) <> "" ? $this->Maintenance_Mode->FldTagCaption(1) : "No";
		}
		$this->Maintenance_Mode->ViewCustomAttributes = "";

		// Maintenance_Finish_DateTime
		$this->Maintenance_Finish_DateTime->ViewValue = $this->Maintenance_Finish_DateTime->CurrentValue;
		$this->Maintenance_Finish_DateTime->ViewValue = ew_FormatDateTime($this->Maintenance_Finish_DateTime->ViewValue, 9);
		$this->Maintenance_Finish_DateTime->ViewCustomAttributes = "";

		// Auto_Normal_After_Maintenance
		if (ew_ConvertToBool($this->Auto_Normal_After_Maintenance->CurrentValue)) {
			$this->Auto_Normal_After_Maintenance->ViewValue = $this->Auto_Normal_After_Maintenance->FldTagCaption(1) <> "" ? $this->Auto_Normal_After_Maintenance->FldTagCaption(1) : "Yes";
		} else {
			$this->Auto_Normal_After_Maintenance->ViewValue = $this->Auto_Normal_After_Maintenance->FldTagCaption(2) <> "" ? $this->Auto_Normal_After_Maintenance->FldTagCaption(2) : "No";
		}
		$this->Auto_Normal_After_Maintenance->ViewCustomAttributes = "";

		// Allow_User_To_Register
		if (ew_ConvertToBool($this->Allow_User_To_Register->CurrentValue)) {
			$this->Allow_User_To_Register->ViewValue = $this->Allow_User_To_Register->FldTagCaption(1) <> "" ? $this->Allow_User_To_Register->FldTagCaption(1) : "Yes";
		} else {
			$this->Allow_User_To_Register->ViewValue = $this->Allow_User_To_Register->FldTagCaption(2) <> "" ? $this->Allow_User_To_Register->FldTagCaption(2) : "No";
		}
		$this->Allow_User_To_Register->ViewCustomAttributes = "";

		// Suspend_New_User_Account
		if (ew_ConvertToBool($this->Suspend_New_User_Account->CurrentValue)) {
			$this->Suspend_New_User_Account->ViewValue = $this->Suspend_New_User_Account->FldTagCaption(2) <> "" ? $this->Suspend_New_User_Account->FldTagCaption(2) : "Yes";
		} else {
			$this->Suspend_New_User_Account->ViewValue = $this->Suspend_New_User_Account->FldTagCaption(1) <> "" ? $this->Suspend_New_User_Account->FldTagCaption(1) : "No";
		}
		$this->Suspend_New_User_Account->ViewCustomAttributes = "";

		// User_Need_Activation_After_Registered
		if (ew_ConvertToBool($this->User_Need_Activation_After_Registered->CurrentValue)) {
			$this->User_Need_Activation_After_Registered->ViewValue = $this->User_Need_Activation_After_Registered->FldTagCaption(1) <> "" ? $this->User_Need_Activation_After_Registered->FldTagCaption(1) : "Yes";
		} else {
			$this->User_Need_Activation_After_Registered->ViewValue = $this->User_Need_Activation_After_Registered->FldTagCaption(2) <> "" ? $this->User_Need_Activation_After_Registered->FldTagCaption(2) : "No";
		}
		$this->User_Need_Activation_After_Registered->ViewCustomAttributes = "";

		// Show_Captcha_On_Registration_Page
		if (ew_ConvertToBool($this->Show_Captcha_On_Registration_Page->CurrentValue)) {
			$this->Show_Captcha_On_Registration_Page->ViewValue = $this->Show_Captcha_On_Registration_Page->FldTagCaption(1) <> "" ? $this->Show_Captcha_On_Registration_Page->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Captcha_On_Registration_Page->ViewValue = $this->Show_Captcha_On_Registration_Page->FldTagCaption(2) <> "" ? $this->Show_Captcha_On_Registration_Page->FldTagCaption(2) : "No";
		}
		$this->Show_Captcha_On_Registration_Page->ViewCustomAttributes = "";

		// Show_Terms_And_Conditions_On_Registration_Page
		if (ew_ConvertToBool($this->Show_Terms_And_Conditions_On_Registration_Page->CurrentValue)) {
			$this->Show_Terms_And_Conditions_On_Registration_Page->ViewValue = $this->Show_Terms_And_Conditions_On_Registration_Page->FldTagCaption(1) <> "" ? $this->Show_Terms_And_Conditions_On_Registration_Page->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Terms_And_Conditions_On_Registration_Page->ViewValue = $this->Show_Terms_And_Conditions_On_Registration_Page->FldTagCaption(2) <> "" ? $this->Show_Terms_And_Conditions_On_Registration_Page->FldTagCaption(2) : "No";
		}
		$this->Show_Terms_And_Conditions_On_Registration_Page->ViewCustomAttributes = "";

		// User_Auto_Login_After_Activation_Or_Registration
		if (ew_ConvertToBool($this->User_Auto_Login_After_Activation_Or_Registration->CurrentValue)) {
			$this->User_Auto_Login_After_Activation_Or_Registration->ViewValue = $this->User_Auto_Login_After_Activation_Or_Registration->FldTagCaption(1) <> "" ? $this->User_Auto_Login_After_Activation_Or_Registration->FldTagCaption(1) : "Yes";
		} else {
			$this->User_Auto_Login_After_Activation_Or_Registration->ViewValue = $this->User_Auto_Login_After_Activation_Or_Registration->FldTagCaption(2) <> "" ? $this->User_Auto_Login_After_Activation_Or_Registration->FldTagCaption(2) : "No";
		}
		$this->User_Auto_Login_After_Activation_Or_Registration->ViewCustomAttributes = "";

		// Show_Captcha_On_Login_Page
		if (ew_ConvertToBool($this->Show_Captcha_On_Login_Page->CurrentValue)) {
			$this->Show_Captcha_On_Login_Page->ViewValue = $this->Show_Captcha_On_Login_Page->FldTagCaption(2) <> "" ? $this->Show_Captcha_On_Login_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Captcha_On_Login_Page->ViewValue = $this->Show_Captcha_On_Login_Page->FldTagCaption(1) <> "" ? $this->Show_Captcha_On_Login_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Captcha_On_Login_Page->ViewCustomAttributes = "";

		// Show_Captcha_On_Forgot_Password_Page
		if (ew_ConvertToBool($this->Show_Captcha_On_Forgot_Password_Page->CurrentValue)) {
			$this->Show_Captcha_On_Forgot_Password_Page->ViewValue = $this->Show_Captcha_On_Forgot_Password_Page->FldTagCaption(2) <> "" ? $this->Show_Captcha_On_Forgot_Password_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Captcha_On_Forgot_Password_Page->ViewValue = $this->Show_Captcha_On_Forgot_Password_Page->FldTagCaption(1) <> "" ? $this->Show_Captcha_On_Forgot_Password_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Captcha_On_Forgot_Password_Page->ViewCustomAttributes = "";

		// Show_Captcha_On_Change_Password_Page
		if (ew_ConvertToBool($this->Show_Captcha_On_Change_Password_Page->CurrentValue)) {
			$this->Show_Captcha_On_Change_Password_Page->ViewValue = $this->Show_Captcha_On_Change_Password_Page->FldTagCaption(2) <> "" ? $this->Show_Captcha_On_Change_Password_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Captcha_On_Change_Password_Page->ViewValue = $this->Show_Captcha_On_Change_Password_Page->FldTagCaption(1) <> "" ? $this->Show_Captcha_On_Change_Password_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Captcha_On_Change_Password_Page->ViewCustomAttributes = "";

		// User_Auto_Logout_After_Idle_In_Minutes
		$this->User_Auto_Logout_After_Idle_In_Minutes->ViewValue = $this->User_Auto_Logout_After_Idle_In_Minutes->CurrentValue;
		$this->User_Auto_Logout_After_Idle_In_Minutes->ViewCustomAttributes = "";

		// User_Login_Maximum_Retry
		$this->User_Login_Maximum_Retry->ViewValue = $this->User_Login_Maximum_Retry->CurrentValue;
		$this->User_Login_Maximum_Retry->ViewCustomAttributes = "";

		// User_Login_Retry_Lockout
		$this->User_Login_Retry_Lockout->ViewValue = $this->User_Login_Retry_Lockout->CurrentValue;
		$this->User_Login_Retry_Lockout->ViewCustomAttributes = "";

		// Redirect_To_Last_Visited_Page_After_Login
		if (ew_ConvertToBool($this->Redirect_To_Last_Visited_Page_After_Login->CurrentValue)) {
			$this->Redirect_To_Last_Visited_Page_After_Login->ViewValue = $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(1) <> "" ? $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(1) : "Yes";
		} else {
			$this->Redirect_To_Last_Visited_Page_After_Login->ViewValue = $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(2) <> "" ? $this->Redirect_To_Last_Visited_Page_After_Login->FldTagCaption(2) : "No";
		}
		$this->Redirect_To_Last_Visited_Page_After_Login->ViewCustomAttributes = "";

		// Enable_Password_Expiry
		if (ew_ConvertToBool($this->Enable_Password_Expiry->CurrentValue)) {
			$this->Enable_Password_Expiry->ViewValue = $this->Enable_Password_Expiry->FldTagCaption(1) <> "" ? $this->Enable_Password_Expiry->FldTagCaption(1) : "Yes";
		} else {
			$this->Enable_Password_Expiry->ViewValue = $this->Enable_Password_Expiry->FldTagCaption(2) <> "" ? $this->Enable_Password_Expiry->FldTagCaption(2) : "No";
		}
		$this->Enable_Password_Expiry->ViewCustomAttributes = "";

		// Password_Expiry_In_Days
		$this->Password_Expiry_In_Days->ViewValue = $this->Password_Expiry_In_Days->CurrentValue;
		$this->Password_Expiry_In_Days->ViewCustomAttributes = "";

		// Show_Entire_Header
		if (ew_ConvertToBool($this->Show_Entire_Header->CurrentValue)) {
			$this->Show_Entire_Header->ViewValue = $this->Show_Entire_Header->FldTagCaption(1) <> "" ? $this->Show_Entire_Header->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Entire_Header->ViewValue = $this->Show_Entire_Header->FldTagCaption(2) <> "" ? $this->Show_Entire_Header->FldTagCaption(2) : "No";
		}
		$this->Show_Entire_Header->ViewCustomAttributes = "";

		// Logo_Width
		$this->Logo_Width->ViewValue = $this->Logo_Width->CurrentValue;
		$this->Logo_Width->ViewCustomAttributes = "";

		// Show_Site_Title_In_Header
		if (ew_ConvertToBool($this->Show_Site_Title_In_Header->CurrentValue)) {
			$this->Show_Site_Title_In_Header->ViewValue = $this->Show_Site_Title_In_Header->FldTagCaption(1) <> "" ? $this->Show_Site_Title_In_Header->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Site_Title_In_Header->ViewValue = $this->Show_Site_Title_In_Header->FldTagCaption(2) <> "" ? $this->Show_Site_Title_In_Header->FldTagCaption(2) : "No";
		}
		$this->Show_Site_Title_In_Header->ViewCustomAttributes = "";

		// Show_Current_User_In_Header
		if (ew_ConvertToBool($this->Show_Current_User_In_Header->CurrentValue)) {
			$this->Show_Current_User_In_Header->ViewValue = $this->Show_Current_User_In_Header->FldTagCaption(1) <> "" ? $this->Show_Current_User_In_Header->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Current_User_In_Header->ViewValue = $this->Show_Current_User_In_Header->FldTagCaption(2) <> "" ? $this->Show_Current_User_In_Header->FldTagCaption(2) : "No";
		}
		$this->Show_Current_User_In_Header->ViewCustomAttributes = "";

		// Text_Align_In_Header
		if (strval($this->Text_Align_In_Header->CurrentValue) <> "") {
			$this->Text_Align_In_Header->ViewValue = $this->Text_Align_In_Header->OptionCaption($this->Text_Align_In_Header->CurrentValue);
		} else {
			$this->Text_Align_In_Header->ViewValue = NULL;
		}
		$this->Text_Align_In_Header->ViewCustomAttributes = "";

		// Site_Title_Text_Style
		if (strval($this->Site_Title_Text_Style->CurrentValue) <> "") {
			$this->Site_Title_Text_Style->ViewValue = $this->Site_Title_Text_Style->OptionCaption($this->Site_Title_Text_Style->CurrentValue);
		} else {
			$this->Site_Title_Text_Style->ViewValue = NULL;
		}
		$this->Site_Title_Text_Style->ViewCustomAttributes = "";

		// Language_Selector_Visibility
		if (strval($this->Language_Selector_Visibility->CurrentValue) <> "") {
			$this->Language_Selector_Visibility->ViewValue = $this->Language_Selector_Visibility->OptionCaption($this->Language_Selector_Visibility->CurrentValue);
		} else {
			$this->Language_Selector_Visibility->ViewValue = NULL;
		}
		$this->Language_Selector_Visibility->ViewCustomAttributes = "";

		// Language_Selector_Align
		if (strval($this->Language_Selector_Align->CurrentValue) <> "") {
			$this->Language_Selector_Align->ViewValue = $this->Language_Selector_Align->OptionCaption($this->Language_Selector_Align->CurrentValue);
		} else {
			$this->Language_Selector_Align->ViewValue = NULL;
		}
		$this->Language_Selector_Align->ViewCustomAttributes = "";

		// Show_Entire_Footer
		if (ew_ConvertToBool($this->Show_Entire_Footer->CurrentValue)) {
			$this->Show_Entire_Footer->ViewValue = $this->Show_Entire_Footer->FldTagCaption(1) <> "" ? $this->Show_Entire_Footer->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Entire_Footer->ViewValue = $this->Show_Entire_Footer->FldTagCaption(2) <> "" ? $this->Show_Entire_Footer->FldTagCaption(2) : "No";
		}
		$this->Show_Entire_Footer->ViewCustomAttributes = "";

		// Show_Text_In_Footer
		if (ew_ConvertToBool($this->Show_Text_In_Footer->CurrentValue)) {
			$this->Show_Text_In_Footer->ViewValue = $this->Show_Text_In_Footer->FldTagCaption(1) <> "" ? $this->Show_Text_In_Footer->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Text_In_Footer->ViewValue = $this->Show_Text_In_Footer->FldTagCaption(2) <> "" ? $this->Show_Text_In_Footer->FldTagCaption(2) : "No";
		}
		$this->Show_Text_In_Footer->ViewCustomAttributes = "";

		// Show_Back_To_Top_On_Footer
		if (ew_ConvertToBool($this->Show_Back_To_Top_On_Footer->CurrentValue)) {
			$this->Show_Back_To_Top_On_Footer->ViewValue = $this->Show_Back_To_Top_On_Footer->FldTagCaption(2) <> "" ? $this->Show_Back_To_Top_On_Footer->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Back_To_Top_On_Footer->ViewValue = $this->Show_Back_To_Top_On_Footer->FldTagCaption(1) <> "" ? $this->Show_Back_To_Top_On_Footer->FldTagCaption(1) : "No";
		}
		$this->Show_Back_To_Top_On_Footer->ViewCustomAttributes = "";

		// Show_Terms_And_Conditions_On_Footer
		if (ew_ConvertToBool($this->Show_Terms_And_Conditions_On_Footer->CurrentValue)) {
			$this->Show_Terms_And_Conditions_On_Footer->ViewValue = $this->Show_Terms_And_Conditions_On_Footer->FldTagCaption(1) <> "" ? $this->Show_Terms_And_Conditions_On_Footer->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_Terms_And_Conditions_On_Footer->ViewValue = $this->Show_Terms_And_Conditions_On_Footer->FldTagCaption(2) <> "" ? $this->Show_Terms_And_Conditions_On_Footer->FldTagCaption(2) : "No";
		}
		$this->Show_Terms_And_Conditions_On_Footer->ViewCustomAttributes = "";

		// Show_About_Us_On_Footer
		if (ew_ConvertToBool($this->Show_About_Us_On_Footer->CurrentValue)) {
			$this->Show_About_Us_On_Footer->ViewValue = $this->Show_About_Us_On_Footer->FldTagCaption(2) <> "" ? $this->Show_About_Us_On_Footer->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_About_Us_On_Footer->ViewValue = $this->Show_About_Us_On_Footer->FldTagCaption(1) <> "" ? $this->Show_About_Us_On_Footer->FldTagCaption(1) : "No";
		}
		$this->Show_About_Us_On_Footer->ViewCustomAttributes = "";

		// Pagination_Position
		if (strval($this->Pagination_Position->CurrentValue) <> "") {
			$this->Pagination_Position->ViewValue = $this->Pagination_Position->OptionCaption($this->Pagination_Position->CurrentValue);
		} else {
			$this->Pagination_Position->ViewValue = NULL;
		}
		$this->Pagination_Position->ViewCustomAttributes = "";

		// Pagination_Style
		if (strval($this->Pagination_Style->CurrentValue) <> "") {
			$this->Pagination_Style->ViewValue = $this->Pagination_Style->OptionCaption($this->Pagination_Style->CurrentValue);
		} else {
			$this->Pagination_Style->ViewValue = NULL;
		}
		$this->Pagination_Style->ViewCustomAttributes = "";

		// Selectable_Records_Per_Page
		$this->Selectable_Records_Per_Page->ViewValue = $this->Selectable_Records_Per_Page->CurrentValue;
		$this->Selectable_Records_Per_Page->ViewCustomAttributes = "";

		// Selectable_Groups_Per_Page
		$this->Selectable_Groups_Per_Page->ViewValue = $this->Selectable_Groups_Per_Page->CurrentValue;
		$this->Selectable_Groups_Per_Page->ViewCustomAttributes = "";

		// Default_Record_Per_Page
		$this->Default_Record_Per_Page->ViewValue = $this->Default_Record_Per_Page->CurrentValue;
		$this->Default_Record_Per_Page->ViewCustomAttributes = "";

		// Default_Group_Per_Page
		$this->Default_Group_Per_Page->ViewValue = $this->Default_Group_Per_Page->CurrentValue;
		$this->Default_Group_Per_Page->ViewCustomAttributes = "";

		// Maximum_Selected_Records
		$this->Maximum_Selected_Records->ViewValue = $this->Maximum_Selected_Records->CurrentValue;
		$this->Maximum_Selected_Records->ViewCustomAttributes = "";

		// Maximum_Selected_Groups
		$this->Maximum_Selected_Groups->ViewValue = $this->Maximum_Selected_Groups->CurrentValue;
		$this->Maximum_Selected_Groups->ViewCustomAttributes = "";

		// Show_PageNum_If_Record_Not_Over_Pagesize
		if (ew_ConvertToBool($this->Show_PageNum_If_Record_Not_Over_Pagesize->CurrentValue)) {
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->ViewValue = $this->Show_PageNum_If_Record_Not_Over_Pagesize->FldTagCaption(1) <> "" ? $this->Show_PageNum_If_Record_Not_Over_Pagesize->FldTagCaption(1) : "Yes";
		} else {
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->ViewValue = $this->Show_PageNum_If_Record_Not_Over_Pagesize->FldTagCaption(2) <> "" ? $this->Show_PageNum_If_Record_Not_Over_Pagesize->FldTagCaption(2) : "No";
		}
		$this->Show_PageNum_If_Record_Not_Over_Pagesize->ViewCustomAttributes = "";

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

		// Search_Panel_Collapsed
		if (ew_ConvertToBool($this->Search_Panel_Collapsed->CurrentValue)) {
			$this->Search_Panel_Collapsed->ViewValue = $this->Search_Panel_Collapsed->FldTagCaption(1) <> "" ? $this->Search_Panel_Collapsed->FldTagCaption(1) : "Yes";
		} else {
			$this->Search_Panel_Collapsed->ViewValue = $this->Search_Panel_Collapsed->FldTagCaption(2) <> "" ? $this->Search_Panel_Collapsed->FldTagCaption(2) : "No";
		}
		$this->Search_Panel_Collapsed->ViewCustomAttributes = "";

		// Filter_Panel_Collapsed
		if (ew_ConvertToBool($this->Filter_Panel_Collapsed->CurrentValue)) {
			$this->Filter_Panel_Collapsed->ViewValue = $this->Filter_Panel_Collapsed->FldTagCaption(1) <> "" ? $this->Filter_Panel_Collapsed->FldTagCaption(1) : "Yes";
		} else {
			$this->Filter_Panel_Collapsed->ViewValue = $this->Filter_Panel_Collapsed->FldTagCaption(2) <> "" ? $this->Filter_Panel_Collapsed->FldTagCaption(2) : "No";
		}
		$this->Filter_Panel_Collapsed->ViewCustomAttributes = "";

		// Show_Record_Number_On_List_Page
		if (ew_ConvertToBool($this->Show_Record_Number_On_List_Page->CurrentValue)) {
			$this->Show_Record_Number_On_List_Page->ViewValue = $this->Show_Record_Number_On_List_Page->FldTagCaption(2) <> "" ? $this->Show_Record_Number_On_List_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Record_Number_On_List_Page->ViewValue = $this->Show_Record_Number_On_List_Page->FldTagCaption(1) <> "" ? $this->Show_Record_Number_On_List_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Record_Number_On_List_Page->ViewCustomAttributes = "";

		// Show_Empty_Table_On_List_Page
		if (ew_ConvertToBool($this->Show_Empty_Table_On_List_Page->CurrentValue)) {
			$this->Show_Empty_Table_On_List_Page->ViewValue = $this->Show_Empty_Table_On_List_Page->FldTagCaption(2) <> "" ? $this->Show_Empty_Table_On_List_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Empty_Table_On_List_Page->ViewValue = $this->Show_Empty_Table_On_List_Page->FldTagCaption(1) <> "" ? $this->Show_Empty_Table_On_List_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Empty_Table_On_List_Page->ViewCustomAttributes = "";

		// Rows_Vertical_Align_Top
		if (ew_ConvertToBool($this->Rows_Vertical_Align_Top->CurrentValue)) {
			$this->Rows_Vertical_Align_Top->ViewValue = $this->Rows_Vertical_Align_Top->FldTagCaption(2) <> "" ? $this->Rows_Vertical_Align_Top->FldTagCaption(2) : "Yes";
		} else {
			$this->Rows_Vertical_Align_Top->ViewValue = $this->Rows_Vertical_Align_Top->FldTagCaption(1) <> "" ? $this->Rows_Vertical_Align_Top->FldTagCaption(1) : "No";
		}
		$this->Rows_Vertical_Align_Top->ViewCustomAttributes = "";

		// Action_Button_Alignment
		if (strval($this->Action_Button_Alignment->CurrentValue) <> "") {
			$this->Action_Button_Alignment->ViewValue = $this->Action_Button_Alignment->OptionCaption($this->Action_Button_Alignment->CurrentValue);
		} else {
			$this->Action_Button_Alignment->ViewValue = NULL;
		}
		$this->Action_Button_Alignment->ViewCustomAttributes = "";

		// Show_Add_Success_Message
		if (ew_ConvertToBool($this->Show_Add_Success_Message->CurrentValue)) {
			$this->Show_Add_Success_Message->ViewValue = $this->Show_Add_Success_Message->FldTagCaption(2) <> "" ? $this->Show_Add_Success_Message->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Add_Success_Message->ViewValue = $this->Show_Add_Success_Message->FldTagCaption(1) <> "" ? $this->Show_Add_Success_Message->FldTagCaption(1) : "No";
		}
		$this->Show_Add_Success_Message->ViewCustomAttributes = "";

		// Show_Edit_Success_Message
		if (ew_ConvertToBool($this->Show_Edit_Success_Message->CurrentValue)) {
			$this->Show_Edit_Success_Message->ViewValue = $this->Show_Edit_Success_Message->FldTagCaption(2) <> "" ? $this->Show_Edit_Success_Message->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Edit_Success_Message->ViewValue = $this->Show_Edit_Success_Message->FldTagCaption(1) <> "" ? $this->Show_Edit_Success_Message->FldTagCaption(1) : "No";
		}
		$this->Show_Edit_Success_Message->ViewCustomAttributes = "";

		// jQuery_Auto_Hide_Success_Message
		if (ew_ConvertToBool($this->jQuery_Auto_Hide_Success_Message->CurrentValue)) {
			$this->jQuery_Auto_Hide_Success_Message->ViewValue = $this->jQuery_Auto_Hide_Success_Message->FldTagCaption(2) <> "" ? $this->jQuery_Auto_Hide_Success_Message->FldTagCaption(2) : "Yes";
		} else {
			$this->jQuery_Auto_Hide_Success_Message->ViewValue = $this->jQuery_Auto_Hide_Success_Message->FldTagCaption(1) <> "" ? $this->jQuery_Auto_Hide_Success_Message->FldTagCaption(1) : "No";
		}
		$this->jQuery_Auto_Hide_Success_Message->ViewCustomAttributes = "";

		// Use_Javascript_Message
		if (ew_ConvertToBool($this->Use_Javascript_Message->CurrentValue)) {
			$this->Use_Javascript_Message->ViewValue = $this->Use_Javascript_Message->FldTagCaption(1) <> "" ? $this->Use_Javascript_Message->FldTagCaption(1) : "Yes";
		} else {
			$this->Use_Javascript_Message->ViewValue = $this->Use_Javascript_Message->FldTagCaption(2) <> "" ? $this->Use_Javascript_Message->FldTagCaption(2) : "No";
		}
		$this->Use_Javascript_Message->ViewCustomAttributes = "";

		// Login_Window_Type
		if (strval($this->Login_Window_Type->CurrentValue) <> "") {
			$this->Login_Window_Type->ViewValue = $this->Login_Window_Type->OptionCaption($this->Login_Window_Type->CurrentValue);
		} else {
			$this->Login_Window_Type->ViewValue = NULL;
		}
		$this->Login_Window_Type->ViewCustomAttributes = "";

		// Forgot_Password_Window_Type
		if (strval($this->Forgot_Password_Window_Type->CurrentValue) <> "") {
			$this->Forgot_Password_Window_Type->ViewValue = $this->Forgot_Password_Window_Type->OptionCaption($this->Forgot_Password_Window_Type->CurrentValue);
		} else {
			$this->Forgot_Password_Window_Type->ViewValue = NULL;
		}
		$this->Forgot_Password_Window_Type->ViewCustomAttributes = "";

		// Change_Password_Window_Type
		if (strval($this->Change_Password_Window_Type->CurrentValue) <> "") {
			$this->Change_Password_Window_Type->ViewValue = $this->Change_Password_Window_Type->OptionCaption($this->Change_Password_Window_Type->CurrentValue);
		} else {
			$this->Change_Password_Window_Type->ViewValue = NULL;
		}
		$this->Change_Password_Window_Type->ViewCustomAttributes = "";

		// Registration_Window_Type
		if (strval($this->Registration_Window_Type->CurrentValue) <> "") {
			$this->Registration_Window_Type->ViewValue = $this->Registration_Window_Type->OptionCaption($this->Registration_Window_Type->CurrentValue);
		} else {
			$this->Registration_Window_Type->ViewValue = NULL;
		}
		$this->Registration_Window_Type->ViewCustomAttributes = "";

		// Show_Record_Number_On_Detail_Preview
		if (ew_ConvertToBool($this->Show_Record_Number_On_Detail_Preview->CurrentValue)) {
			$this->Show_Record_Number_On_Detail_Preview->ViewValue = $this->Show_Record_Number_On_Detail_Preview->FldTagCaption(2) <> "" ? $this->Show_Record_Number_On_Detail_Preview->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Record_Number_On_Detail_Preview->ViewValue = $this->Show_Record_Number_On_Detail_Preview->FldTagCaption(1) <> "" ? $this->Show_Record_Number_On_Detail_Preview->FldTagCaption(1) : "No";
		}
		$this->Show_Record_Number_On_Detail_Preview->ViewCustomAttributes = "";

		// Show_Empty_Table_In_Detail_Preview
		if (ew_ConvertToBool($this->Show_Empty_Table_In_Detail_Preview->CurrentValue)) {
			$this->Show_Empty_Table_In_Detail_Preview->ViewValue = $this->Show_Empty_Table_In_Detail_Preview->FldTagCaption(2) <> "" ? $this->Show_Empty_Table_In_Detail_Preview->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Empty_Table_In_Detail_Preview->ViewValue = $this->Show_Empty_Table_In_Detail_Preview->FldTagCaption(1) <> "" ? $this->Show_Empty_Table_In_Detail_Preview->FldTagCaption(1) : "No";
		}
		$this->Show_Empty_Table_In_Detail_Preview->ViewCustomAttributes = "";

		// Detail_Preview_Table_Width
		$this->Detail_Preview_Table_Width->ViewValue = $this->Detail_Preview_Table_Width->CurrentValue;
		$this->Detail_Preview_Table_Width->ViewCustomAttributes = "";

		// Password_Minimum_Length
		$this->Password_Minimum_Length->ViewValue = $this->Password_Minimum_Length->CurrentValue;
		$this->Password_Minimum_Length->ViewCustomAttributes = "";

		// Password_Maximum_Length
		$this->Password_Maximum_Length->ViewValue = $this->Password_Maximum_Length->CurrentValue;
		$this->Password_Maximum_Length->ViewCustomAttributes = "";

		// Password_Must_Contain_At_Least_One_Lower_Case
		if (ew_ConvertToBool($this->Password_Must_Contain_At_Least_One_Lower_Case->CurrentValue)) {
			$this->Password_Must_Contain_At_Least_One_Lower_Case->ViewValue = $this->Password_Must_Contain_At_Least_One_Lower_Case->FldTagCaption(2) <> "" ? $this->Password_Must_Contain_At_Least_One_Lower_Case->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Contain_At_Least_One_Lower_Case->ViewValue = $this->Password_Must_Contain_At_Least_One_Lower_Case->FldTagCaption(1) <> "" ? $this->Password_Must_Contain_At_Least_One_Lower_Case->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Contain_At_Least_One_Lower_Case->ViewCustomAttributes = "";

		// Password_Must_Comply_With_Minumum_Length
		if (ew_ConvertToBool($this->Password_Must_Comply_With_Minumum_Length->CurrentValue)) {
			$this->Password_Must_Comply_With_Minumum_Length->ViewValue = $this->Password_Must_Comply_With_Minumum_Length->FldTagCaption(2) <> "" ? $this->Password_Must_Comply_With_Minumum_Length->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Comply_With_Minumum_Length->ViewValue = $this->Password_Must_Comply_With_Minumum_Length->FldTagCaption(1) <> "" ? $this->Password_Must_Comply_With_Minumum_Length->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Comply_With_Minumum_Length->ViewCustomAttributes = "";

		// Password_Must_Comply_With_Maximum_Length
		if (ew_ConvertToBool($this->Password_Must_Comply_With_Maximum_Length->CurrentValue)) {
			$this->Password_Must_Comply_With_Maximum_Length->ViewValue = $this->Password_Must_Comply_With_Maximum_Length->FldTagCaption(2) <> "" ? $this->Password_Must_Comply_With_Maximum_Length->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Comply_With_Maximum_Length->ViewValue = $this->Password_Must_Comply_With_Maximum_Length->FldTagCaption(1) <> "" ? $this->Password_Must_Comply_With_Maximum_Length->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Comply_With_Maximum_Length->ViewCustomAttributes = "";

		// Password_Must_Contain_At_Least_One_Upper_Case
		if (ew_ConvertToBool($this->Password_Must_Contain_At_Least_One_Upper_Case->CurrentValue)) {
			$this->Password_Must_Contain_At_Least_One_Upper_Case->ViewValue = $this->Password_Must_Contain_At_Least_One_Upper_Case->FldTagCaption(2) <> "" ? $this->Password_Must_Contain_At_Least_One_Upper_Case->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Contain_At_Least_One_Upper_Case->ViewValue = $this->Password_Must_Contain_At_Least_One_Upper_Case->FldTagCaption(1) <> "" ? $this->Password_Must_Contain_At_Least_One_Upper_Case->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Contain_At_Least_One_Upper_Case->ViewCustomAttributes = "";

		// Password_Must_Contain_At_Least_One_Numeric
		if (ew_ConvertToBool($this->Password_Must_Contain_At_Least_One_Numeric->CurrentValue)) {
			$this->Password_Must_Contain_At_Least_One_Numeric->ViewValue = $this->Password_Must_Contain_At_Least_One_Numeric->FldTagCaption(2) <> "" ? $this->Password_Must_Contain_At_Least_One_Numeric->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Contain_At_Least_One_Numeric->ViewValue = $this->Password_Must_Contain_At_Least_One_Numeric->FldTagCaption(1) <> "" ? $this->Password_Must_Contain_At_Least_One_Numeric->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Contain_At_Least_One_Numeric->ViewCustomAttributes = "";

		// Password_Must_Contain_At_Least_One_Symbol
		if (ew_ConvertToBool($this->Password_Must_Contain_At_Least_One_Symbol->CurrentValue)) {
			$this->Password_Must_Contain_At_Least_One_Symbol->ViewValue = $this->Password_Must_Contain_At_Least_One_Symbol->FldTagCaption(2) <> "" ? $this->Password_Must_Contain_At_Least_One_Symbol->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Contain_At_Least_One_Symbol->ViewValue = $this->Password_Must_Contain_At_Least_One_Symbol->FldTagCaption(1) <> "" ? $this->Password_Must_Contain_At_Least_One_Symbol->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Contain_At_Least_One_Symbol->ViewCustomAttributes = "";

		// Password_Must_Be_Difference_Between_Old_And_New
		if (ew_ConvertToBool($this->Password_Must_Be_Difference_Between_Old_And_New->CurrentValue)) {
			$this->Password_Must_Be_Difference_Between_Old_And_New->ViewValue = $this->Password_Must_Be_Difference_Between_Old_And_New->FldTagCaption(2) <> "" ? $this->Password_Must_Be_Difference_Between_Old_And_New->FldTagCaption(2) : "Yes";
		} else {
			$this->Password_Must_Be_Difference_Between_Old_And_New->ViewValue = $this->Password_Must_Be_Difference_Between_Old_And_New->FldTagCaption(1) <> "" ? $this->Password_Must_Be_Difference_Between_Old_And_New->FldTagCaption(1) : "No";
		}
		$this->Password_Must_Be_Difference_Between_Old_And_New->ViewCustomAttributes = "";

		// Reset_Password_Field_Options
		if (strval($this->Reset_Password_Field_Options->CurrentValue) <> "") {
			$this->Reset_Password_Field_Options->ViewValue = $this->Reset_Password_Field_Options->OptionCaption($this->Reset_Password_Field_Options->CurrentValue);
		} else {
			$this->Reset_Password_Field_Options->ViewValue = NULL;
		}
		$this->Reset_Password_Field_Options->ViewCustomAttributes = "";

		// Export_Record_Options
		if (strval($this->Export_Record_Options->CurrentValue) <> "") {
			$this->Export_Record_Options->ViewValue = $this->Export_Record_Options->OptionCaption($this->Export_Record_Options->CurrentValue);
		} else {
			$this->Export_Record_Options->ViewValue = NULL;
		}
		$this->Export_Record_Options->ViewCustomAttributes = "";

		// Show_Record_Number_On_Exported_List_Page
		if (ew_ConvertToBool($this->Show_Record_Number_On_Exported_List_Page->CurrentValue)) {
			$this->Show_Record_Number_On_Exported_List_Page->ViewValue = $this->Show_Record_Number_On_Exported_List_Page->FldTagCaption(2) <> "" ? $this->Show_Record_Number_On_Exported_List_Page->FldTagCaption(2) : "Yes";
		} else {
			$this->Show_Record_Number_On_Exported_List_Page->ViewValue = $this->Show_Record_Number_On_Exported_List_Page->FldTagCaption(1) <> "" ? $this->Show_Record_Number_On_Exported_List_Page->FldTagCaption(1) : "No";
		}
		$this->Show_Record_Number_On_Exported_List_Page->ViewCustomAttributes = "";

		// Use_Table_Setting_For_Export_Field_Caption
		if (ew_ConvertToBool($this->Use_Table_Setting_For_Export_Field_Caption->CurrentValue)) {
			$this->Use_Table_Setting_For_Export_Field_Caption->ViewValue = $this->Use_Table_Setting_For_Export_Field_Caption->FldTagCaption(2) <> "" ? $this->Use_Table_Setting_For_Export_Field_Caption->FldTagCaption(2) : "Yes";
		} else {
			$this->Use_Table_Setting_For_Export_Field_Caption->ViewValue = $this->Use_Table_Setting_For_Export_Field_Caption->FldTagCaption(1) <> "" ? $this->Use_Table_Setting_For_Export_Field_Caption->FldTagCaption(1) : "No";
		}
		$this->Use_Table_Setting_For_Export_Field_Caption->ViewCustomAttributes = "";

		// Use_Table_Setting_For_Export_Original_Value
		if (ew_ConvertToBool($this->Use_Table_Setting_For_Export_Original_Value->CurrentValue)) {
			$this->Use_Table_Setting_For_Export_Original_Value->ViewValue = $this->Use_Table_Setting_For_Export_Original_Value->FldTagCaption(2) <> "" ? $this->Use_Table_Setting_For_Export_Original_Value->FldTagCaption(2) : "Yes";
		} else {
			$this->Use_Table_Setting_For_Export_Original_Value->ViewValue = $this->Use_Table_Setting_For_Export_Original_Value->FldTagCaption(1) <> "" ? $this->Use_Table_Setting_For_Export_Original_Value->FldTagCaption(1) : "No";
		}
		$this->Use_Table_Setting_For_Export_Original_Value->ViewCustomAttributes = "";

			// Option_ID
			$this->Option_ID->LinkCustomAttributes = "";
			$this->Option_ID->HrefValue = "";
			$this->Option_ID->TooltipValue = "";

			// Option_Default
			$this->Option_Default->LinkCustomAttributes = "";
			$this->Option_Default->HrefValue = "";
			$this->Option_Default->TooltipValue = "";

			// Default_Theme
			$this->Default_Theme->LinkCustomAttributes = "";
			$this->Default_Theme->HrefValue = "";
			$this->Default_Theme->TooltipValue = "";

			// Font_Name
			$this->Font_Name->LinkCustomAttributes = "";
			$this->Font_Name->HrefValue = "";
			$this->Font_Name->TooltipValue = "";

			// Font_Size
			$this->Font_Size->LinkCustomAttributes = "";
			$this->Font_Size->HrefValue = "";
			$this->Font_Size->TooltipValue = "";

			// Show_Border_Layout
			$this->Show_Border_Layout->LinkCustomAttributes = "";
			$this->Show_Border_Layout->HrefValue = "";
			$this->Show_Border_Layout->TooltipValue = "";

			// Show_Shadow_Layout
			$this->Show_Shadow_Layout->LinkCustomAttributes = "";
			$this->Show_Shadow_Layout->HrefValue = "";
			$this->Show_Shadow_Layout->TooltipValue = "";

			// Menu_Horizontal
			$this->Menu_Horizontal->LinkCustomAttributes = "";
			$this->Menu_Horizontal->HrefValue = "";
			$this->Menu_Horizontal->TooltipValue = "";

			// Vertical_Menu_Width
			$this->Vertical_Menu_Width->LinkCustomAttributes = "";
			$this->Vertical_Menu_Width->HrefValue = "";
			$this->Vertical_Menu_Width->TooltipValue = "";

			// Show_Announcement
			$this->Show_Announcement->LinkCustomAttributes = "";
			$this->Show_Announcement->HrefValue = "";
			$this->Show_Announcement->TooltipValue = "";

			// Demo_Mode
			$this->Demo_Mode->LinkCustomAttributes = "";
			$this->Demo_Mode->HrefValue = "";
			$this->Demo_Mode->TooltipValue = "";

			// Show_Page_Processing_Time
			$this->Show_Page_Processing_Time->LinkCustomAttributes = "";
			$this->Show_Page_Processing_Time->HrefValue = "";
			$this->Show_Page_Processing_Time->TooltipValue = "";

			// Allow_User_Preferences
			$this->Allow_User_Preferences->LinkCustomAttributes = "";
			$this->Allow_User_Preferences->HrefValue = "";
			$this->Allow_User_Preferences->TooltipValue = "";

			// SMTP_Server
			$this->SMTP_Server->LinkCustomAttributes = "";
			$this->SMTP_Server->HrefValue = "";
			$this->SMTP_Server->TooltipValue = "";

			// SMTP_Server_Port
			$this->SMTP_Server_Port->LinkCustomAttributes = "";
			$this->SMTP_Server_Port->HrefValue = "";
			$this->SMTP_Server_Port->TooltipValue = "";

			// SMTP_Server_Username
			$this->SMTP_Server_Username->LinkCustomAttributes = "";
			$this->SMTP_Server_Username->HrefValue = "";
			$this->SMTP_Server_Username->TooltipValue = "";

			// SMTP_Server_Password
			$this->SMTP_Server_Password->LinkCustomAttributes = "";
			$this->SMTP_Server_Password->HrefValue = "";
			$this->SMTP_Server_Password->TooltipValue = "";

			// Sender_Email
			$this->Sender_Email->LinkCustomAttributes = "";
			$this->Sender_Email->HrefValue = "";
			$this->Sender_Email->TooltipValue = "";

			// Recipient_Email
			$this->Recipient_Email->LinkCustomAttributes = "";
			$this->Recipient_Email->HrefValue = "";
			$this->Recipient_Email->TooltipValue = "";

			// Use_Default_Locale
			$this->Use_Default_Locale->LinkCustomAttributes = "";
			$this->Use_Default_Locale->HrefValue = "";
			$this->Use_Default_Locale->TooltipValue = "";

			// Default_Language
			$this->Default_Language->LinkCustomAttributes = "";
			$this->Default_Language->HrefValue = "";
			$this->Default_Language->TooltipValue = "";

			// Default_Timezone
			$this->Default_Timezone->LinkCustomAttributes = "";
			$this->Default_Timezone->HrefValue = "";
			$this->Default_Timezone->TooltipValue = "";

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

			// Maintenance_Mode
			$this->Maintenance_Mode->LinkCustomAttributes = "";
			$this->Maintenance_Mode->HrefValue = "";
			$this->Maintenance_Mode->TooltipValue = "";

			// Maintenance_Finish_DateTime
			$this->Maintenance_Finish_DateTime->LinkCustomAttributes = "";
			$this->Maintenance_Finish_DateTime->HrefValue = "";
			$this->Maintenance_Finish_DateTime->TooltipValue = "";

			// Auto_Normal_After_Maintenance
			$this->Auto_Normal_After_Maintenance->LinkCustomAttributes = "";
			$this->Auto_Normal_After_Maintenance->HrefValue = "";
			$this->Auto_Normal_After_Maintenance->TooltipValue = "";

			// Allow_User_To_Register
			$this->Allow_User_To_Register->LinkCustomAttributes = "";
			$this->Allow_User_To_Register->HrefValue = "";
			$this->Allow_User_To_Register->TooltipValue = "";

			// Suspend_New_User_Account
			$this->Suspend_New_User_Account->LinkCustomAttributes = "";
			$this->Suspend_New_User_Account->HrefValue = "";
			$this->Suspend_New_User_Account->TooltipValue = "";

			// User_Need_Activation_After_Registered
			$this->User_Need_Activation_After_Registered->LinkCustomAttributes = "";
			$this->User_Need_Activation_After_Registered->HrefValue = "";
			$this->User_Need_Activation_After_Registered->TooltipValue = "";

			// Show_Captcha_On_Registration_Page
			$this->Show_Captcha_On_Registration_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Registration_Page->HrefValue = "";
			$this->Show_Captcha_On_Registration_Page->TooltipValue = "";

			// Show_Terms_And_Conditions_On_Registration_Page
			$this->Show_Terms_And_Conditions_On_Registration_Page->LinkCustomAttributes = "";
			$this->Show_Terms_And_Conditions_On_Registration_Page->HrefValue = "";
			$this->Show_Terms_And_Conditions_On_Registration_Page->TooltipValue = "";

			// User_Auto_Login_After_Activation_Or_Registration
			$this->User_Auto_Login_After_Activation_Or_Registration->LinkCustomAttributes = "";
			$this->User_Auto_Login_After_Activation_Or_Registration->HrefValue = "";
			$this->User_Auto_Login_After_Activation_Or_Registration->TooltipValue = "";

			// Show_Captcha_On_Login_Page
			$this->Show_Captcha_On_Login_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Login_Page->HrefValue = "";
			$this->Show_Captcha_On_Login_Page->TooltipValue = "";

			// Show_Captcha_On_Forgot_Password_Page
			$this->Show_Captcha_On_Forgot_Password_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Forgot_Password_Page->HrefValue = "";
			$this->Show_Captcha_On_Forgot_Password_Page->TooltipValue = "";

			// Show_Captcha_On_Change_Password_Page
			$this->Show_Captcha_On_Change_Password_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Change_Password_Page->HrefValue = "";
			$this->Show_Captcha_On_Change_Password_Page->TooltipValue = "";

			// User_Auto_Logout_After_Idle_In_Minutes
			$this->User_Auto_Logout_After_Idle_In_Minutes->LinkCustomAttributes = "";
			$this->User_Auto_Logout_After_Idle_In_Minutes->HrefValue = "";
			$this->User_Auto_Logout_After_Idle_In_Minutes->TooltipValue = "";

			// User_Login_Maximum_Retry
			$this->User_Login_Maximum_Retry->LinkCustomAttributes = "";
			$this->User_Login_Maximum_Retry->HrefValue = "";
			$this->User_Login_Maximum_Retry->TooltipValue = "";

			// User_Login_Retry_Lockout
			$this->User_Login_Retry_Lockout->LinkCustomAttributes = "";
			$this->User_Login_Retry_Lockout->HrefValue = "";
			$this->User_Login_Retry_Lockout->TooltipValue = "";

			// Redirect_To_Last_Visited_Page_After_Login
			$this->Redirect_To_Last_Visited_Page_After_Login->LinkCustomAttributes = "";
			$this->Redirect_To_Last_Visited_Page_After_Login->HrefValue = "";
			$this->Redirect_To_Last_Visited_Page_After_Login->TooltipValue = "";

			// Enable_Password_Expiry
			$this->Enable_Password_Expiry->LinkCustomAttributes = "";
			$this->Enable_Password_Expiry->HrefValue = "";
			$this->Enable_Password_Expiry->TooltipValue = "";

			// Password_Expiry_In_Days
			$this->Password_Expiry_In_Days->LinkCustomAttributes = "";
			$this->Password_Expiry_In_Days->HrefValue = "";
			$this->Password_Expiry_In_Days->TooltipValue = "";

			// Show_Entire_Header
			$this->Show_Entire_Header->LinkCustomAttributes = "";
			$this->Show_Entire_Header->HrefValue = "";
			$this->Show_Entire_Header->TooltipValue = "";

			// Logo_Width
			$this->Logo_Width->LinkCustomAttributes = "";
			$this->Logo_Width->HrefValue = "";
			$this->Logo_Width->TooltipValue = "";

			// Show_Site_Title_In_Header
			$this->Show_Site_Title_In_Header->LinkCustomAttributes = "";
			$this->Show_Site_Title_In_Header->HrefValue = "";
			$this->Show_Site_Title_In_Header->TooltipValue = "";

			// Show_Current_User_In_Header
			$this->Show_Current_User_In_Header->LinkCustomAttributes = "";
			$this->Show_Current_User_In_Header->HrefValue = "";
			$this->Show_Current_User_In_Header->TooltipValue = "";

			// Text_Align_In_Header
			$this->Text_Align_In_Header->LinkCustomAttributes = "";
			$this->Text_Align_In_Header->HrefValue = "";
			$this->Text_Align_In_Header->TooltipValue = "";

			// Site_Title_Text_Style
			$this->Site_Title_Text_Style->LinkCustomAttributes = "";
			$this->Site_Title_Text_Style->HrefValue = "";
			$this->Site_Title_Text_Style->TooltipValue = "";

			// Language_Selector_Visibility
			$this->Language_Selector_Visibility->LinkCustomAttributes = "";
			$this->Language_Selector_Visibility->HrefValue = "";
			$this->Language_Selector_Visibility->TooltipValue = "";

			// Language_Selector_Align
			$this->Language_Selector_Align->LinkCustomAttributes = "";
			$this->Language_Selector_Align->HrefValue = "";
			$this->Language_Selector_Align->TooltipValue = "";

			// Show_Entire_Footer
			$this->Show_Entire_Footer->LinkCustomAttributes = "";
			$this->Show_Entire_Footer->HrefValue = "";
			$this->Show_Entire_Footer->TooltipValue = "";

			// Show_Text_In_Footer
			$this->Show_Text_In_Footer->LinkCustomAttributes = "";
			$this->Show_Text_In_Footer->HrefValue = "";
			$this->Show_Text_In_Footer->TooltipValue = "";

			// Show_Back_To_Top_On_Footer
			$this->Show_Back_To_Top_On_Footer->LinkCustomAttributes = "";
			$this->Show_Back_To_Top_On_Footer->HrefValue = "";
			$this->Show_Back_To_Top_On_Footer->TooltipValue = "";

			// Show_Terms_And_Conditions_On_Footer
			$this->Show_Terms_And_Conditions_On_Footer->LinkCustomAttributes = "";
			$this->Show_Terms_And_Conditions_On_Footer->HrefValue = "";
			$this->Show_Terms_And_Conditions_On_Footer->TooltipValue = "";

			// Show_About_Us_On_Footer
			$this->Show_About_Us_On_Footer->LinkCustomAttributes = "";
			$this->Show_About_Us_On_Footer->HrefValue = "";
			$this->Show_About_Us_On_Footer->TooltipValue = "";

			// Pagination_Position
			$this->Pagination_Position->LinkCustomAttributes = "";
			$this->Pagination_Position->HrefValue = "";
			$this->Pagination_Position->TooltipValue = "";

			// Pagination_Style
			$this->Pagination_Style->LinkCustomAttributes = "";
			$this->Pagination_Style->HrefValue = "";
			$this->Pagination_Style->TooltipValue = "";

			// Selectable_Records_Per_Page
			$this->Selectable_Records_Per_Page->LinkCustomAttributes = "";
			$this->Selectable_Records_Per_Page->HrefValue = "";
			$this->Selectable_Records_Per_Page->TooltipValue = "";

			// Selectable_Groups_Per_Page
			$this->Selectable_Groups_Per_Page->LinkCustomAttributes = "";
			$this->Selectable_Groups_Per_Page->HrefValue = "";
			$this->Selectable_Groups_Per_Page->TooltipValue = "";

			// Default_Record_Per_Page
			$this->Default_Record_Per_Page->LinkCustomAttributes = "";
			$this->Default_Record_Per_Page->HrefValue = "";
			$this->Default_Record_Per_Page->TooltipValue = "";

			// Default_Group_Per_Page
			$this->Default_Group_Per_Page->LinkCustomAttributes = "";
			$this->Default_Group_Per_Page->HrefValue = "";
			$this->Default_Group_Per_Page->TooltipValue = "";

			// Maximum_Selected_Records
			$this->Maximum_Selected_Records->LinkCustomAttributes = "";
			$this->Maximum_Selected_Records->HrefValue = "";
			$this->Maximum_Selected_Records->TooltipValue = "";

			// Maximum_Selected_Groups
			$this->Maximum_Selected_Groups->LinkCustomAttributes = "";
			$this->Maximum_Selected_Groups->HrefValue = "";
			$this->Maximum_Selected_Groups->TooltipValue = "";

			// Show_PageNum_If_Record_Not_Over_Pagesize
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->LinkCustomAttributes = "";
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->HrefValue = "";
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->TooltipValue = "";

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

			// Search_Panel_Collapsed
			$this->Search_Panel_Collapsed->LinkCustomAttributes = "";
			$this->Search_Panel_Collapsed->HrefValue = "";
			$this->Search_Panel_Collapsed->TooltipValue = "";

			// Filter_Panel_Collapsed
			$this->Filter_Panel_Collapsed->LinkCustomAttributes = "";
			$this->Filter_Panel_Collapsed->HrefValue = "";
			$this->Filter_Panel_Collapsed->TooltipValue = "";

			// Show_Record_Number_On_List_Page
			$this->Show_Record_Number_On_List_Page->LinkCustomAttributes = "";
			$this->Show_Record_Number_On_List_Page->HrefValue = "";
			$this->Show_Record_Number_On_List_Page->TooltipValue = "";

			// Show_Empty_Table_On_List_Page
			$this->Show_Empty_Table_On_List_Page->LinkCustomAttributes = "";
			$this->Show_Empty_Table_On_List_Page->HrefValue = "";
			$this->Show_Empty_Table_On_List_Page->TooltipValue = "";

			// Rows_Vertical_Align_Top
			$this->Rows_Vertical_Align_Top->LinkCustomAttributes = "";
			$this->Rows_Vertical_Align_Top->HrefValue = "";
			$this->Rows_Vertical_Align_Top->TooltipValue = "";

			// Action_Button_Alignment
			$this->Action_Button_Alignment->LinkCustomAttributes = "";
			$this->Action_Button_Alignment->HrefValue = "";
			$this->Action_Button_Alignment->TooltipValue = "";

			// Show_Add_Success_Message
			$this->Show_Add_Success_Message->LinkCustomAttributes = "";
			$this->Show_Add_Success_Message->HrefValue = "";
			$this->Show_Add_Success_Message->TooltipValue = "";

			// Show_Edit_Success_Message
			$this->Show_Edit_Success_Message->LinkCustomAttributes = "";
			$this->Show_Edit_Success_Message->HrefValue = "";
			$this->Show_Edit_Success_Message->TooltipValue = "";

			// jQuery_Auto_Hide_Success_Message
			$this->jQuery_Auto_Hide_Success_Message->LinkCustomAttributes = "";
			$this->jQuery_Auto_Hide_Success_Message->HrefValue = "";
			$this->jQuery_Auto_Hide_Success_Message->TooltipValue = "";

			// Use_Javascript_Message
			$this->Use_Javascript_Message->LinkCustomAttributes = "";
			$this->Use_Javascript_Message->HrefValue = "";
			$this->Use_Javascript_Message->TooltipValue = "";

			// Login_Window_Type
			$this->Login_Window_Type->LinkCustomAttributes = "";
			$this->Login_Window_Type->HrefValue = "";
			$this->Login_Window_Type->TooltipValue = "";

			// Forgot_Password_Window_Type
			$this->Forgot_Password_Window_Type->LinkCustomAttributes = "";
			$this->Forgot_Password_Window_Type->HrefValue = "";
			$this->Forgot_Password_Window_Type->TooltipValue = "";

			// Change_Password_Window_Type
			$this->Change_Password_Window_Type->LinkCustomAttributes = "";
			$this->Change_Password_Window_Type->HrefValue = "";
			$this->Change_Password_Window_Type->TooltipValue = "";

			// Registration_Window_Type
			$this->Registration_Window_Type->LinkCustomAttributes = "";
			$this->Registration_Window_Type->HrefValue = "";
			$this->Registration_Window_Type->TooltipValue = "";

			// Show_Record_Number_On_Detail_Preview
			$this->Show_Record_Number_On_Detail_Preview->LinkCustomAttributes = "";
			$this->Show_Record_Number_On_Detail_Preview->HrefValue = "";
			$this->Show_Record_Number_On_Detail_Preview->TooltipValue = "";

			// Show_Empty_Table_In_Detail_Preview
			$this->Show_Empty_Table_In_Detail_Preview->LinkCustomAttributes = "";
			$this->Show_Empty_Table_In_Detail_Preview->HrefValue = "";
			$this->Show_Empty_Table_In_Detail_Preview->TooltipValue = "";

			// Detail_Preview_Table_Width
			$this->Detail_Preview_Table_Width->LinkCustomAttributes = "";
			$this->Detail_Preview_Table_Width->HrefValue = "";
			$this->Detail_Preview_Table_Width->TooltipValue = "";

			// Password_Minimum_Length
			$this->Password_Minimum_Length->LinkCustomAttributes = "";
			$this->Password_Minimum_Length->HrefValue = "";
			$this->Password_Minimum_Length->TooltipValue = "";

			// Password_Maximum_Length
			$this->Password_Maximum_Length->LinkCustomAttributes = "";
			$this->Password_Maximum_Length->HrefValue = "";
			$this->Password_Maximum_Length->TooltipValue = "";

			// Password_Must_Contain_At_Least_One_Lower_Case
			$this->Password_Must_Contain_At_Least_One_Lower_Case->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Lower_Case->HrefValue = "";
			$this->Password_Must_Contain_At_Least_One_Lower_Case->TooltipValue = "";

			// Password_Must_Comply_With_Minumum_Length
			$this->Password_Must_Comply_With_Minumum_Length->LinkCustomAttributes = "";
			$this->Password_Must_Comply_With_Minumum_Length->HrefValue = "";
			$this->Password_Must_Comply_With_Minumum_Length->TooltipValue = "";

			// Password_Must_Comply_With_Maximum_Length
			$this->Password_Must_Comply_With_Maximum_Length->LinkCustomAttributes = "";
			$this->Password_Must_Comply_With_Maximum_Length->HrefValue = "";
			$this->Password_Must_Comply_With_Maximum_Length->TooltipValue = "";

			// Password_Must_Contain_At_Least_One_Upper_Case
			$this->Password_Must_Contain_At_Least_One_Upper_Case->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Upper_Case->HrefValue = "";
			$this->Password_Must_Contain_At_Least_One_Upper_Case->TooltipValue = "";

			// Password_Must_Contain_At_Least_One_Numeric
			$this->Password_Must_Contain_At_Least_One_Numeric->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Numeric->HrefValue = "";
			$this->Password_Must_Contain_At_Least_One_Numeric->TooltipValue = "";

			// Password_Must_Contain_At_Least_One_Symbol
			$this->Password_Must_Contain_At_Least_One_Symbol->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Symbol->HrefValue = "";
			$this->Password_Must_Contain_At_Least_One_Symbol->TooltipValue = "";

			// Password_Must_Be_Difference_Between_Old_And_New
			$this->Password_Must_Be_Difference_Between_Old_And_New->LinkCustomAttributes = "";
			$this->Password_Must_Be_Difference_Between_Old_And_New->HrefValue = "";
			$this->Password_Must_Be_Difference_Between_Old_And_New->TooltipValue = "";

			// Reset_Password_Field_Options
			$this->Reset_Password_Field_Options->LinkCustomAttributes = "";
			$this->Reset_Password_Field_Options->HrefValue = "";
			$this->Reset_Password_Field_Options->TooltipValue = "";

			// Export_Record_Options
			$this->Export_Record_Options->LinkCustomAttributes = "";
			$this->Export_Record_Options->HrefValue = "";
			$this->Export_Record_Options->TooltipValue = "";

			// Show_Record_Number_On_Exported_List_Page
			$this->Show_Record_Number_On_Exported_List_Page->LinkCustomAttributes = "";
			$this->Show_Record_Number_On_Exported_List_Page->HrefValue = "";
			$this->Show_Record_Number_On_Exported_List_Page->TooltipValue = "";

			// Use_Table_Setting_For_Export_Field_Caption
			$this->Use_Table_Setting_For_Export_Field_Caption->LinkCustomAttributes = "";
			$this->Use_Table_Setting_For_Export_Field_Caption->HrefValue = "";
			$this->Use_Table_Setting_For_Export_Field_Caption->TooltipValue = "";

			// Use_Table_Setting_For_Export_Original_Value
			$this->Use_Table_Setting_For_Export_Original_Value->LinkCustomAttributes = "";
			$this->Use_Table_Setting_For_Export_Original_Value->HrefValue = "";
			$this->Use_Table_Setting_For_Export_Original_Value->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Option_ID
			$this->Option_ID->EditAttrs["class"] = "form-control";
			$this->Option_ID->EditCustomAttributes = "";
			$this->Option_ID->EditValue = $this->Option_ID->CurrentValue;
			$this->Option_ID->ViewCustomAttributes = "";

			// Option_Default
			$this->Option_Default->EditCustomAttributes = "";
			$this->Option_Default->EditValue = $this->Option_Default->Options(FALSE);

			// Default_Theme
			$this->Default_Theme->EditAttrs["class"] = "form-control";
			$this->Default_Theme->EditCustomAttributes = "";
			if (trim(strval($this->Default_Theme->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Theme_ID`" . ew_SearchString("=", $this->Default_Theme->CurrentValue, EW_DATATYPE_STRING, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Theme_ID`, `Theme_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `themes`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `Theme_ID`, `Theme_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `themes`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Default_Theme, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Theme_ID`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Default_Theme->EditValue = $arwrk;

			// Font_Name
			$this->Font_Name->EditAttrs["class"] = "form-control";
			$this->Font_Name->EditCustomAttributes = "";
			$this->Font_Name->EditValue = $this->Font_Name->Options(TRUE);

			// Font_Size
			$this->Font_Size->EditAttrs["class"] = "form-control";
			$this->Font_Size->EditCustomAttributes = "";
			$this->Font_Size->EditValue = $this->Font_Size->Options(TRUE);

			// Show_Border_Layout
			$this->Show_Border_Layout->EditCustomAttributes = "";
			$this->Show_Border_Layout->EditValue = $this->Show_Border_Layout->Options(FALSE);

			// Show_Shadow_Layout
			$this->Show_Shadow_Layout->EditCustomAttributes = "";
			$this->Show_Shadow_Layout->EditValue = $this->Show_Shadow_Layout->Options(FALSE);

			// Menu_Horizontal
			$this->Menu_Horizontal->EditCustomAttributes = "";
			$this->Menu_Horizontal->EditValue = $this->Menu_Horizontal->Options(FALSE);

			// Vertical_Menu_Width
			$this->Vertical_Menu_Width->EditAttrs["class"] = "form-control";
			$this->Vertical_Menu_Width->EditCustomAttributes = "";
			$this->Vertical_Menu_Width->EditValue = ew_HtmlEncode($this->Vertical_Menu_Width->CurrentValue);
			$this->Vertical_Menu_Width->PlaceHolder = ew_RemoveHtml($this->Vertical_Menu_Width->FldCaption());

			// Show_Announcement
			$this->Show_Announcement->EditAttrs["class"] = "form-control";
			$this->Show_Announcement->EditCustomAttributes = "";
			$this->Show_Announcement->EditValue = $this->Show_Announcement->Options(TRUE);

			// Demo_Mode
			$this->Demo_Mode->EditCustomAttributes = "";
			$this->Demo_Mode->EditValue = $this->Demo_Mode->Options(FALSE);

			// Show_Page_Processing_Time
			$this->Show_Page_Processing_Time->EditCustomAttributes = "";
			$this->Show_Page_Processing_Time->EditValue = $this->Show_Page_Processing_Time->Options(FALSE);

			// Allow_User_Preferences
			$this->Allow_User_Preferences->EditCustomAttributes = "";
			$this->Allow_User_Preferences->EditValue = $this->Allow_User_Preferences->Options(FALSE);

			// SMTP_Server
			$this->SMTP_Server->EditAttrs["class"] = "form-control";
			$this->SMTP_Server->EditCustomAttributes = "";
			$this->SMTP_Server->EditValue = ew_HtmlEncode($this->SMTP_Server->CurrentValue);
			$this->SMTP_Server->PlaceHolder = ew_RemoveHtml($this->SMTP_Server->FldCaption());

			// SMTP_Server_Port
			$this->SMTP_Server_Port->EditAttrs["class"] = "form-control";
			$this->SMTP_Server_Port->EditCustomAttributes = "";
			$this->SMTP_Server_Port->EditValue = ew_HtmlEncode($this->SMTP_Server_Port->CurrentValue);
			$this->SMTP_Server_Port->PlaceHolder = ew_RemoveHtml($this->SMTP_Server_Port->FldCaption());

			// SMTP_Server_Username
			$this->SMTP_Server_Username->EditAttrs["class"] = "form-control";
			$this->SMTP_Server_Username->EditCustomAttributes = "";
			$this->SMTP_Server_Username->EditValue = ew_HtmlEncode($this->SMTP_Server_Username->CurrentValue);
			$this->SMTP_Server_Username->PlaceHolder = ew_RemoveHtml($this->SMTP_Server_Username->FldCaption());

			// SMTP_Server_Password
			$this->SMTP_Server_Password->EditAttrs["class"] = "form-control";
			$this->SMTP_Server_Password->EditCustomAttributes = "";
			$this->SMTP_Server_Password->EditValue = ew_HtmlEncode($this->SMTP_Server_Password->CurrentValue);
			$this->SMTP_Server_Password->PlaceHolder = ew_RemoveHtml($this->SMTP_Server_Password->FldCaption());

			// Sender_Email
			$this->Sender_Email->EditAttrs["class"] = "form-control";
			$this->Sender_Email->EditCustomAttributes = "";
			$this->Sender_Email->EditValue = ew_HtmlEncode($this->Sender_Email->CurrentValue);
			$this->Sender_Email->PlaceHolder = ew_RemoveHtml($this->Sender_Email->FldCaption());

			// Recipient_Email
			$this->Recipient_Email->EditAttrs["class"] = "form-control";
			$this->Recipient_Email->EditCustomAttributes = "";
			$this->Recipient_Email->EditValue = ew_HtmlEncode($this->Recipient_Email->CurrentValue);
			$this->Recipient_Email->PlaceHolder = ew_RemoveHtml($this->Recipient_Email->FldCaption());

			// Use_Default_Locale
			$this->Use_Default_Locale->EditCustomAttributes = "";
			$this->Use_Default_Locale->EditValue = $this->Use_Default_Locale->Options(FALSE);

			// Default_Language
			$this->Default_Language->EditAttrs["class"] = "form-control";
			$this->Default_Language->EditCustomAttributes = "";
			if (trim(strval($this->Default_Language->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Language_Code`" . ew_SearchString("=", $this->Default_Language->CurrentValue, EW_DATATYPE_STRING, "");
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
			$this->Lookup_Selecting($this->Default_Language, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Default_Language->EditValue = $arwrk;

			// Default_Timezone
			$this->Default_Timezone->EditAttrs["class"] = "form-control";
			$this->Default_Timezone->EditCustomAttributes = "";
			if (trim(strval($this->Default_Timezone->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Timezone`" . ew_SearchString("=", $this->Default_Timezone->CurrentValue, EW_DATATYPE_STRING, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Timezone`, `Timezone` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `timezone`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `Timezone`, `Timezone` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `timezone`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Default_Timezone, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Default_Timezone->EditValue = $arwrk;

			// Default_Thousands_Separator
			$this->Default_Thousands_Separator->EditAttrs["class"] = "form-control";
			$this->Default_Thousands_Separator->EditCustomAttributes = "";
			$this->Default_Thousands_Separator->EditValue = ew_HtmlEncode($this->Default_Thousands_Separator->CurrentValue);
			$this->Default_Thousands_Separator->PlaceHolder = ew_RemoveHtml($this->Default_Thousands_Separator->FldCaption());

			// Default_Decimal_Point
			$this->Default_Decimal_Point->EditAttrs["class"] = "form-control";
			$this->Default_Decimal_Point->EditCustomAttributes = "";
			$this->Default_Decimal_Point->EditValue = ew_HtmlEncode($this->Default_Decimal_Point->CurrentValue);
			$this->Default_Decimal_Point->PlaceHolder = ew_RemoveHtml($this->Default_Decimal_Point->FldCaption());

			// Default_Currency_Symbol
			$this->Default_Currency_Symbol->EditAttrs["class"] = "form-control";
			$this->Default_Currency_Symbol->EditCustomAttributes = "";
			$this->Default_Currency_Symbol->EditValue = ew_HtmlEncode($this->Default_Currency_Symbol->CurrentValue);
			$this->Default_Currency_Symbol->PlaceHolder = ew_RemoveHtml($this->Default_Currency_Symbol->FldCaption());

			// Default_Money_Thousands_Separator
			$this->Default_Money_Thousands_Separator->EditAttrs["class"] = "form-control";
			$this->Default_Money_Thousands_Separator->EditCustomAttributes = "";
			$this->Default_Money_Thousands_Separator->EditValue = ew_HtmlEncode($this->Default_Money_Thousands_Separator->CurrentValue);
			$this->Default_Money_Thousands_Separator->PlaceHolder = ew_RemoveHtml($this->Default_Money_Thousands_Separator->FldCaption());

			// Default_Money_Decimal_Point
			$this->Default_Money_Decimal_Point->EditAttrs["class"] = "form-control";
			$this->Default_Money_Decimal_Point->EditCustomAttributes = "";
			$this->Default_Money_Decimal_Point->EditValue = ew_HtmlEncode($this->Default_Money_Decimal_Point->CurrentValue);
			$this->Default_Money_Decimal_Point->PlaceHolder = ew_RemoveHtml($this->Default_Money_Decimal_Point->FldCaption());

			// Maintenance_Mode
			$this->Maintenance_Mode->EditCustomAttributes = "";
			$this->Maintenance_Mode->EditValue = $this->Maintenance_Mode->Options(FALSE);

			// Maintenance_Finish_DateTime
			$this->Maintenance_Finish_DateTime->EditAttrs["class"] = "form-control";
			$this->Maintenance_Finish_DateTime->EditCustomAttributes = "";
			$this->Maintenance_Finish_DateTime->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, 9));
			$this->Maintenance_Finish_DateTime->PlaceHolder = ew_RemoveHtml($this->Maintenance_Finish_DateTime->FldCaption());

			// Auto_Normal_After_Maintenance
			$this->Auto_Normal_After_Maintenance->EditCustomAttributes = "";
			$this->Auto_Normal_After_Maintenance->EditValue = $this->Auto_Normal_After_Maintenance->Options(FALSE);

			// Allow_User_To_Register
			$this->Allow_User_To_Register->EditCustomAttributes = "";
			$this->Allow_User_To_Register->EditValue = $this->Allow_User_To_Register->Options(FALSE);

			// Suspend_New_User_Account
			$this->Suspend_New_User_Account->EditCustomAttributes = "";
			$this->Suspend_New_User_Account->EditValue = $this->Suspend_New_User_Account->Options(FALSE);

			// User_Need_Activation_After_Registered
			$this->User_Need_Activation_After_Registered->EditCustomAttributes = "";
			$this->User_Need_Activation_After_Registered->EditValue = $this->User_Need_Activation_After_Registered->Options(FALSE);

			// Show_Captcha_On_Registration_Page
			$this->Show_Captcha_On_Registration_Page->EditCustomAttributes = "";
			$this->Show_Captcha_On_Registration_Page->EditValue = $this->Show_Captcha_On_Registration_Page->Options(FALSE);

			// Show_Terms_And_Conditions_On_Registration_Page
			$this->Show_Terms_And_Conditions_On_Registration_Page->EditCustomAttributes = "";
			$this->Show_Terms_And_Conditions_On_Registration_Page->EditValue = $this->Show_Terms_And_Conditions_On_Registration_Page->Options(FALSE);

			// User_Auto_Login_After_Activation_Or_Registration
			$this->User_Auto_Login_After_Activation_Or_Registration->EditCustomAttributes = "";
			$this->User_Auto_Login_After_Activation_Or_Registration->EditValue = $this->User_Auto_Login_After_Activation_Or_Registration->Options(FALSE);

			// Show_Captcha_On_Login_Page
			$this->Show_Captcha_On_Login_Page->EditCustomAttributes = "";
			$this->Show_Captcha_On_Login_Page->EditValue = $this->Show_Captcha_On_Login_Page->Options(FALSE);

			// Show_Captcha_On_Forgot_Password_Page
			$this->Show_Captcha_On_Forgot_Password_Page->EditCustomAttributes = "";
			$this->Show_Captcha_On_Forgot_Password_Page->EditValue = $this->Show_Captcha_On_Forgot_Password_Page->Options(FALSE);

			// Show_Captcha_On_Change_Password_Page
			$this->Show_Captcha_On_Change_Password_Page->EditCustomAttributes = "";
			$this->Show_Captcha_On_Change_Password_Page->EditValue = $this->Show_Captcha_On_Change_Password_Page->Options(FALSE);

			// User_Auto_Logout_After_Idle_In_Minutes
			$this->User_Auto_Logout_After_Idle_In_Minutes->EditAttrs["class"] = "form-control";
			$this->User_Auto_Logout_After_Idle_In_Minutes->EditCustomAttributes = "";
			$this->User_Auto_Logout_After_Idle_In_Minutes->EditValue = ew_HtmlEncode($this->User_Auto_Logout_After_Idle_In_Minutes->CurrentValue);
			$this->User_Auto_Logout_After_Idle_In_Minutes->PlaceHolder = ew_RemoveHtml($this->User_Auto_Logout_After_Idle_In_Minutes->FldCaption());

			// User_Login_Maximum_Retry
			$this->User_Login_Maximum_Retry->EditAttrs["class"] = "form-control";
			$this->User_Login_Maximum_Retry->EditCustomAttributes = "";
			$this->User_Login_Maximum_Retry->EditValue = ew_HtmlEncode($this->User_Login_Maximum_Retry->CurrentValue);
			$this->User_Login_Maximum_Retry->PlaceHolder = ew_RemoveHtml($this->User_Login_Maximum_Retry->FldCaption());

			// User_Login_Retry_Lockout
			$this->User_Login_Retry_Lockout->EditAttrs["class"] = "form-control";
			$this->User_Login_Retry_Lockout->EditCustomAttributes = "";
			$this->User_Login_Retry_Lockout->EditValue = ew_HtmlEncode($this->User_Login_Retry_Lockout->CurrentValue);
			$this->User_Login_Retry_Lockout->PlaceHolder = ew_RemoveHtml($this->User_Login_Retry_Lockout->FldCaption());

			// Redirect_To_Last_Visited_Page_After_Login
			$this->Redirect_To_Last_Visited_Page_After_Login->EditCustomAttributes = "";
			$this->Redirect_To_Last_Visited_Page_After_Login->EditValue = $this->Redirect_To_Last_Visited_Page_After_Login->Options(FALSE);

			// Enable_Password_Expiry
			$this->Enable_Password_Expiry->EditCustomAttributes = "";
			$this->Enable_Password_Expiry->EditValue = $this->Enable_Password_Expiry->Options(FALSE);

			// Password_Expiry_In_Days
			$this->Password_Expiry_In_Days->EditAttrs["class"] = "form-control";
			$this->Password_Expiry_In_Days->EditCustomAttributes = "";
			$this->Password_Expiry_In_Days->EditValue = ew_HtmlEncode($this->Password_Expiry_In_Days->CurrentValue);
			$this->Password_Expiry_In_Days->PlaceHolder = ew_RemoveHtml($this->Password_Expiry_In_Days->FldCaption());

			// Show_Entire_Header
			$this->Show_Entire_Header->EditCustomAttributes = "";
			$this->Show_Entire_Header->EditValue = $this->Show_Entire_Header->Options(FALSE);

			// Logo_Width
			$this->Logo_Width->EditAttrs["class"] = "form-control";
			$this->Logo_Width->EditCustomAttributes = "";
			$this->Logo_Width->EditValue = ew_HtmlEncode($this->Logo_Width->CurrentValue);
			$this->Logo_Width->PlaceHolder = ew_RemoveHtml($this->Logo_Width->FldCaption());

			// Show_Site_Title_In_Header
			$this->Show_Site_Title_In_Header->EditCustomAttributes = "";
			$this->Show_Site_Title_In_Header->EditValue = $this->Show_Site_Title_In_Header->Options(FALSE);

			// Show_Current_User_In_Header
			$this->Show_Current_User_In_Header->EditCustomAttributes = "";
			$this->Show_Current_User_In_Header->EditValue = $this->Show_Current_User_In_Header->Options(FALSE);

			// Text_Align_In_Header
			$this->Text_Align_In_Header->EditCustomAttributes = "";
			$this->Text_Align_In_Header->EditValue = $this->Text_Align_In_Header->Options(FALSE);

			// Site_Title_Text_Style
			$this->Site_Title_Text_Style->EditCustomAttributes = "";
			$this->Site_Title_Text_Style->EditValue = $this->Site_Title_Text_Style->Options(FALSE);

			// Language_Selector_Visibility
			$this->Language_Selector_Visibility->EditCustomAttributes = "";
			$this->Language_Selector_Visibility->EditValue = $this->Language_Selector_Visibility->Options(FALSE);

			// Language_Selector_Align
			$this->Language_Selector_Align->EditCustomAttributes = "";
			$this->Language_Selector_Align->EditValue = $this->Language_Selector_Align->Options(FALSE);

			// Show_Entire_Footer
			$this->Show_Entire_Footer->EditCustomAttributes = "";
			$this->Show_Entire_Footer->EditValue = $this->Show_Entire_Footer->Options(FALSE);

			// Show_Text_In_Footer
			$this->Show_Text_In_Footer->EditCustomAttributes = "";
			$this->Show_Text_In_Footer->EditValue = $this->Show_Text_In_Footer->Options(FALSE);

			// Show_Back_To_Top_On_Footer
			$this->Show_Back_To_Top_On_Footer->EditCustomAttributes = "";
			$this->Show_Back_To_Top_On_Footer->EditValue = $this->Show_Back_To_Top_On_Footer->Options(FALSE);

			// Show_Terms_And_Conditions_On_Footer
			$this->Show_Terms_And_Conditions_On_Footer->EditCustomAttributes = "";
			$this->Show_Terms_And_Conditions_On_Footer->EditValue = $this->Show_Terms_And_Conditions_On_Footer->Options(FALSE);

			// Show_About_Us_On_Footer
			$this->Show_About_Us_On_Footer->EditCustomAttributes = "";
			$this->Show_About_Us_On_Footer->EditValue = $this->Show_About_Us_On_Footer->Options(FALSE);

			// Pagination_Position
			$this->Pagination_Position->EditCustomAttributes = "";
			$this->Pagination_Position->EditValue = $this->Pagination_Position->Options(FALSE);

			// Pagination_Style
			$this->Pagination_Style->EditCustomAttributes = "";
			$this->Pagination_Style->EditValue = $this->Pagination_Style->Options(FALSE);

			// Selectable_Records_Per_Page
			$this->Selectable_Records_Per_Page->EditAttrs["class"] = "form-control";
			$this->Selectable_Records_Per_Page->EditCustomAttributes = "";
			$this->Selectable_Records_Per_Page->EditValue = ew_HtmlEncode($this->Selectable_Records_Per_Page->CurrentValue);
			$this->Selectable_Records_Per_Page->PlaceHolder = ew_RemoveHtml($this->Selectable_Records_Per_Page->FldCaption());

			// Selectable_Groups_Per_Page
			$this->Selectable_Groups_Per_Page->EditAttrs["class"] = "form-control";
			$this->Selectable_Groups_Per_Page->EditCustomAttributes = "";
			$this->Selectable_Groups_Per_Page->EditValue = ew_HtmlEncode($this->Selectable_Groups_Per_Page->CurrentValue);
			$this->Selectable_Groups_Per_Page->PlaceHolder = ew_RemoveHtml($this->Selectable_Groups_Per_Page->FldCaption());

			// Default_Record_Per_Page
			$this->Default_Record_Per_Page->EditAttrs["class"] = "form-control";
			$this->Default_Record_Per_Page->EditCustomAttributes = "";
			$this->Default_Record_Per_Page->EditValue = ew_HtmlEncode($this->Default_Record_Per_Page->CurrentValue);
			$this->Default_Record_Per_Page->PlaceHolder = ew_RemoveHtml($this->Default_Record_Per_Page->FldCaption());

			// Default_Group_Per_Page
			$this->Default_Group_Per_Page->EditAttrs["class"] = "form-control";
			$this->Default_Group_Per_Page->EditCustomAttributes = "";
			$this->Default_Group_Per_Page->EditValue = ew_HtmlEncode($this->Default_Group_Per_Page->CurrentValue);
			$this->Default_Group_Per_Page->PlaceHolder = ew_RemoveHtml($this->Default_Group_Per_Page->FldCaption());

			// Maximum_Selected_Records
			$this->Maximum_Selected_Records->EditAttrs["class"] = "form-control";
			$this->Maximum_Selected_Records->EditCustomAttributes = "";
			$this->Maximum_Selected_Records->EditValue = ew_HtmlEncode($this->Maximum_Selected_Records->CurrentValue);
			$this->Maximum_Selected_Records->PlaceHolder = ew_RemoveHtml($this->Maximum_Selected_Records->FldCaption());

			// Maximum_Selected_Groups
			$this->Maximum_Selected_Groups->EditAttrs["class"] = "form-control";
			$this->Maximum_Selected_Groups->EditCustomAttributes = "";
			$this->Maximum_Selected_Groups->EditValue = ew_HtmlEncode($this->Maximum_Selected_Groups->CurrentValue);
			$this->Maximum_Selected_Groups->PlaceHolder = ew_RemoveHtml($this->Maximum_Selected_Groups->FldCaption());

			// Show_PageNum_If_Record_Not_Over_Pagesize
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->EditCustomAttributes = "";
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->EditValue = $this->Show_PageNum_If_Record_Not_Over_Pagesize->Options(FALSE);

			// Table_Width_Style
			$this->Table_Width_Style->EditCustomAttributes = "";
			$this->Table_Width_Style->EditValue = $this->Table_Width_Style->Options(FALSE);

			// Scroll_Table_Width
			$this->Scroll_Table_Width->EditAttrs["class"] = "form-control";
			$this->Scroll_Table_Width->EditCustomAttributes = "";
			$this->Scroll_Table_Width->EditValue = ew_HtmlEncode($this->Scroll_Table_Width->CurrentValue);
			$this->Scroll_Table_Width->PlaceHolder = ew_RemoveHtml($this->Scroll_Table_Width->FldCaption());

			// Scroll_Table_Height
			$this->Scroll_Table_Height->EditAttrs["class"] = "form-control";
			$this->Scroll_Table_Height->EditCustomAttributes = "";
			$this->Scroll_Table_Height->EditValue = ew_HtmlEncode($this->Scroll_Table_Height->CurrentValue);
			$this->Scroll_Table_Height->PlaceHolder = ew_RemoveHtml($this->Scroll_Table_Height->FldCaption());

			// Search_Panel_Collapsed
			$this->Search_Panel_Collapsed->EditCustomAttributes = "";
			$this->Search_Panel_Collapsed->EditValue = $this->Search_Panel_Collapsed->Options(FALSE);

			// Filter_Panel_Collapsed
			$this->Filter_Panel_Collapsed->EditCustomAttributes = "";
			$this->Filter_Panel_Collapsed->EditValue = $this->Filter_Panel_Collapsed->Options(FALSE);

			// Show_Record_Number_On_List_Page
			$this->Show_Record_Number_On_List_Page->EditCustomAttributes = "";
			$this->Show_Record_Number_On_List_Page->EditValue = $this->Show_Record_Number_On_List_Page->Options(FALSE);

			// Show_Empty_Table_On_List_Page
			$this->Show_Empty_Table_On_List_Page->EditCustomAttributes = "";
			$this->Show_Empty_Table_On_List_Page->EditValue = $this->Show_Empty_Table_On_List_Page->Options(FALSE);

			// Rows_Vertical_Align_Top
			$this->Rows_Vertical_Align_Top->EditCustomAttributes = "";
			$this->Rows_Vertical_Align_Top->EditValue = $this->Rows_Vertical_Align_Top->Options(FALSE);

			// Action_Button_Alignment
			$this->Action_Button_Alignment->EditCustomAttributes = "";
			$this->Action_Button_Alignment->EditValue = $this->Action_Button_Alignment->Options(FALSE);

			// Show_Add_Success_Message
			$this->Show_Add_Success_Message->EditCustomAttributes = "";
			$this->Show_Add_Success_Message->EditValue = $this->Show_Add_Success_Message->Options(FALSE);

			// Show_Edit_Success_Message
			$this->Show_Edit_Success_Message->EditCustomAttributes = "";
			$this->Show_Edit_Success_Message->EditValue = $this->Show_Edit_Success_Message->Options(FALSE);

			// jQuery_Auto_Hide_Success_Message
			$this->jQuery_Auto_Hide_Success_Message->EditCustomAttributes = "";
			$this->jQuery_Auto_Hide_Success_Message->EditValue = $this->jQuery_Auto_Hide_Success_Message->Options(FALSE);

			// Use_Javascript_Message
			$this->Use_Javascript_Message->EditCustomAttributes = "";
			$this->Use_Javascript_Message->EditValue = $this->Use_Javascript_Message->Options(FALSE);

			// Login_Window_Type
			$this->Login_Window_Type->EditCustomAttributes = "";
			$this->Login_Window_Type->EditValue = $this->Login_Window_Type->Options(FALSE);

			// Forgot_Password_Window_Type
			$this->Forgot_Password_Window_Type->EditCustomAttributes = "";
			$this->Forgot_Password_Window_Type->EditValue = $this->Forgot_Password_Window_Type->Options(FALSE);

			// Change_Password_Window_Type
			$this->Change_Password_Window_Type->EditCustomAttributes = "";
			$this->Change_Password_Window_Type->EditValue = $this->Change_Password_Window_Type->Options(FALSE);

			// Registration_Window_Type
			$this->Registration_Window_Type->EditCustomAttributes = "";
			$this->Registration_Window_Type->EditValue = $this->Registration_Window_Type->Options(FALSE);

			// Show_Record_Number_On_Detail_Preview
			$this->Show_Record_Number_On_Detail_Preview->EditCustomAttributes = "";
			$this->Show_Record_Number_On_Detail_Preview->EditValue = $this->Show_Record_Number_On_Detail_Preview->Options(FALSE);

			// Show_Empty_Table_In_Detail_Preview
			$this->Show_Empty_Table_In_Detail_Preview->EditCustomAttributes = "";
			$this->Show_Empty_Table_In_Detail_Preview->EditValue = $this->Show_Empty_Table_In_Detail_Preview->Options(FALSE);

			// Detail_Preview_Table_Width
			$this->Detail_Preview_Table_Width->EditAttrs["class"] = "form-control";
			$this->Detail_Preview_Table_Width->EditCustomAttributes = "";
			$this->Detail_Preview_Table_Width->EditValue = ew_HtmlEncode($this->Detail_Preview_Table_Width->CurrentValue);
			$this->Detail_Preview_Table_Width->PlaceHolder = ew_RemoveHtml($this->Detail_Preview_Table_Width->FldCaption());

			// Password_Minimum_Length
			$this->Password_Minimum_Length->EditAttrs["class"] = "form-control";
			$this->Password_Minimum_Length->EditCustomAttributes = "";
			$this->Password_Minimum_Length->EditValue = ew_HtmlEncode($this->Password_Minimum_Length->CurrentValue);
			$this->Password_Minimum_Length->PlaceHolder = ew_RemoveHtml($this->Password_Minimum_Length->FldCaption());

			// Password_Maximum_Length
			$this->Password_Maximum_Length->EditAttrs["class"] = "form-control";
			$this->Password_Maximum_Length->EditCustomAttributes = "";
			$this->Password_Maximum_Length->EditValue = ew_HtmlEncode($this->Password_Maximum_Length->CurrentValue);
			$this->Password_Maximum_Length->PlaceHolder = ew_RemoveHtml($this->Password_Maximum_Length->FldCaption());

			// Password_Must_Contain_At_Least_One_Lower_Case
			$this->Password_Must_Contain_At_Least_One_Lower_Case->EditCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Lower_Case->EditValue = $this->Password_Must_Contain_At_Least_One_Lower_Case->Options(FALSE);

			// Password_Must_Comply_With_Minumum_Length
			$this->Password_Must_Comply_With_Minumum_Length->EditCustomAttributes = "";
			$this->Password_Must_Comply_With_Minumum_Length->EditValue = $this->Password_Must_Comply_With_Minumum_Length->Options(FALSE);

			// Password_Must_Comply_With_Maximum_Length
			$this->Password_Must_Comply_With_Maximum_Length->EditCustomAttributes = "";
			$this->Password_Must_Comply_With_Maximum_Length->EditValue = $this->Password_Must_Comply_With_Maximum_Length->Options(FALSE);

			// Password_Must_Contain_At_Least_One_Upper_Case
			$this->Password_Must_Contain_At_Least_One_Upper_Case->EditCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Upper_Case->EditValue = $this->Password_Must_Contain_At_Least_One_Upper_Case->Options(FALSE);

			// Password_Must_Contain_At_Least_One_Numeric
			$this->Password_Must_Contain_At_Least_One_Numeric->EditCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Numeric->EditValue = $this->Password_Must_Contain_At_Least_One_Numeric->Options(FALSE);

			// Password_Must_Contain_At_Least_One_Symbol
			$this->Password_Must_Contain_At_Least_One_Symbol->EditCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Symbol->EditValue = $this->Password_Must_Contain_At_Least_One_Symbol->Options(FALSE);

			// Password_Must_Be_Difference_Between_Old_And_New
			$this->Password_Must_Be_Difference_Between_Old_And_New->EditCustomAttributes = "";
			$this->Password_Must_Be_Difference_Between_Old_And_New->EditValue = $this->Password_Must_Be_Difference_Between_Old_And_New->Options(FALSE);

			// Reset_Password_Field_Options
			$this->Reset_Password_Field_Options->EditCustomAttributes = "";
			$this->Reset_Password_Field_Options->EditValue = $this->Reset_Password_Field_Options->Options(FALSE);

			// Export_Record_Options
			$this->Export_Record_Options->EditCustomAttributes = "";
			$this->Export_Record_Options->EditValue = $this->Export_Record_Options->Options(FALSE);

			// Show_Record_Number_On_Exported_List_Page
			$this->Show_Record_Number_On_Exported_List_Page->EditCustomAttributes = "";
			$this->Show_Record_Number_On_Exported_List_Page->EditValue = $this->Show_Record_Number_On_Exported_List_Page->Options(FALSE);

			// Use_Table_Setting_For_Export_Field_Caption
			$this->Use_Table_Setting_For_Export_Field_Caption->EditCustomAttributes = "";
			$this->Use_Table_Setting_For_Export_Field_Caption->EditValue = $this->Use_Table_Setting_For_Export_Field_Caption->Options(FALSE);

			// Use_Table_Setting_For_Export_Original_Value
			$this->Use_Table_Setting_For_Export_Original_Value->EditCustomAttributes = "";
			$this->Use_Table_Setting_For_Export_Original_Value->EditValue = $this->Use_Table_Setting_For_Export_Original_Value->Options(FALSE);

			// Edit refer script
			// Option_ID

			$this->Option_ID->LinkCustomAttributes = "";
			$this->Option_ID->HrefValue = "";

			// Option_Default
			$this->Option_Default->LinkCustomAttributes = "";
			$this->Option_Default->HrefValue = "";

			// Default_Theme
			$this->Default_Theme->LinkCustomAttributes = "";
			$this->Default_Theme->HrefValue = "";

			// Font_Name
			$this->Font_Name->LinkCustomAttributes = "";
			$this->Font_Name->HrefValue = "";

			// Font_Size
			$this->Font_Size->LinkCustomAttributes = "";
			$this->Font_Size->HrefValue = "";

			// Show_Border_Layout
			$this->Show_Border_Layout->LinkCustomAttributes = "";
			$this->Show_Border_Layout->HrefValue = "";

			// Show_Shadow_Layout
			$this->Show_Shadow_Layout->LinkCustomAttributes = "";
			$this->Show_Shadow_Layout->HrefValue = "";

			// Menu_Horizontal
			$this->Menu_Horizontal->LinkCustomAttributes = "";
			$this->Menu_Horizontal->HrefValue = "";

			// Vertical_Menu_Width
			$this->Vertical_Menu_Width->LinkCustomAttributes = "";
			$this->Vertical_Menu_Width->HrefValue = "";

			// Show_Announcement
			$this->Show_Announcement->LinkCustomAttributes = "";
			$this->Show_Announcement->HrefValue = "";

			// Demo_Mode
			$this->Demo_Mode->LinkCustomAttributes = "";
			$this->Demo_Mode->HrefValue = "";

			// Show_Page_Processing_Time
			$this->Show_Page_Processing_Time->LinkCustomAttributes = "";
			$this->Show_Page_Processing_Time->HrefValue = "";

			// Allow_User_Preferences
			$this->Allow_User_Preferences->LinkCustomAttributes = "";
			$this->Allow_User_Preferences->HrefValue = "";

			// SMTP_Server
			$this->SMTP_Server->LinkCustomAttributes = "";
			$this->SMTP_Server->HrefValue = "";

			// SMTP_Server_Port
			$this->SMTP_Server_Port->LinkCustomAttributes = "";
			$this->SMTP_Server_Port->HrefValue = "";

			// SMTP_Server_Username
			$this->SMTP_Server_Username->LinkCustomAttributes = "";
			$this->SMTP_Server_Username->HrefValue = "";

			// SMTP_Server_Password
			$this->SMTP_Server_Password->LinkCustomAttributes = "";
			$this->SMTP_Server_Password->HrefValue = "";

			// Sender_Email
			$this->Sender_Email->LinkCustomAttributes = "";
			$this->Sender_Email->HrefValue = "";

			// Recipient_Email
			$this->Recipient_Email->LinkCustomAttributes = "";
			$this->Recipient_Email->HrefValue = "";

			// Use_Default_Locale
			$this->Use_Default_Locale->LinkCustomAttributes = "";
			$this->Use_Default_Locale->HrefValue = "";

			// Default_Language
			$this->Default_Language->LinkCustomAttributes = "";
			$this->Default_Language->HrefValue = "";

			// Default_Timezone
			$this->Default_Timezone->LinkCustomAttributes = "";
			$this->Default_Timezone->HrefValue = "";

			// Default_Thousands_Separator
			$this->Default_Thousands_Separator->LinkCustomAttributes = "";
			$this->Default_Thousands_Separator->HrefValue = "";

			// Default_Decimal_Point
			$this->Default_Decimal_Point->LinkCustomAttributes = "";
			$this->Default_Decimal_Point->HrefValue = "";

			// Default_Currency_Symbol
			$this->Default_Currency_Symbol->LinkCustomAttributes = "";
			$this->Default_Currency_Symbol->HrefValue = "";

			// Default_Money_Thousands_Separator
			$this->Default_Money_Thousands_Separator->LinkCustomAttributes = "";
			$this->Default_Money_Thousands_Separator->HrefValue = "";

			// Default_Money_Decimal_Point
			$this->Default_Money_Decimal_Point->LinkCustomAttributes = "";
			$this->Default_Money_Decimal_Point->HrefValue = "";

			// Maintenance_Mode
			$this->Maintenance_Mode->LinkCustomAttributes = "";
			$this->Maintenance_Mode->HrefValue = "";

			// Maintenance_Finish_DateTime
			$this->Maintenance_Finish_DateTime->LinkCustomAttributes = "";
			$this->Maintenance_Finish_DateTime->HrefValue = "";

			// Auto_Normal_After_Maintenance
			$this->Auto_Normal_After_Maintenance->LinkCustomAttributes = "";
			$this->Auto_Normal_After_Maintenance->HrefValue = "";

			// Allow_User_To_Register
			$this->Allow_User_To_Register->LinkCustomAttributes = "";
			$this->Allow_User_To_Register->HrefValue = "";

			// Suspend_New_User_Account
			$this->Suspend_New_User_Account->LinkCustomAttributes = "";
			$this->Suspend_New_User_Account->HrefValue = "";

			// User_Need_Activation_After_Registered
			$this->User_Need_Activation_After_Registered->LinkCustomAttributes = "";
			$this->User_Need_Activation_After_Registered->HrefValue = "";

			// Show_Captcha_On_Registration_Page
			$this->Show_Captcha_On_Registration_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Registration_Page->HrefValue = "";

			// Show_Terms_And_Conditions_On_Registration_Page
			$this->Show_Terms_And_Conditions_On_Registration_Page->LinkCustomAttributes = "";
			$this->Show_Terms_And_Conditions_On_Registration_Page->HrefValue = "";

			// User_Auto_Login_After_Activation_Or_Registration
			$this->User_Auto_Login_After_Activation_Or_Registration->LinkCustomAttributes = "";
			$this->User_Auto_Login_After_Activation_Or_Registration->HrefValue = "";

			// Show_Captcha_On_Login_Page
			$this->Show_Captcha_On_Login_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Login_Page->HrefValue = "";

			// Show_Captcha_On_Forgot_Password_Page
			$this->Show_Captcha_On_Forgot_Password_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Forgot_Password_Page->HrefValue = "";

			// Show_Captcha_On_Change_Password_Page
			$this->Show_Captcha_On_Change_Password_Page->LinkCustomAttributes = "";
			$this->Show_Captcha_On_Change_Password_Page->HrefValue = "";

			// User_Auto_Logout_After_Idle_In_Minutes
			$this->User_Auto_Logout_After_Idle_In_Minutes->LinkCustomAttributes = "";
			$this->User_Auto_Logout_After_Idle_In_Minutes->HrefValue = "";

			// User_Login_Maximum_Retry
			$this->User_Login_Maximum_Retry->LinkCustomAttributes = "";
			$this->User_Login_Maximum_Retry->HrefValue = "";

			// User_Login_Retry_Lockout
			$this->User_Login_Retry_Lockout->LinkCustomAttributes = "";
			$this->User_Login_Retry_Lockout->HrefValue = "";

			// Redirect_To_Last_Visited_Page_After_Login
			$this->Redirect_To_Last_Visited_Page_After_Login->LinkCustomAttributes = "";
			$this->Redirect_To_Last_Visited_Page_After_Login->HrefValue = "";

			// Enable_Password_Expiry
			$this->Enable_Password_Expiry->LinkCustomAttributes = "";
			$this->Enable_Password_Expiry->HrefValue = "";

			// Password_Expiry_In_Days
			$this->Password_Expiry_In_Days->LinkCustomAttributes = "";
			$this->Password_Expiry_In_Days->HrefValue = "";

			// Show_Entire_Header
			$this->Show_Entire_Header->LinkCustomAttributes = "";
			$this->Show_Entire_Header->HrefValue = "";

			// Logo_Width
			$this->Logo_Width->LinkCustomAttributes = "";
			$this->Logo_Width->HrefValue = "";

			// Show_Site_Title_In_Header
			$this->Show_Site_Title_In_Header->LinkCustomAttributes = "";
			$this->Show_Site_Title_In_Header->HrefValue = "";

			// Show_Current_User_In_Header
			$this->Show_Current_User_In_Header->LinkCustomAttributes = "";
			$this->Show_Current_User_In_Header->HrefValue = "";

			// Text_Align_In_Header
			$this->Text_Align_In_Header->LinkCustomAttributes = "";
			$this->Text_Align_In_Header->HrefValue = "";

			// Site_Title_Text_Style
			$this->Site_Title_Text_Style->LinkCustomAttributes = "";
			$this->Site_Title_Text_Style->HrefValue = "";

			// Language_Selector_Visibility
			$this->Language_Selector_Visibility->LinkCustomAttributes = "";
			$this->Language_Selector_Visibility->HrefValue = "";

			// Language_Selector_Align
			$this->Language_Selector_Align->LinkCustomAttributes = "";
			$this->Language_Selector_Align->HrefValue = "";

			// Show_Entire_Footer
			$this->Show_Entire_Footer->LinkCustomAttributes = "";
			$this->Show_Entire_Footer->HrefValue = "";

			// Show_Text_In_Footer
			$this->Show_Text_In_Footer->LinkCustomAttributes = "";
			$this->Show_Text_In_Footer->HrefValue = "";

			// Show_Back_To_Top_On_Footer
			$this->Show_Back_To_Top_On_Footer->LinkCustomAttributes = "";
			$this->Show_Back_To_Top_On_Footer->HrefValue = "";

			// Show_Terms_And_Conditions_On_Footer
			$this->Show_Terms_And_Conditions_On_Footer->LinkCustomAttributes = "";
			$this->Show_Terms_And_Conditions_On_Footer->HrefValue = "";

			// Show_About_Us_On_Footer
			$this->Show_About_Us_On_Footer->LinkCustomAttributes = "";
			$this->Show_About_Us_On_Footer->HrefValue = "";

			// Pagination_Position
			$this->Pagination_Position->LinkCustomAttributes = "";
			$this->Pagination_Position->HrefValue = "";

			// Pagination_Style
			$this->Pagination_Style->LinkCustomAttributes = "";
			$this->Pagination_Style->HrefValue = "";

			// Selectable_Records_Per_Page
			$this->Selectable_Records_Per_Page->LinkCustomAttributes = "";
			$this->Selectable_Records_Per_Page->HrefValue = "";

			// Selectable_Groups_Per_Page
			$this->Selectable_Groups_Per_Page->LinkCustomAttributes = "";
			$this->Selectable_Groups_Per_Page->HrefValue = "";

			// Default_Record_Per_Page
			$this->Default_Record_Per_Page->LinkCustomAttributes = "";
			$this->Default_Record_Per_Page->HrefValue = "";

			// Default_Group_Per_Page
			$this->Default_Group_Per_Page->LinkCustomAttributes = "";
			$this->Default_Group_Per_Page->HrefValue = "";

			// Maximum_Selected_Records
			$this->Maximum_Selected_Records->LinkCustomAttributes = "";
			$this->Maximum_Selected_Records->HrefValue = "";

			// Maximum_Selected_Groups
			$this->Maximum_Selected_Groups->LinkCustomAttributes = "";
			$this->Maximum_Selected_Groups->HrefValue = "";

			// Show_PageNum_If_Record_Not_Over_Pagesize
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->LinkCustomAttributes = "";
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->HrefValue = "";

			// Table_Width_Style
			$this->Table_Width_Style->LinkCustomAttributes = "";
			$this->Table_Width_Style->HrefValue = "";

			// Scroll_Table_Width
			$this->Scroll_Table_Width->LinkCustomAttributes = "";
			$this->Scroll_Table_Width->HrefValue = "";

			// Scroll_Table_Height
			$this->Scroll_Table_Height->LinkCustomAttributes = "";
			$this->Scroll_Table_Height->HrefValue = "";

			// Search_Panel_Collapsed
			$this->Search_Panel_Collapsed->LinkCustomAttributes = "";
			$this->Search_Panel_Collapsed->HrefValue = "";

			// Filter_Panel_Collapsed
			$this->Filter_Panel_Collapsed->LinkCustomAttributes = "";
			$this->Filter_Panel_Collapsed->HrefValue = "";

			// Show_Record_Number_On_List_Page
			$this->Show_Record_Number_On_List_Page->LinkCustomAttributes = "";
			$this->Show_Record_Number_On_List_Page->HrefValue = "";

			// Show_Empty_Table_On_List_Page
			$this->Show_Empty_Table_On_List_Page->LinkCustomAttributes = "";
			$this->Show_Empty_Table_On_List_Page->HrefValue = "";

			// Rows_Vertical_Align_Top
			$this->Rows_Vertical_Align_Top->LinkCustomAttributes = "";
			$this->Rows_Vertical_Align_Top->HrefValue = "";

			// Action_Button_Alignment
			$this->Action_Button_Alignment->LinkCustomAttributes = "";
			$this->Action_Button_Alignment->HrefValue = "";

			// Show_Add_Success_Message
			$this->Show_Add_Success_Message->LinkCustomAttributes = "";
			$this->Show_Add_Success_Message->HrefValue = "";

			// Show_Edit_Success_Message
			$this->Show_Edit_Success_Message->LinkCustomAttributes = "";
			$this->Show_Edit_Success_Message->HrefValue = "";

			// jQuery_Auto_Hide_Success_Message
			$this->jQuery_Auto_Hide_Success_Message->LinkCustomAttributes = "";
			$this->jQuery_Auto_Hide_Success_Message->HrefValue = "";

			// Use_Javascript_Message
			$this->Use_Javascript_Message->LinkCustomAttributes = "";
			$this->Use_Javascript_Message->HrefValue = "";

			// Login_Window_Type
			$this->Login_Window_Type->LinkCustomAttributes = "";
			$this->Login_Window_Type->HrefValue = "";

			// Forgot_Password_Window_Type
			$this->Forgot_Password_Window_Type->LinkCustomAttributes = "";
			$this->Forgot_Password_Window_Type->HrefValue = "";

			// Change_Password_Window_Type
			$this->Change_Password_Window_Type->LinkCustomAttributes = "";
			$this->Change_Password_Window_Type->HrefValue = "";

			// Registration_Window_Type
			$this->Registration_Window_Type->LinkCustomAttributes = "";
			$this->Registration_Window_Type->HrefValue = "";

			// Show_Record_Number_On_Detail_Preview
			$this->Show_Record_Number_On_Detail_Preview->LinkCustomAttributes = "";
			$this->Show_Record_Number_On_Detail_Preview->HrefValue = "";

			// Show_Empty_Table_In_Detail_Preview
			$this->Show_Empty_Table_In_Detail_Preview->LinkCustomAttributes = "";
			$this->Show_Empty_Table_In_Detail_Preview->HrefValue = "";

			// Detail_Preview_Table_Width
			$this->Detail_Preview_Table_Width->LinkCustomAttributes = "";
			$this->Detail_Preview_Table_Width->HrefValue = "";

			// Password_Minimum_Length
			$this->Password_Minimum_Length->LinkCustomAttributes = "";
			$this->Password_Minimum_Length->HrefValue = "";

			// Password_Maximum_Length
			$this->Password_Maximum_Length->LinkCustomAttributes = "";
			$this->Password_Maximum_Length->HrefValue = "";

			// Password_Must_Contain_At_Least_One_Lower_Case
			$this->Password_Must_Contain_At_Least_One_Lower_Case->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Lower_Case->HrefValue = "";

			// Password_Must_Comply_With_Minumum_Length
			$this->Password_Must_Comply_With_Minumum_Length->LinkCustomAttributes = "";
			$this->Password_Must_Comply_With_Minumum_Length->HrefValue = "";

			// Password_Must_Comply_With_Maximum_Length
			$this->Password_Must_Comply_With_Maximum_Length->LinkCustomAttributes = "";
			$this->Password_Must_Comply_With_Maximum_Length->HrefValue = "";

			// Password_Must_Contain_At_Least_One_Upper_Case
			$this->Password_Must_Contain_At_Least_One_Upper_Case->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Upper_Case->HrefValue = "";

			// Password_Must_Contain_At_Least_One_Numeric
			$this->Password_Must_Contain_At_Least_One_Numeric->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Numeric->HrefValue = "";

			// Password_Must_Contain_At_Least_One_Symbol
			$this->Password_Must_Contain_At_Least_One_Symbol->LinkCustomAttributes = "";
			$this->Password_Must_Contain_At_Least_One_Symbol->HrefValue = "";

			// Password_Must_Be_Difference_Between_Old_And_New
			$this->Password_Must_Be_Difference_Between_Old_And_New->LinkCustomAttributes = "";
			$this->Password_Must_Be_Difference_Between_Old_And_New->HrefValue = "";

			// Reset_Password_Field_Options
			$this->Reset_Password_Field_Options->LinkCustomAttributes = "";
			$this->Reset_Password_Field_Options->HrefValue = "";

			// Export_Record_Options
			$this->Export_Record_Options->LinkCustomAttributes = "";
			$this->Export_Record_Options->HrefValue = "";

			// Show_Record_Number_On_Exported_List_Page
			$this->Show_Record_Number_On_Exported_List_Page->LinkCustomAttributes = "";
			$this->Show_Record_Number_On_Exported_List_Page->HrefValue = "";

			// Use_Table_Setting_For_Export_Field_Caption
			$this->Use_Table_Setting_For_Export_Field_Caption->LinkCustomAttributes = "";
			$this->Use_Table_Setting_For_Export_Field_Caption->HrefValue = "";

			// Use_Table_Setting_For_Export_Original_Value
			$this->Use_Table_Setting_For_Export_Original_Value->LinkCustomAttributes = "";
			$this->Use_Table_Setting_For_Export_Original_Value->HrefValue = "";
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
		if (!$this->Default_Theme->FldIsDetailKey && !is_null($this->Default_Theme->FormValue) && $this->Default_Theme->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Default_Theme->FldCaption(), $this->Default_Theme->ReqErrMsg));
		}
		if (!$this->Font_Name->FldIsDetailKey && !is_null($this->Font_Name->FormValue) && $this->Font_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Font_Name->FldCaption(), $this->Font_Name->ReqErrMsg));
		}
		if (!$this->Font_Size->FldIsDetailKey && !is_null($this->Font_Size->FormValue) && $this->Font_Size->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Font_Size->FldCaption(), $this->Font_Size->ReqErrMsg));
		}
		if (!$this->Vertical_Menu_Width->FldIsDetailKey && !is_null($this->Vertical_Menu_Width->FormValue) && $this->Vertical_Menu_Width->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Vertical_Menu_Width->FldCaption(), $this->Vertical_Menu_Width->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Vertical_Menu_Width->FormValue)) {
			ew_AddMessage($gsFormError, $this->Vertical_Menu_Width->FldErrMsg());
		}
		if (!$this->Show_Announcement->FldIsDetailKey && !is_null($this->Show_Announcement->FormValue) && $this->Show_Announcement->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Show_Announcement->FldCaption(), $this->Show_Announcement->ReqErrMsg));
		}
		if (!ew_CheckDate($this->Maintenance_Finish_DateTime->FormValue)) {
			ew_AddMessage($gsFormError, $this->Maintenance_Finish_DateTime->FldErrMsg());
		}
		if (!ew_CheckInteger($this->User_Auto_Logout_After_Idle_In_Minutes->FormValue)) {
			ew_AddMessage($gsFormError, $this->User_Auto_Logout_After_Idle_In_Minutes->FldErrMsg());
		}
		if (!ew_CheckInteger($this->User_Login_Maximum_Retry->FormValue)) {
			ew_AddMessage($gsFormError, $this->User_Login_Maximum_Retry->FldErrMsg());
		}
		if (!ew_CheckInteger($this->User_Login_Retry_Lockout->FormValue)) {
			ew_AddMessage($gsFormError, $this->User_Login_Retry_Lockout->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Password_Expiry_In_Days->FormValue)) {
			ew_AddMessage($gsFormError, $this->Password_Expiry_In_Days->FldErrMsg());
		}
		if (!$this->Logo_Width->FldIsDetailKey && !is_null($this->Logo_Width->FormValue) && $this->Logo_Width->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Logo_Width->FldCaption(), $this->Logo_Width->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Logo_Width->FormValue)) {
			ew_AddMessage($gsFormError, $this->Logo_Width->FldErrMsg());
		}
		if ($this->Language_Selector_Align->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Language_Selector_Align->FldCaption(), $this->Language_Selector_Align->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Default_Record_Per_Page->FormValue)) {
			ew_AddMessage($gsFormError, $this->Default_Record_Per_Page->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Default_Group_Per_Page->FormValue)) {
			ew_AddMessage($gsFormError, $this->Default_Group_Per_Page->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Maximum_Selected_Records->FormValue)) {
			ew_AddMessage($gsFormError, $this->Maximum_Selected_Records->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Maximum_Selected_Groups->FormValue)) {
			ew_AddMessage($gsFormError, $this->Maximum_Selected_Groups->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Scroll_Table_Width->FormValue)) {
			ew_AddMessage($gsFormError, $this->Scroll_Table_Width->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Scroll_Table_Height->FormValue)) {
			ew_AddMessage($gsFormError, $this->Scroll_Table_Height->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Detail_Preview_Table_Width->FormValue)) {
			ew_AddMessage($gsFormError, $this->Detail_Preview_Table_Width->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Password_Minimum_Length->FormValue)) {
			ew_AddMessage($gsFormError, $this->Password_Minimum_Length->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Password_Maximum_Length->FormValue)) {
			ew_AddMessage($gsFormError, $this->Password_Maximum_Length->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Option_Default
			$tmpBool = $this->Option_Default->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Option_Default->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Option_Default->ReadOnly);

			// Default_Theme
			$this->Default_Theme->SetDbValueDef($rsnew, $this->Default_Theme->CurrentValue, NULL, $this->Default_Theme->ReadOnly);

			// Font_Name
			$this->Font_Name->SetDbValueDef($rsnew, $this->Font_Name->CurrentValue, NULL, $this->Font_Name->ReadOnly);

			// Font_Size
			$this->Font_Size->SetDbValueDef($rsnew, $this->Font_Size->CurrentValue, NULL, $this->Font_Size->ReadOnly);

			// Show_Border_Layout
			$tmpBool = $this->Show_Border_Layout->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Border_Layout->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Border_Layout->ReadOnly);

			// Show_Shadow_Layout
			$tmpBool = $this->Show_Shadow_Layout->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Shadow_Layout->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Shadow_Layout->ReadOnly);

			// Menu_Horizontal
			$tmpBool = $this->Menu_Horizontal->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Menu_Horizontal->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Menu_Horizontal->ReadOnly);

			// Vertical_Menu_Width
			$this->Vertical_Menu_Width->SetDbValueDef($rsnew, $this->Vertical_Menu_Width->CurrentValue, NULL, $this->Vertical_Menu_Width->ReadOnly);

			// Show_Announcement
			$this->Show_Announcement->SetDbValueDef($rsnew, ((strval($this->Show_Announcement->CurrentValue) == "Y") ? "Y" : "N"), NULL, $this->Show_Announcement->ReadOnly);

			// Demo_Mode
			$tmpBool = $this->Demo_Mode->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Demo_Mode->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Demo_Mode->ReadOnly);

			// Show_Page_Processing_Time
			$tmpBool = $this->Show_Page_Processing_Time->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Page_Processing_Time->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Page_Processing_Time->ReadOnly);

			// Allow_User_Preferences
			$tmpBool = $this->Allow_User_Preferences->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Allow_User_Preferences->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Allow_User_Preferences->ReadOnly);

			// SMTP_Server
			$this->SMTP_Server->SetDbValueDef($rsnew, $this->SMTP_Server->CurrentValue, NULL, $this->SMTP_Server->ReadOnly);

			// SMTP_Server_Port
			$this->SMTP_Server_Port->SetDbValueDef($rsnew, $this->SMTP_Server_Port->CurrentValue, NULL, $this->SMTP_Server_Port->ReadOnly);

			// SMTP_Server_Username
			$this->SMTP_Server_Username->SetDbValueDef($rsnew, $this->SMTP_Server_Username->CurrentValue, NULL, $this->SMTP_Server_Username->ReadOnly);

			// SMTP_Server_Password
			$this->SMTP_Server_Password->SetDbValueDef($rsnew, $this->SMTP_Server_Password->CurrentValue, NULL, $this->SMTP_Server_Password->ReadOnly);

			// Sender_Email
			$this->Sender_Email->SetDbValueDef($rsnew, $this->Sender_Email->CurrentValue, NULL, $this->Sender_Email->ReadOnly);

			// Recipient_Email
			$this->Recipient_Email->SetDbValueDef($rsnew, $this->Recipient_Email->CurrentValue, NULL, $this->Recipient_Email->ReadOnly);

			// Use_Default_Locale
			$tmpBool = $this->Use_Default_Locale->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Use_Default_Locale->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Use_Default_Locale->ReadOnly);

			// Default_Language
			$this->Default_Language->SetDbValueDef($rsnew, $this->Default_Language->CurrentValue, NULL, $this->Default_Language->ReadOnly);

			// Default_Timezone
			$this->Default_Timezone->SetDbValueDef($rsnew, $this->Default_Timezone->CurrentValue, NULL, $this->Default_Timezone->ReadOnly);

			// Default_Thousands_Separator
			$this->Default_Thousands_Separator->SetDbValueDef($rsnew, $this->Default_Thousands_Separator->CurrentValue, NULL, $this->Default_Thousands_Separator->ReadOnly);

			// Default_Decimal_Point
			$this->Default_Decimal_Point->SetDbValueDef($rsnew, $this->Default_Decimal_Point->CurrentValue, NULL, $this->Default_Decimal_Point->ReadOnly);

			// Default_Currency_Symbol
			$this->Default_Currency_Symbol->SetDbValueDef($rsnew, $this->Default_Currency_Symbol->CurrentValue, NULL, $this->Default_Currency_Symbol->ReadOnly);

			// Default_Money_Thousands_Separator
			$this->Default_Money_Thousands_Separator->SetDbValueDef($rsnew, $this->Default_Money_Thousands_Separator->CurrentValue, NULL, $this->Default_Money_Thousands_Separator->ReadOnly);

			// Default_Money_Decimal_Point
			$this->Default_Money_Decimal_Point->SetDbValueDef($rsnew, $this->Default_Money_Decimal_Point->CurrentValue, NULL, $this->Default_Money_Decimal_Point->ReadOnly);

			// Maintenance_Mode
			$tmpBool = $this->Maintenance_Mode->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Maintenance_Mode->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Maintenance_Mode->ReadOnly);

			// Maintenance_Finish_DateTime
			$this->Maintenance_Finish_DateTime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, 9), NULL, $this->Maintenance_Finish_DateTime->ReadOnly);

			// Auto_Normal_After_Maintenance
			$tmpBool = $this->Auto_Normal_After_Maintenance->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Auto_Normal_After_Maintenance->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Auto_Normal_After_Maintenance->ReadOnly);

			// Allow_User_To_Register
			$tmpBool = $this->Allow_User_To_Register->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Allow_User_To_Register->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Allow_User_To_Register->ReadOnly);

			// Suspend_New_User_Account
			$tmpBool = $this->Suspend_New_User_Account->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Suspend_New_User_Account->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Suspend_New_User_Account->ReadOnly);

			// User_Need_Activation_After_Registered
			$tmpBool = $this->User_Need_Activation_After_Registered->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->User_Need_Activation_After_Registered->SetDbValueDef($rsnew, $tmpBool, NULL, $this->User_Need_Activation_After_Registered->ReadOnly);

			// Show_Captcha_On_Registration_Page
			$tmpBool = $this->Show_Captcha_On_Registration_Page->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Captcha_On_Registration_Page->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Captcha_On_Registration_Page->ReadOnly);

			// Show_Terms_And_Conditions_On_Registration_Page
			$tmpBool = $this->Show_Terms_And_Conditions_On_Registration_Page->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Terms_And_Conditions_On_Registration_Page->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Terms_And_Conditions_On_Registration_Page->ReadOnly);

			// User_Auto_Login_After_Activation_Or_Registration
			$tmpBool = $this->User_Auto_Login_After_Activation_Or_Registration->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->User_Auto_Login_After_Activation_Or_Registration->SetDbValueDef($rsnew, $tmpBool, NULL, $this->User_Auto_Login_After_Activation_Or_Registration->ReadOnly);

			// Show_Captcha_On_Login_Page
			$tmpBool = $this->Show_Captcha_On_Login_Page->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Captcha_On_Login_Page->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Captcha_On_Login_Page->ReadOnly);

			// Show_Captcha_On_Forgot_Password_Page
			$tmpBool = $this->Show_Captcha_On_Forgot_Password_Page->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Captcha_On_Forgot_Password_Page->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Captcha_On_Forgot_Password_Page->ReadOnly);

			// Show_Captcha_On_Change_Password_Page
			$tmpBool = $this->Show_Captcha_On_Change_Password_Page->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Captcha_On_Change_Password_Page->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Captcha_On_Change_Password_Page->ReadOnly);

			// User_Auto_Logout_After_Idle_In_Minutes
			$this->User_Auto_Logout_After_Idle_In_Minutes->SetDbValueDef($rsnew, $this->User_Auto_Logout_After_Idle_In_Minutes->CurrentValue, NULL, $this->User_Auto_Logout_After_Idle_In_Minutes->ReadOnly);

			// User_Login_Maximum_Retry
			$this->User_Login_Maximum_Retry->SetDbValueDef($rsnew, $this->User_Login_Maximum_Retry->CurrentValue, NULL, $this->User_Login_Maximum_Retry->ReadOnly);

			// User_Login_Retry_Lockout
			$this->User_Login_Retry_Lockout->SetDbValueDef($rsnew, $this->User_Login_Retry_Lockout->CurrentValue, NULL, $this->User_Login_Retry_Lockout->ReadOnly);

			// Redirect_To_Last_Visited_Page_After_Login
			$tmpBool = $this->Redirect_To_Last_Visited_Page_After_Login->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Redirect_To_Last_Visited_Page_After_Login->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Redirect_To_Last_Visited_Page_After_Login->ReadOnly);

			// Enable_Password_Expiry
			$tmpBool = $this->Enable_Password_Expiry->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Enable_Password_Expiry->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Enable_Password_Expiry->ReadOnly);

			// Password_Expiry_In_Days
			$this->Password_Expiry_In_Days->SetDbValueDef($rsnew, $this->Password_Expiry_In_Days->CurrentValue, NULL, $this->Password_Expiry_In_Days->ReadOnly);

			// Show_Entire_Header
			$tmpBool = $this->Show_Entire_Header->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Entire_Header->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Entire_Header->ReadOnly);

			// Logo_Width
			$this->Logo_Width->SetDbValueDef($rsnew, $this->Logo_Width->CurrentValue, NULL, $this->Logo_Width->ReadOnly);

			// Show_Site_Title_In_Header
			$tmpBool = $this->Show_Site_Title_In_Header->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Site_Title_In_Header->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Site_Title_In_Header->ReadOnly);

			// Show_Current_User_In_Header
			$tmpBool = $this->Show_Current_User_In_Header->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Current_User_In_Header->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Current_User_In_Header->ReadOnly);

			// Text_Align_In_Header
			$this->Text_Align_In_Header->SetDbValueDef($rsnew, $this->Text_Align_In_Header->CurrentValue, NULL, $this->Text_Align_In_Header->ReadOnly);

			// Site_Title_Text_Style
			$this->Site_Title_Text_Style->SetDbValueDef($rsnew, $this->Site_Title_Text_Style->CurrentValue, NULL, $this->Site_Title_Text_Style->ReadOnly);

			// Language_Selector_Visibility
			$this->Language_Selector_Visibility->SetDbValueDef($rsnew, $this->Language_Selector_Visibility->CurrentValue, NULL, $this->Language_Selector_Visibility->ReadOnly);

			// Language_Selector_Align
			$this->Language_Selector_Align->SetDbValueDef($rsnew, $this->Language_Selector_Align->CurrentValue, NULL, $this->Language_Selector_Align->ReadOnly);

			// Show_Entire_Footer
			$tmpBool = $this->Show_Entire_Footer->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Entire_Footer->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Entire_Footer->ReadOnly);

			// Show_Text_In_Footer
			$tmpBool = $this->Show_Text_In_Footer->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Text_In_Footer->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Text_In_Footer->ReadOnly);

			// Show_Back_To_Top_On_Footer
			$tmpBool = $this->Show_Back_To_Top_On_Footer->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Back_To_Top_On_Footer->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Back_To_Top_On_Footer->ReadOnly);

			// Show_Terms_And_Conditions_On_Footer
			$tmpBool = $this->Show_Terms_And_Conditions_On_Footer->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Terms_And_Conditions_On_Footer->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Terms_And_Conditions_On_Footer->ReadOnly);

			// Show_About_Us_On_Footer
			$tmpBool = $this->Show_About_Us_On_Footer->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_About_Us_On_Footer->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_About_Us_On_Footer->ReadOnly);

			// Pagination_Position
			$this->Pagination_Position->SetDbValueDef($rsnew, $this->Pagination_Position->CurrentValue, NULL, $this->Pagination_Position->ReadOnly);

			// Pagination_Style
			$this->Pagination_Style->SetDbValueDef($rsnew, $this->Pagination_Style->CurrentValue, NULL, $this->Pagination_Style->ReadOnly);

			// Selectable_Records_Per_Page
			$this->Selectable_Records_Per_Page->SetDbValueDef($rsnew, $this->Selectable_Records_Per_Page->CurrentValue, NULL, $this->Selectable_Records_Per_Page->ReadOnly);

			// Selectable_Groups_Per_Page
			$this->Selectable_Groups_Per_Page->SetDbValueDef($rsnew, $this->Selectable_Groups_Per_Page->CurrentValue, NULL, $this->Selectable_Groups_Per_Page->ReadOnly);

			// Default_Record_Per_Page
			$this->Default_Record_Per_Page->SetDbValueDef($rsnew, $this->Default_Record_Per_Page->CurrentValue, NULL, $this->Default_Record_Per_Page->ReadOnly);

			// Default_Group_Per_Page
			$this->Default_Group_Per_Page->SetDbValueDef($rsnew, $this->Default_Group_Per_Page->CurrentValue, NULL, $this->Default_Group_Per_Page->ReadOnly);

			// Maximum_Selected_Records
			$this->Maximum_Selected_Records->SetDbValueDef($rsnew, $this->Maximum_Selected_Records->CurrentValue, NULL, $this->Maximum_Selected_Records->ReadOnly);

			// Maximum_Selected_Groups
			$this->Maximum_Selected_Groups->SetDbValueDef($rsnew, $this->Maximum_Selected_Groups->CurrentValue, NULL, $this->Maximum_Selected_Groups->ReadOnly);

			// Show_PageNum_If_Record_Not_Over_Pagesize
			$tmpBool = $this->Show_PageNum_If_Record_Not_Over_Pagesize->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_PageNum_If_Record_Not_Over_Pagesize->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_PageNum_If_Record_Not_Over_Pagesize->ReadOnly);

			// Table_Width_Style
			$this->Table_Width_Style->SetDbValueDef($rsnew, $this->Table_Width_Style->CurrentValue, NULL, $this->Table_Width_Style->ReadOnly);

			// Scroll_Table_Width
			$this->Scroll_Table_Width->SetDbValueDef($rsnew, $this->Scroll_Table_Width->CurrentValue, NULL, $this->Scroll_Table_Width->ReadOnly);

			// Scroll_Table_Height
			$this->Scroll_Table_Height->SetDbValueDef($rsnew, $this->Scroll_Table_Height->CurrentValue, NULL, $this->Scroll_Table_Height->ReadOnly);

			// Search_Panel_Collapsed
			$tmpBool = $this->Search_Panel_Collapsed->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Search_Panel_Collapsed->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Search_Panel_Collapsed->ReadOnly);

			// Filter_Panel_Collapsed
			$tmpBool = $this->Filter_Panel_Collapsed->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Filter_Panel_Collapsed->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Filter_Panel_Collapsed->ReadOnly);

			// Show_Record_Number_On_List_Page
			$tmpBool = $this->Show_Record_Number_On_List_Page->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Record_Number_On_List_Page->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Record_Number_On_List_Page->ReadOnly);

			// Show_Empty_Table_On_List_Page
			$tmpBool = $this->Show_Empty_Table_On_List_Page->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Empty_Table_On_List_Page->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Empty_Table_On_List_Page->ReadOnly);

			// Rows_Vertical_Align_Top
			$tmpBool = $this->Rows_Vertical_Align_Top->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Rows_Vertical_Align_Top->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Rows_Vertical_Align_Top->ReadOnly);

			// Action_Button_Alignment
			$this->Action_Button_Alignment->SetDbValueDef($rsnew, $this->Action_Button_Alignment->CurrentValue, NULL, $this->Action_Button_Alignment->ReadOnly);

			// Show_Add_Success_Message
			$tmpBool = $this->Show_Add_Success_Message->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Add_Success_Message->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Add_Success_Message->ReadOnly);

			// Show_Edit_Success_Message
			$tmpBool = $this->Show_Edit_Success_Message->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Edit_Success_Message->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Edit_Success_Message->ReadOnly);

			// jQuery_Auto_Hide_Success_Message
			$tmpBool = $this->jQuery_Auto_Hide_Success_Message->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->jQuery_Auto_Hide_Success_Message->SetDbValueDef($rsnew, $tmpBool, NULL, $this->jQuery_Auto_Hide_Success_Message->ReadOnly);

			// Use_Javascript_Message
			$tmpBool = $this->Use_Javascript_Message->CurrentValue;
			if ($tmpBool <> "1" && $tmpBool <> "0")
				$tmpBool = (!empty($tmpBool)) ? "1" : "0";
			$this->Use_Javascript_Message->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Use_Javascript_Message->ReadOnly);

			// Login_Window_Type
			$this->Login_Window_Type->SetDbValueDef($rsnew, $this->Login_Window_Type->CurrentValue, NULL, $this->Login_Window_Type->ReadOnly);

			// Forgot_Password_Window_Type
			$this->Forgot_Password_Window_Type->SetDbValueDef($rsnew, $this->Forgot_Password_Window_Type->CurrentValue, NULL, $this->Forgot_Password_Window_Type->ReadOnly);

			// Change_Password_Window_Type
			$this->Change_Password_Window_Type->SetDbValueDef($rsnew, $this->Change_Password_Window_Type->CurrentValue, NULL, $this->Change_Password_Window_Type->ReadOnly);

			// Registration_Window_Type
			$this->Registration_Window_Type->SetDbValueDef($rsnew, $this->Registration_Window_Type->CurrentValue, NULL, $this->Registration_Window_Type->ReadOnly);

			// Show_Record_Number_On_Detail_Preview
			$tmpBool = $this->Show_Record_Number_On_Detail_Preview->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Record_Number_On_Detail_Preview->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Record_Number_On_Detail_Preview->ReadOnly);

			// Show_Empty_Table_In_Detail_Preview
			$tmpBool = $this->Show_Empty_Table_In_Detail_Preview->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Empty_Table_In_Detail_Preview->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Empty_Table_In_Detail_Preview->ReadOnly);

			// Detail_Preview_Table_Width
			$this->Detail_Preview_Table_Width->SetDbValueDef($rsnew, $this->Detail_Preview_Table_Width->CurrentValue, NULL, $this->Detail_Preview_Table_Width->ReadOnly);

			// Password_Minimum_Length
			$this->Password_Minimum_Length->SetDbValueDef($rsnew, $this->Password_Minimum_Length->CurrentValue, NULL, $this->Password_Minimum_Length->ReadOnly);

			// Password_Maximum_Length
			$this->Password_Maximum_Length->SetDbValueDef($rsnew, $this->Password_Maximum_Length->CurrentValue, NULL, $this->Password_Maximum_Length->ReadOnly);

			// Password_Must_Contain_At_Least_One_Lower_Case
			$tmpBool = $this->Password_Must_Contain_At_Least_One_Lower_Case->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Password_Must_Contain_At_Least_One_Lower_Case->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Password_Must_Contain_At_Least_One_Lower_Case->ReadOnly);

			// Password_Must_Comply_With_Minumum_Length
			$tmpBool = $this->Password_Must_Comply_With_Minumum_Length->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Password_Must_Comply_With_Minumum_Length->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Password_Must_Comply_With_Minumum_Length->ReadOnly);

			// Password_Must_Comply_With_Maximum_Length
			$tmpBool = $this->Password_Must_Comply_With_Maximum_Length->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Password_Must_Comply_With_Maximum_Length->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Password_Must_Comply_With_Maximum_Length->ReadOnly);

			// Password_Must_Contain_At_Least_One_Upper_Case
			$tmpBool = $this->Password_Must_Contain_At_Least_One_Upper_Case->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Password_Must_Contain_At_Least_One_Upper_Case->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Password_Must_Contain_At_Least_One_Upper_Case->ReadOnly);

			// Password_Must_Contain_At_Least_One_Numeric
			$tmpBool = $this->Password_Must_Contain_At_Least_One_Numeric->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Password_Must_Contain_At_Least_One_Numeric->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Password_Must_Contain_At_Least_One_Numeric->ReadOnly);

			// Password_Must_Contain_At_Least_One_Symbol
			$tmpBool = $this->Password_Must_Contain_At_Least_One_Symbol->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Password_Must_Contain_At_Least_One_Symbol->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Password_Must_Contain_At_Least_One_Symbol->ReadOnly);

			// Password_Must_Be_Difference_Between_Old_And_New
			$tmpBool = $this->Password_Must_Be_Difference_Between_Old_And_New->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Password_Must_Be_Difference_Between_Old_And_New->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Password_Must_Be_Difference_Between_Old_And_New->ReadOnly);

			// Reset_Password_Field_Options
			$this->Reset_Password_Field_Options->SetDbValueDef($rsnew, $this->Reset_Password_Field_Options->CurrentValue, NULL, $this->Reset_Password_Field_Options->ReadOnly);

			// Export_Record_Options
			$this->Export_Record_Options->SetDbValueDef($rsnew, $this->Export_Record_Options->CurrentValue, NULL, $this->Export_Record_Options->ReadOnly);

			// Show_Record_Number_On_Exported_List_Page
			$tmpBool = $this->Show_Record_Number_On_Exported_List_Page->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Show_Record_Number_On_Exported_List_Page->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Show_Record_Number_On_Exported_List_Page->ReadOnly);

			// Use_Table_Setting_For_Export_Field_Caption
			$tmpBool = $this->Use_Table_Setting_For_Export_Field_Caption->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Use_Table_Setting_For_Export_Field_Caption->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Use_Table_Setting_For_Export_Field_Caption->ReadOnly);

			// Use_Table_Setting_For_Export_Original_Value
			$tmpBool = $this->Use_Table_Setting_For_Export_Original_Value->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Use_Table_Setting_For_Export_Original_Value->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Use_Table_Setting_For_Export_Original_Value->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("settingslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url); // v11.0.4
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Style = "tabs";
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
		$pages->Add(4);
		$pages->Add(5);
		$pages->Add(6);
		$pages->Add(7);
		$pages->Add(8);
		$pages->Add(9);
		$pages->Add(10);
		$pages->Add(11);
		$pages->Add(12);
		$pages->Add(13);
		$pages->Add(14);
		$this->MultiPages = $pages;
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
if (!isset($settings_edit)) $settings_edit = new csettings_edit();

// Page init
$settings_edit->Page_Init();

// Page main
$settings_edit->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$settings_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fsettingsedit = new ew_Form("fsettingsedit", "edit");

// Validate form
fsettingsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Option_Default[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Option_Default->FldCaption(), $settings->Option_Default->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Default_Theme");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Default_Theme->FldCaption(), $settings->Default_Theme->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Font_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Font_Name->FldCaption(), $settings->Font_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Font_Size");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Font_Size->FldCaption(), $settings->Font_Size->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Vertical_Menu_Width");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Vertical_Menu_Width->FldCaption(), $settings->Vertical_Menu_Width->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Vertical_Menu_Width");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Vertical_Menu_Width->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Show_Announcement");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Show_Announcement->FldCaption(), $settings->Show_Announcement->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Maintenance_Finish_DateTime");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Maintenance_Finish_DateTime->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Show_Captcha_On_Registration_Page[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Show_Captcha_On_Registration_Page->FldCaption(), $settings->Show_Captcha_On_Registration_Page->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Show_Terms_And_Conditions_On_Registration_Page[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Show_Terms_And_Conditions_On_Registration_Page->FldCaption(), $settings->Show_Terms_And_Conditions_On_Registration_Page->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_User_Auto_Logout_After_Idle_In_Minutes");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->User_Auto_Logout_After_Idle_In_Minutes->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_User_Login_Maximum_Retry");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->User_Login_Maximum_Retry->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_User_Login_Retry_Lockout");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->User_Login_Retry_Lockout->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Redirect_To_Last_Visited_Page_After_Login[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Redirect_To_Last_Visited_Page_After_Login->FldCaption(), $settings->Redirect_To_Last_Visited_Page_After_Login->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Password_Expiry_In_Days");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Password_Expiry_In_Days->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Logo_Width");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Logo_Width->FldCaption(), $settings->Logo_Width->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Logo_Width");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Logo_Width->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Language_Selector_Align");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Language_Selector_Align->FldCaption(), $settings->Language_Selector_Align->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Show_Terms_And_Conditions_On_Footer[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->Show_Terms_And_Conditions_On_Footer->FldCaption(), $settings->Show_Terms_And_Conditions_On_Footer->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Default_Record_Per_Page");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Default_Record_Per_Page->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Default_Group_Per_Page");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Default_Group_Per_Page->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Maximum_Selected_Records");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Maximum_Selected_Records->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Maximum_Selected_Groups");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Maximum_Selected_Groups->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Scroll_Table_Width");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Scroll_Table_Width->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Scroll_Table_Height");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Scroll_Table_Height->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Detail_Preview_Table_Width");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Detail_Preview_Table_Width->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Password_Minimum_Length");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Password_Minimum_Length->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Password_Maximum_Length");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->Password_Maximum_Length->FldErrMsg()) ?>");

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
fsettingsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsettingsedit.ValidateRequired = true;
<?php } else { ?>
fsettingsedit.ValidateRequired = false; 
<?php } ?>

// Multi-Page
fsettingsedit.MultiPage = new ew_MultiPage("fsettingsedit");

// Dynamic selection lists
fsettingsedit.Lists["x_Option_Default[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Option_Default[]"].Options = <?php echo json_encode($settings->Option_Default->Options()) ?>;
fsettingsedit.Lists["x_Default_Theme"] = {"LinkField":"x_Theme_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Theme_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Font_Name"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Font_Name"].Options = <?php echo json_encode($settings->Font_Name->Options()) ?>;
fsettingsedit.Lists["x_Font_Size"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Font_Size"].Options = <?php echo json_encode($settings->Font_Size->Options()) ?>;
fsettingsedit.Lists["x_Show_Border_Layout[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Border_Layout[]"].Options = <?php echo json_encode($settings->Show_Border_Layout->Options()) ?>;
fsettingsedit.Lists["x_Show_Shadow_Layout[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Shadow_Layout[]"].Options = <?php echo json_encode($settings->Show_Shadow_Layout->Options()) ?>;
fsettingsedit.Lists["x_Menu_Horizontal[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Menu_Horizontal[]"].Options = <?php echo json_encode($settings->Menu_Horizontal->Options()) ?>;
fsettingsedit.Lists["x_Show_Announcement"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Announcement"].Options = <?php echo json_encode($settings->Show_Announcement->Options()) ?>;
fsettingsedit.Lists["x_Demo_Mode[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Demo_Mode[]"].Options = <?php echo json_encode($settings->Demo_Mode->Options()) ?>;
fsettingsedit.Lists["x_Show_Page_Processing_Time[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Page_Processing_Time[]"].Options = <?php echo json_encode($settings->Show_Page_Processing_Time->Options()) ?>;
fsettingsedit.Lists["x_Allow_User_Preferences[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Allow_User_Preferences[]"].Options = <?php echo json_encode($settings->Allow_User_Preferences->Options()) ?>;
fsettingsedit.Lists["x_Use_Default_Locale[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Use_Default_Locale[]"].Options = <?php echo json_encode($settings->Use_Default_Locale->Options()) ?>;
fsettingsedit.Lists["x_Default_Language"] = {"LinkField":"x_Language_Code","Ajax":true,"AutoFill":false,"DisplayFields":["x_Language_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Default_Timezone"] = {"LinkField":"x_Timezone","Ajax":true,"AutoFill":false,"DisplayFields":["x_Timezone","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Maintenance_Mode[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Maintenance_Mode[]"].Options = <?php echo json_encode($settings->Maintenance_Mode->Options()) ?>;
fsettingsedit.Lists["x_Auto_Normal_After_Maintenance[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Auto_Normal_After_Maintenance[]"].Options = <?php echo json_encode($settings->Auto_Normal_After_Maintenance->Options()) ?>;
fsettingsedit.Lists["x_Allow_User_To_Register[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Allow_User_To_Register[]"].Options = <?php echo json_encode($settings->Allow_User_To_Register->Options()) ?>;
fsettingsedit.Lists["x_Suspend_New_User_Account[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Suspend_New_User_Account[]"].Options = <?php echo json_encode($settings->Suspend_New_User_Account->Options()) ?>;
fsettingsedit.Lists["x_User_Need_Activation_After_Registered[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_User_Need_Activation_After_Registered[]"].Options = <?php echo json_encode($settings->User_Need_Activation_After_Registered->Options()) ?>;
fsettingsedit.Lists["x_Show_Captcha_On_Registration_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Captcha_On_Registration_Page[]"].Options = <?php echo json_encode($settings->Show_Captcha_On_Registration_Page->Options()) ?>;
fsettingsedit.Lists["x_Show_Terms_And_Conditions_On_Registration_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Terms_And_Conditions_On_Registration_Page[]"].Options = <?php echo json_encode($settings->Show_Terms_And_Conditions_On_Registration_Page->Options()) ?>;
fsettingsedit.Lists["x_User_Auto_Login_After_Activation_Or_Registration[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_User_Auto_Login_After_Activation_Or_Registration[]"].Options = <?php echo json_encode($settings->User_Auto_Login_After_Activation_Or_Registration->Options()) ?>;
fsettingsedit.Lists["x_Show_Captcha_On_Login_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Captcha_On_Login_Page[]"].Options = <?php echo json_encode($settings->Show_Captcha_On_Login_Page->Options()) ?>;
fsettingsedit.Lists["x_Show_Captcha_On_Forgot_Password_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Captcha_On_Forgot_Password_Page[]"].Options = <?php echo json_encode($settings->Show_Captcha_On_Forgot_Password_Page->Options()) ?>;
fsettingsedit.Lists["x_Show_Captcha_On_Change_Password_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Captcha_On_Change_Password_Page[]"].Options = <?php echo json_encode($settings->Show_Captcha_On_Change_Password_Page->Options()) ?>;
fsettingsedit.Lists["x_Redirect_To_Last_Visited_Page_After_Login[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Redirect_To_Last_Visited_Page_After_Login[]"].Options = <?php echo json_encode($settings->Redirect_To_Last_Visited_Page_After_Login->Options()) ?>;
fsettingsedit.Lists["x_Enable_Password_Expiry[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Enable_Password_Expiry[]"].Options = <?php echo json_encode($settings->Enable_Password_Expiry->Options()) ?>;
fsettingsedit.Lists["x_Show_Entire_Header[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Entire_Header[]"].Options = <?php echo json_encode($settings->Show_Entire_Header->Options()) ?>;
fsettingsedit.Lists["x_Show_Site_Title_In_Header[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Site_Title_In_Header[]"].Options = <?php echo json_encode($settings->Show_Site_Title_In_Header->Options()) ?>;
fsettingsedit.Lists["x_Show_Current_User_In_Header[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Current_User_In_Header[]"].Options = <?php echo json_encode($settings->Show_Current_User_In_Header->Options()) ?>;
fsettingsedit.Lists["x_Text_Align_In_Header"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Text_Align_In_Header"].Options = <?php echo json_encode($settings->Text_Align_In_Header->Options()) ?>;
fsettingsedit.Lists["x_Site_Title_Text_Style"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Site_Title_Text_Style"].Options = <?php echo json_encode($settings->Site_Title_Text_Style->Options()) ?>;
fsettingsedit.Lists["x_Language_Selector_Visibility"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Language_Selector_Visibility"].Options = <?php echo json_encode($settings->Language_Selector_Visibility->Options()) ?>;
fsettingsedit.Lists["x_Language_Selector_Align"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Language_Selector_Align"].Options = <?php echo json_encode($settings->Language_Selector_Align->Options()) ?>;
fsettingsedit.Lists["x_Show_Entire_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Entire_Footer[]"].Options = <?php echo json_encode($settings->Show_Entire_Footer->Options()) ?>;
fsettingsedit.Lists["x_Show_Text_In_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Text_In_Footer[]"].Options = <?php echo json_encode($settings->Show_Text_In_Footer->Options()) ?>;
fsettingsedit.Lists["x_Show_Back_To_Top_On_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Back_To_Top_On_Footer[]"].Options = <?php echo json_encode($settings->Show_Back_To_Top_On_Footer->Options()) ?>;
fsettingsedit.Lists["x_Show_Terms_And_Conditions_On_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Terms_And_Conditions_On_Footer[]"].Options = <?php echo json_encode($settings->Show_Terms_And_Conditions_On_Footer->Options()) ?>;
fsettingsedit.Lists["x_Show_About_Us_On_Footer[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_About_Us_On_Footer[]"].Options = <?php echo json_encode($settings->Show_About_Us_On_Footer->Options()) ?>;
fsettingsedit.Lists["x_Pagination_Position"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Pagination_Position"].Options = <?php echo json_encode($settings->Pagination_Position->Options()) ?>;
fsettingsedit.Lists["x_Pagination_Style"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Pagination_Style"].Options = <?php echo json_encode($settings->Pagination_Style->Options()) ?>;
fsettingsedit.Lists["x_Show_PageNum_If_Record_Not_Over_Pagesize[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_PageNum_If_Record_Not_Over_Pagesize[]"].Options = <?php echo json_encode($settings->Show_PageNum_If_Record_Not_Over_Pagesize->Options()) ?>;
fsettingsedit.Lists["x_Table_Width_Style"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Table_Width_Style"].Options = <?php echo json_encode($settings->Table_Width_Style->Options()) ?>;
fsettingsedit.Lists["x_Search_Panel_Collapsed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Search_Panel_Collapsed[]"].Options = <?php echo json_encode($settings->Search_Panel_Collapsed->Options()) ?>;
fsettingsedit.Lists["x_Filter_Panel_Collapsed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Filter_Panel_Collapsed[]"].Options = <?php echo json_encode($settings->Filter_Panel_Collapsed->Options()) ?>;
fsettingsedit.Lists["x_Show_Record_Number_On_List_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Record_Number_On_List_Page[]"].Options = <?php echo json_encode($settings->Show_Record_Number_On_List_Page->Options()) ?>;
fsettingsedit.Lists["x_Show_Empty_Table_On_List_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Empty_Table_On_List_Page[]"].Options = <?php echo json_encode($settings->Show_Empty_Table_On_List_Page->Options()) ?>;
fsettingsedit.Lists["x_Rows_Vertical_Align_Top[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Rows_Vertical_Align_Top[]"].Options = <?php echo json_encode($settings->Rows_Vertical_Align_Top->Options()) ?>;
fsettingsedit.Lists["x_Action_Button_Alignment"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Action_Button_Alignment"].Options = <?php echo json_encode($settings->Action_Button_Alignment->Options()) ?>;
fsettingsedit.Lists["x_Show_Add_Success_Message[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Add_Success_Message[]"].Options = <?php echo json_encode($settings->Show_Add_Success_Message->Options()) ?>;
fsettingsedit.Lists["x_Show_Edit_Success_Message[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Edit_Success_Message[]"].Options = <?php echo json_encode($settings->Show_Edit_Success_Message->Options()) ?>;
fsettingsedit.Lists["x_jQuery_Auto_Hide_Success_Message[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_jQuery_Auto_Hide_Success_Message[]"].Options = <?php echo json_encode($settings->jQuery_Auto_Hide_Success_Message->Options()) ?>;
fsettingsedit.Lists["x_Use_Javascript_Message[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Use_Javascript_Message[]"].Options = <?php echo json_encode($settings->Use_Javascript_Message->Options()) ?>;
fsettingsedit.Lists["x_Login_Window_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Login_Window_Type"].Options = <?php echo json_encode($settings->Login_Window_Type->Options()) ?>;
fsettingsedit.Lists["x_Forgot_Password_Window_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Forgot_Password_Window_Type"].Options = <?php echo json_encode($settings->Forgot_Password_Window_Type->Options()) ?>;
fsettingsedit.Lists["x_Change_Password_Window_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Change_Password_Window_Type"].Options = <?php echo json_encode($settings->Change_Password_Window_Type->Options()) ?>;
fsettingsedit.Lists["x_Registration_Window_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Registration_Window_Type"].Options = <?php echo json_encode($settings->Registration_Window_Type->Options()) ?>;
fsettingsedit.Lists["x_Show_Record_Number_On_Detail_Preview[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Record_Number_On_Detail_Preview[]"].Options = <?php echo json_encode($settings->Show_Record_Number_On_Detail_Preview->Options()) ?>;
fsettingsedit.Lists["x_Show_Empty_Table_In_Detail_Preview[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Empty_Table_In_Detail_Preview[]"].Options = <?php echo json_encode($settings->Show_Empty_Table_In_Detail_Preview->Options()) ?>;
fsettingsedit.Lists["x_Password_Must_Contain_At_Least_One_Lower_Case[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Password_Must_Contain_At_Least_One_Lower_Case[]"].Options = <?php echo json_encode($settings->Password_Must_Contain_At_Least_One_Lower_Case->Options()) ?>;
fsettingsedit.Lists["x_Password_Must_Comply_With_Minumum_Length[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Password_Must_Comply_With_Minumum_Length[]"].Options = <?php echo json_encode($settings->Password_Must_Comply_With_Minumum_Length->Options()) ?>;
fsettingsedit.Lists["x_Password_Must_Comply_With_Maximum_Length[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Password_Must_Comply_With_Maximum_Length[]"].Options = <?php echo json_encode($settings->Password_Must_Comply_With_Maximum_Length->Options()) ?>;
fsettingsedit.Lists["x_Password_Must_Contain_At_Least_One_Upper_Case[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Password_Must_Contain_At_Least_One_Upper_Case[]"].Options = <?php echo json_encode($settings->Password_Must_Contain_At_Least_One_Upper_Case->Options()) ?>;
fsettingsedit.Lists["x_Password_Must_Contain_At_Least_One_Numeric[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Password_Must_Contain_At_Least_One_Numeric[]"].Options = <?php echo json_encode($settings->Password_Must_Contain_At_Least_One_Numeric->Options()) ?>;
fsettingsedit.Lists["x_Password_Must_Contain_At_Least_One_Symbol[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Password_Must_Contain_At_Least_One_Symbol[]"].Options = <?php echo json_encode($settings->Password_Must_Contain_At_Least_One_Symbol->Options()) ?>;
fsettingsedit.Lists["x_Password_Must_Be_Difference_Between_Old_And_New[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Password_Must_Be_Difference_Between_Old_And_New[]"].Options = <?php echo json_encode($settings->Password_Must_Be_Difference_Between_Old_And_New->Options()) ?>;
fsettingsedit.Lists["x_Reset_Password_Field_Options"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Reset_Password_Field_Options"].Options = <?php echo json_encode($settings->Reset_Password_Field_Options->Options()) ?>;
fsettingsedit.Lists["x_Export_Record_Options"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Export_Record_Options"].Options = <?php echo json_encode($settings->Export_Record_Options->Options()) ?>;
fsettingsedit.Lists["x_Show_Record_Number_On_Exported_List_Page[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Show_Record_Number_On_Exported_List_Page[]"].Options = <?php echo json_encode($settings->Show_Record_Number_On_Exported_List_Page->Options()) ?>;
fsettingsedit.Lists["x_Use_Table_Setting_For_Export_Field_Caption[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Use_Table_Setting_For_Export_Field_Caption[]"].Options = <?php echo json_encode($settings->Use_Table_Setting_For_Export_Field_Caption->Options()) ?>;
fsettingsedit.Lists["x_Use_Table_Setting_For_Export_Original_Value[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsettingsedit.Lists["x_Use_Table_Setting_For_Export_Original_Value[]"].Options = <?php echo json_encode($settings->Use_Table_Setting_For_Export_Original_Value->Options()) ?>;

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
<?php $settings_edit->ShowPageHeader(); ?>
<?php
$settings_edit->ShowMessage();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($settings_edit->Pager)) $settings_edit->Pager = new cNumericPager($settings_edit->StartRec, $settings_edit->DisplayRecs, $settings_edit->TotalRecs, $settings_edit->RecRange) ?>
		<?php if ($settings_edit->Pager->RecordCount > 0) { ?>
				<?php if (($settings_edit->Pager->PageCount==1) && ($settings_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($settings_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($settings_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $settings_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($settings_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($settings_edit->Pager)) $settings_edit->Pager = new cPrevNextPager($settings_edit->StartRec, $settings_edit->DisplayRecs, $settings_edit->TotalRecs) ?>
		<?php if ($settings_edit->Pager->RecordCount > 0) { ?>
				<?php if (($settings_edit->Pager->PageCount==1) && ($settings_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($settings_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($settings_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				</div>
				<!--current page number-->
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $settings_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($settings_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($settings_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				</div>
				</div>
				</div>
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $settings_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
</form>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="fsettingsedit" id="fsettingsedit" class="<?php echo $settings_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($settings_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $settings_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="settings">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div class="ewMultiPage">
<div class="tabbable" id="settings_edit">
	<ul class="nav<?php echo $settings_edit->MultiPages->NavStyle() ?>">
		<li<?php echo $settings_edit->MultiPages->TabStyle("1") ?>><a href="#tab_settings1" data-toggle="tab"><?php echo $settings->PageCaption(1) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("2") ?>><a href="#tab_settings2" data-toggle="tab"><?php echo $settings->PageCaption(2) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("3") ?>><a href="#tab_settings3" data-toggle="tab"><?php echo $settings->PageCaption(3) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("4") ?>><a href="#tab_settings4" data-toggle="tab"><?php echo $settings->PageCaption(4) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("5") ?>><a href="#tab_settings5" data-toggle="tab"><?php echo $settings->PageCaption(5) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("6") ?>><a href="#tab_settings6" data-toggle="tab"><?php echo $settings->PageCaption(6) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("7") ?>><a href="#tab_settings7" data-toggle="tab"><?php echo $settings->PageCaption(7) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("8") ?>><a href="#tab_settings8" data-toggle="tab"><?php echo $settings->PageCaption(8) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("9") ?>><a href="#tab_settings9" data-toggle="tab"><?php echo $settings->PageCaption(9) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("10") ?>><a href="#tab_settings10" data-toggle="tab"><?php echo $settings->PageCaption(10) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("11") ?>><a href="#tab_settings11" data-toggle="tab"><?php echo $settings->PageCaption(11) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("12") ?>><a href="#tab_settings12" data-toggle="tab"><?php echo $settings->PageCaption(12) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("13") ?>><a href="#tab_settings13" data-toggle="tab"><?php echo $settings->PageCaption(13) ?></a></li>
		<li<?php echo $settings_edit->MultiPages->TabStyle("14") ?>><a href="#tab_settings14" data-toggle="tab"><?php echo $settings->PageCaption(14) ?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("1") ?>" id="tab_settings1">
<div>
<?php if ($settings->Option_ID->Visible) { // Option_ID ?>
	<div id="r_Option_ID" class="form-group">
		<label id="elh_settings_Option_ID" class="col-sm-4 control-label ewLabel"><?php echo $settings->Option_ID->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Option_ID->CellAttributes() ?>>
<span id="el_settings_Option_ID">
<span<?php echo $settings->Option_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $settings->Option_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="settings" data-field="x_Option_ID" data-page="1" name="x_Option_ID" id="x_Option_ID" value="<?php echo ew_HtmlEncode($settings->Option_ID->CurrentValue) ?>">
<?php echo $settings->Option_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Option_Default->Visible) { // Option_Default ?>
	<div id="r_Option_Default" class="form-group">
		<label id="elh_settings_Option_Default" class="col-sm-4 control-label ewLabel"><?php echo $settings->Option_Default->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Option_Default->CellAttributes() ?>>
<span id="el_settings_Option_Default">
<?php
$selwrk = (ew_ConvertToBool($settings->Option_Default->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Option_Default" data-page="1" name="x_Option_Default[]" id="x_Option_Default[]" value="1"<?php echo $selwrk ?><?php echo $settings->Option_Default->EditAttributes() ?>>
</span>
<?php echo $settings->Option_Default->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Theme->Visible) { // Default_Theme ?>
	<div id="r_Default_Theme" class="form-group">
		<label id="elh_settings_Default_Theme" for="x_Default_Theme" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Theme->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Theme->CellAttributes() ?>>
<span id="el_settings_Default_Theme">
<select data-table="settings" data-field="x_Default_Theme" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Default_Theme->DisplayValueSeparator) ? json_encode($settings->Default_Theme->DisplayValueSeparator) : $settings->Default_Theme->DisplayValueSeparator) ?>" id="x_Default_Theme" name="x_Default_Theme"<?php echo $settings->Default_Theme->EditAttributes() ?>>
<?php
if (is_array($settings->Default_Theme->EditValue)) {
	$arwrk = $settings->Default_Theme->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($settings->Default_Theme->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $settings->Default_Theme->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($settings->Default_Theme->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($settings->Default_Theme->CurrentValue) ?>" selected><?php echo $settings->Default_Theme->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
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
$settings->Default_Theme->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$settings->Default_Theme->LookupFilters += array("f0" => "`Theme_ID` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$settings->Lookup_Selecting($settings->Default_Theme, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Theme_ID`";
if ($sSqlWrk <> "") $settings->Default_Theme->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Default_Theme" id="s_x_Default_Theme" value="<?php echo $settings->Default_Theme->LookupFilterQuery() ?>">
</span>
<?php echo $settings->Default_Theme->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Font_Name->Visible) { // Font_Name ?>
	<div id="r_Font_Name" class="form-group">
		<label id="elh_settings_Font_Name" for="x_Font_Name" class="col-sm-4 control-label ewLabel"><?php echo $settings->Font_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Font_Name->CellAttributes() ?>>
<span id="el_settings_Font_Name">
<select data-table="settings" data-field="x_Font_Name" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Font_Name->DisplayValueSeparator) ? json_encode($settings->Font_Name->DisplayValueSeparator) : $settings->Font_Name->DisplayValueSeparator) ?>" id="x_Font_Name" name="x_Font_Name"<?php echo $settings->Font_Name->EditAttributes() ?>>
<?php
if (is_array($settings->Font_Name->EditValue)) {
	$arwrk = $settings->Font_Name->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($settings->Font_Name->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $settings->Font_Name->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($settings->Font_Name->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($settings->Font_Name->CurrentValue) ?>" selected><?php echo $settings->Font_Name->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $settings->Font_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Font_Size->Visible) { // Font_Size ?>
	<div id="r_Font_Size" class="form-group">
		<label id="elh_settings_Font_Size" for="x_Font_Size" class="col-sm-4 control-label ewLabel"><?php echo $settings->Font_Size->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Font_Size->CellAttributes() ?>>
<span id="el_settings_Font_Size">
<select data-table="settings" data-field="x_Font_Size" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Font_Size->DisplayValueSeparator) ? json_encode($settings->Font_Size->DisplayValueSeparator) : $settings->Font_Size->DisplayValueSeparator) ?>" id="x_Font_Size" name="x_Font_Size"<?php echo $settings->Font_Size->EditAttributes() ?>>
<?php
if (is_array($settings->Font_Size->EditValue)) {
	$arwrk = $settings->Font_Size->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($settings->Font_Size->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $settings->Font_Size->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($settings->Font_Size->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($settings->Font_Size->CurrentValue) ?>" selected><?php echo $settings->Font_Size->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $settings->Font_Size->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Border_Layout->Visible) { // Show_Border_Layout ?>
	<div id="r_Show_Border_Layout" class="form-group">
		<label id="elh_settings_Show_Border_Layout" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Border_Layout->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Border_Layout->CellAttributes() ?>>
<span id="el_settings_Show_Border_Layout">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Border_Layout->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Border_Layout" data-page="1" name="x_Show_Border_Layout[]" id="x_Show_Border_Layout[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Border_Layout->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Border_Layout->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Shadow_Layout->Visible) { // Show_Shadow_Layout ?>
	<div id="r_Show_Shadow_Layout" class="form-group">
		<label id="elh_settings_Show_Shadow_Layout" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Shadow_Layout->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Shadow_Layout->CellAttributes() ?>>
<span id="el_settings_Show_Shadow_Layout">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Shadow_Layout->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Shadow_Layout" data-page="1" name="x_Show_Shadow_Layout[]" id="x_Show_Shadow_Layout[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Shadow_Layout->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Shadow_Layout->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Menu_Horizontal->Visible) { // Menu_Horizontal ?>
	<div id="r_Menu_Horizontal" class="form-group">
		<label id="elh_settings_Menu_Horizontal" class="col-sm-4 control-label ewLabel"><?php echo $settings->Menu_Horizontal->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Menu_Horizontal->CellAttributes() ?>>
<span id="el_settings_Menu_Horizontal">
<?php
$selwrk = (ew_ConvertToBool($settings->Menu_Horizontal->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Menu_Horizontal" data-page="1" name="x_Menu_Horizontal[]" id="x_Menu_Horizontal[]" value="1"<?php echo $selwrk ?><?php echo $settings->Menu_Horizontal->EditAttributes() ?>>
</span>
<?php echo $settings->Menu_Horizontal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Vertical_Menu_Width->Visible) { // Vertical_Menu_Width ?>
	<div id="r_Vertical_Menu_Width" class="form-group">
		<label id="elh_settings_Vertical_Menu_Width" for="x_Vertical_Menu_Width" class="col-sm-4 control-label ewLabel"><?php echo $settings->Vertical_Menu_Width->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Vertical_Menu_Width->CellAttributes() ?>>
<span id="el_settings_Vertical_Menu_Width">
<input type="text" data-table="settings" data-field="x_Vertical_Menu_Width" data-page="1" name="x_Vertical_Menu_Width" id="x_Vertical_Menu_Width" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($settings->Vertical_Menu_Width->getPlaceHolder()) ?>" value="<?php echo $settings->Vertical_Menu_Width->EditValue ?>"<?php echo $settings->Vertical_Menu_Width->EditAttributes() ?>>
</span>
<?php echo $settings->Vertical_Menu_Width->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Announcement->Visible) { // Show_Announcement ?>
	<div id="r_Show_Announcement" class="form-group">
		<label id="elh_settings_Show_Announcement" for="x_Show_Announcement" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Announcement->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Announcement->CellAttributes() ?>>
<span id="el_settings_Show_Announcement">
<select data-table="settings" data-field="x_Show_Announcement" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Show_Announcement->DisplayValueSeparator) ? json_encode($settings->Show_Announcement->DisplayValueSeparator) : $settings->Show_Announcement->DisplayValueSeparator) ?>" id="x_Show_Announcement" name="x_Show_Announcement"<?php echo $settings->Show_Announcement->EditAttributes() ?>>
<?php
if (is_array($settings->Show_Announcement->EditValue)) {
	$arwrk = $settings->Show_Announcement->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($settings->Show_Announcement->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $settings->Show_Announcement->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($settings->Show_Announcement->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($settings->Show_Announcement->CurrentValue) ?>" selected><?php echo $settings->Show_Announcement->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $settings->Show_Announcement->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Demo_Mode->Visible) { // Demo_Mode ?>
	<div id="r_Demo_Mode" class="form-group">
		<label id="elh_settings_Demo_Mode" class="col-sm-4 control-label ewLabel"><?php echo $settings->Demo_Mode->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Demo_Mode->CellAttributes() ?>>
<span id="el_settings_Demo_Mode">
<?php
$selwrk = (ew_ConvertToBool($settings->Demo_Mode->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Demo_Mode" data-page="1" name="x_Demo_Mode[]" id="x_Demo_Mode[]" value="1"<?php echo $selwrk ?><?php echo $settings->Demo_Mode->EditAttributes() ?>>
</span>
<?php echo $settings->Demo_Mode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Page_Processing_Time->Visible) { // Show_Page_Processing_Time ?>
	<div id="r_Show_Page_Processing_Time" class="form-group">
		<label id="elh_settings_Show_Page_Processing_Time" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Page_Processing_Time->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Page_Processing_Time->CellAttributes() ?>>
<span id="el_settings_Show_Page_Processing_Time">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Page_Processing_Time->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Page_Processing_Time" data-page="1" name="x_Show_Page_Processing_Time[]" id="x_Show_Page_Processing_Time[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Page_Processing_Time->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Page_Processing_Time->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Allow_User_Preferences->Visible) { // Allow_User_Preferences ?>
	<div id="r_Allow_User_Preferences" class="form-group">
		<label id="elh_settings_Allow_User_Preferences" class="col-sm-4 control-label ewLabel"><?php echo $settings->Allow_User_Preferences->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Allow_User_Preferences->CellAttributes() ?>>
<span id="el_settings_Allow_User_Preferences">
<?php
$selwrk = (ew_ConvertToBool($settings->Allow_User_Preferences->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Allow_User_Preferences" data-page="1" name="x_Allow_User_Preferences[]" id="x_Allow_User_Preferences[]" value="1"<?php echo $selwrk ?><?php echo $settings->Allow_User_Preferences->EditAttributes() ?>>
</span>
<?php echo $settings->Allow_User_Preferences->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("2") ?>" id="tab_settings2">
<div>
<?php if ($settings->SMTP_Server->Visible) { // SMTP_Server ?>
	<div id="r_SMTP_Server" class="form-group">
		<label id="elh_settings_SMTP_Server" for="x_SMTP_Server" class="col-sm-4 control-label ewLabel"><?php echo $settings->SMTP_Server->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->SMTP_Server->CellAttributes() ?>>
<span id="el_settings_SMTP_Server">
<input type="text" data-table="settings" data-field="x_SMTP_Server" data-page="2" name="x_SMTP_Server" id="x_SMTP_Server" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($settings->SMTP_Server->getPlaceHolder()) ?>" value="<?php echo $settings->SMTP_Server->EditValue ?>"<?php echo $settings->SMTP_Server->EditAttributes() ?>>
</span>
<?php echo $settings->SMTP_Server->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->SMTP_Server_Port->Visible) { // SMTP_Server_Port ?>
	<div id="r_SMTP_Server_Port" class="form-group">
		<label id="elh_settings_SMTP_Server_Port" for="x_SMTP_Server_Port" class="col-sm-4 control-label ewLabel"><?php echo $settings->SMTP_Server_Port->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->SMTP_Server_Port->CellAttributes() ?>>
<span id="el_settings_SMTP_Server_Port">
<input type="text" data-table="settings" data-field="x_SMTP_Server_Port" data-page="2" name="x_SMTP_Server_Port" id="x_SMTP_Server_Port" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($settings->SMTP_Server_Port->getPlaceHolder()) ?>" value="<?php echo $settings->SMTP_Server_Port->EditValue ?>"<?php echo $settings->SMTP_Server_Port->EditAttributes() ?>>
</span>
<?php echo $settings->SMTP_Server_Port->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->SMTP_Server_Username->Visible) { // SMTP_Server_Username ?>
	<div id="r_SMTP_Server_Username" class="form-group">
		<label id="elh_settings_SMTP_Server_Username" for="x_SMTP_Server_Username" class="col-sm-4 control-label ewLabel"><?php echo $settings->SMTP_Server_Username->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->SMTP_Server_Username->CellAttributes() ?>>
<span id="el_settings_SMTP_Server_Username">
<input type="text" data-table="settings" data-field="x_SMTP_Server_Username" data-page="2" name="x_SMTP_Server_Username" id="x_SMTP_Server_Username" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($settings->SMTP_Server_Username->getPlaceHolder()) ?>" value="<?php echo $settings->SMTP_Server_Username->EditValue ?>"<?php echo $settings->SMTP_Server_Username->EditAttributes() ?>>
</span>
<?php echo $settings->SMTP_Server_Username->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->SMTP_Server_Password->Visible) { // SMTP_Server_Password ?>
	<div id="r_SMTP_Server_Password" class="form-group">
		<label id="elh_settings_SMTP_Server_Password" for="x_SMTP_Server_Password" class="col-sm-4 control-label ewLabel"><?php echo $settings->SMTP_Server_Password->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->SMTP_Server_Password->CellAttributes() ?>>
<span id="el_settings_SMTP_Server_Password">
<input type="text" data-table="settings" data-field="x_SMTP_Server_Password" data-page="2" name="x_SMTP_Server_Password" id="x_SMTP_Server_Password" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($settings->SMTP_Server_Password->getPlaceHolder()) ?>" value="<?php echo $settings->SMTP_Server_Password->EditValue ?>"<?php echo $settings->SMTP_Server_Password->EditAttributes() ?>>
</span>
<?php echo $settings->SMTP_Server_Password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Sender_Email->Visible) { // Sender_Email ?>
	<div id="r_Sender_Email" class="form-group">
		<label id="elh_settings_Sender_Email" for="x_Sender_Email" class="col-sm-4 control-label ewLabel"><?php echo $settings->Sender_Email->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Sender_Email->CellAttributes() ?>>
<span id="el_settings_Sender_Email">
<input type="text" data-table="settings" data-field="x_Sender_Email" data-page="2" name="x_Sender_Email" id="x_Sender_Email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($settings->Sender_Email->getPlaceHolder()) ?>" value="<?php echo $settings->Sender_Email->EditValue ?>"<?php echo $settings->Sender_Email->EditAttributes() ?>>
</span>
<?php echo $settings->Sender_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Recipient_Email->Visible) { // Recipient_Email ?>
	<div id="r_Recipient_Email" class="form-group">
		<label id="elh_settings_Recipient_Email" for="x_Recipient_Email" class="col-sm-4 control-label ewLabel"><?php echo $settings->Recipient_Email->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Recipient_Email->CellAttributes() ?>>
<span id="el_settings_Recipient_Email">
<input type="text" data-table="settings" data-field="x_Recipient_Email" data-page="2" name="x_Recipient_Email" id="x_Recipient_Email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($settings->Recipient_Email->getPlaceHolder()) ?>" value="<?php echo $settings->Recipient_Email->EditValue ?>"<?php echo $settings->Recipient_Email->EditAttributes() ?>>
</span>
<?php echo $settings->Recipient_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("3") ?>" id="tab_settings3">
<div>
<?php if ($settings->Use_Default_Locale->Visible) { // Use_Default_Locale ?>
	<div id="r_Use_Default_Locale" class="form-group">
		<label id="elh_settings_Use_Default_Locale" class="col-sm-4 control-label ewLabel"><?php echo $settings->Use_Default_Locale->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Use_Default_Locale->CellAttributes() ?>>
<span id="el_settings_Use_Default_Locale">
<?php
$selwrk = (ew_ConvertToBool($settings->Use_Default_Locale->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Use_Default_Locale" data-page="3" name="x_Use_Default_Locale[]" id="x_Use_Default_Locale[]" value="1"<?php echo $selwrk ?><?php echo $settings->Use_Default_Locale->EditAttributes() ?>>
</span>
<?php echo $settings->Use_Default_Locale->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Language->Visible) { // Default_Language ?>
	<div id="r_Default_Language" class="form-group">
		<label id="elh_settings_Default_Language" for="x_Default_Language" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Language->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Language->CellAttributes() ?>>
<span id="el_settings_Default_Language">
<select data-table="settings" data-field="x_Default_Language" data-page="3" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Default_Language->DisplayValueSeparator) ? json_encode($settings->Default_Language->DisplayValueSeparator) : $settings->Default_Language->DisplayValueSeparator) ?>" id="x_Default_Language" name="x_Default_Language"<?php echo $settings->Default_Language->EditAttributes() ?>>
<?php
if (is_array($settings->Default_Language->EditValue)) {
	$arwrk = $settings->Default_Language->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($settings->Default_Language->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $settings->Default_Language->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($settings->Default_Language->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($settings->Default_Language->CurrentValue) ?>" selected><?php echo $settings->Default_Language->CurrentValue ?></option>
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
$settings->Default_Language->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$settings->Default_Language->LookupFilters += array("f0" => "`Language_Code` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$settings->Lookup_Selecting($settings->Default_Language, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $settings->Default_Language->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Default_Language" id="s_x_Default_Language" value="<?php echo $settings->Default_Language->LookupFilterQuery() ?>">
</span>
<?php echo $settings->Default_Language->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Timezone->Visible) { // Default_Timezone ?>
	<div id="r_Default_Timezone" class="form-group">
		<label id="elh_settings_Default_Timezone" for="x_Default_Timezone" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Timezone->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Timezone->CellAttributes() ?>>
<span id="el_settings_Default_Timezone">
<select data-table="settings" data-field="x_Default_Timezone" data-page="3" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Default_Timezone->DisplayValueSeparator) ? json_encode($settings->Default_Timezone->DisplayValueSeparator) : $settings->Default_Timezone->DisplayValueSeparator) ?>" id="x_Default_Timezone" name="x_Default_Timezone"<?php echo $settings->Default_Timezone->EditAttributes() ?>>
<?php
if (is_array($settings->Default_Timezone->EditValue)) {
	$arwrk = $settings->Default_Timezone->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($settings->Default_Timezone->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $settings->Default_Timezone->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($settings->Default_Timezone->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($settings->Default_Timezone->CurrentValue) ?>" selected><?php echo $settings->Default_Timezone->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Timezone`, `Timezone` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `timezone`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Timezone`, `Timezone` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `timezone`";
		$sWhereWrk = "";
		break;
}
$settings->Default_Timezone->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$settings->Default_Timezone->LookupFilters += array("f0" => "`Timezone` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$settings->Lookup_Selecting($settings->Default_Timezone, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $settings->Default_Timezone->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Default_Timezone" id="s_x_Default_Timezone" value="<?php echo $settings->Default_Timezone->LookupFilterQuery() ?>">
</span>
<?php echo $settings->Default_Timezone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Thousands_Separator->Visible) { // Default_Thousands_Separator ?>
	<div id="r_Default_Thousands_Separator" class="form-group">
		<label id="elh_settings_Default_Thousands_Separator" for="x_Default_Thousands_Separator" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Thousands_Separator->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Thousands_Separator->CellAttributes() ?>>
<span id="el_settings_Default_Thousands_Separator">
<input type="text" data-table="settings" data-field="x_Default_Thousands_Separator" data-page="3" name="x_Default_Thousands_Separator" id="x_Default_Thousands_Separator" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($settings->Default_Thousands_Separator->getPlaceHolder()) ?>" value="<?php echo $settings->Default_Thousands_Separator->EditValue ?>"<?php echo $settings->Default_Thousands_Separator->EditAttributes() ?>>
</span>
<?php echo $settings->Default_Thousands_Separator->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Decimal_Point->Visible) { // Default_Decimal_Point ?>
	<div id="r_Default_Decimal_Point" class="form-group">
		<label id="elh_settings_Default_Decimal_Point" for="x_Default_Decimal_Point" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Decimal_Point->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Decimal_Point->CellAttributes() ?>>
<span id="el_settings_Default_Decimal_Point">
<input type="text" data-table="settings" data-field="x_Default_Decimal_Point" data-page="3" name="x_Default_Decimal_Point" id="x_Default_Decimal_Point" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($settings->Default_Decimal_Point->getPlaceHolder()) ?>" value="<?php echo $settings->Default_Decimal_Point->EditValue ?>"<?php echo $settings->Default_Decimal_Point->EditAttributes() ?>>
</span>
<?php echo $settings->Default_Decimal_Point->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Currency_Symbol->Visible) { // Default_Currency_Symbol ?>
	<div id="r_Default_Currency_Symbol" class="form-group">
		<label id="elh_settings_Default_Currency_Symbol" for="x_Default_Currency_Symbol" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Currency_Symbol->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Currency_Symbol->CellAttributes() ?>>
<span id="el_settings_Default_Currency_Symbol">
<input type="text" data-table="settings" data-field="x_Default_Currency_Symbol" data-page="3" name="x_Default_Currency_Symbol" id="x_Default_Currency_Symbol" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($settings->Default_Currency_Symbol->getPlaceHolder()) ?>" value="<?php echo $settings->Default_Currency_Symbol->EditValue ?>"<?php echo $settings->Default_Currency_Symbol->EditAttributes() ?>>
</span>
<?php echo $settings->Default_Currency_Symbol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Money_Thousands_Separator->Visible) { // Default_Money_Thousands_Separator ?>
	<div id="r_Default_Money_Thousands_Separator" class="form-group">
		<label id="elh_settings_Default_Money_Thousands_Separator" for="x_Default_Money_Thousands_Separator" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Money_Thousands_Separator->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Money_Thousands_Separator->CellAttributes() ?>>
<span id="el_settings_Default_Money_Thousands_Separator">
<input type="text" data-table="settings" data-field="x_Default_Money_Thousands_Separator" data-page="3" name="x_Default_Money_Thousands_Separator" id="x_Default_Money_Thousands_Separator" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($settings->Default_Money_Thousands_Separator->getPlaceHolder()) ?>" value="<?php echo $settings->Default_Money_Thousands_Separator->EditValue ?>"<?php echo $settings->Default_Money_Thousands_Separator->EditAttributes() ?>>
</span>
<?php echo $settings->Default_Money_Thousands_Separator->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Money_Decimal_Point->Visible) { // Default_Money_Decimal_Point ?>
	<div id="r_Default_Money_Decimal_Point" class="form-group">
		<label id="elh_settings_Default_Money_Decimal_Point" for="x_Default_Money_Decimal_Point" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Money_Decimal_Point->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Money_Decimal_Point->CellAttributes() ?>>
<span id="el_settings_Default_Money_Decimal_Point">
<input type="text" data-table="settings" data-field="x_Default_Money_Decimal_Point" data-page="3" name="x_Default_Money_Decimal_Point" id="x_Default_Money_Decimal_Point" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($settings->Default_Money_Decimal_Point->getPlaceHolder()) ?>" value="<?php echo $settings->Default_Money_Decimal_Point->EditValue ?>"<?php echo $settings->Default_Money_Decimal_Point->EditAttributes() ?>>
</span>
<?php echo $settings->Default_Money_Decimal_Point->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("4") ?>" id="tab_settings4">
<div>
<?php if ($settings->Maintenance_Mode->Visible) { // Maintenance_Mode ?>
	<div id="r_Maintenance_Mode" class="form-group">
		<label id="elh_settings_Maintenance_Mode" class="col-sm-4 control-label ewLabel"><?php echo $settings->Maintenance_Mode->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Maintenance_Mode->CellAttributes() ?>>
<span id="el_settings_Maintenance_Mode">
<?php
$selwrk = (ew_ConvertToBool($settings->Maintenance_Mode->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Maintenance_Mode" data-page="4" name="x_Maintenance_Mode[]" id="x_Maintenance_Mode[]" value="1"<?php echo $selwrk ?><?php echo $settings->Maintenance_Mode->EditAttributes() ?>>
</span>
<?php echo $settings->Maintenance_Mode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Maintenance_Finish_DateTime->Visible) { // Maintenance_Finish_DateTime ?>
	<div id="r_Maintenance_Finish_DateTime" class="form-group">
		<label id="elh_settings_Maintenance_Finish_DateTime" for="x_Maintenance_Finish_DateTime" class="col-sm-4 control-label ewLabel"><?php echo $settings->Maintenance_Finish_DateTime->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Maintenance_Finish_DateTime->CellAttributes() ?>>
<span id="el_settings_Maintenance_Finish_DateTime">
<input type="text" data-table="settings" data-field="x_Maintenance_Finish_DateTime" data-page="4" data-format="9" name="x_Maintenance_Finish_DateTime" id="x_Maintenance_Finish_DateTime" placeholder="<?php echo ew_HtmlEncode($settings->Maintenance_Finish_DateTime->getPlaceHolder()) ?>" value="<?php echo $settings->Maintenance_Finish_DateTime->EditValue ?>"<?php echo $settings->Maintenance_Finish_DateTime->EditAttributes() ?>>
<?php if (!$settings->Maintenance_Finish_DateTime->ReadOnly && !$settings->Maintenance_Finish_DateTime->Disabled && !isset($settings->Maintenance_Finish_DateTime->EditAttrs["readonly"]) && !isset($settings->Maintenance_Finish_DateTime->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fsettingsedit", "x_Maintenance_Finish_DateTime", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php echo $settings->Maintenance_Finish_DateTime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Auto_Normal_After_Maintenance->Visible) { // Auto_Normal_After_Maintenance ?>
	<div id="r_Auto_Normal_After_Maintenance" class="form-group">
		<label id="elh_settings_Auto_Normal_After_Maintenance" class="col-sm-4 control-label ewLabel"><?php echo $settings->Auto_Normal_After_Maintenance->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Auto_Normal_After_Maintenance->CellAttributes() ?>>
<span id="el_settings_Auto_Normal_After_Maintenance">
<?php
$selwrk = (ew_ConvertToBool($settings->Auto_Normal_After_Maintenance->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Auto_Normal_After_Maintenance" data-page="4" name="x_Auto_Normal_After_Maintenance[]" id="x_Auto_Normal_After_Maintenance[]" value="1"<?php echo $selwrk ?><?php echo $settings->Auto_Normal_After_Maintenance->EditAttributes() ?>>
</span>
<?php echo $settings->Auto_Normal_After_Maintenance->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("5") ?>" id="tab_settings5">
<div>
<?php if ($settings->Allow_User_To_Register->Visible) { // Allow_User_To_Register ?>
	<div id="r_Allow_User_To_Register" class="form-group">
		<label id="elh_settings_Allow_User_To_Register" class="col-sm-4 control-label ewLabel"><?php echo $settings->Allow_User_To_Register->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Allow_User_To_Register->CellAttributes() ?>>
<span id="el_settings_Allow_User_To_Register">
<?php
$selwrk = (ew_ConvertToBool($settings->Allow_User_To_Register->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Allow_User_To_Register" data-page="5" name="x_Allow_User_To_Register[]" id="x_Allow_User_To_Register[]" value="1"<?php echo $selwrk ?><?php echo $settings->Allow_User_To_Register->EditAttributes() ?>>
</span>
<?php echo $settings->Allow_User_To_Register->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Suspend_New_User_Account->Visible) { // Suspend_New_User_Account ?>
	<div id="r_Suspend_New_User_Account" class="form-group">
		<label id="elh_settings_Suspend_New_User_Account" class="col-sm-4 control-label ewLabel"><?php echo $settings->Suspend_New_User_Account->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Suspend_New_User_Account->CellAttributes() ?>>
<span id="el_settings_Suspend_New_User_Account">
<?php
$selwrk = (ew_ConvertToBool($settings->Suspend_New_User_Account->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Suspend_New_User_Account" data-page="5" name="x_Suspend_New_User_Account[]" id="x_Suspend_New_User_Account[]" value="1"<?php echo $selwrk ?><?php echo $settings->Suspend_New_User_Account->EditAttributes() ?>>
</span>
<?php echo $settings->Suspend_New_User_Account->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->User_Need_Activation_After_Registered->Visible) { // User_Need_Activation_After_Registered ?>
	<div id="r_User_Need_Activation_After_Registered" class="form-group">
		<label id="elh_settings_User_Need_Activation_After_Registered" class="col-sm-4 control-label ewLabel"><?php echo $settings->User_Need_Activation_After_Registered->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->User_Need_Activation_After_Registered->CellAttributes() ?>>
<span id="el_settings_User_Need_Activation_After_Registered">
<?php
$selwrk = (ew_ConvertToBool($settings->User_Need_Activation_After_Registered->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_User_Need_Activation_After_Registered" data-page="5" name="x_User_Need_Activation_After_Registered[]" id="x_User_Need_Activation_After_Registered[]" value="1"<?php echo $selwrk ?><?php echo $settings->User_Need_Activation_After_Registered->EditAttributes() ?>>
</span>
<?php echo $settings->User_Need_Activation_After_Registered->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Captcha_On_Registration_Page->Visible) { // Show_Captcha_On_Registration_Page ?>
	<div id="r_Show_Captcha_On_Registration_Page" class="form-group">
		<label id="elh_settings_Show_Captcha_On_Registration_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Captcha_On_Registration_Page->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Captcha_On_Registration_Page->CellAttributes() ?>>
<span id="el_settings_Show_Captcha_On_Registration_Page">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Captcha_On_Registration_Page->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Captcha_On_Registration_Page" data-page="5" name="x_Show_Captcha_On_Registration_Page[]" id="x_Show_Captcha_On_Registration_Page[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Captcha_On_Registration_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Captcha_On_Registration_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Terms_And_Conditions_On_Registration_Page->Visible) { // Show_Terms_And_Conditions_On_Registration_Page ?>
	<div id="r_Show_Terms_And_Conditions_On_Registration_Page" class="form-group">
		<label id="elh_settings_Show_Terms_And_Conditions_On_Registration_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Terms_And_Conditions_On_Registration_Page->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Terms_And_Conditions_On_Registration_Page->CellAttributes() ?>>
<span id="el_settings_Show_Terms_And_Conditions_On_Registration_Page">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Terms_And_Conditions_On_Registration_Page->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Terms_And_Conditions_On_Registration_Page" data-page="5" name="x_Show_Terms_And_Conditions_On_Registration_Page[]" id="x_Show_Terms_And_Conditions_On_Registration_Page[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Terms_And_Conditions_On_Registration_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Terms_And_Conditions_On_Registration_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->User_Auto_Login_After_Activation_Or_Registration->Visible) { // User_Auto_Login_After_Activation_Or_Registration ?>
	<div id="r_User_Auto_Login_After_Activation_Or_Registration" class="form-group">
		<label id="elh_settings_User_Auto_Login_After_Activation_Or_Registration" class="col-sm-4 control-label ewLabel"><?php echo $settings->User_Auto_Login_After_Activation_Or_Registration->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->User_Auto_Login_After_Activation_Or_Registration->CellAttributes() ?>>
<span id="el_settings_User_Auto_Login_After_Activation_Or_Registration">
<?php
$selwrk = (ew_ConvertToBool($settings->User_Auto_Login_After_Activation_Or_Registration->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_User_Auto_Login_After_Activation_Or_Registration" data-page="5" name="x_User_Auto_Login_After_Activation_Or_Registration[]" id="x_User_Auto_Login_After_Activation_Or_Registration[]" value="1"<?php echo $selwrk ?><?php echo $settings->User_Auto_Login_After_Activation_Or_Registration->EditAttributes() ?>>
</span>
<?php echo $settings->User_Auto_Login_After_Activation_Or_Registration->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("6") ?>" id="tab_settings6">
<div>
<?php if ($settings->Show_Captcha_On_Login_Page->Visible) { // Show_Captcha_On_Login_Page ?>
	<div id="r_Show_Captcha_On_Login_Page" class="form-group">
		<label id="elh_settings_Show_Captcha_On_Login_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Captcha_On_Login_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Captcha_On_Login_Page->CellAttributes() ?>>
<span id="el_settings_Show_Captcha_On_Login_Page">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Captcha_On_Login_Page->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Captcha_On_Login_Page" data-page="6" name="x_Show_Captcha_On_Login_Page[]" id="x_Show_Captcha_On_Login_Page[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Captcha_On_Login_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Captcha_On_Login_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Captcha_On_Forgot_Password_Page->Visible) { // Show_Captcha_On_Forgot_Password_Page ?>
	<div id="r_Show_Captcha_On_Forgot_Password_Page" class="form-group">
		<label id="elh_settings_Show_Captcha_On_Forgot_Password_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Captcha_On_Forgot_Password_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Captcha_On_Forgot_Password_Page->CellAttributes() ?>>
<span id="el_settings_Show_Captcha_On_Forgot_Password_Page">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Captcha_On_Forgot_Password_Page->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Captcha_On_Forgot_Password_Page" data-page="6" name="x_Show_Captcha_On_Forgot_Password_Page[]" id="x_Show_Captcha_On_Forgot_Password_Page[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Captcha_On_Forgot_Password_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Captcha_On_Forgot_Password_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Captcha_On_Change_Password_Page->Visible) { // Show_Captcha_On_Change_Password_Page ?>
	<div id="r_Show_Captcha_On_Change_Password_Page" class="form-group">
		<label id="elh_settings_Show_Captcha_On_Change_Password_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Captcha_On_Change_Password_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Captcha_On_Change_Password_Page->CellAttributes() ?>>
<span id="el_settings_Show_Captcha_On_Change_Password_Page">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Captcha_On_Change_Password_Page->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Captcha_On_Change_Password_Page" data-page="6" name="x_Show_Captcha_On_Change_Password_Page[]" id="x_Show_Captcha_On_Change_Password_Page[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Captcha_On_Change_Password_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Captcha_On_Change_Password_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->User_Auto_Logout_After_Idle_In_Minutes->Visible) { // User_Auto_Logout_After_Idle_In_Minutes ?>
	<div id="r_User_Auto_Logout_After_Idle_In_Minutes" class="form-group">
		<label id="elh_settings_User_Auto_Logout_After_Idle_In_Minutes" for="x_User_Auto_Logout_After_Idle_In_Minutes" class="col-sm-4 control-label ewLabel"><?php echo $settings->User_Auto_Logout_After_Idle_In_Minutes->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->User_Auto_Logout_After_Idle_In_Minutes->CellAttributes() ?>>
<span id="el_settings_User_Auto_Logout_After_Idle_In_Minutes">
<input type="text" data-table="settings" data-field="x_User_Auto_Logout_After_Idle_In_Minutes" data-page="6" name="x_User_Auto_Logout_After_Idle_In_Minutes" id="x_User_Auto_Logout_After_Idle_In_Minutes" size="30" placeholder="<?php echo ew_HtmlEncode($settings->User_Auto_Logout_After_Idle_In_Minutes->getPlaceHolder()) ?>" value="<?php echo $settings->User_Auto_Logout_After_Idle_In_Minutes->EditValue ?>"<?php echo $settings->User_Auto_Logout_After_Idle_In_Minutes->EditAttributes() ?>>
</span>
<?php echo $settings->User_Auto_Logout_After_Idle_In_Minutes->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->User_Login_Maximum_Retry->Visible) { // User_Login_Maximum_Retry ?>
	<div id="r_User_Login_Maximum_Retry" class="form-group">
		<label id="elh_settings_User_Login_Maximum_Retry" for="x_User_Login_Maximum_Retry" class="col-sm-4 control-label ewLabel"><?php echo $settings->User_Login_Maximum_Retry->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->User_Login_Maximum_Retry->CellAttributes() ?>>
<span id="el_settings_User_Login_Maximum_Retry">
<input type="text" data-table="settings" data-field="x_User_Login_Maximum_Retry" data-page="6" name="x_User_Login_Maximum_Retry" id="x_User_Login_Maximum_Retry" size="30" placeholder="<?php echo ew_HtmlEncode($settings->User_Login_Maximum_Retry->getPlaceHolder()) ?>" value="<?php echo $settings->User_Login_Maximum_Retry->EditValue ?>"<?php echo $settings->User_Login_Maximum_Retry->EditAttributes() ?>>
</span>
<?php echo $settings->User_Login_Maximum_Retry->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->User_Login_Retry_Lockout->Visible) { // User_Login_Retry_Lockout ?>
	<div id="r_User_Login_Retry_Lockout" class="form-group">
		<label id="elh_settings_User_Login_Retry_Lockout" for="x_User_Login_Retry_Lockout" class="col-sm-4 control-label ewLabel"><?php echo $settings->User_Login_Retry_Lockout->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->User_Login_Retry_Lockout->CellAttributes() ?>>
<span id="el_settings_User_Login_Retry_Lockout">
<input type="text" data-table="settings" data-field="x_User_Login_Retry_Lockout" data-page="6" name="x_User_Login_Retry_Lockout" id="x_User_Login_Retry_Lockout" size="30" placeholder="<?php echo ew_HtmlEncode($settings->User_Login_Retry_Lockout->getPlaceHolder()) ?>" value="<?php echo $settings->User_Login_Retry_Lockout->EditValue ?>"<?php echo $settings->User_Login_Retry_Lockout->EditAttributes() ?>>
</span>
<?php echo $settings->User_Login_Retry_Lockout->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Redirect_To_Last_Visited_Page_After_Login->Visible) { // Redirect_To_Last_Visited_Page_After_Login ?>
	<div id="r_Redirect_To_Last_Visited_Page_After_Login" class="form-group">
		<label id="elh_settings_Redirect_To_Last_Visited_Page_After_Login" class="col-sm-4 control-label ewLabel"><?php echo $settings->Redirect_To_Last_Visited_Page_After_Login->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Redirect_To_Last_Visited_Page_After_Login->CellAttributes() ?>>
<span id="el_settings_Redirect_To_Last_Visited_Page_After_Login">
<?php
$selwrk = (ew_ConvertToBool($settings->Redirect_To_Last_Visited_Page_After_Login->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Redirect_To_Last_Visited_Page_After_Login" data-page="6" name="x_Redirect_To_Last_Visited_Page_After_Login[]" id="x_Redirect_To_Last_Visited_Page_After_Login[]" value="1"<?php echo $selwrk ?><?php echo $settings->Redirect_To_Last_Visited_Page_After_Login->EditAttributes() ?>>
</span>
<?php echo $settings->Redirect_To_Last_Visited_Page_After_Login->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Enable_Password_Expiry->Visible) { // Enable_Password_Expiry ?>
	<div id="r_Enable_Password_Expiry" class="form-group">
		<label id="elh_settings_Enable_Password_Expiry" class="col-sm-4 control-label ewLabel"><?php echo $settings->Enable_Password_Expiry->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Enable_Password_Expiry->CellAttributes() ?>>
<span id="el_settings_Enable_Password_Expiry">
<?php
$selwrk = (ew_ConvertToBool($settings->Enable_Password_Expiry->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Enable_Password_Expiry" data-page="6" name="x_Enable_Password_Expiry[]" id="x_Enable_Password_Expiry[]" value="1"<?php echo $selwrk ?><?php echo $settings->Enable_Password_Expiry->EditAttributes() ?>>
</span>
<?php echo $settings->Enable_Password_Expiry->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Password_Expiry_In_Days->Visible) { // Password_Expiry_In_Days ?>
	<div id="r_Password_Expiry_In_Days" class="form-group">
		<label id="elh_settings_Password_Expiry_In_Days" for="x_Password_Expiry_In_Days" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Expiry_In_Days->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Expiry_In_Days->CellAttributes() ?>>
<span id="el_settings_Password_Expiry_In_Days">
<input type="text" data-table="settings" data-field="x_Password_Expiry_In_Days" data-page="6" name="x_Password_Expiry_In_Days" id="x_Password_Expiry_In_Days" size="30" placeholder="<?php echo ew_HtmlEncode($settings->Password_Expiry_In_Days->getPlaceHolder()) ?>" value="<?php echo $settings->Password_Expiry_In_Days->EditValue ?>"<?php echo $settings->Password_Expiry_In_Days->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Expiry_In_Days->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("7") ?>" id="tab_settings7">
<div>
<?php if ($settings->Show_Entire_Header->Visible) { // Show_Entire_Header ?>
	<div id="r_Show_Entire_Header" class="form-group">
		<label id="elh_settings_Show_Entire_Header" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Entire_Header->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Entire_Header->CellAttributes() ?>>
<span id="el_settings_Show_Entire_Header">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Entire_Header->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Entire_Header" data-page="7" name="x_Show_Entire_Header[]" id="x_Show_Entire_Header[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Entire_Header->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Entire_Header->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Logo_Width->Visible) { // Logo_Width ?>
	<div id="r_Logo_Width" class="form-group">
		<label id="elh_settings_Logo_Width" for="x_Logo_Width" class="col-sm-4 control-label ewLabel"><?php echo $settings->Logo_Width->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Logo_Width->CellAttributes() ?>>
<span id="el_settings_Logo_Width">
<input type="text" data-table="settings" data-field="x_Logo_Width" data-page="7" name="x_Logo_Width" id="x_Logo_Width" size="30" placeholder="<?php echo ew_HtmlEncode($settings->Logo_Width->getPlaceHolder()) ?>" value="<?php echo $settings->Logo_Width->EditValue ?>"<?php echo $settings->Logo_Width->EditAttributes() ?>>
</span>
<?php echo $settings->Logo_Width->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Site_Title_In_Header->Visible) { // Show_Site_Title_In_Header ?>
	<div id="r_Show_Site_Title_In_Header" class="form-group">
		<label id="elh_settings_Show_Site_Title_In_Header" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Site_Title_In_Header->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Site_Title_In_Header->CellAttributes() ?>>
<span id="el_settings_Show_Site_Title_In_Header">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Site_Title_In_Header->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Site_Title_In_Header" data-page="7" name="x_Show_Site_Title_In_Header[]" id="x_Show_Site_Title_In_Header[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Site_Title_In_Header->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Site_Title_In_Header->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Current_User_In_Header->Visible) { // Show_Current_User_In_Header ?>
	<div id="r_Show_Current_User_In_Header" class="form-group">
		<label id="elh_settings_Show_Current_User_In_Header" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Current_User_In_Header->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Current_User_In_Header->CellAttributes() ?>>
<span id="el_settings_Show_Current_User_In_Header">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Current_User_In_Header->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Current_User_In_Header" data-page="7" name="x_Show_Current_User_In_Header[]" id="x_Show_Current_User_In_Header[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Current_User_In_Header->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Current_User_In_Header->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Text_Align_In_Header->Visible) { // Text_Align_In_Header ?>
	<div id="r_Text_Align_In_Header" class="form-group">
		<label id="elh_settings_Text_Align_In_Header" class="col-sm-4 control-label ewLabel"><?php echo $settings->Text_Align_In_Header->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Text_Align_In_Header->CellAttributes() ?>>
<span id="el_settings_Text_Align_In_Header">
<div id="tp_x_Text_Align_In_Header" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Text_Align_In_Header" data-page="7" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Text_Align_In_Header->DisplayValueSeparator) ? json_encode($settings->Text_Align_In_Header->DisplayValueSeparator) : $settings->Text_Align_In_Header->DisplayValueSeparator) ?>" name="x_Text_Align_In_Header" id="x_Text_Align_In_Header" value="{value}"<?php echo $settings->Text_Align_In_Header->EditAttributes() ?>></div>
<div id="dsl_x_Text_Align_In_Header" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Text_Align_In_Header->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Text_Align_In_Header->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Text_Align_In_Header" data-page="7" name="x_Text_Align_In_Header" id="x_Text_Align_In_Header_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Text_Align_In_Header->EditAttributes() ?>><?php echo $settings->Text_Align_In_Header->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Text_Align_In_Header->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Text_Align_In_Header" data-page="7" name="x_Text_Align_In_Header" id="x_Text_Align_In_Header_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Text_Align_In_Header->CurrentValue) ?>" checked<?php echo $settings->Text_Align_In_Header->EditAttributes() ?>><?php echo $settings->Text_Align_In_Header->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Text_Align_In_Header->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Site_Title_Text_Style->Visible) { // Site_Title_Text_Style ?>
	<div id="r_Site_Title_Text_Style" class="form-group">
		<label id="elh_settings_Site_Title_Text_Style" class="col-sm-4 control-label ewLabel"><?php echo $settings->Site_Title_Text_Style->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Site_Title_Text_Style->CellAttributes() ?>>
<span id="el_settings_Site_Title_Text_Style">
<div id="tp_x_Site_Title_Text_Style" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Site_Title_Text_Style" data-page="7" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Site_Title_Text_Style->DisplayValueSeparator) ? json_encode($settings->Site_Title_Text_Style->DisplayValueSeparator) : $settings->Site_Title_Text_Style->DisplayValueSeparator) ?>" name="x_Site_Title_Text_Style" id="x_Site_Title_Text_Style" value="{value}"<?php echo $settings->Site_Title_Text_Style->EditAttributes() ?>></div>
<div id="dsl_x_Site_Title_Text_Style" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Site_Title_Text_Style->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Site_Title_Text_Style->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Site_Title_Text_Style" data-page="7" name="x_Site_Title_Text_Style" id="x_Site_Title_Text_Style_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Site_Title_Text_Style->EditAttributes() ?>><?php echo $settings->Site_Title_Text_Style->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Site_Title_Text_Style->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Site_Title_Text_Style" data-page="7" name="x_Site_Title_Text_Style" id="x_Site_Title_Text_Style_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Site_Title_Text_Style->CurrentValue) ?>" checked<?php echo $settings->Site_Title_Text_Style->EditAttributes() ?>><?php echo $settings->Site_Title_Text_Style->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Site_Title_Text_Style->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Language_Selector_Visibility->Visible) { // Language_Selector_Visibility ?>
	<div id="r_Language_Selector_Visibility" class="form-group">
		<label id="elh_settings_Language_Selector_Visibility" class="col-sm-4 control-label ewLabel"><?php echo $settings->Language_Selector_Visibility->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Language_Selector_Visibility->CellAttributes() ?>>
<span id="el_settings_Language_Selector_Visibility">
<div id="tp_x_Language_Selector_Visibility" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Language_Selector_Visibility" data-page="7" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Language_Selector_Visibility->DisplayValueSeparator) ? json_encode($settings->Language_Selector_Visibility->DisplayValueSeparator) : $settings->Language_Selector_Visibility->DisplayValueSeparator) ?>" name="x_Language_Selector_Visibility" id="x_Language_Selector_Visibility" value="{value}"<?php echo $settings->Language_Selector_Visibility->EditAttributes() ?>></div>
<div id="dsl_x_Language_Selector_Visibility" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Language_Selector_Visibility->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Language_Selector_Visibility->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Language_Selector_Visibility" data-page="7" name="x_Language_Selector_Visibility" id="x_Language_Selector_Visibility_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Language_Selector_Visibility->EditAttributes() ?>><?php echo $settings->Language_Selector_Visibility->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Language_Selector_Visibility->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Language_Selector_Visibility" data-page="7" name="x_Language_Selector_Visibility" id="x_Language_Selector_Visibility_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Language_Selector_Visibility->CurrentValue) ?>" checked<?php echo $settings->Language_Selector_Visibility->EditAttributes() ?>><?php echo $settings->Language_Selector_Visibility->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Language_Selector_Visibility->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Language_Selector_Align->Visible) { // Language_Selector_Align ?>
	<div id="r_Language_Selector_Align" class="form-group">
		<label id="elh_settings_Language_Selector_Align" class="col-sm-4 control-label ewLabel"><?php echo $settings->Language_Selector_Align->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Language_Selector_Align->CellAttributes() ?>>
<span id="el_settings_Language_Selector_Align">
<div id="tp_x_Language_Selector_Align" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Language_Selector_Align" data-page="7" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Language_Selector_Align->DisplayValueSeparator) ? json_encode($settings->Language_Selector_Align->DisplayValueSeparator) : $settings->Language_Selector_Align->DisplayValueSeparator) ?>" name="x_Language_Selector_Align" id="x_Language_Selector_Align" value="{value}"<?php echo $settings->Language_Selector_Align->EditAttributes() ?>></div>
<div id="dsl_x_Language_Selector_Align" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Language_Selector_Align->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Language_Selector_Align->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Language_Selector_Align" data-page="7" name="x_Language_Selector_Align" id="x_Language_Selector_Align_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Language_Selector_Align->EditAttributes() ?>><?php echo $settings->Language_Selector_Align->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Language_Selector_Align->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Language_Selector_Align" data-page="7" name="x_Language_Selector_Align" id="x_Language_Selector_Align_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Language_Selector_Align->CurrentValue) ?>" checked<?php echo $settings->Language_Selector_Align->EditAttributes() ?>><?php echo $settings->Language_Selector_Align->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Language_Selector_Align->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("8") ?>" id="tab_settings8">
<div>
<?php if ($settings->Show_Entire_Footer->Visible) { // Show_Entire_Footer ?>
	<div id="r_Show_Entire_Footer" class="form-group">
		<label id="elh_settings_Show_Entire_Footer" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Entire_Footer->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Entire_Footer->CellAttributes() ?>>
<span id="el_settings_Show_Entire_Footer">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Entire_Footer->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Entire_Footer" data-page="8" name="x_Show_Entire_Footer[]" id="x_Show_Entire_Footer[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Entire_Footer->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Entire_Footer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Text_In_Footer->Visible) { // Show_Text_In_Footer ?>
	<div id="r_Show_Text_In_Footer" class="form-group">
		<label id="elh_settings_Show_Text_In_Footer" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Text_In_Footer->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Text_In_Footer->CellAttributes() ?>>
<span id="el_settings_Show_Text_In_Footer">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Text_In_Footer->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Text_In_Footer" data-page="8" name="x_Show_Text_In_Footer[]" id="x_Show_Text_In_Footer[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Text_In_Footer->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Text_In_Footer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Back_To_Top_On_Footer->Visible) { // Show_Back_To_Top_On_Footer ?>
	<div id="r_Show_Back_To_Top_On_Footer" class="form-group">
		<label id="elh_settings_Show_Back_To_Top_On_Footer" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Back_To_Top_On_Footer->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Back_To_Top_On_Footer->CellAttributes() ?>>
<span id="el_settings_Show_Back_To_Top_On_Footer">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Back_To_Top_On_Footer->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Back_To_Top_On_Footer" data-page="8" name="x_Show_Back_To_Top_On_Footer[]" id="x_Show_Back_To_Top_On_Footer[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Back_To_Top_On_Footer->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Back_To_Top_On_Footer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Terms_And_Conditions_On_Footer->Visible) { // Show_Terms_And_Conditions_On_Footer ?>
	<div id="r_Show_Terms_And_Conditions_On_Footer" class="form-group">
		<label id="elh_settings_Show_Terms_And_Conditions_On_Footer" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Terms_And_Conditions_On_Footer->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Terms_And_Conditions_On_Footer->CellAttributes() ?>>
<span id="el_settings_Show_Terms_And_Conditions_On_Footer">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Terms_And_Conditions_On_Footer->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Terms_And_Conditions_On_Footer" data-page="8" name="x_Show_Terms_And_Conditions_On_Footer[]" id="x_Show_Terms_And_Conditions_On_Footer[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Terms_And_Conditions_On_Footer->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Terms_And_Conditions_On_Footer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_About_Us_On_Footer->Visible) { // Show_About_Us_On_Footer ?>
	<div id="r_Show_About_Us_On_Footer" class="form-group">
		<label id="elh_settings_Show_About_Us_On_Footer" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_About_Us_On_Footer->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_About_Us_On_Footer->CellAttributes() ?>>
<span id="el_settings_Show_About_Us_On_Footer">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_About_Us_On_Footer->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_About_Us_On_Footer" data-page="8" name="x_Show_About_Us_On_Footer[]" id="x_Show_About_Us_On_Footer[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_About_Us_On_Footer->EditAttributes() ?>>
</span>
<?php echo $settings->Show_About_Us_On_Footer->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("9") ?>" id="tab_settings9">
<div>
<?php if ($settings->Pagination_Position->Visible) { // Pagination_Position ?>
	<div id="r_Pagination_Position" class="form-group">
		<label id="elh_settings_Pagination_Position" class="col-sm-4 control-label ewLabel"><?php echo $settings->Pagination_Position->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Pagination_Position->CellAttributes() ?>>
<span id="el_settings_Pagination_Position">
<div id="tp_x_Pagination_Position" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Pagination_Position" data-page="9" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Pagination_Position->DisplayValueSeparator) ? json_encode($settings->Pagination_Position->DisplayValueSeparator) : $settings->Pagination_Position->DisplayValueSeparator) ?>" name="x_Pagination_Position" id="x_Pagination_Position" value="{value}"<?php echo $settings->Pagination_Position->EditAttributes() ?>></div>
<div id="dsl_x_Pagination_Position" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Pagination_Position->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Pagination_Position->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Pagination_Position" data-page="9" name="x_Pagination_Position" id="x_Pagination_Position_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Pagination_Position->EditAttributes() ?>><?php echo $settings->Pagination_Position->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Pagination_Position->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Pagination_Position" data-page="9" name="x_Pagination_Position" id="x_Pagination_Position_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Pagination_Position->CurrentValue) ?>" checked<?php echo $settings->Pagination_Position->EditAttributes() ?>><?php echo $settings->Pagination_Position->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Pagination_Position->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Pagination_Style->Visible) { // Pagination_Style ?>
	<div id="r_Pagination_Style" class="form-group">
		<label id="elh_settings_Pagination_Style" class="col-sm-4 control-label ewLabel"><?php echo $settings->Pagination_Style->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Pagination_Style->CellAttributes() ?>>
<span id="el_settings_Pagination_Style">
<div id="tp_x_Pagination_Style" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Pagination_Style" data-page="9" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Pagination_Style->DisplayValueSeparator) ? json_encode($settings->Pagination_Style->DisplayValueSeparator) : $settings->Pagination_Style->DisplayValueSeparator) ?>" name="x_Pagination_Style" id="x_Pagination_Style" value="{value}"<?php echo $settings->Pagination_Style->EditAttributes() ?>></div>
<div id="dsl_x_Pagination_Style" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Pagination_Style->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Pagination_Style->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Pagination_Style" data-page="9" name="x_Pagination_Style" id="x_Pagination_Style_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Pagination_Style->EditAttributes() ?>><?php echo $settings->Pagination_Style->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Pagination_Style->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Pagination_Style" data-page="9" name="x_Pagination_Style" id="x_Pagination_Style_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Pagination_Style->CurrentValue) ?>" checked<?php echo $settings->Pagination_Style->EditAttributes() ?>><?php echo $settings->Pagination_Style->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Pagination_Style->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Selectable_Records_Per_Page->Visible) { // Selectable_Records_Per_Page ?>
	<div id="r_Selectable_Records_Per_Page" class="form-group">
		<label id="elh_settings_Selectable_Records_Per_Page" for="x_Selectable_Records_Per_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Selectable_Records_Per_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Selectable_Records_Per_Page->CellAttributes() ?>>
<span id="el_settings_Selectable_Records_Per_Page">
<input type="text" data-table="settings" data-field="x_Selectable_Records_Per_Page" data-page="9" name="x_Selectable_Records_Per_Page" id="x_Selectable_Records_Per_Page" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($settings->Selectable_Records_Per_Page->getPlaceHolder()) ?>" value="<?php echo $settings->Selectable_Records_Per_Page->EditValue ?>"<?php echo $settings->Selectable_Records_Per_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Selectable_Records_Per_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Selectable_Groups_Per_Page->Visible) { // Selectable_Groups_Per_Page ?>
	<div id="r_Selectable_Groups_Per_Page" class="form-group">
		<label id="elh_settings_Selectable_Groups_Per_Page" for="x_Selectable_Groups_Per_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Selectable_Groups_Per_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Selectable_Groups_Per_Page->CellAttributes() ?>>
<span id="el_settings_Selectable_Groups_Per_Page">
<input type="text" data-table="settings" data-field="x_Selectable_Groups_Per_Page" data-page="9" name="x_Selectable_Groups_Per_Page" id="x_Selectable_Groups_Per_Page" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($settings->Selectable_Groups_Per_Page->getPlaceHolder()) ?>" value="<?php echo $settings->Selectable_Groups_Per_Page->EditValue ?>"<?php echo $settings->Selectable_Groups_Per_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Selectable_Groups_Per_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Record_Per_Page->Visible) { // Default_Record_Per_Page ?>
	<div id="r_Default_Record_Per_Page" class="form-group">
		<label id="elh_settings_Default_Record_Per_Page" for="x_Default_Record_Per_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Record_Per_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Record_Per_Page->CellAttributes() ?>>
<span id="el_settings_Default_Record_Per_Page">
<input type="text" data-table="settings" data-field="x_Default_Record_Per_Page" data-page="9" name="x_Default_Record_Per_Page" id="x_Default_Record_Per_Page" size="30" placeholder="<?php echo ew_HtmlEncode($settings->Default_Record_Per_Page->getPlaceHolder()) ?>" value="<?php echo $settings->Default_Record_Per_Page->EditValue ?>"<?php echo $settings->Default_Record_Per_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Default_Record_Per_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Default_Group_Per_Page->Visible) { // Default_Group_Per_Page ?>
	<div id="r_Default_Group_Per_Page" class="form-group">
		<label id="elh_settings_Default_Group_Per_Page" for="x_Default_Group_Per_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Default_Group_Per_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Default_Group_Per_Page->CellAttributes() ?>>
<span id="el_settings_Default_Group_Per_Page">
<input type="text" data-table="settings" data-field="x_Default_Group_Per_Page" data-page="9" name="x_Default_Group_Per_Page" id="x_Default_Group_Per_Page" size="30" placeholder="<?php echo ew_HtmlEncode($settings->Default_Group_Per_Page->getPlaceHolder()) ?>" value="<?php echo $settings->Default_Group_Per_Page->EditValue ?>"<?php echo $settings->Default_Group_Per_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Default_Group_Per_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Maximum_Selected_Records->Visible) { // Maximum_Selected_Records ?>
	<div id="r_Maximum_Selected_Records" class="form-group">
		<label id="elh_settings_Maximum_Selected_Records" for="x_Maximum_Selected_Records" class="col-sm-4 control-label ewLabel"><?php echo $settings->Maximum_Selected_Records->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Maximum_Selected_Records->CellAttributes() ?>>
<span id="el_settings_Maximum_Selected_Records">
<input type="text" data-table="settings" data-field="x_Maximum_Selected_Records" data-page="9" name="x_Maximum_Selected_Records" id="x_Maximum_Selected_Records" size="30" placeholder="<?php echo ew_HtmlEncode($settings->Maximum_Selected_Records->getPlaceHolder()) ?>" value="<?php echo $settings->Maximum_Selected_Records->EditValue ?>"<?php echo $settings->Maximum_Selected_Records->EditAttributes() ?>>
</span>
<?php echo $settings->Maximum_Selected_Records->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Maximum_Selected_Groups->Visible) { // Maximum_Selected_Groups ?>
	<div id="r_Maximum_Selected_Groups" class="form-group">
		<label id="elh_settings_Maximum_Selected_Groups" for="x_Maximum_Selected_Groups" class="col-sm-4 control-label ewLabel"><?php echo $settings->Maximum_Selected_Groups->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Maximum_Selected_Groups->CellAttributes() ?>>
<span id="el_settings_Maximum_Selected_Groups">
<input type="text" data-table="settings" data-field="x_Maximum_Selected_Groups" data-page="9" name="x_Maximum_Selected_Groups" id="x_Maximum_Selected_Groups" size="30" placeholder="<?php echo ew_HtmlEncode($settings->Maximum_Selected_Groups->getPlaceHolder()) ?>" value="<?php echo $settings->Maximum_Selected_Groups->EditValue ?>"<?php echo $settings->Maximum_Selected_Groups->EditAttributes() ?>>
</span>
<?php echo $settings->Maximum_Selected_Groups->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_PageNum_If_Record_Not_Over_Pagesize->Visible) { // Show_PageNum_If_Record_Not_Over_Pagesize ?>
	<div id="r_Show_PageNum_If_Record_Not_Over_Pagesize" class="form-group">
		<label id="elh_settings_Show_PageNum_If_Record_Not_Over_Pagesize" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_PageNum_If_Record_Not_Over_Pagesize->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_PageNum_If_Record_Not_Over_Pagesize->CellAttributes() ?>>
<span id="el_settings_Show_PageNum_If_Record_Not_Over_Pagesize">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_PageNum_If_Record_Not_Over_Pagesize->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_PageNum_If_Record_Not_Over_Pagesize" data-page="9" name="x_Show_PageNum_If_Record_Not_Over_Pagesize[]" id="x_Show_PageNum_If_Record_Not_Over_Pagesize[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_PageNum_If_Record_Not_Over_Pagesize->EditAttributes() ?>>
</span>
<?php echo $settings->Show_PageNum_If_Record_Not_Over_Pagesize->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("10") ?>" id="tab_settings10">
<div>
<?php if ($settings->Table_Width_Style->Visible) { // Table_Width_Style ?>
	<div id="r_Table_Width_Style" class="form-group">
		<label id="elh_settings_Table_Width_Style" class="col-sm-4 control-label ewLabel"><?php echo $settings->Table_Width_Style->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Table_Width_Style->CellAttributes() ?>>
<span id="el_settings_Table_Width_Style">
<div id="tp_x_Table_Width_Style" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Table_Width_Style" data-page="10" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Table_Width_Style->DisplayValueSeparator) ? json_encode($settings->Table_Width_Style->DisplayValueSeparator) : $settings->Table_Width_Style->DisplayValueSeparator) ?>" name="x_Table_Width_Style" id="x_Table_Width_Style" value="{value}"<?php echo $settings->Table_Width_Style->EditAttributes() ?>></div>
<div id="dsl_x_Table_Width_Style" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Table_Width_Style->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Table_Width_Style->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Table_Width_Style" data-page="10" name="x_Table_Width_Style" id="x_Table_Width_Style_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Table_Width_Style->EditAttributes() ?>><?php echo $settings->Table_Width_Style->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Table_Width_Style->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Table_Width_Style" data-page="10" name="x_Table_Width_Style" id="x_Table_Width_Style_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Table_Width_Style->CurrentValue) ?>" checked<?php echo $settings->Table_Width_Style->EditAttributes() ?>><?php echo $settings->Table_Width_Style->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Table_Width_Style->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Scroll_Table_Width->Visible) { // Scroll_Table_Width ?>
	<div id="r_Scroll_Table_Width" class="form-group">
		<label id="elh_settings_Scroll_Table_Width" for="x_Scroll_Table_Width" class="col-sm-4 control-label ewLabel"><?php echo $settings->Scroll_Table_Width->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Scroll_Table_Width->CellAttributes() ?>>
<span id="el_settings_Scroll_Table_Width">
<input type="text" data-table="settings" data-field="x_Scroll_Table_Width" data-page="10" name="x_Scroll_Table_Width" id="x_Scroll_Table_Width" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($settings->Scroll_Table_Width->getPlaceHolder()) ?>" value="<?php echo $settings->Scroll_Table_Width->EditValue ?>"<?php echo $settings->Scroll_Table_Width->EditAttributes() ?>>
</span>
<?php echo $settings->Scroll_Table_Width->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Scroll_Table_Height->Visible) { // Scroll_Table_Height ?>
	<div id="r_Scroll_Table_Height" class="form-group">
		<label id="elh_settings_Scroll_Table_Height" for="x_Scroll_Table_Height" class="col-sm-4 control-label ewLabel"><?php echo $settings->Scroll_Table_Height->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Scroll_Table_Height->CellAttributes() ?>>
<span id="el_settings_Scroll_Table_Height">
<input type="text" data-table="settings" data-field="x_Scroll_Table_Height" data-page="10" name="x_Scroll_Table_Height" id="x_Scroll_Table_Height" size="10" maxlength="5" placeholder="<?php echo ew_HtmlEncode($settings->Scroll_Table_Height->getPlaceHolder()) ?>" value="<?php echo $settings->Scroll_Table_Height->EditValue ?>"<?php echo $settings->Scroll_Table_Height->EditAttributes() ?>>
</span>
<?php echo $settings->Scroll_Table_Height->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Search_Panel_Collapsed->Visible) { // Search_Panel_Collapsed ?>
	<div id="r_Search_Panel_Collapsed" class="form-group">
		<label id="elh_settings_Search_Panel_Collapsed" class="col-sm-4 control-label ewLabel"><?php echo $settings->Search_Panel_Collapsed->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Search_Panel_Collapsed->CellAttributes() ?>>
<span id="el_settings_Search_Panel_Collapsed">
<?php
$selwrk = (ew_ConvertToBool($settings->Search_Panel_Collapsed->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Search_Panel_Collapsed" data-page="10" name="x_Search_Panel_Collapsed[]" id="x_Search_Panel_Collapsed[]" value="1"<?php echo $selwrk ?><?php echo $settings->Search_Panel_Collapsed->EditAttributes() ?>>
</span>
<?php echo $settings->Search_Panel_Collapsed->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Filter_Panel_Collapsed->Visible) { // Filter_Panel_Collapsed ?>
	<div id="r_Filter_Panel_Collapsed" class="form-group">
		<label id="elh_settings_Filter_Panel_Collapsed" class="col-sm-4 control-label ewLabel"><?php echo $settings->Filter_Panel_Collapsed->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Filter_Panel_Collapsed->CellAttributes() ?>>
<span id="el_settings_Filter_Panel_Collapsed">
<?php
$selwrk = (ew_ConvertToBool($settings->Filter_Panel_Collapsed->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Filter_Panel_Collapsed" data-page="10" name="x_Filter_Panel_Collapsed[]" id="x_Filter_Panel_Collapsed[]" value="1"<?php echo $selwrk ?><?php echo $settings->Filter_Panel_Collapsed->EditAttributes() ?>>
</span>
<?php echo $settings->Filter_Panel_Collapsed->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Record_Number_On_List_Page->Visible) { // Show_Record_Number_On_List_Page ?>
	<div id="r_Show_Record_Number_On_List_Page" class="form-group">
		<label id="elh_settings_Show_Record_Number_On_List_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Record_Number_On_List_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Record_Number_On_List_Page->CellAttributes() ?>>
<span id="el_settings_Show_Record_Number_On_List_Page">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Record_Number_On_List_Page->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Record_Number_On_List_Page" data-page="10" name="x_Show_Record_Number_On_List_Page[]" id="x_Show_Record_Number_On_List_Page[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Record_Number_On_List_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Record_Number_On_List_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Empty_Table_On_List_Page->Visible) { // Show_Empty_Table_On_List_Page ?>
	<div id="r_Show_Empty_Table_On_List_Page" class="form-group">
		<label id="elh_settings_Show_Empty_Table_On_List_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Empty_Table_On_List_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Empty_Table_On_List_Page->CellAttributes() ?>>
<span id="el_settings_Show_Empty_Table_On_List_Page">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Empty_Table_On_List_Page->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Empty_Table_On_List_Page" data-page="10" name="x_Show_Empty_Table_On_List_Page[]" id="x_Show_Empty_Table_On_List_Page[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Empty_Table_On_List_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Empty_Table_On_List_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Rows_Vertical_Align_Top->Visible) { // Rows_Vertical_Align_Top ?>
	<div id="r_Rows_Vertical_Align_Top" class="form-group">
		<label id="elh_settings_Rows_Vertical_Align_Top" class="col-sm-4 control-label ewLabel"><?php echo $settings->Rows_Vertical_Align_Top->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Rows_Vertical_Align_Top->CellAttributes() ?>>
<span id="el_settings_Rows_Vertical_Align_Top">
<?php
$selwrk = (ew_ConvertToBool($settings->Rows_Vertical_Align_Top->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Rows_Vertical_Align_Top" data-page="10" name="x_Rows_Vertical_Align_Top[]" id="x_Rows_Vertical_Align_Top[]" value="1"<?php echo $selwrk ?><?php echo $settings->Rows_Vertical_Align_Top->EditAttributes() ?>>
</span>
<?php echo $settings->Rows_Vertical_Align_Top->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Action_Button_Alignment->Visible) { // Action_Button_Alignment ?>
	<div id="r_Action_Button_Alignment" class="form-group">
		<label id="elh_settings_Action_Button_Alignment" class="col-sm-4 control-label ewLabel"><?php echo $settings->Action_Button_Alignment->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Action_Button_Alignment->CellAttributes() ?>>
<span id="el_settings_Action_Button_Alignment">
<div id="tp_x_Action_Button_Alignment" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Action_Button_Alignment" data-page="10" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Action_Button_Alignment->DisplayValueSeparator) ? json_encode($settings->Action_Button_Alignment->DisplayValueSeparator) : $settings->Action_Button_Alignment->DisplayValueSeparator) ?>" name="x_Action_Button_Alignment" id="x_Action_Button_Alignment" value="{value}"<?php echo $settings->Action_Button_Alignment->EditAttributes() ?>></div>
<div id="dsl_x_Action_Button_Alignment" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Action_Button_Alignment->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Action_Button_Alignment->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Action_Button_Alignment" data-page="10" name="x_Action_Button_Alignment" id="x_Action_Button_Alignment_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Action_Button_Alignment->EditAttributes() ?>><?php echo $settings->Action_Button_Alignment->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Action_Button_Alignment->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Action_Button_Alignment" data-page="10" name="x_Action_Button_Alignment" id="x_Action_Button_Alignment_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Action_Button_Alignment->CurrentValue) ?>" checked<?php echo $settings->Action_Button_Alignment->EditAttributes() ?>><?php echo $settings->Action_Button_Alignment->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Action_Button_Alignment->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("11") ?>" id="tab_settings11">
<div>
<?php if ($settings->Show_Add_Success_Message->Visible) { // Show_Add_Success_Message ?>
	<div id="r_Show_Add_Success_Message" class="form-group">
		<label id="elh_settings_Show_Add_Success_Message" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Add_Success_Message->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Add_Success_Message->CellAttributes() ?>>
<span id="el_settings_Show_Add_Success_Message">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Add_Success_Message->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Add_Success_Message" data-page="11" name="x_Show_Add_Success_Message[]" id="x_Show_Add_Success_Message[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Add_Success_Message->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Add_Success_Message->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Edit_Success_Message->Visible) { // Show_Edit_Success_Message ?>
	<div id="r_Show_Edit_Success_Message" class="form-group">
		<label id="elh_settings_Show_Edit_Success_Message" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Edit_Success_Message->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Edit_Success_Message->CellAttributes() ?>>
<span id="el_settings_Show_Edit_Success_Message">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Edit_Success_Message->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Edit_Success_Message" data-page="11" name="x_Show_Edit_Success_Message[]" id="x_Show_Edit_Success_Message[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Edit_Success_Message->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Edit_Success_Message->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->jQuery_Auto_Hide_Success_Message->Visible) { // jQuery_Auto_Hide_Success_Message ?>
	<div id="r_jQuery_Auto_Hide_Success_Message" class="form-group">
		<label id="elh_settings_jQuery_Auto_Hide_Success_Message" class="col-sm-4 control-label ewLabel"><?php echo $settings->jQuery_Auto_Hide_Success_Message->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->jQuery_Auto_Hide_Success_Message->CellAttributes() ?>>
<span id="el_settings_jQuery_Auto_Hide_Success_Message">
<?php
$selwrk = (ew_ConvertToBool($settings->jQuery_Auto_Hide_Success_Message->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_jQuery_Auto_Hide_Success_Message" data-page="11" name="x_jQuery_Auto_Hide_Success_Message[]" id="x_jQuery_Auto_Hide_Success_Message[]" value="1"<?php echo $selwrk ?><?php echo $settings->jQuery_Auto_Hide_Success_Message->EditAttributes() ?>>
</span>
<?php echo $settings->jQuery_Auto_Hide_Success_Message->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Use_Javascript_Message->Visible) { // Use_Javascript_Message ?>
	<div id="r_Use_Javascript_Message" class="form-group">
		<label id="elh_settings_Use_Javascript_Message" class="col-sm-4 control-label ewLabel"><?php echo $settings->Use_Javascript_Message->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Use_Javascript_Message->CellAttributes() ?>>
<span id="el_settings_Use_Javascript_Message">
<?php
$selwrk = (ew_ConvertToBool($settings->Use_Javascript_Message->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Use_Javascript_Message" data-page="11" name="x_Use_Javascript_Message[]" id="x_Use_Javascript_Message[]" value="1"<?php echo $selwrk ?><?php echo $settings->Use_Javascript_Message->EditAttributes() ?>>
</span>
<?php echo $settings->Use_Javascript_Message->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Login_Window_Type->Visible) { // Login_Window_Type ?>
	<div id="r_Login_Window_Type" class="form-group">
		<label id="elh_settings_Login_Window_Type" class="col-sm-4 control-label ewLabel"><?php echo $settings->Login_Window_Type->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Login_Window_Type->CellAttributes() ?>>
<span id="el_settings_Login_Window_Type">
<div id="tp_x_Login_Window_Type" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Login_Window_Type" data-page="11" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Login_Window_Type->DisplayValueSeparator) ? json_encode($settings->Login_Window_Type->DisplayValueSeparator) : $settings->Login_Window_Type->DisplayValueSeparator) ?>" name="x_Login_Window_Type" id="x_Login_Window_Type" value="{value}"<?php echo $settings->Login_Window_Type->EditAttributes() ?>></div>
<div id="dsl_x_Login_Window_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Login_Window_Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Login_Window_Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Login_Window_Type" data-page="11" name="x_Login_Window_Type" id="x_Login_Window_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Login_Window_Type->EditAttributes() ?>><?php echo $settings->Login_Window_Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Login_Window_Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Login_Window_Type" data-page="11" name="x_Login_Window_Type" id="x_Login_Window_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Login_Window_Type->CurrentValue) ?>" checked<?php echo $settings->Login_Window_Type->EditAttributes() ?>><?php echo $settings->Login_Window_Type->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Login_Window_Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Forgot_Password_Window_Type->Visible) { // Forgot_Password_Window_Type ?>
	<div id="r_Forgot_Password_Window_Type" class="form-group">
		<label id="elh_settings_Forgot_Password_Window_Type" class="col-sm-4 control-label ewLabel"><?php echo $settings->Forgot_Password_Window_Type->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Forgot_Password_Window_Type->CellAttributes() ?>>
<span id="el_settings_Forgot_Password_Window_Type">
<div id="tp_x_Forgot_Password_Window_Type" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Forgot_Password_Window_Type" data-page="11" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Forgot_Password_Window_Type->DisplayValueSeparator) ? json_encode($settings->Forgot_Password_Window_Type->DisplayValueSeparator) : $settings->Forgot_Password_Window_Type->DisplayValueSeparator) ?>" name="x_Forgot_Password_Window_Type" id="x_Forgot_Password_Window_Type" value="{value}"<?php echo $settings->Forgot_Password_Window_Type->EditAttributes() ?>></div>
<div id="dsl_x_Forgot_Password_Window_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Forgot_Password_Window_Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Forgot_Password_Window_Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Forgot_Password_Window_Type" data-page="11" name="x_Forgot_Password_Window_Type" id="x_Forgot_Password_Window_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Forgot_Password_Window_Type->EditAttributes() ?>><?php echo $settings->Forgot_Password_Window_Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Forgot_Password_Window_Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Forgot_Password_Window_Type" data-page="11" name="x_Forgot_Password_Window_Type" id="x_Forgot_Password_Window_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Forgot_Password_Window_Type->CurrentValue) ?>" checked<?php echo $settings->Forgot_Password_Window_Type->EditAttributes() ?>><?php echo $settings->Forgot_Password_Window_Type->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Forgot_Password_Window_Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Change_Password_Window_Type->Visible) { // Change_Password_Window_Type ?>
	<div id="r_Change_Password_Window_Type" class="form-group">
		<label id="elh_settings_Change_Password_Window_Type" class="col-sm-4 control-label ewLabel"><?php echo $settings->Change_Password_Window_Type->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Change_Password_Window_Type->CellAttributes() ?>>
<span id="el_settings_Change_Password_Window_Type">
<div id="tp_x_Change_Password_Window_Type" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Change_Password_Window_Type" data-page="11" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Change_Password_Window_Type->DisplayValueSeparator) ? json_encode($settings->Change_Password_Window_Type->DisplayValueSeparator) : $settings->Change_Password_Window_Type->DisplayValueSeparator) ?>" name="x_Change_Password_Window_Type" id="x_Change_Password_Window_Type" value="{value}"<?php echo $settings->Change_Password_Window_Type->EditAttributes() ?>></div>
<div id="dsl_x_Change_Password_Window_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Change_Password_Window_Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Change_Password_Window_Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Change_Password_Window_Type" data-page="11" name="x_Change_Password_Window_Type" id="x_Change_Password_Window_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Change_Password_Window_Type->EditAttributes() ?>><?php echo $settings->Change_Password_Window_Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Change_Password_Window_Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Change_Password_Window_Type" data-page="11" name="x_Change_Password_Window_Type" id="x_Change_Password_Window_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Change_Password_Window_Type->CurrentValue) ?>" checked<?php echo $settings->Change_Password_Window_Type->EditAttributes() ?>><?php echo $settings->Change_Password_Window_Type->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Change_Password_Window_Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Registration_Window_Type->Visible) { // Registration_Window_Type ?>
	<div id="r_Registration_Window_Type" class="form-group">
		<label id="elh_settings_Registration_Window_Type" class="col-sm-4 control-label ewLabel"><?php echo $settings->Registration_Window_Type->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Registration_Window_Type->CellAttributes() ?>>
<span id="el_settings_Registration_Window_Type">
<div id="tp_x_Registration_Window_Type" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Registration_Window_Type" data-page="11" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Registration_Window_Type->DisplayValueSeparator) ? json_encode($settings->Registration_Window_Type->DisplayValueSeparator) : $settings->Registration_Window_Type->DisplayValueSeparator) ?>" name="x_Registration_Window_Type" id="x_Registration_Window_Type" value="{value}"<?php echo $settings->Registration_Window_Type->EditAttributes() ?>></div>
<div id="dsl_x_Registration_Window_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Registration_Window_Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Registration_Window_Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Registration_Window_Type" data-page="11" name="x_Registration_Window_Type" id="x_Registration_Window_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Registration_Window_Type->EditAttributes() ?>><?php echo $settings->Registration_Window_Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Registration_Window_Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Registration_Window_Type" data-page="11" name="x_Registration_Window_Type" id="x_Registration_Window_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Registration_Window_Type->CurrentValue) ?>" checked<?php echo $settings->Registration_Window_Type->EditAttributes() ?>><?php echo $settings->Registration_Window_Type->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Registration_Window_Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("12") ?>" id="tab_settings12">
<div>
<?php if ($settings->Show_Record_Number_On_Detail_Preview->Visible) { // Show_Record_Number_On_Detail_Preview ?>
	<div id="r_Show_Record_Number_On_Detail_Preview" class="form-group">
		<label id="elh_settings_Show_Record_Number_On_Detail_Preview" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Record_Number_On_Detail_Preview->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Record_Number_On_Detail_Preview->CellAttributes() ?>>
<span id="el_settings_Show_Record_Number_On_Detail_Preview">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Record_Number_On_Detail_Preview->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Record_Number_On_Detail_Preview" data-page="12" name="x_Show_Record_Number_On_Detail_Preview[]" id="x_Show_Record_Number_On_Detail_Preview[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Record_Number_On_Detail_Preview->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Record_Number_On_Detail_Preview->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Empty_Table_In_Detail_Preview->Visible) { // Show_Empty_Table_In_Detail_Preview ?>
	<div id="r_Show_Empty_Table_In_Detail_Preview" class="form-group">
		<label id="elh_settings_Show_Empty_Table_In_Detail_Preview" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Empty_Table_In_Detail_Preview->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Empty_Table_In_Detail_Preview->CellAttributes() ?>>
<span id="el_settings_Show_Empty_Table_In_Detail_Preview">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Empty_Table_In_Detail_Preview->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Empty_Table_In_Detail_Preview" data-page="12" name="x_Show_Empty_Table_In_Detail_Preview[]" id="x_Show_Empty_Table_In_Detail_Preview[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Empty_Table_In_Detail_Preview->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Empty_Table_In_Detail_Preview->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Detail_Preview_Table_Width->Visible) { // Detail_Preview_Table_Width ?>
	<div id="r_Detail_Preview_Table_Width" class="form-group">
		<label id="elh_settings_Detail_Preview_Table_Width" for="x_Detail_Preview_Table_Width" class="col-sm-4 control-label ewLabel"><?php echo $settings->Detail_Preview_Table_Width->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Detail_Preview_Table_Width->CellAttributes() ?>>
<span id="el_settings_Detail_Preview_Table_Width">
<input type="text" data-table="settings" data-field="x_Detail_Preview_Table_Width" data-page="12" name="x_Detail_Preview_Table_Width" id="x_Detail_Preview_Table_Width" size="30" placeholder="<?php echo ew_HtmlEncode($settings->Detail_Preview_Table_Width->getPlaceHolder()) ?>" value="<?php echo $settings->Detail_Preview_Table_Width->EditValue ?>"<?php echo $settings->Detail_Preview_Table_Width->EditAttributes() ?>>
</span>
<?php echo $settings->Detail_Preview_Table_Width->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("13") ?>" id="tab_settings13">
<div>
<?php if ($settings->Password_Minimum_Length->Visible) { // Password_Minimum_Length ?>
	<div id="r_Password_Minimum_Length" class="form-group">
		<label id="elh_settings_Password_Minimum_Length" for="x_Password_Minimum_Length" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Minimum_Length->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Minimum_Length->CellAttributes() ?>>
<span id="el_settings_Password_Minimum_Length">
<input type="text" data-table="settings" data-field="x_Password_Minimum_Length" data-page="13" name="x_Password_Minimum_Length" id="x_Password_Minimum_Length" size="30" placeholder="<?php echo ew_HtmlEncode($settings->Password_Minimum_Length->getPlaceHolder()) ?>" value="<?php echo $settings->Password_Minimum_Length->EditValue ?>"<?php echo $settings->Password_Minimum_Length->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Minimum_Length->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Password_Maximum_Length->Visible) { // Password_Maximum_Length ?>
	<div id="r_Password_Maximum_Length" class="form-group">
		<label id="elh_settings_Password_Maximum_Length" for="x_Password_Maximum_Length" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Maximum_Length->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Maximum_Length->CellAttributes() ?>>
<span id="el_settings_Password_Maximum_Length">
<input type="text" data-table="settings" data-field="x_Password_Maximum_Length" data-page="13" name="x_Password_Maximum_Length" id="x_Password_Maximum_Length" size="30" placeholder="<?php echo ew_HtmlEncode($settings->Password_Maximum_Length->getPlaceHolder()) ?>" value="<?php echo $settings->Password_Maximum_Length->EditValue ?>"<?php echo $settings->Password_Maximum_Length->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Maximum_Length->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Password_Must_Contain_At_Least_One_Lower_Case->Visible) { // Password_Must_Contain_At_Least_One_Lower_Case ?>
	<div id="r_Password_Must_Contain_At_Least_One_Lower_Case" class="form-group">
		<label id="elh_settings_Password_Must_Contain_At_Least_One_Lower_Case" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Must_Contain_At_Least_One_Lower_Case->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Must_Contain_At_Least_One_Lower_Case->CellAttributes() ?>>
<span id="el_settings_Password_Must_Contain_At_Least_One_Lower_Case">
<?php
$selwrk = (ew_ConvertToBool($settings->Password_Must_Contain_At_Least_One_Lower_Case->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Password_Must_Contain_At_Least_One_Lower_Case" data-page="13" name="x_Password_Must_Contain_At_Least_One_Lower_Case[]" id="x_Password_Must_Contain_At_Least_One_Lower_Case[]" value="1"<?php echo $selwrk ?><?php echo $settings->Password_Must_Contain_At_Least_One_Lower_Case->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Must_Contain_At_Least_One_Lower_Case->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Password_Must_Comply_With_Minumum_Length->Visible) { // Password_Must_Comply_With_Minumum_Length ?>
	<div id="r_Password_Must_Comply_With_Minumum_Length" class="form-group">
		<label id="elh_settings_Password_Must_Comply_With_Minumum_Length" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Must_Comply_With_Minumum_Length->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Must_Comply_With_Minumum_Length->CellAttributes() ?>>
<span id="el_settings_Password_Must_Comply_With_Minumum_Length">
<?php
$selwrk = (ew_ConvertToBool($settings->Password_Must_Comply_With_Minumum_Length->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Password_Must_Comply_With_Minumum_Length" data-page="13" name="x_Password_Must_Comply_With_Minumum_Length[]" id="x_Password_Must_Comply_With_Minumum_Length[]" value="1"<?php echo $selwrk ?><?php echo $settings->Password_Must_Comply_With_Minumum_Length->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Must_Comply_With_Minumum_Length->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Password_Must_Comply_With_Maximum_Length->Visible) { // Password_Must_Comply_With_Maximum_Length ?>
	<div id="r_Password_Must_Comply_With_Maximum_Length" class="form-group">
		<label id="elh_settings_Password_Must_Comply_With_Maximum_Length" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Must_Comply_With_Maximum_Length->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Must_Comply_With_Maximum_Length->CellAttributes() ?>>
<span id="el_settings_Password_Must_Comply_With_Maximum_Length">
<?php
$selwrk = (ew_ConvertToBool($settings->Password_Must_Comply_With_Maximum_Length->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Password_Must_Comply_With_Maximum_Length" data-page="13" name="x_Password_Must_Comply_With_Maximum_Length[]" id="x_Password_Must_Comply_With_Maximum_Length[]" value="1"<?php echo $selwrk ?><?php echo $settings->Password_Must_Comply_With_Maximum_Length->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Must_Comply_With_Maximum_Length->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Password_Must_Contain_At_Least_One_Upper_Case->Visible) { // Password_Must_Contain_At_Least_One_Upper_Case ?>
	<div id="r_Password_Must_Contain_At_Least_One_Upper_Case" class="form-group">
		<label id="elh_settings_Password_Must_Contain_At_Least_One_Upper_Case" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Must_Contain_At_Least_One_Upper_Case->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Must_Contain_At_Least_One_Upper_Case->CellAttributes() ?>>
<span id="el_settings_Password_Must_Contain_At_Least_One_Upper_Case">
<?php
$selwrk = (ew_ConvertToBool($settings->Password_Must_Contain_At_Least_One_Upper_Case->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Password_Must_Contain_At_Least_One_Upper_Case" data-page="13" name="x_Password_Must_Contain_At_Least_One_Upper_Case[]" id="x_Password_Must_Contain_At_Least_One_Upper_Case[]" value="1"<?php echo $selwrk ?><?php echo $settings->Password_Must_Contain_At_Least_One_Upper_Case->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Must_Contain_At_Least_One_Upper_Case->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Password_Must_Contain_At_Least_One_Numeric->Visible) { // Password_Must_Contain_At_Least_One_Numeric ?>
	<div id="r_Password_Must_Contain_At_Least_One_Numeric" class="form-group">
		<label id="elh_settings_Password_Must_Contain_At_Least_One_Numeric" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Must_Contain_At_Least_One_Numeric->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Must_Contain_At_Least_One_Numeric->CellAttributes() ?>>
<span id="el_settings_Password_Must_Contain_At_Least_One_Numeric">
<?php
$selwrk = (ew_ConvertToBool($settings->Password_Must_Contain_At_Least_One_Numeric->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Password_Must_Contain_At_Least_One_Numeric" data-page="13" name="x_Password_Must_Contain_At_Least_One_Numeric[]" id="x_Password_Must_Contain_At_Least_One_Numeric[]" value="1"<?php echo $selwrk ?><?php echo $settings->Password_Must_Contain_At_Least_One_Numeric->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Must_Contain_At_Least_One_Numeric->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Password_Must_Contain_At_Least_One_Symbol->Visible) { // Password_Must_Contain_At_Least_One_Symbol ?>
	<div id="r_Password_Must_Contain_At_Least_One_Symbol" class="form-group">
		<label id="elh_settings_Password_Must_Contain_At_Least_One_Symbol" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Must_Contain_At_Least_One_Symbol->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Must_Contain_At_Least_One_Symbol->CellAttributes() ?>>
<span id="el_settings_Password_Must_Contain_At_Least_One_Symbol">
<?php
$selwrk = (ew_ConvertToBool($settings->Password_Must_Contain_At_Least_One_Symbol->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Password_Must_Contain_At_Least_One_Symbol" data-page="13" name="x_Password_Must_Contain_At_Least_One_Symbol[]" id="x_Password_Must_Contain_At_Least_One_Symbol[]" value="1"<?php echo $selwrk ?><?php echo $settings->Password_Must_Contain_At_Least_One_Symbol->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Must_Contain_At_Least_One_Symbol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Password_Must_Be_Difference_Between_Old_And_New->Visible) { // Password_Must_Be_Difference_Between_Old_And_New ?>
	<div id="r_Password_Must_Be_Difference_Between_Old_And_New" class="form-group">
		<label id="elh_settings_Password_Must_Be_Difference_Between_Old_And_New" class="col-sm-4 control-label ewLabel"><?php echo $settings->Password_Must_Be_Difference_Between_Old_And_New->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Password_Must_Be_Difference_Between_Old_And_New->CellAttributes() ?>>
<span id="el_settings_Password_Must_Be_Difference_Between_Old_And_New">
<?php
$selwrk = (ew_ConvertToBool($settings->Password_Must_Be_Difference_Between_Old_And_New->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Password_Must_Be_Difference_Between_Old_And_New" data-page="13" name="x_Password_Must_Be_Difference_Between_Old_And_New[]" id="x_Password_Must_Be_Difference_Between_Old_And_New[]" value="1"<?php echo $selwrk ?><?php echo $settings->Password_Must_Be_Difference_Between_Old_And_New->EditAttributes() ?>>
</span>
<?php echo $settings->Password_Must_Be_Difference_Between_Old_And_New->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Reset_Password_Field_Options->Visible) { // Reset_Password_Field_Options ?>
	<div id="r_Reset_Password_Field_Options" class="form-group">
		<label id="elh_settings_Reset_Password_Field_Options" class="col-sm-4 control-label ewLabel"><?php echo $settings->Reset_Password_Field_Options->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Reset_Password_Field_Options->CellAttributes() ?>>
<span id="el_settings_Reset_Password_Field_Options">
<div id="tp_x_Reset_Password_Field_Options" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Reset_Password_Field_Options" data-page="13" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Reset_Password_Field_Options->DisplayValueSeparator) ? json_encode($settings->Reset_Password_Field_Options->DisplayValueSeparator) : $settings->Reset_Password_Field_Options->DisplayValueSeparator) ?>" name="x_Reset_Password_Field_Options" id="x_Reset_Password_Field_Options" value="{value}"<?php echo $settings->Reset_Password_Field_Options->EditAttributes() ?>></div>
<div id="dsl_x_Reset_Password_Field_Options" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Reset_Password_Field_Options->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Reset_Password_Field_Options->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Reset_Password_Field_Options" data-page="13" name="x_Reset_Password_Field_Options" id="x_Reset_Password_Field_Options_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Reset_Password_Field_Options->EditAttributes() ?>><?php echo $settings->Reset_Password_Field_Options->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Reset_Password_Field_Options->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Reset_Password_Field_Options" data-page="13" name="x_Reset_Password_Field_Options" id="x_Reset_Password_Field_Options_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Reset_Password_Field_Options->CurrentValue) ?>" checked<?php echo $settings->Reset_Password_Field_Options->EditAttributes() ?>><?php echo $settings->Reset_Password_Field_Options->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Reset_Password_Field_Options->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
		<div class="tab-pane<?php echo $settings_edit->MultiPages->PageStyle("14") ?>" id="tab_settings14">
<div>
<?php if ($settings->Export_Record_Options->Visible) { // Export_Record_Options ?>
	<div id="r_Export_Record_Options" class="form-group">
		<label id="elh_settings_Export_Record_Options" class="col-sm-4 control-label ewLabel"><?php echo $settings->Export_Record_Options->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Export_Record_Options->CellAttributes() ?>>
<span id="el_settings_Export_Record_Options">
<div id="tp_x_Export_Record_Options" class="ewTemplate"><input type="radio" data-table="settings" data-field="x_Export_Record_Options" data-page="14" data-value-separator="<?php echo ew_HtmlEncode(is_array($settings->Export_Record_Options->DisplayValueSeparator) ? json_encode($settings->Export_Record_Options->DisplayValueSeparator) : $settings->Export_Record_Options->DisplayValueSeparator) ?>" name="x_Export_Record_Options" id="x_Export_Record_Options" value="{value}"<?php echo $settings->Export_Record_Options->EditAttributes() ?>></div>
<div id="dsl_x_Export_Record_Options" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $settings->Export_Record_Options->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($settings->Export_Record_Options->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Export_Record_Options" data-page="14" name="x_Export_Record_Options" id="x_Export_Record_Options_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $settings->Export_Record_Options->EditAttributes() ?>><?php echo $settings->Export_Record_Options->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($settings->Export_Record_Options->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="settings" data-field="x_Export_Record_Options" data-page="14" name="x_Export_Record_Options" id="x_Export_Record_Options_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($settings->Export_Record_Options->CurrentValue) ?>" checked<?php echo $settings->Export_Record_Options->EditAttributes() ?>><?php echo $settings->Export_Record_Options->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $settings->Export_Record_Options->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Show_Record_Number_On_Exported_List_Page->Visible) { // Show_Record_Number_On_Exported_List_Page ?>
	<div id="r_Show_Record_Number_On_Exported_List_Page" class="form-group">
		<label id="elh_settings_Show_Record_Number_On_Exported_List_Page" class="col-sm-4 control-label ewLabel"><?php echo $settings->Show_Record_Number_On_Exported_List_Page->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Show_Record_Number_On_Exported_List_Page->CellAttributes() ?>>
<span id="el_settings_Show_Record_Number_On_Exported_List_Page">
<?php
$selwrk = (ew_ConvertToBool($settings->Show_Record_Number_On_Exported_List_Page->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Show_Record_Number_On_Exported_List_Page" data-page="14" name="x_Show_Record_Number_On_Exported_List_Page[]" id="x_Show_Record_Number_On_Exported_List_Page[]" value="1"<?php echo $selwrk ?><?php echo $settings->Show_Record_Number_On_Exported_List_Page->EditAttributes() ?>>
</span>
<?php echo $settings->Show_Record_Number_On_Exported_List_Page->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Use_Table_Setting_For_Export_Field_Caption->Visible) { // Use_Table_Setting_For_Export_Field_Caption ?>
	<div id="r_Use_Table_Setting_For_Export_Field_Caption" class="form-group">
		<label id="elh_settings_Use_Table_Setting_For_Export_Field_Caption" class="col-sm-4 control-label ewLabel"><?php echo $settings->Use_Table_Setting_For_Export_Field_Caption->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Use_Table_Setting_For_Export_Field_Caption->CellAttributes() ?>>
<span id="el_settings_Use_Table_Setting_For_Export_Field_Caption">
<?php
$selwrk = (ew_ConvertToBool($settings->Use_Table_Setting_For_Export_Field_Caption->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Use_Table_Setting_For_Export_Field_Caption" data-page="14" name="x_Use_Table_Setting_For_Export_Field_Caption[]" id="x_Use_Table_Setting_For_Export_Field_Caption[]" value="1"<?php echo $selwrk ?><?php echo $settings->Use_Table_Setting_For_Export_Field_Caption->EditAttributes() ?>>
</span>
<?php echo $settings->Use_Table_Setting_For_Export_Field_Caption->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->Use_Table_Setting_For_Export_Original_Value->Visible) { // Use_Table_Setting_For_Export_Original_Value ?>
	<div id="r_Use_Table_Setting_For_Export_Original_Value" class="form-group">
		<label id="elh_settings_Use_Table_Setting_For_Export_Original_Value" class="col-sm-4 control-label ewLabel"><?php echo $settings->Use_Table_Setting_For_Export_Original_Value->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $settings->Use_Table_Setting_For_Export_Original_Value->CellAttributes() ?>>
<span id="el_settings_Use_Table_Setting_For_Export_Original_Value">
<?php
$selwrk = (ew_ConvertToBool($settings->Use_Table_Setting_For_Export_Original_Value->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="settings" data-field="x_Use_Table_Setting_For_Export_Original_Value" data-page="14" name="x_Use_Table_Setting_For_Export_Original_Value[]" id="x_Use_Table_Setting_For_Export_Original_Value[]" value="1"<?php echo $selwrk ?><?php echo $settings->Use_Table_Setting_For_Export_Original_Value->EditAttributes() ?>>
</span>
<?php echo $settings->Use_Table_Setting_For_Export_Original_Value->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
		</div>
	</div>
</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $settings_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($settings_edit->Pager)) $settings_edit->Pager = new cNumericPager($settings_edit->StartRec, $settings_edit->DisplayRecs, $settings_edit->TotalRecs, $settings_edit->RecRange) ?>
		<?php if ($settings_edit->Pager->RecordCount > 0) { ?>
				<?php if (($settings_edit->Pager->PageCount==1) && ($settings_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($settings_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($settings_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $settings_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($settings_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($settings_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($settings_edit->Pager)) $settings_edit->Pager = new cPrevNextPager($settings_edit->StartRec, $settings_edit->DisplayRecs, $settings_edit->TotalRecs) ?>
		<?php if ($settings_edit->Pager->RecordCount > 0) { ?>
				<?php if (($settings_edit->Pager->PageCount==1) && ($settings_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($settings_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($settings_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				</div>
				<!--current page number-->
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $settings_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($settings_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($settings_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $settings_edit->PageUrl() ?>start=<?php echo $settings_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				</div>
				</div>
				</div>
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $settings_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
</form>
<script type="text/javascript">
fsettingsedit.Init();
</script>
<?php
$settings_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fsettingsedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($settings->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyEdit(this)'); function alertifyEdit(obj) { <?php global $Language; ?> if (fsettingsedit.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyEditConfirm'); ?>", function (e) {	if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyEdit'); ?>"); $("#fsettingsedit").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$settings_edit->Page_Terminate();
?>
