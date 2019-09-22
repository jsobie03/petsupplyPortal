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

$announcement_edit = NULL; // Initialize page object first

class cannouncement_edit extends cannouncement {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'announcement';

	// Page object name
	var $PageObjName = 'announcement_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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

		// Create form object
		$objForm = new cFormObj();
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
		if (@$_GET["Announcement_ID"] <> "") {
			$this->Announcement_ID->setQueryStringValue($_GET["Announcement_ID"]);
			$this->RecKey["Announcement_ID"] = $this->Announcement_ID->QueryStringValue;
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
			$this->Page_Terminate("announcementlist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->Announcement_ID->CurrentValue) == strval($this->Recordset->fields('Announcement_ID'))) {
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
					$this->Page_Terminate("announcementlist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "announcementlist.php")
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
		if (!$this->Announcement_ID->FldIsDetailKey)
			$this->Announcement_ID->setFormValue($objForm->GetValue("x_Announcement_ID"));
		if (!$this->Is_Active->FldIsDetailKey) {
			$this->Is_Active->setFormValue($objForm->GetValue("x_Is_Active"));
		}
		if (!$this->Topic->FldIsDetailKey) {
			$this->Topic->setFormValue($objForm->GetValue("x_Topic"));
		}
		if (!$this->Message->FldIsDetailKey) {
			$this->Message->setFormValue($objForm->GetValue("x_Message"));
		}
		if (!$this->Date_LastUpdate->FldIsDetailKey) {
			$this->Date_LastUpdate->setFormValue($objForm->GetValue("x_Date_LastUpdate"));
			$this->Date_LastUpdate->CurrentValue = ew_UnFormatDateTime($this->Date_LastUpdate->CurrentValue, 9);
		}
		if (!$this->_Language->FldIsDetailKey) {
			$this->_Language->setFormValue($objForm->GetValue("x__Language"));
		}
		if (!$this->Auto_Publish->FldIsDetailKey) {
			$this->Auto_Publish->setFormValue($objForm->GetValue("x_Auto_Publish"));
		}
		if (!$this->Date_Start->FldIsDetailKey) {
			$this->Date_Start->setFormValue($objForm->GetValue("x_Date_Start"));
			$this->Date_Start->CurrentValue = ew_UnFormatDateTime($this->Date_Start->CurrentValue, 9);
		}
		if (!$this->Date_End->FldIsDetailKey) {
			$this->Date_End->setFormValue($objForm->GetValue("x_Date_End"));
			$this->Date_End->CurrentValue = ew_UnFormatDateTime($this->Date_End->CurrentValue, 9);
		}
		if (!$this->Date_Created->FldIsDetailKey) {
			$this->Date_Created->setFormValue($objForm->GetValue("x_Date_Created"));
			$this->Date_Created->CurrentValue = ew_UnFormatDateTime($this->Date_Created->CurrentValue, 9);
		}
		if (!$this->Created_By->FldIsDetailKey) {
			$this->Created_By->setFormValue($objForm->GetValue("x_Created_By"));
		}
		if (!$this->Translated_ID->FldIsDetailKey) {
			$this->Translated_ID->setFormValue($objForm->GetValue("x_Translated_ID"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Announcement_ID->CurrentValue = $this->Announcement_ID->FormValue;
		$this->Is_Active->CurrentValue = $this->Is_Active->FormValue;
		$this->Topic->CurrentValue = $this->Topic->FormValue;
		$this->Message->CurrentValue = $this->Message->FormValue;
		$this->Date_LastUpdate->CurrentValue = $this->Date_LastUpdate->FormValue;
		$this->Date_LastUpdate->CurrentValue = ew_UnFormatDateTime($this->Date_LastUpdate->CurrentValue, 9);
		$this->_Language->CurrentValue = $this->_Language->FormValue;
		$this->Auto_Publish->CurrentValue = $this->Auto_Publish->FormValue;
		$this->Date_Start->CurrentValue = $this->Date_Start->FormValue;
		$this->Date_Start->CurrentValue = ew_UnFormatDateTime($this->Date_Start->CurrentValue, 9);
		$this->Date_End->CurrentValue = $this->Date_End->FormValue;
		$this->Date_End->CurrentValue = ew_UnFormatDateTime($this->Date_End->CurrentValue, 9);
		$this->Date_Created->CurrentValue = $this->Date_Created->FormValue;
		$this->Date_Created->CurrentValue = ew_UnFormatDateTime($this->Date_Created->CurrentValue, 9);
		$this->Created_By->CurrentValue = $this->Created_By->FormValue;
		$this->Translated_ID->CurrentValue = $this->Translated_ID->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
			$this->Topic->EditValue = ew_HtmlEncode($this->Topic->CurrentValue);
			$this->Topic->PlaceHolder = ew_RemoveHtml($this->Topic->FldCaption());

			// Message
			$this->Message->EditAttrs["class"] = "form-control";
			$this->Message->EditCustomAttributes = "";
			$this->Message->EditValue = ew_HtmlEncode($this->Message->CurrentValue);
			$this->Message->PlaceHolder = ew_RemoveHtml($this->Message->FldCaption());

			// Date_LastUpdate
			$this->Date_LastUpdate->EditAttrs["class"] = "form-control";
			$this->Date_LastUpdate->EditCustomAttributes = "";
			$this->Date_LastUpdate->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Date_LastUpdate->CurrentValue, 9));
			$this->Date_LastUpdate->PlaceHolder = ew_RemoveHtml($this->Date_LastUpdate->FldCaption());

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

			// Auto_Publish
			$this->Auto_Publish->EditCustomAttributes = "";
			$this->Auto_Publish->EditValue = $this->Auto_Publish->Options(FALSE);

			// Date_Start
			$this->Date_Start->EditAttrs["class"] = "form-control";
			$this->Date_Start->EditCustomAttributes = "";
			$this->Date_Start->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Date_Start->CurrentValue, 9));
			$this->Date_Start->PlaceHolder = ew_RemoveHtml($this->Date_Start->FldCaption());

			// Date_End
			$this->Date_End->EditAttrs["class"] = "form-control";
			$this->Date_End->EditCustomAttributes = "";
			$this->Date_End->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Date_End->CurrentValue, 9));
			$this->Date_End->PlaceHolder = ew_RemoveHtml($this->Date_End->FldCaption());

