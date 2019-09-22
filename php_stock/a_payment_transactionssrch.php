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

$a_payment_transactions_search = NULL; // Initialize page object first

class ca_payment_transactions_search extends ca_payment_transactions {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_payment_transactions';

	// Page object name
	var $PageObjName = 'a_payment_transactions_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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
		if (!$Security->CanSearch()) {
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
		$this->Payment_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $SearchLabelClass = "col-sm-3 control-label ewLabel";
	var $SearchRightColumnClass = "col-sm-9";

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "a_payment_transactionslist.php" . "?" . $sSrchStr;
						if ($this->IsModal) {
							$row = array();
							$row["url"] = $sSrchStr;
							echo ew_ArrayToJson(array($row));
							$this->Page_Terminate();
							exit();
						} else {
							$this->Page_Terminate($sSrchStr); // Go to list page
						}
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->Payment_ID); // Payment_ID
		$this->BuildSearchUrl($sSrchUrl, $this->Ref_ID); // Ref_ID
		$this->BuildSearchUrl($sSrchUrl, $this->Type); // Type
		$this->BuildSearchUrl($sSrchUrl, $this->Customer); // Customer
		$this->BuildSearchUrl($sSrchUrl, $this->Supplier); // Supplier
		$this->BuildSearchUrl($sSrchUrl, $this->Sub_Total); // Sub_Total
		$this->BuildSearchUrl($sSrchUrl, $this->Payment); // Payment
		$this->BuildSearchUrl($sSrchUrl, $this->Balance); // Balance
		$this->BuildSearchUrl($sSrchUrl, $this->Due_Date); // Due_Date
		$this->BuildSearchUrl($sSrchUrl, $this->Date_Transaction); // Date_Transaction
		$this->BuildSearchUrl($sSrchUrl, $this->Date_Added); // Date_Added
		$this->BuildSearchUrl($sSrchUrl, $this->Added_By); // Added_By
		$this->BuildSearchUrl($sSrchUrl, $this->Date_Updated); // Date_Updated
		$this->BuildSearchUrl($sSrchUrl, $this->Updated_By); // Updated_By
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// Payment_ID

		$this->Payment_ID->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Payment_ID"));
		$this->Payment_ID->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Payment_ID");
		$this->Payment_ID->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Payment_ID");
		$this->Payment_ID->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Payment_ID"));
		$this->Payment_ID->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Payment_ID");

		// Ref_ID
		$this->Ref_ID->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Ref_ID"));
		$this->Ref_ID->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Ref_ID");
		$this->Ref_ID->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Ref_ID");
		$this->Ref_ID->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Ref_ID"));
		$this->Ref_ID->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Ref_ID");

		// Type
		$this->Type->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Type"));
		$this->Type->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Type");
		$this->Type->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Type");
		$this->Type->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Type"));
		$this->Type->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Type");

		// Customer
		$this->Customer->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Customer"));
		$this->Customer->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Customer");
		$this->Customer->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Customer");
		$this->Customer->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Customer"));
		$this->Customer->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Customer");

		// Supplier
		$this->Supplier->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Supplier"));
		$this->Supplier->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Supplier");
		$this->Supplier->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Supplier");
		$this->Supplier->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Supplier"));
		$this->Supplier->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Supplier");

		// Sub_Total
		$this->Sub_Total->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Sub_Total"));
		$this->Sub_Total->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Sub_Total");
		$this->Sub_Total->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Sub_Total");
		$this->Sub_Total->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Sub_Total"));
		$this->Sub_Total->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Sub_Total");

		// Payment
		$this->Payment->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Payment"));
		$this->Payment->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Payment");
		$this->Payment->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Payment");
		$this->Payment->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Payment"));
		$this->Payment->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Payment");

		// Balance
		$this->Balance->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Balance"));
		$this->Balance->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Balance");
		$this->Balance->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Balance");
		$this->Balance->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Balance"));
		$this->Balance->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Balance");

		// Due_Date
		$this->Due_Date->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Due_Date"));
		$this->Due_Date->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Due_Date");
		$this->Due_Date->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Due_Date");
		$this->Due_Date->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Due_Date"));
		$this->Due_Date->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Due_Date");

		// Date_Transaction
		$this->Date_Transaction->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Date_Transaction"));
		$this->Date_Transaction->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Date_Transaction");
		$this->Date_Transaction->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Date_Transaction");
		$this->Date_Transaction->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Date_Transaction"));
		$this->Date_Transaction->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Date_Transaction");

