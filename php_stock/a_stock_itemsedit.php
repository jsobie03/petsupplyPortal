<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "a_stock_itemsinfo.php" ?>
<?php include_once "a_suppliersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "view_sales_detailsgridcls.php" ?>
<?php include_once "view_purchases_detailsgridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$a_stock_items_edit = NULL; // Initialize page object first

class ca_stock_items_edit extends ca_stock_items {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_stock_items';

	// Page object name
	var $PageObjName = 'a_stock_items_edit';

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

		// Table object (a_stock_items)
		if (!isset($GLOBALS["a_stock_items"]) || get_class($GLOBALS["a_stock_items"]) == "ca_stock_items") {
			$GLOBALS["a_stock_items"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["a_stock_items"];
		}

		// Table object (a_suppliers)
		if (!isset($GLOBALS['a_suppliers'])) $GLOBALS['a_suppliers'] = new ca_suppliers();

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'a_stock_items', TRUE);

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
		if (!isset($_SESSION['table_a_stock_items_views'])) { 
			$_SESSION['table_a_stock_items_views'] = 0;
		}
		$_SESSION['table_a_stock_items_views'] = $_SESSION['table_a_stock_items_views']+1;

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
				$this->Page_Terminate(ew_GetUrl("a_stock_itemslist.php"));
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
		$this->Stock_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

