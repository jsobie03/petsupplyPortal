<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "languagesinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$languages_edit = NULL; // Initialize page object first

class clanguages_edit extends clanguages {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'languages';

	// Page object name
	var $PageObjName = 'languages_edit';

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

		// Table object (languages)
		if (!isset($GLOBALS["languages"]) || get_class($GLOBALS["languages"]) == "clanguages") {
			$GLOBALS["languages"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["languages"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'languages', TRUE);

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
		if (!isset($_SESSION['table_languages_views'])) { 
			$_SESSION['table_languages_views'] = 0;
		}
		$_SESSION['table_languages_views'] = $_SESSION['table_languages_views']+1;

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
				$this->Page_Terminate(ew_GetUrl("languageslist.php"));
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
		global $EW_EXPORT, $languages;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($languages);
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
		if (@$_GET["Language_Code"] <> "") {
			$this->Language_Code->setQueryStringValue($_GET["Language_Code"]);
			$this->RecKey["Language_Code"] = $this->Language_Code->QueryStringValue;
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
			$this->Page_Terminate("languageslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->Language_Code->CurrentValue) == strval($this->Recordset->fields('Language_Code'))) {
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
					$this->Page_Terminate("languageslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "languageslist.php")
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
		if (!$this->Language_Code->FldIsDetailKey) {
			$this->Language_Code->setFormValue($objForm->GetValue("x_Language_Code"));
		}
		if (!$this->Language_Name->FldIsDetailKey) {
			$this->Language_Name->setFormValue($objForm->GetValue("x_Language_Name"));
		}
		if (!$this->_Default->FldIsDetailKey) {
			$this->_Default->setFormValue($objForm->GetValue("x__Default"));
		}
		if (!$this->Site_Logo->FldIsDetailKey) {
			$this->Site_Logo->setFormValue($objForm->GetValue("x_Site_Logo"));
		}
		if (!$this->Site_Title->FldIsDetailKey) {
			$this->Site_Title->setFormValue($objForm->GetValue("x_Site_Title"));
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
		if (!$this->Terms_And_Condition_Text->FldIsDetailKey) {
			$this->Terms_And_Condition_Text->setFormValue($objForm->GetValue("x_Terms_And_Condition_Text"));
		}
		if (!$this->Announcement_Text->FldIsDetailKey) {
			$this->Announcement_Text->setFormValue($objForm->GetValue("x_Announcement_Text"));
		}
		if (!$this->About_Text->FldIsDetailKey) {
			$this->About_Text->setFormValue($objForm->GetValue("x_About_Text"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Language_Code->CurrentValue = $this->Language_Code->FormValue;
		$this->Language_Name->CurrentValue = $this->Language_Name->FormValue;
		$this->_Default->CurrentValue = $this->_Default->FormValue;
		$this->Site_Logo->CurrentValue = $this->Site_Logo->FormValue;
		$this->Site_Title->CurrentValue = $this->Site_Title->FormValue;
		$this->Default_Thousands_Separator->CurrentValue = $this->Default_Thousands_Separator->FormValue;
		$this->Default_Decimal_Point->CurrentValue = $this->Default_Decimal_Point->FormValue;
		$this->Default_Currency_Symbol->CurrentValue = $this->Default_Currency_Symbol->FormValue;
		$this->Default_Money_Thousands_Separator->CurrentValue = $this->Default_Money_Thousands_Separator->FormValue;
		$this->Default_Money_Decimal_Point->CurrentValue = $this->Default_Money_Decimal_Point->FormValue;
		$this->Terms_And_Condition_Text->CurrentValue = $this->Terms_And_Condition_Text->FormValue;
		$this->Announcement_Text->CurrentValue = $this->Announcement_Text->FormValue;
		$this->About_Text->CurrentValue = $this->About_Text->FormValue;
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Language_Code->DbValue = $row['Language_Code'];
		$this->Language_Name->DbValue = $row['Language_Name'];
		$this->_Default->DbValue = $row['Default'];
		$this->Site_Logo->DbValue = $row['Site_Logo'];
		$this->Site_Title->DbValue = $row['Site_Title'];
		$this->Default_Thousands_Separator->DbValue = $row['Default_Thousands_Separator'];
		$this->Default_Decimal_Point->DbValue = $row['Default_Decimal_Point'];
		$this->Default_Currency_Symbol->DbValue = $row['Default_Currency_Symbol'];
		$this->Default_Money_Thousands_Separator->DbValue = $row['Default_Money_Thousands_Separator'];
		$this->Default_Money_Decimal_Point->DbValue = $row['Default_Money_Decimal_Point'];
		$this->Terms_And_Condition_Text->DbValue = $row['Terms_And_Condition_Text'];
		$this->Announcement_Text->DbValue = $row['Announcement_Text'];
		$this->About_Text->DbValue = $row['About_Text'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Language_Code
			$this->Language_Code->EditAttrs["class"] = "form-control";
			$this->Language_Code->EditCustomAttributes = "";
			$this->Language_Code->EditValue = $this->Language_Code->CurrentValue;
			$this->Language_Code->ViewCustomAttributes = "";

			// Language_Name
			$this->Language_Name->EditAttrs["class"] = "form-control";
			$this->Language_Name->EditCustomAttributes = "";
			$this->Language_Name->EditValue = ew_HtmlEncode($this->Language_Name->CurrentValue);
			$this->Language_Name->PlaceHolder = ew_RemoveHtml($this->Language_Name->FldCaption());

			// Default
			$this->_Default->EditCustomAttributes = "";
			$this->_Default->EditValue = $this->_Default->Options(FALSE);

			// Site_Logo
			$this->Site_Logo->EditAttrs["class"] = "form-control";
			$this->Site_Logo->EditCustomAttributes = "";
			$this->Site_Logo->EditValue = ew_HtmlEncode($this->Site_Logo->CurrentValue);
			$this->Site_Logo->PlaceHolder = ew_RemoveHtml($this->Site_Logo->FldCaption());

			// Site_Title
			$this->Site_Title->EditAttrs["class"] = "form-control";
			$this->Site_Title->EditCustomAttributes = "";
			$this->Site_Title->EditValue = ew_HtmlEncode($this->Site_Title->CurrentValue);
			$this->Site_Title->PlaceHolder = ew_RemoveHtml($this->Site_Title->FldCaption());

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

			// Terms_And_Condition_Text
			$this->Terms_And_Condition_Text->EditAttrs["class"] = "form-control";
			$this->Terms_And_Condition_Text->EditCustomAttributes = "";
			$this->Terms_And_Condition_Text->EditValue = ew_HtmlEncode($this->Terms_And_Condition_Text->CurrentValue);
			$this->Terms_And_Condition_Text->PlaceHolder = ew_RemoveHtml($this->Terms_And_Condition_Text->FldCaption());

			// Announcement_Text
			$this->Announcement_Text->EditAttrs["class"] = "form-control";
			$this->Announcement_Text->EditCustomAttributes = "";
			$this->Announcement_Text->EditValue = ew_HtmlEncode($this->Announcement_Text->CurrentValue);
			$this->Announcement_Text->PlaceHolder = ew_RemoveHtml($this->Announcement_Text->FldCaption());

			// About_Text
			$this->About_Text->EditAttrs["class"] = "form-control";
			$this->About_Text->EditCustomAttributes = "";
			$this->About_Text->EditValue = ew_HtmlEncode($this->About_Text->CurrentValue);
			$this->About_Text->PlaceHolder = ew_RemoveHtml($this->About_Text->FldCaption());

			// Edit refer script
			// Language_Code

			$this->Language_Code->LinkCustomAttributes = "";
			$this->Language_Code->HrefValue = "";

			// Language_Name
			$this->Language_Name->LinkCustomAttributes = "";
			$this->Language_Name->HrefValue = "";

			// Default
			$this->_Default->LinkCustomAttributes = "";
			$this->_Default->HrefValue = "";

			// Site_Logo
			$this->Site_Logo->LinkCustomAttributes = "";
			$this->Site_Logo->HrefValue = "";

			// Site_Title
			$this->Site_Title->LinkCustomAttributes = "";
			$this->Site_Title->HrefValue = "";

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

			// Terms_And_Condition_Text
			$this->Terms_And_Condition_Text->LinkCustomAttributes = "";
			$this->Terms_And_Condition_Text->HrefValue = "";

			// Announcement_Text
			$this->Announcement_Text->LinkCustomAttributes = "";
			$this->Announcement_Text->HrefValue = "";

			// About_Text
			$this->About_Text->LinkCustomAttributes = "";
			$this->About_Text->HrefValue = "";
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
		if (!$this->Language_Code->FldIsDetailKey && !is_null($this->Language_Code->FormValue) && $this->Language_Code->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Language_Code->FldCaption(), $this->Language_Code->ReqErrMsg));
		}
		if (!$this->Language_Name->FldIsDetailKey && !is_null($this->Language_Name->FormValue) && $this->Language_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Language_Name->FldCaption(), $this->Language_Name->ReqErrMsg));
		}
		if (!$this->Site_Logo->FldIsDetailKey && !is_null($this->Site_Logo->FormValue) && $this->Site_Logo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Site_Logo->FldCaption(), $this->Site_Logo->ReqErrMsg));
		}
		if (!$this->Site_Title->FldIsDetailKey && !is_null($this->Site_Title->FormValue) && $this->Site_Title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Site_Title->FldCaption(), $this->Site_Title->ReqErrMsg));
		}
		if (!$this->Terms_And_Condition_Text->FldIsDetailKey && !is_null($this->Terms_And_Condition_Text->FormValue) && $this->Terms_And_Condition_Text->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Terms_And_Condition_Text->FldCaption(), $this->Terms_And_Condition_Text->ReqErrMsg));
		}
		if (!$this->Announcement_Text->FldIsDetailKey && !is_null($this->Announcement_Text->FormValue) && $this->Announcement_Text->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Announcement_Text->FldCaption(), $this->Announcement_Text->ReqErrMsg));
		}
		if (!$this->About_Text->FldIsDetailKey && !is_null($this->About_Text->FormValue) && $this->About_Text->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->About_Text->FldCaption(), $this->About_Text->ReqErrMsg));
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

			// Language_Code
			// Language_Name

			$this->Language_Name->SetDbValueDef($rsnew, $this->Language_Name->CurrentValue, "", $this->Language_Name->ReadOnly);

			// Default
			$tmpBool = $this->_Default->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->_Default->SetDbValueDef($rsnew, $tmpBool, NULL, $this->_Default->ReadOnly);

			// Site_Logo
			$this->Site_Logo->SetDbValueDef($rsnew, $this->Site_Logo->CurrentValue, "", $this->Site_Logo->ReadOnly);

			// Site_Title
			$this->Site_Title->SetDbValueDef($rsnew, $this->Site_Title->CurrentValue, "", $this->Site_Title->ReadOnly);

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

			// Terms_And_Condition_Text
			$this->Terms_And_Condition_Text->SetDbValueDef($rsnew, $this->Terms_And_Condition_Text->CurrentValue, "", $this->Terms_And_Condition_Text->ReadOnly);

			// Announcement_Text
			$this->Announcement_Text->SetDbValueDef($rsnew, $this->Announcement_Text->CurrentValue, "", $this->Announcement_Text->ReadOnly);

			// About_Text
			$this->About_Text->SetDbValueDef($rsnew, $this->About_Text->CurrentValue, "", $this->About_Text->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("languageslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url); // v11.0.4
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
if (!isset($languages_edit)) $languages_edit = new clanguages_edit();

// Page init
$languages_edit->Page_Init();

// Page main
$languages_edit->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$languages_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = flanguagesedit = new ew_Form("flanguagesedit", "edit");

// Validate form
flanguagesedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Language_Code");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $languages->Language_Code->FldCaption(), $languages->Language_Code->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Language_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $languages->Language_Name->FldCaption(), $languages->Language_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Site_Logo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $languages->Site_Logo->FldCaption(), $languages->Site_Logo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Site_Title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $languages->Site_Title->FldCaption(), $languages->Site_Title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Terms_And_Condition_Text");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $languages->Terms_And_Condition_Text->FldCaption(), $languages->Terms_And_Condition_Text->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Announcement_Text");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $languages->Announcement_Text->FldCaption(), $languages->Announcement_Text->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_About_Text");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $languages->About_Text->FldCaption(), $languages->About_Text->ReqErrMsg)) ?>");

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
flanguagesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flanguagesedit.ValidateRequired = true;
<?php } else { ?>
flanguagesedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flanguagesedit.Lists["x__Default[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
flanguagesedit.Lists["x__Default[]"].Options = <?php echo json_encode($languages->_Default->Options()) ?>;

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
<?php $languages_edit->ShowPageHeader(); ?>
<?php
$languages_edit->ShowMessage();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($languages_edit->Pager)) $languages_edit->Pager = new cNumericPager($languages_edit->StartRec, $languages_edit->DisplayRecs, $languages_edit->TotalRecs, $languages_edit->RecRange) ?>
		<?php if ($languages_edit->Pager->RecordCount > 0) { ?>
				<?php if (($languages_edit->Pager->PageCount==1) && ($languages_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($languages_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($languages_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($languages_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $languages_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($languages_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($languages_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($languages_edit->Pager)) $languages_edit->Pager = new cPrevNextPager($languages_edit->StartRec, $languages_edit->DisplayRecs, $languages_edit->TotalRecs) ?>
		<?php if ($languages_edit->Pager->RecordCount > 0) { ?>
				<?php if (($languages_edit->Pager->PageCount==1) && ($languages_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($languages_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($languages_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $languages_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($languages_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($languages_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $languages_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
</form>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="flanguagesedit" id="flanguagesedit" class="<?php echo $languages_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($languages_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $languages_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="languages">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($languages->Language_Code->Visible) { // Language_Code ?>
	<div id="r_Language_Code" class="form-group">
		<label id="elh_languages_Language_Code" for="x_Language_Code" class="col-sm-4 control-label ewLabel"><?php echo $languages->Language_Code->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Language_Code->CellAttributes() ?>>
<span id="el_languages_Language_Code">
<span<?php echo $languages->Language_Code->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $languages->Language_Code->EditValue ?></p></span>
</span>
<input type="hidden" data-table="languages" data-field="x_Language_Code" name="x_Language_Code" id="x_Language_Code" value="<?php echo ew_HtmlEncode($languages->Language_Code->CurrentValue) ?>">
<?php echo $languages->Language_Code->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Language_Name->Visible) { // Language_Name ?>
	<div id="r_Language_Name" class="form-group">
		<label id="elh_languages_Language_Name" for="x_Language_Name" class="col-sm-4 control-label ewLabel"><?php echo $languages->Language_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Language_Name->CellAttributes() ?>>
<span id="el_languages_Language_Name">
<input type="text" data-table="languages" data-field="x_Language_Name" name="x_Language_Name" id="x_Language_Name" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($languages->Language_Name->getPlaceHolder()) ?>" value="<?php echo $languages->Language_Name->EditValue ?>"<?php echo $languages->Language_Name->EditAttributes() ?>>
</span>
<?php echo $languages->Language_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->_Default->Visible) { // Default ?>
	<div id="r__Default" class="form-group">
		<label id="elh_languages__Default" class="col-sm-4 control-label ewLabel"><?php echo $languages->_Default->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $languages->_Default->CellAttributes() ?>>
<span id="el_languages__Default">
<?php
$selwrk = (ew_ConvertToBool($languages->_Default->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="languages" data-field="x__Default" name="x__Default[]" id="x__Default[]" value="1"<?php echo $selwrk ?><?php echo $languages->_Default->EditAttributes() ?>>
</span>
<?php echo $languages->_Default->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Site_Logo->Visible) { // Site_Logo ?>
	<div id="r_Site_Logo" class="form-group">
		<label id="elh_languages_Site_Logo" for="x_Site_Logo" class="col-sm-4 control-label ewLabel"><?php echo $languages->Site_Logo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Site_Logo->CellAttributes() ?>>
<span id="el_languages_Site_Logo">
<input type="text" data-table="languages" data-field="x_Site_Logo" name="x_Site_Logo" id="x_Site_Logo" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($languages->Site_Logo->getPlaceHolder()) ?>" value="<?php echo $languages->Site_Logo->EditValue ?>"<?php echo $languages->Site_Logo->EditAttributes() ?>>
</span>
<?php echo $languages->Site_Logo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Site_Title->Visible) { // Site_Title ?>
	<div id="r_Site_Title" class="form-group">
		<label id="elh_languages_Site_Title" for="x_Site_Title" class="col-sm-4 control-label ewLabel"><?php echo $languages->Site_Title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Site_Title->CellAttributes() ?>>
<span id="el_languages_Site_Title">
<input type="text" data-table="languages" data-field="x_Site_Title" name="x_Site_Title" id="x_Site_Title" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($languages->Site_Title->getPlaceHolder()) ?>" value="<?php echo $languages->Site_Title->EditValue ?>"<?php echo $languages->Site_Title->EditAttributes() ?>>
</span>
<?php echo $languages->Site_Title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Default_Thousands_Separator->Visible) { // Default_Thousands_Separator ?>
	<div id="r_Default_Thousands_Separator" class="form-group">
		<label id="elh_languages_Default_Thousands_Separator" for="x_Default_Thousands_Separator" class="col-sm-4 control-label ewLabel"><?php echo $languages->Default_Thousands_Separator->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Default_Thousands_Separator->CellAttributes() ?>>
<span id="el_languages_Default_Thousands_Separator">
<input type="text" data-table="languages" data-field="x_Default_Thousands_Separator" name="x_Default_Thousands_Separator" id="x_Default_Thousands_Separator" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($languages->Default_Thousands_Separator->getPlaceHolder()) ?>" value="<?php echo $languages->Default_Thousands_Separator->EditValue ?>"<?php echo $languages->Default_Thousands_Separator->EditAttributes() ?>>
</span>
<?php echo $languages->Default_Thousands_Separator->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Default_Decimal_Point->Visible) { // Default_Decimal_Point ?>
	<div id="r_Default_Decimal_Point" class="form-group">
		<label id="elh_languages_Default_Decimal_Point" for="x_Default_Decimal_Point" class="col-sm-4 control-label ewLabel"><?php echo $languages->Default_Decimal_Point->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Default_Decimal_Point->CellAttributes() ?>>
<span id="el_languages_Default_Decimal_Point">
<input type="text" data-table="languages" data-field="x_Default_Decimal_Point" name="x_Default_Decimal_Point" id="x_Default_Decimal_Point" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($languages->Default_Decimal_Point->getPlaceHolder()) ?>" value="<?php echo $languages->Default_Decimal_Point->EditValue ?>"<?php echo $languages->Default_Decimal_Point->EditAttributes() ?>>
</span>
<?php echo $languages->Default_Decimal_Point->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Default_Currency_Symbol->Visible) { // Default_Currency_Symbol ?>
	<div id="r_Default_Currency_Symbol" class="form-group">
		<label id="elh_languages_Default_Currency_Symbol" for="x_Default_Currency_Symbol" class="col-sm-4 control-label ewLabel"><?php echo $languages->Default_Currency_Symbol->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Default_Currency_Symbol->CellAttributes() ?>>
<span id="el_languages_Default_Currency_Symbol">
<input type="text" data-table="languages" data-field="x_Default_Currency_Symbol" name="x_Default_Currency_Symbol" id="x_Default_Currency_Symbol" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($languages->Default_Currency_Symbol->getPlaceHolder()) ?>" value="<?php echo $languages->Default_Currency_Symbol->EditValue ?>"<?php echo $languages->Default_Currency_Symbol->EditAttributes() ?>>
</span>
<?php echo $languages->Default_Currency_Symbol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Default_Money_Thousands_Separator->Visible) { // Default_Money_Thousands_Separator ?>
	<div id="r_Default_Money_Thousands_Separator" class="form-group">
		<label id="elh_languages_Default_Money_Thousands_Separator" for="x_Default_Money_Thousands_Separator" class="col-sm-4 control-label ewLabel"><?php echo $languages->Default_Money_Thousands_Separator->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Default_Money_Thousands_Separator->CellAttributes() ?>>
<span id="el_languages_Default_Money_Thousands_Separator">
<input type="text" data-table="languages" data-field="x_Default_Money_Thousands_Separator" name="x_Default_Money_Thousands_Separator" id="x_Default_Money_Thousands_Separator" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($languages->Default_Money_Thousands_Separator->getPlaceHolder()) ?>" value="<?php echo $languages->Default_Money_Thousands_Separator->EditValue ?>"<?php echo $languages->Default_Money_Thousands_Separator->EditAttributes() ?>>
</span>
<?php echo $languages->Default_Money_Thousands_Separator->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Default_Money_Decimal_Point->Visible) { // Default_Money_Decimal_Point ?>
	<div id="r_Default_Money_Decimal_Point" class="form-group">
		<label id="elh_languages_Default_Money_Decimal_Point" for="x_Default_Money_Decimal_Point" class="col-sm-4 control-label ewLabel"><?php echo $languages->Default_Money_Decimal_Point->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Default_Money_Decimal_Point->CellAttributes() ?>>
<span id="el_languages_Default_Money_Decimal_Point">
<input type="text" data-table="languages" data-field="x_Default_Money_Decimal_Point" name="x_Default_Money_Decimal_Point" id="x_Default_Money_Decimal_Point" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($languages->Default_Money_Decimal_Point->getPlaceHolder()) ?>" value="<?php echo $languages->Default_Money_Decimal_Point->EditValue ?>"<?php echo $languages->Default_Money_Decimal_Point->EditAttributes() ?>>
</span>
<?php echo $languages->Default_Money_Decimal_Point->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Terms_And_Condition_Text->Visible) { // Terms_And_Condition_Text ?>
	<div id="r_Terms_And_Condition_Text" class="form-group">
		<label id="elh_languages_Terms_And_Condition_Text" for="x_Terms_And_Condition_Text" class="col-sm-4 control-label ewLabel"><?php echo $languages->Terms_And_Condition_Text->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Terms_And_Condition_Text->CellAttributes() ?>>
<span id="el_languages_Terms_And_Condition_Text">
<textarea data-table="languages" data-field="x_Terms_And_Condition_Text" name="x_Terms_And_Condition_Text" id="x_Terms_And_Condition_Text" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($languages->Terms_And_Condition_Text->getPlaceHolder()) ?>"<?php echo $languages->Terms_And_Condition_Text->EditAttributes() ?>><?php echo $languages->Terms_And_Condition_Text->EditValue ?></textarea>
</span>
<?php echo $languages->Terms_And_Condition_Text->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->Announcement_Text->Visible) { // Announcement_Text ?>
	<div id="r_Announcement_Text" class="form-group">
		<label id="elh_languages_Announcement_Text" for="x_Announcement_Text" class="col-sm-4 control-label ewLabel"><?php echo $languages->Announcement_Text->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $languages->Announcement_Text->CellAttributes() ?>>
<span id="el_languages_Announcement_Text">
<textarea data-table="languages" data-field="x_Announcement_Text" name="x_Announcement_Text" id="x_Announcement_Text" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($languages->Announcement_Text->getPlaceHolder()) ?>"<?php echo $languages->Announcement_Text->EditAttributes() ?>><?php echo $languages->Announcement_Text->EditValue ?></textarea>
</span>
<?php echo $languages->Announcement_Text->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($languages->About_Text->Visible) { // About_Text ?>
	<div id="r_About_Text" class="form-group">
		<label id="elh_languages_About_Text" for="x_About_Text" class="col-sm-4 control-label ewLabel"><?php echo $languages->About_Text->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $languages->About_Text->CellAttributes() ?>>
<span id="el_languages_About_Text">
<textarea data-table="languages" data-field="x_About_Text" name="x_About_Text" id="x_About_Text" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($languages->About_Text->getPlaceHolder()) ?>"<?php echo $languages->About_Text->EditAttributes() ?>><?php echo $languages->About_Text->EditValue ?></textarea>
</span>
<?php echo $languages->About_Text->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $languages_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($languages_edit->Pager)) $languages_edit->Pager = new cNumericPager($languages_edit->StartRec, $languages_edit->DisplayRecs, $languages_edit->TotalRecs, $languages_edit->RecRange) ?>
		<?php if ($languages_edit->Pager->RecordCount > 0) { ?>
				<?php if (($languages_edit->Pager->PageCount==1) && ($languages_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($languages_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($languages_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($languages_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $languages_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($languages_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($languages_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($languages_edit->Pager)) $languages_edit->Pager = new cPrevNextPager($languages_edit->StartRec, $languages_edit->DisplayRecs, $languages_edit->TotalRecs) ?>
		<?php if ($languages_edit->Pager->RecordCount > 0) { ?>
				<?php if (($languages_edit->Pager->PageCount==1) && ($languages_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($languages_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($languages_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $languages_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($languages_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($languages_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $languages_edit->PageUrl() ?>start=<?php echo $languages_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $languages_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
</form>
<script type="text/javascript">
flanguagesedit.Init();
</script>
<?php
$languages_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#flanguagesedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($languages->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyEdit(this)'); function alertifyEdit(obj) { <?php global $Language; ?> if (flanguagesedit.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyEditConfirm'); ?>", function (e) {	if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyEdit'); ?>"); $("#flanguagesedit").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$languages_edit->Page_Terminate();
?>
