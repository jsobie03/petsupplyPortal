<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "a_salesinfo.php" ?>
<?php include_once "a_customersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "a_sales_detailgridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$a_sales_add = NULL; // Initialize page object first

class ca_sales_add extends ca_sales {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_sales';

	// Page object name
	var $PageObjName = 'a_sales_add';

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

		// Table object (a_sales)
		if (!isset($GLOBALS["a_sales"]) || get_class($GLOBALS["a_sales"]) == "ca_sales") {
			$GLOBALS["a_sales"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["a_sales"];
		}

		// Table object (a_customers)
		if (!isset($GLOBALS['a_customers'])) $GLOBALS['a_customers'] = new ca_customers();

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'a_sales', TRUE);

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
		if (!isset($_SESSION['table_a_sales_views'])) { 
			$_SESSION['table_a_sales_views'] = 0;
		}
		$_SESSION['table_a_sales_views'] = $_SESSION['table_a_sales_views']+1;

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
				$this->Page_Terminate(ew_GetUrl("a_saleslist.php"));
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

			// Process auto fill for detail table 'a_sales_detail'
			if (@$_POST["grid"] == "fa_sales_detailgrid") {
				if (!isset($GLOBALS["a_sales_detail_grid"])) $GLOBALS["a_sales_detail_grid"] = new ca_sales_detail_grid;
				$GLOBALS["a_sales_detail_grid"]->Page_Init();
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
		global $EW_EXPORT, $a_sales;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($a_sales);
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
					$this->Page_Terminate("a_saleslist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "a_saleslist.php")
						$sReturnUrl = $this->AddMasterUrl($this->GetListUrl()); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "a_salesview.php")
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
		$this->Sales_Number->CurrentValue = NULL;
		$this->Sales_Number->OldValue = $this->Sales_Number->CurrentValue;
		$this->Sales_Date->CurrentValue = ew_CurrentDateTime();
		$this->Customer_ID->CurrentValue = NULL;
		$this->Customer_ID->OldValue = $this->Customer_ID->CurrentValue;
		$this->Notes->CurrentValue = NULL;
		$this->Notes->OldValue = $this->Notes->CurrentValue;
		$this->Total_Amount->CurrentValue = 0;
		$this->Discount_Type->CurrentValue = "P";
		$this->Discount_Percentage->CurrentValue = 0;
		$this->Discount_Amount->CurrentValue = 0;
		$this->Tax_Percentage->CurrentValue = 0;
		$this->Tax_Amount->CurrentValue = 0;
		$this->Tax_Description->CurrentValue = NULL;
		$this->Tax_Description->OldValue = $this->Tax_Description->CurrentValue;
		$this->Final_Total_Amount->CurrentValue = 0;
		$this->Total_Payment->CurrentValue = 0;
		$this->Total_Balance->CurrentValue = 0;
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
		if (!$this->Sales_Number->FldIsDetailKey) {
			$this->Sales_Number->setFormValue($objForm->GetValue("x_Sales_Number"));
		}
		if (!$this->Sales_Date->FldIsDetailKey) {
			$this->Sales_Date->setFormValue($objForm->GetValue("x_Sales_Date"));
			$this->Sales_Date->CurrentValue = ew_UnFormatDateTime($this->Sales_Date->CurrentValue, 9);
		}
		if (!$this->Customer_ID->FldIsDetailKey) {
			$this->Customer_ID->setFormValue($objForm->GetValue("x_Customer_ID"));
		}
		if (!$this->Notes->FldIsDetailKey) {
			$this->Notes->setFormValue($objForm->GetValue("x_Notes"));
		}
		if (!$this->Total_Amount->FldIsDetailKey) {
			$this->Total_Amount->setFormValue($objForm->GetValue("x_Total_Amount"));
		}
		if (!$this->Discount_Type->FldIsDetailKey) {
			$this->Discount_Type->setFormValue($objForm->GetValue("x_Discount_Type"));
		}
		if (!$this->Discount_Percentage->FldIsDetailKey) {
			$this->Discount_Percentage->setFormValue($objForm->GetValue("x_Discount_Percentage"));
		}
		if (!$this->Discount_Amount->FldIsDetailKey) {
			$this->Discount_Amount->setFormValue($objForm->GetValue("x_Discount_Amount"));
		}
		if (!$this->Tax_Percentage->FldIsDetailKey) {
			$this->Tax_Percentage->setFormValue($objForm->GetValue("x_Tax_Percentage"));
		}
		if (!$this->Tax_Amount->FldIsDetailKey) {
			$this->Tax_Amount->setFormValue($objForm->GetValue("x_Tax_Amount"));
		}
		if (!$this->Tax_Description->FldIsDetailKey) {
			$this->Tax_Description->setFormValue($objForm->GetValue("x_Tax_Description"));
		}
		if (!$this->Final_Total_Amount->FldIsDetailKey) {
			$this->Final_Total_Amount->setFormValue($objForm->GetValue("x_Final_Total_Amount"));
		}
		if (!$this->Total_Payment->FldIsDetailKey) {
			$this->Total_Payment->setFormValue($objForm->GetValue("x_Total_Payment"));
		}
		if (!$this->Total_Balance->FldIsDetailKey) {
			$this->Total_Balance->setFormValue($objForm->GetValue("x_Total_Balance"));
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
		$this->Sales_Number->CurrentValue = $this->Sales_Number->FormValue;
		$this->Sales_Date->CurrentValue = $this->Sales_Date->FormValue;
		$this->Sales_Date->CurrentValue = ew_UnFormatDateTime($this->Sales_Date->CurrentValue, 9);
		$this->Customer_ID->CurrentValue = $this->Customer_ID->FormValue;
		$this->Notes->CurrentValue = $this->Notes->FormValue;
		$this->Total_Amount->CurrentValue = $this->Total_Amount->FormValue;
		$this->Discount_Type->CurrentValue = $this->Discount_Type->FormValue;
		$this->Discount_Percentage->CurrentValue = $this->Discount_Percentage->FormValue;
		$this->Discount_Amount->CurrentValue = $this->Discount_Amount->FormValue;
		$this->Tax_Percentage->CurrentValue = $this->Tax_Percentage->FormValue;
		$this->Tax_Amount->CurrentValue = $this->Tax_Amount->FormValue;
		$this->Tax_Description->CurrentValue = $this->Tax_Description->FormValue;
		$this->Final_Total_Amount->CurrentValue = $this->Final_Total_Amount->FormValue;
		$this->Total_Payment->CurrentValue = $this->Total_Payment->FormValue;
		$this->Total_Balance->CurrentValue = $this->Total_Balance->FormValue;
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
		$this->Sales_ID->setDbValue($rs->fields('Sales_ID'));
		$this->Sales_Number->setDbValue($rs->fields('Sales_Number'));
		$this->Sales_Date->setDbValue($rs->fields('Sales_Date'));
		$this->Customer_ID->setDbValue($rs->fields('Customer_ID'));
		$this->Notes->setDbValue($rs->fields('Notes'));
		$this->Total_Amount->setDbValue($rs->fields('Total_Amount'));
		$this->Discount_Type->setDbValue($rs->fields('Discount_Type'));
		$this->Discount_Percentage->setDbValue($rs->fields('Discount_Percentage'));
		$this->Discount_Amount->setDbValue($rs->fields('Discount_Amount'));
		$this->Tax_Percentage->setDbValue($rs->fields('Tax_Percentage'));
		$this->Tax_Amount->setDbValue($rs->fields('Tax_Amount'));
		$this->Tax_Description->setDbValue($rs->fields('Tax_Description'));
		$this->Final_Total_Amount->setDbValue($rs->fields('Final_Total_Amount'));
		$this->Total_Payment->setDbValue($rs->fields('Total_Payment'));
		$this->Total_Balance->setDbValue($rs->fields('Total_Balance'));
		$this->Date_Added->setDbValue($rs->fields('Date_Added'));
		$this->Added_By->setDbValue($rs->fields('Added_By'));
		$this->Date_Updated->setDbValue($rs->fields('Date_Updated'));
		$this->Updated_By->setDbValue($rs->fields('Updated_By'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Sales_ID->DbValue = $row['Sales_ID'];
		$this->Sales_Number->DbValue = $row['Sales_Number'];
		$this->Sales_Date->DbValue = $row['Sales_Date'];
		$this->Customer_ID->DbValue = $row['Customer_ID'];
		$this->Notes->DbValue = $row['Notes'];
		$this->Total_Amount->DbValue = $row['Total_Amount'];
		$this->Discount_Type->DbValue = $row['Discount_Type'];
		$this->Discount_Percentage->DbValue = $row['Discount_Percentage'];
		$this->Discount_Amount->DbValue = $row['Discount_Amount'];
		$this->Tax_Percentage->DbValue = $row['Tax_Percentage'];
		$this->Tax_Amount->DbValue = $row['Tax_Amount'];
		$this->Tax_Description->DbValue = $row['Tax_Description'];
		$this->Final_Total_Amount->DbValue = $row['Final_Total_Amount'];
		$this->Total_Payment->DbValue = $row['Total_Payment'];
		$this->Total_Balance->DbValue = $row['Total_Balance'];
		$this->Date_Added->DbValue = $row['Date_Added'];
		$this->Added_By->DbValue = $row['Added_By'];
		$this->Date_Updated->DbValue = $row['Date_Updated'];
		$this->Updated_By->DbValue = $row['Updated_By'];
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

		if ($this->Total_Amount->FormValue == $this->Total_Amount->CurrentValue && is_numeric(ew_StrToFloat($this->Total_Amount->CurrentValue)))
			$this->Total_Amount->CurrentValue = ew_StrToFloat($this->Total_Amount->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Discount_Percentage->FormValue == $this->Discount_Percentage->CurrentValue && is_numeric(ew_StrToFloat($this->Discount_Percentage->CurrentValue)))
			$this->Discount_Percentage->CurrentValue = ew_StrToFloat($this->Discount_Percentage->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Discount_Amount->FormValue == $this->Discount_Amount->CurrentValue && is_numeric(ew_StrToFloat($this->Discount_Amount->CurrentValue)))
			$this->Discount_Amount->CurrentValue = ew_StrToFloat($this->Discount_Amount->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Tax_Percentage->FormValue == $this->Tax_Percentage->CurrentValue && is_numeric(ew_StrToFloat($this->Tax_Percentage->CurrentValue)))
			$this->Tax_Percentage->CurrentValue = ew_StrToFloat($this->Tax_Percentage->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Tax_Amount->FormValue == $this->Tax_Amount->CurrentValue && is_numeric(ew_StrToFloat($this->Tax_Amount->CurrentValue)))
			$this->Tax_Amount->CurrentValue = ew_StrToFloat($this->Tax_Amount->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Final_Total_Amount->FormValue == $this->Final_Total_Amount->CurrentValue && is_numeric(ew_StrToFloat($this->Final_Total_Amount->CurrentValue)))
			$this->Final_Total_Amount->CurrentValue = ew_StrToFloat($this->Final_Total_Amount->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Total_Payment->FormValue == $this->Total_Payment->CurrentValue && is_numeric(ew_StrToFloat($this->Total_Payment->CurrentValue)))
			$this->Total_Payment->CurrentValue = ew_StrToFloat($this->Total_Payment->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Total_Balance->FormValue == $this->Total_Balance->CurrentValue && is_numeric(ew_StrToFloat($this->Total_Balance->CurrentValue)))
			$this->Total_Balance->CurrentValue = ew_StrToFloat($this->Total_Balance->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Sales_ID
		// Sales_Number
		// Sales_Date
		// Customer_ID
		// Notes
		// Total_Amount
		// Discount_Type
		// Discount_Percentage
		// Discount_Amount
		// Tax_Percentage
		// Tax_Amount
		// Tax_Description
		// Final_Total_Amount
		// Total_Payment
		// Total_Balance
		// Date_Added
		// Added_By
		// Date_Updated
		// Updated_By

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Sales_Number
		$this->Sales_Number->ViewValue = $this->Sales_Number->CurrentValue;
		$this->Sales_Number->ViewCustomAttributes = "";

		// Sales_Date
		$this->Sales_Date->ViewValue = $this->Sales_Date->CurrentValue;
		$this->Sales_Date->ViewValue = ew_FormatDateTime($this->Sales_Date->ViewValue, 9);
		$this->Sales_Date->ViewCustomAttributes = "";

		// Customer_ID
		if (strval($this->Customer_ID->CurrentValue) <> "") {
			$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer_ID->CurrentValue, EW_DATATYPE_STRING, "");
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
		$this->Lookup_Selecting($this->Customer_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Customer_ID->ViewValue = $this->Customer_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Customer_ID->ViewValue = $this->Customer_ID->CurrentValue;
			}
		} else {
			$this->Customer_ID->ViewValue = NULL;
		}
		$this->Customer_ID->ViewCustomAttributes = "";

		// Notes
		$this->Notes->ViewValue = $this->Notes->CurrentValue;
		$this->Notes->ViewCustomAttributes = "";

		// Total_Amount
		$this->Total_Amount->ViewValue = $this->Total_Amount->CurrentValue;
		$this->Total_Amount->ViewValue = ew_FormatCurrency($this->Total_Amount->ViewValue, 2, -2, -2, -2);
		$this->Total_Amount->CellCssStyle .= "text-align: right;";
		$this->Total_Amount->ViewCustomAttributes = "";

		// Discount_Type
		if (strval($this->Discount_Type->CurrentValue) <> "") {
			$this->Discount_Type->ViewValue = $this->Discount_Type->OptionCaption($this->Discount_Type->CurrentValue);
		} else {
			$this->Discount_Type->ViewValue = NULL;
		}
		$this->Discount_Type->ViewCustomAttributes = "";

		// Discount_Percentage
		$this->Discount_Percentage->ViewValue = $this->Discount_Percentage->CurrentValue;
		$this->Discount_Percentage->ViewValue = ew_FormatNumber($this->Discount_Percentage->ViewValue, 0, -2, -2, -2);
		$this->Discount_Percentage->CellCssStyle .= "text-align: right;";
		$this->Discount_Percentage->ViewCustomAttributes = "";

		// Discount_Amount
		$this->Discount_Amount->ViewValue = $this->Discount_Amount->CurrentValue;
		$this->Discount_Amount->ViewValue = ew_FormatCurrency($this->Discount_Amount->ViewValue, 2, -2, -2, -2);
		$this->Discount_Amount->CellCssStyle .= "text-align: right;";
		$this->Discount_Amount->ViewCustomAttributes = "";

		// Tax_Percentage
		$this->Tax_Percentage->ViewValue = $this->Tax_Percentage->CurrentValue;
		$this->Tax_Percentage->ViewValue = ew_FormatNumber($this->Tax_Percentage->ViewValue, 0, -2, -2, -2);
		$this->Tax_Percentage->CellCssStyle .= "text-align: right;";
		$this->Tax_Percentage->ViewCustomAttributes = "";

		// Tax_Amount
		$this->Tax_Amount->ViewValue = $this->Tax_Amount->CurrentValue;
		$this->Tax_Amount->ViewValue = ew_FormatCurrency($this->Tax_Amount->ViewValue, 2, -2, -2, -2);
		$this->Tax_Amount->CellCssStyle .= "text-align: right;";
		$this->Tax_Amount->ViewCustomAttributes = "";

		// Tax_Description
		$this->Tax_Description->ViewValue = $this->Tax_Description->CurrentValue;
		$this->Tax_Description->ViewCustomAttributes = "";

		// Final_Total_Amount
		$this->Final_Total_Amount->ViewValue = $this->Final_Total_Amount->CurrentValue;
		$this->Final_Total_Amount->ViewValue = ew_FormatCurrency($this->Final_Total_Amount->ViewValue, 2, -2, -2, -2);
		$this->Final_Total_Amount->CellCssStyle .= "text-align: right;";
		$this->Final_Total_Amount->ViewCustomAttributes = "";

		// Total_Payment
		$this->Total_Payment->ViewValue = $this->Total_Payment->CurrentValue;
		$this->Total_Payment->ViewValue = ew_FormatCurrency($this->Total_Payment->ViewValue, 2, -2, -2, -2);
		$this->Total_Payment->CellCssStyle .= "text-align: right;";
		$this->Total_Payment->ViewCustomAttributes = "";

		// Total_Balance
		$this->Total_Balance->ViewValue = $this->Total_Balance->CurrentValue;
		$this->Total_Balance->ViewValue = ew_FormatCurrency($this->Total_Balance->ViewValue, 2, -2, -2, -2);
		$this->Total_Balance->CellCssStyle .= "text-align: right;";
		$this->Total_Balance->ViewCustomAttributes = "";

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

			// Sales_Number
			$this->Sales_Number->LinkCustomAttributes = "";
			$this->Sales_Number->HrefValue = "";
			$this->Sales_Number->TooltipValue = "";

			// Sales_Date
			$this->Sales_Date->LinkCustomAttributes = "";
			$this->Sales_Date->HrefValue = "";
			$this->Sales_Date->TooltipValue = "";

			// Customer_ID
			$this->Customer_ID->LinkCustomAttributes = "";
			$this->Customer_ID->HrefValue = "";
			$this->Customer_ID->TooltipValue = "";

			// Notes
			$this->Notes->LinkCustomAttributes = "";
			$this->Notes->HrefValue = "";
			$this->Notes->TooltipValue = "";

			// Total_Amount
			$this->Total_Amount->LinkCustomAttributes = "";
			$this->Total_Amount->HrefValue = "";
			$this->Total_Amount->TooltipValue = "";

			// Discount_Type
			$this->Discount_Type->LinkCustomAttributes = "";
			$this->Discount_Type->HrefValue = "";
			$this->Discount_Type->TooltipValue = "";

			// Discount_Percentage
			$this->Discount_Percentage->LinkCustomAttributes = "";
			$this->Discount_Percentage->HrefValue = "";
			$this->Discount_Percentage->TooltipValue = "";

			// Discount_Amount
			$this->Discount_Amount->LinkCustomAttributes = "";
			$this->Discount_Amount->HrefValue = "";
			$this->Discount_Amount->TooltipValue = "";

			// Tax_Percentage
			$this->Tax_Percentage->LinkCustomAttributes = "";
			$this->Tax_Percentage->HrefValue = "";
			$this->Tax_Percentage->TooltipValue = "";

			// Tax_Amount
			$this->Tax_Amount->LinkCustomAttributes = "";
			$this->Tax_Amount->HrefValue = "";
			$this->Tax_Amount->TooltipValue = "";

			// Tax_Description
			$this->Tax_Description->LinkCustomAttributes = "";
			$this->Tax_Description->HrefValue = "";
			$this->Tax_Description->TooltipValue = "";

			// Final_Total_Amount
			$this->Final_Total_Amount->LinkCustomAttributes = "";
			$this->Final_Total_Amount->HrefValue = "";
			$this->Final_Total_Amount->TooltipValue = "";

			// Total_Payment
			$this->Total_Payment->LinkCustomAttributes = "";
			$this->Total_Payment->HrefValue = "";
			$this->Total_Payment->TooltipValue = "";

			// Total_Balance
			$this->Total_Balance->LinkCustomAttributes = "";
			$this->Total_Balance->HrefValue = "";
			$this->Total_Balance->TooltipValue = "";

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

			// Sales_Number
			$this->Sales_Number->EditAttrs["class"] = "form-control";
			$this->Sales_Number->EditCustomAttributes = "";
			$this->Sales_Number->EditValue = ew_HtmlEncode($this->Sales_Number->CurrentValue);
			$this->Sales_Number->PlaceHolder = ew_RemoveHtml($this->Sales_Number->FldCaption());

			// Sales_Date
			$this->Sales_Date->EditAttrs["class"] = "form-control";
			$this->Sales_Date->EditCustomAttributes = "";
			$this->Sales_Date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Sales_Date->CurrentValue, 9));
			$this->Sales_Date->PlaceHolder = ew_RemoveHtml($this->Sales_Date->FldCaption());

			// Customer_ID
			$this->Customer_ID->EditAttrs["class"] = "form-control";
			$this->Customer_ID->EditCustomAttributes = "";
			if ($this->Customer_ID->getSessionValue() <> "") {
				$this->Customer_ID->CurrentValue = $this->Customer_ID->getSessionValue();
			if (strval($this->Customer_ID->CurrentValue) <> "") {
				$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer_ID->CurrentValue, EW_DATATYPE_STRING, "");
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
			$this->Lookup_Selecting($this->Customer_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->Customer_ID->ViewValue = $this->Customer_ID->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Customer_ID->ViewValue = $this->Customer_ID->CurrentValue;
				}
			} else {
				$this->Customer_ID->ViewValue = NULL;
			}
			$this->Customer_ID->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->Customer_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer_ID->CurrentValue, EW_DATATYPE_STRING, "");
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
			$this->Lookup_Selecting($this->Customer_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Customer_ID->EditValue = $arwrk;
			}

			// Notes
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue = ew_HtmlEncode($this->Notes->CurrentValue);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

			// Total_Amount
			$this->Total_Amount->EditAttrs["class"] = "form-control";
			$this->Total_Amount->EditCustomAttributes = "";
			$this->Total_Amount->EditValue = ew_HtmlEncode($this->Total_Amount->CurrentValue);
			$this->Total_Amount->PlaceHolder = ew_RemoveHtml($this->Total_Amount->FldCaption());
			if (strval($this->Total_Amount->EditValue) <> "" && is_numeric($this->Total_Amount->EditValue)) $this->Total_Amount->EditValue = ew_FormatNumber($this->Total_Amount->EditValue, -2, -2, -2, -2);

			// Discount_Type
			$this->Discount_Type->EditCustomAttributes = "";
			$this->Discount_Type->EditValue = $this->Discount_Type->Options(FALSE);

			// Discount_Percentage
			$this->Discount_Percentage->EditAttrs["class"] = "form-control";
			$this->Discount_Percentage->EditCustomAttributes = "";
			$this->Discount_Percentage->EditValue = ew_HtmlEncode($this->Discount_Percentage->CurrentValue);
			$this->Discount_Percentage->PlaceHolder = ew_RemoveHtml($this->Discount_Percentage->FldCaption());
			if (strval($this->Discount_Percentage->EditValue) <> "" && is_numeric($this->Discount_Percentage->EditValue)) $this->Discount_Percentage->EditValue = ew_FormatNumber($this->Discount_Percentage->EditValue, -2, -2, -2, -2);

			// Discount_Amount
			$this->Discount_Amount->EditAttrs["class"] = "form-control";
			$this->Discount_Amount->EditCustomAttributes = "";
			$this->Discount_Amount->EditValue = ew_HtmlEncode($this->Discount_Amount->CurrentValue);
			$this->Discount_Amount->PlaceHolder = ew_RemoveHtml($this->Discount_Amount->FldCaption());
			if (strval($this->Discount_Amount->EditValue) <> "" && is_numeric($this->Discount_Amount->EditValue)) $this->Discount_Amount->EditValue = ew_FormatNumber($this->Discount_Amount->EditValue, -2, -2, -2, -2);

			// Tax_Percentage
			$this->Tax_Percentage->EditAttrs["class"] = "form-control";
			$this->Tax_Percentage->EditCustomAttributes = "";
			$this->Tax_Percentage->EditValue = ew_HtmlEncode($this->Tax_Percentage->CurrentValue);
			$this->Tax_Percentage->PlaceHolder = ew_RemoveHtml($this->Tax_Percentage->FldCaption());
			if (strval($this->Tax_Percentage->EditValue) <> "" && is_numeric($this->Tax_Percentage->EditValue)) $this->Tax_Percentage->EditValue = ew_FormatNumber($this->Tax_Percentage->EditValue, -2, -2, -2, -2);

			// Tax_Amount
			$this->Tax_Amount->EditAttrs["class"] = "form-control";
			$this->Tax_Amount->EditCustomAttributes = "";
			$this->Tax_Amount->EditValue = ew_HtmlEncode($this->Tax_Amount->CurrentValue);
			$this->Tax_Amount->PlaceHolder = ew_RemoveHtml($this->Tax_Amount->FldCaption());
			if (strval($this->Tax_Amount->EditValue) <> "" && is_numeric($this->Tax_Amount->EditValue)) $this->Tax_Amount->EditValue = ew_FormatNumber($this->Tax_Amount->EditValue, -2, -2, -2, -2);

			// Tax_Description
			$this->Tax_Description->EditAttrs["class"] = "form-control";
			$this->Tax_Description->EditCustomAttributes = "";
			$this->Tax_Description->EditValue = ew_HtmlEncode($this->Tax_Description->CurrentValue);
			$this->Tax_Description->PlaceHolder = ew_RemoveHtml($this->Tax_Description->FldCaption());

			// Final_Total_Amount
			$this->Final_Total_Amount->EditAttrs["class"] = "form-control";
			$this->Final_Total_Amount->EditCustomAttributes = "";
			$this->Final_Total_Amount->EditValue = ew_HtmlEncode($this->Final_Total_Amount->CurrentValue);
			$this->Final_Total_Amount->PlaceHolder = ew_RemoveHtml($this->Final_Total_Amount->FldCaption());
			if (strval($this->Final_Total_Amount->EditValue) <> "" && is_numeric($this->Final_Total_Amount->EditValue)) $this->Final_Total_Amount->EditValue = ew_FormatNumber($this->Final_Total_Amount->EditValue, -2, -2, -2, -2);

			// Total_Payment
			$this->Total_Payment->EditAttrs["class"] = "form-control";
			$this->Total_Payment->EditCustomAttributes = "";
			$this->Total_Payment->EditValue = ew_HtmlEncode($this->Total_Payment->CurrentValue);
			$this->Total_Payment->PlaceHolder = ew_RemoveHtml($this->Total_Payment->FldCaption());
			if (strval($this->Total_Payment->EditValue) <> "" && is_numeric($this->Total_Payment->EditValue)) $this->Total_Payment->EditValue = ew_FormatNumber($this->Total_Payment->EditValue, -2, -2, -2, -2);

			// Total_Balance
			$this->Total_Balance->EditAttrs["class"] = "form-control";
			$this->Total_Balance->EditCustomAttributes = "";
			$this->Total_Balance->EditValue = ew_HtmlEncode($this->Total_Balance->CurrentValue);
			$this->Total_Balance->PlaceHolder = ew_RemoveHtml($this->Total_Balance->FldCaption());
			if (strval($this->Total_Balance->EditValue) <> "" && is_numeric($this->Total_Balance->EditValue)) $this->Total_Balance->EditValue = ew_FormatNumber($this->Total_Balance->EditValue, -2, -2, -2, -2);

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
			// Sales_Number

			$this->Sales_Number->LinkCustomAttributes = "";
			$this->Sales_Number->HrefValue = "";

			// Sales_Date
			$this->Sales_Date->LinkCustomAttributes = "";
			$this->Sales_Date->HrefValue = "";

			// Customer_ID
			$this->Customer_ID->LinkCustomAttributes = "";
			$this->Customer_ID->HrefValue = "";

			// Notes
			$this->Notes->LinkCustomAttributes = "";
			$this->Notes->HrefValue = "";

			// Total_Amount
			$this->Total_Amount->LinkCustomAttributes = "";
			$this->Total_Amount->HrefValue = "";

			// Discount_Type
			$this->Discount_Type->LinkCustomAttributes = "";
			$this->Discount_Type->HrefValue = "";

			// Discount_Percentage
			$this->Discount_Percentage->LinkCustomAttributes = "";
			$this->Discount_Percentage->HrefValue = "";

			// Discount_Amount
			$this->Discount_Amount->LinkCustomAttributes = "";
			$this->Discount_Amount->HrefValue = "";

			// Tax_Percentage
			$this->Tax_Percentage->LinkCustomAttributes = "";
			$this->Tax_Percentage->HrefValue = "";

			// Tax_Amount
			$this->Tax_Amount->LinkCustomAttributes = "";
			$this->Tax_Amount->HrefValue = "";

			// Tax_Description
			$this->Tax_Description->LinkCustomAttributes = "";
			$this->Tax_Description->HrefValue = "";

			// Final_Total_Amount
			$this->Final_Total_Amount->LinkCustomAttributes = "";
			$this->Final_Total_Amount->HrefValue = "";

			// Total_Payment
			$this->Total_Payment->LinkCustomAttributes = "";
			$this->Total_Payment->HrefValue = "";

			// Total_Balance
			$this->Total_Balance->LinkCustomAttributes = "";
			$this->Total_Balance->HrefValue = "";

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
		if (!$this->Sales_Number->FldIsDetailKey && !is_null($this->Sales_Number->FormValue) && $this->Sales_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Sales_Number->FldCaption(), $this->Sales_Number->ReqErrMsg));
		}
		if (!$this->Sales_Date->FldIsDetailKey && !is_null($this->Sales_Date->FormValue) && $this->Sales_Date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Sales_Date->FldCaption(), $this->Sales_Date->ReqErrMsg));
		}
		if (!ew_CheckDate($this->Sales_Date->FormValue)) {
			ew_AddMessage($gsFormError, $this->Sales_Date->FldErrMsg());
		}
		if (!$this->Customer_ID->FldIsDetailKey && !is_null($this->Customer_ID->FormValue) && $this->Customer_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Customer_ID->FldCaption(), $this->Customer_ID->ReqErrMsg));
		}
		if (!$this->Total_Amount->FldIsDetailKey && !is_null($this->Total_Amount->FormValue) && $this->Total_Amount->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Total_Amount->FldCaption(), $this->Total_Amount->ReqErrMsg));
		}
		if ($this->Discount_Type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Discount_Type->FldCaption(), $this->Discount_Type->ReqErrMsg));
		}
		if (!$this->Discount_Percentage->FldIsDetailKey && !is_null($this->Discount_Percentage->FormValue) && $this->Discount_Percentage->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Discount_Percentage->FldCaption(), $this->Discount_Percentage->ReqErrMsg));
		}
		if (!ew_CheckRange($this->Discount_Percentage->FormValue, 0, 100)) {
			ew_AddMessage($gsFormError, $this->Discount_Percentage->FldErrMsg());
		}
		if (!$this->Discount_Amount->FldIsDetailKey && !is_null($this->Discount_Amount->FormValue) && $this->Discount_Amount->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Discount_Amount->FldCaption(), $this->Discount_Amount->ReqErrMsg));
		}
		if (!$this->Tax_Percentage->FldIsDetailKey && !is_null($this->Tax_Percentage->FormValue) && $this->Tax_Percentage->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tax_Percentage->FldCaption(), $this->Tax_Percentage->ReqErrMsg));
		}
		if (!ew_CheckRange($this->Tax_Percentage->FormValue, 0, 100)) {
			ew_AddMessage($gsFormError, $this->Tax_Percentage->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Tax_Amount->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tax_Amount->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Final_Total_Amount->FormValue)) {
			ew_AddMessage($gsFormError, $this->Final_Total_Amount->FldErrMsg());
		}
		if (!$this->Total_Payment->FldIsDetailKey && !is_null($this->Total_Payment->FormValue) && $this->Total_Payment->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Total_Payment->FldCaption(), $this->Total_Payment->ReqErrMsg));
		}
		if (!ew_CheckRange($this->Total_Payment->FormValue, 1, 999999999)) {
			ew_AddMessage($gsFormError, $this->Total_Payment->FldErrMsg());
		}
		if (!$this->Total_Balance->FldIsDetailKey && !is_null($this->Total_Balance->FormValue) && $this->Total_Balance->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Total_Balance->FldCaption(), $this->Total_Balance->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("a_sales_detail", $DetailTblVar) && $GLOBALS["a_sales_detail"]->DetailAdd) {
			if (!isset($GLOBALS["a_sales_detail_grid"])) $GLOBALS["a_sales_detail_grid"] = new ca_sales_detail_grid(); // get detail page object
			$GLOBALS["a_sales_detail_grid"]->ValidateGridForm();
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
		if ($this->Sales_Number->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Sales_Number = '" . ew_AdjustSql($this->Sales_Number->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Sales_Number->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Sales_Number->CurrentValue, $sIdxErrMsg);
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

		// Sales_Number
		$this->Sales_Number->SetDbValueDef($rsnew, $this->Sales_Number->CurrentValue, "", FALSE);

		// Sales_Date
		$this->Sales_Date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Sales_Date->CurrentValue, 9), ew_CurrentDate(), FALSE);

		// Customer_ID
		$this->Customer_ID->SetDbValueDef($rsnew, $this->Customer_ID->CurrentValue, "", FALSE);

		// Notes
		$this->Notes->SetDbValueDef($rsnew, $this->Notes->CurrentValue, NULL, FALSE);

		// Total_Amount
		$this->Total_Amount->SetDbValueDef($rsnew, $this->Total_Amount->CurrentValue, NULL, strval($this->Total_Amount->CurrentValue) == "");

		// Discount_Type
		$this->Discount_Type->SetDbValueDef($rsnew, $this->Discount_Type->CurrentValue, NULL, FALSE);

		// Discount_Percentage
		$this->Discount_Percentage->SetDbValueDef($rsnew, $this->Discount_Percentage->CurrentValue, NULL, strval($this->Discount_Percentage->CurrentValue) == "");

		// Discount_Amount
		$this->Discount_Amount->SetDbValueDef($rsnew, $this->Discount_Amount->CurrentValue, NULL, strval($this->Discount_Amount->CurrentValue) == "");

		// Tax_Percentage
		$this->Tax_Percentage->SetDbValueDef($rsnew, $this->Tax_Percentage->CurrentValue, NULL, strval($this->Tax_Percentage->CurrentValue) == "");

		// Tax_Amount
		$this->Tax_Amount->SetDbValueDef($rsnew, $this->Tax_Amount->CurrentValue, NULL, strval($this->Tax_Amount->CurrentValue) == "");

		// Tax_Description
		$this->Tax_Description->SetDbValueDef($rsnew, $this->Tax_Description->CurrentValue, NULL, FALSE);

		// Final_Total_Amount
		$this->Final_Total_Amount->SetDbValueDef($rsnew, $this->Final_Total_Amount->CurrentValue, NULL, strval($this->Final_Total_Amount->CurrentValue) == "");

		// Total_Payment
		$this->Total_Payment->SetDbValueDef($rsnew, $this->Total_Payment->CurrentValue, NULL, strval($this->Total_Payment->CurrentValue) == "");

		// Total_Balance
		$this->Total_Balance->SetDbValueDef($rsnew, $this->Total_Balance->CurrentValue, NULL, strval($this->Total_Balance->CurrentValue) == "");

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("a_sales_detail", $DetailTblVar) && $GLOBALS["a_sales_detail"]->DetailAdd) {
				$GLOBALS["a_sales_detail"]->Sales_Number->setSessionValue($this->Sales_Number->CurrentValue); // Set master key
				if (!isset($GLOBALS["a_sales_detail_grid"])) $GLOBALS["a_sales_detail_grid"] = new ca_sales_detail_grid(); // Get detail page object
				$AddRow = $GLOBALS["a_sales_detail_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["a_sales_detail"]->Sales_Number->setSessionValue(""); // Clear master key if insert failed
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
			if ($sMasterTblVar == "a_customers") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Customer_Number"] <> "") {
					$GLOBALS["a_customers"]->Customer_Number->setQueryStringValue($_GET["fk_Customer_Number"]);
					$this->Customer_ID->setQueryStringValue($GLOBALS["a_customers"]->Customer_Number->QueryStringValue);
					$this->Customer_ID->setSessionValue($this->Customer_ID->QueryStringValue);
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
			if ($sMasterTblVar == "a_customers") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Customer_Number"] <> "") {
					$GLOBALS["a_customers"]->Customer_Number->setFormValue($_POST["fk_Customer_Number"]);
					$this->Customer_ID->setFormValue($GLOBALS["a_customers"]->Customer_Number->FormValue);
					$this->Customer_ID->setSessionValue($this->Customer_ID->FormValue);
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
			if ($sMasterTblVar <> "a_customers") {
				if ($this->Customer_ID->CurrentValue == "") $this->Customer_ID->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
			if (in_array("a_sales_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["a_sales_detail_grid"]))
					$GLOBALS["a_sales_detail_grid"] = new ca_sales_detail_grid;
				if ($GLOBALS["a_sales_detail_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["a_sales_detail_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["a_sales_detail_grid"]->CurrentMode = "add";
					$GLOBALS["a_sales_detail_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["a_sales_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["a_sales_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["a_sales_detail_grid"]->Sales_Number->FldIsDetailKey = TRUE;
					$GLOBALS["a_sales_detail_grid"]->Sales_Number->CurrentValue = $this->Sales_Number->CurrentValue;
					$GLOBALS["a_sales_detail_grid"]->Sales_Number->setSessionValue($GLOBALS["a_sales_detail_grid"]->Sales_Number->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_saleslist.php"), "", $this->TableVar, TRUE);
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

		if (isset($_GET["Customer_Number"])) {	
			$_SESSION["Customer_Number_Sales"] = $_GET["Customer_Number"];
		} else {
			if ($this->CurrentAction == "A") {

				// after adding a new record, redirect to List Page
			} else {

				//$this->setWarningMessage("Please click on <strong>Sale Now</strong> related to the Customers in the List below!");
				//$url = "a_customerslist.php";

			}
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
if (!isset($a_sales_add)) $a_sales_add = new ca_sales_add();

// Page init
$a_sales_add->Page_Init();

// Page main
$a_sales_add->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_sales_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fa_salesadd = new ew_Form("fa_salesadd", "add");

// Validate form
fa_salesadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Sales_Number->FldCaption(), $a_sales->Sales_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Sales_Date->FldCaption(), $a_sales->Sales_Date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Sales_Date");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Sales_Date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Customer_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Customer_ID->FldCaption(), $a_sales->Customer_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Total_Amount");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Total_Amount->FldCaption(), $a_sales->Total_Amount->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Discount_Type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Discount_Type->FldCaption(), $a_sales->Discount_Type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Discount_Percentage");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Discount_Percentage->FldCaption(), $a_sales->Discount_Percentage->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Discount_Percentage");
			if (elm && !ew_CheckRange(elm.value, 0, 100))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Discount_Percentage->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Discount_Amount");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Discount_Amount->FldCaption(), $a_sales->Discount_Amount->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tax_Percentage");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Tax_Percentage->FldCaption(), $a_sales->Tax_Percentage->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tax_Percentage");
			if (elm && !ew_CheckRange(elm.value, 0, 100))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Tax_Percentage->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tax_Amount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Tax_Amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Final_Total_Amount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Final_Total_Amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Total_Payment");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Total_Payment->FldCaption(), $a_sales->Total_Payment->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Total_Payment");
			if (elm && !ew_CheckRange(elm.value, 1, 999999999))
				return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Total_Payment->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Total_Balance");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_sales->Total_Balance->FldCaption(), $a_sales->Total_Balance->ReqErrMsg)) ?>");

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
fa_salesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_salesadd.ValidateRequired = true;
<?php } else { ?>
fa_salesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_salesadd.Lists["x_Customer_ID"] = {"LinkField":"x_Customer_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_salesadd.Lists["x_Discount_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_salesadd.Lists["x_Discount_Type"].Options = <?php echo json_encode($a_sales->Discount_Type->Options()) ?>;

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
<?php $a_sales_add->ShowPageHeader(); ?>
<?php
$a_sales_add->ShowMessage();
?>
<form name="fa_salesadd" id="fa_salesadd" class="<?php echo $a_sales_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_sales_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_sales_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_sales">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($a_sales->getCurrentMasterTable() == "a_customers") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="a_customers">
<input type="hidden" name="fk_Customer_Number" value="<?php echo $a_sales->Customer_ID->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($a_sales->Sales_Number->Visible) { // Sales_Number ?>
	<div id="r_Sales_Number" class="form-group">
		<label id="elh_a_sales_Sales_Number" for="x_Sales_Number" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Sales_Number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Sales_Number->CellAttributes() ?>>
<span id="el_a_sales_Sales_Number">
<input type="text" data-table="a_sales" data-field="x_Sales_Number" name="x_Sales_Number" id="x_Sales_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Number->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Number->EditValue ?>"<?php echo $a_sales->Sales_Number->EditAttributes() ?>>
</span>
<?php echo $a_sales->Sales_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Sales_Date->Visible) { // Sales_Date ?>
	<div id="r_Sales_Date" class="form-group">
		<label id="elh_a_sales_Sales_Date" for="x_Sales_Date" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Sales_Date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Sales_Date->CellAttributes() ?>>
<span id="el_a_sales_Sales_Date">
<input type="text" data-table="a_sales" data-field="x_Sales_Date" data-format="9" name="x_Sales_Date" id="x_Sales_Date" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Date->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Date->EditValue ?>"<?php echo $a_sales->Sales_Date->EditAttributes() ?>>
<?php if (!$a_sales->Sales_Date->ReadOnly && !$a_sales->Sales_Date->Disabled && !isset($a_sales->Sales_Date->EditAttrs["readonly"]) && !isset($a_sales->Sales_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_salesadd", "x_Sales_Date", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php echo $a_sales->Sales_Date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Customer_ID->Visible) { // Customer_ID ?>
	<div id="r_Customer_ID" class="form-group">
		<label id="elh_a_sales_Customer_ID" for="x_Customer_ID" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Customer_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Customer_ID->CellAttributes() ?>>
<?php if ($a_sales->Customer_ID->getSessionValue() <> "") { ?>
<span id="el_a_sales_Customer_ID">
<span<?php echo $a_sales->Customer_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_sales->Customer_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_Customer_ID" name="x_Customer_ID" value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el_a_sales_Customer_ID">
<select data-table="a_sales" data-field="x_Customer_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales->Customer_ID->DisplayValueSeparator) ? json_encode($a_sales->Customer_ID->DisplayValueSeparator) : $a_sales->Customer_ID->DisplayValueSeparator) ?>" id="x_Customer_ID" name="x_Customer_ID"<?php echo $a_sales->Customer_ID->EditAttributes() ?>>
<?php
if (is_array($a_sales->Customer_ID->EditValue)) {
	$arwrk = $a_sales->Customer_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales->Customer_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_sales->Customer_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_sales->Customer_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_sales->Customer_ID->CurrentValue) ?>" selected><?php echo $a_sales->Customer_ID->CurrentValue ?></option>
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
$a_sales->Customer_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_sales->Customer_ID->LookupFilters += array("f0" => "`Customer_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_sales->Lookup_Selecting($a_sales->Customer_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_sales->Customer_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Customer_ID" id="s_x_Customer_ID" value="<?php echo $a_sales->Customer_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $a_sales->Customer_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Notes->Visible) { // Notes ?>
	<div id="r_Notes" class="form-group">
		<label id="elh_a_sales_Notes" for="x_Notes" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Notes->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Notes->CellAttributes() ?>>
<span id="el_a_sales_Notes">
<input type="text" data-table="a_sales" data-field="x_Notes" name="x_Notes" id="x_Notes" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Notes->getPlaceHolder()) ?>" value="<?php echo $a_sales->Notes->EditValue ?>"<?php echo $a_sales->Notes->EditAttributes() ?>>
</span>
<?php echo $a_sales->Notes->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Total_Amount->Visible) { // Total_Amount ?>
	<div id="r_Total_Amount" class="form-group">
		<label id="elh_a_sales_Total_Amount" for="x_Total_Amount" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Total_Amount->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Total_Amount->CellAttributes() ?>>
<span id="el_a_sales_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Total_Amount" name="x_Total_Amount" id="x_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Amount->EditValue ?>"<?php echo $a_sales->Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Total_Amount->ReadOnly && !$a_sales->Total_Amount->Disabled && @$a_sales->Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales->Total_Amount->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Discount_Type->Visible) { // Discount_Type ?>
	<div id="r_Discount_Type" class="form-group">
		<label id="elh_a_sales_Discount_Type" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Discount_Type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Discount_Type->CellAttributes() ?>>
<span id="el_a_sales_Discount_Type">
<div id="tp_x_Discount_Type" class="ewTemplate"><input type="radio" data-table="a_sales" data-field="x_Discount_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales->Discount_Type->DisplayValueSeparator) ? json_encode($a_sales->Discount_Type->DisplayValueSeparator) : $a_sales->Discount_Type->DisplayValueSeparator) ?>" name="x_Discount_Type" id="x_Discount_Type" value="{value}"<?php echo $a_sales->Discount_Type->EditAttributes() ?>></div>
<div id="dsl_x_Discount_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $a_sales->Discount_Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_sales->Discount_Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="a_sales" data-field="x_Discount_Type" name="x_Discount_Type" id="x_Discount_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $a_sales->Discount_Type->EditAttributes() ?>><?php echo $a_sales->Discount_Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($a_sales->Discount_Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="a_sales" data-field="x_Discount_Type" name="x_Discount_Type" id="x_Discount_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($a_sales->Discount_Type->CurrentValue) ?>" checked<?php echo $a_sales->Discount_Type->EditAttributes() ?>><?php echo $a_sales->Discount_Type->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $a_sales->Discount_Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Discount_Percentage->Visible) { // Discount_Percentage ?>
	<div id="r_Discount_Percentage" class="form-group">
		<label id="elh_a_sales_Discount_Percentage" for="x_Discount_Percentage" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Discount_Percentage->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Discount_Percentage->CellAttributes() ?>>
<span id="el_a_sales_Discount_Percentage">
<input type="text" data-table="a_sales" data-field="x_Discount_Percentage" name="x_Discount_Percentage" id="x_Discount_Percentage" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Discount_Percentage->getPlaceHolder()) ?>" value="<?php echo $a_sales->Discount_Percentage->EditValue ?>"<?php echo $a_sales->Discount_Percentage->EditAttributes() ?>>
<?php if (!$a_sales->Discount_Percentage->ReadOnly && !$a_sales->Discount_Percentage->Disabled && @$a_sales->Discount_Percentage->EditAttrs["readonly"] == "" && @$a_sales->Discount_Percentage->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Discount_Percentage').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales->Discount_Percentage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Discount_Amount->Visible) { // Discount_Amount ?>
	<div id="r_Discount_Amount" class="form-group">
		<label id="elh_a_sales_Discount_Amount" for="x_Discount_Amount" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Discount_Amount->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Discount_Amount->CellAttributes() ?>>
<span id="el_a_sales_Discount_Amount">
<input type="text" data-table="a_sales" data-field="x_Discount_Amount" name="x_Discount_Amount" id="x_Discount_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Discount_Amount->EditValue ?>"<?php echo $a_sales->Discount_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Discount_Amount->ReadOnly && !$a_sales->Discount_Amount->Disabled && @$a_sales->Discount_Amount->EditAttrs["readonly"] == "" && @$a_sales->Discount_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Discount_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales->Discount_Amount->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Tax_Percentage->Visible) { // Tax_Percentage ?>
	<div id="r_Tax_Percentage" class="form-group">
		<label id="elh_a_sales_Tax_Percentage" for="x_Tax_Percentage" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Tax_Percentage->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Tax_Percentage->CellAttributes() ?>>
<span id="el_a_sales_Tax_Percentage">
<input type="text" data-table="a_sales" data-field="x_Tax_Percentage" name="x_Tax_Percentage" id="x_Tax_Percentage" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Percentage->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Percentage->EditValue ?>"<?php echo $a_sales->Tax_Percentage->EditAttributes() ?>>
<?php if (!$a_sales->Tax_Percentage->ReadOnly && !$a_sales->Tax_Percentage->Disabled && @$a_sales->Tax_Percentage->EditAttrs["readonly"] == "" && @$a_sales->Tax_Percentage->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Tax_Percentage').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales->Tax_Percentage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Tax_Amount->Visible) { // Tax_Amount ?>
	<div id="r_Tax_Amount" class="form-group">
		<label id="elh_a_sales_Tax_Amount" for="x_Tax_Amount" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Tax_Amount->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Tax_Amount->CellAttributes() ?>>
<span id="el_a_sales_Tax_Amount">
<input type="text" data-table="a_sales" data-field="x_Tax_Amount" name="x_Tax_Amount" id="x_Tax_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Amount->EditValue ?>"<?php echo $a_sales->Tax_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Tax_Amount->ReadOnly && !$a_sales->Tax_Amount->Disabled && @$a_sales->Tax_Amount->EditAttrs["readonly"] == "" && @$a_sales->Tax_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Tax_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales->Tax_Amount->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Tax_Description->Visible) { // Tax_Description ?>
	<div id="r_Tax_Description" class="form-group">
		<label id="elh_a_sales_Tax_Description" for="x_Tax_Description" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Tax_Description->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Tax_Description->CellAttributes() ?>>
<span id="el_a_sales_Tax_Description">
<input type="text" data-table="a_sales" data-field="x_Tax_Description" name="x_Tax_Description" id="x_Tax_Description" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Description->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Description->EditValue ?>"<?php echo $a_sales->Tax_Description->EditAttributes() ?>>
</span>
<?php echo $a_sales->Tax_Description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Final_Total_Amount->Visible) { // Final_Total_Amount ?>
	<div id="r_Final_Total_Amount" class="form-group">
		<label id="elh_a_sales_Final_Total_Amount" for="x_Final_Total_Amount" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Final_Total_Amount->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Final_Total_Amount->CellAttributes() ?>>
<span id="el_a_sales_Final_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Final_Total_Amount" name="x_Final_Total_Amount" id="x_Final_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Final_Total_Amount->EditValue ?>"<?php echo $a_sales->Final_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Final_Total_Amount->ReadOnly && !$a_sales->Final_Total_Amount->Disabled && @$a_sales->Final_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Final_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Final_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales->Final_Total_Amount->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Total_Payment->Visible) { // Total_Payment ?>
	<div id="r_Total_Payment" class="form-group">
		<label id="elh_a_sales_Total_Payment" for="x_Total_Payment" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Total_Payment->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Total_Payment->CellAttributes() ?>>
<span id="el_a_sales_Total_Payment">
<input type="text" data-table="a_sales" data-field="x_Total_Payment" name="x_Total_Payment" id="x_Total_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Payment->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Payment->EditValue ?>"<?php echo $a_sales->Total_Payment->EditAttributes() ?>>
<?php if (!$a_sales->Total_Payment->ReadOnly && !$a_sales->Total_Payment->Disabled && @$a_sales->Total_Payment->EditAttrs["readonly"] == "" && @$a_sales->Total_Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Total_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales->Total_Payment->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Total_Balance->Visible) { // Total_Balance ?>
	<div id="r_Total_Balance" class="form-group">
		<label id="elh_a_sales_Total_Balance" for="x_Total_Balance" class="col-sm-4 control-label ewLabel"><?php echo $a_sales->Total_Balance->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_sales->Total_Balance->CellAttributes() ?>>
<span id="el_a_sales_Total_Balance">
<input type="text" data-table="a_sales" data-field="x_Total_Balance" name="x_Total_Balance" id="x_Total_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Balance->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Balance->EditValue ?>"<?php echo $a_sales->Total_Balance->EditAttributes() ?>>
<?php if (!$a_sales->Total_Balance->ReadOnly && !$a_sales->Total_Balance->Disabled && @$a_sales->Total_Balance->EditAttrs["readonly"] == "" && @$a_sales->Total_Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Total_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_sales->Total_Balance->CustomMsg ?></div></div>
	</div>
<?php } ?>
<span id="el_a_sales_Date_Added">
<input type="hidden" data-table="a_sales" data-field="x_Date_Added" name="x_Date_Added" id="x_Date_Added" value="<?php echo ew_HtmlEncode($a_sales->Date_Added->CurrentValue) ?>">
</span>
<span id="el_a_sales_Added_By">
<input type="hidden" data-table="a_sales" data-field="x_Added_By" name="x_Added_By" id="x_Added_By" value="<?php echo ew_HtmlEncode($a_sales->Added_By->CurrentValue) ?>">
</span>
</div>
<?php
	if (in_array("a_sales_detail", explode(",", $a_sales->getCurrentDetailTable())) && $a_sales_detail->DetailAdd) {
?>
<?php if ($a_sales->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("a_sales_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "a_sales_detailgrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $a_sales_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fa_salesadd.Init();
</script>
<?php
$a_sales_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">
$(document).on("updatedone", function(e, args) {
	if (args.target.id == "x_Customer_ID") {
		<?php if (isset($_GET["Customer_Number"])) { ?>

		//$(args.target).val("<?php echo $_GET["Customer_Number"]; ?>");
		//$(args.target).attr('disabled','disabled');

		<?php } ?>
	}
});
$(document).ready(function() {
	$('#r_Tax_Amount').hide();
	if($('input[name=x_Discount_Type]:radio:checked').val()=="P"){

		//$('#x_Discount_Amount').val("0");
		$('#r_Discount_Amount').hide();
		$('#r_Discount_Percentage').show();
	} else {

		//$('#x_Discount_Percentage').val("0");
		$('#r_Discount_Percentage').hide();
		$('#r_Discount_Amount').show();  
	}
	$('input[name=x_Discount_Type]:radio').click(function(){
		if($(this).attr("value")=="P"){

			//$('#x_Discount_Amount').val("0");
			$('#r_Discount_Amount').hide();
			$('#r_Discount_Percentage').show();
		} else {

			//$('#x_Discount_Percentage').val("0");
			$('#r_Discount_Percentage').hide();
			$('#r_Discount_Amount').show();
		}
		GetAmountTotalFinal();
	});
	$("#x_Total_Balance").blur(function() {
		$("#x_Total_Balance").val($("#x_Final_Total_Amount").autoNumeric('get') - $("#x_Total_Payment").autoNumeric('get'));
	});
	AdjustCSSGrid();
});

function AdjustCSSGrid() {
	$("input[data-field='x_Sales_Quantity'], input[data-field='x_Purchasing_Price'], input[data-field='x_Sales_Price'], input[data-field='x_Sales_Total_Amount']").css('min-width', '120px');
	$("input[data-field='x_Sales_Quantity'], input[data-field='x_Purchasing_Price'], input[data-field='x_Sales_Price'], input[data-field='x_Sales_Total_Amount']").css('max-width', '160px');
	$("input[data-field='x_Sales_Quantity'], input[data-field='x_Purchasing_Price'], input[data-field='x_Sales_Price'], input[data-field='x_Sales_Total_Amount']").css('text-align', 'right');
}
$(function() {
	$(document).on('change', 'select[data-field="x_Stock_Item"]', function (e) {
		generateSelectedAreas();		
	});

	function generateSelectedAreas() {
		var selectedValues=[];
		$('select[data-field="x_Stock_Item"] option:selected').each(function () {
		   var select = $(this).parent(),
		   optValue = $(this).val();            
		   if($(this).val()!=''){
			   $('select[data-field="x_Stock_Item"]').not(select).children().filter(function(e){
				   if($(this).val()==optValue) 					 						
					   return e
			   }).remove();
		   }
		});
	}
});

function SetFocusTextBox(name) {
	$("#x_"+ name +"").select(); 
}

function SetFocusTextGrid(event, name) {
	var elm_name = $(event.target).attr('name');
	var start_pos = elm_name.indexOf('x') + 1;
	var end_pos = elm_name.indexOf('_',start_pos);
	var idx = elm_name.substring(start_pos,end_pos)
	$("#x" + idx + "_" + name + "").select();  
}

function GetAmountTotal() {
	var total_amount = $("#x_Total_Amount").val(GetSalesTotal());
	return total_amount;
}

function GetAmountTotalFinal() {
	var tax_amount = ($("#x_Tax_Percentage").autoNumeric('get') / 100 ) * $("#x_Total_Amount").autoNumeric('get');
	$("#x_Tax_Amount").val(tax_amount); // added
	if ($("#x_Discount_Percentage").autoNumeric('get') > 0) {

	//if ($('input[name=x_Discount_Type]:radio').attr("value")=="P") { // changed
		var discount_amount = ($("#x_Discount_Percentage").autoNumeric('get') / 100 ) * $("#x_Total_Amount").autoNumeric('get');
		$("#x_Discount_Amount").val(discount_amount);
	} else {
		var discount_amount = $("#x_Discount_Amount").autoNumeric('get');
	}
	var final_total_amount = $("#x_Final_Total_Amount").val( ($("#x_Total_Amount").autoNumeric('get') - discount_amount) + tax_amount);
	return final_total_amount;
}

function ValidateDiscountAmount() {
	if ($("#x_Discount_Amount").autoNumeric('get') > GetSalesTotal()) {
		$("#x_Discount_Amount").val($("#x_Total_Amount").autoNumeric('get'));
	} else if ($("#x_Discount_Amount").autoNumeric('get') < 0) {
		$("#x_Discount_Amount").val(0);
	} else if ($("#x_Discount_Amount").val() == "") {
		$("#x_Discount_Amount").val(0);
	}
}

function ValidateDiscountPercentage() {
	if ($("#x_Discount_Percentage").autoNumeric('get') > 100) {
		$("#x_Discount_Percentage").val(100);
	} else if ($("#x_Discount_Percentage").autoNumeric('get') < 0) {
		$("#x_Discount_Percentage").val(0);
	} else if ($("#x_Discount_Percentage").val() == "") {
		$("#x_Discount_Percentage").val(0);
	}
}

function ValidateTaxPercentage() {
	if ($("#x_Tax_Percentage").autoNumeric('get') > 100) {
		$("#x_Tax_Percentage").val(100);
	} else if ($("#x_Tax_Percentage").autoNumeric('get') < 0) {
		$("#x_Tax_Percentage").val(0);
	} else if ($("#x_Tax_Percentage").val() == "") {
		$("#x_Tax_Percentage").val(0);
	}
}

function ValidateTotalPayment() {
	if ($("#x_Total_Payment").autoNumeric('get') < 0) {
		$("#x_Total_Payment").val(0);
	} else if ($("#x_Total_Payment").val() == "") {
		$("#x_Total_Payment").val(0);
	}
}

function ValidateFinalTotalAmount() {
	if ($("#x_Final_Total_Amount").autoNumeric('get') < 0) {
		$("#x_Final_Total_Amount").val(0);
	} else if ($("#x_Final_Total_Amount").val() == "") {
		$("#x_Final_Total_Amount").val(0);
	}
}

function GetBalanceTotalFinal() {
	var final_total_amount =  $("#x_Final_Total_Amount").autoNumeric('get');
	var total_payment = $("#x_Total_Payment").autoNumeric('get');
	var total_balance = final_total_amount - total_payment;
	$("#x_Total_Balance").val(total_balance);
	if (total_balance < 0) {
		$("#x_Total_Payment").val($("#x_Final_Total_Amount").autoNumeric('get'));
		$("#x_Total_Balance").val("0");
	}
}

function CalculateGrid(event) {
	var elm_name = $(event.target).attr('name');
	var start_pos = elm_name.indexOf('x') + 1;
	var end_pos = elm_name.indexOf('_',start_pos);
	var idx = elm_name.substring(start_pos,end_pos)
	$("#x" + idx + "_Sales_Total_Amount").val($("#x" + idx + "_Sales_Quantity").autoNumeric('get') *
	$("#x" + idx + "_Sales_Price").autoNumeric('get'));  
	$("#x_Total_Amount").val(GetSalesTotal());
}

function GetSalesTotal() {
	var fobj = fa_sales_detailgrid.GetForm(), $fobj = $(fobj);
	fa_sales_detailgrid.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var val_elm, addcnt = 0;
	var $k = $fobj.find("#" + fa_sales_detailgrid.FormKeyCountName); 
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; 
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	var total_amount = 0;
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !fa_sales_detailgrid.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			val_elm = $("#x" + infix + "_Sales_Total_Amount").autoNumeric('get');
			total_amount += +(val_elm);
			ew_ElementsToRow(fobj);
		}
	}
	return total_amount;
}
</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_salesadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($a_sales->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyAdd(this)'); function alertifyAdd(obj) { <?php global $Language; ?> if (fa_salesadd.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyAddConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyAdd'); ?>"); $("#fa_salesadd").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_sales_add->Page_Terminate();
?>
