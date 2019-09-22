<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "a_payment_transactionsinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "view_sales_outstandingsinfo.php" ?>
<?php include_once "view_purchases_outstandingsinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$a_payment_transactions_add = NULL; // Initialize page object first

class ca_payment_transactions_add extends ca_payment_transactions {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_payment_transactions';

	// Page object name
	var $PageObjName = 'a_payment_transactions_add';

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

		// Table object (a_payment_transactions)
		if (!isset($GLOBALS["a_payment_transactions"]) || get_class($GLOBALS["a_payment_transactions"]) == "ca_payment_transactions") {
			$GLOBALS["a_payment_transactions"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["a_payment_transactions"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Table object (view_sales_outstandings)
		if (!isset($GLOBALS['view_sales_outstandings'])) $GLOBALS['view_sales_outstandings'] = new cview_sales_outstandings();

		// Table object (view_purchases_outstandings)
		if (!isset($GLOBALS['view_purchases_outstandings'])) $GLOBALS['view_purchases_outstandings'] = new cview_purchases_outstandings();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'a_payment_transactions', TRUE);

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
		if (!isset($_SESSION['table_a_payment_transactions_views'])) { 
			$_SESSION['table_a_payment_transactions_views'] = 0;
		}
		$_SESSION['table_a_payment_transactions_views'] = $_SESSION['table_a_payment_transactions_views']+1;

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
				$this->Page_Terminate(ew_GetUrl("a_payment_transactionslist.php"));
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
		global $EW_EXPORT, $a_payment_transactions;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($a_payment_transactions);
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
			if (@$_GET["Payment_ID"] != "") {
				$this->Payment_ID->setQueryStringValue($_GET["Payment_ID"]);
				$this->setKey("Payment_ID", $this->Payment_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("Payment_ID", ""); // Clear key
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
					$this->Page_Terminate("a_payment_transactionslist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "a_payment_transactionslist.php")
						$sReturnUrl = $this->AddMasterUrl($this->GetListUrl()); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "a_payment_transactionsview.php")
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
		$this->Ref_ID->CurrentValue = NULL;
		$this->Ref_ID->OldValue = $this->Ref_ID->CurrentValue;
		$this->Type->CurrentValue = NULL;
		$this->Type->OldValue = $this->Type->CurrentValue;
		$this->Customer->CurrentValue = NULL;
		$this->Customer->OldValue = $this->Customer->CurrentValue;
		$this->Supplier->CurrentValue = NULL;
		$this->Supplier->OldValue = $this->Supplier->CurrentValue;
		$this->Sub_Total->CurrentValue = 0;
		$this->Payment->CurrentValue = 0;
		$this->Balance->CurrentValue = 0;
		$this->Due_Date->CurrentValue = ew_CurrentDateTime();
		$this->Date_Transaction->CurrentValue = ew_CurrentDateTime();
		$this->Date_Added->CurrentValue = ew_CurrentDateTime();
		$this->Added_By->CurrentValue = CurrentUserName();
		$this->Date_Updated->CurrentValue = NULL;
		$this->Date_Updated->OldValue = $this->Date_Updated->CurrentValue;
		$this->Updated_By->CurrentValue = NULL;
		$this->Updated_By->OldValue = $this->Updated_By->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Ref_ID->FldIsDetailKey) {
			$this->Ref_ID->setFormValue($objForm->GetValue("x_Ref_ID"));
		}
		if (!$this->Type->FldIsDetailKey) {
			$this->Type->setFormValue($objForm->GetValue("x_Type"));
		}
		if (!$this->Customer->FldIsDetailKey) {
			$this->Customer->setFormValue($objForm->GetValue("x_Customer"));
		}
		if (!$this->Supplier->FldIsDetailKey) {
			$this->Supplier->setFormValue($objForm->GetValue("x_Supplier"));
		}
		if (!$this->Sub_Total->FldIsDetailKey) {
			$this->Sub_Total->setFormValue($objForm->GetValue("x_Sub_Total"));
		}
		if (!$this->Payment->FldIsDetailKey) {
			$this->Payment->setFormValue($objForm->GetValue("x_Payment"));
		}
		if (!$this->Balance->FldIsDetailKey) {
			$this->Balance->setFormValue($objForm->GetValue("x_Balance"));
		}
		if (!$this->Due_Date->FldIsDetailKey) {
			$this->Due_Date->setFormValue($objForm->GetValue("x_Due_Date"));
			$this->Due_Date->CurrentValue = ew_UnFormatDateTime($this->Due_Date->CurrentValue, 5);
		}
		if (!$this->Date_Transaction->FldIsDetailKey) {
			$this->Date_Transaction->setFormValue($objForm->GetValue("x_Date_Transaction"));
			$this->Date_Transaction->CurrentValue = ew_UnFormatDateTime($this->Date_Transaction->CurrentValue, 5);
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
		$this->LoadOldRecord();
		$this->Ref_ID->CurrentValue = $this->Ref_ID->FormValue;
		$this->Type->CurrentValue = $this->Type->FormValue;
		$this->Customer->CurrentValue = $this->Customer->FormValue;
		$this->Supplier->CurrentValue = $this->Supplier->FormValue;
		$this->Sub_Total->CurrentValue = $this->Sub_Total->FormValue;
		$this->Payment->CurrentValue = $this->Payment->FormValue;
		$this->Balance->CurrentValue = $this->Balance->FormValue;
		$this->Due_Date->CurrentValue = $this->Due_Date->FormValue;
		$this->Due_Date->CurrentValue = ew_UnFormatDateTime($this->Due_Date->CurrentValue, 5);
		$this->Date_Transaction->CurrentValue = $this->Date_Transaction->FormValue;
		$this->Date_Transaction->CurrentValue = ew_UnFormatDateTime($this->Date_Transaction->CurrentValue, 5);
		$this->Date_Added->CurrentValue = $this->Date_Added->FormValue;
		$this->Date_Added->CurrentValue = ew_UnFormatDateTime($this->Date_Added->CurrentValue, 0);
		$this->Added_By->CurrentValue = $this->Added_By->FormValue;
		$this->Date_Updated->CurrentValue = $this->Date_Updated->FormValue;
		$this->Date_Updated->CurrentValue = ew_UnFormatDateTime($this->Date_Updated->CurrentValue, 0);
		$this->Updated_By->CurrentValue = $this->Updated_By->FormValue;
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
		$this->Payment_ID->setDbValue($rs->fields('Payment_ID'));
		$this->Ref_ID->setDbValue($rs->fields('Ref_ID'));
		$this->Type->setDbValue($rs->fields('Type'));
		$this->Customer->setDbValue($rs->fields('Customer'));
		$this->Supplier->setDbValue($rs->fields('Supplier'));
		$this->Sub_Total->setDbValue($rs->fields('Sub_Total'));
		$this->Payment->setDbValue($rs->fields('Payment'));
		$this->Balance->setDbValue($rs->fields('Balance'));
		$this->Due_Date->setDbValue($rs->fields('Due_Date'));
		$this->Date_Transaction->setDbValue($rs->fields('Date_Transaction'));
		$this->Date_Added->setDbValue($rs->fields('Date_Added'));
		$this->Added_By->setDbValue($rs->fields('Added_By'));
		$this->Date_Updated->setDbValue($rs->fields('Date_Updated'));
		$this->Updated_By->setDbValue($rs->fields('Updated_By'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Payment_ID->DbValue = $row['Payment_ID'];
		$this->Ref_ID->DbValue = $row['Ref_ID'];
		$this->Type->DbValue = $row['Type'];
		$this->Customer->DbValue = $row['Customer'];
		$this->Supplier->DbValue = $row['Supplier'];
		$this->Sub_Total->DbValue = $row['Sub_Total'];
		$this->Payment->DbValue = $row['Payment'];
		$this->Balance->DbValue = $row['Balance'];
		$this->Due_Date->DbValue = $row['Due_Date'];
		$this->Date_Transaction->DbValue = $row['Date_Transaction'];
		$this->Date_Added->DbValue = $row['Date_Added'];
		$this->Added_By->DbValue = $row['Added_By'];
		$this->Date_Updated->DbValue = $row['Date_Updated'];
		$this->Updated_By->DbValue = $row['Updated_By'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Payment_ID")) <> "")
			$this->Payment_ID->CurrentValue = $this->getKey("Payment_ID"); // Payment_ID
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
		// Convert decimal values if posted back

		if ($this->Sub_Total->FormValue == $this->Sub_Total->CurrentValue && is_numeric(ew_StrToFloat($this->Sub_Total->CurrentValue)))
			$this->Sub_Total->CurrentValue = ew_StrToFloat($this->Sub_Total->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Payment->FormValue == $this->Payment->CurrentValue && is_numeric(ew_StrToFloat($this->Payment->CurrentValue)))
			$this->Payment->CurrentValue = ew_StrToFloat($this->Payment->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Balance->FormValue == $this->Balance->CurrentValue && is_numeric(ew_StrToFloat($this->Balance->CurrentValue)))
			$this->Balance->CurrentValue = ew_StrToFloat($this->Balance->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Payment_ID
		// Ref_ID
		// Type
		// Customer
		// Supplier
		// Sub_Total
		// Payment
		// Balance
		// Due_Date
		// Date_Transaction
		// Date_Added
		// Added_By
		// Date_Updated
		// Updated_By

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Ref_ID
		$this->Ref_ID->ViewValue = $this->Ref_ID->CurrentValue;
		$this->Ref_ID->ViewCustomAttributes = "";

		// Type
		if (strval($this->Type->CurrentValue) <> "") {
			$this->Type->ViewValue = $this->Type->OptionCaption($this->Type->CurrentValue);
		} else {
			$this->Type->ViewValue = NULL;
		}
		$this->Type->ViewCustomAttributes = "";

		// Customer
		if (strval($this->Customer->CurrentValue) <> "") {
			$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Customer, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Customer->ViewValue = $this->Customer->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Customer->ViewValue = $this->Customer->CurrentValue;
			}
		} else {
			$this->Customer->ViewValue = NULL;
		}
		$this->Customer->ViewCustomAttributes = "";

		// Supplier
		if (strval($this->Supplier->CurrentValue) <> "") {
			$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Supplier, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Supplier->ViewValue = $this->Supplier->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Supplier->ViewValue = $this->Supplier->CurrentValue;
			}
		} else {
			$this->Supplier->ViewValue = NULL;
		}
		$this->Supplier->ViewCustomAttributes = "";

		// Sub_Total
		$this->Sub_Total->ViewValue = $this->Sub_Total->CurrentValue;
		$this->Sub_Total->ViewValue = ew_FormatCurrency($this->Sub_Total->ViewValue, 2, -2, -2, -2);
		$this->Sub_Total->CellCssStyle .= "text-align: right;";
		$this->Sub_Total->ViewCustomAttributes = "";

		// Payment
		$this->Payment->ViewValue = $this->Payment->CurrentValue;
		$this->Payment->ViewValue = ew_FormatCurrency($this->Payment->ViewValue, 2, -2, -2, -2);
		$this->Payment->CellCssStyle .= "text-align: right;";
		$this->Payment->ViewCustomAttributes = "";

		// Balance
		$this->Balance->ViewValue = $this->Balance->CurrentValue;
		$this->Balance->ViewValue = ew_FormatCurrency($this->Balance->ViewValue, 2, -2, -2, -2);
		$this->Balance->CellCssStyle .= "text-align: right;";
		$this->Balance->ViewCustomAttributes = "";

		// Due_Date
		$this->Due_Date->ViewValue = $this->Due_Date->CurrentValue;
		$this->Due_Date->ViewValue = ew_FormatDateTime($this->Due_Date->ViewValue, 5);
		$this->Due_Date->ViewCustomAttributes = "";

		// Date_Transaction
		$this->Date_Transaction->ViewValue = $this->Date_Transaction->CurrentValue;
		$this->Date_Transaction->ViewValue = ew_FormatDateTime($this->Date_Transaction->ViewValue, 5);
		$this->Date_Transaction->ViewCustomAttributes = "";

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

			// Ref_ID
			$this->Ref_ID->LinkCustomAttributes = "";
			$this->Ref_ID->HrefValue = "";
			$this->Ref_ID->TooltipValue = "";

			// Type
			$this->Type->LinkCustomAttributes = "";
			$this->Type->HrefValue = "";
			$this->Type->TooltipValue = "";

			// Customer
			$this->Customer->LinkCustomAttributes = "";
			$this->Customer->HrefValue = "";
			$this->Customer->TooltipValue = "";

			// Supplier
			$this->Supplier->LinkCustomAttributes = "";
			$this->Supplier->HrefValue = "";
			$this->Supplier->TooltipValue = "";

			// Sub_Total
			$this->Sub_Total->LinkCustomAttributes = "";
			$this->Sub_Total->HrefValue = "";
			$this->Sub_Total->TooltipValue = "";

			// Payment
			$this->Payment->LinkCustomAttributes = "";
			$this->Payment->HrefValue = "";
			$this->Payment->TooltipValue = "";

			// Balance
			$this->Balance->LinkCustomAttributes = "";
			$this->Balance->HrefValue = "";
			$this->Balance->TooltipValue = "";

			// Due_Date
			$this->Due_Date->LinkCustomAttributes = "";
			$this->Due_Date->HrefValue = "";
			$this->Due_Date->TooltipValue = "";

			// Date_Transaction
			$this->Date_Transaction->LinkCustomAttributes = "";
			$this->Date_Transaction->HrefValue = "";
			$this->Date_Transaction->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Ref_ID
			$this->Ref_ID->EditAttrs["class"] = "form-control";
			$this->Ref_ID->EditCustomAttributes = "";
			if ($this->Ref_ID->getSessionValue() <> "") {
				$this->Ref_ID->CurrentValue = $this->Ref_ID->getSessionValue();
			$this->Ref_ID->ViewValue = $this->Ref_ID->CurrentValue;
			$this->Ref_ID->ViewCustomAttributes = "";
			} else {
			$this->Ref_ID->EditValue = ew_HtmlEncode($this->Ref_ID->CurrentValue);
			$this->Ref_ID->PlaceHolder = ew_RemoveHtml($this->Ref_ID->FldCaption());
			}

			// Type
			$this->Type->EditCustomAttributes = "";
			$this->Type->EditValue = $this->Type->Options(FALSE);

			// Customer
			$this->Customer->EditAttrs["class"] = "form-control";
			$this->Customer->EditCustomAttributes = "";
			if (trim(strval($this->Customer->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer->CurrentValue, EW_DATATYPE_STRING, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_customers`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_customers`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Customer, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Customer->EditValue = $arwrk;

			// Supplier
			$this->Supplier->EditAttrs["class"] = "form-control";
			$this->Supplier->EditCustomAttributes = "";
			if (trim(strval($this->Supplier->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier->CurrentValue, EW_DATATYPE_STRING, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_suppliers`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_suppliers`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Supplier, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Supplier->EditValue = $arwrk;

			// Sub_Total
			$this->Sub_Total->EditAttrs["class"] = "form-control";
			$this->Sub_Total->EditCustomAttributes = "";
			$this->Sub_Total->EditValue = ew_HtmlEncode($this->Sub_Total->CurrentValue);
			$this->Sub_Total->PlaceHolder = ew_RemoveHtml($this->Sub_Total->FldCaption());
			if (strval($this->Sub_Total->EditValue) <> "" && is_numeric($this->Sub_Total->EditValue)) $this->Sub_Total->EditValue = ew_FormatNumber($this->Sub_Total->EditValue, -2, -2, -2, -2);

			// Payment
			$this->Payment->EditAttrs["class"] = "form-control";
			$this->Payment->EditCustomAttributes = "";
			$this->Payment->EditValue = ew_HtmlEncode($this->Payment->CurrentValue);
			$this->Payment->PlaceHolder = ew_RemoveHtml($this->Payment->FldCaption());
			if (strval($this->Payment->EditValue) <> "" && is_numeric($this->Payment->EditValue)) $this->Payment->EditValue = ew_FormatNumber($this->Payment->EditValue, -2, -2, -2, -2);

			// Balance
			$this->Balance->EditAttrs["class"] = "form-control";
			$this->Balance->EditCustomAttributes = "";
			$this->Balance->EditValue = ew_HtmlEncode($this->Balance->CurrentValue);
			$this->Balance->PlaceHolder = ew_RemoveHtml($this->Balance->FldCaption());
			if (strval($this->Balance->EditValue) <> "" && is_numeric($this->Balance->EditValue)) $this->Balance->EditValue = ew_FormatNumber($this->Balance->EditValue, -2, -2, -2, -2);

			// Due_Date
			$this->Due_Date->EditAttrs["class"] = "form-control";
			$this->Due_Date->EditCustomAttributes = "";
			$this->Due_Date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Due_Date->CurrentValue, 5));
			$this->Due_Date->PlaceHolder = ew_RemoveHtml($this->Due_Date->FldCaption());

			// Date_Transaction
			$this->Date_Transaction->EditAttrs["class"] = "form-control";
			$this->Date_Transaction->EditCustomAttributes = "";
			$this->Date_Transaction->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Date_Transaction->CurrentValue, 5));
			$this->Date_Transaction->PlaceHolder = ew_RemoveHtml($this->Date_Transaction->FldCaption());

			// Date_Added
			$this->Date_Added->EditAttrs["class"] = "form-control";
			$this->Date_Added->EditCustomAttributes = "";
			$this->Date_Added->CurrentValue = ew_CurrentDateTime();

			// Added_By
			$this->Added_By->EditAttrs["class"] = "form-control";
			$this->Added_By->EditCustomAttributes = "";
			$this->Added_By->CurrentValue = CurrentUserName();

			// Date_Updated
			// Updated_By
			// Add refer script
			// Ref_ID

			$this->Ref_ID->LinkCustomAttributes = "";
			$this->Ref_ID->HrefValue = "";

			// Type
			$this->Type->LinkCustomAttributes = "";
			$this->Type->HrefValue = "";

			// Customer
			$this->Customer->LinkCustomAttributes = "";
			$this->Customer->HrefValue = "";

			// Supplier
			$this->Supplier->LinkCustomAttributes = "";
			$this->Supplier->HrefValue = "";

			// Sub_Total
			$this->Sub_Total->LinkCustomAttributes = "";
			$this->Sub_Total->HrefValue = "";

			// Payment
			$this->Payment->LinkCustomAttributes = "";
			$this->Payment->HrefValue = "";

			// Balance
			$this->Balance->LinkCustomAttributes = "";
			$this->Balance->HrefValue = "";

			// Due_Date
			$this->Due_Date->LinkCustomAttributes = "";
			$this->Due_Date->HrefValue = "";

			// Date_Transaction
			$this->Date_Transaction->LinkCustomAttributes = "";
			$this->Date_Transaction->HrefValue = "";

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
		if (!ew_CheckRange($this->Payment->FormValue, 1, 999999999)) {
			ew_AddMessage($gsFormError, $this->Payment->FldErrMsg());
		}
		if (!ew_CheckDate($this->Due_Date->FormValue)) {
			ew_AddMessage($gsFormError, $this->Due_Date->FldErrMsg());
		}
		if (!ew_CheckDate($this->Date_Transaction->FormValue)) {
			ew_AddMessage($gsFormError, $this->Date_Transaction->FldErrMsg());
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

		// Ref_ID
		$this->Ref_ID->SetDbValueDef($rsnew, $this->Ref_ID->CurrentValue, NULL, FALSE);

		// Type
		$this->Type->SetDbValueDef($rsnew, $this->Type->CurrentValue, NULL, FALSE);

		// Customer
		$this->Customer->SetDbValueDef($rsnew, $this->Customer->CurrentValue, NULL, FALSE);

		// Supplier
		$this->Supplier->SetDbValueDef($rsnew, $this->Supplier->CurrentValue, NULL, FALSE);

		// Sub_Total
		$this->Sub_Total->SetDbValueDef($rsnew, $this->Sub_Total->CurrentValue, 0, strval($this->Sub_Total->CurrentValue) == "");

		// Payment
		$this->Payment->SetDbValueDef($rsnew, $this->Payment->CurrentValue, 0, strval($this->Payment->CurrentValue) == "");

		// Balance
		$this->Balance->SetDbValueDef($rsnew, $this->Balance->CurrentValue, 0, strval($this->Balance->CurrentValue) == "");

		// Due_Date
		$this->Due_Date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Due_Date->CurrentValue, 5), NULL, FALSE);

		// Date_Transaction
		$this->Date_Transaction->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Date_Transaction->CurrentValue, 5), NULL, FALSE);

		// Date_Added
		$this->Date_Added->SetDbValueDef($rsnew, $this->Date_Added->CurrentValue, NULL, FALSE);

		// Added_By
		$this->Added_By->SetDbValueDef($rsnew, $this->Added_By->CurrentValue, NULL, FALSE);

		// Date_Updated
		$this->Date_Updated->SetDbValueDef($rsnew, ew_CurrentDateTime(), NULL);
		$rsnew['Date_Updated'] = &$this->Date_Updated->DbValue;

		// Updated_By
		$this->Updated_By->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Updated_By'] = &$this->Updated_By->DbValue;

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->Payment_ID->setDbValue($conn->Insert_ID());
				$rsnew['Payment_ID'] = $this->Payment_ID->DbValue;
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
			if ($sMasterTblVar == "view_sales_outstandings") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Sales_Number"] <> "") {
					$GLOBALS["view_sales_outstandings"]->Sales_Number->setQueryStringValue($_GET["fk_Sales_Number"]);
					$this->Ref_ID->setQueryStringValue($GLOBALS["view_sales_outstandings"]->Sales_Number->QueryStringValue);
					$this->Ref_ID->setSessionValue($this->Ref_ID->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "view_purchases_outstandings") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Purchase_Number"] <> "") {
					$GLOBALS["view_purchases_outstandings"]->Purchase_Number->setQueryStringValue($_GET["fk_Purchase_Number"]);
					$this->Ref_ID->setQueryStringValue($GLOBALS["view_purchases_outstandings"]->Purchase_Number->QueryStringValue);
					$this->Ref_ID->setSessionValue($this->Ref_ID->QueryStringValue);
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
			if ($sMasterTblVar == "view_sales_outstandings") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Sales_Number"] <> "") {
					$GLOBALS["view_sales_outstandings"]->Sales_Number->setFormValue($_POST["fk_Sales_Number"]);
					$this->Ref_ID->setFormValue($GLOBALS["view_sales_outstandings"]->Sales_Number->FormValue);
					$this->Ref_ID->setSessionValue($this->Ref_ID->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "view_purchases_outstandings") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Purchase_Number"] <> "") {
					$GLOBALS["view_purchases_outstandings"]->Purchase_Number->setFormValue($_POST["fk_Purchase_Number"]);
					$this->Ref_ID->setFormValue($GLOBALS["view_purchases_outstandings"]->Purchase_Number->FormValue);
					$this->Ref_ID->setSessionValue($this->Ref_ID->FormValue);
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
			if ($sMasterTblVar <> "view_sales_outstandings") {
				if ($this->Ref_ID->CurrentValue == "") $this->Ref_ID->setSessionValue("");
			}
			if ($sMasterTblVar <> "view_purchases_outstandings") {
				if ($this->Ref_ID->CurrentValue == "") $this->Ref_ID->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_payment_transactionslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url); // v11.0.4
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
		if (isset($_GET["Sales_Number_Payment"])) {	
			$_SESSION["Sales_Number_Payment"] = $_GET["Sales_Number_Payment"];
		}
		if (isset($_GET["Transaction_Type"])) {	
			$_SESSION["Transaction_Type"] = $_GET["Transaction_Type"];
		}
		if (isset($_GET["Purchase_Number_Payment"])) {	
			$_SESSION["Purchase_Number_Payment"] = $_GET["Purchase_Number_Payment"];
		}
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

		if ($_SESSION["Purchase_Number_Payment"] <> "") {
			if ($this->CurrentAction == "A") {

				// after adding a new record, redirect to List Page
			} else {
				if (GetStartBalance("purchase", $_SESSION["Purchase_Number_Payment"]) == 0) {
					$this->setWarningMessage("There are no related outstanding. Please choose <strong>Pay Now!</strong> from this List!");
					$url = "a_purchaseslist.php";
				}
			}
		} elseif ($_SESSION["Sales_Number_Payment"] <> "") {
			if ($this->CurrentAction == "A") {

				// after adding a new record, redirect to List Page
			} else {
				if (GetStartBalance("sales", $_SESSION["Sales_Number_Payment"]) == 0) {
					$this->setWarningMessage("There are no related outstanding. Please choose <strong>Pay Now!</strong> from this List!");
					$url = "a_saleslist.php";
				}
			}
		} elseif ($_SESSION["Purchase_Number_Payment"] == "" && $_SESSION["Sales_Number_Payment"] == "") {
			$this->setWarningMessage("There are no related outstanding. <br><br>Please choose <strong>Pay Now!</strong> either from <strong>Sales</strong> or <strong>Purchases</strong> menu!");
			$url = "a_payment_transactionslist.php";
		}
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
if (!isset($a_payment_transactions_add)) $a_payment_transactions_add = new ca_payment_transactions_add();

// Page init
$a_payment_transactions_add->Page_Init();

// Page main
$a_payment_transactions_add->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_payment_transactions_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fa_payment_transactionsadd = new ew_Form("fa_payment_transactionsadd", "add");

// Validate form
fa_payment_transactionsadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Payment");
			if (elm && !ew_CheckRange(elm.value, 1, 999999999))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_payment_transactions->Payment->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Due_Date");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_payment_transactions->Due_Date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Date_Transaction");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_payment_transactions->Date_Transaction->FldErrMsg()) ?>");

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
fa_payment_transactionsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_payment_transactionsadd.ValidateRequired = true;
<?php } else { ?>
fa_payment_transactionsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_payment_transactionsadd.Lists["x_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_payment_transactionsadd.Lists["x_Type"].Options = <?php echo json_encode($a_payment_transactions->Type->Options()) ?>;
fa_payment_transactionsadd.Lists["x_Customer"] = {"LinkField":"x_Customer_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_payment_transactionsadd.Lists["x_Supplier"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $a_payment_transactions_add->ShowPageHeader(); ?>
<?php
$a_payment_transactions_add->ShowMessage();
?>
<form name="fa_payment_transactionsadd" id="fa_payment_transactionsadd" class="<?php echo $a_payment_transactions_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_payment_transactions_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_payment_transactions_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_payment_transactions">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($a_payment_transactions->getCurrentMasterTable() == "view_sales_outstandings") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="view_sales_outstandings">
<input type="hidden" name="fk_Sales_Number" value="<?php echo $a_payment_transactions->Ref_ID->getSessionValue() ?>">
<?php } ?>
<?php if ($a_payment_transactions->getCurrentMasterTable() == "view_purchases_outstandings") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="view_purchases_outstandings">
<input type="hidden" name="fk_Purchase_Number" value="<?php echo $a_payment_transactions->Ref_ID->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($a_payment_transactions->Ref_ID->Visible) { // Ref_ID ?>
	<div id="r_Ref_ID" class="form-group">
		<label id="elh_a_payment_transactions_Ref_ID" for="x_Ref_ID" class="col-sm-4 control-label ewLabel"><?php echo $a_payment_transactions->Ref_ID->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_payment_transactions->Ref_ID->CellAttributes() ?>>
<?php if ($a_payment_transactions->Ref_ID->getSessionValue() <> "") { ?>
<span id="el_a_payment_transactions_Ref_ID">
<span<?php echo $a_payment_transactions->Ref_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_payment_transactions->Ref_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_Ref_ID" name="x_Ref_ID" value="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el_a_payment_transactions_Ref_ID">
<input type="text" data-table="a_payment_transactions" data-field="x_Ref_ID" name="x_Ref_ID" id="x_Ref_ID" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Ref_ID->EditValue ?>"<?php echo $a_payment_transactions->Ref_ID->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $a_payment_transactions->Ref_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Type->Visible) { // Type ?>
	<div id="r_Type" class="form-group">
		<label id="elh_a_payment_transactions_Type" class="col-sm-4 control-label ewLabel"><?php echo $a_payment_transactions->Type->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_payment_transactions->Type->CellAttributes() ?>>
<span id="el_a_payment_transactions_Type">
<div id="tp_x_Type" class="ewTemplate"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Type->DisplayValueSeparator) ? json_encode($a_payment_transactions->Type->DisplayValueSeparator) : $a_payment_transactions->Type->DisplayValueSeparator) ?>" name="x_Type" id="x_Type" value="{value}"<?php echo $a_payment_transactions->Type->EditAttributes() ?>></div>
<div id="dsl_x_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $a_payment_transactions->Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_payment_transactions->Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="x_Type" id="x_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="x_Type" id="x_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->CurrentValue) ?>" checked<?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $a_payment_transactions->Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Customer->Visible) { // Customer ?>
	<div id="r_Customer" class="form-group">
		<label id="elh_a_payment_transactions_Customer" for="x_Customer" class="col-sm-4 control-label ewLabel"><?php echo $a_payment_transactions->Customer->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_payment_transactions->Customer->CellAttributes() ?>>
<span id="el_a_payment_transactions_Customer">
<select data-table="a_payment_transactions" data-field="x_Customer" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Customer->DisplayValueSeparator) ? json_encode($a_payment_transactions->Customer->DisplayValueSeparator) : $a_payment_transactions->Customer->DisplayValueSeparator) ?>" id="x_Customer" name="x_Customer"<?php echo $a_payment_transactions->Customer->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Customer->EditValue)) {
	$arwrk = $a_payment_transactions->Customer->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Customer->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_payment_transactions->Customer->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Customer->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_payment_transactions->Customer->CurrentValue) ?>" selected><?php echo $a_payment_transactions->Customer->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Customer_Number`, `Customer_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_customers`";
		$sWhereWrk = "";
		break;
}
$a_payment_transactions->Customer->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_payment_transactions->Customer->LookupFilters += array("f0" => "`Customer_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_payment_transactions->Lookup_Selecting($a_payment_transactions->Customer, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_payment_transactions->Customer->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Customer" id="s_x_Customer" value="<?php echo $a_payment_transactions->Customer->LookupFilterQuery() ?>">
</span>
<?php echo $a_payment_transactions->Customer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Supplier->Visible) { // Supplier ?>
	<div id="r_Supplier" class="form-group">
		<label id="elh_a_payment_transactions_Supplier" for="x_Supplier" class="col-sm-4 control-label ewLabel"><?php echo $a_payment_transactions->Supplier->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_payment_transactions->Supplier->CellAttributes() ?>>
<span id="el_a_payment_transactions_Supplier">
<select data-table="a_payment_transactions" data-field="x_Supplier" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Supplier->DisplayValueSeparator) ? json_encode($a_payment_transactions->Supplier->DisplayValueSeparator) : $a_payment_transactions->Supplier->DisplayValueSeparator) ?>" id="x_Supplier" name="x_Supplier"<?php echo $a_payment_transactions->Supplier->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Supplier->EditValue)) {
	$arwrk = $a_payment_transactions->Supplier->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Supplier->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_payment_transactions->Supplier->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Supplier->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_payment_transactions->Supplier->CurrentValue) ?>" selected><?php echo $a_payment_transactions->Supplier->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Supplier_Number`, `Supplier_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_suppliers`";
		$sWhereWrk = "";
		break;
}
$a_payment_transactions->Supplier->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_payment_transactions->Supplier->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_payment_transactions->Lookup_Selecting($a_payment_transactions->Supplier, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_payment_transactions->Supplier->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Supplier" id="s_x_Supplier" value="<?php echo $a_payment_transactions->Supplier->LookupFilterQuery() ?>">
</span>
<?php echo $a_payment_transactions->Supplier->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Sub_Total->Visible) { // Sub_Total ?>
	<div id="r_Sub_Total" class="form-group">
		<label id="elh_a_payment_transactions_Sub_Total" for="x_Sub_Total" class="col-sm-4 control-label ewLabel"><?php echo $a_payment_transactions->Sub_Total->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_payment_transactions->Sub_Total->CellAttributes() ?>>
<span id="el_a_payment_transactions_Sub_Total">
<input type="text" data-table="a_payment_transactions" data-field="x_Sub_Total" name="x_Sub_Total" id="x_Sub_Total" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Sub_Total->EditValue ?>"<?php echo $a_payment_transactions->Sub_Total->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Sub_Total->ReadOnly && !$a_payment_transactions->Sub_Total->Disabled && @$a_payment_transactions->Sub_Total->EditAttrs["readonly"] == "" && @$a_payment_transactions->Sub_Total->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Sub_Total').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_payment_transactions->Sub_Total->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Payment->Visible) { // Payment ?>
	<div id="r_Payment" class="form-group">
		<label id="elh_a_payment_transactions_Payment" for="x_Payment" class="col-sm-4 control-label ewLabel"><?php echo $a_payment_transactions->Payment->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_payment_transactions->Payment->CellAttributes() ?>>
<span id="el_a_payment_transactions_Payment">
<input type="text" data-table="a_payment_transactions" data-field="x_Payment" name="x_Payment" id="x_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Payment->EditValue ?>"<?php echo $a_payment_transactions->Payment->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Payment->ReadOnly && !$a_payment_transactions->Payment->Disabled && @$a_payment_transactions->Payment->EditAttrs["readonly"] == "" && @$a_payment_transactions->Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_payment_transactions->Payment->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Balance->Visible) { // Balance ?>
	<div id="r_Balance" class="form-group">
		<label id="elh_a_payment_transactions_Balance" for="x_Balance" class="col-sm-4 control-label ewLabel"><?php echo $a_payment_transactions->Balance->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_payment_transactions->Balance->CellAttributes() ?>>
<span id="el_a_payment_transactions_Balance">
<input type="text" data-table="a_payment_transactions" data-field="x_Balance" name="x_Balance" id="x_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Balance->EditValue ?>"<?php echo $a_payment_transactions->Balance->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Balance->ReadOnly && !$a_payment_transactions->Balance->Disabled && @$a_payment_transactions->Balance->EditAttrs["readonly"] == "" && @$a_payment_transactions->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_payment_transactions->Balance->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Due_Date->Visible) { // Due_Date ?>
	<div id="r_Due_Date" class="form-group">
		<label id="elh_a_payment_transactions_Due_Date" for="x_Due_Date" class="col-sm-4 control-label ewLabel"><?php echo $a_payment_transactions->Due_Date->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_payment_transactions->Due_Date->CellAttributes() ?>>
<span id="el_a_payment_transactions_Due_Date">
<input type="text" data-table="a_payment_transactions" data-field="x_Due_Date" data-format="5" name="x_Due_Date" id="x_Due_Date" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Due_Date->EditValue ?>"<?php echo $a_payment_transactions->Due_Date->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Due_Date->ReadOnly && !$a_payment_transactions->Due_Date->Disabled && !isset($a_payment_transactions->Due_Date->EditAttrs["readonly"]) && !isset($a_payment_transactions->Due_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionsadd", "x_Due_Date", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php echo $a_payment_transactions->Due_Date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Date_Transaction->Visible) { // Date_Transaction ?>
	<div id="r_Date_Transaction" class="form-group">
		<label id="elh_a_payment_transactions_Date_Transaction" for="x_Date_Transaction" class="col-sm-4 control-label ewLabel"><?php echo $a_payment_transactions->Date_Transaction->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_payment_transactions->Date_Transaction->CellAttributes() ?>>
<span id="el_a_payment_transactions_Date_Transaction">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Transaction" data-format="5" name="x_Date_Transaction" id="x_Date_Transaction" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Transaction->EditValue ?>"<?php echo $a_payment_transactions->Date_Transaction->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Date_Transaction->ReadOnly && !$a_payment_transactions->Date_Transaction->Disabled && !isset($a_payment_transactions->Date_Transaction->EditAttrs["readonly"]) && !isset($a_payment_transactions->Date_Transaction->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionsadd", "x_Date_Transaction", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php echo $a_payment_transactions->Date_Transaction->CustomMsg ?></div></div>
	</div>
<?php } ?>
<span id="el_a_payment_transactions_Date_Added">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Date_Added" name="x_Date_Added" id="x_Date_Added" value="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Added->CurrentValue) ?>">
</span>
<span id="el_a_payment_transactions_Added_By">
<input type="hidden" data-table="a_payment_transactions" data-field="x_Added_By" name="x_Added_By" id="x_Added_By" value="<?php echo ew_HtmlEncode($a_payment_transactions->Added_By->CurrentValue) ?>">
</span>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $a_payment_transactions_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fa_payment_transactionsadd.Init();
</script>
<?php
$a_payment_transactions_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">
$(document).on("updatedone", function(e, args) {
	if (args.target.id == "x_Customer") {
		<?php if (@$_GET["Transaction_Type"] == "sales") { ?>
		$(args.target).val("<?php echo GetCustomerNumber($_SESSION["Sales_Number_Payment"]); ?>");
		$(args.target).attr('disabled','disabled');
		<?php } ?>
	}
	if (args.target.id == "x_Supplier") {
		<?php if (@$_GET["Transaction_Type"] == "purchase") { ?>
		$(args.target).val("<?php echo GetSupplierNumber($_GET["Purchase_Number_Payment"]); ?>");
		$(args.target).attr('disabled','disabled');
		<?php } ?>
	}
});
$(document).ready(function() {
	$('#elh_a_payment_transactions_Customer').append('<span class="ewRequired">&nbsp;*</span>');
	$('#elh_a_payment_transactions_Supplier').append('<span class="ewRequired">&nbsp;*</span>');
	if($('input[name=x_Type]:radio:checked').val()=="sales"){
		$('#x_Supplier').val("");
		$('#r_Supplier').hide();
		$('#r_Customer').show();
	} else if($('input[name=x_Type]:radio:checked').val()=="purchase"){
		$('#x_Customer').val("");
		$('#r_Customer').hide();
		$('#r_Supplier').show();  
	} else {
		$('#x_Customer').val("");
		$('#x_Supplier').val("");
		$('#r_Customer').hide();
		$('#r_Supplier').hide();
	}
	$('input[name=x_Type]:radio').click(function(){
		if($(this).attr("value")=="sales"){
			$('#x_Supplier').val("");
			$('#r_Supplier').hide();
			$('#r_Customer').show();
		} else if($('input[name=x_Type]:radio:checked').val()=="purchase"){
			$('#x_Customer').val("");
			$('#r_Customer').hide();
			$('#r_Supplier').show();
		} else {
			$('#x_Customer').val("");
			$('#x_Supplier').val("");
			$('#r_Customer').hide();
			$('#r_Supplier').hide();
		}
	});
	$("#x_Balance").blur(function() {
		<?php if ($_SESSION["Transaction_Type"] == "sales") { ?>
		var sub_total = "<?php echo GetStartBalance("sales", $_SESSION["Sales_Number_Payment"]); ?>";
		<?php } else { ?>
		var sub_total = "<?php echo GetStartBalance("purchase", $_SESSION["Purchase_Number_Payment"]); ?>";
		<?php } ?>
		var payment = $("#x_Payment").autoNumeric('get');
		var balance = sub_total - payment;
		$("#x_Balance").val(balance);
	});
});

function SetFocusTextBox(name) {
	$("#x_"+ name +"").select(); 
}

function GetBalancePayment() {
	<?php if ($_SESSION["Transaction_Type"] == "sales") { ?>
	var sub_total = <?php echo GetStartBalance("sales", $_SESSION["Sales_Number_Payment"]); ?>;
	<?php } else { ?>
	var sub_total = <?php echo GetStartBalance("purchase", $_SESSION["Purchase_Number_Payment"]); ?>;
	<?php } ?>
	var payment = $("#x_Payment").autoNumeric('get');
	var balance = sub_total - payment;
	$("#x_Balance").val(balance);
	if (payment > sub_total) {
		$("#x_Payment").val(sub_total);
		$("#x_Balance").val("0");
	}
}
</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_payment_transactionsadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($a_payment_transactions->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyAdd(this)'); function alertifyAdd(obj) { <?php global $Language; ?> if (fa_payment_transactionsadd.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyAddConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyAdd'); ?>"); $("#fa_payment_transactionsadd").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_payment_transactions_add->Page_Terminate();
?>