		// Date_Added
		$this->Date_Added->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Date_Added"));
		$this->Date_Added->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Date_Added");
		$this->Date_Added->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Date_Added");
		$this->Date_Added->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Date_Added"));
		$this->Date_Added->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Date_Added");

		// Added_By
		$this->Added_By->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Added_By"));
		$this->Added_By->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Added_By");
		$this->Added_By->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Added_By");
		$this->Added_By->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Added_By"));
		$this->Added_By->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Added_By");

		// Date_Updated
		$this->Date_Updated->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Date_Updated"));
		$this->Date_Updated->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Date_Updated");
		$this->Date_Updated->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Date_Updated");
		$this->Date_Updated->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Date_Updated"));
		$this->Date_Updated->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Date_Updated");

		// Updated_By
		$this->Updated_By->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Updated_By"));
		$this->Updated_By->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Updated_By");
		$this->Updated_By->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Updated_By");
		$this->Updated_By->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Updated_By"));
		$this->Updated_By->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Updated_By");
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

		// Payment_ID
		$this->Payment_ID->ViewValue = $this->Payment_ID->CurrentValue;
		$this->Payment_ID->ViewCustomAttributes = "";

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

			// Payment_ID
			$this->Payment_ID->LinkCustomAttributes = "";
			$this->Payment_ID->HrefValue = "";
			$this->Payment_ID->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Payment_ID
			$this->Payment_ID->EditAttrs["class"] = "form-control";
			$this->Payment_ID->EditCustomAttributes = "";
			$this->Payment_ID->EditValue = ew_HtmlEncode($this->Payment_ID->AdvancedSearch->SearchValue);
			$this->Payment_ID->PlaceHolder = ew_RemoveHtml($this->Payment_ID->FldCaption());
			$this->Payment_ID->EditAttrs["class"] = "form-control";
			$this->Payment_ID->EditCustomAttributes = "";
			$this->Payment_ID->EditValue2 = ew_HtmlEncode($this->Payment_ID->AdvancedSearch->SearchValue2);
			$this->Payment_ID->PlaceHolder = ew_RemoveHtml($this->Payment_ID->FldCaption());

			// Ref_ID
			$this->Ref_ID->EditAttrs["class"] = "form-control";
			$this->Ref_ID->EditCustomAttributes = "";
			$this->Ref_ID->EditValue = ew_HtmlEncode($this->Ref_ID->AdvancedSearch->SearchValue);
			$this->Ref_ID->PlaceHolder = ew_RemoveHtml($this->Ref_ID->FldCaption());
			$this->Ref_ID->EditAttrs["class"] = "form-control";
			$this->Ref_ID->EditCustomAttributes = "";
			$this->Ref_ID->EditValue2 = ew_HtmlEncode($this->Ref_ID->AdvancedSearch->SearchValue2);
			$this->Ref_ID->PlaceHolder = ew_RemoveHtml($this->Ref_ID->FldCaption());

			// Type
			$this->Type->EditCustomAttributes = "";
			$this->Type->EditValue = $this->Type->Options(FALSE);
			$this->Type->EditCustomAttributes = "";
			$this->Type->EditValue2 = $this->Type->Options(FALSE);

