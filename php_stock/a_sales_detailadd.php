<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "a_sales_detailinfo.php" ?>
<?php include_once "a_salesinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$a_sales_detail_add = NULL; // Initialize page object first

class ca_sales_detail_add extends ca_sales_detail {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_sales_detail';

	// Page object name
	var $PageObjName = 'a_sales_detail_add';

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

		// Table object (a_sales_detail)
		if (!isset($GLOBALS["a_sales_detail"]) || get_class($GLOBALS["a_sales_detail"]) == "ca_sales_detail") {
			$GLOBALS["a_sales_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["a_sales_detail"];
		}

		// Table object (a_sales)
		if (!isset($GLOBALS['a_sales'])) $GLOBALS['a_sales'] = new ca_sales();

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'a_sales_detail', TRUE);

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
		if (!isset($_SESSION['table_a_sales_detail_views'])) { 
			$_SESSION['table_a_sales_detail_views'] = 0;
		}
		$_SESSION['table_a_sales_detail_views'] = $_SESSION['table_a_sales_detail_views']+1;

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
				$this->Page_Terminate(ew_GetUrl("a_sales_detaillist.php"));
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
		global $EW_EXPORT, $a_sales_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($a_sales_detail);
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
			if (@$_GET["Sales_ID"] != "") {
				$this->Sales_ID->setQueryStringValue($_GET["Sales_ID"]);
				$this->setKey("Sales_ID", $this->Sales_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("Sales_ID", ""); // Clear key
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
					$this->Page_Terminate("a_sales_detaillist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "a_sales_detaillist.php")
						$sReturnUrl = $this->AddMasterUrl($this->GetListUrl()); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "a_sales_detailview.php")
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
		$this->Sales_Number->CurrentValue = NULL;
		$this->Sales_Number->OldValue = $this->Sales_Number->CurrentValue;
		$this->Supplier_Number->CurrentValue = NULL;
		$this->Supplier_Number->OldValue = $this->Supplier_Number->CurrentValue;
		$this->Stock_Item->CurrentValue = NULL;
		$this->Stock_Item->OldValue = $this->Stock_Item->CurrentValue;
		$this->Sales_Quantity->CurrentValue = 0;
		$this->Purchasing_Price->CurrentValue = 0;
		$this->Sales_Price->CurrentValue = 0;
		$this->Sales_Total_Amount->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Sales_Number->FldIsDetailKey) {
			$this->Sales_Number->setFormValue($objForm->GetValue("x_Sales_Number"));
		}
		if (!$this->Supplier_Number->FldIsDetailKey) {
			$this->Supplier_Number->setFormValue($objForm->GetValue("x_Supplier_Number"));
		}
		if (!$this->Stock_Item->FldIsDetailKey) {
			$this->Stock_Item->setFormValue($objForm->GetValue("x_Stock_Item"));
		}
		if (!$this->Sales_Quantity->FldIsDetailKey) {
			$this->Sales_Quantity->setFormValue($objForm->GetValue("x_Sales_Quantity"));
		}
		if (!$this->Purchasing_Price->FldIsDetailKey) {
			$this->Purchasing_Price->setFormValue($objForm->GetValue("x_Purchasing_Price"));
		}
		if (!$this->Sales_Price->FldIsDetailKey) {
			$this->Sales_Price->setFormValue($objForm->GetValue("x_Sales_Price"));
		}
		if (!$this->Sales_Total_Amount->FldIsDetailKey) {
			$this->Sales_Total_Amount->setFormValue($objForm->GetValue("x_Sales_Total_Amount"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Sales_Number->CurrentValue = $this->Sales_Number->FormValue;
		$this->Supplier_Number->CurrentValue = $this->Supplier_Number->FormValue;
		$this->Stock_Item->CurrentValue = $this->Stock_Item->FormValue;
		$this->Sales_Quantity->CurrentValue = $this->Sales_Quantity->FormValue;
		$this->Purchasing_Price->CurrentValue = $this->Purchasing_Price->FormValue;
		$this->Sales_Price->CurrentValue = $this->Sales_Price->FormValue;
		$this->Sales_Total_Amount->CurrentValue = $this->Sales_Total_Amount->FormValue;
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
		$this->Sales_ID->setDbValue($rs->fields('Sales_ID'));
		$this->Sales_Number->setDbValue($rs->fields('Sales_Number'));
		$this->Supplier_Number->setDbValue($rs->fields('Supplier_Number'));
		$this->Stock_Item->setDbValue($rs->fields('Stock_Item'));
		$this->Sales_Quantity->setDbValue($rs->fields('Sales_Quantity'));
		$this->Purchasing_Price->setDbValue($rs->fields('Purchasing_Price'));
		$this->Sales_Price->setDbValue($rs->fields('Sales_Price'));
		$this->Sales_Total_Amount->setDbValue($rs->fields('Sales_Total_Amount'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Sales_ID->DbValue = $row['Sales_ID'];
		$this->Sales_Number->DbValue = $row['Sales_Number'];
		$this->Supplier_Number->DbValue = $row['Supplier_Number'];
		$this->Stock_Item->DbValue = $row['Stock_Item'];
		$this->Sales_Quantity->DbValue = $row['Sales_Quantity'];
		$this->Purchasing_Price->DbValue = $row['Purchasing_Price'];
		$this->Sales_Price->DbValue = $row['Sales_Price'];
		$this->Sales_Total_Amount->DbValue = $row['Sales_Total_Amount'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Sales_ID")) <> "")
			$this->Sales_ID->CurrentValue = $this->getKey("Sales_ID"); // Sales_ID
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

		if ($this->Sales_Quantity->FormValue == $this->Sales_Quantity->CurrentValue && is_numeric(ew_StrToFloat($this->Sales_Quantity->CurrentValue)))
			$this->Sales_Quantity->CurrentValue = ew_StrToFloat($this->Sales_Quantity->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Purchasing_Price->FormValue == $this->Purchasing_Price->CurrentValue && is_numeric(ew_StrToFloat($this->Purchasing_Price->CurrentValue)))
			$this->Purchasing_Price->CurrentValue = ew_StrToFloat($this->Purchasing_Price->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Sales_Price->FormValue == $this->Sales_Price->CurrentValue && is_numeric(ew_StrToFloat($this->Sales_Price->CurrentValue)))
			$this->Sales_Price->CurrentValue = ew_StrToFloat($this->Sales_Price->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Sales_Total_Amount->FormValue == $this->Sales_Total_Amount->CurrentValue && is_numeric(ew_StrToFloat($this->Sales_Total_Amount->CurrentValue)))
			$this->Sales_Total_Amount->CurrentValue = ew_StrToFloat($this->Sales_Total_Amount->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Sales_ID
		// Sales_Number
		// Supplier_Number
		// Stock_Item
		// Sales_Quantity
		// Purchasing_Price
		// Sales_Price
		// Sales_Total_Amount

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Sales_Number
		$this->Sales_Number->ViewValue = $this->Sales_Number->CurrentValue;
		$this->Sales_Number->ViewCustomAttributes = "";

		// Supplier_Number
		if (strval($this->Supplier_Number->CurrentValue) <> "") {
			$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier_Number->CurrentValue, EW_DATATYPE_STRING, "");
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
		$lookuptblfilter = "`Is_Stock_Available` = 'Y'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Supplier_ID`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Supplier_Number->ViewValue = $this->Supplier_Number->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Supplier_Number->ViewValue = $this->Supplier_Number->CurrentValue;
			}
		} else {
			$this->Supplier_Number->ViewValue = NULL;
		}
		$this->Supplier_Number->ViewCustomAttributes = "";

		// Stock_Item
		if (strval($this->Stock_Item->CurrentValue) <> "") {
			$sFilterWrk = "`Stock_Number`" . ew_SearchString("=", $this->Stock_Item->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
				$sWhereWrk = "";
				break;
		}
		$lookuptblfilter = "`Quantity` > 0";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Stock_Item, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Stock_Item->ViewValue = $this->Stock_Item->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Stock_Item->ViewValue = $this->Stock_Item->CurrentValue;
			}
		} else {
			$this->Stock_Item->ViewValue = NULL;
		}
		$this->Stock_Item->ViewCustomAttributes = "";

		// Sales_Quantity
		$this->Sales_Quantity->ViewValue = $this->Sales_Quantity->CurrentValue;
		$this->Sales_Quantity->ViewValue = ew_FormatNumber($this->Sales_Quantity->ViewValue, 0, -2, -2, -2);
		$this->Sales_Quantity->CellCssStyle .= "text-align: right;";
		$this->Sales_Quantity->ViewCustomAttributes = "";

		// Purchasing_Price
		$this->Purchasing_Price->ViewValue = $this->Purchasing_Price->CurrentValue;
		$this->Purchasing_Price->ViewValue = ew_FormatCurrency($this->Purchasing_Price->ViewValue, 2, -2, -2, -2);
		$this->Purchasing_Price->CellCssStyle .= "text-align: right;";
		$this->Purchasing_Price->ViewCustomAttributes = "";

		// Sales_Price
		$this->Sales_Price->ViewValue = $this->Sales_Price->CurrentValue;
		$this->Sales_Price->ViewValue = ew_FormatCurrency($this->Sales_Price->ViewValue, 2, -2, -2, -2);
		$this->Sales_Price->CellCssStyle .= "text-align: right;";
		$this->Sales_Price->ViewCustomAttributes = "";

		// Sales_Total_Amount
		$this->Sales_Total_Amount->ViewValue = $this->Sales_Total_Amount->CurrentValue;
		$this->Sales_Total_Amount->ViewValue = ew_FormatCurrency($this->Sales_Total_Amount->ViewValue, 2, -2, -2, -2);
		$this->Sales_Total_Amount->CellCssStyle .= "text-align: right;";
		$this->Sales_Total_Amount->ViewCustomAttributes = "";

			// Sales_Number
			$this->Sales_Number->LinkCustomAttributes = "";
			$this->Sales_Number->HrefValue = "";
			$this->Sales_Number->TooltipValue = "";

			// Supplier_Number
			$this->Supplier_Number->LinkCustomAttributes = "";
			$this->Supplier_Number->HrefValue = "";
			$this->Supplier_Number->TooltipValue = "";

			// Stock_Item
			$this->Stock_Item->LinkCustomAttributes = "";
			$this->Stock_Item->HrefValue = "";
			$this->Stock_Item->TooltipValue = "";

			// Sales_Quantity
			$this->Sales_Quantity->LinkCustomAttributes = "";
			$this->Sales_Quantity->HrefValue = "";
			$this->Sales_Quantity->TooltipValue = "";

			// Purchasing_Price
			$this->Purchasing_Price->LinkCustomAttributes = "";
			$this->Purchasing_Price->HrefValue = "";
			$this->Purchasing_Price->TooltipValue = "";

			// Sales_Price
			$this->Sales_Price->LinkCustomAttributes = "";
			$this->Sales_Price->HrefValue = "";
			$this->Sales_Price->TooltipValue = "";

			// Sales_Total_Amount
			$this->Sales_Total_Amount->LinkCustomAttributes = "";
			$this->Sales_Total_Amount->HrefValue = "";
			$this->Sales_Total_Amount->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Sales_Number
			$this->Sales_Number->EditAttrs["class"] = "form-control";
			$this->Sales_Number->EditCustomAttributes = "";
			if ($this->Sales_Number->getSessionValue() <> "") {
				$this->Sales_Number->CurrentValue = $this->Sales_Number->getSessionValue();
			$this->Sales_Number->ViewValue = $this->Sales_Number->CurrentValue;
			$this->Sales_Number->ViewCustomAttributes = "";
			} else {
			$this->Sales_Number->EditValue = ew_HtmlEncode($this->Sales_Number->CurrentValue);
			$this->Sales_Number->PlaceHolder = ew_RemoveHtml($this->Sales_Number->FldCaption());
			}

			// Supplier_Number
			$this->Supplier_Number->EditAttrs["class"] = "form-control";
			$this->Supplier_Number->EditCustomAttributes = "";
			if (trim(strval($this->Supplier_Number->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier_Number->CurrentValue, EW_DATATYPE_STRING, "");
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
			$lookuptblfilter = "`Is_Stock_Available` = 'Y'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Supplier_ID`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Supplier_Number->EditValue = $arwrk;

			// Stock_Item
			$this->Stock_Item->EditAttrs["class"] = "form-control";
			$this->Stock_Item->EditCustomAttributes = "";
			if (trim(strval($this->Stock_Item->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Stock_Number`" . ew_SearchString("=", $this->Stock_Item->CurrentValue, EW_DATATYPE_STRING, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Supplier_Number` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_stock_items`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `Supplier_Number` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_stock_items`";
					$sWhereWrk = "";
					break;
			}
			$lookuptblfilter = "`Quantity` > 0";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Stock_Item, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Stock_Item->EditValue = $arwrk;

			// Sales_Quantity
			$this->Sales_Quantity->EditAttrs["class"] = "form-control";
			$this->Sales_Quantity->EditCustomAttributes = "";
			$this->Sales_Quantity->EditValue = ew_HtmlEncode($this->Sales_Quantity->CurrentValue);
			$this->Sales_Quantity->PlaceHolder = ew_RemoveHtml($this->Sales_Quantity->FldCaption());
			if (strval($this->Sales_Quantity->EditValue) <> "" && is_numeric($this->Sales_Quantity->EditValue)) $this->Sales_Quantity->EditValue = ew_FormatNumber($this->Sales_Quantity->EditValue, -2, -2, -2, -2);

			// Purchasing_Price
			$this->Purchasing_Price->EditAttrs["class"] = "form-control";
			$this->Purchasing_Price->EditCustomAttributes = "";
			$this->Purchasing_Price->EditValue = ew_HtmlEncode($this->Purchasing_Price->CurrentValue);
			$this->Purchasing_Price->PlaceHolder = ew_RemoveHtml($this->Purchasing_Price->FldCaption());
			if (strval($this->Purchasing_Price->EditValue) <> "" && is_numeric($this->Purchasing_Price->EditValue)) $this->Purchasing_Price->EditValue = ew_FormatNumber($this->Purchasing_Price->EditValue, -2, -2, -2, -2);

			// Sales_Price
			$this->Sales_Price->EditAttrs["class"] = "form-control";
			$this->Sales_Price->EditCustomAttributes = "";
			$this->Sales_Price->EditValue = ew_HtmlEncode($this->Sales_Price->CurrentValue);
			$this->Sales_Price->PlaceHolder = ew_RemoveHtml($this->Sales_Price->FldCaption());
			if (strval($this->Sales_Price->EditValue) <> "" && is_numeric($this->Sales_Price->EditValue)) $this->Sales_Price->EditValue = ew_FormatNumber($this->Sales_Price->EditValue, -2, -2, -2, -2);

			// Sales_Total_Amount
			$this->Sales_Total_Amount->EditAttrs["class"] = "form-control";
			$this->Sales_Total_Amount->EditCustomAttributes = "";
			$this->Sales_Total_Amount->EditValue = ew_HtmlEncode($this->Sales_Total_Amount->CurrentValue);
			$this->Sales_Total_Amount->PlaceHolder = ew_RemoveHtml($this->Sales_Total_Amount->FldCaption());
			if (strval($this->Sales_Total_Amount->EditValue) <> "" && is_numeric($this->Sales_Total_Amount->EditValue)) $this->Sales_Total_Amount->EditValue = ew_FormatNumber($this->Sales_Total_Amount->EditValue, -2, -2, -2, -2);

			// Add refer script
			// Sales_Number

			$this->Sales_Number->LinkCustomAttributes = "";
			$this->Sales_Number->HrefValue = "";

			// Supplier_Number
			$this->Supplier_Number->LinkCustomAttributes = "";
			$this->Supplier_Number->HrefValue = "";

			// Stock_Item
			$this->Stock_Item->LinkCustomAttributes = "";
			$this->Stock_Item->HrefValue = "";

			// Sales_Quantity
			$this->Sales_Quantity->LinkCustomAttributes = "";
			$this->Sales_Quantity->HrefValue = "";

			// Purchasing_Price
			$this->Purchasing_Price->LinkCustomAttributes = "";
			$this->Purchasing_Price->HrefValue = "";

			// Sales_Price
			$this->Sales_Price->LinkCustomAttributes = "";
			$this->Sales_Price->HrefValue = "";

			// Sales_Total_Amount
			$this->Sales_Total_Amount->LinkCustomAttributes = "";
			$this->Sales_Total_Amount->HrefValue = "";
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
		if (!$this->Sales_Number->FldIsDetailKey && !is_null($this->Sales_Number->FormValue) && $this->Sales_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Sales_Number->FldCaption(), $this->Sales_Number->ReqErrMsg));
		}
		if (!$this->Supplier_Number->FldIsDetailKey && !is_null($this->Supplier_Number->FormValue) && $this->Supplier_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Supplier_Number->FldCaption(), $this->Supplier_Number->ReqErrMsg));
		}
		if (!$this->Stock_Item->FldIsDetailKey && !is_null($this->Stock_Item->FormValue) && $this->Stock_Item->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Stock_Item->FldCaption(), $this->Stock_Item->ReqErrMsg));
		}
		if (!$this->Sales_Quantity->FldIsDetailKey && !is_null($this->Sales_Quantity->FormValue) && $this->Sales_Quantity->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Sales_Quantity->FldCaption(), $this->Sales_Quantity->ReqErrMsg));
		}
		if (!$this->Purchasing_Price->FldIsDetailKey && !is_null($this->Purchasing_Price->FormValue) && $this->Purchasing_Price->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Purchasing_Price->FldCaption(), $this->Purchasing_Price->ReqErrMsg));
		}
		if (!$this->Sales_Price->FldIsDetailKey && !is_null($this->Sales_Price->FormValue) && $this->Sales_Price->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Sales_Price->FldCaption(), $this->Sales_Price->ReqErrMsg));
		}
		if (!$this->Sales_Total_Amount->FldIsDetailKey && !is_null($this->Sales_Total_Amount->FormValue) && $this->Sales_Total_Amount->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Sales_Total_Amount->FldCaption(), $this->Sales_Total_Amount->ReqErrMsg));
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

		// Check referential integrity for master table 'a_sales'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_a_sales();
		if (strval($this->Sales_Number->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@Sales_Number@", ew_AdjustSql($this->Sales_Number->CurrentValue, "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["a_sales"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "a_sales", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Sales_Number
		$this->Sales_Number->SetDbValueDef($rsnew, $this->Sales_Number->CurrentValue, "", FALSE);

		// Supplier_Number
		$this->Supplier_Number->SetDbValueDef($rsnew, $this->Supplier_Number->CurrentValue, "", FALSE);

		// Stock_Item
		$this->Stock_Item->SetDbValueDef($rsnew, $this->Stock_Item->CurrentValue, "", FALSE);

		// Sales_Quantity
		$this->Sales_Quantity->SetDbValueDef($rsnew, $this->Sales_Quantity->CurrentValue, 0, strval($this->Sales_Quantity->CurrentValue) == "");

		// Purchasing_Price
		$this->Purchasing_Price->SetDbValueDef($rsnew, $this->Purchasing_Price->CurrentValue, 0, strval($this->Purchasing_Price->CurrentValue) == "");

		// Sales_Price
		$this->Sales_Price->SetDbValueDef($rsnew, $this->Sales_Price->CurrentValue, 0, strval($this->Sales_Price->CurrentValue) == "");

		// Sales_Total_Amount
		$this->Sales_Total_Amount->SetDbValueDef($rsnew, $this->Sales_Total_Amount->CurrentValue, 0, strval($this->Sales_Total_Amount->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->Sales_ID->setDbValue($conn->Insert_ID());
				$rsnew['Sales_ID'] = $this->Sales_ID->DbValue;
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
			if ($sMasterTblVar == "a_sales") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Sales_Number"] <> "") {
					$GLOBALS["a_sales"]->Sales_Number->setQueryStringValue($_GET["fk_Sales_Number"]);
					$this->Sales_Number->setQueryStringValue($GLOBALS["a_sales"]->Sales_Number->QueryStringValue);
					$this->Sales_Number->setSessionValue($this->Sales_Number->QueryStringValue);
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
			if ($sMasterTblVar == "a_sales") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Sales_Number"] <> "") {
					$GLOBALS["a_sales"]->Sales_Number->setFormValue($_POST["fk_Sales_Number"]);
					$this->Sales_Number->setFormValue($GLOBALS["a_sales"]->Sales_Number->FormValue);
					$this->Sales_Number->setSessionValue($this->Sales_Number->FormValue);
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
			if ($sMasterTblVar <> "a_sales") {
				if ($this->Sales_Number->CurrentValue == "") $this->Sales_Number->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_sales_detaillist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url); // v11.0.4
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
		if (isset($_GET["fk_Sales_Number"])) {
			$_SESSION["Detail_Sales_Number"] = $_GET["fk_Sales_Number"];
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
if (!isset($a_sales_detail_add)) $a_sales_detail_add = new ca_sales_detail_add();

// Page init
$a_sales_detail_add->Page_Init();

// Page main
$a_sales_detail_add->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_sales_detail_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fa_sales_detailadd = new ew_Form("fa_sales_detailadd", "add");

// Validate form
fa_sales_detailadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Sales_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Sales_Number->FldCaption(), $a_sales_detail->Sales_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Supplier_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Supplier_Number->FldCaption(), $a_sales_detail->Supplier_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Stock_Item");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Stock_Item->FldCaption(), $a_sales_detail->Stock_Item->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Quantity");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Sales_Quantity->FldCaption(), $a_sales_detail->Sales_Quantity->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Purchasing_Price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Purchasing_Price->FldCaption(), $a_sales_detail->Purchasing_Price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Sales_Price->FldCaption(), $a_sales_detail->Sales_Price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Total_Amount");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales_detail->Sales_Total_Amount->FldCaption(), $a_sales_detail->Sales_Total_Amount->ReqErrMsg)) ?>");

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
fa_sales_detailadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_sales_detailadd.ValidateRequired = true;
<?php } else { ?>
fa_sales_detailadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_sales_detailadd.Lists["x_Supplier_Number"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":["x_Stock_Item"],"FilterFields":[],"Options":[],"Template":""};
fa_sales_detailadd.Lists["x_Stock_Item"] = {"LinkField":"x_Stock_Number","Ajax":true,"AutoFill":true,"DisplayFields":["x_Stock_Name","","",""],"ParentFields":["x_Supplier_Number"],"ChildFields":[],"FilterFields":["x_Supplier_Number"],"Options":[],"Template":""};

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
<?php $a_sales_detail_add->ShowPageHeader(); ?>
<?php
$a_sales_detail_add->ShowMessage();
?>
<form name="fa_sales_detailadd" id="fa_sales_detailadd" class="<?php echo $a_sales_detail_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_sales_detail_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_sales_detail_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_sales_detail">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($a_sales_detail->getCurrentMasterTable() == "a_sales") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="a_sales">
<input type="hidden" name="fk_Sales_Number" value="<?php echo $a_sales_detail->Sales_Number->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($a_sales_detail->Sales_Number->Visible) { // Sales_Number ?>
	<div id="r_Sales_Number" class="form-group">
		<label id="elh_a_sales_detail_Sales_Number" for="x_Sales_Number" class="col-sm-4 control-label ewLabel"><?php echo $a_sales_detail->Sales_Number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales_detail->Sales_Number->CellAttributes() ?>>
<?php if ($a_sales_detail->Sales_Number->getSessionValue() <> "") { ?>
<span id="el_a_sales_detail_Sales_Number">
<span<?php echo $a_sales_detail->Sales_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales_detail->Sales_Number->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_Sales_Number" name="x_Sales_Number" value="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Number->CurrentValue) ?>">
<?php } else { ?>
<span id="el_a_sales_detail_Sales_Number">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Number" name="x_Sales_Number" id="x_Sales_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Number->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Number->EditValue ?>"<?php echo $a_sales_detail->Sales_Number->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $a_sales_detail->Sales_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales_detail->Supplier_Number->Visible) { // Supplier_Number ?>
	<div id="r_Supplier_Number" class="form-group">
		<label id="elh_a_sales_detail_Supplier_Number" for="x_Supplier_Number" class="col-sm-4 control-label ewLabel"><?php echo $a_sales_detail->Supplier_Number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales_detail->Supplier_Number->CellAttributes() ?>>
<span id="el_a_sales_detail_Supplier_Number">
<?php $a_sales_detail->Supplier_Number->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$a_sales_detail->Supplier_Number->EditAttrs["onchange"]; ?>
<select data-table="a_sales_detail" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales_detail->Supplier_Number->DisplayValueSeparator) ? json_encode($a_sales_detail->Supplier_Number->DisplayValueSeparator) : $a_sales_detail->Supplier_Number->DisplayValueSeparator) ?>" id="x_Supplier_Number" name="x_Supplier_Number"<?php echo $a_sales_detail->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_sales_detail->Supplier_Number->EditValue)) {
	$arwrk = $a_sales_detail->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales_detail->Supplier_Number->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales_detail->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales_detail->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales_detail->Supplier_Number->CurrentValue) ?>" selected><?php echo $a_sales_detail->Supplier_Number->CurrentValue ?></option>
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
$lookuptblfilter = "`Is_Stock_Available` = 'Y'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_sales_detail->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales_detail->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_sales_detail->Lookup_Selecting($a_sales_detail->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Supplier_ID`";
if ($sSqlWrk <> "") $a_sales_detail->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Supplier_Number" id="s_x_Supplier_Number" value="<?php echo $a_sales_detail->Supplier_Number->LookupFilterQuery() ?>">
</span>
<?php echo $a_sales_detail->Supplier_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales_detail->Stock_Item->Visible) { // Stock_Item ?>
	<div id="r_Stock_Item" class="form-group">
		<label id="elh_a_sales_detail_Stock_Item" for="x_Stock_Item" class="col-sm-4 control-label ewLabel"><?php echo $a_sales_detail->Stock_Item->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales_detail->Stock_Item->CellAttributes() ?>>
<span id="el_a_sales_detail_Stock_Item">
<?php $a_sales_detail->Stock_Item->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$a_sales_detail->Stock_Item->EditAttrs["onchange"]; ?>
<select data-table="a_sales_detail" data-field="x_Stock_Item" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales_detail->Stock_Item->DisplayValueSeparator) ? json_encode($a_sales_detail->Stock_Item->DisplayValueSeparator) : $a_sales_detail->Stock_Item->DisplayValueSeparator) ?>" id="x_Stock_Item" name="x_Stock_Item"<?php echo $a_sales_detail->Stock_Item->EditAttributes() ?>>
<?php
if (is_array($a_sales_detail->Stock_Item->EditValue)) {
	$arwrk = $a_sales_detail->Stock_Item->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales_detail->Stock_Item->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales_detail->Stock_Item->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales_detail->Stock_Item->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales_detail->Stock_Item->CurrentValue) ?>" selected><?php echo $a_sales_detail->Stock_Item->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
		$sWhereWrk = "{filter}";
		break;
	default:
		$sSqlWrk = "SELECT `Stock_Number`, `Stock_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_items`";
		$sWhereWrk = "{filter}";
		break;
}
$lookuptblfilter = "`Quantity` > 0";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$a_sales_detail->Stock_Item->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales_detail->Stock_Item->LookupFilters += array("f0" => "`Stock_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$a_sales_detail->Stock_Item->LookupFilters += array("f1" => "`Supplier_Number` IN ({filter_value})", "t1" => "200", "fn1" => "");
$sSqlWrk = "";
$a_sales_detail->Lookup_Selecting($a_sales_detail->Stock_Item, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_sales_detail->Stock_Item->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Stock_Item" id="s_x_Stock_Item" value="<?php echo $a_sales_detail->Stock_Item->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_Stock_Item" id="ln_x_Stock_Item" value="x_Purchasing_Price,x_Sales_Price">
</span>
<?php echo $a_sales_detail->Stock_Item->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales_detail->Sales_Quantity->Visible) { // Sales_Quantity ?>
	<div id="r_Sales_Quantity" class="form-group">
		<label id="elh_a_sales_detail_Sales_Quantity" for="x_Sales_Quantity" class="col-sm-4 control-label ewLabel"><?php echo $a_sales_detail->Sales_Quantity->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales_detail->Sales_Quantity->CellAttributes() ?>>
<span id="el_a_sales_detail_Sales_Quantity">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Quantity" name="x_Sales_Quantity" id="x_Sales_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Quantity->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Quantity->EditValue ?>"<?php echo $a_sales_detail->Sales_Quantity->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Quantity->ReadOnly && !$a_sales_detail->Sales_Quantity->Disabled && @$a_sales_detail->Sales_Quantity->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Sales_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales_detail->Sales_Quantity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales_detail->Purchasing_Price->Visible) { // Purchasing_Price ?>
	<div id="r_Purchasing_Price" class="form-group">
		<label id="elh_a_sales_detail_Purchasing_Price" for="x_Purchasing_Price" class="col-sm-4 control-label ewLabel"><?php echo $a_sales_detail->Purchasing_Price->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales_detail->Purchasing_Price->CellAttributes() ?>>
<span id="el_a_sales_detail_Purchasing_Price">
<input type="text" data-table="a_sales_detail" data-field="x_Purchasing_Price" name="x_Purchasing_Price" id="x_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Purchasing_Price->EditValue ?>"<?php echo $a_sales_detail->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_sales_detail->Purchasing_Price->ReadOnly && !$a_sales_detail->Purchasing_Price->Disabled && @$a_sales_detail->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_sales_detail->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales_detail->Purchasing_Price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales_detail->Sales_Price->Visible) { // Sales_Price ?>
	<div id="r_Sales_Price" class="form-group">
		<label id="elh_a_sales_detail_Sales_Price" for="x_Sales_Price" class="col-sm-4 control-label ewLabel"><?php echo $a_sales_detail->Sales_Price->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales_detail->Sales_Price->CellAttributes() ?>>
<span id="el_a_sales_detail_Sales_Price">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Price" name="x_Sales_Price" id="x_Sales_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Price->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Price->EditValue ?>"<?php echo $a_sales_detail->Sales_Price->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Price->ReadOnly && !$a_sales_detail->Sales_Price->Disabled && @$a_sales_detail->Sales_Price->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Sales_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales_detail->Sales_Price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales_detail->Sales_Total_Amount->Visible) { // Sales_Total_Amount ?>
	<div id="r_Sales_Total_Amount" class="form-group">
		<label id="elh_a_sales_detail_Sales_Total_Amount" for="x_Sales_Total_Amount" class="col-sm-4 control-label ewLabel"><?php echo $a_sales_detail->Sales_Total_Amount->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales_detail->Sales_Total_Amount->CellAttributes() ?>>
<span id="el_a_sales_detail_Sales_Total_Amount">
<input type="text" data-table="a_sales_detail" data-field="x_Sales_Total_Amount" name="x_Sales_Total_Amount" id="x_Sales_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales_detail->Sales_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales_detail->Sales_Total_Amount->EditValue ?>"<?php echo $a_sales_detail->Sales_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales_detail->Sales_Total_Amount->ReadOnly && !$a_sales_detail->Sales_Total_Amount->Disabled && @$a_sales_detail->Sales_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales_detail->Sales_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Sales_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales_detail->Sales_Total_Amount->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $a_sales_detail_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fa_sales_detailadd.Init();
</script>
<?php
$a_sales_detail_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

function CalculateSingleSales() {
	$("#x_Sales_Total_Amount").val($("#x_Sales_Quantity").autoNumeric('get') *
	$("#x_Sales_Price").autoNumeric('get')); 
}
</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_sales_detailadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($a_sales_detail->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyAdd(this)'); function alertifyAdd(obj) { <?php global $Language; ?> if (fa_sales_detailadd.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyAddConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyAdd'); ?>"); $("#fa_sales_detailadd").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_sales_detail_add->Page_Terminate();
?>