			// Process auto fill for detail table 'view_sales_details'
			if (@$_POST["grid"] == "fview_sales_detailsgrid") {
				if (!isset($GLOBALS["view_sales_details_grid"])) $GLOBALS["view_sales_details_grid"] = new cview_sales_details_grid;
				$GLOBALS["view_sales_details_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'view_purchases_details'
			if (@$_POST["grid"] == "fview_purchases_detailsgrid") {
				if (!isset($GLOBALS["view_purchases_details_grid"])) $GLOBALS["view_purchases_details_grid"] = new cview_purchases_details_grid;
				$GLOBALS["view_purchases_details_grid"]->Page_Init();
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
		global $EW_EXPORT, $a_stock_items;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($a_stock_items);
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
		if (@$_GET["Stock_ID"] <> "") {
			$this->Stock_ID->setQueryStringValue($_GET["Stock_ID"]);
			$this->RecKey["Stock_ID"] = $this->Stock_ID->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("a_stock_itemslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->Stock_ID->CurrentValue) == strval($this->Recordset->fields('Stock_ID'))) {
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
					$this->Page_Terminate("a_stock_itemslist.php"); // Return to list page
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
				if (ew_GetPageName($sReturnUrl) == "a_stock_itemslist.php")
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
		if (!$this->Stock_ID->FldIsDetailKey)
			$this->Stock_ID->setFormValue($objForm->GetValue("x_Stock_ID"));
		if (!$this->Category->FldIsDetailKey) {
			$this->Category->setFormValue($objForm->GetValue("x_Category"));
		}
		if (!$this->Supplier_Number->FldIsDetailKey) {
			$this->Supplier_Number->setFormValue($objForm->GetValue("x_Supplier_Number"));
		}
		if (!$this->Stock_Number->FldIsDetailKey) {
			$this->Stock_Number->setFormValue($objForm->GetValue("x_Stock_Number"));
		}
		if (!$this->Stock_Name->FldIsDetailKey) {
			$this->Stock_Name->setFormValue($objForm->GetValue("x_Stock_Name"));
		}
		if (!$this->Unit_Of_Measurement->FldIsDetailKey) {
			$this->Unit_Of_Measurement->setFormValue($objForm->GetValue("x_Unit_Of_Measurement"));
		}
		if (!$this->Purchasing_Price->FldIsDetailKey) {
			$this->Purchasing_Price->setFormValue($objForm->GetValue("x_Purchasing_Price"));
		}
		if (!$this->Selling_Price->FldIsDetailKey) {
			$this->Selling_Price->setFormValue($objForm->GetValue("x_Selling_Price"));
		}
		if (!$this->Quantity->FldIsDetailKey) {
			$this->Quantity->setFormValue($objForm->GetValue("x_Quantity"));
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
		$this->LoadRow();
		$this->Stock_ID->CurrentValue = $this->Stock_ID->FormValue;
		$this->Category->CurrentValue = $this->Category->FormValue;
		$this->Supplier_Number->CurrentValue = $this->Supplier_Number->FormValue;
		$this->Stock_Number->CurrentValue = $this->Stock_Number->FormValue;
		$this->Stock_Name->CurrentValue = $this->Stock_Name->FormValue;
		$this->Unit_Of_Measurement->CurrentValue = $this->Unit_Of_Measurement->FormValue;
		$this->Purchasing_Price->CurrentValue = $this->Purchasing_Price->FormValue;
		$this->Selling_Price->CurrentValue = $this->Selling_Price->FormValue;
		$this->Quantity->CurrentValue = $this->Quantity->FormValue;
		$this->Notes->CurrentValue = $this->Notes->FormValue;
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
		$this->Stock_ID->setDbValue($rs->fields('Stock_ID'));
		$this->Category->setDbValue($rs->fields('Category'));
		$this->Supplier_Number->setDbValue($rs->fields('Supplier_Number'));
		$this->Stock_Number->setDbValue($rs->fields('Stock_Number'));
		$this->Stock_Name->setDbValue($rs->fields('Stock_Name'));
		$this->Unit_Of_Measurement->setDbValue($rs->fields('Unit_Of_Measurement'));
		$this->Purchasing_Price->setDbValue($rs->fields('Purchasing_Price'));
		$this->Selling_Price->setDbValue($rs->fields('Selling_Price'));
		$this->Quantity->setDbValue($rs->fields('Quantity'));
		$this->Notes->setDbValue($rs->fields('Notes'));
		$this->Date_Added->setDbValue($rs->fields('Date_Added'));
		$this->Added_By->setDbValue($rs->fields('Added_By'));
		$this->Date_Updated->setDbValue($rs->fields('Date_Updated'));
		$this->Updated_By->setDbValue($rs->fields('Updated_By'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Stock_ID->DbValue = $row['Stock_ID'];
		$this->Category->DbValue = $row['Category'];
		$this->Supplier_Number->DbValue = $row['Supplier_Number'];
		$this->Stock_Number->DbValue = $row['Stock_Number'];
		$this->Stock_Name->DbValue = $row['Stock_Name'];
		$this->Unit_Of_Measurement->DbValue = $row['Unit_Of_Measurement'];
		$this->Purchasing_Price->DbValue = $row['Purchasing_Price'];
		$this->Selling_Price->DbValue = $row['Selling_Price'];
		$this->Quantity->DbValue = $row['Quantity'];
		$this->Notes->DbValue = $row['Notes'];
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

		if ($this->Purchasing_Price->FormValue == $this->Purchasing_Price->CurrentValue && is_numeric(ew_StrToFloat($this->Purchasing_Price->CurrentValue)))
			$this->Purchasing_Price->CurrentValue = ew_StrToFloat($this->Purchasing_Price->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Selling_Price->FormValue == $this->Selling_Price->CurrentValue && is_numeric(ew_StrToFloat($this->Selling_Price->CurrentValue)))
			$this->Selling_Price->CurrentValue = ew_StrToFloat($this->Selling_Price->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Quantity->FormValue == $this->Quantity->CurrentValue && is_numeric(ew_StrToFloat($this->Quantity->CurrentValue)))
			$this->Quantity->CurrentValue = ew_StrToFloat($this->Quantity->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Stock_ID
		// Category
		// Supplier_Number
		// Stock_Number
		// Stock_Name
		// Unit_Of_Measurement
		// Purchasing_Price
		// Selling_Price
		// Quantity
		// Notes
		// Date_Added
		// Added_By
		// Date_Updated
		// Updated_By

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Stock_ID
		$this->Stock_ID->ViewValue = $this->Stock_ID->CurrentValue;
		$this->Stock_ID->ViewCustomAttributes = "";

		// Category
		if (strval($this->Category->CurrentValue) <> "") {
			$sFilterWrk = "`Category_ID`" . ew_SearchString("=", $this->Category->CurrentValue, EW_DATATYPE_NUMBER, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `Category_ID`, `Category_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_categories`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `Category_ID`, `Category_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_categories`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Category, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Category->ViewValue = $this->Category->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Category->ViewValue = $this->Category->CurrentValue;
			}
		} else {
			$this->Category->ViewValue = NULL;
		}
		$this->Category->ViewCustomAttributes = "";

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
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Supplier_Name`";
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

		// Stock_Number
		$this->Stock_Number->ViewValue = $this->Stock_Number->CurrentValue;
		$this->Stock_Number->ViewCustomAttributes = "";

		// Stock_Name
		$this->Stock_Name->ViewValue = $this->Stock_Name->CurrentValue;
		$this->Stock_Name->ViewCustomAttributes = "";

		// Unit_Of_Measurement
		if (strval($this->Unit_Of_Measurement->CurrentValue) <> "") {
			$sFilterWrk = "`UOM_ID`" . ew_SearchString("=", $this->Unit_Of_Measurement->CurrentValue, EW_DATATYPE_STRING, "");
		switch (@$gsLanguage) {
			case "id":
				$sSqlWrk = "SELECT `UOM_ID`, `UOM_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_unit_of_measurement`";
				$sWhereWrk = "";
				break;
			default:
				$sSqlWrk = "SELECT `UOM_ID`, `UOM_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_unit_of_measurement`";
				$sWhereWrk = "";
				break;
		}
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Unit_Of_Measurement, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Unit_Of_Measurement->ViewValue = $this->Unit_Of_Measurement->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Unit_Of_Measurement->ViewValue = $this->Unit_Of_Measurement->CurrentValue;
			}
		} else {
			$this->Unit_Of_Measurement->ViewValue = NULL;
		}
		$this->Unit_Of_Measurement->ViewCustomAttributes = "";

		// Purchasing_Price
		$this->Purchasing_Price->ViewValue = $this->Purchasing_Price->CurrentValue;
		$this->Purchasing_Price->ViewValue = ew_FormatCurrency($this->Purchasing_Price->ViewValue, 2, -2, -2, -2);
		$this->Purchasing_Price->CellCssStyle .= "text-align: right;";
		$this->Purchasing_Price->ViewCustomAttributes = "";

		// Selling_Price
		$this->Selling_Price->ViewValue = $this->Selling_Price->CurrentValue;
		$this->Selling_Price->ViewValue = ew_FormatCurrency($this->Selling_Price->ViewValue, 2, -2, -2, -2);
		$this->Selling_Price->CellCssStyle .= "text-align: right;";
		$this->Selling_Price->ViewCustomAttributes = "";

		// Quantity
		$this->Quantity->ViewValue = $this->Quantity->CurrentValue;
		$this->Quantity->ViewValue = ew_FormatNumber($this->Quantity->ViewValue, 0, -2, -2, -2);
		$this->Quantity->CellCssStyle .= "text-align: right;";
		$this->Quantity->ViewCustomAttributes = "";

		// Notes
		$this->Notes->ViewValue = $this->Notes->CurrentValue;
		$this->Notes->ViewCustomAttributes = "";

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

			// Stock_ID
			$this->Stock_ID->LinkCustomAttributes = "";
			$this->Stock_ID->HrefValue = "";
			$this->Stock_ID->TooltipValue = "";

			// Category
			$this->Category->LinkCustomAttributes = "";
			$this->Category->HrefValue = "";
			$this->Category->TooltipValue = "";

			// Supplier_Number
			$this->Supplier_Number->LinkCustomAttributes = "";
			$this->Supplier_Number->HrefValue = "";
			$this->Supplier_Number->TooltipValue = "";

			// Stock_Number
			$this->Stock_Number->LinkCustomAttributes = "";
			$this->Stock_Number->HrefValue = "";
			$this->Stock_Number->TooltipValue = "";

			// Stock_Name
			$this->Stock_Name->LinkCustomAttributes = "";
			$this->Stock_Name->HrefValue = "";
			$this->Stock_Name->TooltipValue = "";

			// Unit_Of_Measurement
			$this->Unit_Of_Measurement->LinkCustomAttributes = "";
			$this->Unit_Of_Measurement->HrefValue = "";
			$this->Unit_Of_Measurement->TooltipValue = "";

			// Purchasing_Price
			$this->Purchasing_Price->LinkCustomAttributes = "";
			$this->Purchasing_Price->HrefValue = "";
			$this->Purchasing_Price->TooltipValue = "";

			// Selling_Price
			$this->Selling_Price->LinkCustomAttributes = "";
			$this->Selling_Price->HrefValue = "";
			$this->Selling_Price->TooltipValue = "";

			// Quantity
			$this->Quantity->LinkCustomAttributes = "";
			$this->Quantity->HrefValue = "";
			$this->Quantity->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Stock_ID
			$this->Stock_ID->EditAttrs["class"] = "form-control";
			$this->Stock_ID->EditCustomAttributes = "";
			$this->Stock_ID->EditValue = $this->Stock_ID->CurrentValue;
			$this->Stock_ID->ViewCustomAttributes = "";

			// Category
			$this->Category->EditAttrs["class"] = "form-control";
			$this->Category->EditCustomAttributes = "";
			if (trim(strval($this->Category->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Category_ID`" . ew_SearchString("=", $this->Category->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `Category_ID`, `Category_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_stock_categories`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `Category_ID`, `Category_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_stock_categories`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Category, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Category->EditValue = $arwrk;

			// Supplier_Number
			$this->Supplier_Number->EditAttrs["class"] = "form-control";
			$this->Supplier_Number->EditCustomAttributes = "";
			if ($this->Supplier_Number->getSessionValue() <> "") {
				$this->Supplier_Number->CurrentValue = $this->Supplier_Number->getSessionValue();
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
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Supplier_Name`";
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
			} else {
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
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Supplier_Number, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Supplier_Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Supplier_Number->EditValue = $arwrk;
			}

			// Stock_Number
			$this->Stock_Number->EditAttrs["class"] = "form-control";
			$this->Stock_Number->EditCustomAttributes = "";
			$this->Stock_Number->EditValue = ew_HtmlEncode($this->Stock_Number->CurrentValue);
			$this->Stock_Number->PlaceHolder = ew_RemoveHtml($this->Stock_Number->FldCaption());

			// Stock_Name
			$this->Stock_Name->EditAttrs["class"] = "form-control";
			$this->Stock_Name->EditCustomAttributes = "";
			$this->Stock_Name->EditValue = ew_HtmlEncode($this->Stock_Name->CurrentValue);
			$this->Stock_Name->PlaceHolder = ew_RemoveHtml($this->Stock_Name->FldCaption());

			// Unit_Of_Measurement
			$this->Unit_Of_Measurement->EditAttrs["class"] = "form-control";
			$this->Unit_Of_Measurement->EditCustomAttributes = "";
			if (trim(strval($this->Unit_Of_Measurement->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`UOM_ID`" . ew_SearchString("=", $this->Unit_Of_Measurement->CurrentValue, EW_DATATYPE_STRING, "");
			}
			switch (@$gsLanguage) {
				case "id":
					$sSqlWrk = "SELECT `UOM_ID`, `UOM_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_unit_of_measurement`";
					$sWhereWrk = "";
					break;
				default:
					$sSqlWrk = "SELECT `UOM_ID`, `UOM_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `a_unit_of_measurement`";
					$sWhereWrk = "";
					break;
			}
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Unit_Of_Measurement, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Unit_Of_Measurement->EditValue = $arwrk;

			// Purchasing_Price
			$this->Purchasing_Price->EditAttrs["class"] = "form-control";
			$this->Purchasing_Price->EditCustomAttributes = "";
			$this->Purchasing_Price->EditValue = ew_HtmlEncode($this->Purchasing_Price->CurrentValue);
			$this->Purchasing_Price->PlaceHolder = ew_RemoveHtml($this->Purchasing_Price->FldCaption());
			if (strval($this->Purchasing_Price->EditValue) <> "" && is_numeric($this->Purchasing_Price->EditValue)) $this->Purchasing_Price->EditValue = ew_FormatNumber($this->Purchasing_Price->EditValue, -2, -2, -2, -2);

			// Selling_Price
			$this->Selling_Price->EditAttrs["class"] = "form-control";
			$this->Selling_Price->EditCustomAttributes = "";
			$this->Selling_Price->EditValue = ew_HtmlEncode($this->Selling_Price->CurrentValue);
			$this->Selling_Price->PlaceHolder = ew_RemoveHtml($this->Selling_Price->FldCaption());
			if (strval($this->Selling_Price->EditValue) <> "" && is_numeric($this->Selling_Price->EditValue)) $this->Selling_Price->EditValue = ew_FormatNumber($this->Selling_Price->EditValue, -2, -2, -2, -2);

			// Quantity
			$this->Quantity->EditAttrs["class"] = "form-control";
			$this->Quantity->EditCustomAttributes = "";
			$this->Quantity->EditValue = ew_HtmlEncode($this->Quantity->CurrentValue);
			$this->Quantity->PlaceHolder = ew_RemoveHtml($this->Quantity->FldCaption());
			if (strval($this->Quantity->EditValue) <> "" && is_numeric($this->Quantity->EditValue)) $this->Quantity->EditValue = ew_FormatNumber($this->Quantity->EditValue, -2, -2, -2, -2);

			// Notes
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue = ew_HtmlEncode($this->Notes->CurrentValue);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

			// Date_Added
			$this->Date_Added->EditAttrs["class"] = "form-control";
			$this->Date_Added->EditCustomAttributes = "";

			// Added_By
			$this->Added_By->EditAttrs["class"] = "form-control";
			$this->Added_By->EditCustomAttributes = "";

			// Date_Updated
			// Updated_By
			// Edit refer script
			// Stock_ID

			$this->Stock_ID->LinkCustomAttributes = "";
			$this->Stock_ID->HrefValue = "";

			// Category
			$this->Category->LinkCustomAttributes = "";
			$this->Category->HrefValue = "";

			// Supplier_Number
			$this->Supplier_Number->LinkCustomAttributes = "";
			$this->Supplier_Number->HrefValue = "";

			// Stock_Number
			$this->Stock_Number->LinkCustomAttributes = "";
			$this->Stock_Number->HrefValue = "";

			// Stock_Name
			$this->Stock_Name->LinkCustomAttributes = "";
			$this->Stock_Name->HrefValue = "";

			// Unit_Of_Measurement
			$this->Unit_Of_Measurement->LinkCustomAttributes = "";
			$this->Unit_Of_Measurement->HrefValue = "";

			// Purchasing_Price
			$this->Purchasing_Price->LinkCustomAttributes = "";
			$this->Purchasing_Price->HrefValue = "";

			// Selling_Price
			$this->Selling_Price->LinkCustomAttributes = "";
			$this->Selling_Price->HrefValue = "";

			// Quantity
			$this->Quantity->LinkCustomAttributes = "";
			$this->Quantity->HrefValue = "";

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
		if (!$this->Category->FldIsDetailKey && !is_null($this->Category->FormValue) && $this->Category->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Category->FldCaption(), $this->Category->ReqErrMsg));
		}
		if (!$this->Supplier_Number->FldIsDetailKey && !is_null($this->Supplier_Number->FormValue) && $this->Supplier_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Supplier_Number->FldCaption(), $this->Supplier_Number->ReqErrMsg));
		}
		if (!$this->Stock_Number->FldIsDetailKey && !is_null($this->Stock_Number->FormValue) && $this->Stock_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Stock_Number->FldCaption(), $this->Stock_Number->ReqErrMsg));
		}
		if (!$this->Stock_Name->FldIsDetailKey && !is_null($this->Stock_Name->FormValue) && $this->Stock_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Stock_Name->FldCaption(), $this->Stock_Name->ReqErrMsg));
		}
		if (!$this->Unit_Of_Measurement->FldIsDetailKey && !is_null($this->Unit_Of_Measurement->FormValue) && $this->Unit_Of_Measurement->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Unit_Of_Measurement->FldCaption(), $this->Unit_Of_Measurement->ReqErrMsg));
		}
		if (!$this->Purchasing_Price->FldIsDetailKey && !is_null($this->Purchasing_Price->FormValue) && $this->Purchasing_Price->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Purchasing_Price->FldCaption(), $this->Purchasing_Price->ReqErrMsg));
		}
		if (!$this->Selling_Price->FldIsDetailKey && !is_null($this->Selling_Price->FormValue) && $this->Selling_Price->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Selling_Price->FldCaption(), $this->Selling_Price->ReqErrMsg));
		}
		if (!$this->Quantity->FldIsDetailKey && !is_null($this->Quantity->FormValue) && $this->Quantity->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Quantity->FldCaption(), $this->Quantity->ReqErrMsg));
		}
		if (!$this->Notes->FldIsDetailKey && !is_null($this->Notes->FormValue) && $this->Notes->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Notes->FldCaption(), $this->Notes->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("view_sales_details", $DetailTblVar) && $GLOBALS["view_sales_details"]->DetailEdit) {
			if (!isset($GLOBALS["view_sales_details_grid"])) $GLOBALS["view_sales_details_grid"] = new cview_sales_details_grid(); // get detail page object
			$GLOBALS["view_sales_details_grid"]->ValidateGridForm();
		}
		if (in_array("view_purchases_details", $DetailTblVar) && $GLOBALS["view_purchases_details"]->DetailEdit) {
			if (!isset($GLOBALS["view_purchases_details_grid"])) $GLOBALS["view_purchases_details_grid"] = new cview_purchases_details_grid(); // get detail page object
			$GLOBALS["view_purchases_details_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Category
			$this->Category->SetDbValueDef($rsnew, $this->Category->CurrentValue, 0, $this->Category->ReadOnly);

			// Supplier_Number
			$this->Supplier_Number->SetDbValueDef($rsnew, $this->Supplier_Number->CurrentValue, "", $this->Supplier_Number->ReadOnly);

			// Stock_Number
			$this->Stock_Number->SetDbValueDef($rsnew, $this->Stock_Number->CurrentValue, "", $this->Stock_Number->ReadOnly);

			// Stock_Name
			$this->Stock_Name->SetDbValueDef($rsnew, $this->Stock_Name->CurrentValue, "", $this->Stock_Name->ReadOnly);

			// Unit_Of_Measurement
			$this->Unit_Of_Measurement->SetDbValueDef($rsnew, $this->Unit_Of_Measurement->CurrentValue, "", $this->Unit_Of_Measurement->ReadOnly);

			// Purchasing_Price
			$this->Purchasing_Price->SetDbValueDef($rsnew, $this->Purchasing_Price->CurrentValue, 0, $this->Purchasing_Price->ReadOnly);

			// Selling_Price
			$this->Selling_Price->SetDbValueDef($rsnew, $this->Selling_Price->CurrentValue, 0, $this->Selling_Price->ReadOnly);

			// Quantity
			$this->Quantity->SetDbValueDef($rsnew, $this->Quantity->CurrentValue, 0, $this->Quantity->ReadOnly);

			// Notes
			$this->Notes->SetDbValueDef($rsnew, $this->Notes->CurrentValue, "", $this->Notes->ReadOnly);

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
					if (in_array("view_sales_details", $DetailTblVar) && $GLOBALS["view_sales_details"]->DetailEdit) {
						if (!isset($GLOBALS["view_sales_details_grid"])) $GLOBALS["view_sales_details_grid"] = new cview_sales_details_grid(); // Get detail page object
						$EditRow = $GLOBALS["view_sales_details_grid"]->GridUpdate();
					}
					if (in_array("view_purchases_details", $DetailTblVar) && $GLOBALS["view_purchases_details"]->DetailEdit) {
						if (!isset($GLOBALS["view_purchases_details_grid"])) $GLOBALS["view_purchases_details_grid"] = new cview_purchases_details_grid(); // Get detail page object
						$EditRow = $GLOBALS["view_purchases_details_grid"]->GridUpdate();
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
			if ($sMasterTblVar == "a_suppliers") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Supplier_Number"] <> "") {
					$GLOBALS["a_suppliers"]->Supplier_Number->setQueryStringValue($_GET["fk_Supplier_Number"]);
					$this->Supplier_Number->setQueryStringValue($GLOBALS["a_suppliers"]->Supplier_Number->QueryStringValue);
					$this->Supplier_Number->setSessionValue($this->Supplier_Number->QueryStringValue);
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
			if ($sMasterTblVar == "a_suppliers") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Supplier_Number"] <> "") {
					$GLOBALS["a_suppliers"]->Supplier_Number->setFormValue($_POST["fk_Supplier_Number"]);
					$this->Supplier_Number->setFormValue($GLOBALS["a_suppliers"]->Supplier_Number->FormValue);
					$this->Supplier_Number->setSessionValue($this->Supplier_Number->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "a_suppliers") {
				if ($this->Supplier_Number->CurrentValue == "") $this->Supplier_Number->setSessionValue("");
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
			if (in_array("view_sales_details", $DetailTblVar)) {
				if (!isset($GLOBALS["view_sales_details_grid"]))
					$GLOBALS["view_sales_details_grid"] = new cview_sales_details_grid;
				if ($GLOBALS["view_sales_details_grid"]->DetailEdit) {
					$GLOBALS["view_sales_details_grid"]->CurrentMode = "edit";
					$GLOBALS["view_sales_details_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["view_sales_details_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["view_sales_details_grid"]->setStartRecordNumber(1);
					$GLOBALS["view_sales_details_grid"]->Stock_Item->FldIsDetailKey = TRUE;
					$GLOBALS["view_sales_details_grid"]->Stock_Item->CurrentValue = $this->Stock_Number->CurrentValue;
					$GLOBALS["view_sales_details_grid"]->Stock_Item->setSessionValue($GLOBALS["view_sales_details_grid"]->Stock_Item->CurrentValue);
				}
			}
			if (in_array("view_purchases_details", $DetailTblVar)) {
				if (!isset($GLOBALS["view_purchases_details_grid"]))
					$GLOBALS["view_purchases_details_grid"] = new cview_purchases_details_grid;
				if ($GLOBALS["view_purchases_details_grid"]->DetailEdit) {
					$GLOBALS["view_purchases_details_grid"]->CurrentMode = "edit";
					$GLOBALS["view_purchases_details_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["view_purchases_details_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["view_purchases_details_grid"]->setStartRecordNumber(1);
					$GLOBALS["view_purchases_details_grid"]->Stock_Item->FldIsDetailKey = TRUE;
					$GLOBALS["view_purchases_details_grid"]->Stock_Item->CurrentValue = $this->Stock_Number->CurrentValue;
					$GLOBALS["view_purchases_details_grid"]->Stock_Item->setSessionValue($GLOBALS["view_purchases_details_grid"]->Stock_Item->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1); // v11.0.4
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_stock_itemslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($a_stock_items_edit)) $a_stock_items_edit = new ca_stock_items_edit();

// Page init
$a_stock_items_edit->Page_Init();

// Page main
$a_stock_items_edit->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_stock_items_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fa_stock_itemsedit = new ew_Form("fa_stock_itemsedit", "edit");

// Validate form
fa_stock_itemsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Category");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Category->FldCaption(), $a_stock_items->Category->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Supplier_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Supplier_Number->FldCaption(), $a_stock_items->Supplier_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Stock_Number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Stock_Number->FldCaption(), $a_stock_items->Stock_Number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Stock_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Stock_Name->FldCaption(), $a_stock_items->Stock_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Unit_Of_Measurement");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Unit_Of_Measurement->FldCaption(), $a_stock_items->Unit_Of_Measurement->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Purchasing_Price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Purchasing_Price->FldCaption(), $a_stock_items->Purchasing_Price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Selling_Price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Selling_Price->FldCaption(), $a_stock_items->Selling_Price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Quantity");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Quantity->FldCaption(), $a_stock_items->Quantity->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Notes");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_stock_items->Notes->FldCaption(), $a_stock_items->Notes->ReqErrMsg)) ?>");

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
fa_stock_itemsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_stock_itemsedit.ValidateRequired = true;
<?php } else { ?>
fa_stock_itemsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_stock_itemsedit.Lists["x_Category"] = {"LinkField":"x_Category_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Category_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_stock_itemsedit.Lists["x_Supplier_Number"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_stock_itemsedit.Lists["x_Unit_Of_Measurement"] = {"LinkField":"x_UOM_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_UOM_Description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $a_stock_items_edit->ShowPageHeader(); ?>
<?php
$a_stock_items_edit->ShowMessage();
?>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==1) || (MS_PAGINATION_POSITION==3) ) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($a_stock_items_edit->Pager)) $a_stock_items_edit->Pager = new cNumericPager($a_stock_items_edit->StartRec, $a_stock_items_edit->DisplayRecs, $a_stock_items_edit->TotalRecs, $a_stock_items_edit->RecRange) ?>
		<?php if ($a_stock_items_edit->Pager->RecordCount > 0) { ?>
				<?php if (($a_stock_items_edit->Pager->PageCount==1) && ($a_stock_items_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($a_stock_items_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_stock_items_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($a_stock_items_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $a_stock_items_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($a_stock_items_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_stock_items_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($a_stock_items_edit->Pager)) $a_stock_items_edit->Pager = new cPrevNextPager($a_stock_items_edit->StartRec, $a_stock_items_edit->DisplayRecs, $a_stock_items_edit->TotalRecs) ?>
		<?php if ($a_stock_items_edit->Pager->RecordCount > 0) { ?>
				<?php if (($a_stock_items_edit->Pager->PageCount==1) && ($a_stock_items_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($a_stock_items_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($a_stock_items_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $a_stock_items_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($a_stock_items_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($a_stock_items_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $a_stock_items_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
</form>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<form name="fa_stock_itemsedit" id="fa_stock_itemsedit" class="<?php echo $a_stock_items_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_stock_items_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_stock_items_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_stock_items">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($a_stock_items->getCurrentMasterTable() == "a_suppliers") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="a_suppliers">
<input type="hidden" name="fk_Supplier_Number" value="<?php echo $a_stock_items->Supplier_Number->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($a_stock_items->Stock_ID->Visible) { // Stock_ID ?>
	<div id="r_Stock_ID" class="form-group">
		<label id="elh_a_stock_items_Stock_ID" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Stock_ID->FldCaption() ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Stock_ID->CellAttributes() ?>>
<span id="el_a_stock_items_Stock_ID">
<span<?php echo $a_stock_items->Stock_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Stock_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="a_stock_items" data-field="x_Stock_ID" name="x_Stock_ID" id="x_Stock_ID" value="<?php echo ew_HtmlEncode($a_stock_items->Stock_ID->CurrentValue) ?>">
<?php echo $a_stock_items->Stock_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Category->Visible) { // Category ?>
	<div id="r_Category" class="form-group">
		<label id="elh_a_stock_items_Category" for="x_Category" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Category->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Category->CellAttributes() ?>>
<span id="el_a_stock_items_Category">
<select data-table="a_stock_items" data-field="x_Category" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Category->DisplayValueSeparator) ? json_encode($a_stock_items->Category->DisplayValueSeparator) : $a_stock_items->Category->DisplayValueSeparator) ?>" id="x_Category" name="x_Category"<?php echo $a_stock_items->Category->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Category->EditValue)) {
	$arwrk = $a_stock_items->Category->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Category->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_stock_items->Category->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_stock_items->Category->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_stock_items->Category->CurrentValue) ?>" selected><?php echo $a_stock_items->Category->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php if (AllowAdd(CurrentProjectID() . "a_stock_categories")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $a_stock_items->Category->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_Category',url:'a_stock_categoriesaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_Category"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $a_stock_items->Category->FldCaption() ?></span></button>
<?php } ?>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `Category_ID`, `Category_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_categories`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `Category_ID`, `Category_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_stock_categories`";
		$sWhereWrk = "";
		break;
}
$a_stock_items->Category->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_stock_items->Category->LookupFilters += array("f0" => "`Category_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$a_stock_items->Lookup_Selecting($a_stock_items->Category, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_stock_items->Category->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Category" id="s_x_Category" value="<?php echo $a_stock_items->Category->LookupFilterQuery() ?>">
</span>
<?php echo $a_stock_items->Category->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Supplier_Number->Visible) { // Supplier_Number ?>
	<div id="r_Supplier_Number" class="form-group">
		<label id="elh_a_stock_items_Supplier_Number" for="x_Supplier_Number" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Supplier_Number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Supplier_Number->CellAttributes() ?>>
<?php if ($a_stock_items->Supplier_Number->getSessionValue() <> "") { ?>
<span id="el_a_stock_items_Supplier_Number">
<span<?php echo $a_stock_items->Supplier_Number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $a_stock_items->Supplier_Number->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_Supplier_Number" name="x_Supplier_Number" value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->CurrentValue) ?>">
<?php } else { ?>
<span id="el_a_stock_items_Supplier_Number">
<select data-table="a_stock_items" data-field="x_Supplier_Number" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Supplier_Number->DisplayValueSeparator) ? json_encode($a_stock_items->Supplier_Number->DisplayValueSeparator) : $a_stock_items->Supplier_Number->DisplayValueSeparator) ?>" id="x_Supplier_Number" name="x_Supplier_Number"<?php echo $a_stock_items->Supplier_Number->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Supplier_Number->EditValue)) {
	$arwrk = $a_stock_items->Supplier_Number->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Supplier_Number->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_stock_items->Supplier_Number->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_stock_items->Supplier_Number->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_stock_items->Supplier_Number->CurrentValue) ?>" selected><?php echo $a_stock_items->Supplier_Number->CurrentValue ?></option>
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
$a_stock_items->Supplier_Number->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_stock_items->Supplier_Number->LookupFilters += array("f0" => "`Supplier_Number` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_stock_items->Lookup_Selecting($a_stock_items->Supplier_Number, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Supplier_Name`";
if ($sSqlWrk <> "") $a_stock_items->Supplier_Number->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Supplier_Number" id="s_x_Supplier_Number" value="<?php echo $a_stock_items->Supplier_Number->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $a_stock_items->Supplier_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Stock_Number->Visible) { // Stock_Number ?>
	<div id="r_Stock_Number" class="form-group">
		<label id="elh_a_stock_items_Stock_Number" for="x_Stock_Number" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Stock_Number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Stock_Number->CellAttributes() ?>>
<span id="el_a_stock_items_Stock_Number">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Number" name="x_Stock_Number" id="x_Stock_Number" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Number->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Number->EditValue ?>"<?php echo $a_stock_items->Stock_Number->EditAttributes() ?>>
</span>
<?php echo $a_stock_items->Stock_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Stock_Name->Visible) { // Stock_Name ?>
	<div id="r_Stock_Name" class="form-group">
		<label id="elh_a_stock_items_Stock_Name" for="x_Stock_Name" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Stock_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Stock_Name->CellAttributes() ?>>
<span id="el_a_stock_items_Stock_Name">
<input type="text" data-table="a_stock_items" data-field="x_Stock_Name" name="x_Stock_Name" id="x_Stock_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Stock_Name->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Stock_Name->EditValue ?>"<?php echo $a_stock_items->Stock_Name->EditAttributes() ?>>
</span>
<?php echo $a_stock_items->Stock_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Unit_Of_Measurement->Visible) { // Unit_Of_Measurement ?>
	<div id="r_Unit_Of_Measurement" class="form-group">
		<label id="elh_a_stock_items_Unit_Of_Measurement" for="x_Unit_Of_Measurement" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Unit_Of_Measurement->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Unit_Of_Measurement->CellAttributes() ?>>
<span id="el_a_stock_items_Unit_Of_Measurement">
<select data-table="a_stock_items" data-field="x_Unit_Of_Measurement" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_stock_items->Unit_Of_Measurement->DisplayValueSeparator) ? json_encode($a_stock_items->Unit_Of_Measurement->DisplayValueSeparator) : $a_stock_items->Unit_Of_Measurement->DisplayValueSeparator) ?>" id="x_Unit_Of_Measurement" name="x_Unit_Of_Measurement"<?php echo $a_stock_items->Unit_Of_Measurement->EditAttributes() ?>>
<?php
if (is_array($a_stock_items->Unit_Of_Measurement->EditValue)) {
	$arwrk = $a_stock_items->Unit_Of_Measurement->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_stock_items->Unit_Of_Measurement->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $a_stock_items->Unit_Of_Measurement->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($a_stock_items->Unit_Of_Measurement->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($a_stock_items->Unit_Of_Measurement->CurrentValue) ?>" selected><?php echo $a_stock_items->Unit_Of_Measurement->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php if (AllowAdd(CurrentProjectID() . "a_unit_of_measurement")) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $a_stock_items->Unit_Of_Measurement->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_Unit_Of_Measurement',url:'a_unit_of_measurementaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_Unit_Of_Measurement"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $a_stock_items->Unit_Of_Measurement->FldCaption() ?></span></button>
<?php } ?>
<?php
switch (@$gsLanguage) {
	case "id":
		$sSqlWrk = "SELECT `UOM_ID`, `UOM_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_unit_of_measurement`";
		$sWhereWrk = "";
		break;
	default:
		$sSqlWrk = "SELECT `UOM_ID`, `UOM_Description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `a_unit_of_measurement`";
		$sWhereWrk = "";
		break;
}
$a_stock_items->Unit_Of_Measurement->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$a_stock_items->Unit_Of_Measurement->LookupFilters += array("f0" => "`UOM_ID` = {filter_value}", "t0" => "200", "fn0" => "");
$sSqlWrk = "";
$a_stock_items->Lookup_Selecting($a_stock_items->Unit_Of_Measurement, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $a_stock_items->Unit_Of_Measurement->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_Unit_Of_Measurement" id="s_x_Unit_Of_Measurement" value="<?php echo $a_stock_items->Unit_Of_Measurement->LookupFilterQuery() ?>">
</span>
<?php echo $a_stock_items->Unit_Of_Measurement->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Purchasing_Price->Visible) { // Purchasing_Price ?>
	<div id="r_Purchasing_Price" class="form-group">
		<label id="elh_a_stock_items_Purchasing_Price" for="x_Purchasing_Price" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Purchasing_Price->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Purchasing_Price->CellAttributes() ?>>
<span id="el_a_stock_items_Purchasing_Price">
<input type="text" data-table="a_stock_items" data-field="x_Purchasing_Price" name="x_Purchasing_Price" id="x_Purchasing_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Purchasing_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Purchasing_Price->EditValue ?>"<?php echo $a_stock_items->Purchasing_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Purchasing_Price->ReadOnly && !$a_stock_items->Purchasing_Price->Disabled && @$a_stock_items->Purchasing_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Purchasing_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Purchasing_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_stock_items->Purchasing_Price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Selling_Price->Visible) { // Selling_Price ?>
	<div id="r_Selling_Price" class="form-group">
		<label id="elh_a_stock_items_Selling_Price" for="x_Selling_Price" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Selling_Price->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Selling_Price->CellAttributes() ?>>
<span id="el_a_stock_items_Selling_Price">
<input type="text" data-table="a_stock_items" data-field="x_Selling_Price" name="x_Selling_Price" id="x_Selling_Price" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Selling_Price->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Selling_Price->EditValue ?>"<?php echo $a_stock_items->Selling_Price->EditAttributes() ?>>
<?php if (!$a_stock_items->Selling_Price->ReadOnly && !$a_stock_items->Selling_Price->Disabled && @$a_stock_items->Selling_Price->EditAttrs["readonly"] == "" && @$a_stock_items->Selling_Price->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Selling_Price').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_stock_items->Selling_Price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Quantity->Visible) { // Quantity ?>
	<div id="r_Quantity" class="form-group">
		<label id="elh_a_stock_items_Quantity" for="x_Quantity" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Quantity->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Quantity->CellAttributes() ?>>
<span id="el_a_stock_items_Quantity">
<input type="text" data-table="a_stock_items" data-field="x_Quantity" name="x_Quantity" id="x_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Quantity->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Quantity->EditValue ?>"<?php echo $a_stock_items->Quantity->EditAttributes() ?>>
<?php if (!$a_stock_items->Quantity->ReadOnly && !$a_stock_items->Quantity->Disabled && @$a_stock_items->Quantity->EditAttrs["readonly"] == "" && @$a_stock_items->Quantity->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Quantity').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_stock_items->Quantity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_stock_items->Notes->Visible) { // Notes ?>
	<div id="r_Notes" class="form-group">
		<label id="elh_a_stock_items_Notes" for="x_Notes" class="col-sm-4 control-label ewLabel"><?php echo $a_stock_items->Notes->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-8"><div<?php echo $a_stock_items->Notes->CellAttributes() ?>>
<span id="el_a_stock_items_Notes">
<input type="text" data-table="a_stock_items" data-field="x_Notes" name="x_Notes" id="x_Notes" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_stock_items->Notes->getPlaceHolder()) ?>" value="<?php echo $a_stock_items->Notes->EditValue ?>"<?php echo $a_stock_items->Notes->EditAttributes() ?>>
</span>
<?php echo $a_stock_items->Notes->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<span id="el_a_stock_items_Date_Added">
<input type="hidden" data-table="a_stock_items" data-field="x_Date_Added" name="x_Date_Added" id="x_Date_Added" value="<?php echo ew_HtmlEncode($a_stock_items->Date_Added->CurrentValue) ?>">
</span>
<span id="el_a_stock_items_Added_By">
<input type="hidden" data-table="a_stock_items" data-field="x_Added_By" name="x_Added_By" id="x_Added_By" value="<?php echo ew_HtmlEncode($a_stock_items->Added_By->CurrentValue) ?>">
</span>
<?php
	if (in_array("view_sales_details", explode(",", $a_stock_items->getCurrentDetailTable())) && $view_sales_details->DetailEdit) {
?>
<?php if ($a_stock_items->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("view_sales_details", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "view_sales_detailsgrid.php" ?>
<?php } ?>
<?php
	if (in_array("view_purchases_details", explode(",", $a_stock_items->getCurrentDetailTable())) && $view_purchases_details->DetailEdit) {
?>
<?php if ($a_stock_items->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("view_purchases_details", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "view_purchases_detailsgrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $a_stock_items_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
<?php if ( (MS_PAGINATION_POSITION==2) || (MS_PAGINATION_POSITION==3) ) { ?>
	<?php if (MS_PAGINATION_STYLE==1) { // link ?>
		<?php if (!isset($a_stock_items_edit->Pager)) $a_stock_items_edit->Pager = new cNumericPager($a_stock_items_edit->StartRec, $a_stock_items_edit->DisplayRecs, $a_stock_items_edit->TotalRecs, $a_stock_items_edit->RecRange) ?>
		<?php if ($a_stock_items_edit->Pager->RecordCount > 0) { ?>
				<?php if (($a_stock_items_edit->Pager->PageCount==1) && ($a_stock_items_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
				<div class="ewPager">
				<div class="ewNumericPage"><ul class="pagination">
					<?php if ($a_stock_items_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_stock_items_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } else { // else of rtl { ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } // end of rtl { ?>
					<?php } ?>
					<?php foreach ($a_stock_items_edit->Pager->Items as $PagerItem) { ?>
						<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $a_stock_items_edit->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
					<?php } ?>
					<?php if ($a_stock_items_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
					<?php if ($a_stock_items_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
					<?php } else { // else of rtl ?>
					<li><a href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
					<?php } // end of rtl ?>
					<?php } ?>
				</ul></div>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE ?>
		<?php } ?>	
	<?php } elseif (MS_PAGINATION_STYLE==2) { // button ?>
		<?php if (!isset($a_stock_items_edit->Pager)) $a_stock_items_edit->Pager = new cPrevNextPager($a_stock_items_edit->StartRec, $a_stock_items_edit->DisplayRecs, $a_stock_items_edit->TotalRecs) ?>
		<?php if ($a_stock_items_edit->Pager->RecordCount > 0) { ?>
				<?php if (($a_stock_items_edit->Pager->PageCount==1) && ($a_stock_items_edit->Pager->CurrentPage == 1) && (MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE)  ) { ?>
				<?php } else { // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
				<div class="ewPager">
				<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
				<div class="ewPrevNext"><div class="input-group">
				<div class="input-group-btn">
				<!--first page button-->
					<?php if ($a_stock_items_edit->Pager->FirstButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->FirstButton->Start ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-last ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--previous page button-->
					<?php if ($a_stock_items_edit->Pager->PrevButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->PrevButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
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
					<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $a_stock_items_edit->Pager->CurrentPage ?>">
				<div class="input-group-btn">
				<!--next page button-->
					<?php if ($a_stock_items_edit->Pager->NextButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->NextButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } else { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-prev ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
					<?php } // end of rtl ?>
					<?php } ?>
				<!--last page button-->
					<?php if ($a_stock_items_edit->Pager->LastButton->Enabled) { ?>
					<?php if ($Language->Phrase("dir") == "rtl") { // begin of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->LastButton->Start ?>"><span class="icon-first ewIcon"></span></a>
					<?php } else { // else of rtl ?>
					<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $a_stock_items_edit->PageUrl() ?>start=<?php echo $a_stock_items_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
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
				<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $a_stock_items_edit->Pager->PageCount ?></span>
				</div>
				<?php } // end MS_SHOW_PAGENUM_IF_REC_NOT_OVER_PAGESIZE==FALSE ?>
		<?php } ?>
	<?php } // end of link or button ?>	
<div class="clearfix"></div>
<?php } ?>
<?php // End of modification Customize Navigation/Pager Panel, by Masino Sinaga, May 2, 2012 ?>
</form>
<script type="text/javascript">
fa_stock_itemsedit.Init();
</script>
<?php
$a_stock_items_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_stock_itemsedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($a_stock_items->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyEdit(this)'); function alertifyEdit(obj) { <?php global $Language; ?> if (fa_stock_itemsedit.Validate() == true ) { alertify.confirm("<?php echo $Language->Phrase('AlertifyEditConfirm'); ?>", function (e) {	if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyEdit'); ?>"); $("#fa_stock_itemsedit").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_stock_items_edit->Page_Terminate();
?>
