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
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$a_sales_search = NULL; // Initialize page object first

class ca_sales_search extends ca_sales {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_sales';

	// Page object name
	var $PageObjName = 'a_sales_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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
		if (!$Security->CanSearch()) {
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
		$this->Sales_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
						$sSrchStr = "a_saleslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->Sales_ID); // Sales_ID
		$this->BuildSearchUrl($sSrchUrl, $this->Sales_Number); // Sales_Number
		$this->BuildSearchUrl($sSrchUrl, $this->Sales_Date); // Sales_Date
		$this->BuildSearchUrl($sSrchUrl, $this->Customer_ID); // Customer_ID
		$this->BuildSearchUrl($sSrchUrl, $this->Notes); // Notes
		$this->BuildSearchUrl($sSrchUrl, $this->Total_Amount); // Total_Amount
		$this->BuildSearchUrl($sSrchUrl, $this->Discount_Type); // Discount_Type
		$this->BuildSearchUrl($sSrchUrl, $this->Discount_Percentage); // Discount_Percentage
		$this->BuildSearchUrl($sSrchUrl, $this->Discount_Amount); // Discount_Amount
		$this->BuildSearchUrl($sSrchUrl, $this->Tax_Percentage); // Tax_Percentage
		$this->BuildSearchUrl($sSrchUrl, $this->Tax_Amount); // Tax_Amount
		$this->BuildSearchUrl($sSrchUrl, $this->Tax_Description); // Tax_Description
		$this->BuildSearchUrl($sSrchUrl, $this->Final_Total_Amount); // Final_Total_Amount
		$this->BuildSearchUrl($sSrchUrl, $this->Total_Payment); // Total_Payment
		$this->BuildSearchUrl($sSrchUrl, $this->Total_Balance); // Total_Balance
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
		// Sales_ID

		$this->Sales_ID->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Sales_ID"));
		$this->Sales_ID->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Sales_ID");
		$this->Sales_ID->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Sales_ID");
		$this->Sales_ID->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Sales_ID"));
		$this->Sales_ID->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Sales_ID");

		// Sales_Number
		$this->Sales_Number->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Sales_Number"));
		$this->Sales_Number->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Sales_Number");
		$this->Sales_Number->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Sales_Number");
		$this->Sales_Number->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Sales_Number"));
		$this->Sales_Number->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Sales_Number");

		// Sales_Date
		$this->Sales_Date->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Sales_Date"));
		$this->Sales_Date->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Sales_Date");
		$this->Sales_Date->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Sales_Date");
		$this->Sales_Date->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Sales_Date"));
		$this->Sales_Date->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Sales_Date");

		// Customer_ID
		$this->Customer_ID->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Customer_ID"));
		$this->Customer_ID->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Customer_ID");
		$this->Customer_ID->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Customer_ID");
		$this->Customer_ID->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Customer_ID"));
		$this->Customer_ID->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Customer_ID");

		// Notes
		$this->Notes->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Notes"));
		$this->Notes->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Notes");
		$this->Notes->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Notes");
		$this->Notes->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Notes"));
		$this->Notes->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Notes");

		// Total_Amount
		$this->Total_Amount->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Total_Amount"));
		$this->Total_Amount->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Total_Amount");
		$this->Total_Amount->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Total_Amount");
		$this->Total_Amount->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Total_Amount"));
		$this->Total_Amount->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Total_Amount");

		// Discount_Type
		$this->Discount_Type->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Discount_Type"));
		$this->Discount_Type->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Discount_Type");
		$this->Discount_Type->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Discount_Type");
		$this->Discount_Type->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Discount_Type"));
		$this->Discount_Type->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Discount_Type");

		// Discount_Percentage
		$this->Discount_Percentage->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Discount_Percentage"));
		$this->Discount_Percentage->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Discount_Percentage");
		$this->Discount_Percentage->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Discount_Percentage");
		$this->Discount_Percentage->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Discount_Percentage"));
		$this->Discount_Percentage->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Discount_Percentage");

		// Discount_Amount
		$this->Discount_Amount->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Discount_Amount"));
		$this->Discount_Amount->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Discount_Amount");
		$this->Discount_Amount->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Discount_Amount");
		$this->Discount_Amount->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Discount_Amount"));
		$this->Discount_Amount->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Discount_Amount");

		// Tax_Percentage
		$this->Tax_Percentage->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tax_Percentage"));
		$this->Tax_Percentage->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tax_Percentage");
		$this->Tax_Percentage->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Tax_Percentage");
		$this->Tax_Percentage->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Tax_Percentage"));
		$this->Tax_Percentage->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Tax_Percentage");

		// Tax_Amount
		$this->Tax_Amount->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tax_Amount"));
		$this->Tax_Amount->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tax_Amount");

		// Tax_Description
		$this->Tax_Description->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Tax_Description"));
		$this->Tax_Description->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Tax_Description");
		$this->Tax_Description->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Tax_Description");
		$this->Tax_Description->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Tax_Description"));
		$this->Tax_Description->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Tax_Description");

		// Final_Total_Amount
		$this->Final_Total_Amount->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Final_Total_Amount"));
		$this->Final_Total_Amount->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Final_Total_Amount");
		$this->Final_Total_Amount->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Final_Total_Amount");
		$this->Final_Total_Amount->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Final_Total_Amount"));
		$this->Final_Total_Amount->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Final_Total_Amount");

		// Total_Payment
		$this->Total_Payment->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Total_Payment"));
		$this->Total_Payment->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Total_Payment");
		$this->Total_Payment->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Total_Payment");
		$this->Total_Payment->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Total_Payment"));
		$this->Total_Payment->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Total_Payment");

		// Total_Balance
		$this->Total_Balance->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Total_Balance"));
		$this->Total_Balance->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Total_Balance");
		$this->Total_Balance->AdvancedSearch->SearchCondition = $objForm->GetValue("v_Total_Balance");
		$this->Total_Balance->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_Total_Balance"));
		$this->Total_Balance->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_Total_Balance");

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

		// Sales_ID
		$this->Sales_ID->ViewValue = $this->Sales_ID->CurrentValue;
		$this->Sales_ID->ViewCustomAttributes = "";

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

			// Sales_ID
			$this->Sales_ID->LinkCustomAttributes = "";
			$this->Sales_ID->HrefValue = "";
			$this->Sales_ID->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Sales_ID
			$this->Sales_ID->EditAttrs["class"] = "form-control";
			$this->Sales_ID->EditCustomAttributes = "";
			$this->Sales_ID->EditValue = ew_HtmlEncode($this->Sales_ID->AdvancedSearch->SearchValue);
			$this->Sales_ID->PlaceHolder = ew_RemoveHtml($this->Sales_ID->FldCaption());
			$this->Sales_ID->EditAttrs["class"] = "form-control";
			$this->Sales_ID->EditCustomAttributes = "";
			$this->Sales_ID->EditValue2 = ew_HtmlEncode($this->Sales_ID->AdvancedSearch->SearchValue2);
			$this->Sales_ID->PlaceHolder = ew_RemoveHtml($this->Sales_ID->FldCaption());

			// Sales_Number
			$this->Sales_Number->EditAttrs["class"] = "form-control";
			$this->Sales_Number->EditCustomAttributes = "";
			$this->Sales_Number->EditValue = ew_HtmlEncode($this->Sales_Number->AdvancedSearch->SearchValue);
			$this->Sales_Number->PlaceHolder = ew_RemoveHtml($this->Sales_Number->FldCaption());
			$this->Sales_Number->EditAttrs["class"] = "form-control";
			$this->Sales_Number->EditCustomAttributes = "";
			$this->Sales_Number->EditValue2 = ew_HtmlEncode($this->Sales_Number->AdvancedSearch->SearchValue2);
			$this->Sales_Number->PlaceHolder = ew_RemoveHtml($this->Sales_Number->FldCaption());

			// Sales_Date
			$this->Sales_Date->EditAttrs["class"] = "form-control";
			$this->Sales_Date->EditCustomAttributes = "";
			$this->Sales_Date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Sales_Date->AdvancedSearch->SearchValue, 9), 9));
			$this->Sales_Date->PlaceHolder = ew_RemoveHtml($this->Sales_Date->FldCaption());
			$this->Sales_Date->EditAttrs["class"] = "form-control";
			$this->Sales_Date->EditCustomAttributes = "";
			$this->Sales_Date->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Sales_Date->AdvancedSearch->SearchValue2, 9), 9));
			$this->Sales_Date->PlaceHolder = ew_RemoveHtml($this->Sales_Date->FldCaption());

			// Customer_ID
			$this->Customer_ID->EditAttrs["class"] = "form-control";
			$this->Customer_ID->EditCustomAttributes = "";
			if (trim(strval($this->Customer_ID->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer_ID->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
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
			$this->Customer_ID->EditAttrs["class"] = "form-control";
			$this->Customer_ID->EditCustomAttributes = "";
			if (trim(strval($this->Customer_ID->AdvancedSearch->SearchValue2)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Customer_Number`" . ew_SearchString("=", $this->Customer_ID->AdvancedSearch->SearchValue2, EW_DATATYPE_STRING, "");
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
			$this->Customer_ID->EditValue2 = $arwrk;

			// Notes
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue = ew_HtmlEncode($this->Notes->AdvancedSearch->SearchValue);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue2 = ew_HtmlEncode($this->Notes->AdvancedSearch->SearchValue2);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

			// Total_Amount
			$this->Total_Amount->EditAttrs["class"] = "form-control";
			$this->Total_Amount->EditCustomAttributes = "";
			$this->Total_Amount->EditValue = ew_HtmlEncode($this->Total_Amount->AdvancedSearch->SearchValue);
			$this->Total_Amount->PlaceHolder = ew_RemoveHtml($this->Total_Amount->FldCaption());
			$this->Total_Amount->EditAttrs["class"] = "form-control";
			$this->Total_Amount->EditCustomAttributes = "";
			$this->Total_Amount->EditValue2 = ew_HtmlEncode($this->Total_Amount->AdvancedSearch->SearchValue2);
			$this->Total_Amount->PlaceHolder = ew_RemoveHtml($this->Total_Amount->FldCaption());

			// Discount_Type
			$this->Discount_Type->EditCustomAttributes = "";
			$this->Discount_Type->EditValue = $this->Discount_Type->Options(FALSE);
			$this->Discount_Type->EditCustomAttributes = "";
			$this->Discount_Type->EditValue2 = $this->Discount_Type->Options(FALSE);

			// Discount_Percentage
			$this->Discount_Percentage->EditAttrs["class"] = "form-control";
			$this->Discount_Percentage->EditCustomAttributes = "";
			$this->Discount_Percentage->EditValue = ew_HtmlEncode($this->Discount_Percentage->AdvancedSearch->SearchValue);
			$this->Discount_Percentage->PlaceHolder = ew_RemoveHtml($this->Discount_Percentage->FldCaption());
			$this->Discount_Percentage->EditAttrs["class"] = "form-control";
			$this->Discount_Percentage->EditCustomAttributes = "";
			$this->Discount_Percentage->EditValue2 = ew_HtmlEncode($this->Discount_Percentage->AdvancedSearch->SearchValue2);
			$this->Discount_Percentage->PlaceHolder = ew_RemoveHtml($this->Discount_Percentage->FldCaption());

			// Discount_Amount
			$this->Discount_Amount->EditAttrs["class"] = "form-control";
			$this->Discount_Amount->EditCustomAttributes = "";
			$this->Discount_Amount->EditValue = ew_HtmlEncode($this->Discount_Amount->AdvancedSearch->SearchValue);
			$this->Discount_Amount->PlaceHolder = ew_RemoveHtml($this->Discount_Amount->FldCaption());
			$this->Discount_Amount->EditAttrs["class"] = "form-control";
			$this->Discount_Amount->EditCustomAttributes = "";
			$this->Discount_Amount->EditValue2 = ew_HtmlEncode($this->Discount_Amount->AdvancedSearch->SearchValue2);
			$this->Discount_Amount->PlaceHolder = ew_RemoveHtml($this->Discount_Amount->FldCaption());

			// Tax_Percentage
			$this->Tax_Percentage->EditAttrs["class"] = "form-control";
			$this->Tax_Percentage->EditCustomAttributes = "";
			$this->Tax_Percentage->EditValue = ew_HtmlEncode($this->Tax_Percentage->AdvancedSearch->SearchValue);
			$this->Tax_Percentage->PlaceHolder = ew_RemoveHtml($this->Tax_Percentage->FldCaption());
			$this->Tax_Percentage->EditAttrs["class"] = "form-control";
			$this->Tax_Percentage->EditCustomAttributes = "";
			$this->Tax_Percentage->EditValue2 = ew_HtmlEncode($this->Tax_Percentage->AdvancedSearch->SearchValue2);
			$this->Tax_Percentage->PlaceHolder = ew_RemoveHtml($this->Tax_Percentage->FldCaption());

			// Tax_Amount
			$this->Tax_Amount->EditAttrs["class"] = "form-control";
			$this->Tax_Amount->EditCustomAttributes = "";
			$this->Tax_Amount->EditValue = ew_HtmlEncode($this->Tax_Amount->AdvancedSearch->SearchValue);
			$this->Tax_Amount->PlaceHolder = ew_RemoveHtml($this->Tax_Amount->FldCaption());

			// Tax_Description
			$this->Tax_Description->EditAttrs["class"] = "form-control";
			$this->Tax_Description->EditCustomAttributes = "";
			$this->Tax_Description->EditValue = ew_HtmlEncode($this->Tax_Description->AdvancedSearch->SearchValue);
			$this->Tax_Description->PlaceHolder = ew_RemoveHtml($this->Tax_Description->FldCaption());
			$this->Tax_Description->EditAttrs["class"] = "form-control";
			$this->Tax_Description->EditCustomAttributes = "";
			$this->Tax_Description->EditValue2 = ew_HtmlEncode($this->Tax_Description->AdvancedSearch->SearchValue2);
			$this->Tax_Description->PlaceHolder = ew_RemoveHtml($this->Tax_Description->FldCaption());

			// Final_Total_Amount
			$this->Final_Total_Amount->EditAttrs["class"] = "form-control";
			$this->Final_Total_Amount->EditCustomAttributes = "";
			$this->Final_Total_Amount->EditValue = ew_HtmlEncode($this->Final_Total_Amount->AdvancedSearch->SearchValue);
			$this->Final_Total_Amount->PlaceHolder = ew_RemoveHtml($this->Final_Total_Amount->FldCaption());
			$this->Final_Total_Amount->EditAttrs["class"] = "form-control";
			$this->Final_Total_Amount->EditCustomAttributes = "";
			$this->Final_Total_Amount->EditValue2 = ew_HtmlEncode($this->Final_Total_Amount->AdvancedSearch->SearchValue2);
			$this->Final_Total_Amount->PlaceHolder = ew_RemoveHtml($this->Final_Total_Amount->FldCaption());

			// Total_Payment
			$this->Total_Payment->EditAttrs["class"] = "form-control";
			$this->Total_Payment->EditCustomAttributes = "";
			$this->Total_Payment->EditValue = ew_HtmlEncode($this->Total_Payment->AdvancedSearch->SearchValue);
			$this->Total_Payment->PlaceHolder = ew_RemoveHtml($this->Total_Payment->FldCaption());
			$this->Total_Payment->EditAttrs["class"] = "form-control";
			$this->Total_Payment->EditCustomAttributes = "";
			$this->Total_Payment->EditValue2 = ew_HtmlEncode($this->Total_Payment->AdvancedSearch->SearchValue2);
			$this->Total_Payment->PlaceHolder = ew_RemoveHtml($this->Total_Payment->FldCaption());

			// Total_Balance
			$this->Total_Balance->EditAttrs["class"] = "form-control";
			$this->Total_Balance->EditCustomAttributes = "";
			$this->Total_Balance->EditValue = ew_HtmlEncode($this->Total_Balance->AdvancedSearch->SearchValue);
			$this->Total_Balance->PlaceHolder = ew_RemoveHtml($this->Total_Balance->FldCaption());
			$this->Total_Balance->EditAttrs["class"] = "form-control";
			$this->Total_Balance->EditCustomAttributes = "";
			$this->Total_Balance->EditValue2 = ew_HtmlEncode($this->Total_Balance->AdvancedSearch->SearchValue2);
			$this->Total_Balance->PlaceHolder = ew_RemoveHtml($this->Total_Balance->FldCaption());

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
		if (!ew_CheckInteger($this->Sales_ID->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Sales_ID->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Sales_ID->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Sales_ID->FldErrMsg());
		}
		if (!ew_CheckDate($this->Sales_Date->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Sales_Date->FldErrMsg());
		}
		if (!ew_CheckDate($this->Sales_Date->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Sales_Date->FldErrMsg());
		}
		if (!ew_CheckRange($this->Discount_Percentage->AdvancedSearch->SearchValue, 0, 100)) {
			ew_AddMessage($gsSearchError, $this->Discount_Percentage->FldErrMsg());
		}
		if (!ew_CheckRange($this->Discount_Percentage->AdvancedSearch->SearchValue2, 0, 100)) {
			ew_AddMessage($gsSearchError, $this->Discount_Percentage->FldErrMsg());
		}
		if (!ew_CheckRange($this->Tax_Percentage->AdvancedSearch->SearchValue, 0, 100)) {
			ew_AddMessage($gsSearchError, $this->Tax_Percentage->FldErrMsg());
		}
		if (!ew_CheckRange($this->Tax_Percentage->AdvancedSearch->SearchValue2, 0, 100)) {
			ew_AddMessage($gsSearchError, $this->Tax_Percentage->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Tax_Amount->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Tax_Amount->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Final_Total_Amount->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Final_Total_Amount->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Final_Total_Amount->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Final_Total_Amount->FldErrMsg());
		}
		if (!ew_CheckRange($this->Total_Payment->AdvancedSearch->SearchValue, 1, 999999999)) {
			ew_AddMessage($gsSearchError, $this->Total_Payment->FldErrMsg());
		}
		if (!ew_CheckRange($this->Total_Payment->AdvancedSearch->SearchValue2, 1, 999999999)) {
			ew_AddMessage($gsSearchError, $this->Total_Payment->FldErrMsg());
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
		$this->Sales_ID->AdvancedSearch->Load();
		$this->Sales_Number->AdvancedSearch->Load();
		$this->Sales_Date->AdvancedSearch->Load();
		$this->Customer_ID->AdvancedSearch->Load();
		$this->Notes->AdvancedSearch->Load();
		$this->Total_Amount->AdvancedSearch->Load();
		$this->Discount_Type->AdvancedSearch->Load();
		$this->Discount_Percentage->AdvancedSearch->Load();
		$this->Discount_Amount->AdvancedSearch->Load();
		$this->Tax_Percentage->AdvancedSearch->Load();
		$this->Tax_Amount->AdvancedSearch->Load();
		$this->Tax_Description->AdvancedSearch->Load();
		$this->Final_Total_Amount->AdvancedSearch->Load();
		$this->Total_Payment->AdvancedSearch->Load();
		$this->Total_Balance->AdvancedSearch->Load();
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("a_saleslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($a_sales_search)) $a_sales_search = new ca_sales_search();

// Page init
$a_sales_search->Page_Init();

// Page main
$a_sales_search->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_sales_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($a_sales_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fa_salessearch = new ew_Form("fa_salessearch", "search");
<?php } else { ?>
var CurrentForm = fa_salessearch = new ew_Form("fa_salessearch", "search");
<?php } ?>

// Form_CustomValidate event
fa_salessearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_salessearch.ValidateRequired = true;
<?php } else { ?>
fa_salessearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fa_salessearch.Lists["x_Customer_ID"] = {"LinkField":"x_Customer_Number","Ajax":true,"AutoFill":false,"DisplayFields":["x_Customer_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_salessearch.Lists["x_Discount_Type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fa_salessearch.Lists["x_Discount_Type"].Options = <?php echo json_encode($a_sales->Discount_Type->Options()) ?>;

// Form object for search
// Validate function for search

fa_salessearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_Sales_ID");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Sales_ID->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Sales_Date");
	if (elm && !ew_CheckDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Sales_Date->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Discount_Percentage");
	if (elm && !ew_CheckRange(elm.value, 0, 100))
		return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Discount_Percentage->FldErrMsg()) ?>");
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
	if (elm && !ew_CheckRange(elm.value, 1, 999999999))
		return this.OnError(elm, "<?php echo ew_JsEncode2($a_sales->Total_Payment->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$a_sales_search->IsModal) { ?>
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
<?php $a_sales_search->ShowPageHeader(); ?>
<?php
$a_sales_search->ShowMessage();
?>
<form name="fa_salessearch" id="fa_salessearch" class="<?php echo $a_sales_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_sales_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_sales_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_sales">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($a_sales_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($a_sales->Sales_ID->Visible) { // Sales_ID ?>
	<div id="r_Sales_ID" class="form-group">
		<label for="x_Sales_ID" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Sales_ID"><?php echo $a_sales->Sales_ID->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Sales_ID->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Sales_ID" id="z_Sales_ID" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Sales_ID->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Sales_ID->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Sales_ID->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Sales_ID->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Sales_ID->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Sales_ID->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Sales_ID->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Sales_ID->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Sales_ID->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Sales_ID">
<input type="text" data-table="a_sales" data-field="x_Sales_ID" name="x_Sales_ID" id="x_Sales_ID" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_ID->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_ID->EditValue ?>"<?php echo $a_sales->Sales_ID->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Sales_ID" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Sales_ID" class="btw1_Sales_ID" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Sales_ID" name="y_Sales_ID" id="y_Sales_ID" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_ID->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_ID->EditValue2 ?>"<?php echo $a_sales->Sales_ID->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Sales_Number->Visible) { // Sales_Number ?>
	<div id="r_Sales_Number" class="form-group">
		<label for="x_Sales_Number" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Sales_Number"><?php echo $a_sales->Sales_Number->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Sales_Number->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Sales_Number" id="z_Sales_Number" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_sales->Sales_Number->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Sales_Number">
<input type="text" data-table="a_sales" data-field="x_Sales_Number" name="x_Sales_Number" id="x_Sales_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Number->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Number->EditValue ?>"<?php echo $a_sales->Sales_Number->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Sales_Number" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Sales_Number" class="btw1_Sales_Number" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Sales_Number" name="y_Sales_Number" id="y_Sales_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Number->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Number->EditValue2 ?>"<?php echo $a_sales->Sales_Number->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Sales_Date->Visible) { // Sales_Date ?>
	<div id="r_Sales_Date" class="form-group">
		<label for="x_Sales_Date" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Sales_Date"><?php echo $a_sales->Sales_Date->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Sales_Date->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Sales_Date" id="z_Sales_Date" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Sales_Date->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Sales_Date->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Sales_Date->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Sales_Date->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Sales_Date->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Sales_Date->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="BETWEEN"<?php echo ($a_sales->Sales_Date->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Sales_Date">
<input type="text" data-table="a_sales" data-field="x_Sales_Date" data-format="9" name="x_Sales_Date" id="x_Sales_Date" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Date->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Date->EditValue ?>"<?php echo $a_sales->Sales_Date->EditAttributes() ?>>
<?php if (!$a_sales->Sales_Date->ReadOnly && !$a_sales->Sales_Date->Disabled && !isset($a_sales->Sales_Date->EditAttrs["readonly"]) && !isset($a_sales->Sales_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_salessearch", "x_Sales_Date", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Sales_Date" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Sales_Date" class="btw1_Sales_Date" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Sales_Date" data-format="9" name="y_Sales_Date" id="y_Sales_Date" placeholder="<?php echo ew_HtmlEncode($a_sales->Sales_Date->getPlaceHolder()) ?>" value="<?php echo $a_sales->Sales_Date->EditValue2 ?>"<?php echo $a_sales->Sales_Date->EditAttributes() ?>>
<?php if (!$a_sales->Sales_Date->ReadOnly && !$a_sales->Sales_Date->Disabled && !isset($a_sales->Sales_Date->EditAttrs["readonly"]) && !isset($a_sales->Sales_Date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fa_salessearch", "y_Sales_Date", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Customer_ID->Visible) { // Customer_ID ?>
	<div id="r_Customer_ID" class="form-group">
		<label for="x_Customer_ID" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Customer_ID"><?php echo $a_sales->Customer_ID->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Customer_ID->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Customer_ID" id="z_Customer_ID" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($a_sales->Customer_ID->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Customer_ID">
<select data-table="a_sales" data-field="x_Customer_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales->Customer_ID->DisplayValueSeparator) ? json_encode($a_sales->Customer_ID->DisplayValueSeparator) : $a_sales->Customer_ID->DisplayValueSeparator) ?>" id="x_Customer_ID" name="x_Customer_ID"<?php echo $a_sales->Customer_ID->EditAttributes() ?>>
<?php
if (is_array($a_sales->Customer_ID->EditValue)) {
	$arwrk = $a_sales->Customer_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales->Customer_ID->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
			<span class="ewSearchCond btw1_Customer_ID" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Customer_ID" class="btw1_Customer_ID" style="display: none">
<select data-table="a_sales" data-field="x_Customer_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales->Customer_ID->DisplayValueSeparator) ? json_encode($a_sales->Customer_ID->DisplayValueSeparator) : $a_sales->Customer_ID->DisplayValueSeparator) ?>" id="y_Customer_ID" name="y_Customer_ID"<?php echo $a_sales->Customer_ID->EditAttributes() ?>>
<?php
if (is_array($a_sales->Customer_ID->EditValue2)) {
	$arwrk = $a_sales->Customer_ID->EditValue2;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($a_sales->Customer_ID->AdvancedSearch->SearchValue2, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
<input type="hidden" name="s_y_Customer_ID" id="s_y_Customer_ID" value="<?php echo $a_sales->Customer_ID->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Notes->Visible) { // Notes ?>
	<div id="r_Notes" class="form-group">
		<label for="x_Notes" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Notes"><?php echo $a_sales->Notes->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Notes->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Notes" id="z_Notes" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Notes->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Notes">
<input type="text" data-table="a_sales" data-field="x_Notes" name="x_Notes" id="x_Notes" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Notes->getPlaceHolder()) ?>" value="<?php echo $a_sales->Notes->EditValue ?>"<?php echo $a_sales->Notes->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Notes" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Notes" class="btw1_Notes" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Notes" name="y_Notes" id="y_Notes" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Notes->getPlaceHolder()) ?>" value="<?php echo $a_sales->Notes->EditValue2 ?>"<?php echo $a_sales->Notes->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Total_Amount->Visible) { // Total_Amount ?>
	<div id="r_Total_Amount" class="form-group">
		<label for="x_Total_Amount" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Total_Amount"><?php echo $a_sales->Total_Amount->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Total_Amount->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Total_Amount" id="z_Total_Amount" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Total_Amount->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Total_Amount->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Total_Amount->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Total_Amount->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Total_Amount->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Total_Amount->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Total_Amount->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Total_Amount->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Total_Amount->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Total_Amount" name="x_Total_Amount" id="x_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Amount->EditValue ?>"<?php echo $a_sales->Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Total_Amount->ReadOnly && !$a_sales->Total_Amount->Disabled && @$a_sales->Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Total_Amount" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Total_Amount" class="btw1_Total_Amount" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Total_Amount" name="y_Total_Amount" id="y_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Amount->EditValue2 ?>"<?php echo $a_sales->Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Total_Amount->ReadOnly && !$a_sales->Total_Amount->Disabled && @$a_sales->Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Discount_Type->Visible) { // Discount_Type ?>
	<div id="r_Discount_Type" class="form-group">
		<label class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Discount_Type"><?php echo $a_sales->Discount_Type->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Discount_Type->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Discount_Type" id="z_Discount_Type" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Discount_Type->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Discount_Type">
<div id="tp_x_Discount_Type" class="ewTemplate"><input type="radio" data-table="a_sales" data-field="x_Discount_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales->Discount_Type->DisplayValueSeparator) ? json_encode($a_sales->Discount_Type->DisplayValueSeparator) : $a_sales->Discount_Type->DisplayValueSeparator) ?>" name="x_Discount_Type" id="x_Discount_Type" value="{value}"<?php echo $a_sales->Discount_Type->EditAttributes() ?>></div>
<div id="dsl_x_Discount_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $a_sales->Discount_Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_sales->Discount_Type->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
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
			<span class="ewSearchCond btw1_Discount_Type" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Discount_Type" class="btw1_Discount_Type" style="display: none">
<div id="tp_y_Discount_Type" class="ewTemplate"><input type="radio" data-table="a_sales" data-field="x_Discount_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($a_sales->Discount_Type->DisplayValueSeparator) ? json_encode($a_sales->Discount_Type->DisplayValueSeparator) : $a_sales->Discount_Type->DisplayValueSeparator) ?>" name="y_Discount_Type" id="y_Discount_Type" value="{value}"<?php echo $a_sales->Discount_Type->EditAttributes() ?>></div>
<div id="dsl_y_Discount_Type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $a_sales->Discount_Type->EditValue2;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_sales->Discount_Type->AdvancedSearch->SearchValue2) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="a_sales" data-field="x_Discount_Type" name="y_Discount_Type" id="y_Discount_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $a_sales->Discount_Type->EditAttributes() ?>><?php echo $a_sales->Discount_Type->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($a_sales->Discount_Type->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="a_sales" data-field="x_Discount_Type" name="y_Discount_Type" id="y_Discount_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($a_sales->Discount_Type->CurrentValue) ?>" checked<?php echo $a_sales->Discount_Type->EditAttributes() ?>><?php echo $a_sales->Discount_Type->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Discount_Percentage->Visible) { // Discount_Percentage ?>
	<div id="r_Discount_Percentage" class="form-group">
		<label for="x_Discount_Percentage" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Discount_Percentage"><?php echo $a_sales->Discount_Percentage->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Discount_Percentage->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Discount_Percentage" id="z_Discount_Percentage" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Discount_Percentage->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Discount_Percentage->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Discount_Percentage->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Discount_Percentage->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Discount_Percentage->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Discount_Percentage->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Discount_Percentage->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Discount_Percentage->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Discount_Percentage->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Discount_Percentage">
<input type="text" data-table="a_sales" data-field="x_Discount_Percentage" name="x_Discount_Percentage" id="x_Discount_Percentage" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Discount_Percentage->getPlaceHolder()) ?>" value="<?php echo $a_sales->Discount_Percentage->EditValue ?>"<?php echo $a_sales->Discount_Percentage->EditAttributes() ?>>
<?php if (!$a_sales->Discount_Percentage->ReadOnly && !$a_sales->Discount_Percentage->Disabled && @$a_sales->Discount_Percentage->EditAttrs["readonly"] == "" && @$a_sales->Discount_Percentage->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Discount_Percentage').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Discount_Percentage" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Discount_Percentage" class="btw1_Discount_Percentage" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Discount_Percentage" name="y_Discount_Percentage" id="y_Discount_Percentage" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Discount_Percentage->getPlaceHolder()) ?>" value="<?php echo $a_sales->Discount_Percentage->EditValue2 ?>"<?php echo $a_sales->Discount_Percentage->EditAttributes() ?>>
<?php if (!$a_sales->Discount_Percentage->ReadOnly && !$a_sales->Discount_Percentage->Disabled && @$a_sales->Discount_Percentage->EditAttrs["readonly"] == "" && @$a_sales->Discount_Percentage->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Discount_Percentage').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Discount_Amount->Visible) { // Discount_Amount ?>
	<div id="r_Discount_Amount" class="form-group">
		<label for="x_Discount_Amount" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Discount_Amount"><?php echo $a_sales->Discount_Amount->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Discount_Amount->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Discount_Amount" id="z_Discount_Amount" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Discount_Amount->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Discount_Amount->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Discount_Amount->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Discount_Amount->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Discount_Amount->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Discount_Amount->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Discount_Amount->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Discount_Amount->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Discount_Amount->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Discount_Amount">
<input type="text" data-table="a_sales" data-field="x_Discount_Amount" name="x_Discount_Amount" id="x_Discount_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Discount_Amount->EditValue ?>"<?php echo $a_sales->Discount_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Discount_Amount->ReadOnly && !$a_sales->Discount_Amount->Disabled && @$a_sales->Discount_Amount->EditAttrs["readonly"] == "" && @$a_sales->Discount_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Discount_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Discount_Amount" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Discount_Amount" class="btw1_Discount_Amount" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Discount_Amount" name="y_Discount_Amount" id="y_Discount_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Discount_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Discount_Amount->EditValue2 ?>"<?php echo $a_sales->Discount_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Discount_Amount->ReadOnly && !$a_sales->Discount_Amount->Disabled && @$a_sales->Discount_Amount->EditAttrs["readonly"] == "" && @$a_sales->Discount_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Discount_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Tax_Percentage->Visible) { // Tax_Percentage ?>
	<div id="r_Tax_Percentage" class="form-group">
		<label for="x_Tax_Percentage" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Tax_Percentage"><?php echo $a_sales->Tax_Percentage->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Tax_Percentage->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Tax_Percentage" id="z_Tax_Percentage" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Tax_Percentage->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Tax_Percentage->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Tax_Percentage->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Tax_Percentage->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Tax_Percentage->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Tax_Percentage->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Tax_Percentage->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Tax_Percentage->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Tax_Percentage->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Tax_Percentage">
<input type="text" data-table="a_sales" data-field="x_Tax_Percentage" name="x_Tax_Percentage" id="x_Tax_Percentage" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Percentage->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Percentage->EditValue ?>"<?php echo $a_sales->Tax_Percentage->EditAttributes() ?>>
<?php if (!$a_sales->Tax_Percentage->ReadOnly && !$a_sales->Tax_Percentage->Disabled && @$a_sales->Tax_Percentage->EditAttrs["readonly"] == "" && @$a_sales->Tax_Percentage->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Tax_Percentage').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Tax_Percentage" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Tax_Percentage" class="btw1_Tax_Percentage" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Tax_Percentage" name="y_Tax_Percentage" id="y_Tax_Percentage" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Percentage->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Percentage->EditValue2 ?>"<?php echo $a_sales->Tax_Percentage->EditAttributes() ?>>
<?php if (!$a_sales->Tax_Percentage->ReadOnly && !$a_sales->Tax_Percentage->Disabled && @$a_sales->Tax_Percentage->EditAttrs["readonly"] == "" && @$a_sales->Tax_Percentage->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Tax_Percentage').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '0', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Tax_Amount->Visible) { // Tax_Amount ?>
	<div id="r_Tax_Amount" class="form-group">
		<label for="x_Tax_Amount" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Tax_Amount"><?php echo $a_sales->Tax_Amount->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Tax_Amount" id="z_Tax_Amount" value="="></p>
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Tax_Amount->CellAttributes() ?>>
			<span id="el_a_sales_Tax_Amount">
<input type="text" data-table="a_sales" data-field="x_Tax_Amount" name="x_Tax_Amount" id="x_Tax_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Amount->EditValue ?>"<?php echo $a_sales->Tax_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Tax_Amount->ReadOnly && !$a_sales->Tax_Amount->Disabled && @$a_sales->Tax_Amount->EditAttrs["readonly"] == "" && @$a_sales->Tax_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Tax_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Tax_Description->Visible) { // Tax_Description ?>
	<div id="r_Tax_Description" class="form-group">
		<label for="x_Tax_Description" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Tax_Description"><?php echo $a_sales->Tax_Description->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Tax_Description->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Tax_Description" id="z_Tax_Description" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Tax_Description->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Tax_Description">
<input type="text" data-table="a_sales" data-field="x_Tax_Description" name="x_Tax_Description" id="x_Tax_Description" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Description->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Description->EditValue ?>"<?php echo $a_sales->Tax_Description->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Tax_Description" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Tax_Description" class="btw1_Tax_Description" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Tax_Description" name="y_Tax_Description" id="y_Tax_Description" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Tax_Description->getPlaceHolder()) ?>" value="<?php echo $a_sales->Tax_Description->EditValue2 ?>"<?php echo $a_sales->Tax_Description->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Final_Total_Amount->Visible) { // Final_Total_Amount ?>
	<div id="r_Final_Total_Amount" class="form-group">
		<label for="x_Final_Total_Amount" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Final_Total_Amount"><?php echo $a_sales->Final_Total_Amount->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Final_Total_Amount->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Final_Total_Amount" id="z_Final_Total_Amount" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Final_Total_Amount->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Final_Total_Amount->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Final_Total_Amount->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Final_Total_Amount->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Final_Total_Amount->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Final_Total_Amount->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Final_Total_Amount->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Final_Total_Amount->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Final_Total_Amount->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Final_Total_Amount">
<input type="text" data-table="a_sales" data-field="x_Final_Total_Amount" name="x_Final_Total_Amount" id="x_Final_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Final_Total_Amount->EditValue ?>"<?php echo $a_sales->Final_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Final_Total_Amount->ReadOnly && !$a_sales->Final_Total_Amount->Disabled && @$a_sales->Final_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Final_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Final_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Final_Total_Amount" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Final_Total_Amount" class="btw1_Final_Total_Amount" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Final_Total_Amount" name="y_Final_Total_Amount" id="y_Final_Total_Amount" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Final_Total_Amount->getPlaceHolder()) ?>" value="<?php echo $a_sales->Final_Total_Amount->EditValue2 ?>"<?php echo $a_sales->Final_Total_Amount->EditAttributes() ?>>
<?php if (!$a_sales->Final_Total_Amount->ReadOnly && !$a_sales->Final_Total_Amount->Disabled && @$a_sales->Final_Total_Amount->EditAttrs["readonly"] == "" && @$a_sales->Final_Total_Amount->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Final_Total_Amount').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Total_Payment->Visible) { // Total_Payment ?>
	<div id="r_Total_Payment" class="form-group">
		<label for="x_Total_Payment" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Total_Payment"><?php echo $a_sales->Total_Payment->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Total_Payment->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Total_Payment" id="z_Total_Payment" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Total_Payment->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Total_Payment->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Total_Payment->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Total_Payment->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Total_Payment->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Total_Payment->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Total_Payment->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Total_Payment->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Total_Payment->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Total_Payment">
<input type="text" data-table="a_sales" data-field="x_Total_Payment" name="x_Total_Payment" id="x_Total_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Payment->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Payment->EditValue ?>"<?php echo $a_sales->Total_Payment->EditAttributes() ?>>
<?php if (!$a_sales->Total_Payment->ReadOnly && !$a_sales->Total_Payment->Disabled && @$a_sales->Total_Payment->EditAttrs["readonly"] == "" && @$a_sales->Total_Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Total_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Total_Payment" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Total_Payment" class="btw1_Total_Payment" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Total_Payment" name="y_Total_Payment" id="y_Total_Payment" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Payment->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Payment->EditValue2 ?>"<?php echo $a_sales->Total_Payment->EditAttributes() ?>>
<?php if (!$a_sales->Total_Payment->ReadOnly && !$a_sales->Total_Payment->Disabled && @$a_sales->Total_Payment->EditAttrs["readonly"] == "" && @$a_sales->Total_Payment->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Total_Payment').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Total_Balance->Visible) { // Total_Balance ?>
	<div id="r_Total_Balance" class="form-group">
		<label for="x_Total_Balance" class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Total_Balance"><?php echo $a_sales->Total_Balance->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Total_Balance->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Total_Balance" id="z_Total_Balance" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Total_Balance->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Total_Balance->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Total_Balance->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Total_Balance->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Total_Balance->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Total_Balance->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Total_Balance->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Total_Balance->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Total_Balance->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Total_Balance">
<input type="text" data-table="a_sales" data-field="x_Total_Balance" name="x_Total_Balance" id="x_Total_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Balance->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Balance->EditValue ?>"<?php echo $a_sales->Total_Balance->EditAttributes() ?>>
<?php if (!$a_sales->Total_Balance->ReadOnly && !$a_sales->Total_Balance->Disabled && @$a_sales->Total_Balance->EditAttrs["readonly"] == "" && @$a_sales->Total_Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Total_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_Total_Balance" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Total_Balance" class="btw1_Total_Balance" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Total_Balance" name="y_Total_Balance" id="y_Total_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_sales->Total_Balance->getPlaceHolder()) ?>" value="<?php echo $a_sales->Total_Balance->EditValue2 ?>"<?php echo $a_sales->Total_Balance->EditAttributes() ?>>
<?php if (!$a_sales->Total_Balance->ReadOnly && !$a_sales->Total_Balance->Disabled && @$a_sales->Total_Balance->EditAttrs["readonly"] == "" && @$a_sales->Total_Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#y_Total_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Date_Added->Visible) { // Date_Added ?>
	<div id="r_Date_Added" class="form-group">
		<label class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Date_Added"><?php echo $a_sales->Date_Added->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Date_Added->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Date_Added" id="z_Date_Added" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Date_Added->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Date_Added->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Date_Added->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Date_Added->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Date_Added->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Date_Added->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Date_Added->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Date_Added->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Date_Added->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Date_Added">
<input type="text" data-table="a_sales" data-field="x_Date_Added" name="x_Date_Added" id="x_Date_Added" placeholder="<?php echo ew_HtmlEncode($a_sales->Date_Added->getPlaceHolder()) ?>" value="<?php echo $a_sales->Date_Added->EditValue ?>"<?php echo $a_sales->Date_Added->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Date_Added" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Date_Added" class="btw1_Date_Added" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Date_Added" name="y_Date_Added" id="y_Date_Added" placeholder="<?php echo ew_HtmlEncode($a_sales->Date_Added->getPlaceHolder()) ?>" value="<?php echo $a_sales->Date_Added->EditValue2 ?>"<?php echo $a_sales->Date_Added->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Added_By->Visible) { // Added_By ?>
	<div id="r_Added_By" class="form-group">
		<label class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Added_By"><?php echo $a_sales->Added_By->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Added_By->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Added_By" id="z_Added_By" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Added_By->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Added_By">
<input type="text" data-table="a_sales" data-field="x_Added_By" name="x_Added_By" id="x_Added_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Added_By->getPlaceHolder()) ?>" value="<?php echo $a_sales->Added_By->EditValue ?>"<?php echo $a_sales->Added_By->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Added_By" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Added_By" class="btw1_Added_By" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Added_By" name="y_Added_By" id="y_Added_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Added_By->getPlaceHolder()) ?>" value="<?php echo $a_sales->Added_By->EditValue2 ?>"<?php echo $a_sales->Added_By->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Date_Updated->Visible) { // Date_Updated ?>
	<div id="r_Date_Updated" class="form-group">
		<label class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Date_Updated"><?php echo $a_sales->Date_Updated->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Date_Updated->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Date_Updated" id="z_Date_Updated" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Date_Updated->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Date_Updated->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Date_Updated->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Date_Updated->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Date_Updated->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Date_Updated->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="IS NULL"<?php echo ($a_sales->Date_Updated->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Date_Updated->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Date_Updated->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Date_Updated">
<input type="text" data-table="a_sales" data-field="x_Date_Updated" name="x_Date_Updated" id="x_Date_Updated" placeholder="<?php echo ew_HtmlEncode($a_sales->Date_Updated->getPlaceHolder()) ?>" value="<?php echo $a_sales->Date_Updated->EditValue ?>"<?php echo $a_sales->Date_Updated->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Date_Updated" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Date_Updated" class="btw1_Date_Updated" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Date_Updated" name="y_Date_Updated" id="y_Date_Updated" placeholder="<?php echo ew_HtmlEncode($a_sales->Date_Updated->getPlaceHolder()) ?>" value="<?php echo $a_sales->Date_Updated->EditValue2 ?>"<?php echo $a_sales->Date_Updated->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($a_sales->Updated_By->Visible) { // Updated_By ?>
	<div id="r_Updated_By" class="form-group">
		<label class="<?php echo $a_sales_search->SearchLabelClass ?>"><span id="elh_a_sales_Updated_By"><?php echo $a_sales->Updated_By->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $a_sales_search->SearchRightColumnClass ?>"><div<?php echo $a_sales->Updated_By->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_Updated_By" id="z_Updated_By" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="IS NULL"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "IS NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NULL") ?></option><option value="IS NOT NULL"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "IS NOT NULL") ? " selected" : "" ?> ><?php echo $Language->Phrase("IS NOT NULL") ?></option><option value="BETWEEN"<?php echo ($a_sales->Updated_By->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_a_sales_Updated_By">
<input type="text" data-table="a_sales" data-field="x_Updated_By" name="x_Updated_By" id="x_Updated_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Updated_By->getPlaceHolder()) ?>" value="<?php echo $a_sales->Updated_By->EditValue ?>"<?php echo $a_sales->Updated_By->EditAttributes() ?>>
</span>
			<span class="ewSearchCond btw1_Updated_By" style="display: none">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_a_sales_Updated_By" class="btw1_Updated_By" style="display: none">
<input type="text" data-table="a_sales" data-field="x_Updated_By" name="y_Updated_By" id="y_Updated_By" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_sales->Updated_By->getPlaceHolder()) ?>" value="<?php echo $a_sales->Updated_By->EditValue2 ?>"<?php echo $a_sales->Updated_By->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$a_sales_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fa_salessearch.Init();
</script>
<?php
$a_sales_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_salessearch:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_sales_search->Page_Terminate();
?>
