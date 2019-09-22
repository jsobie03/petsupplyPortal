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

$a_payment_transactions_delete = NULL; // Initialize page object first

class ca_payment_transactions_delete extends ca_payment_transactions {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_payment_transactions';

	// Page object name
	var $PageObjName = 'a_payment_transactions_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("a_payment_transactionslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in a_payment_transactions class, a_payment_transactionsinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Payment_ID'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"]; // v11.0.4
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url); // v11.0.4
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($a_payment_transactions_delete)) $a_payment_transactions_delete = new ca_payment_transactions_delete();

// Page init
$a_payment_transactions_delete->Page_Init();

// Page main
$a_payment_transactions_delete->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_payment_transactions_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fa_payment_transactionsdelete = new ew_Form("fa_payment_transactionsdelete", "delete");

// Form_CustomValidate event
fa_payment_transactionsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_payment_transactionsdelete.ValidateRequired = true;
<?php } else { ?>
fa_payment_transactionsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_payment_transactionsdelete.Lists["x_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_payment_transactionsdelete.Lists["x_Type"].Options = <?php echo json_encode($a_payment_transactions->Type->Options()) ?>;
fa_payment_transactionsdelete.Lists["x_Customer"] = {"LinkField":"x_Customer_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_payment_transactionsdelete.Lists["x_Supplier"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($a_payment_transactions_delete->Recordset = $a_payment_transactions_delete->LoadRecordset())
	$a_payment_transactions_deleteTotalRecs = $a_payment_transactions_delete->Recordset->RecordCount(); // Get record count
if ($a_payment_transactions_deleteTotalRecs <= 0) { // No record found, exit
	if ($a_payment_transactions_delete->Recordset)
		$a_payment_transactions_delete->Recordset->Close();
	$a_payment_transactions_delete->Page_Terminate("a_payment_transactionslist.php"); // Return to list
}
?>
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
<?php $a_payment_transactions_delete->ShowPageHeader(); ?>
<?php
$a_payment_transactions_delete->ShowMessage();
?>
<form name="fa_payment_transactionsdelete" id="fa_payment_transactionsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_payment_transactions_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_payment_transactions_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_payment_transactions">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($a_payment_transactions_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $a_payment_transactions->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($a_payment_transactions->Ref_ID->Visible) { // Ref_ID ?>
		<th><span id="elh_a_payment_transactions_Ref_ID" class="a_payment_transactions_Ref_ID"><?php echo $a_payment_transactions->Ref_ID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_payment_transactions->Type->Visible) { // Type ?>
		<th><span id="elh_a_payment_transactions_Type" class="a_payment_transactions_Type"><?php echo $a_payment_transactions->Type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_payment_transactions->Customer->Visible) { // Customer ?>
		<th><span id="elh_a_payment_transactions_Customer" class="a_payment_transactions_Customer"><?php echo $a_payment_transactions->Customer->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_payment_transactions->Supplier->Visible) { // Supplier ?>
		<th><span id="elh_a_payment_transactions_Supplier" class="a_payment_transactions_Supplier"><?php echo $a_payment_transactions->Supplier->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_payment_transactions->Sub_Total->Visible) { // Sub_Total ?>
		<th><span id="elh_a_payment_transactions_Sub_Total" class="a_payment_transactions_Sub_Total"><?php echo $a_payment_transactions->Sub_Total->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_payment_transactions->Payment->Visible) { // Payment ?>
		<th><span id="elh_a_payment_transactions_Payment" class="a_payment_transactions_Payment"><?php echo $a_payment_transactions->Payment->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_payment_transactions->Balance->Visible) { // Balance ?>
		<th><span id="elh_a_payment_transactions_Balance" class="a_payment_transactions_Balance"><?php echo $a_payment_transactions->Balance->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_payment_transactions->Due_Date->Visible) { // Due_Date ?>
		<th><span id="elh_a_payment_transactions_Due_Date" class="a_payment_transactions_Due_Date"><?php echo $a_payment_transactions->Due_Date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($a_payment_transactions->Date_Transaction->Visible) { // Date_Transaction ?>
		<th><span id="elh_a_payment_transactions_Date_Transaction" class="a_payment_transactions_Date_Transaction"><?php echo $a_payment_transactions->Date_Transaction->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$a_payment_transactions_delete->RecCnt = 0;
$i = 0;
while (!$a_payment_transactions_delete->Recordset->EOF) {
	$a_payment_transactions_delete->RecCnt++;
	$a_payment_transactions_delete->RowCnt++;

	// Set row properties
	$a_payment_transactions->ResetAttrs();
	$a_payment_transactions->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$a_payment_transactions_delete->LoadRowValues($a_payment_transactions_delete->Recordset);

	// Render row
	$a_payment_transactions_delete->RenderRow();
?>
	<tr<?php echo $a_payment_transactions->RowAttributes() ?>>
<?php if ($a_payment_transactions->Ref_ID->Visible) { // Ref_ID ?>
		<td<?php echo $a_payment_transactions->Ref_ID->CellAttributes() ?>>
<span id="el<?php echo $a_payment_transactions_delete->RowCnt ?>_a_payment_transactions_Ref_ID" class="a_payment_transactions_Ref_ID">
<span<?php echo $a_payment_transactions->Ref_ID->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Ref_ID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_payment_transactions->Type->Visible) { // Type ?>
		<td<?php echo $a_payment_transactions->Type->CellAttributes() ?>>
<span id="el<?php echo $a_payment_transactions_delete->RowCnt ?>_a_payment_transactions_Type" class="a_payment_transactions_Type">
<span<?php echo $a_payment_transactions->Type->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_payment_transactions->Customer->Visible) { // Customer ?>
		<td<?php echo $a_payment_transactions->Customer->CellAttributes() ?>>
<span id="el<?php echo $a_payment_transactions_delete->RowCnt ?>_a_payment_transactions_Customer" class="a_payment_transactions_Customer">
<span<?php echo $a_payment_transactions->Customer->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Customer->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_payment_transactions->Supplier->Visible) { // Supplier ?>
		<td<?php echo $a_payment_transactions->Supplier->CellAttributes() ?>>
<span id="el<?php echo $a_payment_transactions_delete->RowCnt ?>_a_payment_transactions_Supplier" class="a_payment_transactions_Supplier">
<span<?php echo $a_payment_transactions->Supplier->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Supplier->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_payment_transactions->Sub_Total->Visible) { // Sub_Total ?>
		<td<?php echo $a_payment_transactions->Sub_Total->CellAttributes() ?>>
<span id="el<?php echo $a_payment_transactions_delete->RowCnt ?>_a_payment_transactions_Sub_Total" class="a_payment_transactions_Sub_Total">
<span<?php echo $a_payment_transactions->Sub_Total->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Sub_Total->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_payment_transactions->Payment->Visible) { // Payment ?>
		<td<?php echo $a_payment_transactions->Payment->CellAttributes() ?>>
<span id="el<?php echo $a_payment_transactions_delete->RowCnt ?>_a_payment_transactions_Payment" class="a_payment_transactions_Payment">
<span<?php echo $a_payment_transactions->Payment->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Payment->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_payment_transactions->Balance->Visible) { // Balance ?>
		<td<?php echo $a_payment_transactions->Balance->CellAttributes() ?>>
<span id="el<?php echo $a_payment_transactions_delete->RowCnt ?>_a_payment_transactions_Balance" class="a_payment_transactions_Balance">
<span<?php echo $a_payment_transactions->Balance->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Balance->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_payment_transactions->Due_Date->Visible) { // Due_Date ?>
		<td<?php echo $a_payment_transactions->Due_Date->CellAttributes() ?>>
<span id="el<?php echo $a_payment_transactions_delete->RowCnt ?>_a_payment_transactions_Due_Date" class="a_payment_transactions_Due_Date">
<span<?php echo $a_payment_transactions->Due_Date->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Due_Date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_payment_transactions->Date_Transaction->Visible) { // Date_Transaction ?>
		<td<?php echo $a_payment_transactions->Date_Transaction->CellAttributes() ?>>
<span id="el<?php echo $a_payment_transactions_delete->RowCnt ?>_a_payment_transactions_Date_Transaction" class="a_payment_transactions_Date_Transaction">
<span<?php echo $a_payment_transactions->Date_Transaction->ViewAttributes() ?>>
<?php echo $a_payment_transactions->Date_Transaction->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$a_payment_transactions_delete->Recordset->MoveNext();
}
$a_payment_transactions_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $a_payment_transactions_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fa_payment_transactionsdelete.Init();
</script>
<?php
$a_payment_transactions_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if ($a_payment_transactions->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyDelete(this)'); function alertifyDelete(obj) { <?php global $Language; ?> if (fa_payment_transactionsdelete.Validate() == true ) { alertify.confirm("<?php echo  $Language->Phrase('AlertifyDeleteConfirm'); ?>", function (e) { if (e) {	$(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyDelete'); ?>"); $("#fa_payment_transactionsdelete").submit(); } }).set("title", "<?php echo $Language->Phrase('AlertifyConfirm'); ?>").set("defaultFocus", "cancel").set('oncancel', function(closeEvent){ alertify.error('<?php echo $Language->Phrase('AlertifyCancel'); ?>');}).set('labels', {ok:'<?php echo $Language->Phrase("MyOKMessage"); ?>!', cancel:'<?php echo $Language->Phrase("MyCancelMessage"); ?>'}); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_payment_transactions_delete->Page_Terminate();
?>
