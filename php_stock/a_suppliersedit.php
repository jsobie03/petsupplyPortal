<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "a_suppliersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "a_purchasesgridcls.php" ?>
<?php include_once "a_stock_itemsgridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$a_suppliers_edit = NULL; // Initialize page object first

class ca_suppliers_edit extends ca_suppliers {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_suppliers';

	// Page object name
	var $PageObjName = 'a_suppliers_edit';

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

		// Table object (a_suppliers)
		if (!isset($GLOBALS["a_suppliers"]) || get_class($GLOBALS["a_suppliers"]) == "ca_suppliers") {
			$GLOBALS["a_suppliers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["a_suppliers"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'a_suppliers', TRUE);

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
		if (!isset($_SESSION['table_a_suppliers_views'])) { 
			$_SESSION['table_a_suppliers_views'] = 0;
		}
		$_SESSION['table_a_suppliers_views'] = $_SESSION['table_a_suppliers_views']+1;

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
				$this->Page_Terminate(ew_GetUrl("a_supplierslist.php"));
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
		$this->Supplier_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

			// Process auto fill for detail table 'a_purchases'
			if (@$_POST["grid"] == "fa_purchasesgrid") {
				if (!isset($GLOBALS["a_purchases_grid"])) $GLOBALS["a_purchases_grid"] = new ca_purchases_grid;
				$GLOBALS["a_purchases_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'a_stock_items'
			if (@$_POST["grid"] == "fa_stock_itemsgrid") {
				if (!isset($GLOBALS["a_stock_items_grid"])) $GLOBALS["a_stock_items_grid"] = new ca_stock_items_grid;
				$GLOBALS["a_stock_items_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $a_suppliers;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($a_suppliers);
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
		if (@$_GET["Supplier_ID"] <> "") {
			$this->Supplier_ID->setQueryStringValue($_GET["Supplier_ID"]);
			$this->RecKey["Supplier_ID"] = $this->Supplier_ID->QueryStringValue;
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
			$this->Page_Terminate("a_supplierslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->Supplier_ID->CurrentValue) == strval($this->Recordset->fields('Supplier_ID'))) {
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

			// Set up detail parameters
			$this->SetUpDetailParms();
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
					$this->Page_Terminate("a_supplierslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "a_supplierslist.php")
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

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->Supplier_ID->FldIsDetailKey)
			$this->Supplier_ID->setFormValue($objForm->GetValue("x_Supplier_ID"));
		if (!$this->Supplier_Number->FldIsDetailKey) {
			$this->Supplier_Number->setFormValue($objForm->GetValue("x_Supplier_Number"));
		}
		if (!$this->Supplier_Name->FldIsDetailKey) {
			$this->Supplier_Name->setFormValue($objForm->GetValue("x_Supplier_Name"));
		}
		if (!$this->Address->FldIsDetailKey) {
			$this->Address->setFormValue($objForm->GetValue("x_Address"));
		}
		if (!$this->City->FldIsDetailKey) {
			$this->City->setFormValue($objForm->GetValue("x_City"));
		}
		if (!$this->Country->FldIsDetailKey) {
			$this->Country->setFormValue($objForm->GetValue("x_Country"));
		}
		if (!$this->Contact_Person->FldIsDetailKey) {
			$this->Contact_Person->setFormValue($objForm->GetValue("x_Contact_Person"));
		}
		if (!$this->Phone_Number->FldIsDetailKey) {
			$this->Phone_Number->setFormValue($objForm->GetValue("x_Phone_Number"));
		}
		if (!$this->_Email->FldIsDetailKey) {
			$this->_Email->setFormValue($objForm->GetValue("x__Email"));
		}
		if (!$this->Mobile_Number->FldIsDetailKey) {
			$this->Mobile_Number->setFormValue($objForm->GetValue("x_Mobile_Number"));
		}
		if (!$this->Notes->FldIsDetailKey) {
			$this->Notes->setFormValue($objForm->GetValue("x_Notes"));
		}
		if (!$this->Balance->FldIsDetailKey) {
			$this->Balance->setFormValue($objForm->GetValue("x_Balance"));
		}
		if (!$this->Is_Stock_Available->FldIsDetailKey) {
			$this->Is_Stock_Available->setFormValue($objForm->GetValue("x_Is_Stock_Available"));
		}
		if (!$this->Date_Added->FldIsDetailKey) {
			$this->Date_Added->setFormValue($objForm->GetValue("x_Date_Added"));
			$this->Date_Added->CurrentValue = ew_UnFormatDateTime($this->Date_Added->CurrentValue, 0);
		}
		if (!$this->Added_By->FldIsDetailKey) {
			$this->Added_By->setFormValue($objForm->GetValue("x_Added_By"));
		}
		if (!$this->Date_Updated->FldIsDetailKey) {
			$this->Date_Updated->setFormValue($objForm->GetValue("x_Date_Updated"));
			$this->Date_Updated->CurrentValue = ew_UnFormatDateTime($this->Date_Updated->CurrentValue, 0);
		}
		if (!$this->Updated_By->FldIsDetailKey) {
			$this->Updated_By->setFormValue($objForm->GetValue("x_Updated_By"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Supplier_ID->CurrentValue = $this->Supplier_ID->FormValue;
		$this->Supplier_Number->CurrentValue = $this->Supplier_Number->FormValue;
		$this->Supplier_Name->CurrentValue = $this->Supplier_Name->FormValue;
		$this->Address->CurrentValue = $this->Address->FormValue;
		$this->City->CurrentValue = $this->City->FormValue;
		$this->Country->CurrentValue = $this->Country->FormValue;
		$this->Contact_Person->CurrentValue = $this->Contact_Person->FormValue;
		$this->Phone_Number->CurrentValue = $this->Phone_Number->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
		$this->Mobile_Number->CurrentValue = $this->Mobile_Number->FormValue;
		$this->Notes->CurrentValue = $this->Notes->FormValue;
		$this->Balance->CurrentValue = $this->Balance->FormValue;
		$this->Is_Stock_Available->CurrentValue = $this->Is_Stock_Available->FormValue;
		$this->Date_Added->CurrentValue = $this->Date_Added->FormValue;
		$this->Date_Added->CurrentValue = ew_UnFormatDateTime($this->Date_Added->CurrentValue, 0);
		$this->Added_By->CurrentValue = $this->Added_By->FormValue;
		$this->Date_Updated->CurrentValue = $this->Date_Updated->FormValue;
		$this->Date_Updated->CurrentValue = ew_UnFormatDateTime($this->Date_Updated->CurrentValue, 0);
		$this->Updated_By->CurrentValue = $this->Updated_By->FormValue;
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
		$this->Supplier_ID->setDbValue($rs->fields('Supplier_ID'));
		$this->Supplier_Number->setDbValue($rs->fields('Supplier_Number'));
		$this->Supplier_Name->setDbValue($rs->fields('Supplier_Name'));
		$this->Address->setDbValue($rs->fields('Address'));
		$this->City->setDbValue($rs->fields('City'));
		$this->Country->setDbValue($rs->fields('Country'));
		$this->Contact_Person->setDbValue($rs->fields('Contact_Person'));
		$this->Phone_Number->setDbValue($rs->fields('Phone_Number'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Mobile_Number->setDbValue($rs->fields('Mobile_Number'));
		$this->Notes->setDbValue($rs->fields('Notes'));
		$this->Balance->setDbValue($rs->fields('Balance'));
		$this->Is_Stock_Available->setDbValue($rs->fields('Is_Stock_Available'));
		$this->Date_Added->setDbValue($rs->fields('Date_Added'));
		$this->Added_By->setDbValue($rs->fields('Added_By'));
		$this->Date_Updated->setDbValue($rs->fields('Date_Updated'));
		$this->Updated_By->setDbValue($rs->fields('Updated_By'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Supplier_ID->DbValue = $row['Supplier_ID'];
		$this->Supplier_Number->DbValue = $row['Supplier_Number'];
		$this->Supplier_Name->DbValue = $row['Supplier_Name'];
		$this->Address->DbValue = $row['Address'];
		$this->City->DbValue = $row['City'];
		$this->Country->DbValue = $row['Country'];
		$this->Contact_Person->DbValue = $row['Contact_Person'];
		$this->Phone_Number->DbValue = $row['Phone_Number'];
		$this->_Email->DbValue = $row['Email'];
		$this->Mobile_Number->DbValue = $row['Mobile_Number'];
		$this->Notes->DbValue = $row['Notes'];
		$this->Balance->DbValue = $row['Balance'];
		$this->Is_Stock_Available->DbValue = $row['Is_Stock_Available'];
		$this->Date_Added->DbValue = $row['Date_Added'];
		$this->Added_By->DbValue = $row['Added_By'];
		$this->Date_Updated->DbValue = $row['Date_Updated'];
		$this->Updated_By->DbValue = $row['Updated_By'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Balance->FormValue == $this->Balance->CurrentValue && is_numeric(ew_StrToFloat($this->Balance->CurrentValue)))
			$this->Balance->CurrentValue = ew_StrToFloat($this->Balance->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Supplier_ID
		// Supplier_Number
		// Supplier_Name
		// Address
		// City
		// Country
		// Contact_Person
		// Phone_Number
		// Email
		// Mobile_Number
		// Notes
		// Balance
		// Is_Stock_Available
		// Date_Added
		// Added_By
		// Date_Updated
		// Updated_By

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Supplier_ID
		$this->Supplier_ID->ViewValue = $this->Supplier_ID->CurrentValue;
		$this->Supplier_ID->ViewCustomAttributes = "";

		// Supplier_Number
		$this->Supplier_Number->ViewValue = $this->Supplier_Number->CurrentValue;
		$this->Supplier_Number->ViewCustomAttributes = "";

		// Supplier_Name
		$this->Supplier_Name->ViewValue = $this->Supplier_Name->CurrentValue;
		$this->Supplier_Name->ViewCustomAttributes = "";

		// Address
		$this->Address->ViewValue = $this->Address->CurrentValue;
		$this->Address->ViewCustomAttributes = "";

		// City
		$this->City->ViewValue = $this->City->CurrentValue;
		$this->City->ViewCustomAttributes = "";

		// Country
		$this->Country->ViewValue = $this->Country->CurrentValue;
		$this->Country->ViewCustomAttributes = "";

		// Contact_Person
		$this->Contact_Person->ViewValue = $this->Contact_Person->CurrentValue;
		$this->Contact_Person->ViewCustomAttributes = "";

		// Phone_Number
		$this->Phone_Number->ViewValue = $this->Phone_Number->CurrentValue;
		$this->Phone_Number->ViewCustomAttributes = "";

		// Email
		$this->_Email->ViewValue = $this->_Email->CurrentValue;
		$this->_Email->ViewCustomAttributes = "";

		// Mobile_Number
		$this->Mobile_Number->ViewValue = $this->Mobile_Number->CurrentValue;
		$this->Mobile_Number->ViewCustomAttributes = "";

		// Notes
		$this->Notes->ViewValue = $this->Notes->CurrentValue;
		$this->Notes->ViewCustomAttributes = "";

		// Balance
		$this->Balance->ViewValue = $this->Balance->CurrentValue;
		$this->Balance->ViewValue = ew_FormatCurrency($this->Balance->ViewValue, 2, -2, -2, -2);
		$this->Balance->CellCssStyle .= "text-align: right;";
		$this->Balance->ViewCustomAttributes = "";

		// Is_Stock_Available
		if (ew_ConvertToBool($this->Is_Stock_Available->CurrentValue)) {
			$this->Is_Stock_Available->ViewValue = $this->Is_Stock_Available->FldTagCaption(2) <> "" ? $this->Is_Stock_Available->FldTagCaption(2) : "Y";
		} else {
			$this->Is_Stock_Available->ViewValue = $this->Is_Stock_Available->FldTagCaption(1) <> "" ? $this->Is_Stock_Available->FldTagCaption(1) : "N";
		}
		$this->Is_Stock_Available->ViewCustomAttributes = "";

		// Date_Added
		$this->Date_Added->ViewValue = $this->Date_Added->CurrentValue;
		$this->Date_Added->ViewCustomAttributes = "";

		// Added_By
		$this->Added_By->ViewValue = $this->Added_By->CurrentValue;
		$this->Added_By->ViewCustomAttributes = "";

		// Date_Updated
		$this->Date_Updated->ViewValue = $this->Date_Updated->CurrentValue;
		$this->Date_Updated->ViewCustomAttributes = "";

		// Updated_By
		$this->Updated_By->ViewValue = $this->Updated_By->CurrentValue;
		$this->Updated_By->ViewCustomAttributes = "";

			// Supplier_ID
			$this->Supplier_ID->LinkCustomAttributes = "";
			$this->Supplier_ID->HrefValue = "";
			$this->Supplier_ID->TooltipValue = "";

			// Supplier_Number
			$this->Supplier_Number->LinkCustomAttributes = "";
			$this->Supplier_Number->HrefValue = "";
			$this->Supplier_Number->TooltipValue = "";

			// Supplier_Name
			$this->Supplier_Name->LinkCustomAttributes = "";
			$this->Supplier_Name->HrefValue = "";
			$this->Supplier_Name->TooltipValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";
			$this->Address->TooltipValue = "";

			// City
			$this->City->LinkCustomAttributes = "";
			$this->City->HrefValue = "";
			$this->City->TooltipValue = "";

			// Country
			$this->Country->LinkCustomAttributes = "";
			$this->Country->HrefValue = "";
			$this->Country->TooltipValue = "";

			// Contact_Person
			$this->Contact_Person->LinkCustomAttributes = "";
			$this->Contact_Person->HrefValue = "";
			$this->Contact_Person->TooltipValue = "";

			// Phone_Number
			$this->Phone_Number->LinkCustomAttributes = "";
			$this->Phone_Number->HrefValue = "";
			$this->Phone_Number->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";

			// Mobile_Number
			$this->Mobile_Number->LinkCustomAttributes = "";
			$this->Mobile_Number->HrefValue = "";
			$this->Mobile_Number->TooltipValue = "";

			// Notes
			$this->Notes->LinkCustomAttributes = "";
			$this->Notes->HrefValue = "";
			$this->Notes->TooltipValue = "";

			// Balance
			$this->Balance->LinkCustomAttributes = "";
			$this->Balance->HrefValue = "";
			$this->Balance->TooltipValue = "";

			// Is_Stock_Available
			$this->Is_Stock_Available->LinkCustomAttributes = "";
			$this->Is_Stock_Available->HrefValue = "";
			$this->Is_Stock_Available->TooltipValue = "";

			// Date_Added
			$this->Date_Added->LinkCustomAttributes = "";
			$this->Date_Added->HrefValue = "";
			$this->Date_Added->TooltipValue = "";

			// Added_By
			$this->Added_By->LinkCustomAttributes = "";
			$this->Added_By->HrefValue = "";
			$this->Added_By->TooltipValue = "";

			// Date_Updated
			$this->Date_Updated->LinkCustomAttributes = "";
			$this->Date_Updated->HrefValue = "";
			$this->Date_Updated->TooltipValue = "";

			// Updated_By
			$this->Updated_By->LinkCustomAttributes = "";
			$this->Updated_By->HrefValue = "";
			$this->Updated_By->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Supplier_ID
			$this->Supplier_ID->EditAttrs["class"] = "form-control";
			$this->Supplier_ID->EditCustomAttributes = "";
			$this->Supplier_ID->EditValue = $this->Supplier_ID->CurrentValue;
			$this->Supplier_ID->ViewCustomAttributes = "";

			// Supplier_Number
			$this->Supplier_Number->EditAttrs["class"] = "form-control";
			$this->Supplier_Number->EditCustomAttributes = "";
			$this->Supplier_Number->EditValue = ew_HtmlEncode($this->Supplier_Number->CurrentValue);
			$this->Supplier_Number->PlaceHolder = ew_RemoveHtml($this->Supplier_Number->FldCaption());

			// Supplier_Name
			$this->Supplier_Name->EditAttrs["class"] = "form-control";
			$this->Supplier_Name->EditCustomAttributes = "";
			$this->Supplier_Name->EditValue = ew_HtmlEncode($this->Supplier_Name->CurrentValue);
			$this->Supplier_Name->PlaceHolder = ew_RemoveHtml($this->Supplier_Name->FldCaption());

			// Address
			$this->Address->EditAttrs["class"] = "form-control";
			$this->Address->EditCustomAttributes = "";
			$this->Address->EditValue = ew_HtmlEncode($this->Address->CurrentValue);
			$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

			// City
			$this->City->EditAttrs["class"] = "form-control";
			$this->City->EditCustomAttributes = "";
			$this->City->EditValue = ew_HtmlEncode($this->City->CurrentValue);
			$this->City->PlaceHolder = ew_RemoveHtml($this->City->FldCaption());

			// Country
			$this->Country->EditAttrs["class"] = "form-control";
			$this->Country->EditCustomAttributes = "";
			$this->Country->EditValue = ew_HtmlEncode($this->Country->CurrentValue);
			$this->Country->PlaceHolder = ew_RemoveHtml($this->Country->FldCaption());

			// Contact_Person
			$this->Contact_Person->EditAttrs["class"] = "form-control";
			$this->Contact_Person->EditCustomAttributes = "";
			$this->Contact_Person->EditValue = ew_HtmlEncode($this->Contact_Person->CurrentValue);
			$this->Contact_Person->PlaceHolder = ew_RemoveHtml($this->Contact_Person->FldCaption());

			// Phone_Number
			$this->Phone_Number->EditAttrs["class"] = "form-control";
			$this->Phone_Number->EditCustomAttributes = "";
			$this->Phone_Number->EditValue = ew_HtmlEncode($this->Phone_Number->CurrentValue);
			$this->Phone_Number->PlaceHolder = ew_RemoveHtml($this->Phone_Number->FldCaption());

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue = ew_HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

			// Mobile_Number
			$this->Mobile_Number->EditAttrs["class"] = "form-control";
			$this->Mobile_Number->EditCustomAttributes = "";
			$this->Mobile_Number->EditValue = ew_HtmlEncode($this->Mobile_Number->CurrentValue);
			$this->Mobile_Number->PlaceHolder = ew_RemoveHtml($this->Mobile_Number->FldCaption());

			// Notes
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue = ew_HtmlEncode($this->Notes->CurrentValue);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

			// Balance
			$this->Balance->EditAttrs["class"] = "form-control";
			$this->Balance->EditCustomAttributes = "";
			$this->Balance->EditValue = ew_HtmlEncode($this->Balance->CurrentValue);
			$this->Balance->PlaceHolder = ew_RemoveHtml($this->Balance->FldCaption());
			if (strval($this->Balance->EditValue) <> "" && is_numeric($this->Balance->EditValue)) $this->Balance->EditValue = ew_FormatNumber($this->Balance->EditValue, -2, -2, -2, -2);

			// Is_Stock_Available
			$this->Is_Stock_Available->EditAttrs["class"] = "form-control";
			$this->Is_Stock_Available->EditCustomAttributes = "";
			$this->Is_Stock_Available->EditValue = $this->Is_Stock_Available->Options(TRUE);

			// Date_Added
			$this->Date_Added->EditAttrs["class"] = "form-control";
			$this->Date_Added->EditCustomAttributes = "";

			// Added_By
			$this->Added_By->EditAttrs["class"] = "form-control";
			$this->Added_By->EditCustomAttributes = "";

			// Date_Updated
			// Updated_By
			// Edit refer script
			// Supplier_ID

			$this->Supplier_ID->LinkCustomAttributes = "";
			$this->Supplier_ID->HrefValue = "";

			// Supplier_Number
			$this->Supplier_Number->LinkCustomAttributes = "";
			$this->Supplier_Number->HrefValue = "";

			// Supplier_Name
			$this->Supplier_Name->LinkCustomAttributes = "";
			$this->Supplier_Name->HrefValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";

			// City
			$this->City->LinkCustomAttributes = "";
			$this->City->HrefValue = "";

			// Country
			$this->Country->LinkCustomAttributes = "";
			$this->Country->HrefValue = "";

			// Contact_Person
			$this->Contact_Person->LinkCustomAttributes = "";
			$this->Contact_Person->HrefValue = "";

			// Phone_Number
			$this->Phone_Number->LinkCustomAttributes = "";
			$this->Phone_Number->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";

			// Mobile_Number
			$this->Mobile_Number->LinkCustomAttributes = "";
			$this->Mobile_Number->HrefValue = "";

			// Notes
			$this->Notes->LinkCustomAttributes = "";
			$this->Notes->HrefValue = "";

			// Balance
			$this->Balance->LinkCustomAttributes = "";
			$this->Balance->HrefValue = "";

			// Is_Stock_Available
			$this->Is_Stock_Available->LinkCustomAttributes = "";
			$this->Is_Stock_Available->HrefValue = "";

			// Date_Added
			$this->Date_Added->LinkCustomAttributes = "";
			$this->Date_Added->HrefValue = "";

			// Added_By
			$this->Added_By->LinkCustomAttributes = "";
			$this->Added_By->HrefValue = "";

			// Date_Updated
			$this->Date_Updated->LinkCustomAttributes = "";
			$this->Date_Updated->HrefValue = "";

			// Updated_By
			$this->Updated_By->LinkCustomAttributes = "";
			$this->Updated_By->HrefValue = "";
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
		if (!$this->Supplier_Number->FldIsDetailKey && !is_null($this->Supplier_Number->FormValue) && $this->Supplier_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Supplier_Number->FldCaption(), $this->Supplier_Number->ReqErrMsg));
		}
		if (!$this->Supplier_Name->FldIsDetailKey && !is_null($this->Supplier_Name->FormValue) && $this->Supplier_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Supplier_Name->FldCaption(), $this->Supplier_Name->ReqErrMsg));
		}
		if (!$this->Address->FldIsDetailKey && !is_null($this->Address->FormValue) && $this->Address->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Address->FldCaption(), $this->Address->ReqErrMsg));
		}
		if (!$this->City->FldIsDetailKey && !is_null($this->City->FormValue) && $this->City->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->City->FldCaption(), $this->City->ReqErrMsg));
		}
		if (!$this->Country->FldIsDetailKey && !is_null($this->Country->FormValue) && $this->Country->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Country->FldCaption(), $this->Country->ReqErrMsg));
		}
		if (!$this->Contact_Person->FldIsDetailKey && !is_null($this->Contact_Person->FormValue) && $this->Contact_Person->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Contact_Person->FldCaption(), $this->Contact_Person->ReqErrMsg));
		}
		if (!$this->Phone_Number->FldIsDetailKey && !is_null($this->Phone_Number->FormValue) && $this->Phone_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Phone_Number->FldCaption(), $this->Phone_Number->ReqErrMsg));
		}
		if (!$this->_Email->FldIsDetailKey && !is_null($this->_Email->FormValue) && $this->_Email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_Email->FldCaption(), $this->_Email->ReqErrMsg));
		}
		if (!$this->Mobile_Number->FldIsDetailKey && !is_null($this->Mobile_Number->FormValue) && $this->Mobile_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Mobile_Number->FldCaption(), $this->Mobile_Number->ReqErrMsg));
		}
		if (!$this->Notes->FldIsDetailKey && !is_null($this->Notes->FormValue) && $this->Notes->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Notes->FldCaption(), $this->Notes->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("a_purchases", $DetailTblVar) && $GLOBALS["a_purchases"]->DetailEdit) {
			if (!isset($GLOBALS["a_purchases_grid"])) $GLOBALS["a_purchases_grid"] = new ca_purchases_grid(); // get detail page object
			$GLOBALS["a_purchases_grid"]->ValidateGridForm();
		}
		if (in_array("a_stock_items", $DetailTblVar) && $GLOBALS["a_stock_items"]->DetailEdit) {
			if (!isset($GLOBALS["a_stock_items_grid"])) $GLOBALS["a_stock_items_grid"] = new ca_stock_items_grid(); // get detail page object
			$GLOBALS["a_stock_items_grid"]->ValidateGridForm();
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
		if ($this->Supplier_Number->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Supplier_Number` = '" . ew_AdjustSql($this->Supplier_Number->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Supplier_Number->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Supplier_Number->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Supplier_Number
			$this->Supplier_Number->SetDbValueDef($rsnew, $this->Supplier_Number->CurrentValue, "", $this->Supplier_Number->ReadOnly);

			// Supplier_Name
			$this->Supplier_Name->SetDbValueDef($rsnew, $this->Supplier_Name->CurrentValue, "", $this->Supplier_Name->ReadOnly);

			// Address
			$this->Address->SetDbValueDef($rsnew, $this->Address->CurrentValue, "", $this->Address->ReadOnly);

			// City
			$this->City->SetDbValueDef($rsnew, $this->City->CurrentValue, "", $this->City->ReadOnly);

			// Country
			$this->Country->SetDbValueDef($rsnew, $this->Country->CurrentValue, "", $this->Country->ReadOnly);

			// Contact_Person
			$this->Contact_Person->SetDbValueDef($rsnew, $this->Contact_Person->CurrentValue, "", $this->Contact_Person->ReadOnly);

			// Phone_Number
			$this->Phone_Number->SetDbValueDef($rsnew, $this->Phone_Number->CurrentValue, "", $this->Phone_Number->ReadOnly);

			// Email
			$this->_Email->SetDbValueDef($rsnew, $this->_Email->CurrentValue, "", $this->_Email->ReadOnly);

			// Mobile_Number
			$this->Mobile_Number->SetDbValueDef($rsnew, $this->Mobile_Number->CurrentValue, "", $this->Mobile_Number->ReadOnly);

			// Notes
			$this->Notes->SetDbValueDef($rsnew, $this->Notes->CurrentValue, "", $this->Notes->ReadOnly);

			// Balance
			$this->Balance->SetDbValueDef($rsnew, $this->Balance->CurrentValue, NULL, $this->Balance->ReadOnly);

			// Is_Stock_Available
			$this->Is_Stock_Available->SetDbValueDef($rsnew, ((strval($this->Is_Stock_Available->CurrentValue) == "Y") ? "Y" : "N"), "N", $this->Is_Stock_Available->ReadOnly);

			// Date_Added
			$this->Date_Added->SetDbValueDef($rsnew, $this->Date_Added->CurrentValue, NULL, $this->Date_Added->ReadOnly);

			// Added_By
			$this->Added_By->SetDbValueDef($rsnew, $this->Added_By->CurrentValue, NULL, $this->Added_By->ReadOnly);

			// Date_Updated
			$this->Date_Updated->SetDbValueDef($rsnew, ew_CurrentDateTime(), NULL);
			$rsnew['Date_Updated'] = &$this->Date_Updated->DbValue;

			// Updated_By
			$this->Updated_By->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Updated_By'] = &$this->Updated_By->DbValue;

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

				// Update detail records
				if ($EditRow) {
					$DetailTblVar = explode(",", $this->getCurrentDetailTable());
					if (in_array("a_purchases", $DetailTblVar) && $GLOBALS["a_purchases"]->DetailEdit) {
						if (!isset($GLOBALS["a_purchases_grid"])) $GLOBALS["a_purchases_grid"] = new ca_purchases_grid(); // Get detail page object
						$EditRow = $GLOBALS["a_purchases_grid"]->GridUpdate();
					}
					if (in_array("a_stock_items", $DetailTblVar) && $GLOBALS["a_stock_items"]->DetailEdit) {
						if (!isset($GLOBALS["a_stock_items_grid"])) $GLOBALS["a_stock_items_grid"] = new ca_stock_items_grid(); // Get detail page object
						$EditRow = $GLOBALS["a_stock_items_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("a_purchases", $DetailTblVar)) {
				if (!isset($GLOBALS["a_purchases_grid"]))
					$GLOBALS["a_purchases_grid"] = new ca_purchases_grid;
				if ($GLOBALS["a_purchases_grid"]->DetailEdit) {
					$GLOBALS["a_purchases_grid"]->CurrentMode = "edit";
					$GLOBALS["a_purchases_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["a_purchases_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["a_purchases_grid"]->setStartRecordNumber(1);
					$GLOBALS["a_purchases_grid"]->Supplier_ID->FldIsDetailKey = TRUE;
					$GLOBALS["a_purchases_grid"]->Supplier_ID->CurrentValue = $this->Supplier_Number->CurrentValue;
					$GLOBALS["a_purchases_grid"]->Supplier_ID->setSessionValue($GLOBALS["a_purchases_grid"]->Supplier_ID->CurrentValue);
				}
			}
			if (in_array("a_stock_items", $DetailTblVar)) {
				if (!isset($GLOBALS["a_stock_items_grid"]))
					$GLOBALS["a_stock_items_grid"] = new ca_stock_items_grid;
				if ($GLOBALS["a_stock_items_grid"]->DetailEdit) {
					$GLOBALS["a_stock_items_grid"]->CurrentMode = "edit";
					$GLOBALS["a_stock_items_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["a_stock_items_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["a_stock_items_grid"]->setStartRecordNumber(1);
					$GLOBALS["a_stock_items_grid"]->Supplier_Number->FldIsDetailKey = TRUE;
					$GLOBALS["a_stock_items_grid"]->Supplier_Number->CurrentValue = $this->Supplier_Number->CurrentValue;
					$GLOBALS["a_stock_items_grid"]->Supplier_Number->setSessionValue($GLOBALS["a_stock_items_grid"]->Supplier_Number->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_supplierslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($a_suppliers_edit)) $a_suppliers_edit = new ca_suppliers_edit();

// Page init
$a_suppliers_edit->Page_Init();

// Page main
$a_suppliers_edit->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_suppliers_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fa_suppliersedit = new ew_Form("fa_suppliersedit", "edit");

// Validate form
fa_suppliersedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Supplier_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Supplier_Number->FldCaption(), $a_suppliers->Supplier_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Supplier_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Supplier_Name->FldCaption(), $a_suppliers->Supplier_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Address");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Address->FldCaption(), $a_suppliers->Address->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_City");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->City->FldCaption(), $a_suppliers->City->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Country");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Country->FldCaption(), $a_suppliers->Country->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Contact_Person");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Contact_Person->FldCaption(), $a_suppliers->Contact_Person->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Phone_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Phone_Number->FldCaption(), $a_suppliers->Phone_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__Email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->_Email->FldCaption(), $a_suppliers->_Email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Mobile_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Mobile_Number->FldCaption(), $a_suppliers->Mobile_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Notes");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Notes->FldCaption(), $a_suppliers->Notes->ReqErrMsg)) ?>");

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
fa_suppliersedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_suppliersedit.ValidateRequired = true;
<?php } else { ?>
fa_suppliersedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_suppliersedit.Lists["x_Is_Stock_Available"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_suppliersedit.Lists["x_Is_Stock_Available"].Options = <?php echo json_encode($a_suppliers->Is_Stock_Available->Options()) ?>;

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
<?php $a_suppliers_edit->ShowPageHeader(); ?>
<?php
$a_suppliers_edit->ShowMessage();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($a_suppliers_edit->Pager)) $a_suppliers_edit->Pager = new cNumericPager($a_suppliers_edit->StartRec, $a_suppliers_edit->DisplayRecs, $a_suppliers_edit->TotalRecs, $a_suppliers_edit->RecRange) ?>
		<?php if ($a_suppliers_edit->Pager->RecordCount > 0) { ?>
				<?php if (($a_suppliers_edit->Pager->PageCount==1) && ($a_suppliers_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($a_suppliers_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_suppliers_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($a_suppliers_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $a_suppliers_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($a_suppliers_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_suppliers_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($a_suppliers_edit->Pager)) $a_suppliers_edit->Pager = new cPrevNextPager($a_suppliers_edit->StartRec, $a_suppliers_edit->DisplayRecs, $a_suppliers_edit->TotalRecs) ?>
		<?php if ($a_suppliers_edit->Pager->RecordCount > 0) { ?>
				<?php if (($a_suppliers_edit->Pager->PageCount==1) && ($a_suppliers_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($a_suppliers_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($a_suppliers_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $a_suppliers_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($a_suppliers_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($a_suppliers_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $a_suppliers_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
</form>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="fa_suppliersedit" id="fa_suppliersedit" class="<?php echo $a_suppliers_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_suppliers_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_suppliers_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_suppliers">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($a_suppliers->Supplier_ID->Visible) { // Supplier_ID ?>
	<div id="r_Supplier_ID" class="form-group">
		<label id="elh_a_suppliers_Supplier_ID" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Supplier_ID->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Supplier_ID->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_ID">
<span<?php echo $a_suppliers->Supplier_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_suppliers->Supplier_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="a_suppliers" data-field="x_Supplier_ID" name="x_Supplier_ID" id="x_Supplier_ID" value="<?php echo ew_HtmlEncode($a_suppliers->Supplier_ID->CurrentValue) ?>">
<?php echo $a_suppliers->Supplier_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Supplier_Number->Visible) { // Supplier_Number ?>
	<div id="r_Supplier_Number" class="form-group">
		<label id="elh_a_suppliers_Supplier_Number" for="x_Supplier_Number" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Supplier_Number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Supplier_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_Number">
<input type="text" data-table="a_suppliers" data-field="x_Supplier_Number" name="x_Supplier_Number" id="x_Supplier_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_Number->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Supplier_Number->EditValue ?>"<?php echo $a_suppliers->Supplier_Number->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Supplier_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Supplier_Name->Visible) { // Supplier_Name ?>
	<div id="r_Supplier_Name" class="form-group">
		<label id="elh_a_suppliers_Supplier_Name" for="x_Supplier_Name" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Supplier_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Supplier_Name->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_Name">
<input type="text" data-table="a_suppliers" data-field="x_Supplier_Name" name="x_Supplier_Name" id="x_Supplier_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_Name->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Supplier_Name->EditValue ?>"<?php echo $a_suppliers->Supplier_Name->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Supplier_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Address->Visible) { // Address ?>
	<div id="r_Address" class="form-group">
		<label id="elh_a_suppliers_Address" for="x_Address" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Address->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Address->CellAttributes() ?>>
<span id="el_a_suppliers_Address">
<textarea data-table="a_suppliers" data-field="x_Address" name="x_Address" id="x_Address" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Address->getPlaceHolder()) ?>"<?php echo $a_suppliers->Address->EditAttributes() ?>><?php echo $a_suppliers->Address->EditValue ?></textarea>
</span>
<?php echo $a_suppliers->Address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->City->Visible) { // City ?>
	<div id="r_City" class="form-group">
		<label id="elh_a_suppliers_City" for="x_City" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->City->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->City->CellAttributes() ?>>
<span id="el_a_suppliers_City">
<input type="text" data-table="a_suppliers" data-field="x_City" name="x_City" id="x_City" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_suppliers->City->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->City->EditValue ?>"<?php echo $a_suppliers->City->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->City->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Country->Visible) { // Country ?>
	<div id="r_Country" class="form-group">
		<label id="elh_a_suppliers_Country" for="x_Country" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Country->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Country->CellAttributes() ?>>
<span id="el_a_suppliers_Country">
<input type="text" data-table="a_suppliers" data-field="x_Country" name="x_Country" id="x_Country" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Country->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Country->EditValue ?>"<?php echo $a_suppliers->Country->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Country->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Contact_Person->Visible) { // Contact_Person ?>
	<div id="r_Contact_Person" class="form-group">
		<label id="elh_a_suppliers_Contact_Person" for="x_Contact_Person" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Contact_Person->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Contact_Person->CellAttributes() ?>>
<span id="el_a_suppliers_Contact_Person">
<input type="text" data-table="a_suppliers" data-field="x_Contact_Person" name="x_Contact_Person" id="x_Contact_Person" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Contact_Person->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Contact_Person->EditValue ?>"<?php echo $a_suppliers->Contact_Person->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Contact_Person->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Phone_Number->Visible) { // Phone_Number ?>
	<div id="r_Phone_Number" class="form-group">
		<label id="elh_a_suppliers_Phone_Number" for="x_Phone_Number" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Phone_Number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Phone_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Phone_Number">
<input type="text" data-table="a_suppliers" data-field="x_Phone_Number" name="x_Phone_Number" id="x_Phone_Number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Phone_Number->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Phone_Number->EditValue ?>"<?php echo $a_suppliers->Phone_Number->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Phone_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group">
		<label id="elh_a_suppliers__Email" for="x__Email" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->_Email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->_Email->CellAttributes() ?>>
<span id="el_a_suppliers__Email">
<input type="text" data-table="a_suppliers" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($a_suppliers->_Email->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->_Email->EditValue ?>"<?php echo $a_suppliers->_Email->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Mobile_Number->Visible) { // Mobile_Number ?>
	<div id="r_Mobile_Number" class="form-group">
		<label id="elh_a_suppliers_Mobile_Number" for="x_Mobile_Number" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Mobile_Number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Mobile_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Mobile_Number">
<input type="text" data-table="a_suppliers" data-field="x_Mobile_Number" name="x_Mobile_Number" id="x_Mobile_Number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Mobile_Number->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Mobile_Number->EditValue ?>"<?php echo $a_suppliers->Mobile_Number->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Mobile_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Notes->Visible) { // Notes ?>
	<div id="r_Notes" class="form-group">
		<label id="elh_a_suppliers_Notes" for="x_Notes" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Notes->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Notes->CellAttributes() ?>>
<span id="el_a_suppliers_Notes">
<textarea data-table="a_suppliers" data-field="x_Notes" name="x_Notes" id="x_Notes" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Notes->getPlaceHolder()) ?>"<?php echo $a_suppliers->Notes->EditAttributes() ?>><?php echo $a_suppliers->Notes->EditValue ?></textarea>
</span>
<?php echo $a_suppliers->Notes->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Balance->Visible) { // Balance ?>
	<div id="r_Balance" class="form-group">
		<label id="elh_a_suppliers_Balance" for="x_Balance" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Balance->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Balance->CellAttributes() ?>>
<span id="el_a_suppliers_Balance">
<input type="text" data-table="a_suppliers" data-field="x_Balance" name="x_Balance" id="x_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Balance->getPlaceHolder()) ?>" value="<?php echo $a_suppliers->Balance->EditValue ?>"<?php echo $a_suppliers->Balance->EditAttributes() ?>>
<?php if (!$a_suppliers->Balance->ReadOnly && !$a_suppliers->Balance->Disabled && @$a_suppliers->Balance->EditAttrs["readonly"] == "" && @$a_suppliers->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_suppliers->Balance->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Is_Stock_Available->Visible) { // Is_Stock_Available ?>
	<div id="r_Is_Stock_Available" class="form-group">
		<label id="elh_a_suppliers_Is_Stock_Available" for="x_Is_Stock_Available" class="col-sm-4 control-label ewLabel"><?php echo $a_suppliers->Is_Stock_Available->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_suppliers->Is_Stock_Available->CellAttributes() ?>>
<span id="el_a_suppliers_Is_Stock_Available">
<select data-table="a_suppliers" data-field="x_Is_Stock_Available" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_suppliers->Is_Stock_Available->DisplayValueSeparator) ? json_encode($a_suppliers->Is_Stock_Available->DisplayValueSeparator) : $a_suppliers->Is_Stock_Available->DisplayValueSeparator) ?>" id="x_Is_Stock_Available" name="x_Is_Stock_Available"<?php echo $a_suppliers->Is_Stock_Available->EditAttributes() ?>>
<?php
if (is_array($a_suppliers->Is_Stock_Available->EditValue)) {
	$arwrk = $a_suppliers->Is_Stock_Available->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_suppliers->Is_Stock_Available->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_suppliers->Is_Stock_Available->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_suppliers->Is_Stock_Available->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_suppliers->Is_Stock_Available->CurrentValue) ?>" selected><?php echo $a_suppliers->Is_Stock_Available->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $a_suppliers->Is_Stock_Available->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<span id="el_a_suppliers_Date_Added">
<input type="hidden" data-table="a_suppliers" data-field="x_Date_Added" name="x_Date_Added" id="x_Date_Added" value="<?php echo ew_HtmlEncode($a_suppliers->Date_Added->CurrentValue) ?>">
</span>
<span id="el_a_suppliers_Added_By">
<input type="hidden" data-table="a_suppliers" data-field="x_Added_By" name="x_Added_By" id="x_Added_By" value="<?php echo ew_HtmlEncode($a_suppliers->Added_By->CurrentValue) ?>">
</span>
<?php
	if (in_array("a_purchases", explode(",", $a_suppliers->getCurrentDetailTable())) && $a_purchases->DetailEdit) {
?>
<?php if ($a_suppliers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("a_purchases", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "a_purchasesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("a_stock_items", explode(",", $a_suppliers->getCurrentDetailTable())) && $a_stock_items->DetailEdit) {
?>
<?php if ($a_suppliers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("a_stock_items", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "a_stock_itemsgrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $a_suppliers_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($a_suppliers_edit->Pager)) $a_suppliers_edit->Pager = new cNumericPager($a_suppliers_edit->StartRec, $a_suppliers_edit->DisplayRecs, $a_suppliers_edit->TotalRecs, $a_suppliers_edit->RecRange) ?>
		<?php if ($a_suppliers_edit->Pager->RecordCount > 0) { ?>
				<?php if (($a_suppliers_edit->Pager->PageCount==1) && ($a_suppliers_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($a_suppliers_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_suppliers_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($a_suppliers_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $a_suppliers_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($a_suppliers_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_suppliers_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($a_suppliers_edit->Pager)) $a_suppliers_edit->Pager = new cPrevNextPager($a_suppliers_edit->StartRec, $a_suppliers_edit->DisplayRecs, $a_suppliers_edit->TotalRecs) ?>
		<?php if ($a_suppliers_edit->Pager->RecordCount > 0) { ?>
				<?php if (($a_suppliers_edit->Pager->PageCount==1) && ($a_suppliers_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($a_suppliers_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($a_suppliers_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $a_suppliers_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($a_suppliers_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($a_suppliers_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_suppliers_edit->PageUrl() ?>start=<?php echo $a_suppliers_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $a_suppliers_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
</form>
<script type="text/javascript">
fa_suppliersedit.Init();
</script>
<?php
$a_suppliers_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_suppliersedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($a_suppliers->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyEdit(this)'); function alertifyEdit(obj) { <?php global $Language; ?> if (fa_suppliersedit.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyEditConfirm'); ?>", function (e) {	if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyEdit'); ?>"); $("#fa_suppliersedit").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_suppliers_edit->Page_Terminate();
?>
