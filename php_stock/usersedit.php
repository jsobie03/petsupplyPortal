<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$users_edit = NULL; // Initialize page object first

class cusers_edit extends cusers {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_edit';

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

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

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
		if (!isset($_SESSION['table_users_views'])) { 
			$_SESSION['table_users_views'] = 0;
		}
		$_SESSION['table_users_views'] = $_SESSION['table_users_views']+1;

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
				$this->Page_Terminate(ew_GetUrl("userslist.php"));
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
		global $EW_EXPORT, $users;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($users);
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
		if (@$_GET["Username"] <> "") {
			$this->Username->setQueryStringValue($_GET["Username"]);
			$this->RecKey["Username"] = $this->Username->QueryStringValue;
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
			$this->Page_Terminate("userslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->Username->CurrentValue) == strval($this->Recordset->fields('Username'))) {
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
					$this->Page_Terminate("userslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "userslist.php")
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
		if (!$this->Username->FldIsDetailKey) {
			$this->Username->setFormValue($objForm->GetValue("x_Username"));
		}
		if (!$this->Password->FldIsDetailKey) {
			$this->Password->setFormValue($objForm->GetValue("x_Password"));
		}
		if (!$this->First_Name->FldIsDetailKey) {
			$this->First_Name->setFormValue($objForm->GetValue("x_First_Name"));
		}
		if (!$this->Last_Name->FldIsDetailKey) {
			$this->Last_Name->setFormValue($objForm->GetValue("x_Last_Name"));
		}
		if (!$this->_Email->FldIsDetailKey) {
			$this->_Email->setFormValue($objForm->GetValue("x__Email"));
		}
		if (!$this->User_Level->FldIsDetailKey) {
			$this->User_Level->setFormValue($objForm->GetValue("x_User_Level"));
		}
		if (!$this->Report_To->FldIsDetailKey) {
			$this->Report_To->setFormValue($objForm->GetValue("x_Report_To"));
		}
		if (!$this->Activated->FldIsDetailKey) {
			$this->Activated->setFormValue($objForm->GetValue("x_Activated"));
		}
		if (!$this->Locked->FldIsDetailKey) {
			$this->Locked->setFormValue($objForm->GetValue("x_Locked"));
		}
		if (!$this->Profile->FldIsDetailKey) {
			$this->Profile->setFormValue($objForm->GetValue("x_Profile"));
		}
		if (!$this->Current_URL->FldIsDetailKey) {
			$this->Current_URL->setFormValue($objForm->GetValue("x_Current_URL"));
		}
		if (!$this->Theme->FldIsDetailKey) {
			$this->Theme->setFormValue($objForm->GetValue("x_Theme"));
		}
		if (!$this->Menu_Horizontal->FldIsDetailKey) {
			$this->Menu_Horizontal->setFormValue($objForm->GetValue("x_Menu_Horizontal"));
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
		if (!$this->Rows_Vertical_Align_Top->FldIsDetailKey) {
			$this->Rows_Vertical_Align_Top->setFormValue($objForm->GetValue("x_Rows_Vertical_Align_Top"));
		}
		if (!$this->_Language->FldIsDetailKey) {
			$this->_Language->setFormValue($objForm->GetValue("x__Language"));
		}
		if (!$this->Redirect_To_Last_Visited_Page_After_Login->FldIsDetailKey) {
			$this->Redirect_To_Last_Visited_Page_After_Login->setFormValue($objForm->GetValue("x_Redirect_To_Last_Visited_Page_After_Login"));
		}
		if (!$this->Font_Name->FldIsDetailKey) {
			$this->Font_Name->setFormValue($objForm->GetValue("x_Font_Name"));
		}
		if (!$this->Font_Size->FldIsDetailKey) {
			$this->Font_Size->setFormValue($objForm->GetValue("x_Font_Size"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Username->CurrentValue = $this->Username->FormValue;
		$this->Password->CurrentValue = $this->Password->FormValue;
		$this->First_Name->CurrentValue = $this->First_Name->FormValue;
		$this->Last_Name->CurrentValue = $this->Last_Name->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
		$this->User_Level->CurrentValue = $this->User_Level->FormValue;
		$this->Report_To->CurrentValue = $this->Report_To->FormValue;
		$this->Activated->CurrentValue = $this->Activated->FormValue;
		$this->Locked->CurrentValue = $this->Locked->FormValue;
		$this->Profile->CurrentValue = $this->Profile->FormValue;
		$this->Current_URL->CurrentValue = $this->Current_URL->FormValue;
		$this->Theme->CurrentValue = $this->Theme->FormValue;
		$this->Menu_Horizontal->CurrentValue = $this->Menu_Horizontal->FormValue;
		$this->Table_Width_Style->CurrentValue = $this->Table_Width_Style->FormValue;
		$this->Scroll_Table_Width->CurrentValue = $this->Scroll_Table_Width->FormValue;
		$this->Scroll_Table_Height->CurrentValue = $this->Scroll_Table_Height->FormValue;
		$this->Rows_Vertical_Align_Top->CurrentValue = $this->Rows_Vertical_Align_Top->FormValue;
		$this->_Language->CurrentValue = $this->_Language->FormValue;
		$this->Redirect_To_Last_Visited_Page_After_Login->CurrentValue = $this->Redirect_To_Last_Visited_Page_After_Login->FormValue;
		$this->Font_Name->CurrentValue = $this->Font_Name->FormValue;
		$this->Font_Size->CurrentValue = $this->Font_Size->FormValue;
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Username->DbValue = $row['Username'];
		$this->Password->DbValue = $row['Password'];
		$this->First_Name->DbValue = $row['First_Name'];
		$this->Last_Name->DbValue = $row['Last_Name'];
		$this->_Email->DbValue = $row['Email'];
		$this->User_Level->DbValue = $row['User_Level'];
		$this->Report_To->DbValue = $row['Report_To'];
		$this->Activated->DbValue = $row['Activated'];
		$this->Locked->DbValue = $row['Locked'];
		$this->Profile->DbValue = $row['Profile'];
		$this->Current_URL->DbValue = $row['Current_URL'];
		$this->Theme->DbValue = $row['Theme'];
		$this->Menu_Horizontal->DbValue = $row['Menu_Horizontal'];
		$this->Table_Width_Style->DbValue = $row['Table_Width_Style'];
		$this->Scroll_Table_Width->DbValue = $row['Scroll_Table_Width'];
		$this->Scroll_Table_Height->DbValue = $row['Scroll_Table_Height'];
		$this->Rows_Vertical_Align_Top->DbValue = $row['Rows_Vertical_Align_Top'];
		$this->_Language->DbValue = $row['Language'];
		$this->Redirect_To_Last_Visited_Page_After_Login->DbValue = $row['Redirect_To_Last_Visited_Page_After_Login'];
		$this->Font_Name->DbValue = $row['Font_Name'];
		$this->Font_Size->DbValue = $row['Font_Size'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Username
			$this->Username->EditAttrs["class"] = "form-control";
			$this->Username->EditCustomAttributes = "";
			$this->Username->EditValue = $this->Username->CurrentValue;
			$this->Username->ViewCustomAttributes = "";

			// Password
			$this->Password->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->Password->EditCustomAttributes = "";
			$this->Password->EditValue = ew_HtmlEncode($this->Password->CurrentValue);
			$this->Password->PlaceHolder = ew_RemoveHtml($this->Password->FldCaption());

			// First_Name
			$this->First_Name->EditAttrs["class"] = "form-control";
			$this->First_Name->EditCustomAttributes = "";
			$this->First_Name->EditValue = ew_HtmlEncode($this->First_Name->CurrentValue);
			$this->First_Name->PlaceHolder = ew_RemoveHtml($this->First_Name->FldCaption());

			// Last_Name
			$this->Last_Name->EditAttrs["class"] = "form-control";
			$this->Last_Name->EditCustomAttributes = "";
			$this->Last_Name->EditValue = ew_HtmlEncode($this->Last_Name->CurrentValue);
			$this->Last_Name->PlaceHolder = ew_RemoveHtml($this->Last_Name->FldCaption());

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue = ew_HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

			// User_Level
			$this->User_Level->EditAttrs["class"] = "form-control";
			$this->User_Level->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->User_Level->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->User_Level->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`User_Level_ID`" . ew_SearchString("=", $this->User_Level->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `User_Level_ID`, `User_Level_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `User_Level_ID`, `User_Level_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->User_Level, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->User_Level->EditValue = $arwrk;
			}

			// Report_To
			$this->Report_To->EditAttrs["class"] = "form-control";
			$this->Report_To->EditCustomAttributes = "";
			$this->Report_To->EditValue = ew_HtmlEncode($this->Report_To->CurrentValue);
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
			$this->Profile->EditValue = ew_HtmlEncode($this->Profile->CurrentValue);
			$this->Profile->PlaceHolder = ew_RemoveHtml($this->Profile->FldCaption());

			// Current_URL
			$this->Current_URL->EditAttrs["class"] = "form-control";
			$this->Current_URL->EditCustomAttributes = "";
			$this->Current_URL->EditValue = ew_HtmlEncode($this->Current_URL->CurrentValue);
			$this->Current_URL->PlaceHolder = ew_RemoveHtml($this->Current_URL->FldCaption());

			// Theme
			$this->Theme->EditAttrs["class"] = "form-control";
			$this->Theme->EditCustomAttributes = "";
			if (trim(strval($this->Theme->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Theme_ID`" . ew_SearchString("=", $this->Theme->CurrentValue, EW_DATATYPE_STRING, "");
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
			$this->Lookup_Selecting($this->Theme, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Theme->EditValue = $arwrk;

			// Menu_Horizontal
			$this->Menu_Horizontal->EditCustomAttributes = "";
			$this->Menu_Horizontal->EditValue = $this->Menu_Horizontal->Options(FALSE);

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

			// Rows_Vertical_Align_Top
			$this->Rows_Vertical_Align_Top->EditCustomAttributes = "";
			$this->Rows_Vertical_Align_Top->EditValue = $this->Rows_Vertical_Align_Top->Options(FALSE);

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

			// Edit refer script
			// Username

			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";

			// First_Name
			$this->First_Name->LinkCustomAttributes = "";
			$this->First_Name->HrefValue = "";

			// Last_Name
			$this->Last_Name->LinkCustomAttributes = "";
			$this->Last_Name->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";

			// User_Level
			$this->User_Level->LinkCustomAttributes = "";
			$this->User_Level->HrefValue = "";

			// Report_To
			$this->Report_To->LinkCustomAttributes = "";
			$this->Report_To->HrefValue = "";

			// Activated
			$this->Activated->LinkCustomAttributes = "";
			$this->Activated->HrefValue = "";

			// Locked
			$this->Locked->LinkCustomAttributes = "";
			$this->Locked->HrefValue = "";

			// Profile
			$this->Profile->LinkCustomAttributes = "";
			$this->Profile->HrefValue = "";

			// Current_URL
			$this->Current_URL->LinkCustomAttributes = "";
			$this->Current_URL->HrefValue = "";

			// Theme
			$this->Theme->LinkCustomAttributes = "";
			$this->Theme->HrefValue = "";

			// Menu_Horizontal
			$this->Menu_Horizontal->LinkCustomAttributes = "";
			$this->Menu_Horizontal->HrefValue = "";

			// Table_Width_Style
			$this->Table_Width_Style->LinkCustomAttributes = "";
			$this->Table_Width_Style->HrefValue = "";

			// Scroll_Table_Width
			$this->Scroll_Table_Width->LinkCustomAttributes = "";
			$this->Scroll_Table_Width->HrefValue = "";

			// Scroll_Table_Height
			$this->Scroll_Table_Height->LinkCustomAttributes = "";
			$this->Scroll_Table_Height->HrefValue = "";

			// Rows_Vertical_Align_Top
			$this->Rows_Vertical_Align_Top->LinkCustomAttributes = "";
			$this->Rows_Vertical_Align_Top->HrefValue = "";

			// Language
			$this->_Language->LinkCustomAttributes = "";
			$this->_Language->HrefValue = "";

			// Redirect_To_Last_Visited_Page_After_Login
			$this->Redirect_To_Last_Visited_Page_After_Login->LinkCustomAttributes = "";
			$this->Redirect_To_Last_Visited_Page_After_Login->HrefValue = "";

			// Font_Name
			$this->Font_Name->LinkCustomAttributes = "";
			$this->Font_Name->HrefValue = "";

			// Font_Size
			$this->Font_Size->LinkCustomAttributes = "";
			$this->Font_Size->HrefValue = "";
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
		if (!$this->Username->FldIsDetailKey && !is_null($this->Username->FormValue) && $this->Username->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Username->FldCaption(), $this->Username->ReqErrMsg));
		}
		if (!$this->Password->FldIsDetailKey && !is_null($this->Password->FormValue) && $this->Password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Password->FldCaption(), $this->Password->ReqErrMsg));
		}
		if (!$this->_Email->FldIsDetailKey && !is_null($this->_Email->FormValue) && $this->_Email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_Email->FldCaption(), $this->_Email->ReqErrMsg));
		}
		if (!ew_CheckEmail($this->_Email->FormValue)) {
			ew_AddMessage($gsFormError, $this->_Email->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Report_To->FormValue)) {
			ew_AddMessage($gsFormError, $this->Report_To->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Scroll_Table_Width->FormValue)) {
			ew_AddMessage($gsFormError, $this->Scroll_Table_Width->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Scroll_Table_Height->FormValue)) {
			ew_AddMessage($gsFormError, $this->Scroll_Table_Height->FldErrMsg());
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

			// Username
			// Password

			$this->Password->SetDbValueDef($rsnew, $this->Password->CurrentValue, "", $this->Password->ReadOnly || (EW_ENCRYPTED_PASSWORD && $rs->fields('Password') == $this->Password->CurrentValue));

			// First_Name
			$this->First_Name->SetDbValueDef($rsnew, $this->First_Name->CurrentValue, NULL, $this->First_Name->ReadOnly);

			// Last_Name
			$this->Last_Name->SetDbValueDef($rsnew, $this->Last_Name->CurrentValue, NULL, $this->Last_Name->ReadOnly);

			// Email
			$this->_Email->SetDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, $this->_Email->ReadOnly);

			// User_Level
			if ($Security->CanAdmin()) { // System admin
			$this->User_Level->SetDbValueDef($rsnew, $this->User_Level->CurrentValue, NULL, $this->User_Level->ReadOnly);
			}

			// Report_To
			$this->Report_To->SetDbValueDef($rsnew, $this->Report_To->CurrentValue, NULL, $this->Report_To->ReadOnly);

			// Activated
			$this->Activated->SetDbValueDef($rsnew, ((strval($this->Activated->CurrentValue) == "Y") ? "Y" : "N"), "N", $this->Activated->ReadOnly);

			// Locked
			$tmpBool = $this->Locked->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Locked->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Locked->ReadOnly);

			// Profile
			$this->Profile->SetDbValueDef($rsnew, $this->Profile->CurrentValue, NULL, $this->Profile->ReadOnly);

			// Current_URL
			$this->Current_URL->SetDbValueDef($rsnew, $this->Current_URL->CurrentValue, NULL, $this->Current_URL->ReadOnly);

			// Theme
			$this->Theme->SetDbValueDef($rsnew, $this->Theme->CurrentValue, NULL, $this->Theme->ReadOnly);

			// Menu_Horizontal
			$tmpBool = $this->Menu_Horizontal->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Menu_Horizontal->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Menu_Horizontal->ReadOnly);

			// Table_Width_Style
			$this->Table_Width_Style->SetDbValueDef($rsnew, $this->Table_Width_Style->CurrentValue, NULL, $this->Table_Width_Style->ReadOnly);

			// Scroll_Table_Width
			$this->Scroll_Table_Width->SetDbValueDef($rsnew, $this->Scroll_Table_Width->CurrentValue, NULL, $this->Scroll_Table_Width->ReadOnly);

			// Scroll_Table_Height
			$this->Scroll_Table_Height->SetDbValueDef($rsnew, $this->Scroll_Table_Height->CurrentValue, NULL, $this->Scroll_Table_Height->ReadOnly);

			// Rows_Vertical_Align_Top
			$tmpBool = $this->Rows_Vertical_Align_Top->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Rows_Vertical_Align_Top->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Rows_Vertical_Align_Top->ReadOnly);

			// Language
			$this->_Language->SetDbValueDef($rsnew, $this->_Language->CurrentValue, NULL, $this->_Language->ReadOnly);

			// Redirect_To_Last_Visited_Page_After_Login
			$tmpBool = $this->Redirect_To_Last_Visited_Page_After_Login->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->Redirect_To_Last_Visited_Page_After_Login->SetDbValueDef($rsnew, $tmpBool, NULL, $this->Redirect_To_Last_Visited_Page_After_Login->ReadOnly);

			// Font_Name
			$this->Font_Name->SetDbValueDef($rsnew, $this->Font_Name->CurrentValue, NULL, $this->Font_Name->ReadOnly);

			// Font_Size
			$this->Font_Size->SetDbValueDef($rsnew, $this->Font_Size->CurrentValue, NULL, $this->Font_Size->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("userslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($users_edit)) $users_edit = new cusers_edit();

// Page init
$users_edit->Page_Init();

// Page main
$users_edit->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$users_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fusersedit = new ew_Form("fusersedit", "edit");

// Validate form
fusersedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Username");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->Username->FldCaption(), $users->Username->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->Password->FldCaption(), $users->Password->ReqErrMsg)) ?>");
			if ($(fobj.x_Password).hasClass("ewPasswordStrength") && !$(fobj.x_Password).data("validated"))
				return this.OnError(fobj.x_Password, ewLanguage.Phrase("PasswordTooSimple"));
			elm = this.GetElements("x" + infix + "__Email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->_Email->FldCaption(), $users->_Email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__Email");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->_Email->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Report_To");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->Report_To->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Scroll_Table_Width");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->Scroll_Table_Width->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Scroll_Table_Height");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->Scroll_Table_Height->FldErrMsg()) ?>");

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
fusersedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fusersedit.ValidateRequired = true;
<?php } else { ?>
fusersedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fusersedit.Lists["x_User_Level"] = {"LinkField":"x_User_Level_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_User_Level_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Activated"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Activated"].Options = <?php echo json_encode($users->Activated->Options()) ?>;
fusersedit.Lists["x_Locked[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Locked[]"].Options = <?php echo json_encode($users->Locked->Options()) ?>;
fusersedit.Lists["x_Theme"] = {"LinkField":"x_Theme_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Theme_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Menu_Horizontal[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Menu_Horizontal[]"].Options = <?php echo json_encode($users->Menu_Horizontal->Options()) ?>;
fusersedit.Lists["x_Table_Width_Style"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Table_Width_Style"].Options = <?php echo json_encode($users->Table_Width_Style->Options()) ?>;
fusersedit.Lists["x_Rows_Vertical_Align_Top[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Rows_Vertical_Align_Top[]"].Options = <?php echo json_encode($users->Rows_Vertical_Align_Top->Options()) ?>;
fusersedit.Lists["x__Language"] = {"LinkField":"x_Language_Code","Ajax":true,"AutoFill":false,"DisplayFields":["x_Language_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Redirect_To_Last_Visited_Page_After_Login[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Redirect_To_Last_Visited_Page_After_Login[]"].Options = <?php echo json_encode($users->Redirect_To_Last_Visited_Page_After_Login->Options()) ?>;
fusersedit.Lists["x_Font_Name"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Font_Name"].Options = <?php echo json_encode($users->Font_Name->Options()) ?>;
fusersedit.Lists["x_Font_Size"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_Font_Size"].Options = <?php echo json_encode($users->Font_Size->Options()) ?>;

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
<?php $users_edit->ShowPageHeader(); ?>
<?php
$users_edit->ShowMessage();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($users_edit->Pager)) $users_edit->Pager = new cNumericPager($users_edit->StartRec, $users_edit->DisplayRecs, $users_edit->TotalRecs, $users_edit->RecRange) ?>
		<?php if ($users_edit->Pager->RecordCount > 0) { ?>
				<?php if (($users_edit->Pager->PageCount==1) && ($users_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($users_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($users_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($users_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $users_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($users_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($users_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($users_edit->Pager)) $users_edit->Pager = new cPrevNextPager($users_edit->StartRec, $users_edit->DisplayRecs, $users_edit->TotalRecs) ?>
		<?php if ($users_edit->Pager->RecordCount > 0) { ?>
				<?php if (($users_edit->Pager->PageCount==1) && ($users_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($users_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($users_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($users_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($users_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
</form>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="fusersedit" id="fusersedit" class="<?php echo $users_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div>
<?php if ($users->Username->Visible) { // Username ?>
	<div id="r_Username" class="form-group">
		<label id="elh_users_Username" for="x_Username" class="col-sm-4 control-label ewLabel"><?php echo $users->Username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $users->Username->CellAttributes() ?>>
<span id="el_users_Username">
<span<?php echo $users->Username->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $users->Username->EditValue ?></p></span>
</span>
<input type="hidden" data-table="users" data-field="x_Username" name="x_Username" id="x_Username" value="<?php echo ew_HtmlEncode($users->Username->CurrentValue) ?>">
<?php echo $users->Username->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Password->Visible) { // Password ?>
	<div id="r_Password" class="form-group">
		<label id="elh_users_Password" for="x_Password" class="col-sm-4 control-label ewLabel"><?php echo $users->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $users->Password->CellAttributes() ?>>
<span id="el_users_Password">
<div class="input-group" id="ig_x_Password">
<input type="password" data-password-strength="pst_x_Password" data-password-generated="pgt_x_Password" data-table="users" data-field="x_Password" name="x_Password" id="x_Password" value="<?php echo $users->Password->EditValue ?>" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($users->Password->getPlaceHolder()) ?>"<?php echo $users->Password->EditAttributes() ?>>
<span class="input-group-btn">
	<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="x_Password" data-password-confirm="c_Password" data-password-strength="pst_x_Password" data-password-generated="pgt_x_Password"><?php echo $Language->Phrase("GeneratePassword") ?></button>
</span>
</div>
<span class="help-block" id="pgt_x_Password" style="display: none;"></span>
<div class="progress ewPasswordStrengthBar" id="pst_x_Password" style="display: none;">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php echo $users->Password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->First_Name->Visible) { // First_Name ?>
	<div id="r_First_Name" class="form-group">
		<label id="elh_users_First_Name" for="x_First_Name" class="col-sm-4 control-label ewLabel"><?php echo $users->First_Name->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->First_Name->CellAttributes() ?>>
<span id="el_users_First_Name">
<input type="text" data-table="users" data-field="x_First_Name" name="x_First_Name" id="x_First_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->First_Name->getPlaceHolder()) ?>" value="<?php echo $users->First_Name->EditValue ?>"<?php echo $users->First_Name->EditAttributes() ?>>
</span>
<?php echo $users->First_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Last_Name->Visible) { // Last_Name ?>
	<div id="r_Last_Name" class="form-group">
		<label id="elh_users_Last_Name" for="x_Last_Name" class="col-sm-4 control-label ewLabel"><?php echo $users->Last_Name->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Last_Name->CellAttributes() ?>>
<span id="el_users_Last_Name">
<input type="text" data-table="users" data-field="x_Last_Name" name="x_Last_Name" id="x_Last_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->Last_Name->getPlaceHolder()) ?>" value="<?php echo $users->Last_Name->EditValue ?>"<?php echo $users->Last_Name->EditAttributes() ?>>
</span>
<?php echo $users->Last_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group">
		<label id="elh_users__Email" for="x__Email" class="col-sm-4 control-label ewLabel"><?php echo $users->_Email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $users->_Email->CellAttributes() ?>>
<span id="el_users__Email">
<input type="text" data-table="users" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($users->_Email->getPlaceHolder()) ?>" value="<?php echo $users->_Email->EditValue ?>"<?php echo $users->_Email->EditAttributes() ?>>
</span>
<?php echo $users->_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->User_Level->Visible) { // User_Level ?>
	<div id="r_User_Level" class="form-group">
		<label id="elh_users_User_Level" for="x_User_Level" class="col-sm-4 control-label ewLabel"><?php echo $users->User_Level->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->User_Level->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_users_User_Level">
<p class="form-control-static"><?php echo $users->User_Level->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_users_User_Level">
<select data-table="users" data-field="x_User_Level" data-value-separator="<?php echo ew_HtmlEncode(is_array($users->User_Level->DisplayValueSeparator) ? json_encode($users->User_Level->DisplayValueSeparator) : $users->User_Level->DisplayValueSeparator) ?>" id="x_User_Level" name="x_User_Level"<?php echo $users->User_Level->EditAttributes() ?>>
<?php
if (is_array($users->User_Level->EditValue)) {
	$arwrk = $users->User_Level->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($users->User_Level->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $users->User_Level->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($users->User_Level->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($users->User_Level->CurrentValue) ?>" selected><?php echo $users->User_Level->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
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
$users->User_Level->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$users->User_Level->LookupFilters += array("f0" => "`User_Level_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$users->Lookup_Selecting($users->User_Level, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $users->User_Level->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_User_Level" id="s_x_User_Level" value="<?php echo $users->User_Level->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $users->User_Level->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Report_To->Visible) { // Report_To ?>
	<div id="r_Report_To" class="form-group">
		<label id="elh_users_Report_To" for="x_Report_To" class="col-sm-4 control-label ewLabel"><?php echo $users->Report_To->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Report_To->CellAttributes() ?>>
<span id="el_users_Report_To">
<input type="text" data-table="users" data-field="x_Report_To" name="x_Report_To" id="x_Report_To" size="30" placeholder="<?php echo ew_HtmlEncode($users->Report_To->getPlaceHolder()) ?>" value="<?php echo $users->Report_To->EditValue ?>"<?php echo $users->Report_To->EditAttributes() ?>>
</span>
<?php echo $users->Report_To->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Activated->Visible) { // Activated ?>
	<div id="r_Activated" class="form-group">
		<label id="elh_users_Activated" for="x_Activated" class="col-sm-4 control-label ewLabel"><?php echo $users->Activated->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Activated->CellAttributes() ?>>
<span id="el_users_Activated">
<select data-table="users" data-field="x_Activated" data-value-separator="<?php echo ew_HtmlEncode(is_array($users->Activated->DisplayValueSeparator) ? json_encode($users->Activated->DisplayValueSeparator) : $users->Activated->DisplayValueSeparator) ?>" id="x_Activated" name="x_Activated"<?php echo $users->Activated->EditAttributes() ?>>
<?php
if (is_array($users->Activated->EditValue)) {
	$arwrk = $users->Activated->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($users->Activated->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $users->Activated->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($users->Activated->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($users->Activated->CurrentValue) ?>" selected><?php echo $users->Activated->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $users->Activated->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Locked->Visible) { // Locked ?>
	<div id="r_Locked" class="form-group">
		<label id="elh_users_Locked" class="col-sm-4 control-label ewLabel"><?php echo $users->Locked->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Locked->CellAttributes() ?>>
<span id="el_users_Locked">
<?php
$selwrk = (ew_ConvertToBool($users->Locked->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="users" data-field="x_Locked" name="x_Locked[]" id="x_Locked[]" value="1"<?php echo $selwrk ?><?php echo $users->Locked->EditAttributes() ?>>
</span>
<?php echo $users->Locked->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Profile->Visible) { // Profile ?>
	<div id="r_Profile" class="form-group">
		<label id="elh_users_Profile" for="x_Profile" class="col-sm-4 control-label ewLabel"><?php echo $users->Profile->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Profile->CellAttributes() ?>>
<span id="el_users_Profile">
<textarea data-table="users" data-field="x_Profile" name="x_Profile" id="x_Profile" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->Profile->getPlaceHolder()) ?>"<?php echo $users->Profile->EditAttributes() ?>><?php echo $users->Profile->EditValue ?></textarea>
</span>
<?php echo $users->Profile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Current_URL->Visible) { // Current_URL ?>
	<div id="r_Current_URL" class="form-group">
		<label id="elh_users_Current_URL" for="x_Current_URL" class="col-sm-4 control-label ewLabel"><?php echo $users->Current_URL->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Current_URL->CellAttributes() ?>>
<span id="el_users_Current_URL">
<textarea data-table="users" data-field="x_Current_URL" name="x_Current_URL" id="x_Current_URL" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->Current_URL->getPlaceHolder()) ?>"<?php echo $users->Current_URL->EditAttributes() ?>><?php echo $users->Current_URL->EditValue ?></textarea>
</span>
<?php echo $users->Current_URL->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Theme->Visible) { // Theme ?>
	<div id="r_Theme" class="form-group">
		<label id="elh_users_Theme" for="x_Theme" class="col-sm-4 control-label ewLabel"><?php echo $users->Theme->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Theme->CellAttributes() ?>>
<span id="el_users_Theme">
<select data-table="users" data-field="x_Theme" data-value-separator="<?php echo ew_HtmlEncode(is_array($users->Theme->DisplayValueSeparator) ? json_encode($users->Theme->DisplayValueSeparator) : $users->Theme->DisplayValueSeparator) ?>" id="x_Theme" name="x_Theme"<?php echo $users->Theme->EditAttributes() ?>>
<?php
if (is_array($users->Theme->EditValue)) {
	$arwrk = $users->Theme->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($users->Theme->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $users->Theme->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($users->Theme->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($users->Theme->CurrentValue) ?>" selected><?php echo $users->Theme->CurrentValue ?></option>
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
$users->Theme->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$users->Theme->LookupFilters += array("f0" => "`Theme_ID` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$users->Lookup_Selecting($users->Theme, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $users->Theme->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Theme" id="s_x_Theme" value="<?php echo $users->Theme->LookupFilterQuery() ?>">
</span>
<?php echo $users->Theme->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Menu_Horizontal->Visible) { // Menu_Horizontal ?>
	<div id="r_Menu_Horizontal" class="form-group">
		<label id="elh_users_Menu_Horizontal" class="col-sm-4 control-label ewLabel"><?php echo $users->Menu_Horizontal->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Menu_Horizontal->CellAttributes() ?>>
<span id="el_users_Menu_Horizontal">
<?php
$selwrk = (ew_ConvertToBool($users->Menu_Horizontal->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="users" data-field="x_Menu_Horizontal" name="x_Menu_Horizontal[]" id="x_Menu_Horizontal[]" value="1"<?php echo $selwrk ?><?php echo $users->Menu_Horizontal->EditAttributes() ?>>
</span>
<?php echo $users->Menu_Horizontal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Table_Width_Style->Visible) { // Table_Width_Style ?>
	<div id="r_Table_Width_Style" class="form-group">
		<label id="elh_users_Table_Width_Style" class="col-sm-4 control-label ewLabel"><?php echo $users->Table_Width_Style->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Table_Width_Style->CellAttributes() ?>>
<span id="el_users_Table_Width_Style">
<div id="tp_x_Table_Width_Style" class="ewTemplate"><input type="radio" data-table="users" data-field="x_Table_Width_Style" data-value-separator="<?php echo ew_HtmlEncode(is_array($users->Table_Width_Style->DisplayValueSeparator) ? json_encode($users->Table_Width_Style->DisplayValueSeparator) : $users->Table_Width_Style->DisplayValueSeparator) ?>" name="x_Table_Width_Style" id="x_Table_Width_Style" value="{value}"<?php echo $users->Table_Width_Style->EditAttributes() ?>></div>
<div id="dsl_x_Table_Width_Style" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $users->Table_Width_Style->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($users->Table_Width_Style->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="users" data-field="x_Table_Width_Style" name="x_Table_Width_Style" id="x_Table_Width_Style_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $users->Table_Width_Style->EditAttributes() ?>><?php echo $users->Table_Width_Style->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($users->Table_Width_Style->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="users" data-field="x_Table_Width_Style" name="x_Table_Width_Style" id="x_Table_Width_Style_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($users->Table_Width_Style->CurrentValue) ?>" checked<?php echo $users->Table_Width_Style->EditAttributes() ?>><?php echo $users->Table_Width_Style->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $users->Table_Width_Style->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Scroll_Table_Width->Visible) { // Scroll_Table_Width ?>
	<div id="r_Scroll_Table_Width" class="form-group">
		<label id="elh_users_Scroll_Table_Width" for="x_Scroll_Table_Width" class="col-sm-4 control-label ewLabel"><?php echo $users->Scroll_Table_Width->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Scroll_Table_Width->CellAttributes() ?>>
<span id="el_users_Scroll_Table_Width">
<input type="text" data-table="users" data-field="x_Scroll_Table_Width" name="x_Scroll_Table_Width" id="x_Scroll_Table_Width" size="30" placeholder="<?php echo ew_HtmlEncode($users->Scroll_Table_Width->getPlaceHolder()) ?>" value="<?php echo $users->Scroll_Table_Width->EditValue ?>"<?php echo $users->Scroll_Table_Width->EditAttributes() ?>>
</span>
<?php echo $users->Scroll_Table_Width->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Scroll_Table_Height->Visible) { // Scroll_Table_Height ?>
	<div id="r_Scroll_Table_Height" class="form-group">
		<label id="elh_users_Scroll_Table_Height" for="x_Scroll_Table_Height" class="col-sm-4 control-label ewLabel"><?php echo $users->Scroll_Table_Height->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Scroll_Table_Height->CellAttributes() ?>>
<span id="el_users_Scroll_Table_Height">
<input type="text" data-table="users" data-field="x_Scroll_Table_Height" name="x_Scroll_Table_Height" id="x_Scroll_Table_Height" size="30" placeholder="<?php echo ew_HtmlEncode($users->Scroll_Table_Height->getPlaceHolder()) ?>" value="<?php echo $users->Scroll_Table_Height->EditValue ?>"<?php echo $users->Scroll_Table_Height->EditAttributes() ?>>
</span>
<?php echo $users->Scroll_Table_Height->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Rows_Vertical_Align_Top->Visible) { // Rows_Vertical_Align_Top ?>
	<div id="r_Rows_Vertical_Align_Top" class="form-group">
		<label id="elh_users_Rows_Vertical_Align_Top" class="col-sm-4 control-label ewLabel"><?php echo $users->Rows_Vertical_Align_Top->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Rows_Vertical_Align_Top->CellAttributes() ?>>
<span id="el_users_Rows_Vertical_Align_Top">
<?php
$selwrk = (ew_ConvertToBool($users->Rows_Vertical_Align_Top->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="users" data-field="x_Rows_Vertical_Align_Top" name="x_Rows_Vertical_Align_Top[]" id="x_Rows_Vertical_Align_Top[]" value="1"<?php echo $selwrk ?><?php echo $users->Rows_Vertical_Align_Top->EditAttributes() ?>>
</span>
<?php echo $users->Rows_Vertical_Align_Top->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->_Language->Visible) { // Language ?>
	<div id="r__Language" class="form-group">
		<label id="elh_users__Language" for="x__Language" class="col-sm-4 control-label ewLabel"><?php echo $users->_Language->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->_Language->CellAttributes() ?>>
<span id="el_users__Language">
<select data-table="users" data-field="x__Language" data-value-separator="<?php echo ew_HtmlEncode(is_array($users->_Language->DisplayValueSeparator) ? json_encode($users->_Language->DisplayValueSeparator) : $users->_Language->DisplayValueSeparator) ?>" id="x__Language" name="x__Language"<?php echo $users->_Language->EditAttributes() ?>>
<?php
if (is_array($users->_Language->EditValue)) {
	$arwrk = $users->_Language->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($users->_Language->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $users->_Language->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($users->_Language->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($users->_Language->CurrentValue) ?>" selected><?php echo $users->_Language->CurrentValue ?></option>
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
$users->_Language->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$users->_Language->LookupFilters += array("f0" => "`Language_Code` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$users->Lookup_Selecting($users->_Language, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $users->_Language->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x__Language" id="s_x__Language" value="<?php echo $users->_Language->LookupFilterQuery() ?>">
</span>
<?php echo $users->_Language->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Redirect_To_Last_Visited_Page_After_Login->Visible) { // Redirect_To_Last_Visited_Page_After_Login ?>
	<div id="r_Redirect_To_Last_Visited_Page_After_Login" class="form-group">
		<label id="elh_users_Redirect_To_Last_Visited_Page_After_Login" class="col-sm-4 control-label ewLabel"><?php echo $users->Redirect_To_Last_Visited_Page_After_Login->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Redirect_To_Last_Visited_Page_After_Login->CellAttributes() ?>>
<span id="el_users_Redirect_To_Last_Visited_Page_After_Login">
<?php
$selwrk = (ew_ConvertToBool($users->Redirect_To_Last_Visited_Page_After_Login->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="users" data-field="x_Redirect_To_Last_Visited_Page_After_Login" name="x_Redirect_To_Last_Visited_Page_After_Login[]" id="x_Redirect_To_Last_Visited_Page_After_Login[]" value="1"<?php echo $selwrk ?><?php echo $users->Redirect_To_Last_Visited_Page_After_Login->EditAttributes() ?>>
</span>
<?php echo $users->Redirect_To_Last_Visited_Page_After_Login->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Font_Name->Visible) { // Font_Name ?>
	<div id="r_Font_Name" class="form-group">
		<label id="elh_users_Font_Name" for="x_Font_Name" class="col-sm-4 control-label ewLabel"><?php echo $users->Font_Name->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Font_Name->CellAttributes() ?>>
<span id="el_users_Font_Name">
<select data-table="users" data-field="x_Font_Name" data-value-separator="<?php echo ew_HtmlEncode(is_array($users->Font_Name->DisplayValueSeparator) ? json_encode($users->Font_Name->DisplayValueSeparator) : $users->Font_Name->DisplayValueSeparator) ?>" id="x_Font_Name" name="x_Font_Name"<?php echo $users->Font_Name->EditAttributes() ?>>
<?php
if (is_array($users->Font_Name->EditValue)) {
	$arwrk = $users->Font_Name->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($users->Font_Name->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $users->Font_Name->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($users->Font_Name->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($users->Font_Name->CurrentValue) ?>" selected><?php echo $users->Font_Name->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $users->Font_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->Font_Size->Visible) { // Font_Size ?>
	<div id="r_Font_Size" class="form-group">
		<label id="elh_users_Font_Size" for="x_Font_Size" class="col-sm-4 control-label ewLabel"><?php echo $users->Font_Size->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $users->Font_Size->CellAttributes() ?>>
<span id="el_users_Font_Size">
<select data-table="users" data-field="x_Font_Size" data-value-separator="<?php echo ew_HtmlEncode(is_array($users->Font_Size->DisplayValueSeparator) ? json_encode($users->Font_Size->DisplayValueSeparator) : $users->Font_Size->DisplayValueSeparator) ?>" id="x_Font_Size" name="x_Font_Size"<?php echo $users->Font_Size->EditAttributes() ?>>
<?php
if (is_array($users->Font_Size->EditValue)) {
	$arwrk = $users->Font_Size->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($users->Font_Size->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $users->Font_Size->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($users->Font_Size->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($users->Font_Size->CurrentValue) ?>" selected><?php echo $users->Font_Size->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $users->Font_Size->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $users_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($users_edit->Pager)) $users_edit->Pager = new cNumericPager($users_edit->StartRec, $users_edit->DisplayRecs, $users_edit->TotalRecs, $users_edit->RecRange) ?>
		<?php if ($users_edit->Pager->RecordCount > 0) { ?>
				<?php if (($users_edit->Pager->PageCount==1) && ($users_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($users_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($users_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($users_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $users_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($users_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($users_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($users_edit->Pager)) $users_edit->Pager = new cPrevNextPager($users_edit->StartRec, $users_edit->DisplayRecs, $users_edit->TotalRecs) ?>
		<?php if ($users_edit->Pager->RecordCount > 0) { ?>
				<?php if (($users_edit->Pager->PageCount==1) && ($users_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($users_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($users_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($users_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($users_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
</form>
<script type="text/javascript">
fusersedit.Init();
</script>
<?php
$users_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fusersedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($users->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyEdit(this)'); function alertifyEdit(obj) { <?php global $Language; ?> if (fusersedit.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyEditConfirm'); ?>", function (e) {	if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyEdit'); ?>"); $("#fusersedit").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$users_edit->Page_Terminate();
?>
