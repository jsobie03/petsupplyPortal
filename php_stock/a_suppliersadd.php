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

$a_suppliers_add = NULL; // Initialize page object first

class ca_suppliers_add extends ca_suppliers {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_suppliers';

	// Page object name
	var $PageObjName = 'a_suppliers_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

			// End of modification Permission Access for Export To Feature, by Masino Sinaga, May 5, 2012
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Supplier_ID"] != "") {
				$this->Supplier_ID->setQueryStringValue($_GET["Supplier_ID"]);
				$this->setKey("Supplier_ID", $this->Supplier_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("Supplier_ID", ""); // Clear key
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("a_supplierslist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
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
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "a_supplierslist.php")
						$sReturnUrl = $this->AddMasterUrl($this->GetListUrl()); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "a_suppliersview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->Supplier_Number->CurrentValue = NULL;
		$this->Supplier_Number->OldValue = $this->Supplier_Number->CurrentValue;
		$this->Supplier_Name->CurrentValue = NULL;
		$this->Supplier_Name->OldValue = $this->Supplier_Name->CurrentValue;
		$this->Address->CurrentValue = NULL;
		$this->Address->OldValue = $this->Address->CurrentValue;
		$this->City->CurrentValue = NULL;
		$this->City->OldValue = $this->City->CurrentValue;
		$this->Country->CurrentValue = NULL;
		$this->Country->OldValue = $this->Country->CurrentValue;
		$this->Contact_Person->CurrentValue = NULL;
		$this->Contact_Person->OldValue = $this->Contact_Person->CurrentValue;
		$this->Phone_Number->CurrentValue = NULL;
		$this->Phone_Number->OldValue = $this->Phone_Number->CurrentValue;
		$this->_Email->CurrentValue = NULL;
		$this->_Email->OldValue = $this->_Email->CurrentValue;
		$this->Mobile_Number->CurrentValue = NULL;
		$this->Mobile_Number->OldValue = $this->Mobile_Number->CurrentValue;
		$this->Notes->CurrentValue = NULL;
		$this->Notes->OldValue = $this->Notes->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Supplier_ID")) <> "")
			$this->Supplier_ID->CurrentValue = $this->getKey("Supplier_ID"); // Supplier_ID
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
		if (in_array("a_purchases", $DetailTblVar) && $GLOBALS["a_purchases"]->DetailAdd) {
			if (!isset($GLOBALS["a_purchases_grid"])) $GLOBALS["a_purchases_grid"] = new ca_purchases_grid(); // get detail page object
			$GLOBALS["a_purchases_grid"]->ValidateGridForm();
		}
		if (in_array("a_stock_items", $DetailTblVar) && $GLOBALS["a_stock_items"]->DetailAdd) {
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		if ($this->Supplier_Number->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Supplier_Number = '" . ew_AdjustSql($this->Supplier_Number->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Supplier_Number->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Supplier_Number->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Supplier_Number
		$this->Supplier_Number->SetDbValueDef($rsnew, $this->Supplier_Number->CurrentValue, "", FALSE);

		// Supplier_Name
		$this->Supplier_Name->SetDbValueDef($rsnew, $this->Supplier_Name->CurrentValue, "", FALSE);

		// Address
		$this->Address->SetDbValueDef($rsnew, $this->Address->CurrentValue, "", FALSE);

		// City
		$this->City->SetDbValueDef($rsnew, $this->City->CurrentValue, "", FALSE);

		// Country
		$this->Country->SetDbValueDef($rsnew, $this->Country->CurrentValue, "", FALSE);

		// Contact_Person
		$this->Contact_Person->SetDbValueDef($rsnew, $this->Contact_Person->CurrentValue, "", FALSE);

		// Phone_Number
		$this->Phone_Number->SetDbValueDef($rsnew, $this->Phone_Number->CurrentValue, "", FALSE);

		// Email
		$this->_Email->SetDbValueDef($rsnew, $this->_Email->CurrentValue, "", FALSE);

		// Mobile_Number
		$this->Mobile_Number->SetDbValueDef($rsnew, $this->Mobile_Number->CurrentValue, "", FALSE);

		// Notes
		$this->Notes->SetDbValueDef($rsnew, $this->Notes->CurrentValue, "", FALSE);

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
				$this->Supplier_ID->setDbValue($conn->Insert_ID());
				$rsnew['Supplier_ID'] = $this->Supplier_ID->DbValue;
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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("a_purchases", $DetailTblVar) && $GLOBALS["a_purchases"]->DetailAdd) {
				$GLOBALS["a_purchases"]->Supplier_ID->setSessionValue($this->Supplier_Number->CurrentValue); // Set master key
				if (!isset($GLOBALS["a_purchases_grid"])) $GLOBALS["a_purchases_grid"] = new ca_purchases_grid(); // Get detail page object
				$AddRow = $GLOBALS["a_purchases_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["a_purchases"]->Supplier_ID->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("a_stock_items", $DetailTblVar) && $GLOBALS["a_stock_items"]->DetailAdd) {
				$GLOBALS["a_stock_items"]->Supplier_Number->setSessionValue($this->Supplier_Number->CurrentValue); // Set master key
				if (!isset($GLOBALS["a_stock_items_grid"])) $GLOBALS["a_stock_items_grid"] = new ca_stock_items_grid(); // Get detail page object
				$AddRow = $GLOBALS["a_stock_items_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["a_stock_items"]->Supplier_Number->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
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
				if ($GLOBALS["a_purchases_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["a_purchases_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["a_purchases_grid"]->CurrentMode = "add";
					$GLOBALS["a_purchases_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["a_stock_items_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["a_stock_items_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["a_stock_items_grid"]->CurrentMode = "add";
					$GLOBALS["a_stock_items_grid"]->CurrentAction = "gridadd";

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
if (!isset($a_suppliers_add)) $a_suppliers_add = new ca_suppliers_add();

// Page init
$a_suppliers_add->Page_Init();

// Page main
$a_suppliers_add->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_suppliers_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fa_suppliersadd = new ew_Form("fa_suppliersadd", "add");

// Validate form
fa_suppliersadd.Validate = function() {
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
fa_suppliersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_suppliersadd.ValidateRequired = true;
<?php } else { ?>
fa_suppliersadd.ValidateRequired = false; 
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
<?php $a_suppliers_add->ShowPageHeader(); ?>
<?php
$a_suppliers_add->ShowMessage();
?>
<form name="fa_suppliersadd" id="fa_suppliersadd" class="<?php echo $a_suppliers_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_suppliers_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_suppliers_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_suppliers">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
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
<span id="el_a_suppliers_Date_Added">
<input type="hidden" data-table="a_suppliers" data-field="x_Date_Added" name="x_Date_Added" id="x_Date_Added" value="<?php echo ew_HtmlEncode($a_suppliers->Date_Added->CurrentValue) ?>">
</span>
<span id="el_a_suppliers_Added_By">
<input type="hidden" data-table="a_suppliers" data-field="x_Added_By" name="x_Added_By" id="x_Added_By" value="<?php echo ew_HtmlEncode($a_suppliers->Added_By->CurrentValue) ?>">
</span>
</div>
<?php
	if (in_array("a_purchases", explode(",", $a_suppliers->getCurrentDetailTable())) && $a_purchases->DetailAdd) {
?>
<?php if ($a_suppliers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("a_purchases", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "a_purchasesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("a_stock_items", explode(",", $a_suppliers->getCurrentDetailTable())) && $a_stock_items->DetailAdd) {
?>
<?php if ($a_suppliers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("a_stock_items", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "a_stock_itemsgrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $a_suppliers_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fa_suppliersadd.Init();
</script>
<?php
$a_suppliers_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_suppliersadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($a_suppliers->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyAdd(this)'); function alertifyAdd(obj) { <?php global $Language; ?> if (fa_suppliersadd.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyAddConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyAdd'); ?>"); $("#fa_suppliersadd").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_suppliers_add->Page_Terminate();
?>