			// Customer
			$this->Customer->EditAttrs["class"] = "form-control";
			$this->Customer->EditCustomAttributes = "";
			if (trim(strval($this->Customer->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
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
			$this->Customer->EditAttrs["class"] = "form-control";
			$this->Customer->EditCustomAttributes = "";
			if (trim(strval($this->Customer->AdvancedSearch->SearchValue2)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer->AdvancedSearch->SearchValue2, EW_DATATYPE_STRING, "");
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
			$this->Customer->EditValue2 = $arwrk;

			// Supplier
			$this->Supplier->EditAttrs["class"] = "form-control";
			$this->Supplier->EditCustomAttributes = "";
			if (trim(strval($this->Supplier->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
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
			$this->Supplier->EditAttrs["class"] = "form-control";
			$this->Supplier->EditCustomAttributes = "";
			if (trim(strval($this->Supplier->AdvancedSearch->SearchValue2)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Supplier_Number`" . ew_SearchString("=", $this->Supplier->AdvancedSearch->SearchValue2, EW_DATATYPE_STRING, "");
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
			$this->Supplier->EditValue2 = $arwrk;

			// Sub_Total
			$this->Sub_Total->EditAttrs["class"] = "form-control";
			$this->Sub_Total->EditCustomAttributes = "";
			$this->Sub_Total->EditValue = ew_HtmlEncode($this->Sub_Total->AdvancedSearch->SearchValue);
			$this->Sub_Total->PlaceHolder = ew_RemoveHtml($this->Sub_Total->FldCaption());
			$this->Sub_Total->EditAttrs["class"] = "form-control";
			$this->Sub_Total->EditCustomAttributes = "";
			$this->Sub_Total->EditValue2 = ew_HtmlEncode($this->Sub_Total->AdvancedSearch->SearchValue2);
			$this->Sub_Total->PlaceHolder = ew_RemoveHtml($this->Sub_Total->FldCaption());

			// Payment
			$this->Payment->EditAttrs["class"] = "form-control";
			$this->Payment->EditCustomAttributes = "";
			$this->Payment->EditValue = ew_HtmlEncode($this->Payment->AdvancedSearch->SearchValue);
			$this->Payment->PlaceHolder = ew_RemoveHtml($this->Payment->FldCaption());
			$this->Payment->EditAttrs["class"] = "form-control";
			$this->Payment->EditCustomAttributes = "";
			$this->Payment->EditValue2 = ew_HtmlEncode($this->Payment->AdvancedSearch->SearchValue2);
			$this->Payment->PlaceHolder = ew_RemoveHtml($this->Payment->FldCaption());

			// Balance
			$this->Balance->EditAttrs["class"] = "form-control";
			$this->Balance->EditCustomAttributes = "";
			$this->Balance->EditValue = ew_HtmlEncode($this->Balance->AdvancedSearch->SearchValue);
			$this->Balance->PlaceHolder = ew_RemoveHtml($this->Balance->FldCaption());
			$this->Balance->EditAttrs["class"] = "form-control";
			$this->Balance->EditCustomAttributes = "";
			$this->Balance->EditValue2 = ew_HtmlEncode($this->Balance->AdvancedSearch->SearchValue2);
			$this->Balance->PlaceHolder = ew_RemoveHtml($this->Balance->FldCaption());

			// Due_Date
			$this->Due_Date->EditAttrs["class"] = "form-control";
			$this->Due_Date->EditCustomAttributes = "";
			$this->Due_Date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Due_Date->AdvancedSearch->SearchValue, 5), 5));
			$this->Due_Date->PlaceHolder = ew_RemoveHtml($this->Due_Date->FldCaption());
			$this->Due_Date->EditAttrs["class"] = "form-control";
			$this->Due_Date->EditCustomAttributes = "";
			$this->Due_Date->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Due_Date->AdvancedSearch->SearchValue2, 5), 5));
			$this->Due_Date->PlaceHolder = ew_RemoveHtml($this->Due_Date->FldCaption());

			// Date_Transaction
			$this->Date_Transaction->EditAttrs["class"] = "form-control";
			$this->Date_Transaction->EditCustomAttributes = "";
			$this->Date_Transaction->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Date_Transaction->AdvancedSearch->SearchValue, 5), 5));
			$this->Date_Transaction->PlaceHolder = ew_RemoveHtml($this->Date_Transaction->FldCaption());
			$this->Date_Transaction->EditAttrs["class"] = "form-control";
			$this->Date_Transaction->EditCustomAttributes = "";
			$this->Date_Transaction->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Date_Transaction->AdvancedSearch->SearchValue2, 5), 5));
			$this->Date_Transaction->PlaceHolder = ew_RemoveHtml($this->Date_Transaction->FldCaption());

			// Date_Added
			$this->Date_Added->EditAttrs["class"] = "form-control";
			$this->Date_Added->EditCustomAttributes = "";
			$this->Date_Added->EditValue = ew_HtmlEncode(ew_UnFormatDateTime($this->Date_Added->AdvancedSearch->SearchValue, 0));
			$this->Date_Added->PlaceHolder = ew_RemoveHtml($this->Date_Added->FldCaption());
			$this->Date_Added->EditAttrs["class"] = "form-control";
			$this->Date_Added->EditCustomAttributes = "";
			$this->Date_Added->EditValue2 = ew_HtmlEncode(ew_UnFormatDateTime($this->Date_Added->AdvancedSearch->SearchValue2, 0));
			$this->Date_Added->PlaceHolder = ew_RemoveHtml($this->Date_Added->FldCaption());

			// Added_By
			$this->Added_By->EditAttrs["class"] = "form-control";
			$this->Added_By->EditCustomAttributes = "";
			$this->Added_By->EditValue = ew_HtmlEncode($this->Added_By->AdvancedSearch->SearchValue);
			$this->Added_By->PlaceHolder = ew_RemoveHtml($this->Added_By->FldCaption());
			$this->Added_By->EditAttrs["class"] = "form-control";
			$this->Added_By->EditCustomAttributes = "";
			$this->Added_By->EditValue2 = ew_HtmlEncode($this->Added_By->AdvancedSearch->SearchValue2);
			$this->Added_By->PlaceHolder = ew_RemoveHtml($this->Added_By->FldCaption());

			// Date_Updated
			$this->Date_Updated->EditAttrs["class"] = "form-control";
			$this->Date_Updated->EditCustomAttributes = "";
			$this->Date_Updated->EditValue = ew_HtmlEncode(ew_UnFormatDateTime($this->Date_Updated->AdvancedSearch->SearchValue, 0));
			$this->Date_Updated->PlaceHolder = ew_RemoveHtml($this->Date_Updated->FldCaption());
			$this->Date_Updated->EditAttrs["class"] = "form-control";
			$this->Date_Updated->EditCustomAttributes = "";
			$this->Date_Updated->EditValue2 = ew_HtmlEncode(ew_UnFormatDateTime($this->Date_Updated->AdvancedSearch->SearchValue2, 0));
			$this->Date_Updated->PlaceHolder = ew_RemoveHtml($this->Date_Updated->FldCaption());

			// Updated_By
			$this->Updated_By->EditAttrs["class"] = "form-control";
			$this->Updated_By->EditCustomAttributes = "";
			$this->Updated_By->EditValue = ew_HtmlEncode($this->Updated_By->AdvancedSearch->SearchValue);
			$this->Updated_By->PlaceHolder = ew_RemoveHtml($this->Updated_By->FldCaption());
			$this->Updated_By->EditAttrs["class"] = "form-control";
			$this->Updated_By->EditCustomAttributes = "";
			$this->Updated_By->EditValue2 = ew_HtmlEncode($this->Updated_By->AdvancedSearch->SearchValue2);
			$this->Updated_By->PlaceHolder = ew_RemoveHtml($this->Updated_By->FldCaption());
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($this->Payment_ID->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Payment_ID->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Payment_ID->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Payment_ID->FldErrMsg());
		}
		if (!ew_CheckRange($this->Payment->AdvancedSearch->SearchValue, 1, 999999999)) {
			ew_AddMessage($gsSearchError, $this->Payment->FldErrMsg());
		}
		if (!ew_CheckRange($this->Payment->AdvancedSearch->SearchValue2, 1, 999999999)) {
			ew_AddMessage($gsSearchError, $this->Payment->FldErrMsg());
		}
		if (!ew_CheckDate($this->Due_Date->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Due_Date->FldErrMsg());
		}
		if (!ew_CheckDate($this->Due_Date->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Due_Date->FldErrMsg());
		}
		if (!ew_CheckDate($this->Date_Transaction->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Date_Transaction->FldErrMsg());
		}
		if (!ew_CheckDate($this->Date_Transaction->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Date_Transaction->FldErrMsg());
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Payment_ID->AdvancedSearch->Load();
		$this->Ref_ID->AdvancedSearch->Load();
		$this->Type->AdvancedSearch->Load();
		$this->Customer->AdvancedSearch->Load();
		$this->Supplier->AdvancedSearch->Load();
		$this->Sub_Total->AdvancedSearch->Load();
		$this->Payment->AdvancedSearch->Load();
		$this->Balance->AdvancedSearch->Load();
		$this->Due_Date->AdvancedSearch->Load();
		$this->Date_Transaction->AdvancedSearch->Load();
		$this->Date_Added->AdvancedSearch->Load();
		$this->Added_By->AdvancedSearch->Load();
		$this->Date_Updated->AdvancedSearch->Load();
		$this->Updated_By->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_payment_transactionslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
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
if (!isset($a_payment_transactions_search)) $a_payment_transactions_search = new ca_payment_transactions_search();

// Page init
$a_payment_transactions_search->Page_Init();

// Page main
$a_payment_transactions_search->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_payment_transactions_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($a_payment_transactions_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fa_payment_transactionssearch = new ew_Form("fa_payment_transactionssearch", "search");
<?php } else { ?>
var CurrentForm = fa_payment_transactionssearch = new ew_Form("fa_payment_transactionssearch", "search");
<?php } ?>

// Form_CustomValidate event
fa_payment_transactionssearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_payment_transactionssearch.ValidateRequired = true;
<?php } else { ?>
fa_payment_transactionssearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_payment_transactionssearch.Lists["x_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_payment_transactionssearch.Lists["x_Type"].Options = <?php echo json_encode($a_payment_transactions->Type->Options()) ?>;
fa_payment_transactionssearch.Lists["x_Customer"] = {"LinkField":"x_Customer_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_payment_transactionssearch.Lists["x_Supplier"] = {"LinkField":"x_Supplier_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Supplier_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
// Validate function for search

fa_payment_transactionssearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Payment_ID");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($a_payment_transactions->Payment_ID->FldErrMsg()) ?>");
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
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$a_payment_transactions_search->IsModal) { ?>
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
<?php } ?>
<?php $a_payment_transactions_search->ShowPageHeader(); ?>
<?php
$a_payment_transactions_search->ShowMessage();
?>
<form name="fa_payment_transactionssearch" id="fa_payment_transactionssearch" class="<?php echo $a_payment_transactions_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_payment_transactions_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_payment_transactions_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_payment_transactions">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($a_payment_transactions_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($a_payment_transactions->Payment_ID->Visible) { // Payment_ID ?>
	<div id="r_Payment_ID" class="form-group">
		<label for="x_Payment_ID" class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Payment_ID"><?php echo $a_payment_transactions->Payment_ID->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Payment_ID->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Payment_ID" id="z_Payment_ID" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Payment_ID->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Payment_ID->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Payment_ID->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Payment_ID->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Payment_ID->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Payment_ID->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Payment_ID->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Payment_ID->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Payment_ID->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Payment_ID">
<input type="text" data-table="a_payment_transactions" data-field="x_Payment_ID" name="x_Payment_ID" id="x_Payment_ID" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Payment_ID->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Payment_ID->EditValue ?>"<?php echo $a_payment_transactions->Payment_ID->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Payment_ID" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Payment_ID" class="btw1_Payment_ID" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Payment_ID" name="y_Payment_ID" id="y_Payment_ID" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Payment_ID->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Payment_ID->EditValue2 ?>"<?php echo $a_payment_transactions->Payment_ID->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Ref_ID->Visible) { // Ref_ID ?>
	<div id="r_Ref_ID" class="form-group">
		<label for="x_Ref_ID" class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Ref_ID"><?php echo $a_payment_transactions->Ref_ID->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Ref_ID->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Ref_ID" id="z_Ref_ID" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Ref_ID->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Ref_ID">
<input type="text" data-table="a_payment_transactions" data-field="x_Ref_ID" name="x_Ref_ID" id="x_Ref_ID" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Ref_ID->EditValue ?>"<?php echo $a_payment_transactions->Ref_ID->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Ref_ID" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Ref_ID" class="btw1_Ref_ID" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Ref_ID" name="y_Ref_ID" id="y_Ref_ID" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Ref_ID->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Ref_ID->EditValue2 ?>"<?php echo $a_payment_transactions->Ref_ID->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Type->Visible) { // Type ?>
	<div id="r_Type" class="form-group">
		<label class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Type"><?php echo $a_payment_transactions->Type->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Type->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Type" id="z_Type" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Type->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Type">
<div id="tp_x_Type" class="ewTemplate"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Type->DisplayValueSeparator) ? json_encode($a_payment_transactions->Type->DisplayValueSeparator) : $a_payment_transactions->Type->DisplayValueSeparator) ?>" name="x_Type" id="x_Type" value="{value}"<?php echo $a_payment_transactions->Type->EditAttributes() ?>></div>
<div id="dsl_x_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $a_payment_transactions->Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_payment_transactions->Type->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
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
			<span class="ewSearchCond btw1_Type" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Type" class="btw1_Type" style="display: none">
<div id="tp_y_Type" class="ewTemplate"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Type->DisplayValueSeparator) ? json_encode($a_payment_transactions->Type->DisplayValueSeparator) : $a_payment_transactions->Type->DisplayValueSeparator) ?>" name="y_Type" id="y_Type" value="{value}"<?php echo $a_payment_transactions->Type->EditAttributes() ?>></div>
<div id="dsl_y_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $a_payment_transactions->Type->EditValue2;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_payment_transactions->Type->AdvancedSearch->SearchValue2) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="y_Type" id="y_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($a_payment_transactions->Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="a_payment_transactions" data-field="x_Type" name="y_Type" id="y_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($a_payment_transactions->Type->CurrentValue) ?>" checked<?php echo $a_payment_transactions->Type->EditAttributes() ?>><?php echo $a_payment_transactions->Type->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Customer->Visible) { // Customer ?>
	<div id="r_Customer" class="form-group">
		<label for="x_Customer" class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Customer"><?php echo $a_payment_transactions->Customer->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Customer->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Customer" id="z_Customer" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Customer->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Customer">
<select data-table="a_payment_transactions" data-field="x_Customer" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Customer->DisplayValueSeparator) ? json_encode($a_payment_transactions->Customer->DisplayValueSeparator) : $a_payment_transactions->Customer->DisplayValueSeparator) ?>" id="x_Customer" name="x_Customer"<?php echo $a_payment_transactions->Customer->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Customer->EditValue)) {
	$arwrk = $a_payment_transactions->Customer->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Customer->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
			<span class="ewSearchCond btw1_Customer" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Customer" class="btw1_Customer" style="display: none">
<select data-table="a_payment_transactions" data-field="x_Customer" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Customer->DisplayValueSeparator) ? json_encode($a_payment_transactions->Customer->DisplayValueSeparator) : $a_payment_transactions->Customer->DisplayValueSeparator) ?>" id="y_Customer" name="y_Customer"<?php echo $a_payment_transactions->Customer->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Customer->EditValue2)) {
	$arwrk = $a_payment_transactions->Customer->EditValue2;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Customer->AdvancedSearch->SearchValue2, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
<input type="hidden" name="s_y_Customer" id="s_y_Customer" value="<?php echo $a_payment_transactions->Customer->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Supplier->Visible) { // Supplier ?>
	<div id="r_Supplier" class="form-group">
		<label for="x_Supplier" class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Supplier"><?php echo $a_payment_transactions->Supplier->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Supplier->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Supplier" id="z_Supplier" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Supplier->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Supplier">
<select data-table="a_payment_transactions" data-field="x_Supplier" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Supplier->DisplayValueSeparator) ? json_encode($a_payment_transactions->Supplier->DisplayValueSeparator) : $a_payment_transactions->Supplier->DisplayValueSeparator) ?>" id="x_Supplier" name="x_Supplier"<?php echo $a_payment_transactions->Supplier->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Supplier->EditValue)) {
	$arwrk = $a_payment_transactions->Supplier->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Supplier->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
			<span class="ewSearchCond btw1_Supplier" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Supplier" class="btw1_Supplier" style="display: none">
<select data-table="a_payment_transactions" data-field="x_Supplier" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_payment_transactions->Supplier->DisplayValueSeparator) ? json_encode($a_payment_transactions->Supplier->DisplayValueSeparator) : $a_payment_transactions->Supplier->DisplayValueSeparator) ?>" id="y_Supplier" name="y_Supplier"<?php echo $a_payment_transactions->Supplier->EditAttributes() ?>>
<?php
if (is_array($a_payment_transactions->Supplier->EditValue2)) {
	$arwrk = $a_payment_transactions->Supplier->EditValue2;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_payment_transactions->Supplier->AdvancedSearch->SearchValue2, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
<input type="hidden" name="s_y_Supplier" id="s_y_Supplier" value="<?php echo $a_payment_transactions->Supplier->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Sub_Total->Visible) { // Sub_Total ?>
	<div id="r_Sub_Total" class="form-group">
		<label for="x_Sub_Total" class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Sub_Total"><?php echo $a_payment_transactions->Sub_Total->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Sub_Total->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Sub_Total" id="z_Sub_Total" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Sub_Total->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Sub_Total->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Sub_Total->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Sub_Total->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Sub_Total->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Sub_Total->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Sub_Total->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Sub_Total">
<input type="text" data-table="a_payment_transactions" data-field="x_Sub_Total" name="x_Sub_Total" id="x_Sub_Total" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Sub_Total->EditValue ?>"<?php echo $a_payment_transactions->Sub_Total->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Sub_Total->ReadOnly && !$a_payment_transactions->Sub_Total->Disabled && @$a_payment_transactions->Sub_Total->EditAttrs["readonly"] == "" && @$a_payment_transactions->Sub_Total->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Sub_Total').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Sub_Total" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Sub_Total" class="btw1_Sub_Total" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Sub_Total" name="y_Sub_Total" id="y_Sub_Total" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Sub_Total->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Sub_Total->EditValue2 ?>"<?php echo $a_payment_transactions->Sub_Total->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Sub_Total->ReadOnly && !$a_payment_transactions->Sub_Total->Disabled && @$a_payment_transactions->Sub_Total->EditAttrs["readonly"] == "" && @$a_payment_transactions->Sub_Total->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Sub_Total').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Payment->Visible) { // Payment ?>
	<div id="r_Payment" class="form-group">
		<label for="x_Payment" class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Payment"><?php echo $a_payment_transactions->Payment->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Payment->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Payment" id="z_Payment" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Payment->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Payment->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Payment->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Payment->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Payment->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Payment->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Payment->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Payment">
<input type="text" data-table="a_payment_transactions" data-field="x_Payment" name="x_Payment" id="x_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Payment->EditValue ?>"<?php echo $a_payment_transactions->Payment->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Payment->ReadOnly && !$a_payment_transactions->Payment->Disabled && @$a_payment_transactions->Payment->EditAttrs["readonly"] == "" && @$a_payment_transactions->Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Payment" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Payment" class="btw1_Payment" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Payment" name="y_Payment" id="y_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Payment->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Payment->EditValue2 ?>"<?php echo $a_payment_transactions->Payment->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Payment->ReadOnly && !$a_payment_transactions->Payment->Disabled && @$a_payment_transactions->Payment->EditAttrs["readonly"] == "" && @$a_payment_transactions->Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Balance->Visible) { // Balance ?>
	<div id="r_Balance" class="form-group">
		<label for="x_Balance" class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Balance"><?php echo $a_payment_transactions->Balance->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Balance->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Balance" id="z_Balance" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Balance->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Balance->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Balance->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Balance->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Balance->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Balance->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Balance->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Balance">
<input type="text" data-table="a_payment_transactions" data-field="x_Balance" name="x_Balance" id="x_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Balance->EditValue ?>"<?php echo $a_payment_transactions->Balance->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Balance->ReadOnly && !$a_payment_transactions->Balance->Disabled && @$a_payment_transactions->Balance->EditAttrs["readonly"] == "" && @$a_payment_transactions->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Balance" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Balance" class="btw1_Balance" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Balance" name="y_Balance" id="y_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Balance->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Balance->EditValue2 ?>"<?php echo $a_payment_transactions->Balance->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Balance->ReadOnly && !$a_payment_transactions->Balance->Disabled && @$a_payment_transactions->Balance->EditAttrs["readonly"] == "" && @$a_payment_transactions->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Due_Date->Visible) { // Due_Date ?>
	<div id="r_Due_Date" class="form-group">
		<label for="x_Due_Date" class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Due_Date"><?php echo $a_payment_transactions->Due_Date->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Due_Date->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Due_Date" id="z_Due_Date" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Due_Date->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Due_Date->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Due_Date->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Due_Date->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Due_Date->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Due_Date->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Due_Date->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Due_Date->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Due_Date->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Due_Date">
<input type="text" data-table="a_payment_transactions" data-field="x_Due_Date" data-format="5" name="x_Due_Date" id="x_Due_Date" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Due_Date->EditValue ?>"<?php echo $a_payment_transactions->Due_Date->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Due_Date->ReadOnly && !$a_payment_transactions->Due_Date->Disabled && !isset($a_payment_transactions->Due_Date->EditAttrs["readonly"]) && !isset($a_payment_transactions->Due_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionssearch", "x_Due_Date", "%Y/%m/%d");
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Due_Date" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Due_Date" class="btw1_Due_Date" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Due_Date" data-format="5" name="y_Due_Date" id="y_Due_Date" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Due_Date->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Due_Date->EditValue2 ?>"<?php echo $a_payment_transactions->Due_Date->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Due_Date->ReadOnly && !$a_payment_transactions->Due_Date->Disabled && !isset($a_payment_transactions->Due_Date->EditAttrs["readonly"]) && !isset($a_payment_transactions->Due_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionssearch", "y_Due_Date", "%Y/%m/%d");
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Date_Transaction->Visible) { // Date_Transaction ?>
	<div id="r_Date_Transaction" class="form-group">
		<label for="x_Date_Transaction" class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Date_Transaction"><?php echo $a_payment_transactions->Date_Transaction->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Date_Transaction->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Date_Transaction" id="z_Date_Transaction" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Date_Transaction->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Date_Transaction->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Date_Transaction->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Date_Transaction->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Date_Transaction->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Date_Transaction->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Date_Transaction->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Date_Transaction->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Date_Transaction->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Date_Transaction">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Transaction" data-format="5" name="x_Date_Transaction" id="x_Date_Transaction" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Transaction->EditValue ?>"<?php echo $a_payment_transactions->Date_Transaction->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Date_Transaction->ReadOnly && !$a_payment_transactions->Date_Transaction->Disabled && !isset($a_payment_transactions->Date_Transaction->EditAttrs["readonly"]) && !isset($a_payment_transactions->Date_Transaction->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionssearch", "x_Date_Transaction", "%Y/%m/%d");
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Date_Transaction" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Date_Transaction" class="btw1_Date_Transaction" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Transaction" data-format="5" name="y_Date_Transaction" id="y_Date_Transaction" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Transaction->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Transaction->EditValue2 ?>"<?php echo $a_payment_transactions->Date_Transaction->EditAttributes() ?>>
<?php if (!$a_payment_transactions->Date_Transaction->ReadOnly && !$a_payment_transactions->Date_Transaction->Disabled && !isset($a_payment_transactions->Date_Transaction->EditAttrs["readonly"]) && !isset($a_payment_transactions->Date_Transaction->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_payment_transactionssearch", "y_Date_Transaction", "%Y/%m/%d");
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Date_Added->Visible) { // Date_Added ?>
	<div id="r_Date_Added" class="form-group">
		<label class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Date_Added"><?php echo $a_payment_transactions->Date_Added->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Date_Added->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Date_Added" id="z_Date_Added" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Date_Added->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Date_Added->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Date_Added->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Date_Added->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Date_Added->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Date_Added->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Date_Added->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Date_Added->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Date_Added->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Date_Added">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Added" name="x_Date_Added" id="x_Date_Added" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Added->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Added->EditValue ?>"<?php echo $a_payment_transactions->Date_Added->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Date_Added" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Date_Added" class="btw1_Date_Added" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Added" name="y_Date_Added" id="y_Date_Added" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Added->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Added->EditValue2 ?>"<?php echo $a_payment_transactions->Date_Added->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Added_By->Visible) { // Added_By ?>
	<div id="r_Added_By" class="form-group">
		<label class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Added_By"><?php echo $a_payment_transactions->Added_By->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Added_By->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Added_By" id="z_Added_By" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Added_By->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Added_By">
<input type="text" data-table="a_payment_transactions" data-field="x_Added_By" name="x_Added_By" id="x_Added_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Added_By->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Added_By->EditValue ?>"<?php echo $a_payment_transactions->Added_By->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Added_By" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Added_By" class="btw1_Added_By" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Added_By" name="y_Added_By" id="y_Added_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Added_By->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Added_By->EditValue2 ?>"<?php echo $a_payment_transactions->Added_By->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Date_Updated->Visible) { // Date_Updated ?>
	<div id="r_Date_Updated" class="form-group">
		<label class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Date_Updated"><?php echo $a_payment_transactions->Date_Updated->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Date_Updated->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Date_Updated" id="z_Date_Updated" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Date_Updated->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Date_Updated->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Date_Updated->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Date_Updated->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Date_Updated->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Date_Updated->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Date_Updated->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Date_Updated->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Date_Updated->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Date_Updated">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Updated" name="x_Date_Updated" id="x_Date_Updated" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Updated->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Updated->EditValue ?>"<?php echo $a_payment_transactions->Date_Updated->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Date_Updated" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Date_Updated" class="btw1_Date_Updated" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Date_Updated" name="y_Date_Updated" id="y_Date_Updated" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Date_Updated->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Date_Updated->EditValue2 ?>"<?php echo $a_payment_transactions->Date_Updated->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_payment_transactions->Updated_By->Visible) { // Updated_By ?>
	<div id="r_Updated_By" class="form-group">
		<label class="<?php echo $a_payment_transactions_search->SearchLabelClass ?>"><span id="elh_a_payment_transactions_Updated_By"><?php echo $a_payment_transactions->Updated_By->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_payment_transactions_search->SearchRightColumnClass ?>"><div<?php echo $a_payment_transactions->Updated_By->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Updated_By" id="z_Updated_By" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_payment_transactions->Updated_By->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_payment_transactions_Updated_By">
<input type="text" data-table="a_payment_transactions" data-field="x_Updated_By" name="x_Updated_By" id="x_Updated_By" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Updated_By->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Updated_By->EditValue ?>"<?php echo $a_payment_transactions->Updated_By->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Updated_By" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_payment_transactions_Updated_By" class="btw1_Updated_By" style="display: none">
<input type="text" data-table="a_payment_transactions" data-field="x_Updated_By" name="y_Updated_By" id="y_Updated_By" placeholder="<?php echo ew_HtmlEncode($a_payment_transactions->Updated_By->getPlaceHolder()) ?>" value="<?php echo $a_payment_transactions->Updated_By->EditValue2 ?>"<?php echo $a_payment_transactions->Updated_By->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$a_payment_transactions_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fa_payment_transactionssearch.Init();
</script>
<?php
$a_payment_transactions_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_payment_transactionssearch:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_payment_transactions_search->Page_Terminate();
?>