			// Date_Created
			$this->Date_Created->EditAttrs["class"] = "form-control";
			$this->Date_Created->EditCustomAttributes = "";
			$this->Date_Created->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Date_Created->CurrentValue, 9));
			$this->Date_Created->PlaceHolder = ew_RemoveHtml($this->Date_Created->FldCaption());

			// Created_By
			$this->Created_By->EditAttrs["class"] = "form-control";
			$this->Created_By->EditCustomAttributes = "";
			$this->Created_By->EditValue = ew_HtmlEncode($this->Created_By->CurrentValue);
			$this->Created_By->PlaceHolder = ew_RemoveHtml($this->Created_By->FldCaption());

			// Translated_ID
			$this->Translated_ID->EditAttrs["class"] = "form-control";
			$this->Translated_ID->EditCustomAttributes = "";
			if (trim(strval($this->Translated_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Announcement_ID`" . ew_SearchString("=", $this->Translated_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Announcement_ID`, `Topic` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `announcement`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `Announcement_ID`, `Topic` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `announcement`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Translated_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Translated_ID->EditValue = $arwrk;

			// Edit refer script
			// Announcement_ID

			$this->Announcement_ID->LinkCustomAttributes = "";
			$this->Announcement_ID->HrefValue = "";

			// Is_Active
			$this->Is_Active->LinkCustomAttributes = "";
			$this->Is_Active->HrefValue = "";

			// Topic
			$this->Topic->LinkCustomAttributes = "";
			$this->Topic->HrefValue = "";

			// Message
			$this->Message->LinkCustomAttributes = "";
			$this->Message->HrefValue = "";

			// Date_LastUpdate
			$this->Date_LastUpdate->LinkCustomAttributes = "";
			$this->Date_LastUpdate->HrefValue = "";

			// Language
			$this->_Language->LinkCustomAttributes = "";
			$this->_Language->HrefValue = "";

			// Auto_Publish
			$this->Auto_Publish->LinkCustomAttributes = "";
			$this->Auto_Publish->HrefValue = "";

			// Date_Start
			$this->Date_Start->LinkCustomAttributes = "";
			$this->Date_Start->HrefValue = "";

			// Date_End
			$this->Date_End->LinkCustomAttributes = "";
			$this->Date_End->HrefValue = "";

			// Date_Created
			$this->Date_Created->LinkCustomAttributes = "";
			$this->Date_Created->HrefValue = "";

			// Created_By
			$this->Created_By->LinkCustomAttributes = "";
			$this->Created_By->HrefValue = "";

			// Translated_ID
			$this->Translated_ID->LinkCustomAttributes = "";
			$this->Translated_ID->HrefValue = "";
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
		if (!$this->Topic->FldIsDetailKey && !is_null($this->Topic->FormValue) && $this->Topic->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Topic->FldCaption(), $this->Topic->ReqErrMsg));
		}
		if (!$this->Message->FldIsDetailKey && !is_null($this->Message->FormValue) && $this->Message->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Message->FldCaption(), $this->Message->ReqErrMsg));
		}
		if (!ew_CheckDate($this->Date_LastUpdate->FormValue)) {
			ew_AddMessage($gsFormError, $this->Date_LastUpdate->FldErrMsg());
		}
		if (!$this->_Language->FldIsDetailKey && !is_null($this->_Language->FormValue) && $this->_Language->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_Language->FldCaption(), $this->_Language->ReqErrMsg));
		}
		if (!ew_CheckDate($this->Date_Start->FormValue)) {
			ew_AddMessage($gsFormError, $this->Date_Start->FldErrMsg());
		}
		if (!ew_CheckDate($this->Date_End->FormValue)) {
			ew_AddMessage($gsFormError, $this->Date_End->FldErrMsg());
		}
		if (!ew_CheckDate($this->Date_Created->FormValue)) {
			ew_AddMessage($gsFormError, $this->Date_Created->FldErrMsg());
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

			// Is_Active
			$tmpBool = $this->Is_Active->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Is_Active->SetDbValueDef($rsnew, $tmpBool, "N", $this->Is_Active->ReadOnly);

			// Topic
			$this->Topic->SetDbValueDef($rsnew, $this->Topic->CurrentValue, "", $this->Topic->ReadOnly);

			// Message
			$this->Message->SetDbValueDef($rsnew, $this->Message->CurrentValue, "", $this->Message->ReadOnly);

			// Date_LastUpdate
			$this->Date_LastUpdate->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Date_LastUpdate->CurrentValue, 9), NULL, $this->Date_LastUpdate->ReadOnly);

			// Language
			$this->_Language->SetDbValueDef($rsnew, $this->_Language->CurrentValue, "", $this->_Language->ReadOnly);

			// Auto_Publish
			$tmpBool = $this->Auto_Publish->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Auto_Publish->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Auto_Publish->ReadOnly);

			// Date_Start
			$this->Date_Start->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Date_Start->CurrentValue, 9), NULL, $this->Date_Start->ReadOnly);

			// Date_End
			$this->Date_End->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Date_End->CurrentValue, 9), NULL, $this->Date_End->ReadOnly);

			// Date_Created
			$this->Date_Created->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Date_Created->CurrentValue, 9), NULL, $this->Date_Created->ReadOnly);

			// Created_By
			$this->Created_By->SetDbValueDef($rsnew, $this->Created_By->CurrentValue, NULL, $this->Created_By->ReadOnly);

			// Translated_ID
			$this->Translated_ID->SetDbValueDef($rsnew, $this->Translated_ID->CurrentValue, NULL, $this->Translated_ID->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("announcementlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($announcement_edit)) $announcement_edit = new cannouncement_edit();

// Page init
$announcement_edit->Page_Init();

// Page main
$announcement_edit->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$announcement_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fannouncementedit = new ew_Form("fannouncementedit", "edit");

// Validate form
fannouncementedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Is_Active[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $announcement->Is_Active->FldCaption(), $announcement->Is_Active->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Topic");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $announcement->Topic->FldCaption(), $announcement->Topic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Message");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $announcement->Message->FldCaption(), $announcement->Message->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Date_LastUpdate");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($announcement->Date_LastUpdate->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "__Language");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $announcement->_Language->FldCaption(), $announcement->_Language->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Date_Start");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($announcement->Date_Start->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Date_End");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($announcement->Date_End->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Date_Created");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($announcement->Date_Created->FldErrMsg()) ?>");

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
fannouncementedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fannouncementedit.ValidateRequired = true;
<?php } else { ?>
fannouncementedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fannouncementedit.Lists["x_Is_Active[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fannouncementedit.Lists["x_Is_Active[]"].Options = <?php echo json_encode($announcement->Is_Active->Options()) ?>;
fannouncementedit.Lists["x__Language"] = {"LinkField":"x_Language_Code","Ajax":true,"AutoFill":false,"DisplayFields":["x_Language_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fannouncementedit.Lists["x_Auto_Publish[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fannouncementedit.Lists["x_Auto_Publish[]"].Options = <?php echo json_encode($announcement->Auto_Publish->Options()) ?>;
fannouncementedit.Lists["x_Translated_ID"] = {"LinkField":"x_Announcement_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Topic","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $announcement_edit->ShowPageHeader(); ?>
<?php
$announcement_edit->ShowMessage();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($announcement_edit->Pager)) $announcement_edit->Pager = new cNumericPager($announcement_edit->StartRec, $announcement_edit->DisplayRecs, $announcement_edit->TotalRecs, $announcement_edit->RecRange) ?>
		<?php if ($announcement_edit->Pager->RecordCount > 0) { ?>
				<?php if (($announcement_edit->Pager->PageCount==1) && ($announcement_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($announcement_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($announcement_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($announcement_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $announcement_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($announcement_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($announcement_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($announcement_edit->Pager)) $announcement_edit->Pager = new cPrevNextPager($announcement_edit->StartRec, $announcement_edit->DisplayRecs, $announcement_edit->TotalRecs) ?>
		<?php if ($announcement_edit->Pager->RecordCount > 0) { ?>
				<?php if (($announcement_edit->Pager->PageCount==1) && ($announcement_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($announcement_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($announcement_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $announcement_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($announcement_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($announcement_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $announcement_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
</form>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="fannouncementedit" id="fannouncementedit" class="<?php echo $announcement_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($announcement_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $announcement_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="announcement">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($announcement->Announcement_ID->Visible) { // Announcement_ID ?>
	<div id="r_Announcement_ID" class="form-group">
		<label id="elh_announcement_Announcement_ID" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Announcement_ID->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Announcement_ID->CellAttributes() ?>>
<span id="el_announcement_Announcement_ID">
<span<?php echo $announcement->Announcement_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $announcement->Announcement_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="announcement" data-field="x_Announcement_ID" name="x_Announcement_ID" id="x_Announcement_ID" value="<?php echo ew_HtmlEncode($announcement->Announcement_ID->CurrentValue) ?>">
<?php echo $announcement->Announcement_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Is_Active->Visible) { // Is_Active ?>
	<div id="r_Is_Active" class="form-group">
		<label id="elh_announcement_Is_Active" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Is_Active->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Is_Active->CellAttributes() ?>>
<span id="el_announcement_Is_Active">
<?php
$selwrk = (ew_ConvertToBool($announcement->Is_Active->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="announcement" data-field="x_Is_Active" name="x_Is_Active[]" id="x_Is_Active[]" value="1"<?php echo $selwrk ?><?php echo $announcement->Is_Active->EditAttributes() ?>>
</span>
<?php echo $announcement->Is_Active->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Topic->Visible) { // Topic ?>
	<div id="r_Topic" class="form-group">
		<label id="elh_announcement_Topic" for="x_Topic" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Topic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Topic->CellAttributes() ?>>
<span id="el_announcement_Topic">
<input type="text" data-table="announcement" data-field="x_Topic" name="x_Topic" id="x_Topic" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($announcement->Topic->getPlaceHolder()) ?>" value="<?php echo $announcement->Topic->EditValue ?>"<?php echo $announcement->Topic->EditAttributes() ?>>
</span>
<?php echo $announcement->Topic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Message->Visible) { // Message ?>
	<div id="r_Message" class="form-group">
		<label id="elh_announcement_Message" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Message->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Message->CellAttributes() ?>>
<span id="el_announcement_Message">
<?php ew_AppendClass($announcement->Message->EditAttrs["class"], "editor"); ?>
<textarea data-table="announcement" data-field="x_Message" name="x_Message" id="x_Message" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($announcement->Message->getPlaceHolder()) ?>"<?php echo $announcement->Message->EditAttributes() ?>><?php echo $announcement->Message->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fannouncementedit", "x_Message", 35, 4, <?php echo ($announcement->Message->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $announcement->Message->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Date_LastUpdate->Visible) { // Date_LastUpdate ?>
	<div id="r_Date_LastUpdate" class="form-group">
		<label id="elh_announcement_Date_LastUpdate" for="x_Date_LastUpdate" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Date_LastUpdate->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Date_LastUpdate->CellAttributes() ?>>
<span id="el_announcement_Date_LastUpdate">
<input type="text" data-table="announcement" data-field="x_Date_LastUpdate" data-format="9" name="x_Date_LastUpdate" id="x_Date_LastUpdate" placeholder="<?php echo ew_HtmlEncode($announcement->Date_LastUpdate->getPlaceHolder()) ?>" value="<?php echo $announcement->Date_LastUpdate->EditValue ?>"<?php echo $announcement->Date_LastUpdate->EditAttributes() ?>>
</span>
<?php echo $announcement->Date_LastUpdate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->_Language->Visible) { // Language ?>
	<div id="r__Language" class="form-group">
		<label id="elh_announcement__Language" for="x__Language" class="col-sm-4 control-label ewLabel"><?php echo $announcement->_Language->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->_Language->CellAttributes() ?>>
<span id="el_announcement__Language">
<select data-table="announcement" data-field="x__Language" data-value-separator="<?php echo ew_HtmlEncode(is_array($announcement->_Language->DisplayValueSeparator) ? json_encode($announcement->_Language->DisplayValueSeparator) : $announcement->_Language->DisplayValueSeparator) ?>" id="x__Language" name="x__Language"<?php echo $announcement->_Language->EditAttributes() ?>>
<?php
if (is_array($announcement->_Language->EditValue)) {
	$arwrk = $announcement->_Language->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($announcement->_Language->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $announcement->_Language->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($announcement->_Language->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($announcement->_Language->CurrentValue) ?>" selected><?php echo $announcement->_Language->CurrentValue ?></option>
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
$announcement->_Language->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$announcement->_Language->LookupFilters += array("f0" => "`Language_Code` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$announcement->Lookup_Selecting($announcement->_Language, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $announcement->_Language->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x__Language" id="s_x__Language" value="<?php echo $announcement->_Language->LookupFilterQuery() ?>">
</span>
<?php echo $announcement->_Language->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Auto_Publish->Visible) { // Auto_Publish ?>
	<div id="r_Auto_Publish" class="form-group">
		<label id="elh_announcement_Auto_Publish" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Auto_Publish->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Auto_Publish->CellAttributes() ?>>
<span id="el_announcement_Auto_Publish">
<?php
$selwrk = (ew_ConvertToBool($announcement->Auto_Publish->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="announcement" data-field="x_Auto_Publish" name="x_Auto_Publish[]" id="x_Auto_Publish[]" value="1"<?php echo $selwrk ?><?php echo $announcement->Auto_Publish->EditAttributes() ?>>
</span>
<?php echo $announcement->Auto_Publish->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Date_Start->Visible) { // Date_Start ?>
	<div id="r_Date_Start" class="form-group">
		<label id="elh_announcement_Date_Start" for="x_Date_Start" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Date_Start->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Date_Start->CellAttributes() ?>>
<span id="el_announcement_Date_Start">
<input type="text" data-table="announcement" data-field="x_Date_Start" data-format="9" name="x_Date_Start" id="x_Date_Start" placeholder="<?php echo ew_HtmlEncode($announcement->Date_Start->getPlaceHolder()) ?>" value="<?php echo $announcement->Date_Start->EditValue ?>"<?php echo $announcement->Date_Start->EditAttributes() ?>>
<?php if (!$announcement->Date_Start->ReadOnly && !$announcement->Date_Start->Disabled && !isset($announcement->Date_Start->EditAttrs["readonly"]) && !isset($announcement->Date_Start->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fannouncementedit", "x_Date_Start", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php echo $announcement->Date_Start->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Date_End->Visible) { // Date_End ?>
	<div id="r_Date_End" class="form-group">
		<label id="elh_announcement_Date_End" for="x_Date_End" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Date_End->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Date_End->CellAttributes() ?>>
<span id="el_announcement_Date_End">
<input type="text" data-table="announcement" data-field="x_Date_End" data-format="9" name="x_Date_End" id="x_Date_End" placeholder="<?php echo ew_HtmlEncode($announcement->Date_End->getPlaceHolder()) ?>" value="<?php echo $announcement->Date_End->EditValue ?>"<?php echo $announcement->Date_End->EditAttributes() ?>>
<?php if (!$announcement->Date_End->ReadOnly && !$announcement->Date_End->Disabled && !isset($announcement->Date_End->EditAttrs["readonly"]) && !isset($announcement->Date_End->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fannouncementedit", "x_Date_End", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php echo $announcement->Date_End->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Date_Created->Visible) { // Date_Created ?>
	<div id="r_Date_Created" class="form-group">
		<label id="elh_announcement_Date_Created" for="x_Date_Created" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Date_Created->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Date_Created->CellAttributes() ?>>
<span id="el_announcement_Date_Created">
<input type="text" data-table="announcement" data-field="x_Date_Created" data-format="9" name="x_Date_Created" id="x_Date_Created" placeholder="<?php echo ew_HtmlEncode($announcement->Date_Created->getPlaceHolder()) ?>" value="<?php echo $announcement->Date_Created->EditValue ?>"<?php echo $announcement->Date_Created->EditAttributes() ?>>
<?php if (!$announcement->Date_Created->ReadOnly && !$announcement->Date_Created->Disabled && !isset($announcement->Date_Created->EditAttrs["readonly"]) && !isset($announcement->Date_Created->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fannouncementedit", "x_Date_Created", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php echo $announcement->Date_Created->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Created_By->Visible) { // Created_By ?>
	<div id="r_Created_By" class="form-group">
		<label id="elh_announcement_Created_By" for="x_Created_By" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Created_By->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Created_By->CellAttributes() ?>>
<span id="el_announcement_Created_By">
<input type="text" data-table="announcement" data-field="x_Created_By" name="x_Created_By" id="x_Created_By" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($announcement->Created_By->getPlaceHolder()) ?>" value="<?php echo $announcement->Created_By->EditValue ?>"<?php echo $announcement->Created_By->EditAttributes() ?>>
</span>
<?php echo $announcement->Created_By->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($announcement->Translated_ID->Visible) { // Translated_ID ?>
	<div id="r_Translated_ID" class="form-group">
		<label id="elh_announcement_Translated_ID" for="x_Translated_ID" class="col-sm-4 control-label ewLabel"><?php echo $announcement->Translated_ID->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $announcement->Translated_ID->CellAttributes() ?>>
<span id="el_announcement_Translated_ID">
<select data-table="announcement" data-field="x_Translated_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($announcement->Translated_ID->DisplayValueSeparator) ? json_encode($announcement->Translated_ID->DisplayValueSeparator) : $announcement->Translated_ID->DisplayValueSeparator) ?>" id="x_Translated_ID" name="x_Translated_ID"<?php echo $announcement->Translated_ID->EditAttributes() ?>>
<?php
if (is_array($announcement->Translated_ID->EditValue)) {
	$arwrk = $announcement->Translated_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($announcement->Translated_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $announcement->Translated_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($announcement->Translated_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($announcement->Translated_ID->CurrentValue) ?>" selected><?php echo $announcement->Translated_ID->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
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
$announcement->Translated_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$announcement->Translated_ID->LookupFilters += array("f0" => "`Announcement_ID` = {filter_value}", "t0" => "19", "fn0" => "");
$sSqlWrk = "";
$announcement->Lookup_Selecting($announcement->Translated_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $announcement->Translated_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Translated_ID" id="s_x_Translated_ID" value="<?php echo $announcement->Translated_ID->LookupFilterQuery() ?>">
</span>
<?php echo $announcement->Translated_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $announcement_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($announcement_edit->Pager)) $announcement_edit->Pager = new cNumericPager($announcement_edit->StartRec, $announcement_edit->DisplayRecs, $announcement_edit->TotalRecs, $announcement_edit->RecRange) ?>
		<?php if ($announcement_edit->Pager->RecordCount > 0) { ?>
				<?php if (($announcement_edit->Pager->PageCount==1) && ($announcement_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($announcement_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($announcement_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($announcement_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $announcement_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($announcement_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($announcement_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($announcement_edit->Pager)) $announcement_edit->Pager = new cPrevNextPager($announcement_edit->StartRec, $announcement_edit->DisplayRecs, $announcement_edit->TotalRecs) ?>
		<?php if ($announcement_edit->Pager->RecordCount > 0) { ?>
				<?php if (($announcement_edit->Pager->PageCount==1) && ($announcement_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($announcement_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($announcement_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $announcement_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($announcement_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($announcement_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $announcement_edit->PageUrl() ?>start=<?php echo $announcement_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $announcement_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
</form>
<script type="text/javascript">
fannouncementedit.Init();
</script>
<?php
$announcement_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fannouncementedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($announcement->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyEdit(this)'); function alertifyEdit(obj) { <?php global $Language; ?> if (fannouncementedit.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyEditConfirm'); ?>", function (e) {	if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyEdit'); ?>"); $("#fannouncementedit").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$announcement_edit->Page_Terminate();
?>
